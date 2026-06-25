<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('invoice_decode_metadata')) {
    /**
     * Decode invoice metadata JSON safely.
     *
     * @param mixed $raw
     * @return array
     */
    function invoice_decode_metadata($raw)
    {
        if (is_array($raw)) {
            return $raw;
        }

        $decoded = json_decode((string)$raw, true);
        return is_array($decoded) ? $decoded : [];
    }
}

if (!function_exists('invoice_currency_symbol')) {
    /**
     * Return a printable currency symbol or prefix.
     *
     * @param string $currency
     * @return string
     */
    function invoice_currency_symbol($currency)
    {
        $code = strtoupper(trim((string)$currency));
        if ($code === 'USD') {
            return '$';
        }
        if ($code === 'EUR') {
            return 'EUR ';
        }
        if ($code === 'DKK') {
            return 'DKK ';
        }
        if ($code === 'GBP') {
            return 'GBP ';
        }

        return ($code !== '' ? $code . ' ' : '$');
    }
}

if (!function_exists('invoice_format_rental_type')) {
    /**
     * Normalize rental period label.
     *
     * @param mixed $rental_type
     * @return string
     */
    function invoice_format_rental_type($rental_type)
    {
        $value = strtolower(trim((string)$rental_type));
        $map = [
            '1' => 'Daily',
            '2' => 'Weekly',
            '3' => 'Monthly',
            '4' => 'Yearly',
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
        ];

        return isset($map[$value]) ? $map[$value] : 'N/A';
    }
}

if (!function_exists('invoice_can_download')) {
    /**
     * Determine whether invoice can be downloaded for the order state.
     *
     * @param object|array $order
     * @return bool
     */
    function invoice_can_download($order)
    {
        $field = static function ($key, $default = '') use ($order) {
            if (is_array($order)) {
                return array_key_exists($key, $order) ? $order[$key] : $default;
            }

            if (is_object($order) && isset($order->$key)) {
                return $order->$key;
            }

            return $default;
        };

        $payment_status = strtolower(trim((string)$field('paymentStatus')));
        $order_status = strtolower(trim((string)$field('orderStatus')));
        $rental_status = strtolower(trim((string)$field('rentalRequestStatus')));
        $sale_type = strtolower(trim((string)$field('saleType')));
        $is_workforce = !empty($field('workforcePaymentID'));
        $is_rental = $is_workforce || in_array($sale_type, ['rental', '0', '2'], true);

        $blocked_order_statuses = [
            'requested',
            'payment_pending',
            'rejected',
            'cancelled',
            'refunded',
        ];

        $blocked_rental_statuses = [
            'request_pending',
            'request_rejected',
            'rental_cancelled',
        ];

        if (in_array($order_status, $blocked_order_statuses, true)) {
            return false;
        }

        if ($is_rental && in_array($rental_status, $blocked_rental_statuses, true)) {
            return false;
        }

        $paid_payment_statuses = ['paid', 'succeeded', 'completed'];
        if (in_array($payment_status, $paid_payment_statuses, true)) {
            return true;
        }

        $paid_like_order_statuses = [
            'payment_secured',
            'payment_approved',
            'shipped',
            'pickup_ready',
            'delivered',
            'completed',
        ];

        $paid_like_rental_statuses = [
            'rental_active',
            'return_requested',
            'rental_overdue',
            'returned_by_renter',
            'received_by_owner',
            'under_review',
            'rental_completed',
        ];

        if (in_array($order_status, $paid_like_order_statuses, true)) {
            return true;
        }

        if ($is_rental && in_array($rental_status, $paid_like_rental_statuses, true)) {
            return true;
        }

        // Do not unlock invoice purely from intent creation; payment must be completed.
        return false;
    }
}

if (!function_exists('invoice_base64url_encode')) {
    /**
     * URL-safe base64 encode.
     *
     * @param string $binary
     * @return string
     */
    function invoice_base64url_encode($binary)
    {
        return rtrim(strtr(base64_encode((string)$binary), '+/', '-_'), '=');
    }
}

if (!function_exists('invoice_verification_signing_key')) {
    /**
     * Resolve signing key for stateless verification fallback.
     *
     * @return string Binary key
     */
    function invoice_verification_signing_key()
    {
        static $cached = null;
        if ($cached !== null) {
            return $cached;
        }

        $key = '';
        if (function_exists('getenv')) {
            $key = (string)getenv('INVOICE_VERIFY_SECRET');
            if ($key === '') {
                $key = (string)getenv('NODE_API_SECRET');
            }
            if ($key === '') {
                $key = (string)getenv('JWT_SECRET');
            }
        }

        $ci = function_exists('get_instance') ? get_instance() : null;
        if ($key === '' && $ci && isset($ci->config)) {
            $key = (string)$ci->config->item('encryption_key');
        }

        if ($key === '') {
            $key = 'equipmanager-invoice-verify-default-change-this';
        }

        $cached = hash('sha256', $key, true);
        return $cached;
    }
}

if (!function_exists('invoice_build_stateless_token')) {
    /**
     * Build a signed fallback token (used if DB columns are unavailable).
     *
     * @param int $order_id
     * @return string
     */
    function invoice_build_stateless_token($order_id)
    {
        $order_id = (int)$order_id;
        if ($order_id <= 0) {
            return '';
        }

        $signature = hash_hmac('sha256', 'invoice:' . $order_id, invoice_verification_signing_key(), true);
        return 'v1.' . $order_id . '.' . invoice_base64url_encode($signature);
    }
}

if (!function_exists('invoice_parse_stateless_token')) {
    /**
     * Validate fallback token and return order ID if valid.
     *
     * @param string $token
     * @return int
     */
    function invoice_parse_stateless_token($token)
    {
        $token = trim((string)$token);
        if (!preg_match('/^v1\.([0-9]+)\.([A-Za-z0-9\-_]+)$/', $token, $matches)) {
            return 0;
        }

        $order_id = (int)$matches[1];
        if ($order_id <= 0) {
            return 0;
        }

        $expected = invoice_base64url_encode(
            hash_hmac('sha256', 'invoice:' . $order_id, invoice_verification_signing_key(), true)
        );

        return hash_equals($expected, (string)$matches[2]) ? $order_id : 0;
    }
}

if (!function_exists('invoice_orders_has_verification_columns')) {
    /**
     * Determine whether invoice verification columns exist on orders table.
     *
     * @return bool
     */
    function invoice_orders_has_verification_columns()
    {
        static $has_columns = null;
        if ($has_columns !== null) {
            return $has_columns;
        }

        $ci = function_exists('get_instance') ? get_instance() : null;
        if (!$ci) {
            $has_columns = false;
            return $has_columns;
        }

        if (!isset($ci->db)) {
            $ci->load->database();
        }

        $col_token = $ci->db->query("SHOW COLUMNS FROM `orders` LIKE 'invoiceVerifyToken'");
        $col_issued = $ci->db->query("SHOW COLUMNS FROM `orders` LIKE 'invoiceVerifyIssuedAt'");
        $has_columns = ($col_token && $col_token->num_rows() > 0 && $col_issued && $col_issued->num_rows() > 0);

        return $has_columns;
    }
}

if (!function_exists('invoice_get_or_create_verification_token')) {
    /**
     * Return stable order verification token. Creates one if missing.
     *
     * @param int $order_id
     * @return string
     */
    function invoice_get_or_create_verification_token($order_id)
    {
        $order_id = (int)$order_id;
        if ($order_id <= 0) {
            return '';
        }

        $ci = function_exists('get_instance') ? get_instance() : null;
        if (!$ci) {
            return invoice_build_stateless_token($order_id);
        }

        if (!isset($ci->db)) {
            $ci->load->database();
        }

        if (!invoice_orders_has_verification_columns()) {
            return invoice_build_stateless_token($order_id);
        }

        $existing_row = $ci->db
            ->select('invoiceVerifyToken')
            ->from('orders')
            ->where('orderID', $order_id)
            ->limit(1)
            ->get()
            ->row_array();

        if (!$existing_row) {
            return invoice_build_stateless_token($order_id);
        }

        $existing = trim((string)($existing_row['invoiceVerifyToken'] ?? ''));
        if ($existing !== '') {
            return $existing;
        }

        for ($attempt = 0; $attempt < 4; $attempt++) {
            try {
                $token = bin2hex(random_bytes(24));
            } catch (\Exception $e) {
                log_message('error', 'Invoice token generation failed: ' . $e->getMessage());
                return invoice_build_stateless_token($order_id);
            }

            $ci->db->set('invoiceVerifyToken', $token);
            $ci->db->set('invoiceVerifyIssuedAt', date('Y-m-d H:i:s'));
            $ci->db->where('orderID', $order_id);
            $ci->db->where('(invoiceVerifyToken IS NULL OR invoiceVerifyToken = "")', null, false);
            $updated = $ci->db->update('orders');

            if ($updated && $ci->db->affected_rows() > 0) {
                return $token;
            }

            $current = $ci->db
                ->select('invoiceVerifyToken')
                ->from('orders')
                ->where('orderID', $order_id)
                ->limit(1)
                ->get()
                ->row_array();

            $current_token = trim((string)($current['invoiceVerifyToken'] ?? ''));
            if ($current_token !== '') {
                return $current_token;
            }
        }

        return invoice_build_stateless_token($order_id);
    }
}

if (!function_exists('invoice_build_verification_url')) {
    /**
     * Build absolute invoice verification URL.
     *
     * @param string $token
     * @return string
     */
    function invoice_build_verification_url($token)
    {
        $token = trim((string)$token);
        if ($token === '') {
            return '';
        }

        return 'https://equipmanager.dk/invoice/verify/' . rawurlencode($token);
    }
}

if (!function_exists('invoice_generate_qr_data_uri')) {
    /**
     * Generate QR code data URI for embedding in PDF.
     *
     * @param string $verification_url
     * @return string
     */
    function invoice_generate_qr_data_uri($verification_url)
    {
        $verification_url = trim((string)$verification_url);
        if ($verification_url === '') {
            return '';
        }

        if (!class_exists('Endroid\\QrCode\\Builder\\Builder')) {
            $autoload_path = defined('FCPATH') ? FCPATH . 'vendor/autoload.php' : '';
            if ($autoload_path !== '' && file_exists($autoload_path)) {
                require_once $autoload_path;
            }
        }

        // PNG QR requires GD in DOMPDF image renderer.
        if (!extension_loaded('gd')) {
            return '';
        }

        if (class_exists('Endroid\\QrCode\\Builder\\Builder')) {
            try {
                $result = \Endroid\QrCode\Builder\Builder::create()
                    ->writer(new \Endroid\QrCode\Writer\PngWriter())
                    ->data($verification_url)
                    ->encoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
                    ->errorCorrectionLevel(\Endroid\QrCode\ErrorCorrectionLevel::High)
                    ->size(420)
                    ->margin(12)
                    ->build();

                return $result->getDataUri();
            } catch (\Throwable $e) {
                log_message('error', 'Invoice QR generation failed: ' . $e->getMessage());
            }
        }

        return '';
    }
}

if (!function_exists('invoice_generate_qr_svg_data_uri')) {
    /**
     * Generate SVG QR data URI (works without GD and renders reliably in DOMPDF image pipeline).
     *
     * @param string $verification_url
     * @return string
     */
    function invoice_generate_qr_svg_data_uri($verification_url)
    {
        $verification_url = trim((string)$verification_url);
        if ($verification_url === '') {
            return '';
        }

        if (!class_exists('Endroid\\QrCode\\Builder\\Builder')) {
            $autoload_path = defined('FCPATH') ? FCPATH . 'vendor/autoload.php' : '';
            if ($autoload_path !== '' && file_exists($autoload_path)) {
                require_once $autoload_path;
            }
        }

        if (!class_exists('Endroid\\QrCode\\Builder\\Builder')) {
            return '';
        }

        try {
            $result = \Endroid\QrCode\Builder\Builder::create()
                ->writer(new \Endroid\QrCode\Writer\SvgWriter())
                ->data($verification_url)
                ->encoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
                ->errorCorrectionLevel(\Endroid\QrCode\ErrorCorrectionLevel::High)
                ->size(420)
                ->margin(12)
                ->build();

            $svg = (string)$result->getString();
            if ($svg === '') {
                return '';
            }

            return 'data:image/svg+xml;base64,' . base64_encode($svg);
        } catch (\Throwable $e) {
            log_message('error', 'Invoice QR SVG data URI generation failed: ' . $e->getMessage());
            return '';
        }
    }
}

if (!function_exists('invoice_fetch_order_for_verification')) {
    /**
     * Resolve invoice order payload by verification token.
     *
     * @param string $token
     * @return object|null
     */
    function invoice_fetch_order_for_verification($token)
    {
        $token = trim((string)$token);
        if ($token === '') {
            return null;
        }

        $ci = function_exists('get_instance') ? get_instance() : null;
        if (!$ci) {
            return null;
        }

        if (!isset($ci->db)) {
            $ci->load->database();
        }

        $select_clause = "
            o.orderID,
            o.equipmentPaymentID,
            o.workforcePaymentID,
            COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount,
            COALESCE(ep.commissionPercent, wp.commissionPercent) as commissionPercent,
            COALESCE(ep.commissionAmount, wp.commissionAmount) as commissionAmount,
            COALESCE(ep.netAmount, wp.netAmount) as netAmount,
            COALESCE(ep.currency, wp.currency, 'USD') as currency,
            COALESCE(NULLIF(ep.paymentStatus, ''), NULLIF(wp.paymentStatus, '')) as paymentStatus,
            COALESCE(NULLIF(ep.orderStatus, ''), NULLIF(wp.orderStatus, ''), NULLIF(wp.rentalRequestStatus, '')) as orderStatus,
            COALESCE(NULLIF(ep.rentalRequestStatus, ''), NULLIF(wp.rentalRequestStatus, '')) as rentalRequestStatus,
            COALESCE(NULLIF(ep.stripePaymentIntentID, ''), NULLIF(wp.stripePaymentIntentID, '')) as stripePaymentIntentID,
            COALESCE(NULLIF(ep.saleType, ''), 'rental') as saleType,
            COALESCE(ep.quantity, DATEDIFF(wp.rentalEndDate, wp.rentalStartDate) + 1) as quantity,
            COALESCE(ep.rentalStartDate, wp.rentalStartDate) as rentalStartDate,
            COALESCE(ep.rentalEndDate, wp.rentalEndDate) as rentalEndDate,
            COALESCE(ep.rentalType, wp.rentalType) as rentalType,
            COALESCE(ep.paymentMetadata, wp.paymentMetadata) as paymentMetadata,
            COALESCE(ep.createdAt, wp.createdAt) as createdAt,
            COALESCE(ep.updatedAt, wp.updatedAt) as updatedAt,
            COALESCE(e.equipName, wf.personName) as itemName,
            buyer.userName as buyerName,
            buyer.userEmail as buyerEmail,
            buyer.userPhone as buyerPhone,
            cd.companyName as sellerCompanyName,
            seller.userName as sellerContactName,
            seller.userEmail as sellerEmail,
            seller.userPhone as sellerPhone
        ";

        $query_builder = function () use ($ci, $select_clause) {
            return $ci->db->select($select_clause, false)
                ->from('orders o')
                ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
                ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
                ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
                ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
                ->join('users buyer', 'COALESCE(ep.buyerUserID, wp.buyerUserID) = buyer.userID', 'left')
                ->join('companydetail cd', 'COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) = cd.companyID', 'left')
                ->join('users seller', 'cd.userID = seller.userID', 'left');
        };

        $order = null;
        $matched_db_token = false;
        if (invoice_orders_has_verification_columns()) {
            $order = $query_builder()
                ->where('o.invoiceVerifyToken', $token)
                ->limit(1)
                ->get()
                ->row();
            $matched_db_token = (bool)$order;
        }

        if (!$order) {
            $order_id = invoice_parse_stateless_token($token);
            if ($order_id > 0) {
                $order = $query_builder()
                    ->where('o.orderID', $order_id)
                    ->limit(1)
                    ->get()
                    ->row();
            }
        }

        if (!$order) {
            return null;
        }

        // DB-backed token match is authoritative and non-guessable.
        if ($matched_db_token) {
            return $order;
        }

        // For stateless fallback tokens, keep lifecycle guard.
        return invoice_can_download($order) ? $order : null;
    }
}

if (!function_exists('invoice_build_payload')) {
    /**
     * Build invoice payload consumed by invoice PDF template.
     *
     * @param object|array $order
     * @return array
     */
    function invoice_build_payload($order)
    {
        $field = static function ($key, $default = '') use ($order) {
            if (is_array($order)) {
                return array_key_exists($key, $order) ? $order[$key] : $default;
            }

            if (is_object($order) && isset($order->$key)) {
                return $order->$key;
            }

            return $default;
        };

        $metadata = invoice_decode_metadata($field('paymentMetadata'));
        $quantity = max(1, (int)$field('quantity', 1));
        $gross_amount = (float)$field('grossAmount', 0);
        $delivery_amount = (float)($metadata['delivery_amount'] ?? $metadata['delivery_charge'] ?? 0);

        $explicit_subtotal = isset($metadata['equipment_amount']) ? (float)$metadata['equipment_amount'] : null;
        $subtotal = ($explicit_subtotal !== null)
            ? max(0.0, $explicit_subtotal)
            : max(0.0, $gross_amount - $delivery_amount);

        if ($subtotal <= 0 && $gross_amount > 0) {
            $subtotal = $gross_amount;
        }

        $unit_rate = $quantity > 0 ? ($subtotal / $quantity) : $subtotal;
        $sale_type = strtolower(trim((string)$field('saleType', 'rental')));
        $is_workforce = !empty($field('workforcePaymentID'));
        $is_rental = $is_workforce || in_array($sale_type, ['rental', '0', '2'], true);

        $currency = strtoupper(trim((string)$field('currency', 'USD')));
        if ($currency === '') {
            $currency = 'USD';
        }
        $currency_symbol = invoice_currency_symbol($currency);

        $issue_at = strtotime((string)$field('updatedAt'));
        if ($issue_at === false) {
            $issue_at = strtotime((string)$field('createdAt'));
        }
        if ($issue_at === false) {
            $issue_at = time();
        }

        $invoice_number = ($is_rental ? 'RNT' : 'SAL') . '-' . str_pad((string)$field('orderID', 0), 6, '0', STR_PAD_LEFT);
        $status = strtolower(trim((string)$field('orderStatus', 'pending')));
        if ($status === '') {
            $status = strtolower(trim((string)$field('rentalRequestStatus', 'pending')));
        }

        $payment_reference = trim((string)$field('stripePaymentIntentID', ''));
        if ($payment_reference !== '') {
            $order_number = strtoupper(preg_replace('/^pi_/i', 'TRX-', $payment_reference));
        } else {
            $order_number = 'ORD-' . str_pad((string)$field('orderID', 0), 6, '0', STR_PAD_LEFT);
        }

        $customer_name = trim((string)($metadata['delivery_name'] ?? $metadata['customer_name'] ?? $field('buyerName')));
        $customer_email = trim((string)($metadata['customer_email'] ?? $field('buyerEmail')));
        $customer_phone = trim((string)($metadata['customer_phone'] ?? $field('buyerPhone')));

        $address_parts = [];
        foreach (['delivery_street', 'delivery_city', 'delivery_postal', 'delivery_country'] as $part_key) {
            $part_value = trim((string)($metadata[$part_key] ?? ''));
            if ($part_value !== '') {
                $address_parts[] = $part_value;
            }
        }
        $customer_address = implode(', ', $address_parts);

        $rental_type_label = invoice_format_rental_type($field('rentalType'));
        $rental_period = '';
        $rental_start_date = '';
        $rental_end_date = '';
        if (!empty($field('rentalStartDate')) || !empty($field('rentalEndDate'))) {
            if (!empty($field('rentalStartDate'))) {
                $rental_start_date = date('d M Y', strtotime((string)$field('rentalStartDate')));
            }
            if (!empty($field('rentalEndDate'))) {
                $rental_end_date = date('d M Y', strtotime((string)$field('rentalEndDate')));
            }
            $rental_period = ($rental_start_date !== '' ? $rental_start_date : 'N/A') . ' to ' . ($rental_end_date !== '' ? $rental_end_date : 'N/A');
        }

        $line_name = trim((string)$field('itemName', $is_rental ? 'Rental Service' : 'Equipment'));
        $line_description = $line_name;
        if ($is_rental && $rental_period !== '') {
            $line_description .= ' | Period: ' . $rental_period;
        }
        if ($is_rental && $rental_type_label !== 'N/A') {
            $line_description .= ' | Plan: ' . $rental_type_label;
        }

        $service_fee = (float)$field('commissionAmount', 0);
        $insurance_amount = (float)($metadata['insurance_amount'] ?? 0);

        // Prefer explicit tax in metadata, otherwise derive if gross includes fee+tax.
        $tax_amount = 0.0;
        if (isset($metadata['tax_amount'])) {
            $tax_amount = (float)$metadata['tax_amount'];
        } elseif (isset($metadata['vat_amount'])) {
            $tax_amount = (float)$metadata['vat_amount'];
        } else {
            $derived_tax = $gross_amount - ($subtotal + $delivery_amount + $service_fee + $insurance_amount);
            if ($derived_tax > 0) {
                $tax_amount = $derived_tax;
            }
        }
        $tax_amount = max(0.0, $tax_amount);

        $summary_total = isset($metadata['total_amount']) ? (float)$metadata['total_amount'] : $gross_amount;
        if ($summary_total <= 0 && $gross_amount > 0) {
            $summary_total = $gross_amount;
        }

        $order_id = (int)$field('orderID', 0);
        $verification_token = invoice_get_or_create_verification_token($order_id);
        $verification_url = invoice_build_verification_url($verification_token);
        $verification_qr_svg_data_uri = invoice_generate_qr_svg_data_uri($verification_url);
        $verification_qr_data_uri = invoice_generate_qr_data_uri($verification_url);

        $verification_id = trim((string)($metadata['verification_id'] ?? ''));
        if ($verification_id === '' && $verification_token !== '') {
            $verification_id = 'EM-VER-' . strtoupper(substr(hash('sha256', $verification_token), 0, 10));
        }
        if ($verification_id === '') {
            $verification_id = 'EM-VER-' . substr(md5((string)$field('orderID', 0) . (string)$field('stripePaymentIntentID', '')), 0, 6);
        }

        return [
            'title' => $is_rental ? 'RENTAL INVOICE' : 'SALES INVOICE',
            'subtitle' => $is_rental
                ? 'Transaction Facilitated via EquipManager Platform'
                : 'Transaction Facilitated via EquipManager Marketplace',
            'invoice_number' => $invoice_number,
            'order_number' => $order_number,
            'issued_on' => date('d M Y', $issue_at),
            'status_label' => strtoupper(str_replace('_', ' ', $status)),
            'currency' => $currency,
            'currency_code' => $currency,
            'currency_symbol' => $currency_symbol,
            'from' => [
                'company' => trim((string)$field('sellerCompanyName', 'Seller Company')),
                'cvr' => trim((string)$field('sellerCVR', trim((string)$field('sellerRegistrationNumber', '')))),
                'address' => trim((string)$field('sellerAddress', '')),
                'contact' => trim((string)$field('sellerContactName', '')),
                'email' => trim((string)$field('sellerEmail', '')),
                'phone' => trim((string)$field('sellerPhone', '')),
            ],
            'to' => [
                'name' => ($customer_name !== '' ? $customer_name : trim((string)$field('buyerName', 'Buyer'))),
                'email' => $customer_email,
                'phone' => $customer_phone,
                'address' => $customer_address,
            ],
            'line' => [
                'description' => $line_description,
                'quantity' => $quantity,
                'rate' => $unit_rate,
                'amount' => $subtotal,
                'category' => trim((string)$field('itemCategory', 'Equipment')),
                'condition' => trim((string)$field('itemCondition', 'New')),
            ],
            'summary' => [
                'subtotal' => $subtotal,
                'delivery' => $delivery_amount,
                'fee' => $service_fee,
                'insurance' => $insurance_amount,
                'tax' => $tax_amount,
                'total' => $summary_total,
            ],
            'meta' => [
                'transaction_id' => $verification_id,
                'rental_start_date' => $rental_start_date,
                'rental_end_date' => $rental_end_date,
                'payment_reference' => $payment_reference,
                'fulfillment_method' => ((int)($metadata['delivery_method'] ?? 0) === 2) ? 'Delivery' : 'Pickup',
                'rental_period' => $rental_period,
                'rental_type' => $rental_type_label,
                'verification_url' => $verification_url,
                'verification_qr_svg_data_uri' => $verification_qr_svg_data_uri,
                'verification_qr_data_uri' => $verification_qr_data_uri,
            ],
            'commission' => [
                'percent' => (float)$field('commissionPercent', 0),
                'amount' => (float)$field('commissionAmount', 0),
            ],
            'notes' => trim((string)($metadata['delivery_notes'] ?? '')),
        ];
    }
}
