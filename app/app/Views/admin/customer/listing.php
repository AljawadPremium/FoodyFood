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
                    <h4 class="mb-sm-0">Customer</h4>
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
                            <div class="card-header p_select_checkbox">
                                <h4 class="card-title mb-0"><button class="delete_selected">Delete Selected Customer</button></h4>
                            </div>
                            <div class="card-body row">

                                <div class="col-sm-4">
                                    <label>Search</label>
                                    <input class="search_order_page" type="text" placeholder="Search Here..." id="search_val">
                                </div>

                                <div class="col-sm-4">
                                    <label>Filter By</label>
                                    <select class="form-control filter_by" name="filter_by" >
                                        <option value="">Select filter mode</option>
                                        <option value="freq_customer">Frequent Customer (Customers who have ordered twice or more in the last 1 week)</option>
                                        <option value="one_order">One Order Customer (Customers who have ordered only once in the last 2 months)</option>
                                        <option value="no_order">No Order Customer (Customers who have not ordered even once in the last 2 months)</option>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label>Sort By</label>
                                    <select class="form-control sort_by" name="sort_by" >
                                        <option value="">Select SORT BY</option>
                                        <option value="id,DESC">Latest First</option>
                                        <option value="id,ASC">Latest Last</option>
                                        <!-- <option value="wallet_amount,DESC">Wallet Amount High</option> -->
                                        <!-- <option value="wallet_amount,ASC">Wallet Amount Less</option> -->
                                    </select>
                                </div>

                                <div class="col-sm-12 pt-3">
                                    <table id="customer_listing" class="table table-bordered table-striped align-middle dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Register Date</th>
                                                <th>Source</th>
                                                <th>Total Order</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                        </tbody>
                                    </table>
                                    <div class="text-right">
                                        <div id="pagination"></div>
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

<?php include(ROOTPATH."/app/Views/admin/customer/customer_notification.php"); ?>

<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>


<link href='<?php echo base_url();?>public/admin/select2.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url();?>public/admin/select2.min.js'></script>

<script src="<?php echo base_url();?>/public/admin/main_js/customer_listing.js"></script>
