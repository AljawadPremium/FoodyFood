<article  class="container theme-container">
    <div class="row">
        <?php include("my_account_menu.php"); ?>
        <aside class="col-md-8 col-sm-8 space-bottom-20">
            <div class="account-details-wrap">
                <div class="title-2 sub-title-small">  My Account</div>
                <div class="account-box  light-bg default-box-shadow">
                    <ul>
                        <li><a href="<?php echo base_url("my_account/edit") ?>">Edit your account information</a></li>
                        <li><a href="<?php echo base_url("my_account/wallet") ?>">See your wallet amount</a></li>
                        <li><a href="<?php echo base_url("my_account/address") ?>">Modify Your Address Book Entries</a></li>
                        <li><a href="<?php echo base_url("my_account/notifications") ?>">View Notifications</a></li>
                    </ul>
                </div>
                <div class="title-2 sub-title-small"> order and review </div>
                <div class="account-box  light-bg default-box-shadow">
                    <ul>
                        <li><a href="<?php echo base_url("my_account/orders") ?>">View your order history</a></li>
                        <li><a href="<?php echo base_url("product/wishlist") ?>">View your wishlist</a></li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</article>
<style>
.activ_my_acnt a {
font-weight: 600;
color: #333 !important;
background: #e9e9e9;
border-color:#424242 !important;
}
.main.mt-lg-4{
background: #f5f5f5;
margin-top: 0px !important;
padding-top: 10px;
}
.page-wrapper{
background: #f5f5f5;
}
</style>