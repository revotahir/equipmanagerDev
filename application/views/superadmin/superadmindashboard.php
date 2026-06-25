<!DOCTYPE html>
<html lang="en" class="minimal-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?= base_url() ?>assets/images/logo-icon.png" type="image/png" />
    <!--plugins-->
    <link href="<?= base_url() ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link
        href="<?= base_url() ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css"
        rel="stylesheet" />
    <link
        href="<?= base_url() ?>assets/plugins/metismenu/css/metisMenu.min.css"
        rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- loader-->
    <link href="<?= base_url() ?>assets/css/pace.min.css" rel="stylesheet" />

    <!--Theme Styles-->
    <link href="<?= base_url() ?>assets/css/dark-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/light-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/semi-dark.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/header-colors.css" rel="stylesheet" />

    <title>Equip Manager</title>
    <style>
        /* Override wrapper to be flex container */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Ensure proper layout */
        main.superadmin-dashboard {
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
            main.superadmin-dashboard {
                margin-left: 0;
                margin-top: 60px;
                padding: 1rem;
            }
        }

        @media (min-width: 769px) {
            main.superadmin-dashboard {
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
        <main class="superadmin-dashboard">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
                    <p class="text-gray-500 text-sm mt-1">Real-time overview of EquipManager platform performance.</p>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <button class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors whitespace-nowrap">
                        <i class="bi bi-calendar-event text-gray-400"></i>
                        <span>May 12 - May 18, 2024</span>
                        <i class="bi bi-chevron-down text-gray-400 text-xs"></i>
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50 transition-colors whitespace-nowrap">
                        <i class="bi bi-download text-gray-400"></i>
                        <span>Export</span>
                        <i class="bi bi-chevron-down text-gray-400 text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Primary KPI Cards (3 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Card 1: Marketplace Companies -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-purple-600 font-semibold text-sm">Marketplace Companies</h3>
                            <p class="text-gray-500 text-xs mt-1">Using marketplace only</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <i class="bi bi-people text-purple-600 text-lg"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-3">1,842</p>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-arrow-up text-emerald-600 text-xs"></i>
                        <span class="text-emerald-600 font-semibold text-sm">12.5%</span>
                        <span class="text-gray-500 text-xs sm:text-sm">vs last 7 days</span>
                    </div>
                </div>

                <!-- Card 2: EM Tracking Customers -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-green-600 font-semibold text-sm">EM Tracking Customers</h3>
                            <p class="text-gray-500 text-xs mt-1">Active subscription</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-lg">
                            <i class="bi bi-building text-green-600 text-lg"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-3">378</p>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-arrow-up text-emerald-600 text-xs"></i>
                        <span class="text-emerald-600 font-semibold text-sm">8.1%</span>
                        <span class="text-gray-500 text-xs sm:text-sm">vs last 7 days</span>
                    </div>
                </div>

                <!-- Card 3: Total Companies -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-blue-600 font-semibold text-sm">Total Companies</h3>
                            <p class="text-gray-500 text-xs mt-1">All companies on platform</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="bi bi-people text-blue-600 text-lg"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-3">2,220</p>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-arrow-up text-emerald-600 text-xs"></i>
                        <span class="text-emerald-600 font-semibold text-sm">11.2%</span>
                        <span class="text-gray-500 text-xs sm:text-sm">vs last 7 days</span>
                    </div>
                </div>
            </div>

            <!-- Secondary Metric Cards (4 Columns) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Card 1: Total Orders -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mb-3">1,892</p>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-arrow-up text-emerald-600 text-xs"></i>
                        <span class="text-emerald-600 font-semibold text-xs">15.3%</span>
                        <span class="text-gray-500 text-xs">vs last 7 days</span>
                    </div>
                </div>

                <!-- Card 2: Total Revenue -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mb-3">$285,430</p>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-arrow-up text-emerald-600 text-xs"></i>
                        <span class="text-emerald-600 font-semibold text-xs">20.7%</span>
                        <span class="text-gray-500 text-xs">vs last 7 days</span>
                    </div>
                </div>

                <!-- Card 3: Active Rentals -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <p class="text-gray-600 text-sm font-medium mb-2">Active Rentals</p>
                    <p class="text-2xl font-bold text-gray-900 mb-3">892</p>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-arrow-up text-emerald-600 text-xs"></i>
                        <span class="text-emerald-600 font-semibold text-xs">9.4%</span>
                        <span class="text-gray-500 text-xs">vs last 7 days</span>
                    </div>
                </div>

                <!-- Card 4: Support Tickets -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <p class="text-gray-600 text-sm font-medium mb-2">Support Tickets</p>
                    <p class="text-2xl font-bold text-gray-900 mb-3">156</p>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-arrow-down text-red-500 text-xs"></i>
                        <span class="text-red-500 font-semibold text-xs">5.3%</span>
                        <span class="text-gray-500 text-xs">vs last 7 days</span>
                    </div>
                </div>
            </div>

            <!-- Charts & Visuals Row (2 Columns - Cleaner Layout) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                <!-- Chart 1: Revenue Trend -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Revenue Trend</h3>
                    <!-- SVG Line Chart Mock -->
                    <svg class="w-full h-56" viewBox="0 0 360 220" preserveAspectRatio="xMidYMid meet">
                        <!-- Axis -->
                        <line x1="46" y1="184" x2="338" y2="184" stroke="#9CA3AF" stroke-width="1.2"/>
                        <line x1="46" y1="26" x2="46" y2="184" stroke="#9CA3AF" stroke-width="1.2"/>
                        <!-- Grid Lines -->
                        <line x1="46" y1="150" x2="338" y2="150" stroke="#E5E7EB" stroke-width="1"/>
                        <line x1="46" y1="116" x2="338" y2="116" stroke="#E5E7EB" stroke-width="1"/>
                        <line x1="46" y1="82" x2="338" y2="82" stroke="#E5E7EB" stroke-width="1"/>
                        <line x1="46" y1="48" x2="338" y2="48" stroke="#E5E7EB" stroke-width="1"/>
                        <!-- Axis tick labels -->
                        <text x="12" y="188" font-size="10" fill="#6B7280">$0k</text>
                        <text x="8" y="154" font-size="10" fill="#6B7280">$50k</text>
                        <text x="4" y="120" font-size="10" fill="#6B7280">$100k</text>
                        <text x="4" y="86" font-size="10" fill="#6B7280">$150k</text>
                        <text x="4" y="52" font-size="10" fill="#6B7280">$200k</text>
                        <!-- Green Line -->
                        <polyline points="56,132 104,92 152,108 200,70 248,84 320,52" fill="none" stroke="#10B981" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <!-- Blue Line -->
                        <polyline points="56,158 104,142 152,126 200,108 248,120 320,92" fill="none" stroke="#3B82F6" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <!-- X labels -->
                        <text x="50" y="204" font-size="10" fill="#6B7280">May 12</text>
                        <text x="115" y="204" font-size="10" fill="#6B7280">May 13</text>
                        <text x="180" y="204" font-size="10" fill="#6B7280">May 14</text>
                        <text x="245" y="204" font-size="10" fill="#6B7280">May 15</text>
                        <text x="306" y="204" font-size="10" fill="#6B7280">May 18</text>
                        <!-- Axis titles -->
                        <text x="180" y="216" font-size="10" fill="#6B7280" text-anchor="middle">Date</text>
                        <text x="14" y="20" font-size="10" fill="#6B7280">Revenue (USD)</text>
                    </svg>
                    <div class="flex gap-6 mt-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span class="text-gray-600">Subscriptions</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                            <span class="text-gray-600">Marketplace</span>
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Revenue Distribution -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm flex flex-col">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Revenue Distribution</h3>
                    <div class="flex justify-center flex-1">
                        <svg class="w-40 h-40" viewBox="0 0 120 120" preserveAspectRatio="xMidYMid meet">
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#E5E7EB" stroke-width="8"/>
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#10B981" stroke-width="8" stroke-dasharray="119 360" transform="rotate(-90 60 60)"/>
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#3B82F6" stroke-width="8" stroke-dasharray="92 360" stroke-dashoffset="-119" transform="rotate(-90 60 60)"/>
                            <circle cx="60" cy="60" r="30" fill="white"/>
                            <text x="60" y="60" font-size="16" font-weight="bold" text-anchor="middle" fill="#111827">$285K</text>
                        </svg>
                    </div>
                    <div class="space-y-2 text-xs mt-4">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span class="text-gray-600">Subscriptions: $104K</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                            <span class="text-gray-600">Marketplace: $181K</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders & Health Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- Chart 3: Orders Status -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Orders Status</h3>
                    <div class="flex items-center gap-8">
                        <svg class="w-32 h-32" viewBox="0 0 120 120" preserveAspectRatio="xMidYMid meet">
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#E5E7EB" stroke-width="8"/>
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#10B981" stroke-width="8" stroke-dasharray="117 360" transform="rotate(-90 60 60)"/>
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#F59E0B" stroke-width="8" stroke-dasharray="49 360" stroke-dashoffset="-117" transform="rotate(-90 60 60)"/>
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#EF4444" stroke-width="8" stroke-dasharray="30 360" stroke-dashoffset="-166" transform="rotate(-90 60 60)"/>
                            <circle cx="60" cy="60" r="30" fill="white"/>
                            <text x="60" y="62" font-size="16" font-weight="bold" text-anchor="middle" fill="#111827">1,892</text>
                        </svg>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <span class="text-gray-600">Completed: 1,230</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                                <span class="text-gray-600">Pending: 410</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                <span class="text-gray-600">Cancelled: 252</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart 4: Platform Health -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">System Health</h3>
                    <div class="flex flex-col items-center justify-center py-4">
                        <svg class="w-32 h-32 mb-4" viewBox="0 0 120 120" preserveAspectRatio="xMidYMid meet">
                            <circle cx="60" cy="60" r="50" fill="none" stroke="#E5E7EB" stroke-width="6"/>
                            <circle cx="60" cy="60" r="50" fill="none" stroke="#10B981" stroke-width="6" stroke-dasharray="157 314" transform="rotate(-90 60 60)"/>
                            <text x="60" y="68" font-size="28" font-weight="bold" text-anchor="middle" fill="#10B981">98%</text>
                        </svg>
                        <p class="text-sm font-semibold text-gray-900">All Systems Operational</p>
                        <p class="text-xs text-gray-500 mt-1">No critical issues</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Lists & Alerts Row (Simplified) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <!-- Card 1: Top Companies by Revenue -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Top Companies by Revenue</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">ABC Construction</span>
                            <span class="text-sm font-semibold text-gray-900">$32,460</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">BuildPro Group</span>
                            <span class="text-sm font-semibold text-gray-900">$24,990</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nordic Builders</span>
                            <span class="text-sm font-semibold text-gray-900">$18,230</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">SteelWorks Ltd.</span>
                            <span class="text-sm font-semibold text-gray-900">$14,560</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Urban Infra</span>
                            <span class="text-sm font-semibold text-gray-900">$12,150</span>
                        </div>
                    </div>
                    <a href="#" class="text-xs text-blue-600 font-medium mt-4 inline-block hover:underline">View all →</a>
                </div>

                <!-- Card 2: Top Equipment by Rentals -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Top Equipment by Rentals</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Excavator CAT 320</span>
                            <span class="text-sm font-semibold text-gray-900">412</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Generator 450kVA</span>
                            <span class="text-sm font-semibold text-gray-900">298</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Boom Lift</span>
                            <span class="text-sm font-semibold text-gray-900">164</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Handheld Drill</span>
                            <span class="text-sm font-semibold text-gray-900">142</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Compressor 185CFM</span>
                            <span class="text-sm font-semibold text-gray-900">123</span>
                        </div>
                    </div>
                    <a href="#" class="text-xs text-blue-600 font-medium mt-4 inline-block hover:underline">View all →</a>
                </div>

                <!-- Card 3: Critical Alerts -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Critical Alerts</h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-exclamation-circle-fill text-red-500 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">3 Devices offline</p>
                                <p class="text-xs text-gray-500 mt-1">Needs attention</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-exclamation-circle-fill text-red-500 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">7 Support tickets</p>
                                <p class="text-xs text-gray-500 mt-1">High priority</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-exclamation-circle text-amber-500 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">2 Failed payments</p>
                                <p class="text-xs text-gray-500 mt-1">Follow up required</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="text-xs text-blue-600 font-medium mt-4 inline-block hover:underline">View all →</a>
                </div>

                <!-- Card 4: Support Overview -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Support Tickets</h3>
                    <p class="text-3xl font-bold text-gray-900 mb-2">156</p>
                    <div class="flex items-center gap-2 mb-4">
                        <i class="bi bi-arrow-up text-emerald-600 text-xs"></i>
                        <span class="text-emerald-600 font-semibold text-xs">+15.3%</span>
                        <span class="text-gray-500 text-xs">vs last week</span>
                    </div>
                    <!-- Simple Sparkline -->
                    <svg class="w-full h-10" viewBox="0 0 120 40" preserveAspectRatio="xMidYMid meet">
                        <polyline points="5,25 15,20 25,22 35,18 45,20 55,16 65,18 70,15 80,17 90,14 100,16 115,12" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <!-- Card 5: Active Rentals -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Active Rentals</h3>
                    <p class="text-3xl font-bold text-gray-900 mb-2">892</p>
                    <div class="flex items-center gap-2 mb-4">
                        <i class="bi bi-arrow-up text-emerald-600 text-xs"></i>
                        <span class="text-emerald-600 font-semibold text-xs">+9.4%</span>
                        <span class="text-gray-500 text-xs">vs last week</span>
                    </div>
                    <!-- Simple Sparkline -->
                    <svg class="w-full h-10" viewBox="0 0 120 40" preserveAspectRatio="xMidYMid meet">
                        <polyline points="5,28 15,23 25,25 35,21 45,23 55,19 65,21 70,18 80,20 90,17 100,19 115,15" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <!-- Card 6: Revenue Status -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Monthly Revenue</h3>
                    <p class="text-3xl font-bold text-gray-900 mb-2">$285K</p>
                    <div class="flex items-center gap-2 mb-4">
                        <i class="bi bi-arrow-up text-emerald-600 text-xs"></i>
                        <span class="text-emerald-600 font-semibold text-xs">+20.7%</span>
                        <span class="text-gray-500 text-xs">vs last month</span>
                    </div>
                    <!-- Simple Sparkline -->
                    <svg class="w-full h-10" viewBox="0 0 120 40" preserveAspectRatio="xMidYMid meet">
                        <polyline points="5,30 15,25 25,20 35,16 45,18 55,14 65,16 70,12 80,14 90,10 100,12 115,8" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </main>
        <!--end page main-->

        <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
        <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class="bx bxs-up-arrow-alt"></i></a>
        <!--End Back To Top Button-->
    </div>
    <!--end wrapper-->

    <!-- Bootstrap bundle JS -->
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="<?= base_url() ?>assets/js/pace.min.js"></script>
    <!--app-->
    <script src="<?= base_url() ?>assets/js/app.js"></script>
</body>

</html>
