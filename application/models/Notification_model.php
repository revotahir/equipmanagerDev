<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Notification_model
 *
 * Handles in-platform notification storage and retrieval.
 * Supports 15 notification types across the rental lifecycle.
 */
class Notification_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Create a new notification for a user
     *
     * @param int $user_id Recipient user ID
     * @param string $type Notification type enum value
     * @param string $title Short title
     * @param string $body Full notification body text
     * @param int|null $order_id Related order ID
     * @param string|null $action_url URL to navigate to on click
     * @param int|null $issue_id Related issue ID
     * @return int|false notificationID on success
     */
    public function createNotification($user_id, $type, $title, $body, $order_id = null, $action_url = null, $issue_id = null)
    {
        $title = $this->sanitizeNotificationText($title);
        $body = $this->sanitizeNotificationText($body);

        $data = [
            'userID'             => $user_id,
            'notificationType'   => $type,
            'notificationTitle'  => $title,
            'notificationBody'   => $body,
            'relatedOrderID'     => $order_id,
            'relatedIssueID'     => $issue_id,
            'actionUrl'          => $action_url,
            'isRead'             => 0,
            'createdAt'          => date('Y-m-d H:i:s'),
        ];

        if ($this->db->insert('notifications', $data)) {
            return $this->db->insert_id();
        }

        log_message('error', "Notification_model::createNotification failed for user {$user_id}, type {$type}");
        return false;
    }

    /**
     * Normalize notification text to prevent placeholder artifacts like "????".
     *
     * @param string|null $text
     * @return string
     */
    private function sanitizeNotificationText($text)
    {
        $clean = (string)$text;

        // Remove broken replacement sequences observed in old dumps.
        $clean = str_replace(['????', 'G��', "\xEF\xBF\xBD", '�'], '', $clean);

        // Drop emoji symbols to avoid any UTF fallback corruption in mixed environments.
        $clean = preg_replace('/[\x{1F1E6}-\x{1F1FF}\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}\x{FE0F}]/u', '', $clean);

        // Collapse extra whitespace while preserving line breaks.
        $clean = preg_replace('/[ \t]{2,}/', ' ', $clean);
        $clean = preg_replace('/\n{3,}/', "\n\n", $clean);

        return trim($clean);
    }

    /**
     * Get notifications for a user
     *
     * @param int $user_id
     * @param int $limit
     * @param int $offset
     * @param bool $unread_only Return only unread
     * @return array
     */
    public function getUserNotifications($user_id, $limit = 20, $offset = 0, $unread_only = false)
    {
        $this->db->where('userID', $user_id);

        if ($unread_only) {
            $this->db->where('isRead', 0);
        }

        return $this->db->order_by('createdAt', 'DESC')
            ->limit($limit, $offset)
            ->get('notifications')
            ->result();
    }

    /**
     * Get unread notification count for a user
     *
     * @param int $user_id
     * @return int
     */
    public function getUnreadCount($user_id)
    {
        return $this->db->where('userID', $user_id)
            ->where('isRead', 0)
            ->count_all_results('notifications');
    }

    /**
     * Mark a specific notification as read
     *
     * @param int $notification_id
     * @param int $user_id Prevent marking others' notifications
     * @return bool
     */
    public function markAsRead($notification_id, $user_id)
    {
        return $this->db->update('notifications', [
            'isRead' => 1,
            'readAt' => date('Y-m-d H:i:s'),
        ], [
            'notificationID' => $notification_id,
            'userID'         => $user_id,
        ]);
    }

    /**
     * Mark all notifications as read for a user
     *
     * @param int $user_id
     * @return bool
     */
    public function markAllAsRead($user_id)
    {
        return $this->db->update('notifications', [
            'isRead' => 1,
            'readAt' => date('Y-m-d H:i:s'),
        ], [
            'userID' => $user_id,
            'isRead' => 0,
        ]);
    }

    /**
     * Delete a single notification
     *
     * @param int $notification_id
     * @param int $user_id Safety check
     * @return bool
     */
    public function deleteNotification($notification_id, $user_id)
    {
        return $this->db->delete('notifications', [
            'notificationID' => $notification_id,
            'userID'         => $user_id,
        ]);
    }

    /**
     * Delete old notifications (cleanup cron)
     *
     * @param int $days_old Delete notifications older than this many days
     * @return int Number of rows deleted
     */
    public function deleteOldNotifications($days_old = 90)
    {
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$days_old} days"));
        $this->db->where('createdAt <', $cutoff)
                 ->where('isRead', 1)
                 ->delete('notifications');
        return $this->db->affected_rows();
    }

    /**
     * Get count of all notifications for pagination
     *
     * @param int $user_id
     * @return int
     */
    public function getTotalCount($user_id)
    {
        return $this->db->where('userID', $user_id)
            ->count_all_results('notifications');
    }
}
