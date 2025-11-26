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
    <script src="https://cdn.tiny.cloud/1/k3dyp6z9t18y59wacjgbp7fd0k4awtdhmq2j8qe570fxys3c/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <title>Add Blog</title>
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
                    Blog Management
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="card-title d-flex align-items-center">
                                    <h5 class="mb-0">Add Blog</h5>
                                </div>
                                <hr />
                                <form action="<?= base_url('add-blog') ?>" method="post" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label
                                            for="blogImage"
                                            class="col-sm-3 col-form-label">Upload Image</label>
                                        <div class="col-sm-9">
                                            <input
                                                type="file"
                                                class="form-control"
                                                id="blogImage"
                                                name="blogImage" />
                                            <div class="mt-2 text-muted">
                                                <small>Acceptable image formats JPG, JPEG, PNG, Max Size 1024KB</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="blogCate" class="col-sm-3 col-form-label">Select Blog Category</label>
                                        <div class="col-sm-9">
                                            <?php
                                            if (!empty($blogCatData)) {
                                            ?>
                                                <select name="blogCate" id="blogCate" class="form-control">
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    foreach ($blogCatData as $category) {
                                                    ?>
                                                        <option value="<?= $category['blogCatID'] ?>"><?= $category['blogCat'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label
                                            for="blogDate"
                                            class="col-sm-3 col-form-label">Date</label>
                                        <div class="col-sm-9">
                                            <input
                                                type="date"
                                                class="form-control"
                                                id="blogDate"
                                                name="blogDate"
                                                required />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label
                                            for="blogTitle"
                                            class="col-sm-3 col-form-label">Title</label>
                                        <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="blogTitle"
                                                name="blogTitle"
                                                required
                                                placeholder="Enter Title" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="blogDesp" class="col-sm-3 col-form-label">Blog Description</label>
                                        <div class="col-sm-9">
                                            <textarea
                                                class="form-control"
                                                id="blogDesp"
                                                name="blogDesp"
                                                rows="3"
                                                required
                                                placeholder="Write Blog Description"></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button
                                                type="submit"
                                                class="btn btn-primary px-5 btn-clash">
                                                Add Blog
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

    <script>
        tinymce.init({
            selector: '#blogDesp',
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            }
        });
    </script>

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