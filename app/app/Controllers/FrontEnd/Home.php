<?php

namespace App\Controllers\FrontEnd;
use App\Libraries\EmailTemplate;
use App\Libraries\CommonFun;
use App\Libraries\Check_login;

// require_once 'vendor/autoload.php'; 
// use Twilio\Rest\Client;

class Home extends FrontController
{
    protected $comf;
    protected $email_t;
    protected $check_login;

    function __construct()
    {
        $this->comf   = new CommonFun();
        $this->email_t  = new EmailTemplate();
        $this->check_login  = new Check_login();
    }

    public function index()
    {
        $latitude = $longitude = '';
        if (empty($latitude)) {
            $latitude = "19.0645";
            $longitude = "74.7089";
        }

        $user_id = $this->user_id;
        $session = session();
        if (!empty($session->get('lat'))) {
            $latitude = $session->get('lat');
            $longitude = $session->get('lng');

            if(!empty($latitude)) $update_arr['latitude']  = $latitude;
            if(!empty($longitude)) $update_arr['longitude']  = $longitude;
            $this->db_model->my_update($update_arr,array("id" => $user_id),"admin_users");
        }

        $c_listing = $this->db_model->get_data_array("SELECT id,display_name,image FROM category WHERE `status` = 'active' ");
        $our_supplies_listing = $this->db_model->get_data_array("SELECT id,image FROM our_supplies WHERE `status` = 'active' ");

        $category_listing = $this->db_model->get_data_array("SELECT id,display_name,image FROM category WHERE `status` = 'active' AND `parent` = '0' AND `has_product` = '1' ORDER BY id ASC LIMIT 6"); 

        if (!empty($category_listing)) {
            foreach ($category_listing as $vkey => $vvalue){
                $cat = $vvalue['id'];
                $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1'  AND ( `category` = '$cat' ) order by  id desc LIMIT 6 ");
                $product_l_array = $this->check_login->get_all_product_data($product_listing,$user_id);
                $category_listing[$vkey]['product_list'] = $product_l_array;
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

        $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1' ORDER BY id DESC LIMIT 8 "); 
        $new_arrival = $this->check_login->get_all_product_data($product_listing,$user_id);

        $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `special_menu` = '1' AND `status`='1' ORDER BY id DESC LIMIT 8 "); 
        $special_listing = $this->check_login->get_all_product_data($product_listing,$user_id);

        $random_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1' ORDER BY RAND() LIMIT 8 "); 
        $rand_listing = $this->check_login->get_all_product_data($random_listing,$user_id);


        $top_listing = array();
        $top_sold_monthwise = $this->db_model->get_data_array("SELECT product_id FROM order_items group by product_id, year(created_date),month(created_date) ORDER BY product_id");
        if(!empty($top_sold_monthwise)) {
            $product_ids = array_column($top_sold_monthwise, 'product_id');
            $product_id_list = implode(',', $product_ids);
            
            $top_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product WHERE  `stock_status` = 'instock' AND `product_delete`='0' AND `status`='1' AND id IN ($product_id_list) ORDER BY RAND() LIMIT 8 "); 
            $top_listing = $this->check_login->get_all_product_data($random_listing,$user_id);
        }

        // echo "<pre>";
        // print_r($top_listing);
        // die;

        $this->mViewData['our_supplies_listing'] = $our_supplies_listing;
        $this->mViewData['top_listing'] = $top_listing;
        $this->mViewData['rand_listing'] = $rand_listing;
        $this->mViewData['special_listing'] = $special_listing;
        $this->mViewData['new_arrival'] = $new_arrival;
        $this->mViewData['all_shop_listing'] = $all_shop_listing;
        $this->mViewData['category_listing'] = $category_listing;
        $this->mViewData['c_listing'] = $c_listing;
        $this->Urender('index','default', $page_name = 'Food');
    }

    public function save_location()
    {
        $session = session();
        $post_data=$this->request->getPost();

        if ($post_data) {
            $lat = $post_data['lat'];
            $lng = $post_data['lng'];
            
            // $_SESSION['lat'] = $lat;
            // $_SESSION['lng'] = $lng;

            $session->set([
                'lat'   => $lat,
                'lng'  => $lng,
            ]);
        }

        echo "<pre>";
        print_r($post_data);
        die;
    }

    public function changeLang()
    {
        // https://includebeer.com/en/blog/creating-a-multilingual-website-with-codeigniter-4-part-2
        $post_data=$this->request->getPost(); 
        if(!empty($post_data))
        {
            if(isset($post_data['lang']))
            {
                $lang = get_cookie('lang');
                if($lang == $post_data['lang']) {
                    echo json_encode(array("status"=>false,"message"=>"The same language has already been selected")); die;
                }

                $post_data['lang'] = $this->comf->test_input($post_data['lang']);
                if(in_array($post_data['lang'], $this->request->config->supportedLocales))
                {
                    $this->comf->set_lang($post_data['lang']);
                    echo json_encode(array("status"=>true,"message"=>"The language has been changed successfully")); die;
                }else{
                    echo json_encode(array("status"=>false,"message"=>"Please select a valid language")); die;
                }                
            }
        }
        echo json_encode(array("status"=>false,"message"=>"Something went wrong")); die;
    }
}
