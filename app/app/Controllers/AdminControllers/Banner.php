<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;

class Banner extends AdminController
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
        $banner = $this->db_model->get_data_array("SELECT category.display_name,banner.* FROM banner LEFT JOIN category ON category.id = banner.category ORDER BY banner.id DESC ");
        if (!empty($banner)) 
        {
            foreach ($banner as $key => $value) 
            {
                $a_language = 'Kurdish sorani';
                $language = $value['language'];
                if ($language == 'en') {
                    $a_language = 'English';
                }
                elseif ($language == 'ar') {
                    $a_language = 'Arabic';
                }
                $bid = en_de_crypt($value['id']);

                $url = '<a href=" '.base_url('admin/banner/edit/').$bid.'" target="_blank" class=""><button class="btn btn-sm btn-success"><i class="fa fa-pencil "></i></button></a> ';

                $url.= '<a class="delete_banner" href="javascript:void(0);" data-id="'.$bid.'" ><button class="btn btn-sm btn-warning"><i class="fa fa-trash "></i></button></a> ';
                $banner[$key]['action_url'] = $url;
                $banner[$key]['language'] = $a_language;

            }
        }
        // $banner = $this->db_model->get_data_array("SELECT * FROM banner ORDER BY `id` ASC");
        $this->mViewData['banner'] = $banner;
        $this->Urenderadmin('banner/listing','default', $page_name ='Banner Listing');
    }

    public function add()
    {
        $language = 'en';
        $post_data=$this->request->getPost();
        if ($post_data) 
        {
            $p_language = $post_data['language'];
            $banner_id = $post_data['banner_id'];
            $type = $post_data['type'];
            $category = $post_data['category'];
            $status = $post_data['status'];
            $FILES = $_FILES['image'];
            $upload_dir = ROOTPATH . "public/admin/banner/";

            $asd['type'] = $type;
            $asd['category'] = $category;

            $cat_image = $this->upload_banner_img($FILES,$upload_dir);
            if ($cat_image) 
            {
                $asd['image'] = $cat_image;
            }

            if (empty($category)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Select category.'))); die;
            }
            if (empty($type)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Select type.'))); die;
            }
            if (empty($status)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Select status.'))); die;
            }

            if ($banner_id) 
            {
                $b_id = en_de_crypt($banner_id,'d');
                $banner = $this->db_model->get_data_array("SELECT id,status,image FROM banner WHERE `id` = '$b_id' ORDER BY `id` DESC ");
                if (empty($banner)) {
                    echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request.'))); die;
                }

                $old_image = $banner[0]['image'];
                if ($cat_image) {
                    unlink($upload_dir.'/'.$old_image);
                }

                $asd['language'] = $p_language;
                $asd['status'] = $status;
                $this->db_model->my_update($asd, array("id" => $b_id), 'banner');
                echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Banner information updated successfully'))); die;
            }

            if (empty($cat_image)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Please add banner image.'))); die;
            }

            $asd['created_date'] = date("Y/m/d H:i:s");
            $asd['language'] = $p_language;
            $asd['status'] = $status;
            $this->db_model->my_insert($asd , 'banner');
            echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Banner created successfully'))); die;
        }

        $c_listing = $this->db_model->get_data_array("SELECT id,display_name FROM category WHERE `parent` = '0' ORDER BY `id` ASC");
        $this->mViewData['c_listing'] = $c_listing;

        // echo "<pre>";
        // print_r($c_listing);
        // die;

        $this->Urenderadmin('banner/add','default', $page_name ='Add banner');
    }

    public function edit($sub_cat_id ='')
    {
        $sub_id = en_de_crypt($sub_cat_id,'d');
        $banner = $this->db_model->get_data_array("SELECT * FROM banner WHERE `id` = '$sub_id' ORDER BY `id` DESC ");
        $this->mViewData['edit'] = $banner[0];

        $c_listing = $this->db_model->get_data_array("SELECT id,display_name FROM category WHERE `parent` = '0' ORDER BY `id` ASC");
        $this->mViewData['c_listing'] = $c_listing;
        $this->Urenderadmin('banner/add','default', $page_name ='Edit banner');
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

    public function delete_banner()
    {
        $language = 'en';
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $bid = en_de_crypt($post_data['b_id'],'d');
            $banner = $this->db_model->get_data_array("SELECT image FROM banner WHERE `id` = '$bid' ");
            if (!empty($banner)) {
                $old_image = $banner[0]['image'];
                $upload_dir = ROOTPATH . "public/admin/banner/";
                unlink($upload_dir.'/'.$old_image);

                $this->db_model->my_delete(['id' => $bid], 'banner');
                echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Banner deleted successfully'))); die;
            }
        }
        echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request'))); die;
    }

}
