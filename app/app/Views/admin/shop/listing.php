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
                        <h4 class="mb-sm-0">Truck Listing</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboards</a></li>
                                <li class="breadcrumb-item active">Truck</li>
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
                                <!-- <div class="card-header">
                                    <h4 class="card-title mb-0"></h4>
                                </div> -->
                                <div class="card-body">
                                    <table id="l_listing" data-order='[[ 0, "desc" ]]'  class="table table-bordered dt-responsive table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th style="width:30%">Driver</th>
                                                <!-- <th>Image</th> -->
                                                <th>Status</th>
                                                <th class="action_tab">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($shop): ?>
                                            <?php foreach ($shop as $key => $value): ?>
                                            <tr class="main_shop_<?php echo $value['cid']; ?>">
                                                <td><?php echo $value['id']; ?></td>
                                                <td style="width:15%"><?php echo $value['first_name']; ?></td>
                                                <td><?php echo $value['email']; ?></td>
                                                <td><?php echo $value['phone']; ?></td>
                                                <td class="sub_cat_lis">
                                                    <?php if ($value['driver_list']): ?>
                                                    <?php foreach ($value['driver_list'] as $skey => $svalue): ?>
                                                    <p class="sub_category_<?php echo en_de_crypt($svalue['id']); ?>"><?php echo $skey + 1 ; ?>)
                                                        <span class="a_show"><?php echo $svalue['first_name']; ?>
                                                        <?php if ($svalue['active'] == '0'): ?>
                                                        (Deactive)
                                                        <?php endif ?>
                                                        </span>
                                                        <a class="" href="<?php echo base_url('admin/driver/edit/') ?><?php echo en_de_crypt($svalue['id']); ?>" target="_blank"><i class="action_tab fa fa-edit"></i></a>
                                                        <!-- <a href="javascript:void(0);" data-id="<?php echo en_de_crypt($svalue['id']); ?>" class="delete_sub_category"><i class="action_tab fa fa-trash"></i></a> -->
                                                    </p>
                                                    <?php endforeach ?>
                                                    <?php endif ?>
                                                </td>
                                                <!-- <td style="width: 10%">
                                                    <a target="_blank" href="<?php echo $value['image']; ?>">
                                                    <img style="width: 50px" src="<?php echo $value['image']; ?>" alt=""></a>
                                                </td>  -->
                                                <td><?php echo $value['active']; ?></td>
                                                <td><?php echo $value['action_url']; ?></td>
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
</div>
<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>
<script src="<?php echo base_url();?>/public/admin/main_js/shop_listing.js"></script>