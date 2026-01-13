<?php

namespace App\Libraries;
use App\Models\DbModel;
use \DateTime; 
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\I18n\Time;

class User_account
{
    protected $db_model;
    protected $session ='';

    function __construct()
    {  
        $this->db_model = new DbModel();
        $this->session      = \Config\Services::session();
    }

    public function add_remove_cart($pid, $uid, $type, $qty = 1, $metadata = array(),$comment='',$append='',$country='')
    {
        $session = session();
        $uncontent = $response = array();
        $status = $check_pr_at = false;
        $cart_qty = 0;

        if (!empty($uid))
        {
            $is_data = $this->db_model->my_where('my_cart','*',array('user_id' => $uid,'meta_key' => 'cart'));
            if (!empty($is_data))
            {
                $status = true;
                $db_content = $is_data[0]['content'];
                $id = $is_data[0]['id'];
                $uncontent = unserialize($db_content);
            }
        }
        else{
            $con = $session->get('content');
            if ($con) {
                $uncontent = unserialize($con);
            }
        }

        $c_sk = $this->db_model->my_where('product','*',array('id' => $pid));
        /*if (!empty($c_sk)) {
            if ($c_sk[0]['price_select'] == '2' && empty($metadata)) {
                return json_encode(array('status'=>false,'message'=>'invalid_size'));
            }
        }*/

        if($type == 'add')
        {
            $ck_sk = $this->db_model->my_where('product','*',array('id' => $pid));
            if(!empty($ck_sk))
            {
                if($ck_sk[0]['status'] == '0' )
                {
                    return json_encode(array('status'=>false,'message'=>'product_is_deactive'));
                }

                if($ck_sk[0]['stock'] > $qty  ||  $ck_sk[0]['stock_status'] == 'instock' )
                {                   
                    if($ck_sk[0]['stock_status'] == 'notinstock' )
                    {
                        return json_encode(array('status'=>false,'message'=>'quantity_notinstock'));
                    }

                    if(empty($metadata)) 
                    {
                        if ($comment) {
                            $comment = implode(',', $comment);
                        }
                        $append = 'm'.$pid;
                    }else 
                    {
                        $return_val=$this->product_metadata($metadata,$pid);
                        if($return_val!='invalid_size')
                        {
                            $metadata=$return_val['metadata'];
                            $append=$return_val['append'];                          
                        }else{
                            return json_encode(array('status'=>false,'message'=>$return_val));
                        }

                        $pcxdata = $this->product_exdata($comment,$pid);
                        if($pcxdata!='invalid_customize_id')
                        {
                            $comment = $pcxdata['pcxdata'];                           
                            $append=$append.$pcxdata['append'];                         
                        }else{
                            return json_encode(array('status'=>false,'message'=>$pcxdata));
                        }
                    }

                    // echo "<pre>";
                    // print_r($comment);
                    // die;

                    $cart_check=$this->check_product_added($uid,$qty,$uncontent,$append,$ck_sk,$comment);

                    if($cart_check == 'not_added_tocart')
                    {
                        $cnt[$append] = array('pid' => $pid, 'qty' => $qty, 'metadata' => $metadata,'comment'=> $comment);
                        if(!empty($uncontent))
                        {
                            $cnt = array_merge($uncontent,$cnt);
                        }

                        // print_r($cnt);
                        // die;

                        $response = $cnt;
                        $data = array('meta_key' => 'cart', 'content' => serialize($cnt));
                        if (!empty($uid))
                        {
                            if ($status)
                            {
                                $this->db_model->my_update(array('content' => serialize($response)),array('id' => $id,'meta_key' => 'cart'),'my_cart',true,true);
                            }
                            else{
                                $data['user_id'] = $uid;
                                $this->db_model->my_insert($data,'my_cart');
                            }
                        }

                        $session->set('content', serialize($response));
                        // $this->session->set_userdata('content', serialize($response));
                        return json_encode(array('status'=>true,'message'=>"first_time_added_successfully"));
                    }
                    else
                    {
                        return json_encode(array('status'=>false,'message'=>$cart_check));                      
                    }               
                }
                else
                {
                    // if quantity is grather than stock
                    return json_encode(array('status'=>false,'message'=>'quantity_not_avilable'));              
                }                
            }
            else{
                return json_encode(array('status'=>false,'message'=>'product_not_found'));
            }           
        }else if($type=='update') 
        {            
            $ck_sk = $this->db_model->my_where('product','*',array('id' => $pid));

            // echo "<pre>";
            // print_r($ck_sk);
            // die;

            if(!empty($ck_sk))
            {
                if($ck_sk[0]['stock_status'] == 'notinstock' )
                {
                    return json_encode(array('status'=>false,'message'=>'quantity_notinstock'));
                }
                else if($ck_sk[0]['status']==1)
                {
                    $cart_check = $this->check_product_update($uid,$qty,$uncontent,$append,$ck_sk);
                    if($cart_check=='cart_updated')
                    {
                        return json_encode(array('status'=>true,'message'=>$cart_check));
                    }else{
                        return json_encode(array('status'=>false,'message'=>$cart_check));
                    }
                }else{
                    return json_encode(array('status'=>false,'message'=>'product_deactive'));
                }
            }
            else
            {
                return json_encode(array('status'=>false,'message'=>'product_not_found'));
            }           
        }  //  this for remove individual prodcut form cart             
        else if($type == 'remove')
        {
            // echo "<pre>";
            // print_r($uncontent);
            // die;

            if (!empty($uncontent))
            {
                $append = $pid;
                if (array_key_exists($append, $uncontent))
                {
                    unset($uncontent[$append]);
                    $uncontent = array_filter($uncontent);
                    $response = $uncontent;
                    if (!empty($uid)){
                        $this->db_model->my_update(array('content' => serialize($response)),array('id' => $id,'meta_key' => 'cart'),'my_cart',true,true);
                    }
                    else
                    {
                        $session->set('content', serialize($response));
                    }

                    return $response;
                }
                else{
                    return '-1';
                }
            }
            else{
                return '-1';
            }
        }
    }


    public function check_product_added($uid,$qty,$uncontent,$append,$ck_sk,$comment)
    {
        $session = session();
        // echo "<pre>";
        // print_r($comment);
        // die;

        if (!empty($uid))
        {
            // $is_data = $this->custom_model->my_where('my_cart','*',array('user_id' => $uid,'meta_key' => 'cart'));
            if (!empty($uncontent))
            {   
                // $db_content = $is_data[0]['content'];
                // $id = $is_data[0]['id'];
                // $uncontent = unserialize($db_content);                       
                // check product all ready added ot cart                                        
                if(array_key_exists($append,$uncontent )) {
                    //echo "123"; exit;
                    $p_qurnt=$uncontent[$append]['qty'];
                    $uncontent[$append]['qty']=$p_qurnt+$qty;
                    $uncontent[$append]['comment'] = $comment;
                    $p_q_c=$p_qurnt+$qty;                   
                    if($p_q_c > $ck_sk[0]['stock'] || $ck_sk[0]['stock_status'] == 'notinstock')
                    {                       
                        $return_val="quantity_not_avilable";            
                        return $return_val;
                    }

                    $update=$this->db_model->my_update(array('content' =>serialize($uncontent)),array('user_id' => $uid,'meta_key' => 'cart'),'my_cart');
                    $return_val="founded";          
                    return $return_val;                                
                }   
            }
            // prodcut not already added to cart
        $return_val="not_added_tocart";             
        return $return_val;
        } 
        else
        {
            if(!empty($uncontent))
            {
                // $uncontent3=unserialize($this->session->userdata('content'));
                if(array_key_exists($append,$uncontent))
                {
                    $p_qurnt = $uncontent[$append]['qty'];
                    $uncontent[$append]['qty'] = $p_qurnt+$qty;
                    $uncontent[$append]['comment'] = $comment;
                    $p_q_c=$p_qurnt+$qty;                           
                    if($p_q_c > $ck_sk[0]['stock'] || $ck_sk[0]['stock_status'] == 'notinstock')
                    {          
                        $return_val="quantity_not_avilable";            
                        return $return_val;
                    }

                    // Serialize and store $uncontent in session
                    $session->set('content', serialize($uncontent));

                    // Later, retrieve and unserialize the session data
                    $content = unserialize($session->get('content'));

                    // $this->session->set_userdata('content',serialize($uncontent));
                    $return_val = "founded";
                    return $return_val;                                        
                }                               
            } 
            // prodcut not already added to cart
            $return_val="not_added_tocart";             
            return $return_val;             
        }
    }

    public function check_product_update($uid,$qty,$uncontent,$append,$ck_sk)
    {    
        $session = session();
        if (!empty($uid))
        {   
            if (!empty($uncontent))
            {
                if(array_key_exists($append,$uncontent )) {
                    $p_qurnt = $uncontent[$append]['qty'];
                    $tcount = $qty + $p_qurnt;

                    if( $p_qurnt == 1 && $tcount < 1)
                    {
                        $return_val="quantity_not_update_below_one";            
                        return $return_val;
                    }

                    if($qty==-1)
                    {
                        $uncontent[$append]['qty']=$p_qurnt-1;
                        $p_q_c=$p_qurnt-1;
                    }else{
                        $uncontent[$append]['qty']=$p_qurnt+1;
                        $p_q_c=$p_qurnt+1;
                    }                                       
                    if( $p_q_c > $ck_sk[0]['stock'] || $ck_sk[0]['stock_status'] == 'notinstock')
                    {                       
                        $return_val="quantity_not_avilable";            
                        return $return_val;
                    }

                    $update=$this->db_model->my_update(array('content' =>serialize($uncontent)),array('user_id' => $uid,'meta_key' => 'cart'),'my_cart');                                                      
                    $return_val="cart_updated";             
                        return $return_val;
                }   
            }
            // prodcut not already added to cart
            $return_val="not_added_tocart";
            return $return_val;
        } 
        else
        {
            // echo "<pre>";
            // print_r($append);
            // print_r($uncontent);
            // die;

            if(!empty($uncontent))
            {               
                if(array_key_exists($append,$uncontent))
                {
                    $p_qurnt=$uncontent[$append]['qty'];
                    if($qty==-1)
                    {
                        $uncontent[$append]['qty']=$p_qurnt-1;
                        $p_q_c=$p_qurnt-1;
                    }else{
                        $uncontent[$append]['qty']=$p_qurnt+1;
                        $p_q_c=$p_qurnt+1;
                    }       
                    if($p_q_c > $ck_sk[0]['stock'] || $ck_sk[0]['stock_status'] == 'notinstock')
                    {          
                        $return_val="quantity_not_avilable";            
                        return $return_val;
                        
                    }

                    $session->set('content', serialize($uncontent));

                    $return_val="cart_updated";             
                    return $return_val;                                    
                }                               
            } 
            // prodcut not already added to cart
            $return_val="not_added_tocart";             
            return $return_val;             
        }
    }

    public function product_exdata($comment,$pid)
    {
        $session = session();
        // echo "<pre>";
        // print_r($comment);
        // die;

        $append = '';
        $pcxdata = '';
        if(!empty($comment))
        {
            $pcxdata = array();
            foreach ($comment as $pcxd_key => $pcxd_val)
            {
                $cus_att_value = $this->db_model->my_where('product_custimze_details','*',array('id' => $pcxd_val,'pid' => $pid));
                if (!empty($cus_att_value))
                {
                    $pcxdata[] =  $pcxd_val;
                    // $pcxdata[$pcxd_val]['name']         = $cus_att_value[0]['name'];
                    // $pcxdata[$pcxd_val]['price']         = $cus_att_value[0]['price'];
                    // $append=$append.'m'.$pcxd_val;
                }
                else
                {
                    $return_val = "invalid_customize_id";             
                    return $return_val;
                }
            }
            
            if ($pcxdata) {
                $pcxdata = implode(',', $pcxdata);
            }
            else{
                $pcxdata = '';
            }
        }
        return ['append'=>$append,'pcxdata'=>$pcxdata];
    }

    public function product_metadata($metadata,$pid)
    {
        // echo "<pre>";
        // print_r($pid);
        // print_r($metadata);
        // die;

        $session = session();
        foreach ($metadata as $md_key => $md_val) 
        {
            $attribute_item = $this->db_model->my_where('attribute_item','item_name',array('id' => $md_val));
            $attribute = $this->db_model->my_where('attribute','name',array('id' => $md_key));
            $attribute_price = $this->db_model->my_where('product_attribute','price',array('attribute_id' => $md_key,'item_id'=>$md_val,'p_id'=> $pid));

            if (empty($attribute_price)) {
                $return_val = "invalid_size";
                return $return_val;
            }

            if(!empty($attribute_item) && !empty($attribute))
            {
                $append = 'm'.$pid.'m'.$md_val;
                unset($metadata[$md_key]);
                $metadata['item_id'] = $md_val;
                $metadata['price'] = $attribute_price[0]['price'];
                $metadata['size'] = $attribute_item[0]['item_name'];
                return ['append'=>$append,'metadata'=>$metadata];
            }else
            {
                $return_val="invalid_size";
                return $return_val;
            }
            break;
        }
    }

    // this funciton for if cart qty is grather than available prodcut qty than set avilable qty
    public function update_catqty($content,$key,$available_qty)
    {
        // echo "<pre>";
        // print_r($content);
        // print_r($key);
        // die;

        $session = session();
        /*$uid = $this->session->userdata('uid');     
        if (array_key_exists($key, $content))
        {           
            $content[$key]['qty']=$available_qty;           
            // $uncontent = array_filter($uncontent);
            // echo "<pre>";
            // print_r($content);
            // die;         
            if (!empty($uid))
            {
                $this->db_model->my_update(array('content' => serialize($content)),array('user_id' => $uid,'meta_key'=>'cart'),'my_cart',true,true);
            }
            $this->session->set_userdata('content',serialize($content));            
        } */
    }

    

}

?>    