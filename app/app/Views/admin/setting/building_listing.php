<div class="vertical-overlay"></div>
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Building</h4>
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
                                    <button id="add_building" onclick="document.getElementById('id01').style.display='block'" class="header_btn w3-button w3-black">Add Building</button>
                                </h4>
                            </div>
                            <div class="card-body">
                                

                                <table id="building_listing" data-order='[[ 0, "desc" ]]'  class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Name</th>
                                        <th>Wings</th>
                                        <th>Status</th>
                                        <th class="action_tab">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($data): ?>
                                    <?php foreach ($data as $key => $value): ?>
                                    
                                    <tr class="banner_<?php echo en_de_crypt($value['id']); ?>">
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $value['building_name']; ?></td>
                                        <td>
                                            <?php if (!empty($value['wings'])): ?>
                                                <?php foreach ($value['wings'] as $wkey => $wvalue): ?>

                                                    <div class="wing_listing w_l_<?php echo en_de_crypt($wvalue['id']); ?>">
                                                        <?php echo $wvalue['wing_name']; ?>
                                                            
                                                        <a class="edit_wing" data-id="<?php echo en_de_crypt($wvalue['id']); ?>" href="javascript:void(0);"><button class="btn btn-sm btn-success"><i class="fa fa-pencil "></i></button></a>

                                                        <a class="delete_wing" data-id="<?php echo en_de_crypt($wvalue['id']); ?>" href="javascript:void(0);"><button class="btn btn-sm btn-warning"><i class="fa fa-trash "></i></button></a>
                                                    </div>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            
                                        </td>
                                        <td><?php echo $value['status']; ?></td>
                                        <td class="action_tab">
                                            <a onclick="document.getElementById('id02').style.display='block'" class="add_wing" data-id="<?php echo en_de_crypt($value['id']); ?>" data-name="<?php echo $value['building_name']; ?>" href="javascript:void(0);"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add Wing</button></a>

                                            <a class="edit_building" data-id="<?php echo en_de_crypt($value['id']); ?>" href="javascript:void(0);"><button class="btn btn-sm btn-success"><i class="fa fa-pencil "></i></button></a>

                                            <a class="delete_building" data-id="<?php echo en_de_crypt($value['id']); ?>" href="javascript:void(0);"><button class="btn btn-sm btn-warning"><i class="fa fa-trash "></i></button></a>
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

<div id="id01" class="w3-modal" style="display: none;">
    <div class="w3-modal-content">
        <div class="w3-container">

            <span onclick="document.getElementById('id01').style.display='none'" class="close_building w3-button w3-display-topright">&times;</span>

            <form class="building_form" method="post">
                <div class="modal-body">
                    <label class="building_modal">Add Building</label>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">Building Name</label>
                            <input class="b_name form-control" type="text" placeholder="Building Name" name="building_name">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="city" class="col-form-label">Status</label>
                            <select class="b_status form-control" name="status">
                                <option value="active">Active</option>
                                <option value="deactive">Deactive</option>
                            </select>
                        </div>

                        <label class="error_show"></label>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="id02" class="w3-modal" style="display: none;">
    <div class="w3-modal-content">
        <div class="w3-container">

            <span onclick="document.getElementById('id02').style.display='none'" class="close_wings w3-button w3-display-topright">&times;</span>

            <form class="wing_form" method="post">
                <div class="modal-body">
                    <label class="wing_modal">Add Wings</label>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label">Wing Name</label>
                            <input class="w_name form-control" type="text" placeholder="Wing Name" name="wing_name">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="city" class="col-form-label">Status</label>
                            <select class="b_status form-control" name="status">
                                <option value="active">Active</option>
                                <option value="deactive">Deactive</option>
                            </select>
                        </div>

                        <input type="hidden" name="wing_id" class="append_wing_id">
                        <input type="hidden" name="building_id" class="append_building_id">
                        <label class="e_show"></label>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" onclick="document.getElementById('id02').style.display='none'" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>/public/admin/css/buttons.dataTables.min.css">

<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>
<script src="<?php echo base_url();?>/public/admin/main_js/setting.js"></script>