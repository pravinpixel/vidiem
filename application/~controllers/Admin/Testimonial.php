<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Testimonial extends CI_Controller {
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
	    if(hasPermission('testimonial_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		$data['DataResult']=$this->FunctionModel->Select('vidiem_testimonial');
		$this->load->view('Backend/testimonial-view',$data);
    }

	public function add() {
	        if(hasPermission('testimonial_add') != true){
    			$this->session->set_flashdata('class', "alert-danger");
    			$this->session->set_flashdata('icon', "fa-warning");
    			$this->session->set_flashdata('msg', "Access denied.");
    			redirect('Admin/dashboard', 'refresh');
		    }
		    $this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('title','Title','required');
			$this->form_validation->set_rules('designation','Designation','required');
			$this->form_validation->set_rules('content','Content','required|max_length[500]');
		    $this->form_validation->set_rules('location','Location & Date','required');
			$this->form_validation->set_rules('image','Image','callback_image_upload');
			$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'name'     => $this->input->post('name'),
					'title'     => $this->input->post('title'),
					'designation'     => $this->input->post('designation'),
					'content'  => $this->input->post('content'),
					'location' => $this->input->post('location'),
					'image'    => $this->upload_data['file']['file_name'],
					'order_no' => $this->input->post('order_no'),
					'status'   => '1',
					'created'  => date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_testimonial');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
					$this->session->set_flashdata('icon', "fa-check");
					$this->session->set_flashdata('msg', "Testimonial Added Successfully.");
					redirect('Admin/testimonial','refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
					redirect('Admin/testimonial/add', 'refresh');
				}
			}
		  // $data['Pages']=$this->ProjectModel->Pages();
		   $this->load->view('Backend/testimonial-add');
    }
function image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/testimonial';
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
	    if(hasPermission('testimonial_update') != true){
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
			redirect('Admin/testimonial', 'refresh');
		}
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('designation','Designation','required');
		$this->form_validation->set_rules('content','Content','required|max_length[500]');
		$this->form_validation->set_rules('location','Location & Date','required');
		$this->form_validation->set_rules('image','Image','callback_edit_image_upload');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'name'     => $this->input->post('name'),
					'title'     => $this->input->post('title'),
					'designation'     => $this->input->post('designation'),
					'content'  => $this->input->post('content'),
					'location' => $this->input->post('location'),
					'image'    => $this->upload_data['file']['file_name'],
					'order_no' => $this->input->post('order_no'),
					'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_testimonial',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Testimonial Updated Successfully.");
				redirect('Admin/testimonial','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/testimonial/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_testimonial',array('id'=>$edit_id));
		  // $data['Pages']=$this->ProjectModel->Pages();
		   $this->load->view('Backend/testimonial-edit',$data);
    }

	function edit_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/testimonial';
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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_testimonial',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }
	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/testimonial', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_testimonial',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/testimonial','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/testimonial', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('testimonial_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/testimonial', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_testimonial',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/testimonial','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/testimonial', 'refresh');
        endif;
    }

    public function AjaxSingleView(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/testimonial');
    	}
    	$info=$this->FunctionModel->Select_Row('vidiem_testimonial',array('id'=>$id));
    	$return['modal_name']='View Testimonial';

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
                    <label class="control-label"><a href="'.base_url('Admin/testimonial/edit/'.$info['id']).'" class="btn btn-primary" data-toggle="tooltip" data-placement="left"  data-original-name="Edit"><span class="fa fa-edit"> &nbsp;Edit</span></a></label>
                  </div>
                </div>
                </div>
                ';
    	echo json_encode($return);
    	exit;
    }

}