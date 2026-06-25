<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reviews extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Review_model');
        $this->load->model('ReviewReport_model');
        $this->load->library('review_service');
        $this->load->helper('notification');
    }

    public function index()
    {
        $login = $this->session->userdata('loginData');
        if (!$login || empty($login['userID'])) redirect('login');
        $user_id = (int)$login['userID'];
        $filter = strtolower((string)$this->input->get('filter', true));
        if (!in_array($filter, ['pending', 'done'], true)) $filter = 'pending';

        $rows = $this->db->select("
            o.orderID, o.createdAt as orderCreatedAt,
            o.equipmentPaymentID, o.workforcePaymentID,
            ep.saleType, ep.orderStatus as epOrderStatus, ep.rentalRequestStatus as epRentalStatus, ep.hasActiveIssue as epIssue, ep.refundProcessedAt as epRefundedAt, ep.completedAt as epCompletedAt,
            wp.orderStatus as wpOrderStatus, wp.rentalRequestStatus as wpRentalStatus, wp.hasActiveIssue as wpIssue, wp.refundProcessedAt as wpRefundedAt,
            COALESCE(e.equipName, wf.personName) as itemName,
            u_buyer.userID as buyerID, u_buyer.userName as buyerName,
            u_seller.userID as sellerUserID, u_seller.userName as sellerName,
            u_worker.userID as workerUserID, u_worker.userName as workerName,
            r.reviewID, r.rating, r.reviewText, r.createdAt as reviewCreatedAt
        ", false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('users u_buyer', 'u_buyer.userID = COALESCE(ep.buyerUserID, wp.buyerUserID)', 'left')
        ->join('companydetail cd', 'cd.companyID = COALESCE(ep.sellerCompanyID, wp.sellerCompanyID)', 'left')
        ->join('users u_seller', 'u_seller.userID = cd.userID', 'left')
        ->join('usercompanyworkforcelink ucwl', 'ucwl.workforceID = wp.workforceID', 'left')
        ->join('users u_worker', 'u_worker.userID = ucwl.userID', 'left')
        ->join('reviews r', 'r.orderID = o.orderID AND r.reviewerID = ' . $user_id, 'left')
        ->group_start()
            ->where('u_buyer.userID', $user_id)
            ->or_where('u_seller.userID', $user_id)
            ->or_where('u_worker.userID', $user_id)
        ->group_end()
        ->order_by('o.createdAt', 'DESC')
        ->get()->result_array();

        $pending = [];
        $done = [];
        foreach ($rows as $row) {
            $ctx = $this->review_service->get_order_review_context((int)$row['orderID'], $user_id);
            $is_done = !empty($row['reviewID']);
            $type = !empty($row['workforcePaymentID']) ? 'workforce' : (strtolower((string)$row['saleType']) === 'purchase' ? 'purchase' : 'rental');
            $counterparty = '';
            if ($user_id === (int)$row['buyerID']) {
                $counterparty = $type === 'workforce' && !empty($row['workerName']) ? $row['workerName'] : $row['sellerName'];
            } else {
                $counterparty = $row['buyerName'];
            }
            $entry = [
                'orderID' => (int)$row['orderID'],
                'itemName' => $row['itemName'] ?: 'Item',
                'transactionType' => $type,
                'counterparty' => $counterparty ?: 'User',
                'reviewID' => $row['reviewID'] ? (int)$row['reviewID'] : null,
                'rating' => $row['rating'] ? (int)$row['rating'] : null,
                'reviewText' => $row['reviewText'] ?? '',
                'reviewCreatedAt' => $row['reviewCreatedAt'] ?? null,
                'eligibilityReason' => $ctx['allowed'] ? '' : ($ctx['reason'] ?? 'Not eligible'),
            ];
            if ($is_done) {
                $done[] = $entry;
            } elseif (!empty($ctx['allowed'])) {
                $pending[] = $entry;
            }
        }

        $data = [
            'active_page' => 'reviews',
            'filter' => $filter,
            'pending_reviews' => $pending,
            'done_reviews' => $done,
        ];
        $this->load->view('reviews/user_reviews_dashboard', $data);
    }

    public function company_index()
    {
        $login = $this->session->userdata('loginData');
        if (!$login || empty($login['userID'])) redirect('login');

        $user_id = (int)$login['userID'];
        $user_type = (int)($login['userType'] ?? 0);
        if (!in_array($user_type, [2, 3], true)) {
            show_error('Forbidden', 403);
        }

        $filter = strtolower((string)$this->input->get('filter', true));
        if (!in_array($filter, ['pending', 'done'], true)) {
            $filter = 'pending';
        }

        $company = $this->db->select('companyID')
            ->from('companydetail')
            ->where('userID', $user_id)
            ->get()
            ->row();
        if (!$company || empty($company->companyID)) {
            show_error('Company not found', 404);
        }
        $company_id = (int)$company->companyID;

        $rows = $this->db->select("
            o.orderID, o.createdAt as orderCreatedAt,
            o.equipmentPaymentID, o.workforcePaymentID,
            ep.saleType, ep.orderStatus as epOrderStatus, ep.rentalRequestStatus as epRentalStatus, ep.hasActiveIssue as epIssue, ep.refundProcessedAt as epRefundedAt, ep.completedAt as epCompletedAt,
            wp.orderStatus as wpOrderStatus, wp.rentalRequestStatus as wpRentalStatus, wp.hasActiveIssue as wpIssue, wp.refundProcessedAt as wpRefundedAt,
            COALESCE(e.equipName, wf.personName) as itemName,
            u_buyer.userID as buyerID, u_buyer.userName as buyerName, u_buyer.userEmail as buyerEmail,
            u_seller.userID as sellerUserID, u_seller.userName as sellerName,
            r.reviewID, r.rating, r.reviewText, r.createdAt as reviewCreatedAt
        ", false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('users u_buyer', 'u_buyer.userID = COALESCE(ep.buyerUserID, wp.buyerUserID)', 'left')
        ->join('companydetail cd', 'cd.companyID = COALESCE(ep.sellerCompanyID, wp.sellerCompanyID)', 'left')
        ->join('users u_seller', 'u_seller.userID = cd.userID', 'left')
        ->join('reviews r', 'r.orderID = o.orderID AND r.reviewerID = ' . $user_id, 'left')
        ->group_start()
            ->where('ep.sellerCompanyID', $company_id)
            ->or_where('wp.sellerCompanyID', $company_id)
        ->group_end()
        ->order_by('o.createdAt', 'DESC')
        ->get()->result_array();

        $pending = [];
        $done = [];
        foreach ($rows as $row) {
            $ctx = $this->review_service->get_order_review_context((int)$row['orderID'], $user_id);
            $is_done = !empty($row['reviewID']);
            $type = !empty($row['workforcePaymentID']) ? 'workforce' : (strtolower((string)$row['saleType']) === 'purchase' ? 'purchase' : 'rental');
            $entry = [
                'orderID' => (int)$row['orderID'],
                'itemName' => $row['itemName'] ?: 'Item',
                'transactionType' => $type,
                'customerName' => $row['buyerName'] ?: 'Customer',
                'customerEmail' => $row['buyerEmail'] ?: '',
                'reviewID' => $row['reviewID'] ? (int)$row['reviewID'] : null,
                'rating' => $row['rating'] ? (int)$row['rating'] : null,
                'reviewText' => $row['reviewText'] ?? '',
                'reviewCreatedAt' => $row['reviewCreatedAt'] ?? null,
                'eligibilityReason' => $ctx['allowed'] ? '' : ($ctx['reason'] ?? 'Not eligible'),
            ];
            if ($is_done) {
                $done[] = $entry;
            } elseif (!empty($ctx['allowed'])) {
                $pending[] = $entry;
            }
        }

        $data = [
            'active_page' => 'company_reviews',
            'filter' => $filter,
            'pending_reviews' => $pending,
            'done_reviews' => $done,
        ];
        $this->load->view('company/company_reviews_dashboard', $data);
    }

    public function submit()
    {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') show_error('Invalid method', 405);
        $login = $this->session->userdata('loginData');
        if (!$login || empty($login['userID'])) redirect('login');
        $user_id = (int)$login['userID'];
        $order_id = (int)$this->input->post('order_id', true);
        $rating = (int)$this->input->post('rating', true);
        $text = trim((string)$this->input->post('review_text', true));
        $tags = $this->input->post('tags');
        $normalized_tags = [];
        foreach ((array)$tags as $tag) {
            $tag = trim((string)$tag);
            if ($tag !== '') {
                $normalized_tags[] = $tag;
            }
        }
        $category_ratings = $this->input->post('category_ratings');

        if ($rating < 1 || $rating > 5 || strlen($text) > 500) {
            $this->session->set_flashdata('error', 'Rating must be 1-5 and review text must be 500 chars or less.');
            redirect($_SERVER['HTTP_REFERER'] ?? 'orders');
            return;
        }

        $ctx = $this->review_service->get_order_review_context($order_id, $user_id);
        if (empty($ctx['allowed'])) {
            $this->session->set_flashdata('error', $ctx['reason']);
            redirect($_SERVER['HTTP_REFERER'] ?? 'orders');
            return;
        }

        if ($this->Review_model->get_by_order_and_reviewer($order_id, $user_id)) {
            $this->session->set_flashdata('error', 'You already submitted a review for this transaction.');
            redirect($_SERVER['HTTP_REFERER'] ?? 'orders');
            return;
        }

        $data = [
            'orderID' => $order_id,
            'equipmentPaymentID' => !empty($ctx['order']['equipmentPaymentID']) ? (int)$ctx['order']['equipmentPaymentID'] : null,
            'workforcePaymentID' => !empty($ctx['order']['workforcePaymentID']) ? (int)$ctx['order']['workforcePaymentID'] : null,
            'reviewerID' => $user_id,
            'revieweeID' => (int)$ctx['reviewee_id'],
            'transactionType' => $ctx['transaction_type'],
            'roleType' => $ctx['role_type'],
            'rating' => $rating,
            'reviewText' => ($text !== '' ? $text : null),
            'categoryRatings' => !empty($category_ratings) ? json_encode($category_ratings) : null,
            'tagsJson' => !empty($normalized_tags) ? json_encode(array_values($normalized_tags)) : null,
            'visibilityStatus' => 'visible',
            'editWindowExpiry' => $ctx['edit_window_expiry'],
        ];

        $review_id = $this->Review_model->create($data);
        if ($review_id > 0 && !empty($ctx['reviewee_id'])) {
            $notify_user_ids = [(int)$ctx['reviewee_id']];
            if (($ctx['transaction_type'] ?? '') === 'workforce') {
                $seller_user_id = (int)($ctx['order']['sellerUserID'] ?? 0);
                if ($seller_user_id > 0) {
                    $notify_user_ids[] = $seller_user_id;
                }
            }
            $notify_user_ids = array_values(array_unique(array_filter($notify_user_ids)));
            foreach ($notify_user_ids as $notify_user_id) {
                send_notification((int)$notify_user_id, 'review_received', $order_id);
            }
        }

        $this->handle_media_uploads($review_id);
        $this->session->set_flashdata('success', 'Review submitted successfully.');
        redirect($_SERVER['HTTP_REFERER'] ?? 'orders');
    }

    public function update($review_id)
    {
        $login = $this->session->userdata('loginData');
        if (!$login || empty($login['userID'])) redirect('login');
        $review = $this->db->where('reviewID', (int)$review_id)->get('reviews')->row();
        if (!$review || (int)$review->reviewerID !== (int)$login['userID']) show_error('Forbidden', 403);
        if (strtotime($review->editWindowExpiry) < time()) show_error('Edit window expired', 403);
        $rating = (int)$this->input->post('rating', true);
        $text = trim((string)$this->input->post('review_text', true));
        $tags = $this->input->post('tags');
        $category_ratings = $this->input->post('category_ratings');
        $normalized_tags = [];
        foreach ((array)$tags as $tag) {
            $tag = trim((string)$tag);
            if ($tag !== '') {
                $normalized_tags[] = $tag;
            }
        }
        if ($rating < 1 || $rating > 5 || strlen($text) > 500) {
            $this->session->set_flashdata('error', 'Rating must be 1-5 and review text must be 500 chars or less.');
            redirect($_SERVER['HTTP_REFERER'] ?? 'orders');
            return;
        }
        $this->Review_model->update((int)$review_id, [
            'rating' => $rating,
            'reviewText' => ($text !== '' ? $text : null),
            'categoryRatings' => !empty($category_ratings) ? json_encode($category_ratings) : null,
            'tagsJson' => !empty($normalized_tags) ? json_encode(array_values($normalized_tags)) : null,
            'isEdited' => 1
        ]);
        $this->handle_media_uploads((int)$review_id);
        $this->session->set_flashdata('success', 'Review updated successfully.');
        redirect($_SERVER['HTTP_REFERER'] ?? 'orders');
    }

    public function delete($review_id)
    {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') show_error('Invalid method', 405);
        $login = $this->session->userdata('loginData');
        if (!$login || empty($login['userID'])) redirect('login');

        $review = $this->db->where('reviewID', (int)$review_id)->get('reviews')->row();
        if (!$review || (int)$review->reviewerID !== (int)$login['userID']) {
            show_error('Forbidden', 403);
            return;
        }

        $this->db->where('reviewID', (int)$review_id)->delete('review_media');
        $this->db->where('reviewID', (int)$review_id)->delete('reviews');
        $this->session->set_flashdata('success', 'Review deleted successfully.');
        redirect($_SERVER['HTTP_REFERER'] ?? 'orders');
    }

    public function report($review_id)
    {
        $login = $this->session->userdata('loginData');
        if (!$login || empty($login['userID'])) redirect('login');
        $this->ReviewReport_model->create([
            'reviewID' => (int)$review_id,
            'reportedBy' => (int)$login['userID'],
            'reason' => substr(trim((string)$this->input->post('reason', true)), 0, 255),
            'details' => trim((string)$this->input->post('details', true)),
            'status' => 'open'
        ]);
        $this->session->set_flashdata('success', 'Review report submitted.');
        redirect($_SERVER['HTTP_REFERER'] ?? 'orders');
    }

    private function handle_media_uploads($review_id)
    {
        if (empty($_FILES['review_media']['name'][0])) return;
        $dir = FCPATH . 'assets/uploads/reviews/';
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        $count = count($_FILES['review_media']['name']);
        for ($i = 0; $i < min($count, 4); $i++) {
            if (empty($_FILES['review_media']['name'][$i])) continue;
            $_FILES['single_media'] = [
                'name' => $_FILES['review_media']['name'][$i],
                'type' => $_FILES['review_media']['type'][$i],
                'tmp_name' => $_FILES['review_media']['tmp_name'][$i],
                'error' => $_FILES['review_media']['error'][$i],
                'size' => $_FILES['review_media']['size'][$i],
            ];
            $config = ['upload_path' => $dir, 'allowed_types' => 'jpg|jpeg|png|webp', 'max_size' => 4096, 'encrypt_name' => true];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('single_media')) {
                $u = $this->upload->data();
                $this->db->insert('review_media', [
                    'reviewID' => (int)$review_id,
                    'filePath' => 'assets/uploads/reviews/' . $u['file_name'],
                    'mimeType' => $u['file_type'],
                    'fileSize' => (int)$u['file_size']
                ]);
            }
        }
    }
}
