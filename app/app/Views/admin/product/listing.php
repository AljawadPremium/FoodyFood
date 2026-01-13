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
                    <h4 class="mb-sm-0"></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboards</a></li>
                            <li class="breadcrumb-item active">Product Listing</li>
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
                                <h4 class="card-title mb-0 checkbox_msg">Product listing</h4>
                            </div>
                            <div class="card-body row">

                                <div class="col-sm-3">
                                    <input class="form-control search_value" type="text" placeholder="Search Here..." id="search_btn">
                                </div>
                                <div class="col-sm-3 ">
                                    <select class="form-control cat_id">
                                        <option value="">Search by category</option>
                                        <?php if (!empty($category_l)): ?>
                                        <?php foreach ($category_l as $kaey => $valuae): ?>
                                            <option value="<?php echo $valuae['id']; ?>"><?php echo $valuae['display_name']; ?></option>
                                        <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select class="form-control filter_by">
                                        <option value="">Filter by</option>
                                        <option value="status,1">Active</option>
                                        <option value="status,0">Inactive</option>
                                        <option value="stock_status,instock">In Stock</option>
                                        <option value="stock_status,notinstock">Out Of Stock</option>
                                        <option value="stock,0">Zero Quantity</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select class="form-control sort_by">
                                        <option value="">Sory by</option>
                                        <option value="stock,ASC">Stock Ascending</option>
                                        <option value="stock,DESC">Stock Descending</option>
                                        <option value="product_name,ASC">Product name Ascending</option>
                                        <option value="product_name,DESC">Product name Descending</option>
                                        <option value="id,DESC">Newly Added first</option>
                                        <option value="id,ASC">Newly Added last</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 custome_checkbox">
                                    <input type="checkbox" name="product_checkbox" value="fast_moving" id="html" class="checkboxx">
                                    <label for="html">Fast Moving Products</label>
                                </div>
                                <div class="col-sm-3 custome_checkbox">
                                    <input type="checkbox" name="product_checkbox" value="slow_moving" id="shtml" class="checkboxx">
                                    <label for="shtml">Slow Moving Products</label>
                                </div>
                                <div class="col-sm-3 custome_checkbox">
                                    <input type="checkbox" name="product_checkbox" value="non_moving" id="nhtml" class="checkboxx">
                                    <label for="nhtml">Non Moving Products</label>
                                </div>
                                <div class="col-sm-3 custome_checkbox">
                                    <input type="checkbox" name="product_checkbox" value="most_viewed" id="most_html" class="checkboxx">
                                    <label for="most_html">Most Viewed Products</label>
                                </div>
                                <div class="ad_clear_btn">
                                    
                                </div>

                                <div class="col-sm-12 mt-20">
                                <table id="l_listing" class="table table-bordered table-striped align-middle dataTable no-footer">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Truck</th>
                                                    <th>Category name</th>
                                                    <th>Stock</th>
                                                    <th>Stock Status</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_body">
                                                <?php if (!empty($product)){ ?>
                                                <?php foreach ($product as $key => $value){ ?>
                                                <tr class="rowdelete_<?php echo $value['product_id']; ?>">

                                                    <td><?php echo $value['id']; ?></td>
                                                    <td><?php echo $value['product_name']; ?></td>
                                                    <td><?php echo $value['seller_id']; ?></td>

                                                    <td><?php echo $value['category_name']; ?></td>
                                                    <td><?php echo $value['stock']; ?></td>
                                                    <td><?php echo $value['stock_status']; ?></td>
                                                    <td><?php echo $value['status']; ?></td>
                                                    <td><?php echo $value['action_url']; ?></td>
                                                </tr>
                                                <?php } }else{ ?>
                                                    <tr colspan="12">Record Not Found.!!</tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-right">
                                        <div id="pagination"><?php echo $pagination_link; ?></div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>

<link href='<?php echo base_url();?>/public/admin/select2.min.css' rel='stylesheet' type='text/css'>
<script src='<?php echo base_url();?>/public/admin/select2.min.js'></script>
<script src="<?php echo base_url();?>/public/admin/main_js/product_listing.js"></script>