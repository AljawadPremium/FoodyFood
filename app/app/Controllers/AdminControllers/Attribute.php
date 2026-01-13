<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;

class Attribute extends AdminController
{   
    protected $comf;
    function __construct()
    {
       $this->comf = new CommonFun();
       $this->is_logged_in();
    }    

    public function index()
    {
        $user_type = $this->admin_data[0]['type'];
        $attribute = $this->db_model->get_data_array("SELECT * FROM attribute_item ORDER BY `id` ASC");
        if (!empty($attribute)) 
        {
            foreach ($attribute as $key => $value) 
            {
                $bid = en_de_crypt($value['id']);

                $url = '<a href=" '.base_url('admin/attribute/edit/').$bid.'" target="_blank" class=""><button class="btn btn-sm btn-success"><i class="fa fa-pencil "></i></button></a> ';

                if ($user_type == 'admin') {
                    $url.= '<a class="delete_attribute" href="javascript:void(0);" data-id="'.$bid.'" ><button class="btn btn-sm btn-warning"><i class="fa fa-trash "></i></button></a> ';
                }
                $attribute[$key]['action_url'] = $url;

            }
        }

        $this->mViewData['attribute'] = $attribute;
        $this->Urenderadmin('attribute/listing','default', $page_name ='Attribute Listing');
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

            $attribute_item_id = $post_data['attribute_item_id'];

            $item_name = $post_data['item_name'];
            $status = $post_data['status'];
            $a_id = $post_data['a_id'];

            $asd['item_name'] = $item_name;
            $asd['item_value'] = $item_name;
            $asd['status'] = $status;
            $asd['a_id'] = $a_id;

            if (empty($item_name)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Enter item name.'))); die;
            }
            if (empty($status)) {
                echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Select status.'))); die;
            }

            if ($attribute_item_id) 
            {
                $b_id = en_de_crypt($attribute_item_id,'d');
                $attribute = $this->db_model->get_data_array("SELECT id FROM attribute_item WHERE `id` = '$b_id' ORDER BY `id` DESC ");
                if (empty($attribute)) {
                    echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request.'))); die;
                }

                $this->db_model->my_update($asd, array("id" => $b_id), 'attribute_item');
                echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Attribute information updated successfully'))); die;
            }

            $asd['created_date'] = date("Y/m/d H:i:s");
            $this->db_model->my_insert($asd , 'attribute_item');
            echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Attribute created successfully'))); die;
        }

        $this->Urenderadmin('attribute/add','default', $page_name ='Add attribute');
    }

    public function edit($sub_cat_id ='')
    {
        $sub_id = en_de_crypt($sub_cat_id,'d');
        $attribute = $this->db_model->get_data_array("SELECT * FROM attribute_item WHERE `id` = '$sub_id' ORDER BY `id` DESC ");
        $this->mViewData['edit'] = $attribute[0];
        $this->Urenderadmin('attribute/add','default', $page_name ='Edit attribute');
    }

    public function delete_attribute()
    {
        $language = 'en';
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $bid = en_de_crypt($post_data['b_id'],'d');
            $this->db_model->my_delete(['id' => $bid], 'attribute_item');
            echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Attribute deleted successfully'))); die;
        }
        echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Invalid request'))); die;
    }

}
