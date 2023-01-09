<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Payumoney{
	
	private $MERCHANT_KEY;                
	private $SALT;       
	private $PAYU_BASE_URL;       
    
    public function __construct() {
		$this->MERCHANT_KEY='MAGn4X';                
		$this->SALT='BFcRcZHJ';       
		
		//$this->MERCHANT_KEY='gtKFFx';                
		//$this->SALT='eCwWELxi';  
		 $this->PAYU_BASE_URL='https://secure.payu.in';  
		 //$this->PAYU_BASE_URL='https://test.payu.in/_payment';  
		error_reporting(E_ALL ^ E_DEPRECATED);
    }

	public function paymentGeneration($payData){
		$hash = '';
		// Hash Sequence
		$payData['key']=$this->MERCHANT_KEY;
		$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

		$hashVarsSeq = explode('|', $hashSequence);
		$hash_string = '';	
		foreach($hashVarsSeq as $hash_var) {
		$hash_string .= isset($payData[$hash_var]) ? $payData[$hash_var] : '';
		$hash_string .= '|';
		}

		$hash_string .= $this->SALT;
		$data['MERCHANT_KEY']=$this->MERCHANT_KEY;
		$data['hash'] = strtolower(hash('sha512', $hash_string));
		$data['action'] = $this->PAYU_BASE_URL . '/_payment';
		return $data;
	} 
}
?>