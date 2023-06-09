<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seo extends CI_Controller {
    
	function __construct() {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->library('slug');
        $this->load->model(array('Accessmodel'));
        if(!$this->session->userdata('user_logged_in')){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}
    }

	 public function index() {
	    if(hasPermission('seo_index') != true){
    		$this->session->set_flashdata('class', "alert-danger");
    		$this->session->set_flashdata('icon', "fa-warning");
    		$this->session->set_flashdata('msg', "Access denied.");
    		redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->FunctionModel->Select('vidiem_seo');
		$this->load->view('Backend/seo-view',$data);
    }

	public function add() {
	    if(hasPermission('seo_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
	    $this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('meta_title','Meta_Title','required');
		$this->form_validation->set_rules('meta_description','Meta_Description','required');
		$this->form_validation->set_rules('meta_keywords','Meta_Keywords','required');
		 if (!$this->form_validation->run() == FALSE) {
		   $InsertData=array(
				'title'    => $this->input->post('title'),
				'meta_title'    => $this->input->post('meta_title'),
				'meta_description'    => $this->input->post('meta_description'),
				'meta_keywords'    => $this->input->post('meta_keywords'),
				'status'  => '1',
				'created' => date('Y-m-d H:i:s')
			);
	         $result=$this->FunctionModel->Insert($InsertData,'vidiem_seo');
			if($result >= 1){
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "SEO Added Successfully.");
				redirect('Admin/seo','refresh');
			}
			else{
				$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
				redirect('Admin/seo/add', 'refresh');
			}
		}
		 //$data['Pages']=$this->ProjectModel->Pagesevents();
	   $this->load->view('Backend/seo-add');
    }

  

	public function edit($id = NULL) {
	    if(hasPermission('seo_update') != true){
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
			redirect('Admin/seo', 'refresh');
		}
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('meta_title','Meta_Title','required');
		$this->form_validation->set_rules('meta_description','Meta_Description','required');
		$this->form_validation->set_rules('meta_keywords','Meta_Keywords','required');
			  if (!$this->form_validation->run() == FALSE) {
			   $UpdateData=array(
					'title'    => $this->input->post('title'),
				    'meta_title'    => $this->input->post('meta_title'),
				    'meta_description'    => $this->input->post('meta_description'),
				    'meta_keywords'    => $this->input->post('meta_keywords'),
				    'modified' => date('Y-m-d H:i:s')
				);
		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_seo',array('id'=>$edit_id));

			if ($result == 1) :
				$this->session->set_flashdata('class', "alert-success");
				$this->session->set_flashdata('icon', "fa-check");
				$this->session->set_flashdata('msg', "SEO Updated Successfully.");
				redirect('Admin/seo','refresh');
			else :
          		$this->session->set_flashdata('class', "alert-danger");
				$this->session->set_flashdata('icon', "fa-warning");
				$this->session->set_flashdata('msg', "Something Went Wrong.");
          		redirect('Admin/seo/edit/'.$edit_id, 'refresh');
        	endif;
			}
			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_seo',array('id'=>$edit_id));
		   $this->load->view('Backend/seo-edit',$data);
    }
	
	public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/seo', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_seo',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/seo','refresh');
        else :
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/seo', 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('seo_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/seo', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_seo',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/seo','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/seo', 'refresh');
        endif;
    }

}