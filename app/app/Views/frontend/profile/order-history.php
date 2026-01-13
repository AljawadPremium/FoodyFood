<!-- <section class="page-header">
    <div class="page-header__bg" style="background-image: url(<?php echo base_url('public/frontend/images/'); ?>backgrounds/page-header-bg.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title">My Account</h2>
        <ul class="boskery-breadcrumb list-unstyled">
            <li><a href="<?php echo base_url(''); ?>">Home</a></li>
            <li><span>Order Listing</span></li>
        </ul>
    </div>
</section> -->

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
                        Order Listing
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="checkout-page section-space">
    <div class="container">
        <div class="row mt-30 mb-20">
            <div class="row">
                <?php if (!empty($data)): ?>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <table id="example" class="table table-bordered table-striped align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Payment Mode</th>
                                    <th>TOTAL</th>
                                    <th>Customer Info</th>
                                    <th>Order Date</th>
                                    <th>Cancel Order</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $key => $value): ?>
                                    <tr>
                                        <?php if ($value['payment_mode'] == 'cash-on-del') {
                                            $value['payment_mode'] = 'Cash';
                                        }
                                        else if ($value['payment_mode'] == 'online') {
                                            $value['payment_mode'] = 'Online';
                                        } ?>
                                        <td><a href="<?php echo base_url('my_account/order_detail/') ?><?php echo en_de_crypt($value['display_order_id']); ?>"><?php echo $value['order_master_id']; ?></a></td>

                                        <td class="calcel_<?php echo en_de_crypt($value['order_master_id']); ?>">
                                            <a href="<?php echo base_url('my_account/order_detail/') ?><?php echo en_de_crypt($value['display_order_id']); ?>"><?php echo $value['order_status']; ?></a>
                                        </td>
                                        <td><?php echo $value['payment_status']; ?></td>
                                        <td><?php echo $value['payment_mode']; ?></td>
                                        <td><?php echo $currency; ?><?php echo $value['net_total']; ?></td>
                                        <td>
                                            <?php $out = mb_strimwidth($value['name'], 0, 15, "..."); ?>
                                            <?php echo $out; ?>
                                        </td>
                                        <td><?php $asd = date('F j, Y', strtotime($value['order_datetime'])); echo $asd; ?></td>
                                        <td>
                                            <?php if ($value['order_statuss'] == 'Pending'): ?>
                                                <a href="javascript:void()" data-id="<?php echo en_de_crypt($value['order_master_id']); ?>" class="btn-sm btn btn-success cancel_order hide_<?php echo en_de_crypt($value['order_master_id']); ?>">Cancel</a>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <a class="btn-sm btn btn-success" href="<?php echo base_url('invoice/pdf/') ?><?php echo en_de_crypt($value['order_master_id']); ?>" target="_blank"><i class="fa fa-download mr-2 "></i></a>
                                            <a class="btn-sm btn btn-warning" href="<?php echo base_url('my_account/order_detail/') ?><?php echo en_de_crypt($value['display_order_id']); ?>" ><i class="fa fa-eye mr-2 "></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                <?php endif ?>

                <?php if (empty($data)): ?>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body cart">
                                <div class="col-sm-6 empty-cart-cls text-center" style="margin: 0px auto;"><img src="https://i.imgur.com/dCdflKN.png" width="130" height="130" class="img-fluid mb-4 mr-3">
                                    <h3><strong>No orders found</strong></h3>
                                    <p>Before proceed to checkout you must add some products to your shopping cart. You will find a lot of interesting products on our "Home" page.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>
</section>
<style type="text/css">
    table#example
    {
        font-size: 14px;
    }
    a
    {
        color: inherit;
    }
    #toast-container {
        font-size: 14px;
    }
    .prof_li a{
        color: #88c73f!important;
    }
    .badge-warning{color:#212529;background-color:#ffc107}
    .badge-dark{color:#fff;background-color:#343a40}
    .badge-primary{color:#fff;background-color:#007bff}
    .badge-info{color:#fff;background-color:#17a2b8}
    .badge-success{color:#fff;background-color:#28a745}
    .badge-danger{color:#fff;background-color:#dc3545}
</style>