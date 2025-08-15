<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?=base_url()?>assets/images/favicon.png" type="image/png" />
    <title>Verders data</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?=base_url()?>assets/admin/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/libs/css/style.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" type="text/css"
        href="<?=base_url()?>assets/admin/vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?=base_url()?>assets/admin/vendor/datatables/css/buttons.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?=base_url()?>assets/admin/vendor/datatables/css/select.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?=base_url()?>assets/admin/vendor/datatables/css/fixedHeader.bootstrap4.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/toastr/toastr.min.css">
    <style>
    .space-gap {
        display: flex;
        align-items: center;
        gap: 20px;

        .fa-pencil-alt {
            fill: green;
            color: green;
        }

        .fa-trash-alt {
            fill: #ef172c;
            color: #ef172c;
        }
    }
    </style>
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
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">All Vendors</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>"
                                                class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">All Vendors</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->

                <div class="row">
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <Div class="card-header">
                                <h5 class="mb-0">Vendors Data</h5>
                            </Div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered second"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Vendor Name</th>
                                                <th>Vendor Email</th>
                                                <th>Vendor Phone</th>
                                                <th>Vendor Password</th>
                                                <th>Account Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($vendorsList){
                                                $sr=1;
                                                foreach($vendorsList as $row){
                                            ?>
                                            <tr>
                                                <td><?=$sr.'.'?></td>
                                                <td><?=$row['userName']?></td>
                                                <td><?=$row['userEmail']?></td>
                                                <td><?=$row['userPhone']?></td>
                                                <td><?=$row['userPass']?></td>
                                                <td><?php 
                                                if($row['userStatus']==1){
                                                ?>
                                                    <span class="text-success">Active</span>
                                                    <?php   
                                                }else{
                                                    ?>
                                                    <span class="text-danger">Inactive</span>
                                                    <?php } ?>
                                                </td>

                                                <td class="space-gap">
                                                    <?php
                                                if($row['userStatus']==1){
                                                ?>
                                                    <a href="<?=base_url('deactivate-vendor/').$row['userID']?>"
                                                        onclick="return confirmDeactivate()"
                                                        class="btn btn-danger">Deactivate</a>
                                                    <?php    
                                            }else{
                                                  ?>
                                                    <a href="<?=base_url('activate-vendor/').$row['userID']?>"
                                                        onclick="return confirmActivate()"
                                                        class="btn btn-success">Activate</a>
                                                    <?php 
                                                }
                                                ?>
                                                    <!-- edit -->
                                                    <a href="<?=base_url('edit-vendor/').$row['userID']?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <!-- delete -->
                                                    <a href="<?=base_url('delete-vendor/').$row['userID']?>"
                                                        onclick="return confirmDelete()">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>

                                                </td>



                                            </tr>
                                            <?php   
                                            $sr++;
                                        }
                                    }else{
                                        
                                            ?>
                                            <tr>
                                                <td colspan="7">
                                                    <center>No Data Found!</center>
                                                </td>
                                            </tr>
                                            <?php
                                            
                                    }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Vendor Name</th>
                                                <th>Vendor Email</th>
                                                <th>Vendor Phone</th>
                                                <th>Vendor Password</th>
                                                <th>Account Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end data table  -->
                    <!-- ============================================================== -->
                </div>

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="<?=base_url()?>assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="<?=base_url()?>assets/admin/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="<?=base_url()?>assets/admin/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="<?=base_url()?>assets/admin/vendor/multi-select/js/jquery.multi-select.js"></script>
    <script src="<?=base_url()?>assets/admin/libs/js/main-js.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>assets/admin/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="<?=base_url()?>assets/admin/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="<?=base_url()?>assets/admin/vendor/datatables/js/data-table.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?= base_url() ?>assets/toastr/toastr.min.js"></script>
    <!-- deactive -->
    <?php
    if ($this->session->flashdata('vendorDeactivated') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.error('Vendor Account Deactivated!');
    </script>
    <?php
    }
    ?>
    <!-- active -->
    <?php
    if ($this->session->flashdata('vendorActivated') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.success('Vendor Account Activated!');
    </script>
    <?php
    }
    ?>
    <!-- delete -->
    <?php
    if ($this->session->flashdata('vendorDeleted') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.success('Vendor Account Deleted!');
    </script>
    <?php
    }
    ?>
    <!-- vendor Update -->
    <?php
    if ($this->session->flashdata('VendorUpdated') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.success('Vendor Account Updated!');
    </script>
    <?php
    }
    ?>
    <script>
    function confirmDeactivate() {
        if (confirm('Are you sure you want to deactivate vendor account?')) {
            return true;
        } else {
            return false;
        }
    }

    function confirmActivate() {
        if (confirm('Are you sure you want to activate vendor account?')) {
            return true;
        } else {
            return false;
        }
    }

    function confirmDelete() {
        if (confirm('Are you sure you want to delete vendor account')) {
            return true;
        } else {
            return false;
        }
    }
    </script>

</body>

</html>