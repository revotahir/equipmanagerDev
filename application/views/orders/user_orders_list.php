<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?= base_url() ?>assets/images/logo-icon.png" type="image/png" />
    
    <!-- Website CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/style.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/header.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/footer.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/resopnsive.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    
    <title>My Orders - EquipManager</title>
    
    <style>
        :root {
            --primary-brand: #13372E;
            --accent-green: #13372E;
            --text-primary: #1A1A1A;
            --text-secondary: #6B7280;
            --text-light: #FFFFFF;
            --body-bg: #F5F6F8;
            --card-bg: #FFFFFF;
            --border-color: #E5E7EB;
            --table-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Manrope", sans-serif;
        }

        body {
            background-color: var(--body-bg);
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
        }

        /* Page Title Section */
        .page-title-section {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 24px;
            margin-bottom: 24px;
            border-radius: 12px;
            box-shadow: var(--table-shadow);
        }

        .page-title {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .page-subtitle {
            margin: 8px 0 0 0;
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Status Filter Tabs */
        .status-filters {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
            background: linear-gradient(135deg, #f0f9f4 0%, #ffffff 100%);
            padding: 20px;
            border-radius: 12px;
            border: 2px solid #e8f5f0;
        }

        .filter-btn {
            padding: 12px 24px;
            border: 2px solid #d0d0d0;
            background-color: #ffffff;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            text-decoration: none;
        }

        .filter-btn:hover {
            border-color: var(--accent-green);
            color: var(--text-primary);
            background-color: #e8f5f0;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .filter-btn.active {
            border-color: var(--accent-green);
            background: linear-gradient(135deg, #13372E 0%, #13372E 100%);
            color: white;
            font-weight: 700;
        }

        /* Sorting Controls */
        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
            gap: 24px;
            padding: 16px 20px;
            background-color: #f9f9f9;
            border-bottom: 1px solid var(--border-color);
            border-radius: 12px 12px 0 0;
        }

        .sort-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            white-space: nowrap;
        }

        .sort-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .sort-select {
            padding: 8px 12px;
            border: 2px solid var(--border-color);
            background-color: #ffffff;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .sort-select:hover {
            border-color: var(--accent-green);
        }

        .sort-select:focus {
            outline: none;
            border-color: var(--accent-green);
        }

        /* Orders Table */
        .orders-table-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: var(--table-shadow);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        thead {
            background-color: #f9f9f9;
            border-bottom: 2px solid var(--border-color);
        }

        th {
            padding: 16px;
            font-weight: 700;
            font-size: 13px;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: none;
            text-align: left;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #f5f5f5;
            color: var(--text-secondary);
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr:hover {
            background-color: #fafafa;
        }

        .order-id {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 15px;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-primary {
            background-color: #d1e7f5;
            color: #004085;
        }

        .status-success {
            background-color: #d4edda;
            color: #155724;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-shipped {
            background-color: #e0f0ff;
            color: #0057b8;
        }

        .status-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 8px 14px;
            border: 2px solid transparent;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            background: none;
            border: 1px solid;
        }

        .btn-view {
            background-color: #f0f9f4;
            color: var(--accent-green);
            border: 1px solid #d0e8e0;
        }

        .btn-view:hover {
            background-color: #e0f5e8;
            border-color: var(--accent-green);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-chat {
            background-color: #e8f5ff;
            color: #0066cc;
            border: 1px solid #b3d9ff;
        }

        .btn-chat:hover {
            background-color: #d4ebff;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-pay {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #a3d9a5;
        }

        .btn-pay:hover {
            background-color: #c3e6cb;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-confirm {
            background-color: #34FF67;
            color: #0f2f2c;
            border: 1px solid #1fcc4f;
            font-weight: 700;
        }

        .btn-confirm:hover {
            background-color: #1fcc4f;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-confirm:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-expired-link {
            background-color: #f3f4f6;
            color: #6b7280;
            border: 1px solid #d1d5db;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .btn-expired-link:hover {
            background-color: #f3f4f6;
            color: #6b7280;
            text-decoration: none;
            transform: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-state-icon {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 16px;
        }

        .empty-state-text {
            font-size: 16px;
            color: var(--text-secondary);
        }

        @media (max-width: 1024px) {
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

            .table-controls {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }

            th, td {
                padding: 12px;
                font-size: 12px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Website Header -->
    <?php $this->load->view('components/websiteHeader'); ?>

    <div class="main-wrapper">
        <div class="dashboard-container">
            <!-- Dashboard Sidebar -->
            <?php $this->load->view('components/dashboardSidebar', ['active_page' => 'orders']); ?>

            <!-- Main Content -->
            <main class="dashboard-content">
                
                <!-- Page Title -->
                <div class="page-title-section">
                    <h1 class="page-title">My Orders</h1>
                    <p class="page-subtitle">View and manage your purchases</p>
                </div>

                <?php
                    $filter_type = strtolower((string)($filter_type ?? ''));
                    $status_query_suffix = !empty($filter_type) ? '&type=' . rawurlencode($filter_type) : '';
                    $type_query_suffix = !empty($filter) ? '&status=' . rawurlencode((string)$filter) : '';
                ?>

                <!-- Status Filter Tabs -->
                <div class="status-filters">
                    <a href="<?= base_url('orders') ?>" class="filter-btn <?= (!$filter && !$filter_type) ? 'active' : '' ?>">
                        <i class="bi bi-list-ul"></i>
                        <span>All Orders</span>
                    </a>
                    <a href="<?= base_url('orders?status=requested' . $status_query_suffix) ?>" class="filter-btn <?= $filter == 'requested' ? 'active' : '' ?>">
                        <i class="bi bi-clock"></i>
                        <span>Pending</span>
                    </a>
                    <a href="<?= base_url('orders?status=payment_pending' . $status_query_suffix) ?>" class="filter-btn <?= $filter == 'payment_pending' ? 'active' : '' ?>">
                        <i class="bi bi-credit-card"></i>
                        <span>Awaiting Payment</span>
                    </a>
                    <a href="<?= base_url('orders?status=shipped' . $status_query_suffix) ?>" class="filter-btn <?= $filter == 'shipped' ? 'active' : '' ?>">
                        <i class="bi bi-truck"></i>
                        <span>On The Way</span>
                    </a>
                    <a href="<?= base_url('orders?status=completed' . $status_query_suffix) ?>" class="filter-btn <?= $filter == 'completed' ? 'active' : '' ?>">
                        <i class="bi bi-check-circle"></i>
                        <span>Completed</span>
                    </a>
                    <a href="<?= base_url('orders?type=rental' . $type_query_suffix) ?>" class="filter-btn <?= $filter_type == 'rental' ? 'active' : '' ?>">
                        <i class="bi bi-calendar-range"></i>
                        <span>Rental</span>
                    </a>
                    <a href="<?= base_url('orders?type=purchase' . $type_query_suffix) ?>" class="filter-btn <?= $filter_type == 'purchase' ? 'active' : '' ?>">
                        <i class="bi bi-bag"></i>
                        <span>Purchase</span>
                    </a>
                </div>

                <!-- Orders Table -->
                <div class="orders-table-card">
                    <!-- Table Controls -->
                    <div class="table-controls">
                        <div class="sort-group">
                            <label class="sort-label">Sort by:</label>
                            <select class="sort-select" onchange="sortTable(this.value)">
                                <option value="date-desc">Newest First</option>
                                <option value="date-asc">Oldest First</option>
                                <option value="amount-desc">Price: High to Low</option>
                                <option value="amount-asc">Price: Low to High</option>
                                <option value="id-asc">Order ID: A to Z</option>
                                <option value="id-desc">Order ID: Z to A</option>
                            </select>
                        </div>
                        <div class="sort-group">
                            <small style="color: #999; font-size: 12px;">
                                Total Orders: <strong id="total-orders-count">0</strong>
                            </small>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Equipment</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr data-id="<?= htmlspecialchars($order->orderID) ?>" 
                                            data-date="<?= htmlspecialchars($order->createdAt) ?>" 
                                            data-amount="<?= htmlspecialchars($order->grossAmount) ?>"
                                            data-sale-type="<?= ((($order->orderType ?? 'equipment') === 'workforce') || in_array(strtolower((string)($order->saleType ?? '')), ['rental', '0', '2'], true)) ? 'rental' : 'purchase' ?>">
                                            <td class="order-id">#<?= htmlspecialchars($order->orderID) ?></td>
                                            <td>
                                                <div style="display: flex; gap: 8px; align-items: center;">
                                                    <span><?= htmlspecialchars($order->itemName ?? $order->equipName ?? 'Item') ?></span>
                                                    <span style="font-size: 10px; padding: 2px 6px; border-radius: 4px; <?= ($order->orderType ?? 'equipment') === 'equipment' ? 'background-color: #d4edda; color: #155724;' : 'background-color: #d1ecf1; color: #0c5460;' ?>">
                                                        <?= ($order->orderType ?? 'equipment') === 'equipment' ? 'Equipment' : 'Workforce' ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($order->itemCategory ?? $order->catName ?? 'N/A') ?></td>
                                            <td><strong>$<?= number_format($order->grossAmount, 2) ?></strong></td>
                                            <td><?= date('M d, Y', strtotime($order->createdAt)) ?></td>
                                            <td>
                                                <?php
                                                    $sale_type_label_value = strtolower((string)($order->saleType ?? ''));
                                                    $is_rental_type_label = (($order->orderType ?? 'equipment') === 'workforce') || in_array($sale_type_label_value, ['rental', '0', '2'], true);
                                                ?>
                                                <span class="status-badge <?= $is_rental_type_label ? 'status-info' : 'status-primary' ?>">
                                                    <?= $is_rental_type_label ? 'Rental' : 'Purchase' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                    $rawOrderStatus = strtolower((string)($order->orderStatus ?? 'requested'));
                                                    $rentalLifecycleStatus = strtolower((string)($order->rentalLifecycleStatus ?? ''));
                                                    $orderStatus = $rawOrderStatus;
                                                    $saleType = strtolower((string)($order->saleType ?? ''));
                                                    $is_equipment_order = (($order->orderType ?? 'equipment') === 'equipment');
                                                    $is_rental_order = (($order->orderType ?? 'equipment') === 'workforce') || ($is_equipment_order && ($saleType === 'rental' || $saleType === '0' || $saleType === '2'));
                                                    $is_purchase_order = $is_equipment_order && ($saleType === 'purchase' || $saleType === '1');
                                                    $terminal_order_states = ['rejected', 'cancelled', 'refunded'];

                                                    $effectiveCheckoutToken = (string)($order->checkoutToken ?? '');
                                                    $effectiveCheckoutTokenExpiry = $order->checkoutTokenExpiry ?? null;
                                                    if (($order->orderType ?? 'equipment') === 'workforce' && !empty($order->paymentMetadata)) {
                                                        $meta = json_decode((string)$order->paymentMetadata, true);
                                                        if (is_array($meta)) {
                                                            $effectiveCheckoutToken = (string)($meta['checkout_token'] ?? $effectiveCheckoutToken);
                                                            $effectiveCheckoutTokenExpiry = $meta['checkout_token_expiry'] ?? $effectiveCheckoutTokenExpiry;
                                                        }
                                                    }

                                                    if ($rawOrderStatus === 'payment_pending') {
                                                        $orderStatus = 'payment_pending';
                                                    } elseif ($is_rental_order && !empty($rentalLifecycleStatus)) {
                                                        // Rental lifecycle drives status unless order is already terminal.
                                                        $orderStatus = in_array($rawOrderStatus, $terminal_order_states, true)
                                                            ? $rawOrderStatus
                                                            : $rentalLifecycleStatus;
                                                    } elseif (in_array($rawOrderStatus, ['payment_secured', 'shipped', 'pickup_ready', 'delivered', 'completed', 'rejected', 'cancelled'], true)) {
                                                        $orderStatus = $rawOrderStatus;
                                                    }

                                                    // Heal stale mixed states for UI logic (old rows: requested + request_rejected).
                                                    if ($orderStatus === 'request_rejected' && !in_array($rawOrderStatus, $terminal_order_states, true)) {
                                                        $rawOrderStatus = 'rejected';
                                                    } elseif ($orderStatus === 'rental_cancelled' && !in_array($rawOrderStatus, $terminal_order_states, true)) {
                                                        $rawOrderStatus = 'cancelled';
                                                    }

                                                    $has_active_issue = intval($order->hasActiveIssue ?? 0) === 1;
                                                    if ($has_active_issue && !in_array($rawOrderStatus, ['completed', 'cancelled', 'rejected', 'refunded'], true)) {
                                                        $orderStatus = 'under_review';
                                                    }

                                                    $is_purchase_link_expired = false;
                                                    if ($is_purchase_order && $rawOrderStatus === 'payment_pending' && !empty($effectiveCheckoutToken)) {
                                                        if (!empty($effectiveCheckoutTokenExpiry)) {
                                                            $is_purchase_link_expired = (time() > strtotime($effectiveCheckoutTokenExpiry));
                                                        } else {
                                                            $base_ts = !empty($order->createdAt) ? strtotime($order->createdAt) : time();
                                                            $is_purchase_link_expired = (time() > ($base_ts + (7 * 24 * 60 * 60)));
                                                        }
                                                    }
                                                    if ($is_purchase_link_expired) {
                                                        $orderStatus = 'expired';
                                                    }
                                                    $status_labels = [
                                                        // Equipment statuses
                                                        'requested'       => ['class' => 'status-warning',   'label' => 'Pending Approval'],
                                                        'payment_pending' => ['class' => 'status-info',      'label' => 'Awaiting Payment'],
                                                        'expired'         => ['class' => 'status-danger',    'label' => 'Expired'],
                                                        'payment_secured' => ['class' => 'status-primary',   'label' => 'Payment Secured'],
                                                        'pickup_ready'    => ['class' => 'status-primary',   'label' => 'Ready for Pickup'],
                                                        'shipped'         => ['class' => 'status-shipped',   'label' => 'Shipment On The Way'],
                                                        'delivered'       => ['class' => 'status-success',   'label' => 'Delivered'],
                                                        'completed'       => ['class' => 'status-completed', 'label' => 'Completed'],
                                                        'rejected'        => ['class' => 'status-danger',    'label' => 'Rejected'],
                                                        'cancelled'       => ['class' => 'status-danger',    'label' => 'Cancelled'],
                                                        // Workforce statuses
                                                        'request_pending' => ['class' => 'status-warning',   'label' => 'Pending Approval'],
                                                        'request_approved' => ['class' => 'status-info',     'label' => 'Awaiting Payment'],
                                                        'awaiting_handover' => ['class' => 'status-primary', 'label' => 'Awaiting Handover'],
                                                        'request_rejected' => ['class' => 'status-danger',   'label' => 'Rejected'],
                                                        'rental_active'   => ['class' => 'status-success',   'label' => 'Rental Period Started'],
                                                        'return_requested' => ['class' => 'status-info',     'label' => 'Pending Return (72h)'],
                                                        'rental_overdue'  => ['class' => 'status-danger',    'label' => 'Overdue'],
                                                        'returned_by_renter' => ['class' => 'status-primary', 'label' => 'Awaiting Owner Confirmation'],
                                                        'received_by_owner' => ['class' => 'status-primary', 'label' => 'Received By Owner'],
                                                        'under_review'    => ['class' => 'status-warning',   'label' => 'Under Review'],
                                                        'rental_completed' => ['class' => 'status-completed', 'label' => 'Completed'],
                                                        'rental_cancelled' => ['class' => 'status-danger',   'label' => 'Cancelled'],
                                                    ];
                                                    $badge = $status_labels[$orderStatus] ?? ['class' => 'status-warning', 'label' => ucfirst(str_replace('_',' ',$orderStatus))];
                                                    $rental_lifecycle = $order->rentalLifecycleStatus ?? null;
                                                    $rental_status_lc = strtolower((string)($rental_lifecycle ?? ''));
                                                    $raw_order_status_lc = strtolower((string)($rawOrderStatus ?? ''));
                                                    $rental_start_ts = !empty($order->rentalStartDate) ? strtotime($order->rentalStartDate . ' 00:00:00') : null;
                                                    $post_handover_states = ['rental_active','return_requested','rental_overdue','returned_by_renter','received_by_owner','under_review','rental_completed','rental_cancelled'];
                                                    $pre_handover_order_states = ['request_approved','awaiting_handover','payment_secured','shipped','pickup_ready','delivered'];
                                                    $renter_late_arrival_window = $rental_start_ts
                                                        && time() >= $rental_start_ts
                                                        && in_array($raw_order_status_lc, $pre_handover_order_states, true)
                                                        && !in_array($rental_status_lc, $post_handover_states, true);
                                                    $renter_active_window = ($rental_status_lc === 'rental_active');
                                                    $can_report_issue = $renter_active_window || $renter_late_arrival_window;
                                                ?>
                                                <span class="status-badge <?= $badge['class'] ?>">
                                                    <?= $badge['label'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="<?= base_url('orders/' . $order->orderID) ?>" class="btn-action btn-view" title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <?php if (!empty($order->chatID)): ?>
                                                    <a href="<?= base_url('chat/' . $order->orderID) ?>" class="btn-action btn-chat" title="Open Chat">
                                                        <i class="bi bi-chat-dots"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                    <?php if ($rawOrderStatus === 'payment_pending' && !$is_purchase_link_expired && !empty($effectiveCheckoutToken)): ?>
                                                        <a href="<?= base_url('checkout/pay/' . $effectiveCheckoutToken) ?>" class="btn-action btn-pay" title="Pay Now">
                                                            <i class="bi bi-credit-card"></i> Pay
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ($rawOrderStatus === 'pickup_ready'): ?>
                                                    <button type="button" class="btn-action btn-confirm" onclick="confirmPickup(event, <?= $order->orderID ?>, this)" title="Confirm Pickup">
                                                        <i class="bi bi-bag-check"></i> Pickup
                                                    </button>
                                                    <?php endif; ?>
                                                    <?php if ($rawOrderStatus === 'shipped'): ?>
                                                    <button type="button" class="btn-action btn-confirm" onclick="confirmDelivery(event, <?= $order->orderID ?>, this)" title="Confirm Receipt">
                                                        <i class="bi bi-check-circle"></i> Received
                                                    </button>
                                                    <?php endif; ?>
                                                    <?php if ($can_report_issue): ?>
                                                    <a href="<?= base_url('orders/' . $order->orderID) ?>#report-issue-section" class="btn-action" title="Report Issue" style="background-color:#fff7e6;color:#b45309;border-color:#fcd9a5;">
                                                        <i class="bi bi-flag"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8">
                                            <div class="empty-state">
                                                <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
                                                <p class="empty-state-text">No orders found</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Website Footer -->
    <?php $this->load->view('components/websiteFooter'); ?>

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    
    <script>
        // Merge Sort Algorithm
        function mergeSort(arr, compareFn) {
            if (arr.length <= 1) return arr;
            
            const mid = Math.floor(arr.length / 2);
            const left = mergeSort(arr.slice(0, mid), compareFn);
            const right = mergeSort(arr.slice(mid), compareFn);
            
            return merge(left, right, compareFn);
        }

        function merge(left, right, compareFn) {
            const result = [];
            let i = 0, j = 0;
            
            while (i < left.length && j < right.length) {
                if (compareFn(left[i], right[j]) <= 0) {
                    result.push(left[i++]);
                } else {
                    result.push(right[j++]);
                }
            }
            
            return result.concat(left.slice(i)).concat(right.slice(j));
        }

        // Sort table function
        function sortTable(sortBy) {
            const tbody = document.querySelector('table tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // Skip empty state row
            const emptyStateRow = rows.find(row => row.querySelector('.empty-state-icon'));
            const dataRows = rows.filter(row => !row.querySelector('.empty-state-icon'));
            
            if (dataRows.length === 0) return;
            
            let compareFn;
            
            switch(sortBy) {
                case 'date-desc':
                    compareFn = (a, b) => {
                        const dateA = new Date(a.getAttribute('data-date'));
                        const dateB = new Date(b.getAttribute('data-date'));
                        return dateB - dateA;
                    };
                    break;
                case 'date-asc':
                    compareFn = (a, b) => {
                        const dateA = new Date(a.getAttribute('data-date'));
                        const dateB = new Date(b.getAttribute('data-date'));
                        return dateA - dateB;
                    };
                    break;
                case 'amount-desc':
                    compareFn = (a, b) => {
                        const amountA = parseFloat(a.getAttribute('data-amount'));
                        const amountB = parseFloat(b.getAttribute('data-amount'));
                        return amountB - amountA;
                    };
                    break;
                case 'amount-asc':
                    compareFn = (a, b) => {
                        const amountA = parseFloat(a.getAttribute('data-amount'));
                        const amountB = parseFloat(b.getAttribute('data-amount'));
                        return amountA - amountB;
                    };
                    break;
                case 'id-desc':
                    compareFn = (a, b) => {
                        const idA = a.getAttribute('data-id');
                        const idB = b.getAttribute('data-id');
                        return idB.localeCompare(idA);
                    };
                    break;
                case 'id-asc':
                    compareFn = (a, b) => {
                        const idA = a.getAttribute('data-id');
                        const idB = b.getAttribute('data-id');
                        return idA.localeCompare(idB);
                    };
                    break;
                default:
                    return;
            }
            
            const sortedRows = mergeSort(dataRows, compareFn);
            tbody.innerHTML = '';
            sortedRows.forEach(row => tbody.appendChild(row));
        }

        // Update statistics
        function updateStats() {
            const rows = document.querySelectorAll('table tbody tr');
            let totalCount = 0;
            
            rows.forEach(row => {
                if (!row.querySelector('.empty-state-icon')) {
                    totalCount++;
                }
            });
            
            document.getElementById('total-orders-count').textContent = totalCount;
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            sortTable('date-desc');
        });

        function confirmDelivery(evt, orderId, buttonEl) {
            AppDialog.confirm('Have you received your order? This will mark the order as completed and release payment to the seller.', {
                title: 'Confirm Delivery',
                okText: 'Confirm Delivery'
            }).then(function(confirmed) {
                if (!confirmed) {
                    return;
                }

                const btn = buttonEl || (evt && evt.currentTarget ? evt.currentTarget : null);
                if (!btn) {
                    AppToast.error('Action button unavailable. Please refresh and try again.');
                    return;
                }

                const originalHTML = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';

                const formData = new FormData();
                formData.append('order_id', orderId);
                formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

                fetch('<?= base_url('orders/confirm_delivery') ?>', {
                    method: 'POST',
                    body: formData,
                    credentials: 'include',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        AppToast.success(data.message);
                        window.location.href = data.redirect;
                    } else {
                        AppToast.error(data.message);
                        btn.disabled = false;
                        btn.innerHTML = originalHTML;
                    }
                })
                .catch(err => {
                    console.error(err);
                    AppToast.error('Something went wrong. Please try again.');
                    btn.disabled = false;
                    btn.innerHTML = originalHTML;
                });
            });
        }

        function confirmPickup(evt, orderId, buttonEl) {
            AppDialog.confirm('Have you collected your order? Confirming pickup will release payment to the seller. This action cannot be undone.', {
                title: 'Confirm Pickup',
                okText: 'Confirm Pickup'
            }).then(function(confirmed) {
                if (!confirmed) {
                    return;
                }

                const btn = buttonEl || (evt && evt.currentTarget ? evt.currentTarget : null);
                if (!btn) {
                    AppToast.error('Action button unavailable. Please refresh and try again.');
                    return;
                }

                const originalHTML = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';

                const formData = new FormData();
                formData.append('order_id', orderId);
                formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

                fetch('<?= base_url('orders/confirm_pickup') ?>', {
                    method: 'POST',
                    body: formData,
                    credentials: 'include',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        AppToast.success(data.message);
                        window.location.href = data.redirect;
                    } else {
                        AppToast.error(data.message);
                        btn.disabled = false;
                        btn.innerHTML = originalHTML;
                    }
                })
                .catch(err => {
                    console.error(err);
                    AppToast.error('Something went wrong. Please try again.');
                    btn.disabled = false;
                    btn.innerHTML = originalHTML;
                });
            });
        }
    </script>
</body>
</html>
