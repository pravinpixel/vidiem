<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupen extends CI_Controller {
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
        if(hasPermission('coupen_index') != true){
    		$this->session->set_flashdata('class', "alert-danger");
    		$this->session->set_flashdata('icon', "fa-warning");
    		$this->session->set_flashdata('msg', "Access denied.");
    		redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->FunctionModel->Select('vidiem_coupon');
		$this->load->view('Backend/coupen-view',$data);
    }

	public function add() {
	    if(hasPermission('coupen_add') != true){
    		$this->session->set_flashdata('class', "alert-danger");
    		$this->session->set_flashdata('icon', "fa-warning");
    		$this->session->set_flashdata('msg', "Access denied.");
    		redirect('Admin/dashboard', 'refresh');
		} 
		$this->form_validation->set_rules('name','Coupen Name','required');
		$this->form_validation->set_rules('code','Coupen Code','required|min_length[5]|max_length[8]|is_unique[vidiem_coupon.code]');
		$this->form_validation->set_rules('type','Discount Type','required');
		$this->form_validation->set_rules('discount_value','Discount Value','required');
		$this->form_validation->set_rules('min_order','Min. Order Value','required');
		$this->form_validation->set_rules('max_discount','Max. Discount Amount','required');
		$this->form_validation->set_rules('max_usage','Max. Time Coupen Usage','required');
		$this->form_validation->set_rules('max_per_user','Max. Time Coupen Usage Per User','required');
		$this->form_validation->set_rules('start_date','Start Date','required');
		$this->form_validation->set_rules('end_date','End Date','required');
		$this->form_validation->set_message('is_unique','%s already have the same value');
		 if (!$this->form_validation->run() == FALSE) {
		   $InsertData=array(
				'name'            => $this->input->post('name'),
				'code'            => $this->input->post('code'),
				'type'            => $this->input->post('type'),
				'discount_value'  => $this->input->post('discount_value'),
				'min_order'       => $this->input->post('min_order'),
				'max_discount'    => $this->input->post('max_discount'),
				'max_usage'       => $this->input->post('max_usage'),
				'max_per_user'    => $this->input->post('max_per_user'),
				'only_first_order'=> $this->input->post('only_first_order'),
				'start_date'      => $this->input->post('start_date'),
				'end_date'        => $this->input->post('end_date'),
				'status'          => '1',
				'created'         => date('Y-m-d H:i:s')
			);
	         $result=$this->FunctionModel->Insert($InsertData,'vidiem_coupon');
			if($result >= 1){
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Product Coupen Added Successfully.");
				redirect('Admin/coupen','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
				redirect('Admin/coupen/add', 'refresh');
			}
		}
	   $this->load->view('Backend/coupen-add',@$data);
    }

	public function edit($id = NULL) {
	    if(hasPermission('coupen_update') != true){
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
			redirect('Admin/coupen', 'refresh');
		}
		$this->form_validation->set_rules('name','Coupen Name','required');
		$this->form_validation->set_rules('code','Coupen Code','required|min_length[5]|max_length[8]|callback_edit_unique');
		$this->form_validation->set_rules('type','Discount Type','required');
		$this->form_validation->set_rules('discount_value','Discount Value','required');
		$this->form_validation->set_rules('min_order','Min. Order Value','required');
		$this->form_validation->set_rules('max_discount','Max. Discount Amount','required');
		$this->form_validation->set_rules('max_usage','Max. Time Coupen Usage','required');
		$this->form_validation->set_rules('max_per_user','Max. Time Coupen Usage Per User','required');
		$this->form_validation->set_rules('start_date','Start Date','required');
		$this->form_validation->set_rules('end_date','End Date','required');
		$this->form_validation->set_message('is_unique','%s already have the same value');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
				'name'            => $this->input->post('name'),
				'code'            => $this->input->post('code'),
				'type'            => $this->input->post('type'),
				'discount_value'  => $this->input->post('discount_value'),
				'min_order'       => $this->input->post('min_order'),
				'max_discount'    => $this->input->post('max_discount'),
				'max_usage'       => $this->input->post('max_usage'),
				'max_per_user'    => $this->input->post('max_per_user'),
				'only_first_order'=> $this->input->post('only_first_order'),
				'start_date'      => $this->input->post('start_date'),
				'end_date'        => $this->input->post('end_date'),
				'modified'        => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_coupon',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Webinar Updated Successfully.");
				redirect('Admin/coupen','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/coupen/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_coupon',array('id'=>$edit_id));
		   $this->load->view('Backend/coupen-edit',$data);
    }

    function edit_unique(){
    	$id=$this->input->post('hidden_id');
    	$code=$this->input->post('code');
    	$count=$this->FunctionModel->Row_Count('vidiem_coupon',array('id !='=>$id,'code'=>$code));
    	if($count==0){return true;}
    	else{
    		$this->form_validation->set_message('edit_unique','Coupon Code Already Exist');
    		return false;
    	}
    }

	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/coupen', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_coupon',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/coupen','refresh');
        else :
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/coupen', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('coupen_delete') != true){
    		$this->session->set_flashdata('class', "alert-danger");
    		$this->session->set_flashdata('icon', "fa-warning");
    		$this->session->set_flashdata('msg', "Access denied.");
    		redirect('Admin/dashboard', 'refresh');
		} 
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/coupen', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_coupon',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/coupen','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/coupen', 'refresh');
        endif;
    }

    public function AjaxSingleView(){
    	$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/coupen');
    	}
    	$info=$this->FunctionModel->Select_Row('vidiem_coupon',array('id'=>$id));
    	$return['modal_title']='View Coupen';
    	$return['modal_content']='';
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
					<label class="col-sm-3 control-label">Coupen Code</label>
				<div class="col-sm-8">
					<label class="control-label">'.@$info['code'].'</label>
				</div>
				</div>
			</div>
             <div class="row">
				<div class="form-group">
					<label class="col-sm-3 control-label">Discount Type</label>
				<div class="col-sm-8">
					<label class="control-label">'.($info['type']==1?'Percentage %':'Fixed Amount').'</label>
				</div>
				</div>
			</div>
            <div class="row">
				<div class="form-group">
					<label class="col-sm-3 control-label">Discount Value</label>
				<div class="col-sm-8">
					<label class="control-label">'.@$info['discount_value'].'</label>
				</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label class="col-sm-3 control-label">Min. Order Value</label>
				<div class="col-sm-8">
					<label class="control-label">'.@$info['min_order'].'</label>
				</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label class="col-sm-3 control-label">Max. Discount Amount</label>
				<div class="col-sm-8">
					<label class="control-label">'.@$info['max_discount'].'</label>
				</div>
				</div>
			</div>';
                 
				$return['modal_content'].='<h4 class="box-title">Seo Information</h4>
				<div class="row">
				<div class="form-group">
					<label class="col-sm-3 control-label">Max. Time Coupen Usage</label>
				<div class="col-sm-8">
					<label class="control-label">'.@$info['max_usage'].'</label>
				</div>
				</div>
			</div>
             <div class="row">    
                <div class="form-group">
                  <label class="col-sm-3 control-label">Max. Time Coupen Usage Per User</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['max_per_user'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                 <div class="form-group">
                  <label class="col-sm-3 control-label">Only For First Order</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['only_first_order'].'</label>
                  </div>
                </div>
                 </div>
             <div class="row">    
                 <div class="form-group">
                  <label class="col-sm-3 control-label">Start Date</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['start_date'].'</label>
                  </div>
                </div>
                 </div>
                <div class="row">    
                 <div class="form-group">
                  <label class="col-sm-3 control-label">End Date</label>
                  <div class="col-sm-8">
                    <label class="control-label">'.@$info['end_date'].'</label>
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
                    <label class="control-label"><a href="'.base_url('Admin/coupen/edit/'.$info['id']).'" class="btn btn-primary" data-toggle="tooltip" data-placement="left"  data-original-title="Edit"><span class="fa fa-edit"> &nbsp;Edit</span></a></label>
                  </div>
                </div>
                </div>
                ';
    	echo json_encode($return);
    	exit;
    }
   
}