<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Checkout Controller
 * 
 * Handles secure checkout process for equipment rental/purchase and workforce rental.
 * All calculations, validations, and data retrieval are server-side ONLY.
 * 
 * Integration with:
 * - Stripe Payment API (via prepare_payment method)
 * - Payment_model for database operations
 * - Database tables: equipment_payments, workforce_payments, equipment_payouts, workforce_payouts
 */

class Checkout extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Generic_model');
		$this->load->model('Payment_model', 'payment');
		$this->load->library('StripeService');
		$this->load->database();
		$this->config->set_item('csrf_protection', TRUE);
	}

	/**
	 * Display checkout page with order summary
	 * 
	 * GET Parameters (validated):
	 * - item_id (int): shopitem.itemID
	 * - quantity (int): units to rent/purchase
	 * - start_date (string, optional): rental start date YYYY-MM-DD (if rental)
	 * - end_date (string, optional): rental end date YYYY-MM-DD (if rental)
	 * 
	 * Flow:
	 * 1. Validate all input parameters
	 * 2. Fetch product from database
	 * 3. Validate product state (exists, live, saleable)
	 * 4. Validate quantity against available inventory
	 * 5. Validate dates if rental
	 * 6. Calculate pricing server-side
	 * 7. Fetch system commission rate
	 * 8. Render checkout view with data
	 */
	public function index()
	{
		// ===== SECURITY CHECK: USER MUST BE LOGGED IN =====
		$login_data = $this->session->userdata('loginData');
		if (!$login_data) {
			$this->session->set_flashdata('error', 'Please log in to continue with checkout');
			redirect(base_url('login'));
			return;
		}

		// ===== STEP 1: VALIDATE & SANITIZE INPUT =====

		$item_id = $this->input->get('item_id', TRUE);
		$quantity = $this->input->get('quantity', TRUE);
		$start_date = $this->input->get('start_date', TRUE);
		$end_date = $this->input->get('end_date', TRUE);

		// Convert to appropriate types
		$item_id  = intval($item_id);
		$quantity = intval($quantity);

		// Validate required parameters (must be strictly positive integers)
		if ($item_id <= 0) {
			show_error('Invalid item ID. Must be a positive integer.', 400);
			return;
		}
		if ($quantity < 1 || $quantity > 10000) {
			show_error('Invalid quantity. Must be between 1 and 10000.', 400);
			return;
		}

		// ===== STEP 2: FETCH PRODUCT FROM DATABASE =====

		// Get shopitem record to determine type (equipment vs workforce)
		$item_query = $this->db->where('itemID', $item_id)
			->where('liveStatus', 1)  // Only live items can be checked out
			->get('shopitem');

		if ($item_query->num_rows() === 0) {
			show_error('Product not found or not available', 404);
			return;
		}

		$item = $item_query->row();
		$item_type = $item->itemType;  // 1 = equipment, 2 = workforce
		$sale_type = $item->saleType;  // 0 = rental, 1 = purchase

		// ===== STEP 3: FETCH PRODUCT DETAILS BASED ON TYPE =====

		$order_data = array();

		if ($item_type == 1) {
			// EQUIPMENT CHECKOUT
			$equipment_query = $this->db->select('se.*, e.equipName')
				->from('shopequipments se')
				->join('equipment e', 'se.equipmentID = e.equipmentID')
				->where('se.itemID', $item_id)
				->get();

			if ($equipment_query->num_rows() == 0) {
				show_error('Equipment not found', 404);
				return;
			}

			// Get as both object and array for debugging
			$equipment_obj = $equipment_query->row();
			$equipment_arr = $equipment_query->row_array();
			$equipment = $equipment_obj;  // Use object for backward compatibility

			if ($sale_type == 0 && $this->_is_date_in_past($equipment->eqpAvailableEnd ?? null)) {
				$this->_delist_marketplace_item($item_id);
				show_error('This rental listing is no longer available.', 410);
				return;
			}

			// DEBUG: Log equipment delivery info from both object and array
			log_message('info', "Equipment Query: " . $this->db->last_query());
			log_message('info', "Equipment (object) for item {$item_id}: delivery_option=" . ($equipment->eqpDeliveryOpt ?? 'NULL') . ", deliveryCharge=" . ($equipment->deliveryCharge ?? 'NULL') . ", deliveryChargeBearer=" . ($equipment->deliveryChargeBearer ?? 'NULL'));
			log_message('info', "Equipment (array) for item {$item_id}: delivery_option=" . ($equipment_arr['eqpDeliveryOpt'] ?? 'NULL') . ", deliveryCharge=" . ($equipment_arr['deliveryCharge'] ?? 'NULL') . ", deliveryChargeBearer=" . ($equipment_arr['deliveryChargeBearer'] ?? 'NULL'));

			// ===== STEP 4: VALIDATE INVENTORY =====

			if ($quantity > $equipment->equipQty) {
				show_error('Insufficient inventory. Available: ' . $equipment->equipQty . ', Requested: ' . $quantity, 400);
				return;
			}

			// ===== STEP 5: VALIDATE RENTAL DATES (IF APPLICABLE) =====

			$rental_days = 0;

			if ($sale_type == 0) {  // Rental

				// Dates are required for rental
				if (!$start_date || !$end_date) {
					show_error('Start date and end date are required for rental', 400);
					return;
				}

				// Validate date format (YYYY-MM-DD)
				if (!$this->_validate_date_format($start_date) || !$this->_validate_date_format($end_date)) {
					show_error('Invalid date format. Use YYYY-MM-DD', 400);
					return;
				}

				// Parse dates
				$start = strtotime($start_date);
				$end = strtotime($end_date);
				$today_ts = strtotime(date('Y-m-d'));

				// Validate date range
				if ($start === FALSE || $end === FALSE) {
					show_error('Invalid dates', 400);
					return;
				}

				if ($start > $end) {
					show_error('Start date must be before end date', 400);
					return;
				}

				if ($start < $today_ts || $end < $today_ts) {
					show_error('Past dates cannot be selected for rental', 400);
					return;
				}

				// Minimum 2-day rental
				$rental_days = $this->_calculate_inclusive_rental_days($start_date, $end_date);
				if ($rental_days < 1) {
					show_error('Rental period must be at least 1 day', 400);
					return;
				}

				// Validate dates fall within availability window
				$avail_start = strtotime($equipment->eqpAvailableStart);
				$avail_end = strtotime($equipment->eqpAvailableEnd);

				if ($start < $avail_start || $end > $avail_end) {
					show_error('Selected dates fall outside availability window', 400);
					return;
				}
			}

			// ===== STEP 6: CALCULATE PRICING (SERVER-SIDE ONLY) =====

			$subtotal = 0;

			if ($sale_type == 0) {  // Rental
				// Price based on rental type
				$price_per_unit = floatval($equipment->eqpPrice);

				// rental_type: 1=daily, 2=weekly, 3=monthly, 4=yearly
				// For now, assume daily rate - can be extended for other periods
				$subtotal = $price_per_unit * $rental_days * $quantity;
			} else {  // Purchase
				// Direct purchase price
				$price_per_unit = floatval($equipment->eqpPrice);
				$subtotal = $price_per_unit * $quantity;
			}

			// Prepare order data for view
			$order_data = array(
				'item_id' => $item_id,
				'item_type' => 1,
				'sale_type' => $sale_type,
				'product_name' => $equipment->equipName,
				'product_sku' => 'EQ-' . $equipment->equipmentID,
				'quantity' => $quantity,
				'unit_price' => floatval($equipment->eqpPrice),
				'rental_start_date' => $sale_type == 0 ? $start_date : NULL,
				'rental_end_date' => $sale_type == 0 ? $end_date : NULL,
				'rental_days' => $rental_days,
				'delivery_option' => $equipment->eqpDeliveryOpt,  // 1=both pickup & delivery, 2=pickup only
				'delivery_charge_bearer' => intval($equipment_arr['deliveryChargeBearer'] ?? 0),  // 1=company pays, 2=renter pays
				'delivery_charge' => floatval($equipment_arr['deliveryCharge'] ?? 0),  // Delivery charge amount
				'pickup_address' => $equipment->eqpAdd ?? 'Address not available',
				'pickup_city' => $equipment->eqpLocCity ?? 'City not available',
				'equipment_rules' => $equipment->eqpRules ?? '',
				'subtotal' => $subtotal,
			);
		} else if ($item_type == 2) {
			// WORKFORCE CHECKOUT
			$workforce_query = $this->db->select('sw.*, w.personName')
				->from('shopworkforce sw')
				->join('workforce w', 'sw.workforceID = w.workforceID')
				->where('sw.itemID', $item_id)
				->get();

			if ($workforce_query->num_rows() == 0) {
				show_error('Workforce not found', 404);
				return;
			}

			// Get as both object and array for debugging
			$workforce_obj = $workforce_query->row();
			$workforce_arr = $workforce_query->row_array();
			$workforce = $workforce_obj;  // Use object for backward compatibility

			if ($this->_is_date_in_past($workforce->workforceAvailableEnd ?? null)) {
				$this->_delist_marketplace_item($item_id);
				show_error('This rental listing is no longer available.', 410);
				return;
			}

			// DEBUG: Log workforce delivery info
			log_message('info', "Workforce (array) for item {$item_id}: delivery_option=" . ($workforce_arr['workforceDeliveryOpt'] ?? 'NULL') . ", deliveryCharge=" . ($workforce_arr['deliveryCharge'] ?? 'NULL') . ", deliveryChargeBearer=" . ($workforce_arr['deliveryChargeBearer'] ?? 'NULL'));

			// ===== STEP 4: VALIDATE WORKFORCE QUANTITY =====
			// Workforce is always 1 person, so quantity must be 1

			if ($quantity != 1) {
				show_error('Workforce quantity must be 1', 400);
				return;
			}

			// ===== STEP 5: VALIDATE DATES =====

			if (!$start_date || !$end_date) {
				show_error('Start date and end date are required for workforce rental', 400);
				return;
			}

			if (!$this->_validate_date_format($start_date) || !$this->_validate_date_format($end_date)) {
				show_error('Invalid date format. Use YYYY-MM-DD', 400);
				return;
			}

			$start = strtotime($start_date);
			$end = strtotime($end_date);
			$today_ts = strtotime(date('Y-m-d'));

			if ($start === FALSE || $end === FALSE) {
				show_error('Invalid dates', 400);
				return;
			}

			if ($start > $end) {
				show_error('Start date must be before end date', 400);
				return;
			}

			if ($start < $today_ts || $end < $today_ts) {
				show_error('Past dates cannot be selected for rental', 400);
				return;
			}

			$rental_days = $this->_calculate_inclusive_rental_days($start_date, $end_date);
			if ($rental_days < 1) {
				show_error('Rental period must be at least 1 day', 400);
				return;
			}

			// Validate availability
			$avail_start = strtotime($workforce->workforceAvailableStart);
			$avail_end = strtotime($workforce->workforceAvailableEnd);

			if ($start < $avail_start || $end > $avail_end) {
				show_error('Selected dates fall outside availability window', 400);
				return;
			}

			// ===== STEP 6: CALCULATE PRICING (SERVER-SIDE ONLY) =====

			$price_per_unit = floatval($workforce->workforcePrice);
			$subtotal = $price_per_unit * $rental_days;

			// Prepare order data
			$order_data = array(
				'item_id' => $item_id,
				'item_type' => 2,
				'sale_type' => 0,  // Workforce is always rental
				'product_name' => $workforce->personName . ' (Workforce)',
				'product_sku' => 'WF-' . $workforce->workforceID,
				'quantity' => 1,
				'unit_price' => $price_per_unit,
				'rental_start_date' => $start_date,
				'rental_end_date' => $end_date,
				'rental_days' => $rental_days,
				'delivery_option' => $workforce->workforceDeliveryOpt,  // 1=pickup, 2=delivery
				'delivery_charge_bearer' => intval($workforce_arr['deliveryChargeBearer'] ?? 0),  // 1=company pays, 2=renter pays
				'delivery_charge' => floatval($workforce_arr['deliveryCharge'] ?? 0),  // Delivery charge amount
				'pickup_address' => $workforce->WorkforceAdd ?? 'Address not available',
				'pickup_city' => $workforce->workforceCity ?? 'City not available',
				'subtotal' => $subtotal,
			);
		} else {
			show_error('Invalid item type', 400);
			return;
		}

		// ===== STEP 7: FETCH GLOBAL COMMISSION RATE =====

		$commission_query = $this->db->where('settingKey', 'marketplace_commission_percent')
			->get('system_settings');

		$commission_percent = 5.00;  // Default if not found
		if ($commission_query->num_rows() > 0) {
			$commission_percent = floatval($commission_query->row()->settingValue);
			// Bounds validation: commission must be between 0 and 50 percent
			if ($commission_percent < 0 || $commission_percent > 50) {
				log_message('error', 'Invalid commission rate from DB: ' . $commission_percent . ' — using safe default 5.00');
				$commission_percent = 5.00;
			}
		}

		// ===== STEP 8: CALCULATE TAXES & TOTAL =====

		$subtotal = floatval($order_data['subtotal']);
		$commission_amount = ($subtotal * $commission_percent) / 100;
		$tax_amount = 0;  // TODO: Implement tax calculation if required
		$total = $subtotal + $tax_amount;  // Commission is NOT added to customer total

		// Add calculated values to order data
		$order_data['commission_percent'] = $commission_percent;
		$order_data['commission_amount'] = $commission_amount;
		$order_data['tax_amount'] = $tax_amount;
		$order_data['total'] = $total;

		// ===== STEP 9: LOAD VIEW =====

		// Get Stripe public key from StripeService
		$stripe_public_key = $this->stripeservice->getPublishableKey();

		// DEBUG: Log what's being passed to view
		log_message('info', "Order data to view: delivery_charge=" . ($order_data['delivery_charge'] ?? 'NOT SET') . ", delivery_charge_bearer=" . ($order_data['delivery_charge_bearer'] ?? 'NOT SET'));

		$data = array(
			'order' => $order_data,
			'csrf_token_name' => $this->security->get_csrf_token_name(),
			'csrf_token_value' => $this->security->get_csrf_hash(),
			'stripe_public_key' => $stripe_public_key,
		);

		// Use existing header/footer layout
		$this->load->view('components/websiteHeader', $data);
		$this->load->view('website/checkout_view', $data);
		$this->load->view('components/websiteFooter', $data);
	}

	/**
	 * Prepare payment with Stripe integration
	 * 
	 * POST Parameters:
	 * - equipment_payment_id (int, optional): If provided, UPDATE existing equipment order
	 * - workforce_payment_id (int, optional): If provided, UPDATE existing workforce order
	 * - payment_method_id (string): Stripe payment method ID
	 * - item_id (int)
	 * - quantity (int)
	 * - start_date (string, optional)
	 * - end_date (string, optional)
	 * - customer_email (string)
	 * - customer_phone (string)
	 * - delivery_name (string)
	 * - delivery_street (string)
	 * - delivery_city (string)
	 * - delivery_postal (string)
	 * - delivery_country (string)
	 * - delivery_method (int): 1=pickup, 2=delivery
	 * - delivery_notes (string, optional)
	 * 
	 * Returns: JSON with client_secret or error
	 */
	public function prepare_payment()
	{

		try {
			header('Content-Type: application/json');

			// Disable CSRF for this AJAX endpoint - security handled by:
			// 1. Server-side order validation
			// 2. Stripe API security
			// 3. Session user verification
			$this->config->set_item('csrf_protection', FALSE);

			// ===== INITIALIZE STRIPE API =====
			\Stripe\Stripe::setApiKey($this->stripeservice->getSecretKey());

			// Accept POST only
			if ($this->input->server('REQUEST_METHOD') !== 'POST') {
				http_response_code(405);
				echo json_encode(['success' => FALSE, 'message' => 'POST required']);
				return;
			}

			// Get JSON input
			$input = json_decode(file_get_contents('php://input'), TRUE);

			if (!is_array($input)) {
				http_response_code(400);
				echo json_encode(['success' => FALSE, 'message' => 'Invalid JSON input']);
				return;
			}

			// ===== VALIDATE INPUT =====
			$equipment_payment_id = intval($input['equipment_payment_id'] ?? 0);
			$workforce_payment_id = intval($input['workforce_payment_id'] ?? 0);
			$item_id = intval($input['item_id'] ?? 0);
			$quantity = intval($input['quantity'] ?? 0);
			$start_date = $input['start_date'] ?? '';
			$end_date = $input['end_date'] ?? '';
			$payment_method_id = $input['payment_method_id'] ?? '';
			$customer_email = htmlspecialchars($input['customer_email'] ?? '');
			$customer_phone = htmlspecialchars($input['customer_phone'] ?? '');
			$delivery_name = htmlspecialchars($input['delivery_name'] ?? '');
			$delivery_street = htmlspecialchars($input['delivery_street'] ?? '');
			$delivery_city = htmlspecialchars($input['delivery_city'] ?? '');
			$delivery_postal = htmlspecialchars($input['delivery_postal'] ?? '');
			$delivery_country = htmlspecialchars($input['delivery_country'] ?? '');
			$delivery_method = intval($input['delivery_method'] ?? 0);
			$delivery_notes = htmlspecialchars($input['delivery_notes'] ?? '');

			if (!$item_id || !$quantity || !$payment_method_id) {
				http_response_code(400);
				echo json_encode(['success' => FALSE, 'message' => 'Missing required parameters']);
				return;
			}

			// ===== CHECK IF UPDATING EXISTING ORDER (approved request with token) =====
			$buyer_user_id = 0;
			if ($equipment_payment_id > 0 || $workforce_payment_id > 0) {
				// Verify the order exists and belongs to the current logged-in user
				$login_data = $this->session->userdata('loginData');
				$buyer_user_id = intval($login_data['userID'] ?? 0);
				
				if (!$buyer_user_id) {
					http_response_code(401);
					echo json_encode(['success' => FALSE, 'message' => 'User not authenticated']);
					return;
				}
				
				if ($equipment_payment_id > 0) {
					$existing_order = $this->db->select('equipmentPaymentID, buyerUserID, orderStatus')
						->from('equipment_payments')
						->where('equipmentPaymentID', $equipment_payment_id)
						->where('buyerUserID', $buyer_user_id)
						->get()
						->row();
				} else {
					$existing_order = $this->db->select('workforcePaymentID, buyerUserID, orderStatus')
						->from('workforce_payments')
						->where('workforcePaymentID', $workforce_payment_id)
						->where('buyerUserID', $buyer_user_id)
						->get()
						->row();
				}
				
				if (!$existing_order) {
					http_response_code(403);
					echo json_encode(['success' => FALSE, 'message' => 'Order not found or access denied']);
					return;
				}
				
				if ($existing_order->orderStatus !== 'payment_pending') {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Order cannot be paid in current status: ' . $existing_order->orderStatus]);
					return;
				}
			}

			// ===== RE-VALIDATE ORDER (Never trust client) =====

			// Fetch and validate item
			$item_query = $this->db->where('itemID', $item_id)
				->where('liveStatus', 1)
				->get('shopitem');

			if ($item_query->num_rows() === 0) {
				http_response_code(404);
				echo json_encode(['success' => FALSE, 'message' => 'Product not found']);
				return;
			}

			$item = $item_query->row();
			$item_type = $item->itemType;
			$sale_type = $item->saleType;

			// Fetch product details and recalculate pricing
			$subtotal = 0;
			// Default seller company from shopitem; tables below may not expose sellerCompanyID directly
			$seller_company_id = intval($item->companyID ?? 0);

			if ($item_type == 1) {
				// Equipment
				$equipment = $this->db->select('se.*, e.equipName')
					->from('shopequipments se')
					->join('equipment e', 'se.equipmentID = e.equipmentID')
					->where('se.itemID', $item_id)
					->get()
					->row();

				if (!$equipment) {
					http_response_code(404);
					echo json_encode(['success' => FALSE, 'message' => 'Equipment not found']);
					return;
				}

				if ($quantity > $equipment->equipQty) {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Insufficient inventory']);
					return;
				}

				// Fallback to item company if sellerCompanyID is not present
				$seller_company_id = intval($equipment->sellerCompanyID ?? $seller_company_id);

				if ($sale_type == 0) {
					// Rental
					$start = strtotime($start_date);
					$end = strtotime($end_date);

					if ($start === FALSE || $end === FALSE || $start > $end) {
						http_response_code(400);
						echo json_encode(['success' => FALSE, 'message' => 'Invalid dates']);
						return;
					}

					$rental_days = $this->_calculate_inclusive_rental_days($start_date, $end_date);
					$price_per_unit = floatval($equipment->eqpPrice);
					$subtotal = $price_per_unit * $rental_days * $quantity;
				} else {
					// Purchase
					$price_per_unit = floatval($equipment->eqpPrice);
					$subtotal = $price_per_unit * $quantity;
				}
			} else if ($item_type == 2) {
				// Workforce
				$workforce = $this->db->select('sw.*, w.personName')
					->from('shopworkforce sw')
					->join('workforce w', 'sw.workforceID = w.workforceID')
					->where('sw.itemID', $item_id)
					->get()
					->row();

				if (!$workforce) {
					http_response_code(404);
					echo json_encode(['success' => FALSE, 'message' => 'Workforce not found']);
					return;
				}

				if ($quantity != 1) {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Workforce quantity must be 1']);
					return;
				}

				$seller_company_id = intval($workforce->sellerCompanyID ?? $seller_company_id);

				$start = strtotime($start_date);
				$end = strtotime($end_date);

				if ($start === FALSE || $end === FALSE || $start > $end) {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Invalid dates']);
					return;
				}

				$rental_days = $this->_calculate_inclusive_rental_days($start_date, $end_date);
				$price_per_unit = floatval($workforce->workforcePrice);
				$subtotal = $price_per_unit * $rental_days;
			}

			// Get commission and calculate total
			$commission_percent = $this->payment->getGlobalCommissionRate();
			$commission_amount = round($subtotal * ($commission_percent / 100), 2);
			$tax_amount = 0; // TODO: Implement tax if needed

		// ===== CALCULATE DELIVERY CHARGE =====
		// Delivery charge is only added if:
		// 1. Item supports delivery (eqpDeliveryOpt/workforceDeliveryOpt == 1)
		// 2. User selected delivery method (delivery_method == 2, where 1=pickup, 2=delivery)
		// 3. Seller charges for delivery (deliveryChargeBearer == 2, where 1=company pays, 2=renter pays)
		$delivery_charge = 0;
		$max_delivery_charge = 0;

		if ($item_type == 1) {
			// Equipment delivery logic
			if (isset($equipment->deliveryChargeBearer) && $equipment->deliveryChargeBearer == 2 && !empty($equipment->deliveryCharge)) {
				$max_delivery_charge = floatval($equipment->deliveryCharge);
			}
			// Only apply delivery charge if item supports delivery AND user chose delivery
			if (intval($equipment->eqpDeliveryOpt ?? 0) == 1 && $delivery_method == 2 && $max_delivery_charge > 0) {
				$delivery_charge = $max_delivery_charge;
			}
		} else if ($item_type == 2) {
			// Workforce delivery logic
			if (isset($workforce->deliveryChargeBearer) && $workforce->deliveryChargeBearer == 2 && !empty($workforce->deliveryCharge)) {
				$max_delivery_charge = floatval($workforce->deliveryCharge);
			}
			// Only apply delivery charge if workforce supports delivery AND user chose delivery
			if (intval($workforce->workforceDeliveryOpt ?? 0) == 1 && $delivery_method == 2 && $max_delivery_charge > 0) {
				$delivery_charge = $max_delivery_charge;
			}
		}

		// Total = equipment/rental amount + delivery charge (only if delivery selected)
		// Commission applies ONLY to equipment/rental amount, NOT to delivery
		$total_amount = $subtotal + $tax_amount + $delivery_charge;


			// Get current user (buyer) - session structure: loginData contains user array
			$login_data = $this->session->userdata('loginData');
			if (!$login_data) {
				http_response_code(401);
				echo json_encode(['success' => FALSE, 'message' => 'User not authenticated. Please log in.']);
				return;
			}
			$buyer_user_id = intval($login_data['userID'] ?? 0);


			// ===== CREATE STRIPE PAYMENT INTENT =====

			// Create payment intent with Stripe
			// Setting confirm=true allows immediate confirmation (succeeds for test cards, requires_action for 3DS)
			$intent = \Stripe\PaymentIntent::create([
				'amount' => intval($total_amount * 100), // Amount in cents
				'currency' => 'usd',
				'automatic_payment_methods' => [
					'enabled' => true,
					'allow_redirects' => 'never',  // Only accept non-redirect payment methods
				],
				'payment_method' => $payment_method_id,
				// Stripe PaymentIntent does not accept customer_email; use receipt_email instead
				'receipt_email' => $customer_email,
				'description' => 'Order from EquipManager - ' . ($item_type == 1 ? 'Equipment' : 'Workforce'),
				'metadata' => [
					'item_id' => $item_id,
					'item_type' => $item_type,
					'quantity' => $quantity,
					'buyer_user_id' => $buyer_user_id,
					'seller_company_id' => $seller_company_id,
					'delivery_method' => $delivery_method,
					'equipment_amount' => number_format($subtotal, 2, '.', ''),
					'delivery_amount' => number_format($delivery_charge, 2, '.', ''),
					'total_amount' => number_format($total_amount, 2, '.', ''),
				],
				'confirm' => true,
			]);

			// ===== CREATE OR UPDATE PAYMENT RECORD IN DATABASE =====

			if ($equipment_payment_id > 0 || $workforce_payment_id > 0) {
				// UPDATE existing approved order with Stripe payment info
				$net_amount = $subtotal - $commission_amount + $delivery_charge;
				$update_data = [
					'stripePaymentIntentID' => $intent->id,
					'paymentStatus' => 'pending',
					'grossAmount' => $total_amount,
					'commissionPercent' => $commission_percent,
					'commissionAmount' => $commission_amount,
					'netAmount' => $net_amount,
					'paymentMetadata' => json_encode([
				'equipment_amount' => number_format($subtotal, 2, '.', ''),
				'delivery_amount' => number_format($delivery_charge, 2, '.', ''),
						'total_amount' => number_format($total_amount, 2, '.', ''),
						'delivery_method' => $delivery_method,
						'customer_email' => $customer_email,
						'customer_phone' => $customer_phone,
						'delivery_name' => $delivery_name,
						'delivery_street' => $delivery_street,
						'delivery_city' => $delivery_city,
						'delivery_postal' => $delivery_postal,
						'delivery_country' => $delivery_country,
						'delivery_notes' => $delivery_notes,
					]),
					'updatedAt' => date('Y-m-d H:i:s')
				];

				if ($equipment_payment_id > 0) {
					$this->db->where('equipmentPaymentID', $equipment_payment_id);
					$update_result = $this->db->update('equipment_payments', $update_data);
					$payment_id = $equipment_payment_id;
					log_message('info', "Updated existing equipment order {$equipment_payment_id} with Stripe payment intent {$intent->id}");
				} else {
					$this->db->where('workforcePaymentID', $workforce_payment_id);
					$update_result = $this->db->update('workforce_payments', $update_data);
					$payment_id = $workforce_payment_id;
					log_message('info', "Updated existing workforce order {$workforce_payment_id} with Stripe payment intent {$intent->id}");
				}
				
				if (!$update_result) {
					http_response_code(500);
					echo json_encode(['success' => FALSE, 'message' => 'Failed to update payment record']);
					return;
				}
			} else {
				// CREATE new payment record (for direct checkout, not via token)
				$payment_data = [
					'item_id' => $item_id,
					'buyer_user_id' => $buyer_user_id,
					'seller_company_id' => $seller_company_id,
					'gross_amount' => $total_amount,
					'currency' => 'USD',
					'metadata' => [
					'equipment_amount' => number_format($subtotal, 2, '.', ''),
					'delivery_amount' => number_format($delivery_charge, 2, '.', ''),
						'delivery_method' => $delivery_method,
						'customer_email' => $customer_email,
						'customer_phone' => $customer_phone,
						'delivery_name' => $delivery_name,
						'delivery_street' => $delivery_street,
						'delivery_city' => $delivery_city,
						'delivery_postal' => $delivery_postal,
						'delivery_country' => $delivery_country,
						'delivery_notes' => $delivery_notes,
					],
				];

				if ($item_type == 1) {
					// EQUIPMENT PAYMENT
					$payment_data['equipment_id'] = $equipment->equipmentID;
					$payment_data['quantity'] = $quantity;
					$payment_data['sale_type'] = $sale_type == 1 ? 'purchase' : 'rental';
					$payment_data['rental_start_date'] = $start_date ?: NULL;
					$payment_data['rental_end_date'] = $end_date ?: NULL;
					$payment_data['rental_type'] = $equipment->eqpRentalType; // 1=daily, 2=weekly, 3=monthly, 4=yearly
					$payment_data['stripe_payment_intent_id'] = $intent->id;

					$payment_id = $this->payment->createEquipmentPayment($payment_data);
				} else {
					// WORKFORCE PAYMENT
					$payment_data['workforce_id'] = $workforce->workforceID;
					$payment_data['rental_start_date'] = $start_date;
					$payment_data['rental_end_date'] = $end_date;
					$payment_data['rental_type'] = $workforce->workforceRentalType; // 1=daily, 2=weekly, 3=monthly, 4=yearly
					$payment_data['stripe_payment_intent_id'] = $intent->id;

					$payment_id = $this->payment->createWorkforcePayment($payment_data);
				}

				if (!$payment_id) {
					http_response_code(500);
					echo json_encode(['success' => FALSE, 'message' => 'Failed to create payment record']);
					return;
				}
			}

			// ===== RETURN RESPONSE =====

			http_response_code(200);
			echo json_encode([
				'success' => TRUE,
				'payment_intent_id' => $intent->id,
				'client_secret' => $intent->client_secret,
				'requires_action' => $intent->status === 'requires_action',
				'status' => $intent->status,
			]);
		} catch (\Stripe\Exception\ApiErrorException $e) {
			header('Content-Type: application/json');
			http_response_code(400);
			echo json_encode([
				'success' => FALSE,
				'message' => 'Stripe Error: ' . $e->getMessage()
			]);
			log_message('error', 'Stripe Error: ' . $e->getMessage());
		} catch (Exception $e) {
			header('Content-Type: application/json');
			http_response_code(500);
			echo json_encode([
				'success' => FALSE,
				'message' => 'Error: ' . $e->getMessage()
			]);
			log_message('error', 'Payment Processing Error: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
		} catch (Throwable $e) {
			header('Content-Type: application/json');
			http_response_code(500);
			echo json_encode([
				'success' => FALSE,
				'message' => 'Unexpected Error: ' . $e->getMessage()
			]);
			log_message('error', 'Unhandled Error in prepare_payment: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
		}
	}

	/**
	 * Payment success callback
	 * 
	 * Handles payment confirmation after successful Stripe payment
	 * - Retrieves PaymentIntent status from Stripe
	 * - Updates payment record status in database
	 * - Updates inventory if applicable
	 * - Displays success page
	 */
	public function payment_success()
	{

		// Check if user is authenticated - session structure: loginData contains user array
		$login_data = $this->session->userdata('loginData');
		if (!$login_data) {
			redirect('login');
			return;
		}
		$user_id = intval($login_data['userID'] ?? 0);

		// Get the payment intent ID from query params (set by Stripe after 3D Secure)
		$payment_intent_id = $this->input->get('payment_intent', TRUE);

		if (!$payment_intent_id) {
			$this->load->view('website/payment_failed', [
				'error_message' => 'No payment confirmation received. Please contact support.'
			]);
			return;
		}

		// Initialize Stripe API
		try {
			\Stripe\Stripe::setApiKey($this->stripeservice->getSecretKey());

			// Retrieve PaymentIntent from Stripe to verify status
			$payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);

			// Verify payment was actually successful
			if ($payment_intent->status !== 'succeeded') {
				$this->load->view('website/payment_failed', [
					'error_message' => 'Payment was not completed successfully. Status: ' . $payment_intent->status
				]);
				return;
			}
		} catch (Exception $e) {
			log_message('error', 'Stripe verification error in payment_success: ' . $e->getMessage());
			$this->load->view('website/payment_failed', [
				'error_message' => 'Could not verify payment. Please contact support.'
			]);
			return;
		}

		// Look up payment by intent ID
		$payment = NULL;

		// Check equipment payments first
		$eq_payment = $this->payment->getEquipmentPaymentByIntentId($payment_intent_id);
		if ($eq_payment && $eq_payment['buyerUserID'] == $user_id) {
			$payment = $eq_payment;
			$payment['type'] = 'equipment';
		}

		// Check workforce payments
		if (!$payment) {
			$wf_payment = $this->payment->getWorkforcePaymentByIntentId($payment_intent_id);
			if ($wf_payment && $wf_payment['buyerUserID'] == $user_id) {
				$payment = $wf_payment;
				$payment['type'] = 'workforce';
			}
		}

		if (!$payment) {
			$this->load->view('website/payment_failed', [
				'error_message' => 'Payment not found. Please contact support with your payment ID.'
			]);
			return;
		}

		$order_lookup = $this->db->select('orderID')
			->from('orders')
			->where($payment['type'] === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID',
				$payment['type'] === 'equipment' ? $payment['equipmentPaymentID'] : $payment['workforcePaymentID'])
			->get()
			->row();
		$order_id = intval($order_lookup->orderID ?? 0);

		// ===== VERIFY ORDER STATUS (ESCROW WORKFLOW) =====
		// For equipment orders, verify order status before processing payment
		if ($payment['type'] === 'equipment' && isset($payment['orderStatus'])) {
			if ($payment['orderStatus'] === 'rejected') {
				$this->load->view('website/payment_failed', [
					'error_message' => 'This purchase request was rejected by the seller. Payment cannot be processed.'
				]);
				return;
			}
			
			if ($payment['orderStatus'] === 'requested') {
				$this->load->view('website/payment_failed', [
					'error_message' => 'This purchase request is still pending approval. Payment cannot be processed yet.'
				]);
				return;
			}
		}

		// Update payment status to completed if Stripe confirms success
		$this->load->model('Chat_model');
		$this->load->helper('notification');

		if ($payment['paymentStatus'] === 'pending' || $payment['paymentStatus'] === 'processing') {
			if ($payment['type'] === 'equipment') {
				$this->payment->updateEquipmentPaymentStatus(
					$payment['equipmentPaymentID'],
					'paid'
				);
				$payment_id = $payment['equipmentPaymentID'];

				// ===== UPDATE ORDER STATUS TO PAYMENT_SECURED (ESCROW) =====
				// Money is now held in escrow, awaiting shipment
				$this->db->update(
					'equipment_payments',
					['orderStatus' => 'payment_secured'],
					['equipmentPaymentID' => $payment['equipmentPaymentID']]
				);

				// ===== UPDATE EQUIPMENT INVENTORY =====
				// Decrease equipment quantity after successful payment
				$equipment_data = $this->db->where('itemID', $payment['itemID'])
					->get('shopequipments')
					->row();

				if ($equipment_data) {
					$new_quantity = floatval($equipment_data->equipQty) - floatval($payment['quantity']);
					$this->db->update(
						'shopequipments',
						['equipQty' => max(0, $new_quantity)],  // Don't go below 0
						['itemID' => $payment['itemID']]
					);
					log_message('info', "Equipment inventory updated: Item ID {$payment['itemID']}, Quantity reduced by {$payment['quantity']}");
				}

			// ===== UPDATE MAIN EQUIPMENT TABLE TOTAL QUANTITY =====
			// Also decrease the total quantity in the equipment table
			$main_equipment = $this->db->where('equipmentID', $payment['equipmentID'])
				->get('equipment')
				->row();

			if ($main_equipment) {
				$new_total_quantity = floatval($main_equipment->equipTotalQuantity) - floatval($payment['quantity']);
				$this->db->update(
					'equipment',
					['equipTotalQuantity' => max(0, $new_total_quantity)],  // Don't go below 0
					['equipmentID' => $payment['equipmentID']]
				);
				log_message('info', "Main equipment total quantity updated: Equipment ID {$payment['equipmentID']}, Total quantity reduced by {$payment['quantity']}");
			}

			// ===== CREATE CHAT FOR ORDER =====
			// Automatically create chat between buyer and seller
			$this->load->model('Chat_model');
			$this->load->helper('notification');

			$chatID = null;
			if ($order_id > 0) {
				$chatID = $this->Chat_model->create_chat(
					$order_id,
					$payment['buyerUserID'],
					$payment['sellerCompanyID']
				);
			}

			if ($chatID) {
				log_message('info', "Chat ensured for order {$order_id} (equipment payment {$payment['equipmentPaymentID']}): Chat ID {$chatID}");
				
				// Send automated message to seller: Payment secured, please ship
				$message = "Payment received and secured in escrow!\n\n"
				         . "Order #" . ($order_id > 0 ? $order_id : $payment['equipmentPaymentID']) . "\n"
				         . "Amount: $" . number_format($payment['grossAmount'], 2) . "\n\n";
				
				$this->Chat_model->send_automated_message(
					$chatID,
					$message,
					$payment['sellerCompanyID'],
					'system'
				);

				if ($order_id > 0) {
					send_notification((int)$payment['buyerUserID'], 'payment_received', (int)$order_id);
					$company_admin = $this->db->select('userID')
						->from('companydetail')
						->where('companyID', $payment['sellerCompanyID'])
						->get()
						->row();
					if (!empty($company_admin->userID)) {
						send_notification((int)$company_admin->userID, 'payment_received', (int)$order_id);
					}
				}
			} else {
				log_message('error', "Failed to create chat for equipment payment {$payment['equipmentPaymentID']}");
				$chatID = null;
			}
		} else {
			// Workforce - update payment status and align fulfillment status with equipment flow
			$this->db->update(
					'workforce_payments',
					[
						'paymentStatus' => 'paid',
						'orderStatus' => 'payment_secured'
					],
					['workforcePaymentID' => $payment['workforcePaymentID']]
				);
				$payment_id = $payment['workforcePaymentID'];

				$chatID = null;
				if ($order_id > 0) {
					$chatID = $this->Chat_model->create_chat(
						$order_id,
						$payment['buyerUserID'],
						$payment['sellerCompanyID']
					);
				}

				if ($chatID) {
					$message = "Payment received and secured in escrow!\n\n"
					         . "Order #" . ($order_id > 0 ? $order_id : $payment['workforcePaymentID']) . "\n"
					         . "Amount: $" . number_format($payment['grossAmount'], 2) . "\n\n";

					$this->Chat_model->send_automated_message(
						$chatID,
						$message,
						$payment['sellerCompanyID'],
						'system'
					);
				}

				if ($order_id > 0) {
					send_notification((int)$payment['buyerUserID'], 'payment_received', (int)$order_id);
					$company_admin = $this->db->select('userID')
						->from('companydetail')
						->where('companyID', $payment['sellerCompanyID'])
						->get()
						->row();
					if (!empty($company_admin->userID)) {
						send_notification((int)$company_admin->userID, 'payment_received', (int)$order_id);
					}
				}
			}
		} else {
			// Already processed
			$payment_id = $payment['type'] === 'equipment' ? $payment['equipmentPaymentID'] : $payment['workforcePaymentID'];
			$chatID = null;
			if ($order_id > 0) {
				$existing_chat = $this->Chat_model->get_chat_by_order($order_id);
				$chatID = $existing_chat ? $existing_chat->chatID : null;
			}
		}

		// Render success page with order details
		$this->load->view('website/payment_success', [
			'order_id' => $order_id ?: ($payment_id ?? 'N/A'),
			'amount' => $payment['grossAmount'] ?? 0,
			'chatID' => $chatID,
			'paymentID' => $payment_id,
			'orderID' => $order_id
		]);
	}

	/**
	 * Payment failure callback
	 * 
	 * Displays failure page with error details
	 * User can retry or contact support
	 */
	public function payment_failed()
	{

		// Check if user is authenticated - session structure: loginData contains user array
		$login_data = $this->session->userdata('loginData');
		if (!$login_data) {
			redirect('login');
			return;
		}
		$user_id = intval($login_data['userID'] ?? 0);

		// Get error message from query params
		$error_message = $this->input->get('error', TRUE);

		$this->load->view('website/payment_failed', [
			'error_message' => $error_message ?: 'Your payment could not be processed. Please try again.'
		]);
	}

	/**
	 * PRIVATE HELPER: Validate date format (YYYY-MM-DD)
	 */
	private function _validate_date_format($date)
	{
		$pattern = '/^\d{4}-\d{2}-\d{2}$/';
		if (!preg_match($pattern, $date)) {
			return FALSE;
		}

		// Also validate it's a real date
		$parts = explode('-', $date);
		return checkdate(intval($parts[1]), intval($parts[2]), intval($parts[0]));
	}

	private function _is_date_in_past($date)
	{
		if (empty($date)) {
			return false;
		}

		$timestamp = strtotime($date);
		if ($timestamp === FALSE) {
			return false;
		}

		return $timestamp < strtotime(date('Y-m-d'));
	}

	private function _delist_marketplace_item($item_id)
	{
		$this->db->where('itemID', intval($item_id));
		$this->db->update('shopitem', ['liveStatus' => 0]);
	}

	/**
	 * Calculate inclusive rental days in a DST-safe way from YYYY-MM-DD dates.
	 */
	private function _calculate_inclusive_rental_days($start_date, $end_date)
	{
		try {
			$start = new DateTime($start_date);
			$end = new DateTime($end_date);
			return intval($start->diff($end)->days) + 1;
		} catch (Exception $e) {
			return 0;
		}
	}

	/**
	 * Create Purchase Request (NEW FLOW)
	 * 
	 * Creates a purchase request without immediate payment
	 * - Request goes to company admin for approval
	 * - Chat is opened immediately
	 * - Payment only proceeds after admin approval
	 * 
	 * POST Parameters:
	 * - item_id: shopitem.itemID
	 * - quantity: units to purchase
	 * - start_date (optional): for rentals
	 * - end_date (optional): for rentals
	 * - customer_email
	 * - customer_phone
	 * - delivery_method: 1=pickup, 2=delivery
	 * - delivery details (name, street, city, postal, country, notes)
	 */
	public function create_purchase_request()
	{
		try {
			header('Content-Type: application/json');
			
			// Disable CSRF for AJAX endpoint
			$this->config->set_item('csrf_protection', FALSE);
			
			// POST only
			if ($this->input->server('REQUEST_METHOD') !== 'POST') {
				http_response_code(405);
				echo json_encode(['success' => FALSE, 'message' => 'POST required']);
				return;
			}
			
			// Get JSON input
			$input = json_decode(file_get_contents('php://input'), TRUE);
			
			if (!is_array($input)) {
				http_response_code(400);
				echo json_encode(['success' => FALSE, 'message' => 'Invalid JSON input']);
				return;
			}
			
			// ===== CHECK IF UPDATING EXISTING ORDER (approved request with token) =====
			$equipment_payment_id = intval($input['equipment_payment_id'] ?? 0);
			
			// If equipment_payment_id is provided, we're updating an existing approved order
			if ($equipment_payment_id > 0) {
				// Verify the order exists and belongs to the current logged-in user
				$login_data = $this->session->userdata('loginData');
				$buyer_user_id = intval($login_data['userID'] ?? 0);
				
				$existing_order = $this->db->select('equipmentPaymentID, buyerUserID, orderStatus')
					->from('equipment_payments')
					->where('equipmentPaymentID', $equipment_payment_id)
					->where('buyerUserID', $buyer_user_id)
					->get()
					->row();
				
				if (!$existing_order) {
					http_response_code(403);
					echo json_encode(['success' => FALSE, 'message' => 'Order not found or access denied']);
					return;
				}
				
				if ($existing_order->orderStatus !== 'payment_pending') {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Order cannot be paid in current status: ' . $existing_order->orderStatus]);
					return;
				}
				
				// This is an UPDATE scenario - update the payment metadata for the existing order
				// Continue to payment processing but mark as UPDATE_EXISTING
			}
			
         // ===== VALIDATE INPUT =====
			$item_id = intval($input['item_id'] ?? 0);
			$quantity = intval($input['quantity'] ?? 0);
			$start_date = $input['start_date'] ?? '';
			$end_date = $input['end_date'] ?? '';
			$customer_email = htmlspecialchars($input['customer_email'] ?? '');
			$customer_phone = htmlspecialchars($input['customer_phone'] ?? '');
			$delivery_name = htmlspecialchars($input['delivery_name'] ?? '');
			$delivery_street = htmlspecialchars($input['delivery_street'] ?? '');
			$delivery_city = htmlspecialchars($input['delivery_city'] ?? '');
			$delivery_postal = htmlspecialchars($input['delivery_postal'] ?? '');
			$delivery_country = htmlspecialchars($input['delivery_country'] ?? '');
			$delivery_method = intval($input['delivery_method'] ?? 0);
			$delivery_notes = htmlspecialchars($input['delivery_notes'] ?? '');
			
			if (!$item_id || !$quantity) {
				http_response_code(400);
				echo json_encode(['success' => FALSE, 'message' => 'Missing required parameters']);
				return;
			}
			
			// ===== VALIDATE PRODUCT =====
			$item_query = $this->db->where('itemID', $item_id)
				->where('liveStatus', 1)
				->get('shopitem');
			
			if ($item_query->num_rows() === 0) {
				http_response_code(404);
				echo json_encode(['success' => FALSE, 'message' => 'Product not found']);
				return;
			}
			
			$item = $item_query->row();
			$item_type = $item->itemType;
			$sale_type = $item->saleType;
			$seller_company_id = intval($item->companyID ?? 0);

			if ($item_type != 1 && $item_type != 2) {
				http_response_code(400);
				echo json_encode(['success' => FALSE, 'message' => 'Unsupported item type']);
				return;
			}

			$equipment = NULL;
			$workforce = NULL;
			$product_name = 'Item';
			$request_table = '';
			$order_link_field = '';

			// ===== FETCH ITEM DETAILS + CALCULATE PRICING =====
			$subtotal = 0;
			if ($item_type == 1) {
				$equipment = $this->db->select('se.*, e.equipName')
					->from('shopequipments se')
					->join('equipment e', 'se.equipmentID = e.equipmentID')
					->where('se.itemID', $item_id)
					->get()
					->row();

				if (!$equipment) {
					http_response_code(404);
					echo json_encode(['success' => FALSE, 'message' => 'Equipment not found']);
					return;
				}

				if ($sale_type == 0 && $this->_is_date_in_past($equipment->eqpAvailableEnd ?? null)) {
					$this->_delist_marketplace_item($item_id);
					http_response_code(410);
					echo json_encode(['success' => FALSE, 'message' => 'This rental listing is no longer available']);
					return;
				}

				if ($quantity > intval($equipment->equipQty ?? 0)) {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Insufficient inventory']);
					return;
				}

				if ($sale_type == 0) {
					$start = strtotime($start_date);
					$end = strtotime($end_date);
					$today_ts = strtotime(date('Y-m-d'));

					if ($start === FALSE || $end === FALSE || $start > $end) {
						http_response_code(400);
						echo json_encode(['success' => FALSE, 'message' => 'Invalid dates']);
						return;
					}

					if ($start < $today_ts || $end < $today_ts) {
						http_response_code(400);
						echo json_encode(['success' => FALSE, 'message' => 'Past dates cannot be selected for rental']);
						return;
					}

					$avail_start = strtotime($equipment->eqpAvailableStart);
					$avail_end = strtotime($equipment->eqpAvailableEnd);
					if ($start < $avail_start || $end > $avail_end) {
						http_response_code(400);
						echo json_encode(['success' => FALSE, 'message' => 'Selected dates fall outside availability window']);
						return;
					}

					$available_qty = $this->payment->getAvailableQuantity($equipment->equipmentID, $start_date, $end_date);
					if ($available_qty < $quantity) {
						http_response_code(400);
						echo json_encode(['success' => FALSE, 'message' => 'Equipment is not available for the selected dates']);
						return;
					}

					$rental_days = $this->_calculate_inclusive_rental_days($start_date, $end_date);
					$subtotal = floatval($equipment->eqpPrice) * $rental_days * $quantity;
				} else {
					$subtotal = floatval($equipment->eqpPrice) * $quantity;
				}

				$product_name = (string)($equipment->equipName ?? 'Equipment');
				$request_table = 'equipment_payments';
				$order_link_field = 'equipmentPaymentID';
			} else {
				$workforce = $this->db->select('sw.*, w.personName')
					->from('shopworkforce sw')
					->join('workforce w', 'sw.workforceID = w.workforceID')
					->where('sw.itemID', $item_id)
					->get()
					->row();

				if (!$workforce) {
					http_response_code(404);
					echo json_encode(['success' => FALSE, 'message' => 'Workforce not found']);
					return;
				}

				if ($this->_is_date_in_past($workforce->workforceAvailableEnd ?? null)) {
					$this->_delist_marketplace_item($item_id);
					http_response_code(410);
					echo json_encode(['success' => FALSE, 'message' => 'This rental listing is no longer available']);
					return;
				}

				if ($quantity != 1) {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Workforce quantity must be 1']);
					return;
				}

				$start = strtotime($start_date);
				$end = strtotime($end_date);
				$today_ts = strtotime(date('Y-m-d'));
				if ($start === FALSE || $end === FALSE || $start > $end) {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Invalid dates']);
					return;
				}

				if ($start < $today_ts || $end < $today_ts) {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Past dates cannot be selected for rental']);
					return;
				}

				$avail_start = strtotime($workforce->workforceAvailableStart);
				$avail_end = strtotime($workforce->workforceAvailableEnd);
				if ($start < $avail_start || $end > $avail_end) {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Selected dates fall outside availability window']);
					return;
				}

				if (!$this->payment->isWorkforceAvailable($workforce->workforceID, $start_date, $end_date)) {
					http_response_code(400);
					echo json_encode(['success' => FALSE, 'message' => 'Workforce is not available for the selected dates']);
					return;
				}

				$rental_days = $this->_calculate_inclusive_rental_days($start_date, $end_date);
				$subtotal = floatval($workforce->workforcePrice) * $rental_days;

				$product_name = (string)($workforce->personName ?? 'Workforce');
				$request_table = 'workforce_payments';
				$order_link_field = 'workforcePaymentID';
				$sale_type = 0; // Workforce is always rental
			}
			
			// Get commission
			$commission_percent = $this->payment->getGlobalCommissionRate();
			$commission_amount = round($subtotal * ($commission_percent / 100), 2);

		// ===== CALCULATE DELIVERY CHARGE =====
		// Delivery charge is only added if:
		// 1. Item supports delivery (eqpDeliveryOpt == 1)
		// 2. User selected delivery method (delivery_method == 2, where 1=pickup, 2=delivery)
		// 3. Seller charges for delivery (deliveryChargeBearer == 2, where 1=company pays, 2=renter pays)
		$delivery_charge = 0;
		$max_delivery_charge = 0;

		if ($item_type == 1) {
			if (isset($equipment->deliveryChargeBearer) && $equipment->deliveryChargeBearer == 2 && !empty($equipment->deliveryCharge)) {
				$max_delivery_charge = floatval($equipment->deliveryCharge);
			}
			// Only apply delivery charge if item supports delivery AND user chose delivery
			if (intval($equipment->eqpDeliveryOpt ?? 0) == 1 && $delivery_method == 2 && $max_delivery_charge > 0) {
				$delivery_charge = $max_delivery_charge;
			}
		} else {
			if (isset($workforce->deliveryChargeBearer) && $workforce->deliveryChargeBearer == 2 && !empty($workforce->deliveryCharge)) {
				$max_delivery_charge = floatval($workforce->deliveryCharge);
			}
			// Only apply delivery charge if workforce supports delivery AND user chose delivery
			if (intval($workforce->workforceDeliveryOpt ?? 0) == 1 && $delivery_method == 2 && $max_delivery_charge > 0) {
				$delivery_charge = $max_delivery_charge;
			}
		}

		// Total = equipment/rental amount + delivery charge (only if delivery selected)
		// Commission applies ONLY to equipment/rental amount, NOT to delivery
		$total_amount = $subtotal + $delivery_charge;

			
			// Get buyer user ID
			$login_data = $this->session->userdata('loginData');
			if (!$login_data) {
				http_response_code(401);
				echo json_encode(['success' => FALSE, 'message' => 'User not authenticated']);
				return;
			}
			$buyer_user_id = intval($login_data['userID'] ?? 0);
			
			// ===== CREATE PURCHASE/RENTAL REQUEST RECORD =====
			$request_data = [
				'itemID' => $item_id,
				'buyerUserID' => $buyer_user_id,
				'sellerCompanyID' => $seller_company_id,
				'grossAmount' => $total_amount,
				'commissionPercent' => $commission_percent,
				'commissionAmount' => $commission_amount,
				'netAmount' => $total_amount - $commission_amount,
				'currency' => 'USD',
				'rentalStartDate' => $start_date ?: NULL,
				'rentalEndDate' => $end_date ?: NULL,
				'orderStatus' => 'requested',
				'paymentStatus' => 'pending',
				'paymentMetadata' => json_encode([
					'equipment_amount' => number_format($subtotal, 2, '.', ''),
					'delivery_amount' => number_format($delivery_charge, 2, '.', ''),
					'delivery_method' => $delivery_method,
					'customer_email' => $customer_email,
					'customer_phone' => $customer_phone,
					'delivery_name' => $delivery_name,
					'delivery_street' => $delivery_street,
					'delivery_city' => $delivery_city,
					'delivery_postal' => $delivery_postal,
					'delivery_country' => $delivery_country,
					'delivery_notes' => $delivery_notes,
				]),
				'createdAt' => date('Y-m-d H:i:s'),
				'updatedAt' => date('Y-m-d H:i:s')
			];

			if ($item_type == 1) {
				$request_data['equipmentID'] = $equipment->equipmentID;
				$request_data['quantity'] = $quantity;
				$request_data['saleType'] = $sale_type == 1 ? 'purchase' : 'rental';
				$request_data['rentalType'] = $equipment->eqpRentalType;
			} else {
				$request_data['workforceID'] = $workforce->workforceID;
				$request_data['rentalType'] = $workforce->workforceRentalType;
				$request_data['rentalRequestStatus'] = 'request_pending';
			}

			$this->db->insert($request_table, $request_data);
			$request_id = $this->db->insert_id();
			
		if (!$request_id) {
			http_response_code(500);
			echo json_encode(['success' => FALSE, 'message' => 'Failed to create request']);
			return;
		}

		// ===== CREATE UNIFIED ORDER RECORD =====
		$order_id = NULL;
		$chatID = NULL;
		if ($request_id) {
			$order_data = [
				$order_link_field => intval($request_id),
				'createdAt' => date('Y-m-d H:i:s')
			];

			try {
				$insert_result = $this->db->insert('orders', $order_data);

				if ($insert_result) {
					$order_id = $this->db->insert_id();
					log_message('info', "Order created successfully: Order ID={$order_id}, {$order_link_field}={$request_id}");
				} else {
					$db_error = $this->db->error();
					log_message('error', "Order insertion FAILED: " . json_encode($db_error));
				}
			} catch (Exception $order_error) {
				log_message('error', "Exception during order insert: " . $order_error->getMessage());
			}
		}

		// ===== CREATE CHAT IMMEDIATELY =====
		$this->load->model('Chat_model');
		$this->load->helper('notification');

		// Only create chat if order was successfully created
		if ($order_id) {
			$chatID = $this->Chat_model->create_chat($order_id, $buyer_user_id, $seller_company_id);

			$company_admin = $this->db->select('userID')
				->from('companydetail')
				->where('companyID', $seller_company_id)
				->get()
				->row();
			if (!empty($company_admin->userID)) {
				send_notification((int)$company_admin->userID, 'rental_request_created', (int)$order_id);
			}
			send_notification((int)$buyer_user_id, 'rental_request_created', (int)$order_id);

			if ($chatID) {
				log_message('info', "Chat created immediately for request {$request_id} with order {$order_id}: Chat ID {$chatID}");

				// Send order summary FROM THE BUYER so the seller can see the full request details
				$order_type = ($sale_type == 0) ? 'Rental' : 'Purchase';
				$buyer_order_msg = "New Order Request\n\n"
				                 . "Item: " . $product_name . "\n"
				                 . "Type: " . $order_type . "\n"
				                 . "Quantity: " . $quantity . "\n"
				                 . "Total: $" . number_format($total_amount, 2);
				if ($sale_type == 0 && !empty($start_date) && !empty($end_date)) {
					$buyer_order_msg .= "\nRental Period: " . $start_date . " to " . $end_date;
				}
				if (!empty($delivery_city)) {
					$location = trim(($delivery_name ? $delivery_name . ', ' : '') . $delivery_city . ($delivery_country ? ', ' . $delivery_country : ''));
					$buyer_order_msg .= "\nDelivery to: " . $location;
				}
				$buyer_order_msg .= "\n\nPlease review and approve my order request.";

				$this->Chat_model->send_automated_message_as_user($chatID, $buyer_order_msg, $buyer_user_id);
			} else {
				log_message('error', "Failed to create chat for order {$order_id} ({$order_link_field} {$request_id})");
			}
		} else {
			log_message('error', "Cannot create chat - Order ID is null for {$order_link_field} {$request_id}");
		}

		// ===== RETURN SUCCESS =====
		http_response_code(200);
		echo json_encode([
			'success' => TRUE,
			'message' => 'Request submitted successfully',
			'request_id' => $request_id,
			'order_id' => $order_id,
			'chat_id' => $chatID,
			'status' => 'pending_approval'
		]);

		log_message('info', "Request {$request_id} created by user {$buyer_user_id} for item {$item_id} (type {$item_type})");
			
		} catch (Exception $e) {
			header('Content-Type: application/json');
			http_response_code(500);
			echo json_encode([
				'success' => FALSE,
				'message' => 'Error: ' . $e->getMessage()
			]);
			log_message('error', 'Purchase Request Error: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
		}
	}

	/**
	 * Token-based checkout for approved purchase requests
	 * 
	 * @param string $token Unique checkout token from approval
	 * 
	 * Flow:
	 * 1. Verify token exists and hasn't expired
	 * 2. Verify orderStatus = 'payment_pending'
	 * 3. Load order details from database
	 * 4. Display checkout page with pre-filled data
	 * 5. User completes payment (handled by prepare_payment_from_token)
	 */
	public function pay_with_token($token)
	{
		// ===== SECURITY CHECK: USER MUST BE LOGGED IN =====
		$login_data = $this->session->userdata('loginData');
		if (!$login_data) {
			$this->session->set_flashdata('error', 'Please log in to complete your payment');
			redirect(base_url('login'));
			return;
		}

		$user_id = intval($login_data['userID'] ?? 0);

		// ===== STEP 1: VALIDATE TOKEN =====
		if (!$token || strlen($token) !== 64) {
			show_error('Invalid checkout token', 400);
			return;
		}

		// ===== STEP 2: FETCH ORDER BY TOKEN =====
		$order = $this->db->select('o.orderID, ep.*, e.equipName, e.equipDesc, e.equipImg,
		                           si.itemID, si.itemType, si.saleType,
		                           cd.companyName as sellerCompanyName,
		                           se.equipQty, se.eqpRentalType, se.eqpPrice, se.eqpDeliveryOpt, se.deliveryChargeBearer, se.deliveryCharge, se.eqpAdd, se.eqpLocCity, se.eqpRules')
			->from('orders o')
			->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'inner')
			->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
			->join('shopitem si', 'ep.itemID = si.itemID', 'left')
			->join('companydetail cd', 'ep.sellerCompanyID = cd.companyID', 'left')
			->join('shopequipments se', 'si.itemID = se.itemID', 'left')
			->where('ep.checkoutToken', $token)
			->where('ep.buyerUserID', $user_id)
			->get()
			->row();

		$is_workforce_checkout = false;
		if (!$order) {
			$workforce_candidate = $this->db->select('o.orderID, wp.*, wf.personName, wf.personAddInfo,
			    si.itemID, si.itemType, 0 as saleType,
			    cd.companyName as sellerCompanyName,
			    sw.workforceRentalType, sw.workforcePrice, sw.workforceDeliveryOpt, sw.deliveryChargeBearer, sw.deliveryCharge, sw.WorkforceAdd, sw.workforceCity, sw.workforceRules')
				->from('orders o')
				->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'inner')
				->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
				->join('shopitem si', 'wp.itemID = si.itemID', 'left')
				->join('companydetail cd', 'wp.sellerCompanyID = cd.companyID', 'left')
				->join('shopworkforce sw', 'si.itemID = sw.itemID', 'left')
				->where('wp.buyerUserID', $user_id)
				->like('wp.paymentMetadata', '"checkout_token":"' . $this->db->escape_like_str($token) . '"')
				->order_by('wp.workforcePaymentID', 'DESC')
				->get()
				->row();

			if ($workforce_candidate) {
				$wf_meta = json_decode((string)($workforce_candidate->paymentMetadata ?? '{}'), true);
				if (is_array($wf_meta) && !empty($wf_meta['checkout_token']) && hash_equals((string)$wf_meta['checkout_token'], (string)$token)) {
					$order = $workforce_candidate;
					$is_workforce_checkout = true;
				}
			}
		}

		if (!$order) {
			show_error('Checkout link not found or you do not have permission to access it', 404);
			return;
		}

		// Equipment purchase links expire after 7 days. Rental links remain non-expiring.
		$is_purchase = strtolower((string)($order->saleType ?? '')) === 'purchase'
			|| intval($order->saleType ?? -1) === 1;
		if ($is_purchase) {
			$wf_meta = [];
			if ($is_workforce_checkout) {
				$wf_meta = json_decode((string)($order->paymentMetadata ?? '{}'), true);
				if (!is_array($wf_meta)) {
					$wf_meta = [];
				}
			}

			$expiry_source = $is_workforce_checkout
				? ($wf_meta['checkout_token_expiry'] ?? null)
				: ($order->checkoutTokenExpiry ?? null);

			$expiry_ts = !empty($expiry_source)
				? strtotime($expiry_source)
				: (!empty($order->approvedAt) ? strtotime($order->approvedAt . ' +7 days') : strtotime($order->createdAt . ' +7 days'));
			if ($expiry_ts && time() > $expiry_ts) {
				$this->session->set_flashdata('error', 'This payment link has expired. Please request a new payment link from the seller.');
				redirect(base_url('orders'));
				return;
			}
		}

		// ===== STEP 3: VALIDATE ORDER STATUS =====
		if ($order->orderStatus !== 'payment_pending') {
			$status_messages = [
				'requested' => 'This request is still pending seller approval.',
				'rejected' => 'This request was rejected by the seller.',
				'payment_secured' => 'Payment has already been completed for this order.',
				'shipped' => 'This order has already been paid and shipped.',
				'delivered' => 'This order has already been completed.',
				'completed' => 'This order has already been completed.',
				'cancelled' => 'This order was cancelled.',
				'refunded' => 'This order was refunded.'
			];

			$message = $status_messages[$order->orderStatus] ?? 'This checkout link is no longer valid.';
			$this->session->set_flashdata('error', $message);
			redirect(base_url('orders'));
			return;
		}

		// ===== STEP 5: PREPARE ORDER DATA FOR CHECKOUT VIEW =====
		// paymentMetadata may store split amounts from request creation/update flow
		$payment_metadata = json_decode($order->paymentMetadata ?? '{}', TRUE);
		if (!is_array($payment_metadata)) {
			$payment_metadata = [];
		}

		$metadata_equipment_amount = floatval($payment_metadata['equipment_amount'] ?? 0);
		$metadata_delivery_amount = floatval($payment_metadata['delivery_amount'] ?? 0);

		// Subtotal should represent equipment/rental only; delivery is shown and added dynamically in view
		if ($metadata_equipment_amount > 0) {
			$subtotal = $metadata_equipment_amount;
		} else if ($metadata_delivery_amount > 0) {
			$subtotal = max(0, floatval($order->grossAmount) - $metadata_delivery_amount);
		} else {
			$subtotal = floatval($order->grossAmount);
		}

		$delivery_charge = $metadata_delivery_amount > 0
			? $metadata_delivery_amount
			: floatval($order->deliveryCharge ?? 0);
		$delivery_charge_bearer = intval($order->deliveryChargeBearer ?? 0);
		$commission_percent = floatval($order->commissionPercent);
		$commission_amount = floatval($order->commissionAmount);

		// Determine rental days if applicable
		$rental_days = 0;
		if ($order->saleType == 0 && $order->rentalStartDate && $order->rentalEndDate) {
			$start = strtotime($order->rentalStartDate);
			$end = strtotime($order->rentalEndDate);
			$rental_days = $this->_calculate_inclusive_rental_days($order->rentalStartDate, $order->rentalEndDate);
		}

		$order_data = [
			'order_id' => intval($order->orderID ?? 0),
			'equipment_payment_id' => $is_workforce_checkout ? null : ($order->equipmentPaymentID ?? null),
			'workforce_payment_id' => $is_workforce_checkout ? ($order->workforcePaymentID ?? null) : null,
			'checkout_token' => $token,
			'item_id' => $order->itemID,
			'item_type' => $is_workforce_checkout ? 2 : 1,
			'sale_type' => $is_workforce_checkout ? 0 : ($order->saleType === 'rental' ? 0 : 1),
			'product_name' => $is_workforce_checkout ? ($order->personName ?? 'Workforce') : ($order->equipName ?? 'Equipment'),
			'product_description' => $is_workforce_checkout ? ($order->personAddInfo ?? '') : ($order->equipDesc ?? ''),
			'product_image' => $is_workforce_checkout ? '' : ($order->equipImg ?? ''),
			'product_sku' => $is_workforce_checkout ? ('WF-' . intval($order->workforceID ?? 0)) : ('EQ-' . intval($order->equipmentID ?? 0)),
			'quantity' => intval($is_workforce_checkout ? 1 : ($order->quantity ?? 1)),
			'unit_price' => $subtotal / max(1, intval($is_workforce_checkout ? 1 : ($order->quantity ?? 1))),
			'rental_start_date' => $order->rentalStartDate,
			'rental_end_date' => $order->rentalEndDate,
			'rental_days' => $rental_days,
			'subtotal' => $subtotal,
			'commission_percent' => $commission_percent,
			'commission_amount' => $commission_amount,
			'tax_amount' => 0,
			'total' => $subtotal,
			'seller_company' => $order->sellerCompanyName,
			'delivery_option' => intval($is_workforce_checkout ? ($order->workforceDeliveryOpt ?? 2) : ($order->eqpDeliveryOpt ?? 2)),
			'delivery_charge_bearer' => $delivery_charge_bearer,
			'delivery_charge' => $delivery_charge,
			'pickup_address' => $is_workforce_checkout ? ($order->WorkforceAdd ?? 'Address not available') : ($order->eqpAdd ?? 'Address not available'),
			'pickup_city' => $is_workforce_checkout ? ($order->workforceCity ?? 'City not available') : ($order->eqpLocCity ?? 'City not available'),
			'equipment_rules' => $is_workforce_checkout ? ($order->workforceRules ?? '') : ($order->eqpRules ?? ''),
			'pre_filled' => true,
		];

		// Get Stripe public key
		$stripe_public_key = $this->stripeservice->getPublishableKey();

		$data = [
			'order' => $order_data,
			'csrf_token_name' => $this->security->get_csrf_token_name(),
			'csrf_token_value' => $this->security->get_csrf_hash(),
			'stripe_public_key' => $stripe_public_key,
		];

		// ===== STEP 6: LOAD CHECKOUT VIEW =====
		$this->load->view('components/websiteHeader', $data);
		$this->load->view('website/checkout_view', $data);
		$this->load->view('components/websiteFooter', $data);

		$log_payment_id = $is_workforce_checkout ? intval($order->workforcePaymentID ?? 0) : intval($order->equipmentPaymentID ?? 0);
		$log_order_id = intval($order->orderID ?? 0);
		$log_type = $is_workforce_checkout ? 'workforce' : 'equipment';
		log_message('info', "User {$user_id} accessed checkout with token for {$log_type} payment {$log_payment_id}, order {$log_order_id}");
	}
}
