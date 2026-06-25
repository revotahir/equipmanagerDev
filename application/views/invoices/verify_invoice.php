<?php
$safe = static function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};

$is_valid = !empty($is_valid);
$invoice = isset($invoice) && is_array($invoice) ? $invoice : [];
$meta = isset($invoice['meta']) && is_array($invoice['meta']) ? $invoice['meta'] : [];
$from = isset($invoice['from']) && is_array($invoice['from']) ? $invoice['from'] : [];
$to = isset($invoice['to']) && is_array($invoice['to']) ? $invoice['to'] : [];
$line = isset($invoice['line']) && is_array($invoice['line']) ? $invoice['line'] : [];
$summary = isset($invoice['summary']) && is_array($invoice['summary']) ? $invoice['summary'] : [];

$symbol = isset($invoice['currency_symbol']) ? (string)$invoice['currency_symbol'] : '$';
$money = static function ($value) use ($symbol) {
    return $symbol . number_format((float)$value, 2);
};

$logo_url = base_url('assets/logo.jpg');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Verification</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Calibri, sans-serif;
        }

        body {
            margin: 0;
            background: #f2f4f7;
            color: #111827;
        }

        .page {
            max-width: 980px;
            margin: 24px auto;
            padding: 0 14px;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
            border-radius: 10px;
            overflow: hidden;
        }

        .header {
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .brand img {
            width: 180px;
            max-width: 100%;
            height: auto;
            display: block;
        }

        .title {
            margin: 0;
            font-size: 30px;
            color: #1f2937;
            letter-spacing: 0.4px;
        }

        .subtitle {
            margin: 4px 0 0;
            color: #6b7280;
            font-size: 16px;
        }

        .status-pill {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-valid {
            background: #e8f7f1;
            color: #0f4a44;
            border: 1px solid #86d2bb;
        }

        .status-invalid {
            background: #fdebec;
            color: #9f1239;
            border: 1px solid #f3b7c3;
        }

        .body {
            padding: 16px 20px 20px;
        }

        .message {
            margin: 0 0 12px;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 16px;
            line-height: 1.35;
        }

        .message-valid {
            background: #edf8f4;
            border: 1px solid #bfe7d8;
            color: #0f4a44;
        }

        .message-invalid {
            background: #fff0f2;
            border: 1px solid #f8c4cf;
            color: #9f1239;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .panel {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            background: #ffffff;
        }

        .panel-head {
            background: #f3f4f6;
            border-bottom: 1px solid #e5e7eb;
            padding: 9px 12px;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .panel-body {
            padding: 10px 12px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 16px;
            line-height: 1.3;
        }

        .row:last-child {
            margin-bottom: 0;
        }

        .label {
            color: #6b7280;
        }

        .value {
            color: #111827;
            font-weight: 600;
            text-align: right;
        }

        .full {
            margin-top: 12px;
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
            margin-top: 12px;
        }

        @media (max-width: 800px) {
            .title {
                font-size: 24px;
            }

            .subtitle {
                font-size: 14px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <div class="header">
                <div class="brand">
                    <img src="<?= $safe($logo_url) ?>" alt="EquipManager">
                    <div>
                        <h1 class="title">Invoice Verification</h1>
                        <p class="subtitle">EquipManager Platform Verification Service</p>
                    </div>
                </div>
                <div>
                    <?php if ($is_valid): ?>
                        <span class="status-pill status-valid">Verified Genuine</span>
                    <?php else: ?>
                        <span class="status-pill status-invalid">Not Valid</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="body">
                <p class="message <?= $is_valid ? 'message-valid' : 'message-invalid' ?>"><?= $safe((string)($message ?? '')) ?></p>

                <?php if ($is_valid): ?>
                    <div class="grid">
                        <div class="panel">
                            <div class="panel-head">Invoice Information</div>
                            <div class="panel-body">
                                <div class="row"><span class="label">Invoice Number</span><span class="value"><?= $safe((string)($invoice['invoice_number'] ?? 'N/A')) ?></span></div>
                                <div class="row"><span class="label">Transaction ID</span><span class="value"><?= $safe((string)($invoice['order_number'] ?? 'N/A')) ?></span></div>
                                <div class="row"><span class="label">Issued On</span><span class="value"><?= $safe((string)($invoice['issued_on'] ?? 'N/A')) ?></span></div>
                                <div class="row"><span class="label">Status</span><span class="value"><?= $safe((string)($invoice['status_label'] ?? 'N/A')) ?></span></div>
                                <div class="row"><span class="label">Currency</span><span class="value"><?= $safe((string)($invoice['currency_code'] ?? 'N/A')) ?></span></div>
                                <div class="row"><span class="label">Verification ID</span><span class="value"><?= $safe((string)($meta['transaction_id'] ?? 'N/A')) ?></span></div>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-head">Parties</div>
                            <div class="panel-body">
                                <div class="row"><span class="label">Seller</span><span class="value"><?= $safe((string)($from['company'] ?? 'N/A')) ?></span></div>
                                <div class="row"><span class="label">Buyer</span><span class="value"><?= $safe((string)($to['name'] ?? 'N/A')) ?></span></div>
                                <div class="row"><span class="label">Item</span><span class="value"><?= $safe((string)($line['description'] ?? 'N/A')) ?></span></div>
                                <div class="row"><span class="label">Quantity</span><span class="value"><?= $safe((string)($line['quantity'] ?? 'N/A')) ?></span></div>
                                <div class="row"><span class="label">Subtotal</span><span class="value"><?= $safe($money((float)($summary['subtotal'] ?? 0))) ?></span></div>
                                <div class="row"><span class="label">Total Paid</span><span class="value"><?= $safe($money((float)($summary['total'] ?? 0))) ?></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="panel full">
                        <div class="panel-head">Verification Notes</div>
                        <div class="panel-body">
                            <div class="row"><span class="label">Verified At</span><span class="value"><?= $safe((string)($verified_at ?? 'N/A')) ?></span></div>
                            <div class="row"><span class="label">Validation Result</span><span class="value">The invoice token and record match successfully.</span></div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="muted">If you suspect fraud, contact EquipManager support and share the Invoice Number and Verification ID.</div>
            </div>
        </div>
    </div>
</body>
</html>
