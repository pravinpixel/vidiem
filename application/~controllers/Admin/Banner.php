<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banner extends CI_Controller {
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
	    if(hasPermission('banner_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->FunctionModel->Select('vidiem_banner');
		$this->load->view('Backend/banner-view',$data);
    }

	public function add() {
    	    if(hasPermission('banner_add') != true){
    			$this->session->set_flashdata('class', "alert-danger");
    			$this->session->set_flashdata('icon', "fa-warning");
    			$this->session->set_flashdata('msg', "Access denied.");
    			redirect('Admin/dashboard', 'refresh');
    		} 
		    $this->form_validation->set_rules('page','Page','required');
		    $this->form_validation->set_rules('name','Name','required');
		    $this->form_validation->set_rules('image','Image','callback_image_upload');
		    $this->form_validation->set_rules('mobileimage','Mobile Image','callback_temp_image_upload');
			$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'category'     => $this->input->post('page'),
					'name'     => $this->input->post('name'),
					'image'    => $this->upload_data['file']['file_name'],
					'mobileimage'    => $this->upload_data['mobileimage']['file_name'],
					'banner_url'       => $this->input->post('banner_url'),
					'description'    => $this->input->post('contents'),
					'order_no' => $this->input->post('order_no'),
					'status'   => '1',
					'created'  => date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_banner');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
					$this->session->set_flashdata('icon', "fa-check");
					$this->session->set_flashdata('msg', "Banner Added Successfully.");
					redirect('Admin/banner','refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
					redirect('Admin/banner/add', 'refresh');
				}
			}
		   $this->load->view('Backend/add-banner');
    }

	function image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/banner';
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
   
   	function temp_image_upload(){
	  if($_FILES['mobileimage']['size'] != 0){
		$upload_dir = './uploads/mobileimage';
		if (!is_dir($upload_dir)) {
		     mkdir($upload_dir);
		}
		if(file_exists($upload_dir.'/'.$_FILES['mobileimage']['name'])){
				list($file_name)=explode('.',$_FILES['mobileimage']['name']);
				$file_name=$file_name.'_'.substr(md5(rand()),0,5);
			}else{
				list($file_name)=explode('.',$_FILES['mobileimage']['name']);
			}
		$config['upload_path']   = $upload_dir;
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['file_name']     = $file_name;
		$config['overwrite']     = false;
		$config['max_size']	     = '10000';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('mobileimage')){
			$this->form_validation->set_message('image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			$this->upload_data['mobileimage'] =  $this->upload->data();
			return true;
		}
	}
	else{
		$this->form_validation->set_message('image_upload', "No file selected");
		return false;
	}
   }

	public function edit($id = NULL) {
	    if(hasPermission('banner_update') != true){
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
			redirect('Admin/banner', 'refresh');
		}
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('page','Page','required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('image','Image','callback_edit_image_upload');
		$this->form_validation->set_rules('mobileimage','Mobile Image','callback_edit_temp_image_upload');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'category'     => $this->input->post('page'),
					'name'     => $this->input->post('name'),
					'image'    => $this->upload_data['file']['file_name'],
					'mobileimage'    => $this->upload_data['mobileimage']['file_name'],
					'banner_url'       => $this->input->post('banner_url'),
					'description'    => $this->input->post('contents'),
					'order_no' => $this->input->post('order_no'),
					'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_banner',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Banner Updated Successfully.");
				redirect('Admin/banner','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/banner/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_banner',array('id'=>$edit_id));
		   //$data['Pages']=$this->ProjectModel->Pages();
		   $this->load->view('Backend/banner-edit',$data);
    }

	function edit_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/banner';
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
			$this->form_validation->set_message('edit_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			$this->upload_data['file'] =  $this->upload->data();
			return true;
		}
	}
	else{
		$id=$this->input->post('hidden_id');
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_banner',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }
   
   function edit_temp_image_upload(){
	  if($_FILES['mobileimage']['size'] != 0){
		$upload_dir = './uploads/mobileimage';
		if (!is_dir($upload_dir)) {
		     mkdir($upload_dir);
		}
		if(file_exists($upload_dir.'/'.$_FILES['mobileimage']['name'])){
				list($file_name)=explode('.',$_FILES['mobileimage']['name']);
				$file_name=$file_name.'_'.substr(md5(rand()),0,5);
			}else{
				list($file_name)=explode('.',$_FILES['mobileimage']['name']);
			}
		$config['upload_path']   = $upload_dir;
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['file_name']     = $file_name;
		$config['overwrite']     = false;
		$config['max_size']	     = '10000';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('mobileimage')){
			$this->form_validation->set_message('edit_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			$this->upload_data['mobileimage'] =  $this->upload->data();
			return true;
		}
	}
	else{
		$id=$this->input->post('hidden_id');
		$file_name=$this->FunctionModel->Select_Field('mobileimage','vidiem_banner',array('id'=>$id));
		$this->upload_data['mobileimage']['file_name']=$file_name;
		return true;
	}
   }

	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/banner', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_banner',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/banner','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/banner', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('banner_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/banner', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_banner',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/banner','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/banner', 'refresh');
        endif;
    }

    public function AjaxSingleView(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/banner');
    	}
    	$info=$this->FunctionModel->Select_Row('and_banner',array('id'=>$id));
    	$return['modal_name']='View Banner';

    	$return['modal_content']='
				<div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['name'].'</label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Image</label>
                  <div class="col-sm-8">
                    <label class="control-label"><img src="'.base_url('uploads/images/'.$info['image']).'" width="250px" height="250px" class="img-responsive"></label>
                  </div>
                </div>
				 <div class="form-group">
                  <label class="col-sm-3 control-label">Image</label>
                  <div class="col-sm-8">
                    <label class="control-label"><img src="'.base_url('uploads/mobileimage/'.$info['mobileimage']).'" width="250px" height="250px" class="img-responsive"></label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Content</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['content'].'</label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Order No</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['order_no'].'</label>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Status</label>
                  <div class="col-sm-8">
                    <label class="control-label"><span class="label label-'.($info['status']==1?'success':'warning').' status-span">'.($info['status']==1?'Active':'InActive').'</span></label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Created</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['created'].'</label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"></label>
                  <div class="col-sm-8">
                    <label class="control-label"><a href="'.base_url('Admin/banner/edit/'.$info['id']).'" class="btn btn-primary" data-toggle="tooltip" data-placement="left"  data-original-name="Edit"><span class="fa fa-edit"> &nbsp;Edit</span></a></label>
                  </div>
                </div>
                </div>
                ';
    	echo json_encode($return);
    	exit;
    }
	 

}