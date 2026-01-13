<?php
$label = 'Add';
$f_name = $t_id = '';
if (!empty($edit))
{
    $t_id = en_de_crypt($edit['id']);
    $f_name = $edit['first_name'];
    $label = 'Update';
}
$first_name = $email = $phone = $password = $password_show = $address = $status = $image = $driver_id = '';
if (!empty($driver_data)) {
    $driver_id = en_de_crypt($driver_data['id']);
    $first_name = $driver_data['first_name'];
    $email = $driver_data['email'];
    $phone = $driver_data['phone'];
    $address = $driver_data['address'];
    $password_show = $driver_data['password_show'];
    $status = $driver_data['active'];
    $image = $driver_data['logo'];
}
?>
<div class="vertical-overlay"></div>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><?php echo $label; ?></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item active">Add Driver</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="add_subcategory" id="addDriverForm" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="seller_id" value="<?php echo $t_id; ?>">
                                        <input type="hidden" class="driver_id" name="driver_id" value="<?php echo $driver_id; ?>">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label>Driver Name</label>
                                                <input class="m_name form-control" name="first_name" placeholder="Enter name" type="text" value="<?php echo $first_name; ?>" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Driver email</label>
                                                <input class="m_name form-control" name="email" placeholder="Enter email" type="email" value="<?php echo $email; ?>" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Driver Number</label>
                                                <input class="form-control" name="phone" placeholder="Enter phone" type="number" value="<?php echo $phone; ?>" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Driver Address</label>
                                                <input class="form-control" name="address" placeholder="Enter address" value="<?php echo $address; ?>" type="text">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Driver Password (<?php echo $password_show; ?>)</label>
                                                <input class="form-control" name="password" placeholder="Enter password" type="password">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Status</label>
                                                <select class="form-control" name="active">
                                                    <option <?php if($status=== '1') echo 'selected="selected"';?> value="1">Active</option>
                                                    <option <?php if($status=== '0') echo 'selected="selected"';?> value="0">Deactive</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Image</label>
                                                <input type="file" class="cat_img form-control" name="image" accept="image/*">
                                                <div class="showImage" style="background-image: url('<?php echo base_url('/public/driver/') ?><?php echo $image; ?>');"></div>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="col-sm-6">
                                                <p class="error_show"></p>
                                                <button class="btn btn-primary" type="submit"><?php echo $label; ?></button>
                                            </div>
                                        </div>
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
<script>
$(document).ready(function () {
    $("#addDriverForm").on("submit", function (event) {
        event.preventDefault(); // Prevent the form from submitting normally
        var driver_id = $(".driver_id").val();
        $(".error_show").text("");
        // Create a FormData object to handle file upload
        var formData = new FormData(this);
        $.ajax({
            url: '<?= base_url("admin/driver/add") ?>', // Replace with the correct URL for your addDriver method
            type: "POST",
            data: formData,
            contentType: false, // Required for file upload
            processData: false, // Required for file upload
            success: function (response) {
                $("#loading").hide();
                var response = $.parseJSON(response);
                if (response.status == true) {
                    if (driver_id == "") {
                        $(".showImage").css("display", "none");
                        $(".showImage").css("background-image", "url()");
                        $("#addDriverForm")[0].reset();
                    }
                    toastr.success(response.message, "Success");
                } else {
                    toastr.warning(response.message, "Warning");
                }
            },
            error: function (xhr, status, error) {
                $(".error_show").text("Error: " + error); // Display error if AJAX fails
            },
        });
    });
});

$(function () {
    $(".cat_img").on("change", function () {
        $(".showImage").html("");

        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test(files[0].type)) {
            // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function () {
                // set image data as background of div
                $(".showImage").css("background-image", "url(" + this.result + ")");
                $(".showImage").css("display", "block");
                // $(".showImage").css("position", "absolute");
            };
        }
    });
});

</script>