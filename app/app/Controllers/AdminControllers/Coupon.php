<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;

class Coupon extends AdminController
{   
    protected $comf;
    function __construct()
    {
       $this->comf = new CommonFun();
       $this->is_logged_in();
       $this->seller_blocked();
    }    

    public function index()
    {
        // $this->superadmin_library->check_permission("coupon_listing");
        // $city_id = $this->superadmin_library->get_city_id();

        // Expiry check
        // $this->superadmin_library->check_voucher_expired_or_not();
        
        $sql = '';
        // if ($city_id) { $sql = "AND city_id = '$city_id' "; }

        $data = $this->db_model->get_data_array("SELECT * FROM vouchers WHERE `id` != '' $sql Order BY id DESC ");
        $this->mViewData['data'] = $data;

        // $sql = '';
        // if ($city_id) { $sql = "AND id = '$city_id' "; }

        // $city = $this->db_model->get_data_array("SELECT id,name FROM city_listing WHERE `status` = 'active' $sql ORDER BY id DESC");
        // $this->mViewData['city'] = $city;

        $this->Urenderadmin('coupon/listing','default', $page_name ='Coupon Listing');
    }

    public function get_coupon_data($bid = ''){
        $language = 'en';
        if(!empty($bid)){
            $data = $this->db_model->get_data_array("SELECT * FROM vouchers WHERE `id` = '$bid' ");
            if ($data) {
                echo json_encode(array("status"=>true, "data" => $data[0] ,"message"=>  ($language == 'ar'? '':"Successfully"))); die;
            }
        }
        
        echo json_encode(array("url"=>"redirect","status"=>true,"message"=>  ($language == 'ar'? '':"Invalid request"))); die;
    }

    public function delete_coupon()
    {
        $post_data=$this->request->getPost();
        if(!empty($post_data))
        {
            $cid = en_de_crypt($post_data['cid'],'d');
            $this->db_model->my_delete(['id' => $cid], 'vouchers');
            echo 1;
            die;
        }else {
            echo 0;
            die;
        }
    }

    public function add_edit_voucher($vid = '')
    {
        $language = 'en';
        $post_data = $this->request->getPost();          
        if(!empty($post_data)){
            if (!empty($vid) && $vid != 'add') {
                $post_data['updated_date'] = date('Y/m/d H:i:s');                
                $this->db_model->my_update($post_data , array("id"=> $vid),"vouchers");
                echo json_encode(array("status"=>true,"message"=>  ($language == 'ar'? '':"Coupon information updated successfully"))); die;
            }
            else{
                $post_data['created_date'] = date('Y/m/d H:i:s');
                $this->db_model->my_insert($post_data,"vouchers");
                echo json_encode(array("status"=>true,"message"=>  ($language == 'ar'? '':"Coupon created successfully"))); die;                
            }
        }
        echo json_encode(array("url"=>"redirect","status"=>true,"message"=>  ($language == 'ar'? '':"Invalid request"))); die;
    }
}