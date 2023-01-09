<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('dbvars',NULL,'Info');
    }
	
	public function index() {
		// echo sys_get_temp_dir();die;
	    if($this->session->userdata('user_logged_in')){redirect('Admin/dashboard');}			
		 $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		 $this->form_validation->set_rules('password', 'Password', 'required');
			if (!$this->form_validation->run() == FALSE) {
				
				$email=$this->input->post('email');
			    $password=$this->input->post('password');
			    $login=$this->Accessmodel->Login($email,$password);
				if($login['status']==0){
					
					$this->session->set_flashdata('class', "alert-warning");	 
					$this->session->set_flashdata('icon', "fa-warning");	 
					$this->session->set_flashdata('msg', "Invalid Email / Password.");
					redirect('Admin','refresh');	
				}else if($login['status']==2){
					
					$this->session->set_flashdata('class', "alert-danger");	 
					$this->session->set_flashdata('icon', "fa-warning");	 
					$this->session->set_flashdata('msg', "Account Inactive.");
					redirect('Admin','refresh');	
				}else{
					
					$this->session->set_flashdata('class', "alert-success");	 
					$this->session->set_flashdata('icon', "fa-check");	 
					$this->session->set_flashdata('msg', "Login Successfully.");
					redirect('Admin/dashboard','refresh');
					
				}
			  }
		$this->load->view('Backend/login');
	}
	
	public function forgot_password() {
		 if($this->session->userdata('user_logged_in')){redirect('Admin/dashboard');}
		 $this->form_validation->set_rules('email', 'Email Id', 'required|valid_email|callback_forgot_check');
			if (!$this->form_validation->run() == FALSE) {
					$email=$this->input->post('email');
					$user_state=$this->Accessmodel->SendNewPassword($email);	

					$this->session->set_flashdata('class', "alert-success");	 
					$this->session->set_flashdata('icon', "fa-check");	 
					$this->session->set_flashdata('msg', "Password Sent Successfully.");
					redirect('Admin','refresh');
			 } 
		$this->load->view('Backend/forgot_password');			
	}
	
	public function forgot_check($email)
	{
		$count=$this->FunctionModel->Row_Count('vidiem_users',array('email'=>$email,'status'=>1));
		if ($count==0)
		{
			$this->form_validation->set_message('forgot_check', 'The %s not Exist');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	  
	}	
	
	public function logout() {
		if(!$this->session->userdata('user_logged_in')){
			$this->session->set_flashdata('class', "alert-danger");	 
			$this->session->set_flashdata('icon', "fa-warning");	 
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}	
		$this->Accessmodel->UserLogout();	
		$this->session->set_flashdata('class', "alert-success");	 
		$this->session->set_flashdata('icon', "fa-check");	 
		$this->session->set_flashdata('msg', "Logout Successfully !..");
		redirect('Admin','refresh');
	}
	
	public function destroy(){
		$this->session->sess_destroy();
		redirect('Admin');	
	}
	
	public function page_not_found(){
		redirect('Admin');
		if(1==1){
			redirect('Admin');
		}
		$this->load->view('404');		
	}
}
