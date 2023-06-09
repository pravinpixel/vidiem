<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {
	function __construct() {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->model(array('Accessmodel'));
        $this->load->library('slug');
        if(!$this->session->userdata('user_logged_in')){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}
    }

	 public function index() {
	    if(hasPermission('order_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->ProjectModel->Select_Orders();
		$this->load->view('Backend/view-orders',$data);
    }
    
    
    //view order
    
    public function viewOrder()
    {
		$this->load->view('Backend/view-order-list');
    }

    public function viewOrderList()
    {
        if(hasPermission('order_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
        $length          = $this->input->post('length');
        $draw            = $this->input->post('draw');
        $start           = $this->input->post('start');
        $rowperpage      = $this->input->post('length');
        $columnIndex     = $this->input->post('order')[0]['column'];
        $columnName      = $this->input->post('columns')[$columnIndex]['data'];
        $columnSortOrder = $this->input->post('order')[0]['dir'];
        $searchValue     = $this->input->post('search')['value'];
        if(in_array($columnIndex, [0,1,2,4,13])){
            $order=array(
                'field'=>'o.created',
                'type'=> $columnSortOrder,
            );
        }else{
            $order=array(
                'field'=>$columnName,
                'type'=> $columnSortOrder
            );
        }
        
        $where=[];
        $custom='';
        $searchQuery = [];
        if($searchValue != ''){
            $searchQuery['c.name']               = $searchValue;
            $searchQuery['o.delivery_name']     = $searchValue;
            $searchQuery['cat.name']             = $searchValue;
            $searchQuery['o.delivery_city']      = $searchValue;
            $searchQuery['o.delivery_state']     = $searchValue;
            $searchQuery['o.delivery_address']   = $searchValue;
            $searchQuery['o.delivery_zip']       = $searchValue;
            $searchQuery['o.created']            = $searchValue;
            $searchQuery['o.inv_code']           = $searchValue;
            $searchQuery['o.delivery_mobile_no'] = $searchValue;
            $searchQuery['c.mobile_no']          = $searchValue;
            $searchQuery['o.delivery_emailid']   = $searchValue;
            $searchQuery['c.email']              = $searchValue;
            $searchQuery['p.name']               = $searchValue;
            $searchQuery['p.bank_ref_num']       = $searchValue;
        }
        if($this->input->post('filter_date')) {
            list($start_date, $end_date) = explode('-',($this->input->post('filter_date')));
            $start_date = date('Y-m-d 00:00:00',strtotime($start_date));
            $end_date = date('Y-m-d 23:59:59',strtotime($end_date));
            $where = ("o.created BETWEEN '{$start_date}' AND '{$end_date}'");
        } else  {
            $start_date = date('Y-m-d 00:00:00',strtotime('-30 days'));
            $end_date = date('Y-m-d 23:59:59',strtotime("today"));
            $where = ("o.created BETWEEN '{$start_date}' AND '{$end_date}'");
        }

        $DataResult=$this->ProjectModel->SelectOrderProductList('list',$where,$custom,$searchQuery,$order);
        $count=$this->ProjectModel->SelectOrderProductList('count',$where,$custom,$searchQuery);
        $data = array();
        if($order['type']=='desc' && $order['field']=='id'){
            $no=$start+1;
        }else if($order['type']=='asc' && $order['field']=='id' ){
            $no=$count;
        }else{
            $no=$start+1;  
        }
        if($DataResult){
            foreach($DataResult as $row){
                $options='';
                $data[]=array(
                    'no'                  => $no,
                    'id'                  => $no,
                    'month'                => date('M', strtotime($row['created'])),
                    'created'             => $row['created'],
                    'inv_code'            => $row['inv_code'],
                    'inv_date'            => $row['invoice_date'],
                    'name'                => $row['name'],
                    'address'             => $row['address'],
                    'mobile_no'           => $row['mobile_no'],
                    'email'               => $row['email'],
                    'city'                => $row['city'],
                    'state'               => $row['state'],
                    'zip_code'            => $row['zip_code'],
                    'category_name'       => $row['category_name'],
                    'product_name'        => $row['product_name'],
                    'qty'                 => $row['qty'],
                    'price'               => $row['price'],
                    'bank_ref_num'        => $row['bank_ref_num']
                );
                if($order['type']=='desc' && $order['field']=='id' ){
                    $no++;
                }else if($order['type']=='asc' && $order['field']=='id' ){
                    $no--;
                }else{
                    $no++;  
                }
            }
        }
        $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $count,
        "iTotalDisplayRecords" => $count,
        "aaData" => $data
        );
        echo json_encode($response); exit;
    }

    public function viewOrderExport()
    {
        $DataResult=$this->ProjectModel->viewOrderExport();
        if (empty($DataResult)) {
          $DataResult[0]['No Result Found'] = '';
        }
        $this->FunctionModel->export_data($DataResult, 'view-orders-data');
    }
    //end view order

	public function uncompleted(){
	    if(hasPermission('order_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->ProjectModel->Select_unCompletedOrders();
		$this->load->view('Backend/view-uncompleted-orders',$data);
	}

    public function updateOrderUncompletedToNewOrder() {
        $order_id = $this->input->post('id');
        $status = $this->input->post('status');
		
		  $code=$this->FunctionModel->Select_Field('inv_code','vidiem_order',array('id'=>$order_id),'inv_code','DESC',1);
          $data = 0;
         if(empty($code)){
            $inv_code=$this->ProjectModel->InvoiceCode();
            $UpdateData=array(
                'inv_code'      => $inv_code,
                'mihpayid'      => $dataarr['data'],
                'payment_source'=> "Razorpay",
                'pg_type'       => $dataarr['tracking_id'],
                'bank_ref_num'  => $dataarr['bank_ref_no'],
                'payment_status'=> 'success',
				'status' =>  $status,
				'inv_date'      => date('Y-m-d H:i:s'),
                'modified'      => date('Y-m-d H:i:s')
            );
           $data =   $this->FunctionModel->Update($UpdateData,'vidiem_order',array('id'=>$order_id));
         }    
            
		
		
       
        if($data) {
            //$this->ProjectModel->NewOrderNotification($order_id);
            $this->ProjectModel->OrderInvoicing($order_id);
            $res = json_encode(['status' => true, 'msg' => 'Order status updated successfully']);
        } else {
            $res = json_encode(['status' => false, 'msg' => 'Something went wrong contact administrator']);
        }
        echo  $res;
        exit;
    }

	public function cancelled(){
	    if(hasPermission('order_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		$data['DataResult']=$this->ProjectModel->Select_Cancelled_Order();
		$this->load->view('Backend/view-cancelled-orders',$data);
    }
    
    public function cancel_request(){
        if(hasPermission('order_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
        $data['DataResult']=$this->ProjectModel->Select_Cancel_Requests();
		$this->load->view('Backend/view-cancel-request',$data);
    }
	
	public function orderCancel($id=null){
       if(empty($id)){
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            redirect('Admin/orders');
        }
       $order_info=$this->FunctionModel->Select_Fields_Row('client_id,inv_code,created','vidiem_order',array('id'=>$id));
       $clt_info=$this->FunctionModel->Select_Fields_Row('name,email','vidiem_clients',array('id',$order_info['client_id']));

       $UpdateData=array(
            'status'=>4,
            'modified'=>date('Y-m-d H:i:s')
       );
       $this->FunctionModel->Update($UpdateData,'vidiem_order',array('id'=>$id));

        $subject='Subject : Vidiem Order Status - Cancelled';
            $msg='<style>
        div.mail > p{
            margin:0px 0px 1em;padding:0px;color:rgb(51,51,51);font-family:q_serif,Georgia,Times,&quot;Times New Roman&quot;,&quot;Hiragino Kaku Gothic Pro&quot;,Meiryo,serif;font-size:16px
        } 
        </style>
        <div class="mail"><p>Dear '.$clt_info['name'].'</p><p><b>RE: Vidiem&nbsp;current status for the&nbsp;<span>Order</span>&nbsp;number '.$order_info['inv_code'].' dated '.date("d-M-Y", strtotime($order_info['created'])).'.</b></p><p>I here by write to you in regards with the above&nbsp;<span>order</span>&nbsp;which was made by&nbsp; you is&nbsp;<span style="font-family:Arial,Helvetica,sans-serif;font-size:small;color:rgb(34,34,34)">cancelled</span></p><p>If you require any other information in relationship to the above, please do not hesitate to contact us/me.</p><p>Your early response will be highly appreciable.</p><p>Thanking you in advance.</p><p>Best Wishes,</p><p>Vidiem Team.</p></div>';
            $this->FunctionModel->sendmail1($clt_info['email'],$msg,$subject,InfoMail);
            $this->FunctionModel->sendmail1("onlinesales@mayaappliances.com,care@mayaappliances.com",$msg,$subject,InfoMail);
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Order Successfully cancelled.");
            redirect($_SERVER['HTTP_REFERER']);
    }

	// Order Status Management
	public function OrderStatusManagement(){
		$id=$this->input->post('id');
		$info=$this->FunctionModel->Select_Fields_Row('id,inv_code,status,courier,tracking_code,notes','vidiem_order',array('id'=>$id));
		echo json_encode($info);
    	exit;
	}

		public function OrderStatusUpdate(){
			
			
			
		$id=$this->input->post('id');
		$UpdateData=array(
			'status'       => $this->input->post('status'),
            'courier'      => $this->input->post('courier'),
			'tracking_code'=> $this->input->post('tracking_code'),
			'notes'        => $this->input->post('notes'),
			'modified'     => date('Y-m-d H:i:s')
		);
        $status=$this->input->post('status');
        if($status==5){
             $order_info=$this->FunctionModel->Select_Fields_Row('client_id,inv_code,amount,created','vidiem_order',array('id'=>$id));
             $clt_info=$this->FunctionModel->Select_Fields_Row('name,mobile_no,email','vidiem_clients',array('id'=>$order_info['client_id']));
             $sms_content='sir your order on vidiem site is in processing';
       // $this->SMS($clt_info['mobile_no'],$sms_content);
       $this->ProjectModel->SMS($clt_info['mobile_no'],$sms_content);

             $subject='Subject : Vidiem Order Status - Order in Process';
            $msg='<style>
        div.mail > p{
            margin:0px 0px 1em;padding:0px;color:rgb(51,51,51);font-family:q_serif,Georgia,Times,&quot;Times New Roman&quot;,&quot;Hiragino Kaku Gothic Pro&quot;,Meiryo,serif;font-size:16px
        } 
        </style>
        <div class="mail"><p>Dear '.$clt_info['name'].'</p><p><b>RE: Vidiem&nbsp;current status for the&nbsp;<span>Order</span>&nbsp;number '.$order_info['inv_code'].' dated '.date("d-M-Y", strtotime($order_info['created'])).'.</b></p><p>I here by write to you in regards with the above&nbsp;<span>order</span>&nbsp;which was made by&nbsp; you is&nbsp;<span style="font-family:Arial,Helvetica,sans-serif;font-size:small;color:rgb(34,34,34)">in processing</span></p><p>If you require any other information in relationship to the above, please do not hesitate to contact us/me.</p><p>Your early response will be highly appreciable.</p><p>Thanking you in advance.</p><p>Best Wishes,</p><p>Vidiem Team.</p></div>';
    $this->FunctionModel->sendmail1($clt_info['email'],$msg,$subject,InfoMail);
    $this->FunctionModel->sendmail1("onlinesales@mayaappliances.com,care@mayaappliances.com",$msg,$subject,InfoMail);
	
        }
        if($status==2){
              $order_info=$this->FunctionModel->Select_Fields_Row('client_id,inv_code,amount,created,billing_mobile_no','vidiem_order',array('id'=>$id));
             $courier_id=$this->input->post('courier');
             $tracking_code=$this->input->post('tracking_code');
             $courier=$this->FunctionModel->Select_Fields_Row('name,url','vidiem_delivery_partners',['id'=>$courier_id]);
             $clt_info=$this->FunctionModel->Select_Fields_Row('name,mobile_no,email','vidiem_clients',array('id'=>$order_info['client_id']));
             $track_url = str_replace('{track_id}', $tracking_code, $courier['url']);
             $sms_content='Hi <b>'.$clt_info['name'].'</b>, your Vidiem order <b>'.$order_info['inv_code'].'.</b> has been shipped! Your Tracking number is <b>'.$tracking_code.'.</b>. Track your order here:'.$track_url;
             
       // $this->SMS($clt_info['mobile_no'],$sms_content);
        $billing_mobile_no =  ($order_info['billing_mobile_no'] != '' &&  $order_info['billing_mobile_no'] != null)  ? $order_info['billing_mobile_no'] :  $clt_info['mobile_no'];
       SMS($billing_mobile_no,$sms_content);
       $this->ProjectModel->SMS($clt_info['mobile_no'],$sms_content);

             $subject='Subject : Vidiem Order Status - Shipped';
            $msg='<style>
        div.mail > p{
            margin:0px 0px 1em;padding:0px;color:rgb(51,51,51);font-family:q_serif,Georgia,Times,&quot;Times New Roman&quot;,&quot;Hiragino Kaku Gothic Pro&quot;,Meiryo,serif;font-size:16px
        } 
        </style>
        <div class="mail"><p>We here by write to you in regards with the above order which was made by you is <b>"Shipped"</b> with our Courier Partner <b>'.ucfirst($courier['name']).'.</b> Tracking Number : <b>'.$tracking_code.'.</b></p>
       <p>If you require any other information in relationship to the above, please do not hesitate to contact us/me.</p>
<p>Your early response will be highly appreciable.</p>
<p>Thanking you in advance.</p><p>Best Wishes,</p><p>Vidiem Team.</p></div>';
    $this->FunctionModel->sendmail1($clt_info['email'],$msg,$subject,InfoMail);
    $this->FunctionModel->sendmail1("onlinesales@mayaappliances.com,care@mayaappliances.com",$msg,$subject,InfoMail);
        }
        if($status==3){
            $UpdateData['delivered_at']=date('Y-m-d');

            $order_info=$this->FunctionModel->Select_Fields_Row('client_id,inv_code,amount,created,billing_mobile_no','vidiem_order',array('id'=>$id));
             $clt_info=$this->FunctionModel->Select_Fields_Row('mobile_no,email','vidiem_clients',array('id'=>$order_info['client_id']));
             $sms_content='Hi <b>'.$clt_info['name'].'</b>, your order <b>'.$order_info['inv_code'].'</b> has been delivered. Thank you for shopping with us. Keep visiting <a href="www.vidiem.in">vidiem.in</a> for exciting offers. -VIDIEM';
       // $this->SMS($clt_info['mobile_no'],$sms_content);
        $billing_mobile_no =  ($order_info['billing_mobile_no'] != '' &&  $order_info['billing_mobile_no'] != null)  ? $order_info['billing_mobile_no'] :  $clt_info['mobile_no'];
       SMS($billing_mobile_no,$sms_content);
       $this->ProjectModel->SMS($clt_info['mobile_no'],$sms_content);

             $subject='Subject : Vidiem Order Status - Delivered ';
            $msg='<style>
        div.mail > p{
        	margin:0px 0px 1em;padding:0px;color:rgb(51,51,51);font-family:q_serif,Georgia,Times,&quot;Times New Roman&quot;,&quot;Hiragino Kaku Gothic Pro&quot;,Meiryo,serif;font-size:16px
        } 
        </style>
        <div class="mail"><p>Dear '.$clt_info['name'].'</p><p><b>RE: Vidiem&nbsp;current status for the&nbsp;<span>Order</span>&nbsp;number '.$order_info['inv_code'].' dated '.date("d-M-Y", strtotime($order_info['created'])).'.</b></p><p>I here by write to you in regards with the above&nbsp;<span>order</span>&nbsp;which was made by&nbsp; you is&nbsp;<span style="font-family:Arial,Helvetica,sans-serif;font-size:small;color:rgb(34,34,34)"> Delivered</span></p><p>If you require any other information in relationship to the above, please do not hesitate to contact us/me.</p><p>Your early response will be highly appreciable.</p><p>Thanking you in advance.</p><p>Best Wishes,</p><p>Vidiem Team.</p></div>';
    $this->FunctionModel->sendmail1($clt_info['email'],$msg,$subject,InfoMail);
    $this->FunctionModel->sendmail1("onlinesales@mayaappliances.com,care@mayaappliances.com",$msg,$subject,InfoMail);
        }
		$this->FunctionModel->Update($UpdateData,'vidiem_order',array('id'=>$id));
		echo 1; exit;
	}
	

	public function AjaxSingleView(){
		$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/orders');
    	}
    	$order_data=$this->FunctionModel->Select_Row('vidiem_order',array('id'=>$id));
		$order_product=$this->FunctionModel->Select('vidiem_order_products',array('order_id'=>$id));
        $client=$this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
    	$return['modal_title']='View Order';
    	$return['modal_content']='';
    	
    		$return['modal_content']='
   <style>h1 {
    margin-top: -5px;
}
.container{width:100%;}
</style>
   <div style="">
   <div class="container inCon">
        <div style="float:left;"><h1 style="color:#00BFFF;"><img src="'.base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto"/></h1></div>
        <div style="width:30%;float:right;"><h1 style="color:#00BFFF;">Proforma Invoice</h1></div>
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
        <div class="detail" style="float:left; width:35%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:14px;">Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road,
Oggiam Thoraipakkam,<br>Chennai - 600097, Tamilnadu, INDIA.</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Landline</span> : &nbsp; 044-6635 6635 / 77110 06635
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Website</span> : &nbsp; http://vidiem.in/
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">GST NO</span> : &nbsp;  33AAACM6280D1ZT
                </li>
            </ul>
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">BILL TO </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_name'].'
                </li>';
                if(!empty($order_data['billing_company_name'])){
                 $return['modal_content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_company_name'].'</li>';
                }
                 $return['modal_content'].='</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; '.@$order_data['billing_address'].' - '.@$order_data['billing_address2'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; '.@$order_data['billing_city'].'-'.$order_data['billing_zip'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; '.@$order_data['billing_state'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; '.@$order_data['billing_country'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; '.@$order_data['billing_mobile_no'].'
                </li>
            </ul>
        </div>
        <div class="logo" style="float:left; width:35%; "></div>
         <div class="contact" style="float:right; width:30%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">DATE</span> :&nbsp;
                &nbsp;'.date("d-M-Y", strtotime(@$order_data['created'])).'</li>
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">INVOICE</span> :&nbsp;
                &nbsp;'.@$order_data['inv_code'].'</li>
            </ul>

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">SHIPPING ADDRESS </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_name'].'
                </li>';
                if(!empty($order_data['delivery_company_name'])){
                 $return['modal_content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_company_name'].'</li>';
                }
                 $return['modal_content'].='</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; '.@$order_data['delivery_address'].' - '.@$order_data['delivery_address2'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; '.@$order_data['delivery_city'].'-'.$order_data['delivery_zip'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; '.@$order_data['delivery_state'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; '.@$order_data['delivery_country'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; '.@$order_data['delivery_mobile_no'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">GST No</span> : &nbsp; '.@$order_data['gst_no'].'
                </li>
            </ul>';
         
         $return['modal_content'].='</div>
        </div>        
        <div class="form" style="width:100%;">
            <table style="width:100%; padding:20px 0 40px 0;">
                <tr style="background:#3B4E87;; font-family:roboto; font-weight:normal">
                    <th style="color:#fff; padding:15px 0; font-size:14px;">SL</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Product</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Price</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Qty</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Amount</th>
                </tr>';
                
                if(!empty($order_product)){ $x=1;
                    foreach ($order_product as $info) {
                       $return['modal_content'].='<tr style=""><td style="text-align:center;padding:15px 0;">'.$x.'</td>
                            <td style="padding:15px 20px;font-size:14px;">'.$info['name'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['price'],2,'.','').'</td>
                            <td style="padding:15px 0;text-align:right;">'.$info['qty'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['amount'],2,'.','').'</td>
                            </tr>';
                            $x++;
                    }
                }
                
                 $return['modal_content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">SubTotal + GST 18% Included('.number_format($order_data['tax'],2,'.','').')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['sub_total'],2,'.','').'</b></th>
                </tr>';
                if($order_data['coupon_id']!=0){
                   if($order_data['discount']!=0){	
                    $return['modal_content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Coupon Discount ('.$order_data['coupon'].')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['discount'],2,'.','').'</b></th>
                </tr>';
				 }else{

                    if( $order_data['coupon'] == 'vitago' ) {
                        $return['modal_content']    .= '<tr>
                                                    <td></td>
                                                    <th style="text-align:right;" colspan="3">Get VITA-GO Personal Blender</th>
                                                    <th style="padding:10px 0;text-align:right;">Free</th>
                                                </tr>'; 
                    } else {
                        $return['modal_content']    .= '<tr>
                                                    <td></td>
                                                    <th style="text-align:right;" colspan="3">3 Months Extended Warranty </th>
                                                    <th style="padding:10px 0;text-align:right;">Free</th>
                                                </tr>'; 
                    }
					
				 }
                }

                 $return['modal_content'].='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#3B4E87;;text-align:right;">&nbsp; '.number_format($order_data['amount'],2,'.','').'</th>
                </tr>';
               
                  $return['modal_content'].='<tr><td></td><td></td><td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.</td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">If you have any questions about this invoice, please write us to below email id</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">care@vidiem.in</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
            </table>
        </div>
    </div>
    </div>';
    	echo json_encode($return);
    	exit;
	}

	public function AjaxSingleViewBooking(){
		$id=$this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/orders');
    	}
    	$order_data=$this->FunctionModel->Select_Row('vidiem_order',array('id'=>$id));
		$order_product=$this->FunctionModel->Select('vidiem_order_products',array('order_id'=>$id));
        $client=$this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
    	$return['modal_title']='View Failiure Booking';
    	$return['modal_content']='';
    	
    		$return['modal_content']='
   <style>h1 {
    margin-top: -5px;
}
.container{width:100%;}
</style>
   <div style="">
   <div class="container inCon">
    <div class="header_bottom" style="width:100%; padding:10px 0;">
        <div class="detail" style="float:left; width:35%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">BILL TO </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_name'].'
                </li>';
                if(!empty($order_data['billing_company_name'])){
                 $return['modal_content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_company_name'].'</li>';
                }
                 $return['modal_content'].='</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; '.@$order_data['billing_address'].' - '.@$order_data['billing_address'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; '.@$order_data['billing_city'].'-'.$order_data['billing_zip'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; '.@$order_data['billing_state'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; '.@$order_data['billing_country'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; '.@$order_data['billing_mobile_no'].'
                </li>
            </ul>
        </div>
        <div class="logo" style="float:left; width:35%; "></div>
         <div class="contact" style="float:right; width:30%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">DATE</span> :&nbsp;
                &nbsp;'.date("d-M-Y", strtotime(@$order_data['created'])).'</li>
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">Booking Code</span> :&nbsp;
                &nbsp;'.@$order_data['code'].'</li>
            </ul>

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">SHIPPING ADDRESS </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_name'].'
                </li>';
                if(!empty($order_data['delivery_company_name'])){
                 $return['modal_content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_company_name'].'</li>';
                }
                 $return['modal_content'].='</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; '.@$order_data['delivery_address'].' - '.@$order_data['delivery_address'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; '.@$order_data['delivery_city'].'-'.$order_data['delivery_zip'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; '.@$order_data['delivery_state'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; '.@$order_data['delivery_country'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; '.@$order_data['delivery_mobile_no'].'
                </li>
                 <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">GST No</span> :&nbsp;
                &nbsp;'.@$order_data['gst_no'].'</li>
            </ul>';
         
         $return['modal_content'].='</div>
        </div>        
        <div class="form" style="width:100%;">
            <table style="width:100%; padding:20px 0 40px 0;">
                <tr style="background:#3B4E87;; font-family:roboto; font-weight:normal">
                    <th style="color:#fff; padding:15px 0; font-size:14px;">SL</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Product</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Price</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Qty</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Amount</th>
                </tr>';
                
                if(!empty($order_product)){ $x=1;
                    foreach ($order_product as $info) {
                       $return['modal_content'].='<tr style=""><td style="text-align:center;padding:15px 0;">'.$x.'</td>
                            <td style="padding:15px 20px;font-size:14px;">'.$info['name'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['price'],2,'.','').'</td>
                            <td style="padding:15px 0;text-align:right;">'.$info['qty'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['amount'],2,'.','').'</td>
                            </tr>';
                            $x++;
                    }
                }
                
                 $return['modal_content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">SubTotal + GST 18% Included('.number_format($order_data['tax'],2,'.','').')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['sub_total'],2,'.','').'</b></th>
                </tr>';
                if($order_data['coupon_id']!=0){
					
					   if($order_data['discount']!=0){	
                    $return['modal_content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Coupon Discount ('.$order_data['coupon'].')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['discount'],2,'.','').'</b></th>
                </tr>';
				 }else{
					 $return['modal_content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">3 Months Extended Warranty </th>
                    <th style="padding:10px 0;text-align:right;">Free</th>
                </tr>'; 
				 }
                   /* $return['modal_content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Coupon Discount ('.$order_data['coupon'].')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['discount'],2,'.','').'</b></th>
                </tr>'; */
                }
                 $return['modal_content'].='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#3B4E87;;text-align:right;">&nbsp; '.number_format($order_data['amount'],2,'.','').'</th>
                </tr>
            </table>
        </div>
    </div>
    </div>';
    	echo json_encode($return);
    	exit;
	}

    public function invoice($order_id){
         $order_data=$this->FunctionModel->Select_Row('vidiem_order',array('id'=>$order_id));
        $order_product=$this->FunctionModel->Select('vidiem_order_products',array('order_id'=>$order_id));
        $client=$this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
         $data['content']='
   <style>h1 {
    margin-top: -5px; margin-bottom:5px;
}</style>
   <div style="border:1px solid black; padding:5px; 10px;">
   <div class="container inCon">
        <div style="float:left; width:50%;"><h1 style="color:#00BFFF;"><img src="'.base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto"/></h1></div>
        <div style="width:30%;float:right;"><h1 style="color:#00BFFF;">Proforma Invoice</h1></div>
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
        <div class="detail" style="float:left; width:35%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:14px;">Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road,
Oggiam Thoraipakkam,<br>Chennai - 600097, Tamilnadu, INDIA.</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Landline</span> : &nbsp; 044-6635 6635 / 77110 06635
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Website</span> : &nbsp; http://vidiem.in/
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">GST NO</span> : &nbsp;  33AAACM6280D1ZT
                </li>
            </ul>
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">BILL TO </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_name'].'
                </li>';
                if(!empty($order_data['billing_company_name'])){
                  $data['content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_company_name'].'</li>';
                }
                  $data['content'].='</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; '.@$order_data['billing_address'].' - '.@$order_data['billing_address2'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; '.@$order_data['billing_city'].'-'.$order_data['billing_zip'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; '.@$order_data['billing_state'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; '.@$order_data['billing_country'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; '.@$order_data['billing_mobile_no'].'
                </li>
            </ul>
        </div>
        <div class="logo" style="float:left; width:35%; "></div>
         <div class="contact" style="float:right; width:30%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">DATE</span> :&nbsp;
                &nbsp;'.date("d-M-Y", strtotime(@$order_data['created'])).'</li>
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">Invoice</span> :&nbsp;
                &nbsp;'.@$order_data['inv_code'].'</li>
            </ul>

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">SHIPPING ADDRESS </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_name'].'
                </li>';
                if(!empty($order_data['delivery_company_name'])){
                  $data['content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_company_name'].'</li>';
                }
                  $data['content'].='</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; '.@$order_data['delivery_address'].' - '.@$order_data['delivery_address2'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; '.@$order_data['delivery_city'].'-'.$order_data['delivery_zip'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; '.@$order_data['delivery_state'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; '.@$order_data['delivery_country'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; '.@$order_data['delivery_mobile_no'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">GST No</span> : &nbsp; '.@$order_data['gst_no'].'
                </li>
            </ul>';
         
          $data['content'].='</div>
        </div>        
        <div class="form" style="width:100%;">
            <table style="width:100%; padding:20px 0 40px 0;">
                <tr style="background:#3B4E87;; font-family:roboto; font-weight:normal">
                    <th style="color:#fff; padding:15px 0; font-size:14px;">SL</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Product</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Price</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Qty</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Amount</th>
                </tr>';
                
                if(!empty($order_product)){ $x=1;
                    foreach ($order_product as $info) {
                        $data['content'].='<tr style=""><td style="text-align:center;padding:15px 0;">'.$x.'</td>
                            <td style="padding:15px 20px;font-size:14px;">'.$info['name'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['price'],2,'.','').'</td>
                            <td style="padding:15px 0;text-align:right;">'.$info['qty'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['amount'],2,'.','').'</td>
                            </tr>';
                            $x++;
                    }
                }
                
                 $data['content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">SubTotal + GST 18% Included('.number_format($order_data['tax'],2,'.','').')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['sub_total'],2,'.','').'</b></th>
                </tr>';
                if($order_data['coupon_id']!=0){
					
					if($order_data['discount']!=0){
					
                    $data['content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Coupon Discount ('.$order_data['coupon'].')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['discount'],2,'.','').'</b></th>
                </tr>';
					}else{
						 $data['content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">3 Months Extended Warranty</th>
                    <th style="padding:10px 0;text-align:right;">Free</th>
                </tr>';
						
					}
                }
                  $data['content'].='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#3B4E87;;text-align:right;">&nbsp; '.number_format($order_data['amount'],2,'.','').'</th>
                </tr>';
               
                   $data['content'].='<tr><td></td><td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.</td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">If you have any questions about this invoice, please write us to below email id</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">care@vidiem.in</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
            </table>
        </div>
    </div>
    </div>';
    // echo $data['content']; exit;
   // $this->load->view('Backend/pdf-page',$data);
      $html=$this->load->view('Backend/pdf-page',$data,true);
        //this the the PDF filename that user will get to download
        $pdfFilePath ="invoice-".$inv_info['inv_code'].".pdf";
        //load mPDF library
         $this->load->library('m_pdf');
         $this->m_pdf->pdf->AddPage('P', // L - landscape, P - portrait
            '', '', '', '',
            7, // margin_left
            3, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer
       //generate the PDF from the given html
         $this->m_pdf->pdf->WriteHTML($html);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
    }

}