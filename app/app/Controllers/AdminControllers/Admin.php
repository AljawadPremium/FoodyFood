<?php
namespace App\Controllers\AdminControllers;
use App\Libraries\CommonFun;
use App\Libraries\Check_login;
use \DateTime; 

class Admin extends AdminController
{       
    protected $comf;
    protected $check_login;
    function __construct()
    {                
       $this->comf = new CommonFun();
       $this->check_login = new Check_login();
    }
    
    public function index()
    {
        if(empty($this->admin_id)) {
            return redirect()->to(base_url('admin/login'));
        }

        $type = $this->admin_data[0]['type'];
        if ($type == 'seller') {
            return redirect()->to(base_url('admin/seller/orders'));
        }

        $user_type = $this->admin_data[0]['type'];
        $un_orders = $this->db_model->get_data_array("SELECT order_master_id,display_order_id,order_datetime,net_total,payment_mode,payment_status,order_status,user_id,name,address,email,mobile_no FROM order_master WHERE `order_status` != 'delivered' AND `order_status` != 'canceled' ORDER BY order_master_id DESC limit 20");
        if (!empty($un_orders)) 
        {
            foreach ($un_orders as $key => $value) 
            {
                $order_status = $value['order_status'];
                if ($order_status == 'Pending') {
                    $un_orders[$key]['order_status'] = '<label class="mb-0 badge badge-primary" title="" data-original-title="Pending">Pending</label>';
                }
                if ($order_status == 'Packed') {
                    $un_orders[$key]['order_status'] = '<label class="mb-0 badge badge-warning" title="" data-original-title="Pending">Packed</label>';
                }
                if ($order_status == 'Ready to ship') {
                    $un_orders[$key]['order_status'] = '<label class="mb-0 badge badge-dark" title="" data-original-title="Pending">Ready to ship</label>';
                }
                if ($order_status == 'Dispatched') {
                    $un_orders[$key]['order_status'] = '<label class="mb-0 badge badge-info" title="" data-original-title="Pending">Dispatched</label>';
                }
                if ($order_status == 'delivered') {
                    $un_orders[$key]['order_status'] = '<label class="mb-0 badge badge-success" title="" data-original-title="Pending">Delivered</label>';
                }
                if ($order_status == 'canceled') {
                    $un_orders[$key]['order_status'] = '<label class="mb-0 badge badge-danger" title="" data-original-title="Pending">Canceled</label>';
                }
            
                $un_orders[$key]['order_id'] = en_de_crypt($value['order_master_id']);
                $un_orders[$key]['d_order_id'] = en_de_crypt($value['display_order_id']);
                $un_orders[$key]['order_datetime'] = date('d-m-Y H:i:s' ,strtotime($value['order_datetime'])); 
            }
        }

        // FIXED: Added all selected columns to GROUP BY for MySQL 8.0 Strict Mode
        $top_sold_monthwise = $this->db_model->get_data_array("SELECT product_id, product_name, year(created_date) as year, month(created_date) as month, monthname(created_date) as month_name, sum(sub_total) as sum, count(product_id) as count FROM order_items GROUP BY product_id, product_name, year, month, month_name ORDER BY count DESC");
        
        if (!empty($_GET['year']) || !empty($_GET['month']) || !empty($_GET['type'])) 
        {
            $top_sold_monthwise = $this->check_login->top_sold_monthwise_or_not($_GET);
        }

        $canvas_values = '';
        $canvas_record = $this->db_model->get_data_array("SELECT year(order_datetime) as year, month(order_datetime) as month, sum(net_total) as sum FROM order_master WHERE `order_status` != 'canceled' GROUP BY year, month ORDER BY year, month LIMIT 12");
        if ($canvas_record) 
        {
            foreach ($canvas_record as $key => $value) 
            {
                $monthNum  = $value['month'];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('F'); 

                $label = $value['year'].' - '.$monthName;
                $sum = $value['sum'];
                $canvas_values .= '{ label: "'.$label.'",  y: '.$sum.' },';
            }
        }

        $this->mViewData['year'] = @$_GET['year'];
        $this->mViewData['month'] = @$_GET['month'];
        $this->mViewData['type'] = @$_GET['type'];
        $this->mViewData['top_sold_monthwise'] = $top_sold_monthwise;

        $this->mViewData['top_selled'] = $this->check_login->top_selled();
        $this->mViewData['top_customer'] = $this->check_login->top_customer();

        $this->mViewData['chart_data']  = rtrim($canvas_values, ',');
        $this->mViewData['un_orders'] = $un_orders;
        $this->Urenderadmin('index','default', $page_name ='Admin Dashboard');
    }

    public function profile()
    {
        $user_type = $this->admin_data[0]['type'];
        if(empty($this->admin_id)) {
            return redirect()->to(base_url('admin/login'));
        }
        
        $data = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `id` = '$this->admin_id' ORDER BY `id` DESC");
        
        $this->mViewData['edit'] = $data[0];
        $this->Urenderadmin('profile','default', $page_name ='Profile');
    }

    public function updatess()
    {
        $user_type = $this->admin_data[0]['type'];

        $language = 'en';
        $data = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `id` = '$this->admin_id' ORDER BY `id` DESC");
        if (empty($data)) {
            echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request.'))); die;
        }

        $post_data = $this->request->getPost();
        if ($post_data) {

            $phone = $post_data['phone'];
            $password = $post_data['password'];
            $first_name = $post_data['first_name'];

            $FILES = $_FILES['profile_image'];
            $upload_dir = ROOTPATH . "/public/admin/images/logo/";
            $cat_image = $this->upload_logo($FILES,$upload_dir);
            if ($cat_image) {
                $post_data['logo'] = $cat_image;
            }

            $admin_id = $this->admin_id;
            $phone_check = $this->db_model->my_where("admin_users","*",array('phone' => $phone,'type' => $user_type,'id!=' => $admin_id),array(),"","","","", array(), "",array(),false  );
            if ($phone_check) {
                echo json_encode( array("status" => false, "message" => ($language == 'ar'? '':'Phone number already exist')) );die;
            }

            if ($password) {
                $post_data['password'] = password_hash($password, PASSWORD_BCRYPT);
                $post_data['password_show'] = $password;
            }
            else{
                unset($post_data['password']);
            }

            $old_image = $data[0]['logo'];
            if ($cat_image) 
            {
                if ($old_image) {
                    $oldPicture = $upload_dir.'/'.$old_image;
                    if (file_exists($oldPicture)) {
                        unlink($oldPicture);
                    }
                }
            }

            $this->db_model->my_update($post_data , array("id" => $admin_id),"admin_users");
            echo json_encode(array("status"=>true,"message"=>  ($language == 'ar'? '':"Profile information updated successfully"))); die;

        }
    }
    
    public function upload_logo($FILES,$upload_dir)
    {
        if (isset($FILES['name'])) {
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

    public function sales_day()
    {
        $post_data = $this->request->getPost();
        $now = date('Y-m-d' ,strtotime($post_data['s_value']));
        $total_amt = $this->db_model->get_data_array("SELECT FORMAT(COALESCE(ROUND(sum(net_total)),0),'#,0.00',0) as order_total FROM order_master WHERE order_datetime LIKE '%$now%' AND `order_status` != 'canceled' ");
        echo json_encode(array("status"=>true ,"data"=>$total_amt[0]['order_total'] ,"message" => "")); die;
    }

    public function sales_month()
    {
        $post_data = $this->request->getPost();
        $sdate = date('Y-m-d', strtotime($post_data['s_value'].' +0 days'));
        $edate = date('Y-m-d', strtotime($post_data['e_value'].' + 1 days'));
        $s_query = " AND (order_datetime > '$sdate' AND order_datetime < '$edate') ";

        $total_amt = $this->db_model->get_data_array("SELECT FORMAT(COALESCE(ROUND(sum(net_total)),0),'#,0.00',0) as order_total FROM order_master WHERE `order_status` != 'canceled' $s_query ");
        echo json_encode(array("status"=>true ,"data" => $total_amt[0]['order_total'] ,"message" => "")); die;
    }

    public function total_sale()
    {
        $total_amt = $this->db_model->get_data_array("SELECT FORMAT(COALESCE(ROUND(sum(net_total)),0),'#,0.00',0) as t_sale FROM order_master WHERE `order_status` != 'canceled' ");
        echo json_encode(array("status"=>true ,"data" => $total_amt[0]['t_sale'] ,"message" => "")); die;
    }

    public function delivered_order()
    {
        $post_data = $this->request->getPost();
        $sdate = date('Y-m-d', strtotime($post_data['s_value'].' +0 days'));
        $edate = date('Y-m-d', strtotime($post_data['e_value'].' + 1 days'));
        $s_query = " AND (order_datetime > '$sdate' AND order_datetime < '$edate') ";

        $total_amt = $this->db_model->get_data_array("SELECT COALESCE(COUNT(order_master_id),0) as order_total FROM order_master WHERE `order_status` = 'delivered' $s_query");
        echo json_encode(array("status"=>true ,"data" => $total_amt[0]['order_total'] ,"message" => "")); die;
    }

    public function canceled_order()
    {
        $post_data = $this->request->getPost();
        $sdate = date('Y-m-d', strtotime($post_data['s_value'].' +0 days'));
        $edate = date('Y-m-d', strtotime($post_data['e_value'].' + 1 days'));
        $s_query = " AND (order_datetime > '$sdate' AND order_datetime < '$edate') ";

        $total_amt = $this->db_model->get_data_array("SELECT COALESCE(COUNT(order_master_id),0) as order_total FROM order_master WHERE `order_status` = 'canceled' $s_query");
        echo json_encode(array("status"=>true ,"data" => $total_amt[0]['order_total'] ,"message" => "")); die;
    }

    public function pending_order()
    {
        $post_data = $this->request->getPost();
        $sdate = date('Y-m-d', strtotime($post_data['s_value'].' +0 days'));
        $edate = date('Y-m-d', strtotime($post_data['e_value'].' + 1 days'));
        $s_query = " AND (order_datetime > '$sdate' AND order_datetime < '$edate') ";

        $total_amt = $this->db_model->get_data_array("SELECT COALESCE(COUNT(order_master_id),0) as order_total FROM order_master WHERE `order_status` != 'canceled' AND `order_status` !='delivered' $s_query");
        echo json_encode(array("status"=>true ,"data" => $total_amt[0]['order_total'] ,"message" => "")); die;
    }

    public function total_customer()
    {
        $post_data = $this->request->getPost();
        $sdate = date('Y/m/d', strtotime($post_data['s_value'].' +0 days'));
        $edate = date('Y/m/d', strtotime($post_data['e_value'].' + 1 days'));
        $s_query = " AND (created_on > '$sdate' AND created_on < '$edate') ";

        $total_amt = $this->db_model->get_data_array("SELECT COALESCE(COUNT(id),0) as order_total FROM admin_users WHERE `id` != '' $s_query");
        echo json_encode(array("status"=>true ,"data" => $total_amt[0]['order_total'] ,"message" => "")); die;
    }

    public function total_order()
    {
        $post_data = $this->request->getPost();
        $sdate = date('Y-m-d', strtotime($post_data['s_value'].' +0 days'));
        $edate = date('Y-m-d', strtotime($post_data['e_value'].' + 1 days'));
        $s_query = " AND (order_datetime > '$sdate' AND order_datetime < '$edate') ";

        $total_amt = $this->db_model->get_data_array("SELECT COALESCE(COUNT(order_master_id),0) as order_total FROM order_master WHERE `order_status` != '' $s_query");
        echo json_encode(array("status"=>true ,"data" => $total_amt[0]['order_total'] ,"message" => "")); die;
    }

    public function test()
    {        
        $data = $this->db_model->get_data_array("SELECT id,product_image,image_gallery FROM product ORDER BY id DESC LIMIT 150");
        die;
    }
}
