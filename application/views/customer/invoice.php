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
    <title>Invoice</title>
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
                                <h2 class="pageheader-title">Invoice </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?= base_url('customer-dashboard') ?>"
                                                    class="breadcrumb-link">Dashboard</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Order History</li>
                                            <li class="breadcrumb-item active" aria-current="page">Invoice</li>
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
                            <div class="card">
                                <div class="card-header p-4">
                                     <a class="pt-2 d-inline-block" >
                                        <img src="<?=base_url('assets/images/Logo.webp')?>" alt="">
                                     </a>
                                   
                                    <div class="float-right"> <h3 class="mb-0">Invoice #<?=$order[0]['checkoutID']?></h3>
                                    Date: <?=$order[0]['checkoutDate']?></div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-sm-6">
                                            <h5 class="mb-3">From:</h5>                                            
                                            <h3 class="text-dark mb-1">Metro Foods</h3>
                                         
                                            <!-- <div>2546 Penn Street</div>
                                            <div>Sikeston, MO 63801</div> -->
                                            <div>Email: orders@mymetrofoods.com</div>
                                            <div>Phone: N/A</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h5 class="mb-3">To:</h5>
                                            <h3 class="text-dark mb-1"><?=$userData[0]['userName']?></h3>                                            
                                            <div><?=$order[0]['address']?></div>
                                            <div><?=$order[0]['address2']?></div>
                                            <div>Email: <?=$userData[0]['userEmail']?></div>
                                            <div>Phone: <?=$userData[0]['userPhone']?></div>
                                        </div>
                                    </div>
                                    <div class="table-responsive-sm">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th class="right">Unit Cost</th>
                                                    <th class="center">Qty</th>
                                                    <th class="right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                 $totalAmount = 0;
                                                    foreach($cartProduct as $row){
                                                        $totalAmount += $row['price'] * $row['quantity'];
                                                ?>
                                                <tr>
                                                    <td class="left strong"><?=$row['productName']?></td>
                                                    <td class="left"><?= $row['productDesp'] ?><br>
                                                            <strong>Dimentions</strong><br>
                                                            L: <?= ($row['productLength'] == '') ? 'N/A' : $row['productLength'] ?>
                                                            H: <?= ($row['productHeight'] == '') ? 'N/A' : $row['productHeight'] ?>
                                                            W: <?= ($row['productWidth'] == '') ? 'N/A' : $row['productWidth'] ?><br>
                                                            Weight: <?= ($row['productWeight'] == '') ? 'N/A' : $row['productWeight'] ?>
                                                        </td>
                                                    <td class="right">$<?=$row['price']?></td>
                                                    <td class="center"><?=$row['quantity']?></td>
                                                    <td class="right">$<?=$row['quantity'] * $row['price'] ?></td>
                                                </tr>
                                                <?php 
                                                    }
                                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-5">
                                        </div>
                                        <div class="col-lg-4 col-sm-5 ml-auto">
                                            <table class="table table-clear">
                                                <tbody>
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Subtotal</strong>
                                                        </td>
                                                        <td class="right">$<?=$totalAmount?></td>
                                                    </tr>
                                                   
                                                  
                                                    <tr>
                                                        <td class="left">
                                                            <strong class="text-dark">Total</strong>
                                                        </td>
                                                        <td class="right">
                                                            <strong class="text-dark">$<?=$totalAmount?></strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- footer -->
               
                <!-- ============================================================== -->
                <!-- end footer -->
                <!-- ============================================================== -->
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
        <!-- jquery 3.3.1 -->
        <script src="<?= base_url() ?>assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
        <!-- bootstap bundle js -->
        <script src="<?= base_url() ?>assets/admin/vendor/bootstrap/js/bootstrap.bundle.js"></script>
        <!-- slimscroll js -->
        <script src="<?= base_url() ?>assets/admin/vendor/slimscroll/jquery.slimscroll.js"></script>
        <!-- main js -->
        <script src="<?= base_url() ?>assets/admin/libs/js/main-js.js"></script>
</body>
 
</html>