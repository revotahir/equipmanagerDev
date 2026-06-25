<div class="page-kicker">My Projects</div>
<h1 class="page-title">Assigned Projects</h1>
<p class="page-subtitle">Projects are pulled from the existing project workforce assignment table and filtered by your workforce ID.</p>

<section class="content-card">
    <?php if (!empty($projects)) : ?>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Timeline</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project) : ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($project['pName'] ?? 'Project') ?></strong>
                            <div class="row-meta"><?= htmlspecialchars($project['pDesc'] ?? '') ?></div>
                        </td>
                        <td><?= htmlspecialchars($project['pCatName'] ?? 'Marketplace') ?></td>
                        <td><?= htmlspecialchars($project['pLocation'] ?? '-') ?></td>
                        <td>
                            <?= !empty($project['pStartDate']) ? date('M d, Y', strtotime($project['pStartDate'])) : '-' ?>
                            <?php if (!empty($project['pEndDate'])) : ?>
                                <div class="row-meta">to <?= date('M d, Y', strtotime($project['pEndDate'])) ?></div>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge-soft"><?= employee_project_status_label($project['pStatus'] ?? null) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="empty-state">No projects are currently assigned to you.</div>
    <?php endif; ?>
</section>
