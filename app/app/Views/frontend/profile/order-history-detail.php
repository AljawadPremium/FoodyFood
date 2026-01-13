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
                        Order Detail
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/js/thank_you_page.css">
<a class="backk" href="<?php echo base_url('my_account/orders'); ?>">Back to order listing</a>
<section class="section-b-space" style="clear: both;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 thnkyou_order6">
                <div class="product-order">
                    <div class="row product-order-detail" style="margin-top: 0px;">
                        <div class="col-3 order_detail prodct_name_as">
                            <div>
                                <h4>product name</h4>
                            </div>
                        </div>
                        <div class="col-2 order_detail qnty_wrp">
                            <div>
                                <h4>quantity</h4>
                            </div>
                        </div>
                        <div class="col-2 order_detail pric_right">
                            <div>
                                <h4>price</h4>
                            </div>
                        </div>
                        <div class="col-2 order_detail pric_right">
                            <div>
                                <h4>Total</h4>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($order_item)): ?>
                        <?php foreach ($order_item as $key => $value): ?>
                            <div class="row product-order-detail">
                                <div class="col-3 order_detail prodct_name_as">
                                    <div>
                                        <h5><?php echo $value['product_name']; ?>
                                        <?php if (!empty($value['attribute']))
                                        {
                                            echo $value['attribute'];
                                        } ?>
                                        <br>
                                        <a class="add_review" href="<?php echo base_url('product/review/') ?><?php echo en_de_crypt($value['product_id']); ?>/?v=<?php echo en_de_crypt($data['display_order_id']); ?>">Write a product review</a>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-2 order_detail qnty_wrp">
                                <div>
                                    <h5><?php echo $value['quantity']; ?></h5>
                                </div>
                            </div>
                            <div class="col-2 order_detail pric_right">
                                <div>
                                    <h5><?php echo $currency; ?><?php echo $value['price']; ?> </h5>
                                </div>
                            </div>
                            <div class="col-2 order_detail pric_right">
                                <div>
                                    <h5><?php echo $currency; ?><?php echo $value['price'] * $value['quantity']; ?> </h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
                <div class="total-sec">
                    <ul>
                        <li>Total Price : <span><?php echo $currency; ?><?php echo $data['sub_total']; ?> </span></li>
                        <li>Delivery Charges : <span><?php echo $currency; ?><?php echo floatval($data['shipping_charge']); ?> </span></li>
                        <?php if ($data['voucher_amount']): ?>
                            <li>Voucher amount : <span><?php echo $currency; ?><?php echo floatval($data['voucher_amount']); ?> </span></li>
                        <?php endif ?>
                        <?php if ($data['wallet_amount'] > 0): ?>
                            <li>Wallet amount : <span><?php echo $currency; ?><?php echo number_format((float)$data['wallet_amount'], 2, '.', ''); ?> </span></li>
                        <?php endif ?>
                        <?php if ($data['account_minus']): ?>
                            <li>Prevoius amount : <span> <?php echo $currency; ?><?php echo number_format((float)$data['account_minus'], 2, '.', ''); ?> </span></li>
                        <?php endif ?>
                        <li style="display: none;">GST : <span><?php echo $currency; ?><?php echo number_format((float)$data['tax'], 2, '.', ''); ?> </span></li>
                    </ul>
                </div>
                <div class="final-total">
                    <h3>Total  : <span><?php echo $currency; ?><?php echo $data['net_total']; ?></span></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-6 thnkyou_order6">
            <div class="row order-success-sec">
                <?php if ($t_details): ?>
                    <div class="col-sm-6">
                        <h4>Transaction details</h4>
                        <ul class="order-detail">
                            <li>Payment Id: <?php echo $t_details[0]['payment_id']; ?></li>
                            <li>Payment method: <?php echo $t_details[0]['method']; ?></li>
                            <li>Payment Date: <?php $t_details[0]['created_at'] = date('F j, Y, g:i a' ,strtotime($data['order_datetime']));
                            echo $data['order_datetime'];  ?> </li>
                        </ul>
                    </div>
                <?php endif ?>
                <div class="col-sm-6">
                    <h4>Summary</h4>
                    <ul class="order-detail">
                        <li>Order Id: <?php echo $data['display_order_id']; ?></li>
                        <li>Order Date: <?php $data['order_datetime'] = date('F j, Y, g:i a' ,strtotime($data['order_datetime']));
                        echo $data['order_datetime'];  ?> </li>
                        <?php if ($data['account_minus']): ?>
                            <li>Account minus: <?php echo $currency; ?> <?php echo $data['account_minus']; ?></li>
                            <li>Account minus reason:<?php echo $data['account_minus_reason']; ?></li>
                        <?php endif ?>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <br>
                    <h4>shipping/Billing address</h4>
                    <ul class="order-detail">
                        <li><?php echo $data['landmark']; ?> </li>
                        <li><?php echo $data['address']; ?> </li>                        
                    </ul>
                </div>
                <div class="col-sm-6 payment-mode" style="text-transform: capitalize;">
                    <h4>Customer Details</h4>
                    <ul class="order-detail">
                        <li><?php echo $data['name']; ?> </li>
                        <li><?php echo $data['mobile_no']; ?></li>
                        <li><?php echo $data['email']; ?></li>
                        <?php
                        if ($data['payment_mode'] == 'cash-on-del') {
                            $data['payment_mode'] = 'Cash';
                        }
                        else{
                            $data['payment_mode'] = 'Online';
                        }
                        ?>
                        <!-- <li>Payment method - <?php echo $data['payment_mode']; ?></li> -->
                    </ul>
                </div>
                <br>
                <div class="col-sm-6 payment-mode">
                    <h4>Payment Details</h4>
                    <ul class="order-detail">
                        <li>Payment Status - <?php echo $data['payment_status']; ?> </li>
                        <li>Payment Mode - <?php echo $data['payment_mode']; ?> </li>
                        <?php if ($data['delivery_note']): ?>
                            <li>Delivery note - <?php echo $data['delivery_note']; ?> </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
</section>
<style type="text/css">
    .col-sm-6.payment-mode {
        margin-bottom: 20px;
        margin-top: 20px;
    }
    .backk
    {
        float: right;
        display: block;
        margin-right: 40px;
        border: none;
        background: transparent;
        padding: 20px;
    }
    .prof_li a{
        color: #88c73f!important;
    }

</style>