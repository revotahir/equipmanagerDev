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

  <title>All Listing</title>
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
          Market Place Listing
        </div>
      </div>
      <!--end breadcrumb-->

      <div class="row">
        <div class="col-xl-12 mx-auto">
          <div class="card">
            <div class="card-body">
              <form method="get" id="filterForm" name="filterForm">
                <div class="border p-4 rounded">
                  <div class="card-title d-flex align-items-center">
                    <h5 class="mb-0">Filter By</h5>
                  </div>
                  <hr />
                  <div class="row mb-3">

                    <div class="col-sm-6">
                      <select name="ItemType" id="ItemType" class="form-control">
                        <option value="">Select Item Type</option>
                        <option value="1" 
                        <?php 
                          if(isset($_GET['ItemType']) && $_GET['ItemType']==1){
                            echo 'selected';
                          }
                        ?>
                        >Equipment</option>
                        <option value="2"
                          <?php 
                          if(isset($_GET['ItemType']) && $_GET['ItemType']==2){
                            echo 'selected';
                          }
                        ?>
                        >Workforce</option>
                      </select>
                    </div>
                    <div class="col-sm-6">
                      <select name="listingType" id="listingType" class="form-select">
                        <option value="">Select Listing Type</option>
                        <option value="1" 
                          <?php 
                          if(isset($_GET['listingType']) && $_GET['listingType']==1){
                            echo 'selected';
                          }
                        ?>
                        >Sale</option>
                        <option value="0"
                        <?php 
                          if(isset($_GET['listingType']) && $_GET['listingType']==0){
                            echo 'selected';
                          }
                        ?>
                        >Rental</option>
                      </select>
                    </div>
                  </div>

                 

                  <div class="row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-12">
                      <button
                        type="submit"
                        class="btn btn-primary px-5 btn-clash">
                        Apply Filters
                      </button>
                      <?php
                      if (isset($_GET['ItemType'])) {
                      ?>
                        <a href="<?= base_url('all-listing') ?>" style="color:#0f2f2c;margin-left:10px"><i class="bi bi-x-lg"></i> Clear Filter</a>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h5 class="mb-0">Projects List</h5>
          <div class="table-responsive mt-3">
            <table class="table align-middle">
              <thead class="table-secondary bg-sky-blue font-clash-green">
                <tr>
                  <th>Sr.</th>
                  <th>Item Type</th>
                  <th>Item Name</th>
                  <th>Listing Type</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($listing) {
                  $sr = 1;
                  foreach ($listing as $row) {

                ?>
                    <tr>
                      <td><?= $sr . '.' ?></td>
                      <td>
                        <?php
                        if ($row['itemType'] == 1) {
                          echo 'Equipment';
                        } else {
                          echo 'Workforce';
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if ($row['itemType'] == 1) {
                          echo $row['equipName'];
                        } else {
                          echo $row['personName'];
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if ($row['saleType'] == 1) {
                          echo 'For Sale';
                        } else {
                          echo 'For Rental';
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if ($row['itemType'] == 1) {
                          echo date('j M, Y', strtotime($row['eqpAvailableStart']));
                        } else {
                          echo date('j M, Y', strtotime($row['workforceAvailableStart']));
                        }


                        ?>
                      </td>
                      <td>
                        <?php
                        if ($row['itemType'] == 1) {
                          echo date('j M, Y', strtotime($row['eqpAvailableEnd']));
                        } else {
                          echo date('j M, Y', strtotime($row['workforceAvailableEnd']));
                        }


                        ?>
                      </td>
                      <td>
                        <?php
                        if ($row['itemStatus'] == 1) {
                          echo '<span class="badge text-bg-success">Approved</span>';
                        } else if ($row['itemStatus'] == 2) {
                          echo '<span class="badge text-bg-primary">Pending Approval</span>';
                        } else if ($row['itemStatus'] == 3) {
                          echo '<span class="badge text-bg-danger">Rejected</span>';
                        } else if ($row['itemStatus'] == 0) {
                          echo '<span class="badge text-bg-warning">Drafted</span>';
                        }
                        ?>
                      </td>
                      <td>
                        <div
                          class="table-actions d-flex align-items-center gap-3 fs-6">
                          <a
                            href="<?= base_url('add-listing/?itemID='.$row['itemID']) ?>"
                            class="text-warning"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            title="Edit"><i class="bi bi-pencil-fill"></i></a>
                          <a
                            href="javascript:;"
                            onclick=""
                            class="text-danger"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            title="Delete"><i class="bi bi-trash-fill"></i></a>
                        </div>
                      </td>
                    </tr>
                  <?php
                    $sr++;
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan="8" class="text-center">No Listing Found</td>
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
  <script src="<?= base_url() ?>assets/toastr/toastr.min.js"></script>
  <!--app-->
  <script src="<?= base_url() ?>assets/js/app.js"></script>
  <?php
  if ($this->session->flashdata('deletedproject') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.success('Project Deleted!');
    </script>
  <?php
  }
  ?>
</body>

</html>