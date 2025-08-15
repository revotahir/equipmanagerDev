<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?=base_url()?>assets/images/favicon.png" type="image/png" />
    <title>Metro Foods</title>
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
    <link rel="stylesheet" href="<?=base_url()?>assets/css/style.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/toastr/toastr.min.css">
  </head>
  <body>
    <!-- ============================================= -->
    <!-- Header starts here -->
    <!-- ============================================= -->
    <header class="mainBox">
      <div class="container">
        <div class="row">
          <a href="#">
            <img src="<?=base_url()?>assets/images/logo.png" alt="Logo" />
          </a>
        </div>
      </div>
    </header>
    <!-- ============================================= -->
    <!-- Header end here -->
    <!-- ============================================= -->

    <!-- ============================================= -->
    <!-- Hero section starts here -->
    <!-- ============================================= -->
    <section class="hero-mainBox">
      <!-- <img src="assets/images/leaf.png" alt="leaf" /> -->
      <div class="container">
        <div class="row">
          <div class="hero-section">
            <h1>Login</h1>
          </div>
        </div>
      </div>
    </section>
    <!-- ============================================= -->
    <!-- Hero section end here -->
    <!-- ============================================= -->

    <!-- ============================================= -->
    <!-- Form section starts here -->
    <!-- ============================================= -->
    <section class="form-mainBox">
      <div class="container">
        <div class="row">
          <form method="post" action="<?=base_url('login-data')?>">
            <h2>Login</h2>
            <span
              >Metro Food Customer Login Portal</span
            >
            <input
              type="email"
              name="email-address"
              id="email-address"
              placeholder="Email Address"
              required
            />
            <div class="password-wrapper">
              <input
                type="password"
                name="email-password"
                id="email-password"
                placeholder="Password"
                required
              />
              <ion-icon id="toggle-password" name="eye"></ion-icon>
            </div>
            <div class="button-area">
              <button type="submit">
                Login <ion-icon name="chevron-forward-outline"></ion-icon>
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- ============================================= -->
    <!-- Form section end here -->
    <!-- ============================================= -->

    <!-- ============================================= -->
    <!-- info section starts here -->
    <!-- ============================================= -->
    <section class="mainBox">
      <div class="container">
        <div class="row box-shadow">
          <div class="info-box">
            <img src="<?=base_url()?>assets/images/map.svg" alt="Map" />
            <span>2800 Wegworth Ln. Baltimore, MD 21230 United States</span>
          </div>
          <div class="info-box border-line">
            <a href="mailto:sales@freshcreativecuisine.com">
              <img src="<?=base_url()?>assets/images/env.svg" alt="Mail" />
              <span>sales@freshcreativecuisine.com</span>
            </a>
          </div>
          <div class="info-box">
            <a href="tel:855-969-3338">
              <img src="<?=base_url()?>assets/images/phone.svg" alt="Phone" />
              <span>855-969-3338</span>
            </a>
          </div>
        </div>
      </div>
    </section>
    <!-- ============================================= -->
    <!-- info section end here -->
    <!-- ============================================= -->

    <!-- ============================================= -->
    <!-- footer section starts here -->
    <!-- ============================================= -->
    <header class="footer-mainBox">
      <div class="container">
        <div class="row">
          <!-- <div> -->
          <a href="#">
            <img src="assets/images/logo.png" alt="Logo" />
          </a>
          <p>
            Our recipes and fresh foods are prepared by our very own in-house
            chefs using the finest “fresh & local” ingredients available.
          </p>
          <!-- </div> -->
        </div>
      </div>
    </header>
    <!-- ============================================= -->
    <!-- footer section end here -->
    <!-- ============================================= -->
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/toastr/toastr.min.js"></script>
    <?php
    if ($this->session->flashdata('error') != '') {
    ?>
    <script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.error('Invalid Login!');
    </script>
    <?php
    }
    ?>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll("input[required]").forEach((input) => {
        input.addEventListener("input", () => validateField(input));
      });

      document
        .getElementById("toggle-password")
        .addEventListener("click", function () {
          const passwordField = document.getElementById("email-password");
          if (passwordField.type === "password") {
            passwordField.type = "text";
            this.setAttribute("name", "eye");
          } else {
            passwordField.type = "password";
            this.setAttribute("name", "eye-off");
          }
        });

      function validateField(field) {
        if (field.type === "email") validateEmail(field);
        else validateRequired(field);
      }

      function validateRequired(field) {
        field.style.borderBottom = field.value.trim()
          ? "1px solid green"
          : "1px solid red";
      }

      function validateEmail(field) {
        field.style.borderBottom = /@.+\./.test(field.value)
          ? "1px solid green"
          : "1px solid red";
      }
    });
  </script>
</html>
