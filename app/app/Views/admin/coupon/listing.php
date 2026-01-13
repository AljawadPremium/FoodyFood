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
                    <h4 class="mb-sm-0">Coupons</h4>
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
                                <h4 class="card-title mb-0" style="float: right;">
                                    <a class="btn btn-primary model_btnn" href="javascript:void(0);" data-toggle="modal" data-target="#voucher_model">Create New Coupon</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <table id="v_listing" data-order='[[ 0, "desc" ]]'  class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Code</th>
                                        <th>Discount</th>
                                        <th>Applicable between</th>
                                        <th>Private</th>
                                        <th>Method</th>
                                        <th>Use type</th>
                                        <th>Status</th>
                                        <th class="action_tab">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($data): ?>
                                    <?php foreach ($data as $key => $value): ?>
                                    
                                    <tr class="coupon_<?php echo en_de_crypt($value['id']); ?>">
                                        <td><?php echo $value['id']; ?></td>
                                        <td><?php echo $value['code']; ?></td>
                                        <td>
                                            <?php
                                            if ($value['type'] == 'percent') {
                                                echo $value['amount']." %";
                                            }
                                            else if ($value['type'] == 'flat') {
                                                echo $value['amount']." $";
                                            }
                                            ?> 
                                            <?php if ($value['max_discount']): ?>
                                                <br>
                                                (<b style="font-size:11px;">Max <?php echo $value['max_discount']; ?> <?php echo $currency; ?> Discount </b>)
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if ($value['start_date']): ?>
                                            <?php echo date('M j, Y', strtotime($value['start_date'])); ?>
                                            -
                                            <?php echo date('M j, Y', strtotime($value['end_date'])); ?>
                                            <?php endif ?>
                                            
                                        </td>
                                        <td><?php echo $value['private_coupon']; ?></td>
                                        <td><?php echo $value['payment_method']; ?></td>
                                        <td><?php echo $value['use_type']; ?></td>
                                        <td><?php echo $value['status']; ?></td>
                                        <td class="action_tab">
                                            <a class="detete_coupon" data-id="<?php echo en_de_crypt($value['id']); ?>" href="javascript:void(0)" >
                                                <button class="btn btn-sm btn-success"><i class="fa fa-trash "></i></button>
                                            </a>
                                            <a class="edit" data-id="<?php echo $value['id']; ?>" target="_blank">
                                                <button class="btn btn-sm btn-warning"><i class="fa fa-pencil "></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
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

<div class="modal" id="voucher_model">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create new coupon</h4>
                <button type="button" class="close close_modal" data-dismiss="modal">&times;</button>
            </div>
            
            <form class="coupon_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="member-name" class="col-form-label">Coupon code</label>
                            <input class="form-control" type="text" placeholder="Coupon code" id="code" name="code">
                            <label class="error_show code"></label>
                        </div>
                        <div class="col-md-4">
                            <label for="member-name" class="col-form-label">Start date</label>
                            <input class="form-control" type="date" placeholder="Start date" id="start_date" name="start_date">
                            <label class="error_show start_date"></label>
                        </div>
                        <div class="col-md-4">
                            <label for="member-name" class="col-form-label">End date</label>
                            <input class="form-control" type="date" placeholder="End date" id="end_date" name="end_date">
                            <label class="error_show end_date"></label>
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="col-form-label">Status</label>
                            <select class="select2 form-control ce_status" name="status">
                                <option value="Active">Active</option>
                                <option value="Deactive">Deactive</option>
                            </select>
                            <label class="error_show status"></label>
                        </div>

                        <div class="col-md-4">
                            <label for="city" class="col-form-label">Only if payment method</label>
                            <select class="select2 form-control" id="payment_method" name="payment_method">
                                <option value="both">Both Online & Cash</option>
                                <option value="online">Online</option>
                                <option value="cod">Cash On delivery</option>
                            </select>
                            <label class="error_show payment_method"></label>
                        </div>

                        <div class="col-md-4">
                            <label for="city" class="col-form-label">Discount By?</label>
                            <select class="select2 form-control" id="type" name="type">
                                <option value="percent">Percent</option>
                                <option value="flat">Flat Amount</option>
                            </select>
                            <label class="error_show type"></label>
                        </div>
                        <div class="col-md-4">
                            <label for="member-name" class="col-form-label">Amount Discount</label>
                            <input class="form-control" type="text" placeholder="Amount" id="amount" name="amount">
                            <label class="error_show amount"></label>
                        </div>
                        <div class="col-md-4">
                            <label for="member-name" class="col-form-label">Minimum Order</label>
                            <input class="form-control" type="text" placeholder="Minimum Order" id="min_amount_to_apply" name="min_amount_to_apply">
                            <label class="error_show min_amount_to_apply"></label>
                        </div>

                        <div class="col-md-4">
                            <label for="city" class="col-form-label">Is it a private coupon?</label>
                            <select class="select2 form-control" id="private_coupon" name="private_coupon">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <label class="error_show private_coupon"></label>
                        </div>

                        <div class="col-md-4">
                            <label for="city" class="col-form-label">Is it One time/Multiple time use</label>
                            <select class="select2 form-control" id="use_type" name="use_type">
                                <option value="one">One time</option>
                                <option value="multiple">Multiple time</option>
                            </select>
                            <label class="error_show use_type"></label>
                        </div>


                        <div class="col-md-4 max_order">
                            <label for="member-name" class="col-form-label">Maximum Discount(optional)</label>
                            <input class="form-control" type="number" placeholder="Max discount up to" id="max_discount" name="max_discount">
                            <label class="error_show max_discount"></label>
                        </div>

                        <!-- <div class="col-md-4">
                            <label for="city" class="col-form-label">City</label>
                            <select class="select2 form-control" id="city_id" name="city_id">
                            </select>
                            <label class="error_show city_id"></label>
                        </div> -->

                        <div class="col-md-12">
                            <label class="col-form-label">Title</label>
                            <input class="form-control" type="text" placeholder="Enter Title" id="title" name="title">
                            <label class="error_show title"></label>
                        </div>

                        <div class="col-md-12">
                            <label for="additional-msg" class="col-form-label">Description</label>
                            <textarea class="form-control" placeholder="Description" id="description" name="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>
<script src="<?php echo base_url();?>/public/admin/main_js/voucher_listing.js"></script>
<style type="text/css">
    .coupon_form .form-control {
        margin-bottom: 0px !important;
    }
    label.error_show {
    color: red;
    text-align: center;
    width: 100%;
    margin-top: 5px;
    font-weight: bold;
}
.close_modal {
    background: transparent;
    border: none;
    font-size: 18px;
}
.edit
{
    cursor: pointer;
}
</style>