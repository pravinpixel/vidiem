<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation', 'upload');
        $this->load->model('LocationsModel');
        $this->load->model('DealersModel');
        if( $this->session->userdata('dealer_session')['user']['user_type'] == 'sale_person' ) {
            redirect('vidiem-dealer');
        }

    }

    public function index($dealer_id)
    {
        $data['details']    = $this->LocationsModel->getLocation($dealer_id);
        $data['dealer_id']  = $dealer_id;
        $this->db->select('dealer_type')->from('vidiem_dealers');
        $query = $this->db->where('id',$dealer_id);
        $query = $this->db->get();
        $row = $query->row();
        $data['dealer_type']=$row->dealer_type;
        $this->load->view('Backend/dealers/location/index', $data);
    }

    public function add_edit($dealer_id, $id = null)
    {   
      
        $this->db->select('dealer_type')->from('vidiem_dealers');
        $query = $this->db->where('id',$dealer_id);
        $query = $this->db->get();
        $row = $query->row();
        $dealer_type=$row->dealer_type;
        $ard_charge=$this->FunctionModel->Select_Fields('id,service_charge','vidiem_ard_service_charge',array('dealer_type'=>'sub_dealer'));
        $action_btn         = 'Save';
        $action             = 'Add';
        $info               = '';
        if( !empty( $id ) ) {
            $info           = $this->LocationsModel->getInfoByRandomColumn('vidiem_dealer_locations', $id, 'id');
            $action_btn     = 'Update';
            $action         = 'Update';
        }        
        $params             = array(
                                'action_btn' => $action_btn,
                                'action' => $action,
                                'info' => $info,
                                'dealer_id' => $dealer_id,
                                'id' => $id,
                                'dealer_type' =>$dealer_type,
                                'ard_charge' => $ard_charge
                            );
        $this->load->view('Backend/dealers/location/add_edit_form', $params);
    }


    	public function file_selected_test_subdealer(){

        $id         = $this->input->post('id');
        $info       = $this->DealersModel->getInfoById('vidiem_dealers', $id);

        if( isset( $info->image ) && !empty( $info->image ) && isset($_FILES['logo']['name']) && $_FILES['logo']['name'] =="" ) {
            return true;
        }
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['logo']['name']);
        
        if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){

                if($_FILES['logo']['size'] != 0){
                    $upload_dir = './uploads/dealer';
                    if (!is_dir($upload_dir)) {
                         mkdir($upload_dir);
                    }
                    if(file_exists($upload_dir.'/'.$_FILES['logo']['name'])){
                            list($file_name)=explode('.',$_FILES['logo']['name']);
                            $file_name=$file_name.'_'.substr(md5(rand()),0,5);
                        }else{
                            list($file_name)=explode('.',$_FILES['logo']['name']);
                        }
                    $config['upload_path']   = $upload_dir;
                    $config['allowed_types'] = 'jpg|png|jpeg';
                    $config['file_name']     = $file_name;
                    $config['overwrite']     = false;
                    $config['max_size']	     = '5120';
            
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('logo')){
                        $this->form_validation->set_message('file_selected_test', $this->upload->display_errors('<p class=error>','</p>'));
                        return false;
                    }
                    else{
                        $this->upload_data['logo'] =  $this->upload->data();
                        return true;
                    }
                }

                return true;
            }else{
                $this->form_validation->set_message('file_selected_test', 'Please select only gif/jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_selected_test', 'Please choose a file to upload.');
            return true;
        }
    }

    public function save()
    {

        $id = $this->input->post('id');
        
        $this->form_validation->set_rules('location_name', 'Location Name', 'required');
        $this->form_validation->set_rules('location_code', 'Location Code', 'required|edit_unique[vidiem_dealer_locations.location_code.id.'.$id.']');
        $this->form_validation->set_rules('email', 'Email Id', 'required');
        $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('logo', 'Logo', 'callback_file_selected_test_subdealer');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->db->select('dealer_type')->from('vidiem_dealers');
            $query = $this->db->where('id',$dealer_id);
            $query = $this->db->get();
            $row = $query->row();
            $dealer_type=$row->dealer_type;
            $ard_charge=$this->FunctionModel->Select_Fields('id,service_charge','vidiem_ard_service_charge',array('dealer_type'=>'sub_dealer'));
    

            $action_btn     = 'Save';
            $action         = 'Add';

            $params         = array(
                                'action_btn' => $action_btn,
                                'action' => $action,
                                'dealer_type' =>$dealer_type,
                                'ard_charge' => $ard_charge
                            );
            $this->load->view('Backend/dealers/location/add_edit_form', $params);

        } else {

            /***
             *  check data already exist in vidiem_dealer_locations
             */
            
            $InsertData     = array(
                                'dealer_id'         => $this->input->post('dealer_id') ?? $this->session->userdata('dealer_session')['dealer']['id'],
                                'location_name'     => $this->input->post('location_name'), 
                                'location_code'     => $this->input->post('location_code'),
                                'dealer_erp_code'   => $this->input->post('dealer_erp_code'),
                                'vidiem_erp_code'   => $this->input->post('vidiem_erp_code'),
                                'location_address'  => $this->input->post('address'),
                                'email'             => $this->input->post('email'),
                                'mobile_no'         => $this->input->post('mobile_no'),
                                'area'              => $this->input->post('area'),
                                'city'              => $this->input->post('city'),
                                'district'          => $this->input->post('district'),
                                'state'             => $this->input->post('state'),
                                'post_code'         => $this->input->post('post_code'),
                                'status'            => '1',                            
                            );
                            	 if( isset( $this->upload_data['logo']['file_name'] ) && !empty( $this->upload_data['logo']['file_name'] ) ) {
                $InsertData['sub_dealer_logo']        = $this->upload_data['logo']['file_name'];
            }

                            if($this->input->post('sub_dealer')=='ard')
                            {
                                $InsertData['sub_dealer_service_charge_id']=$this->input->post('service_charge_id');
                                $InsertData['sub_dealer_gst_no']=$this->input->post('gst_no');
                                $InsertData['sub_dealer_cin_no']=$this->input->post('cin_no');
                                $InsertData['sub_dealer_pan_no']=$this->input->post('pan_no');
                            }
            if( isset( $id ) && !empty( $id ) ) {
                $InsertData['updated_at' ]      = date('Y-m-d H:i:s');
                $result                         = $this->FunctionModel->Update($InsertData,'vidiem_dealer_locations', ['id' => $id]);
                // echo $this->db->last_query();die;
                $location_id = $id;
            } else {
                $InsertData['created_at' ]      = date('Y-m-d H:i:s');
                $result                         = $this->FunctionModel->Insert($InsertData,'vidiem_dealer_locations');
                $location_id = $this->db->insert_id();
            }
            if( $result >= 1 ) {

                //location against user add stars
                if(isset($_POST['s_user_name']) && !empty($_POST['s_user_name'])){

                    $sale_user_id        = $this->input->post('sale_user_id');
                    if( isset( $sale_user_id ) && !empty( $sale_user_id ) ) {

                        $_insert_user_location  = array(
                            'location_id' => $location_id,
                            'dealer_id' => $this->input->post('dealer_id'),
                            'user_id' => $_POST['s_user_name'],
                            'user_code' => $_POST['s_user_code'],
                        );

                        if( isset( $_POST['s_password'] ) && !empty( $_POST['s_password'] ) ) {
                            $_insert_user_location['password'] = sha1($_POST['s_password']);
                            $_insert_user_location['open_password'] = $_POST['s_password'];
                        }

                        $this->FunctionModel->Update($_insert_user_location,'vidiem_dealer_users', ['id' => $sale_user_id ]);
                    } else {
                        $_insert_user_location     = array(
                            'location_id' => $location_id,
                            'dealer_id' => $this->input->post('dealer_id'),
                            'user_id' => $_POST['s_user_name'],
                            'password' => sha1($_POST['s_password']),
                            'open_password' => $_POST['s_password'],
                            'user_code' => $_POST['s_user_code'],
                            'is_admin' => 'no',
                            'is_main_admin' => 'no',
                            'user_type' => 'sale_person'
                        );
                        $this->FunctionModel->Insert($_insert_user_location,'vidiem_dealer_users');
                    }
                    
                }

                if(isset($_POST['c_user_name']) && !empty($_POST['c_user_name'])){
                    $counter_user_id        = $this->input->post('counter_user_id');
                    if( isset( $counter_user_id ) && !empty( $counter_user_id ) ) {

                        $_insert_user_location  = array(
                                                    'location_id'   => $location_id,
                                                    'dealer_id' => $this->input->post('dealer_id'),
                                                    'user_id'       => $_POST['c_user_name'],
                                                    'user_code'     => $_POST['c_user_code'],
                                                );

                        if( isset( $_POST['c_password'] ) && !empty( $_POST['c_password'] ) ) {
                            $_insert_user_location['password'] = sha1($_POST['c_password']);
                        }

                        $this->FunctionModel->Update($_insert_user_location,'vidiem_dealer_users', ['id' => $counter_user_id ]);
                    } else {
                        $_insert_user_location  = array(
                            'location_id' => $location_id,
                            'dealer_id' => $this->input->post('dealer_id'),
                            'user_id' => $_POST['c_user_name'],
                            'password' => sha1($_POST['c_password']),
                            'open_password' => $_POST['c_password'],
                            'user_code' => $_POST['c_user_code'],
                            'is_admin' => 'no',
                            'is_main_admin' => 'no',
                            'user_type' => 'counter_person'
                        );
                        $this->FunctionModel->Insert($_insert_user_location,'vidiem_dealer_users');
                    }
                   
                }                
                //location against user add ends
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-check");
                $this->session->set_flashdata('head_alert', "Success");
                if( isset( $id ) && !empty( $id ) ) {
                    $this->session->set_flashdata('msg', "Location Updated Successfully.");
                }else{
                    $this->session->set_flashdata('msg', "Location Added Successfully.");
                }
                redirect('dealer-admin/dealers/'.$this->session->userdata('dealer_session')['dealer']['id'].'/location','refresh');
            } else {
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('head_alert', "OOPS");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
                redirect('dealer-admin/locations/add', 'refresh');
            }
        }
    }

    public function delete_status_update()
    {

        $id = $_POST['id'];
        $value = $_POST['value'];
        if($_POST['update_to'] == "delete"){
            $_update_location = array(
                'is_deleted' => $value
            );
        }else{
            $_update_location = array(
                'status' => $value
            );
        }
        return $this->LocationsModel->delete('vidiem_dealer_locations',$_update_location, $id, 'id');

    }
}