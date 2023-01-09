<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Event extends CI_Controller {
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
	    if(hasPermission('event_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		$data['DataResult']=$this->FunctionModel->Select('vidiem_event');
		$this->load->view('Backend/event-view',$data);
    }

	public function add() {
    	    if(hasPermission('event_add') != true){
    			$this->session->set_flashdata('class', "alert-danger");
    			$this->session->set_flashdata('icon', "fa-warning");
    			$this->session->set_flashdata('msg', "Access denied.");
    			redirect('Admin/dashboard', 'refresh');
    		}
		    $this->form_validation->set_rules('page','Page','required');
		    $this->form_validation->set_rules('title','Title','required');
		    $this->form_validation->set_rules('image','Image','callback_image_upload');
			$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
			        'category'     => $this->input->post('page'),
					'title'        => $this->input->post('title'),
					'content'      => $this->input->post('content'),
					'eventdate'    => $this->input->post('eventdate'),
					'image'        => $this->upload_data['file']['file_name'],
					'order_no'     => $this->input->post('order_no'),
					'status'       => '1',
					'created'      => date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_event');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
					$this->session->set_flashdata('icon', "fa-check");
					$this->session->set_flashdata('msg', "Event Added Successfully.");
					redirect('Admin/event','refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
					redirect('Admin/event/add', 'refresh');
				}
			}
		   $data['Pages']=$this->ProjectModel->Pagesevents();
		   $this->load->view('Backend/event-add',@$data);
    }

	function image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/event';
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
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name']     = $file_name;
		$config['overwrite']     = false;
		$config['max_size']	     = '5120';

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
	    if(hasPermission('event_update') != true){
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
			redirect('Admin/team', 'refresh');
		}
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('page','Page','required');
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('image','Image','callback_edit_image_upload');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					 'category'     => $this->input->post('page'),
					'title'     => $this->input->post('title'),
					'content'     => $this->input->post('content'),
					'eventdate'     => $this->input->post('eventdate'),
					'image'    => $this->upload_data['file']['file_name'],
					'order_no' => $this->input->post('order_no'),
					'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_event',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Event Updated Successfully.");
				redirect('Admin/event','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/event/edit/'.$edit_id, 'refresh');
        	endif;
			}
		   $data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_event',array('id'=>$edit_id));
		   $data['Pages']=$this->ProjectModel->Pagesevents();
		   $this->load->view('Backend/event-edit',$data);
    }

	function edit_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/event';
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
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name']     = $file_name;
		$config['overwrite']     = false;
		$config['max_size']	     = '5120';

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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_event',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }

	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/team', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_event',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/event','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/event', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('event_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/event', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_event',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/event','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/event', 'refresh');
        endif;
    }

    public function AjaxSingleView(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/event');
    	}
    	$info=$this->FunctionModel->Select_Row('and_team',array('id'=>$id));
    	$return['modal_name']='View Event';

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
                    <label class="control-label"><a href="'.base_url('Admin/team/edit/'.$info['id']).'" class="btn btn-primary" data-toggle="tooltip" data-placement="left"  data-original-name="Edit"><span class="fa fa-edit"> &nbsp;Edit</span></a></label>
                  </div>
                </div>
                </div>
                ';
    	echo json_encode($return);
    	exit;
    }
public function eventcat($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/event');
    	}
    	$data['id']=$id;
    	$data['title']=$this->FunctionModel->Select_Field('title','vidiem_event',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_event_category',array('parent_id'=>$id));
		$this->load->view('Backend/event-cat-view',$data);
    }    
       public function eventcatadd($id=NULL) {
	    if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning"); 
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/event');
    	}
    	$data['id']=$id;
    	$data['title']=$this->FunctionModel->Select_Field('title','vidiem_event',array('id'=>$id));
    	$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('content','Content','required');
		//$this->form_validation->set_rules('image','Image','callback_event_image_upload');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
				 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
			   	'parent_id'=>$id,
				'title' => $this->input->post('title'),
				'link' => $this->input->post('link'),
				'content'  => $this->input->post('content'),
				'order_no' => $this->input->post('order_no'),
				'status'   => '1',
				'created'  => date('Y-m-d H:i:s')
				);
			    // $image = $this->upload_data['file']['file_name'];
			//   if(!empty($image)){$InsertData['image']=$image;}
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_event_category');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Event Added Successfully.");
				    redirect('Admin/event/eventcat/'.$id,'refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/event/eventadd/'.$id, 'refresh');	
				}
				}
		   $this->load->view('Backend/event-cat-add',@$data);	
    }
    function event_image_upload(){ 
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/event/eventcat';
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
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name']     = $file_name; 
		$config['overwrite']     = false;
		$config['max_size']	     = '5120';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('image')){
			$this->form_validation->set_message('event_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			$this->upload_data['file'] =  $this->upload->data();
			return true;
		}
	}
	else{
		$this->form_validation->set_message('event_image_upload', "No file selected");
		return false;
	}
   }
    public function eventcatedit($id = NULL) {
    $edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/event');
		}
         $data['id']=$this->FunctionModel->Select_Field('parent_id','vidiem_event_category',array('id'=>$edit_id));
         $data['title']=$this->FunctionModel->Select_Field('title','vidiem_event',array('id'=>$id));
	     $this->form_validation->set_rules('hidden_id', 'ID', 'required');
		 $this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('content','Content','required');
		//$this->form_validation->set_rules('image','Image','callback_event_image_upload');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
		  if (!$this->form_validation->run() == FALSE) {
          $UpdateData=array(
					'title' => $this->input->post('title'),
				'link' => $this->input->post('link'),
				'content'  => $this->input->post('content'),
				'order_no' => $this->input->post('order_no'),
					'modified' => date('Y-m-d H:i:s')
				);
		  $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_event_category',array('id'=>$edit_id));
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_event_category',array('id'=>$edit_id));
			if ($result == 1) :
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Event Updated Successfully.");
		    	redirect('Admin/event/eventcat/'.$parent_id,'refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/event/eventcatedit/'.$edit_id, 'refresh');	
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_event_category',array('id'=>$edit_id));	
		   $this->load->view('Backend/event-cat-edit',$data);	
    }
    public function eventcatstatus($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/event', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_event_category',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_event_category',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/event/eventcat/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/event/eventcat/'.$parent_id, 'refresh');	
        endif;
    }

     public function eventcatdelete($id = NULL) { 
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/event', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_event_category',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_event_category',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/event/eventcat/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/event/eventcat/'.$parent_id, 'refresh');	
        endif;
    } 

    public function image($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/event');
    	}
    	$data['id']=$id;
    	$data['title']=$this->FunctionModel->Select_Field('title','vidiem_event',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_event_images',array('parent_id'=>$id));
			   //$data['DataResult']=$this->FunctionModel->Select('vidiem_category',array('status'=>1,'parent_id'=>0));
 
		$this->load->view('Backend/event-image-view',$data);
    }

    public function add_image($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/event');
    	}
    	$data['id']=$id;
    	$data['name']=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$id));
    	$this->form_validation->set_rules('image','Image','callback_event_image_upload');
    	//$this->form_validation->set_rules('banner_url','Banner_url','required');
    	$this->form_validation->set_rules('order_no','Order No','required');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'parent_id'=>$id,
					//'name'=>$this->input->post('name'),
					'image'=>$this->upload_data['file']['file_name'],
					'order_no'=>$this->input->post('order_no'),
					'status' =>'1',
					'created'=>date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_event_images');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Event Images Added Successfully.");
				    redirect('Admin/event/image/'.$id,'refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/event/add_image/'.$id, 'refresh');	
				}
				} 
		   $this->load->view('Backend/event-image-add',@$data);	
    } 
    public function image_edit($id = NULL) {
		$edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/event');
		}
         $data['id']=$this->FunctionModel->Select_Field('parent_id','vidiem_category_images',array('id'=>$edit_id));
         $data['name']=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$id));
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('image','Image','callback_edit_content_image_upload');
    	$this->form_validation->set_rules('order_no','Order No','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					//'name'=>$this->input->post('name'),
					'image'=>$this->upload_data['file']['file_name'],
					//'banner_url'       => $this->input->post('banner_url'),
					'order_no'=>$this->input->post('order_no'),
					'modified'=>date('Y-m-d H:i:s')
				);
		  $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_event_images',array('id'=>$edit_id));
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_event_images',array('id'=>$edit_id));
			if ($result == 1) : 
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Event Image Updated Successfully.");
		    	redirect('Admin/event/image/'.$parent_id,'refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/event/image_edit/'.$edit_id, 'refresh');	
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_event_images',array('id'=>$edit_id));	
		   $this->load->view('Backend/event-image-edit',$data);	
    }
    	function edit_content_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/event/eventcat';
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
			$this->form_validation->set_message('edit_content_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}	
		else{
			$this->upload_data['file'] =  $this->upload->data();
			return true;
		}	
	}	
	else{ 
		$id=$this->input->post('hidden_id');
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_event_images',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }
    public function image_status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/event', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_event_images',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_event_images',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/event/image/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/event/image/'.$parent_id, 'refresh');	
        endif;
    }
	
	public function image_delete($id = NULL) {
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/event', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_event_images',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_event_images',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/event/image/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/event/image/'.$parent_id, 'refresh');	
        endif;
    }
    public function cat_image($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/event');
    	}
    	$data['id']=$id;
    	$data['title']=$this->FunctionModel->Select_Field('title','vidiem_event',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_event_category_images',array('parent_id'=>$id));
			   //$data['DataResult']=$this->FunctionModel->Select('vidiem_category',array('status'=>1,'parent_id'=>0));
 
		$this->load->view('Backend/event-cat-image-view',$data);
    }
    public function cat_add_image($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/event');
    	}
    	$data['id']=$id;
    	$data['name']=$this->FunctionModel->Select_Field('title','vidiem_event',array('id'=>$id));
    	$this->form_validation->set_rules('image','Image','callback_event_cat_image_upload');
    	//$this->form_validation->set_rules('banner_url','Banner_url','required');
    	$this->form_validation->set_rules('order_no','Order No','required');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'parent_id'=>$id,
					//'name'=>$this->input->post('name'),
					'image'=>$this->upload_data['file']['file_name'],
					'order_no'=>$this->input->post('order_no'),
					'status' =>'1',
					'created'=>date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_event_category_images');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Event Images Added Successfully.");
				    redirect('Admin/event/cat_image/'.$id,'refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/event/cat_add_image/'.$id, 'refresh');	
				}
				} 
		   $this->load->view('Backend/event-cat-image-add',@$data);	
    } 
      function event_cat_image_upload(){ 
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/event/event-cat';
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
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['file_name']     = $file_name; 
		$config['overwrite']     = false;
		$config['max_size']	     = '5120';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('image')){
			$this->form_validation->set_message('event_cat_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			$this->upload_data['file'] =  $this->upload->data();
			return true;
		}
	}
	else{
		$this->form_validation->set_message('event_cat_image_upload', "No file selected");
		return false;
	}
   }
   public function cat_image_edit($id = NULL) {
		$edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/event');
		}
         $data['id']=$this->FunctionModel->Select_Field('parent_id','vidiem_category_images',array('id'=>$edit_id));
         $data['name']=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$id));
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('image','Image','callback_cat_edit_content_image_upload');
    	$this->form_validation->set_rules('order_no','Order No','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					//'name'=>$this->input->post('name'),
					'image'=>$this->upload_data['file']['file_name'],
					//'banner_url'       => $this->input->post('banner_url'),
					'order_no'=>$this->input->post('order_no'),
					'modified'=>date('Y-m-d H:i:s')
				);
		  $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_event_category_images',array('id'=>$edit_id));
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_event_category_images',array('id'=>$edit_id));
			if ($result == 1) : 
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Event Image Updated Successfully.");
		    	redirect('Admin/event/cat_image/'.$parent_id,'refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/event/cat_image_edit/'.$edit_id, 'refresh');	
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_event_category_images',array('id'=>$edit_id));	
		   $this->load->view('Backend/event-cat-image-edit',$data);	
    }
    function cat_edit_content_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/event/event-cat';
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
			$this->form_validation->set_message('cat_edit_content_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}	
		else{
			$this->upload_data['file'] =  $this->upload->data();
			return true;
		}	
	}	
	else{ 
		$id=$this->input->post('hidden_id');
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_event_category_images',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }
    public function cat_image_status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/event', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_event_category_images',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_event_category_images',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/event/cat_image/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/event/cat_image/'.$parent_id, 'refresh');	
        endif;
    }
    public function cat_image_delete($id = NULL) {
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/event', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_event_category_images',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_event_category_images',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/event/cat_image/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/event/cat_image/'.$parent_id, 'refresh');	
        endif;
    }
}