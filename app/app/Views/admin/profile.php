<?php
$name = $phone = $password = $password_show = $p_logo = $address = $status = $show_password = $p_id = '';
$label = "Create";
$label_a = "Create admin";

$required = "required";
?>
<?php if (!empty($edit))
{
    $label_a = "Edit admin";
    $label = "Update";
    $p_id = en_de_crypt($edit['id']);
    $name = $edit['first_name'];
    $phone = $edit['phone'];
    $password = $edit['password'];
    $password_show = $edit['password_show'];
    $p_logo = $edit['logo'];
    $address = $edit['address'];
    // $status = $edit['status'];
    $show_password = '('.$edit['password_show'].')';
    $required = "";
} ?>
<input type="hidden" class="bases_url" value="<?php echo base_url(''); ?>">

<div class="vertical-overlay"></div>
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Profile</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('/admin'); ?>">Dashboards</a></li>
                            <li class="breadcrumb-item active">Edit Profile</li>
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
                                        <form class="admin_add_edit" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="col-form-label">Name</label>
                                                    <input class="form-control" type="text" placeholder="Enter admin name" id="name" name="first_name" value="<?php echo $name ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-form-label">Phone</label>
                                                    <input class="form-control" type="text" placeholder="Enter phone number" id="phone" name="phone" value="<?php echo $phone ?>" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-form-label">Password <?php echo $show_password ?></label>
                                                    <input class="form-control" type="password" placeholder="Password" id="password" name="password" value="" <?php echo $required; ?>>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="col-form-label">Address</label>
                                                    <input class="form-control" type="text" placeholder="address" name="address" value="<?php echo $address; ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label  class="col-form-label">Profile Image</label>
                                                    <input style="padding: 10px;" class="form-control" type="file"  id="profile_image" name="profile_image" accept="image/png, image/gif, image/jpeg">
                                                    <?php if (!empty($p_logo)): ?>
                                                    <div class="" style="">
                                                        <a class="jquery_imge_preview" target="_blank" href="<?php echo base_url('public/admin/images/logo/') ?><?php echo $p_logo ?>"><img src="<?php echo base_url('public/admin/images/logo/') ?><?php echo $p_logo ?>" class="upload_img_dr" ></a>
                                                        <div class="clear" ></div>
                                                    </div>
                                                    <?php endif ?>
                                                </div>
                                                <br>
                                            </div>
                                            <br>
                                            <button class="btn btn-primary" type="submit"><?php echo $label; ?></button>
                                        </form>
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

<script src='<?php echo base_url(); ?>public/admin/main_js/profile.js'></script>
<style type="text/css">
    .site-upload-img, .upload_img_dr
    {
        width: 119px;
        margin-top: 6px;
        border: 1px solid #cdcdcd;
        float: left;
        margin-right: 2px;
    }
</style>