<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Equip Managemnt</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url()?>assets/website/img/favicon.svg" />
    <link rel="stylesheet" href="<?= base_url()?>assets/website/css/style.css" />
    <link rel="stylesheet" href="<?= base_url()?>assets/website/css/header.css" />
    <link rel="stylesheet" href="<?= base_url()?>assets/website/css/footer.css" />
    <link rel="stylesheet" href="<?= base_url()?>assets/website/css/home.css" />
    <link rel="stylesheet" href="<?= base_url()?>assets/website/css/resopnsive.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Link Swiper's CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  </head>
  <body>
    <?php $this->load->view('components/websiteHeader'); ?>
    <!-- body section -->
    <section class="hero-section">
      <div class="container">
        <div class="inner-hero-section">
          <span class="slide">EQUIP MANAGER</span>
          <h1>
            Rent, Hire, or List Your Workforce And Equipment with Confidence
          </h1>
          <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting
            industry. Lorem Ipsum has been the industry's standard
          </p>
          <div class="hero-btn">
            <div class="btns">
              <a href="#" class="btn-parrot-green">Browse Marketplace</a>
              <a href="#" class="btn-white-transparent"
                >REGISTER YOUR COMPANY</a
              >
            </div>
            <div class="client">
              <img src="<?= base_url()?>assets/website/img/clients.webp" alt="image" />
              <span>50K+ HAPPY CLIENTS</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- search -->
    <section class="search">
      <div class="container">
        <div class="inner-search">
          <span>Search Equipment</span>
          <form action="" method="post" class="search-main">
            <!-- Custom Select Element -->
            <div
              class="custom-select-element"
              data-custom-select-element
              data-custom-select-value
            >
              <div
                class="custom-select-label-wrapper"
                data-custom-select-triger
              >
                <div class="custom-select-icon-txt">
                  <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M8 10.75H4C3.27088 10.7493 2.57184 10.4593 2.05628 9.94372C1.54071 9.42816 1.25074 8.72912 1.25 8V4C1.25074 3.27088 1.54071 2.57184 2.05628 2.05628C2.57184 1.54071 3.27088 1.25074 4 1.25H8C8.72912 1.25074 9.42816 1.54071 9.94372 2.05628C10.4593 2.57184 10.7493 3.27088 10.75 4V8C10.7493 8.72912 10.4593 9.42816 9.94372 9.94372C9.42816 10.4593 8.72912 10.7493 8 10.75ZM4 2.75C3.66857 2.75031 3.35081 2.8821 3.11646 3.11646C2.8821 3.35081 2.75031 3.66857 2.75 4V8C2.75031 8.33143 2.8821 8.64919 3.11646 8.88354C3.35081 9.1179 3.66857 9.24969 4 9.25H8C8.33143 9.24969 8.64919 9.1179 8.88354 8.88354C9.1179 8.64919 9.24969 8.33143 9.25 8V4C9.24969 3.66857 9.1179 3.35081 8.88354 3.11646C8.64919 2.8821 8.33143 2.75031 8 2.75H4Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M20 10.75H16C15.2709 10.7493 14.5718 10.4593 14.0563 9.94372C13.5407 9.42816 13.2507 8.72912 13.25 8V4C13.2507 3.27088 13.5407 2.57184 14.0563 2.05628C14.5718 1.54071 15.2709 1.25074 16 1.25H20C20.7291 1.25074 21.4282 1.54071 21.9437 2.05628C22.4593 2.57184 22.7493 3.27088 22.75 4V8C22.7493 8.72912 22.4593 9.42816 21.9437 9.94372C21.4282 10.4593 20.7291 10.7493 20 10.75ZM16 2.75C15.6686 2.75031 15.3508 2.8821 15.1165 3.11646C14.8821 3.35081 14.7503 3.66857 14.75 4V8C14.7503 8.33143 14.8821 8.64919 15.1165 8.88354C15.3508 9.1179 15.6686 9.24969 16 9.25H20C20.3314 9.24969 20.6492 9.1179 20.8835 8.88354C21.1179 8.64919 21.2497 8.33143 21.25 8V4C21.2497 3.66857 21.1179 3.35081 20.8835 3.11646C20.6492 2.8821 20.3314 2.75031 20 2.75H16Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M8 22.75H4C3.27088 22.7493 2.57184 22.4593 2.05628 21.9437C1.54071 21.4282 1.25074 20.7291 1.25 20V16C1.25074 15.2709 1.54071 14.5718 2.05628 14.0563C2.57184 13.5407 3.27088 13.2507 4 13.25H8C8.72912 13.2507 9.42816 13.5407 9.94372 14.0563C10.4593 14.5718 10.7493 15.2709 10.75 16V20C10.7493 20.7291 10.4593 21.4282 9.94372 21.9437C9.42816 22.4593 8.72912 22.7493 8 22.75ZM4 14.75C3.66857 14.7503 3.35081 14.8821 3.11646 15.1165C2.8821 15.3508 2.75031 15.6686 2.75 16V20C2.75031 20.3314 2.8821 20.6492 3.11646 20.8835C3.35081 21.1179 3.66857 21.2497 4 21.25H8C8.33143 21.2497 8.64919 21.1179 8.88354 20.8835C9.1179 20.6492 9.24969 20.3314 9.25 20V16C9.24969 15.6686 9.1179 15.3508 8.88354 15.1165C8.64919 14.8821 8.33143 14.7503 8 14.75H4Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M18.0002 23.335C17.7705 23.3355 17.5428 23.2905 17.3305 23.2027C17.1181 23.1149 16.9253 22.9859 16.7629 22.8233L13.177 19.2373C12.8492 18.909 12.665 18.464 12.665 18C12.665 17.536 12.8492 17.091 13.177 16.7627L16.7629 13.1768C17.0913 12.8489 17.5363 12.6648 18.0002 12.6648C18.4642 12.6648 18.9092 12.8489 19.2375 13.1768L22.8235 16.7627C23.1513 17.091 23.3354 17.536 23.3354 18C23.3354 18.464 23.1513 18.909 22.8235 19.2373L19.2375 22.8232C19.0752 22.9859 18.8823 23.1149 18.67 23.2027C18.4577 23.2905 18.23 23.3355 18.0002 23.335ZM18.0002 14.1641C17.9674 14.164 17.9349 14.1704 17.9045 14.183C17.8742 14.1956 17.8466 14.2141 17.8235 14.2373L14.2375 17.8232C14.2143 17.8464 14.1959 17.874 14.1833 17.9043C14.1708 17.9347 14.1643 17.9672 14.1643 18C14.1643 18.0328 14.1708 18.0653 14.1833 18.0957C14.1959 18.126 14.2143 18.1535 14.2375 18.1768L17.8235 21.7627C17.8467 21.7859 17.8742 21.8043 17.9046 21.8169C17.9349 21.8295 17.9674 21.8359 18.0002 21.8359C18.0331 21.8359 18.0656 21.8295 18.0959 21.8169C18.1262 21.8043 18.1538 21.7859 18.177 21.7627L21.7629 18.1768C21.7862 18.1535 21.8046 18.126 21.8171 18.0957C21.8297 18.0653 21.8362 18.0328 21.8362 18C21.8362 17.9672 21.8297 17.9347 21.8171 17.9043C21.8046 17.874 21.7862 17.8464 21.7629 17.8232L18.177 14.2373C18.1538 14.214 18.1263 14.1955 18.096 14.183C18.0656 14.1704 18.0331 14.164 18.0002 14.1641Z"
                      fill="#585B7C"
                    />
                  </svg>

                  <div class="custom-select-label-option-text">
                    <span class="cos-label">CATEGORY</span>
                    <span class="custom-select-label-txt"> </span>
                  </div>
                </div>
                <div class="custom-select-chevron">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="25"
                    height="24"
                    viewBox="0 0 25 24"
                    fill="none"
                  >
                    <path
                      d="M20.4201 8.95L13.9001 15.47C13.1301 16.24 11.8701 16.24 11.1001 15.47L4.58008 8.95"
                      stroke="none"
                      stroke-width="1.5"
                      stroke-miterlimit="10"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </div>
              </div>
              <div
                class="custom-select-options-dropdown-wrapper"
                data-custom-select-dropdown
              >
                <div class="custom-select-options-dropdown-container">
                  <div
                    class="custom-select-options-search"
                    data-custom-select-options-search
                  >
                    <div class="label-input">
                      <!-- Placeholder Icon -->
                      <div class="input-placeholder-icon">
                        <svg
                          class="svg-icon"
                          xmlns="http://www.w3.org/2000/svg"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                        >
                          <path
                            d="M20 11C20 15.97 15.97 20 11 20C6.03 20 2 15.97 2 11C2 6.03 6.03 2 11 2"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                          <path
                            d="M18.9299 20.6898C19.4599 22.2898 20.6699 22.4498 21.5999 21.0498C22.4499 19.7698 21.8899 18.7198 20.3499 18.7198C19.2099 18.7098 18.5699 19.5998 18.9299 20.6898Z"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                          <path
                            d="M14 5H20"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                          <path
                            d="M14 8H17"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                        </svg>
                      </div>
                      <input type="text" placeholder="Search here" />
                    </div>
                  </div>
                  <div class="custom-select-options-lists-container">
                    <ul
                      class="custom-select-options-list"
                      data-custom-select-options-list
                    >
                      <li class="custom-select-option">
                        <span>Heavy Machinery</span>
                      </li>
                      <li class="custom-select-option">
                        <span>Heavy Machinery 1</span>
                      </li>
                      <li class="custom-select-option">
                        <span>Heavy Machinery 2</span>
                      </li>
                      <li class="custom-select-option">
                        <span>Heavy Machinery 3</span>
                      </li>
                      <li class="custom-select-option">
                        <span>Heavy Machinery 4</span>
                      </li>
                      <li class="custom-select-option">
                        <span>Heavy Machinery 5</span>
                      </li>
                      <li class="custom-select-option">
                        <span>Heavy Machinery 6</span>
                      </li>
                      <li class="custom-select-option">
                        <span>Heavy Machinery 7</span>
                      </li>
                      <li class="custom-select-option">
                        <span>Heavy Machinery 8</span>
                      </li>
                      <li class="custom-select-option">
                        <span>Heavy Machinery 9</span>
                      </li>
                      <li class="custom-select-option">
                        <span>Heavy Machinery 10</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Custom Select Element -->
            <!-- Custom Select Element -->
            <div
              class="custom-select-element"
              data-custom-select-element
              data-custom-select-value
            >
              <div
                class="custom-select-label-wrapper"
                data-custom-select-triger
              >
                <div class="custom-select-icon-txt">
                  <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M19.1781 2.9731C17.2609 1.05586 14.7118 0 12.0004 0C9.28906 0 6.7399 1.05586 4.82271 2.9731C2.90547 4.89038 1.84961 7.43945 1.84961 10.1508C1.84961 15.6357 7.03578 20.1978 9.82198 22.6487C10.2092 22.9893 10.5435 23.2835 10.8099 23.5323C11.1437 23.844 11.5721 24 12.0004 24C12.4288 24 12.8571 23.844 13.1909 23.5323C13.4572 23.2834 13.7916 22.9893 14.1788 22.6487C16.965 20.1978 22.1512 15.6357 22.1512 10.1508C22.1511 7.43945 21.0953 4.89038 19.1781 2.9731ZM13.2502 21.5932C12.8545 21.9412 12.5128 22.2419 12.2311 22.505C12.1017 22.6258 11.899 22.6258 11.7696 22.505C11.4879 22.2418 11.1462 21.9412 10.7505 21.5932C8.13111 19.289 3.25539 15 3.25539 10.1508C3.25539 5.32885 7.17832 1.40592 12.0003 1.40592C16.8223 1.40592 20.7452 5.32885 20.7452 10.1508C20.7452 15 15.8696 19.289 13.2502 21.5932Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M11.9997 5.29401C9.53309 5.29401 7.52637 7.30068 7.52637 9.7673C7.52637 12.2339 9.53309 14.2406 11.9997 14.2406C14.4663 14.2406 16.473 12.2339 16.473 9.7673C16.473 7.30068 14.4663 5.29401 11.9997 5.29401ZM11.9997 12.8347C10.3083 12.8347 8.93224 11.4586 8.93224 9.76725C8.93224 8.0759 10.3083 6.69984 11.9997 6.69984C13.6911 6.69984 15.0671 8.0759 15.0671 9.76725C15.0671 11.4586 13.6911 12.8347 11.9997 12.8347Z"
                      fill="#585B7C"
                    />
                  </svg>

                  <div class="custom-select-label-option-text">
                    <span class="cos-label">LOCATION</span>
                    <span class="custom-select-label-txt"> </span>
                  </div>
                </div>
                <div class="custom-select-chevron">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="25"
                    height="24"
                    viewBox="0 0 25 24"
                    fill="none"
                  >
                    <path
                      d="M20.4201 8.95L13.9001 15.47C13.1301 16.24 11.8701 16.24 11.1001 15.47L4.58008 8.95"
                      stroke="none"
                      stroke-width="1.5"
                      stroke-miterlimit="10"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </div>
              </div>
              <div
                class="custom-select-options-dropdown-wrapper"
                data-custom-select-dropdown
              >
                <div class="custom-select-options-dropdown-container">
                  <div
                    class="custom-select-options-search"
                    data-custom-select-options-search
                  >
                    <div class="label-input">
                      <!-- Placeholder Icon -->
                      <div class="input-placeholder-icon">
                        <svg
                          class="svg-icon"
                          xmlns="http://www.w3.org/2000/svg"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                        >
                          <path
                            d="M20 11C20 15.97 15.97 20 11 20C6.03 20 2 15.97 2 11C2 6.03 6.03 2 11 2"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                          <path
                            d="M18.9299 20.6898C19.4599 22.2898 20.6699 22.4498 21.5999 21.0498C22.4499 19.7698 21.8899 18.7198 20.3499 18.7198C19.2099 18.7098 18.5699 19.5998 18.9299 20.6898Z"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                          <path
                            d="M14 5H20"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                          <path
                            d="M14 8H17"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                        </svg>
                      </div>
                      <input type="text" placeholder="Search here" />
                    </div>
                  </div>
                  <div class="custom-select-options-lists-container">
                    <ul
                      class="custom-select-options-list"
                      data-custom-select-options-list
                    >
                      <li class="custom-select-option">
                        <span>New York, USA</span>
                      </li>
                      <li class="custom-select-option">
                        <span>New York, USA 1</span>
                      </li>
                      <li class="custom-select-option">
                        <span>New York, USA 2</span>
                      </li>
                      <li class="custom-select-option">
                        <span>New York, USA 3</span>
                      </li>
                      <li class="custom-select-option">
                        <span>New York, USA 4</span>
                      </li>
                      <li class="custom-select-option">
                        <span>New York, USA 5</span>
                      </li>
                      <li class="custom-select-option">
                        <span>New York, USA 6</span>
                      </li>
                      <li class="custom-select-option">
                        <span>New York, USA 7</span>
                      </li>
                      <li class="custom-select-option">
                        <span>New York, USA 8</span>
                      </li>
                      <li class="custom-select-option">
                        <span>New York, USA 9</span>
                      </li>
                      <li class="custom-select-option">
                        <span>New York, USA 10</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Custom Select Element -->
            <!-- Custom Select Element -->
            <div
              class="custom-select-element"
              data-custom-select-element
              data-custom-select-value
            >
              <div
                class="custom-select-label-wrapper"
                data-custom-select-triger
              >
                <div class="custom-select-icon-txt">
                  <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M12 22.5C9.9233 22.5 7.89323 21.8842 6.16652 20.7304C4.4398 19.5767 3.09399 17.9368 2.29927 16.0182C1.50455 14.0996 1.29661 11.9884 1.70176 9.95156C2.1069 7.91476 3.10693 6.04383 4.57538 4.57538C6.04383 3.10693 7.91476 2.1069 9.95156 1.70176C11.9884 1.29661 14.0996 1.50455 16.0182 2.29927C17.9368 3.09399 19.5767 4.4398 20.7304 6.16652C21.8842 7.89323 22.5 9.9233 22.5 12C22.5 14.7848 21.3938 17.4555 19.4246 19.4246C17.4555 21.3938 14.7848 22.5 12 22.5ZM12 3C10.22 3 8.47992 3.52785 6.99987 4.51678C5.51983 5.50571 4.36628 6.91132 3.68509 8.55585C3.0039 10.2004 2.82567 12.01 3.17294 13.7558C3.5202 15.5016 4.37737 17.1053 5.63604 18.364C6.89472 19.6226 8.49836 20.4798 10.2442 20.8271C11.99 21.1743 13.7996 20.9961 15.4442 20.3149C17.0887 19.6337 18.4943 18.4802 19.4832 17.0001C20.4722 15.5201 21 13.78 21 12C21 9.61306 20.0518 7.32387 18.364 5.63604C16.6761 3.94822 14.387 3 12 3Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M15.75 15.75C15.5808 15.749 15.417 15.6909 15.285 15.585L11.535 12.585C11.4466 12.5152 11.3751 12.4263 11.3257 12.325C11.2764 12.2237 11.2505 12.1127 11.25 12V6C11.25 5.80109 11.329 5.61032 11.4697 5.46967C11.6103 5.32902 11.8011 5.25 12 5.25C12.1989 5.25 12.3897 5.32902 12.5303 5.46967C12.671 5.61032 12.75 5.80109 12.75 6V11.64L16.215 14.415C16.3695 14.5387 16.4689 14.7186 16.4914 14.9153C16.5138 15.112 16.4576 15.3096 16.335 15.465C16.2652 15.5534 16.1763 15.6249 16.075 15.6742C15.9737 15.7236 15.8627 15.7495 15.75 15.75Z"
                      fill="#585B7C"
                    />
                  </svg>

                  <div class="custom-select-label-option-text">
                    <span class="cos-label">AVAILABILITY</span>
                    <span class="custom-select-label-txt"> </span>
                  </div>
                </div>
                <div class="custom-select-chevron">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="25"
                    height="24"
                    viewBox="0 0 25 24"
                    fill="none"
                  >
                    <path
                      d="M20.4201 8.95L13.9001 15.47C13.1301 16.24 11.8701 16.24 11.1001 15.47L4.58008 8.95"
                      stroke="none"
                      stroke-width="1.5"
                      stroke-miterlimit="10"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </div>
              </div>
              <div
                class="custom-select-options-dropdown-wrapper"
                data-custom-select-dropdown
              >
                <div class="custom-select-options-dropdown-container">
                  <div
                    class="custom-select-options-search"
                    data-custom-select-options-search
                  >
                    <div class="label-input">
                      <!-- Placeholder Icon -->
                      <div class="input-placeholder-icon">
                        <svg
                          class="svg-icon"
                          xmlns="http://www.w3.org/2000/svg"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                        >
                          <path
                            d="M20 11C20 15.97 15.97 20 11 20C6.03 20 2 15.97 2 11C2 6.03 6.03 2 11 2"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                          <path
                            d="M18.9299 20.6898C19.4599 22.2898 20.6699 22.4498 21.5999 21.0498C22.4499 19.7698 21.8899 18.7198 20.3499 18.7198C19.2099 18.7098 18.5699 19.5998 18.9299 20.6898Z"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                          <path
                            d="M14 5H20"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                          <path
                            d="M14 8H17"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          ></path>
                        </svg>
                      </div>
                      <input type="text" placeholder="Search here" />
                    </div>
                  </div>
                  <div class="custom-select-options-lists-container">
                    <ul
                      class="custom-select-options-list"
                      data-custom-select-options-list
                    >
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025</span>
                      </li>
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025 1</span>
                      </li>
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025 2</span>
                      </li>
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025 3</span>
                      </li>
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025 4</span>
                      </li>
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025 5</span>
                      </li>
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025 6</span>
                      </li>
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025 7</span>
                      </li>
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025 8</span>
                      </li>
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025 9</span>
                      </li>
                      <li class="custom-select-option">
                        <span>2 July - 10 July 2025 10</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- Custom Select Element -->

            <a href="#" class="btn-dark-green btn-responsive">SEARCH</a>
          </form>
        </div>
      </div>
    </section>

    <!-- how it works -->
    <section class="how-it-work">
      <div class="container">
        <div class="inner-how-it-works">
          <div class="how-img">
            <img
              src="<?= base_url()?>assets/website/img/16fb6ac02ec32d408b1e2a37b4a78c241610b23b.webp"
              alt="image"
            />
          </div>
          <div class="how-works">
            <span class="sub-heading">HOW IT WORKS</span>
            <h2 class="text-h2">We Provide Cost Effective Solution For You</h2>
            <p class="text-para">
              Lorem Ipsum is simply dummy text of the printing and typesetting
              industry. Lorem Ip sum has been the industry's standard Lorem
              Ipsum is simply dummy text of the printing and typesetting
              industry.
            </p>
            <!-- timeline -->
            <div class="timeline">
              <!-- timeline card start-->
              <div class="timeline-card">
                <img src="<?= base_url()?>assets/website/img/register.svg" alt="Register" />
                <span>Register your company</span>
              </div>
              <!-- line -->
              <div class="timeline-line">
                <img src="<?= base_url()?>assets/website/img/circle-line.svg" alt="line" />
              </div>
              <!-- timeline card end-->

              <!-- timeline card start-->
              <div class="timeline-card">
                <img src="<?= base_url()?>assets/website/img/list.svg" alt="Register" />
                <span>List your tools, equipment, or skilled staff</span>
              </div>
              <!-- line -->
              <div class="timeline-line">
                <img src="<?= base_url()?>assets/website/img/circle-line.svg" alt="line" />
              </div>
              <!-- timeline card end-->

              <!-- timeline card start-->
              <div class="timeline-card">
                <img src="<?= base_url()?>assets/website/img/rent.svg" alt="Register" />
                <span>Rent or get hired through our secure platform</span>
              </div>
              <!-- line -->
              <div class="timeline-line">
                <img src="<?= base_url()?>assets/website/img/circle-line.svg" alt="line" />
              </div>
              <!-- timeline card end-->

              <!-- timeline card start-->
              <div class="timeline-card">
                <img src="<?= base_url()?>assets/website/img/track.svg" alt="Register" />
                <span>Track everything from your company dashboard</span>
              </div>
              <!-- timeline card end-->
            </div>
          </div>
        </div>
      </div>
    </section>

    <!--  what's available -->
    <section class="available">
      <div class="container">
        <div class="inner-available">
          <h2 class="text-h2"> what's available</h2>
          <!-- tabs -->
          <div class="tabs">
            <button class="tab-btn active" data-tab="workforce">
              Workforce
            </button>
            <button class="tab-btn" data-tab="equipment">Equipment</button>
            <button class="tab-btn" data-tab="services">Services</button>
          </div>

          <!-- cards start-->
          <div class="tab-content active-tab" id="workforce">
            <div class="cards">
              <!-- single card -->
              <div class="single-card one-card">
                <svg
                  width="40"
                  height="40"
                  viewBox="0 0 40 40"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <circle
                    data-figma-bg-blur-radius="22"
                    cx="20"
                    cy="20"
                    r="20"
                    fill="#34FF67"
                  />
                  <path
                    d="M25.0351 16.1111C25.0344 15.8073 24.9135 15.5162 24.6987 15.3015C24.4839 15.0867 24.1928 14.9658 23.8891 14.9651L17.4073 14.9651C17.2568 14.9651 17.1078 14.9947 16.9688 15.0523C16.8297 15.1099 16.7034 15.1943 16.597 15.3007C16.3821 15.5156 16.2613 15.8071 16.2613 16.1111C16.2613 16.415 16.3821 16.7065 16.597 16.9214C16.8119 17.1363 17.1034 17.257 17.4073 17.257H21.1227L15.3007 23.079C15.0858 23.2939 14.9651 23.5853 14.9651 23.8892C14.9651 24.1931 15.0858 24.4846 15.3007 24.6995C15.5156 24.9143 15.8071 25.0351 16.111 25.0351C16.4148 25.0351 16.7063 24.9143 16.9212 24.6995L22.7431 18.8775L22.7431 22.5929C22.7431 22.7434 22.7728 22.8924 22.8304 23.0314C22.888 23.1705 22.9724 23.2968 23.0788 23.4032C23.1852 23.5096 23.3115 23.594 23.4506 23.6516C23.5896 23.7092 23.7386 23.7389 23.8891 23.7389C24.0396 23.7389 24.1886 23.7092 24.3277 23.6516C24.4667 23.594 24.593 23.5096 24.6995 23.4032C24.8059 23.2968 24.8903 23.1705 24.9479 23.0314C25.0055 22.8924 25.0351 22.7434 25.0351 22.5929L25.0351 16.1111Z"
                    fill="#0F2F2C"
                  />
                  <defs>
                    <clipPath
                      id="bgblur_0_2218_3538_clip_path"
                      transform="translate(22 22)"
                    >
                      <circle cx="20" cy="20" r="20" />
                    </clipPath>
                  </defs>
                </svg>
                <div class="card-info">
                  <div>
                    <svg
                      width="18"
                      height="18"
                      viewBox="0 0 18 18"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <g clip-path="url(#clip0_2218_3549)">
                        <path
                          d="M11.6719 9.03516H13.0781C13.0781 11.2838 11.2488 13.1133 9 13.1133C6.75124 13.1133 4.92188 11.2838 4.92188 9.03516H6.32812C6.32812 10.5084 7.52673 11.707 9 11.707C10.4733 11.707 11.6719 10.5084 11.6719 9.03516ZM17.1028 8.92186L16.708 9.03516H16.5938V9.06798L14.4152 9.69324L14.3291 10.1093C14.1915 10.774 13.9296 11.4037 13.5507 11.9807L13.3132 12.3425L14.4256 14.2747L14.2747 14.4256L12.3425 13.3131L11.9807 13.5505C11.4037 13.9294 10.774 14.1913 10.1093 14.3289L9.68404 14.4171L9.10506 16.5938H8.89494L8.31596 14.4171L7.89066 14.3291C7.22585 14.1915 6.59633 13.9296 6.01913 13.5507L5.65741 13.3132L3.72519 14.4256L3.57426 14.2747L4.68677 12.3426L4.44933 11.9809C4.07043 11.4037 3.80855 10.7742 3.67094 10.1093L3.58484 9.69337L1.40625 9.06798V9.03516H1.29199L0.897171 8.92186L0.864624 9.03516H0V10.1273L2.39502 10.8148C2.54457 11.3593 2.76183 11.8824 3.04404 12.3775L1.81796 14.507L3.49297 16.182L5.62253 14.956C6.11485 15.2367 6.63478 15.453 7.17613 15.6025L7.81389 18H10.1861L10.8239 15.6025C11.3652 15.453 11.8851 15.2367 12.3775 14.956L14.507 16.182L16.182 14.507L14.956 12.3775C15.2382 11.8824 15.4554 11.3593 15.605 10.8148L18 10.1273V9.03516H17.1354L17.1028 8.92186ZM1.40625 7.62891H0C0 6.33746 0.709579 5.20876 1.75919 4.61165C1.53644 4.27725 1.40625 3.87625 1.40625 3.44531C1.40625 2.28214 2.35245 1.33594 3.51562 1.33594C4.6788 1.33594 5.625 2.28214 5.625 3.44531C5.625 3.89191 5.48506 4.30637 5.24734 4.64777C5.45265 4.77013 5.64505 4.91391 5.82152 5.07706C6.16965 4.6442 6.60429 4.28371 7.09895 4.02196C6.74931 3.59692 6.53906 3.05296 6.53906 2.46094C6.53906 1.10399 7.64305 0 9 0C10.3569 0 11.4609 1.10399 11.4609 2.46094C11.4609 3.05296 11.2507 3.59692 10.901 4.02196C11.3957 4.28371 11.8304 4.6442 12.1786 5.07706C12.3551 4.91391 12.5475 4.77013 12.7528 4.64777C12.5149 4.30637 12.375 3.89191 12.375 3.44531C12.375 2.28214 13.3212 1.33594 14.4844 1.33594C15.6476 1.33594 16.5938 2.28214 16.5938 3.44531C16.5938 3.87625 16.4636 4.27725 16.2408 4.61165C17.2904 5.20876 18 6.33746 18 7.62891H16.5938C16.5938 6.49168 15.6686 5.56636 14.5312 5.56636C13.873 5.56636 13.2698 5.87315 12.8842 6.38622C13.01 6.77815 13.0781 7.19577 13.0781 7.62891H11.6719C11.6719 6.15564 10.4733 4.95703 9 4.95703C7.52673 4.95703 6.32812 6.15564 6.32812 7.62891H4.92188C4.92188 7.19577 4.98999 6.77815 5.11578 6.38622C4.73016 5.87315 4.12701 5.5665 3.4688 5.5665C2.33144 5.56636 1.40625 6.49168 1.40625 7.62891ZM13.7812 3.44531C13.7812 3.83299 14.0967 4.14844 14.4844 4.14844C14.8721 4.14844 15.1875 3.83299 15.1875 3.44531C15.1875 3.05763 14.8721 2.74219 14.4844 2.74219C14.0967 2.74219 13.7812 3.05763 13.7812 3.44531ZM7.94531 2.46094C7.94531 3.04253 8.41841 3.51562 9 3.51562C9.58159 3.51562 10.0547 3.04253 10.0547 2.46094C10.0547 1.87935 9.58159 1.40625 9 1.40625C8.41841 1.40625 7.94531 1.87935 7.94531 2.46094ZM2.8125 3.44531C2.8125 3.83299 3.12794 4.14844 3.51562 4.14844C3.90331 4.14844 4.21875 3.83299 4.21875 3.44531C4.21875 3.05763 3.90331 2.74219 3.51562 2.74219C3.12794 2.74219 2.8125 3.05763 2.8125 3.44531Z"
                          fill="white"
                        />
                      </g>
                      <defs>
                        <clipPath id="clip0_2218_3549">
                          <rect width="18" height="18" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                  </div>
                  <h3 class="text-h3">Available Workforce</h3>
                  <span>Electrician in Karachi</span>
                  <div class="price-location">
                    <!-- price -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Price</span>
                      </div>
                      <span>$200.00</span>
                    </div>
                    <div class="line"></div>
                    <!-- location -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Location</span>
                      </div>
                      <span>New York, USA</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- single card -->
              <div class="single-card two-card">
                <svg
                  width="40"
                  height="40"
                  viewBox="0 0 40 40"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <circle
                    data-figma-bg-blur-radius="22"
                    cx="20"
                    cy="20"
                    r="20"
                    fill="#34FF67"
                  />
                  <path
                    d="M25.0351 16.1111C25.0344 15.8073 24.9135 15.5162 24.6987 15.3015C24.4839 15.0867 24.1928 14.9658 23.8891 14.9651L17.4073 14.9651C17.2568 14.9651 17.1078 14.9947 16.9688 15.0523C16.8297 15.1099 16.7034 15.1943 16.597 15.3007C16.3821 15.5156 16.2613 15.8071 16.2613 16.1111C16.2613 16.415 16.3821 16.7065 16.597 16.9214C16.8119 17.1363 17.1034 17.257 17.4073 17.257H21.1227L15.3007 23.079C15.0858 23.2939 14.9651 23.5853 14.9651 23.8892C14.9651 24.1931 15.0858 24.4846 15.3007 24.6995C15.5156 24.9143 15.8071 25.0351 16.111 25.0351C16.4148 25.0351 16.7063 24.9143 16.9212 24.6995L22.7431 18.8775L22.7431 22.5929C22.7431 22.7434 22.7728 22.8924 22.8304 23.0314C22.888 23.1705 22.9724 23.2968 23.0788 23.4032C23.1852 23.5096 23.3115 23.594 23.4506 23.6516C23.5896 23.7092 23.7386 23.7389 23.8891 23.7389C24.0396 23.7389 24.1886 23.7092 24.3277 23.6516C24.4667 23.594 24.593 23.5096 24.6995 23.4032C24.8059 23.2968 24.8903 23.1705 24.9479 23.0314C25.0055 22.8924 25.0351 22.7434 25.0351 22.5929L25.0351 16.1111Z"
                    fill="#0F2F2C"
                  />
                  <defs>
                    <clipPath
                      id="bgblur_0_2218_3538_clip_path"
                      transform="translate(22 22)"
                    >
                      <circle cx="20" cy="20" r="20" />
                    </clipPath>
                  </defs>
                </svg>
                <div class="card-info">
                  <div>
                    <svg
                      width="18"
                      height="18"
                      viewBox="0 0 18 18"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M17.4375 13.6406H15.6094V3.9375C15.6094 3.70459 15.4204 3.51562 15.1875 3.51562H12.9375C12.7046 3.51562 12.5156 3.70459 12.5156 3.9375V10.5991C12.1371 10.3933 11.7103 10.2656 11.25 10.2656H11.1094V8.4375C11.1094 5.50635 10.1733 2.39062 8.4375 2.39062H3.9375C3.73645 2.39062 3.56287 2.53235 3.52332 2.72955L2.46609 8.01562H1.6875C0.834961 8.01562 0.140625 8.70941 0.140625 9.5625V12.375C0.140625 13.0945 0.636658 13.6953 1.30277 13.8676C1.4778 14.8552 2.33748 15.6094 3.375 15.6094C4.18092 15.6094 4.87422 15.1501 5.22922 14.4844H9.07972C9.56477 15.1627 10.3543 15.6094 11.25 15.6094C12.1457 15.6094 12.9352 15.1627 13.4203 14.4844H17.4375C17.6704 14.4844 17.8594 14.2954 17.8594 14.0625C17.8594 13.8296 17.6704 13.6406 17.4375 13.6406ZM10.2656 8.4375V10.2656H6.60938V3.23438H8.4375C9.29993 3.23438 10.2656 5.45966 10.2656 8.4375ZM4.28357 3.23438H5.76562V9.66893L4.23633 8.13922C4.15723 8.06012 4.04956 8.01562 3.9375 8.01562H3.32762L4.28357 3.23438ZM3.375 14.7656C2.67737 14.7656 2.10938 14.1976 2.10938 13.5C2.10938 12.8024 2.67737 12.2344 3.375 12.2344C4.07263 12.2344 4.64062 12.8024 4.64062 13.5C4.64062 14.1976 4.07263 14.7656 3.375 14.7656ZM5.47016 13.6406C5.47332 13.5932 5.48438 13.5481 5.48438 13.5C5.48438 12.3371 4.53845 11.3906 3.375 11.3906C2.39461 11.3906 1.57606 12.0658 1.3404 12.9731C1.13152 12.8511 0.984375 12.6339 0.984375 12.375V9.5625C0.984375 9.17468 1.29968 8.85938 1.6875 8.85938H3.76282L5.88867 10.9858C5.96777 11.0649 6.07544 11.1094 6.1875 11.1094H9.31181C8.86013 11.5881 8.57812 12.229 8.57812 12.9375C8.57812 13.1824 8.62193 13.4151 8.68394 13.6406H5.47016ZM11.25 14.7656C10.2415 14.7656 9.42188 13.9455 9.42188 12.9375C9.42188 11.9295 10.2415 11.1094 11.25 11.1094C12.2585 11.1094 13.0781 11.9295 13.0781 12.9375C13.0781 13.9455 12.2585 14.7656 11.25 14.7656ZM13.3594 11.3168V4.35938H14.7656V13.6406H13.8161C13.8781 13.4151 13.9219 13.1824 13.9219 12.9375C13.9219 12.3255 13.7068 11.7678 13.3594 11.3168Z"
                        fill="white"
                      />
                      <path
                        d="M11.25 13.3594C11.483 13.3594 11.6719 13.1705 11.6719 12.9375C11.6719 12.7045 11.483 12.5156 11.25 12.5156C11.017 12.5156 10.8281 12.7045 10.8281 12.9375C10.8281 13.1705 11.017 13.3594 11.25 13.3594Z"
                        fill="white"
                      />
                    </svg>
                  </div>
                  <h3 class="text-h3">Available Equipment</h3>
                  <span>Concrete Mixer in Lahore </span>
                  <div class="price-location">
                    <!-- price -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Price</span>
                      </div>
                      <span>$200.00</span>
                    </div>
                    <div class="line"></div>
                    <!-- location -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Location</span>
                      </div>
                      <span>New York, USA</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- cards end -->

          <!-- cards start-->
          <div class="tab-content" id="equipment">
            <div class="cards">
              <!-- single card -->
              <div class="single-card one-card">
                <svg
                  width="40"
                  height="40"
                  viewBox="0 0 40 40"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <circle
                    data-figma-bg-blur-radius="22"
                    cx="20"
                    cy="20"
                    r="20"
                    fill="#34FF67"
                  />
                  <path
                    d="M25.0351 16.1111C25.0344 15.8073 24.9135 15.5162 24.6987 15.3015C24.4839 15.0867 24.1928 14.9658 23.8891 14.9651L17.4073 14.9651C17.2568 14.9651 17.1078 14.9947 16.9688 15.0523C16.8297 15.1099 16.7034 15.1943 16.597 15.3007C16.3821 15.5156 16.2613 15.8071 16.2613 16.1111C16.2613 16.415 16.3821 16.7065 16.597 16.9214C16.8119 17.1363 17.1034 17.257 17.4073 17.257H21.1227L15.3007 23.079C15.0858 23.2939 14.9651 23.5853 14.9651 23.8892C14.9651 24.1931 15.0858 24.4846 15.3007 24.6995C15.5156 24.9143 15.8071 25.0351 16.111 25.0351C16.4148 25.0351 16.7063 24.9143 16.9212 24.6995L22.7431 18.8775L22.7431 22.5929C22.7431 22.7434 22.7728 22.8924 22.8304 23.0314C22.888 23.1705 22.9724 23.2968 23.0788 23.4032C23.1852 23.5096 23.3115 23.594 23.4506 23.6516C23.5896 23.7092 23.7386 23.7389 23.8891 23.7389C24.0396 23.7389 24.1886 23.7092 24.3277 23.6516C24.4667 23.594 24.593 23.5096 24.6995 23.4032C24.8059 23.2968 24.8903 23.1705 24.9479 23.0314C25.0055 22.8924 25.0351 22.7434 25.0351 22.5929L25.0351 16.1111Z"
                    fill="#0F2F2C"
                  />
                  <defs>
                    <clipPath
                      id="bgblur_0_2218_3538_clip_path"
                      transform="translate(22 22)"
                    >
                      <circle cx="20" cy="20" r="20" />
                    </clipPath>
                  </defs>
                </svg>
                <div class="card-info">
                  <div>
                    <svg
                      width="18"
                      height="18"
                      viewBox="0 0 18 18"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <g clip-path="url(#clip0_2218_3549)">
                        <path
                          d="M11.6719 9.03516H13.0781C13.0781 11.2838 11.2488 13.1133 9 13.1133C6.75124 13.1133 4.92188 11.2838 4.92188 9.03516H6.32812C6.32812 10.5084 7.52673 11.707 9 11.707C10.4733 11.707 11.6719 10.5084 11.6719 9.03516ZM17.1028 8.92186L16.708 9.03516H16.5938V9.06798L14.4152 9.69324L14.3291 10.1093C14.1915 10.774 13.9296 11.4037 13.5507 11.9807L13.3132 12.3425L14.4256 14.2747L14.2747 14.4256L12.3425 13.3131L11.9807 13.5505C11.4037 13.9294 10.774 14.1913 10.1093 14.3289L9.68404 14.4171L9.10506 16.5938H8.89494L8.31596 14.4171L7.89066 14.3291C7.22585 14.1915 6.59633 13.9296 6.01913 13.5507L5.65741 13.3132L3.72519 14.4256L3.57426 14.2747L4.68677 12.3426L4.44933 11.9809C4.07043 11.4037 3.80855 10.7742 3.67094 10.1093L3.58484 9.69337L1.40625 9.06798V9.03516H1.29199L0.897171 8.92186L0.864624 9.03516H0V10.1273L2.39502 10.8148C2.54457 11.3593 2.76183 11.8824 3.04404 12.3775L1.81796 14.507L3.49297 16.182L5.62253 14.956C6.11485 15.2367 6.63478 15.453 7.17613 15.6025L7.81389 18H10.1861L10.8239 15.6025C11.3652 15.453 11.8851 15.2367 12.3775 14.956L14.507 16.182L16.182 14.507L14.956 12.3775C15.2382 11.8824 15.4554 11.3593 15.605 10.8148L18 10.1273V9.03516H17.1354L17.1028 8.92186ZM1.40625 7.62891H0C0 6.33746 0.709579 5.20876 1.75919 4.61165C1.53644 4.27725 1.40625 3.87625 1.40625 3.44531C1.40625 2.28214 2.35245 1.33594 3.51562 1.33594C4.6788 1.33594 5.625 2.28214 5.625 3.44531C5.625 3.89191 5.48506 4.30637 5.24734 4.64777C5.45265 4.77013 5.64505 4.91391 5.82152 5.07706C6.16965 4.6442 6.60429 4.28371 7.09895 4.02196C6.74931 3.59692 6.53906 3.05296 6.53906 2.46094C6.53906 1.10399 7.64305 0 9 0C10.3569 0 11.4609 1.10399 11.4609 2.46094C11.4609 3.05296 11.2507 3.59692 10.901 4.02196C11.3957 4.28371 11.8304 4.6442 12.1786 5.07706C12.3551 4.91391 12.5475 4.77013 12.7528 4.64777C12.5149 4.30637 12.375 3.89191 12.375 3.44531C12.375 2.28214 13.3212 1.33594 14.4844 1.33594C15.6476 1.33594 16.5938 2.28214 16.5938 3.44531C16.5938 3.87625 16.4636 4.27725 16.2408 4.61165C17.2904 5.20876 18 6.33746 18 7.62891H16.5938C16.5938 6.49168 15.6686 5.56636 14.5312 5.56636C13.873 5.56636 13.2698 5.87315 12.8842 6.38622C13.01 6.77815 13.0781 7.19577 13.0781 7.62891H11.6719C11.6719 6.15564 10.4733 4.95703 9 4.95703C7.52673 4.95703 6.32812 6.15564 6.32812 7.62891H4.92188C4.92188 7.19577 4.98999 6.77815 5.11578 6.38622C4.73016 5.87315 4.12701 5.5665 3.4688 5.5665C2.33144 5.56636 1.40625 6.49168 1.40625 7.62891ZM13.7812 3.44531C13.7812 3.83299 14.0967 4.14844 14.4844 4.14844C14.8721 4.14844 15.1875 3.83299 15.1875 3.44531C15.1875 3.05763 14.8721 2.74219 14.4844 2.74219C14.0967 2.74219 13.7812 3.05763 13.7812 3.44531ZM7.94531 2.46094C7.94531 3.04253 8.41841 3.51562 9 3.51562C9.58159 3.51562 10.0547 3.04253 10.0547 2.46094C10.0547 1.87935 9.58159 1.40625 9 1.40625C8.41841 1.40625 7.94531 1.87935 7.94531 2.46094ZM2.8125 3.44531C2.8125 3.83299 3.12794 4.14844 3.51562 4.14844C3.90331 4.14844 4.21875 3.83299 4.21875 3.44531C4.21875 3.05763 3.90331 2.74219 3.51562 2.74219C3.12794 2.74219 2.8125 3.05763 2.8125 3.44531Z"
                          fill="white"
                        />
                      </g>
                      <defs>
                        <clipPath id="clip0_2218_3549">
                          <rect width="18" height="18" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                  </div>
                  <h3 class="text-h3">Available Equipment</h3>
                  <span>Electrician in Karachi</span>
                  <div class="price-location">
                    <!-- price -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Price</span>
                      </div>
                      <span>$200.00</span>
                    </div>
                    <div class="line"></div>
                    <!-- location -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Location</span>
                      </div>
                      <span>New York, USA</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- single card -->
              <div class="single-card two-card">
                <svg
                  width="40"
                  height="40"
                  viewBox="0 0 40 40"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <circle
                    data-figma-bg-blur-radius="22"
                    cx="20"
                    cy="20"
                    r="20"
                    fill="#34FF67"
                  />
                  <path
                    d="M25.0351 16.1111C25.0344 15.8073 24.9135 15.5162 24.6987 15.3015C24.4839 15.0867 24.1928 14.9658 23.8891 14.9651L17.4073 14.9651C17.2568 14.9651 17.1078 14.9947 16.9688 15.0523C16.8297 15.1099 16.7034 15.1943 16.597 15.3007C16.3821 15.5156 16.2613 15.8071 16.2613 16.1111C16.2613 16.415 16.3821 16.7065 16.597 16.9214C16.8119 17.1363 17.1034 17.257 17.4073 17.257H21.1227L15.3007 23.079C15.0858 23.2939 14.9651 23.5853 14.9651 23.8892C14.9651 24.1931 15.0858 24.4846 15.3007 24.6995C15.5156 24.9143 15.8071 25.0351 16.111 25.0351C16.4148 25.0351 16.7063 24.9143 16.9212 24.6995L22.7431 18.8775L22.7431 22.5929C22.7431 22.7434 22.7728 22.8924 22.8304 23.0314C22.888 23.1705 22.9724 23.2968 23.0788 23.4032C23.1852 23.5096 23.3115 23.594 23.4506 23.6516C23.5896 23.7092 23.7386 23.7389 23.8891 23.7389C24.0396 23.7389 24.1886 23.7092 24.3277 23.6516C24.4667 23.594 24.593 23.5096 24.6995 23.4032C24.8059 23.2968 24.8903 23.1705 24.9479 23.0314C25.0055 22.8924 25.0351 22.7434 25.0351 22.5929L25.0351 16.1111Z"
                    fill="#0F2F2C"
                  />
                  <defs>
                    <clipPath
                      id="bgblur_0_2218_3538_clip_path"
                      transform="translate(22 22)"
                    >
                      <circle cx="20" cy="20" r="20" />
                    </clipPath>
                  </defs>
                </svg>
                <div class="card-info">
                  <div>
                    <svg
                      width="18"
                      height="18"
                      viewBox="0 0 18 18"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M17.4375 13.6406H15.6094V3.9375C15.6094 3.70459 15.4204 3.51562 15.1875 3.51562H12.9375C12.7046 3.51562 12.5156 3.70459 12.5156 3.9375V10.5991C12.1371 10.3933 11.7103 10.2656 11.25 10.2656H11.1094V8.4375C11.1094 5.50635 10.1733 2.39062 8.4375 2.39062H3.9375C3.73645 2.39062 3.56287 2.53235 3.52332 2.72955L2.46609 8.01562H1.6875C0.834961 8.01562 0.140625 8.70941 0.140625 9.5625V12.375C0.140625 13.0945 0.636658 13.6953 1.30277 13.8676C1.4778 14.8552 2.33748 15.6094 3.375 15.6094C4.18092 15.6094 4.87422 15.1501 5.22922 14.4844H9.07972C9.56477 15.1627 10.3543 15.6094 11.25 15.6094C12.1457 15.6094 12.9352 15.1627 13.4203 14.4844H17.4375C17.6704 14.4844 17.8594 14.2954 17.8594 14.0625C17.8594 13.8296 17.6704 13.6406 17.4375 13.6406ZM10.2656 8.4375V10.2656H6.60938V3.23438H8.4375C9.29993 3.23438 10.2656 5.45966 10.2656 8.4375ZM4.28357 3.23438H5.76562V9.66893L4.23633 8.13922C4.15723 8.06012 4.04956 8.01562 3.9375 8.01562H3.32762L4.28357 3.23438ZM3.375 14.7656C2.67737 14.7656 2.10938 14.1976 2.10938 13.5C2.10938 12.8024 2.67737 12.2344 3.375 12.2344C4.07263 12.2344 4.64062 12.8024 4.64062 13.5C4.64062 14.1976 4.07263 14.7656 3.375 14.7656ZM5.47016 13.6406C5.47332 13.5932 5.48438 13.5481 5.48438 13.5C5.48438 12.3371 4.53845 11.3906 3.375 11.3906C2.39461 11.3906 1.57606 12.0658 1.3404 12.9731C1.13152 12.8511 0.984375 12.6339 0.984375 12.375V9.5625C0.984375 9.17468 1.29968 8.85938 1.6875 8.85938H3.76282L5.88867 10.9858C5.96777 11.0649 6.07544 11.1094 6.1875 11.1094H9.31181C8.86013 11.5881 8.57812 12.229 8.57812 12.9375C8.57812 13.1824 8.62193 13.4151 8.68394 13.6406H5.47016ZM11.25 14.7656C10.2415 14.7656 9.42188 13.9455 9.42188 12.9375C9.42188 11.9295 10.2415 11.1094 11.25 11.1094C12.2585 11.1094 13.0781 11.9295 13.0781 12.9375C13.0781 13.9455 12.2585 14.7656 11.25 14.7656ZM13.3594 11.3168V4.35938H14.7656V13.6406H13.8161C13.8781 13.4151 13.9219 13.1824 13.9219 12.9375C13.9219 12.3255 13.7068 11.7678 13.3594 11.3168Z"
                        fill="white"
                      />
                      <path
                        d="M11.25 13.3594C11.483 13.3594 11.6719 13.1705 11.6719 12.9375C11.6719 12.7045 11.483 12.5156 11.25 12.5156C11.017 12.5156 10.8281 12.7045 10.8281 12.9375C10.8281 13.1705 11.017 13.3594 11.25 13.3594Z"
                        fill="white"
                      />
                    </svg>
                  </div>
                  <h3 class="text-h3">Available Services</h3>
                  <span>Concrete Mixer in Lahore </span>
                  <div class="price-location">
                    <!-- price -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Price</span>
                      </div>
                      <span>$200.00</span>
                    </div>
                    <div class="line"></div>
                    <!-- location -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Location</span>
                      </div>
                      <span>New York, USA</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- cards end -->

          <!-- cards start-->
          <div class="tab-content" id="services">
            <div class="cards">
              <!-- single card -->
              <div class="single-card one-card">
                <svg
                  width="40"
                  height="40"
                  viewBox="0 0 40 40"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <circle
                    data-figma-bg-blur-radius="22"
                    cx="20"
                    cy="20"
                    r="20"
                    fill="#34FF67"
                  />
                  <path
                    d="M25.0351 16.1111C25.0344 15.8073 24.9135 15.5162 24.6987 15.3015C24.4839 15.0867 24.1928 14.9658 23.8891 14.9651L17.4073 14.9651C17.2568 14.9651 17.1078 14.9947 16.9688 15.0523C16.8297 15.1099 16.7034 15.1943 16.597 15.3007C16.3821 15.5156 16.2613 15.8071 16.2613 16.1111C16.2613 16.415 16.3821 16.7065 16.597 16.9214C16.8119 17.1363 17.1034 17.257 17.4073 17.257H21.1227L15.3007 23.079C15.0858 23.2939 14.9651 23.5853 14.9651 23.8892C14.9651 24.1931 15.0858 24.4846 15.3007 24.6995C15.5156 24.9143 15.8071 25.0351 16.111 25.0351C16.4148 25.0351 16.7063 24.9143 16.9212 24.6995L22.7431 18.8775L22.7431 22.5929C22.7431 22.7434 22.7728 22.8924 22.8304 23.0314C22.888 23.1705 22.9724 23.2968 23.0788 23.4032C23.1852 23.5096 23.3115 23.594 23.4506 23.6516C23.5896 23.7092 23.7386 23.7389 23.8891 23.7389C24.0396 23.7389 24.1886 23.7092 24.3277 23.6516C24.4667 23.594 24.593 23.5096 24.6995 23.4032C24.8059 23.2968 24.8903 23.1705 24.9479 23.0314C25.0055 22.8924 25.0351 22.7434 25.0351 22.5929L25.0351 16.1111Z"
                    fill="#0F2F2C"
                  />
                  <defs>
                    <clipPath
                      id="bgblur_0_2218_3538_clip_path"
                      transform="translate(22 22)"
                    >
                      <circle cx="20" cy="20" r="20" />
                    </clipPath>
                  </defs>
                </svg>
                <div class="card-info">
                  <div>
                    <svg
                      width="18"
                      height="18"
                      viewBox="0 0 18 18"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <g clip-path="url(#clip0_2218_3549)">
                        <path
                          d="M11.6719 9.03516H13.0781C13.0781 11.2838 11.2488 13.1133 9 13.1133C6.75124 13.1133 4.92188 11.2838 4.92188 9.03516H6.32812C6.32812 10.5084 7.52673 11.707 9 11.707C10.4733 11.707 11.6719 10.5084 11.6719 9.03516ZM17.1028 8.92186L16.708 9.03516H16.5938V9.06798L14.4152 9.69324L14.3291 10.1093C14.1915 10.774 13.9296 11.4037 13.5507 11.9807L13.3132 12.3425L14.4256 14.2747L14.2747 14.4256L12.3425 13.3131L11.9807 13.5505C11.4037 13.9294 10.774 14.1913 10.1093 14.3289L9.68404 14.4171L9.10506 16.5938H8.89494L8.31596 14.4171L7.89066 14.3291C7.22585 14.1915 6.59633 13.9296 6.01913 13.5507L5.65741 13.3132L3.72519 14.4256L3.57426 14.2747L4.68677 12.3426L4.44933 11.9809C4.07043 11.4037 3.80855 10.7742 3.67094 10.1093L3.58484 9.69337L1.40625 9.06798V9.03516H1.29199L0.897171 8.92186L0.864624 9.03516H0V10.1273L2.39502 10.8148C2.54457 11.3593 2.76183 11.8824 3.04404 12.3775L1.81796 14.507L3.49297 16.182L5.62253 14.956C6.11485 15.2367 6.63478 15.453 7.17613 15.6025L7.81389 18H10.1861L10.8239 15.6025C11.3652 15.453 11.8851 15.2367 12.3775 14.956L14.507 16.182L16.182 14.507L14.956 12.3775C15.2382 11.8824 15.4554 11.3593 15.605 10.8148L18 10.1273V9.03516H17.1354L17.1028 8.92186ZM1.40625 7.62891H0C0 6.33746 0.709579 5.20876 1.75919 4.61165C1.53644 4.27725 1.40625 3.87625 1.40625 3.44531C1.40625 2.28214 2.35245 1.33594 3.51562 1.33594C4.6788 1.33594 5.625 2.28214 5.625 3.44531C5.625 3.89191 5.48506 4.30637 5.24734 4.64777C5.45265 4.77013 5.64505 4.91391 5.82152 5.07706C6.16965 4.6442 6.60429 4.28371 7.09895 4.02196C6.74931 3.59692 6.53906 3.05296 6.53906 2.46094C6.53906 1.10399 7.64305 0 9 0C10.3569 0 11.4609 1.10399 11.4609 2.46094C11.4609 3.05296 11.2507 3.59692 10.901 4.02196C11.3957 4.28371 11.8304 4.6442 12.1786 5.07706C12.3551 4.91391 12.5475 4.77013 12.7528 4.64777C12.5149 4.30637 12.375 3.89191 12.375 3.44531C12.375 2.28214 13.3212 1.33594 14.4844 1.33594C15.6476 1.33594 16.5938 2.28214 16.5938 3.44531C16.5938 3.87625 16.4636 4.27725 16.2408 4.61165C17.2904 5.20876 18 6.33746 18 7.62891H16.5938C16.5938 6.49168 15.6686 5.56636 14.5312 5.56636C13.873 5.56636 13.2698 5.87315 12.8842 6.38622C13.01 6.77815 13.0781 7.19577 13.0781 7.62891H11.6719C11.6719 6.15564 10.4733 4.95703 9 4.95703C7.52673 4.95703 6.32812 6.15564 6.32812 7.62891H4.92188C4.92188 7.19577 4.98999 6.77815 5.11578 6.38622C4.73016 5.87315 4.12701 5.5665 3.4688 5.5665C2.33144 5.56636 1.40625 6.49168 1.40625 7.62891ZM13.7812 3.44531C13.7812 3.83299 14.0967 4.14844 14.4844 4.14844C14.8721 4.14844 15.1875 3.83299 15.1875 3.44531C15.1875 3.05763 14.8721 2.74219 14.4844 2.74219C14.0967 2.74219 13.7812 3.05763 13.7812 3.44531ZM7.94531 2.46094C7.94531 3.04253 8.41841 3.51562 9 3.51562C9.58159 3.51562 10.0547 3.04253 10.0547 2.46094C10.0547 1.87935 9.58159 1.40625 9 1.40625C8.41841 1.40625 7.94531 1.87935 7.94531 2.46094ZM2.8125 3.44531C2.8125 3.83299 3.12794 4.14844 3.51562 4.14844C3.90331 4.14844 4.21875 3.83299 4.21875 3.44531C4.21875 3.05763 3.90331 2.74219 3.51562 2.74219C3.12794 2.74219 2.8125 3.05763 2.8125 3.44531Z"
                          fill="white"
                        />
                      </g>
                      <defs>
                        <clipPath id="clip0_2218_3549">
                          <rect width="18" height="18" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                  </div>
                  <h3 class="text-h3">Available Services</h3>
                  <span>Electrician in Karachi</span>
                  <div class="price-location">
                    <!-- price -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Price</span>
                      </div>
                      <span>$200.00</span>
                    </div>
                    <div class="line"></div>
                    <!-- location -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Location</span>
                      </div>
                      <span>New York, USA</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- single card -->
              <div class="single-card two-card">
                <svg
                  width="40"
                  height="40"
                  viewBox="0 0 40 40"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <circle
                    data-figma-bg-blur-radius="22"
                    cx="20"
                    cy="20"
                    r="20"
                    fill="#34FF67"
                  />
                  <path
                    d="M25.0351 16.1111C25.0344 15.8073 24.9135 15.5162 24.6987 15.3015C24.4839 15.0867 24.1928 14.9658 23.8891 14.9651L17.4073 14.9651C17.2568 14.9651 17.1078 14.9947 16.9688 15.0523C16.8297 15.1099 16.7034 15.1943 16.597 15.3007C16.3821 15.5156 16.2613 15.8071 16.2613 16.1111C16.2613 16.415 16.3821 16.7065 16.597 16.9214C16.8119 17.1363 17.1034 17.257 17.4073 17.257H21.1227L15.3007 23.079C15.0858 23.2939 14.9651 23.5853 14.9651 23.8892C14.9651 24.1931 15.0858 24.4846 15.3007 24.6995C15.5156 24.9143 15.8071 25.0351 16.111 25.0351C16.4148 25.0351 16.7063 24.9143 16.9212 24.6995L22.7431 18.8775L22.7431 22.5929C22.7431 22.7434 22.7728 22.8924 22.8304 23.0314C22.888 23.1705 22.9724 23.2968 23.0788 23.4032C23.1852 23.5096 23.3115 23.594 23.4506 23.6516C23.5896 23.7092 23.7386 23.7389 23.8891 23.7389C24.0396 23.7389 24.1886 23.7092 24.3277 23.6516C24.4667 23.594 24.593 23.5096 24.6995 23.4032C24.8059 23.2968 24.8903 23.1705 24.9479 23.0314C25.0055 22.8924 25.0351 22.7434 25.0351 22.5929L25.0351 16.1111Z"
                    fill="#0F2F2C"
                  />
                  <defs>
                    <clipPath
                      id="bgblur_0_2218_3538_clip_path"
                      transform="translate(22 22)"
                    >
                      <circle cx="20" cy="20" r="20" />
                    </clipPath>
                  </defs>
                </svg>
                <div class="card-info">
                  <div>
                    <svg
                      width="18"
                      height="18"
                      viewBox="0 0 18 18"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M17.4375 13.6406H15.6094V3.9375C15.6094 3.70459 15.4204 3.51562 15.1875 3.51562H12.9375C12.7046 3.51562 12.5156 3.70459 12.5156 3.9375V10.5991C12.1371 10.3933 11.7103 10.2656 11.25 10.2656H11.1094V8.4375C11.1094 5.50635 10.1733 2.39062 8.4375 2.39062H3.9375C3.73645 2.39062 3.56287 2.53235 3.52332 2.72955L2.46609 8.01562H1.6875C0.834961 8.01562 0.140625 8.70941 0.140625 9.5625V12.375C0.140625 13.0945 0.636658 13.6953 1.30277 13.8676C1.4778 14.8552 2.33748 15.6094 3.375 15.6094C4.18092 15.6094 4.87422 15.1501 5.22922 14.4844H9.07972C9.56477 15.1627 10.3543 15.6094 11.25 15.6094C12.1457 15.6094 12.9352 15.1627 13.4203 14.4844H17.4375C17.6704 14.4844 17.8594 14.2954 17.8594 14.0625C17.8594 13.8296 17.6704 13.6406 17.4375 13.6406ZM10.2656 8.4375V10.2656H6.60938V3.23438H8.4375C9.29993 3.23438 10.2656 5.45966 10.2656 8.4375ZM4.28357 3.23438H5.76562V9.66893L4.23633 8.13922C4.15723 8.06012 4.04956 8.01562 3.9375 8.01562H3.32762L4.28357 3.23438ZM3.375 14.7656C2.67737 14.7656 2.10938 14.1976 2.10938 13.5C2.10938 12.8024 2.67737 12.2344 3.375 12.2344C4.07263 12.2344 4.64062 12.8024 4.64062 13.5C4.64062 14.1976 4.07263 14.7656 3.375 14.7656ZM5.47016 13.6406C5.47332 13.5932 5.48438 13.5481 5.48438 13.5C5.48438 12.3371 4.53845 11.3906 3.375 11.3906C2.39461 11.3906 1.57606 12.0658 1.3404 12.9731C1.13152 12.8511 0.984375 12.6339 0.984375 12.375V9.5625C0.984375 9.17468 1.29968 8.85938 1.6875 8.85938H3.76282L5.88867 10.9858C5.96777 11.0649 6.07544 11.1094 6.1875 11.1094H9.31181C8.86013 11.5881 8.57812 12.229 8.57812 12.9375C8.57812 13.1824 8.62193 13.4151 8.68394 13.6406H5.47016ZM11.25 14.7656C10.2415 14.7656 9.42188 13.9455 9.42188 12.9375C9.42188 11.9295 10.2415 11.1094 11.25 11.1094C12.2585 11.1094 13.0781 11.9295 13.0781 12.9375C13.0781 13.9455 12.2585 14.7656 11.25 14.7656ZM13.3594 11.3168V4.35938H14.7656V13.6406H13.8161C13.8781 13.4151 13.9219 13.1824 13.9219 12.9375C13.9219 12.3255 13.7068 11.7678 13.3594 11.3168Z"
                        fill="white"
                      />
                      <path
                        d="M11.25 13.3594C11.483 13.3594 11.6719 13.1705 11.6719 12.9375C11.6719 12.7045 11.483 12.5156 11.25 12.5156C11.017 12.5156 10.8281 12.7045 10.8281 12.9375C10.8281 13.1705 11.017 13.3594 11.25 13.3594Z"
                        fill="white"
                      />
                    </svg>
                  </div>
                  <h3 class="text-h3">Available Workforce</h3>
                  <span>Concrete Mixer in Lahore </span>
                  <div class="price-location">
                    <!-- price -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Price</span>
                      </div>
                      <span>$200.00</span>
                    </div>
                    <div class="line"></div>
                    <!-- location -->
                    <div>
                      <div>
                        <svg
                          width="17"
                          height="17"
                          viewBox="0 0 17 17"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M7.23342 16.875C7.233 16.875 7.23249 16.875 7.23197 16.875C6.70391 16.8746 6.20736 16.6686 5.8341 16.2947L0.576731 11.0298C-0.192244 10.2594 -0.192244 9.00584 0.576731 8.23552L7.66374 1.13492C8.39409 0.40313 9.36586 0 10.4 0H14.8963C15.9866 0 16.8738 0.887009 16.8738 1.97754V6.46006C16.8738 7.49343 16.4711 8.46479 15.74 9.19504L8.63098 16.2967C8.25751 16.6696 7.76117 16.875 7.23342 16.875ZM10.4 1.31836C9.71852 1.31836 9.07819 1.58399 8.59689 2.06622L1.50978 9.16682C1.25342 9.42369 1.25342 9.84145 1.50978 10.0983L6.76715 15.3632C6.89147 15.4877 7.05688 15.5565 7.233 15.5566H7.23352C7.40944 15.5566 7.57485 15.4881 7.69927 15.3639L14.8083 8.26241C15.2901 7.7812 15.5555 7.14098 15.5555 6.46006V1.97754C15.5555 1.61406 15.2598 1.31836 14.8963 1.31836H10.4ZM12.0947 6.69067C11.0042 6.69067 10.1171 5.80367 10.1171 4.71313C10.1171 3.6226 11.0042 2.7356 12.0947 2.7356C13.1851 2.7356 14.0722 3.6226 14.0722 4.71313C14.0722 5.80367 13.1851 6.69067 12.0947 6.69067ZM12.0947 4.05396C11.7312 4.05396 11.4355 4.34966 11.4355 4.71313C11.4355 5.07661 11.7312 5.37231 12.0947 5.37231C12.4582 5.37231 12.7538 5.07661 12.7538 4.71313C12.7538 4.34966 12.4582 4.05396 12.0947 4.05396Z"
                            fill="#34FF67"
                          />
                        </svg>
                        <span>Location</span>
                      </div>
                      <span>New York, USA</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- cards end -->

          <a href="#" class="btn-dark-green">VIEW ALL</a>
        </div>
      </div>
    </section>

    <!-- Key Features & Benefits -->
    <section class="features">
      <div class="container">
        <div class="inner-features">
          <span class="sub-heading">FEATURES AND BENEFITS</span>
          <h2 class="text-h2">Key Features & Benefits</h2>
          <div class="key-feature">
            <div class="box-area">
              <!-- single box start -->
              <div class="single-icon-box">
                <svg
                  width="48"
                  height="48"
                  viewBox="0 0 48 48"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M16 29C17.1046 29 18 28.1046 18 27C18 25.8954 17.1046 25 16 25C14.8954 25 14 25.8954 14 27C14 28.1046 14.8954 29 16 29Z"
                    fill="#0F2F2C"
                  />
                  <path
                    d="M16 37C17.1046 37 18 36.1046 18 35C18 33.8954 17.1046 33 16 33C14.8954 33 14 33.8954 14 35C14 36.1046 14.8954 37 16 37Z"
                    fill="#0F2F2C"
                  />
                  <path
                    d="M24 29C25.1046 29 26 28.1046 26 27C26 25.8954 25.1046 25 24 25C22.8954 25 22 25.8954 22 27C22 28.1046 22.8954 29 24 29Z"
                    fill="#0F2F2C"
                  />
                  <path
                    d="M24 37C25.1046 37 26 36.1046 26 35C26 33.8954 25.1046 33 24 33C22.8954 33 22 33.8954 22 35C22 36.1046 22.8954 37 24 37Z"
                    fill="#0F2F2C"
                  />
                  <path
                    d="M32 29C33.1046 29 34 28.1046 34 27C34 25.8954 33.1046 25 32 25C30.8954 25 30 25.8954 30 27C30 28.1046 30.8954 29 32 29Z"
                    fill="#0F2F2C"
                  />
                  <path
                    d="M32 37C33.1046 37 34 36.1046 34 35C34 33.8954 33.1046 33 32 33C30.8954 33 30 33.8954 30 35C30 36.1046 30.8954 37 32 37Z"
                    fill="#0F2F2C"
                  />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M45.5 13V39C45.5 40.99 44.71 42.896 43.304 44.304C41.896 45.71 39.99 46.5 38 46.5H10C8.01 46.5 6.104 45.71 4.696 44.304C3.29 42.896 2.5 40.99 2.5 39V13C2.5 11.01 3.29 9.104 4.696 7.696C6.104 6.29 8.01 5.5 10 5.5H38C39.99 5.5 41.896 6.29 43.304 7.696C44.71 9.104 45.5 11.01 45.5 13ZM42.5 13C42.5 11.806 42.026 10.662 41.182 9.818C40.338 8.974 39.194 8.5 38 8.5H10C8.806 8.5 7.662 8.974 6.818 9.818C5.974 10.662 5.5 11.806 5.5 13V39C5.5 40.194 5.974 41.338 6.818 42.182C7.662 43.026 8.806 43.5 10 43.5H38C39.194 43.5 40.338 43.026 41.182 42.182C42.026 41.338 42.5 40.194 42.5 39V13Z"
                    fill="#0F2F2C"
                  />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M44 16.5C44.828 16.5 45.5 17.172 45.5 18C45.5 18.828 44.828 19.5 44 19.5H4C3.172 19.5 2.5 18.828 2.5 18C2.5 17.172 3.172 16.5 4 16.5H44Z"
                    fill="#0F2F2C"
                  />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M30.5 3C30.5 2.172 31.172 1.5 32 1.5C32.828 1.5 33.5 2.172 33.5 3V11C33.5 11.828 32.828 12.5 32 12.5C31.172 12.5 30.5 11.828 30.5 11V3Z"
                    fill="#0F2F2C"
                  />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M14.5 3C14.5 2.172 15.172 1.5 16 1.5C16.828 1.5 17.5 2.172 17.5 3V11C17.5 11.828 16.828 12.5 16 12.5C15.172 12.5 14.5 11.828 14.5 11V3Z"
                    fill="#0F2F2C"
                  />
                </svg>
                <h3 class="text-h3 text-gray-black">
                  Real-time availability & scheduling
                </h3>
                <p class="text-para">
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ip sum has been the industry's
                  standard Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry.
                </p>
              </div>
              <!-- single box end -->
              <!-- single box start -->
              <div class="single-icon-box">
                <svg
                  width="48"
                  height="48"
                  viewBox="0 0 48 48"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g clip-path="url(#clip0_2869_75)">
                    <path
                      d="M32.6661 7.98046H27.9526C28.1194 5.90849 27.4137 3.77886 25.8323 2.1973C22.9708 -0.663949 18.3151 -0.663949 15.4537 2.1973L13.9909 3.66008L12.5281 2.1973C9.66666 -0.664137 5.01084 -0.664043 2.1495 2.19739C0.763406 3.58339 0 5.42643 0 7.38664C0 9.34686 0.763312 11.1898 2.1495 12.5759L5.69616 16.1226C4.52306 18.3287 3.90666 20.7919 3.90666 23.3144C3.90666 31.7696 10.7855 38.6483 19.2407 38.6483H21.5323L31.5255 47.9488V38.6483H32.6661C41.1213 38.6483 48 31.7695 48 23.3144C48 14.8593 41.1212 7.98046 32.6661 7.98046ZM4.13991 4.18771C5.02191 3.30571 6.18019 2.8648 7.33875 2.8648C8.49703 2.8648 9.65578 3.30589 10.5376 4.18771L13.9908 7.64089L17.444 4.18771C19.2079 2.42399 22.0777 2.42389 23.8417 4.1878C24.6962 5.04224 25.1667 6.17821 25.1667 7.38664C25.1667 8.59499 24.6962 9.73105 23.8417 10.5855L13.9909 20.4365L4.13991 10.5855C2.37609 8.82158 2.37609 5.95161 4.13991 4.18771ZM32.6661 35.8335H28.7106V41.4838L22.6396 35.8335H19.2407C12.3376 35.8335 6.72159 30.2175 6.72159 23.3144C6.72159 21.5482 7.09144 19.8184 7.79991 18.2262L13.991 24.4173L25.8323 12.5759C26.3704 12.0379 26.8071 11.4364 27.1428 10.7953H32.6662C39.5692 10.7953 45.1852 16.4113 45.1852 23.3144C45.1852 30.2175 39.5691 35.8335 32.6661 35.8335Z"
                      fill="#0F2F2C"
                    />
                    <path
                      d="M18.2764 22.5139H21.2513V25.3289H18.2764V22.5139Z"
                      fill="#0F2F2C"
                    />
                    <path
                      d="M24.8447 22.5139H27.8197V25.3289H24.8447V22.5139Z"
                      fill="#0F2F2C"
                    />
                    <path
                      d="M31.4131 22.5139H34.3881V25.3289H31.4131V22.5139Z"
                      fill="#0F2F2C"
                    />
                  </g>
                  <defs>
                    <clipPath id="clip0_2869_75">
                      <rect width="48" height="48" fill="white" />
                    </clipPath>
                  </defs>
                </svg>
                <h3 class="text-h3 text-gray-black">
                  Verified companies and reviews
                </h3>
                <p class="text-para">
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ip sum has been the industry's
                  standard Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry.
                </p>
              </div>
              <!-- single box end -->
              <!-- single box start -->
              <div class="single-icon-box">
                <svg
                  width="48"
                  height="48"
                  viewBox="0 0 48 48"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M2.5 12C2.5 8.96244 4.96244 6.5 8 6.5H40C43.0376 6.5 45.5 8.96244 45.5 12V32C45.5 35.0376 43.0376 37.5 40 37.5H28.427L29.927 40.5H34C34.8284 40.5 35.5 41.1716 35.5 42C35.5 42.8284 34.8284 43.5 34 43.5H14C13.1716 43.5 12.5 42.8284 12.5 42C12.5 41.1716 13.1716 40.5 14 40.5H18.0729L19.5729 37.5H8C4.96244 37.5 2.5 35.0376 2.5 32V12ZM40 34.5H8C6.61928 34.5 5.5 33.3808 5.5 32V12C5.5 10.6193 6.61928 9.5 8 9.5H40C41.3808 9.5 42.5 10.6193 42.5 12V32C42.5 33.3808 41.3808 34.5 40 34.5Z"
                    fill="#0F2F2C"
                  />
                </svg>
                <h3 class="text-h3 text-gray-black">
                  Centralized dashboard for tracking
                </h3>
                <p class="text-para">
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ip sum has been the industry's
                  standard Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry.
                </p>
              </div>
              <!-- single box end -->
              <!-- single box start -->
              <div class="single-icon-box">
                <svg
                  width="48"
                  height="48"
                  viewBox="0 0 48 48"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M47.9999 16.2711C47.9999 12.7358 46.6232 9.41209 44.1233 6.91225C41.6235 4.41241 38.2998 3.03564 34.7645 3.03564C31.2292 3.03564 27.9055 4.41241 25.4057 6.91225L23.9982 8.31967L22.588 6.90953C17.4275 1.74897 9.03081 1.74907 3.87035 6.90953C-1.29012 12.07 -1.29012 20.4667 3.87035 25.6272L5.28049 27.0373L5.2353 27.0825C4.41121 27.9065 3.95744 29.0021 3.95744 30.1674C3.95744 31.3326 4.41121 32.4282 5.23652 33.2535C6.06052 34.0775 7.15612 34.5313 8.32138 34.5313C8.52604 34.5313 8.72855 34.5172 8.92787 34.4897C9.08875 35.3111 9.48664 36.0947 10.1216 36.7298L10.1333 36.7414C10.956 37.5589 12.0474 38.009 13.2078 38.009C13.4125 38.009 13.615 37.9949 13.8143 37.9674C13.9752 38.7887 14.3731 39.5724 15.008 40.2075L15.0185 40.2178C15.8414 41.0361 16.9332 41.4866 18.0942 41.4866C18.298 41.4866 18.4996 41.4726 18.6981 41.4453C18.8628 42.2886 19.2737 43.0643 19.8958 43.6863C20.7198 44.5104 21.8154 44.9642 22.9806 44.9642C24.1459 44.9642 25.2415 44.5104 26.0655 43.6864L27.0836 42.6684C27.5466 42.2053 27.8835 41.6632 28.0944 41.0851C28.6684 41.3467 29.2879 41.4775 29.9075 41.4775C31.0249 41.4774 32.1428 41.0519 32.9938 40.2009C33.629 39.5657 34.027 38.7818 34.1878 37.9602C34.387 37.9877 34.5896 38.0017 34.7942 38.0017H34.7944C35.9599 38.0017 37.0557 37.5478 37.8802 36.7234C38.5154 36.0881 38.9135 35.3042 39.0742 34.4827C39.2735 34.5101 39.476 34.5242 39.6806 34.5242H39.6807C40.8462 34.5242 41.9421 34.0703 42.7662 33.2462L42.8025 33.2094C43.6037 32.3896 44.0444 31.309 44.0445 30.1607C44.0445 28.9953 43.5906 27.8996 42.7665 27.0756L42.7221 27.0311L44.1232 25.6301C46.6232 23.1301 47.9999 19.8064 47.9999 16.2711ZM27.3945 8.90104C29.3631 6.93241 31.9805 5.84824 34.7645 5.84824C37.5485 5.84824 40.166 6.93241 42.1346 8.90104C44.1033 10.8697 45.1874 13.4871 45.1874 16.2711C45.1874 19.0551 44.1033 21.6725 42.1346 23.641L40.7271 25.0485L28.6391 12.9606L23.8917 17.7081C23.5375 18.0623 23.0666 18.2573 22.5656 18.2573C22.0647 18.2573 21.5938 18.0622 21.2396 17.7081C20.8854 17.3539 20.6903 16.883 20.6903 16.3821C20.6903 15.8812 20.8854 15.4102 21.2396 15.0559L27.3945 8.90104ZM9.41754 31.2648C9.12475 31.5576 8.73549 31.7188 8.32147 31.7188C7.90746 31.7188 7.51819 31.5576 7.22409 31.2635C6.9313 30.9708 6.77004 30.5815 6.77004 30.1675C6.77004 29.7535 6.9313 29.3642 7.22409 29.0714L10.3554 25.9401C10.6481 25.6473 11.0374 25.4861 11.4514 25.4861C11.8654 25.4861 12.2547 25.6473 12.5488 25.9414C13.1474 26.54 13.1531 27.5106 12.5658 28.1162C12.5601 28.1219 12.5543 28.1275 12.5486 28.1332L9.41754 31.2648ZM14.3039 34.7424C14.0111 35.0351 13.6219 35.1964 13.2079 35.1964C12.7938 35.1964 12.4046 35.0351 12.1118 34.7424L12.1059 34.7364C11.5134 34.1389 11.5078 33.1753 12.089 32.5708L14.5377 30.1222C14.5431 30.1168 14.5484 30.1113 14.5537 30.1059C14.8445 29.8232 15.2271 29.6679 15.6335 29.6679C16.0475 29.6679 16.4368 29.8291 16.7309 30.1231C17.3298 30.722 17.3351 31.6933 16.747 32.299C16.7415 32.3043 16.7361 32.3096 16.7307 32.3151L14.3039 34.7424ZM19.1903 38.2199C18.8975 38.5127 18.5083 38.674 18.0942 38.674C17.6802 38.674 17.2909 38.5127 16.9982 38.2199L16.9926 38.2144C16.3994 37.6166 16.3941 36.6521 16.9762 36.0476L18.7197 34.3042C18.7251 34.2988 18.7304 34.2934 18.7358 34.2879C19.0266 34.0054 19.4091 33.85 19.8155 33.85C20.2295 33.85 20.6188 34.0113 20.9115 34.3041L20.9177 34.3102C21.5121 34.9098 21.5156 35.8781 20.928 36.482C20.9229 36.4871 20.9177 36.4922 20.9126 36.4972L19.1903 38.2199ZM25.0949 40.6795L24.0768 41.6975C23.784 41.9903 23.3948 42.1516 22.9807 42.1516C22.5667 42.1516 22.1775 41.9903 21.8834 41.6963C21.5906 41.4035 21.4293 41.0143 21.4293 40.6002C21.4293 40.1966 21.5825 39.8167 21.8614 39.5266L22.9016 38.4864C22.907 38.4809 22.9123 38.4755 22.9176 38.4701C23.2085 38.1874 23.591 38.0321 23.9974 38.0321C24.4114 38.0321 24.8007 38.1933 25.0934 38.4861L25.0993 38.492C25.6992 39.0967 25.6976 40.0766 25.0949 40.6795ZM35.4531 28.1258L33.4642 30.1146L35.9058 32.5563C36.4959 33.162 36.4911 34.1347 35.8911 34.7348C35.5981 35.0277 35.2087 35.189 34.7944 35.189C34.3801 35.189 33.9907 35.0276 33.6977 34.7346L31.2716 32.3084L29.2828 34.2972L31.0154 36.0299C31.6094 36.6352 31.6059 37.611 31.0042 38.2127C30.3996 38.8173 29.4161 38.8172 28.8115 38.2127L27.089 36.4902L27.0822 36.497L27.072 36.487C26.291 35.7108 25.2679 35.266 24.1735 35.2228C24.1306 34.1659 23.7067 33.1216 22.9014 32.3164L22.89 32.305C22.1088 31.5289 21.0858 31.084 19.9912 31.0409C19.9482 29.9837 19.524 28.939 18.7182 28.1332C17.9358 27.3508 16.9085 26.9022 15.8093 26.8589C15.7662 25.8018 15.342 24.7571 14.5361 23.9513C13.7121 23.1273 12.6165 22.6735 11.4512 22.6735C10.2859 22.6735 9.19038 23.1273 8.36638 23.9513L7.269 25.0486L5.85885 23.6385C1.79502 19.5747 1.79502 12.9622 5.85885 8.89832C9.92268 4.83449 16.535 4.8344 20.5989 8.89832L22.0091 10.3086L19.2505 13.0672C17.4227 14.895 17.4227 17.869 19.2505 19.6968C20.1359 20.5822 21.3131 21.0699 22.5653 21.0699C23.8175 21.0699 24.9947 20.5823 25.8801 19.6968L28.6387 16.9382L40.7267 29.0261L40.7331 29.0197L40.7776 29.0643C41.0705 29.3571 41.2318 29.7464 41.2318 30.1605C41.2318 30.5746 41.0705 30.964 40.7776 31.2569L40.7707 31.2638C40.4785 31.5527 40.0917 31.7115 39.6806 31.7115C39.2663 31.7115 38.8769 31.5501 38.5839 31.2572L35.4531 28.1258Z"
                    fill="#0F2F2C"
                  />
                </svg>
                <h3 class="text-h3 text-gray-black">
                  Secure contracts and bookings
                </h3>
                <p class="text-para">
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ip sum has been the industry's
                  standard Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry.
                </p>
              </div>
              <!-- single box end -->
            </div>
            <div class="img-area">
              <img
                src="<?= base_url()?>assets/website/img/441a5e4f71245e172857574814944e65401bdec4.webp"
                alt="img"
              />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- POPULAR CATEGORIES -->
    <section class="popular">
      <div class="container overflow-hide">
        <div class="inner-popular">
          <span class="sub-heading">POPULAR CATEGORIES</span>
          <h2 class="text-h2">Explore Popular Categories</h2>
          <div class="para-btn">
            <p class="text-para">
              Lorem Ipsum is simply dummy text of the printing and typesetting
              industry. Lorem Ip sum has been the industry's standard Lorem
              Ipsum.
            </p>
            <a href="#" class="btn-dark-green">GET A QUOTE</a>
          </div>
          <!-- slider section -->
          <div class="bg-slider">
            <div class="swiper categorySwiper">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <!-- single slide  start-->
                  <div class="single-slide-box">
                    <div>
                      <svg
                        width="64"
                        height="64"
                        viewBox="0 0 64 64"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <foreignObject x="-22" y="-22" width="108" height="108"
                          ><div
                            xmlns="http://www.w3.org/1999/xhtml"
                            style="
                              backdrop-filter: blur(11px);
                              clip-path: url(#bgblur_0_2869_123_clip_path);
                              height: 100%;
                              width: 100%;
                            "
                          ></div
                        ></foreignObject>
                        <rect
                          data-figma-bg-blur-radius="22"
                          x="0.5"
                          y="0.5"
                          width="63"
                          height="63"
                          rx="15.5"
                          fill="white"
                          fill-opacity="0.15"
                          stroke="white"
                        />
                        <g clip-path="url(#clip1_2869_123)">
                          <path
                            d="M18.0889 20.5685L19.9563 23.8362C20.0193 23.9467 20.1247 24.0265 20.248 24.0575L21.9902 24.493L27.9654 30.4683L28.6257 29.8082L22.5569 23.7396C22.4972 23.6797 22.4223 23.6373 22.3403 23.6167L20.6663 23.1968L19.0764 20.413L20.4395 19.0499L23.2244 20.6413L23.6446 22.3153C23.6649 22.3975 23.7076 22.4726 23.7673 22.5323L29.8361 28.6011L30.4961 27.9409L24.5209 21.9656L24.0853 20.2244C24.0544 20.1009 23.9745 19.9953 23.8641 19.9321L20.5962 18.0649C20.4139 17.9612 20.1846 17.9919 20.036 18.14L18.1688 20.0074C18.0186 20.1551 17.986 20.3847 18.0889 20.5685Z"
                            fill="white"
                          />
                          <path
                            d="M37.4966 27.2006L27.2266 37.4707L26.5664 36.8105L36.8366 26.5405L37.4966 27.2006Z"
                            fill="white"
                          />
                          <path
                            d="M25.4296 37.8338C25.3451 37.6933 25.1934 37.6074 25.0294 37.6074H22.2286C22.0648 37.6074 21.9129 37.6933 21.8285 37.8338L20.428 40.1679C20.3391 40.3157 20.3391 40.5007 20.428 40.6487L21.8285 42.9828C21.9129 43.1231 22.0648 43.2092 22.2286 43.2092H25.0294C25.1934 43.2092 25.3451 43.1231 25.4296 42.9828L26.83 40.6487C26.9189 40.5007 26.9189 40.3157 26.83 40.1679L25.4296 37.8338ZM24.7654 42.2755H22.4928L21.3725 40.4083L22.4928 38.5409H24.7654L25.8857 40.4083L24.7654 42.2755Z"
                            fill="white"
                          />
                          <path
                            d="M40.4347 29.2046C43.5179 29.215 46.0259 26.7239 46.0363 23.6407C46.0378 23.1714 45.9802 22.704 45.8648 22.249C45.8026 21.9988 45.5493 21.8465 45.299 21.9087C45.2168 21.9293 45.1419 21.9717 45.082 22.0314L42.1761 24.9354L39.8705 24.1671L39.1016 21.8621L42.0075 18.9556C42.1897 18.7731 42.1896 18.4776 42.0071 18.2953C41.947 18.2352 41.8713 18.1926 41.7886 18.1722C38.7985 17.415 35.7611 19.225 35.0039 22.2148C34.8888 22.6684 34.8314 23.1347 34.833 23.6027C34.8341 23.9703 34.872 24.3367 34.9465 24.6965L24.7229 34.9199C24.3631 34.8456 23.9967 34.8077 23.6293 34.8064C20.5354 34.8064 18.0273 37.3144 18.0273 40.4083C18.0273 43.502 20.5354 46.0101 23.6293 46.0101C26.723 46.0101 29.231 43.502 29.231 40.4083C29.2299 40.0408 29.1919 39.6743 29.1175 39.3145L31.5651 36.8669L32.6355 37.9374C32.8179 38.1196 33.1133 38.1196 33.2957 37.9374L33.529 37.7038C33.7337 37.5005 34.0646 37.5005 34.2693 37.7038C34.4739 37.9078 34.4742 38.2389 34.2703 38.4434C34.2701 38.4436 34.2697 38.444 34.2693 38.4443L34.036 38.6777C33.8538 38.8599 33.8538 39.1555 34.036 39.3377L39.6047 44.9064C41.0694 46.3845 43.4549 46.3953 44.933 44.9306C46.4109 43.4659 46.4217 41.0803 44.957 39.6023C44.9491 39.5943 44.9411 39.5862 44.933 39.5781L39.3643 34.0096C39.182 33.8274 38.8865 33.8274 38.7043 34.0096L38.4709 34.2429C38.266 34.4465 37.9353 34.4465 37.7304 34.2429C37.5261 34.039 37.5255 33.7079 37.7295 33.5036C37.7299 33.5032 37.7302 33.503 37.7304 33.5026L37.964 33.2691C38.1462 33.0869 38.1462 32.7913 37.964 32.6091L36.8935 31.5387L39.3411 29.0911C39.7009 29.1655 40.0673 29.2035 40.4347 29.2046ZM42.2689 45.0766C41.9297 45.076 41.5935 45.0147 41.276 44.8955L44.9219 41.2494C45.4721 42.713 44.7318 44.3453 43.2682 44.8955C42.9489 45.0155 42.6103 45.0769 42.2689 45.0766ZM36.9803 32.9438C36.4634 33.5604 36.5444 34.4795 37.161 34.9963C37.703 35.4505 38.4928 35.4501 39.0342 34.995L44.273 40.2384C44.3298 40.2954 44.383 40.3555 44.4345 40.4166L40.4432 44.4079C40.3819 44.3566 40.3218 44.3034 40.2648 44.2464L35.0219 39.0032C35.5389 38.3865 35.4579 37.4674 34.8412 36.9507C34.2993 36.4963 33.5092 36.4969 32.9679 36.9518L32.2211 36.205L36.2333 32.1987L36.9803 32.9438ZM38.8654 28.2487L28.2754 38.8365C28.1593 38.9525 28.1126 39.1209 28.1522 39.2801C28.7926 41.7952 27.2728 44.3533 24.7575 44.9936C22.2424 45.6341 19.6842 44.1143 19.0438 41.599C18.4035 39.0838 19.9233 36.5257 22.4386 35.8852C23.1995 35.6917 23.9967 35.6917 24.7575 35.8852C24.9167 35.9242 25.0847 35.8776 25.2011 35.7622L35.7885 25.1741C35.9045 25.0582 35.9512 24.8897 35.9113 24.7307C35.2752 22.245 36.7747 19.7143 39.2604 19.0781C39.7301 18.9581 40.216 18.912 40.6999 18.9421L38.2374 21.4056C38.1124 21.5304 38.0686 21.7153 38.1245 21.883L39.058 24.6841C39.1047 24.8233 39.2141 24.9327 39.3535 24.979L42.1546 25.9127C42.3221 25.9686 42.507 25.925 42.632 25.8002L45.0945 23.3377C45.1001 23.4268 45.103 23.5149 45.103 23.6027C45.116 26.1677 43.0474 28.2577 40.4823 28.2709C40.0858 28.2729 39.6906 28.2241 39.3065 28.1258C39.1473 28.086 38.9789 28.1325 38.8629 28.2485H38.8654V28.2487Z"
                            fill="white"
                          />
                          <path
                            d="M42.1652 41.4786L41.505 42.1388L36.8369 37.4708L37.4969 36.8105L42.1652 41.4786Z"
                            fill="white"
                          />
                        </g>
                        <defs>
                          <clipPath
                            id="bgblur_0_2869_123_clip_path"
                            transform="translate(22 22)"
                          >
                            <rect
                              x="0.5"
                              y="0.5"
                              width="63"
                              height="63"
                              rx="15.5"
                            />
                          </clipPath>
                          <clipPath id="clip1_2869_123">
                            <rect
                              width="28"
                              height="28"
                              fill="white"
                              transform="translate(18 18)"
                            />
                          </clipPath>
                        </defs>
                      </svg>
                      <h3 class="text-h3">Construction Equipment</h3>
                    </div>
                    <!-- btn -->
                    <a href="#" class="single-box-btn"
                      >VIEW LISTINGS
                      <svg
                        width="22"
                        height="22"
                        viewBox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M16.0351 7.1113C16.0344 6.80758 15.9135 6.51649 15.6987 6.30173C15.4839 6.08696 15.1928 5.966 14.8891 5.96532L8.40731 5.96532C8.25682 5.96532 8.1078 5.99496 7.96876 6.05255C7.82973 6.11014 7.70339 6.19455 7.59698 6.30097C7.38207 6.51588 7.26133 6.80737 7.26133 7.1113C7.26133 7.41524 7.38207 7.70672 7.59698 7.92164C7.81189 8.13655 8.10338 8.25729 8.40731 8.25729H12.1227L6.30072 14.0793C6.08584 14.2941 5.96512 14.5856 5.96512 14.8895C5.96512 15.1934 6.08584 15.4848 6.30072 15.6997C6.51561 15.9146 6.80706 16.0353 7.11095 16.0353C7.41484 16.0353 7.70629 15.9146 7.92118 15.6997L13.7431 9.87774L13.7431 13.5931C13.7431 13.7436 13.7728 13.8926 13.8304 14.0317C13.888 14.1707 13.9724 14.297 14.0788 14.4034C14.1852 14.5099 14.3115 14.5943 14.4506 14.6519C14.5896 14.7095 14.7386 14.7391 14.8891 14.7391C15.0396 14.7391 15.1886 14.7095 15.3277 14.6519C15.4667 14.5943 15.593 14.5099 15.6995 14.4034C15.8059 14.297 15.8903 14.1707 15.9479 14.0317C16.0055 13.8926 16.0351 13.7436 16.0351 13.5931L16.0351 7.1113Z"
                          fill="#34FF67"
                        />
                      </svg>
                    </a>
                  </div>
                  <!-- single slide end -->
                </div>
                <div class="swiper-slide">
                  <!-- single slide  start-->
                  <div class="single-slide-box">
                    <div>
                      <svg
                        width="64"
                        height="64"
                        viewBox="0 0 64 64"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <foreignObject x="-22" y="-22" width="108" height="108"
                          ><div
                            xmlns="http://www.w3.org/1999/xhtml"
                            style="
                              backdrop-filter: blur(11px);
                              clip-path: url(#bgblur_0_2869_99_clip_path);
                              height: 100%;
                              width: 100%;
                            "
                          ></div
                        ></foreignObject>
                        <rect
                          data-figma-bg-blur-radius="22"
                          x="0.5"
                          y="0.5"
                          width="63"
                          height="63"
                          rx="15.5"
                          fill="white"
                          fill-opacity="0.15"
                          stroke="white"
                        />
                        <path
                          d="M34.1795 33.8809L33.0195 32.7207C32.4346 33.3056 31.4832 33.3056 30.8983 32.7207L29.7383 33.8809C30.3505 34.4931 31.1548 34.7993 31.9589 34.7993C32.763 34.7993 33.5673 34.4931 34.1795 33.8809Z"
                          fill="white"
                        />
                        <path
                          d="M44.3047 46V39.5417L36.1016 37.7616V36.4951C38.0786 35.1689 39.3828 32.9137 39.3828 30.3594V29.5391H41.0234V24.6172H39.3369C39.0105 21.704 37.0439 19.3439 34.4609 18.4219V18H29.5391V18.4219C26.9527 19.345 24.9893 21.7074 24.6631 24.6172H22.9766V29.5391H24.6172V30.3594C24.6172 32.9137 25.9214 35.1689 27.8984 36.4951V37.7473L19.6953 39.543V46H44.3047ZM42.6641 44.3594H41.0234V40.5084L42.6641 40.8645V44.3594ZM39.3828 40.1525V44.3594H33.3223L35.7946 39.3738L39.3828 40.1525ZM24.6172 26.2578H26.2578V25.4375C26.2578 23.1581 27.5643 21.1343 29.5391 20.1943V22.9219H31.1797V19.6406H32.8203V22.9219H34.4609V20.1943C36.4357 21.1341 37.7422 23.1581 37.7422 25.4375V26.2578H39.3828V27.8984H24.6172V26.2578ZM26.2578 30.3594V29.5391H37.7422V30.3594C37.7422 33.5257 35.1663 36.1016 32 36.1016C28.8337 36.1016 26.2578 33.5257 26.2578 30.3594ZM32 37.7422C32.8626 37.7422 33.6908 37.5931 34.4609 37.3199V38.3702L32 43.3331L29.5391 38.3702V37.3199C30.3092 37.5931 31.1374 37.7422 32 37.7422ZM28.199 39.361L30.6777 44.3594H24.6172V40.145L28.199 39.361ZM21.3359 40.8632L22.9766 40.5041V44.3594H21.3359V40.8632Z"
                          fill="white"
                        />
                        <defs>
                          <clipPath
                            id="bgblur_0_2869_99_clip_path"
                            transform="translate(22 22)"
                          >
                            <rect
                              x="0.5"
                              y="0.5"
                              width="63"
                              height="63"
                              rx="15.5"
                            />
                          </clipPath>
                        </defs>
                      </svg>
                      <h3 class="text-h3">Skilled Technicians</h3>
                    </div>
                    <!-- btn -->
                    <a href="#" class="single-box-btn"
                      >VIEW LISTINGS
                      <svg
                        width="22"
                        height="22"
                        viewBox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M16.0351 7.1113C16.0344 6.80758 15.9135 6.51649 15.6987 6.30173C15.4839 6.08696 15.1928 5.966 14.8891 5.96532L8.40731 5.96532C8.25682 5.96532 8.1078 5.99496 7.96876 6.05255C7.82973 6.11014 7.70339 6.19455 7.59698 6.30097C7.38207 6.51588 7.26133 6.80737 7.26133 7.1113C7.26133 7.41524 7.38207 7.70672 7.59698 7.92164C7.81189 8.13655 8.10338 8.25729 8.40731 8.25729H12.1227L6.30072 14.0793C6.08584 14.2941 5.96512 14.5856 5.96512 14.8895C5.96512 15.1934 6.08584 15.4848 6.30072 15.6997C6.51561 15.9146 6.80706 16.0353 7.11095 16.0353C7.41484 16.0353 7.70629 15.9146 7.92118 15.6997L13.7431 9.87774L13.7431 13.5931C13.7431 13.7436 13.7728 13.8926 13.8304 14.0317C13.888 14.1707 13.9724 14.297 14.0788 14.4034C14.1852 14.5099 14.3115 14.5943 14.4506 14.6519C14.5896 14.7095 14.7386 14.7391 14.8891 14.7391C15.0396 14.7391 15.1886 14.7095 15.3277 14.6519C15.4667 14.5943 15.593 14.5099 15.6995 14.4034C15.8059 14.297 15.8903 14.1707 15.9479 14.0317C16.0055 13.8926 16.0351 13.7436 16.0351 13.5931L16.0351 7.1113Z"
                          fill="#34FF67"
                        />
                      </svg>
                    </a>
                  </div>
                  <!-- single slide end -->
                </div>
                <div class="swiper-slide">
                  <!-- single slide  start-->
                  <div class="single-slide-box">
                    <div>
                      <svg
                        width="64"
                        height="64"
                        viewBox="0 0 64 64"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <foreignObject x="-22" y="-22" width="108" height="108"
                          ><div
                            xmlns="http://www.w3.org/1999/xhtml"
                            style="
                              backdrop-filter: blur(11px);
                              clip-path: url(#bgblur_0_2869_104_clip_path);
                              height: 100%;
                              width: 100%;
                            "
                          ></div
                        ></foreignObject>
                        <rect
                          data-figma-bg-blur-radius="22"
                          x="0.5"
                          y="0.5"
                          width="63"
                          height="63"
                          rx="15.5"
                          fill="white"
                          fill-opacity="0.15"
                          stroke="white"
                        />
                        <path
                          d="M47.6709 40.665L43.6709 32.665C43.5439 32.4102 43.2842 32.25 43 32.25C42.4006 32.25 41.8322 32.3735 41.3036 32.577L38.1973 29.4697C38.0566 29.3291 37.8662 29.25 37.667 29.25H33.8326L32.7393 22.873C32.6777 22.5137 32.3652 22.25 32 22.25H24C23.5859 22.25 23.25 22.5859 23.25 23V28.25H21.75V27C21.75 26.8964 21.729 26.7976 21.6909 26.7079C21.5468 25.8872 20.8613 25.25 20 25.25C19.5859 25.25 19.25 25.5859 19.25 26C19.25 26.4141 19.5859 26.75 20 26.75C20.1377 26.75 20.25 26.8623 20.25 27V28.25H17C16.5859 28.25 16.25 28.5859 16.25 29V35C16.25 35.1992 16.3291 35.3896 16.4697 35.5303L18.2849 37.3455C18.4655 39.8009 20.4991 41.75 23 41.75C24.5923 41.75 25.996 40.9559 26.8583 39.75H31.1417C32.004 40.9559 33.4077 41.75 35 41.75C36.3999 41.75 37.6472 41.1298 38.5173 40.1631C38.9572 41.0975 39.9005 41.75 41 41.75H47C47.2598 41.75 47.501 41.6152 47.6377 41.3945C47.7744 41.1729 47.7871 40.8975 47.6709 40.665ZM39.9746 33.369C39.5975 33.6838 39.2648 34.045 39 34.4608C38.1562 33.1362 36.6836 32.25 35 32.25C34.0206 32.25 33.11 32.5487 32.353 33.0586C31.99 32.8354 31.75 32.441 31.75 32C31.75 31.3105 32.3105 30.75 33 30.75H37.3564L39.9746 33.369ZM31.9675 27.25H29.999C29.3096 27.25 28.749 26.6895 28.749 26V23.75H31.3672L31.9675 27.25ZM23 40.25C21.208 40.25 19.75 38.792 19.75 37C19.75 35.208 21.208 33.75 23 33.75C24.792 33.75 26.25 35.208 26.25 37C26.25 38.792 24.792 40.25 23 40.25ZM27.5619 38.25C27.6721 37.8491 27.75 37.4354 27.75 37C27.75 34.3809 25.6191 32.25 23 32.25C20.9207 32.25 19.1683 33.6018 18.5265 35.4659L17.75 34.6895V29.75H24C24.4141 29.75 24.75 29.4141 24.75 29V23.75H27.249V26C27.249 27.5166 28.4824 28.75 29.999 28.75H32.2247L32.3265 29.3433C31.1364 29.6458 30.25 30.717 30.25 32C30.25 32.8344 30.6509 33.5867 31.2665 34.0988C30.6392 34.9038 30.25 35.9027 30.25 37C30.25 37.4354 30.3279 37.8491 30.4381 38.25H27.5619ZM35 40.25C33.208 40.25 31.75 38.792 31.75 37C31.75 35.208 33.208 33.75 35 33.75C36.792 33.75 38.25 35.208 38.25 37C38.25 38.792 36.792 40.25 35 40.25ZM41 40.25C40.3105 40.25 39.75 39.6895 39.75 39V37C39.75 35.3604 40.9707 34 42.5518 33.7812L45.7861 40.25H41Z"
                          fill="white"
                        />
                        <path
                          d="M23 37.75C23.4142 37.75 23.75 37.4142 23.75 37C23.75 36.5858 23.4142 36.25 23 36.25C22.5858 36.25 22.25 36.5858 22.25 37C22.25 37.4142 22.5858 37.75 23 37.75Z"
                          fill="white"
                        />
                        <path
                          d="M35 37.75C35.4142 37.75 35.75 37.4142 35.75 37C35.75 36.5858 35.4142 36.25 35 36.25C34.5858 36.25 34.25 36.5858 34.25 37C34.25 37.4142 34.5858 37.75 35 37.75Z"
                          fill="white"
                        />
                        <defs>
                          <clipPath
                            id="bgblur_0_2869_104_clip_path"
                            transform="translate(22 22)"
                          >
                            <rect
                              x="0.5"
                              y="0.5"
                              width="63"
                              height="63"
                              rx="15.5"
                            />
                          </clipPath>
                        </defs>
                      </svg>
                      <h3 class="text-h3">Heavy Machinery</h3>
                    </div>
                    <!-- btn -->
                    <a href="#" class="single-box-btn"
                      >VIEW LISTINGS
                      <svg
                        width="22"
                        height="22"
                        viewBox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M16.0351 7.1113C16.0344 6.80758 15.9135 6.51649 15.6987 6.30173C15.4839 6.08696 15.1928 5.966 14.8891 5.96532L8.40731 5.96532C8.25682 5.96532 8.1078 5.99496 7.96876 6.05255C7.82973 6.11014 7.70339 6.19455 7.59698 6.30097C7.38207 6.51588 7.26133 6.80737 7.26133 7.1113C7.26133 7.41524 7.38207 7.70672 7.59698 7.92164C7.81189 8.13655 8.10338 8.25729 8.40731 8.25729H12.1227L6.30072 14.0793C6.08584 14.2941 5.96512 14.5856 5.96512 14.8895C5.96512 15.1934 6.08584 15.4848 6.30072 15.6997C6.51561 15.9146 6.80706 16.0353 7.11095 16.0353C7.41484 16.0353 7.70629 15.9146 7.92118 15.6997L13.7431 9.87774L13.7431 13.5931C13.7431 13.7436 13.7728 13.8926 13.8304 14.0317C13.888 14.1707 13.9724 14.297 14.0788 14.4034C14.1852 14.5099 14.3115 14.5943 14.4506 14.6519C14.5896 14.7095 14.7386 14.7391 14.8891 14.7391C15.0396 14.7391 15.1886 14.7095 15.3277 14.6519C15.4667 14.5943 15.593 14.5099 15.6995 14.4034C15.8059 14.297 15.8903 14.1707 15.9479 14.0317C16.0055 13.8926 16.0351 13.7436 16.0351 13.5931L16.0351 7.1113Z"
                          fill="#34FF67"
                        />
                      </svg>
                    </a>
                  </div>
                  <!-- single slide end -->
                </div>
                <div class="swiper-slide">
                  <!-- single slide  start-->
                  <div class="single-slide-box">
                    <div>
                      <svg
                        width="64"
                        height="64"
                        viewBox="0 0 64 64"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <foreignObject x="-22" y="-22" width="108" height="108"
                          ><div
                            xmlns="http://www.w3.org/1999/xhtml"
                            style="
                              backdrop-filter: blur(11px);
                              clip-path: url(#bgblur_0_2869_111_clip_path);
                              height: 100%;
                              width: 100%;
                            "
                          ></div
                        ></foreignObject>
                        <rect
                          data-figma-bg-blur-radius="22"
                          x="0.5"
                          y="0.5"
                          width="63"
                          height="63"
                          rx="15.5"
                          fill="white"
                          fill-opacity="0.15"
                          stroke="white"
                        />
                        <g clip-path="url(#clip1_2869_111)">
                          <path
                            d="M46 35.2444V28.7555H43.1557C42.9188 27.9394 42.5927 27.1533 42.1814 26.4068L44.1936 24.3946L39.6054 19.8063L37.5932 21.8186C36.8467 21.4073 36.0605 21.0812 35.2444 20.8443V18H28.7555V20.8443C27.9394 21.0812 27.1533 21.4073 26.4068 21.8186L24.3946 19.8064L19.8064 24.3946L21.8186 26.4068C21.4073 27.1533 21.0812 27.9394 20.8444 28.7556H18V35.2445H20.8444C21.0812 36.0606 21.4073 36.8467 21.8186 37.5932L19.8064 39.6054L24.3947 44.1936L26.4069 42.1814C27.1533 42.5926 27.9395 42.9184 28.7555 43.1553L28.7556 45.9999H35.2465V43.1554C36.0611 42.9188 36.8466 42.593 37.5933 42.1814L39.6054 44.1936L44.1937 39.6053L42.1815 37.5931C42.5927 36.8467 42.9188 36.0606 43.1557 35.2444H46ZM33.6067 36.5203V44.3602H30.3953L30.3949 36.5203L29.9301 36.2969C28.279 35.5037 27.2122 33.8084 27.2122 31.9778C27.2122 30.493 27.891 29.1266 29.0132 28.2328V32.1068L32.0008 33.9024L34.9884 32.1068V28.2328C36.1106 29.1266 36.7894 30.493 36.7894 31.9778C36.7894 33.8083 35.7226 35.5037 34.0715 36.2969L33.6067 36.5203ZM41.8746 39.6054L39.6053 41.8747L37.8425 40.1117L37.2891 40.4586C36.6428 40.8636 35.9589 41.1906 35.2465 41.4359V37.5279C36.1203 37.0163 36.8632 36.3044 37.414 35.4464C38.0781 34.4117 38.4292 33.2124 38.4292 31.9779C38.4292 29.3804 36.8813 27.0526 34.4856 26.0478L33.3486 25.5708V31.1793L32.0008 31.9893L30.653 31.1793V25.5708L29.5159 26.0477C27.1203 27.0525 25.5723 29.3803 25.5723 31.9779C25.5723 33.2123 25.9234 34.4117 26.5876 35.4463C27.1384 36.3044 27.8812 37.0163 28.7551 37.5278L28.7553 41.4359C28.0413 41.1904 27.3567 40.8634 26.7109 40.4586L26.1574 40.1117L24.3946 41.8747L22.1253 39.6054L23.8882 37.8425L23.5413 37.2891C22.9503 36.346 22.525 35.3206 22.2773 34.2411L22.1312 33.6046H19.6398V30.3953H22.1313L22.2774 29.7588C22.5251 28.6794 22.9504 27.6539 23.5414 26.7108L23.8883 26.1574L22.1254 24.3946L24.3947 22.1253L26.1575 23.8882L26.7109 23.5413C27.654 22.9502 28.6796 22.5249 29.7589 22.2772L30.3954 22.1311V19.6398H33.6047V22.1312L34.2412 22.2773C35.3206 22.525 36.346 22.9504 37.2892 23.5414L37.8426 23.8883L39.6054 22.1254L41.8747 24.3947L40.1117 26.1575L40.4586 26.7109C41.0496 27.654 41.475 28.6795 41.7227 29.7589L41.8688 30.3954H44.3602V33.6047H41.8688L41.7227 34.2412C41.475 35.3206 41.0496 36.346 40.4586 37.2891L40.1117 37.8425L41.8746 39.6054Z"
                            fill="white"
                          />
                        </g>
                        <defs>
                          <clipPath
                            id="bgblur_0_2869_111_clip_path"
                            transform="translate(22 22)"
                          >
                            <rect
                              x="0.5"
                              y="0.5"
                              width="63"
                              height="63"
                              rx="15.5"
                            />
                          </clipPath>
                          <clipPath id="clip1_2869_111">
                            <rect
                              width="28"
                              height="28"
                              fill="white"
                              transform="translate(18 18)"
                            />
                          </clipPath>
                        </defs>
                      </svg>
                      <h3 class="text-h3">Electrical Installers</h3>
                    </div>
                    <!-- btn -->
                    <a href="#" class="single-box-btn"
                      >VIEW LISTINGS
                      <svg
                        width="22"
                        height="22"
                        viewBox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M16.0351 7.1113C16.0344 6.80758 15.9135 6.51649 15.6987 6.30173C15.4839 6.08696 15.1928 5.966 14.8891 5.96532L8.40731 5.96532C8.25682 5.96532 8.1078 5.99496 7.96876 6.05255C7.82973 6.11014 7.70339 6.19455 7.59698 6.30097C7.38207 6.51588 7.26133 6.80737 7.26133 7.1113C7.26133 7.41524 7.38207 7.70672 7.59698 7.92164C7.81189 8.13655 8.10338 8.25729 8.40731 8.25729H12.1227L6.30072 14.0793C6.08584 14.2941 5.96512 14.5856 5.96512 14.8895C5.96512 15.1934 6.08584 15.4848 6.30072 15.6997C6.51561 15.9146 6.80706 16.0353 7.11095 16.0353C7.41484 16.0353 7.70629 15.9146 7.92118 15.6997L13.7431 9.87774L13.7431 13.5931C13.7431 13.7436 13.7728 13.8926 13.8304 14.0317C13.888 14.1707 13.9724 14.297 14.0788 14.4034C14.1852 14.5099 14.3115 14.5943 14.4506 14.6519C14.5896 14.7095 14.7386 14.7391 14.8891 14.7391C15.0396 14.7391 15.1886 14.7095 15.3277 14.6519C15.4667 14.5943 15.593 14.5099 15.6995 14.4034C15.8059 14.297 15.8903 14.1707 15.9479 14.0317C16.0055 13.8926 16.0351 13.7436 16.0351 13.5931L16.0351 7.1113Z"
                          fill="#34FF67"
                        />
                      </svg>
                    </a>
                  </div>
                  <!-- single slide end -->
                </div>
                <div class="swiper-slide">
                  <!-- single slide  start-->
                  <div class="single-slide-box">
                    <div>
                      <svg
                        width="64"
                        height="64"
                        viewBox="0 0 64 64"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <foreignObject x="-22" y="-22" width="108" height="108"
                          ><div
                            xmlns="http://www.w3.org/1999/xhtml"
                            style="
                              backdrop-filter: blur(11px);
                              clip-path: url(#bgblur_0_2869_123_clip_path);
                              height: 100%;
                              width: 100%;
                            "
                          ></div
                        ></foreignObject>
                        <rect
                          data-figma-bg-blur-radius="22"
                          x="0.5"
                          y="0.5"
                          width="63"
                          height="63"
                          rx="15.5"
                          fill="white"
                          fill-opacity="0.15"
                          stroke="white"
                        />
                        <g clip-path="url(#clip1_2869_123)">
                          <path
                            d="M18.0889 20.5685L19.9563 23.8362C20.0193 23.9467 20.1247 24.0265 20.248 24.0575L21.9902 24.493L27.9654 30.4683L28.6257 29.8082L22.5569 23.7396C22.4972 23.6797 22.4223 23.6373 22.3403 23.6167L20.6663 23.1968L19.0764 20.413L20.4395 19.0499L23.2244 20.6413L23.6446 22.3153C23.6649 22.3975 23.7076 22.4726 23.7673 22.5323L29.8361 28.6011L30.4961 27.9409L24.5209 21.9656L24.0853 20.2244C24.0544 20.1009 23.9745 19.9953 23.8641 19.9321L20.5962 18.0649C20.4139 17.9612 20.1846 17.9919 20.036 18.14L18.1688 20.0074C18.0186 20.1551 17.986 20.3847 18.0889 20.5685Z"
                            fill="white"
                          />
                          <path
                            d="M37.4966 27.2006L27.2266 37.4707L26.5664 36.8105L36.8366 26.5405L37.4966 27.2006Z"
                            fill="white"
                          />
                          <path
                            d="M25.4296 37.8338C25.3451 37.6933 25.1934 37.6074 25.0294 37.6074H22.2286C22.0648 37.6074 21.9129 37.6933 21.8285 37.8338L20.428 40.1679C20.3391 40.3157 20.3391 40.5007 20.428 40.6487L21.8285 42.9828C21.9129 43.1231 22.0648 43.2092 22.2286 43.2092H25.0294C25.1934 43.2092 25.3451 43.1231 25.4296 42.9828L26.83 40.6487C26.9189 40.5007 26.9189 40.3157 26.83 40.1679L25.4296 37.8338ZM24.7654 42.2755H22.4928L21.3725 40.4083L22.4928 38.5409H24.7654L25.8857 40.4083L24.7654 42.2755Z"
                            fill="white"
                          />
                          <path
                            d="M40.4347 29.2046C43.5179 29.215 46.0259 26.7239 46.0363 23.6407C46.0378 23.1714 45.9802 22.704 45.8648 22.249C45.8026 21.9988 45.5493 21.8465 45.299 21.9087C45.2168 21.9293 45.1419 21.9717 45.082 22.0314L42.1761 24.9354L39.8705 24.1671L39.1016 21.8621L42.0075 18.9556C42.1897 18.7731 42.1896 18.4776 42.0071 18.2953C41.947 18.2352 41.8713 18.1926 41.7886 18.1722C38.7985 17.415 35.7611 19.225 35.0039 22.2148C34.8888 22.6684 34.8314 23.1347 34.833 23.6027C34.8341 23.9703 34.872 24.3367 34.9465 24.6965L24.7229 34.9199C24.3631 34.8456 23.9967 34.8077 23.6293 34.8064C20.5354 34.8064 18.0273 37.3144 18.0273 40.4083C18.0273 43.502 20.5354 46.0101 23.6293 46.0101C26.723 46.0101 29.231 43.502 29.231 40.4083C29.2299 40.0408 29.1919 39.6743 29.1175 39.3145L31.5651 36.8669L32.6355 37.9374C32.8179 38.1196 33.1133 38.1196 33.2957 37.9374L33.529 37.7038C33.7337 37.5005 34.0646 37.5005 34.2693 37.7038C34.4739 37.9078 34.4742 38.2389 34.2703 38.4434C34.2701 38.4436 34.2697 38.444 34.2693 38.4443L34.036 38.6777C33.8538 38.8599 33.8538 39.1555 34.036 39.3377L39.6047 44.9064C41.0694 46.3845 43.4549 46.3953 44.933 44.9306C46.4109 43.4659 46.4217 41.0803 44.957 39.6023C44.9491 39.5943 44.9411 39.5862 44.933 39.5781L39.3643 34.0096C39.182 33.8274 38.8865 33.8274 38.7043 34.0096L38.4709 34.2429C38.266 34.4465 37.9353 34.4465 37.7304 34.2429C37.5261 34.039 37.5255 33.7079 37.7295 33.5036C37.7299 33.5032 37.7302 33.503 37.7304 33.5026L37.964 33.2691C38.1462 33.0869 38.1462 32.7913 37.964 32.6091L36.8935 31.5387L39.3411 29.0911C39.7009 29.1655 40.0673 29.2035 40.4347 29.2046ZM42.2689 45.0766C41.9297 45.076 41.5935 45.0147 41.276 44.8955L44.9219 41.2494C45.4721 42.713 44.7318 44.3453 43.2682 44.8955C42.9489 45.0155 42.6103 45.0769 42.2689 45.0766ZM36.9803 32.9438C36.4634 33.5604 36.5444 34.4795 37.161 34.9963C37.703 35.4505 38.4928 35.4501 39.0342 34.995L44.273 40.2384C44.3298 40.2954 44.383 40.3555 44.4345 40.4166L40.4432 44.4079C40.3819 44.3566 40.3218 44.3034 40.2648 44.2464L35.0219 39.0032C35.5389 38.3865 35.4579 37.4674 34.8412 36.9507C34.2993 36.4963 33.5092 36.4969 32.9679 36.9518L32.2211 36.205L36.2333 32.1987L36.9803 32.9438ZM38.8654 28.2487L28.2754 38.8365C28.1593 38.9525 28.1126 39.1209 28.1522 39.2801C28.7926 41.7952 27.2728 44.3533 24.7575 44.9936C22.2424 45.6341 19.6842 44.1143 19.0438 41.599C18.4035 39.0838 19.9233 36.5257 22.4386 35.8852C23.1995 35.6917 23.9967 35.6917 24.7575 35.8852C24.9167 35.9242 25.0847 35.8776 25.2011 35.7622L35.7885 25.1741C35.9045 25.0582 35.9512 24.8897 35.9113 24.7307C35.2752 22.245 36.7747 19.7143 39.2604 19.0781C39.7301 18.9581 40.216 18.912 40.6999 18.9421L38.2374 21.4056C38.1124 21.5304 38.0686 21.7153 38.1245 21.883L39.058 24.6841C39.1047 24.8233 39.2141 24.9327 39.3535 24.979L42.1546 25.9127C42.3221 25.9686 42.507 25.925 42.632 25.8002L45.0945 23.3377C45.1001 23.4268 45.103 23.5149 45.103 23.6027C45.116 26.1677 43.0474 28.2577 40.4823 28.2709C40.0858 28.2729 39.6906 28.2241 39.3065 28.1258C39.1473 28.086 38.9789 28.1325 38.8629 28.2485H38.8654V28.2487Z"
                            fill="white"
                          />
                          <path
                            d="M42.1652 41.4786L41.505 42.1388L36.8369 37.4708L37.4969 36.8105L42.1652 41.4786Z"
                            fill="white"
                          />
                        </g>
                        <defs>
                          <clipPath
                            id="bgblur_0_2869_123_clip_path"
                            transform="translate(22 22)"
                          >
                            <rect
                              x="0.5"
                              y="0.5"
                              width="63"
                              height="63"
                              rx="15.5"
                            />
                          </clipPath>
                          <clipPath id="clip1_2869_123">
                            <rect
                              width="28"
                              height="28"
                              fill="white"
                              transform="translate(18 18)"
                            />
                          </clipPath>
                        </defs>
                      </svg>
                      <h3 class="text-h3">Construction Equipment</h3>
                    </div>
                    <!-- btn -->
                    <a href="#" class="single-box-btn"
                      >VIEW LISTINGS
                      <svg
                        width="22"
                        height="22"
                        viewBox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M16.0351 7.1113C16.0344 6.80758 15.9135 6.51649 15.6987 6.30173C15.4839 6.08696 15.1928 5.966 14.8891 5.96532L8.40731 5.96532C8.25682 5.96532 8.1078 5.99496 7.96876 6.05255C7.82973 6.11014 7.70339 6.19455 7.59698 6.30097C7.38207 6.51588 7.26133 6.80737 7.26133 7.1113C7.26133 7.41524 7.38207 7.70672 7.59698 7.92164C7.81189 8.13655 8.10338 8.25729 8.40731 8.25729H12.1227L6.30072 14.0793C6.08584 14.2941 5.96512 14.5856 5.96512 14.8895C5.96512 15.1934 6.08584 15.4848 6.30072 15.6997C6.51561 15.9146 6.80706 16.0353 7.11095 16.0353C7.41484 16.0353 7.70629 15.9146 7.92118 15.6997L13.7431 9.87774L13.7431 13.5931C13.7431 13.7436 13.7728 13.8926 13.8304 14.0317C13.888 14.1707 13.9724 14.297 14.0788 14.4034C14.1852 14.5099 14.3115 14.5943 14.4506 14.6519C14.5896 14.7095 14.7386 14.7391 14.8891 14.7391C15.0396 14.7391 15.1886 14.7095 15.3277 14.6519C15.4667 14.5943 15.593 14.5099 15.6995 14.4034C15.8059 14.297 15.8903 14.1707 15.9479 14.0317C16.0055 13.8926 16.0351 13.7436 16.0351 13.5931L16.0351 7.1113Z"
                          fill="#34FF67"
                        />
                      </svg>
                    </a>
                  </div>
                  <!-- single slide end -->
                </div>
                <div class="swiper-slide">
                  <!-- single slide  start-->
                  <div class="single-slide-box">
                    <div>
                      <svg
                        width="64"
                        height="64"
                        viewBox="0 0 64 64"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <foreignObject x="-22" y="-22" width="108" height="108"
                          ><div
                            xmlns="http://www.w3.org/1999/xhtml"
                            style="
                              backdrop-filter: blur(11px);
                              clip-path: url(#bgblur_0_2869_99_clip_path);
                              height: 100%;
                              width: 100%;
                            "
                          ></div
                        ></foreignObject>
                        <rect
                          data-figma-bg-blur-radius="22"
                          x="0.5"
                          y="0.5"
                          width="63"
                          height="63"
                          rx="15.5"
                          fill="white"
                          fill-opacity="0.15"
                          stroke="white"
                        />
                        <path
                          d="M34.1795 33.8809L33.0195 32.7207C32.4346 33.3056 31.4832 33.3056 30.8983 32.7207L29.7383 33.8809C30.3505 34.4931 31.1548 34.7993 31.9589 34.7993C32.763 34.7993 33.5673 34.4931 34.1795 33.8809Z"
                          fill="white"
                        />
                        <path
                          d="M44.3047 46V39.5417L36.1016 37.7616V36.4951C38.0786 35.1689 39.3828 32.9137 39.3828 30.3594V29.5391H41.0234V24.6172H39.3369C39.0105 21.704 37.0439 19.3439 34.4609 18.4219V18H29.5391V18.4219C26.9527 19.345 24.9893 21.7074 24.6631 24.6172H22.9766V29.5391H24.6172V30.3594C24.6172 32.9137 25.9214 35.1689 27.8984 36.4951V37.7473L19.6953 39.543V46H44.3047ZM42.6641 44.3594H41.0234V40.5084L42.6641 40.8645V44.3594ZM39.3828 40.1525V44.3594H33.3223L35.7946 39.3738L39.3828 40.1525ZM24.6172 26.2578H26.2578V25.4375C26.2578 23.1581 27.5643 21.1343 29.5391 20.1943V22.9219H31.1797V19.6406H32.8203V22.9219H34.4609V20.1943C36.4357 21.1341 37.7422 23.1581 37.7422 25.4375V26.2578H39.3828V27.8984H24.6172V26.2578ZM26.2578 30.3594V29.5391H37.7422V30.3594C37.7422 33.5257 35.1663 36.1016 32 36.1016C28.8337 36.1016 26.2578 33.5257 26.2578 30.3594ZM32 37.7422C32.8626 37.7422 33.6908 37.5931 34.4609 37.3199V38.3702L32 43.3331L29.5391 38.3702V37.3199C30.3092 37.5931 31.1374 37.7422 32 37.7422ZM28.199 39.361L30.6777 44.3594H24.6172V40.145L28.199 39.361ZM21.3359 40.8632L22.9766 40.5041V44.3594H21.3359V40.8632Z"
                          fill="white"
                        />
                        <defs>
                          <clipPath
                            id="bgblur_0_2869_99_clip_path"
                            transform="translate(22 22)"
                          >
                            <rect
                              x="0.5"
                              y="0.5"
                              width="63"
                              height="63"
                              rx="15.5"
                            />
                          </clipPath>
                        </defs>
                      </svg>
                      <h3 class="text-h3">Skilled Technicians</h3>
                    </div>
                    <!-- btn -->
                    <a href="#" class="single-box-btn"
                      >VIEW LISTINGS
                      <svg
                        width="22"
                        height="22"
                        viewBox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M16.0351 7.1113C16.0344 6.80758 15.9135 6.51649 15.6987 6.30173C15.4839 6.08696 15.1928 5.966 14.8891 5.96532L8.40731 5.96532C8.25682 5.96532 8.1078 5.99496 7.96876 6.05255C7.82973 6.11014 7.70339 6.19455 7.59698 6.30097C7.38207 6.51588 7.26133 6.80737 7.26133 7.1113C7.26133 7.41524 7.38207 7.70672 7.59698 7.92164C7.81189 8.13655 8.10338 8.25729 8.40731 8.25729H12.1227L6.30072 14.0793C6.08584 14.2941 5.96512 14.5856 5.96512 14.8895C5.96512 15.1934 6.08584 15.4848 6.30072 15.6997C6.51561 15.9146 6.80706 16.0353 7.11095 16.0353C7.41484 16.0353 7.70629 15.9146 7.92118 15.6997L13.7431 9.87774L13.7431 13.5931C13.7431 13.7436 13.7728 13.8926 13.8304 14.0317C13.888 14.1707 13.9724 14.297 14.0788 14.4034C14.1852 14.5099 14.3115 14.5943 14.4506 14.6519C14.5896 14.7095 14.7386 14.7391 14.8891 14.7391C15.0396 14.7391 15.1886 14.7095 15.3277 14.6519C15.4667 14.5943 15.593 14.5099 15.6995 14.4034C15.8059 14.297 15.8903 14.1707 15.9479 14.0317C16.0055 13.8926 16.0351 13.7436 16.0351 13.5931L16.0351 7.1113Z"
                          fill="#34FF67"
                        />
                      </svg>
                    </a>
                  </div>
                  <!-- single slide end -->
                </div>
                <div class="swiper-slide">
                  <!-- single slide  start-->
                  <div class="single-slide-box">
                    <div>
                      <svg
                        width="64"
                        height="64"
                        viewBox="0 0 64 64"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <foreignObject x="-22" y="-22" width="108" height="108"
                          ><div
                            xmlns="http://www.w3.org/1999/xhtml"
                            style="
                              backdrop-filter: blur(11px);
                              clip-path: url(#bgblur_0_2869_104_clip_path);
                              height: 100%;
                              width: 100%;
                            "
                          ></div
                        ></foreignObject>
                        <rect
                          data-figma-bg-blur-radius="22"
                          x="0.5"
                          y="0.5"
                          width="63"
                          height="63"
                          rx="15.5"
                          fill="white"
                          fill-opacity="0.15"
                          stroke="white"
                        />
                        <path
                          d="M47.6709 40.665L43.6709 32.665C43.5439 32.4102 43.2842 32.25 43 32.25C42.4006 32.25 41.8322 32.3735 41.3036 32.577L38.1973 29.4697C38.0566 29.3291 37.8662 29.25 37.667 29.25H33.8326L32.7393 22.873C32.6777 22.5137 32.3652 22.25 32 22.25H24C23.5859 22.25 23.25 22.5859 23.25 23V28.25H21.75V27C21.75 26.8964 21.729 26.7976 21.6909 26.7079C21.5468 25.8872 20.8613 25.25 20 25.25C19.5859 25.25 19.25 25.5859 19.25 26C19.25 26.4141 19.5859 26.75 20 26.75C20.1377 26.75 20.25 26.8623 20.25 27V28.25H17C16.5859 28.25 16.25 28.5859 16.25 29V35C16.25 35.1992 16.3291 35.3896 16.4697 35.5303L18.2849 37.3455C18.4655 39.8009 20.4991 41.75 23 41.75C24.5923 41.75 25.996 40.9559 26.8583 39.75H31.1417C32.004 40.9559 33.4077 41.75 35 41.75C36.3999 41.75 37.6472 41.1298 38.5173 40.1631C38.9572 41.0975 39.9005 41.75 41 41.75H47C47.2598 41.75 47.501 41.6152 47.6377 41.3945C47.7744 41.1729 47.7871 40.8975 47.6709 40.665ZM39.9746 33.369C39.5975 33.6838 39.2648 34.045 39 34.4608C38.1562 33.1362 36.6836 32.25 35 32.25C34.0206 32.25 33.11 32.5487 32.353 33.0586C31.99 32.8354 31.75 32.441 31.75 32C31.75 31.3105 32.3105 30.75 33 30.75H37.3564L39.9746 33.369ZM31.9675 27.25H29.999C29.3096 27.25 28.749 26.6895 28.749 26V23.75H31.3672L31.9675 27.25ZM23 40.25C21.208 40.25 19.75 38.792 19.75 37C19.75 35.208 21.208 33.75 23 33.75C24.792 33.75 26.25 35.208 26.25 37C26.25 38.792 24.792 40.25 23 40.25ZM27.5619 38.25C27.6721 37.8491 27.75 37.4354 27.75 37C27.75 34.3809 25.6191 32.25 23 32.25C20.9207 32.25 19.1683 33.6018 18.5265 35.4659L17.75 34.6895V29.75H24C24.4141 29.75 24.75 29.4141 24.75 29V23.75H27.249V26C27.249 27.5166 28.4824 28.75 29.999 28.75H32.2247L32.3265 29.3433C31.1364 29.6458 30.25 30.717 30.25 32C30.25 32.8344 30.6509 33.5867 31.2665 34.0988C30.6392 34.9038 30.25 35.9027 30.25 37C30.25 37.4354 30.3279 37.8491 30.4381 38.25H27.5619ZM35 40.25C33.208 40.25 31.75 38.792 31.75 37C31.75 35.208 33.208 33.75 35 33.75C36.792 33.75 38.25 35.208 38.25 37C38.25 38.792 36.792 40.25 35 40.25ZM41 40.25C40.3105 40.25 39.75 39.6895 39.75 39V37C39.75 35.3604 40.9707 34 42.5518 33.7812L45.7861 40.25H41Z"
                          fill="white"
                        />
                        <path
                          d="M23 37.75C23.4142 37.75 23.75 37.4142 23.75 37C23.75 36.5858 23.4142 36.25 23 36.25C22.5858 36.25 22.25 36.5858 22.25 37C22.25 37.4142 22.5858 37.75 23 37.75Z"
                          fill="white"
                        />
                        <path
                          d="M35 37.75C35.4142 37.75 35.75 37.4142 35.75 37C35.75 36.5858 35.4142 36.25 35 36.25C34.5858 36.25 34.25 36.5858 34.25 37C34.25 37.4142 34.5858 37.75 35 37.75Z"
                          fill="white"
                        />
                        <defs>
                          <clipPath
                            id="bgblur_0_2869_104_clip_path"
                            transform="translate(22 22)"
                          >
                            <rect
                              x="0.5"
                              y="0.5"
                              width="63"
                              height="63"
                              rx="15.5"
                            />
                          </clipPath>
                        </defs>
                      </svg>
                      <h3 class="text-h3">Heavy Machinery</h3>
                    </div>
                    <!-- btn -->
                    <a href="#" class="single-box-btn"
                      >VIEW LISTINGS
                      <svg
                        width="22"
                        height="22"
                        viewBox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M16.0351 7.1113C16.0344 6.80758 15.9135 6.51649 15.6987 6.30173C15.4839 6.08696 15.1928 5.966 14.8891 5.96532L8.40731 5.96532C8.25682 5.96532 8.1078 5.99496 7.96876 6.05255C7.82973 6.11014 7.70339 6.19455 7.59698 6.30097C7.38207 6.51588 7.26133 6.80737 7.26133 7.1113C7.26133 7.41524 7.38207 7.70672 7.59698 7.92164C7.81189 8.13655 8.10338 8.25729 8.40731 8.25729H12.1227L6.30072 14.0793C6.08584 14.2941 5.96512 14.5856 5.96512 14.8895C5.96512 15.1934 6.08584 15.4848 6.30072 15.6997C6.51561 15.9146 6.80706 16.0353 7.11095 16.0353C7.41484 16.0353 7.70629 15.9146 7.92118 15.6997L13.7431 9.87774L13.7431 13.5931C13.7431 13.7436 13.7728 13.8926 13.8304 14.0317C13.888 14.1707 13.9724 14.297 14.0788 14.4034C14.1852 14.5099 14.3115 14.5943 14.4506 14.6519C14.5896 14.7095 14.7386 14.7391 14.8891 14.7391C15.0396 14.7391 15.1886 14.7095 15.3277 14.6519C15.4667 14.5943 15.593 14.5099 15.6995 14.4034C15.8059 14.297 15.8903 14.1707 15.9479 14.0317C16.0055 13.8926 16.0351 13.7436 16.0351 13.5931L16.0351 7.1113Z"
                          fill="#34FF67"
                        />
                      </svg>
                    </a>
                  </div>
                  <!-- single slide end -->
                </div>
                <div class="swiper-slide">
                  <!-- single slide  start-->
                  <div class="single-slide-box">
                    <div>
                      <svg
                        width="64"
                        height="64"
                        viewBox="0 0 64 64"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <foreignObject x="-22" y="-22" width="108" height="108"
                          ><div
                            xmlns="http://www.w3.org/1999/xhtml"
                            style="
                              backdrop-filter: blur(11px);
                              clip-path: url(#bgblur_0_2869_111_clip_path);
                              height: 100%;
                              width: 100%;
                            "
                          ></div
                        ></foreignObject>
                        <rect
                          data-figma-bg-blur-radius="22"
                          x="0.5"
                          y="0.5"
                          width="63"
                          height="63"
                          rx="15.5"
                          fill="white"
                          fill-opacity="0.15"
                          stroke="white"
                        />
                        <g clip-path="url(#clip1_2869_111)">
                          <path
                            d="M46 35.2444V28.7555H43.1557C42.9188 27.9394 42.5927 27.1533 42.1814 26.4068L44.1936 24.3946L39.6054 19.8063L37.5932 21.8186C36.8467 21.4073 36.0605 21.0812 35.2444 20.8443V18H28.7555V20.8443C27.9394 21.0812 27.1533 21.4073 26.4068 21.8186L24.3946 19.8064L19.8064 24.3946L21.8186 26.4068C21.4073 27.1533 21.0812 27.9394 20.8444 28.7556H18V35.2445H20.8444C21.0812 36.0606 21.4073 36.8467 21.8186 37.5932L19.8064 39.6054L24.3947 44.1936L26.4069 42.1814C27.1533 42.5926 27.9395 42.9184 28.7555 43.1553L28.7556 45.9999H35.2465V43.1554C36.0611 42.9188 36.8466 42.593 37.5933 42.1814L39.6054 44.1936L44.1937 39.6053L42.1815 37.5931C42.5927 36.8467 42.9188 36.0606 43.1557 35.2444H46ZM33.6067 36.5203V44.3602H30.3953L30.3949 36.5203L29.9301 36.2969C28.279 35.5037 27.2122 33.8084 27.2122 31.9778C27.2122 30.493 27.891 29.1266 29.0132 28.2328V32.1068L32.0008 33.9024L34.9884 32.1068V28.2328C36.1106 29.1266 36.7894 30.493 36.7894 31.9778C36.7894 33.8083 35.7226 35.5037 34.0715 36.2969L33.6067 36.5203ZM41.8746 39.6054L39.6053 41.8747L37.8425 40.1117L37.2891 40.4586C36.6428 40.8636 35.9589 41.1906 35.2465 41.4359V37.5279C36.1203 37.0163 36.8632 36.3044 37.414 35.4464C38.0781 34.4117 38.4292 33.2124 38.4292 31.9779C38.4292 29.3804 36.8813 27.0526 34.4856 26.0478L33.3486 25.5708V31.1793L32.0008 31.9893L30.653 31.1793V25.5708L29.5159 26.0477C27.1203 27.0525 25.5723 29.3803 25.5723 31.9779C25.5723 33.2123 25.9234 34.4117 26.5876 35.4463C27.1384 36.3044 27.8812 37.0163 28.7551 37.5278L28.7553 41.4359C28.0413 41.1904 27.3567 40.8634 26.7109 40.4586L26.1574 40.1117L24.3946 41.8747L22.1253 39.6054L23.8882 37.8425L23.5413 37.2891C22.9503 36.346 22.525 35.3206 22.2773 34.2411L22.1312 33.6046H19.6398V30.3953H22.1313L22.2774 29.7588C22.5251 28.6794 22.9504 27.6539 23.5414 26.7108L23.8883 26.1574L22.1254 24.3946L24.3947 22.1253L26.1575 23.8882L26.7109 23.5413C27.654 22.9502 28.6796 22.5249 29.7589 22.2772L30.3954 22.1311V19.6398H33.6047V22.1312L34.2412 22.2773C35.3206 22.525 36.346 22.9504 37.2892 23.5414L37.8426 23.8883L39.6054 22.1254L41.8747 24.3947L40.1117 26.1575L40.4586 26.7109C41.0496 27.654 41.475 28.6795 41.7227 29.7589L41.8688 30.3954H44.3602V33.6047H41.8688L41.7227 34.2412C41.475 35.3206 41.0496 36.346 40.4586 37.2891L40.1117 37.8425L41.8746 39.6054Z"
                            fill="white"
                          />
                        </g>
                        <defs>
                          <clipPath
                            id="bgblur_0_2869_111_clip_path"
                            transform="translate(22 22)"
                          >
                            <rect
                              x="0.5"
                              y="0.5"
                              width="63"
                              height="63"
                              rx="15.5"
                            />
                          </clipPath>
                          <clipPath id="clip1_2869_111">
                            <rect
                              width="28"
                              height="28"
                              fill="white"
                              transform="translate(18 18)"
                            />
                          </clipPath>
                        </defs>
                      </svg>
                      <h3 class="text-h3">Electrical Installers</h3>
                    </div>
                    <!-- btn -->
                    <a href="#" class="single-box-btn"
                      >VIEW LISTINGS
                      <svg
                        width="22"
                        height="22"
                        viewBox="0 0 22 22"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M16.0351 7.1113C16.0344 6.80758 15.9135 6.51649 15.6987 6.30173C15.4839 6.08696 15.1928 5.966 14.8891 5.96532L8.40731 5.96532C8.25682 5.96532 8.1078 5.99496 7.96876 6.05255C7.82973 6.11014 7.70339 6.19455 7.59698 6.30097C7.38207 6.51588 7.26133 6.80737 7.26133 7.1113C7.26133 7.41524 7.38207 7.70672 7.59698 7.92164C7.81189 8.13655 8.10338 8.25729 8.40731 8.25729H12.1227L6.30072 14.0793C6.08584 14.2941 5.96512 14.5856 5.96512 14.8895C5.96512 15.1934 6.08584 15.4848 6.30072 15.6997C6.51561 15.9146 6.80706 16.0353 7.11095 16.0353C7.41484 16.0353 7.70629 15.9146 7.92118 15.6997L13.7431 9.87774L13.7431 13.5931C13.7431 13.7436 13.7728 13.8926 13.8304 14.0317C13.888 14.1707 13.9724 14.297 14.0788 14.4034C14.1852 14.5099 14.3115 14.5943 14.4506 14.6519C14.5896 14.7095 14.7386 14.7391 14.8891 14.7391C15.0396 14.7391 15.1886 14.7095 15.3277 14.6519C15.4667 14.5943 15.593 14.5099 15.6995 14.4034C15.8059 14.297 15.8903 14.1707 15.9479 14.0317C16.0055 13.8926 16.0351 13.7436 16.0351 13.5931L16.0351 7.1113Z"
                          fill="#34FF67"
                        />
                      </svg>
                    </a>
                  </div>
                  <!-- single slide end -->
                </div>
              </div>

              <!-- Navigation buttons -->
              <div class="swiper-button-next categorySwiper-next">
                <svg
                  width="14"
                  height="12"
                  viewBox="0 0 14 12"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M0.334579 6.53965C0.1203 6.3244 2.63713e-07 6.03304 2.50436e-07 5.72932C2.3716e-07 5.42559 0.1203 5.13423 0.334579 4.91898L4.91791 0.335651C5.02433 0.229237 5.15066 0.144824 5.2897 0.0872328C5.42873 0.0296417 5.57775 -2.43811e-07 5.72824 -2.5039e-07C6.03218 -2.63675e-07 6.32366 0.120737 6.53858 0.335651C6.75349 0.550565 6.87423 0.84205 6.87423 1.14598C6.87423 1.44992 6.75349 1.7414 6.53858 1.95632L3.91141 4.58348L12.1449 4.58348C12.4488 4.58348 12.7403 4.7042 12.9551 4.91909C13.17 5.13398 13.2907 5.42542 13.2907 5.72932C13.2907 6.03321 13.17 6.32466 12.9551 6.53954C12.7403 6.75443 12.4488 6.87515 12.1449 6.87515L3.91141 6.87515L6.53858 9.50232C6.64499 9.60873 6.72941 9.73507 6.787 9.8741C6.84459 10.0131 6.87423 10.1622 6.87423 10.3127C6.87423 10.4631 6.84459 10.6122 6.787 10.7512C6.72941 10.8902 6.64499 11.0166 6.53858 11.123C6.43216 11.2294 6.30583 11.3138 6.16679 11.3714C6.02776 11.429 5.87874 11.4586 5.72825 11.4586C5.57775 11.4586 5.42873 11.429 5.2897 11.3714C5.15066 11.3138 5.02433 11.2294 4.91791 11.123L0.334579 6.53965Z"
                    fill="#34FF67"
                  ></path>
                </svg>
              </div>
              <div class="swiper-button-prev categorySwiper-prev">
                <svg
                  width="14"
                  height="12"
                  viewBox="0 0 14 12"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M0.334579 6.53965C0.1203 6.3244 2.63713e-07 6.03304 2.50436e-07 5.72932C2.3716e-07 5.42559 0.1203 5.13423 0.334579 4.91898L4.91791 0.335651C5.02433 0.229237 5.15066 0.144824 5.2897 0.0872328C5.42873 0.0296417 5.57775 -2.43811e-07 5.72824 -2.5039e-07C6.03218 -2.63675e-07 6.32366 0.120737 6.53858 0.335651C6.75349 0.550565 6.87423 0.84205 6.87423 1.14598C6.87423 1.44992 6.75349 1.7414 6.53858 1.95632L3.91141 4.58348L12.1449 4.58348C12.4488 4.58348 12.7403 4.7042 12.9551 4.91909C13.17 5.13398 13.2907 5.42542 13.2907 5.72932C13.2907 6.03321 13.17 6.32466 12.9551 6.53954C12.7403 6.75443 12.4488 6.87515 12.1449 6.87515L3.91141 6.87515L6.53858 9.50232C6.64499 9.60873 6.72941 9.73507 6.787 9.8741C6.84459 10.0131 6.87423 10.1622 6.87423 10.3127C6.87423 10.4631 6.84459 10.6122 6.787 10.7512C6.72941 10.8902 6.64499 11.0166 6.53858 11.123C6.43216 11.2294 6.30583 11.3138 6.16679 11.3714C6.02776 11.429 5.87874 11.4586 5.72825 11.4586C5.57775 11.4586 5.42873 11.429 5.2897 11.3714C5.15066 11.3138 5.02433 11.2294 4.91791 11.123L0.334579 6.53965Z"
                    fill="#34FF67"
                  ></path>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Success Metrics -->
    <section class="success">
      <div class="container overflow-hide">
        <div class="inner-success">
          <div class="mertrics">
            <h2 class="text-h2">Success Metrics</h2>
            <!-- Success Metrics multi box -->
            <div class="success-boxs">
              <!-- single box start-->
              <div class="success-single-box">
                <svg
                  width="32"
                  height="32"
                  viewBox="0 0 32 32"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g clip-path="url(#clip0_2218_3726)">
                    <path
                      d="M32 19.7079V12.292H28.7494C28.4786 11.3593 28.1059 10.4609 27.6359 9.60776L29.9356 7.3081L24.6918 2.06434L22.3922 4.36407C21.539 3.89405 20.6406 3.52136 19.7079 3.25062V0H12.292V3.25062C11.3593 3.52136 10.461 3.89405 9.60782 4.36407L7.30816 2.06441L2.06441 7.30816L4.36407 9.60782C3.89405 10.461 3.52143 11.3593 3.25069 12.2921H0V19.708H3.25069C3.52143 20.6407 3.89405 21.5391 4.36407 22.3922L2.06447 24.6918L7.30822 29.9356L9.60788 27.6359C10.461 28.1059 11.3594 28.4781 12.292 28.7489L12.2922 31.9999H19.7103V28.7491C20.6412 28.4786 21.5389 28.1063 22.3923 27.6359L24.6919 29.9355L29.9357 24.6918L27.636 22.3921C28.1059 21.539 28.4786 20.6407 28.7494 19.7079H32ZM17.8362 21.166V30.1259H14.166L14.1656 21.166L13.6344 20.9108C11.7474 20.0042 10.5282 18.0667 10.5282 15.9746C10.5282 14.2777 11.304 12.7161 12.5865 11.6947V16.1221L16.0009 18.1742L19.4154 16.1221V11.6947C20.6978 12.7161 21.4736 14.2777 21.4736 15.9746C21.4736 18.0667 20.2544 20.0042 18.3674 20.9108L17.8362 21.166ZM27.2853 24.6918L24.6918 27.2854L22.6771 25.2706L22.0447 25.667C21.3061 26.1299 20.5245 26.5036 19.7103 26.7839V22.3176C20.709 21.7329 21.5579 20.9194 22.1874 19.9387C22.9464 18.7562 23.3476 17.3856 23.3476 15.9748C23.3476 13.0061 21.5786 10.3458 18.8407 9.19746L17.5412 8.65236V15.062L16.0009 15.9878L14.4605 15.062V8.6523L13.161 9.1974C10.4232 10.3458 8.65405 13.0061 8.65405 15.9747C8.65405 17.3855 9.05529 18.7562 9.81434 19.9387C10.4438 20.9193 11.2929 21.7329 12.2915 22.3175L12.2918 26.7839C11.4758 26.5033 10.6934 26.1296 9.95527 25.667L9.32278 25.2706L7.3081 27.2854L4.71464 24.6918L6.72932 22.6771L6.33296 22.0447C5.65748 20.9669 5.17141 19.7949 4.88831 18.5613L4.72133 17.8338H1.87406V14.1661H4.72145L4.88843 13.4387C5.17154 12.205 5.65761 11.033 6.33308 9.95521L6.72945 9.32278L4.71477 7.3081L7.30822 4.71458L9.3229 6.72939L9.95534 6.33296C11.0332 5.65742 12.2052 5.17129 13.4387 4.88824L14.1662 4.72126V1.87406H17.8339V4.72139L18.5613 4.88837C19.7949 5.17141 20.9669 5.65755 22.0448 6.33308L22.6772 6.72951L24.6919 4.71471L27.2854 7.30822L25.2705 9.32284L25.6669 9.95527C26.3425 11.0332 26.8286 12.2051 27.1116 13.4387L27.2786 14.1662H30.1259V17.8339H27.2786L27.1116 18.5613C26.8285 19.7949 26.3425 20.9669 25.6669 22.0447L25.2705 22.6772L27.2853 24.6918Z"
                      fill="#585B7C"
                    />
                  </g>
                  <defs>
                    <clipPath id="clip0_2218_3726">
                      <rect width="32" height="32" fill="white" />
                    </clipPath>
                  </defs>
                </svg>
                <span>2,000+</span>
                <p class="text-para">Listed Tools</p>
              </div>
              <!-- single box end-->
              <!-- single box start-->
              <div class="success-single-box">
                <svg
                  width="32"
                  height="32"
                  viewBox="0 0 32 32"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g clip-path="url(#clip0_2218_3734)">
                    <path
                      d="M0.10136 2.93538L2.2355 6.66992C2.30749 6.79611 2.42798 6.88741 2.56888 6.92275L4.55993 7.42051L11.3888 14.2494L12.1433 13.4951L5.20759 6.55952C5.13934 6.49105 5.05374 6.44254 4.96003 6.41906L3.04689 5.93908L1.22988 2.75761L2.7877 1.1998L5.97048 3.01856L6.45068 4.9317C6.47395 5.02563 6.52267 5.11145 6.59092 5.1797L13.5267 12.1155L14.281 11.3609L7.45213 4.53204L6.95437 2.54209C6.91903 2.40097 6.82773 2.28026 6.70154 2.20805L2.96678 0.0741281C2.75851 -0.0443867 2.49646 -0.00927121 2.32659 0.159942L0.19266 2.29409C0.021033 2.46286 -0.0162772 2.72535 0.10136 2.93538Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M22.2817 10.5146L10.5446 22.2519L9.79004 21.4974L21.5274 9.76025L22.2817 10.5146Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M8.4906 22.6674C8.39403 22.5068 8.22065 22.4087 8.03322 22.4087H4.83222C4.64501 22.4087 4.47141 22.5068 4.37506 22.6674L2.77445 25.3349C2.67284 25.5039 2.67284 25.7153 2.77445 25.8845L4.37506 28.5519C4.47141 28.7124 4.64501 28.8107 4.83222 28.8107H8.03322C8.22065 28.8107 8.39403 28.7124 8.4906 28.5519L10.091 25.8845C10.1926 25.7153 10.1926 25.5039 10.091 25.3349L8.4906 22.6674ZM7.73145 27.7436H5.13422L3.85382 25.6097L5.13422 23.4755H7.73145L9.01184 25.6097L7.73145 27.7436Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M25.6397 12.8053C29.1633 12.8171 32.0296 9.97016 32.0414 6.44653C32.0432 5.91015 31.9774 5.37595 31.8455 4.85602C31.7743 4.57005 31.4849 4.39601 31.1989 4.46712C31.105 4.4906 31.0194 4.5391 30.9509 4.60736L27.6298 7.92621L24.9949 7.04811L24.1161 4.41379L27.4371 1.09208C27.6454 0.883582 27.6452 0.545814 27.4367 0.337535C27.368 0.268841 27.2815 0.220118 27.1869 0.196854C23.7698 -0.668524 20.2984 1.4 19.433 4.81696C19.3015 5.33535 19.2359 5.86823 19.2377 6.40308C19.239 6.82315 19.2822 7.2419 19.3674 7.65319L7.68336 19.337C7.27207 19.2521 6.85331 19.2088 6.43346 19.2073C2.89755 19.2073 0.03125 22.0736 0.03125 25.6095C0.03125 29.1452 2.89755 32.0115 6.43346 32.0115C9.96916 32.0115 12.8355 29.1452 12.8355 25.6095C12.8341 25.1894 12.7907 24.7707 12.7058 24.3594L15.5029 21.5622L16.7263 22.7856C16.9348 22.9938 17.2723 22.9938 17.4808 22.7856L17.7475 22.5187C17.9814 22.2863 18.3596 22.2863 18.5935 22.5187C18.8273 22.7518 18.8277 23.1301 18.5946 23.3639C18.5944 23.3641 18.594 23.3645 18.5935 23.365L18.3269 23.6316C18.1186 23.8399 18.1186 24.1777 18.3269 24.3859L24.6911 30.7502C26.365 32.4395 29.0913 32.4518 30.7806 30.7778C32.4696 29.1039 32.4819 26.3774 30.808 24.6884C30.799 24.6792 30.7898 24.6699 30.7806 24.6607L24.4163 18.2967C24.2081 18.0884 23.8703 18.0884 23.662 18.2967L23.3953 18.5634C23.1612 18.796 22.7832 18.796 22.5491 18.5634C22.3155 18.3303 22.3149 17.9519 22.548 17.7184C22.5484 17.718 22.5488 17.7177 22.5491 17.7173L22.8159 17.4504C23.0242 17.2421 23.0242 16.9044 22.8159 16.6961L21.5926 15.4728L24.3898 12.6756C24.8011 12.7605 25.2198 12.804 25.6397 12.8053ZM27.7358 30.9446C27.3483 30.944 26.964 30.874 26.6012 30.7377L30.7679 26.5708C31.3966 28.2434 30.5506 30.1089 28.878 30.7377C28.513 30.8748 28.1261 30.9451 27.7358 30.9446ZM21.6918 17.0786C21.101 17.7834 21.1936 18.8337 21.8983 19.4243C22.5177 19.9434 23.4204 19.943 24.0391 19.4228L30.0263 25.4153C30.0912 25.4805 30.152 25.5491 30.2108 25.6189L25.6493 30.1804C25.5793 30.1218 25.5106 30.061 25.4454 29.9959L19.4536 24.0036C20.0445 23.2989 19.9518 22.2485 19.2471 21.6579C18.6278 21.1386 17.7249 21.1393 17.1062 21.6592L16.2526 20.8057L20.8381 16.2271L21.6918 17.0786ZM23.8461 11.7128L11.7434 23.8131C11.6106 23.9457 11.5573 24.1382 11.6025 24.3201C12.3344 27.1945 10.5975 30.1181 7.72286 30.8498C4.84844 31.5818 1.92485 29.8449 1.19291 26.9702C0.461195 24.0958 2.1981 21.1722 5.07274 20.4403C5.94229 20.2191 6.85331 20.2191 7.72286 20.4403C7.9048 20.4848 8.09684 20.4315 8.22984 20.2996L20.3298 8.19902C20.4623 8.06646 20.5157 7.87398 20.47 7.69226C19.7431 4.85141 21.4568 1.95921 24.2976 1.2321C24.8344 1.09493 25.3897 1.04226 25.9428 1.07672L23.1285 3.8921C22.9856 4.03476 22.9356 4.24611 22.9994 4.43771L24.0663 7.63893C24.1196 7.79804 24.2447 7.92314 24.404 7.97603L27.6053 9.04311C27.7966 9.10697 28.008 9.05715 28.1509 8.9145L30.9652 6.10021C30.9715 6.20204 30.9748 6.30278 30.9748 6.40308C30.9897 9.33457 28.6256 11.7231 25.6941 11.7382C25.2409 11.7404 24.7892 11.6847 24.3503 11.5723C24.1683 11.5269 23.9759 11.58 23.8433 11.7125H23.8461V11.7128Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M27.6178 26.8325L26.8632 27.587L21.5283 22.2521L22.2826 21.4976L27.6178 26.8325Z"
                      fill="#585B7C"
                    />
                  </g>
                  <defs>
                    <clipPath id="clip0_2218_3734">
                      <rect width="32" height="32" fill="white" />
                    </clipPath>
                  </defs>
                </svg>

                <span>500+</span>
                <p class="text-para">Active Companies</p>
              </div>
              <!-- single box end-->
              <!-- single box start-->
              <div class="success-single-box">
                <svg
                  width="32"
                  height="32"
                  viewBox="0 0 32 32"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g clip-path="url(#clip0_2218_3734)">
                    <path
                      d="M0.10136 2.93538L2.2355 6.66992C2.30749 6.79611 2.42798 6.88741 2.56888 6.92275L4.55993 7.42051L11.3888 14.2494L12.1433 13.4951L5.20759 6.55952C5.13934 6.49105 5.05374 6.44254 4.96003 6.41906L3.04689 5.93908L1.22988 2.75761L2.7877 1.1998L5.97048 3.01856L6.45068 4.9317C6.47395 5.02563 6.52267 5.11145 6.59092 5.1797L13.5267 12.1155L14.281 11.3609L7.45213 4.53204L6.95437 2.54209C6.91903 2.40097 6.82773 2.28026 6.70154 2.20805L2.96678 0.0741281C2.75851 -0.0443867 2.49646 -0.00927121 2.32659 0.159942L0.19266 2.29409C0.021033 2.46286 -0.0162772 2.72535 0.10136 2.93538Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M22.2817 10.5146L10.5446 22.2519L9.79004 21.4974L21.5274 9.76025L22.2817 10.5146Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M8.4906 22.6674C8.39403 22.5068 8.22065 22.4087 8.03322 22.4087H4.83222C4.64501 22.4087 4.47141 22.5068 4.37506 22.6674L2.77445 25.3349C2.67284 25.5039 2.67284 25.7153 2.77445 25.8845L4.37506 28.5519C4.47141 28.7124 4.64501 28.8107 4.83222 28.8107H8.03322C8.22065 28.8107 8.39403 28.7124 8.4906 28.5519L10.091 25.8845C10.1926 25.7153 10.1926 25.5039 10.091 25.3349L8.4906 22.6674ZM7.73145 27.7436H5.13422L3.85382 25.6097L5.13422 23.4755H7.73145L9.01184 25.6097L7.73145 27.7436Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M25.6397 12.8053C29.1633 12.8171 32.0296 9.97016 32.0414 6.44653C32.0432 5.91015 31.9774 5.37595 31.8455 4.85602C31.7743 4.57005 31.4849 4.39601 31.1989 4.46712C31.105 4.4906 31.0194 4.5391 30.9509 4.60736L27.6298 7.92621L24.9949 7.04811L24.1161 4.41379L27.4371 1.09208C27.6454 0.883582 27.6452 0.545814 27.4367 0.337535C27.368 0.268841 27.2815 0.220118 27.1869 0.196854C23.7698 -0.668524 20.2984 1.4 19.433 4.81696C19.3015 5.33535 19.2359 5.86823 19.2377 6.40308C19.239 6.82315 19.2822 7.2419 19.3674 7.65319L7.68336 19.337C7.27207 19.2521 6.85331 19.2088 6.43346 19.2073C2.89755 19.2073 0.03125 22.0736 0.03125 25.6095C0.03125 29.1452 2.89755 32.0115 6.43346 32.0115C9.96916 32.0115 12.8355 29.1452 12.8355 25.6095C12.8341 25.1894 12.7907 24.7707 12.7058 24.3594L15.5029 21.5622L16.7263 22.7856C16.9348 22.9938 17.2723 22.9938 17.4808 22.7856L17.7475 22.5187C17.9814 22.2863 18.3596 22.2863 18.5935 22.5187C18.8273 22.7518 18.8277 23.1301 18.5946 23.3639C18.5944 23.3641 18.594 23.3645 18.5935 23.365L18.3269 23.6316C18.1186 23.8399 18.1186 24.1777 18.3269 24.3859L24.6911 30.7502C26.365 32.4395 29.0913 32.4518 30.7806 30.7778C32.4696 29.1039 32.4819 26.3774 30.808 24.6884C30.799 24.6792 30.7898 24.6699 30.7806 24.6607L24.4163 18.2967C24.2081 18.0884 23.8703 18.0884 23.662 18.2967L23.3953 18.5634C23.1612 18.796 22.7832 18.796 22.5491 18.5634C22.3155 18.3303 22.3149 17.9519 22.548 17.7184C22.5484 17.718 22.5488 17.7177 22.5491 17.7173L22.8159 17.4504C23.0242 17.2421 23.0242 16.9044 22.8159 16.6961L21.5926 15.4728L24.3898 12.6756C24.8011 12.7605 25.2198 12.804 25.6397 12.8053ZM27.7358 30.9446C27.3483 30.944 26.964 30.874 26.6012 30.7377L30.7679 26.5708C31.3966 28.2434 30.5506 30.1089 28.878 30.7377C28.513 30.8748 28.1261 30.9451 27.7358 30.9446ZM21.6918 17.0786C21.101 17.7834 21.1936 18.8337 21.8983 19.4243C22.5177 19.9434 23.4204 19.943 24.0391 19.4228L30.0263 25.4153C30.0912 25.4805 30.152 25.5491 30.2108 25.6189L25.6493 30.1804C25.5793 30.1218 25.5106 30.061 25.4454 29.9959L19.4536 24.0036C20.0445 23.2989 19.9518 22.2485 19.2471 21.6579C18.6278 21.1386 17.7249 21.1393 17.1062 21.6592L16.2526 20.8057L20.8381 16.2271L21.6918 17.0786ZM23.8461 11.7128L11.7434 23.8131C11.6106 23.9457 11.5573 24.1382 11.6025 24.3201C12.3344 27.1945 10.5975 30.1181 7.72286 30.8498C4.84844 31.5818 1.92485 29.8449 1.19291 26.9702C0.461195 24.0958 2.1981 21.1722 5.07274 20.4403C5.94229 20.2191 6.85331 20.2191 7.72286 20.4403C7.9048 20.4848 8.09684 20.4315 8.22984 20.2996L20.3298 8.19902C20.4623 8.06646 20.5157 7.87398 20.47 7.69226C19.7431 4.85141 21.4568 1.95921 24.2976 1.2321C24.8344 1.09493 25.3897 1.04226 25.9428 1.07672L23.1285 3.8921C22.9856 4.03476 22.9356 4.24611 22.9994 4.43771L24.0663 7.63893C24.1196 7.79804 24.2447 7.92314 24.404 7.97603L27.6053 9.04311C27.7966 9.10697 28.008 9.05715 28.1509 8.9145L30.9652 6.10021C30.9715 6.20204 30.9748 6.30278 30.9748 6.40308C30.9897 9.33457 28.6256 11.7231 25.6941 11.7382C25.2409 11.7404 24.7892 11.6847 24.3503 11.5723C24.1683 11.5269 23.9759 11.58 23.8433 11.7125H23.8461V11.7128Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M27.6178 26.8325L26.8632 27.587L21.5283 22.2521L22.2826 21.4976L27.6178 26.8325Z"
                      fill="#585B7C"
                    />
                  </g>
                  <defs>
                    <clipPath id="clip0_2218_3734">
                      <rect width="32" height="32" fill="white" />
                    </clipPath>
                  </defs>
                </svg>

                <span>1,200+</span>
                <p class="text-para">Workforce Members</p>
              </div>
              <!-- single box end-->
              <!-- single box start-->
              <div class="success-single-box">
                <svg
                  width="32"
                  height="32"
                  viewBox="0 0 32 32"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g clip-path="url(#clip0_2218_3734)">
                    <path
                      d="M0.10136 2.93538L2.2355 6.66992C2.30749 6.79611 2.42798 6.88741 2.56888 6.92275L4.55993 7.42051L11.3888 14.2494L12.1433 13.4951L5.20759 6.55952C5.13934 6.49105 5.05374 6.44254 4.96003 6.41906L3.04689 5.93908L1.22988 2.75761L2.7877 1.1998L5.97048 3.01856L6.45068 4.9317C6.47395 5.02563 6.52267 5.11145 6.59092 5.1797L13.5267 12.1155L14.281 11.3609L7.45213 4.53204L6.95437 2.54209C6.91903 2.40097 6.82773 2.28026 6.70154 2.20805L2.96678 0.0741281C2.75851 -0.0443867 2.49646 -0.00927121 2.32659 0.159942L0.19266 2.29409C0.021033 2.46286 -0.0162772 2.72535 0.10136 2.93538Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M22.2817 10.5146L10.5446 22.2519L9.79004 21.4974L21.5274 9.76025L22.2817 10.5146Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M8.4906 22.6674C8.39403 22.5068 8.22065 22.4087 8.03322 22.4087H4.83222C4.64501 22.4087 4.47141 22.5068 4.37506 22.6674L2.77445 25.3349C2.67284 25.5039 2.67284 25.7153 2.77445 25.8845L4.37506 28.5519C4.47141 28.7124 4.64501 28.8107 4.83222 28.8107H8.03322C8.22065 28.8107 8.39403 28.7124 8.4906 28.5519L10.091 25.8845C10.1926 25.7153 10.1926 25.5039 10.091 25.3349L8.4906 22.6674ZM7.73145 27.7436H5.13422L3.85382 25.6097L5.13422 23.4755H7.73145L9.01184 25.6097L7.73145 27.7436Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M25.6397 12.8053C29.1633 12.8171 32.0296 9.97016 32.0414 6.44653C32.0432 5.91015 31.9774 5.37595 31.8455 4.85602C31.7743 4.57005 31.4849 4.39601 31.1989 4.46712C31.105 4.4906 31.0194 4.5391 30.9509 4.60736L27.6298 7.92621L24.9949 7.04811L24.1161 4.41379L27.4371 1.09208C27.6454 0.883582 27.6452 0.545814 27.4367 0.337535C27.368 0.268841 27.2815 0.220118 27.1869 0.196854C23.7698 -0.668524 20.2984 1.4 19.433 4.81696C19.3015 5.33535 19.2359 5.86823 19.2377 6.40308C19.239 6.82315 19.2822 7.2419 19.3674 7.65319L7.68336 19.337C7.27207 19.2521 6.85331 19.2088 6.43346 19.2073C2.89755 19.2073 0.03125 22.0736 0.03125 25.6095C0.03125 29.1452 2.89755 32.0115 6.43346 32.0115C9.96916 32.0115 12.8355 29.1452 12.8355 25.6095C12.8341 25.1894 12.7907 24.7707 12.7058 24.3594L15.5029 21.5622L16.7263 22.7856C16.9348 22.9938 17.2723 22.9938 17.4808 22.7856L17.7475 22.5187C17.9814 22.2863 18.3596 22.2863 18.5935 22.5187C18.8273 22.7518 18.8277 23.1301 18.5946 23.3639C18.5944 23.3641 18.594 23.3645 18.5935 23.365L18.3269 23.6316C18.1186 23.8399 18.1186 24.1777 18.3269 24.3859L24.6911 30.7502C26.365 32.4395 29.0913 32.4518 30.7806 30.7778C32.4696 29.1039 32.4819 26.3774 30.808 24.6884C30.799 24.6792 30.7898 24.6699 30.7806 24.6607L24.4163 18.2967C24.2081 18.0884 23.8703 18.0884 23.662 18.2967L23.3953 18.5634C23.1612 18.796 22.7832 18.796 22.5491 18.5634C22.3155 18.3303 22.3149 17.9519 22.548 17.7184C22.5484 17.718 22.5488 17.7177 22.5491 17.7173L22.8159 17.4504C23.0242 17.2421 23.0242 16.9044 22.8159 16.6961L21.5926 15.4728L24.3898 12.6756C24.8011 12.7605 25.2198 12.804 25.6397 12.8053ZM27.7358 30.9446C27.3483 30.944 26.964 30.874 26.6012 30.7377L30.7679 26.5708C31.3966 28.2434 30.5506 30.1089 28.878 30.7377C28.513 30.8748 28.1261 30.9451 27.7358 30.9446ZM21.6918 17.0786C21.101 17.7834 21.1936 18.8337 21.8983 19.4243C22.5177 19.9434 23.4204 19.943 24.0391 19.4228L30.0263 25.4153C30.0912 25.4805 30.152 25.5491 30.2108 25.6189L25.6493 30.1804C25.5793 30.1218 25.5106 30.061 25.4454 29.9959L19.4536 24.0036C20.0445 23.2989 19.9518 22.2485 19.2471 21.6579C18.6278 21.1386 17.7249 21.1393 17.1062 21.6592L16.2526 20.8057L20.8381 16.2271L21.6918 17.0786ZM23.8461 11.7128L11.7434 23.8131C11.6106 23.9457 11.5573 24.1382 11.6025 24.3201C12.3344 27.1945 10.5975 30.1181 7.72286 30.8498C4.84844 31.5818 1.92485 29.8449 1.19291 26.9702C0.461195 24.0958 2.1981 21.1722 5.07274 20.4403C5.94229 20.2191 6.85331 20.2191 7.72286 20.4403C7.9048 20.4848 8.09684 20.4315 8.22984 20.2996L20.3298 8.19902C20.4623 8.06646 20.5157 7.87398 20.47 7.69226C19.7431 4.85141 21.4568 1.95921 24.2976 1.2321C24.8344 1.09493 25.3897 1.04226 25.9428 1.07672L23.1285 3.8921C22.9856 4.03476 22.9356 4.24611 22.9994 4.43771L24.0663 7.63893C24.1196 7.79804 24.2447 7.92314 24.404 7.97603L27.6053 9.04311C27.7966 9.10697 28.008 9.05715 28.1509 8.9145L30.9652 6.10021C30.9715 6.20204 30.9748 6.30278 30.9748 6.40308C30.9897 9.33457 28.6256 11.7231 25.6941 11.7382C25.2409 11.7404 24.7892 11.6847 24.3503 11.5723C24.1683 11.5269 23.9759 11.58 23.8433 11.7125H23.8461V11.7128Z"
                      fill="#585B7C"
                    />
                    <path
                      d="M27.6178 26.8325L26.8632 27.587L21.5283 22.2521L22.2826 21.4976L27.6178 26.8325Z"
                      fill="#585B7C"
                    />
                  </g>
                  <defs>
                    <clipPath id="clip0_2218_3734">
                      <rect width="32" height="32" fill="white" />
                    </clipPath>
                  </defs>
                </svg>

                <span>4.9</span>
                <p class="text-para">Average Rating</p>
              </div>
              <!-- single box end-->
            </div>
          </div>
          <div class="company">
            <h2 class="text-h2">Our Company Partners</h2>

            <!-- Swiper -->
            <div dir="rtl" class="swiper company-swiper main-company-box">
              <div class="swiper-wrapper company-list">
                <div class="swiper-slide company-slide">
                  <svg
                    width="119"
                    height="27"
                    viewBox="0 0 119 27"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M11.2503 0.161033V0.993041C10.2732 1.1004 9.61296 1.26143 9.21682 1.44931C8.82068 1.63717 8.6094 2.06661 8.6094 2.71073C8.6094 3.00596 8.66223 3.3012 8.74146 3.56959C8.82068 3.83797 8.95273 4.24055 9.164 4.77734L15.0532 19.163L20.0446 6.44135C20.2823 5.82406 20.4936 5.15309 20.7048 4.48211C20.9161 3.78429 21.0217 3.27436 21.0217 2.92545C21.0217 2.2008 20.6784 1.66401 20.0183 1.34195C19.5957 1.15408 19.041 1.04672 18.3279 0.993041V0.161033H26.1187V0.993041C25.2208 1.07356 24.5606 1.36879 24.1645 1.9324C23.7683 2.46919 23.1873 3.70378 22.4214 5.66302L14.3931 26.0607C14.2346 26.4095 14.1289 26.6512 14.0232 26.7854C13.9177 26.9195 13.812 27 13.6536 27C13.4687 27 13.3103 26.8927 13.1782 26.6779C13.0462 26.4632 12.9141 26.1949 12.7557 25.8728L4.22548 5.09941C3.53884 3.40855 2.79937 2.28131 2.03352 1.66401C1.55815 1.31511 0.897914 1.1004 0 0.993041V0.161033H11.2503ZM36.3919 0.0805172V18.1968C36.3919 19.4851 36.5767 20.505 36.9201 21.2833C37.6067 22.7058 38.9008 23.4305 40.7495 23.4305C42.0171 23.4305 43.2583 23.001 44.4995 22.169C45.1862 21.7127 45.8992 21.0418 46.6123 20.2098V4.69683C46.6123 3.22068 46.3218 2.28131 45.7671 1.82505C45.2126 1.36879 44.1035 1.1004 42.4397 0.993041V0.0536782H51.3396V20.2098C51.3396 21.4443 51.5508 22.3032 51.9998 22.7862C52.4487 23.2694 53.3731 23.4572 54.7727 23.4036V24.2356C53.7692 24.504 53.0298 24.7186 52.5544 24.8528C52.0791 24.987 51.2867 25.2555 50.1775 25.6044C49.7022 25.7654 48.6722 26.168 47.0613 26.8121C46.9556 26.8121 46.9292 26.7585 46.9028 26.6779C46.8764 26.5974 46.8764 26.4901 46.8764 26.3559V21.7127C45.6087 23.2425 44.4468 24.3698 43.3904 25.1213C41.8059 26.2485 40.1157 26.8121 38.3462 26.8121C36.7353 26.8121 35.2036 26.2217 33.751 25.0676C32.2985 23.9135 31.5591 21.9811 31.5591 19.2704V4.58946C31.5591 3.08648 31.2685 2.06661 30.6347 1.55666C30.2385 1.23459 29.3935 1.01988 28.0994 0.885686V0.0536782H36.3919V0.0805172ZM61.0317 3.81113C63.3293 1.26143 66.2871 0 69.9053 0C73.4969 0 76.4812 1.20775 78.8579 3.62327C81.2085 6.03877 82.3968 9.23261 82.3968 13.2584C82.3968 16.9353 81.2612 20.156 78.9636 22.8668C76.666 25.5775 73.7082 26.9463 70.0637 26.9463C66.5777 26.9463 63.6199 25.6312 61.1902 23.0279C58.7605 20.4244 57.5721 17.1233 57.5721 13.1779C57.5721 9.47415 58.7077 6.36084 61.0317 3.81113ZM65.3628 3.0328C63.5406 4.72366 62.6162 7.6491 62.6162 11.7823C62.6162 15.0835 63.3557 18.1699 64.8347 21.0149C66.3135 23.8866 68.3471 25.3091 70.9616 25.3091C73.0215 25.3091 74.5796 24.3429 75.6889 22.4374C76.7981 20.5317 77.3526 18.009 77.3526 14.9225C77.3526 11.7018 76.6396 8.69582 75.24 5.8509C73.8401 3.00596 71.7803 1.5835 69.113 1.5835C67.6604 1.5835 66.4192 2.06661 65.3628 3.0328ZM85.1433 25.8728C86.8599 25.7386 87.9956 25.4165 88.5501 24.9334C89.1047 24.4771 89.3953 23.4841 89.3953 21.9542V9.09841C89.3953 7.24652 89.2104 5.90458 88.867 5.09941C88.5237 4.29424 87.8899 3.89164 86.9656 3.89164C86.7808 3.89164 86.5166 3.91848 86.2261 3.97217C85.9092 4.02585 85.5923 4.07952 85.249 4.16004V3.24752C86.3054 2.87177 87.4146 2.49603 88.5237 2.12028C89.6594 1.7177 90.4253 1.44931 90.8742 1.26143C91.7985 0.912524 92.7756 0.509941 93.7792 0.0536782C93.9112 0.0536782 93.9905 0.107356 94.0169 0.214712C94.0432 0.322068 94.0696 0.536779 94.0696 0.858847V5.55567C95.2317 3.86481 96.3672 2.52287 97.45 1.5835C98.5328 0.644135 99.6685 0.161033 100.83 0.161033C101.755 0.161033 102.521 0.456262 103.102 1.04672C103.683 1.63717 103.973 2.36182 103.973 3.24752C103.973 4.02585 103.762 4.69683 103.313 5.2336C102.864 5.77037 102.309 6.03877 101.623 6.03877C100.936 6.03877 100.249 5.7167 99.5364 5.04572C98.8498 4.37476 98.2952 4.05269 97.899 4.05269C97.2652 4.05269 96.4993 4.58946 95.5486 5.63618C94.6243 6.70974 94.1489 7.81014 94.1489 8.93738V21.659C94.1489 23.2694 94.5186 24.3698 95.2845 24.987C96.0239 25.6044 97.2915 25.8996 99.0346 25.8728V26.7854H85.1433V25.8728ZM114.537 0.161033C114.774 0.080517 114.748 0.429424 114.748 0.590458V20.9076C114.748 23.0546 115.012 24.3967 115.514 24.9334C116.042 25.4702 117.178 25.819 119 25.9801V26.8121H105.426V25.9801C107.433 25.7923 108.674 25.4433 109.202 24.9603C109.73 24.4503 109.968 23.1352 109.968 20.9345V7.24652C109.968 6.03877 109.889 5.17992 109.73 4.72366C109.44 3.94533 108.885 3.56959 107.987 3.56959C107.776 3.56959 107.591 3.59643 107.406 3.62327C107.221 3.6501 106.667 3.81113 105.743 4.07952V2.97913C105.743 2.95229 109.73 1.69086 114.537 0.161033Z"
                      fill="#526464"
                    />
                  </svg>
                </div>
                <div class="swiper-slide company-slide">
                  <svg
                    width="85"
                    height="35"
                    viewBox="0 0 85 35"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M85 0H0.0145502V3.07434H85V0ZM85 31.1566H0.0145502V34.2087H85V31.1566ZM81.9761 17.0644C81.9761 14.3987 81.7191 12.7683 79.9285 12.7683H78.4304V21.3249H79.9285C81.7191 21.3249 81.9761 19.6989 81.9761 17.0244V17.0644ZM85 17.0244C85 21.165 83.8339 24.2571 79.9285 24.2571H75.7385C75.7016 24.2597 75.6646 24.2534 75.63 24.2387C75.5953 24.224 75.5639 24.2012 75.5377 24.1718C75.5116 24.1424 75.4913 24.1071 75.4782 24.0682C75.4651 24.0292 75.4595 23.9876 75.4618 23.9461V10.1204C75.4595 10.0789 75.4651 10.0373 75.4782 9.99848C75.4913 9.95955 75.5116 9.92423 75.5377 9.89474C75.5639 9.86534 75.5953 9.8425 75.63 9.8278C75.6646 9.8131 75.7016 9.80691 75.7385 9.8095H79.9285C83.8339 9.8095 85 12.9193 85 17.0422V17.0244ZM69.4061 21.6492V23.9639C69.4084 24.0054 69.4029 24.047 69.3898 24.0859C69.3767 24.1248 69.3564 24.1602 69.3302 24.1896C69.3041 24.219 69.2726 24.2418 69.238 24.2565C69.2033 24.2712 69.1664 24.2775 69.1294 24.2749H61.0696C61.0327 24.2775 60.9957 24.2712 60.9611 24.2565C60.9265 24.2418 60.895 24.219 60.8689 24.1896C60.8427 24.1602 60.8223 24.1248 60.8093 24.0859C60.7962 24.047 60.7907 24.0054 60.793 23.9639V10.1204C60.7907 10.0789 60.7962 10.0373 60.8093 9.99848C60.8223 9.95955 60.8427 9.92423 60.8689 9.89474C60.895 9.86534 60.9265 9.8425 60.9611 9.8278C60.9957 9.8131 61.0327 9.80691 61.0696 9.8095H69.1136C69.1506 9.80691 69.1876 9.8131 69.2222 9.8278C69.2568 9.8425 69.2883 9.86534 69.3144 9.89474C69.3406 9.92423 69.3609 9.95955 69.374 9.99848C69.387 10.0373 69.3927 10.0789 69.3903 10.1204V12.4395C69.3927 12.481 69.387 12.5226 69.374 12.5615C69.3609 12.6005 69.3406 12.6358 69.3144 12.6652C69.2883 12.6947 69.2568 12.7174 69.2222 12.7321C69.1876 12.7469 69.1506 12.7531 69.1136 12.7505H63.7655V15.5494H68.663C68.7 15.5469 68.7369 15.5531 68.7715 15.5678C68.8062 15.5825 68.8377 15.6053 68.8638 15.6347C68.89 15.6642 68.9102 15.6995 68.9234 15.7384C68.9364 15.7774 68.942 15.8189 68.9397 15.8604V18.1751C68.942 18.2166 68.9364 18.2581 68.9234 18.2971C68.9102 18.336 68.89 18.3713 68.8638 18.4007C68.8377 18.4302 68.8062 18.4529 68.7715 18.4677C68.7369 18.4824 68.7 18.4886 68.663 18.486H63.7655V21.3694H69.1334C69.1698 21.3653 69.2065 21.3703 69.2409 21.384C69.2754 21.3977 69.3068 21.4197 69.3328 21.4485C69.3588 21.4774 69.3789 21.5123 69.3916 21.5508C69.4042 21.5893 69.4092 21.6306 69.4061 21.6714V21.6492ZM54.8716 20.1743C54.8716 23.2841 53.2154 24.617 49.9741 24.617C46.9502 24.617 45.4639 23.4618 45.2308 20.5697C45.2229 20.5275 45.2238 20.4837 45.2332 20.4419C45.2426 20.4002 45.2604 20.3613 45.2851 20.3283C45.3098 20.2954 45.341 20.2691 45.3761 20.2517C45.4111 20.2343 45.4493 20.226 45.4876 20.2276H47.7012C47.8673 20.2276 47.9305 20.3431 47.978 20.5075C48.2191 21.2494 48.8041 21.6137 49.9543 21.6137C51.1876 21.6137 51.9505 21.2227 51.9505 20.2809C51.9505 19.339 51.6738 18.8059 49.8911 18.4105C47.6103 17.904 45.4047 16.8423 45.4047 13.9279C45.4047 11.2623 46.8475 9.61839 49.8911 9.61839C52.6028 9.61839 54.2392 10.7735 54.4685 13.5636C54.4772 13.6075 54.4772 13.6531 54.4685 13.6971C54.4598 13.7411 54.4425 13.7823 54.418 13.8179C54.3935 13.8536 54.3623 13.8827 54.3266 13.9033C54.2909 13.9238 54.2516 13.9352 54.2115 13.9367H52.1916C52.0257 13.9367 51.9624 13.7901 51.915 13.6257C51.741 13.026 51.16 12.595 49.9662 12.595C48.8713 12.595 48.3218 13.1637 48.3218 13.9279C48.3218 14.5454 48.2863 15.1896 49.9228 15.5406C52.334 16.0426 54.8796 16.9933 54.8796 20.1654L54.8716 20.1743ZM33.562 16.6379H35.4989C36.6097 16.6379 37.0445 16.4202 37.0445 14.6876C37.0445 12.9549 36.6136 12.7461 35.4989 12.7461H33.562V16.6379ZM39.7442 24.2749H37.4635C37.3939 24.2808 37.3246 24.2604 37.2666 24.2169C37.2085 24.1735 37.1652 24.1094 37.1433 24.035L35.3882 19.5923H33.5581V23.9816C33.5604 24.0231 33.5548 24.0647 33.5417 24.1037C33.5287 24.1426 33.5084 24.1779 33.4822 24.2073C33.456 24.2368 33.4246 24.2595 33.39 24.2743C33.3554 24.2889 33.3183 24.2952 33.2814 24.2926H30.8464C30.8092 24.2951 30.7718 24.2889 30.7368 24.2743C30.7018 24.2596 30.6699 24.237 30.6432 24.2077C30.6164 24.1785 30.5953 24.1432 30.5813 24.1043C30.5674 24.0654 30.5607 24.0236 30.5619 23.9816V10.1204C30.5607 10.0785 30.5674 10.0368 30.5813 9.99783C30.5953 9.95891 30.6164 9.92368 30.6432 9.89446C30.6699 9.86516 30.7018 9.8425 30.7368 9.8279C30.7718 9.81329 30.8092 9.807 30.8464 9.8095H35.4792C38.9536 9.8095 39.8628 11.5865 39.8628 14.6964C39.8628 16.8644 39.4201 18.375 37.9971 19.0947L39.9379 23.9062C40.0249 24.1283 39.9379 24.2749 39.7284 24.2749H39.7442ZM24.4746 21.6492V23.9639C24.4769 24.0054 24.4713 24.047 24.4582 24.0859C24.4451 24.1248 24.4248 24.1602 24.3986 24.1896C24.3725 24.219 24.341 24.2418 24.3064 24.2565C24.2718 24.2712 24.2348 24.2775 24.1978 24.2749H16.138C16.1011 24.2775 16.0641 24.2712 16.0295 24.2565C15.9949 24.2418 15.9634 24.219 15.9373 24.1896C15.9111 24.1602 15.8908 24.1248 15.8777 24.0859C15.8646 24.047 15.8591 24.0054 15.8614 23.9639V10.1204C15.8591 10.0789 15.8646 10.0373 15.8777 9.99848C15.8908 9.95955 15.9111 9.92423 15.9373 9.89474C15.9634 9.86534 15.9949 9.8425 16.0295 9.8278C16.0641 9.8131 16.1011 9.80691 16.138 9.8095H24.182C24.2189 9.80691 24.256 9.8131 24.2906 9.8278C24.3252 9.8425 24.3566 9.86534 24.3829 9.89474C24.409 9.92423 24.4293 9.95955 24.4424 9.99848C24.4555 10.0373 24.4611 10.0789 24.4587 10.1204V12.4395C24.4611 12.481 24.4555 12.5226 24.4424 12.5615C24.4293 12.6005 24.409 12.6358 24.3829 12.6652C24.3566 12.6947 24.3252 12.7174 24.2906 12.7321C24.256 12.7469 24.2189 12.7531 24.182 12.7505H18.8299V15.5494H23.7314C23.7684 15.5469 23.8054 15.5531 23.8399 15.5678C23.8746 15.5825 23.9061 15.6053 23.9322 15.6347C23.9584 15.6642 23.9787 15.6995 23.9918 15.7384C24.0048 15.7774 24.0104 15.8189 24.0081 15.8604V18.1751C24.0104 18.2166 24.0048 18.2581 23.9918 18.2971C23.9787 18.336 23.9584 18.3713 23.9322 18.4007C23.9061 18.4302 23.8746 18.4529 23.8399 18.4677C23.8054 18.4824 23.7684 18.4886 23.7314 18.486H18.8299V21.3694H24.1978C24.2343 21.3654 24.2712 21.3704 24.3059 21.3841C24.3405 21.3978 24.372 21.4197 24.3984 21.4484C24.4247 21.4772 24.4451 21.512 24.4583 21.5505C24.4714 21.589 24.477 21.6303 24.4746 21.6714V21.6492ZM7.56442 9.8095H10.035C10.2365 9.8095 10.2918 9.95604 10.2563 10.1605L7.29562 24.0217C7.27743 24.0975 7.2363 24.1638 7.17931 24.2092C7.12231 24.2546 7.05302 24.2763 6.98335 24.2705H3.28748C3.21781 24.2763 3.14852 24.2546 3.09152 24.2092C3.03453 24.1638 2.9934 24.0975 2.97521 24.0217L0.0145502 10.1605C-0.0328834 9.95604 0.0343149 9.8095 0.235908 9.8095H2.69851C2.76891 9.79886 2.84028 9.81856 2.89823 9.86479C2.95619 9.91092 2.9964 9.98008 3.01078 10.0583L4.98718 20.8007H5.26388L7.24028 10.0583C7.25466 9.98008 7.29488 9.91092 7.35283 9.86479C7.41078 9.81856 7.48216 9.79886 7.55255 9.8095"
                      fill="#526464"
                    />
                  </svg>
                </div>
                <div class="swiper-slide company-slide">
                  <svg
                    width="134"
                    height="29"
                    viewBox="0 0 134 29"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M82.9369 12.3596L75.6866 4.97722V4.92606C75.2455 4.50067 74.6618 4.26891 74.0586 4.27965C73.4553 4.2904 72.8797 4.5428 72.4531 4.98364C72.0265 5.42447 71.7822 6.01928 71.7718 6.64263C71.7614 7.26597 71.9857 7.86913 72.3974 8.32489L72.4469 8.36874L79.5912 15.8535H82.9723V12.3596H82.9369Z"
                      fill="#526464"
                    />
                    <path
                      d="M84.1758 20.59L91.412 27.9725L91.4615 28.0236C91.8977 28.4734 92.4889 28.7256 93.1051 28.725C93.7213 28.7243 94.3119 28.4707 94.7472 28.02C95.1824 27.5693 95.4265 26.9583 95.4259 26.3216C95.4252 25.6849 95.1798 25.0745 94.7436 24.6248L94.7012 24.5809L87.5569 17.0962H84.1758V20.59Z"
                      fill="#526464"
                    />
                    <path
                      d="M87.5357 15.8535L94.68 8.36874L94.7295 8.32489C95.1412 7.86913 95.3654 7.26597 95.355 6.64263C95.3446 6.01928 95.1004 5.42447 94.6738 4.98364C94.2472 4.5428 93.6715 4.2904 93.0683 4.27965C92.4651 4.26891 91.8814 4.50067 91.4403 4.92606L91.3979 4.97722L84.1758 12.3596V15.8535H87.5357Z"
                      fill="#526464"
                    />
                    <path
                      d="M79.5572 17.0962L72.42 24.5736L72.3704 24.6175C71.9343 25.0721 71.6907 25.6871 71.6934 26.3272C71.6947 26.6442 71.7564 26.9578 71.875 27.2501C71.9936 27.5424 72.1668 27.8077 72.3846 28.0309C72.6024 28.2541 72.8607 28.4307 73.1446 28.5508C73.4285 28.6708 73.7325 28.7319 74.0392 28.7306C74.6587 28.7278 75.2518 28.4709 75.6879 28.0163L75.7304 27.9651L82.9737 20.59V17.0889H79.5855L79.5572 17.0962Z"
                      fill="#526464"
                    />
                    <path
                      d="M19.1622 25.0856L18.3063 12.4258C18.2073 10.964 18.1436 9.73602 18.1436 8.47151C17.8748 9.83835 17.6768 10.6643 17.2806 12.1262L13.6519 25.0856H9.73318L6.46521 12.6597C6.16812 11.4976 5.75785 9.83104 5.53858 8.4642C5.53858 9.86759 5.47491 11.2637 5.37588 12.7255L4.58365 25.0856H0L2.12206 1.39609H8.02846L11.0276 13.2591C11.3557 14.4937 11.6201 15.7453 11.8199 17.0088C12.0388 15.7106 12.3221 14.4249 12.6687 13.1568L15.7669 1.39609H21.6379L23.6822 25.0856H19.1622ZM39.2369 25.97C38.2345 25.5669 37.3958 24.8215 36.8602 23.8576C36.5442 24.1914 36.2037 24.4993 35.8416 24.7786C34.8296 25.4514 33.6416 25.7857 32.4392 25.7361C28.6832 25.7361 26.6389 23.7553 26.6389 20.2834C26.6389 16.1901 29.3764 14.2824 34.7523 14.2824H35.7426V13.5515C35.7426 11.6072 35.3747 10.9567 33.762 10.9567C32.3473 10.9567 30.6921 11.6876 28.8812 12.9375L26.9997 9.66293C27.8658 9.088 28.7823 8.59855 29.7371 8.20106C31.1911 7.53134 32.7643 7.1828 34.3561 7.17776C37.1856 7.17776 39.1379 8.26685 39.7957 10.2111C40.0954 11.2256 40.1964 12.2916 40.0928 13.3468L39.9937 19.1943C39.9937 21.102 40.0928 21.9206 41.5782 23.0828L39.2369 25.97ZM35.4738 17.4473C32.4109 17.4473 31.3499 18.0321 31.3499 20.1079C31.3215 20.3924 31.3504 20.6798 31.4345 20.9521C31.5187 21.2245 31.6564 21.476 31.8391 21.6908C32.0217 21.9056 32.2453 22.079 32.4958 22.2004C32.7464 22.3217 33.0185 22.3882 33.2951 22.3958C33.7402 22.3735 34.1759 22.2554 34.5742 22.049C34.9726 21.8426 35.3247 21.5524 35.6082 21.197L35.6718 17.4473H35.4738ZM49.5147 25.4949C47.2724 25.4949 45.4899 24.4716 44.9664 22.9366C44.6797 22.0729 44.5784 21.1551 44.6694 20.2468V10.7447H42.9859V7.63824H44.6694C44.6337 6.25944 44.6881 4.87973 44.832 3.50848L49.3167 2.35361C49.144 4.10952 49.0566 5.87329 49.0549 7.63824H53.009L51.8914 10.7739H49.062V19.5451C49.062 21.7379 49.4581 22.3373 50.9719 22.3373C51.5124 22.3006 52.0456 22.1875 52.5563 22.0011L53.1151 24.7274C51.976 25.2271 50.7522 25.488 49.5147 25.4949ZM63.3293 11.6218C62.9382 11.3897 62.4928 11.2733 62.0419 11.2856C61.5145 11.3055 60.9981 11.4471 60.5306 11.7001C60.063 11.953 59.6562 12.3109 59.3399 12.7475V25.0856H54.9189V13.4272C54.9823 11.6981 54.772 9.96984 54.2964 8.3107L58.2505 7.22161C58.673 7.98061 58.9155 8.83227 58.9579 9.70678C59.9128 8.37649 61.2709 7.22161 62.9191 7.22161C63.49 7.20092 64.0568 7.32912 64.5672 7.59439L63.3293 11.6218ZM67.9766 5.65742C67.619 5.65551 67.2652 5.58082 66.9355 5.43763C66.6058 5.29443 66.3067 5.08554 66.0551 4.82287C65.8035 4.5602 65.6045 4.2489 65.4694 3.90674C65.3342 3.56458 65.2656 3.19827 65.2675 2.82871C65.2749 2.07455 65.5706 1.35401 66.09 0.824143C66.6094 0.294275 67.3104 -0.0019586 68.0403 9.7467e-06C68.3975 0.000944476 68.7511 0.0750715 69.0804 0.218102C69.4097 0.361133 69.7084 0.570228 69.959 0.83329C70.2096 1.09635 70.4073 1.40816 70.5405 1.75067C70.6738 2.09318 70.74 2.45959 70.7353 2.82871C70.7363 3.20231 70.6654 3.57239 70.5269 3.91746C70.3883 4.26254 70.1848 4.57574 69.9281 4.83889C69.6715 5.10205 69.3669 5.30991 69.0318 5.45042C68.6968 5.59093 68.3382 5.66129 67.9766 5.65742ZM65.7838 25.0856V7.93793L70.2048 7.207V25.0856H65.7838ZM99.1002 5.65742C98.7429 5.65551 98.3895 5.58077 98.0602 5.43749C97.7308 5.29421 97.4321 5.08519 97.1811 4.82243C96.9301 4.55966 96.7318 4.2483 96.5974 3.90618C96.463 3.56407 96.3953 3.19792 96.3981 2.82871C96.4037 2.07522 96.6978 1.35467 97.2161 0.824594C97.7343 0.294523 98.4346 -0.00194463 99.1638 9.7467e-06C99.5211 0.000944476 99.8746 0.0750715 100.204 0.218102C100.533 0.361133 100.832 0.570228 101.083 0.83329C101.333 1.09635 101.531 1.40816 101.664 1.75067C101.797 2.09318 101.864 2.45959 101.859 2.82871C101.86 3.20231 101.789 3.57239 101.65 3.91746C101.512 4.26254 101.308 4.57574 101.052 4.83889C100.795 5.10205 100.49 5.30991 100.155 5.45042C99.8204 5.59093 99.4617 5.66129 99.1002 5.65742ZM96.9074 25.0856V7.93793L101.321 7.207V25.0856H96.9074ZM116.218 25.97C115.216 25.5669 114.377 24.8215 113.841 23.8576C113.527 24.1931 113.186 24.5011 112.823 24.7786C111.811 25.4514 110.623 25.7857 109.42 25.7361C105.664 25.7361 103.62 23.7553 103.62 20.2834C103.62 16.1901 106.358 14.2824 111.734 14.2824H112.724V13.5515C112.724 11.6072 112.356 10.9567 110.743 10.9567C109.329 10.9567 107.673 11.6876 105.862 12.9375L103.981 9.71409C104.847 9.13916 105.764 8.64972 106.718 8.25223C108.172 7.58251 109.746 7.23396 111.337 7.22892C114.167 7.22892 116.119 8.31801 116.777 10.2623C117.077 11.2767 117.178 12.3427 117.074 13.398L116.975 19.2454C116.975 21.1532 117.074 21.9718 118.559 23.134L116.218 25.97ZM112.469 17.4473C109.406 17.4473 108.352 18.0321 108.352 20.1079C108.323 20.3926 108.351 20.6804 108.435 20.9533C108.519 21.2261 108.656 21.478 108.839 21.693C109.022 21.9081 109.246 22.0816 109.497 22.2025C109.748 22.3235 110.021 22.3893 110.298 22.3958C110.739 22.3705 111.171 22.251 111.565 22.0447C111.96 21.8383 112.308 21.5497 112.589 21.197L112.653 17.4473H112.469ZM129.644 25.0856V13.7342C129.644 11.7607 129.311 11.176 128.158 11.176C126.992 11.3229 125.908 11.8774 125.088 12.7475V25.0856H120.667V12.4258C120.689 11.0369 120.488 9.65393 120.073 8.33263L123.999 7.17776C124.39 7.83969 124.607 8.59549 124.629 9.37055C125.252 8.89979 125.901 8.46778 126.574 8.0768C127.519 7.60005 128.556 7.35018 129.608 7.34587C131.49 7.34587 133.145 8.36187 133.669 9.86759C133.918 10.6697 134.028 11.511 133.994 12.3528V25.0856H129.644Z"
                      fill="#526464"
                    />
                  </svg>
                </div>
                <div class="swiper-slide company-slide">
                  <svg
                    width="93"
                    height="33"
                    viewBox="0 0 93 33"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M92.9922 22.6145C92.5889 23.0833 92.2601 23.673 91.7684 23.9969C90.6562 24.7316 89.5315 24.3288 88.5403 22.9818C84.4219 24.7912 80.8914 24.0323 78.6313 20.8535C77.621 19.4268 77.0984 17.6905 77.1465 15.9202C77.1945 14.1499 77.8105 12.4469 78.8965 11.0817C80.0478 9.64534 81.6539 8.68172 83.427 8.36346C85.2 8.0452 87.0243 8.3931 88.5729 9.34482C89.7689 8.05588 90.7291 7.74493 91.8009 8.47318C92.288 8.80347 92.606 9.40121 93 9.87812L92.9922 22.6145ZM81.1566 16.1794C81.175 17.1564 81.5625 18.0867 82.2355 18.7695C82.9085 19.4523 83.8131 19.8327 84.7539 19.8287C86.7006 19.8142 88.3449 18.1225 88.334 16.1424C88.3232 14.1622 86.6727 12.4463 84.7585 12.4367C83.8038 12.4396 82.8891 12.835 82.2142 13.5363C81.5393 14.2376 81.1591 15.1879 81.1566 16.1794ZM63.5568 23.8454V28.4534C63.5568 28.8562 63.5708 29.259 63.5568 29.6618C63.4885 31.0393 62.5144 32.0012 61.1881 32.0173C59.8619 32.0334 58.8226 31.0796 58.7372 29.7407C58.6829 28.8852 58.7124 28.0216 58.7109 27.1628C58.7109 21.8459 58.7248 16.5291 58.7 11.2122C58.7 10.0215 58.942 9.0097 60.0201 8.43129C61.0485 7.87704 62.0009 8.07522 62.8944 8.83891C63.034 8.95653 63.4125 8.87436 63.6344 8.77447C68.2724 6.67994 73.6256 9.45922 74.6401 14.5425C75.2481 17.5876 74.457 20.2702 72.2435 22.3712C69.9849 24.5157 67.3184 25.0506 64.3867 24.1225C64.1587 24.0436 63.9415 23.9679 63.5568 23.8454ZM66.9182 12.4061C66.4212 12.4012 65.9282 12.4985 65.4675 12.6923C65.0069 12.8862 64.5877 13.1729 64.2342 13.5357C63.8806 13.8986 63.5997 14.3305 63.4076 14.8067C63.2154 15.2828 63.1159 15.7937 63.1147 16.3099C63.1114 17.0851 63.3292 17.8438 63.7408 18.4904C64.1524 19.137 64.7393 19.6424 65.4272 19.9428C66.1152 20.2431 66.8734 20.325 67.6062 20.178C68.3389 20.031 69.0133 19.6618 69.5441 19.117C70.0749 18.5722 70.4384 17.8762 70.5886 17.1169C70.7388 16.3576 70.669 15.5691 70.388 14.851C70.1071 14.133 69.6275 13.5174 69.0099 13.0823C68.3924 12.6471 67.6645 12.4118 66.9182 12.4061ZM44.4306 23.8454C44.4306 25.8481 44.4476 27.7251 44.4228 29.6021C44.4245 30.1036 44.2738 30.5927 43.9922 31C43.7106 31.4074 43.3125 31.712 42.8546 31.8707C41.8711 32.1929 40.8939 32.0705 40.247 31.194C39.8612 30.6673 39.6389 30.0312 39.6095 29.3701C39.5629 23.1687 39.5831 16.9641 39.58 10.7659C39.58 9.70895 39.9756 8.88403 40.8985 8.40067C41.8215 7.91732 42.7786 8.0011 43.5728 8.71324C43.9823 9.07898 44.2708 8.86469 44.6167 8.71324C49.23 6.7315 54.3892 9.42055 55.4596 14.4136C56.1281 17.5199 55.3355 20.2299 53.0723 22.3744C50.8091 24.5189 48.1891 25.0232 45.2946 24.1274C45.0448 24.0533 44.8044 23.9727 44.4306 23.8454ZM47.7113 20.2074C48.4549 20.2109 49.1828 19.9852 49.8028 19.559C50.4229 19.1327 50.9073 18.525 51.1947 17.8127C51.4822 17.1005 51.5598 16.3156 51.4177 15.5575C51.2756 14.7995 50.9202 14.1022 50.3965 13.5539C49.8728 13.0057 49.2043 12.6311 48.4755 12.4776C47.7468 12.324 46.9906 12.3985 46.3026 12.6914C45.6146 12.9844 45.0258 13.4828 44.6105 14.1234C44.1953 14.7641 43.9723 15.5183 43.9699 16.2906C43.9637 18.3948 45.687 20.1993 47.7113 20.2138V20.2074ZM20.5887 11.1671V2.70355C20.5918 1.06338 21.5613 0 23.0319 0C24.5024 0 25.4533 1.10043 25.4533 2.72772C25.4533 7.96727 25.4641 13.2004 25.444 18.4464C25.444 19.1327 25.5634 19.5742 26.2583 19.8626C27.3923 20.3459 27.8902 21.6139 27.5458 22.7998C27.385 23.3864 27.0279 23.8941 26.5388 24.2317C26.0498 24.5693 25.4608 24.7145 24.8778 24.6413C22.2857 24.3481 20.6151 22.4179 20.5934 19.6306C20.5701 16.8094 20.5887 13.9882 20.5887 11.1671ZM11.9688 16.3567L15.7924 19.9963C16.9915 21.1386 17.142 22.724 16.157 23.839C15.172 24.9539 13.644 24.9297 12.4341 23.789C10.5199 21.9909 8.6068 20.1918 6.69469 18.3916C5.45374 17.2219 5.44288 15.5672 6.67763 14.3862C8.61145 12.5344 10.5541 10.6896 12.5055 8.8518C13.6549 7.7707 15.2092 7.80776 16.1725 8.90497C17.1358 10.0022 17.0117 11.5457 15.8886 12.6365C14.6104 13.8771 13.3059 15.0903 11.9688 16.3567ZM30.777 16.3035C30.777 14.4523 30.7677 12.5978 30.777 10.7498C30.7863 9.15954 31.8054 8.09294 33.2822 8.10261C34.7061 8.11066 35.7144 9.18371 35.7191 10.7385C35.7284 14.47 35.7284 18.2004 35.7191 21.9297C35.7191 23.5103 34.6472 24.6687 33.2527 24.6574C31.8209 24.6397 30.7847 23.5151 30.7708 21.9394C30.7692 20.0608 30.777 18.1821 30.777 16.3035ZM0.0183553 6.48337C0.0183553 5.24921 0.0028434 4.01505 0.0183553 2.77767C0.0524816 1.05854 1.00957 0 2.48165 0C3.99096 0.00805588 4.96356 1.12782 4.97287 2.84695C4.97287 5.37005 4.98217 7.89315 4.97287 10.4195C4.9829 10.9601 4.82595 11.4899 4.52504 11.9312C4.22412 12.3725 3.79504 12.7021 3.30068 12.8717C2.30016 13.2116 1.14918 12.9361 0.589195 12.0516C0.268615 11.5122 0.0810698 10.8991 0.0431744 10.2664C-0.0374876 9.01131 0.0199065 7.74493 0.0183553 6.48337Z"
                      fill="#526464"
                    />
                    <path
                      d="M4.8452 21.9778C4.8452 23.5294 3.92379 24.5235 2.47652 24.5218C1.09906 24.5218 0.115607 23.4875 0.109402 22.0326C0.103198 20.5777 1.15025 19.4418 2.50445 19.4547C3.85864 19.4676 4.84209 20.5213 4.8452 21.9778Z"
                      fill="#526464"
                    />
                  </svg>
                </div>
                <div class="swiper-slide company-slide">
                  <svg
                    width="146"
                    height="27"
                    viewBox="0 0 146 27"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M0 0.174715H3.4543L8.72069 14.6281L13.8738 0.174715H17.3282V26.7109H13.8738V9.54045L10.0231 21.1031H7.305L3.4543 9.54045V26.7688H0V0.174715ZM24.803 0.174715H29.4465L34.3731 26.7109H30.6923L29.673 20.9875H25.0295L25.4825 18.7327C25.6524 17.9234 26.0488 17.5187 26.7283 17.5187H29.0501L27.0681 6.36072L23.3873 26.7109H19.7065L24.803 0.174715ZM36.9214 0.174715H40.2624L46.3217 16.5936V0.174715H49.8325V26.7109H46.718L40.4324 9.71389V26.7688H36.9214V0.174715ZM53.4568 21.5078L53.4001 19.0796H57.1942L57.2507 21.6812C57.2507 22.8953 58.1002 23.5312 59.2894 23.5312H60.0256C61.2714 23.5312 62.0642 22.8953 62.0642 21.6812V19.1374C62.0642 16.6514 60.6484 16.2468 57.5906 14.4546C53.7399 12.4311 53.4568 11.1592 53.4568 8.32638V5.49353C53.4568 1.85129 55.7218 -0.0565371 58.893 0.00127603H60.0256C63.1967 0.00127603 65.6318 1.85129 65.6318 5.49353V7.74823C65.6318 8.49981 65.1787 8.90451 64.3858 9.02013L61.8942 9.54045V5.26227C61.8942 4.0482 61.0448 3.41225 59.8556 3.41225H59.1195C57.8737 3.41225 57.1942 4.0482 57.1942 5.26227V8.32638C57.1942 10.0608 58.0436 10.6389 59.2328 11.3904L62.4039 13.0092C65.4052 14.5124 65.8016 16.2468 65.8016 18.7327V21.5078C65.8016 25.1501 63.4232 27 60.1954 27H59.0629C55.8351 26.9422 53.4568 25.0922 53.4568 21.5078ZM69.3692 21.5078V5.49353C69.3692 1.85129 71.5776 -0.0565371 74.8055 0.00127603H75.938C79.1091 0.00127603 81.3743 1.67786 81.3743 5.26227V8.0373C81.3743 8.78887 80.9212 9.19357 80.1285 9.30919L77.6368 9.88732V5.26227C77.6368 4.0482 76.9573 3.41225 75.7114 3.41225H74.9753C73.7295 3.41225 73.1066 4.0482 73.1066 5.26227V21.739C73.1066 22.9531 73.7295 23.5891 74.9753 23.5891H75.7114C76.9573 23.5891 77.6368 22.9531 77.6368 21.739V19.0796H81.4309L81.3743 21.4499C81.3743 25.0921 79.1657 26.9422 75.938 26.9422H74.8055C71.5776 26.9422 69.3692 25.0922 69.3692 21.5078ZM88.4527 0.174715H93.0962L98.0228 26.7109H94.342L93.3228 20.9875H88.6793L89.1322 18.7327C89.3022 17.9234 89.6419 17.5187 90.3782 17.5187H92.6998L90.7179 6.36072L87.037 26.7109H83.3562L88.4527 0.174715ZM100.628 0.174715H107.536C110.708 0.116902 112.973 1.96692 112.973 5.66697V12.1999C112.973 15.8421 110.764 17.7499 107.536 17.6343H104.931V15.4952C104.931 14.4546 105.271 14.1655 106.234 14.1655H107.31C108.556 14.1655 109.178 13.5295 109.178 12.3155V5.43572C109.178 4.22163 108.556 3.58569 107.31 3.58569H104.422V26.7688H100.628V0.174715ZM116.484 0.174715H127.016V3.81695H120.164V23.0688H126.96V26.7109H116.427L116.484 0.174715ZM120.731 12.6624C120.731 11.6217 121.07 11.3326 122.033 11.3326H126.394V14.9749H120.731V12.6624ZM130.584 0.174715H137.492C140.664 0.116902 142.929 1.96692 142.929 5.66697V21.3343C142.929 24.9765 140.72 26.8844 137.492 26.8266H130.584V0.174715ZM137.266 23.3C138.511 23.3 139.135 22.6641 139.135 21.4499V5.43572C139.135 4.22163 138.511 3.58569 137.266 3.58569H134.378V23.3578H137.266V23.3ZM143.382 0.348155H142.872V0.174715H144.118V0.348155H143.608V1.96692H143.382V0.348155ZM144.288 0.174715H144.571L145.08 1.56223L145.591 0.174715H145.874V1.96692H145.647V0.463781L145.08 1.96692H145.024L144.402 0.463781V1.96692H144.231L144.288 0.174715Z"
                      fill="#526464"
                    />
                  </svg>
                </div>
                <div class="swiper-slide company-slide">
                  <svg
                    width="119"
                    height="27"
                    viewBox="0 0 119 27"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M11.2503 0.161033V0.993041C10.2732 1.1004 9.61296 1.26143 9.21682 1.44931C8.82068 1.63717 8.6094 2.06661 8.6094 2.71073C8.6094 3.00596 8.66223 3.3012 8.74146 3.56959C8.82068 3.83797 8.95273 4.24055 9.164 4.77734L15.0532 19.163L20.0446 6.44135C20.2823 5.82406 20.4936 5.15309 20.7048 4.48211C20.9161 3.78429 21.0217 3.27436 21.0217 2.92545C21.0217 2.2008 20.6784 1.66401 20.0183 1.34195C19.5957 1.15408 19.041 1.04672 18.3279 0.993041V0.161033H26.1187V0.993041C25.2208 1.07356 24.5606 1.36879 24.1645 1.9324C23.7683 2.46919 23.1873 3.70378 22.4214 5.66302L14.3931 26.0607C14.2346 26.4095 14.1289 26.6512 14.0232 26.7854C13.9177 26.9195 13.812 27 13.6536 27C13.4687 27 13.3103 26.8927 13.1782 26.6779C13.0462 26.4632 12.9141 26.1949 12.7557 25.8728L4.22548 5.09941C3.53884 3.40855 2.79937 2.28131 2.03352 1.66401C1.55815 1.31511 0.897914 1.1004 0 0.993041V0.161033H11.2503ZM36.3919 0.0805172V18.1968C36.3919 19.4851 36.5767 20.505 36.9201 21.2833C37.6067 22.7058 38.9008 23.4305 40.7495 23.4305C42.0171 23.4305 43.2583 23.001 44.4995 22.169C45.1862 21.7127 45.8992 21.0418 46.6123 20.2098V4.69683C46.6123 3.22068 46.3218 2.28131 45.7671 1.82505C45.2126 1.36879 44.1035 1.1004 42.4397 0.993041V0.0536782H51.3396V20.2098C51.3396 21.4443 51.5508 22.3032 51.9998 22.7862C52.4487 23.2694 53.3731 23.4572 54.7727 23.4036V24.2356C53.7692 24.504 53.0298 24.7186 52.5544 24.8528C52.0791 24.987 51.2867 25.2555 50.1775 25.6044C49.7022 25.7654 48.6722 26.168 47.0613 26.8121C46.9556 26.8121 46.9292 26.7585 46.9028 26.6779C46.8764 26.5974 46.8764 26.4901 46.8764 26.3559V21.7127C45.6087 23.2425 44.4468 24.3698 43.3904 25.1213C41.8059 26.2485 40.1157 26.8121 38.3462 26.8121C36.7353 26.8121 35.2036 26.2217 33.751 25.0676C32.2985 23.9135 31.5591 21.9811 31.5591 19.2704V4.58946C31.5591 3.08648 31.2685 2.06661 30.6347 1.55666C30.2385 1.23459 29.3935 1.01988 28.0994 0.885686V0.0536782H36.3919V0.0805172ZM61.0317 3.81113C63.3293 1.26143 66.2871 0 69.9053 0C73.4969 0 76.4812 1.20775 78.8579 3.62327C81.2085 6.03877 82.3968 9.23261 82.3968 13.2584C82.3968 16.9353 81.2612 20.156 78.9636 22.8668C76.666 25.5775 73.7082 26.9463 70.0637 26.9463C66.5777 26.9463 63.6199 25.6312 61.1902 23.0279C58.7605 20.4244 57.5721 17.1233 57.5721 13.1779C57.5721 9.47415 58.7077 6.36084 61.0317 3.81113ZM65.3628 3.0328C63.5406 4.72366 62.6162 7.6491 62.6162 11.7823C62.6162 15.0835 63.3557 18.1699 64.8347 21.0149C66.3135 23.8866 68.3471 25.3091 70.9616 25.3091C73.0215 25.3091 74.5796 24.3429 75.6889 22.4374C76.7981 20.5317 77.3526 18.009 77.3526 14.9225C77.3526 11.7018 76.6396 8.69582 75.24 5.8509C73.8401 3.00596 71.7803 1.5835 69.113 1.5835C67.6604 1.5835 66.4192 2.06661 65.3628 3.0328ZM85.1433 25.8728C86.8599 25.7386 87.9956 25.4165 88.5501 24.9334C89.1047 24.4771 89.3953 23.4841 89.3953 21.9542V9.09841C89.3953 7.24652 89.2104 5.90458 88.867 5.09941C88.5237 4.29424 87.8899 3.89164 86.9656 3.89164C86.7808 3.89164 86.5166 3.91848 86.2261 3.97217C85.9092 4.02585 85.5923 4.07952 85.249 4.16004V3.24752C86.3054 2.87177 87.4146 2.49603 88.5237 2.12028C89.6594 1.7177 90.4253 1.44931 90.8742 1.26143C91.7985 0.912524 92.7756 0.509941 93.7792 0.0536782C93.9112 0.0536782 93.9905 0.107356 94.0169 0.214712C94.0432 0.322068 94.0696 0.536779 94.0696 0.858847V5.55567C95.2317 3.86481 96.3672 2.52287 97.45 1.5835C98.5328 0.644135 99.6685 0.161033 100.83 0.161033C101.755 0.161033 102.521 0.456262 103.102 1.04672C103.683 1.63717 103.973 2.36182 103.973 3.24752C103.973 4.02585 103.762 4.69683 103.313 5.2336C102.864 5.77037 102.309 6.03877 101.623 6.03877C100.936 6.03877 100.249 5.7167 99.5364 5.04572C98.8498 4.37476 98.2952 4.05269 97.899 4.05269C97.2652 4.05269 96.4993 4.58946 95.5486 5.63618C94.6243 6.70974 94.1489 7.81014 94.1489 8.93738V21.659C94.1489 23.2694 94.5186 24.3698 95.2845 24.987C96.0239 25.6044 97.2915 25.8996 99.0346 25.8728V26.7854H85.1433V25.8728ZM114.537 0.161033C114.774 0.080517 114.748 0.429424 114.748 0.590458V20.9076C114.748 23.0546 115.012 24.3967 115.514 24.9334C116.042 25.4702 117.178 25.819 119 25.9801V26.8121H105.426V25.9801C107.433 25.7923 108.674 25.4433 109.202 24.9603C109.73 24.4503 109.968 23.1352 109.968 20.9345V7.24652C109.968 6.03877 109.889 5.17992 109.73 4.72366C109.44 3.94533 108.885 3.56959 107.987 3.56959C107.776 3.56959 107.591 3.59643 107.406 3.62327C107.221 3.6501 106.667 3.81113 105.743 4.07952V2.97913C105.743 2.95229 109.73 1.69086 114.537 0.161033Z"
                      fill="#526464"
                    />
                  </svg>
                </div>
                <div class="swiper-slide company-slide">
                  <svg
                    width="85"
                    height="35"
                    viewBox="0 0 85 35"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M85 0H0.0145502V3.07434H85V0ZM85 31.1566H0.0145502V34.2087H85V31.1566ZM81.9761 17.0644C81.9761 14.3987 81.7191 12.7683 79.9285 12.7683H78.4304V21.3249H79.9285C81.7191 21.3249 81.9761 19.6989 81.9761 17.0244V17.0644ZM85 17.0244C85 21.165 83.8339 24.2571 79.9285 24.2571H75.7385C75.7016 24.2597 75.6646 24.2534 75.63 24.2387C75.5953 24.224 75.5639 24.2012 75.5377 24.1718C75.5116 24.1424 75.4913 24.1071 75.4782 24.0682C75.4651 24.0292 75.4595 23.9876 75.4618 23.9461V10.1204C75.4595 10.0789 75.4651 10.0373 75.4782 9.99848C75.4913 9.95955 75.5116 9.92423 75.5377 9.89474C75.5639 9.86534 75.5953 9.8425 75.63 9.8278C75.6646 9.8131 75.7016 9.80691 75.7385 9.8095H79.9285C83.8339 9.8095 85 12.9193 85 17.0422V17.0244ZM69.4061 21.6492V23.9639C69.4084 24.0054 69.4029 24.047 69.3898 24.0859C69.3767 24.1248 69.3564 24.1602 69.3302 24.1896C69.3041 24.219 69.2726 24.2418 69.238 24.2565C69.2033 24.2712 69.1664 24.2775 69.1294 24.2749H61.0696C61.0327 24.2775 60.9957 24.2712 60.9611 24.2565C60.9265 24.2418 60.895 24.219 60.8689 24.1896C60.8427 24.1602 60.8223 24.1248 60.8093 24.0859C60.7962 24.047 60.7907 24.0054 60.793 23.9639V10.1204C60.7907 10.0789 60.7962 10.0373 60.8093 9.99848C60.8223 9.95955 60.8427 9.92423 60.8689 9.89474C60.895 9.86534 60.9265 9.8425 60.9611 9.8278C60.9957 9.8131 61.0327 9.80691 61.0696 9.8095H69.1136C69.1506 9.80691 69.1876 9.8131 69.2222 9.8278C69.2568 9.8425 69.2883 9.86534 69.3144 9.89474C69.3406 9.92423 69.3609 9.95955 69.374 9.99848C69.387 10.0373 69.3927 10.0789 69.3903 10.1204V12.4395C69.3927 12.481 69.387 12.5226 69.374 12.5615C69.3609 12.6005 69.3406 12.6358 69.3144 12.6652C69.2883 12.6947 69.2568 12.7174 69.2222 12.7321C69.1876 12.7469 69.1506 12.7531 69.1136 12.7505H63.7655V15.5494H68.663C68.7 15.5469 68.7369 15.5531 68.7715 15.5678C68.8062 15.5825 68.8377 15.6053 68.8638 15.6347C68.89 15.6642 68.9102 15.6995 68.9234 15.7384C68.9364 15.7774 68.942 15.8189 68.9397 15.8604V18.1751C68.942 18.2166 68.9364 18.2581 68.9234 18.2971C68.9102 18.336 68.89 18.3713 68.8638 18.4007C68.8377 18.4302 68.8062 18.4529 68.7715 18.4677C68.7369 18.4824 68.7 18.4886 68.663 18.486H63.7655V21.3694H69.1334C69.1698 21.3653 69.2065 21.3703 69.2409 21.384C69.2754 21.3977 69.3068 21.4197 69.3328 21.4485C69.3588 21.4774 69.3789 21.5123 69.3916 21.5508C69.4042 21.5893 69.4092 21.6306 69.4061 21.6714V21.6492ZM54.8716 20.1743C54.8716 23.2841 53.2154 24.617 49.9741 24.617C46.9502 24.617 45.4639 23.4618 45.2308 20.5697C45.2229 20.5275 45.2238 20.4837 45.2332 20.4419C45.2426 20.4002 45.2604 20.3613 45.2851 20.3283C45.3098 20.2954 45.341 20.2691 45.3761 20.2517C45.4111 20.2343 45.4493 20.226 45.4876 20.2276H47.7012C47.8673 20.2276 47.9305 20.3431 47.978 20.5075C48.2191 21.2494 48.8041 21.6137 49.9543 21.6137C51.1876 21.6137 51.9505 21.2227 51.9505 20.2809C51.9505 19.339 51.6738 18.8059 49.8911 18.4105C47.6103 17.904 45.4047 16.8423 45.4047 13.9279C45.4047 11.2623 46.8475 9.61839 49.8911 9.61839C52.6028 9.61839 54.2392 10.7735 54.4685 13.5636C54.4772 13.6075 54.4772 13.6531 54.4685 13.6971C54.4598 13.7411 54.4425 13.7823 54.418 13.8179C54.3935 13.8536 54.3623 13.8827 54.3266 13.9033C54.2909 13.9238 54.2516 13.9352 54.2115 13.9367H52.1916C52.0257 13.9367 51.9624 13.7901 51.915 13.6257C51.741 13.026 51.16 12.595 49.9662 12.595C48.8713 12.595 48.3218 13.1637 48.3218 13.9279C48.3218 14.5454 48.2863 15.1896 49.9228 15.5406C52.334 16.0426 54.8796 16.9933 54.8796 20.1654L54.8716 20.1743ZM33.562 16.6379H35.4989C36.6097 16.6379 37.0445 16.4202 37.0445 14.6876C37.0445 12.9549 36.6136 12.7461 35.4989 12.7461H33.562V16.6379ZM39.7442 24.2749H37.4635C37.3939 24.2808 37.3246 24.2604 37.2666 24.2169C37.2085 24.1735 37.1652 24.1094 37.1433 24.035L35.3882 19.5923H33.5581V23.9816C33.5604 24.0231 33.5548 24.0647 33.5417 24.1037C33.5287 24.1426 33.5084 24.1779 33.4822 24.2073C33.456 24.2368 33.4246 24.2595 33.39 24.2743C33.3554 24.2889 33.3183 24.2952 33.2814 24.2926H30.8464C30.8092 24.2951 30.7718 24.2889 30.7368 24.2743C30.7018 24.2596 30.6699 24.237 30.6432 24.2077C30.6164 24.1785 30.5953 24.1432 30.5813 24.1043C30.5674 24.0654 30.5607 24.0236 30.5619 23.9816V10.1204C30.5607 10.0785 30.5674 10.0368 30.5813 9.99783C30.5953 9.95891 30.6164 9.92368 30.6432 9.89446C30.6699 9.86516 30.7018 9.8425 30.7368 9.8279C30.7718 9.81329 30.8092 9.807 30.8464 9.8095H35.4792C38.9536 9.8095 39.8628 11.5865 39.8628 14.6964C39.8628 16.8644 39.4201 18.375 37.9971 19.0947L39.9379 23.9062C40.0249 24.1283 39.9379 24.2749 39.7284 24.2749H39.7442ZM24.4746 21.6492V23.9639C24.4769 24.0054 24.4713 24.047 24.4582 24.0859C24.4451 24.1248 24.4248 24.1602 24.3986 24.1896C24.3725 24.219 24.341 24.2418 24.3064 24.2565C24.2718 24.2712 24.2348 24.2775 24.1978 24.2749H16.138C16.1011 24.2775 16.0641 24.2712 16.0295 24.2565C15.9949 24.2418 15.9634 24.219 15.9373 24.1896C15.9111 24.1602 15.8908 24.1248 15.8777 24.0859C15.8646 24.047 15.8591 24.0054 15.8614 23.9639V10.1204C15.8591 10.0789 15.8646 10.0373 15.8777 9.99848C15.8908 9.95955 15.9111 9.92423 15.9373 9.89474C15.9634 9.86534 15.9949 9.8425 16.0295 9.8278C16.0641 9.8131 16.1011 9.80691 16.138 9.8095H24.182C24.2189 9.80691 24.256 9.8131 24.2906 9.8278C24.3252 9.8425 24.3566 9.86534 24.3829 9.89474C24.409 9.92423 24.4293 9.95955 24.4424 9.99848C24.4555 10.0373 24.4611 10.0789 24.4587 10.1204V12.4395C24.4611 12.481 24.4555 12.5226 24.4424 12.5615C24.4293 12.6005 24.409 12.6358 24.3829 12.6652C24.3566 12.6947 24.3252 12.7174 24.2906 12.7321C24.256 12.7469 24.2189 12.7531 24.182 12.7505H18.8299V15.5494H23.7314C23.7684 15.5469 23.8054 15.5531 23.8399 15.5678C23.8746 15.5825 23.9061 15.6053 23.9322 15.6347C23.9584 15.6642 23.9787 15.6995 23.9918 15.7384C24.0048 15.7774 24.0104 15.8189 24.0081 15.8604V18.1751C24.0104 18.2166 24.0048 18.2581 23.9918 18.2971C23.9787 18.336 23.9584 18.3713 23.9322 18.4007C23.9061 18.4302 23.8746 18.4529 23.8399 18.4677C23.8054 18.4824 23.7684 18.4886 23.7314 18.486H18.8299V21.3694H24.1978C24.2343 21.3654 24.2712 21.3704 24.3059 21.3841C24.3405 21.3978 24.372 21.4197 24.3984 21.4484C24.4247 21.4772 24.4451 21.512 24.4583 21.5505C24.4714 21.589 24.477 21.6303 24.4746 21.6714V21.6492ZM7.56442 9.8095H10.035C10.2365 9.8095 10.2918 9.95604 10.2563 10.1605L7.29562 24.0217C7.27743 24.0975 7.2363 24.1638 7.17931 24.2092C7.12231 24.2546 7.05302 24.2763 6.98335 24.2705H3.28748C3.21781 24.2763 3.14852 24.2546 3.09152 24.2092C3.03453 24.1638 2.9934 24.0975 2.97521 24.0217L0.0145502 10.1605C-0.0328834 9.95604 0.0343149 9.8095 0.235908 9.8095H2.69851C2.76891 9.79886 2.84028 9.81856 2.89823 9.86479C2.95619 9.91092 2.9964 9.98008 3.01078 10.0583L4.98718 20.8007H5.26388L7.24028 10.0583C7.25466 9.98008 7.29488 9.91092 7.35283 9.86479C7.41078 9.81856 7.48216 9.79886 7.55255 9.8095"
                      fill="#526464"
                    />
                  </svg>
                </div>
                <div class="swiper-slide company-slide">
                  <svg
                    width="134"
                    height="29"
                    viewBox="0 0 134 29"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M82.9369 12.3596L75.6866 4.97722V4.92606C75.2455 4.50067 74.6618 4.26891 74.0586 4.27965C73.4553 4.2904 72.8797 4.5428 72.4531 4.98364C72.0265 5.42447 71.7822 6.01928 71.7718 6.64263C71.7614 7.26597 71.9857 7.86913 72.3974 8.32489L72.4469 8.36874L79.5912 15.8535H82.9723V12.3596H82.9369Z"
                      fill="#526464"
                    />
                    <path
                      d="M84.1758 20.59L91.412 27.9725L91.4615 28.0236C91.8977 28.4734 92.4889 28.7256 93.1051 28.725C93.7213 28.7243 94.3119 28.4707 94.7472 28.02C95.1824 27.5693 95.4265 26.9583 95.4259 26.3216C95.4252 25.6849 95.1798 25.0745 94.7436 24.6248L94.7012 24.5809L87.5569 17.0962H84.1758V20.59Z"
                      fill="#526464"
                    />
                    <path
                      d="M87.5357 15.8535L94.68 8.36874L94.7295 8.32489C95.1412 7.86913 95.3654 7.26597 95.355 6.64263C95.3446 6.01928 95.1004 5.42447 94.6738 4.98364C94.2472 4.5428 93.6715 4.2904 93.0683 4.27965C92.4651 4.26891 91.8814 4.50067 91.4403 4.92606L91.3979 4.97722L84.1758 12.3596V15.8535H87.5357Z"
                      fill="#526464"
                    />
                    <path
                      d="M79.5572 17.0962L72.42 24.5736L72.3704 24.6175C71.9343 25.0721 71.6907 25.6871 71.6934 26.3272C71.6947 26.6442 71.7564 26.9578 71.875 27.2501C71.9936 27.5424 72.1668 27.8077 72.3846 28.0309C72.6024 28.2541 72.8607 28.4307 73.1446 28.5508C73.4285 28.6708 73.7325 28.7319 74.0392 28.7306C74.6587 28.7278 75.2518 28.4709 75.6879 28.0163L75.7304 27.9651L82.9737 20.59V17.0889H79.5855L79.5572 17.0962Z"
                      fill="#526464"
                    />
                    <path
                      d="M19.1622 25.0856L18.3063 12.4258C18.2073 10.964 18.1436 9.73602 18.1436 8.47151C17.8748 9.83835 17.6768 10.6643 17.2806 12.1262L13.6519 25.0856H9.73318L6.46521 12.6597C6.16812 11.4976 5.75785 9.83104 5.53858 8.4642C5.53858 9.86759 5.47491 11.2637 5.37588 12.7255L4.58365 25.0856H0L2.12206 1.39609H8.02846L11.0276 13.2591C11.3557 14.4937 11.6201 15.7453 11.8199 17.0088C12.0388 15.7106 12.3221 14.4249 12.6687 13.1568L15.7669 1.39609H21.6379L23.6822 25.0856H19.1622ZM39.2369 25.97C38.2345 25.5669 37.3958 24.8215 36.8602 23.8576C36.5442 24.1914 36.2037 24.4993 35.8416 24.7786C34.8296 25.4514 33.6416 25.7857 32.4392 25.7361C28.6832 25.7361 26.6389 23.7553 26.6389 20.2834C26.6389 16.1901 29.3764 14.2824 34.7523 14.2824H35.7426V13.5515C35.7426 11.6072 35.3747 10.9567 33.762 10.9567C32.3473 10.9567 30.6921 11.6876 28.8812 12.9375L26.9997 9.66293C27.8658 9.088 28.7823 8.59855 29.7371 8.20106C31.1911 7.53134 32.7643 7.1828 34.3561 7.17776C37.1856 7.17776 39.1379 8.26685 39.7957 10.2111C40.0954 11.2256 40.1964 12.2916 40.0928 13.3468L39.9937 19.1943C39.9937 21.102 40.0928 21.9206 41.5782 23.0828L39.2369 25.97ZM35.4738 17.4473C32.4109 17.4473 31.3499 18.0321 31.3499 20.1079C31.3215 20.3924 31.3504 20.6798 31.4345 20.9521C31.5187 21.2245 31.6564 21.476 31.8391 21.6908C32.0217 21.9056 32.2453 22.079 32.4958 22.2004C32.7464 22.3217 33.0185 22.3882 33.2951 22.3958C33.7402 22.3735 34.1759 22.2554 34.5742 22.049C34.9726 21.8426 35.3247 21.5524 35.6082 21.197L35.6718 17.4473H35.4738ZM49.5147 25.4949C47.2724 25.4949 45.4899 24.4716 44.9664 22.9366C44.6797 22.0729 44.5784 21.1551 44.6694 20.2468V10.7447H42.9859V7.63824H44.6694C44.6337 6.25944 44.6881 4.87973 44.832 3.50848L49.3167 2.35361C49.144 4.10952 49.0566 5.87329 49.0549 7.63824H53.009L51.8914 10.7739H49.062V19.5451C49.062 21.7379 49.4581 22.3373 50.9719 22.3373C51.5124 22.3006 52.0456 22.1875 52.5563 22.0011L53.1151 24.7274C51.976 25.2271 50.7522 25.488 49.5147 25.4949ZM63.3293 11.6218C62.9382 11.3897 62.4928 11.2733 62.0419 11.2856C61.5145 11.3055 60.9981 11.4471 60.5306 11.7001C60.063 11.953 59.6562 12.3109 59.3399 12.7475V25.0856H54.9189V13.4272C54.9823 11.6981 54.772 9.96984 54.2964 8.3107L58.2505 7.22161C58.673 7.98061 58.9155 8.83227 58.9579 9.70678C59.9128 8.37649 61.2709 7.22161 62.9191 7.22161C63.49 7.20092 64.0568 7.32912 64.5672 7.59439L63.3293 11.6218ZM67.9766 5.65742C67.619 5.65551 67.2652 5.58082 66.9355 5.43763C66.6058 5.29443 66.3067 5.08554 66.0551 4.82287C65.8035 4.5602 65.6045 4.2489 65.4694 3.90674C65.3342 3.56458 65.2656 3.19827 65.2675 2.82871C65.2749 2.07455 65.5706 1.35401 66.09 0.824143C66.6094 0.294275 67.3104 -0.0019586 68.0403 9.7467e-06C68.3975 0.000944476 68.7511 0.0750715 69.0804 0.218102C69.4097 0.361133 69.7084 0.570228 69.959 0.83329C70.2096 1.09635 70.4073 1.40816 70.5405 1.75067C70.6738 2.09318 70.74 2.45959 70.7353 2.82871C70.7363 3.20231 70.6654 3.57239 70.5269 3.91746C70.3883 4.26254 70.1848 4.57574 69.9281 4.83889C69.6715 5.10205 69.3669 5.30991 69.0318 5.45042C68.6968 5.59093 68.3382 5.66129 67.9766 5.65742ZM65.7838 25.0856V7.93793L70.2048 7.207V25.0856H65.7838ZM99.1002 5.65742C98.7429 5.65551 98.3895 5.58077 98.0602 5.43749C97.7308 5.29421 97.4321 5.08519 97.1811 4.82243C96.9301 4.55966 96.7318 4.2483 96.5974 3.90618C96.463 3.56407 96.3953 3.19792 96.3981 2.82871C96.4037 2.07522 96.6978 1.35467 97.2161 0.824594C97.7343 0.294523 98.4346 -0.00194463 99.1638 9.7467e-06C99.5211 0.000944476 99.8746 0.0750715 100.204 0.218102C100.533 0.361133 100.832 0.570228 101.083 0.83329C101.333 1.09635 101.531 1.40816 101.664 1.75067C101.797 2.09318 101.864 2.45959 101.859 2.82871C101.86 3.20231 101.789 3.57239 101.65 3.91746C101.512 4.26254 101.308 4.57574 101.052 4.83889C100.795 5.10205 100.49 5.30991 100.155 5.45042C99.8204 5.59093 99.4617 5.66129 99.1002 5.65742ZM96.9074 25.0856V7.93793L101.321 7.207V25.0856H96.9074ZM116.218 25.97C115.216 25.5669 114.377 24.8215 113.841 23.8576C113.527 24.1931 113.186 24.5011 112.823 24.7786C111.811 25.4514 110.623 25.7857 109.42 25.7361C105.664 25.7361 103.62 23.7553 103.62 20.2834C103.62 16.1901 106.358 14.2824 111.734 14.2824H112.724V13.5515C112.724 11.6072 112.356 10.9567 110.743 10.9567C109.329 10.9567 107.673 11.6876 105.862 12.9375L103.981 9.71409C104.847 9.13916 105.764 8.64972 106.718 8.25223C108.172 7.58251 109.746 7.23396 111.337 7.22892C114.167 7.22892 116.119 8.31801 116.777 10.2623C117.077 11.2767 117.178 12.3427 117.074 13.398L116.975 19.2454C116.975 21.1532 117.074 21.9718 118.559 23.134L116.218 25.97ZM112.469 17.4473C109.406 17.4473 108.352 18.0321 108.352 20.1079C108.323 20.3926 108.351 20.6804 108.435 20.9533C108.519 21.2261 108.656 21.478 108.839 21.693C109.022 21.9081 109.246 22.0816 109.497 22.2025C109.748 22.3235 110.021 22.3893 110.298 22.3958C110.739 22.3705 111.171 22.251 111.565 22.0447C111.96 21.8383 112.308 21.5497 112.589 21.197L112.653 17.4473H112.469ZM129.644 25.0856V13.7342C129.644 11.7607 129.311 11.176 128.158 11.176C126.992 11.3229 125.908 11.8774 125.088 12.7475V25.0856H120.667V12.4258C120.689 11.0369 120.488 9.65393 120.073 8.33263L123.999 7.17776C124.39 7.83969 124.607 8.59549 124.629 9.37055C125.252 8.89979 125.901 8.46778 126.574 8.0768C127.519 7.60005 128.556 7.35018 129.608 7.34587C131.49 7.34587 133.145 8.36187 133.669 9.86759C133.918 10.6697 134.028 11.511 133.994 12.3528V25.0856H129.644Z"
                      fill="#526464"
                    />
                  </svg>
                </div>
                <div class="swiper-slide company-slide">
                  <svg
                    width="93"
                    height="33"
                    viewBox="0 0 93 33"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M92.9922 22.6145C92.5889 23.0833 92.2601 23.673 91.7684 23.9969C90.6562 24.7316 89.5315 24.3288 88.5403 22.9818C84.4219 24.7912 80.8914 24.0323 78.6313 20.8535C77.621 19.4268 77.0984 17.6905 77.1465 15.9202C77.1945 14.1499 77.8105 12.4469 78.8965 11.0817C80.0478 9.64534 81.6539 8.68172 83.427 8.36346C85.2 8.0452 87.0243 8.3931 88.5729 9.34482C89.7689 8.05588 90.7291 7.74493 91.8009 8.47318C92.288 8.80347 92.606 9.40121 93 9.87812L92.9922 22.6145ZM81.1566 16.1794C81.175 17.1564 81.5625 18.0867 82.2355 18.7695C82.9085 19.4523 83.8131 19.8327 84.7539 19.8287C86.7006 19.8142 88.3449 18.1225 88.334 16.1424C88.3232 14.1622 86.6727 12.4463 84.7585 12.4367C83.8038 12.4396 82.8891 12.835 82.2142 13.5363C81.5393 14.2376 81.1591 15.1879 81.1566 16.1794ZM63.5568 23.8454V28.4534C63.5568 28.8562 63.5708 29.259 63.5568 29.6618C63.4885 31.0393 62.5144 32.0012 61.1881 32.0173C59.8619 32.0334 58.8226 31.0796 58.7372 29.7407C58.6829 28.8852 58.7124 28.0216 58.7109 27.1628C58.7109 21.8459 58.7248 16.5291 58.7 11.2122C58.7 10.0215 58.942 9.0097 60.0201 8.43129C61.0485 7.87704 62.0009 8.07522 62.8944 8.83891C63.034 8.95653 63.4125 8.87436 63.6344 8.77447C68.2724 6.67994 73.6256 9.45922 74.6401 14.5425C75.2481 17.5876 74.457 20.2702 72.2435 22.3712C69.9849 24.5157 67.3184 25.0506 64.3867 24.1225C64.1587 24.0436 63.9415 23.9679 63.5568 23.8454ZM66.9182 12.4061C66.4212 12.4012 65.9282 12.4985 65.4675 12.6923C65.0069 12.8862 64.5877 13.1729 64.2342 13.5357C63.8806 13.8986 63.5997 14.3305 63.4076 14.8067C63.2154 15.2828 63.1159 15.7937 63.1147 16.3099C63.1114 17.0851 63.3292 17.8438 63.7408 18.4904C64.1524 19.137 64.7393 19.6424 65.4272 19.9428C66.1152 20.2431 66.8734 20.325 67.6062 20.178C68.3389 20.031 69.0133 19.6618 69.5441 19.117C70.0749 18.5722 70.4384 17.8762 70.5886 17.1169C70.7388 16.3576 70.669 15.5691 70.388 14.851C70.1071 14.133 69.6275 13.5174 69.0099 13.0823C68.3924 12.6471 67.6645 12.4118 66.9182 12.4061ZM44.4306 23.8454C44.4306 25.8481 44.4476 27.7251 44.4228 29.6021C44.4245 30.1036 44.2738 30.5927 43.9922 31C43.7106 31.4074 43.3125 31.712 42.8546 31.8707C41.8711 32.1929 40.8939 32.0705 40.247 31.194C39.8612 30.6673 39.6389 30.0312 39.6095 29.3701C39.5629 23.1687 39.5831 16.9641 39.58 10.7659C39.58 9.70895 39.9756 8.88403 40.8985 8.40067C41.8215 7.91732 42.7786 8.0011 43.5728 8.71324C43.9823 9.07898 44.2708 8.86469 44.6167 8.71324C49.23 6.7315 54.3892 9.42055 55.4596 14.4136C56.1281 17.5199 55.3355 20.2299 53.0723 22.3744C50.8091 24.5189 48.1891 25.0232 45.2946 24.1274C45.0448 24.0533 44.8044 23.9727 44.4306 23.8454ZM47.7113 20.2074C48.4549 20.2109 49.1828 19.9852 49.8028 19.559C50.4229 19.1327 50.9073 18.525 51.1947 17.8127C51.4822 17.1005 51.5598 16.3156 51.4177 15.5575C51.2756 14.7995 50.9202 14.1022 50.3965 13.5539C49.8728 13.0057 49.2043 12.6311 48.4755 12.4776C47.7468 12.324 46.9906 12.3985 46.3026 12.6914C45.6146 12.9844 45.0258 13.4828 44.6105 14.1234C44.1953 14.7641 43.9723 15.5183 43.9699 16.2906C43.9637 18.3948 45.687 20.1993 47.7113 20.2138V20.2074ZM20.5887 11.1671V2.70355C20.5918 1.06338 21.5613 0 23.0319 0C24.5024 0 25.4533 1.10043 25.4533 2.72772C25.4533 7.96727 25.4641 13.2004 25.444 18.4464C25.444 19.1327 25.5634 19.5742 26.2583 19.8626C27.3923 20.3459 27.8902 21.6139 27.5458 22.7998C27.385 23.3864 27.0279 23.8941 26.5388 24.2317C26.0498 24.5693 25.4608 24.7145 24.8778 24.6413C22.2857 24.3481 20.6151 22.4179 20.5934 19.6306C20.5701 16.8094 20.5887 13.9882 20.5887 11.1671ZM11.9688 16.3567L15.7924 19.9963C16.9915 21.1386 17.142 22.724 16.157 23.839C15.172 24.9539 13.644 24.9297 12.4341 23.789C10.5199 21.9909 8.6068 20.1918 6.69469 18.3916C5.45374 17.2219 5.44288 15.5672 6.67763 14.3862C8.61145 12.5344 10.5541 10.6896 12.5055 8.8518C13.6549 7.7707 15.2092 7.80776 16.1725 8.90497C17.1358 10.0022 17.0117 11.5457 15.8886 12.6365C14.6104 13.8771 13.3059 15.0903 11.9688 16.3567ZM30.777 16.3035C30.777 14.4523 30.7677 12.5978 30.777 10.7498C30.7863 9.15954 31.8054 8.09294 33.2822 8.10261C34.7061 8.11066 35.7144 9.18371 35.7191 10.7385C35.7284 14.47 35.7284 18.2004 35.7191 21.9297C35.7191 23.5103 34.6472 24.6687 33.2527 24.6574C31.8209 24.6397 30.7847 23.5151 30.7708 21.9394C30.7692 20.0608 30.777 18.1821 30.777 16.3035ZM0.0183553 6.48337C0.0183553 5.24921 0.0028434 4.01505 0.0183553 2.77767C0.0524816 1.05854 1.00957 0 2.48165 0C3.99096 0.00805588 4.96356 1.12782 4.97287 2.84695C4.97287 5.37005 4.98217 7.89315 4.97287 10.4195C4.9829 10.9601 4.82595 11.4899 4.52504 11.9312C4.22412 12.3725 3.79504 12.7021 3.30068 12.8717C2.30016 13.2116 1.14918 12.9361 0.589195 12.0516C0.268615 11.5122 0.0810698 10.8991 0.0431744 10.2664C-0.0374876 9.01131 0.0199065 7.74493 0.0183553 6.48337Z"
                      fill="#526464"
                    />
                    <path
                      d="M4.8452 21.9778C4.8452 23.5294 3.92379 24.5235 2.47652 24.5218C1.09906 24.5218 0.115607 23.4875 0.109402 22.0326C0.103198 20.5777 1.15025 19.4418 2.50445 19.4547C3.85864 19.4676 4.84209 20.5213 4.8452 21.9778Z"
                      fill="#526464"
                    />
                  </svg>
                </div>
                <div class="swiper-slide company-slide">
                  <svg
                    width="146"
                    height="27"
                    viewBox="0 0 146 27"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M0 0.174715H3.4543L8.72069 14.6281L13.8738 0.174715H17.3282V26.7109H13.8738V9.54045L10.0231 21.1031H7.305L3.4543 9.54045V26.7688H0V0.174715ZM24.803 0.174715H29.4465L34.3731 26.7109H30.6923L29.673 20.9875H25.0295L25.4825 18.7327C25.6524 17.9234 26.0488 17.5187 26.7283 17.5187H29.0501L27.0681 6.36072L23.3873 26.7109H19.7065L24.803 0.174715ZM36.9214 0.174715H40.2624L46.3217 16.5936V0.174715H49.8325V26.7109H46.718L40.4324 9.71389V26.7688H36.9214V0.174715ZM53.4568 21.5078L53.4001 19.0796H57.1942L57.2507 21.6812C57.2507 22.8953 58.1002 23.5312 59.2894 23.5312H60.0256C61.2714 23.5312 62.0642 22.8953 62.0642 21.6812V19.1374C62.0642 16.6514 60.6484 16.2468 57.5906 14.4546C53.7399 12.4311 53.4568 11.1592 53.4568 8.32638V5.49353C53.4568 1.85129 55.7218 -0.0565371 58.893 0.00127603H60.0256C63.1967 0.00127603 65.6318 1.85129 65.6318 5.49353V7.74823C65.6318 8.49981 65.1787 8.90451 64.3858 9.02013L61.8942 9.54045V5.26227C61.8942 4.0482 61.0448 3.41225 59.8556 3.41225H59.1195C57.8737 3.41225 57.1942 4.0482 57.1942 5.26227V8.32638C57.1942 10.0608 58.0436 10.6389 59.2328 11.3904L62.4039 13.0092C65.4052 14.5124 65.8016 16.2468 65.8016 18.7327V21.5078C65.8016 25.1501 63.4232 27 60.1954 27H59.0629C55.8351 26.9422 53.4568 25.0922 53.4568 21.5078ZM69.3692 21.5078V5.49353C69.3692 1.85129 71.5776 -0.0565371 74.8055 0.00127603H75.938C79.1091 0.00127603 81.3743 1.67786 81.3743 5.26227V8.0373C81.3743 8.78887 80.9212 9.19357 80.1285 9.30919L77.6368 9.88732V5.26227C77.6368 4.0482 76.9573 3.41225 75.7114 3.41225H74.9753C73.7295 3.41225 73.1066 4.0482 73.1066 5.26227V21.739C73.1066 22.9531 73.7295 23.5891 74.9753 23.5891H75.7114C76.9573 23.5891 77.6368 22.9531 77.6368 21.739V19.0796H81.4309L81.3743 21.4499C81.3743 25.0921 79.1657 26.9422 75.938 26.9422H74.8055C71.5776 26.9422 69.3692 25.0922 69.3692 21.5078ZM88.4527 0.174715H93.0962L98.0228 26.7109H94.342L93.3228 20.9875H88.6793L89.1322 18.7327C89.3022 17.9234 89.6419 17.5187 90.3782 17.5187H92.6998L90.7179 6.36072L87.037 26.7109H83.3562L88.4527 0.174715ZM100.628 0.174715H107.536C110.708 0.116902 112.973 1.96692 112.973 5.66697V12.1999C112.973 15.8421 110.764 17.7499 107.536 17.6343H104.931V15.4952C104.931 14.4546 105.271 14.1655 106.234 14.1655H107.31C108.556 14.1655 109.178 13.5295 109.178 12.3155V5.43572C109.178 4.22163 108.556 3.58569 107.31 3.58569H104.422V26.7688H100.628V0.174715ZM116.484 0.174715H127.016V3.81695H120.164V23.0688H126.96V26.7109H116.427L116.484 0.174715ZM120.731 12.6624C120.731 11.6217 121.07 11.3326 122.033 11.3326H126.394V14.9749H120.731V12.6624ZM130.584 0.174715H137.492C140.664 0.116902 142.929 1.96692 142.929 5.66697V21.3343C142.929 24.9765 140.72 26.8844 137.492 26.8266H130.584V0.174715ZM137.266 23.3C138.511 23.3 139.135 22.6641 139.135 21.4499V5.43572C139.135 4.22163 138.511 3.58569 137.266 3.58569H134.378V23.3578H137.266V23.3ZM143.382 0.348155H142.872V0.174715H144.118V0.348155H143.608V1.96692H143.382V0.348155ZM144.288 0.174715H144.571L145.08 1.56223L145.591 0.174715H145.874V1.96692H145.647V0.463781L145.08 1.96692H145.024L144.402 0.463781V1.96692H144.231L144.288 0.174715Z"
                      fill="#526464"
                    />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="testimoni">
      <div class="container overflow-hide">
        <div class="inner-testimoni">
          <div class="testimoni-title">
            <div>
              <span>TESTIMONIALS</span>
              <h2 class="text-h2 text-white">What Our Client Say!</h2>
            </div>
          </div>

          <!-- Swiper -->
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <!-- testimoni single start -->
                <div class="testimoni-single-card">
                  <div class="rating">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </div>
                  <p class="text-para text-white fix-height">
                    Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's
                    standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a
                    type.
                  </p>
                  <div class="client-info">
                    <img
                      src="<?= base_url()?>assets/website/img/67ffd9ab33f677397c671e58bef352ebc410bf03.png"
                      alt="client"
                    />
                    <div>
                      <h4 class="text-h4">Alison Jordon</h4>
                      <span>Hook - USA</span>
                    </div>
                  </div>
                </div>
                <!-- testimoni single end -->
              </div>
              <div class="swiper-slide">
                <!-- testimoni single start -->
                <div class="testimoni-single-card">
                  <div class="rating">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </div>
                  <p class="text-para text-white fix-height">
                    Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's
                    standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a
                    type.
                  </p>
                  <div class="client-info">
                    <img
                      src="<?= base_url()?>assets/website/img/67ffd9ab33f677397c671e58bef352ebc410bf03.png"
                      alt="client"
                    />
                    <div>
                      <h4 class="text-h4">Alison Jordon</h4>
                      <span>Hook - USA</span>
                    </div>
                  </div>
                </div>
                <!-- testimoni single end -->
              </div>
              <div class="swiper-slide">
                <!-- testimoni single start -->
                <div class="testimoni-single-card">
                  <div class="rating">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </div>
                  <p class="text-para text-white fix-height">
                    Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's
                    standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a
                    type.
                  </p>
                  <div class="client-info">
                    <img
                      src="<?= base_url()?>assets/website/img/67ffd9ab33f677397c671e58bef352ebc410bf03.png"
                      alt="client"
                    />
                    <div>
                      <h4 class="text-h4">Alison Jordon</h4>
                      <span>Hook - USA</span>
                    </div>
                  </div>
                </div>
                <!-- testimoni single end -->
              </div>
              <div class="swiper-slide">
                <!-- testimoni single start -->
                <div class="testimoni-single-card">
                  <div class="rating">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </div>
                  <p class="text-para text-white fix-height">
                    Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's
                    standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a
                    type.
                  </p>
                  <div class="client-info">
                    <img
                      src="<?= base_url()?>assets/website/img/67ffd9ab33f677397c671e58bef352ebc410bf03.png"
                      alt="client"
                    />
                    <div>
                      <h4 class="text-h4">Alison Jordon</h4>
                      <span>Hook - USA</span>
                    </div>
                  </div>
                </div>
                <!-- testimoni single end -->
              </div>
              <div class="swiper-slide">
                <!-- testimoni single start -->
                <div class="testimoni-single-card">
                  <div class="rating">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </div>
                  <p class="text-para text-white fix-height">
                    Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's
                    standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a
                    type.
                  </p>
                  <div class="client-info">
                    <img
                      src="<?= base_url()?>assets/website/img/67ffd9ab33f677397c671e58bef352ebc410bf03.png"
                      alt="client"
                    />
                    <div>
                      <h4 class="text-h4">Alison Jordon</h4>
                      <span>Hook - USA</span>
                    </div>
                  </div>
                </div>
                <!-- testimoni single end -->
              </div>
              <div class="swiper-slide">
                <!-- testimoni single start -->
                <div class="testimoni-single-card">
                  <div class="rating">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </div>
                  <p class="text-para text-white fix-height">
                    Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's
                    standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a
                    type.
                  </p>
                  <div class="client-info">
                    <img
                      src="<?= base_url()?>assets/website/img/67ffd9ab33f677397c671e58bef352ebc410bf03.png"
                      alt="client"
                    />
                    <div>
                      <h4 class="text-h4">Alison Jordon</h4>
                      <span>Hook - USA</span>
                    </div>
                  </div>
                </div>
                <!-- testimoni single end -->
              </div>
              <div class="swiper-slide">
                <!-- testimoni single start -->
                <div class="testimoni-single-card">
                  <div class="rating">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </div>
                  <p class="text-para text-white fix-height">
                    Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's
                    standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a
                    type.
                  </p>
                  <div class="client-info">
                    <img
                      src="<?= base_url()?>assets/website/img/67ffd9ab33f677397c671e58bef352ebc410bf03.png"
                      alt="client"
                    />
                    <div>
                      <h4 class="text-h4">Alison Jordon</h4>
                      <span>Hook - USA</span>
                    </div>
                  </div>
                </div>
                <!-- testimoni single end -->
              </div>
              <div class="swiper-slide">
                <!-- testimoni single start -->
                <div class="testimoni-single-card">
                  <div class="rating">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </div>
                  <p class="text-para text-white fix-height">
                    Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's
                    standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a
                    type.
                  </p>
                  <div class="client-info">
                    <img
                      src="<?= base_url()?>assets/website/img/67ffd9ab33f677397c671e58bef352ebc410bf03.png"
                      alt="client"
                    />
                    <div>
                      <h4 class="text-h4">Alison Jordon</h4>
                      <span>Hook - USA</span>
                    </div>
                  </div>
                </div>
                <!-- testimoni single end -->
              </div>
              <div class="swiper-slide">
                <!-- testimoni single start -->
                <div class="testimoni-single-card">
                  <div class="rating">
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <svg
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16L6.71043 19.28L8.20043 13.24L3.44043 9.22L9.65043 8.76L12.0004 3Z"
                        fill="#34FF67"
                      />
                      <path
                        d="M12.0004 3L9.65043 8.76L3.44043 9.22L8.20043 13.24L6.71043 19.28L12.0004 16M12.0004 3L14.3504 8.76L20.5604 9.22L15.8004 13.24L17.2904 19.28L12.0004 16"
                        stroke="#34FF67"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </div>
                  <p class="text-para text-white fix-height">
                    Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's
                    standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a
                    type.
                  </p>
                  <div class="client-info">
                    <img
                      src="<?= base_url()?>assets/website/img/67ffd9ab33f677397c671e58bef352ebc410bf03.png"
                      alt="client"
                    />
                    <div>
                      <h4 class="text-h4">Alison Jordon</h4>
                      <span>Hook - USA</span>
                    </div>
                  </div>
                </div>
                <!-- testimoni single end -->
              </div>
            </div>

            <!-- Navigation buttons -->
            <div class="swiper-button-next mySwiper-next">
              <svg
                width="14"
                height="12"
                viewBox="0 0 14 12"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M0.334579 6.53965C0.1203 6.3244 2.63713e-07 6.03304 2.50436e-07 5.72932C2.3716e-07 5.42559 0.1203 5.13423 0.334579 4.91898L4.91791 0.335651C5.02433 0.229237 5.15066 0.144824 5.2897 0.0872328C5.42873 0.0296417 5.57775 -2.43811e-07 5.72824 -2.5039e-07C6.03218 -2.63675e-07 6.32366 0.120737 6.53858 0.335651C6.75349 0.550565 6.87423 0.84205 6.87423 1.14598C6.87423 1.44992 6.75349 1.7414 6.53858 1.95632L3.91141 4.58348L12.1449 4.58348C12.4488 4.58348 12.7403 4.7042 12.9551 4.91909C13.17 5.13398 13.2907 5.42542 13.2907 5.72932C13.2907 6.03321 13.17 6.32466 12.9551 6.53954C12.7403 6.75443 12.4488 6.87515 12.1449 6.87515L3.91141 6.87515L6.53858 9.50232C6.64499 9.60873 6.72941 9.73507 6.787 9.8741C6.84459 10.0131 6.87423 10.1622 6.87423 10.3127C6.87423 10.4631 6.84459 10.6122 6.787 10.7512C6.72941 10.8902 6.64499 11.0166 6.53858 11.123C6.43216 11.2294 6.30583 11.3138 6.16679 11.3714C6.02776 11.429 5.87874 11.4586 5.72825 11.4586C5.57775 11.4586 5.42873 11.429 5.2897 11.3714C5.15066 11.3138 5.02433 11.2294 4.91791 11.123L0.334579 6.53965Z"
                  fill="#34FF67"
                ></path>
              </svg>
            </div>
            <div class="swiper-button-prev mySwiper-prev">
              <svg
                width="14"
                height="12"
                viewBox="0 0 14 12"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M0.334579 6.53965C0.1203 6.3244 2.63713e-07 6.03304 2.50436e-07 5.72932C2.3716e-07 5.42559 0.1203 5.13423 0.334579 4.91898L4.91791 0.335651C5.02433 0.229237 5.15066 0.144824 5.2897 0.0872328C5.42873 0.0296417 5.57775 -2.43811e-07 5.72824 -2.5039e-07C6.03218 -2.63675e-07 6.32366 0.120737 6.53858 0.335651C6.75349 0.550565 6.87423 0.84205 6.87423 1.14598C6.87423 1.44992 6.75349 1.7414 6.53858 1.95632L3.91141 4.58348L12.1449 4.58348C12.4488 4.58348 12.7403 4.7042 12.9551 4.91909C13.17 5.13398 13.2907 5.42542 13.2907 5.72932C13.2907 6.03321 13.17 6.32466 12.9551 6.53954C12.7403 6.75443 12.4488 6.87515 12.1449 6.87515L3.91141 6.87515L6.53858 9.50232C6.64499 9.60873 6.72941 9.73507 6.787 9.8741C6.84459 10.0131 6.87423 10.1622 6.87423 10.3127C6.87423 10.4631 6.84459 10.6122 6.787 10.7512C6.72941 10.8902 6.64499 11.0166 6.53858 11.123C6.43216 11.2294 6.30583 11.3138 6.16679 11.3714C6.02776 11.429 5.87874 11.4586 5.72825 11.4586C5.57775 11.4586 5.42873 11.429 5.2897 11.3714C5.15066 11.3138 5.02433 11.2294 4.91791 11.123L0.334579 6.53965Z"
                  fill="#34FF67"
                ></path>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- LATEST BLOGS -->
    <section class="blog">
      <div class="container">
        <div class="inner-blog">
          <div class="title">
            <div>
              <span class="sub-heading">LATEST BLOGS</span>
              <h2 class="text-h2">Articles & blog posts</h2>
            </div>
            <a href="#" class="btn-dark-green">VIEW ALL BLOGS</a>
          </div>

          <!-- all in one blogs -->
          <div class="all-blogs">
            <div class="single-blog">
              <img
                src="<?= base_url()?>assets/website/img/a8fb0faf6cb005ea88c490e3bb75944c28387f6d.webp"
                alt="blog img"
              />
              <div>
                <span class="text-para">Manufacturing</span>
                <svg
                  width="6"
                  height="6"
                  viewBox="0 0 6 6"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <circle cx="3" cy="3" r="3" fill="#1E1E1E" />
                </svg>

                <span class="text-para">Jan 18, 2025</span>
              </div>
              <h4 class="text-h4-blog text-gray-black">
                Top Manufacturing Trends Shaping Industry’s Future
              </h4>
              <p class="text-para">
                Lorem Ipsum is simply dummy text of the printing and typesetting
                industry. Lorem Ip sum has been the industry's standard Lorem
                Ipsum.
              </p>
            </div>
            <div class="multi-blog">
              <!-- multi-btn-single start -->
              <div class="multi-blog-list">
                <div>
                  <div>
                    <span class="text-para">Manufacturing</span>
                    <svg
                      width="6"
                      height="6"
                      viewBox="0 0 6 6"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <circle cx="3" cy="3" r="3" fill="#1E1E1E" />
                    </svg>

                    <span class="text-para">Jan 18, 2025</span>
                  </div>
                  <h4 class="text-h4-blog text-gray-black">
                    5 Key Strategies for Efficient Industrial Operation
                  </h4>
                </div>
                <div>
                  <img
                    src="<?= base_url()?>assets/website/img/50193dfd83f81eb22382fa2ba9a23ec1995409de.webp"
                    alt="blog img"
                  />
                </div>
              </div>
              <!-- multi-btn-single end -->
              <!-- multi-btn-single start -->
              <div class="multi-blog-list">
                <div>
                  <div>
                    <span class="text-para">INDUSTRY</span>
                    <svg
                      width="6"
                      height="6"
                      viewBox="0 0 6 6"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <circle cx="3" cy="3" r="3" fill="#1E1E1E" />
                    </svg>

                    <span class="text-para">Jan 18, 2025</span>
                  </div>
                  <h4 class="text-h4-blog text-gray-black">
                    Exploring the Future of Aerospace: What Lies Ahead?
                  </h4>
                </div>
                <div>
                  <img
                    src="<?= base_url()?>assets/website/img/3eb0df2ad59770f6c9e0df37622b7ec8c3295330.webp"
                    alt="blog img"
                  />
                </div>
              </div>
              <!-- multi-btn-single end -->
              <!-- multi-btn-single start -->
              <div class="multi-blog-list">
                <div>
                  <div>
                    <span class="text-para">Manufacturing</span>
                    <svg
                      width="6"
                      height="6"
                      viewBox="0 0 6 6"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <circle cx="3" cy="3" r="3" fill="#1E1E1E" />
                    </svg>

                    <span class="text-para">Jan 18, 2025</span>
                  </div>
                  <h4 class="text-h4-blog text-gray-black">
                    Boosting Manufacturing Efficiency with Top Innovation
                  </h4>
                </div>
                <div>
                  <img
                    src="<?= base_url()?>assets/website/img/cadab4537c0fef374c0b9268e36c86fd52c2eaee.webp"
                    alt="blog img"
                  />
                </div>
              </div>
              <!-- multi-btn-single end -->
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta">
      <div class="container">
        <div class="inner-cta">
          <div class="social">
            <h3 class="text-h3 text-white">FOLLOW US</h3>
            <!-- social links -->
            <div class="social-links">
              <a href="">
                <svg
                  width="21"
                  height="21"
                  viewBox="0 0 21 21"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M12.1711 2.46387C11.1198 2.46387 10.1114 2.88153 9.36798 3.62498C8.62453 4.36843 8.20686 5.37676 8.20686 6.42815V8.6353H6.08544C5.97915 8.6353 5.89258 8.72101 5.89258 8.82815V11.7424C5.89258 11.8487 5.97829 11.9353 6.08544 11.9353H8.20686V17.9139C8.20686 18.0202 8.29258 18.1067 8.39972 18.1067H11.314C11.4203 18.1067 11.5069 18.021 11.5069 17.9139V11.9353H13.6471C13.7354 11.9353 13.8126 11.8753 13.834 11.7896L14.5626 8.8753C14.5697 8.84686 14.5703 8.81716 14.5643 8.78846C14.5583 8.75976 14.5458 8.73282 14.5277 8.70967C14.5097 8.68653 14.4867 8.66781 14.4603 8.65492C14.434 8.64203 14.405 8.63532 14.3757 8.6353H11.5069V6.42815C11.5069 6.34092 11.524 6.25454 11.5574 6.17394C11.5908 6.09335 11.6397 6.02012 11.7014 5.95843C11.7631 5.89675 11.8363 5.84782 11.9169 5.81443C11.9975 5.78105 12.0839 5.76387 12.1711 5.76387H14.3997C14.506 5.76387 14.5926 5.67815 14.5926 5.57101V2.65672C14.5926 2.55044 14.5069 2.46387 14.3997 2.46387H12.1711Z"
                    fill="#34FF67"
                  />
                </svg>
              </a>
              <a href="">
                <svg
                  width="21"
                  height="21"
                  viewBox="0 0 21 21"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M12.986 7.20022C12.329 7.19797 11.6781 7.32528 11.0704 7.57486C10.4627 7.82445 9.91013 8.19141 9.4444 8.65475C8.97866 9.1181 8.60887 9.66873 8.35616 10.2751C8.10345 10.8816 7.9728 11.5318 7.97168 12.1888V17.2288C7.97168 17.4334 8.05296 17.6296 8.19763 17.7743C8.3423 17.919 8.53851 18.0002 8.74311 18.0002H10.5431C10.7477 18.0002 10.9439 17.919 11.0886 17.7743C11.2333 17.6296 11.3145 17.4334 11.3145 17.2288V12.1888C11.3144 11.9551 11.3634 11.7241 11.4586 11.5107C11.5537 11.2972 11.6927 11.1063 11.8666 10.9502C12.0405 10.7941 12.2453 10.6764 12.4677 10.6048C12.6901 10.5332 12.9251 10.5092 13.1574 10.5345C13.574 10.587 13.9568 10.7905 14.2333 11.1065C14.5098 11.4225 14.6607 11.8289 14.6574 12.2488V17.2288C14.6574 17.4334 14.7387 17.6296 14.8833 17.7743C15.028 17.919 15.2242 18.0002 15.4288 18.0002H17.2288C17.4334 18.0002 17.6296 17.919 17.7743 17.7743C17.919 17.6296 18.0003 17.4334 18.0003 17.2288V12.1888C17.9991 11.5318 17.8685 10.8816 17.6158 10.2751C17.3631 9.66873 16.9933 9.1181 16.5275 8.65475C16.0618 8.19141 15.5093 7.82445 14.9016 7.57486C14.2939 7.32528 13.6429 7.19797 12.986 7.20022Z"
                    fill="#34FF67"
                  />
                  <path
                    d="M5.657 7.97168H3.34272C2.91667 7.97168 2.57129 8.31706 2.57129 8.74311V17.2288C2.57129 17.6549 2.91667 18.0003 3.34272 18.0003H5.657C6.08305 18.0003 6.42843 17.6549 6.42843 17.2288V8.74311C6.42843 8.31706 6.08305 7.97168 5.657 7.97168Z"
                    fill="#34FF67"
                  />
                  <path
                    d="M4.49986 6.42843C5.56498 6.42843 6.42843 5.56498 6.42843 4.49986C6.42843 3.43474 5.56498 2.57129 4.49986 2.57129C3.43474 2.57129 2.57129 3.43474 2.57129 4.49986C2.57129 5.56498 3.43474 6.42843 4.49986 6.42843Z"
                    fill="#34FF67"
                  />
                </svg>
              </a>
              <a href="">
                <svg
                  width="21"
                  height="21"
                  viewBox="0 0 21 21"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M12.8571 3H7.71429C5.11066 3 3 5.11066 3 7.71429V12.8571C3 15.4608 5.11066 17.5714 7.71429 17.5714H12.8571C15.4608 17.5714 17.5714 15.4608 17.5714 12.8571V7.71429C17.5714 5.11066 15.4608 3 12.8571 3Z"
                    stroke="#34FF67"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M10.2862 13.377C11.9932 13.377 13.377 11.9932 13.377 10.2862C13.377 8.57914 11.9932 7.19531 10.2862 7.19531C8.57914 7.19531 7.19531 8.57914 7.19531 10.2862C7.19531 11.9932 8.57914 13.377 10.2862 13.377Z"
                    stroke="#34FF67"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M14.4805 6.97372C14.9681 6.97372 15.3634 6.57845 15.3634 6.09086C15.3634 5.60328 14.9681 5.20801 14.4805 5.20801C13.9929 5.20801 13.5977 5.60328 13.5977 6.09086C13.5977 6.57845 13.9929 6.97372 14.4805 6.97372Z"
                    fill="#34FF67"
                  />
                </svg>
              </a>
              <a href="">
                <svg
                  width="21"
                  height="21"
                  viewBox="0 0 21 21"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M18.6941 5.33725C18.7438 5.26868 18.6701 5.17868 18.5913 5.20953C18.0261 5.42863 17.4358 5.57634 16.8341 5.64925C17.5026 5.24995 18.0208 4.6414 18.3084 3.91782C18.3375 3.8441 18.257 3.7781 18.1884 3.81668C17.5653 4.16039 16.8941 4.4081 16.1955 4.55125C16.1812 4.55414 16.1663 4.55329 16.1523 4.54879C16.1384 4.54429 16.1258 4.53628 16.1158 4.52553C15.5901 3.97086 14.8979 3.60266 14.1442 3.47674C13.3904 3.35083 12.6161 3.47406 11.9387 3.82775C11.2612 4.18144 10.7175 4.74633 10.39 5.4368C10.0624 6.12727 9.96891 6.90569 10.1235 7.65411C10.1263 7.66714 10.126 7.68062 10.1228 7.69354C10.1195 7.70646 10.1134 7.71846 10.1048 7.72863C10.0962 7.7388 10.0854 7.74687 10.0732 7.75223C10.061 7.75758 10.0477 7.76008 10.0344 7.75953C8.67793 7.67529 7.35298 7.31479 6.14082 6.70016C4.92865 6.08553 3.85484 5.22973 2.98526 4.18525C2.97658 4.17438 2.96534 4.16584 2.95254 4.16039C2.93974 4.15495 2.92579 4.15276 2.91194 4.15404C2.89809 4.15531 2.88477 4.16001 2.87319 4.1677C2.8616 4.17539 2.8521 4.18584 2.84555 4.1981C2.57492 4.71149 2.43369 5.28318 2.43412 5.86353C2.43302 6.44158 2.57488 7.01092 2.84705 7.52087C3.11923 8.03083 3.51328 8.46557 3.99412 8.78639C3.4847 8.77254 2.98458 8.64671 2.52926 8.41782C2.47098 8.38782 2.40069 8.42982 2.40326 8.49496C2.43747 9.26733 2.71768 10.0085 3.20298 10.6104C3.7186 11.2349 4.43408 11.6621 5.2284 11.8198C4.92245 11.9121 4.60509 11.9611 4.28555 11.9655C4.11178 11.9632 3.93832 11.9503 3.76612 11.927C3.70183 11.9184 3.64955 11.9784 3.67183 12.0384C3.91734 12.703 4.35752 13.2781 4.93491 13.6886C5.5123 14.0992 6.20006 14.3261 6.90841 14.3398C5.54068 15.4156 3.82325 15.9471 2.08698 15.8321C1.99612 15.8261 1.95412 15.947 2.03212 15.9932C3.56745 16.9043 5.32025 17.3841 7.10555 17.3818C8.42521 17.3955 9.73438 17.1461 10.9566 16.6483C12.1788 16.1504 13.2896 15.4139 14.224 14.482C15.1584 13.55 15.8978 12.4412 16.3989 11.2203C16.9 9.99944 17.1529 8.69094 17.1427 7.37125V6.95982C17.1427 6.94651 17.1458 6.93339 17.1517 6.92149C17.1577 6.90958 17.1663 6.89923 17.177 6.89125C17.7584 6.45294 18.2699 5.92898 18.6941 5.33725Z"
                    fill="#34FF67"
                  />
                </svg>
              </a>
            </div>
          </div>

          <div class="cta-section-top">
            <h2 class="text-h2 text-dark-green">
              Ready to Earn More from Your Idle Equipment And Workforce?
            </h2>
            <div>
              <a href="#" class="btn-dark-green">LIST ON MARKETPLACE</a>
              <a href="#" class="btn-dark-green-trans">Register Your Company</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="faq">
      <div class="container">
        <div class="inner-faq">
          <span class="sub-heading">FAQS</span>
          <h2 class="text-h2">Frequently Asked Questions</h2>

          <ul class="accordion-list">
            <li>
              <h3>How do I list my equipment?</h3>
              <div class="answer">
                <p class="text-para">
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the industry's
                  standard dummy text ever since the 1500s, when an unknown
                  printer took a galley of type and scrambled it to make a type
                  specimen book. It has survived not only five centuries, but
                  also the leap into electronic typesetting, remaining
                  essentially unchanged.
                </p>
              </div>
            </li>
            <li>
              <h3>Who can rent?</h3>
              <div class="answer">
                <p class="text-para">
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the industry's
                  standard dummy text ever since the 1500s, when an unknown
                  printer took a galley of type and scrambled it to make a type
                  specimen book. It has survived not only five centuries, but
                  also the leap into electronic typesetting, remaining
                  essentially unchanged.
                </p>
              </div>
            </li>
            <li>
              <h3>Are payments secure?</h3>
              <div class="answer">
                <p class="text-para">
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the industry's
                  standard dummy text ever since the 1500s, when an unknown
                  printer took a galley of type and scrambled it to make a type
                  specimen book. It has survived not only five centuries, but
                  also the leap into electronic typesetting, remaining
                  essentially unchanged.
                </p>
              </div>
            </li>
            <li>
              <h3>How does workforce hiring work?</h3>
              <div class="answer">
                <p class="text-para">
                  Lorem Ipsum is simply dummy text of the printing and
                  typesetting industry. Lorem Ipsum has been the industry's
                  standard dummy text ever since the 1500s, when an unknown
                  printer took a galley of type and scrambled it to make a type
                  specimen book. It has survived not only five centuries, but
                  also the leap into electronic typesetting, remaining
                  essentially unchanged.
                </p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <?php $this->load->view('components/websiteFooter'); ?>
  </body>

  <script src="<?= base_url()?>assets/website/js/testimonial.js"></script>
  <script type="module" src="<?= base_url()?>assets/website/js/main.js"></script>
  <script src="<?= base_url()?>assets/website/js/home.js"></script>
</html>
