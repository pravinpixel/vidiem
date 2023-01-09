<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(__DIR__.'/razorpay-php/Razorpay.php');
use \Razorpay\Api\Api;
class Razorpay{
	
	private $keyId;                
	private $keySecret;       
	private $api;       
    
    public function __construct() {	 
	
		$this->ci = &get_instance();
		$configs = $this->ci->config;
	
		$this->keyId=$configs->config['keyid'];                
		$this->keySecret=$configs->config['keysecret']; 
		 $this->api = new Api($this->keyId, $this->keySecret);
		//error_reporting(E_ALL ^ E_DEPRECATED);
    }
	
	public function CreateOrder($orderData)
	{
		 
		$razorpayOrder = $this->api->order->create($orderData);
		return $razorpayOrder;		
	}
	
	public function FetchOrder($orderid)
	{
		 
		$razorpayOrder = $this->api->order->fetch($orderid);
		return $razorpayOrder;
		
	}
	
	public function verifyPaymentSignature($attributes)
	{
		 
		$signature = $this->api->utility->verifyPaymentSignature($attributes);
		return $signature;
		
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