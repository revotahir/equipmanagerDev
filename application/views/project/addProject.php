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

  <title>Add New Project </title>
  <style>
    .width-ctrl {
      --width: 25%;
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

    /* Overlay */
    .loader-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: #8080802b;
      /* grey dim */
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 999;
      border-radius: 15px;
      display: none;
    }

    /* Logo Spin Animation */
    .loader-logo {
      width: 45px;
      animation: spinCycle 4s infinite;
    }

    @keyframes spinCycle {
      0% {
        transform: rotate(0deg);
      }

      60% {
        transform: rotate(1080deg);
      }

      /* 3 fast spins */
      80% {
        transform: rotate(1440deg);
      }

      /* slowing down */
      100% {
        transform: rotate(1440deg);
      }

      /* pause before repeat */
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
          Project Management
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
              <div class="multi_tabs-btn active_tab width-ctrl">
                <div class="tab-progress-bar"></div>
                <button class="tab-btn">
                  <span class="_circle">Step 1</span>
                </button>
              </div>
              <!-- Btn -->
              <div class="multi_tabs-btn width-ctrl">
                <div class="tab-progress-bar"></div>
                <button class="tab-btn" disabled>
                  <span class="_circle">Step 2</span>
                </button>
              </div>
              <!-- Btn -->
              <div class="multi_tabs-btn" style="--width: 50%">
                <div class="tab-progress-bar"></div>
                <button class="tab-btn" disabled>
                  <span class="_circle">Step 3</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- HAMZA STEPS -->

        <div class="multi_tabs_content-container">
          <div class="card multi_tab_content" id="first-box">
            <div class="card-body">
              <!-- inner card start here-->
              <div class="row">
                <div class="col-xl-12 mx-auto">
                  <!-- <div class="card">
                    <div class="card-body"> -->
                  <div class="border p-3 rounded">
                    <h6 class="mb-0 text">Add General Information</h6>
                    <hr />
                    <form class="row g-3" method="post" id="firstForm" enctype="multipart/form-data">
                      <div class="col-12">
                        <label class="form-label">Project name</label>
                        <input
                          type="text"
                          required
                          id="pName"
                          name="pName"
                          class="form-control"
                          placeholder="Enter Project name" />
                      </div>
                      <div class="col-12">
                        <label class="form-label">Project category</label>
                        <select name="pCatID" id="pCatID" required class="form-control">
                          <option value="">select Category</option>
                          <?php
                          if (!empty($Pcategory)) {
                            foreach ($Pcategory as $cat) {
                          ?>
                              <option value="<?= $cat['pCatID'] ?>"><?= $cat['pCatName'] ?></option>
                          <?php
                            }
                          } else {
                            echo '<option value="">No Category Found</option>';
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-12">
                        <label class="form-label">Location</label>
                        <input
                          type="text"
                          required
                          id="pLocation"
                          name="pLocation"
                          class="form-control"
                          placeholder="Add  Location" />
                      </div>
                      <div class="col-12">
                        <label class="form-label">Upload Image (Max 10, Optional)</label>
                        <input type="file" multiple id="pImg" name="pImg[]" class="form-control" />
                      </div>
                      <div class="col-12 mb-3">
                        <label class="form-label">Timeline</label><br>
                       
                        <div class="row">
                           
                          <div class="col-md-6 mb-2 mb-md-0">
                            <span class="text-muted mt-2">Start Date</span>
                            <input
                              type="date"
                              id="pStartDate"
                              name="pStartDate"
                              required
                              class="form-control"
                              placeholder="Start Date" />
                              
                          </div>
                         
                          <div class="col-md-6">
                             <span class="text-muted mt-2">End Date(Optional)</span>
                            <input
                              type="date"
                              id="pEndDate"
                              name="pEndDate"
                              class="form-control"
                              placeholder="End Date" />
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea
                          class="form-control"
                          rows="4"
                          cols="4"
                          required
                          id="pDesc"
                          name="pDesc"
                          placeholder="Write Here"></textarea>
                      </div>
                      <div class="row justify-content-center mt-3">
                        <div class="col-sm-1">
                          <div class="d-flex">
                            <button
                              type="submit"
                              class="btn btn-primary btn-clash">
                              Next
                            </button>
                          </div>
                        </div>
                      </div>
                    </form>
                    <!-- </div>
                    </div> -->
                  </div>
                </div>
                <div class="loader-overlay" id="loader">
                  <img src="<?= base_url() ?>assets/images/logo-icon.png" alt="Loading..." class="loader-logo">
                </div>
              </div>
              <!-- inner card end here-->
            </div>
          </div>
          <div class="card multi_tab_content" id="second-box">
            <div class="card-body">
              <!-- inner card 2nd start here-->
              <div class="row">
                <div class="col-xl-12 mx-auto">
                  <!-- <div class="card">
                    <div class="card-body"> -->
                  <div class="border p-3 rounded">
                    <h6 class="mb-0 text">Workforce and Equipment</h6>
                    <hr />
                    <form class="row g-3">
                      <div class="col-12">
                        <div class="d-flex align-items-center gap-20 mb-3">
                          <label class="form-label mb-0">Select Employee</label>
                        </div>
                        <select name="skill" id="skill" class="form-control">
                          <option value="">Select Employee</option>
                          <option value="">Select Employee 1</option>
                          <option value="">Select Employee 3</option>
                          <option value="">Select Employee 4</option>
                        </select>
                      </div>

                      <!-- start -->
                      <div class="card-body card-body-p-0">
                        <div class="product-grid">
                          <div
                            class="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-4 g-3">
                            <!-- Card start -->
                            <div class="col close" style="position: relative">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="<?= base_url() ?>assets/images/gallery/e167bc99fa5ad15d9308030e83cef4d07e8b4c10.jpg"
                                    class="card-img-top-main rounded-top"
                                    alt="Helen Heidenreich" />
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="white" />
                                  </svg>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      Helen Heidenreich
                                    </h5>
                                    <span class="text-muted">Developer</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Card end -->
                            <!-- Card start -->
                            <div class="col close" style="position: relative">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="<?= base_url() ?>assets/images/gallery/5225a0cdaba6dd55efd0ff44b26e82ddfe8d8800.jpg"
                                    class="card-img-top-main rounded-top"
                                    alt="Helen Heidenreich" />
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="white" />
                                  </svg>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      Helen Heidenreich
                                    </h5>
                                    <span class="text-muted">Developer</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Card end -->
                            <!-- Card start -->
                            <div class="col close" style="position: relative">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="<?= base_url() ?>assets/images/gallery/b909a323568685cb2a0b10d855cc868d21267f7f.jpg"
                                    class="card-img-top-main rounded-top"
                                    alt="Helen Heidenreich" />
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="white" />
                                  </svg>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      Helen Heidenreich
                                    </h5>
                                    <span class="text-muted">Developer</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Card end -->
                            <!-- Card start -->
                            <div class="col close" style="position: relative">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="<?= base_url() ?>assets/images/gallery/f660fef856d605d87fe01d9a5d5be8b6d0ed8a48.jpg"
                                    class="card-img-top-main rounded-top"
                                    alt="Helen Heidenreich" />
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="white" />
                                  </svg>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      Helen Heidenreich
                                    </h5>
                                    <span class="text-muted">Developer</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Card end -->
                          </div>
                        </div>
                      </div>
                      <!-- end -->

                      <!-- second section start  -->

                      <div class="col-12">
                        <div class="d-flex align-items-center gap-20 mb-3">
                          <label class="form-label mb-0">Select Equipment</label>
                        </div>
                        <select name="skill" id="skill" class="form-control">
                          <option value="">Select Equipment</option>
                          <option value="">Select Equipment 1</option>
                          <option value="">Select Equipment 3</option>
                          <option value="">Select Equipment 4</option>
                        </select>
                      </div>

                      <!-- start -->
                      <div class="card-body card-body-p-0">
                        <div class="product-grid">
                          <div
                            class="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-4 g-3">
                            <!-- Card start -->
                            <div class="col close" style="position: relative">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="<?= base_url() ?>assets/images/gallery/e167bc99fa5ad15d9308030e83cef4d07e8b4c10.jpg"
                                    class="card-img-top-main rounded-top"
                                    alt="Helen Heidenreich" />
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="white" />
                                  </svg>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      Helen Heidenreich
                                    </h5>
                                    <span class="text-muted">Developer</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Card end -->
                            <!-- Card start -->
                            <div class="col close" style="position: relative">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="<?= base_url() ?>assets/images/gallery/5225a0cdaba6dd55efd0ff44b26e82ddfe8d8800.jpg"
                                    class="card-img-top-main rounded-top"
                                    alt="Helen Heidenreich" />
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="white" />
                                  </svg>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      Helen Heidenreich
                                    </h5>
                                    <span class="text-muted">Developer</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Card end -->
                            <!-- Card start -->
                            <div class="col close" style="position: relative">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="<?= base_url() ?>assets/images/gallery/b909a323568685cb2a0b10d855cc868d21267f7f.jpg"
                                    class="card-img-top-main rounded-top"
                                    alt="Helen Heidenreich" />
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="white" />
                                  </svg>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      Helen Heidenreich
                                    </h5>
                                    <span class="text-muted">Developer</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Card end -->
                            <!-- Card start -->
                            <div class="col close" style="position: relative">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="<?= base_url() ?>assets/images/gallery/f660fef856d605d87fe01d9a5d5be8b6d0ed8a48.jpg"
                                    class="card-img-top-main rounded-top"
                                    alt="Helen Heidenreich" />
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="white" />
                                  </svg>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      Helen Heidenreich
                                    </h5>
                                    <span class="text-muted">Developer</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Card end -->
                          </div>
                        </div>
                      </div>
                      <!-- end -->

                      <!-- second section end  -->

                      <div class="row justify-content-center mt-3">
                        <div class="col-sm-1">
                          <div class="d-flex">
                            <button
                              type="submit"
                              class="btn btn-primary btn-clash">
                              Next
                            </button>
                          </div>
                        </div>
                      </div>
                    </form>
                    <!-- </div>
                    </div> -->
                  </div>
                </div>
              </div>
              <!-- inner card 2nd end here-->
            </div>
          </div>
          <div class="multi_tab_content" id="third-box">
            <div class="card">
              <div class="card-body">
                <!-- inner card 3nd start here-->
                <div class="row">
                  <div class="col-xl-12 mx-auto">
                    <!-- <div class="card">
                    <div class="card-body"> -->
                    <div class="border p-3 rounded">
                      <h6 class="mb-0 text">Assign Equipment (Optional)</h6>
                      <hr />
                      <form class="row g-3">
                        <div class="col-12">
                          <div class="d-flex align-items-center gap-20 mb-3">
                            <label class="form-label mb-0">Select Equipment</label>
                          </div>
                          <select
                            name="skill"
                            id="skill"
                            class="form-control">
                            <option value="">Select Equipment</option>
                            <option value="">select equipment 1</option>
                            <option value="">select equipment 3</option>
                            <option value="">select equipment 4</option>
                          </select>
                        </div>
                        <div class="col-12">
                          <div class="d-flex align-items-center gap-20 mb-3">
                            <label class="form-label mb-0">Select Employee</label>
                          </div>
                          <select
                            name="skill"
                            id="skill"
                            class="form-control">
                            <option value="">Select Employee</option>
                            <option value="">Select Employee 1</option>
                            <option value="">Select Employee 3</option>
                            <option value="">Select Employee 4</option>
                          </select>
                        </div>
                        <div class="col-12 text-center mt-3">
                          <div
                            class="d-flex flex-column flex-md-row justify-content-center gap-2">
                            <button
                              type="submit"
                              class="btn btn-primary btn-clash">
                              Assign
                            </button>
                            <button
                              type="submit"
                              class="btn btn-primary btn-clash-outline">
                              Submit Project
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
            <div class="card">
              <div class="card-body">
                <h5 class="mb-0">Equipment and Employees</h5>
                <div class="table-responsive mt-3">
                  <table class="table align-middle">
                    <thead
                      class="table-secondary bg-sky-blue font-clash-green">
                      <tr>
                        <th>Sr.</th>
                        <th>Equipment</th>
                        <th>Employee</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Forklift Model X</td>
                        <td>
                          <div class="employee">
                            <img
                              src="<?= base_url() ?>assets/images/gallery/be817f5a348841cfb87df369616233a266b8b28f.jpg"
                              alt="client" />
                            <span>Meghan Grady</span>
                          </div>
                        </td>
                        <td>
                          <div
                            class="table-actions d-flex align-items-center gap-3 fs-6">
                            <a
                              href="javascript:;"
                              class="text-warning"
                              data-bs-toggle="tooltip"
                              data-bs-placement="bottom"
                              title="Edit"><i class="bi bi-pencil-fill"></i></a>
                            <a
                              href="javascript:;"
                              class="text-danger"
                              data-bs-toggle="tooltip"
                              data-bs-placement="bottom"
                              title="Delete"><i class="bi bi-trash-fill"></i></a>
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
      </div>
      <!--end row-->
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
      aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Person</h5>
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
                  <div class="border p-4 rounded">
                    <div class="card-title d-flex align-items-center">
                      <h5 class="mb-0">Add New Skill</h5>
                    </div>
                    <hr />
                    <div class="row mb-3">
                      <label
                        for="inputEnterYourName"
                        class="col-sm-3 col-form-label">New Skill Name</label>
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="inputEnterYourName"
                          placeholder="Enter New Skill Name" />
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label
                        for="inputAddress4"
                        class="col-sm-3 col-form-label">Description</label>
                      <div class="col-sm-9">
                        <textarea
                          class="form-control"
                          id="inputAddress4"
                          rows="3"
                          placeholder="Address"></textarea>
                      </div>
                    </div>

                    <div class="row">
                      <label class="col-sm-3 col-form-label"></label>
                      <div class="col-sm-9">
                        <button
                          type="submit"
                          class="btn btn-primary px-5 btn-clash">
                          Add Manage Skill
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
              data-bs-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- popup end -->

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
  <!-- first step ajax call  -->
  <script>
    $(document).ready(function() {
      $("#firstForm").on("submit", function(e) {
        e.preventDefault();
        // alert('ok');
        document.getElementById("loader").style.display = "flex";
        var form = this;
        $.ajax({
          url: "<?= base_url('add-project-general-data') ?>",
          type: "POST",
          data: new FormData(form),
          processData: false,
          contentType: false,
          cache: false,
          success: function(response) {
            alert(response);
            // console.log(response);
            if (response) {
              if (response == "data missing") {
                toastr.options = {
                  "closeButton": true,
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                toastr.error('Please fill all Required Fields!');

              }
              // explode by array //
              response = response.split("//");

              if(response[0]=="Projectadded"){
                document.getElementById("loader").style.display = "none";
                toastr.options = {
                  "closeButton": true,
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                toastr.success('Project Added Successfully!');
                $("#first-box").hide();
                $("#second-box").show();
                $("#third-box").hide();
                $(".step1").removeClass("active");
                $(".step2").addClass("active");
                $(".step3").removeClass("active");
                //add parementer to url
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?id=' + response[1];
                window.history.pushState({ path: newurl }, '', newurl);
              }

              // toastr.success("First Step Completed");
              // $("#first-box").hide();
              // $("#second-box").show();
              // $("#third-box").hide();
              // $(".step1").removeClass("active");
              // $(".step2").addClass("active");
              // $(".step3").removeClass("active");
            } else {
              toastr.error("Something Went Wrong");
            }
          },
        });
      });
    });
  </script>
</body>

</html>