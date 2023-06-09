<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {
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
	    if(hasPermission('product_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		$data['DataResult']=$this->ProjectModel->ProuctListing();
		$data['cat']=$this->FunctionModel->Select_Fields('name','vidiem_category',array('parent_id'=>0,'status'=>1));
		$this->load->view('Backend/product-view',$data);
    }

	public function add() {
	    if(hasPermission('product_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		$this->form_validation->set_rules('category','Category','required');
		$this->form_validation->set_rules('sub_category','Sub Category','callback_sub_category');
		$this->form_validation->set_rules('name','Product Name','required');
		$this->form_validation->set_rules('modal_no','Modal No.','required');
		$this->form_validation->set_rules('price','Price','required');
		$this->form_validation->set_rules('short_description','Short Description','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('image','Image','callback_image_upload');
		$this->form_validation->set_rules('key_feature_image','Key Feature Image','callback_temp_image_upload');
		$this->form_validation->set_rules('manual','Manual','callback_manual_upload');
		$this->form_validation->set_rules('order_no','Order No','required|integer|max_length[3]');
		 if (!$this->form_validation->run() == FALSE) {
		 
		   $InsertData=array(
				'cat_id'           => $this->input->post('category'),
				'sub_cat_id'       => $this->input->post('sub_category'),
				'slug'             => $this->slug->create_unique_slug($this->input->post('name'), 'vidiem_products'),
				'name'             => $this->input->post('name'),
				'modal_no'         => $this->input->post('modal_no'),
				'image'            => $this->upload_data['file']['file_name'],
				'short_description'=> $this->input->post('short_description'),
				'list_description'=> $this->input->post('list_description'),
				'description'      => $this->input->post('description'),
				'search_keywords'    => $this->input->post('search_keywords'), 
				'key_feature'      => $this->input->post('key_feature'),
				'key_feature_image'=> $this->upload_data['key_feature_image']['file_name'],
				'warranty'         => $this->input->post('warranty'),
				'manual'            => $this->upload_data['manual']['file_name'],
				'exclusive'        => $this->input->post('exclusive'),
				'featured'         => $this->input->post('featured'),
				'new_launches'     => $this->input->post('new_launches'),
				'outofstock'       => $this->input->post('outofstock'),
				'popularproduct'       => $this->input->post('popularproduct'),
				'iscustomized'       => $this->input->post('iscustomized'),
				'old_price'        => $this->input->post('old_price'),
				'price'            => $this->input->post('price'),
				'meta_title'       => $this->input->post('meta_title'),
				'meta_description' => $this->input->post('meta_description'),
				'meta_keywords'    => $this->input->post('meta_keywords'),
				'order_no'         => $this->input->post('order_no'),
				'status'           => '1',
				'created'          => date('Y-m-d H:i:s')
			);
	         $result=$this->FunctionModel->Insert($InsertData,'vidiem_products');
			if($result >= 1){
				// Product Revision
				$this->ProjectModel->ProductRevisionUpdate($result,'inserted');
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Product Category Added Successfully.");
				redirect('Admin/products','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
				redirect('Admin/products/add', 'refresh');
			}
		}
	   $data['category']=$this->FunctionModel->Select('vidiem_category',array('status'=>1,'parent_id'=>0));
	   if(!empty($this->input->post('category'))){
	   		$cat_id=$this->input->post('category');
	   		$data['sub_category']=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('status'=>1,'parent_id'=>$cat_id));
	   }
	   $this->load->view('Backend/product-add',@$data);
    }

    function sub_category(){
    	if(empty($this->input->post('category'))){
    		return TRUE;
    	}
    	$cat_id=$this->input->post('category');
    	$count=$this->FunctionModel->Row_Count('vidiem_category',array('status'=>1,'parent_id'=>$cat_id));
    	if($count!=0 && empty($this->input->post('sub_category'))){
    		$this->form_validation->set_message('sub_category','Sub Category Required');
    		return false;
    	}
    	return TRUE;
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

   function temp_image_upload(){
		 if($_FILES['key_feature_image']['size'] != 0){
			$upload_dir = './uploads/images';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}

			if(file_exists($upload_dir.'/'.$_FILES['key_feature_image']['name'])){
				list($file_name)=explode('.',$_FILES['key_feature_image']['name']);
				$file_name=$file_name.'_'.substr(md5(rand()),0,5);
			}else{
				list($file_name)=explode('.',$_FILES['key_feature_image']['name']);
			}
			
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg|gif';
			$config['file_name']     = $file_name;
			$config['overwrite']     = false;
			$config['max_size']	     = '5120';

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('key_feature_image')){
				$this->form_validation->set_message('temp_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
				return false;
			}
			else{
				$this->upload_data['key_feature_image'] =  $this->upload->data();
				return true;
			}
		}
		else{
			$this->upload_data['key_feature_image']['file_name']='';
			return true;
		}
   }

   function manual_upload(){
		  if($_FILES['manual']['size'] != 0){
			$upload_dir = './uploads/manual';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}

			if(file_exists($upload_dir.'/'.$_FILES['manual']['name'])){
				list($file_name)=explode('.',$_FILES['manual']['name']);
				$file_name=$file_name.'_'.substr(md5(rand()),0,5);
			}else{
				list($file_name)=explode('.',$_FILES['manual']['name']);
			}
			
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg|doc|pdf|gif';
			$config['file_name']     = $file_name;
			$config['overwrite']     = false;
			$config['max_size']	     = '15120';

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('manual')){
				$this->form_validation->set_message('manual_upload', $this->upload->display_errors('<p class=error>','</p>'));
				return false;
			}
			else{
				$this->upload_data['manual'] =  $this->upload->data();
				return true;
			}
		}
		$this->upload_data['manual']['file_name']='';
		return true;
   }


	public function edit($id = NULL) {
	    if(hasPermission('product_update') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
	    //if(!empty($_POST)){echo '<pre>'; print_r($_FILES); echo '</pre>'; exit;}
		$edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
	//	print_r($edit_id);exit;
		if(empty($edit_id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/products', 'refresh');
		}
		//$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('category','Category','required');
		$this->form_validation->set_rules('sub_category','Sub Category','callback_edit_sub_category');
		$this->form_validation->set_rules('name','Product Name','required');
		$this->form_validation->set_rules('modal_no','Modal No.','required');
		$this->form_validation->set_rules('price','Price','required');
		$this->form_validation->set_rules('short_description','Short Description','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('image','Image','callback_edit_image_upload');
		$this->form_validation->set_rules('key_feature_image','Key Feature Image','callback_edit_temp_image_upload');
		$this->form_validation->set_rules('manual','Manual','callback_edit_manual_upload');
		$this->form_validation->set_rules('order_no','Order No','required|integer|max_length[3]');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
				'cat_id'           => $this->input->post('category'),
				'sub_cat_id'       => $this->input->post('sub_category'),
				'slug'             => $this->slug->create_unique_slug($this->input->post('name'), 'vidiem_products'),
				'name'             => $this->input->post('name'),
				'modal_no'         => $this->input->post('modal_no'),
				'image'            => $this->upload_data['file']['file_name'],
				'short_description'=> $this->input->post('short_description'),
				'list_description'=> $this->input->post('list_description'),
				'description'      => $this->input->post('description'),
				'search_keywords'    => $this->input->post('search_keywords'), 
				'key_feature'      => $this->input->post('key_feature'),
				'key_feature_image'=> $this->upload_data['key_feature_image']['file_name'],
				'warranty'         => $this->input->post('warranty'),
				'manual'            => $this->upload_data['manual']['file_name'],
				'featured'         => $this->input->post('featured'),
				'exclusive'        => $this->input->post('exclusive'),
				'new_launches'     => $this->input->post('new_launches'),
				'outofstock'       => $this->input->post('outofstock'),
				'popularproduct'       => $this->input->post('popularproduct'),
				'iscustomized'       => $this->input->post('iscustomized'),
				'old_price'        => $this->input->post('old_price'),
				'price'            => $this->input->post('price'),
				'meta_title'       => $this->input->post('meta_title'),
				'meta_description' => $this->input->post('meta_description'),
				'meta_keywords'    => $this->input->post('meta_keywords'),
				'order_no'         => $this->input->post('order_no'),
				'modified'           => date('Y-m-d H:i:s')
				);
			$this->ProjectModel->ProductRevisionUpdate($edit_id,'updated');
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_products',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Webinar Updated Successfully.");
				redirect('Admin/products','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/products/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_products',array('id'=>$edit_id));
			$data['category']=$this->FunctionModel->Select('vidiem_category',array('status'=>1,'parent_id'=>0));
			if(!empty($this->input->post('hidden_id'))){
				if(!empty($this->input->post('category'))){
		   			$cat_id=$this->input->post('category');
		   			$data['sub_category']=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('status'=>1,'parent_id'=>$cat_id));
	   			}
	   		}
	   		else{
	   			$data['sub_category']=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('status'=>1,'parent_id'=>$data['Edit_Result']['cat_id']));
	   		}
		   $this->load->view('Backend/product-edit',$data);
    }

    function edit_sub_category(){
    	if(empty($this->input->post('category'))){
    		return TRUE;
    	}
    	$cat_id=$this->input->post('category');
    	$count=$this->FunctionModel->Row_Count('vidiem_category',array('status'=>1,'parent_id'=>$cat_id));
    	if($count!=0 && empty($this->input->post('sub_category'))){
    		$this->form_validation->set_message('sub_category','Sub Category Required');
    		return FALSE;
    	}
    	return TRUE;
    }

	function edit_image_upload(){
	     //print_r($_FILES['image']['name']);exit;
	   if($_FILES['image']['size'] != 0){
	      //print_r($_FILES['image']['name']);exit;
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
			$config['overwrite']     = TRUE;
			$config['max_size']	     = '2048000';
			 $config['max_width']  = '5024';
            $config['max_height']  = '5024';


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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_products',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }

   function edit_temp_image_upload(){
	   if($_FILES['key_feature_image']['size'] != 0){
			$upload_dir = './uploads/images';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}

			if(file_exists($upload_dir.'/'.$_FILES['key_feature_image']['name'])){
				list($file_name)=explode('.',$_FILES['key_feature_image']['name']);
				$file_name=$file_name.'_'.substr(md5(rand()),0,5);
			}else{
				list($file_name)=explode('.',$_FILES['key_feature_image']['name']);
			}
			
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg|gif';
			$config['file_name']     = $file_name;
			$config['overwrite']     = TRUE;
			$config['max_size']	     = '2048000';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('key_feature_image')){
			$this->form_validation->set_message('edit_temp_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			$this->upload_data['key_feature_image'] =  $this->upload->data();
			return true;
		}
	}
	else{
		$id=$this->input->post('hidden_id');
		$file_name=$this->FunctionModel->Select_Field('key_feature_image','vidiem_products',array('id'=>$id));
		$this->upload_data['key_feature_image']['file_name']=$file_name;
		return true;
	}
   }

   function edit_manual_upload(){
	  if($_FILES['manual']['size'] != 0){
		$upload_dir = './uploads/manual';
		if (!is_dir($upload_dir)) {
		     mkdir($upload_dir);
		}
		$config['upload_path']   = $upload_dir;
		$config['allowed_types'] = 'jpg|png|jpeg|doc|pdf|gif';
		$config['file_name']     = 'image_'.substr(md5(rand()),0,10);
		$config['overwrite']     = false;
		$config['max_size']	     = '10120';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('manual')){
			$this->form_validation->set_message('edit_manual_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			$this->upload_data['manual'] =  $this->upload->data();
			return true;
		}
	}
	else{
		$id=$this->input->post('hidden_id');
		$file_name=$this->FunctionModel->Select_Field('manual','vidiem_products',array('id'=>$id));
		$this->upload_data['manual']['file_name']=$file_name;
		return true;
	}
   }
   
   public function test(){
       phpinfo(); exit;
   }
   
	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/products', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_products',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/products','refresh');
        else :
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/products', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('product_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/products', 'refresh');
		}
		// Product Revision Update
		$this->ProjectModel->ProductRevisionUpdate($id,'deleted');
        $result = $this->FunctionModel->Delete('vidiem_products',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/products','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/products', 'refresh');
        endif;
    }

    public function AjaxSingleView(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
    	}
    	$info=$this->ProjectModel->ProductInfo($id);
    	$return['modal_title']='View Product';
    	$return['modal_content']='';
    	
    		$return['modal_content'].='<div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">Category</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['category'].'</label>
                  </div>
                </div>
            </div>';
            if(!empty($info['sub_category'])){
            $return['modal_content'].='<div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">Sub Category</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['sub_category'].'</label>
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
                  <label class="col-sm-3 control-label">Modal No.</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['modal_no'].'</label>
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
                  <label class="col-sm-3 control-label">Short Description</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['short_description'].'</label>
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
                  <label class="col-sm-3 control-label">Warranty</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['warranty'].'</label>
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
                  <label class="col-sm-3 control-label">Out of Stock</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.($info['outofstock']=='1'?'YES':'-').'</label>
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
                 
               
                 	$return['modal_content'].='<h4 class="box-title">Price Information</h4>
					 <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Price</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.$info['price'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Old Price</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.$info['old_price'].'</label>
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
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label"></label>
                  <div class="col-sm-8">
                    <label class="control-label"><a href="'.base_url('Admin/products/edit/'.$info['id']).'" class="btn btn-primary" data-toggle="tooltip" data-placement="left"  data-original-title="Edit"><span class="fa fa-edit"> &nbsp;Edit</span></a></label>
                  </div>
                </div>
                </div>
                ';
    	echo json_encode($return);
    	exit;
	}
	
	public function AjaxSingleViewRevision(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
    	}
    	$info=$this->FunctionModel->Select_Row('vidiem_products_revision',['id'=>$id]);
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
			</div>
			
			<div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">Category</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['cat_name'].'</label>
                  </div>
                </div>
            </div>';
            if(!empty($info['sub_category'])){
            $return['modal_content'].='<div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">Sub Category</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['sub_cat_name'].'</label>
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
                  <label class="col-sm-3 control-label">Modal No.</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['modal_no'].'</label>
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
                  <label class="col-sm-3 control-label">Short Description</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['short_description'].'</label>
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
                  <label class="col-sm-3 control-label">Warranty</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['warranty'].'</label>
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
                  <label class="col-sm-3 control-label">Out of Stock</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.($info['outofstock']=='1'?'YES':'-').'</label>
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
                 
               
                 	$return['modal_content'].='<h4 class="box-title">Price Information</h4>
					 <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Price</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.$info['price'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Old Price</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.$info['old_price'].'</label>
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

    public function AjaxSubCategory(){
    	$id=$this->input->post('id');
    	$sub_cat=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('status'=>1,'parent_id'=>$id));
    	echo '<option value="">Select Sub Category</option>';
    	if(!empty($sub_cat)){
    		foreach ($sub_cat as $info) {
    			echo '<option value="'.$info['id'].'">'.$info['name'].'</option>';
    		}
    	}
    	exit;
    }

    // Product Gallery

    public function image($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
    	}
    	$data['id']=$id;
    	$data['name']=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_product_images',array('parent_id'=>$id));
		$this->load->view('Backend/product-image-view',$data);
    }
    
    public function add_image($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
    	}
    	$data['id']=$id;
    	$data['name']=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$id));
    	$this->form_validation->set_rules('name','Name','required');
    	$this->form_validation->set_rules('image','Image','callback_image_upload');
    	$this->form_validation->set_rules('order_no','Order No','required');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'parent_id'=>$id,
					'name'=>$this->input->post('name'),
					'image'=>$this->upload_data['file']['file_name'],
					'classname'=>$this->input->post('classname'),
					'order_no'=>$this->input->post('order_no'),
					'status' =>'1',
					'created'=>date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_product_images');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Product Images Added Successfully.");
				    redirect('Admin/products/image/'.$id,'refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/products/add_image/'.$id, 'refresh');	
				}
				}
		   $this->load->view('Backend/product-image-add',@$data);	
    }

    public function image_edit($id = NULL) {
		$edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
		}
         $data['id']=$this->FunctionModel->Select_Field('parent_id','vidiem_product_images',array('id'=>$edit_id));
         $data['name']=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$id));
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('image','Image','callback_edit_content_image_upload');
    	$this->form_validation->set_rules('order_no','Order No','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'name'=>$this->input->post('name'),
					'image'=>$this->upload_data['file']['file_name'],
					'classname'=>$this->input->post('classname'),
					'order_no'=>$this->input->post('order_no'),
					'modified'=>date('Y-m-d H:i:s')
				);
		  $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_product_images',array('id'=>$edit_id));
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_product_images',array('id'=>$edit_id));
			if ($result == 1) :
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Webinar Image Updated Successfully.");
		    	redirect('Admin/products/image/'.$parent_id,'refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/products/image_edit/'.$edit_id, 'refresh');	
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_product_images',array('id'=>$edit_id));	
		   $this->load->view('Backend/product-image-edit',$data);	
    }

    function edit_content_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/images';
		if (!is_dir($upload_dir)) {
		     mkdir($upload_dir);
		}	
		$config['upload_path']   = $upload_dir;
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_product_images',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }

   public function image_status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/products', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_product_images',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_product_images',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/products/image/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/products/image/'.$parent_id, 'refresh');	
        endif;
    }
	
	public function image_delete($id = NULL) {
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/products', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_product_images',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_product_images',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/products/image/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/products/image/'.$parent_id, 'refresh');	
        endif;
    }
	
    // Product Video Start

    public function video($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
    	}
    	$data['id']=$id;
    	$data['name']=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_product_video',array('parent_id'=>$id));
		$this->load->view('Backend/product-video-view',$data);
    }

    public function add_video($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
    	}
    	$data['id']=$id; 
    	$data['name']=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$id));
    	$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('videourl','Video URL','required');
    	$this->form_validation->set_rules('image','Image','callback_image_upload');
    	$this->form_validation->set_rules('order_no','Order No','required');
			 if (!$this->form_validation->run() == FALSE) {
				 $url=$this->input->post('videourl');
                 list($tmp,$videoid)=explode('youtube.com/watch?v=',$url);
			   $InsertData=array(
					'parent_id'=>$id,
					'name'=>$this->input->post('name'),
					'video_url'=>$videoid,
					'image'=>$this->upload_data['file']['file_name'],
					'order_no'=>$this->input->post('order_no'),
					'status' =>'1',
					'created'=>date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_product_video');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Product Video Added Successfully.");
				    redirect('Admin/products/video/'.$id,'refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/products/add_video/'.$id, 'refresh');	
				}
				}
		   $this->load->view('Backend/product-video-add',@$data);	
    }

    public function video_edit($id = NULL) {
		$edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
		}
         $data['id']=$this->FunctionModel->Select_Field('parent_id','vidiem_product_video',array('id'=>$edit_id));
         $data['name']=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$id));
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('videourl','Video URL','required');
		$this->form_validation->set_rules('image','Image','callback_edit_content_image_upload');
    	$this->form_validation->set_rules('order_no','Order No','required');

		  if (!$this->form_validation->run() == FALSE) {
			  
			  $url=$this->input->post('videourl');
                 list($tmp,$videoid)=explode('youtube.com/watch?v=',$url);
			   $UpdateData=array(
					'name'=>$this->input->post('name'),
					'video_url'=>$videoid,
					'image'=>$this->upload_data['file']['file_name'],
					'order_no'=>$this->input->post('order_no'),
					'status' =>'1',
					'created'=>date('Y-m-d H:i:s')
				);
		  $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_product_video',array('id'=>$edit_id));
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_product_video',array('id'=>$edit_id));
			if ($result == 1) :
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Webinar Video Updated Successfully.");
		    	redirect('Admin/products/video/'.$parent_id,'refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/products/video_edit/'.$edit_id, 'refresh');	
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_product_video',array('id'=>$edit_id));	
		   $this->load->view('Backend/product-video-edit',$data);	
    }

	public function video_status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/products', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_product_video',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_product_video',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/products/video/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/products/video/'.$parent_id, 'refresh');	
        endif;
    }
	
	public function video_delete($id = NULL) {
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/products', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_product_video',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_product_video',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/products/video/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/products/video/'.$parent_id, 'refresh');	
        endif;
    }	
	
	// Product Video End

    // Ajax Product Feautres
    public function AjaxFeautres(){
    	$id=$this->input->post('id');
    	$cat_id=$this->FunctionModel->Select_Field('cat_id','vidiem_products',array('id'=>$id));
    	$this->db->select('f.id,f.name,pf.value,pf.id as pf_id');
    	$this->db->join('vidiem_product_features pf','f.id=pf.feature_id AND pf.product_id='.$id.'','left');
    	$query=$this->db->get_where('vidiem_features f',array('parent_id'=>$cat_id));
    	$features=$query->result_array();
    	// echo $this->db->last_query(); exit;

    	echo '<form class="form-horizontal feautre_form"><table class="table">
    		   <input type="hidden" name="id" value="'.$id.'">
    		   <thead><tr><th>S.No.</th><th>Name</th><th>Value</th></tr></thead><tbody class="feature_body">';
    	if(!empty($features)){ $x=1;
    		foreach ($features as $info) {
    			echo '<tr><td>'.$x.'<input type="hidden" name="feature_id[]" value="'.$info['id'].'">
							<input type="hidden" name="product_feature_id[]" value="'.$info['pf_id'].'">
    			        </td>
						<td><label>'.$info['name'].'</label></td>
						<td><input type="text" name="value[]" class="form-control" value="'.$info['value'].'"></td></tr>';
    		$x++;} }
    	echo '</tbody>
				<tfoot><tr><td></td><td><button type="submit" class="btn btn-info col-sm-6 pro_feautre_submit">Update</button></td><td></td></tfoot>
    	      </table></form>';
    	 exit;	    
    } 

    public function UpdateProductFeautres(){
    	$id=$this->input->post('id');
    	$feature_id=$this->input->post('feature_id');
    	$pf_id=$this->input->post('product_feature_id');
    	$value=$this->input->post('value');
    	if(!empty($feature_id)){ $x=0;
    		foreach ($feature_id as $info) {
    			if(!empty($pf_id[$x])){
    				$UpdateData=array(
    					'value'=>$value[$x],
    					'modified'=>date('Y-m-d H:i:s')
    				);
    				$this->FunctionModel->Update($UpdateData,'vidiem_product_features',array('id'=>$pf_id[$x]));
    			}
    			else{
    				$InsertData=array(
    					'feature_id'=>$info,
    					'product_id'=>$id,
    					'value'=>$value[$x],
    					'created'=>date('Y-m-d H:i:s')
    				);
    				$this->FunctionModel->Insert($InsertData,'vidiem_product_features');
    			}
    			$x++;
    		}
    	}

    	$cat_id=$this->FunctionModel->Select_Field('cat_id','vidiem_products',array('id'=>$id));
    	$this->db->select('f.id,f.name,pf.value,pf.id as pf_id');
    	$this->db->join('vidiem_product_features pf','f.id=pf.feature_id AND pf.product_id='.$id.'','left');
    	$query=$this->db->get_where('vidiem_features f',array('parent_id'=>$cat_id));
    	$features=$query->result_array();

    	echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-check"></i> Alert!</h4>
      Product Features Successfully Updated.    </div>
    	<form class="form-horizontal feautre_form"><table class="table">
    		   <input type="hidden" name="id" value="'.$id.'">
    		   <thead><tr><th>S.No.</th><th>Name</th><th>Value</th></tr></thead><tbody class="feature_body">';
    	if(!empty($features)){ $x=1;
    		foreach ($features as $info) {
    			echo '<tr><td>'.$x.'<input type="hidden" name="feature_id[]" value="'.$info['id'].'">
							<input type="hidden" name="product_feature_id[]" value="'.$info['pf_id'].'">
    			        </td>
						<td><label>'.$info['name'].'</label></td>
						<td><input type="text" name="value[]" class="form-control" value="'.$info['value'].'"></td></tr>';
    		$x++;} }
    	echo '</tbody>
				<tfoot><tr><td></td><td><button type="submit" class="btn btn-info col-sm-6 pro_feautre_submit">Update</button></td><td></td></tfoot>
    	      </table></form>';	    
    	exit;

    }

    public function key_feautres($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
    	}
    	$data['id']=$id;
    	$data['name']=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_product_key_feautures',array('parent_id'=>$id));
		$this->load->view('Backend/product-key-feautures-view',$data);
    }
    
    public function add_key_feautres($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
    	}
    	$data['id']=$id;
    	$data['name']=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$id));
		$data['position']=$this->FunctionModel->Select('vidiem_keyfeatureposition',array('status'=>1));
    	$this->form_validation->set_rules('name','Name','');
    	$this->form_validation->set_rules('image','Image','callback_image_upload');
		$this->form_validation->set_rules('productkeyfeature','Product Key Feature','required');
		$this->form_validation->set_rules('position','Position','required');
    	$this->form_validation->set_rules('order_no','Order No','required');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'parent_id'=> $id,
					'name'     => $this->input->post('name'),
					'image'    => $this->upload_data['file']['file_name'],
					'content'  => $this->input->post('content'),
					'productkeyfeature' => $this->input->post('productkeyfeature'),
					'position' => $this->input->post('position'),
					'imageposition' => $this->input->post('imageposition'),
					'order_no' => $this->input->post('order_no'),
					'status'   => '1',
					'created'  => date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_product_key_feautures');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Product Images Added Successfully.");
				    redirect('Admin/products/key_feautres/'.$id,'refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/products/add_key_feautres/'.$id, 'refresh');	
				}
				}
		   $this->load->view('Backend/product-key-feautures-add',@$data);	
    }

    public function key_feautres_edit($id = NULL) {
		$edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/products');
		}
         $data['id']=$this->FunctionModel->Select_Field('parent_id','vidiem_product_key_feautures',array('id'=>$edit_id));
         $data['name']=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$id));
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('name','Name','');
		$this->form_validation->set_rules('image','Image','callback_feautre_image_upload');
		$this->form_validation->set_rules('productkeyfeature','Product Key Feature','required');
		$this->form_validation->set_rules('position','Position','required');
    	$this->form_validation->set_rules('order_no','Order No','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'name'    => $this->input->post('name'),
					'image'   => $this->upload_data['file']['file_name'],
					'content' => $this->input->post('content'),
					'productkeyfeature' => $this->input->post('productkeyfeature'),
					'position' => $this->input->post('position'),
					'imageposition' => $this->input->post('imageposition'),
					'order_no'=> $this->input->post('order_no'),
					'modified'=> date('Y-m-d H:i:s')
				);
		  $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_product_key_feautures',array('id'=>$edit_id));
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_product_key_feautures',array('id'=>$edit_id));
		  
			if ($result == 1) :
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Webinar Image Updated Successfully.");
		    	redirect('Admin/products/key_feautres/'.$parent_id,'refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/products/key_feautres_edit/'.$edit_id, 'refresh');	
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_product_key_feautures',array('id'=>$edit_id));
			$data['position']=$this->FunctionModel->Select('vidiem_keyfeatureposition',array('status'=>1));			
		   $this->load->view('Backend/product-key-feautures-edit',$data);	
    }

    function feautre_image_upload(){
	  if($_FILES['image']['size'] != 0){
		$upload_dir = './uploads/images';
		if (!is_dir($upload_dir)) {
		     mkdir($upload_dir);
		}	
		$config['upload_path']   = $upload_dir;
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['file_name']     = 'image_'.substr(md5(rand()),0,10);
		$config['overwrite']     = false;
		$config['max_size']	 = '5120';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('image')){
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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_product_key_feautures',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }

   public function key_feautres_status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/products', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_product_key_feautures',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_product_key_feautures',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/products/key_feautres/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/products/key_feautres/'.$parent_id, 'refresh');	
        endif;
    }
	
	public function key_feautres_delete($id = NULL) {
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/products', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_product_key_feautures',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_product_key_feautures',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/products/key_feautres/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/products/key_feautres/'.$parent_id, 'refresh');	
        endif;
    }

     public function AjaxKeyNotes(){
    	$id=$this->input->post('id');
    	$features=$this->FunctionModel->Select_Fields('id,name,content,order_no','vidiem_product_keynotes',array('parent_id'=>$id));
    	echo '<form class="form-horizontal feautre_form"><table class="table">
    			<input type="hidden" name="id" value="'.$id.'">
    		   <thead><tr><th>S.No.</th><th>Name</th><th>Content</th><th class="col-xs-1">Order No.</th><th>Option</th></tr></thead><tbody class="feature_body">';
    	if(!empty($features)){ $x=1;
    		foreach ($features as $info) {
    			echo '<tr><td>'.$x.'<input type="hidden" name="hidden_id[]" value="'.$info['id'].'"></td>
						<td><input type="text" name="name[]" class="form-control" value="'.$info['name'].'"></td>
						<td><textarea class="form-control" name="content[]">'.$info['content'].'</textarea></td>
						<td><input type="text" name="order_no[]" class="form-control" value="'.$info['order_no'].'"></td>
						<td><a href="javascript:void(0);" data-id="'.$info['id'].'" class="btn btn-danger remove_keynotes"><i class="fa fa-times"></i></a></td>';
    		$x++;} }
    	echo '<tr><td><input type="hidden" name="hidden_id[]" value="0"></td>
						<td><input type="text" name="name[]" class="form-control" value=""></td>
						<td><textarea class="form-control" name="content[]"></textarea></td>
						<td><input type="text" name="order_no[]" class="form-control" value=""></td>
						<td><a href="javascript:void(0);" class="btn btn-danger remove_feautre_empty"><i class="fa fa-times"></i></a></td>';	   
    	echo '</tbody>
				<tfoot><tr><td></td><td><button type="submit" class="btn btn-info col-sm-6 keynotes_submit">Update</button></td><td></td><td><a href="javascript:void(0);" class="btn btn-primary add_keynotes_trigger">Add <i class="fa fa-plus"></i></a></td></tfoot>
    	      </table></form>';	    
    	exit;
    }

    public function delete_keynotes(){
    	$id=$this->input->post('id');
    	$this->FunctionModel->Delete('vidiem_product_keynotes',array('id'=>$id));
    	echo '1'; exit;
    }

    public function updateKeyNotes(){
    	$id=$this->input->post('id');
    	$hidden_id=$this->input->post('hidden_id');
    	$name=$this->input->post('name');
    	$content=$this->input->post('content');
    	$order_no=$this->input->post('order_no');
    	if(!empty($hidden_id)){ $x=0;
    		foreach ($hidden_id as $info) {
    			
    			if(!empty($name[$x])){
    			    $image='';
    			if($name[$x]=='Safe'){$image='safe_icon.png';}
    				elseif($name[$x]=='Reliable'){$image='relaiable_icon.png';}
    					elseif($name[$x]=='Ergonomic'){$image='ergnomic_icon.png';}
    						elseif($name[$x]=='Efficient'){$image='efficient_icon.png';}
    			if($info==0){
    				$InsertData=array(
    					'parent_id'=>$id,
    					'name'=>$name[$x],
    					'image'=>$image,
    					'content'=>$content[$x],
    					'order_no'=>$order_no[$x],
    					'status'=>1,
    					'created'=>date('Y-m-d H:i:s')
    				);
    				$this->FunctionModel->Insert($InsertData,'vidiem_product_keynotes');
    			}
    			else{
    				$UpdateData=array(
    					'parent_id'=>$id,
    					'name'=>$name[$x],
    					'image'=>$image,
    					'content'=>$content[$x],
    					'order_no'=>$order_no[$x],
    					'modified'=>date('Y-m-d H:i:s')
    				);
    				$this->FunctionModel->Update($UpdateData,'vidiem_product_keynotes',array('id'=>$info));
    			}
    		  }	
    		$x++; }
    	}
    	$features=$this->FunctionModel->Select_Fields('id,name,content,order_no','vidiem_product_keynotes',array('parent_id'=>$id));
    	echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-check"></i> Alert!</h4>
      Category Features Successfully Updated.    </div>
    	<form class="form-horizontal feautre_form"><table class="table">
    			<input type="hidden" name="id" value="'.$id.'">
    		   <thead><tr><th>S.No.</th><th>Name</th><th>Content</th><th class="col-xs-1">Order No.</th><th>Option</th></tr></thead><tbody class="feature_body">';
    	if(!empty($features)){ $x=1;
    		foreach ($features as $info) {
    			echo '<tr><td>'.$x.'<input type="hidden" name="hidden_id[]" value="'.$info['id'].'"></td>
						<td><input type="text" name="name[]" class="form-control" value="'.$info['name'].'"></td>
						<td><textarea class="form-control" name="content[]">'.$info['content'].'</textarea></td>
						<td><input type="text" name="order_no[]" class="form-control" value="'.$info['order_no'].'"></td>
						<td><a href="javascript:void(0);" data-id="'.$info['id'].'" class="btn btn-danger remove_keynotes"><i class="fa fa-times"></i></a></td>';
    		$x++;} }
    	echo '<tr><td><input type="hidden" name="hidden_id[]" value="0"></td>
						<td><input type="text" name="name[]" class="form-control" value=""></td>
						<td><textarea class="form-control" name="content[]"></textarea></td>
						<td><input type="text" name="order_no[]" class="form-control" value=""></td>
						<td><a href="javascript:void(0);" class="btn btn-danger remove_feautre_empty"><i class="fa fa-times"></i></a></td>';	   
    	echo '</tbody>
				<tfoot><tr><td></td><td><button type="submit" class="btn btn-info col-sm-6 keynotes_submit">Update</button></td><td></td><td><a href="javascript:void(0);" class="btn btn-primary add_keynotes_trigger">Add <i class="fa fa-plus"></i></a></td></tfoot>
    	      </table></form>';	    
    	exit;
    }

     // Filter Functionality
    public function AjaxFilters(){
    	$id=$this->input->post('id');
    	$cat_id=$this->FunctionModel->Select_Field('cat_id','vidiem_products',array('id'=>$id));
    	$this->db->select('f.name,cf.id,filter_id');
    	$this->db->join('vidiem_filters f','f.id=cf.filter_id');
    	$query=$this->db->get_where('vidiem_category_filters cf',array('parent_id'=>$cat_id));
    	$filters=$query->result_array();
    	echo '<form class="form-horizontal pro_filter_form"><table class="table">
    			<input type="hidden" name="id" value="'.$id.'">
    		   <thead><tr><th>S.No.</th><th>Filter</th><th>Value</th></tr></thead><tbody class="feature_body">';
    	if(!empty($filters)){ $x=1;
    		foreach ($filters as $info) {
    			echo '<tr><td>'.$x.'<input type="hidden" name="filter_id[]" value="'.$info['id'].'"></td>
						<td>'.$info['name'].'</td><td>
						<select name="value_id[]" class="form-control">';
						$filter_item=$this->FunctionModel->Select_Fields('id,name','vidiem_filter_option',array('parent_id'=>$info['filter_id']));
						$val=$this->FunctionModel->Select_Field('value_id','vidiem_product_filters',array('parent_id'=>$id,'cat_filter_id'=>$info['id']));
						if(!empty($filter_item)){
							foreach ($filter_item as $tmp) {
								echo '<option value="'.$tmp['id'].'" '.($tmp['id']==$val?'selected':'').'>'.$tmp['name'].'</option>';
							}
						}
					echo '</select>
						</td><tr>';
    		$x++;} }
    		   
    	echo '</tbody>
				<tfoot><tr><td></td><td><button type="submit" class="btn btn-info col-sm-6">Update</button></td><td></td></tfoot>
    	      </table></form>';	    
    	exit;
    }

    public function AjaxProductFilter(){
    	$product_id=$this->input->post('id');
    	$filter_id=$this->input->post('filter_id');
    	$value_id=$this->input->post('value_id');
    	if(!empty($filter_id)){ $x=0;
    		foreach ($filter_id as $info) {
    			$count=$this->FunctionModel->Row_Count('vidiem_product_filters',array('parent_id'=>$product_id,'cat_filter_id'=>$info));
    			if($count==0){
    				$InsertData=array(
    					'parent_id'=>$product_id,
    					'cat_filter_id'=>$info,
    					'value_id'=>$value_id[$x],
    					'created'=>date('Y-m-d H:i:s')
    				);
    				$this->FunctionModel->Insert($InsertData,'vidiem_product_filters');
    			}
    			else{
    				$UpdateData=array(
    					'value_id'=>$value_id[$x],
    					'modified'=>date('Y-m-d H:i:s')
    				);
    				$this->FunctionModel->Update($UpdateData,'vidiem_product_filters',array('parent_id'=>$product_id,'cat_filter_id'=>$info));
    			}
    			$x++;
    		}
    	}


    	$id=$this->input->post('id');
    	$cat_id=$this->FunctionModel->Select_Field('cat_id','vidiem_products',array('id'=>$id));
    	$this->db->select('f.name,cf.id,filter_id');
    	$this->db->join('vidiem_filters f','f.id=cf.filter_id');
    	$query=$this->db->get_where('vidiem_category_filters cf',array('parent_id'=>$cat_id));
    	$filters=$query->result_array();
    	echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-check"></i> Alert!</h4>
      Product Filters Successfully Updated.    </div>
    	<form class="form-horizontal pro_filter_form"><table class="table">
    			<input type="hidden" name="id" value="'.$id.'">
    		   <thead><tr><th>S.No.</th><th>Filter</th><th>Value</th></tr></thead><tbody class="feature_body">';
    	if(!empty($filters)){ $x=1;
    		foreach ($filters as $info) {
    			echo '<tr><td>'.$x.'<input type="hidden" name="filter_id[]" value="'.$info['id'].'"></td>
						<td>'.$info['name'].'</td><td>
						<select name="value_id[]" class="form-control">';
						$filter_item=$this->FunctionModel->Select_Fields('id,name','vidiem_filter_option',array('parent_id'=>$info['filter_id']));
						$val=$this->FunctionModel->Select_Field('value_id','vidiem_product_filters',array('parent_id'=>$id,'cat_filter_id'=>$info['id']));
						if(!empty($filter_item)){
							foreach ($filter_item as $tmp) {
								echo '<option value="'.$tmp['id'].'" '.($tmp['id']==$val?'selected':'').'>'.$tmp['name'].'</option>';
							}
						}
					echo '</select>
						</td><tr>';
    		$x++;} }
    		   
    	echo '</tbody>
				<tfoot><tr><td></td><td><button type="submit" class="btn btn-info col-sm-6">Update</button></td><td></td></tfoot>
    	      </table></form>';	    
    	exit;
	}
	

	// Revison Master Functionality
	public function revisions(){
		$data['DataResult']=$this->ProjectModel->deletedProductList();
		$this->load->view('Backend/product-revision-view',$data);
	}

	public function AjaxProductRevisionList(){
		$id=$this->input->post('id');
		$data=$this->FunctionModel->Select_Fields('id,rev_type,user_name,rev_time','vidiem_products_revision',['rev_parent_id'=>$id],'id','DESC');
		$return['modal_title']='Product Revision';
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
						<td><a href="javascript:void(0);" class="btn bg-navy revision_product_view" data-id="'.$info['id'].'" data-toggle="tooltip" data-placement="left" data-original-title="view"><span class="fa fa-eye"></span></a></td>
						</tr>';
						$i++;
					}
				}
		echo json_encode($return); exit;	
    	
	}

}