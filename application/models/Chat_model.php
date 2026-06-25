<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Chat_model
 * 
 * Handles all database operations for buyer/company chat system.
 * Standard chats are persistent per buyer/company pair.
 * Orders are attached to chats via order_chat_links.
 */
class Chat_model extends CI_Model
{
    private $has_order_links_table = null;

    private function reopen_standard_chat_if_needed($chat)
    {
        if (!$chat) {
            return $chat;
        }

        if (($chat->chatType ?? 'standard') === 'standard' && ($chat->chatStatus ?? 'open') !== 'open') {
            $this->db->where('chatID', (int)$chat->chatID)->update('order_chats', [
                'chatStatus' => 'open',
                'lockedAt' => null
            ]);
            $chat->chatStatus = 'open';
            $chat->lockedAt = null;
        }

        return $chat;
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function has_order_links_table()
    {
        if ($this->has_order_links_table === null) {
            $this->has_order_links_table = $this->db->table_exists('order_chat_links');
        }
        return $this->has_order_links_table;
    }

    /**
     * Ensure one persistent standard chat per buyer/company pair and attach order to it.
     *
     * @param int $orderID unified order ID from orders table
     * @param int $buyerUserID
     * @param int $sellerCompanyID
     * @return int|false
     */
    public function create_chat($orderID, $buyerUserID, $sellerCompanyID)
    {
        $orderID = (int)$orderID;
        $buyerUserID = (int)$buyerUserID;
        $sellerCompanyID = (int)$sellerCompanyID;

        $chatID = $this->get_or_create_company_chat($buyerUserID, $sellerCompanyID);
        if (!$chatID) {
            return false;
        }

        if ($orderID > 0) {
            $this->link_order_to_chat((int)$chatID, $orderID);
        }

        return (int)$chatID;
    }

    /**
     * Resolve a chat by order ID.
     * Uses order_chat_links first, then falls back to legacy order_chats.orderID.
     */
    public function get_chat_by_order($orderID)
    {
        $orderID = (int)$orderID;
        if ($orderID <= 0) {
            return null;
        }

        $order = $this->db->select('
                COALESCE(ep.buyerUserID, wp.buyerUserID) AS buyerUserID,
                COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) AS sellerCompanyID
            ', false)
            ->from('orders o')
            ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->where('o.orderID', $orderID)
            ->limit(1)
            ->get()
            ->row();

        if ($order && !empty($order->buyerUserID) && !empty($order->sellerCompanyID)) {
            $canonical_chat_id = $this->get_or_create_company_chat((int)$order->buyerUserID, (int)$order->sellerCompanyID);
            if (!empty($canonical_chat_id)) {
                $this->link_order_to_chat((int)$canonical_chat_id, $orderID);
                return $this->get_chat_by_id((int)$canonical_chat_id);
            }
        }

        if ($this->has_order_links_table()) {
            $chat = $this->db->select('c.*')
                ->from('order_chat_links ocl')
                ->join('order_chats c', 'c.chatID = ocl.chatID', 'inner')
                ->where('ocl.orderID', $orderID)
                ->order_by('ocl.linkID', 'DESC')
                ->limit(1)
                ->get()
                ->row();
            if ($chat) {
                return $this->reopen_standard_chat_if_needed($chat);
            }
        }

        $legacy = $this->db->get_where('order_chats', ['orderID' => $orderID])->row();
        return $this->reopen_standard_chat_if_needed($legacy);
    }

    /**
     * Ensure an order resolves to a persistent chat.
     * If no mapping exists yet, derive buyer/company from order payments and attach it.
     *
     * @param int $orderID
     * @return object|null
     */
    public function ensure_chat_for_order($orderID)
    {
        $orderID = (int)$orderID;
        if ($orderID <= 0) {
            return null;
        }

        $order = $this->db->select('
                o.orderID,
                COALESCE(ep.buyerUserID, wp.buyerUserID) AS buyerUserID,
                COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) AS sellerCompanyID
            ', false)
            ->from('orders o')
            ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->where('o.orderID', $orderID)
            ->limit(1)
            ->get()
            ->row();

        if (!$order || empty($order->buyerUserID) || empty($order->sellerCompanyID)) {
            return null;
        }

        $chatID = $this->get_or_create_company_chat((int)$order->buyerUserID, (int)$order->sellerCompanyID);
        if (!$chatID) {
            return null;
        }

        // Force canonical mapping so all orders for this pair resolve to one shared chat.
        $this->link_order_to_chat((int)$chatID, $orderID);
        $chat = $this->get_chat_by_id((int)$chatID);
        return $this->reopen_standard_chat_if_needed($chat);
    }

    /**
     * Get chat by chat ID
     * 
     * @param int $chatID
     * @return object|null
     */
    public function get_chat_by_id($chatID)
    {
        $chat = $this->db->get_where('order_chats', [
            'chatID' => $chatID
        ])->row();
        return $this->reopen_standard_chat_if_needed($chat);
    }

    public function get_or_create_company_chat($buyerUserID, $sellerCompanyID)
    {
        $buyerUserID = (int)$buyerUserID;
        $sellerCompanyID = (int)$sellerCompanyID;

        $existing = $this->db->select('*')
            ->from('order_chats')
            ->where('buyerUserID', $buyerUserID)
            ->where('sellerCompanyID', $sellerCompanyID)
            ->where('chatType', 'standard')
            ->order_by('chatStatus', 'DESC')
            ->order_by('chatID', 'ASC')
            ->get()
            ->result();

        if (!empty($existing)) {
            $canonical = $existing[0];
            if ($canonical->chatStatus !== 'open') {
                $this->db->where('chatID', (int)$canonical->chatID)->update('order_chats', [
                    'chatStatus' => 'open',
                    'lockedAt' => null
                ]);
                $canonical->chatStatus = 'open';
            }
            return (int)$canonical->chatID;
        }

        $data = [
            'orderID' => null,
            'buyerUserID' => $buyerUserID,
            'sellerCompanyID' => $sellerCompanyID,
            'chatStatus' => 'open',
            'chatType' => 'standard',
            'createdAt' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('order_chats', $data)) {
            return (int)$this->db->insert_id();
        }

        return false;
    }

    /**
     * Backward-compatible alias used by existing controllers/views.
     */
    public function get_or_create_direct_chat($buyerUserID, $sellerCompanyID)
    {
        return $this->get_or_create_company_chat($buyerUserID, $sellerCompanyID);
    }

    public function link_order_to_chat($chatID, $orderID)
    {
        $chatID = (int)$chatID;
        $orderID = (int)$orderID;
        if ($chatID <= 0 || $orderID <= 0) {
            return false;
        }

        if ($this->has_order_links_table()) {
            $existing = $this->db->get_where('order_chat_links', ['orderID' => $orderID])->row();
            if ($existing) {
                if ((int)$existing->chatID !== $chatID) {
                    $this->db->where('orderID', $orderID)->update('order_chat_links', ['chatID' => $chatID]);
                }
                return true;
            }

            return $this->db->insert('order_chat_links', [
                'chatID' => $chatID,
                'orderID' => $orderID,
                'linkedAt' => date('Y-m-d H:i:s')
            ]);
        }

        // Legacy fallback when mapping table is not yet migrated.
        return $this->db->where('chatID', $chatID)
            ->update('order_chats', ['orderID' => $orderID]);
    }

    /**
     * Validate if user has access to this chat
     * User must be either the buyer or belong to the seller company
     * 
     * @param int $chatID
     * @param int $userID
     * @return array ['has_access' => bool, 'role' => 'buyer'|'seller'|null]
     */
    public function validate_user_access($chatID, $userID)
    {
        $chat = $this->get_chat_by_id($chatID);

        if (!$chat) {
            log_message('error', "[Chat_model] validate_user_access: Chat ID {$chatID} not found");
            return ['has_access' => false, 'role' => null];
        }

        // SuperAdmin can access dispute chats as third-party mediator.
        $user = $this->db->select('userType')
            ->from('users')
            ->where('userID', $userID)
            ->limit(1)
            ->get()
            ->row();
        if ($user && intval($user->userType) === 1 && isset($chat->chatType) && $chat->chatType === 'dispute') {
            log_message('info', "[Chat_model] ✓ User {$userID} is SUPERADMIN for dispute chat {$chatID}");
            return ['has_access' => true, 'role' => 'superadmin'];
        }

        log_message('info', "[Chat_model] validate_user_access: Chat ID {$chatID}, User ID {$userID}");
        log_message('info', "[Chat_model] Chat buyerUserID: {$chat->buyerUserID}, sellerCompanyID: {$chat->sellerCompanyID}");

        // Check if user is the buyer
        if ($chat->buyerUserID == $userID) {
            log_message('info', "[Chat_model] ✓ User {$userID} is BUYER");
            return ['has_access' => true, 'role' => 'buyer'];
        }

        log_message('info', "[Chat_model] ✗ User {$userID} is NOT the buyer (buyer is {$chat->buyerUserID})");

        // Check if user belongs to seller company (is company admin/owner)
        $this->db->select('companyID');
        $this->db->from('companydetail');
        $this->db->where('userID', $userID);
        $this->db->where('companyID', $chat->sellerCompanyID);
        $company_owner = $this->db->get()->row();

        if ($company_owner) {
            log_message('info', "[Chat_model] ✓ User {$userID} is company OWNER");
            return ['has_access' => true, 'role' => 'seller'];
        }

        // Check if user is an employee of the seller company
        $this->db->select('userID');
        $this->db->from('usercompanyworkforcelink');
        $this->db->where('userID', $userID);
        $this->db->where('companyID', $chat->sellerCompanyID);
        $company_employee = $this->db->get()->row();

        if ($company_employee) {
            log_message('info', "[Chat_model] ✓ User {$userID} is company EMPLOYEE");
            return ['has_access' => true, 'role' => 'seller'];
        }

        log_message('error', "[Chat_model] ✗ User {$userID} has NO ACCESS to chat {$chatID}");
        return ['has_access' => false, 'role' => null];
    }

    /**
     * Save a new message
     * 
     * @param int $chatID
     * @param int $senderUserID
     * @param string $messageText
     * @return int|false messageID on success, false on failure
     */
    public function save_message($chatID, $senderUserID, $messageText)
    {
        // Validate chat exists and is open
        $chat = $this->get_chat_by_id($chatID);

        if (!$chat || $chat->chatStatus !== 'open') {
            return false;
        }

        // Validate user has access
        $access = $this->validate_user_access($chatID, $senderUserID);
        if (!$access['has_access']) {
            return false;
        }

        // Sanitize and validate message
        $messageText = trim($messageText);
        if (empty($messageText) || strlen($messageText) > 2500) {
            return false;
        }

        $data = [
            'chatID' => $chatID,
            'senderUserID' => $senderUserID,
            'messageText' => $messageText,
            'createdAt' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('order_chat_messages', $data)) {
            return $this->db->insert_id();
        }

        return false;
    }

    /**
     * Get all messages for a chat
     * Returns messages in chronological order
     * 
     * @param int $chatID
     * @param int $limit (optional)
     * @return array
     */
    public function get_messages($chatID, $limit = 500)
    {
        $this->db->select('m.*, u.userName as firstName, "" as lastName, u.userEmail as email');
        $this->db->from('order_chat_messages m');
        $this->db->join('users u', 'u.userID = m.senderUserID', 'left');
        $this->db->where('m.chatID', $chatID);
        $this->db->order_by('m.createdAt', 'ASC');
        $this->db->limit($limit);

        return $this->db->get()->result();
    }

    /**
     * Lock a chat (when order is completed/cancelled)
     *
     * For dispute chats, locking is blocked while the linked issue is unresolved
     * unless explicitly forced by superadmin resolution flow.
     *
     * @param int $chatID
     * @param bool $force
     * @return bool
     */
    public function lock_chat($chatID, $force = false)
    {
        $chat = $this->get_chat_by_id($chatID);
        if (!$chat) {
            return false;
        }

        // Standard conversations are persistent and must remain open 24/7.
        if (($chat->chatType ?? 'standard') === 'standard') {
            return true;
        }

        if (!$force && $chat->chatType === 'dispute' && !empty($chat->disputeIssueID)) {
            $issue = $this->db->select('issueStatus')
                ->from('rental_issues')
                ->where('issueID', intval($chat->disputeIssueID))
                ->get()->row();

            if ($issue && !in_array($issue->issueStatus, ['resolved', 'closed'], true)) {
                log_message('info', "lock_chat blocked for unresolved dispute chat {$chatID} (issue {$chat->disputeIssueID})");
                return false;
            }
        }

        $data = [
            'chatStatus' => 'locked',
            'lockedAt' => date('Y-m-d H:i:s')
        ];

        $this->db->where('chatID', $chatID);
        return $this->db->update('order_chats', $data);
    }

    /**
     * Get chat status
     * 
     * @param int $chatID
     * @return string|null 'open'|'locked'|null
     */
    public function get_chat_status($chatID)
    {
        $chat = $this->get_chat_by_id($chatID);
        return $chat ? $chat->chatStatus : null;
    }

    public function get_chat_details($chatID)
    {
        $this->db->select("
            c.chatID,
            c.buyerUserID,
            c.sellerCompanyID,
            c.chatStatus,
            c.chatType,
            c.disputeIssueID,
            c.createdAt,
            c.lockedAt,
            buyer.userName as buyerFirstName,
            \"\" as buyerLastName,
            buyer.userEmail as buyerEmail,
            company.companyName as sellerCompanyName,
            seller_user.userName as sellerUserName
        ", false);
        $this->db->from('order_chats c');
        $this->db->join('users buyer', 'buyer.userID = c.buyerUserID', 'left');
        $this->db->join('companydetail company', 'company.companyID = c.sellerCompanyID', 'left');
        $this->db->join('users seller_user', 'seller_user.userID = company.userID', 'left');
        $this->db->where('c.chatID', $chatID);

        $chat = $this->db->get()->row();
        if (!$chat) {
            return null;
        }

        $orders = $this->get_chat_orders((int)$chatID, 1);
        $latest_order = !empty($orders) ? $orders[0] : null;

        $chat->orderID = $latest_order ? (int)$latest_order->orderID : null;
        $chat->grossAmount = $latest_order ? (float)$latest_order->grossAmount : 0.0;
        $chat->orderStatus = $latest_order ? (string)$latest_order->orderStatus : '';
        $chat->ordersCount = (int)$this->get_chat_order_count((int)$chatID);

        return $chat;
    }

    public function get_chat_order_count($chatID)
    {
        $chatID = (int)$chatID;
        if ($chatID <= 0) {
            return 0;
        }

        if ($this->has_order_links_table()) {
            return (int)$this->db->from('order_chat_links')->where('chatID', $chatID)->count_all_results();
        }

        $chat = $this->get_chat_by_id($chatID);
        return (!empty($chat) && !empty($chat->orderID)) ? 1 : 0;
    }

    public function get_chat_orders($chatID, $limit = 50)
    {
        $chatID = (int)$chatID;
        $limit = (int)$limit;

        if ($chatID <= 0) {
            return [];
        }

        if ($this->has_order_links_table()) {
            $this->db->select("
                ocl.orderID,
                o.createdAt as orderCreatedAt,
                COALESCE(ep.grossAmount, wp.grossAmount, 0) as grossAmount,
                COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus, 'open') as orderStatus,
                CASE
                    WHEN o.equipmentPaymentID IS NOT NULL THEN 'equipment'
                    ELSE 'workforce'
                END as orderType
            ", false);
            $this->db->from('order_chat_links ocl');
            $this->db->join('orders o', 'o.orderID = ocl.orderID', 'inner');
            $this->db->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left');
            $this->db->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left');
            $this->db->where('ocl.chatID', $chatID);
            $this->db->order_by('ocl.linkID', 'DESC');
            if ($limit > 0) {
                $this->db->limit($limit);
            }
            return $this->db->get()->result();
        }

        $legacy_chat = $this->get_chat_by_id($chatID);
        if (!$legacy_chat || empty($legacy_chat->orderID)) {
            return [];
        }

        return [(object)[
            'orderID' => (int)$legacy_chat->orderID,
            'orderCreatedAt' => $legacy_chat->createdAt,
            'grossAmount' => 0,
            'orderStatus' => 'open',
            'orderType' => 'legacy',
        ]];
    }

    /**
     * Send an automated system message in a chat
     * Used for approval/rejection notifications, shipping updates, etc.
     * 
     * @param int $chatID
     * @param string $message
     * @param int $companyID Sender company ID (will resolve to admin userID)
     * @param string $senderType 'system'|'seller'|'buyer' (for logging, not stored)
     * @return int|false messageID on success, false on failure
     */
    public function send_automated_message($chatID, $message, $companyID, $senderType = 'system')
    {
        $message = $this->sanitizeAutomatedMessage($message);

        // Verify chat exists
        $chat = $this->get_chat_by_id($chatID);
        if (!$chat) {
            log_message('error', "Cannot send automated message: Chat {$chatID} not found");
            return false;
        }

        // Get the admin userID for this company
        $admin = $this->db->select('userID')
                         ->from('companydetail')
                         ->where('companyID', $companyID)
                         ->get()
                         ->row();
        
        if (!$admin) {
            log_message('error', "Cannot send automated message: Company {$companyID} admin userID not found");
            return false;
        }

        $data = [
            'chatID' => $chatID,
            'senderUserID' => $admin->userID,
            'messageText' => $message,
            'createdAt' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('order_chat_messages', $data)) {
            $messageID = $this->db->insert_id();
            log_message('info', "Automated message sent to chat {$chatID} by user {$admin->userID}: {$message}");
            return $messageID;
        }

        log_message('error', "Failed to send automated message to chat {$chatID}");
        return false;
    }

    /**
     * Send an automated message in a chat directly as a specific user (e.g. buyer side)
     *
     * @param int $chatID
     * @param string $message
     * @param int $userID  The userID to send as (buyer)
     * @return int|false messageID on success, false on failure
     */
    public function send_automated_message_as_user($chatID, $message, $userID)
    {
        $message = $this->sanitizeAutomatedMessage($message);

        $data = [
            'chatID'       => $chatID,
            'senderUserID' => $userID,
            'messageText'  => $message,
            'createdAt'    => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('order_chat_messages', $data)) {
            $messageID = $this->db->insert_id();
            log_message('info', "Automated buyer message sent to chat {$chatID} by user {$userID}");
            return $messageID;
        }

        log_message('error', "Failed to send automated buyer message to chat {$chatID}");
        return false;
    }

    /**
     * Upgrade a standard chat to a dispute chat
     * Called when an issue is reported on a rental
     *
     * @param int $chatID
     * @param int $issue_id The rental_issues ID this dispute is about
     * @return bool
     */
    public function upgrade_to_dispute_chat($chatID, $issue_id)
    {
        $chat = $this->get_chat_by_id($chatID);
        if (!$chat) {
            log_message('error', "upgrade_to_dispute_chat: Chat {$chatID} not found");
            return false;
        }

        $this->db->update('order_chats', [
            'chatType'           => 'dispute',
            'disputeIssueID'     => $issue_id,
            'superAdminJoinedAt' => date('Y-m-d H:i:s'),
            'chatStatus'         => 'open',
            'lockedAt'           => null,
        ], ['chatID' => $chatID]);

        // Post a system message notifying escalation
        $system_msg = "🚨 This chat has been escalated to a dispute.\n"
                    . "Issue ID #{$issue_id} has been reported.\n"
                    . "A platform administrator has been added and will review the dispute shortly.\n"
                    . "Please continue to communicate here.";

        // Insert as system message (using sellerCompanyID as sender company)
        $admin = $this->db->select('userID')
            ->from('companydetail')
            ->where('companyID', $chat->sellerCompanyID)
            ->get()->row();

        if ($admin) {
            $this->db->insert('order_chat_messages', [
                'chatID'       => $chatID,
                'senderUserID' => $admin->userID,
                'messageText'  => $system_msg,
                'createdAt'    => date('Y-m-d H:i:s'),
            ]);
        }

        log_message('info', "Chat {$chatID} upgraded to dispute chat for issue {$issue_id}");
        return true;
    }

    /**
     * Normalize dispute chat state after resolution.
     *
     * IMPORTANT: Keep dispute linkage (chatType/disputeIssueID) intact so
     * superadmin can always review full history and ongoing messages.
     *
     * @param int $chatID
     * @param bool $keep_open
     * @return bool
     */
    public function deescalate_dispute_chat($chatID, $keep_open = true)
    {
        $chat = $this->get_chat_by_id($chatID);
        if (!$chat) {
            return false;
        }

        if ($keep_open) {
            $data = [
                'chatStatus' => 'open',
                'lockedAt'   => null,
            ];
        } else {
            $data = [
                'chatStatus' => 'locked',
                'lockedAt'   => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->where('chatID', $chatID);
        return $this->db->update('order_chats', $data);
    }

    /**
     * Get all dispute chats for SuperAdmin management
     *
     * @param array $filters Optional: ['status' => 'open'|'locked']
     * @return array
     */
    public function get_dispute_chats($filters = [])
    {
        $has_chat_links = $this->has_order_links_table();

        $query = $this->db->select('
            c.chatID,
            COALESCE(ri.orderID, c.orderID) as orderID,
            c.chatStatus,
            c.chatType,
            c.disputeIssueID,
            c.superAdminJoinedAt,
            buyer.userName as buyerName,
            buyer.userEmail as buyerEmail,
            company.companyName,
            ri.issueType,
            ri.issueTitle,
            ri.issueStatus,
            ri.reportedAt,
            COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount
        ', false)
        ->from('order_chats c')
        ->join('users buyer', 'buyer.userID = c.buyerUserID', 'left')
        ->join('companydetail company', 'company.companyID = c.sellerCompanyID', 'left')
        ->join('rental_issues ri', 'ri.issueID = c.disputeIssueID', 'left');

        if ($has_chat_links) {
            $query->join('order_chat_links ocl', 'ocl.chatID = c.chatID', 'left')
                ->join('orders o', 'o.orderID = COALESCE(ri.orderID, ocl.orderID, c.orderID)', 'left');
        } else {
            $query->join('orders o', 'o.orderID = COALESCE(ri.orderID, c.orderID)', 'left');
        }

        $query->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->where('c.chatType', 'dispute');

        if (!empty($filters['status'])) {
            $query->where('c.chatStatus', $filters['status']);
        }

        return $query->order_by('c.superAdminJoinedAt', 'DESC')
            ->get()->result();
    }

    /**
     * Check if a SuperAdmin is attached to this dispute chat
     *
     * @param int $chatID
     * @return bool
     */
    public function is_dispute_chat($chatID)
    {
        $chat = $this->get_chat_by_id($chatID);
        return $chat && $chat->chatType === 'dispute';
    }

    /**
     * Normalize automated/system messages to avoid placeholder artifacts like "????".
     *
     * @param string|null $message
     * @return string
     */
    private function sanitizeAutomatedMessage($message)
    {
        $clean = (string)$message;

        // Normalize known corruption patterns seen in current dataset.
        $clean = str_replace(['????', 'G��', "\xEF\xBF\xBD", '�'], '', $clean);

        // Remove emoji glyphs from automated text to keep DB output stable.
        $clean = preg_replace('/[\x{1F1E6}-\x{1F1FF}\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}\x{FE0F}]/u', '', $clean);

        // Keep content readable.
        $clean = preg_replace('/[ \t]{2,}/', ' ', $clean);
        $clean = preg_replace('/\n{3,}/', "\n\n", $clean);

        return trim($clean);
    }
}
