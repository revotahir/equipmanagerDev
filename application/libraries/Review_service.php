<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_service
{
    private $CI;
    const REVIEW_WINDOW_DAYS = 0;
    const EDIT_WINDOW_HOURS = 24;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Review_model');
    }

    public function get_order_review_context($order_id, $user_id)
    {
        $order = $this->CI->db->select("
            o.orderID, o.equipmentPaymentID, o.workforcePaymentID,
            ep.buyerUserID as equipBuyerUserID, ep.sellerCompanyID as equipSellerCompanyID, ep.saleType,
            ep.orderStatus as equipOrderStatus, ep.rentalRequestStatus as equipRentalStatus, ep.completedAt as equipCompletedAt, ep.hasActiveIssue as equipHasIssue, ep.refundProcessedAt as equipRefundedAt,
            wp.buyerUserID as workBuyerUserID, wp.sellerCompanyID as workSellerCompanyID,
            wp.orderStatus as workOrderStatus, wp.rentalRequestStatus as workRentalStatus, wp.hasActiveIssue as workHasIssue, wp.refundProcessedAt as workRefundedAt,
            cd.userID as sellerUserID, ucwl.userID as workerUserID
        ", false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID=ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID=wp.workforcePaymentID', 'left')
        ->join('companydetail cd', 'cd.companyID = COALESCE(ep.sellerCompanyID, wp.sellerCompanyID)', 'left')
        ->join('usercompanyworkforcelink ucwl', 'ucwl.workforceID = wp.workforceID', 'left')
        ->where('o.orderID', (int)$order_id)->get()->row_array();

        if (!$order) return ['allowed' => false, 'reason' => 'Order not found'];

        $is_workforce = !empty($order['workforcePaymentID']);
        $is_purchase = !$is_workforce && strtolower((string)$order['saleType']) === 'purchase';
        $is_rental = !$is_purchase;
        $buyer_id = (int)($is_workforce ? $order['workBuyerUserID'] : $order['equipBuyerUserID']);
        $seller_id = (int)$order['sellerUserID'];
        $worker_id = (int)($order['workerUserID'] ?? 0);
        $order_status = strtolower((string)($is_workforce ? $order['workOrderStatus'] : $order['equipOrderStatus']));
        $rental_status = strtolower((string)($is_workforce ? $order['workRentalStatus'] : $order['equipRentalStatus']));
        // Completed transactions are review-eligible even when issue/refund flags exist on legacy rows.

        if ($is_purchase) {
            // Keep purchase eligibility tolerant for legacy rows.
            $completed_ok = in_array($order_status, ['completed', 'delivered'], true);
        } else {
            // Rentals: support lifecycle completion + legacy completed order status.
            $completed_ok = in_array($rental_status, ['rental_completed', 'received_by_owner', 'completed'], true)
                || in_array($order_status, ['completed', 'delivered'], true);
        }
        if (!$completed_ok) return ['allowed' => false, 'reason' => 'Transaction is not completed yet'];

        $completed_at = $order['equipCompletedAt'] ?? null;
        if (self::REVIEW_WINDOW_DAYS > 0) {
            if (empty($completed_at)) $completed_at = date('Y-m-d H:i:s');
            if (strtotime($completed_at . ' +'.self::REVIEW_WINDOW_DAYS.' days') < time()) {
                return ['allowed' => false, 'reason' => 'Review window expired'];
            }
        }

        if ((int)$user_id === $buyer_id) {
            if ($is_workforce) {
                $reviewee_id = $worker_id > 0 ? $worker_id : $seller_id;
                $role = 'client';
                $type = 'workforce';
            } else {
                $reviewee_id = $seller_id;
                $role = $is_purchase ? 'buyer' : 'renter';
                $type = $is_purchase ? 'purchase' : 'rental';
            }
        } elseif ((int)$user_id === $seller_id || ($worker_id > 0 && (int)$user_id === $worker_id)) {
            $reviewee_id = $buyer_id;
            if ($is_workforce && (int)$user_id === $worker_id) {
                $role = 'worker';
                $type = 'workforce';
            } else {
                $role = $is_purchase ? 'seller' : 'owner';
                $type = $is_purchase ? 'purchase' : 'rental';
            }
        } else {
            return ['allowed' => false, 'reason' => 'You are not part of this transaction'];
        }

        return [
            'allowed' => true,
            'order' => $order,
            'reviewee_id' => $reviewee_id,
            'role_type' => $role,
            'transaction_type' => $type,
            'edit_window_expiry' => date('Y-m-d H:i:s', time() + (self::EDIT_WINDOW_HOURS * 3600)),
        ];
    }

    public function weighted_rating_for_user($user_id)
    {
        $rows = $this->CI->Review_model->get_user_reviews($user_id, 'recent');
        if (!$rows) return ['weighted' => 0, 'average' => 0, 'total' => 0];
        $sum = 0.0; $weights = 0.0; $plain = 0.0;
        foreach ($rows as $r) {
            $days = max(0, (time() - strtotime($r->createdAt)) / 86400);
            $w = max(0.15, 1 / (1 + ($days / 30)));
            $sum += ((float)$r->rating) * $w;
            $weights += $w;
            $plain += (float)$r->rating;
        }
        return ['weighted' => round($sum / $weights, 2), 'average' => round($plain / count($rows), 2), 'total' => count($rows)];
    }
}
