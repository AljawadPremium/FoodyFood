<?php
$cat_id_array = array();
$first_name = $status = $image = $t_id = $latitude = $longitude = $email = $phone =  $password_show = '';
$label = 'Add';
$required = "required";
if (!empty($edit))
{
    $t_id = en_de_crypt($edit['id']);
    $cat_id_array = explode (",", $edit['category_id']);

    $required = "";

    $first_name = $edit['first_name'];
    $email = $edit['email'];
    $phone = $edit['phone'];
    $password_show = $edit['password_show'];
    $latitude = $edit['latitude'];
    $longitude = $edit['longitude'];
    $status = $edit['active'];
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
                        <h4 class="mb-sm-0"><?php echo $label; ?> main Truck</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item active"><?php echo $label; ?> main Truck</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="add_main_cat" method="post">
                                <input type="hidden" class="shop_id" name="edit_id" value="<?php echo $t_id ?>">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Login Username email</label>
                                        <input class="form-control" name="email" placeholder="Enter email" type="text" value="<?php echo $email; ?>" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Phone</label>
                                        <input class="form-control" name="phone" placeholder="Enter phone" type="text" value="<?php echo $phone; ?>" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>
                                            Login Username password
                                            <?php if ($password_show): ?>
                                                (<?php echo $password_show; ?>)
                                            <?php endif ?>
                                        </label>
                                        <input class="form-control" name="password" placeholder="Enter password" type="password" <?php echo $required; ?>>
                                    </div>


                                    <div class="col-sm-3">
                                        <label>Shop Name</label>
                                        <input class="m_name form-control" rows="1" name="first_name" placeholder="Enter name" type="text" value="<?php echo $first_name; ?>" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Shop Latitude</label>
                                        <input class="form-control" rows="1" name="latitude" placeholder="Enter Latitude" type="text" value="<?php echo $latitude; ?>" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Shop Longitude</label>
                                        <input class="form-control" rows="1" name="longitude" placeholder="Enter Longitude" type="text" value="<?php echo $longitude; ?>" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Status</label>
                                        <select class="form-control" name="active">
                                            <option <?php if($status=== '1') echo 'selected="selected"';?> value="1">Active</option>
                                            <option <?php if($status=== '0') echo 'selected="selected"';?> value="0">Deactive</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Shop Category</label>
                                        <select class="form-control category_id" name="category_id[]" multiple>
                                            <?php if (!empty($category_listing)): ?>
                                                <?php foreach ($category_listing as $skey => $svalue): 
                                                    $c_name = (in_array($svalue['id'], $cat_id_array)? 'selected':'') ?>
                                                    <option value="<?php echo $svalue['id']; ?>" <?php echo $c_name; ?> ><?php echo $svalue['display_name']; ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <br>
                                        <label>Shop Image</label>
                                        <input type="file" class="cat_img form-control" name="image" accept="image/*">

                                        <div class="showImage" style="background-image: url('<?php echo base_url('/public/admin/shop/') ?><?php echo $image; ?>');">
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

    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet"> <!-- for live demo page -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('.category_id').each(function () {
                $(this).select2({
                    theme: 'bootstrap4',
                    width: 'style',
                    placeholder: $(this).attr('placeholder'),
                    allowClear: Boolean($(this).data('allow-clear')),
                });
            });
        });
    </script>
    <script src='<?php echo base_url(); ?>/public/admin/main_js/shop.js'></script>
    <style type="text/css">
        .select2-container .select2-selection--multiple .select2-selection__choice {
            color: white!important;
        }
    </style>