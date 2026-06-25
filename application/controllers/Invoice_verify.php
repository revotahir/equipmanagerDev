<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_verify extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'invoice']);
    }

    /**
     * Public invoice verification endpoint used by QR code.
     *
     * @param string $token
     * @return void
     */
    public function index($token = '')
    {
        $token = trim((string)$token);

        $data = [
            'is_valid' => false,
            'message' => 'The invoice verification link is invalid or incomplete.',
            'invoice' => null,
            'verified_at' => date('d M Y H:i'),
        ];

        if ($token === '' || !preg_match('/^[A-Za-z0-9\-_.]{20,200}$/', $token)) {
            $this->load->view('invoices/verify_invoice', $data);
            return;
        }

        $order = invoice_fetch_order_for_verification($token);
        if (!$order) {
            $data['message'] = 'This invoice could not be verified. It may be invalid, tampered, or unavailable.';
            $this->load->view('invoices/verify_invoice', $data);
            return;
        }

        $invoice = invoice_build_payload($order);
        $data['is_valid'] = true;
        $data['message'] = 'Invoice verified successfully. This document is genuine.';
        $data['invoice'] = $invoice;

        $this->load->view('invoices/verify_invoice', $data);
    }
}
