<div class="vertical-overlay"></div>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customer view
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/customer') ?>">Customer Listing</a></li>
                                <li class="breadcrumb-item active">View</li>
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
                                    <h4 class="card-title mb-0">Update information</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" id="customer_form_update">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="hidden" class="customer_id" value="<?php echo $data['c_id']; ?>">
                                                <div class="form-group">
                                                    <label for="member-name" class="col-form-label">First Name</label>
                                                    <input class="form-control" name="first_name" type="text" placeholder="Enter Your First Name" value="<?php echo $data['first_name'] ?>">
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="member-name" class="col-form-label">Last Name</label>
                                                    <input class="form-control" name="last_name" type="text" placeholder="Enter Your last name" value="<?php echo $data['last_name'] ?>">
                                                </div>
                                            </div> -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="member-email" class="col-form-label">Your Email</label>
                                                    <input class="form-control" name="email" type="email" placeholder="Enter Your Email" value="<?php echo $data['email'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="member-email" class="col-form-label">Your Phone</label>
                                                    <input class="form-control" name="phone" type="number" placeholder="Enter Your Phone" value="<?php echo $data['phone'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="member-email" class="col-form-label">Status</label>
                                                    <select class="select2 form-control" name="active">
                                                        <option <?php if($data['active']==='1') echo 'selected="selected"';?> value="1">Active</option>
                                                        <option <?php if($data['active']==='0') echo 'selected="selected"';?> value="0">De active</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="member-email" class="col-form-label">Your Password (<?php echo $data['password_show'] ?>)</label>
                                                    <input class="form-control" name="password" type="number" placeholder="Enter Your Phone" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="mt-10 btn btn-danger">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Order History</h4>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($orders)): ?>
                                    <table class="table table-striped table-bordered dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Payment Mode</th>
                                                <th>Payment</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                            <?php foreach ($orders as $key => $value): ?>
                                            <tr>
                                                <td><a href="<?php echo base_url('admin/orders/view/') ?><?php echo $value['order_id']; ?>"><?php echo $value['order_master_id']; ?></a></td>
                                                <td>
                                                    <a href="<?php echo base_url('admin/orders/view/') ?><?php echo $value['order_id']; ?>"><?php echo $value['name']; ?></a>
                                                </td>
                                                <td>
                                                    <?php if ($value['payment_mode'] == 'cash-on-del'): ?>
                                                    Cash
                                                    <?php endif ?>
                                                    <?php if ($value['payment_mode'] != 'cash-on-del'): ?>
                                                    Online
                                                    <?php endif ?>
                                                </td>
                                                <td><?php echo $value['payment_status']; ?></td>
                                                <td><?php echo $currency; ?> <?php echo $value['net_total']; ?></td>
                                                <td><?php echo $value['order_datetime']; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                    <?php endif ?>
                                    <?php if (empty($orders)): ?>
                                        <span>No order found.</span>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Wishlist Products</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Product Name</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                            <?php if (!empty($wish_list_products)): ?>
                                            <?php foreach ($wish_list_products as $key => $value): ?>
                                            <tr>
                                                <td><?php echo $value['id']; ?></td>
                                                <td><?php echo $value['product_name']; ?></td>
                                            </tr>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                            <?php if (empty($wish_list_products)): ?>
                                            <tr>
                                                <td colspan="4">No product has been added to the wishlist.</td>
                                            </tr>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Latest Purchase Products</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Product Name</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                            <?php if (!empty($purchase_product)): ?>
                                            <?php foreach ($purchase_product as $key => $value): ?>
                                            <tr>
                                                <td><?php echo $value['product_id']; ?></td>
                                                <td><?php echo $value['product_name']; ?></td>
                                                <td><?php echo $value['quantity']; ?></td>
                                                <td><?php echo $currency; ?> <?php echo $value['price']; ?></td>
                                                <td><?php echo $currency; ?> <?php echo $value['sub_total']; ?></td>
                                            </tr>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                            <?php if (empty($purchase_product)): ?>
                                            <tr>
                                                <td colspan="6">No product has been purchased yet.</td>
                                            </tr>
                                            <?php endif ?>
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

<script src="<?php echo base_url();?>/public/admin/main_js/customer_view.js"></script>