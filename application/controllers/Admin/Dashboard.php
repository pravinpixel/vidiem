<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct() {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->model(array('Accessmodel','Dashboardmodel'));
		// print_r( $_SESSION );die;
        if(!$this->session->userdata('user_logged_in')){
			$this->session->set_flashdata('class', "alert-danger");	 
			$this->session->set_flashdata('icon', "fa-warning");	 
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}	
    }
	
	public function index(){
		// Dashboard Statistics
		$data['Statistics']=$this->Dashboardmodel->DashInfo();
	    $this->load->view('Backend/dashboard',@$data);
	}

	// Dashboard Config
	
	public function sidebar_config(){
		$style=$this->session->userdata('user_menu_style');
		if($style=='sidebar-collapse'){
			$style='';
		}else{
			$style='sidebar-collapse';
		}
		$UpdateData=array(
			'menu_style'=>$style,
			'modified'=>date('Y-m-d h:i:s')
		);
		$this->session->set_userdata('user_menu_style',$style);
		$id=$this->session->userdata('user_id');
		$result=$this->FunctionModel->Update($UpdateData,'vidiem_users',array('id'=>$id));
		echo $result;
		exit;
	}

	public function background_config(){
		$style=$this->input->post('style');
		$UpdateData=array(
			'theme_color' => $style,
			'modified'    => date('Y-m-d h:i:s')
		);
		$this->session->set_userdata('user_theme_color',$style);
		$id=$this->session->userdata('user_id');
		$result=$this->FunctionModel->Update($UpdateData,'vidiem_users',array('id'=>$id));
		echo $result;
		exit;
	}

}
