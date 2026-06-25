<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Employee_model', 'employee_model');
    }

    private function require_employee()
    {
        $login_data = $this->session->userdata('loginData');
        if (!$login_data || empty($login_data['userID'])) {
            redirect(base_url('login'));
            return null;
        }

        $employee = $this->employee_model->resolve_employee($login_data['userID']);
        if (!$employee) {
            show_error('You do not have access to the employee dashboard.', 403);
            return null;
        }

        return $employee;
    }

    private function render($view, $data = [])
    {
        $employee = $this->require_employee();
        if (!$employee) {
            return;
        }

        $data['employee'] = $employee;
        $data['employee_view'] = $view;
        $data['employee_nav'] = true;
        $this->load->view('employee/layout', $data);
    }

    public function dashboard()
    {
        $employee = $this->require_employee();
        if (!$employee) {
            return;
        }

        $data = [
            'employee' => $employee,
            'counts' => $this->employee_model->get_dashboard_counts($employee['workforceID'], $employee['userID']),
            'recent_projects' => array_slice($this->employee_model->get_projects($employee['workforceID']), 0, 4),
            'recent_equipment' => array_slice($this->employee_model->get_equipment($employee['workforceID']), 0, 4),
            'active_page' => 'employee_dashboard',
            'employee_view' => 'employee/dashboard',
            'employee_nav' => true
        ];

        $this->load->view('employee/layout', $data);
    }

    public function projects()
    {
        $employee = $this->require_employee();
        if (!$employee) {
            return;
        }

        $this->load->view('employee/layout', [
            'employee' => $employee,
            'projects' => $this->employee_model->get_projects($employee['workforceID']),
            'active_page' => 'employee_projects',
            'employee_view' => 'employee/projects',
            'employee_nav' => true
        ]);
    }

    public function equipment()
    {
        $employee = $this->require_employee();
        if (!$employee) {
            return;
        }

        $this->load->view('employee/layout', [
            'employee' => $employee,
            'equipment' => $this->employee_model->get_equipment($employee['workforceID']),
            'active_page' => 'employee_equipment',
            'employee_view' => 'employee/equipment',
            'employee_nav' => true
        ]);
    }

    public function rentals()
    {
        $employee = $this->require_employee();
        if (!$employee) {
            return;
        }

        $this->load->view('employee/layout', [
            'employee' => $employee,
            'rentals' => $this->employee_model->get_rentals($employee['workforceID']),
            'active_page' => 'employee_rentals',
            'employee_view' => 'employee/rentals',
            'employee_nav' => true
        ]);
    }

    public function profile()
    {
        $employee = $this->require_employee();
        if (!$employee) {
            return;
        }

        $this->load->view('employee/layout', [
            'employee' => $employee,
            'active_page' => 'employee_profile',
            'employee_view' => 'employee/profile',
            'employee_nav' => true
        ]);
    }

    public function messages()
    {
        $employee = $this->require_employee();
        if (!$employee) {
            return;
        }

        $company_id = (int)($employee['companyID'] ?? 0);
        $user_id = (int)($employee['userID'] ?? 0);

        if ($company_id <= 0 || $user_id <= 0) {
            show_error('Unable to open employee messaging right now.', 500);
            return;
        }

        $this->load->model('Chat_model');
        $chat_id = $this->Chat_model->get_or_create_direct_chat($user_id, $company_id);
        if (!$chat_id) {
            show_error('Unable to start chat right now. Please try again.', 500);
            return;
        }

        redirect(base_url('chat/thread/' . (int)$chat_id));
    }
}
