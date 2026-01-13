<?php

namespace App\Controllers\FrontEnd;
use App\Libraries\EmailTemplate;
use App\Libraries\Fcmnotification;
use App\Libraries\Razorpay_lib;
use App\Libraries\Check_login;
use App\Libraries\Stripe_lib;

class Cron extends FrontController
{
    protected $email_t;
    protected $fcmnotification;
    protected $razorpay_lib;
    protected $check_login;
    protected $stripe_lib;

    function __construct()
    {
        $this->email_t  = new EmailTemplate();
        $this->fcmnotification  = new Fcmnotification();
        $this->razorpay_lib  = new Razorpay_lib();
        $this->check_login  = new Check_login();
        $this->stripe_lib  = new Stripe_lib();
    }


    public function index()
    {        
        $this->notification_email_fire();
        $this->check_pro_available_or_not();
    }

    public function notification_email_fire()
    {
        // $data = $this->db_model->get_data_array("SELECT * FROM order_email_notification WHERE `email` = 'pending' ORDER BY 'id' ASC LIMIT 2");

        $data = $this->db_model->get_data_array("SELECT * FROM order_email_notification ORDER BY 'id' ASC LIMIT 1");

        if(!empty($data))
        {
            foreach ($data as $skey => $vsalue) 
            {
                $order_status = $vsalue['order_status'];
                $display_order_id = $vsalue['display_order_id'];
                $user_id = $vsalue['user_id'];
                $id = $vsalue['id'];
                
                if ($order_status == 'Pending') {
                    $title      = "Order Accepted ";
                    $message    = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been accepted and should reach you soon!';
                    $image_url      = '';
                }
                else if ($order_status == 'Packed') {
                    $title      = "Order Packed ";
                    $message    = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been packed and should reach you soon!';
                    $image_url      = '';
                }
                else if ($order_status == 'Ready to ship') {
                    $title      = "Order Ready To Ship ";
                    $message    = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been ready for ship and should reach you soon!';
                    $image_url      = '';
                }
                else if ($order_status == 'Dispatched') {
                    $title      = "Order Dispatched ";
                    $message    = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been dispatched and should reach you soon!';
                    $image_url      = '';
                }
                else if ($order_status == 'delivered') {
                    $title      = "Order Delivered ";
                    $message    = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been delivered.';
                    $image_url      = '';
                }
                else if ($order_status == 'canceled') {
                    $title      = "Order Canceled ";
                    $message    = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been canceled!';
                    $image_url      = '';
                }

                /*if (!empty($message)) {
                    $this->fcmnotification->send_fcm_message_user($user_id, $message, $title,$image_url);
                    $this->db_model->my_update(array("firebase"=>"send"),array("id" => $id),"order_email_notification");
                }*/

                $this->db_model->my_update(array("email"=>"send"),array("id" => $id),"order_email_notification");
                $this->email_t->send_new_invoice($display_order_id);
            }
        }       
    }

    public function check_pro_available_or_not()
    {
        $available_cat = $this->db_model->get_data_array("SELECT * FROM  category  WHERE `parent` = '0' " );
        if (!empty($available_cat))
        {
            foreach ($available_cat as $skey => $svalue)
            {
                $cat_id = $svalue['id'];
                $cat_status = $svalue['status'];

                if ($cat_status == 'deactive') 
                {
                    $product_detail = $this->db_model->my_where("product","id,category",array('category' =>$cat_id,'product_delete' => '0'));

                    if (!empty($product_detail))
                    {
                        foreach ($product_detail as $dkey => $dvalue)
                        {
                            $pid = $dvalue['id'];
                            $this->db_model->my_update(array('category_status' => 'deactive'),array('id' => $pid),'product');   
                        }
                    }
                }
                else
                {
                    $product_detail = $this->db_model->my_where("product","id,category",array('category' =>$cat_id,'product_delete' => '0'));

                    if (!empty($product_detail))
                    {
                        foreach ($product_detail as $dkey => $dvalue)
                        {
                            $pid = $dvalue['id'];

                            $this->db_model->my_update(array('category_status' => 'active'),array('id' => $pid),'product'); 

                            $this->db_model->my_update(array('has_product' => '1'),array('id' => $cat_id),'category');  

                        }
                    }
                    else
                    {
                        $this->db_model->my_update(array('has_product' => '0'),array('id' => $cat_id),'category');  
                    }
                }               
            }
        }
        // die;
    }
}
