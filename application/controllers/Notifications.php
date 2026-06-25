<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Notifications Controller
 *
 * Handles in-platform notification list, unread count,
 * mark-read and mark-all-read API endpoints.
 */
class Notifications extends MY_Controller
{
    private function employeeAccount($user_id)
    {
        $this->load->model('Employee_model', 'employee_model');
        return $this->employee_model->resolve_employee((int)$user_id);
    }
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notification_model');
    }

    /**
     * Full notification list page
     * GET /notifications
     */
    public function index()
    {
        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            redirect('login');
        }

        $user_id = $login_data['userID'];
        $employee = ((int)($login_data['userType'] ?? 0) === 4) ? $this->employeeAccount($user_id) : null;
        $page    = max(1, intval($this->input->get('page')));
        $limit   = 20;
        $offset  = ($page - 1) * $limit;

        $data = [
            'notifications' => $this->Notification_model->getUserNotifications($user_id, $limit, $offset),
            'total'         => $this->Notification_model->getTotalCount($user_id),
            'current_page'  => $page,
            'per_page'      => $limit,
            'csrf_name'     => $this->security->get_csrf_token_name(),
            'csrf_hash'     => $this->security->get_csrf_hash(),
            'employee_nav'  => !empty($employee),
            'employee'      => $employee,
            'active_page'   => 'notifications',
        ];

        if (!empty($employee)) {
            $data['employee_view'] = 'employee/notifications';
            $data['active_page'] = 'employee_notifications';
            $this->load->view('employee/layout', $data);
            return;
        }

        $this->load->view('notifications/list', $data);
    }

    /**
     * API: Get unread notification count (polling endpoint)
     * GET /notifications/api_get_unread_count
     * Used by frontend notification bell every 30 seconds
     */
    public function api_get_unread_count()
    {
        header('Content-Type: application/json');

        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            echo json_encode(['count' => 0]);
            return;
        }

        $count = $this->Notification_model->getUnreadCount($login_data['userID']);
        echo json_encode(['count' => $count, 'success' => true]);
    }

    /**
     * API: Get recent notifications (for dropdown bell)
     * GET /notifications/api_get_recent
     */
    public function api_get_recent()
    {
        header('Content-Type: application/json');

        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'notifications' => []]);
            return;
        }

        $notifications = $this->Notification_model->getUserNotifications($login_data['userID'], 10);
        echo json_encode(['success' => true, 'notifications' => $notifications]);
    }

    /**
     * API: Mark a single notification as read
     * POST /notifications/api_mark_read
     */
    public function api_mark_read()
    {
        header('Content-Type: application/json');

        $login_data = $this->session->userdata('loginData');
        if (!$login_data) {
            http_response_code(401);
            echo json_encode(['success' => false]);
            return;
        }

        $notification_id = intval($this->input->post('notification_id', TRUE));
        if (!$notification_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'notification_id required']);
            return;
        }

        $result = $this->Notification_model->markAsRead($notification_id, $login_data['userID']);
        echo json_encode(['success' => (bool)$result]);
    }

    /**
     * API: Mark all notifications as read
     * POST /notifications/api_mark_all_read
     */
    public function api_mark_all_read()
    {
        header('Content-Type: application/json');

        $login_data = $this->session->userdata('loginData');
        if (!$login_data) {
            http_response_code(401);
            echo json_encode(['success' => false]);
            return;
        }

        $this->Notification_model->markAllAsRead($login_data['userID']);
        echo json_encode(['success' => true]);
    }

    /**
     * API: Delete a single notification
     * POST /notifications/api_delete
     */
    public function api_delete()
    {
        header('Content-Type: application/json');

        $login_data = $this->session->userdata('loginData');
        if (!$login_data) {
            http_response_code(401);
            echo json_encode(['success' => false]);
            return;
        }

        $notification_id = intval($this->input->post('notification_id', TRUE));
        if (!$notification_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'notification_id required']);
            return;
        }

        $result = $this->Notification_model->deleteNotification($notification_id, $login_data['userID']);
        echo json_encode(['success' => (bool)$result]);
    }
}
