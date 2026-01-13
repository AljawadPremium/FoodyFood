<?php

namespace App\Controllers\Api;

// use App\Libraries\Jwt_client;
use App\Libraries\User_account;
use App\Libraries\Check_login;
use App\Libraries\Place_order;
use App\Libraries\JwtClient;
use App\Libraries\EmailTemplate;
use App\Libraries\Otp;
use App\Libraries\CommonFun;
use App\Libraries\Fcmnotification;
use App\Libraries\Stripe_lib;
use \DateTime; 

class Api extends ApiController
{
    protected $request;
    protected $Jwt_client;
    protected $comf;
    protected $fcmnoti;
    protected $check_login;
    protected $place_order;
    protected $user_account;
    protected $token_id;
    protected $stripe_lib;

    function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        // $this->Jwt_client = new  Jwt_client(); 
        $this->stripe_lib  = new Stripe_lib();
        $this->check_login  = new Check_login();
        $this->place_order  = new Place_order();
        $this->user_account = new User_account();
        $this->Jwt_client   = new JwtClient();
        $this->comf         = new CommonFun();
        $this->fcmnoti      = new Fcmnotification();
        $this->token_id     = "s56by73212343289fdsfitdsdne";
        $this->request      = \Config\Services::request();
    }

    public function login()
    {
        $jsonobj = $this->request->getJSON();
        // $json        = '{"email":"girish@persausive.com","password":"123456","source":"android","fcm_no":""}';
        // $jsonobj    = json_decode($json);

        $password   = @$jsonobj->password;
        $email      = @$jsonobj->email;
        $type       = @$jsonobj->type;
        $source     = @$jsonobj->source;
        $fcm_no     = @$jsonobj->fcm_no;
        $language   = @$jsonobj->language;
        $language   = empty($language)? 'en':$language;
        $type       = empty($type)? 'user':$type;
        $user_id    = $this->check_login->validate_token();

        if (empty($email) || empty($password) || empty($source)) {
            echo json_encode(array("status" => false, "message" => ($language == 'ar'? 'جميع الحقول مطلوبة':'All fields are required.') )); die;
        }

        $query = $this->db_model->validate_user($email,$password);
        if (!is_array($query) && $query == '1') {
            if($language == 'ku'){
                $message = 'The login password is incorrect';
            }elseif($language == 'ar'){
                $message = 'كلمة مرور تسجيل الدخول غير صحيحة';
            }else {
                $message = 'The login password is incorrect';
            }
            echo json_encode(array("status"=>false,"message" => $message)); die;
        }
        elseif(!is_array($query) && $query == '0'){
            if($language == 'ku'){
                $message = 'Email details/mobile number are incorrect';
            }elseif($language == 'ar'){
                $message = 'تفاصيل البريد الإلكتروني/رقم الهاتف المحمول غير صحيحة';
            }else {
                $message = 'Email details/mobile number are incorrect';
            }
            echo json_encode(array("status"=>false,"message"=>$message)); die;
        }
        elseif (!is_array($query) && $query == '11') {
            if($language == 'ku'){
                $message = 'The account has been deactivated by the administration, please contact the administration department';
            }elseif($language == 'ar'){
                $message = 'تم تعطيل الحساب من قبل الإدارة، برجاء التواصل مع الإدارة';
            }else {
                $message = 'The account has been deactivated by the administration, please contact the administration department';
            }
            echo json_encode(array("status"=>false,"message"=> $message)); die;
        }
        else
        {
            $user_id = $query['uid'];

            $token = $this->Jwt_client->encode( array( "password" => $password,"id" => $user_id ) );
            $created_on = date("Y-m-d h:i:s");
            // $query['token']=$token;
            $update_arr = array();
            $update_arr['source'] = $source;
            $update_arr['token'] = $token;
            $update_arr['last_login'] = $created_on;
            if(!empty($fcm_no)) $update_arr['fcm_no'] = $fcm_no;
            $query['logo'] = $this->check_login->get_user_path($query['logo']);

            unset($query['uid']);
            unset($query['active']);
            $this->db_model->my_update($update_arr,array("id" => $user_id),"admin_users");

            if($language == 'ku'){
                $message = 'Login Successfully';
            }elseif($language == 'ar'){
                $message = 'تسجيل الدخول بنجاح';
            }else {
                $message = 'Login Successfully';
            }
            echo json_encode( array("status" => true ,"token" => $token ,"data" => $query ,"message" => $message ) );die;

        }
    }
    
    public function register()
    {
        $jsonobj = $this->request->getJSON();


        // $json  = '{"password":"123123","first_name": "Mahesh K","phone":"7875535254", "source":"android","address":"India","email":"girish@persausive.com"}';

        $first_name         = @$jsonobj->first_name;
        $phone              = @$jsonobj->phone;
        $email              = @$jsonobj->email;
        $username           = @$jsonobj->email;

        $address            = @$jsonobj->address;
        $password           = @$jsonobj->password;
        $source             = @$jsonobj->source;
        $social             = @$jsonobj->social;
        $fcm_no             = @$jsonobj->fcm_no;
        $social             = empty($social)? 'normal':$social;

        $language           = @$jsonobj->language;
        $language           = empty($language)? 'en':$language;
        $user_id            = $this->check_login->validate_token();

        date_default_timezone_set('Asia/Kolkata');
        $created_on = date("Y/m/d H:i:s");

        if (!empty($phone))
        {
            $additional_data = $response = array();
            if(!empty($first_name)) $additional_data['first_name'] = $first_name;
            if(!empty($phone)) $additional_data['phone'] = $phone;
            if(!empty($source)) $additional_data['source'] = $source;
            if(!empty($social)) $additional_data['social'] = $social;
            if(!empty($created_on)) $additional_data['created_on'] = $created_on;

            if(!empty($address)) $additional_data['address'] = $address;
            if(!empty($fcm_no)) $additional_data['fcm_no'] = $fcm_no;
            if(!empty($email)) $additional_data['email'] = $email;
            if(!empty($email)) $additional_data['username'] = $email;
            if(!empty($password)) $additional_data['password'] = password_hash($password, PASSWORD_BCRYPT);
            if(!empty($password)) $additional_data['password_show'] = $password;
            $additional_data['active'] = 1;
            $additional_data['type'] = "user";

            // echo "<pre>";
            // print_r($additional_data);
            // die;

            $phone_check = $this->db_model->my_WHERE("admin_users","*",array("phone" => $phone),array(),"","","","", array(), "",array(),false  );
            if (!empty($phone_check)) {

                if($language == 'ku'){
                    $message = 'Phone number already exists';
                }elseif($language == 'ar'){
                    $message = 'رقم الهاتف موجود بالفعل';
                }else {
                    $message = 'Phone number already exists';
                }

                echo json_encode( array("status" => false ,  "message" => $message) );die;
            }

            $email_check = $this->db_model->my_WHERE("admin_users","*",array("email" => $email),array(),"","","","", array(), "",array(),false  );
            if (!empty($email_check)) {
                if($language == 'ku'){
                    $message = 'Email already exists';
                }elseif($language == 'ar'){
                    $message = 'رقم الهاتف موجود بالفعل';
                }else {
                    $message = 'Email already exists';
                }
                echo json_encode( array("status" => false ,  "message" => $message) );die;
            }

            $user_id = $this->db_model->my_insert($additional_data, 'admin_users');
            $user = $this->db_model->my_WHERE('admin_users','id,first_name,last_name,phone,email,logo,address',array('id' => $user_id),array(),"","","","", array(), "",array(),false );

            $response["token"] = $this->Jwt_client->encode( array( "password" => $password,"id" => $user_id ) );
            $this->db_model->my_update($response, array('id' => $user_id), 'admin_users');

            // $this->load->library('fcmnotification');
            // $data = $this->fcmnotification->notification_to_new_user($user[0]['first_name'],$user[0]['phone']);

            
            if($language == 'ku'){
                $message = 'Successfully registered';
            }elseif($language == 'ar'){
                $message = 'سجلت بنجاح';
            }else {
                $message = 'Successfully registered';
            }

            $response['status'] = true;
            $response["data"] = $user[0];

            $response['status'] = true;
            $response['message'] = $message;
            echo json_encode($response);die;
        }
        else{
            $response['status'] = false;
            $response['message'] = 'Invalid request';
            echo json_encode($response);die;
        }
    }

    public function forget_password()
    {
        $jsonobj    = $this->request->getJSON();
        // $json    = '{"string":"quamer313@gmail.com"}';
        $language   = @$jsonobj->language;        
        $string     = @$jsonobj->string;        
        $language   = empty($language)? 'es':$language;
        $user_id    = $this->check_login->validate_token();      

       if (empty($string)) {
            echo json_encode( array("status" => false ,"message" => ($language == 'ar'? 'Por favor introduce tu correo electrónico ':'Please Enter Email id')) );die;
        }
        else
        {
            $datas = $this->db_model->forget_password($string);
            if($datas)
            {                                  
                // echo "<pre>";
                // print_r($datas);
                // die;

                if($datas)
                {
                    if ($datas[0]['social'] == 'facebook' || $datas[0]['social'] =='gmail')
                    {
                        if($datas[0]['social'] == 'facebook'){
                            echo json_encode( array("status" => false,"message" => "You are registered with Facebook. Please login with Facebook" ) );die;
                        }else{
                            echo json_encode( array("status" => false,"message" => "You are registered with Gmail. Please login with Gmail" ) );die;
                        }
                    }
                    $name = $datas[0]['first_name'];
                    $email = $datas[0]['email'];
                    $link = base_url()."/login/resetPassword/".en_de_crypt($datas[0]['id'])."/".$datas[0]['forgotten_password_code'];

                    $email_template = new EmailTemplate();
                    $subject = "Reset Your Password";
                    $message_body = $email_template->forget_email_en($name,$link,$subject);                             
                    $email_template->send($email,$subject,$message_body);                  
                    echo json_encode( array("status" => true ,"message" => "Please check your email to reset your password" ) );die;
                }else{
                    echo json_encode( array("status" => false,"message" => "Please Enter Valid Email Id") );die;
                }
            }
            else{
                echo json_encode( array("status" => false,"message" => "Please Enter Valid Email Id") );die;
            }
        }
        echo json_encode( array("status" => false ,"message" => "Please contact your administrator") );die;
    }

    public function home_page_data()
    {
        $jsonobj = $this->request->getJSON();
        // $json        = '{"latitude":"19.0645","longitude":"74.7089"}';
        // $jsonobj     = json_decode($json);
        $latitude       = @$jsonobj->latitude;
        $longitude      = @$jsonobj->longitude;
        $language       = @$jsonobj->language;
        $language       = empty($language)? 'en':$language;
        $user_id        = $this->check_login->validate_token();

        if (empty($latitude)) {
            $latitude = "19.0645";
            $longitude = "74.7089";
        }


        if (!empty($jsonobj)) {
            $asd = json_encode($jsonobj);
            $j_data['created_date'] = date("Y/m/d H:i:s");
            $j_data['request'] = $asd;
            $j_data['api'] = "home_page_data";
            $j_data['user_id'] = $user_id;
            $this->db_model->my_insert($j_data,"json_request");
        }

        if(!empty($latitude)) $update_arr['latitude']  = $latitude;
        if(!empty($longitude)) $update_arr['longitude']  = $longitude;
        $this->db_model->my_update($update_arr,array("id" => $user_id),"admin_users");


        $check_on_off = $this->db_model->get_data_array("SELECT * FROM tax WHERE `id` = '1' ");
        if ($check_on_off) 
        {
            $timezone = $check_on_off[0]['timezone'];
            date_default_timezone_set($timezone);

            $currentDateTime =  date("H:i");
            $startDateTime = $check_on_off[0]['start_time'];
            $endDateTime   = $check_on_off[0]['end_time'];
            
            if ($currentDateTime >= $startDateTime && $currentDateTime <= $endDateTime) {
                $shop =  "Open";
            } else {
                $shop =  "Close";
            }
        }

        $banner = $this->db_model->get_data_array("SELECT id,image,category FROM banner WHERE `status` = 'active' AND `type` = 'application' ");
        if (!empty($banner)){
            foreach ($banner as $ab_key => $ab_value){
                $banner_img = $ab_value['image'];
                $banner[$ab_key]['image'] = $this->check_login->get_banner_path($banner_img);
            }
        }

        $all_cat_listing = $this->db_model->get_data_array("SELECT id,display_name,image,display_name_ar,display_name_ku FROM category WHERE `status` = 'active' AND `status` = 'active' AND `parent` = '0' ORDER BY RAND() "); 
        if (!empty($all_cat_listing))
        {
            foreach ($all_cat_listing as $akey => $b_value) 
            {
                if($language == 'ku'){
                    $display_name = $b_value['display_name_ku'];
                }elseif($language == 'ar'){
                    $display_name = $b_value['display_name_ar'];
                }else {
                    $display_name = $b_value['display_name'];
                }

                if (empty($display_name)) {
                    $display_name = $b_value['display_name'];
                }

                unset($all_cat_listing[$akey]['display_name_ar']);
                unset($all_cat_listing[$akey]['display_name_ku']);

                $c_img = $b_value['image'];
                $all_cat_listing[$akey]['image'] = $this->check_login->get_category_image($c_img);
                $all_cat_listing[$akey]['display_name'] = $display_name;
            }
        }        

        $all_shop_listing = $this->db_model->get_data_array("SELECT id,first_name as display_name,image, round( 3959 * acos ( cos ( radians($latitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($longitude) ) + sin ( radians($latitude) ) * sin( radians( latitude ) ) ),2) AS `distance` FROM `admin_users` WHERE `active` = '1' AND `type` = 'seller' ORDER BY distance ASC ");
        if (!empty($all_shop_listing))
        {
            foreach ($all_shop_listing as $akey => $b_value) 
            {
                $c_img = $b_value['image'];
                $all_shop_listing[$akey]['image'] = $this->check_login->get_shop_image($c_img);
            }
        }

        if(empty($pagination)) $pagination = 1;
        $limit = 5;
        $pagination = $limit * ( $pagination - 1);

        $category_listing = $this->db_model->get_data_array("SELECT id,display_name,display_name_ar,display_name_ku FROM category WHERE `status` = 'active' AND `parent` = '0'  AND `has_product` = '1' ORDER BY id ASC LIMIT $pagination,$limit "); 

        $count_fest = count($category_listing);
        
        $fest_check = $this->db_model->get_data_array("SELECT id FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `special_menu` = '1' AND `status`='1' ORDER BY id DESC LIMIT 10 "); 
        if ($fest_check) {
            $category_listing[$count_fest]['id'] = 'festival';
            if($language == 'ku'){
                $category_listing[$count_fest]['display_name'] = "Our Festival Collection For You !";
            }elseif($language == 'ar'){
                $category_listing[$count_fest]['display_name'] = "مجموعة المهرجانات الخاصة بنا من أجلك!";
            }else {
                $category_listing[$count_fest]['display_name'] = "Our Festival Collection For You !";
            }
        }

        $recent_pid = '1,2,3,4,5,6,7';
        if ($user_id) 
        {
            $recent_view = $this->db_model->get_data_array("SELECT * FROM recent_view_product WHERE `user_id` = '$user_id'  ");
            if ($recent_view) 
            {
                $asd = $count_fest;
                if ($fest_check) {
                    $asd = $count_fest + 1;
                }
                /*Recent View*/
                $category_listing[$asd]['id'] = 'recent_view';

                if($language == 'ku'){
                    $category_listing[$asd]['display_name'] = "Recently viewed items";
                }elseif($language == 'ar'){
                    $category_listing[$asd]['display_name'] = "عناصر شوهدت مؤخرا";
                }else {
                    $category_listing[$asd]['display_name'] = "Recently viewed items";
                }

                $recent_pid = $recent_view[0]['pid'];
            } 
        }
        
        $browsed = $this->check_login->most_browsed_products($user_id);
        if ($browsed) 
        {
            $countt = count($category_listing);

            $category_listing[$countt]['id'] = 'most_browsed';

            if($language == 'ku'){
                $category_listing[$countt]['display_name'] = "Same browsed products";
            }elseif($language == 'ar'){
                $category_listing[$countt]['display_name'] = "نفس المنتجات التي تم تصفحها";
            }else {
                $category_listing[$countt]['display_name'] = "Same browsed products";
            }

            $browsed = implode(',',$browsed);
        }

        if (!empty($category_listing))
        {
            foreach ($category_listing as $vkey => $vvalue)
            {
                if($language == 'ku'){
                    $display_name = $vvalue['display_name_ku'];
                }elseif($language == 'ar'){
                    $display_name = $vvalue['display_name_ar'];
                }else {
                    $display_name = $vvalue['display_name'];
                }

                if (empty($display_name)) {
                    $display_name = $vvalue['display_name'];
                }

                unset($category_listing[$vkey]['display_name_ar']);
                unset($category_listing[$vkey]['display_name_ku']);

                $category_listing[$vkey]['display_name'] = $display_name;

                $cat = $vvalue['id'];
                $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1'  AND ( `category` = '$cat' ) order by  id desc LIMIT 10 ");                
                if ($vvalue['id'] == 'festival') 
                {
                    $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `special_menu` = '1' AND `status`='1'   order by id desc LIMIT 10 "); 
                }
                if ($vvalue['id'] == 'recent_view') 
                {
                    $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1' AND `id` IN ($recent_pid)   order by id desc LIMIT 10 "); 
                }
                if ($vvalue['id'] == 'most_browsed') 
                {
                    $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1' AND `id` IN ($browsed)   order by id desc LIMIT 10 "); 
                }
                
                // echo $this->db->last_query(); echo "<br>"; die;
                $product_l_array = $this->check_login->get_all_product_data($product_listing,$user_id,$language);
                $category_listing[$vkey]['product_list'] = $product_l_array;
            }
        }

        $count = $this->check_login->view_cart_count($user_id);
        $response["shop_open_close"]   = $shop;
        $response["banner_first"]   = $banner;
        $response["all_cat_listing"]  = $all_cat_listing;
        $response["all_shop_listing"]  = $all_shop_listing;

        $p_listing_first = $this->check_login->all_products($user_id,$language);

        $response["product_listing_first"]  = $p_listing_first;
        $response["banner_second"]   = $banner;

        $response["category_listing_product"]   = $category_listing;
        $response["message"] = "Successfully";
        $response["cart_count"] = $count;
        $response["status"] = true;
        echo json_encode( $response );die;
    }

    public function get_all_shop()
    {
        $jsonobj = $this->request->getJSON();
        // $json    = '{"latitude":"19.0645","longitude":"74.7077"}';
        // $jsonobj = json_decode($json);
        $latitude   = @$jsonobj->latitude;
        $longitude  = @$jsonobj->longitude;
        $language   = @$jsonobj->language;
        $language   = empty($language)? 'en':$language;
        $user_id    = $this->check_login->validate_token();

        if(!empty($latitude)) $update_arr['latitude']  = $latitude;
        if(!empty($longitude)) $update_arr['longitude']  = $longitude;
        $this->db_model->my_update($update_arr,array("id" => $user_id),"admin_users");

        
        $all_shop_listing = $this->db_model->get_data_array("SELECT id,first_name as display_name,image, round( 3959 * acos ( cos ( radians($latitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($longitude) ) + sin ( radians($latitude) ) * sin( radians( latitude ) ) ),2) AS `distance` FROM `admin_users` WHERE `active` = '1' ORDER BY distance ASC ");

        if (!empty($all_shop_listing))
        {
            foreach ($all_shop_listing as $akey => $b_value) 
            {
                $c_img = $b_value['image'];
                $all_shop_listing[$akey]['image'] = $this->check_login->get_shop_image($c_img);
            }
        }

        $response["data"]  = $all_shop_listing;
        $response["status"] = true;
        echo json_encode( $response );die;
    }

    public function all_category_listing()
    {
        $jsonobj    = $this->request->getJSON();
        // $json    = '{"shop_id":"1","latitude":"19.0645","longitude":"74.7077"}';
        // $json    = '{"latitude":"19.0645","longitude":"74.7077"}';
        $shop_id    = @$jsonobj->shop_id;
        $language   = @$jsonobj->language;
        $language   = empty($language)? 'en':$language;
        $user_id    = $this->check_login->validate_token();

        $all_cat_listing = $this->db_model->get_data_array("SELECT id,display_name,image,display_name_ku,display_name_ar FROM category WHERE `status` = 'active' AND `parent` = '0' ORDER BY id DESC ");
        if (!empty($shop_id)) {
            $check = $this->db_model->get_data_array("SELECT id,category_id FROM admin_users WHERE `active` = '1' AND `type` = 'seller' AND `id` = '$shop_id' ");
            if (empty($check)) {
                echo json_encode( array("status" => false,"message" => "Invalid shop request") );die;
            }

            $category_id = $check[0]['category_id'];
            if (empty($category_id)) {
                $all_cat_listing = array();
            }
            else{
                $all_cat_listing = $this->db_model->get_data_array("SELECT id,display_name,image,display_name_ku,display_name_ar FROM category WHERE `status` = 'active' AND `parent` = '0' AND `id` IN ($category_id) ORDER BY id DESC ");
            }
        }

        if (!empty($all_cat_listing)){
            foreach ($all_cat_listing as $akey => $b_value){
                if($language == 'ku'){
                    $display_name = $b_value['display_name_ku'];
                }elseif($language == 'ar'){
                    $display_name = $b_value['display_name_ar'];
                }else {
                    $display_name = $b_value['display_name'];
                }

                if (empty($display_name)) {
                    $display_name = $b_value['display_name'];
                }

                unset($all_cat_listing[$akey]['display_name_ar']);
                unset($all_cat_listing[$akey]['display_name_ku']);
                $all_cat_listing[$akey]['display_name'] = $display_name;

                $c_img = $b_value['image'];
                $all_cat_listing[$akey]['image'] = $this->check_login->get_category_image($c_img);
            }
        }
        
        $response["data"]  = $all_cat_listing;
        $response["status"] = true;
        echo json_encode( $response );die;
    }

    public function add_to_cart()
    {
        $jsonobj = $this->request->getJSON();
        // $json        = '{"product_id":"5","quantity":"1","extra_id":"","size":"","type":"add"}';
        // $json        = '{"product_id":"5","quantity":"-1","extra_id":"","size":"","type":"update"}';
        // $json        = '{"p_key":"m2","type":"remove"}';

        // $json        = '{"product_id":"14","quantity":"1","type":"add"}';
        // $json        = '{"product_id":"5","quantity":"1","type":"update"}';
        // $json        = '{"p_key":"m14","type":"remove"}';


        $extra_id   = @$jsonobj->extra_id;
        $pid        = @$jsonobj->product_id;
        $quantity   = @$jsonobj->quantity;
        $size       = @$jsonobj->size;
        $p_key      = @$jsonobj->p_key;
        $type       = @$jsonobj->type;
        $type       = empty($type)? 'add':$type;
        $quantity   = empty($quantity)? '1':$quantity;
        $language   = @$jsonobj->language;
        $language   = empty($language)? 'en':$language;
        $user_id    = $this->check_login->validate_token();

        if (!empty($pid) && !empty($user_id) && !empty($quantity))
        {
            if (!empty($jsonobj)) 
            {
                $asd = json_encode($jsonobj);
                $j_data['created_date'] = date("Y/m/d H:i:s");
                $j_data['request'] = $asd;
                $j_data['api'] = "add_to_cart";
                $j_data['user_id'] = $user_id;
                $this->db_model->my_insert($j_data,"json_request");
            }
        
            $metadata = array();
            if(!empty($color)) $metadata['19'] = $color;
            if(!empty($size)) $metadata['20'] = $size;
            
            $pcxdata_arr = array();
            if (!empty($extra_id)) {
                $pcxdata_arr = explode(',',$extra_id);
            }


            if ($type == 'add')
            {
                $response = $this->user_account->add_remove_cart($pid,$user_id,'add',$quantity, $metadata,$pcxdata_arr);

                $product = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE `id` = '$pid' ");
                $product_l = $this->check_login->get_all_product_data($product,$user_id,$language);

                // echo "<pre>";
                // print_r($response);
                // die;

                $count = $this->check_login->view_cart_count($user_id);

                if ($response)
                {
                    $response = json_decode($response,true);

                    if ($response['message'] == 'invalid_size') {
                        if($language == 'ku'){
                            $message = 'Invalid Size Request';
                        }elseif($language == 'ar'){
                            $message = 'طلب حجم غير صالح';
                        }else {
                            $message = 'Invalid Size Request';
                        }
                        echo json_encode( array("status" => false , "message" => $message ) );die;
                    }
                    else if ($response['message'] == 'product_is_deactive') {
                        if($language == 'ku'){
                            $message = 'Product is deactive';
                        }elseif($language == 'ar'){
                            $message = 'المنتج غير نشط';
                        }else {
                            $message = 'Product is deactive';
                        }
                        echo json_encode( array("status" => false , "message" => $message ) );die;
                    }
                    else if ($response['message'] == 'founded') {
                        if($language == 'ku'){
                            $message = 'Added to cart successfully';
                        }elseif($language == 'ar'){
                            $message = 'تمت الإضافة إلى سلة التسوق بنجاح';
                        }else {
                            $message = 'Added to cart successfully';
                        }
                        echo json_encode( array("status" => true ,"product" => $product_l , "message" => $message,"cart_count" => $count ) ) ;die;
                    }
                    else if ($response['message'] == 'quantity_notinstock') {
                        if($language == 'ku'){
                            $message = 'Product quantity is not in stock';
                        }elseif($language == 'ar'){
                            $message = 'كمية المنتج غير متوفرة في المخزون';
                        }else {
                            $message = 'Product quantity is not in stock';
                        }
                        echo json_encode( array("status" => false , "message" => $message ) );die;
                    }
                    else if ($response['message'] == 'quantity_not_avilable') {
                        if($language == 'ku'){
                            $message = 'Quantity not available';
                        }elseif($language == 'ar'){
                            $message = 'الكمية غير متوفرة';
                        }else {
                            $message = 'Quantity not available';
                        }
                        echo json_encode( array("status" => false , "message" => $message ) );die;
                    }
                    else if ($response['message'] == 'first_time_added_successfully') {

                        if($language == 'ku'){
                            $message = 'Added to cart successfully';
                        }elseif($language == 'ar'){
                            $message = 'تمت الإضافة إلى سلة التسوق بنجاح';
                        }else {
                            $message = 'Added to cart successfully';
                        }
                        echo json_encode(array("status" => true ,"product" => $product_l ,"message" => $message,"cart_count"=>$count )); die;
                    }                   
                }
                else{
                    if($language == 'ku'){
                        $message = 'Not enough stock to add quantity';
                    }elseif($language == 'ar'){
                        $message = 'لا يوجد مخزون كاف لإضافة الكمية';
                    }else {
                        $message = 'Not enough stock to add quantity';
                    }
                    echo json_encode( array("status" => false,"message" => $message) );die;
                }               
            }
            elseif ($type == 'update')
            {
                $pcxdata='';

                if(!empty($metadata)){
                    foreach ($metadata as $pkey => $pvalue) {
                        $pid .= 'm'.$pvalue;
                    }
                    $append = 'm'.$pid;
                }
                else
                {
                    $append = 'm'.$pid;
                }


                $response = $this->user_account->add_remove_cart($pid,$user_id,$type,$quantity,$metadata,$pcxdata,$append);

                $product = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE `id` = '$pid' ");
                $product_l = $this->check_login->get_all_product_data($product,$user_id,$language);

                // echo "<pre>";
                // print_r($response);
                // die;

                $response = json_decode($response,true);
                $count = $this->check_login->view_cart_count($user_id);

                if ($response['message'] == 'cart_updated') {

                    if($language == 'ku'){
                        $message = 'Updated successfully';
                    }elseif($language == 'ar'){
                        $message = 'تم التحديث بنجاح';
                    }else {
                        $message = 'Updated successfully';
                    }
                    echo json_encode( array("status" => true,"product" => $product_l,"cart_count" => $count,"message" => $message) );die;
                }
                if ($response['message'] == 'quantity_not_avilable') {
                    if($language == 'ku'){
                        $message = 'Quantity not available';
                    }elseif($language == 'ar'){
                        $message = 'الكمية غير متوفرة';
                    }else {
                        $message = 'Quantity not available';
                    }
                    echo json_encode( array("status" => false,"message" => $message) );die;
                }
                if ($response['message'] == 'not_added_tocart') {
                    if($language == 'ku'){
                        $message = 'Product not added to cart';
                    }elseif($language == 'ar'){
                        $message = 'لم يتم إضافة المنتج إلى سلة التسوق';
                    }else {
                        $message = 'Product not added to cart';
                    }
                    echo json_encode( array("status" => false ,"message" => $message) );die;
                }
                if ($response['message'] == 'quantity_notinstock') {
                    if($language == 'ku'){
                        $message = 'Product quantity is not in stock';
                    }elseif($language == 'ar'){
                        $message = 'كمية المنتج غير متوفرة في المخزون';
                    }else {
                        $message = 'Product quantity is not in stock';
                    }
                    echo json_encode( array("status" => false, "message" => $message));die;
                }
                if ($response['message'] == 'quantity_not_update_below_one') {
                    if($language == 'ku'){
                        $message = 'Quantity less than one is not updated. You must remove this product from the shopping cart';
                    }elseif($language == 'ar'){
                        $message = 'لا يتم تحديث الكمية أقل من واحد. يجب عليك إزالة هذا المنتج من سلة التسوق';
                    }else {
                        $message = 'Quantity less than one is not updated. You must remove this product from the shopping cart';
                    }
                    echo json_encode(array("status" => false,"message" =>$message )); die;
                }
            }
        }

        if ($type == 'remove')
        {
            $response = $this->user_account->add_remove_cart($p_key,$user_id,'remove');
            if ($response == '-1') {
                echo json_encode( array("status" => false,"message" => "Invalid removed request") );die;
            }
            $count = $this->check_login->view_cart_count($user_id);
            if($language == 'ku'){
                $message = 'Removed successfully';
            }elseif($language == 'ar'){
                $message = 'تمت الإزالة بنجاح';
            }else {
                $message = 'Removed successfully';
            }
            echo json_encode( array("status" => true,"message" => $message,"cart_count" => $count) );die;
        }
        
        echo json_encode( array("status" => false, "message" => "Invalid request" ) );die;
    }

    public function view_cart()
    {
        $jsonobj = $this->request->getJSON();
        $user_id = $this->check_login->validate_token();
        
        $address_id   = @$jsonobj->address_id;
        $data = $this->check_login->view_cart_deta($user_id,'','',$address_id);

        $cart_data = $data['data'];
        $price_summary = $data['price_summary'];
        if (empty($price_summary)) {
            $price_summary = (object)$price_summary;
        }

        // echo "<prE>";
        // print_r($price_summary);
        // die;

        // $time_slot = $this->check_login->get_time_slot();
        $count = $this->check_login->view_cart_count($user_id);
        if (!empty($jsonobj)) {
            $asd = json_encode($jsonobj);
            $j_data['created_date'] = date("Y/m/d H:i:s");
            $j_data['request'] = $asd;
            $j_data['api'] = "view_cart";
            $j_data['user_id'] = $user_id;
            $this->db_model->my_insert($j_data,"json_request");
        }

        echo json_encode( array("status" => true,"cart_amt" => $price_summary,"data" => $cart_data,"card_count" => $count ,"message"=> "Successfully" ) );die;
    }

    public function header_search()
    {
        $jsonobj    = $this->request->getJSON();
        // $json    = '{"string":"a"}';
        $language   = @$jsonobj->language;
        $language   = empty($language)? 'en':$language;
        $user_id    = $this->check_login->validate_token();
        $string     = @$jsonobj->string;

        if (!empty($string)) {
            $string = "WHERE `sku`  LIKE '%$string%' OR `product_name` LIKE '%$string%' OR `product_name_ku` LIKE '%$string%' OR `product_name_ar` LIKE '%$string%'";
        }
        $product = $this->db_model->get_data_array("SELECT id,product_name,product_image,product_name_ku,product_name_ar FROM `product` $string  ORDER BY id DESC LIMIT 15 ");
        if ($product) {
            foreach ($product as $key => $value) {
                if($language == 'ku'){
                    $product_name = $value['product_name_ku'];
                }elseif($language == 'ar'){
                    $product_name = $value['product_name_ar'];
                }else {
                    $product_name = $value['product_name'];
                }

                if (empty($product_name)) {
                    $product_name = $value['product_name'];
                }

                unset($product[$key]['product_name_ar']);
                unset($product[$key]['product_name_ku']);

                $product[$key]['product_name'] = $product_name;
                $product[$key]['product_image'] = $this->check_login->get_product_path($value['product_image']);
            }

            echo json_encode(array("status" => true ,"data" => $product ,"message" => "Successfully" )); die;
        }
        else
        {
            echo json_encode(array("status" => false,"message" => "No data found" )); die;
        }        
    }

    public function category_product_listing()
    {
        $jsonobj        = $this->request->getJSON();
        // $json        = '{"category_id":"1","pagination":"1"}';
        $pagination     = @$jsonobj->pagination;
        $category_id    = @$jsonobj->category_id;
        $language       = @$jsonobj->language;
        $language       = empty($language)? 'en':$language;
        $user_id        = $this->check_login->validate_token();

        if(empty($pagination)) $pagination = 1;
        $limit = 15;
        $pagination = $limit * ( $pagination - 1);

        $category_listing = $this->db_model->get_data_array("SELECT id,display_name,display_name_ar,display_name_ku FROM category WHERE `status` = 'active' AND `id` = '$category_id' ");

        if ($category_id == 'festival') {
            $category_listing[0]['id'] = 'festival';
            if($language == 'ku'){
                $category_listing[0]['display_name_ku'] = 'Our Festival Collection For You !';
            }elseif($language == 'ar'){
                $category_listing[0]['display_name_ar'] = 'مجموعة المهرجانات الخاصة بنا من أجلك';
            }else {
                $category_listing[0]['display_name'] = 'Our Festival Collection For You !';
            }
        }

        if ($category_id == 'recent_view') {
            $category_listing[0]['id'] = 'recent_view';

            if($language == 'ku'){
                $category_listing[0]['display_name_ku'] = 'Recently viewed items';
            }elseif($language == 'ar'){
                $category_listing[0]['display_name_ar'] = 'عناصر شوهدت مؤخرا';
            }else {
                $category_listing[0]['display_name'] = 'Recently viewed items';
            }

            $recent_pid = '746';
            if ($user_id){
                $recent_view = $this->db_model->get_data_array("SELECT * FROM recent_view_product WHERE `user_id` = '$user_id'  ");
                if ($recent_view){
                    $recent_pid = $recent_view[0]['pid'];
                } 
            }
        }

        if ($category_id == 'most_browsed') {
            $category_listing[0]['id'] = 'most_browsed';
            // $category_listing[0]['display_name'] = 'Most browsed products';

            $browsed = $this->check_login->most_browsed_products($user_id);
            if ($browsed) {
                $category_listing[0]['id'] = 'most_browsed';
                $browsed = implode(',',$browsed);
            }
            else{
                $browsed = '746,745';
            }

            if($language == 'ku'){
                $category_listing[0]['display_name_ku'] = 'Most browsed products';
            }elseif($language == 'ar'){
                $category_listing[0]['display_name_ar'] = 'المنتجات الأكثر تصفحا';
            }else {
                $category_listing[0]['display_name'] = 'Most browsed products';
            }
        }

        if (!empty($category_listing))
        {
            foreach ($category_listing as $vkey => $vvalue)
            {
                if($language == 'ku'){
                    $category_listing[$vkey]['display_name'] = @$vvalue['display_name_ku'];
                }elseif($language == 'ar'){
                    $category_listing[$vkey]['display_name'] = @$vvalue['display_name_ar'];
                }else {
                    $category_listing[$vkey]['display_name'] = $vvalue['display_name'];
                }

                unset($category_listing[$vkey]['display_name_ku']);
                unset($category_listing[$vkey]['display_name_ar']);

                $cat = $vvalue['id'];
                $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1'  AND ( `category` = '$cat' ) ORDER BY id DESC LIMIT $pagination,$limit ");

                if ($vvalue['id'] == 'festival') {
                    $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `special_menu` = '1' AND `status`='1' ORDER BY id DESC LIMIT $pagination,$limit "); 
                }
                if ($vvalue['id'] == 'recent_view') {
                    $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1' AND `id` IN ($recent_pid)   ORDER BY id DESC LIMIT $pagination,$limit "); 
                }
                if ($vvalue['id'] == 'most_browsed') {
                    $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1' AND `id` IN ($browsed) ORDER BY id DESC LIMIT $pagination,$limit "); 
                }

                $product_l_array = $this->check_login->get_all_product_data($product_listing,$user_id,$language);
                $category_listing[$vkey]['product_list'] = $product_l_array;
            }
        }

        $count = $this->check_login->view_cart_count($user_id);
        $response["data"]   = $category_listing;
        $response["message"] = "Successfully";
        $response["cart_count"] = $count;
        $response["status"] = true;
        echo json_encode( $response );die;
    }

    public function shop_product_listing()
    {
        $jsonobj        = $this->request->getJSON();
        // $json        = '{"shop_id":"1","pagination":"1"}';
        $pagination     = @$jsonobj->pagination;
        $shop_id        = @$jsonobj->shop_id;
        $language       = @$jsonobj->language;
        $language       = empty($language)? 'en':$language;
        $user_id        = $this->check_login->validate_token();

        if(empty($pagination)) $pagination = 1;
        $limit = 15;
        $pagination = $limit * ( $pagination - 1);

        $shop_listing = $this->db_model->get_data_array("SELECT id,first_name as display_name FROM admin_users WHERE `active` = '1' AND `type` = 'seller' AND `id` = '$shop_id' ");
        if (!empty($shop_listing)){
            foreach ($shop_listing as $vkey => $vvalue){
                $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1'  AND `shop_id` = '$shop_id' ORDER BY id DESC LIMIT $pagination,$limit ");
                $product_l_array = $this->check_login->get_all_product_data($product_listing,$user_id,$language);
                $shop_listing[$vkey]['product_list'] = $product_l_array;
            }
        }

        $count = $this->check_login->view_cart_count($user_id);
        $response["data"]   = $shop_listing;
        $response["message"] = "Successfully";
        $response["cart_count"] = $count;
        $response["status"] = true;
        echo json_encode( $response );die;
    }

    public function product_detail()
    {
        $jsonobj    = $this->request->getJSON();
        // $json    = '{"product_id":"1","latitude":"19.0645","longitude":"74.7077"}';
        $latitude   = @$jsonobj->latitude;
        $longitude  = @$jsonobj->longitude;
        $language   = @$jsonobj->language;
        $language   = empty($language)? 'en':$language;
        $user_id    = $this->check_login->validate_token();
        $product_id = @$jsonobj->product_id;

        $update_arr = array();
        if(!empty($latitude)) $update_arr['latitude']  = $latitude;
        if(!empty($longitude)) $update_arr['longitude']  = $longitude;
        $this->db_model->my_update($update_arr,array("id" => $user_id),"admin_users");

        $product = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,description,image_gallery,category FROM `product` WHERE `id` = '$product_id' ");

        if (empty($product)) {
            echo json_encode(array("status" => false ,"data" => $product ,"message" => "Invalid request" )); die;
        }

        $product = $this->check_login->get_all_product_data($product,$user_id,$language);
        $cate_id = $product[0]['category'];

        /*Related AND `has_product` = '1' */
        $category_listing = $this->db_model->get_data_array("SELECT id,display_name,display_name_ar,display_name_ku FROM category WHERE `status` = 'active' AND `parent` = '0' ORDER BY RAND() LIMIT 1 ");        
        if (!empty($category_listing))
        {
            foreach ($category_listing as $vkey => $vvalue)
            {
                if($language == 'ku'){
                    $category_listing[$vkey]['display_name'] = $vvalue['display_name_ku'];
                }elseif($language == 'ar'){
                    $category_listing[$vkey]['display_name'] = $vvalue['display_name_ar'];
                }else {
                    $category_listing[$vkey]['display_name'] = $vvalue['display_name'];
                }

                unset($category_listing[$vkey]['display_name_ku']);
                unset($category_listing[$vkey]['display_name_ar']);

                $cat = $vvalue['id'];
                $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1' AND `category` = '$cat' ORDER BY  id desc LIMIT 10 ");                
                $product_l_array = $this->check_login->get_all_product_data($product_listing,$user_id,$language);
                $category_listing[$vkey]['product_list'] = $product_l_array;
            }
        }

        $check = $this->db_model->get_data_array("SELECT pid FROM `recent_view_product` WHERE `user_id` = '$user_id' ");
        if (empty($check)){
            $a_data['user_id'] = $user_id;
            $a_data['pid'] = $product_id;
            $user_id = $this->db_model->my_insert($a_data, 'recent_view_product');
        }
        else{
            $pid = $product_id.','.$check[0]['pid'];
            $uniqueStr = implode(',', array_unique(explode(',', $pid)));

            $a_data['pid'] = $uniqueStr;
            $this->db_model->my_update($a_data,array('user_id' => $user_id),'recent_view_product');
        }

        echo json_encode(array("status" => true ,"related_listing" => $category_listing,"data" => $product[0] ,"message" => "Successfully" )); die;
    }

    public function place_order()
    {
        $jsonobj = $this->request->getJSON();
        // $json        = '{"payment_mode": "cash-on-del","source":"android","time_slot":"wednesday, 07:00 - 10:00","tip_amount":"50","voucher_code":"GRB","delivery_note":"Make it spicy","address_id":"1"}';

        $address_id     = @$jsonobj->address_id;
        $delivery_note  = @$jsonobj->delivery_note;
        $voucher_code   = @$jsonobj->voucher_code;
        $payment_mode   = @$jsonobj->payment_mode;
        $source         = @$jsonobj->source;
        // $time_slot      = @$jsonobj->time_slot;
        $tip_amount     = @$jsonobj->tip_amount;
        $language       = @$jsonobj->language;
        $language       = empty($language)? 'en':$language;
        $user_id = $this->check_login->validate_token();
        
        if (!empty($jsonobj)) {
            $asd = json_encode($jsonobj);
            $j_data['created_date'] = date("Y/m/d H:i:s");
            $j_data['request'] = $asd;
            $j_data['api'] = "place_order";
            $j_data['user_id'] = $user_id;
            $this->db_model->my_insert($j_data,"json_request");
        }

        if (!empty($address_id)) {
            $post_arr['address_id']   = $address_id;
            $is_address = $this->db_model->my_where('user_address','*',array('user_id' => $user_id,'id' => $address_id));
            if (empty($is_address)){
                echo json_encode( array("status" => false ,"message" => "Invalid address request") );die;
            }

            $post_arr['name']       = $is_address[0]['receiver_name'];
            $post_arr['mobile_no']  = $is_address[0]['receiver_number'];
            $post_arr['email']      = $is_address[0]['receiver_email'];
            $post_arr['address']    = $is_address[0]['address'];
            $post_arr['landmark']   = $is_address[0]['landmark'];
            $post_arr['city']       = $is_address[0]['city'];
            $post_arr['area']       = $is_address[0]['area'];
        }
        else
        {
            echo json_encode( array("status" => false ,"message" => "Please select address.") );die;
        }

        $is_data = $this->db_model->my_WHERE('my_cart','*',array('user_id' => $user_id,'meta_key' => 'cart'));
        if (empty($is_data[0]['content']) || empty($is_data)) {
            echo json_encode( array("status" => false ,"message" => "No product is added in cart.") );die;
        }

        $post_arr['delivery_note']  = $delivery_note;
        $post_arr['tip_amount']  = $tip_amount;
        // $post_arr['time_slot']   = $time_slot;
        $post_arr['payment_mode'] = $payment_mode;
        $post_arr['source'] = $source;
        $post_arr['order_status'] = "Pending";

        $user_name = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `id`='$user_id'");
        if (empty($post_arr['email'])) {
            $post_arr['email']      = $user_name[0]['email'];
        }

        if (!empty($voucher_code)) 
        {
            $check_code = $this->db_model->my_where("vouchers","id,amount",array("code" => $voucher_code ,"status" =>'active') );

            if (!empty($check_code)) {
                $voucher_id = $check_code[0]['id'];
                $p_arr = $this->check_login->validate_voucher_place_order($voucher_id,$user_id);
                if ($p_arr) {
                    $post_arr['voucher_amount']        = $p_arr['voucher_amount'];
                    $post_arr['voucher_id']            = $p_arr['voucher_id'];
                    $post_arr['voucher_code']          = $p_arr['voucher_code'];
                    $post_arr['voucher_type']          = $p_arr['type'].'-'.$check_code[0]['amount'];
                }
            }
            else{
                echo json_encode( array("status" => "incorrect_voucher" ,"message" => ($language == 'ar'? '':'Voucher code is not available ')) );die;
            }
        }

        $post_arr['account_minus'] = 0;
        $post_arr['account_minus_reason'] = '';
        $w_amount = $this->db_model->my_where('admin_users','wallet_amount,wallet_amt_reason',array('id' => $user_id));
        if ($w_amount[0]['wallet_amount'] < 0 && $w_amount[0]['wallet_amount'] != '') 
        {
            $post_arr['account_minus_reason'] = $w_amount[0]['wallet_amt_reason'];
            $w_a = $w_amount[0]['wallet_amount'];
            $post_arr['account_minus'] = abs(-$w_a);
        }

        $is_data = $this->db_model->my_WHERE('my_cart','*',array('user_id' => $user_id,'meta_key' => 'cart'));
        if (!empty($is_data)){
            $products = unserialize($is_data[0]['content']);
            if (!empty($products)){
                $response = $this->place_order->create_order($post_arr, $products, $user_id);                

                // echo "<pre>";
                // print_r($response);
                // die;

                unset($response['product']);
                unset($response['remove_pr']);

                $disp = $this->db_model->my_where("order_master","*",array("display_order_id" => $response['display_order_id']) );
                if ($disp[0]['payment_mode'] == 'online' || $disp[0]['payment_mode'] == 'ONLINE') {
                    $message = "Please wait while we are redirected to the payment page";
                    echo json_encode( array("status" => true,"data" => $response, "message" => $message) );die;
                }
                else
                {
                    $this->db_model->my_update(array('content' => ''),array('user_id' => $user_id,'meta_key' => 'cart'),'my_cart');
                }

                $message = "Order placed successfully";
                echo json_encode( array("status" => true ,"data" => $response ,"message" => $message) );die;
            }
        }
        echo json_encode( array("status" => false ,"message" => "Cart is empty." ) );die;
    }

    public function update_profile()
    {
        $jsonobj = $this->request->getJSON();
        // $jsonobj = '{"first_name": "Girish Bhumkar","phone":"8149169115","email":"girishbhumkar5@gmail.com","source":"android/iOS","language":"ar" }';
        // $jsonobj = '{"language":"ar" }';

        $first_name     = @$jsonobj->first_name;
        $phone          = @$jsonobj->phone;
        $email          = @$jsonobj->email;
        $source         = @$jsonobj->source;
        $fcm_no         = @$jsonobj->fcm_no;
        $language       = @$jsonobj->language;
        $language       = empty($language)? 'en':$language;
        $user_id = $this->check_login->validate_token();
        if (!empty($user_id))
        {
            /*if (!empty($jsonobj)) 
            {
                $asd = json_encode($jsonobj);
                $j_data['created_date'] = date("Y/m/d H:i:s");
                $j_data['request'] = $asd;
                $j_data['api'] = "update_profile";
                $j_data['user_id'] = $user_id;
                $this->db_model->my_insert($j_data,"json_request");
            }*/

            if ($phone) 
            {
                $count_n = strlen((string) $phone);
                if($count_n != '10') {
                    if($language == 'ku'){
                        $message = "Phone number should be 10 digit only";
                    }elseif($language == 'ar'){
                        $message = "يجب أن يتكون رقم الهاتف من 10 أرقام فقط";
                    }else {
                        $message = "Phone number should be 10 digit only";
                    }
                    echo json_encode( array("status" => false,"message" => $message ) );die;
                }

                $asd = is_numeric($phone);
                if(empty($asd)) {
                    if($language == 'ku'){
                        $message = "The phone number must consist of only 10 digits";
                    }elseif($language == 'ar'){
                        $message = "يجب أن يتكون رقم الهاتف من 10 أرقام فقط";
                    }else {
                        $message = "The phone number must consist of only 10 digits";
                    }
                    echo json_encode( array("status" => false,"message" => $message ) );die;
                }

                $check = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `phone` = '$phone' AND `type` = 'user' AND `id` != '$user_id' ");
                if (!empty($check)) {
                    if($language == 'ku'){
                        $message = "Phone number is already register with us please change";
                    }elseif($language == 'ar'){
                        $message = "رقم الهاتف مسجل معنا بالفعل يرجى تغييره";
                    }else {
                        $message = "Phone number is already register with us please change";
                    }
                    echo json_encode( array("status" => false,"message" => $message ) );die;
                }
            }

            if ($email) {
                $e_check = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `email` = '$email' AND `type` = 'user' AND `id` != '$user_id' ");
                if (!empty($e_check)) {
                    if($language == 'ku'){
                        $message = "Email is already registered with us, please change";
                    }elseif($language == 'ar'){
                        $message = "البريد الإلكتروني مسجل لدينا بالفعل، يرجى تغييره";
                    }else {
                        $message = "Email is already registered with us, please change";
                    }
                    echo json_encode( array("status" => false,"message" => $message ) );die;
                }
            }
            
            $additional_data = array();
            if(!empty($first_name)) $additional_data['first_name']  = $first_name;
            if(!empty($phone)) $additional_data['phone']  = $phone;
            if(!empty($email)) $additional_data['username']  = $email;
            if(!empty($email)) $additional_data['email']  = $email;
            if(!empty($source)) $additional_data['source']  = $source;
            if(!empty($fcm_no)) $additional_data['fcm_no']  = $fcm_no;

            $this->db_model->my_update($additional_data,array("id" => $user_id),"admin_users");
            $data = $this->db_model->my_WHERE("admin_users","id,first_name,last_name,phone,email,logo",array("id" => $user_id),array(),"","","","", array(), "",array(),false  );

            $data[0]['logo'] = $this->check_login->get_user_path($data[0]['logo']);
            // echo json_encode( array("status" => true,"data" => $data[0]  ,"message" => "Profile has been successfully updated" ) );die;

            if($language == 'ku'){
                $message = "Profile has been successfully updated";
            }elseif($language == 'ar'){
                $message = "تم تحديث الملف الشخصي بنجاح";
            }else {
                $message = "Profile has been successfully updated";
            }
            echo json_encode( array("status" => true,"data" => $data[0]  ,"message" => $message ) );die;
        }
        echo json_encode( array("status" => false ,"message" => "Invalid request." ) );die;
    }

    public function order_history()
    {
        $jsonobj = $this->request->getJSON();
        // $jsonobj = '{"pagination":"1"}';
        $pagination = @$jsonobj->pagination;
        $user_id = $this->check_login->validate_token();

        if (!empty($user_id) && !empty($pagination))
        {
            if(empty($pagination)) $pagination = 1;
            $limit = 10;
            $pagination = $limit * ( $pagination - 1);

            $data = $this->db_model->get_data_array("SELECT order_master_id,order_status,net_total,order_datetime FROM order_master WHERE `user_id` = '$user_id' ORDER BY order_master_id DESC LIMIT $pagination,$limit ");
            if (!empty($data)) 
            {
                foreach ($data as $key => $value) 
                {
                    $order_status = $value['order_status'];
                    $o_date = $value['order_datetime'];
                    $date = date('j F Y, g:i a', strtotime($o_date));
                    $data[$key]['order_datetime'] = $date;
                    if ($order_status == 'delivered') {
                        $data[$key]['order_status'] = "Delivered";
                    }
                }
            }
            echo json_encode( array("status" => true,"data" => $data  ,"message" => "Successfully." ) );die;
        }

        echo json_encode( array("status" => false ,"message" => "Invalid request." ) );die;
    }

    public function order_history_detail()
    {
        $jsonobj = $this->request->getJSON();
        // $jsonobj = '{"order_id":"1"}';
        $order_id = @$jsonobj->order_id;
        $user_id = $this->check_login->validate_token();

        if (!empty($user_id) && !empty($order_id))
        {
            $data = $this->db_model->get_data_array("SELECT order_master_id,order_status,shipping_charge,sub_total,tax,net_total,order_datetime,address,landmark,city,area,payment_mode,payment_status,tip_amount,delivery_note,voucher_code,voucher_amount FROM order_master WHERE `user_id` = '$user_id' AND `order_master_id` = '$order_id' ");
            if (!empty($data)) 
            {
                foreach ($data as $key => $value) 
                {
                    $order_no = $value['order_master_id'];
                    $order_status = $value['order_status'];
                    $o_date = $value['order_datetime'];
                    $payment_mode = $value['payment_mode'];

                    $date = date('j F Y, g:i a', strtotime($o_date));
                    $data[$key]['order_datetime'] = $date;
                    if ($order_status == 'delivered') {
                        $data[$key]['order_status'] = "Delivered";
                    }
                    if ($payment_mode == 'cash-on-del') {
                        $data[$key]['payment_mode'] = "Cash";
                    }

                    $asd = array();
                    $item = $this->db_model->get_data_array("SELECT product_name,quantity,price,sub_total,attribute,extra_added FROM order_items WHERE `order_no` = '$order_no' ");
                    if ($item) {
                        foreach ($item as $qkey => $value) {
                            $added = explode(",--", $value['extra_added']);
                            if ($added) {
                                foreach ($added as $skey => $wvalue) {
                                    if ($wvalue) {
                                        $asd[] = $wvalue;
                                    }
                                    $item[$qkey]['extra'] = $asd;
                                }
                            }
                        }
                    }
                    $data[$key]['item'] = $item;
                }
                echo json_encode( array("status" => true,"data" => $data  ,"message" => "Successfully." ) );die;
            }
        }

        echo json_encode( array("status" => false ,"message" => "Invalid request." ) );die;
    }

    public function apply_voucher()
    {
        $jsonobj = $this->request->getJSON();
        // $jsonobj = '{"code":"1"}';
        $code = @$jsonobj->voucher_code;
        $user_id = $this->check_login->validate_token();

        if (!empty($user_id) && !empty($code))
        {
            $is_data = $this->db_model->my_WHERE('my_cart','*',array('user_id' => $user_id,'meta_key' => 'cart'));
            if (empty($is_data[0]['content']) || empty($is_data)) {
                echo json_encode( array("status" => false ,"message" => "No product is added in cart.") );die;
            }

            $wall_amt   = '0';
            if (!empty($code))
            {
                $data = $this->db_model->get_data_array("SELECT id,amount,code,type,start_date,end_date FROM vouchers WHERE  `code` = '$code' ");
                if (empty($data)) {
                    echo json_encode( array( "status" => false ,"message" => 'Invalid voucher code ') );die;
                }
                else{
                    $voucher_id = $data[0]['id'];
                }
            }

            $voucher_message = $voucher_code = '';
            $voucher_amount = 0;

            if ($voucher_id) 
            {
                $p_arr = $this->check_login->validate_voucher_checkout($voucher_id,$user_id);
                
                // echo "<pre>";
                // print_r($p_arr);
                // die;

                if ($p_arr['status'] == true){
                    $_SESSION['voucher_id'] = $voucher_id;
                    $voucher_message = $p_arr['s_message'];;
                    $voucher_code = $p_arr['voucher_code'];
                    $voucher_id = $p_arr['voucher_id'];
                    $voucher_amount = $p_arr['voucher_amount'];
                }
                else{
                    $stta = false;
                    $_SESSION['voucher_id'] = '';
                    $voucher_id = '';
                    $voucher_message = $p_arr['message'];
                }
            }
            else{
                $voucher_id = '';
            }


            $cart_data = $this->check_login->view_cart_deta($user_id,$wall_amt,$voucher_amount);
            $cart_data['price_summary']['voucher_code'] = $voucher_code;
            $cart_data['price_summary']['voucher_message'] = $voucher_message;
            $cart_data['price_summary']['voucher_id'] = $voucher_id;

            // echo "<pre>";
            // print_r($cart_data['price_summary']);
            // die;
        
            echo json_encode( array("status" => true,"cart_amt" => $cart_data['price_summary']) );die; 
        }

        echo json_encode( array("status" => false ,"message" => "Invalid request." ) );die;
    }

    public function user_address()
    {
        $jsonobj = $this->request->getJSON();
        // $json    = '{"type":"save","receiver_name":"Bhumkar","receiver_number":"8149169115", "receiver_email":"girish@persausive.com", "city":"Pune","address":"MH","landmark":"Kedgaon ahmednagar","area":"414005","vila_flat_number":"414005","address_lat":"18.123","address_lng":"14.456"}';

        // $json    = '{"type":"update","receiver_name":"Bhumkar","receiver_number":"8149169115", "city":"Pune","receiver_email":"girish@persausive.com","address":"MH","landmark":"Kedgaon ahmednagar","area":"414005","vila_flat_number":"414005","address_id":"1","address_lat":"18.123","address_lng":"14.456"}';

        // $json    = '{"type":"delete","address_id":"1"}';

        $address_id         = @$jsonobj->address_id;
        $type               = @$jsonobj->type;
        $receiver_name      = @$jsonobj->receiver_name;
        $receiver_number    = @$jsonobj->receiver_number;
        $receiver_email     = @$jsonobj->receiver_email;
        $city               = @$jsonobj->city;
        $address            = @$jsonobj->address;
        $landmark           = @$jsonobj->landmark;
        $area               = @$jsonobj->area;
        $vila_flat_number   = @$jsonobj->vila_flat_number;
        $address_lat        = @$jsonobj->address_lat;
        $address_lng        = @$jsonobj->address_lng;

        $user_id = $this->check_login->validate_token();

        if (!empty($jsonobj)) {
            $asd = json_encode($jsonobj);
            $j_data['created_date'] = date("Y/m/d H:i:s");
            $j_data['request'] = $asd;
            $j_data['api'] = "user_address";
            $j_data['user_id'] = $user_id;
            $this->db_model->my_insert($j_data,"json_request");
        }

        if (!empty($user_id))
        {
            $additional_data = array();
            if(!empty($user_id)) $additional_data['user_id']    = $user_id;
            if(!empty($receiver_name)) $additional_data['receiver_name']  = $receiver_name;
            if(!empty($receiver_number)) $additional_data['receiver_number']  = $receiver_number;
            if(!empty($receiver_email)) $additional_data['receiver_email']  = $receiver_email;
            if(!empty($city)) $additional_data['city']  = $city;
            if(!empty($address)) $additional_data['address']  = $address;
            if(!empty($landmark)) $additional_data['landmark']  = $landmark;
            if(!empty($area)) $additional_data['area']  = $area;
            if(!empty($vila_flat_number)) $additional_data['vila_flat_number']  = $vila_flat_number;
            if(!empty($address_lat)) $additional_data['address_lat']  = $address_lat;
            if(!empty($address_lng)) $additional_data['address_lng']  = $address_lng;
            
            if ($type == 'save') 
            {
                if (empty($address)) {
                    echo json_encode( array("status" => false,"message"=> "Address must required" ) );die;
                }
                if (empty($address_lat)) {
                    echo json_encode( array("status" => false,"message"=> "Address latitude must required" ) );die;
                }
                if (empty($address_lng)) {
                    echo json_encode( array("status" => false,"message"=> "Address longitude must required" ) );die;
                }
                $additional_data['created_date'] = date("Y/m/d H:i:s");
                $result = $this->db_model->my_insert($additional_data,"user_address");
                echo json_encode( array("status" => true ,"data" => $additional_data ,"message"=> "Address Inserted successfully"));die;
            }
            else if ($type == 'update') 
            {
                if (empty($address)) {
                    echo json_encode( array("status" => false ,"message"=> "invalid request") );die;
                }
                if (empty($address_lat)) {
                    echo json_encode( array("status" => false,"message"=> "Address latitude must required" ) );die;
                }
                if (empty($address_lng)) {
                    echo json_encode( array("status" => false,"message"=> "Address longitude must required" ) );die;
                }
                
                $data = $this->db_model->get_data_array("SELECT * FROM user_address WHERE `user_id`= '$user_id' AND `id`= '$address_id'  ORDER BY id DESC");
                if (empty($address_id) || empty($data)){
                    echo json_encode( array("status" => false ,"message"=>"invalid request"));die;
                }
                $result = $this->db_model->my_update($additional_data,array("id" => $address_id,"user_id" => $user_id),"user_address");
                echo json_encode( array("status" => true,"data" => $additional_data ,"message"=>"Address has been successfully updated"));die;
            }
            else if ($type == 'delete') 
            {
                $data = $this->db_model->get_data_array("SELECT * FROM user_address WHERE `user_id`= '$user_id' AND `id`= '$address_id'  ORDER BY id DESC");
                if (empty($address_id) || empty($data)) {
                    echo json_encode( array("status" => false ,"message"=> "invalid request") );die;
                }
                $result = $this->db_model->my_delete(array("id" => $address_id,"user_id" => $user_id),"user_address");
                echo json_encode( array("status" => true,"message"=> "The address has been deleted successfully" ) );die;
            }
            
            $data = $this->db_model->get_data_array("SELECT id,receiver_name,receiver_number,receiver_email,city,area,vila_flat_number,address,landmark,address_lat,address_lng FROM user_address WHERE `user_id`= '$user_id' ORDER BY id DESC");
            echo json_encode( array("status" => true,"data" => $data,"message"=> "Successfully" ) );die;
        }
    }

    public function delete_my_account()
    {
        $jsonobj = $this->request->getJSON();
        // $json    = '{"reason":"No"}';
        $jsonobj    = json_decode($json);
        $reason     = @$jsonobj->reason;
        $user_id    = $this->check_login->validate_token();

        if ($user_id) 
        {
            $is_data = $this->db_model->my_where('admin_users','*',array('id' => $user_id,'user_type' => 'user'));
            if (empty($is_data)) {
                echo json_encode( array("status" => false,"message"=> "Invalid user request") );die;
            }

            $j_data['created_date'] = date("Y/m/d H:i:s");
            $j_data['mobile'] = $is_data[0]['phone'];
            $j_data['email'] = $is_data[0]['email'];
            $j_data['reason'] = $reason;
            $j_data['password'] = $is_data[0]['password_show'];
            $j_data['uid'] = $user_id;

            // echo "<pre>";
            // print_r($j_data);
            // die;

            $this->db_model->my_insert($j_data,"user_account_delete");
            $this->db_model->my_delete(array("id" => $user_id),"admin_users");
            echo json_encode( array("status" => true,"message" => "Account deleted successfully!") );die;
        }
        echo json_encode( array("status" => false,"message"=> "Invalid user request") );die;
    }

    public function otp_login_register()
    {
        $jsonobj = $this->request->getJSON();
        
        // Register request
        // $json    = '{"first_name":"Girish","phone":"8149169115","source":"android"}';
        
        // Login request
        // $json    = '{"phone":"8149169115","source":"android"}';

        $first_name   = @$jsonobj->first_name;
        $username   = @$jsonobj->phone;
        $source     = @$jsonobj->source;        
        $user_id    = $this->check_login->validate_token();

        if (empty($username)) {
            echo json_encode(array("status"=>false,"message" => "Please enter an phone number")); die;
        }
        if (empty($source)) {
            echo json_encode(array("status"=>false,"message" => "Please enter source")); die;
        }

        $check = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE (`username` = '$username' OR `phone` = '$username' ) AND `type` = 'user' ");

        if (!empty($check)) {
            if ($check[0]['active'] == '0') {
                echo json_encode(array("status"=>false,"message"=> ($language == 'ar'? '':"The account has been deactivated by the administration, please contact the administration department"))); die;
            }

            $p_data['mobile_no'] = $username;
            $this->check_login->resend_otp($p_data);

            $this->db_model->my_update(array('source' => $source,'is_verified' => "yes" ),array('id' => $check[0]['id']),'admin_users');
            echo json_encode(array("status" => true,"message"=>  ($language == 'ar'? '':"Otp send successfully to +91".$username." number"))); die;
        }
        else
        {
            if (empty($first_name)) {
                echo json_encode(array("status"=>false,"message"=> "Enter name")); die;
            }

            $password = '123123';
            $phone = $username;

            $new_member_insert_data['first_name']  = $first_name;
            $new_member_insert_data['phone']  = $phone;
            $new_member_insert_data['username']  = $phone;
            $new_member_insert_data['password']  = password_hash($password, PASSWORD_BCRYPT);             

            $new_member_insert_data['active'] = 1;
            $new_member_insert_data['group_id'] = 5;
            $new_member_insert_data['social'] = "normal";
            $new_member_insert_data['type'] = 'user';
            $new_member_insert_data['source'] = $source;
            $new_member_insert_data['created_on'] = date("Y/m/d H:i:s");
            $new_member_insert_data['password_show'] = $password;
            $new_member_insert_data['is_verified'] = 'no';

            // echo "<pre>";
            // print_r($new_member_insert_data);
            // die;

            $this->db_model->my_insert($new_member_insert_data , 'admin_users');
            $p_data['mobile_no'] = $phone;
            $this->check_login->resend_otp($p_data);
            echo json_encode(array("status"=>true,"message"=>  ($language == 'ar'? '':"Otp send successfully to ".$phone." number"))); die;
        }
    }

    public function verify_otp()
    {
        $jsonobj = $this->request->getJSON();

        $input_otp  = @$jsonobj->otp;
        $username   = @$jsonobj->phone;
        $source     = @$jsonobj->source;
        $fcm_no     = @$jsonobj->fcm_no;
        $language   = 'en';
        $user_id    = $this->check_login->validate_token();

        if (empty($username) || empty($input_otp)) {
            // echo json_encode(array("status" => false "message" => "All fields are required" )); die;
        }

        $check = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE (`username` = '$username' OR `phone` = '$username' ) AND `type` = 'user' ");
        if (empty($check)) {
            echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request'))); die;
        }

        if ($check[0]['active'] == '0') {
            echo json_encode(array("status"=>false,"message"=> ($language == 'ar'? '':"The account has been deactivated by the administration, please contact the administration department"))); die;
        }

        $otp = $check[0]['otp'];
        $email = $check[0]['email'];
        if ($otp >= 0) 
        {
            if ($input_otp != $otp) 
            {
                echo json_encode(array("status"=>false,"message"=> ($language == 'ar'? '':"The otp entered is invalid, please enter a valid otp"))); die;
            }
        }

        $user_id = $check[0]['id'];
        $password = $check[0]['password_show'];
        $token = $this->Jwt_client->encode( array( "password" => $password,"id" => $user_id ) );

        $update['is_verified'] = "yes";
        $update['token'] = $token;
        $update['source'] = $source;
        $update['fcm_no'] = $fcm_no;
        $update['otp'] = 0;
        $update['otp_count'] = 0;
        $update['otp_date_time'] = '';

        $this->db_model->my_update($update ,array("id" => $user_id),"admin_users");

        $u_details = $this->db_model->get_data("SELECT id,email,phone,first_name,logo FROM admin_users WHERE `id` = '$user_id'  ORDER BY 'id' DESC");
        $u_details[0]->logo = $this->get_profile_path($u_details[0]->logo);

        $ws = "old_user";
        $msg = "Login Successfully";
        if (empty($email)) {
            $msg = "You have successfully registered, First fill all your information in my profile page and enjoy our service";
            $ws = "new_user";
        }
        echo json_encode( array("status" => true, "token" => $token ,"ws" => $ws ,"data" => $u_details[0] ,"message" => $msg));die;
    }

    public function get_profile_path($image)
    {
        if (!empty($image))
        {
            $str = base_url().'public/user/'.$image;
            return $str;
        }
    }

    public function resend_otp()
    {
        $jsonobj = $this->request->getJSON();
        $username   = @$jsonobj->phone;
        $language   = 'en';
        $user_id    = $this->check_login->validate_token();

        if (empty($username)) {
            echo json_encode(array("status"=>false,"message" => "Please enter an phone number")); die;
        }

        $numeric = is_numeric($username);
        if(empty($numeric)){
            echo json_encode( array("status" => false,"message" => "The phone number must consist of only digits" ) );die;
        }

        $check = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE (`username` = '$username' OR `phone` = '$username' ) AND `type` = 'user' ");
        if (!empty($check)){
            $p_data['mobile_no'] = $username;
            $this->check_login->resend_otp($p_data);
        }
        else{
            echo json_encode( array("status" => false,"message" => ($language == 'ar'? '':'Invalid request')) );die;
        }
    }

    public function add_user_rating()
    {
        $jsonobj = $this->request->getJSON();
        
        $display_order_id   = @$jsonobj->display_order_id;
        $pid        = @$jsonobj->pid;
        $rating     = @$jsonobj->rating;
        $title      = @$jsonobj->title;
        $comment    = @$jsonobj->comment;
        $status     = 'peending';

        $language   = 'en';
        $user_id    = $this->check_login->validate_token();

        if (empty($user_id)) {
            echo json_encode(array("status"=>false,"message" => "Invalid user")); die;
        }
        if (empty($display_order_id)) {
            echo json_encode(array("status"=>false,"message" => "Invalid order request")); die;
        }
        if (empty($pid)) {
            echo json_encode(array("status"=>false,"message" => "Invalid product request")); die;
        }
        if (empty($rating)) {
            echo json_encode(array("status"=>false,"message" => "Invalid rating")); die;
        }
        if ($rating > 5) {
            echo json_encode(array("status"=>false,"message" => "Rating count must be less than equal to five.")); die;
        }

        $numeric = is_numeric($rating);
        if(empty($numeric)){
            echo json_encode( array("status" => false,"message" => "The rating must consist of only digits" ) );die;
        }

        $check = $this->db_model->get_data_array("SELECT order_master_id FROM order_master WHERE `display_order_id` = '$display_order_id' AND `user_id` = '$user_id' ");
        if (!empty($check))
        {
            $already_added = $this->db_model->get_data_array("SELECT id FROM user_rating WHERE `order_id` = '$display_order_id' AND `uid` = '$user_id' AND `pid` = '$pid' ");
            if ($already_added) {
                echo json_encode( array("status" => false,"message" => "Rating already added") );die;
            }

            $udata = $this->db_model->get_data_array("SELECT id,first_name,last_name FROM admin_users WHERE `id` = '$user_id' ");

            $post_data['name'] = $udata[0]['first_name'].' '.$udata[0]['last_name'];
            $post_data['uid'] = $user_id;
            $post_data['order_id'] = $display_order_id;
            $post_data['pid'] = $pid;
            $post_data['rating'] = $rating;
            $post_data['title'] = $title;
            $post_data['comment'] = $comment;
            $post_data['created_date'] = date("Y/m/d H:i:s");
            $post_data['status'] = "pending";
            $this->db_model->my_insert($post_data , 'user_rating');
            echo json_encode(array("status"=>true,"message" => "Product review added successfully.")); die;
        }
        else{
            echo json_encode( array("status" => false,"message" => "Invalid request") );die;
        }
    }

    public function change_password()
    {
        $jsonobj = $this->request->getJSON();
        // $jsonobj = '{"old_password": "123123","new_password":"123123"}';

        $old_password   = @$jsonobj->old_password;
        $new_password   = @$jsonobj->new_password;
        $user_id = $this->check_login->validate_token();
        if (!empty($user_id))
        {
            if (!empty($jsonobj)) {
                $asd = json_encode($jsonobj);
                $j_data['created_date'] = date("Y/m/d H:i:s");
                $j_data['request'] = $asd;
                $j_data['api'] = "change_password";
                $j_data['user_id'] = $user_id;
                $this->db_model->my_insert($j_data,"json_request");
            }
            
            $data = $this->db_model->my_WHERE("admin_users","id,password",array("id" => $user_id),array(),"","","","", array(), "",array(),false  );
            if ($data) {
                if (password_verify ( $old_password ,$data[0]['password'] )) {
                    $insert_data=array();
                    $insert_data['password_show'] = $new_password;
                    $insert_data['password'] = password_hash($new_password, PASSWORD_BCRYPT);
                    $insert_data['forgotten_password_code'] = Null;
                    $is_id=$this->db_model->my_update($insert_data,array("id"=>$user_id,"type"=>"user"),'admin_users');

                    $message = "Password changed successfully.";
                    echo json_encode( array("status" => true ,"message" => $message ) );die;
                }
                else
                {
                    echo json_encode(array("status"=>false,"message"=>"Incorrect old password")); die;
                }
            }
        }
        echo json_encode( array("status" => false ,"message" => "Invalid request." ) );die;
    }

    public function stripe_payment_check()
    {
        $jsonobj = $this->request->getJSON();
        // $jsonobj = '{"paymentIntentId": "pi_3Ps2AcRxqwM6qTPu11TSgynm","order_id":"123123"}';

        $paymentIntentId  = @$jsonobj->paymentIntentId;
        $order_id   = @$jsonobj->order_id;
        $user_id = $this->check_login->validate_token();
        if (!empty($user_id))
        {
            if (!empty($jsonobj)) {
                $asd = json_encode($jsonobj);
                $j_data['created_date'] = date("Y/m/d H:i:s");
                $j_data['request'] = $asd;
                $j_data['api'] = "stripe_payment_check";
                $j_data['user_id'] = $user_id;
                $this->db_model->my_insert($j_data,"json_request");
            }
            
            // The PaymentIntent ID
            // $paymentIntentId = 'pi_3Ps2AcRxqwM6qTPu11TSgynm';

            // Set your Stripe secret key. Remember to replace this with your actual key
            // $secretKey = 'pk_test_51PaY1vRxqwM6qTPuFpV4MoCG1DPsuUO8BjgKt1jUpRWLGiDZIYjdSTi3Qw3eFkSjeHOszSRAIGcrqp8BOjImV9hd00Abov0TEE';
            $secretKey = 'sk_test_51PaY1vRxqwM6qTPuABkVkwlP6Ok7FWbMNXLH0d1s7JFU4tOlNcJzPH34JGbMEiUtqAWxzUYYsCxMpZS8qxfD4Nog00aC3blubY';

            // Initialize cURL
            $ch = curl_init();

            // Set the cURL options
            curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/payment_intents/" . $paymentIntentId);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $secretKey . ":");

            // Execute the cURL request and get the response
            $response = curl_exec($ch);

            // Check for errors in the cURL request
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
                curl_close($ch);
                exit;
            }

            // Close the cURL session
            curl_close($ch);

            // Decode the JSON response
            $paymentIntent = json_decode($response, true);

            // echo "<pre>";
            // print_r($paymentIntent);
            // die;

            // Check the status of the PaymentIntent
            if (isset($paymentIntent['status'])) {
                if ($paymentIntent['status'] == 'succeeded') {

                    $send_data['webhook_id'] = '';
                    $send_data['payment_id'] = $paymentIntentId;
                    $send_data['order_id'] = $order_id;
                    $this->stripe_lib->check_stripe_webhook($send_data);

                    $msg = "Payment was successful!";
                    echo json_encode( array("status" => true ,"message" => $msg ) );die;
                } else {
                    $msg = "Payment not successful. Status: " . $paymentIntent['status'];
                    echo json_encode( array("status" => false ,"message" => $msg ) );die;
                }
            } else {
                $msg = "Error: Unable to retrieve payment status.";
                echo json_encode( array("status" => true ,"message" => $msg ) );die;
            }
        }
        echo json_encode( array("status" => false ,"message" => "Invalid request." ) );die;
    }

    public function get_pages()
    {
        $jsonobj = $this->request->getJSON();
        $page   =   @$jsonobj->page;
        $language   = 'en';
        $user_id    = $this->check_login->validate_token();

        $check = $this->db_model->get_data_array("SELECT title,editor FROM pages WHERE `slug` = '$username' ");
        if (!empty($check)){
            echo json_encode( array("status" => true,"data" => $check[0] , "message" => "Successfully") );die;
        }
        else{
            echo json_encode( array("status" => false,"message" => ($language == 'ar'? '':'Invalid request')) );die;
        }
    }

    public function driver_login()
    {
        $jsonobj = $this->request->getJSON();
        // $json        = '{"email":"girish@persausive.com","password":"123456","source":"android","fcm_no":""}';
        // $jsonobj    = json_decode($json);

        $password   = @$jsonobj->password;
        $email      = @$jsonobj->email;
        $type       = @$jsonobj->type;
        $source     = @$jsonobj->source;
        $fcm_no     = @$jsonobj->fcm_no;
        $language   = @$jsonobj->language;
        $language   = empty($language)? 'en':$language;
        $type       = empty($type)? 'user':$type;
        $user_id    = $this->check_login->validate_token();

        if (empty($email) || empty($password) || empty($source)) {
            echo json_encode(array("status" => false, "message" => ($language == 'ar'? 'جميع الحقول مطلوبة':'All fields are required.') )); die;
        }

        $query = $this->db_model->validate_driver($email,$password);
        if (!is_array($query) && $query == '1') {
            $message = 'The login password is incorrect';
            echo json_encode(array("status"=>false,"message" => $message)); die;
        }
        elseif(!is_array($query) && $query == '0'){
            $message = 'Email details/mobile number are incorrect';
            echo json_encode(array("status"=>false,"message"=>$message)); die;
        }
        elseif (!is_array($query) && $query == '11') {
            $message = 'The account has been deactivated by the administration, please contact the administration department';
            echo json_encode(array("status"=>false,"message"=> $message)); die;
        }
        else
        {
            $user_id = $query['uid'];

            $token = $this->Jwt_client->encode( array( "password" => $password,"id" => $user_id ) );
            $created_on = date("Y-m-d h:i:s");
            // $query['token']=$token;
            $update_arr = array();
            $update_arr['source'] = $source;
            $update_arr['token'] = $token;
            $update_arr['last_login'] = $created_on;
            if(!empty($fcm_no)) $update_arr['fcm_no'] = $fcm_no;
            $query['logo'] = $this->check_login->get_driver_path($query['logo']);

            unset($query['uid']);
            unset($query['active']);
            $this->db_model->my_update($update_arr,array("id" => $user_id),"admin_users");

            $message = 'Login Successfully';
            echo json_encode( array("status" => true ,"token" => $token ,"data" => $query ,"message" => $message ) );die;

        }
    }

    public function driver_order_listing()
    {
        $jsonobj = $this->request->getJSON();
        // $jsonobj = '{"pagination":"1"}';
        $pagination = @$jsonobj->pagination;
        $user_id = $this->check_login->validate_token();

        if (!empty($user_id) && !empty($pagination))
        {

            if(empty($pagination)) $pagination = 1;
            $limit = 10;
            $pagination = $limit * ( $pagination - 1);

            $data = $this->db_model->get_data_array("SELECT order_master_id,order_datetime,address,landmark,name as customer_name,order_status FROM order_master WHERE `order_status` != 'canceled' AND `order_status` != 'delivered' AND `order_status` != 'Pending' ORDER BY order_master_id DESC LIMIT $pagination,$limit ");
            if (!empty($data)) 
            {
                foreach ($data as $key => $value) 
                {
                    $order_no = $value['order_master_id'];
                    
                    $item_count = $this->db_model->get_data_array("SELECT item_id FROM order_items WHERE `order_no` = '$order_no' ");

                    $item = $this->db_model->get_data_array("SELECT product_name,quantity,extra_added FROM order_items WHERE `order_no` = '$order_no' ORDER BY item_id DESC LIMIT 1 ");
                    if ($item) {
                        foreach ($item as $qkey => $ivalue) {
                            $added = explode(",--", $ivalue['extra_added']);
                            if ($added) {
                                $asd = array();
                                foreach ($added as $skey => $wvalue) {
                                    if ($wvalue) {
                                        $asd[] = $wvalue;
                                    }
                                    $item[$qkey]['extra'] = $asd;
                                    unset($item[$qkey]['extra_added']);
                                }
                            }
                        }
                    }


                    $o_date = $value['order_datetime'];
                    $date = date('j F Y, g:i a', strtotime($o_date));
                    $data[$key]['order_datetime'] = $date;
                    $data[$key]['item'] = $item[0];
                    $data[$key]['item_count'] = "Total ".count($item_count)." Items";
                }
            }
            echo json_encode( array("status" => true,"data" => $data  ,"message" => "Successfully." ) );die;
        }

        echo json_encode( array("status" => false ,"message" => "Invalid request." ) );die;
    }

    public function driver_order_detail()
    {
        $jsonobj = $this->request->getJSON();
        // $jsonobj = '{"order_id":"1"}';
        $order_id = @$jsonobj->order_id;
        $user_id = $this->check_login->validate_token();

        if (!empty($user_id) && !empty($order_id))
        {
            $image_base_url = base_url().'/public/admin/products/';
            $data = $this->db_model->get_data_array("
                        SELECT 
                            om.order_master_id, 
                            om.name AS customer_name, 
                            om.mobile_no AS customer_number, 
                            om.email AS customer_email, 
                            om.order_status, 
                            om.shipping_charge, 
                            om.sub_total, 
                            om.tax, 
                            om.net_total, 
                            om.order_datetime, 
                            om.address, 
                            om.landmark, 
                            om.address_lat, 
                            om.address_lng, 
                            om.city, 
                            om.area, 
                            om.payment_mode, 
                            om.payment_status, 
                            om.tip_amount, 
                            om.delivery_note, 
                            om.voucher_code, 
                            om.voucher_amount,
                            oi.quantity, 
                            oi.price, 
                            oi.sub_total AS item_sub_total, 
                            oi.attribute, 
                            oi.extra_added,
                            p.product_name, 
                            CONCAT('$image_base_url', p.product_image) AS product_image_url
                        FROM order_master AS om
                        LEFT JOIN order_items AS oi ON om.order_master_id = oi.order_no
                        LEFT JOIN product AS p ON oi.product_id = p.id
                        WHERE om.order_master_id = '$order_id'
                    ");

            if (!empty($data)) {
                foreach ($data as $key => &$value) {
                    // Format the order date and update order status and payment mode
                    $value['order_datetime'] = date('j F Y, g:i a', strtotime($value['order_datetime']));
                    $value['order_status'] = ($value['order_status'] == 'delivered') ? 'Delivered' : $value['order_status'];
                    $value['payment_mode'] = ($value['payment_mode'] == 'cash-on-del') ? 'Cash' : $value['payment_mode'];

                    // Process extra added items if any
                    $extraItems = explode(",--", $value['extra_added']);
                    $value['extra'] = array_filter($extraItems);  // Filter empty values
                }
                echo json_encode(array("status" => true, "data" => $data, "message" => "Successfully."));
                die;
            }

        }

        echo json_encode( array("status" => false ,"message" => "Invalid request." ) );die;
    }

    public function driver_order_verify_delivered()
    {
        $jsonobj = $this->request->getJSON();
        // $jsonobj = '{"order_id":"1"}';
        $order_id = @$jsonobj->order_id;
        $pcode = @$jsonobj->pickup_code;
        $user_id = $this->check_login->validate_token();

        if (!empty($user_id) && !empty($order_id))
        {
            $image_base_url = base_url().'/public/admin/products/';
            $data = $this->db_model->get_data_array("
                        SELECT 
                            om.order_master_id, 
                            om.name AS customer_name, 
                            om.mobile_no AS customer_number, 
                            om.email AS customer_email, 
                            om.order_status, 
                            om.pickup_code, 
                            oi.sub_total AS item_sub_total, 
                            oi.attribute, 
                            oi.extra_added,
                            p.product_name, 
                            CONCAT('$image_base_url', p.product_image) AS product_image_url
                        FROM order_master AS om
                        LEFT JOIN order_items AS oi ON om.order_master_id = oi.order_no
                        LEFT JOIN product AS p ON oi.product_id = p.id
                        WHERE om.order_master_id = '$order_id'
                    ");

            if (!empty($data)) {
                
                $order_master_id = $data[0]['order_master_id'];
                $order_status = $data[0]['order_status'];
                $pickup_code = $data[0]['pickup_code'];

                if ($order_status == 'delivered') {
                    echo json_encode( array("status" => false ,"message" => "Order is already delivered" ) );die;
                }
                elseif ($order_status == 'canceled') {
                    echo json_encode( array("status" => false ,"message" => "Order is already canceled" ) );die;
                }
                
                if ($pcode != $pickup_code) {
                    echo json_encode( array("status" => false ,"pickup_code" => $pickup_code ,"message" => "Entered pickup is invalid" ) );die;
                }

                $order_s_array['payment_status'] = "Paid";
                $order_s_array['driver_id'] = $user_id;
                $order_s_array['delivered_date_time'] = date("Y-m-d H:i:s");
                $order_s_array['order_status'] = 'delivered';
                $this->db_model->my_update($order_s_array,array("order_master_id" => $order_master_id),"order_master");
                echo json_encode(array("status" => true, "message" => "Order delivered successfully."));
                die;
            }
        }

        echo json_encode( array("status" => false ,"message" => "Invalid request." ) );die;
    }
}
