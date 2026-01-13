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
                            <table id="seller_o_listing" class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th style="width: 13%;">Name</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Source</th>
                                        <th style="width: 16%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                    <?php if ($orders): ?>
                                    <?php foreach ($orders as $key => $value): ?>
                                        <tr>
                                            <td><?php echo $value['invoice_id'] ?></td>
                                            <td><?php echo $value['odata']['name'] ?></td>
                                            <td><?php echo $value['payment_mode'] ?></td>
                                            <td><?php echo $value['order_status'] ?></td>
                                            <td><?php echo $value['sub_total'] ?></td>
                                            <td><?php echo $value['created_date'] ?></td>
                                            <td><?php echo $value['source'] ?></td>
                                            <td>
                                                <a href="<?php echo base_url('admin/orders_view/') ?><?php echo $value['order_id'] ?>" target="_blank" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
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

<script type="text/javascript">
    $("document").ready(function() { 
        $(".order_tab").trigger('click');
        $(".o_listing").css({"color": "white"});
    });
    var table = $('#seller_o_listing').DataTable({
        pageLength : 25,
    // lengthMenu: [[2, 5, 10, 20, -1], [2, 5, 10, 20, 'Todos']]
    });
</script>