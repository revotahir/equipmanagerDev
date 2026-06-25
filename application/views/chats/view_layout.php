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
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    
    <title>Chat - Equip Manager</title>
    
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
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            --table-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        }

        html, body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        body {
            background-color: var(--body-bg);
            font-family: "Manrope", sans-serif;
        }

        /* Main content area */
        .main-wrapper {
            padding: 0 40px;
            max-width: 1600px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
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
            min-width: 0;
            box-sizing: border-box;
        }

        .chat-interface-container {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--table-shadow);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            width: 100%;
            max-width: 1120px;
            margin: 0 auto;
            height: min(72vh, 700px);
            max-height: min(72vh, 700px);
            min-height: 460px;
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                flex-direction: column;
            }

            .dashboard-content {
                padding: 24px;
            }

            .main-wrapper {
                padding: 0 16px;
            }

            .chat-interface-container {
                max-width: 100%;
                height: min(70vh, 640px);
                max-height: min(70vh, 640px);
                min-height: 430px;
            }
        }

        @media (max-width: 768px) {
            .main-wrapper {
                padding: 0 12px;
            }

            .dashboard-content {
                padding: 16px;
            }

            .chat-interface-container {
                max-width: 100%;
                height: calc(100vh - 230px);
                max-height: calc(100vh - 230px);
                min-height: 400px;
            }
        }

        @media (max-width: 480px) {
            .main-wrapper {
                padding: 0 8px;
            }

            .dashboard-content {
                padding: 12px;
            }

            .chat-interface-container {
                max-width: 100%;
                height: calc(100vh - 200px);
                max-height: calc(100vh - 200px);
                min-height: 360px;
            }
        }

        /* Stability overrides: keep composer visible and avoid overflow clipping */
        .chat-interface-container {
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .chat-interface-container .chat-view-root {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            height: 100%;
        }

        .chat-interface-container .chat-orders-strip {
            max-height: 104px;
            overflow-y: auto;
            flex: 0 0 auto;
        }

        .chat-interface-container .messages-area {
            flex: 1 1 auto;
            min-height: 0 !important;
            height: 0 !important;
            overflow-y: auto;
        }

        .chat-interface-container .chat-input-area,
        .chat-interface-container .order-completed-banner {
            flex: 0 0 auto;
            z-index: 2;
        }

        .chat-interface-container .chat-input-area {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            min-height: 72px;
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
        }
    </style>
</head>
<body>
    <!-- Website Header -->
    <?php $this->load->view('components/websiteHeader'); ?>

    <div class="main-wrapper">
        <!-- Main Dashboard Container -->
        <div class="dashboard-container">
            <!-- Dashboard Sidebar Component -->
            <?php $this->load->view('components/dashboardSidebar', [
                'active_page' => 'chats',
                'employee_nav' => !empty($employee_nav)
            ]); ?>

            <!-- Main Content -->
            <main class="dashboard-content">
                <div class="chat-interface-container">
                    <?php 
                    // Prepare data for view.php
                    $view_data = array(
                        'chat' => isset($chat) ? $chat : null,
                        'messages' => isset($messages) ? $messages : array(),
                        'chat_orders' => isset($chat_orders) ? $chat_orders : array(),
                        'current_user_id' => isset($current_user_id) ? $current_user_id : null,
                        'user_role' => isset($user_role) ? $user_role : null,
                        'jwt_token' => isset($jwt_token) ? $jwt_token : null,
                    );
                    $this->load->view('chats/view', $view_data); 
                    ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Website Footer -->
    <?php $this->load->view('components/websiteFooter'); ?>

    <!-- Scripts -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
</body>
</html>
