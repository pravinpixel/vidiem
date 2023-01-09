<?php
class ReportModel extends CI_Model {

     function __construct()
    {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('session');
		$this->load->database();
    }

	public function Day_Divider($date=NULL){
		list($tmp['from'],$tmp['to'])=explode(' - ',$date);
		return $tmp;
	}

	public function SalesReport($from,$to,$status=null,$reportuser=null){
		 $this->db->select('o.*,c.name,c.email,c.mobile_no');
        $this->db->join('vidiem_clients c','c.id=o.client_id','left');
        $this->db->where('DATE(o.created) >=',$from);
		$this->db->where('DATE(o.created) <=',$to);
		if(!empty($status)){
			$this->db->where('o.status',$status);
		}
		if(!empty($reportuser)){
			$this->db->where('o.client_id',$reportuser);
		}
        $query=$this->db->get_where('vidiem_order o',array('o.status !='=>4,'o.payment_status'=>'success'));
        
         // print_r($this->db->last_query());
         //  die();
        
        return $query->result_array();
	}
	
		public function ProductReport($from,$to,$status=null,$reportuser=null){
		 $this->db->select('o.*,c.name,c.email,c.mobile_no,op.name as productname,op.price as product_price,op.qty as product_qty,op.amount as subtotal_amt');
        $this->db->join('vidiem_clients c','c.id=o.client_id','left');
        $this->db->join('vidiem_order_products op','o.id=op.order_id');
        $this->db->where('DATE(o.created) >=',$from);
		$this->db->where('DATE(o.created) <=',$to);
		if(!empty($status)){
			$this->db->where('o.status',$status);
		}
		if(!empty($reportuser)){
			$this->db->where('o.client_id',$reportuser);
		}
        $query=$this->db->get_where('vidiem_order o',array('o.status !='=>4,'o.payment_status'=>'success'));
        
         // print_r($this->db->last_query());
        //  die();
        
        return $query->result_array();
	}

	public function PaymentReport($from,$to,$booking_mode=null,$booking_type=null,$payment_mode=null){
		$this->db->select('b.*,w.name as webinar_name,c.name as course_name,clt.code as user_code,clt.name,clt.email,clt.mobile_no,clt.city');
		$this->db->join('stock_webinar w','w.id=b.course_id');
		$this->db->join('stock_courses c','c.id=w.course_id');
		$this->db->join('stock_clients clt','clt.id=b.client_id');
		if(!empty($booking_mode)){
			$this->db->where('b.booking_mode',$booking_mode);
		}
		if(!empty($booking_type)){
			$this->db->where('b.booking_type',$booking_type);
		}
		if(!empty($payment_mode)){
			$this->db->where('b.payment_mode',$payment_mode);
		}
		$this->db->where('DATE(b.created) >=',$from);
		$this->db->where('DATE(b.created) <=',$to);
		$query=$this->db->get_where('stock_course_booking b',array('order_status'=>'Success'));
        return $query->result_array(); 
	}

 }