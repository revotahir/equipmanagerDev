<?php defined('BASEPATH') or exit('No direct script access allowed');
$this->load->helper('status_display');

$status_class = 'status-reported';
if ($issue->issueStatus === 'under_review') {
    $status_class = 'status-under-review';
} elseif ($issue->issueStatus === 'resolved') {
    $status_class = 'status-resolved';
} elseif ($issue->issueStatus === 'closed') {
    $status_class = 'status-closed';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Issue Detail - Equip Manager</title>
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
            text-transform: capitalize;
        }

        .summary-chips {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            flex-wrap: wrap;
            background: linear-gradient(135deg, #f0f9f4 0%, #ffffff 100%);
            padding: 16px;
            border-radius: 12px;
            border: 2px solid #e8f5f0;
            box-shadow: 0 2px 8px rgba(52, 255, 103, 0.08);
        }

        .summary-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid #dceadf;
            font-size: 13px;
            font-weight: 600;
            color: #254235;
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

        .issue-layout {
            display: grid;
            grid-template-columns: 1.65fr 1fr;
            gap: 16px;
        }

        .section-card {
            background-color: #ffffff;
            border-radius: 10px;
            border: 1px solid #f0f0f0;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 16px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #f0f0f0;
            gap: 8px;
            flex-wrap: wrap;
        }

        .section-title {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #0f2f2c;
            font-weight: 700;
        }

        .section-body {
            padding: 16px;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .meta-box {
            border: 1px solid #edf1ef;
            background-color: #fcfdfc;
            border-radius: 8px;
            padding: 10px;
        }

        .meta-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #7a8882;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 3px;
        }

        .meta-value {
            color: #1f3b2f;
            font-size: 13px;
            font-weight: 600;
            word-break: break-word;
        }

        .meta-link {
            color: #0f2f2c;
            text-decoration: none;
            font-weight: 700;
        }

        .meta-link:hover {
            color: #0f2f2c;
            text-decoration: underline;
        }

        .body-text {
            white-space: pre-wrap;
            color: #374741;
            margin: 0;
            line-height: 1.6;
            font-size: 14px;
        }

        .resolution-bar {
            border: 1px solid #d3ead9;
            border-radius: 8px;
            background: #f4fcf6;
            padding: 10px 12px;
            margin-bottom: 10px;
        }

        .resolution-bar strong {
            color: #1a5a37;
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
            cursor: pointer;
        }

        .btn-back {
            background-color: #f0f2f4;
            color: #2d404d;
            border-color: #dde3e8;
        }

        .btn-back:hover {
            background-color: #e6ebef;
            color: #2d404d;
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

        .btn-resolve {
            background-color: #f0f9f4;
            color: #0f2f2c;
            border-color: #d0e8e0;
        }

        .btn-resolve:hover {
            background-color: #e0f5e8;
            border-color: #34ff67;
            color: #0f2f2c;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #304742;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #34ff67;
            box-shadow: 0 0 0 3px rgba(52, 255, 103, 0.1);
        }

        .assign-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .assign-row select {
            flex: 1;
        }

        @media (max-width: 991px) {
            .issue-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-title-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .meta-grid {
                grid-template-columns: 1fr;
            }

            .assign-row {
                flex-direction: column;
                align-items: stretch;
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
                <div class="breadcrumb-title pe-3">Issue Detail</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin-dashboard') ?>"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('superadmin/issues') ?>">Rental Issues</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Issue #<?= (int) $issue->issueID ?></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="page-title-section">
                <div class="page-title-container">
                    <div>
                        <h3 class="page-title">Issue #<?= (int) $issue->issueID ?></h3>
                        <p class="page-subtitle"><?= htmlspecialchars($issue->issueTitle) ?></p>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">#<?= (int) $issue->orderID ?></span>
                        <span class="stat-label">Related Order</span>
                    </div>
                </div>
            </div>

            <div class="summary-chips">
                <span class="summary-chip"><i class="bi bi-flag"></i> <?= htmlspecialchars(get_issue_type_label($issue->issueType)) ?></span>
                <span class="summary-chip"><i class="bi bi-person"></i> <?= htmlspecialchars($issue->reporterName ?? 'N/A') ?></span>
                <span class="summary-chip"><i class="bi bi-person-badge"></i> <?= htmlspecialchars($issue->reporterType ?? 'unknown') ?></span>
                <span class="summary-chip"><i class="bi bi-calendar-event"></i> <?= !empty($issue->reportedAt) ? date('M d, Y', strtotime($issue->reportedAt)) : 'N/A' ?></span>
                <span class="status-pill <?= $status_class ?>"><?= htmlspecialchars(str_replace('_', ' ', $issue->issueStatus)) ?></span>
            </div>

            <div class="action-buttons mb-3">
                <a href="<?= site_url('superadmin/issues') ?>" class="btn-action btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Back to Issues
                </a>
                <?php if (!empty($issue->chatID)): ?>
                    <a href="<?= site_url('superadmin/issue-chats/view/'.$issue->chatID.'?issue_id='.$issue->issueID) ?>" class="btn-action btn-chat">
                        <i class="bi bi-chat-dots"></i>
                        Open Dispute Chat
                    </a>
                <?php endif; ?>
            </div>

            <div class="issue-layout">
                <div>
                    <div class="section-card">
                        <div class="section-header">
                            <h4 class="section-title">Issue Overview</h4>
                        </div>
                        <div class="section-body">
                            <div class="meta-grid">
                                <div class="meta-box">
                                    <div class="meta-label">Issue Type</div>
                                    <div class="meta-value"><?= htmlspecialchars(get_issue_type_label($issue->issueType)) ?></div>
                                </div>
                                <div class="meta-box">
                                    <div class="meta-label">Reported By</div>
                                    <div class="meta-value"><?= htmlspecialchars($issue->reporterName ?? 'N/A') ?> (<?= htmlspecialchars($issue->reporterType ?? 'unknown') ?>)</div>
                                </div>
                                <div class="meta-box">
                                    <div class="meta-label">Reported At</div>
                                    <div class="meta-value"><?= !empty($issue->reportedAt) ? date('d M Y H:i', strtotime($issue->reportedAt)) : 'N/A' ?></div>
                                </div>
                                <div class="meta-box">
                                    <div class="meta-label">Order</div>
                                    <div class="meta-value"><a class="meta-link" href="<?= site_url('superadmin/order_detail/'.$issue->orderID) ?>">#<?= (int) $issue->orderID ?></a></div>
                                </div>
                                <div class="meta-box">
                                    <div class="meta-label">Item</div>
                                    <div class="meta-value"><?= htmlspecialchars($issue->itemName ?? 'N/A') ?></div>
                                </div>
                                <div class="meta-box">
                                    <div class="meta-label">Seller Company</div>
                                    <div class="meta-value"><?= htmlspecialchars($issue->sellerCompanyName ?? 'N/A') ?></div>
                                </div>
                                <div class="meta-box">
                                    <div class="meta-label">Rental Period</div>
                                    <div class="meta-value">
                                        <?= $issue->rentalStartDate ? date('d M Y', strtotime($issue->rentalStartDate)) : 'N/A' ?>
                                        to
                                        <?= $issue->rentalEndDate ? date('d M Y', strtotime($issue->rentalEndDate)) : 'N/A' ?>
                                    </div>
                                </div>
                                <div class="meta-box">
                                    <div class="meta-label">Gross Amount</div>
                                    <div class="meta-value"><?= $issue->grossAmount ? number_format($issue->grossAmount, 2).' $' : 'N/A' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-card">
                        <div class="section-header">
                            <h4 class="section-title">Issue Description</h4>
                        </div>
                        <div class="section-body">
                            <p class="body-text"><?= htmlspecialchars($issue->issueDescription) ?></p>
                        </div>
                    </div>

                    <?php if ($issue->issueStatus === 'resolved'): ?>
                        <div class="section-card">
                            <div class="section-header">
                                <h4 class="section-title">Resolution Summary</h4>
                            </div>
                            <div class="section-body">
                                <div class="resolution-bar">
                                    <strong><?= ucwords(str_replace('_', ' ', $issue->resolutionOutcome ?? '')) ?></strong><br>
                                    <span>Resolved by <?= htmlspecialchars($issue->resolvedByName ?? 'N/A') ?> at <?= $issue->resolvedAt ? date('d M Y H:i', strtotime($issue->resolvedAt)) : 'N/A' ?></span>
                                </div>

                                <?php if (!empty($issue->refundAmount)): ?>
                                    <p class="mb-2"><strong>Refund Amount:</strong> <?= number_format($issue->refundAmount, 2) ?> $</p>
                                <?php endif; ?>

                                <p class="mb-0"><strong>Notes:</strong><br><?= nl2br(htmlspecialchars($issue->resolutionNotes ?? 'N/A')) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div>
                    <?php if (in_array($issue->issueStatus, ['reported', 'under_review'])): ?>
                        <div class="section-card">
                            <div class="section-header">
                                <h4 class="section-title">Resolve Issue</h4>
                            </div>
                            <div class="section-body">
                                <form id="resolve-issue-form">
                                    <input type="hidden" name="issue_id" value="<?= (int) $issue->issueID ?>">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                                    <div class="form-group mb-3">
                                        <label class="form-label">Outcome <span class="text-danger">*</span></label>
                                        <select name="outcome" class="form-control" required>
                                            <option value="">Select outcome</option>
                                            <option value="no_action">No Action Required</option>
                                            <option value="refund_partial">Partial Refund to Renter</option>
                                            <option value="refund_full">Full Refund to Renter</option>
                                            <option value="compensation">Compensation to Owner</option>
                                            <option value="insurance_claim">Insurance Claim Filed</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3" id="refund-amount-group" style="display:none;">
                                        <label class="form-label">Refund Amount ($)</label>
                                        <input
                                            type="number"
                                            name="refund_amount"
                                            class="form-control"
                                            step="0.01"
                                            min="0"
                                            max="<?= $issue->grossAmount ?? 999999 ?>"
                                            placeholder="e.g. 750.00"
                                        >
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Resolution Notes <span class="text-danger">*</span></label>
                                        <textarea
                                            name="notes"
                                            class="form-control"
                                            rows="5"
                                            required
                                            placeholder="Describe the final decision and reasoning"
                                        ></textarea>
                                    </div>

                                    <button type="submit" class="btn-action btn-resolve" id="resolve-btn">
                                        <i class="bi bi-check2-circle"></i>
                                        Resolve Issue
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-header">
                                <h4 class="section-title">Assign To Admin</h4>
                            </div>
                            <div class="section-body">
                                <form id="assign-admin-form">
                                    <input type="hidden" name="issue_id" value="<?= (int) $issue->issueID ?>">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                                    <div class="assign-row">
                                        <select name="admin_id" class="form-control">
                                            <?php foreach ($admins as $admin): ?>
                                                <option value="<?= (int) $admin->userID ?>" <?= ($issue->assignedToAdmin == $admin->userID) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($admin->userName) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn-action btn-resolve">
                                            <i class="bi bi-person-check"></i>
                                            Assign
                                        </button>
                                    </div>
                                </form>

                                <?php if ($issue->assignedAdminName): ?>
                                    <p class="text-muted mt-2 mb-0" style="font-size:12px;">
                                        Currently assigned to: <strong><?= htmlspecialchars($issue->assignedAdminName) ?></strong>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
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

    <script>
        $('[name="outcome"]').on('change', function() {
            var v = $(this).val();
            $('#refund-amount-group').toggle(v === 'refund_partial' || v === 'refund_full');
        });

        $('#resolve-issue-form').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#resolve-btn').prop('disabled', true).text('Resolving...');
            $.post('<?= site_url("superadmin/api_resolve_issue") ?>', $(this).serialize(), function(res) {
                if (res.success) {
                    location.reload();
                } else {
                    AppToast.error(res.message || 'Failed to resolve issue');
                    btn.prop('disabled', false).html('<i class="bi bi-check2-circle"></i> Resolve Issue');
                }
            }, 'json');
        });

        $('#assign-admin-form').on('submit', function(e) {
            e.preventDefault();
            $.post('<?= site_url("superadmin/api_assign_issue") ?>', $(this).serialize(), function(res) {
                if (res.success) {
                    AppToast.success('Admin assigned');
                } else {
                    AppToast.error(res.message || 'Failed to assign');
                }
            }, 'json');
        });
    </script>
</body>
</html>
