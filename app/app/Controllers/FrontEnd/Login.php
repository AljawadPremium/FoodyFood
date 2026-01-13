<?php

namespace App\Controllers\FrontEnd;
use App\Libraries\CommonFun;

class Login extends FrontController
{    
    protected $request;
    function __construct()
    {
        $this->request = \Config\Services::request();
    }

    public function index()
    {
        $msg1 = lang("Validation.Please enter an email address");
        $msg2 = lang("Validation.Please enter the password");
        $msg3 = lang("Validation.The login password is incorrect");
        $msg4 = lang("Validation.Incorrect email/mobile number details");
        $msg5 = lang("Validation.The account has been deactivated by the administration, please contact the administration department");
        $msg6 = lang("Validation.You have successfully logged in");
        $msg7 = lang("Validation.Something Went Wrong");

        if(!empty($_SESSION['uid'])) {
            return redirect()->to(base_url(''));
        }

        $comf = new CommonFun(); 
        $language = "en";
        $post_data=$this->request->getPost();
        if(!empty($post_data))
        {
            if(isset($post_data['login_username']) && isset($post_data['login_password']) ) 
            {
                $username = trim($post_data['login_username']);
                $password = $post_data['login_password'];

                if (empty($username)) {
                    echo json_encode(array("status"=>false,"message" => $msg1)); die;
                }
                if (empty($password)) {
                    echo json_encode(array("status"=>false,"message" => $msg2)); die;
                }

                $query = $this->db_model->validate_user($username,$password);
                if (!is_array($query) && $query == '1') {
                    echo json_encode(array("status"=>false,"message" => $msg3)); die;
                }
                elseif(!is_array($query) && $query == '0') {
                    echo json_encode(array("status"=>false,"message" => $msg4)); die;
                }
                elseif (!is_array($query) && $query == '11') {
                    echo json_encode(array("status"=>false,"message"=> $msg5)); die;
                }
                else
                {
                    if(isset($post_data['remember_me']) && $post_data['remember_me']=='on')
                    {
                        $comf->user_set_remember_me($username,$password);
                    }else{
                        $comf->user_set_remember_me('','');
                    }

                    $data = array(
                        'username'  =>  $query['first_name'].' '.$query['last_name'],
                        'uid'           =>  $query['id'],
                        'c_email'       =>  $query['email'],
                        'c_phone'       =>  $query['phone'],
                        'is_logged_in'  => true
                    );

                    $this->session->set($data);
                    echo json_encode(array("status"=>true,"message"=> $msg6)); die;
                }                
            }
            else
            {
                echo json_encode(array("status"=>false,"message" => $msg7)); die;
            }       
        }

        $remember_arr = $comf->user_get_remember_me();
        $remember_c='';
        if(!empty($remember_arr['remember_user_name']) && !empty($remember_arr['remember_user_password']) )
        {
            $remember_c = 'checked';
        }        
        $this->mViewData['remember_arr'] =$remember_arr;
        $this->mViewData['remember_c'] = $remember_c;
        $this->mViewData['page_name'] = "Admin Login";

        $this->Urender('login','default', $page_name = 'Food');
    }

    public function resetPassword($uid,$code)
    {
        $decrypt = en_de_crypt($uid,'d');    
        $post_data=$this->request->getPost();

        if(!empty($post_data))
        {
            if(isset($post_data['password']) && isset($post_data['confirm_password']) )
            {
                if(!empty($post_data['password']) && !empty($post_data['confirm_password']) )
                {
                    $is_user = $this->db_model->get_data_array("SELECT id,forgotten_password_code FROM admin_users WHERE `id`='$decrypt' AND `forgotten_password_code`='$code' AND `type`='user' "); 

                    if(!empty($is_user))
                    {
                        if($post_data['password']==$post_data['confirm_password'])
                        {
                            $insert_data=array();
                            $insert_data['password_show'] = $post_data['password'];
                            $insert_data['password'] = password_hash($post_data['password'], PASSWORD_BCRYPT);
                            $insert_data['forgotten_password_code']=Null;
                            $is_id=$this->db_model->my_update($insert_data,array("id"=>$decrypt,"type"=>"user"),'admin_users');
                            if($is_id)
                            {
                                $success_link=base_url().'/login/success';
                                echo json_encode(array("status"=>true,"message"=>"Password Updated Successfully","flag"=>$success_link)); die;    
                            }else{
                                echo json_encode(array("status"=>false,"message"=>"Something Went Wrong","flag"=>"")); die;     
                            } 
                        }else{
                           echo json_encode(array("status"=>false,"message"=>"Password & Confirm Password Not Matched","flag"=>"")); die;  
                        }
                    }else{
                        echo json_encode(array("status"=>false,"message"=>"Password Reset Link Expired, Please Genrate New Link","flag"=>"")); die; 
                    }
                }else{
                    echo json_encode(array("status"=>false,"message"=>"All Field Required","flag"=>"")); die;        
                }
            }else{
              echo json_encode(array("status"=>false,"message"=>"All Field Required","flag"=>"")); die;  
            }
        }

        $is_user = $this->db_model->get_data_array(" SELECT id,forgotten_password_code FROM admin_users WHERE id='$decrypt' AND forgotten_password_code='$code' AND type='user' ");
        $this->mViewData['uid'] = $uid;
        $this->mViewData['code'] = $code;
        $this->mViewData['is_user'] = $is_user;
        $this->Urender('reset_pass','default', 'Reset Password');
    }

    public function success()
    {
        $this->mViewData['messsage'] = "Password Change Successfully";
        $this->Urender('success','default', 'Success');
    }
    

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url(''));
    }
}