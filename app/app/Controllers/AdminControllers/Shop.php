<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;

class Shop extends AdminController
{   
    protected $comf;
    function __construct()
    {
       $this->comf = new CommonFun();
       $this->is_logged_in();
       $this->seller_blocked();
    }    

    public function index()
    {
        $data = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `type` = 'seller' ORDER BY `id` DESC ");
        if ($data) 
        {
            foreach ($data as $key => $value) 
            {
                $cid = $value['id'];
                $image = $value['image'];
                $active = $value['active'];
                
                $data[$key]['active'] = 'Active';
                if ($active == 0) {
                    $data[$key]['active'] = 'Blocked';
                }

                $data[$key]['image'] = base_url('public/admin/shop/').$image;

                $data[$key]['cid'] = en_de_crypt($cid);

                $url = '<a href=" '.base_url('admin/shop/edit/').en_de_crypt($cid).'" target="_blank" class=""><button class="btn btn-sm btn-success"><i class="fa fa-pencil "></i></button></a> ';
                $url.= '<a href=" '.base_url('admin/shop/add_driver/').en_de_crypt($cid).'/add" target="_blank" class=""><button class="btn btn-sm btn-success"><i class="fa fa-plus "></i> Add Driver</button></a> ';
                $url.= '<a class="delete_main_shop" href="javascript:void(0);" data-id="'.en_de_crypt($cid).'" ><button class="btn btn-sm btn-warning"><i class="fa fa-trash "></i></button></a> ';
                $data[$key]['action_url'] = $url;

                $cdata = $this->db_model->get_data_array("SELECT id,first_name,active FROM admin_users WHERE `seller_id` = '$cid' ORDER BY `id` ASC ");
                $data[$key]['driver_list'] = $cdata;
            }
        }
        $this->mViewData['shop'] = $data;
        $this->Urenderadmin('shop/listing','default', $page_name ='Shop Listing');
    }

    public function add()
    {
        $post_data = $this->request->getPost();

        if ($post_data) {
            $first_name = $post_data['first_name'];

            $status = $post_data['active'];
            $edit_id = $post_data['edit_id'];
            $category_id = @$post_data['category_id'];
            $email = @$post_data['email'];
            $phone = @$post_data['phone'];

            $FILES = $_FILES['image'];
            $upload_dir = ROOTPATH . "public/admin/shop/";
            $cat_image = $this->upload_img($FILES,$upload_dir);
            
            if (empty($first_name)) {
                echo json_encode(array("status"=>false,"message" => "Add shop name")); die;
            }
            if (empty($category_id)) {
                echo json_encode(array("status"=>false,"message" => "Select category")); die;
            }

            $post_data['category_id'] = $tags = implode(",", $category_id);
            $post_data['type'] = "seller";

            if ($cat_image) {
                $post_data['image'] = $cat_image;
            }
            else {
                // echo json_encode(array("status"=>false,"message" => "Add shop image")); die;
            }

            $edit_id = $post_data['edit_id'];
            unset($post_data['edit_id']);

            $password = $post_data['password'];
            if ($password) {
                $post_data['password_show'] = $password;
                $post_data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }
            else {
                unset($post_data['password']);
            }
            

            if (empty($edit_id)) {

                $post_data['group_id'] = "7";
                $post_data['created_on'] = date("Y/m/d");
                $post_data['username'] = $email;
                
                $email_check = $this->db_model->my_where("admin_users","*",array('email' => $email,'type' => 'seller'),array(),"","","","", array(), "",array(),false  );
                if ($email_check) {
                    echo json_encode( array("status" => false, "message" => "Email address already exist") );die;
                }
                $p_check = $this->db_model->my_where("admin_users","*",array('phone' => $phone,'type' => 'seller'),array(),"","","","", array(), "",array(),false  );
                if ($p_check) {
                    echo json_encode( array("status" => false, "message" => "Phone number already exist") );die;
                }

                $this->db_model->my_insert($post_data , 'admin_users');
                echo json_encode(array("status"=>true,"message" => "Shop created successfully")); die;
            }
            else
            {
                $eid = en_de_crypt($edit_id,'d');
                $email_check = $this->db_model->my_where("admin_users","*",array('email' => $email,'type' => 'seller','id !=' => $eid),array(),"","","","", array(), "",array(),false  );
                if ($email_check) {
                    echo json_encode( array("status" => false, "message" => "Email address already exist") );die;
                }
                $p_check = $this->db_model->my_where("admin_users","*",array('phone' => $phone,'type' => 'seller','id !=' => $eid),array(),"","","","", array(), "",array(),false  );
                if ($p_check) {
                    echo json_encode( array("status" => false, "message" => "Phone number already exist") );die;
                }

                $this->db_model->my_update($post_data, array("id" => $eid) , 'admin_users');
                echo json_encode(array("status"=>true,"message" => "Shop information updated successfully")); die;
            }
        }

        $category_listing = $this->db_model->get_data_array("SELECT id,display_name FROM category WHERE `parent` = '0' AND `status` = 'active' ORDER BY `id` DESC ");
        $this->mViewData['category_listing'] = $category_listing;
        $this->Urenderadmin('shop/create','default', $page_name ='Add Shop');
    }

    public function edit($cid = '')
    {
        $cid = en_de_crypt($cid,'d');
        $category_listing = $this->db_model->get_data_array("SELECT id,display_name FROM category WHERE `parent` = '0' AND `status` = 'active' ORDER BY `id` DESC ");
        $shop = $this->db_model->get_data_array("SELECT * FROM admin_users WHERE `id` = '$cid' ORDER BY `id` DESC ");
        $this->mViewData['category_listing'] = $category_listing;
        $this->mViewData['edit'] = $shop[0];
        $this->Urenderadmin('shop/create','default', $page_name ='Edit Shop');
    }

    public function upload_img($FILES,$upload_dir)
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

    public function delete_main_shop()
    {
       $post_data = $this->request->getPost();
        if(!empty($post_data)) {
            $cid = en_de_crypt($post_data['m_id'],'d');
            $this->db_model->my_delete(['id' => $cid], 'admin_users');
            echo 1;
            die;
        }
        else {
            echo 0;
            die;
        }
    }

    public function add_driver($cid = '')
    {
        $language = 'en';
        $cid = en_de_crypt($cid,'d');
        $category = $this->db_model->get_data_array("SELECT id,first_name,active,logo FROM admin_users WHERE `id` = '$cid' ORDER BY `id` DESC ");

    
        
        $this->mViewData['edit'] = $category[0];
        $this->Urenderadmin('shop/add_driver','default', $page_name ='Add Driver');
    }

    public function addDriver($value='')
    {
        $post_data=$this->request->getPost();
        if ($post_data) 
        {
            $driver_id = $post_data['driver_id'];
            $first_name = $post_data['first_name'];
            $email = $post_data['email'];
            $phone = $post_data['phone'];
            $password = $post_data['password'];

            if (empty($first_name)) {
                echo json_encode(array("status"=>false,"message" => "Add driver name")); die;
            }

            if (empty($driver_id)) {
                $email_check = $this->db_model->my_where("admin_users","*",array('email' => $email,'type' => 'driver'),array(),"","","","", array(), "",array(),false  );
                if ($email_check) {
                    echo json_encode( array("status" => false, "message" => "Email address already exist") );die;
                }

                $p_check = $this->db_model->my_where("admin_users","*",array('phone' => $phone,'type' => 'driver'),array(),"","","","", array(), "",array(),false  );
                if ($p_check) {
                    echo json_encode( array("status" => false, "message" => "Phone number already exist") );die;
                }
            }


            $FILES = $_FILES['image'];
            $upload_dir = ROOTPATH . "public/driver/";
            $cat_image = $this->upload_img($FILES,$upload_dir);
            if ($cat_image) {
                $post_data['logo'] = $cat_image;
            }

            unset($post_data['driver_id']);

            // echo "<pre>";
            // print_r($post_data);
            // die;
            $post_data['username'] = $post_data['email'];
            if ($password) {
                $post_data['password_show'] = $password;
                $post_data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }
            $post_data['seller_id'] = en_de_crypt($post_data['seller_id'],'d');

            if (empty($driver_id)) {
                $post_data['created_on'] = date("Y/m/d");
                $post_data['group_id'] = "7";
                $post_data['type'] = "driver";

                $this->db_model->my_insert($post_data , 'admin_users');
                echo json_encode(array("status"=>true,"message" => "Driver created successfully")); die;
            }
            else
            {
                $eid = en_de_crypt($driver_id,'d');
                $email_check = $this->db_model->my_where("admin_users","*",array('email' => $email,'type' => 'driver','id !=' => $eid),array(),"","","","", array(), "",array(),false  );
                if ($email_check) {
                    echo json_encode( array("status" => false, "message" => "Email address already exist") );die;
                }
                $p_check = $this->db_model->my_where("admin_users","*",array('phone' => $phone,'type' => 'driver','id !=' => $eid),array(),"","","","", array(), "",array(),false  );
                if ($p_check) {
                    echo json_encode( array("status" => false, "message" => "Phone number already exist") );die;
                }

                $this->db_model->my_update($post_data, array("id" => $eid) , 'admin_users');
                echo json_encode(array("status"=>true,"message" => "Driver information updated successfully")); die;
            }

        }
    }

    public function editDriver($driver_id='')
    {
        $did = en_de_crypt($driver_id,'d');        
        $driver_data = $this->db_model->get_data_array("SELECT id,first_name,phone,email,active,logo,seller_id,address,password_show FROM admin_users WHERE `id` = '$did' ORDER BY `id` DESC ");

        $seller_id = $driver_data[0]['seller_id'];
        $seller_data = $this->db_model->get_data_array("SELECT id,first_name,active,logo FROM admin_users WHERE `id` = '$seller_id' ORDER BY `id` DESC ");

        $this->mViewData['driver_data'] = $driver_data[0];
        $this->mViewData['edit'] = $seller_data[0];
        $this->Urenderadmin('shop/add_driver','default', $page_name ='Edit Driver');        
    }
}
