<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->model(array('Accessmodel','Dashboardmodel'));
        if(!$this->session->userdata('user_logged_in')){
			$this->session->set_flashdata('class', "alert-danger");	 
			$this->session->set_flashdata('icon', "fa-warning");	 
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}	
    }
	
	public function index(){
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('image','Image','callback_edit_image_upload');
		$this->form_validation->set_rules('password','Password','min_length[8]|max_length[20]');
		if (!$this->form_validation->run() == FALSE) {
			$UpdateData=array(
				'name'    => $this->input->post('name'),
				'email'   => $this->input->post('email'),
				'image'   => $this->upload_data['file']['file_name'],
				'modified'=> date('Y-m-d h:i:s')
			);
			$password=$this->input->post('password');
			if(!empty($password)){$UpdateData['password']=sha1($password);}
			$this->session->set_userdata('user_name',$this->input->post('name'));
			$this->session->set_userdata('user_image',$this->upload_data['file']['file_name']);
			$id=$this->session->userdata('user_id');
			$result=$this->FunctionModel->Update($UpdateData,'vidiem_users',array('id'=>$id));
			
			if($result >= 1){	
				$this->session->set_flashdata('class', "alert-success");	 
				$this->session->set_flashdata('icon', "fa-check");	 
				$this->session->set_flashdata('msg', "Profile Updated Successfully.");
				redirect('Admin/profile','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");	 
				$this->session->set_flashdata('icon', "fa-warning");	 
				$this->session->set_flashdata('msg', "Something went Wrong.");
				redirect('Admin/profile', 'refresh');	
			}
		}
		$user_id=$this->session->userdata('user_id');
		$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_users',array('id'=>$user_id));
	    $this->load->view('Backend/profile',@$data);
	}

	function edit_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/profile';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}	
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['file_name']     = 'image_'.substr(md5(rand()),0,7);
			$config['overwrite']     = false;
			$config['max_size']	 = '5120';

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('image')){
				$this->form_validation->set_message('edit_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
				return false;
			}	
			else{
				$this->upload_data['file'] =  $this->upload->data();
				return true;
			}	
		}	
		else{
			$id=$this->session->userdata('user_id');
			$file_name=$this->FunctionModel->Select_Field('image','vidiem_users',array('id'=>$id));
			$this->upload_data['file']['file_name']=$file_name;
			return true;
		}
   }

}
