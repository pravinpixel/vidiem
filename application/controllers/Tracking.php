<?php
ini_set("display_errors", 1);
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('HomeModel');
        $this->load->model('FunctionModel');
        $this->load->model('TrackingModel');
        $this->load->library('cart');
    }
    
    public function index() {
        
        $data = array(
            'title' => 'Tracking Order'
        );
        $this->load->view('tracking',$data );
        
    }

 public function get_tracking_info()
    {

        $this->form_validation->set_rules('code','Invoice Number','required');
        $this->form_validation->set_rules('email','Email','required');

        if($this->form_validation->run()==TRUE) {

            $invoice_code               = $this->input->post( 'code', true );
            $email                      = $this->input->post( 'email', true );
            $order_type                 = $this->input->post( 'order_type');
            if($order_type=='normal_order')
            {
                 $orderInfo                  = $this->TrackingModel->getNormalOrder($invoice_code, $email);
            }
            else
            {
                 $orderInfo                  = $this->TrackingModel->getCustomerOrder($invoice_code, $email);
            }

           
            
            if( isset( $orderInfo ) && !empty( $orderInfo ) ) {
                
                if($order_type=='normal_order')
                {
                       $gerCustomOrderInfos    = $this->TrackingModel->getOrderTrackingData($orderInfo->id, 'normal_order');
                }
                else
                {
                      $gerCustomOrderInfos    = $this->TrackingModel->getOrderTrackingData($orderInfo->id, 'custom_order');
                }
                $trackItems             = [];
                if( isset($gerCustomOrderInfos ) && !empty( $gerCustomOrderInfos ) ) {
                    foreach ($gerCustomOrderInfos as $items ) {
                        $trackItems[$items->order_status]  = $items;
                    }
                }
              
                if($order_type=='normal_order')
                {
                    if(empty($trackItems))
                    {
                          
                        $trackItems2=$orderInfo ;
                    }
                }
                else
                {
                     $trackItems2='';
                }
                
            }
            
            $params         = array( 'orderInfo' => $orderInfo, 'trackingDetails' => $trackItems,'trackItems2' =>  $trackItems2);

            $view           = $this->load->view('tracking/tracking_url', $params, true );

            $error          = 1;
            $error_message  = '';

        } else {

            $error_message  = validation_errors();
            $error          = 0;
            $view           = '';

        }

        echo json_encode( [ 'error' => $error, 'error_message' => $error_message, 'view' => $view ] );

    }

    public function test_mail() {
        
        $this->FunctionModel->test_mail();
    }

    public function test_sms()
    {
        $sms_content    = "Thank you for shopping with Vidiem through our Dealer Durai raj. Your order number 200222 is under production. We'll share the tracking details once the shipment is ready. -VIDIEM";
        $this->ProjectModel->SMSContentDealer('9551706025',$sms_content);
    }
    
}