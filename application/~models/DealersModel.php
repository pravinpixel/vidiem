<?php
class DealersModel extends CI_Model {

    public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('session');
		$this->load->database();
    }

    function checkDealersLogin() {

        $user_name      = $this->input->post('user_name', true);
        $password       = $this->input->post('password', true);

        $this->db->select( 'vidiem_dealers.dealer_erp_code,vidiem_dealers.image,vidiem_dealers.display_name,vidiem_dealers.vidiem_erp_code,vidiem_dealers.payment_option,vidiem_dealer_locations.location_name,vidiem_dealer_locations.dealer_id,vidiem_dealer_locations.location_code,vidiem_dealer_users.*' )
                    ->join( 'vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_users.dealer_id and vidiem_dealers.status="1"' )
                    ->join('vidiem_dealer_locations', 'vidiem_dealer_locations.ID = vidiem_dealer_users.location_id and vidiem_dealer_locations.status="1"')
                    ->where('vidiem_dealer_users.user_id', $user_name)
                    ->where('vidiem_dealer_users.password', sha1($password));
                    
        $info                           = $this->db->get( 'vidiem_dealer_users');
        
        if( isset( $info ) && $info->num_rows() > 0 ) {
            $info                       = $info->row();
            
            $dealer_session['user']     = array(
                                            'id'            => $info->id,
                                            'user_id'       => $info->user_id,
                                            'user_code'     => $info->user_code,
                                            'is_admin'      => $info->is_admin,
                                            'is_main_admin' => $info->is_main_admin,
                                            'location_id'   => $info->location_id,
                                            'user_type'     => $info->user_type
                                        );
            $dealer_session['location'] = array(
                                            'location_name' => $info->location_name,
                                            'location_address' => $info->location_address,
                                            'location_code' => $info->location_code
                                        );
            $dealer_session['dealer']   = array(
                                            'id'                => $info->dealer_id,
                                            'dealer_erp_code'   => $info->dealer_erp_code,
                                            'display_name'      => $info->display_name,
                                            'vidiem_erp_code'   => $info->vidiem_erp_code,
                                            'payment_option'    => $info->payment_option,
                                            'image'             => $info->image
                                        );

            $var['dealer_session']      = $dealer_session; 
            $this->session->set_userdata($var);

            $query = $this->db->delete( 'vidiem_carts', array('dealer_user_id' => $dealer_session['user']['id']) );

            $error = 1;
            $user_type = $info->user_type;                          
            

        } else {
            $error = 0;
            $user_type = '';
        }
        return array( 'error' => $error, 'user_type' => $user_type );

    }

    function getInfoById( $table, $id ) {
        return $this->db->where('id', $id)->get($table)->row();
    }

    function getDealerInfo($id) {
        
        $details = $this->db->select('vidiem_dealers.*, vidiem_dealer_users.user_id, vidiem_dealer_users.password, vidiem_dealer_users.open_password')
                    ->join('vidiem_dealer_users', 'vidiem_dealer_users.dealer_id = vidiem_dealers.id and vidiem_dealer_users.is_admin="yes"', 'left')
                    ->where('vidiem_dealers.id', $id)
                    ->get('vidiem_dealers');

        if( isset( $details ) && $details->num_rows() > 0 ) {
            return $details->row();
        } else {
            return null;
        }
    }

    function getDealerOrdersAll( $id = null, $from = '' ) {

        $user_type  = $this->session->userdata('dealer_session')['user']['user_type'];
        
        $this->db->select('vidiem_customorder.*,vidiem_dealers.dealer_erp_code, vidiem_dealers.display_name,vidiem_dealer_users.user_id,vidiem_dealer_users.user_code,vidiem_dealer_users.user_type,vidiem_dealer_users.location_id, vidiem_dealer_locations.location_name,vidiem_dealer_locations.location_code,vidiem_dealer_locations.location_address, vidiem_clients.name as client_name,vidiem_clients.mobile_no as client_mobile_no,vidiem_clients.email as client_email')
                ->from('vidiem_customorder')
                ->join('vidiem_dealer_users', 'vidiem_dealer_users.id = vidiem_customorder.dealer_user_id')
                ->join('vidiem_dealer_locations', 'vidiem_dealer_locations.id = vidiem_dealer_users.location_id')
                ->join('vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_locations.dealer_id')
                ->join('vidiem_clients', 'vidiem_clients.id = vidiem_customorder.client_id', 'left')
                ->order_by('vidiem_customorder.id', 'desc');
        if( isset( $user_type) && $user_type == 'admin' ) {
            $this->db->where('vidiem_customorder.dealer_id', $this->session->userdata('dealer_session')['dealer']['id']);
        } else if( $from == 'admin') {

        } else {
            $this->db->where('vidiem_customorder.dealer_location_id', $this->session->userdata('dealer_session')['user']['location_id']);
        }             
        if( isset( $_POST['location_id'] ) && !empty( $_POST['location_id'] ) ) {
            $this->db->where('vidiem_customorder.dealer_location_id', $_POST['location_id'] );
        }   
        if( isset( $_POST['order_status'] ) && !empty( $_POST['order_status'] ) ) { 
            $this->db->where('vidiem_customorder.status', $_POST['order_status'] );
        }
        
 
        if( isset( $_POST['date'] ) && !empty( $_POST['date'] ) ) {
    
            $date               = explode( "-", $_POST['date'] );
            $start_date         = current($date);
            $end_date           = end($date);
            $this->db->group_start();
                $this->db->where( 'DATE(vidiem_customorder.created) >=', date( 'Y-m-d', strtotime($start_date) ) );
                $this->db->where( 'DATE(vidiem_customorder.created) <=', date( 'Y-m-d', strtotime($end_date) ) );
            $this->db->group_end();
            
        }
        if( isset( $_POST['status'] ) && $_POST['status'] == 1 ) {
            //counter condition
            $this->db->where('vidiem_customorder.payment_source', 'counter');
        } else if( isset( $_POST['status'] ) && $_POST['status'] == 2 ) {
            //counter condition
            $this->db->where('vidiem_customorder.payment_source !=', 'counter');
        }

        if( isset( $_POST['payment_status'] ) && !empty($_POST['payment_status']) ) {
            //counter condition
            $this->db->where('vidiem_customorder.payment_status', $_POST['payment_status']);
        } 

        if( $id ) {
            $this->db->where('vidiem_customorder.id', $id);
        } 

        $details = $this->db->get();

        if( isset( $details ) && $details->num_rows() > 0 ) {
            if( isset( $id ) && !empty( $id ) ) {
                return $details->row();
            } else {
                return $details->result();
            }
            
        } else {
            return null;
        }
                
    }

    public function getDealerOrderItemsDetails($order_id)
	{
		 
        $this->db->select("o.inv_code,o.cart_code,op.order_id,op.base_id,op.basetitle,op.basepath,op.baseprice,op.bc_id,op.bc_title,op.basecolorpath,op.basecolorprice,op.motor_id,op.motorname,op.motorbasepath,op.motorprice,op.bm_text_id,op.desktopleft,op.desktoptop,op.textprice,op.canvas_text,op.message_text,op.occasion_text,op.package_id,op.packagename,op.packagebasepath,op.packageprice,cat.name as catname,op.desktopleft,op.desktoptop ");
                                                                                
        $this->db->join('vidiem_customorder  o',' o.id=op.order_id and o.Isactive=1 ');
        $this->db->join('vidiem_category cat',' cat.id=o.category_id and cat.status=1 ');
        $this->db->where(" op.IsActive=1 ");
        $this->db->where(" op.order_id= ".$order_id);        
        return $this->db->get_where(' vidiem_custom_order_products op ')->result();	
	} 

    function getDealerSaleOrdersAll() {

        $user_type  = $this->session->userdata('dealer_session')['dealer']['id'];
        $this->db->select('vidiem_customorder.*,vidiem_dealers.dealer_erp_code, vidiem_dealers.display_name,vidiem_dealer_users.user_id,vidiem_dealer_users.user_code,vidiem_dealer_users.user_type,vidiem_dealer_users.location_id, vidiem_dealer_locations.location_name,vidiem_dealer_locations.location_code,vidiem_dealer_locations.location_address, vidiem_clients.name as client_name,vidiem_clients.mobile_no as client_mobile_no,vidiem_clients.email as client_email')
                ->from('vidiem_customorder')
                ->join('vidiem_dealer_users', 'vidiem_dealer_users.id = vidiem_customorder.dealer_user_id')
                ->join('vidiem_dealer_locations', 'vidiem_dealer_locations.id = vidiem_dealer_users.location_id')
                ->join('vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_locations.dealer_id')
                ->join('vidiem_clients', 'vidiem_clients.id = vidiem_customorder.client_id', 'left')
                ->order_by('vidiem_customorder.id', 'desc');                

        if( isset( $_POST['date'] ) && !empty( $_POST['date'] ) ) {
    
            $date               = explode( "-", $_POST['date'] );
            $start_date         = current($date);
            $end_date           = end($date);
            $this->db->group_start();
                $this->db->where( 'DATE(vidiem_customorder.created) >=', date( 'Y-m-d', strtotime($start_date) ) );
                $this->db->where( 'DATE(vidiem_customorder.created) <=', date( 'Y-m-d', strtotime($end_date) ) );
            $this->db->group_end();
            
        }

        if( isset( $_POST['status'] ) && !empty($_POST['status'] ) ) {
            //counter condition
            $this->db->where('vidiem_customorder.status', $_POST['status']);
        } 
        //counter condition
        $this->db->where('vidiem_customorder.payment_status', 'success');
        
        $details = $this->db->get();

        if( isset( $details ) && $details->num_rows() > 0 ) {
            if( isset( $id ) && !empty( $id ) ) {
                return $details->row();
            } else {
                return $details->result();
            }
            
        } else {
            return null;
        }
                
    }

    public function getDealerLocations($dealer_id)
    {
        $details = $this->db->select('*')->from('vidiem_dealer_locations')->where('dealer_id', $dealer_id)->get();
        if( isset( $details ) && $details->num_rows() > 0 ) {
           
            return $details->result();
            
        } else {
            return null;
        }
    }

    function checkQrDealersLogin() {

        $user_name      = $this->input->get('userid', true);
        $password       = urldecode($this->input->get('password', true) );
        $password = base64_decode($password);
        
        $this->db->select( 'vidiem_dealers.dealer_erp_code,vidiem_dealers.image,vidiem_dealers.display_name,vidiem_dealers.vidiem_erp_code,vidiem_dealers.payment_option,vidiem_dealer_locations.location_name,vidiem_dealer_locations.dealer_id,vidiem_dealer_locations.location_code,vidiem_dealer_users.*' )
                    ->join( 'vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_users.dealer_id and vidiem_dealers.status="1"' )
                    ->join('vidiem_dealer_locations', 'vidiem_dealer_locations.ID = vidiem_dealer_users.location_id and vidiem_dealer_locations.status="1"')
                    ->where('vidiem_dealer_users.user_id', $user_name)
                    ->where('vidiem_dealer_users.password', sha1($password))
                    ->where('vidiem_dealer_users.user_type', 'sale_person');
                    
        $info                           = $this->db->get( 'vidiem_dealer_users');
        
        
        if( isset( $info ) && $info->num_rows() > 0 ) {
            $info                       = $info->row();
            
            $dealer_session['user']     = array(
                                            'id'            => $info->id,
                                            'user_id'       => $info->user_id,
                                            'user_code'     => $info->user_code,
                                            'is_admin'      => $info->is_admin,
                                            'is_main_admin' => $info->is_main_admin,
                                            'location_id'   => $info->location_id,
                                            'user_type'     => $info->user_type
                                        );
            $dealer_session['location'] = array(
                                            'location_name' => $info->location_name,
                                            'location_address' => $info->location_address,
                                            'location_code' => $info->location_code
                                        );
            $dealer_session['dealer']   = array(
                                            'id'                => $info->dealer_id,
                                            'dealer_erp_code'   => $info->dealer_erp_code,
                                            'display_name'      => $info->display_name,
                                            'vidiem_erp_code'   => $info->vidiem_erp_code,
                                            'payment_option'    => $info->payment_option,
                                            'image'             => $info->image
                                        );

            $var['dealer_session']      = $dealer_session; 
            $this->session->set_userdata($var);

            $query = $this->db->delete( 'vidiem_carts', array('dealer_user_id' => $dealer_session['user']['id']) );

            return true;

        } else {
           return false;
        }

    }

    public function getAllDealerUser() {
        $data = $this->db->select('vidiem_dealer_users.*, vidiem_dealers.vidiem_erp_code, vidiem_dealers.display_name, vidiem_dealer_locations.location_name, vidiem_dealer_locations.location_code')
                    ->join('vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_users.dealer_id' )
                    ->join('vidiem_dealer_locations', 'vidiem_dealer_locations.id = vidiem_dealer_users.location_id' )
                    ->where('vidiem_dealer_users.is_active', 1)
                    ->where('vidiem_dealer_users.open_password is NOT NULL', NULL, FALSE)
                    ->get('vidiem_dealer_users');
        
        if( isset( $data ) && !empty( $data ) && count($data) > 0 ) {

        }   
        
    }

}
	