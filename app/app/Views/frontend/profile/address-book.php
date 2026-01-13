<?php include(ROOTPATH."/app/Views/frontend/header_1.php"); ?>
<article  class="<?php echo $container_class; ?> theme-container">
    <div class="row">
        <?php include("my_account_menu.php"); ?>
        <aside class="col-md-8 col-sm-8 space-bottom-20">
            
            <div class="account-details-wrap">
                <div class="title-2 sub-title-small">  Change Your Personal Details </div>
                <div class=" account-box  light-bg default-box-shadow">
                    <?php if (!empty($all_data)): ?>
                        <div class="row">
                            <?php foreach ($all_data as $skey => $svalue): ?>
                                <div class="col-sm-4 list_address address_<?php echo $svalue['id'] ?>">
                                    <div class="user_name_adres">
                                        <a href="javascript:void(0)" data-id="<?php echo $svalue['id'] ?>" class="edit_address" ><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" data-id="<?php echo $svalue['id'] ?>" class="delete_address edit_icnas edit_dlt" ><i class="fas fa-trash"></i></a>
                                        <div><?php echo $svalue['first_name']; ?> <?php echo $svalue['last_name']; ?></div>
                                        <div><?php echo $svalue['phone']; ?></div>
                                        <div><?php echo $svalue['address']; ?>,<?php echo $svalue['landmark']; ?></div>
                                        <div><?php echo $svalue['city']; ?> </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                    <form action="#" class="form-delivery" id="address_create" method="post">
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First name</label>
                                    <input name="first_name" class="f_name form-control" type="text" placeholder="First name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Last name</label>
                                    <input class="l_name form-control" name="last_name" type="text" placeholder="Last name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input name="email" class="a_email form-control" type="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control a_phone" name="phone" type="number" placeholder="Phone" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10" minlength="10">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input class="form-control a_address" name="address" type="text" placeholder="Address">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Landmark</label>
                                    <input class="form-control a_landmark" name="landmark" type="text" placeholder="Landmark">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>City</label>
                                    <input class="form-control a_city" name="city" type="text" placeholder="City">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>State</label>
                                    <input class="a_state form-control" name="state" type="text" placeholder="State">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Postcode</label>
                                    <input class="a_postcode form-control" name="postcode" type="number" placeholder="Postcode">
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-sm-12">
                                <label class="pink-btn btn_main_updt">
                                    <input class="button_value" type="submit" value="Add address">
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </aside>
    </div>
</article>
<style>
    .activ_adres_bok a{
        font-weight: 600;
        color: #333 !important;
        background: #e9e9e9;
        border-color:#424242 !important;
    }
/*Address tab my account*/
.list_address
{
    padding: 5px;
}
.list_address a
{
    float: right;
}
.user_name_adres {
    padding: 10px;
    border: 1px solid #cdcdcdcd;
}
</style>
<script type="text/javascript">
    $(".dropdown.category-dropdown.has-border").removeClass("menu-fixed");
</script>
<?php include(ROOTPATH."/app/Views/frontend/footer_1.php"); ?>