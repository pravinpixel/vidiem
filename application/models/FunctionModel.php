<?php
class FunctionModel extends CI_Model {
     function __construct()
    {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('session');
		$this->load->database();
    }
	
	/*================ Insert ==================*/
	public function Insert($data,$table){
		$data = $this->security->xss_clean($data);
		$this->db->insert($table,$data); 
		$insert_id = $this->db->insert_id(); 
		return $insert_id;
	}
	
	/*================ Update ==================*/
	public function Update($data,$table,$where){
		$data = $this->security->xss_clean($data);
		$this->db->where($where);
		$this->db->update($table, $data);
	 	return $this->db->affected_rows();
	}
	
	/*================ Delete ==================*/
	public function Delete($table,$where){
		$query = $this->db->delete($table,$where);
		return $this->db->affected_rows();
	}
	
	/*================ Select ==================*/
	public function Select($table,$where=array(),$order_by='',$order_type='',$limit='',$offset=''){
		$query = $this->db->order_by($order_by,$order_type)->get_where($table,$where, $limit, $offset);
	    return $query->result_array();
	}
	
	
	
		/*================ Select ==================*/
	public function Select_order($table, $where = array(), $order_by = '', $order_type = '', $limit = '', $offset = '')
	{
		$query = $this->db->order_by($order_by, $order_type)->get_where($table, $where, $limit, $offset);
		return $query->result_array();
	}
	
	
	
	
	/*================ Select Row ==================*/
	public function Select_Row($table,$where=array(),$order_by='',$order_type='',$limit='',$offset=''){
		$query = $this->db->order_by($order_by,$order_type)->get_where($table,$where, $limit, $offset);
		
	    return $query->row_array();
	}
	
	/*================ Select Field ==================*/
	public function Select_Field($field,$table,$where=array(),$order_by='',$order_type='',$limit='',$offset=''){
		$query = $this->db->select($field)->order_by($order_by,$order_type)->get_where($table,$where,$limit,$offset);
		$data=$query->row_array();
	    return $data[$field];
	}
	
	/*================ Select Fields ==================*/
	public function Select_Fields($field,$table,$where=array(),$order_by='',$order_type='',$limit='',$offset=''){
		$query = $this->db->select($field)->order_by($order_by,$order_type)->get_where($table,$where,$limit,$offset);
		return $query->result_array();
	}
	
	/*================ Select Fields Row==================*/
	public function Select_Fields_Row($field,$table,$where=array(),$order_by='',$order_type='',$limit='',$offset=''){
		$query = $this->db->select($field)->order_by($order_by,$order_type)->get_where($table,$where,$limit,$offset);
		return $query->row_array();
	}
	
	/*================ Select Sum==================*/
	public function Select_Sum($field,$table,$where=array()){
		$query = $this->db->select_sum($field)->get_where($table,$where);
		$data=$query->row_array();
		return $data[$field];
	}

    /*================ Row Count==================*/
	public function Row_Count($table,$where=array()){
		$this->db->where($where);
		$count=$this->db->count_all_results($table);
		return $count;
	}
	
	/*============== Password Generate ==============*/
	public function NewPassword($chars_min=10, $chars_max=12)
    {
        $use_upper_case=false;
		$length = rand($chars_min, $chars_max);
        $selection = 'AEUOYIBCDFGHJKLMNPQRSTVWXZ1234567890';
        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
            $password .=  $current_letter;
        }                
      return $password;
    }
	
	/*============== Times Ago ==============*/
	public function GetTimeAgo($time_ago)
    {
		$time_ago = strtotime($time_ago);
		$cur_time   = time();
		$time_elapsed   = $cur_time - $time_ago;
		$seconds    = $time_elapsed ;
		$minutes    = round($time_elapsed / 60 );
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400 );
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640 );
		$years      = round($time_elapsed / 31207680 );
		// Seconds
		if($seconds <= 60){
			return "Just now";
		}
		//Minutes
		else if($minutes <=60){
			if($minutes==1){
				return "one minute ago";
			}
			else{
				return "$minutes minutes ago";
			}
		}
		//Hours
		else if($hours <=24){
			if($hours==1){
				return "an hour ago";
			}else{
				return "$hours hrs ago";
			}
		}
		//Days
		else if($days <= 7){
			if($days==1){
				return "yesterday";
			}else{
				return "$days days ago";
			}
		}
		//Weeks
		else if($weeks <= 4.3){
			if($weeks==1){
				return "a week ago";
			}else{
				return "$weeks weeks ago";
			}
		}
		//Months
		else if($months <=12){
			if($months==1){
				return "a month ago";
			}else{
				return "$months months ago";
			}
		}
		//Years
		else{
			if($years==1){
				return "one year ago";
			}else{
				return "$years years ago";
			}
		}
    }
	
	/*==========  Months and Date List ==============*/
	public function Month() {
		$month=array('1'=>'01','2'=>'02','3'=>'03','4'=>'04','5'=>'05','6'=>'06','7'=>'07','8'=>'08','9'=>'09','10'=>'10','11'=>'11','12'=>'12');
        return $month;
    }
	
	public function Date() {
	   $date=array('01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20','21'=>'21','22'=>'22','23'=>'23','24'=>'24','25'=>'25','26'=>'26','27'=>'27','28'=>'28','29'=>'29','30'=>'30','31'=>'31');
	   return $date;
    }
	
	/*==========  Amount to Words ============*/
	public function Get_Amount_Str($number){
		$no = round($number);
		$point = round($number - $no, 2) * 100;
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'one', '2' => 'two',
		'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
		'7' => 'seven', '8' => 'eight', '9' => 'nine',
		'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
		'13' => 'thirteen', '14' => 'fourteen',
		'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
		'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
		'30' => 'thirty', '40' => 'fourty', '50' => 'fifty',
		'60' => 'sixty', '70' => 'seventy',
		'80' => 'eighty', '90' => 'ninety');
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_1) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += ($divider == 10) ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number] .
				" " . $digits[$counter] . $plural . " " . $hundred
				:
				$words[floor($number / 10) * 10]
				. " " . $words[$number % 10] . " "
				. $digits[$counter] . $plural . " " . $hundred;
			} else $str[] = null;
		}
		$str = array_reverse($str);
		$result = implode('', $str);
		$points = ($point) ?
		"." . $words[$point / 10] . " " . 
		$words[$point = $point % 10] : '';
		$s=$result;
		return $s;
	}
 
	public function AmountStr($amount){
		$str1=$this->Get_Amount_Str(substr($amount,0,-2));
		$str=ucwords($str1).' Rupees ';
		$tmp=substr(number_format($amount,2),-2);
		if($tmp!='00'){
			$str2=$this->Get_Amount_Str($tmp);
			$str=$str.ucwords($str2).' Paise';
		}
		return $str;
	}
	
	/*=============== Mail Functions ================*/
	 public function sendmail_smtp($email2, $msg3, $subject1, $from_email) {
	     
	     $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.vidiem.in',
            'smtp_port' => 25,
            'smtp_crypto' => 'None',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
		$from_email="vetriselvam.pixel@gmail.com";
		$email2="vetriselvam.pixel@gmail.com";
		$msg3="vetriselvam.pixel@gmail.com";
			$subject1=" Test mail content ";
		$this->email->attach($attchment, "attachment", 'invoice.pdf','application/pdf',TRUE);
        $this->email->from($from_email); // change it to yours
        $this->email->to($email2); // change it to yours
        $this->email->subject($subject1);
        $this->email->message($msg3);
        $result = $this->email->send();
        echo '<pre>'; print_r($result); echo '</pre>'; exit;
    } 
    
    	public function send_dealer_attach_mail($to_email,$cc_mail, $msg, $subject, $from_email = '', $attchment = null)
	{

		$this->load->library('email');
		
		$tmp['smtp_host'] = "smtp.office365.com";
		$tmp['smtp_port'] = "587";
		$tmp['smtp_user'] = "orders@vidiem.in"; 
		$tmp['smtp_pass'] = "Fus32406";
		$tmp['charset'] = "utf-8";
		$tmp['mailtype'] = "html";
		
		// $this->load->library('email',$tmp);
		$this->email->initialize($tmp);
		$this->email->set_newline("\r\n");  
		$this->email->from('orders@vidiem.in', 'Orders Vidiem');
    	$this->email->bcc('erp@mayaappliances.com,naveenkumar.pixel@gmail.com');
		$this->email->to($to_email);
		$this->email->cc($cc_mail);
		// $this->email->reply_to('durairaj.pixel@gmail.com');
		$this->email->subject($subject);
		$this->email->message($msg);
		if (!empty($attchment)) {
			$this->email->attach($attchment);
		}
		$result 			= $this->email->send();

		// if ($this->email->send()) {
		// 	echo 'Your email was sent, thanks chamil.';
		// } else {
		// 	show_error($this->email->print_debugger());
		// }
		$this->email->clear();
		return $result;
	}
	
	public function sendmail($to_email,$msg,$subject,$from_email,$attchment=null) {
            $config 		= array(
								'mailtype' => 'html',
								'charset' => 'utf-8',
								'newline' => "\r\n"
							);
            $config['crlf'] = "\r\n";  
            $this->load->library('email',$config);
            $this->email->from($from_email); // change it to yours
            $this->email->to($to_email); // change it to yours
            	$this->email->bcc('erp@mayaappliances.com');
            $this->email->subject($subject);
            $this->email->message($msg);
            if(!empty($attchment)){
            	 $this->email->attach($attchment, "attachment", 'invoice.pdf','application/pdf',TRUE);
            }
            $result 			= $this->email->send();
			$this->email->clear();
            return $result;
    }
    public function sendmail1($to_email,$msg,$subject,$from_email,$reply_mail=null) {
            $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n");
            $config['crlf'] = "\r\n"; 
            $this->load->library('email',$config);
            $this->email->from($from_email); // change it to yours
            $this->email->to($to_email); // change it to yours
            	$this->email->bcc('erp@mayaappliances.com');
            if(!empty($reply_mail)){
            	$this->email->reply_to($reply_mail);
            }
            $this->email->subject($subject);
            $this->email->message($msg);
            $this->email->send();
    }

	public function test_mail() {
		$this->load->library('email');
		
		$tmp['smtp_host'] = "smtp.office365.com";
		$tmp['smtp_port'] = "587";
		$tmp['smtp_user'] = "orders@vidiem.in"; 
		$tmp['smtp_pass'] = "Fus32406";
		$tmp['charset'] = "utf-8";
		$tmp['mailtype'] = "html";
		
		// $this->load->library('email',$tmp);
		$this->email->initialize($tmp);
		$this->email->set_newline("\r\n");  

		$this->email->from('orders@vidiem.in', 'Orders Vidiem');
		$list = array('durairaj.pixel@gmail.com');

		$this->email->to($list);
		$this->email->reply_to('durairaj.pixel@gmail.com');
		$this->email->subject('This is an email test');
		$this->email->message('It is working. Great!');

		if ($this->email->send()) {
			echo 'Your email was sent, thanks chamil.';
		} else {
			show_error($this->email->print_debugger());
		}
		
	}
    
    function export_data($data,$filename='document')
	{
		$this->load->library("excel");
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
        $head=array_keys((array)$data[0]);
		$table_columns = $head;
		$column = 0;
		foreach($table_columns as $field)
		{
			 $object->getActiveSheet()->setCellValueByColumnAndRow($column,1, $field);
			 $object->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
			 $column++;
		}
		$excel_row = 2;
		foreach($data as $row)
		{
			$colcount=0;
			foreach($row as $key=>$value){
				$object->getActiveSheet()->setCellValueByColumnAndRow($colcount, $excel_row, $value);
				$colcount++;
				
			}
			$object->getActiveSheet()->getRowDimension($excel_row)->setRowHeight(18);
			$excel_row++;
		}
		$object_writer = PHPExcel_IOFactory::createWriter($object,'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        $filenamenew=time().".xls";
		$object_writer->save("uploads/exports/".$filenamenew);
		ob_start();
		$object_writer->save("php://output");
		$xlsData = ob_get_contents();
		ob_end_clean();
		$response =  array(
				'op' => 'ok',
				'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData),
				'filename' => $filename,
                'downloadurl'=>'https://www.vidiem.in/uploads/exports/'.$filenamenew
			);
		die(json_encode($response));
	}
	
	public function Select_subcategoryfilters($subcatids){

		$this->db->select('id,slug,name,image,price,old_price,outofstock,list_description');
		$this->db->from('vidiem_products');
		$this->db->where('status',1);
		$this->db->where_in('sub_cat_id',$subcatids);
		$this->db->order_by('order_no','asc');
		$result=$this->db->get()->result();
		//echo $this->db->last_query(); exit;
		return $result;
	}

	public function getExclusiveMenu()
	{
		$details = $this->db->select('vidiem_products.id as product_id, vidiem_products.name as product_name, vidiem_category.name,vidiem_category.id as category_id, vidiem_category.slug ')
					->join('vidiem_category', 'vidiem_category.id = vidiem_products.cat_id')
					->where('exclusive', 1)
					->group_by('vidiem_products.cat_id')
					->get('vidiem_products');

		if( $details->num_rows() > 0 ) {
			return $details->result();
		} else {
			return null;
		}
				
	}

	public function getDealerLocationInfo($user_id)
	{
		$details = $this->db->select('vidiem_dealer_users.user_id, 
							vidiem_dealer_locations.location_name, 
							vidiem_dealer_locations.location_code, 
							vidiem_dealer_locations.email, 
							vidiem_dealer_locations.mobile_no,
							vidiem_dealers.id,vidiem_dealers.email as admin_email,
							vidiem_dealers.display_name,vidiem_dealers.dealer_erp_code,
							vidiem_dealers.vidiem_erp_code,
							')->join('vidiem_dealer_locations', 'vidiem_dealer_locations.id = vidiem_dealer_users.location_id')
							->join('vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_locations.dealer_id')
							->where('vidiem_dealer_users.id', $user_id)
							->get('vidiem_dealer_users');

		if( $details->num_rows() > 0 ) {
			return $details->row_array();
		} else {
			return null;
		}
	}

	public function getARDLocationInfo($user_id)
	{
		$details = $this->db->select('vidiem_dealer_users.user_id, 
							vidiem_dealer_locations.location_name, 
							vidiem_dealer_locations.location_code, 
							vidiem_dealer_locations.email, 
							vidiem_dealer_locations.mobile_no,
							vidiem_dealers.id,vidiem_dealers.email as admin_email,
							vidiem_dealers.display_name,vidiem_dealers.dealer_erp_code,
							vidiem_dealers.vidiem_erp_code,
							vidiem_dealers.address,
							vidiem_dealers.gstin_no
							')->join('vidiem_dealer_locations', 'vidiem_dealer_locations.id = vidiem_dealer_users.location_id')
							->join('vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_locations.dealer_id')
							->where('vidiem_dealer_users.id', $user_id)
							->get('vidiem_dealer_users');

		if( $details->num_rows() > 0 ) {
			return $details->row_array();
		} else {
			return null;
		}
	}
	
    public function getARDInfo($user_id)
	{
		$details = $this->db->select('vidiem_dealer_users.user_id, 
							vidiem_dealers.id,vidiem_dealers.email as admin_email,
							vidiem_dealers.display_name,vidiem_dealers.dealer_erp_code,
							vidiem_dealers.vidiem_erp_code,
							vidiem_dealers.address,
							vidiem_dealers.gstin_no,
							vidiem_dealers.ard_cin,
							vidiem_dealers.ard_pan
							')->join('vidiem_dealer_locations', 'vidiem_dealer_locations.id = vidiem_dealer_users.location_id')
							->join('vidiem_dealers', 'vidiem_dealers.id = vidiem_dealer_locations.dealer_id')
							->where('vidiem_dealer_users.id', $user_id)
							->get('vidiem_dealer_users');

		if( $details->num_rows() > 0 ) {
			return $details->row_array();
		} else {
			return null;
		}
	}


	public function getARDCommissionDetails($commission_id)
	{
		$details = $this->db->select('*')
							->where('id', $commission_id)
							->get('ard_sub_dealer_order_details');

		if( $details->num_rows() > 0 ) {
			return $details->row_array();
		} else {
			return null;
		}
	}

public function AmountInWords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "and " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}
	
	public function send_office_mail($to_email, $msg, $subject, $from_email, $attchment = null)
	{

		$this->load->library('email');
		
		$tmp['smtp_host'] = "smtp.office365.com";
		$tmp['smtp_port'] = "587";
		$tmp['smtp_user'] = "orders@vidiem.in"; 
		$tmp['smtp_pass'] = "Fus32406";
		$tmp['charset'] = "utf-8";
		$tmp['mailtype'] = "html";
		
		// $this->load->library('email',$tmp);
		$this->email->initialize($tmp);
		$this->email->set_newline("\r\n");  
		$this->email->from('orders@vidiem.in', 'Orders Vidiem');

		$this->email->to($to_email);
		$this->email->bcc('erp@mayaappliances.com');
		$this->email->subject($subject);
		$this->email->message($msg);
		if (!empty($attchment)) {
			$this->email->attach($attchment, "attachment", 'invoice.pdf', 'application/pdf', TRUE);
		}
		$result 			= $this->email->send();

		// if ($this->email->send()) {
		// 	echo 'Your email was sent, thanks chamil.';
		// } else {
		// 	show_error($this->email->print_debugger());
		// }
		$this->email->clear();
		return $result;
	}
	
		public function send_office_mail_dealer($to_email,$cc_mail, $msg, $subject, $from_email, $attchment = null, $attchment2 = null)
	{
         $admin_to_mail_list='john@pixel-studios.com,prodmgsrk@mayaappliances.com,palani.j@mayaappliances.com,venkatesan@mayaappliances.com,em@mayaappliances.com,syed.m@mayaappliances.com,balakrishnan.s@mayaappliances.com,thulasiraman.s@mayaappliances.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,qasrk@mayaappliances.com,anandan.c@mayaappliances.com,murugan.k@mayaappliances.com,satheyaraaj.t@mayaappliances.com';
		$this->load->library('email');
		
		$tmp['smtp_host'] = "smtp.office365.com";
		$tmp['smtp_port'] = "587";
		$tmp['smtp_user'] = "orders@vidiem.in"; 
		$tmp['smtp_pass'] = "Fus32406";
		$tmp['charset'] = "utf-8";
		$tmp['mailtype'] = "html";
		
		// $this->load->library('email',$tmp);
		$this->email->initialize($tmp);
		$this->email->set_newline("\r\n");  
		$this->email->from('orders@vidiem.in', 'Orders Vidiem');

		$this->email->to($to_email);
		$this->email->cc($cc_mail);
		$this->email->bcc('erp@mayaappliances.com'.','.$admin_to_mail_list);
		$this->email->subject($subject);
		$this->email->message($msg);
		if (!empty($attchment)) {
			$this->email->attach($attchment, "attachment", 'invoice.pdf', 'application/pdf', TRUE);
		}
			if (!empty($attchment2)) {
			$this->email->attach($attchment2);
		}
	
		$result 			= $this->email->send();

		// if ($this->email->send()) {
		// 	echo 'Your email was sent, thanks chamil.';
		// } else {
		// 	show_error($this->email->print_debugger());
		// }
		$this->email->clear();
		return $result;
	}
	
		public function send_office_dealer_ard($to_email,$cc_mail, $msg, $subject, $from_email, $attchment = null, $attchment2 = null)
	{
         $admin_to_mail_list='john@pixel-studios.com,prodmgsrk@mayaappliances.com,palani.j@mayaappliances.com,venkatesan@mayaappliances.com,em@mayaappliances.com,syed.m@mayaappliances.com,balakrishnan.s@mayaappliances.com,thulasiraman.s@mayaappliances.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,qasrk@mayaappliances.com,anandan.c@mayaappliances.com,murugan.k@mayaappliances.com,satheyaraaj.t@mayaappliances.com';
		$admin_to_mail_list='';
		$this->load->library('email');
		
		$tmp['smtp_host'] = "smtp.office365.com";
		$tmp['smtp_port'] = "587";
		$tmp['smtp_user'] = "orders@vidiem.in"; 
		$tmp['smtp_pass'] = "Fus32406";
		$tmp['charset'] = "utf-8";
		$tmp['mailtype'] = "html";
		
		// $this->load->library('email',$tmp);
		$this->email->initialize($tmp);
		$this->email->set_newline("\r\n");  
		$this->email->from('orders@vidiem.in', 'Orders Vidiem');

		$this->email->to($to_email);
		$this->email->cc($cc_mail);
		$this->email->bcc('erp@mayaappliances.com'.','.$admin_to_mail_list);
		$this->email->subject($subject);
		$this->email->message($msg);
		if (!empty($attchment)) {
			$this->email->attach($attchment, "attachment", 'invoice_service_bill_ard.pdf', 'application/pdf', TRUE);
		}
			if (!empty($attchment2)) {
			$this->email->attach($attchment2);
		}
	
		$result 			= $this->email->send();

		// if ($this->email->send()) {
		// 	echo 'Your email was sent, thanks chamil.';
		// } else {
		// 	show_error($this->email->print_debugger());
		// }
	    $this->email->clear(TRUE);
		return $result;
	}
	
		public function send_office_ard_to_apl($to_email,$cc_mail, $msg, $subject, $from_email, $attchment = null, $attchment2 = null)
	{
         $admin_to_mail_list='john@pixel-studios.com,prodmgsrk@mayaappliances.com,palani.j@mayaappliances.com,venkatesan@mayaappliances.com,em@mayaappliances.com,syed.m@mayaappliances.com,balakrishnan.s@mayaappliances.com,thulasiraman.s@mayaappliances.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,qasrk@mayaappliances.com,anandan.c@mayaappliances.com,murugan.k@mayaappliances.com,satheyaraaj.t@mayaappliances.com';
		$admin_to_mail_list='';
		$this->load->library('email');
		
		$tmp['smtp_host'] = "smtp.office365.com";
		$tmp['smtp_port'] = "587";
		$tmp['smtp_user'] = "orders@vidiem.in"; 
		$tmp['smtp_pass'] = "Fus32406";
		$tmp['charset'] = "utf-8";
		$tmp['mailtype'] = "html";
		
		// $this->load->library('email',$tmp);
		$this->email->initialize($tmp);
		$this->email->set_newline("\r\n");  
		$this->email->from('orders@vidiem.in', 'Orders Vidiem');

		$this->email->to($to_email);
		$this->email->cc($cc_mail);
		$this->email->bcc('erp@mayaappliances.com'.','.$admin_to_mail_list);
		$this->email->subject($subject);
		$this->email->message($msg);
		if (!empty($attchment)) {
			$this->email->attach($attchment, "attachment", 'invoice_service_bill_mal.pdf', 'application/pdf', TRUE);
		}
			if (!empty($attchment2)) {
			$this->email->attach($attchment2);
		}
	
		$result 			= $this->email->send();

		// if ($this->email->send()) {
		// 	echo 'Your email was sent, thanks chamil.';
		// } else {
		// 	show_error($this->email->print_debugger());
		// }
	$this->email->clear(TRUE);
		return $result;
	}

	public function ARD_Service_charge()
	{
		$details = $this->db->select('vidiem_dealers.dealer_erp_code,	
							vidiem_dealers.vidiem_erp_code, 
							vidiem_ard_service_charge.id,vidiem_ard_service_charge.ard_dealer_id,
							vidiem_ard_service_charge.ard_service_charge,vidiem_ard_service_charge.sub_dealer_service_charge
							')->join('vidiem_ard_service_charge', 'vidiem_dealers.id = vidiem_ard_service_charge.ard_dealer_id')
							->where('vidiem_dealers.dealer_type', 'ard')
							->get('vidiem_dealers');

		if( $details->num_rows() > 0 ) {
			return $details->result_array();
		} else {
			return null;
		}
	}
	
	



}