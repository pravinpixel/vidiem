<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {
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
	    if(hasPermission('notification_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->FunctionModel->Select('vidiem_notification');
		$this->load->view('Backend/notification-view',$data);
    }

	public function add() {
	    if(hasPermission('notification_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
	    $this->form_validation->set_rules('title','Title','required');
		 if (!$this->form_validation->run() == FALSE) {
		   $InsertData=array(
				'title' => $this->input->post('title'),
				'url' => $this->input->post('url'),
				'status'   => '1',
				'created'  => date('Y-m-d H:i:s')
			);
	         $result=$this->FunctionModel->Insert($InsertData,'vidiem_notification');
			if($result >= 1){
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Notification Added Successfully.");
				redirect('Admin/notification','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
				redirect('Admin/notification/add', 'refresh');
			}
		}
	   $this->load->view('Backend/notification-add',@$data);
    }

	public function edit($id = NULL) {
	    if(hasPermission('notification_update') != true){
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
			redirect('Admin/notification', 'refresh');
		}
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		 $this->form_validation->set_rules('title','Title','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'title' => $this->input->post('title'),
					'url' => $this->input->post('url'),
					'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_notification',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Notification Updated Successfully.");
				redirect('Admin/notification','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/notification/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_notification',array('id'=>$edit_id));
		   $this->load->view('Backend/notification-edit',$data);
    }

	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/notification', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_notification',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/notification','refresh');
        else :
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/notification', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('notification_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/notification', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_notification',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/notification','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/notification', 'refresh');
        endif;
    }

    public function AjaxSingleView(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/notification');
    	}
    	$info=$this->FunctionModel->Select_Row('stock_Notification',array('id'=>$id));
    	$return['modal_title']='View Notification';

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
                    <label class="control-label"><a href="'.base_url('Admin/notification/edit/'.$info['id']).'" class="btn btn-primary" data-toggle="tooltip" data-placement="left"  data-original-title="Edit"><span class="fa fa-edit"> &nbsp;Edit</span></a></label>
                  </div>
                </div>
                </div>
                ';
    	echo json_encode($return);
    	exit;
    }
   


}