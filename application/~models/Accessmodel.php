<?php
class Accessmodel extends CI_Model {
    function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('session');
		$this->load->database();
    }
	
	public function Login($email,$password){
		$query =$this->db->get_where('vidiem_users',array('email' => $email, 'password' => sha1($password)));
		if ($query->num_rows() == 1)
		{
			$data=$query->row_array();
			if($data['status']==1){
				$SessionData = array(
					'user_id'         => $data['id'],
					'user_name'       => $data['name'],
					'user_role'       => $data['role'],
					'user_image'      => $data['image'],
					'user_menu_style' => $data['menu_style'],
					'user_theme_color'=> $data['theme_color'],
					'user_logged_in'  =>  TRUE
				);
				$this->session->set_userdata($SessionData);
				$login['status']=1;
				$this->login_time_ip_update();
			}
			else{
				$login['status']=2;
			}
			return $login;
        }
        	$login['status']=0;
			return $login;	
	}
	
	public function login_time_ip_update(){
		$id=$this->session->userdata('user_id');
		$row=$this->FunctionModel->Select_Row('vidiem_users',array('id'=>$id));
		$UpdateData=array(
			'last_login_ip'   => $row['login_ip'],
			'last_login_time' => $row['login_time'],
			'login_ip'        => $_SERVER['REMOTE_ADDR'],
			'login_time'      => date('Y-m-d h:i:s'),
			'modified'        => date('Y-m-d h:i:s')
		);
		$this->FunctionModel->Update($UpdateData,'vidiem_users',array('id'=>$id));
		return true;
	}
	
	public function UserLogout(){
		$id=$this->session->userdata('user_id');
		$UpdateData=array(
			'logout_time'=>date('Y-m-d h:i:s'),
			'modified'   =>date('Y-m-d h:i:s')
		);
		$this->FunctionModel->Update($UpdateData,'vidiem_users',array('id'=>$id));
		
		//Destroy User Session Data 
		$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}
		return 1;
	}
	
	///////////////   Developer - Job Board  ////////////////
	
	public function SendNewPassword($email){
		$id=$this->FunctionModel->Select_Field('id','vidiem_users',array('email'=>$email));
		$password=$this->FunctionModel->NewPassword();
		$this->SendPassword($email,$password);
		$UpdateData=array(
			'password' => sha1($password),
			'modified' => date('Y-m-d h:i:s')
		);
		$this->FunctionModel->Update($UpdateData,'vidiem_users',array('id'=>$id));
		return true;
	}  

	public function SendPassword($email,$password){
		$subject = ucfirst($this->Info->company_name)." - New Password";
		$message = "";
		$message .= "<p>Your New Password &nbsp;&nbsp; $password &nbsp;&nbsp; <br><a href='".base_url()."'>Click to Login</a></p>";
		$this->FunctionModel->sendmail($email, $message, $subject,$this->config->item('mail'));
	}

///////////////////////////////////////////////
//            Authentication				 //
///////////////////////////////////////////////

	public function Role_Privileges($role_id){
		$data=$this->FunctionModel->Select_where('med_auth_role_privileges','role_id',$role_id);
			if(!empty($data)){
				foreach($data as $info){
					$privileges[]=$info['privilege_id'];	
				}
			return $privileges;
			}
			else{ 
				return array(0);
			}
	} 

	public function is_privileged($privilage=NULL){
		$role=$this->session->userdata('user_role');
		if($role==1){return 1;}
		else{
		$this->db->select('med_auth_role_privileges.id');
			$this->db->join('med_auth_role_privileges', 'med_auth_role_privileges.privilege_id=med_auth_privileges.id');
			$query = $this->db->get_where('med_auth_privileges',array('med_auth_privileges.name'=>$privilage,'med_auth_role_privileges.role_id'=>$role));
				if ($query->num_rows() > 0){
					 return 1;
				}
				else{
					return 0;	
				} 	
			}	
	}
}
?>