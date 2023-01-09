<?php
class HomeModel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');
		$this->load->database();
    }
    	  
}