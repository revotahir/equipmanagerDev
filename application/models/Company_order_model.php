<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Company_order_model
 * 
 * Handles database operations for company order management
 */
class Company_order_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all orders for a company with optional status filter
     * 
     * @param int $company_id
    * @param string $status_filter Optional order status filter
    * @param string $type_filter Optional order type filter: 'rental'|'purchase'
     * @return array
     */
    public function get_company_orders($company_id, $status_filter = null, $type_filter = null)
    {
        $equipment_query = $this->db->select([
            'o.orderID as orderID',
            "'equipment' as orderType",
            'ep.equipmentPaymentID',
            'NULL as workforcePaymentID',
            'ep.grossAmount',
            'ep.quantity',
            'ep.saleType',
            'ep.orderStatus',
            'ep.rentalRequestStatus as rentalLifecycleStatus',
            'ep.hasActiveIssue',
            'ep.currentIssueID',
            'ep.rentalStartDate',
            'ep.rentalEndDate',
            'ep.renterConfirmedReturn',
            'ep.ownerConfirmedReturn',
            'ep.paymentStatus',
            'ep.createdAt',
            'ep.stripePaymentIntentID',
            'ep.paymentMetadata',
            'e.equipName as itemName',
            'e.equipName',
            'e.equipmentID',
            'u.userName as buyerName',
            'u.userEmail as buyerEmail',
            'u.userPhone as buyerPhone'
        ], false)
        ->from('equipment_payments ep')
        ->join('orders o', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'inner')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('users u', 'ep.buyerUserID = u.userID', 'left')
        ->where('ep.sellerCompanyID', $company_id);

        if ($type_filter === 'rental') {
            $equipment_query->where("LOWER(CAST(ep.saleType AS CHAR)) IN ('rental','0','2')", null, false);
        } elseif ($type_filter === 'purchase') {
            $equipment_query->where("LOWER(CAST(ep.saleType AS CHAR)) IN ('purchase','1')", null, false);
        }

        if ($status_filter) {
            if ($status_filter === 'under_review') {
                $equipment_query->group_start()
                    ->where('ep.rentalRequestStatus', $status_filter)
                    ->or_where('ep.hasActiveIssue', 1)
                    ->group_end();
            } else {
                $equipment_query->group_start()
                    ->where('ep.orderStatus', $status_filter)
                    ->or_where('ep.rentalRequestStatus', $status_filter)
                    ->group_end();
            }
        }

        $equipment_orders = $equipment_query->get()->result();

        $workforce_query = $this->db->select([
            'o.orderID as orderID',
            "'workforce' as orderType",
            'NULL as equipmentPaymentID',
            'wp.workforcePaymentID',
            'wp.grossAmount',
            '1 as quantity',
            "'rental' as saleType",
            'wp.orderStatus',
            'wp.rentalRequestStatus as rentalLifecycleStatus',
            'wp.hasActiveIssue',
            'wp.currentIssueID',
            'wp.rentalStartDate',
            'wp.rentalEndDate',
            'wp.renterConfirmedReturn',
            'wp.ownerConfirmedReturn',
            'wp.paymentStatus',
            'wp.createdAt',
            'wp.stripePaymentIntentID',
            'wp.paymentMetadata',
            'wf.personName as itemName',
            'NULL as equipName',
            'NULL as equipmentID',
            'u.userName as buyerName',
            'u.userEmail as buyerEmail',
            'u.userPhone as buyerPhone'
        ], false)
        ->from('workforce_payments wp')
        ->join('orders o', 'o.workforcePaymentID = wp.workforcePaymentID', 'inner')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('users u', 'wp.buyerUserID = u.userID', 'left')
        ->where('wp.sellerCompanyID', $company_id);

        if ($type_filter === 'purchase') {
            $workforce_query->where('1 = 0', null, false);
        }

        if ($status_filter) {
            if ($status_filter === 'under_review') {
                $workforce_query->group_start()
                    ->where('wp.rentalRequestStatus', $status_filter)
                    ->or_where('wp.hasActiveIssue', 1)
                    ->group_end();
            } else {
                $workforce_query->group_start()
                    ->where('wp.orderStatus', $status_filter)
                    ->or_where('wp.rentalRequestStatus', $status_filter)
                    ->group_end();
            }
        }

        $workforce_orders = $workforce_query->get()->result();

        $orders = array_merge($equipment_orders, $workforce_orders);

        usort($orders, function ($a, $b) {
            return strcmp((string)($b->createdAt ?? ''), (string)($a->createdAt ?? ''));
        });

        return $orders;
    }

    /**
     * Get equipment orders for a company with optional status filter
     * 
     * @param int $company_id
     * @param string $status_filter optional status filter
     * @return array
     */
    public function get_company_equipment_orders($company_id, $status_filter = null)
    {
        $query = $this->db->select("
            ep.equipmentPaymentID as orderID,
            'equipment' as orderType,
            ep.grossAmount,
            ep.quantity,
            ep.orderStatus,
            ep.paymentStatus,
            ep.createdAt,
            ep.stripePaymentIntentID,
            ep.paymentMetadata,
            e.equipName as itemName,
            e.equipmentID,
            u.userName as buyerName,
            u.userEmail as buyerEmail,
            u.userPhone as buyerPhone
        ", false)
        ->from('equipment_payments ep')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('users u', 'ep.buyerUserID = u.userID', 'left')
        ->where('ep.sellerCompanyID', $company_id)
        ->order_by('ep.createdAt', 'DESC');
        
        if ($status_filter) {
            $query->where('ep.orderStatus', $status_filter);
        }
        
        return $query->get()->result();
    }

    /**
     * Get workforce orders for a company with optional status filter
     * 
     * @param int $company_id
     * @param string $status_filter optional status filter
     * @return array
     */
    public function get_company_workforce_orders($company_id, $status_filter = null)
    {
        $query = $this->db->select("
            wp.workforcePaymentID as orderID,
            'workforce' as orderType,
            wp.grossAmount,
            DATEDIFF(wp.rentalEndDate, wp.rentalStartDate) as quantity,
            wp.orderStatus as orderStatus,
            wp.rentalRequestStatus as rentalLifecycleStatus,
            wp.paymentStatus,
            wp.createdAt,
            wp.stripePaymentIntentID,
            wp.paymentMetadata,
            wf.personName as itemName,
            wf.workforceID,
            u.userName as buyerName,
            u.userEmail as buyerEmail,
            u.userPhone as buyerPhone
        ", false)
        ->from('workforce_payments wp')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('users u', 'wp.buyerUserID = u.userID', 'left')
        ->where('wp.sellerCompanyID', $company_id)
        ->order_by('wp.createdAt', 'DESC');
        
        if ($status_filter) {
            $query->group_start()
                ->where('wp.orderStatus', $status_filter)
                ->or_where('wp.rentalRequestStatus', $status_filter)
                ->group_end();
        }
        
        return $query->get()->result();
    }

    /**
     * Get detailed order information
     * Verify order belongs to specified company
     * Uses unified orderID from orders table
     * 
     * @param int $order_id - unified order ID
     * @param int $company_id
     * @return object|null
     */
    public function get_order_detail($order_id, $company_id)
    {
        $has_chat_links = $this->db->table_exists('order_chat_links');

        $query = $this->db->select("
            o.orderID,
            o.equipmentPaymentID,
            o.workforcePaymentID,
            CASE WHEN o.equipmentPaymentID IS NOT NULL THEN 'equipment' ELSE 'workforce' END as orderType,
            COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount,
            COALESCE(ep.commissionPercent, wp.commissionPercent) as commissionPercent,
            COALESCE(ep.commissionAmount, wp.commissionAmount) as commissionAmount,
            COALESCE(ep.netAmount, wp.netAmount) as netAmount,
            COALESCE(ep.saleType, 'rental') as saleType,
            COALESCE(ep.rentalType, wp.rentalType) as rentalType,
            COALESCE(ep.paymentStatus, wp.paymentStatus) as paymentStatus,
            COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus) as orderStatus,
            COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) as rentalRequestStatus,
            COALESCE(ep.renterConfirmedReturn, wp.renterConfirmedReturn) as renterConfirmedReturn,
            COALESCE(ep.ownerConfirmedReturn, wp.ownerConfirmedReturn) as ownerConfirmedReturn,
            COALESCE(ep.renterConfirmedAt, wp.renterConfirmedAt) as renterConfirmedAt,
            COALESCE(ep.renterReturnNotes, wp.renterReturnNotes) as renterReturnNotes,
            COALESCE(ep.hasActiveIssue, wp.hasActiveIssue) as hasActiveIssue,
            COALESCE(ep.currentIssueID, wp.currentIssueID) as currentIssueID,
            COALESCE(ep.createdAt, wp.createdAt) as createdAt,
            COALESCE(ep.updatedAt, wp.updatedAt) as updatedAt,
            COALESCE(ep.quantity, DATEDIFF(wp.rentalEndDate, wp.rentalStartDate) + 1) as quantity,
            COALESCE(ep.rentalStartDate, wp.rentalStartDate) as rentalStartDate,
            COALESCE(ep.rentalEndDate, wp.rentalEndDate) as rentalEndDate,
            ep.rejectionReason,
            COALESCE(ep.approvedAt, wp.requestApprovedAt) as approvedAt,
            e.equipName as equipmentName,
            e.equipDesc,
            e.equipImg as equipImage,
            e.equipTotalQuantity,
            e.equipmentID,
            wf.personName as workforceName,
            wf.workforceID,
            sw.workforceCity,
            sw.WorkforceAdd,
            sw.workforceAvailableStart,
            sw.workforceAvailableEnd,
            sw.workforcePrice,
            u.userName as buyerName,
            u.userEmail as buyerEmail,
            u.userPhone as buyerPhone,
            u.userID as buyerUserID,
            cd.companyName as sellerCompanyName,
            cd.companyID as sellerCompanyID,
            COALESCE(ep.itemID, wp.itemID) as itemID,
            COALESCE(e.equipName, wf.personName) as itemName,
            oc.chatID,
            ep.approvedBy,
            approver.userName as approvedByName,
            COALESCE(ep.paymentMetadata, wp.paymentMetadata) as paymentMetadata,
            ep.trackingNumber,
            ep.shippingNotes,
            ep.shippedAt,
            ep.deliveredAt
        ", false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('shopworkforce sw', 'wp.itemID = sw.itemID', 'left')
        ->join('users u', 'COALESCE(ep.buyerUserID, wp.buyerUserID) = u.userID', 'left')
        ->join('companydetail cd', 'COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) = cd.companyID', 'left')
        ->join('shopitem si', 'COALESCE(ep.itemID, wp.itemID) = si.itemID', 'left');

        if ($has_chat_links) {
            $query->join('order_chat_links ocl', 'o.orderID = ocl.orderID', 'left')
                ->join('order_chats oc', 'ocl.chatID = oc.chatID', 'left');
        } else {
            $query->join('order_chats oc', 'o.orderID = oc.orderID', 'left');
        }

        return $query->join('users approver', 'ep.approvedBy = approver.userID', 'left')
            ->where('o.orderID', $order_id)
            ->where('COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) =', $company_id)
            ->get()
            ->row();
    }

    /**
     * Approve an order and generate checkout token
     *
     * @param int $order_id - unified order ID from orders table
     * @param int $admin_user_id
     * @param string $checkout_token
     * @param string $token_expiry
     * @return bool
     */
    public function approve_order($order_id, $admin_user_id, $checkout_token, $token_expiry)
    {
        // Get the payment ID from the unified orders table
        $order = $this->db->select('equipmentPaymentID, workforcePaymentID')
                          ->from('orders')
                          ->where('orderID', $order_id)
                          ->get()
                          ->row();

        if (!$order) {
            log_message('error', "Order {$order_id} not found in orders table");
            return false;
        }

        $result = false;
        if ($order->equipmentPaymentID) {
            $update_data = [
                'orderStatus' => 'payment_pending',
                'approvedBy' => $admin_user_id,
                'approvedAt' => date('Y-m-d H:i:s'),
                'checkoutToken' => $checkout_token,
                'checkoutTokenExpiry' => $token_expiry,
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            $this->db->where('equipmentPaymentID', $order->equipmentPaymentID);
            $result = $this->db->update('equipment_payments', $update_data);
        } elseif ($order->workforcePaymentID) {
            $existing_metadata_raw = $this->db->select('paymentMetadata')
                ->from('workforce_payments')
                ->where('workforcePaymentID', $order->workforcePaymentID)
                ->get()
                ->row('paymentMetadata');
            $existing_metadata = json_decode((string)$existing_metadata_raw, true);
            if (!is_array($existing_metadata)) {
                $existing_metadata = [];
            }
            $existing_metadata['checkout_token'] = $checkout_token;
            $existing_metadata['checkout_token_expiry'] = $token_expiry;
            $existing_metadata['checkout_token_created_at'] = date('Y-m-d H:i:s');

            $update_data = [
                'orderStatus' => 'payment_pending',
                'rentalRequestStatus' => 'request_approved',
                'requestApprovedBy' => $admin_user_id,
                'requestApprovedAt' => date('Y-m-d H:i:s'),
                'paymentMetadata' => json_encode($existing_metadata),
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            $this->db->where('workforcePaymentID', $order->workforcePaymentID);
            $result = $this->db->update('workforce_payments', $update_data);
        }

        if ($result) {
            log_message('info', "Order {$order_id} approved by admin {$admin_user_id}");
        }

        return $result;
    }

    /**
     * Reject an order with reason
     *
     * @param int $order_id - unified order ID from orders table
     * @param int $admin_user_id
     * @param string $reason
     * @return bool
     */
    public function reject_order($order_id, $admin_user_id, $reason = null)
    {
        // Get the payment ID from the unified orders table
        $order = $this->db->select('equipmentPaymentID, workforcePaymentID')
                          ->from('orders')
                          ->where('orderID', $order_id)
                          ->get()
                          ->row();

        if (!$order) {
            log_message('error', "Order {$order_id} not found in orders table");
            return false;
        }

        $result = false;
        if ($order->equipmentPaymentID) {
            $equipment_payment = $this->db->select('saleType')
                ->from('equipment_payments')
                ->where('equipmentPaymentID', $order->equipmentPaymentID)
                ->get()
                ->row();

            $sale_type = strtolower((string)($equipment_payment->saleType ?? ''));
            $is_equipment_rental = in_array($sale_type, ['rental', '0', '2'], true);

            $update_data = [
                'orderStatus' => 'rejected',
                'approvedBy' => $admin_user_id,
                'approvedAt' => date('Y-m-d H:i:s'),
                'rejectionReason' => $reason,
                'updatedAt' => date('Y-m-d H:i:s')
            ];

            if ($is_equipment_rental) {
                $update_data['rentalRequestStatus'] = 'request_rejected';
            }

            $this->db->where('equipmentPaymentID', $order->equipmentPaymentID);
            $result = $this->db->update('equipment_payments', $update_data);
        } elseif ($order->workforcePaymentID) {
            $update_data = [
                'orderStatus' => 'rejected',
                'rentalRequestStatus' => 'request_rejected',
                'requestApprovedBy' => $admin_user_id,
                'requestApprovedAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            $this->db->where('workforcePaymentID', $order->workforcePaymentID);
            $result = $this->db->update('workforce_payments', $update_data);
        }

        if ($result) {
            log_message('info', "Order {$order_id} rejected by admin {$admin_user_id}");
        }

        return $result;
    }

    /**
     * Mark order as shipped
     *
     * @param int $order_id - unified order ID from orders table
     * @param int $admin_user_id
     * @param string $tracking_number
     * @param string $shipping_notes
     * @return bool
     */
    public function mark_as_shipped($order_id, $admin_user_id, $tracking_number = null, $shipping_notes = null)
    {
        // Get the payment ID from the unified orders table
        $order = $this->db->select('equipmentPaymentID, workforcePaymentID')
                          ->from('orders')
                          ->where('orderID', $order_id)
                          ->get()
                          ->row();

        if (!$order) {
            log_message('error', "Order {$order_id} not found in orders table");
            return false;
        }

        $result = false;
        if ($order->equipmentPaymentID) {
            $update_data = [
                'orderStatus' => 'shipped',
                'shippedBy' => $admin_user_id,
                'shippedAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];

            if ($tracking_number) {
                $update_data['trackingNumber'] = $tracking_number;
            }

            if ($shipping_notes) {
                $update_data['shippingNotes'] = $shipping_notes;
            }

            $this->db->where('equipmentPaymentID', $order->equipmentPaymentID);
            $result = $this->db->update('equipment_payments', $update_data);
        } elseif ($order->workforcePaymentID) {
            $existing_metadata_raw = $this->db->select('paymentMetadata')
                ->from('workforce_payments')
                ->where('workforcePaymentID', $order->workforcePaymentID)
                ->get()
                ->row('paymentMetadata');
            $existing_metadata = json_decode((string)$existing_metadata_raw, true);
            if (!is_array($existing_metadata)) {
                $existing_metadata = [];
            }
            $existing_metadata['shipping_marked_by'] = intval($admin_user_id);
            $existing_metadata['shipping_marked_at'] = date('Y-m-d H:i:s');
            if (!empty($tracking_number)) {
                $existing_metadata['tracking_number'] = (string)$tracking_number;
            }
            if (!empty($shipping_notes)) {
                $existing_metadata['shipping_notes'] = (string)$shipping_notes;
            }

            $update_data = [
                'orderStatus' => 'shipped',
                'paymentMetadata' => json_encode($existing_metadata),
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            $this->db->where('workforcePaymentID', $order->workforcePaymentID);
            $result = $this->db->update('workforce_payments', $update_data);
        }

        if ($result) {
            log_message('info', "Order {$order_id} marked as shipped by admin {$admin_user_id}");
        }

        return $result;
    }

    /**
     * Update approval status of an order (DEPRECATED - use approve_order or reject_order)
     *
     * @param int $order_id - unified order ID from orders table
     * @param string $status 'approved'|'rejected'
     * @param int $admin_user_id
     * @param string $notes
     * @return bool
     */
    public function update_approval_status($order_id, $status, $admin_user_id, $notes = null)
    {
        // Get the payment ID from the unified orders table
        $order = $this->db->select('equipmentPaymentID, workforcePaymentID')
                          ->from('orders')
                          ->where('orderID', $order_id)
                          ->get()
                          ->row();

        if (!$order) {
            log_message('error', "Order {$order_id} not found in orders table");
            return false;
        }

        $result = false;
        if ($order->equipmentPaymentID) {
            $update_data = [
                'orderStatus' => $status,
                'approvedBy' => $admin_user_id,
                'approvedAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];

            if ($notes) {
                $update_data['rejectionReason'] = $notes;
            }

            $this->db->where('equipmentPaymentID', $order->equipmentPaymentID);
            $result = $this->db->update('equipment_payments', $update_data);
        } elseif ($order->workforcePaymentID) {
            $update_data = [
                'orderStatus' => $status === 'approved' ? 'payment_pending' : 'rejected',
                'rentalRequestStatus' => $status === 'approved' ? 'request_approved' : 'request_rejected',
                'requestApprovedBy' => $admin_user_id,
                'requestApprovedAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            $this->db->where('workforcePaymentID', $order->workforcePaymentID);
            $result = $this->db->update('workforce_payments', $update_data);
        }

        if ($result) {
            log_message('info', "Order {$order_id} order status updated to {$status} by admin {$admin_user_id}");
        }

        return $result;
    }

    /**
     * Mark order as ready for pickup (pickup orders only)
     *
     * @param int $order_id - unified order ID from orders table
     * @param int $admin_user_id
     * @return bool
     */
    public function mark_as_pickup_ready($order_id, $admin_user_id)
    {
        // Get the payment ID from the unified orders table
        $order = $this->db->select('equipmentPaymentID, workforcePaymentID')
                          ->from('orders')
                          ->where('orderID', $order_id)
                          ->get()
                          ->row();

        if (!$order) {
            log_message('error', "Order {$order_id} not found in orders table");
            return false;
        }

        $result = false;
        if ($order->equipmentPaymentID) {
            $update_data = [
                'orderStatus' => 'pickup_ready',
                'shippedBy'   => $admin_user_id,
                'shippedAt'   => date('Y-m-d H:i:s'),
                'updatedAt'   => date('Y-m-d H:i:s')
            ];
            $this->db->where('equipmentPaymentID', $order->equipmentPaymentID);
            $result = $this->db->update('equipment_payments', $update_data);
        } elseif ($order->workforcePaymentID) {
            $existing_metadata_raw = $this->db->select('paymentMetadata')
                ->from('workforce_payments')
                ->where('workforcePaymentID', $order->workforcePaymentID)
                ->get()
                ->row('paymentMetadata');
            $existing_metadata = json_decode((string)$existing_metadata_raw, true);
            if (!is_array($existing_metadata)) {
                $existing_metadata = [];
            }
            $existing_metadata['pickup_ready_by'] = intval($admin_user_id);
            $existing_metadata['pickup_ready_at'] = date('Y-m-d H:i:s');

            $update_data = [
                'orderStatus' => 'pickup_ready',
                'paymentMetadata' => json_encode($existing_metadata),
                'updatedAt'   => date('Y-m-d H:i:s')
            ];
            $this->db->where('workforcePaymentID', $order->workforcePaymentID);
            $result = $this->db->update('workforce_payments', $update_data);
        }

        if ($result) {
            log_message('info', "Order {$order_id} marked as pickup_ready by admin {$admin_user_id}");
        }

        return $result;
    }

    /**
     * Get order count by status for company
     * 
     * @param int $company_id
     * @return object
     */
    public function get_order_counts($company_id)
    {
        $result = $this->db->select([
            'COUNT(*) as total',
            'SUM(CASE WHEN orderStatus = "requested" THEN 1 ELSE 0 END) as requested',
            'SUM(CASE WHEN orderStatus = "payment_pending" THEN 1 ELSE 0 END) as payment_pending',
            'SUM(CASE WHEN orderStatus = "payment_secured" THEN 1 ELSE 0 END) as payment_secured',
            'SUM(CASE WHEN orderStatus = "shipped" THEN 1 ELSE 0 END) as shipped',
            'SUM(CASE WHEN orderStatus = "rejected" THEN 1 ELSE 0 END) as rejected'
        ])
        ->from('equipment_payments')
        ->where('sellerCompanyID', $company_id)
        ->get()
        ->row();
        
        return $result;
    }
}
