<div class="page-kicker">My Equipment</div>
<h1 class="page-title">Assigned Equipment</h1>
<p class="page-subtitle">Equipment shown here is assigned to you through project equipment assignments. This is a read-only operational view.</p>

<section class="content-card">
    <?php if (!empty($equipment)) : ?>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Equipment</th>
                    <th>Category</th>
                    <th>Project</th>
                    <th>Quantity</th>
                    <th>Project Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipment as $row) : ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($row['equipName'] ?? 'Equipment') ?></strong>
                            <div class="row-meta"><?= htmlspecialchars($row['equipDesc'] ?? '') ?></div>
                        </td>
                        <td><?= htmlspecialchars($row['catName'] ?? '-') ?></td>
                        <td>
                            <?= htmlspecialchars($row['pName'] ?? 'Unassigned project') ?>
                            <?php if (!empty($row['pLocation'])) : ?>
                                <div class="row-meta"><?= htmlspecialchars($row['pLocation']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge-soft"><?= (int)($row['assignedQty'] ?? 0) ?> assigned</span></td>
                        <td><span class="badge-soft"><?= employee_project_status_label($row['pStatus'] ?? null) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="empty-state">No equipment is currently assigned to you.</div>
    <?php endif; ?>
</section>
