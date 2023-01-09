<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Registration extends CI_Controller {
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


    public function product_registration(){
        if(hasPermission('site_registration_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
        $this->load->view('Backend/registration-product-view');
    }

     public function product_registration_list(){
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
                'field'=>'r.created',
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
            $columns = $this->db->list_fields('vidiem_product_registration');
            foreach($columns as $column)
            {
                $searchQuery['r.'.$column ] = $searchValue;
            }
            //$searchQuery = array('r.code'=>$searchValue,'r.category' => $searchValue, 'r.product' => $searchValue,'r.email' => $searchValue, 'r.name'=>$searchValue,'r.mobile'=>$searchValue);
        }
        $DataResult=$this->ProjectModel->productRegistrationList('list',$where,$custom,$searchQuery,$order);
        $count=$this->ProjectModel->productRegistrationList('count',$where,$custom,$searchQuery);
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
        $data[]=array(
           'no'          => '',
           'id'          => $no,
		   'code'        => $row['code'],
           'category'      => $row['category'],	     
           'Product'     => $row['Product'],
           'jdate'       => $row['jdate'],
           'serialnumer' => $row['serialnumer'],
		   'purchasefrom'  => $row['purchasefrom'],
           'dealername'  => $row['dealername'],
           'gender'      => $row['gender'],
           'name'        => $row['name'],
           'age'         => $row['age'],
           'email'       => $row['email'],
           'mobile'      => $row['mobile'],
           'occupation'  => $row['occupation'],
           'address'     => $row['address'],
           'city'        => $row['city'],
           'state'       => $row['state'],
           'country'     => $row['country'],
           'pincode'     => $row['pincode'],
           'created'     => date('d-M-Y',strtotime($row['created'])),
           'options'     => $options,
           'action'      => '<div calss="row"> <a href="'.base_url('Admin/registration/edit_product_registration/'.$row['id']).'" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></a>'
           //    <a href="javascript:void(0);" class="btn btn-danger delete_trigger" data-toggle="tooltip" data-placement="right"  data-original-title="Delete" data-url="'.base_url('Admin/Registration/delete_product_registration/'.$row['id']).'""><span class="fa fa-trash"></span></a>
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

    public function complaint_registration(){
        if(hasPermission('site_registration_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
	    }
        $this->load->view('Backend/registration-complaint-view');
    }

    public function complaint_registration_list(){
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
                'field'=>'r.created',
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
            $columns = $this->db->list_fields('vidiem_complaint_registration');
            foreach($columns as $column){
                $searchQuery['r.'.$column ] = $searchValue;
            }
            $searchQuery['c.name'] = $searchValue;
            $searchQuery['p.name'] = $searchValue;
            //$searchQuery = array('r.code'=>$searchValue,'c.name'=>$searchValue,'p.name'=>$searchValue,'r.name'=>$searchValue,'r.mobile'=>$searchValue);
        }
        $DataResult=$this->ProjectModel->complaintRegistrationList('list',$where,$custom,$searchQuery,$order);
        $count=$this->ProjectModel->complaintRegistrationList('count',$where,$custom,$searchQuery);
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
        $data[]=array(
           'no'                  => '',
           'id'                  => $no,
           'code'                => $row['code'],
           'category'            => $row['category_name'],
           'product'             => $row['product_name'],
           'serialnumer'         => $row['serialnumer'],
           'purchase_date'       => $row['purchase_date'],
           'dealername'          => $row['dealername'],
           'remarks'             => $row['remarks'],
           'gender'              => $row['gender'],
           'name'                => $row['name'],
           'email'               => $row['email'],
           'mobile'              => $row['mobile'],
           'alternative_mobile'  => $row['alternative_mobile'],
           'occupation'          => $row['occupation'],
           'address'             => $row['address'],
           'city'                => $row['city'],
           'state'               => $row['state'],
           'country'             => $row['country'],
           'pincode'             => $row['pincode'],
           'created'             => date('d-M-Y',strtotime($row['created'])),
           'options'             => $options,
           'action'              => '<div calss="row"> <a href="'.base_url('Admin/registration/edit_complaint_registration/'.$row['id']).'" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></a>'
        //    <a href="javascript:void(0);" class="btn btn-danger delete_trigger" data-toggle="tooltip" data-placement="right"  data-original-title="Delete" data-url="'.base_url('Admin/Registration/delete_complaint_registration/'.$row['id']).'""><span class="fa fa-trash"></span></a>
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

    public function complaint_exports(){
      $order=array(
          'field'=>'r.created',
          'type'=> 'desc'
      );
      $where=[];
      $custom='';
      $searchQuery = "";
      $DataResult=$this->ProjectModel->complaintRegistrationExport();
      if (empty($DataResult)) {
        $DataResult[0]['No Result Found'] = '';
      }
      $this->FunctionModel->export_data($DataResult, 'complaint-registration-data');
  }

  public function products_exports(){
      $order=array(
          'field'=>'r.created',
          'type'=> 'desc'
      );
      $where=[];
      $custom='';
      $searchQuery = "";
      $DataResult=$this->ProjectModel->productRegistrationExport();
      if (empty($DataResult)) {
        $DataResult[0]['No Result Found'] = '';
      }
      $this->FunctionModel->export_data($DataResult,'product-registration-data');
  }

  public function edit_product_registration($id) {
      
    if(hasPermission('site_registration_update') != true){
		$this->session->set_flashdata('class', "alert-danger");
		$this->session->set_flashdata('icon', "fa-warning");
		$this->session->set_flashdata('msg', "Access denied.");
		redirect('Admin/dashboard', 'refresh');
    }
    
    if($this->input->method() == 'post') {
        $this->form_validation->set_rules('code', 'Code', 'required');
        $this->form_validation->set_rules('category', 'category', 'required');
        $this->form_validation->set_rules('product_name', 'product name', 'required');
        $this->form_validation->set_rules('serial_number', 'serial no', 'required');
        $this->form_validation->set_rules('purchase_from', 'purchase from', 'required');
        $this->form_validation->set_rules('purchase_date', 'purchase date', 'required');
        $this->form_validation->set_rules('dealer_name', 'dealer name', 'required');
        $this->form_validation->set_rules('gender', 'gender', 'required');
        $this->form_validation->set_rules('name', 'name', 'required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('age','age','required|regex_match[/^[0-9]{2}$/]');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('mobile', 'mobile', 'required|regex_match[/^[0-9]{10}$/]');
        //$this->form_validation->set_rules('occupation', 'occupation', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('city', 'city', 'required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('country', 'country', 'required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('state', 'state', 'required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('pincode','pincode','required|regex_match[/^[0-9]{6}$/]');
        if (!$this->form_validation->run() == FALSE) { 
          
          $productRegistration = [
              "category"     => $this->input->post('category'),
              "Product"      => $this->input->post('product_name'),
              "serialnumer" => $this->input->post('serial_number'),
              "jdate"        => $this->input->post('purchase_date'),
              "dealername"   => $this->input->post('dealer_name'),
              "purchasefrom" => $this->input->post('purchase_from'),
              "gender"       => $this->input->post('gender'),
              "name"         => $this->input->post('name'),
              "age"          => $this->input->post('age'),
              "email"        => $this->input->post('email'),
              "mobile"       => $this->input->post('mobile'),
              "address"      => $this->input->post('address'),
              "occupation"   => $this->input->post('occupation'),
              "city"         => $this->input->post('city'),
              "country"      => $this->input->post('country'),
              "state"        => $this->input->post('state'),
              "pincode"      => $this->input->post('pincode'),
          ];
          $result = $this->FunctionModel->Update($productRegistration,'vidiem_product_registration',array('id' => $id));
          if( $result ) {
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-success");
            $this->session->set_flashdata('msg', "Update Successfully.");
            
          } else {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
          }
          return redirect('Admin/registration/product_registration');
        }
    }
    $data['productRegistration'] = $this->ProjectModel->getProductRegistrationById($id);
    if(empty($data['productRegistration'])) {
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Data not found.");
        return redirect('Admin/registration/product_registration');
    }
    $data['category'] = $this->FunctionModel->Select('vidiem_registration_categories',array('is_active'=>1));
    
  //  print_r($data); die();
    
    $data['products'] = $this->FunctionModel->Select('vidiem_registration_products', array('is_active' =>1));
    return $this->load->view('Backend/registration-product-edit',$data);
  }

  public function delete_product_registration($id) {
    if(empty($id)){
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something Went Wrong.");
        redirect('Admin/registration/product_registration','refresh');
    }
    $result = $this->FunctionModel->Delete('vidiem_product_registration',array('id'=>$id));
    if ($result) {
        $this->session->set_flashdata('class', "alert-success");
        $this->session->set_flashdata('icon', "fa-check");
        $this->session->set_flashdata('msg', "Successfully Deleted.");
        redirect('Admin/registration/product_registration','refresh');
    } else {
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something Went Wrong.");
        redirect('Admin/registration/product_registration','refresh');
    }
  }

  public function edit_complaint_registration($id) {
      
    if(hasPermission('site_registration_update') != true){
		$this->session->set_flashdata('class', "alert-danger");
		$this->session->set_flashdata('icon', "fa-warning");
		$this->session->set_flashdata('msg', "Access denied.");
		redirect('Admin/dashboard', 'refresh');
    }
    
    if($this->input->method() == 'post') {
        $this->form_validation->set_rules('code', 'code', 'required');
        $this->form_validation->set_rules('category', 'category', 'required');
        $this->form_validation->set_rules('product_name', 'product name', 'required');
        $this->form_validation->set_rules('serial_number', 'serial No', 'required');
        $this->form_validation->set_rules('dealer_name', 'dealer name', 'required');
        $this->form_validation->set_rules('purchase_date', 'purchase date', 'required');
        $this->form_validation->set_rules('gender', 'gender', 'required');
        $this->form_validation->set_rules('name', 'name', 'required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('mobile', 'mobile', 'required|regex_match[/^[0-9]{10}$/]');
       // $this->form_validation->set_rules('occupation', 'occupation', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('city', 'city','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('country', 'country','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('state', 'state', 'required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('pincode','pincode','required|regex_match[/^[0-9]{6}$/]');
       
        if (!$this->form_validation->run() == FALSE) { 
            
          $complaintRegistration = [
              "category"           => $this->input->post('category'),
              "product"            => $this->input->post('product_name'),
              "serialnumer"        => $this->input->post('serial_number'),
              "purchase_date"      => $this->input->post('purchase_date'),
              "dealername"         => $this->input->post('dealer_name'),
              "remarks"            => $this->input->post('remarks'),
              "gender"             => $this->input->post('gender'),
              "name"               => $this->input->post('name'),
              "email"              => $this->input->post('email'),
              "mobile"             => $this->input->post('mobile'),
              "alternative_mobile" => $this->input->post('alternative_mobile'),
              "address"            => $this->input->post('address'),
              "occupation"         => $this->input->post('occupation'),
              "city"               => $this->input->post('city'),
              "state"              => $this->input->post('state'),
              "country"            => $this->input->post('country'),
              "pincode"            => $this->input->post('pincode'),
          ];
          $result = $this->FunctionModel->Update($complaintRegistration,'vidiem_complaint_registration',array('id' => $id));
          if( $result ) {
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-success");
            $this->session->set_flashdata('msg', "Update Successfully.");
          } else {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
          }
          return redirect('Admin/registration/complaint_registration');
        } 
    }
    $data['productComplaint'] = $this->ProjectModel->getComplainRegistrationById($id);
    if(empty($data['productComplaint'])) {
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "data not found.");
        return redirect('Admin/registration/complaint_registration');
    }
    $data['category'] = $this->FunctionModel->Select('vidiem_category',array('status'=>1,'parent_id'=>0));
    $data['products'] = $this->FunctionModel->Select('vidiem_products', array('status' =>1));
    
    return $this->load->view('Backend/registration-complaint-edit',$data);
  }

  public function delete_complaint_registration($id) {
    if(empty($id)){
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something Went Wrong.");
        return redirect('Admin/registration/complaint_registration','refresh');
    }
    $result = $this->FunctionModel->Delete('vidiem_complaint_registration',array('id'=>$id));
    if ($result) {
        $this->session->set_flashdata('class', "alert-success");
        $this->session->set_flashdata('icon', "fa-check");
        $this->session->set_flashdata('msg', "Successfully Deleted.");
        return redirect('Admin/registration/complaint_registration','refresh');
    } else {
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something Went Wrong.");
        return redirect('Admin/registration/complaint_registration','refresh');
    }
  }

}