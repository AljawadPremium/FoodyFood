<?php

namespace App\Libraries;
use App\Libraries\JwtClient;
use App\Models\DbModel;
use \DateTime; 
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\I18n\Time;
use App\Libraries\CommonFun;
use App\Libraries\User_account;
use App\Libraries\Email_send;

require_once 'vendor/autoload.php'; 
use Twilio\Rest\Client;


class Check_login
{
    protected $request;
    protected $email_send;
    protected $user_account;
    protected $Jwt_client;
    protected $comf;
    protected $db_model;
    protected $token_id;
    protected $session ='';

    function __construct()
    {
        $this->email_send   = new Email_send();
        $this->user_account = new User_account();
        $this->Jwt_client   = new JwtClient();
        $this->comf         = new CommonFun();
        $this->token_id     = "s56by73212343289fdsfitdsdne";
        $this->request      = \Config\Services::request();
        $this->db_model     = new DbModel();
        $this->session      = \Config\Services::session();
    }

    public function validate_token($language = 'en',$ws='')
    {
        $uid = 0;
        $token = $this->getBearerToken();
        if(empty($token))
        {
            echo json_encode( array("status" => false,"message" => ($language == 'ar'? "مصادقة غير صالحة.":'Invalid authentication.' ),  "language"=> $language , "ws" => $ws ) );die;
        }
        $token = $this->Jwt_client->decode($token);

        if($token){
            if(@$token['api_key'] != $this->token_id ){
                $uid = $this->check_user_login($language,$ws);
            }
        }else{
            $uid = $this->check_user_login($language,$ws);
        }
        return $uid;
    }

    public function check_user_login($language = 'en',$ws='')
    {
        $token1 = $this->getBearerToken();
        if(empty($token1))
        {
            echo json_encode( array("status" => false,"message" => ($language == 'ar'? "مصادقة غير صالحة.":'Invalid authentication.' ),  "language"=> $language , "ws" => $ws ) );die;
        }
        $token = $this->Jwt_client->decode($token1);
        if($token)
        {
            $aData = array();
            $id = @$token['id'];
            $password = @$token['password'];
            $logged_in = $this->db_model->my_where('admin_users','id,first_name,phone,email,logo,token,password,',array('id'=>$id),array(),"","","","", array(), "",array(),false );
            if (!empty($logged_in))
            {
                if(password_verify ( $password ,$logged_in[0]['password'] ))
                {
                    if ($logged_in[0]['token'] == $token1) {
                        return $id;
                    }
                }
                elseif ($password == $logged_in[0]['password'] )
                {
                    if ($logged_in[0]['token'] == $token1) {
                        return $id;
                    }
                }
            }
        }
        echo json_encode( array("status" => false,"message" => ($language == 'ar'? "مصادقة غير صالحة.":'Invalid authentication.' ),  "language"=> $language , "ws" => $ws ) );die;
    }

    /** 
     * Get hearder Authorization
     * */

    function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Token'])) {
            $headers = trim($_SERVER["Token"]);
        }
            else if (isset($_SERVER['HTTP_TOKEN'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["HTTP_TOKEN"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                if (isset($requestHeaders['Token'])) {
                    $headers = trim($requestHeaders['Token']);
                }
            }
            return $headers;
        }


    /**
     * get access token from header
     * */
    function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return trim($matches[1]);
            }
        }
        return null;
    }

    public function get_driver_path($image)
    {
        $str = base_url().'public/driver/empty.png';
        if (!empty($image)){
            $str = base_url().'public/driver/'.$image;
        }
        return $str;
    }

    public function get_user_path($image)
    {
        if (empty($image))
        {
            $str = base_url().'public/frontend/user/empty.png';
            return $str;
        }

        if (!empty($image))
        {
            $str = base_url().'public/frontend/user/'.$image;
            return $str;
        }
    }

    public function get_product_path($image)
    {
        if (empty($image))
        {
            $str = base_url().'public/admin/products/empty.png';
            return $str;
        }

        if (!empty($image))
        {
            $str = base_url().'public/admin/products/'.$image;
            return $str;
        }
    }

    public function get_banner_path($image = '')
    {
        if (!empty($image)) {
            $str = base_url().'public/admin/banner/'.$image;
            return $str;
        }
    }

    public function get_category_image($image = '')
    {
        if (!empty($image))
        {
            $str = base_url().'public/admin/category/'.$image;
            return $str;
        }
        else
        {
            $str = base_url().'public/admin/images/logo.png';
            return $str;
        }
    }

    public function get_shop_image($image = '')
    {
        if (!empty($image))
        {
            $str = base_url().'public/admin/shop/'.$image;
            return $str;
        }
        else
        {
            $str = base_url().'public/admin/images/logo.png';
            return $str;
        }
    }

    public function most_browsed_products($user_id = '')
    {
        $r_pid = $top_p =  $get_d = '';
        if (empty($user_id)) {
            return $get_d;
        }
        else
        {
            $top_selled = $this->db_model->get_data_array("SELECT id,view_count FROM `product` ORDER BY view_count DESC limit 100 ");
            $column = 'id';
            if ($top_selled) {
                $top_p = implode(',', array_map(function($n) use ($column) {return $n[$column];}, $top_selled));
            }

            $recent_view = $this->db_model->get_data_array("SELECT * FROM recent_view_product where `user_id` = '$user_id'  ");

                // echo "<pre>";
                // print_r($recent_view);
                // die;

            if ($recent_view) 
            {
                $r_pid = $recent_view[0]['pid'];
            } 

            if (!empty($top_p) && !empty($r_pid)) 
            {
                $top = explode (",", $top_p); 
                $r_pid = explode (",", $r_pid);
                $duplicates =  array_merge($top,$r_pid);
                $get_d = array_diff_assoc($duplicates, array_unique($duplicates));
            }

            return $get_d;

        }
    }

    public function view_cart_count($user_id= '')
    {
        $session = session();
        $cart = $this->db_model->my_where('my_cart','content',array('user_id'=>$user_id,'meta_key' => 'cart'));
        if(!empty($cart)) $content = $cart[0]['content'];

        if (empty($user_id)) {
            $content = $session->get('content');
        }

        $cart_qty = 0;
        if ($content)
        {
            $content=unserialize($content);
            foreach ($content as $unkey => $unvalue)
            {
                $cart_qty += $unvalue['qty'];
            }
        }
        return $cart_qty;
    }

    function get_distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $rad = M_PI / 180;
            //Calculate distance from latitude and longitude
        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin($latitudeFrom * $rad) 
                * sin($latitudeTo * $rad) +  cos($latitudeFrom * $rad)
                * cos($latitudeTo * $rad) * cos($theta * $rad);

        return round(acos($dist) / $rad * 60 *  1.853,2);
    }

    public function get_all_product_data($product_listing='',$user_id='',$language='')
    {
        $language = get_cookie('lang');

        if (!empty($product_listing))
        {
            foreach ($product_listing as $dkey => $dvalue)
            {
                $pid = $dvalue['id'];
                $p_data = $this->db_model->get_data_array("SELECT product_name_ku,product_name_ar,price_select,shop_id,short_description_ar,description_ar FROM product WHERE `id` = '$pid' "); 
                
                if($language == 'ar'){
                    $product_listing[$dkey]['product_name'] = $p_data[0]['product_name_ar'];
                    $product_listing[$dkey]['short_description'] = $p_data[0]['short_description_ar'];
                    $product_listing[$dkey]['description'] = $p_data[0]['description_ar'];
                }

                $shop_id = $p_data[0]['shop_id'];
                $shop_name = $distance = '';
                $shop_details = $this->db_model->get_data_array("SELECT first_name as display_name,latitude,longitude FROM admin_users WHERE `id` = '$shop_id'");
                if ($shop_details) {
                    $shop_name = $shop_details[0]['display_name'];
                    $shop_lat = $shop_details[0]['latitude'];
                    $shop_lng = $shop_details[0]['longitude'];
                }
                $product_listing[$dkey]['shop_name'] = $shop_name;

                $user_details = $this->db_model->get_data_array("SELECT latitude,longitude FROM admin_users WHERE `id` = '$user_id'");
                if ($user_details) {
                    $lat = $user_details[0]['latitude'];
                    $lng = $user_details[0]['longitude'];

                    if (!empty($lat) && !empty($lng) && !empty($shop_lat) && !empty($shop_lng)) {
                        $distance = $this->get_distance($lat,$lng,$shop_lat,$shop_lng);
                    }
                }
                $product_listing[$dkey]['distance'] = $distance;

                $product_listing[$dkey]['type'] = @$p_data[0]['price_select'];

                if (!empty($dvalue['image_gallery'])) 
                {
                    $image_gallery = $dvalue['image_gallery'];
                    $aimage_gallery = explode(",", $image_gallery); 
                    $aimage_gallery = array_filter($aimage_gallery);

                    if ($aimage_gallery) {
                        foreach ($aimage_gallery as $gkey => $gvalue) {
                            $gallery_image[] = $this->get_product_path($gvalue);
                        }

                        if (@$gkey) {
                            $gallery_image[$gkey+1] = $this->get_product_path($dvalue['product_image']);
                        }
                    }
                    else {
                        $gallery_image[] =  $this->get_product_path($dvalue['product_image']);   
                    }

                    $product_listing[$dkey]['image_gallery'] = $gallery_image;
                }
                else {
                    $product_listing[$dkey]['image_gallery'] = array();
                }            

                $m_price = $dvalue['price'];
                $ms_price = $dvalue['sale_price'];
                if (substr($dvalue['sale_price'], -3) === '.00') {
                    $m_price = substr($dvalue['price'], 0, -3);
                }
                if (substr($dvalue['sale_price'], -3) === '.00') {
                    $ms_price = substr($dvalue['sale_price'], 0, -3);
                }

                $product_listing[$dkey]['price'] = $m_price;
                $product_listing[$dkey]['sale_price'] = $ms_price;

                $product_offer = array();
                if($dvalue['price_select'] == 3)
                {
                    $return_p_count = $this->get_count($pid ,$user_id);
                    $pack_of = '1';
                    $type_qty_piece_name = 'Pack';
                    $product_listing[$dkey]['qty_label'] = $return_p_count * $pack_of.' '.$type_qty_piece_name;

                    $product_offer = $this->db_model->get_data_array("SELECT quantity,rate FROM product_offer WHERE `product_id` = '$pid'");
                    $count = count($product_offer);

                    if ($product_offer) 
                    {
                        foreach ($product_offer as $vkey => $ovalue) 
                        {
                            $quantity = $ovalue['quantity'];
                            $qty = $pack_of * $ovalue['quantity'];
                            $rate = $ovalue['rate']/$pack_of;
                            $rate = $ovalue['rate'];

                            $title = "Buy $qty $type_qty_piece_name or more at ₹$rate/$type_qty_piece_name";
                            $product_offer[$vkey]['title'] = $title;

                            if ($count == ($vkey + 1)) 
                            {
                                $asd = '100000';
                            }
                            else
                            {
                                $asd = $product_offer[$vkey + 1]['quantity'] - 1;
                            }

                            if ( in_array($return_p_count, range($quantity,$asd)) ) 
                            {
                                $offer_price            = $ovalue['rate'];
                                $offer_sale_price       = $ovalue['rate'];

                                $product_listing[$dkey]['price'] = $offer_price;
                                $product_listing[$dkey]['sale_price']  = $offer_sale_price;

                                $product_offer[$vkey]['status'] = "activee";
                                $product_listing[$dkey]['price_label'] = number_format($return_p_count * $offer_sale_price);
                            }
                            else
                            {
                                $product_offer[$vkey]['status'] = "deactive";
                            }

                            // unset($product_offer[$okey]['quantity']);
                            // unset($product_offer[$okey]['rate']);
                        }
                    }
                }

                $product_listing[$dkey]['offer'] = $product_offer;


                $product_listing[$dkey]['size'] = '';
                $price = $dvalue['price'];
                $product_attrs = $this->db_model->get_data_array("SELECT `item_id`,`price`,`sale_price`,`id` FROM product_attribute WHERE `p_id` = '$pid'");
                if(!empty($product_attrs))
                {
                    $product_listing[$dkey]['meta_data'] = $product_attrs;
                    foreach ($product_listing[$dkey]['meta_data'] as $key2 => $meta_data) 
                    {
                        if ($key2 == 0) {

                            $a_price = (string)$meta_data['price'];
                            $a_sale_price = (string)$meta_data['sale_price'];

                            // Check if the string ends with '.00' and remove it
                            if (substr($a_price, -3) === '.00') {
                                $a_price = substr($a_price, 0, -3);
                            }
                            // Check if the string ends with '.00' and remove it
                            if (substr($a_sale_price, -3) === '.00') {
                                $a_sale_price = substr($a_sale_price, 0, -3);
                            }

                            $product_listing[$dkey]['price']        = $a_price;
                            $product_listing[$dkey]['sale_price']   = $a_sale_price;
                            // $product_listing[$dkey]['our_price']   = $a_sale_price;
                            // $product_listing[$dkey]['market_price']   = $a_price;
                        }
                        
                        $item_id = $meta_data['item_id'];
                        $attribute_item = $this->db_model->get_data_array("SELECT `item_name` FROM attribute_item WHERE `id` = '$item_id'");
                        $product_listing[$dkey]['meta_data'][$key2]['size'] = $attribute_item[0]['item_name'];
                            // unset($product_listing[$dkey]['meta_data'][$key2]['item_id']);

                        $get_count_m = $this->get_count($pid ,$user_id,$attribute_item[0]['item_name']);
                        $get_extra_m = $this->get_count($pid ,$user_id,$attribute_item[0]['item_name']);
                        $product_listing[$dkey]['meta_data'][$key2]['count_add'] = $get_count_m;

                        if (!empty($get_count_m)) {
                            $product_listing[$dkey]['size'] = $attribute_item[0]['item_name'];
                        }

                        $product_listing[$dkey]['meta_data'][$key2]['remove_key'] = 'm'.$pid.'m'.$item_id;
                        $product_listing[$dkey]['remove_key'] = "";
                        
                        if (!empty($get_extra_m)) {
                            // $product_listing[$dkey]['get_extra'] = $get_extra_m;

                            $e_sum = 0;
                            $comment = $get_extra_m;
                            $extra_m = $this->db_model->my_where('product_custimze_details','id,name,price',array('pid' => $pid));
                            if ($extra_m)
                            {
                                if (!empty($comment)) {
                                    foreach ($extra_m as $rkey => $rvalue)
                                    {
                                        $e_id = $rvalue['id'];
                                        $e_price = $rvalue['price'];
                                        if ($this->checkNumberInString($e_id, $comment))
                                        {
                                            $e_sum+= $e_price;
                                            $extra_m[$rkey]['is_added'] = 'yes';
                                        } else {
                                            $extra_m[$rkey]['is_added'] = 'no';
                                        }
                                    }
                                }
                            }
                            $product_listing[$dkey]['extra_list']   = $extra_m;
                            // $product_listing[$dkey]['extra_sum']    = $e_sum;

                        }
                    }
                }
                else{
                    $product_listing[$dkey]['meta_data']  = array();
                }

                $rating = $this->rating($pid);
                $product_listing[$dkey]['avg_rating'] = $rating['rating'];
                $product_listing[$dkey]['user_count'] = $rating['user_count'];
                $product_listing[$dkey]['user_rating_count'] = $rating['user_count'];

                $product_listing[$dkey]['product_image'] = $this->get_product_path($dvalue['product_image']);

                $is_in_wish_list    = $this->is_in_wish_list($pid ,$user_id);
                $get_count          = $this->get_count($pid ,$user_id);
                $get_extra          = $this->get_extra($pid ,$user_id);
                
                $product_listing[$dkey]['add_label'] = "Add to cart";
                if ($get_count > 0){
                    $product_listing[$dkey]['add_label'] = "Added";
                }

                $extra_sum = 0;
                $comment = $get_extra;
                $extra = $this->db_model->my_where('product_custimze_details','id,name,price',array('pid' => $pid));
                if ($extra)
                {
                    if (!empty($comment)) {
                        foreach ($extra as $rkey => $rvalue)
                        {
                            $e_id = $rvalue['id'];
                            $e_price = $rvalue['price'];
                            if ($this->checkNumberInString($e_id, $comment))
                            {
                                $extra_sum+= $e_price;
                                $extra[$rkey]['is_added'] = 'yes';
                            } else {
                                $extra[$rkey]['is_added'] = 'no';
                            }
                        }
                    }
                }
                // $product_listing[$dkey]['get_extra']            = $get_extra;
                $product_listing[$dkey]['extra_list']           = $extra;
                // $product_listing[$dkey]['extra_sum']            = $extra_sum;

                // $remove_key_genrate = $this->check_login->remove_key_genrate($pid ,$user_id);
                $main_category_name  = $this->get_category_name(@$dvalue['category']);
                $product_listing[$dkey]['category_name'] = $main_category_name;


                $product_listing[$dkey]['is_in_wish_list']      = $is_in_wish_list;
                $product_listing[$dkey]['count_add']            = $get_count;
                // $product_listing[$dkey]['remove_key_genrate']    = $remove_key_genrate;
            }
        }

        return $product_listing;
    }

    public function get_category_name($cid = '')
    {
        $c_name = '';
        if(!empty($cid))
        {
            $category = $this->db_model->my_where('category','id,display_name',array('id'=>$cid));
            if(!empty($category))
            {
                $c_name = $category[0]['display_name'];
            }
        }

        return $c_name;
    }

    public function is_in_wish_list( $p_id, $user_id)
    {
        $wish_arr = $this->db_model->my_where('wishlist','id',array('user_id' => $user_id,'product_id' => $p_id));
        if(!empty($wish_arr)) $my_wish = true ;
        $data = !empty($my_wish) ? true:false;
        return $data;
    }

    public function rating($pid)
    {
        $user_review = $this->db_model->my_where("user_rating","uid,pid,name,rating,title,created_date,comment",array('pid' => $pid, 'status' => 'accept') );
        if (!empty($user_review))
        {
            $avg = 0;
            foreach ($user_review as $dkey => $svalue)
            {
                $avg += $svalue['rating'];
            }
            $response['rating'] = round($avg/count($user_review));
            $response['user_count'] = count($user_review);
            $response['user_review'] = $user_review;
            return $response;
        }
        else
        {
            $response['rating']         = 0 ; 
            $response['user_count']     = 0 ;
            $response['user_review']    = array() ;
            return $response;
        }
    }

    function find_key_value($array, $key, $val)
    {
        if ($array) 
        {
            foreach ($array as $item)
            {
                if (is_array($item) && $this->find_key_value($item, $key, $val)) return $item['quantity'];

                if (isset($item[$key]) && $item[$key] == $val) return $item['quantity'];
            }
        }

        return 0;
    }

    public function get_count($pid = '',$user_id = '',$size= '')
    {
        $session = session();
        $cart_qty = 0;


        if (empty($user_id)) 
        {
            $con = $session->get('content');
            if ($con) {
                $content = unserialize($con);
            }
        }else{
            $cart = $this->db_model->my_where('my_cart','content',array('user_id'=>$user_id,'meta_key' => 'cart'));
            if(!empty($cart)) $content = unserialize($cart[0]['content']);
        }

        if (!empty($content)) 
        {
            foreach ($content as $key => $value)
            {
                        // echo"<pre>";
                        // print_r($value);
                        // die;

                $added_pid = $value['pid'];

                if ($pid == $added_pid) 
                {
                    if(!empty($value['metadata']))
                    {
                        if ($value['metadata']['size'] == $size) 
                        {
                            $cart_qty = $value['qty'];
                        }
                    }
                    else
                    {
                        $cart_qty = $value['qty'];
                    }
                }

            }
        }

        return $cart_qty;
    }
    public function get_extra($pid = '',$user_id = '',$size= '')
    {
        $session = session();
        $cart_qty = 0;

        if (empty($user_id)) 
        {
            $con = $session->get('content');
            if ($con) {
                $content = unserialize($con);
            }
        }
        else{
            $cart = $this->db_model->my_where('my_cart','content',array('user_id'=>$user_id,'meta_key' => 'cart'));
            if(!empty($cart)) $content = unserialize($cart[0]['content']);
        }

        if (!empty($content)) 
        {
            foreach ($content as $key => $value)
            {
                        // echo"<pre>";
                        // print_r($value);
                        // die;

                $added_pid = $value['pid'];

                if ($pid == $added_pid) 
                {
                    if(!empty($value['metadata']))
                    {
                        if ($value['metadata']['size'] == $size) 
                        {
                            $cart_qty = $value['comment'];
                        }
                    }
                    else
                    {
                        $cart_qty = $value['comment'];
                    }
                }

            }
        }

        return $cart_qty;
    }

    public function all_products($user_id='',$language='')
    {
        $category_listing = $this->db_model->get_data_array("SELECT id,display_name,display_name_ar,display_name_ku FROM category where `status` = 'active' AND `parent` = '0'  AND `has_product` = '1'  order by RAND() ASC LIMIT 3 "); 
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
                $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category FROM product where  `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1'  AND ( `category` = '$cat' ) ORDER BY id DESC LIMIT 10 ");                
                $product_l_array = $this->get_all_product_data($product_listing,$user_id);
                $category_listing[$vkey]['product_list'] = $product_l_array;
            }
        }
        return $category_listing;
    }

    function checkNumberInString($number, $commaSeparatedString) {
        // Split the string into an array
        $numbersArray = explode(',', $commaSeparatedString);

        // Trim whitespace from each element in the array (optional, in case there are spaces)
        $numbersArray = array_map('trim', $numbersArray);

        // Check if the number exists in the array
        return in_array($number, $numbersArray);
    }

    public function remove_from_cart($send_data='')
    {
        // echo "<pre>";
        // print_r($send_data);
        // die;

        $pid = $send_data['pid'];
        $uid = $send_data['uid'];

        $response = $this->user_account->add_remove_cart($pid,$uid,'remove');
        if ($response)
        {
            // echo "<pre>";
            // print_r($response);
            // die;

            if ($response != '-1')
            {
                if (isset($response['cart_qty']))
                {
                    $cart_qty = $response['cart_qty'];
                    // $this->session->set_userdata('cart_qty', $response['cart_qty']);
                    unset($response['cart_qty']);
                }

                $this->session->set_userdata('content', serialize($response));
            }
        }
    }

    public function add_to_wish_list_from_view_cart($send_data = '')
    {
        $pid = $send_data['pid'];
        $uid = $send_data['uid'];

        /*Add code*/

        $my_wish = array();
        if (empty($my_wish))
        {
            $my_wish[] = $pid;
        }
        elseif (!in_array($pid, $my_wish))
        {
            $my_wish[] = $pid;
        }
        elseif ($is_wish == '1')
        {
            $my_wish = array_diff($my_wish, array($pid));
        }

        if (!empty($uid))
        {
            $is_data = $this->db_model->my_where('my_cart','*',array('user_id' => $uid,'meta_key' => 'wish_list'));

            if (!empty($is_data)) {
                $this->db_model->my_update(array('content' => serialize($my_wish)),array('id' => $is_data[0]['id'],'meta_key' => 'wish_list'),'my_cart',true,true);
            }
            else{
                $data['user_id'] = $uid;
                $data['meta_key'] = 'wish_list';
                $data['content'] = serialize($my_wish);
                $this->db_model->my_insert($data,'my_cart');
            }
        }
    }

    public function online_payment_fail_then_order_cancel($post_data='')
    {
        $ws = 'o_cancel';
        $language = 'en';
        $oid = $post_data['oid'];
        $reason = $post_data['reason'];
        $uid = $post_data['uid'];
        $cron = @$post_data['cron'];

        $data = $this->db_model->get_data_array("SELECT * FROM `order_master` WHERE `user_id` = '$uid' AND `order_master_id` = '$oid' ");
        if(!empty($data))
        {
            $wallet_amount = $data[0]['wallet_amount'];
            $account_minus = $data[0]['account_minus'];
            $account_minus_reason = $data[0]['account_minus_reason'];
            $order_status = $data[0]['order_status'];
            if ($order_status == 'Packed') {
                echo json_encode( array("status" => false,"ws" => $ws ,"message" =>  ($language == 'ar'? '':'The order has already been Packed by admin so you cant calcelled order') ) );die;   
            }
            elseif ($order_status == 'Ready to ship') {
                echo json_encode( array("status" => false,"ws" => $ws ,"message" =>  ($language == 'ar'? '':'The order has already been ready to ship so you cant calcelled order') ) );die;   
            }
            else if ($order_status == 'canceled') 
            {
                echo json_encode( array("status" => false,"ws" => $ws ,"message" =>  ($language == 'ar'? '':'The order has already been canceled') ) );die; 
            }
            if ($order_status == 'delivered') 
            {
                echo json_encode( array("status" => false,"ws" => $ws ,"message" =>  ($language == 'ar'? '':'The order has been delivered so cannot be canceled') ) );die; 
            }
            if ($order_status == 'dispatched') 
            {
                echo json_encode( array("status" => false,"ws" => $ws ,"message" =>  ($language == 'ar'? '':'The order has been dispatched so cannot be canceled') ) );die; 
            }
            if ($order_status == 'Pending') 
            {
                if (!empty($account_minus)) 
                {
                    $u_data = $this->db_model->get_data_array("SELECT * FROM `admin_users` WHERE `id` = '$uid' ");
                    if (empty($u_data)) 
                    {
                        echo json_encode( array("status" => true,"ws" => $ws,"message" =>  ($language == 'ar'? '':'Invalid request') ) );die;
                    }

                    $added_w_amt = $u_data[0]['wallet_amount'];
                    $added_w_reason = $u_data[0]['wallet_amt_reason'];

                    $p_data['wallet_amount'] = $added_w_amt - $account_minus;
                    if ($added_w_reason) 
                    {
                        $p_data['wallet_amt_reason'] = $added_w_reason.' AND '.$account_minus_reason;
                    }
                    else
                    {
                        $p_data['wallet_amt_reason'] = $account_minus_reason;
                    }
                    $this->db_model->my_update($p_data,array("id" => $uid),"admin_users");
                }
                else if (!empty($wallet_amount)) 
                {
                    $u_data = $this->db_model->get_data_array("SELECT * FROM `admin_users` WHERE `id` = '$uid' ");
                    if (empty($u_data)) 
                    {
                        echo json_encode( array("status" => true,"ws" => $ws,"message" =>  ($language == 'ar'? '':'Invalid request') ) );die;
                    }

                    $added_w_amt = $u_data[0]['wallet_amount'];
                    $p_data['wallet_amount'] = $added_w_amt + $wallet_amount;
                    $this->db_model->my_update($p_data,array("id" => $uid),"admin_users");
                }

                if (!empty($cron)) {
                    $additional_data['online_unpaid_check'] = '';
                }

                $additional_data['order_cancel_reason'] = $reason;
                $additional_data['order_status'] = 'canceled';
                    // $additional_data['order_comment'] = 'The order has been canceled successfully and the order cancel timing is '.date("Y-m-d H:i:s");
                $additional_data['order_cancel_date_time'] = date("Y-m-d H:i:s");
                $result = $this->db_model->my_update($additional_data,array("order_master_id" => $oid),"order_master");

                $this->re_add_product_on_cancel_order($oid);

                echo json_encode( array("status" => true,"ws" => $ws ,"message" => ($language == 'ar'? 'تم إلغاء الطلب بنجاح':'The order has been canceled successfully')));die;
            }  
        }

        echo json_encode( array("status" => true,"ws" => $ws,"message" => ($language == 'ar'? '':'No order found') ) );die;
    }

    public function admin_order_cancel($post_data='')
    {
        $oid = $post_data['oid'];

        $data = $this->db_model->get_data_array("SELECT * FROM `order_master` WHERE `order_master_id` = '$oid' ");
        if(!empty($data))
        {
            $uid = $data[0]['user_id'];
            $order_status = $data[0]['order_status'];
            $display_order_id = $data[0]['display_order_id'];

                // if ($order_status == 'Packed') {
                //     echo json_encode( array("status" => false ,"message" =>  ($language == 'ar'? '':'The order has already been Packed by admin so you cant calcelled order') ) );die;   
                // }
                // elseif ($order_status == 'Ready to ship') {
                //     echo json_encode( array("status" => false ,"message" =>  ($language == 'ar'? '':'The order has already been ready to ship so you cant calcelled order') ) );die;   
                // }
            if ($order_status == 'canceled') 
            {
                echo json_encode( array("status" => false ,"message" =>"The order has already been canceled") );die; 
            }
            if ($order_status == 'delivered' ) 
            {
                echo json_encode( array("status" => false ,"message" => "The order has been delivered so cannot be canceled" ) );die; 
            }
                // if ($order_status == 'dispatched') 
                // {
                //     echo json_encode( array("status" => false ,"message" =>  ($language == 'ar'? '':'The order has been dispatched so cannot be canceled') ) );die; 
                // }

            $additional_data['order_status'] = 'canceled';
                // $additional_data['order_comment'] = 'The order has been canceled successfully and the order cancel timing is '.date("Y-m-d H:i:s");
            $additional_data['order_cancel_date_time'] = date("Y-m-d H:i:s");
            $result = $this->db_model->my_update($additional_data,array("order_master_id" => $oid),"order_master");

            $send_data['order_status'] = 'canceled';
            $send_data['display_order_id'] = $display_order_id;
            $send_data['user_id'] = $uid;

            $this->email_send->order_email_fire($send_data);
            $this->re_add_product_on_cancel_order($oid);

            echo json_encode( array("status" => true ,"message" => "The order has been canceled successfully"));die;
        }

        echo json_encode( array("status" => false,"message" => "No order found" ) );die;
    }

    public function re_add_product_on_cancel_order($oid='')
    {
        $data = $this->db_model->get_data_array("SELECT * FROM `order_items` WHERE `order_no` = '$oid' ");
        if ($data) 
        {
            foreach ($data as $key => $value) 
            {
                $product_id = $value['product_id'];
                $new_qty = $value['quantity'];

                $check = $this->db_model->get_data_array("SELECT * FROM `product` WHERE `id` = '$product_id' ");
                if (!empty($check)) 
                {
                    $old_qty = $check[0]['stock'];

                    $update['stock'] = $old_qty + $new_qty;
                    if ($update['stock'] == 0 || $update['stock'] < 0)
                    {
                        $update['stock_status'] = 'notinstock';
                        $update['stock']        = '0';
                    }
                    else
                    {
                        $update['stock_status'] = 'instock';
                    }

                    $this->db_model->my_update($update,array('id' => $product_id), 'product');
                }
            }
        }
    }

    public function get_time_slot()
    {
        $today_day_name = date ('l');

        $check = $this->db_model->get_data_array("SELECT * FROM `delivery_slot` WHERE `day` = '$today_day_name' ");
        if ($check) 
        {
            foreach ($check as $key => $value) 
            {
                $day_id = $value['id'];
                $data = $this->db_model->get_data_array("SELECT start_time,end_time FROM `delivery_slot_time` WHERE `delivery_slot_id` = '$day_id' AND `status` = 'active' ORDER BY `start_time` ASC ");
                if (!empty($data)) 
                {
                    foreach ($data as $dkey => $dvalue) 
                    {
                        $current_time = date ('H:i');
                        $start_time = $dvalue['start_time'];

                        $data[$dkey]['status'] = "active";
                        if ($current_time >= $start_time) {
                            $data[$dkey]['status'] = "deactive";
                        }
                    }
                }
                $check[$key]['date']   = date("Y-m-d");
                $check[$key]['day'] = ucfirst($value['day']);
                $check[$key]['slots'] = $data;
            }
        }

        $tomorrow = date('l', strtotime("+1 day"));
        $day_after_tomorrow = date('l', strtotime("+2 day"));

        $check_next = $this->db_model->get_data_array("SELECT * FROM `delivery_slot` WHERE `day` = '$tomorrow' OR `day` = '$day_after_tomorrow' ");
        $check_next = $this->db_model->get_data_array("SELECT * FROM `delivery_slot` WHERE `day` = '$tomorrow' ");
        if ($check_next) 
        {
            foreach ($check_next as $key => $value) 
            {
                $day_id = $value['id'];
                $tomorrow = date("Y-m-d", strtotime('tomorrow'));

                $data = $this->db_model->get_data_array("SELECT start_time,end_time,status FROM `delivery_slot_time` WHERE `delivery_slot_id` = '$day_id' AND `status` = 'active' ORDER BY `start_time` ASC ");
                $check_next[$key]['date']   = $tomorrow;
                $check_next[$key]['slots'] = $data;
                $check_next[$key]['day'] = ucfirst($value['day']);
            }
        }

        $merge_array  = array_merge($check, $check_next);

        if (!empty($merge_array)) 
        {
            foreach ($merge_array as $ksey => $vaslue) 
            {
                $slots = $vaslue['slots'];
                if (!empty($slots)) 
                {
                    foreach ($slots as $qkey => $qvalue) 
                    {
                        $start_time = $qvalue['start_time'];
                        $end_time = $qvalue['end_time'];
                        $slots[$qkey]['start_time'] = date('h:i a', strtotime($start_time));
                        $slots[$qkey]['end_time'] = date('h:i a', strtotime($end_time));
                    }
                }
                $merge_array[$ksey]['slots'] = $slots;
            }
        }
        return $merge_array;
    }

    public function fast_moving_product($p_data = '')
    {
        $myGoal = '';
        $startdate = $p_data['start_date'];
        $enddate = $p_data['end_date'];

        $top_selled = $this->db_model->get_data_array("SELECT item_id,product_id,product_name, COUNT(*) as pro_count FROM `order_items` WHERE `created_date` BETWEEN '$startdate' AND '$enddate' GROUP by product_id HAVING COUNT(*) > 1 ORDER BY COUNT(*) DESC ");

        if ($top_selled) 
        {
            $myGoal = implode(",", array_column($top_selled, "product_id"));
        }

        return $myGoal;
    }

    public function slow_moving_product($p_data = '')
    {
        $myGoal = '';
        $startdate = $p_data['start_date'];
        $enddate = $p_data['end_date'];

        $top_selled = $this->db_model->get_data_array("SELECT item_id,product_id,product_name, COUNT(*) as pro_count FROM `order_items` WHERE `created_date` BETWEEN '$startdate' AND '$enddate' GROUP by product_id HAVING COUNT(*) <= 4 ORDER BY COUNT(*) DESC ");

        if ($top_selled) 
        {
            if ($top_selled) 
            {
                $myGoal = implode(",", array_column($top_selled, "product_id"));
            }
        }        
        return $myGoal;
    }

    public function non_moving_product($p_data = '')
    {
        $myGoal = '';

        $startdate = $p_data['start_date'];
        $enddate = $p_data['end_date'];

        $top_selled = $this->db_model->get_data_array("SELECT item_id,product_id,product_name, COUNT(*) as pro_count FROM `order_items` WHERE `created_date` BETWEEN '$startdate' AND '$enddate' GROUP by product_id HAVING COUNT(*) > 1 ORDER BY COUNT(*) DESC");

        $pid =  implode(",", array_column($top_selled, "product_id"));
        $t_selled = $this->db_model->get_data_array("SELECT id,product_name FROM `product` WHERE `id` NOT IN ($pid)  ORDER BY id DESC ");
        if ($t_selled) 
        {
            foreach ($t_selled as $tkey => $tvalue) 
            {
                $product_id = $tvalue['id'];
                $t_selled[$tkey]['product_id'] = $product_id;
                $t_selled[$tkey]['pro_count'] = 0;
            }
        }

        if ($t_selled) 
        {
            $myGoal = implode(",", array_column($t_selled, "product_id"));
        }

        return $myGoal;
    }

    public function most_viewed()
    {
        $myGoal = '';

        $top_selled = $this->db_model->get_data_array("SELECT id FROM `product` WHERE `view_count` >= '10' ORDER BY view_count DESC ");

        if ($top_selled) 
        {
            if ($top_selled) {
                $myGoal = implode(",", array_column($top_selled, "id"));
            }
        }

        return $myGoal;
    }

    public function top_sold_monthwise_or_not($GET='')
    {
        $year = $GET['year'];
        $month = $GET['month'];

        $query = '';
        if ($month) 
        {
            $query = " AND month(created_date) = '$month' ";
        }
        $type = $GET['type'];


        $top_sold_monthwise = $this->db_model->get_data_array("SELECT product_id,product_name, year(created_date) as year,month(created_date) as month,monthname(created_date) as month_name,count(product_id) as count from order_items WHERE year(created_date) = '$year' $query group by product_id, year(created_date),month(created_date) order by product_id, year(created_date),month(created_date)");
        $pid = '0,';
        if ($type == 'not_sold') 
        {
            if ($top_sold_monthwise) 
            {
                foreach ($top_sold_monthwise as $akey => $vaalue) 
                {
                    $pid.=$vaalue['product_id'].',';
                }
            }

            $top_sold_monthwise = array();
            $pid = rtrim($pid,',');
            $data = $this->db_model->get_data_array("SELECT product_name, id as product_id FROM product WHERE `id` NOT IN ($pid) ");
            if ($data) 
            {
                foreach ($data as $kwey => $wvalue) 
                {
                    if ($month != 0) 
                    {
                        $data[$kwey]['month'] = $month;
                        $data[$kwey]['month_name'] = date('F', mktime(0, 0, 0, $month, 10)); 
                    }
                    else
                    {
                        $data[$kwey]['month'] = '';
                        $data[$kwey]['month_name'] = '';
                    }
                    $data[$kwey]['year'] = $year;

                    $data[$kwey]['count'] = '0';
                }
            }

            $top_sold_monthwise = $data;
        }

            // echo "<pre>";
            // print_r($top_sold_monthwise);
            // die;

        return $top_sold_monthwise;
    }

public function top_selled()
{
    // Fix: Removed item_id and removed the undefined $startdate/$enddate variables
    $top_selled = $this->db_model->get_data_array("SELECT product_id, product_name, COUNT(*) as pro_count FROM `order_items` GROUP BY product_id, product_name HAVING COUNT(*) > 1 ORDER BY COUNT(*) DESC LIMIT 24");
    
    if ($top_selled) 
    {
        foreach ($top_selled as $tkey => $tvalue) 
        {
            $product_id = $tvalue['product_id'];
            $p_data = $this->db_model->get_data_array("SELECT * FROM product WHERE `id` = '$product_id' ");
            if ($p_data) 
            {
                $str = base_url().'public/admin/products/'.@$p_data[0]['product_image'];
                $top_selled[$tkey]['p_image'] = $str;
            }
            else
            {
                $top_selled[$tkey]['p_image'] = "";
            }
        }
    }
    return $top_selled;
}


public function top_customer()
{
    // Grouping by user_id is enough here because it's the only non-aggregated column selected
    $t_customer = $this->db_model->get_data_array("SELECT user_id, COUNT(*) as order_count, SUM(net_total) as total_sum FROM `order_master` GROUP BY user_id HAVING COUNT(*) > 1 ORDER BY COUNT(*) DESC LIMIT 24");

    if ($t_customer) 
    {
        foreach ($t_customer as $tkey => $tvalue) 
        {
            $user_id = $tvalue['user_id'];
            $p_data = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `id` = '$user_id' ");
            if ($p_data) 
            {
                $str = base_url().'public/admin/'.($p_data[0]['logo'] ?? '');
                $t_customer[$tkey]['logo'] = $str;
                $t_customer[$tkey]['fname'] = ($p_data[0]['first_name'] ?? '').' '.($p_data[0]['last_name'] ?? '');
                $t_customer[$tkey]['phone'] = $p_data[0]['phone'] ?? '';
            }
            else
            {
                $t_customer[$tkey]['logo'] = "";
                $t_customer[$tkey]['fname'] = "";
                $t_customer[$tkey]['phone'] = "";
            }
        }
    }
    return $t_customer;
}
    public function get_customer_filter($type="")
    {
            // $t_customer = $this->db_model->get_data_array("SELECT user_id,city_id, COUNT(*) as order_count , SUM(net_total) as total_sum FROM `order_master` GROUP by user_id HAVING COUNT(*) > 1 ORDER BY COUNT(*) DESC limit 12");

        if ($type == 'no_order') {

            $sdate = date('Y-m-d', strtotime('-60 days'));
            $edate = date('Y-m-d', strtotime('+1 days'));
            $s_query = " (order_datetime > '$sdate' AND order_datetime < '$edate') ";

            $t_customer = $this->db_model->get_data_array("SELECT user_id, COUNT(*) as order_count FROM `order_master` WHERE $s_query GROUP by user_id HAVING COUNT(*) >= 1 ORDER BY COUNT(*) DESC ");

            $asd =  implode(",", array_column($t_customer, "user_id"));
            if ($asd) {
                return $asd;
            }
        }
        if ($type == 'one_order') {

            $sdate = date('Y-m-d', strtotime('-60 days'));
            $edate = date('Y-m-d', strtotime('+1 days'));
            $s_query = " (order_datetime > '$sdate' AND order_datetime < '$edate') ";

            $t_customer = $this->db_model->get_data_array("SELECT user_id, COUNT(*) as order_count FROM `order_master` WHERE $s_query GROUP by user_id HAVING COUNT(*) = 1 ORDER BY COUNT(*) DESC ");            
            $asd =  implode(",", array_column($t_customer, "user_id"));
            if ($asd) {
                return $asd;
            }
        }

        if ($type == 'freq_customer') {

            $sdate = date('Y-m-d', strtotime('-7 days'));
            $edate = date('Y-m-d', strtotime('+1 days'));
            $s_query = " (order_datetime > '$sdate' AND order_datetime < '$edate') ";

            $t_customer = $this->db_model->get_data_array("SELECT user_id, COUNT(*) as order_count FROM `order_master` WHERE $s_query GROUP by user_id HAVING COUNT(*) >= 2 ORDER BY COUNT(*) DESC ");
            $asd =  implode(",", array_column($t_customer, "user_id"));
            if ($asd) {
                return $asd;
            }
        }
    }

    public function get_cart_product_name_msg($uid='')
    {
        $name = '';
        $is_data = $this->db_model->my_where('my_cart','*',array('user_id' => $uid,'meta_key' => 'cart'));
        if ($is_data) 
        {
            $content = unserialize($is_data[0]['content']);
            if (!empty($content))
            {
                foreach ($content as $key => $value) 
                {
                    $pid = $value['pid'];
                    $curr = $this->db_model->my_where('product','product_name',array('id' => $pid));
                    if ($curr) 
                    {
                        $name.= $curr[0]['product_name'].' & ';
                    }
                }

                $msg = rtrim($name, ' & ');
                $name = $msg." is still in your cart. Check out now.";
            }

        }

        return $name;
    }

    public function validate_voucher_checkout($voucher_id,$user_id,$pdata = '')
    {
        // echo "<pre>";
        // print_r($pdata);
        // die;

        $data = $this->db_model->get_data_array("SELECT id,amount,code,type,start_date,end_date,min_amount_to_apply,status,max_discount,use_type FROM vouchers WHERE `id` = '$voucher_id' AND `status` = 'active' ");

        if (!empty($data))
        {
            $min_amount_to_apply    = $data[0]['min_amount_to_apply'];
            $amount     = $data[0]['amount'];
            $start_date = $data[0]['start_date'];
            $end_date   = $data[0]['end_date'];
            $code       = $data[0]['code'];
            $type       = $data[0]['type'];
            $id         = $data[0]['id'];
            $status         = $data[0]['status'];
            $max_discount   = $data[0]['max_discount'];
            $use_type   = $data[0]['use_type'];

            if (!empty($start_date)) 
            {
                $paymentDate = strtotime(date("Y-m-d H:i:s"));
                $contractDateBegin = strtotime($start_date);
                $contractDateEnd = strtotime($end_date);

                if($paymentDate > $contractDateBegin && $paymentDate < $contractDateEnd){} 
                else
                {
                    $get['status']  = false;
                    $get['message'] = "Voucher is expired";
                    return $get;
                    return false;
                }
            }

            if ($use_type != 'multiple'){
                $validate_code_table = $this->db_model->my_where("order_master","*",array("user_id" => $user_id , "voucher_id" => $id) ,array());
                if ($validate_code_table)
                {
                    $get['status']  = false;
                    $get['message'] = "Voucher code already used";
                    return $get;
                    return false;
                }
            }

            // $cart_data = $this->view_cart_deta($user_id);
            $cart_data = $this->view_cart_deta($user_id,'','',$pdata);

            // print_r($cart_data);
            // die;

            $cart_total = $cart_data['price_summary']['cart_price'];

            if (!empty($min_amount_to_apply)) 
            {
                if ($cart_total <= $min_amount_to_apply) {
                    $get['status'] = false;
                    $get['message'] = 'You are not eligible for '.$code.' voucher add minimum '.$min_amount_to_apply.' $ in your cart total';
                    return $get;
                    return false;
                }
            }

            if ($type == 'flat') 
            {
                if ($cart_total <= $amount) 
                {
                    $get['status'] = false;
                    $get['message'] = 'Voucher amount is greater than cart amount so please add some extra product in cart';
                    return $get;
                    return false;
                }

                $voucher_amount = $amount;
                $response_data["cart_total"]        = $cart_total;
                $response_data["voucher_amount"]    = $voucher_amount;
                $response_data["voucher_id"]        = $id;
                $response_data["voucher_code"]      = $code;
                $response_data["type"]              = $type;
            }
            else
            {
                $percentage = $amount;
                $totalsum   = $cart_total;

                $voucher_amount = ($percentage / 100) * $totalsum;

                if (!empty($max_discount)){
                    if ($voucher_amount > $max_discount){
                        $voucher_amount = $max_discount;
                    }
                }
                $response_data["cart_total"]        = $cart_total;
                $response_data["voucher_amount"]    = $voucher_amount;
                $response_data["voucher_id"]        = $id;
                $response_data["voucher_code"]      = $code;
                $response_data["type"]              = $type;
            }

            $response_data['status'] = true;
            $response_data['message'] = 'Voucher applied successfully. (<span class="remove_voucher">×</span>)';
            $response_data['s_message'] = 'Voucher applied successfully.';

            return $response_data;
        }
        else
        {
            $get['status'] = false;
            $get['message'] = "Voucher code is not available";
            return $get;
            return false;
        }
    }

    public function view_cart_deta($uid = '',$wallet_amt = '',$voucher_amount = '',$address_id = '')
    {
        $minn_amount_spend =  '1000';
        if (empty($voucher_amount)){
            $voucher_amount = 0;
        }

        $cart_price=$cart_qty = 0;
        $data = $adata = $price_summary = array();
        $attp = array();
        $attc = array();

        if (!empty($uid)){
            $is_data = $this->db_model->my_where('my_cart','*',array('user_id' => $uid,'meta_key' => 'cart'));
            if ($is_data) {
                $_SESSION['content']  = $is_data[0]['content'];
                $content = unserialize($is_data[0]['content']);
            }
            // $this->session->set('content',((!empty($is_data))? $is_data[0]['content']:array()));
        }else{
            $cdata = $this->session->get('content');
            if (!empty($cdata)) {
                $content = unserialize($cdata);
            }
        }

        if (!empty($content) )
        {
            if (!empty($content)) {
                unset($content['cart_qty']);
                foreach ($content as $key => $value)
                {
                    $final_sum = 0;
                    $pid = $value['pid'];
                    if(empty($value['pid'])) {
                        $_POST['pid'] = $value['pid'];
                        $_POST['uid'] = $uid;
                        $this->remove_from_cart($_POST);
                        $_POST[] = array();
                        continue;
                    }
                    $curr = $this->db_model->my_where('product','id,product_name,price,sale_price,stock_status,stock,product_image,category,status,price_select,incremental_qty,minimum_add_to_cart',array('id'=>$pid));
                    if (empty($curr)) {
                        $send_data['pid'] = $key;
                        $send_data['uid'] = $uid;
                        $this->remove_from_cart($send_data);
                        continue;
                    }
                    if(!empty($curr)){
                        $curr[0]['product_image'] = $this->get_product_path($curr[0]['product_image']);
                    }

                    $is_in_wish_list                = $this->is_in_wish_list($curr[0]['id'] ,$uid);
                    $curr[0]['is_in_wish_list']     = $is_in_wish_list;

                    if ($curr[0]['stock_status'] == 'notinstock' || $curr[0]['stock'] == 0 || $curr[0]['stock'] <= 0 || $curr[0]['status'] == 0 ){
                        $send_data['pid'] = $key;
                        $send_data['uid'] = $uid;
                        $this->add_to_wish_list_from_view_cart($send_data);
                        $this->remove_from_cart($send_data);
                        $adata['error'][$key] = $curr[0]['product_name'];
                        continue;
                    }
                    if($value['qty'] > $curr[0]['stock'] ){
                        $value['qty']   =   $curr[0]['stock'];
                        $this->user_account->update_catqty($content,$key,$curr[0]['stock']);
                    }
                    $market_price = $curr[0]['price'];
                    $our_price = $curr[0]['sale_price'];
                    $value['total_amount']  =   $value['qty'] * $curr[0]['price'];
                    $pid = $curr[0]['id'];

                    $rating['rating'] = "2";
                    $rating['user_count'] = "5";
                    // $data[$key]['total_amount'] = $value['total_amount'];
                    if(!empty($value['metadata']))
                    {
                        $item_id = $value['metadata']['item_id'];
                        $get_prod_att_price = $this->db_model->my_where('product_attribute','*',array('item_id' => $item_id,'p_id' => $pid,'attribute_id' => '20'));
                        if ($get_prod_att_price)
                        {
                            $value['metadata']['price'] = $get_prod_att_price[0]['price'];
                            $value['metadata']['sale_price'] = $get_prod_att_price[0]['sale_price'];
                            $our_price = $get_prod_att_price[0]['sale_price'];
                            $market_price = $get_prod_att_price[0]['price'];
                        }
                        $final_sum+= $value['metadata']['sale_price'] * $value['qty'];
                    }
                    else
                    {
                        $final_sum+= $value['total_amount'];
                        $value['metadata'] = array();
                    }

                    if($curr[0]['price_select']==1)
                    {
                        if ($curr[0]['stock_status'] == 'notinstock' || $curr[0]['stock'] == 0 || $curr[0]['stock'] <= 0 || $curr[0]['status'] == 0 )
                        {
                            $this->user_account->add_remove_cart($key,$uid,'remove');
                            continue;
                        }
                        if($value['qty'] > $curr[0]['stock'] )
                        {
                            $value['qty']=$curr[0]['stock'];
                            $this->user_account->update_catqty($content,$key,$curr[0]['stock']);
                        }
                        $price_with_aty = $value['qty'] * $curr[0]['sale_price'];
                    }
                    elseif($curr[0]['price_select']==2)
                    {
                        if($curr[0]['status'] == 0)
                        {
                            $this->user_account->add_remove_cart($key,$uid,'remove');
                            continue;
                        }
                        if(isset($value['metadata']['size']))
                        {
                            $attribute_stock = $this->db_model->get_data_array("SELECT id,stock FROM `product_attribute` WHERE `attribute_id` = '20' AND `item_id` = '".$value['metadata']['item_id']."' AND `p_id` = '".$value['pid']."' ");
                            if(empty($attribute_stock)){
                                $this->user_account->add_remove_cart($key,$uid,'remove');
                                continue;
                            }else
                            {
                                $price_with_aty = $value['metadata']['sale_price'] * $value['qty'];
                                if ($attribute_stock[0]['stock'] == 0 || $attribute_stock[0]['stock'] <= 0 )
                                {
                                    $this->user_account->add_remove_cart($key,$uid,'remove');
                                    continue;
                                }
                                if($value['qty'] > $attribute_stock[0]['stock'] )
                                {
                                    $value['qty']=$attribute_stock[0]['stock'];
                                    $this->user_account->update_catqty($content,$key,$attribute_stock[0]['stock']);
                                }
                            }
                        }
                    }
                    elseif ($curr[0]['price_select'] == 3)
                    {
                        $product_offer = $this->db_model->get_data_array("SELECT quantity,rate FROM product_offer WHERE `product_id` = '$pid'");
                        $count = count($product_offer);
                        if ($product_offer)
                        {
                            foreach ($product_offer as $okey => $ovalue)
                            {
                                $pack_of = '1';
                                $type_qty_piece_name = 'Pack';
                                $return_p_count = $this->get_count($pid ,$uid);
                                $quantity = $ovalue['quantity'];
                                $qty = $pack_of * $quantity;
                                $rate = $ovalue['rate']/$pack_of;
                                $rate = $ovalue['rate'];
                                $title = "Buy $qty $type_qty_piece_name or more at $ $rate/$type_qty_piece_name";
                                $product_offer[$okey]['title'] = $title;
                                if ($count == ($okey + 1))
                                {
                                    $asd = '100000';
                                }
                                else
                                {
                                    $asd = $product_offer[$okey + 1]['quantity'] - 1;
                                }
                                if ( in_array($return_p_count, range($quantity,$asd)) )
                                {
                                    $offer_price            = $ovalue['rate']+10;
                                    $offer_sale_price       = $ovalue['rate'];
                                    $curr[0]['sale_price'] = $offer_sale_price;
                                    $curr[0]['price']  = $offer_price;
                                    $product_offer[$okey]['status'] = "active";
                                    $price_with_aty = $quantity * $offer_sale_price;
                                    // $data[$key]['price_label'] = number_format($return_p_count * $offer_sale_price);
                                }
                                else
                                {
                                    $product_offer[$okey]['status'] = "deactive";
                                }
                                unset($product_offer[$okey]['quantity']);
                                unset($product_offer[$okey]['rate']);
                            }
                        }
                        $curr[0]['product_offer']   = $product_offer;
                    }

                    $extra_sum = 0;
                    $comment = $value['comment'];
                    $extra = $this->db_model->my_where('product_custimze_details','id,name,price',array('pid' => $pid));
                    if ($extra)
                    {
                        if (!empty($comment)) {
                            foreach ($extra as $rkey => $rvalue)
                            {
                                $e_id = $rvalue['id'];
                                $e_price = $rvalue['price'];
                                if ($this->checkNumberInString($e_id, $comment))
                                {
                                    $extra_sum+= $e_price;
                                    $extra[$rkey]['is_added'] = 'yes';
                                } else {
                                    $extra[$rkey]['is_added'] = 'no';
                                }
                            }
                        }
                    }

                    $data[$key]['p'] = $curr[0];
                    $data[$key]['c'] = $value;
                    $data[$key]['extra'] = $extra;
                    $data[$key]['rating'] = $rating['rating'];
                    $data[$key]['rating_user_count'] = $rating['user_count'];
                    $data[$key]['our_price'] = $our_price;
                    $data[$key]['market_price'] = $market_price;
                    $data[$key]['final_sum'] = $final_sum;
                    $data[$key]['key'] = $key;
                    $data[$key]['uqty'] = $value['qty'];
                    $cart_price = $cart_price+$price_with_aty;
                    $cart_qty += $value['qty'];
                }
            }
        }

        $response = array();
        $bill_amt = $dilevery = $total_saved = $totaltax = 0;
        foreach ($data as $key => $value){
            $response[] = $value;
        }

        $distance = '';
        if(!empty($data))
        {
            $tax_table = $this->db_model->my_where('tax','*',array());
            $tax_perc = $tax_table[0]['percentage'];
            $shipping_amount = $tax_table[0]['shipping_charges'];

            if (!empty($address_id)) {

                // echo "<pre>";
                // print_r($address_id);
                // die;

                if (!empty($address_id['lat'])) 
                {
                    $u_lat = $address_id['lat'];
                    $u_lng = $address_id['lng'];
                }
                else
                {
                    if (!is_array($address_id)) {
                        $u_data = $this->db_model->get_data_array("SELECT address_lat,address_lng FROM user_address where `id` = '$address_id' ");
                        if (!empty($u_data)) 
                        {
                            $u_lat = $u_data[0]['address_lat'];
                            $u_lng = $u_data[0]['address_lng'];
                        }
                    }
                }

                if (!empty($u_lat)) {
                    $shop = $this->db_model->get_data_array("SELECT latitude,longitude FROM admin_users where `type` = 'seller' ");
                    
                    $s_lat = $shop[0]['latitude'];
                    $s_lng = $shop[0]['longitude'];

                    $distance = $this->haversineGreatCircleDistance($s_lat, $s_lng, $u_lat, $u_lng);

                    // Calculate shipping cost
                    $initialCost = 3; // First km cost
                    $additionalCostPerKm = 1; // Cost per km after the first km

                    if ($distance <= 1) {
                        $shippingCost = $initialCost;
                    } else {
                        $shippingCost = $initialCost + ($distance - 1) * $additionalCostPerKm;
                    }

                    $shipping_amount = round($shippingCost, 2);
                    $distance = round($distance, 2). " km";   
                }
            }


            $tax = $this->comf->decnum( $cart_price ) * ( $tax_perc / 100);
            if ($wallet_amt){
                $u_data = $this->db_model->get_data_array("SELECT wallet_amount FROM admin_users where `id` = '$uid' ");
                $wallet_amt = $u_data[0]['wallet_amount'];
                if ($wallet_amt < 0) {
                    $wallet_amt = 0;
                }
            }
            else{
                $wallet_amt = 0;
            }
            // $price_summary['min_cart_amount'] = $minn_amount_spend;
            $total_cart = round($cart_price + $shipping_amount + $tax,'2');
            $both_v_wallet_amt = $wallet_amt + $voucher_amount;
            if (!empty($wallet_amt) && !empty($voucher_amount))
            {
                $c_total = $total_cart - $voucher_amount;
                $remaining_w_amt = $wallet_amt - $c_total;
                $price_summary['used_wall_amt'] = $wallet_amt - $remaining_w_amt;
                if ($both_v_wallet_amt < $total_cart) {
                    $price_summary['used_wall_amt'] = $wallet_amt ;
                }
            }
            else if ($wallet_amt > $total_cart){
                $c_total = $total_cart - $voucher_amount;
                $remaining_w_amt = $wallet_amt - $c_total;
                $price_summary['used_wall_amt'] = $wallet_amt - $remaining_w_amt;
            }
            else{
                $c_total = $total_cart - $voucher_amount;
                $remaining_w_amt = $wallet_amt ;
                $price_summary['used_wall_amt'] = $remaining_w_amt;
            }
            
            /*if (!empty($wallet_amt) && !empty($voucher_amount))
            {
            $c_total = $total_cart - $voucher_amount;
            $remaining_w_amt = $wallet_amt - $c_total;
            $price_summary['used_wall_amt'] = $wallet_amt - $remaining_w_amt;
            }*/

            $w_amt = 0;
            $w_amt_reason = '';
            $u_data = $this->db_model->get_data_array("SELECT wallet_amount,wallet_amt_reason FROM admin_users where `id` = '$uid' ");
            if ($u_data)
            {
                $w_amt_reason = $u_data[0]['wallet_amt_reason'];
                $w_amt = $u_data[0]['wallet_amount'];
                if ($w_amt < 0) {
                    $w_amt = $u_data[0]['wallet_amount'];
                }
            }
            // echo "<pre>";
            // print_r($price_summary);
            // die;
            $price_summary['voucher_code'] = '';
            $price_summary['voucher_message'] = '';
            $price_summary['distance'] = $distance;
            $price_summary['voucher_amount'] = $voucher_amount;
            $price_summary['shipping_amount'] = round($shipping_amount,'2');
            $price_summary['tax_percentage'] = $tax_perc;
            $price_summary['tax_amt'] = round($tax,'2');
            $price_summary['cart_price'] = round($cart_price,'2');           
            $price_summary['w_amt'] = $w_amt; 
            $price_summary['w_amt_reason'] = $w_amt_reason;
            $price_summary['total_cart'] = floatval($total_cart - $price_summary['used_wall_amt'] - $voucher_amount);
        }

        // echo "<pre>";
        // print_r($price_summary);
        // die;

        return ['data'=>$response,'price_summary'=>$price_summary,'cart_qty'=>$cart_qty];
        // return $response;
    }

    function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        // Convert latitude and longitude from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        // Haversine formula
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function validate_voucher_place_order($voucher_id,$user_id)
    {
        $data = $this->db_model->get_data_array("SELECT id,amount,code,type,start_date,end_date,min_amount_to_apply,status,max_discount,use_type FROM vouchers WHERE `id` = '$voucher_id' AND `status` = 'active' ");
        if (!empty($data))
        {
            $min_amount_to_apply    = $data[0]['min_amount_to_apply'];
            $amount     = $data[0]['amount'];
            $start_date = $data[0]['start_date'];
            $end_date   = $data[0]['end_date'];
            $code       = $data[0]['code'];
            $type       = $data[0]['type'];
            $id         = $data[0]['id'];
            $status         = $data[0]['status'];
            $max_discount   = $data[0]['max_discount'];
            $use_type   = $data[0]['use_type'];

            if (!empty($start_date)) 
            {
                $paymentDate = strtotime(date("Y-m-d H:i:s"));
                $contractDateBegin = strtotime($start_date);
                $contractDateEnd = strtotime($end_date);

                if($paymentDate > $contractDateBegin && $paymentDate < $contractDateEnd){} 
                else{
                    echo json_encode( array("status" => false ,"message" => "Voucher is expired") );die;
                }
            }

            if ($use_type != 'multiple'){
                $validate_code_table = $this->db_model->my_where("order_master","*",array("user_id" => $user_id , "voucher_id" => $id) ,array());
                if ($validate_code_table){
                    echo json_encode( array("status" => false ,"message" => "Voucher code already used") );die;
                }
            }

            $cart_data = $this->view_cart_deta($user_id);
            $cart_total = $cart_data['price_summary']['cart_price'];

            // echo "<pre>";
            // print_r($cart_total);
            // die;


            if (!empty($min_amount_to_apply)) 
            {
                if ($cart_total <= $min_amount_to_apply) {
                    $message = 'You are not eligible for '.$code.' voucher add minimum '.$min_amount_to_apply.' $ in your cart total';
                    echo json_encode( array("status" => false ,"message" => $message) );die;
                }
            }

            if ($type == 'flat'){
                if ($cart_total <= $amount){
                    echo json_encode( array("status" => false ,"message" => "Voucher amount is greater than cart amount so please add some extra product in cart") );die;
                }

                $voucher_amount = $amount;
                $response_data["cart_total"]        = $cart_total;
                $response_data["voucher_amount"]    = $voucher_amount;
                $response_data["voucher_id"]        = $id;
                $response_data["voucher_code"]      = $code;
                $response_data["type"]              = $type;
            }
            else
            {
                $percentage = $amount;
                $totalsum   = $cart_total;

                $voucher_amount = ($percentage / 100) * $totalsum;

                if (!empty($max_discount)){
                    if ($voucher_amount > $max_discount){
                        $voucher_amount = $max_discount;
                    }
                }
                $response_data["cart_total"]        = $cart_total;
                $response_data["voucher_amount"]    = $voucher_amount;
                $response_data["voucher_id"]        = $id;
                $response_data["voucher_code"]      = $code;
                $response_data["type"]              = $type;
            }

            $response_data['status'] = true;
            $response_data['message'] = 'Voucher applied successfully.';
            return $response_data;
        }
        else{
            echo json_encode( array("status" => false ,"message" => "Voucher code is not available") );die;
        }
    }

    public function resend_otp($p_data ='')
    {
        $language   = 'en';
        $username   = $p_data['mobile_no'];
        $type       = @$p_data['type'];
        if (empty($username)) {
            echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Please enter an phone number'))); die;
        }

        $count_n = strlen((string) $username);
        if($count_n != '10'){
            // echo json_encode( array("status" => false,"message" => ($language == 'ar'? '':"Phone number should be 10 digit only") ) );die;
        }

        $check_number = is_numeric($username);
        if(empty($check_number)){
            echo json_encode( array("status" => false,"message" => ($language == 'ar'? '':"The phone number must consist of only digits ") ) );die;
        }

        $check = $this->db_model->get_data_array("SELECT id,active,otp,otp_count,otp_date_time FROM admin_users WHERE (`username` = '$username' OR `phone` = '$username' ) AND `type` = 'user' ");
        if (!empty($check)) 
        {
            if ($check[0]['active'] == '0') {
                echo json_encode(array("status"=>false,"message"=> ($language == 'ar'? '':"The account has been deactivated by the administration, please contact the administration department"))); die;
            }

            $otp_count = $check[0]['otp_count'];
            if($otp_count >= 5)
            {
                echo json_encode( array("status" => false,"message" => ($language == 'ar'? '':"You have exceeded the maximum verification attempts, please try again in 1 hour") ) );die;
            }

            if (!empty($check[0]['otp'])) {
                $otp = $check[0]['otp'];
            }
            else {
                $otp = rand ( 1000 , 9999 );
            }

            /*if ($username == '8149169115') {
            }*/
            $otp = '1234';
            // $this->sms_fire($username,$otp);

            $update_data['otp'] = $otp;
            $update_data['otp_count'] = $otp_count + 1;
            $update_data['otp_date_time'] = date("Y/m/d H:i:s");

            $this->db_model->my_update($update_data,array('id' => $check[0]['id']),'admin_users');

            $otp_data['otp'] = $otp;
            $otp_data['phone'] = $username;
            $otp_data['user_id'] = $check[0]['id'];
            $otp_data['created_date'] = date("Y/m/d H:i:s");
            $this->db_model->my_insert($otp_data,'otp_list');

            if (!empty($type)) 
            {
                echo json_encode(array("status" => "otp","message"=>  ($language == 'ar'? '':"Otp send successfully to +91 ".$username." number")));die;
            }
            echo json_encode(array("status" => true,"message"=>  ($language == 'ar'? '':"Otp send successfully to +91 ".$username." number"))); die;
        }
        else
        {
            echo json_encode( array("status" => false,"message" => ($language == 'ar'? '':'Invalid request')) );die;
        }
    }

    public  function sms_fire($mobile_no,$otp)
    {
        // Your Account SID and Auth Token from twilio.com/console
        $sid    = "AC925572673621a45bf25be8406a33bacf";
        $token  = "16bd5bee2f81eb32a0d70f1cb0bbb25d";
        $twilio = new Client($sid, $token);

        // $mobile_no = "+918149169115";
        $body = "Welcome to 10 By 10 Food Eat. \n Your OTP code is: $otp";

        $message = $twilio->messages
          ->create($mobile_no,
           [
               "body" => $body,
               "from" => "+18779389958"
           ]
        );

        // echo "<pre>";
        // print($message->sid);
        // print($message);
        // die;
    }

    public function getProductDetailRating($pid)
    {
        $rating_data = array();

        $user_review = $this->db_model->get_data_array("SELECT * FROM user_rating WHERE pid = '$pid' AND status = 'complete' ORDER BY id DESC ");

        if (!empty($user_review))
        {
            $avg = 0;
            foreach ($user_review as $key3 => $value){
                $avg += $value['rating'];
                $user_review[$key3]['created_date'] = date('M d, Y' ,strtotime($value['created_date']));
                $user_review[$key3]['user_logo'] = $this->user_logo($value['uid']);

                unset($user_review[$key3]['order_id']);
                unset($user_review[$key3]['id']);
                unset($user_review[$key3]['uid']);
                unset($user_review[$key3]['pid']);
                unset($user_review[$key3]['status']);
            }
            $avg_rating = $avg/count($user_review);
            $rating_data['avg_rating'] = round($avg_rating,'2');
            $rating_data['user_count'] = count($user_review);
            $rating_data['total_rating'] = $avg;
        }else{
            $rating_data['avg_rating'] = 0;
            $rating_data['user_count'] = 0;
            $rating_data['total_rating'] = 0;
        }

        // $rating_data["product_rating"] = $product_rating;
        $rating_data["user_review"] = $user_review;
        return $rating_data;
    }

    public function get_rating_one_to_five_in_percentage($pid)
    {
        $rating_data = array();

        $total_reviews = $this->db_model->get_data_array("SELECT count(id) as total_star FROM user_rating WHERE pid = '$pid' AND status = 'complete' ORDER BY id DESC ");

        $one_review = $this->db_model->get_data_array("SELECT count(id) as one_star FROM user_rating WHERE pid = '$pid' AND status = 'complete' AND `rating` BETWEEN '0' AND '1'  ORDER BY id DESC ");

        $two_review = $this->db_model->get_data_array("SELECT count(id) as two_star FROM user_rating WHERE pid = '$pid' AND status = 'complete' AND `rating` BETWEEN '1.1' AND '2'  ORDER BY id DESC ");

        $three_review = $this->db_model->get_data_array("SELECT count(id) as three_star FROM user_rating WHERE pid = '$pid' AND status = 'complete' AND `rating` BETWEEN '2.1' AND '3'  ORDER BY id DESC ");

        $four_review = $this->db_model->get_data_array("SELECT count(id) as four_star FROM user_rating WHERE pid = '$pid' AND status = 'complete' AND `rating` BETWEEN '3.1' AND '4'  ORDER BY id DESC ");

        $five_review = $this->db_model->get_data_array("SELECT count(id) as five_star FROM user_rating WHERE pid = '$pid' AND status = 'complete' AND `rating` BETWEEN '4.1' AND '5'  ORDER BY id DESC ");


        $total_count = $total_reviews[0]['total_star'];
        $one_r = $one_review[0]['one_star'];
        $two_r = $two_review[0]['two_star'];
        $three_r = $three_review[0]['three_star'];
        $four_r = $four_review[0]['four_star'];
        $five_r = $five_review[0]['five_star'];

        $one = $two = $three = $four = $five = 0;
        if ($total_count > 0) {
            $one = $one_r/$total_count * 100;
            $two = $two_r/$total_count * 100;
            $three = $three_r/$total_count * 100;
            $four = $four_r/$total_count * 100;
            $five = $five_r/$total_count * 100;

            $one = round($one,2);
            $two = round($two,2);
            $three = round($three,2);
            $four = round($four,2);
            $five = round($five,2);
        }

        $rating_data["one_reviews"] = $one;
        $rating_data["two_reviews"] = $two;
        $rating_data["three_reviews"] = $three;
        $rating_data["four_reviews"] = $four;
        $rating_data["five_reviews"] = $five;
        return $rating_data;
    }

    public function add_product_recent_view($product_id='',$user_id='')
    {
        if (!empty($user_id)) {
            $check = $this->db_model->get_data_array("SELECT pid FROM `recent_view_product` WHERE `user_id` = '$user_id' ");
            if (empty($check)) {
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
        }
    }

    public function get_product_price($pid='')
    {
        $name = '';
        $check = $this->db_model->my_where('product','*',array('id' => $pid));
        if ($check){
            $name = $check[0]['sale_price'];
        }

        $a_str = (string)$name;

        // Check if the string ends with '.00' and remove it
        if (substr($a_str, -3) === '.00') {
            $a_str = substr($a_str, 0, -3);
        }

        return $a_str;
    }

    public function get_product_name($pid='')
    {
        $name = '';
        $check = $this->db_model->my_where('product','*',array('id' => $pid));
        if ($check){
            $name = $check[0]['product_name'];
        }
        return $name;
    }

    public function get_product_image($pid='')
    {
        $name = '';
        $check = $this->db_model->my_where('product','*',array('id' => $pid));
        if ($check){
            $pname = $check[0]['product_image'];
            $name = base_url('public/admin/products/').$pname;
        }
        return $name;
    }

    public function order_cancel($post_data='')
    {
        $ws = 'o_cancel';
        $language = 'en';
        $oid = $post_data['oid'];
        $reason = $post_data['reason'];
        $uid = $post_data['uid'];
        $cron = @$post_data['cron'];
        
        $data = $this->db_model->get_data_array("SELECT * FROM `order_master` WHERE `user_id` = '$uid' AND `order_master_id` = '$oid' ");
        if(!empty($data))
        {
            $wallet_amount = $data[0]['wallet_amount'];
            $account_minus = $data[0]['account_minus'];
            $account_minus_reason = $data[0]['account_minus_reason'];
            $order_status = $data[0]['order_status'];
            if ($order_status == 'Packed') {
                echo json_encode( array("status" => false,"ws" => $ws ,"message" =>  ($language == 'ar'? '':'The order has already been Packed by admin so you cant calcelled order') ) );die;   
            }
            elseif ($order_status == 'Ready to ship') {
                echo json_encode( array("status" => false,"ws" => $ws ,"message" =>  ($language == 'ar'? '':'The order has already been ready to ship so you cant calcelled order') ) );die;   
            }
            else if ($order_status == 'canceled') 
            {
                echo json_encode( array("status" => false,"ws" => $ws ,"message" =>  ($language == 'ar'? '':'The order has already been canceled') ) );die; 
            }
            if ($order_status == 'delivered') 
            {
                echo json_encode( array("status" => false,"ws" => $ws ,"message" =>  ($language == 'ar'? '':'The order has been delivered so cannot be canceled') ) );die; 
            }
            if ($order_status == 'dispatched') 
            {
                echo json_encode( array("status" => false,"ws" => $ws ,"message" =>  ($language == 'ar'? '':'The order has been dispatched so cannot be canceled') ) );die; 
            }
            if ($order_status == 'Pending') 
            {
                if (!empty($account_minus)) 
                {
                    $u_data = $this->db_model->get_data_array("SELECT * FROM `admin_users` WHERE `id` = '$uid' ");
                    if (empty($u_data)) 
                    {
                        echo json_encode( array("status" => true,"ws" => $ws,"message" =>  ($language == 'ar'? '':'Invalid request') ) );die;
                    }

                    $added_w_amt = $u_data[0]['wallet_amount'];
                    $added_w_reason = $u_data[0]['wallet_amt_reason'];

                    $p_data['wallet_amount'] = $added_w_amt - $account_minus;
                    if ($added_w_reason) 
                    {
                        $p_data['wallet_amt_reason'] = $added_w_reason.' AND '.$account_minus_reason;
                    }
                    else
                    {
                        $p_data['wallet_amt_reason'] = $account_minus_reason;
                    }
                    $this->db_model->my_update($p_data,array("id" => $uid),"admin_users");
                }
                else if (!empty($wallet_amount)) 
                {
                    $u_data = $this->db_model->get_data_array("SELECT * FROM `admin_users` WHERE `id` = '$uid' ");
                    if (empty($u_data)) 
                    {
                        echo json_encode( array("status" => true,"ws" => $ws,"message" =>  ($language == 'ar'? '':'Invalid request') ) );die;
                    }

                    $added_w_amt = $u_data[0]['wallet_amount'];
                    $p_data['wallet_amount'] = $added_w_amt + $wallet_amount;
                    $this->db_model->my_update($p_data,array("id" => $uid),"admin_users");
                }

                if (!empty($cron)) {
                    $additional_data['online_unpaid_check'] = '';
                }

                $additional_data['order_cancel_reason'] = $reason;
                $additional_data['order_status'] = 'canceled';
                // $additional_data['order_comment'] = 'The order has been canceled successfully and the order cancel timing is '.date("Y-m-d H:i:s");
                $additional_data['order_cancel_date_time'] = date("Y-m-d H:i:s");
                $result = $this->db_model->my_update($additional_data,array("order_master_id" => $oid),"order_master");

                $this->re_add_product_on_cancel_order($oid);
                
                echo json_encode( array("status" => true,"ws" => $ws ,"message" => ($language == 'ar'? 'تم إلغاء الطلب بنجاح':'The order has been canceled successfully')));die;
            }  
        }
        
        echo json_encode( array("status" => true,"ws" => $ws,"message" => ($language == 'ar'? '':'No order found') ) );die;
    }
}

?>    
