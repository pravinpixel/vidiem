<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjobs extends CI_Controller {
    function __construct() {		
       parent::__construct();
    }
    
    public function index() {
        
		
    }
	public function uncompletedorder_cron() {
     
	    $unCompletedOrders=$this->ProjectModel->Select_unCompletedOrders_cron();
		
		if(count($unCompletedOrders)>0){
		
		 $msg='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
              <table border = "1" cellpadding = "5" cellspacing = "5">
                <tr>
                    <td class="" style="text-align:center;">
					Code
					</td>
					 <td class="" style="text-align:center;">
					Order Date Time
					</td>
					 <td class="" style="text-align:center;">
					Name
					</td>
					 <td class="" style="text-align:center;">
					Email
					</td>
					 <td class="" style="text-align:center;">
					Phone
					</td>
				  <td class="" style="text-align:center;">
					Order Total
					</td>
                </tr> ';
				foreach($unCompletedOrders as $order) {
				 $msg.=' <tr>
                    <td class="" style="text-align:center;">
					'.$order['code'].'
					</td>
					 <td class="" style="text-align:center;">
					'.date("Y-m-d H:i:s",strtotime($order['created'])).'
					</td>
					 <td class="" style="text-align:center;">
					'.$order['billing_name'].'
					</td>
					 <td class="" style="text-align:center;">
					'.$order['billing_emailid'].'
					</td>
					 <td class="" style="text-align:center;">
					'.$order['billing_mobile_no'].'
					</td>
				  <td class="" style="text-align:center;">
					'.$order['amount'].'
					</td>
                </tr> ';
				}
           $msg.=' </table>';
         
           //$this->FunctionModel->sendmail1('online@mayaappliances.com,care@mayaappliances.com',$msg,$subject,'care@vidiem.in',$from_mail);
		   $this->FunctionModel->sendmail1('onlinesales@mayaappliances.com,care@mayaappliances.com,saravanan.p@mayaappliances.com',$msg,"New Uncompleted Order",'care@vidiem.in','care@vidiem.in');
		
		}
		//print_r($unCompletedOrders);
		//die();
		
    }   
}