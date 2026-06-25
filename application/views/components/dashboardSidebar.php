<!-- Dashboard Sidebar Component -->
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
    }

    .dashboard-sidebar {
        width: 260px;
        min-width: 260px;
        flex: 0 0 260px;
        background-color: var(--card-bg);
        border-right: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        padding: 0;
        box-shadow: var(--shadow);
        border-radius: 12px;
        overflow: hidden;
    }

    .sidebar-profile {
        padding: 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: var(--primary-brand);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        overflow: hidden;
        color: var(--text-light);
        font-size: 32px;
        font-weight: bold;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-info {
        width: 100%;
    }

    .profile-name {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 4px;
        font-family: "Manrope", sans-serif;
    }

    .profile-email {
        font-size: 13px;
        color: var(--text-secondary);
        margin-bottom: 16px;
        word-break: break-word;
        font-family: "Manrope", sans-serif;
    }

    .logout-btn {
        background-color: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        width: 100%;
        font-family: "Manrope", sans-serif;
    }

    .logout-btn:hover {
        background-color: #f0f0f0;
        border-color: var(--text-secondary);
        color: var(--text-primary);
    }

    .sidebar-nav {
        list-style: none;
        padding: 0;
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 24px 0;
        margin: 0;
    }

    .sidebar-mobile-toggle {
        display: none;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin: 14px 18px 0;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: #fff;
        color: var(--text-primary);
        font-size: 13px;
        font-weight: 700;
        padding: 10px 12px;
        cursor: pointer;
        font-family: "Manrope", sans-serif;
    }

    .profile-link-btn {
        background-color: #f8fafc;
        border: 1px solid var(--border-color);
        color: var(--primary-brand);
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        font-family: "Manrope", sans-serif;
        font-weight: 700;
    }

    .profile-link-btn:hover {
        background: #eef2f7;
        color: var(--primary-brand);
    }

    .sidebar-mobile-toggle i {
        font-size: 15px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 24px;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 14px;
        font-weight: 500;
        font-family: "Manrope", sans-serif;
    }

    .nav-item:hover {
        background-color: #f9f9f9;
    }

    .nav-item.active {
        background-color: var(--primary-brand);
        color: var(--text-light);
    }

    @media (max-width: 1024px) {
        .dashboard-sidebar {
            width: 100%;
            min-width: 0;
            flex: 1 1 auto;
            border-right: none;
            border-bottom: 1px solid var(--border-color);
            flex-direction: column;
            align-items: stretch;
            padding: 14px;
            border-radius: 12px;
            gap: 10px;
        }

        .sidebar-profile {
            border-bottom: none;
            padding: 0;
            text-align: left;
            flex-direction: row;
            align-items: center;
            gap: 12px;
            width: 100%;
            justify-content: space-between;
        }

        .profile-avatar {
            width: 52px;
            height: 52px;
            margin-bottom: 0;
        }

        .profile-name,
        .profile-email {
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-email {
            margin-bottom: 0;
            font-size: 12px;
        }

        .logout-btn {
            width: auto;
            min-width: 88px;
            padding: 8px 10px;
            font-size: 12px;
            flex-shrink: 0;
        }

        .profile-link-btn {
            width: auto;
            min-width: 88px;
            padding: 8px 10px;
            font-size: 12px;
            margin-bottom: 0;
            margin-right: 8px;
        }

        .sidebar-mobile-toggle {
            display: inline-flex;
        }

        .sidebar-nav {
            display: none;
            flex-direction: column;
            padding: 4px 0 0;
            border-top: 1px solid var(--border-color);
            margin-top: 2px;
        }

        .dashboard-sidebar.nav-open .sidebar-nav {
            display: flex;
        }

        .nav-item {
            border-radius: 8px;
            margin: 2px 0;
            padding: 11px 12px;
        }
    }

    @media (max-width: 640px) {
        .sidebar-profile {
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .profile-info {
            min-width: 0;
            flex: 1;
        }

        .logout-btn {
            width: 100%;
            margin-top: 8px;
        }

        .profile-link-btn {
            width: 100%;
            margin-top: 8px;
            margin-right: 0;
        }
    }
</style>

<?php $is_employee_nav = !empty($employee_nav); ?>
<aside class="dashboard-sidebar">
    <!-- Profile Section -->
    <div class="sidebar-profile">
        <div class="profile-avatar">
            <?php 
                $login_data = $this->session->userdata('loginData');
                $user_name = isset($login_data['userName']) ? $login_data['userName'] : 'User';
                $user_email = isset($login_data['userEmail']) ? $login_data['userEmail'] : 'user@equipmanager.com';
                $user_id = isset($login_data['userID']) ? (int)$login_data['userID'] : 0;
                echo strtoupper(substr($user_name, 0, 2));
            ?>
        </div>
        <div class="profile-info">
            <div class="profile-name"><?= htmlspecialchars($user_name) ?></div>
            <div class="profile-email"><?= htmlspecialchars($user_email) ?></div>
        </div>
        <?php if (!$is_employee_nav && $user_id > 0): ?>
            <a class="profile-link-btn" href="<?= base_url('user-profile/' . $user_id . '#reviews') ?>">My Profile</a>
        <?php endif; ?>
        <button class="logout-btn" onclick="logoutUser()">Logout</button>
    </div>

    <button type="button" class="sidebar-mobile-toggle" id="dashboardSidebarToggle" onclick="toggleDashboardSidebarNav()">
        <i class="bi bi-list"></i>
        <span>Menu</span>
    </button>

    <?php
        $nav_items = $is_employee_nav ? [
            ['key' => 'employee_dashboard', 'url' => 'employee/dashboard', 'icon' => 'bi-house-door', 'label' => 'Dashboard'],
            ['key' => 'employee_projects', 'url' => 'employee/projects', 'icon' => 'bi-kanban', 'label' => 'Projects'],
            ['key' => 'employee_equipment', 'url' => 'employee/equipment', 'icon' => 'bi-tools', 'label' => 'Equipment'],
            ['key' => 'employee_profile', 'url' => 'employee/profile', 'icon' => 'bi-person-badge', 'label' => 'Profile'],
            ['key' => 'employee_messages', 'url' => 'employee/messages', 'icon' => 'bi-headset', 'label' => 'Contact Admin'],
            ['key' => 'employee_notifications', 'url' => 'notifications', 'icon' => 'bi-bell', 'label' => 'Notifications'],
        ] : [
            ['key' => 'dashboard', 'url' => 'user-dashboard', 'icon' => 'bi-house-door', 'label' => 'Dashboard'],
            ['key' => 'orders', 'url' => 'orders', 'icon' => 'bi-bag', 'label' => 'Orders'],
            ['key' => 'reviews', 'url' => 'dashboard/reviews', 'icon' => 'bi-star', 'label' => 'Reviews'],
            ['key' => 'chats', 'url' => 'chats', 'icon' => 'bi-chat-dots', 'label' => 'Chats'],
            ['key' => 'notifications', 'url' => 'notifications', 'icon' => 'bi-bell', 'label' => 'Notifications'],
            ['key' => 'settings', 'url' => 'settings', 'icon' => 'bi-gear', 'label' => 'Settings'],
        ];
    ?>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <?php foreach ($nav_items as $item) : ?>
            <li class="nav-item <?= ($active_page ?? '') === $item['key'] ? 'active' : '' ?>" onclick="navigateTo('<?= $item['url'] ?>')">
                <i class="bi <?= $item['icon'] ?>"></i>
                <?= htmlspecialchars($item['label']) ?>
            </li>
        <?php endforeach; ?>
    </nav>
</aside>

<script>
    function logoutUser() {
        AppDialog.confirm('Are you sure you want to logout?', {
            title: 'Logout',
            okText: 'Logout'
        }).then(function(confirmed) {
            if (confirmed) {
                window.location.href = '<?= base_url('logout') ?>';
            }
        });
    }

    function navigateTo(page) {
        window.location.href = '<?= base_url() ?>' + page;
    }

    function toggleDashboardSidebarNav() {
        const sidebar = document.querySelector('.dashboard-sidebar');
        if (sidebar) {
            sidebar.classList.toggle('nav-open');
        }
    }
</script>
