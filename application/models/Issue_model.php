<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Issue_model
 *
 * Handles rental issue reporting and dispute management.
 */
class Issue_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Create a new rental issue
     *
     * @param array $data Issue data
     * @return int|false issueID on success, false on failure
     */
    public function createIssue($data)
    {
        $insert = [
            'equipmentPaymentID' => isset($data['equipmentPaymentID']) ? $data['equipmentPaymentID'] : null,
            'workforcePaymentID' => isset($data['workforcePaymentID']) ? $data['workforcePaymentID'] : null,
            'orderID'            => $data['orderID'],
            'issueType'          => $data['issueType'],
            'issueTitle'         => $data['issueTitle'],
            'issueDescription'   => $data['issueDescription'],
            'reportedBy'         => $data['reportedBy'],
            'reporterType'       => $data['reporterType'],
            'issueStatus'        => 'reported',
            'createdAt'          => date('Y-m-d H:i:s'),
            'updatedAt'          => date('Y-m-d H:i:s'),
        ];

        if (isset($data['attachmentUrls'])) {
            $insert['attachmentUrls'] = is_array($data['attachmentUrls'])
                ? json_encode($data['attachmentUrls'])
                : $data['attachmentUrls'];
        }

        $this->db->insert('rental_issues', $insert);
        $id = $this->db->insert_id();

        if ($id) {
            log_message('info', "Issue created: ID {$id} for order {$data['orderID']} by user {$data['reportedBy']}");
            return $id;
        }

        log_message('error', 'Issue_model::createIssue - Insert failed');
        return false;
    }

    /**
     * Get a single issue with reporter and resolver info
     *
     * @param int $issue_id
     * @return object|null
     */
    public function getIssueById($issue_id)
    {
        $has_chat_links = $this->db->table_exists('order_chat_links');

        $query = $this->db->select('
            ri.*,
            u.userName as reporterName,
            u.userEmail as reporterEmail,
            a.userName as assignedAdminName,
            r.userName as resolvedByName,
            COALESCE(e.equipName, wf.personName) as itemName,
            COALESCE(ep.rentalStartDate, wp.rentalStartDate) as rentalStartDate,
            COALESCE(ep.rentalEndDate, wp.rentalEndDate) as rentalEndDate,
            COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount,
            cd.companyName as sellerCompanyName,
            oc.chatID
        ', false)
        ->from('rental_issues ri')
        ->join('users u', 'u.userID = ri.reportedBy', 'left')
        ->join('users a', 'a.userID = ri.assignedToAdmin', 'left')
        ->join('users r', 'r.userID = ri.resolvedBy', 'left')
        ->join('equipment_payments ep', 'ri.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'ri.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('companydetail cd', 'COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) = cd.companyID', 'left');

        if ($has_chat_links) {
            $query->join('order_chat_links ocl', 'ocl.orderID = ri.orderID', 'left')
                ->join('order_chats oc', 'oc.chatID = ocl.chatID', 'left');
        } else {
            $query->join('order_chats oc', 'oc.orderID = ri.orderID', 'left');
        }

        return $query->where('ri.issueID', $issue_id)
            ->get()
            ->row();
    }

    /**
     * Get all issues for a specific order
     *
     * @param int $order_id
     * @return array
     */
    public function getIssuesForOrder($order_id)
    {
        return $this->db->select('ri.*, u.userName as reporterName, u.userEmail as reporterEmail, r.userName as resolvedByName')
            ->from('rental_issues ri')
            ->join('users u', 'u.userID = ri.reportedBy', 'left')
            ->join('users r', 'r.userID = ri.resolvedBy', 'left')
            ->where('ri.orderID', $order_id)
            ->order_by('COALESCE(ri.reportedAt, ri.createdAt)', 'DESC', false)
            ->get()
            ->result();
    }

    /**
     * Get all issues for SuperAdmin management
     *
     * @param array $filters Optional: ['status' => ..., 'type' => ...]
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllIssues($filters = [], $limit = 20, $offset = 0)
    {
        $has_chat_links = $this->db->table_exists('order_chat_links');

        $this->db->select('
            ri.*,
            u.userName as reporterName,
            COALESCE(e.equipName, wf.personName) as itemName,
            cd.companyName,
            oc.chatID
        ', false)
        ->from('rental_issues ri')
        ->join('users u', 'u.userID = ri.reportedBy', 'left')
        ->join('equipment_payments ep', 'ri.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'ri.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('companydetail cd', 'COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) = cd.companyID', 'left');

        if ($has_chat_links) {
            $this->db->join('order_chat_links ocl', 'ocl.orderID = ri.orderID', 'left')
                ->join('order_chats oc', 'oc.chatID = ocl.chatID', 'left');
        } else {
            $this->db->join('order_chats oc', 'oc.orderID = ri.orderID', 'left');
        }

        if (!empty($filters['status'])) {
            $this->db->where('ri.issueStatus', $filters['status']);
        }
        if (!empty($filters['type'])) {
            $this->db->where('ri.issueType', $filters['type']);
        }

        return $this->db->order_by('ri.reportedAt', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count all issues (for pagination)
     *
     * @param array $filters
     * @return int
     */
    public function countAllIssues($filters = [])
    {
        $this->db->from('rental_issues');
        if (!empty($filters['status'])) {
            $this->db->where('issueStatus', $filters['status']);
        }
        if (!empty($filters['type'])) {
            $this->db->where('issueType', $filters['type']);
        }
        return $this->db->count_all_results();
    }

    /**
     * Assign issue to a SuperAdmin
     *
     * @param int $issue_id
     * @param int $admin_id
     * @return bool
     */
    public function assignToAdmin($issue_id, $admin_id)
    {
        return $this->db->update('rental_issues', [
            'assignedToAdmin' => $admin_id,
            'issueStatus'     => 'under_review',
            'updatedAt'       => date('Y-m-d H:i:s'),
        ], ['issueID' => $issue_id]);
    }

    /**
     * Update issue status
     *
     * @param int $issue_id
     * @param string $status
     * @return bool
     */
    public function updateIssueStatus($issue_id, $status)
    {
        return $this->db->update('rental_issues', [
            'issueStatus' => $status,
            'updatedAt'   => date('Y-m-d H:i:s'),
        ], ['issueID' => $issue_id]);
    }

    /**
     * Resolve an issue (SuperAdmin action)
     *
     * @param int $issue_id
     * @param array $resolution_data
     * @return bool
     */
    public function resolveIssue($issue_id, $resolution_data)
    {
        $update = [
            'issueStatus'       => 'resolved',
            'resolutionNotes'   => isset($resolution_data['notes']) ? $resolution_data['notes'] : null,
            'resolutionOutcome' => isset($resolution_data['outcome']) ? $resolution_data['outcome'] : 'no_action',
            'resolvedBy'        => $resolution_data['resolved_by'],
            'resolvedAt'        => date('Y-m-d H:i:s'),
            'updatedAt'         => date('Y-m-d H:i:s'),
        ];

        if (isset($resolution_data['refund_amount'])) {
            $update['refundAmount'] = $resolution_data['refund_amount'];
        }
        if (isset($resolution_data['compensation_amount'])) {
            $update['compensationAmount'] = $resolution_data['compensation_amount'];
        }

        return $this->db->update('rental_issues', $update, ['issueID' => $issue_id]);
    }

    /**
     * Get issues filed by a specific user (renter view)
     *
     * @param int $user_id
     * @return array
     */
    public function getIssuesByUser($user_id)
    {
        return $this->db->select('ri.*, COALESCE(e.equipName, wf.personName) as itemName', false)
            ->from('rental_issues ri')
            ->join('equipment_payments ep', 'ri.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->join('workforce_payments wp', 'ri.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
            ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
            ->where('ri.reportedBy', $user_id)
            ->order_by('ri.reportedAt', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Get issues for a company (owner view)
     *
     * @param int $company_id
     * @return array
     */
    public function getIssuesByCompany($company_id)
    {
        return $this->db->select('ri.*, u.userName as reporterName, COALESCE(e.equipName, wf.personName) as itemName', false)
            ->from('rental_issues ri')
            ->join('users u', 'u.userID = ri.reportedBy', 'left')
            ->join('equipment_payments ep', 'ri.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->join('workforce_payments wp', 'ri.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
            ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
            ->group_start()
                ->where('ep.sellerCompanyID', $company_id)
                ->or_where('wp.sellerCompanyID', $company_id)
            ->group_end()
            ->order_by('ri.reportedAt', 'DESC')
            ->get()
            ->result();
    }
}
