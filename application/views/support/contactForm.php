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

  <title>Contact Form Data</title>
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
    .disabled-text {
      color: #6c757d;
      opacity: 0.65;
      cursor: not-allowed;
      pointer-events: none;
      user-select: none;
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
          Contact Form Enquiries
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
                      <select name="status" id="status" class="form-control">
                        <option value="">Select Query Status</option>
                        <option value="1" 
                        <?php 
                          if(isset($_GET['status']) && $_GET['status']==1){
                            echo 'selected';
                          }
                        ?>
                        >New</option>
                        <option value="2"
                          <?php 
                          if(isset($_GET['status']) && $_GET['status']==2){
                            echo 'selected';
                          }
                        ?>
                        >Responded</option>
                      </select>
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
                      if (isset($_GET['status'])) {
                      ?>
                        <a href="<?= base_url('contact-form') ?>" style="color:#0f2f2c;margin-left:10px"><i class="bi bi-x-lg"></i> Clear Filter</a>
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
          <h5 class="mb-0">Query List</h5>
          <div class="table-responsive mt-3">
            <table class="table align-middle">
              <thead class="table-secondary bg-sky-blue font-clash-green">
                <tr>
                  <th>Sr.</th>
                  <th>Date</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($contactEntries) {
                  $sr = 1;
                  foreach ($contactEntries as $row) {

                ?>
                    <tr>
                      <td><?= $sr . '.' ?></td>
                      <td>
                        <?= date('j M, Y', strtotime($row['contactDate'])) ?>
                      </td>
                      <td>
                        <?= $row['contactName'] ?>
                      </td>
                      <td>
                        <?= $row['contactEmail'] ?>
                      </td>
                      <td>
                        <?= $row['contactSubject'] ?>
                      </td>
                      <td>
                       <?= $row['contactMsg'] ?>
                      </td>
                      <td>
                        <?php
                        if ($row['contactStatus'] == 1) {
                          echo '<span style="color:red">New</span>';
                        } else {
                          echo '<span style="color:green">Responded</span>';
                        }


                        ?>
                      </td>
                      <td>
                        <?php
                        if ($row['contactStatus'] == 1) {
                          ?>
                        <a href="<?= base_url('contact-form-responded?contactID='.$row['contactID']) ?>" class="btn btn-primary px-5 btn-clash">Mark Responded</a>
                        <?php
                        }else{
                        ?>
                          <span id="disableResponded" class="disabled-text" aria-disabled="true" title="Responded">Responded</span>
                        <?php 
                        }
                        ?>
                      </td>
                    </tr>
                  <?php
                    $sr++;
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan="9" class="text-center">No Inquiry Found</td>
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
  if ($this->session->flashdata('statusUpdated') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.success('Query marked Responded!');
    </script>
  <?php
  }
  ?>
</body>

</html>