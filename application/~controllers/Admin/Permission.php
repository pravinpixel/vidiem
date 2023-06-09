<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permission extends CI_Controller {
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

	public function index($id) 
    {
        $data['columns'] = $this->db->list_fields('vidiem_permissions');
        unset($data['columns']['0']);
        unset($data['columns']['1']);
        $data['permission'] = $this->FunctionModel->Select_Row('vidiem_permissions',array('role_id'=>$id));
        $data['id'] = $id;
		$this->load->view('Backend/role/permission',$data);
    }
   
    public function update($id) 
    {
        $UpdateData = [];
        $inputs = $this->input->post();
        $columns = $this->db->list_fields('vidiem_permissions');
        unset($columns['0']);
        unset($columns['1']);
      
        foreach($columns as  $value) {
            $UpdateData[$value] = !isset($inputs[$value]) ? 0 : 1;
        }

        $permission_exists = $this->FunctionModel->Select_Row('vidiem_permissions',array('role_id'=>$id));

        if(empty($permission_exists)){
            $UpdateData['role_id'] = $id;
            $result = $this->FunctionModel->Insert($UpdateData,'vidiem_permissions');
        } else {
            $result = $this->FunctionModel->Update($UpdateData,'vidiem_permissions',array('role_id'=>$id));
        }
        if($result >= 1){
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Permission Updated Successfully.");
            redirect('Admin/Role','refresh');
        }
        else{
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            redirect('Admin/Role','refresh');
        }
    }
}