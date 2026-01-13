<?php
$label = 'Add';
$item_name = $status = $t_id = $a_id = '';
if (!empty($edit))
{
    $t_id = en_de_crypt($edit['id']);
    $a_id = $edit['a_id'];
    $item_name = $edit['item_name'];
    $status = $edit['status'];

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
                        <h4 class="mb-sm-0">Attribute item</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/attribute') ?>">Item Listing</a></li>
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
                                            <form class="add_attribute" method="post">
                                                <input type="hidden" class="attribute_item_id" name="attribute_item_id" value="<?php echo $t_id; ?>">
                                                <div class="row">

                                                    <div class="col-sm-4">
                                                        <label for="category">Name</label>
                                                        <input type="text" name="item_name" class="form-control" value="<?php echo $item_name; ?>" placeholder="Item Name">
                                                    </div>


                                                    <div class="col-sm-4">
                                                        <label>Size</label>
                                                        <select class="form-control" name="a_id">
                                                            <!-- <option <?php if($a_id=== '19') echo 'selected="selected"';?> value="19">Color</option> -->
                                                            <option <?php if($a_id=== '20') echo 'selected="selected"';?> value="20">Size</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label>Status</label>
                                                        <select class="form-control" name="status">
                                                            <option <?php if($status=== '1') echo 'selected="selected"';?> value="1">Active</option>
                                                            <option <?php if($status=== '0') echo 'selected="selected"';?> value="0">Deactive</option>
                                                        </select>
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
    <script src='<?php echo base_url(); ?>/public/admin/main_js/attribute.js'></script>