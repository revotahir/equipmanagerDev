<!doctype html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?=base_url()?>assets/images/favicon.png" type="image/png" />
    <title>Add Products</title>
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
                            <h2 class="pageheader-title">Add Products</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>"
                                                class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Products</li>
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
                            <h5 class="card-header">Products Form</h5>
                            <div class="card-body">
                                <form class="needs-validation" novalidate method="post"
                                    action="<?=base_url('add-product-data')?>" enctype="multipart/form-data">
                                    <div class="row">
                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="vendorID">Select Vendor</label>
                                            <select name="vendorID" id="vendorID" required class="form-control">
                                                <option value="">Select Vendor</option>
                                                <?php 
                                                    if($vendors){
                                                        foreach($vendors as $row){
                                                ?>
                                                <option value="<?=$row['userID']?>"><?=$row['userName']?></option>
                                                <?php 
                                                        }
                                                    }
                                                    ?>
                                            </select>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a select vendor.
                                            </div>

                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="catID">Product Category</label>
                                            <select required name="catID" id="catID" class="form-control">
                                                <option value="">Select Category</option>
                                                <?php 
                                                    if($categories){
                                                        foreach($categories as $row){
                                                ?>
                                                <option value="<?=$row['catID']?>"><?=$row['catName']?></option>
                                                <?php 
                                                        }
                                                    }
                                                    ?>
                                            </select>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a select category.
                                            </div>

                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="product-name">Product Name</label>
                                            <input type="text" class="form-control" id="product-name"
                                                name="product-name" placeholder="Product Name" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a product name.
                                            </div>
                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="price">Product Price($)</label>
                                            <input type="number" class="form-control" id="price" name="price"
                                                placeholder="Product Price" step="any" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a valid product price.
                                            </div>
                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="cuisine-item">Product Cuisine Item</label>
                                            <input type="text" class="form-control" id="cuisine-item"
                                                name="cuisine-item" placeholder="Product Cuisine Item" step="any"
                                                required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a valid product cuisine item.
                                            </div>
                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="cuisine-upc">Product Cuisine UPC</label>
                                            <input type="text" class="form-control" id="cuisine-upc" name="cuisine-upc"
                                                placeholder="Product Cuisine UPC" step="any" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a valid product cuisine upc.
                                            </div>
                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-3 col-lg-3 col-md-6  col-sm-12 col-12 m-t-10">
                                            <label for="product-length">Length</label>
                                            <input type="text" class="form-control" id="product-length"
                                                name="product-length" placeholder="Product Length" step="any" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a valid product cuisine upc.
                                            </div>
                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 m-t-10">
                                            <label for="product-height">Height</label>
                                            <input type="text" class="form-control" id="product-height"
                                                name="product-height" placeholder="Product Height" step="any" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a valid product height.
                                            </div>
                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 m-t-10">
                                            <label for="product-width">Width</label>
                                            <input type="text" class="form-control" id="product-width"
                                                name="product-width" placeholder="Product Width" step="any" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a valid product width.
                                            </div>
                                        </div>
                                        <!-- field  -->
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 m-t-10">
                                            <label for="product-weight">Weight</label>
                                            <input type="text" class="form-control" id="product-weight"
                                                name="product-weight" placeholder="Product Weight" step="any" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a valid product weight.
                                            </div>
                                        </div>

                                        <!-- field  -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="Description">Product Description</label>
                                            <textarea name="Description" id="Description" class="form-control"
                                                required></textarea>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a product description.
                                            </div>

                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-10">
                                            <label for="productImage">Product Image</label>
                                            <input type="file" name="productImage" id="productImage"
                                                class="form-control">
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 m-t-20">
                                            <button class="btn btn-primary" type="submit">Add Product</button>
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
    if ($this->session->flashdata('uploadError') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.error('<?= $this->session->flashdata('uploadError'); ?>');
    </script>
    <?php
    }
    ?>

    <?php
    if ($this->session->flashdata('productUploaded') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.success('Product Added!');
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

</body>

</html>