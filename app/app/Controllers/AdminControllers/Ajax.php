<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;

class Ajax extends AdminController
{   
    protected $comf;
    function __construct()
    {
       $this->comf = new CommonFun();
       $this->is_logged_in();
    }    

    public function update_tax_shipping_amount()
    {
        $this->seller_blocked();
        
        $language = 'en';
        $post_data = $this->request->getPost();
        if ($post_data) 
        {
            $start_time = $post_data['start_time'];
            $end_time = $post_data['end_time'];
            if ($start_time) {
                if (strtotime($start_time) >= strtotime($end_time)) {
                    echo json_encode(array("status"=>false,"message" => "Order Start time must be earlier than end time.")); die;
                }
            }
            $this->db_model->my_update($post_data, array("id" => "1"), 'tax');
            echo json_encode(array("status"=>true,"message" => ($language == 'ar'? '': 'Information updated successfully'))); die;
        }

        $tax = $this->db_model->get_data_array("SELECT * FROM tax WHERE `id` = '1' ORDER BY `id` ASC");
        $this->mViewData['edit'] = $tax[0];
        $this->Urenderadmin('tax_shipping/update','default', $page_name ='Food 10 x 10');
    }
}
