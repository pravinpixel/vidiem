<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipe extends CI_Controller {
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
	    if(hasPermission('recipe_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
		$data['DataResult']=$this->FunctionModel->Select('vidiem_recipe');
		$this->load->view('Backend/recipe-view',$data);
    }

	public function add() {
	    if(hasPermission('recipe_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
	    $this->form_validation->set_rules('name','Name','required');
	    $this->form_validation->set_rules('image','Image','callback_image_upload');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
		 if (!$this->form_validation->run() == FALSE) {
		   $InsertData=array(
				'name' => $this->input->post('name'),
				'image'        => $this->upload_data['file']['file_name'],
				'order_no'     => $this->input->post('order_no'),
				'status'   => '1',
				'created'  => date('Y-m-d H:i:s')
			);
	         $result=$this->FunctionModel->Insert($InsertData,'vidiem_recipe');
			if($result >= 1){
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Recipe Added Successfully.");
				redirect('Admin/recipe','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
				redirect('Admin/recipe/add', 'refresh');
			}
		}
	   $this->load->view('Backend/recipe-add',@$data);
    }
    function image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/recipe';
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
		$config['max_size']	     = '51200';

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
	    if(hasPermission('recipe_update') != true){
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
			redirect('Admin/recipe', 'refresh');
		}
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		 $this->form_validation->set_rules('name','Name','required');
		 $this->form_validation->set_rules('image','Image','callback_edit_image_upload');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'name' => $this->input->post('name'),
					'image'    => $this->upload_data['file']['file_name'],
					'order_no' => $this->input->post('order_no'),
					'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_recipe',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Recipe Updated Successfully.");
				redirect('Admin/recipe','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/recipe/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_recipe',array('id'=>$edit_id));
		   $this->load->view('Backend/recipe-edit',$data);
    }
function edit_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/recipe';
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
		$config['max_size']	     = '51200';

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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_recipe',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }

	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/recipe', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_recipe',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/recipe','refresh');
        else :
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/recipe', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('recipe_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/recipe', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_recipe',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/recipe','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/recipe', 'refresh');
        endif;
    }


    public function bannerview(){
        if(hasPermission('recipe_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_recipe_banner');
		$this->load->view('Backend/recipe-banner-view',$data);
    }    
    public function banneradd() {
        if(hasPermission('recipe_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
    	$this->form_validation->set_rules('title','Title','required');
	    $this->form_validation->set_rules('name','Name','required');
	    $this->form_validation->set_rules('image','Image','callback_banner_image_upload');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
		 if (!$this->form_validation->run() == FALSE) {
		   $InsertData=array(
		     	'title' => $this->input->post('title'),
				'name' => $this->input->post('name'),
				'image'        => $this->upload_data['file']['file_name'],
				'order_no'     => $this->input->post('order_no'),
				'status'   => '1',
				'created'  => date('Y-m-d H:i:s')
			);
	         $result=$this->FunctionModel->Insert($InsertData,'vidiem_recipe_banner');
			if($result >= 1){
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Recipe Banner Added Successfully.");
				redirect('Admin/recipe/bannerview','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
				redirect('Admin/recipe/bannerview/banneradd', 'refresh');
			}
		}
	   $this->load->view('Backend/recipe-banner-add',@$data);
    }
     function banner_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/recipe/banner';
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
		$config['max_size']	     = '51200';

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
    public function banneredit($id = NULL) {
        if(hasPermission('recipe_update') != true){
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
			redirect('Admin/recipe/bannerview', 'refresh');
		}
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('title','Title','required');
		 $this->form_validation->set_rules('name','Name','required');
		 $this->form_validation->set_rules('image','Image','callback_edit_banner_image_upload');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
			    	'title' => $this->input->post('title'),
					'name' => $this->input->post('name'),
					'image'    => $this->upload_data['file']['file_name'],
					'order_no' => $this->input->post('order_no'),
					'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_recipe_banner',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Recipe Banner Updated Successfully.");
				redirect('Admin/recipe/bannerview','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/recipe/bannerview/recipeedit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_recipe_banner',array('id'=>$edit_id));
		   $this->load->view('Backend/recipe-banner-edit',$data);
    }
    function edit_banner_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/recipe/banner';
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
		$config['max_size']	     = '51200';

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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_recipe_banner',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }
  public function bannerstatus($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/recipe/bannerview', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_recipe_banner',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/recipe/bannerview','refresh');
        else :
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/recipe/bannerview', 'refresh');
        endif;
    }

	public function bannerdelete($id = NULL) {
	    if(hasPermission('recipe_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/recipe/bannerview', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_recipe_banner',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/recipe/bannerview','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/recipe/bannerview', 'refresh');
        endif;
    }
   public function recipecat($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/recipe');
    	}
    	$data['id']=$id;
    	$data['title']=$this->FunctionModel->Select_Field('name','vidiem_recipe',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_recipe_category',array('parent_id'=>$id));
		$this->load->view('Backend/recipe-cat-view',$data);
    }    
      public function recipecatadd($id=NULL) {
	    if(empty($id)){ 
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/recipe');
    	}
    	$data['id']=$id; 
    	//$data['name'] = $name;
    	$data['title']=$this->FunctionModel->Select_Field('name','vidiem_recipe',array('id'=>$id));
    	$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('content','Content','required');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
				 if (!$this->form_validation->run() == FALSE) {
			//$name = $this->FunctionModel->Select_Field('name','vidiem_recipe',array('id'=>$id));
			//$imagee = $this->FunctionModel->Select_Field('image','vidiem_recipe',array('id'=>$id));
			   $InsertData=array( 
			   	'parent_id'=>$id,
			   //	'parent_name'=>$name,  
			   //	'parent_image'=>$imagee,
				'title' => $this->input->post('title'),
				'content'  => $this->input->post('content'),
				'order_no' => $this->input->post('order_no'),
				'status'   => '1',
				'created'  => date('Y-m-d H:i:s')
				);
			   $increcontent = $this->input->post('increcontent');
			   if(!empty($increcontent)){$InsertData['increcontent']=$increcontent;}
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_recipe_category');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "RecipeAdded Successfully.");
				    redirect('Admin/recipe/recipecat/'.$id,'refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/recipe/recipecatadd/'.$id, 'refresh');	
				}
				}
		   $this->load->view('Backend/recipe-cat-add',@$data);	
    } 
     public function recipecatedit($id = NULL) {
     $edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/recipe/recipecat');
		}
         $data['id']=$this->FunctionModel->Select_Field('parent_id','vidiem_recipe_category',array('id'=>$edit_id));
         $data['title']=$this->FunctionModel->Select_Field('name','vidiem_recipe',array('id'=>$id));
	     $this->form_validation->set_rules('hidden_id', 'ID', 'required');
		 $this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('content','Answer','required');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
	
		  if (!$this->form_validation->run() == FALSE) {
          $UpdateData=array(
					'title' => $this->input->post('title'),
					'content'  => $this->input->post('content'),
					 'increcontent' => $this->input->post('increcontent'),
					'order_no' => $this->input->post('order_no'),
					'modified' => date('Y-m-d H:i:s')
				);
          //$increcontent = $this->input->post('increcontent');
			if(!empty($increcontent)){$UpdateData['increcontent']=$increcontent;}
		  $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_recipe_category',array('id'=>$edit_id));
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_recipe_category',array('id'=>$edit_id));
			if ($result == 1) :
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Recipe Updated Successfully.");
		    	redirect('Admin/recipe/recipecat/'.$parent_id,'refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/recipe/recipecat/'.$edit_id, 'refresh');	
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_recipe_category',array('id'=>$edit_id));	
		   $this->load->view('Backend/recipe-cat-edit',$data);	

    }
    public function recipecatstatus($id = NULL,$status = NULL) { 
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/recipe/recipecat', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_recipe_category',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_recipe_category',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/recipe/recipecat/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/recipe/recipecat/'.$parent_id, 'refresh');	
        endif;
    }
     public function recipecatdelete($id = NULL) {
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/recipe/recipecat/', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_recipe_category',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_recipe_category',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/recipe/recipecat/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/recipe/recipecat/'.$parent_id, 'refresh');	
        endif;
    }
    public function AjaxSingleView(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/productregister');
    	}
    	$info=$this->FunctionModel->Select_Row('vidiem_product_registration',array('id'=>$id));
    	$return['modal_name']='View Product Register';
        $return['modal_title']='View Product Register';
    	$return['modal_content']='
				<div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">Product Name</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['Product'].'</label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Serial Number</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['serialnumer'].'</label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Date</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['jdate'].'</label>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Dealer Name</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['dealername'].'</label>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['name'].'</label>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['email'].'</label>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Mobile</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['mobile'].'</label>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">Address</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['address'].'</label>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">City</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['city'].'</label>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label">State</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['state'].'</label>
                  </div>
                </div>
				<div class="form-group"> 
                  <label class="col-sm-3 control-label">Pincode</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['pincode'].'</label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Created</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['created'].'</label>
                  </div>
                </div>
                
                </div>
                ';
    	echo json_encode($return);
    	exit;
    }

} 