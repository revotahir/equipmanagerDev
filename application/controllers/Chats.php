<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Chats Controller
 * 
 * Displays list of chats for logged-in user (buyer or seller)
 */
class Chats extends MY_Controller
{
    private function employeeAccount($userID)
    {
        $this->load->model('Employee_model', 'employee_model');
        return $this->employee_model->resolve_employee((int)$userID);
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Chat_model');
        $this->load->database();
    }

    /**
     * Display list of all chats for current user
     * Shows both chats where user is buyer and chats where user is seller
     * Includes both equipment and workforce rental chats
     * Uses unified orders table with orderID
     */
    public function index()
    {
        $loginData = $this->session->userdata('loginData');
        
        // Verify session exists
        if (!$loginData || !isset($loginData['userID'])) {
            log_message('error', 'Chats list access attempt without valid session');
            show_error('Session expired. Please log in again.', 401);
            return;
        }
        
        $userID = $loginData['userID'];
        $employee = null;

        // Get companyID - check companyDetails first, then loginData
        $companyID = null;
        if ($this->session->userdata('companyDetails')) {
            $companyDetails = $this->session->userdata('companyDetails');
            $companyID = $companyDetails['companyID'];
        } elseif (isset($loginData['companyID'])) {
            $companyID = $loginData['companyID'];
        }

        $has_chat_links = $this->db->table_exists('order_chat_links');

        if ($has_chat_links) {
            $this->db->select("
                c.chatID,
                c.chatStatus,
                c.chatType,
                c.buyerUserID,
                c.sellerCompanyID,
                c.createdAt,
                company.companyName as sellerCompanyName,
                seller_user.userName as sellerUserName,
                buyer.userName as buyerFirstName,
                buyer.userEmail as buyerEmail,
                CASE
                    WHEN c.chatType = 'dispute' THEN 'Dispute'
                    WHEN (SELECT COUNT(*) FROM order_chat_links WHERE chatID = c.chatID) > 0 THEN 'Orders'
                    ELSE 'Direct Inquiry'
                END as itemType,
                (SELECT COUNT(*) FROM order_chat_messages WHERE chatID = c.chatID) as messageCount,
                (SELECT MAX(createdAt) FROM order_chat_messages WHERE chatID = c.chatID) as lastMessageAt,
                (SELECT COUNT(*) FROM order_chat_links WHERE chatID = c.chatID) as linkedOrdersCount,
                COALESCE(
                    (SELECT ocl.orderID FROM order_chat_links ocl WHERE ocl.chatID = c.chatID ORDER BY ocl.linkID DESC LIMIT 1),
                    c.orderID
                ) as orderID,
                COALESCE(
                    (SELECT COALESCE(ep.grossAmount, wp.grossAmount, 0)
                     FROM orders o
                     LEFT JOIN equipment_payments ep ON o.equipmentPaymentID = ep.equipmentPaymentID
                     LEFT JOIN workforce_payments wp ON o.workforcePaymentID = wp.workforcePaymentID
                     WHERE o.orderID = COALESCE(
                        (SELECT ocl2.orderID FROM order_chat_links ocl2 WHERE ocl2.chatID = c.chatID ORDER BY ocl2.linkID DESC LIMIT 1),
                        c.orderID
                     )
                     LIMIT 1),
                    0
                ) as grossAmount,
                COALESCE(
                    (SELECT COALESCE(ep.paymentStatus, wp.paymentStatus, 'open')
                     FROM orders o
                     LEFT JOIN equipment_payments ep ON o.equipmentPaymentID = ep.equipmentPaymentID
                     LEFT JOIN workforce_payments wp ON o.workforcePaymentID = wp.workforcePaymentID
                     WHERE o.orderID = COALESCE(
                        (SELECT ocl3.orderID FROM order_chat_links ocl3 WHERE ocl3.chatID = c.chatID ORDER BY ocl3.linkID DESC LIMIT 1),
                        c.orderID
                     )
                     LIMIT 1),
                    'open'
                ) as paymentStatus
            ", false);
        } else {
            $this->db->select("
                c.chatID,
                c.chatStatus,
                c.chatType,
                c.buyerUserID,
                c.sellerCompanyID,
                c.createdAt,
                company.companyName as sellerCompanyName,
                seller_user.userName as sellerUserName,
                buyer.userName as buyerFirstName,
                buyer.userEmail as buyerEmail,
                CASE
                    WHEN c.orderID IS NULL THEN 'Direct Inquiry'
                    WHEN o.equipmentPaymentID IS NOT NULL THEN 'Equipment'
                    ELSE 'Workforce'
                END as itemType,
                (SELECT COUNT(*) FROM order_chat_messages WHERE chatID = c.chatID) as messageCount,
                (SELECT MAX(createdAt) FROM order_chat_messages WHERE chatID = c.chatID) as lastMessageAt,
                c.orderID,
                COALESCE(ep.grossAmount, wp.grossAmount, 0) as grossAmount,
                COALESCE(ep.paymentStatus, wp.paymentStatus, 'open') as paymentStatus,
                CASE WHEN c.orderID IS NULL THEN 0 ELSE 1 END as linkedOrdersCount
            ", false);
        }

        $this->db->from('order_chats c');
        if (!$has_chat_links) {
            $this->db->join('orders o', 'c.orderID = o.orderID', 'left');
            $this->db->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left');
            $this->db->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left');
        }
        $this->db->join('companydetail company', 'c.sellerCompanyID = company.companyID', 'left');
        $this->db->join('users seller_user', 'seller_user.userID = company.userID', 'left');
        $this->db->join('users buyer', 'c.buyerUserID = buyer.userID', 'left');
        
        // Build WHERE clause for user as buyer OR seller
        $this->db->group_start()
            ->where('c.buyerUserID', $userID);
        
        if ($companyID) {
            $this->db->or_where('c.sellerCompanyID', $companyID);
        }
        
        $this->db->group_end();
        
        $all_chats = $this->db->get()->result();

        // Collapse standard chats to a single persistent conversation per buyer/company pair.
        $seen_chats = [];
        $unique_chats = [];
        foreach ($all_chats as $chat) {
            $activity_time = strtotime($chat->lastMessageAt ?: $chat->createdAt ?: '1970-01-01');
            $group_key = ($chat->chatType === 'dispute')
                ? ('dispute:' . $chat->chatID)
                : ('standard:' . $chat->buyerUserID . ':' . $chat->sellerCompanyID);

            if (!isset($seen_chats[$group_key])) {
                $seen_chats[$group_key] = $chat;
            } else {
                $existing = $seen_chats[$group_key];
                if ($chat->chatType === 'standard') {
                    // Force canonical chat for standard threads (smallest chatID),
                    // so old order-level chats do not split the conversation.
                    if ((int)$chat->chatID < (int)$existing->chatID) {
                        $seen_chats[$group_key] = $chat;
                    }
                } else {
                    $existing_activity = strtotime($existing->lastMessageAt ?: $existing->createdAt ?: '1970-01-01');
                    if ($activity_time > $existing_activity) {
                        $seen_chats[$group_key] = $chat;
                    }
                }
            }
        }

        $all_chats = array_values($seen_chats);

        // Sort by last message time (most recent first)
        usort($all_chats, function ($a, $b) {
            $timeA = $a->lastMessageAt ?: $a->createdAt;
            $timeB = $b->lastMessageAt ?: $b->createdAt;
            return strtotime($timeB) - strtotime($timeA);
        });

        $userType = $loginData['userType'];
        if ((int)$userType === 4) {
            $employee = $this->employeeAccount($userID);
            if (!empty($employee)) {
                redirect(base_url('employee/messages'));
                return;
            }
        }

        $data = [
            'chats' => $all_chats,
            'user_id' => $userID,
            'company_id' => $companyID,
            'user_type' => $userType,
            'employee' => $employee,
            'employee_nav' => !empty($employee),
            'active_page' => 'chats'
        ];

        // Determine which layout to use based on user type

        // Store data for views
        $this->data = $data;

        if ($userType == 2 || $userType == 3) {
            // Company admin or manager - use admin layout
            $this->load->view('chats/list_layout', $data);
        } else {
            // Regular user - use website layout
            $this->load->view('chats/list_website_layout', $data);
        }
    }
}
