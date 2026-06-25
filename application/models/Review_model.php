<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_model extends CI_Model
{
    public function get_workforce_reviewee_user_ids($workforce_id, $company_id = 0)
    {
        $workforce_id = (int)$workforce_id;
        $company_id = (int)$company_id;
        if ($workforce_id <= 0) {
            return [];
        }

        if ($company_id <= 0) {
            $company_id = (int)$this->db->select('companyID')
                ->from('workforce')
                ->where('workforceID', $workforce_id)
                ->get()
                ->row('companyID');
        }

        $ids = [];

        $company_user_id = 0;
        if ($company_id > 0) {
            $company_user_id = (int)$this->db->select('userID')
                ->from('companydetail')
                ->where('companyID', $company_id)
                ->get()
                ->row('userID');
        }
        if ($company_user_id > 0) {
            $ids[] = $company_user_id;
        }

        $worker_rows = $this->db->select('userID')
            ->from('usercompanyworkforcelink')
            ->where('workforceID', $workforce_id)
            ->get()
            ->result_array();

        foreach ($worker_rows as $row) {
            $worker_user_id = (int)($row['userID'] ?? 0);
            if ($worker_user_id > 0) {
                $ids[] = $worker_user_id;
            }
        }

        return array_values(array_unique($ids));
    }

    public function get_company_reviewee_user_ids($company_id)
    {
        $company_user_id = (int)$this->db->select('userID')->from('companydetail')->where('companyID', (int)$company_id)->get()->row('userID');
        $worker_ids = $this->db->select('userID')->from('usercompanyworkforcelink')->where('companyID', (int)$company_id)->get()->result_array();
        $ids = [];
        if ($company_user_id > 0) $ids[] = $company_user_id;
        foreach ($worker_ids as $r) {
            $wid = (int)($r['userID'] ?? 0);
            if ($wid > 0) $ids[] = $wid;
        }
        return array_values(array_unique($ids));
    }

    public function get_company_rating_summary($company_id)
    {
        $reviewee_ids = $this->get_company_reviewee_user_ids((int)$company_id);
        if (empty($reviewee_ids)) return ['avg' => 0, 'total' => 0];

        $row = $this->db->select('AVG(r.rating) as avgRating, COUNT(*) as totalReviews')
            ->from('reviews r')
            ->join('orders o', 'o.orderID = r.orderID', 'inner')
            ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->where('r.visibilityStatus', 'visible')
            ->where_in('r.revieweeID', $reviewee_ids)
            ->group_start()
                ->where('ep.sellerCompanyID', (int)$company_id)
                ->or_where('wp.sellerCompanyID', (int)$company_id)
            ->group_end()
            ->get()->row_array();

        return [
            'avg' => !empty($row['avgRating']) ? round((float)$row['avgRating'], 2) : 0,
            'total' => !empty($row['totalReviews']) ? (int)$row['totalReviews'] : 0,
        ];
    }

    public function get_company_reviews($company_id, $limit = 200)
    {
        $reviewee_ids = $this->get_company_reviewee_user_ids((int)$company_id);
        if (empty($reviewee_ids)) return [];

        return $this->db->select("
                r.*, u.userName as reviewerName,
                COALESCE(e.equipName, wf.personName) as itemName
            ", false)
            ->from('reviews r')
            ->join('users u', 'u.userID = r.reviewerID', 'left')
            ->join('orders o', 'o.orderID = r.orderID', 'inner')
            ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
            ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
            ->where('r.visibilityStatus', 'visible')
            ->where_in('r.revieweeID', $reviewee_ids)
            ->group_start()
                ->where('ep.sellerCompanyID', (int)$company_id)
                ->or_where('wp.sellerCompanyID', (int)$company_id)
            ->group_end()
            ->order_by('r.createdAt', 'DESC')
            ->limit((int)$limit)
            ->get()->result();
    }
    public function create(array $data)
    {
        $this->db->insert('reviews', $data);
        return (int)$this->db->insert_id();
    }

    public function update($review_id, array $data)
    {
        return $this->db->where('reviewID', (int)$review_id)->update('reviews', $data);
    }

    public function get_by_order_and_reviewer($order_id, $reviewer_id)
    {
        return $this->db->from('reviews')
            ->where('orderID', (int)$order_id)
            ->where('reviewerID', (int)$reviewer_id)
            ->get()
            ->row();
    }

    public function get_order_reviews($order_id)
    {
        return $this->db->select('r.*, u.userName as reviewerName')
            ->from('reviews r')
            ->join('users u', 'u.userID = r.reviewerID', 'left')
            ->where('r.orderID', (int)$order_id)
            ->where('r.visibilityStatus', 'visible')
            ->order_by('r.createdAt', 'DESC')
            ->get()
            ->result();
    }

    public function get_user_reviews($user_id, $sort = 'recent')
    {
        $this->db->select('r.*, u.userName as reviewerName')
            ->from('reviews r')
            ->join('users u', 'u.userID = r.reviewerID', 'left')
            ->where('r.revieweeID', (int)$user_id)
            ->where('r.visibilityStatus', 'visible');
        if ($sort === 'highest') {
            $this->db->order_by('r.rating', 'DESC');
        } elseif ($sort === 'lowest') {
            $this->db->order_by('r.rating', 'ASC');
        } else {
            $this->db->order_by('r.createdAt', 'DESC');
        }
        return $this->db->get()->result();
    }

    public function get_item_reviews($item_type, $item_id)
    {
        $field = $item_type === 'workforce' ? 'wp.workforceID' : 'ep.equipmentID';
        return $this->db->select('r.*, u.userName as reviewerName')
            ->from('reviews r')
            ->join('orders o', 'o.orderID = r.orderID', 'inner')
            ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->join('users u', 'u.userID = r.reviewerID', 'left')
            ->where($field, (int)$item_id)
            ->where('r.visibilityStatus', 'visible')
            ->order_by('r.createdAt', 'DESC')
            ->get()
            ->result();
    }

    public function get_workforce_rating_summary($workforce_id, $company_id = 0)
    {
        $workforce_id = (int)$workforce_id;
        if ($workforce_id <= 0) {
            return ['avg' => 0, 'total' => 0];
        }

        $reviewee_ids = $this->get_workforce_reviewee_user_ids($workforce_id, (int)$company_id);
        if (empty($reviewee_ids)) {
            return ['avg' => 0, 'total' => 0];
        }

        $row = $this->db->select('AVG(r.rating) as avgRating, COUNT(*) as totalReviews')
            ->from('reviews r')
            ->join('orders o', 'o.orderID = r.orderID', 'inner')
            ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'inner')
            ->where('wp.workforceID', $workforce_id)
            ->where('r.visibilityStatus', 'visible')
            ->where_in('r.revieweeID', $reviewee_ids)
            ->get()
            ->row_array();

        return [
            'avg' => !empty($row['avgRating']) ? round((float)$row['avgRating'], 2) : 0,
            'total' => !empty($row['totalReviews']) ? (int)$row['totalReviews'] : 0,
        ];
    }

    public function get_workforce_reviews($workforce_id, $company_id = 0, $limit = 20)
    {
        $workforce_id = (int)$workforce_id;
        if ($workforce_id <= 0) {
            return [];
        }

        $reviewee_ids = $this->get_workforce_reviewee_user_ids($workforce_id, (int)$company_id);
        if (empty($reviewee_ids)) {
            return [];
        }

        return $this->db->select("
                r.*,
                reviewer.userName as reviewerName,
                reviewee.userName as revieweeName
            ", false)
            ->from('reviews r')
            ->join('orders o', 'o.orderID = r.orderID', 'inner')
            ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'inner')
            ->join('users reviewer', 'reviewer.userID = r.reviewerID', 'left')
            ->join('users reviewee', 'reviewee.userID = r.revieweeID', 'left')
            ->where('wp.workforceID', $workforce_id)
            ->where('r.visibilityStatus', 'visible')
            ->where_in('r.revieweeID', $reviewee_ids)
            ->order_by('r.createdAt', 'DESC')
            ->limit(max(1, (int)$limit))
            ->get()
            ->result();
    }

    public function get_aggregate_for_user($user_id)
    {
        return $this->db->select('COUNT(*) as totalReviews, AVG(rating) as averageRating')
            ->from('reviews')
            ->where('revieweeID', (int)$user_id)
            ->where('visibilityStatus', 'visible')
            ->get()->row_array();
    }

    public function get_user_reviews_with_context($user_id, $limit = 200)
    {
        return $this->db->select("
                r.*,
                reviewer.userName as reviewerName,
                COALESCE(e.equipName, wf.personName) as itemName
            ", false)
            ->from('reviews r')
            ->join('users reviewer', 'reviewer.userID = r.reviewerID', 'left')
            ->join('orders o', 'o.orderID = r.orderID', 'left')
            ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
            ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
            ->where('r.revieweeID', (int)$user_id)
            ->where('r.visibilityStatus', 'visible')
            ->order_by('r.createdAt', 'DESC')
            ->limit((int)$limit)
            ->get()
            ->result();
    }
}
