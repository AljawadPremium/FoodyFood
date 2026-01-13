<main>
    <!-- Banner-area-start -->
    <section class="bd-banner__area grey-bg banner-height-2 d-flex align-items-center p-relative fix">
        <div class="bd-banner__shape-1">
            <img src="<?php echo base_url('public/frontend/'); ?>img/banner/banner-shape-1.png" alt="banner-shape">
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="bd-singel__banner d-flex align-items-center">
                    <div class="col-xl-7 col-lg-6 col-md-6 col-12">
                        <div class="bd-banner__content__wrapper p-relative">
                            <div class="bd-banner__text-shape">
                                <img src="<?php echo base_url('public/frontend/'); ?>img/banner/banner-shape-2.png" alt="banner-shape">
                            </div>
                            <div class="bd-banner__btn-shape">
                                <img src="<?php echo base_url('public/frontend/'); ?>img/banner/curved-arrow.png" alt="curved-arrow">
                            </div>
                            <div class="bd-banner__content-2">
                                <h2>Find Your Favorite Food Near You</h2>
                                <p>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.  
                                </p>
                                <div class="bd-banner__btn">
                                    <a class="bd-bn__btn-1" href="<?php echo base_url('products'); ?>">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-6">
                        <div class="bd-banner__thumb">
                            <img src="<?php echo base_url('public/frontend/'); ?>img/banner/food.png" class="food_truck" alt="banner-3.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner-area-end -->
    <div class="clear"></div>
    <br><br>

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
                           Your Trusted Source for Premium Food Supplies!
                        </h2>
                     </div>
                     <div class="bd-about__inner bd_about__inner_2a">
                        <div class="bd-about__info">
                           <p class="fod_text">
                              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                           </p>
                           <a href="<?php echo base_url('about') ?>" class="afody_link">Learn More About Foody Food, </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

    <?php if (!empty($c_listing)): ?>
        <div class="bd-brand__area grey-bg pt-95 pb-65 brows_cat">
            <div class="container">
                <div class="row  justify-content-between">
                    <div class="col-12">
                        <div class="bd-brand-active swiper-container">
                            <div class="title_new">
                                Browse by Category
                            </div>
                            <div class="swiper-wrapper">
                                <?php foreach ($c_listing as $ckey => $cvalue): ?>
                                    <div class="swiper-slide">
                                        <div class="bd-singel__brand mb-30">
                                            <a href="<?php echo base_url('products/'.$cvalue['id']); ?>" class="cat_a" >
                                                <img src="<?php echo base_url('public/admin/category/'.$cvalue['image']); ?>" alt="brand-thumb">
                                                <div class=""><?php echo $cvalue['display_name']; ?></div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <br><br>
    <?php endif ?>

    <!-- Product-banner-area-end -->
    <!-- Trending-area-start -->
    <section class="bd-trending__area pb-10">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-5">
                            <div class="bd-section__title-wrapper mb-40">
                                <div class="bd-sm__section-title">
                                    <h3>Special Dish</h3>
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
                                    <!-- If we need navigation buttons -->
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
        <?php if (!empty($all_shop_listing)): ?>
            <div class="bd-brand__area grey-bg pt-95 pb-65 brows_cat brows_truck">
                <div class="container">
                    <div class="row  justify-content-between">
                        <div class="col-12">
                            <div class="bd-brand-active swiper-container">
                                <div class="title_new">
                                    Browse by Food Truck
                                </div>
                                <div class="swiper-wrapper">
                                    <?php foreach ($all_shop_listing as $fkey => $fvalue): ?>
                                        <div class="swiper-slide">
                                            <div class="bd-singel__brand mb-30">
                                                <a href="<?php echo base_url('shop/'); ?><?php echo $fvalue['id'] ?>" class="cat_a" >
                                                    <img src="<?php echo $fvalue['image'] ?>" alt="brand-thumb">
                                                    <div class=""><?php echo $fvalue['display_name'] ?></div>
                                                    <div class="trck_orng">
                                                        <i class="fa fa-location-arrow" aria-hidden="true"></i>
                                                        <?php echo $fvalue['distance'] ?> Km away
                                                    </div>
                                                </a>
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
        <section class="bd-trending__big-area ">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-9 col-xl-8 col-lg-12 col-md-12 order-xl-2">
                        <div class="row align-items-center">
                            <div class="col-xxl-4 col-xl-5 col-lg-4">
                                <div class="bd-section__title-wrapper mb-40">
                                    <div class="bd-sm__section-title">
                                        <h3>You May Browse</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-8 col-xl-7 col-lg-8">
                                <div class="bd-trending-tab-2">
                                    <div class="bd-trending__tab-wrapper mb-40">
                                        <div class="bd-tending-nav">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab-large" role="tablist">
                                                    <button class="nav-link active" id="nav-trending-tab-1-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-trending-tab-1" type="button" role="tab"
                                                    aria-controls="nav-trending-tab-1" aria-selected="true">View All</button>
                                                    <button class="nav-link" id="nav-trending-tab-2-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-trending-tab-2" type="button" role="tab"
                                                    aria-controls="nav-trending-tab-2" aria-selected="false">New Arrival</button>
                                                    <button class="nav-link" id="nav-trending-tab-3-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-trending-tab-3" type="button" role="tab"
                                                    aria-controls="nav-trending-tab-3" aria-selected="false">Best Sale</button>
                                                    <button class="nav-link" id="nav-trending-tab-4-tab" data-bs-toggle="tab"
                                                    data-bs-target="#nav-trending-tab-4" type="button" role="tab"
                                                    aria-controls="nav-trending-tab-4" aria-selected="false">Special Product</button>
                                                </div>
                                            </nav>
                                        </div>
                                        <div class="bd-trending__btn style-2">
                                            <a class="bd-bn__btn-2" href="<?php echo base_url('products/'); ?>">View All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="tab-content" id="nav-tabContent-2">
                                    <div class="tab-pane fade show active" id="nav-trending-tab-1" role="tabpanel" aria-labelledby="nav-trending-tab-1-tab">
                                        <div class="bd-trending__item-wrapper">
                                            <div class="row">

                                                <?php if (!empty($rand_listing)): ?>
                                                    <?php foreach ($rand_listing as $pkey => $pvalue): ?>
                                                        <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
                                                            <div class="bd-trending__item mb-30 text-center">
                                                                <div class="bd-trending__product-thumb">
                                                                    <a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><img src="<?php echo $pvalue['product_image']; ?>" alt="trending-img"></a>
                                                        <!-- <div class="bd-product__tag">
                                                            <span class="tag-text theme-bg">New</span>
                                                        </div> -->
                                                        <div class="bd-product__action">
                                                            <a data-id="<?php echo $pvalue['id']; ?>"  class="cart-btn btn_quickview" href="javascript:void(0)"><i class="fal fa-cart-arrow-down"></i></a>
                                                        </div>

                                                    </div>
                                                    <div class="bd-teanding__content">
                                                        <div class="food_truck_dtl"><?php echo $pvalue['shop_name']; ?></div>
                                                        <h4 class="bd-product__title"><a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><?php echo $pvalue['product_name']; ?></a>
                                                        </h4>
                                                        <div class="bd-product__price">
                                                            <span class="bd-product__old-price"><del><?php echo $currency; ?><?php echo $pvalue['price']; ?></del></span><span class="bd-product__new-price"><?php echo $currency; ?><?php echo $pvalue['sale_price']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-trending-tab-2" role="tabpanel"
                        aria-labelledby="nav-trending-tab-2-tab">
                        <div class="row">
                            
                            <?php if (!empty($new_arrival)): ?>
                                <?php foreach ($new_arrival as $pkey => $pvalue): ?>
                                    <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
                                        <div class="bd-trending__item mb-30 text-center">
                                            <div class="bd-trending__product-thumb">
                                                <a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><img src="<?php echo $pvalue['product_image']; ?>" alt="trending-img"></a>
                                                <div class="bd-product__action">
                                                    <a data-id="<?php echo $pvalue['id']; ?>"  class="cart-btn btn_quickview" href="javascript:void(0)"><i class="fal fa-cart-arrow-down"></i></a>
                                                </div>
                                                <div class="bd-product__tag">
                                                    <span class="tag-text theme-bg">New</span>
                                                </div>
                                            </div>
                                            <div class="bd-teanding__content">
                                                <div class="food_truck_dtl"><?php echo $pvalue['shop_name']; ?></div>
                                                <h4 class="bd-product__title"><a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><?php echo $pvalue['product_name']; ?></a>
                                                </h4>
                                                <div class="bd-product__price">
                                                    <span class="bd-product__old-price"><del><?php echo $currency; ?><?php echo $pvalue['price']; ?></del></span><span class="bd-product__new-price"><?php echo $currency; ?><?php echo $pvalue['sale_price']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                            

                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-trending-tab-3" role="tabpanel"
                    aria-labelledby="nav-trending-tab-3-tab">
                    <div class="row">
                        
                        <?php if (!empty($top_listing)): ?>
                            <?php foreach ($top_listing as $pkey => $pvalue): ?>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
                                    <div class="bd-trending__item mb-30 text-center">
                                        <div class="bd-trending__product-thumb">
                                            <a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><img src="<?php echo $pvalue['product_image']; ?>" alt="trending-img"></a>
                                            <div class="bd-product__action">
                                                <a data-id="<?php echo $pvalue['id']; ?>"  class="cart-btn btn_quickview" href="javascript:void(0)"><i class="fal fa-cart-arrow-down"></i></a>
                                            </div>
                                                        <!-- <div class="bd-product__tag">
                                                            <span class="tag-text theme-bg">New</span>
                                                        </div> -->
                                                    </div>
                                                    <div class="bd-teanding__content">
                                                        <div class="food_truck_dtl"><?php echo $pvalue['shop_name']; ?></div>
                                                        <h4 class="bd-product__title"><a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><?php echo $pvalue['product_name']; ?></a>
                                                        </h4>
                                                        <div class="bd-product__price">
                                                            <span class="bd-product__old-price"><del><?php echo $currency; ?><?php echo $pvalue['price']; ?></del></span><span class="bd-product__new-price"><?php echo $currency; ?><?php echo $pvalue['sale_price']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>                                        

                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-trending-tab-4" role="tabpanel"
                            aria-labelledby="nav-trending-tab-4-tab">
                            <div class="row">
                                
                                <?php if (!empty($special_listing)): ?>
                                    <?php foreach ($special_listing as $pkey => $pvalue): ?>
                                        <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
                                            <div class="bd-trending__item mb-30 text-center">
                                                <div class="bd-trending__product-thumb">
                                                    <a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><img src="<?php echo $pvalue['product_image']; ?>" alt="trending-img"></a>
                                                        <!-- <div class="bd-product__tag">
                                                            <span class="tag-text theme-bg">New</span>
                                                        </div> -->
                                                        <div class="bd-product__action">
                                                            <a data-id="<?php echo $pvalue['id']; ?>"  class="cart-btn btn_quickview" href="javascript:void(0)"><i class="fal fa-cart-arrow-down"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="bd-teanding__content">
                                                        <div class="food_truck_dtl"><?php echo $pvalue['shop_name']; ?></div>
                                                        <h4 class="bd-product__title"><a href="<?php echo base_url('product/'.$pvalue['id']) ?>"><?php echo $pvalue['product_name']; ?></a>
                                                        </h4>
                                                        <div class="bd-product__price">
                                                            <span class="bd-product__old-price"><del><?php echo $currency; ?><?php echo $pvalue['price']; ?></del></span><span class="bd-product__new-price"><?php echo $currency; ?><?php echo $pvalue['sale_price']; ?></span>
                                                        </div>
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
            </div>
            <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-8 order-xl-1">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <a href="#">
                            <div class="bd-flash___banner-item mb-30 p-relative">
                                <div class="bd-flash__banner-thumb w-img">
                                    <img src="<?php echo base_url('public/frontend/'); ?>img/trending/flash/flash-banner-01.jpg" alt="flash-banner">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="bd-quite-active swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="bd-trending__quite text-center mb-30">
                                        <div class="bd-trending__quite-thumb">
                                            <img src="<?php echo base_url('public/frontend/'); ?>img/testimonial/trending-quite.png" alt="trending-quite">
                                        </div>
                                        <div class="bd-tending__quite-meta">
                                            <h4>Daniel Branliard</h4>
                                            <span>Sr. Executive</span>
                                        </div>
                                        <div class="bd-trending__quite-text">
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                            </p>
                                        </div>
                                        <div class="bd-trending__quite-icon">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bd-trending__quite text-center mb-30">
                                        <div class="bd-trending__quite-thumb">
                                            <img src="<?php echo base_url('public/frontend/'); ?>img/testimonial/testimonial-1.png" alt="trending-quite">
                                        </div>
                                        <div class="bd-tending__quite-meta">
                                            <h4>Basie Colton</h4>
                                            <span>Sr. Executive</span>
                                        </div>
                                        <div class="bd-trending__quite-text">
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                            </p>
                                        </div>
                                        <div class="bd-trending__quite-icon">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="bd-trending__quite text-center mb-30">
                                        <div class="bd-trending__quite-thumb">
                                            <img src="<?php echo base_url('public/frontend/'); ?>img/testimonial/testimonial-2.png" alt="trending-quite">
                                        </div>
                                        <div class="bd-tending__quite-meta">
                                            <h4>Andrew Jaxon</h4>
                                            <span>Sr. Executive</span>
                                        </div>
                                        <div class="bd-trending__quite-text">
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                            </p>
                                        </div>
                                        <div class="bd-trending__quite-icon">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="bd-trending__app-wrapper text-center mb-30">
                            <div class="bd-trending__app-title">
                                <h5>Download the App</h5>
                                <span>Make your life easier</span>
                            </div>
                            <div class="bd-trending__app-image">
                                <a href="#"><img src="<?php echo base_url('public/frontend/'); ?>img/trending/app/app-store-01.png" alt="app-store"></a>
                                <a href="#"><img src="<?php echo base_url('public/frontend/'); ?>img/trending/app/app-store-02.png" alt="app-store"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Trending-big-area-end -->
<!-- Brand-area-start -->
<!-- Brand-area-end -->
<!-- News-aera-start -->
<!-- News-aera-end -->
</main>