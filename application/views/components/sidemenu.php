  <?php
    if ($this->session->userdata('loginData')['userType'] == 1) {
    ?>

      <!--start sidebar -->
      <aside class="sidebar-wrapper" data-simplebar="true">
          <div class="sidebar-header">
              <div>
                  <img
                      src="<?= base_url() ?>assets/images/logo-icon.png"
                      class="logo-icon"
                      alt="logo icon" />
              </div>
              <div>
                  <h4 class="logo-text" style="color: black">Equip Manager</h4>
              </div>
              <div class="toggle-icon ms-auto">
                  <i class="bi bi-chevron-double-left" style="color: black"></i>
              </div>
          </div>
          <!--navigation-->
          <ul class="metismenu" id="menu">
              <li>
                  <a href="<?= base_url('admin-dashboard') ?>">
                      <div class="parent-icon"><i class="bi bi-house-door"></i></div>
                      <div class="menu-title font-clash">Dashboard</div>
                  </a>
              </li>
              <li>
                  <a href="javascript:;" class="has-arrow">
                      <div class="parent-icon"><i class="bi bi-people-fill"></i></div>
                      <div class="menu-title font-clash">Manage Category</div>
                  </a>
                  <ul>
                      <li>
                          <a href="<?= base_url('manage-super-category') ?>"><i class="bi bi-arrow-right-short"></i>Add Category</a>
                      </li>
                      <li>
                          <a href="<?= base_url('show-super-category') ?>"><i class="bi bi-arrow-right-short"></i>See Category</a>
                      </li>
                  </ul>
              </li>

              <!-- manage Testimonial -->
              <li>
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon">
                          <i class="bi bi-tools"></i>
                      </div>
                      <div class="menu-title font-clash">Manage Testimonial</div>
                  </a>
                  <ul>

                      <li>
                          <a href="<?= base_url('') ?>"><i class="bi bi-arrow-right-short"></i>Add Testimonial</a>
                      </li>
                  </ul>
              </li>
              <!-- mannage  Testimonial end here-->
              <!-- manage Blog -->
              <li>
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon">
                          <i class="bx bx-window-alt"></i>
                      </div>
                      <div class="menu-title font-clash">Manage Blog</div>
                  </a>
                  <ul>

                      <li>
                          <a href="<?= base_url('') ?>"><i class="bi bi-arrow-right-short"></i>Add Blog</a>
                      </li>
                  </ul>
              </li>
              <!-- mannage  Blog end here-->
              <!-- manage Success Metrics -->
              <li>
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon">
                          <i class="bx bx-window-alt"></i>
                      </div>
                      <div class="menu-title font-clash">Manage Metrics</div>
                  </a>
                  <ul>

                      <li>
                          <a href="<?= base_url('') ?>"><i class="bi bi-arrow-right-short"></i>Add Success Metrics</a>
                      </li>
                  </ul>
              </li>
              <!-- mannage  Success Metrics end here-->
              <!-- manage Company Partners -->
              <li>
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon">
                          <i class="bx bx-window-alt"></i>
                      </div>
                      <div class="menu-title font-clash">Manage Company Partners
                      </div>
                  </a>
                  <ul>

                      <li>
                          <a href="<?= base_url('') ?>"><i class="bi bi-arrow-right-short"></i>Add Company Partners</a>
                      </li>
                  </ul>
              </li>
              <!-- mannage  Company Partners end here-->
          </ul>
          <!--end navigation-->
      </aside>
      <!--end sidebar -->
  <?php
    } else {
    ?>
      <!--start sidebar -->
      <aside class="sidebar-wrapper" data-simplebar="true">
          <div class="sidebar-header">
              <div>
                  <img
                      src="<?= base_url() ?>assets/images/logo-icon.png"
                      class="logo-icon"
                      alt="logo icon" />
              </div>
              <div>
                  <h4 class="logo-text" style="color: black">Equip Manager</h4>
              </div>
              <div class="toggle-icon ms-auto">
                  <i class="bi bi-chevron-double-left" style="color: black"></i>
              </div>
          </div>
          <!--navigation-->
          <ul class="metismenu" id="menu">
              <li>
                  <?php
                    //   dashboard for company vendor 
                    if ($this->session->userdata('loginData')['userType'] == 2) {
                    ?>
                      <a href="<?= base_url('company-dashboard') ?>">
                          <div class="parent-icon"><i class="bi bi-house-door"></i></div>
                          <div class="menu-title font-clash">Dashboard</div>
                      </a>
                  <?php
                    }
                    ?>
              </li>
              <li>
                  <a href="javascript:;" class="has-arrow">
                      <div class="parent-icon"><i class="bi bi-people-fill"></i></div>
                      <div class="menu-title font-clash">Manage Workforce</div>
                  </a>
                  <ul>
                      <li>
                          <a href="<?= base_url('add-workforce') ?>"><i class="bi bi-arrow-right-short"></i>Add workforce</a>
                      </li>
                      <li>
                          <a href="<?= base_url('all-workforce') ?>"><i class="bi bi-arrow-right-short"></i>All Workforce</a>
                      </li>
                      <li>
                          <a href="<?= base_url('manage-workforce-skill') ?>"><i class="bi bi-arrow-right-short"></i>Manage Skills</a>
                      </li>
                  </ul>
              </li>

              <!-- manage Equipment -->
              <li>
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon">
                          <i class="bi bi-tools"></i>
                      </div>
                      <div class="menu-title font-clash">Manage Equipment</div>
                  </a>
                  <ul>

                      <li>
                          <a href="<?= base_url('add-equipment') ?>"><i class="bi bi-arrow-right-short"></i>Add Equipment</a>
                      </li>
                      <li>
                          <a href="<?= base_url('all-equipment') ?>"><i class="bi bi-arrow-right-short"></i>All Equipment </a>
                      </li>
                      <li>
                          <a href="<?= base_url('manage-category') ?>"><i class="bi bi-arrow-right-short"></i>Manage Category</a>
                      </li>
                  </ul>
              </li>
              <!-- mannage  Equipment end here-->
              <!-- manage Project -->
              <li>
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon">
                          <i class="bx bx-window-alt"></i>
                      </div>
                      <div class="menu-title font-clash">Manage Projects</div>
                  </a>
                  <ul>

                      <li>
                          <a href="<?= base_url('add-project') ?>"><i class="bi bi-arrow-right-short"></i>Add Project</a>
                      </li>
                      <li>
                          <a href="<?= base_url('all-projects') ?>"><i class="bi bi-arrow-right-short"></i>All Projects </a>
                      </li>
                      <li>
                          <a href="<?= base_url('project-category') ?>"><i class="bi bi-arrow-right-short"></i>Project Category</a>
                      </li>
                  </ul>
              </li>
              <!-- mannage  Equipment end here-->
          </ul>
          <!--end navigation-->
      </aside>
      <!--end sidebar -->
  <?php
    }
    ?>