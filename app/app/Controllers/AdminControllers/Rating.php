<?php
namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;
class Rating extends AdminController
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
        $data = $this->db_model->get_data_array("SELECT * FROM user_rating Order BY id DESC ");
        $user_list = $this->db_model->get_data_array("SELECT id,first_name FROM admin_users WHERE `type` = 'user' Order BY id DESC ");
        $product_list = $this->db_model->get_data_array("SELECT id,product_name FROM product Order BY id DESC ");
        $this->mViewData['data'] = $data;
        $this->mViewData['user_list'] = $user_list;
        $this->mViewData['product_list'] = $product_list;
        $this->Urenderadmin('rating/listing','default', $page_name ='Rating Listing');
    }
    public function get_data($bid = ''){
        $language = 'en';
        if(!empty($bid)){
            $data = $this->db_model->get_data_array("SELECT * FROM user_rating WHERE `id` = '$bid' ");
            if ($data) {
                echo json_encode(array("status"=>true, "data" => $data[0] ,"message"=>  ($language == 'ar'? '':"Successfully"))); die;
            }
        }

        echo json_encode(array("url"=>"redirect","status"=>true,"message"=>  ($language == 'ar'? '':"Invalid request"))); die;
    }
    public function delete()
    {
        $post_data=$this->request->getPost();
        if(!empty($post_data))
        {
            $cid = en_de_crypt($post_data['cid'],'d');
            $this->db_model->my_delete(['id' => $cid], 'user_rating');
            echo 1;
            die;
        }else {
            echo 0;
            die;
        }
    }
    public function add_edit($vid = '')
    {
        $language = 'en';
        $post_data = $this->request->getPost();

        // echo "<pre>";
        // print_r($post_data);
        // die;

        if(!empty($post_data)){
            if (!empty($vid) && $vid != 'add') {
                $post_data['updated_date'] = date('Y/m/d H:i:s');
                $this->db_model->my_update($post_data , array("id"=> $vid),"user_rating");
                echo json_encode(array("status"=>true,"message"=>  ($language == 'ar'? '':"Rating information updated successfully"))); die;
            }
            else{

                $user_id = $post_data['uid'];
                $user_list = $this->db_model->get_data_array("SELECT id,first_name FROM admin_users WHERE `id` = '$user_id' Order BY id DESC ");
                if ($user_list) {
                    $post_data['name'] = $user_list[0]['first_name'];
                }

                $post_data['created_date'] = date('Y/m/d H:i:s');
                $this->db_model->my_insert($post_data,"user_rating");
                echo json_encode(array("status"=>true,"message"=>  ($language == 'ar'? '':"Rating created successfully"))); die;
            }
        }
        echo json_encode(array("url"=>"redirect","status"=>true,"message"=>  ($language == 'ar'? '':"Invalid request"))); die;
    }
}