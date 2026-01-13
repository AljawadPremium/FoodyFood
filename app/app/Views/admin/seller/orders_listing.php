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
                            <li class="breadcrumb-item active">Order Listing</li>
                        </ol>
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
                            <table id="order_listing" class="table table-bordered table-striped align-middle">
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
                                    <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $key => $value): ?>
                                    <tr class="remove_<?php echo $value['order_id'] ?>">
                                        <td><?php echo $value['invoice_id'] ?></td>
                                        <td><a href="./admin/orders/view/'+v.order_id+'"><?php echo $value['customer_name'] ?></a></td>
                                        <td><?php echo $value['payment_mode'] ?></td>
                                        <td class="status_'+v.order_master_id+'" ><?php echo $value['order_status'] ?></td>
                                        <td><?php echo $value['payment_status'] ?></td>
                                        <td>$<?php echo $value['net_total'] ?></td>
                                        <td><?php echo $value['order_datetime'] ?></td>
                                        <td><?php echo $value['source'] ?></td>
                                        <td><?php echo $value['action_url'] ?></td>
                                        <?php endforeach ?>
                                        <?php endif ?>
                                </tbody>
                            </table>
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

<script type="text/javascript">
    $("document").ready(function() { 
        $(".order_tab").trigger('click');
        $(".seller_order_listing").css({"color": "white"});
    });
    var table = $('#order_listing').DataTable({
        pageLength : 25,
        // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
    });
</script>