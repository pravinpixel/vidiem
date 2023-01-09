<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Role extends CI_Controller {
	function __construct() {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->model(array('Accessmodel'));
        $this->load->library('upload');
        if(!$this->session->userdata('user_logged_in')){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}
    }

	 public function index() 
     {
        if(hasPermission('role_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult'] = $this->FunctionModel->Select('vidiem_roles');
		$this->load->view('Backend/role/index',$data);
    }

    public function create()
    {
        if(hasPermission('role_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
        $this->load->view('Backend/role/create');
    }

    public function store() 
    {
        if(hasPermission('role_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
        $this->form_validation->set_rules('name','Name','required|is_unique[vidiem_roles.name]');
        if (!$this->form_validation->run() == FALSE) {
            $insertData = array(
                'name'        => $this->input->post('name'),
                'status'      => 1,
                'description' => $this->input->post('description'),
                'created_at'  => date('Y-m-d')
            );
            $result = $this->FunctionModel->Insert($insertData,'vidiem_roles');
            if($result >= 1){
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-check");
                $this->session->set_flashdata('msg', "Role Added Successfully.");
                redirect('Admin/Role','refresh');
            }
            else{
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
                redirect('Admin/Role', 'refresh');
            }
        }
        $this->load->view('Backend/role/create');
    }

    public function edit($id)
    {
        if(hasPermission('role_update') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
        $data['role']=$this->FunctionModel->Select_Row('vidiem_roles',array('id'=>$id));
        $this->load->view('Backend/role/edit', $data);
    }

    public function update($id)
    {
        if(hasPermission('role_update') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
        $this->form_validation->set_rules('name','Name','required');
        if (!$this->form_validation->run() == FALSE) {
            $UpdateData = array(
                'name'        => $this->input->post('name'),
                'status'      => 1,
                'description' => $this->input->post('description'),
                'updated_at'  => date('Y-m-d')
            );
            $result = $this->FunctionModel->Update($UpdateData,'vidiem_roles',array('id'=>$id));
            if($result >= 1){
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-check");
                $this->session->set_flashdata('msg', "Role Updated Successfully.");
                redirect('Admin/Role','refresh');
            }
            else{
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
                redirect('Admin/Role', 'refresh');
            }
        }
    }

    public function delete($id)
    {
        if(hasPermission('role_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/Role', 'refresh');
		}
        $users = $this->FunctionModel->Select_Row('vidiem_users',['role'=>$id]);
        if(!empty( $users)) {
            $this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Can not delete this role, it is mapped with some user");
			redirect('Admin/Role', 'refresh');
        }
        $result = $this->FunctionModel->Delete('vidiem_roles',array('id'=>$id));
		if ($result == 1) :
			$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/Role', 'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/Role', 'refresh');
        endif;
    }
}