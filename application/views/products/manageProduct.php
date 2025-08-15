<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= base_url() ?>assets/images/favicon.png" type="image/png" />
    <title>Products Data</title>
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
    /* Image container and thumbnail styling */
    .thumbnail {
        width: 100px;
        cursor: pointer;
    }

    /* The lightbox (hidden by default) */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 99;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        /* Semi-transparent background */
        overflow: auto;
        opacity: 0;
        /* Start with opacity 0 */
        transition: opacity 0.5s ease;
        /* Smooth fade-in transition */
    }

    /* Lightbox image styling */
    .lightbox-content {
        max-width: 80%;
        max-height: 80%;
        margin: auto;
        display: block;
        transform: scale(0);
        /* Start with the image scaled down */
        transition: transform 0.2s ease-in-out;
        /* Smooth zoom-in effect */
    }

    /* Close button (X) styling */
    .close-btn {
        position: absolute;
        top: 10%;
        right: 30px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* Optional: Add zoom-out effect on lightbox image when it is closed */
    .lightbox.closing .lightbox-content {
        transform: scale(0);
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
                            <h2 class="pageheader-title">All Products</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"
                                                class="breadcrumb-link">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">All Products</li>
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
                                <h5 class="mb-0">Products Data</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered second"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Vendor</th>
                                                <th>Category </th>
                                                <th>Cuisine Item</th>
                                                <th>Cuisine Upc</th>
                                                <th>Product</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($products) {
                                                $sr = 1;
                                                foreach ($products as $row) {
                                            ?>
                                            <tr>
                                                <td><?= $sr . '.' ?></td>
                                                <td><?= $row['userName'] ?></td>
                                                <td><?= $row['catName'] ?></td>
                                                <!-- <td style="width: 15%;">
                                                            <div class="image-container">
                                                                <img id="myImage"  src="<?= base_url('assets/productimages/') . $row['productImage'] ?>" width="30%" alt="Thumbnail" class="thumbnail" />
                                                            </div> -->
                                                <!-- The Modal (Lightbox) -->
                                                <!-- <div id="lightbox" class="lightbox">
                                                                <span id="closeBtn" class="close-btn">&times;</span>
                                                                <img class="lightbox-content" id="lightboxImage" />
                                                            </div>

                                                        </td> -->
                                                <td><?= $row['productCuisineItem'] ?></td>
                                                <td><?= $row['productCuisineUpc'] ?></td>
                                                <td><?= $row['productName'] ?></td>
                                                <td><?= $row['productDesp'] ?><br>
                                                <strong>Dimentions</strong><br>
                                                L: <?= $row['productLength'] ?><br>
                                                    H: <?= $row['productHeight'] ?><br>
                                                    W: <?= $row['productWidth'] ?><br>
                                                    Weight: <?= $row['productWeight'] ?>
                                            </td>
                                                <td>$ <?= $row['productPrice'] ?></td>
                                               
                                                <td><?php
                                                            if ($row['productStatus'] == 1) {
                                                            ?>
                                                    <span class="text-success">Active</span>
                                                    <?php
                                                            } else {
                                                            ?>
                                                    <span class="text-danger">Inactive</span>
                                                    <?php } ?>
                                                </td>
                                                <td class="space-gap">

                                                    <?php
                                                            if ($row['productStatus'] == 1) {
                                                            ?>

                                                    <a href="<?= base_url('deactivate-product/') . $row['productID'] ?>"
                                                        onclick="return confirmDeactivate()"
                                                        class="btn btn-danger">Deactivate</a>
                                                    <?php
                                                            } else {
                                                            ?>
                                                    <a href="<?= base_url('activate-product/') . $row['productID'] ?>"
                                                        onclick="return confirmActivate()"
                                                        class="btn btn-success">Activate</a>
                                                    <?php
                                                            }
                                                            ?>
                                                    <!-- edit -->
                                                    <a style="margin-right:10px; margin-left:10px"
                                                        href="<?= base_url('edit-product/') . $row['productID'] ?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <!-- delete -->
                                                    <a href="<?= base_url('delete-product/') . $row['productID'] ?>"
                                                        onclick="return confirmDelete()">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                            <?php
                                                    $sr++;
                                                }
                                            } else {

                                                ?>
                                            <tr>
                                                <td colspan="12">
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
                                                <th>Vendor</th>
                                                <th>Category </th>
                                                <th>Cuisine Item</th>
                                                <th>Cuisine Upc</th>
                                                <th>Product</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Status</th>
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
    <script>
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
    </script>
</body>

</html>