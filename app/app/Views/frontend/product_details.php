<style type="text/css">
    #header-sticky .row.align-items-center{
        background: #f9f9f9 !important;
        height: 102px;
    }
</style>
<main>
    <!-- Breadcrumb-area-start -->
    <div class="breadcrumb-area pt-10 pb-10">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb__list">
                        <span><a href="index.html">Home</a></span>
                        <span><i class="fa-regular fa-angle-right"></i></span>
                        <span>Product Deatils</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb-area-end -->
    <!-- Shop-details-area-start -->
    <div class="page-wrapper product-single bd__shop-details-area pt-110 pb-75">
        <div class="container small-container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="bd__shop-details-inner mb-55">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-details__thumb-inner small-device p-relative">
                                    <div class="bd__shop-details-img-gallery mb-30">
                                        <div class="product-details-active swiper-container">
                                            <div class="swiper-wrapper">

                                                <?php if (!empty($product_detail['image_gallery'])): ?>
                                                    <?php foreach ($product_detail['image_gallery'] as $key => $value): ?>
                                                        <?php $is_active = ''; 
                                                        if ($key == 0) {
                                                            $is_active = 'active';
                                                        } ?>
                                                        <div class="swiper-slide">
                                                            <div class="product-details__gallery-top__inner">
                                                                <div class="product-details__gallery-top__image">
                                                                    <img src="<?php echo $value; ?>" alt="product details image">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="bd-product__details-small-img">
                                        <div class="swiper-container product-details-nav">
                                            <div class="swiper-wrapper">

                                                <?php if (!empty($product_detail['image_gallery'])): ?>
                                                    <?php foreach ($product_detail['image_gallery'] as $key => $value): ?>
                                                        <div class="swiper-slide m-img">
                                                            <div class="product-small__img">
                                                                <img src="<?php echo $value; ?>" alt="product-thumb">
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- If we need navigation buttons -->
                                    <div class="bd-product__details-nav">
                                        <button class="product-details__button-prev"><i
                                            class="fa-regular fa-angle-left"></i></button>
                                            <button class="product-details__button-next"><i
                                                class="fa-regular fa-angle-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="modal-product-info shop-details-info">
                                            <h3><?php echo $product_detail['product_name']; ?></h3>
                                            <div class="product-price">
                                                <span class="asd123"><?php echo $currency; ?><?php echo $product_detail['sale_price']; ?>
                                                <del class="rough_del"><?php echo $currency; ?><?php echo $product_detail['price']; ?></del>
                                            </div>
                                            <div class="modal-product-meta bd__product-details-menu-1">
                                                <ul>
                                                    <li>
                                                        <!-- <strong></strong> -->
                                                        <span>
                                                            <a href="javascript:void(0);"><?php echo $product_detail['short_description']; ?></a> 
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>

                                            <?php if ($product_detail['meta_data']): ?>
                                            <div class="product-details__size">
                                                <?php if (!empty($product_detail['offer'])): ?>
                                                    <div class="offer_label_<?php echo $product_detail['id']; ?>">
                                                        <?php foreach ($product_detail['offer'] as $okey => $ovalue): 
                                                            ?>
                                                            <div class="singl_ofr_list <?php echo $ovalue['status'] ?>"><i class="fa fa-certificate" aria-hidden="true"></i><span><?php echo $ovalue['title']; ?></span>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                <?php endif ?>


                                                <?php 
                                                $size_arry  = '';
                                                if (!empty($product_detail['meta_data'])) 
                                                {
                                                    $size_arry = '<div class="product-form product-size">
                                                    <h3 class="product-details__content__title">Size</h3>
                                                    <div class="product-form-group">
                                                    <div class="product-variations sizelist_'.$product_detail['id'].'">';
                                                    foreach ($product_detail['meta_data'] as $mkey => $mvalue) {
                                                        $item_id = $mvalue['item_id'];
                                                        $size_name = $mvalue['size'];
                                                        $price = $mvalue['sale_price'];
                                                        $active = '';
                                                        if ($mkey == 0) {
                                                            // $active = 'active';
                                                            $active = '';
                                                            $f_price = $mvalue['price'];
                                                            $count_add = $mvalue['count_add'];
                                                        }
                                                        $size_arry.= '<a class="size '.$active.'" data-pid="'.$product_detail['id'].'" data-id="'.$item_id.'" data-price="'.$price.'" href="javascript:void(0);">'.$size_name.'</a>';
                                                    }
                                                    $size_arry .= '</div>
                                                    <a href="javascript:void(0);" class="product-variation-clean">Clean All</a>
                                                    </div>
                                                    </div>
                                                    <div class="product-variation-price">
                                                        <span class="asd123">'.$f_price.'</span>
                                                    </div>';
                                                }
                                                ?>
                                                <?php echo $size_arry; ?>
                                            </div>
                                        <?php endif ?>

                                            <div class="product-quantity-cart mb-25">
                                                <div class="product-quantity-form">
                                                    <!-- <form action="#"> -->
                                                        <input class="minimum_a_t_c_<?php echo $product_detail['id'] ?>" type="hidden" data-incremental_qty="<?php echo $product_detail['incremental_qty'] ?>" data-min="<?php echo $product_detail['minimum_add_to_cart'] ?>" >

                                                        <button class="sub quantity-minus cart-minus" data-id="<?php echo $product_detail['id'] ?>"><i class="far fa-minus"></i></button>

                                                        <input class="cart-input p_qty_<?php echo $product_detail['id'] ?>" type="text" value="<?php echo $product_detail['count_add']; ?>" readonly>

                                                        <button class="add quantity-plus cart-plus" data-id="<?php echo $product_detail['id'] ?>"><i class="far fa-plus"></i></button>
                                                    <!-- </form> -->
                                                </div>
                                                <a class="crt_btn_as cart-btn bd-fill__btn add_to_cart product_<?php echo $product_detail['id'] ?>" href="javascript:void(0)" data-id="<?php echo $product_detail['id'] ?>" data-toggle="tooltip" data-placement="top" title="Add to Cart" data-bs-toggle="modal"><i class="fal fa-cart-arrow-down"></i>Add to Cart</a>
                                            </div>

                                            <div class="bd__product-details-menu-3"></div>

                                            <?php if ($product_detail['extra_list']): ?>
                                            <div class="bd__social-media">
                                                <div id="flip" class="ad_extra_btn" >
                                                    Select EXTRA (if you need it)
                                                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                                                </div>
                                                <div class="clear"></div>
                                                <div id="panel" class="panel_extra p_select_<?php echo $product_detail['id'] ?>" style="display: block;">
                                                    <?php foreach ($product_detail['extra_list'] as $ekey => $evalue): ?>
                                                    <label class="extra_singl">
                                                        <input type="checkbox" name="option[]" value="<?php echo $evalue['id'] ?>">
                                                        <span class="name_extraname_extra" ><?php echo $evalue['name'] ?></span>
                                                        <?php 
                                                            $amt = $currency.''.$evalue['price'];
                                                            if ($evalue['price'] == 0) {
                                                                $amt = "free";
                                                            }
                                                        ?>
                                                        <span class="usd_extra" ><?php echo $amt; ?></span>
                                                        <div class="clear"></div>
                                                    </label>
                                                    <?php endforeach ?>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                            
                                            <?php endif ?>
                                            <?php
                                            $product_name = $product_detail['product_name']; 
                                            $product_url =  base_url('product/'.$product_detail['id']);
                                            $product_image = $product_detail['product_image'];
                                            $product_description = $product_detail['short_description'];
                                            ?>
                                            <div class="bd__social-media" style="display: none;">
                                                <ul>
                                                    <li>Share:</li>
                                                    <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($product_url) ?>&quote=<?= urlencode($product_description) ?>" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>

                                                    <li><a target="_blank" href="https://twitter.com/intent/tweet?url=<?= urlencode($product_url) ?>&text=<?= urlencode($product_description) ?>" title="Twitter"><i class="fab fa-twitter"></i></a></li>

                                                    <li><a target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($product_url) ?>" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>

                                                </ul>
                                            </div>
                                            <div class="bd__safe-checkout" style="display: none;">
                                                <h5>Guaranteed Safe Checkout</h5>
                                                <a href="javascript:void(0);"><img src="<?php echo base_url('public/frontend/'); ?>/img/icon/discover.png" alt="Payment Image"></a>
                                                <a href="javascript:void(0);"><img src="<?php echo base_url('public/frontend/'); ?>/img/icon/mastercard.png" alt="Payment Image"></a>
                                                <a href="javascript:void(0);"><img src="<?php echo base_url('public/frontend/'); ?>/img/icon/paypal.png" alt="Payment Image"></a>
                                                <a href="javascript:void(0);"><img src="<?php echo base_url('public/frontend/'); ?>/img/icon/visa.png" alt="Payment Image"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Shop Tab Start -->
                            <div class="product_info-faq-area pt-50">
                                <nav class="product-details-tab">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link show" id="nav-general-tab" data-bs-toggle="tab"
                                        href="#nav-general" role="tab" aria-selected="false"><?php echo lang('Validation.Description') ?></a>
                                    </nav>
                                    <div class="tab-content product-details-content" id="nav-tabContent">
                                        <div class="tab-pane fade active show" id="nav-general" role="tabpanel">
                                            <div class="tabs-wrapper mt-35 mb-40">
                                                <div class="product__details-des">
                                                    <?php echo $product_detail['description']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Shop Tab End -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
<script> 
$(document).ready(function(){
    $("#flip").click(function(){
        $("#panel").slideToggle("slow");
    });
});
</script>