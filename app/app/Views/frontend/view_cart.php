<style type="text/css">
    #header-sticky .row.align-items-center{
    background: #f9f9f9 !important;
    height: 102px;
    }
</style>
<section class="prdct_list bd-page__banner-area include-bg page-overlay" data-background="<?php echo base_url('public/frontend/img/'); ?>/banner/page-banner-1.jpg" style="background-image: url(&quot;<?php echo base_url('public/frontend/img/'); ?>/banner/page-banner-1.jpg&quot;);">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bd-page__banner-content text-center">
                    <h2>
                        <?php echo lang('Validation.My Cart') ?>
                    </h2>
                    <div class="breadcrumb_area_centr breadcrumb-area pt-10 pb-10">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="breadcrumb__list">
                                        <span><a href="<?php echo base_url(''); ?>"><?php echo lang('Validation.Home') ?></a></span>
                                        <span><i class="fa-regular fa-angle-right"></i></span>
                                        <span><a href="<?php echo base_url('products'); ?>"><?php echo lang('Validation.Category') ?></a></span>
                                        <span><i class="fa-regular fa-angle-right"></i></span>
                                        <span><?php echo lang('Validation.Cart') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Body main wrapper start -->
<main>
    <!-- Breadcrumb-area-end -->
    <!-- Cart area start  -->
    <section class="cart-area pt-110 pb-130">
        <div class="container small-container">
            <div class="row">
                <div class="col-12">

                    <?php if (empty($card_total)): ?>
                        <p><?php echo lang('Validation.No data added yet in cart') ?></p>
                    <?php endif ?>

                    <?php if ($card_total): ?>
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail"><?php echo lang('Validation.Images') ?></th>
                                    <th class="cart-product-name"><?php echo lang('Validation.Product') ?></th>
                                    <th class="product-price"><?php echo lang('Validation.Unit Price') ?></th>
                                    <th class="product-quantity"><?php echo lang('Validation.Quantity') ?></th>
                                    <th class="product-subtotal"><?php echo lang('Validation.Total') ?></th>
                                    <th class="product-remove"><?php echo lang('Validation.Remove') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_data as $ckey => $cvalue): 
                                $update_key = $cvalue['key'];
                                $incremental_qty = $cvalue['p']['incremental_qty'];
                                $minimum_add_to_cart = $cvalue['p']['minimum_add_to_cart'];
                                $pid = $cvalue['p']['id'];
                                $price = $cvalue['p']['sale_price'];
                                $product_offer = @$cvalue['p']['product_offer'];
                                $qty = $cvalue['c']['qty'];
                                $extra = $cvalue['extra'];
                                $size = '';
                                if (!empty($cvalue['c']['metadata']['size'])) {
                                   $price = $cvalue['c']['metadata']['sale_price']; 
                                   $size = $cvalue['c']['metadata']['size']; 
                                }
                                $total = $price * $qty;
                                ?>
                                <tr class="row_count remove_pro_<?php echo $update_key ?>">
                                    <td class="product-thumbnail"><a href="<?php echo base_url('product/'.$pid) ?>"><img src="<?php echo $cvalue['p']['product_image']; ?>" alt="img"></a></td>
                                    <td class="product-name pname_extra">
                                        <a href="<?php echo base_url('product/'.$pid) ?>"><?php echo $cvalue['p']['product_name']; ?></a>
                                        <?php if ($size): ?>
                                        <p style="margin: 0px;"><?php echo $size; ?></p>
                                        <?php endif ?>

                                        <?php if ($extra): ?>
                                        <?php foreach ($extra as $ekey => $evalue): ?>
                                            <?php if (!empty($evalue['is_added'])): ?>
                                            <?php if ($evalue['is_added'] == 'yes'): ?>

                                                <?php 
                                                    $amt = $currency.$evalue['price'];
                                                    if ($evalue['price'] == 0) {
                                                        $amt = 'Free';
                                                    }
                                                ?>
                                                <p><?php echo $evalue['name']; ?> - <?php echo $amt; ?></p>
                                            <?php endif ?>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                        <?php endif ?>

                                        <div class="offer_div_<?php echo $update_key ?>">
                                            <?php if ($product_offer): ?>
                                            <?php foreach ($product_offer as $keay => $valaue): ?>
                                            <div class="singl_ofr_list singl_ofr_list_cart <?php echo $valaue['status']; ?>">
                                                <i class="fa fa-certificate" aria-hidden="true"></i>
                                                <span class="<?php if( $valaue['status'] == 'active') echo "activ_ofer_pop"; ?>  ">
                                                <?php echo $valaue['title']; ?>
                                                </span>
                                                <div class="clear"></div>
                                            </div>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                        </div>

                                    </td>
                                    <td class="product-price price_u_<?php echo $update_key ?>"><span class="amount"><?php echo $currency; ?><?php echo $price; ?></span></td>
                                    <td class="product-quantity text-center">
                                        <div class="product-quantity mt-10 mb-10">
                                            <div class="product-quantity-form">
                                                <!-- <form action="#">
                                                    <button class="cart-minus"><i class="far fa-minus"></i></button>
                                                    <input class="cart-input" type="text" value="1">
                                                    <button class="cart-plus"><i class="far fa-plus"></i></button>
                                                </form> -->
                                                <button class="cart-minus quantity_minus_cart" data-symbol="minus-btn" onclick="productQty(this)" data-id="<?php echo $pid ?>" data-target="<?php echo $update_key ?>" ><i class="fa fa-minus"></i></button>

                                                <input class="minimum_a_t_c_<?php echo $pid ?>" type="hidden" data-incremental_qty="<?php echo $incremental_qty ?>" data-min="<?php echo $minimum_add_to_cart ?>" >

                                                <input class="cart-input p_qty_<?php echo $update_key ?>" type="number" value="<?php echo $qty; ?>" readonly>
                                                
                                                <button data-target="<?php echo $update_key ?>" data-symbol="plus-btn" onclick="productQty(this)" class="cart-plus quantity_plus_cart" data-id="<?php echo $pid ?>" ><i class="fa fa-plus"></i></button>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="aount_u_<?php echo $update_key ?>"><?php echo $currency; ?><?php echo $total; ?></span>
                                    </td>
                                    <td class="product-remove">
                                        <a href="javascript:void(0);" data-id="<?php echo $update_key ?>" class="delete_cart_pro cart-page__table__remove" title="Remove this product"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="cart_btn_a">
                        <div class="row cart_left">
                            <!-- <div class="col-12">
                                <input type="hidden" class="tip_value" value="10" >
                                <div class="tip_titl">Add A TIP</div>
                                <div class="clear"></div>
                                <a href="javascript:void(0);" class="tip_sml" >$5</a>
                                <a href="javascript:void(0);" class="tip_sml" >$10</a>
                                <a href="javascript:void(0);" class="tip_sml" >$15</a>
                                <a href="javascript:void(0);" class="tip_sml" >$20</a>
                                <div class="d-flex align-items-center cart_tip">
                                    <input oninput="validateInput(this)" class="input-text tip_a_input" name="tip_amt" placeholder="Enter TIP" type="text">
                                    <button class="btn btn-primary bd-bd__coupon-btn aply_tip" type="submit">
                                    ADD A TIP
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="coupon-all">
                                    <div class="coupon d-flex align-items-center">
                                        <input id="coupon_code" class="input-text" name="coupon_code" value=""
                                            placeholder="Coupon code" type="text">
                                        <button class="bd-bd__coupon-btn aply_cpn" name="apply_coupon" type="submit">Apply
                                        coupon</button>
                                    </div>
                                    <div class="coupon2">
                                        <button onclick="window.location.reload()" class="bd-bd__coupon-btn updte_cpn" name="update_cart" type="submit">Update cart</button>
                                        <button class="clear_all_items bd-bd__coupon-btn updte_cpn" type="submit">Clear cart</button>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="row cart_right">
                            <div class="col-md-12 ml-auto">
                                <div class="cart-page-total">
                                    <h2><?php echo lang('Validation.Order Summary') ?></h2>
                                    <ul class="mb-20">
                                        <li><?php echo lang('Validation.Subtotal') ?> <span class="total_sale_price"><?php echo $currency; ?><?php echo $card_total['cart_price'] ?></span></li>
                                        <li><?php echo lang('Validation.Delivery Charges') ?> <span class="shipping_amt"><?php echo $currency; ?><?php echo $card_total['shipping_amount'] ?></span></li>
                                        <li><?php echo lang('Validation.Estimated Taxes') ?> (<?php echo $card_total['tax_percentage'] ?>%) <span class="tax_amount"><?php echo $currency; ?><?php echo $card_total['tax_amt'] ?></span></li>
                                        <li style="font-size: 24px;" ><?php echo lang('Validation.Total') ?><span class="main_total"><?php echo $currency; ?><?php echo $card_total['total_cart'] ?></span></li>
                                    </ul>
                                    <button class="clear_all_items bd-bd__coupon-btn updte_cpn" type="submit"><?php echo lang('Validation.Clear cart') ?></button>
                                    <a class="bd-border__btn checkout_proc" href="<?php echo base_url('checkout') ?>"><?php echo lang('Validation.Proceed to checkout') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
</main>

<style type="text/css">
    .pname_extra p
    {
        margin: 0px;
        font-weight: bold;
    }

    .pname_extra a{
        margin-bottom: 10px;
    }
</style>