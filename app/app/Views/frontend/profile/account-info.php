<style type="text/css">
    #header-sticky .row.align-items-center{
    background: #f9f9f9 !important;
    height: 102px;
    }
</style>
<section class="prdct_list bd-page__banner-area include-bg page-overlay" data-background="<?php echo base_url('public/frontend/img/'); ?>/banner/page-banner-1.jpg" style="background-image: url(&quot;<?php echo base_url('public/frontend/img/'); ?>/banner/page-banner-1.jpg&quot;);">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="bd-page__banner-content text-center">
                    <h2>
                        My Account
                    </h2>
                    <div class="breadcrumb_area_centr breadcrumb-area pt-10 pb-10">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="breadcrumb__list">
                                        <span><a href="<?php echo base_url(''); ?>">Home</a></span>
                                        <span><i class="fa-regular fa-angle-right"></i></span>
                                        <span>Edit Profile</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<article  class="container theme-container">
    <div class="row">
        <?php include("my_account_menu.php"); ?>
        <aside class="col-md-8 col-sm-8 space-bottom-20">
            <div class="account-details-wrap">
                <!-- <div class="title-2 sub-title-small">Edit Profile</div> -->
                <div class="account-box  light-bg default-box-shadow">
                    <form method="post" class="form-delivery" enctype="multipart/form-data" id="edit_profile" action="">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input autocomplete="off" onkeypress="return onlyAlphabets(event,this);"  type="text" class="form-control" placeholder="First Name" name="first_name" value="<?php echo $edit['first_name'] ?>" required="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input autocomplete="off" onkeypress="return onlyAlphabets(event,this);"  type="text" class="form-control" placeholder="Last Name" name="last_name" value="<?php echo $edit['last_name'] ?>" required="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" placeholder="Email Address" name="email" value="<?php echo $edit['email'] ?>" required="">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input autocomplete="off" onkeypress="return isNumberKey(event)" type="text" class="form-control" placeholder="Mobile Number" name="phone" value="<?php echo $edit['phone'] ?>">
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" class="input_date form-control" placeholder="Date of Birth" name="date_of_birth" value="<?php echo $edit['date_of_birth'] ?>" >
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Profile Image</label>
                                    <input type="file" class="form-control" name="logo" >
                                    <?php if (!empty($edit['logo'])): ?>
                                        <div  class="col-sm-12 site-upload-img" style="margin-right: 0px;">
                                            <img src="<?php echo base_url('public/usersdata/') ?><?php echo $edit['logo'] ?>" class="img_multpl_imga" >
                                        </div>
                                    <?php endif ?>

                                </div>
                            </div>
                            
                            <div class="col-md-12 col-sm-12">
                                <label class="pink-btn btn_main_updt">
                                    <input type="submit" value="Update">
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
    .activ_acnt_inf a{
        font-weight: 600;
        color: #333 !important;
        background: #e9e9e9;
        border-color:#424242 !important;
    }
    .prof_li a{
        color: #88c73f!important;
    }
</style>