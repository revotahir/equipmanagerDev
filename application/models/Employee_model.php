<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee_model extends CI_Model
{
    public function resolve_employee($user_id)
    {
        $this->db->select('ucwl.userCompanyWorkforceLinkID, ucwl.companyID, ucwl.workforceID, ucwl.userID, w.personName, w.personEmail, w.personPhone, w.personImg, w.personAddInfo, w.personStatus, cd.companyName, u.userName, u.userEmail, u.userPhone, u.userStatus');
        $this->db->from('usercompanyworkforcelink ucwl');
        $this->db->join('workforce w', 'w.workforceID = ucwl.workforceID', 'inner');
        $this->db->join('companydetail cd', 'cd.companyID = ucwl.companyID', 'left');
        $this->db->join('users u', 'u.userID = ucwl.userID', 'inner');
        $this->db->where('ucwl.userID', (int)$user_id);
        $this->db->where('u.userStatus', 1);

        if ($this->db->field_exists('employeeStatus', 'usercompanyworkforcelink')) {
            $this->db->where('ucwl.employeeStatus', 'active');
        }

        $query = $this->db->get();
        return $query->num_rows() ? $query->row_array() : null;
    }

    public function is_employee_user($user_id)
    {
        return $this->resolve_employee($user_id) !== null;
    }

    public function get_dashboard_counts($workforce_id, $user_id)
    {
        $workforce_id = (int)$workforce_id;
        $user_id = (int)$user_id;

        $this->db->from('projectworkforcelink pwl');
        $this->db->join('projects p', 'p.ProjectID = pwl.ProjectID', 'inner');
        $this->db->where('pwl.workforceID', $workforce_id);
        $this->db->where('p.ProjectID >', 0);
        $projects = (int)$this->db->count_all_results();

        $this->db->from('projectequipmentassign');
        $this->db->where('workforceID', $workforce_id);
        $equipment = (int)$this->db->count_all_results();

        $rentals = 0;
        if ($this->db->table_exists('workforce_payments')) {
            $this->db->from('workforce_payments');
            $this->db->where('workforceID', $workforce_id);
            $this->db->where_in('rentalRequestStatus', [
                'request_approved',
                'awaiting_handover',
                'rental_active',
                'rental_overdue',
                'return_requested',
                'returned_by_renter',
                'received_by_owner',
                'under_review'
            ]);
            $this->db->where_not_in('orderStatus', ['cancelled', 'rejected', 'refunded']);
            $rentals = (int)$this->db->count_all_results();
        }

        $unread_notifications = 0;
        if ($this->db->table_exists('notifications')) {
            $this->db->from('notifications');
            $this->db->where('userID', $user_id);
            $this->db->where('isRead', 0);
            $unread_notifications = (int)$this->db->count_all_results();
        }

        return [
            'projects' => $projects,
            'equipment' => $equipment,
            'rentals' => $rentals,
            'notifications' => $unread_notifications
        ];
    }

    public function get_projects($workforce_id)
    {
        $this->db->select('p.*, pc.pCatName, cd.companyName');
        $this->db->from('projectworkforcelink pwl');
        $this->db->join('projects p', 'p.ProjectID = pwl.ProjectID', 'inner');
        $this->db->join('projectcategory pc', 'pc.pCatID = p.pCatID', 'left');
        $this->db->join('companydetail cd', 'cd.companyID = p.companyID', 'left');
        $this->db->where('pwl.workforceID', (int)$workforce_id);
        $this->db->where('p.ProjectID >', 0);
        $this->db->order_by('p.ProjectID', 'DESC');

        return $this->db->get()->result_array();
    }

    public function get_equipment($workforce_id)
    {
        $this->db->select('pea.assignID, pea.assignedQty, pea.ProjectID, e.*, ec.catName, p.pName, p.pLocation, p.pStatus, p.pStartDate, p.pEndDate');
        $this->db->from('projectequipmentassign pea');
        $this->db->join('equipment e', 'e.equipmentID = pea.equipmentID', 'inner');
        $this->db->join('equipcat ec', 'ec.equipCatID = e.equipCatID', 'left');
        $this->db->join('projects p', 'p.ProjectID = pea.ProjectID', 'left');
        $this->db->where('pea.workforceID', (int)$workforce_id);
        $this->db->order_by('pea.assignID', 'DESC');

        return $this->db->get()->result_array();
    }

    public function get_rentals($workforce_id)
    {
        if (!$this->db->table_exists('workforce_payments')) {
            return [];
        }

        $this->db->select('wp.*, u.userName AS buyerName, u.userEmail AS buyerEmail, cd.companyName');
        $this->db->from('workforce_payments wp');
        $this->db->join('users u', 'u.userID = wp.buyerUserID', 'left');
        $this->db->join('companydetail cd', 'cd.companyID = wp.sellerCompanyID', 'left');
        $this->db->where('wp.workforceID', (int)$workforce_id);
        $this->db->order_by('wp.workforcePaymentID', 'DESC');

        return $this->db->get()->result_array();
    }
}
