<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?=base_url()?>assets/images/favicon.png" type="image/png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?=base_url()?>assets/admin/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/libs/css/style.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet"
        href="<?=base_url()?>assets/admin/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <title>DashBoard</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <?php 
    $this->load->view('components/header');
    ?>
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Welcome to Metro Foods </h2>
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus
                                    vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a 
                                                    class="breadcrumb-link">Dashboard</a></li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
         
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="<?=base_url()?>assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="<?=base_url()?>assets/admin/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="<?=base_url()?>assets/admin/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="<?=base_url()?>assets/admin/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="<?=base_url()?>assets/admin/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="<?=base_url()?>assets/admin/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="<?=base_url()?>assets/admin/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="<?=base_url()?>assets/admin/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="<?=base_url()?>assets/admin/vendor/charts/c3charts/c3.min.js"></script>
    <script src="<?=base_url()?>assets/admin/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="<?=base_url()?>assets/admin/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="<?=base_url()?>assets/admin/libs/js/dashboard-ecommerce.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/toastr/toastr.min.js"></script>
</body>


</html>