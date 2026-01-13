<main>
    <section class="bd-banner__area grey-bg banner-height-2 d-flex align-items-center p-relative fix">
        <div class="container" style="z-index: 99;" >
            <div class="row align-items-center">
                <div class="bd-singel__banner d-flex align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="bd-banner__content__wrapper p-relative">
                            <div class="bd-banner__content-2">
                                <h2><?php echo lang("Validation.Find Your Favorite Food Near You") ?></h2>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <div class="bd-banner__btn">
                                    <a class="bd-bn__btn-1" href="<?php echo base_url('products'); ?>"><?php echo lang("Validation.Shop Now") ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-6">
                    </div>
                </div>
            </div>
        </div>
        <div class="slider_b_as"></div>
        <video class="slider_b" autoplay muted loop >
            <source src="<?php echo base_url('public/frontend/img/'); ?>video_burger.mp4" type="video/mp4">
            <source src="<?php echo base_url('public/frontend/img/'); ?>video_burger.mp4" type="video/ogg">
        </video>
    </section>

    <div class="clear"></div>
    <section class="bd-about__area pt-130 pb-65 about_sectn about_sectn_new">
        <div class="container">
            <div class="row g-0">
                <div class="col-xxl-7 col-xl-7 col-lg-7">
                    <div class="bd-about__wrapper mb-60">
                    </div>
                </div>
                <div class="col-xxl-5 col-xl-5 col-lg-5">
                    <div class="bd-about__content-box mb-60">
                        <div class="bd-section__title-wrapper mb-50">
                            <h2 class="bd-section__title mb-30">
                                <?php echo lang("Validation.Your Trusted Source for Premium Food Supplies") ?>!
                            </h2>
                        </div>
                        <div class="bd-about__inner bd_about__inner_2a">
                            <div class="bd-about__info">
                                <p class="fod_text" >
                                    <?php echo lang("Validation.At Foody Food, we specialize in wholesale and individual food supply, offering a wide range of high-quality products. Whether you’re a large catering institution, a restaurant, or a small store, we cater to your needs with frozen products, canned goods, essential ingredients, spices, beverages, and more") ?>.
                                </p>
                                <a href="" class="afody_link" ><?php echo lang("Validation.Learn More About Foody Food") ?>, </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clear"></div>

    <div class="div_food">
        <div class="div_food_right">
            <h3><?php echo lang("Validation.Our Products") ?></h3>
            <div class="sub_text_as_3">
                <?php echo lang("Validation.We source from trusted suppliers and reputable manufacturers<br>  to ensure quality and food safety") ?>.
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <section class="bd-trending__area pb-10">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-5">
                            <div class="bd-section__title-wrapper mb-40">
                                <div class="bd-sm__section-title">
                                    <h3><?php echo lang("Validation.Our Products") ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-8 col-xl-7">
                            <div class="bd-trending__tab-wrapper style-2 mb-40 p-relative">
                                <div class="bd-tending-nav">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <?php if (!empty($category_listing)): ?>
                                            <?php foreach ($category_listing as $ckey => $cvalue): ?>
                                            <?php $a_class="";
                                            if ($ckey == 0){
                                                $a_class="active";
                                            }
                                            ?>
                                            <button class="nav-link <?php echo $a_class; ?>" id="nav-tab-<?php echo $cvalue['id']; ?>-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-tab-<?php echo $cvalue['id']; ?>" type="button" role="tab" aria-controls="nav-tab-<?php echo $cvalue['id']; ?>"
                                            aria-selected="true"><?php echo $cvalue['display_name']; ?></button>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                        </div>
                                    </nav>
                                </div>
                                <div class="bd-trending__navigation style-2">
                                    <button class="trending-button-prev"><i class="fa-regular fa-angle-left"></i></button>
                                    <button class="trending-button-next"><i class="fa-regular fa-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bd-trending__item-wrapper">
                        <div class="tab-content" id="nav-tabContent">
                            <?php if ($category_listing): ?>
                                <?php foreach ($category_listing as $skey => $svalue): ?>

                                    <?php 
                                    $wclass="";
                                    $wc_lass="";
                                    if ($skey == 0){
                                        $wclass="display: block;";
                                        $wc_lass="show active";
                                    }
                                    ?>

                                    <div class="tab-pane fade <?php echo $wc_lass; ?>" id="nav-tab-<?php echo $svalue['id']; ?>" role="tabpanel"
                                        aria-labelledby="nav-tab-<?php echo $svalue['id']; ?>-tab">
                                        <div class="bd-trending-active-2 swiper-container">
                                            <div class="swiper-wrapper">

                                                <?php if ($svalue['product_list']): ?>
                                                    <?php foreach ($svalue['product_list'] as $pkey => $pvalue): ?>
                                                        <div class="swiper-slide">
                                                            <div class="bd-trending__item text-center mb-30">
                                                                <div class="bd-trending__product-thumb">
                                                                    <a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><img src="<?php echo $pvalue['product_image']; ?>" alt="trending-thumb"></a>
                                                                    <div class="bd-product__action">
                                                                        <a data-id="<?php echo $pvalue['id']; ?>"  class="cart-btn btn_quickview" href="javascript:void(0)"><i class="fal fa-cart-arrow-down"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="bd-product__tag">
                                                                    <span class="tag-text theme-bg">Sale</span>
                                                                </div>
                                                                <div class="bd-teanding__content">
                                                                    <div class="food_truck_dtl"><?php echo $pvalue['shop_name']; ?></div>
                                                                    <h4 class="bd-product__title"><a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><?php echo $pvalue['product_name']; ?></a>
                                                                    </h4>
                                                                    <div class="bd-product__price">
                                                                        <span class="bd-product__old-price"><del><?php echo $currency; ?><?php echo $pvalue['price']; ?></del></span><span
                                                                        class="bd-product__new-price"><?php echo $currency; ?><?php echo $pvalue['sale_price']; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Trending-area-end -->
    <?php if ($our_supplies_listing): ?>    
    <div class="bd-brand__area grey-bg pt-95 pb-65">
        <div class="container">
            <div class="row  justify-content-between">
                <div class="col-12">
                    <div class="our_supl_a">
                        <?php echo lang("Validation.Our Suppliers") ?> 
                    </div>
                    <div class="clear"></div>
                    <div class="bd-brand-active swiper-container swper_client">
                        <div class="swiper-wrapper">
                            <?php foreach ($our_supplies_listing as $dkey => $valdue): ?>
                            <div class="swiper-slide">
                                <div class="bd-singel__brand mb-30">
                                    <a href="javascript:void(0);"><img src="<?php echo base_url('public/frontend/img/'); ?>brand/<?php echo $valdue['image']; ?>" alt="brand-thumb"></a>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>
    <div class="clear"></div>
    <br><br>
    <!-- Trending-big-area-end -->
    <!-- Trending-big-area-end -->
    <!-- Brand-area-start -->
    <!-- Brand-area-end -->
    <!-- News-aera-start -->
    <!-- News-aera-end -->
</main>