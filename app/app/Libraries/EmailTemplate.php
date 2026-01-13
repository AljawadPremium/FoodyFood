<?php

namespace App\Libraries;

use App\Models\DbModel;
use \DateTime; 
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\I18n\Time;
use App\Libraries\CommonFun;

class EmailTemplate
{
    protected $request;
    protected $comf;
    protected $db_model;

    function __construct()
    {
        $this->comf         = new CommonFun();
        $this->request      = \Config\Services::request();
        $this->db_model     = new DbModel();               
    }

	private $formEmail = 'info@persausive.in';

	public function send($toEmail,$subject,$messageBody)
	{
		$email = \Config\Services::email();
		$email->setFrom($this->formEmail, 'FoodyFood');
		$email->setTo($toEmail);
		// $email->setCC('another@another-example.com');
		// $email->setBCC('them@their-example.com');
		$email->setSubject($subject);
		$email->setMessage($messageBody);
		$email->send();
	}

    public function order_email_fire($send_data= '')
    {
        $order_status = $send_data['order_status'];
        $display_order_id = $send_data['display_order_id'];
        $user_id = $send_data['user_id'];

        $check = $this->db_model->my_where('order_email_notification','*',array('display_order_id' => $display_order_id,'order_status' => $order_status));
        if (empty($check)) 
        {
            $or_data = array();
            if ($order_status == 'Packed') { $or_data['packed_date_time'] = date('Y/m/d H:i:s'); }
            if ($order_status == 'Ready to ship') { $or_data['ready_to_ship_date_time'] = date('Y/m/d H:i:s'); }
            if ($order_status == 'delivered') { $or_data['delivered_date_time'] = date('Y/m/d H:i:s'); }
            if ($order_status == 'canceled') { $or_data['canceled_date_time'] = date('Y/m/d H:i:s'); }
            if ($or_data) {
                $this->db_model->my_update($or_data,array("display_order_id" => $display_order_id) ,"order_master");
            }

            $p_data['user_id'] = $user_id;
            $p_data['display_order_id'] = $display_order_id;
            $p_data['order_status'] = $order_status;
            $p_data['created_date'] = date('Y/m/d H:i:s');
            $this->db_model->my_insert($p_data,"order_email_notification");
            // $this->send_new_invoice($display_order_id);
        }
    }

    public function send_new_invoice($display_order_id='')
    {
        $row9 = $this->db_model->my_where('order_master','*',array('display_order_id' => $display_order_id));

        $currency = '$ ';
        $order_status               = $row9[0]['order_status'];
        $order_master_id            = $row9[0]['order_master_id'];
        $payment_status             = $row9[0]['payment_status'];
        $payment_mode               = $row9[0]['payment_mode'];
        $customer_id                = $row9[0]['user_id'];
        $sub_total                  = number_format($row9[0]['sub_total']);
        $shipping_charge            = number_format($row9[0]['shipping_charge']);
        $voucher_amount             = number_format($row9[0]['voucher_amount']);
        $wallet_amount              = number_format($row9[0]['wallet_amount']);
        $net_total                  = number_format($row9[0]['net_total'] - $row9[0]['voucher_amount']);
        $tax                        = number_format($row9[0]['tax']);

        $account_minus              = number_format($row9[0]['account_minus']);
        $account_minus_reason       = $row9[0]['account_minus_reason'];

        $order_datetime             = $row9[0]['order_datetime'];
        $users_name                 = $row9[0]['name'];
    

        $users_address  =  @$row9[0]['address'];
        // $landmark       =  @$row9[0]['city'].', '.$row9[0]['state'].', '.$row9[0]['postcode'];
        $landmark       =  "";
        $delivery_date  =  @$row9[0]['delivery_date'];
        if ($delivery_date) 
        {
            $delivery_date = date('F j, Y, g:i a', strtotime($delivery_date));
        }

        $asd = '';
        if ($order_status == 'Pending') 
        {
            $subject = "Order Accepted";
            $asd = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been accepted and should reach you soon!';
        }
        else if ($order_status == 'Packed') 
        {
            $subject = "Order Packed";
            $asd = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been packed and should reach you soon!';
        }
        else if ($order_status == 'Ready to ship') 
        {
            $subject = "Order Ready to ship";
            $asd = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been ready to ship and should reach you soon!';
        }
        else if ($order_status == 'Dispatched') 
        {
            $subject = "Order Dispatched & Invoice";
            $asd = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been dispatched and should reach you soon!';
        }
        else if ($order_status == 'delivered') 
        {
            $subject = "Order Delivered & Invoice";
            $asd = 'We just wanted to let you know that items in your Order No. '.$display_order_id.'  has been delivered !';
        }
        else if ($order_status == 'canceled') 
        {
            $subject = "Order Canceled";
            $asd = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been canceled!';
        }
        else
        {
            $subject = "Order Dispatched";
            $asd = 'We just wanted to let you know that items in your Order No. '.$display_order_id.' has been dispatched soon and should reach you !';
        }

        $p_data['display_o_id'] = $display_order_id;
        $p_data['order_id'] = $order_master_id;
        $p_data['user_id']  = $customer_id;
        $p_data['title']    = $subject;
        $p_data['message']  = $asd;

        $this->fcm_notification_send($p_data);

        // echo "<pre>";
        // print_r($row9);
        // print_r($users_details);
        // die;

        $users_phone        =   $row9[0]['mobile_no'];
        $users_email        =   $row9[0]['email'];
        $order_id           =   $row9[0]['order_master_id'];

        $product_detail = $this->db_model->my_where('order_items','*',array('order_no' => $order_id));
        $count = count($product_detail);
        $new_html_loop = '';
        foreach ($product_detail as $key1 => $value1)
        {
            $attribute = $value1["attribute"];
            if (!empty($attribute))
            {
                $product_name = $value1["product_name"].' ('. $attribute .')' ;
            }
            else
            {
                $product_name = $value1["product_name"];
            }

            $product_cust_data = '';

            if (!empty($value1['product_cust_data']))
            {
                foreach ($value1['product_cust_data'] as $pkey => $pvalue)
                {
                    if ($pvalue['price'] == '0')
                    {
                        $c_price = 'Free';
                    }
                    else
                    {
                        $c_price = $pvalue['price'].' '.$currency;
                    }
                    $product_cust_data.='<p>'.$pvalue['name'].' :- '.$c_price.'</p>';
                }
            }

            $p_info =  $this->db_model->my_where('product','*',array('id' => $value1['product_id']));
            // $product_name =  implode(' ', array_slice(str_word_count($product_name, 2), 0, 4));

            $key1 = $key1 + 1;
            $new_html_loop.='<tr><td style="font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 1px 10px 5px 10px;">'.$key1.'. '.$product_name.' ( '.$value1['quantity'].' * '.$value1['price'].' '.$currency.')</td>';
            $new_html_loop.='<td style="text-align: right;font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 1px 10px 5px 10px;"> ' .$currency.''.number_format($value1['price']  * $value1['quantity']) .' </td></tr>';

            // $new_html_loop.='<tr style="font-size:15px; line-height: 30px; ">';
            //     $new_html_loop.='<td style="text-align: left;    width: 50%;">
            //              '.$product_name.'';
            //     $new_html_loop.='</td>'; 
            //     $new_html_loop.='<td>
            //                '.$value1['quantity'].' * '.$value1['price'].' '.$currency;
            //     $new_html_loop.='</td>';
            //     $new_html_loop.='<td style="">
            //              '.number_format($value1['price']  * $value1['quantity']) .' ' .$currency.' ';
            //     $new_html_loop.='</td>';
            // $new_html_loop.='</tr>';
        }

        $voucher_label = $wallet_label = $account_minus_label = '';
        if ($voucher_amount) 
        {
            $voucher_label.='<tr>';
                $voucher_label.='<td width="75%" align="left" style="font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> VOUCHER AMOUNT </td>';
                $voucher_label.='<td width="25%" align="left" style="text-align: right;font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">' .$currency.' '.$voucher_amount.' </td>';
            $voucher_label.='</tr>';
        }
        if ($wallet_amount) 
        {
            $wallet_label.='<tr>';
                $wallet_label.='<td width="75%" align="left" style="font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> WALLET AMOUNT </td>';
                $wallet_label.='<td width="25%" align="left" style="text-align: right;font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">' .$currency.' '.$wallet_amount.' </td>';
            $wallet_label.='</tr>';
        }
        if ($account_minus) 
        {
            $account_minus_label.='<tr>';
                $account_minus_label.='<td width="75%" align="left" style="font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> PREVIOUS FINE AMOUNT ('.$account_minus_reason.') </td>';
                $account_minus_label.='<td width="25%" align="left" style="text-align: right;font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">' .$currency.' '.$account_minus.' </td>';
            $account_minus_label.='</tr>';
        }
        // echo $new_html_loop;
        // die;

        $invoice_url = base_url('invoice/pdf/').en_de_crypt($order_id);
        $message = '<!DOCTYPE html>
                    <html  >
                       <head>
                          <title>Index</title>
                       </head>
                       <body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">
                            <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: initial; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
                                For what reason would it be advisable for me to think about business content? That might be little bit risky to have crew member like them.
                            </div>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; text-transform: uppercase;">
                                            <tr>
                                                <td align="center" valign="top" style="font-size:0; padding: 15px;padding-bottom: 0px;" bgcolor="#fff">
                                                    <div style="display:inline-block; max-width:100%; min-width:100px; vertical-align:top; width:100%;">
                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:100%;">
                                                            <tr>
                                                                <td align="center" valign="top" style="font-family: initial; font-size: 36px; font-weight: 800; " class="mobile-center">
                                                                    <img style="width:200px;" src="'.base_url().'/public/frontend/img/logo/logo.png" alt="">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;" class="mobile-hide">
                                                       
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding: 15px 35px 20px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                                                        <tr>
                                                            <td align="left" style="font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                                                                <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">'.$asd.'</p>
                                                            </td>
                                                        </tr>
                                                        <tr style="position: relative;bottom: 15px;">
                                                            <td width="100%" align="left" style=" font-weight: 800;text-align: center;    margin-top: 20px;display: block;">
                                                                <a target="_blank" href = "'.$invoice_url.'">Download Invoice</a>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td align="left" style="padding-top: 20px;">
                                                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                                    <tr style="position: relative;bottom: 15px;">
                                                                        <td width="75%" align="left" bgcolor="#eeeeee" style="font-family: initial; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> Order Id # </td>
                                                                        <td width="25%" align="left" bgcolor="#eeeeee" style="font-family: initial; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;"> '.$display_order_id.' </td>
                                                                    </tr>
                                                                    '.$new_html_loop.'
                                                                    <tr>
                                                                        <td width="75%" align="left" style="font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;"> PURCHASED ITEMS ('.$count.') </td>
                                                                        <td width="25%" align="left" style="text-align: right;font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">  ' .$currency.' '.$sub_total.' </td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                        <td width="75%" align="left" style="font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> SUBTOTAL </td>
                                                                        <td width="25%" align="left" style="text-align: right;font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">' .$currency.' '.$sub_total.'  </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="75%" align="left" style="font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> DELIVERY CHARGE </td>
                                                                        <td width="25%" align="left" style="text-align: right;font-family: initial; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;"> ' .$currency.' '.$shipping_charge.'  </td>
                                                                    </tr>

                                                                    '.$voucher_label.'
                                                                    '.$wallet_label.'
                                                                    '.$account_minus_label.'
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" style="padding-top: 20px;">
                                                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                                    <tr>
                                                                        <td width="75%" align="left" style="font-family: initial; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;"> TOTAL </td>
                                                                        <td width="25%" align="left" style="text-align: right;font-family: initial; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">' .$currency.' '.$net_total.' </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding: 0 35px 35px 35px;background-color: #ffffff;">
                                                    <span style="font-weight: 800;">Delivery Address - 
                                                        <span style="font-family: initial;font-size: 16px;font-weight: 400;display: block;">'.$users_address.' '.$landmark.' </span>
                                                    </span>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </body>
                    </html>';

        // echo "<pre>";
        // print_r($users_email);
        // echo "GRB";
        // print_r($message);
        // die;

        $users_email = 'girish@persausive.com';
        // $subject .= " GRB";
        $this->send($users_email,$subject,$message);
    }

    public function forget_email_en($first_name,$link,$subject='')
    {
        $html_tag='';
        $html_tag.='<!DOCTYPE html>';
        $html_tag.='<html>';
            $html_tag.=' <head><title>Index</title></head>';
            $html_tag.='<style>
                      html, body{
                      padding:0px;
                      margin:0px;
                      font-family: arial;
                      font-size: 14px;
                      }
                      div{
                      box-sizing: border-box;
                      }
                      .row_padng td{
                      padding:10px 0px;
                      }
                   </style>';

            $html_tag.='<body>
                          <div style="text-align: center; background: #f3f3f3; " >
                             <div style="width: 750px; background: #fff; box-shadow: 0px 0px 4px 1px #cccccc25; display: inline-block; margin: 20px 0px; padding: 0px 15px 10px 15px; border-radius: 8px; border-top: 5px solid #185faa; border-bottom: 5px solid #185faa; " >
                                <div style="padding:10px 0px;">
                                   <img src="'.base_url().'/public/frontend/img/logo/logo.png'.'" style="width: 250px; margin-top: 30px; margin-bottom: 10px; " >
                                </div>
                                <div style="float: left;width: 100%; text-align: center;  " >
                                   <div style="width: 100%;">
                                      <div style="float: left; width:100%; text-align: center; font-weight: 600; line-height: 20px; font-size: 18px; " >
                                         '.$subject.'                    
                                      </div>                  
                                   </div>
                                </div>

                                <div style="float: right;width: 100%; text-align: center;  " >
                                   <div style="width: 100%;">
                                      <div style="float: left; width:100%; text-align: center; line-height: 20px; padding:0px 20px; text-align:center; " >
                                         <div style="font-weight: 600; margin-top:30px; text-align:center; font-size: 16px; " >
                                         Dear '.$first_name.',
                                         </div>
                                         
                                         <div style="margin-top: 13px; font-size: 17px; font-weight: 500; line-height: 18px; margin-bottom: 20px; display: inline-block;     margin-top: 20px; " >
                                         
                                            We\'ve received a request to reset your password. If you didn\'t make the request, just ignore this email.
                                             <br>Otherwise, you can reset your password using this link.  <br>

                                            <div style="margin-top: 13px;">
                                               <a href="'.$link.'" style="background: #185faa; margin-left: 2px; margin-right: 2px; padding: 3px 7px; border-radius: 4px; color: #fff; cursor: pointer; text-decoration: none; font-size: 12px;" >RESET PASSWORD</a>
                                            </div>

                                            <div  style="margin-top: 10px; font-weight: 600; margin-top: 25px; line-height: 23px;">
                                               Regards,
                                               <div style=" font-size: 18px; margin-top: 2px; margin-bottom: 6px; ">
                                                  <a style="text-decoration: none; color: #185faa;" target="_blank" href="'.base_url().'">Bom bkra</a>
                                               </div>
                                            </div>
                                         </div>                  
                                      </div>
                                   </div>
                                </div>   

                                <div style="clear:both;"></div>          
                             </div>
                          </div>
                        </body>';      
        $html_tag.='</html>';
        return $html_tag;
    }
    public function fcm_notification_send($p_data = '')
    {
        // Show notification data in website/Application that fired through firebase
        // $p_data['type'] = 'Pending';
        // $p_data['created_date'] = date('Y/m/d H:i:s');
        // $this->db_model->my_insert($p_data,'user_notification');
    }
}

?>