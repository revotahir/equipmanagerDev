<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Cron Controller
 *
 * Cron controller for automated rental lifecycle state machine.
 * Supports CLI and pseudo-cron HTTP calls guarded by a shared secret.
 *
 * Crontab setup (Europe/Copenhagen timezone):
 *   0 0 * * *  php /path/to/equipmanager/index.php cron activate_due_rentals
 *   0 1 * * *  php /path/to/equipmanager/index.php cron check_overdue_rentals
 *   0 2 * * *  php /path/to/equipmanager/index.php cron expire_old_checkout_tokens (no-op; links are indefinite)
 *   0 12 * * * php /path/to/equipmanager/index.php cron warn_expiring_checkouts (no-op; links are indefinite)
 *   0 3 * * 0  php /path/to/equipmanager/index.php cron cleanup_old_notifications
 *
 * Pseudo-cron endpoint:
 *   /cron/pseudo_run?secret=...
 */
class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // SECURITY: Allow CLI, or HTTP with specific pseudo-cron secret
        $secret = $this->input->get('secret');
        $expected_secret = 'eqm_auto_cron_7791'; // Hardcoded secret for pseudo-cron

        if (!$this->input->is_cli_request() && $secret !== $expected_secret) {
            show_error('Cron jobs can only be run via CLI or with valid secret', 403);
            exit;
        }

        $this->load->database();
        $this->load->model('Payment_model');
        $this->load->model('Notification_model');
        $this->load->helper('notification');
    }

    /**
     * List available cron jobs (test command)
     * CLI: php index.php cron index
     */
    public function index()
    {
        echo "EquipManager Cron Jobs:\n";
        echo "  pseudo_run               - Trigger scheduled jobs with built-in throttling\n";
        echo "  activate_due_rentals     - Activate rentals starting today\n";
        echo "  check_overdue_rentals    - Mark overdue rentals\n";
        echo "  expire_old_checkout_tokens - No-op (checkout links are non-expiring)\n";
        echo "  warn_expiring_checkouts  - No-op (checkout links are non-expiring)\n";
        echo "  cleanup_old_notifications - Delete read notifications older than 90 days\n";
        echo "\nCurrent time: " . date('Y-m-d H:i:s') . " (server)\n";
    }

    /**
     * Pseudo-cron runner for environments without server-level cron.
     *
     * Triggered by website footer in background. Uses file-based state to:
     * - throttle frequent calls,
     * - run daily jobs only once per day,
     * - run cleanup once per week.
     */
    public function pseudo_run()
    {
        header('Content-Type: application/json');

        $now_ts = time();
        $today = date('Y-m-d');
        $state_file = APPPATH . 'cache/pseudo_cron_state.json';

        $state = [
            'lock_until' => 0,
            'last_activate_due_rentals' => null,
            'last_check_overdue_rentals' => null,
            'last_cleanup_old_notifications' => null,
        ];

        if (is_file($state_file)) {
            $raw = @file_get_contents($state_file);
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $state = array_merge($state, $decoded);
            }
        }

        if ($now_ts < intval($state['lock_until'])) {
            echo json_encode([
                'success' => true,
                'message' => 'Pseudo-cron throttled',
                'ran' => [],
            ]);
            return;
        }

        // Lock for 90s to avoid burst executions from multiple visitors.
        $state['lock_until'] = $now_ts + 90;
        @file_put_contents($state_file, json_encode($state), LOCK_EX);

        $ran = [];
        $errors = [];

        if (($state['last_activate_due_rentals'] ?? null) !== $today) {
            try {
                ob_start();
                $this->activate_due_rentals();
                $output = trim(ob_get_clean());
                $state['last_activate_due_rentals'] = $today;
                $ran['activate_due_rentals'] = $output;
            } catch (Throwable $e) {
                if (ob_get_level() > 0) {
                    ob_end_clean();
                }
                $errors['activate_due_rentals'] = $e->getMessage();
            }
        }

        if (($state['last_check_overdue_rentals'] ?? null) !== $today) {
            try {
                ob_start();
                $this->check_overdue_rentals();
                $output = trim(ob_get_clean());
                $state['last_check_overdue_rentals'] = $today;
                $ran['check_overdue_rentals'] = $output;
            } catch (Throwable $e) {
                if (ob_get_level() > 0) {
                    ob_end_clean();
                }
                $errors['check_overdue_rentals'] = $e->getMessage();
            }
        }

        $current_week = date('o-W');
        $last_cleanup_week = null;
        if (!empty($state['last_cleanup_old_notifications'])) {
            $last_cleanup_week = date('o-W', strtotime($state['last_cleanup_old_notifications']));
        }

        if ($last_cleanup_week !== $current_week) {
            try {
                ob_start();
                $this->cleanup_old_notifications();
                $output = trim(ob_get_clean());
                $state['last_cleanup_old_notifications'] = date('Y-m-d H:i:s');
                $ran['cleanup_old_notifications'] = $output;
            } catch (Throwable $e) {
                if (ob_get_level() > 0) {
                    ob_end_clean();
                }
                $errors['cleanup_old_notifications'] = $e->getMessage();
            }
        }

        $state['lock_until'] = 0;
        @file_put_contents($state_file, json_encode($state), LOCK_EX);

        echo json_encode([
            'success' => empty($errors),
            'message' => empty($errors) ? 'Pseudo-cron completed' : 'Pseudo-cron completed with errors',
            'ran' => array_keys($ran),
            'errors' => $errors,
        ]);
    }

    /**
     * JOB 1: Activate rentals where start date = today
     * Run: 0 0 * * * (midnight)
     *
     * Finds all approved+paid rentals with rentalStartDate = TODAY
     * and transitions them to 'rental_active'.
     */
    public function activate_due_rentals()
    {
        $today     = date('Y-m-d');
        $activated = 0;
        $errors    = 0;

        echo "[Cron] activate_due_rentals - {$today}\n";

        // Equipment rentals
        $equipment_rentals = $this->db->select(
                'ep.equipmentPaymentID, ep.buyerUserID, ep.sellerCompanyID, o.orderID')
            ->from('equipment_payments ep')
            ->join('orders o', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->where('ep.orderStatus', 'delivered')
            ->where_in('ep.rentalRequestStatus', ['request_approved', 'awaiting_handover'])
            ->where_in('ep.paymentStatus', ['paid', 'completed'])
            ->where('ep.rentalStartDate', $today)
            ->get()->result();

        foreach ($equipment_rentals as $rental) {
            $this->db->update('equipment_payments',
                ['rentalRequestStatus' => 'rental_active', 'updatedAt' => date('Y-m-d H:i:s')],
                ['equipmentPaymentID' => $rental->equipmentPaymentID]
            );

            if ($this->db->affected_rows() > 0) {
                $activated++;

                if ($rental->orderID) {
                    // Notify renter
                    send_notification($rental->buyerUserID, 'rental_started', $rental->orderID);

                    // Notify company admin
                    $admin = $this->db->select('userID')
                        ->from('companydetail')
                        ->where('companyID', $rental->sellerCompanyID)
                        ->get()->row();
                    if ($admin) {
                        send_notification($admin->userID, 'rental_started', $rental->orderID);
                    }
                }
            } else {
                $errors++;
            }
        }

        // Workforce rentals (same logic)
        $workforce_rentals = $this->db->select(
                'wp.workforcePaymentID, wp.buyerUserID, wp.sellerCompanyID, o.orderID')
            ->from('workforce_payments wp')
            ->join('orders o', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->where('wp.orderStatus', 'delivered')
            ->where_in('wp.rentalRequestStatus', ['request_approved', 'awaiting_handover'])
            ->where_in('wp.paymentStatus', ['paid', 'completed'])
            ->where('wp.rentalStartDate', $today)
            ->get()->result();

        foreach ($workforce_rentals as $rental) {
            $this->db->update('workforce_payments',
                ['rentalRequestStatus' => 'rental_active', 'updatedAt' => date('Y-m-d H:i:s')],
                ['workforcePaymentID' => $rental->workforcePaymentID]
            );

            if ($this->db->affected_rows() > 0) {
                $activated++;

                if ($rental->orderID) {
                    send_notification($rental->buyerUserID, 'rental_started', $rental->orderID);
                    $admin = $this->db->select('userID')
                        ->from('companydetail')
                        ->where('companyID', $rental->sellerCompanyID)
                        ->get()->row();
                    if ($admin) {
                        send_notification($admin->userID, 'rental_started', $rental->orderID);
                    }
                }
            } else {
                $errors++;
            }
        }

        $msg = "Done: activated={$activated}, errors={$errors}";
        echo "[Cron] {$msg}\n";
        log_message('info', "Cron activate_due_rentals: {$msg}");
    }

    /**
     * JOB 2: Move rentals through post-end lifecycle
     * Run: 0 1 * * * (1 AM)
     *
     * Rules:
     * - After rentalEndDate passes -> return_requested (pending return)
     * - 72 hours after rentalEndDate end-of-day -> rental_overdue
     */
    public function check_overdue_rentals()
    {
        $today = date('Y-m-d');
        $pending_return = 0;
        $overdue = 0;

        echo "[Cron] check_overdue_rentals - {$today}\n";

        // Equipment
        $equipment_rows = $this->db->select('ep.equipmentPaymentID, ep.buyerUserID, ep.sellerCompanyID, ep.rentalRequestStatus, ep.rentalEndDate, o.orderID')
            ->from('equipment_payments ep')
            ->join('orders o', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
            ->where('ep.orderStatus', 'delivered')
            ->where_in('ep.rentalRequestStatus', ['rental_active', 'return_requested'])
            ->where('ep.rentalEndDate <', $today)
            ->where('ep.renterConfirmedReturn', 0)
            ->get()->result();

        foreach ($equipment_rows as $rental) {
            $end_of_day = strtotime($rental->rentalEndDate . ' 23:59:59');
            if (!$end_of_day) {
                continue;
            }

            $is_past_72h = (time() > ($end_of_day + (72 * 3600)));
            $next_status = $is_past_72h ? 'rental_overdue' : 'return_requested';

            if ($rental->rentalRequestStatus === $next_status) {
                continue;
            }

            $this->db->update('equipment_payments',
                ['rentalRequestStatus' => $next_status, 'updatedAt' => date('Y-m-d H:i:s')],
                ['equipmentPaymentID' => $rental->equipmentPaymentID]
            );

            if ($this->db->affected_rows() <= 0) {
                continue;
            }

            if ($next_status === 'return_requested') {
                $pending_return++;
            } else {
                $overdue++;
            }

            if ($rental->orderID) {
                $notif_type = ($next_status === 'return_requested') ? 'return_requested' : 'rental_overdue';
                send_notification($rental->buyerUserID, $notif_type, $rental->orderID);
                $admin = $this->db->select('userID')
                    ->from('companydetail')
                    ->where('companyID', $rental->sellerCompanyID)
                    ->get()->row();
                if ($admin) {
                    send_notification($admin->userID, $notif_type, $rental->orderID);
                }
            }
        }

        // Workforce
        $workforce_rows = $this->db->select('wp.workforcePaymentID, wp.buyerUserID, wp.sellerCompanyID, wp.rentalRequestStatus, wp.rentalEndDate, o.orderID')
            ->from('workforce_payments wp')
            ->join('orders o', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
            ->where('wp.orderStatus', 'delivered')
            ->where_in('wp.rentalRequestStatus', ['rental_active', 'return_requested'])
            ->where('wp.rentalEndDate <', $today)
            ->where('wp.renterConfirmedReturn', 0)
            ->get()->result();

        foreach ($workforce_rows as $rental) {
            $end_of_day = strtotime($rental->rentalEndDate . ' 23:59:59');
            if (!$end_of_day) {
                continue;
            }

            $is_past_72h = (time() > ($end_of_day + (72 * 3600)));
            $next_status = $is_past_72h ? 'rental_overdue' : 'return_requested';

            if ($rental->rentalRequestStatus === $next_status) {
                continue;
            }

            $this->db->update('workforce_payments',
                ['rentalRequestStatus' => $next_status, 'updatedAt' => date('Y-m-d H:i:s')],
                ['workforcePaymentID' => $rental->workforcePaymentID]
            );

            if ($this->db->affected_rows() <= 0) {
                continue;
            }

            if ($next_status === 'return_requested') {
                $pending_return++;
            } else {
                $overdue++;
            }

            if ($rental->orderID) {
                $notif_type = ($next_status === 'return_requested') ? 'return_requested' : 'rental_overdue';
                send_notification($rental->buyerUserID, $notif_type, $rental->orderID);
                $admin = $this->db->select('userID')
                    ->from('companydetail')
                    ->where('companyID', $rental->sellerCompanyID)
                    ->get()->row();
                if ($admin) {
                    send_notification($admin->userID, $notif_type, $rental->orderID);
                }
            }
        }

        $msg = "Done: pending_return={$pending_return}, overdue={$overdue}";
        echo "[Cron] {$msg}\n";
        log_message('info', "Cron check_overdue_rentals: {$msg}");
    }

    /**
     * JOB 3: Expire checkout tokens for unpaid approved rentals
     * Run: 0 2 * * * (2 AM)
     */
    public function expire_old_checkout_tokens()
    {
        $now = date('Y-m-d H:i:s');
        $msg = 'Skipped: checkout links are configured as non-expiring';
        echo "[Cron] expire_old_checkout_tokens - {$now}\n";
        echo "[Cron] {$msg}\n";
        log_message('info', "Cron expire_old_checkout_tokens: {$msg}");
    }

    /**
     * JOB 4: Warn buyers about checkout links expiring in the next 24 hours
     * Run: 0 12 * * * (noon)
     */
    public function warn_expiring_checkouts()
    {
        $now = date('Y-m-d H:i:s');
        $msg = 'Skipped: checkout links are configured as non-expiring';
        echo "[Cron] warn_expiring_checkouts - {$now}\n";
        echo "[Cron] {$msg}\n";
        log_message('info', "Cron warn_expiring_checkouts: {$msg}");
    }

    /**
     * JOB 5: Delete old read notifications (cleanup)
     * Run: 0 3 * * 0 (3 AM every Sunday)
     */
    public function cleanup_old_notifications()
    {
        $deleted = $this->Notification_model->deleteOldNotifications(90);
        $msg     = "Done: deleted={$deleted} old notifications";
        echo "[Cron] {$msg}\n";
        log_message('info', "Cron cleanup_old_notifications: {$msg}");
    }
}

