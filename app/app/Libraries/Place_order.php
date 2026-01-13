<?php

namespace App\Libraries;
use App\Models\DbModel;
use \DateTime; 
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\I18n\Time;
use App\Libraries\EmailTemplate;
use App\Libraries\Fcmnotification;
use App\Libraries\Check_login;

class Place_order
{
    protected $db_model;
    protected $EmailTemplate;
    protected $fcmnotification;
    protected $email_send;
    protected $check_login;

    function __construct()
    {
        $this->db_model = new DbModel();
        $this->email_send = new EmailTemplate();
        $this->check_login = new Check_login();
        $this->fcmnotification  = new Fcmnotification();
    }

    public function create_order($post_arr, $products, $uid)
    {
        // echo "<pre>";
        // print_r($post_arr);
        // print_r($products);
        // die;
        
        $address_id = $post_arr['address_id'];
        $tip_amount = $post_arr['tip_amount'];
        if (empty($tip_amount)) {
            $tip_amount = 0;
        }

        $account_minus = @$post_arr['account_minus'];
        if (empty($account_minus)) { $account_minus = 0; }
        
        $wallet_amount = @$post_arr['wallet_amount'];
        $voucher_amount = @$post_arr['voucher_amount'];
        if (empty($voucher_amount)) {
            $voucher_amount = $post_arr['voucher_amount'] = 0;
        }
        if ($wallet_amount) {
            $w_amt = $this->check_login->view_cart_deta($uid,'yes',$voucher_amount,$address_id);
            $post_arr['wallet_amount'] = $w_amt['price_summary']['used_wall_amt'];
        }
        else{
            $post_arr['wallet_amount'] = $wallet_amount = 0;
        }


        $digits = 4;
        $number =  rand(pow(10, $digits-1), pow(10, $digits)-1);
        // $number =  '1234';

        $post_arr['pickup_code']    =  $number;
        

        $data = array();
        if (!empty($post_arr))
        {
            if (!empty($products ))
            {
                $product_w = 0;
                // $post_arr['delivery_date']   = $this->order_datetime ;
                $post_arr['delivery_date']  = '' ;
                $post_arr['net_total'] = "0";
                $post_arr['sub_total'] = "0";
                

                $p_arr = $cart_data = $this->check_login->view_cart_deta($uid,"","",$address_id);
                $check_values = $p_arr['price_summary'];
                $distance = $check_values['distance'];
                $shipping_amount = $check_values['shipping_amount'];
                $tax_percentage = $check_values['tax_percentage'];
                $tax = $check_values['tax_percentage'];

                $post_arr['shipping_charge'] =  $shipping_amount;
                $post_arr['tax_percentage'] = $tax;

                // echo "<pre>";
                // print_r($check_values);
                // die;

                if($post_arr['payment_mode'] == 'cash-on-del')
                {
                    $post_arr['payment_status'] = 'Unpaid';
                }
                else {
                    $post_arr['payment_status'] = 'Unpaid';
                    $post_arr['online_unpaid_check'] = 'pending';
                }


                $post_arr['user_id']        = $uid;
                $post_arr['order_datetime'] = date('Y-m-d H:i:s');

                // echo "<pre>";print_r($post_arr);die;
                $oid = $this->db_model->my_insert($post_arr,'order_master');
                            
                // insert in order_items
                $invoice = $itesmval = $prd_cat  = array();
                $sub_total1 = $net_total1 = $tax1 =0;
                

                // echo "<pre>";
                // print_r($products);
                // die;

                $saved_amt =  0;
                foreach ($products as $key => $value) {
                    $item = array();
                    $pid = $value['pid'];
                    $curr = $this->db_model->my_where('product','id,category,product_name,sale_price,price,product_image,stock,price_select,seller_id,tax,product_weight,type_qty_piece_name',array('id'=>$pid));

                    $product_extra = '';
                    $added_ex_amt = 0;
                    $extra_id = $value['comment'];
                    if ($extra_id) {
                        $added_data = $this->db_model->get_data_array("SELECT name,price FROM `product_custimze_details` WHERE `id` IN ($extra_id) ");
                        if ($added_data) 
                        {
                            $product_extra = '';
                            foreach ($added_data as $wkey => $wvlue) 
                            {
                                $product_extra.= $wvlue['name'].'-'.$wvlue['price'].",--";
                                if ($wvlue['price'] == '') {
                                    $wvlue['price'] = 0;
                                }
                                $added_ex_amt += $wvlue['price'];
                            }
                        }
                    }

                    $type_qty_piece_name       = $curr[0]['type_qty_piece_name'];
                    $s_price    = $curr[0]['price'];
                    $sale_price = $curr[0]['sale_price'];
                    $product_weight = $curr[0]['product_weight'];

                    if (empty($product_weight)) {
                        $product_weight = 0.1;
                    }

                    $product_w += floor( $product_weight * $value['qty']);
                    $saved_amt += ( $s_price - $sale_price ) * $value['qty'];

                    // $tax = $curr[0]['tax'];

                    $data['remove_pr'][] = $curr[0]['id'];


                    $prd_cat[] = $curr[0]['category'];
                    if(isset($value['metadata']) && !empty($value['metadata']))
                    {
                        $item_id = $value['metadata']['item_id'];
                        $cdata = $this->db_model->my_where('product_attribute','*',array('item_id'=>$item_id, 'p_id'=>$pid));
                        $price  =   $cdata[0]['sale_price'];
                        $item['attribute'] = 'Size-'.$value['metadata']['size'];
                    }
                    else
                    {
                        $price = $curr[0]['sale_price'];
                        if ($curr[0]['price_select'] == 3) {
                            $get_price = $this->check_login->product_sale_price_get($value['pid'],$uid);
                            $price   = $get_price['sale_price'];
                        }
                    }

                    // die;

                    $item['extra_added_amt'] = $added_ex_amt;
                    $item['extra_added'] = $product_extra;

                    $item['order_no'] = $oid;
                    $item['user_id'] = $uid;
                    $item['product_id'] = $value['pid'];
                    $item['price'] = $price;
                    $item['seller_id'] = $curr[0]['seller_id'];

                    $data['product'][$key]['quantity'] = $item['quantity'] = $value['qty'];
                    $data['product'][$key]['name'] = $item['product_name'] = $curr[0]['product_name'];
                    $data['product'][$key]['price'] = $price;
                    // $data['product'][$key]['sale_price'] = $price;
                    $data['product'][$key]['product_image'] = $curr[0]['product_image'];
                    
                    $itemtax = 0;
                    if(!empty($tax)) $itemtax = round( $price * $value['qty'],'2' ) * ( $tax / 100);
                    
                    $tax1 += $itemtax;

                    $item['sub_total']      = floor( $price * $value['qty'] );
                    $item['tax']            = $itemtax;
                    $item['tax_percentage'] = $tax;
                    
                    // $item['shipping_cost']   = $post_arr['shipping_charge'];
                    $item['payment_status'] = $post_arr['payment_status'];
                    $item['payment_mode']   = $post_arr['payment_mode'];
                    $item['delivery_date']  = $post_arr['delivery_date'];
                    $item['order_status']   = 'pending';
                    $item['created_date']   = date('Y-m-d H:i:s');
                    $item['product_unit']   = $type_qty_piece_name;
                    
                    

                    $item_id = $this->db_model->my_insert($item,'order_items');

                    // reduce quantity from stock
                    $update['stock'] = $curr[0]['stock'] - $value['qty'];

                    if ($update['stock'] == 0 || $update['stock'] < 0)
                    {
                        $update['stock_status'] = 'notinstock';
                        $update['stock']        = '0';
                    }

                    $this->db_model->my_update($update,array('id' => $value['pid']), 'product');

                    $item['product_image']  = $curr[0]['product_image'];
                    $item['mrp']            = $price;
                    // $item['vender_email']    = $curr1[0]['email'];
                    $item['category']       = $curr[0]['category'];
                    $itesmval[$item_id]     = $item;

                    $invoice_seller_id  = $curr[0]['seller_id'];
                    $invoice[$invoice_seller_id]['order_no']    = $oid;
                    $invoice[$invoice_seller_id]['items'][]     = $item_id;
                    $invoice[$invoice_seller_id]['commision']   = $tax;

                    $sub_total1 = round( $sub_total1 + $item['sub_total'],'2' );
                   
                    $percentage = $tax;
                    $totalWidth = $sub_total1;


                    $percentage_amt = 0;
                    if ($percentage > 0) {
                        $percentage_amt = ($percentage / 100) * $totalWidth;
                    }
                    
                    $additional_percentage = $response = array();
                    // if(!empty($percentage_amt)) $additional_percentage['commision']  = $percentage_amt;
                    $item_id = $this->db_model->my_update($additional_percentage,array("item_id" => $item_id),"order_items");
                }

                if ($shipping_amount == 'weight_check') 
                {
                    if ($product_w >= 1) {
                        $remaining_wt = $product_w - 1;
                    }
                    else{
                        $remaining_wt = 0 ;
                    }
                    
                    $remaining_wt = round($remaining_wt);
                    $shipping_amount = $per_kg_price + ($remaining_wt * $after_per_kg_price);
                    if ($free_shipping) 
                    {
                        if ($sub_total1 >= $free_shipping) 
                        {
                            $shipping_amount = 0;
                        }
                    }
                    $post_arr['shipping_charge'] = $shipping_amount;
                }

                $display_order_id = date('YmdHis').$oid;
                    
                // echo "<pre>";
                // print_r($invoice);
                // die;

                $datasi = array();
                $itax = $totalcommision = 0;
                
                foreach ($invoice as $ikey => $ivalue)
                {
                    // $commision =  $ivalue['commision'];
                    $datasi['order_status'] = "pending";
                    $datasi['display_order_id'] = $display_order_id;
                    $datasi['payment_status'] = "pending";
                    $datasi['payment_mode'] = $post_arr['payment_mode'];
                    $datasi['order_no'] = $ivalue['order_no'];
                    $datasi['item_ids'] = implode(",", $ivalue['items']);
                    $datasi['seller_id'] = $ikey;

                    $sub_total = $transaction_cost = $net_total = 0;
                    $shipping_charge = $post_arr['shipping_charge'];

                    if ($ivalue['items']) 
                    { 
                        foreach($ivalue['items'] as $item_id)
                        {
                            $row = $itesmval[$item_id];
                            $product_name = $row["product_name"];
                            $quantity = $row["quantity"];
                            $price = $row["price"];
                            // $tax = 0;
                            // $vender_email = $row['vender_email'];
                            $category = $row['category'];
                            $mrp = $row['mrp'];
                          
                            // $final_commission = (($mrp * $quantity) + $tax) * ($commision / 100);
                            // $totalcommision +=$final_commission;
                            
                            // update commission of that product
                            // $this->db_model->my_update(array('commision' => $final_commission), array('item_id' => $item_id), 'order_items');

                            $sub_total = round( $sub_total + ($price * $quantity) , '2');
                            $itax = $tax;
                        }
                    }

                    $net_total = round( $sub_total + $shipping_charge , '2');
                    
                    $datasi['sub_total']        = $sub_total;
                    $datasi['shipping_cost']    = $shipping_charge;
                    $datasi['net_total']        = $net_total;
                    // $datasi['commission']        = $totalcommision;
                    $datasi['created_date']     = date('Y-m-d H:i:s');
                    $datasi['tax']              = $itax;
                    $datasi['distance']         = $distance;

                    $this->db_model->my_insert($datasi,'order_invoice');
                }

                /*Calculate tax on whole added product and extra*/
                $total_product_cost = $sub_total1 + $added_ex_amt;
                $calculated_tax = ($tax_percentage / 100) * $total_product_cost;

                $f_net_total    = $total_product_cost + $shipping_charge + $tip_amount ;
                
                $final_net_total    = round( $f_net_total + $calculated_tax  + $account_minus - $voucher_amount - $post_arr['wallet_amount'] , '2');
                if ($final_net_total == 0) 
                {
                    $this->db_model->my_update(array('payment_status' => "Paid",'payment_mode' => "wallet"),array('order_master_id' => $oid),'order_master');
                }

                $count_o = $this->db_model->get_data_array("SELECT COUNT(order_master_id) as order_user FROM order_master WHERE `user_id`='$uid'");
                $count_user = $count_o[0]['order_user'];
                $suffix = $this->ordinalSuffix($count_user);

                $this->db_model->my_update(array(
    'order_count'      => $count_user.''.$suffix,
    'saved_amount'     => $saved_amt,
    'display_order_id' => $display_order_id, 
    'shipping_charge'  => $shipping_charge, 
    'sub_total'        => $total_product_cost, 
    'net_total'        => round($final_net_total),
    'tax'              => $calculated_tax,
    'tip_amount'       => $tip_amount,
    'extra_amt'        => $added_ex_amt,
    'distance'         => $distance,
    'city'             => @$post_arr['city'] // <--- ADD THIS LINE
), array('order_master_id' => $oid), 'order_master');
                
                if (!empty($post_arr['wallet_amount'])) 
                {
                    $used_w_amt = $post_arr['wallet_amount'];
                    $udata = $this->db_model->get_data_array("SELECT wallet_amount FROM `admin_users` WHERE `id` = '$uid' ");
                    $old_w_amt = 0;
                    if ($udata) 
                    {
                        $old_w_amt = $udata[0]['wallet_amount'];
                    }
                    $new_w_amt = $old_w_amt - $used_w_amt;
                    $this->db_model->my_update(array('wallet_amount' => $new_w_amt ),array('id' => $uid),'admin_users');
                }

                if (!empty($account_minus)) 
                {
                    $this->db_model->my_update(array('wallet_amount' => "0",'wallet_amt_reason' => "", ),array('id' => $uid),'admin_users');
                }

                if ($post_arr['payment_mode'] != 'online') 
                {
                    $send_data['order_status'] = "Pending";
                    $send_data['display_order_id'] = $display_order_id;
                    $send_data['user_id'] = $uid;
                    $this->email_send->order_email_fire($send_data);
                }


                $data['tip_amount'] = $tip_amount;
                $data['account_minus'] = $account_minus;
                $data['account_minus_reason'] = @$post_arr['account_minus_reason'];
                $data['payment_status'] = $post_arr['payment_status'];
                $data['payment_mode'] = $post_arr['payment_mode'];
                $data['order_master_id'] = $oid;
                $data['display_order_id'] = $display_order_id;
                $data['order_date'] = date('j F Y, g:i a');
                $data['delivery_address'] = $post_arr['address'];
                $data['sub_total'] = $sub_total1 + $added_ex_amt;
                $data['shipping_charge'] = $shipping_charge;                
                $data['estimate_delivery'] = "Today";
                $data['tax'] = $tax1;
                $data['email'] = $post_arr['email'];             
                $data['net_total'] = $final_net_total;
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function ordinalSuffix( $n = '' )
    {
        return date('S',mktime(1,1,1,1,( (($n>=10)+($n>=20)+($n==0))*10 + $n%10) ));
    }

}

?>
