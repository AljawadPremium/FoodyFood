<?php
namespace App\Libraries;
use App\Libraries\FcmSetData;
use App\Models\DbModel;

class Fcmnotification
{
	protected $db_model;
	function __construct()
    {  
        $this->db_model = new DbModel();               
    }

	public function send_fcm_message_user($uid,$title,$msg='',$image_url='',$action='',$action_destination= '',$topic = '')
    {
        $check = $this->db_model->my_where('admin_users','first_name,id,fcm_no,source',array('id'=>$uid,'fcm_no!=' => ''));
        
        // echo "<pre>";
        // print_r($check);

        if(!empty($check))
        {
            $notification = new FcmSetData();

            $title = $title;
            $message = isset($msg)?$msg:'';
            $imageUrl = isset($image_url)?$image_url:'';
            $action = isset($action)?$action:'';
            
            // $actionDestination = isset($_POST['action_destination'])?$_POST['action_destination']:'';

            // if($actionDestination ==''){
            //     $action = '';
            // }

            $notification->setTitle($title);
            $notification->setMessage($message);
            // $notification->setBody($message);
            $notification->setImage($imageUrl);
            $notification->setAction($action);
            $notification->setActionDestination($action_destination);
            
            $firebase_token = $check[0]['fcm_no'];

            $firebase_api = "AAAAjxmU7J4:APA91bHl16bXcipKnQOGsdZc8u70NgoHBOOcWzeo2Y0ndT-S4h5i0c0ROBUMUkMkuYB68EOzI7KWCj7b56lr4Tc4Z8jNQm1UHft0A_X2i0nw0YOGVPRde-dBz-y_8VCKHvzOE3-8Lg2z";
            
            $topic = $topic;
            
            $requestData = $notification->getNotificatin();
            
            if(!empty($topic)){
                $fields = array(
                    'to' => '/topics/' . $topic,
                    'data' => $requestData,
                );
                
            }else{
                $source = $check[0]['source'];
                if ($source == 'android' || $source == 'Android') 
                {                    
                    $fields = array(
                        'to' => $firebase_token,
                        'data' => $requestData,
                    );
                }
                else
                {
                    $fields = array(
                        'to' => $firebase_token,
                        'notification' => $requestData,
                    );
                }           
            }

            // echo "<pre>";
            // print_r($fields);
            // die;

            // Set POST variables
            $url = 'https://fcm.googleapis.com/fcm/send';

            $headers = array(
                'Authorization: key=' . $firebase_api,
                'Content-Type: application/json'
            );
            
            // Open connection
            $ch = curl_init();

            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarily
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            // Execute post
            $result = curl_exec($ch);
            if($result === FALSE){
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);
            
            // echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
            // echo json_encode($fields,JSON_PRETTY_PRINT);
            // echo '</pre></p><h3>Response </h3><p><pre>';
            // echo $result;
            // echo '</pre></p>';
            // die;
        }
    }
}