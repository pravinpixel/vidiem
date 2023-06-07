<?php
class TrackingModel extends CI_Model {

    public function __construct() {
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('session');
		$this->load->database();
    }

    public function getCustomerOrder( $invoice_no, $email ) 
    {
        $this->db->select('vidiem_customorder.*, vidiem_clients.name as client_name')
                            ->join('vidiem_clients', 'vidiem_clients.id = vidiem_customorder.client_id', 'left');
        $this->db->group_start(); 
            $this->db->where('inv_code', $invoice_no );
            $this->db->or_where('order_no', $invoice_no );
        $this->db->group_end();                    
        $this->db->group_start();
            $this->db->where('vidiem_customorder.billing_emailid', $email);
            $this->db->or_where('vidiem_clients.email', $email);
        $this->db->group_end();

        $info   = $this->db->get('vidiem_customorder');
        if( isset( $info ) && $info->num_rows() > 0 ) {
            return $info->row();
        } else {
            return null;
        }
    }

    public function getOrderTrackingData($order_no, $order_type )
    {
        $details    = $this->db->select('vidiem_order_tracking.*, vidiem_delivery_partners.name as courier_name')
                    ->join('vidiem_delivery_partners', 'vidiem_delivery_partners.id = vidiem_order_tracking.couried', 'left')
                    ->where('vidiem_order_tracking.order_id', $order_no)
                    ->where('vidiem_order_tracking.order_type', $order_type)
                    ->get('vidiem_order_tracking');
        
        if( isset( $details ) && $details->num_rows() > 0 ) {
            return $details->result();
        } else {
            return null;
        }
    }

}
