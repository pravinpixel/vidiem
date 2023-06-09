<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Warranty extends CI_Controller {
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
	    if(hasPermission('warranty_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		$data['DataResult']=$this->FunctionModel->Select('vidiem_warranty');
		$this->load->view('Backend/warranty-view',$data); 
    }
 
	public function add() {
    	    if(hasPermission('warranty_add') != true){
    			$this->session->set_flashdata('class', "alert-danger");
    			$this->session->set_flashdata('icon', "fa-warning");
    			$this->session->set_flashdata('msg', "Access denied.");
    			redirect('Admin/dashboard', 'refresh');
    		}
		    $this->form_validation->set_rules('parent_category','Category Name','required');
			$this->form_validation->set_rules('content','Content','required|max_length[5000]');
		  
			$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
			 if (!$this->form_validation->run() == FALSE) {
			   $InsertData=array(
					'title'     => $this->input->post('parent_category'),
					'content'  => $this->input->post('content'),
					'order_no' => $this->input->post('order_no'),
					'status'   => '1',
					'created'  => date('Y-m-d H:i:s')
				);
		         $result=$this->FunctionModel->Insert($InsertData,'vidiem_warranty');
				if($result >= 1){
					$this->session->set_flashdata('class', "alert-success");
					$this->session->set_flashdata('icon', "fa-check");
					$this->session->set_flashdata('msg', "Testimonial Added Successfully.");
					redirect('Admin/Warranty','refresh');
				}
				else{
					$this->session->set_flashdata('class', "alert-danger");
					$this->session->set_flashdata('icon', "fa-warning");
					$this->session->set_flashdata('msg', "Something Went Wrong.");
					redirect('Admin/Warranty/add', 'refresh');
				}
			}
		  // $data['Pages']=$this->ProjectModel->Pages();
			$data['category']=$this->FunctionModel->Select('vidiem_category',array('status'=>1,'parent_id'=>0));
		   $this->load->view('Backend/warranty-add',@$data);
    }

	public function edit($id = NULL) {
	    if(hasPermission('warranty_update') != true){
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
			redirect('Admin/Warranty', 'refresh');
		}
		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
		$this->form_validation->set_rules('name','Category Name','required');
		$this->form_validation->set_rules('content','Content','required|max_length[5000]');
		$this->form_validation->set_rules('order_no','Order No.','required|numeric|greater_than[0]|max_length[3]');
		  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'title'     => $this->input->post('name'),
					'content'  => $this->input->post('content'),
					'order_no' => $this->input->post('order_no'),
					'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_warranty',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "Testimonial Updated Successfully.");
				redirect('Admin/Warranty','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/Warranty/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_warranty',array('id'=>$edit_id));
			$data['Edit_Result_category']=$this->FunctionModel->Select_Row('vidiem_category',array('id'=>$edit_id));
		  // $data['Pages']=$this->ProjectModel->Pages();
		   $this->load->view('Backend/warranty-edit',$data);
    }

	
	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/Warranty', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_warranty',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/Warranty','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/Warranty', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('warranty_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/Warranty', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_warranty',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/Warranty','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/Warranty', 'refresh');
        endif;
    }

    

}