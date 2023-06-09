<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filters extends CI_Controller {
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
	    if(hasPermission('filter_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->FunctionModel->Select('vidiem_filters');
		$this->load->view('Backend/filters-view',$data);
    }

	public function add() {
	    if(hasPermission('filter_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$this->form_validation->set_rules('name','Filter Category Name','required');
		 if (!$this->form_validation->run() == FALSE) {
		   $InsertData=array(
				'name'   => $this->input->post('name'),
				'status' => '1',
				'created'=> date('Y-m-d H:i:s')
			);
	         $result=$this->FunctionModel->Insert($InsertData,'vidiem_filters');
			if($result >= 1){
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Product Category Added Successfully.");
				redirect('Admin/filters','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
				redirect('Admin/filters/add', 'refresh');
			}
		}
	   $this->load->view('Backend/filters-add',@$data);
    }

	public function edit($id = NULL) {
	    if(hasPermission('filter_update') != true){
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
			redirect('Admin/filters', 'refresh');
		}
		$this->form_validation->set_rules('name','Filter Category Name','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
				'name'     => $this->input->post('name'),
				'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_filters',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Webinar Updated Successfully.");
				redirect('Admin/filters','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/filters/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_filters',array('id'=>$edit_id));
		   $this->load->view('Backend/filters-edit',$data);
    }

	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/filters', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_filters',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/filters','refresh');
        else :
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/filters', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('filter_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/filters', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_filters',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/filters','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/filters', 'refresh');
        endif;
    }

    public function AjaxFiltersItem(){
      $id=$this->input->post('id');
      $features=$this->FunctionModel->Select_Fields('id,name','vidiem_filter_option',array('parent_id'=>$id));
      echo '<form class="form-horizontal feautre_form"><table class="table">
          <input type="hidden" name="id" value="'.$id.'">
           <thead><tr><th>S.No.</th><th>Name</th><th>Option</th></tr></thead><tbody class="feature_body">';
      if(!empty($features)){ $x=1;
        foreach ($features as $info) {
          echo '<tr><td>'.$x.'<input type="hidden" name="hidden_id[]" value="'.$info['id'].'"></td>
            <td><input type="text" name="name[]" class="form-control" value="'.$info['name'].'"></td>
            <td><a href="javascript:void(0);" data-id="'.$info['id'].'" class="btn btn-danger remove_filter"><i class="fa fa-times"></i></a></td>';
        $x++;} }
      echo '<tr><td><input type="hidden" name="hidden_id[]" value="0"></td>
            <td><input type="text" name="name[]" class="form-control" value=""></td>
            <td><a href="javascript:void(0);" class="btn btn-danger remove_feautre_empty"><i class="fa fa-times"></i></a></td>';     
      echo '</tbody>
        <tfoot><tr><td></td><td><button type="submit" class="btn btn-info col-sm-6 filter_submit">Update</button></td><td><a href="javascript:void(0);" class="btn btn-primary add_filter_trigger">Add <i class="fa fa-plus"></i></a></td></tfoot>
            </table></form>';     
      exit;
    }

    public function delete_filter(){
    	$id=$this->input->post('id');
    	$this->FunctionModel->Delete('vidiem_filter_option',array('id'=>$id));
    	echo '1'; exit;
    }

    public function updateFilters(){
    	$id=$this->input->post('id');
    	$hidden_id=$this->input->post('hidden_id');
    	$name=$this->input->post('name');
    	if(!empty($hidden_id)){ $x=0;
    		foreach ($hidden_id as $info) {
    			if(!empty($name[$x])){
    			if($info==0){
    				$InsertData=array(
    					'parent_id'=>$id,
    					'name'=>$name[$x],
    					'status'=>1,
    					'created'=>date('Y-m-d H:i:s')
    				);
    				$this->FunctionModel->Insert($InsertData,'vidiem_filter_option');
    			}
    			else{
    				$UpdateData=array(
    					'parent_id'=>$id,
    					'name'=>$name[$x],
    					'modified'=>date('Y-m-d H:i:s')
    				);
    				$this->FunctionModel->Update($UpdateData,'vidiem_filter_option',array('id'=>$info));
    			}
    		  }	
    		$x++; }
    	}
    	$features=$this->FunctionModel->Select_Fields('id,name','vidiem_filter_option',array('parent_id'=>$id));
    	echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-check"></i> Alert!</h4>
      Category Features Successfully Updated.    </div>
    	<form class="form-horizontal feautre_form"><table class="table">
    			<input type="hidden" name="id" value="'.$id.'">
    		   <thead><tr><th>S.No.</th><th>Name</th><th>Option</th></tr></thead><tbody class="feature_body">';
    	if(!empty($features)){ $x=1;
    		foreach ($features as $info) {
    			echo '<tr><td>'.$x.'<input type="hidden" name="hidden_id[]" value="'.$info['id'].'"></td>
						<td><input type="text" name="name[]" class="form-control" value="'.$info['name'].'"></td>
						<td><a href="javascript:void(0);" data-id="'.$info['id'].'" class="btn btn-danger remove_feautre"><i class="fa fa-times"></i></a></td>';
    		$x++;} }
    	echo '<tr><td><input type="hidden" name="hidden_id[]" value="0"></td>
						<td><input type="text" name="name[]" class="form-control" value=""></td>
						<td><a href="javascript:void(0);" class="btn btn-danger remove_feautre_empty"><i class="fa fa-times"></i></a></td>';	   
    	echo '</tbody>
				<tfoot><tr><td></td><td><button type="submit" class="btn btn-info col-sm-6 filter_submit">Update</button></td><td><a href="javascript:void(0);" class="btn btn-primary add_feautre_trigger">Add <i class="fa fa-plus"></i></a></td></tfoot>
    	      </table></form>';	    
    	exit;
    }
    
}