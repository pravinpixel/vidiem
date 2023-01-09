<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('dbvars',NULL,'Info');
         $this->load->library('pagination');
         $this->load->library('cart');
          $this->load->library('mcapi');
        $this->load->library(array('payumoney'));
        $this->load->model('HomeModel');
        $client_id=$this->session->userdata('client_id');
           $this->session->keep_flashdata('title');
        $this->session->keep_flashdata('msg');
        $this->session->keep_flashdata('type');
        if(empty($client_id)){
            $this->session->set_flashdata('title', "Warning");    
            $this->session->set_flashdata('msg', "Access Denied.");  
            $this->session->set_flashdata('type', "warning");
            redirect('sign-in', 'refresh');
        }  
     
    }
	
	public function index() {
	    
		redirect('user/dashboard');
	}

    // User Dashboad 

    public function Dashboard(){
        //  print_r($_SERVER); exit;
        $data['menu_id']=0;
        $client_id=$this->session->userdata('client_id');
        $data['current_order']=$this->ProjectModel->currentOrder($client_id);
        $data['cancelled_order']=$this->FunctionModel->Select('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success','status'=>4));
        $data['delivered_order']=$this->FunctionModel->Select('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success','status'=>3));
        $this->load->view('dashboard',@$data);  
    }

    public function track_order($order_id=null){
        if(empty($order_id)){ redirect('user/dashboard'); }
        $client_id=$this->session->userdata('client_id');
        $count=$this->FunctionModel->Row_Count('vidiem_order',array('id'=>$order_id,'client_id'=>$client_id));
        if($count==0){ redirect('user/dashboard'); }
        $info=$this->FunctionModel->Select_Fields_Row('courier,tracking_code','vidiem_order',array('id'=>$order_id));
        if(empty($info['courier'])){
            redirect('user/dashboard');
        }
        if($info['courier']==1){
            redirect('https://www.fedex.com/apps/fedextrack/?action=track&tracknumbers='.$info['tracking_code']);
        }else if($info['courier']==2){
            redirect('https://track.aftership.com/india-post/'.$info['tracking_code']);
        }else if($info['courier']==3){
             redirect('http://www.trackcourier.in/track-bluedart.php?cno='.$info['tracking_code']);
        }else if($info['courier']==4){
             redirect('https://track24.net/service/DTDC/tracking/'.$info['tracking_code']);
        }else if($info['courier']==5){
             redirect('http://www.stcourier.com/cgi_bin/show_status1.php?awb='.$info['tracking_code']);
        }
    }

    public function Settings(){
        $data['menu_id']=0;
        $role=$this->input->post('role');
        if($role !=2){
            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('dob','DOB','required');
            $this->form_validation->set_rules('password','Password','callback_password');
            $this->form_validation->set_rules('confirm_password','Confirm Password','matches[password]');
            if($this->form_validation->run()==TRUE){
                $InsertData=array(
                    'name'         => $this->input->post('name'),
                    'gender'       => $this->input->post('gender'),
                    'dob'          => $this->input->post('dob'),
                    'newsletter'   => $this->input->post('newsletter'),
                    'special_offer'=> $this->input->post('special_offer'),
                    'modified'     => date('Y-m-d H:i:s')
                );
                $password=$this->input->post('password');
                if(!empty($password)){
                    $InsertData['password']=md5($this->input->post('password'));
                }
                $client_id=$this->session->userdata('client_id');
                $this->FunctionModel->Update($InsertData,'vidiem_clients',array('id'=>$client_id));
                $newsletter=$this->input->post('newsletter');
                $special_offer=$this->input->post('special_offer');
                $emailAddress=$this->FunctionModel->Select_Field('email','vidiem_clients',array('id'=>$client_id));
                if($newsletter==1){
                    $retval = $this->mcapi->listSubscribe($this->dbvars->newsletter_id, $emailAddress,'NULL','html',false); 
                }else{
                    $retval = $this->mcapi->listUnsubscribe($this->dbvars->newsletter_id, $emailAddress,true); 
                }
    
                 if($special_offer==1){
                    $retval = $this->mcapi->listSubscribe($this->dbvars->offer_letter_id, $emailAddress,'NULL','html',false); 
                }else{
                    $retval = $this->mcapi->listUnsubscribe($this->dbvars->offer_letter_id, $emailAddress,true); 
                }
    
                $this->session->set_flashdata('title', "Success");   
                $this->session->set_flashdata('msg', "Information Updated Successfully.");     
                $this->session->set_flashdata('type', "success");
                redirect('user/dashboard', 'refresh');
            }
            $client_id=$this->session->userdata('client_id');
            $data['Edit_Result']=$this->FunctionModel->Select_Fields_Row('name,mobile_no,email,gender,dob,newsletter,special_offer,role','vidiem_clients',array('id'=>$client_id));
            $this->load->view('settings',@$data);
        }
        
        if($role ==2){
           $this->form_validation->set_rules('rname','Name','required');
           $this->form_validation->set_rules('rpassword','Password','callback_guestpassword');
           $this->form_validation->set_rules('rconfirm_password','Confirm Password','matches[rpassword]');
            if($this->form_validation->run()==TRUE){
                $InsertData=array(
                    'name'         => $this->input->post('rname'),
                    'modified'     => date('Y-m-d H:i:s')
                );
                $password=$this->input->post('rpassword');
                if(!empty($password)){
                    $InsertData['password']=md5($password);
                }
                $client_id=$this->session->userdata('client_id');
                $this->FunctionModel->Update($InsertData,'vidiem_clients',array('id'=>$client_id));
                /*$newsletter=$this->input->post('newsletter');
                $special_offer=$this->input->post('special_offer');
                $emailAddress=$this->FunctionModel->Select_Field('email','vidiem_clients',array('id'=>$client_id));
                if($newsletter==1){
                    $retval = $this->mcapi->listSubscribe($this->dbvars->newsletter_id, $emailAddress,'NULL','html',false); 
                }else{
                    $retval = $this->mcapi->listUnsubscribe($this->dbvars->newsletter_id, $emailAddress,true); 
                }
    
                 if($special_offer==1){
                    $retval = $this->mcapi->listSubscribe($this->dbvars->offer_letter_id, $emailAddress,'NULL','html',false); 
                }else{
                    $retval = $this->mcapi->listUnsubscribe($this->dbvars->offer_letter_id, $emailAddress,true); 
                }*/
    
                $this->session->set_flashdata('title', "Success");   
                $this->session->set_flashdata('msg', "Information Updated Successfully.");     
                $this->session->set_flashdata('type', "success");
                redirect('user/dashboard', 'refresh');
            }
            $client_id=$this->session->userdata('client_id');
            $data['Edit_Result']=$this->FunctionModel->Select_Fields_Row('name,mobile_no,email,gender,dob,newsletter,special_offer,role','vidiem_clients',array('id'=>$client_id));
            $this->load->view('settings',@$data);
        }
        
        
    }

    function password(){
        $password=$this->input->post('password');
        if(empty($password)){ return true;}
        $length=strlen($password);
        if($length<6){
            $this->form_validation->set_message('password','Password need atleast 6 characters');
            return false;
        }
        if($length>16){
            $this->form_validation->set_message('password','Password need atleast 16 characters');
            return false;
        }
        return true;
    }
    
    function guestpassword(){
        $password=$this->input->post('rpassword');
       // print_r($password);exit;
        if(empty($password)){ return true;}
        $length=strlen($password);
        if($length<6){
            $this->form_validation->set_message('password','Password need atleast 6 characters');
            return false;
        }
        if($length>16){
            $this->form_validation->set_message('password','Password need atleast 16 characters');
            return false;
        }
        return true;
    }

    function email_validation(){
        return true;
    }

    function mobile_no_validation(){

    }

    public function Address(){
        $data['menu_id']=0;
        $client_id=$this->session->userdata('client_id');
        $data['shipping_address']=$this->FunctionModel->Select('vidiem_clients_address',array('client_id'=>$client_id,'type'=>1));
        $data['billing_address']=$this->FunctionModel->Select('vidiem_clients_address',array('client_id'=>$client_id,'type'=>2));
        $this->load->view('address',@$data);
    }

    public function CreditSlips(){
        $data['menu_id']=0;
        $this->load->view('credit_slips',@$data);
    }

    public function add_address($redirect=null){
        $data['menu_id']=0;
        $data['type']=$this->input->get('type');
        $data['shipping_id']=$this->input->get('shipping_id');
        $data['billing_id']=$this->input->get('billing_id');
        $data['same']=$this->input->get('same');
        $client_id=$this->session->userdata('client_id');
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('address','Address','required');
        $this->form_validation->set_rules('zip_code','Zip Code','required');
        $this->form_validation->set_rules('city','City','required');
        $this->form_validation->set_rules('state','State','required');
        $this->form_validation->set_rules('mobile_no','Mobile No.','required');
		$this->form_validation->set_rules('emailid','Email','required');
        $this->form_validation->set_rules('title','Address Title','required');
        if($this->form_validation->run()===true){
            $InsertData=array(
                'client_id'      => $this->session->userdata('client_id'),
                'title'          => $this->input->post('title'),
                'name'           => $this->input->post('name'),
                'type'           => $this->input->post('type'),
                'company_name'   => $this->input->post('company_name'),
                'address'        => $this->input->post('address'),
                'address2'       => $this->input->post('address2'),
                'city'           => $this->input->post('city'),
                'zip_code'       => $this->input->post('zip_code'),
                'state'          => $this->input->post('state'),
                'country'        => $this->input->post('country'),
                'mobile_no'      => $this->input->post('mobile_no'),
				'emailid'      => $this->input->post('emailid'),
                'add_information'=> $this->input->post('add_information'),
                'created'        => date('Y-m-d H:i:s')
            );
            $tmp_id=$this->FunctionModel->Insert($InsertData,'vidiem_clients_address');
            if(empty($redirect)){
                redirect('user/address');
            }else{
                $ship_id=$this->input->post('shipping_id');
                $bill_id=$this->input->post('billing_id');
                $type=$this->input->post('type');
                if($type==1){
                   $ship_id=$tmp_id;
                }else{
                   $bill_id=$tmp_id;
                }
                $same=$this->input->post('same');
                redirect('checkout?type='.$type.'&shipping_id='.$ship_id.'&billing_id='.$bill_id.'&same='.$same);
            }
        }
        $this->load->view('add-address',@$data);
    }

    public function edit_address($id=null,$redirect=null){
        $data['menu_id']=0;
        $client_id=$this->session->userdata('client_id');
        if(empty($id)){ redirect('user/address');}
        $count=$this->FunctionModel->Row_Count('vidiem_clients_address',array('id'=>$id,'client_id'=>$client_id));
        if($count==0){ redirect('user/address');}
        $data['shipping_id']=$this->input->get('shipping_id');
        $data['billing_id']=$this->input->get('billing_id');
        $data['same']=$this->input->get('same');
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('address','Address','required');
        $this->form_validation->set_rules('zip_code','Zip Code','required');
        $this->form_validation->set_rules('city','City','required');
        $this->form_validation->set_rules('state','State','required');
        $this->form_validation->set_rules('mobile_no','Mobile No.','required');
		$this->form_validation->set_rules('emailid','Email','required');
        $this->form_validation->set_rules('title','Address Title','required');
        if($this->form_validation->run()===true){
            $UpdateData=array(
                'client_id'      => $this->session->userdata('client_id'),
                'title'          => $this->input->post('title'),
                'name'           => $this->input->post('name'),
                'company_name'   => $this->input->post('company_name'),
                'address'        => $this->input->post('address'),
                'address2'       => $this->input->post('address2'),
                'city'           => $this->input->post('city'),
                'zip_code'       => $this->input->post('zip_code'),
                'state'          => $this->input->post('state'),
                'country'        => $this->input->post('country'),
                'mobile_no'      => $this->input->post('mobile_no'),
				'emailid'      => $this->input->post('emailid'),
                'add_information'=> $this->input->post('add_information'),
                'modified'        => date('Y-m-d H:i:s')
            );
            $this->FunctionModel->Update($UpdateData,'vidiem_clients_address',array('id'=>$id));
            if(empty($redirect)){
                redirect('user/address');
            }else{
                $ship_id=$this->input->post('shipping_id');
                $bill_id=$this->input->post('billing_id');
                $same=$this->input->post('same');
                redirect('checkout?shipping_id='.$ship_id.'&billing_id='.$bill_id.'&same='.$same);
            }
        }
        $data['Edit_Info']=$this->FunctionModel->Select_Row('vidiem_clients_address',array('id'=>$id));
        $this->load->view('edit-address',@$data);
    }

    public function delete_address($id=null){
        if(empty($id)){ redirect('user/address'); }
        $client_id=$this->session->userdata('client_id');
        $count=$this->FunctionModel->Row_Count('vidiem_clients_address',array('client_id'=>$client_id,'id'=>$id));
        if($count==0){redirect('user/address');}
        $this->FunctionModel->Delete('vidiem_clients_address',array('id'=>$id));
        $this->session->set_flashdata('title', "Success");   
        $this->session->set_flashdata('msg', "Address Deleted Successfully.");     
        $this->session->set_flashdata('type', "success");
        redirect('user/address', 'refresh');
    }
	
	  public function customdashboard(){
        $data['menu_id']=0;
        $client_id=$this->session->userdata('client_id');
        $data['current_order']=$this->CustomizeModel->customcurrentOrder($client_id);
	
        $data['cancelled_order']=$this->FunctionModel->Select('vidiem_customorder',array('client_id'=>$client_id,'payment_status'=>'success','status'=>4));
        $data['delivered_order']=$this->FunctionModel->Select('vidiem_customorder',array('client_id'=>$client_id,'payment_status'=>'success','status'=>3));
			
        $this->load->view('customdashboard',@$data);  
    }
	
	 public function test(){
		 echo "vvv";
		 die();
	 }

}