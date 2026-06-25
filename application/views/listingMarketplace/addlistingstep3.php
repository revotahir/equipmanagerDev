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
    /* Force tooltips to stay centered on top */
    .tooltip-inner {
      transform: translateX(-50%) !important;
      left: 50% !important;
    }

    /* Hide all tooltip arrows */
    .tooltip-arrow {
      display: none !important;
    }

    .bs-tooltip-top .tooltip-arrow,
    .bs-tooltip-auto[data-popper-placement^="top"] .tooltip-arrow {
      display: none !important;
    }

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
          Equipment Marketplace Listings
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
                <button type="button" class="tab-btn" <?php if (!isset($_GET['edit'])) { echo 'disabled'; } ?> onclick="<?php if (isset($_GET['edit'])) { echo "window.location.href='" . base_url('add-listing?itemID='.$_GET['listingID'].'&edit=1') . "';"; } ?>">
                  <span class="_circle">Listing Type</span>
                </button>
              </div>
              <!-- Btn -->
              <div class="multi_tabs-btn 
                
                width-ctrl">
                <div class="tab-progress-bar"></div>
                <button class="tab-btn">
                  <?php
                  if (isset($_GET['edit'])) {
                  ?>
                    <a href="<?= base_url('add-listing?itemID='.$_GET['listingID'].'&skill='.$listing[0]['itemType'].'&rentalType='.$listing[0]['saleType'].'&edit=1') ?>">
                    <?php
                  }
                    ?>
                  <span class="_circle">Listing Details</span>
                    <?php
                    if (isset($_GET['edit'])) {
                    ?>
                    </a>
                  <?php
                    }
                  ?>
                </button>
              </div>
              <!-- Btn -->
              <div class="multi_tabs-btn active_tab" style="--width: 50%">
                <div class="tab-progress-bar"></div>
                <button class="tab-btn">
                  <span class="_circle">Terms & Conditions</span>
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
                      <?php $login = $this->session->userdata('loginData'); ?>
                      <div style="margin-top:8px; color:#13372E; font-weight:600;">
                        <?php if ((int)$login['userType'] === 2): ?>
                          Creating as: Company Admin
                        <?php elseif ((int)$login['userType'] === 4): ?>
                          Creating as: Employee (<?= htmlspecialchars($login['userName']) ?>)
                        <?php endif; ?>
                      </div>
                      <hr />
                      <form class="row g-3" method="post" action="<?= base_url('add-step-3-data/?listingID=' . urlencode($_GET['listingID'])) ?>">
                        <?= csrf_field() ?>
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
                                if($listing[0]['itemType']==1){
                                if ($listingOptions[0]['eqpDeliveryOpt'] == 1) {
                                  echo 'selected';
                                }
                                }else{
                                  if ($listingOptions[0]['workforceDeliveryOpt'] == 1) {
                                  echo 'selected';
                                }
                                }
                              }
                              ?>
                              value="1">Can be delivered</option>
                            <option
                              <?php
                              if (isset($_GET['edit'])) {
                                if($listing[0]['itemType']==1){
                                if ($listingOptions[0]['eqpDeliveryOpt'] == 2) {
                                  echo 'selected';
                                }
                                }else{
                                  if ($listingOptions[0]['workforceDeliveryOpt'] == 2) {
                                  echo 'selected';
                                }
                                }
                              }
                              ?>
                              value="2">Pickup</option>
                          </select>
                        </div>

                        <!-- Delivery Charge Section (shown only when delivery available) -->
                        <div class="col-12" id="deliveryChargeSection" style="display: none;">
                          <div class="border p-3 rounded" style="background-color: #f8f9fa;">
                            <h6 class="mb-3">Delivery Charge Details</h6>
                            
                            <div class="mb-3">
                              <label class="form-label">Who bears the delivery charge? 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16" style="cursor: pointer;" data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true" title="Delivery Charge Bearer" data-bs-content="Choose whether your company covers the delivery cost (free delivery for customers) or if customers pay the delivery fee.">
                                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                </svg>
                              </label>
                              <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="deliveryChargeBearer" id="companyPays" value="1"
                                  <?php
                                  if (isset($_GET['edit'])) {
                                    if($listing[0]['itemType']==1){
                                      if ($listingOptions[0]['deliveryChargeBearer'] == 1) {
                                        echo 'checked';
                                      }
                                    }else{
                                      if ($listingOptions[0]['deliveryChargeBearer'] == 1) {
                                        echo 'checked';
                                      }
                                    }
                                  }
                                  ?>>
                                <label class="form-check-label" for="companyPays">
                                  Company pays (Free delivery for customers)
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="deliveryChargeBearer" id="customerPays" value="2"
                                  <?php
                                  if (isset($_GET['edit'])) {
                                    if($listing[0]['itemType']==1){
                                      if ($listingOptions[0]['deliveryChargeBearer'] == 2) {
                                        echo 'checked';
                                      }
                                    }else{
                                      if ($listingOptions[0]['deliveryChargeBearer'] == 2) {
                                        echo 'checked';
                                      }
                                    }
                                  }
                                  ?>>
                                <label class="form-check-label" for="customerPays">
                                  Customer pays (Charge customer for delivery)
                                </label>
                              </div>
                            </div>

                            <div class="mb-0" id="chargeAmountField" style="display: none;">
                              <label class="form-label">Delivery Charge Amount (USD)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16" style="cursor: pointer;" data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true" title="Delivery Fee" data-bs-content="Enter the delivery charge amount that will be added to the customer's total when they order this item.">
                                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                </svg>
                              </label>
                              <input 
                                type="number" 
                                name="deliveryCharge" 
                                id="deliveryCharge" 
                                class="form-control"
                                step="0.01" 
                                min="0" 
                                placeholder="0.00"
                                value="<?php 
                                  if (isset($_GET['edit']) && ($listingOptions[0]['deliveryCharge'] !== null)) {
                                    echo $listingOptions[0]['deliveryCharge'];
                                  }
                                ?>">
                            </div>
                          </div>
                        </div>

                        <div class="col-12">
                          <label class="form-label">Set rules
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="setRules" class="bi bi-info-circle" viewBox="0 0 16 16" style="cursor: pointer;" data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true" title="(damage, return, etc.)" data-bs-content="Define the key rules renters must follow when using this equipment. This can include responsibility for damage, return condition, cleaning requirements, late returns, or misuse. Clear rules help avoid misunderstandings and disputes.">
                              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                            </svg>
                          </label>
                          <textarea
                            class="form-control"
                            rows="4"
                            cols="4"
                            id="rules"
                            name="rules"
                            placeholder="Write Here"> <?php if (isset($_GET['edit'])) {
                              if($listing[0]['itemType']==1){
                                                        echo $listingOptions[0]['eqpRules'];
                              }else{
                                 echo $listingOptions[0]['workforceRules'];
                              }
                                                      } ?></textarea>
                        </div>
                        <?php
                        if ($listing[0]['saleType'] == 0) {
                        ?>
                          <div class="col-12">
                            <label class="form-label">Write notes for renter
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="rentalNotesInfo" class="bi bi-info-circle" viewBox="0 0 16 16" style="cursor: pointer;" data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true" data-bs-content="Add practical or helpful information for the renter. For example: usage tips, known quirks, setup instructions, safety notes, or recommendations for proper handling. These notes are intended to help the renter get the best possible experience with the equipment.">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                              </svg>
                            </label>
                            <textarea
                              class="form-control"
                              rows="4"
                              cols="4"
                              id="rentalNotes"
                              name="rentalNotes"
                              placeholder="Write Here"><?php if (isset($_GET['edit'])) {
                                if($listing[0]['itemType']==1){
                                                          echo $listingOptions[0]['noteForRenter'];
                                }else{
                                  echo $listingOptions[0]['workforcenoteForRenter'];
                                }
                                                        } ?></textarea>
                          </div>

                          <div class="col-12">
                            <label class="form-label">Add requirements for renters
                              <span class="text-muted">(if any)</span>
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="rentalReqInfo" class="bi bi-info-circle" viewBox="0 0 16 16" style="cursor: pointer;" data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true" data-bs-content="Specify any requirements the renter must meet in order to rent this equipment. This could include certifications, licenses, experience level, insurance, or company approval. Leave this field empty if there are no special requirements.">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                              </svg>
                            </label>
                            <textarea
                              class="form-control"
                              rows="4"
                              cols="4"
                              id="rentalReq"
                              name="rentalReq"
                              placeholder="Write Here"><?php if (isset($_GET['edit'])) {
                                if($listing[0]['itemType']==1){
                                                          echo $listingOptions[0]['addRequirments'];
                                }else{
                                  echo $listingOptions[0]['workforceaddRequirments'];
                                }
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
  <!-- Initialize Bootstrap Tooltips -->
  <script>
    $(document).ready(function() {
      $('[data-bs-toggle="tooltip"]').tooltip({
        placement: 'top',
        fallbackPlacements: [],
        container: 'body',
        delay: { show: 100, hide: 50 }
      });

      // ===== DELIVERY CHARGE LOGIC =====
      // Show/hide delivery charge section based on delivery option
      function toggleDeliveryChargeSection() {
        const deliveryOpt = document.getElementById('devliveryOpt').value;
        const deliveryChargeSection = document.getElementById('deliveryChargeSection');
        
        if (deliveryOpt === '1') {
          deliveryChargeSection.style.display = 'block';
          // Initialize bearer selection state if needed
          toggleChargeAmountField();
        } else {
          deliveryChargeSection.style.display = 'none';
          // Clear values when hidden
          document.getElementById('deliveryCharge').value = '';
          document.querySelectorAll('input[name="deliveryChargeBearer"]').forEach(el => el.checked = false);
        }
      }

      // Show/hide charge amount field based on who bears the charge
      function toggleChargeAmountField() {
        const customerPaysRadio = document.getElementById('customerPays');
        const chargeAmountField = document.getElementById('chargeAmountField');
        
        if (customerPaysRadio.checked) {
          chargeAmountField.style.display = 'block';
        } else {
          chargeAmountField.style.display = 'none';
          document.getElementById('deliveryCharge').value = '';
        }
      }

      // Event listeners
      document.getElementById('devliveryOpt').addEventListener('change', toggleDeliveryChargeSection);
      document.getElementById('companyPays').addEventListener('change', toggleChargeAmountField);
      document.getElementById('customerPays').addEventListener('change', toggleChargeAmountField);

      // Initialize on page load (for edit mode)
      toggleDeliveryChargeSection();
    });
  </script>
  <script>
    $('[data-bs-toggle="tooltip"]').tooltip({
      placement: 'top',
      fallbackPlacements: [],
      container: 'body',
      delay: { show: 100, hide: 50 }
    });
  </script>
  <script>
    // Initialize popover for setRules - trigger on hover
    const setRulesElement = document.getElementById('setRules');
    const setRulesPopover = new bootstrap.Popover(setRulesElement, {
      trigger: 'hover'
    });
    
    // Initialize popover for rentalNotesInfo - trigger on hover
    const rentalNotesElement = document.getElementById('rentalNotesInfo');
    const rentalNotesPopover = new bootstrap.Popover(rentalNotesElement, {
      trigger: 'hover'
    });
    
    // Initialize popover for rentalReqInfo - trigger on hover
    const rentalReqElement = document.getElementById('rentalReqInfo');
    const rentalReqPopover = new bootstrap.Popover(rentalReqElement, {
      trigger: 'hover'
    });
  </script>
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
