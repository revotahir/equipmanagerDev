<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Notification Helper
 *
 * Provides a simple interface to send in-platform notifications.
 * Maps notification types to human-readable templates and persists them.
 */

if (!function_exists('send_notification')) {
    /**
     * Resolve userType for role-aware notification routing.
     * userType: 1=superadmin, 2/3=company/admin, others=renter/user
     */
    function _notification_user_type($user_id)
    {
        $CI =& get_instance();
        $row = $CI->db->select('userType')
            ->from('users')
            ->where('userID', (int)$user_id)
            ->limit(1)
            ->get()
            ->row();

        return isset($row->userType) ? (int)$row->userType : 4;
    }

    function _is_employee_user($user_id)
    {
        $CI =& get_instance();
        $row = $CI->db->select('userID')
            ->from('usercompanyworkforcelink')
            ->where('userID', (int)$user_id)
            ->limit(1)
            ->get()
            ->row();

        return !empty($row);
    }

    /**
     * Build action URL based on recipient role + notification type.
     */
    function _notification_action_url($user_id, $user_type, $type, $order_id = null, $issue_id = null)
    {
        $is_superadmin = ($user_type === 1);
        $is_company    = in_array($user_type, [2, 3], true);
        $is_employee   = ($user_type === 4 && _is_employee_user($user_id));

        // Allow issue notifications to deep-link superadmins directly to issue detail.
        if (in_array($type, ['issue_reported', 'issue_resolved'], true)) {
            if ($is_superadmin) {
                if (!empty($issue_id)) {
                    return site_url('superadmin/issue_detail/' . (int)$issue_id);
                }
                return site_url('superadmin/issues');
            }

            if (!empty($order_id)) {
                if ($is_employee) {
                    return site_url('employee/dashboard');
                }
                return $is_company
                    ? site_url('company-orders/view/' . (int)$order_id)
                    : site_url('orders/' . (int)$order_id);
            }

            if ($is_employee) {
                return site_url('employee/dashboard');
            }
            return $is_company ? site_url('company-orders') : site_url('orders');
        }

        // Order-centric notifications route to order detail pages by role.
        if (!empty($order_id)) {
            if ($is_superadmin) {
                return site_url('super-admin-orders/view/' . (int)$order_id);
            }
            if ($is_company) {
                return site_url('company-orders/view/' . (int)$order_id);
            }
            if ($is_employee) {
                return site_url('employee/dashboard');
            }
            return site_url('orders/' . (int)$order_id);
        }

        // Fallback list pages when order is not available.
        if ($is_superadmin) {
            return site_url('super-admin-orders');
        }
        if ($is_company) {
            return site_url('company-orders');
        }
        if ($is_employee) {
            return site_url('notifications');
        }
        return site_url('orders');
    }

    /**
     * Send an in-platform notification to a user
     *
     * @param int $user_id Recipient user ID
     * @param string $type Notification type (see ENUM in notifications table)
     * @param int|null $order_id Related order ID
     * @param array $extra_data Extra context data for template substitution
     * @param int|null $issue_id Related issue ID
     * @return int|false Notification ID or false on failure
     */
    function send_notification($user_id, $type, $order_id = null, $extra_data = [], $issue_id = null)
    {
        $CI =& get_instance();
        $CI->load->model('Notification_model');

        // Template map — title and body for each notification type
        $templates = [
            'rental_request_created' => [
                'title' => 'New Rental Request',
                'body'  => 'You have received a new rental request. Review and approve or reject it from your orders dashboard.',
            ],
            'rental_approved' => [
                'title' => 'Rental Approved',
                'body'  => 'Your rental request has been approved! A payment link has been sent in the order chat. Complete payment to secure your booking.',
            ],
            'rental_rejected' => [
                'title' => 'Rental Request Rejected',
                'body'  => 'Your rental request has been declined. Check the order chat for details.',
            ],
            'rental_cancelled' => [
                'title' => 'Rental Cancelled',
                'body'  => 'A rental has been cancelled.' . (isset($extra_data['cancelled_by']) ? ' Cancelled by: ' . $extra_data['cancelled_by'] . '.' : ''),
            ],
            'rental_started' => [
                'title' => 'Rental Period Started',
                'body'  => 'Your rental period has officially begun! The equipment should be delivered or ready for pickup.',
            ],
            'rental_overdue' => [
                'title' => 'Rental Overdue',
                'body'  => 'This rental is past its end date. Please confirm the return immediately to avoid further issues.',
            ],
            'rental_completed' => [
                'title' => 'Rental Completed',
                'body'  => 'The rental has been completed successfully. Both parties have confirmed the return.',
            ],
            'payment_received' => [
                'title' => 'Payment Secured in Escrow',
                'body'  => 'Payment has been secured in escrow for this rental. Funds will be released after successful completion.',
            ],
            'payment_released' => [
                'title' => 'Escrow Funds Released',
                'body'  => 'Escrow funds from a completed rental have been approved for payout. Check your payout dashboard.',
            ],
            'issue_reported' => [
                'title' => 'Issue Reported',
                'body'  => 'An issue has been reported for this rental'
                         . (isset($extra_data['issue_type']) ? ' (Type: ' . str_replace('_', ' ', $extra_data['issue_type']) . ')' : '')
                         . '. SuperAdmin will review.',
            ],
            'issue_resolved' => [
                'title' => 'Issue Resolved',
                'body'  => 'The reported issue for your rental has been resolved by the platform administrator.',
            ],
            'return_requested' => [
                'title' => 'Return Requested',
                'body'  => 'The renter has requested/initiated return. Please inspect and confirm receipt to complete the rental lifecycle.',
            ],
            'return_confirmed' => [
                'title' => 'Return Confirmed',
                'body'  => 'The owner has confirmed receipt of the returned equipment. The rental is now complete.',
            ],
            'checkout_link_expiring' => [
                'title' => 'Payment Link Expiring Soon',
                'body'  => 'Your payment link for an approved rental expires in 24 hours. Complete payment now to keep your booking.',
            ],
            'checkout_link_expired' => [
                'title' => 'Rental Request Expired',
                'body'  => 'Your payment window expired, so this rental request is now expired/cancelled. Please submit a new request.',
            ],
            'review_requested' => [
                'title' => 'Leave a Review',
                'body'  => 'Your transaction is complete. Please leave a review for the other party.',
            ],
            'review_received' => [
                'title' => 'New Review Received',
                'body'  => 'You received a new review on a completed transaction.',
            ],
        ];

        if (!isset($templates[$type])) {
            log_message('error', "send_notification: Unknown notification type [{$type}]");
            return false;
        }

        $tpl       = $templates[$type];
        $user_type = _notification_user_type($user_id);
        $action_url = _notification_action_url($user_id, $user_type, $type, $order_id, $issue_id);

        return $CI->Notification_model->createNotification(
            $user_id,
            $type,
            $tpl['title'],
            $tpl['body'],
            $order_id,
            $action_url,
            $issue_id
        );
    }
}

/**
 * Notify all SuperAdmins about an event
 *
 * @param string $type
 * @param int|null $order_id
 * @param array $extra_data
 * @param int|null $issue_id
 */
if (!function_exists('notify_super_admins')) {
    function notify_super_admins($type, $order_id = null, $extra_data = [], $issue_id = null)
    {
        $CI =& get_instance();
        $admins = $CI->db->select('userID')
            ->from('users')
            ->where('userType', 1)
            ->where('userStatus', 1)
            ->get()
            ->result();

        foreach ($admins as $admin) {
            send_notification($admin->userID, $type, $order_id, $extra_data, $issue_id);
        }
    }
}
