<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en" class="minimal-theme">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?=base_url()?>assets/images/logo-icon.png" type="image/png" />
    <link href="<?=base_url()?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <title>Issue Chat - Equip Manager</title>
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
            --table-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        }

        main.page-content {
            padding-top: 8px;
        }

        .chat-header-panel {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .chat-meta {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .chat-interface-container {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--table-shadow);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            height: min(72vh, 700px);
            max-height: min(72vh, 700px);
            min-height: 460px;
        }

        @media (max-width: 768px) {
            .chat-header-panel {
                flex-direction: column;
                align-items: flex-start;
            }

            .chat-interface-container {
                height: calc(100vh - 230px);
                max-height: calc(100vh - 230px);
                min-height: 400px;
            }
        }

        @media (max-width: 550px) {
            .chat-interface-container {
                height: calc(100vh - 200px);
                max-height: calc(100vh - 200px);
                min-height: 360px;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php $this->load->view('components/header'); ?>
    <?php $this->load->view('components/sidemenu'); ?>

    <main class="page-content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= htmlspecialchars($this->session->flashdata('success')) ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($this->session->flashdata('error')) ?></div>
        <?php endif; ?>

        <div class="chat-header-panel">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <a href="<?= base_url('superadmin/issue-chats') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <strong>Order #<?= (int)($issue->orderID ?? $chat->orderID ?? 0) ?> • Issue #<?= (int)($issue->issueID ?? 0) ?></strong>
                </div>
            </div>
            <div>
                <?php if (($chat->chatStatus ?? '') === 'open' && !in_array($issue->issueStatus ?? '', ['resolved','closed'], true)): ?>
                    <a href="<?= base_url('superadmin/issue_detail/' . (int)($issue->issueID ?? 0)) ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-check2-circle"></i> Resolve Issue
                    </a>
                <?php else: ?>
                    <span class="badge bg-secondary">Chat Closed</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="chat-interface-container">
            <?php $this->load->view('chats/view', [
                'chat' => $chat,
                'messages' => $messages,
                'current_user_id' => $current_user_id,
                'user_role' => $user_role,
                'jwt_token' => $jwt_token,
            ]); ?>
        </div>
    </main>

    <div class="overlay nav-toggle-icon"></div>
</div>

<script src="<?=base_url()?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
<script src="<?=base_url()?>assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="<?=base_url()?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="<?=base_url()?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="<?=base_url()?>assets/js/app.js"></script>
</body>
</html>
