<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
	function __construct() {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->library('pagination');
        $this->load->model(array('Accessmodel'));
         $user_role=$this->session->userdata('user_role');
        if(!$this->session->userdata('user_logged_in') || $user_role==2){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}
    }

	 public function index($start=0) {
  		if(hasPermission('user_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
  		$this->db->select('u.*,r.name as role_name');
		$this->db->join('vidiem_roles r','r.id=u.role');
		$query=$this->db->get_where('vidiem_users u');
        $data['DataResult'] = $query->result_array();
  		$this->load->view('Backend/users-view',$data);
    }

    public function add() {
        if(hasPermission('user_add') != true){
    		$this->session->set_flashdata('class', "alert-danger");
    		$this->session->set_flashdata('icon', "fa-warning");
    		$this->session->set_flashdata('msg', "Access denied.");
    		redirect('Admin/dashboard', 'refresh');
    	} 
    $this->form_validation->set_rules('name','Full Name','required');
    $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[vidiem_users.email]');
    $this->form_validation->set_rules('password','Password','required|min_length[6]|max_length[15]');
      if (!$this->form_validation->run() == FALSE) {
     
      $InsertData=array(
        'email'      => $this->input->post('email'),
        'password'   => sha1($this->input->post('password')),
        'role'       => $this->input->post('role'),
        'name'       => $this->input->post('name'),
        'image'      => 'image_e5c8446.jpg',
        'theme_color'=> 'skin-blue',
        'menu_style' => 1,
        'status'     => 1,
        'created'    => date('Y-m-d H:i:s')
      );
      $result=$this->FunctionModel->Insert($InsertData,'vidiem_users');
      if ($result != 0) :
          $this->session->set_flashdata('class', "alert-success");
          $this->session->set_flashdata('icon', "fa-check");
          $this->session->set_flashdata('msg', "User Added Successfully.");
          redirect('Admin/users','refresh');
        else :
          $this->session->set_flashdata('class', "alert-danger");
          $this->session->set_flashdata('icon', "fa-warning");
          $this->session->set_flashdata('msg', "Something Went sachin Wrong.");
          redirect('Admin/users/add', 'refresh');
            endif;
      }
       $data['roles'] = $this->FunctionModel->Select('vidiem_roles',array('status'=>1));
       $this->load->view('Backend/users-add',@$data);
    }

    public function edit($id = NULL) {
        if(hasPermission('user_update') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
  		$edit_id=!empty($id)?$id:$this->input->post('hidden_id'); $data['edit_id']=$edit_id;
  		$data['roles'] = $this->FunctionModel->Select('vidiem_roles',array('status'=>1));
  		if(empty($edit_id)){
  			$this->session->set_flashdata('class', "alert-danger");
  			$this->session->set_flashdata('icon', "fa-warning");
  			$this->session->set_flashdata('msg', "Something Went Wrong.");
  			redirect('Admin/users', 'refresh');
  		}
  		$this->form_validation->set_rules('hidden_id', 'ID', 'required');
  		$this->form_validation->set_rules('name','Full Name','required');
  		$this->form_validation->set_rules('email','Email','callback_email_validation');
  		$this->form_validation->set_rules('password','Password','min_length[6]|max_length[15]');
  		  if (!$this->form_validation->run() == FALSE) {
  			   $UpdateData=array(
  					'name'     => $this->input->post('name'),
  					'email'    => $this->input->post('email'),
  					'role'     => $this->input->post('role'),
  					'modified' => date('Y-m-d H:i:s')
  				);
  		  $password=$this->input->post('password');
  		  if(!empty($password)){ $UpdateData['password']=sha1($password); }
  		  $result=$this->FunctionModel->Update($UpdateData,'vidiem_users',array('id'=>$edit_id));
  			if ($result == 1) :
  				$this->session->set_flashdata('class', "alert-success");
  				$this->session->set_flashdata('icon', "fa-check");
  				$this->session->set_flashdata('msg', "User Updated Successfully.");
  				redirect('Admin/users','refresh');
  			else :
            		$this->session->set_flashdata('class', "alert-danger");
  				$this->session->set_flashdata('icon', "fa-warning");
  				$this->session->set_flashdata('msg', "Something Went sachin Wrong.");
            		redirect('Admin/users/edit/'.$edit_id, 'refresh');
          	endif;
  			}
  			$data['Edit_Result']=$this->FunctionModel->Select_Row('vidiem_users',array('id'=>$edit_id));
  		   $this->load->view('Backend/users-edit',$data);
    }

    public function email_validation(){
    	$tmp_id=$this->input->post('hidden_id');
    	$email=$this->input->post('email');
    	if(empty($email)){
    		$this->form_validation->set_message('email_validation','Email Field required');
    		return false;
    	}
    	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		$this->form_validation->set_message('email_validation','Invalid Email Address');
			return false;
    	}
    	$count=$this->FunctionModel->Row_Count('vidiem_users',array('email'=>$email,'id !='=>$tmp_id));
    	if($count!=0){
    		$this->form_validation->set_message('email_validation','Email Address Already Exist');
			return false;
    	}
    	return true;
    }

    public function status($id = NULL,$status = NULL) {
		if(empty($id) || empty($status)){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
			redirect('Admin/users', 'refresh');
		}
		$UpdateData=array(
			'status' =>$status,
			'modified'=>date('Y-m-d H:i:s')
			);
		$result = $this->FunctionModel->Update($UpdateData,'vidiem_users',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect($_SERVER['HTTP_REFERER'],'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect($_SERVER['HTTP_REFERER'], 'refresh');
        endif;
    }

	public function delete($id = NULL) {
	    if(hasPermission('user_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");
			redirect('Admin/users', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_users',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect($_SERVER['HTTP_REFERER'], 'refresh');
        endif;
    }
	
}