<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;

class Category extends AdminController
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
        $category = $this->db_model->get_data_array("SELECT id,display_name,status,image FROM category WHERE `parent` = '0' ORDER BY `id` ASC ");
        if ($category) 
        {
            foreach ($category as $key => $value) 
            {
                $cid = $value['id'];
                $image = $value['image'];

                $category[$key]['image'] = base_url('public/admin/category/').$image;

                $category[$key]['cid'] = en_de_crypt($cid);

                $url = '<a href=" '.base_url('admin/category/edit/').en_de_crypt($cid).'" target="_blank" class=""><button class="btn btn-sm btn-success"><i class="fa fa-pencil "></i></button></a> ';
                // $url.= '<a href=" '.base_url('admin/add_sub/').en_de_crypt($cid).'/add" target="_blank" class=""><button class="btn btn-sm btn-success"><i class="fa fa-plus "></i> Add Subcategory</button></a> ';
                $url.= '<a class="delete_main_category" href="javascript:void(0);" data-id="'.en_de_crypt($cid).'" ><button class="btn btn-sm btn-warning"><i class="fa fa-trash "></i></button></a> ';
                $category[$key]['action_url'] = $url;

                $subcategory = $this->db_model->get_data_array("SELECT id,display_name,status,image FROM category WHERE `parent` = '$cid' ORDER BY `id` ASC ");
                $category[$key]['subcategory'] = $subcategory;
            }
        }
        $this->mViewData['category'] = $category;
        $this->Urenderadmin('category/listing','default', $page_name ='Category Listing');
    }

    public function add()
    {
        $post_data = $this->request->getPost();

        if ($post_data) 
        {
            $display_name = $post_data['display_name'];
            $display_name_ar = $post_data['display_name_ar'];
            $status = $post_data['status'];

            $FILES = $_FILES['image'];
            $upload_dir = ROOTPATH . "public/admin/category/";
            $cat_image = $this->upload_img($FILES,$upload_dir);
            if ($cat_image) {
                $asd['image'] = $cat_image;
            }
            else {
                // echo json_encode(array("status"=>false,"message" => "Add category image")); die;
            }

            if (empty($display_name)) {
                echo json_encode(array("status"=>false,"message" => "Add category name")); die;
            }
            if (empty($status)) {
                echo json_encode(array("status"=>false,"message" => "Select status")); die;
            }

            $asd['display_name_ar'] = $display_name_ar;
            $asd['display_name'] = $display_name;
            $asd['status'] = $status;
            $this->db_model->my_insert($asd , 'category');

            echo json_encode(array("status"=>true,"message" => "Main category created successfully")); die;
        }

        $this->Urenderadmin('category/create','default', $page_name ='Add Category');
    }

    public function edit($cid = '')
    {
        $cid = en_de_crypt($cid,'d');
        $category = $this->db_model->get_data_array("SELECT * FROM category WHERE `id` = '$cid' ORDER BY `id` DESC ");

        $post_data = $this->request->getPost();
        if ($post_data) {
            $language = 'en';
            $display_name = $post_data['display_name'];
            $display_name_ar = $post_data['display_name_ar'];
            $status = $post_data['status'];
            $edit_id = $post_data['edit_id'];

            if (empty($display_name)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Add category name.'))); die;
            }
            if (empty($status)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Select status.'))); die;
            }
            if (empty($edit_id)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request.'))); die;
            }

            $FILES = $_FILES['image'];
            $upload_dir = ROOTPATH . "public/admin/category/";
            $cat_image = $this->upload_img($FILES,$upload_dir);
            if ($cat_image) {
                $asd['image'] = $cat_image;
            }
            
            $cid = en_de_crypt($edit_id,'d');

            $asd['display_name'] = $display_name;
            $asd['display_name_ar'] = $display_name_ar;
            $asd['status'] = $status;
            $this->db_model->my_update($asd, array("id" => $cid) , 'category');

            echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Main category information updated successfully'))); die;
        }
        
        $this->mViewData['edit'] = $category[0];
        $this->Urenderadmin('category/edit','default', $page_name ='Edit Category');
    }

    public function add_sub($cid = '')
    {
        $language = 'en';
        $cid = en_de_crypt($cid,'d');
        $category = $this->db_model->get_data_array("SELECT id,display_name,status,image FROM category WHERE `id` = '$cid' ORDER BY `id` DESC ");

        $post_data=$this->request->getPost();
        if ($post_data) 
        {
            $display_name = $post_data['display_name'];
            $status = $post_data['status'];
            $FILES=$_FILES['image'];
            $upload_dir = ROOTPATH . "public/admin/category/";
            $cat_image = $this->upload_img($FILES,$upload_dir);
            if ($cat_image) 
            {
                $asd['image'] = $cat_image;
            }

            if (empty($display_name)) 
            {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Add category name.'))); die;
            }
            if (empty($status)) 
            {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Select status.'))); die;
            }
            if (empty($cat_image)) 
            {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Please add image.'))); die;
            }

            // echo "<pre>";
            // print_r($post_data);
            // die;

            $asd['parent'] = en_de_crypt($post_data['main_category_id'],'d');
            $asd['display_name'] = $display_name;
            $asd['status'] = $status;

            $this->db_model->my_insert($asd , 'category');

            echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Sub category created successfully'))); die;
        }
        
        $this->mViewData['edit'] = $category[0];
        $this->Urenderadmin('category/add_sub','default', $page_name ='Add sub category');
    }

    public function edit_subcategory($sub_cat_id ='')
    {
        $language = 'en';
        $sub_id = en_de_crypt($sub_cat_id,'d');
        $category = $this->db_model->get_data_array("SELECT id,display_name,status,image FROM category WHERE `id` = '$sub_id' ORDER BY `id` DESC ");

        $post_data = $this->request->getPost();
        if ($post_data) 
        {
            $display_name = $post_data['display_name'];
            $status = $post_data['status'];
            $FILES=$_FILES['image'];
            $upload_dir = ROOTPATH . "public/admin/category/";
            $cat_image = $this->upload_img($FILES,$upload_dir);
            if ($cat_image) {
                $asd['image'] = $cat_image;
            }

            if (empty($display_name)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Add category name.'))); die;
            }

            if (empty($status)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Select status.'))); die;
            }

            $edit_sub_id = en_de_crypt($post_data['edit_sub_id'],'d');
            // $asd['parent'] = en_de_crypt($post_data['main_category_id'],'d');
            $asd['display_name'] = $display_name;
            $asd['status'] = $status;

            // echo "<pre>";
            // print_r($asd);
            // die;

            $this->db_model->my_update($asd, array("id" => $edit_sub_id ) , 'category');

            echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Sub category information updated successfully'))); die;
        }
        
        $this->mViewData['edit'] = $category[0];
        $this->Urenderadmin('category/edit_sub','default', $page_name ='Edit Category');
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

    public function delete_sub_category()
    {
       $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $cid = en_de_crypt($post_data['s_id'],'d');
            $this->db_model->my_delete(['id' => $cid], 'category');
            echo 1;
            die;
        }
        else
        {
            echo 0;
            die;
        }
    }

    public function delete_main_category()
    {
       $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $cid = en_de_crypt($post_data['m_id'],'d');
            $this->db_model->my_delete(['id' => $cid], 'category');

            $sub_category = $this->db_model->get_data_array("SELECT id FROM category WHERE `parent` = '$cid' ");
            if ($sub_category) 
            {
                foreach ($sub_category as $key => $value) 
                {
                    $sub_c_id = $value['id'];
                    $this->db_model->my_delete(['id' => $sub_c_id], 'category');
                }
            }

            echo 1;
            die;
        }
        else
        {
            echo 0;
            die;
        }
    }

}
