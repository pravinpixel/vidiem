<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProductRegistration extends CI_Controller {
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
        $this->load->view('Backend/registration-product/index');
    }

    public function create()
    {
        $data['registration_categories'] = $this->FunctionModel->Select_Fields('category_name,id','vidiem_registration_categories',array('is_active'=>1));
        $this->load->view('Backend/registration-product/create', $data);
    }

    public function store()
    {
        if($this->input->method() == 'post') {
            $this->form_validation->set_rules('product_name', 'product name', 'trim|required|is_unique[vidiem_registration_products.product_name]');
            $this->form_validation->set_rules('category_id', 'category', 'required');
            if ($this->form_validation->run() == FALSE) {
                $data['registration_categories'] = $this->FunctionModel->Select_Fields('category_name,id','vidiem_registration_categories',array('is_active'=>1));
                return $this->load->view('Backend/registration-product/create', $data); 
            }
            $productRegistration = [
                "product_name"     => ltrim($this->input->post('product_name')),
                "category_id"     =>  $this->input->post('category_id'),
                "created_at"        => Date('Y-m-d'),
            ];
            $result = $this->FunctionModel->Insert($productRegistration,'vidiem_registration_products');
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Added Successfully.");
            } else {
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
            }
            return redirect('Admin/productRegistration/index');
            }
        
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/productRegistration/index');
    }

    public function edit($id) 
    {
        $data['registrationProduct'] = $this->ProjectModel->getRegistrationProductById($id);
        if(empty($data['registrationProduct'])) {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Data not found.");
            return redirect('Admin/productRegistration/index');
        }
        $data['registration_categories'] = $this->FunctionModel->Select_Fields('category_name,id','vidiem_registration_categories',array('is_active'=>1));
        return $this->load->view('Backend/registration-product/edit',$data);
    }

    public function update($id)
    {
        if($this->input->method() == 'post') {
            $this->form_validation->set_rules('product_name', 'product name', 'trim|required|edit_unique[vidiem_registration_products.product_name.category_id.'.$id.']');
            if ($this->form_validation->run() == FALSE) { 
                $data['registrationProduct'] = $this->ProjectModel->getRegistrationProductById($id);
                $data['registration_categories'] = $this->FunctionModel->Select_Fields('category_name,id','vidiem_registration_categories',array('is_active'=>1));
                return $this->load->view('Backend/registration-product/edit',$data); 
            }
            $productRegistration = [
                "product_name"      => ltrim($this->input->post('product_name')),
                "category_id"       =>  $this->input->post('category_id'),
                "updated_at"        => Date('Y-m-d'),
            ];
            $result = $this->FunctionModel->Update($productRegistration,'vidiem_registration_products',array('id' => $id));
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Update Successfully.");
            }
            return redirect('Admin/productRegistration/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/CategorRegistration/index');
    }

    public function status($id) 
    {
        if($this->input->method() == 'post') {
            $registrationProduct = $this->ProjectModel->getRegistrationProductById($id);
            $productRegistration = [
                "is_active"     => !$registrationProduct->is_active,
            ];
       
            $result = $this->FunctionModel->Update($productRegistration,'vidiem_registration_products',array('id' => $id));
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Status Update Successfully.");
            }
            return redirect('Admin/productRegistration/index');
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
            return redirect('Admin/productRegistration/index');
        }
        $result = $this->FunctionModel->Delete('vidiem_registration_products',array('id'=>$id));
        if ($result == 1) {
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Successfully Deleted.");
            return redirect('Admin/productRegistration/index');
        }
        else {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            return redirect('Admin/productRegistration/index');
        }
    
    }

    public function registration_product_list(){
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
                'field'=>'c.created_at',
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
            $columns = $this->db->list_fields('vidiem_registration_products');
            foreach($columns as $column){
                $searchQuery['p.'.$column ] = $searchValue;
            }
            $searchQuery['c.category_name'] = $searchValue;
        }
        $DataResult=$this->ProjectModel->registrationProductList('list',$where,$custom,$searchQuery,$order);
        $count=$this->ProjectModel->registrationProductList('count',$where,$custom,$searchQuery);
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
           'product_name'        => $row['product_name'],
           'category_name'       => $row['category_name'],
           'status'              => '<div calss="row" ><a href="#" data-message="Are you sure want to update the status" data-href="' . base_url('Admin/productRegistration/status/'.$row['id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-"><span class="label '.$status_color.' status-span">'.$status.'</span></a>',
           'action'              => '<div calss="row"> <a href="'.base_url('Admin/productRegistration/edit/'.$row['id']).'" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                                    <a href="#" data-message="Are you sure want to delete ? " data-href="' . base_url('Admin/productRegistration/delete/'.$row['id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></div>'
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