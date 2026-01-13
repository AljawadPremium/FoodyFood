<?php

namespace App\Libraries;
use App\Models\DbModel;
use \DateTime; 
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\I18n\Time;
use App\Libraries\Email_send;

class Stripe_lib
{
    protected $db_model;
    protected $email_send;

    function __construct()
    {
        $this->email_send  = new Email_send();
        $this->db_model = new DbModel();
    }

    public function check_stripe_webhook($send_data = '')
    {
        // echo "<pre>";
        // print_r($send_data);
        // die;

        if ($send_data) 
        {
            if (!empty($send_data['payment_id'])) 
            {
                $payment_id = $send_data['payment_id'];
                $order_id = $send_data['order_id'];
                $webhook_id = @$send_data['webhook_id'];

                $secretKey = 'sk_test_51PaY1vRxqwM6qTPuABkVkwlP6Ok7FWbMNXLH0d1s7JFU4tOlNcJzPH34JGbMEiUtqAWxzUYYsCxMpZS8qxfD4Nog00aC3blubY';

                // Initialize cURL
                $ch = curl_init();

                // Set the cURL options
                curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/payment_intents/" . $payment_id);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                curl_setopt($ch, CURLOPT_USERPWD, $secretKey . ":");

                // Execute the cURL request and get the response
                $response = curl_exec($ch);

                // Check for errors in the cURL request
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                    curl_close($ch);
                    exit;
                }

                // Close the cURL session
                curl_close($ch);

                // Decode the JSON response
                $paymentIntent = json_decode($response, true);

                // echo "<pre>";
                // print_r($paymentIntent);
                // die;

                $status = '';
                // Check the status of the PaymentIntent
                if (isset($paymentIntent['status'])) {
                    if ($paymentIntent['status'] == 'succeeded') {
                        $msg = "Payment was successful!";
                        $status = 'success';
                        // echo json_encode( array("status" => true ,"message" => $msg ) );die;
                    } else {
                        $status = 'fail';
                        $msg = "Payment not successful. Status: " . $paymentIntent['status'];
                        // echo json_encode( array("status" => false ,"message" => $msg ) );die;
                    }
                } else {
                    $status = 'error';
                    $msg = "Error: Unable to retrieve payment status.";
                    // echo json_encode( array("status" => true ,"message" => $msg ) );die;
                }

                if ($status == 'success') 
                {
                    date_default_timezone_set('Asia/Kolkata');
                    $i_data['payment_id'] = $paymentIntent['id'];
                    $i_data['payment_status'] = $paymentIntent['status'];

                    $info = $this->db_model->get_data_array("SELECT user_id,display_order_id,net_total,email,mobile_no FROM order_master WHERE `display_order_id` = '$order_id' ");
                    
                    if (empty($info)) {
                        return false;
                    }
                    
                    $user_id = $info[0]['user_id'];
                    $net_total = $info[0]['net_total'];

                    $i_data['user_id'] = $user_id;
                    $i_data['display_order_id'] = $order_id;
                    $i_data['user_email'] = $info[0]['email'];
                    $i_data['user_phone'] = $info[0]['mobile_no'];
                    $i_data['paid_amt'] = $paymentIntent['amount']/100;
                    $i_data['order_amt'] = $net_total;
                    $i_data['created_at'] = date('Y-m-d H:i:s', $paymentIntent['created']);

                    // print_r($info);
                    // print_r($i_data);
                    // die;

                    $check = $this->db_model->get_data_array("SELECT payment_id FROM transaction_details where `payment_id` = '$payment_id' ");
                    if (empty($check)) {
                        $this->db_model->my_insert($i_data,'transaction_details');
                    }

                    if (!empty($webhook_id)) {
                        $web["api"]     = "WEBHOOK_DONE";
                        $this->db_model->my_update($web,array('id' => $webhook_id),'json_request');
                    }

                    if ($paymentIntent['status'] == 'succeeded' || $paymentIntent['status'] == 'captured' ) {
                        if (!empty($info)) {
                            $updata["online_unpaid_check"]   = "Paid";
                            $updata["payment_status"]   = "Paid";
                            $updata["payment_mode"]     = "online";
                            $this->db_model->my_update($updata,array('display_order_id' => $order_id),'order_master');

                            /*Send notifi and mail about order*/
                            $send_data['order_status'] = "Pending";
                            $send_data['display_order_id'] = $order_id;
                            $send_data['user_id'] = $user_id;
                            $this->email_send->order_email_fire($send_data);

                            $this->db_model->my_delete(['user_id' => $user_id,"meta_key" => 'cart'], 'my_cart');
                        }
                    }
                }
            }
        }
    }

    public function genrate_stripe_url($display_order_id='')
    {
        $random = $this->generateRandomString();
        $order = $this->db_model->my_where("order_master","*",array("display_order_id" => $display_order_id) );

        $name = $order[0]['name'];
        $email = $order[0]['email'];

        $price = $order[0]['net_total']*100;
        $uid = $order[0]['user_id'];

        $currency = "USD";

        $title = '10/10 Food Eat';
        $description = 'An Independently Run, Natural & Organic Food Store. From Organic Food to Organic Wine. Eco-Friendly House Hold Products to Refills.';
        
        $dec_uid = en_de_crypt($uid);   
        $d_order_id = en_de_crypt($display_order_id);   

        $CURLOPT_POSTFIELDS = [
            'customer_email'=>$email,
            'payment_method_types' => ['card'],
                'line_items' => [[ 
                    'price_data' => [ 
                        'product_data' => [ 
                            'name' => $title,
                            'description' => $description,
                            'images' => [base_url('public/admin/images/logo.png')],
                            'metadata' => [ 
                                'pro_id' => "1" 
                            ] 
                        ], 
                        'unit_amount' => $price, 
                        'currency' => $currency, 
                    ], 
                    'quantity' => 1 
                ]],
            'mode' => 'payment', 
            'success_url' => base_url('stripe/success/'.$dec_uid.'/'.$d_order_id.'/'.$random),
            'cancel_url' => base_url('stripe/cancel/'.$dec_uid.'/'.$d_order_id.'/'.$random),        
        ];

        // echo "<pre>";
        // print_r($CURLOPT_POSTFIELDS);
        // die;

        $service_url = 'https://api.stripe.com/v1/checkout/sessions';
        $curl = curl_init($service_url);                                                            
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // curl_setopt($curl, CURLOPT_USERPWD, "sk_live_5CMh7vz10SQUdmDFaPGnYz3W00Wyq8JKcl"); //Your credentials goes here
        // pk_test_51PaY1vRxqwM6qTPuFpV4MoCG1DPsuUO8BjgKt1jUpRWLGiDZIYjdSTi3Qw3eFkSjeHOszSRAIGcrqp8BOjImV9hd00Abov0TEE
        curl_setopt($curl, CURLOPT_USERPWD, "sk_test_51PaY1vRxqwM6qTPuABkVkwlP6Ok7FWbMNXLH0d1s7JFU4tOlNcJzPH34JGbMEiUtqAWxzUYYsCxMpZS8qxfD4Nog00aC3blubY");

        //Your credentials goes here
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($CURLOPT_POSTFIELDS));
        $resp = curl_exec($curl);
        parse_str($resp, $output);
        curl_close($curl);              
        $resp = json_decode($resp);

        // echo "<pre>";
        // print_r($resp);
        // die;

        if(isset($resp->error))
        {
            $msg = $resp->error->message;
            echo json_encode(array("status" => false,"message"=> $msg )); die;
        }
        else 
        {
            $t_data['transaction_id'] = $resp->id;
            $t_data['order_amt'] = $resp->amount_total/100;
            $t_data['created_at'] = date("Y-m-d H:i:s");
            $t_data['random'] = $random;
            $t_data['display_order_id'] = $display_order_id;
            $t_data['user_id'] = $uid;


            $this->db_model->my_insert($t_data,'transaction_details');


            // $udata['trans_id'] = $resp->id;
            // $this->db_model->my_update($udata,array('display_order_id' => $display_order_id),'order_master');

            $url = $resp->url;
            return $url;

            // $msg = "Please wait, we are sending you to payment page.";
            // echo json_encode(array("status" => true,"message"=> $msg,"redirect"=> $url )); die;
        }
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

?>