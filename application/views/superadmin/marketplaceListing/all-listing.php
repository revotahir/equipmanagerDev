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
    /* Tag styles */
    .spec-tag {
      background-color: #0f2f2c;
      color: white;
      padding: 0.5rem 0.75rem;
      border-radius: 20px;
      display: inline-block;
      font-size: 0.875rem;
      margin-right: 0.5rem;
      margin-bottom: 0.5rem;
    }
  </style>
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
                          if (isset($_GET['ItemType']) && $_GET['ItemType'] == 1) {
                            echo 'selected';
                          }
                          ?>>Equipment</option>
                        <option value="2"
                          <?php
                          if (isset($_GET['ItemType']) && $_GET['ItemType'] == 2) {
                            echo 'selected';
                          }
                          ?>>Workforce</option>
                      </select>
                    </div>
                    <div class="col-sm-4">
                      <select name="listingType" id="listingType" class="form-select">
                        <option value="">Select Listing Type</option>
                        <option value="1"
                          <?php
                          if (isset($_GET['listingType']) && $_GET['listingType'] == 1) {
                            echo 'selected';
                          }
                          ?>>Sale</option>
                        <option value="0"
                          <?php
                          if (isset($_GET['listingType']) && $_GET['listingType'] == 0) {
                            echo 'selected';
                          }
                          ?>>Rental</option>
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
                        <a href="<?= base_url('admin-marketplace-listing') ?>" style="color:#0f2f2c;margin-left:10px"><i class="bi bi-x-lg"></i> Clear Filter</a>
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
                            href="#"
                            class="text-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal_<?= $row['itemID'] ?>"

                            title="Edit"><i class="bi bi-eye-fill"></i></a>
                          <!-- Modal -->
                          <div
                            class="modal fade"
                            id="exampleModal_<?= $row['itemID'] ?>"
                            tabindex="-1"
                            aria-labelledby="exampleModalLabel_<?= $row['itemID'] ?>"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel_<?= $row['itemID'] ?>"></h5>
                                  <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <!-- body code -->

                                  <div class="row">
                                    <div class="card">
                                      <div class="card-body">
                                        <div class="border p-3 rounded">
                                          <h6 class="mb-0 text-uppercase">Review Listing Data | <?= ($row['itemType'] == 1) ? 'Equipment' : 'Workforce' ?> | <?= ($row['saleType'] == 1) ? 'For Sale' : 'For Rental' ?></h6>
                                          <hr />
                                          <table class="table align-middle">
                                            <thead class="table-secondary bg-sky-blue font-clash-green">
                                            </thead>
                                            <tbody>

                                              <tr>
                                                <th>Company/User Name Name</th>
                                                <td><?php
                                                    if ($row['companyID'] == '') {
                                                      echo $row['userID'];
                                                    } else {
                                                      echo $row['companyName'];
                                                    }
                                                    ?></td>
                                              </tr>
                                              <tr>
                                                <th>Item Name</th>
                                                <td><?php
                                                    if ($row['itemType'] == 1) {
                                                      echo $row['equipName'];
                                                    } else {
                                                      echo $row['personName'];
                                                    }
                                                    ?></td>
                                              </tr>
                                              <tr>
                                                <th>Marketplace Category</th>
                                                <td>
                                                  <?= $row['web_catName'] ?>
                                                </td>
                                              </tr>
                                              <tr>
                                                <th>Listing Duration</th>
                                                <td><?php
                                                    if ($row['itemType'] == 1) {
                                                      echo date('j M, Y', strtotime($row['eqpAvailableEnd']));
                                                    } else {
                                                      echo date('j M, Y', strtotime($row['workforceAvailableEnd']));
                                                    }


                                                    ?> -
                                                  <?php
                                                  if ($row['itemType'] == 1) {
                                                    echo date('j M, Y', strtotime($row['eqpAvailableEnd']));
                                                  } else {
                                                    echo date('j M, Y', strtotime($row['workforceAvailableEnd']));
                                                  }


                                                  ?>
                                                </td>
                                              </tr>
                                              <?php
                                              if ($row['itemType'] == 1) {
                                              ?>
                                                <tr>
                                                  <th>Equipment Quantity</th>
                                                  <td><?= $row['equipQty'] ?></td>
                                                </tr>
                                                <tr>
                                                  <th>Brand/Model</th>
                                                  <td><?= $row['eqpBrandModel'] ?></td>
                                                </tr>
                                                <tr>
                                                  <th>Specification</th>
                                                  <td>
                                                    <?php 
                                                      $specs = $row['eqpSpecs'];
                                                      if (!empty($specs)) {
                                                        $specArray = array_filter(array_map('trim', explode('|', $specs)));
                                                        foreach ($specArray as $spec) {
                                                          echo '<span class="spec-tag">' . htmlspecialchars($spec) . '</span>';
                                                        }
                                                      }
                                                    ?>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <th>Condition</th>
                                                  <td>
                                                  <?php 
                                                     if($row['eqpCondition']==1){
                echo '<span style="color:red">Major defects affecting performance, nearing end-of-life, requires significant attention or
replacement.</span>';
              }else if($row['eqpCondition']==2){
echo '<span style="color:#FFBF00">Noticeable wear, functional but approaching mid-lifecycle, maintenance recommended.</span>';
              } else if($row['eqpCondition']==3){
                echo '<span style="color:#9ACD32">Minor wear, fully functional, standard maintenance needed.</span>';
              }else{
                echo '<span style="color:#008000">Like new, no defects, optimal performance.</span>';
              }
                                                  ?>

                                                  </td>
                                                </tr>
                                                <tr>
                                                  <th>Equipment Images</th>
                                                  <td>
                                                    <?php
                                                    echo '<div class="mt-3"><div class="row">';
                                                    for ($i = 1; $i <= 10; $i++) {
                                                      $imgColumn = 'eqpimg' . $i;
                                                      if (isset($row[$imgColumn]) && !empty($row[$imgColumn])) {
                                                        echo '<div class="col-4 mb-2">
                                  <a href="' . base_url('assets/website/images/' . $row[$imgColumn]) . '" alt="Equipment Image ' . $i . '" target="_blank"><img src="' . base_url('assets/website/images/' . $row[$imgColumn]) . '" alt="Equipment Image ' . $i . '" class="img-fluid img-thumbnail" style="max-height: 120px; object-fit: cover;"></a>
                                </div>';
                                                      }
                                                    }
                                                    echo '</div></div>';
                                                    ?>
                                                  </td>
                                                </tr>
                                              <?php
                                              } else {
                                              ?>
                                                <tr>
                                                  <th>CV</th>
                                                  <td>
                                                    <div class="row">
                                                      <div class="col-1 mb-2">
                                                        <a href="<?= base_url('assets/website/documents/' . $row['workforceCV'])  ?>" target="_blank">

                                                          <img src="<?= base_url('assets/website/documents/' . $row['workforceCV'])  ?>" width="150px" alt="">
                                                        </a>
                                                      </div>
                                                    </div>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <th>Certificates</th>
                                                  <td>
                                                    <?php
                                                    if ($row['workforceCertif'] != '') {
                                                    ?>
                                                      <a href="<?= base_url('assets/website/documents/' . $row['workforceCertif'])  ?>" target="_blank">
                                                        <img src="<?= base_url('assets/website/documents/' . $row['workforceCertif'])  ?>" width="150px" alt="">
                                                      </a>
                                                    <?php
                                                    } else {
                                                      echo '-';
                                                    }
                                                    ?>
                                                  </td>
                                                </tr>
                                              <?php
                                              }
                                              ?>
                                              <tr>
                                                <th>City</th>
                                                <td>
                                                  <?= ($row['itemType'] == 1) ? $row['eqpLocCity'] : $row['workforceCity'] ?>
                                                </td>
                                              </tr>
                                              <tr>
                                                <th>Complete Address</th>
                                                <td>
                                                  <?= ($row['itemType'] == 1) ? $row['eqpAdd'] : $row['WorkforceAdd'] ?>
                                                </td>
                                              </tr>
                                              <?php
                                              if ($row['itemType'] == 1) {
                                              ?>
                                                <tr>
                                                  <th>Retanl Type</th>
                                                  <td>
                                                    <?php
                                                    if ($row['eqpRentalType'] == 1) {
                                                      echo 'Per Day';
                                                    } else if ($row['eqpRentalType'] == 2) {
                                                      echo 'Per Week';
                                                    } else if ($row['eqpRentalType'] == 3) {
                                                      echo 'Per Month';
                                                    } else {
                                                      echo 'Yearly';
                                                    }
                                                    ?>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <th>Price</th>
                                                  <td><?= $row['eqpPrice'] ?></td>
                                                </tr>
                                                <tr>
                                                  <th>Delivery Options</th>
                                                  <td>
                                                    <?php
                                                    if ($row['eqpDeliveryOpt'] == 1) {
                                                      echo 'Can be delivered';
                                                    } else {
                                                      echo 'Pickup Only';
                                                    }
                                                    ?>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <th>Rules Set by Company</th>
                                                  <td><?= $row['eqpRules'] ?></td>
                                                </tr>
                                                <tr>
                                                  <th>Note for Renter</th>
                                                  <td><?= $row['noteForRenter'] ?></td>
                                                </tr>
                                                <tr>
                                                  <th>Additional Requirements</th>
                                                  <td><?= $row['addRequirments'] ?></td>
                                                </tr>
                                              <?php
                                              } else {
                                              ?>
                                                <tr>
                                                  <th>Rental Type</th>
                                                  <td>
                                                    <?php
                                                    if ($row['workforceRentalType'] == 1) {
                                                      echo 'Per Day';
                                                    } else if ($row['workforceRentalType'] == 2) {
                                                      echo 'Per Week';
                                                    } else if ($row['workforceRentalType'] == 3) {
                                                      echo 'Per Month';
                                                    } else {
                                                      echo 'Yearly';
                                                    }
                                                    ?>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <th>Price</th>
                                                  <td><?= $row['workforcePrice'] ?></td>
                                                </tr>
                                                <tr>
                                                  <th>Delivery Options</th>
                                                  <td>
                                                    <?php
                                                    if ($row['workforceDeliveryOpt'] == 1) {
                                                      echo 'Can be delivered';
                                                    } else {
                                                      echo 'Pickup Only';
                                                    }
                                                    ?>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <th>Rules Set by Company</th>
                                                  <td><?= $row['workforceRules'] ?></td>
                                                </tr>
                                                <tr>
                                                  <th>Note for Renter</th>
                                                  <td><?= $row['workforcenoteForRenter'] ?></td>
                                                </tr>
                                                <tr>
                                                  <th>Additional Requirements</th>
                                                  <td><?= $row['workforceaddRequirments'] ?></td>
                                                </tr>

                                              <?php
                                              }
                                              ?>
                                              <?php
                                              if ($row['itemStatus'] == 2) {
                                              ?>
                                                <tr>
                                                  <td colspan="2">
                                                    <center>
                                                      <h4>Action</h4>
                                                      <a href="<?= base_url('mark-listing-approved?listingID=' . $row['itemID']) ?>" class="btn btn-success">Mark Approved</a>
                                                      <a href="<?= base_url('mark-listing-rejected?listingID=' . $row['itemID']) ?>" class="btn btn-danger">Mark Rejected</a>
                                                    </center>

                                                  </td>
                                                </tr>
                                              <?php
                                              }
                                              ?>
                                            </tbody>
                                          </table>

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
                                    data-bs-dismiss="modal">
                                    Close
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>

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
  <!--app-->
  <script src="<?= base_url() ?>assets/js/app.js"></script>
  <?php
  if ($this->session->flashdata('approved') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.success('Listing Approved!');
    </script>
  <?php
  }
  ?>
  <?php
  if ($this->session->flashdata('rejected') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.success('Listing Rejected!');
    </script>
  <?php
  }
  ?>
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
</body>

</html>