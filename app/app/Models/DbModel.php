<?php  
namespace App\Models;
use CodeIgniter\Model;

class DbModel extends Model
{

	public function __construct()
	{
		parent::__construct();
		// $this->load->database();
		$db = \Config\Database::connect();
		// print_r($db);
	}

	public function get_pre_slug($table,$slug)
	{
		$builder = $this->db->table($table);
		$builder->select('COUNT(*) AS NumHits');
		$builder->like('slug', $slug);
		$result= $builder->get();
		$row =$result->getResult();	

		return $row[0]->NumHits;
	}
    
 
	
	public function record_count($table,$where = array())
	{
		$builder = $this->db->table($table);
		$builder->select('COUNT(*) AS NumHits');
		
		if (!empty($where) && is_array($where))
		{
			foreach ($where as $key => $value)
			{
				$builder->where($key, $value);
			}
		}
		
		$result= $builder->get();
		$row =$result->getResult();	

		return $row[0]->NumHits;
	}

	public function my_insert($data,$table)
	{
		$builder = $this->db->table($table);
		$builder->set($data, false);		
		$builder->insert();
		return $this->db->insertID();
	}

	public function my_where($table,$select = '*',$where = array(),$like = array(), $order="",$orderby="",$group_by="",$where_in="", $where_in_data = array(), $return = "", $join = array(),$chk =true)
	{
		$builder = $this->db->table($table);
		$builder->select($select);
		// $this->db->select($select);
		if(!empty($where_in) && !empty($where_in_data)){
			$builder->whereIn($where_in,$where_in_data);
		}
		if (!empty($where) && is_array($where))
		{
			foreach ($where as $key => $value)
			{
				// $this->db->where($key, $value);
				$builder->where($key, $value);
			}
		}

		if (!empty($like) && is_array($like))
		{
			foreach ($like as $key => $value)
			{
				$builder->like($key, $value);
			}
		}

		if (!empty($join) && is_array($join))
		{
			foreach ($join as $vkey => $vvalue)
			{
				$this->db->join($vkey, $vvalue);
			}
		}

		if(!empty($order) && !empty($orderby) ){
			$builder->orderBy($order, $orderby);
		}
		if(!empty($group_by) ){
			$builder->groupBy($group_by);
		}
		if($return == "object"){
			$result= $builder->get();
			return $result->getResult();
			// return $this->db->get($table)->getResult();
		}else

		{
			$result= $builder->get();
			return $result->getResultArray();
			// return $this->db->get($table)->getResultArray();
		}
		
	}

	public function my_update($field,$where,$table)
	{

		if (!empty($field) && is_array($field) && !empty($where) && is_array($where) && !empty($table))
		{
			$builder = $this->db->table($table);
			foreach ($where as $key1 => $value1)
			{
				$builder->where($key1, $value1);
			}
			$builder->set($field, false);
			$builder->update();
			return true;
		}
		else
		{
			return false;
		}
	}

	
	public function my_delete($where,$table)
	{
		if (!empty($where) && is_array($where) && !empty($table))
		{
			$builder = $this->db->table($table);
			$builder->where($where);
			$builder->delete();			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function get_data($query)
	{
		$result = $this->db->query($query);
		$aresult = array();
		foreach ($result->getResult() as $row)
		{
		    $aresult[] = $row;
		}
		return $aresult;
	}
    
    public function get_data_array($query)
	{		
		$result = $this->db->query($query);		
		return $result->getResultArray();
	}

	public function validate_admin($user_name, $password,$table='admin_users',$group_id="9")
    {
    	$builder = $this->db->table($table);
        $builder->select('id,password,first_name,last_name,email,phone,social,active');
        $builder->where('type !=', 'user');
        $builder->where('username', $user_name);
        // if(!empty($group_id)) $this->db->where('group_id', $group_id);
        // $this->db->or_where('phone', $user_name);

        $result= $builder->get();
		$re =  $result->getResultArray();        
        
        $data = 0;
        foreach ($re as $krey => $userdata) {
            if(!empty($userdata))
            {
                
                $pass_word = $userdata['password'];
                if ($userdata['active'] == 0) {
                    $data = 11;
                }
                elseif(password_verify ( $password ,$pass_word ))
                {
                    $userdata['uid'] = $userdata['id'];
                    unset($userdata['password']);
                    unset($userdata['id']);
                    return $userdata;
                }
                else{
                    $data = 1;
                }
            }
            else{
                $data = 0;
            }   
        }   
        return $data;
    }

    public function validate_user($user_name, $password,$table='admin_users')
    {
    	$builder = $this->db->table($table);
        $builder->select('id,password,first_name,last_name,phone,email,logo,active,address');
        $builder->where('type', 'user');
        $builder->where('username', $user_name);
        $builder->orWhere('phone', $user_name);
        // if(!empty($group_id)) $this->db->where('group_id', $group_id);
        // $this->db->or_where('phone', $user_name);

        $result= $builder->get();
		$re =  $result->getResultArray();        
        
        $data = 0;
        foreach ($re as $krey => $userdata) {
            if(!empty($userdata))
            {
                $pass_word = $userdata['password'];
                if ($userdata['active'] == 0) {
                    $data = 11;
                }
                elseif(password_verify ( $password ,$pass_word ))
                {
                    // $data = array('firstname' => $firstname, 'uid' => $id, 'email' => $username, 'phone' => $phone,"last_name" => $last_name, "group_id" => $group_id);
                    $userdata['uid'] = $userdata['id'];
                    unset($userdata['password']);
                    // unset($userdata['id']);
                    return $userdata;
                }
                else{
                    $data = 1;
                }
            }
            else{
                $data = 0;
            }   
        }   
        return $data;
    }

    public function validate_driver($user_name, $password,$table='admin_users')
    {
    	$builder = $this->db->table($table);
        $builder->select('id,password,first_name,last_name,phone,email,logo,active,address');
        $builder->where('type', 'driver');
        $builder->where('username', $user_name);
        $builder->orWhere('phone', $user_name);
        // if(!empty($group_id)) $this->db->where('group_id', $group_id);
        // $this->db->or_where('phone', $user_name);

        $result= $builder->get();
		$re =  $result->getResultArray();        
        
        $data = 0;
        foreach ($re as $krey => $userdata) {
            if(!empty($userdata))
            {
                $pass_word = $userdata['password'];
                if ($userdata['active'] == 0) {
                    $data = 11;
                }
                elseif(password_verify ( $password ,$pass_word ))
                {
                    // $data = array('firstname' => $firstname, 'uid' => $id, 'email' => $username, 'phone' => $phone,"last_name" => $last_name, "group_id" => $group_id);
                    $userdata['uid'] = $userdata['id'];
                    unset($userdata['password']);
                    // unset($userdata['id']);
                    return $userdata;
                }
                else{
                    $data = 1;
                }
            }
            else{
                $data = 0;
            }   
        }   
        return $data;
    }

    function forget_password($username)
    {
    	$builder = $this->db->table('admin_users');
		$builder->select('id,password,first_name,email,username,social');
		$builder->where('username', $username);			
		$builder->where('type', 'user');			
		// $builder->where('email', $username);			

		$result= $builder->get();
		$userdata =  $result->getResultArray(); 
		// echo "<pre>";
		// print_r($result);
		// die;
		if(!empty($userdata))
		{	
			$forgotten_password_code = uniqid();			
			$this->my_update(array('forgotten_password_code'=>$forgotten_password_code),array('id'=>$userdata[0]['id']),"admin_users");			
			$userdata[0]['forgotten_password_code'] = $forgotten_password_code;			
			return $userdata;
		}else{
			return false;
		}
	}

	function create_member($insert_data)
	{
		$flag=false;
		$builder = $this->db->table('admin_users');
		$builder->select('id');
		$builder->where('username', $insert_data['username']);
		$result= $builder->get();
		$is_data =  $result->getResultArray();

		if(!empty($is_data))
		{
			$flag = 'email';
		}else{
			$builder->select('id');
			$builder->where('phone', $insert_data['phone']);
			$result= $builder->get();
			$is_data =  $result->getResultArray(); 	
			
			if(!empty($is_data))
			{
				$flag = 'phone';
			}
            else
            {
				$builder->set($insert_data, false);
                $builder->insert();
				$flag = $this->db->insertID();
			}
		}
		return $flag;
	}

    function create_service_provider($insert_data)
    {
        $flag=false;
        $builder = $this->db->table('service_provider');
        $builder->select('id');
        $builder->where('username', $insert_data['username']);
        $result= $builder->get();
        $is_data =  $result->getResultArray();

        if(!empty($is_data))
        {
            $flag = 'email';
        }else{
            $builder->select('id');
            $builder->where('phone', $insert_data['phone']);
            $result= $builder->get();
            $is_data =  $result->getResultArray();  
            
            if(!empty($is_data))
            {
                $flag = 'phone';
            }
            else
            {
                $builder->set($insert_data, false);
                $builder->insert();
                $flag = $this->db->insertID();
            }
        }
        return $flag;
    }

    public function validate_service_provider($user_name, $password,$table='service_provider')
    {
        $builder = $this->db->table($table);
        $builder->select('id,password,first_name,phone,email,logo,active,company_name,country,address,kvk_number,btw_number,service_category,area');
        // $builder->where('user_type =', 'user');
        $builder->where('username', $user_name);
        $builder->orWhere('phone', $user_name);
        // if(!empty($group_id)) $this->db->where('group_id', $group_id);

        $result= $builder->get();
        $re =  $result->getResultArray();        
        
        $data = 0;
        foreach ($re as $krey => $userdata) {
            if(!empty($userdata))
            {
                $pass_word = $userdata['password'];
                if ($userdata['active'] == 0) {
                    $data = 11;
                }
                elseif(password_verify ( $password ,$pass_word ))
                {
                    $userdata['uid'] = $userdata['id'];
                    unset($userdata['password']);
                    return $userdata;
                }
                else{
                    $data = 1;
                }
            }
            else{
                $data = 0;
            }   
        }   
        return $data;
    }
}