   <style>
    .cart-badge {
    font-size: 12px;
    padding: 3px 6px;
    min-width: 18px;
    height: 18px;
    line-height: 1;
    color: white;
  border-radius: 10px; 
}
   </style>
   
   <!-- ============================================================== -->
    <!-- navbar -->
    <!-- ============================================================== -->
    <div class="dashboard-header">
        <nav class="navbar navbar-expand-lg bg-white fixed-top">
            <a class="navbar-brand" href="index.html">Metro Foods</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-right-top">

                    <?php
                    if ($this->session->userdata['loginData']['userType'] == 2) {
                    ?>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-icons position-relative" href="<?=base_url('cart')?>" id="navbarDropdownMenuLink2"
                               >
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadge">
           <?=$cartCount[0]['result']?>
        </span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item dropdown nav-user">
                        <a class="nav-link nav-user-img size-position" href="#" id="navbarDropdownMenuLink2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle user-avatar-md rounded-circle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                            aria-labelledby="navbarDropdownMenuLink2">
                            <div class="nav-user-info">
                                <h5 class="mb-0 text-white nav-user-name">
                                    <?= $this->session->userdata['loginData']['userName'] ?></h5>
                                <span class="status"></span><span class="ml-2">Available</span>
                            </div>
                            <!-- <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a> -->
                            <a class="dropdown-item" href="<?= base_url('logout') ?>"><i
                                    class="fas fa-power-off mr-2"></i>Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- ============================================================== -->
    <!-- end navbar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- left sidebar -->
    <!-- ============================================================== -->
    <?php
    if ($this->session->userdata['loginData']['userType'] == 2) {
    ?>
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="<?= base_url('customer-dashboard') ?>"><i
                                        class="fa fa-fw fa-user-circle"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="<?= base_url('order-now') ?>"><i
                                        class="fas fa-shopping-basket"></i>Order Now 
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="<?= base_url('order-history') ?>"><i
                                        class="fab fa-wpforms"></i>Order History
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

    <?php
    } else {
    ?>
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="<?= base_url('dashboard') ?>"><i
                                        class="fa fa-fw fa-user-circle"></i>Dashboard <span
                                        class="badge badge-success">6</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-2" aria-controls="submenu-2"><i
                                        class="fas fa-user"></i>Vendors</a>
                                <div id="submenu-2" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('vendors') ?>">Add new Vendors</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('all-vendor') ?>">Manage Vendors</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-3" aria-controls="submenu-3"><i
                                        class="fas fa-users"></i>Customers</a>
                                <div id="submenu-3" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('customers') ?>">Add new Customers</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('all-customer') ?>">Manage Customers</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('assign-product') ?>">Assign Products</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('manage-assign-product') ?>">Manage Assign Products</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-boxes"></i>Manage
                                    Products</a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('add-new-product') ?>">Add new Product</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('manage-Products') ?>">Manage Products</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('category') ?>">Category</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url('manage-admin-orders')?>" ><i class="fas fa-shopping-basket"></i>Manage
                                    Orders</a>
                              
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    <?php
    }
    ?>
    <!-- ============================================================== -->
    <!-- end left sidebar -->
    <!-- ============================================================== -->