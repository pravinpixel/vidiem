<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AjaxAction extends CI_Controller {
	   function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->model(array('Accessmodel'));
       
    }


    public function index(){
		 
          redirect('Admin', 'refresh');
    }
	
      public function loadcity(){
		 
            $city = $this->FunctionModel->Select_Fields('cityname as name, city_id as id','vidiem_servicecity',array('isactive'=>1,"state_id"=>$_POST['sid']));
            
            $optionhtml='   <select class="selectpicker required js-states form-control custome-select registration_category" data-live-search="true" name="city_id" id="city_id"><option  value="" >Select City</option>';
            if(!empty($city)){ 
                  foreach($city as $info){ 
                        $optionhtml.='<option  value="'.$info['id'].'" >'.$info['name'].'</option>';
            } 
            }  
            echo $optionhtml.="</select>";  
		
    }
	

  
}