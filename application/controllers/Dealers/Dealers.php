<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealers extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation', 'upload');
        $this->load->model('DealersModel');
        if( $this->session->userdata('dealer_session')['user']['user_type'] == 'sale_person' ) {
            redirect('vidiem-dealer');
        }

    }

    public function index()
    {
        
       
        $data['details']    = $this->FunctionModel->Select('vidiem_dealers');
        
        
        $this->load->view('Backend/dealers/dealer/index', $data);

    }

    public function add_edit($id = null)
    {
        
        $action_btn         = 'Save';
        $action             = 'Add';
        $info               = '';

        if( !empty( $id ) ) {

            $info           = $this->DealersModel->getInfoById('vidiem_dealers', $id);
            $action_btn     = 'Save';
            $action         = 'Update';

        }
        
        $params             = array(
                                'action_btn' => $action_btn,
                                'action' => $action,
                                'info' => $info
                            );
        $this->load->view('Backend/dealers/dealer/add_edit_form', $params);
    }

    public function save()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('dealer_erp_code', 'Dealer ERP Code', 'required|edit_unique[vidiem_dealers.dealer_erp_code.id.'.$id.']');
        $this->form_validation->set_rules('vidiem_erp_code', 'Vidiem ERP Code', 'required');
        $this->form_validation->set_rules('location_code', 'Location Code', 'required');
        $this->form_validation->set_rules('display_name', 'Display Name', 'required');
        $this->form_validation->set_rules('logo', 'Logo', 'callback_file_selected_test');
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
            $this->load->view('Backend/dealers/dealer/add_edit_form', $params);

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
                                'address'           => $this->input->post('address'),
                                'area'              => $this->input->post('area'),
                                'city'              => $this->input->post('city'),
                                'district'          => $this->input->post('district'),
                                'state'             => $this->input->post('state'),
                                'country'           => $this->input->post('country'),
                                'post_code'         => $this->input->post('post_code'),
                                'status'            => '1',
                                
                            );
            
            if( isset( $this->upload_data['logo']['file_name'] ) && !empty( $this->upload_data['logo']['file_name'] ) ) {
                $InsertData['image']        = $this->upload_data['logo']['file_name'];
            }
            if( isset( $id ) && !empty( $id ) ) {
                $result                         = $this->FunctionModel->Update($InsertData,'vidiem_dealers', ['id' => $id]);
            } else {
                $InsertData['created' ]         = date('Y-m-d H:i:s');
                $result                         = $this->FunctionModel->Insert($InsertData,'vidiem_dealers');
            }

            if( $result >= 1 ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-check");
                $this->session->set_flashdata('msg', "Dealers Added Successfully.");
                redirect('dealer-admin/dealers','refresh');
            } else {
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
                redirect('dealer-admin/dealers/add', 'refresh');
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
			redirect('dealer-admin/dealers','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('dealer-admin/dealers', 'refresh');
        endif;
    }

    public function delete($id)
    {
        
        $result         = $this->FunctionModel->Delete('vidiem_dealers', ['id' => $id]);
        if ($result == 1) :
        	$this->session->set_flashdata('class', "alert-success");
			$this->session->set_flashdata('icon', "fa-check");
			$this->session->set_flashdata('msg', "Deleted Successfully Updated.");
			redirect('dealer-admin/dealers','refresh');
        else :
        	$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
        	redirect('dealer-admin/dealers', 'refresh');
        endif;
    }

    public function logout()
    {
        $this->session->unset_userdata('dealer_session');
        redirect('vidiem-dealer/login');
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

        $allowed_mime_type_arr  = array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
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
                    if (!$this->upload->do_upload($param)) {
                        
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

    public function cancelOrder()
    {

        $order_id           = $this->input->post('order_id');
        $cancel_reason      = $this->input->post('cancel_reason');
        
        $UpdateData         = array(
                                'status'    => 4,
                                'modified'  => date('Y-m-d H:i:s'),
                                'cancel_reason' => $cancel_reason
                            );

        $this->FunctionModel->Update($UpdateData,'vidiem_customorder',array('id'=>$order_id));
     
        $this->session->set_flashdata('class', "alert-success");
        $this->session->set_flashdata('icon', "fa-check");
        $this->session->set_flashdata('msg', "Order Successfully cancelled.");
        
        echo json_encode(['error' => 1]);

    }

    public function doCounterPayment()
    {

        $this->form_validation->set_rules('receipt_no', 'Display Name', 'required');
        $this->form_validation->set_rules('promoter_code', 'Promoter Code', 'required');
        $this->form_validation->set_rules('receipt', 'Receipt', 'callback_file_selected_dynamic[receipt]');
        $this->form_validation->set_rules('dealer_invoice', 'Dealer Invoice', 'callback_file_selected_dynamic[dealer_invoice]');
        $this->form_validation->set_rules('vidiem_invoice', 'Vidiem Invoice', 'callback_file_selected_dynamic[vidiem_invoice]');

        if ($this->form_validation->run() == FALSE)
        {
            $error_message  = validation_errors();
            $status         = 0;
        } else {
            /***
             *  check data already exist in vidiem_dealer_locations
             */
            $id                                     = $this->input->post('id', true);
            $order_id                               = $this->input->post('order_id');
            $receipt_no                             = $this->input->post('receipt_no');
            $promoter_code                          = $this->input->post('promoter_code');

            $InsertData                             = array(
                                                        'promoter_code'     => $this->input->post('promoter_code'),
                                                        'pg_type'           => $this->input->post('receipt_no'),
                                                        'payment_status'    => 'success',
                                                        'modified'          => date('Y-m-d H:i:s')
                                                    );
            $code                                   = $this->FunctionModel->Select_Fields('inv_code,pg_type','vidiem_customorder',array('id'=>$id),'inv_code','DESC',1);
            
            if( empty( $code ) ) {
                $InsertData['inv_code']             = $this->CustomizeModel->CustomInvoiceCode();
            }

            if( isset( $this->upload_data['receipt']['file_name'] ) && !empty( $this->upload_data['receipt']['file_name'] ) ) {
                $InsertData['receipt_file']         = $this->upload_data['receipt']['file_name'];
            }
            if( isset( $this->upload_data['dealer_invoice']['file_name'] ) && !empty( $this->upload_data['dealer_invoice']['file_name'] ) ) {
                $InsertData['dealer_invoice']       = $this->upload_data['dealer_invoice']['file_name'];
            }
            if( isset( $this->upload_data['vidiem_invoice']['file_name'] ) && !empty( $this->upload_data['vidiem_invoice']['file_name'] ) ) {
                $InsertData['vidiem_invoice']       = $this->upload_data['vidiem_invoice']['file_name'];
            }
            
            $result                                 = $this->FunctionModel->Update($InsertData,'vidiem_customorder', ['id' => $id]);

            if( isset( $code['pg_type'] ) && empty($code['pg_type']) ) {
                //do actions
            } else {
                $this->CustomizeModel->Custom_NewOrderNotification($id);  
                $this->CustomizeModel->CustomOrderInvoicing($id); 
            }
            
            $this->session->set_flashdata('title', "Thank You");     
            $this->session->set_flashdata('msg', "Payment is successful and You will receive email from our side further instrucions.");     
            $this->session->set_flashdata('type', "success");  
            $error_message = 'Updated successfully';

            if( $result >= 1 ) {

                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-check");
                $this->session->set_flashdata('msg', "Dealers Order Payment paid Successfully.");
                
                $status = 1;

            } else {

                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
                $status = 0;
            }

        }

        echo json_encode(['status' => $status, 'error_message' => $error_message ]);        
        
    }

    
}