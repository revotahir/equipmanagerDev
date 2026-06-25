<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Load database and model
        $this->load->database();
        $this->load->model('Order_model');
        $this->load->helper('invoice');
    }

    /**
     * Display all orders for the logged-in user with optional status filtering
     * Uses the new unified orders table
     */
    public function index()
    {
        // DEBUG: Log page load session
        $session_id = session_id();
        error_log("[ORDERS INDEX DEBUG] SessionID: $session_id");
        
        // MY_Controller ensures user is authenticated before this runs
        // Safely get userID from loginData
        $login_data = $this->session->userdata('loginData');
        
        error_log("[ORDERS INDEX DEBUG] LoginData exists: " . (isset($login_data) ? 'YES' : 'NO'));
        
        if (!$login_data || !isset($login_data['userID'])) {
            redirect('login');
        }
        
        $user_id = $login_data['userID'];
        $has_chat_links = $this->db->table_exists('order_chat_links');
        error_log("[ORDERS INDEX DEBUG] User ID: $user_id");
        
        // Get filter parameter from URL
        $filter = $this->input->get('status');
        $type_filter = strtolower(trim((string)$this->input->get('type', TRUE)));
        if (!in_array($type_filter, ['rental', 'purchase'], true)) {
            $type_filter = '';
        }
        
        // Query unified orders table with both equipment and workforce details
        $query = $this->db->select("
            o.orderID,
            CASE 
                WHEN o.equipmentPaymentID IS NOT NULL THEN 'equipment'
                WHEN o.workforcePaymentID IS NOT NULL THEN 'workforce'
            END as orderType,
            COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount,
            COALESCE(ep.paymentStatus, wp.paymentStatus) as paymentStatus,
            COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus) as orderStatus,
            COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus, ep.orderStatus, wp.orderStatus) as rentalLifecycleStatus,
            COALESCE(ep.checkoutToken, '') as checkoutToken,
            ep.checkoutTokenExpiry,
            COALESCE(ep.paymentMetadata, wp.paymentMetadata) as paymentMetadata,
            COALESCE(ep.rentalStartDate, wp.rentalStartDate) as rentalStartDate,
            COALESCE(ep.rentalEndDate, wp.rentalEndDate) as rentalEndDate,
            o.createdAt,
            COALESCE(ep.quantity, DATEDIFF(wp.rentalEndDate, wp.rentalStartDate) + 1) as quantity,
            COALESCE(ep.saleType, 'rental') as saleType,
            COALESCE(e.equipName, wf.personName) as itemName,
            COALESCE(ec.catName, 'Workforce') as itemCategory,
            oc.chatID,
            COALESCE(ep.itemID, wp.itemID) as itemID
        ", false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('equipcat ec', 'e.equipCatID = ec.equipCatID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left');

        if ($has_chat_links) {
            $query->join('order_chat_links ocl', 'o.orderID = ocl.orderID', 'left')
                ->join('order_chats oc', 'ocl.chatID = oc.chatID', 'left');
        } else {
            $query->join('order_chats oc', 'o.orderID = oc.orderID', 'left');
        }

        $query
        ->where('COALESCE(ep.buyerUserID, wp.buyerUserID) =', $user_id);

        // Apply filter if provided
        if ($filter && !empty($filter)) {
                $valid_filters = ['requested', 'payment_pending', 'payment_secured', 'in_progress', 'shipped', 'pickup_ready', 'delivered', 'completed', 'rejected', 'cancelled',
                        'request_pending', 'request_approved', 'request_rejected', 'awaiting_handover', 'rental_active', 'return_requested', 'rental_overdue', 'returned_by_renter', 'received_by_owner', 'under_review', 'rental_completed', 'rental_cancelled'];
            if (in_array($filter, $valid_filters)) {
                if ($filter === 'under_review') {
                    $query->group_start()
                        ->where('ep.rentalRequestStatus', $filter)
                        ->or_where('wp.rentalRequestStatus', $filter)
                        ->or_where('COALESCE(ep.hasActiveIssue, wp.hasActiveIssue) = 1', null, false)
                        ->group_end();
                } else {
                    $query->group_start()
                        ->where('ep.orderStatus', $filter)
                        ->or_where('ep.rentalRequestStatus', $filter)
                        ->or_where('wp.orderStatus', $filter)
                        ->or_where('wp.rentalRequestStatus', $filter)
                        ->group_end();
                }
            }
        }

        // Apply rental/purchase filter if provided
        if ($type_filter === 'rental') {
            $query->group_start()
                ->where('o.workforcePaymentID IS NOT NULL', null, false)
                ->or_where("(o.equipmentPaymentID IS NOT NULL AND LOWER(CAST(ep.saleType AS CHAR)) IN ('rental','0','2'))", null, false)
                ->group_end();
        } elseif ($type_filter === 'purchase') {
            $query->where('o.equipmentPaymentID IS NOT NULL', null, false)
                ->where("LOWER(CAST(ep.saleType AS CHAR)) IN ('purchase','1')", null, false);
        }

        // Order by newest first
        $query->order_by('o.createdAt', 'DESC');
        $orders = $query->get()->result();

        // Self-heal legacy rows stuck at under_review after issue resolution.
        foreach ($orders as $order_row) {
            if (strtolower((string)($order_row->rentalLifecycleStatus ?? '')) !== 'under_review') {
                continue;
            }

            if (!empty($order_row->equipmentPaymentID)) {
                $restored = $this->normalize_payment_issue_status('equipment_payments', 'equipmentPaymentID', (int)$order_row->equipmentPaymentID);
            } elseif (!empty($order_row->workforcePaymentID)) {
                $restored = $this->normalize_payment_issue_status('workforce_payments', 'workforcePaymentID', (int)$order_row->workforcePaymentID);
            } else {
                $restored = null;
            }

            if (!empty($restored)) {
                $order_row->rentalLifecycleStatus = $restored;
            }
        }

        // Prepare data for view
        $data = [
            'orders' => $orders,
            'filter' => $filter,
            'filter_type' => $type_filter
        ];

        // Load layout with component
        $this->load->view('orders/user_orders_list', $data);
    }

    /**
     * Display a single order details page
     * Note: Authentication is handled by MY_Controller (checks loginData)
     */
    public function view($order_id)
    {
        // MY_Controller ensures user is authenticated before this runs
        // Safely get userID from loginData
        $login_data = $this->session->userdata('loginData');
        
        if (!$login_data || !isset($login_data['userID'])) {
            redirect('login');
        }
        
        $user_id = $login_data['userID'];
        $has_chat_links = $this->db->table_exists('order_chat_links');
        
        // Validate order ID is numeric
        if (!is_numeric($order_id)) {
            show_404();
            return;
        }
        
        // Get order details using unified orders table
        $this->db->select("
            o.orderID,
            o.equipmentPaymentID,
            o.workforcePaymentID,
            CASE WHEN o.equipmentPaymentID IS NOT NULL THEN 'equipment' ELSE 'workforce' END as orderType,
            COALESCE(ep.equipmentPaymentID, wp.workforcePaymentID) as paymentID,
            COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount,
            COALESCE(ep.commissionAmount, wp.commissionAmount) as commissionAmount,
            COALESCE(ep.commissionPercent, wp.commissionPercent) as commissionPercent,
            COALESCE(ep.netAmount, wp.netAmount) as netAmount,
            COALESCE(ep.paymentStatus, wp.paymentStatus) as paymentStatus,
            COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus) as orderStatus,
            COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) as rentalRequestStatus,
            COALESCE(ep.renterConfirmedReturn, wp.renterConfirmedReturn) as renterConfirmedReturn,
            COALESCE(ep.renterConfirmedAt, wp.renterConfirmedAt) as renterConfirmedAt,
            COALESCE(ep.renterReturnNotes, wp.renterReturnNotes) as renterReturnNotes,
            COALESCE(ep.hasActiveIssue, wp.hasActiveIssue) as hasActiveIssue,
            COALESCE(ep.currentIssueID, wp.currentIssueID) as currentIssueID,
            COALESCE(ep.createdAt, wp.createdAt) as createdAt,
            COALESCE(ep.updatedAt, wp.updatedAt) as updatedAt,
            COALESCE(ep.quantity, DATEDIFF(wp.rentalEndDate, wp.rentalStartDate)) as quantity,
            COALESCE(ep.saleType, 'rental') as saleType,
            COALESCE(ep.rentalStartDate, wp.rentalStartDate) as rentalStartDate,
            COALESCE(ep.rentalEndDate, wp.rentalEndDate) as rentalEndDate,
            COALESCE(ep.rentalType, wp.rentalType) as rentalType,
            COALESCE(ep.itemID, wp.itemID) as itemID,
            ep.trackingNumber,
            ep.shippedAt,
            COALESCE(ep.paymentMetadata, wp.paymentMetadata) as paymentMetadata,
            COALESCE(e.equipName, wf.personName) as itemName,
            e.equipDesc,
            e.equipImg,
            ec.equipCatID,
            ec.catName,
            cd.companyName,
            oc.chatID
        ", false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('equipcat ec', 'e.equipCatID = ec.equipCatID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('companydetail cd', 'COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) = cd.companyID', 'left')
        ->join($has_chat_links ? 'order_chat_links ocl' : 'order_chats oc', $has_chat_links ? 'o.orderID = ocl.orderID' : 'o.orderID = oc.orderID', 'left');

        if ($has_chat_links) {
            $this->db->join('order_chats oc', 'ocl.chatID = oc.chatID', 'left');
        }

        $this->db
        ->where('o.orderID', $order_id)
        ->where('COALESCE(ep.buyerUserID, wp.buyerUserID) =', $user_id);

        $query = $this->db->get();
        $order = $query->row();

        if (!$order) {
            show_404();
            return;
        }

        if (!empty($order->equipmentPaymentID)) {
            $restored = $this->normalize_payment_issue_status('equipment_payments', 'equipmentPaymentID', (int)$order->equipmentPaymentID);
        } elseif (!empty($order->workforcePaymentID)) {
            $restored = $this->normalize_payment_issue_status('workforce_payments', 'workforcePaymentID', (int)$order->workforcePaymentID);
        } else {
            $restored = null;
        }

        if (!empty($restored)) {
            $order->rentalRequestStatus = $restored;
            $order->hasActiveIssue = 0;
            $order->currentIssueID = null;
        }

        // Fetch shopequipments images for this item
        $images = array();
        
        // First, try to get images using itemID
        if (!empty($order->itemID)) {
            $this->db->select([
                'eqpimg1', 'eqpimg2', 'eqpimg3', 'eqpimg4', 'eqpimg5',
                'eqpimg6', 'eqpimg7', 'eqpimg8', 'eqpimg9', 'eqpimg10'
            ])
            ->from('shopequipments')
            ->where('itemID', $order->itemID)
            ->limit(1);
            
            $eq_query = $this->db->get();
            $shop_equipment = $eq_query->row();
            
            if ($shop_equipment) {
                // Collect all non-empty image paths
                for ($i = 1; $i <= 10; $i++) {
                    $img_field = 'eqpimg' . $i;
                    if (!empty($shop_equipment->$img_field)) {
                        $images[] = 'assets/website/images/' . $shop_equipment->$img_field;
                    }
                }
            }
        }
        
        // If still no images, use equipment's main image as fallback
        if (empty($images) && !empty($order->equipImg)) {
            $images[] = 'assets/website/images/' . $order->equipImg;
        }

        $data = [
            'order' => $order,
            'images' => $images,
            'can_download_invoice' => invoice_can_download($order)
        ];
        $this->load->library('review_service');
        $this->load->model('Review_model');
        $data['review_context'] = $this->review_service->get_order_review_context((int)$order_id, (int)$user_id);
        $data['order_reviews'] = $this->Review_model->get_order_reviews((int)$order_id);
        $data['my_review'] = $this->Review_model->get_by_order_and_reviewer((int)$order_id, (int)$user_id);

        $this->load->model('Issue_model');
        $data['order_issues'] = $this->Issue_model->getIssuesForOrder((int)$order_id);

        $this->load->view('orders/detail_layout', $data);
    }

    /**
     * Download invoice PDF for an order owned by the logged-in buyer.
     *
     * @param int $order_id
     * @return void
     */
    public function invoice($order_id)
    {
        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            redirect('login');
            return;
        }

        if (!is_numeric($order_id)) {
            show_404();
            return;
        }

        $buyer_user_id = (int)$login_data['userID'];
        $order = $this->get_invoice_order_for_buyer((int)$order_id, $buyer_user_id);
        if (!$order) {
            show_404();
            return;
        }

        if (!invoice_can_download($order)) {
            $this->session->set_flashdata('error', 'Invoice is available only after payment is completed.');
            redirect('orders/view/' . (int)$order_id);
            return;
        }

        $invoice_data = invoice_build_payload($order);
        $this->stream_invoice_pdf($invoice_data);
    }

    /**
     * Get orders via AJAX (for dynamic loading)
     */
    public function ajax_get_orders()
    {
        $login_data = $this->session->userdata('loginData');
        
        if (!$login_data || !isset($login_data['userID'])) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        $user_id = $login_data['userID'];
        
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $search = isset($_GET['search']) ? $this->db->escape_str($_GET['search']) : '';
        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        // Base query
        $this->db->select([
            'ep.equipmentPaymentID',
            'ep.grossAmount',
            'ep.paymentStatus',
            'ep.createdAt',
            'ep.quantity',
            'e.equipName',
            'ec.catName'
        ])
        ->from('equipment_payments ep')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('equipcat ec', 'e.equipCatID = ec.equipCatID', 'left')
        ->where('ep.buyerUserID', $user_id);

        // Search filter
        if (!empty($search)) {
            $this->db->group_start()
                     ->like('e.equipName', $search)
                     ->or_like('ec.catName', $search)
                     ->or_like('ep.equipmentPaymentID', $search)
                     ->group_end();
        }

        $this->db->order_by('ep.createdAt', 'DESC')
                 ->limit($per_page, $offset);

        $query = $this->db->get();
        $orders = $query->result();

        // Get total count
        $this->db->select('COUNT(*) as total')
                 ->from('equipment_payments')
                 ->where('buyerUserID', $user_id);
        
        if (!empty($search)) {
            $this->db->group_start()
                     ->like('equipmentName', $search)
                     ->group_end();
        }
        
        $count_result = $this->db->get();
        $total = $count_result->row()->total;

        $response = [
            'success' => true,
            'orders' => $orders,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => ceil($total / $per_page),
                'total' => $total,
                'per_page' => $per_page
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Get order status statistics
     */
    public function ajax_get_statistics()
    {
        $login_data = $this->session->userdata('loginData');
        
        if (!$login_data || !isset($login_data['userID'])) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $user_id = $login_data['userID'];

        $stats = $this->db->select('paymentStatus, COUNT(*) as count')
                          ->from('equipment_payments')
                          ->where('buyerUserID', $user_id)
                          ->group_by('paymentStatus')
                          ->get()
                          ->result();

        $response = [
            'success' => true,
            'statistics' => $stats
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * DEBUG: Test session data and routing
     * Access via /orders/test_session
     */
    public function test_session()
    {
        header('Content-Type: application/json');
        
        $login_data = $this->session->userdata('loginData');
        $session_id = session_id();
        $all_session_data = $this->session->userdata();
        
        $response = [
            'page' => 'orders/test_session',
            'route_successful' => true,
            'session_id' => $session_id,
            'loginData_exists' => isset($login_data),
            'loginData' => $login_data ?? null,
            'all_session_keys' => array_keys($all_session_data),
            'php_session_exists' => !empty($_SESSION),
            'timestamp' => date('Y-m-d H:i:s'),
            'message' => $login_data ? 'Session is ACTIVE' : 'Session DATA MISSING - This is the problem!'
        ];
        
        log_message('debug', 'DEBUG Session Test: ' . json_encode($response));
        echo json_encode($response);
    }

    /**
     * Confirm delivery of shipped order
     * POST only
     */
    public function confirm_delivery()
    {
        // Verify POST method
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error('Invalid request method', 405);
            return;
        }
        
        $login_data = $this->session->userdata('loginData');
        
        if (!$login_data || !isset($login_data['userID'])) {
            $this->session->set_flashdata('error', 'Please log in to confirm delivery');
            redirect('login');
            return;
        }
        
        $user_id = $login_data['userID'];
        $has_chat_links = $this->db->table_exists('order_chat_links');
        $order_id = intval($this->input->post('order_id', TRUE));
        
        if (!$order_id) {
            $this->session->set_flashdata('error', 'Invalid order ID');
            redirect('orders');
            return;
        }
        
        // Get order and verify it belongs to this buyer using unified orders table
        $order_query = $this->db->select("o.orderID, o.equipmentPaymentID, o.workforcePaymentID, 
                                      COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus) as orderStatus,
                                      COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) as rentalStatus,
                                      COALESCE(ep.saleType, 'rental') as saleType,
                                      COALESCE(ep.paymentMetadata, wp.paymentMetadata) as paymentMetadata,
                                      COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) as sellerCompanyID,
                                      COALESCE(ep.buyerUserID, wp.buyerUserID) as buyerUserID,
                                      oc.chatID")
                           ->from('orders o')
                           ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
                           ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left');
        if ($has_chat_links) {
            $order_query->join('order_chat_links ocl', 'o.orderID = ocl.orderID', 'left')
                ->join('order_chats oc', 'ocl.chatID = oc.chatID', 'left');
        } else {
            $order_query->join('order_chats oc', 'o.orderID = oc.orderID', 'left');
        }
        $order_data = $order_query->where('o.orderID', $order_id)
            ->where('COALESCE(ep.buyerUserID, wp.buyerUserID) =', $user_id)
            ->get()
            ->row();
        
        if (!$order_data) {
            $this->session->set_flashdata('error', 'Order not found or access denied');
            redirect('orders');
            return;
        }
        
        if ($order_data->orderStatus !== 'shipped') {
            $this->session->set_flashdata('error', 'Order cannot be confirmed - not yet shipped. Current status: ' . $order_data->orderStatus);
            redirect('orders');
            return;
        }
        
        $is_rental_order = ($order_data->saleType === 'rental') || !empty($order_data->rentalStatus);
        $now = date('Y-m-d H:i:s');
        
        $result = false;
        if ($order_data->equipmentPaymentID) {
            $update_data = [
                'orderStatus' => $is_rental_order ? 'delivered' : 'completed',
                'deliveredBy' => $user_id,
                'deliveredAt' => $now,
                'updatedAt' => $now
            ];
            if ($is_rental_order) {
                $update_data['rentalRequestStatus'] = 'rental_active';
            } else {
                $update_data['completedAt'] = $now;
            }
            $this->db->where('equipmentPaymentID', $order_data->equipmentPaymentID);
            $result = $this->db->update('equipment_payments', $update_data);
        } elseif ($order_data->workforcePaymentID) {
            $metadata = json_decode((string)($order_data->paymentMetadata ?? ''), true);
            if (!is_array($metadata)) {
                $metadata = [];
            }
            $metadata['delivery_confirmed_by'] = intval($user_id);
            $metadata['delivery_confirmed_at'] = $now;
            $metadata['delivery_confirmation_method'] = 'delivery';

            $update_data = [
                'orderStatus' => $is_rental_order ? 'delivered' : 'completed',
                'updatedAt' => $now,
                'paymentMetadata' => json_encode($metadata)
            ];
            if ($is_rental_order) {
                $update_data['rentalRequestStatus'] = 'rental_active';
            }
            $this->db->where('workforcePaymentID', $order_data->workforcePaymentID);
            $result = $this->db->update('workforce_payments', $update_data);
        }
        
        if ($result) {
            $this->load->helper('notification');

            // Send automated chat messages to both parties
            $this->load->model('Chat_model');
            
            if ($order_data->chatID) {
                // Message to seller
                $message = "Delivery Confirmed!\n\n"
                         . "Order #" . $order_id . "\n"
                         . "The buyer has confirmed receipt of the product.\n\n"
                         . "Funds are being released to your account now.\n\n"
                         . "Thank you for your business!";
                
                $this->Chat_model->send_automated_message(
                    $order_data->chatID,
                    $message,
                    $order_data->sellerCompanyID,
                    'system'
                );
                
                // Message to buyer
                $buyer_message = "Thank you for confirming delivery!\n\n"
                               . "Order #" . $order_id . "\n"
                               . "Payment has been released to the seller.\n\n"
                               . "We hope you enjoy your purchase!";
                
                $this->Chat_model->send_automated_message(
                    $order_data->chatID,
                    $buyer_message,
                    $order_data->sellerCompanyID,
                    'system'
                );

                // Lock the chat - order is complete, no further messages needed
                $this->Chat_model->lock_chat($order_data->chatID);
            }

            $company_admin = $this->db->select('userID')
                ->from('companydetail')
                ->where('companyID', $order_data->sellerCompanyID)
                ->get()
                ->row();
            if ($company_admin) {
                send_notification((int)$company_admin->userID, 'payment_released', $order_id);
            }
            send_notification((int)$order_data->buyerUserID, 'payment_released', $order_id);
            
            // Trigger automatic fund release (if needed in future)
            // For now, funds are released immediately when order is marked completed
            // $this->release_funds($order_id);
            
            $this->session->set_flashdata('success', 'Delivery confirmed! Order completed and payment released to seller.');
            log_message('info', "Buyer {$user_id} confirmed delivery for order {$order_id}");
        } else {
            $this->session->set_flashdata('error', 'Failed to confirm delivery');
        }
        
        // Check if this is an AJAX request
        if ($this->input->is_ajax_request()) {
            // Return JSON response for AJAX
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode([
                             'success' => $result,
                             'message' => $result ? 'Delivery confirmed successfully!' : 'Failed to confirm delivery',
                             'redirect' => base_url('orders')
                         ]));
        } else {
            // Regular form submission - redirect to orders page
            redirect('orders');
        }
    }

    /**
    * Confirm pickup of a pickup order (pickup_ready -> completed)
     * POST only
     */
    public function confirm_pickup()
    {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_error('Invalid request method', 405);
            return;
        }

        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            $this->session->set_flashdata('error', 'Please log in to confirm pickup');
            redirect('login');
            return;
        }

        $user_id  = $login_data['userID'];
        $has_chat_links = $this->db->table_exists('order_chat_links');
        $order_id = intval($this->input->post('order_id', TRUE));

        if (!$order_id) {
            $this->session->set_flashdata('error', 'Invalid order ID');
            redirect('orders');
            return;
        }

        // Get order and verify it belongs to this buyer using unified orders table
        $order_query = $this->db->select("o.orderID, o.equipmentPaymentID, o.workforcePaymentID,
                                      COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus) as orderStatus,
                                      COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) as rentalStatus,
                                      COALESCE(ep.saleType, 'rental') as saleType,
                                      COALESCE(ep.paymentMetadata, wp.paymentMetadata) as paymentMetadata,
                                      COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) as sellerCompanyID,
                                      COALESCE(ep.buyerUserID, wp.buyerUserID) as buyerUserID,
                                      oc.chatID")
                           ->from('orders o')
                           ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
                           ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left');
        if ($has_chat_links) {
            $order_query->join('order_chat_links ocl', 'o.orderID = ocl.orderID', 'left')
                ->join('order_chats oc', 'ocl.chatID = oc.chatID', 'left');
        } else {
            $order_query->join('order_chats oc', 'o.orderID = oc.orderID', 'left');
        }
        $order_data = $order_query->where('o.orderID', $order_id)
            ->where('COALESCE(ep.buyerUserID, wp.buyerUserID) =', $user_id)
            ->get()
            ->row();

        if (!$order_data) {
            $this->session->set_flashdata('error', 'Order not found or access denied');
            redirect('orders');
            return;
        }

        if ($order_data->orderStatus !== 'pickup_ready') {
            $this->session->set_flashdata('error', 'Order cannot be confirmed - not yet ready for pickup. Current status: ' . $order_data->orderStatus);
            redirect('orders');
            return;
        }

        $is_rental_order = ($order_data->saleType === 'rental') || !empty($order_data->rentalStatus);
        $now = date('Y-m-d H:i:s');

        $result = false;
        if ($order_data->equipmentPaymentID) {
            $update_data = [
                'orderStatus' => $is_rental_order ? 'delivered' : 'completed',
                'deliveredBy' => $user_id,
                'deliveredAt' => $now,
                'updatedAt'   => $now,
            ];
            if ($is_rental_order) {
                $update_data['rentalRequestStatus'] = 'rental_active';
            } else {
                $update_data['completedAt'] = $now;
            }
            $this->db->where('equipmentPaymentID', $order_data->equipmentPaymentID);
            $result = $this->db->update('equipment_payments', $update_data);
        } elseif ($order_data->workforcePaymentID) {
            $metadata = json_decode((string)($order_data->paymentMetadata ?? ''), true);
            if (!is_array($metadata)) {
                $metadata = [];
            }
            $metadata['pickup_confirmed_by'] = intval($user_id);
            $metadata['pickup_confirmed_at'] = $now;
            $metadata['delivery_confirmation_method'] = 'pickup';

            $update_data = [
                'orderStatus' => $is_rental_order ? 'delivered' : 'completed',
                'updatedAt'   => $now,
                'paymentMetadata' => json_encode($metadata)
            ];
            if ($is_rental_order) {
                $update_data['rentalRequestStatus'] = 'rental_active';
            }
            $this->db->where('workforcePaymentID', $order_data->workforcePaymentID);
            $result = $this->db->update('workforce_payments', $update_data);
        }

        if ($result) {
            $this->load->helper('notification');

            $this->load->model('Chat_model');

            if ($order_data->chatID) {
                // Notify seller
                $seller_msg = "Pickup Confirmed!\n\n"
                            . "Order #" . $order_id . "\n"
                            . "The buyer has collected the item.\n\n"
                            . "Funds are being released to your account now.\n\n"
                            . "Thank you for your business!";

                $this->Chat_model->send_automated_message(
                    $order_data->chatID,
                    $seller_msg,
                    $order_data->sellerCompanyID,
                    'system'
                );

                // Notify buyer
                $buyer_msg = "Thank you for confirming pickup!\n\n"
                           . "Order #" . $order_id . "\n"
                           . "Payment has been released to the seller.\n\n"
                           . "We hope you enjoy your purchase!";

                $this->Chat_model->send_automated_message(
                    $order_data->chatID,
                    $buyer_msg,
                    $order_data->sellerCompanyID,
                    'system'
                );

                // Lock the chat - order is complete
                $this->Chat_model->lock_chat($order_data->chatID);
            }

            $company_admin = $this->db->select('userID')
                ->from('companydetail')
                ->where('companyID', $order_data->sellerCompanyID)
                ->get()
                ->row();
            if ($company_admin) {
                send_notification((int)$company_admin->userID, 'payment_released', $order_id);
            }
            send_notification((int)$order_data->buyerUserID, 'payment_released', $order_id);

            $this->session->set_flashdata('success', 'Pickup confirmed! Order completed and payment released to seller.');
            log_message('info', "Buyer {$user_id} confirmed pickup for order {$order_id}");
        } else {
            $this->session->set_flashdata('error', 'Failed to confirm pickup');
        }

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode([
                             'success' => $result,
                             'message' => $result ? 'Pickup confirmed successfully!' : 'Failed to confirm pickup',
                             'redirect' => base_url('orders')
                         ]));
        } else {
            redirect('orders');
        }
    }

    /**
     * Release funds to seller (called automatically after delivery confirmation)
     * 
     * @param int $order_id
     */
    private function release_funds($order_id)
    {
        // Get order details
        $order = $this->db->select('ep.*, cd.companyID as sellerCompanyID')
                          ->from('equipment_payments ep')
                          ->join('companydetail cd', 'ep.sellerCompanyID = cd.companyID', 'left')
                          ->where('ep.equipmentPaymentID', $order_id)
                          ->get()
                          ->row();
        
        if (!$order || $order->orderStatus !== 'delivered') {
            log_message('error', "Cannot release funds for order {$order_id} - invalid status");
            return false;
        }
        
        // TODO: Implement Stripe transfer to seller's connected account
        // For now, just update the order status to completed
        
        $update_data = [
            'orderStatus' => 'completed',
            'fundsReleasedAt' => date('Y-m-d H:i:s'),
            'completedAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('equipmentPaymentID', $order_id);
        $result = $this->db->update('equipment_payments', $update_data);
        
        if ($result) {
            log_message('info', "Funds released for order {$order_id} - Order completed");
            // TODO: Add Stripe transfer logic here
            // $this->stripeservice->transfer_to_seller($order->netAmount, $seller_stripe_account);
        }
        
        return $result;
    }

    /**
     * Get invoice-ready order data with buyer and seller details.
     *
     * @param int $order_id
     * @param int $buyer_user_id
     * @return object|null
     */
    private function get_invoice_order_for_buyer($order_id, $buyer_user_id)
    {
        return $this->db->select(" 
            o.orderID,
            o.equipmentPaymentID,
            o.workforcePaymentID,
            COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount,
            COALESCE(ep.commissionPercent, wp.commissionPercent) as commissionPercent,
            COALESCE(ep.commissionAmount, wp.commissionAmount) as commissionAmount,
            COALESCE(ep.netAmount, wp.netAmount) as netAmount,
            COALESCE(ep.currency, wp.currency, 'USD') as currency,
            COALESCE(ep.paymentStatus, wp.paymentStatus) as paymentStatus,
            COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus) as orderStatus,
            COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) as rentalRequestStatus,
            COALESCE(ep.stripePaymentIntentID, wp.stripePaymentIntentID) as stripePaymentIntentID,
            COALESCE(ep.saleType, 'rental') as saleType,
            COALESCE(ep.quantity, DATEDIFF(wp.rentalEndDate, wp.rentalStartDate) + 1) as quantity,
            COALESCE(ep.rentalStartDate, wp.rentalStartDate) as rentalStartDate,
            COALESCE(ep.rentalEndDate, wp.rentalEndDate) as rentalEndDate,
            COALESCE(ep.rentalType, wp.rentalType) as rentalType,
            COALESCE(ep.paymentMetadata, wp.paymentMetadata) as paymentMetadata,
            COALESCE(ep.createdAt, wp.createdAt) as createdAt,
            COALESCE(ep.updatedAt, wp.updatedAt) as updatedAt,
            COALESCE(e.equipName, wf.personName) as itemName,
            buyer.userName as buyerName,
            buyer.userEmail as buyerEmail,
            buyer.userPhone as buyerPhone,
            cd.companyName as sellerCompanyName,
            seller.userName as sellerContactName,
            seller.userEmail as sellerEmail,
            seller.userPhone as sellerPhone
        ", false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('users buyer', 'COALESCE(ep.buyerUserID, wp.buyerUserID) = buyer.userID', 'left')
        ->join('companydetail cd', 'COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) = cd.companyID', 'left')
        ->join('users seller', 'cd.userID = seller.userID', 'left')
        ->where('o.orderID', $order_id)
        ->where('COALESCE(ep.buyerUserID, wp.buyerUserID) =', $buyer_user_id)
        ->get()
        ->row();
    }

    /**
     * Render and download invoice PDF.
     *
     * @param array $invoice_data
     * @return void
     */
    private function stream_invoice_pdf(array $invoice_data)
    {
        if (!class_exists('Dompdf\\Dompdf')) {
            $autoload_path = FCPATH . 'vendor/autoload.php';
            if (!file_exists($autoload_path)) {
                show_error('PDF library is not installed. Please run composer install.', 500);
                return;
            }
            require_once $autoload_path;
        }

        $html = $this->load->view('invoices/order_invoice_pdf', ['invoice' => $invoice_data], true);

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();

        $filename = 'invoice-' . preg_replace('/[^A-Za-z0-9\-_]/', '', (string)$invoice_data['invoice_number']) . '.pdf';
        $this->output
            ->set_content_type('application/pdf')
            ->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
            ->set_output($dompdf->output());
    }

    // =============================================
    // RENTAL LIFECYCLE ENDPOINTS (Renter-Side)
    // =============================================

    /**
     * API: Renter cancels a rental (72h refund policy enforced)
     * POST /orders/api_cancel_rental
     */
    public function api_cancel_rental()
    {
        header('Content-Type: application/json');
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            http_response_code(405); echo json_encode(['success'=>false,'message'=>'POST required']); return;
        }
        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            http_response_code(401); echo json_encode(['success'=>false,'message'=>'Not authenticated']); return;
        }
        $user_id    = $login_data['userID'];
        $payment_id = intval($this->input->post('payment_id', TRUE));
        $reason     = $this->input->post('reason', TRUE) ?: 'Cancelled by renter';
        $item_type  = $this->input->post('item_type', TRUE) === 'workforce' ? 'workforce' : 'equipment';
        if (!$payment_id) {
            http_response_code(400); echo json_encode(['success'=>false,'message'=>'Invalid payment ID']); return;
        }
        $this->load->model('Payment_model');
        $this->load->helper('notification');
        $table = $item_type === 'equipment' ? 'equipment_payments' : 'workforce_payments';
        $pk    = $item_type === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID';
        $select_cols = "{$pk}, buyerUserID, sellerCompanyID, rentalRequestStatus";
        if ($item_type === 'equipment') {
            $select_cols .= ', saleType';
        }
        $payment = $this->db->select($select_cols)
            ->from($table)->where($pk, $payment_id)->get()->row();
        if (!$payment || $payment->buyerUserID != $user_id) {
            http_response_code(403); echo json_encode(['success'=>false,'message'=>'Access denied']); return;
        }
        if ($item_type === 'equipment' && strtolower((string)($payment->saleType ?? 'purchase')) !== 'rental') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Cancellation is only available for rental equipment/workforce orders.']);
            return;
        }
        $result = $this->Payment_model->cancelRental($payment_id, $user_id, $reason, false, $item_type);
        if ($result['success']) {
            $order = $this->db->select('orderID')->from('orders')->where($pk, $payment_id)->get()->row();
            $admin = $this->db->select('userID')->from('companydetail')->where('companyID', $payment->sellerCompanyID)->get()->row();
            if ($admin && $order) { send_notification($admin->userID, 'rental_cancelled', $order->orderID); }
            echo json_encode(['success'=>true,'message'=>$result['message']]);
        } else {
            http_response_code(400); echo json_encode(['success'=>false,'message'=>$result['message']]);
        }
    }

    /**
     * API: Renter confirms they have returned the equipment
     * POST /orders/api_confirm_return
     */
    public function api_confirm_return()
    {
        header('Content-Type: application/json');
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            http_response_code(405); echo json_encode(['success'=>false,'message'=>'POST required']); return;
        }
        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            http_response_code(401); echo json_encode(['success'=>false,'message'=>'Not authenticated']); return;
        }
        $user_id    = $login_data['userID'];
        $payment_id = intval($this->input->post('payment_id', TRUE));
        $notes      = $this->input->post('notes', TRUE) ?? '';
        $item_type  = $this->input->post('item_type', TRUE) === 'workforce' ? 'workforce' : 'equipment';
        if (!$payment_id) {
            http_response_code(400); echo json_encode(['success'=>false,'message'=>'Invalid payment ID']); return;
        }
        $this->load->model('Payment_model');
        $this->load->helper('notification');
        $table = $item_type === 'equipment' ? 'equipment_payments' : 'workforce_payments';
        $pk    = $item_type === 'equipment' ? 'equipmentPaymentID' : 'workforcePaymentID';
        $payment = $this->db->select("{$pk}, buyerUserID, sellerCompanyID, rentalRequestStatus")
            ->from($table)->where($pk, $payment_id)->get()->row();
        if (!$payment || $payment->buyerUserID != $user_id) {
            http_response_code(403); echo json_encode(['success'=>false,'message'=>'Access denied']); return;
        }
        if (!in_array($payment->rentalRequestStatus, ['rental_active','return_requested','rental_overdue','under_review','received_by_owner'])) {
            http_response_code(400); echo json_encode(['success'=>false,'message'=>'Can only confirm return for active, pending-return, overdue, under-review, or owner-received rentals']); return;
        }
        $result = $this->Payment_model->confirmReturnByRenter($payment_id, $notes, $item_type);
        if ($result['success']) {
            $order = $this->db->select('orderID')->from('orders')->where($pk, $payment_id)->get()->row();
            if ($order) {
                $admin = $this->db->select('userID')->from('companydetail')->where('companyID', $payment->sellerCompanyID)->get()->row();
                if ($admin) {
                    $notif_type = (isset($result['status']) && $result['status']==='rental_completed') ? 'rental_completed' : 'return_requested';
                    send_notification($admin->userID, $notif_type, $order->orderID);
                    send_notification($payment->buyerUserID, $notif_type, $order->orderID);
                }
            }
            echo json_encode(['success'=>true,'message'=>$result['message']]);
        } else {
            http_response_code(400); echo json_encode(['success'=>false,'message'=>$result['message']]);
        }
    }

    /**
     * API: Renter reports an issue. Delegates to Issues::api_create_issue()
     * POST /orders/api_report_issue
     */
    public function api_report_issue()
    {
        if (!class_exists('Issues', false)) {
            require_once APPPATH . 'controllers/Issues.php';
        }

        $this->load->model('Issue_model');
        $this->load->model('Chat_model');
        $this->load->helper(['notification','status_display']);
        $issues_ctrl = new Issues();
        $issues_ctrl->api_create_issue();
    }

    /**
     * Normalize legacy under_review payment state when no issues are currently open.
     *
     * @param string $table
     * @param string $pk
     * @param int $payment_id
     * @return string|null Restored rental status or null if unchanged.
     */
    private function normalize_payment_issue_status($table, $pk, $payment_id)
    {
        if (empty($payment_id)) {
            return null;
        }

        $payment = $this->db->get_where($table, [$pk => $payment_id])->row();
        if (!$payment) {
            return null;
        }

        $rental_status = strtolower(trim((string)($payment->rentalRequestStatus ?? '')));
        if ($rental_status !== 'under_review') {
            return null;
        }

        if ($table === 'equipment_payments') {
            $this->db->where('equipmentPaymentID', $payment_id);
        } else {
            $this->db->where('workforcePaymentID', $payment_id);
        }
        $open_issue_count = $this->db->where_in('issueStatus', ['reported', 'under_review'])
            ->count_all_results('rental_issues');

        if ($open_issue_count > 0) {
            return null;
        }

        $order_status = strtolower(trim((string)($payment->orderStatus ?? '')));
        $start_ts = !empty($payment->rentalStartDate) ? strtotime($payment->rentalStartDate . ' 00:00:00') : null;
        $end_ts = !empty($payment->rentalEndDate) ? strtotime($payment->rentalEndDate . ' 23:59:59') : null;
        $renter_confirmed = !empty($payment->renterConfirmedReturn);
        $owner_confirmed = !empty($payment->ownerConfirmedReturn);

        $restored_status = 'rental_active';
        if ($renter_confirmed && $owner_confirmed) {
            $restored_status = 'rental_completed';
        } elseif ($renter_confirmed) {
            $restored_status = 'returned_by_renter';
        } elseif ($owner_confirmed) {
            $restored_status = 'received_by_owner';
        } elseif ($start_ts && time() < $start_ts) {
            $restored_status = in_array($order_status, ['request_pending', 'request_approved', 'awaiting_handover'], true)
                ? $order_status
                : 'awaiting_handover';
        } elseif ($end_ts && time() > ($end_ts + (72 * 3600))) {
            $restored_status = 'rental_overdue';
        } elseif ($end_ts && time() > $end_ts) {
            $restored_status = 'return_requested';
        }

        $this->db->update($table, [
            'rentalRequestStatus' => $restored_status,
            'hasActiveIssue' => 0,
            'currentIssueID' => null,
            'updatedAt' => date('Y-m-d H:i:s'),
        ], [$pk => $payment_id]);

        return $restored_status;
    }
}
