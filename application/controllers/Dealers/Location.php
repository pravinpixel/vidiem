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
        $this->load->view('Backend/dealers/location/index', $data);
    }

    public function add_edit($dealer_id, $id = null)
    {   
        
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
                                'id' => $id
                            );
        $this->load->view('Backend/dealers/location/add_edit_form', $params);
    }

    public function save()
    {

        $id = $this->input->post('id');
        
        $this->form_validation->set_rules('location_name', 'Location Name', 'required');
        $this->form_validation->set_rules('location_code', 'Location Code', 'required|edit_unique[vidiem_dealer_locations.location_code.id.'.$id.']');
        $this->form_validation->set_rules('email', 'Email Id', 'required');
        $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {

            $action_btn     = 'Save';
            $action         = 'Add';

            $params         = array(
                                'action_btn' => $action_btn,
                                'action' => $action
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