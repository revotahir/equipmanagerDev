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
      rel="stylesheet"
    />
    <link
      href="<?= base_url() ?>assets/plugins/metismenu/css/metisMenu.min.css"
      rel="stylesheet"
    />
    <link
      href="<?= base_url() ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css"
      rel="stylesheet"
    />
    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
    />

    <!-- loader-->
    <link href="<?= base_url() ?>assets/css/pace.min.css" rel="stylesheet" />

    <!--Theme Styles-->
    <link href="<?= base_url() ?>assets/css/dark-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/light-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/semi-dark.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/header-colors.css" rel="stylesheet" />

    <title>Equipment List</title>
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
            Equipment Management
          </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
          <div class="col-xl-3 mx-auto">
            <div class="card">
              <div class="card-body">
                <div class="border p-3 rounded">
                  <h6 class="mb-0 text-uppercase">Filter By</h6>
                  <hr />
                  <form class="row g-3">
                    <div class="col-12">
                      <label class="form-label"> Name</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Enter Person Name"
                      />
                    </div>
                    <div class="col-12">
                      <label class="form-label">Category</label>
                      <select
                        name="category"
                        id="category"
                        class="form-control"
                      >
                        <option value="">Select Category</option>
                        <option value="">Category 1</option>
                        <option value="">Category 3</option>
                        <option value="">Category 4</option>
                      </select>
                    </div>
                    <!-- <div class="col-12">
                      <label class="form-label">Status</label>
                      <select name="status" id="status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="">Status 1</option>
                        <option value="">Status 3</option>
                        <option value="">Status 4</option>
                      </select>
                    </div> -->
                    <div class="col-12">
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-clash">
                          Apply Filters
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-9 mx-auto">
            <div class="card">
              <div class="card-body">
                <div
                  class="d-flex align-items-center justify-spc-btw flex-col-md"
                >
                  <h5 class="mb-0">Equipment List</h5>
                  <div class="d-flex gap-20 justify-spc-btw-md flex-col-sm">
                    <div class="d-grid">
                      <!-- This is your button, now wrapped in a label -->
                      <!-- Button trigger modal -->
                      <button
                        type="button"
                        class="btn btn-primary btn-clash-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal"
                      >
                        Add Equipment
                      </button>
                    </div>
                    <div class="d-grid">
                      <!-- Manage Skills Button -->
                      <button
                        type="button"
                        class="btn btn-primary btn-clash-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#manageskills"
                      >
                        Manage Category
                      </button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive mt-3">
                  <table class="table align-middle">
                    <thead class="table-secondary bg-sky-blue font-clash-green">
                      <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div
                            class="d-flex align-items-center gap-3 cursor-pointer"
                          >
                            <img
                              src="<?= base_url() ?>assets/images/avatars/avatar-1.png"
                              class="rounded-circle"
                              width="44"
                              height="44"
                              alt=""
                            />
                            <div class="">
                              <p class="mb-0">Forklift Model X</p>
                            </div>
                          </div>
                        </td>
                        <td>Heavy Machinery</td>
                        <td>
                          <span class="badge text-success">Available</span>
                        </td>
                        <td>
                          <div
                            class="table-actions d-flex align-items-center gap-3 fs-6"
                          >
                            <a
                              href="javascript:;"
                              class="text-primary"
                              data-bs-toggle="tooltip"
                              data-bs-placement="bottom"
                              title="Views"
                              ><i class="bi bi-eye-fill"></i
                            ></a>
                            <a
                              href="javascript:;"
                              class="text-warning"
                              data-bs-toggle="tooltip"
                              data-bs-placement="bottom"
                              title="Edit"
                              ><i class="bi bi-pencil-fill"></i
                            ></a>
                            <a
                              href="javascript:;"
                              class="text-danger"
                              data-bs-toggle="tooltip"
                              data-bs-placement="bottom"
                              title="Delete"
                              ><i class="bi bi-trash-fill"></i
                            ></a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!--end row-->
      </main>
      <!--end page main-->

      <!-- popup start -->

      <!-- Modal -->
      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Equipment</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <!-- body code -->

              <div class="row">
                <div class="card">
                  <div class="card-body">
                    <div class="border p-3 rounded">
                      <h6 class="mb-0 text-uppercase">Add Equipment</h6>
                      <hr />
                      <form class="row g-3">
                        <div class="col-12">
                          <label class="form-label">Equipment Name</label>
                          <input
                            type="text"
                            class="form-control"
                            placeholder="Enter Equipment Name"
                          />
                        </div>
                        <div class="col-12">
                          <div class="d-flex align-items-center gap-20 mb-3">
                            <label class="form-label mb-0"
                              > Equipment Category</label
                            >
                          </div>
                          <select name="skill" id="skill" class="form-control">
                            <option value="">Select  Equipment Category</option>
                            <option value="">Equipment Category 1</option>
                            <option value="">Equipment Category 3</option>
                            <option value="">Equipment Category 4</option>
                          </select>
                        </div>
                        <div class="col-12">
                          <label class="form-label">Upload Image</label>
                          <input type="file" class="form-control" />
                        </div>
                        <!-- <div class="col-12">
                      <label class="form-label">Password</label>
                      <input
                        type="password"
                        class="form-control"
                        placeholder="Enter Password"
                      />
                    </div> -->
                        <div class="col-12">
                          <label class="form-label">Description</label>
                          <textarea
                            class="form-control"
                            placeholder="Write Here"
                            rows="4"
                            cols="4"
                          ></textarea>
                        </div>
                        <div class="col-12">
                          <div class="d-grid">
                            <button
                              type="submit"
                              class="btn btn-primary btn-clash"
                            >
                              Add Equipment
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- body code end here -->
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- popup end -->

      <!-- second popup here -->

      <div
        class="modal fade"
        id="manageskills"
        tabindex="-1"
        aria-labelledby="manageskillsLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="manageskillsLabel">
                Manage Category
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <!-- body code -->

              <div class="row">
                <div class="card">
                  <div class="card-body">
                    <div class="border p-4 rounded">
                      <div class="card-title d-flex align-items-center">
                        <h5 class="mb-0">Add Equipment Category</h5>
                      </div>
                      <hr />
                      <div class="row mb-3">
                        <label
                          for="inputEnterYourName"
                          class="col-sm-3 col-form-label"
                          >Category Name</label
                        >
                        <div class="col-sm-9">
                          <input
                            type="text"
                            class="form-control"
                            id="inputEnterYourName"
                            placeholder="Enter New Equipment Name"
                          />
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label
                          for="inputAddress4"
                          class="col-sm-3 col-form-label"
                          >Description</label
                        >
                        <div class="col-sm-9">
                          <textarea
                            class="form-control"
                            id="inputAddress4"
                            rows="3"
                            placeholder="Write Description"
                          ></textarea>
                        </div>
                      </div>

                      <div class="row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                          <button
                            type="submit"
                            class="btn btn-primary px-5 btn-clash"
                          >
                            Add Category
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- body code end here -->
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- second popup end -->

      <!--start overlay-->
      <div class="overlay nav-toggle-icon"></div>
      <!--end overlay-->

      <!--Start Back To Top Button-->
      <a href="javaScript:;" class="back-to-top"
        ><i class="bx bxs-up-arrow-alt"></i
      ></a>
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
  </body>
</html>
