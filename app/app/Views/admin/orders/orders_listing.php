<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/buttons.dataTables.min.css">

<div class="vertical-overlay"></div>
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Order List</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboards</a></li>
                            <li class="breadcrumb-item active">Listing</li>
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
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                <small>Showing Summary: <button class="custome_date"></button></small>
                                <input type="hidden" class="start_date"  value="">
                                <input type="hidden" class="end_date"  value="">
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <br>
                                    <div class="col-sm-2 col-12">
                                        <div class="order_card card-body dd-flex align-items-center">
                                            <div class="row">
                                                <div class="text-center col">
                                                    <span class="order_count count_span"><?php echo $order_count; ?></span><br>
                                                    <small class="sm_cer">Total Orders</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-12">
                                        <div class="order_card card-body dd-flex align-items-center">
                                            <div class="row">
                                                <div class="text-center col">
                                                    <span class="acc_count count_span"><?php echo $acc_count; ?></span><br>
                                                    <small class="sm_cer">Accepted Orders</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-12">
                                        <div class="order_card s_order card-body dd-flex align-items-center">
                                            <div class="row">
                                                <div class="text-center col">
                                                    <span class="shipped_count count_span"><?php echo $shipped_count; ?></span><br>
                                                    <small class="sm_cer">Shipped Orders</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-12">
                                        <div class="order_card dis_order card-body dd-flex align-items-center">
                                            <div class="row">
                                                <div class="text-center col">
                                                    <span class="disp_count count_span"><?php echo $disp_count; ?></span><br>
                                                    <small class="sm_cer">Dispatch Orders</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-12">
                                        <div class="order_card d_order card-body dd-flex align-items-center">
                                            <div class="row">
                                                <div class="text-center col">
                                                    <span class="deli_count count_span"><?php echo $deli_count; ?></span><br>
                                                    <small class="sm_cer">Delivered Orders</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-12">
                                        <div tabindex="0" class="order_card can_order card-body dd-flex align-items-center">
                                            <div class="row">
                                                <div class="text-center col">
                                                    <span class="can_count count_span"><?php echo $can_count; ?></span><br>
                                                    <small class="sm_cer">Cancelled Orders</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-sm-4 mb-10">
                                        <label>Search</label>
                                        <input class="search_order_page" type="text" placeholder="Search Here..." id="search_value">
                                    </div>
                                    <div class="col-sm-4 mb-10">
                                        <label>Customer Listing</label>
                                        <select id='selUser' class='customer_id form-control'>
                                            <option value="">Search user</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 mb-10">
                                        <label>Filter By</label>
                                        <select class="form-control filter_by" name="filter_by" >
                                            <option value="">Select filter mode</option>
                                            <option value="payment_mode,cash-on-del">Cash Payment</option>
                                            <option value="payment_mode,online">Online Payment</option>
                                            <option value="payment_status,Paid">Payment Paid</option>
                                            <option value="payment_status,Unpaid">Payment Unpaid</option>
                                            <option value="order_status,Pending">Order Status Pending</option>
                                            <option value="order_status,Packed">Order Status Packed</option>
                                            <option value="order_status,Ready to ship">Order Status Ready to ship</option>
                                            <option value="order_status,Dispatched">Order Status Dispatched</option>
                                            <option value="order_status,delivered">Order Status delivered</option>
                                            <option value="order_status,canceled">Order Status canceled</option>
                                            <option value="source,Web">Website Added Order</option>
                                            <option value="source,android">Android Added Order</option>
                                            <option value="source,ios">IOS Added Order</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card table-card">
                    <?php if (!empty($orders)): ?>
                    <div class="chart-holder">
                        <div class="table-responsive">
                            <table id="order_listing" class="table table-styled mb-0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th style="width: 13%;">Name</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Source</th>
                                        <th style="width: 16%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <div id="pagination"><?php echo $pagination_link; ?></div>
                        </div>
                                    
                    </div>
                    
                    <?php endif ?>
                    <?php if (empty($orders)): ?>
                    <div class="card-body row">
                        <div class="col-sm-12">
                            <p>No orders found.</p>
                        </div>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>

<link href='<?php echo base_url();?>public/admin/select2.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url();?>public/admin/select2.min.js' defer></script>

<script src="<?php echo base_url();?>/public/admin/main_js/order_listing.js"></script>

<?php include(ROOTPATH."/app/Views/admin/orders/status_change_modal.php"); ?>
<?php include(ROOTPATH."/app/Views/admin/razorpay/payment_link_for_order.php"); ?>
<?php include(ROOTPATH."/app/Views/admin/razorpay/genrate_razorpay_qr_code.php"); ?>
