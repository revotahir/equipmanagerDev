<?php
$employee_data = $employee ?? [];
$employee_name = $employee_data['personName'] ?? ($employee_data['userName'] ?? 'Employee');
$company_name = $employee['companyName'] ?? 'your company';
$projects = $recent_projects ?? [];
$equipment_rows = $recent_equipment ?? [];
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="employee-dashboard-content">
    <!-- Header Section -->
    <div class="mb-6">
        <p class="text-teal-600 text-xs font-semibold uppercase tracking-wide mb-2">Employee Workspace</p>
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Welcome back, <?= htmlspecialchars($employee_name) ?></h1>
        <p class="text-gray-500 text-sm">This dashboard only shows projects, equipment, and notifications assigned to your workforce profile at <?= htmlspecialchars($company_name) ?>.</p>
    </div>

    <!-- Row 2: Primary KPIs (4 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Assigned Projects -->
        <a href="<?= base_url('employee/projects') ?>" class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-center w-14 h-14 bg-[#13372E] rounded-full mb-4">
                <i class="bi bi-kanban text-white" style="font-size: 1.75rem;"></i>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2"><?= (int)($counts['projects'] ?? 0) ?></p>
            <p class="text-gray-600 text-sm">Assigned Projects</p>
        </a>

        <!-- Assigned Equipment -->
        <a href="<?= base_url('employee/equipment') ?>" class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-center w-14 h-14 bg-[#13372E] rounded-full mb-4">
                <i class="bi bi-tools text-white" style="font-size: 1.75rem;"></i>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2"><?= (int)($counts['equipment'] ?? 0) ?></p>
            <p class="text-gray-600 text-sm">Assigned Equipment</p>
        </a>

        <!-- Unread Notifications -->
        <a href="<?= base_url('notifications') ?>" class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-center w-14 h-14 bg-[#13372E] rounded-full mb-4">
                <i class="bi bi-bell text-white" style="font-size: 1.75rem;"></i>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2"><?= (int)($counts['notifications'] ?? 0) ?></p>
            <p class="text-gray-600 text-sm">Unread Notifications</p>
        </a>

        <!-- Contact Admin -->
        <a href="<?= base_url('employee/messages') ?>" class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-center w-14 h-14 bg-[#13372E] rounded-full mb-4">
                <i class="bi bi-chat-dots text-white" style="font-size: 1.75rem;"></i>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-2">24/7</p>
            <p class="text-gray-600 text-sm">Contact Company Admin</p>
        </a>
    </div>

    <!-- Row 3: Hero & Secondary KPIs (4 Column Layout) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Today's Project (col-span-2) -->
        <div class="md:col-span-2 lg:col-span-2 bg-emerald-50 border border-emerald-200 rounded-xl p-6 shadow-sm">
            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-3">Today's Project</p>
            <?php if (!empty($projects)) :
                $today_project = $projects[0];
            ?>
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3"><?= htmlspecialchars($today_project['pName'] ?? 'Project') ?></h3>
                        <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                            <i class="bi bi-geo-alt"></i>
                            <span><?= htmlspecialchars($today_project['pLocation'] ?? 'No location') ?></span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Role</p>
                                <p class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($today_project['role'] ?? 'Technician') ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Status</p>
                                <span class="inline-flex items-center gap-1">
                                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-sm font-medium text-emerald-700"><?= employee_project_status_label($today_project['pStatus'] ?? null) ?></span>
                                </span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Start Date</p>
                                <p class="text-sm font-semibold text-gray-900"><?= date('M d, Y', strtotime($today_project['pStartDate'] ?? 'now')) ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">End Date</p>
                                <p class="text-sm font-semibold text-gray-900"><?= date('M d, Y', strtotime($today_project['pEndDate'] ?? 'now')) ?></p>
                            </div>
                        </div>
                        <a href="<?= base_url('employee/projects') ?>" class="text-sm text-teal-600 font-medium hover:underline">View project details →</a>
                    </div>
                    <div class="hidden md:flex flex-shrink-0 w-28 h-28 lg:w-32 lg:h-32 items-center justify-center bg-white rounded-lg opacity-20">
                        <svg viewBox="0 0 100 100" class="w-20 h-20 lg:w-24 lg:h-24 text-teal-600">
                            <rect x="10" y="20" width="30" height="40" fill="none" stroke="currentColor" stroke-width="2"/>
                            <rect x="60" y="10" width="30" height="50" fill="none" stroke="currentColor" stroke-width="2"/>
                            <polygon points="45,15 35,30 55,30" fill="none" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
            <?php else : ?>
                <div class="text-center py-8">
                    <p class="text-gray-500 text-sm">No projects assigned to you yet.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- My Project -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-2">My Project</p>
            <p class="text-4xl font-bold text-gray-900 mb-2"><?= (int)($counts['projects'] ?? 0) ?></p>
            <p class="text-sm text-gray-600 mb-4">Active Projects</p>
            <a href="<?= base_url('employee/projects') ?>" class="text-sm text-teal-600 font-medium hover:underline">View all →</a>
        </div>

        <!-- My Equipment -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-2">My Equipment</p>
            <p class="text-4xl font-bold text-gray-900 mb-2"><?= (int)($counts['equipment'] ?? 0) ?></p>
            <p class="text-sm text-gray-600 mb-4">Assigned</p>
            <a href="<?= base_url('employee/equipment') ?>" class="text-sm text-teal-600 font-medium hover:underline">View all →</a>
        </div>
    </div>

    <!-- Row 4: Lists & Feeds (3 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <!-- My Equipment -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">My Equipment</h3>
            <?php if (!empty($equipment_rows)) : ?>
                <div class="space-y-3">
                    <?php foreach (array_slice($equipment_rows, 0, 5) as $row) : ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <i class="bi bi-tools text-gray-400 flex-shrink-0"></i>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($row['equipName'] ?? 'Equipment') ?></p>
                                </div>
                            </div>
                            <span class="inline-block px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded flex-shrink-0 ml-2">In Use</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="<?= base_url('employee/equipment') ?>" class="text-sm text-teal-600 font-medium mt-4 inline-block hover:underline">View all equipment →</a>
            <?php else : ?>
                <div class="text-center py-6">
                    <p class="text-gray-500 text-sm">No equipment assigned yet.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Upcoming Bookings -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Upcoming Bookings</h3>
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <span class="inline-block w-2 h-2 rounded-full bg-gray-400 mt-1.5 flex-shrink-0"></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Excavator CAT 320</p>
                        <p class="text-xs text-gray-500">May 20, 2024</p>
                    </div>
                    <span class="text-xs text-gray-500 flex-shrink-0 ml-2">08:00 AM</span>
                </div>
                <div class="flex items-start gap-3">
                    <span class="inline-block w-2 h-2 rounded-full bg-gray-400 mt-1.5 flex-shrink-0"></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Generator 40kVA</p>
                        <p class="text-xs text-gray-500">May 22, 2024</p>
                    </div>
                    <span class="text-xs text-gray-500 flex-shrink-0 ml-2">08:00 AM</span>
                </div>
            </div>
            <a href="<?= base_url('employee/bookings') ?>" class="text-sm text-teal-600 font-medium mt-4 inline-block hover:underline">View all bookings →</a>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Recent Activity</h3>
            <div class="space-y-4">
                <div class="flex gap-3">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-teal-700 mt-1 flex-shrink-0"></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Project "Bridge Construction" updated</p>
                        <p class="text-xs text-gray-500 mt-1">May 18, 09:15 AM</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-teal-700 mt-1 flex-shrink-0"></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">New equipment assigned: Generator 40kVA</p>
                        <p class="text-xs text-gray-500 mt-1">May 17, 04:30 PM</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-teal-700 mt-1 flex-shrink-0"></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">New message from Site Manager</p>
                        <p class="text-xs text-gray-500 mt-1">May 16, 11:20 AM</p>
                    </div>
                </div>
            </div>
            <a href="<?= base_url('employee/activity') ?>" class="text-sm text-teal-600 font-medium mt-4 inline-block hover:underline">View all activity →</a>
        </div>
    </div>
</div>
