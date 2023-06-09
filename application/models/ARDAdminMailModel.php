<?php
class ARDAdminMailModel extends CI_Model {

    public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('session');
		$this->load->database();
    }

	public function ARDAdminInvoice( $order_id,$commission_id ) {
               
                //ARD Service Bill Mail Start
               // $admin_to_mail='durairaj.pixel@gmail.com';

                $admin_mail_header = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                                <span>
                                    <h1 style="color:#00BFFF;">
                                        <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                                    </h1>
                                </span>';
                $admin_mail_content = '';
                $admin_order_info                 = $this->FunctionModel->Select_Fields_Row('dealer_user_id,client_id,inv_code,created,billing_name,amount,billing_emailid,billing_mobile_no, order_no, payment_source, billing_city,billing_zip,billing_state,dealer_id, pg_type,code', 'vidiem_customorder', array('id' => $order_id));
                $admin_dealer_info                = $this->FunctionModel->getARDLocationInfo($admin_order_info['dealer_user_id']);
                $admin_ard_commission_details     = $this->FunctionModel->getARDCommissionDetails($commission_id);
                $ard_info                   = $this->FunctionModel->getARDInfo($admin_order_info['dealer_user_id']);
                $admin_ard_gst=$admin_ard_commission_details['ard_gst']/2;
                $admin_amount_words     = $this->FunctionModel->AmountInWords($admin_ard_commission_details['ard_service_bill']);
                $admin_amount_words = str_replace(array("\r", "\n"), '', $admin_amount_words);
                $admin_amount_words = preg_replace('/\s+/', ' ', $admin_amount_words);      
                $admin_client_mail_subject        = 'Vidiem By You - Dealer To ARD Service Bill | Order No :' . $admin_order_info['code'];
                $admin_mail_content               .= $admin_mail_header;
                $admin_mail_content               .= '    <div style="width:100%;text-align:center;">
        
                                                        <h2>     Greetings, Vidiem</h2>,
                                                        <h2>You may access the Service Bill here. Vidiem By You order for the order no ' . $admin_order_info['code'].' against the receipt.</h2>
                                                    </div>';
                $admin_mail_content               .= '<p>Regards</p>
                                                            <p><ARD></p>
                                                           ';
                $admin_mail_content               .= '</div>';
                $admin_current_date=date('Y-m-d H:i:s');
                $invoice_admin='';
                 $admin_mail_content               .= '
               
                <div style="border:1px solid black;">
                <div class="container inCon">
                    <div style="float:left;"><h1 style="color:#00BFFF;"><img src="' . base_url('assets/front-end/images/logo.png') . '" style="display:block; margin:4px auto 0 auto"/></h1></div>
                     <div style="float:left;"><ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                             <li style="font-size:12px; text-transform:uppercase;">Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road, Oggiam Thoraipakkam, Chennai - 600097, Tamilnadu, INDIA. 
                            |   <span style="list-style:none;line-height:28px; display:inline-block;">Phone</span> : &nbsp; 044-6635 6635 / 77110 06635  | Website</span> : &nbsp; https://vidiem.in/
                              | GST NO</span> : &nbsp; 33AAACM6280D1ZT </li>
                         </ul></div><br>
                    
                    
                    
                
                      <div style="width:100%;"><h2 style="color:#000000;" style="text-align:center;">ARD To Maya Appliances (Proforma Invoice)  </h2>  </div> ';
             
                     $admin_mail_content               .= '
                           
                     <div class="form" style="width:100%;"> ';
             
                      $admin_mail_content               .= '<table style="width: 4.8e+2pt;margin-left:5.4pt;border-collapse:collapse;">
                     <tbody>
                         <tr>
                         
                            <td rowspan="2" style="width: 7cm;border: 1pt solid black;padding: 0cm 5.4pt;height: 46.5pt;vertical-align: top;">
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">From.</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">' . $ard_info['display_name'] . '</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">' . $ard_info['address'] . '</p>
                         
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">GSTIN : ' .$ard_info['gstin_no'] . '</p>
                            </td>
                             <td rowspan="2" style="width: 7cm;border: 1pt solid black;padding: 0cm 5.4pt;height: 46.5pt;vertical-align: top;">
                             <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp;</p>
                             <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">To.</p>
                             <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">M/s.Maya Appliances (P) Ltd.,</p>
                             <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">No.3/140, I.T. Highway,</p>
                             <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">OggiamThoraipakkam,</p>
                             <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Chennai &ndash; 600 097</p>
                             <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Tamilnadu</p>
                             <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px">GSTIN :33AAACM6280D1ZT</p>
                             </td>
                            <td colspan="2" style="width: 278.05pt;border: 1pt solid black;padding: 0cm 5.4pt;height: 46.5pt;vertical-align: top;">
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Order No. : <strong>' . $admin_order_info['code'].'</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Order Date &nbsp; &nbsp; &nbsp; &nbsp; : '. $admin_order_info['created'].' </p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Under Reverse Charge:&nbsp;<s>Yes</s> / No</p>
                        </td>
                         </tr>
                         <tr>
                         
                           <td colspan="2" style="width: 278.05pt;border: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Income Tax PAN No.: ' . $ard_info['ard_pan'] . '</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">GSTIN &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :  ' . $ard_info['gstin_no'] . '</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">CIN. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : ' . $ard_info['ard_cin'] . '  </p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">HSN/SAC Code &nbsp; &nbsp; &nbsp; &nbsp; : 996211</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Type of Service &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: Referral Commission on Sales</p>
                     </td>
                     
                            
                         </tr>
                         <tr>
                             <td colspan="2" style="width:342.75pt;border:1pt solid black;padding:0cm 5.4pt 0cm 5.4pt;height:20.25pt;">
                                 <h3 style="margin:0cm;margin-bottom:.0001pt;text-align:center;text-indent:-36.0pt;font-size:17px;margin-left:36.0pt;"><span style="font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style="font-size:16px;">Particulars</span></h3>
                             </td>
                             <td style="width:133.75pt;border:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:20.25pt;">
                                 <h3 style="margin:0cm;margin-bottom:.0001pt;text-align:center;text-indent:0cm;font-size:17px;"><span style="font-size:16px;">Amount</span></h3>
                             </td>
                         </tr>
                         <tr>
                             <td colspan="2" rowspan="2" style="width: 342.75pt;border: 1pt solid; blackpadding: 0cm 5.4pt;height: 110.8pt;vertical-align: top;">
                                
                                 
                                
                                  <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;margin-left:54.0pt;">&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;margin-left:54.0pt;">&nbsp;</p>
                                
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;margin-left:54.0pt;">Referral Commission&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;margin-left:36.0pt;">&nbsp; &nbsp; &nbsp;&nbsp;</p>
                              
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' . $admin_order_info['billing_name'].',&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ' . $admin_order_info['billing_city'].',</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ' . $admin_order_info['billing_state'].',</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ' . $admin_order_info['billing_zip'].'.</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>
                                   <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Order No: <strong>' . $admin_order_info['code'].'</strong> |  Order Amount: <strong>' . $admin_order_info['amount'].'</strong> </p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; TOTAL</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;color:black;"><span style="font-size:17px;">&nbsp;</span></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;color:black;"><span style="font-size:17px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;CGST @ 9%</span></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;color:black;"><span style="font-size:17px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SGST @ 9%</span></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;color:black;"><span style="font-size:17px;">&nbsp;</span></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp;</p>
                                 <h3 style="margin:0cm;margin-bottom:.0001pt;text-align:center;text-indent:-36.0pt;font-size:17px;margin-left:36.0pt;"><span style="font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style="font-size:16px;">GRAND TOTAL</span></h3>
                                 <h3 style="margin:0cm;margin-bottom:.0001pt;text-align:left;text-indent:-36.0pt;font-size:17px;margin-left:36.0pt;"><span style="font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style="font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></h3>
                             </td>
                             <td style="width: 133.75pt;border: 1pt solid black;padding: 0cm 5.4pt;height: 110.8pt;vertical-align: top;">
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>-
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">'.number_format($admin_ard_commission_details['ard_commission'],2).'</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>
                             </td>
                         </tr>
                         <tr>
                             <td style="width:133.75pt;border:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:125.45pt;">
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>&nbsp;</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;"><strong>&nbsp;</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>'.number_format($admin_ard_commission_details['ard_commission'],2).'</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>&nbsp;</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>'.number_format($admin_ard_gst,2).'</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>'.number_format($admin_ard_gst,2).'</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>&nbsp;</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>&nbsp;</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>---------------------------</strong></p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>'.round($admin_ard_commission_details['ard_service_bill']).'</strong></p>
                             </td>
                         </tr>
                         
                         <tr>
                             <td colspan="3" style="width:476.5pt;border:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:40.0pt;">
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Rupees : '.$admin_amount_words.' Only</p>
                             </td>
                         </tr>
                          
                         
                     </tbody>
                 </table>
                 <div style="float:left;">
                 <p>E. & O.E</p>
                 </div>
                 <div style="float:right;">
                 <p style="margin-left:60%;">For</p><br><br><br>
                    <p style="margin-left:50%;"><strong>Authorised Signatory<strong></p>
                 </div></div></div></div>';    
                 //print_r($invoice_admin); die;
                    $pdfObject_admin = '';
                     $this->load->library('m_pdf');
                     
                     $pdfObject_admin = $this->m_pdf;
                     $pdfObject_admin->pdf->AddPage(
                         'P', // L - landscape, P - portrait
                         '',
                         '',
                         '',
                         '',
                         7, // margin_left
                         3, // margin right
                         5, // margin top
                         5, // margin bottom
                         5, // margin header
                         5
                     ); // margin footer
                     //generate the PDF from the given html
                   
                     $file_name_admin = 'uploads/invoice_ard/vidiem_ard_admin_Invoice.pdf';
                     $pdfObject_admin->pdf->WriteHTML($invoice_admin);
                     $attachdata_admin = $pdfObject_admin->pdf->Output($file_name_admin, 'S');
                     $attachdata_admin1='';
                    
                    $cc_admin_mail='mktg1@mayaappliances.com,onlinesales@mayaappliances.com';
                    $admin_to_mail='accounts@mayaappliances.com,itsupport@mayaappliances.com,umashankar.k@mayaappliances.com,taxation@mayaappliances.com,receivables@mayaappliances.com,saravanan.p@mayaappliances.com,satheyaraaj.t@mayaappliances.com';
                    //$cc_admin_mail='naveenkumar.pixel@gmail.com';
        
                    $admin_client_mail_subject='VBY - ARD to MAPL Service Bill | Order No :'.$admin_order_info['code'];
                    
                     $this->FunctionModel->send_office_mail_dealer($admin_to_mail,$cc_admin_mail, $admin_mail_content, $admin_client_mail_subject,  'orders@vidiem.in',$attachdata_admin1);
                 //$pdfObject_admin->pdf->WriteHTML(false);
                //ARD Service Bill Mail End
                //VBY - Dealer To ARD Service Bill | Order No : <order no>
        
        
    }

   
}
?>