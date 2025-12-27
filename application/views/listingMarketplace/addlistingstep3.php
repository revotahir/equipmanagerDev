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

  <title>Marketplace Listing</title>
  <style>
    .width-ctrl {
      --width: 25%;
    }

    .white {
      color: #ffffff;
    }

    .form-check-input:checked {
      background-color: #0f2f2c;
      border-color: #0f2f2c;
    }

    @media (max-width: 550px) {
      .width-ctrl {
        --width: 37%;
      }

      .multi_tabs-container {
        & .multi_tabs-btn {
          & .tab-btn {
            & ._circle {
              width: 70px;
              font-size: 14px;
            }
          }
        }
      }
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
          Equipment Listings
        </div>
      </div>
      <!--end breadcrumb-->

      <div class="col-xl-12 mx-auto">
        <!--  STEPS -->
        <div
          class="multi_tabs-container col-12"
          id="multiTabsBtnsContentSection">
          <!-- Btns -->
          <div class="multi_tabs_btns-container">
            <div class="multi_tabs_btns-wrapper">
              <!-- Btn -->
              <div class="multi_tabs-btn 
                
                width-ctrl">
                <div class="tab-progress-bar"></div>
                <button class="tab-btn">
                  <span class="_circle">Step 1</span>
                </button>
              </div>
              <!-- Btn -->
              <div class="multi_tabs-btn 
                
                width-ctrl">
                <div class="tab-progress-bar"></div>
                <button class="tab-btn">
                  <span class="_circle">Step 2</span>
                </button>
              </div>
              <!-- Btn -->
              <div class="multi_tabs-btn active_tab" style="--width: 50%">
                <div class="tab-progress-bar"></div>
                <button class="tab-btn">
                  <span class="_circle">Step 3</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- HAMZA STEPS -->

        <div class="multi_tabs_content-container">


          <!-- for workforce step 2  -->
          <div class="multi_tab_content" id="third-box">
            <div class="card">
              <div class="card-body">
                <!-- inner card 3nd start here-->
                <div class="row">
                  <div class="col-xl-12 mx-auto">
                    <!-- <div class="card">
                    <div class="card-body"> -->
                    <div class="border p-3 rounded">
                      <h6 class="mb-0 text">Rental terms</h6>
                      <hr />
                      <form class="row g-3" method="post" action="<?= base_url('add-step-3-data/?listingID=' . $_GET['listingID']) ?>">
                        <?php
                        if (isset($_GET['edit'])) {
                        ?>
                          <input type="hidden" name="edit" value="1">
                        <?php
                        }
                        ?>
                        <div class="col-12">
                          <div class="d-flex align-items-center gap-20 mb-3">
                            <label class="form-label mb-0">Add delivery options</label>
                          </div>
                          <select
                            name="devliveryOpt"
                            id="devliveryOpt"
                            required
                            class="form-control">
                            <option value="">Select Delivery Option</option>
                            <option
                              <?php
                              if (isset($_GET['edit'])) {
                                if ($listingOptions[0]['eqpDeliveryOpt'] == 1) {
                                  echo 'selected';
                                }
                              }
                              ?>
                              value="1">Can be delivered</option>
                            <option
                              <?php
                              if (isset($_GET['edit'])) {
                                if ($listingOptions[0]['eqpDeliveryOpt'] == 2) {
                                  echo 'selected';
                                }
                              }
                              ?>
                              value="2">Pickup</option>
                          </select>
                        </div>

                        <div class="col-12">
                          <label class="form-label">Set rules
                            <span class="text-muted">(damage, return, etc.)</span></label>
                          <textarea
                            class="form-control"
                            rows="4"
                            cols="4"
                            id="rules"
                            name="rules"
                            placeholder="Write Here"> <?php if (isset($_GET['edit'])) {
                                                        echo $listingOptions[0]['eqpRules'];
                                                      } ?></textarea>
                        </div>
                        <?php
                        if ($listing[0]['saleType'] == 0) {
                        ?>
                          <div class="col-12">
                            <label class="form-label">Write notes for renter</label>
                            <textarea
                              class="form-control"
                              rows="4"
                              cols="4"
                              id="rentalNotes"
                              name="rentalNotes"
                              placeholder="Write Here"><?php if (isset($_GET['edit'])) {
                                                          echo $listingOptions[0]['noteForRenter'];
                                                        } ?></textarea>
                          </div>

                          <div class="col-12">
                            <label class="form-label">Add requirements for renters
                              <span class="text-muted">(if any)</span></label>
                            <textarea
                              class="form-control"
                              rows="4"
                              cols="4"
                              id="rentalReq"
                              name="rentalReq"
                              placeholder="Write Here"><?php if (isset($_GET['edit'])) {
                                                          echo $listingOptions[0]['addRequirments'];
                                                        } ?></textarea>
                          </div>
                        <?php
                        }
                        ?>
                        <div class="col-12">
                          <div class="d-grid">
                            <button
                              type="submit"
                              class="btn btn-primary btn-clash">
                              <?php
                              if (isset($_GET['edit'])) {
                              ?>
                                Update & Submit For Approval
                              <?php
                              } else {
                              ?>
                                Submit For Approval
                              <?php
                              }
                              ?>
                            </button>
                          </div>
                        </div>
                      </form>
                      <!-- </div>
                    </div> -->
                    </div>
                  </div>
                </div>
                <!-- inner card 3nd end here-->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--end row-->
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
  <!--app-->
  <script src="<?= base_url() ?>assets/js/app.js"></script>
  <script src="<?= base_url() ?>assets/js/step.js"></script>
  <script src="<?= base_url() ?>assets/toastr/toastr.min.js"></script>
  <?php
  if ($this->session->flashdata('drafted') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.info('Listing Drafted!');
    </script>
  <?php
  }
  ?>
  <?php
  if ($this->session->flashdata('updated') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.info('Listing Updated, Drafted!');
    </script>
  <?php
  }
  ?>
</body>

</html>