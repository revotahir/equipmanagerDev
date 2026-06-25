<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Payment_helper
 * 
 * Helper functions for payment-related operations including chat management
 */

if (!function_exists('lock_chat_for_order')) {
    /**
     * Lock chat when order is completed/cancelled
     * 
     * @param int $orderID Unified order ID
     * @return bool
     */
    function lock_chat_for_order($orderID)
    {
        $CI = &get_instance();
        $CI->load->model('Chat_model');

        // Get chat for this order
        $chat = $CI->Chat_model->get_chat_by_order((int)$orderID);

        if ($chat && $chat->chatStatus === 'open') {
            // Lock the chat
            $CI->Chat_model->lock_chat($chat->chatID);

            // Notify Node.js server
            if (($chat->chatType ?? 'standard') !== 'standard') {
                notify_node_chat_locked($chat->chatID);
            }

            log_message('info', "Chat {$chat->chatID} updated for order {$orderID}");
            return true;
        }

        return false;
    }
}

if (!function_exists('notify_node_chat_locked')) {
    /**
     * Notify Node.js server that chat is locked
     * 
     * @param int $chatID
     */
    function notify_node_chat_locked($chatID)
    {
        $nodeServerUrl = getenv('NODE_SERVER_URL') ?: 'http://localhost:3000';

        $ch = curl_init($nodeServerUrl . '/api/chat-locked');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['chat_id' => $chatID]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2); // Don't wait long

        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            log_message('info', "Node.js notified of chat {$chatID} lock");
        } else {
            log_message('error', "Failed to notify Node.js of chat {$chatID} lock (HTTP {$http_code})");
        }
    }
}
