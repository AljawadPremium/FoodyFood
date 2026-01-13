<?php
$order_id = $orders['order_id'];
$order_status = $orders['order_status'];
$payment_status = $orders['payment_status'];
$order_comment = $orders['order_comment'];
$driver_comment = "";
$delivery_date = $orders['delivery_date'];
$driver_id = $orders['driver_id'];
$order_cancel_reason = $orders['order_cancel_reason'];
$order_cancel_date_time = $orders['order_cancel_date_time'];

$packed_date_time = $orders['packed_date_time'];
$ready_to_ship_date_time = $orders['ready_to_ship_date_time'];
$delivered_date_time = $orders['delivered_date_time'];
$canceled_date_time = $orders['canceled_date_time'];
$payment_mode = $orders['payment_mode'];
$admin_note = $orders['admin_note'];
if ($payment_mode == 'cash-on-del') {
    $payment_mode = 'Cash';
}else if ($payment_mode == 'online') {
    $payment_mode = 'Online';
}
?>

<div class="vertical-overlay"></div>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><?php echo $orders['name']; ?>
                            <span class="det chip__content"> <?php echo $orders['order_count']; ?> Order</span>
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/order/listing') ?>">Order Listing</a></li>
                                <li class="breadcrumb-item active">Order details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class=" res_div col-sm-3">
                                            <input type="hidden" class="order_master_id" value="<?php echo en_de_crypt($orders['order_master_id']); ?>">
                                            <input type="hidden" class="d_order_id" value="<?php echo $invoice_data['invoice_id']; ?>">
                                            <label>Order Status</label>
                                            <select  class="o_status form-control"  name="order_status" >
                                                <option value="" disabled="">Select Order Status :</option>
                                                <option value="Pending" <?php if( $order_status == "Pending" ) echo "Selected"; ?> >Pending</option>
                                                <option <?php if( $order_status == "Packed" ) echo "Selected"; ?> value="Packed">Packed</option>
                                                <option <?php if( $order_status == "Ready to ship" ) echo "Selected"; ?> value="Ready to ship">Ready to ship</option>
                                                <option <?php if( $order_status == "Dispatched" ) echo "Selected"; ?> value="Dispatched">Dispatched</option>
                                                <option <?php if( $order_status == "delivered" ) echo "Selected"; ?> value="delivered">Delivered</option>
                                                <option <?php if( $order_status == "canceled" ) echo "Selected"; ?> value="canceled">Canceled</option>
                                            </select>
                                        </div>
                                        <div class=" res_div col-sm-3">
                                            <label>Payment Status</label>
                                            <select  class="form-control p_status" name="payment_status">
                                                <option value="Paid" <?php if( isset($payment_status) && $payment_status == "Paid" ) echo "Selected"; ?> >Paid</option>
                                                <option value="Unpaid" <?php if( isset($payment_status) && $payment_status == "Unpaid" ) echo "Selected"; ?> >Unpaid</option>
                                                <option value="pay_later" <?php if( isset($payment_status) && $payment_status == "pay_later" ) echo "Selected"; ?> >Pay later</option>
                                            </select>
                                        </div>
                                        
                                        <div class=" res_div col-sm-12 col-md-12 hh-grayBox">
                                            <div class="row justify-content-between">
                                                <div class="order-tracking completed">
                                                    <span class="is-complete"></span>
                                                    <p>Ordered<br><span><?php echo date("D, d F, g:i a",strtotime($orders['order_datetime'])); ?></span></p>
                                                </div>
                                                <?php 
                                                    $s1_completed = $s2_completed = $s3_completed = $s4_completed = $packed = $ready_to_ship_d = $delivered_d = $canceled_d = '';
                                                    if (!empty($packed_date_time)) {
                                                        $s1_completed = 'completed';
                                                        $packed = date("D, d F, g:i a",strtotime($orders['packed_date_time']));
                                                    }if (!empty($ready_to_ship_date_time)) {
                                                        $s2_completed = 'completed';
                                                        $ready_to_ship_d = date("D, d F, g:i a",strtotime($orders['ready_to_ship_date_time']));
                                                    }if (!empty($delivered_date_time)) {
                                                        $s3_completed = 'completed';
                                                        $delivered_d = date("D, d F, g:i a",strtotime($orders['delivered_date_time']));
                                                    }if (!empty($canceled_date_time)) {
                                                        $s4_completed = 'completed';
                                                        $canceled_d = date("D, d F, g:i a",strtotime($orders['canceled_date_time']));
                                                    }
                                                    ?>
                                                <div class="order-tracking <?php echo $s1_completed ?>">
                                                    <span class="is-complete"></span>
                                                    <p>Packed<br><span><?php echo $packed; ?></span></p>
                                                </div>
                                                <div class="order-tracking <?php echo $s2_completed ?>">
                                                    <span class="is-complete"></span>
                                                    <p>Shipped<br><span><?php echo $ready_to_ship_d; ?></span></p>
                                                </div>
                                                <div class="order-tracking <?php echo $s3_completed ?>">
                                                    <span class="is-complete"></span>
                                                    <p>Delivered<br><span><?php echo $delivered_d; ?></span></p>
                                                </div>
                                                <div class="order-tracking <?php echo $s4_completed ?>">
                                                    <span class="is-complete"></span>
                                                    <p>Cancelled<br><span><?php echo $canceled_d; ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="o_box">
                                                <div class="o_label"> OID </div>
                                                <div class="o_labe"> #<?php echo $orders['order_master_id']; ?> </div>
                                            </div>
                                            <div class="o_box">
                                                <div class="o_label"> Payment Mode </div>
                                                <div class="o_labe"> <?php echo $payment_mode; ?> </div>
                                            </div>
                                            <div class="o_box">
                                                <div class="o_label"> Payment Status </div>
                                                <div class="o_labe"> <?php echo $orders['payment_status']; ?> </div>
                                            </div>
                                            <div class="o_box">
                                                <div class="o_label"> Order Amount </div>
                                                <div class="o_labe"> <?php echo $currency; ?> <?php echo $invoice_data['sub_total']; ?> </div>
                                            </div>
                                            <div class="o_box">
                                                <div class="o_label"> Source </div>
                                                <div class="o_labe"> <?php echo $orders['source']; ?> </div>
                                            </div>
                                            <div class="o_box">
                                                <div class="o_label"> Order Date </div>
                                                <div class="o_labe"> <?php echo date("D, h:i A",strtotime($orders['order_datetime'])); ?> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"><br></div>
                                    <div class="clear">
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="heading_red">Order details</span>
                                        </div>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div"> User id </div>
                                            <div class="o_div_am"><?php echo $orders['user_id']; ?></div>
                                        </div>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div"> Display Order Id </div>
                                            <div class="o_div_am"><?php echo $orders['display_order_id']; ?></div>
                                        </div>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div"> Customer Name </div>
                                            <div class="o_div_am c_nasme"> <?php echo $orders['name']; ?> </div>
                                        </div>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div"> Mobile Number </div>
                                            <div class="o_div_am"> +91 <?php echo $orders['mobile_no']; ?> </div>
                                        </div>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div"> Email </div>
                                            <div class="o_div_am"> <?php echo $orders['email']; ?> </div>
                                        </div>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div"> Payment Status </div>
                                            <div class="o_div_am"><?php echo $orders['payment_status']; ?> </div>
                                        </div>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div"> Order Status </div>
                                            <div class="o_div_am"> <?php echo $orders['order_status']; ?> </div>
                                        </div>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div"> Code Applied? </div>
                                            <div class="o_div_am">
                                                <?php if ($orders['voucher_code']) 
                                                {
                                                    echo "Yes";
                                                }
                                                else{ 
                                                    echo "No"; 
                                                } ?>
                                            </div>
                                        </div>
                                        <?php if ($orders['voucher_code']): ?>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div"> Code Details </div>
                                            <div class="o_div_am">
                                                <?php
                                                    echo $orders['voucher_code'];
                                                    $added = explode("-", $orders['voucher_type']);
                                                    if (substr($added[1], -3) === '.00') {
                                                        $a_str = substr($added[1], 0, -3);
                                                    }

                                                    if ($added[0] == 'percent') {
                                                        echo "(".$a_str."%)";
                                                    }
                                                    else{
                                                        echo "(Flat ".$a_str." OFF)";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <?php endif ?>

                                        <div class="col-md-3 order_details">
                                            <div class="o_div"> Payment Mode </div>
                                            <div class="o_div_am"> <?php echo $payment_mode; ?> </div>
                                        </div>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div">Order Date & Time </div>
                                            <div class="o_div_am"> <?php echo date("D d M Y, H:i",strtotime($orders['order_datetime'])); ?> </div>
                                        </div>
                                        <?php if ($orders['order_cancel_date_time']): ?>
                                        <div class="col-md-3 order_details">
                                            <div class="o_div">Order cancel date time </div>
                                            <div class="o_div_am"> <?php echo date("D d M Y, H:i",strtotime($orders['order_cancel_date_time'])); ?> </div>
                                        </div>
                                        <div class="col-md-6 order_details">
                                            <div class="o_div">Cancel reason </div>
                                            <div class="o_div_am"> <?php echo $orders['order_cancel_reason']; ?> </div>
                                        </div>
                                        <?php endif ?>
                                    </div>
                                    <div class="clear">
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="heading_red">Delivery Address</span>
                                        </div>
                                        <div class="col-md-6 order_details">
                                            <div class="o_div"> Address </div>
                                            <div class="o_div_am">
                                                <?php echo $orders['landmark']; ?> <?php echo $orders['address']; ?>
                                            </div>
                                            <br>
                                            <div class="o_div">Area/City</div>
                                            <div class="o_div_am">
                                                <?php echo $orders['area']; ?> <?php echo $orders['city']; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 order_details">
                                            <div class="o_div"> Admin Comment </div>
                                            <textarea style="min-height: 50px;" class="admin_comment form-control" name="admin_note"><?php echo $admin_note; ?></textarea>
                                            <span class="a_comment_submit">Submit</span>
                                        </div>
                                        <div class="col-md-6 order_details">
                                            <div class="o_div"> Extra Notes / Delivery note </div>
                                            <div class="o_div_am extr_notes"> <?php echo $orders['delivery_note']; ?> </div>
                                        </div>
                                    </div>
                                    <div class="clear">
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="heading_red">Order Item</span>
                                        </div>
                                        <div class="col-sm-12">
                                            <table class="rwd-table">
                                                <tbody>
                                                    <tr>
                                                        <th>#</th>
                                                        <th class="col-sm-3">Name</th>
                                                        <th>Add Extra</th>
                                                        <th>Size</th>
                                                        <th>Unit</th>
                                                        <th>Amount</th>
                                                        <!-- <th>Tax</th> -->
                                                        <th>Extra Cost</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    <?php if ($data_items): ?>
                                                    <?php foreach ($data_items as $skey => $svalue): ?>
                                                    <tr>
                                                        <td class="asaa"><?php echo $skey+1; ?></td>
                                                        <td class="asaa pname"><?php echo $svalue['product_name']; ?></td>
                                                        <td class="asaa pname">
                                                            <?php if ($svalue['extra_added']): ?>
                                                            <?php 
                                                                $added = explode(",--", $svalue['extra_added']);
                                                                foreach ($added as $key => $value) {
                                                                    if ($value) {
                                                                        echo $value.'<br>';
                                                                    }
                                                                }
                                                                ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="asaa p_unit"><?php echo @$svalue['attribute']; ?></td>
                                                        <td class="asaa"><?php echo $svalue['quantity']; ?></td>
                                                        <td class="asaa"><?php echo $currency; ?> <?php echo $svalue['price']; ?></td>
                                                        <!-- <td class="asaatax_lbl"><?php echo $currency; ?> <?php echo $svalue['tax']; ?></td> -->
                                                        <td class="asaatax_lbl"><?php echo $currency; ?> <?php echo $svalue['extra_added_amt']; ?></td>
                                                        <td class="asaa n_total"><?php echo $currency; ?> <?php echo $svalue['sub_total'] + $svalue['extra_added_amt']; ?></td>
                                                    </tr>
                                                    <?php endforeach ?>
                                                    <?php endif ?>
                                                    <tr class="">
                                                        <td class="fle" colspan="7">Product Total</td>
                                                        <td class="td_label" colspan="1"><?php echo $currency; ?> <?php echo $invoice_data['sub_total']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(ROOTPATH."/app/Views/admin/orders/order_notifi_send.php"); ?>
<?php include(ROOTPATH."/app/Views/admin/razorpay/payment_link_for_order.php"); ?>
<?php include(ROOTPATH."/app/Views/admin/razorpay/genrate_razorpay_qr_code.php"); ?>

<script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<link href='<?php echo base_url();?>/public/admin/select2.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url();?>/public/admin/select2.min.js'></script>
<script src='<?php echo base_url(); ?>public/admin/main_js/seller_order_view.js'></script>