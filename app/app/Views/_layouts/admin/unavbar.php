<?php
    if (empty($admin_data)) {
        return redirect()->to(base_url('admin'));
    }
    $dashboard = base_url('/admin');
    $language = '';
    $acc_holder_name = $admin_data[0]['first_name'].' '.$admin_data[0]['last_name'];
    $acc_type = $admin_data[0]['type'];

    $profile_image = base_url('public/admin/images/logo/'.$admin_data[0]['logo']);
?>

<!DOCTYPE html>
<html lang="<?php echo @$language; ?>" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" class="loading no-js <?php echo @$language; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="Description">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('/public/admin/logo.png') ?>">
        <input class="base_url" type="hidden" value="<?php echo $base_url; ?>">
        <base href="<?php echo $base_url; ?>" />
        <title><?php echo $page_title; ?></title>
    </head>
    <body id="bg" class="home <?php echo $body_class; ?> <?php echo @$language; ?>">
        <div id="loading" style="display: none">
            <img id="loading-image" src="<?php echo base_url('/public/loader.gif') ?>" alt="Loading..." />
        </div>

        <link rel="shortcut icon" href="<?php echo base_url();?>/public/admin/images/logo-sm.png">
        <link href="<?php echo base_url();?>/public/admin/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>/public/admin/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>/public/admin/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo base_url();?>/public/admin/js/layout.js"></script>
        <script src="<?php echo base_url();?>/public/admin/js/jquery.min.js"></script>

        <link href="<?php echo base_url('public/admin/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('public/admin/css/icons.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('public/admin/css/app.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('public/admin/css/custom.min.css');?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/toastr.css') ?>">

        <script src="<?php echo base_url();?>/public/toastr.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/public/admin_custome.css">

        <style type="text/css">
            html.loading {
                background:  url('<?php echo base_url();?>/public/loader.gif') no-repeat center fixed;
                position: fixed;
                left: 0;
                top: 0;
                z-index: 99999;
                width: 100%;
                height: 100%;
                overflow: visible;
                background-size: 150px;
                background-color: #ffffff;
                }
                html.loading body {
                opacity: 0;
                -webkit-transition: opacity 0;
                transition: opacity 0;
                }
        </style>
        <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="<?php echo $dashboard; ?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?php echo base_url();?>/public/admin/images/logo-sm.png" alt="" height="42">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?php echo base_url();?>/public/admin/images/logo-dark.png" alt="" height="17">
                                </span>
                            </a>
                            <a href="<?php echo $dashboard; ?>" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?php echo base_url();?>/public/admin/images/logo-sm.png" alt="" height="42">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?php echo base_url();?>/public/admin/images/logo_light.png" alt="" height="17">
                                </span>
                            </a>
                        </div>
                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown d-md-none topbar-head-dropdown header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="bx bx-search fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..."
                                                aria-label="Recipient's username">
                                            <button class="btn btn-primary" type="submit"><i
                                                class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                            <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                            <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>
                       
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?php echo $profile_image;?>"
                                alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $acc_holder_name; ?></span>
                            <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?php echo $acc_type; ?></span>
                            </span>
                            </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <h6 class="dropdown-header">Welcome <?php echo $acc_holder_name; ?>!</h6>
                                <a class="dropdown-item" href="<?php echo base_url('admin/profile') ?>"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="user_logut dropdown-item"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <a href="<?php echo $dashboard; ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?php echo base_url();?>/public/admin/images/logo-sm.png" alt="" height="42">
                    </span>
                    <span class="logo-lg">
                        <span style="font-size: 31px;color: #ffde59;font-weight: 900;font-family: inherit;">
                            FoodyFood
                        </span>
                        <!-- <img src="<?php echo base_url();?>/public/admin/images/logo_light.png" alt="" height="55"> -->
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover"><i class="ri-record-circle-line"></i></button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        
                        <li class="nav-item">
                            <a class="nav-link menu-link " href="<?php echo $dashboard; ?>" >
                            <i class="ri-dashboard-2-line"></i> <span class="dashboards">Dashboards</span>
                            </a>
                        </li>

                        <?php if ($acc_type == 'admin'): ?>
                        <!-- <li class="nav-item ">
                            <a class="nav-link menu-link" href="<?php echo base_url('/admin/customer'); ?>">
                                <i class="fa fa-user-plus"></i> <span class="customer_tab">Customer</span>
                            </a>
                        </li> -->
                        <li class="nav-item ">
                            <a class=" nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps"><i class=" fa fa-copyright"></i> <span class="category_tab" data-key="t-apps">Category</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarApps">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/category'); ?>" class="category_listing nav-link" data-key="t-calendar">List</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/category/add'); ?>" class="category_add nav-link" data-key="t-calendar">Add main category</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- <li class="nav-item ">
                            <a class=" nav-link menu-link" href="#sidebar_shop" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar_shop"><i class=" fa fa-copyright"></i> <span class="shop_tab" data-key="t-apps">Truck</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebar_shop">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/shop'); ?>" class="shop_listing nav-link" data-key="t-calendar">List</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/shop/add'); ?>" class="shop_add nav-link" data-key="t-calendar">Add</a>
                                    </li>
                                </ul>
                            </div>
                        </li> 
                        <li class="nav-item ">
                            <a class=" nav-link menu-link" href="#sidebar_banner" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar_banner"><i class="fa fa-file-image-o"></i> <span class="banner_tab" data-key="t-apps">Banner</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebar_banner">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/banner'); ?>" class="banner_listing nav-link" data-key="t-calendar">List</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/banner/add'); ?>" class="banner_add nav-link" data-key="t-calendar">Add banner</a>
                                    </li>
                                </ul>
                            </div>
                        </li>-->
                        <?php endif ?>


                        <li class="nav-item ">
                            <a class=" nav-link menu-link" href="#sidebar_order" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar_order"><i class="fa fa-briefcase"></i> <span class="order_tab" data-key="t-apps">Orders</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebar_order">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/order/listing'); ?>" class="o_listing nav-link" data-key="t-calendar">List</a>
                                    </li>
                                </ul>
                            </div>
                        </li>


                        <li class="nav-item ">
                            <a class=" nav-link menu-link" href="#sidebar_product" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar_product"><i class="fa fa-universal-access"></i> <span class="product_tab" data-key="t-apps">Product</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebar_product">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/product'); ?>" class="product_listing nav-link" data-key="t-calendar">List</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/product/add'); ?>" class="product_add nav-link" data-key="t-calendar">Add product</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- <li class="nav-item ">
                            <a class=" nav-link menu-link" href="#sidebar_attribute" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar_attribute"><i class="fa fa-cubes"></i> <span class="attribute_tab" data-key="t-apps">Attribute</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebar_attribute">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/attribute'); ?>" class="attribute_listing nav-link" data-key="t-calendar">List</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/attribute/add'); ?>" class="attribute_add nav-link" data-key="t-calendar">Add attribute</a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->

                        <?php if ($acc_type == 'admin s'): ?>
                        <li class="nav-item ">
                            <a class=" nav-link menu-link" href="#sidebar_setting" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar_setting"><i class="fa fa-cogs"></i> <span class="setting_tab" data-key="t-apps">Settings</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebar_setting">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item ">
                                        <a class="tax_listing nav-link menu-link" href="<?php echo base_url('admin/tax'); ?>"><span>Tax & Shipping Amount</span></a>
                                    </li>
                                    <!-- <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/building'); ?>" class="building_add nav-link" data-key="t-calendar">Building/Wings</a>
                                    </li> -->
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/notification'); ?>" class="notification_listing nav-link" data-key="t-calendar">Notification</a>
                                    </li>
                                    <!-- <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/payment/link'); ?>" class="payment_link_add nav-link" data-key="t-calendar">Payment Link</a>
                                    </li> -->
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/pages'); ?>" class="pages_listing nav-link">Pages</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/coupon'); ?>" class="coupon_listing nav-link" data-key="t-calendar">Coupons</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/rating'); ?>" class="rating_listing nav-link" data-key="t-calendar">Rating & Reviews</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <?php endif ?>
                        
                        <li class="nav-item" style="display: none;">
                            <a class=" nav-link menu-link" href="#sidebar_slot" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar_slot"><i class="fa fa-braille"></i> <span class="slot_tab" data-key="t-apps">Slot</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebar_slot">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/slot'); ?>" class="slot_listing nav-link" data-key="t-calendar">List</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="<?php echo base_url('/admin/slot/add'); ?>" class="slot_add nav-link" data-key="t-calendar">Add slot</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <hr>
                        <li class="nav-item">
                            <a class="nav-link menu-link" target="_blank" href="<?php echo base_url(''); ?>">
                            <i class="mdi mdi-logout"></i><span>Go to website</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link user_logut">
                            <i class="mdi mdi-logout"></i><span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sidebar-background"></div>
        </div>
