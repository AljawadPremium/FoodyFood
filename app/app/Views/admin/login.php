<!DOCTYPE html>
<html lang="" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" class="loading no-js ">
<head>
    <meta charset="utf-8">  
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Ddescription Ddescription">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_name; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>/public/admin/logo.png">
    
    </head>

<body id="bg" class="home">
<link rel="shortcut icon" href="<?php echo base_url();?>/public/admin/images/logo-sm.png">
<link href="<?php echo base_url();?>/public/admin/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>/public/admin/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>/public/admin/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>/public/admin/js/layout.js"></script>
<link href="<?php echo base_url();?>/public/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>/public/admin/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>/public/admin/css/app.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>/public/admin/css/custom.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/public/admin_custome.css">
<style type="text/css">
    html.loading {
    background:  url('<?php echo base_url();?>/public/loader.gif') no-repeat center fixed;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 99999;
    width: 100%;
    height: 100%;
    overflow: visible;
    background-size: 150px;
    background-color: #ffffff;
    }
    html.loading body {
    opacity: 0;
    -webkit-transition: opacity 0;
    transition: opacity 0;
    }
</style>
<div id="loading" style="display: none">
    <img id="loading-image" src="<?php echo base_url('/public/loader.gif') ?>" alt="Loading..." />
</div>
<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <div class="auth-page-content overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden" style="margin-top: 20px;" >
                        <div class="row g-0">
                             
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4 auth-one-bg h-100">
                                    <div class="bg-overlay"></div>
                                    <div class="position-relative h-100 d-flex flex-column">
                                        <div class="mb-4">
                                            <a href="javascript:void(0);" class="d-block" style="display:inline-block; width: 100%; text-align: center;  " >
                                                <img style="width: 100%;border-radius: 5px;" src="<?php echo base_url();?>/public/admin/images/logo.png" >
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 login_div">
                                <div class="p-lg-5 p-4">
                                    <div>
                                        <h5 class="text-primary">Welcome Back Admin !</h5>
                                        <p class="text-muted">Sign in to continue.</p>
                                    </div>
                                    <div class="mt-4">
                                        <form id="admin_login_form" method="POST" >
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input name="lemail" type="text" class="form-control" id="username" placeholder="Enter username" value="<?php echo $remember_arr['remember_admin_user_name']; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input name="lpassword" type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input" value="<?php echo $remember_arr['remember_admin_password']; ?>">
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="remember_me" type="checkbox" id="auth-remember-check" <?php echo $remember_c; ?>>
                                                <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                            </div>
                                            <div class="mt-4">
                                                <span class="error_show"></span>
                                                <button class="btn btn-success w-100 login-button" type="submit">Sign In</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class="mt-5 text-center">
                                        <p class="mb-0">Don't have an account ? <a href="<?php echo base_url('radiology/signup') ?>" class="fw-semibold text-primary text-decoration-underline"> Signup</a> </p>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer start-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0">©
                            <script>document.write(new Date().getFullYear())</script> BomBkra. Crafted with <i class="mdi mdi-heart text-danger"></i> by Persausive
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<script src="<?php echo base_url();?>/public/admin/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>/public/admin/main_js/admin_login.js"></script>
<script src="<?php echo base_url();?>/public/toastr.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/public/toastr.css">
<script type="text/javascript">
    document.getElementsByTagName( "html" )[0].classList.remove( "loading" );
    document.getElementsByTagName( "html" )[0].className.replace( /loading/, "" );
</script>

</body>
</html>
