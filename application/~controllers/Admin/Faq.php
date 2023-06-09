<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {
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
	    if(hasPermission('faq_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
		$data['DataResult']=$this->FunctionModel->Select('vidiem_faq');
		$this->load->view('Backend/faq-view',$data);
    }

	public function add() {
	    if(hasPermission('faq_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
	    $this->form_validation->set_rules('title','Title','required');
		 if (!$this->form_validation->run() == FALSE) {
		   $InsertData=array(
				'title' => $this->input->post('title'),
				'status'   => '1',
				'created'  => date('Y-m-d H:i:s')
			);
	         $result=$this->FunctionModel->Insert($InsertData,'vidiem_faq');
			if($result >= 1){
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "FAQ Added Successfully.");
				redirect('Admin/faq','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
				redirect('Admin/faq/add', 'refresh');
			}
		}
	   $this->load->view('Backend/faq-add',@$data);
    }

	public function edit($id = NULL) {
	    if(hasPermission('faq_update') != true){
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
			redirect('Admin/faq', 'refresh');
		}
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		 $this->form_validation->set_rules('title','Title','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'title' => $this->input->post('title'),
					'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_faq',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "FAQ Updated Successfully.");
				redirect('Admin/faq','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/faq/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_faq',array('id'=>$edit_id));
		   $this->load->view('Backend/faq-edit',$data);
    }

	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/faq', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_faq',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/faq','refresh');
        else :
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/faq', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('faq_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/faq', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_faq',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/faq','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/faq', 'refresh');
        endif;
    }

    public function AjaxSingleView(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/faq');
    	}
    	$info=$this->FunctionModel->Select_Row('stock_faq',array('id'=>$id));
    	$return['modal_title']='View FAQs';

    	$return['modal_content']='
				<div class="row">
    			<div class="form-group">
                  <label class="col-sm-3 control-label">Client Name</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['client_name'].'</label>
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
                    <label class="control-label"><a href="'.base_url('Admin/faq/edit/'.$info['id']).'" class="btn btn-primary" data-toggle="tooltip" data-placement="left"  data-original-title="Edit"><span class="fa fa-edit"> &nbsp;Edit</span></a></label>
                  </div>
                </div>
                </div>
                ';
    	echo json_encode($return);
    	exit;
    }
    public function faqcat($id=NULL){
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/faq');
    	}
    	$data['id']=$id;
    	$data['title']=$this->FunctionModel->Select_Field('title','vidiem_faq',array('id'=>$id));
    	$data['DataResult']=$this->FunctionModel->Select('vidiem_faq_category',array('parent_id'=>$id));
		$this->load->view('Backend/faq-cat-view',$data);
    }    
    public function faqadd($id=NULL) {
	    if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/faq');
    	}
    	$data['id']=$id;
    	$data['title']=$this->FunctionModel->Select_Field('title','vidiem_faq',array('id'=>$id));
    	$this->form_validation->set_rules('question','Question','required');
		$this->form_validation->set_rules('content','Answer','required|min_length[36]|max_length[750]');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
				 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
			   	'parent_id'=>$id,
				'question' => $this->input->post('question'),
				'content'  => $this->input->post('content'),
				'order_no' => $this->input->post('order_no'),
				'status'   => '1',
				'created'  => date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_faq_category');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Media Videos Added Successfully.");
				    redirect('Admin/faq/faqcat/'.$id,'refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
	                redirect('Admin/faq/faqadd/'.$id, 'refresh');	
				}
				}
		   $this->load->view('Backend/faq-cat-add',@$data);	
    }
    public function faqedit($id = NULL) {
    $edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
		if(empty($edit_id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/faq');
		}
         $data['id']=$this->FunctionModel->Select_Field('parent_id','vidiem_faq_category',array('id'=>$edit_id));
         $data['title']=$this->FunctionModel->Select_Field('title','vidiem_faq',array('id'=>$id));
	     $this->form_validation->set_rules('hidden_id', 'ID', 'required');
		 $this->form_validation->set_rules('question','Question','required');
		$this->form_validation->set_rules('content','Answer','required|min_length[36]|max_length[750]');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
	
		  if (!$this->form_validation->run() == FALSE) {
          $UpdateData=array(
					'question' => $this->input->post('question'),
					'content'  => $this->input->post('content'),
					'order_no' => $this->input->post('order_no'),
					'modified' => date('Y-m-d H:i:s')
				);
		  $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_faq_category',array('id'=>$edit_id));
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_faq_category',array('id'=>$edit_id));
			if ($result == 1) :
            	$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Faq Updated Successfully.");
		    	redirect('Admin/faq/faqcat/'.$parent_id,'refresh');
            else :
          		$this->session->set_flashdata('class', "alert-danger");
			    $this->session->set_flashdata('icon', "fa-warning");
			    $this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/faq/faqedit/'.$edit_id, 'refresh');	
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_faq_category',array('id'=>$edit_id));	
		   $this->load->view('Backend/faq-cat-edit',$data);	
    }
    public function faqstatus($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/faq', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_faq_category',array('id'=>$id));
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_faq_category',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/faq/faqcat/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/faq/faqcat/'.$parent_id, 'refresh');	
        endif;
    }
    public function faqdelete($id = NULL) {
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");	 
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
			redirect('Admin/faq', 'refresh');
		}
        $parent_id=$this->FunctionModel->Select_Field('parent_id','vidiem_faq_category',array('id'=>$id));
        $result = $this->FunctionModel->Delete('vidiem_faq_category',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/faq/faqcat/'.$parent_id,'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/faq/faqcat/'.$parent_id, 'refresh');	
        endif;
    }


}