<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Status Display Helper
 *
 * Returns Bootstrap 4 badge HTML for various rental/payment/issue statuses.
 */

if (!function_exists('get_rental_status_badge')) {
    /**
     * Get Bootstrap badge for rental request / rental lifecycle status
     *
     * @param string $status
     * @return string HTML badge
     */
    function get_rental_status_badge($status)
    {
        $map = [
            // Purchase workflow
            'requested'        => ['warning',   'Pending Approval'],
            'payment_pending'  => ['info',      'Awaiting Payment'],
            'payment_secured'  => ['primary',   'Payment Secured'],
            'shipped'          => ['info',      'Shipped'],
            'pickup_ready'     => ['info',      'Ready for Pickup'],
            'delivered'        => ['info',      'Delivered'],
            'completed'        => ['dark',      'Completed'],
            'cancelled'        => ['secondary', 'Cancelled'],
            'rejected'         => ['danger',    'Rejected'],
            // Rental workflow
            'request_pending'  => ['warning',   'Pending Approval'],
            'request_approved' => ['info',      'Approved – Pay Now'],
            'request_rejected' => ['danger',    'Rejected'],
            'rental_active'    => ['success',   '▶ Active Rental'],
            'rental_overdue'   => ['danger',    '⚠ Overdue'],
            'rental_completed' => ['dark',      'Completed'],
            'rental_cancelled' => ['secondary', 'Cancelled'],
            'under_review'     => ['warning',   '🚨 Under Review'],
        ];

        if (!isset($map[$status])) {
            return '<span class="badge badge-secondary">' . htmlspecialchars($status) . '</span>';
        }

        [$color, $label] = $map[$status];
        return '<span class="badge badge-' . $color . '">' . htmlspecialchars($label) . '</span>';
    }
}

if (!function_exists('get_payment_status_badge')) {
    /**
     * Get Bootstrap badge for payment status
     *
     * @param string $status
     * @return string HTML badge
     */
    function get_payment_status_badge($status)
    {
        $map = [
            'pending'   => ['warning',   'Pending'],
            'paid'      => ['success',   'Paid'],
            'failed'    => ['danger',    'Failed'],
            'refunded'  => ['info',      'Refunded'],
            'cancelled' => ['secondary', 'Cancelled'],
        ];

        if (!isset($map[$status])) {
            return '<span class="badge badge-secondary">' . htmlspecialchars($status) . '</span>';
        }

        [$color, $label] = $map[$status];
        return '<span class="badge badge-' . $color . '">' . htmlspecialchars($label) . '</span>';
    }
}

if (!function_exists('get_issue_status_badge')) {
    /**
     * Get Bootstrap badge for issue status
     *
     * @param string $status
     * @return string HTML badge
     */
    function get_issue_status_badge($status)
    {
        $map = [
            'reported'     => ['danger',    '🚨 Reported'],
            'under_review' => ['warning',   '🔍 Under Review'],
            'resolved'     => ['success',   '✅ Resolved'],
            'closed'       => ['dark',      'Closed'],
        ];

        if (!isset($map[$status])) {
            return '<span class="badge badge-secondary">' . htmlspecialchars($status) . '</span>';
        }

        [$color, $label] = $map[$status];
        return '<span class="badge badge-' . $color . '">' . htmlspecialchars($label) . '</span>';
    }
}

if (!function_exists('get_issue_type_label')) {
    /**
     * Get human-readable label for issue type
     *
     * @param string $type
     * @return string
     */
    function get_issue_type_label($type)
    {
        $map = [
            'late_delivery'  => 'Late Delivery',
            'late_return'    => 'Late Return',
            'damaged'        => 'Damaged Equipment',
            'missing_parts'  => 'Missing Parts',
            'malfunction'    => 'Equipment Malfunction',
            'other'          => 'Other',
        ];
        return isset($map[$type]) ? $map[$type] : ucfirst(str_replace('_', ' ', $type));
    }
}
