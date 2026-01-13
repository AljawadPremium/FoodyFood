<?php
$display_name = $display_name_ar = $status = $image = $t_id = '';
$label = 'Add';
if (!empty($edit))
{
    $t_id = en_de_crypt($edit['id']);
    $display_name = $edit['display_name'];
    $display_name_ar = $edit['display_name_ar'];
    $status = $edit['status'];
    $image = $edit['image'];
    $label = 'Update';
}
?>
<div class="vertical-overlay"></div>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><?php echo $label; ?> main category</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item active"><?php echo $label; ?> main category</li>
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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form class="edit_main_cat" method="post">
                                                <input type="hidden" class="category_id" name="edit_id" value="<?php echo $t_id ?>">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label>Category Name</label>
                                                        <input class="m_name form-control" rows="1" name="display_name" placeholder="Enter name" type="text" value="<?php echo $display_name; ?>">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Category Name (Ar)</label>
                                                        <input class="m_name form-control" rows="1" name="display_name_ar" placeholder="Enter name" type="text" value="<?php echo $display_name_ar; ?>">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Status</label>
                                                        <select class="form-control" name="status">
                                                            <option <?php if($status=== 'active') echo 'selected="selected"';?> value="active">Active</option>
                                                            <option <?php if($status=== 'deactive') echo 'selected="selected"';?> value="deactive">Deactive</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Image</label>
                                                        <input type="file" class="cat_img form-control" name="image" accept="image/*">
                                                        
                                                        <div class="showImage" style="background-image: url('<?php echo base_url('/public/admin/category/') ?><?php echo $image; ?>');">
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="col-sm-6">
                                                        <button class="btn btn-primary" type="submit"><?php echo $label; ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                            <br>
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

<script src='<?php echo base_url(); ?>/public/admin/main_js/category.js'></script>