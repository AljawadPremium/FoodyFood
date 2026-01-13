<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;
use App\Libraries\Razorpay_lib;

class Razorpay extends AdminController
{   
    protected $comf;
    protected $razorpay_lib;
    function __construct()
    {
       $this->comf = new CommonFun();
       $this->razorpay_lib = new Razorpay_lib();
       $this->is_logged_in();
    }    

    public function payment_link_listing()
    {
        $post_data = $this->request->getPost();
        if (!empty($post_data)) 
        {
            $this->razorpay_lib->send_payment_link($post_data);
        }

        $p_data = $this->db_model->get_data_array("SELECT * FROM razorpay_genrate_payment_link Order BY id DESC ");
        $this->mViewData['p_data'] = $p_data;
        $this->Urenderadmin('razorpay/payment_link_listing_create','default', $page_name ='Payment Link');
    }

    public function order_payment_link()
    {
        $aid = $this->admin_id;

        if (empty($aid)) {
            echo json_encode(array("status"=>false ,"message"=>  ($language == 'ar'? '':"Invalid request"))); die;
        }

        $post_data = $this->request->getPost();
        $post_data['type'] = $aid;

        if (!empty($post_data)) 
        {
            $this->razorpay_lib->send_payment_link($post_data);
        }
    }

    public function get_qr($did='')
    {
        if ($did) {
            $this->razorpay_lib->get_qr_code($did);
        }

        echo json_encode(array("status"=>false,"message" => 'Invalid request')); die;
    }

}