<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managecity extends CI_Controller {
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


    public function index(){
		if(hasPermission('service_center_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
        $this->load->view('Backend/managecity/index');
    }

    public function create()
    {
        if(hasPermission('service_center_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		 $data['action'] =  "Create";
		  $data['state'] = $this->FunctionModel->Select_Fields('statename as name ,state_id as id',' vidiem_servicestate ',array('isactive'=>1));
		  
		
		  
        $this->load->view('Backend/managecity/form',$data);
    }

    public function save()
    {
        if(hasPermission('service_center_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
        if($this->input->method() == 'post') {
			
            $this->form_validation->set_rules('cityname', 'City Name', 'trim|required|edit_unique_customize[vidiem_servicecity.cityname.state_id.city_id.'.$id.']');
			$this->form_validation->set_rules('state_id','State','required');	
			
			
            if ($this->form_validation->run() == FALSE) { 
				  $data['action']="Create";
				  $data['dataitems']['cityname'] =  ltrim($this->input->post('cityname'));
				  
                return $this->load->view('Backend/managecity/form',$data); 
            }
			
			
			 $createdatavalue = [
                "cityname"     => ltrim($this->input->post('cityname')),			    
                "state_id"     => ltrim($this->input->post('state_id')),			    
                "userid" 	=> $this->session->userdata("user_id"),	
                "createddate" 	=> Date('Y-m-d H:i:s'),
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
            $result = $this->FunctionModel->Insert($createdatavalue,'vidiem_servicecity',array('city_id' => $id));
			
           
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Added Successfully.");
            } else {
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
            }
            return redirect('Admin/Managecity/index');
            }
        
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/Managecity/index');
    }

    public function edit($id) 
    {
        if(hasPermission('service_center_update') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		 $data['action'] =  "Edit";
        $data['dataitems'] = $this->SerivceModel->getDataArrById($id,"vidiem_servicecity","city_id");
        if(empty($data['dataitems'])) {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Data not found.");
            return redirect('Admin/Managecity/index');
        }
		 $data['state'] = $this->FunctionModel->Select_Fields('statename as name ,state_id as id',' vidiem_servicestate ',array('isactive'=>1));
		
        return $this->load->view('Backend/managecity/form',$data);
    }

    public function update($id)
    {
		if(hasPermission('service_center_update') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
	
        if($this->input->method() == 'post') {
		
			
          $this->form_validation->set_rules('cityname', 'City Name', 'trim|required|edit_unique_customize[vidiem_servicecity.cityname.state_id.city_id.'.$id.']');
		  	$this->form_validation->set_rules('state_id','State','required');	
            if ($this->form_validation->run() == FALSE) { 
                $data['dataitems'] = $this->SerivceModel->getDataArrById($id,"vidiem_servicecity","city_id");
			   $data['state'] = $this->FunctionModel->Select_Fields('statename as name ,state_id as id',' vidiem_servicestate ',array('isactive'=>1));
				$data['action']="Edit";
                return $this->load->view('Backend/managecity/edit',$data); 
            }
            $updatedatavalue = [
                "cityname"     => ltrim($this->input->post('cityname')),	
				"state_id"     => ltrim($this->input->post('state_id')),			   				
               "userid" 	=> $this->session->userdata("user_id"),	
               
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
            $result = $this->FunctionModel->Update($updatedatavalue,'vidiem_servicecity',array('city_id' => $id));
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Update Successfully.");
            }
            return redirect('Admin/Managecity/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/Managecity/index');
    }

    public function status($id) 
    {
        if($this->input->method() == 'post') {
            $dataarr = $this->SerivceModel->getDataArrById($id,"vidiem_servicecity","city_id");
            $update_status = [
                "isactive"     => !(int)$dataarr->isactive,
				"userid" 	=> $this->session->userdata("user_id"),	
               
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
       
            $result = $this->FunctionModel->Update($update_status,'vidiem_servicecity',array('city_id' => $id));
			
			// print_r($this->db->last_query());  
		  // die();
			
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Status Update Successfully.");
            }
            return redirect('Admin/Managecity/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/Managecity/index');
    }
    public function delete($id = NULL) {
        if(hasPermission('service_center_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
        if(empty($id) || $this->input->method() != 'post'){
            $this->session->set_flashdata('class', "alert-warning");	 
            $this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
            return redirect('Admin/Managecity/index');
        }
        $dataarr = $this->SerivceModel->getDataArrById($id,"vidiem_servicecity","city_id");
        
		
		  if(!isset($dataarr->city_id) || $dataarr->city_id=='' ){
      
			
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "State id missing");
            return $this->load->view('Backend/managecity/index');
        }
		
		 
            $update_status = [
                "isactive"     => "2",
				"userid" 	=> $this->session->userdata("user_id"),	
               
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
       
            $result = $this->FunctionModel->Update($update_status,'vidiem_servicecity',array('city_id' => $id));
          
		
      //  $result = $this->FunctionModel->Delete('vidiem_registration_categories',array('id'=>$id));
        if ($result) {
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Successfully Deleted.");
            return $this->load->view('Backend/managecity/index');
        }else {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            return $this->load->view('Backend/managecity/index');
        }
        return $this->load->view('Backend/managecity/index');
    }

    public function display_datatble_list(){
		
		$searchbycloums=["cityname"];
		
        $length=$this->input->post('length');
        $draw=$this->input->post('draw');
        $start = $this->input->post('start');
        $rowperpage = $this->input->post('length'); 
        $columnIndex = $this->input->post('order')[0]['column'];
        $columnName = $this->input->post('columns')[$columnIndex]['data']; 
        $columnSortOrder = $this->input->post('order')[0]['dir']; 
        $searchValue = $this->input->post('search')['value']; 
        if($columnIndex==0){
            $order=array(
                'field'=>'createddate',
                'type'=> 'desc'
            );
        }else{
            $order=array(
                'field'=>$columnName,
                'type'=> $columnSortOrder
            );
        }
        $where=[];
		$where=array("p.isactive != "=>"2");
        $custom='';
        $searchQuery = [];
        if($searchValue != ''){
            $columns = $searchbycloums;
        foreach($columns as $column){
                $searchQuery[$column ] = $searchValue;
            }
            $searchQuery['cityname'] = $searchValue;
        }
		
		//print_r($searchQuery);
		//die();
		
        $DataResult=$this->SerivceModel->managecityList('list',$where,$custom,$searchQuery,$order);
        $count=$this->SerivceModel->managecityList('count',$where,$custom,$searchQuery);
        $data = array();
        if($order['type']=='desc' && $order['field']=='id'){
            $no=$start+1;
        }else if($order['type']=='asc' && $order['field']=='id' ){
            $no=$count;
        }else{
            $no=$start+1;  
        }
        
       
       if($DataResult){
        foreach($DataResult as $row){
            $options='';
            $status =  $row['isactive'] == 0 ? "inactive" : "active" ;
            $status_color =  $row['isactive'] == 0 ? "label-danger" : "label-success" ;
	
        $data[]=array(
           'no'                  => '',
           'id'                  => $no,
           'cityname'       => $row['cityname'],	
		   'statename'       => $row['statename'],	
 
           'status'              => '<div calss="row" ><a href="#" data-message="Are you want to update status" data-href="' . base_url('Admin/Managecity/status/'.$row['city_id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-"><span class="label '.$status_color.' status-span">'.$status.'</span></a>',
           'action'              => '<div calss="row"> <a href="'.base_url('Admin/Managecity/edit/'.$row['city_id']).'" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                                   <a href="#" data-message="Are you sure want to delete ? " data-href="' . base_url('Admin/Managecity/delete/'.$row['city_id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></div>'
        );

        if($order['type']=='desc' && $order['field']=='id' ){
            $no++;
        }else if($order['type']=='asc' && $order['field']=='id' ){
            $no--;
        }else{
            $no++;  
        }
         }
        }
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $count,
            "iTotalDisplayRecords" => $count,
            "aaData" => $data
         );
         echo json_encode($response); exit;
    }
}