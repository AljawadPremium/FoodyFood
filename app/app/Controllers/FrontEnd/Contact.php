<?php

namespace App\Controllers\FrontEnd;

class Contact extends FrontController
{
    public function index()
    {
        $msg1 = lang("Validation.Please enter a name");
        $msg2 = lang("Validation.Please enter your email address");
        $msg3 = lang("Validation.Please enter phone number");
        $msg4 = lang("Validation.Please enter subject");
        $msg5 = lang("Validation.Please enter message");
        $msg6 = lang("Validation.The contact request has been successfully sent to the administrator, admin will contact you soon on registered email");

        $post_data = $this->request->getPost();
        $language = "en";
        if(!empty($post_data))
        {            
            $name = $post_data['name'];
            $email = $post_data['email'];
            $phone = $post_data['phone'];
            $subject = $post_data['subject'];
            $message = $post_data['message'];

            if (empty($name)) {
                echo json_encode(array("status"=>false,"message" => $msg1)); die;
            }
            if (empty($email)) {
                echo json_encode(array("status"=>false,"message" => $msg2)); die;
            }
            if (empty($phone)) {
                echo json_encode(array("status"=>false,"message" => $msg3)); die;
            }
            if (empty($subject)) {
                echo json_encode(array("status"=>false,"message" => $msg4)); die;
            }
            if (empty($message)) {
                echo json_encode(array("status"=>false,"message" => $msg5)); die;
            }

            $user_id = $this->session->get('uid');
            if (!empty($user_id)) {
                $post_data['user_id'] = $user_id;
            }

            $post_data['source'] = "Website";
            $post_data['created_date'] = date('Y/m/d H:i:s');
            $this->db_model->my_insert($post_data,'contact_request');
            echo json_encode(array("status"=>true,"message"=> $msg6)); die;
        }
        $this->Urender('contact_us','default', $page_name = 'Contact us');
    }


    public function newsletter()
    {
        $post_data = $this->request->getPost();

        $msg1 = lang("Validation.Please enter your email address");
        $msg2 = lang("Validation.The newsletter request has been successfully sent");

        $language = "en";
        if(!empty($post_data))
        {
            $email = $post_data['email'];
            if (empty($email)) {
                echo json_encode(array("status"=>false,"message" => $msg1)); die;
            }
            $user_id = $this->session->get('uid');
            if (!empty($user_id)) {
                $post_data['user_id'] = $user_id;
            }

            $post_data['source'] = "Website";
            $post_data['created_date'] = date('Y/m/d H:i:s');
            $check = $this->db_model->get_data_array("SELECT id FROM newsletter WHERE `email` = '$email' ");
            if (empty($check)) {
                $this->db_model->my_insert($post_data,'newsletter');
            }
            echo json_encode(array("status"=>true,"message"=> $msg2)); die;
        }
    }

    public function about_us()
    {
        $data = $this->db_model->get_data_array("SELECT title,editor FROM pages WHERE `slug` = 'about' ");
        $this->mViewData['data'] = $data;
        $this->Urender('about','default', $page_name = 'About us');
    }

    public function privacy()
    {
        $data = $this->db_model->get_data_array("SELECT title,editor FROM pages WHERE `slug` = 'privacy-policy' ");
        $this->mViewData['data'] = $data;
        $this->Urender('privacy','default', $page_name = 'Privacy & Policy');
    }

    public function terms()
    {
        $data = $this->db_model->get_data_array("SELECT title,editor FROM pages WHERE `slug` = 'terms-conditions' ");
        $this->mViewData['data'] = $data;
        $this->Urender('terms','default', $page_name = 'Terms & Conditions');
    }

    public function faq()
    {
        $data = $this->db_model->get_data_array("SELECT title,editor FROM pages WHERE `slug` = 'frequently-asked-questions-faq' ");
        $this->mViewData['data'] = $data;
        $this->Urender('faq','default', $page_name = 'Frequently Asked Questions (FAQ)');
    }

}
