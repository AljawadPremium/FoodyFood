<?php

namespace App\Controllers\FrontEnd;
use App\Libraries\EmailTemplate;
use App\Libraries\CommonFun;
use App\Libraries\Check_login;

class Stripe extends FrontController
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

    public function genrate_stripe_url($post_data='')
    {
        $name = "GIrish Bhumkar";
        $email = "girishbhumkar5@gmail.com";
        $price = "10000";
        $random_id = "100";
        $uid = "1";

        $currency = "USD";

        $title = '10/10 Food Eat';
        $description = 'An Independently Run, Natural & Organic Food Store. From Organic Food to Organic Wine. Eco-Friendly House Hold Products to Refills.';
        $dec_uid = en_de_crypt($uid);   

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
            'success_url' => base_url('stripe/success/'.$dec_uid.'/'.$random_id),
            'cancel_url' => base_url('stripe/cancel/'.$dec_uid.'/'.$random_id),        
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

        if(isset($resp->error))
        {
            $msg = $resp->error->message;
            echo json_encode(array("status" => false,"message"=> $msg )); die;
        }
        else 
        {
            $url = $resp->url;

            echo $url; die;

            // transaction_details

            $t_data['transaction_id'] = $resp->id;
            $t_data['amount'] = $resp->amount_total/100;
            $t_data['created_date'] = date("Y-m-d H:i:s");
            $t_data['user_id'] = $uid;
            $t_data['sub_month'] = $month;
            $t_data['plan_name'] = $plan_name;
            $t_data['currency'] = "USD";

            $created_on = date("Y-m-d H:i:s");
            $today = date("Y-m-d");
            $end_date = date('Y-m-d', strtotime('+'.$month.' months'));

            $subs_start_date    =  $today;
            $subs_end_date      =  $end_date;

            $t_data['start']  = $subs_start_date;
            $t_data['end']    = $subs_end_date;

            $this->db_model->my_insert($t_data,'transaction_details');


            $msg = "Please wait, we are sending you to payment page.";
            echo json_encode(array("status" => true,"message"=> $msg,"redirect"=> $url )); die;
        }
    }

    public function payment_success($uid='',$display_order_id='',$random='')
    {
        if (!empty($uid) && !empty($display_order_id)) {
            $user_id = en_de_crypt($uid,'d');
            $display_order_id = en_de_crypt($display_order_id,'d');

            $check = $this->db_model->my_where("order_master","*",array('user_id' => $user_id,'display_order_id' => $display_order_id));
            $trans = $this->db_model->my_where("transaction_details","*",array('user_id' => $user_id,'random' => $random));

            // echo "<pre>";
            // print_r($trans);
            // die;

            if(!empty($trans)) 
            {
                $did = $trans[0]['display_order_id'];
                $transaction_id = $trans[0]['transaction_id'];
                $uid_d = en_de_crypt($uid,'d');
                $display_order_id = en_de_crypt($display_order_id,'d');
                

                // $transaction_id = "cs_test_a1f6Z2Nqiv51bZRXGWRyyGMpdWenGNaJCtMMuSEaeJe6IsgKVykKEoYdeQ";

                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.stripe.com/v1/checkout/sessions/'.$transaction_id,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Basic c2tfdGVzdF81MVBhWTF2Unhxd002cVRQdUFCa1Zrd2xQNk9rN0ZXYk1OWExIMGQxczdKRlU0dE9sTmNKelBIMzRKR2JNRWlVdHFBV3h6VVlZc0N4TXBaUzhxeGZENE5vZzAwYUMzYmx1Ylk6'
                  ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $response = json_decode($response, true);
                
                // echo "<pre>";
                // print_r($response);
                // die;

                if($response['status'] != 'complete')
                {                    
                    // $transaction_data['error_message']=$response->error->message;
                    // $transaction_data['error_type']=$response->error->type; 
                    // $transaction_data['is_update']=1;
                    // $update=$this->db_model->my_update($transaction_data,array('user_id'=>$uid_d,'order_id'=>$order_id_d),'transaction_details');   
                    // $url_re= 'stripe/payment-error/'.$uid.'/'.$order_id;
                    return redirect()->to(base_url($url_re));                   
                }
                else
                {                    
                    $transaction_data['payment_id'] = $response['payment_intent'];  
                    $transaction_data['paid_amt'] = $response['amount_total']/100;  
                    $transaction_data['payment_status'] = $response['payment_status'];                   
                    $transaction_data['user_email'] = $response['customer_details']['email'];                   

                    $update = $this->db_model->my_update($transaction_data,array('random' => $random),'transaction_details');

                    $a_data['payment_status'] = 'Paid';
                    $a_data['online_unpaid_check'] = '';
                    $this->db_model->my_update($a_data,array('display_order_id' => $did),'order_master');

                    $url_re = base_url('thank_you/'.$did);

                    $this->db_model->my_update(array('content' => ''),array('user_id' => $uid_d,'meta_key' => 'cart'),'my_cart');

                    // echo $uid;
                    // echo ">>";
                    // echo $url_re; die;
                    // die;

                    return redirect()->to($url_re);                             
                }               
            }
            else {
                return redirect()->to(base_url(''));
            }
        }
        else {
            return redirect()->to(base_url(''));
        }
    }

    public function payment_cancel($uid='',$display_order_id='',$random='')
    {
        if (!empty($uid) && !empty($display_order_id)) {
            $user_id = en_de_crypt($uid,'d');
            $display_order_id = en_de_crypt($display_order_id,'d');

            $check = $this->db_model->my_where("order_master","*",array('user_id' => $user_id,'display_order_id' => $display_order_id));
            $trans = $this->db_model->my_where("transaction_details","*",array('user_id' => $user_id,'random' => $random));

            // echo "<pre>";
            // print_r($trans);
            // die;

            if(!empty($trans)) 
            {
                $did = $trans[0]['display_order_id'];
                $transaction_id = $trans[0]['transaction_id'];
                $uid_d = en_de_crypt($uid,'d');
                $display_order_id = en_de_crypt($display_order_id,'d');
                

                // $transaction_id = "cs_test_a1f6Z2Nqiv51bZRXGWRyyGMpdWenGNaJCtMMuSEaeJe6IsgKVykKEoYdeQ";

                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.stripe.com/v1/checkout/sessions/'.$transaction_id,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'GET',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Basic c2tfdGVzdF81MVBhWTF2Unhxd002cVRQdUFCa1Zrd2xQNk9rN0ZXYk1OWExIMGQxczdKRlU0dE9sTmNKelBIMzRKR2JNRWlVdHFBV3h6VVlZc0N4TXBaUzhxeGZENE5vZzAwYUMzYmx1Ylk6'
                  ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $response = json_decode($response, true);
                
                // echo "<pre>";
                // print_r($response);
                // die;

                if($response['payment_status'] == 'unpaid')
                {                    
                    $transaction_data['payment_status'] = "unpaid";
                    $update = $this->db_model->my_update($transaction_data,array('random' => $random),'transaction_details');

                    $url_re = base_url('payment/cancel/'.$did.'/'.$random);
                    return redirect()->to($url_re);                   
                }          
            }
            else {
                return redirect()->to(base_url(''));
            }
        }
        else {
            return redirect()->to(base_url(''));
        }
    }
}