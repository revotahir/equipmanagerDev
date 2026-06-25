<?php
if (!function_exists('employee_project_status_label')) {
    function employee_project_status_label($status)
    {
        $labels = [
            1 => 'Draft',
            2 => 'In Process',
            3 => 'Delayed',
            4 => 'Completed'
        ];

        return $labels[(int)$status] ?? 'Unknown';
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="minimal-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?= base_url() ?>assets/images/logo-icon.png" type="image/png" />
    <!--plugins-->
    <link href="<?= base_url() ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link href="<?= base_url() ?>assets/css/pace.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/dark-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/light-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/semi-dark.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/header-colors.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Employee Dashboard - EquipManager</title>
    <style>
        :root {
            --primary-brand: #13372E;
            --accent-green: #2A7A66;
            --text-primary: #1A1A1A;
            --text-secondary: #6B7280;
            --text-light: #FFFFFF;
            --body-bg: #F5F6F8;
            --card-bg: #FFFFFF;
            --border-color: #E5E7EB;
            --soft-green: #EEF7F3;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        body,
        .page-content {
            font-family: "Manrope", sans-serif;
            color: var(--text-primary);
        }

        .page-content {
            background-color: var(--body-bg);
        }

        .employee-content {
            max-width: 1400px;
            padding-left: 8px;
            padding-right: 8px;
        }

        .page-kicker {
            color: var(--accent-green);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .page-title {
            font-size: 34px;
            font-weight: 800;
            margin: 0 0 10px;
            font-family: "Manrope", sans-serif;
        }

        .page-subtitle {
            color: var(--text-secondary);
            font-size: 15px;
            line-height: 1.7;
            margin: 0 0 28px;
            max-width: 760px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .summary-tile,
        .content-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            box-shadow: var(--shadow);
        }

        .summary-tile {
            padding: 22px;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .summary-tile:hover {
            transform: translateY(-2px);
            color: inherit;
            box-shadow: 0 8px 20px rgba(19, 55, 46, .12);
        }

        .tile-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--primary-brand);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 22px;
        }

        .tile-value {
            font-size: 30px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 6px;
        }

        .tile-label {
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 700;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .content-card {
            padding: 24px;
            margin-bottom: 16px;
        }

        .card-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 18px;
        }

        .card-heading h2 {
            font-size: 20px;
            font-weight: 800;
            margin: 0;
        }

        .text-link {
            color: var(--primary-brand);
            font-weight: 800;
            font-size: 13px;
            text-decoration: none;
        }

        .data-list {
            display: grid;
            gap: 12px;
        }

        .data-row {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 14px;
            background: #fff;
        }

        .row-title {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .row-meta {
            color: var(--text-secondary);
            font-size: 13px;
            line-height: 1.6;
        }

        .badge-soft {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            background: var(--soft-green);
            color: var(--primary-brand);
            font-size: 12px;
            font-weight: 800;
            padding: 6px 10px;
            margin-top: 10px;
        }

        .empty-state {
            border: 1px dashed var(--border-color);
            background: #FAFAFA;
            color: var(--text-secondary);
            border-radius: 14px;
            padding: 28px;
            text-align: center;
            font-weight: 600;
        }

        .responsive-table {
            width: 100%;
            border-collapse: collapse;
        }

        .responsive-table th,
        .responsive-table td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--border-color);
            text-align: left;
            vertical-align: top;
            font-size: 14px;
        }

        .responsive-table th {
            color: var(--text-secondary);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 24px;
            align-items: start;
        }

        .profile-photo {
            width: 180px;
            height: 180px;
            border-radius: 18px;
            object-fit: cover;
            background: var(--soft-green);
            border: 1px solid var(--border-color);
        }

        @media (max-width: 1100px) {
            .summary-grid,
            .content-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .employee-content {
                padding: 0;
            }

            .summary-grid,
            .content-grid,
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 26px;
            }

            .responsive-table thead {
                display: none;
            }

            .responsive-table tr,
            .responsive-table td {
                display: block;
                width: 100%;
            }

            .responsive-table tr {
                border: 1px solid var(--border-color);
                border-radius: 12px;
                margin-bottom: 12px;
                overflow: hidden;
            }

            .responsive-table td {
                border-bottom: 1px solid var(--border-color);
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php $this->load->view('components/header'); ?>
        <?php $this->load->view('components/sidemenu'); ?>

        <main class="page-content">
            <div class="employee-content">
                <?php $this->load->view($employee_view); ?>
            </div>
        </main>

        <div class="overlay nav-toggle-icon"></div>
        <a href="javaScript:;" class="back-to-top"><i class="bx bxs-up-arrow-alt"></i></a>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="<?= base_url() ?>assets/js/pace.min.js"></script>
    <script src="<?= base_url() ?>assets/js/app.js"></script>
</body>

</html>
