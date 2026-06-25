<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$total_pages = ($per_page ?? 0) > 0 ? (int)ceil(($total ?? 0) / $per_page) : 1;
?>

<div class="page-kicker">Employee Workspace</div>
<h1 class="page-title">Notifications</h1>
<p class="page-subtitle">Project, tool assignment, and workflow updates for your employee account appear here.</p>

<section class="content-card">
    <div class="card-heading">
        <h2>All Notifications</h2>
        <button type="button" id="mark-all-read-btn" class="btn-brand">Mark All Read</button>
    </div>

    <?php if (empty($notifications)): ?>
        <div class="empty-state">No notifications yet.</div>
    <?php else: ?>
        <div class="data-list">
            <?php foreach ($notifications as $n): ?>
                <?php
                $is_unread = ((int)$n->isRead === 0);
                $action = !empty($n->actionUrl) ? $n->actionUrl : site_url('employee/dashboard');
                ?>
                <a href="<?= htmlspecialchars($action) ?>" class="data-row notification-row<?= $is_unread ? ' is-unread' : '' ?>" data-notif-id="<?= (int)$n->notificationID ?>">
                    <div class="row-title">
                        <?= htmlspecialchars($n->notificationTitle) ?>
                        <?php if ($is_unread): ?><span class="badge-soft" style="margin-left:8px;">New</span><?php endif; ?>
                    </div>
                    <div class="row-meta"><?= htmlspecialchars($n->notificationBody) ?></div>
                    <div class="row-meta" style="margin-top:6px;">
                        <?= date('d M Y, h:i A', strtotime($n->createdAt)) ?>
                        <button type="button" class="btn btn-link btn-sm text-danger p-0 ms-3" data-delete-id="<?= (int)$n->notificationID ?>">Delete</button>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <div style="margin-top:16px; display:flex; gap:8px; flex-wrap:wrap;">
                <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                    <a href="<?= site_url('notifications?page=' . $p) ?>" class="btn btn-sm <?= $p === (int)$current_page ? 'btn-primary' : 'btn-outline-secondary' ?>"><?= $p ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</section>

<style>
    .notification-row {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .notification-row.is-unread {
        border-color: #cfe9de;
        background: #f4fbf8;
    }
</style>

<script>
    (function () {
        var csrfName = <?= json_encode($csrf_name ?? '') ?>;
        var csrfHash = <?= json_encode($csrf_hash ?? '') ?>;

        function withCsrf(payload) {
            var data = payload || {};
            if (csrfName && csrfHash) {
                data[csrfName] = csrfHash;
            }
            return data;
        }

        $(document).on('click', '[data-notif-id]', function (e) {
            var target = e.target;
            if (target && target.closest('[data-delete-id]')) {
                return;
            }
            var id = $(this).data('notif-id');
            if (!id) return;
            $.post('<?= site_url('notifications/api_mark_read') ?>', withCsrf({ notification_id: id }));
        });

        $('#mark-all-read-btn').on('click', function () {
            $.post('<?= site_url('notifications/api_mark_all_read') ?>', withCsrf({}), function () {
                window.location.reload();
            });
        });

        $(document).on('click', '[data-delete-id]', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var id = $(this).data('delete-id');
            var row = $(this).closest('.notification-row');
            $.post('<?= site_url('notifications/api_delete') ?>', withCsrf({ notification_id: id }), function (res) {
                if (res && res.success) {
                    row.fadeOut(150, function () { $(this).remove(); });
                }
            }, 'json');
        });
    })();
</script>
