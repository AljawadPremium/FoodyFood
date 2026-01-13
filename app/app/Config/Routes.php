<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$front_path="FrontEnd\ ";
$front_path = trim($front_path);
$admin_path="AdminControllers\ ";
$admin_path = trim($admin_path);
$api_path="Api\ ";
$api_path = trim($api_path);
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->post('change-language', $front_path.'Home::changeLang');


// frontend controller toutes start here
$routes->get('/', $front_path.'Home::index');
$routes->match(['get', 'post'],'reset-password/(:any)/(:any)', $front_path.'Login::resetPassword/$1/$2');
// $routes->match(['get', 'post'],'login', $front_path.'Login::index');
// $routes->match(['get', 'post'],'register', $front_path.'Register::index');

$routes->get('login/success', $front_path.'Login::success');
$routes->get('logout', $front_path.'Login::logout');
$routes->get('forget-password', $front_path.'Login::forgetPassword');
$routes->post('forget-password', $front_path.'Login::forgetPassword');
$routes->post('login/u_logout', $front_path.'Login::u_logout');

$routes->get('/notification', $front_path.'Cron::index');
$routes->get('/get_customer_id_from_razorpay', $front_path.'Cron::get_customer_id_from_razorpay');
$routes->match(['get', 'post'],'razorpay/webhook', $front_path.'Cron::webhook');


$routes->match(['get', 'post'],'run_twice_day', $front_path.'Cron::run_twice_day');
$routes->match(['get', 'post'],'webhook', $front_path.'Cron::check_webhook');

$routes->post('/save_location', $front_path.'Home::save_location');
/*Pages*/
$routes->get('faq', $front_path.'Contact::faq');
$routes->get('terms', $front_path.'Contact::terms');
$routes->get('privacy', $front_path.'Contact::privacy');
$routes->get('about', $front_path.'Contact::about_us');
$routes->get('contact', $front_path.'Contact::index');

/*Category listing product*/
$routes->get('products/(:any)', $front_path.'Product::catList/$1');
$routes->match(['get', 'post'],'products', $front_path.'Product::catList');


/*My account*/
// $routes->get('profile', $front_path.'My_account::edit');
// $routes->get('my_account/edit', $front_path.'My_account::edit');
// $routes->get('my_account/wallet', $front_path.'My_account::wallet');
// $routes->get('orders', $front_path.'My_account::orders');
// $routes->get('my_account/orders', $front_path.'My_account::orders');
// $routes->get('my_account/order_detail/(:any)', $front_path.'My_account::order_detail/$1');


// $routes->post('my_account/edit', $front_path.'My_account::edit');

// $routes->get('my_account/address', $front_path.'My_account::address');
// $routes->post('my_account/address', $front_path.'My_account::address');
// $routes->post('my_account/delete_address', $front_path.'My_account::delete_address');
// $routes->post('my_account/get_address_data/(:any)', $front_path.'My_account::get_address_data/$1');
// $routes->post('my_account/order_cancel', $front_path.'My_account::order_cancel');
$routes->post('my_account/newsletter', $front_path.'My_account::newsletter');

$routes->match(['get', 'post'],'product/review/(:any)', $front_path.'Product::add_review/$1');


//Cart
$routes->post('add-to-cart', $front_path.'Cart::addToCart');
$routes->post('view-cart-count', $front_path.'Cart::viewCartCount');
$routes->post('add-to-wish-list', $front_path.'Cart::addtoWishList');
$routes->post('cat_pro_count', $front_path.'Cart::catProCount');
$routes->post('update-cart', $front_path.'Cart::updateCart');
$routes->post('remove-from-cart', $front_path.'Cart::removeFromCart');
$routes->get('cart', $front_path.'Cart::index');
$routes->get('checkout', $front_path.'Cart::checkout');
$routes->post('checkout/get_shipping_cost', $front_path.'Cart::get_shipping_cost');

$routes->get('cart/clear-all-items', $front_path.'Cart::clearAllItems');
$routes->get('cart/thank_you/(:any)', $front_path.'Cart::thank_you/$1');
$routes->get('thank_you/(:any)', $front_path.'Cart::thank_you/$1');
$routes->post('place-order', $front_path.'Cart::placeOrder');
$routes->get('payment-success/(:any)/(:any)', $front_path.'Cart::paymentSuccess/$1/$2');
$routes->get('payment-cancle/(:any)/(:any)', $front_path.'Cart::paymentCancle/$1/$2');
// $routes->get('payment-notify/(:any)/(:any)', $front_path.'Cart::paymentNotify/$1/$2');
$routes->match(['get', 'post'],'payment-notify/(:any)/(:any)', $front_path.'Cart::paymentNotify/$1/$2');

/*product detail*/
$routes->get('product/(:num)', $front_path.'Product::index/$1');

/*Search*/
$routes->post('ajax/search_assets', $front_path.'Ajax::search_assets');
$routes->post('ajax/get_checkout_amt', $front_path.'Ajax::get_checkout_amt');

$routes->post('product/get_added_count', $front_path.'Cart::get_metadata_count');


$routes->get('/ajax/quickview/(:any)', $front_path.'Ajax::quickview/$1');

// $routes->get('/genrate_stripe_url', $front_path.'Stripe::genrate_stripe_url');
// $routes->get('/stripe/success/(:any)/(:any)', $front_path.'Stripe::payment_success/$1/$2');
// $routes->get('/stripe/cancel/(:any)/(:any)', $front_path.'Stripe::payment_cancel/$1/$2');
// $routes->get('/payment/cancel/(:any)/(:any)', $front_path.'Cart::paymentCancle/$1/$2');

// frontend controller toutes end here


// admin controller routs start here
$routes->get('admin', $admin_path.'Admin::index');
$routes->get('admin/profile', $admin_path.'Admin::profile');
$routes->post('admin/profile_update', $admin_path.'Admin::updatess');

$routes->get('admin/login', $admin_path.'AdminLogin::index');
$routes->post('admin/login', $admin_path.'AdminLogin::index');
$routes->post('admin/logout', $admin_path.'AdminLogin::logout');

$routes->get('admin/category', $admin_path.'Category::index');
$routes->get('admin/category/edit/(:any)', $admin_path.'Category::edit/$1');
$routes->post('admin/category/edit/(:any)', $admin_path.'Category::edit/$1');

$routes->get('admin/add_sub/(:any)', $admin_path.'Category::add_sub/$1');

$routes->get('admin/category/add', $admin_path.'Category::add');
$routes->post('admin/add_category', $admin_path.'Category::add');
$routes->post('category/delete_sub_category', $admin_path.'Category::delete_sub_category');
$routes->post('category/delete_main_category', $admin_path.'Category::delete_main_category');

$routes->post('admin/add_subcategory', $admin_path.'Category::add_sub');
$routes->post('admin/edit_subcategory/(:any)', $admin_path.'Category::edit_subcategory/$1');
$routes->get('admin/subcategory/edit/(:any)', $admin_path.'Category::edit_subcategory/$1');

// $routes->get('admin/job/(:any)', $admin_path.'Job::index/$1');
// $routes->post('admin/job/(:any)', $admin_path.'Job::index/$1');

$routes->get('admin/shop/add', $admin_path.'Shop::add');
$routes->get('admin/shop', $admin_path.'Shop::index');
$routes->get('admin/shop/edit/(:any)', $admin_path.'Shop::edit/$1');
$routes->post('shop/delete_main_shop', $admin_path.'Shop::delete_main_shop');
$routes->post('admin/add_shop', $admin_path.'Shop::add');


$routes->get('admin/shop/add_driver/(:any)', $admin_path.'Shop::add_driver/$1');
$routes->post('admin/driver/add', $admin_path.'Shop::addDriver');
$routes->get('admin/driver/edit/(:any)', $admin_path.'Shop::editDriver/$1');





$routes->post('admin/get_category_shop_wise', $admin_path.'Product::get_category_shop_wise');



// $routes->match(['get', 'post'],'admin/customer', $admin_path.'Customer::index');
// $routes->post('admin/customer/delete_customer', $admin_path.'Customer::delete_customer');
// $routes->post('admin/customer/user_single_notification', $admin_path.'Customer::user_single_notification');
// $routes->post('admin/customer/delete_multiple_customer', $admin_path.'Customer::delete_multiple_customer');
// $routes->match(['get', 'post'],'admin/customer/view/(:any)', $admin_path.'Customer::view/$1');

$routes->get('admin/pages', $admin_path.'Pages::index');
$routes->get('admin/pages/add', $admin_path.'Pages::add');
$routes->post('admin/add_pages', $admin_path.'Pages::add');
$routes->get('admin/pages/edit/(:any)', $admin_path.'Pages::edit/$1');
$routes->post('admin/pages/edit/(:any)', $admin_path.'Pages::edit/$1');
$routes->post('pages/delete_pages/', $admin_path.'Pages::delete_pages');


$routes->get('admin/banner', $admin_path.'Banner::index');
$routes->get('admin/banner/add', $admin_path.'Banner::add');
$routes->post('admin/add_banner', $admin_path.'Banner::add');
$routes->get('admin/banner/edit/(:any)', $admin_path.'Banner::edit/$1');
$routes->post('admin/banner/edit/(:any)', $admin_path.'Banner::edit/$1');
$routes->post('banner/delete_banner/', $admin_path.'Banner::delete_banner');


$routes->match(['get', 'post'],'admin/product', $admin_path.'Product::index');
$routes->match(['get', 'post'],'admin/product/add', $admin_path.'Product::add');


$routes->get('admin/product/edit/(:any)', $admin_path.'Product::edit/$1');
$routes->post('admin/product/edit/(:any)', $admin_path.'Product::edit/$1');
$routes->post('product/delete_product/', $admin_path.'Product::delete_product');
$routes->post('product/uploadFiless/', $admin_path.'Product::uploadFiless');


$routes->get('admin/attribute', $admin_path.'Attribute::index');
$routes->get('admin/attribute/add', $admin_path.'Attribute::add');
$routes->post('admin/add_attribute', $admin_path.'Attribute::add');
$routes->get('admin/attribute/edit/(:any)', $admin_path.'Attribute::edit/$1');
$routes->post('admin/attribute/edit/(:any)', $admin_path.'Attribute::edit/$1');
$routes->post('attribute/delete_attribute/', $admin_path.'Attribute::delete_attribute');


$routes->match(['get', 'post'],'admin/tax', $admin_path.'Ajax::update_tax_shipping_amount');
$routes->match(['get', 'post'],'admin/slot', $admin_path.'Slot::index');
$routes->match(['get', 'post'],'admin/slot/add_time/(:any)', $admin_path.'Slot::add_time/$1');
$routes->match(['get', 'post'],'admin/add_slot_timer', $admin_path.'Slot::add_slot_timer');
$routes->post('admin/slot/delete_time/', $admin_path.'Slot::delete_time');

$routes->match(['get', 'post'],'admin/order/listing', $admin_path.'Orders::listing');
$routes->match(['get', 'post'],'orders/get_customer', $admin_path.'Orders::get_customer');
$routes->match(['get', 'post'],'admin/orders/view/(:any)', $admin_path.'Orders::view/$1');
$routes->match(['get', 'post'],'admin/orders_view/(:any)', $admin_path.'Orders::seller_view/$1');
$routes->match(['get', 'post'],'admin/orders/payment_status_change/(:any)', $admin_path.'Orders::payment_status_change/$1');
$routes->match(['get', 'post'],'admin/orders/assign_driver/(:any)', $admin_path.'Orders::assign_driver/$1');
$routes->match(['get', 'post'],'admin/orders/admin_comment/(:any)', $admin_path.'Orders::admin_comment/$1');
$routes->match(['get', 'post'],'admin/orders/delete_order', $admin_path.'Orders::delete_order');
$routes->match(['get', 'post'],'admin/orders/order_info_get/(:any)', $admin_path.'Orders::order_info_get/$1');
$routes->match(['get', 'post'],'admin/orders/order_status_change/(:any)', $admin_path.'Orders::order_status_change/$1');
$routes->match(['get', 'post'],'invoice/print/(:any)', $admin_path.'Invoice::print_order/$1');
$routes->match(['get', 'post'],'invoice/pdf/(:any)', $admin_path.'Invoice::pdf/$1');
$routes->match(['get', 'post'],'orders/comment_order_notification/(:any)', $admin_path.'Orders::comment_order_notification/$1');
$routes->match(['get', 'post'],'admin/order/delete_order_comment', $admin_path.'Orders::delete_order_comment');
$routes->match(['get', 'post'],'admin/orders/order_payment_link/(:any)', $admin_path.'Orders::order_payment_link/$1');

// seller
$routes->match(['get', 'post'],'admin/seller/orders', $admin_path.'Orders::seller_listing');
$routes->match(['get', 'post'],'seller/orders/order_status_change/(:any)', $admin_path.'Orders::seller_o_status_change/$1');
$routes->match(['get', 'post'],'seller/orders/payment_status_change/(:any)', $admin_path.'Orders::seller_payment_s_change/$1');


$routes->match(['get', 'post'],'admin/building', $admin_path.'Setting::building');
$routes->match(['get', 'post'],'admin/setting/building_c_edit/(:any)', $admin_path.'Setting::building_create_edit/$1');
$routes->match(['get', 'post'],'setting/get_building_data/(:any)', $admin_path.'Setting::get_building_data/$1');

$routes->match(['get', 'post'],'admin/setting/wing_c_edit/(:any)', $admin_path.'Setting::wing_create_edit/$1');
$routes->match(['get', 'post'],'setting/get_wing_data/(:any)', $admin_path.'Setting::get_wing_data/$1');
$routes->post('setting/delete_building', $admin_path.'Setting::delete_building');
$routes->post('setting/delete_wing', $admin_path.'Setting::delete_wing');

$routes->match(['get', 'post'],'admin/notification', $admin_path.'Notification::index');
$routes->match(['get', 'post'],'notification/resend_noti', $admin_path.'Notification::resend_noti');
$routes->match(['get', 'post'],'admin/notification/delete', $admin_path.'Notification::delete');

$routes->match(['get', 'post'],'admin/payment/link', $admin_path.'Razorpay::payment_link_listing');
$routes->match(['get', 'post'],'admin/razorpay/order_payment_link', $admin_path.'Razorpay::order_payment_link/$1');
$routes->match(['get', 'post'],'admin/razorpay/orders/get_qr/(:any)', $admin_path.'Razorpay::get_qr/$1');


/*Voucher*/
$routes->match(['get', 'post'],'admin/coupon', $admin_path.'Coupon::index');
$routes->match(['get', 'post'],'ajax/get_coupon_data/(:any)', $admin_path.'Coupon::get_coupon_data/$1');
$routes->match(['get', 'post'],'ajax/add_edit_voucher/(:any)', $admin_path.'Coupon::add_edit_voucher/$1');
$routes->match(['get', 'post'],'ajax/delete_coupon', $admin_path.'Coupon::delete_coupon');

/*Rating*/
$routes->match(['get', 'post'],'admin/rating', $admin_path.'Rating::index');
$routes->match(['get', 'post'],'ajax/get_rating_data/(:any)', $admin_path.'Rating::get_data/$1');
$routes->match(['get', 'post'],'ajax/add_edit_rating/(:any)', $admin_path.'Rating::add_edit/$1');
$routes->match(['get', 'post'],'ajax/delete_rating', $admin_path.'Rating::delete');


/*Dashboard stats*/
$routes->post('admin/dashboard/sales_day', $admin_path.'Admin::sales_day');
$routes->post('admin/dashboard/sales_month', $admin_path.'Admin::sales_month');
$routes->post('admin/dashboard/total_sale', $admin_path.'Admin::total_sale');
$routes->post('admin/dashboard/delivered_order', $admin_path.'Admin::delivered_order');
$routes->post('admin/dashboard/canceled_order', $admin_path.'Admin::canceled_order');
$routes->post('admin/dashboard/pending_order', $admin_path.'Admin::pending_order');
$routes->post('admin/dashboard/total_customer', $admin_path.'Admin::total_customer');
$routes->post('admin/dashboard/total_order', $admin_path.'Admin::total_order');

// $routes->match(['get', 'post'],'admin/login', $admin_path.'AdminLogin::index');
// // users controller
// $routes->match(['get', 'post'],'admin/users', $admin_path.'Users::index');
// $routes->match(['get', 'post'],'admin/users/create', $admin_path.'Users::create');
// $routes->match(['get', 'post'],'admin/users/edit/(:num)', $admin_path.'Users::edit/$1');
// $routes->post('admin/users/delete', $admin_path.'Users::delete');
// $routes->get('admin/users/detail/(:num)',  $admin_path.'Users::userDetail/$1');
// admin controller routs end here

// Invoice
// $routes->post('invoice/pdf/(:any)', $front_path.'Invoice::pdf/$1');



// api controller routes
// $routes->get('api', $api_path.'Api::index');


$routes->post('api/otp_login_register', $api_path.'Api::otp_login_register');
$routes->post('api/resend_otp', $api_path.'Api::resend_otp');
$routes->post('api/verify_otp', $api_path.'Api::verify_otp');

$routes->post('api/login', $api_path.'Api::login');
$routes->post('api/register', $api_path.'Api::register');
$routes->match(['post'],'api/forget_password', $api_path.'Api::forget_password');

$routes->match(['get', 'post'],'api/home_page_data', $api_path.'Api::home_page_data');
$routes->match(['get', 'post'],'api/all_category_listing', $api_path.'Api::all_category_listing');
$routes->match(['get', 'post'],'api/get_all_shop', $api_path.'Api::get_all_shop');
$routes->match(['get', 'post'],'api/add_to_cart', $api_path.'Api::add_to_cart');
$routes->match(['get', 'post'],'api/view_cart', $api_path.'Api::view_cart');

$routes->match(['get', 'post'],'api/header_search', $api_path.'Api::header_search');
$routes->match(['get', 'post'],'api/product_detail', $api_path.'Api::product_detail');
$routes->match(['post'],'api/place_order', $api_path.'Api::place_order');
$routes->match(['get', 'post'],'api/update_profile', $api_path.'Api::update_profile');
$routes->match(['get', 'post'],'api/category_product_listing', $api_path.'Api::category_product_listing');
$routes->match(['get', 'post'],'api/shop_product_listing', $api_path.'Api::shop_product_listing');

$routes->match(['post'],'api/order_history', $api_path.'Api::order_history');
$routes->match(['post'],'api/order_history_detail', $api_path.'Api::order_history_detail');

$routes->match(['post'],'api/user_address', $api_path.'Api::user_address');
$routes->match(['post'],'api/apply_voucher', $api_path.'Api::apply_voucher');
$routes->match(['post'],'api/add_user_rating', $api_path.'Api::add_user_rating');
$routes->match(['post'],'api/change_password', $api_path.'Api::change_password');
$routes->match(['post'],'api/stripe_payment_check', $api_path.'Api::stripe_payment_check');


$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {

    $routes->match(['get', 'post'],'drivers/login', 'Api::driver_login');
    $routes->match(['get', 'post'],'drivers/orders', 'Api::driver_order_listing');
    $routes->match(['get', 'post'],'drivers/orders/detail', 'Api::driver_order_detail');
    $routes->match(['get', 'post'],'drivers/orders/verify', 'Api::driver_order_verify_delivered');

});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
