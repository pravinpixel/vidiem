<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Block extends CI_Controller {
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
	    if(hasPermission('block_management_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->FunctionModel->Select('vidiem_block');
		$this->load->view('Backend/block-view',$data);
    }

	public function add() {
    	    if(hasPermission('block_management_add') != true){
    			$this->session->set_flashdata('class', "alert-danger");
    			$this->session->set_flashdata('icon', "fa-warning");
    			$this->session->set_flashdata('msg', "Access denied.");
    			redirect('Admin/dashboard', 'refresh');
    		}
		    $this->form_validation->set_rules('name','Name','required');
			//$this->form_validation->set_rules('blockslug','Blockslug','required');
		    $this->form_validation->set_rules('contents','Content','required');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'name'     => $this->input->post('name'),
					'slug'             => $this->slug->create_unique_slug($this->input->post('name'), 'vidiem_block'),
					'content'       => $this->input->post('contents'),
					'status'   => '1',
					'created'  => date('Y-m-d H:i:s') 
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_block');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
					$this->session->set_flashdata('icon', "fa-check");
					$this->session->set_flashdata('msg', "Block Added Successfully.");
					redirect('Admin/block','refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
					redirect('Admin/block/add', 'refresh');
				}
			}
		   $this->load->view('Backend/add-block');
    }



	public function edit($id = NULL) {
	    if(hasPermission('block_management_update') != true){
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
			redirect('Admin/block', 'refresh');
		}
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		 $this->form_validation->set_rules('name','Name','required');
			//$this->form_validation->set_rules('blockslug','Blockslug','required');
		    $this->form_validation->set_rules('contents','Content','required');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'name'     => $this->input->post('name'),
					'slug'             => $this->slug->create_unique_slug($this->input->post('name'), 'vidiem_block'),
					'content'       => $this->input->post('contents'),
					'status'   => '1', 
					'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_block',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Block Updated Successfully.");
				redirect('Admin/block','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/block/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_block',array('id'=>$edit_id));
		   //$data['Pages']=$this->ProjectModel->Pages();
		   $this->load->view('Backend/block-edit',$data);
    }



	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/block', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_block',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/block','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/block', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('block_management_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/block', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_block',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/block','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/block', 'refresh');
        endif;
    }



}