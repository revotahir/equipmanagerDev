<!doctype html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?=base_url()?>assets/images/favicon.png" type="image/png" />
    <title>Update Venders</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?=base_url()?>assets/admin/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/libs/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/fonts/fontawesome/css/fontawesome-all.css">
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
                            <h2 class="pageheader-title">Update Venders</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>"
                                                class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Venders</li>
                                        <li class="breadcrumb-item active" aria-current="page">Update Venders</li>
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
                    <!-- validation form -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Vender Update Form</h5>
                            <div class="card-body">
                                <form class="needs-validation" novalidate method="post"
                                    action="<?=base_url('update-vender-data/').$vendor[0]['userID']?>">
                                    <div class="row">
                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <label for="user-name">Vendor name</label>
                                            <input type="text" class="form-control" value="<?=$vendor[0]['userName']?>"
                                                id="user-name" name="user-name" placeholder="Enter Vendor" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a user name.
                                            </div>
                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="user-email">Vendor Email</label>
                                            <input type="email" class="form-control"
                                                value="<?=$vendor[0]['userEmail']?>" id="user-email" name="user-email"
                                                placeholder="Vendor Email" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a user email.
                                            </div>
                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="user-phone">Vendor Phone</label>
                                            <input type="tel" class="form-control" id="user-phone"
                                                value="<?=$vendor[0]['userPhone']?>" name="user-phone"
                                                placeholder="Vendor Phone" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a user phone.
                                            </div>
                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="user-password">Vendor Password</label>
                                            <input type="text" class="form-control" id="user-password"
                                                name="user-password" placeholder="Vendor Password"
                                                value="<?=$vendor[0]['userPass']?>" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a user password.
                                            </div>
                                            <button class="btn btn-dark m-t-10" type="button">Generate
                                                Password</button>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end validation form -->
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
    <script src="<?=base_url()?>assets/admin/vendor/parsley/parsley.js"></script>
    <script src="<?=base_url()?>assets/admin/libs/js/main-js.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/toastr/toastr.min.js"></script>

    <?php
    if ($this->session->flashdata('alreadyRegistered') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.error('Email Already Registered!');
    </script>
    <?php
    }
    ?>
    <?php
    if ($this->session->flashdata('successfullyRegistered') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.success('Vender Registered!');
    </script>
    <?php
    }
    ?>

    <script>
    $('#form').parsley();
    </script>
    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>
    <script>
    document.querySelector('.btn.btn-dark.m-t-10').addEventListener('click', function() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+';
        let password = '';
        for (let i = 0; i < 15; i++) {
            password += chars[Math.floor(Math.random() * chars.length)];
        }
        document.getElementById('user-password').value = password;
    });
    </script>
</body>

</html>