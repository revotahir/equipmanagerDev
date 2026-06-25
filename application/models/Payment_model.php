<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Payment Model - Segregated Payments Version
 * 
 * Handles database operations for segregated equipment and workforce payments
 * with global commission structure
 * 
 * @package    EquipManager
 * @subpackage Models
 * @category   Payment
 * @version    2.0
 */

class Payment_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Generic_model', 'generic');
    }

    // =============================================
    // EQUIPMENT PAYMENT METHODS
    // =============================================

    /**
     * Create equipment payment with commission calculation
     * 
     * @param array $data Payment data
     * @return int|false Payment ID or false on failure
     */
    public function createEquipmentPayment($data)
    {
        // Get global commission rate
        $commission_percent = $this->getGlobalCommissionRate();

        // Extract amounts from data and metadata
        // SECURITY: Always extract component amounts from metadata for validation
        $gross_amount = floatval($data['gross_amount']);
        $equipment_amount = 0;
        $delivery_amount = 0;
        
        // Try to get separated amounts from metadata (new structure)
        if (isset($data['metadata']) && is_array($data['metadata'])) {
            if (isset($data['metadata']['equipment_amount'])) {
                $equipment_amount = floatval($data['metadata']['equipment_amount']);
            }
            if (isset($data['metadata']['delivery_amount'])) {
                $delivery_amount = floatval($data['metadata']['delivery_amount']);
            }
        }
        
        // Validate that amounts add up correctly (security check against manipulation)
        $calculated_total = $equipment_amount + $delivery_amount;
        if (abs($calculated_total - $gross_amount) > 0.01) {
            // Amounts don't match - log error but don't fail (for backwards compatibility)
            log_message('error', "Payment amount mismatch: equipment({$equipment_amount}) + delivery({$delivery_amount}) = {$calculated_total}, but gross_amount = {$gross_amount}");
        }
        
        // Use equipment_amount as subtotal for commission calculation
        // Commission applies ONLY to equipment/rental, NOT to delivery
        $subtotal = max($equipment_amount, $gross_amount - $delivery_amount);
        
        // Commission percentage from system settings
        $commission_amount = round($subtotal * ($commission_percent / 100), 2);
        
        // Net amount = subtotal - commission + delivery (delivery keeps full value, not subject to commission)
        $net_amount = $subtotal - $commission_amount + $delivery_amount;

        $payment_data = [
            'itemID' => $data['item_id'],
            'equipmentID' => $data['equipment_id'],
            'buyerUserID' => $data['buyer_user_id'],
            'sellerCompanyID' => $data['seller_company_id'],
            'stripeSessionID' => isset($data['stripe_session_id']) ? $data['stripe_session_id'] : null,
            'stripePaymentIntentID' => isset($data['stripe_payment_intent_id']) ? $data['stripe_payment_intent_id'] : null,
            'grossAmount' => $gross_amount,
            'commissionPercent' => $commission_percent,
            'commissionAmount' => $commission_amount,
            'netAmount' => $net_amount,
            'currency' => isset($data['currency']) ? $data['currency'] : 'USD',
            'quantity' => isset($data['quantity']) ? $data['quantity'] : 1,
            'saleType' => $data['sale_type'], // 'rental' or 'purchase'
            'rentalStartDate' => isset($data['rental_start_date']) ? $data['rental_start_date'] : null,
            'rentalEndDate' => isset($data['rental_end_date']) ? $data['rental_end_date'] : null,
            'rentalType' => isset($data['rental_type']) ? $data['rental_type'] : null,
            'paymentStatus' => 'pending',
            'paymentMetadata' => isset($data['metadata']) ? json_encode($data['metadata']) : null,
        ];

        $this->generic->InsertData('equipment_payments', $payment_data);
        return $this->db->insert_id();
    }

    /**
     * Update equipment payment status
     * 
     * @param int $payment_id Payment ID
     * @param string $status New status
     * @param array $additional_data Additional fields to update
     * @return bool Success status
     */
    public function updateEquipmentPaymentStatus($payment_id, $status, $additional_data = [])
    {
        $update_data = array_merge(['paymentStatus' => $status], $additional_data);
        $this->generic->Update('equipment_payments', ['equipmentPaymentID' => $payment_id], $update_data);
        return true;
    }

    /**
     * Get equipment payment by ID
     * 
     * @param int $payment_id Payment ID
     * @return array|false Payment data or false
     */
    public function getEquipmentPaymentById($payment_id)
    {
        $result = $this->generic->GetData('equipment_payments', ['equipmentPaymentID' => $payment_id]);
        return $result ? $result[0] : false;
    }

    /**
     * Get equipment payment by Stripe session ID
     * 
     * @param string $session_id Stripe session ID
     * @return array|false Payment data or false
     */
    public function getEquipmentPaymentBySessionId($session_id)
    {
        $result = $this->generic->GetData('equipment_payments', ['stripeSessionID' => $session_id]);
        return $result ? $result[0] : false;
    }

    /**
     * Get equipment payment by Stripe payment intent ID
     * 
     * @param string $payment_intent_id Stripe payment intent ID
     * @return array|false Payment data or false
     */
    public function getEquipmentPaymentByIntentId($payment_intent_id)
    {
        $result = $this->generic->GetData('equipment_payments', ['stripePaymentIntentID' => $payment_intent_id]);
        return $result ? $result[0] : false;
    }

    /**
     * Get equipment payments for a specific buyer
     * 
     * @param int $user_id Buyer user ID
     * @return array|false Payments array or false
     */
    public function getEquipmentPaymentsByBuyer($user_id)
    {
        return $this->generic->GetData('equipment_payments', ['buyerUserID' => $user_id], 'createdAt', 'DESC');
    }

    /**
     * Get equipment payments for a specific company (seller)
     * 
     * @param int $company_id Company ID
     * @return array|false Payments array or false
     */
    public function getEquipmentPaymentsBySeller($company_id)
    {
        return $this->generic->GetData('equipment_payments', ['sellerCompanyID' => $company_id], 'createdAt', 'DESC');
    }

    // =============================================
    // WORKFORCE PAYMENT METHODS
    // =============================================

    /**
     * Create workforce payment with commission calculation
     * 
     * @param array $data Payment data
     * @return int|false Payment ID or false on failure
     */
    public function createWorkforcePayment($data)
    {
        // Get global commission rate
        $commission_percent = $this->getGlobalCommissionRate();

        // Extract amounts from data and metadata
        // SECURITY: Always extract component amounts from metadata for validation
        $gross_amount = floatval($data['gross_amount']);
        $equipment_amount = 0;
        $delivery_amount = 0;
        
        // Try to get separated amounts from metadata (new structure)
        if (isset($data['metadata']) && is_array($data['metadata'])) {
            if (isset($data['metadata']['equipment_amount'])) {
                $equipment_amount = floatval($data['metadata']['equipment_amount']);
            }
            if (isset($data['metadata']['delivery_amount'])) {
                $delivery_amount = floatval($data['metadata']['delivery_amount']);
            }
        }
        
        // Validate that amounts add up correctly (security check against manipulation)
        $calculated_total = $equipment_amount + $delivery_amount;
        if (abs($calculated_total - $gross_amount) > 0.01) {
            // Amounts don't match - log error but don't fail (for backwards compatibility)
            log_message('error', "Payment amount mismatch: equipment({$equipment_amount}) + delivery({$delivery_amount}) = {$calculated_total}, but gross_amount = {$gross_amount}");
        }
        
        // Use equipment_amount as subtotal for commission calculation
        // Commission applies ONLY to workforce service, NOT to delivery
        $subtotal = max($equipment_amount, $gross_amount - $delivery_amount);
        
        // Commission percentage from system settings
        $commission_amount = round($subtotal * ($commission_percent / 100), 2);
        
        // Net amount = subtotal - commission + delivery (delivery keeps full value, not subject to commission)
        $net_amount = $subtotal - $commission_amount + $delivery_amount;

        $payment_data = [
            'itemID' => $data['item_id'],
            'workforceID' => $data['workforce_id'],
            'buyerUserID' => $data['buyer_user_id'],
            'sellerCompanyID' => $data['seller_company_id'],
            'stripeSessionID' => isset($data['stripe_session_id']) ? $data['stripe_session_id'] : null,
            'stripePaymentIntentID' => isset($data['stripe_payment_intent_id']) ? $data['stripe_payment_intent_id'] : null,
            'grossAmount' => $gross_amount,
            'commissionPercent' => $commission_percent,
            'commissionAmount' => $commission_amount,
            'netAmount' => $net_amount,
            'currency' => isset($data['currency']) ? $data['currency'] : 'USD',
            'rentalStartDate' => $data['rental_start_date'],
            'rentalEndDate' => $data['rental_end_date'],
            'rentalType' => $data['rental_type'],
            'paymentStatus' => 'pending',
            'paymentMetadata' => isset($data['metadata']) ? json_encode($data['metadata']) : null,
        ];

        $this->generic->InsertData('workforce_payments', $payment_data);
        return $this->db->insert_id();
    }

    /**
     * Update workforce payment status
     * 
     * @param int $payment_id Payment ID
     * @param string $status New status
     * @param array $additional_data Additional fields to update
     * @return bool Success status
     */
    public function updateWorkforcePaymentStatus($payment_id, $status, $additional_data = [])
    {
        $update_data = array_merge(['paymentStatus' => $status], $additional_data);
        $this->generic->Update('workforce_payments', ['workforcePaymentID' => $payment_id], $update_data);
        return true;
    }

    /**
     * Get workforce payment by ID
     * 
     * @param int $payment_id Payment ID
     * @return array|false Payment data or false
     */
    public function getWorkforcePaymentById($payment_id)
    {
        $result = $this->generic->GetData('workforce_payments', ['workforcePaymentID' => $payment_id]);
        return $result ? $result[0] : false;
    }

    /**
     * Get workforce payment by Stripe session ID
     * 
     * @param string $session_id Stripe session ID
     * @return array|false Payment data or false
     */
    public function getWorkforcePaymentBySessionId($session_id)
    {
        $result = $this->generic->GetData('workforce_payments', ['stripeSessionID' => $session_id]);
        return $result ? $result[0] : false;
    }

    /**
     * Get workforce payment by Stripe payment intent ID
     * 
     * @param string $payment_intent_id Stripe payment intent ID
     * @return array|false Payment data or false
     */
    public function getWorkforcePaymentByIntentId($payment_intent_id)
    {
        $result = $this->generic->GetData('workforce_payments', ['stripePaymentIntentID' => $payment_intent_id]);
        return $result ? $result[0] : false;
    }

    /**
     * Get workforce payments for a specific buyer
     * 
     * @param int $user_id Buyer user ID
     * @return array|false Payments array or false
     */
    public function getWorkforcePaymentsByBuyer($user_id)
    {
        return $this->generic->GetData('workforce_payments', ['buyerUserID' => $user_id], 'createdAt', 'DESC');
    }

    /**
     * Get workforce payments for a specific company (seller)
     * 
     * @param int $company_id Company ID
     * @return array|false Payments array or false
     */
    public function getWorkforcePaymentsBySeller($company_id)
    {
        return $this->generic->GetData('workforce_payments', ['sellerCompanyID' => $company_id], 'createdAt', 'DESC');
    }

    /**
     * Get order details by orderID (unified orders table)
     * 
     * @param int $order_id Order ID from unified orders table
     * @return array|false Order data with payment details or false
     */
    public function getOrderById($order_id)
    {
        return $this->db->select('o.*, 
                                ep.equipmentPaymentID, ep.equipmentID, ep.itemID, ep.buyerUserID, ep.sellerCompanyID,
                                ep.grossAmount, ep.commissionPercent, ep.commissionAmount, ep.netAmount,
                                ep.quantity, ep.saleType, ep.rentalStartDate, ep.rentalEndDate, ep.rentalType,
                                ep.paymentStatus, ep.orderStatus, ep.paymentMetadata,
                                wp.workforcePaymentID, wp.workforceID')
            ->from('orders o')
            ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->where('o.orderID', $order_id)
            ->get()
            ->row();
    }

    // =============================================
    // COMBINED PAYMENT METHODS (for views that show both)
    // =============================================

    /**
     * Get all payments for a buyer (equipment + workforce)
     * 
     * @param int $user_id Buyer user ID
     * @return array Combined payments array with type indicator
     */
    public function getAllPaymentsByBuyer($user_id)
    {
        $equipment = $this->getEquipmentPaymentsByBuyer($user_id);
        $workforce = $this->getWorkforcePaymentsByBuyer($user_id);

        $combined = [];

        if ($equipment) {
            foreach ($equipment as $payment) {
                $payment['paymentType'] = 'equipment';
                $combined[] = $payment;
            }
        }

        if ($workforce) {
            foreach ($workforce as $payment) {
                $payment['paymentType'] = 'workforce';
                $combined[] = $payment;
            }
        }

        // Sort by createdAt DESC
        usort($combined, function ($a, $b) {
            return strtotime($b['createdAt']) - strtotime($a['createdAt']);
        });

        return $combined;
    }

    /**
     * Get all payments for a seller (equipment + workforce)
     * 
     * @param int $company_id Company ID
     * @return array Combined payments array with type indicator
     */
    public function getAllPaymentsBySeller($company_id)
    {
        $equipment = $this->getEquipmentPaymentsBySeller($company_id);
        $workforce = $this->getWorkforcePaymentsBySeller($company_id);

        $combined = [];

        if ($equipment) {
            foreach ($equipment as $payment) {
                $payment['paymentType'] = 'equipment';
                $combined[] = $payment;
            }
        }

        if ($workforce) {
            foreach ($workforce as $payment) {
                $payment['paymentType'] = 'workforce';
                $combined[] = $payment;
            }
        }

        // Sort by createdAt DESC
        usort($combined, function ($a, $b) {
            return strtotime($b['createdAt']) - strtotime($a['createdAt']);
        });

        return $combined;
    }

    // =============================================
    // PAYOUT METHODS
    // =============================================

    /**
     * Create equipment payout
     * 
     * @param int $payment_id Equipment payment ID
     * @param int $company_id Company ID
     * @param float $payout_amount Net amount to payout
     * @return int|false Payout ID or false
     */
    public function createEquipmentPayout($payment_id, $company_id, $payout_amount)
    {
        $payout_data = [
            'equipmentPaymentID' => $payment_id,
            'companyID' => $company_id,
            'payoutAmount' => $payout_amount,
            'payoutStatus' => 'pending',
        ];

        $this->generic->InsertData('equipment_payouts', $payout_data);
        return $this->db->insert_id();
    }

    /**
     * Create workforce payout
     * 
     * @param int $payment_id Workforce payment ID
     * @param int $company_id Company ID
     * @param float $payout_amount Net amount to payout
     * @return int|false Payout ID or false
     */
    public function createWorkforcePayout($payment_id, $company_id, $payout_amount)
    {
        $payout_data = [
            'workforcePaymentID' => $payment_id,
            'companyID' => $company_id,
            'payoutAmount' => $payout_amount,
            'payoutStatus' => 'pending',
        ];

        $this->generic->InsertData('workforce_payouts', $payout_data);
        return $this->db->insert_id();
    }

    /**
     * Update equipment payout status
     * 
     * @param int $payout_id Payout ID
     * @param string $status New status
     * @param int $approved_by SuperAdmin user ID
     * @param string $notes Optional notes
     * @return bool Success status
     */
    public function updateEquipmentPayoutStatus($payout_id, $status, $approved_by = null, $notes = null)
    {
        $update_data = ['payoutStatus' => $status];

        if ($status === 'approved' && $approved_by) {
            $update_data['approvedBy'] = $approved_by;
            $update_data['approvedAt'] = date('Y-m-d H:i:s');
        }

        if ($notes) {
            $update_data['payoutNotes'] = $notes;
        }

        $this->generic->Update('equipment_payouts', ['equipmentPayoutID' => $payout_id], $update_data);
        return true;
    }

    /**
     * Update workforce payout status
     * 
     * @param int $payout_id Payout ID
     * @param string $status New status
     * @param int $approved_by SuperAdmin user ID
     * @param string $notes Optional notes
     * @return bool Success status
     */
    public function updateWorkforcePayoutStatus($payout_id, $status, $approved_by = null, $notes = null)
    {
        $update_data = ['payoutStatus' => $status];

        if ($status === 'approved' && $approved_by) {
            $update_data['approvedBy'] = $approved_by;
            $update_data['approvedAt'] = date('Y-m-d H:i:s');
        }

        if ($notes) {
            $update_data['payoutNotes'] = $notes;
        }

        $this->generic->Update('workforce_payouts', ['workforcePayoutID' => $payout_id], $update_data);
        return true;
    }

    /**
     * Get equipment payout by payment ID
     * 
     * @param int $payment_id Equipment payment ID
     * @return array|false Payout data or false
     */
    public function getEquipmentPayoutByPaymentId($payment_id)
    {
        $result = $this->generic->GetData('equipment_payouts', ['equipmentPaymentID' => $payment_id]);
        return $result ? $result[0] : false;
    }

    /**
     * Get workforce payout by payment ID
     * 
     * @param int $payment_id Workforce payment ID
     * @return array|false Payout data or false
     */
    public function getWorkforcePayoutByPaymentId($payment_id)
    {
        $result = $this->generic->GetData('workforce_payouts', ['workforcePaymentID' => $payment_id]);
        return $result ? $result[0] : false;
    }

    /**
     * Get all pending payouts for SuperAdmin approval (both types)
     * 
     * @return array|false Payouts array or false
     */
    public function getPendingPayouts()
    {
        // Get equipment payouts
        $this->db->select('ep.*, epm.grossAmount, epm.itemID, epm.createdAt as paymentDate, 
                          cd.companyName, u.userName as buyerName, "equipment" as payoutType');
        $this->db->from('equipment_payouts ep');
        $this->db->join('equipment_payments epm', 'ep.equipmentPaymentID = epm.equipmentPaymentID');
        $this->db->join('companydetail cd', 'ep.companyID = cd.companyID');
        $this->db->join('users u', 'epm.buyerUserID = u.userID');
        $this->db->where('ep.payoutStatus', 'pending');
        $equipment_payouts = $this->db->get()->result_array();

        // Get workforce payouts
        $this->db->select('wp.*, wpm.grossAmount, wpm.itemID, wpm.createdAt as paymentDate, 
                          cd.companyName, u.userName as buyerName, "workforce" as payoutType');
        $this->db->from('workforce_payouts wp');
        $this->db->join('workforce_payments wpm', 'wp.workforcePaymentID = wpm.workforcePaymentID');
        $this->db->join('companydetail cd', 'wp.companyID = cd.companyID');
        $this->db->join('users u', 'wpm.buyerUserID = u.userID');
        $this->db->where('wp.payoutStatus', 'pending');
        $workforce_payouts = $this->db->get()->result_array();

        // Combine and sort
        $combined = array_merge($equipment_payouts, $workforce_payouts);

        if (empty($combined)) {
            return false;
        }

        usort($combined, function ($a, $b) {
            return strtotime($b['createdAt']) - strtotime($a['createdAt']);
        });

        return $combined;
    }

    /**
     * Get payouts for a specific company (both types)
     * 
     * @param int $company_id Company ID
     * @return array|false Payouts array or false
     */
    public function getPayoutsByCompany($company_id)
    {
        // Get equipment payouts
        $this->db->select('ep.*, epm.grossAmount, epm.itemID, epm.createdAt as paymentDate, "equipment" as payoutType');
        $this->db->from('equipment_payouts ep');
        $this->db->join('equipment_payments epm', 'ep.equipmentPaymentID = epm.equipmentPaymentID');
        $this->db->where('ep.companyID', $company_id);
        $equipment_payouts = $this->db->get()->result_array();

        // Get workforce payouts
        $this->db->select('wp.*, wpm.grossAmount, wpm.itemID, wpm.createdAt as paymentDate, "workforce" as payoutType');
        $this->db->from('workforce_payouts wp');
        $this->db->join('workforce_payments wpm', 'wp.workforcePaymentID = wpm.workforcePaymentID');
        $this->db->where('wp.companyID', $company_id);
        $workforce_payouts = $this->db->get()->result_array();

        // Combine and sort
        $combined = array_merge($equipment_payouts, $workforce_payouts);

        if (empty($combined)) {
            return false;
        }

        usort($combined, function ($a, $b) {
            return strtotime($b['createdAt']) - strtotime($a['createdAt']);
        });

        return $combined;
    }

    // =============================================
    // SYSTEM SETTINGS & COMMISSION
    // =============================================

    /**
     * Get global commission rate from system settings
     * 
     * @return float Commission percentage
     */
    public function getGlobalCommissionRate()
    {
        $setting = $this->generic->GetData('system_settings', ['settingKey' => 'marketplace_commission_percent']);

        if ($setting) {
            $rate = floatval($setting[0]['settingValue']);
            // Bounds validation: protect against a compromised DB row
            if ($rate >= 0 && $rate <= 50) {
                return $rate;
            }
            log_message('error', 'Commission rate from DB is out of bounds (' . $rate . '%), using safe default 5.00%');
        }

        // Default fallback
        return 5.00;
    }

    /**
     * Update global commission rate (SuperAdmin only)
     * 
     * @param float $commission_percent New commission percentage
     * @param int $updated_by SuperAdmin user ID
     * @return bool Success status
     */
    public function updateGlobalCommissionRate($commission_percent, $updated_by)
    {
        $this->generic->Update(
            'system_settings',
            ['settingKey' => 'marketplace_commission_percent'],
            [
                'settingValue' => $commission_percent,
                'updatedBy' => $updated_by
            ]
        );
        return true;
    }

    // =============================================
    // INVENTORY MANAGEMENT
    // =============================================

    /**
     * Lock equipment inventory after successful payment
     * 
     * @param int $equipment_id Equipment ID
     * @param int $quantity Quantity to lock
     * @return bool Success status
     */
    public function lockEquipmentInventory($equipment_id, $quantity)
    {
        // Get current quantity
        $equipment = $this->generic->GetData('equipment', ['equipmentID' => $equipment_id]);

        if (!$equipment) {
            return false;
        }

        $current_qty = $equipment[0]['equipTotalQuantity'];
        $in_use_qty = $equipment[0]['equipInUseQuantity'];

        // Check if enough inventory available
        if ($current_qty - $in_use_qty < $quantity) {
            log_message('error', "Insufficient inventory for equipment {$equipment_id}");
            return false;
        }

        // Increase in-use quantity
        $new_in_use = $in_use_qty + $quantity;
        $this->generic->Update('equipment', ['equipmentID' => $equipment_id], [
            'equipInUseQuantity' => $new_in_use,
        ]);

        return true;
    }

    /**
     * Release equipment inventory (e.g., after rental period ends or refund)
     * 
     * @param int $equipment_id Equipment ID
     * @param int $quantity Quantity to release
     * @return bool Success status
     */
    public function releaseEquipmentInventory($equipment_id, $quantity)
    {
        $equipment = $this->generic->GetData('equipment', ['equipmentID' => $equipment_id]);

        if (!$equipment) {
            return false;
        }

        $in_use_qty = $equipment[0]['equipInUseQuantity'];
        $new_in_use = max(0, $in_use_qty - $quantity);

        $this->generic->Update('equipment', ['equipmentID' => $equipment_id], [
            'equipInUseQuantity' => $new_in_use,
        ]);

        return true;
    }

    // =============================================
    // STATISTICS & REPORTING
    // =============================================

    /**
     * Get payment statistics for dashboard
     * 
     * @param array $filters Optional filters (company_id, date_from, date_to, type)
     * @return array Statistics
     */
    public function getPaymentStats($filters = [])
    {
        $equipment_stats = $this->getEquipmentPaymentStats($filters);
        $workforce_stats = $this->getWorkforcePaymentStats($filters);

        return [
            'total_payments' => $equipment_stats['total_payments'] + $workforce_stats['total_payments'],
            'total_revenue' => $equipment_stats['total_revenue'] + $workforce_stats['total_revenue'],
            'successful_payments' => $equipment_stats['successful_payments'] + $workforce_stats['successful_payments'],
            'failed_payments' => $equipment_stats['failed_payments'] + $workforce_stats['failed_payments'],
            'equipment' => $equipment_stats,
            'workforce' => $workforce_stats,
        ];
    }

    /**
     * Get equipment payment statistics
     */
    private function getEquipmentPaymentStats($filters = [])
    {
        $this->db->select('
            COUNT(equipmentPaymentID) as total_payments,
            SUM(CASE WHEN paymentStatus = "paid" THEN grossAmount ELSE 0 END) as total_revenue,
            SUM(CASE WHEN paymentStatus = "paid" THEN 1 ELSE 0 END) as successful_payments,
            SUM(CASE WHEN paymentStatus = "failed" THEN 1 ELSE 0 END) as failed_payments
        ');
        $this->db->from('equipment_payments');

        if (isset($filters['company_id'])) {
            $this->db->where('sellerCompanyID', $filters['company_id']);
        }

        if (isset($filters['date_from'])) {
            $this->db->where('createdAt >=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $this->db->where('createdAt <=', $filters['date_to']);
        }

        return $this->db->get()->row_array();
    }

    /**
     * Get workforce payment statistics
     */
    private function getWorkforcePaymentStats($filters = [])
    {
        $this->db->select('
            COUNT(workforcePaymentID) as total_payments,
            SUM(CASE WHEN paymentStatus = "paid" THEN grossAmount ELSE 0 END) as total_revenue,
            SUM(CASE WHEN paymentStatus = "paid" THEN 1 ELSE 0 END) as successful_payments,
            SUM(CASE WHEN paymentStatus = "failed" THEN 1 ELSE 0 END) as failed_payments
        ');
        $this->db->from('workforce_payments');

        if (isset($filters['company_id'])) {
            $this->db->where('sellerCompanyID', $filters['company_id']);
        }

        if (isset($filters['date_from'])) {
            $this->db->where('createdAt >=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $this->db->where('createdAt <=', $filters['date_to']);
        }

        return $this->db->get()->row_array();
    }

    // =============================================
    // INVENTORY & AVAILABILITY METHODS
    // =============================================

    /**
     * Get available quantity for equipment
     * 
     * Checks total stock minus currently active bookings for the requested period.
     * This prevents overbooking.
     */
    public function getAvailableQuantity($equipment_id, $start_date, $end_date)
    {
        // Get equipment details
        $equipment = $this->generic->GetData('equipment', ['equipmentID' => $equipment_id]);
        if (!$equipment) return 0;

        $total_qty = (int)$equipment[0]['equipTotalQuantity'];
        $in_use_qty = (int)$equipment[0]['equipInUseQuantity']; // Permanently unavailable/lost/maintenance
        $rental_total_qty = (int)$equipment[0]['equipRentalTotalQuantity']; // Units available for rental
        $rental_locked_qty = (int)$equipment[0]['equipRentalLockedQuantity']; // Units currently locked

        // Lock-aware calculation (new rental system).
        // If rental total is not explicitly configured yet, fall back to total minus in-use,
        // but ALWAYS subtract rental_locked_qty so approved requests cannot be overbooked.
        if ($rental_total_qty > 0 || $rental_locked_qty > 0) {
            $capacity = $rental_total_qty > 0 ? $rental_total_qty : max(0, $total_qty - $in_use_qty);
            $available = $capacity - $rental_locked_qty;
            return max(0, $available);
        }

        // Legacy system: use equipInUseQuantity for rental tracking
        // Calculate overlapping rentals from date-based bookings
        $overlapping_qty = $this->getOverlappingRentals($equipment_id, $start_date, $end_date);

        // Calculate true availability
        // Available = Total - (Permanently In Use) - (Booked for dates)
        $available = $total_qty - $in_use_qty - $overlapping_qty;

        return max(0, $available);
    }

    /**
     * Check if workforce member is available
     * 
     * Workforce are single units - they can only be in one place at a time.
     * Returns true if free, false if booked.
     */
    public function isWorkforceAvailable($workforce_id, $start_date, $end_date)
    {
        // Workforce must be blocked once a request is approved/active, even before payment is captured.
        $this->db->select('COUNT(*) as count');
        $this->db->from('workforce_payments');
        $this->db->where('workforceID', $workforce_id);

        // Only lifecycle states that actively lock/occupy the workforce should block availability.
        $this->db->where_in('rentalRequestStatus', [
            'request_approved',
            'awaiting_handover',
            'rental_active',
            'rental_overdue',
            'return_requested',
            'returned_by_renter',
            'received_by_owner',
            'under_review'
        ]);

        // Defensive fallback: if both confirmations are already set, do not treat as blocking.
        $this->db->group_start();
        $this->db->where('ownerConfirmedReturn !=', 1);
        $this->db->or_where('renterConfirmedReturn !=', 1);
        $this->db->or_where('ownerConfirmedReturn IS NULL', null, false);
        $this->db->or_where('renterConfirmedReturn IS NULL', null, false);
        $this->db->group_end();

        // Date overlap logic:
        // (StartA <= EndB) and (EndA >= StartB)
        $this->db->group_start();
        $this->db->where('rentalStartDate <=', $end_date);
        $this->db->where('rentalEndDate >=', $start_date);
        $this->db->group_end();

        $result = $this->db->get()->row_array();

        // If count > 0, they are booked (only if paid)
        return ($result['count'] == 0);
    }

    /**
     * Get ID helpers
     */
    public function getEquipmentIDByItemID($item_id)
    {
        $item = $this->generic->GetData('shopequipments', ['itemID' => $item_id]);
        return $item ? $item[0]['equipmentID'] : false;
    }

    public function getWorkforceIDByItemID($item_id)
    {
        $item = $this->generic->GetData('shopworkforce', ['itemID' => $item_id]);
        return $item ? $item[0]['workforceID'] : false;
    }

    /**
     * Helper: Count overlapping equipment rentals
     */
    private function getOverlappingRentals($equipment_id, $start_date, $end_date)
    {
        $this->db->select('SUM(quantity) as booked_qty');
        $this->db->from('equipment_payments');
        $this->db->where('equipmentID', $equipment_id);
        $this->db->where('paymentStatus', 'paid');  // ONLY count paid bookings, not pending requests

        // Overlap check
        $this->db->group_start();
        $this->db->where('rentalStartDate <=', $end_date);
        $this->db->where('rentalEndDate >=', $start_date);
        $this->db->group_end();

        $result = $this->db->get()->row_array();
        return (int)$result['booked_qty'];
    }

    /**
     * Calculate Total Cost (Shared Logic)
     * 
     * Used by both API (for display) and Controller (for actual charging)
     * to ensure consistent pricing.
     * 
     * @return array ['total' => float, 'breakdown' => string, 'error' => string|null]
     */
    public function calculateTotalCost($item_type, $item_data, $quantity, $start_date, $end_date, $sale_type = 'rental')
    {
        $unit_price = 0;
        $rental_type = 0; // 1=daily, etc.

        if ($item_type == 1) { // Equipment
            $unit_price = $item_data['eqpPrice'];
            if ($sale_type == 'purchase') {
                return [
                    'total' => $unit_price * $quantity,
                    'breakdown' => "{$quantity} units × " . number_format($unit_price, 2),
                    'error' => null
                ];
            }
            $rental_type = $item_data['eqpRentalType'];
        } else { // Workforce
            $unit_price = $item_data['workforcePrice'];
            $rental_type = $item_data['workforceRentalType'];
            $sale_type = 'rental'; // Force rental
        }

        // Rental Calculation
        if (!$start_date || !$end_date) {
            return ['total' => 0, 'breakdown' => '', 'error' => 'Dates required'];
        }

        try {
            $start = new DateTime($start_date);
            $end = new DateTime($end_date);
            $days = $end->diff($start)->days + 1;
        } catch (Exception $e) {
            return ['total' => 0, 'breakdown' => '', 'error' => 'Invalid dates'];
        }

        if ($days < 1) {
            return ['total' => 0, 'breakdown' => '', 'error' => 'End date must be after start date'];
        }

        $period_count = 0;
        $period_name = '';

        switch ($rental_type) {
            case 1: // Daily
                $period_count = $days;
                $period_name = 'days';
                break;
            case 2: // Weekly
                $period_count = ceil($days / 7);
                $period_name = 'weeks';
                break;
            case 3: // Monthly
                $period_count = ceil($days / 30);
                $period_name = 'months';
                break;
            case 4: // Yearly
                $period_count = ceil($days / 365);
                $period_name = 'years';
                break;
            default:
                $period_count = $days;
                $period_name = 'days';
        }

        $total = $unit_price * $period_count * $quantity;
        $breakdown = "{$quantity} unit(s) × " . number_format($unit_price, 2) . " × {$period_count} {$period_name}";

        return [
            'total' => $total,
            'breakdown' => $breakdown,
            'error' => null
        ];
    }

    // =============================================
    // RENTAL REQUEST MANAGEMENT (NEW WORKFLOW)
    // =============================================

    /**
     * Lock equipment quantity for an approved rental request
     * 
     * @param int $equipment_id Equipment ID
     * @param int $equipment_payment_id Equipment payment ID
     * @param int $quantity Quantity to lock
     * @param string $start_date Rental start date
     * @param string $end_date Rental end date
     * @return bool|int Lock ID on success, false on failure
     */
    public function lockRentalQuantity($equipment_id, $equipment_payment_id, $quantity, $start_date, $end_date)
    {
        // Verify availability first
        $available = $this->getAvailableQuantity($equipment_id, $start_date, $end_date);
        if ($available < $quantity) {
            log_message('error', "Cannot lock {$quantity} units for equipment {$equipment_id}: only {$available} available");
            return false;
        }

        // Create lock record
        $lock_data = [
            'equipmentID' => $equipment_id,
            'equipmentPaymentID' => $equipment_payment_id,
            'quantity' => $quantity,
            'rentalStartDate' => $start_date,
            'rentalEndDate' => $end_date,
            'lockStatus' => 'locked'
        ];

        $this->db->insert('rental_quantity_locks', $lock_data);
        $lock_id = $this->db->insert_id();

        if ($lock_id) {
            // Update rental locked quantity in equipment table
            $this->db->where('equipmentID', $equipment_id);
            $this->db->set('equipRentalLockedQuantity', 'equipRentalLockedQuantity + ' . $quantity, FALSE);
            $this->db->update('equipment');

            log_message('info', "Locked {$quantity} units for equipment {$equipment_id} (Lock ID: {$lock_id})");
            return $lock_id;
        }

        return false;
    }

    /**
     * Unlock equipment quantity when rental request is rejected or cancelled
     * 
     * @param int $lock_id Lock ID
     * @return bool Success status
     */
    public function unlockRentalQuantity($lock_id)
    {
        // Get the lock record
        $this->db->select('equipmentID, quantity');
        $this->db->from('rental_quantity_locks');
        $this->db->where('lockID', $lock_id);
        $this->db->where('lockStatus', 'locked');
        $lock = $this->db->get()->row();

        if (!$lock) {
            log_message('error', "Lock ID {$lock_id} not found or already unlocked");
            return false;
        }

        // Update lock status
        $this->db->where('lockID', $lock_id);
        $this->db->update('rental_quantity_locks', ['lockStatus' => 'unlocked', 'unlockedAt' => date('Y-m-d H:i:s')]);

        // Update equipment locked quantity
        $this->db->where('equipmentID', $lock->equipmentID);
        $this->db->set('equipRentalLockedQuantity', 'equipRentalLockedQuantity - ' . $lock->quantity, FALSE);
        $this->db->update('equipment');

        log_message('info', "Unlocked {$lock->quantity} units for equipment {$lock->equipmentID} (Lock ID: {$lock_id})");
        return true;
    }

    /**
     * Release equipment quantity when rental period ends
     * 
     * @param int $equipment_id Equipment ID
     * @param int $quantity Quantity to release
     * @param string $end_date Rental end date
     * @return bool Success status
     */
    public function releaseRentalQuantity($equipment_id, $quantity, $end_date)
    {
        // Mark locks as released
        $this->db->where('equipmentID', $equipment_id);
        $this->db->where('rentalEndDate <=', $end_date);
        $this->db->where('lockStatus', 'locked');
        $this->db->update('rental_quantity_locks', ['lockStatus' => 'released']);

        // Log the completion
        $completion_data = [
            'itemType' => 1, // equipment
            'quantity' => $quantity,
            'completionDate' => date('Y-m-d'),
            'quantityReturned' => $quantity
        ];
        $this->db->insert('rental_completion_log', $completion_data);

        log_message('info', "Released {$quantity} units for equipment {$equipment_id} on {$end_date}");
        return true;
    }

    /**
     * Approve a rental request (with transaction)
     * 
     * @param int $payment_id Equipment payment ID
     * @param int $admin_user_id Company admin user ID who approves
     * @return bool Success status
     */
    public function approveRentalRequest($payment_id, $admin_user_id, $payment_type = 'equipment')
    {
        if ($payment_type === 'equipment') {
            return $this->approveEquipmentRental($payment_id, $admin_user_id);
        } elseif ($payment_type === 'workforce') {
            return $this->approveWorkforceRental($payment_id, $admin_user_id);
        }
        return false;
    }

    /**
     * Approve equipment rental with quantity locking
     */
    private function approveEquipmentRental($payment_id, $admin_user_id)
    {
        // Get payment details
        $payment = $this->db->select('equipmentID, quantity, rentalStartDate, rentalEndDate, rentalRequestStatus')
                            ->from('equipment_payments')
                            ->where('equipmentPaymentID', $payment_id)
                            ->get()
                            ->row();
        
        if (!$payment) {
            log_message('error', "Equipment payment {$payment_id} not found");
            return false;
        }

        if ($payment->rentalRequestStatus !== 'request_pending') {
            log_message('error', "Equipment payment {$payment_id} is not pending; current status: {$payment->rentalRequestStatus}");
            return false;
        }
        
        // Atomic transaction
        $this->db->trans_start();

        try {
            // Idempotency guard: do not create duplicate locks for the same payment.
            $existing_lock = $this->db->select('lockID')
                ->from('rental_quantity_locks')
                ->where('equipmentPaymentID', $payment_id)
                ->where('lockStatus', 'locked')
                ->get()
                ->row();

            if ($existing_lock) {
                throw new Exception("Payment {$payment_id} already has an active quantity lock");
            }

            // Verify availability hasn't changed
            $available = $this->getAvailableQuantity(
                $payment->equipmentID,
                $payment->rentalStartDate,
                $payment->rentalEndDate
            );

            if ($available < $payment->quantity) {
                throw new Exception("Insufficient inventory: need {$payment->quantity}, have {$available}");
            }

            // Lock the quantity
            $lock_id = $this->lockRentalQuantity(
                $payment->equipmentID,
                $payment_id,
                $payment->quantity,
                $payment->rentalStartDate,
                $payment->rentalEndDate
            );

            if (!$lock_id) {
                throw new Exception("Failed to lock quantity");
            }

            // NOTE: Do NOT decrease equipRentalTotalQuantity!
            // equipRentalTotalQuantity stays constant - it's the total available inventory
            // equipRentalLockedQuantity is incremented by lockRentalQuantity()
            // Available = equipRentalTotalQuantity - equipRentalLockedQuantity

            // Update payment status using standard DB methods
            $update_data = [
                'orderStatus' => 'payment_pending',
                'rentalRequestStatus' => 'request_approved',
                'requestApprovedBy' => $admin_user_id,
                'requestApprovedAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];

            $this->db->where('equipmentPaymentID', $payment_id);
            $this->db->update('equipment_payments', $update_data);

            log_message('info', "Approved equipment rental {$payment_id}: locked {$payment->quantity} units, lock ID {$lock_id}");
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', "Failed to approve equipment rental {$payment_id}: " . $e->getMessage());
            return false;
        }

        // Finalize transaction only if we got here (no exception)
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            log_message('error', "Transaction failed to commit for equipment rental {$payment_id}");
            return false;
        }

        return true;
    }

    /**
     * Approve workforce rental (no quantity locking needed)
     */
    private function approveWorkforceRental($payment_id, $admin_user_id)
    {
        if (!$payment_id) {
            return false;
        }

        $payment = $this->db->select('workforceID, rentalStartDate, rentalEndDate, rentalRequestStatus')
            ->from('workforce_payments')
            ->where('workforcePaymentID', $payment_id)
            ->get()
            ->row();

        if (!$payment) {
            log_message('error', "Workforce payment {$payment_id} not found");
            return false;
        }

        if ($payment->rentalRequestStatus !== 'request_pending') {
            log_message('error', "Workforce payment {$payment_id} is not pending; current status: {$payment->rentalRequestStatus}");
            return false;
        }

        if (!$this->isWorkforceAvailable($payment->workforceID, $payment->rentalStartDate, $payment->rentalEndDate)) {
            log_message('error', "Workforce {$payment->workforceID} not available for payment {$payment_id}");
            return false;
        }

        $update_data = [
            'orderStatus' => 'payment_pending',
            'rentalRequestStatus' => 'request_approved',
            'requestApprovedBy' => $admin_user_id,
            'requestApprovedAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ];

        $this->db->where('workforcePaymentID', $payment_id);
        $result = $this->db->update('workforce_payments', $update_data);

        if ($result) {
            log_message('info', "Approved workforce rental {$payment_id}");
            return true;
        } else {
            log_message('error', "Failed to approve workforce rental {$payment_id}: DB update returned false");
            return false;
        }
    }

    /**
     * Reject a rental request and unlock quantity
     * 
     * @param int $payment_id Equipment or workforce payment ID
     * @param string $payment_type Type of payment: 'equipment' or 'workforce'
     * @return bool Success status
     */
    public function rejectRentalRequest($payment_id, $payment_type = 'equipment')
    {
        if ($payment_type === 'equipment') {
            return $this->rejectEquipmentRental($payment_id);
        } elseif ($payment_type === 'workforce') {
            return $this->rejectWorkforceRental($payment_id);
        }
        return false;
    }

    /**
     * Reject equipment rental and unlock quantity
     */
    private function rejectEquipmentRental($payment_id)
    {
        $this->db->trans_start();

        try {
            // Get the payment details to get the quantity
            $payment = $this->db->select('equipmentID, quantity')
                                ->from('equipment_payments')
                                ->where('equipmentPaymentID', $payment_id)
                                ->get()
                                ->row();
            
            if (!$payment) {
                throw new Exception("Equipment payment {$payment_id} not found");
            }

            // Find associated lock
            $lock = $this->db->select('lockID')
                ->from('rental_quantity_locks')
                ->where('equipmentPaymentID', $payment_id)
                ->where('lockStatus', 'locked')
                ->get()
                ->row();

            // Unlock if exists (request was previously approved)
            if ($lock) {
                $this->unlockRentalQuantity($lock->lockID);
                // NOTE: unlockRentalQuantity() correctly decrements equipRentalLockedQuantity
                // Do NOT increment equipRentalTotalQuantity - it stays constant!
            }

            // Update payment status
            $update_data = [
                'orderStatus' => 'rejected',
                'rentalRequestStatus' => 'request_rejected',
                'updatedAt' => date('Y-m-d H:i:s')
            ];

            $this->db->where('equipmentPaymentID', $payment_id);
            $result = $this->db->update('equipment_payments', $update_data);

            if (!$result) {
                throw new Exception("DB update returned false");
            }

            log_message('info', "Rejected equipment rental {$payment_id}");
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', "Failed to reject equipment rental {$payment_id}: " . $e->getMessage());
            return false;
        }

        // Finalize transaction only if we got here (no exception)
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            log_message('error', "Transaction failed to commit for reject equipment rental {$payment_id}");
            return false;
        }

        return true;
    }

    /**
     * Reject workforce rental
     */
    private function rejectWorkforceRental($payment_id)
    {
        $update_data = [
            'orderStatus' => 'rejected',
            'rentalRequestStatus' => 'request_rejected',
            'updatedAt' => date('Y-m-d H:i:s')
        ];

        $this->db->where('workforcePaymentID', $payment_id);
        $result = $this->db->update('workforce_payments', $update_data);

        if ($result) {
            log_message('info', "Rejected workforce rental {$payment_id}");
            return true;
        } else {
            log_message('error', "Failed to reject workforce rental {$payment_id}: DB update returned false");
            return false;
        }
    }

    /**
     * Get pending rental requests for a company
     * 
     * @param int $company_id Company ID
     * @return array|false Pending requests array
     */
    public function getPendingRentalRequests($company_id)
    {
        return $this->db->select([
            'ep.equipmentPaymentID',
            'ep.itemID',
            'ep.buyerUserID',
            'ep.quantity',
            'ep.rentalStartDate',
            'ep.rentalEndDate',
            'ep.createdAt',
            'e.equipName',
            'u.userName as buyerName',
            'u.userEmail as buyerEmail'
        ])
        ->from('equipment_payments ep')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID')
        ->join('users u', 'ep.buyerUserID = u.userID')
        ->where('ep.sellerCompanyID', $company_id)
        ->where('ep.orderStatus', 'requested')
        ->where('ep.rentalRequestStatus', 'request_pending')
        ->order_by('ep.createdAt', 'DESC')
        ->get()
        ->result();
    }

    /**
     * Get approved rental requests for a company
     * 
     * @param int $company_id Company ID
     * @return array|false Approved requests array
     */
    public function getApprovedRentalRequests($company_id)
    {
        return $this->db->select([
            'ep.equipmentPaymentID',
            'ep.itemID',
            'ep.buyerUserID',
            'ep.quantity',
            'ep.rentalStartDate',
            'ep.rentalEndDate',
            'ep.requestApprovedAt',
            'e.equipName',
            'u.userName as buyerName'
        ])
        ->from('equipment_payments ep')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID')
        ->join('users u', 'ep.buyerUserID = u.userID')
        ->where('ep.sellerCompanyID', $company_id)
        ->where('ep.orderStatus', 'payment_pending')
        ->where('ep.rentalRequestStatus', 'request_approved')
        ->order_by('ep.rentalStartDate', 'ASC')
        ->get()
        ->result();
    }

    /**
     * Mark rental as completed and release quantity
     * 
     * @param int $payment_id Equipment payment ID
     * @param string $completion_date Date rental was completed
     * @return bool Success status
     */
    public function completeRental($payment_id, $completion_date = null)
    {
        if (!$completion_date) {
            $completion_date = date('Y-m-d');
        }

        $this->db->trans_start();

        try {
            // Get payment details
            $payment = $this->generic->GetData('equipment_payments', ['equipmentPaymentID' => $payment_id]);
            if (!$payment) {
                throw new Exception("Payment not found");
            }

            $payment = $payment[0];

            // Find and release lock
            $lock = $this->db->select('lockID')
                ->from('rental_quantity_locks')
                ->where('equipmentPaymentID', $payment_id)
                ->where('lockStatus', 'locked')
                ->get()
                ->row();

            if ($lock) {
                // Update lock status
                $this->db->where('lockID', $lock->lockID);
                $this->db->update('rental_quantity_locks', ['lockStatus' => 'released']);

                // Release from locked quantity
                $this->db->where('equipmentID', $payment['equipmentID']);
                $this->db->set('equipRentalLockedQuantity', 'equipRentalLockedQuantity - ' . $payment['quantity'], FALSE);
                $this->db->update('equipment');
                
                // NOTE: Do NOT increment equipRentalTotalQuantity!
                // equipRentalTotalQuantity stays constant - it's the total inventory
                // Only equipRentalLockedQuantity changes when rentals are locked/released
            }

            // Update payment status
            $update_data = [
                'orderStatus' => 'completed',
                'rentalRequestStatus' => 'rental_completed',
                'updatedAt' => date('Y-m-d H:i:s')
            ];

            $this->generic->Update('equipment_payments', ['equipmentPaymentID' => $payment_id], $update_data);

            // Log completion
            $completion_data = [
                'equipmentPaymentID' => $payment_id,
                'itemType' => 1,
                'quantity' => $payment['quantity'],
                'completionDate' => $completion_date,
                'quantityReturned' => $payment['quantity']
            ];
            $this->db->insert('rental_completion_log', $completion_data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Transaction failed");
            }

            log_message('info', "Completed rental {$payment_id}, released {$payment['quantity']} units back to rentalTotalQuantity");
            return true;
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', "Failed to complete rental: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get rental requests by date range (for automated completion)
     * 
     * @param string $end_date Date to check for completed rentals
     * @return array Rentals that should be completed
     */
    public function getRentalsToComplete($end_date)
    {
        return $this->db->select([
            'ep.equipmentPaymentID',
            'ep.equipmentID',
            'ep.quantity',
            'ep.rentalEndDate'
        ])
        ->from('equipment_payments ep')
        ->where('ep.rentalEndDate <=', $end_date)
        ->where_in('ep.rentalRequestStatus', ['rental_active', 'rental_overdue'])
        ->get()
        ->result();
    }

    // =============================================
    // RENTAL LIFECYCLE METHODS (Added 2026-03)
    // =============================================

    /**
     * Cancel a rental with refund logic
     *
     * Handles both renter and owner cancellation, enforces 72-hour refund policy.
     *
     * @param int $payment_id Equipment or workforce payment ID
     * @param int $user_id User cancelling
     * @param string $reason Cancellation reason text
     * @param bool $is_owner_cancellation True if company admin is cancelling
     * @param string $item_type 'equipment' or 'workforce'
     * @return array ['success'=>bool, 'refundable'=>bool, 'refund_amount'=>float, 'message'=>string]
     */
    public function cancelRental($payment_id, $user_id, $reason, $is_owner_cancellation, $item_type = 'equipment')
    {
        $table = $item_type === 'equipment' ? 'equipment_payments' : 'workforce_payments';
        $pk    = $item_type === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID';

        $payment = $this->db->get_where($table, [$pk => $payment_id])->row();
        if (!$payment) {
            return ['success' => false, 'message' => 'Payment record not found'];
        }

        $rental_status = strtolower(trim((string)($payment->rentalRequestStatus ?? '')));
        $order_status = strtolower(trim((string)($payment->orderStatus ?? '')));

        // Core policy: cancellation is allowed only before dispatch/pickup notification.
        $handover_notified_states = ['shipped', 'pickup_ready', 'delivered', 'completed', 'cancelled', 'rejected', 'refunded'];
        if (in_array($order_status, $handover_notified_states, true)) {
            return ['success' => false, 'message' => 'Rental can no longer be cancelled after dispatch/pickup notification.'];
        }

        // Do not allow cancellation once rental lifecycle has moved into/after in-use phases.
        $non_cancellable_rental_states = [
            'rental_active', 'return_requested', 'rental_overdue', 'returned_by_renter',
            'received_by_owner', 'under_review', 'rental_completed', 'rental_cancelled'
        ];
        if (in_array($rental_status, $non_cancellable_rental_states, true)) {
            return ['success' => false, 'message' => 'Rental cannot be cancelled in its current state: ' . $payment->rentalRequestStatus];
        }

        $is_paid = in_array((string)($payment->paymentStatus ?? ''), ['paid', 'completed'], true);
        $rental_start_ts = !empty($payment->rentalStartDate) ? strtotime($payment->rentalStartDate . ' 00:00:00') : null;

        $hours_until_start = $rental_start_ts
            ? (($rental_start_ts - time()) / 3600)
            : null;

        // Owner policy: owner can cancel only when there is MORE than 72h before rental start.
        if ($is_owner_cancellation) {
            $owner_accepted_rental_states = ['request_approved', 'awaiting_handover'];
            $owner_accepted_order_states = ['payment_pending', 'payment_secured'];

            $is_owner_accepted_phase = in_array($rental_status, $owner_accepted_rental_states, true)
                || in_array($order_status, $owner_accepted_order_states, true);

            if (!$is_owner_accepted_phase) {
                return ['success' => false, 'message' => 'Owner cancellation is available only after the rental request has been accepted.'];
            }

            if ($hours_until_start === null) {
                return ['success' => false, 'message' => 'Owner cancellation requires a valid rental start date.'];
            }
            if ($hours_until_start <= 72) {
                return ['success' => false, 'message' => 'Owner cancellation is only allowed when more than 72 hours remain before rental start date.'];
            }
        }

        // Determine refund eligibility
        $refundable    = false;
        $refund_amount = 0;
        $stripe_refund_id = null;

        if ($is_paid && !empty($payment->stripePaymentIntentID)) {
            $hours_for_refund = ($hours_until_start !== null) ? $hours_until_start : 999;

            if ($is_owner_cancellation) {
                // Owner cancels: always refund (platform policy protects renter)
                $refundable    = true;
                $refund_amount = floatval($payment->grossAmount);
            } elseif ($hours_for_refund >= 72) {
                // Renter cancels with >=72h notice: refund allowed
                $refundable    = true;
                $refund_amount = floatval($payment->grossAmount);
            }
            // else: <72h — no refund (deposit retained)

            if ($refundable && $refund_amount > 0) {
                try {
                    $this->load->library('StripeService');

                    $refund_response = $this->stripeservice->createRefund(
                        $payment->stripePaymentIntentID,
                        intval(round($refund_amount * 100))
                    );

                    if (empty($refund_response['success'])) {
                        $refund_error = isset($refund_response['error']) ? $refund_response['error'] : 'Unknown Stripe refund error';
                        log_message('error', 'Stripe refund failed: ' . $refund_error);
                        return ['success' => false, 'message' => 'Refund failed: ' . $refund_error];
                    }

                    $stripe_refund_id = isset($refund_response['refund_id']) ? $refund_response['refund_id'] : null;
                    log_message('info', "Stripe refund {$stripe_refund_id} for payment_intent {$payment->stripePaymentIntentID}: {$refund_amount}");
                } catch (Exception $e) {
                    log_message('error', 'Stripe refund failed: ' . $e->getMessage());
                    return ['success' => false, 'message' => 'Refund failed: ' . $e->getMessage()];
                }
            }
        }

        $this->db->trans_start();

        // Update payment status
        $update = [
            'orderStatus'         => 'cancelled',
            'rentalRequestStatus' => 'rental_cancelled',
            'cancelledBy'         => $user_id,
            'cancelledAt'         => date('Y-m-d H:i:s'),
            'cancellationReason'  => $reason,
            'updatedAt'           => date('Y-m-d H:i:s'),
        ];

        if ($refundable) {
            $update['refundAmount']      = $refund_amount;
            $update['refundProcessedAt'] = date('Y-m-d H:i:s');
            $update['stripeRefundID']    = $stripe_refund_id;
            $update['paymentStatus']     = 'refunded';
        }

        $this->db->update($table, $update, [$pk => $payment_id]);

        // Unlock quantity if equipment rental was locked
        if ($item_type === 'equipment') {
            $this->unlockRentalQuantityByPaymentId($payment_id);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            log_message('error', "cancelRental transaction failed for payment {$payment_id}");
            return ['success' => false, 'message' => 'Database error during cancellation'];
        }

        $order = $this->db->select('orderID')
            ->from('orders')
            ->where($pk, $payment_id)
            ->get()
            ->row();

        if ($order && !empty($order->orderID)) {
            $this->closeOrderChatAfterCancellation(
                (int)$order->orderID,
                intval($payment->sellerCompanyID ?? 0),
                $refundable,
                $refund_amount
            );
        }

        log_message('info', "Rental {$payment_id} cancelled by user {$user_id}. Refundable: " . ($refundable ? 'YES' : 'NO'));

        $response_message = 'Rental request cancelled.';
        if (!$is_paid) {
            $response_message = 'Rental request cancelled with no penalty.';
        } elseif ($refundable) {
            $response_message = 'Rental cancelled. Refund of ' . number_format($refund_amount, 2) . ' $ is being processed.';
        } else {
            $response_message = 'Rental cancelled. No refund (cancelled within 72h of rental start date).';
        }

        return [
            'success'       => true,
            'refundable'    => $refundable,
            'refund_amount' => $refund_amount,
            'message'       => $response_message,
        ];
    }

    /**
     * Close the primary order chat immediately after cancellation.
     *
     * If a refund was processed, post an automated note about refund transfer
     * to the renter's Stripe account before locking the chat.
     *
     * @param int $order_id Unified order ID
     * @param int $seller_company_id Company ID used as sender context
     * @param bool $refundable Whether refund was applied
     * @param float $refund_amount Refunded amount
     * @return bool
     */
    private function closeOrderChatAfterCancellation($order_id, $seller_company_id, $refundable = false, $refund_amount = 0.0)
    {
        if (empty($order_id)) {
            return false;
        }

        $this->load->model('Chat_model');
        $this->load->helper('payment');

        $chat = $this->Chat_model->get_chat_by_order((int)$order_id);
        if (!$chat) {
            log_message('error', "No chat found for cancelled order {$order_id}");
            return false;
        }

        $note_lines = [
            'This order has been cancelled. This conversation remains available for support.'
        ];

        if ($refundable && floatval($refund_amount) > 0) {
            $note_lines[] = 'Payment update: A refund of ' . number_format((float)$refund_amount, 2) . ' $ has been initiated to your Stripe account.';
        }

        $sender_company_id = intval($seller_company_id);
        if ($sender_company_id <= 0 && !empty($chat->sellerCompanyID)) {
            $sender_company_id = intval($chat->sellerCompanyID);
        }

        if ($sender_company_id > 0) {
            $this->Chat_model->send_automated_message(
                (int)$chat->chatID,
                implode("\n\n", $note_lines),
                $sender_company_id,
                'system'
            );
        } else {
            log_message('error', "Skipped automated cancellation message for order {$order_id}: missing seller company context");
        }

        $locked = $this->Chat_model->lock_chat((int)$chat->chatID, true);
        if ($locked && (string)($chat->chatType ?? 'standard') !== 'standard' && function_exists('notify_node_chat_locked')) {
            notify_node_chat_locked((int)$chat->chatID);
        }

        return $locked;
    }

    /**
     * Unlock rental quantity using payment ID (wrapper around existing unlockRentalQuantity)
     *
     * @param int $payment_id Equipment payment ID
     * @param string $reason Optional notes for lock record
     * @return bool
     */
    public function unlockRentalQuantityByPaymentId($payment_id, $reason = 'Cancelled')
    {
        $locks = $this->db->select('lockID, equipmentID, quantity')
            ->from('rental_quantity_locks')
            ->where('equipmentPaymentID', $payment_id)
            ->where('lockStatus', 'locked')
            ->get()->result();

        if (empty($locks)) {
            return true; // Nothing to unlock
        }

        $now = date('Y-m-d H:i:s');
        $release_by_equipment = [];
        $lock_ids = [];

        foreach ($locks as $lock) {
            $lock_ids[] = intval($lock->lockID);
            $equipment_id = intval($lock->equipmentID);
            $qty = intval($lock->quantity);
            if (!isset($release_by_equipment[$equipment_id])) {
                $release_by_equipment[$equipment_id] = 0;
            }
            $release_by_equipment[$equipment_id] += $qty;
        }

        $update_data = [
            'lockStatus' => 'unlocked',
            'unlockedAt' => $now,
        ];

        // 'notes' now exists in schema; keep reason for auditability.
        $update_data['notes'] = $reason;

        $this->db->where_in('lockID', $lock_ids);
        $this->db->update('rental_quantity_locks', $update_data);

        foreach ($release_by_equipment as $equipment_id => $release_qty) {
            if ($release_qty <= 0) {
                continue;
            }
            $this->db->where('equipmentID', $equipment_id);
            $this->db->set('equipRentalLockedQuantity', 'GREATEST(0, equipRentalLockedQuantity - ' . intval($release_qty) . ')', false);
            $this->db->update('equipment');
            log_message('info', "Unlocked {$release_qty} units for equipment {$equipment_id} (cancelled payment {$payment_id})");
        }

        // NOTE: Do NOT change equipRentalTotalQuantity!
        // equipRentalTotalQuantity stays constant
        // Only equipRentalLockedQuantity changes
        return true;
    }

    /**
     * Mark rental as returned by the renter
     * If owner has already confirmed → triggers completeRentalReturn()
     *
     * @param int $payment_id
     * @param string $notes Optional notes from renter
     * @param string $item_type 'equipment'|'workforce'
     * @return array
     */
    public function confirmReturnByRenter($payment_id, $notes = '', $item_type = 'equipment')
    {
        $table = $item_type === 'equipment' ? 'equipment_payments' : 'workforce_payments';
        $pk    = $item_type === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID';

        $this->db->update($table, [
            'rentalRequestStatus'   => 'returned_by_renter',
            'renterConfirmedReturn' => 1,
            'renterConfirmedAt'     => date('Y-m-d H:i:s'),
            'renterReturnNotes'     => $notes,
            'updatedAt'             => date('Y-m-d H:i:s'),
        ], [$pk => $payment_id]);

        if ($this->db->affected_rows() === 0) {
            return ['success' => false, 'message' => 'Failed to update return status'];
        }

        // Check if owner already confirmed — if so, complete the rental
        $payment = $this->db->get_where($table, [$pk => $payment_id])->row();
        if ($payment && $payment->ownerConfirmedReturn == 1) {
            return $this->completeRentalReturn($payment_id, $item_type);
        }

        return ['success' => true, 'awaiting_owner_confirmation' => true, 'message' => 'Return marked. Waiting for owner to confirm receipt.'];
    }

    /**
     * Mark rental as received by the equipment owner
     * If renter has already confirmed → triggers completeRentalReturn()
     *
     * @param int $payment_id
     * @param string $notes Optional condition notes from owner
     * @param string $item_type 'equipment'|'workforce'
     * @return array
     */
    public function confirmReturnByOwner($payment_id, $notes = '', $item_type = 'equipment')
    {
        $table = $item_type === 'equipment' ? 'equipment_payments' : 'workforce_payments';
        $pk    = $item_type === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID';

        $this->db->update($table, [
            'rentalRequestStatus'  => 'received_by_owner',
            'ownerConfirmedReturn' => 1,
            'ownerConfirmedAt'     => date('Y-m-d H:i:s'),
            'ownerReturnNotes'     => $notes,
            'updatedAt'            => date('Y-m-d H:i:s'),
        ], [$pk => $payment_id]);

        if ($this->db->affected_rows() === 0) {
            return ['success' => false, 'message' => 'Failed to update return status'];
        }

        $payment = $this->db->get_where($table, [$pk => $payment_id])->row();
        if ($payment && $payment->renterConfirmedReturn == 1) {
            return $this->completeRentalReturn($payment_id, $item_type);
        }

        return ['success' => true, 'awaiting_renter_confirmation' => true, 'message' => 'Receipt confirmed. Waiting for renter to confirm return.'];
    }

    /**
     * Complete a rental when both parties have confirmed return
     *
     * Unlocks quantity, logs completion, creates payout record.
     *
     * @param int $payment_id
     * @param string $item_type 'equipment'|'workforce'
     * @return array
     */
    public function completeRentalReturn($payment_id, $item_type = 'equipment')
    {
        $table = $item_type === 'equipment' ? 'equipment_payments' : 'workforce_payments';
        $pk    = $item_type === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID';

        $payment = $this->db->get_where($table, [$pk => $payment_id])->row();
        if (!$payment) {
            return ['success' => false, 'message' => 'Payment not found'];
        }

        if ($payment->renterConfirmedReturn != 1 || $payment->ownerConfirmedReturn != 1) {
            return ['success' => false, 'message' => 'Both parties must confirm return before completion'];
        }

        $this->db->trans_start();

        // Mark rental completed. Some schemas (e.g., workforce_payments) may not have completedAt.
        $completion_update = [
            'orderStatus'         => 'completed',
            'rentalRequestStatus' => 'rental_completed',
            'updatedAt'           => date('Y-m-d H:i:s'),
        ];
        if ($this->db->field_exists('completedAt', $table)) {
            $completion_update['completedAt'] = date('Y-m-d H:i:s');
        }
        $this->db->update($table, $completion_update, [$pk => $payment_id]);

        // Unlock quantity for equipment rentals
        if ($item_type === 'equipment') {
            $this->unlockRentalQuantityByPaymentId($payment_id, 'Completed');
        }

        // Log completion
        $log_data = [
            $pk            => $payment_id,
            'itemType'     => $item_type === 'equipment' ? 1 : 2,
            'quantity'     => isset($payment->quantityLocked) ? $payment->quantityLocked : ($payment->quantity ?? 1),
            'completionDate' => date('Y-m-d'),
            'quantityReturned' => isset($payment->quantityLocked) ? $payment->quantityLocked : ($payment->quantity ?? 1),
            'completedAt'  => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('rental_completion_log', $log_data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            log_message('error', "completeRentalReturn transaction failed for payment {$payment_id}");
            return ['success' => false, 'message' => 'Database error during completion'];
        }

        // Create payout record (outside transaction — non-critical)
        $this->markEscrowEligibleForRelease($payment_id, $item_type, $payment);

        log_message('info', "Rental {$payment_id} ({$item_type}) completed successfully");
        return ['success' => true, 'status' => 'rental_completed', 'message' => 'Rental completed successfully!'];
    }

    /**
     * Mark escrow eligible for release by creating a payout record
     *
     * @param int $payment_id
     * @param string $item_type 'equipment'|'workforce'
     * @param object|null $payment Pre-fetched payment object (optional, saves a query)
     * @return int|false Payout ID or false
     */
    public function markEscrowEligibleForRelease($payment_id, $item_type = 'equipment', $payment = null)
    {
        $table = $item_type === 'equipment' ? 'equipment_payments' : 'workforce_payments';
        $pk    = $item_type === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID';

        if (!$payment) {
            $payment = $this->db->get_where($table, [$pk => $payment_id])->row();
        }

        if (!$payment) {
            log_message('error', "markEscrowEligibleForRelease: payment {$payment_id} not found");
            return false;
        }

        // Only create payout if payment was actually paid
        if ($payment->paymentStatus !== 'paid') {
            return false;
        }

        // Check if payout already exists
        $payout_table = $item_type === 'equipment' ? 'equipment_payouts' : 'workforce_payouts';
        $existing = $this->db->get_where($payout_table, [$pk => $payment_id])->row();
        if ($existing) {
            log_message('info', "Payout already exists for {$item_type} payment {$payment_id}");
            return $existing->{$item_type === 'equipment' ? 'equipmentPayoutID' : 'workforcePayoutID'};
        }

        // Create payout record
        if ($item_type === 'equipment') {
            return $this->createEquipmentPayout($payment_id, $payment->sellerCompanyID, $payment->netAmount);
        } else {
            return $this->createWorkforcePayout($payment_id, $payment->sellerCompanyID, $payment->netAmount);
        }
    }
}

