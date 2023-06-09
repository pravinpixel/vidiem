<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjobs1 extends CI_Controller {
    function __construct() {		
       parent::__construct();
    }
    
    public function index() {
        echo "ggg";
		die();
		
    }
	public function uncompletedorder() {
        echo "ggg";
		die();
	    $unCompletedOrders=$this->ProjectModel->Select_unCompletedOrders_cron();
		echo "ggg";
		die();
		if(count($unCompletedOrders)>0){
		
		 $msg='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
              <table>
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
                </tr> '
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
		   $this->FunctionModel->sendmail1('johnpaul@pixel-studios.com',$msg,"New Uncompleted Order",'care@vidiem.in',$from_mail);
		
		}
		print_r($unCompletedOrders);
		die();
		
    }   
}