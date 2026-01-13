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
                    <h4 class="mb-sm-0">Category Listing</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboards</a></li>
                            <li class="breadcrumb-item active">Category</li>
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
                                        <th>Category Name</th>
                                        <th>Image</th>
                                        <!-- <th>Sub Category</th> -->
                                        <th>Status</th>
                                        <th class="action_tab">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($category): ?>
                                    <?php foreach ($category as $key => $value): ?>
                                    
                                    <tr class="main_category_<?php echo $value['cid']; ?>">
                                        <td><?php echo $key+1; ?></td>
                                        <td style="width: 30%"><?php echo $value['display_name']; ?></td>
                                        <td style="width: 10%"><img style="width: 50px" src="<?php echo $value['image']; ?>" alt=""></td>
                                        <!-- td class="sub_cat_lis">
                                            <?php if ($value['subcategory']): ?>
                                            <?php foreach ($value['subcategory'] as $skey => $svalue): ?>
                                                <p class="sub_category_<?php echo en_de_crypt($svalue['id']); ?>"><?php echo $skey + 1 ; ?>)
                                                    <?php echo $svalue['display_name']; ?> 

                                                    <?php if ($svalue['status'] == 'deactive'): ?>
                                                        (Deactive)
                                                    <?php endif ?>
                                               
                                                    <a href="<?php echo base_url('admin/subcategory/edit/') ?><?php echo en_de_crypt($svalue['id']); ?>" target="_blank"><i class="action_tab fa fa-edit"></i></a>

                                                    <a href="javascript:void(0);" data-id="<?php echo en_de_crypt($svalue['id']); ?>" class="delete_sub_category"><i class="action_tab fa fa-trash"></i></a>
                                                </p>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                        </td> -->
                                       
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
<script src="<?php echo base_url();?>/public/admin/main_js/category_listing.js"></script>