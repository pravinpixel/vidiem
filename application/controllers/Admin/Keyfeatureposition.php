<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Keyfeatureposition extends CI_Controller { 
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
	    if(hasPermission('key_feature_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->FunctionModel->Select('vidiem_keyfeatureposition');
		$this->load->view('Backend/keyfeatureposition-view',$data);
    }

	public function add() {
    	    if(hasPermission('key_feature_add') != true){
    			$this->session->set_flashdata('class', "alert-danger");
    			$this->session->set_flashdata('icon', "fa-warning");
    			$this->session->set_flashdata('msg', "Access denied.");
    			redirect('Admin/dashboard', 'refresh');
    		} 
		    $this->form_validation->set_rules('position','Position','required');
		    $this->form_validation->set_rules('columnname','Column Name','required');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'position'     => $this->input->post('position'),
					'columnname'       => $this->input->post('columnname'),
					'status'   => '1',
					'created'  => date('Y-m-d H:i:s') 
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_keyfeatureposition');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
					$this->session->set_flashdata('icon', "fa-check");
					$this->session->set_flashdata('msg', "Key Feature Position Added Successfully.");
					redirect('Admin/keyfeatureposition','refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
					redirect('Admin/keyfeatureposition/add', 'refresh');
				}
			}
		   $this->load->view('Backend/add-keyfeatureposition');
    }



	public function edit($id = NULL) {
	    if(hasPermission('key_feature_update') != true){
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
			redirect('Admin/keyfeatureposition', 'refresh');
		}
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('position','Position','required');
		$this->form_validation->set_rules('columnname','Column Name','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'position'     => $this->input->post('position'),
					'columnname'       => $this->input->post('columnname'),
					'status'   => '1',
					'created'  => date('Y-m-d H:i:s') 
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_keyfeatureposition',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Key Feature Position Updated Successfully.");
				redirect('Admin/keyfeatureposition','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/keyfeatureposition/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_keyfeatureposition',array('id'=>$edit_id));
		   //$data['Pages']=$this->ProjectModel->Pages();
		   $this->load->view('Backend/keyfeatureposition-edit',$data);
    }



	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/keyfeatureposition', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_keyfeatureposition',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/keyfeatureposition','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/keyfeatureposition', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('key_feature_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/keyfeatureposition', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_keyfeatureposition',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/keyfeatureposition','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/keyfeatureposition', 'refresh');
        endif;
    }



}