<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Company Reviews - Equip Manager</title>
    <link rel="icon" href="<?= base_url() ?>assets/images/logo-icon.png" type="image/png" />
    <link href="<?= base_url() ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <style>
        body { background: #fafafa; }
        .page-title-section { background:#fff; border-bottom:1px solid #f0f0f0; padding:24px 0; margin-bottom:24px; }
        .page-title-container { padding:0 24px; display:flex; justify-content:space-between; align-items:center; }
        .page-title { margin:0; font-size:28px; font-weight:700; color:#0f2f2c; }
        .page-subtitle { margin:4px 0 0 0; font-size:14px; color:#6b7280; }
        .chip-group { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px; }
        .chip { padding:10px 16px; border-radius:8px; border:1px solid #d8dee6; color:#0f2f2c; text-decoration:none; font-weight:700; background:#fff; display:inline-flex; align-items:center; justify-content:center; min-height:48px; line-height:1.2; }
        .chip.active { background:#0f4238; color:#fff; border-color:#0f4238; }
        .list-card { background:#fff; border:1px solid #ececec; border-radius:12px; padding:18px; box-shadow:0 2px 8px rgba(0,0,0,.04); }
        .review-row { border:1px solid #edf2f7; border-radius:10px; padding:14px; background:#fff; margin-top:10px; }
        .review-meta { color:#6b7280; font-size:13px; }
        .stars { color:#f4b400; font-weight:700; letter-spacing:1px; }
        .btn-review { margin-top:10px; display:inline-flex; align-items:center; justify-content:center; background:#13372E; color:#fff; text-decoration:none; padding:10px 14px; border-radius:10px; font-weight:700; font-size:14px; line-height:1; min-height:44px; }
        .empty { color:#6b7280; padding:24px 6px; }
        @media (max-width: 768px) {
            .page-title-container { padding:0 12px; }
            .page-title { font-size:22px; }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php $this->load->view('components/header'); ?>
    <?php $this->load->view('components/sidemenu'); ?>

    <main class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Reviews</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('company-dashboard') ?>"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Customer Reviews</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="page-title-section">
            <div class="page-title-container">
                <div>
                    <h1 class="page-title">Customer Reviews</h1>
                    <p class="page-subtitle">Review buyers and renters for completed orders.</p>
                </div>
            </div>
        </div>

        <div class="chip-group">
            <a class="chip <?= $filter === 'pending' ? 'active' : '' ?>" href="<?= base_url('company-reviews?filter=pending') ?>">Pending Reviews (<?= count($pending_reviews ?? []) ?>)</a>
            <a class="chip <?= $filter === 'done' ? 'active' : '' ?>" href="<?= base_url('company-reviews?filter=done') ?>">Done Reviews (<?= count($done_reviews ?? []) ?>)</a>
        </div>

        <section class="list-card">
            <?php $rows = $filter === 'done' ? ($done_reviews ?? []) : ($pending_reviews ?? []); ?>
            <?php if (empty($rows)) : ?>
                <div class="empty">No <?= html_escape($filter) ?> reviews found.</div>
            <?php else : foreach ($rows as $r) : ?>
                <article class="review-row">
                    <div style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                        <div>
                            <strong><?= html_escape($r['itemName']) ?></strong>
                            <div class="review-meta">Order #<?= (int)$r['orderID'] ?> | <?= ucfirst(html_escape($r['transactionType'])) ?></div>
                            <div class="review-meta">Customer: <?= html_escape($r['customerName']) ?><?= !empty($r['customerEmail']) ? ' (' . html_escape($r['customerEmail']) . ')' : '' ?></div>
                        </div>
                        <?php if (!empty($r['reviewID'])): ?>
                            <div class="stars"><?= str_repeat('★', (int)$r['rating']) . str_repeat('☆', 5 - (int)$r['rating']) ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($r['reviewID'])): ?>
                        <p style="margin:10px 0 0;color:#374151;"><?= nl2br(html_escape($r['reviewText'])) ?></p>
                    <?php else: ?>
                        <a class="btn-review" href="<?= base_url('company-orders/view/' . (int)$r['orderID']) ?>">Write Review</a>
                    <?php endif; ?>
                </article>
            <?php endforeach; endif; ?>
        </section>
    </main>

    <div class="overlay toggle-icon"></div>
    <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
</div>

<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="<?= base_url() ?>assets/js/app.js"></script>
</body>
</html>
