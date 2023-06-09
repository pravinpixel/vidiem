<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer extends CI_Controller {

    function __construct() {
		
        parent::__construct();
        $this->load->library('dbvars',NULL,'Info');
        $this->load->library('pagination');
        $this->load->library('cart');
        $this->load->library('google');
        $this->load->library('facebook');
        $this->load->library(array('payumoney'));
		$this->load->library(array('razorpay'));
        $this->load->model('HomeModel');
        $this->load->model('DealersModel');
        $this->session->keep_flashdata('title');
        $this->session->keep_flashdata('msg');
        $this->session->keep_flashdata('type');
		
    }

    public function index()
    {
        
        if(empty($this->session->userdata('dealer_session'))){
			redirect('vidiem-dealer/login');
		}	
        if( $this->session->userdata('dealer_session')['user']['user_type'] != 'sale_person' && !empty( $this->session->userdata('dealer_session')['user']['user_type'] )  ) {
            redirect('dealer-admin');
        }	
        
        $data       = array(
                        'title' => 'Vidiem Dealer ',
                        'menu_id' => 0
                    );
        $this->load->view('dealer/dashboard/index', $data);
        
    }

    public function login()
    {
        
        if(!empty($this->session->userdata('dealer_session')) && $this->session->userdata('dealer_session')['user_type'] == 'sale_person'){
			redirect('vidiem-dealer');
		} else if( $this->session->userdata('dealer_session')['user']['user_type'] != 'sale_person' && !empty( $this->session->userdata('dealer_session')['user']['user_type'] )  ) {
            redirect('dealer-admin');
        }	 
        
        $data       = array(
                        'title' => 'Dealer Login',
                        'menu_id' => 0
                    );
        $this->load->view('dealer/login', $data);
        
    }

    public function logout()
    {
        $this->session->unset_userdata('dealer_session');
        $this->session->unset_userdata('previous_url');
        $this->session->unset_userdata('client_id');
        $this->session->unset_userdata('client_name');
        $this->session->unset_userdata('userData');
        $this->session->unset_userdata('loggedIn');
       
        redirect('vidiem-dealer/login');
    }

    public function doDealerLogin()
    {
        
        $response       = [];
        $check          = $this->DealersModel->checkDealersLogin();
        if( isset( $check ) && $check['error'] == 1 ) {
            $response   = array( 'status' => 1, 'message' => 'Login Success', 'user_type' => $check['user_type'] );
        } else {
            $response   = array( 'status' => 0, 'message' => 'Login Failed. Invalid credentials!', );
        }
        echo json_encode( $response );

    }

    public function doDealerLogout(){
		$this->session->unset_userdata('dealer_session');
        redirect('vidiem-dealer', 'refresh');
    }

    public function passwordLinkList()
    {
        
       $data = $this->db->select('vidiem_dealer_users.*, vidiem_dealers.vidiem_erp_code, vidiem_dealers.display_name, vidiem_dealer_locations.location_name, vidiem_dealer_locations.location_code')
                    ->join('vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_users.dealer_id and vidiem_dealers.status="1"' )
                    ->join('vidiem_dealer_locations', 'vidiem_dealer_locations.id = vidiem_dealer_users.location_id and vidiem_dealer_locations.status="1"' )
                    ->where('vidiem_dealer_users.user_type', 'sale_person')
                    ->where('vidiem_dealer_users.open_password is NOT NULL', NULL, FALSE)
                    ->get('vidiem_dealer_users');
        $data = $data->result();
        
        if( isset( $data ) && !empty( $data ) && count($data) > 0 ) {
echo <<<THEADER

<table class="url-header" border-spacing="0" cell-spacing="0" style="border-collapse: collapse;">
    <tr>
        <th> Ho Name</th>
        <th> Location Name </th>
        <th> Customer Code </th>
        <th> Url </th>
    </tr>
THEADER;
            foreach($data as $items ){
                $password = @base64_encode($items->open_password);
echo <<<HEADER
<tr>
    <td>$items->display_name</td><td>$items->location_name</td><td>$items->vidiem_erp_code</td><td>https://www.vidiem.in/vidiem-dealer/qrlogin?userid=$items->user_id&password=$password</td>
</tr>
HEADER;
            }
        }
        
    }

}