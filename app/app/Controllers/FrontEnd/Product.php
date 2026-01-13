<?php

namespace App\Controllers\FrontEnd;
use App\Libraries\EmailTemplate;
use App\Libraries\CommonFun;
use App\Libraries\Check_login;

class Product extends FrontController
{
    protected $comf;
    protected $email_t;
    protected $check_login;
    protected $db;

    function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->comf   = new CommonFun();
        $this->email_t  = new EmailTemplate();
        $this->check_login  = new Check_login();
    }

    public function index($id="")
    {
        $user_id = $this->user_id;
        $product_listing = $this->db_model->get_data_array("SELECT * FROM product as pro  WHERE pro.status='1' AND pro.product_delete='0' AND pro.id='".$id."'  ");
        $product_detail = $this->check_login->get_all_product_data($product_listing,$user_id);
        if(!empty($product_detail))
        {
            $past_sale_product = $this->db_model->get_data_array("SELECT pro.id,pro.category,pro.product_name,pro.price,pro.sale_price,pro.stock_status,pro.stock,pro.product_image,pro.price_select,pro.image_gallery FROM product as pro INNER JOIN order_items as ori ON pro.id=ori.product_id WHERE pro.status='1' AND pro.product_delete='0' GROUP BY ori.product_id  ORDER BY pro.id DESC LIMIT 8");
            $past_sale_product = $this->check_login->get_all_product_data($past_sale_product,$user_id);

            $related_product = $this->db_model->get_data_array("SELECT id,category,product_name,price,sale_price,stock_status,stock,product_image,price_select,image_gallery FROM product WHERE product_delete='0' AND status='1' AND (category='".$product_detail[0]["category"]."') ORDER BY id DESC LIMIT 8");
            $related_product = $this->check_login->get_all_product_data($related_product,$user_id);
        }
        
        $rating_data = $this->check_login->getProductDetailRating($id);
        $rating_one_five = $this->check_login->get_rating_one_to_five_in_percentage($id);



        $next_product = $this->db_model->get_data_array("SELECT id,product_name,product_image FROM product  WHERE `status` = '1' AND `id` > '$id' LIMIT 1");
        if (empty($next_product)) {
            $next_product = $this->db_model->get_data_array("SELECT id,product_name,product_image FROM product  WHERE `status` = '1' ORDER BY `id` ASC LIMIT 1 ");
        }

        $previous_product = $this->db_model->get_data_array("SELECT id,product_name,product_image FROM product  WHERE `status` = '1' AND `id` < '$id' ORDER BY id DESC LIMIT 1");
        if (empty($previous_product)) {
            $previous_product = $this->db_model->get_data_array("SELECT id,product_name,product_image FROM product  WHERE `status` = '1' AND `id` > '$id' ORDER BY id DESC LIMIT 1");
        }
        
        // echo "<prE>";
        // print_r($product_detail);
        // die;

        $this->check_login->add_product_recent_view($id , $this->user_id);
        $this->mViewData['rating_one_five'] = $rating_one_five;
        $this->mViewData['next_product'] = $next_product;
        $this->mViewData['previous_product'] = $previous_product;
        $this->mViewData['related_product'] = $related_product;
        $this->mViewData['past_sale_product'] = $past_sale_product;
        $this->mViewData['product_detail'] = $product_detail[0];
        $this->mViewData['rating_data'] = $rating_data;
        // return redirect()->to(base_url('/admin'));
        $this->Urender('product_details','default', $page_name = 'Product Detail');
    }

    public function catList($cat_id="",$sub_cat_id="")
    {
        $rowperpage = 15;
        $user_id = @$_SESSION['uid'];
        $rowno=0; $ajax='call';  $search= $search_type ='';
        $where_cond ="WHERE pro.status='1' AND pro.product_delete='0' ";

        $page_arr= $data = array();
        $post_data = $this->request->getPost();

        $sort = 'id';
        $sort_by = 'DESC';

        $product_view = '';
        if (!empty($post_data))
        {
            $search = $post_data['search'];
            $rating_selected = $post_data['rating_selected'];
            $price_range = $post_data['price_range'];
            $product_view = $post_data['view'];
            
            if ($price_range) 
            {
                preg_match_all('/\d+/', $price_range, $matches);
                // The numbers will be in the $matches[0] array
                $startPrice = $matches[0][0];
                $endPrice = $matches[0][1];
                $where_cond.="AND pro.sale_price BETWEEN $startPrice AND $endPrice"; 
            }

            if ($rating_selected) 
            {
                $lowerBound = $rating_selected;
                $upperBound = $rating_selected + 0.9;

                $where_cond.=" AND pro.avg_rating BETWEEN $lowerBound AND $upperBound"; 
            }
            
            if ($search) 
            {
                $where_cond.=" AND pro.product_name LIKE '%$search%' "; 
            }

            if (!empty($post_data['sort_by'])) {
                $s_array = explode(',', $post_data['sort_by']);
                $sort = $s_array[0];
                $sort_by = $s_array[1];
            }

            $rowperpage = $post_data['count'];
            $rowno = $post_data['pagno'];
            $ajax   = $post_data['ajax'];
            if(isset($post_data['gcat_ids']) && !empty($post_data['gcat_ids']))
            {
                $g_ids = $post_data['gcat_ids'];
                $where_cond.=" AND pro.category IN($g_ids) ";
            }
        }

        $get_data=$this->request->getGet(); 

        if (!empty($get_data)){
            $rowno = $get_data['page'];
        }

        if(!empty($cat_id) && !empty($sub_cat_id) ){
            $where_cond.="AND pro.category='".$cat_id."' AND subcategory='".$sub_cat_id."' "; 
        }else if(!empty($cat_id))
        {
           $where_cond.="AND pro.category='".$cat_id."' "; 
        }
                
        if($rowno != 0){
            $active_page=$rowno;
            $rowno = ($rowno-1) * $rowperpage;
        }else{
            $active_page=1;
            $rowno=0;
        }

        $info_data = $this->db_model->get_data_array("SELECT id,product_name,product_image,price,sale_price,short_description,category,price_select FROM product as pro $where_cond ORDER BY $sort $sort_by LIMIT $rowno,$rowperpage  ");
        $info_data = $this->check_login->get_all_product_data($info_data,$user_id);
        $data_count = $this->db_model->get_data_array(" SELECT COUNT(pro.id) as data_count FROM product as pro $where_cond  ");

        // echo $this->db->getLastQuery(); die;

        $page_arr['active_page'] = $active_page;
        $page_arr['rowperpage'] = $rowperpage;
        $page_arr['data_count'] = $data_count[0]['data_count'];

        $msg = "Showing Total ".$data_count[0]['data_count']." Results";

        if($ajax =='call' && $rowno==0 && empty($post_data)){                   
            $this->mViewData['pagination_link'] = $this->pagination($page_arr);                       
        }else { // this for pagination-
            $data['msg'] = $msg;
            $data['status'] = true;
            $data['pagination_link'] = $this->pagination($page_arr);
            // $data['result'] = $info_data;
            $data['result'] = $this->producthtml($info_data,$product_view);
            $data['row'] = $rowno;
            $data['total_rows'] = $page_arr['data_count']; 
            $data['message'] = ""; 
            echo json_encode($data);
            die;   
        }    

        $this->mViewData['info_data']=$info_data;
        $this->mViewData['data_count']=$data_count[0]['data_count'];
        if(!empty($cat_slug)){
            $cat_name = str_replace("-"," ",$cat_slug);
            $cat_name = ucwords($cat_name);            
        }else{
            $cat_name="All Product Listing";
        }


        $cat_listing = $this->db_model->get_data_array("SELECT id,display_name FROM category WHERE `parent` = '0' AND `status` = 'active' ORDER BY RAND() ");
        $cat_title = "All Categories";
        if (!empty($cat_id)) {
            $cat_listing = $this->db_model->get_data_array("SELECT id,display_name FROM category WHERE `parent` = '$cat_id' ORDER BY `id` ASC ");
            $cat_title = $this->get_cat_name($cat_id);
        }

        $this->mViewData['cat_title'] = $cat_title;
        $this->mViewData['cat_listing'] = $cat_listing;
        $this->mViewData['msg'] = $msg;
        $this->mViewData['cat_name'] = $this->get_cat_name($cat_id);
        $this->mViewData['sub_cat_name'] = $this->get_cat_name($sub_cat_id);
        $this->mViewData['sub_cat_id'] = $sub_cat_id;
        $page_name = "Product List";
        $this->Urender('product_listing','default', $page_name);         
    }

    private function producthtml($product_data , $product_view = '')
    {
        $html_tag='';
        if(!empty($product_data))
        {
            $i=1;
            foreach ($product_data as $pkey => $pvalue) 
            {
                $pro_url = '';
                $rating_element = '1';
                $wish_list = '1';
                $per_off_lab = '10%';

                $prod_detail_url = base_url('product/').$pvalue['id'];
                $category_url = base_url('category/').$pvalue['category'];
                
                $shop_name = $pvalue['shop_name'];
                $short_description = $pvalue['short_description'];
                $add_label = $pvalue['add_label'];
                $sale_price = $pvalue['sale_price'];
                $product_image = $pvalue['product_image'];
                $pid = $pvalue['id'];
                $product_name = $pvalue['product_name'];
                $price = $pvalue['price'];
                $category_name = $pvalue['category_name'];
                $user_rating_count = $pvalue['user_rating_count'];
                $avg_rating = $pvalue['avg_rating']*20;

                if ($pvalue['is_in_wish_list'] == '') {
                    $wclass = '';
                    $wicon = 'd-icon-heart';
                    $wtitle = 'Add to wishlist';
                }
                else
                {
                    $wtitle = 'Remove from wishlist';
                    $wclass = 'added';
                    $wicon = 'd-icon-heart-full';
                }

                $rating = $pvalue['avg_rating'];
                $rate = "<span class='stars'>";
                    for ( $i = 1; $i <= 5; $i++ ) {
                    if ( round( $rating - .25 ) >= $i ) {
                        $rate.= "<i class='fa fa-star' style='font-size:20px;color:#ff9f00;'></i>"; //fas fa-star for v5
                    } elseif ( round( $rating + .25 ) >= $i ) {
                        $rate.= "<i class='fa fa-star-half' style='font-size:20px;color:#ff9f00;'></i>";//fas fa-star-half-alt for v5
                    } else {
                        $rate.= "<i class='fa fa-star' style='font-size:20px;color:#ff9f00;'></i>"; //far fa-star for v5
                    }
                    }
                $rate.= '</span>';

                $sze = '';
                if ($pvalue['size']) {
                    $sze = "(".$pvalue['size'].')';
                }

                if ($product_view == 'landscape') 
                {
                    $prize_select = '';
                    if ($pvalue['price_select'] == '1' || $pvalue['price_select'] == '3')
                    {
                        // $prize_select = '<a href="javascript:void(0);" class="btn_quickview cart-btn bd-add__cart-btn  add_to_cart product_'.$pid.'" data-id="'.$pid.'" title="Add to cart"> <span class="boskery-btn__text">'.$add_label.'</span></a>';

                        $prize_select = '<a data-id="'.$pid.'" class="btn_quickview cart-btn bd-add__cart-btn" href="javascript:void(0)">Preview</a>';
                    }
                    if ($pvalue['price_select'] == '2')
                    {
                        $prize_select = '<a data-id="'.$pid.'" class="btn_quickview cart-btn bd-add__cart-btn" href="javascript:void(0)">Preview Size</a>';
                    }


                    $html_tag.='<div class="bd-grid__singel-item mb-30">
                                    <div class="row align-items-center">
                                        <div class="col-xxl-4 col-lg-6 col-md-6">
                                            <div class="bd-trending__item">
                                                <div class="bd-trending__product-thumb text-center">
                                                    <a href="'.$prod_detail_url.'"><img src="'.$product_image.'"
                                                        alt="product-img"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-8 col-lg-6 col-md-6">
                                            <div class="bd-trending__content">
                                                <div class="bd-product__content mb-10">
                                                    <div class="food_truck_dtl">'.$shop_name.'</div>
                                                    <h4 class="bd-product__title"><a href="'.$prod_detail_url.'">'.$product_name.'</a></h4>
                                                    <div class="bd-product__price">
                                                        <span
                                                            class="bd-product__old-price"><del>'.$this->currency.''.$price.'</del></span><span
                                                            class="bd-product__new-price">'.$this->currency.''.$sale_price.' '.$sze.'</span>
                                                    </div>
                                                </div>
                                                '.$rate.'
                                                <p class="mb-25">'.$short_description.'</p>
                                                <div class="bd-product__action-btn">
                                                    '.$prize_select.'
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                }
                else
                {
                    $html_tag.='<div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="bd-trending__item mb-45 text-center">
                                    <div class="bd-trending__product-thumb">
                                        <a href="'.$prod_detail_url.'"><img class="img_listing" src="'.$product_image.'" alt="product-img"></a>
                                        <div class="bd-product__action">
                                            <a data-id="'.$pid.'"  class="cart-btn btn_quickview" href="javascript:void(0)"><i
                                                class="fal fa-cart-arrow-down"></i></a>
                                        </div>
                                    </div>
                                    <div class="bd-trending__content">
                                        <div class="food_truck_dtl">'.$shop_name.'</div>
                                        <h4 class="bd-product__title">
                                            <a href="'.$prod_detail_url.'">'.$product_name.'</a>
                                        </h4>
                                        <div class="bd-product__price">
                                            <span class="bd-product__old-price"><del>'.$this->currency.''.$price.'</del></span>
                                            <span class="bd-product__new-price">'.$this->currency.''.$sale_price.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                }
                $i++;
            }
        } 
        return $html_tag;   
    }

    public function getProductName()
    {
        $post_data=$this->request->getPost();

        if(!empty($post_data))
        {   
            $search = $this->comf->test_input($post_data['search']); 
            $product_data = $this->db_model->get_data_array("SELECT id,product_name,price,sale_price,stock_status,stock,product_image,price_select FROM product WHERE (product_name LIKE '%$search%' OR sku LIKE '%$search%' ) AND `product_delete`='0' AND `status`='1' ORDER BY `product_name` ASC LIMIT 30  "); 
            $product_data = $this->related_menu($product_data,$is_catetory=false,$is_wish=false,$is_rating=true,$language='');
            $html_tag = $this->searchHtmlTag($product_data);
            echo json_encode(array("status"=>true,"message"=>"Successfully","data"=>$html_tag)); die;
        }else{
            echo json_encode(array("status"=>false,"message"=>"Something Went Wrong")); die;
        }
    }

    public function get_cat_name($cat_id = '')
    {
        $cdata = $this->db_model->get_data_array("SELECT display_name FROM category WHERE `id`='$cat_id' "); 
        if(!empty($cdata)){
            return $cdata[0]['display_name'];
        }
    }

    private function searchHtmlTag($product_data)
    {
        $html_tag='<ul class="custom-scroll">';
        if(!empty($product_data))
        {
            foreach ($product_data as $key => $val) {
                $html_tag.='<li>';
                    $html_tag.='<a href="'.$val['pro_url'].'" class="product-cart media">';
                        $html_tag.='<img src="'.$val['product_image'].'" class="img-fluid blur-up lazyload" alt="">';
                        $html_tag.='<div class="media-body">';
                            $html_tag.='<span><h6 class="mb-1">'.$val['product_name'].'</h6></span>';
                            $html_tag.='<ul class="rating">'.$val['rating_element'].'</ul>';
                            $html_tag.='<p class="mb-0 mt-1">$'.$val['sale_price'].'</p>';
                        $html_tag.='</div>';  //media-body
                    $html_tag.='</a>';  //media

                $html_tag.='</li>';
            }
        }else{
            $html_tag.='<li>';
                $html_tag.='<div class="media-body">';
                    $html_tag.='<a><h6 class="mb-1">Product Not Found.!!</h6></a>';
                $html_tag.='</div>'; 
            $html_tag.='</li>';
        }

        $html_tag.='</ul>';
        return $html_tag;
    }

    public function add_review($pid="")
    {
        $user_id = $this->user_id;
        $pid = en_de_crypt($pid,'d');

        $post_data = $this->request->getPost();
        if (!empty($post_data))
        {
            if (empty($post_data['title'])) {
                echo json_encode(array("status"=>false,"message" => "Please enter title.")); die;
            }
            if (empty($post_data['rating'])) {
                echo json_encode(array("status"=>false,"message" => "Please select rating.")); die;
            }
            if ($post_data['rating'] > 5) {
                echo json_encode(array("status"=>false,"message" => "Invalid request.")); die;
            }
            if (empty($post_data['comment'])) {
                echo json_encode(array("status"=>false,"message" => "Please add review.")); die;
            }

            $FILES = $_FILES['image'];
            $FILES_1 = $_FILES['image1'];
            $upload_dir = ROOTPATH . "public/product/rating/";


            $rating_image = $this->upload_banner_img($FILES,$upload_dir);
            $rating_image_1 = $this->upload_banner_img($FILES_1,$upload_dir);

            if (!empty($rating_image)) {
                $post_data['rating_image'] = $rating_image;
            }
            if (!empty($rating_image_1)) {
                $post_data['rating_image_1'] = $rating_image_1;
            }

            if ($user_id) {
                $post_data['uid'] = $user_id;
                $udata = $this->db_model->get_data_array("SELECT id,first_name,last_name FROM admin_users WHERE `id` = '$user_id' ");
                $post_data['name'] = $udata[0]['first_name'].' '.$udata[0]['last_name'];
            }
            if ($post_data['order_id']) {
                $post_data['order_id'] = en_de_crypt($post_data['order_id'],'d');
            }
            
            $post_data['pid'] = $pid;
            $post_data['created_date'] = date("Y/m/d H:i:s");
            $post_data['status'] = "pending";
            $this->db_model->my_insert($post_data , 'user_rating');

            echo json_encode(array("status"=>true,"message" => "Product review added successfully.")); die;
        }



        // echo "<pre>";
        // print_r($_GET);
        // die;
        
        $p_listing = $this->db_model->get_data_array("SELECT id,product_name,product_image FROM product WHERE `product_delete` = '0' AND `id` = $pid ");
        if (empty($p_listing)) {
            return redirect()->to(base_url());
        }

        $this->mViewData['p_data'] = $p_listing;
        $this->Urender('product_rating','default', $page_name = 'Review Your Purchases');
    }

    public function upload_banner_img($FILES,$upload_dir)
    {
        if (isset($FILES['name'])) {
            // $upload_dir = ASSETS_PATH . "/admin/products/";
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
}