<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Reviews - EquipManager</title>
    <link rel="icon" href="<?= base_url() ?>assets/images/logo-icon.png" type="image/png" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/style.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/header.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/footer.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/resopnsive.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <style>
        body { background:#F5F6F8; font-family:"Manrope",sans-serif; }
        .main-wrapper { padding: 0 40px; max-width:1600px; margin:0 auto; }
        .dashboard-container { display:flex; gap:0; margin:30px 0; }
        .dashboard-content { flex:1; padding:40px; }
        .page-card { background:#fff; border:1px solid #E5E7EB; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,.05); }
        .page-head { padding:24px; border-bottom:1px solid #E5E7EB; }
        .filter-tabs { display:flex; gap:10px; padding:18px 24px; border-bottom:1px solid #E5E7EB; }
        .filter-btn { text-decoration:none; padding:9px 14px; border-radius:8px; border:1px solid #d6dbe3; color:#13372E; font-weight:700; font-size:13px; display:inline-flex; align-items:center; justify-content:center; min-height:44px; line-height:1.2; }
        .filter-btn.active { background:#13372E; color:#fff; border-color:#13372E; }
        .rows { padding:12px 20px 20px; }
        .review-row { border:1px solid #edf2f7; border-radius:10px; padding:14px; background:#fff; margin-top:10px; }
        .top { display:flex; justify-content:space-between; gap:10px; flex-wrap:wrap; }
        .meta { color:#6B7280; font-size:13px; }
        .badge { font-size:12px; font-weight:700; border-radius:999px; padding:5px 10px; background:#ecfdf3; color:#166534; }
        .badge.done { background:#eff6ff; color:#1d4ed8; }
        .star-display { color:#f59e0b; letter-spacing:1px; font-size:15px; font-weight:700; }
        .empty { padding:24px; color:#6B7280; text-align:center; }
        .btn-review { margin-top:10px; display:inline-flex; align-items:center; justify-content:center; background:#13372E; color:#fff; text-decoration:none; padding:10px 14px; border-radius:10px; font-weight:700; font-size:14px; line-height:1; min-height:44px; }
    </style>
</head>
<body>
<?php $this->load->view('components/websiteHeader'); ?>
<div class="main-wrapper">
    <div class="dashboard-container">
        <?php $this->load->view('components/dashboardSidebar', ['active_page' => 'reviews']); ?>
        <main class="dashboard-content">
            <div class="page-card">
                <div class="page-head">
                    <h2 style="margin:0;color:#1A1A1A;">My Reviews</h2>
                    <p style="margin:6px 0 0;color:#6B7280;font-size:14px;">Track pending reviews and submitted reviews.</p>
                </div>
                <div class="filter-tabs">
                    <a class="filter-btn <?= $filter === 'pending' ? 'active' : '' ?>" href="<?= base_url('dashboard/reviews?filter=pending') ?>">Pending Reviews (<?= count($pending_reviews) ?>)</a>
                    <a class="filter-btn <?= $filter === 'done' ? 'active' : '' ?>" href="<?= base_url('dashboard/reviews?filter=done') ?>">Done Reviews (<?= count($done_reviews) ?>)</a>
                </div>
                <div class="rows">
                    <?php $rows = $filter === 'done' ? $done_reviews : $pending_reviews; ?>
                    <?php if (empty($rows)) : ?>
                        <div class="empty">No <?= $filter ?> reviews found.</div>
                    <?php else : foreach ($rows as $r) : ?>
                        <article class="review-row">
                            <div class="top">
                                <div>
                                    <div><strong>#<?= (int)$r['orderID'] ?></strong> • <?= html_escape(ucfirst($r['transactionType'])) ?> • <?= html_escape($r['itemName']) ?></div>
                                    <div class="meta">Counterparty: <?= html_escape($r['counterparty']) ?></div>
                                </div>
                                <?php if ($filter === 'done') : ?>
                                    <?php $sr = max(1, min(5, (int)$r['rating'])); $stars = str_repeat('★', $sr) . str_repeat('☆', 5 - $sr); ?>
                                    <span class="star-display"><?= $stars ?></span>
                                <?php else : ?>
                                    <span class="badge">Pending</span>
                                <?php endif; ?>
                            </div>
                            <?php if ($filter === 'done') : ?>
                                <p style="margin:10px 0 0;color:#374151;"><?= nl2br(html_escape($r['reviewText'])) ?></p>
                            <?php else : ?>
                                <a class="btn-review" href="<?= base_url('orders/' . (int)$r['orderID']) ?>">Write Review</a>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>
<?php $this->load->view('components/websiteFooter'); ?>
</body>
</html>
