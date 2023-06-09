<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offers extends CI_Controller {
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
		$data['DataResult']=$this->FunctionModel->Select('vidiem_offers');
		$this->load->view('Backend/offer-view',$data);
    }

	/*public function add() {
	    $this->form_validation->set_rules('page','Page','required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('image','Image','callback_image_upload');
	//	$this->form_validation->set_rules('products[]','Product List','required');
		$data['old_products']=$this->input->post('products');
		if(empty($data['old_products'])){
			$data['old_products']=array();
		}
		 if (!$this->form_validation->run() == FALSE) {
		   $InsertData=array(
				'slug'             => $this->slug->create_unique_slug($this->input->post('name'), 'vidiem_offers'),
				'type'     => $this->input->post('page'),
				'name'             => $this->input->post('name'),
				'image'            => $this->upload_data['file']['file_name'],
				'meta_title'       => $this->input->post('meta_title'),
				'meta_description' => $this->input->post('meta_description'),
				'meta_keywords'    => $this->input->post('meta_keywords'),
				'status'           => '1',
				'created'          => date('Y-m-d H:i:s')
			);
	         $offer_id=$this->FunctionModel->Insert($InsertData,'vidiem_offers');
	         $products=$this->input->post('products');
	         $InsertData=array(
	         	'parent_id'=>$offer_id,
	         	'status'=>1,
	         	'created'=>date('Y-m-d H:i:s')
	         );
	         if(!empty($products)){
	         	foreach ($products as $info) {
	         		$InsertData['product_id']=$info;
	         		$result=$this->FunctionModel->Insert($InsertData,'vidiem_offer_products');
	         	}
	         }
			if($result >= 1){
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Offers Added Successfully.");
				redirect('Admin/offers','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
				redirect('Admin/offers/add', 'refresh');
			}
		}
		$data['Pages']=$this->ProjectModel->Pages();
	   $data['products']=$this->FunctionModel->Select_Fields('id,name','vidiem_products',array('status'=>1));
	   $this->load->view('Backend/offer-add',@$data);
    }*/
    public function add() {
		$this->form_validation->set_rules('page','Page','required');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('image','Image','callback_image_upload');
	//	$this->form_validation->set_rules('products[]','Product List','required');
		$data['old_products']=$this->input->post('products');
		if(empty($data['old_products'])){
			$data['old_products']=array();
		}
		 if (!$this->form_validation->run() == FALSE) {
		   $InsertData=array(
				'slug'             => $this->slug->create_unique_slug($this->input->post('name'), 'vidiem_offers'),
				'type'     => $this->input->post('page'),
				'name'             => $this->input->post('name'),
				'image'            => $this->upload_data['file']['file_name'],
				'meta_title'       => $this->input->post('meta_title'),
				'meta_description' => $this->input->post('meta_description'),
				'meta_keywords'    => $this->input->post('meta_keywords'),
				'status'           => '1',
				'created'          => date('Y-m-d H:i:s')
			);
	         $offer_id=$this->FunctionModel->Insert($InsertData,'vidiem_offers');
	         $products=$this->input->post('products');
	         
	         if(!empty($products)){
	         	$InsertData=array(
	         	'parent_id'=>$offer_id,
	         	// 'type'     => $this->input->post('page'),
	         	'status'=>1,
	         	'created'=>date('Y-m-d H:i:s')
	         );
	         	foreach ($products as $info) {
	         		$InsertData['product_id']=$info;
	         		$result=$this->FunctionModel->Insert($InsertData,'vidiem_offer_products');
	         	}
	         }
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Offers Added Successfully.");
				redirect('Admin/offers','refresh');
			
			
		}
	   $data['products']=$this->FunctionModel->Select_Fields('id,name','vidiem_products',array('status'=>1));
	   $data['Pages']=$this->ProjectModel->Pages();
	   $this->load->view('Backend/offer-add',@$data);
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

	public function edit($id = NULL) {
		$edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/offers', 'refresh');
		}
		$this->form_validation->set_rules('page','Page','required');
		$this->form_validation->set_rules('name','Category Name','required');
		$this->form_validation->set_rules('image','Image','callback_edit_image_upload');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
			   	'slug'             => $this->slug->create_unique_slug($this->input->post('name'), 'vidiem_offers'),
			   	'type'     => $this->input->post('page'),
				'name'             => $this->input->post('name'),
				'image'            => $this->upload_data['file']['file_name'],
				'meta_title'       => $this->input->post('meta_title'),
				'meta_description' => $this->input->post('meta_description'),
				'meta_keywords'    => $this->input->post('meta_keywords'),
				'modified'           => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_offers',array('id'=>$edit_id));
           // Product List Updates
		  $temp=$this->FunctionModel->Select_Fields('product_id','vidiem_offer_products',array('parent_id'=>$edit_id));
                 if(!empty($temp)){
                 	foreach ($temp as $info) {
                 		$old_products[]=$info['product_id'];
               }
           }

           $new_product=$this->input->post('products');
           $for_del=array_diff($old_products,$new_product);
           $new=array_diff($new_product,$old_products);
           // Delete Product
           if(!empty($for_del)){
           		$this->db->where_in('product_id',$for_del);
           		$query = $this->db->delete('vidiem_offer_products',array('parent_id'=>$edit_id));
           }
           
           if(!empty($new)){
	           	$InsertData=array(
		         	'parent_id'=>$edit_id,
		         	'status'=>1,
		         	'created'=>date('Y-m-d H:i:s')
		         );
           		foreach ($new as $info) {
	         		$InsertData['product_id']=$info;
	         		$this->FunctionModel->Insert($InsertData,'vidiem_offer_products');
           		}
           }

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Offers Updated Successfully.");
				redirect('Admin/offers','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/offers/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$post=$this->input->post('hidden_id');
			if(empty($post)){
				$temp=$this->FunctionModel->Select_Fields('product_id','vidiem_offer_products',array('parent_id'=>$edit_id));
                 if(empty($temp)){
                 	$data['old_products']=array();
                 }else{
                 	foreach ($temp as $info) {
                 		$data['old_products'][]=$info['product_id'];
                 	}
                 }
			}
			$data['Pages']=$this->ProjectModel->Pages();
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_offers',array('id'=>$edit_id));
			$data['products']=$this->FunctionModel->Select_Fields('id,name','vidiem_products',array('status'=>1));
		   $this->load->view('Backend/offer-edit',$data);
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
		$file_name=$this->FunctionModel->Select_Field('image','vidiem_offers',array('id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }

	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/offers', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_offers',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/offers','refresh');
        else :
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/offers', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/offers', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_offers',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/offers','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/offers', 'refresh');
        endif;
    }


    // Category Feauture Functionality
    
    public function product_list($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/offers');
    	}
    	$data['id']=$id;
    	$data['name']=$this->FunctionModel->Select_Field('name','vidiem_offers',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_offer_products',array('parent_id'=>$id));
		$data['DataResult']=$this->ProjectModel->OfferProductList($id);
		$this->load->view('Backend/offer-product-view',$data);
    }
	   
	
      public function product_status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/offers', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_offer_products',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_offer_products',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/offers/product_list/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/offers/product_list/'.$parent_id, 'refresh');	
        endif;
    }
	
	public function product_delete($id = NULL) {
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/offers', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_offer_products',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_offer_products',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/offers/product_list/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/offers/product_list/'.$parent_id, 'refresh');	
        endif;
    }

    
}