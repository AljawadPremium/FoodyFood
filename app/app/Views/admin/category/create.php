<?php
$label = 'Add';
if (!empty($edit))
{
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
                        <h4 class="mb-sm-0"><?php echo $label; ?> Category</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item active"><?php echo $label; ?> Category</li>
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
                                            <form class="add_main_cat" method="post">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label>Category Name</label>
                                                        <input class="m_name form-control" rows="1" name="display_name" placeholder="Enter name" type="text">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Category Name(Ar)</label>
                                                        <input class="form-control" rows="1" name="display_name_ar" placeholder="Enter name in Arabic" type="text">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Status</label>
                                                        <select class="form-control" name="status">
                                                            <option value="active">Active</option>
                                                            <option value="deactive">Deactive</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Image</label>
                                                        <input type="file" class="cat_img form-control" name="image" accept="image/*">
                                                        <div class="showImage"></div>
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