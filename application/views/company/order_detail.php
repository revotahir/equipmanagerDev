<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Details - Equip Manager</title>
    <link rel="icon" href="<?= base_url() ?>assets/images/logo-icon.png" type="image/png" />
    
    <!-- Stylesheets -->
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
            font-family: "Manrope", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        /* Breadcrumb Navigation */
        .page-breadcrumb {
            padding: 0 0 12px 0;
        }

        .page-breadcrumb .breadcrumb {
            background-color: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            color: #34FF67;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item a:hover {
            color: #2ae050;
            text-decoration: underline;
        }

        /* Page Title Section */
        .page-title-section {
            background-color: transparent;
            border-bottom: none;
            padding: 24px 0 16px 0;
            margin-bottom: 24px;
        }

        .page-title-container {
            max-width: 100%;
            padding: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #0f2f2c;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            margin: 4px 0 0 0;
            font-size: 13px;
            color: #999;
            font-weight: 400;
        }

        /* Order Detail Card Styles */
        .order-detail-card {
            background-color: #ffffff;
            border-radius: 8px;
            border: 1px solid #efefef;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }

        .order-detail-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .card-header-custom {
            background: linear-gradient(135deg, #f9f9f9 0%, #f5f5f5 100%);
            border-bottom: 1px solid #efefef;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title-custom {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: #0f2f2c;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .card-body-custom {
            padding: 20px;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            font-size: 12px;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.2px;
        }

        .info-value {
            color: #0f2f2c;
            font-size: 14px;
            margin-bottom: 16px;
            font-weight: 500;
        }

        .status-badge {
            font-size: 11px;
            padding: 8px 14px;
            border-radius: 6px;
            font-weight: 700;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-payment {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .badge-secured {
            background-color: #d1e7f5;
            color: #004085;
        }

        .badge-shipped {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Timeline Styles */
        .timeline-item {
            padding-bottom: 20px;
            border-left: 3px solid #f0f0f0;
            padding-left: 20px;
            position: relative;
        }

        .timeline-item:last-child {
            border-left: 3px solid transparent;
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #34FF67;
            border: 2px solid white;
        }

        /* Action Buttons */
        .btn-action-custom {
            padding: 11px 20px;
            border: 2px solid transparent;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-family: "Manrope", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            min-width: 140px;
            text-align: center;
        }

        .btn-success-custom {
            background-color: #34FF67;
            color: #0f2f2c;
            border: 2px solid #2ae050;
        }

        .btn-success-custom:hover {
            background-color: #2ae050;
            border-color: #1fb83f;
            box-shadow: 0 4px 12px rgba(52, 255, 103, 0.25);
            transform: translateY(-2px);
        }

        .btn-danger-custom {
            background-color: #ff4757;
            color: #ffffff;
            border: 2px solid #ff3838;
        }

        .btn-danger-custom:hover {
            background-color: #ff3839;
            border-color: #ff1d1d;
            box-shadow: 0 4px 12px rgba(255, 71, 87, 0.25);
            transform: translateY(-2px);
        }

        .btn-secondary-custom {
            background-color: #f0f0f0;
            color: #0f2f2c;
            border: 2px solid #ddd;
            width: 100%;
        }

        .btn-secondary-custom:hover {
            background-color: #e8e8e8;
            border-color: #34FF67;
            box-shadow: 0 4px 12px rgba(52, 255, 103, 0.1);
            transform: translateY(-2px);
        }
        .star-display { color:#f59e0b; letter-spacing:1px; font-size:16px; font-weight:700; }
        .star-picker { display:flex; align-items:center; gap:6px; }
        .star-picker-btn { background:none; border:none; font-size:24px; line-height:1; color:#d1d5db; cursor:pointer; padding:0 2px; }
        .star-picker-btn.is-active { color:#f59e0b; }
        .star-picker-text { font-size:12px; color:#6b7280; margin-left:4px; }

        .btn-primary-custom {
            background-color: #34FF67;
            color: #0f2f2c;
            border: 2px solid #2ae050;
            width: 100%;
        }

        .btn-primary-custom:hover {
            background-color: #2ae050;
            border-color: #1fb83f;
            box-shadow: 0 4px 12px rgba(52, 255, 103, 0.25);
            transform: translateY(-2px);
        }

        /* Equipment Image */
        .equipment-image {
            max-height: 280px;
            width: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #efefef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Rejection Alert */
        .rejection-alert {
            background-color: #fef0f0;
            border: 1px solid #f0d0d0;
            border-radius: 8px;
            padding: 14px 16px;
            color: #721c24;
            margin-top: 12px;
            font-size: 13px;
            line-height: 1.5;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .action-buttons form {
            display: block;
            margin-bottom: 0;
        }

        .action-buttons button,
        .action-buttons form button {
            width: 100%;
        }

        .back-nav-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background-color: #f0f9f4;
            color: #0f2f2c;
            border: 2px solid #d0e8e0;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .back-nav-button:hover {
            background-color: #e0f5e8;
            border-color: #34FF67;
            box-shadow: 0 4px 12px rgba(52, 255, 103, 0.15);
            transform: translateY(-2px);
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 8px;
            border: 1px solid #efefef;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid #efefef;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .modal-title {
            color: #0f2f2c;
            font-weight: 700;
            font-size: 16px;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: 1px solid #efefef;
            padding: 16px 20px;
            background-color: #f9f9f9;
        }

        .modal-footer .btn {
            font-weight: 600;
            font-size: 13px;
            border-radius: 6px;
            padding: 10px 20px;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 10px 12px;
            font-family: "Manrope", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .form-control:focus {
            border-color: #34FF67;
            box-shadow: 0 0 0 3px rgba(52, 255, 103, 0.1);
        }

        .form-label {
            color: #0f2f2c;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.2px;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 22px;
            }

            .page-title-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .card-body-custom {
                padding: 16px;
            }

            .card-header-custom {
                padding: 14px 16px;
            }

            .card-title-custom {
                font-size: 13px;
            }

            .btn-action-custom {
                padding: 9px 14px;
                font-size: 12px;
            }

            .info-label {
                font-size: 11px;
            }

            .info-value {
                font-size: 13px;
            }

            .row {
                margin-bottom: 12px;
            }

            .col-md-6 {
                margin-bottom: 12px;
            }
        }
    </style>
</head>

<body>
    <!--start wrapper-->
    <div class="wrapper">
        <?php $this->load->view('components/header'); ?>
        <?php $this->load->view('components/sidemenu'); ?>

        <!--start content-->
        <main class="page-content">

            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Order Details</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin-dashboard') ?>"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('company-orders') ?>">Orders</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order #<?= $order['orderID'] ?></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <?php
                $is_workforce_order_view = !empty($order['workforcePaymentID']) || (($order['orderType'] ?? '') === 'workforce');
                $item_label = $is_workforce_order_view ? 'Workforce' : 'Equipment';
                $item_name = $is_workforce_order_view
                    ? ($order['workforceName'] ?? $order['itemName'] ?? 'Workforce')
                    : ($order['equipmentName'] ?? $order['itemName'] ?? 'Equipment');
                $item_id_value = $is_workforce_order_view
                    ? ($order['workforceID'] ?? null)
                    : ($order['equipmentID'] ?? null);
                $rental_type_value = strtolower((string)($order['rentalType'] ?? ''));
                $rental_type_label_map = [
                    '1' => 'Daily',
                    '2' => 'Weekly',
                    '3' => 'Monthly',
                    '4' => 'Yearly',
                    'daily' => 'Daily',
                    'weekly' => 'Weekly',
                    'monthly' => 'Monthly',
                    'yearly' => 'Yearly'
                ];
                $rental_type_label = $rental_type_label_map[$rental_type_value] ?? (!empty($order['rentalType']) ? ucfirst((string)$order['rentalType']) : 'N/A');
                $sale_type_value = strtolower((string)($order['saleType'] ?? ''));
                if ($sale_type_value === 'rental') {
                    $sale_type_display = 'Rental' . ($rental_type_label !== 'N/A' ? ' (' . $rental_type_label . ')' : '');
                } elseif ($sale_type_value === 'purchase') {
                    $sale_type_display = 'Purchase';
                } else {
                    $sale_type_display = !empty($order['saleType']) ? ucfirst((string)$order['saleType']) : 'N/A';
                }
            ?>

            <div class="row">
                <div class="col-lg-8">
                    <div class="order-detail-card">
                        <div class="card-header-custom">
                            <h3 class="card-title-custom">Order Information</h3>
                            <?php
                                $status_class = '';
                                $status_text = '';
                                $is_workforce_for_badge = !empty($order['workforcePaymentID']);
                                $is_equipment_rental_for_badge = !$is_workforce_for_badge && strtolower((string)($order['saleType'] ?? '')) === 'rental';
                                $is_rental_for_badge = $is_workforce_for_badge || $is_equipment_rental_for_badge;
                                $display_status = $is_rental_for_badge && !empty($order['rentalRequestStatus'])
                                    ? $order['rentalRequestStatus']
                                    : ($order['orderStatus'] ?? 'requested');

                                $_meta_raw = $order['paymentMetadata'] ?? ($order['metadata'] ?? '{}');
                                if (is_array($_meta_raw)) {
                                    $_meta = $_meta_raw;
                                } else {
                                    $_meta = json_decode((string) $_meta_raw, true);
                                    $_meta = is_array($_meta) ? $_meta : [];
                                }
                                $_delivery_fee = floatval($_meta['delivery_amount'] ?? 0);
                                $_delivery_method = intval($_meta['delivery_method'] ?? 0);
                                if ($_delivery_method !== 1 && $_delivery_method !== 2) {
                                    $_delivery_method = $_delivery_fee > 0 ? 2 : 1;
                                }
                                $_is_delivery = ($_delivery_method === 2);
                                $_is_pickup = ($_delivery_method === 1);

                                switch ($display_status) {
                                    case 'requested':
                                    case 'request_pending':
                                        $status_class = 'badge-pending';
                                        $status_text = 'Pending Approval';
                                        break;
                                    case 'payment_pending':
                                        $status_class = 'badge-payment';
                                        $status_text = 'Awaiting Payment';
                                        break;
                                    case 'request_approved':
                                        $status_class = 'badge-secured';
                                        $status_text = 'Request Approved';
                                        break;
                                    case 'awaiting_handover':
                                        $status_class = 'badge-secured';
                                        $status_text = 'Awaiting Handover';
                                        break;
                                    case 'payment_secured':
                                        $status_class = 'badge-secured';
                                        $status_text = 'Payment Secured';
                                        break;
                                    case 'shipped':
                                        $status_class = 'badge-shipped';
                                        $status_text = 'Shipped';
                                        break;
                                    case 'delivered':
                                        $status_class = 'badge-shipped';
                                        $status_text = 'Delivered';
                                        break;
                                    case 'pickup_ready':
                                        $status_class = 'badge-secured';
                                        $status_text = 'Ready for Pickup';
                                        break;
                                    case 'rental_active':
                                        $status_class = 'badge-completed';
                                        $status_text = 'Rental Period Started';
                                        break;
                                    case 'return_requested':
                                        $status_class = 'badge-payment';
                                        $status_text = 'Pending Return (72h)';
                                        break;
                                    case 'rental_overdue':
                                        $status_class = 'badge-rejected';
                                        $status_text = 'Return Overdue';
                                        break;
                                    case 'returned_by_renter':
                                        $status_class = 'badge-secured';
                                        $status_text = 'Awaiting Return Confirmation';
                                        break;
                                    case 'received_by_owner':
                                        $status_class = 'badge-secured';
                                        $status_text = 'Received By Owner';
                                        break;
                                    case 'completed':
                                    case 'rental_completed':
                                        $status_class = 'badge-completed';
                                        $status_text = 'Completed';
                                        break;
                                    case 'rejected':
                                    case 'request_rejected':
                                        $status_class = 'badge-rejected';
                                        $status_text = 'Rejected';
                                        break;
                                    case 'cancelled':
                                    case 'rental_cancelled':
                                        $status_class = 'badge-rejected';
                                        $status_text = 'Cancelled';
                                        break;
                                    case 'under_review':
                                        $status_class = 'badge-pending';
                                        $status_text = 'Under Review';
                                        break;
                                    default:
                                        $status_class = 'badge-payment';
                                        $status_text = ucwords(str_replace('_', ' ', $display_status));
                                }
                                ?>
                            <span class="status-badge <?= $status_class ?>"><?= $status_text ?></span>
                        </div>
                        <div class="card-body-custom">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="info-label">Order ID</div>
                                        <div class="info-value"><strong>#<?= $order['orderID'] ?></strong></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Order Date</div>
                                        <div class="info-value"><?= date('M d, Y h:i A', strtotime($order['createdAt'])) ?></div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="info-label"><?= $item_label ?></div>
                                        <div class="info-value"><strong><?= htmlspecialchars((string)$item_name) ?></strong></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Quantity</div>
                                        <div class="info-value"><?= intval($order['quantity'] ?? 0) ?> unit(s)</div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="info-label">Sale Type</div>
                                        <div class="info-value"><?= htmlspecialchars($sale_type_display) ?></div>
                                    </div>
                                    <?php if (!empty($order['saleType']) && $order['saleType'] === 'rental') { ?>
                                        <div class="col-md-6">
                                            <div class="info-label">Rental Period</div>
                                            <div class="info-value">
                                                <?= !empty($order['rentalStartDate']) ? date('M d, Y', strtotime($order['rentalStartDate'])) : 'N/A' ?> to 
                                                <?= !empty($order['rentalEndDate']) ? date('M d, Y', strtotime($order['rentalEndDate'])) : 'N/A' ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <hr style="margin: 20px 0;">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="info-label">Gross Amount</div>
                                        <div class="info-value"><strong>$<?= !empty($order['grossAmount']) ? number_format($order['grossAmount'], 2) : '0.00' ?></strong></div>
                                    </div>
                                    <?php if ($_delivery_fee > 0): ?>
                                    <div class="col-md-6">
                                        <div class="info-label">Delivery Fee</div>
                                        <div class="info-value">$<?= number_format($_delivery_fee, 2) ?></div>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="info-label">Commission (<?= !empty($order['commissionPercent']) ? $order['commissionPercent'] : '0' ?>%)</div>
                                        <div class="info-value" style="color: #ff6b6b;">-$<?= !empty($order['commissionAmount']) ? number_format($order['commissionAmount'], 2) : '0.00' ?></div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="info-label">Net Amount (Your Earnings)</div>
                                        <div class="info-value" style="color: #34FF67; font-weight: 700; font-size: 16px;">$<?= !empty($order['netAmount']) ? number_format($order['netAmount'], 2) : '0.00' ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Payment Status</div>
                                        <div class="info-value">
                                            <?php
                                            $payment_badge = '';
                                            switch ($order['paymentStatus']) {
                                                case 'pending':
                                                    $payment_badge = '<span class="badge-pending status-badge">Pending Payment</span>';
                                                    break;
                                                case 'completed':
                                                    $payment_badge = '<span class="badge-completed status-badge">Paid to ' . htmlspecialchars($order['sellerCompanyName'] ?? 'Your Company') . '</span>';
                                                    break;
                                                case 'failed':
                                                    $payment_badge = '<span class="badge-rejected status-badge">Failed</span>';
                                                    break;
                                                case 'refunded':
                                                    $payment_badge = '<span class="badge-payment status-badge">Refunded</span>';
                                                    break;
                                            }
                                            echo $payment_badge;
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if (!empty($order['rejectionReason'])) { ?>
                                    <hr style="margin: 20px 0;">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="info-label">Rejection Reason</div>
                                            <div class="rejection-alert">
                                                <?= nl2br(htmlspecialchars($order['rejectionReason'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- Delivery / Pickup Details -->
                                <?php if ($_is_delivery): ?>
                                    <hr style="margin: 20px 0;">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="info-label">Fulfillment Method</div>
                                            <div class="info-value">
                                                <span class="status-badge badge-payment"><i class="bi bi-truck"></i>&nbsp;Delivery</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (!empty($_meta['delivery_name'])): ?>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="info-label">Recipient Name</div>
                                            <div class="info-value"><?= htmlspecialchars($_meta['delivery_name']) ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-label">Phone</div>
                                            <div class="info-value"><?= htmlspecialchars($_meta['customer_phone'] ?? '-') ?></div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($_meta['delivery_street'])): ?>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="info-label">Street Address</div>
                                            <div class="info-value"><?= htmlspecialchars($_meta['delivery_street']) ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-label">City / Postal Code</div>
                                            <div class="info-value"><?= htmlspecialchars($_meta['delivery_city'] ?? '') ?><?= !empty($_meta['delivery_postal']) ? ' &mdash; ' . htmlspecialchars($_meta['delivery_postal']) : '' ?></div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($_meta['delivery_country'])): ?>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="info-label">Country</div>
                                            <div class="info-value"><?= htmlspecialchars($_meta['delivery_country']) ?></div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($_meta['delivery_notes'])): ?>
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <div class="info-label">Delivery Notes</div>
                                            <div class="info-value"><?= nl2br(htmlspecialchars($_meta['delivery_notes'])) ?></div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php elseif ($_is_pickup): ?>
                                    <hr style="margin: 20px 0;">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="info-label">Fulfillment Method</div>
                                            <div class="info-value">
                                                <span class="status-badge badge-pending"><i class="bi bi-building"></i>&nbsp;Pickup at Store</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        $_pickup_name = $_meta['customer_name'] ?? ($_meta['delivery_name'] ?? null);
                                        $_pickup_phone = $_meta['customer_phone'] ?? null;
                                        $_pickup_email = $_meta['customer_email'] ?? null;
                                    ?>
                                    <?php if ($_pickup_name || $_pickup_phone): ?>
                                    <div class="row mb-3">
                                        <?php if ($_pickup_name): ?>
                                        <div class="col-md-6">
                                            <div class="info-label">Buyer Name</div>
                                            <div class="info-value"><?= htmlspecialchars($_pickup_name) ?></div>
                                        </div>
                                        <?php endif; ?>
                                        <?php if ($_pickup_phone): ?>
                                        <div class="col-md-6">
                                            <div class="info-label">Buyer Phone</div>
                                            <div class="info-value"><?= htmlspecialchars($_pickup_phone) ?></div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($_pickup_email): ?>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <div class="info-label">Buyer Email</div>
                                            <div class="info-value"><?= htmlspecialchars($_pickup_email) ?></div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php
                            $review_context = isset($review_context) && is_array($review_context) ? $review_context : [];
                            $order_reviews = isset($order_reviews) && is_array($order_reviews) ? $order_reviews : [];
                            $my_review = isset($my_review) ? $my_review : null;
                            $current_user_id = (int)($this->session->userdata('loginData')['userID'] ?? 0);
                        ?>
                        <div class="order-detail-card">
                            <div class="card-header-custom">
                                <h3 class="card-title-custom">Reviews</h3>
                            </div>
                            <div class="card-body-custom">
                                <?php if (!empty($review_context['allowed']) && empty($my_review)) : ?>
                                <form method="post" action="<?= base_url('reviews/submit') ?>" enctype="multipart/form-data">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                    <input type="hidden" name="order_id" value="<?= (int)$order['orderID'] ?>">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <input type="hidden" name="rating" value="" required>
                                            <div class="star-picker" data-star-picker>
                                                <button type="button" class="star-picker-btn" data-value="1" aria-label="1 star">★</button>
                                                <button type="button" class="star-picker-btn" data-value="2" aria-label="2 stars">★</button>
                                                <button type="button" class="star-picker-btn" data-value="3" aria-label="3 stars">★</button>
                                                <button type="button" class="star-picker-btn" data-value="4" aria-label="4 stars">★</button>
                                                <button type="button" class="star-picker-btn" data-value="5" aria-label="5 stars">★</button>
                                                <span class="star-picker-text">Click to rate</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4"><input class="form-control" type="text" name="tags[]" placeholder="Tag e.g. Great communication"></div>
                                        <div class="col-md-4"><input class="form-control" type="file" name="review_media[]" multiple accept="image/*"></div>
                                    </div>
                                    <textarea class="form-control mt-2" name="review_text" maxlength="500" rows="3" placeholder="Write your review (optional)"></textarea>
                                    <button class="btn btn-success mt-2" type="submit">Submit Review</button>
                                </form>
                                <?php elseif (!empty($my_review)) : ?>
                                <p class="text-muted mb-2">You have already submitted a review for this order.</p>
                                <?php elseif (!empty($review_context['reason'])) : ?>
                                <p class="text-muted mb-2"><?= html_escape($review_context['reason']) ?></p>
                                <?php else : ?>
                                <p class="text-muted mb-2">Review status unavailable for this order right now.</p>
                                <?php endif; ?>
                                <?php if (!empty($order_reviews)) : foreach ($order_reviews as $rv) : ?>
                                <div class="border-top pt-2 mt-2">
                                    <?php $r = max(1, min(5, (int)$rv->rating)); $stars = str_repeat('★', $r) . str_repeat('☆', 5 - $r); ?>
                                    <strong><?= html_escape($rv->reviewerName ?: 'User') ?></strong>
                                    <span class="star-display"><?= $stars ?></span>
                                    <div><?= nl2br(html_escape((string)($rv->reviewText ?? ''))) ?></div>
                                    <?php if ((int)($rv->reviewerID ?? 0) === $current_user_id): ?>
                                    <div class="d-flex gap-2 flex-wrap mt-2">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleEditReviewForm('review-edit-<?= (int)$rv->reviewID ?>')">Edit</button>
                                        <form method="post" action="<?= base_url('reviews/delete/' . (int)$rv->reviewID) ?>" style="display:inline;">
                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this review?');">Delete</button>
                                        </form>
                                    </div>
                                    <form id="review-edit-<?= (int)$rv->reviewID ?>" method="post" action="<?= base_url('reviews/update/' . (int)$rv->reviewID) ?>" style="display:none;" class="mt-2" enctype="multipart/form-data">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <input type="hidden" name="rating" value="<?= (int)$rv->rating ?>" required>
                                                <div class="star-picker" data-star-picker data-current-rating="<?= (int)$rv->rating ?>">
                                                    <button type="button" class="star-picker-btn" data-value="1" aria-label="1 star">★</button>
                                                    <button type="button" class="star-picker-btn" data-value="2" aria-label="2 stars">★</button>
                                                    <button type="button" class="star-picker-btn" data-value="3" aria-label="3 stars">★</button>
                                                    <button type="button" class="star-picker-btn" data-value="4" aria-label="4 stars">★</button>
                                                    <button type="button" class="star-picker-btn" data-value="5" aria-label="5 stars">★</button>
                                                    <span class="star-picker-text">Click to rate</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4"><input class="form-control" type="text" name="tags[]" placeholder="Tag e.g. Great communication"></div>
                                            <div class="col-md-4"><input class="form-control" type="file" name="review_media[]" multiple accept="image/*"></div>
                                        </div>
                                        <textarea class="form-control mt-2" name="review_text" maxlength="500" rows="3" placeholder="Write your review (optional)"><?= html_escape($rv->reviewText) ?></textarea>
                                        <button type="submit" class="btn btn-success btn-sm mt-2">Save</button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>

                        <!-- Item Details Card -->
                        <div class="order-detail-card">
                            <div class="card-header-custom">
                                <h3 class="card-title-custom"><?= $item_label ?> Details</h3>
                            </div>
                            <div class="card-body-custom">
                                <?php
                                $adminImages = isset($images) ? array_values(array_filter($images)) : [];
                                if (!empty($adminImages)):
                                ?>
                                <div class="mb-4" style="position:relative;">
                                    <!-- Main image -->
                                    <div id="adminGalleryMain" style="width:100%;height:260px;border-radius:8px;overflow:hidden;background:#f5f5f5;display:flex;align-items:center;justify-content:center;position:relative;border:1px solid #efefef;">
                                        <img id="adminMainImg"
                                             src="<?= base_url($adminImages[0]) ?>"
                                             alt="<?= htmlspecialchars((string)$item_name) ?>"
                                             style="width:100%;height:100%;object-fit:cover;"
                                             onerror="this.src='<?= base_url('assets/website/images/brand-logo-2.png') ?>'">
                                        <?php if (count($adminImages) > 1): ?>
                                        <button onclick="adminGalleryNav(-1)" style="position:absolute;left:8px;top:50%;transform:translateY(-50%);width:32px;height:32px;background:rgba(255,255,255,.9);border:none;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;color:#0f2f2c;z-index:5;">&#8249;</button>
                                        <button onclick="adminGalleryNav(1)"  style="position:absolute;right:8px;top:50%;transform:translateY(-50%);width:32px;height:32px;background:rgba(255,255,255,.9);border:none;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;color:#0f2f2c;z-index:5;">&#8250;</button>
                                        <span id="adminGalleryCounter" style="position:absolute;bottom:8px;right:10px;background:rgba(0,0,0,.55);color:#fff;font-size:11px;font-weight:600;padding:3px 8px;border-radius:12px;">1 / <?= count($adminImages) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (count($adminImages) > 1): ?>
                                    <!-- Thumbnails -->
                                    <div id="adminThumbRow" style="display:flex;gap:6px;overflow-x:auto;padding:8px 0 4px;scrollbar-width:thin;">
                                        <?php foreach ($adminImages as $idx => $img): ?>
                                        <div onclick="adminGallerySet(<?= $idx ?>)"
                                             class="admin-thumb <?= $idx === 0 ? 'admin-thumb-active' : '' ?>"
                                             style="flex-shrink:0;width:56px;height:56px;border-radius:6px;border:2px solid <?= $idx === 0 ? '#34FF67' : '#ddd' ?>;overflow:hidden;cursor:pointer;transition:border-color .2s;"
                                             id="adminThumb<?= $idx ?>">
                                            <img src="<?= base_url($img) ?>"
                                                 style="width:100%;height:100%;object-fit:cover;"
                                                 onerror="this.src='<?= base_url('assets/website/images/brand-logo-2.png') ?>'">
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label"><?= $item_label ?> ID</div>
                                        <div class="info-value"><?= $item_id_value ? ('#' . intval($item_id_value)) : 'N/A' ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label"><?= $is_workforce_order_view ? 'Availability Window' : 'Total Available' ?></div>
                                        <div class="info-value">
                                            <?php if ($is_workforce_order_view): ?>
                                                <?php if (!empty($order['workforceAvailableStart']) || !empty($order['workforceAvailableEnd'])): ?>
                                                    <?= !empty($order['workforceAvailableStart']) ? date('M d, Y', strtotime($order['workforceAvailableStart'])) : 'N/A' ?> to
                                                    <?= !empty($order['workforceAvailableEnd']) ? date('M d, Y', strtotime($order['workforceAvailableEnd'])) : 'N/A' ?>
                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?= intval($order['equipTotalQuantity'] ?? 0) ?> unit(s)
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buyer Information & Actions -->
                    <div class="col-lg-4">
                        <!-- Buyer Details Card -->
                        <div class="order-detail-card">
                            <div class="card-header-custom">
                                <h3 class="card-title-custom">Buyer Information</h3>
                            </div>
                            <div class="card-body-custom">
                                <div class="mb-4">
                                    <div class="info-label">Name</div>
                                    <div class="info-value"><?= htmlspecialchars((string)($order['buyerName'] ?? 'N/A')) ?></div>
                                </div>
                                <div class="mb-4">
                                    <div class="info-label">Account Email</div>
                                    <div class="info-value"><?= htmlspecialchars((string)($order['buyerEmail'] ?? 'N/A')) ?></div>
                                </div>
                                <div class="mb-4">
                                    <div class="info-label">Billing Email</div>
                                    <div class="info-value"><?= htmlspecialchars($_meta['customer_email'] ?? 'N/A') ?></div>
                                </div>
                                <?php if (!empty($order['chatID'])) { ?>
                                    <button type="button" class="btn-action-custom btn-primary-custom" onclick="window.location.href='<?= base_url('chat/' . $order['orderID']) ?>'">
                                        <i class="bi bi-chat-dots"></i> Open Chat
                                    </button>
                                <?php } ?>
                                <?php if (!empty($can_download_invoice)) { ?>
                                    <a href="<?= base_url('company-orders/invoice/' . intval($order['orderID'])) ?>" class="btn-action-custom btn-secondary-custom" style="margin-top:12px; text-decoration:none;">
                                        <i class="bi bi-file-earmark-arrow-down"></i> Download Invoice (PDF)
                                    </a>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Actions Card -->
                        <?php if ($order['orderStatus'] === 'requested') { ?>
                            <div class="order-detail-card">
                                <div class="card-header-custom">
                                    <h3 class="card-title-custom">Actions</h3>
                                </div>
                                <div class="card-body-custom">
                                    <div class="action-buttons">
                                        <form method="POST" action="<?= base_url('company-orders/accept') ?>">
                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                            <input type="hidden" name="order_id" value="<?= $order['orderID'] ?>">
                                            <button type="submit" class="btn-action-custom btn-success-custom" onclick="return AppDialog.confirmAction(event, this, 'Are you sure you want to approve this purchase request?');">
                                                <i class="bi bi-check-circle"></i> Approve Request
                                            </button>
                                        </form>

                                        <button type="button" class="btn-action-custom btn-danger-custom" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                            <i class="bi bi-x-circle"></i> Reject Request
                                        </button>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="border-radius: 8px; border: 1px solid #efefef; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                                    <form method="POST" action="<?= base_url('company-orders/reject') ?>">
                                                        <div class="modal-header" style="border-bottom: 1px solid #efefef; padding: 20px; background-color: #f9f9f9;">
                                                            <h5 class="modal-title" style="color: #0f2f2c; font-weight: 700; font-size: 16px;">Reject Purchase Request</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body" style="padding: 20px;">
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                                            <input type="hidden" name="order_id" value="<?= $order['orderID'] ?>">
                                                            <div class="mb-3">
                                                                <label for="rejection_reason" class="form-label" style="color: #0f2f2c; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.2px;">Reason for Rejection</label>
                                                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" placeholder="Please provide a reason..." style="border-radius: 6px; border: 1px solid #ddd; padding: 10px 12px; font-family: Manrope, sans-serif;"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer" style="border-top: 1px solid #efefef; padding: 16px; background-color: #f9f9f9;">
                                                            <button type="button" class="btn" data-bs-dismiss="modal" style="color: #0f2f2c; background-color: #f0f0f0; border-radius: 6px; padding: 10px 20px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s ease;">Cancel</button>
                                                            <button type="submit" class="btn" style="background-color: #ff4757; color: white; border-radius: 6px; padding: 10px 20px; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s ease;">Reject Request</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Actions Card: payment_secured (Ship or Allow Pickup) -->
                        <?php if ($order['orderStatus'] === 'payment_secured'): ?>
                            <div class="order-detail-card">
                                <div class="card-header-custom">
                                    <h3 class="card-title-custom">Actions</h3>
                                </div>
                                <div class="card-body-custom">
                                    <?php if ($_is_delivery): ?>
                                        <p style="color:#666; font-size:13px; margin-bottom:16px;">Payment secured. Mark this order as shipped once dispatched.</p>
                                        <button type="button" class="btn-action-custom btn-success-custom" data-bs-toggle="modal" data-bs-target="#shippingModal">
                                            <i class="bi bi-truck"></i> Mark as Shipped
                                        </button>
                                        <!-- Shipping Modal -->
                                        <div class="modal fade" id="shippingModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="border-radius:8px;border:1px solid #efefef;box-shadow:0 4px 12px rgba(0,0,0,.1);">
                                                    <form method="POST" action="<?= base_url('company-orders/mark_shipped') ?>">
                                                        <div class="modal-header" style="border-bottom:1px solid #efefef;padding:20px;background:#f9f9f9;">
                                                            <h5 class="modal-title" style="color:#0f2f2c;font-weight:700;font-size:16px;">Mark Order as Shipped</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body" style="padding:20px;">
                                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                                            <input type="hidden" name="order_id" value="<?= $order['orderID'] ?>">
                                                            <div class="mb-3">
                                                                <label class="form-label">Tracking Number <small style="color:#999">(optional)</small></label>
                                                                <input type="text" class="form-control" name="tracking_number" placeholder="Enter tracking number..." style="border-radius:6px;border:1px solid #ddd;padding:10px 12px;font-family:Manrope,sans-serif;">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Shipping Notes <small style="color:#999">(optional)</small></label>
                                                                <textarea class="form-control" name="shipping_notes" rows="3" placeholder="Any additional information..." style="border-radius:6px;border:1px solid #ddd;padding:10px 12px;font-family:Manrope,sans-serif;"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer" style="border-top:1px solid #efefef;padding:16px;background:#f9f9f9;">
                                                            <button type="button" class="btn" data-bs-dismiss="modal" style="color:#0f2f2c;background:#f0f0f0;border-radius:6px;padding:10px 20px;font-weight:600;border:none;cursor:pointer;">Cancel</button>
                                                            <button type="submit" class="btn" style="background:#34FF67;color:#0f2f2c;border-radius:6px;padding:10px 20px;font-weight:600;border:none;cursor:pointer;">Confirm Shipment</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <p style="color:#666; font-size:13px; margin-bottom:16px;">Payment secured. Click below to notify the buyer that their order is ready for collection.</p>
                                        <form method="POST" action="<?= base_url('company-orders/allow_pickup') ?>">
                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                            <input type="hidden" name="order_id" value="<?= $order['orderID'] ?>">
                                            <button type="submit" class="btn-action-custom btn-success-custom" onclick="return AppDialog.confirmAction(event, this, 'Notify buyer that order #<?= $order['orderID'] ?> is ready for pickup?');">
                                                <i class="bi bi-bag-check"></i> Allow Pickup
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Approval History Card -->
                        <?php if (!empty($order['approvedAt'])) { ?>
                            <div class="order-detail-card">
                                <div class="card-header-custom">
                                    <h3 class="card-title-custom">Timeline</h3>
                                </div>
                                <div class="card-body-custom">
                                    <div class="timeline-item">
                                        <div class="info-label">Created</div>
                                        <div class="info-value"><?= date('M d, Y h:i A', strtotime($order['createdAt'])) ?></div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="info-label"><?= ucfirst(str_replace('_', ' ', $order['orderStatus'])) ?></div>
                                        <div class="info-value"><?= date('M d, Y h:i A', strtotime($order['approvedAt'])) ?></div>
                                        <?php if (!empty($order['approvedByName'])) { ?>
                                            <small style="color: #999;">By: <?= htmlspecialchars($order['approvedByName']) ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- =============================================
                     RENTAL LIFECYCLE ACTION CARDS (Owner/Company Side)
                     Only show for rental orders
                ============================================= -->
                <?php
                $order_status = $order['orderStatus'] ?? '';
                $rental_status = $order['rentalRequestStatus'] ?? '';
                $is_workforce_order = !empty($order['workforcePaymentID']);
                $is_equipment_rental = !$is_workforce_order && strtolower((string)($order['saleType'] ?? '')) === 'rental';
                $is_rental = $is_workforce_order || $is_equipment_rental;
                $renter_confirmed = !empty($order['renterConfirmedReturn']);
                $owner_confirmed = !empty($order['ownerConfirmedReturn']);
                $start_ts = !empty($order['rentalStartDate']) ? strtotime($order['rentalStartDate'] . ' 00:00:00') : null;
                $end_ts = !empty($order['rentalEndDate']) ? strtotime($order['rentalEndDate'] . ' 23:59:59') : null;
                $hours_until_start = $start_ts ? (($start_ts - time()) / 3600) : null;
                $owner_within_cancel_window = ($hours_until_start !== null && $hours_until_start > 72);
                $handover_notified = in_array($order_status, ['shipped','pickup_ready','delivered'], true);
                // Owner cancel is available only after request acceptance and before handover notification.
                $owner_cancel_eligible_phase = (in_array($rental_status, ['request_approved','awaiting_handover'], true)
                    || in_array($order_status, ['payment_pending','payment_secured'], true));
                $cancellable = $owner_cancel_eligible_phase
                    && !$handover_notified
                    && $owner_within_cancel_window;
                $show_owner_cancel_window_hint = $owner_cancel_eligible_phase
                    && !$handover_notified
                    && !$owner_within_cancel_window
                    && $hours_until_start !== null
                    && $hours_until_start <= 72;
                $days_left = null;
                if ($rental_status === 'rental_active' && $end_ts) {
                    $days_left = max(0, intval(floor(($end_ts - time()) / 86400)) + 1);
                }
                $grace_hours_left = null;
                if ($rental_status === 'return_requested' && $end_ts) {
                    $grace_hours_left = max(0, intval(ceil((($end_ts + (72 * 3600)) - time()) / 3600)));
                }
                $is_past_return_grace = $end_ts ? (time() > ($end_ts + (72 * 3600))) : false;
                $active_deadline_ms = ($rental_status === 'rental_active' && $end_ts) ? ($end_ts * 1000) : 0;
                $return_deadline_ms = ($rental_status === 'return_requested' && $end_ts) ? (($end_ts + (72 * 3600)) * 1000) : 0;
                $post_handover_states = ['rental_active','return_requested','rental_overdue','returned_by_renter','received_by_owner','under_review','rental_completed','rental_cancelled'];
                $pre_handover_order_states = ['request_approved','awaiting_handover','payment_secured','shipped','pickup_ready','delivered'];
                $owner_late_arrival_window = $start_ts
                    && time() >= $start_ts
                    && in_array($order_status, $pre_handover_order_states)
                    && !in_array($rental_status, $post_handover_states);
                $owner_active_window = ($rental_status === 'rental_active');
                $owner_overdue_window = !$renter_confirmed && (
                    $rental_status === 'rental_overdue'
                    || $is_past_return_grace
                );
                $owner_return_inspection_window = $renter_confirmed && !$owner_confirmed;
                $can_report_issue = $owner_active_window || $owner_late_arrival_window || $owner_overdue_window || $owner_return_inspection_window;
                $payment_id  = $order['equipmentPaymentID'] ?? $order['workforcePaymentID'] ?? null;
                $item_type   = !empty($order['equipmentPaymentID']) ? 'equipment' : 'workforce';
                ?>
                <?php if ($is_rental && $payment_id): ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="order-detail-card">
                            <div class="card-header-custom">
                                <h3 class="card-title-custom">⚡ Rental Actions</h3>
                                <span class="status-badge <?php
                                    switch($rental_status) {
                                        case 'rental_active': echo 'badge-completed'; break;
                                        case 'return_requested': echo 'badge-payment'; break;
                                        case 'rental_overdue': echo 'badge-rejected'; break;
                                        case 'rental_completed': echo 'badge-completed'; break;
                                        case 'rental_cancelled': echo 'badge-rejected'; break;
                                        case 'under_review': echo 'badge-pending'; break;
                                        default: echo 'badge-payment';
                                    }
                                ?>"><?= strtoupper(str_replace('_',' ', $rental_status)) ?></span>
                            </div>
                            <div class="card-body-custom">
                                <?php if ($rental_status === 'rental_active' && $days_left !== null): ?>
                                <div class="alert alert-info mb-3 small">
                                    <i class="bi bi-hourglass-split"></i>
                                    Rental period started. <strong><span id="owner-active-countdown" data-deadline="<?= $active_deadline_ms ?>"><?= $days_left ?> day<?= $days_left === 1 ? '' : 's' ?> left</span></strong> (usable until <?= date('d M Y', strtotime($order['rentalEndDate'])) ?>).
                                </div>
                                <?php elseif ($rental_status === 'return_requested' && $grace_hours_left !== null): ?>
                                <div class="alert alert-warning mb-3 small">
                                    <i class="bi bi-arrow-return-left"></i>
                                    Pending return phase: renter has <strong><span id="owner-return-countdown" data-deadline="<?= $return_deadline_ms ?>"><?= $grace_hours_left ?> hour<?= $grace_hours_left === 1 ? '' : 's' ?> left</span></strong> in the 72-hour return window.
                                </div>
                                <?php elseif ($rental_status === 'rental_overdue'): ?>
                                <div class="alert alert-danger mb-3 small">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Return is overdue (72-hour window exceeded). You may report a late-return issue.
                                </div>
                                <?php endif; ?>

                                <div class="d-flex flex-wrap gap-2">

                                    <!-- Confirm Receipt button — only show if renter has confirmed return -->
                                    <?php if (in_array($rental_status, ['rental_active', 'return_requested', 'rental_overdue', 'under_review', 'returned_by_renter'])): ?>
                                    <?php if ($renter_confirmed): ?>
                                        <button class="btn-action-custom btn-success-custom" id="btn-confirm-receipt"
                                                data-payment-id="<?= $payment_id ?>" data-item-type="<?= $item_type ?>">
                                            <i class="bi bi-check2-all"></i> Confirm Receipt
                                        </button>
                                    <?php else: ?>
                                        <button class="btn-action-custom btn-secondary-custom" disabled title="Waiting for renter to mark as returned">
                                            <i class="bi bi-hourglass-split"></i> Awaiting Renter Return
                                        </button>
                                    <?php endif; ?>

                                    <?php if ($rental_status === 'returned_by_renter'): ?>
                                    <div class="alert alert-info mt-3 small w-100">
                                        <i class="bi bi-hourglass-split"></i>
                                        Renter has marked this item as returned. Please confirm receipt to complete the rental.
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                    <!-- Cancel Rental button -->
                                    <?php if ($cancellable): ?>
                                        <button class="btn-action-custom btn-danger-custom"
                                                data-bs-toggle="modal" data-bs-target="#cancelRentalModal">
                                            <i class="bi bi-x-circle"></i> Cancel Rental
                                        </button>
                                    <?php endif; ?>

                                    <!-- Report Issue button (active rental, valid late-arrival, or overdue-not-returned) -->
                                    <?php if ($can_report_issue): ?>
                                        <button class="btn-action-custom btn-secondary-custom"
                                                data-bs-toggle="modal" data-bs-target="#reportIssueModal">
                                            <i class="bi bi-flag"></i> Report Issue
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <?php if ($show_owner_cancel_window_hint): ?>
                                <div class="alert alert-info mt-3 small w-100">
                                    <i class="bi bi-info-circle"></i>
                                    Owner cancellation is available only when more than 72 hours remain before rental start.
                                    <?php $hours_left_clamped = max(0, intval(ceil((float)$hours_until_start))); ?>
                                    Time remaining: <strong><?= $hours_left_clamped ?> hour<?= $hours_left_clamped === 1 ? '' : 's' ?></strong>.
                                </div>
                                <?php endif; ?>

                                <!-- Return status info -->
                                <?php if ($renter_confirmed): ?>
                                <div class="alert alert-info mt-3 small">
                                    <i class="bi bi-info-circle"></i>
                                    Renter confirmed return at <strong><?= date('d M Y H:i', strtotime($order['renterConfirmedAt'])) ?></strong>.
                                    <?= !empty($order['renterReturnNotes']) ? 'Notes: ' . htmlspecialchars($order['renterReturnNotes']) : '' ?>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($order_issues)): ?>
                                <div class="alert mt-3 small" style="background:#f8fafc;border:1px solid #dbe3ea;color:#1f2937;">
                                    <div style="font-weight:700;color:#0f2f2c;margin-bottom:8px;">Issue Escalation History:</div>
                                    <?php
                                    $issue_type_labels = [
                                        'late_delivery' => 'Late Delivery',
                                        'late_return' => 'Late Return',
                                        'damaged' => 'Damaged Equipment',
                                        'missing_parts' => 'Missing Parts',
                                        'malfunction' => 'Operational Malfunction',
                                        'other' => 'Other Issue',
                                    ];
                                    $resolution_labels = [
                                        'no_action' => 'No Action Needed',
                                        'refund_partial' => 'Partial Refund',
                                        'refund_full' => 'Full Refund',
                                        'compensation' => 'Compensation Provided',
                                        'insurance_claim' => 'Insurance Claim Processed',
                                    ];
                                    ?>
                                    <?php foreach ($order_issues as $issue): ?>
                                        <?php
                                        $issue_status = strtolower((string)($issue->issueStatus ?? 'reported'));
                                        $issue_type = strtolower((string)($issue->issueType ?? 'other'));
                                        $reporter_type = strtolower((string)($issue->reporterType ?? ''));
                                        $reported_by_you = ($reporter_type === 'owner');
                                        $reporter_line = $reported_by_you ? 'You reported this issue.' : 'Renter reported this issue.';
                                        $reported_at_raw = $issue->reportedAt ?? $issue->createdAt ?? null;
                                        $resolved_at_raw = $issue->resolvedAt ?? null;
                                        ?>
                                        <div style="border:1px solid #e5e7eb;border-radius:8px;padding:10px 12px;background:#fff;margin-bottom:8px;">
                                            <div style="display:flex;justify-content:space-between;gap:10px;align-items:flex-start;flex-wrap:wrap;">
                                                <div style="font-weight:700;color:#0f2f2c;"><?= htmlspecialchars($issue_type_labels[$issue_type] ?? ucwords(str_replace('_', ' ', $issue_type))) ?></div>
                                                <span style="font-size:11px;padding:3px 8px;border-radius:999px;<?= in_array($issue_status, ['resolved','closed'], true) ? 'background:#dcfce7;color:#166534;' : 'background:#fef3c7;color:#92400e;' ?>">
                                                    <?= in_array($issue_status, ['resolved','closed'], true) ? 'Resolved' : 'Under Review' ?>
                                                </span>
                                            </div>
                                            <div style="font-size:12px;color:#6b7280;margin-top:4px;"><?= htmlspecialchars($reporter_line) ?><?= $reported_at_raw ? ' Reported at ' . date('d M Y H:i', strtotime((string)$reported_at_raw)) . '.' : '' ?></div>
                                            <?php if (!empty($issue->issueTitle)): ?>
                                                <div style="font-size:13px;color:#111827;margin-top:6px;"><strong><?= htmlspecialchars((string)$issue->issueTitle) ?></strong></div>
                                            <?php endif; ?>
                                            <?php if (!empty($issue->issueDescription)): ?>
                                                <div style="font-size:13px;color:#374151;margin-top:2px;"><?= nl2br(htmlspecialchars((string)$issue->issueDescription)) ?></div>
                                            <?php endif; ?>
                                            <?php if (in_array($issue_status, ['resolved','closed'], true)): ?>
                                                <div style="margin-top:8px;padding:8px;border-radius:6px;background:#f0fdf4;border:1px solid #bbf7d0;font-size:12px;color:#14532d;">
                                                    <strong>Resolution:</strong> <?= htmlspecialchars($resolution_labels[strtolower((string)($issue->resolutionOutcome ?? 'no_action'))] ?? ucwords(str_replace('_', ' ', (string)($issue->resolutionOutcome ?? 'No Action')))) ?>
                                                    <?php if (!empty($issue->resolutionNotes)): ?><br><?= nl2br(htmlspecialchars((string)$issue->resolutionNotes)) ?><?php endif; ?>
                                                    <?php if (!empty($issue->resolvedByName) || !empty($resolved_at_raw)): ?><br><span style="color:#166534;">Handled<?= !empty($issue->resolvedByName) ? ' by ' . htmlspecialchars((string)$issue->resolvedByName) : '' ?><?= !empty($resolved_at_raw) ? ' on ' . date('d M Y H:i', strtotime((string)$resolved_at_raw)) : '' ?>.</span><?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cancel Rental Modal -->
                <div class="modal fade" id="cancelRentalModal" tabindex="-1">
                    <div class="modal-dialog"><div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cancel Rental</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning"><i class="bi bi-exclamation-triangle-fill mr-1"></i>
                                Cancelling as owner will trigger a <strong>full refund</strong> to the renter if payment was made.
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Reason for Cancellation</label>
                                <textarea class="form-control" id="cancel-reason-owner" rows="3" placeholder="Enter reason..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-danger" id="confirm-cancel-rental-owner"
                                    data-payment-id="<?= $payment_id ?>" data-item-type="<?= $item_type ?>">Confirm Cancel</button>
                        </div>
                    </div></div>
                </div>

                <!-- Report Issue Modal -->
                <div class="modal fade" id="reportIssueModal" tabindex="-1">
                    <div class="modal-dialog"><div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">⚠️ Report Rental Issue</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info" style="font-size:13px;">
                                <i class="bi bi-info-circle"></i> Reporting an issue will notify the SuperAdmin team for investigation and resolution.
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Issue Category *</label>
                                <select class="form-control" id="issue-type-owner" required>
                                    <option value="">— Select a category —</option>
                                    <option value="late_delivery">Late Delivery</option>
                                    <option value="late_return">Late Return</option>
                                    <option value="damaged">Damaged <?= $item_label ?></option>
                                    <option value="missing_parts">Missing Parts / Components</option>
                                    <option value="malfunction">Operational Malfunction</option>
                                    <option value="other">Other Issue</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" id="issue-title-owner" placeholder="Brief summary...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description *</label>
                                <textarea class="form-control" id="issue-desc-owner" rows="4" placeholder="Describe the issue in detail..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Evidence (Images/Videos) <small class="text-muted">(optional)</small></label>
                                <input type="file" class="form-control" id="issue-media-owner" multiple accept="image/*,video/*">
                                <small class="text-muted">Only images or videos are allowed (max 25MB each).</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-warning text-dark" id="submit-issue-owner"
                                    data-order-id="<?= $order['orderID'] ?>">Submit Issue</button>
                        </div>
                    </div></div>
                </div>

                <!-- Confirm Receipt Modal -->
                <div class="modal fade" id="confirmReceiptModal" tabindex="-1">
                    <div class="modal-dialog"><div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm <?= $item_label ?> Receipt</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="small">Confirming receipt will finalize the rental and release escrow funds to your account.</p>
                            <div class="alert alert-success small mb-3">
                                <i class="bi bi-shield-check"></i>
                                Confirm only if you have received the rental product back safely and have no issues with its return condition.
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Condition Notes <small class="text-muted">(optional)</small></label>
                                <textarea class="form-control" id="receipt-notes-owner" rows="3" placeholder="<?= $item_label ?> condition on return..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-success" id="confirm-receipt-btn"
                                    data-payment-id="<?= $payment_id ?>" data-item-type="<?= $item_type ?>">Confirm Receipt</button>
                        </div>
                    </div></div>
                </div>

                <script>
                var csrfTokenName = '<?= $this->security->get_csrf_token_name() ?>';
                var csrfHash = '<?= $this->security->get_csrf_hash() ?>';
                var csrfCookieName = '<?= $this->config->item('csrf_cookie_name') ?>';

                function getCookie(name) {
                    var value = '; ' + document.cookie;
                    var parts = value.split('; ' + name + '=');
                    if (parts.length === 2) return parts.pop().split(';').shift();
                    return '';
                }

                function attachCsrf(payload) {
                    var latest = getCookie(csrfCookieName);
                    payload[csrfTokenName] = latest || csrfHash;
                    return payload;
                }

                // Owner: Cancel Rental
                document.getElementById('confirm-cancel-rental-owner')?.addEventListener('click', function() {
                    var paymentId = this.dataset.paymentId;
                    var itemType  = this.dataset.itemType;
                    var reason    = document.getElementById('cancel-reason-owner').value.trim();
                    if (!reason) { AppToast.error('Please enter a cancellation reason.'); return; }
                    var btn = this;
                    btn.disabled = true; btn.textContent = 'Cancelling…';
                    var cancelData = {
                        payment_id: paymentId,
                        item_type: itemType,
                        reason: reason
                    };
                    cancelData = attachCsrf(cancelData);
                    $.ajax({
                        url: '<?= site_url("company-orders/api_cancel_rental") ?>',
                        type: 'POST',
                        data: cancelData,
                        dataType: 'json',
                        timeout: 30000,
                        success: function(r) {
                            console.log('Cancel rental response:', r);
                            if (r && r.success) { 
                                AppToast.success(r.message || 'Rental cancelled successfully');
                                setTimeout(function() { location.reload(); }, 1000);
                            } else { 
                                AppToast.error(r?.message || 'Cancellation failed'); 
                                btn.disabled = false; 
                                btn.textContent = 'Confirm Cancel';
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Cancel rental error:', {status: xhr.status, statusText: xhr.statusText, error: error, response: xhr.responseText});
                            var msg = 'Request failed. Please try again.';
                            if (xhr.status === 403) {
                                msg = 'Request blocked (403). Please refresh the page and try again.';
                            } else if (xhr.status >= 400 && xhr.status < 500) {
                                try {
                                    var errData = JSON.parse(xhr.responseText);
                                    msg = errData.message || msg;
                                } catch(e) {}
                            }
                            AppToast.error(msg);
                            btn.disabled = false; 
                            btn.textContent = 'Confirm Cancel';
                        }
                    });
                });

                // Owner: Confirm Receipt button opens modal
                document.getElementById('btn-confirm-receipt')?.addEventListener('click', function() {
                    document.getElementById('confirm-receipt-btn').dataset.paymentId = this.dataset.paymentId;
                    document.getElementById('confirm-receipt-btn').dataset.itemType  = this.dataset.itemType;
                    new bootstrap.Modal(document.getElementById('confirmReceiptModal')).show();
                });

                document.getElementById('confirm-receipt-btn')?.addEventListener('click', function() {
                    var paymentId = this.dataset.paymentId;
                    var itemType  = this.dataset.itemType;
                    var notes     = document.getElementById('receipt-notes-owner').value;
                    this.disabled = true; this.textContent = 'Confirming…';
                    var confirmData = {
                        payment_id: paymentId,
                        item_type: itemType,
                        notes: notes
                    };
                    confirmData = attachCsrf(confirmData);
                    $.post('<?= site_url("company-orders/api_confirm_return") ?>', confirmData, function(r) {
                        if (r.success) { location.reload(); } else { AppToast.error(r.message); }
                    }, 'json').fail(function(xhr) {
                        if (xhr && xhr.status === 403) {
                            AppToast.error('Request blocked (403). Please refresh the page and try again.');
                        } else {
                            AppToast.error('Request failed. Please try again.');
                        }
                    });
                });

                // Owner: Submit Issue
                document.getElementById('submit-issue-owner')?.addEventListener('click', function() {
                    var submitBtn = this;
                    var orderId = this.dataset.orderId;
                    var type    = document.getElementById('issue-type-owner').value;
                    var title   = document.getElementById('issue-title-owner').value.trim();
                    var desc    = document.getElementById('issue-desc-owner').value.trim();
                    var mediaFiles = document.getElementById('issue-media-owner').files;
                    if (!orderId || orderId === '0') { AppToast.error('Missing order reference. Please refresh and try again.'); return; }
                    if (!type || !title || !desc) { AppToast.error('Please fill all required fields.'); return; }

                    var formData = new FormData();
                    formData.append('order_id', orderId);
                    formData.append('issue_type', type);
                    formData.append('issue_title', title);
                    formData.append('issue_description', desc);
                    formData.append(csrfTokenName, getCookie(csrfCookieName) || csrfHash);

                    for (var i = 0; i < mediaFiles.length; i++) {
                        if (!mediaFiles[i].type || (!mediaFiles[i].type.startsWith('image/') && !mediaFiles[i].type.startsWith('video/'))) {
                            AppToast.error('Only image or video attachments are allowed.');
                            return;
                        }
                        formData.append('attachment_' + i, mediaFiles[i]);
                    }

                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Submitting...';

                    $.ajax({
                        url: '<?= site_url("issues/api_create_issue") ?>',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(r) {
                        if (r && r.success) {
                            location.reload();
                            return;
                        }
                        var message = (r && r.message) ? r.message : 'Failed to submit issue.';
                        if (r && r.debug) {
                            console.warn('Issue submit debug:', r.debug);
                        }
                        AppToast.error(message);
                        },
                        error: function(xhr) {
                        var message = 'Request failed. Please try again.';
                        if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        AppToast.error(message);
                        },
                        complete: function() {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Submit Issue';
                        }
                    });
                });
                </script>
                <script>
                    (function() {
                        function formatCountdown(diffMs) {
                            var totalSec = Math.max(0, Math.floor(diffMs / 1000));
                            var days = Math.floor(totalSec / 86400);
                            var rem = totalSec % 86400;
                            var hours = Math.floor(rem / 3600);
                            rem = rem % 3600;
                            var mins = Math.floor(rem / 60);
                            var secs = rem % 60;

                            return days + 'd '
                                + String(hours).padStart(2, '0') + ':'
                                + String(mins).padStart(2, '0') + ':'
                                + String(secs).padStart(2, '0')
                                + ' left';
                        }

                        function startCountdown(elId, onExpireText) {
                            var el = document.getElementById(elId);
                            if (!el) return;
                            var deadline = parseInt(el.getAttribute('data-deadline') || '0', 10);
                            if (!deadline) return;

                            function tick() {
                                var diff = deadline - Date.now();
                                if (diff <= 0) {
                                    el.textContent = onExpireText;
                                    return;
                                }
                                el.textContent = formatCountdown(diff);
                                setTimeout(tick, 1000);
                            }

                            tick();
                        }

                        startCountdown('owner-active-countdown', '0d 00:00:00 left');
                        startCountdown('owner-return-countdown', '0d 00:00:00 left');
                    })();
                </script>

                <?php endif; // end is_rental ?>

                <div class="row mt-4">
                    <div class="col-12">
                        <a href="<?= base_url('company-orders') ?>" class="back-nav-button">
                            <i class="bi bi-arrow-left"></i> Back to Orders List
                        </a>
                    </div>
                </div>

        </main>
    
        <!-- Overlay -->
        <div class="overlay toggle-icon"></div>
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="<?= base_url() ?>assets/js/pace.min.js"></script>
    <script src="<?= base_url() ?>assets/js/app.js"></script>
    <script>
    (function() {
        var adminImages = <?= isset($images) ? json_encode(array_values(array_filter($images))) : '[]' ?>;
        var adminCurrent = 0;
        var BASE = '<?= base_url() ?>';

        window.adminGalleryNav = function(dir) {
            adminGallerySet((adminCurrent + dir + adminImages.length) % adminImages.length);
        };

        window.adminGallerySet = function(idx) {
            adminCurrent = idx;
            var mainImg = document.getElementById('adminMainImg');
            var counter = document.getElementById('adminGalleryCounter');
            if (mainImg) mainImg.src = BASE + adminImages[idx];
            if (counter) counter.textContent = (idx + 1) + ' / ' + adminImages.length;
            adminImages.forEach(function(_, i) {
                var thumb = document.getElementById('adminThumb' + i);
                if (thumb) thumb.style.borderColor = (i === idx) ? '#34FF67' : '#ddd';
            });
        };

    })();
    </script>
    <script>
        function toggleEditReviewForm(formId) {
            var form = document.getElementById(formId);
            if (!form) return;
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }

        (function () {
            document.querySelectorAll('[data-star-picker]').forEach(function (picker) {
                var container = picker.parentElement;
                var input = container ? container.querySelector('input[name="rating"]') : null;
                var stars = picker.querySelectorAll('.star-picker-btn');
                var initial = parseInt(picker.getAttribute('data-current-rating') || (input ? input.value : '0'), 10) || 0;
                function paint(value) {
                    stars.forEach(function (s) {
                        var active = parseInt(s.getAttribute('data-value'), 10) <= value;
                        s.classList.toggle('is-active', active);
                    });
                }
                stars.forEach(function (star) {
                    star.addEventListener('click', function () {
                        var value = parseInt(star.getAttribute('data-value'), 10);
                        if (input) input.value = String(value);
                        paint(value);
                    });
                });
                if (input && initial > 0) input.value = String(initial);
                paint(initial);
            });
        })();
    </script>
</body>

</html>

