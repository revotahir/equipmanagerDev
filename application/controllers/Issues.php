<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Issues Controller
 *
 * Handles issue reporting API endpoints accessible by buyers and sellers.
 * SuperAdmin issue management is in Superadmin.php.
 */
class Issues extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Issue_model');
        $this->load->model('Payment_model');
        $this->load->model('Chat_model');
        $this->load->model('Notification_model');
        $this->load->helper(['notification', 'status_display']);
    }

    /**
     * API: Create an issue for a rental
     * POST — JSON response
     * Accessible by both renters (buyer) and company admins (owner)
     */
    public function api_create_issue()
    {
        header('Content-Type: application/json');

        $request_method = strtoupper($this->input->method(TRUE));
        if (!in_array($request_method, ['POST', 'GET'])) {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Unsupported request method']);
            return;
        }

        $login_data = $this->session->userdata('loginData');
        if (!$login_data || !isset($login_data['userID'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $user_id = $login_data['userID'];
        $has_chat_links = $this->db->table_exists('order_chat_links');

        $raw_payload = [];
        $raw_input = $this->input->raw_input_stream;
        if (!empty($raw_input)) {
            $decoded = json_decode($raw_input, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $raw_payload = $decoded;
            } else {
                parse_str($raw_input, $parsed_payload);
                if (is_array($parsed_payload)) {
                    $raw_payload = $parsed_payload;
                }
            }
        }

        $read_field = function ($name, $fallback = null) use ($raw_payload) {
            $v = $this->input->post($name, TRUE);
            if ($v !== null && $v !== '') {
                return $v;
            }
            $v = $this->input->get($name, TRUE);
            if ($v !== null && $v !== '') {
                return $v;
            }
            if (array_key_exists($name, $raw_payload) && $raw_payload[$name] !== '') {
                return $raw_payload[$name];
            }
            return $fallback;
        };

        // Input - accept both 'title'/'description' and 'issue_title'/'issue_description' for flexibility
        $order_id    = intval($read_field('order_id'));
        $issue_type  = $read_field('issue_type');
        $title       = $read_field('issue_title', $read_field('title'));
        $description = $read_field('issue_description', $read_field('description'));

        if (!$order_id || !$issue_type || !$title || !$description) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Missing required fields: order_id, issue_type, issue_title, issue_description',
                'debug' => [
                    'received_order_id' => $order_id,
                    'received_issue_type' => $issue_type,
                    'received_title' => !empty($title),
                    'received_description' => !empty($description),
                ],
            ]);
            return;
        }

        // Validate issue_type against supported schema values.
        $valid_types = ['late_delivery', 'late_return', 'damaged', 'missing_parts', 'malfunction', 'other'];
        if (!in_array($issue_type, $valid_types)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid issue type']);
            return;
        }

        // Get order and verify user has access
        $order = $this->db->select('
            o.orderID, o.equipmentPaymentID, o.workforcePaymentID,
            COALESCE(ep.buyerUserID, wp.buyerUserID) as buyerUserID,
            COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) as sellerCompanyID,
            COALESCE(ep.saleType, wp.rentalType) as saleType,
            COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) as rentalStatus,
            COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus) as orderStatus,
            COALESCE(ep.rentalStartDate, wp.rentalStartDate) as rentalStartDate,
            COALESCE(ep.rentalEndDate, wp.rentalEndDate) as rentalEndDate,
            COALESCE(ep.renterConfirmedReturn, wp.renterConfirmedReturn) as renterConfirmedReturn,
            COALESCE(ep.ownerConfirmedReturn, wp.ownerConfirmedReturn) as ownerConfirmedReturn,
            oc.chatID
        ', false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join($has_chat_links ? 'order_chat_links ocl' : 'order_chats oc', $has_chat_links ? 'ocl.orderID = o.orderID' : 'oc.orderID = o.orderID', 'left');

        if ($has_chat_links) {
            $this->db->join('order_chats oc', 'oc.chatID = ocl.chatID', 'left');
        }

        $this->db
        ->where('o.orderID', $order_id)
        ->get()->row();

        if (!$order) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Order not found']);
            return;
        }

        $is_workforce_order = !empty($order->workforcePaymentID);
        $is_equipment_rental = !$is_workforce_order && strtolower((string)($order->saleType ?? '')) === 'rental';
        $is_rental_order = $is_workforce_order || $is_equipment_rental;
        if (!$is_rental_order) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Issue reporting is available only for rental equipment/workforce orders.',
            ]);
            return;
        }

        // Determine reporter type / verify access
        $reporter_type = null;
        if ($order->buyerUserID == $user_id) {
            $reporter_type = 'renter';
        } else {
            // Check if user is company admin for this company
            $company = $this->db->get_where('companydetail', [
                'userID'    => $user_id,
                'companyID' => $order->sellerCompanyID,
            ])->row();
            if ($company) {
                $reporter_type = 'owner';
            }
        }

        if (!$reporter_type) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Access denied — not a party to this order']);
            return;
        }

        $order_status_value = strtolower(trim((string) ($order->orderStatus ?? '')));
        $rental_status_value = strtolower(trim((string) ($order->rentalStatus ?? '')));

        $is_terminal = in_array($rental_status_value, ['rental_completed', 'rental_cancelled'], true)
            || in_array($order_status_value, ['completed', 'cancelled', 'rejected', 'refunded'], true);
        if ($is_terminal) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Issue reporting is not available for completed/cancelled orders.',
                'status_debug' => [
                    'orderStatus' => $order->orderStatus,
                    'rentalStatus' => $order->rentalStatus,
                ],
            ]);
            return;
        }

        $start_ts = !empty($order->rentalStartDate) ? strtotime($order->rentalStartDate . ' 00:00:00') : null;
        $post_handover_states = ['rental_active','return_requested','rental_overdue','returned_by_renter','received_by_owner','under_review','rental_completed','rental_cancelled'];
        $pre_handover_order_states = ['request_approved','awaiting_handover','payment_secured','shipped','pickup_ready','delivered'];

        $is_late_arrival_window = $start_ts
            && time() >= $start_ts
            && in_array($order_status_value, $pre_handover_order_states, true)
            && !in_array($rental_status_value, $post_handover_states, true);

        $is_active_rental = ($rental_status_value === 'rental_active');
        $is_overdue_rental = ($rental_status_value === 'rental_overdue');
        $has_renter_returned = intval($order->renterConfirmedReturn ?? 0) === 1;
        $has_owner_confirmed = intval($order->ownerConfirmedReturn ?? 0) === 1;
        $end_ts = !empty($order->rentalEndDate) ? strtotime($order->rentalEndDate . ' 23:59:59') : null;
        $is_past_return_grace = $end_ts ? (time() > ($end_ts + (72 * 3600))) : false;
        $late_return_allowed = !$has_renter_returned && ($is_overdue_rental || $is_past_return_grace);
        $owner_return_inspection_window = ($reporter_type === 'owner' && $has_renter_returned && !$has_owner_confirmed);

        // Late return can only be reported when rental is overdue.
        if ($issue_type === 'late_return') {
            if ($reporter_type !== 'owner') {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Late return issues can only be reported by the owner.',
                ]);
                return;
            }

            if (!$late_return_allowed) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Late return can only be reported for overdue rentals that are not yet returned.',
                    'status_debug' => [
                        'rentalStatus' => $order->rentalStatus,
                        'rentalEndDate' => $order->rentalEndDate,
                        'isPastGraceWindow' => $is_past_return_grace,
                        'renterConfirmedReturn' => $order->renterConfirmedReturn,
                    ],
                ]);
                return;
            }

            // If time-window says overdue but status is stale, align status now.
            if (!$is_overdue_rental && $is_past_return_grace) {
                if (!empty($order->equipmentPaymentID)) {
                    $this->db->update('equipment_payments', [
                        'rentalRequestStatus' => 'rental_overdue',
                        'updatedAt' => date('Y-m-d H:i:s'),
                    ], ['equipmentPaymentID' => $order->equipmentPaymentID]);
                } elseif (!empty($order->workforcePaymentID)) {
                    $this->db->update('workforce_payments', [
                        'rentalRequestStatus' => 'rental_overdue',
                        'updatedAt' => date('Y-m-d H:i:s'),
                    ], ['workforcePaymentID' => $order->workforcePaymentID]);
                }
            }
        }

        // Late delivery can only be reported during the late-arrival window.
        if ($issue_type === 'late_delivery') {
            if (!$is_late_arrival_window) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Late delivery can only be reported after rental start date if the item has still not arrived.',
                ]);
                return;
            }
        }

        // Damage/missing/malfunction/other can be reported during active rental,
        // and by owner during return inspection (after renter marks returned, before owner confirms receipt).
        if (in_array($issue_type, ['damaged', 'missing_parts', 'malfunction', 'other'], true)
            && !$is_active_rental
            && !$owner_return_inspection_window) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'This issue type can only be reported during an active rental, or by the owner before return receipt is confirmed.',
            ]);
            return;
        }

        // Create issue
        $issue_data = [
            'orderID'             => $order_id,
            'equipmentPaymentID'  => $order->equipmentPaymentID,
            'workforcePaymentID'  => $order->workforcePaymentID,
            'issueType'           => $issue_type,
            'issueTitle'          => $title,
            'issueDescription'    => $description,
            'reportedBy'          => $user_id,
            'reporterType'        => $reporter_type,
        ];

        // Handle evidence uploads (optional) - only images/videos are accepted.
        $attachment_urls = null;
        if (!empty($_FILES)) {
            $this->load->library('upload');
            $upload_path = './assets/uploads/issues/';
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            $attachments = [];
            $file_count = 0;
            $upload_errors = [];

            // Process each uploaded file
            foreach ($_FILES as $field_name => $file_info) {
                if (strpos($field_name, 'attachment_') === 0 && !empty($file_info['name'])) {
                    // Reset upload library config for each file
                    $config = [
                        'upload_path'   => $upload_path,
                        'allowed_types' => 'gif|jpg|jpeg|png|webp|bmp|tif|tiff|mp4|mov|avi|mkv|webm|mpeg|mpg|m4v|3gp',
                        'max_size'      => '25600', // 25MB per file
                        'encrypt_name'  => true,
                        'overwrite'     => false,
                    ];
                    
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload($field_name)) {
                        $upload_data = $this->upload->data();
                        $mime = strtolower((string) ($upload_data['file_type'] ?? ''));

                        if (strpos($mime, 'image/') !== 0 && strpos($mime, 'video/') !== 0) {
                            @unlink($upload_data['full_path']);
                            $upload_errors[] = 'Only image or video files are allowed.';
                            continue;
                        }

                        $attachments[] = 'assets/uploads/issues/' . $upload_data['file_name'];
                        $file_count++;
                    } else {
                        $upload_errors[] = strip_tags($this->upload->display_errors('', ''));
                        log_message('error', 'Issue media upload failed: ' . $this->upload->display_errors('', ''));
                    }
                }
            }

            if (!empty($upload_errors)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Attachment upload failed. Only images/videos are allowed and each file must be under 25MB.',
                    'errors'  => $upload_errors,
                ]);
                return;
            }

            if (!empty($attachments)) {
                $attachment_urls = json_encode($attachments);
                $issue_data['attachmentUrls'] = $attachment_urls;
            }
        }

        $issue_id = $this->Issue_model->createIssue($issue_data);

        if (!$issue_id) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to create issue']);
            return;
        }

        // Update payment record to flag active issue
        if ($order->equipmentPaymentID) {
            $this->db->update('equipment_payments', [
                'hasActiveIssue' => 1,
                'currentIssueID' => $issue_id,
                'updatedAt' => date('Y-m-d H:i:s'),
            ], ['equipmentPaymentID' => $order->equipmentPaymentID]);
        } elseif ($order->workforcePaymentID) {
            $this->db->update('workforce_payments', [
                'hasActiveIssue' => 1,
                'currentIssueID' => $issue_id,
                'updatedAt' => date('Y-m-d H:i:s'),
            ], ['workforcePaymentID' => $order->workforcePaymentID]);
        }

        // Upgrade chat to dispute chat
        if (!empty($order->chatID)) {
            $this->Chat_model->upgrade_to_dispute_chat($order->chatID, $issue_id);
        }

        // Notify the other party
        $this->load->helper('notification');
        if ($reporter_type === 'renter') {
            // Notify company admin
            $admin = $this->db->select('userID')
                ->from('companydetail')
                ->where('companyID', $order->sellerCompanyID)
                ->get()->row();
            if ($admin) {
                send_notification($admin->userID, 'issue_reported', $order_id, ['issue_type' => $issue_type], $issue_id);
            }
        } else {
            // Notify renter
            send_notification($order->buyerUserID, 'issue_reported', $order_id, ['issue_type' => $issue_type], $issue_id);
        }

        // Notify all SuperAdmins
        notify_super_admins('issue_reported', $order_id, ['issue_type' => $issue_type], $issue_id);

        log_message('info', "Issue {$issue_id} created by {$reporter_type} {$user_id} for order {$order_id}");

        echo json_encode([
            'success'  => true,
            'issue_id' => $issue_id,
            'message'  => 'Issue reported successfully. A platform administrator has been notified.',
        ]);
    }

    /**
     * Get issues for a specific order (buyer view)
     * GET — JSON response
     */
    public function api_get_order_issues()
    {
        header('Content-Type: application/json');

        $login_data = $this->session->userdata('loginData');
        if (!$login_data) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $order_id = intval($this->input->get('order_id', TRUE));
        if (!$order_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'order_id required']);
            return;
        }

        $issues = $this->Issue_model->getIssuesForOrder($order_id);
        echo json_encode(['success' => true, 'issues' => $issues]);
    }
}
