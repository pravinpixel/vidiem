<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managestate extends CI_Controller {
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
        $this->load->view('Backend/managestate/index');
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
        $this->load->view('Backend/managestate/form',$data);
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
			
            $this->form_validation->set_rules('statename', 'State Name', 'trim|required|edit_unique_customize[vidiem_servicestate.statename.country_id.state_id.'.$id.']');
			
			
			
            if ($this->form_validation->run() == FALSE) { 
				  $data['action']="Create";
				  $data['dataitems']['statename'] =  ltrim($this->input->post('statename'));
				  
                return $this->load->view('Backend/managestate/form',$data); 
            }
			
			
			 $createdatavalue = [
                "statename"     => ltrim($this->input->post('statename')),			    
                "userid" 	=> $this->session->userdata("user_id"),	
                "createddate" 	=> Date('Y-m-d H:i:s'),
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
            $result = $this->FunctionModel->Insert($createdatavalue,'vidiem_servicestate',array('state_id' => $id));
			
           
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Added Successfully.");
            } else {
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
            }
            return redirect('Admin/Managestate/index');
            }
        
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/Managestate/index');
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
        $data['dataitems'] = $this->SerivceModel->getDataArrById($id,"vidiem_servicestate","state_id");
        if(empty($data['dataitems'])) {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Data not found.");
            return redirect('Admin/Managestate/index');
        }
		// $data['categories'] = $this->FunctionModel->Select_Fields('name,id','vidiem_category',array('status'=>1,"parent_id"=>"0"));
		
        return $this->load->view('Backend/managestate/form',$data);
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
		
			
          $this->form_validation->set_rules('statename', 'State Name', 'trim|required|edit_unique_customize[vidiem_servicestate.statename.country_id.state_id.'.$id.']');
            if ($this->form_validation->run() == FALSE) { 
                $data['dataitems'] = $this->SerivceModel->getDataArrById($id,"vidiem_servicestate","state_id");
				$data['action']="Edit";
                return $this->load->view('Backend/managestate/edit',$data); 
            }
            $updatedatavalue = [
                "statename"     => ltrim($this->input->post('statename')),			    
               "userid" 	=> $this->session->userdata("user_id"),	
               
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
            $result = $this->FunctionModel->Update($updatedatavalue,'vidiem_servicestate',array('state_id' => $id));
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Update Successfully.");
            }
            return redirect('Admin/Managestate/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/Managestate/index');
    }

    public function status($id) 
    {
        if($this->input->method() == 'post') {
            $dataarr = $this->SerivceModel->getDataArrById($id,"vidiem_servicestate","state_id");
            $update_status = [
                "isactive"     => !(int)$dataarr->isactive,
				"userid" 	=> $this->session->userdata("user_id"),	
               
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
       
            $result = $this->FunctionModel->Update($update_status,'vidiem_servicestate',array('state_id' => $id));
			
			// print_r($this->db->last_query());  
		  // die();
			
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Status Update Successfully.");
            }
            return redirect('Admin/Managestate/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/Managestate/index');
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
            return redirect('Admin/Managestate/index');
        }
        $dataarr = $this->SerivceModel->getDataArrById($id,"vidiem_servicestate","state_id");
        
		
		  if(!isset($dataarr->state_id) || $dataarr->state_id=='' ){
      
			
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "State id missing");
            return $this->load->view('Backend/managestate/index');
        }
		
		 
            $update_status = [
                "isactive"     => "2",
				"userid" 	=> $this->session->userdata("user_id"),	
               
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
       
            $result = $this->FunctionModel->Update($update_status,'vidiem_servicestate',array('state_id' => $id));
          
		
      //  $result = $this->FunctionModel->Delete('vidiem_registration_categories',array('id'=>$id));
        if ($result) {
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Successfully Deleted.");
            return $this->load->view('Backend/managestate/index');
        }else {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            return $this->load->view('Backend/managestate/index');
        }
        return $this->load->view('Backend/managestate/index');
    }

    public function display_datatble_list(){
		
		$searchbycloums=["statename"];
		
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
            $searchQuery['statename'] = $searchValue;
        }
		
		//print_r($searchQuery);
		//die();
		
        $DataResult=$this->SerivceModel->managestateList('list',$where,$custom,$searchQuery,$order);
        $count=$this->SerivceModel->managestateList('count',$where,$custom,$searchQuery);
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
	if( $row['state_id']!="1"){		
        $data[]=array(
           'no'                  => '',
           'id'                  => $no,
           'statename'       => $row['statename'],		
 
           'status'              => '<div calss="row" ><a href="#" data-message="Are you want to update status" data-href="' . base_url('Admin/Managestate/status/'.$row['state_id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-"><span class="label '.$status_color.' status-span">'.$status.'</span></a>',
           'action'              => '<div calss="row"> <a href="'.base_url('Admin/Managestate/edit/'.$row['state_id']).'" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                                   <a href="#" data-message="Are you sure want to delete ? " data-href="' . base_url('Admin/Managestate/delete/'.$row['state_id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></div>'
        );
	} else {
		  $data[]=array(
           'no'                  => '',
           'id'                  => $no,
           'statename'       => $row['statename'],		
 
           'status'              => '<div calss="row" ><span class="label '.$status_color.' status-span">'.$status.'</span></div>',
           'action'              => '-'
        );
		
		
	}
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