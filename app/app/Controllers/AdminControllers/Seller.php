<?php
namespace App\Controllers\AdminControllers;
use App\Libraries\CommonFun;
use App\Libraries\Email_send;
use App\Libraries\Fcmnotification;
use App\Libraries\Check_login;

class Seller extends AdminController
{       
    protected $comf;
    protected $email_send;
    protected $fcmnotification;
    protected $check_login;
    function __construct()
    {                
       $this->comf = new CommonFun();
       $this->email_send = new Email_send();
       $this->fcmnotification = new Fcmnotification();
       $this->check_login = new Check_login();
    }
    
    public function listing()
    {
        // echo "<pre>";
        // print_r($this->admin_data[0]['id']);
        // die;

        $seller_id = $this->admin_data[0]['id'];
        $rowno = 0;
        $ajax = 'call';

        $post_data = $this->request->getPost();

       
        $orders = $this->db_model->get_data_array("SELECT * FROM order_invoice WHERE `seller_id` = '$seller_id' ORDER BY `invoice_id` DESC ");
        
        
        if (!empty($orders)) 
        {
            foreach ($orders as $key => $value) 
            {
                $order_id = en_de_crypt($value['order_no']);

                $order_status = $value['order_status'];
                $admin_notification = $value['admin_notification'];
                $payment_status = $value['payment_status'];
                $payment_mode = $value['payment_mode'];


                if ($payment_mode == 'cash-on-del') {
                    $orders[$key]['payment_mode'] = 'Cash';
                }
                elseif ($payment_mode == 'online') {
                    $orders[$key]['payment_mode'] = 'Online';
                }
                elseif ($payment_mode == 'bank_transfer') {
                    $orders[$key]['payment_mode'] = 'Bank T.';
                }
                
                $value['name'] = 'Girish Bhumkar';
                $name = mb_strimwidth($value['name'], 0, 12, "...");
                $orders[$key]['customer_name'] = $name;

                $orders[$key]['created_date'] = date('M j, Y, g:i a', strtotime($value['created_date']));
                
                $order_datetime = date('Y-m-d', strtotime($value['created_date']));
                $today = date("Y-m-d");
                if ($order_datetime == $today) {
                    $orders[$key]['order_datetime'] = date('g:i a', strtotime($value['order_datetime']));
                }
                else{
                    $orders[$key]['order_datetime'] = $order_datetime;
                }

                
                $invoice_id = en_de_crypt($value['invoice_id']);
                $display_order_id = en_de_crypt($value['display_order_id']);
                $orders[$key]['order_id'] = en_de_crypt($value['order_no']);
                $orders[$key]['d_order_id'] = $display_order_id;

                $url = '<a href=" '.base_url('/admin/seller/orders/view/').$invoice_id.'" target="_blank" class="btn btn-primary"><i class="fa fa-eye"></i></a> ';
                // $url .= '<a data-id="'.$order_id.'" href="javascript:void(0);" class="delete_order_listing btn btn-warning"><i class="fa fa-trash"></i></a> ';
                
                $orders[$key]['action_url'] = $url;

            }
        }

        // echo "<pre>";
        // print_r($orders);
        // die;

        $this->mViewData['orders'] = $orders;
        $this->Urenderadmin('seller/orders_listing','default', $page_name ='Orders Listing');
    }

    public function view($oid = '')
    {
        $aid = $this->admin_id;
        $oid = en_de_crypt($oid,"d");
        $orders = $this->db_model->get_data_array("SELECT * FROM order_master WHERE `order_master_id` = '$oid' ");
        if (!empty($orders)) {
            foreach ($orders as $key => $value) {
                $orders[$key]['order_id'] = en_de_crypt($value['order_master_id']);
                $orders[$key]['d_order_id'] = en_de_crypt($value['display_order_id']);
                $orders[$key]['order_datetime'] = date('d-m-Y H:i:s' ,strtotime($value['order_datetime'])); 
            }
        }
        else {
            redirect('orders/listing');
        }

        $data_items = $this->db_model->my_where('order_items','item_id,product_name,quantity,price,sub_total,product_id,tax,attribute,extra_added,extra_added_amt',array('order_no' => $oid));
                
        $product_listing = $this->db_model->get_data_array("SELECT id,product_name,sale_price FROM product WHERE `product_delete`='0' Order BY id DESC ");
        $this->db_model->my_update(array('admin_notification'=> 'seen'),array('order_master_id' => $oid),'order_master');

        $o_comment = $this->db_model->get_data_array("SELECT * FROM order_comment WHERE `oid` = '$oid' ");
        $this->mViewData['o_comment'] = $o_comment;

        $this->mViewData['product_listing'] = $product_listing;
        $this->mViewData['data_items'] = $data_items;
        $this->mViewData['orders'] = $orders[0];

        $this->mViewData['gst_number'] = "";
        $this->mViewData['staff_listing'] = array();
        
        $this->Urenderadmin('orders/order_view','default', $page_name ='Order detail');
    }

    public function get_customer()
    {
        $post_data=$this->request->getPost();
        if (!empty($post_data))
        {
            $search = $post_data['search'];
            $usersList = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `type` = 'user' AND (`first_name` LIKE '%$search%' OR `last_name` LIKE '%$search%' OR `phone` LIKE '%$search%' OR `email` LIKE '%$search%') ORDER BY id DESC LIMIT 50");
        }
        else
        {
            $usersList = $this->db_model->get_data_array("SELECT id,first_name,last_name,phone,email FROM admin_users WHERE `type` = 'user' ORDER BY id DESC limit 50 ");
        }

        $response = array();
        foreach($usersList as $key => $user){

            if ($key == 0) {
                $response[] = array(
                    "id" => '',
                    "text" => "Search customer"
                );
            }

            $response[] = array(
                "id" => $user['id'],
                "text" => $user['first_name'].' '.$user['last_name'].' ('.$user['phone'].')'
            );
        }

        echo json_encode($response);
    }

    public function payment_status_change($o_id = '')
    {
        $post_data = $this->request->getPost();
        $language = '';

        if ($o_id) 
        {
            $display_order_id = en_de_crypt($o_id,'d');
            $data = $this->db_model->get_data_array("SELECT * FROM order_master WHERE `display_order_id` = '$display_order_id' ");
            if ($data) 
            {
                $oid = $data[0]['order_master_id'];
                $payment_status = $post_data['payment_status'];                
                if (empty($payment_status)) {
                   echo json_encode(array("status"=>false,"message" => 'Invalid request')); die; 
                }

                $info['payment_status'] = $post_data['payment_status'];
                $this->db_model->my_update($info,array('order_master_id' => $oid),'order_master');
                
                $item_info['payment_status'] = $post_data['payment_status'];
                $this->db_model->my_update($item_info,array('order_no' => $oid),'order_items');
                $this->db_model->my_update($item_info,array('order_no' => $oid),'order_invoice');

                echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Payment status updated.'))); die;
            }
            else
            {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Order not found.'))); die;
            }
        }
        echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request.'))); die;
    }

    public function admin_comment($oid = '')
    {
        $language = 'en';
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $admin_note = $post_data['admin_note'];
            $o_id = en_de_crypt($oid,"d");
            $i_data['admin_note'] = $admin_note;
            $this->db_model->my_update($i_data,array('order_master_id' => $o_id),'order_master');
            echo json_encode(array("status"=>true,"message"=> "Comment updated successfully.")); die;
            
        }
    }

    public function delete_order()
    {
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $o_id = en_de_crypt($post_data['o_id'],'d');

            $orders = $this->db_model->get_data_array("SELECT product_id,quantity,order_status FROM order_items WHERE `order_no` = '$o_id' ");
            if ($orders) {
                foreach ($orders as $key => $value) {
                    $pid = $value['product_id'];
                    $quantity = $value['quantity'];
                    $order_status = $value['order_status'];
                    // Reupdate stock after delete order
                    if ($order_status != 'delivered' || $order_status != 'canceled') {
                        $check_prod = $this->db_model->get_data_array("SELECT stock FROM product WHERE `id` = '$pid' ");
                        if ($check_prod) {
                            $old_qty = $check_prod[0]['stock'];
                            $final_qty = $quantity + $old_qty;
                            $p_data['stock'] = $final_qty;
                            $p_data['stock_status'] = 'instock';
                            $this->db_model->my_update($p_data , array("id"=> $pid),"product");
                        }
                    }
                }
            }

            $this->db_model->my_delete(['order_master_id' => $o_id], 'order_master');
            $this->db_model->my_delete(['order_no' => $o_id], 'order_items');
            $this->db_model->my_delete(['order_no' => $o_id], 'order_invoice');
            echo 1;
            die;
        }else {
            echo 0;
            die;
        }
    }

    public function order_info_get($oid = '')
    {
        $oid = en_de_crypt($oid,"d");
        $orders = $this->db_model->get_data_array("SELECT * FROM order_master WHERE `order_master_id` = '$oid' ");
        if (!empty($orders)) 
        {
            $order_status = $orders[0]['order_status'];
            $display_order_id = en_de_crypt($orders[0]['display_order_id']);

            if ($order_status == 'canceled') {
                echo json_encode( array("status" => false ,"message" => 'The order has already been canceled.' ) );die; 
            }
            else if ($order_status == 'delivered') {
                echo json_encode( array("status" => false ,"message" => 'The order has been delivered.') );die; 
            }

            echo json_encode(array("status"=>true,"display_order_id"=>$display_order_id,"order_status"=>$order_status,"message"=> 'Successfully')); die;
        }
        else {
            echo json_encode(array("status"=>false,"message"=> 'Invalid order request')); die;
        } 
    }

    public function order_status_change($o_id = '')
    {
        $admin_id = $this->admin_id;

        $post_data = $this->request->getPost();
        $language = '';

        if ($o_id) 
        {
            $display_order_id = en_de_crypt($o_id,'d');
            $data = $this->db_model->get_data_array("SELECT * FROM order_master WHERE `display_order_id` = '$display_order_id' ");
            if ($data) 
            {
                $oid = $data[0]['order_master_id'];
                $order_status = $data[0]['order_status'];
                $payment_status = $data[0]['payment_status'];

                if ($order_status == 'canceled' && empty($admin_id)) {
                    echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Order is already canceled.'))); die;
                }
                if ($order_status == 'delivered' && empty($admin_id)) {
                    echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Order is already delivered.'))); die;
                }

                if ($post_data['order_status'] == 'canceled') {
                    $c_data['oid'] = $oid;
                    $check_p = $this->check_login->admin_order_cancel($c_data);
                }

                $info['order_status'] = $post_data['order_status'];
                $this->db_model->my_update($info,array('order_master_id' => $oid),'order_master');
                
                $item_info['order_status'] = $post_data['order_status'];
                $this->db_model->my_update($item_info,array('order_no' => $oid),'order_items');
                $this->db_model->my_update($item_info,array('order_no' => $oid),'order_invoice');

                $send_data['order_status'] = $post_data['order_status'];
                $send_data['display_order_id'] = $display_order_id;
                $send_data['user_id'] = $data[0]['user_id'];
               
                $this->email_send->order_email_fire($send_data);

                $order_id = en_de_crypt($oid);

                $data = $this->db_model->get_data_array("SELECT * FROM order_master WHERE `display_order_id` = '$display_order_id' ");
                $order_status = $data[0]['order_status'];
                if ($order_status == 'Pending') {
                    $data_o_status = '<label class="mb-0 badge badge-primary status_c_listing" data-id = "'.$order_id.'" title="" data-original-title="Pending">Pending</label>';
                }
                elseif ($order_status == 'Packed') {
                    $data_o_status = '<label class="mb-0 badge badge-warning status_c_listing" data-id = "'.$order_id.'" title="" data-original-title="Pending">Packed</label>';
                }
                elseif ($order_status == 'Ready to ship') {
                    $data_o_status = '<label class="mb-0 badge badge-dark status_c_listing" data-id = "'.$order_id.'" title="" data-original-title="Pending">Ready to ship</label>';
                }
                elseif ($order_status == 'Dispatched') {
                    $data_o_status = '<label class="mb-0 badge badge-info status_c_listing" data-id = "'.$order_id.'" title="" data-original-title="Pending">Dispatched</label>';
                }
                elseif ($order_status == 'delivered') {
                    
                    $add_array['delivery_date'] = date("Y-m-d H:i:s");
                    $this->db_model->my_update($add_array,array("order_master_id" => $oid),"order_master");

                    $data_o_status = '<label class="mb-0 badge badge-success status_c_listing" data-id = "'.$order_id.'" title="" data-original-title="Pending">Delivered</label>';
                }
                elseif ($value['order_cancel_reason'] != '') {
                    $data_o_status = '<label class="mb-0 badge badge-danger" title="" data-original-title="Pending">Cancelled by Cu...</label>';
                }
                elseif ($order_status == 'canceled') {
                    $data_o_status = '<label class="mb-0 badge badge-danger" title="" data-original-title="Pending">Canceled</label>';
                }

                echo json_encode(array("order_master_id"=>$oid,"data_o_status"=>$data_o_status,"status"=>true,"message" => ($language == 'ar'? '': 'Order status updated.'))); die;
            }
            else
            {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Order not found.'))); die;
            }
        }
        echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request.'))); die;
    }

    public function comment_order_notification($oid = '')
    {
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $order_comment = $post_data['order_comment'];
            $msg = "Order comment send successfully to user. ";
            $o_id = en_de_crypt($oid,"d");

            $i_data['order_comment'] = $order_comment;
            $i_data['oid'] = $o_id;
            $i_data['created_date'] = date('Y/m/d H:i:s');
            $id = $this->db_model->my_insert($i_data,"order_comment");

            /*Notifi fire to user*/
            $orders = $this->db_model->get_data_array("SELECT * FROM order_master WHERE `order_master_id` = '$o_id' ");

            $title = "Order Comment";
            $message = $order_comment;
            $user_id = $orders[0]['user_id'];

            $this->fcmnotification->send_fcm_message_user($user_id,$title,$message);

            echo json_encode(array("created_date"=>date('Y/m/d H:i:s'),"inserted_id"=> $id,"oid"=>$oid,"status"=>true,"message"=> $msg)); die;
            
        }
    }

    public function delete_order_comment()
    {
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            echo "<pre>";
            print_r($post_data);
            die;

            $c_id = $post_data['i_id'];
            $this->db_model->my_delete(array('id' => $c_id), 'order_comment');
            echo 1;
            die;
        }else {
            echo 0;
            die;
        }
    }

    public function order_payment_link($o_id = '')
    {
        if ($o_id) 
        {
            $display_order_id = en_de_crypt($o_id,'d');
            $data = $this->db_model->get_data_array("SELECT * FROM order_master WHERE `display_order_id` = '$display_order_id' ");
            if ($data) {
                $order_status = $data[0]['order_status'];
                $payment_status = $data[0]['payment_status'];

                if ($order_status == 'canceled') {
                    echo json_encode(array("status"=>false,"message" => "Order is canceled")); die;
                }
                if ($payment_status == 'Paid') {
                    echo json_encode(array("status"=>false,"message" => "Order is already Paid")); die;
                }

                $odata['net_total'] = $data[0]['net_total'];
                $odata['order_master_id'] = $data[0]['order_master_id'];
                $odata['display_order_id'] = $data[0]['display_order_id'];
                $odata['name'] = $data[0]['first_name'].' '.$data[0]['last_name'];
                $odata['email'] = $data[0]['email'];
                $odata['phone'] = $data[0]['mobile_no'];

                echo json_encode(array("status"=>true,"data"=>$odata,"message" => "")); die;
            }
        }

        echo json_encode(array("status"=>false,"message" => "Invalid request.")); die;
    }
}

