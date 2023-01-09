<?php
class DashboardModel extends CI_Model {

     function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('session');
		$this->load->database();
    }

    public function DashInfo(){
    	$data['product']=$this->FunctionModel->Row_Count('vidiem_products',array('product_id'=>0));
    	$data['clients']=$this->FunctionModel->Row_Count('vidiem_clients');
    	$data['enquiry']=$this->FunctionModel->Row_Count('vidiem_enquiry');
    	$data['new_order']=$this->FunctionModel->Row_Count('vidiem_order',array('payment_status'=>'success','status'=>1));
    	
    	$this->db->like('created',date('Y-m-d'));
    	$query=$this->db->get_where('vidiem_order',array('payment_status'=>'success','status !='=>4));
    	$data['today_order']=$query->num_rows();

    	$this->db->select_sum('amount');
    	$this->db->like('created',date('Y-m-d'));
    	$query=$this->db->get_where('vidiem_order',array('payment_status'=>'success','status !='=>4));
    	$tmp=$query->row_array();
    	$data['today_sales']=$tmp['amount'];

    	 $from=date('Y-m-d',strtotime('-7 Days'));
        $to=date('Y-m-d');
    	$this->db->where('DATE(created) >=',$from);
		$this->db->where('DATE(created) <=',$to);
    	$query=$this->db->get_where('vidiem_order',array('payment_status'=>'success','status !='=>4));
    	$data['week_order']=$query->num_rows();

    	$this->db->select_sum('amount');
    	$this->db->where('DATE(created) >=',$from);
		$this->db->where('DATE(created) <=',$to);
    	$query=$this->db->get_where('vidiem_order',array('payment_status'=>'success','status !='=>4));
    	$tmp=$query->row_array();
    	$data['week_sales']=$tmp['amount'];
    	return $data;
    }
	

	 
}