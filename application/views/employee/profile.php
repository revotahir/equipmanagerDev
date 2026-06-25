<?php
$photo = !empty($employee['personImg']) ? base_url('assets/uploads/workforce/' . $employee['personImg']) : base_url('assets/uploads/workforce/images.png');
?>

<div class="page-kicker">My Profile</div>
<h1 class="page-title">Employee Profile</h1>
<p class="page-subtitle">This information comes from your workforce record and authenticated user account. Contact your company admin if it needs to be changed.</p>

<section class="content-card">
    <div class="profile-grid">
        <div>
            <img class="profile-photo" src="<?= $photo ?>" alt="<?= htmlspecialchars($employee['personName'] ?? 'Employee') ?>">
        </div>
        <div class="data-list">
            <div class="data-row">
                <div class="row-title"><?= htmlspecialchars($employee['personName'] ?? $employee['userName'] ?? 'Employee') ?></div>
                <div class="row-meta">Company: <?= htmlspecialchars($employee['companyName'] ?? '-') ?></div>
                <span class="badge-soft">Workforce ID #<?= (int)($employee['workforceID'] ?? 0) ?></span>
            </div>
            <div class="data-row">
                <div class="row-title">Contact</div>
                <div class="row-meta">Email: <?= htmlspecialchars($employee['personEmail'] ?? $employee['userEmail'] ?? '-') ?></div>
                <div class="row-meta">Phone: <?= htmlspecialchars($employee['personPhone'] ?? $employee['userPhone'] ?? '-') ?></div>
            </div>
            <div class="data-row">
                <div class="row-title">Additional Information</div>
                <div class="row-meta"><?= nl2br(htmlspecialchars($employee['personAddInfo'] ?? 'No additional information saved.')) ?></div>
            </div>
        </div>
    </div>
</section>
