<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;
use App\Libraries\Check_login;

class Product extends AdminController
{   
    protected $comf;
    protected $check_login;
    function __construct()
    {
       $this->comf = new CommonFun();
       $this->check_login = new Check_login();
       $this->is_logged_in();
    }    

    public function index()
    {
        $type = $this->admin_data[0]['type'];

        $rowno = 0;
        $ajax = 'call';
        $search  = $where_cond = "";
        $checkbox_msg = "Product listing";
        $page_arr = $data = array();

        $post_data = $this->request->getPost(); 

        $sort = 'product.id';
        $sort_by = 'DESC';
        if (!empty($post_data))
        {
            $rowno = $post_data['pagno'];
            $ajax   = $post_data['ajax'];
            $search = $post_data['search'];
            $cat_id = $post_data['cat_id'];
            $filter_by = $post_data['filter_by'];
            $s_by = $post_data['sort_by'];
            $c_box_type = $post_data['c_box'];

            if (!empty($s_by)) {
                $s_array = explode(',', $s_by);
                $sort = 'product.'.$s_array[0];
                $sort_by = $s_array[1];
            }

            if ($c_box_type) 
            {
                if ($c_box_type == 'fast_moving') {
                    $date = date("Y-m-d");
                    $p_data['start_date'] = date('Y-m-d', strtotime($date. ' - 7 days'));
                    $p_data['end_date'] = date('Y-m-d', strtotime($date. ' - 1 days'));
                    $top_selled = $this->check_login->fast_moving_product($p_data);
                    $msg = "Products have been ordered twice or more in the last 1 week";
                }
                elseif ($c_box_type == 'slow_moving') {
                    $date = date("Y-m-d");
                    $p_data['start_date'] = date('Y-m-d', strtotime($date. ' - 30 days'));
                    $p_data['end_date'] = date('Y-m-d', strtotime($date. ' - 1 days'));
                    $top_selled = $this->check_login->slow_moving_product($p_data);
                    $msg = "Products have sold one or less than five times once in a month";
                }
                elseif ($c_box_type == 'non_moving') {
                    $date = date("Y-m-d");
                    $p_data['start_date'] = date('Y-m-d', strtotime($date. ' - 30 days'));
                    $p_data['end_date'] = date('Y-m-d', strtotime($date. ' - 1 days'));
                    $top_selled = $this->check_login->non_moving_product($p_data);
                    $msg = "Products have no order in the last 30 days or more";
                }
                elseif ($c_box_type == 'most_viewed') {
                    $top_selled = $this->check_login->most_viewed();
                    $msg = "Most product viewed till now";

                    $sort = 'product.view_count';
                    $sort_by = 'DESC';
                }

                if (!empty($top_selled)) {
                    $checkbox_msg = $msg;
                    $where_cond.= "AND product.id IN ($top_selled) ";
                }

            }

            if (!empty($cat_id)) {
                $where_cond.= "AND product.category = '$cat_id' ";
            }
            
            if(!empty($search)) {
                $where_cond.=" AND (product.product_name LIKE '%$search%' OR category_name LIKE '%$search%' OR product.stock LIKE '%$search%' OR product.stock_status LIKE '%$search%' ) ";                
            }
            if (!empty($filter_by)) {
                $myArray = explode(',', $filter_by);
                $field_name = $myArray[0];
                $field_value = $myArray[1];
                $where_cond.= "AND product.$field_name = '$field_value' ";
            }
        }
        
        if ($type == 'seller') {
            $seller_id = $this->admin_data[0]['id'];
            $where_cond.= " AND product.seller_id = '$seller_id' ";
        }



        $rowperpage = 40;
        
        if($rowno != 0) {
            $active_page=$rowno;
            $rowno = ($rowno-1) * $rowperpage;
        } else {
            $active_page=1;
            $rowno=0;
        }

        $info_data = $this->db_model->get_data_array("SELECT category.display_name as category_name,product.id,product.product_name,product.product_image,product.status,product.category,product.stock,product.stock_status,product.seller_id FROM product LEFT JOIN category ON category.id = product.category WHERE product.id != '' $where_cond ORDER BY $sort $sort_by limit $rowno,$rowperpage ");

        if (!empty($info_data)) 
        {
            foreach ($info_data as $key => $value) 
            {
                $status = $value['status'];
                $product_id = en_de_crypt($value['id']);
                $info_data[$key]['product_id'] = $product_id;

                $url = '<a href=" '.base_url('admin/product/edit/').$product_id.'" target="_blank" class=""><button class="btn btn-sm btn-success"><i class="fa fa-pencil "></i></button></a> ';

                $url.= '<a class="delete_product" href="javascript:void(0);" data-id="'.$product_id.'" ><button class="btn btn-sm btn-warning"><i class="fa fa-trash "></i></button></a> ';

                $a_status = 'Deactive';
                if ($status == '1') {
                    $a_status = 'Active';
                }
                $info_data[$key]['status'] = $a_status;

                $info_data[$key]['action_url'] = $url;
                $info_data[$key]['product_image'] = base_url("public/admin/products/").$value['product_image'];
            }
        }
        $data_count = $this->db_model->get_data_array(" SELECT COUNT(id) as data_count FROM product WHERE `product_delete` = '0' $where_cond  ");
        
        $page_arr['active_page'] = $active_page;
        $page_arr['rowperpage'] = $rowperpage;
        $page_arr['data_count'] = $data_count[0]['data_count'];

        if($ajax =='call' && $rowno==0 && empty($post_data)){
            $this->mViewData['pagination_link'] = $this->pagination($page_arr);
        }else { // this for pagination-
            $data['status'] = true;
            $data['pagination_link'] = $this->pagination($page_arr);
            $data['result'] = $info_data;
            $data['row'] = $rowno;
            $data['total_rows'] = $page_arr['data_count']; 
            $data['message'] = ""; 
            $data['checkbox_msg'] = $checkbox_msg; 
            echo json_encode($data);
            die;
        }
        
        $category_l = $this->db_model->my_where("category","id,display_name",array("parent" => '0'),array(),"","","","", array(), "",array(),false  );
        $this->mViewData['category_l'] = $category_l;
        $this->mViewData['product'] = $info_data;
        $this->Urenderadmin('product/listing','default', $page_name = 'Product Listing');
    }

    public function add()
    {
        $language = 'en';
        $post_data = $this->request->getPost();
        
        if ( !empty($post_data))
        {
            $product_name = $post_data['product_name'];
            $sku = $post_data['sku'];
            $short_description = $post_data['short_description'];
            $category = $post_data['category'];
            $stock_status = $post_data['stock_status'];
            $stock = $post_data['stock'];
            $description = $post_data['description'];
            $status = $post_data['status'];
            $tax = $post_data['tax'];
            $price_select = $post_data['price_select'];
            $price = $post_data['price'];
            $sale_price = $post_data['sale_price'];

            $post_data['category_name'] = $this->cat_name_get($post_data['category']);
            
            $extra_name = $post_data['extra_name'];
            $extra_price = $post_data['extra_price'];

            unset($post_data['extra_name']);
            unset($post_data['extra_price']);

            // echo "<pre>";
            // print_r($post_data);
            // die;
        
            $attribute = @$post_data['attribute2'];
            if(!empty($attribute)) {
                $attribute = explode(",",$attribute);
            }

            // $this->attribute_img_barcode($product_id,$attribute);
            
            $attribute_price = @$post_data['attribute_price'];
            $attribute_sale_price = @$post_data['attribute_sale_price'];
            
            unset($post_data['attribute']);
            unset($post_data['attribute_price']);
            unset($post_data['attribute_sale_price']);
            unset($post_data['attribute2']);                    
            
            if($post_data['price_select']==2)
            {
                unset($post_data['price']);
                unset($post_data['sale_price']);
            }

            if (!empty($post_data['gallery_images'])) 
            {
                $post_data['image_gallery'] = implode(',', $post_data['gallery_images']); 
            }
            unset($post_data['gallery_images']);
            
            // $post_data['image_gallery'] = trim($post_data['image_gallery'],',');


            $product_image = $_FILES['product_image'];
            $upload_dir = ROOTPATH . "public/admin/products/";

            $p_image = $this->upload_product_img($product_image,$upload_dir);
            if ($p_image) 
            {
                $post_data['product_image'] = $p_image;
            }

            // echo "<pre>";
            // print_r($post_data);
            // die; 

            $post_data['seller_id'] = $post_data['shop_id'];
            $response = $this->db_model->my_insert($post_data,'product');

            if (!empty($extra_name)) {
                foreach ($extra_name as $ekey => $evalue) {
                    $idata['pid']  = $response;
                    $idata['name']  = $evalue;
                    $idata['price'] = $extra_price[$ekey];
                    if ($idata['name']) {
                        $this->db_model->my_insert($idata,'product_custimze_details');
                    }
                }
            }
            
            //update attribute
            if($post_data['price_select']==2)
            {
                if (!empty($attribute))
                {
                    foreach ($attribute as $ak => $aval)
                    {
                        $size_id = $this->db_model->my_where('attribute_item','a_id',array('id' => $aval));

                        $this->db_model->my_insert(['attribute_id' => $size_id[0]['a_id'], 'p_id' => $response, 'item_id' => $aval,'price'=>$attribute_price[$ak],'sale_price'=>$attribute_sale_price[$ak]], 'product_attribute');
                    }
                }
            }


            echo json_encode(array("status"=>true,"message" => "Product created successfully")); die;

        }

        $acategories = $this->db_model->my_where('category','*',array('status' => 'active'),array(),"parent","asc","","",array(),"object");

        $acatp = array();
        if(!empty($acategories)){
            foreach ($acategories as $ckey => $cvalue) {
                $parent = $cvalue->parent;
                $acatp[$parent][] = $cvalue;
            }
        }
        $this->mViewData['acatp'] = $acatp;


        $category = $this->db_model->my_where('category','*',array('status' => 'active','parent'=>'0'),array(),"parent","asc","","",array(),"");
        $this->mViewData['category'] = $category;

        $attribute = $this->db_model->get_data("SELECT * FROM attribute WHERE `id` = '20' ");       
        $attribute = json_decode( json_encode($attribute), true);
        if (!empty($attribute))
        {
            foreach ($attribute as $key => $value)
            {
                $aid = $value['id'];

                $attribute_item = $this->db_model->get_data("SELECT * FROM attribute_item WHERE `status`='1' AND  a_id = ".$value['id']);
                $attribute_item = json_decode( json_encode($attribute_item), true);
                $attribute[$key]['item'] = $attribute_item;
            }
        }

        $shop_listing = $this->db_model->my_where("admin_users","id,first_name as display_name",array("active" => '1',"type" => 'seller'),array(),"","","","", array(), "",array(),false  );
        $this->mViewData['shop_listing'] = $shop_listing;

        $this->mViewData['attribute'] = $attribute;
        $this->Urenderadmin('product/add','default', $page_name ='Add product');
    }

    public function edit($sub_cat_id ='')
    {
        $product_id = en_de_crypt($sub_cat_id,'d');
        $post_data = $this->request->getPost();

        if ( !empty($post_data) )
        {
            $post_data['category_name'] = $this->cat_name_get($post_data['category']);
            if (!empty($post_data['gallery_images'])) 
            {
                $post_data['image_gallery'] = implode(',', $post_data['gallery_images']); 
            }
            unset($post_data['gallery_images']);

            $extra_name = $post_data['extra_name'];
            $extra_price = $post_data['extra_price'];
            $extra_name_added = @$post_data['extra_name_added'];
            $extra_price_added = @$post_data['extra_price_added'];
            $extra_id_added = @$post_data['extra_id_added'];

            unset($post_data['extra_name']);
            unset($post_data['extra_price']);
            unset($post_data['extra_id_added']);
            unset($post_data['extra_name_added']);
            unset($post_data['extra_price_added']);

            // echo "<pre>";
            // print_r($post_data);
            // die;

            $product_image = $_FILES['product_image'];
            $upload_dir = ROOTPATH . "public/admin/products/";

            $p_image = $this->upload_product_img($product_image,$upload_dir);
            if ($p_image) {
                $post_data['product_image'] = $p_image;
            }

            if(!isset($post_data['special_menu'])) {
                $post_data['special_menu']='0';
            }
            if (empty($post_data['attribute2'])) {
                unset($post_data['attribute2']);
            }

            if (!empty($post_data['attribute'])) 
            {
                $attribute2 = $post_data['attribute2'];
                $attribute_price = $post_data['attribute_price'];
                $attribute_sale_price = $post_data['attribute_sale_price'];
                $attribute2 = explode(",",$attribute2);

                unset($post_data['attribute2']);
                unset($post_data['attribute_price']);
                unset($post_data['attribute_sale_price']);
                foreach ($attribute2 as $ak1 => $aval1)
                {
                    //print_r($colorr);
                    ///$this->db_model->my_insert(['p_id' => $product_id, 'item_id' => $aval1], 'product_attribute');

                    $colorr = $this->db_model->my_where('attribute_item','item_name',array('id' => $aval1,'a_id' => '19'));
                    foreach ($colorr as $ekey => $evalue) {
                        $tags[] = implode(',', $evalue);
                        // echo $tags;
                    }                   
                }
            }
                        
            // $post_data['image_gallery'] = trim($post_data['image_gallery'],',');

            $attribute = isset($post_data['attribute'])? $post_data['attribute']:[];
            if(!empty($attribute2)){
                $attribute = $attribute2;
            } 

            if(isset($post_data['attribute'])) unset($post_data['attribute']);

            $post_data['seller_id'] = $post_data['shop_id'];

            // echo "<prE>";
            // print_r($post_data);
            // die;
            
            $response = $this->db_model->my_update($post_data,array('id' => $product_id),'product');

            $this->db_model->my_delete(['p_id' => $product_id], 'product_attribute');
            foreach ($attribute as $ak => $aval)
            {
                $size_id = $this->db_model->my_where('attribute_item','a_id',array('id' => $aval));

                $this->db_model->my_insert(['attribute_id' => $size_id[0]['a_id'], 'p_id' => $product_id, 'item_id' => $aval,'price'=>$attribute_price[$ak],'sale_price'=>$attribute_sale_price[$ak]], 'product_attribute');
                // $this->db_model->my_insert(['attribute_id' => $size_id[0]['a_id'], 'p_id' => $product_id, 'item_id' => $aval], 'product_attribute');
            }

            if (!empty($extra_name)) {
                foreach ($extra_name as $ekey => $evalue) {
                    $idata['pid']  = $product_id;
                    $idata['name']  = $evalue;
                    $idata['price'] = $extra_price[$ekey];
                    if ($idata['name']) {
                        $this->db_model->my_insert($idata,'product_custimze_details');
                    }
                }
            }
            if (!empty($extra_name_added)) {
                foreach ($extra_name_added as $ukey => $evalue) {
                    $udata['name']  = $evalue;
                    $udata['price'] = $extra_price_added[$ukey];
                    if ($udata['name']) {
                        $this->db_model->my_update($udata,array('id' => $extra_id_added[$ukey]),'product_custimze_details');
                    }
                }
            }

            echo json_encode(array("status"=>true,"message" => "Product updated successfully")); die;
        }

        $product_data = $this->db_model->my_where('product','*',array('id' => $product_id),array(),"","","","",array(),"object");
        
        $p_attr = $this->db_model->my_where('product_attribute', '*', ['p_id' => $product_id]);
        $patr = array();
        foreach ($p_attr as $pakey => $pavalue)
        {
            $patr[] = $pavalue['item_id'];
        }

        foreach ($p_attr as $pakey2 => $pavalue2)
        {
            $attribute_item2 = $this->db_model->get_data_array("SELECT * FROM attribute_item WHERE id = ".$pavalue2['item_id']);
            $p_attr[$pakey2]['item_name']=$attribute_item2[0]['item_name'];
            
        }
        $this->mViewData['product_attribute'] = $patr;

        $attribute = $this->db_model->get_data("SELECT * FROM attribute WHERE `id` = '20' ");
        $attribute = json_decode( json_encode($attribute), true);
        foreach ($attribute as $key => $value)
        {
            $attribute_item = $this->db_model->get_data("SELECT * FROM attribute_item WHERE  `status`='1' AND a_id = ".$value['id']);
            $attribute_item = json_decode( json_encode($attribute_item), true);
            $attribute[$key]['item'] = $attribute_item;
        }

        $this->mViewData['attribute'] = $attribute;
        $this->mViewData['p_attr'] = $p_attr;


        $shop_listing = $this->db_model->my_where("admin_users","id,first_name as display_name",array("active" => '1',"type" => 'seller'),array(),"","","","", array(), "",array(),false  );

        $shop_id = $product_data[0]->shop_id;
        $s_listing = $this->db_model->my_where("admin_users","id,first_name as display_name,category_id",array("id" => $shop_id,"type" => 'seller'),array(),"","","","", array(), "",array(),false  );

        $category = $this->db_model->get_data_array("SELECT * FROM category ORDER BY 'id' DESC");
        $extra = $this->db_model->get_data_array("SELECT * FROM product_custimze_details WHERE `pid` = '$product_id' ORDER BY 'id' DESC");

        $this->mViewData['extra'] = $extra;
        $this->mViewData['category'] = $category;
        $this->mViewData['shop_listing'] = $shop_listing;
        $this->mViewData['edit'] = $product_data[0];
        $this->Urenderadmin('product/add','default', $page_name ='Edit product');
    }

    public function upload_product_img($FILES,$upload_dir)
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

    public function delete_product()
    {
        $language = 'en';
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $bid = en_de_crypt($post_data['pid'],'d');
            $product = $this->db_model->get_data_array("SELECT product_image FROM product WHERE `id` = '$bid' ");
            if (!empty($product)) {
                $old_image = $product[0]['product_image'];
                $upload_dir = ROOTPATH . "public/admin/products/";
                // unlink($upload_dir.'/'.$old_image);

                $this->db_model->my_delete(['id' => $bid], 'product');
                echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Product deleted successfully'))); die;
            }
        }
        echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request'))); die;
    }

    public function cat_name_get($cat_id = '')
    {
        $cat_name = '';
        if(!empty($cat_id)) {
            $category = $this->db_model->my_where('category','display_name',array('id' => $cat_id));
            if(!empty($category)) {
                $cat_name = $category[0]['display_name'];
            }
        }
        return $cat_name;   
    }

    public function uploadFiless()
    {
        if(isset($_FILES["file"]["type"]))
        {
            $details = $this->request->getPost();
            $path = $details['path'];
            $count = $details['count'];
            $FILES = $_FILES["file"];
            $upload_dir =  ROOTPATH.$path;
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $newFileName = md5(time()).$count;
            $target_file = $upload_dir . basename($FILES["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $newFileName = $newFileName.".".$imageFileType;
            $target_file = $upload_dir.$newFileName;
            
            // echo $target_file;
            // list($width, $height, $type, $attr)= getimagesize($FILES["tmp_name"]);
            $type1 = $FILES['type'];  

            if ( ( ($type1 == "image/gif") || ($type1 == "image/jpeg") || ($type1 == "image/jpg") || ($type1 == "image/png") ) /*&& ($FILES["size"] < 50939 ) && ($width < 200) && ($height < 200 ) && ($width > 40) && ($height > 40 )*/  )
            { 

                if (move_uploaded_file($FILES["tmp_name"], $target_file)) 
                {
                    echo json_encode(array("status"=>true,"img_name"=>$newFileName,"message" => "successfully")); die;
                }
            }
        }
        echo json_encode(array("status"=>false,"message" => "Invalid request.")); die;
    }

    public function get_category_shop_wise()
    {
        $post_data = $this->request->getPost();
        $shop_id = $post_data['shop_id'];
        $shop = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `id` = '$shop_id' AND `type` = 'seller' ORDER BY 'id' DESC");
        if (empty($shop)) {
            echo json_encode(array("status"=>false,"message" => "Invalid request")); die;
        }

        $category_id = $shop[0]['category_id'];
        $category = $this->db_model->get_data_array("SELECT * FROM category WHERE `id` IN ($category_id) ORDER BY 'id' DESC");
        $asd = "<option value = ''>Select Category</option>";
        foreach ($category as $kaey => $vaalue) {
            $asd .=  "<option value = '".$vaalue['id']."'>".$vaalue['display_name']."</option>";
        }
        // $asd .= '</select>';
        echo json_encode(array("status"=>true,"option"=>$asd,"message" => "Success")); die;
    }
}
