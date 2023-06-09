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
        
       $data = $this->db->select('vidiem_dealer_users.*,vidiem_dealers.location_code ,vidiem_dealers.created,vidiem_dealers.dealer_erp_code,vidiem_dealers.vidiem_erp_code, vidiem_dealers.display_name, vidiem_dealer_locations.location_name, vidiem_dealer_locations.location_code')
                    ->join('vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_users.dealer_id and vidiem_dealers.status="1"' )
                    ->join('vidiem_dealer_locations', 'vidiem_dealer_locations.id = vidiem_dealer_users.location_id and vidiem_dealer_locations.status="1"' )
                    ->where('vidiem_dealer_users.user_type', 'sale_person')
                    ->where('vidiem_dealer_users.open_password is NOT NULL', NULL, FALSE)
                    ->get('vidiem_dealer_users');
        $data = $data->result();
        
        if( isset( $data ) && !empty( $data ) && count($data) > 0 ) {
echo <<<THEADER
<style>.url-header td,th {
  border: 1px solid;
  border-collapse: collapse;
  border-spacing: 0;
}</style>
<table class="url-header" border-spacing="0" cell-spacing="0" style="border-collapse: collapse;">
    <tr>
        <th> Ho Name</th>
        <th> Location Name </th>
        <th> Vidiem ERP Code </th>
        <th> Dealer ERP Code </th>
        <th> Location Code </th>
        <th> Url </th>
        <th> Date of Creation </th>
    </tr>
THEADER;
            foreach($data as $items ){
                $password = @base64_encode($items->open_password);
echo <<<HEADER
<tr>
    <td>$items->display_name</td><td>$items->location_name</td><td>$items->vidiem_erp_code</td><td>$items->dealer_erp_code</td><td>$items->location_code</td><td>https://www.vidiem.in/vidiem-dealer/qrlogin?userid=$items->user_id&password=$password</td><td>
    $items->created</td>
</tr>
HEADER;
            }
        }
        
    }
    
    
    /*****Custom Order List  *********/
    
        public function customOrderListHtml()
    {
        
       /*$data = $this->db->select('')
                    ->join('vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_users.dealer_id and vidiem_dealers.status="1"' )
                    ->join('vidiem_dealer_locations', 'vidiem_dealer_locations.id = vidiem_dealer_users.location_id and vidiem_dealer_locations.status="1"' )
                    ->where('vidiem_dealer_users.user_type', 'sale_person')
                    ->where('vidiem_dealer_users.open_password is NOT NULL', NULL, FALSE)
                    ->get('vidiem_dealer_users');
        $data = $data->result();*/
        $data=$this->db->query("SELECT a.`code`, `inv_code`, `cart_code`, `promoter_code`, a.created, `delivery_name`, `delivery_company_name`, `delivery_address`, `delivery_address2`, `delivery_city`, `delivery_zip`, `delivery_state`, `delivery_country`, `delivery_mobile_no`, `delivery_emailid`, `delivery_add_info`, `billing_name`, `billing_company_name`, `billing_address`, `billing_address2`, `billing_city`, `billing_zip`, `billing_state`, `billing_country`, `billing_mobile_no`, `billing_emailid`, `billing_add_info`, `payment_source`, `pg_type`, `bank_ref_num`, `payment_status`, `courier`, `tracking_code`, `notes`, `coupon`, `coupon_type`, `coupon_value`, `sub_total`, `tax`, `discount`, `amount`, case when `status`=5 then 'Order in Process' when `status`=2 then 'Order Shipped' when `status`=3 then 'Order Delivered' when `status`=1 then 'New Order' end as status, `cancel_request`, `cancel_reason`, `cancel_request_date`, `delivered_at`, a.`packageprice`, `receipt_date_time`, `dealer_invoice_date_time`, `vidiem_invoice_date_time`, `ard_service_bill_date_time`, `sub_dealer_service_bill_date_time`, b.`jarname`, d.code AS `jarcode`, e.typeoflidname, f.typeofjarname, g.typeofhandlename, h.capacityname, b.`qty`, b.`price`, c.`basetitle`, c.`baseprice`, c.`bc_title`, c.`basecolorprice`, c.`motorname`, c.`motorprice`, c.`textprice`, c.`canvas_text`, c.`message_text`, c.`occasion_text`, c.`packagename`FROM `vidiem_customorder` AS a JOIN `vidiem_custom_order_jars` AS b ON a.id=b.`order_id`JOIN `vidiem_custom_order_products` AS c ON a.id=c.order_id left JOIN vidiem_jar d ON d.jar_id=b.jar_id left JOIN vidiem_typeoflid e ON e.typeoflid_id=d.typeoflid_id left JOIN vidiem_typeofjar f ON f.typeofjar_id=d.typeofjar_id left JOIN vidiem_typeofhandle g ON g.typeofhandle_id=d.typeofhandle_id left JOIN vidiem_capacity h ON h.capacity_id=d.capacity_id left JOIN vidiem_color i ON i.color_id=d.color_id;");
$data2 = $data->result_array();




    echo '
<style>.url-header td,th {
  border: 1px solid;
  border-collapse: collapse;
  border-spacing: 0;
}</style>
<table class="url-header" border-spacing="0" cell-spacing="0" style="border-collapse: collapse;">
';
$column_name2 = [];
if( $data->row() ) {
    $header = '<thead><tr>';
    foreach($data->row() as $ky => $vl ) {
        
        $name = str_replace('_', ' ', $ky );
        if($name=='created')
        {
         $name='Order Date';   
        }
        $column_name = ucwords( $name );
        $header .= '<th>'.$column_name.'</th>';
      
    }
    $header .= '</tr></thead>';
}
        echo $header;
         
        $tbody = '<tbody>';
        
        $i=0;
       foreach($data2 as $val2 ) {
            $tbody .= '<tr>';
            foreach($data->row() as $ky => $vl ) {
                
                $tbody.= '<td>' . $val2[$ky] . '</td>'; 
            }
             $tbody .= '</tr>';
            $i++;


        }
        $tbody.= '</tbody>';
        echo $tbody;
      
        


        
       
        
    }

}