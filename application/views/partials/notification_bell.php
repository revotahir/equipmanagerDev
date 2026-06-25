<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Notification Bell Widget — include in header -->
<li class="nav-item dropdown mr-2" id="notification-bell-container">
    <a class="nav-link position-relative" href="#" role="button"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
       id="notification-bell-btn" title="Notifications">
        <i class="fas fa-bell fa-lg"></i>
        <span class="badge badge-danger badge-pill notification-badge d-none" id="notif-unread-badge">0</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right notification-dropdown shadow" id="notification-dropdown">
        <div class="dropdown-header d-flex justify-content-between align-items-center px-3 py-2">
            <span class="font-weight-bold">Notifications</span>
            <a href="#" class="small text-muted" id="notif-mark-all-read">Mark all read</a>
        </div>
        <div class="dropdown-divider m-0"></div>
        <div id="notification-list-container" style="max-height:360px;overflow-y:auto;">
            <div class="text-center text-muted py-3 small" id="notif-empty-state">
                <i class="far fa-bell-slash mb-1 d-block"></i> No notifications
            </div>
        </div>
        <div class="dropdown-divider m-0"></div>
        <a class="dropdown-item text-center small py-2" href="<?= site_url('notifications') ?>">
            View all notifications
        </a>
    </div>
</li>

<style>
.notification-badge {
    position: absolute;
    top: 2px;
    right: 2px;
    font-size: 10px;
    min-width: 16px;
    height: 16px;
    line-height: 16px;
    padding: 0 4px;
}
.notification-dropdown { width: 360px; }
.notif-item { border-left: 3px solid transparent; transition: background 0.15s; }
.notif-item.unread { border-left-color: #007bff; background: #f0f7ff; }
.notif-item:hover { background: #f8f9fa !important; }
.notif-item .notif-title { font-size: 13px; font-weight: 600; }
.notif-item .notif-body { font-size: 12px; color: #555; }
.notif-item .notif-time { font-size: 11px; color: #aaa; }
</style>

<script>
(function() {
    var pollInterval = null;

    function fetchUnreadCount() {
        $.getJSON('<?= site_url("notifications/api_get_unread_count") ?>', function(data) {
            var badge = $('#notif-unread-badge');
            if (data.count > 0) {
                badge.text(data.count > 99 ? '99+' : data.count).removeClass('d-none');
            } else {
                badge.addClass('d-none');
            }
        });
    }

    function fetchRecentNotifications() {
        $.getJSON('<?= site_url("notifications/api_get_recent") ?>', function(data) {
            if (!data.success) return;
            var $container = $('#notification-list-container');
            $container.empty();

            if (data.notifications.length === 0) {
                $container.html('<div class="text-center text-muted py-3 small"><i class="far fa-bell-slash mb-1 d-block"></i> No notifications</div>');
                return;
            }

            $.each(data.notifications, function(i, n) {
                var unreadClass = n.isRead == 0 ? 'unread' : '';
                var timeAgo = formatTimeAgo(n.createdAt);
                var url     = n.actionUrl || '#';

                var html = '<a class="dropdown-item notif-item ' + unreadClass + ' px-3 py-2" ' +
                           'href="' + url + '" data-id="' + n.notificationID + '">' +
                           '<div class="notif-title">' + escapeHtml(n.notificationTitle) + '</div>' +
                           '<div class="notif-body">' + escapeHtml(n.notificationBody.substring(0, 80)) + (n.notificationBody.length > 80 ? '…' : '') + '</div>' +
                           '<div class="notif-time">' + timeAgo + '</div>' +
                           '</a>';
                $container.append(html);
            });
        });
    }

    function formatTimeAgo(dateStr) {
        var now  = new Date();
        var date = new Date(dateStr.replace(' ', 'T'));
        var diff = Math.floor((now - date) / 1000);
        if (diff < 60)    return 'Just now';
        if (diff < 3600)  return Math.floor(diff/60) + 'm ago';
        if (diff < 86400) return Math.floor(diff/3600) + 'h ago';
        return Math.floor(diff/86400) + 'd ago';
    }

    function escapeHtml(s) {
        return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    // Poll every 30 seconds for unread count
    fetchUnreadCount();
    pollInterval = setInterval(fetchUnreadCount, 30000);

    // Load notifications when dropdown opens
    $('#notification-bell-btn').on('click', function() {
        fetchRecentNotifications();
    });

    // Mark single notification as read on click
    $(document).on('click', '.notif-item', function(e) {
        var id = $(this).data('id');
        if (id) {
            $.post('<?= site_url("notifications/api_mark_read") ?>', {notification_id: id});
            $(this).removeClass('unread');
        }
    });

    // Mark all as read
    $('#notif-mark-all-read').on('click', function(e) {
        e.preventDefault();
        $.post('<?= site_url("notifications/api_mark_all_read") ?>', function() {
            $('.notif-item').removeClass('unread');
            $('#notif-unread-badge').addClass('d-none');
        });
    });
})();
</script>
