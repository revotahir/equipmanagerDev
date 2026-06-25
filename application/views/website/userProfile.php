<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Profile - EquipManager</title>
  <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/website/img/favicon.svg" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/style.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/header.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/footer.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/website/css/resopnsive.css" />
  <style>
    :root {
      --primary-brand: #13372E;
      --text-primary: #0f2f2c;
      --text-secondary: #526464;
      --surface: #ffffff;
      --border: #e5e7eb;
    }
    body {
      background: #f5f6f8;
      font-family: "Manrope", sans-serif;
      color: var(--text-primary);
    }
    .profile-wrap {
      max-width: 1200px;
      margin: 28px auto 40px;
      padding: 0 16px;
    }
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 14px;
      color: var(--primary-brand);
      text-decoration: none;
      font-weight: 700;
      font-size: 14px;
    }
    .profile-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 22px;
      margin-bottom: 18px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .profile-card h2,
    .profile-card h3 {
      margin: 0;
      color: var(--text-primary);
      font-weight: 800;
      letter-spacing: -0.2px;
    }
    .profile-card h2 { font-size: 30px; }
    .profile-card h3 { font-size: 24px; }
    .meta {
      color: var(--text-secondary);
      font-size: 14px;
      line-height: 1.5;
    }
    .stars {
      color: #f59e0b;
      letter-spacing: 1px;
      font-weight: 700;
    }
    .review-item {
      border-top: 1px solid #eef2f7;
      padding-top: 14px;
      margin-top: 14px;
    }
    .review-item strong {
      font-weight: 800;
      color: var(--text-primary);
    }
  </style>
</head>
<body>
<?php $this->load->view('components/websiteHeader'); ?>
<div class="profile-wrap">
  <a href="javascript:history.back()" class="back-link">&larr; Back</a>
  <div class="profile-card">
    <h2 style="margin:0 0 6px 0;"><?= htmlspecialchars($profile_display_name ?? ($profile_user['userName'] ?? 'User'), ENT_QUOTES, 'UTF-8') ?></h2>
    <?php
      $avg = !empty($user_rating_summary['averageRating']) ? (float)$user_rating_summary['averageRating'] : 0.0;
      $total = !empty($user_rating_summary['totalReviews']) ? (int)$user_rating_summary['totalReviews'] : 0;
      $filled = (int)round($avg);
      $stars = str_repeat('★', max(0, min(5, $filled))) . str_repeat('☆', 5 - max(0, min(5, $filled)));
    ?>
    <p class="meta"><?= number_format($avg, 1) ?> / 5 (<?= $total ?> reviews) <span class="stars"><?= $stars ?></span></p>
  </div>

  <div class="profile-card" id="reviews">
    <h3 style="margin:0;">Reviews</h3>
    <?php if (empty($user_reviews)): ?>
      <p class="meta" style="margin-top:10px;">No reviews yet.</p>
    <?php else: ?>
      <?php foreach ($user_reviews as $rv): ?>
        <?php
          $r = max(1, min(5, (int)$rv->rating));
          $rs = str_repeat('★', $r) . str_repeat('☆', 5 - $r);
        ?>
        <div class="review-item">
          <div><strong><?= htmlspecialchars($rv->reviewerName ?: 'User', ENT_QUOTES, 'UTF-8') ?></strong> <span class="stars"><?= $rs ?></span></div>
          <div class="meta"><?= htmlspecialchars(ucfirst((string)$rv->transactionType), ENT_QUOTES, 'UTF-8') ?><?= !empty($rv->itemName) ? ' • ' . htmlspecialchars((string)$rv->itemName, ENT_QUOTES, 'UTF-8') : '' ?></div>
          <div style="margin-top:6px; color:#374151;"><?= nl2br(htmlspecialchars((string)$rv->reviewText, ENT_QUOTES, 'UTF-8')) ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
<?php $this->load->view('components/websiteFooter'); ?>
</body>
</html>
