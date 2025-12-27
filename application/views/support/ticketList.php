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
  <link rel="stylesheet" href="<?= base_url() ?>assets/toastr/toastr.min.css" />
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

  <title>Support Ticket List</title>
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
          Support Management
        </div>
      </div>
      <!--end breadcrumb-->

      <div class="row">
        
        <div class="col-xl-12 mx-auto">
          <div class="card">
            <div class="card-body">
              <div
                class="d-flex align-items-center justify-spc-btw flex-col-md">
                <h5 class="mb-0">Ticket List</h5>
                
              </div>
              <div class="table-responsive mt-3">
                <table class="table align-middle">
                  <thead class="table-secondary bg-sky-blue font-clash-green">
                    <tr>
                      <th>Category</th>
                      <th class="text-center">Subject</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (!empty($alltickets)) {
                      foreach ($alltickets as $ticket) { ?>


                        <tr>
                          <td><?= $ticket['supportCat'] ?></td>
                          <td class="text-center">
                            <?= $ticket['supportSubject'] ?>
                          </td>
                          <td>
                            <div
                              class="table-actions d-flex align-items-center gap-3 fs-6">
                              <?php 
                                if($ticket['supportTicketStatus']==1){
                                  echo '<strong>Waiting Response</strong>';
                                }else if($ticket['supportTicketStatus']==2){
                                  echo '<strong>Response Given</strong>';
                                }else{
                                  echo '<strong>Closed</strong>';
                                }
                              ?>
                            </div>
                          </td>
                          <td>
                             <a
                              href="<?= base_url('ticket-chat?ticketID='.$ticket['supportTicketID']) ?>"
                              class="text-primary"
                              data-bs-toggle="tooltip"
                              data-bs-placement="bottom"
                              title="Views"
                              ><i class="bi bi-eye-fill"></i
                            ></a>
                            
                          </td>
                        </tr>
                      <?php }
                    } else { ?>
                      <tr>
                        <td colspan="4" class="text-center">No Ticket Created!</td>
                      </tr>
                    <?php } ?>
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

   

    <!-- second popup end -->

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
  if ($this->session->flashdata('success-added') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.success('Equipment Added!');
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
  if ($this->session->flashdata('successDeleted') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.success('Equipment Deleted!');
    </script>
  <?php
  }
  ?>
  <?php
  if ($this->session->flashdata('success-edited') != '') {
  ?>
    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      toastr.success('Equipment Updated!');
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
      toastr.error('Something went wrong, Please try again!');
    </script>
  <?php
  }
  ?>
</body>

</html>
