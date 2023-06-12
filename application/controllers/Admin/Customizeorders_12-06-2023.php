<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customizeorders extends CI_Controller {
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
	    if(hasPermission('customize_order_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 

        $data['dealers']    = $this->FunctionModel->Select('vidiem_dealers');
		
		$data['DataResult'] = $this->CustomizeModel->custom_Select_Orders();
		
		$this->load->view('Backend/customizeorder/view-orders',$data);
    }

	public function uncompleted(){
	    if(hasPermission('customize_order_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		
		$data['DataResult']=$this->CustomizeModel->custom_Select_unCompletedOrders();
		$this->load->view('Backend/customizeorder/view-uncompleted-orders',$data);
	}

  public function cutomizeupdateOrderUncompletedToNewOrder()
    {
        $order_id = $this->input->post('id');
        $invoice_no = $this->input->post('invoice_no');
        $order_ref_no = $this->input->post('order_ref_no');
        $bank_ref_no = $this->input->post('bank_ref_no');
        $status = $this->input->post('status');
        $UpdateData=array(
            'inv_code'      => $invoice_no,
            'payment_source'=> "Razorpay",
            'pg_type'       => $order_ref_no,
            'bank_ref_num'  => $bank_ref_no,
            'payment_status'=> 'success',
            'status' =>  $status,
         
            'modified'      => date('Y-m-d H:i:s')
        );
       $data =   $this->FunctionModel->Update($UpdateData,'vidiem_customorder',array('id'=>$order_id));
       if($data) {
        //$this->ProjectModel->NewOrderNotification($order_id);
      
        $res = json_encode(['status' => true, 'msg' => 'Custom Order status updated successfully']);
    } else {
        $res = json_encode(['status' => false, 'msg' => 'Something went wrong contact administrator']);
    }
    echo  $res;
    exit;

    }

	public function cancelled(){
	    if(hasPermission('customize_order_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		
		$data['DataResult']=$this->CustomizeModel->custom_Select_Cancelled_Order();
		$this->load->view('Backend/customizeorder/view-cancelled-orders',$data);
    }
    
    public function cancel_request(){
		if(hasPermission('customize_order_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		} 
		
        $data['DataResult']=$this->CustomizeModel->custom_Select_Cancel_Requests();
		
		$this->load->view('Backend/customizeorder/view-cancel-request',$data);
    }
	
	public function orderCancel($id=null){
	
       if(empty($id)){
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            redirect('Admin/Customizeorders');
        }
       $order_info=$this->FunctionModel->Select_Fields_Row('client_id,inv_code,created','vidiem_customorder',array('id'=>$id));
	   
	
	   
       $clt_info=$this->FunctionModel->Select_Fields_Row('name,email','vidiem_clients',array('id',$order_info['client_id']));

       $UpdateData=array(
            'status'=>4,
            'modified'=>date('Y-m-d H:i:s')
       );
       $this->FunctionModel->Update($UpdateData,'vidiem_customorder',array('id'=>$id));
		
		

        $subject='Subject : Vidiem Order Status - Cancelled';
            $msg='<style>
        div.mail > p{
            margin:0px 0px 1em;padding:0px;color:rgb(51,51,51);font-family:q_serif,Georgia,Times,&quot;Times New Roman&quot;,&quot;Hiragino Kaku Gothic Pro&quot;,Meiryo,serif;font-size:16px
        } 
        </style>
        <div class="mail"><p>Dear '.$clt_info['name'].'</p><p><b>RE: Vidiem&nbsp;current status for the&nbsp;<span>Order</span>&nbsp;number '.$order_info['inv_code'].' dated '.date("d-M-Y", strtotime($order_info['created'])).'.</b></p><p>I here by write to you in regards with the above&nbsp;<span>order</span>&nbsp;which was made by&nbsp; you is&nbsp;<span style="font-family:Arial,Helvetica,sans-serif;font-size:small;color:rgb(34,34,34)">cancelled</span></p><p>If you require any other information in relationship to the above, please do not hesitate to contact us/me.</p><p>Your early response will be highly appreciable.</p><p>Thanking you in advance.</p><p>Best Wishes,</p><p>Vidiem Team.</p></div>';
            $this->FunctionModel->sendmail1($clt_info['email'],$msg,$subject,InfoMail);
            $this->FunctionModel->sendmail1("onlinesales@mayaappliances.com,johnpaul@pixel-studios.com",$msg,$subject,InfoMail);
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Order Successfully cancelled.");
            redirect($_SERVER['HTTP_REFERER']);
    }

	// Order Status Management
	public function OrderStatusManagement() {

		$id         = $this->input->post('id');
		$info       = $this->FunctionModel->Select_Fields_Row('id,inv_code,status,courier,tracking_code,notes','vidiem_customorder',array('id'=>$id));
		echo json_encode($info);
    	exit;
        
	}

	public function OrderStatusUpdate() {

		$id                         = $this->input->post('id');

        $order_info                 = $this->FunctionModel->Select_Row('vidiem_customorder',array('id'=>$id));

        $mail_header                = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                                            <span>
                                                <h1 style="color:#00BFFF;">
                                                    <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                                                </h1>
                                            </span>';
        $mail_content               = '';


        if( isset( $order_info['dealer_id'] ) && !empty( $order_info['dealer_id']) ) {

            $dealer_info            = $this->FunctionModel->getDealerLocationInfo($order_info['dealer_user_id']);
            // $dealer_info        = $this->FunctionModel->Select_Fields_Row('display_name,dealer_erp_code,location_code, phone, email','vidiem_dealers',array('id'=>$order_info['dealer_id']));

        }
        
        $clt_info                   = $this->FunctionModel->Select_Fields_Row('name,mobile_no,email','vidiem_clients',array( 'id' => $order_info['client_id'] ) );
		$UpdateData                 = array(
                                        'status'       => $this->input->post('status'),
                                        'courier'      => $this->input->post('courier'),
                                        'tracking_code'=> $this->input->post('tracking_code'),
                                        'notes'        => $this->input->post('notes'),
                                        'modified'     => date('Y-m-d H:i:s')
                                    );
        $status                     = $this->input->post('status');

        $ins_trac['order_id']       = $id;        
        $ins_trac['created_at']     = date('Y-m-d H:i:s');
        $ins_trac['notes']          = $this->input->post('notes');
        $ins_trac['tracking']       = $this->input->post('tracking_code');
        $ins_trac['couried']        = $this->input->post('courier');
        $ins_trac['order_status']   = $status;
        $ins_trac['order_type']     = 'custom_order';

        $client_mobile_no           = $clt_info['mobile_no'] ?? $order_info['billing_mobile_no'];
        $client_email               = $clt_info['email'] ?? $order_info['billing_emailid'];
        $client_name                = $clt_info['name'] ?? $order_info['billing_name'];

        if($status==5) {

            $ins_trac['status_name']= 'Order in Process';  

            $subject    = 'Subject : Vidiem Order Status - Order in Process';

            $mail_content        .= $mail_header;
            $mail_content        .= '<div style="width:100%;text-align:center;">
                                        <h2>Dear '.$client_name.'</h2>
                                        <p><b>RE: Vidiem&nbsp;current status for the&nbsp;
                                        <span>Order</span>
                                        &nbsp;number '.$order_info['inv_code'].' dated '.date("d-M-Y", strtotime($order_info['created'])).'.</b>
                                        </p>
                                        <p>I here by write to you in regards with the above&nbsp;
                                        <span>order</span>
                                        &nbsp;which was made by&nbsp; you is&nbsp;
                                        <span style="font-family:Arial,Helvetica,sans-serif;font-size:small;color:rgb(34,34,34)">in processing</span>
                                        </p>
                                        <p>If you require any other information in relationship to the above, please do not hesitate to contact us/me.</p>
                                        <p>Your early response will be highly appreciable.</p>
                                    </div>
                                    <p>Thanking you in advance.</p>
                                    <p>Best Wishes,</p>
                                    <p>Vidiem Team.</p>
                                    </div>';

            $this->FunctionModel->sendmail1($client_email,$mail_content,$subject,InfoMail);
            $this->FunctionModel->sendmail1("onlinesales@mayaappliances.com,johnpaul@pixel-studios.com",$mail_content,$subject,InfoMail);
            // $this->FunctionModel->sendmail1("durairaj.pixel@gmail.com,johnpaul@pixel-studios.com",$mail_content,$subject,InfoMail);

            if( isset( $order_info['dealer_id'] ) && !empty( $order_info['dealer_id'])) {
                $this->FunctionModel->sendmail1( $dealer_info['email'], $msg, $subject, InfoMail );
                // $sms_content    = "Dear Dealer Vasanth & Co, Our Customer showing interest on Vidiem By You. To confirm order 123132132, please collect the amount in bill counter. -VIDIEM";
                // $this->ProjectModel->SMSContent('9551706025',$sms_content);

            }
	
        }
        if($status==2){
            
            $ins_trac['status_name']    = 'Order Shipped';
            
            $courier_id                 = $this->input->post('courier');
            $tracking_code              = $this->input->post('tracking_code');
            $courier_name               = $this->FunctionModel->Select_Field('name','vidiem_delivery_partners',['id'=>$courier_id]);
            $clt_info                   = $this->FunctionModel->Select_Fields_Row('name,mobile_no,email','vidiem_clients',array('id'=>$order_info['client_id']));
            
            $sms_content                = 'Hi <b>'.$client_name.'</b>, your Vidiem order <b>'.$order_info['inv_code'].'.</b> has been shipped! Your Tracking number is <b>'.$tracking_code.'.</b>. Track your order here:'.base_url().'tracking';
              
            // $this->SMS($clt_info['mobile_no'],$sms_content);
            $billing_mobile_no          =  ($order_info['billing_mobile_no'] != '' &&  $order_info['billing_mobile_no'] != null)  ? $order_info['billing_mobile_no'] :  $clt_info['mobile_no'];
            $this->ProjectModel->SMS($clt_info['mobile_no'],$sms_content);
            
            if( isset( $order_info['dealer_id'] ) && !empty( $order_info['dealer_id'])) {
                /** dealer sms content  */
                $sms_content    = "Hi ".$dealer_info['display_name'].' '.$dealer_info['location_name'].", your Vidiem By You order ".$order_info['inv_code']." has been shipped! Your Tracking number is ".$tracking_code.". Track your order here: ".base_url()."tracking. -VIDIEM";
                $this->ProjectModel->SMSContent( $dealer_info['mobile_no'], $sms_content );

                /*** customer sms template */
                $sms_client_content = 'Hi '.$client_name.', your Vidiem By You order '.$order_info['inv_code'].' has been shipped! Your Tracking number is '.$tracking_code.'. Track your order here: '.base_url().'tracking. -VIDIEM';
                $this->ProjectModel->SMSContent( $client_mobile_no, $sms_client_content );

                $subject        = ' Vidiem By You Order No : '.$order_info['order_no'].' Shipped';
                $mail_content   .= $mail_header;

                $mail_content   .= '<div style="width:100%;text-align:center" >
                                        <h2> Hi '.($client_name).', <br>Thanks for choosing to shop with us!</h2>
                                    </div>
                                    <hr>
                                    <div style="text-align:center">Your Vidiem By You order #'.@$order_info['order_no'].'is now on the way. Track your shipment to see the latest delivery status.<br></div>
                
                                    <hr><br><br> Regards<br>Vidiem Team </div>';

                $this->FunctionModel->sendmail1( $dealer_info['email'], $mail_content, $subject, InfoMail );

            } else {

                $subject        = 'Subject : Vidiem Order Status - Shipped';

                $mail_content   .= $mail_header;

                $mail_content   .= ' <div style="width:100%;text-align:center" >
                                        <h2> Hi '.($client_name).'</h2>
                
                                        <div class="mail">
                                        <p> We here by write to you in regards with the above order which was made by you is 
                                            <b>"Shipped"</b> with our Courier Partner 
                                            <b>'.ucfirst($courier_name).'.</b> Tracking Number : 
                                            <b>'.$tracking_code.'.</b>
                                        </p>
                                        <p> If you require any other information in relationship to the above, please do not hesitate to contact us/me.</p>
                                        <p> Your early response will be highly appreciable.</p>
                                    </div>
                                        <p> Thanking you in advance.</p>
                                        <p>Best Wishes,</p>
                                        <p>Vidiem Team.</p>
                                    </div>';

            }
            
            $this->FunctionModel->sendmail1($client_email,$mail_content,$subject,InfoMail);
            $this->FunctionModel->sendmail1("onlinesales@mayaappliances.com,johnpaul@pixel-studios.com",$mail_content,$subject,InfoMail);
            // $this->FunctionModel->sendmail1("durairaj.pixel@gmail.com,johnpaul@pixel-studios.com",$mail_content,$subject,InfoMail);
        }

        if($status==3) {

            $ins_trac['status_name']    = 'Order Delivered';

            $UpdateData['delivered_at'] = date('Y-m-d');

            $clt_info               = $this->FunctionModel->Select_Fields_Row('mobile_no,email','vidiem_clients',array('id'=>$order_info['client_id']));
          
            $sms_content            = 'Hi <b>'.$clt_info['name'].'</b>, your order <b>'.$order_info['inv_code'].'</b> has been delivered. Thank you for shopping with us. Keep visiting <a href="www.vidiem.in">vidiem.in</a> for exciting offers. -VIDIEM';
            // $this->SMS($clt_info['mobile_no'],$sms_content);
            $billing_mobile_no =  ($order_info['billing_mobile_no'] != '' &&  $order_info['billing_mobile_no'] != null)  ? $order_info['billing_mobile_no'] :  $clt_info['mobile_no'];
            SMS($billing_mobile_no,$sms_content);
            $this->ProjectModel->SMS($clt_info['mobile_no'],$sms_content);
       
            /*   $sms_content='sir your order has been delivered. Thanks for choosing Vidiem';
            // $this->SMSContent($clt_info['mobile_no'],$sms_content);
            $this->ProjectModel->SMSContent($clt_info['mobile_no'],$sms_content);
            */

            if( isset( $order_info['dealer_id'] ) && !empty( $order_info['dealer_id'])) {

                /*** Dealer sms content */

                $sms_content    = "Hi ".$dealer_info['display_name'].' '.$dealer_info['location_name'].", Vidiem By You order ".$order_info['inv_code']."  ".$order_info['order_no']." has been delivered. -VIDIEM";
                $this->ProjectModel->SMSContent($dealer_info['mobile_no'],$sms_content);

                /*** customer sms template */
                
                $sms_client_content = 'Hi '.$client_name.' your Vidiem By You order '.$order_info['inv_code'].' '.$order_info['order_no'].' has been delivered. Thank you for shopping with our Dealer '.$dealer_info['display_name'].' '.$dealer_info['location_name'].' and us. Keep visiting vidiem.in for exciting offers. -VIDIEM';
                $this->ProjectModel->SMSContent( $client_mobile_no, $sms_client_content );

                $subject = ' Vidiem By You Order No : '.$order_info['order_no'].' Delivered';

                $mail_content   .= $mail_header;
                $mail_content   .= ' <div style="width:100%;text-align:center" >
                                        <h2> Hi '.($client_name).', <br>Thanks for choosing to shop with us!</h2>
                                    </div>
                                    <hr>
                                    <div style="text-align:center">Your Vidiem By You order #'.@$order_info['order_no'].'is now successfully delivered. 
                                        <br>
                                    </div>
                
                                    <hr><br><br> Regards<br>Vidiem Team    
                                    </div>';

                $this->FunctionModel->sendmail1( $dealer_info['email'], $mail_content, $subject, InfoMail );
                
            } else {
                $subject    = 'Subject : Vidiem Order Status - Delivered ';

                $mail_content   .= $mail_header;
                $mail_content   .= ' <div style="width:100%;text-align:center" >
                                        <div class="mail">
                                        <p>Dear '.$clt_info['name'].'</p>
                                        <p><b>RE: Vidiem&nbsp;current status for the&nbsp;
                                        <span>Order</span>
                                        &nbsp;number '.$order_info['inv_code'].' dated '.date("d-M-Y", strtotime($order_info['created'])).'.</b>
                                        </p>
                                        <p>I here by write to you in regards with the above&nbsp;<span>order</span>&nbsp;which was made by&nbsp; you is&nbsp;
                                        <span style="font-family:Arial,Helvetica,sans-serif;font-size:small;color:rgb(34,34,34)"> Delivered</span></p>
                                        <p>If you require any other information in relationship to the above, please do not hesitate to contact us/me.</p>
                                        <p>Your early response will be highly appreciable.</p><p>Thanking you in advance.</p>
                                    </div>
                                    <p>Best Wishes,</p>
                                    <p>Vidiem Team.</p>
                                    </div>';
            }
           
            $this->FunctionModel->sendmail1($client_email,$mail_content,$subject,InfoMail);
            $this->FunctionModel->sendmail1("onlinesales@mayaappliances.com,johnpaul@pixel-studios.com",$mail_content,$subject,InfoMail);
            // $this->FunctionModel->sendmail1("durairaj.pixel@gmail.com,johnpaul@pixel-studios.com",$mail_content,$subject,InfoMail);
        }

        $this->FunctionModel->Insert($ins_trac,' vidiem_order_tracking');
        // ss( $UpdateData );
		$this->FunctionModel->Update($UpdateData,'vidiem_customorder',array('id'=>$id));
		echo 1; exit;

	}
	

	public function AjaxSingleView(){
		$id=$this->input->post('id');
        $jar_count = 0;
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/Customizeorders');
    	}
    	$order_data=$this->FunctionModel->Select_Row('vidiem_customorder',array('id'=>$id));
	
		
		$basiciteminfo=	$this->CustomizeModel->getOrderBasicDetails($id);
		$jarinfo=$this->CustomizeModel->getOrderJarsDetails($id);
		
        $client=$this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
    	$return['modal_title']='View Order';

        foreach($jarinfo as $jar) {

            $jar_count += $jar['qty'];
        }
    	$return['modal_content']='';
    	
        $return['modal_content']='
                <style>h1 {
                    margin-top: -5px;
                }
                a.download-pdf{position: absolute; right: 40px; top: -47px; padding: 7px 20px; font-size: 16px; color: #FFF; background: #e31e24; border-radius: 5px; transition: all 0.3s ease;}
                a.download-pdf:hover{background: #222;color: #FFF; transition: all 0.3s ease;}
                .container{width:100%;}
                </style>
                
                <div> <a href="#" class="download-pdf" id="download" onclick="return download_pdf(\'view-order-pane\')">Download as PDF &nbsp; <i class="fa fa-download"></i></a>
                <div id="editor"></div>
                <div class="container inCon print-content view-order-pane" id="print-content">
                        <div style="float:left;"><h1 style="color:#00BFFF;"><img src="'.base_url('assets/front-end/images/logo.png').'" style="display:block; margin:0px auto 0 auto"/></h1></div>
                        <div style="float:left;"> <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                                <li style="font-size:14px;">Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road,
                Oggiam Thoraipakkam, Chennai - 600097, Tamilnadu, INDIA.</li>
                            <li  style="font-size:14px;">   Phone   : &nbsp; 044-6635 6635 / 77110 06635 | Visit : www.vidiem.in | GST NO  :  33AAACM6280D1ZT </li> </ul></div>
                    
                        <p style="clear:both;"></p>
                    <div class="header_bottom" style="width:100%; padding:10px 0;">
                    <span style="width:100%;display:block;"><h1 style="color:#00BFFF;">Proforma Invoice</h1></span>
                        <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                        
                                <li style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E84;"><strong>Order Date</span> :&nbsp;
                                &nbsp;&nbsp;'.date("d-M-Y", strtotime(@$order_data['created'])).' &nbsp;&nbsp;| &nbsp;&nbsp;Order No. :  &nbsp;'.@$order_data['inv_code'].'</strong></li>
                            </ul>
                            
                        <table width="100%" border="0">
                            <tr>
                            <td width="50%" >
                                <div class="detail" style="margin-right:3px;">
                                    <ul style="width:100%; display:inline-block; margin:1px; padding:0;list-style:none;">
                                        <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">Billing Address </h3>
                                        <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Name</span> :  '.@$order_data['billing_name'].'
                                        </li>';
                                        if(!empty($order_data['billing_company_name'])){
                                        $return['modal_content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Company</span> :  '.@$order_data['billing_company_name'].'</li>';
                                        }
                                        $return['modal_content'].='</li>
                                        <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Address</span> : <span style="width:65%;display:inline-flex;">'.@$order_data['billing_address'].', <br/>'.@$order_data['billing_address2'].'
                                        </span></li>
                                        <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">City</span> :  '.@$order_data['billing_city'].'-'.$order_data['billing_zip'].'
                                        </li>
                                        <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">State</span> :  '.@$order_data['billing_state'].'
                                        </li>
                                        <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Country</span> :  '.@$order_data['billing_country'].'
                                        </li>
                                        <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Mobile</span> :  '.@$order_data['billing_mobile_no'].'
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td width="50%" >
                            
                            <div class="contact" style="margin-left:3px;">
                        

                            <ul style="width:100%; display:inline-block; margin:1px; padding:0;list-style:none;">
                                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">Shipping Address</h3>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Name</span> :  '.@$order_data['delivery_name'].'
                                </li>';
                                if(!empty($order_data['delivery_company_name'])){
                                $return['modal_content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Company</span> :  '.@$order_data['delivery_company_name'].'</li>';
                                }
                                $return['modal_content'].='</li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Address</span> : <span style="width:65%;display:inline-flex;"> '.@$order_data['delivery_address'].',<br/>'.@$order_data['delivery_address2'].'
                                </span></li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">City</span> :  '.@$order_data['delivery_city'].'-'.$order_data['delivery_zip'].'
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">State</span> :  '.@$order_data['delivery_state'].'
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Country</span> : '.@$order_data['delivery_country'].'
                                </li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Mobile</span> :  '.@$order_data['delivery_mobile_no'].'
                                </li>
                            </ul>';
                        
                        $return['modal_content'].='</div>
                            </td>
                            </tr>
                        </table>
                        
                        
                        </div>        
                        <div class="form" style="width:100%;"> ';
                            $return['modal_content'].='<table style="width:100%; padding:0px 0 0px 0;border:1px solid #3B4E87;">
                    <tr ><td colspan="2"><h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;">Items Orderd</h3> </td> </tr>
                                <tr>
                                    <td style="width:15%">
                                        <img src="'.base_url('uploads/customizeimg/'.$basiciteminfo['basecolorpath']).'" style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
                                    </td>
                                    <td style="width:85%">
                                        <table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
                                                <tbody>
                                                    <tr>
                                                        <td style="border-bottom:1px solid #CCC;">Customization Code</td>
                                                        <td style="border-bottom:1px solid #CCC;">'.$basiciteminfo['cart_code'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Body Design</td>
                                                        <td>'.$basiciteminfo['basetitle'].'</td>
                                                        <td> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Color</td>
                                                        <td>'.$basiciteminfo['bc_title'].'</td>
                                                        <td>'.$basiciteminfo['basecolorprice'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Selected Jars</td>
                                                        <td>'.$jar_count.'</td>
                                                        <td> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Motor Power</td>
                                                        <td>'.$basiciteminfo['motorname'].'</td>
                                                        <td>'.$basiciteminfo['motorprice'].'</td>
                                                        
                                                    </tr>';
                                                            if($basiciteminfo['canvas_text']!='') {		
                                                $return['modal_content'].='	<tr>
                                                        <td>Personalised message</td>
                                                        <td>'.$basiciteminfo['canvas_text'].'</td>
                                                    </tr> ';
                                            }	
                                                        
                                                    '<tr>
                                                        <td>Gift Box Message</td>
                                                        <td>'.$basiciteminfo['message_text'].'</td>
                                                        <td> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Gift Occasion</td>
                                                        <td>'.$basiciteminfo['occasion_text'].'</td>
                                                        <td> </td>
                                                    </tr> 
                                                    <tr>
                                                        <td>Package Preference</td>
                                                        <td>'.$basiciteminfo['packagename'].'</td>
                                                        <td>'.$basiciteminfo['packageprice'].'</td>
                                                    </tr> ';
                                            if($basiciteminfo['package_id']!='' && !empty($basiciteminfo['package_id'])) {				
                                            $data['content'].='		<tr>
                                                        <td>Package Preference</td>
                                                        <td>'.$basiciteminfo['packagename'].'</td>
                                                    </tr> ';
                                        }			
                                        $return['modal_content'].='			</tbody>
                                            </table> ';
                                            
                                        if(count($jarinfo)>0) {	
                                        $return['modal_content'].='	<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
                                                <thead>
                                                    <tr>
                                                        <th style="border-bottom:1px solid #CCC;"></th>
                                                        <th style="border-bottom:1px solid #CCC;">Jar Information</th>
                                                        <th style="text-align:center;border-bottom:1px solid #CCC;">No. Jars</th>
                                                        <th style="text-align:center;border-bottom:1px solid #CCC;">Unit Price</th>
                                                        <th style="text-align:center;border-bottom:1px solid #CCC;">Total Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody> ';
                                                foreach($jarinfo as $jar) {

                                                    $jar_count += $jar['qty'];
                                                    $return['modal_content'].='<tr>
                                                        <td>
                                                                <img src="'.base_url("uploads/customizeimg/jar/".$jar['jarimgpath']).'" style="margin: 0; border: 0; padding: 0; display: block;" width="60" height="60" />								
                                                        </td>
                                                        <td>'.$jar['jarname'].'<br>  '.$jar['capacityname'].'|'.$jar['typeofjarname'].'|'.$jar['typeofhandlename'].'|'.$jar['typeoflidname'].'</td>
                                                        <td style="text-align:center;color:#F7000A;">
                                                            '.$jar['qty'].' Jars
                                                        </td>
                                                        <td style="text-align:center;color:#F7000A;">
                                                            Rs.'.number_format($jar['price']) .'
                                                        </td>
                                                        <td style="text-align:center;color:#F7000A;">
                                                            Rs. '.number_format($jar['qty']*$jar['price']).'
                                                        </td>
                                                    </tr> ';
                                                }
                                        }	
                                                    
                                            $return['modal_content'].='	</tbody>
                                            </table>
                                            <table border="0"  cellspacing="10" style="width:600px;border:1px solid #CCC;margin-bottom:20px;padding:10px;font-size:11px;">
                                        <tr>	<td style="border-bottom:1px solid #CCC;color:#ff0000;"> <strong>Warranty Information</strong></td></tr>
                                            <tr><td> - 2 Years Warranty on Product <br> - 5 Years Warranty on Motor <br> <span style="color:#ff0000;font-size:10px;"><i>(For Domestic Purpose Only)<br>Non Returnable / No Cancellation in all vidiem by you orders</i></span></td></tr></table>
                                    </td>
                                </tr>
                            </table> ';
                
                        $return['modal_content'].='<table style="width:100%; padding:20px 0 40px 0;">
                                                    <tr>
                            <td></td>
                            <th style="text-align:right;" colspan="3">SubTotal + GST 18% Included</th>
                            <th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['sub_total'],2,'.','').'</b></th>
                        </tr>';
                        if($order_data['coupon_id']!=0){
                        if($order_data['discount']!=0){	
                            $return['modal_content'].='<tr>
                            <td></td>
                            <th style="text-align:right;" colspan="3">Coupon Discount ('.$order_data['coupon'].')</th>
                            <th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['discount'],2,'.','').'</b></th>
                        </tr>';
                        }else{

                            if( $order_data['coupon'] == 'vitago') {
                                $return['modal_content'].='<tr>
                                                            <td></td>
                                                            <th style="text-align:right;" colspan="3">Get VITA-GO Personal Blender </th>
                                                            <th style="padding:10px 0;text-align:right;">Free</th>
                                                        </tr>'; 
                            } else {
                                $return['modal_content'].='<tr>
                                                            <td></td>
                                                            <th style="text-align:right;" colspan="3">3 Months Extended Warranty </th>
                                                            <th style="padding:10px 0;text-align:right;">Free</th>
                                                        </tr>'; 
                            }
                           
                        }
                        }

                        $return['modal_content'].='
                        <tr>
                            <td></td>
                            <th style="text-align:right;" colspan="3">Package Charges</th>
                            <th style="padding:10px 0;text-align:right;"> <b>Rs. '.number_format($order_data['packageprice'],2,'.','').'</b></th>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th style="text-align:right;font-size:14px;">TOTAL</th>
                            <th style="color:#fff;padding:10px 0; background:#3B4E87;;text-align:right;">&nbsp;Rs. '.number_format($order_data['amount'],2,'.','').'</th>
                        </tr>';
                    
                    
                    $return['modal_content'].='<tr><td></td>
                    <td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.</td></tr>';
                
                        $return['modal_content'].='<tr><td></td>
                        <td style="font-size:12px;">If you have any questions about this invoice, please write us to care@vidiem.in and If you have any queries in the orders, Please write us to orders@vidiem.in </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                
                        <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
                    </table>
                </div>
            </div>
            </div>';
    	echo json_encode($return);
    	exit;
	}

	public function AjaxSingleViewBooking() {

		$id                     = $this->input->post('id');
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/Customizeorders');
    	}
    	$order_data             = $this->FunctionModel->Select_Row('vidiem_customorder',array('id'=>$id));
		$order_product          = $this->FunctionModel->Select('vidiem_customorder_products',array('order_id'=>$id));
        $client                 = $this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
    	$return['modal_title']  = 'View Failiure Booking';
    	$return['modal_content']= '';
    	
    	$return['modal_content']= '
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
                 $return['modal_content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Company</span> : &nbsp; '.@$order_data['delivery_company_name'].'</li>';
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
            </ul>';
         
         $return['modal_content'].='</div>
        </div>        
        <div class="form" style="width:100%;"> ';
            $return['modal_content'].=' <table style="width:100%; padding:20px 0 40px 0;">
                <tr>
					<td style="width:15%">
						<img src="'.base_url('uploads/customizeimg/'.$basiciteminfo['basecolorpath']).'" style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
					</td>
					<td style="width:85%">
						<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<tbody>
									<tr>
										<td style="border-bottom:1px solid #CCC;"><strong>Customization Code</strong></td>
										<td style="border-bottom:1px solid #CCC;"><strong>'.$basiciteminfo['cart_code'].'</strong></td>
									</tr>
									<tr>
										<td>Body Design</td>
										<td>'.$basiciteminfo['basetitle'].'</td>
									</tr>
									<tr>
										<td>Color</td>
										<td>'.$basiciteminfo['bc_title'].'</td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td>'.count($jarinfo).'</td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td>'.$basiciteminfo['motorname'].'</td>
										<td>'.$basiciteminfo['motorprice'].'</td>
									</tr>';
									
									if($basiciteminfo['canvas_text']!='') {		
								  $return['modal_content'].='	<tr>
										<td>Personalised message</td>
										<td>'.$basiciteminfo['canvas_text'].'</td>
									</tr> ';
							}	
									 
										
									'<tr>
										<td>Gift Box Message</td>
										<td>'.$basiciteminfo['message_text'].'</td>
									</tr>
									<tr>
										<td>Gift Occasion</td>
										<td>'.$basiciteminfo['occasion_text'].'</td>
									</tr>
									
									';
							 	
					if($basiciteminfo['package_id']!='' && !empty($basiciteminfo['package_id'])) {				
							  $data['content'].='		<tr>
										<td>Package Preference</td>
										<td>'.$basiciteminfo['packagename'].'</td>
									</tr> ';
						}
						  $return['modal_content'].='			</tbody>
							</table> ';
							
						if(count($jarinfo)>0) {	
						  $return['modal_content'].='	<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<thead>
									<tr>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">No. Jars</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Unit Price</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Total Price</th>
									</tr>
								</thead>
								<tbody> ';
								foreach($jarinfo as $jar) {
									 $return['modal_content'].='<tr>
										<td>
												<img src="'.base_url("uploads/customizeimg/jar/".$jar['jarimgpath']).'" style="margin: 0; border: 0; padding: 0; display: block;" width="60" height="60" />								
										</td>
										<td>'.$jar['jarname'].'</td>
										<td style="text-align:center;color:#F7000A;">
											'.$jar['qty'].' Jars
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs.'.number_format($jar['price']) .'
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs. '.number_format($jar['qty']*$jar['price']).'
										</td>
									</tr> ';
								}
						}	
									
							 $return['modal_content'].='	</tbody>
							</table>
							
					</td>
				</tr>
            </table> ';
		
        
                
            
                
                $return['modal_content'].='<table style="width:100%; padding:20px 0 40px 0;">
                 <tr>
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
					
                   /* $return['modal_content'].='<tr> <b>Rs. '.number_format($order_data['packageprice'],2,'.','').'</b>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Coupon Discount ('.$order_data['coupon'].')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['discount'],2,'.','').'</b></th>
                </tr>'; */
                }
                 $return['modal_content'].=' <tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Package Charges</th>
                    <th style="padding:10px 0;text-align:right;"> <b>Rs. '.number_format($order_data['packageprice'],2,'.','').'</b></th>
                </tr>
                 <tr>
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
         $order_data=$this->FunctionModel->Select_Row('vidiem_customorder',array('id'=>$order_id));
		
		$basiciteminfo=	$this->CustomizeModel->getOrderBasicDetails($order_id);
		$jarinfo=$this->CustomizeModel->getOrderJarsDetails($order_id);	
        
        $client=$this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
         $data['content']='
   <style>h1 {
    margin-top: -5px; margin-bottom:5px;
}</style>
  
   <div style="border:1px solid black; padding:5px; 10px;font-family:Arial;">
   <div class="container inCon">
         <div style="float:left; width:15%;border:0px solid #ccc;">
        <h1 style="color:#00BFFF;"><img src="'.base_url('assets/front-end/images/logo.png').'" style="display:block; margin:0px 0px 0px 0px;"/></h1></div>
        <div style="float:left;border:0px solid #ccc;"> <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;font-size:12px;font-family:Arial;">
                <li>Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road,Oggiam Thoraipakkam, Chennai - 600097, Tamilnadu, INDIA.</li>
              <li>   Phone   : &nbsp; 044-6635 6635 / 77110 06635 | Visit : www.vidiem.in | GST NO  :  33AAACM6280D1ZT </li> </ul></div>
     <div class="header_bottom" style="width:100%; padding:0px 0;">
     <div style="width:100%;float:left;font-family:Arial;"><h1 style="color:#00BFFF;">Proforma Invoice </h1></div>
           <div style="width:99%;display:inline-block;"> <h3 style="color:#fff;padding:10px 5px;font-size:12px;font-family:Arial;background:#3B4E87;">Order Date  :&nbsp;
                &nbsp;'.date("d-M-Y", strtotime(@$order_data['created'])).'  |  Order No.  :&nbsp; &nbsp;'.@$order_data['inv_code'].' </h3></div>
            
            
        <div class="detail" style="float:left;width:49%;">
            
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;font-family:Arial;">
                <h3 style="color:#fff;padding:10px 5px;font-size:12px; background:#3B4E87;">Billing Address</h3>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_name'].'
                </li>';
                if(!empty($order_data['billing_company_name'])){
                  $data['content'].='<li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Company</span> : &nbsp; '.@$order_data['billing_company_name'].'</li>';
                }
                  $data['content'].='</li>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp;<span>'.@$order_data['billing_address'].',<br/> '.@$order_data['billing_address2'].'
                </span></li>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City</span> : &nbsp;'.@$order_data['billing_city'].'-'.$order_data['billing_zip'].'
                </li>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp;'.@$order_data['billing_state'].'
                </li>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp;'.@$order_data['billing_country'].'
                </li>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp;'.@$order_data['billing_mobile_no'].'
                </li><span style="width:65%;display:inline-flex;">
            </ul>
        </div>
       
         <div class="detail" style="float:left;width:50%;">
       

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;font-family:Arial;">
                <h3 style="color:#fff;padding:10px 5px;font-size:12px; background:#3B4E87;;">Shipping Address</h3>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> :  &nbsp;'.@$order_data['delivery_name'].'
                </li>';
                if(!empty($order_data['delivery_company_name'])){
                  $data['content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Company</span> :  &nbsp;'.@$order_data['delivery_company_name'].'</li>';
                }
                  $data['content'].='</li>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp;'.@$order_data['delivery_address'].', <br/>'.@$order_data['delivery_address2'].'
                </li>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City</span> : &nbsp;'.@$order_data['delivery_city'].'-'.$order_data['delivery_zip'].'
                </li>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp;'.@$order_data['delivery_state'].'
                </li>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp;'.@$order_data['delivery_country'].'
                </li>
                <li style="font-size:11px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp;'.@$order_data['delivery_mobile_no'].'
                </li>
            </ul>';
         
          $data['content'].='</div>
        </div>        
        <div class="form" style="width:100%;"> ';
				 $data['content'].=' 
				 
				   <div style="width:99%;display:inline-block;"> <h3 style="color:#fff;padding:10px 5px;font-size:12px;font-family:Arial;background:#3B4E87;">Items Ordered</h3></div>
				 <table style="width:100%; padding:0px 0 0px 0;font-family:Arial;border:1px solid #ccc;">
                <tr>
					<td style="width:15%">
						<img src="'.base_url('uploads/customizeimg/'.$basiciteminfo['basecolorpath']).'" style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
					</td>
					<td style="width:85%">
						<table border="0" cellspacing="4" style="width:600px;border:1px solid #CCC;margin-bottom:10px;font-size:11px;">
								<tbody>
									<tr>
										<td>Customization Code</td>
										<td>'.$basiciteminfo['cart_code'].'</td>
										<td>  </td>
										 
									</tr>
									<tr>
										<td>Body Design</td>
										<td>'.$basiciteminfo['basetitle'].'</td>
										<td>  </td>
										
									</tr>
									<tr>
										<td>Color</td>
										<td>'.$basiciteminfo['bc_title'].'</td>
											<td>'.$basiciteminfo['basecolorprice'].'</td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td>'.count($jarinfo).'</td>
											<td>Price Break - See Below</td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td>'.$basiciteminfo['motorname'].'</td>
											<td>'.$basiciteminfo['motorprice'].'</td>
									</tr>';
										if($basiciteminfo['canvas_text']!='') {		
								  $return['modal_content'].='	<tr>
										<td>Personalised message</td>
										<td>'.$basiciteminfo['canvas_text'].'</td>
									</tr> ';
										}
											'<tr>
										<td>Gift Box Message</td>
										<td>'.$basiciteminfo['message_text'].'</td>
									</tr>
									<tr>
										<td>Gift Occasion</td>
										<td>'.$basiciteminfo['occasion_text'].'</td>
									</tr>
									';
							 	
						if($basiciteminfo['package_id']!='' && !empty($basiciteminfo['package_id'])) {				
							  $data['content'].='		<tr>
										<td>Package Preference</td>
										<td>'.$basiciteminfo['packagename'].'</td>
											<td>'.$basiciteminfo['packageprice'].'</td>
									</tr> ';
						}			
						   $data['content'].='			</tbody>
							</table> ';
							
						if(count($jarinfo)>0) {	
						  $data['content'].='	<table border="0" cellpadding="3" cellspacing="0" style="width:600px;border:1px solid #CCC;margin-bottom:20px;font-size:12px;font-family:Arial;">
								<thead>
									<tr>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="border-bottom:1px solid #CCC;">Jar Information</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">No. Jars</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Unit Price</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Total Price</th>
									</tr>
								</thead>
								<tbody> ';
								foreach($jarinfo as $jar) {
									 $data['content'].='<tr>
										<td>
												<img src="'.base_url("uploads/customizeimg/jar/".$jar['jarimgpath']).'" style="margin: 0; border: 0; padding: 0; display: block;" width="60" height="60" />								
										</td>
										<td>'.$jar['jarname'].' <br> '.$jar['capacityname'].'|'.$jar['typeofjarname'].'|'.$jar['typeofhandlename'].'|'.$jar['typeoflidname'].'</td>
										<td style="text-align:center;color:#F7000A;">
											'.$jar['qty'].' Jars
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs.'.number_format($jar['price']) .'
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs. '.number_format($jar['qty']*$jar['price']).'
										</td>
									</tr> ';
								}
						}	
									
							 $data['content'].='	</tbody>
							</table>
							<table border="0"  cellspacing="5" style="width:600px;border:1px solid #CCC;margin-bottom:10px;padding:10px;font-size:11px;">
					 
							<tr><td><span style="color:#ff0000;font-size:12px;"><strong>Warranty Information</strong></span><br><br>
							- 2 Years Warranty on Product <br> - 5 Years Warranty on Motor <br> <span style="color:#ff0000;font-size:10px;"><i>(For Domestic Purpose Only)<br>Non Returnable / No Cancellation in all vidiem by you orders</i></span></td></tr></table>
							
					</td>
				</tr>
            </table> ';
		
        
                
            
                
                 $data['content'].='<table style="width:100%; padding:10px 0 10px 0;font-size:12px;">
                 <tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">SubTotal + GST 18% Included</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['sub_total'],2,'.','').'</b></th>
                </tr>';
                if($order_data['coupon_id']!=0){
					
					
					 if($order_data['discount']!=0){	
                    $data['modal_content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Coupon Discount ('.$order_data['coupon'].')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['discount'],2,'.','').'</b></th>
                </tr>';
				 }else{
					 $data['modal_content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">3 Months Extended Warranty </th>
                    <th style="padding:10px 0;text-align:right;">Free</th>
                </tr>'; 
				 }
					
					
                  /*  $data['content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Coupon Discount ('.$order_data['coupon'].')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['discount'],2,'.','').'</b></th>
                </tr>'; */
                }
                  $data['content'].='
                   
                   <tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Package Charges</th>
                    <th style="padding:10px 0;text-align:right;"> <b>Rs. '.number_format($order_data['packageprice'],2,'.','').'</b></th>
                </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#3B4E87;;text-align:right;">&nbsp;Rs. '.number_format($order_data['amount'],2,'.','').'</th>
                </tr>';
               
                   $data['content'].='<tr><td></td><td style="font-size:10px;">Note: This is computer generated invoice hence no signature required. | If you have any questions about this invoice, please write us to care@vidiem.in and If you have any queries in the orders, Please write us to orders@vidiem.in</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:10px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
            </table>
        </div>
    </div>
    </div>';
    // echo $data['content']; exit;
   // $this->load->view('Backend/pdf-page',$data);
      $html=$this->load->view('Backend/pdf-page',$data,true);
        //this the the PDF filename that user will get to download
        $pdfFilePath ="invoice-".$order_data['inv_code'].".pdf";
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