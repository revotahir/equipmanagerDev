<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= base_url() ?>assets/images/favicon.png" type="image/png" />
    <title>Cart</title>
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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr {
            background-color: white;
        }




        .cart-totals {
            border: 1px solid #ddd;
            padding: 15px;
            width: 300px;
            margin-top: 20px;
            margin-left: auto;
            background-color: white;
        }

        .checkout {
            background-color: #bccf00;
            color: black;
            padding: 15px;
            border: none;
            width: 100%;
            text-align: center;
            display: block;
            margin-top: 10px;
            font-size: 16px;
        }

        .cancel-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
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
                            <h2 class="pageheader-title">Cart</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= base_url('customer-dashboard') ?>"
                                                class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Order Now</li>
                                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
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
                        <table>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th style="width: 12%;">Action</th>
                            </tr>
                            <?php
                            if ($cartProducts) {
                                $totalAmount = 0;
                                foreach ($cartProducts as $row) {
                                    $totalAmount += $row['price'] * $row['quantity'];
                            ?>
                                    <tr id="cartItem_<?=$row['cartID']?>">
                                        <td><button class="cancel-btn" onclick="return deleteCart(<?= $row['cartID'] ?>)"><i class="fas fa-trash-alt" style="color: white;"></i></button> <?= $row['productName'] ?></td>
                                        <td>$<?= $row['price'] ?></td>
                                        <td><input type="number" value="<?= $row['quantity'] ?>" onchange="return manageUpdateBTNDisbale(<?=$row['cartID']?>,<?= $row['quantity'] ?>)" id="qty_<?=$row['cartID']?>" name="qty_<?=$row['cartID']?>" min="1" style="width: 50px" /></td>
                                        <td id="itemSubtotal">$<?= $row['quantity'] * $row['price'] ?></td>
                                        <td>
                                            <button class="btn btn-primary mt-3 " disabled id="updateBTN_<?=$row['cartID']?>" onclick="return updatecartItem(<?=$row['cartID']?>,<?=$row['price']?>)">Update</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">
                                        <strong>
                                            <center>No Products Found</center>
                                        </strong>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr id="noProductFount" style="display: none;">
                                    <td colspan="4">
                                        <strong>
                                            <center>No Products Found</center>
                                        </strong>
                                    </td>
                                </tr>
                        </table>


                        <div class="cart-totals">
                            <h3>Cart totals</h3>
                            <span id="cardTotal">
                                <strong>Subtotal: </strong> $<?php 
                                if(isset($totalAmount)){
                                    echo $totalAmount;
                                }else{
                                    echo '0';
                                }
                                ?><br>
                                <strong>Total: </strong> $<?php 
                                if(isset($totalAmount)){
                                    echo $totalAmount;
                                }else{
                                    echo '0';
                                }
                                ?><br>
                            </span>
                            <a class="btn btn-primary mt-3" href="<?=base_url('checkout')?>" style="width: 100%;">Proceed to checkout</a>
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
        function manageUpdateBTNDisbale(cartID,qty){
            var Newqty = $('#qty_' + cartID).val();
            if(Newqty==qty){
                $('#updateBTN_'+cartID).prop('disabled', true);
            }else{
                $('#updateBTN_'+cartID).prop('disabled', false); 
            }

        }
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
                            $('#cartItem_' + cartID).fadeOut();

                            if (parts[1] == 'empty') {
                                $('#noProductFount').fadeIn;
                            } else {
                                $html='<strong>Subtotal: </strong> $'+parts[1]+'<br> <strong>Total: </strong> $'+parts[1]+'<br>';
                                $('#cardTotal').html($html);
                            }

                             //total product count
                             if (parts[2] == 'empty') {
                                $('#cartBadge').html('');
                                $('#cartBadge').html('0');
                            } else {
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

        function updatecartItem(cartID,price) {
            var qty = $('#qty_' + cartID).val();
            $('#itemSubtotal').html('$'+qty*price);
            if (qty == '' || qty==0 ) {
                toastr.options = {
                    "closeButton": true,
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.error('Please Enter Quantity!');
                $('#qty_' + cartID).css('border', '1px solid red');
                return false
            } else {
                //  Make an AJAX POST request
                $.ajax({
                    url: '<?= base_url('update-cart-qty') ?>', // URL to the controller method
                    type: 'POST', // HTTP method
                    data: {
                        cartid: cartID,
                        quantity: qty,
                    }, // Data to send

                    success: function(response) {
                        const parts = response.split('//');
                        if (parts[0] == 'done') {
                            //toaster
                            toastr.options = {
                                "closeButton": true,
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                            toastr.success('Product Quantity Updated!');
                            $('#cartItems_' + cartID).fadeOut();
                            $html='<strong>Subtotal: </strong> $'+parts[1]+'<br> <strong>Total: </strong> $'+parts[1]+'<br>';
                            $('#cardTotal').html($html);
                            $('#updateBTN_'+cartID).prop('disabled', true);
                        }
                        
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