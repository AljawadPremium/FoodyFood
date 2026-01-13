<?php

namespace App\Controllers\AdminControllers;
use App\Libraries\CommonFun;

class AdminLogin extends AdminController
{    
    protected $request;
    function __construct()
    {
        $this->request = \Config\Services::request();                                     
    }    

    public function index()
    {
        $comf = new CommonFun(); 

        $language='en';
        if(!empty($this->admin_id))
        {
            return redirect()->to(base_url('admin'));
        }
        $post_data=$this->request->getPost();
        if(!empty($post_data))
        {
            if(isset($post_data['lemail']) && isset($post_data['lpassword']) ) 
            {
                $username = trim($post_data['lemail']);
                $password = $post_data['lpassword'];

                if (empty($username)) 
                {
                    echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Please enter an email address'))); die;
                }
                if (empty($password)) 
                {
                    echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'Please enter the password'))); die;
                }

                $query = $this->db_model->validate_admin($username,$password);
                if (!is_array($query) && $query == '1') 
                {
                    echo json_encode(array("status"=>false,"message" => ($language == 'ar'? '': 'The login password is incorrect'))); die;
                }
                elseif(!is_array($query) && $query == '0')
                {
                    echo json_encode(array("status"=>false,"message"=>($language == 'ar'? '':"Incorrect email/mobile number details"))); die;
                }
                elseif (!is_array($query) && $query == '11') {
                    echo json_encode(array("status"=>false,"message"=> ($language == 'ar'? '':"The account has been deactivated by the administration, please contact the administration department"))); die;
                }
                else
                {
                    if(isset($post_data['remember_me']) && $post_data['remember_me']=='on')
                    {
                        $comf->admin_set_remember_me($username,$password);
                    }else{
                        $comf->admin_set_remember_me('','');
                    }

                    $data = array(
                        'user_name'     => $query['first_name'],
                        'admin_id'      => $query['uid'],                        
                        'is_logged_in'  => true
                    );

                    $this->session->set($data);
                    echo json_encode(array("status"=>true,"message"=>  ($language == 'ar'? '':"You have successfully logged in"))); die;
                }                
            }
            else
            {
                echo json_encode(array("status"=>false,"message" =>'Something Went Wrong')); die;
            }       
        }

        $remember_arr = $comf->admin_get_remember_me();
        $remember_c='';
        if(!empty($remember_arr['remember_admin_user_name']) && !empty($remember_arr['remember_admin_password']) )
        {
            $remember_c = 'checked';
        }        
        $this->mViewData['remember_arr'] =$remember_arr;
        $this->mViewData['remember_c'] = $remember_c;
        $this->mViewData['page_name'] = "Admin Login";

        $this->Urenderadmin('login','empty', $page_name ='Admin Login');
    }

    public function logout()
    {
        $this->session->destroy();
        echo json_encode(array("status"=>true,"message" => "Logout successfully")); die;
        // $post_data=$this->request->getPost();
        // $this->session->destroy();
        // return redirect()->to(base_url('admin/login'));
    }
}
