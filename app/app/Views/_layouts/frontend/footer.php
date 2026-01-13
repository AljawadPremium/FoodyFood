<footer>
    <section class="bd-footer__area grey-bg pt-100 pb-35">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="bd-footer__widget footer-col-1 mb-60">
                        <div class="bd-footer__info">
                            <div class="bd-footer__logo">
                                <a href="<?php echo base_url(''); ?>">
                                    <img src="<?php echo base_url('public/frontend/'); ?>img/logo/logo.png" class="footer_logo" alt="footer-logo">
                                </a>
                            </div>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                            </p>
                            <div class="bd-footer__contact">
                                <span><i class="fa-regular fa-envelope"></i><a href=""><span class="__cf_email__">
                                contact@food.com</span></a></span>
                                <span><i class="fa-regular fa-house-chimney"></i>Lorem, New York, USA - 1234</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="bd-footer__widget footer-col-2 mb-60">
                        <div class="bd-footer__widget-title">
                            <h4><?php echo lang('Validation.Quick Links') ?></h4>
                        </div>
                        <div class="bd-footer__link">
                            <ul>
                                <li><a href="<?php echo base_url('about'); ?>"><?php echo lang('Validation.About Us') ?></a></li>
                                <li><a href="<?php echo base_url('contact'); ?>"><?php echo lang('Validation.Contact Us') ?></a></li>
                                <li><a href="<?php echo base_url('privacy'); ?>"><?php echo lang('Validation.Privacy & Policy') ?></a></li>
                                <li><a href="<?php echo base_url('terms'); ?>"><?php echo lang('Validation.Terms & Conditions') ?></a></li>
                                <li><a href="<?php echo base_url('faq'); ?>"><?php echo lang('Validation.Frequently Asked Questions (FAQ)') ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="bd-footer__widget footer-col-3 mb-60">
                        <div class="bd-footer__widget-title">
                            <h4><?php echo lang('Validation.Categories') ?></h4>
                        </div>
                        <div class="bd-footer__link">
                            <ul>
                                <?php if (!empty($footer_cat_listing)): ?>
                                <?php foreach ($footer_cat_listing as $ckey => $cvalue): ?>
                                <li><a href="<?php echo base_url('products/').$cvalue['id']; ?>"><?php echo $cvalue['display_name']; ?></a></li>
                                <?php endforeach ?>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="bd-footer__widget mb-60">
                        <div class="bd-footer__widget-title">
                            <h4><?php echo lang('Validation.Newsletter') ?></h4>
                        </div>
                        <div class="bd-footer__subcribe p-relative mb-40">
                            <form id="newsletter_submit">
                                <input type="email" name="email" placeholder="<?php echo lang('Validation.Enter Your Email') ?>" required>
                                <button class="bd-footer__s-btn"><i class="fa-solid fa-arrow-right-long"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="bd-sub__fotter">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="bd-footer__copyright style-1">
                        <ul>
                            <li><?php echo lang('Validation.All Rights Reserved') ?></li>
                            <li><?php echo lang('Validation.Copyrighted by') ?> ©2024 <span><a
                            href="https://persausive.com/">Persausive</a></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="bd-footer__payment">
                        <ul>
                            <li><span><?php echo lang('Validation.We Support') ?></span></li>
                            <li><a href="#"><img src="<?php echo base_url('public/frontend/'); ?>img/icon/discover.png" alt="discover"></a></li>
                            <li><a href="#"><img src="<?php echo base_url('public/frontend/'); ?>img/icon/mastercard.png" alt="mastercard"></a></li>
                            <li><a href="#"><img src="<?php echo base_url('public/frontend/'); ?>img/icon/paypal.png" alt="paypal"></a></li>
                            <li><a href="#"><img src="<?php echo base_url('public/frontend/'); ?>img/icon/visa.png" alt="visa"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer area end -->
<!-- Back to top start -->
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
<!-- Back to top end -->
<!-- JS here -->

<!-- <script src="<?php echo base_url('public/frontend/'); ?>/js/vendor/waypoints.js"></script> -->
<script src="<?php echo base_url('public/frontend/'); ?>/js/bootstrap-bundle.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/meanmenu.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/swiper-bundle.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/owl-carousel.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/magnific-popup.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/parallax.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/backtotop.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/nice-select.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/counterup.js"></script>
<!-- <script src="<?php echo base_url('public/frontend/'); ?>/js/countdown.min.js"></script> -->
<script src="<?php echo base_url('public/frontend/'); ?>/js/wow.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/ui-slider-range.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/isotope-pkgd.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/imagesloaded-pkgd.js"></script>
<script src="<?php echo base_url('public/frontend/'); ?>/js/main.js"></script>

<script src="<?php echo base_url('public/js/'); ?>boskery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/toastr.css') ?>">
<script src="<?php echo base_url();?>/public/toastr.js"></script>
<link id="color-link" rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/public/sweetalert.css">
<script src="<?php echo base_url(); ?>/public/sweetalert.min.js"></script>

<script src="<?php echo base_url('public/'); ?>js/main.min.js"></script>
<script src="<?php echo base_url('public/'); ?>js/cart.js"></script>
<script src="<?php echo base_url();?>public/js/checkout.js"></script>
<script src="<?php echo base_url('public/'); ?>js/product_listing.js"></script>
<script src="<?php echo base_url('public/'); ?>js/login.js"></script>
<script src="<?php echo base_url('public/'); ?>js/my_account.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/js'); ?>/my_account.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/js'); ?>/custome.css">
<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('public'); ?>/demo11.min.css"> -->
<script src="<?php echo base_url('public/'); ?>js/product_rating.js"></script>