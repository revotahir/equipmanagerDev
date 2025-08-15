<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.hostinger.com'; // Change if different
$config['smtp_user']   = 'order@mymetrofoods.com';
$config['smtp_pass']   = 'Qw4hddqcrg!@#$%'; // Store securely!
$config['smtp_port']   = 465;
$config['smtp_crypto'] = 'ssl'; // Use 'tls' for port 587
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['wordwrap']    = TRUE;
$config['newline']     = "\r\n";
