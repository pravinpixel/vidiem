<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comboenquiry extends CI_Controller {
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
	    if(hasPermission('combo_enquiry_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		$data['DataResult']=$this->FunctionModel->Select_Fields('id,type,name,email,mobile,city,ref_no,enquiry,message,reply_msg,created','vidiem_enquiry',array('status !='=>0,'type'=>2));
		$this->load->view('Backend/combo-enquiry-view',$data); 
    }

	public function delete($id = NULL) {
	    if(hasPermission('combo_enquiry_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		if(empty($id)){
			$this->session->set_flashdata('class', "alert-warning");
	    	$this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");
			redirect('Admin/comboenquiry', 'refresh');
		}
        $result = $this->FunctionModel->Delete('vidiem_enquiry',array('id'=>$id));
		if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Successfully Deleted.");
			redirect('Admin/comboenquiry','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/comboenquiry', 'refresh');
        endif;
    }
	
    public function ReplyEmail(){
    	$id=$this->input->post('id');
    	$email=$this->input->post('email');
    	$reply_msg=$this->input->post('reply_msg');
    	$UpdateData=array(
    		'reply_msg'=>$reply_msg,
    		'modified'=>date('Y-m-d H:i:s')
    	);
    	$this->FunctionModel->Update($UpdateData,'vidiem_enquiry',array('id'=>$id));
    	$subject='Reply Mail From Vidiem';
    	$message='<p>'.$reply_msg.'</p>';
    	$this->FunctionModel->sendmail($email,$message,$subject,'care@vidiem.in');
    	echo 1; exit;
    }

}