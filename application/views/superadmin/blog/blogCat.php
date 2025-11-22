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

    <title>Manage Blog Category</title>
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
                    Blog Category Management
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="card-title d-flex align-items-center">
                                    <h5 class="mb-0">Add Blog Category</h5>
                                </div>
                                <hr />
                                <form action="<?= base_url('add-blog-category-data') ?>" method="post">

                                    <div class="row mb-3">
                                        <label for="catName" class="col-sm-3 col-form-label">Category Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="catName" placeholder="Category Name" id="catName">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="catDesc" class="col-sm-3 col-form-label">Category Description</label>
                                        <div class="col-sm-9">
                                            <textarea
                                                class="form-control"
                                                id="catDesc"
                                                name="catDesc"
                                                rows="3"
                                                required
                                                placeholder="Blog Category Description"></textarea>
                                        </div>
                                    </div>
                                    <div class="card-title d-flex align-items-center">
                                        <h5 class="mb-0">Category page SEO (Optional)</h5>
                                    </div>
                                    <hr />
                                    <div class="row mb-3">
                                        <label
                                            for="metaTittle"
                                            class="col-sm-3 col-form-label">Page Tittle<br><span>(Don't fill if you want auto generate)</span></label>
                                        <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="metaTittle"
                                                name="metaTittle"
                                                placeholder="Page Title" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label
                                            for="metaDesc"
                                            class="col-sm-3 col-form-label">Meta Description</label>
                                        <div class="col-sm-9">
                                            <textarea
                                                class="form-control"
                                                id="metaDesc"
                                                name="metaDesc"
                                                rows="3"
                                                placeholder="Meta Description"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label
                                            for="metaKeyword"
                                            class="col-sm-3 col-form-label">Meta Keyword<br><span>(Seperate each keywork by coma , )</span></label>
                                        <div class="col-sm-9">
                                            <textarea
                                                class="form-control"
                                                id="metaKeyword"
                                                name="metaKeyword"
                                                rows="3"
                                                placeholder="Meta Keywords"></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3">

                                        <div class="col-sm-6">
                                            <label for="heading1">heading 1</label>
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="heading1"
                                                name="heading1"
                                                placeholder="Heading 1" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="heading2">heading 2</label>
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="heading2"
                                                name="heading2"
                                                placeholder="Heading 2" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">

                                        <div class="col-sm-6">
                                            <label for="headingDesc1">Heading description 1</label>
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="headingDesc1"
                                                name="headingDesc1"
                                                placeholder="Heading Description 1" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="headingDesc2">Heading description 2</label>
                                            <input
                                                class="form-control"
                                                type="text"
                                                id="headingDesc2"
                                                name="headingDesc2"
                                                placeholder="Heading Description 2" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-9">
                                            <button
                                                type="submit"
                                                class="btn btn-primary px-5 btn-clash">
                                                Add Blog Category
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->

            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0">Category List</h5>
                    <div class="table-responsive mt-3">
                        <table class="table align-middle">
                            <thead class="table-secondary bg-sky-blue font-clash-green">
                                <tr>
                                    <th>Sr.</th>
                                    <th>Category Name</th>
                                    <th>Category Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($showtestimonialdata)) {
                                    foreach ($showtestimonialdata as $superTesti) { ?>
                                        <tr>
                                            <th><?= !empty($superTesti['web_testimonialRating']) ? $superTesti['web_testimonialRating'] . ' Star' : '' ?></th>
                                            <td><?= $superTesti['web_testimonialDesp'] ?></td>
                                            <td>
                                                <img src="<?= base_url('assets/uploads/superadmin/testimonial/' . $superTesti['web_testimonialImg']) ?>" alt="Image" width="50" height="50" class="ms-2">
                                            </td>
                                            <td><?= $superTesti['web_testimonialName'] ?></td>
                                            <td><?= $superTesti['web_testimonialLocation'] ?></td>
                                            <td>
                                                <?php
                                                if ($superTesti['web_testimonialStatus'] == 1) {
                                                ?>
                                                    Active<?php
                                                        } else {
                                                            ?>
                                                    Inactive<?php
                                                        } ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('update-testmoni/' . $superTesti['web_testimonialID']) ?>" class="text-warning ms-2"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom"
                                                    title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                                <a href="<?= base_url('delet-testmoni/' . $superTesti['web_testimonialID']) ?>"
                                                    class="text-danger ms-2"
                                                    onclick="return confirm('Are you sure you want to delete this testimonial?');"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom"
                                                    title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No Blog Category Added Yet!</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
            toastr.success('Testimonial Updated!');
        </script>
    <?php
    }
    ?>
    <?php
    if ($this->session->flashdata('successadded') != '') {
    ?>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success('Blog Category Added!');
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
            toastr.success('Testimonial Deleted!');
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
            toastr.error('Please fill out all fields!');
        </script>
    <?php
    }
    ?>
</body>

</html>