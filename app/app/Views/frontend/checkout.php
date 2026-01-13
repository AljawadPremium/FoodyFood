<?php 
$name = $address = $landmark = $city = $state = $postcode = $email = $mobile_no = $delivery_note = $country = '';
?>
<?php if ($user_last_add): ?>
    <?php
    $name = $user_last_add[0]['name'];
    $address = $user_last_add[0]['address'];
    $landmark = $user_last_add[0]['landmark'];
        // $city = $user_last_add[0]['city'];
        // $country = $user_last_add[0]['country'];
        // $state = $user_last_add[0]['state'];
        // $postcode = $user_last_add[0]['postcode'];
    $email = $user_last_add[0]['email'];
    $mobile_no = $user_last_add[0]['mobile_no'];
    $delivery_note = $user_last_add[0]['delivery_note'];
    ?>
<?php endif ?>


<style type="text/css">
    #header-sticky .row.align-items-center{
        background: #f9f9f9 !important;
        height: 102px;
    }
</style>
<section class="prdct_list bd-page__banner-area include-bg page-overlay" data-background="<?php echo base_url('public/frontend/'); ?>img/banner/page-banner-1.jpg" style="background-image: url(&quot;<?php echo base_url('public/frontend/'); ?>img/banner/page-banner-1.jpg&quot;);">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bd-page__banner-content text-center">
                    <h2>
                        <?php echo lang("Validation.Checkout") ?>
                    </h2>
                    <div class="breadcrumb_area_centr breadcrumb-area pt-10 pb-10">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="breadcrumb__list">

                                        <span><a href="<?php echo base_url();?>"><?php echo lang("Validation.Home") ?></a></span>
                                        <span><i class="fa-regular fa-angle-right"></i></span>
                                        <span><a href="<?php echo base_url('cart');?>"><?php echo lang("Validation.Cart") ?></a></span>
                                        <span><i class="fa-regular fa-angle-right"></i></span>
                                        <span><?php echo lang("Validation.Checkout") ?></span>
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
<main>
    <br>
    <section class="checkout-area pb-100">
        <div class="container small-container">
            <form class ="checkout_submit">
                <input type="hidden" name="lat" id="lat" value="">
                <input type="hidden" name="lng" id="lng" value="">
                <input type="hidden" name="place_id" id="place_id" value="place_12313">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="checkbox-form">
                            <h3><?php echo lang('Validation.Billing Details') ?></h3>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="checkout-form-list">
                                        <label for="full-name"><?php echo lang('Validation.Your Name') ?> *</label>
                                        <input type="text" name="name" value="<?php echo $name; ?>" id="full-name" placeholder="<?php echo lang('Validation.Enter Your Name') ?>" required="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="checkout-form-list">
                                        <label for="email"><?php echo lang('Validation.Email Address') ?> *</label>
                                        <input type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="<?php echo lang('Validation.Enter Email Address') ?>" required="">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="checkout-form-list">
                                        <label for="company-name"><?php echo lang('Validation.Phone') ?></label>
                                        <input type="text" name="mobile_no" placeholder="<?php echo lang('Validation.Enter Phone Number') ?>" value="<?php echo $mobile_no; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="checkout-form-list">
                                        <label for="address"><?php echo lang('Validation.Street Address') ?> *</label>
                                        <input type="text" name="address" id="address_autocomplete" value="" placeholder="1837 E Homer M Adams Pkwy" required="">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="checkout-form-list">
                                        <label><?php echo lang('Validation.Landmark') ?> *</label>
                                        <input type="text" placeholder="<?php echo lang('Validation.Enter Landmark') ?>" name="landmark" value="<?php echo $landmark; ?>">
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-20">
    <div class="alert alert-info" style="background-color: #e7f3ff; border-left: 5px solid #2196F3; padding: 15px;">
        <strong>Notice:</strong> We currently only deliver within <strong>Saudi Arabia</strong>.
    </div>
</div>

<div class="col-xl-6">
    <div class="checkout-form-list">
        <label>City *</label>
        <select name="city" class="form-control" required style="height: 50px; border: 1px solid #e1e1e1;">
            <option value="">Select City</option>
            <option value="Riyadh">Riyadh</option>
            <option value="Jeddah">Jeddah</option>
            <option value="Dammam">Dammam</option>
            <option value="Hail">Hail</option>
            <option value="Al-Dwadmi">Al-Dwadmi</option>
            <option value="Al-Ahsa">Al-Ahsa</option>
            <option value="Hafer Albaten">Hafer Albaten</option>
            <option value="Al-Taif">Al-Taif</option>
            <option value="Mecca">Mecca</option>
            <option value="Unaizah">Unaizah</option>
            <option value="Buraidah">Buraidah</option>
            <option value="Al-Rass">Al-Rass</option>
            <option value="Tabuk">Tabuk</option>
        </select>
    </div>
</div>
                                <div class="col-xl-12 order-notes">
                                    <div class="checkout-form-list">
                                        <label for="order-notes"><?php echo lang('Validation.Order Notes') ?> (Optional)</label>
                                        <textarea name="delivery_note" value="<?php echo $delivery_note; ?>" cols="30" rows="10" placeholder="<?php echo lang('Validation.Note About Your Order') ?> . . ."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="your-order mb-30 ">
                            <h3><?php echo lang('Validation.Your order') ?></h3>
                            <div class="your-order-table table-responsive">
                                <table class="checkout-page__order-table">
                                    <thead class="checkout-page__order-table__heade">
                                        <tr>
                                            <th><?php echo lang('Validation.Product') ?></th>
                                            <th class="right"><?php echo lang('Validation.Subtotal') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($cart_data): ?>
                                        <?php foreach ($cart_data as $kaey => $vaalue): ?>
                                        <tr>
                                            <td class="pro__title">
                                                <?php echo $vaalue['p']['product_name']; ?> 
                                                <span>×&nbsp;<?php echo $vaalue['uqty']; ?></span>
                                            </td>
                                            <td class="pro__price">
                                                <?php echo $currency; ?><?php echo floatval($vaalue['our_price'] * $vaalue['uqty']) ; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                        <?php endif ?>
                                        <tr>
                                            <td class="pro__sub-title"><?php echo lang('Validation.Cart Amount') ?></td>
                                            <td class="checkout_sub_total_amount">
                                                <?php echo $currency; ?> <?php echo $price_summary['cart_price']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pro__sub-title"><?php echo lang('Validation.Shipping') ?></td>
                                            <td class="pro__sub-price checkout_shipping_amount">
                                                <?php if ($price_summary['shipping_amount'] == '0.00'): ?>
                                                Free
                                                <?php endif ?>
                                                <?php if ($price_summary['shipping_amount'] != '0.00'): ?>
                                                <?php echo $currency; ?> <?php echo $price_summary['shipping_amount']; ?>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pro__sub-title"><?php echo lang('Validation.Tax Amount') ?></td>
                                            <td class="pro__sub-price checkout_tax_amount">
                                                <?php echo $currency; ?> <?php echo floatval($price_summary['tax_amt']); ?>
                                            </td>
                                        </tr>
                                        <tr style="display: none;" class="che_voucher">
                                            <td class="pro__sub-title"><?php echo lang('Validation.Voucher Amount') ?></td>
                                            <td class="pro__sub-price checkout_voucher_amount">$0</td>
                                        </tr>
                                        <tr style="display: none;">
                                            <td class="pro__sub-title"><?php echo lang('Validation.Tip Amount') ?></td>
                                            <td class="pro__sub-price checkout_tip_amt">$0</td>
                                        </tr>
                                        <tr>
                                            <td class="pro__sub-title"><?php echo lang('Validation.Total') ?></td>
                                            <td class="pro__sub-price checkout_grand_total">
                                                <?php echo $currency; ?> <?php echo floatval($price_summary['total_cart'] + $add_amt); ?>
                                            </td>
                                        </tr>
                                        <tr style="display: none;">
                                            <td colspan="2">
                                                <div class="checkout-page__radio-box checkout-page__radio-box--right">
                                                    <!-- <div class="checkout-page__input-item custom-radio">
                                                        <input type="radio" value="online" id="online" name="payment_mode" class="custom-radio__input" >
                                                        <label for="online" class="custom-radio__title">Online</label>
                                                        </div> -->
                                                    <div class="checkout-page__input-item custom-radio">
                                                        <input type="radio" value="cash-on-del" id="cash-on-del" name="payment_mode" class="custom-radio__input" checked>
                                                        <label for="cash-on-del" class="custom-radio__title"><?php echo lang('Validation.Cash On Delivery') ?></label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="display: none;">
                                            <td colspan="2">
                                                <p class="add_distance"></p>
                                                <p class="checkout-page__order-text checkout_shipping_msg">Your personal data will be used to process your
                                                    order, support your experience throughout this website.
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="order-button-payment mt-20">
                                <button type="submit" class="bd-fill__btn"><?php echo lang('Validation.Place order') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
