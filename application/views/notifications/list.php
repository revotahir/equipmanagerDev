<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?= base_url() ?>assets/images/logo-icon.png" type="image/png" />

    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/style.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/header.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/footer.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/resopnsive.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

    <title>Notifications - Equip Manager</title>

    <style>
        :root {
            --primary-brand: #13372E;
            --accent-green: #2A7A66;
            --text-primary: #1A1A1A;
            --text-secondary: #6B7280;
            --text-light: #FFFFFF;
            --body-bg: #F5F6F8;
            --card-bg: #FFFFFF;
            --border-color: #E5E7EB;
            --table-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
            --unread-bg: #F0F9F4;
            --danger-bg: #fff5f5;
            --danger-text: #b91c1c;
        }

        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--body-bg);
            font-family: "Manrope", sans-serif;
            color: var(--text-primary);
        }

        .main-wrapper {
            padding: 0 40px;
            max-width: 1600px;
            margin: 0 auto;
            width: 100%;
        }

        .dashboard-container {
            display: flex;
            gap: 0;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .dashboard-content {
            flex: 1;
            background-color: var(--body-bg);
            padding: 40px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .notifications-shell {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--table-shadow);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .notifications-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 20px 22px;
            border-bottom: 1px solid var(--border-color);
            background: #fbfbfc;
        }

        .notifications-title {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-primary);
        }

        .notifications-title i {
            color: var(--primary-brand);
            font-size: 20px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-clean {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: #fff;
            color: var(--text-primary);
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-clean:hover {
            border-color: var(--accent-green);
            color: var(--accent-green);
        }

        .btn-brand {
            border: 1px solid var(--primary-brand);
            border-radius: 8px;
            background: var(--primary-brand);
            color: #fff;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-brand:hover {
            background: var(--accent-green);
            border-color: var(--accent-green);
        }

        .notifications-list {
            display: flex;
            flex-direction: column;
        }

        .notification-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            justify-content: space-between;
            padding: 16px 22px;
            border-bottom: 1px solid var(--border-color);
            text-decoration: none;
            color: inherit;
            transition: background 0.2s ease;
        }

        .notification-item:hover {
            background: #f9fafb;
        }

        .notification-item.is-unread {
            background: var(--unread-bg);
        }

        .notification-main {
            min-width: 0;
            flex: 1;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .notif-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
            background: #eef2f7;
            color: #334155;
        }

        .notif-icon.request { background: #e8f7ef; color: #166534; }
        .notif-icon.approved { background: #ecfdf3; color: #15803d; }
        .notif-icon.rejected { background: #fff1f2; color: #be123c; }
        .notif-icon.expired { background: #fff7ed; color: #c2410c; }
        .notif-icon.payment { background: #eef2ff; color: #3730a3; }
        .notif-icon.started { background: #eff6ff; color: #1d4ed8; }
        .notif-icon.return { background: #ecfeff; color: #0e7490; }
        .notif-icon.issue { background: #fff7ed; color: #9a3412; }

        .notif-content {
            min-width: 0;
        }

        .notif-top {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 4px;
        }

        .notif-title {
            margin: 0;
            font-size: 15px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .unread-pill {
            font-size: 10px;
            font-weight: 800;
            color: #0f5132;
            background: #d1f4df;
            border-radius: 999px;
            padding: 3px 8px;
        }

        .notif-body {
            margin: 0;
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .notification-side {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .notif-time {
            font-size: 12px;
            color: var(--text-secondary);
            white-space: nowrap;
        }

        .delete-btn {
            border: none;
            background: transparent;
            color: #9ca3af;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .delete-btn:hover {
            background: var(--danger-bg);
            color: var(--danger-text);
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 42px;
            color: #9ca3af;
            margin-bottom: 12px;
            display: inline-block;
        }

        .empty-state h3 {
            margin: 0 0 8px 0;
            font-size: 20px;
            color: var(--text-primary);
        }

        .empty-state p {
            margin: 0;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .pagination-wrap {
            padding: 16px 22px;
            display: flex;
            justify-content: center;
            border-top: 1px solid var(--border-color);
            background: #fff;
        }

        .pagination {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            text-decoration: none;
            color: var(--text-primary);
            background: #fff;
            font-size: 13px;
            font-weight: 700;
        }

        .page-link.active {
            background: var(--primary-brand);
            border-color: var(--primary-brand);
            color: #fff;
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                flex-direction: column;
            }

            .dashboard-content {
                padding: 24px;
            }

            .main-wrapper {
                padding: 0 16px;
            }
        }

        @media (max-width: 768px) {
            .main-wrapper {
                padding: 0 12px;
            }

            .dashboard-content {
                padding: 16px;
            }

            .notifications-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
            }

            .btn-clean, .btn-brand {
                width: 100%;
            }

            .notification-item {
                padding: 14px;
                flex-direction: column;
            }

            .notification-side {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>
    <?php $this->load->view('components/websiteHeader'); ?>

    <div class="main-wrapper">
        <div class="dashboard-container">
            <?php $this->load->view('components/dashboardSidebar', [
                'active_page' => 'notifications',
                'employee_nav' => !empty($employee_nav)
            ]); ?>
            <main class="dashboard-content">
                <section class="notifications-shell">
                    <div class="notifications-header">
                        <h1 class="notifications-title"><i class="bi bi-bell-fill"></i> Notifications</h1>
                        <div class="header-actions">
                            <button type="button" id="mark-all-read-btn" class="btn-brand">Mark All Read</button>
                        </div>
                    </div>

                    <?php if (empty($notifications)): ?>
                        <div class="empty-state">
                            <i class="bi bi-bell-slash"></i>
                            <h3>No notifications yet</h3>
                            <p>Rental request updates, escrow events, return milestones and issue alerts will appear here.</p>
                        </div>
                    <?php else: ?>
                        <div class="notifications-list">
                            <?php foreach ($notifications as $n): ?>
                                <?php
                                    $is_unread = ((int)$n->isRead === 0);
                                    $type = (string)($n->notificationType ?? '');
                                    $action = !empty($n->actionUrl) ? $n->actionUrl : site_url('orders');

                                    $icon_class = 'request';
                                    $icon = 'bi-bell';

                                    if (in_array($type, ['rental_request_created'], true)) {
                                        $icon_class = 'request'; $icon = 'bi-cart-plus';
                                    } elseif (in_array($type, ['rental_approved'], true)) {
                                        $icon_class = 'approved'; $icon = 'bi-check-circle';
                                    } elseif (in_array($type, ['rental_rejected', 'rental_cancelled'], true)) {
                                        $icon_class = 'rejected'; $icon = 'bi-x-circle';
                                    } elseif (in_array($type, ['checkout_link_expired', 'checkout_link_expiring'], true)) {
                                        $icon_class = 'expired'; $icon = 'bi-hourglass-split';
                                    } elseif (in_array($type, ['payment_received', 'payment_released'], true)) {
                                        $icon_class = 'payment'; $icon = 'bi-cash-stack';
                                    } elseif (in_array($type, ['rental_started'], true)) {
                                        $icon_class = 'started'; $icon = 'bi-play-circle';
                                    } elseif (in_array($type, ['return_requested', 'return_confirmed'], true)) {
                                        $icon_class = 'return'; $icon = 'bi-box-seam';
                                    } elseif (in_array($type, ['issue_reported', 'issue_resolved'], true)) {
                                        $icon_class = 'issue'; $icon = 'bi-exclamation-triangle';
                                    }
                                ?>

                                <a href="<?= htmlspecialchars($action) ?>" class="notification-item<?= $is_unread ? ' is-unread' : '' ?>" data-notif-id="<?= (int)$n->notificationID ?>">
                                    <div class="notification-main">
                                        <div class="notif-icon <?= $icon_class ?>"><i class="bi <?= $icon ?>"></i></div>
                                        <div class="notif-content">
                                            <div class="notif-top">
                                                <h3 class="notif-title"><?= htmlspecialchars($n->notificationTitle) ?></h3>
                                                <?php if ($is_unread): ?>
                                                    <span class="unread-pill">NEW</span>
                                                <?php endif; ?>
                                            </div>
                                            <p class="notif-body"><?= htmlspecialchars($n->notificationBody) ?></p>
                                        </div>
                                    </div>
                                    <div class="notification-side">
                                        <time class="notif-time"><?= date('d M Y, h:i A', strtotime($n->createdAt)) ?></time>
                                        <button type="button" class="delete-btn" data-delete-id="<?= (int)$n->notificationID ?>" title="Delete notification" aria-label="Delete notification">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($total > $per_page): ?>
                            <?php $total_pages = (int)ceil($total / $per_page); ?>
                            <div class="pagination-wrap">
                                <nav class="pagination" aria-label="Notifications pagination">
                                    <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                                        <a href="<?= site_url('notifications?page=' . $p) ?>" class="page-link<?= $p === (int)$current_page ? ' active' : '' ?>"><?= $p ?></a>
                                    <?php endfor; ?>
                                </nav>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </section>
            </main>
        </div>
    </div>

    <?php $this->load->view('components/websiteFooter'); ?>

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script>
        (function () {
            var csrfName = <?= json_encode($csrf_name ?? '') ?>;
            var csrfHash = <?= json_encode($csrf_hash ?? '') ?>;

            function withCsrf(payload) {
                var data = payload || {};
                if (csrfName && csrfHash) {
                    data[csrfName] = csrfHash;
                }
                return data;
            }

            $(document).on('click', '[data-notif-id]', function (e) {
                var target = e.target;
                if (target && (target.closest('[data-delete-id]') || target.closest('.delete-btn'))) {
                    return;
                }

                var id = $(this).data('notif-id');
                if (!id) {
                    return;
                }

                $.post('<?= site_url('notifications/api_mark_read') ?>', withCsrf({ notification_id: id }));
            });

            $('#mark-all-read-btn').on('click', function () {
                $.post('<?= site_url('notifications/api_mark_all_read') ?>', withCsrf({}), function () {
                    window.location.reload();
                });
            });

            $(document).on('click', '[data-delete-id]', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var id = $(this).data('delete-id');
                if (!id) {
                    return;
                }

                var row = $(this).closest('.notification-item');
                $.post('<?= site_url('notifications/api_delete') ?>', withCsrf({ notification_id: id }), function (res) {
                    if (res && res.success) {
                        row.fadeOut(180, function () {
                            $(this).remove();
                            if ($('.notification-item').length === 0) {
                                window.location.reload();
                            }
                        });
                    }
                }, 'json');
            });
        })();
    </script>
</body>
</html>
