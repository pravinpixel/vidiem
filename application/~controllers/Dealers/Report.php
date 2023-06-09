<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller {

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
        // echo $this->db->last_query();
        // print_r( $_POST );die;

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
            $fileName = 'sale_report.xlsx';  

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Id');
            $sheet->setCellValue('B1', 'Date and Time');
            $sheet->setCellValue('C1', 'Location');
            $sheet->setCellValue('D1', 'Order No');
            $sheet->setCellValue('E1', 'Location Code');
            $sheet->setCellValue('F1', 'Order Id');
            $sheet->setCellValue('G1', 'Category');       
            $sheet->setCellValue('H1', 'Model Name');       
            $sheet->setCellValue('I1', 'Customer Name');       
            $sheet->setCellValue('J1', 'Customer Mobile No');       
            $sheet->setCellValue('K1', 'Address');       
            $sheet->setCellValue('L1', 'Amount Paid');       
            $sheet->setCellValue('M1', 'Pay Mode');       
            $sheet->setCellValue('N1', 'Payment Id');       
            $sheet->setCellValue('O1', 'Payment Status');       
            $rows = 2;

            if( isset( $ordersAll ) && !empty( $ordersAll ) ) {
                foreach ($ordersAll as $items ) {

                    $showItems = current($items->items);

                    $sheet->setCellValue('A' . $rows, $items->id);
                    $sheet->setCellValue('B' . $rows, date( 'd-M-Y H:i A', strtotime($items->created)) );
                    $sheet->setCellValue('C' . $rows, $items->location_name );
                    $sheet->setCellValue('D' . $rows, $items->order_no );
                    $sheet->setCellValue('E' . $rows, $items->location_code );
                    $sheet->setCellValue('F' . $rows, $items->code);
                    $sheet->setCellValue('G' . $rows, $showItems->catname ?? '' );
                    $sheet->setCellValue('H' . $rows, $showItems->basetitle ?? '');
                    $sheet->setCellValue('I' . $rows, $items->client_name ?? $items->billing_name ?? '');
                    $sheet->setCellValue('J' . $rows, $items->client_mobile_no ?? $items->billing_mobile_no ?? '');
                    $sheet->setCellValue('K' . $rows, $items->billing_address.' '.$items->billing_city.', '.$items->billing_state, ','.$items->billing_zip
                    .' '.$items->billing_country);
                    $sheet->setCellValue('L' . $rows, $items->amount);
                    $sheet->setCellValue('M' . $rows, $items->payment_source);
                    $sheet->setCellValue('N' . $rows, $items->pg_type);
                    $sheet->setCellValue('O' . $rows, $items->payment_status);
                    $rows++;
                } 
                $writer = new Xlsx($spreadsheet);
             
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$fileName.'"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                 
            } 
        }
     
        $params         = array(
                            'orders' => $orders
                        );
        
        $this->load->view('Backend/dealers/report/index', $params);
    }

    

}