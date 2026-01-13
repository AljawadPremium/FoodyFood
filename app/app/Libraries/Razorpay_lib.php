<?php

namespace App\Libraries;
use App\Models\DbModel;
use \DateTime; 
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\I18n\Time;

class Razorpay_lib
{
    protected $db_model;

    function __construct()
    {  
        $this->db_model = new DbModel();
    }

    function send_payment_link($p_data = '')
    {
        // echo "<pre>";
        // print_r($p_data);
        // die;

        if (!empty($p_data)) 
        {
            $name = $p_data['name'];
            $mobile = $p_data['mobile'];
            $amount = $p_data['amount'] * 100;
            $message = $p_data['message'];
            $email = $p_data['email'];
            $display_order_id = @$p_data['display_order_id'];

            if (ctype_space($name)) {
                echo json_encode(array("status"=>false ,"message"=> "Customer name must contain some character")); die;
            }

            if(preg_match("/[a-z]/i",$mobile)) {
                echo json_encode(array("status"=>false ,"message"=> "Mobile number must contain only numbers")); die;
            }
            $count_n = strlen((string) $mobile);
            if($count_n != '10'){
                echo json_encode( array("status" => false,"message" => "Mobile number should be 10 digit only" ) );die;
            }

            $email_true = '"email": false';
            if ($email) 
            {
                if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
                    echo json_encode( array("status" => false,"message" => "Invalid email format" ) );die;
                }
                $email_true = '"email": true';
            }
            $t_date = date("d-m-Y", strtotime("+1 day"));
            $date = strtotime($t_date);
            $reference_id = strtotime(date("d-m-Y H:i:s", strtotime("+1 day")));
            $message = $message.', Remaining Dot Payment.';

            $did = '';
            if ($display_order_id) {
                $pdata['display_order_id'] = $display_order_id;
                $did = ',"purpose": "'.$display_order_id.'"';
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.razorpay.com/v1/payment_links',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>'{
              "amount": '.$amount.',
              "currency": "INR",
              "accept_partial": false,
              "first_min_partial_amount": '.$amount.',
              "expire_by": '.$date.',
              "reference_id": "'.$reference_id.'",
              "description": "'.$message.'",
              "customer": {
                "name": "'.$name.'",
                "contact": "+91'.$mobile.'",
                "email": "'.$email.'"
              },
              "notify": {
                "sms": true,
                '.$email_true.'
              },
              "reminder_enable": true,
              "notes": {
                "policy_name": "'.$message.'"
                '.$did.'
              },
              "callback_url": "",
              "callback_method": "get"
            }',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Basic cnpwX2xpdmVfNWtBUUhLR0Z3VVdiUnE6WVhEa3FCdkxJMnV4Sm1PRDBvbUoxekI1',
                'Content-Type: application/json'
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response   = json_decode($response);            

            // echo "<pre>";
            // print_r($response);
            // die;

            if (!empty($response->error)) 
            {
                $code =  $response->error->code;
                $description =  $response->error->description;
                echo json_encode( array("status" => false,"message"=> $description ) );die;
            }

            if (!empty($response->status)) 
            {
                $pdata['name'] = $p_data['name'];
                $pdata['mobile'] = $p_data['mobile'];
                $pdata['amount'] = $p_data['amount'];
                $pdata['message'] = $p_data['message'];
                $pdata['email'] = $p_data['email'];
                $pdata['reference_id'] = $response->reference_id;
                $pdata['response_status'] = $response->status;
                $pdata['response_plink_id'] = $response->id;
                $pdata['payment_url'] = $response->short_url;
                $pdata['currency'] = $response->currency;
                $pdata['payment_expired_date'] = $t_date;

                $pdata['created_date'] = date('Y/m/d H:i:s');
                $this->db_model->my_insert($pdata,"razorpay_genrate_payment_link");
                echo json_encode( array("status" => true,"message"=> "Payment Link send successfully" ) );die;
            }
        }
    }

    public function get_qr_code($did='')
    {
        $language = 'en';
        if ($did) 
        {
            $d_o_id = en_de_crypt($did,'d');
            $check = $this->db_model->get_data_array("SELECT * FROM order_master where `display_order_id` = '$d_o_id' ");
            if ($check) 
            {
                $order_status = $check[0]['order_status'];
                if ($order_status == 'canceled') {
                    echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Order is already cancelled so cant genrate qr code.'))); die;
                }
                    
                if ($check[0]['payment_status'] == 'Unpaid') 
                {
                    $folder_path = ROOTPATH.'public/razorpay/qr_code/'.$d_o_id.'.png';
                    if(file_exists($folder_path))
                    {
                        $img_url = base_url('public/razorpay/qr_code/').$d_o_id.'.png';
                        echo json_encode(array("status"=>true,"image" => $img_url ,"message" => "Success")); die;
                    }
                    else
                    {
                        $uid = $check[0]['user_id'];
                        $get_user = $this->db_model->get_data_array("SELECT email,first_name,last_name,phone,razorpay_customer_id,id FROM admin_users where `id` = '$uid' ");
                        if ($get_user) {
                            if (empty($get_user[0]['razorpay_customer_id'])) {
                                $razorpay_customer_id = $this->get_customer_id_from_razorpay($get_user);
                            }
                            else {
                                $razorpay_customer_id = $get_user[0]['razorpay_customer_id'];
                            }
                        }

                        $pdaee['uid'] = $get_user[0]['id'];
                        $pdaee['first_name'] = $get_user[0]['first_name'];
                        $pdaee['last_name'] = $get_user[0]['last_name'];
                        $pdaee['customer_id'] = $razorpay_customer_id;
                        $pdaee['order_master_id'] = $check[0]['order_master_id'];
                        $pdaee['display_order_id'] = $check[0]['display_order_id'];
                        $pdaee['order_amount'] = $check[0]['net_total'];

                        $this->get_qr_for_order($pdaee);
                    }
                }
                else {
                    echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Payment is already paid so cant genrate qr code.'))); die;
                }
            }
        }

        echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request'))); die;
    }

    public function get_qr_for_order($udata='')
    {
        $uid = $udata['uid'];
        $name = $udata['first_name'].' '.$udata['last_name'];
        $customer_id = $udata['customer_id'];

        $order_master_id = $udata['order_master_id'];
        $display_order_id = $udata['display_order_id'];
        $order_amount = $udata['order_amount'];
        $pay_amount = $order_amount*100;
                
        if (empty($name)) {
            $name = 'Test 123';
        }

        $new_time = date("Y-m-d H:i:s", strtotime('+3 hours'));
        $timestamp = strtotime($new_time);


        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.razorpay.com/v1/payments/qr_codes',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "type": "upi_qr",
            "name": "'.$name.'",
            "usage": "single_use",
            "fixed_amount": true,
            "payment_amount": '.$pay_amount.',
            "description": "Order amount '.$order_amount.' $ for order no #'.$order_master_id.'",
            "customer_id": "'.$customer_id.'",
            "close_by": '.$timestamp.',
            "notes": {
                "purpose": "'.$display_order_id.'"
            }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic cnpwX2xpdmVfNWtBUUhLR0Z3VVdiUnE6WVhEa3FCdkxJMnV4Sm1PRDBvbUoxekI1'
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $response   = json_decode($response);

        // echo "<pre>";
        // print_r($response);
        // die;

        if ($response) 
        {
            $url = $response->image_url;
            $img = ROOTPATH.('/public/razorpay/qr_code/').$display_order_id.'.png';
            file_put_contents($img, file_get_contents($url));

            $img_url = base_url('public/razorpay/qr_code/').$display_order_id.'.png';
            echo json_encode(array("status"=>true,"image" => $img_url ,"message" => "Success")); die;
        }
    }

    function payment_link_genrate_admin_check($p_data = '')
    {
        $p_data = $this->db_model->get_data_array("SELECT * FROM razorpay_genrate_payment_link WHERE `response_status` = 'created' Order BY RAND() LIMIT 5 ");
        if (!empty($p_data)) 
        {
            foreach ($p_data as $key => $value) 
            {
                $plink_id = $value['response_plink_id'];
                $id  = $value['id'];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.razorpay.com/v1/payment_links/'.$plink_id,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Basic cnpwX2xpdmVfNWtBUUhLR0Z3VVdiUnE6WVhEa3FCdkxJMnV4Sm1PRDBvbUoxekI1'
                  ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $response   = json_decode($response);

                // print_r($response);
                if (!empty($response->status == 'paid')) 
                {
                    $pdata['response_status'] = $response->status;
                    $pdata['response_order_id'] = $response->order_id;
                    $pdata['payment_method'] = $response->payments[0]->method;
                    $pdata['payment_id'] = $response->payments[0]->payment_id;
                    $pdata['payment_status'] = $response->payments[0]->status;
                    $pdata['payment_paid_created_date'] = $response->payments[0]->created_at;
                    $pdata['amount_paid'] = $response->amount_paid/100;
                    $this->db_model->my_update($pdata,array("id" => $id) ,"razorpay_genrate_payment_link");
                }
                else if (!empty($response->status == 'expired')) 
                {
                    $pdata['response_status'] = $response->status;
                    // $pdata['response_order_id'] = $response->order_id;
                    $pdata['amount_paid'] = $response->amount_paid/100;
                    $this->db_model->my_update($pdata,array("id" => $id) ,"razorpay_genrate_payment_link");
                }
            }
        }
    }

    public function get_customer_id_from_razorpay($udata='')
    {
        $uid = $udata[0]['id'];
        $name = $udata[0]['first_name'].' '.$udata[0]['last_name'];
        $email = $udata[0]['email'];
        if (empty($name)) {
            $name = 'Test 123';
        }
        if (empty($email)) {
            $name = 'test@citybhajiwala.in';
        }

        $contact = $udata[0]['phone'].'';

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.razorpay.com/v1/customers',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "name":"'.$name.'",
          "email":"'.$email.'",
          "contact":"'.$contact.'",
          "fail_existing":"1",
          "gstin":"12ABCDE2356F7GH",
          "notes":{
            "notes_key_1":"'.$uid.'",
            "notes_key_2":""
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic cnpwX2xpdmVfNWtBUUhLR0Z3VVdiUnE6WVhEa3FCdkxJMnV4Sm1PRDBvbUoxekI1'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        $response   = json_decode($response);

        if (empty(@$response->error)) {
            $update_data['razorpay_customer_id'] = $response->id;
            $this->db_model->my_update($update_data,array("id" => $uid),"admin_users");
            return $response->id;
        }
        else
        {
            return "cust_L6Itk2WgzDcWyn";
        }
    }

    public function get_customer_id_from_r_cron($udata='')
    {
        $uid = $udata['id'];
        if (empty($udata['last_name'])) {
            // $udata[0]['last_name'] = $uid;
        }

        $name = $udata['first_name'].' '.$udata['last_name'];
        $email = $udata['email'];

        $contact = $udata['phone'].'';

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.razorpay.com/v1/customers',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "name":"'.$name.'",
          "email":"'.$email.'",
          "contact":"'.$contact.'",
          "fail_existing":"1",
          "gstin":"12ABCDE2356F7GH",
          "notes":{
            "notes_key_1":"'.$uid.'",
            "notes_key_2":""
          }
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic cnpwX2xpdmVfNWtBUUhLR0Z3VVdiUnE6WVhEa3FCdkxJMnV4Sm1PRDBvbUoxekI1'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        $response   = json_decode($response);

        if (empty(@$response->error)) {
            $update_data['razorpay_customer_id'] = $response->id;
            $this->db_model->my_update($update_data,array("id" => $uid),"admin_users");  
        }
    }

    public function get_customer_all()
    {
        $min=1;
        $max=50;
        $no =  rand($min,$max);

        $url = "https://api.razorpay.com/v1/customers?count=100&skip=".$no;
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_POSTFIELDS =>'',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic cnpwX2xpdmVfNWtBUUhLR0Z3VVdiUnE6WVhEa3FCdkxJMnV4Sm1PRDBvbUoxekI1'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        $response   = json_decode($response);
        // echo "<pre>";
        // print_r($response);

        if (!empty($response)) 
        {
            foreach ($response->items as $key => $value) 
            {
                $razorpay_id = $value->id;
                $name = $value->name;
                $email = @$value->email;
                $contact = $value->contact;
                $admin_user_id = $value->notes->notes_key_1;

                $check = $this->db_model->get_data_array("SELECT * FROM razorpay_customer_get WHERE `contact` = '$contact'  ");
                if (empty($check)) 
                {
                    if(!empty($razorpay_id)) $additional_data['razorpay_id']  = $razorpay_id; 
                    if(!empty($name)) $additional_data['name']  = $name; 
                    if(!empty($email)) $additional_data['email']  = $email; 
                    if(!empty($contact)) $additional_data['contact']  = $contact; 
                    if(!empty($admin_user_id)) $additional_data['admin_user_id']  = $admin_user_id;

                    // print_r($additional_data); 
                    $this->db_model->my_insert($additional_data,"razorpay_customer_get");  
                }
            }
        }
        // if (empty(@$response->error)) {
        //     $update_data['razorpay_customer_id'] = $response->id;
        //     $this->db_model->my_update($update_data,array("id" => $uid),"admin_users");  
        // }
    }
}
?>