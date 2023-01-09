<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {
	function __construct() {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->model(array('Accessmodel'));
        $this->load->library('slug');
        if(!$this->session->userdata('user_logged_in')){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}
    }

	 public function index() {
	    if(hasPermission('category_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		$data['DataResult']=$this->FunctionModel->Select('vidiem_category');
		$this->load->view('Backend/category-view',$data);
    }

	public function add() {
		if(hasPermission('category_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		$this->form_validation->set_rules('name','Category Name','required');
		$this->form_validation->set_rules('image','Image','callback_image_upload');
		$this->form_validation->set_rules('imageicon','Image Icon','callback_imageicon_upload');		
		$this->form_validation->set_rules('order_no','Order No','required|integer|max_length[3]');
		$this->form_validation->set_rules('banner_image','Banner Image','callback_bannerimage_upload');

		 if (!$this->form_validation->run() == FALSE) {
				
		   $InsertData=array(
				'parent_id'        => $this->input->post('parent_category'),
				'slug'             => $this->slug->create_unique_slug($this->input->post('name'), 'vidiem_category'),
				'name'             => $this->input->post('name'),
				'banner_image'     => $this->upload_data['banner_image']['file_name'],
				'banner_url'       => $this->input->post('banner_url'),
				'image'            => $this->upload_data['file']['file_name'],
				'imageicon'        => $this->upload_data['imageicon']['file_name'],
				'description'      => $this->input->post('description'),
				'search_keywords'    => $this->input->post('search_keywords'),
				'featured'         => $this->input->post('featured'),
				'meta_title'       => $this->input->post('meta_title'),
				'meta_description' => $this->input->post('meta_description'),
				'meta_keywords'    => $this->input->post('meta_keywords'),
				'content'    => $this->input->post('content'),
				'order_no'         => $this->input->post('order_no'),
				'status'           => '1',
				'created'          => date('Y-m-d H:i:s')
			);
			//print_r($InsertData); exit;
	         $result=$this->FunctionModel->Insert($InsertData,'vidiem_category');

	 
		
			if($result >= 1){
				// Category Revision
				$this->ProjectModel->CategoryRevisionUpdate($result,'inserted');
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Product Category Added Successfully.");
				redirect('Admin/category','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
				redirect('Admin/category/add', 'refresh');
			}
		}
		
	   $data['category']=$this->FunctionModel->Select('vidiem_category',array('status'=>1,'parent_id'=>0));
	   $this->load->view('Backend/category-add',@$data);
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

		 
	function imageicon_upload(){
	  
	    if($_FILES['imageicon']['size'] != 0){
			$upload_dir = './uploads/images';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}

			if(file_exists($upload_dir.'/'.$_FILES['imageicon']['name'])){
				list($file_name)=explode('.',$_FILES['imageicon']['name']);
				$file_name=$file_name.'_'.substr(md5(rand()),0,5);
			}else{
				list($file_name)=explode('.',$_FILES['imageicon']['name']);
			}
			
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['file_name']     = $file_name;
			$config['overwrite']     = false;
			$config['max_size']	     = '5120';

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('imageicon')){
				$this->form_validation->set_message('imageicon_upload', $this->upload->display_errors('<p class=error>','</p>'));
				return false;
			}
			else{
				$this->upload_data['imageicon'] =  $this->upload->data();
				return true;
			}
		}else{
			$this->form_validation->set_message('imageicon_upload', "No file selected");
			return false;
		}
	}  

   function bannerimage_upload(){
	  
		  if($_FILES['banner_image']['size'] != 0){
			$upload_dir = './uploads/images';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}

			if(file_exists($upload_dir.'/'.$_FILES['banner_image']['name'])){
				list($file_name)=explode('.',$_FILES['banner_image']['name']);
				$file_name=$file_name.'_'.substr(md5(rand()),0,5);
			}else{
				list($file_name)=explode('.',$_FILES['banner_image']['name']);
			}
			
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['file_name']     = $file_name;
			$config['overwrite']     = false;
			$config['max_size']	     = '5120';

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('banner_image')){
				$this->form_validation->set_message('bannerimage_upload', $this->upload->display_errors('<p class=error>','</p>'));
				return false;
			}
			else{
				$this->upload_data['banner_image'] =  $this->upload->data();
				return true;
			}
		}
		return true;
   }

	public function edit($id = NULL) {
	    if(hasPermission('category_update') != true){
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
			redirect('Admin/category', 'refresh');
		}
		$this->form_validation->set_rules('name','Category Name','required');
		$this->form_validation->set_rules('image','Image','callback_edit_image_upload');
		$this->form_validation->set_rules('imageicon','Image Icon','callback_edit_image_upload');
		$this->form_validation->set_rules('banner_image','Image','callback_edit_banner_image_upload');
		$this->form_validation->set_rules('order_no','Order No','required|integer|max_length[3]');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
				'slug'             => $this->slug->create_unique_slug($this->input->post('name'), 'vidiem_category'),
				'name'             => $this->input->post('name'),
				'banner_image'     => $this->upload_data['banner_image']['file_name'],
				'banner_url'       => $this->input->post('banner_url'),
				'image'            => $this->upload_data['file']['file_name'],
				'imageicon'        => $this->upload_data['imageicon']['file_name'],
				'description'      => $this->input->post('description'),
				'search_keywords'    => $this->input->post('search_keywords'),
				'featured'         => $this->input->post('featured'),
				'meta_title'       => $this->input->post('meta_title'),
				'meta_description' => $this->input->post('meta_description'),
				'meta_keywords'    => $this->input->post('meta_keywords'),
				'content'    => $this->input->post('content'),
				'order_no'         => $this->input->post('order_no'),
				'modified'           => date('Y-m-d H:i:s')
				);
				// Category Revision
		  $this->ProjectModel->CategoryRevisionUpdate($edit_id,'updated');
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_category',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Webinar Updated Successfully.");
				redirect('Admin/category','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/category/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_category',array('id'=>$edit_id));
		   $this->load->view('Backend/category-edit',$data);
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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_category',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }
   
   
    function edit_imageicon_upload(){
	   if($_FILES['imageicon']['size'] != 0){
			$upload_dir = './uploads/images';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}

			if(file_exists($upload_dir.'/'.$_FILES['imageicon']['name'])){
				list($file_name)=explode('.',$_FILES['imageicon']['name']);
				$file_name=$file_name.'_'.substr(md5(rand()),0,5);
			}else{
				list($file_name)=explode('.',$_FILES['imageicon']['name']);
			}
			
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['file_name']     = $file_name;
			$config['overwrite']     = false;
			$config['max_size']	     = '5120';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('imageicon')){
			$this->form_validation->set_message('edit_imageicon_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			$this->upload_data['imageicon'] =  $this->upload->data();
			return true;
		}
	}
	else{
		$id=$this->input->post('hidden_id');
		$file_name=$this->FunctionModel->Select_Field('imageicon','vidiem_category',array('id'=>$id));
		$this->upload_data['imageicon']['file_name']=$file_name;
		return true;
	}
   }  

   function edit_banner_image_upload(){
	   if($_FILES['banner_image']['size'] != 0){
			$upload_dir = './uploads/images';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}

			if(file_exists($upload_dir.'/'.$_FILES['banner_image']['name'])){
				list($file_name)=explode('.',$_FILES['banner_image']['name']);
				$file_name=$file_name.'_'.substr(md5(rand()),0,5);
			}else{
				list($file_name)=explode('.',$_FILES['banner_image']['name']);
			}
			
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['file_name']     = $file_name;
			$config['overwrite']     = false;
			$config['max_size']	     = '5120';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('banner_image')){
			$this->form_validation->set_message('edit_banner_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			$this->upload_data['banner_image'] =  $this->upload->data();
			return true;
		}
	}
	else{
		$id=$this->input->post('hidden_id');
		$file_name=$this->FunctionModel->Select_Field('banner_image','vidiem_category',array('id'=>$id));
		$this->upload_data['banner_image']['file_name']=$file_name;
		return true;
	}
   }

	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/category', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_category',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/category','refresh');
        else :
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/category', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('category_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/category', 'refresh');
		}
		// Category Revision
		$this->ProjectModel->CategoryRevisionUpdate($id,'deleted');
        $result = $this->FunctionModel->Delete('vidiem_category',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/category','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/category', 'refresh');
        endif;
    }

    public function AjaxSingleView(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/category');
    	}
    	$info=$this->FunctionModel->Select_Row('vidiem_category',array('id'=>$id));
    	$return['modal_title']='View Category';
    	$return['modal_content']='';
    	if($info['parent_id']!=0){
    		$parent_category=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$info['parent_id']));
    		$return['modal_content'].='<div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">Parent Category</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$parent_category.'</label>
                  </div>
                </div>
            </div>';
    	}
    	$return['modal_content'].='
				        <div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['name'].'</label>
                  </div>
                </div>
            </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Image</label>
                  <div class="col-sm-8">
                    <label class="control-label"><img src="'.base_url('uploads/images/'.$info['image']).'" width="250px" height="250px" class="img-responsive"></label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['description'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Feautred</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.($info['featured']=='1'?'YES':'-').'</label>
                  </div>
                </div>
            </div>
             <div class="row">    
				<div class="form-group">
                  <label class="col-sm-3 control-label">Order No.</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['order_no'].'</label>
                  </div>
                </div>
                 </div>';
                 
                 if(!empty($info['banner_image'])){
                 	$return['modal_content'].='<h4 class="box-title">Banner Image Information</h4>
					<div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Banner Image</label>
                  <div class="col-sm-8">
                    <label class="control-label"><img src="'.base_url('uploads/images/'.$info['banner_image']).'" width="250px" height="250px" class="img-responsive"></label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Banner Url</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.base_url($info['banner_url']).'</label>
                  </div>
                </div>
                 </div>';
             	}

				$return['modal_content'].='<h4 class="box-title">Seo Information</h4>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Meta Title</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['meta_title'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                 <div class="form-group">
                  <label class="col-sm-3 control-label">Meta Decription</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['meta_description'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                 <div class="form-group">
                  <label class="col-sm-3 control-label">Meta Keywords</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['meta_keywords'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
				<div class="form-group">
                  <label class="col-sm-3 control-label">Status</label>
                  <div class="col-sm-8">
                    <label class="control-label"><span class="label label-'.($info['status']==1?'success':'warning').' status-span">'.($info['status']==1?'Active':'InActive').'</span></label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Created</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['created'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label"></label>
                  <div class="col-sm-8">
                    <label class="control-label"><a href="'.base_url('Admin/category/edit/'.$info['id']).'" class="btn btn-primary" data-toggle="tooltip" data-placement="left"  data-original-title="Edit"><span class="fa fa-edit"> &nbsp;Edit</span></a></label>
                  </div>
                </div>
                </div>
                ';
    	echo json_encode($return);
    	exit;
    }

    // Category Feauture Functionality

    public function AjaxFeautres(){
    	$id=$this->input->post('id');
    	$features=$this->FunctionModel->Select_Fields('id,name,order_no','vidiem_features',array('parent_id'=>$id));
    	// echo $this->db->last_query(); exit;
    	echo '<form class="form-horizontal feautre_form"><table class="table">
    			<input type="hidden" name="id" value="'.$id.'">
    		   <thead><tr><th>S.No.</th><th>Name</th><th class="col-xs-3">Order No.</th><th>Option</th></tr></thead><tbody class="feature_body">';
    	if(!empty($features)){ 
    	    $x=1;
    		foreach ($features as $info) {
    			echo '<tr><td>'.$x.'<input type="hidden" name="hidden_id[]" value="'.$info['id'].'"></td>
						<td><input type="text" name="name[]" class="form-control" value="'.$info['name'].'"></td>
						<td><input type="text" name="order_no[]" class="form-control" value="'.$info['order_no'].'"></td>
						<td><a href="javascript:void(0);" data-id="'.$info['id'].'" class="btn btn-danger remove_feautre"><i class="fa fa-times"></i></a></td>';
    		$x++;} }
    	echo '<tr><td><input type="hidden" name="hidden_id[]" value="0"></td>
						<td><input type="text" name="name[]" class="form-control" value=""></td>
						<td><input type="text" name="order_no[]" class="form-control" value=""></td>
						<td><a href="javascript:void(0);" class="btn btn-danger remove_feautre_empty"><i class="fa fa-times"></i></a></td>';	   
    	echo '</tbody>
				<tfoot><tr><td></td><td><button type="submit" class="btn btn-info col-sm-6 feautre_submit">Update</button></td><td></td><td><a href="javascript:void(0);" class="btn btn-primary add_feautre_trigger">Add <i class="fa fa-plus"></i></a></td></tfoot>
    	      </table></form>';	    
    	exit;
    }

    public function delete_feautre(){
    	$id=$this->input->post('id');
    	$this->FunctionModel->Delete('vidiem_features',array('id'=>$id));
    	echo '1'; exit;
    }

    public function updateCategoryFeautres(){
    	$id=$this->input->post('id');
    	$hidden_id=$this->input->post('hidden_id');
    	$name=$this->input->post('name');
    	$order_no=$this->input->post('order_no');
    	if(!empty($hidden_id)){ $x=0;
    		foreach ($hidden_id as $info) {
    			if(!empty($name[$x])){
    			if($info==0){
    				$InsertData=array(
    					'parent_id'=>$id,
    					'name'=>$name[$x],
    					'order_no'=>$order_no[$x],
    					'status'=>1,
    					'created'=>date('Y-m-d H:i:s')
    				);
    				$this->FunctionModel->Insert($InsertData,'vidiem_features');
    			}
    			else{
    				$UpdateData=array(
    					'parent_id'=>$id,
    					'name'=>$name[$x],
    					'order_no'=>$order_no[$x],
    					'modified'=>date('Y-m-d H:i:s')
    				);
    				$this->FunctionModel->Update($UpdateData,'vidiem_features',array('id'=>$info));
    			}
    		  }	
    		$x++; }
    	}
    	$features=$this->FunctionModel->Select_Fields('id,name,order_no','vidiem_features',array('parent_id'=>$id));
    	echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-check"></i> Alert!</h4>
      Category Features Successfully Updated.    </div>
    	<form class="form-horizontal feautre_form"><table class="table">
    			<input type="hidden" name="id" value="'.$id.'">
    		   <thead><tr><th>S.No.</th><th>Name</th><th class="col-xs-3">Order No.</th><th>Option</th></tr></thead><tbody class="feature_body">';
    	if(!empty($features)){ $x=1;
    		foreach ($features as $info) {
    			echo '<tr><td>'.$x.'<input type="hidden" name="hidden_id[]" value="'.$info['id'].'"></td>
						<td><input type="text" name="name[]" class="form-control" value="'.$info['name'].'"></td>
						<td><input type="text" name="order_no[]" class="form-control" value="'.$info['order_no'].'"></td>
						<td><a href="javascript:void(0);" data-id="'.$info['id'].'" class="btn btn-danger remove_feautre"><i class="fa fa-times"></i></a></td>';
    		$x++;} }
    	echo '<tr><td><input type="hidden" name="hidden_id[]" value="0"></td>
						<td><input type="text" name="name[]" class="form-control" value=""></td>
						<td><input type="text" name="order_no[]" class="form-control" value=""></td>
						<td><a href="javascript:void(0);" class="btn btn-danger remove_feautre_empty"><i class="fa fa-times"></i></a></td>';	   
    	echo '</tbody>
				<tfoot><tr><td></td><td><button type="submit" class="btn btn-info col-sm-6 feautre_submit">Update</button></td><td></td><td><a href="javascript:void(0);" class="btn btn-primary add_feautre_trigger">Add <i class="fa fa-plus"></i></a></td></tfoot>
    	      </table></form>';	    
    	exit;
    }
    public function image($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/category');
    	}
    	$data['id']=$id;
    	$data['name']=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_category_images',array('parent_id'=>$id));
			   //$data['DataResult']=$this->FunctionModel->Select('vidiem_category',array('status'=>1,'parent_id'=>0));

		$this->load->view('Backend/category-image-view',$data);
    }
	    public function add_image($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/category');
    	}
    	$data['id']=$id;
    	$data['name']=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$id));
    	$this->form_validation->set_rules('name','Name','required');
    	$this->form_validation->set_rules('image','Image','callback_image_upload');
    	//$this->form_validation->set_rules('banner_url','Banner_url','required');
    	$this->form_validation->set_rules('order_no','Order No','required');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'parent_id'=>$id,
					'name'=>$this->input->post('name'),
					'image'=>$this->upload_data['file']['file_name'],
					'banner_url'       => $this->input->post('banner_url'),
					'order_no'=>$this->input->post('order_no'),
					'status' =>'1',
					'created'=>date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_category_images');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Category Images Added Successfully.");
				    redirect('Admin/category/image/'.$id,'refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/category/add_image/'.$id, 'refresh');	
				}
				}
		   $this->load->view('Backend/category-image-add',@$data);	
    }
	public function image_edit($id = NULL) {
		$edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/category');
		}
         $data['id']=$this->FunctionModel->Select_Field('parent_id','vidiem_category_images',array('id'=>$edit_id));
         $data['name']=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$id));
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('image','Image','callback_edit_content_image_upload');
    	$this->form_validation->set_rules('order_no','Order No','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'name'=>$this->input->post('name'),
					'image'=>$this->upload_data['file']['file_name'],
					'banner_url'       => $this->input->post('banner_url'),
					'order_no'=>$this->input->post('order_no'),
					'modified'=>date('Y-m-d H:i:s')
				);
		  $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_category_images',array('id'=>$edit_id));
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_category_images',array('id'=>$edit_id));
			if ($result == 1) :
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Category Image Updated Successfully.");
		    	redirect('Admin/category/image/'.$parent_id,'refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/category/image_edit/'.$edit_id, 'refresh');	
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_category_images',array('id'=>$edit_id));	
		   $this->load->view('Backend/category-image-edit',$data);	
    }
	function edit_content_image_upload(){
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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_category_images',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }
      public function image_status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/category', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_category_images',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_category_images',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/category/image/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/category/image/'.$parent_id, 'refresh');	
        endif;
    }
	
	public function image_delete($id = NULL) {
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/category', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_category_images',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_category_images',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/category/image/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/category/image/'.$parent_id, 'refresh');	
        endif;
    }

    // categoryFilter
    public function categoryFilter(){
    	$id=$this->input->post('id');
    	// $id=1;
    	$filters=$this->FunctionModel->Select_Fields('id,name','vidiem_filters',array('status'=>1));
    	$cat_filter=$this->FunctionModel->Select_Fields('filter_id','vidiem_category_filters',array('parent_id'=>$id));
    	$cat_fil=array();
    	if(!empty($cat_filter)){
    		foreach ($cat_filter as $info) {
    			$cat_fil[]=$info['filter_id'];
    		}
    	}
    	echo '<form class="form-horizontal update_cat_filter cat_filter_form">
    			<input type="hidden" name="id" value="'.$id.'">
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Filters</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="filters[]" class="form-control select2" multiple="multiple">';
						if(!empty($filters)){
							foreach ($filters as $info) {
								echo '<option value="'.$info['id'].'" '.((in_array($info['id'],$cat_fil))?'selected':'').'>'.$info['name'].'</option>';
							}
						}
					echo '</select>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-md-6 col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
               </form>
               <style>
               span.select2{width:100% !important;}
				.select2-container--default .select2-selection--multiple .select2-selection__choice {color: #000; }</style>
				';
    		   
    	exit;
    }

    public function UpdateFilters(){
    	$id=$this->input->post('id');
    	$filters=$this->input->post('filters');
    	$this->db->where_not_in('filter_id',$filters);
    	$this->db->delete('vidiem_category_filters',array('parent_id'=>$id));
    	if(!empty($filters)){
    		$InsertData=array(
    			'parent_id'=>$id,
    			'created'=>date('Y-m-d H:i:s')
    		);
    		foreach ($filters as $info) {
    			$count=$this->FunctionModel->Row_Count('vidiem_category_filters',array('parent_id'=>$id,'filter_id'=>$info));
    			if($count==0){
    				$InsertData['filter_id']=$info;
    				$this->FunctionModel->Insert($InsertData,'vidiem_category_filters');
    			}	
    		}
    	}
    	$filters=$this->FunctionModel->Select_Fields('id,name','vidiem_filters',array('status'=>1));
    	$cat_filter=$this->FunctionModel->Select_Fields('filter_id','vidiem_category_filters',array('parent_id'=>$id));
    	$cat_fil=array();
    	if(!empty($cat_filter)){
    		foreach ($cat_filter as $info) {
    			$cat_fil[]=$info['filter_id'];
    		}
    	}
    	echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-check"></i> Alert!</h4>
      Category Filters Successfully Updated.    </div>
    	<form class="form-horizontal update_cat_filter cat_filter_form">
    			<input type="hidden" name="id" value="'.$id.'">
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Filters</label>
                  <div class="col-md-6 col-sm-10">
                    <select name="filters[]" class="form-control select2" multiple="multiple">';
						if(!empty($filters)){
							foreach ($filters as $info) {
								echo '<option value="'.$info['id'].'" '.((in_array($info['id'],$cat_fil))?'selected':'').'>'.$info['name'].'</option>';
							}
						}
					echo '</select>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-md-6 col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
               </form>
               <style>
               span.select2{width:100% !important;}
				.select2-container--default .select2-selection--multiple .select2-selection__choice {color: #000; }</style>
				';
    	exit;
	}
	
	// Revison Master Functionality
	public function revisions(){
		$data['DataResult']=$this->ProjectModel->deletedCategoryList();
		$this->load->view('Backend/category-revision-view',$data);
	}

	public function AjaxCategoryRevisionList(){
		$id=$this->input->post('id');
		$data=$this->FunctionModel->Select_Fields('id,rev_type,user_name,rev_time','vidiem_category_revision',['rev_parent_id'=>$id],'id','DESC');
		$return['modal_title']='Category Revision';
    	$return['modal_content']='';
    	
			$return['modal_content'].='
			<table class="table">
				<thead>
					<tr>
						<th>S.No</th>
						<th>User Name</th>
						<th>Revision Type</th>
						<th>Time</th>
						<th>View</th>
					</tr>';
				if(!empty($data)){ $i=1;
					foreach($data as $info){
						$return['modal_content'].='<tr>
						<td>'.$i.'</td>
						<td>'.$info['user_name'].'</td>
						<td>'.ucfirst($info['rev_type']).'</td>
						<td>'.date('d-M-Y H:i:s',strtotime($info['rev_time'])).'</td>
						<td><a href="javascript:void(0);" class="btn bg-navy revision_category_view" data-id="'.$info['id'].'" data-toggle="tooltip" data-placement="left" data-original-title="view"><span class="fa fa-eye"></span></a></td>
						</tr>';
						$i++;
					}
				}
		echo json_encode($return); exit;	
    	
	}

	public function AjaxSingleViewRevision(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/category');
    	}
    	$info=$this->FunctionModel->Select_Row('vidiem_category_revision',['id'=>$id]);
    	$return['modal_title']='View Revisions';
    	$return['modal_content']='';
			$return['modal_content'].='
			<div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">User Name</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['user_name'].'</label>
                  </div>
                </div>
			</div>';
			
    	$return['modal_content'].='
				        <div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['name'].'</label>
                  </div>
                </div>
            </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Image</label>
                  <div class="col-sm-8">
                    <label class="control-label"><img src="'.base_url('uploads/images/'.$info['image']).'" width="250px" height="250px" class="img-responsive"></label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Feautred</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.($info['featured']=='1'?'YES':'-').'</label>
                  </div>
                </div>
            </div>
             <div class="row">    
				<div class="form-group">
                  <label class="col-sm-3 control-label">Order No.</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['order_no'].'</label>
                  </div>
                </div>
                 </div>';

				$return['modal_content'].='<h4 class="box-title">Seo Information</h4>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Meta Title</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['meta_title'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                 <div class="form-group">
                  <label class="col-sm-3 control-label">Meta Decription</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['meta_description'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                 <div class="form-group">
                  <label class="col-sm-3 control-label">Meta Keywords</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['meta_keywords'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
				<div class="form-group">
                  <label class="col-sm-3 control-label">Status</label>
                  <div class="col-sm-8">
                    <label class="control-label"><span class="label label-'.($info['status']==1?'success':'warning').' status-span">'.($info['status']==1?'Active':'InActive').'</span></label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Created</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['created'].'</label>
                  </div>
                </div>
                 </div>
                </div>
                ';
    	echo json_encode($return);
    	exit;
    }

    
}