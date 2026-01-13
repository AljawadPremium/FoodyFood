<?php

namespace App\Libraries;
use App\Models\DbModel;
use \DateTime; 
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\I18n\Time;

class CommonFun
{
    protected $db_model;

    function __construct()
    {  
        $this->db_model = new DbModel();               
    }

    public function moveto_folder($image_name,$folder_name)
    {
        $tmp_folder=ROOTPATH.'public/admin/temp_images/'.$image_name;
        $move_folder=ROOTPATH.'public/admin/'.$folder_name.'/'.$image_name;
        if(file_exists($tmp_folder))
        {
            if(rename($tmp_folder, $move_folder))
            {
                return 1;
            }
            return 0;
        }
        return 0;
    }

    public function is_file_check($image_name)
    {
        $folder_path=ROOTPATH.'public/temp/'.$image_name;
        if(file_exists($folder_path))
        {
            return 1;
        }
        return 0;
    }

    public function file_check_then_move($image_name)
    {
        /*Below 2/4 line is for delete folder nd all files in that folder*/

        $folder_path = ROOTPATH.'public/temp/'.$image_name;
        if(file_exists($folder_path))
        {
            $move_folder=ROOTPATH.'public/job/'.$image_name;
            if(rename($folder_path, $move_folder))
            {
                return 1;
            }

            return 1;
        }
        return 0;
    }

    public function uploads($file_name,$file_temp,$folder_name)
    {     
        if (isset($file_name)) {
            // $upload_dir = ASSETS_PATH . "/admin/usersdata/";
            $upload_dir = ROOTPATH . $folder_name;   
            // echo $upload_dir;
            // die;         
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            // $file_name    = $FILES['name'];
            // $random_digit = rand(0000, 999);
            // $random_digit = md5(time()).$random_digit;
            
            $target_file  = $upload_dir . basename($file_name);
            $ext          = pathinfo($target_file, PATHINFO_EXTENSION);
            
            // $new_file_name = $random_digit . "." . $ext;
            $file_name_without_ex = basename($file_name,'.'.$ext);
            $file_name_without_ex = $this->get_slug($file_name_without_ex);
            $new_file_name=$this->is_file($upload_dir,$file_name_without_ex,$ext); 

            $new_file_name = $new_file_name . "." . $ext;
            $path          = $upload_dir . $new_file_name;                    
            if (move_uploaded_file($file_temp, $path)) {
                return $new_file_name;
            } else {
                return false;
            }
        } else {
            return false;
            
        }
    }

    public function is_file($upload_dir,$file_name_without_ex,$ext,$id='')
    {   
        //common
        // this funtion is used to check file exists if yes then genrate new file name
        $path=$upload_dir.$file_name_without_ex.".".$ext;       
        if(file_exists($path))
        {
            $random_digit = mt_rand(2,99);
            if(!empty($id))
            {
                $random_digit = $random_digit.''.$id;
            }
            $file_name_without_ex=$file_name_without_ex.$random_digit;
            $this->is_file($upload_dir,$file_name_without_ex,$ext);         
        }
        return $file_name_without_ex;       
    }

    public function get_slug($title)
    {
        //common
        $slug = preg_replace("/-$/","",preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));
        return $slug;
    }

    // is used to copy fiel form one locatio and past to another location 
    // if same file name exists then rename 
    public function copy_remane_file($image_name,$form_folder,$to_folder,$id)
    {
        //common
        $tmp_folder=ROOTPATH.'public/admin/'.$form_folder.'/'.$image_name;
        $move_folder=ROOTPATH.'public/admin/'.$to_folder.'/'.$image_name;
        if(file_exists($tmp_folder))
        {
            $upload_dir=ROOTPATH.'public/admin/'.$to_folder.'/';
            $ext   = pathinfo($move_folder, PATHINFO_EXTENSION);
            $file_name_without_ex = basename($image_name,'.'.$ext);
            $new_file_name = $this->is_file($upload_dir,$file_name_without_ex,$ext,$id);
            $new_file_name = $new_file_name . "." . $ext;
            $path          = $upload_dir . $new_file_name; 
            if (copy($tmp_folder, $path)) {               
                return $new_file_name;
            }else{
                return 0;
            }
        }
        return 0;
    }

    public function admin_get_remember_me()
    {
        helper('cookie');
        $remember_arr=array();
        $remember_arr['remember_admin_user_name']=get_cookie('remember_admin_user_name');
        $remember_arr['remember_admin_password']=get_cookie('remember_admin_password');
        return  $remember_arr;        
    }

    public function arrayTocommaStr($arr_val)
    {
        $re_val='';
        if(!empty($arr_val))
        {
            foreach ($arr_val as $key => $val) 
            {
                $re_val.="'$val',";
            }
            $re_val=rtrim($re_val,',');            
        }
        return $re_val;
    }    

    public function admin_set_remember_me($user_name='',$password='')
    {
        $this->setMyCookie("remember_admin_user_name",$user_name); 
        $this->setMyCookie("remember_admin_password",$password); 
    } 

    public function setMyCookie($name,$value,$params = array())
    {
        if (empty($params)){
            $config = config('App');

            $params = array(
                'expires'   => time() + (10 * 365 * 24 * 60 * 60),
                // 'expires'   => $time,
                'path'      => $config->cookiePath,
                'domain'    => $config->cookieDomain,
                'secure'    => $config->cookieSecure,
                'httponly'  => $config->cookieHTTPOnly,
                'samesite'  => $config->cookieSameSite,
            );
        }

        setcookie($name,$value,$params);
    }

    public function user_set_remember_me($user_name='',$password='')
    {
        $this->set_user_cookie("remember_user_name",$user_name); 
        $this->set_user_cookie("remember_user_password",$password); 
    } 

    public function set_user_cookie($name,$value,$params = array())
    {
        if (empty($params)){
            $config = config('App');

            $params = array(
                'expires'   => time() + (10 * 365 * 24 * 60 * 60),
                // 'expires'   => $time,
                'path'      => $config->cookiePath,
                'domain'    => $config->cookieDomain,
                'secure'    => $config->cookieSecure,
                'httponly'  => $config->cookieHTTPOnly,
                'samesite'  => $config->cookieSameSite,
            );
        }

        setcookie($name,$value,$params);
    }

    public function user_get_remember_me()
    {
        helper('cookie');
        $remember_arr=array();
        $remember_arr['remember_user_name']=get_cookie('remember_user_name');
        $remember_arr['remember_user_password']=get_cookie('remember_user_password');
        return  $remember_arr;        
    }

    public function getLocationInfoByIp()
    {
        //common
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        $result  = array('country'=>'', 'city'=>'');
        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
        if($ip_data && $ip_data->geoplugin_countryName != null){
            $result['country'] = $ip_data->geoplugin_countryName;
            $result['country_code'] = $ip_data->geoplugin_countryCode;
            $result['city'] = $ip_data->geoplugin_city;
        }
        return $result;
    }

    public function set_lang($lang)
    {
        $this->setMyCookie("lang",$lang); 
    }

    public function get_lang()
    {
        helper('cookie');
        $lang = get_cookie('lang');
        if(empty($lang))
        {
            $lang ="en";
        }
        return  $lang;
    }

    public function imagePath($folder_name,$image_name,$type='admin')
    {
        //common
        if(empty($image_name))
        {
            $image_path = Null;
        }else{
            $image_path=base_url().'/public/'.$type.'/'.$folder_name.'/'.$image_name;
        }
        return $image_path;
    }

    public function test_input($data,$re_tag=true) 
    {
        $data = trim($data);
        $data = stripslashes($data);

        return $data;
    }

    public function decnum($number)
    {
        $number = round($number,2);
        return number_format((float)$number, 2, '.', '');
    }

}

?>    