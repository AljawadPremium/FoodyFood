<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;

class Slot extends AdminController
{   
    protected $comf;
    function __construct()
    {
       $this->comf = new CommonFun();
       $this->is_logged_in();
    }    

    public function index()
    {
        $data = $this->db_model->get_data_array("SELECT * FROM delivery_slot ORDER BY `id` ASC");
        if (!empty($data)) 
        {
            foreach ($data as $key => $value) 
            {
                $bid = en_de_crypt($value['id']);

                $url = '<a href=" '.base_url('admin/slot/add_time/').$bid.'" target="_blank" class=""><button class="btn btn-sm btn-success"><i class="fa fa-plus "></i> Add Slot</button></a> ';

                $data[$key]['action_url'] = $url;

            }
        }

        $this->mViewData['data'] = $data;
        $this->Urenderadmin('slot/listing','default', $page_name ='Slot Listing');
    }

    public function add_time($day_name)
    {
        $day_id = en_de_crypt($day_name,'d');
        $get = $_GET;

        if ($get) 
        {
            if (!empty($get['route'])) 
            {
                $e_id = en_de_crypt($get['route'],'d');
                $edit = $this->db_model->get_data_array("SELECT * FROM delivery_slot_time WHERE `id` = '$e_id' ORDER BY `id` ASC");
                $this->mViewData['edit'] = $edit[0];
            }
        }

        $data = $this->db_model->get_data_array("SELECT * FROM delivery_slot WHERE `id` = '$day_id' ORDER BY `id` ASC");
        if (empty($data)) {
            return redirect()->to(base_url('admin/slot'));
        }

        $delivery_slot_time = $this->db_model->get_data_array("SELECT * FROM delivery_slot_time WHERE `delivery_slot_id` = '$day_id' ORDER BY `id` ASC");

        $this->mViewData['delivery_slot_time'] = $delivery_slot_time;
        $this->mViewData['data'] = $data[0];
        $this->Urenderadmin('slot/add_time_slot','default', $page_name ='Slot Listing');
    }

    public function add_slot_timer()
    {
        $post_data = $this->request->getPost();

        $start_time = $post_data['start_time'];
        $end_time = $post_data['end_time'];
        $t_id = $post_data['t_id'];
        unset($post_data['t_id']);

        if (empty($start_time)) {
            echo json_encode(array("status"=>false,"message" => "Add start time")); die;
        }
        if (empty($end_time)) {
            echo json_encode(array("status"=>false,"message" => "Add end time")); die;
        }
        if (empty($end_time >= $start_time)) {
            echo json_encode(array("status"=>false,"message" => "End time must be greater than start time")); die;
        }

        if ($t_id) 
        {
            $t_id = en_de_crypt($t_id,'d');
            $this->db_model->my_update($post_data, array("id" => $t_id), 'delivery_slot_time');
            echo json_encode(array("status"=>true,"message" => "Slot time updated successfully")); die;
        }

        $post_data['created_date'] = date("Y/m/d H:i:s");
        $this->db_model->my_insert($post_data , 'delivery_slot_time');
        echo json_encode(array("status"=>true,"message" => "Slot time created successfully")); die;
    }

    public function delete_time()
    {
        $post_data = $this->request->getPost();
        if(!empty($post_data))
        {
            $bid = en_de_crypt($post_data['b_id'],'d');
            $this->db_model->my_delete(['id' => $bid], 'delivery_slot_time');
            echo json_encode(array("status"=>true,"message" => "Slot timer deleted successfully")); die;
        }
    }
}
