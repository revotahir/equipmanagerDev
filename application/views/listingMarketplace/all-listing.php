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
    <style>
    .checkbox-apple {
      position: relative;
      width: 50px;
      height: 25px;
      margin: 20px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    .checkbox-apple label {
      position: absolute;
      top: 0;
      left: 0;
      width: 50px;
      height: 25px;
      border-radius: 50px;
      background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .checkbox-apple label:after {
      content: '';
      position: absolute;
      top: 1px;
      left: 1px;
      width: 23px;
      height: 23px;
      border-radius: 50%;
      background-color: #fff;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
    }

    .checkbox-apple input[type="checkbox"]:checked+label {
      background: linear-gradient(to bottom, #4cd964, #5de24e);
    }

    .checkbox-apple input[type="checkbox"]:checked+label:after {
      transform: translateX(25px);
    }

    .checkbox-apple label:hover {
      background: linear-gradient(to bottom, #b3b3b3, #e6e6e6);
    }

    .checkbox-apple label:hover:after {
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .yep {
      position: absolute;
      top: 0;
      left: 0;
      width: 50px;
      height: 25px;
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

                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
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
                    <div class="col-sm-4">
                      <select name="listingStatus" id="listingStatus" class="form-select">
                        <option value="">Select Status</option>
                        <option value="1"
                          <?php
                          if (isset($_GET['listingStatus']) && $_GET['listingStatus'] == 1) {
                            echo 'selected';
                          }
                          ?>>Approved</option>
                        <option value="2"
                          <?php
                          if (isset($_GET['listingStatus']) && $_GET['listingStatus'] == 2) {
                            echo 'selected';
                          }
                          ?>>Pending Approvals</option>
                        <option value="3"
                          <?php
                          if (isset($_GET['listingStatus']) && $_GET['listingStatus'] == 3) {
                            echo 'selected';
                          }
                          ?>>Rejected</option>
                        <option value="0"
                          <?php
                          if (isset($_GET['listingStatus']) && $_GET['listingStatus'] == 0) {
                            echo 'selected';
                          }
                          ?>>Drafts</option>
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
                  <th>Website Status</th>
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
                        <?php 
                        if($row['itemStatus']==1){
                        ?>
                        <a href="<?= base_url('change-website-listing-status/' . $row['itemID']) ?>/<?= $row['liveStatus'] ?>" data-bs-toggle="tooltip"
                          data-bs-placement="bottom"
                          title="Status">
                          <div class="checkbox-apple">
                            <input class="yep" id="check-apple" type="checkbox" <?= ($row['liveStatus'] == 1) ? 'checked' : '' ?> />
                            <label for="check-apple"></label>
                          </div>
                        </a>
                        <?php 
                        }else{
                          echo 'Not Available';
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
                            href="<?= base_url('delete-listing?itemID='.$row['itemID']) ?>"
                            onclick="return confirm('Are you sure you want to Delete the Listing?')";
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
                    <td colspan="9" class="text-center">No Listing Found</td>
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
  <script>
    // Plain JS: delegate clicks on the toggle area and redirect to the enclosing anchor's href.
    document.addEventListener('click', function(e) {
      var wrapper = e.target.closest('.checkbox-apple');
      if (!wrapper) return;
      var anchor = wrapper.closest('a');
      if (!anchor) return;
      e.preventDefault();
      // Use href (absolute or relative)
      var href = anchor.getAttribute('href');
      if (href) window.location.href = href;
    });
    // Read more / Read less toggle for testimonials
    document.addEventListener('click', function(e) {
      var toggle = e.target.closest('.toggle-desc');
      if (!toggle) return;
      e.preventDefault();
      var container = toggle.closest('.testi-desc');
      if (!container) return;
      var shortEl = container.querySelector('.text-short');
      var fullEl = container.querySelector('.text-full');
      if (!shortEl || !fullEl) return;
      var isShowingFull = shortEl.style.display === 'none';
      if (isShowingFull) {
        // currently showing full -> collapse
        shortEl.style.display = '';
        fullEl.style.display = 'none';
        toggle.textContent = 'Read more';
      } else {
        // expand
        shortEl.style.display = 'none';
        fullEl.style.display = '';
        toggle.textContent = 'Read less';
      }
    });
  </script>
    <?php
  if ($this->session->flashdata('live') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.success('Listing is Live!');
    </script>
  <?php
  }
  ?>
  <?php
  if ($this->session->flashdata('notLive') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.info('Listing is not Live!');
    </script>
  <?php
  }
  ?>
  <?php
  if ($this->session->flashdata('listingdeleted') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.success('Listing  Deleted!');
    </script>
  <?php
  }
  ?>
</body>

</html>