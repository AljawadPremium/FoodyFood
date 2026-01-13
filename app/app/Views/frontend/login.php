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
                    <h2>Login</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<main>
    <section class="cart-area pt-10 pb-10">
        <div class="container small-container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="table-content table-responsive">
                        <div class="coupon-info">

                                <form class="user_login_form login-page__form">
                                    <p class="form-row-first">
                                        <label>Username or email <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="singin-email" name="login_username" placeholder="Username or Email Address *" value="<?php echo $remember_arr['remember_user_name']; ?>" required>
                                        <span class="icon-email"></span>
                                    </p>

                                    <p class="form-row-first">
                                        <label>Password <span class="required">*</span></label>
                                        <input type="password" class="form-control login-page__password" id="singin-password" name="login_password" placeholder="Password *" value="<?php echo $remember_arr['remember_user_password']; ?>" required>
                                        <span class="icon-padlock"></span>
                                        <i class="toggle-password pass-field-icon fa fa-fw fa-eye-slash"></i>
                                    </p>

                                    <p class="form-row d-flex align-items-center flex-wrap">
                                        <input type="checkbox" class="e-check-input" id="remember-policy" name="remember_me" <?php echo $remember_c; ?>>
                                        <label for="remember-policy"><span></span>Remember me</label>
                                    </p>
                                    <br>
                                    <div class="login-page__form__input-box login-page__form__input-box--button">
                                        <button type="submit" class="bd-fill__btn w-100">log in</button>
                                    </div>
                                </form>
                                <br>
                                <div class="bd-registered__wrapper">
                                    <div class="not-register">
                                        <span>Not registered?</span><span><a href="<?php echo base_url('register'); ?>"> Sign up</a></span>
                                    </div>
                                    <div class="forget-password">
                                        <a href="#">Forgot password?</a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style type="text/css">
    .pass-field-icon {
    cursor: pointer;
    position: absolute;
    right: 23%;
    margin-top: -45px;
    transform: translateY(-50%);
    z-index: 1;
    color: var(--boskery-text, #7A7373);
    transition: all 400ms ease;
}
</style>