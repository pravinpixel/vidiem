<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CategoryRegistration extends CI_Controller {
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
	
        $this->load->view('Backend/registration-category/index');
    }

    public function create()
    {
        $this->load->view('Backend/registration-category/create');
    }

    public function store()
    {
    
        if($this->input->method() == 'post') {
            $this->form_validation->set_rules('category_name', 'category name', 'trim|required|is_unique[vidiem_registration_categories.category_name]');
            if ($this->form_validation->run() == FALSE) { 
                return $this->load->view('Backend/registration-category/create'); 
            }
            $categoryRegistration = [
                "category_name"     => ltrim($this->input->post('category_name')),
                "created_at"        => Date('Y-m-d'),
            ];
            $result = $this->FunctionModel->Insert($categoryRegistration,'vidiem_registration_categories');
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Added Successfully.");
            } else {
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
            }
            return redirect('Admin/CategoryRegistration/index');
            }
        
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/CategorRegistration/index');
    }

    public function edit($id) 
    {
        $data['registrationCategory'] = $this->ProjectModel->getRegistrationCategoryById($id);
        if(empty($data['registrationCategory'])) {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Data not found.");
            return redirect('Admin/CategoryRegistration/index');
        }
        return $this->load->view('Backend/registration-category/edit',$data);
    }

    public function update($id)
    {
        if($this->input->method() == 'post') {
            $this->form_validation->set_rules('category_name', 'category name', 'trim|required');
            if ($this->form_validation->run() == FALSE) { 
                $data['registrationCategory'] = $this->ProjectModel->getRegistrationCategoryById($id);
                return $this->load->view('Backend/registration-category/edit',$data); 
            }
            $categoryRegistration = [
                "category_name"     => ltrim($this->input->post('category_name')),
                "updated_at"        => Date('Y-m-d'),
            ];
            $result = $this->FunctionModel->Update($categoryRegistration,'vidiem_registration_categories',array('id' => $id));
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Update Successfully.");
            }
            return redirect('Admin/CategoryRegistration/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/CategorRegistration/index');
    }

    public function status($id) 
    {
        if($this->input->method() == 'post') {
            $registrationCategory = $this->ProjectModel->getRegistrationCategoryById($id);
            $categoryRegistration = [
                "is_active"     => !$registrationCategory->is_active,
            ];
       
            $result = $this->FunctionModel->Update($categoryRegistration,'vidiem_registration_categories',array('id' => $id));
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Status Update Successfully.");
            }
            return redirect('Admin/CategoryRegistration/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/CategorRegistration/index');
    }
    public function delete($id = NULL) {

        if(empty($id) || $this->input->method() != 'post'){
            $this->session->set_flashdata('class', "alert-warning");	 
            $this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
            return redirect('Admin/CategorRegistration/index');
        }
      
        $exists =  $this->ProjectModel->getRegistrationProductByCategoryId($id);
        if(isset($exists->id)){
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Can not delete this category it is linked with registration product.");
            return $this->load->view('Backend/registration-category/index');
        }
        $result = $this->FunctionModel->Delete('vidiem_registration_categories',array('id'=>$id));
        if ($result == 1) {
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Successfully Deleted.");
            return $this->load->view('Backend/registration-category/index');
        }else {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            return $this->load->view('Backend/registration-category/index');
        }
        return $this->load->view('Backend/registration-category/index');
    }

    public function registration_category_list(){
		
		
		
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
                'field'=>'created_at',
                'type'=> 'desc'
            );
        }else{
            $order=array(
                'field'=>$columnName,
                'type'=> $columnSortOrder
            );
        }
        $where=[];
        $custom='';
        $searchQuery = [];
        if($searchValue != ''){
            $columns = $this->db->list_fields('vidiem_registration_categories');
            foreach($columns as $column){
                $searchQuery[$column ] = $searchValue;
            }
            $searchQuery['category_name'] = $searchValue;
        }
        $DataResult=$this->ProjectModel->registrationCategoryList('list',$where,$custom,$searchQuery,$order);
        $count=$this->ProjectModel->registrationCategoryList('count',$where,$custom,$searchQuery);
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
            $status =  $row['is_active'] == 0 ? "inactive" : "active" ;
            $status_color =  $row['is_active'] == 0 ? "label-danger" : "label-success" ;
        $data[]=array(
           'no'                  => '',
           'id'                  => $no,
           'category_name'       => $row['category_name'],
           'status'              => '<div calss="row" ><a href="#" data-message="Are you want to update status" data-href="' . base_url('Admin/CategoryRegistration/status/'.$row['id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-"><span class="label '.$status_color.' status-span">'.$status.'</span></a>',
           'action'              => '<div calss="row"> <a href="'.base_url('Admin/CategoryRegistration/edit/'.$row['id']).'" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                                   <a href="#" data-message="Are you sure want to delete ? " data-href="' . base_url('Admin/CategoryRegistration/delete/'.$row['id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></div>'
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