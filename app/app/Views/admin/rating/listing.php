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
                    <h4 class="mb-sm-0">Rating & Reviews</h4>
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
                                    <a class="btn btn-primary model_btnn" href="javascript:void(0);" data-toggle="modal" data-target="#ce_model">Create</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <table id="v_listing" data-order='[[ 0, "desc" ]]'  class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Order</th>
                                        <th>Product</th>
                                        <th>Username</th>
                                        <th>Rating</th>
                                        <th>Title</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="action_tab">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($data): ?>
                                    <?php foreach ($data as $key => $value): ?>
                                    
                                    <tr class="rating_<?php echo en_de_crypt($value['id']); ?>">
                                        <td><?php echo $value['id']; ?></td>
                                        <td><?php echo $value['order_id']; ?></td>
                                        <td><?php echo $value['pid']; ?></td>
                                        <td><?php echo $value['name']; ?></td>
                                        <td><?php echo $value['rating']; ?></td>
                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo $value['comment']; ?></td>
                                        <td><?php echo $value['status']; ?></td>
                                        
                                        <td>
                                            <?php echo date('M j, Y', strtotime($value['created_date'])); ?>
                                        </td>
                                        <td class="action_tab">
                                            <a class="detete_tr" data-id="<?php echo en_de_crypt($value['id']); ?>" href="javascript:void(0)" >
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

<div class="modal" id="ce_model">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create</h4>
                <button type="button" class="close close_modal" data-dismiss="modal">&times;</button>
            </div>
            
            <form class="ce_form" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="member-name" class="col-form-label">User</label>
                            <select class="select2 form-control ce_uid" name="uid">
                                <?php if (!empty($user_list)): ?>
                                <?php foreach ($user_list as $ukey => $uvalue): ?>
                                    <option value="<?php echo $uvalue['id']; ?>"><?php echo $uvalue['first_name']; ?></option>
                                <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="member-name" class="col-form-label">Product</label>
                            <select class="select2 form-control ce_pid" name="pid">
                                <?php if (!empty($product_list)): ?>
                                <?php foreach ($product_list as $key => $ualue): ?>
                                    <option value="<?php echo $ualue['id']; ?>"><?php echo $ualue['product_name']; ?></option>
                                <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">Title</label>
                            <input class="form-control ce_title" type="text" placeholder="Enter title" name="title">
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label">Comment</label>
                            <textarea class="form-control ce_comment" placeholder="Description" name="comment"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="col-form-label">Rating</label>
                            <select class="select2 form-control ce_rating" name="rating">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <label class="error_show status"></label>
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="col-form-label">Status</label>
                            <select class="select2 form-control ce_status" name="status">
                                <option value="pending">Pending</option>
                                <option value="accept">Accept</option>
                                <option value="blocked">Blocked</option>
                            </select>
                            <label class="error_show status"></label>
                        </div>

                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger c_modal" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>
<script src="<?php echo base_url();?>/public/admin/main_js/rating_listing.js"></script>
<style type="text/css">
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