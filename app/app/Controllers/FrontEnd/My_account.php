<?php

namespace App\Controllers\FrontEnd;
use App\Libraries\EmailTemplate;
use App\Libraries\CommonFun;
use App\Libraries\Check_login;

class My_account extends FrontController
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
        // $this->Urender('my-account','udefault');
    }

    public function edit()
    {
        $language = 'en';
        $uid = $this->user_id;

        $data = $this->db_model->my_where("admin_users","id,username,email,first_name,phone,last_name,logo,date_of_birth",array("id" => $uid),array(),"","","","", array(), "",array(),false  );

        $post_data = $this->request->getPost();
        
        if (!empty($post_data))
        {
            $email = $post_data['email'];
            $phone = $post_data['phone'];
            $first_name = $post_data['first_name'];
            $last_name = $post_data['last_name'];
            $date_of_birth = $post_data['date_of_birth'];

            if (empty($first_name)) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? ' الرجاء إدخال الاسم الأول':'Please enter first name')) );die;
            }
            if (empty($last_name)) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء إدخال اسم العائلة':'Please enter last name')) );die;
            }
            if (empty($email)) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء إدخال عنوان البريد الإلكتروني':'Please enter email address')) );die;
            }
            if (empty($phone)) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء إدخال رقم الهاتف':'Please enter phone number')) );die;
            }

            $email_check = $this->db_model->my_where("admin_users","*",array("id !=" => $uid,'email' => $email),array(),"","","","", array(), "",array(),false  );
            if ($email_check) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'البريد الإلكتروني موجود بالفعل':'Email already exist')) );die;
            }
            
            $FILES=$_FILES['logo'];
            $logo = $this->uploads_logo($FILES);
            
            $phone_check = $this->db_model->my_where("admin_users","*",array("id !=" => $uid,'phone' => $phone),array(),"","","","", array(), "",array(),false  );
            if ($phone_check) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الهاتف موجود بالفعل':'Phone already exist')) );die;
            }

            
            $additional_data = array();
            if ( empty($email_check))
            {
                if(!empty($first_name)) $additional_data['first_name']  = $first_name;
                if(!empty($last_name)) $additional_data['last_name']    = $last_name;
                if(!empty($email)) $additional_data['username'] = $email;
                if(!empty($email)) $additional_data['email']    = $email;
                if(!empty($phone)) $additional_data['phone'] = $phone;
                if(!empty($logo)) $additional_data['logo']  = $logo;
                if(!empty($date_of_birth)) $additional_data['date_of_birth']    = $date_of_birth;

                if(!empty($additional_data))
                {
                    $this->db_model->my_update($additional_data,array('id' => $uid),'admin_users');
                    echo json_encode( array("status" => true, "message" => ($language == 'ar'? 'تم تحديث الملف  بنجاح':'Profile Updated successfully')) );die;
                }else{
                    echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'حدث خطأ ما':'Something went wrong')) );die;
                }
            }
        }

        // echo "<pre>";
        // print_r($data);
        // die;
        
        $this->mViewData['edit'] = $data[0];
        $this->Urender('profile/account-info','default', $page_name = 'My account');
    }


    public function account()
    {
        $this->Urender('my-account','default');
    }

    public function cng_pass()
    {
        die;
        $uid = $this->user_id;

        $post_data = $this->request->getPost();
        $data = $this->db_model->my_where("admin_users","id,username,email,first_name,phone,password",array("id" => $uid),array(),"","","","", array(), "",array(),false  );

        if ( !empty($post_data) )
        {
            $language = $post_data['language'];
            $password = $post_data['password'];
            $confirm_password = $post_data['confirm_password'];
            // $old_password = $this->input->post('old_password');

            // if (empty($old_password)) {
            //  echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء إدخال كلمة المرور القديمة':'Please enter old password')) );die;
            // }
            if (empty($password)) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء إدخال كلمة المرور':'Please enter password')) );die;
            }
            if (empty($confirm_password)) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء الموافقة على كلمة المرور':'Please enter confirm password')) );die;
            }

            $hpassword = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

            // if(password_verify ( $old_password ,$data[0]['password'] ))
            // {
            if($password == $confirm_password )
            {
                $updata["password_show"] = $password;
                $updata["password"] = $hpassword;
                $this->db_model->my_update($updata,array('id' => $uid),'admin_users');
                echo json_encode( array("status" => true, "message" => ($language == 'ar'? 'تم تغيير كلمة المرور بنجاح':'Password changed successfully')) );die;
            }
            else
            {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'كلمة المرور وتأكيد كلمة المرور غير متطابقة':'Password & Confirm Password Not Matched')) );die;
            }               
            // }
            // else
            // {
            //  echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'كلمة مرور قديمة غير صالحة':'Invalid old password')) );die;
            // }            
        }       

        $this->Urender('cng-pw', 'default',"",$data);
    }

    public function wallet()
    {
        $uid = $this->user_id;
        $data = $this->db_model->my_where("admin_users","id,wallet_amount,wallet_amt_reason",array("id" => $uid),array(),"","","","", array(), "",array(),false  );
        $this->mViewData['info'] = $data[0];     
        $this->Urender('wallet_amt', 'default');
    }

    public function address()
    {
        $user_id = $this->user_id;
        $language = 'en';
        $post_data = $this->request->getPost();

        if ( !empty($post_data) )
        {
            // echo "<pre>";
            // print_r($post_data);
            // die;

            $e_id         = @$post_data['edit_id'];
            $first_name     = $post_data['first_name'];
            $last_name     = $post_data['last_name'];
            $email = $post_data['email'];
            $phone = $post_data['phone'];
            $address = $post_data['address'];
            $landmark = $post_data['landmark'];
            $state = $post_data['state'];
            $postcode = $post_data['postcode'];

            unset($post_data['edit_id']);            
            if (empty($first_name)){
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? '':'Please enter first name')) );die;   
            }
            if (empty($last_name)){
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? '':'Please enter last name')) );die;   
            }
            if (empty($email)){
                // echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء إدخال عنوان البريد الإلكتروني':'Please enter email address')) );die;   
            }
            if (empty($phone)){
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء إدخال رقم الهاتف':'Please enter phone number')) );die;   
            }
            if (empty($address)){
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء إدخال العنوان':'Please enter address')) );die;   
            }
            if (empty($landmark)){
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء ادخال ,المبنى.الدور.رقم الشقة':'Please enter Apartment, suite, unit etc')) );die;   
            }
            if (empty($state)){
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء ادخال الامارة':'Please enter state')) );die;   
            }
            
            if (empty($postcode)){
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء إدخال الرمز البريدي':'Please enter postcode')) );die;   
            }
            $length = strlen(preg_replace("/[^0-9]/", '', $phone));
            if ($length != '10') 
            {
                echo json_encode(array("status"=>false,"message"=>($language == 'ar'? '':'Phone number should be 10 digit')  )); die;
            }


            if (!empty($e_id)) 
            {
                $this->db_model->my_update($post_data,array('id' => $e_id),'user_address');
                echo json_encode(array("status"=>true,"message"=>($language == 'ar'? '':'Address data updated successfully')  )); die;
            }
            else
            {
                $post_data['created_date'] = date('Y-m-d H:i:s');
                $post_data['user_id'] = $user_id;
                $this->db_model->my_insert($post_data,'user_address');
                echo json_encode(array("status"=>true,"message"=>($language == 'ar'? '':'Address data created successfully') )); die;
            }
        }

        $all_data = $this->db_model->get_data_array("SELECT * FROM user_address WHERE `user_id` = '$user_id' ORDER BY 'id' DESC ");

        // echo "<pre>";
        // print_r($all_data);
        // die;

        $this->mViewData['all_data'] = $all_data;
        $this->Urender('address-book','default');
    }

    public function wishlist()
    {   
        $data = array();
        $uid=$this->user_id;
        $my_data = $this->db_model->my_where('my_cart','*',array('user_id' => $uid,'meta_key' => 'wish_list'));     
        if (!empty($my_data))
        {           
            $my_wish=unserialize($my_data[0]['content']);
            if (!empty($my_wish)) {
                foreach ($my_wish as $key => $value)
                {
                    $curr = $this->db_model->my_where('product','id,product_name,price,sale_price,stock_status,stock,product_image,price_select,price_aed,sale_price_aed,price_sar,sale_price_sar',array('id'=> @$value['pid'],'status'=>'1')); 
                    if (!empty($curr))
                    {                       
                        $data[$key] = $curr[0];
                    }                   
                }
            }
        }

        $data=$this->related_menu($data,$is_catetory = false,$is_wish=true);

        // echo "<pre>";
        // print_r($data);
        // die;

        $this->mViewData['product_data'] = $data;                   
        $this -> Urender('wishlist','default');
    }

    public function remove_from_wishlist()
    {
        $language = '';
        $uid = $this->user_id;
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $this->load->library('check_login');
            $pid = $post_data['c_id'];
            $my_wish = $this->check_login->wish_list_actions($uid, $pid, 'remove');
            echo json_encode( array("status" => true, "message" => ($language == 'ar'? '':'The product has been successfully removed from your wish list .')) );die;
        }
        else 
        {
            echo json_encode( array("status" => false ,"message" => ($language == 'ar'? '':'Invalid request') ) );die;
        }
    }


    public function orders()
    {
        $language = "en";
        if (!empty($this->user_id))
        {
            $data = array();            
            $data = $this->db_model->get_data_array("SELECT * FROM `order_master` WHERE `user_id` = '$this->user_id' ORDER BY order_master_id desc ");          
            foreach ($data as $key => $value)
            {
                $order_status = $value['order_status'];
                $data[$key]['order_statuss'] = $order_status;

                $payment_status = $value['payment_status'];
                if ($order_status == 'Pending') {
                    $data[$key]['order_status'] = '<label class="mb-0 badge badge-primary" title="" data-original-title="Pending">Pending</label>';
                }
                if ($order_status == 'Packed') {
                    $data[$key]['order_status'] = '<label class="mb-0 badge badge-warning" title="" data-original-title="Pending">Packed</label>';
                }
                if ($order_status == 'Ready to ship') {
                    $data[$key]['order_status'] = '<label class="mb-0 badge badge-dark" title="" data-original-title="Pending">Ready to ship</label>';
                }
                if ($order_status == 'Dispatched') {
                    $data[$key]['order_status'] = '<label class="mb-0 badge badge-info" title="" data-original-title="Pending">Dispatched</label>';
                }
                if ($order_status == 'delivered') {
                    $data[$key]['order_status'] = '<label class="mb-0 badge badge-success" title="" data-original-title="Pending">Delivered</label>';
                }
                if ($order_status == 'canceled') {
                    $data[$key]['order_status'] = '<label class="mb-0 badge badge-danger" title="" data-original-title="Pending">Canceled</label>';
                }

                $color = 'badge-primary';
                if ($payment_status == 'Unpaid') 
                {
                    $color = 'badge-warning';
                }
                $data[$key]['payment_status'] = '<label class="mb-0 badge '.$color.' ">'.$payment_status.'</label>';

                $items = $this->db_model->my_where("order_items","*",array("order_no" => $value['order_master_id']) );

                foreach ($items as $k => $val)
                {                   
                    $item_info = $this->db_model->my_where("product","product_name,product_image,id",array("id" => $val['product_id']) );       
                    if ($item_info) 
                    {
                        @$data[$key]['items'][$k] = array_merge($val,$item_info[0]);
                    }           
                }
            }

            $this->mViewData['data']= $data;
            $this->Urender('profile/order-history', 'default',"Orders");
        }
    }

    public function order_detail($d_id = '')
    {
        $language = "en";
        if (!empty($this->user_id))
        {
            $display_order_id = en_de_crypt($d_id,'d');

            $transaction_details = $this->db_model->my_where('transaction_details','*',array('display_order_id' => $display_order_id));
            $data = $this->db_model->my_where('order_master','*',array('display_order_id' => $display_order_id));
            $order_item = $this->db_model->my_where('order_items','*',array('order_no' => $data[0]['order_master_id']));
            $order_comment = $this->db_model->my_where('order_comment','*',array('oid' => $data[0]['order_master_id']));

            // echo "<pre>";
            // print_r($data);
            // die;
            
            $this->mViewData['order_comment'] = $order_comment;
            $this->mViewData['t_details'] = $transaction_details;
            $this->mViewData['order_item'] = $order_item;
            $this->mViewData['data'] = $data[0];


            $this->Urender('profile/order-history-detail', 'default');
        }
    }
    

    public function newsletter()
    {
        $uid = $this->user_id;
        $language = "en";
        $post_data = $this->request->getPost();

        if ( !empty($post_data) )
        {            
            $newsletter = $post_data['email'];
            if (empty($newsletter)) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'الرجاء اختيار النشرة الدورية':'Please enter email for newsletter')) );die;
            }

            $data = $this->db_model->get_data_array("SELECT * FROM newsletter WHERE `email` = '$newsletter' ");
            if (empty($data)) {
                $additional_data['email'] = $newsletter;
                if (!empty($uid)) {
                    $additional_data['user_id'] = $uid;
                }
                $additional_data['created_date'] = date('Y-m-d H:i:s');
                $this->db_model->my_insert($additional_data,'newsletter');
            }

            echo json_encode( array("status" => true, "message" => ($language == 'ar'? 'تم تحديث النشرة الدورية بنجاح':'Newsletter information updated successfully')) );die;
        }
    }

    public function delete_address()
    {
        $language = 'en';
        $uid = $this->user_id;
        $post_data = $this->request->getPost();
        if(!empty($post_data) && !empty($uid))
        {
            $a_id = $post_data['a_id'];
            $this->db_model->my_delete(array('id' => $a_id,'user_id' => $uid),'user_address');
            echo json_encode( array("status" => true, "message" => ($language == 'ar'? '':'Address deleted successfully')) );die;
        }
        else 
        {
            echo json_encode( array("status" => false, "message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request')) );die;
        }
    }

    public function get_address_data($a_id = '')
    {
        $language = 'en';
        $uid = $this->user_id;
        if(!empty($a_id))
        {
            $data = $this->db_model->get_data_array("SELECT * FROM user_address WHERE `id` = '$a_id' AND `user_id` = '$uid' ");
            if ($data) 
            {
                echo json_encode(array("status"=>true, "data" => $data[0] ,"message"=>  ($language == 'ar'? '':"Successfully"))); die;
            }
        }
        
        echo json_encode(array("status"=>true,"message"=>  ($language == 'ar'? '':"Invalid request"))); die;
    }


    public function uploads_logo($FILES)
    {
        if (isset($FILES['name'])) {
            $upload_dir = ROOTPATH . "/public/usersdata/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_name    = $FILES['name'];
            $random_digit = rand(0000, 9999);
            $target_file  = $upload_dir . basename($FILES["name"]);
            $ext          = pathinfo($target_file, PATHINFO_EXTENSION);
            
            $new_file_name = $random_digit . "." . $ext;
            $path          = $upload_dir . $new_file_name;
            if (move_uploaded_file($FILES['tmp_name'], $path)) {
                return $new_file_name;
            } else {
                return false;
            }
        } else {
            return false;
            
        }
    }

    public function order_cancel()
    {
        $post_data = $this->request->getPost();
        $o_id       = @$post_data['o_id'];
        $reason     = @$post_data['reason'];
        $language   = 'en';
        $oid = en_de_crypt($o_id,'d');

        if (empty($oid)) {
            echo json_encode( array("status" => false,"message" => ($language == 'ar'? '':'Add order number') ) );die;
        }

        if (empty($reason)) {
            echo json_encode( array("status" => false,"ws" => $ws ,"message" => ($language == 'ar'? '':'Add reason for cancel order') ) );die;
        }

        // echo "<pre>";
        // print_r($post_data);
        // die;
        
        $uid = $this->user_id;
        if (!empty($uid))
        {
            $post_data['oid'] = $oid;
            $post_data['reason'] = $reason;
            $post_data['uid'] = $uid;
            $data = $this->check_login->order_cancel($post_data);
        }
        
        echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'طلب غير صالح':'Invalid request') ) );die;
    }
}