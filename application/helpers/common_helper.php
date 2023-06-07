<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('SMS'))
{
    function SMS($mobile,$msg,$tempid=false){
            $apikey = "A695c2a00fff3a78ef70843f97b2bfa61"; 
            $senderid="VIDIEM"; 
            $templateid=$tempid;
            $mobile  =  $mobile; 
            $message = strip_tags($msg);
            $message = urlencode($message);
            $type   =  "txt";
             $url="https://api-alerts.kaleyra.com/v4/?api_key=".$apikey."&method=sms&message=".$message."&to=".$mobile."&sender=".$senderid;
            //echo "<pre>";print_r($url);exit;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);  
            curl_close($ch);  
        return true; 
    }
}
if ( ! function_exists('edit_unique')) {
    function edit_unique($value, $params) 
    { 
		 
        $CI =& get_instance(); 
        list($table, $column, $master_column, $id) = explode('.', $params);
        $column_rep = str_replace('_',' ',$column);
        $CI->load->database();
        $CI->db->from($table);
        $CI->db->where([$column => $value]);
        if($master_column != 'null') {
            $master_value = $CI->input->post($master_column);
            $CI->db->where([$master_column => $master_value]);
        }
        $CI->db->where('id!=', $id);
        $result = $CI->db->get()->result_array();
        if(!empty($result)) {
            $CI->form_validation->set_message('edit_unique', "The {$column_rep} field must contain a unique value.");
            return false;
        }
        return true;
    }

}

if ( ! function_exists('edit_unique_customize')) {
    function edit_unique_customize($value, $params) 
    { 
		
        $CI =& get_instance(); 
        list($table, $column, $master_column,$edit_column, $id) = explode('.', $params);
        $column_rep = str_replace('_',' ',$column);
        $CI->load->database();
        $CI->db->from($table);
        $CI->db->where([$column => $value]);
        if($master_column != 'null') {
            $master_value = $CI->input->post($master_column);
            $CI->db->where([$master_column => $master_value]);
        }
        $CI->db->where($edit_column.'!=', $id);
		$CI->db->where(' isactive!=', '2');
		
        $result = $CI->db->get()->result_array();
		//echo $CI->db->last_query(); die();
        if(!empty($result)) {
            $CI->form_validation->set_message('edit_unique_customize', "The {$column_rep} field must contain a unique value.");
            return false;
        }
        return true;
    }

}



if ( ! function_exists('edit_unique_customize_request')) {
    function edit_unique_customize_request($value, $params) 
    { 
	//print_r($GLOBALS['combinebase_ind']);
	if(isset($GLOBALS['combinebase_ind'])){
	$j=$GLOBALS['combinebase_ind'];
	}
	else{
		$j=$GLOBALS['combinebase_ind']=0;
	}
	$GLOBALS['combinebase_ind']+=1;


	
	//echo "ggg"; 
	//	print_r($params);
		//die();
        $CI =& get_instance(); 
        list($table, $column, $master_column,$edit_column, $id) = explode('.', $params);
        $column_rep = str_replace('_',' ',$master_column);
		
	
        $CI->load->database();
		  if($master_column != 'null') {
            $master_value = $CI->input->post($master_column);
			
			//	print_r($master_value);
	//	print_r($master_column);
		
		//for($j=0;$j< count($master_value);$j++) {
        $CI->db->from($table);
        $CI->db->where([$column => $id]);
        if($master_column != 'null') {
          //  $master_value = $CI->input->post($master_column);
			
			
			
            $CI->db->where([$master_column => $master_value[$j]]);
        }
		
	 if($CI->input->post($edit_column)[$j]!= 'null' && $CI->input->post($edit_column)[$j]!= '') { 	
        $CI->db->where($edit_column.'!=', $CI->input->post($edit_column)[$j]);
	 }
		$CI->db->where(' isactive!=', '2');
		
        $result = $CI->db->get()->result_array();
		//print_r($result); 
		//echo $CI->db->last_query(); 
		//die();
        if(!empty($result)) {
            $CI->form_validation->set_message_index('edit_unique_customize_request', "The {$column_rep} field must contain a unique value.",$j);
            return false;
        }
		//}
        return true;
	  
	 }
    }

}



if ( ! function_exists('validate_purchasedate')) {
	
	function validate_purchasedate($value)
	{
        $CI =& get_instance(); 
		$date_to = strtotime(date('Y-m-d'));
		$date_from =  strtotime($value);
		if($date_from <= $date_to ) {
		  return true;
		}
		$CI->form_validation->set_message('validate_purchasedate', "The purchase date less than or equal to current date.");
        return false;
	}
}


if ( ! function_exists('hasPermission')) {
	function hasPermission($column)
	{
        try{
            $CI =& get_instance();
            $user_id = $CI->session->userdata('user_id');
            $CI->db->select('*');
            $CI->db->where('id', $user_id);
            $user = $CI->db->get('vidiem_users')->row();
            if(!empty($user)) {
                if( $user->role == 1) {
                    return true;
                }
                $CI->db->select($column);
                $CI->db->where('role_id',  $user->role);
                $permission = $CI->db->get('vidiem_permissions')->row();
                if($permission->{$column} == 1) {
                    return true;
                }
                return false;
            }
            return false;
        } catch (Exception $ex) {
            return false;
        }
       
	}
}

if ( ! function_exists('generateDealerOrderId')) {
	function generateDealerOrderId()
	{
        $CI =& get_instance(); 
        $dealer_session         = $CI->session->userdata('dealer_session');
        $orderRange             = '00001';
        
        
        if( isset( $dealer_session ) && !empty( $dealer_session ) ) {

            $erp_no             = $dealer_session['dealer']['dealer_erp_code'];
            $data               = $CI->db->select('vidiem_customorder.order_no')
                                        ->where('dealer_id is NOT NULL', NULL, FALSE)
                                        ->where('order_no is NOT NULL', NULL, FALSE)
                                        ->order_by('id', 'desc')
                                        // ->group_by('order_no')
                                        ->get('vidiem_customorder')->row();
            if( isset( $data ) && !empty( $data ) ) {
                $old_no         = $data->order_no;
                $old_numbers    = explode('-', $old_no);
                $old_no         = end($old_numbers);
                
                //0001 + 1 = 2
                $old_no         = $old_no + 1;
        
                if( ( 4 - strlen($old_no) ) > 0 ){
                    $new_no = '';
                    for ($i=0; $i < (4 - strlen($old_no) ); $i++) { 
                        $new_no .= '0';
                    }
                    $ord = $new_no.$old_no;
                    
                    $order_no = $erp_no.'-'.$ord;
                }

            } else {
                $order_no       = $erp_no.'-'.$orderRange;
            }   

        }
        return $order_no;
	}
}

if ( ! function_exists('ss')) {
	function ss( $data = null)
	{
        echo '<pre>';
        print_r( $data );
        die;

	}
}

if ( ! function_exists('show')) {
	function show( $data )
	{
        echo '<pre>';
        print_r( $data );

	}
}