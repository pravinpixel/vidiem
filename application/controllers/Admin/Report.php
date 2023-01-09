<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller {
	function __construct() {
        parent::__construct();
      $this->load->helper(array('url', 'form'));
      $this->load->library('form_validation', 'session', 'upload');
      $this->load->model(array('Accessmodel','ReportModel', 'DealersModel'));
      $this->load->library('slug');
          if(!$this->session->userdata('user_logged_in')){
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Access Denied.");
        redirect('Admin', 'refresh');
      }
  }

   public function sales_report(){
        if(!empty($this->input->post('date'))){
        $input_value='?';
        foreach ($_POST as $key => $info) {
          $input_value.=$key.'='.$info.'&'; 
        }
        $data['data_string']=$input_value;
        $date_range=$this->input->post('date');
        $date=$this->ReportModel->Day_Divider($date_range);
              $status=$this->input->post('status');
              $reportuser=$this->input->post('reportuser');
              $from=date('Y-m-d',strtotime($date['from']));
              $to=date('Y-m-d',strtotime($date['to']));
         $data['DataResult']=$this->ReportModel->SalesReport($from,$to,$status,$reportuser);
        }else{
        $from=date('Y-m-d',strtotime('-1 Month'));
        $to=date('Y-m-d');
        $data['DataResult']=$this->ReportModel->SalesReport($from,$to);
       }
      $this->load->view('Backend/report-sales',@$data);
   } 

   public function sales_report_export(){
        $date_range=$this->input->get('date');
      if(!empty($date_range)){
        $date=$this->ReportModel->Day_Divider($date_range);
        $from=date('Y-m-d',strtotime($date['from']));
        $to=date('Y-m-d',strtotime($date['to']));
      }else{
        $from=date('Y-m-d',strtotime('-1 Month'));
        $to=date('Y-m-d');
      }
      $status=$this->input->post('status');
      $DataResult=$this->ReportModel->SalesReport($from,$to,$status);
           $data['report'] ='<thead>
                <tr>
                  <th>S.No</th>
                  <th>Inv Code</th>
                  <th>Clinet Name</th>
                  <th>Mobile No</th>
                  <th>Email</th>
                  <th>Payment Source</th>
                  <th>Payment Type</th>
                  <th>BankRef. No.</th>
                  <th>Amount</th>
                  <th>Discount</th>
                  <th>Gst</th>
                  <th>Net Amount</th>
                  <th>Order Status</th>
                  <th>Notes</th>
                  <th>Created</th>
                </tr>
                </thead>
                <tbody>';
               if(!empty($DataResult)){  
                $order_status=$this->ProjectModel->OrderStatus();
                    $x=1; $sub_total=0; $discount=0; $tax=0; $amount=0;
                  foreach ($DataResult as $info) { 
                 $data['report'] .='<tr>
                  <td class="col-xs-1">'.$x.'</td>
                  <td>'.$info['inv_code'].'</td>
                  <td>'.$info['delivery_name'].'</td>
                  <td>'.$info['delivery_mobile_no'].'</td>
                  <td>'.$info['delivery_emailid'].'</td>
                  <td>'.$info['payment_source'].'</td>
                  <td>'.$info['pg_type'].'</td>
                  <td>'.$info['bank_ref_num'].'</td>
                  <td>'.$info['sub_total'].'</td>
                  <td>'.$info['discount'].'</td>
                  <td>'.$info['tax'].'</td>
                  <td>'.$info['amount'].'</td>
                  <td>'.$order_status[$info['status']].'</td>
                  <td>'.$info['notes'].'</td>
                  <td>'.$info['created'].'</td>
                </tr>';
               $sub_total+=$info['sub_total']; 
                $discount+=$info['discount'];
                $tax+=$info['tax'];
                $amount+=$info['amount'];
                 $x++; }
                   $data['report'] .='<tr>
                  <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                  <td>'.number_format($sub_total,2).'</td>
                  <td>'.number_format($discount,2).'</td>
                  <td>'.number_format($tax,2).'</td>
                  <td>'.number_format($amount,2).'</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>';
                }else { 
                $data['report'] .='<tr>
                  <td colspan="14">No Data Available...</td>
                </tr>';
                 } 
                 $data['report'].='</tbody>';
        $this->load->view('Backend/excel_export',@$data);   
    }
    
    
     public function sales_products(){
        if(!empty($this->input->post('date'))){
        $input_value='?';
        foreach ($_POST as $key => $info) {
          $input_value.=$key.'='.$info.'&'; 
        }
        $data['data_string']=$input_value;
        $date_range=$this->input->post('date');
        $date=$this->ReportModel->Day_Divider($date_range);
              $status=$this->input->post('status');
              $reportuser=$this->input->post('reportuser');
              $from=date('Y-m-d',strtotime($date['from']));
              $to=date('Y-m-d',strtotime($date['to']));
         $data['DataResult']=$this->ReportModel->ProductReport($from,$to,$status,$reportuser);
        }else{
        $from=date('Y-m-d',strtotime('-1 Month'));
        $to=date('Y-m-d');
        $data['DataResult']=$this->ReportModel->ProductReport($from,$to);
        // echo $this->db->last_query();
       }
      $this->load->view('Backend/report-products',@$data);
   } 

   public function sales_products_export(){
        $date_range=$this->input->get('date');
      if(!empty($date_range)){
        $date=$this->ReportModel->Day_Divider($date_range);
        $from=date('Y-m-d',strtotime($date['from']));
        $to=date('Y-m-d',strtotime($date['to']));
      }else{
        $from=date('Y-m-d',strtotime('-1 Month'));
        $to=date('Y-m-d');
      }
      $status=$this->input->post('status');
      $DataResult=$this->ReportModel->ProductReport($from,$to,$status);
           $data['report'] ='<thead>
                <tr>
                  <th>S.No</th>
                  <th>Inv Code</th>
                  <th>Clinet Name</th>
                  <th>Mobile No</th>
                  <th>Email</th>
                  <th>Payment Source</th>
                  <th>Payment Type</th>
                  <th>BankRef. No.</th>
                  <th>Product Name</th>
                  <th>Amount</th>
                  <th>Qty</th>
                  <th>Sub Total Amount</th>
                  <th>Order Status</th>
                  <th>Created</th>
                </tr>
                </thead>
                <tbody>';
               if(!empty($DataResult)){  
                $order_status=$this->ProjectModel->OrderStatus();
                    $x=1; $sub_total=0; $discount=0; $tax=0; $amount=0;
                  foreach ($DataResult as $info) { 
                 $data['report'] .='<tr>
                  <td class="col-xs-1">'.$x.'</td>
                  <td>'.$info['inv_code'].'</td>
                  <td>'.$info['delivery_name'].'</td>
                  <td>'.$info['delivery_mobile_no'].'</td>
                  <td>'.$info['delivery_emailid'].'</td>
                  <td>'.$info['payment_source'].'</td>
                  <td>'.$info['pg_type'].'</td>
                  <td>'.$info['bank_ref_num'].'</td>
                  <td>'.$info['productname'].'</td>
                  <td>'.$info['product_price'].'</td>
                  <td>'.$info['product_qty'].'</td>
                  <td>'.$info['subtotal_amt'].'</td>
                  <td>'.$order_status[$info['status']].'</td>
                  <td>'.$info['created'].'</td>
                </tr>';
               $sub_total+=$info['subtotal_amt']; 
                $discount+=$info['discount'];
                $tax+=$info['tax'];
                $amount+=$info['subtotal_amt'];
                 $x++; }
                   $data['report'] .='<tr>
                  <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>'.number_format($amount,2).'</td>
                  <td></td>
                  <td></td>
                </tr>';
                }else { 
                $data['report'] .='<tr>
                  <td colspan="14">No Data Available...</td>
                </tr>';
                 } 
                 $data['report'].='</tbody>';
        $this->load->view('Backend/excel_export',@$data);   
    }


	 public function index() {
	 	 if(!empty($this->input->post('date'))){
	 	 	$input_value='?';
	 	 	foreach ($_POST as $key => $info) {
	 	 		$input_value.=$key.'='.$info.'&';	
	 	 	}
	 	 	$data['data_string']=$input_value;
	 	 	$date_range=$this->input->post('date');
			$date=$this->ReportModel->Day_Divider($date_range);
            $mode=$this->input->post('mode');
            $type=$this->input->post('payment_type');
            $payment_mode=$this->input->post('payment_mode');
            $from=date('Y-m-d',strtotime($date['from']));
            $to=date('Y-m-d',strtotime($date['to']));
			$data['DataResult']=$this->ReportModel->PaymentReport($from,$to,$mode,$type,$payment_mode);
	 	  }else{
	 	 	$from=date('Y-m-d',strtotime('-1 Month'));
	 	 	$to=date('Y-m-d');
	 	 	$data['DataResult']=$this->ReportModel->PaymentReport($from,$to);
	 	 }
		  $this->load->view('Backend/report-payment',@$data);
    }

    public function export(){
    		$date_range=$this->input->get('date');
			$date=$this->ReportModel->Day_Divider($date_range);
        $mode=$this->input->get('mode');
        $type=$this->input->get('payment_type');
        $payment_mode=$this->input->get('payment_mode');
        $from=date('Y-m-d',strtotime($date['from']));
        $to=date('Y-m-d',strtotime($date['to']));
			$Gateway=array('0'=>'','1'=>'Cash/ Bank','2'=>'CCAvenue','3'=>'Payumony');
			$DataResult=$this->ReportModel->PaymentReport($from,$to,$mode,$type,$payment_mode);
    	     $data['report'] ='<thead>
                <tr>
                  <th>S.No</th>
                  <th>Inv Code</th>
                  <th>Client Code</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>City</th>
                  <th>Type</th>
                  <th>Gateway</th>
                  <th>Mode</th>
                  <th>Course Amount</th>
                  <th>PG Charges</th>
                  <th>Gst Amount</th>
                  <th>Net Amount</th>
                  <th>Created</th>
                </tr>
                </thead>
                <tbody>';
               if(!empty($DataResult)){  
                  $x=1; $course_amount=0; $pg_charges=0; $gst_charges=0; $amount=0;
                  foreach ($DataResult as $info) { 
                 $data['report'] .='<tr>
                 <td class="col-xs-1">'.$x.'</td>
                  <td>'.$info['inv_code'].'</td>
                  <td>'.$info['user_code'].'</td>
                  <td>'.$info['name'].'</td>
                  <td>'.$info['mobile_no'].'</td>
                  <td>'.$info['email'].'</td>
                  <td>'.$info['city'].'</td>
                  <td>'.($info['booking_mode']==1?'Online':($info['booking_mode']==2?'Manual':'')).'</td>
                  <td>'.$Gateway[$info['booking_type']].'</td>
                  <td>'.$info['payment_mode'].'</td>
                  <td>'.$info['course_amount'].'</td>
                  <td>'.$info['pg_charges'].'</td>
                  <td>'.$info['gst_charges'].'</td>
                  <td>'.$info['amount'].'</td>
                  <td>'.$info['created'].'</td>
                </tr>';
                $course_amount+=$info['course_amount']; 
                $pg_charges+=$info['pg_charges'];
                $gst_charges+=$info['gst_charges'];
                $amount+=$info['amount'];
                 $x++; }
                   $data['report'] .='<tr>
                  <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                  <td>'.number_format($course_amount,2).'</td>
                  <td>'.number_format($pg_charges,2).'</td>
                  <td>'.number_format($gst_charges,2).'</td>
                  <td>'.number_format($amount,2).'</td>
                  <td></td>
                  <td></td>
                </tr>';
                }else { 
                $data['report'] .='<tr>
                  <td colspan="10">No Data Available...</td>
                </tr>';
                 } 
                 $data['report'].='</tbody>';
      $this->load->view('Backend/excel_export',@$data);   
    }

    public function dealer_sales_report()
    {
      
      $orders         = $this->DealersModel->getDealerSaleOrdersAll();      
      $ordersAll      = new ArrayObject();
      if( isset( $orders) && !empty($orders) ) {
        foreach ($orders as $items) {
          $tmp = $items;
          $productItems = $this->DealersModel->getDealerOrderItemsDetails($items->id);
          $tmp->items = (object)$productItems;
          $ordersAll->append($tmp);
        }
      }
      
      if( $this->input->post('export', true ) ) {
        $fileName = 'sale_dealers_report.xlsx';  

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Date and Time');
        $sheet->setCellValue('C1', 'Dealers');
        $sheet->setCellValue('D1', 'Location');
        $sheet->setCellValue('E1', 'Location Code');
        $sheet->setCellValue('F1', 'Order No');
        $sheet->setCellValue('G1', 'Order Id');
        $sheet->setCellValue('H1', 'Category');       
        $sheet->setCellValue('I1', 'Model Name');       
        $sheet->setCellValue('J1', 'Customer Name');       
        $sheet->setCellValue('K1', 'Customer Mobile No');       
        $sheet->setCellValue('L1', 'Address');       
        $sheet->setCellValue('M1', 'Amount Paid');       
        $sheet->setCellValue('N1', 'Pay Mode');       
        $sheet->setCellValue('O1', 'Payment Id');       
        $sheet->setCellValue('P1', 'Payment Status');       
        
        $rows = 2;

        if( isset( $ordersAll ) && !empty( $ordersAll ) ) {
            foreach ($ordersAll as $items ) {

                $showItems = current($items->items);

                $sheet->setCellValue('A' . $rows, $items->id);
                $sheet->setCellValue('B' . $rows, date( 'd-M-Y H:i A', strtotime($items->created)) );
                $sheet->setCellValue('C' . $rows, $items->display_name );
                $sheet->setCellValue('D' . $rows, $items->location_name );
                $sheet->setCellValue('E' . $rows, $items->location_code );
                $sheet->setCellValue('F' . $rows, $items->order_no );
                $sheet->setCellValue('G' . $rows, $items->inv_code);
                $sheet->setCellValue('H' . $rows, $showItems->catname ?? '' );
                $sheet->setCellValue('I' . $rows, $showItems->basetitle ?? '');
                $sheet->setCellValue('J' . $rows, $items->client_name ?? $items->billing_name ?? '');
                $sheet->setCellValue('K' . $rows, $items->client_mobile_no ?? $items->billing_mobile_no ?? '');
                $sheet->setCellValue('L' . $rows, $items->billing_address.' '.$items->billing_city.', '.$items->billing_state, ','.$items->billing_zip
                .' '.$items->billing_country);
                $sheet->setCellValue('M' . $rows, $items->amount);
                $sheet->setCellValue('N' . $rows, $items->payment_source);
                $sheet->setCellValue('O' . $rows, $items->pg_type);
                $sheet->setCellValue('P' . $rows, $items->payment_status);
                $rows++;
            } 
            $writer = new Xlsx($spreadsheet);
          
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } 
    }

    
      $data['orders']     = $orders;
      $this->load->view('Backend/reports-dealers',@$data);   

    }
	
}