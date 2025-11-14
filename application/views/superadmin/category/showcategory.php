<!DOCTYPE html>
<html lang="en" class="minimal-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?= base_url() ?>assets/images/logo-icon.png" type="image/png" />
    <!--plugins-->
    <link href="<?= base_url() ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link
        href="<?= base_url() ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css"
        rel="stylesheet" />
    <link
        href="<?= base_url() ?>assets/plugins/metismenu/css/metisMenu.min.css"
        rel="stylesheet" />
    <link
        href="<?= base_url() ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css"
        rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />

    <!-- loader-->
    <link href="<?= base_url() ?>assets/css/pace.min.css" rel="stylesheet" />

    <!--Theme Styles-->
    <link href="<?= base_url() ?>assets/css/dark-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/light-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/semi-dark.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/header-colors.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/toastr/toastr.min.css" />
    <title>Manage Category</title>
    <style>
        .bg-dark-green img {
            background-color: #0b2523 !important;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <!--start wrapper-->
    <div class="wrapper">
        <?php $this->load->view('components/header'); ?>
        <?php $this->load->view('components/sidemenu'); ?>

        <!--start content-->
        <main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3" style="border: none">
                    Show All Category
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0">Manage Category</h5>
                    <div class="table-responsive mt-3">
                        <table class="table align-middle">
                            <thead class="table-secondary bg-sky-blue font-clash-green">
                                <tr>
                                    <th>Category Icon</th>
                                    <th>Category Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($supercategory)) {
                                    foreach ($supercategory as $superCat) {
                                ?>
                                        <tr>
                                            <td class="bg-dark-green">
                                                <img src="<?= base_url('assets/uploads/superadmin/category/' . $superCat['web_catIcon']) ?>" alt="icon" width="50" height="50">
                                            </td>
                                            <td><?= $superCat['web_catName'] ?></td>
                                            <td><?= $superCat['web_catDesp'] ?></td>
                                            <td><?= ($superCat['web_catStatus'] == 1) ? 'Active' : 'Inactive' ?></td>
                                            <td>
                                                <a href="<?= base_url('update-cate/' . $superCat['web_catID']) ?>" class="text-warning ms-2"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom"
                                                    title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <a href="<?= base_url('delet-cat/' . $superCat['web_catID']) ?>"
                                                    class="text-danger ms-2"
                                                    onclick="return confirm('Are you sure you want to delete this category?');"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom"
                                                    title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No Categories Added Yet!</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!--end row-->
        </main>
        <!--end page main-->

        <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
        <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class="bx bxs-up-arrow-alt"></i></a>
        <!--End Back To Top Button-->
    </div>
    <!--end wrapper-->

    <!-- Bootstrap bundle JS -->
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="<?= base_url() ?>assets/js/pace.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= base_url() ?>assets/js/table-datatable.js"></script>
    <!--app-->
    <script src="<?= base_url() ?>assets/js/app.js"></script>
    <script src="<?= base_url() ?>assets/toastr/toastr.min.js"></script>
    <?php
    if ($this->session->flashdata('success-edited') != '') {
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
    <?php
    if ($this->session->flashdata('successDeleted') != '') {
    ?>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success('Category Deleted!');
        </script>
    <?php
    }
    ?>
    <?php
    if ($this->session->flashdata('success') != '') {
    ?>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success('Category Added!');
        </script>
    <?php
    }
    ?>
    <?php
    if ($this->session->flashdata('error') != '') {
    ?>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.error('Please select a valid image file!');
        </script>
    <?php
    }
    ?>
</body>

</html>