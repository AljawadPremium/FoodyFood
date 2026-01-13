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
                    <h4 class="mb-sm-0">Banner</h4>
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
                            <!-- <div class="card-header">
                                <h4 class="card-title mb-0"></h4>
                            </div> -->
                            <div class="card-body">
                                <table id="l_listing" data-order='[[ 0, "desc" ]]'  class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th class="action_tab">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($banner): ?>
                                    <?php foreach ($banner as $key => $value): ?>
                                        <tr class="banner_<?php echo en_de_crypt($value['id']); ?>">
                                            <td><?php echo $key+1; ?></td>
                                            <td style="width: 20%;">
                                                <img src="<?php echo base_url('public/admin/banner/') ?><?php echo $value['image']; ?>" class="banner_img_listing">
                                            </td>
                                            <td><?php echo $value['display_name']; ?></td>
                                            <td><?php echo $value['type']; ?></td>
                                            <td><?php echo $value['status']; ?></td>
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
<script src="<?php echo base_url();?>/public/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/js/datatables.init.js"></script>
<script src="<?php echo base_url();?>/public/admin/main_js/banner_listing.js"></script>