<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.simply.com';
$config['smtp_user']   = 'system@equipmanager.dk'; 
$config['smtp_pass']   = 'EMsys!2026#Tahir482'; 
$config['smtp_port']   = 587;
$config['smtp_crypto'] = 'tls';
$config['smtp_timeout']= 15;
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['wordwrap']    = TRUE;
$config['crlf']        = "\r\n";
$config['newline']     = "\r\n";
$config['from_email']  = 'system@equipmanager.dk';
$config['from_name']   = 'Equip Manager';
