<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Video extends CI_Controller {
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
	    if(hasPermission('video_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
		$data['DataResult']=$this->FunctionModel->Select('vidiem_video');
		$this->load->view('Backend/video-view',$data);
    }

	public function add() {
    	    if(hasPermission('video_add') != true){
    			$this->session->set_flashdata('class', "alert-danger");
    			$this->session->set_flashdata('icon', "fa-warning");
    			$this->session->set_flashdata('msg', "Access denied.");
    			redirect('Admin/dashboard', 'refresh');
    	    }
		    $this->form_validation->set_rules('title','Title','required');
			if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'title'     => $this->input->post('title'),
					'status'   => '1',
					'created'  => date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_video');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
					$this->session->set_flashdata('icon', "fa-check");
					$this->session->set_flashdata('msg', "Video Added Successfully.");
					redirect('Admin/video','refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
					redirect('Admin/video/add', 'refresh');
				}
			}
		   //$data['Pages']=$this->ProjectModel->Pages();
		   	   //$data['category']=$this->FunctionModel->Select('vidiem_category',array('status'=>1,'parent_id'=>0));

		   $this->load->view('Backend/video-add');
    }
	
	
	

	public function edit($id = NULL) {
	    if(hasPermission('video_update') != true){
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
		$this->form_validation->set_rules('title','Title','required');
	    	  if (!$this->form_validation->run() == FALSE) {
			  
			   $UpdateData=array(
					
					'title'    => $this->input->post('title'),
					
					'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_video',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Video Updated Successfully.");
				redirect('Admin/video','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/video/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result1']=$this->FunctionModel->Select_Row('vidiem_category',array('id'=>$edit_id));
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_video',array('id'=>$edit_id));
		   $this->load->view('Backend/video-edit',$data);
    }

	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/video', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_video',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/video','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/video', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('video_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/video', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_video',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/video','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/video', 'refresh');
        endif;
    }
    public function video($id=NULL){
        if(hasPermission('video_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/video');
    	}
    	$data['id']=$id;
    	$data['title']=$this->FunctionModel->Select_Field('title','vidiem_video',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_video_videos',array('parent_id'=>$id));
		$this->load->view('Backend/video-videos-view',$data);
    } 
	public function add_video($id=NULL){
	    if(hasPermission('video_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/video');
    	}
    	$data['id']=$id;
    	$data['title']=$this->FunctionModel->Select_Field('title','vidiem_video',array('id'=>$id));
    	$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('videourl','Video','required');
		$this->form_validation->set_rules('urllink','URL Link','required');
		$this->form_validation->set_rules('image','Image','callback_image_upload');
		$this->form_validation->set_rules('description','Description','required');
    	$this->form_validation->set_rules('order_no','Order No','required');
			 if (!$this->form_validation->run() == FALSE) {
				 $url=$this->input->post('videourl');
                 list($tmp,$videoid)=explode('youtube.com/watch?v=',$url);
			   $InsertData=array(
			        'name'=>$this->input->post('name'),
					'parent_id'=>$id,
					'video_url'=>$videoid,
					'order_no'=>$this->input->post('order_no'),
					'status' =>'1',
					'created'=>date('Y-m-d H:i:s'),
					'title'=>$this->input->post('title'),
					'urllink'=>$this->input->post('urllink'),
					'image'=> $this->upload_data['file']['file_name'],
					'description' => $this->input->post('description')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_video_videos');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Videos Added Successfully.");
				    redirect('Admin/video/video/'.$id,'refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/video/add_video/'.$id, 'refresh');	
				}
				}
		   $this->load->view('Backend/video-videos-add',@$data);	
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

	
	public function video_edit($id = NULL) {
	    if(hasPermission('video_update') != true){
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
    		redirect('Admin/video');
		}
         $data['id']=$this->FunctionModel->Select_Field('parent_id','vidiem_video_videos',array('id'=>$edit_id));
         $data['title']=$this->FunctionModel->Select_Field('title','vidiem_video',array('id'=>$id));
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('videourl','Video','required');
		$this->form_validation->set_rules('urllink','URL Link','required');
		$this->form_validation->set_rules('image','Image','callback_edit_image_upload');
		$this->form_validation->set_rules('description','Description','required');
    	$this->form_validation->set_rules('order_no','Order No','required');
		  if (!$this->form_validation->run() == FALSE) {
			  $url=$this->input->post('videourl');
                 list($tmp,$id)=explode('youtube.com/watch?v=',$url);
			   $UpdateData=array(
			       'name'=>$this->input->post('name'),
					'video_url'    => $id,
					'order_no'=>$this->input->post('order_no'),
					'modified'=>date('Y-m-d H:i:s'),
					'title'=>$this->input->post('title'),
					'urllink'=>$this->input->post('urllink'),
					'image'=> $this->upload_data['file']['file_name'],
					'description' => $this->input->post('description')
				);
		  $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_video_videos',array('id'=>$edit_id));
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_video_videos',array('id'=>$edit_id));
			if ($result == 1) :
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Video Updated Successfully.");
		    	redirect('Admin/video/video/'.$parent_id,'refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/video/video_edit/'.$edit_id, 'refresh');	
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_video_videos',array('id'=>$edit_id));	
		   $this->load->view('Backend/video-videos-edit',$data);	
    }
	
	function edit_image_upload(){
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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_video_videos',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }	
	
	
    public function video_status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/video', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_video_videos',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_video_videos',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/video/video/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/video/video/'.$parent_id, 'refresh');	
        endif;
    }
	public function video_delete($id = NULL) {
	    if(hasPermission('video_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/video', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_video_videos',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_video_videos',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/video/video/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/video/video/'.$parent_id, 'refresh');	
        endif;
    }


}