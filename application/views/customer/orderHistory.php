<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= base_url() ?>assets/images/favicon.png" type="image/png" />
    <title>Order History</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?= base_url() ?>assets/admin/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/libs/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/admin/vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/admin/vendor/datatables/css/buttons.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/admin/vendor/datatables/css/select.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="<?= base_url() ?>assets/admin/vendor/datatables/css/fixedHeader.bootstrap4.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/toastr/toastr.min.css">

    <style>
        .space-gap {
            /* display: flex;
        align-items: center;
        gap: 20px; */

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
                            <h2 class="pageheader-title">Order History</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= base_url('customer-dashboard') ?>"
                                                class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Order History</li>
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
                            <div class="card-header">
                                <h5 class="mb-0">Order Data</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered second"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Order# </th>
                                                <th>Order Date </th>
                                                <th>Delivery/Pickup</th>
                                                <th>Addition Notes</th>
                                                <th>Total Bill</th>
                                                <th>Order Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($orderList) {
                                                foreach ($orderList as $row) {
                                            ?>
                                                    <tr >

                                                        <td><?= $row['checkoutID'] ?></td>
                                                        <td><?= $row['checkoutDate'] ?></td>

                                                        <td>
                                                            Address Type: <?=($row['addType']==1)?'Delivery':'Pickup'?>
                                                            <?= $row['address'] ?><br>
                                                            <?= $row['address2'] ?><br>
                                                            <?= $row['state'] ?>, <?=$row['country']?><br>
                                                            ZIP: <?=$row['zip']?>
                                                        </td>
                                                      
                                                        <td>
                                                            <?=$row['addQuestions']?>
                                                        </td>
                                                        <td>
                                                            $<?=$row['totalBill']?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                if($row['orderStatus']==1){
                                                                    echo 'In Process';
                                                                }else if($row['orderStatus']==2){
                                                                    echo 'In route';
                                                                }else if($row['orderStatus']==3){
                                                                    echo "Delivered";
                                                                }else if($row['orderStatus']==4){
                                                                    echo "Rescheduled";
                                                                }else{
                                                                    echo "Cancelled";
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                           <a href="<?=base_url('order-invoice/'.$row['checkoutID'])?>" class="btn btn-primary"><i class="fas fa-eye"></i> View Invoice</a>
                                                        </td>

                                                    </tr>
                                                <?php
                                                }
                                            } else {

                                                ?>
                                                <tr>
                                                    <td colspan="9">
                                                        <center>No Data Found!</center>
                                                    </td>
                                                </tr>
                                            <?php

                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            <th>Order# </th>
                                            <th>Order Date </th>
                                                <th>Delivery/Pickup</th>
                                                <th>Addition Notes</th>
                                                <th>Total Bill</th>
                                                <th>Order Status</th>
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
    <script src="<?= base_url() ?>assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="<?= base_url() ?>assets/admin/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="<?= base_url() ?>assets/admin/vendor/multi-select/js/jquery.multi-select.js"></script>
    <script src="<?= base_url() ?>assets/admin/libs/js/main-js.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/vendor/datatables/js/data-table.js"></script>
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

    <script>
        function deleteCart(cartID) {
            if (confirm('Are you sure you want to delete?')) {
                $.ajax({
                    url: '<?= base_url('delet-cart-item') ?>',
                    type: 'POST',
                    data: {
                        cartid: cartID
                    },
                    success: function(response) {
                        const parts = response.split('//');
                        if (parts[0] == 'done') {
                            //toaster
                            toastr.options = {
                                "closeButton": true,
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            toastr.success('Product Deleted From Cart!');
                            $('#cartItems_' + cartID).fadeOut();
                            // alert(parts[1]);
                            if (parts[1] == 'empty') {
                                $html = '<li class="list-group-item" ><center><strong>No Product Added!</strong> </center></li>';
                                $('#summaryLI').html($html);
                            } else {

                                $('#totalAmount').html('$' + parts[1]);
                            }
                            //total product count
                            if (parts[2] == 'empty') {
                                $('#sumaryTotalCount').html('');
                                $('#sumaryTotalCount').html('0');
                                $('#cartBadge').html('');
                                $('#cartBadge').html('0');
                            } else {
                                $('#sumaryTotalCount').html('');
                                $('#sumaryTotalCount').html(parts[2]);
                                $('#cartBadge').html('');
                                $('#cartBadge').html(parts[2]);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error('AJAX Error: ' + status + error);
                    }
                });
            } else {
                return false;
            }
        }

        function addTocartAjax(productid, price) {
            var qty = $('#qty_' + productid).val();
            if (qty == '') {
                toastr.options = {
                    "closeButton": true,
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.error('Please Enter Quantity!');
                $('#qty_' + productid).css('border', '1px solid red');

            } else {
                //  Make an AJAX POST request
                $.ajax({
                    url: '<?= base_url('add-to-cart-data') ?>', // URL to the controller method
                    type: 'POST', // HTTP method
                    data: {
                        productID: productid,
                        quantity: qty,
                        price: price
                    }, // Data to send

                    success: function(response) {
                        const parts = response.split('//');
                        //run toaster based on cart update
                        if (parts[0] == 'QtyUpdated') {
                            toastr.options = {
                                "closeButton": true,
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            toastr.info('Quantity Added!');

                        } else {
                            toastr.options = {
                                "closeButton": true,
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            toastr.success('Product Added To Cart!');
                        }
                        //update sumery
                        $('#summaryLI').html('');
                        $('#summaryLI').html(parts[1]);

                        //update total Amount
                        $('#sumaryTotalCount').html('');
                        $('#sumaryTotalCount').html(parts[2]);
                        $('#cartBadge').html('');
                        $('#cartBadge').html(parts[2]);

                        //reset input value
                        $('#qty_' + productid).val('');
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error('AJAX Error: ' + status + error);
                    }
                });
            }

        }
    </script>
    <!-- deactive -->
    <?php
    if ($this->session->flashdata('checkoutDone') != '') {
    ?>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success('Order Placed!');
        </script>
    <?php
    }
    ?>
    <?php
    if ($this->session->flashdata('ProductDeactivated') != '') {
    ?>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.error('Product Deactivated!');
        </script>
    <?php
    }
    ?>
    <!-- active -->
    <?php
    if ($this->session->flashdata('PRoductActivate') != '') {
    ?>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success('Product Activated!');
        </script>
    <?php
    }
    ?>
    <!-- delete -->
    <?php
    if ($this->session->flashdata('productDeleted') != '') {
    ?>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success('Product Deleted!');
        </script>
    <?php
    }
    ?>
    <!-- vendor Update -->
    <?php
    if ($this->session->flashdata('ProductUpdated') != '') {
    ?>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success('Product Updated!');
        </script>
    <?php
    }
    ?>
    <script>
        function confirmDeactivate() {
            if (confirm('Are you sure you want to deactivate?')) {
                return true;
            } else {
                return false;
            }
        }

        function confirmActivate() {
            if (confirm('Are you sure you want to activate?')) {
                return true;
            } else {
                return false;
            }
        }

        function confirmDelete() {
            if (confirm('Are you sure you want to delete?')) {
                return true;
            } else {
                return false;
            }
        }
    </script>
    <!-- <script>
        // Get the elements
        const lightbox = document.getElementById("lightbox");
        const lightboxImage = document.getElementById("lightboxImage");
        const closeBtn = document.getElementById("closeBtn");
        const myImage = document.getElementById("myImage");

        // When the image is clicked, open the lightbox with zoom effect
        myImage.onclick = function() {
            lightbox.style.display = "flex";
            lightbox.style.opacity = 1; // Fade in the lightbox
            lightboxImage.src = this.src; // Set the lightbox image to the clicked image
            // Optional: Zoom the image as it appears
            setTimeout(() => {
                lightboxImage.style.transform = "scale(1)"; // Zoom-in effect
            }, 10); // Small delay to trigger the transition
        };

        // When the close button is clicked, add zoom-out effect and close the lightbox
        closeBtn.onclick = function() {
            lightbox.classList.add("closing");
            lightboxImage.style.transform = "scale(0)";
            lightbox.classList.remove("closing"); // Add 'closing' class for zoom-out effect
            setTimeout(() => {
                lightbox.style.display = "none";
                // Remove 'closing' class after the transition ends
            }, 500); // Timeout duration matches the transition time (0.5s)
        };
    </script> -->
</body>

</html>