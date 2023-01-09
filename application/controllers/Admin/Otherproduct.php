<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Otherproduct extends CI_Controller {
	function __construct() {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->model(array('Accessmodel'));
        if(!$this->session->userdata('user_logged_in')){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}
    }

	 public function index() {
	    if(hasPermission('other_product_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->FunctionModel->Select('vidiem_otherproduct');
		$this->load->view('Backend/otherproduct-view',$data);
    }
	
	public function add(){
    	if(hasPermission('other_product_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['position']=$this->FunctionModel->Select('vidiem_keyfeatureposition',array('status'=>1));
    	$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('productlink','Product Link','required');
    	$this->form_validation->set_rules('image','Image','callback_image_upload');
		$this->form_validation->set_rules('productkeyfeature','Product Key Feature','required');
		$this->form_validation->set_rules('position','Position','required');
    	$this->form_validation->set_rules('order_no','Order No','required');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'name'     => $this->input->post('name'),
					'productlink'     => $this->input->post('productlink'),
					'image'    => $this->upload_data['file']['file_name'],
					'content'  => $this->input->post('content'),
					'productkeyfeature' => $this->input->post('productkeyfeature'),
					'position' => $this->input->post('position'),
					'imageposition' => $this->input->post('imageposition'),
					'order_no' => $this->input->post('order_no'),
					'status'   => '1',
					'created'  => date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_otherproduct');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Product Images Added Successfully.");
				   redirect('Admin/otherproduct','refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/otherproduct/add', 'refresh');	
				}
				}
		   $this->load->view('Backend/otherproduct-add',$data);	
    }
	
	function image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/images';
		if (!is_dir($upload_dir)) {
		     mkdir($upload_dir);
		}
		if(file_exists($upload_dir.'/'.$_FILES['image']['name'])){
				list($file_name)=explode('.',$_FILES['image']['name']);
				$file_name=$file_name.'_'.substr(md5(rand()),0,5);
			}else{
				list($file_name)=explode('.',$_FILES['image']['name']);
			}
		$config['upload_path']   = $upload_dir;
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['file_name']     = $file_name;
		$config['overwrite']     = false;
		$config['max_size']	     = '10000';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('image')){
			$this->form_validation->set_message('image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			$this->upload_data['file'] =  $this->upload->data();
			return true;
		}
	}
	else{
		$this->form_validation->set_message('image_upload', "No file selected");
		return false;
	}
   }	
	
	

    public function edit($id = NULL) {
        if(hasPermission('other_product_update') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/otherproduct');
		}
         
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('productlink','Product Link','required');
		$this->form_validation->set_rules('image','Image','callback_feautre_image_upload');
		$this->form_validation->set_rules('productkeyfeature','Product Key Feature','required');
		$this->form_validation->set_rules('position','Position','required');
    	$this->form_validation->set_rules('order_no','Order No','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'name'    => $this->input->post('name'),
					'productlink'     => $this->input->post('productlink'),
					'image'   => $this->upload_data['file']['file_name'],
					'content' => $this->input->post('content'),
					'productkeyfeature' => $this->input->post('productkeyfeature'),
					'position' => $this->input->post('position'),
					'imageposition' => $this->input->post('imageposition'),
					'order_no'=> $this->input->post('order_no'),
					'modified'=> date('Y-m-d H:i:s')
				);
		 
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_otherproduct',array('id'=>$edit_id));
		  
			if ($result == 1) :
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Webinar Image Updated Successfully.");
		    	redirect('Admin/otherproduct','refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/otherproduct/edit/'.$edit_id, 'refresh');	
        	endif;
			}
			
			$data['position']=$this->FunctionModel->Select('vidiem_keyfeatureposition',array('status'=>1));
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_otherproduct',array('id'=>$edit_id));
		   $this->load->view('Backend/otherproduct-edit',$data);	
    }

    function feautre_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/images';
		if (!is_dir($upload_dir)) {
		     mkdir($upload_dir);
		}	
		$config['upload_path']   = $upload_dir;
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name']     = 'image_'.substr(md5(rand()),0,10);
		$config['overwrite']     = false;
		$config['max_size']	 = '5120';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('image')){
			$this->form_validation->set_message('feautre_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			$this->form_validation->set_message('feautre_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}	
		else{
			$this->upload_data['file'] =  $this->upload->data();
			return true;
		}	
	}	
	else{
		$id=$this->input->post('hidden_id');
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_otherproduct',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }

   public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/otherproduct', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_otherproduct',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/otherproduct','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/otherproduct','refresh');
        endif;
    }
	
	public function delete($id = NULL) {
	    if(hasPermission('other_product_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/otherproduct', 'refresh');
		}
        
        $result = $this->FunctionModel->Delete('vidiem_otherproduct',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/otherproduct','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/otherproduct', 'refresh');
        endif;
    }



}