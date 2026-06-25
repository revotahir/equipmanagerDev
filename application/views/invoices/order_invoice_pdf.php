<?php
$safe = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};

$money = static function ($value) use ($invoice) {
    $symbol = isset($invoice['currency_symbol']) ? (string)$invoice['currency_symbol'] : '$';
    return $symbol . number_format((float)$value, 2);
};

$title_source = isset($invoice['title']) ? (string)$invoice['title'] : 'INVOICE';
$is_rental = stripos($title_source, 'RENTAL') !== false;

$title = $is_rental ? 'RENTAL INVOICE' : 'SALES INVOICE';
$subtitle = trim((string)($invoice['subtitle'] ?? ''));
if ($subtitle === '') {
    $subtitle = $is_rental
        ? 'Transaction Facilitated via EquipManager Platform'
        : 'Transaction Facilitated via EquipManager Marketplace';
}

$status_raw = isset($invoice['status_label']) ? (string)$invoice['status_label'] : 'Completed';
$status_label = trim($status_raw) === '' ? 'Completed' : ucwords(strtolower(str_replace('_', ' ', $status_raw)));

$invoice_number = isset($invoice['invoice_number']) ? (string)$invoice['invoice_number'] : 'N/A';
$order_number = isset($invoice['order_number']) ? (string)$invoice['order_number'] : 'N/A';
$issued_on = isset($invoice['issued_on']) ? (string)$invoice['issued_on'] : date('d M Y');
$currency_code = strtoupper(trim((string)($invoice['currency_code'] ?? $invoice['currency'] ?? 'DKK')));
if ($currency_code === '') {
    $currency_code = 'DKK';
}

$from = isset($invoice['from']) && is_array($invoice['from']) ? $invoice['from'] : [];
$to = isset($invoice['to']) && is_array($invoice['to']) ? $invoice['to'] : [];
$line = isset($invoice['line']) && is_array($invoice['line']) ? $invoice['line'] : [];
$summary = isset($invoice['summary']) && is_array($invoice['summary']) ? $invoice['summary'] : [];
$meta = isset($invoice['meta']) && is_array($invoice['meta']) ? $invoice['meta'] : [];

$seller_company = trim((string)($from['company'] ?? 'EquipManager Partner'));
$seller_cvr = trim((string)($from['cvr'] ?? ''));
$seller_address = trim((string)($from['address'] ?? ''));
$seller_email = trim((string)($from['email'] ?? ''));
$seller_phone = trim((string)($from['phone'] ?? ''));

$buyer_name = trim((string)($to['name'] ?? 'Customer'));
$buyer_cvr = trim((string)($to['cvr'] ?? ''));
$buyer_address = trim((string)($to['address'] ?? ''));
$buyer_email = trim((string)($to['email'] ?? ''));
$buyer_phone = trim((string)($to['phone'] ?? ''));

$item_description = trim((string)($line['description'] ?? ($is_rental ? 'Rental Equipment' : 'Product')));
$item_category = trim((string)($line['category'] ?? ''));
$item_condition = trim((string)($line['condition'] ?? 'Used'));
$quantity = (int)($line['quantity'] ?? 1);
if ($quantity < 1) {
    $quantity = 1;
}

$unit_rate = (float)($line['rate'] ?? 0);
$line_total = (float)($line['amount'] ?? ($unit_rate * $quantity));

$rental_start = trim((string)($meta['rental_start_date'] ?? ''));
$rental_end = trim((string)($meta['rental_end_date'] ?? ''));

$subtotal = (float)($summary['subtotal'] ?? $line_total);
$service_fee = (float)($summary['fee'] ?? (($invoice['commission']['amount'] ?? 0)));
$insurance = (float)($summary['insurance'] ?? 0);
$vat = (float)($summary['tax'] ?? 0);
$total_paid = (float)($summary['total'] ?? ($subtotal + $service_fee + $insurance + $vat));

$verification_id = trim((string)($meta['transaction_id'] ?? ''));
if ($verification_id === '') {
    $fallback = preg_replace('/[^A-Za-z0-9]/', '', $invoice_number);
    $verification_id = 'EM-VER-' . str_pad(substr($fallback, -6), 6, '0', STR_PAD_LEFT);
}

$verification_url = trim((string)($meta['verification_url'] ?? ''));
$verification_qr_svg_data_uri = trim((string)($meta['verification_qr_svg_data_uri'] ?? ''));
$verification_qr_data_uri = trim((string)($meta['verification_qr_data_uri'] ?? ''));

$seller_header = $is_rental ? 'Lessor Information (Equipment Owner)' : 'Seller Information';
$buyer_header = $is_rental ? 'Lessee Information (Renter)' : 'Buyer Information';
$detail_header = $is_rental ? 'Rental Equipment Details' : 'Product Details';
$left_summary_header = $is_rental ? 'Rental Summary' : 'Cost Summary';
$notice_header = $is_rental ? 'Rental Agreement Notice' : 'Sales Agreement Notice';
$right_subtotal_label = 'Subtotal:';

$notice_text = $is_rental
    ? 'This rental transaction was facilitated via EquipManager. The rental agreement is entered directly between the <strong>Lessor</strong> (equipment owner) and the <strong>Lessee</strong> (renter). EquipManager provides the digital platform enabling the rental transaction.'
    : 'This purchase was facilitated through EquipManager Marketplace. The sale agreement is made directly between the <strong>Seller</strong> and <strong>Buyer</strong>. EquipManager provides the platform infrastructure, enabling the transaction.';

$logo_src = '';
if (defined('FCPATH')) {
    $jpeg_logo_path = FCPATH . 'assets/logo.jpg';
    if (is_file($jpeg_logo_path)) {
        $jpeg_raw = @file_get_contents($jpeg_logo_path);
        if ($jpeg_raw !== false) {
            $logo_src = 'data:image/jpeg;base64,' . base64_encode($jpeg_raw);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $safe($invoice_number) ?></title>
    <style>
        @page {
            size: A4;
            margin: 8mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-family: Calibri, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: #FFFFFF;
            color: #111827;
            font-family: Calibri, sans-serif;
            font-size: 11px;
            line-height: 1.32;
        }

        .sheet {
            width: 100%;
            border: 1px solid #E5E7EB;
            background: #FFFFFF;
            padding: 12px;
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        .block {
            margin-bottom: 8px;
            page-break-inside: avoid;
        }

        .clear {
            clear: both;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .header-table td {
            vertical-align: top;
        }

        .header-left {
            width: 33%;
        }

        .header-center {
            width: 43%;
            text-align: center;
            padding-top: 8px;
        }

        .header-right {
            width: 24%;
            text-align: right;
        }

        .brand-logo {
            white-space: nowrap;
        }

        .brand-logo-image {
            display: block;
            width: 250px;
            max-width: 100%;
            height: auto;
        }

        .brand-mark {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 44px;
            border: 4px solid #0F4A44;
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 8px;
        }

        .brand-mark:before {
            content: "";
            position: absolute;
            left: 7px;
            top: 7px;
            width: 18px;
            height: 18px;
            border: 4px solid #0F4A44;
            border-top-color: transparent;
            border-right-color: transparent;
            border-radius: 50%;
            transform: rotate(-32deg);
        }

        .brand-mark:after {
            content: "";
            position: absolute;
            left: 8px;
            top: 18px;
            width: 25px;
            height: 5px;
            border-radius: 3px;
            background: #0F4A44;
            transform: rotate(-32deg);
        }

        .brand-text {
            display: inline-block;
            vertical-align: middle;
            color: #0F4A44;
            font-weight: 700;
            font-size: 18px;
            line-height: 0.96;
        }

        .brand-text span {
            display: block;
        }

        .invoice-title {
            margin: 0;
            color: #111827;
            font-size: 31px;
            line-height: 1;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .invoice-subtitle {
            margin-top: 5px;
            color: #6B7280;
            font-size: 11px;
            font-weight: 400;
        }

        .qr-box {
            display: inline-block;
            width: 82px;
            height: 82px;
            border: 1px solid #111827;
            background:
                linear-gradient(90deg, #111827 12%, transparent 12%) 0 0/16px 16px,
                linear-gradient(#111827 12%, transparent 12%) 0 0/16px 16px,
                #FFFFFF;
        }

            .qr-image {
                display: inline-block;
                width: 82px;
                height: 82px;
                border: 1px solid #111827;
                object-fit: cover;
            }

        .qr-caption {
            margin-top: 4px;
            color: #6B7280;
            text-align: center;
            font-size: 10px;
        }

        .panel-head {
            border: 1px solid #E5E7EB;
            border-bottom: none;
            background: #F3F4F6;
            padding: 7px 10px;
        }

        .panel-head-title {
            float: left;
            color: #111827;
            font-size: 13px;
            font-weight: 700;
        }

        .panel-head-action {
            float: right;
            color: #1D4640;
            font-size: 11px;
            font-weight: 600;
        }

        .panel-body {
            border: 1px solid #E5E7EB;
            background: #FFFFFF;
            padding: 8px 10px;
        }

        .info-layout {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .info-layout td {
            width: 50%;
            vertical-align: top;
        }

        .info-layout td:first-child {
            padding-right: 8px;
            border-right: 1px solid #E5E7EB;
        }

        .info-layout td:last-child {
            padding-left: 8px;
        }

        .meta-row {
            margin-bottom: 5px;
            white-space: nowrap;
        }

        .meta-row:last-child {
            margin-bottom: 0;
        }

        .meta-label {
            display: inline-block;
            width: 49%;
            color: #6B7280;
            font-weight: 600;
            vertical-align: top;
        }

        .meta-value {
            display: inline-block;
            width: 50%;
            color: #111827;
            font-weight: 500;
            text-align: right;
            vertical-align: top;
        }

        .status-badge {
            display: inline-block;
            background: #1D4640;
            color: #FFFFFF;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 9px;
            border-radius: 4px;
        }

        .parties-layout {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            border: 1px solid #E5E7EB;
        }

        .parties-layout td {
            width: 50%;
            vertical-align: top;
            border-right: 1px solid #E5E7EB;
        }

        .parties-layout td:last-child {
            border-right: none;
        }

        .party-head {
            background: #1D4640;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: 700;
            padding: 7px 10px;
        }

        .party-body {
            padding: 8px 10px;
            min-height: 106px;
        }

        .party-name {
            color: #111827;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .party-line {
            color: #111827;
            font-size: 11px;
            margin-bottom: 2px;
        }

        .party-muted {
            color: #6B7280;
        }

        .detail-title {
            border: 1px solid #E5E7EB;
            border-bottom: none;
            background: #1D4640;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: 700;
            padding: 7px 10px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            border: 1px solid #E5E7EB;
        }

        .detail-table th {
            background: #F3F4F6;
            color: #111827;
            font-size: 11px;
            font-weight: 700;
            padding: 7px 8px;
            text-align: left;
            border-right: 1px solid #E5E7EB;
            border-bottom: 1px solid #E5E7EB;
        }

        .detail-table th:last-child,
        .detail-table td:last-child {
            border-right: none;
            text-align: right;
        }

        .detail-table td {
            color: #111827;
            font-size: 11px;
            padding: 7px 8px;
            border-right: 1px solid #E5E7EB;
            vertical-align: top;
        }

        .detail-center {
            text-align: center;
        }

        .detail-right {
            text-align: right;
        }

        .item-main {
            font-weight: 600;
        }

        .item-sub {
            margin-top: 2px;
            color: #6B7280;
            font-size: 10px;
        }

        .summary-layout {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .summary-layout td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .summary-layout td:first-child {
            padding-right: 5px;
        }

        .summary-layout td:last-child {
            padding-left: 5px;
        }

        .summary-box {
            border: 1px solid #E5E7EB;
            background: #FFFFFF;
        }

        .summary-inner {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .summary-inner th,
        .summary-inner td {
            border-bottom: 1px solid #E5E7EB;
            padding: 7px 10px;
            font-size: 11px;
        }

        .summary-inner tr:last-child td {
            border-bottom: none;
        }

        .summary-inner .head th {
            background: #F3F4F6;
            color: #111827;
            font-size: 12px;
            font-weight: 700;
            text-align: left;
            height: 33px;
        }

        .summary-inner .head-spacer td {
            height: 33px;
            padding: 7px 10px;
            background: #F3F4F6;
            border-bottom: 1px solid #E5E7EB;
        }

        .summary-inner .row td {
            height: 33px;
        }

        .summary-inner .left {
            color: #111827;
            width: 72%;
        }

        .summary-inner .right {
            color: #111827;
            width: 28%;
            text-align: right;
            font-weight: 500;
            white-space: nowrap;
        }

        .summary-inner .placeholder td {
            color: transparent;
            height: 33px;
        }

        .summary-inner .total td {
            background: #1D4640;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: 700;
            height: 39px;
            border-bottom: none;
        }

        .bottom-layout {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .bottom-layout td {
            vertical-align: top;
            padding: 0;
            border: 1px solid #E5E7EB;
            background: #F3F4F6;
        }

        .bottom-layout .notice-col {
            width: 66%;
            padding-right: 5px;
        }

        .bottom-layout .support-col {
            width: 34%;
            padding-left: 5px;
        }

        .notice-box,
        .support-box {
            border: 1px solid #E5E7EB;
            background: #F3F4F6;
            width: 100%;
            border-collapse: collapse;
        }

        .notice-head,
        .support-head {
            color: #111827;
            font-size: 12px;
            font-weight: 700;
            padding: 7px 10px;
            border-bottom: 1px solid #E5E7EB;
        }

        .notice-text {
            padding: 8px 10px;
            color: #111827;
            font-size: 11px;
            line-height: 1.45;
        }

        .support-body {
            padding: 8px 10px;
            color: #111827;
            font-size: 11px;
            line-height: 1.5;
        }

        .support-brand {
            margin-bottom: 4px;
            font-weight: 600;
        }

        .support-small {
            margin-top: 2px;
            color: #6B7280;
            font-size: 9px;
        }

        .verify-bar {
            margin-top: 8px;
            padding-top: 6px;
            border-top: 1px solid #E5E7EB;
            color: #6B7280;
            font-size: 10px;
        }

        .verify-left {
            float: left;
            width: 58%;
        }

        .verify-right {
            float: right;
            width: 40%;
            text-align: right;
        }

        .verify-id {
            color: #111827;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="block">
            <table class="header-table">
                <tr>
                    <td class="header-left">
                        <div class="brand-logo">
                            <?php if ($logo_src !== ''): ?>
                                <img class="brand-logo-image" src="<?= $safe($logo_src) ?>" alt="EquipManager Logo">
                            <?php else: ?>
                                <span class="brand-mark"></span>
                                <span class="brand-text"><span>Equip</span><span>Manager</span></span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="header-center">
                        <h1 class="invoice-title"><?= $safe($title) ?></h1>
                        <div class="invoice-subtitle"><?= $safe($subtitle) ?></div>
                    </td>
                    <td class="header-right">
                        <?php if ($verification_qr_svg_data_uri !== '' && $verification_url !== ''): ?>
                            <a href="<?= $safe($verification_url) ?>" target="_blank" style="display:inline-block; text-decoration:none;">
                                <img class="qr-image" src="<?= $safe($verification_qr_svg_data_uri) ?>" alt="Invoice Verification QR">
                            </a>
                            <div class="qr-caption">Scan or Click to Verify</div>
                        <?php elseif ($verification_qr_data_uri !== '' && $verification_url !== ''): ?>
                            <a href="<?= $safe($verification_url) ?>" target="_blank" style="display:inline-block; text-decoration:none;">
                                <img class="qr-image" src="<?= $safe($verification_qr_data_uri) ?>" alt="Invoice Verification QR">
                            </a>
                            <div class="qr-caption">Scan or Click to Verify</div>
                        <?php elseif ($verification_url !== ''): ?>
                            <div style="border: 1px solid #111827; padding: 8px; text-align: center; font-size: 9px; width: 82px; word-break: break-all;">
                                <strong>Verify:</strong><br><?= $safe(substr($verification_url, 0, 60)) ?>...
                            </div>
                        <?php else: ?>
                            <span class="qr-box"></span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="block">
            <div class="panel-head">
                <span class="panel-head-title">Invoice Information</span>
                <span class="panel-head-action">&#9745; Download <?= $is_rental ? 'Rental ' : '' ?>Invoice (PDF)</span>
                <div class="clear"></div>
            </div>
            <div class="panel-body">
                <table class="info-layout">
                    <tr>
                        <td>
                            <div class="meta-row"><span class="meta-label">Invoice Number:</span><span class="meta-value"><?= $safe($invoice_number) ?></span></div>
                            <div class="meta-row"><span class="meta-label">Transaction ID:</span><span class="meta-value"><?= $safe($order_number) ?></span></div>
                            <div class="meta-row"><span class="meta-label">Invoice Date:</span><span class="meta-value"><?= $safe($issued_on) ?></span></div>
                            <div class="meta-row"><span class="meta-label"><?= $is_rental ? 'Rental Status:' : 'Order Status:' ?></span><span class="meta-value"><span class="status-badge"><?= $safe($status_label) ?></span></span></div>
                        </td>
                        <td>
                            <div class="meta-row"><span class="meta-label">Invoice Date:</span><span class="meta-value"><?= $safe($issued_on) ?></span></div>
                            <div class="meta-row"><span class="meta-label">Payment Status:</span><span class="meta-value"><span class="status-badge"><?= $safe($status_label) ?></span></span></div>
                            <div class="meta-row"><span class="meta-label">Currency:</span><span class="meta-value"><?= $safe($currency_code) ?></span></div>
                            <div class="meta-row"><span class="meta-label">Currency:</span><span class="meta-value"><?= $safe($currency_code) ?></span></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="block">
            <table class="parties-layout">
                <tr>
                    <td>
                        <div class="party-head"><?= $safe($seller_header) ?></div>
                        <div class="party-body">
                            <div class="party-name"><?= $safe($seller_company) ?></div>
                            <?php if ($seller_cvr !== ''): ?><div class="party-line"><strong>CVR#:</strong> <?= $safe($seller_cvr) ?></div><?php endif; ?>
                            <?php if ($seller_address !== ''): ?><div class="party-line"><?= nl2br($safe(str_replace(', ', "\n", $seller_address))) ?></div><?php endif; ?>
                            <?php if ($seller_email !== ''): ?><div class="party-line party-muted"><?= $safe($seller_email) ?></div><?php endif; ?>
                            <?php if ($seller_phone !== ''): ?><div class="party-line party-muted"><?= $safe($seller_phone) ?></div><?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <div class="party-head"><?= $safe($buyer_header) ?></div>
                        <div class="party-body">
                            <div class="party-name"><?= $safe($buyer_name) ?></div>
                            <?php if ($buyer_cvr !== ''): ?><div class="party-line"><strong>CVR#:</strong> <?= $safe($buyer_cvr) ?></div><?php endif; ?>
                            <?php if ($buyer_address !== ''): ?><div class="party-line"><?= nl2br($safe(str_replace(', ', "\n", $buyer_address))) ?></div><?php endif; ?>
                            <?php if ($buyer_email !== ''): ?><div class="party-line party-muted"><?= $safe($buyer_email) ?></div><?php endif; ?>
                            <?php if ($buyer_phone !== ''): ?><div class="party-line party-muted"><?= $safe($buyer_phone) ?></div><?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="block">
            <div class="detail-title"><?= $safe($detail_header) ?></div>
            <table class="detail-table">
                <thead>
                    <tr>
                        <?php if ($is_rental): ?>
                            <th style="width:40%;">Equipment</th>
                            <th style="width:12%; text-align:center;">Quantity</th>
                            <th style="width:17%;">Rental Start</th>
                            <th style="width:17%;">Rental End</th>
                            <th style="width:14%;">Total</th>
                        <?php else: ?>
                            <th style="width:36%;">Product</th>
                            <th style="width:20%;">Category</th>
                            <th style="width:16%;">Condition</th>
                            <th style="width:14%; text-align:right;">Unit Price</th>
                            <th style="width:14%;">Total</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php if ($is_rental): ?>
                            <td>
                                <div class="item-main"><?= $safe($item_description) ?></div>
                                <?php if ($item_category !== ''): ?><div class="item-sub"><?= $safe($item_category) ?></div><?php endif; ?>
                            </td>
                            <td class="detail-center"><?= (int)$quantity ?></td>
                            <td><?= $safe($rental_start !== '' ? $rental_start : 'N/A') ?></td>
                            <td><?= $safe($rental_end !== '' ? $rental_end : 'N/A') ?></td>
                            <td class="detail-right"><?= $money($line_total) ?></td>
                        <?php else: ?>
                            <td><div class="item-main"><?= $safe($item_description) ?></div></td>
                            <td><?= $safe($item_category !== '' ? $item_category : 'Power Tools') ?></td>
                            <td><?= $safe($item_condition !== '' ? $item_condition : 'Used') ?></td>
                            <td class="detail-right"><?= $money($unit_rate) ?></td>
                            <td class="detail-right"><?= $money($line_total) ?></td>
                        <?php endif; ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="block">
            <table class="summary-layout">
                <tr>
                    <td>
                        <div class="summary-box">
                            <table class="summary-inner">
                                <tr class="head"><th colspan="2"><?= $safe($left_summary_header) ?></th></tr>
                                <tr class="row"><td class="left"><?= $is_rental ? 'Rental Subtotal' : 'Product Price' ?></td><td class="right"><?= $money($subtotal) ?></td></tr>
                                <?php if ($is_rental): ?>
                                    <tr class="row"><td class="left">Insurance (optional)</td><td class="right"><?= $money($insurance) ?></td></tr>
                                    <tr class="row placeholder"><td class="left">-</td><td class="right">-</td></tr>
                                <?php else: ?>
                                    <tr class="row"><td class="left">EquipManager Marketplace Fee</td><td class="right"><?= $money($service_fee) ?></td></tr>
                                    <tr class="row"><td class="left">VAT (25%):</td><td class="right"><?= $money($vat) ?></td></tr>
                                <?php endif; ?>
                                <tr class="total"><td class="left">Total Amount Paid:</td><td class="right"><?= $money($total_paid) ?></td></tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="summary-box">
                            <table class="summary-inner">
                                <tr class="head-spacer"><td colspan="2"></td></tr>
                                <tr class="row"><td class="left"><?= $safe($right_subtotal_label) ?></td><td class="right"><?= $money($subtotal) ?></td></tr>
                                <tr class="row"><td class="left">EquipManager <?= $is_rental ? 'Service Fee' : 'Marketplace Fee' ?></td><td class="right"><?= $money($service_fee) ?></td></tr>
                                <tr class="row"><td class="left">VAT (25%):</td><td class="right"><?= $money($vat) ?></td></tr>
                                <tr class="total"><td class="left">Total Amount Paid:</td><td class="right"><?= $money($total_paid) ?></td></tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="block">
            <table class="bottom-layout">
                <tr>
                    <td class="notice-col">
                        <div class="notice-head"><?= $safe($notice_header) ?></div>
                        <div class="notice-text"><?= $notice_text ?></div>
                    </td>
                    <td class="support-col">
                        <div class="support-head">Support</div>
                        <div class="support-body">
                            <div class="support-brand">EquipManager Support</div>
                            <div><?= $safe($is_rental ? 'support@equipmanager.com' : '| support@equipmanager.com') ?></div>
                            <div><?= $safe($is_rental ? 'www.equipmanager.com' : '| www.equipmanager.com') ?></div>
                            <?php if ($is_rental): ?><div class="support-small">Terms and conditions apply.</div><?php endif; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="verify-bar">
            <div class="verify-left"><span class="verify-id">Transaction Verification ID: <?= $safe($verification_id) ?></span></div>
            <div class="verify-right">Scan QR code to verify this transaction via EquipManager.</div>
            <div class="clear"></div>
        </div>
    </div>
</body>
</html>