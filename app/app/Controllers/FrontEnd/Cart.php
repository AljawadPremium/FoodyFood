<?php
namespace App\Controllers\FrontEnd;
use App\Libraries\EmailTemplate;
use App\Libraries\CommonFun;
use App\Libraries\User_account;
use App\Libraries\Place_order;
use App\Libraries\Check_login;
use App\Libraries\Stripe_lib;
use Config\Services; // Added for Email Service

class Cart extends FrontController
{
    protected $comf;
    protected $email_t;
    protected $user_account;
    protected $place_order;
    protected $check_login;
    protected $stripe_lib;

    function __construct()
    {
        $this->comf   = new CommonFun();
        $this->email_t  = new EmailTemplate();
        $this->user_account  = new User_account();
        $this->place_order  = new Place_order();
        $this->check_login  = new Check_login();
        $this->stripe_lib  = new Stripe_lib();
    }

    public function index()
    {
        $cart_data = $this->check_login->view_cart_deta($this->user_id);
        
        // $view_cart_count = $this->check_login->view_cart_count($this->user_id);
        // $recent = $this->check_login->most_browsed_products($this->user_id);
        // $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product WHERE `status` = '1' AND `id` IN ($recent) ORDER BY `id` DESC LIMIT 10 ");
        // $product_l_array = $this->check_login->get_all_product_data($product_listing,$this->user_id);


        // echo "<pre>";
        // print_r($cart_data['data']);
        // print_r($cart_data['price_summary']);
        // die;


        // $this->mViewData['recent_view_product']  = $product_l_array;
        $this->mViewData['cart_data']       = $cart_data['data'];
        $this->mViewData['card_total']   = $cart_data['price_summary'];
        $this->Urender('view_cart','default', $page_name = 'View Cart');
    }

    public function checkout()
    {        
        /*if(empty($this->user_id)) {
            return redirect()->to(base_url('/login'));
        }*/


        $cart_data = $this->check_login->view_cart_deta($this->user_id);
        /*if(empty($cart_data['data'])) {
            return redirect()->to(base_url());
        }*/

        // echo "<pre>";
        // print_r($cart_data);
        // die;

        $user_data = $user_last_add = array();
        $user_last_add = $this->db_model->get_data_array("SELECT name,mobile_no,email,city,address,landmark,delivery_note FROM  order_master WHERE `user_id`='".$this->user_id."' order by order_master_id desc limit 0,1 ");

        if(empty($user_last_add) ){
            $user_data = $this->db_model->my_where("admin_users","email,phone",array("id" =>$this->user_id) );
        }

        $shipping_msg = "Increase your Total Above Rs 500 to get Free Delivery";
        $this->mViewData['shipping_msg']    = $shipping_msg;

        $add_amt = 0 ; $wallet_amt_reason = '';
        $w_amount = $this->db_model->my_where('admin_users','wallet_amount,wallet_amt_reason',array('id' => $this->user_id));

        if ($w_amount) {
            if ($w_amount[0]['wallet_amount'] <= 0 && $w_amount[0]['wallet_amount'] != '') 
            {
                $wallet_amt_reason = $w_amount[0]['wallet_amt_reason'];
                $w_a = $w_amount[0]['wallet_amount'];
                $add_amt = abs(-$w_a);
                $w_amount[0]['wallet_amount'] = '';
            }
        }
        $this->mViewData['add_amt']     = $add_amt;
        $this->mViewData['wallet_amt_reason']     = $wallet_amt_reason;

        $user_address = $this->db_model->get_data_array("SELECT * FROM user_address WHERE `user_id` = '$this->user_id' ORDER BY id DESC LIMIT 6  ");

        // echo "<pre>";
        // print_r($cart_data['price_summary']);
        // die;

        $this->mViewData['user_address']    = $user_address;
        $this->mViewData['wallet_amount']   = @$w_amount[0]['wallet_amount'];
        $this->mViewData['cart_data']       = $cart_data['data'];
        $this->mViewData['price_summary']   = $cart_data['price_summary'];
        $this->mViewData['cart_qty']        = $cart_data['cart_qty'];
        $this->mViewData['user_last_add']   = $user_last_add;
        $this->mViewData['user_data']       = $user_data;
        $this->Urender('checkout','default', $page_name = 'Checkout');
    }

    public function addToCart()
    {
        $language = "en";
        $uid = $this->user_id;
        $post_data = $this->request->getPost();

        if(!empty($post_data))
        {
            if(isset($post_data["pid"]) && isset($post_data["qty"]))
            {
                $pid = $post_data["pid"];
                $qty = $post_data["qty"];
                $metadata = isset($post_data['metadata']) ? $post_data['metadata'] : '';
                // $pcxdata_arr = isset($post_data['pcxdata']) ? $post_data['pcxdata'] : '';

                $extra_id = $post_data['extra_id'];
                $pcxdata_arr = array();
                if (!empty($extra_id)) {
                    $pcxdata_arr = explode(',',$extra_id);
                }


                $type = 'add';

                $item_name = '';
                $product_price = $this->check_login->get_product_price($pid);
                if (!empty($post_data['metadata'])) {
                    $item_id = $post_data['metadata'][20];
                    $attribute_item = $this->db_model->get_data_array("SELECT `item_name` FROM attribute_item WHERE `id` = '$item_id'");
                    $item_name = @$attribute_item[0]['item_name'];

                    $attribute_item_price = $this->db_model->get_data_array("SELECT * FROM `product_attribute` WHERE `p_id` LIKE '$pid' AND `item_id` LIKE '$item_id' ");
                    if ($attribute_item_price) {
                        $product_price = $attribute_item_price[0]['sale_price'];
                    }
                }

                $return_p_count = $this->check_login->get_count($pid ,$uid,$item_name);
                $ck_sk = $this->db_model->my_where('product','incremental_qty,minimum_add_to_cart',array('id' => $pid));
                $incremental_qty = 0;
                if ($ck_sk) 
                {
                    $minimum_add_to_cart = $ck_sk[0]['minimum_add_to_cart'];
                    $incremental_qty = $ck_sk[0]['incremental_qty'];

                    if ($qty >= 0) 
                    {
                        $minqty = $ck_sk[0]['minimum_add_to_cart'];
                        if (empty($return_p_count)) {
                            if ($qty < $minqty || $minqty = $qty) {
                                $qty = $minqty;
                            }
                        }
                        else if (!empty($return_p_count) && !empty($incremental_qty)) 
                        {
                            if ($qty == '1') {
                                if ($return_p_count < $minqty) {
                                    $qty = $minqty;
                                }
                                else{
                                    // $qty = $return_p_count + $ck_sk[0]['incremental_qty'];
                                    $qty = $ck_sk[0]['incremental_qty'];
                                }
                            }
                            else{
                                // $qty = $qty;
                                $qty = $qty - $return_p_count;
                            }

                            // $qty = $ck_sk[0]['incremental_qty'];
                        }
                    }
                    else
                    {
                        if (!empty($incremental_qty)) 
                        {
                            $qty = - $incremental_qty;
                        }
                        else
                        {
                            $qty = -1;
                        }
                    }

                    $old_qty = $qty;
                    if (($return_p_count == $minimum_add_to_cart) && ($old_qty == '-1')){
                        $qty = - $return_p_count;
                    }
                }


                // echo "<pre>";
                // print_r($qty);
                // print_r($post_data);
                // die;

                $response = $this->user_account->add_remove_cart($pid,$uid,$type,$qty,$metadata,$pcxdata_arr,$append='',$country='');
                if ($response)
                {
                    $response = json_decode($response,true);

                    $a_data['get_product_count'] = $this->check_login->get_count($pid ,$uid,$item_name);
                    $a_data['product_name'] = $this->check_login->get_product_name($pid);
                    $a_data['product_image'] = $this->check_login->get_product_image($pid);
                    $a_data['product_detail_link'] = base_url('detail/'.$pid);
                    $a_data['product_price'] = $product_price;
                    $a_data['cart_url'] = base_url('cart');
                    $a_data['checkout_url'] = base_url('checkout');

                    // echo "<pre>";
                    // print_r($a_data);
                    // die;

                    if ($response['message'] == 'invalid_size') 
                    {
                        echo json_encode( array("status" => false , "message" => ($language == 'ar'? 'الحجم المحدد غير صحيح لذا يرجى تحديد الحجم المناسب':'Selected size is wrong so please select proper size')));die;
                    }
                    else if ($response['message'] == 'product_is_deactive') 
                    {
                        echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'المنتج غير نشط':'Product is deactive!')));die;
                    }
                    else if ($response['message'] == 'founded') 
                    {
                        $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product WHERE  `id` = '$pid' ");
                        $product_l_array = $this->check_login->get_all_product_data($product_listing,$uid);

                        $url = base_url($language.'/cart');
                        echo json_encode( array("status" => true,"product_data" => $product_l_array[0],"a_data" => $a_data,"redirect" => '',"message" => ($language == 'ar'? 'تم تحديث المنتج بنجاح الي سلة التسوق':'The product has been successfully updated to the shopping cart')));die;
                    }
                    else if ($response['message'] == 'quantity_notinstock') 
                    {
                        echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'كمية المنتج المطلوب غير موجودة في المخزون':'The quantity of the requested product is not in stock')));die;
                    }
                    else if ($response['message'] == 'quantity_not_avilable') 
                    {
                        echo json_encode( array("status" => false,"message" => ($language == 'ar'? 'كمية المنتج المطلوب غير موجودة في المخزون':'The quantity of the requested product is not in stock')));die;
                    }
                    else if ($response['message'] == 'first_time_added_successfully') 
                    {
                        $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product WHERE  `id` = '$pid' ");
                        $product_l_array = $this->check_login->get_all_product_data($product_listing,$uid);

                        echo json_encode(array("status" => true,"product_data" => $product_l_array[0],"a_data" => $a_data,"redirect" =>'' ,"message" => ($language == 'ar'? 'تمت إضافة المنتج بنجاح إلى ىسلة التسوق':'The product has been successfully added to the cart'))); die;
                    }
                    else if ($response['message'] == 'product_not_found') 
                    {
                        echo json_encode(array("status" => false,"message" => ($language == 'ar'? 'لم يتم العثور على المنتج':'Product not found'))); die;
                    }
                }
                else{
                    $msg = ($language == 'ar'? '':'The quantity of the requested product is not in stock');
                    echo json_encode( array("status" => false,"message" => $msg) );die;
                }

                if($response['status']==1 && is_array($response['message']))
                {           
                    $this->session->set('content', serialize($response['message']));
                    $response['message'] = 'success';
                }
                echo json_encode($response);
                die;   

            }else{
                $msg = ($language == 'ar'? '':'All fields required');
                echo json_encode( array("status" => false,"message" => $msg) );die;
            }
        }else{
            $msg = ($language == 'ar'? '':'Something went wrong');
            echo json_encode( array("status" => false,"message" => $msg) );die;
        }
    }

    public function updateCart()
    {
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            if(isset($post_data["pid"]) && isset($post_data["qty"]) && isset($post_data["append"]))
            {
                $uid = $this->user_id;
                $pid = $post_data["pid"];
                $qty = $post_data["qty"];
                $append = $post_data["append"];
                $type = 'update';
                $pcxdata = '';
                $metadata = '';                
                
                // $this->user_account->g_currency=$currency;
                $response = $this->user_account->add_remove_cart($pid,$uid,$type,$qty,$metadata,$pcxdata,$append);

                $asd = json_decode($response);
                
                // echo "<pre>";
                // print_r($asd);
                // die;

                if ($asd->status == 1) 
                {
                    $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product WHERE `id` = '$pid' ");
                    $product_data = $this->check_login->get_all_product_data($product_listing,$this->user_id);

                    if (!empty($append)) {
                        $meta_data = $product_data[0]['meta_data'];
                        foreach ($meta_data as $key => $value) {
                            if ($append == $value['remove_key']) {
                                $product_data[0]['sale_price'] = $value['sale_price'];
                            }
                        }
                    }

                    // echo "<pre>";
                    // print_r($product_data);
                    // die;

                    $card_total = $this->check_login->view_cart_deta($this->user_id);

                    $data['status'] = true;
                    $data['tax_amount'] = $card_total["price_summary"]['tax_amt'];
                    $data['shipping_amount'] = $card_total["price_summary"]['shipping_amount'];
                    $data['coupon_amount'] = '0.00';
                    $data['sub_total'] = $card_total["price_summary"]['cart_price'];
                    $data['grand_total'] = $card_total["price_summary"]['total_cart'];
                    $data['message'] = $asd->message;
                    // $data['sale_price'] = $asd->sale_price;
                    $data['sale_price'] = 0;

                    $data['product_offer'] = $product_data[0]['offer'];
                    $data['added_product_price'] = $product_data[0]['sale_price'];
                    $response = json_encode($data);
                }
                else
                {
                    $data['status'] = false;
                    $data['message'] = $asd->message;
                    $data['coupon'] = 'no';
                    $response = json_encode($data);
                }
                echo $response;     
            }else{
                echo json_encode(array("status"=>false,"message"=>"Something Went Wrong")); die;  
            }
        }else{
            echo json_encode(array("status"=>false,"message"=>"Something Went Wrong")); die;  
        }
    }

    public function removeFromCart($echo=true)
    {
        $language = "en";
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {   
            if(isset($post_data["pid"]))
            {
                $pid = $post_data["pid"];
                $uid = $this->user_id;
                $response = $this->user_account->add_remove_cart($pid,$uid,'remove');
                $card_total = $this->check_login->view_cart_deta($this->user_id);
                $tax_amount = $shipping_amount = $coupon_amount = $sub_total = $grand_total = 0;
                if(!empty($card_total["data"])) {
                    $tax_amount = $card_total["price_summary"]['tax_amt'];
                    $shipping_amount = $card_total["price_summary"]['shipping_amount'];
                    $coupon_amount = '0.00';
                    $sub_total = $card_total["price_summary"]['cart_price'];
                    $grand_total = $card_total["price_summary"]['total_cart'];
                }
                echo json_encode(array('status'=>true,'message' => ($language == 'ar'? 'تمت إزالة المنتج بنجاح من سلة التسوق':'The product has been successfully removed from the cart'),'shipping_amount'=>$shipping_amount,'tax_amount'=>$tax_amount,'coupon_amount'=>$coupon_amount,'sub_total'=>$sub_total,'grand_total'=>$grand_total));                    
            }else{
                echo json_encode(array("status"=>false,"message"=>"Something Went Wrong")); die; 
            }
        }else{
            echo json_encode(array("status"=>false,"message"=>"Something Went Wrong")); die; 
        }
    }

    public function viewCartCount() 
    {
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            if(isset($post_data["type"]))
            {
                if($post_data["type"]=="count")
                {
                    $cart_data = $this->check_login->view_cart_deta($this->user_id);
                    if (empty($cart_data['price_summary']['cart_price'])) {
                        $cart_data['price_summary']['cart_price'] = 0;
                    }

                    $cart_total = @$cart_data['price_summary']['cart_price'];
                    $cart_count = $this->check_login->view_cart_count($this->user_id);
                    echo json_encode(array("status"=>true,"message"=>"Successfully","data"=>$cart_count,"cart_total"=>$this->currency.''.$cart_total)); die;
                }
                else if($post_data["type"]=="cart_dropdown")
                {
                    $cart_data = $this->check_login->view_cart_deta($this->user_id);
                    $res_data = $this->dropDownCart($cart_data["data"],$cart_data["price_summary"]);
                    echo json_encode(array("status"=>true,"message"=>"Successfully","data"=>$res_data)); die;
                }
            }else{
                echo json_encode(array("status"=>false,"message"=>"Something Went Wrong")); die;   
            }
        }else{
            echo json_encode(array("status"=>false,"message"=>"Something Went Wrong")); die;
        }  
    }


    private function dropDownCart($product_data,$price_summary)
    {
        $res_arr = array();
        $html_tag='';
        $html_tag2='';

        if(!empty($product_data))
        {
            foreach ($product_data as $key => $val) 
            {
                $pid =  $val["p"]["id"];
                $price =  $val["p"]["sale_price"];
                $remove_key =  $val["key"];
                $size = '';
                if (!empty($val['c']['metadata'])) {
                    $price = $val['c']['metadata']['sale_price'];
                    $size = ' ('.$val['c']['metadata']['size'].')';
                }

                $detail_url = base_url('product/'.$pid);
                
                $html_tag.='<li class="menu_count_div '.$remove_key.' " >
                                    <div class="cartmini__thumb">
                                       <a href="'.$detail_url.'">
                                       <img src="'.$val["p"]["product_image"].'" alt="product image">
                                       </a>
                                    </div>
                                    <div class="cartmini__content">
                                       <h5><a href="'.$detail_url.'">'.$val["p"]["product_name"].''.$size.'</a></h5>
                                       <div class="product__sm-price-wrapper">
                                          <span class="product__sm-price">QTY: '.$val["uqty"].'</span>
                                          <span class="product__sm-price"><br> Price: '.$this->currency.''.$price.'</span>
                                       </div>
                                    </div>
                                    <a href="javascript:void(0);" class="cartmini__del delete_pro_menu" data-id="'.$remove_key.'" ><i class="fal fa-times"></i></a>
                                 </li>';
            }

            $html_tag2.='<div class="cartmini__checkout cart-total">
                              <div class="cartmini__checkout-title mb-30">
                                 <h4>'.lang('Validation.Subtotal').':</h4>
                                 <span class="price">'.$this->currency.''.$price_summary["cart_price"].'</span>
                              </div>
                              <div class="cartmini__checkout-btn">
                                 <a href="'.base_url('cart').'" class="bd-fill__btn w-100"> <span></span> '.lang('Validation.view cart').'</a>
                                 <a href="'.base_url('checkout').'" class="bd-unfill__btn w-100"> <span></span> '.lang('Validation.Checkout').'</a>
                              </div>
                           </div>';
        }

        if(empty($html_tag))
        {
            $html_tag='<h3 class="emty_div">Your cart is empty.</h3>';
        }
        $res_arr["html_tag"] = $html_tag;
        $res_arr["html_tag2"] = $html_tag2;
        return $res_arr;
    }


    public function addtoWishList($echo=true)
    {
        //add_to_wish_list
        $language = "en";
        $post_data = $this->request->getPost();
        if(!empty($post_data)){
            $pid = $post_data["pid"];
            $is_wish = $post_data["is_wish"];
            $uid = $this->user_id;;
            if(!empty($pid)){
                $append='m'.$pid;
            }
            if (empty($uid)){
                echo json_encode(array("status"=>false,"message"=>($language == 'ar'? 'الرجاء تسجيل الدخول واضافة المنتج الي القائمة المفضلة':'Please login to add this product in your wishlist'))); die;
            }

            if (!empty($uid)){
                $is_data = $this->db_model->my_where('my_cart','*',array('user_id' => $uid,'meta_key' => 'wish_list'));

                if($is_wish)
                {
                    if(!empty($is_data) ){
                        $wish_list=unserialize($is_data[0]['content']);
                        // $cnt[$append] = array('pid' => $pid, 'add_date' => $date);
                        $cnt[$append] = array('pid' => $pid);

                        if(!empty($wish_list))
                        {
                            $cnt=array_merge($wish_list,$cnt);
                        }
                        $this->db_model->my_update(array('content' => serialize($cnt)),array('id' => $is_data[0]['id']),'my_cart',true,true);
                    }
                    else
                    {
                        // $cnt[$append] = array('pid' => $pid, 'add_date' => $date);
                        $cnt[$append] = array('pid' => $pid);
                        $data['user_id'] = $uid;
                        $data['meta_key'] = 'wish_list';
                        $data['content'] = serialize($cnt);
                        $this->db_model->my_insert($data,'my_cart');
                        echo json_encode(array("status"=>true,"message"=>($language == 'ar'? 'تم اضافة المنتج بنجاح الى القائمة المفضلة':'The product has been successfully added to the wishlist') )); die;
                    }
                }
                else
                {
                    $wish_list = unserialize($is_data[0]['content']);
                    if (array_key_exists($append, $wish_list))
                    {
                        unset($wish_list[$append]);
                        $wish_list = array_filter($wish_list);

                        $this->db_model->my_update(array('content' => serialize($wish_list)),array('id' => $is_data[0]['id']),'my_cart',true,true);             
                    }
                    echo json_encode(array("status"=>true,"message"=> ($language == 'ar'? 'تم حذف المنتج بنجاح من القائمة المفضلة':'The product has been successfully removed from wishlist'))); die;
                }
            }       

            echo json_encode(array("status"=>true,"message"=> ($language == 'ar'? 'تم اضافة المنتج بنجاح الى القائمة المفضلة':'The product has been successfully added to the wishlist'))); die;
        }else{
            $msg = ($language == 'ar'? '':'Something went wrong');
            echo json_encode( array("status" => false,"message" => $msg) );die;
        }
    }

    public function clearAllItems()
    {
        if(!empty($this->user_id)){
            $this->db_model->my_delete(['user_id' => $this->user_id,"meta_key" => 'cart'], 'my_cart');
        }
        $this->session->set('content','');
        echo json_encode( array("status" => true,"message" => "All Product Removed Successfully") );die;
    }

    public function get_metadata_count()
    {
        // added metadata product count get in popup 
        $post_data = $this->request->getPost();

        $pid = $post_data['pid'];
        $user_id = $this->user_id;
        
        $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product WHERE `id`='$pid' ");
        $product_l_array = $this->check_login->get_all_product_data($product_listing,$user_id);            

        // echo "<pre>";
        // print_r($post_data);
        // print_r($product_l_array);
        // die;

        if (!empty($product_l_array)) {
            
            $adata['added_count'] = $product_l_array[0]['count_add'];
            $adata['added_price'] = $product_l_array[0]['price'];
            $adata['added_sale_price'] = $product_l_array[0]['sale_price'];
            $adata['added_remove_key'] = $product_l_array[0]['remove_key'];

            if (!empty($post_data['metadata'])) 
            {
                foreach ($product_l_array[0]['meta_data'] as $key => $value) 
                {
                    $item_id = $value['item_id'];
                    if ($item_id == $post_data['metadata']) 
                    {
                        $adata['added_count'] = $value['count_add'];
                        $adata['added_price'] = $value['price'];
                        $adata['added_sale_price'] = $value['sale_price'];
                        $adata['added_remove_key'] = $value['remove_key'];
                    }
                }
            }
        }

        echo json_encode( array("status" => true,"message" => "","data"=>$adata) );die;
    }



public function placeOrder()
{
    $post_data = $this->request->getPost();
    $uid = $this->user_id;
    $products = $this->session->get('content');

    $language = '';
    $post_data['tip_amount'] = '0';
    $post_data['source'] = 'Web';
    $first_name = @$post_data['name'];
    $lat = @$post_data['lat'];
    $lng = @$post_data['lng'];
    $place_id = @$post_data['place_id'];
    $address_id = @$post_data['address_id'];

    // Basic Validations
    if (empty($address_id) && empty($first_name)) {
        echo json_encode(array("status" => false, "message" => ($language == 'ar' ? 'الرجاء إضافة العنوان أو تحديد عنوان للتسليم' : 'Please add the address or specify an address for delivery.')));
        die;
    }

    $payment_mode = @$post_data['payment_mode'];
    $delivery_note = @$post_data['delivery_note'];

    if (empty($payment_mode)) {
        echo json_encode(array("status" => false, "message" => ($language == 'ar' ? '' : 'Please select payment mode.')));
        die;
    }

    if (empty($uid)) {
        // Log in check (currently commented out in your original code)
        // $url = base_url().'login';
        // echo json_encode(array("status" => "redirect", "url" => $url, "message" => 'Make sure to log in')); die;
    }

    if (empty($products)) {
        $url = base_url() . '';
        echo json_encode(array("status" => "redirect", "url" => $url, "message" => ($language == 'ar' ? 'لم تتم إضافة أي منتج إلى سلة التسوق' : 'No product has been added to the cart')));
        die;
    }

    // Handle New Address Entry (If user fills the form instead of selecting an existing address)
    if (!empty($first_name)) {
        $address = @$post_data['address'];
        $landmark = @$post_data['landmark'];
        $city = @$post_data['city'];
        $email = @$post_data['email'];
        $phone = @$post_data['mobile_no'];

        if (empty($city)) {
            echo json_encode(array("status" => false, "message" => 'Please select your city for delivery.'));
            die;
        }

        if (empty($address) || ctype_space($address)) {
            echo json_encode(array("status" => false, "message" => 'Address must contain some character'));
            die;
        }

        if (empty($landmark) || ctype_space($landmark)) {
            echo json_encode(array("status" => false, "message" => 'Please enter Apartment, suite, unit or landmark'));
            die;
        }

        if (!empty($email) && !preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
            echo json_encode(array("status" => false, "message" => "Invalid email format"));
            die;
        }

        if (empty($phone)) {
            echo json_encode(array("status" => false, "message" => 'Please enter phone number'));
            die;
        }

        if (preg_match("/[a-z]/i", $phone)) {
            echo json_encode(array("status" => false, "message" => "Phone number must contain only numbers"));
            die;
        }

        // Prepare data for user_address table
        $ad_data = array();
        if (!empty($uid)) $ad_data['user_id'] = $uid;
        $ad_data['receiver_name'] = $first_name;
        $ad_data['receiver_number'] = $phone;
        $ad_data['receiver_email'] = $email;
        $ad_data['place_id'] = $place_id;
        $ad_data['address_lat'] = $lat;
        $ad_data['address_lng'] = $lng;
        $ad_data['address'] = $address;
        $ad_data['landmark'] = $landmark;
        $ad_data['city'] = $city;
        $ad_data['created_date'] = date("Y/m/d H:i:s");

        $address_id = $this->db_model->my_insert($ad_data, "user_address");
    }

    // Fetch details for the order based on address_id
    if (!empty($address_id)) {
        $user_address = $this->db_model->my_where('user_address', '*', array('id' => $address_id));
        if (empty($user_address)) {
            echo json_encode(array("status" => false, "message" => ($language == 'ar' ? 'لم يتم العثور على العنوان المختار' : 'Selected address is not found.')));
            die;
        }

        $post_data['address_id'] = $address_id;
        $post_data['name'] = $user_address[0]['receiver_name'];
        $post_data['address_lat'] = $user_address[0]['address_lat'];
        $post_data['address_lng'] = $user_address[0]['address_lng'];
        $post_data['address'] = $user_address[0]['address'];
        $post_data['landmark'] = $user_address[0]['landmark'];
        $post_data['city'] = $user_address[0]['city'];
        $post_data['email'] = $user_address[0]['receiver_email'];
        $post_data['mobile_no'] = $user_address[0]['receiver_number'];
    }

    // Voucher Handling
    if (!empty($post_data['voucher_code'])) {
        $voucher_code = $post_data['voucher_code'];
        $check_code = $this->db_model->my_where("vouchers", "id", array("code" => $voucher_code, "status" => 'active'));

        if (!empty($check_code)) {
            $voucher_id = $check_code[0]['id'];
            $p_arr = $this->check_login->validate_voucher_place_order($voucher_id, $uid);
            if ($p_arr) {
                $post_data['voucher_amount'] = $p_arr['voucher_amount'];
                $post_data['voucher_id'] = $p_arr['voucher_id'];
                $post_data['voucher_code'] = $p_arr['voucher_code'];
            }
        } else {
            echo json_encode(array("status" => "incorrect_voucher", "message" => 'Voucher code is not available '));
            die;
        }
    }

    $post_data['account_minus'] = 0;
    $post_data['account_minus_reason'] = '';

    // Cleanup extra post data before creating order
    unset($post_data['lat']);
    unset($post_data['lng']);
    unset($post_data['place_id']);

    $post_data['order_status'] = 'Pending';
    $post_data['time_slot'] = 'Pending';

    $products = unserialize($products);
    $response = $this->place_order->create_order($post_data, $products, $uid, 'web');

    if ($response) {
        $display_order_id = $response['display_order_id'];
        $disp = $this->db_model->my_where("order_master", "*", array("display_order_id" => $display_order_id));

        // Online Payment Redirect
        if ($disp[0]['payment_mode'] == 'online' || $disp[0]['payment_mode'] == 'ONLINE' && $disp[0]['payment_status'] != 'Paid') {
            $url = $this->stripe_lib->genrate_stripe_url($display_order_id);
            echo json_encode(array("status" => "redirect", "url" => $url, "message" => 'Please wait while we are redirected to the payment page'));
            die;
        }

        // Email Notification Setup
        $order_date = date("F j, Y, g:i a");
        $items_html = '<table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%; font-family: sans-serif;">';
        $items_html .= '<tr style="background: #f4f4f4;"><th>Product Name</th><th>Qty</th><th>Price</th><th>Total</th></tr>';

        $grand_total = 0;
        $cart_info = $this->check_login->view_cart_deta($uid);
        foreach ($cart_info['data'] as $item) {
            $p_name = $item['p']['product_name'];
            $p_qty = $item['uqty'];
            $p_price = $item['p']['sale_price'];
            $p_total = $p_qty * $p_price;
            $grand_total += $p_total;
            $items_html .= "<tr><td>$p_name</td><td align='center'>$p_qty</td><td>SAR$p_price</td><td>SAR$p_total</td></tr>";
        }
        $items_html .= '</table>';

        $summary_html = "
                <div style='font-family: sans-serif; margin-top: 20px;'>
                    <p><b>Order Id:</b> $display_order_id</p>
                    <p><b>Order Date:</b> $order_date</p>
                    <table width='100%'>
                        <tr>
                    <td width='50%' valign='top'><h4>Customer</h4><p>" . $post_data['name'] . "<br>" . $post_data['mobile_no'] . "<br>" . $post_data['email'] . "</p></td>
                    <td width='50%' valign='top'><h4>Shipping</h4>
                        <p>
                            " . $post_data['address'] . "<br>
                            " . $post_data['landmark'] . "<br>
                            <b>City: " . $post_data['city'] . "</b>  </p>
                    </td>
                        </tr>
                    </table>
                    <p><b>Payment:</b> " . ucfirst($payment_mode) . " | <b>Note:</b> " . $post_data['delivery_note'] . "</p>
                    <h2 style='color: #2e7d32;'>TOTAL: SAR$grand_total</h2>
                </div>";

        $email_service = \Config\Services::email();

        // 1. Send to Customer
        if (!empty($post_data['email'])) {
            $email_service->clear();
            $email_service->setTo($post_data['email']);
            $email_service->setFrom('sse@foodyfc.com.sa', 'FoodyFood');
            $email_service->setSubject('Order Confirmation - #' . $display_order_id);
            $email_service->setMessage("<h2>Thank you for your order!</h2>" . $items_html . $summary_html . "<h2>We are processing your order and our Sales Team will contact you to continue.</h2>");
            $email_service->send(false);
        }

        // 2. Send to Admin
        $email_service->clear();
        $email_service->setTo('sse@foodyfc.com.sa');
        $email_service->setFrom('sse@foodyfc.com.sa', 'New FoodyFood Order');
        $email_service->setSubject('NEW ORDER - #' . $display_order_id);
        $email_service->setMessage("<h2>New FoodyFood Order Received</h2>" . $items_html . $summary_html);
        $email_service->send(false);

        // Finalize Session and Cart
        $this->session->set('content', '');
        if (!empty($post_data['account_minus'])) {
            $up_date['wallet_amt_reason'] = '';
            $up_date['wallet_amount'] = '';
            $this->db_model->my_update($up_date, array('id' => $uid), 'admin_users');
        }

        $this->db_model->my_delete(['user_id' => $uid, "meta_key" => 'cart'], 'my_cart');
        date_default_timezone_set('Asia/Kolkata');
        $_SESSION['voucher_id'] = '';

        echo json_encode(array("status" => true, "data" => $display_order_id, "message" => 'Order placed successfully'));
        die;
    } else {
        echo json_encode(array("status" => false, "message" => "Invalid request."));
        die;
    }
}


    public function thank_you($display_order_id = '')
    {
        if(empty($this->user_id)) {
            // return redirect()->to(base_url());
        }

        $transaction_details = $this->db_model->my_where('transaction_details','*',array('display_order_id' =>$display_order_id));
        $data = $this->db_model->my_where('order_master','*',array('display_order_id' =>$display_order_id));
        $order_item = $this->db_model->my_where('order_items','*',array('order_no' =>$data[0]['order_master_id']));
                
        $this->mViewData['t_details'] = $transaction_details;
        $this->mViewData['order_item'] = $order_item;
        $this->mViewData['data'] = $data[0];
        // $this->Urender('thank_you', 'udefault');
        $this->Urender('thank_you','default', $page_name = 'Thank You');
    }

    public function paymentSuccess($trans_id_d, $dip_d)
    {
        // echo 1111; die;
        $trans_id = en_de_crypt($trans_id_d,'d');
        $dip = en_de_crypt($dip_d,'d');
        
        $transaction_details = $this->db_model->my_where('transaction_details','id,user_id',array('display_order_id' =>$dip,'id' =>$trans_id));

        if(!empty($transaction_details)){
            $uid = $transaction_details[0]['user_id'];

           /* $trans_update = [
                'payment_status' => "paid",
            ];

            $this->db_model->my_update($trans_update,array('display_order_id' =>$dip,'id' =>$trans_id), 'transaction_details'); */

            /*$order_update = [
                'payment_status' => "paid",
            ];
            $this->db_model->my_update($order_update,array('display_order_id' => $dip), 'order_master'); */

            $_SESSION['content'] = '';
            $this->db_model->my_delete(['user_id' => $uid,"meta_key" => 'cart'], 'my_cart');

            return redirect()->to(base_url('cart/thank_you/'.$dip));
        
        }else{
            // echo "Invalid Request"; die;
            return redirect()->to(base_url());
        }
    }

    public function paymentCancle($dip_d, $random)
    {
        $transaction_details = $this->db_model->my_where('transaction_details','*',array('display_order_id' =>$dip_d,'random' =>$random));

        // echo "<pre>";
        // print_r($transaction_details);
        // die;

        if(!empty($transaction_details))
        {
            $this->Urender('payment_cancle','default', $page_name = 'Payment Cancle');
        }else{
            echo "Invalid Request"; die;
        }
    }

    public function paymentNotify($trans_id_d, $dip_d)
    {
        $post_data = $this->request->getPost();
        
        if(!empty($post_data) && !empty($trans_id_d) && !empty($dip_d) ){
            $trans_id = en_de_crypt($trans_id_d,'d');
            $dip = en_de_crypt($dip_d,'d');
            $response_data = $this->payfast->paymentNotify($post_data, $trans_id, $dip);
            // $myfile = fopen("newfile.txt", "w");
            // $string_version = json_encode($post_data);
            // fwrite($myfile, $string_version);
            // fclose($myfile);
        }
    }

    public function get_shipping_cost()
    {
        $post_data = $this->request->getPost();    
        $cart_data = $this->check_login->view_cart_deta($this->user_id,'','',$post_data);

        // echo "<pre>";
        // print_r($cart_data['price_summary']);
        // die;

        echo json_encode( array("status" => true,"message" => "","data" => $cart_data['price_summary']));die;
    }
}
