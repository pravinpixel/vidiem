<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dealer_management extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->model(array('Accessmodel', 'DealersModel', 'LocationsModel'));
        $this->load->library('slug');
        if( !$this->session->userdata( 'user_logged_in' ) ) {
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}
    }

    public function index()
    {
		
        if(hasPermission('dealer_management_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['details']             = $this->FunctionModel->Select('vidiem_dealers');
		$this->load->view('Backend/dealer_management/list',$data);

    }

	public function add($id = null)
	{
		if(hasPermission('dealer_management_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$action_btn         = 'Save';
        $action             = 'Add';
        $info               = '';
		if( !empty( $id ) ) {
            $info           = $this->DealersModel->getDealerInfo($id);
            $action_btn     = 'Save';
            $action         = 'Update';
        }
        
        $params             = array(
								'action_btn' => $action_btn,
								'action' => $action,
                                'info' => $info ?? ''
                            );
		
	   	$this->load->view('Backend/dealer_management/add_edit',@$params);
	}

	public function save()
	{
		$id = $this->input->post('id');
        $this->form_validation->set_rules('dealer_erp_code', 'Dealer ERP Code', 'required|edit_unique[vidiem_dealers.dealer_erp_code.id.'.$id.']');
        $this->form_validation->set_rules('vidiem_erp_code', 'Vidiem ERP Code', 'required');
        $this->form_validation->set_rules('location_code', 'Location Code', 'required');
        $this->form_validation->set_rules('display_name', 'Display Name', 'required');
        $this->form_validation->set_rules('logo', 'Logo', 'callback_file_selected_test');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('district', 'District', 'required');
        $this->form_validation->set_rules('post_code', 'Post Code', 'required');

        if ($this->form_validation->run() == FALSE)
        {

            $action_btn     = 'Save';
            $action         = 'Add';

            $params         = array(
                                'action_btn' => $action_btn,
                                'action' => $action
                            );
            $this->load->view('Backend/dealer_management/add_edit', $params);

        } else {

            /***
             *  check data already exist in vidiem_dealer_locations
             */
            $InsertData     = array(

                                'dealer_erp_code'   => $this->input->post('dealer_erp_code'),
                                'vidiem_erp_code'   => $this->input->post('vidiem_erp_code'),
                                'location_code'     => $this->input->post('location_code'),
                                'display_name'      => $this->input->post('display_name'),
                                'payment_option'    => implode(',', $this->input->post('payment_option[]') ),
                                'contact_person'    => $this->input->post('contact_person'),
                                'phone'             => $this->input->post('phone'),
                                'email'             => $this->input->post('email'),                                
                                'address'           => $this->input->post('address'),
                                'area'              => $this->input->post('area'),
                                'city'              => $this->input->post('city'),
                                'district'          => $this->input->post('district'),
                                'state'             => $this->input->post('state'),
                                'country'           => $this->input->post('country'),
                                'post_code'         => $this->input->post('post_code'),
                                'gstin_no'         => $this->input->post('gstin_no'),
                                'bank_ac_no'         => $this->input->post('bank_ac_no'),
                                'ifsc_code'         => $this->input->post('ifsc_code'),
                                'bank_name'         => $this->input->post('bank_name'),
                                'status'            => '1',
                                
                            );
          
            
            if( isset( $this->upload_data['logo']['file_name'] ) && !empty( $this->upload_data['logo']['file_name'] ) ) {
                $InsertData['image']        = $this->upload_data['logo']['file_name'];
            }
            if( isset( $id ) && !empty( $id ) ) {

                $result                         = $this->FunctionModel->Update($InsertData,'vidiem_dealers', ['id' => $id]);

                $_insert_user_location          = array(
                                                    'user_id' => $this->input->post('email'),
                                                    'dealer_id' => $id
                                                );

                if( $this->input->post('password') ) {
                    $_insert_user_location['password'] = sha1($this->input->post('password'));
                }
                $result                         = $this->FunctionModel->Update($_insert_user_location,'vidiem_dealer_users', ['user_id' => $this->input->post('email')]);
                $result = 1;
            } else {
                $InsertData['created' ]         = date('Y-m-d H:i:s');
                $result                         = $this->FunctionModel->Insert($InsertData,'vidiem_dealers');
                $dealer_id                      = $result;

                $_insert_user_location          = array(
                                                    'user_id' => $this->input->post('email'),
                                                    'is_admin' => 'yes',
                                                    'user_type' => 'admin',
                                                    'is_active' => 1,
                                                    'dealer_id' => $dealer_id
                                                );

                if( $this->input->post('password') ) {
                    $_insert_user_location['password']          = sha1($this->input->post('password'));
                }
                $this->FunctionModel->Insert($_insert_user_location,'vidiem_dealer_users');

                /***
                 * insert in location table
                 */

                 $InsertLocData     = array(
                    'dealer_id'         => $dealer_id,
                    'location_name'     => $this->input->post('location_code'),
                    'location_code'     => $this->input->post('location_code'),
                    'location_address'  => $this->input->post('address'),
                    'area'              => $this->input->post('area'),
                    'city'              => $this->input->post('city'),
                    'district'          => $this->input->post('district'),
                    'state'             => $this->input->post('state'),
                    'post_code'         => $this->input->post('post_code'),
                    'status'            => '1',    
                    'is_primary'        => 1 ,
                    'created_at'        => date('Y-m-d H:i:s')
                );

                $location_id            = $this->FunctionModel->Insert($InsertLocData,'vidiem_dealer_locations');

                $loc_up                         = array(
                                                        'location_id' => $location_id,
                                                    );

                $this->FunctionModel->Update($loc_up,'vidiem_dealer_users', ['user_id' => $this->input->post('email')]);
                
            }

            if( $result >= 1 ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-check");
                $this->session->set_flashdata('msg', "Dealers Added Successfully.");
                redirect('Admin/dealer_management','refresh');
            } else {
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
                redirect('Admin/dealer_management/add/'.$id, 'refresh');

            }
            
        }
	}

	public function status($id, $status)
    {
        $updateData     = array('status' => $status );      
        $result         = $this->FunctionModel->Update($updateData,'vidiem_dealers', ['id' => $id]);
        if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Status Successfully Updated.");
			redirect('Admin/dealer_management','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/dealer_management', 'refresh');
        endif;
    }

    public function delete($id)
    {
        
        $result         = $this->FunctionModel->Delete('vidiem_dealers', ['id' => $id]);
        if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Deleted Successfully Updated.");
			redirect('Admin/dealer_management','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('Admin/dealer_management', 'refresh');
        endif;

    }

	public function file_selected_test(){

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
            return false;
        }
    }

    public function file_selected_dynamic( $image, $param ) {
        
        $file_name              = $param;

        $allowed_mime_type_arr  = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime                   = get_mime_by_extension($_FILES[$file_name]['name']);
        
        if( isset($_FILES[$file_name]['name']) && $_FILES[$file_name]['name']!="" ) {

            if( in_array( $mime, $allowed_mime_type_arr ) ) {

                if( $_FILES[$file_name]['size'] != 0 ) {
                    $upload_dir = './uploads/dealer/orders';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir);
                    }
                    if(file_exists($upload_dir.'/'.$_FILES[$param]['name'])){
                            list($file_name)=explode('.',$_FILES[$param]['name']);
                            $file_name = $file_name.'_'.substr(md5(rand()),0,5);
                    } else {
                        list($file_name)=explode('.',$_FILES[$param]['name']);
                    }
                    $config['upload_path']   = $upload_dir;
                    $config['allowed_types'] = '*';
                    $config['file_name']     = $param;
                    $config['overwrite']     = false;
                    $config['max_size']	     = '5120';
            
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload($param)){
                        
                        $this->form_validation->set_message('file_selected_dynamic', $this->upload->display_errors('<p class=error>','</p>'));
                        return false;
                    }
                    else{
                        $this->upload_data[$param] =  $this->upload->data();
                        return true;
                    }
                }

                return true;
            } else {
                $this->form_validation->set_message('file_selected_test', 'Please select only gif/jpg/png file.');
                return false;
            }

        }
        return true;

    }

	public function location_index($dealer_id)
	{
		$data['details']    = $this->LocationsModel->getLocation($dealer_id);
        $data['dealer_id']  = $dealer_id;
        $this->load->view('Backend/dealer_management/location_list', $data);
	}

	public function location_add($dealer_id, $id = null )
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
        $this->load->view('Backend/dealer_management/location_add_edit', $params);
	}

	public function location_save()
	{
		$id 			= $this->input->post('id');
		$dealer_id 		= $this->input->post('dealer_id');
        
        $this->form_validation->set_rules('location_name', 'Location Name', 'required');
        $this->form_validation->set_rules('location_code', 'Location Code', 'required|edit_unique[vidiem_dealer_locations.location_code.id.'.$id.']');
        $this->form_validation->set_rules('email', 'Email id', 'required');
        $this->form_validation->set_rules('mobile_no', 'Mobile No', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {

            $action_btn     = 'Save';
            $action         = 'Add';

            $params         = array(
                                'action_btn' => $action_btn,
                                'action' => $action
                            );
            $this->load->view('Backend/dealer_management/location_add_edit', $params);

        } else {

            /***
             *  check data already exist in vidiem_dealer_locations
             */
            $InsertData     = array(
								'dealer_id'         => $this->input->post('dealer_id'),
								'location_name'     => $this->input->post('location_name'),
								'location_code'     => $this->input->post('location_code'),
                                'dealer_erp_code'   => $this->input->post('dealer_erp_code'),
                                'vidiem_erp_code'   => $this->input->post('vidiem_erp_code'),
								'location_address'  => $this->input->post('address'),
								'area'              => $this->input->post('area'),
								'email'             => $this->input->post('email'),
								'mobile_no'         => $this->input->post('mobile_no'),
								'city'              => $this->input->post('city'),
								'district'          => $this->input->post('district'),
								'state'             => $this->input->post('state'),
								'post_code'         => $this->input->post('post_code'),
								'status'            => '1',                            
							);

            if( isset( $id ) && !empty( $id ) ) {
                $InsertData['updated_at' ]      = date('Y-m-d H:i:s');
                $this->FunctionModel->Update($InsertData,'vidiem_dealer_locations', ['id' => $id]);
                $result = $location_id = $id;
            } else {
                $InsertData['created_at' ]      = date('Y-m-d H:i:s');
                $result                         = $this->FunctionModel->Insert($InsertData,'vidiem_dealer_locations');
                $location_id = $this->db->insert_id();
            }
            if( $result >= 1 ) {

                //location against user add stars
                if(isset($_POST['s_user_name']) && !empty($_POST['s_user_name'])) {

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
                        }

                        $this->FunctionModel->Update($_insert_user_location,'vidiem_dealer_users', ['id' => $sale_user_id ]);
                    } else {
                        $_insert_user_location     = array(
                            'location_id' => $location_id,
                            'dealer_id' => $this->input->post('dealer_id'),
                            'user_id' => $_POST['s_user_name'],
                            'password' => sha1($_POST['s_password']),
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

                        $insert_user  = array(
                            'location_id' => $location_id,
                            'dealer_id' => $this->input->post('dealer_id'),
                            'user_id' => $_POST['c_user_name'],
                            'user_code' => $_POST['c_user_code'],
                            
                        );

                        if( isset( $_POST['c_password'] ) && !empty( $_POST['c_password'] ) ) {
                            $insert_user['password'] = sha1($_POST['c_password']);
                        }

                        $this->FunctionModel->Update($insert_user,'vidiem_dealer_users', ['id' => $counter_user_id ]);
                    } else {
                        $insert_user  = array(
                            'location_id' => $location_id,
                            'dealer_id' => $this->input->post('dealer_id'),
                            'user_id' => $_POST['c_user_name'],
                            'password' => sha1($_POST['c_password']),
                            'user_code' => $_POST['c_user_code'],
                            'is_admin' => 'no',
                            'is_main_admin' => 'no',
                            'user_type' => 'counter_person'
                        );
                        $this->FunctionModel->Insert($insert_user,'vidiem_dealer_users');
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
                redirect('Admin/dealer_management/'.$dealer_id.'/location','refresh');
            } else {
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('head_alert', "OOPS");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
                redirect('Admin/dealer_management/'.$dealer_id.'/location/add', 'refresh');
            }
        }
	}

	public function location_delete_status_update($dealer_id, $location_id)
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