<?php

namespace App\Controllers\FrontEnd;
use App\Libraries\EmailTemplate;
use App\Libraries\CommonFun;
use App\Libraries\Check_login;

class Ajax extends FrontController
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

    public function quickview($pid)
    {
        $user_id = @$_SESSION['uid'];
        $product_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select,image_gallery,sku,incremental_qty,minimum_add_to_cart FROM product WHERE `product_delete`='0' AND  `id` = '$pid'  ");                
        $product_l_array = $this->check_login->get_all_product_data($product_listing,$user_id);

        if (!empty($product_l_array)) 
        {
            $gallery_img = '';
            $incremental_qty = $product_l_array[0]['incremental_qty'];
            $minimum_add_to_cart = $product_l_array[0]['minimum_add_to_cart'];

            $pid = $product_l_array[0]['id'];
            $meta_data = $product_l_array[0]['meta_data'];
            $product_name = $product_l_array[0]['product_name'];
            $image_gallery = $product_l_array[0]['image_gallery'];
            $count_add = $product_l_array[0]['count_add'];

            if (empty($image_gallery)) {
                $image_gallery[] = $product_l_array[0]['product_image'];
            }
            $f_price = $product_l_array[0]['sale_price'];
            $market_price = $product_l_array[0]['price'];
            if (!empty($image_gallery)) 
            {
                foreach ($image_gallery as $gkey => $gvalue) {
                    $gallery_img.= '<figure class="product-image"> <img src="'.$gvalue.'" data-zoom-image="'.$gvalue.'" alt="DOT365"></figure>';
                }
            }

            $offer = $product_l_array[0]['offer'];
            $all_users = '';
            if ($offer) 
            {
                foreach ($offer as $qkey => $qvalue) {
                    $all_users.= '<div class="singl_ofr_list '.$qvalue['status'].'"  >';
                        $all_users.= '<i class="fa fa-certificate" aria-hidden="true"></i>';
                        $all_users.= '<span>';
                            $all_users.= ''.$qvalue['title'].'';
                        $all_users.= '</span>';
                        $all_users.= '<div class="clear"></div>';
                    $all_users.= '</div>';
                }
            }

            $size_arry  = '';
            if (!empty($meta_data)) 
            {
                $size_arry = '<div class="product-form product-size">
                        <label>Size:</label>
                        <div class="product-form-group">
                            <div class="product-variations sizelist_'.$pid.'">';
                            foreach ($meta_data as $mkey => $mvalue) {
                                $item_id = $mvalue['item_id'];
                                $size_name = $mvalue['size'];
                                $price = $mvalue['sale_price'];
                                $active = '';
                                if ($mkey == 0) {
                                    $active = 'active';
                                    $f_price = $mvalue['sale_price'];
                                    $count_add = $mvalue['count_add'];
                                }
                                $size_arry.= '<a class="size '.$active.'" data-pid="'.$pid.'" data-id="'.$item_id.'" data-price="'.$price.'" href="#">'.$size_name.'</a>';
                            }
                $size_arry .= '</div>
                            <a href="#" class="product-variation-clean">Clean All</a>
                        </div>
                    </div>
                    <div class="product-variation-price">
                        <span class="asd123">'.$this->currency.''.$f_price.'</span>
                    </div>';
            }

            $sku = $product_l_array[0]['sku'];
        }

        // echo "<pre>";
        // print_r($product_l_array);
        // die;

        if ($product_l_array[0]['is_in_wish_list'] == '') {
            $wclass = '';
            $wicon = 'fa fa-heart';
            $wtitle = 'Add to wishlist';
        }
        else
        {
            $wtitle = 'Remove from wishlist';
            $wclass = 'added';
            $wicon = 'fa fa-heart-o';
        }

        // <a href="javascript:void(0);" class="modal_add_cart add_to_cart product_'.$pid.'" data-id="'.$pid.'" data-toggle="modal" data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i><span>add to cart</span></a> <a href="javascript:void(0);" class="modal_wishlist '.$wclass.'" title="'.$wtitle.'" data-id="'.$pid.'" ><i class="'.$wicon.'"></i><span>Add to wishlist</span></a>

        $as = $list = '';
        if ($product_l_array[0]['extra_list'])
        {
            foreach ($product_l_array[0]['extra_list'] as $ekey => $evalue) {
                
                $amt = $this->currency.''.$evalue['price'];
                if ($evalue['price'] == 0) {
                    $amt = "free";
                }

                $list.= '<label class="extra_singl">
                    <input type="checkbox" name="option[]" value="'.$evalue['id'].'">
                    <span class="name_extraname_extra" >'.$evalue['name'].'</span>
                    <span class="usd_extra" >'.$amt.'</span>
                    <div class="clear"></div>
                </label>';
            }


            $as = '<div class="bd__social-media" style="margin-top: 10px;">
                        <div id="flip" class="ad_extra_btn" style="margin-bottom: 10px;" >
                            Select EXTRA (if you need it)
                            <i class="fa fa-cutlery" aria-hidden="true"></i>
                        </div>
                        <div class="clear"></div>
                        <div id="panel" class="panel_extra p_select_'.$pid.'" style="display: block;">
                            '.$list.'
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>';

        }
            
                

        echo '<div class="product product-single row product-popup">
            <div class="col-md-6">
                <div class="product-gallery">
                    <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1">
                        '.$gallery_img.'
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-details scrollable pr-0 pr-md-3">
                    <h1 class="product-name mt-0">'.$product_name.'</h1>
                    <div class="product-meta">
                        SKU: <span class="product-sku">'.$sku.'</span>
                        BRAND: <span class="product-brand">The Northland</span>
                    </div>

                    <div class="bd-product__price mt-10 mb-10">
                        <span class="bd-product__old-price"><del>'.$this->currency.''.$market_price.'</del></span>
                        <span class="bd-product__new-price product_price_'.$pid.'">'.$this->currency.''.$f_price.'</span>
                    </div>

                    <div class="ratings-container">
                        <div class="ratings-full">
                            <span class="ratings" style="width:80%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <a style="display:none" href="#product-tab-reviews" class="link-to-tab rating-reviews">( 11 reviews )</a>
                    </div>
                    <p class="product-short-desc">Sed egestas, ante et vulputate volutpat, eros pede semper
                        est, vitae luctus metus libero eu augue. Morbi purus liberpuro ate vol faucibus
                        adipiscing.</p>
                    <div class="offer_label_'.$pid.'">'.$all_users.'</div>                    
                    '.$size_arry.'

                    '.$as.'

                    <hr class="product-divider">

                    <div class="product-form product-qty">
                        <div class="product-form-group">
                            <div class="input-group mr-2">
                                <button class="quantity-minus d-icon-minus" data-id="'.$pid.'" ></button>
                                <input class="minimum_a_t_c_'.$pid.'" type="hidden" data-incremental_qty="'.$incremental_qty.'" data-min="'.$minimum_add_to_cart.'" >
                                <input class="m_input p_qty_'.$pid.'" type="number" value="'.$count_add.'" readonly>
                                <button class="quantity-plus d-icon-plus" data-id="'.$pid.'" ></button>
                            </div>
                            <div class="clear"> </div>
                            <a href="javascript:void(0);" class="modal_add_cart boskery-btn product__item__link add_to_cart product_'.$pid.'" data-id="'.$pid.'" data-toggle="modal" data-target="#addCartModal" title="Add to cart">Add to cart
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                            <a style="display:none" href="javascript:void(0);" class="boskery-btn product__item__link modal_wishlist '.$wclass.' " data-id="'.$pid.'" data-toggle="modal" data-target="#addCartModal" title="'.$wtitle.'">Add to wishlist<i class="'.$wicon.'"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>'; die;
    }

    public function get_checkout_amt()
    {
        $voucher_id = $stta = '';
        $post_data = $this->request->getPost();

        // echo "<pre>";
        // print_r($post_data);
        // die;

        $uid        = $this->user_id;
        $wall_amt   = @$post_data['wall_amt'];
        $code       = @$post_data['code'];
        $lat       = @$post_data['lat'];
        $lng       = @$post_data['lng'];

        if (!empty($code))
        {
            $data = $this->db_model->get_data_array("SELECT id,amount,code,type,start_date,end_date FROM vouchers WHERE  `code` = '$code' ");
            if (empty($data)) {
                $_SESSION['voucher_id'] = '';
                echo json_encode( array( "status" => false ,"message" => 'Invalid voucher code ') );die;
            }
            else{
                $voucher_id = $data[0]['id'];
            }
        }

        $voucher_message = $voucher_code = '';
        $voucher_amount = 0;
        
        $p_data['lat'] = $lat;
        $p_data['lng'] = $lng;

        if ($voucher_id) 
        {

            $p_arr = $this->check_login->validate_voucher_checkout($voucher_id,$uid,$p_data);
            
            // echo "<pre>";
            // print_r($p_arr);
            // die;

            if ($p_arr['status'] == true){
                $_SESSION['voucher_id'] = $voucher_id;
                $voucher_message = $p_arr['message'];;
                $voucher_code = $p_arr['voucher_code'];
                $voucher_id = $p_arr['voucher_id'];
                $voucher_amount = $p_arr['voucher_amount'];
            }
            else{
                $stta = false;
                $_SESSION['voucher_id'] = '';
                $voucher_id = '';
                $voucher_message = $p_arr['message'];
            }
        }
        else{
            $_SESSION['voucher_id'] = '';
            $voucher_id = '';
        }


        $cart_data = $this->check_login->view_cart_deta($uid,$wall_amt,$voucher_amount,$p_data);
        $cart_data['price_summary']['voucher_code'] = $voucher_code;
        $cart_data['price_summary']['voucher_message'] = $voucher_message;
        $cart_data['price_summary']['voucher_id'] = $voucher_id;

        // echo "<pre>";
        // print_r($cart_data['price_summary']);
        // die;
    
        echo json_encode( array("status" => true,"info" => $cart_data['price_summary']) );die;       
    }

    public function search_assets()
    {
        $language = "en";

        $uid = $this->user_id;
        $post_data = $this->request->getPost();
            if ($post_data) {
                $response = array();
                $string = $post_data['string'];
                $search_category = @$post_data['search_category'];
                if (empty($string)) {
                    $response[] = '';
                    echo json_encode(array_slice($response, 0, 10));
                }
                else
                {
                    $query = '';
                    if ($search_category) {
                        $query = "AND `category` = '$search_category' ";
                    }
                    $critical_search = $this->db_model->get_data_array("SELECT id,product_name FROM product WHERE (product_name LIKE '%$string%' OR `created_date` LIKE '%$string%' OR category_name LIKE '%$string%' OR tags LIKE '%$string%' ) $query  AND `product_delete` = '0' AND `status` = '1' ORDER BY id DESC LIMIT 30 ");

                    if ($critical_search) {
                        foreach ($critical_search as $key => $value)
                        {
                            $response[] = '<div  onclick="location.href=\''.base_url('/product/').$value['id'].'\'" class="point_me search_drop_down" >'.$value['product_name'].'</div>';
                        }
                    }
                    else{
                        $response[] = '<div class="point_me search_drop_down" >No data found.</div>';
                    }

                    echo json_encode(array_slice($response, 0, 30));
                }
            }
    }
}