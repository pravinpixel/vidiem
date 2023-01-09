<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model(array('ProjectModel','FunctionModel'));
	}

	public function index(){
	    $code=$this->ProjectModel->RegistrationCode();
	    echo $code; exit;
	}
	
	

}