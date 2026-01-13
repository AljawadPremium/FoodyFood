<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;
use App\Libraries\Check_login;
use App\Libraries\Fcmnotification;

class Customer extends AdminController
{   
    protected $comf;
    protected $fcmnotification;
    protected $check_login;
    function __construct()
    {
       $this->fcmnotification = new Fcmnotification();
       $this->comf = new CommonFun();
       $this->check_login = new Check_login();
       $this->is_logged_in();
       $this->seller_blocked();
    }    

    public function index()
    {
        $user_type = $this->admin_data[0]['type'];
        $post_data = $this->request->getPost();

        $rowno=0; 
        $ajax='call';
        $serach='';

        $sort = 'id';
        $sort_by = 'DESC';
        $sql = '';

        if (!empty($post_data))
        {
            // echo "<pre>";
            // print_r($post_data);
            // die;

            $filter_by = $post_data['filter_by'];
            $sor_by = $post_data['sort_by'];

            $rowno = $post_data['pagno'];
            $ajax   = $post_data['ajax'];
            $serach = $post_data['serach'];

            if (!empty($serach)) {
                $sql.= "AND (CONCAT(first_name,' ', last_name) LIKE '%$serach%' OR `source` LIKE '%$serach%' OR `phone` LIKE '%$serach%' OR `first_name` LIKE '%$serach%' OR `last_name` LIKE '%$serach%' OR  `email` LIKE '%$serach%' ) ";
            }

            if (!empty($sor_by)) {
                $s_array = explode(',', $sor_by);
                $sort = $s_array[0];
                $sort_by = $s_array[1];
            }
            if (!empty($filter_by)) {
                $udataa = $this->check_login->get_customer_filter($filter_by);
                
                if ($filter_by != 'no_order') {
                    if (empty($udataa)) {
                        $udataa = '3';
                    }
                    $sql.= "AND id IN($udataa) ";
                }
                else if ($filter_by == 'no_order') 
                {
                    if (empty($udataa)) {
                        $udataa = '3';
                    }
                    $sql.= "AND id NOT IN($udataa) ";
                }
            }
        }

        $rowperpage = 7;
        
        if($rowno != 0) {
            $active_page=$rowno;
            $rowno = ($rowno-1) * $rowperpage;
        } else {
            $active_page=1;
            $rowno=0;
        }
        
        $customer = $this->db_model->get_data_array("SELECT id,email,first_name,last_name,phone,source,created_on FROM admin_users WHERE `type` = 'user' $sql  ORDER BY $sort $sort_by limit $rowno,$rowperpage ");
        $customer_count = $this->db_model->get_data_array("SELECT id FROM admin_users WHERE `type` = 'user' $sql ");

        if (!empty($customer)) 
        {
            foreach ($customer as $key => $value) 
            {
                $sum = 0;
                $first_name = $value['first_name'];
                $user_id = $value['id'];
                $order_count = $this->db_model->get_data_array("SELECT COUNT(order_master_id) as order_count FROM order_master WHERE `user_id` ='$user_id' ");
                $customer[$key]['order_count'] = $order_count[0]['order_count'];

                // $order_sum = $this->db_model->get_data_array("SELECT SUM(net_total) as pending_count FROM order_master WHERE `user_id` ='$user_id' AND `payment_status` = 'Unpaid' AND `order_status` != 'canceled' AND `order_status` != 'delivered' ");
                // $customer[$key]['order_pending_amt'] = $order_sum[0]['pending_count'];

                $order_unpaid = $this->db_model->get_data_array("SELECT order_master_id,net_total,order_datetime FROM order_master WHERE `user_id` = '$user_id' AND `payment_status` = 'Unpaid' AND  `order_status` != 'canceled' ");

                if ($order_unpaid) {
                    foreach ($order_unpaid as $kaey => $vaalue) {
                        $sum+=$vaalue['net_total'];
                    }
                }

                // $customer[$key]['order_unpaid'] = $order_unpaid;
                $customer[$key]['unpaid_amt'] = $sum;
                $customer[$key]['total_orders_unpaid'] = count($order_unpaid);

                $c_id = en_de_crypt($value['id']);
                $customer[$key]['c_id'] = $c_id;
                $customer[$key]['created_date'] = date('Y-m-d' ,strtotime($value['created_on'])); 
                $customer[$key]['created_time'] = date('g:i a' ,strtotime($value['created_on'])); 
                $customer[$key]['created_day'] = date('l' ,strtotime($value['created_on'])); 
                
                $url = '<a href=" '.base_url('admin/customer/view/').$c_id.'" target="_blank" class=""><button class="btn btn-sm btn-success"><i class="fa fa-eye "></i></button></a> ';

                $url.= '<a class="notification_c" href="javascript:void(0);" data-id="'.$c_id.'" data-name="'.$first_name.'" data-toggle="modal" data-target="#notification_customer" ><button class="btn btn-sm btn-warning"><i class="fa fa-bell"></i></button></a> ';

                $url.= '<a class="delete_customer" href="javascript:void(0);" data-id="'.$c_id.'" ><button class="btn btn-sm btn-warning"><i class="fa fa-trash "></i></button></a> ';


                $customer[$key]['action_url'] = $url;
            }
        }

        $page_arr['active_page'] = $active_page;
        $page_arr['rowperpage'] = $rowperpage;
        $page_arr['data_count'] = count($customer_count);

        if($ajax =='call' && $rowno==0 && empty($post_data)){
            $this->mViewData['pagination_link'] = $this->pagination($page_arr);
        }else {
            $data['status'] = true;
            $data['pagination_link'] = $this->pagination($page_arr);
            $data['result'] = $customer;
            $data['row'] = $rowno;
            $data['total_rows'] = $page_arr['data_count']; 
            $data['message'] = ""; 
            echo json_encode($data);
            die;
        }

        // echo "<pre>";
        // print_r($customer);
        // die;

        $this->mViewData['c_listing'] = array();
        $this->mViewData['data'] = $customer;

        $building_list = $this->db_model->get_data_array("SELECT * FROM building_list WHERE `status` = 'active' ORDER BY `id` ASC");
        $this->mViewData['building_list'] = $building_list;

        $this->Urenderadmin('customer/listing','default', $page_name ='Customer Listing');
    }

    public function view($cid='')
    {
        $cid = en_de_crypt($cid,"d");

        $customer = $this->db_model->get_data_array("SELECT id,username,password_show,email,first_name,last_name,phone,logo,social,source,created_on,last_login,active FROM admin_users WHERE `id` = '$cid' AND `type` = 'user' ");

        if (!empty($customer)) 
        {
            foreach ($customer as $key => $value) 
            {
                $order_count = $this->db_model->get_data_array("SELECT COUNT(order_master_id) as order_count FROM order_master WHERE `user_id` ='$cid' ");
                $customer[$key]['order_count'] = $order_count[0]['order_count'];

                $customer[$key]['c_id'] = en_de_crypt($value['id']);
                $customer[$key]['created_date'] = date('Y-m-d' ,strtotime($value['created_on'])); 
                $customer[$key]['created_time'] = date('g:i a' ,strtotime($value['created_on'])); 
                $customer[$key]['created_day'] = date('l' ,strtotime($value['created_on'])); 
            }
        }
        else {
            return redirect()->to(base_url('admin/customer'));
        }

        $post_data = $this->request->getPost();
        if ($post_data) 
        {
            $email = $post_data['email'];
            $phone = $post_data['phone'];
            $active = $post_data['active'];

            if ($email) 
            {
                $email_check = $this->db_model->my_where("admin_users","*",array('email' => $email,'id !=' => $cid),array(),"","","","", array(), "",array(),false  );
                if ($email_check) {
                    echo json_encode( array("status" => false, "message" => ($language == 'ar'? '':'Email address already exist')) );die;
                }
                $post_data['username'] = $email;
            }
            else {
                $post_data['username'] = $phone;
            }

            $phone_check = $this->db_model->my_where("admin_users","*",array('phone' => $phone,'id !=' => $cid),array(),"","","","", array(), "",array(),false  );
            if ($phone_check) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? '':'Phone number already exist')) );die;
            }

            if ($active != 1) {
                $post_data['token'] = "";
            }

            $password = $post_data['password'];
            if ($password) {
                $post_data['password_show'] = $password;
                $post_data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }
            else {
                unset($post_data['password']);
            }

            $this->db_model->my_update($post_data,array('id' => $cid,'type' => "user"),'admin_users');
            echo json_encode(array("status"=>true,"message"=> 'Personal information updated successfully')); die;
        }

        $data_items = $this->db_model->my_where("order_master","*",array("user_id" => $cid),array(),"","","","", array(), "",array(),false  );
        if (!empty($data_items)) 
        {
            foreach ($data_items as $kcey => $vcalue) 
            {
                $oid = $vcalue['order_master_id'];
                $data_items[$kcey]['order_id'] = en_de_crypt($oid);
            }
        }

        $purchase_product = $this->db_model->get_data_array("SELECT product_id,product_name,quantity,price,sub_total FROM order_items WHERE `user_id` = '$cid' ORDER BY item_id DESC LIMIT 10 ");


        $wish_list_products = array();
        $my_data = $this->db_model->my_where('my_cart','*',array('user_id' => $cid,'meta_key' => 'wish_list'));
        if (!empty($my_data)) {
            $my_wish = unserialize($my_data[0]['content']);
            if (!empty($my_wish)) {
                $tags = implode(',', $my_wish);

                $tags = substr($tags, 1);
                $wish_list_products = $this->db_model->get_data_array("SELECT id,product_name FROM product where `id` IN ($tags)  ORDER BY id DESC LIMIT 10");
            }
        }

        $this->mViewData['orders'] = $data_items;
        $this->mViewData['data'] = $customer[0];
        $this->mViewData['purchase_product'] = $purchase_product;
        $this->mViewData['wish_list_products'] = $wish_list_products;
        $this->Urenderadmin('customer/view','default', $page_name ='Customer details');
    }
    public function delete_customer()
    {
        $post_data=$this->request->getPost();
        if(!empty($post_data))
        {
            $c_id = en_de_crypt($post_data['c_id'],'d');
            $data = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `type` = 'user' AND `id` = '$c_id' ");
            if (!empty($data)) 
            {
                $p_data['logo'] = $data[0]['logo'];
                $p_data['name'] = $data[0]['first_name'].''.$data[0]['last_name'];
                $p_data['mobile'] = $data[0]['phone'];
                $p_data['email'] = $data[0]['email'];
                $p_data['password'] = $data[0]['password_show'];
                $p_data['uid'] = $data[0]['id'];
                $p_data['created_date'] = date('Y/m/d H:i:s');

                $this->db_model->my_delete(['id' => $c_id], 'admin_users');
                $this->db_model->my_insert($p_data,"user_account_delete");
                echo json_encode(array("status"=>true ,"message"=> "Customer deleted succssfully")); die;
            }
        }

        echo json_encode(array("status"=>false ,"message"=> "invalid request")); die;
    }

    public function user_single_notification()
    {
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $title = $post_data['title'];
            $message = $post_data['description'];
            if (empty($title)) {
                echo json_encode(array("status"=>false,"message"=> "Enter title")); die;
            }
            if (empty($message)) {
                echo json_encode(array("status"=>false,"message"=> "Enter description")); die;
            }
            $user_id = en_de_crypt($post_data['n_cust_id'],"d");

            /*Notifi fire to user*/
            $udata = $this->db_model->get_data_array("SELECT fcm_no FROM admin_users WHERE `id` = '$user_id' ");
            if ($udata) {
                $fcm_no = $udata[0]['fcm_no'];
                if (empty($fcm_no)) {
                    echo json_encode(array("status"=>false,"message"=> "No fcm is updated to send notification")); die;
                }
                $this->fcmnotification->send_fcm_message_user($user_id, $message, $title);
                echo json_encode(array("status"=>true,"message"=> "Notification fired successfully")); die;
            }
        }
        echo json_encode(array("status"=>false,"message"=>"Invalid request")); die;
    }

    public function delete_multiple_customer()
    {
        $post_data=$this->request->getPost();
        if(!empty($post_data))
        {
            $c_ids = rtrim($post_data['c_ids'],',');
            if (!empty($c_ids)) 
            {
                $c_array = explode(',', $c_ids);
                foreach ($c_array as $key => $value) 
                {
                    $c_id = en_de_crypt($value , 'd');

                    $data = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `id` = '$c_id' ");
                    if (!empty($data)) 
                    {
                        $p_data['logo'] = $data[0]['logo'];
                        $p_data['name'] = $data[0]['first_name'].''.$data[0]['last_name'];
                        $p_data['mobile'] = $data[0]['phone'];
                        $p_data['email']    = $data[0]['email'];
                        $p_data['password'] = $data[0]['password_show'];
                        $p_data['uid'] = $data[0]['id'];
                        $p_data['created_date'] = date('Y/m/d H:i:s');

                        $this->db_model->my_delete(['id' => $c_id], 'admin_users');
                        $this->db_model->my_insert($p_data,"user_account_delete");
                    }
                }

                echo json_encode(array("status"=>true ,"message"=> "All selected customer deleted succssfully")); die;
            }
            else
            {
                echo json_encode(array("status"=>false ,"message"=> "Please select atleast 1 product to delete")); die;
            }
        }

        echo json_encode(array("status"=>false ,"message"=> "invalid request")); die;
    }

}
