<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Environment Configuration for Chat System
|--------------------------------------------------------------------------
|
| JWT Secret and Node.js Server URL configuration
| IMPORTANT: These values must match in both PHP and Node.js
|
*/

// JWT Secret Key (MUST match Node.js server)
// SECURITY: Do NOT hardcode this value here.
// Set JWT_SECRET in phpenv.php (see phpenv.php.example). It must match the
// JWT_SECRET in chat-server/.env on the Node.js side.
if (!getenv('JWT_SECRET')) {
    log_message('error', 'SECURITY: JWT_SECRET environment variable is not set. Set it in phpenv.php immediately.');
}

// Auto-detect request scheme/host for building PHP API URL and non-local defaults.
$protocol = 'http';
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    $protocol = 'https';
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $protocol = 'https';
}

// Get hostname (reverse proxies may pass X-Forwarded-Host)
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
}

// Remove port from host if present
$host_without_port = explode(':', $host)[0];

// Detect base path (handles subdirectories like /equipmanager)
$script_name = $_SERVER['SCRIPT_NAME'] ?? '';
$path = preg_replace('@/index\\.php/*@', '', $script_name);
$path = rtrim($path, '/');
if (empty($path) || $path === '/') {
    $path = '';
}

// PHP API URL - always derive from current request host
$php_api_url = $protocol . '://' . $host . $path;

// Node.js Chat Server URL
// If CHAT_SERVER_URL env var is set (production), use it directly.
// Otherwise auto-detect:
//   - localhost -> localhost:3000
//   - non-local -> same host over 80/443 (reverse-proxy friendly)
if (getenv('CHAT_SERVER_URL')) {
    $node_server_url = rtrim(getenv('CHAT_SERVER_URL'), '/');
} else {
    if ($host_without_port === 'localhost' || $host_without_port === '127.0.0.1') {
        $node_server_url = 'http://localhost:3000';
    } else {
        $node_server_url = $protocol . '://' . $host_without_port;
    }
}

putenv('PHP_API_URL=' . $php_api_url);
putenv('NODE_SERVER_URL=' . $node_server_url);

// Make URLs available to JavaScript views
if (!defined('CHAT_PHP_API_URL')) {
    define('CHAT_PHP_API_URL', $php_api_url);
}
if (!defined('CHAT_NODE_SERVER_URL')) {
    define('CHAT_NODE_SERVER_URL', $node_server_url);
}
