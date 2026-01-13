<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;

class Pages extends AdminController
{   
    protected $comf;
    function __construct()
    {
       $this->comf = new CommonFun();
       $this->is_logged_in();
    }    

    public function index()
    {
        $pages = $this->db_model->get_data_array("SELECT id,title FROM pages WHERE `status` = 'active' ORDER BY `id` ASC");
        $this->mViewData['pages'] = $pages;
        $this->Urenderadmin('pages/listing','default', $page_name ='Pages Listing');
    }

    public function add()
    {
        $language = 'en';
        $post_data=$this->request->getPost();
        if ($post_data) 
        {
            // echo "<pre>";
            // print_r($post_data);
            // die;

            $pages_id = $post_data['pages_id'];

            $title = $post_data['title'];
            $editor = $post_data['editor'];
            $status = $post_data['status'];
            $asd['title'] = $title;
            $asd['editor'] = $editor;

            if (empty($title)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Enter title.'))); die;
            }
            if (empty($editor)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Enter description.'))); die;
            }

            if ($pages_id) 
            {
                $b_id = en_de_crypt($pages_id,'d');
                $pages = $this->db_model->get_data_array("SELECT id,status FROM pages WHERE `id` = '$b_id' ORDER BY `id` DESC ");
                if (empty($pages)) {
                    echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request.'))); die;
                }

                $asd['status'] = $status;
                $this->db_model->my_update($asd, array("id" => $b_id), 'pages');
                echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Pages information updated successfully'))); die;
            }

            $asd['created_date'] = date("Y/m/d H:i:s");
            $asd['status'] = $status;
            $this->db_model->my_insert($asd , 'pages');
            echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Pages created successfully'))); die;
        }
        $this->Urenderadmin('pages/add','default', $page_name ='Add pages');
    }

    public function edit($sub_cat_id ='')
    {
        $sub_id = en_de_crypt($sub_cat_id,'d');
        $pages = $this->db_model->get_data_array("SELECT * FROM pages WHERE `id` = '$sub_id' ORDER BY `id` DESC ");
        $this->mViewData['edit'] = $pages[0];
        $this->Urenderadmin('pages/add','default', $page_name ='Edit pages');
    }

    public function upload_pages_img($FILES,$upload_dir)
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

    public function delete_pages()
    {
        $language = 'en';
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $bid = en_de_crypt($post_data['b_id'],'d');
            // $this->db_model->my_delete(['id' => $bid], 'pages');
            echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Pages deleted successfully'))); die;
            
        }
        echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request'))); die;
    }

}
