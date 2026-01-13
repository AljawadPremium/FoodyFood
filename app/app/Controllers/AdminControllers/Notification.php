<?php

namespace App\Controllers\AdminControllers;
use App\Models\UserModel;
use App\Libraries\CommonFun;

class Notification extends AdminController
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
        $post_data = $this->request->getPost();
        if (!empty($post_data)) 
        {
            if (empty($post_data['n_title'])) {
                echo json_encode(array("status"=>false,"message"=> "Please enter notification title")); die;
            } 
            if (empty($post_data['n_message'])) {
                echo json_encode(array("status"=>false,"message"=> "Please enter notification message")); die;
            }

            $to_id = '';
            $title = $post_data['n_title'];
            $message = $post_data['n_message'];


            $FILES = $_FILES['n_image'];
            $upload_dir = ROOTPATH . "/public/admin/notification/";
            $b_image = $this->uploads($FILES,$upload_dir);
            if ($b_image) {
                $to_id = base_url('/public/admin/notification/').$b_image;
            }

            $user = $this->db_model->get_data_array("SELECT id,first_name,last_name FROM admin_users WHERE `type` = 'user' AND `fcm_no` != '' ");

            if (!empty($user))
            {
                date_default_timezone_set("Asia/Calcutta"); 
                $cunt = count($user);
                $number = ($cunt / 100);
                $number =  round($number);

                $numb = 0;
                $selected_sizes = $ass_ar = array();

                for ($i = 0; $i <= $number ; $i++) 
                {
                    $selected_sizes = array_slice( $user, $numb, 100 );
                    $user_id =  implode(",", array_column($selected_sizes, "id"));
                    $numb = $numb + 100;

                    $ass_ar['user_id']  = $user_id;
                    $ass_ar['title']    = $title;
                    $ass_ar['message']  = $message;
                    $ass_ar['image']    = $to_id;
                    $ass_ar['type']     = 'user';

                    if ($i == 0) {
                        $ass_ar['show_listing']     = 'yes';
                    }
                    $ass_ar['created_date']     = date("Y/m/d H:i:s");
                    $this->db_model->my_insert($ass_ar,'cron_notification');
                }
            }

            echo json_encode(array("status"=>true ,"message"=> "Notification fired successfully")); die;

        }

        $data = $this->db_model->get_data_array("SELECT * FROM cron_notification WHERE `show_listing` = 'yes' GROUP BY message ORDER BY id DESC");
        if (!empty($data)) 
        {
            foreach ($data as $key => $value) 
            {
                $bid = en_de_crypt($value['id']);

                $url = '<a class="resend_noti" href="javascript:void(0);" data-id="'.$bid.'" ><button class="btn btn-sm btn-warning"><i class="fa fa-refresh "></i></button></a> ';

                $url.= '<a class="delete_noti" href="javascript:void(0);" data-id="'.$bid.'" ><button class="btn btn-sm btn-warning"><i class="fa fa-trash "></i></button></a> ';

                $data[$key]['action_url'] = $url;

            }
        }

        $this->mViewData['data'] = $data;
        $this->Urenderadmin('notification/listing','default', $page_name ='Notification Listing');
    }

    public function uploads($FILES,$upload_dir)
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

    public function resend_noti()
    {
        $language = 'en';
        $post_data = $this->request->getPost();

        if ($post_data) {
            $bid = en_de_crypt($post_data['bid'],'d');

            $data = $this->db_model->get_data_array("SELECT * FROM cron_notification WHERE `id` = '$bid' ");

            $title = $data[0]['title'];
            $message = $data[0]['message'];
            $to_id = $data[0]['image'];
            
            $user = $this->db_model->get_data_array("SELECT id,first_name,last_name FROM admin_users WHERE `type` = 'user' AND `fcm_no` != '' ");

            if (!empty($user))
            {
                date_default_timezone_set("Asia/Calcutta"); 
                $cunt = count($user);
                $number = ($cunt / 100);
                $number =  round($number);

                $numb = 0;
                $selected_sizes = $ass_ar = array();

                for ($i = 0; $i <= $number ; $i++) {
                    $selected_sizes = array_slice( $user, $numb, 100 );
                    $user_id =  implode(",", array_column($selected_sizes, "id"));
                    $numb = $numb + 100;

                    $ass_ar['user_id']  = $user_id;
                    $ass_ar['title']    = $title;
                    $ass_ar['message']  = $message;
                    $ass_ar['image']    = $to_id;
                    $ass_ar['type']     = 'user';
                    $ass_ar['created_date']     = date("Y/m/d H:i:s");
                    if ($user_id) 
                    {
                        $this->db_model->my_insert($ass_ar,'cron_notification');
                    }
                }
            }
        }

        echo json_encode(array("status"=>true ,"message"=>  ($language == 'ar'? '':"Notification again fired successfully"))); die;

    }

    public function delete()
    {
        $post_data=$this->request->getPost();
        if(!empty($post_data))
        {
            $bid = en_de_crypt($post_data['bid'],'d');
            $this->db_model->my_delete(['id' => $bid], 'cron_notification');
            echo 1;
            die;
        }else {
            echo 0;
            die;
        }
    }

}
