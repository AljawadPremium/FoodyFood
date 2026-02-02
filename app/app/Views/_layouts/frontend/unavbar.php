<?php $lang = get_cookie('lang'); ?>
<!DOCTYPE html>
<html lang="en" class="language <?php echo $lang; ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="description" content="10/10 Food" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <base href="<?php echo base_url(); ?>" />
    <title><?php echo $page_name; ?></title>
    <meta property="og:title" content="Sample Product" />
    <meta property="og:description" content="This is a great product" />
    <meta property="og:image" content="https://yourwebsite.com/images/product.jpg" />
    <meta property="og:url" content="https://yourwebsite.com/product/123" />
    <link rel="shortcut icon" href="<?php echo base_url('public/frontend/'); ?>img/fev.png" />
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/meanmenu.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/owl-carousel.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/swiper-bundle.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/backtotop.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/ui-range-slider.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/nice-select.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/font-awesome-pro.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/spacing.css">
    <link rel="stylesheet" href="<?php echo base_url('public/frontend/'); ?>/css/main.css?v=1.4">
    <script src="<?php echo base_url('public/frontend/'); ?>/js/vendor/jquery.js"></script>
</head>

<body>
    <?php $uid = @$_SESSION['uid']; ?>
    <div id="loading" style="display: none">
        <img id="loading-image" src="<?php echo base_url('/public/loader.gif') ?>" alt="Loading..." />
    </div>
    <style type="text/css">
        #loading {
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            position: fixed;
            display: block;
            opacity: 0.9;
            background-color: #fff;
            z-index: 9999999;
            text-align: center;
        }

        #loading-image {
            position: absolute;
            top: 300px;
            left: 630px;
            z-index: 100;
            width: 150px;
        }

        .contry_flag img {
            width: 50px;
        }
    </style>
    <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="offcanvas__area page-wrapper">
        <div class="modal fade" id="offcanvasmodal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="offcanvas__wrapper">
                        <div class="offcanvas__content">
                            <div class="offcanvas__top mb-40 d-flex justify-content-between align-items-center">
                                <div class="offcanvas__logo logo">
                                    <a href="<?php echo base_url(''); ?>">
                                        <img src="<?php echo base_url('public/frontend/'); ?>img/logo/logo.png"
                                            style="width:220px;" alt="logo">
                                    </a>
                                </div>
                                <div class="offcanvas__close">
                                    <button class="offcanvas__close-btn" data-bs-toggle="modal"
                                        data-bs-target="#offcanvasmodal">
                                        <i class="fal fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="bd-utilize__buttons mb-25 d-lg-none">
                                <div class="bd-action__item">
                                    <div class="bd-action__cart-wrapper">
                                        <div class="bd-action__cart-icon">
                                            <a href="#" class="cart-dropdowna" data-bs-toggle="offcanvas"
                                                data-bs-target="#cartmini" aria-controls="cartmini">
                                                <svg id="shopping-bag-5564" xmlns="http://www.w3.org/2000/svg"
                                                    width="16.508" height="18.5" viewBox="0 0 16.508 18.5">
                                                    <path id="Path_76485412" data-name="Path 76"
                                                        d="M24.21,35.5H34.3a3.214,3.214,0,0,0,3.21-3.21v-9.6a.571.571,0,0,0-.569-.569H33.523v-.854a4.269,4.269,0,0,0-8.538,0v.854H21.569a.571.571,0,0,0-.569.569v9.6A3.214,3.214,0,0,0,24.21,35.5Zm1.913-14.231a3.131,3.131,0,0,1,6.262,0v.854H26.123Zm-3.985,1.992h2.846v1.423a.569.569,0,0,0,1.138,0V23.262h6.262v1.423a.569.569,0,0,0,1.138,0V23.262h2.846V32.29A2.076,2.076,0,0,1,34.3,34.362H24.21a2.076,2.076,0,0,1-2.072-2.072Z"
                                                        transform="translate(-21 -17)" fill="#1c1d1b"></path>
                                                </svg>
                                            </a>
                                            <span class="bd-action__item-number cart-count">0</span>
                                        </div>
                                        <div class="bd-cart__text">
                                            <span>Cart</span>
                                            <h5 class="header_cart_total">$0.00</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="bd-action__item">
                                    <div class="bd-action__wishlist">
                                        <div class="bd-action__wistlist-icon">
                                            <a href="#" class="cart-dropdowna" data-bs-toggle="offcanvas"
                                                data-bs-target="#wishlist" aria-controls="wishlist">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16.194" height="14.985"
                                                    viewBox="0 0 16.194 14.985">
                                                    <path id="Path_4451" data-name="Path 4"
                                                        d="M11.829,39.221a4.128,4.128,0,0,0-3.415,1.9c-.118.166-.224.331-.317.492-.093-.161-.2-.326-.317-.492a4.128,4.128,0,0,0-3.415-1.9C1.82,39.221,0,41.549,0,44.343c0,3.195,2.4,6.206,7.769,9.762a.587.587,0,0,0,.656,0c5.373-3.557,7.769-6.568,7.769-9.762C16.194,41.551,14.375,39.221,11.829,39.221Zm1.428,9.1A24,24,0,0,1,8.1,52.7a24,24,0,0,1-5.16-4.383,6.283,6.283,0,0,1-1.671-3.978c0-2.012,1.244-3.74,3.1-3.74A2.891,2.891,0,0,1,6.76,41.938a5.312,5.312,0,0,1,.734,1.445.618.618,0,0,0,1.208,0,5.308,5.308,0,0,1,.711-1.413A2.9,2.9,0,0,1,11.829,40.6c1.857,0,3.1,1.73,3.1,3.74A6.283,6.283,0,0,1,13.257,48.321Z"
                                                        transform="translate(0 -39.221)" fill="#1c1d1b"></path>
                                                </svg>
                                            </a>
                                            <span class="bd-action__item-number wishlist-count">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="offcanvas__search mb-25">
                                <form action="#" style="display:none;">
                                    <input type="text" placeholder="What are you searching for?">
                                    <button type="submit"><i class="far fa-search"></i></button>
                                </form>
                            </div>
                            <div class="mobile-menu fix mb-40"></div>
                            <div class="offcanvas__contact mt-30 mb-20">
                                <h4>Contact Info</h4>
                                <ul>
                                    <li class="d-flex align-items-center">
                                        <div class="offcanvas__contact-icon mr-15">
                                            <i class="fal fa-map-marker-alt"></i>
                                        </div>
                                        <div class="offcanvas__contact-text">
                                            <a target="_blank">12/A,
                                                Lorem City Tower, NYC</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="offcanvas__contact-icon mr-15">
                                            <i class="far fa-phone"></i>
                                        </div>
                                        <div class="offcanvas__contact-text">
                                            <a href="tel:+123">+123 456 7890</a>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <div class="offcanvas__contact-icon mr-15">
                                            <i class="fal fa-envelope"></i>
                                        </div>
                                        <div class="offcanvas__contact-text">
                                            <a href="tel:+012-345-6789"><span class="#"><span
                                                        class="__cf_email__">contact@food.com</span></span></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="offcanvas__social">
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cartmini area start  -->
    <div class="offcanvas offcanvas-end" id="cartmini">
        <div class="cartmini__wrapper">
            <div class="cartmini__title">
                <h4><?php echo lang('Validation.Shopping Cart') ?></h4>
            </div>
            <div class="cartmini__close">
                <button type="button" class="cartmini__close-btn" data-bs-dismiss="offcanvas" aria-label="Close"><i
                        class="fal fa-times"></i></button>
            </div>
            <div class="cartmini__widget">
                <div class="cartmini__inner">
                    <ul class="mini_cart">

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <header>
        <div class="bd-header__middle theme-bg d-none d-sm-block">
            <div class="bd-header__middle-area-3">
                <div class="container">
                    <div class="row align-items-center" style="display: none;">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                            <div class="bd-header__top-link">
                                <a href="<?php echo base_url('about'); ?>">About Us</a>
                                <a href="<?php echo base_url('contact'); ?>">Contact Us</a>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                            <div class="style-2">
                                <div class="bd-treak__right bd-header__top-link">

                                    <?php if (empty($user_data)): ?>
                                        <a href="<?php echo base_url('login'); ?>">Login</a>
                                        <a href="<?php echo base_url('login'); ?>">Register</a>
                                    <?php endif ?>

                                    <?php if (!empty($user_data)): ?>
                                        <a href="javascript:void(0);" class="link-to-tab d-md-show">Welcome
                                            <?php echo $user_data[0]['first_name']; ?></a>
                                        <a href="javascript:void(0);" class="user_logut link-to-tab d-md-show">Logout</a>
                                        <a href="<?php echo base_url('orders'); ?>">My Order</a>
                                        <a href="<?php echo base_url('profile'); ?>">My Profile</a>
                                    <?php endif ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="header-sticky" class="bd-header__bottom-area-3 transparent__header header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-6 col-6">
                        <div class="bd-header__logo-3">
                            <a href="<?php echo base_url(''); ?>">
                                <img src="<?php echo base_url('public/frontend/'); ?>img/logo/logo.png"
                                    class="logo_main" alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-6 d-none d-lg-block">
                        <div class="bd-header__left-3">
                            <div class="main-menu d-none d-none d-lg-block">
                                <nav id="mobile-menu">
                                    <ul>
                                        <li class="">
                                            <a
                                                href="<?php echo base_url(''); ?>"><?php echo lang('Validation.Home') ?></a>
                                        </li>
                                        <li class="has-dropdown">
                                            <a
                                                href="<?php echo base_url('products/'); ?>"><?php echo lang('Validation.Categories') ?></a>
                                            <ul class="submenu">
                                                <?php if (!empty($cat_listing)): ?>
                                                    <?php foreach ($cat_listing as $ckey => $cvalue): ?>
                                                        <li><a
                                                                href="<?php echo base_url('products/') . $cvalue['id']; ?>"><?php echo $cvalue['display_name']; ?></a>
                                                        </li>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </ul>
                                        </li>
                                        <li>
                                            <a
                                                href="javascript:void(0);"><?php echo lang('Validation.Contact Us') ?></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-3 col-md-6 col-6">
                        <div class="bd-header__right header__right-3">
                            <div class="bd-action__filter-wrapper d-none d-xl-block">
                                <div class="bd-action__filter p-relative">
                                    <form action="javascript:void(0);">
                                        <input id="search_me" class="search_header" type="text"
                                            placeholder="<?php echo lang('Validation.Search products') ?>...">
                                        <button><i class="flaticon-magnifiying-glass"></i></button>
                                    </form>
                                    <div class="items ha-box-shadow ha-box-border" id="YOUR_CONTAINER_SELECTOR"></div>
                                </div>
                            </div>
                            <div class="arbc_lang">
                                <?php if (!empty($lang_data)) { ?>
                                    <?php foreach ($lang_data as $ld_key => $ld_val) { ?>
                                        <a href="javascript:void(0)"
                                            class=" contry_flag lang_change <?php echo $ld_val['is_active']; ?>"
                                            data-id="<?php echo $ld_val['lang_nm']; ?>">

                                            <?php if ($ld_val['lang_nm'] == 'ar' && $ld_val['is_active'] != 'active'): ?>
                                                <i class="fa fa-language ar" aria-hidden="true"></i>
                                                <div class="arbc_text">Arabic</div>
                                            <?php endif ?>

                                            <?php if ($ld_val['lang_nm'] == 'en' && $ld_val['is_active'] != 'active'): ?>
                                                <i class="fa fa-language en" aria-hidden="true"></i>
                                                <div class="arbc_text">English</div>
                                            <?php endif ?>
                                        </a>
                                    <?php } ?>
                                <?php } ?>


                                <div class="clear"></div>
                            </div>
                            <div class="bd-action__cart-list list-3">
                                <div class="bd-action__item">
                                    <div class="bd-action__cart-wrapper">
                                        <div class="bd-action__cart-icon">
                                            <a href="#" data-bs-toggle="offcanvas" class="cart-dropdowna"
                                                data-bs-target="#cartmini" aria-controls="cartmini">
                                                <svg id="shopping-bag-5" xmlns="http://www.w3.org/2000/svg"
                                                    width="16.508" height="18.5" viewBox="0 0 16.508 18.5">
                                                    <path id="Path_764854" data-name="Path 76"
                                                        d="M24.21,35.5H34.3a3.214,3.214,0,0,0,3.21-3.21v-9.6a.571.571,0,0,0-.569-.569H33.523v-.854a4.269,4.269,0,0,0-8.538,0v.854H21.569a.571.571,0,0,0-.569.569v9.6A3.214,3.214,0,0,0,24.21,35.5Zm1.913-14.231a3.131,3.131,0,0,1,6.262,0v.854H26.123Zm-3.985,1.992h2.846v1.423a.569.569,0,0,0,1.138,0V23.262h6.262v1.423a.569.569,0,0,0,1.138,0V23.262h2.846V32.29A2.076,2.076,0,0,1,34.3,34.362H24.21a2.076,2.076,0,0,1-2.072-2.072Z"
                                                        transform="translate(-21 -17)" fill="#1c1d1b" />
                                                </svg>
                                            </a>
                                            <span class="bd-action__item-number cart-count">0</span>
                                        </div>
                                        <div class="bd-cart__text">
                                            <span><?php echo lang('Validation.Cart') ?></span>
                                            <h5 class="header_cart_total">$0.00</h5>
                                        </div>
                                        <a class="downl_brchr" href="<?php echo base_url('public/pdf/foodyfood.pdf') ?>"
                                            target="_blank"><?php echo lang('Validation.View Catalog') ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="header__hamburger d-flex d-lg-none">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#offcanvasmodal"
                                    class="hamburger-btn">
                                    <span class="hamburger-icon">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>