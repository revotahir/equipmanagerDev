<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - EquipManager</title>
    <link rel="icon" href="<?= base_url() ?>assets/images/logo-icon.png" type="image/png" />
    <!-- Website CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/style.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/header.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/footer.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/resopnsive.css" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
            --shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Manrope", sans-serif;
            background-color: var(--body-bg);
            color: var(--text-primary);
        }

        /* Main Layout */
        .website-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-container {
            flex: 1;
            display: flex;
            width: 100%;
        }

        .dashboard-container {
            display: flex;
            width: 100%;
            gap: 0;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        /* Order Detail Grid Layout */
        .order-detail-grid {
            display: grid;
            grid-template-columns: 40% 1fr;
            gap: 32px;
            margin-bottom: 24px;
        }

        .gallery-section {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .gallery-main {
            background: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            aspect-ratio: 4/5;
            position: relative;
        }

        .main-image-wrapper {
            width: 100%;
            height: 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--body-bg);
        }

        .main-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }

        .main-image-wrapper.fade-out img {
            opacity: 0;
        }

        .main-image-wrapper.fade-in img {
            opacity: 1;
        }

        .gallery-controls {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            padding: 0 12px;
            z-index: 10;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .gallery-main:hover .gallery-controls {
            opacity: 1;
        }

        .gallery-btn {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-brand);
            font-size: 18px;
            transition: all 0.2s ease;
        }

        .gallery-btn:hover:not(:disabled) {
            background: var(--text-light);
            transform: scale(1.1);
        }

        .gallery-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .gallery-counter {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.6);
            color: var(--text-light);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 10;
        }

        .gallery-thumbnails {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 8px;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .gallery-thumbnail {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: pointer;
            overflow: hidden;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .gallery-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-thumbnail.active {
            border-color: var(--primary-brand);
        }

        /* Order Info Section */
        .order-info-section {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .star-display { color:#f59e0b; letter-spacing:1px; font-size:16px; font-weight:700; }
        .star-picker { display:flex; align-items:center; gap:6px; }
        .star-picker-btn { background:none; border:none; font-size:24px; line-height:1; color:#d1d5db; cursor:pointer; padding:0 2px; }
        .star-picker-btn.is-active { color:#f59e0b; }
        .star-picker-text { font-size:12px; color:#6b7280; margin-left:4px; }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }

        .back-button {
            background: transparent;
            border: none;
            color: var(--primary-brand);
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            align-self: flex-start;
        }

        .back-button:hover {
            opacity: 0.8;
            transform: translateX(-4px);
        }

        .order-title-section h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .order-title-section p {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .order-status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .order-status.status-requested {
            background: #E0F2FE;
            color: #0369A1;
        }

        .order-status.status-approved {
            background: #DCFCE7;
            color: #166534;
        }

        .order-status.status-rejected {
            background: #FEE2E2;
            color: #991B1B;
        }

        .order-status.status-payment_pending {
            background: #FEF9C3;
            color: #854D0E;
        }

        .order-status.status-payment_secured {
            background: #D1FAE5;
            color: #065F46;
        }

        .order-status.status-shipped {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .order-status.status-delivered {
            background: #EDE9FE;
            color: #5B21B6;
        }

        .order-status.status-completed {
            background: #DCFCE7;
            color: #14532D;
        }

        .order-status.status-cancelled {
            background: #FEE2E2;
            color: #991B1B;
        }

        .order-status.status-refunded {
            background: #E5E7EB;
            color: #374151;
        }

        .order-price {
            font-size: 24px;
            font-weight: 700;
            color: #22C55E;
        }

        /* Order Details */
        .order-details {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .detail-item {
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-item:nth-child(2n) {
            border-right: 1px solid var(--border-color);
            padding-right: 20px;
        }

        .detail-item:nth-child(2n-1) {
            padding-right: 20px;
        }

        .detail-label {
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .detail-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .rental-panel {
            margin-top: 16px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            background: var(--card-bg);
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .rental-panel-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .rental-panel-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-brand);
            text-transform: uppercase;
            letter-spacing: 0.2px;
        }

        .rental-panel-sub {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .rental-note {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0 0 12px;
            line-height: 1.5;
        }

        .rental-soft-box {
            border: 1px solid #d6e7e2;
            background: #f5faf8;
            color: #1f4a40;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .rental-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .rental-btn {
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            color: #fff;
        }

        .rental-btn-return {
            background: var(--accent-green);
        }

        .rental-btn-issue {
            background: #0f766e;
        }

        .rental-btn-cancel {
            background: #dc2626;
        }

        .rental-period {
            margin-top: 12px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .rental-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.35);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .rental-modal-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            width: 100%;
            max-width: 480px;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.14);
        }

        .rental-modal-title {
            margin: 0 0 8px;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .rental-modal-intro {
            margin: 0 0 14px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .rental-modal-label {
            font-size: 12px;
            font-weight: 700;
            color: #374151;
            display: block;
            margin-bottom: 6px;
        }

        .rental-modal-input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
            font-size: 13px;
            margin-bottom: 12px;
            font-family: inherit;
        }

        .rental-modal-help {
            display: block;
            font-size: 12px;
            color: var(--text-secondary);
            margin: -4px 0 12px;
        }

        .rental-modal-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .rental-modal-btn {
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }

        .rental-modal-btn-neutral {
            background: #f3f4f6;
            color: #111827;
            border: 1px solid #d1d5db;
        }

        .rental-modal-btn-primary {
            background: var(--primary-brand);
            color: #fff;
        }

        .rental-modal-btn-danger {
            background: #dc2626;
            color: #fff;
        }

        .invoice-download-wrap {
            margin-top: -8px;
            margin-bottom: 6px;
        }

        .invoice-download-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            background: var(--primary-brand);
            color: #fff;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 700;
            transition: background 0.2s ease;
        }

        .invoice-download-btn:hover {
            background: #0f2d26;
            color: #fff;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1600px) {
            .main-content {
                padding: 32px;
            }

            .order-detail-grid {
                grid-template-columns: 45% 1fr;
                gap: 28px;
            }

            .order-title-section h1 {
                font-size: 24px;
            }
        }

        @media (max-width: 1024px) {
            .main-content {
                padding: 24px;
            }

            .order-detail-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .gallery-main {
                aspect-ratio: 1/1;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .detail-item:nth-child(2n) {
                border-right: none;
                padding-right: 0;
            }

            .detail-item:nth-child(2n-1) {
                padding-right: 0;
            }

            .gallery-btn {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 16px;
            }

            .order-detail-grid {
                gap: 16px;
            }

            .gallery-main {
                aspect-ratio: 4/5;
            }

            .gallery-btn {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .order-title-section h1 {
                font-size: 20px;
            }

            .order-price {
                font-size: 20px;
            }

            .details-grid {
                gap: 16px;
            }

            .detail-item {
                padding-bottom: 16px;
            }

            .gallery-counter {
                font-size: 11px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 12px;
            }

            .gallery-thumbnails {
                gap: 6px;
                padding: 6px;
            }

            .gallery-thumbnail {
                width: 48px;
                height: 48px;
            }

            .gallery-btn {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }

            .order-header {
                flex-direction: column;
            }

            .order-title-section h1 {
                font-size: 18px;
            }

            .order-details {
                padding: 16px;
            }

            .detail-label {
                font-size: 11px;
            }

            .detail-value {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Website Header -->
    <?php $this->load->view('components/websiteHeader'); ?>

    <div class="website-wrapper">
        <div class="main-container">
            <div class="dashboard-container">
                <!-- Sidebar -->
                <?php $this->load->view('components/dashboardSidebar', ['active_page' => 'orders']); ?>

                <!-- Main Content -->
                <div class="main-content">
                    <?php if (!empty($order)): ?>
                        <!-- Back Button -->
                        <button class="back-button" onclick="window.location.href='<?= base_url('orders') ?>'">
                            <i class="bi bi-chevron-left"></i> Back to Orders
                        </button>

                        <!-- Order Detail Grid -->
                        <div class="order-detail-grid">
                            <!-- Image Gallery Section -->
                            <div class="gallery-section">
                                <!-- Main Image -->
                                <div class="gallery-main" id="galleryMain">
                                    <div class="main-image-wrapper" id="mainImageWrapper">
                                        <img id="mainImage" src="" alt="Equipment image">
                                    </div>
                                    <div class="gallery-controls">
                                        <button class="gallery-btn" id="prevBtn" onclick="previousImage()">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                        <button class="gallery-btn" id="nextBtn" onclick="nextImage()">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                    <div class="gallery-counter" id="counter"></div>
                                </div>

                                <!-- Thumbnails -->
                                <div class="gallery-thumbnails" id="thumbnails"></div>
                            </div>

                            <!-- Order Info Section -->
                            <div class="order-info-section">
                                <!-- Header -->
                                <div class="order-header">
                                    <div class="order-title-section">
                                        <h1>You have ordered a voucher of:</h1>
                                        <div class="order-price">$<?= number_format($order->grossAmount, 2) ?></div>
                                    </div>
                                    <?php
                                    $_payment_meta = json_decode($order->paymentMetadata ?? '{}', true);
                                    $_delivery_fee = floatval($_payment_meta['delivery_amount'] ?? 0);
                                    ?>
                                    <?php
                                    $statusMap = [
                                        'requested'       => ['class' => 'status-requested',       'label' => 'Requested'],
                                        'approved'        => ['class' => 'status-approved',        'label' => 'Approved'],
                                        'rejected'        => ['class' => 'status-rejected',        'label' => 'Rejected'],
                                        'payment_pending' => ['class' => 'status-payment_pending', 'label' => 'Awaiting Payment'],
                                        'payment_secured' => ['class' => 'status-payment_secured', 'label' => 'Payment Secured'],
                                        'shipped'         => ['class' => 'status-shipped',         'label' => 'Shipment On The Way'],
                                        'pickup_ready'    => ['class' => 'status-payment_secured', 'label' => 'Ready for Pickup'],
                                        'delivered'       => ['class' => 'status-delivered',       'label' => 'Delivered'],
                                        'completed'       => ['class' => 'status-completed',       'label' => 'Completed'],
                                        'cancelled'       => ['class' => 'status-cancelled',       'label' => 'Cancelled'],
                                        'refunded'        => ['class' => 'status-refunded',        'label' => 'Refunded'],
                                        'request_pending' => ['class' => 'status-requested',       'label' => 'Request Pending'],
                                        'request_approved'=> ['class' => 'status-payment_secured', 'label' => 'Request Approved'],
                                        'awaiting_handover' => ['class' => 'status-payment_secured', 'label' => 'Awaiting Handover'],
                                        'rental_active'   => ['class' => 'status-delivered',       'label' => 'Rental Period Started'],
                                        'return_requested'=> ['class' => 'status-payment_pending', 'label' => 'Pending Return (72h)'],
                                        'rental_overdue'  => ['class' => 'status-rejected',        'label' => 'Return Overdue'],
                                        'returned_by_renter' => ['class' => 'status-payment_secured', 'label' => 'Awaiting Owner Confirmation'],
                                        'received_by_owner'  => ['class' => 'status-payment_secured', 'label' => 'Received By Owner'],
                                        'rental_completed'=> ['class' => 'status-completed',       'label' => 'Completed'],
                                        'rental_cancelled'=> ['class' => 'status-cancelled',       'label' => 'Rental Cancelled'],
                                        'under_review'    => ['class' => 'status-payment_pending', 'label' => 'Under Review'],
                                    ];
                                    $orderStatus = $order->orderStatus ?? 'requested';
                                    $is_workforce_for_status = !empty($order->workforcePaymentID);
                                    $is_equipment_rental_for_status = !$is_workforce_for_status && strtolower((string)($order->saleType ?? '')) === 'rental';
                                    $is_rental_for_status = $is_workforce_for_status || $is_equipment_rental_for_status;
                                    if ($orderStatus === 'payment_pending') {
                                        $statusKey = 'payment_pending';
                                    } elseif (in_array($orderStatus, ['payment_secured', 'shipped', 'pickup_ready', 'delivered', 'completed', 'rejected', 'cancelled'], true)) {
                                        $statusKey = $orderStatus;
                                    } else {
                                        $statusKey = ($is_rental_for_status && !empty($order->rentalRequestStatus)) ? $order->rentalRequestStatus : $orderStatus;
                                    }
                                    $statusInfo  = $statusMap[$statusKey] ?? ['class' => 'status-requested', 'label' => ucfirst(str_replace('_', ' ', $statusKey))];
                                    ?>
                                    <span class="order-status <?= $statusInfo['class'] ?>">
                                        <?= $statusInfo['label'] ?>
                                    </span>
                                </div>

                                <?php if (!empty($can_download_invoice)): ?>
                                <div class="invoice-download-wrap">
                                    <a class="invoice-download-btn" href="<?= base_url('orders/invoice/' . intval($order->orderID)) ?>">
                                        <i class="bi bi-file-earmark-arrow-down"></i>
                                        Download Invoice (PDF)
                                    </a>
                                </div>
                                <?php endif; ?>

                                <!-- Order Details Card -->
                                <div class="order-details">
                                    <div class="details-grid">
                                        <div class="detail-item">
                                            <div class="detail-label"><?= !empty($order->workforcePaymentID) ? 'Workforce' : 'Equipment' ?></div>
                                            <div class="detail-value"><?= htmlspecialchars($order->itemName ?? $order->equipName ?? 'N/A') ?></div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Category</div>
                                            <div class="detail-value"><?= htmlspecialchars($order->catName ?? 'N/A') ?></div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Price</div>
                                            <div class="detail-value">$<?= number_format($order->grossAmount ?? 0, 2) ?></div>
                                        </div>
                                        <?php if ($_delivery_fee > 0): ?>
                                        <div class="detail-item">
                                            <div class="detail-label">Delivery Fee</div>
                                            <div class="detail-value">$<?= number_format($_delivery_fee, 2) ?></div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="detail-item">
                                            <div class="detail-label">Order Date</div>
                                            <div class="detail-value"><?= date('m/d/Y', strtotime($order->createdAt ?? 'now')) ?></div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Status</div>
                                            <div class="detail-value"><?= $statusInfo['label'] ?></div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Tracking</div>
                                            <div class="detail-value">#<?= $order->orderID ?></div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    $review_context = isset($review_context) && is_array($review_context) ? $review_context : [];
                                    $order_reviews = isset($order_reviews) && is_array($order_reviews) ? $order_reviews : [];
                                    $my_review = isset($my_review) ? $my_review : null;
                                    $current_user_id = (int)($this->session->userdata('loginData')['userID'] ?? 0);
                                ?>
                                <div class="order-details" style="margin-top:16px;">
                                    <h3 style="margin:0 0 12px 0;font-size:20px;color:#1A1A1A;">Reviews</h3>
                                    <?php if (!empty($review_context['allowed']) && empty($my_review)) : ?>
                                    <form method="post" action="<?= base_url('reviews/submit') ?>" enctype="multipart/form-data">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <input type="hidden" name="order_id" value="<?= (int)$order->orderID ?>">
                                        <div style="display:flex;gap:10px;flex-wrap:wrap;">
                                            <input type="hidden" name="rating" value="" required>
                                            <div class="star-picker" data-star-picker>
                                                <button type="button" class="star-picker-btn" data-value="1" aria-label="1 star">★</button>
                                                <button type="button" class="star-picker-btn" data-value="2" aria-label="2 stars">★</button>
                                                <button type="button" class="star-picker-btn" data-value="3" aria-label="3 stars">★</button>
                                                <button type="button" class="star-picker-btn" data-value="4" aria-label="4 stars">★</button>
                                                <button type="button" class="star-picker-btn" data-value="5" aria-label="5 stars">★</button>
                                                <span class="star-picker-text">Click to rate</span>
                                            </div>
                                            <input type="text" name="tags[]" placeholder="Tag e.g. On time" style="padding:8px;border:1px solid #d1d5db;border-radius:6px;">
                                            <input type="file" name="review_media[]" multiple accept="image/*" style="padding:8px;border:1px solid #d1d5db;border-radius:6px;">
                                        </div>
                                        <textarea name="review_text" maxlength="500" rows="3" placeholder="Write your review (optional)..." style="width:100%;margin-top:10px;padding:10px;border:1px solid #d1d5db;border-radius:6px;"></textarea>
                                        <button type="submit" style="margin-top:10px;background:#13372E;color:#fff;border:0;padding:10px 14px;border-radius:8px;">Submit Review</button>
                                    </form>
                                    <?php elseif (!empty($my_review)) : ?>
                                    <p style="color:#6b7280;margin-bottom:10px;">You have already submitted a review for this order.</p>
                                    <?php elseif (!empty($review_context['reason'])) : ?>
                                    <p style="color:#6b7280;margin-bottom:10px;"><?= html_escape($review_context['reason']) ?></p>
                                    <?php else : ?>
                                    <p style="color:#6b7280;margin-bottom:10px;">Review status unavailable for this order right now.</p>
                                    <?php endif; ?>
                                    <?php if (!empty($order_reviews)) : foreach ($order_reviews as $rv) : ?>
                                    <div style="margin-top:12px;padding-top:12px;border-top:1px solid #f1f5f9;">
                                        <?php $r = max(1, min(5, (int)$rv->rating)); $stars = str_repeat('★', $r) . str_repeat('☆', 5 - $r); ?>
                                        <strong><?= html_escape($rv->reviewerName ?: 'User') ?></strong>
                                        <span class="star-display"><?= $stars ?></span>
                                        <div style="color:#374151;"><?= nl2br(html_escape((string)($rv->reviewText ?? ''))) ?></div>
                                        <?php if ((int)($rv->reviewerID ?? 0) === $current_user_id): ?>
                                        <div style="margin-top:8px;display:flex;gap:8px;flex-wrap:wrap;">
                                            <button type="button" onclick="toggleEditReviewForm('review-edit-<?= (int)$rv->reviewID ?>')" style="background:#fff;border:1px solid #d1d5db;color:#13372E;padding:6px 10px;border-radius:6px;font-weight:600;">Edit</button>
                                            <form method="post" action="<?= base_url('reviews/delete/' . (int)$rv->reviewID) ?>" style="display:inline;">
                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                                <button type="submit" style="background:#fff;border:1px solid #ef4444;color:#b91c1c;padding:6px 10px;border-radius:6px;font-weight:600;" onclick="return confirm('Delete this review?');">Delete</button>
                                            </form>
                                        </div>
                                        <form id="review-edit-<?= (int)$rv->reviewID ?>" method="post" action="<?= base_url('reviews/update/' . (int)$rv->reviewID) ?>" style="display:none;margin-top:10px;" enctype="multipart/form-data">
                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                                                <input type="hidden" name="rating" value="<?= (int)$rv->rating ?>" required>
                                                <div class="star-picker" data-star-picker data-current-rating="<?= (int)$rv->rating ?>">
                                                    <button type="button" class="star-picker-btn" data-value="1" aria-label="1 star">★</button>
                                                    <button type="button" class="star-picker-btn" data-value="2" aria-label="2 stars">★</button>
                                                    <button type="button" class="star-picker-btn" data-value="3" aria-label="3 stars">★</button>
                                                    <button type="button" class="star-picker-btn" data-value="4" aria-label="4 stars">★</button>
                                                    <button type="button" class="star-picker-btn" data-value="5" aria-label="5 stars">★</button>
                                                    <span class="star-picker-text">Click to rate</span>
                                                </div>
                                                <input type="text" name="tags[]" placeholder="Tag e.g. On time" style="padding:8px;border:1px solid #d1d5db;border-radius:6px;">
                                                <input type="file" name="review_media[]" multiple accept="image/*" style="padding:8px;border:1px solid #d1d5db;border-radius:6px;">
                                            </div>
                                            <textarea name="review_text" maxlength="500" rows="3" placeholder="Write your review (optional)..." style="width:100%;margin-top:8px;padding:10px;border:1px solid #d1d5db;border-radius:6px;"><?= html_escape($rv->reviewText) ?></textarea>
                                            <button type="submit" style="margin-top:8px;background:#13372E;color:#fff;border:0;padding:8px 12px;border-radius:6px;">Save</button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                    <?php endforeach; endif; ?>
                                </div>

                                <!-- Confirm Pickup Action -->
                                <?php if ($orderStatus === 'pickup_ready'): ?>
                                <div class="order-details" style="margin-top:16px; border-left:4px solid #F59E0B; background:#FFFBEB; padding:20px 24px; border-radius:8px;">
                                    <p style="margin:0 0 12px; font-weight:600; color:#92400E;"><i class="bi bi-building"></i> Your order is ready for collection at the store.</p>
                                    <p style="margin:0 0 16px; font-size:14px; color:#78350F;">Once you have collected your order in person, tap the button below to confirm pickup and complete the transaction.</p>
                                    <button id="btnConfirmPickup" class="action-button" style="background:#F59E0B;color:#fff;border:none;padding:12px 28px;border-radius:8px;font-weight:700;cursor:pointer;font-size:15px;" onclick="confirmPickupDetail(<?= $order->orderID ?>)">
                                        <i class="bi bi-bag-check"></i> Confirm Pickup &amp; Complete Order
                                    </button>
                                </div>
                                <?php endif; ?>

                                <!-- Confirm Receipt Action -->
                                <?php if ($orderStatus === 'shipped'): ?>
                                <div class="order-details" style="margin-top:16px; border-left:4px solid #3B82F6; background:#EFF6FF; padding:20px 24px; border-radius:8px;">
                                    <p style="margin:0 0 12px; font-weight:600; color:#1E40AF;"><i class="bi bi-truck"></i> Your order is on its way.</p>
                                    <p style="margin:0 0 16px; font-size:14px; color:#1E3A8A;">Once you have received your delivery, tap below to confirm receipt and complete the transaction.</p>
                                    <button id="btnConfirmDelivery" class="action-button" style="background:#3B82F6;color:#fff;border:none;padding:12px 28px;border-radius:8px;font-weight:700;cursor:pointer;font-size:15px;" onclick="confirmDeliveryDetail(<?= $order->orderID ?>)">
                                        <i class="bi bi-check-circle"></i> Confirm Receipt &amp; Complete Order
                                    </button>
                                </div>
                                <?php endif; ?>
                                <!-- =============================================
                                     RENTAL LIFECYCLE ACTIONS (Renter-Side)
                                ============================================= -->
                                <?php
                                $is_workforce_order = !empty($order->workforcePaymentID);
                                $is_equipment_rental = !$is_workforce_order && strtolower((string)($order->saleType ?? '')) === 'rental';
                                $is_rental    = $is_workforce_order || $is_equipment_rental;
                                $rental_st    = $order->rentalRequestStatus ?? '';
                                $order_st     = $order->orderStatus ?? '';
                                $start_ts     = !empty($order->rentalStartDate) ? strtotime($order->rentalStartDate . ' 00:00:00') : null;
                                $end_ts       = !empty($order->rentalEndDate) ? strtotime($order->rentalEndDate . ' 23:59:59') : null;
                                $payment_id   = $order->equipmentPaymentID ?? $order->workforcePaymentID ?? null;
                                $item_type    = !empty($order->equipmentPaymentID) ? 'equipment' : 'workforce';
                                $handover_notified = in_array($order_st, ['shipped','pickup_ready','delivered'], true);
                                $can_cancel   = (in_array($rental_st, ['request_pending','request_approved','awaiting_handover'])
                                    || in_array($order_st, ['requested','payment_pending','payment_secured']))
                                    && !$handover_notified;
                                $can_return   = in_array($rental_st, ['rental_active','return_requested','rental_overdue','under_review','received_by_owner']);
                                $already_ret  = !empty($order->renterConfirmedReturn);
                                $days_left = null;
                                if ($rental_st === 'rental_active' && $end_ts) {
                                    $days_left = max(0, intval(floor(($end_ts - time()) / 86400)) + 1);
                                }
                                $grace_hours_left = null;
                                if ($rental_st === 'return_requested' && $end_ts) {
                                    $grace_hours_left = max(0, intval(ceil((($end_ts + (72 * 3600)) - time()) / 3600)));
                                }
                                $active_deadline_ms = ($rental_st === 'rental_active' && $end_ts) ? ($end_ts * 1000) : 0;
                                $return_deadline_ms = ($rental_st === 'return_requested' && $end_ts) ? (($end_ts + (72 * 3600)) * 1000) : 0;
                                $post_handover_states = ['rental_active','return_requested','rental_overdue','returned_by_renter','received_by_owner','under_review','rental_completed','rental_cancelled'];
                                $pre_handover_order_states = ['request_approved','awaiting_handover','payment_secured','shipped','pickup_ready','delivered'];
                                $renter_late_arrival_window = $start_ts
                                    && time() >= $start_ts
                                    && in_array($order_st, $pre_handover_order_states)
                                    && !in_array($rental_st, $post_handover_states);
                                $renter_active_window = ($rental_st === 'rental_active');
                                $can_report_issue = $renter_active_window || $renter_late_arrival_window;
                                $rental_status_label = [
                                    'rental_active' => 'RENTAL PERIOD STARTED',
                                    'return_requested' => 'PENDING RETURN',
                                    'rental_overdue' => 'RETURN OVERDUE',
                                    'returned_by_renter' => 'AWAITING OWNER CONFIRMATION',
                                    'received_by_owner' => 'RECEIVED BY OWNER',
                                    'rental_completed' => 'COMPLETED',
                                ];
                                ?>
                                <?php if ($is_rental && $payment_id): ?>
                                <div id="report-issue-section" class="rental-panel">
                                    <div class="rental-panel-head">
                                        <strong class="rental-panel-title">Rental Status: <?= $rental_status_label[$rental_st] ?? strtoupper(str_replace('_',' ', $rental_st)) ?></strong>
                                        <?php if (!empty($order_st)): ?>
                                        <small class="rental-panel-sub">Order Flow: <?= strtoupper(str_replace('_',' ', $order_st)) ?></small>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($rental_st === 'rental_active' && $days_left !== null): ?>
                                    <div class="rental-soft-box">
                                        <i class="bi bi-hourglass-split"></i>
                                        Rental period started. <strong><span id="renter-active-countdown" data-deadline="<?= $active_deadline_ms ?>"><?= $days_left ?> day<?= $days_left === 1 ? '' : 's' ?> left</span></strong> until <?= date('d M Y', strtotime($order->rentalEndDate)) ?>.
                                    </div>
                                    <?php elseif ($rental_st === 'return_requested' && $grace_hours_left !== null): ?>
                                    <div class="rental-soft-box" style="background:#fff7ed;border-color:#fed7aa;color:#9a3412;">
                                        <i class="bi bi-arrow-return-left"></i>
                                        Rental ended. Return is pending. <strong><span id="renter-return-countdown" data-deadline="<?= $return_deadline_ms ?>"><?= $grace_hours_left ?> hour<?= $grace_hours_left === 1 ? '' : 's' ?> left</span></strong> in the 72-hour return window.
                                    </div>
                                    <?php elseif ($rental_st === 'rental_overdue'): ?>
                                    <div class="rental-soft-box" style="background:#fef2f2;border-color:#fecaca;color:#991b1b;">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        Return window exceeded by 72+ hours. Owner can report a late-return issue.
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($can_return && !$already_ret): ?>
                                    <!-- Mark as Returned -->
                                    <p class="rental-note">Ready to return the equipment? Notify the owner to confirm receipt and complete the rental.</p>
                                    <div class="rental-actions">
                                    <button class="rental-btn rental-btn-return" id="btn-renter-return"
                                            data-payment-id="<?= $payment_id ?>" data-item-type="<?= $item_type ?>">
                                        <i class="bi bi-box-arrow-up"></i> Mark as Returned
                                    </button>
                                    <?php elseif ($already_ret): ?>
                                    <div class="rental-soft-box">
                                        <i class="bi bi-check-circle-fill"></i> You confirmed the return. Waiting for owner to confirm receipt.
                                    </div>
                                    <div class="rental-actions">
                                    <?php else: ?>
                                    <div class="rental-actions">
                                    <?php endif; ?>

                                    <?php if ($can_report_issue): ?>
                                    <!-- Report Issue -->
                                    <button class="rental-btn rental-btn-issue" id="btn-renter-issue"
                                            data-order-id="<?= $order->orderID ?>">
                                        <i class="bi bi-flag"></i> Report Issue
                                    </button>
                                    <?php endif; ?>

                                    <?php if ($can_cancel): ?>
                                    <!-- Cancel Rental -->
                                    <button class="rental-btn rental-btn-cancel" id="btn-renter-cancel"
                                            data-payment-id="<?= $payment_id ?>" data-item-type="<?= $item_type ?>">
                                        <i class="bi bi-x-circle"></i> Cancel Rental
                                    </button>
                                    <?php endif; ?>
                                    </div>

                                    <?php if (!empty($order->rentalStartDate)): ?>
                                    <div class="rental-period">
                                        Rental period: <strong><?= date('d M Y', strtotime($order->rentalStartDate)) ?></strong>
                                        → <strong><?= date('d M Y', strtotime($order->rentalEndDate)) ?></strong>
                                    </div>
                                    <?php endif; ?>

                                    <?php if (!empty($order_issues)): ?>
                                    <div class="rental-soft-box" style="margin-top:14px;background:#f8fafc;border-color:#dbe3ea;color:#1f2937;">
                                        <strong style="display:block;margin-bottom:8px;color:#0f2f2c;">Issue Escalation History:</strong>
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
                                            $reported_by_you = ($reporter_type === 'renter');
                                            $reporter_line = $reported_by_you ? 'You reported this issue.' : 'Owner reported this issue.';
                                            $reported_at_raw = $issue->reportedAt ?? $issue->createdAt ?? null;
                                            $resolved_at_raw = $issue->resolvedAt ?? null;
                                            ?>
                                            <div style="border:1px solid #e5e7eb;border-radius:8px;padding:10px 12px;background:#fff;margin-bottom:8px;">
                                                <div style="display:flex;justify-content:space-between;gap:10px;align-items:flex-start;flex-wrap:wrap;">
                                                    <div style="font-weight:700;color:#0f2f2c;">
                                                        <?= htmlspecialchars($issue_type_labels[$issue_type] ?? ucwords(str_replace('_', ' ', $issue_type))) ?>
                                                    </div>
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

                                <!-- Renter Modals -->
                                <!-- Mark as Returned Modal -->
                                <div id="renter-return-modal" class="rental-modal">
                                    <div class="rental-modal-card" style="max-width:420px;">
                                        <h4 class="rental-modal-title">Confirm Return</h4>
                                        <p class="rental-modal-intro">Confirm that you have physically returned the equipment to the owner.</p>
                                        <label class="rental-modal-label">Condition Notes <span style="color:#9ca3af; font-weight:500;">(optional)</span></label>
                                        <textarea id="renter-return-notes" class="rental-modal-input" rows="3" placeholder="Equipment condition..."></textarea>
                                        <div class="rental-modal-actions">
                                            <button onclick="document.getElementById('renter-return-modal').style.display='none'" class="rental-modal-btn rental-modal-btn-neutral">Cancel</button>
                                            <button id="confirm-renter-return" class="rental-modal-btn rental-modal-btn-primary">Confirm Return</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Report Issue Modal -->
                                <div id="renter-issue-modal" class="rental-modal">
                                    <div class="rental-modal-card">
                                        <h4 class="rental-modal-title">Report an Issue</h4>
                                        <div class="rental-soft-box" style="margin-bottom:14px;">
                                            <strong>Issue Categories:</strong><br>
                                            • Late Delivery<br>
                                            • Damaged Equipment<br>
                                            • Missing Parts<br>
                                            • Operational Malfunction<br>
                                            • Other
                                        </div>

                                        <label class="rental-modal-label">Issue Type *</label>
                                        <select id="renter-issue-type" class="rental-modal-input">
                                            <option value="">— Select an Issue Type —</option>
                                            <option value="late_delivery">⏰ Late Delivery</option>
                                            <option value="damaged">🔨 Damaged Equipment</option>
                                            <option value="missing_parts">📦 Missing Parts</option>
                                            <option value="malfunction">⚙️ Operational Malfunction</option>
                                            <option value="other">❓ Other Issue</option>
                                        </select>

                                        <label class="rental-modal-label">Title/Summary *</label>
                                        <input id="renter-issue-title" type="text" class="rental-modal-input" placeholder="Brief summary of the issue...">

                                        <label class="rental-modal-label">Description *</label>
                                        <textarea id="renter-issue-desc" class="rental-modal-input" rows="4" placeholder="Provide detailed information about the issue..."></textarea>

                                        <label class="rental-modal-label">Evidence (Images/Videos) <span style="color:#9ca3af; font-weight:500;">(optional)</span></label>
                                        <input id="renter-issue-photos" type="file" multiple accept="image/*,video/*" class="rental-modal-input" style="padding:8px;">
                                        <small class="rental-modal-help">Upload images/videos only (max 25MB each).</small>

                                        <div class="rental-modal-actions">
                                            <button onclick="document.getElementById('renter-issue-modal').style.display='none'" class="rental-modal-btn rental-modal-btn-neutral">Cancel</button>
                                            <button type="button" id="confirm-renter-issue" data-order-id="<?= $order->orderID ?>" class="rental-modal-btn rental-modal-btn-primary">Submit Report</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cancel Modal -->
                                <div id="renter-cancel-modal" class="rental-modal">
                                    <div class="rental-modal-card" style="max-width:420px;">
                                        <h4 class="rental-modal-title">Cancel Rental</h4>
                                        <div class="rental-soft-box" style="background:#fff1f2;border-color:#fecdd3;color:#9f1239;">
                                            Cancellations within 72 hours of the rental start date may not be eligible for a full refund.
                                        </div>
                                        <label class="rental-modal-label">Reason *</label>
                                        <textarea id="renter-cancel-reason" class="rental-modal-input" rows="3" placeholder="Reason for cancellation..."></textarea>
                                        <div class="rental-modal-actions">
                                            <button onclick="document.getElementById('renter-cancel-modal').style.display='none'" class="rental-modal-btn rental-modal-btn-neutral">Keep Rental</button>
                                            <button id="confirm-renter-cancel" class="rental-modal-btn rental-modal-btn-danger">Confirm Cancel</button>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                (function() {
                                    var paymentId, itemType, orderId;
                                    var csrfTokenName = '<?= $this->security->get_csrf_token_name() ?>';
                                    var csrfHash = '<?= $this->security->get_csrf_hash() ?>';
                                    var csrfCookieName = '<?= $this->config->item('csrf_cookie_name') ?>';

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

                                    startCountdown('renter-active-countdown', '0d 00:00:00 left');
                                    startCountdown('renter-return-countdown', '0d 00:00:00 left');

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

                                    function show(id) { var el=document.getElementById(id); if(el){el.style.display='flex';} }
                                    function hide(id) { var el=document.getElementById(id); if(el){el.style.display='none';} }

                                    var btnReturn = document.getElementById('btn-renter-return');
                                    if (btnReturn) {
                                        paymentId = btnReturn.dataset.paymentId;
                                        itemType  = btnReturn.dataset.itemType;
                                        btnReturn.onclick = function() { show('renter-return-modal'); };
                                    }

                                    var btnIssue = document.getElementById('btn-renter-issue');
                                    if (btnIssue) {
                                        orderId = btnIssue.dataset.orderId;
                                        btnIssue.onclick = function() { show('renter-issue-modal'); };
                                    }

                                    var btnCancel = document.getElementById('btn-renter-cancel');
                                    if (btnCancel) {
                                        if (!paymentId) paymentId = btnCancel.dataset.paymentId;
                                        if (!itemType)  itemType  = btnCancel.dataset.itemType;
                                        btnCancel.onclick = function() { show('renter-cancel-modal'); };
                                    }

                                    // Confirm Return
                                    document.getElementById('confirm-renter-return')?.addEventListener('click', function() {
                                        var notes = document.getElementById('renter-return-notes').value;
                                        this.disabled = true; this.textContent = 'Submitting…';
                                        var postData = {
                                            payment_id: paymentId,
                                            item_type: itemType,
                                            notes: notes
                                        };
                                        postData[csrfTokenName] = csrfHash;
                                        $.post('<?= site_url("orders/api_confirm_return") ?>', postData, function(r) {
                                            if (r.success) { location.reload(); } else { AppToast.error(r.message); }
                                        }, 'json');
                                    });

                                    // Submit Issue
                                    document.getElementById('confirm-renter-issue')?.addEventListener('click', function() {
                                        var oId  = this.dataset.orderId;
                                        var type = document.getElementById('renter-issue-type').value;
                                        var ttl  = document.getElementById('renter-issue-title').value.trim();
                                        var desc = document.getElementById('renter-issue-desc').value.trim();
                                        var photoFiles = document.getElementById('renter-issue-photos').files;
                                        
                                        if (!type || !ttl || !desc) { 
                                            AppToast.error('Please fill all required fields: Issue Type, Title, and Description.'); 
                                            return; 
                                        }
                                        
                                        var formData = new FormData();
                                        formData.append('order_id', oId);
                                        formData.append('issue_type', type);
                                        formData.append('issue_title', ttl);
                                        formData.append('issue_description', desc);
                                        formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
                                        
                                        // Add evidence photos (optional)
                                        for (var i = 0; i < photoFiles.length; i++) {
                                            if (!photoFiles[i].type || (!photoFiles[i].type.startsWith('image/') && !photoFiles[i].type.startsWith('video/'))) {
                                                AppToast.error('Only image or video attachments are allowed.');
                                                return;
                                            }
                                            formData.append('attachment_' + i, photoFiles[i]);
                                        }
                                        
                                        this.disabled = true; 
                                        this.textContent = 'Submitting…';
                                        
                                        $.ajax({
                                            url: '<?= site_url("issues/api_create_issue") ?>',
                                            type: 'POST',
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            dataType: 'json',
                                            success: function(r) {
                                                if (r.success) {
                                                    AppToast.success('Issue reported successfully! Platform support has been notified.');
                                                    location.reload();
                                                } else {
                                                    AppToast.error(r.message || 'Failed to submit issue');
                                                    document.getElementById('confirm-renter-issue').disabled = false;
                                                    document.getElementById('confirm-renter-issue').textContent = 'Submit Report';
                                                }
                                            },
                                            error: function(xhr) {
                                                var message = 'Error submitting issue. Please try again.';
                                                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                                                    message = xhr.responseJSON.message;
                                                }
                                                AppToast.error(message);
                                                document.getElementById('confirm-renter-issue').disabled = false;
                                                document.getElementById('confirm-renter-issue').textContent = 'Submit Report';
                                            }
                                        });
                                    });

                                    // Confirm Cancel
                                    document.getElementById('confirm-renter-cancel')?.addEventListener('click', function() {
                                        var reason = document.getElementById('renter-cancel-reason').value.trim();
                                        if (!reason) { AppToast.error('Please enter a cancellation reason.'); return; }
                                        var btn = this;
                                        btn.disabled = true; btn.textContent = 'Cancelling…';
                                        var postData = {
                                            payment_id: paymentId,
                                            item_type: itemType,
                                            reason: reason
                                        };
                                        postData = attachCsrf(postData);
                                        $.ajax({
                                            url: '<?= site_url("orders/api_cancel_rental") ?>',
                                            type: 'POST',
                                            data: postData,
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
                                })();
                                </script>
                                <?php endif; // end is_rental ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Order Not Found -->
                        <div style="text-align: center; padding: 60px 40px;">
                            <i class="bi bi-question-circle" style="font-size: 64px; color: var(--border-color); margin-bottom: 16px;"></i>
                            <h2 style="margin-bottom: 8px;">Order Not Found</h2>
                            <p style="color: var(--text-secondary); margin-bottom: 24px;">This order doesn't exist or you don't have permission to view it.</p>
                            <button class="action-button primary" onclick="window.location.href='<?= base_url('orders') ?>'">
                                Back to Orders
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Website Footer -->
    <?php $this->load->view('components/websiteFooter'); ?>

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script>
        const BASE_URL = '<?= base_url() ?>';
        const images = <?= isset($images) ? json_encode($images) : '[]' ?>;
        let currentIndex = 0;

        // Debug: Log images array to console
        console.log('Images Array:', images);
        console.log('Base URL:', BASE_URL);
        console.log('Total Images:', images.length);

        const mainImage = document.getElementById('mainImage');
        const counter = document.getElementById('counter');
        const thumbnails = document.getElementById('thumbnails');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const mainImageWrapper = document.getElementById('mainImageWrapper');

        // Initialize gallery
        function initGallery() {
            // Filter to only valid images that might exist
            const validImages = images.filter(img => img && img.length > 0);
            
            if (validImages.length === 0) {
                console.log('No valid images found in array, using fallback');
                mainImage.src = BASE_URL + 'assets/website/images/brand-logo-2.png';
                counter.textContent = '0/0';
                prevBtn.disabled = true;
                nextBtn.disabled = true;
                return;
            }

            console.log('Loading gallery with', validImages.length, 'images');

            // Render thumbnails
            validImages.forEach((img, index) => {
                const thumb = document.createElement('div');
                thumb.className = 'gallery-thumbnail' + (index === 0 ? ' active' : '');
                const imgElement = document.createElement('img');
                imgElement.src = BASE_URL + img;
                imgElement.alt = `Thumbnail ${index + 1}`;
                let thumbnailFallbackAttempted = false;
                imgElement.onerror = function() {
                    if (!thumbnailFallbackAttempted) {
                        console.error(`Failed to load thumbnail ${index + 1}:`, this.src);
                        console.log('The database may reference files that were never uploaded. Check:', img);
                        thumbnailFallbackAttempted = true;
                        this.src = BASE_URL + 'assets/website/images/brand-logo-2.png';
                    }
                };
                imgElement.onload = function() {
                    console.log(`Thumbnail ${index + 1} loaded:`, this.src);
                };
                thumb.appendChild(imgElement);
                thumb.onclick = () => goToImage(index);
                thumbnails.appendChild(thumb);
            });

            // Set initial image
            showImage(0);
        }

        function showImage(index) {
            if (images.length === 0) return;

            currentIndex = (index + images.length) % images.length;
            const imageUrl = BASE_URL + images[currentIndex];
            mainImage.src = imageUrl;
            
            // Add error handling for main image (prevent infinite loop)
            let mainImageFallbackAttempted = false;
            mainImage.onerror = function() {
                if (!mainImageFallbackAttempted) {
                    console.error('Failed to load main image:', imageUrl);
                    mainImageFallbackAttempted = true;
                    this.src = BASE_URL + 'assets/website/images/brand-logo-2.png';
                }
            };
            
            mainImage.onload = function() {
                console.log('Main image loaded:', imageUrl);
            };
            
            counter.textContent = `${currentIndex + 1}/${images.length}`;

            // Update active thumbnail
            document.querySelectorAll('.gallery-thumbnail').forEach((thumb, i) => {
                thumb.classList.toggle('active', i === currentIndex);
            });

            // Update button states
            prevBtn.disabled = images.length <= 1;
            nextBtn.disabled = images.length <= 1;
        }

        function goToImage(index) {
            mainImageWrapper.classList.add('fade-out');
            setTimeout(() => {
                showImage(index);
                mainImageWrapper.classList.remove('fade-out');
                mainImageWrapper.classList.add('fade-in');
            }, 150);
        }

        function nextImage() {
            if (images.length > 1) goToImage(currentIndex + 1);
        }

        function previousImage() {
            if (images.length > 1) goToImage(currentIndex - 1);
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') previousImage();
        });

        // Touch swipe support
        let touchStartX = 0;
        let touchEndX = 0;

        mainImageWrapper.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, false);

        mainImageWrapper.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) nextImage();
                else previousImage();
            }
        }, false);

        // Initialize on load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing gallery...');
            initGallery();
        });

        function confirmPickupDetail(orderId) {
            AppDialog.confirm('Have you collected your order? Confirming pickup will release payment to the seller. This action cannot be undone.', {
                title: 'Confirm Pickup',
                okText: 'Confirm Pickup'
            }).then(function(confirmed) {
                if (!confirmed) {
                    return;
                }

                const btn = document.getElementById('btnConfirmPickup');
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
                const fd = new FormData();
                fd.append('order_id', orderId);
                fd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
                fetch('<?= base_url("orders/confirm_pickup") ?>', { method: 'POST', body: fd, credentials: 'include', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(data => {
                    if (data.success) { AppToast.success(data.message); window.location.href = data.redirect; }
                    else { AppToast.error(data.message); btn.disabled = false; btn.innerHTML = '<i class="bi bi-bag-check"></i> Confirm Pickup & Complete Order'; }
                })
                .catch(e => { AppToast.error('Error: ' + e.message); btn.disabled = false; btn.innerHTML = '<i class="bi bi-bag-check"></i> Confirm Pickup & Complete Order'; });
            });
        }

        function confirmDeliveryDetail(orderId) {
            AppDialog.confirm('Have you received your order? Confirming receipt will release payment to the seller. This action cannot be undone.', {
                title: 'Confirm Receipt',
                okText: 'Confirm Receipt'
            }).then(function(confirmed) {
                if (!confirmed) {
                    return;
                }

                const btn = document.getElementById('btnConfirmDelivery');
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
                const fd = new FormData();
                fd.append('order_id', orderId);
                fd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
                fetch('<?= base_url("orders/confirm_delivery") ?>', { method: 'POST', body: fd, credentials: 'include', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(data => {
                    if (data.success) { AppToast.success(data.message); window.location.href = data.redirect; }
                    else { AppToast.error(data.message); btn.disabled = false; btn.innerHTML = '<i class="bi bi-check-circle"></i> Confirm Receipt & Complete Order'; }
                })
                .catch(e => { AppToast.error('Error: ' + e.message); btn.disabled = false; btn.innerHTML = '<i class="bi bi-check-circle"></i> Confirm Receipt & Complete Order'; });
            });
        }
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

