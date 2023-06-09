<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('DealersModel');
        $this->load->model('CustomizeModel');
        if( $this->session->userdata('dealer_session')['user']['user_type'] == 'sale_person' ) {
            redirect('vidiem-dealer');
        } else if( !$this->session->userdata('dealer_session') ) {
            redirect('vidiem-dealer');
        }
    }

    public function index()
    {

        $orders         = $this->DealersModel->getDealerOrdersAll();
        
        $ordersAll      = new ArrayObject();
        if( isset( $orders) && !empty($orders) ) {
            foreach ($orders as $items) {
                $tmp = $items;
                $productItems = $this->DealersModel->getDealerOrderItemsDetails($items->id);
                $tmp->items = (object)$productItems;
                $ordersAll->append($tmp);
            }
        }
        $user_type  = $this->session->userdata('dealer_session')['user']['user_type'];
        $locations      = '';
        if( isset( $user_type ) && $user_type == 'admin' ) {
            $locations  = $this->DealersModel->getDealerLocations($this->session->userdata('dealer_session')['dealer']['id']);
        }
        $params         = array(
                            'orders' => $orders,
                            'locations' => $locations
                        );
        
        $this->load->view('Backend/dealers/dashboard/index', $params);
    }

    public function orderPayment($id)
    {

        $order_data         = $this->FunctionModel->Select_Row('vidiem_customorder',array('id'=>$id));

        $orders             = $this->DealersModel->getDealerOrdersAll( $id );
        
        if( isset( $orders) && !empty($orders) ) {
            $productItems   = $this->DealersModel->getDealerOrderItemsDetails($id);
        }

		$basicItemInfo      =	$this->CustomizeModel->getOrderBasicDetails($id);
		$jarInfo            = $this->CustomizeModel->getOrderJarsDetails($id);
		
        $client             = $this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
        
        $params             = array(
                                'order_data' => $orders,
                                'order_items' => $productItems,
                                'jarInfo' => $jarInfo,
                                'basicItemInfo' => $basicItemInfo,
                                'order_id' => $id
                            );
                            
        $this->load->view( 'Backend/dealers/form/counter_payment', $params );
    }

    

    public function ajax_single_view()
    {
        
        $id                 = $this->input->post('id');
        $jar_count          = 0;
        $invoice            = '';
    	if(empty($id)){
    		$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Something Went Wrong.");
    		redirect('Admin/Customizeorders');
    	}
    	$order_data         = $this->FunctionModel->Select_Row('vidiem_customorder',array('id'=>$id));
		
		$basiciteminfo      = $this->CustomizeModel->getOrderBasicDetails($id);
		$jarinfo            = $this->CustomizeModel->getOrderJarsDetails($id);

        $order_no           = $order_data['order_no'] ?? '';
        $client             = $this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
        $return['modal_title']='View Order Details';
        if($client['email']=='')
        {
            $client['email']=$order_data['billing_emailid'];
            
        }
        $jar_amount         = 0;
        foreach($jarinfo as $jar) {

            $jar_count      += $jar['qty'];
            $jar_amount     += $jar['qty'] * $jar['price'];

        }

        $return['modal_content']='
                <style>h1 {
                    margin-top: -5px;
                }
                .container{width:100%;}
                </style>
                <div style="">
                <div class="container inCon">
                        <div style="float:left;"><h1 style="color:#00BFFF;"><img src="'.base_url('assets/front-end/images/logo.png').'" style="display:block; margin:0px auto 0 auto"/></h1></div>
                    
                        <p style="clear:both;"></p>
                    <div class="header_bottom" style="width:100%; padding:10px 0;">
                    
                        <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                        
                                <li style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E84;"><strong>Order Date</span> :&nbsp;
                                &nbsp;&nbsp;'.date("d-M-Y", strtotime(@$order_data['created'])).' &nbsp;&nbsp;| &nbsp;&nbsp;Order No. :  &nbsp;'.@$order_data['inv_code'].'</strong></li>
                            </ul>
                            
                        <div class="detail" style="float:left; width:50%; margin-top:-15px;border-left:1px #ffffff solid;">
                            <ul style="width:100%; display:inline-block; margin:1px; padding:0;list-style:none;">
                                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">Billing Address </h3>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Name</span> :  '.@$order_data['billing_name'].'
                                </li>';
        if(!empty($order_data['billing_company_name'])){
        $return['modal_content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Company</span> :  '.@$order_data['billing_company_name'].'</li>';
        }
        $return['modal_content'].='</li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Address</span> : <span style="width:65%;display:inline-flex;">'.@$order_data['billing_address'].', '.@$order_data['billing_address2'].'
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
                        <div class="logo" style="float:left; width:35%; "></div>
                        <div class="contact" style="float:right; width:50%; margin-top:-15px;">
                        

                            <ul style="width:100%; display:inline-block; margin:1px; padding:0;list-style:none;">
                                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">Shipping Address</h3>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Name</span> :  '.@$order_data['delivery_name'].'
                                </li>';
        if(!empty($order_data['delivery_company_name'])){
            $return['modal_content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Company</span> :  '.@$order_data['delivery_company_name'].'</li>';
        }
        $return['modal_content'].='</li>
                                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:20px; display:inline-block;">Address</span> : <span style="width:65%;display:inline-flex;"> '.@$order_data['delivery_address'].','.@$order_data['delivery_address2'].'
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
                        </div>        
                        <div class="form" style="width:100%;"> ';

        $invoice        .= ' 
                            <table style="width:100%; padding:20px 0 40px 0;border:1px solid #ddd">
                                <tr>
                                    <td style="width:15%">
                                        <img src="'.base_url('uploads/customizeimg/'.$basiciteminfo['basecolorpath']).'" style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
                                    </td>
                                    <td style="width:85%;">
                                        <table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;margin-top:10px;">
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
                                                        <td>'.$basiciteminfo['basecolorprice'].'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Selected Jars</td>
                                                        <td>'.$jar_count.'</td>
                                                        <td> Rs.'.number_format($jar_amount, 2).'</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Motor Power</td>
                                                        <td>'.$basiciteminfo['motorname'].'</td>
                                                        <td>'.$basiciteminfo['motorprice'].'</td>
                                                    </tr> ';
                                            if($basiciteminfo['canvas_text']!='') {		
                                                $invoice.='	<tr>
                                                        <td> Personalised message </td>
                                                        <td>'.$basiciteminfo['canvas_text'].'</td>
                                                        <td>'.$basiciteminfo['textprice'].'</td>
                                                    </tr> ';
                                            }	
                                                if($basiciteminfo['occasion_text']!='') {		
                                                $invoice.='	<tr>
                                                        <td>Gift Occasion</td>
                                                        <td>'.$basiciteminfo['occasion_text'].'</td>
                                                    </tr> ';
                                            }
                                                if($basiciteminfo['message_text']!='') {		
                                                $invoice.='	<tr>
                                                        <td>Gift Box Message</td>
                                                        <td>'.$basiciteminfo['message_text'].'</td>
                                                    </tr> ';
                                            }
                                        if($basiciteminfo['package_id']!='' && !empty($basiciteminfo['package_id'])) {				
                                            $invoice    .= '<tr>
                                                            <td> Gift Wrapping Preference </td>
                                                            <td>'.$basiciteminfo['packagename'].'</td>
                                                            <td>'.$basiciteminfo['packageprice'].'</td>
                                                        </tr> ';
                                        }			
                                        $invoice.=' 
                                                </tbody>
                                            </table> ';
                                            
                                        if( count($jarinfo)>0 ) {
                                        $invoice.='	<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
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
                                                foreach($jarinfo as $jar) {																	 $invoice.='<tr>
                                                        <td>
                                                                <img src="'.base_url("uploads/customizeimg/jar/".$jar['jarimgpath']).'" alt="" style="margin: 0; border: 0; padding: 0; display: block;" width="60" height="60" >
                                                                <br/>
                                                                <span>'.$jar['capacityname'].'|'.$jar['typeofjarname'].'|'.$jar['typeofhandlename'].'|'.$jar['typeoflidname'].'
                                                            
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
                                                    
                                            $invoice.='	</tbody>
                                            </table>
                                            
                                            <table border="0" cellspacing="5" style="width:600px;border:1px solid #CCC;margin-bottom:10px;padding:10px;font-size:11px;">
                                    
                                            <tr><td><span style="color:#ff0000;font-size:12px;"><strong>Warranty Information</strong></span><br><br>
                                            - 2 Years Warranty on Product <br> - 5 Years Warranty on Motor <br> <span style="color:#ff0000;font-size:10px;"><i>(For Domestic Purpose Only)</i></span></td></tr></table>
                                            
                                    </td>
                                </tr>
                            </table>
							
                        </td>
                    </tr>
                </table> ';
                
        $invoice    .= '<table style="width:100%; padding:20px 0 40px 0;">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th style="text-align:right;">SubTotal</th>
                                <th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['sub_total'],2,'.','').'</b></th>
                            </tr>';
				
        $invoice    .= '<tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th style="text-align:right;">Package Price</th>
                            <th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['packageprice'],2,'.','').'</b></th>
                        </tr>';
				
        $invoice    .= '<tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th style="text-align:right;font-size:14px;width:20%;">TOTAL</th>
                            <th style="color:#fff;padding:10px 0; background:#F7000A;;text-align:right;width:20%;">Rs. '.number_format($order_data['amount'],2,'.','').'</th>
                        </tr>';
               
        $invoice    .= '<tr><td></td><td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.| If you have any questions about this invoice, please write us to care@vidiem.in </td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
                        </table>
                        </div>
                    </div>
                    </div>';

        $return['modal_content'] .= $invoice;
        echo json_encode($return);
    	exit;
        
    }

}