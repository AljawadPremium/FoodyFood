<?php
$label = 'Add';
$category = $language = $type = $status = $image = $t_id = $url = '';
if (!empty($edit))
{
    $t_id = en_de_crypt($edit['id']);

    $language = $edit['language'];
    $category = $edit['category'];
    $type = $edit['type'];
    $status = $edit['status'];

    $image = $edit['image'];
    $url = base_url('public/admin/banner/').$image;
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
                        <h4 class="mb-sm-0">Banner</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/banner') ?>">Banner Listing</a></li>
                                <li class="breadcrumb-item active"><?php echo $label; ?></li>
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
                                            <form class="add_banner" method="post">
                                                <input type="hidden" class="banner_id" name="banner_id" value="<?php echo $t_id; ?>">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label>Category</label>
                                                        <select class="form-control" name="category">
                                                            <?php if (!empty($c_listing)): ?>
                                                            <?php foreach ($c_listing as $key => $value): ?>
                                                                <option <?php if($category === $value['id']) echo 'selected="selected"';?> value="<?php echo $value['id']; ?>"><?php echo $value['display_name']; ?>
                                                                </option>
                                                            <?php endforeach ?>
                                                            <?php endif ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>Type</label>
                                                        <select class="form-control" name="type">
                                                            <option <?php if($type=== 'application') echo 'selected="selected"';?> value="application">Application</option>
                                                            <!-- <option <?php if($type=== 'website') echo 'selected="selected"';?> value="website">Website</option> -->
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3" style="display: none;">
                                                        <label>Language</label>
                                                        <select class="form-control" name="language">
                                                            <option <?php if($language=== 'en') echo 'selected="selected"';?> value="en">English</option>
                                                            <option <?php if($language=== 'ar') echo 'selected="selected"';?> value="ar">Arabic</option>
                                                            <option <?php if($language=== 'ku') echo 'selected="selected"';?> value="ku">Kurdish sorani</option>
                                                        </select>
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
                                                        <input type="file" class="ban_img form-control" name="image" accept="image/*">
                                                        <div class="showImage" style="background-image: url(<?php echo $url; ?>) "></div>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="col-sm-6">
                                                        <p class="error_show"></p>
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
    <script src='<?php echo base_url(); ?>/public/admin/main_js/banner.js'></script>