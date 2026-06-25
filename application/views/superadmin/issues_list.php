<?php defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('status_display');

$total_in_view = is_array($issues) ? count($issues) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Rental Issues - Equip Manager</title>
    <link rel="icon" href="<?= base_url() ?>assets/images/logo-icon.png" type="image/png" />

    <link href="<?= base_url() ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <link href="<?= base_url() ?>assets/css/pace.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/dark-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/light-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/semi-dark.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/header-colors.css" rel="stylesheet" />

    <style>
        * {
            font-family: "Manrope", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body {
            background-color: #fafafa;
        }

        .page-title-section {
            background-color: #ffffff;
            border-bottom: 1px solid #f0f0f0;
            padding: 24px 0;
            margin-bottom: 24px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .page-title-container {
            max-width: 100%;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .page-title {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #0f2f2c;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            margin: 0;
            font-size: 14px;
            color: #666;
            font-weight: 400;
        }

        .stat-card {
            padding: 8px 16px;
            background-color: #f0f9f4;
            border-radius: 8px;
            text-align: center;
        }

        .stat-number {
            font-size: 20px;
            font-weight: 700;
            color: #34ff67;
            display: block;
            line-height: 1.15;
        }

        .stat-label {
            font-size: 12px;
            color: #0f2f2c;
            font-weight: 500;
        }

        .status-filters {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
            background: linear-gradient(135deg, #f0f9f4 0%, #ffffff 100%);
            padding: 20px;
            border-radius: 12px;
            border: 2px solid #e8f5f0;
            box-shadow: 0 2px 8px rgba(52, 255, 103, 0.08);
        }

        .filter-btn {
            padding: 12px 22px;
            border: 2px solid #d0d0d0;
            background-color: #ffffff;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #666;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            text-decoration: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .filter-btn:hover {
            border-color: #34ff67;
            color: #0f2f2c;
            background-color: #e8f5f0;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(52, 255, 103, 0.15);
            transform: translateY(-2px);
        }

        .filter-btn.active {
            border-color: #34ff67;
            background: linear-gradient(135deg, #34ff67 0%, #2ae050 100%);
            color: #0f2f2c;
            box-shadow: 0 4px 12px rgba(52, 255, 103, 0.25);
            font-weight: 700;
        }

        .issues-table-card {
            background-color: #ffffff;
            border-radius: 10px;
            border: 1px solid #f0f0f0;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #f0f0f0;
            gap: 10px;
            flex-wrap: wrap;
        }

        .table-title {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: #0f2f2c;
        }

        .table-subtext {
            margin: 0;
            font-size: 12px;
            color: #7b8a82;
        }

        .issues-table {
            margin-bottom: 0;
        }

        .issues-table thead {
            background-color: #f9f9f9;
            border-bottom: 2px solid #f0f0f0;
        }

        .issues-table thead th {
            padding: 16px;
            font-weight: 700;
            font-size: 13px;
            color: #0f2f2c;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: none;
            white-space: nowrap;
        }

        .issues-table tbody td {
            padding: 16px;
            border-bottom: 1px solid #f5f5f5;
            color: #333;
            font-size: 14px;
            vertical-align: middle;
        }

        .issues-table tbody tr:hover {
            background-color: #fafafa;
        }

        .issue-id {
            font-weight: 700;
            color: #0f2f2c;
            font-size: 15px;
        }

        .order-link {
            color: #0f2f2c;
            font-weight: 700;
            text-decoration: none;
        }

        .order-link:hover {
            color: #0f2f2c;
            text-decoration: underline;
        }

        .issue-title {
            max-width: 260px;
            font-weight: 600;
            color: #1f2f2d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .reporter-name {
            font-weight: 600;
            color: #0f2f2c;
            margin-bottom: 2px;
        }

        .reporter-role {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: capitalize;
            background: #f1f4f2;
            color: #4a5a52;
        }

        .issue-type {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            background: #eef5ff;
            color: #2d4a73;
        }

        .status-pill {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
            text-transform: capitalize;
        }

        .status-reported {
            background: #ffe9db;
            color: #8a3c11;
        }

        .status-under-review {
            background: #fff3cd;
            color: #856404;
        }

        .status-resolved {
            background: #d4edda;
            color: #155724;
        }

        .status-closed {
            background: #e2e3e5;
            color: #495057;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 8px 12px;
            border: 2px solid transparent;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }

        .btn-view {
            background-color: #f0f9f4;
            color: #0f2f2c;
            border-color: #d0e8e0;
        }

        .btn-view:hover {
            background-color: #e0f5e8;
            border-color: #34ff67;
            color: #0f2f2c;
            transform: translateY(-1px);
            text-decoration: none;
        }

        .btn-chat {
            background-color: #eef1ff;
            color: #2e3f79;
            border-color: #d7def8;
        }

        .btn-chat:hover {
            background-color: #e4eaff;
            border-color: #bfc9f4;
            color: #2e3f79;
            text-decoration: none;
        }

        .btn-chat-disabled {
            background: #f6f7f8;
            color: #9ba3ad;
            border-color: #e7eaee;
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 16px;
        }

        .pagination-wrap {
            padding: 16px;
            display: flex;
            justify-content: center;
            border-top: 1px solid #f2f2f2;
        }

        .pagination .page-link {
            color: #0f2f2c;
            border: 1px solid #e1e4e8;
            border-radius: 6px;
            margin: 0 3px;
            min-width: 36px;
            text-align: center;
            font-weight: 600;
        }

        .pagination .page-item.active .page-link {
            background: #34ff67;
            border-color: #34ff67;
            color: #0f2f2c;
        }

        @media (max-width: 768px) {
            .page-title-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .status-filters {
                gap: 8px;
                padding: 14px;
            }

            .filter-btn {
                padding: 8px 14px;
                font-size: 13px;
            }

            .issues-table thead th,
            .issues-table tbody td {
                padding: 12px;
                font-size: 12px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php $this->load->view('components/header'); ?>
        <?php $this->load->view('components/sidemenu'); ?>

        <main class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Rental Issues</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin-dashboard') ?>"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Rental Issues</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="page-title-section">
                <div class="page-title-container">
                    <div>
                        <h3 class="page-title">Rental Issues</h3>
                        <p class="page-subtitle">Review reported disputes and jump directly into associated issue chats.</p>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number"><?= (int) $total ?></span>
                        <span class="stat-label">Total Issue<?= ((int) $total === 1) ? '' : 's' ?></span>
                    </div>
                </div>
            </div>

            <div class="status-filters">
                <a href="<?= site_url('superadmin/issues') ?>" class="filter-btn <?= ($filter_status === '' ? 'active' : '') ?>">
                    <i class="bi bi-list-ul"></i>
                    All Issues
                </a>
                <a href="<?= site_url('superadmin/issues?status=reported') ?>" class="filter-btn <?= ($filter_status === 'reported' ? 'active' : '') ?>">
                    <i class="bi bi-flag"></i>
                    Reported
                </a>
                <a href="<?= site_url('superadmin/issues?status=under_review') ?>" class="filter-btn <?= ($filter_status === 'under_review' ? 'active' : '') ?>">
                    <i class="bi bi-search"></i>
                    Under Review
                </a>
                <a href="<?= site_url('superadmin/issues?status=resolved') ?>" class="filter-btn <?= ($filter_status === 'resolved' ? 'active' : '') ?>">
                    <i class="bi bi-check2-circle"></i>
                    Resolved
                </a>
                <a href="<?= site_url('superadmin/issues?status=closed') ?>" class="filter-btn <?= ($filter_status === 'closed' ? 'active' : '') ?>">
                    <i class="bi bi-lock"></i>
                    Closed
                </a>
            </div>

            <div class="issues-table-card">
                <div class="table-controls">
                    <div>
                        <p class="table-title mb-0">Issue Queue</p>
                        <p class="table-subtext">Showing <?= (int) $total_in_view ?> issue<?= ((int) $total_in_view === 1) ? '' : 's' ?> on this page</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table issues-table">
                        <thead>
                            <tr>
                                <th>Issue ID</th>
                                <th>Order</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Reported By</th>
                                <th>Company</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($issues)): ?>
                                <?php foreach ($issues as $issue): ?>
                                    <?php
                                    $status_class = 'status-reported';
                                    if ($issue->issueStatus === 'under_review') {
                                        $status_class = 'status-under-review';
                                    } elseif ($issue->issueStatus === 'resolved') {
                                        $status_class = 'status-resolved';
                                    } elseif ($issue->issueStatus === 'closed') {
                                        $status_class = 'status-closed';
                                    }
                                    ?>
                                    <tr>
                                        <td class="issue-id">#<?= (int) $issue->issueID ?></td>
                                        <td>
                                            <a class="order-link" href="<?= site_url('superadmin/order_detail/'.$issue->orderID) ?>">
                                                #<?= (int) $issue->orderID ?>
                                            </a>
                                        </td>
                                        <td><span class="issue-type"><?= htmlspecialchars(get_issue_type_label($issue->issueType)) ?></span></td>
                                        <td><div class="issue-title" title="<?= htmlspecialchars($issue->issueTitle) ?>"><?= htmlspecialchars($issue->issueTitle) ?></div></td>
                                        <td>
                                            <div class="reporter-name"><?= htmlspecialchars($issue->reporterName ?? 'N/A') ?></div>
                                            <span class="reporter-role"><?= htmlspecialchars($issue->reporterType ?? 'unknown') ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($issue->companyName ?? 'N/A') ?></td>
                                        <td><?= !empty($issue->reportedAt) ? date('M d, Y', strtotime($issue->reportedAt)) : 'N/A' ?></td>
                                        <td><span class="status-pill <?= $status_class ?>"><?= htmlspecialchars(str_replace('_', ' ', $issue->issueStatus)) ?></span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="<?= site_url('superadmin/issue_detail/'.$issue->issueID) ?>" class="btn-action btn-view">
                                                    <i class="bi bi-eye"></i>
                                                    View
                                                </a>

                                                <?php if (!empty($issue->chatID)): ?>
                                                    <a href="<?= site_url('superadmin/issue-chats/view/'.$issue->chatID.'?issue_id='.$issue->issueID) ?>" class="btn-action btn-chat">
                                                        <i class="bi bi-chat-dots"></i>
                                                        Chat
                                                    </a>
                                                <?php else: ?>
                                                    <span class="btn-action btn-chat-disabled">
                                                        <i class="bi bi-chat"></i>
                                                        No Chat
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <div class="empty-state-icon"><i class="bi bi-check2-circle"></i></div>
                                            <div class="fw-bold">No issues found</div>
                                            <div class="text-muted">No disputes match the selected filter.</div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($total > $per_page): ?>
                    <div class="pagination-wrap">
                        <ul class="pagination pagination-sm mb-0">
                            <?php for ($p = 1; $p <= ceil($total / $per_page); $p++): ?>
                                <li class="page-item<?= ($p == $current_page) ? ' active' : '' ?>">
                                    <a class="page-link" href="<?= site_url('superadmin/issues?page='.$p.($filter_status ? '&status='.$filter_status : '')) ?>"><?= $p ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <div class="overlay toggle-icon"></div>
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="<?= base_url() ?>assets/js/pace.min.js"></script>
    <script src="<?= base_url() ?>assets/js/app.js"></script>
</body>
</html>
