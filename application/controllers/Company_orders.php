<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Company_orders Controller
 * 
 * Handles order management for company admins
 * Allows review and approval/rejection of purchase requests
 */
class Company_orders extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->model('Company_order_model');
        $this->load->model('Chat_model');
        $this->load->helper('notification');
        $this->load->helper('invoice');
        
        // Ensure only company admins can access
        $login_data = $this->session->userdata('loginData');
        if (!$login_data || $login_data['userType'] != 2) {
            show_error('Access denied. Company admin access required.', 403);
        }
    }

    /**
     * Display all purchase requests for company's equipment
     */
    public function index()
    {
        $login_data = $this->session->userdata('loginData');
        $user_id = $login_data['userID'];
        
        // Get company ID for logged-in admin
        $company = $this->db->select('companyID')
                            ->from('companydetail')
                            ->where('userID', $user_id)
                            ->get()
                            ->row();
        
        if (!$company) {
            show_error('Company not found', 404);
            return;
        }
        
        $company_id = $company->companyID;
        
        // Get filters from query string
        $filter = $this->input->get('status', TRUE);
        $type_filter = strtolower(trim((string)$this->input->get('type', TRUE)));
        if (!in_array($type_filter, ['rental', 'purchase'], true)) {
            $type_filter = '';
        }
        
        // Get all orders for this company
        $data['orders'] = $this->Company_order_model->get_company_orders($company_id, $filter, $type_filter);
        foreach ($data['orders'] as $order_row) {
            if (strtolower((string)($order_row->rentalLifecycleStatus ?? '')) !== 'under_review') {
                continue;
            }

            if (!empty($order_row->equipmentPaymentID)) {
                $restored = $this->normalize_payment_issue_status('equipment_payments', 'equipmentPaymentID', (int)$order_row->equipmentPaymentID);
            } elseif (!empty($order_row->workforcePaymentID)) {
                $restored = $this->normalize_payment_issue_status('workforce_payments', 'workforcePaymentID', (int)$order_row->workforcePaymentID);
            } else {
                $restored = null;
            }

            if (!empty($restored)) {
                $order_row->rentalLifecycleStatus = $restored;
            }
        }
        $data['filter'] = $filter;
        $data['filter_type'] = $type_filter;
        $data['company_id'] = $company_id;
        
        // Load view
        $this->load->view('company/orders_list', $data);
    }

    /**
     * View detailed order information
     */
    public function view($order_id)
    {
        $login_data = $this->session->userdata('loginData');
        $user_id = $login_data['userID'];
        
        // Get company ID
        $company = $this->db->select('companyID')
                            ->from('companydetail')
                            ->where('userID', $user_id)
                            ->get()
                            ->row();
        
        if (!$company) {
            show_error('Company not found', 404);
            return;
        }
        
        // Get order details - verify it belongs to this company
        $order = $this->Company_order_model->get_order_detail($order_id, $company->companyID);
        
        if (!$order) {
            // Backward compatibility: some stale links may still pass payment IDs.
            $legacy = $this->db->select('o.orderID')
                ->from('orders o')
                ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
                ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
                ->group_start()
                    ->where('o.equipmentPaymentID', $order_id)
                    ->or_where('o.workforcePaymentID', $order_id)
                ->group_end()
                ->group_start()
                    ->where('ep.sellerCompanyID', $company->companyID)
                    ->or_where('wp.sellerCompanyID', $company->companyID)
                ->group_end()
                ->get()
                ->row();

            if ($legacy && !empty($legacy->orderID)) {
                redirect('company-orders/view/' . intval($legacy->orderID));
                return;
            }

            show_error('Order not found or access denied', 404);
            return;
        }

        if (!empty($order->equipmentPaymentID)) {
            $restored = $this->normalize_payment_issue_status('equipment_payments', 'equipmentPaymentID', (int)$order->equipmentPaymentID);
        } elseif (!empty($order->workforcePaymentID)) {
            $restored = $this->normalize_payment_issue_status('workforce_payments', 'workforcePaymentID', (int)$order->workforcePaymentID);
        } else {
            $restored = null;
        }

        if (!empty($restored)) {
            $order->rentalRequestStatus = $restored;
        }
        
        // Convert object to array for easier access in view
        $data['order'] = (array) $order;

        // Build images array - try shopequipments first, fallback to equipment main image
        $images = [];
        if (!empty($order->itemID)) {
            $shop_eq = $this->db->select([
                'eqpimg1','eqpimg2','eqpimg3','eqpimg4','eqpimg5',
                'eqpimg6','eqpimg7','eqpimg8','eqpimg9','eqpimg10'
            ])->from('shopequipments')->where('itemID', $order->itemID)->limit(1)->get()->row();
            if ($shop_eq) {
                for ($i = 1; $i <= 10; $i++) {
                    $f = 'eqpimg' . $i;
                    if (!empty($shop_eq->$f)) $images[] = 'assets/website/images/' . $shop_eq->$f;
                }
            }
        }
        if (empty($images) && !empty($order->equipmentID)) {
            $shop_eq = $this->db->select([
                'eqpimg1','eqpimg2','eqpimg3','eqpimg4','eqpimg5',
                'eqpimg6','eqpimg7','eqpimg8','eqpimg9','eqpimg10'
            ])->from('shopequipments')->where('equipmentID', $order->equipmentID)->limit(1)->get()->row();
            if ($shop_eq) {
                for ($i = 1; $i <= 10; $i++) {
                    $f = 'eqpimg' . $i;
                    if (!empty($shop_eq->$f)) $images[] = 'assets/website/images/' . $shop_eq->$f;
                }
            }
        }
        if (empty($images) && !empty($order->equipImage)) {
            $images[] = 'assets/website/images/' . $order->equipImage;
        }
        $data['images'] = $images;
        $data['can_download_invoice'] = invoice_can_download($order);

        $this->load->model('Issue_model');
        $data['order_issues'] = $this->Issue_model->getIssuesForOrder((int)$order_id);
        $this->load->library('review_service');
        $this->load->model('Review_model');
        $data['review_context'] = $this->review_service->get_order_review_context((int)$order_id, (int)$user_id);
        $data['order_reviews'] = $this->Review_model->get_order_reviews((int)$order_id);
        $data['my_review'] = $this->Review_model->get_by_order_and_reviewer((int)$order_id, (int)$user_id);

        // Load view
        $this->load->view('company/order_detail', $data);
    }

    /**
     * Download invoice PDF for an order owned by the company.
     *
     * @param int $order_id
     * @return void
     */
    public function invoice($order_id)
    {
        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            redirect('login');
            return;
        }

        if (!is_numeric($order_id)) {
            show_404();
            return;
        }

        $company = $this->db->select('companyID')
            ->from('companydetail')
            ->where('userID', (int)$login_data['userID'])
            ->get()
            ->row();

        if (!$company) {
            show_error('Company not found', 404);
            return;
        }

        $order = $this->get_invoice_order_for_company((int)$order_id, (int)$company->companyID);
        if (!$order) {
            show_404();
            return;
        }

        if (!invoice_can_download($order)) {
            $this->session->set_flashdata('error', 'Invoice is available only after payment is completed.');
            redirect('company-orders/view/' . (int)$order_id);
            return;
        }

        $invoice_data = invoice_build_payload($order);
        $this->stream_invoice_pdf($invoice_data);
    }

    /**
     * Accept a purchase request
     * POST only, CSRF protected
     */
    public function accept()
    {
        // Verify POST method
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error('Invalid request method', 405);
            return;
        }
        
        $login_data = $this->session->userdata('loginData');
        $user_id = $login_data['userID'];
        
        // Get company ID
        $company = $this->db->select('companyID')
                            ->from('companydetail')
                            ->where('userID', $user_id)
                            ->get()
                            ->row();
        
        if (!$company) {
            $this->session->set_flashdata('error', 'Company not found');
            redirect('company-orders');
            return;
        }
        
        $order_id = $this->input->post('order_id', TRUE);
        $order_id = intval($order_id);
        
        if (!$order_id) {
            $this->session->set_flashdata('error', 'Invalid order ID');
            redirect('company-orders');
            return;
        }
        
        // Verify order belongs to this company and is in requested status
        $order = $this->Company_order_model->get_order_detail($order_id, $company->companyID);
        
        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found or access denied');
            redirect('company-orders');
            return;
        }
        
        $order_status = strtolower((string)($order->orderStatus ?? ''));
        $rental_status = strtolower((string)($order->rentalRequestStatus ?? ''));
        $sale_type_value = strtolower((string)($order->saleType ?? ''));
        $is_rental_order = (($order->orderType ?? '') === 'workforce')
            || ((($order->orderType ?? '') === 'equipment') && in_array($sale_type_value, ['rental', '0', '2'], true));

        $is_pending_request = $is_rental_order
            ? in_array($rental_status, ['request_pending'], true)
            : in_array($order_status, ['requested'], true);

        if (!$is_pending_request) {
            $this->session->set_flashdata('error', 'Order cannot be modified - already processed');
            redirect('company-orders');
            return;
        }
        
        // Generate unique checkout token
        $checkout_token = bin2hex(random_bytes(32)); // 64-character token
        $sale_type_value = strtolower((string)($order->saleType ?? ''));
        $is_equipment_purchase = (($order->orderType ?? '') === 'equipment')
            && ($sale_type_value === 'purchase' || $sale_type_value === '1');
        $is_equipment_rental = (($order->orderType ?? '') === 'equipment')
            && ($sale_type_value === 'rental' || $sale_type_value === '2');
        $is_workforce_rental = (($order->orderType ?? '') === 'workforce');
        $token_expiry = $is_equipment_purchase
            ? date('Y-m-d H:i:s', strtotime('+7 days'))
            : null;

        // For rentals, lock quantities via Payment_model before approving
        $this->load->model('Payment_model');

        if ($is_equipment_rental && !empty($order->equipmentPaymentID)) {
            // Lock equipment quantity for rental
            $lock_result = $this->Payment_model->approveRentalRequest(
                (int)$order->equipmentPaymentID,
                $user_id,
                'equipment'
            );
            if (!$lock_result) {
                $this->session->set_flashdata('error', 'Failed to lock equipment quantity. Insufficient inventory or quantity already locked.');
                redirect('company-orders/view/' . $order_id);
                return;
            }
            log_message('info', "Locked equipment quantity for order {$order_id} (payment ID {$order->equipmentPaymentID})");
        } elseif ($is_workforce_rental && !empty($order->workforcePaymentID)) {
            // Mark workforce as approved (this checks availability)
            $lock_result = $this->Payment_model->approveRentalRequest(
                (int)$order->workforcePaymentID,
                $user_id,
                'workforce'
            );
            if (!$lock_result) {
                $this->session->set_flashdata('error', 'Failed to approve workforce rental. Workforce may already be booked.');
                redirect('company-orders/view/' . $order_id);
                return;
            }
            log_message('info', "Approved workforce rental for order {$order_id} (payment ID {$order->workforcePaymentID})");
        }

        // Update order status to payment_pending with checkout token
        $result = $this->Company_order_model->approve_order(
            $order_id,
            $user_id,
            $checkout_token,
            $token_expiry
        );
        
        if ($result) {
            // Send automated chat message with checkout link
            $checkout_url = site_url('checkout/pay/' . $checkout_token);
            $message = "Your purchase request has been approved!\n\n"
                     . "You can now complete your payment using this secure link:\n"
                     . $checkout_url . "\n\n"
                            . ($is_equipment_purchase
                                ? "This link will expire in 7 days.\n\n"
                                : "This link does not expire.\n\n")
                     . "If you have any questions, feel free to message us!";
            
            // Send message via Chat model
            $this->Chat_model->send_automated_message(
                $order->chatID,
                $message,
                $company->companyID,
                'system'
            );

            // Notify renter in notification center (main UI path).
            if (!empty($order->buyerUserID)) {
                send_notification((int)$order->buyerUserID, 'rental_approved', (int)$order_id);
            }
            
            $this->session->set_flashdata('success', 'Purchase request approved successfully. Checkout link sent to buyer.');
            log_message('info', "Company admin {$user_id} approved order {$order_id} - Checkout token: {$checkout_token}");
        } else {
            $this->session->set_flashdata('error', 'Failed to update order status');
        }
        
        redirect('company-orders');
    }

    /**
     * Reject a purchase request
     * POST only, CSRF protected
     */
    public function reject()
    {
        // Verify POST method
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error('Invalid request method', 405);
            return;
        }
        
        $login_data = $this->session->userdata('loginData');
        $user_id = $login_data['userID'];
        
        // Get company ID
        $company = $this->db->select('companyID')
                            ->from('companydetail')
                            ->where('userID', $user_id)
                            ->get()
                            ->row();
        
        if (!$company) {
            $this->session->set_flashdata('error', 'Company not found');
            redirect('company-orders');
            return;
        }
        
        $order_id = $this->input->post('order_id', TRUE);
        $rejection_reason = $this->input->post('rejection_reason', TRUE);
        $order_id = intval($order_id);
        
        if (!$order_id) {
            $this->session->set_flashdata('error', 'Invalid order ID');
            redirect('company-orders');
            return;
        }
        
        // Verify order belongs to this company and is in pending status
        $order = $this->Company_order_model->get_order_detail($order_id, $company->companyID);
        
        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found or access denied');
            redirect('company-orders');
            return;
        }
        
        $order_status = strtolower((string)($order->orderStatus ?? ''));
        $rental_status = strtolower((string)($order->rentalRequestStatus ?? ''));
        $sale_type_value = strtolower((string)($order->saleType ?? ''));
        $is_rental_order = (($order->orderType ?? '') === 'workforce')
            || ((($order->orderType ?? '') === 'equipment') && in_array($sale_type_value, ['rental', '0', '2'], true));

        $is_pending_request = $is_rental_order
            ? in_array($rental_status, ['request_pending'], true)
            : in_array($order_status, ['requested'], true);

        if (!$is_pending_request) {
            $this->session->set_flashdata('error', 'Order cannot be modified - already processed');
            redirect('company-orders');
            return;
        }
        
        // Reject the order
        $result = $this->Company_order_model->reject_order($order_id, $user_id, $rejection_reason);
        
        if ($result) {
            // Send automated chat message
            $message = "Your purchase request has been declined.\n\n";
            if ($rejection_reason) {
                $message .= "Reason: " . $rejection_reason . "\n\n";
            }
            $message .= "If you have any questions or would like to discuss alternatives, feel free to message us here.";
            
            $this->Chat_model->send_automated_message(
                $order->chatID,
                $message,
                $company->companyID,
                'system'
            );

            // Notify renter in notification center (main UI path).
            if (!empty($order->buyerUserID)) {
                send_notification((int)$order->buyerUserID, 'rental_rejected', (int)$order_id);
            }
            
            $this->session->set_flashdata('success', 'Purchase request rejected. Buyer has been notified.');
            log_message('info', "Company admin {$user_id} rejected order {$order_id}");
        } else {
            $this->session->set_flashdata('error', 'Failed to update order status');
        }
        
        redirect('company-orders');
    }

    /**
     * Mark order as shipped
     * POST only, CSRF protected
     */
    public function mark_shipped()
    {
        // Verify POST method
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error('Invalid request method', 405);
            return;
        }
        
        // ===== SECURITY CHECK: USER MUST BE LOGGED IN =====
        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            $this->session->set_flashdata('error', 'Please log in to continue');
            redirect('login');
            return;
        }
        
        $user_id = $login_data['userID'];
        
        // Get company ID
        $company = $this->db->select('companyID')
                            ->from('companydetail')
                            ->where('userID', $user_id)
                            ->get()
                            ->row();
        
        if (!$company) {
            $this->session->set_flashdata('error', 'Company not found');
            redirect('company-orders');
            return;
        }
        
        $order_id = $this->input->post('order_id', TRUE);
        $tracking_number = $this->input->post('tracking_number', TRUE);
        $shipping_notes = $this->input->post('shipping_notes', TRUE);
        $order_id = intval($order_id);
        
        if (!$order_id) {
            $this->session->set_flashdata('error', 'Invalid order ID');
            redirect('company-orders');
            return;
        }
        
        // Verify order belongs to this company and is in payment_secured status
        $order = $this->Company_order_model->get_order_detail($order_id, $company->companyID);
        
        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found or access denied');
            redirect('company-orders');
            return;
        }
        
        if ($order->orderStatus !== 'payment_secured') {
            $this->session->set_flashdata('error', 'Order cannot be shipped - payment not secured yet. Current status: ' . $order->orderStatus);
            redirect('company-orders');
            return;
        }

        // Guard: only delivery orders can be marked as shipped
        $meta = json_decode($order->paymentMetadata ?? '{}', true);
        if (intval($meta['delivery_method'] ?? 0) === 1) {
            // This is a pickup order - use allow_pickup instead
            $this->session->set_flashdata('error', 'This is a pickup order. Use "Allow Pickup" instead of shipping.');
            redirect('company-orders/view/' . $order_id);
            return;
        }
        
        // Update order status to in_progress
        $result = $this->Company_order_model->mark_as_shipped(
            $order_id,
            $user_id,
            $tracking_number,
            $shipping_notes
        );
        
        if ($result) {
            // Ensure Chat_model is loaded
            $this->load->model('Chat_model');
            
            // Send automated chat message to buyer
            $message = "Your order has been shipped!\n\n"
                     . "Order #" . $order_id . "\n";
            
            if ($tracking_number) {
                $message .= "Tracking Number: " . $tracking_number . "\n";
            }
            
            if ($shipping_notes) {
                $message .= "\nShipping Notes:\n" . $shipping_notes . "\n";
            }
            
            $message .= "\nOnce you receive your order, please confirm delivery in your orders dashboard to mark the order as completed.";
            
            // Send message via chat
            if (isset($order->chatID) && $order->chatID) {
                $this->Chat_model->send_automated_message(
                    $order->chatID,
                    $message,
                    $company->companyID,
                    'system'
                );
            }
            
            $this->session->set_flashdata('success', 'Order marked as shipped successfully. Buyer has been notified.');
            log_message('info', "Company admin {$user_id} marked order {$order_id} as shipped with status in_progress");
        } else {
            $this->session->set_flashdata('error', 'Failed to update order status');
            log_message('error', "Failed to mark order {$order_id} as shipped for company {$company->companyID}");
        }
        
        redirect('company-orders');
    }

    /**
    * Allow pickup for a pickup order (payment_secured -> pickup_ready)
     * POST only, CSRF protected
     */
    public function allow_pickup()
    {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error('Invalid request method', 405);
            return;
        }

        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            $this->session->set_flashdata('error', 'Please log in to continue');
            redirect('login');
            return;
        }

        $user_id = $login_data['userID'];

        $company = $this->db->select('companyID')
                            ->from('companydetail')
                            ->where('userID', $user_id)
                            ->get()
                            ->row();

        if (!$company) {
            $this->session->set_flashdata('error', 'Company not found');
            redirect('company-orders');
            return;
        }

        $order_id = intval($this->input->post('order_id', TRUE));

        if (!$order_id) {
            $this->session->set_flashdata('error', 'Invalid order ID');
            redirect('company-orders');
            return;
        }

        $order = $this->Company_order_model->get_order_detail($order_id, $company->companyID);

        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found or access denied');
            redirect('company-orders');
            return;
        }

        if ($order->orderStatus !== 'payment_secured') {
            $this->session->set_flashdata('error', 'Order cannot be processed - payment not secured yet. Current status: ' . $order->orderStatus);
            redirect('company-orders');
            return;
        }

        // Confirm this is actually a pickup order
        $meta = json_decode($order->paymentMetadata ?? '{}', true);
        if (($meta['delivery_method'] ?? 0) != 1) {
            $this->session->set_flashdata('error', 'This action is only available for pickup orders.');
            redirect('company-orders/view/' . $order_id);
            return;
        }

        $result = $this->Company_order_model->mark_as_pickup_ready($order_id, $user_id);

        if ($result) {
            $this->load->model('Chat_model');

            $message = "Your order is ready for pickup!\n\n"
                     . "Order #" . $order_id . "\n"
                     . "Please visit us at our location to collect your item.\n\n"
                     . "Once you have picked up the order, please confirm pickup in your orders dashboard to complete the transaction.";

            if (isset($order->chatID) && $order->chatID) {
                $this->Chat_model->send_automated_message(
                    $order->chatID,
                    $message,
                    $company->companyID,
                    'system'
                );
            }

            $this->session->set_flashdata('success', 'Pickup approved. Buyer has been notified to collect the order.');
            log_message('info', "Company admin {$user_id} allowed pickup for order {$order_id}");
        } else {
            $this->session->set_flashdata('error', 'Failed to update order status');
        }

        redirect('company-orders');
    }

    /**
     * API: Company admin reports a rental issue
     * POST /company-orders/api_report_issue
     */
    public function api_report_issue()
    {
        if (!class_exists('Issues', false)) {
            require_once APPPATH . 'controllers/Issues.php';
        }

        $this->load->model('Issue_model');
        $this->load->model('Payment_model');
        $this->load->model('Chat_model');
        $this->load->model('Notification_model');
        $this->load->helper(['notification', 'status_display']);

        $issues_ctrl = new Issues();
        $issues_ctrl->api_create_issue();
    }

    /**
     * API: Company admin approves rental request and sends payment link
     * POST /company-orders/api_approve_rental
     */
    public function api_approve_rental()
    {
        header('Content-Type: application/json');

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'POST required']);
            return;
        }

        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $admin_user_id = intval($login_data['userID']);
        $payment_id = intval($this->input->post('payment_id', TRUE));
        $item_type = $this->input->post('item_type', TRUE) === 'workforce' ? 'workforce' : 'equipment';
        if (!$payment_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid payment ID']);
            return;
        }

        $company = $this->db->select('companyID')
            ->from('companydetail')
            ->where('userID', $admin_user_id)
            ->get()->row();

        if (!$company) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Company not found']);
            return;
        }

        $table = $item_type === 'equipment' ? 'equipment_payments' : 'workforce_payments';
        $pk = $item_type === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID';

        $payment = $this->db->select("{$pk}, buyerUserID, sellerCompanyID, rentalRequestStatus, chatID")
            ->from($table)
            ->where($pk, $payment_id)
            ->where('sellerCompanyID', $company->companyID)
            ->get()->row();

        if (!$payment) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Rental payment not found or access denied']);
            return;
        }

        if ($payment->rentalRequestStatus !== 'request_pending') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Only pending requests can be approved']);
            return;
        }

        $this->load->model('Payment_model');
        $this->load->helper('notification');

        $ok = $this->Payment_model->approveRentalRequest($payment_id, $admin_user_id, $item_type);
        if (!$ok) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to approve rental request']);
            return;
        }

        $checkout_token = bin2hex(random_bytes(32));
        $token_expiry = null;
        $this->db->update($table, [
            'checkoutToken' => $checkout_token,
            'checkoutTokenExpiry' => $token_expiry,
            'orderStatus' => 'payment_pending',
            'updatedAt' => date('Y-m-d H:i:s'),
        ], [$pk => $payment_id]);

        $order = $this->db->select('orderID')
            ->from('orders')
            ->where($pk, $payment_id)
            ->get()->row();

        if (!empty($payment->chatID)) {
            $checkout_url = site_url('checkout/pay/' . $checkout_token);
            $message = "Your rental request has been approved!\n\n"
                . "You can now complete your payment using this secure link:\n"
                . $checkout_url . "\n\n"
                . "This link does not expire.\n\n"
                . "If you have any questions, feel free to message us!";

            $this->Chat_model->send_automated_message(
                $payment->chatID,
                $message,
                $company->companyID,
                'system'
            );
        }

        if ($order) {
            send_notification($payment->buyerUserID, 'rental_approved', $order->orderID);
        }

        echo json_encode([
            'success' => true,
                'message' => 'Rental approved. Payment link generated and renter notified.',
            'checkout_token' => $checkout_token,
        ]);
    }

    /**
     * API: Company admin cancels rental
     * POST /company-orders/api_cancel_rental
     */
    public function api_cancel_rental()
    {
        header('Content-Type: application/json');

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'POST required']);
            return;
        }

        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $admin_user_id = intval($login_data['userID']);
        $payment_id = intval($this->input->post('payment_id', TRUE));
        $reason = trim($this->input->post('reason', TRUE) ?: 'Cancelled by owner');
        $item_type = $this->input->post('item_type', TRUE) === 'workforce' ? 'workforce' : 'equipment';

        if (!$payment_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid payment ID']);
            return;
        }

        $company = $this->db->select('companyID')
            ->from('companydetail')
            ->where('userID', $admin_user_id)
            ->get()->row();

        if (!$company) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Company not found']);
            return;
        }

        $table = $item_type === 'equipment' ? 'equipment_payments' : 'workforce_payments';
        $pk = $item_type === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID';

        $select_cols = "{$pk}, buyerUserID, sellerCompanyID, rentalRequestStatus";
        if ($item_type === 'equipment') {
            $select_cols .= ', saleType';
        }
        $payment = $this->db->select($select_cols)
            ->from($table)
            ->where($pk, $payment_id)
            ->where('sellerCompanyID', $company->companyID)
            ->get()->row();

        if (!$payment) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Payment record not found or access denied']);
            return;
        }

        if ($item_type === 'equipment' && strtolower((string)($payment->saleType ?? 'purchase')) !== 'rental') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Cancellation is only available for rental equipment/workforce orders.']);
            return;
        }

        $this->load->model('Payment_model');
        $this->load->helper('notification');

        $result = $this->Payment_model->cancelRental($payment_id, $admin_user_id, $reason, true, $item_type);
        if (!$result['success']) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $result['message']]);
            return;
        }

        $order = $this->db->select('orderID')->from('orders')->where($pk, $payment_id)->get()->row();
        if ($order) {
            $notif_type = ($payment->rentalRequestStatus === 'request_pending') ? 'rental_rejected' : 'rental_cancelled';
            send_notification($payment->buyerUserID, $notif_type, $order->orderID);
        }

        echo json_encode([
            'success' => true,
            'message' => $result['message'],
            'refundable' => !empty($result['refundable']),
            'refund_amount' => floatval($result['refund_amount'] ?? 0),
        ]);
    }

    /**
     * API: Company admin confirms receipt/return
     * POST /company-orders/api_confirm_return
     */
    public function api_confirm_return()
    {
        header('Content-Type: application/json');

        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'POST required']);
            return;
        }

        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $admin_user_id = intval($login_data['userID']);
        $payment_id = intval($this->input->post('payment_id', TRUE));
        $notes = $this->input->post('notes', TRUE) ?? '';
        $item_type = $this->input->post('item_type', TRUE) === 'workforce' ? 'workforce' : 'equipment';

        if (!$payment_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid payment ID']);
            return;
        }

        $company = $this->db->select('companyID')
            ->from('companydetail')
            ->where('userID', $admin_user_id)
            ->get()->row();

        if (!$company) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Company not found']);
            return;
        }

        $table = $item_type === 'equipment' ? 'equipment_payments' : 'workforce_payments';
        $pk = $item_type === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID';

        $payment = $this->db->select("{$pk}, buyerUserID, sellerCompanyID, rentalRequestStatus")
            ->from($table)
            ->where($pk, $payment_id)
            ->where('sellerCompanyID', $company->companyID)
            ->get()->row();

        if (!$payment) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Payment record not found or access denied']);
            return;
        }

        if (!in_array($payment->rentalRequestStatus, ['rental_active', 'return_requested', 'rental_overdue', 'under_review', 'returned_by_renter'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Return can only be confirmed for active, pending-return, overdue, or under-review rentals']);
            return;
        }

        $this->load->model('Payment_model');
        $this->load->helper('notification');

        $result = $this->Payment_model->confirmReturnByOwner($payment_id, $notes, $item_type);
        if (!$result['success']) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $result['message']]);
            return;
        }

        $order = $this->db->select('orderID')->from('orders')->where($pk, $payment_id)->get()->row();
        if ($order) {
            $notif_type = (!empty($result['status']) && $result['status'] === 'rental_completed')
                ? 'rental_completed'
                : 'return_confirmed';
            send_notification($payment->buyerUserID, $notif_type, $order->orderID);
            send_notification($admin_user_id, $notif_type, $order->orderID);
        }

        echo json_encode(['success' => true, 'message' => $result['message']]);
    }

    /**
     * Normalize legacy under_review payment state when no issues are currently open.
     *
     * @param string $table
     * @param string $pk
     * @param int $payment_id
     * @return string|null Restored rental status or null if unchanged.
     */
    private function normalize_payment_issue_status($table, $pk, $payment_id)
    {
        if (empty($payment_id)) {
            return null;
        }

        $payment = $this->db->get_where($table, [$pk => $payment_id])->row();
        if (!$payment) {
            return null;
        }

        $rental_status = strtolower(trim((string)($payment->rentalRequestStatus ?? '')));
        if ($rental_status !== 'under_review') {
            return null;
        }

        if ($table === 'equipment_payments') {
            $this->db->where('equipmentPaymentID', $payment_id);
        } else {
            $this->db->where('workforcePaymentID', $payment_id);
        }
        $open_issue_count = $this->db->where_in('issueStatus', ['reported', 'under_review'])
            ->count_all_results('rental_issues');

        if ($open_issue_count > 0) {
            return null;
        }

        $order_status = strtolower(trim((string)($payment->orderStatus ?? '')));
        $start_ts = !empty($payment->rentalStartDate) ? strtotime($payment->rentalStartDate . ' 00:00:00') : null;
        $end_ts = !empty($payment->rentalEndDate) ? strtotime($payment->rentalEndDate . ' 23:59:59') : null;
        $renter_confirmed = !empty($payment->renterConfirmedReturn);
        $owner_confirmed = !empty($payment->ownerConfirmedReturn);

        $restored_status = 'rental_active';
        if ($renter_confirmed && $owner_confirmed) {
            $restored_status = 'rental_completed';
        } elseif ($renter_confirmed) {
            $restored_status = 'returned_by_renter';
        } elseif ($owner_confirmed) {
            $restored_status = 'received_by_owner';
        } elseif ($start_ts && time() < $start_ts) {
            $restored_status = in_array($order_status, ['request_pending', 'request_approved', 'awaiting_handover'], true)
                ? $order_status
                : 'awaiting_handover';
        } elseif ($end_ts && time() > ($end_ts + (72 * 3600))) {
            $restored_status = 'rental_overdue';
        } elseif ($end_ts && time() > $end_ts) {
            $restored_status = 'return_requested';
        }

        $this->db->update($table, [
            'rentalRequestStatus' => $restored_status,
            'hasActiveIssue' => 0,
            'currentIssueID' => null,
            'updatedAt' => date('Y-m-d H:i:s'),
        ], [$pk => $payment_id]);

        return $restored_status;
    }

    /**
     * Get invoice-ready order data for a company-owned order.
     *
     * @param int $order_id
     * @param int $company_id
     * @return object|null
     */
    private function get_invoice_order_for_company($order_id, $company_id)
    {
        return $this->db->select(" 
            o.orderID,
            o.equipmentPaymentID,
            o.workforcePaymentID,
            COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount,
            COALESCE(ep.commissionPercent, wp.commissionPercent) as commissionPercent,
            COALESCE(ep.commissionAmount, wp.commissionAmount) as commissionAmount,
            COALESCE(ep.netAmount, wp.netAmount) as netAmount,
            COALESCE(ep.currency, wp.currency, 'USD') as currency,
            COALESCE(ep.paymentStatus, wp.paymentStatus) as paymentStatus,
            COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus) as orderStatus,
            COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) as rentalRequestStatus,
            COALESCE(ep.stripePaymentIntentID, wp.stripePaymentIntentID) as stripePaymentIntentID,
            COALESCE(ep.saleType, 'rental') as saleType,
            COALESCE(ep.quantity, DATEDIFF(wp.rentalEndDate, wp.rentalStartDate) + 1) as quantity,
            COALESCE(ep.rentalStartDate, wp.rentalStartDate) as rentalStartDate,
            COALESCE(ep.rentalEndDate, wp.rentalEndDate) as rentalEndDate,
            COALESCE(ep.rentalType, wp.rentalType) as rentalType,
            COALESCE(ep.paymentMetadata, wp.paymentMetadata) as paymentMetadata,
            COALESCE(ep.createdAt, wp.createdAt) as createdAt,
            COALESCE(ep.updatedAt, wp.updatedAt) as updatedAt,
            COALESCE(e.equipName, wf.personName) as itemName,
            buyer.userName as buyerName,
            buyer.userEmail as buyerEmail,
            buyer.userPhone as buyerPhone,
            cd.companyName as sellerCompanyName,
            seller.userName as sellerContactName,
            seller.userEmail as sellerEmail,
            seller.userPhone as sellerPhone
        ", false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('users buyer', 'COALESCE(ep.buyerUserID, wp.buyerUserID) = buyer.userID', 'left')
        ->join('companydetail cd', 'COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) = cd.companyID', 'left')
        ->join('users seller', 'cd.userID = seller.userID', 'left')
        ->where('o.orderID', $order_id)
        ->where('COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) =', $company_id)
        ->get()
        ->row();
    }

    /**
     * Render and download invoice PDF.
     *
     * @param array $invoice_data
     * @return void
     */
    private function stream_invoice_pdf(array $invoice_data)
    {
        if (!class_exists('Dompdf\\Dompdf')) {
            $autoload_path = FCPATH . 'vendor/autoload.php';
            if (!file_exists($autoload_path)) {
                show_error('PDF library is not installed. Please run composer install.', 500);
                return;
            }
            require_once $autoload_path;
        }

        $html = $this->load->view('invoices/order_invoice_pdf', ['invoice' => $invoice_data], true);

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();

        $filename = 'invoice-' . preg_replace('/[^A-Za-z0-9\-_]/', '', (string)$invoice_data['invoice_number']) . '.pdf';
        $this->output
            ->set_content_type('application/pdf')
            ->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
            ->set_output($dompdf->output());
    }
}
