<?php
$label = 'Add';
$title = $editor = $status = $t_id = $url = '';
if (!empty($edit))
{
    $t_id = en_de_crypt($edit['id']);
    $title = $edit['title'];
    $editor = $edit['editor'];
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
                        <h4 class="mb-sm-0">Pages Detail</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/pages') ?>">Page Listing</a></li>
                                <li class="breadcrumb-item active">Add</li>
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
                                            <form class="add_pages" method="post">
                                                <input type="hidden" class="pages_id" name="pages_id" value="<?php echo $t_id; ?>">
                                                <div class="row">
                                                    
                                                    <div class="col-sm-4">
                                                        <label>Title</label>
                                                        <input type="text" class="form-control" placeholder="Enter title first" name="title" value="<?php echo $title ?>" >
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <label>Description</label>
                                                        <textarea name="editor" id="editor" rows="10" cols="80"><?php echo $editor ?></textarea>
                                                    </div>

                                                    <div class="col-sm-4" style="display: none;">
                                                        <label>Status</label>
                                                        <select class="form-control" name="status">
                                                            <option <?php if($status=== 'active') echo 'selected="selected"';?> value="active">Active</option>
                                                            <option <?php if($status=== 'deactive') echo 'selected="selected"';?> value="deactive">Deactive</option>
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

<script src='<?php echo base_url(); ?>/public/admin/main_js/pages.js'></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.editorConfig = function (config) {
        config.extraPlugins = 'confighelper';
    };
    CKEDITOR.replace('editor');
</script>