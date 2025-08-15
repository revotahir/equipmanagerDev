<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?= base_url() ?>assets/admin/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/libs/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <title>Checkout</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <?php
        $this->load->view('components/header');
        ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
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
                                <h2 class="pageheader-title">Checkout </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?= base_url('customer-dashboard') ?>"
                                                    class="breadcrumb-link">Dashboard</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Order Now</li>
                                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
                                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="mb-0">Delivery/Pickup address</h4>
                                        </div>
                                        <div class="card-body">
                                            <form class="needs-validation" method="post" novalidate="" action="<?=base_url('checkout-data')?>">

                                                <div class="mb-3">
                                                    <label for="address">Address</label>
                                                    <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
                                                    <div class="invalid-feedback">
                                                        Please enter your shipping address.
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment or suite">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5 mb-3">
                                                        <label for="country">Country</label>
                                                        <input type="text" class="form-control" id="country" name="country" value="United States" placeholder="Country Name">
                                                        <div class="invalid-feedback">
                                                            Please enter your Country Name.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="state">State</label>
                                                        <input type="text" class="form-control" id="state" name="state" placeholder="State">
                                                        <div class="invalid-feedback">
                                                            Please enter your State.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="zip">Zip</label>
                                                        <input type="text" class="form-control" id="zip" name="zip" placeholder="" required="">
                                                        <div class="invalid-feedback">
                                                            Zip code required.
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mb-4">
                                                <h4 class="mb-3">Adress Type</h4>
                                                <div class="d-block my-3">
                                                    <div class="custom-control custom-radio">
                                                        <input id="delivery" name="addType" value="1" type="radio" class="custom-control-input" checked="" required="">
                                                        <label class="custom-control-label" for="delivery">Delivery</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input id="pickup" name="addType" type="radio" value="2" class="custom-control-input" required="">
                                                        <label class="custom-control-label" for="pickup">Pickup</label>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="addQuestion">Additional Notes</label>
                                                        <textarea name="addQuestion" id="addQuestion" class="form-control"></textarea>

                                                    </div>

                                                </div>

                                                <hr class="mb-4">
                                                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="d-flex justify-content-between align-items-center mb-0">
                                                <span class="text-muted">Your cart</span>
                                                <span class="badge badge-secondary badge-pill"> <?= $cartCount[0]['result'] ?></span>
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group mb-3">
                                                <?php
                                                if ($cartProduct) {
                                                    $totalAmount = 0;
                                                    foreach ($cartProduct as $row) {
                                                        $totalAmount += $row['price'] * $row['quantity'];
                                                ?>
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <div>
                                                                <h6 class="my-0"><?= $row['productName'] ?></h6>
                                                                <small class="text-muted"><?= $row['productDesp'] ?></small>
                                                            </div>
                                                            <span class="text-muted">$<?= $row['price'] ?> x <?= $row['quantity'] ?></span>
                                                        </li>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <li class="list-group-item">
                                                        <center>
                                                            <strong>No Product Added!</strong>
                                                        </center>
                                                    </li>
                                                <?php
                                                }
                                                ?>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Total (USD)</span>
                                                    <strong>$<?php
                                                                    if (isset($totalAmount)) {
                                                                        echo $totalAmount;
                                                                    } else {
                                                                        echo '0';
                                                                    }
                                                                    ?></strong>
                                                </li>
                                            </ul>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             
            </div>
            <!-- ============================================================== -->
            <!-- end wrapper  -->
            <!-- ============================================================== -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1  -->
    <script src="<?= base_url() ?>assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js-->
    <script src="<?= base_url() ?>assets/admin/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js-->
    <script src="<?= base_url() ?>assets/admin/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js-->
    <script src="<?= base_url() ?>assets/admin/libs/js/main-js.js"></script>
</body>


</html>