<!DOCTYPE html>
<html lang="en" class="minimal-theme">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?=base_url()?>assets/images/logo-icon.png" type="image/png" />
    <!--plugins-->
    <link href="<?=base_url()?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link
      href="<?=base_url()?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css"
      rel="stylesheet"
    />
    <link
      href="<?=base_url()?>assets/plugins/metismenu/css/metisMenu.min.css"
      rel="stylesheet"
    />
    <!-- Bootstrap CSS -->
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
    />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- loader-->
    <link href="<?=base_url()?>assets/css/pace.min.css" rel="stylesheet" />

    <!--Theme Styles-->
    <link href="<?=base_url()?>assets/css/dark-theme.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/light-theme.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/semi-dark.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/header-colors.css" rel="stylesheet" />

    <title>Equip Manager</title>
    <style>
        /* Override wrapper to be flex container */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Ensure proper layout */
        main.company-dashboard {
            flex: 1;
            margin-top: 60px;
            margin-left: 0;
            width: 100%;
            background-color: #f9fafb;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            main.company-dashboard {
                margin-left: 0;
                margin-top: 60px;
                padding: 1rem;
            }
        }

        @media (min-width: 769px) {
            main.company-dashboard {
                margin-left: 250px;
                margin-top: 60px;
                padding: 1.5rem;
            }
        }
    </style>
  </head>

  <body>
    <!--start wrapper-->
    <div class="wrapper">
  
      <?php $this->load->view('components/header'); ?>
      <?php $this->load->view('components/sidemenu'); ?>

      <!--start content-->
      <main class="company-dashboard">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
          <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-900">Company Dashboard</h1>
            <p class="text-gray-500 text-sm mt-1">Welcome back! Here's what's happening in your company</p>
          </div>
          <div>
            <button class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors whitespace-nowrap">
              <i class="bi bi-calendar-event text-gray-400"></i>
              <span>May 12 - May 18, 2024</span>
              <i class="bi bi-chevron-down text-gray-400 text-xs"></i>
            </button>
          </div>
        </div>

        <!-- Row 1: KPI Metrics (5 Columns) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
          <!-- Total Employees -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <p class="text-gray-600 text-xs font-medium mb-2">Total Employees</p>
            <p class="text-2xl font-bold text-gray-900 mb-3">42</p>
            <div class="flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
              <span class="text-emerald-600 font-semibold text-xs">+4</span>
              <span class="text-gray-500 text-xs">vs last 7 days</span>
            </div>
          </div>

          <!-- Active Projects -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <p class="text-gray-600 text-xs font-medium mb-2">Active Projects</p>
            <p class="text-2xl font-bold text-gray-900 mb-3">8</p>
            <div class="flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
              <span class="text-emerald-600 font-semibold text-xs">+2</span>
              <span class="text-gray-500 text-xs">vs last 7 days</span>
            </div>
          </div>

          <!-- Total Equipment -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <p class="text-gray-600 text-xs font-medium mb-2">Total Equipment</p>
            <p class="text-2xl font-bold text-gray-900 mb-3">128</p>
            <div class="flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
              <span class="text-emerald-600 font-semibold text-xs">+3</span>
              <span class="text-gray-500 text-xs">vs last 7 days</span>
            </div>
          </div>

          <!-- Active Rentals -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <p class="text-gray-600 text-xs font-medium mb-2">Active Rentals</p>
            <p class="text-2xl font-bold text-gray-900 mb-3">56</p>
            <div class="flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
              <span class="text-emerald-600 font-semibold text-xs">+3</span>
              <span class="text-gray-500 text-xs">vs last 7 days</span>
            </div>
          </div>

          <!-- Ubication Rate -->
          <div class="bg-purple-50 border border-purple-200 rounded-xl p-6 shadow-sm">
            <p class="text-gray-600 text-xs font-medium mb-2">Ubication Rate</p>
            <p class="text-2xl font-bold text-purple-900 mb-3">76%</p>
            <div class="flex items-center gap-2">
              <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
              <span class="text-emerald-600 font-semibold text-xs">+5%</span>
              <span class="text-gray-500 text-xs">vs last 7 days</span>
            </div>
          </div>
        </div>

        <!-- Row 2: Overview Visuals (3 Columns) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
          <!-- Projects Overview -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Projects Overview</h3>
            <div class="flex items-center gap-6">
              <svg class="w-32 h-32" viewBox="0 0 120 120" preserveAspectRatio="xMidYMid meet">
                <circle cx="60" cy="60" r="45" fill="none" stroke="#E5E7EB" stroke-width="8"/>
                <circle cx="60" cy="60" r="45" fill="none" stroke="#10B981" stroke-width="8" stroke-dasharray="97 360" transform="rotate(-90 60 60)"/>
                <circle cx="60" cy="60" r="45" fill="none" stroke="#F59E0B" stroke-width="8" stroke-dasharray="49 360" stroke-dashoffset="-97" transform="rotate(-90 60 60)"/>
                <circle cx="60" cy="60" r="45" fill="none" stroke="#EF4444" stroke-width="8" stroke-dasharray="24 360" stroke-dashoffset="-146" transform="rotate(-90 60 60)"/>
                <circle cx="60" cy="60" r="30" fill="white"/>
                <text x="60" y="62" font-size="16" font-weight="bold" text-anchor="middle" fill="#111827">8</text>
              </svg>
              <div class="space-y-2 text-sm">
                <div class="flex items-center gap-2">
                  <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                  <span class="text-gray-600">On Track</span>
                  <span class="text-gray-900 font-semibold">5 (62%)</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                  <span class="text-gray-600">At Risk</span>
                  <span class="text-gray-900 font-semibold">2 (25%)</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="inline-block w-2.5 h-2.5 rounded-full bg-red-500"></span>
                  <span class="text-gray-600">Delayed</span>
                  <span class="text-gray-900 font-semibold">1 (13%)</span>
                </div>
              </div>
            </div>
            <a href="#" class="text-xs text-blue-600 font-medium mt-4 inline-block hover:underline">View all Projects →</a>
          </div>

          <!-- Equipment Utilization -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Equipment Utilization</h3>
            <div class="flex items-center gap-6">
              <svg class="w-32 h-32" viewBox="0 0 120 120" preserveAspectRatio="xMidYMid meet">
                <circle cx="60" cy="60" r="45" fill="none" stroke="#E5E7EB" stroke-width="8"/>
                <circle cx="60" cy="60" r="45" fill="none" stroke="#10B981" stroke-width="8" stroke-dasharray="117 360" transform="rotate(-90 60 60)"/>
                <circle cx="60" cy="60" r="45" fill="none" stroke="#6B7280" stroke-width="8" stroke-dasharray="39 360" stroke-dashoffset="-117" transform="rotate(-90 60 60)"/>
                <circle cx="60" cy="60" r="30" fill="white"/>
                <text x="60" y="62" font-size="16" font-weight="bold" text-anchor="middle" fill="#111827">128</text>
              </svg>
              <div class="space-y-2 text-sm">
                <div class="flex items-center gap-2">
                  <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                  <span class="text-gray-600">In Use</span>
                  <span class="text-gray-900 font-semibold">98 (76%)</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="inline-block w-2.5 h-2.5 rounded-full bg-gray-400"></span>
                  <span class="text-gray-600">Idle</span>
                  <span class="text-gray-900 font-semibold">22 (17%)</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="inline-block w-2.5 h-2.5 rounded-full bg-red-500"></span>
                  <span class="text-gray-600">Maintenance</span>
                  <span class="text-gray-900 font-semibold">8 (7%)</span>
                </div>
              </div>
            </div>
            <a href="#" class="text-xs text-blue-600 font-medium mt-4 inline-block hover:underline">View all Equipment →</a>
          </div>

          <!-- Workforce Overview -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Workforce Overview</h3>
            <div class="flex items-center gap-6">
              <div class="flex items-center justify-center w-32 h-32 bg-purple-100 rounded-full">
                <i class="bi bi-people-fill text-purple-600" style="font-size: 3rem;"></i>
              </div>
              <div class="space-y-2 text-sm">
                <div class="flex items-center gap-2">
                  <span class="inline-block w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                  <span class="text-gray-600">Active</span>
                  <span class="text-gray-900 font-semibold">34 (81%)</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="inline-block w-2.5 h-2.5 rounded-full bg-gray-400"></span>
                  <span class="text-gray-600">On Project</span>
                  <span class="text-gray-900 font-semibold">2 (7%)</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="inline-block w-2.5 h-2.5 rounded-full bg-gray-300"></span>
                  <span class="text-gray-600">Available</span>
                  <span class="text-gray-900 font-semibold">1 (13%)</span>
                </div>
              </div>
            </div>
            <a href="#" class="text-xs text-blue-600 font-medium mt-4 inline-block hover:underline">View Workforce →</a>
          </div>
        </div>

        <!-- Row 3: Lists & Feeds (4 Columns) -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
          <!-- Idle Equipment Alert -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Idle Equipment Alert</h3>
            <div class="space-y-3">
              <div class="flex gap-3">
                <i class="bi bi-gear text-gray-400 text-lg flex-shrink-0"></i>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900">Generator 40kVA</p>
                  <p class="text-xs text-gray-500">Idle for 12 days</p>
                </div>
              </div>
              <div class="flex gap-3">
                <i class="bi bi-gear text-gray-400 text-lg flex-shrink-0"></i>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900">Compressor 185CFM</p>
                  <p class="text-xs text-gray-500">Idle for 7 days</p>
                </div>
              </div>
              <div class="flex gap-3">
                <i class="bi bi-gear text-gray-400 text-lg flex-shrink-0"></i>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900">Excavator CAT 320</p>
                  <p class="text-xs text-gray-500">Idle for 2 days</p>
                </div>
              </div>
            </div>
            <a href="#" class="text-xs text-blue-600 font-medium mt-4 inline-block hover:underline">View all idle equipment →</a>
          </div>

          <!-- Upcoming Rentals -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Upcoming Rentals</h3>
            <div class="space-y-3">
              <div class="flex items-center gap-2">
                <i class="bi bi-calendar2 text-gray-400 text-lg"></i>
                <p class="text-sm font-medium text-gray-900">Excavator CAT 320</p>
              </div>
              <div class="flex items-center gap-2">
                <i class="bi bi-calendar2 text-gray-400 text-lg"></i>
                <p class="text-sm font-medium text-gray-900">Generator 40kVA</p>
              </div>
              <div class="flex items-center gap-2">
                <i class="bi bi-calendar2 text-gray-400 text-lg"></i>
                <p class="text-sm font-medium text-gray-900">Boom Lift</p>
              </div>
              <div class="flex items-center gap-2">
                <i class="bi bi-calendar2 text-gray-400 text-lg"></i>
                <p class="text-sm font-medium text-gray-900">Handheld Drill</p>
              </div>
            </div>
            <a href="#" class="text-xs text-blue-600 font-medium mt-4 inline-block hover:underline">View all rentals →</a>
          </div>

          <!-- Project Risk Overview -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Project Risk Overview</h3>
            <div class="space-y-3">
              <div class="flex items-center justify-between gap-3">
                <span class="text-sm font-medium text-gray-900">Bridge Construction</span>
                <span class="inline-block px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded">On Track</span>
              </div>
              <div class="flex items-center justify-between gap-3">
                <span class="text-sm font-medium text-gray-900">Warehouse Build</span>
                <span class="inline-block px-2 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded">At Risk</span>
              </div>
              <div class="flex items-center justify-between gap-3">
                <span class="text-sm font-medium text-gray-900">Road Expansion</span>
                <span class="inline-block px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded">Delayed</span>
              </div>
              <div class="flex items-center justify-between gap-3">
                <span class="text-sm font-medium text-gray-900">Office Renovation</span>
                <span class="inline-block px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded">On Track</span>
              </div>
            </div>
            <a href="#" class="text-xs text-blue-600 font-medium mt-4 inline-block hover:underline">View all projects →</a>
          </div>

          <!-- Recent Activity Timeline -->
          <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Recent Activity</h3>
            <div class="space-y-4">
              <div class="flex gap-3">
                <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-blue-500 mt-1.5"></div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900">John Doe added to</p>
                  <p class="text-xs text-gray-600">Bridge Construction</p>
                  <p class="text-xs text-gray-500">May 18, 10:30 AM</p>
                </div>
              </div>
              <div class="flex gap-3">
                <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-emerald-500 mt-1.5"></div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900">Excavator CAT 320 assigned to</p>
                  <p class="text-xs text-gray-600">Bridge Construction</p>
                  <p class="text-xs text-gray-500">May 16, 02:45 PM</p>
                </div>
              </div>
              <div class="flex gap-3">
                <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-purple-500 mt-1.5"></div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900">Generator 40kVA returned</p>
                  <p class="text-xs text-gray-600">from rental</p>
                  <p class="text-xs text-gray-500">May 12, 03:20 PM</p>
                </div>
              </div>
            </div>
            <a href="#" class="text-xs text-blue-600 font-medium mt-4 inline-block hover:underline">View all activity →</a>
          </div>
        </div>

        <!-- Row 4: Quick Actions (5-Column Flex) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
          <!-- Add Employee -->
          <a href="<?= base_url('add-workforce') ?>" class="bg-green-50 border border-green-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow text-left block">
            <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mb-3">
              <i class="bi bi-plus text-green-600" style="font-size: 1.5rem;"></i>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Add Employee</h3>
          </a>

          <!-- Add Equipment -->
          <a href="<?= base_url('add-equipment') ?>" class="bg-gray-100 border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow text-left block">
            <div class="flex items-center justify-center w-12 h-12 bg-gray-200 rounded-lg mb-3">
              <i class="bi bi-plus text-gray-600" style="font-size: 1.5rem;"></i>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Add Equipment</h3>
          </a>

          <!-- Create Project -->
          <a href="<?= base_url('add-project') ?>" class="bg-blue-50 border border-blue-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow text-left block">
            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-3">
              <i class="bi bi-plus text-blue-600" style="font-size: 1.5rem;"></i>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Create Project</h3>
          </a>

          <!-- New Rental -->
          <a href="<?= base_url('add-listing') ?>" class="bg-amber-50 border border-amber-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow text-left block">
            <div class="flex items-center justify-center w-12 h-12 bg-amber-100 rounded-lg mb-3">
              <i class="bi bi-plus text-amber-600" style="font-size: 1.5rem;"></i>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Create Rental</h3>
          </a>

          <!-- Generate Report -->
          <button type="button" class="bg-purple-50 border border-purple-200 rounded-xl p-6 shadow-sm text-left block w-full cursor-not-allowed opacity-75" disabled aria-disabled="true" title="Coming soon">
            <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mb-3">
              <i class="bi bi-file-earmark text-purple-600" style="font-size: 1.5rem;"></i>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Generate Report</h3>
          </button>
        </div>
      </main>
      <!--end page main-->

      <!--start overlay-->
      <div class="overlay nav-toggle-icon"></div>
      <!--end overlay-->

      <!--Start Back To Top Button-->
      <a href="javaScript:;" class="back-to-top"
        ><i class="bx bxs-up-arrow-alt"></i
      ></a>
      <!--End Back To Top Button-->
    </div>
    <!--end wrapper-->

    <!-- Bootstrap bundle JS -->
    <script src="<?=base_url()?>assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="<?=base_url()?>assets/js/pace.min.js"></script>
    <!--app-->
    <script src="<?=base_url()?>assets/js/app.js"></script>
  </body>
</html>
