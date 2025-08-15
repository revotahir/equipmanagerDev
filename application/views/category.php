<!doctype html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?=base_url()?>assets/images/favicon.png" type="image/png" />
    <title>Add Category</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?=base_url()?>assets/admin/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/libs/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin/vendor/fonts/fontawesome/css/fontawesome-all.css">
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
                            <h2 class="pageheader-title">Add Category</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>"
                                                class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Category</li>
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
                            <h5 class="card-header">Category Form</h5>
                            <div class="card-body">
                                <form class="needs-validation" novalidate method="post"
                                    action="<?=base_url('add-category')?>">
                                    <div class="row">
                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <label for="cat-name">Category name</label>
                                            <input type="text" class="form-control" id="cat-name" name="cat-name"
                                                placeholder="Enter Category" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a user name.
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- ============================================================== -->
                        <!-- data table  -->
                        <!-- ============================================================== -->
                        <div class="card m-t-10">
                            <Div class="card-header">
                                <h5 class="mb-0">Category Data</h5>
                            </Div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered second"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Category Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($categoryList){
                                                $sr=1;
                                                foreach($categoryList as $row){
                                            ?>
                                            <tr>
                                                <td><?=$sr.'.'?></td>
                                                <td><?=$row['catName']?></td>
                                                <td class="space-gap">
                                                    <!-- edit -->
                                                    <a href="<?=base_url('edit-category/').$row['catID']?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <!-- delete -->
                                                    <a href="<?=base_url('delete-category/').$row['catID']?>"
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
                                                <td colspan="3">
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
                                                <th>Category Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end data table  -->
                        <!-- ============================================================== -->

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
    if ($this->session->flashdata('successfullyAdded') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.success('Category Added Successfully!');
    </script>
    <?php
    }
    ?>
    <!-- delete -->
    <?php
    if ($this->session->flashdata('categoryDeleted') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.error('Category Deleted!');
    </script>
    <?php
    }
    ?>
    <!-- category Update -->
    <?php
    if ($this->session->flashdata('CategoryUpdated') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.success('Category Updated!');
    </script>
    <?php
    }
    ?>
    <script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete category? !!All Products will be Deleted with this category!!')) {
            return true;
        } else {
            return false;
        }
    }
    </script>


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