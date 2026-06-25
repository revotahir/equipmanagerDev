<div class="page-kicker">My Rentals</div>
<h1 class="page-title">Workforce Rental Orders</h1>
<p class="page-subtitle">These records come from workforce rental payments linked directly to your workforce profile.</p>

<section class="content-card">
    <?php if (!empty($rentals)) : ?>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Client</th>
                    <th>Dates</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rentals as $rental) : ?>
                    <tr>
                        <td>
                            <strong>#<?= (int)($rental['workforcePaymentID'] ?? 0) ?></strong>
                            <div class="row-meta"><?= htmlspecialchars(ucfirst($rental['rentalType'] ?? 'rental')) ?></div>
                        </td>
                        <td>
                            <?= htmlspecialchars($rental['buyerName'] ?? 'Client') ?>
                            <div class="row-meta"><?= htmlspecialchars($rental['buyerEmail'] ?? '') ?></div>
                        </td>
                        <td>
                            <?= !empty($rental['rentalStartDate']) ? date('M d, Y', strtotime($rental['rentalStartDate'])) : '-' ?>
                            <div class="row-meta">to <?= !empty($rental['rentalEndDate']) ? date('M d, Y', strtotime($rental['rentalEndDate'])) : '-' ?></div>
                        </td>
                        <td><?= htmlspecialchars($rental['currency'] ?? 'USD') ?> <?= number_format((float)($rental['grossAmount'] ?? 0), 2) ?></td>
                        <td>
                            <span class="badge-soft"><?= htmlspecialchars(str_replace('_', ' ', ucfirst($rental['orderStatus'] ?? 'requested'))) ?></span>
                            <div class="row-meta"><?= htmlspecialchars(str_replace('_', ' ', $rental['rentalRequestStatus'] ?? 'request_pending')) ?></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="empty-state">No workforce rentals are currently linked to your profile.</div>
    <?php endif; ?>
</section>
