<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    function __construct() {
		
        parent::__construct();
		
		
        $this->load->library('dbvars',NULL,'Info');
         $this->load->library('pagination');
         $this->load->library('cart');
        // $this->load->library('Mcapi');
         $this->load->library('google');
         $this->load->library('facebook');
        $this->load->library(array('payumoney'));
		$this->load->library(array('razorpay'));
        $this->load->model('HomeModel');
        $this->session->keep_flashdata('title');
        $this->session->keep_flashdata('msg');
        $this->session->keep_flashdata('type');
		
		
		
		
    }
    
    public function index() {
      //  if($_SERVER['REQUEST_SCHEME']=='http'){ redirect();}
	    $this->session->unset_userdata('previous_url');
		
        $data['menu_id']=1;
        $data['feature_category']=$this->FunctionModel->Select_Fields('id,slug,name,image','vidiem_category',array('parent_id'=>0,'status'=>1,'featured'=>1,'slug !=' => "commercial" ),'order_no','ASC');
		
		
		$data['homepage_video']=$this->FunctionModel->Select_Fields('id,name,video_url,title,urllink,description,image','vidiem_video_videos',array('parent_id'=>10,'status'=>1),'order_no','ASC');
		$data['homepage_bestoffer']=$this->FunctionModel->Select_Fields('id,name,slug,image','vidiem_offers',array('type'=>1,'status'=>1));
        $data['new_launches']=$this->FunctionModel->Select_Fields('slug,name,image','vidiem_products',array('status'=>1,'new_launches'=>1),'id','DESC',6,0);
        $data['testimonial']=$this->FunctionModel->Select('vidiem_testimonial',array('status'=>1),'order_no','ASC');
        $data['banner']=$this->FunctionModel->Select('vidiem_banner',array('status'=>1),'order_no','ASC');
		$data['blockmng']=$this->FunctionModel->Select_Row('vidiem_block',array('status'=>1,'slug'=>'home-rd-product'));
		$data['newlaunch']=$this->FunctionModel->Select_Row('vidiem_block',array('status'=>1,'slug'=>'new-launch'));
		$data['knowyourvidiem']=$this->FunctionModel->Select_Row('vidiem_block',array('status'=>1,'slug'=>'know-your-vidiem'));
		$data['bestoffer']=$this->FunctionModel->Select_Row('vidiem_block',array('status'=>1,'slug'=>'best-offer'));
		$data['customersfavourites']=$this->FunctionModel->Select_Row('vidiem_block',array('status'=>1,'slug'=>'customers-favourites'));
		$data['customersfeedback']=$this->FunctionModel->Select_Row('vidiem_block',array('status'=>1,'slug'=>'customers-feedback'));
        $data['recipe_home']=$this->FunctionModel->Select('vidiem_recipe',array('status'=>1),'id','DESC',6,0);
        $data['homeseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Home'));
		$data['homefindvidiem']=$this->FunctionModel->Select_Row('vidiem_block',array('status'=>1,'slug'=>'home-page-find-vidiem'));
		$data['homespecialoffer']=$this->FunctionModel->Select_Row('vidiem_block',array('status'=>1,'slug'=>'home-page-special-offer'));
		$data['homeoursupport']=$this->FunctionModel->Select_Row('vidiem_block',array('status'=>1,'slug'=>'home-page-our-support'));	
		//print_r($data); die();
        $this->load->view('home',@$data);
		
		
    }

    public function product($slug=NULL){
        $data['menu_id']=3;
        if(empty($slug)){redirect();}
        $data['productseo']=$this->FunctionModel->Select('vidiem_products',array('slug'=>$slug));
        $product_id=$this->FunctionModel->Select_Field('id','vidiem_products',array('slug'=>$slug));
        if(empty($product_id)){redirect();}
        $data['product']=$this->ProjectModel->ProductInfo($product_id);
        $data['cat_slug']=$this->FunctionModel->Select('vidiem_category',array('id'=>$data['product']['cat_id']));
		$data['subcat_slug']=$this->FunctionModel->Select('vidiem_category',array('id'=>$data['product']['sub_cat_id']));
        $data['rel_products']=$this->ProjectModel->Related_Products($product_id);
        $data['keynotes']=$this->FunctionModel->Select('vidiem_product_keynotes',array('parent_id'=>$product_id),'order_no','ASC');
        $data['keyfeautre']=$this->FunctionModel->Select('vidiem_product_key_feautures',array('parent_id'=>$product_id,'status'=>1),'order_no','ASC');
		
	  	 $query=$this->db->query("SELECT 'image'as type,id,name,image as url,classname as classname, '' as backimage,order_no FROM vidiem_product_images where status=1 and parent_id='".$data['product']['id']."'   UNION SELECT 'video' as type,id,name,video_url as url,'' as classname, image as backimage,order_no FROM vidiem_product_video where status=1 and parent_id='".$data['product']['id']."' order by order_no asc ");
		 $data['product_img']=$query->result_array();
		 
	
		 
		//print_r( $data['product_img']); die();		
	
        //$data['product_img']=$this->FunctionModel->Select_Fields('id,name,image,classname','vidiem_product_images',array('status'=>1,'parent_id'=>$data['product']['id']),'order_no','ASC');
		
		//$data['product_video']=$this->FunctionModel->Select_Fields('id,name,video_url,image','vidiem_product_video',array('status'=>1,'parent_id'=>$data['product']['id']),'order_no','ASC');
		
		  $this->db->select('f.id,f.name,pf.value,pf.id as pf_id,p.name as pro_name,p.image as pro_image,p.modal_no as pro_modal_no,p.outofstock,p.id as pro_id');
          $this->db->join('vidiem_product_features pf','f.id=pf.feature_id AND pf.product_id='.$data['product']['id'].'','left');
          $this->db->join('vidiem_products p','p.id=pf.product_id','left');
          $query=$this->db->get_where('vidiem_features f',array('parent_id'=>$data['product']['cat_id']));
		
          $data['product_feature']=$query->result_array();
		  
	
		
		$data['product_about_detail']=$this->FunctionModel->Select_Fields('id,parent_id,name,productkeyfeature,position,imageposition,image,content,order_no ','vidiem_product_key_feautures',array('status'=>1,'productkeyfeature'=>1,'parent_id'=>$data['product']['id']),'order_no','ASC');
		
		$data['product_product_detail']=$this->FunctionModel->Select_Fields('id,parent_id,name,productkeyfeature,position,imageposition,image,content,order_no ','vidiem_product_key_feautures',array('status'=>1,'productkeyfeature'=>2,'parent_id'=>$data['product']['id']),'order_no','ASC');
		
		
        $this->load->view('product-details',@$data);
    }

    public function category($slug=NULL){
		//print_r($_REQUEST); exit;
        $data['menu_id']=3;
        if(empty($slug)){redirect();}
        $data['categoryseo']=$this->FunctionModel->Select('vidiem_category',array('slug'=>$slug));
        $cat_id=$this->FunctionModel->Select_Field('id','vidiem_category',array('slug'=>$slug));
        if(empty($cat_id)){redirect();}
        $data['cat_id']=$cat_id;
        $data['cat']=$this->FunctionModel->Select_Row('vidiem_category',array('id'=>$cat_id));
        $data['filter_sub_cat']=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('parent_id'=>$cat_id,'status'=>1),'order_no','ASC');
        $data['sub_cat']=$this->FunctionModel->Select_Fields('id,name,image,slug','vidiem_category',array('parent_id'=>$cat_id,'status'=>1),'order_no','ASC');
		if($_REQUEST['subcatid']!=''){
			$data['subcatid']=$_REQUEST['subcatid'];
			//$data['product_list']=$this->FunctionModel->Select_Fields('id,slug,name,image,price,old_price,outofstock,list_description','vidiem_products',array('sub_cat_id'=>$_REQUEST['subcatid'],'status'=>1),'price','desc');
			$this->db->select('p.id,p.slug,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description');
          $this->db->join('vidiem_category c','c.id=p.sub_cat_id and c.status=1 AND c.id='.$sub_cat_id.'','inner');
          $this->db->order_by("c.order_no", "asc");
		  $this->db->order_by("p.price", "desc");
		  //$this->db->limit(10,0);
          $query=$this->db->get_where('vidiem_products p',array('p.sub_cat_id'=>$data['subcatid'],'p.status'=>1)); 
		  $data['product_list']=$query->result_array();
			
		}else{
			//$data['product_list']=$this->FunctionModel->Select_Fields('id,slug,name,image,price,old_price,outofstock,list_description','vidiem_products',array('cat_id'=>$cat_id,'status'=>1),'order_no','ASC');
		$this->db->select('p.id,p.slug,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description');
          $this->db->join('vidiem_category c','c.id=p.sub_cat_id and c.status=1 AND c.parent_id='.$cat_id.'','inner');
          $this->db->order_by("c.order_no", "asc");
		  $this->db->order_by("p.price", "desc");
		  //$this->db->limit(10,0);
          $query=$this->db->get_where('vidiem_products p',array('p.cat_id'=>$cat_id,'p.status'=>1)); 
		  $data['product_list']=$query->result_array();
		 // echo $this->db->last_query();
		  //echo "jjj"; die();
		
		}
		
		$data['otherproduct_list']=$this->FunctionModel->Select_Fields('id,productlink,name,image,content','vidiem_otherproduct',array('status'=>1),'order_no','ASC');
        $has_child=$this->FunctionModel->Row_Count('vidiem_category',array('parent_id'=>$cat_id,'status'=>1));
        $data['has_child']=($has_child!=0?1:0);
        $data['cat_slug']=$slug;
        $data['filters']=$this->FunctionModel->Select_Fields('id,filter_id','vidiem_category_filters',array('parent_id'=>$cat_id));
        $data['category_img']=$this->FunctionModel->Select_Fields('id,name,image,banner_url','vidiem_category_images',array('status'=>1,'parent_id'=>$data['cat']['id']),'order_no','ASC');

        $this->load->view('product-listing',@$data);
    }

    public function event($id=NULL){
        $data['menu_id']=0;
         $cat_id=$this->FunctionModel->Select_Field('id','vidiem_event',array('id'=>$id));
         //echo $cat_id;exit;
        if(empty($cat_id)){redirect();}
        $data['cat_id']=$cat_id;
        $data['cat']=$this->FunctionModel->Select_Row('vidiem_event',array('id'=>$cat_id));
        $data['sub_cat']=$this->FunctionModel->Select_Fields('id,title,link,content','vidiem_event_category',array('parent_id'=>$cat_id,'status'=>1),'order_no','ASC');
        $data['event_image']=$this->FunctionModel->Select_Fields('id,image','vidiem_event_category_images',array('status'=>1,'parent_id'=>$data['cat']['id']),'order_no','ASC');
        $img_id=$this->FunctionModel->Select_Field('id','vidiem_event_category',array('parent_id'=>$id));
        $data['img_id']=$img_id;
        $data['img']=$this->FunctionModel->Select_Row('vidiem_event_category',array('id'=>$img_id));
        $data['event_img']=$this->FunctionModel->Select_Fields('id,image','vidiem_event_images',array('status'=>1,'parent_id'=>$data['img']['id']),'order_no','ASC');
        $this->load->view('event-innerpage',$data);
    }

     public function cart(){
        $data['menu_id']=0;
		$client_id=$this->session->userdata('client_id');
		$data['client_id'] = $client_id;
		$this->session->set_userdata('previous_url', 'cart');
        $this->session->unset_userdata('coupon');
        $this->load->view('cart',@$data);
     }

     public function buy_now($product_id=NULL){
        if(empty($product_id)){redirect('cart');}
        $pro=$this->ProjectModel->ProductInfoForCart($product_id);
       if(!empty($pro)){
            $data = array(
                'id'       => $pro['id'],
                'qty'      => 1,
                'price'    => $pro['price'],
                'name'     => $pro['name'],
                'slug'     => $pro['slug'],
                'image'    => $pro['image'],
                'modal_no' => $pro['modal_no']
            );
            $this->cart->insert($data);
        }    
        redirect('cart');
     }

     public function checkout(){
        $contents=$this->cart->contents();
		$this->session->set_userdata('previous_url', 'checkout');
        if(empty($contents)){
            $this->session->set_flashdata('title', "Error..");  
            $this->session->set_flashdata('msg', "Cart Empty");  
            $this->session->set_flashdata('type', "warning");
            redirect('','refresh');
        }
        $client_id=$this->session->userdata('client_id');
		
		$data['client_id']=$client_id;
        if(empty($this->input->post('from_cart'))){
            $coupon=$this->session->userdata('coupon');
        }else{
            $coupon=$this->input->post('coupon');
        }
        if(!empty($coupon) && !empty($client_id)){
            $data['discount']=$this->ProjectModel->coupon_discount($coupon);
            $data['discount']['code']=$coupon;
        }
        $data['menu_id']=0;
        if(!empty($client_id)){
            $data['shipping_address']=$this->FunctionModel->Select_Fields('id,type,title,name,address,city,zip_code,state,country,mobile_no','vidiem_clients_address',array('client_id'=>$client_id,'type'=>1)); 
            $data['billing_address']=$this->FunctionModel->Select_Fields('id,type,title,name,address,city,zip_code,state,country,mobile_no','vidiem_clients_address',array('client_id'=>$client_id,'type'=>2)); 
        }
        $data['ship_id']=$this->input->get('shipping_id');
        $data['bill_id']=$this->input->get('billing_id');
        $data['same']=$this->input->get('same');
        if(!empty($data['same'])){$data['same']=0;}
         $data['loginURL'] = $this->google->loginURL();
        $data['FbloginUrl'] = $this->facebook->loginUrl();
        $this->load->view('account-shipping',@$data);
     }

     public function payment(){
		 extract($_REQUEST);
		
         $client_id=$this->session->userdata('client_id');
         $contents=$this->cart->contents();
        if(empty($contents)){
            $this->session->set_flashdata('title', "Error..");  
            $this->session->set_flashdata('msg', "Cart Empty");  
            $this->session->set_flashdata('type', "warning");
            redirect('','refresh');
        }
        /*if(empty($client_id)){
            $this->session->set_flashdata('title', "Error..");  
            $this->session->set_flashdata('msg', "User Need to Login to Process");  
            $this->session->set_flashdata('type', "warning");
            redirect('','refresh');
        }*/
        
        if(($shippingaddressid!='' && $shippingmethodid!='' && $confirmcart!='') || $client_id==''){
			
            $code=$this->ProjectModel->OrderCode();
			
			
			if($client_id!=''){ //Login User
				$delivery_address=$shippingaddressid;
				
				if($billingaddressid==''){
					$billing_address=$delivery_address;
				}else{
					$billing_address=$billingaddressid;
				}
				$devliver_info=$this->FunctionModel->Select_Row('vidiem_clients_address',array('id'=>$delivery_address));
				$billing_info=$this->FunctionModel->Select_Row('vidiem_clients_address',array('id'=>$billing_address));
				$clientid = $client_id;
				
			}else{ //Guest User
				
				$sessionid = $this->session->session_id;
				$devliver_info=$this->FunctionModel->Select_Row('vidiem_clients_address',array('client_id'=>$sessionid,'type'=>1),'id','desc');
				
					if(empty($devliver_info)){
						$this->session->set_flashdata('title', "Error..");  
						$this->session->set_flashdata('msg', "Please add your shipping address");  
						$this->session->set_flashdata('type', "warning");
						redirect('checkout','refresh');
					}
				
				if($same_billing=='1'){
					$billing_info = $devliver_info;
				}else{
					$billing_info=$this->FunctionModel->Select_Row('vidiem_clients_address',array('client_id'=>$sessionid,'type'=>2),'id','desc');
					
					if(empty($billing_info)){
						$this->session->set_flashdata('title', "Error..");  
						$this->session->set_flashdata('msg', "Please add your billing address");  
						$this->session->set_flashdata('type', "warning");
						redirect('checkout','refresh');
					}
				}
				$clientid = 0;
				
			}
			
			
                $total=$this->cart->total();
                $coupon=$couponcode;
                $discount=$this->ProjectModel->coupon_discount($coupon);
                $amount=$total-$discount['amount'];
            $InsertData=array(
                'code'                  => $code,
                'client_id'             => $clientid,
                'delivery_name'         => $devliver_info['name'],
                'delivery_company_name' => $devliver_info['company_name'],
                'delivery_address'      => $devliver_info['address'],
                'delivery_address2'     => $devliver_info['address2'],
                'delivery_city'         => $devliver_info['city'],
                'delivery_zip'          => $devliver_info['zip_code'],
                'delivery_state'        => $devliver_info['state'],
                'delivery_country'      => $devliver_info['country'], 
                'delivery_mobile_no'    => $devliver_info['mobile_no'],
				'delivery_emailid'    => $devliver_info['emailid'],
                'delivery_add_info'     => $devliver_info['add_information'],
                'billing_name'          => $billing_info['name'],
                'billing_company_name'  => $billing_info['company_name'],
                'billing_address'       => $billing_info['address'],
                'billing_address2'      => $billing_info['address2'],
                'billing_city'          => $billing_info['city'],
                'billing_zip'           => $billing_info['zip_code'],
                'billing_state'         => $billing_info['state'],
                'billing_country'       => $billing_info['country'],
                'billing_mobile_no'     => $billing_info['mobile_no'],
				'billing_emailid'     => $billing_info['emailid'],
                'billing_add_info'      => $billing_info['add_information'],
                'coupon'                => $coupon,
                'coupon_id'             => $discount['id'],
                'coupon_type'           => $discount['type'],
                'coupon_value'          => $discount['value'],
                'sub_total'             => $total,
                'tax'                   => $total-($total/TAX), // TAX variable define from confiq
                'discount'              => $discount['amount'],
                'amount'                => round($amount),
                'status'                => 1,
                'created'               => date('Y-m-d H:i:s')
            );
            $order_id=$this->FunctionModel->Insert($InsertData,'vidiem_order');
            if($order_id!=''){
            $content=$this->cart->contents();
            foreach ($content as $info) {
                $total=$info['price'];
                $InsertData=array(
                    'order_id'  => $order_id,
                    'product_id'=> $info['id'],
                    'name'      => $info['name'],
                    'slug'      => $info['slug'],
                    'image'     => $info['image'],
                    'price'     => $info['price'],
                    'qty'       => $info['qty'],
                    'amount'    => $info['subtotal']
                );
                $this->FunctionModel->Insert($InsertData,'vidiem_order_products');
            }
            $client_id=$this->session->userdata('client_id');
				
			if($client_id!='' && isset($client_id)){ //Login User
				$clt=$this->FunctionModel->Select_Fields_Row('email,mobile_no','vidiem_clients',array('id'=>$client_id));
				$firstname = $this->session->userdata('client_name');
				$email = $clt['email'];
				$mobile = $clt['mobile_no'];
			}else{ //Guest User
				
				$firstname = $billing_info['name'];
				$email = $billing_info['emailid'];
				$mobile = $billing_info['mobile_no'];
				
			}
			
            
            $PaymentData=array(
                'txnid'      => time().rand(1000,9999),
                'amount'     => round($amount),
                'productinfo'=> 'Product Name',
                'firstname'  => $firstname,
                'email'      => $email,
                'surl'       => base_url('home/payumoney_success'),
                'furl'       => base_url('home/payumoney_failure'),
                'curl'       => base_url(''),
                'phone'      => $mobile,
                'udf1'       => $order_id
            );
            $data['PaymentData']=$PaymentData;
            $data['pay']=$this->payumoney->paymentGeneration($PaymentData);
            $this->load->view('payment-payumoney',@$data);
        }
        else{
            redirect('checkout');
        }
        
        }
        else{
            redirect('checkout');
        }
     }

     public function payumoney_success(){
        $status = $this->input->post('status');
      if (empty($status)) {
            redirect('');
        }
        $firstname = $this->input->post('firstname');
        $amount = $this->input->post('amount');
        $txnid = $this->input->post('txnid');
        $posted_hash = $this->input->post('hash');
        $key = $this->input->post('key');
        $productinfo = $this->input->post('productinfo');
        $email = $this->input->post('email');
        $udf1 = $this->input->post('udf1');
        $salt = "BFcRcZHJ"; //  Your salt
        $add = $this->input->post('additionalCharges');
        If (isset($add)) {
            $additionalCharges = $this->input->post('additionalCharges');
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '||||||||||' . $udf1 . '|' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {

            $retHashSeq = $salt . '|' . $status . '||||||||||' . $udf1 . '|' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
         $hash = hash("sha512", $retHashSeq);

          if ($hash != $posted_hash) {
             redirect('home/payumoney_failure','refresh');
           } 
          $data['amount'] = $amount;
          $data['txnid'] = $txnid;
          $data['posted_hash'] = $posted_hash;
          $data['status'] = $status;
          $order_id=$udf1;
          $pay_data=$_POST;
          if($status == 'success'){
         // Invoice Code Update
         
         $code=$this->FunctionModel->Select_Field('inv_code','vidiem_order',array('id'=>$order_id),'inv_code','DESC',1);
         
         if(empty($code)){
            $inv_code=$this->ProjectModel->InvoiceCode();
            $UpdateData=array(
                'inv_code'      => $inv_code,
                'mihpayid'      => $pay_data['mihpayid'],
                'payment_source'=> $pay_data['payment_source'],
                'pg_type'       => $pay_data['PG_TYPE'],
                'bank_ref_num'  => $pay_data['bank_ref_num'],
                'payment_status'=> 'success',
                'modified'      => date('Y-m-d H:i:s')
            );
            $this->FunctionModel->Update($UpdateData,'vidiem_order',array('id'=>$order_id));
         }    
            
            
            

            $this->ProjectModel->NewOrderNotification($order_id);
            $this->cart->destroy();
            $this->session->set_flashdata('title', "Thank You");     
            $this->session->set_flashdata('msg', "Payment is successful and You will receive email from our side further instrucions.");     
            $this->session->set_flashdata('type', "success");
            $this->ProjectModel->OrderInvoicing($order_id); 
             redirect('order-success/'.$order_id,'refresh');
        }
   }    

    public function payumoney_failure(){
        $this->session->set_flashdata('title', "Declined");  
        $this->session->set_flashdata('msg', "The transaction has been declined.");  
        $this->session->set_flashdata('type', "warning");
        redirect('','refresh');
    }
    
     public function offers($slug=NULL) {
        $data['menu_id']=12;
        $data['offersseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Offers'));
        if(empty($slug)){
            $count=$this->FunctionModel->Row_Count('vidiem_offers',array('status'=>1));
            if($count!=1){
                 $data['offers']=$this->FunctionModel->Select('vidiem_offers',array('status'=>1));
                 $this->load->view('offers',@$data);
            }else{
                $slug=$this->FunctionModel->Select_Field('slug','vidiem_offers',array('status'=>1));
                redirect('offers/'.$slug,'refresh');
            }
        $this->load->view('offers',@$data);
        }else{
            $id=$this->FunctionModel->Select_Field('id','vidiem_offers',array('slug'=>$slug,'status'=>1));
            $type=$this->FunctionModel->Select_Field('type','vidiem_offers',array('slug'=>$slug,'status'=>1));
             if($type == 1){
            if(empty($id)){
                redirect('offers','refresh');
            }
            $data['name']=$this->FunctionModel->Select_Field('name','vidiem_offers',array('id'=>$id));
            $data['products']=$this->ProjectModel->OfferProductFrontEnd($id);
            $this->load->view('offer-products',@$data);
            }
            if($type == 2){
            $this->form_validation->set_rules('name','Name','required');
            $this->form_validation->set_rules('city','City','required');
            $this->form_validation->set_rules('email','Email','required|valid_email');
            $this->form_validation->set_rules('mobile','Mobile No.','required|regex_match[/^[0-9]{10}$/]');
            if ($this->form_validation->run() == FALSE) {
                       $this->load->view('combo-offers',@$data); 
                 }
            else if (!$this->form_validation->run() == FALSE) {
                $InsertData=array(
                    'name'       => $this->input->post('name'),
                    'email'      => $this->input->post('email'),
                    'city'       => $this->input->post('city'),
                    'mobile'  => str_replace(' ','',$this->input->post('mobile')),
                    'status'     => 1,
                    'type'     => 2,
                    'created'    =>date('Y-m-d H:i:s')
                );
                    $result=$this->FunctionModel->Insert($InsertData,'vidiem_enquiry');
                    if($result){
                   $from_mail=$this->input->post('email');
                $subject='New Combo Offer In Website';
                $msg='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
                  <table>
                    <tr>
                        <td colspan="2" class="tc" style="text-align:center;"><u>New Combo Offer In Website</u></td></br>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td style="padding:10px 0;">'.$this->input->post('name').'</td>
                    </tr></br>
                        <tr>
                        <td>Location</td>
                        <td style="padding:10px 0;">'.$this->input->post('city').'</td>
                    </tr>
                        <tr>
                        <td>Phone Number</td>
                        <td style="padding:10px 0;">'.$this->input->post('mobile').'</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td style="padding:10px 0;">'.$this->input->post('email').'</td>
                    </tr>
                </table>';
               // echo $msg;exit;
            //  $this->FunctionModel->sendmail1('care@vidiem.in',$msg,$subject,$from_mail);
           //   $this->FunctionModel->sendmail1('online@mayaappliances.com',$msg,$subject,$from_mail);
           
            $this->FunctionModel->sendmail1('care@vidiem.in',$msg,$subject,'care@vidiem.in',$from_mail);
              $this->FunctionModel->sendmail1('online@mayaappliances.com',$msg,$subject,'care@vidiem.in',$from_mail);
         
                    $this->session->set_flashdata('title', "Success");   
                    $this->session->set_flashdata('msg', "Email Send Successfully.");     
                    $this->session->set_flashdata('type', "success");
                    redirect('offers', 'refresh');
          
                   }
                } }
        }
    }

     public function contact_us(){
        $data['menu_id']=6;
        $data['contactseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Contact'));
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('location','Location','required');
        $this->form_validation->set_rules('phone','Phone','required');
        $this->form_validation->set_rules('emailid','Email','required|valid_email');
        $this->form_validation->set_rules('enquire','enquire','required');
        $this->form_validation->set_rules('message','Message','required');
       // $this->form_validation->set_rules('captcha','Captcha','required');
       	$this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_google_validate_captcha');
        if ($this->form_validation->run() == FALSE) {
                 $this->load->view('contact-us',@$data);    
             }
        else if (!$this->form_validation->run() == FALSE) {
            $query = $this->db->query("Select CONCAT('W',DATE_FORMAT(NOW(),'%y%m'),LPAD(MAX(id)+1, 4, '0')) AS ref_no From vidiem_enquiry");

             foreach ($query->result_array() as $row)
          {
                
              $retval =  $row['ref_no'];
      
      
          } 
          // echo $retval;exit;
            $InsertData=array(
                    'ref_no'      =>  $retval,
                    'name'      =>  $this->input->post('name'),
                    'mobile' =>  $this->input->post('phone'),
                    'email' =>  $this->input->post('emailid'),
                    'city' =>  $this->input->post('location'),
                    'enquiry' =>  $this->input->post('enquire'),
                    'message' =>  $this->input->post('message'),
                    'type' =>  '1',
                    'status' =>  '1',
                    'created'         =>  date('Y-m-d H:i:s')
                );
                $result=$this->FunctionModel->Insert($InsertData,'vidiem_enquiry');
                if($result){
            
		$from_mail=$this->input->post('emailid');
        	$subject='New Enquiry In Website';
        	$msg='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
        	  <table>
        		<tr>
        			<td colspan="2" class="tc" style="text-align:center;"><u>New Enquiry In Website</u></td></br>
        		</tr>
        		<tr>
        			<td>Name</td>
        			<td style="padding:10px 0;">'.$this->input->post('name').'</td>
        		</tr></br>
        			<tr>
        			<td>Location</td>
        			<td style="padding:10px 0;">'.$this->input->post('location').'</td>
        		</tr>
        			<tr>
        			<td>Phone Number</td>
        			<td style="padding:10px 0;">'.$this->input->post('phone').'</td>
        		</tr>
        		<tr>
        			<td>Email</td>
        			<td style="padding:10px 0;">'.$this->input->post('emailid').'</td>
        		</tr>
        		<tr>
        			<td>Enquiry</td>
        			<td style="padding:10px 0;">'.$this->input->post('enquire').'</td>
        		</tr>
        		<tr>
        			<td>Message</td>
        			<td style="padding:10px 0;">'.$this->input->post('message').'</td>
        		</tr>
        	</table>';
        	$msg2='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
        	  <table>
        		<tr>
        			<td colspan="2" class="tc"><u>Hi,</u></td></br>
        		</tr>
        		<tr>
        			<td>Your Reference No.is :&nbsp;&nbsp;'.$retval. '</td>
        			
        		</tr></br></br>
        		<tr>
        			<td>Thanks for your request. Our executive will contact you asap. </td>
        		
        		</tr></br></br>
        		<tr>
        			<td>Warm Regards, </td>
        		
        		</tr>
        		<tr>
        			<td>Vidiem Customer Care</td>
        		
        		</tr>
        		<tr>
        			<td>care@vidiem.in</td>
        		
        		</tr>
        		<tr>
        			<td>044-6635 6635 / 77110 06635</td>
        		
        		</tr></br>
        			
        	</table>';
        $this->FunctionModel->sendmail1('care@vidiem.in',$msg,$subject,'care@vidiem.in',$from_mail);
      // $this->sendCovidMail('care@vidiem.in');
         $this->FunctionModel->sendmail1($from_mail, $msg2, 'Reference Number','care@vidiem.in');
        	    $this->session->set_flashdata('title', "Success");   
                $this->session->set_flashdata('msg', "Email Send Successfully.");     
                $this->session->set_flashdata('type', "success");
                redirect('contact-us', 'refresh');
      
        }
        }
     }
     public function google_validate_captcha() 
     {
			$google_captcha = $this->input->post('g-recaptcha-response');
			$google_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Letm3cUAAAAAM6uqYzzeHWdADiNGLaGztKkAJma&response=" . $google_captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
			if ($google_response . 'success' == false) {
				$this->form_validation->set_message('google_validate_captcha', 'Please check the the captcha form');
				return FALSE;
			} else {
				return TRUE;
			}
	
     }
           public function recipe($start=0){
        $data['menu_id']=9;
       $config['base_url'] = base_url('Recipesearch');
      $data['tmp_url']=$config['base_url'];
      $data['tmp_title']='All Recipe';
      $config['per_page'] = 25; 
      $search=$this->input->get('search'); 
      $data['search']=$search;
        if(!empty($search)){
        $data['scroll']=1;
    } 
      $config['total_rows'] = $this->ProjectModel->RecipeDataCount(array('status !='=>0),$search);
      $data['DataResult']=$this->ProjectModel->RecipeData(array('status'=>1),$config['per_page'],$start,$search);
      // $data['DataResult']=$this->ProjectModel->RecipeData(array('status !='=>0),$config['per_page'],$start,$search);
      $data['x']=$start;
        $data['DataResult']=$this->FunctionModel->Select('vidiem_recipe',array('status'=>1),'order_no','ASC');
        $this->FunctionModel->Select('vidiem_recipe',array('status'=>1),'id','DESC',3,0);
        $data['recipe_banner']=$this->FunctionModel->Select('vidiem_recipe_banner',array('status'=>1),'order_no','ASC');
        $data['recipeseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Recipe'));
        $this->load->view('recipe',@$data);     
}
public function recipe_search($start=0){
        $data['menu_id']=9; 
       $config['base_url'] = base_url('Recipesearch');
      $data['tmp_url']=$config['base_url'];
      $data['tmp_title']='All Recipe';
      $config['per_page'] = 25; 
      $search=$this->input->get('search'); 
      $data['search']=$search;
        if(!empty($search)){
        $data['scroll']=1;
    } 
      $config['total_rows'] = $this->ProjectModel->RecipeDataCount(array('status !='=>0),$search);
      $data['DataResult']=$this->ProjectModel->RecipeData(array('status'=>1),$config['per_page'],$start,$search);
      // $data['DataResult']=$this->ProjectModel->RecipeData(array('status !='=>0),$config['per_page'],$start,$search);
      $data['x']=$start;
        $data['recipe']=$this->FunctionModel->Select('vidiem_recipe',array('status'=>1),'order_no','ASC');
        $this->FunctionModel->Select('vidiem_recipe',array('status'=>1),'id','DESC',3,0);
        $data['recipe_banner']=$this->FunctionModel->Select('vidiem_recipe_banner',array('status'=>1),'order_no','ASC');
        $this->load->view('recipe',@$data);     
}


     public function about_us(){
        $data['menu_id']=2;
         $data['teammember']=$this->FunctionModel->Select('vidiem_team',array('status'=>1),'order_no','ASC');
        $data['eventss']=$this->FunctionModel->Select('vidiem_event',array('status'=>1,'category'=>1),'order_no','ASC');
        $data['aboutseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'About Us'));
        $this->load->view('about-us',@$data);
     }

    public function search(){
        $data['menu_id']=0;
        $term=$this->input->get('term');
        $data['search_term']=$term;
        $cat['cat_id']=0;
        if(!empty($term)){
            $cat=$this->ProjectModel->SearchCatFinder($term);
        }
        if($cat['cat_id']!=0){
            $data['cat']=$cat; 
            $data['filters']=$this->FunctionModel->Select_Fields('id,filter_id','vidiem_category_filters',array('parent_id'=>$cat['cat_id']));
            $data['products']=$this->ProjectModel->ProductSearch($term);
            $this->load->view('search',@$data);
        }else{
            $data['products']=$this->ProjectModel->ProductSearch($term);
             $this->load->view('search',@$data);
        }
     }

    public function compare(){
         $array=$this->session->userdata('c_products');
         $cat_id=$this->session->userdata('c_cat_id');
         $data['menu_id']=3;
        if(!empty($array[0])){
            $this->db->select('f.id,f.name,pf.value,pf.id as pf_id,p.name as pro_name,p.image as pro_image,p.modal_no as pro_modal_no,p.outofstock,p.id as pro_id');
            $this->db->join('vidiem_product_features pf','f.id=pf.feature_id AND pf.product_id='.$array[0].'','left');
            $this->db->join('vidiem_products p','p.id=pf.product_id','left');
            $query=$this->db->get_where('vidiem_features f',array('parent_id'=>$cat_id));
            $data['product'][0]=$query->result_array();
        }

        if(!empty($array[1])){
            $this->db->select('f.id,f.name,pf.value,pf.id as pf_id,p.name as pro_name,p.image as pro_image,p.modal_no as pro_modal_no,p.outofstock,p.id as pro_id');
            $this->db->join('vidiem_product_features pf','f.id=pf.feature_id AND pf.product_id='.$array[1].'','left');
            $this->db->join('vidiem_products p','p.id=pf.product_id','left');
            $query=$this->db->get_where('vidiem_features f',array('parent_id'=>$cat_id));
            $data['product'][1]=$query->result_array();
        }

        if(!empty($array[2])){
            $this->db->select('f.id,f.name,pf.value,pf.id as pf_id,p.name as pro_name,p.image as pro_image,p.modal_no as pro_modal_no,p.outofstock,p.id as pro_id');
            $this->db->join('vidiem_product_features pf','f.id=pf.feature_id AND pf.product_id='.$array[2].'','left');
            $this->db->join('vidiem_products p','p.id=pf.product_id','left');
            $query=$this->db->get_where('vidiem_features f',array('parent_id'=>$cat_id));
            $data['product'][2]=$query->result_array();
        }
        $this->load->view('compare',$data);
    }

    // User Login and Dashboard

    public function sign_in(){
   
		if(!empty($this->session->userdata('client_id'))){
			redirect('user/dashboard');
		}		
		
        $data['menu_id']=0;
        $this->form_validation->set_rules('user_name','Email.','required');
        $this->form_validation->set_rules('password','Password','required|callback_password_check');
         if($this->form_validation->run()==TRUE){
            $user_name=$this->input->post('user_name');
            $password=md5($this->input->post('password'));
            $status=$this->ProjectModel->ClientLogin($user_name,$password);
            if($status==1){
                $this->session->set_flashdata('title', "Success");   
                $this->session->set_flashdata('msg', "Login Successfully.");     
                $this->session->set_flashdata('type', "success");
				
				$previous_url = $this->session->userdata('previous_url');
				$this->session->unset_userdata("previous_url");
				if($previous_url=='checkout' || $previous_url=='cart'){
					redirect($previous_url, 'refresh');
				}else{
					redirect('user/dashboard', 'refresh');
				}
            }
            else if($status==2){
                $this->session->set_flashdata('title', "Info");  
                $this->session->set_flashdata('msg', "Account suspended. Contact our team"); 
                $this->session->set_flashdata('type', "warning");
                redirect('', 'refresh');
            }
            else if($status==3){
                $this->session->set_flashdata('title', "Info");  
                $this->session->set_flashdata('msg', "Please Verify your Mobile No.");   
                $this->session->set_flashdata('type', "warning");
                redirect('verify-otp', 'refresh');
            }
        }  
        $data['loginURL'] = $this->google->loginURL(); 
        $data['FbloginUrl'] = $this->facebook->loginUrl();
        $this->load->view('sign-in',@$data);
    }

    public function password_check(){
        $user_name=$this->input->post('user_name');
        $password=$this->input->post('password');
        if(empty($password)){
            $this->form_validation->set_message('password_check','Password field required');
            return false;
        }
        $count=$this->ProjectModel->ClientLoginCheck($user_name,$password);
        if($count==1){ return true;}
        else{ $this->form_validation->set_message('password_check','Invalid Email Id or Password'); 
            return false;
        }
    }
     public function guest_login(){
           $data=array();
           $data['menu_id']=0;
           $client_id=$this->session->userdata('client_id');
            if(!empty($client_id)){
                redirect();
            }
           $data['loginURL'] = $this->google->loginURL();
           $this->load->view('guest_login',@$data);
     }
     public function register(){
        $data['menu_id']=0;
        $client_id=$this->session->userdata('client_id');
        if(!empty($client_id)){
            redirect();
        }
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[vidiem_clients.email]');
        $this->form_validation->set_rules('mobile_no','Mobile No.','required|is_unique[vidiem_clients.mobile_no]|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('password','Password','required|min_length[6]');
        $this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[password]');
        $this->form_validation->set_message('is_unique','%s Already Exist');
        if($this->form_validation->run()==true){
            $otp_code=rand(100000,999999);
            $InsertData=array(
                'name'       => $this->input->post('name'),
                'email'      => $this->input->post('email'),
                'mobile_no'  => str_replace(' ','',$this->input->post('mobile_no')),
                'gender'        => $this->input->post('gender'),
                'dob'           => $this->input->post('dob'),
                'newsletter'    => $this->input->post('newsletter'),
                'special_offer' => $this->input->post('special_offer'),
                'sms_verified'   => 1,
                'sms_code'   => $otp_code,
                'password'   => md5($this->input->post('password')),
                'status'     => 1,
                'created'    =>date('Y-m-d H:i:s')
            );
            $client_id=$this->FunctionModel->Insert($InsertData,'vidiem_clients');
            // $sms_content="Your Otp is ".$otp_code.". Welcome to Vidiem Site.";
            // $this->ProjectModel->SMS($mobile_no,$sms_content);
            // Welcome Mail Start //
            $email=$this->input->post('email');
            $name=$this->input->post('name');
            $this->ProjectModel->WelcomeMail($email,$name);
            // Welcome Mail End //
            $this->session->set_flashdata('title', "Success");   
            $this->session->set_flashdata('msg', "Your account created Successfully.");    
            $this->session->set_flashdata('type', "success");
         
            $this->session->set_userdata('otp_client_id',$client_id);
            redirect('sign-in');
        }
        $data['loginURL'] = $this->google->loginURL();
        $data['FbloginUrl'] = $this->facebook->loginUrl();
        $this->load->view('register',@$data);
    }

    public function verify_otp(){
        $data['menu_id']=0;
        $this->form_validation->set_rules('sms_code','SMS Code','required|callback_otp_verify');
        if($this->form_validation->run()===true){
           $id=$this->session->userdata('otp_client_id');
           $UpdateData=array(
                'sms_verified'=>1,
                'modified'=>date('Y-m-d H:i:s')
           );
            $this->FunctionModel->Update($UpdateData,'vidiem_clients',array('id'=>$id));
            $this->ProjectModel->ClientIdLogin($id);
            $this->session->set_flashdata('title', "Success");   
            $this->session->set_flashdata('msg', "Mobile No Verified Successfully.");    
            $this->session->set_flashdata('type', "success");
            redirect('user/dashboard');
        }
        $this->load->view('verify-otp',@$data);
    }

    public function otp_verify(){
        $client_id=$this->session->userdata('otp_client_id');
        $sms_code=$this->input->post('sms_code');
        if(empty($sms_code)){
            $this->form_validation->set_message('otp_verify','SMS Code required');
            return false;
        }
        $count=$this->FunctionModel->Row_Count('vidiem_clients',array('id'=>$client_id,'sms_code'=>$sms_code));
        if($count==0){
            $this->form_validation->set_message('otp_verify','SMS Code Invalid');
            return false;
        }
        return true;
    }

    public function forgot_password(){
        $data['menu_id']=0;
        $client_id=$this->session->userdata('client_id');
        if(!empty($client_id)){redirect();}
        $this->form_validation->set_rules('email','Email','required|callback_forgot_email');
        if($this->form_validation->run()===TRUE){
            $email=$this->input->post('email');
            $id=$this->FunctionModel->Select_Field('id','vidiem_clients',array('email'=>$email));
            
            $this->ProjectModel->SentNewPassword($id);

            $this->session->set_flashdata('title', "Success");   
            $this->session->set_flashdata('msg', "New Password Sent to your Email.");
            $this->session->set_flashdata('type', "success");
            redirect('sign-in');
        }
        $this->load->view('forgot-password',@$data);
    }

    public function forgot_email(){
        $email=$this->input->post('email');
        if(empty($email)){
            $this->form_validation->set_message('forgot_email','Email Id Field required');
            return false;
        }
        $count=$this->FunctionModel->Row_Count('vidiem_clients',array('email'=>$email,'status'=>1));
        if($count==0){
             $this->form_validation->set_message('forgot_email','Invalid Email Id.');
             return false;
        }
        return true;
    }

    public function forgot_otp(){
        if(empty($this->session->userdata('forgot_client_id'))){
            redirect('sign-in');
        }
        $this->form_validation->set_rules('otp','OTP','required|callback_forgot_verify');
        $this->form_validation->set_rules('password','Password','required|min_length[6]|max_length[15]');
        $this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[password]');

        if (!$this->form_validation->run() == FALSE) {
            $tmp_id=$this->session->userdata('forgot_client_id');
            $UpdateData=array(
                'password' => md5($this->input->post('password')),
                'modified' => date('Y-m-d H:i:s')
            );
            $this->FunctionModel->Update($UpdateData,'vidiem_clients',array('id'=>$tmp_id));
            $this->ProjectModel->ClientIdLogin($tmp_id);
            $this->session->set_flashdata('title', "Success");   
        $this->session->set_flashdata('msg', "New Password Updated Successfully.");
        $this->session->set_flashdata('type', "success");
            redirect('user/dashboard');
        }
        $data['menu_id']=0;
        $this->load->view('forgot-password-otp',@$data);
    }

    public function forgot_verify(){
        $client_id=$this->session->userdata('forgot_client_id');
        $otp=$this->input->post('otp');
        if(empty($otp)){
            $this->form_validation->set_message('forgot_verify','OTP field required');
            return false;
        }
        $count=$this->FunctionModel->Row_Count('vidiem_clients',array('id'=>$client_id,'sms_code'=>$otp));
        if($count==0){
            $this->form_validation->set_message('forgot_verify','Invalid OTP');
            return false;
        }
        return true;
    }

    // Ajax Product Info

     public function AjaxProductInfo(){
            $id=$this->input->post('id');
            if(empty($id)){ redirect();}
            $product=$this->FunctionModel->Select_Row('vidiem_products',array('id'=>$id));
            echo '<li class="zoThepro">
          <img class="qvproimg" src="'.base_url('uploads/images/'.$product['image']).'">
        </li>
        <li class="qvCon">
          <div class="qvConful">
            <h3 class="qvProName">'.$product['name'].'</h3>
            '.$product['short_description'].'
            <p class="qvDepro"><span>Model: </span>'.$product['modal_no'].'</p>
            <!-- <p class="qvDepro"><span>Condition: </span>New</p>
            <p>30 Items</p>-->
          </div>
          <div class="offerdis">
           <h4 class="newpri"><i class="fa fa-inr"></i> '.number_format($product['price']).' /-</h4>';
         if(!empty($product['old_price'])){ 
            echo '<h5 class="oldpri"> <i class="fa fa-inr"></i> '.@number_format($product['old_price']).'/-</h5>';
         }
         echo '</div> ';
          if($product['status']==1){
            if($product['outofstock']==0){
              echo '<a href="javascript:void(0);" class="btn add_to_cart" data-id="'.@$product['id'].'">Add To Cart</a>';  
            }
            else{
              echo '<a href="'.base_url('contact-us').'" class="btn">Out of Stock</a>';
            }
           }

          echo '<a href="'.base_url('product/'.$product['slug']).'" class="btn moreDe">More Detail</a>
        </li>
        <i class="fa fa-close qvclose"></i>';
            exit;
    }


    // Product Compare
    public function Add_to_compare(){
        $product_id=$this->input->post('id');
        if(empty($product_id)){ redirect();}
        $cat_id=$this->session->userdata('c_cat_id');
        $array=$this->session->userdata('c_products');
        if(!empty($array)){
            if(in_array($product_id,$array)){
                echo '3--@--'; goto section;
            }
            if(count($array)==3){
                echo '2--@--'; goto section;
            }
        }
        if(empty($array)){
            $cat_id=$this->FunctionModel->Select_Field('cat_id','vidiem_products',array('id'=>$product_id));
            $this->session->set_userdata('c_cat_id',$cat_id);
            $array=array($product_id);
            $this->session->set_userdata('c_products',$array);
             echo '1--@--'; goto section;
        }
        else{
             $new_cat_id=$this->FunctionModel->Select_Field('cat_id','vidiem_products',array('id'=>$product_id));
             if($cat_id==$new_cat_id){
                $x=count($array);
                array_push($array, $product_id);
                $this->session->set_userdata('c_products',$array);
                echo '1--@--'; goto section;
             }
             else{
                echo '4--@--'; goto section;
             }
        }

        section:
          $array=$this->session->userdata('c_products');
          if(!empty($array)){
            foreach ($array as $info){
                $tmp=$this->FunctionModel->Select_Fields_Row('id,name,image,slug,price,old_price,outofstock','vidiem_products',array('id'=>$info));
               /*echo '<li class="clearfix">
                <div class="proImg prodimg">
                    <img src="'.base_url('uploads/images/'.$tmp['image']).'" alt="" />
                    <em class="prHov">
                        <a href="javascript:void(0);" class="QVpopup quick_view_trigger" data-id="'.$tmp['id'].'"><i class="fa fa-eye"></i>Quick View</a>
                        <a href="'.base_url('product/'.$tmp['slug']).'"><i class="fa fa-plus"></i>More</a>
                    </em>
                </div>
                <div class="mix_det clearfix">
                    <p>'.$tmp['name'].'</p>
                        <h4><i class="fa fa-inr"></i>'.number_format($tmp['price']).'/-</h4>
                    <div class="mix_det_rt clearfix">
                        <a class="mix_det_rt_add btn add_to_cart" href="javascript:void(0);" data-id="'.@$tmp['id'].'">Add to cart</a>
                        <a class="mix_det_rt_add comProRov btn remove_compare_products" href="javascript:void(0);" data-id="'.$tmp['id'].'">Remove</a>
                    </div>
                </div>
            </li>';*/
			echo'<div class="col-sm-12 col-md-4">
				<div class="model-border light-gray-bg">
					<h3><strong>Vidiem</strong>'.$tmp['name'].'</h3>
					<p class="model-price">₹ '.@number_format($tmp['price']).' '; 
					
					if(isset($tmp['old_price'])){  
					
						echo'<span class="strike">₹ '.@number_format($tmp['old_price']).'</span>';
					} 
					echo'</p>
					
					<img src="'.base_url('uploads/images/'.$tmp['image']).'" alt="" class="img-fluid" />
					<div class="row">
						<div class="col-sm-6 col-md-6">';
							if($tmp['outofstock']==0){
							echo'<a href="javascript:void(0);" class="model-add-to-cart add_to_cart" data-id="'.@$tmp['id'].'"><i class="lni lni-cart"></i> &nbsp; Add to Cart</a>';
							} else{ 
							echo'<a class="model-add-to-cart" href="'.base_url('contact-us').'"><i class="lni lni-cart"></i> &nbsp; Out of Stock</a>';
							} 
						echo'</div>
						<div class="col-sm-6 col-md-6">
							<a href="javascript:void(0);" class="model-remove remove_compare_products" data-id="'.$tmp['id'].'"><i class="lni lni-close"></i> &nbsp; Remove</a>
						</div>
					</div>
				</div>
			</div>';			
			
			
			
            }
          }
          exit;
    }

    public function Remove_From_compare(){
         $product_id=$this->input->post('id');
        $array=$this->session->userdata('c_products');
        $x=array_search($product_id,$array);
        unset($array[$x]); 
        if(!empty($array)){
            $array=array_values($array);
            $this->session->set_userdata('c_products',$array);
        }
        else{
            $this->session->unset_userdata('c_cat_id');
            $this->session->unset_userdata('c_products');
        }
        $array=$this->session->userdata('c_products');
          if(!empty($array)){
            foreach ($array as $info){
                $tmp=$this->FunctionModel->Select_Fields_Row('id,name,image,slug,price,old_price,outofstock','vidiem_products',array('id'=>$info));
			echo'<div class="col-sm-12 col-md-4">
				<div class="model-border light-gray-bg">
					<h3><strong>Vidiem</strong>'.$tmp['name'].'</h3>
					<p class="model-price">₹ '.@number_format($tmp['price']).' '; 
					
					if(isset($tmp['old_price'])){  
					
						echo'<span class="strike">₹ '.@number_format($tmp['old_price']).'</span>';
					} 
					echo'</p>
					
					<img src="'.base_url('uploads/images/'.$tmp['image']).'" alt="" class="img-fluid" />
					<div class="row">
						<div class="col-sm-6 col-md-6">';
							if($tmp['outofstock']==0){
							echo'<a href="javascript:void(0);" class="model-add-to-cart add_to_cart" data-id="'.@$tmp['id'].'"><i class="lni lni-cart"></i> &nbsp; Add to Cart</a>';
							} else{ 
							echo'<a class="model-add-to-cart" href="'.base_url('contact-us').'"><i class="lni lni-cart"></i> &nbsp; Out of Stock</a>';
							} 
						echo'</div>
						<div class="col-sm-6 col-md-6">
							<a href="javascript:void(0);" class="model-remove remove_compare_products" data-id="'.$tmp['id'].'"><i class="lni lni-close"></i> &nbsp; Remove</a>
						</div>
					</div>
				</div>
			</div>';	
            }
          }else{
                echo '<h5>Compare Product List Empty</h5>';
          }
        exit;

    }
    
     public function Remove_All_Compare(){
        $this->session->unset_userdata('c_products');
        $this->session->unset_userdata('c_cat_id');
        echo '<h5>Compare Product List Empty</h5>';
        exit;
    }

    // Cart Functionality

    public function add_to_cart(){
        $id=$this->input->post('id');
        // if(empty($id)){redirect();}
         $pro=$this->ProjectModel->ProductInfoForCart($id);
        if(!empty($pro)){
            $data = array(
                'id'    => $pro['id'],
                'qty'   => 1,
                'price' => $pro['price'],
				'old_price' => $pro['old_price'],
                'name'  => $pro['name'],
                'slug'  => $pro['slug'],
                'image'  => $pro['image'],
                'modal_no'  => $pro['modal_no']
            );
            $this->cart->insert($data);
      }
         $content=$this->cart->contents();
         echo count($content).'--@--';


		if(!empty($content)){
           
			echo '<a class="nav-link dropdown-toggle" href="#" id="menu-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="lni lni-cart"></i> <span class="count cart_total_product">'.count($content).'</span> </a>
			
			<div class="dropdown-menu header_cart_section" aria-labelledby="menu-4">
				<div class="cart-table">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Image</th>
								<th>Description</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>';
						 
						  foreach ($content as $key => $info) { 
							echo '<tr>
								<td>
									<img src="'.base_url('uploads/images/' . $info['image']).'" alt="" />
								</td>
								<td>
									<p><strong>Vidiem</strong>'.$info['name'].'</p>
									
									<p class="price">₹ '.number_format($info['price']).'';
									
									if($info['old_price']>0){  
									echo'<span class="strike">₹ '.number_format($info['old_price']).' </span>'; 
									} 
									echo'</p>
								</td>
								<td class="text-center">
									<button type="button" class="btn btn-xs btn-danger remove_from_cart" data-id="'.$key.'">
										<i class="lni lni-trash"></i>
									</button>
									
								</td>
							</tr>';
						   } 
						echo'</tbody>
					</table>
				</div>
				<div class="cart-buttons">
					<a href="'.base_url('cart').'" class="nav-buy-now"><i class="lni lni-cart"></i> View Cart</a>
					<a class="nav-add-to-cart" href="'.base_url('checkout').'"><i class="lni lni-cart"></i> Checkout</a>
				</div>
			 </div>';			
		 } else{
               echo '<a class="nav-link dropdown-toggle" href="#" id="menu-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="lni lni-cart"></i> <span class="count cart_total_product">'.count($content).'</span> </a>

			   <div class="dropdown-menu" aria-labelledby="menu-4">
									<div class="cart-table">
										<table class="table table-bordered">
											Cart Emptyss
										</table>
									</div>
								 </div>'; 
            }
			
            exit;
    }

    public function remove_from_cart(){
		
        $row_id=$this->input->post('id');
        if(empty($row_id)){redirect();}
        $this->cart->remove($row_id);
        $content=$this->cart->contents();
         echo count($content).'--@--';
		if(!empty($content)){
           
			echo '<a class="nav-link dropdown-toggle" href="#" id="menu-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="lni lni-cart"></i> <span class="count cart_total_product">'.count($content).'</span> </a>
			
			<div class="dropdown-menu header_cart_section" aria-labelledby="menu-4">
				<div class="cart-table">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Image</th>
								<th>Description</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>';
						 
						  foreach ($content as $key => $info) { 
							echo '<tr>
								<td>
									<img src="'.base_url('uploads/images/' . $info['image']).'" alt="" />
								</td>
								<td>
									<p><strong>Vidiem</strong>'.$info['name'].'</p>
									
									<p class="price">₹ '.number_format($info['price']).'';
									
									if($info['old_price']>0){  
									echo'<span class="strike">₹ '.number_format($info['old_price']).' </span>'; 
									} 
									echo'</p>
								</td>
								<td class="text-center">
									<button type="button" class="btn btn-xs btn-danger remove_from_cart" data-id="'.$key.'">
										<i class="lni lni-trash"></i>
									</button>
									
								</td>
							</tr>';
						   } 
						echo'</tbody>
					</table>
				</div>
				<div class="cart-buttons">
					<a href="'.base_url('cart').'" class="nav-buy-now"><i class="lni lni-cart"></i> View Cart</a>
					<a class="nav-add-to-cart" href="'.base_url('checkout').'"><i class="lni lni-cart"></i> Checkout</a>
				</div>
			 </div>';			
		 } else{
               echo '<a class="nav-link dropdown-toggle" href="#" id="menu-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="lni lni-cart"></i> <span class="count cart_total_product">'.count($content).'</span> </a>

			   <div class="dropdown-menu" aria-labelledby="menu-4">
									<div class="cart-table">
										<table class="table table-bordered">
											Cart Emptyss
										</table>
									</div>
								 </div>'; 
            }   
            exit;
    }

    public function remove_from_cart_page(){
        $row_id=$this->input->post('id');
        if(empty($row_id)){redirect();}
        $this->cart->remove($row_id);
        $content=$this->cart->contents();
        if(!empty($content)){
         echo '1--@--'; 
         foreach($content as $key=>$info){ ?>
			<li class="clearfix">
				<div class="ckproimgleft">
					<div class="ckfinimg">
						<img src="<?= base_url('uploads/images/'.$info['image']); ?>" alt="" class="img-fluid" />
					</div>	
					<div class="ckproimgright clearfix">
						<h4 class="ckproname"><?= $info['name']; ?></h4>
						<p>Model: <?= $info['modal_no']; ?></p>
						<p class="priceCartDe"><i class="fa fa-inr"></i> <?= number_format($info['price']*$info['qty']); ?>/-</p>
					</div>
					<div class="itemsbye clearfix">
						<div class="plus-minus">
							<div class="value-button decrease" value="Decrease Value">-</div>
								<input type="number" class="number product_count" id="number" value="<?= $info['qty']; ?>" min="1" max="10" data-id="<?= $key;?>">
							<div class="value-button increase" value="Increase Value">+</div>
						</div>
						<div class="ckclosebtn">
							<a href="javascript:void(0);" class="remove_from_cart_page"  data-id="<?= $key; ?>">Remove</a>
						</div>
                    </div>
				</div>
			</li>
        <?php }
        echo '--@--';
        echo '<li class="clearfix">
                        <p class="priceti">Price ('.number_format($this->cart->total_items()).' Item)</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()).'/-</p>
                    </li>
                    <li class="clearfix">
                        <p class="priceti">Delivery Charges</p>
                        <p class="priceAm gre">Free</p>
                    </li>
                    <li class="clearfix toamount">
                        <p class="priceti">AMOUNT PAYABLE</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()).'/-</p>
                    </li>';
         }else{
            echo '2--@--<h3>Cart Empty</h3>';
         }
		 

         exit;           
    }     

    public function cart_product_update(){
		//echo "dfhdgfu"; exit;
        $id=$this->input->post('id');
        if(empty($id)){redirect();}
        $count=$this->input->post('count');
        $type=$this->input->post('type');
        if($type=='increase'){
            $count+=1;
        }
        else{
            $count-=1;
        }
        $data = array(
            'rowid' => $id,
            'qty'   => $count
        );
		if($count>=1){
			$this->cart->update($data);
		}
        $content=$this->cart->contents();
        if(!empty($content)){
         echo '1--@--'; 
         foreach($content as $key=>$info){ ?>
			
			<li class="clearfix">
				<div class="ckproimgleft">
					<div class="ckfinimg">
					<a href="<?= base_url('product/'.$info['slug']); ?>" >
						<img src="<?= base_url('uploads/images/'.$info['image']); ?>" alt="" class="img-fluid" />
					</a>
					</div>	
					<div class="ckproimgright clearfix">
						<a href="<?= base_url('product/'.$info['slug']); ?>" >
						<h4 class="ckproname"><?= $info['name']; ?></h4>
						</a>
						<p>Model: <?= $info['modal_no']; ?></p>
						<p class="priceCartDe"><i class="fa fa-inr"></i> <?= number_format($info['price']*$info['qty']); ?>/-</p>
					</div>
					<div class="itemsbye clearfix">
						<div class="plus-minus">
							<div class="value-button decrease" value="Decrease Value">-</div>
								<input type="number" class="number product_count" id="number" readonly value="<?= $info['qty']; ?>" min="1" max="10" data-id="<?= $key;?>">
							<div class="value-button increase" value="Increase Value">+</div>
						</div>
						<div class="ckclosebtn">
							<a href="javascript:void(0);" class="remove_from_cart_page"  data-id="<?= $key; ?>">Remove</a>
						</div>
                    </div>
				</div>
			</li>			
			
        <?php }
        echo '--@--';
        echo '<li class="clearfix">
                        <p class="priceti">Price ('.number_format($this->cart->total_items()).' Item)</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()).'/-</p>
                    </li>
                    <li class="clearfix">
                        <p class="priceti">Delivery Charges</p>
                        <p class="priceAm gre">Free</p>
                    </li>
                    <li class="clearfix toamount">
                        <p class="priceti">AMOUNT PAYABLE</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()).'/-</p>
                    </li>';
         }else{
            echo '2--@--<h3>Cart Empty</h3>';
         }            
         exit;           
    }

    // Wordpress Blog and Events

    public function blog(){
        $data['menu_id']=7;
        $this->load->view('blog',@$data);
    }

    public function post(){
        $data['menu_id']=7;
        $this->load->view('post',@$data);
    }

    public function Events($id=NULL){
		
		$slug = $this->uri->segment(1);
		$data['slug'] = $slug;
        $data['menu_id']=5;
        $event_id=$this->FunctionModel->Select_Field('id','vidiem_event',array('id'=>$id));
          $data['event_home']=$this->FunctionModel->Select('vidiem_event',array('id'=>$event_id,'status'=>1),'order_no','ASC');
         $data['eventhome']=$this->FunctionModel->Select('vidiem_event_category',array('id'=>$event_id,'status'=>1),'order_no','ASC');
        $data['eventsss']=$this->FunctionModel->Select('vidiem_event',array('status'=>1,'category'=>2),'order_no','ASC');
        //$data['events_see']=$this->FunctionModel->Select('vidiem_event',array('status'=>1,'category'=>2),'order_no','ASC');
        $data['eventsseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Events'));
        $this->load->view('event',@$data);
    }
   

     public function Videos(){
		 
		$slug = $this->uri->segment(1);
		$data['slug'] = $slug;
        $data['menu_id']=5; 
        $data['video_cat']=$this->FunctionModel->Select('vidiem_mediavideo',array('status'=>1,'id !=' =>9),'order_no','ASC');
		$data['video_dealertestimonials']=$this->FunctionModel->Select_Row('vidiem_mediavideo',array('status'=>1,'id' =>9));
		$data['press']=$this->FunctionModel->Select('vidiem_press',array('status'=>1),'order_no','ASC');
        $data['eventsvideoseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Videos'));
        $this->load->view('video',@$data);
    }
    public function Recipe_Videos(){
        $data['menu_id']=42;
        $data['video_cat']=$this->FunctionModel->Select('vidiem_recipevideo',array('status'=>1));
        //$data['eventsvideoseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Videos'));
        $this->load->view('recipevideo',@$data);
    }

     public function press_release(){
		$slug = $this->uri->segment(1);
		$data['slug'] = $slug;
        $data['menu_id']=5;
        $data['press']=$this->FunctionModel->Select('vidiem_press',array('status'=>1),'order_no','ASC');
        $data['pressseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Press Release'));
        $this->load->view('press-releases',@$data);
    }

     /* public function product_registration(){
		 	
        $data['menu_id']=4;
               $data['category']=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('status'=>1,'parent_id'=>0));
	    $data['productregistrationseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Product Registration'));
	    $data['city']=$this->ProjectModel->getCities();
        $this->form_validation->set_rules('menucategory','Product','required');
        $this->form_validation->set_rules('serialnumer','Serial number','required');
        $this->form_validation->set_rules('jdate','Date of Purchase','required');
        $this->form_validation->set_rules('dealername','Dealer name','required');
        $this->form_validation->set_rules('gender','Gender','required');
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('age','Age','required|regex_match[/^[0-9]{2}$/]');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('mobile','Mobile number','required');
        $this->form_validation->set_rules('occupation','Occupation','required');
        $this->form_validation->set_rules('address','Address','required');
        $this->form_validation->set_rules('city','City','required');
        $this->form_validation->set_rules('state','State','required');
        $this->form_validation->set_rules('pincode','Pincode','required');
        //$this->form_validation->set_rules('captcha','Captcha','required');
        $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_google_validate_captcha');
        if ($this->form_validation->run() == FALSE) {
	
                  $this->load->view('product-registration',@$data);
             }
        else if (!$this->form_validation->run() == FALSE) 
        {
            echo "jjj"; die();
            
            $code=$this->ProjectModel->RegistrationCode();
             $InsertData=array(
                    'code'=>$code,
                    'Product'      =>  $this->input->post('menucategory'),
                    'serialnumer' =>  $this->input->post('serialnumer'),
                    'jdate' =>  $this->input->post('jdate'),
                    'dealername' =>  $this->input->post('dealername'),
                    'gender' =>  $this->input->post('gender'),
                    'name' =>  $this->input->post('name'),
                    'age' =>  $this->input->post('age'),
                    'email' =>  $this->input->post('email'),
                    'mobile' =>  $this->input->post('mobile'),
                    'occupation' =>  $this->input->post('occupation'),
                    'address' =>  $this->input->post('address'),
                    'city' =>  $this->input->post('city'),
                    'state' =>  $this->input->post('state'),
                    'pincode' =>  $this->input->post('pincode'),
                    //'captcha' =>  $this->input->post('captcha'),
                    'created'         =>  date('Y-m-d H:i:s')
                );
			
                $result=$this->FunctionModel->Insert($InsertData,'vidiem_product_registration');
                if($result){
                    $from_mail=$this->input->post('email');
        	$subject='Product Registration In Website';
        	$msg='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
        	  <table>
        		<tr>
        			<td colspan="2" class="tc" style="text-align:center;"><u>Product Registration In Website</u></td></br>
        		</tr>
        		 <tr><td>Registration Code</td>
                    <td style="padding:10px 0;">'.$code.'</td></tr></br>
        		<tr>
        			<td>Name</td>
        			<td style="padding:10px 0;">'.$this->input->post('name').'</td>
        		</tr></br>
        		<tr>
        			<td>Age</td>
        			<td style="padding:10px 0;">'.$this->input->post('age').'</td>
        		</tr></br>
        		<tr>
        			<td>Product</td>
        			<td style="padding:10px 0;">'. $this->input->post('menucategory').'</td>
        		</tr>
        			<tr>
        			<td>Phone Number</td>
        			<td style="padding:10px 0;">'.$this->input->post('mobile').'</td>
        		</tr>
        		<tr>
        			<td>Email</td>
        			<td style="padding:10px 0;">'.$this->input->post('email').'</td>
        		</tr>
        		<tr>
        			<td>Dealer</td>
        			<td style="padding:10px 0;">'. $this->input->post('dealername').'</td>
        		</tr>
        		<tr>
        			<td>Serial Number</td>
        			<td style="padding:10px 0;">'. $this->input->post('serialnumer').'</td>
        		</tr>
        		<tr>
        			<td>Address</td>
        			<td style="padding:10px 0;">'.$this->input->post('address').'</td>
        		</tr>
        		<tr>
        			<td>City</td>
        			<td style="padding:10px 0;">'.$this->input->post('city').'</td>
        		</tr>
        		<tr>
        			<td>State</td>
        			<td style="padding:10px 0;">'.$this->input->post('stateee').'</td>
        		</tr>
        		<tr>
        			<td>Pincode</td>
        			<td style="padding:10px 0;">'.$this->input->post('pincode').'</td>
        		</tr>
        	</table>';
           $this->FunctionModel->sendmail1('care@vidiem.in,online@mayaappliances.com,care@mayaappliances.com',$msg,$subject,$from_mail);
        	    $this->session->set_flashdata('title', "Success");   
                $this->session->set_flashdata('msg', "Email Send Successfully.");     
                $this->session->set_flashdata('type', "success");
                
                // Client Mail
                $msg2='<style>
        div.mail > p{
            margin:0px 0px 1em;padding:0px;color:rgb(51,51,51);font-family:q_serif,Georgia,Times,&quot;Times New Roman&quot;,&quot;Hiragino Kaku Gothic Pro&quot;,Meiryo,serif;font-size:16px
        } 
        table{background-color:#e6e6e6;margin:0 auto;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}
        </style>
        <div class="mail"><p>Dear '.$this->input->post('name').'</p>
        <p>Thanks for registering the product with us.</p>
        <p>Registered Reference Number : <b>'.$code.'</b>. Date : <b>'.date('d-m-Y').'</b></p>
        	  <table>
        		<tr>
        			<td colspan="2" class="tc" style="text-align:center;"><u>Registration Details</u></td></br>
        		</tr>
        		 <tr><td>Registration Code</td>
                    <td style="padding:10px 0;">'.$code.'</td></tr></br>
        		<tr>
        			<td>Name</td>
        			<td style="padding:10px 0;">'.$this->input->post('name').'</td>
        		</tr></br>
        		<tr>
        			<td>Age</td>
        			<td style="padding:10px 0;">'.$this->input->post('age').'</td>
        		</tr></br>
        		<tr>
        			<td>Product</td>
        			<td style="padding:10px 0;">'. $this->input->post('menucategory').'</td>
        		</tr>
        			<tr>
        			<td>Phone Number</td>
        			<td style="padding:10px 0;">'.$this->input->post('mobile').'</td>
        		</tr>
        		<tr>
        			<td>Email</td>
        			<td style="padding:10px 0;">'.$this->input->post('email').'</td>
        		</tr>
        		<tr>
        			<td>Dealer</td>
        			<td style="padding:10px 0;">'. $this->input->post('dealername').'</td>
        		</tr>
        		<tr>
        			<td>Serial Number</td>
        			<td style="padding:10px 0;">'. $this->input->post('serialnumer').'</td>
        		</tr>
        		<tr>
        			<td>Address</td>
        			<td style="padding:10px 0;">'.$this->input->post('address').'</td>
        		</tr>
        		<tr>
        			<td>City</td>
        			<td style="padding:10px 0;">'.$this->input->post('city').'</td>
        		</tr>
        		<tr>
        			<td>State</td>
        			<td style="padding:10px 0;">'.$this->input->post('stateee').'</td>
        		</tr>
        		<tr>
        			<td>Pincode</td>
        			<td style="padding:10px 0;">'.$this->input->post('pincode').'</td>
        		</tr>
        	</table>
       <p>Regards,</p><p>Vidiem Team.</p></div>';
        $this->FunctionModel->sendmail($from_mail, $msg2, 'Vidiem Product Registration','care@vidiem.in');
                redirect('product-registration', 'refresh');
                }
        }
     //   $this->load->view('product-registration',@$data);
    } */
    
    /*    public function product_registration(){
          // print_r( $this->form_validation->run()); die();
        
        $data['menu_id']=4;
        $data['category']=$this->FunctionModel->Select('vidiem_category',array('status'=>1,'parent_id'=>0));
        $data['productregistrationseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Product Registration'));
        $data['city']=$this->ProjectModel->getCities();
        $this->form_validation->set_rules('product','Product','required');
        $this->form_validation->set_rules('serialnumer','Serialnumer','required');
        $this->form_validation->set_rules('jdate','Jdate','required');
        $this->form_validation->set_rules('dealername','Dealername','required');
        $this->form_validation->set_rules('gender','Gender','required');
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('age','Age','required|regex_match[/^[0-9]{2}$/]');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('mobile','MobileNumer','required');
        $this->form_validation->set_rules('occupation','Occupation','required');
        $this->form_validation->set_rules('address','Address','required');
        $this->form_validation->set_rules('city','City','required');
        $this->form_validation->set_rules('stateee','State','required');
        $this->form_validation->set_rules('pincode','Pincode','required');
        //$this->form_validation->set_rules('captcha','Captcha','required');
      //  $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_google_validate_captcha');
        if ($this->form_validation->run() == FALSE) {
            print_r( $this->form_validation->run());
            echo "jjj123";
           // print_r($this->input->post); die();
                  $this->load->view('product-registration',@$data);
             }
        else if (!$this->form_validation->run() == FALSE) 
        {
            echo "fff"; die();
            $code=$this->ProjectModel->RegistrationCode();
            $cat_id=$this->input->post('category');
            $pro_id=$this->input->post('product');
            $cat_name=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$cat_id));
            $pro_name=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$pro_id));
             $InsertData=array(
                    'code'=>$code,
                    'category'          =>  $cat_name,
                    'Product'      =>  $pro_name,
                    'serialnumer' =>  $this->input->post('serialnumer'),
                    'jdate' =>  $this->input->post('jdate'),
                    'dealername' =>  $this->input->post('dealername'),
                    'gender' =>  $this->input->post('gender'),
                    'name' =>  $this->input->post('name'),
                    'age' =>  $this->input->post('age'),
                    'email' =>  $this->input->post('email'),
                    'mobile' =>  $this->input->post('mobile'),
                    'occupation' =>  $this->input->post('occupation'),
                    'address' =>  $this->input->post('address'),
                    'city' =>  $this->input->post('city'),
                    'state' =>  $this->input->post('stateee'),
                    'pincode' =>  $this->input->post('pincode'),
                    //'captcha' =>  $this->input->post('captcha'),
                    'created'         =>  date('Y-m-d H:i:s')
                );
                $result=$this->FunctionModel->Insert($InsertData,'vidiem_product_registration');
                if($result){
                    $from_mail=$this->input->post('email');
            $subject='Product Registration In Website';
            $msg='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
              <table>
                <tr>
                    <td colspan="2" class="tc" style="text-align:center;"><u>Product Registration In Website</u></td></br>
                </tr>
                 <tr><td>Registration Code</td>
                    <td style="padding:10px 0;">'.$code.'</td></tr></br>
                <tr>
                    <td>Name</td>
                    <td style="padding:10px 0;">'.$this->input->post('name').'</td>
                </tr></br>
                <tr>
                    <td>Age</td>
                    <td style="padding:10px 0;">'.$this->input->post('age').'</td>
                </tr></br>
                 <tr>
                    <td>Category</td>
                    <td style="padding:10px 0;">'.$cat_name.'</td>
                </tr></br>
                <tr>
                    <td>Product</td>
                    <td style="padding:10px 0;">'.$pro_name.'</td>
                </tr>
                    <tr>
                    <td>Phone Number</td>
                    <td style="padding:10px 0;">'.$this->input->post('mobile').'</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td style="padding:10px 0;">'.$this->input->post('email').'</td>
                </tr>
                <tr>
                    <td>Dealer</td>
                    <td style="padding:10px 0;">'. $this->input->post('dealername').'</td>
                </tr>
                <tr>
                    <td>Serial Number</td>
                    <td style="padding:10px 0;">'. $this->input->post('serialnumer').'</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td style="padding:10px 0;">'.$this->input->post('address').'</td>
                </tr>
                <tr>
                    <td>City</td>
                    <td style="padding:10px 0;">'.$this->input->post('city').'</td>
                </tr>
                <tr>
                    <td>State</td>
                    <td style="padding:10px 0;">'.$this->input->post('stateee').'</td>
                </tr>
                <tr>
                    <td>Pincode</td>
                    <td style="padding:10px 0;">'.$this->input->post('pincode').'</td>
                </tr>
            </table>';
           $this->FunctionModel->sendmail1('care@vidiem.in,online@mayaappliances.com,care@mayaappliances.com',$msg,$subject,'care@vidiem.in',$from_mail);
                $this->session->set_flashdata('title', "Success");   
                $this->session->set_flashdata('msg', "Email Send Successfully.");     
                $this->session->set_flashdata('type', "success");
                
                // Client Mail
                $msg2='<style>
        div.mail > p{
            margin:0px 0px 1em;padding:0px;color:rgb(51,51,51);font-family:q_serif,Georgia,Times,&quot;Times New Roman&quot;,&quot;Hiragino Kaku Gothic Pro&quot;,Meiryo,serif;font-size:16px
        } 
        table{background-color:#e6e6e6;margin:0 auto;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}
        </style>
        <div class="mail"><p>Dear '.$this->input->post('name').'</p>
        <p>Thanks for registering the product with us.</p>
        <p>Registered Reference Number : <b>'.$code.'</b>. Date : <b>'.date('d-m-Y').'</b></p>
              <table>
                <tr>
                    <td colspan="2" class="tc" style="text-align:center;"><u>Registration Details</u></td></br>
                </tr>
                 <tr><td>Registration Code</td>
                    <td style="padding:10px 0;">'.$code.'</td></tr></br>
                <tr>
                    <td>Name</td>
                    <td style="padding:10px 0;">'.$this->input->post('name').'</td>
                </tr></br>
                <tr>
                    <td>Age</td>
                    <td style="padding:10px 0;">'.$this->input->post('age').'</td>
                </tr></br>
                 <tr>
                    <td>Category</td>
                    <td style="padding:10px 0;">'.$cat_name.'</td>
                </tr></br>
                <tr>
                    <td>Product</td>
                    <td style="padding:10px 0;">'.$pro_name.'</td>
                </tr>
                    <tr>
                    <td>Phone Number</td>
                    <td style="padding:10px 0;">'.$this->input->post('mobile').'</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td style="padding:10px 0;">'.$this->input->post('email').'</td>
                </tr>
                <tr>
                    <td>Dealer</td>
                    <td style="padding:10px 0;">'. $this->input->post('dealername').'</td>
                </tr>
                <tr>
                    <td>Serial Number</td>
                    <td style="padding:10px 0;">'. $this->input->post('serialnumer').'</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td style="padding:10px 0;">'.$this->input->post('address').'</td>
                </tr>
                <tr>
                    <td>City</td>
                    <td style="padding:10px 0;">'.$this->input->post('city').'</td>
                </tr>
                <tr>
                    <td>State</td>
                    <td style="padding:10px 0;">'.$this->input->post('stateee').'</td>
                </tr>
                <tr>
                    <td>Pincode</td>
                    <td style="padding:10px 0;">'.$this->input->post('pincode').'</td>
                </tr>
            </table>
       <p>Regards,</p><p>Vidiem Team.</p></div>';
        $this->FunctionModel->sendmail1($from_mail, $msg2, 'Vidiem Product Registration','care@vidiem.in');
                redirect('product-registration', 'refresh');
                }
        }
     //   $this->load->view('product-registration',@$data);
    } */
    
     public function product_registration(){
        $data['menu_id']=4;
        $data['category']=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('status'=>1,'parent_id'=>0));
        $data['productregistrationseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Product Registration'));
        
        $this->form_validation->set_rules('category','Category','required');
        $this->form_validation->set_rules('product','Product','required');
        $this->form_validation->set_rules('serialnumer','Serial number','required|regex_match[/^[Cc][Hh][A-Za-z0-9]{13}$/]');
        $this->form_validation->set_rules('jdate','Date of purchase','required');
		$this->form_validation->set_rules('dealername','Dealer name','required|regex_match[/^[A-Za-z &]*$/]');
        $this->form_validation->set_rules('purchasefrom','Purchase Form','required');
        $this->form_validation->set_rules('gender','Gender','required');
        $this->form_validation->set_rules('name','Name','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('mobile','Mobile number','required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('age','Age','required|regex_match[/^[0-9]{2}$/]');
        $this->form_validation->set_rules('address','Address','required|regex_match[/^[A-Za-z0-9 &,:#]*$/]');
        $this->form_validation->set_rules('city','City','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('state','State','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('pincode','Pincode','required|regex_match[/^[0-9]{6}$/]');
        //$this->form_validation->set_rules('captcha','Captcha','required');
       // $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_google_validate_captcha');
        if ($this->form_validation->run() === TRUE) {
                $email=$this->input->post('email');
                $this->db->like('year(created)',date('Y'));
               
           $code=$this->ProjectModel->RegistrationCode();
            $cat_id=$this->input->post('category');
            $pro_id=$this->input->post('product');
            $cat_name=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$cat_id));
            $pro_name=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$pro_id));
             $InsertData=array(
                    'code'=>$code,
                    'category'          =>  $cat_name,
                    'Product'      =>  $pro_name,
                    'serialnumer' =>  $this->input->post('serialnumer'),
                    'jdate' =>  $this->input->post('jdate'),
                    'dealername' =>  $this->input->post('dealername'),
					'purchasefrom' =>  $this->input->post('purchasefrom'),
                    'gender' =>  $this->input->post('gender'),
                    'name' =>  $this->input->post('name'),
                    'age' =>  $this->input->post('age'),
                    'email' =>  $this->input->post('email'),
                    'mobile' =>  $this->input->post('mobile'),
                    'occupation' =>  $this->input->post('occupation'),
                    'address' =>  $this->input->post('address'),
                    'city' =>  $this->input->post('city'),
                    'state' =>  $this->input->post('state'),
                    'pincode' =>  $this->input->post('pincode'),
                    //'captcha' =>  $this->input->post('captcha'),
                    'created'         =>  date('Y-m-d H:i:s')
                );
                $result=$this->FunctionModel->Insert($InsertData,'vidiem_product_registration');
                if($result){
                    $from_mail=$this->input->post('email');
            $subject='Product Registration In Website';
            $msg='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
              <table>
                <tr>
                    <td colspan="2" class="tc" style="text-align:center;"><u>Product Registration In Website</u></td></br>
                </tr>
                 <tr><td>Registration Code</td>
                    <td style="padding:10px 0;">'.$code.'</td></tr></br>
                <tr>
                    <td>Name</td>
                    <td style="padding:10px 0;">'.$this->input->post('name').'</td>
                </tr></br>
                <tr>
                    <td>Age</td>
                    <td style="padding:10px 0;">'.$this->input->post('age').'</td>
                </tr></br>
                 <tr>
                    <td>Category</td>
                    <td style="padding:10px 0;">'.$cat_name.'</td>
                </tr></br>
                <tr>
                    <td>Purchase Date</td>
                    <td style="padding:10px 0;">'.$this->input->post('jdate').'</td>
                </tr>
                 <tr>
                    <td>Phone Number</td>
                    <td style="padding:10px 0;">'.$this->input->post('mobile').'</td>
                </tr>
                    <tr>
                    <td>Phone Number</td>
                    <td style="padding:10px 0;">'.$this->input->post('mobile').'</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td style="padding:10px 0;">'.$this->input->post('email').'</td>
                </tr>
                <tr>
                    <td>Purchase From</td>
                    <td style="padding:10px 0;">'. $this->input->post('purchasefrom').'</td>
                </tr>
				 <tr>
                    <td>Dealer</td>
                    <td style="padding:10px 0;">'. $this->input->post('dealername').'</td>
                </tr>
                <tr>
                    <td>Serial Number</td>
                    <td style="padding:10px 0;">'. $this->input->post('serialnumer').'</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td style="padding:10px 0;">'.$this->input->post('address').'</td>
                </tr>
                <tr>
                    <td>City</td>
                    <td style="padding:10px 0;">'.$this->input->post('city').'</td>
                </tr>
                <tr>
                    <td>State</td>
                    <td style="padding:10px 0;">'.$this->input->post('state').'</td>
                </tr>
                <tr>
                    <td>Pincode</td>
                    <td style="padding:10px 0;">'.$this->input->post('pincode').'</td>
                </tr>
            </table>';
          // $this->FunctionModel->sendmail1('care@vidiem.in,online@mayaappliances.com,care@mayaappliances.com',$msg,$subject,'care@vidiem.in',$from_mail);
              $this->FunctionModel->sendmail1('online@mayaappliances.com,care@mayaappliances.com',$msg,$subject,'care@vidiem.in',$from_mail);
                $this->session->set_flashdata('title', "Success");   
                $this->session->set_flashdata('msg', "Email Send Successfully.");     
                $this->session->set_flashdata('type', "success");
                
                // Client Mail
                $msg2='<style>
        div.mail > p{
            margin:0px 0px 1em;padding:0px;color:rgb(51,51,51);font-family:q_serif,Georgia,Times,&quot;Times New Roman&quot;,&quot;Hiragino Kaku Gothic Pro&quot;,Meiryo,serif;font-size:16px
        } 
        table{background-color:#e6e6e6;margin:0 auto;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}
        </style>
        <div class="mail"><p>Dear '.$this->input->post('name').'</p>
        <p>Thanks for registering the product with us.</p>
        <p>Registered Reference Number : <b>'.$code.'</b>. Date : <b>'.date('d-m-Y').'</b></p>
              <table>
                <tr>
                    <td colspan="2" class="tc" style="text-align:center;"><u>Registration Details</u></td></br>
                </tr>
                 <tr><td>Registration Code</td>
                    <td style="padding:10px 0;">'.$code.'</td></tr></br>
                <tr>
                    <td>Name</td>
                    <td style="padding:10px 0;">'.$this->input->post('name').'</td>
                </tr></br>
                <tr>
                    <td>Age</td>
                    <td style="padding:10px 0;">'.$this->input->post('age').'</td>
                </tr></br>
                 <tr>
                    <td>Category</td>
                    <td style="padding:10px 0;">'.$cat_name.'</td>
                </tr></br>
                <tr>
                    <td>Product</td>
                    <td style="padding:10px 0;">'.$pro_name.'</td>
                </tr>
                <tr>
                    <td>Purchase Date</td>
                    <td style="padding:10px 0;">'.$this->input->post('jdate').'</td>
                </tr>
                    <tr>
                    <td>Phone Number</td>
                    <td style="padding:10px 0;">'.$this->input->post('mobile').'</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td style="padding:10px 0;">'.$this->input->post('email').'</td>
                </tr>
				 <tr>
                    <td>Purchase From</td>
                    <td style="padding:10px 0;">'. $this->input->post('purchasefrom').'</td>
                </tr>
                <tr>
                    <td>Dealer</td>
                    <td style="padding:10px 0;">'. $this->input->post('dealername').'</td>
                </tr>
                <tr>
                    <td>Serial Number</td>
                    <td style="padding:10px 0;">'. $this->input->post('serialnumer').'</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td style="padding:10px 0;">'.$this->input->post('address').'</td>
                </tr>
                <tr>
                    <td>City</td>
                    <td style="padding:10px 0;">'.$this->input->post('city').'</td>
                </tr>
                <tr>
                    <td>State</td>
                    <td style="padding:10px 0;">'.$this->input->post('state').'</td>
                </tr>
                <tr>
                    <td>Pincode</td>
                    <td style="padding:10px 0;">'.$this->input->post('pincode').'</td>
                </tr>
            </table>
       <p>Regards,</p><p>Vidiem Team.</p></div>';
         $this->FunctionModel->sendmail1($from_mail, $msg2, 'Vidiem Product Registration','care@vidiem.in');
                redirect('product-registration', 'refresh');
                }
        }
        $data['city']=$this->ProjectModel->getCities();
        $cat_id=$this->input->post('category');
        if(!empty($cat_id)){
        $data['products']=$this->FunctionModel->Select_Fields('id,name','vidiem_products',array('cat_id'=>$cat_id));
        }
        $this->load->view('product-registration',@$data);
    }
    
     public function complaint_registration(){
        $data['menu_id']=4;
        $data['category']=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('status'=>1,'parent_id'=>0));
        $data['productregistrationseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Product Complaint'));
        $this->form_validation->set_rules('category','Category','required');
        $this->form_validation->set_rules('product','Product','required');
        $this->form_validation->set_rules('serialnumer','Serial number','required|regex_match[/^[Cc][Hh][A-Za-z0-9]{13}$/]');
        $this->form_validation->set_rules('jdate','Date of purchase','required');
        $this->form_validation->set_rules('dealername','Dealer name','required|regex_match[/^[A-Za-z &]*$/]');
         $this->form_validation->set_rules('remarks','Complaint remarks','required|regex_match[/^[A-Za-z0-9 &,]*$/]');
        $this->form_validation->set_rules('name','Name','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('mobile','Mobile number','required|regex_match[/^[0-9]{10}$/]');
      //  $this->form_validation->set_rules('mobile2','Alternative Mobile Numer','required');
        $this->form_validation->set_rules('address','Address','required|regex_match[/^[A-Za-z0-9 &,:#]*$/]');
        $this->form_validation->set_rules('city','City','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('state','State','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('pincode','Pincode','required|regex_match[/^[0-9]{6}$/]');
        //$this->form_validation->set_rules('captcha','Captcha','required');
        $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_google_validate_captcha');
        if ($this->form_validation->run() === TRUE) {
                $email=$this->input->post('email');
                $this->db->like('created',date('Y-m-d'));
                $tmp=$this->db->get_where('vidiem_complaint_registration',['email'=>$email])->row_array();
                if(!empty($tmp)){
                        $this->session->set_flashdata('title', "Information");   
                        $this->session->set_flashdata('msg', "Already Registered. Your Complaint Id - ".$tmp['code']);     
                        $this->session->set_flashdata('type', "info");
                        redirect('complaint-registration', 'refresh'); 
                }
            $cat_id=$this->input->post('category');
            $pro_id=$this->input->post('product');
            $cat_name=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$cat_id));
            $pro_name=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$pro_id));
            $this->db->like('year(created)',date('Y'));
            $code=$this->ProjectModel->complaintCode();
             $InsertData=array(
                    'code'              =>  $code,
                    'category'          =>  $this->input->post('category'),
                    'product'           =>  $this->input->post('product'),
                    'serialnumer'       =>  $this->input->post('serialnumer'),
                    'purchase_date'     =>  $this->input->post('jdate'),
                    'dealername'        =>  $this->input->post('dealername'),
                    'remarks'           =>  $this->input->post('remarks'),
                    'name'              =>  $this->input->post('name'),
                    'email'             =>  $this->input->post('email'),
                    'mobile'            =>  $this->input->post('mobile'),
                    'alternative_mobile'=>  $this->input->post('mobile2'),
                    'address'           =>  $this->input->post('address'),
                    'city'              =>  $this->input->post('city'),
                    'state'             =>  $this->input->post('state'),
                    'pincode'           =>  $this->input->post('pincode'),
                    'created'           =>  date('Y-m-d H:i:s')
                );
                $result=$this->FunctionModel->Insert($InsertData,'vidiem_complaint_registration');
            $from_mail=$this->input->post('email');
            $subject='Complaint Registration In Website';
            $msg='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
              <table>
                <tr><td colspan="2" class="tc" style="text-align:center;"><u>Complaint Registration In Website</u></td></br></tr>
                <tr><td>Complaint Code</td>
                    <td style="padding:10px 0;">'.$code.'</td></tr></br>
                <tr><td>Name</td>
                    <td style="padding:10px 0;">'.$this->input->post('name').'</td></tr></br>
                <tr><td>Category</td>
                    <td style="padding:10px 0;">'.$cat_name.'</td></tr></br>
                <tr><td>Product</td>
                    <td style="padding:10px 0;">'.$pro_name.'</td></tr></br>
                <tr><td>Mobile Number</td>
                    <td style="padding:10px 0;">'.$this->input->post('mobile').'</td></tr>
                <tr><td>Alternative Mobile Number</td>
                    <td style="padding:10px 0;">'.$this->input->post('mobile2').'</td></tr>
                <tr><td>Email</td>
                    <td style="padding:10px 0;">'.$this->input->post('email').'</td></tr>
                <tr><td>Dealer</td>
                    <td style="padding:10px 0;">'. $this->input->post('dealername').'</td></tr>
                <tr><td>Serial Number</td>
                    <td style="padding:10px 0;">'. $this->input->post('serialnumer').'</td></tr>
                <tr><td>Complaint remarks</td>
                    <td style="padding:10px 0;">'. $this->input->post('remarks').'</td></tr>
                <tr><td>Address</td>
                    <td style="padding:10px 0;">'.$this->input->post('address').'</td></tr>
                <tr><td>City</td>
                    <td style="padding:10px 0;">'.$this->input->post('city').'</td></tr>
                <tr><td>State</td>
                    <td style="padding:10px 0;">'.$this->input->post('state').'</td></tr>
                <tr><td>Pincode</td>
                    <td style="padding:10px 0;">'.$this->input->post('pincode').'</td></tr>
            </table>';
             $this->FunctionModel->sendmail1('care@vidiem.in',$msg,$subject,'care@vidiem.in',$from_mail);
           
           $msg2='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
              <table>
                <tr>
                    <td colspan="2" class="tc"><u>Hi,</u></td></br>
                </tr>
                <tr>
                    <td>Your Complaint Code is :&nbsp;&nbsp;'.$code. '</td>
                    
                </tr></br></br>
                <tr>
                    <td>Thanks for your request. Our executive will contact you asap. </td>
                
                </tr></br></br>
                <tr>
                    <td>Warm Regards, </td>
                
                </tr>
                <tr>
                    <td>Vidiem Customer Care</td>
                
                </tr>
                <tr>
                    <td>care@vidiem.in</td>
                
                </tr>
                <tr>
                    <td>044-6635 6635 / 77110 06635</td>
                
                </tr></br>
                    
            </table>';
            $this->FunctionModel->sendmail1($from_mail, $msg2, 'Complaint Code','care@vidiem.in');
              // $this->sendCovidMail($from_mail);
                $this->session->set_flashdata('title', "Success");   
                $this->session->set_flashdata('msg', "Email Send Successfully.");     
                $this->session->set_flashdata('type', "success");
                redirect('complaint-registration', 'refresh');
        }
        $data['city']=$this->ProjectModel->getCities();
        $cat_id=$this->input->post('category');
        if(!empty($cat_id)){
        $data['products']=$this->FunctionModel->Select_Fields('id,name','vidiem_products',array('cat_id'=>$cat_id));
        }
        $this->load->view('complaint-registration',@$data);
    }
    public function sendCovidMail($from)
    {
         $subject='Vidiem Care';
         $msg='
              <table>
                <tr><td><u>Dear Customer,</u></td></tr>
                <tr></tr>
                <tr></tr>
                <tr><td>Due to the <u>COVID-19</u> pandemic our <u>call centres and service centres are closed till 17th May 2020</u>.</td>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr><td>Thank for your cooperation.</td></tr>
                <tr></tr>
                <tr></tr>
                <tr><td>Regards.</td></tr>
                <tr><td>Vidiem Team</td></tr>
                <tr></tr>
            </table>';
           $this->FunctionModel->sendmail1($from,$msg,$subject,'care@vidiem.in');
    }
    public function complaintProductFetch(){
        $cat_id=$this->input->post('cat_id');
        $return['products']=$this->FunctionModel->Select_Fields('id,name','vidiem_products',array('cat_id'=>$cat_id));
        $return['status']=1;
        if(empty($return['products'])){ $return['status']=2;}
        echo json_encode($return);
        exit;
    }

    public function user_manual(){
        $data['menu_id']=4;
        //$data['usermanual']=$this->FunctionModel->Select('vidiem_user_manual',array('status'=>1),'order_no','ASC');
        $data['usermanualseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'User Manual'));
		$data['feature_category']=$this->FunctionModel->Select_Fields('id,slug,name,image','vidiem_category',array('parent_id'=>0,'status'=>1,'featured'=>1),'order_no','ASC');
        $this->load->view('user-manual',@$data);
    }

    public function faqs(){ 
        $data['menu_id']=4;
        $data['faq_cat']=$this->FunctionModel->Select('vidiem_faq',array('status'=>1));
        $data['FAQseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'FAQ'));
        $this->load->view('faq',@$data);
    }

    public function demo_videos(){
        $data['menu_id']=4;
        $data['demovideo']=$this->FunctionModel->Select('vidiem_video',array('status'=>1));
        $data['demovideoseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Demo Videos'));
        $this->load->view('demo-video',@$data);
    }

    public function dealer_locator(){
        $data['menu_id']=4;
        $data['dealerlocatorseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Dealer Locator'));
        $this->load->view('dealer-locator',@$data);
    }

    public function service_centers(){
        $data['menu_id']=4;
        $data['servicecenterseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Service Center'));
        $this->load->view('service-center',@$data);
    }

    public function warranty(){
        $data['menu_id']=4;
        $data['warranty']=$this->FunctionModel->Select('vidiem_warranty',array('status'=>1),'order_no','ASC');
        $data['warrantyseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Warranty Terms'));
        $this->load->view('warranty',@$data);
    }

    // 404 Pages
    public function page_not_found(){
        echo 'Page Not Found'; exit;
    }

    public function Subscribe(){

            $listID = $this->dbvars->newsletter_id;
            $emailAddress = $this->input->post('email');
            $retval = $this->mcapi->listSubscribe($listID, $emailAddress);  
          if ($this->mcapi->errorCode){  
        if($this->mcapi->errorCode==214){
            echo '2';
            }
            else{
            echo '3';   
            } 
          }else{  
            echo '1';  
          }  
        exit;  
    } 

    public function Logout(){
		$this->session->unset_userdata('previous_url');
        $this->session->unset_userdata('client_id');
        $this->session->unset_userdata('client_name');
        $this->session->unset_userdata('userData');
        $this->session->unset_userdata('loggedIn');
        $this->session->set_flashdata('title', "Success");   
        $this->session->set_flashdata('msg', "Logout Successfully.");    
        $this->session->set_flashdata('type', "success");
        redirect('', 'refresh');
    }

     // Destroy All Session
    public function Destroy(){
        $this->session->sess_destroy();
        exit;
    }
    /*
    public function AjaxRegisterGuest(){
        $this->form_validation->set_rules('guestname','Name','required');
        $this->form_validation->set_rules('guestemail','Email','required|valid_email');
        $this->form_validation->set_rules('guestmobile_no','Mobile No.','required');
        $this->form_validation->set_message('is_unique','%s Already Exist');
        if($this->form_validation->run()==true){
            $otp_code=rand(100000,999999);
            $password=rand(100000,999999);
            $mobile=str_replace(' ','',$this->input->post('guestmobile_no'));
            $mobileExs=$this->FunctionModel->Select_Fields_Row('id,name','vidiem_clients',array('mobile_no'=>$mobile));
            if($mobileExs){
                 $UpdateData=array(
                    'sms_code'      => $otp_code,
                    'status'        => 1,
                    'sms_verified'  => 0,
                    'password'      => md5($password),
                    'role' =>2,
                    'created'       => date('Y-m-d H:i:s')
                );
                 $this->FunctionModel->Update($UpdateData,'vidiem_clients',array('id'=>$mobileExs['id'])); 
                 SMS($mobile,'Hi '.$mobileExs['name'].', Your OTP is '.$otp_code);
                 $client_id=$mobileExs['id'];
            }else{
                 $emailExs=$this->FunctionModel->Select_Fields_Row('id,name','vidiem_clients',array('email'=>$this->input->post('guestemail')));
                 if($emailExs){
                   $return['status']=2;
                   $return['guestemail']='<p class="error">Email id Already Exist with different Phone number!</p>';
                 }else{
                   $InsertData=array(
                    'name'          => $this->input->post('guestname'),
                    'email'         => $this->input->post('guestemail'),
                    'mobile_no'     => $mobile,
                    'sms_code'      => $otp_code,
                    'status'        => 1,
                    'sms_verified'  => 0,
                    'password'      => md5($password),
                    'role' =>2,
                    'created'       => date('Y-m-d H:i:s')
                 );
                $client_id=$this->FunctionModel->Insert($InsertData,'vidiem_clients');   
                SMS($mobile,'Hi '.$this->input->post('guestname').', Your OTP is '.$otp_code); 
                 }
                 
            }
            $this->session->set_userdata('otp_client_id',$client_id);
            //$this->ProjectModel->GuestWelcomeMail($client_id);
            //$this->ProjectModel->ClientIdLogin($client_id);
            $return['status']=1;
        }
        else{
            $return['status']=2;
            $return['guestname']=form_error('guestname');
            $return['guestemail']=form_error('guestemail');
            $return['guestmobile_no']=form_error('guestmobile_no');
        }
        echo json_encode($return);
        exit;
    } */
    
     public function AjaxRegisterGuest(){
        $this->form_validation->set_rules('guestname','Name','required');
        $this->form_validation->set_rules('guestemail','Email','required|valid_email');
        $this->form_validation->set_rules('guestmobile_no','Mobile No.','required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_message('is_unique','%s Already Exist');
        if($this->form_validation->run()==true){
            $otp_code=rand(100000,999999);
            $password=rand(100000,999999);
            $mobile=str_replace(' ','',$this->input->post('guestmobile_no'));
            $mobileExs=$this->FunctionModel->Select_Fields_Row('id,name','vidiem_clients',array('mobile_no'=>$mobile));
            if($mobileExs){
                 $UpdateData=array(
                    'sms_code'      => $otp_code,
                    'status'        => 1,
                    'sms_verified'  => 0,
                    'password'      => md5($password),
                    'role' =>2,
                    'created'       => date('Y-m-d H:i:s')
                );
                 $this->FunctionModel->Update($UpdateData,'vidiem_clients',array('id'=>$mobileExs['id'])); 
                 SMS($mobile,'Hi '.$mobileExs['name'].', Your Website Login OTP is '.$otp_code.' - Vidiem','1107161906519249334');
                 $client_id=$mobileExs['id'];
            }else{
                 $emailExs=$this->FunctionModel->Select_Fields_Row('id,name','vidiem_clients',array('email'=>$this->input->post('guestemail')));
                 if($emailExs){
                   $return['status']=2;
                   $return['guestemail']='<p class="error">Email id Already Exist with different Phone number!</p>';
                 }else{
                   $InsertData=array(
                    'name'          => $this->input->post('guestname'),
                    'email'         => $this->input->post('guestemail'),
                    'mobile_no'     => $mobile,
                    'sms_code'      => $otp_code,
                    'status'        => 1,
                    'register_type' => 2,
                    'sms_verified'  => 0,
                    'password'      => md5($password),
                    'role' =>2,
                    'created'       => date('Y-m-d H:i:s')
                 );
                $client_id=$this->FunctionModel->Insert($InsertData,'vidiem_clients');   
                SMS($mobile,'Hi '.$this->input->post('guestname').', Your Website Login OTP is '.$otp_code.' - Vidiem','1107161906519249334'); 
                 }
                 
            }
            $this->session->set_userdata('otp_client_id',$client_id);
            //$this->ProjectModel->GuestWelcomeMail($client_id);
            //$this->ProjectModel->ClientIdLogin($client_id);
            $return['status']=1;
        }
        else{
            $return['status']=2;
            $return['guestname']=form_error('guestname');
            $return['guestemail']=form_error('guestemail');
            $return['guestmobile_no']=form_error('guestmobile_no');
        }
        echo json_encode($return);
        exit;
    }

    // Checkout Register and Login Option

    public function AjaxForgotPassword(){
        $this->form_validation->set_rules('email','Email','required|callback_forgot_email');
        if($this->form_validation->run()===TRUE){
            $email=$this->input->post('email');
            $id=$this->FunctionModel->Select_Field('id','vidiem_clients',array('email'=>$email));
            $this->ProjectModel->SentNewPassword($id);
            $return['status']=1;
        }else{
            $return['status']=2;
            $return['email']=form_error('email');
        }
        echo json_encode($return);
        exit;
    }

    public function AjaxRegister(){
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('dob','DOB','required');
        $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[vidiem_clients.email]');
        $this->form_validation->set_rules('mobile_no','Mobile No.','required|is_unique[vidiem_clients.mobile_no]|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('password','Password','required|min_length[6]');
        $this->form_validation->set_message('is_unique','%s Already Exist');
        if($this->form_validation->run()==true){
            $otp_code=rand(100000,999999);
            $InsertData=array(
                'name'          => $this->input->post('name'),
                'email'         => $this->input->post('email'),
                'mobile_no'     => str_replace(' ','',$this->input->post('mobile_no')),
                'gender'        => $this->input->post('gender'),
                'dob'           => $this->input->post('dob'),
                'newsletter'    => $this->input->post('newsletter'),
                'special_offer' => $this->input->post('special_offer'),
                'sms_code'      => $otp_code,
                'sms_verified'  => 1,
                'password'      => md5($this->input->post('password')),
                'status'        => 1,
                'created'       => date('Y-m-d H:i:s')
            );
            $client_id=$this->FunctionModel->Insert($InsertData,'vidiem_clients');
            $this->ProjectModel->ClientIdLogin($client_id);
            $email=$this->input->post('email');
            $name=$this->input->post('name');
            $this->ProjectModel->WelcomeMail($email,$name);
            $return['status']=1;
        }
        else{
            $return['status']=2;
            $return['name']=form_error('name');
            $return['email']=form_error('email');
            $return['dob']=form_error('dob');
            $return['mobile_no']=form_error('mobile_no');
            $return['password']=form_error('password');
        }
        echo json_encode($return);
        exit;
    }

     public function AjaxOtpVerify(){
       $this->form_validation->set_rules('sms_code','SMS Code','required|callback_otp_verify');
        if($this->form_validation->run()===true){
           $id=$this->session->userdata('otp_client_id');
           $UpdateData=array(
                'sms_verified'=>1,
                'modified'=>date('Y-m-d H:i:s')
           );
            $this->FunctionModel->Update($UpdateData,'vidiem_clients',array('id'=>$id));
            $row=$this->FunctionModel->Select_Fields_Row('id,name,email','vidiem_clients',array('id'=>$id));
            $this->ProjectModel->WelcomeMail($row['email'],$row['name']);
            $this->ProjectModel->ClientIdLogin($id);
            $return['status']=1;
            $contents=$this->cart->contents();
            if(empty($contents)){
                $redirect='user/dashboard';
            }else{
                $redirect='checkout';
            }
             $return['redirect']=$redirect;
        }else{
             $return['status']=2;
             $return['sms_code']=form_error('sms_code');
        }
        echo json_encode($return);
        exit;
    }

    public function AjaxSignIn(){
        $this->form_validation->set_rules('user_name','Email or Phone No.','required');
        $this->form_validation->set_rules('password','Password','required|callback_password_check');
         if($this->form_validation->run()==TRUE){
            $user_name=$this->input->post('user_name');
            $password=md5($this->input->post('password'));
            $status=$this->ProjectModel->ClientLogin($user_name,$password);
            if($status==1){
                $return['status']=1;
            }
            else if($status==2){
                 $return['status']=2;
            }
            else if($status==3){
                $return['status']=3;
            }
        }else{
             $return['status']=4;
             $return['user_name']=form_error('user_name');
             $return['password']=form_error('password');
        }   
        echo json_encode($return);
        exit;
    }

    public function AjaxFetchAddress(){
        $id=$this->input->post('id');
        if(empty($id)){ exit;}
        $client_id=$this->session->userdata('client_id');
        $count=$this->FunctionModel->Row_Count('vidiem_clients_address',array('id'=>$id,'client_id'=>$client_id));
        if($count==0){exit;}
        $info=$this->FunctionModel->Select_Fields_Row('id,name,company_name,address,address2,city,zip_code,state,country,mobile_no','vidiem_clients_address',array('id'=>$id));
        $return['address']='';
        $return['address'].='
            <p>'.@$info['name'].'</p>';
            if(!empty($info['company_name'])){ 
                $return['address'].='<p>'.@$info['company_name'].'</p>';
            }    
            $return['address'].='<p>'.@$info['address'].'</p>';
            if(!empty($info['address2'])){ 
                $return['address'].='<p>'.@$info['address2'].'</p>';
            } 
            $return['address'].='<p>'.@$info['city'].' - '.@$info['zip_code'].'</p>
            <p>'.@$info['country'].'</p>
            <p>'.@$info['mobile_no'].'</p>
            <a href="javascript:void(0);" class="btn updateAdd update_address_trigger" data-id="'.$info['id'].'">Update</a>';
        echo json_encode($return);
        exit;
    }


    // Google Login

    public function google_login(){
        $client_id=$this->session->userdata('client_id');
		$previous_url = $this->session->userdata('previous_url');
		$this->session->unset_userdata("previous_url");
		
        if(!empty($client_id)){
            $contents=$this->cart->contents();
            if(empty($contents)){
                redirect('user/dashboard');
            }else if($previous_url=='checkout' || $previous_url=='cart'){
				redirect($previous_url, 'refresh');
			}else{
                redirect('checkout');
            }
        }
        if(isset($_GET['code'])){
            //authenticate user
            $this->google->getAuthenticate();
            //get user info from google
            $gpInfo = $this->google->getUserInfo();
            //preparing data for database insertion
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid']      = $gpInfo['id'];
            $userData['first_name']     = $gpInfo['given_name'];
            $userData['last_name']      = $gpInfo['family_name'];
            $userData['email']          = $gpInfo['email'];
            $userData['gender']         = !empty($gpInfo['gender'])?$gpInfo['gender']:'';
            $userData['locale']         = !empty($gpInfo['locale'])?$gpInfo['locale']:'';
            $userData['profile_url']    = !empty($gpInfo['link'])?$gpInfo['link']:'';
            $userData['picture_url']    = !empty($gpInfo['picture'])?$gpInfo['picture']:'';
            //insert or update user data to the database
            $this->ProjectModel->Login_with_google($userData);
            //redirect to profile page
            $this->session->set_flashdata('reload', "1"); 

            $contents=$this->cart->contents();
            if(empty($contents)){
                redirect('user/dashboard','refresh');
            }else if($previous_url=='checkout' || $previous_url=='cart'){
				redirect($previous_url, 'refresh');
			}else{
                redirect('checkout');
            }
        } 
		
        redirect('sign-in');
    }
    public function fb_login(){
        $redirect="";
        $userEmail=$this->input->post('userEmail');
        $userName=$this->input->post('userName');
        $userFBId=$this->input->post('userFBId');
        $userGender=$this->input->post('userGender');
        if($userFBId && $userEmail){
            $contents=$this->cart->contents();
			$previous_url = $this->session->userdata('previous_url');
			$this->session->unset_userdata("previous_url");
            if(empty($contents)){
                $redirect='user/dashboard';
            }else if($previous_url=='checkout' || $previous_url=='cart'){
				$redirect=$previous_url;
			}else{
                $redirect='checkout';
            }
            $userData=array(
                'name'=>$userName,
                'email'=>$userEmail,
                );
            $this->ProjectModel->Login_with_facebook($userData);
            $return=array('state'=>1,'message'=>'Logged in Successfully!','redirect'=>$redirect);
        }else{
            $return=array('state'=>2,'message'=>'Something went wrong .Please try after some time!.');
        }
           echo json_encode($return);exit;
    }
    public function facebook_login(){
        $client_id=$this->session->userdata('client_id');
		$previous_url = $this->session->userdata('previous_url');
		$this->session->unset_userdata("previous_url");
        if(!empty($client_id)){
            $contents=$this->cart->contents();
            if(empty($contents)){
                redirect('user/dashboard');
            }else if($previous_url=='checkout' || $previous_url=='cart'){
				redirect($previous_url, 'refresh');
			}else{
                redirect('checkout');
            }
        }
        if($this->facebook->setSession()){
            $tmp=$this->facebook->getProfile();
            if(!empty($tmp['email'])){
                $userData['name']  = $tmp['name'];
                $userData['email'] = $tmp['email'];
                //insert or update user data to the database
                $this->ProjectModel->Login_with_facebook($userData);
                //redirect to profile page
                $this->session->set_flashdata('reload', "1");  
                $contents=$this->cart->contents();
                if(empty($contents)){
                    redirect('user/dashboard','refresh');
                }else if($previous_url=='checkout' || $previous_url=='cart'){
					redirect($previous_url, 'refresh');
				}else{
                    redirect('checkout');
                }
            }else{
                $this->session->set_flashdata('title', "Warning");   
                $this->session->set_flashdata('msg', "Can't capture your email. Register with Email Id");    
                $this->session->set_flashdata('type', "warning");
                $this->session->set_flashdata('fb_issue', "1");  
                redirect('sign-in','refresh');
            } 
          }else{
                $this->session->set_flashdata('title', "Warning");   
                $this->session->set_flashdata('msg', "Can't capture your email. Register with Email Id");    
                $this->session->set_flashdata('type', "warning");
                $this->session->set_flashdata('fb_issue', "1");  
                redirect('sign-in','refresh');
        }
    }

    // Coupon Code Functionalit
    public function coupon_check(){
        $client_id=$this->session->userdata('client_id');
         $code=$this->input->post('code');
        if(empty($code)){
            $return['status']=2;
            $return['msg']='Enter Coupon Code';
        }else{
            if(empty($client_id)){
                $return['status']=2;
                $return['msg']='Login to use coupon code';
            }else{
                $info=$this->ProjectModel->valid_coupon($code);
                if(empty($info)){
                     $return['status']=2;
                     $return['msg']='Invlid Coupon Code';
                }else{
                    $total=$this->cart->total();
                    $user_order_count=$this->FunctionModel->Row_Count('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success'));
                    $user_used=$this->FunctionModel->Row_Count('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success','coupon_id'=>$info['id']));
                    $total_used=$this->FunctionModel->Row_Count('vidiem_order',array('payment_status'=>'success','coupon_id'=>$info['id']));
                    
                    if($total<$info['min_order']){
                         $return['status']=2;
                         $return['msg']='Coupon valid min. order '.$info['min_order'] ;
                         echo json_encode($return);
                        exit;
                    }
                    if($user_order_count !=0 && $info['only_first_order']==1){
                         $return['status']=2;
                         $return['msg']='Coupon code valid only for first order' ;
                         echo json_encode($return);
                         exit;
                    }
                    if($user_used >= $info['max_per_user']){
                         $return['status']=2;
                         $return['msg']='Coupon code Invalid' ;
                         echo json_encode($return);
                         exit;
                    }
                    if($user_used >= $info['max_usage']){
                         $return['status']=2;
                         $return['msg']='Coupon code Invalid' ;
                         echo json_encode($return);
                         exit;
                    }
                    $return['status']=1;
                    if($info['type']==1){
                        $discount=$total*($info['discount_value']/100);
                        $discount=($discount>$info['max_discount'])?$info['max_discount']:$discount;
                        $return['msg']='<li class="clearfix">
                        <p class="priceti">Price ('.number_format($this->cart->total_items()).' Item)</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()).'</p>
                        </li>
                        <li class="clearfix">
                        <p class="priceti">Delivery Charges</p>
                        <p class="priceAm gre">Free</p>
                        </li>
                        <li class="clearfix">
                        <p class="priceti">Discount '.number_format($info['discount_value']).'% </p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($discount).'</p>
                        </li>
                        <li class="clearfix toamount">
                        <p class="priceti">AMOUNT PAYABLE</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()-$discount).'/-</p>
                        </li>';
                    }else if($info['type']){
                         $discount=($info['discount_value']);
                        $return['msg']='<li class="clearfix">
                        <p class="priceti">Price ('.number_format($this->cart->total_items()).' Item)</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()).'/-</p>
                        </li>
                        <li class="clearfix">
                        <p class="priceti">Delivery Charges</p>
                        <p class="priceAm gre">Free</p>
                        </li>
                         <li class="clearfix">
                        <p class="priceti">Discount</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($discount).'</p>
                        </li>
                        <li class="clearfix toamount">
                        <p class="priceti">AMOUNT PAYABLE</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()-$discount).'/-</p>
                        </li>';
                    }
                }
            }
        }
        echo json_encode($return);
        exit;
    }

    public function remove_coupon(){
        $nounce=$this->input->post('nounce');
        if(empty($nounce)){ exit;}
        echo '<li class="clearfix">
                        <p class="priceti">Price ('.number_format($this->cart->total_items()).' Item)</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()).'/-</p>
                    </li>
                    <li class="clearfix">
                        <p class="priceti">Delivery Charges</p>
                        <p class="priceAm gre">Free</p>
                    </li>
                    <li class="clearfix toamount">
                        <p class="priceti">AMOUNT PAYABLE</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()).'/-</p>
                    </li>';
          exit;          
    }

    public function AjaxProductCheck(){
         $pincode=$this->input->post('pincode');
        if(empty($pincode)){ exit;}
        $desc=$this->FunctionModel->Select_Field('description','vidiem_availability',array('status'=>1,'pincode'=>$pincode));
        if(empty($desc)){
            $return['msg']="<p class='success'>Delivery option available to the location</p>";
        }
        else{
            $return['msg']="<p class='success'>$desc<p>";
        }
         echo json_encode($return);
        exit;
    }

	
	public function AjaxProductFilter(){
	
	
		$price=$this->input->post('price');
        $cat_id=$this->input->post('cat_id');
        $type=$this->input->post('type');
        $parent_id=$this->input->post('parent_id');
        $filters=$this->input->post('filters');
		$sub_filters=$this->input->post('sub_filters');;
	//	print_r($sub_filters); exit;
	//	print_r( $sub_cat_id); die();
        $sort=$this->input->post('sort');
        $stock=$this->input->post('stock');
        $product=$this->ProjectModel->ProductFilter($cat_id,$price,$filters,$type,$parent_id,$sort,$stock,$sub_filters);
		
		 $return['data']='';
		 
		 if(!empty($product)){ 
				$return['data'].='<div class="container">
				<div class="row search_div serach_listing tab-content">';
				
				foreach($product as $data){ 

					$return['data'].='<div class="col-sm-12 col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						
					<div class="product-listing-item">
						<a href="'.base_url('product/'.$data['slug']).'"><h3><strong>Vidiem</strong> '.$data['name'].'</h3>
						<p class="price">₹ '.@number_format($data['price']).' ';
						
						if(isset($data['old_price']) && $data['old_price']>0){ 
						
							$return['data'].='<span class="strike">₹ '.@number_format($data['old_price']).'</span>';
						} 
						$return['data'].='</p>
						<img src="'.base_url('uploads/images/'.$data['image']).'" alt="" />
						</a>
						<p class="product-link">';
						if($data['outofstock']==0){
						//$return['data'].='<a href="javascript:void(0);" class="buy-now add_to_cart" data-id="'.@$data['id'].'">Add to Cart</a><a class="add-to-cart" href="javascript:void(0);"><i class="lni lni-cart"></i></a>';
						
						$return['data'].='<a href="'.base_url('buy-now/'.$data['id']).'" class="buy-now">Buy Now</a><a class="add-to-cart add_to_cart" href="javascript:void(0);" data-id="'.@$data['id'].'" ><i class="lni lni-cart"></i></a>';
						
						} else{ 
						$return['data'].='<a href="'.base_url('contact-us').'" class="buy-now">Out of Stock</a><a class="add-to-cart" href="javascript:void(0);"><i class="lni lni-cart"></i></a>';
						 } 
						$return['data'].='</p>
						<a href="#comProList" class="add-to-compare " data-toggle="modal" data-target="#AddToCompareModal" onclick="addtocompare('.@$data['id'].');"><i class="lni lni-reload"></i> Add to Compare</a>									
					</div>
					</div>';					

				}
				
				$return['data'].='</div>
			</div>';
             }else{ 
                $return['data'].='<div class="search_div noProAvaiSet"><p>No Products Available</p></div>';
             } 
              echo json_encode($return);
        exit;  
		
	}

    
    public function AjaxSearchFilter(){
		//print_r($_REQUEST); exit;
        $price=$this->input->post('price');
        $term=$this->input->post('term');
        $cat_id=$this->input->post('cat_id');
        $filters=$this->input->post('filters');
        $sort=$this->input->post('sort');
         $stock=$this->input->post('stock');
        if(!empty($cat_id)){
			
            $product=$this->ProjectModel->ProductFilter($cat_id,$price,$filters,'','',$sort,$stock);
        }else{
            $product=$this->ProjectModel->AjaxSearchFilter($term,$price,$sort,$stock);
        }
		 $return['data']='';
		 
		 if(!empty($product)){ 
				$return['data'].='<div class="container">
				<div class="row search_div serach_listing tab-content">';
				
				foreach($product as $data){ 

					$return['data'].='<div class="col-sm-12 col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">
						
					<div class="product-listing-item">
						<a href="'.base_url('product/'.$data['slug']).'"><h3><strong>Vidiem</strong> '.$data['name'].'</h3>
						<p class="price">₹ '.@number_format($data['price']).' ';
						
						if(isset($data['old_price']) && $data['old_price']>0){ 
						
							$return['data'].='<span class="strike">₹ '.@number_format($data['old_price']).'</span>';
						} 
						$return['data'].='</p>
						<img src="'.base_url('uploads/images/'.$data['image']).'" alt="" />
						</a>
						<p class="product-link">';
						if($data['outofstock']==0){
						$return['data'].='<a href="'.base_url('buy-now/'.$data['id']).'" class="buy-now">Buy Now</a><a class="add-to-cart add_to_cart" href="javascript:void(0);" data-id="'.@$data['id'].'" ><i class="lni lni-cart"></i></a>';
						} else{ 
						$return['data'].='<a href="'.base_url('contact-us').'" class="buy-now">Out of Stock</a><a class="add-to-cart" href="javascript:void(0);"><i class="lni lni-cart"></i></a>';
						 } 
						$return['data'].='</p>
						<a href="#comProList" class="add-to-compare" data-toggle="modal" data-target="#AddToCompareModal" onclick="addtocompare('.@$data['id'].');" ><i class="lni lni-reload"></i> Add to Compare</a>									
					</div>
					</div>';					

				}
				
				$return['data'].='</div>
			</div>';
             }else{ 
                $return['data'].='<div class="search_div noProAvaiSet"><p>No Products Available</p></div>';
             } 
              echo json_encode($return);
        exit;  
    }
   
    public function cancellation_policy(){
        $data['menu_id']=45;
        $data['cancellationpolicyseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Cancellation Policy'));
          $this->load->view('cancellation-policy',$data);
     }
      public function Disclaimer(){
         $data['menu_id']=46;
         $data['Disclaimerseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Disclaimer'));
          $this->load->view('disclaimer',$data);
     }
      public function privacy_policy(){
        $data['menu_id']=47;
         $data['privacypolicyseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Privacy Policy'));
          $this->load->view('privacy-policy',$data);
     }
     public function vidiem_adc(){
        $data['menu_id']=52;
         $data['vidiemadcseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Vidiem ADC'));
          $this->load->view('vidiem-adc',$data);
     }
     public function vidiem_iris(){
        $data['menu_id']=53;
         $data['vidiemirisseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Vidiem IRIS'));
          $this->load->view('vidiem-iris',$data);
     }
      public function return_refund_policy(){
        $data['menu_id']=48;
        $data['returnrefundseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Return Policy'));
          $this->load->view('return-refund-policy',$data);
     }
     public function shipping_delivery(){
        $data['menu_id']=49;
        $data['shippingseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Shipping & Delivery'));
          $this->load->view('shipping-delivery',$data);
     }
      public function Sitemap(){
        $data['menu_id']=50;
         $data['sitemapseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Sitemap'));
          $this->load->view('sitemap',$data);
     }
      public function terms_conditions(){
        $data['menu_id']=51;
        $data['termsconditionseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Terms and conditions'));
          $this->load->view('terms-conditions',$data);
     }
 public function AjaxRecipe(){
            $id=$this->input->post('id');
            if(empty($id)){ redirect();}
            $recipe=$this->FunctionModel->Select_Row('vidiem_recipe',array('id'=>$id));
            echo '
        <div class="reCipeImgDetail">
            <img src="'.base_url('uploads/recipe/'.$recipe['image']).'">
        </div>
        <div class="recipeDetailIncri clearfix">
            <div class="ingredientsLeftReci">
                <div class="titleIncriReci">
                    <p>Ingredients For</p>
                    <p>'.$recipe['name'].'</p>
                </div>';
              
                 $recipe_catt=$this->FunctionModel->Select('vidiem_recipe_category',array('parent_id'=>$recipe['id'],'status'=>1));
                 if(!empty($recipe_catt)){
                 foreach($recipe_catt as $tmp1){ ?>

              <?php  echo  '<div class="incredeDetailRes">';?>
                    <?= $tmp1['increcontent'];  ?>
                <?php echo '</div>';?>
                 <?php }} ?>
                <?php echo'
            </div>'; ?>
            <?php 
                 $videos=$this->FunctionModel->Select('vidiem_recipe_category',array('parent_id'=>$recipe['id'],'status'=>1));
            if(!empty($videos)){
                 foreach($videos as $tmp){ ?>
                    <?php echo'
            <div class="procedureRecipe">
                <h2>'.$tmp['title'].':</h2>
                <ol class="conRecipeSetOf">'.$tmp['content']
                   
                .'</ol>
            </div>';?>
         <?php }} 
         echo '
                </div>'; 
                    exit;
            }
            
    public function order_success_page($id=null){
        $data['menu_id']=0;
        if(empty($id)){
            redirect('');
         }
        /* $data['code']=$this->FunctionModel->Select_Field('inv_code','vidiem_order',['id'=>$id]);
         if(empty($data['code'])){
            redirect('');
         } */
		 
		 $data['orderdetails']=$this->FunctionModel->Select_Row('vidiem_order',array('id'=>$id));
		 
		 $data['orderproduct']=$this->FunctionModel->Select_Fields('name,slug,image,price,qty,amount','vidiem_order_products',array('order_id'=>$id));
         //$this->load->view('order-success-page',$data);
		 $this->load->view('order-confirmation',$data);
    }    
        
     public function track_order(){  
        $data['menu_id']=0;
        $this->form_validation->set_rules('code','Invoice Code.','required');
        $this->form_validation->set_rules('email','email','required|callback_mail_check');
         if($this->form_validation->run()==TRUE){
            $code=$this->input->post('code');
            $email=$this->input->post('email');
           // echo $code;
          // echo $email;exit;
            $info=$this->ProjectModel->ClientTrackOrder($code,$email);
           // echo $status;exit;
           if($info['status']==2){
            $this->session->set_flashdata('title', "Error..");   
            $this->session->set_flashdata('msg', "Invalid Order Code.");    
            $this->session->set_flashdata('type', "warning");
            redirect('track-order','refresh');
         }
          if($info['order_status']==1 || $info['order_status']==5){
            $this->session->set_flashdata('title', "Information");   
            $this->session->set_flashdata('msg', "Order Processing..");    
            $this->session->set_flashdata('type', "success");
            redirect('track-order','refresh');
         }
          if($info['order_status']==4){
            $this->session->set_flashdata('title', "Information");   
            $this->session->set_flashdata('msg', "Order Cancelled");    
            $this->session->set_flashdata('type', "warning");
            redirect('track-order','refresh');
         }
       
        $track_url=$this->FunctionModel->Select_Field('url','vidiem_delivery_partners',['id'=>$info['courier']]);
        $oldString=array('{track_id}');
        $newString=array($info['tracking_code']);
        $track_url = str_replace($oldString, $newString,$track_url);
           $data['track_url']=$track_url;
          $data['tracked']=1;
          $data['order']=$info;
            $this->load->view('track-order',@$data);
        }else{
            $this->load->view('track-order',@$data);
        }
    }
    
    public function mail_check(){
        $email=$this->input->post('email');
     //   $password=$this->input->post('password');
        if(empty($email)){
            $this->form_validation->set_message('mail_check','Email field required');
            return false;
        }
        $count=$this->ProjectModel->ClientMailCheck($email);
        if($count==1){ return true;}
        else{ $this->form_validation->set_message('mail_check','Invalid Email Id'); 
            return false;
        }
    }
    
    public function satha(){
        //   phpinfo();exit;
        // $result=$this->FunctionModel->sendmail('saravanan.p@mayaappliances.com', 'test mail from vidiem website', 'welcome', 'satham@webspa.in');
        $result=$this->ProjectModel->OrderInvoicing(3);
        echo '<pre>'; print_r($result); echo '</pre>';
    }
    
    
	
    public function AjaxReview(){
        $id=$this->input->post('id');
        if(empty($id)){ redirect(); }
        $InsertData=array(
            'parent_id'=> $this->input->post('id'),
            'name'     => $this->input->post('name'),
            'rating'   => $this->input->post('rating'),
            'content'  => $this->input->post('comment'),
            'status'   => 2,
            'created'  => date('Y-m-d H:i:s')
        );
        $result=$this->FunctionModel->Insert($InsertData,'vidiem_products_reviews');
        $this->db->last_query(); exit;
        echo $result; exit;
   }
   
   //  Order Cacelation
public function AjaxOrderCancel(){
    $id=$this->input->post('id');
    $client_id=$this->session->userdata('client_id');
    $UpdateData=[
        'cancel_request'=>1,
        'cancel_reason'=>$this->input->post('reason'),
        'cancel_request_data'=>date('Y-m-d H:i:s')
    ];
    $result=$this->FunctionModel->Update($UpdateData,'vidiem_order',['id'=>$id,'client_id'=>$client_id]);
    if($result==1){
        $from_mail='care@vidiem.in';
        $subject='Order Cancel Request';
        	$msg='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
        	  <table>
        		<tr>
        			<td colspan="2" class="tc"><u>Hi,</u></td></br>
        		</tr>
        		<tr>
        			<td>You have one new request for order cancellation. Check on admin panel.</td>
        			
        		</tr></br></br>
        		<tr>
        			<td>Warm Regards, </td>
        		
        		</tr>
        		<tr>
        			<td>Vidiem Customer Care</td>
        		
        		</tr>
        		<tr>
        			<td>care@vidiem.in</td>
        		
        		</tr>
        		<tr>
        			<td>044-6635 6635 / 77110 06635</td>
        		
        		</tr></br>
        			
        	</table>';
        $this->FunctionModel->sendmail1('care@vidiem.in',$msg,$subject,'care@vidiem.in');
        $this->FunctionModel->sendmail1('online@mayaappliances.com',$msg,$subject,'care@vidiem.in');
    }
    echo json_encode(['state'=>1]); exit;
}

    public function testnew(){
        print_r($_SESSION);
        echo  $inv_code=$this->ProjectModel->InvoiceCode_test();
        print_r($this->db->last_query());
           // die();
        die();
      
        
    }
	
	public	function newtempregister(){
	
  //$this->ion_auth->register($username, $password, $email, $additional_data, $group)
    $this->FunctionModel->register('robert', '123456', 'robert@robert.com', array( 'first_name' => 'Robert', 'last_name' => 'Roberts' ), array('1') );
	}
	
	// 08-02-2021
	
	public function AjaxAddShippingAddress(){
		$same_billing = $_REQUEST['same_billing']; 
		//print_r($_REQUEST); exit;
        $data['menu_id']=0;
        
		$client_id=$this->session->userdata('client_id');
		if($client_id!='' && isset($client_id)){
			$clientid = $client_id;
		}else{
			$clientid = $this->session->session_id;
		}
		if($same_billing!=''){
			$same_billing = explode(',',$_REQUEST['same_billing']);
		}else{
			$same_billing = array($this->input->post('type'));
		}
		
		foreach($same_billing as $typeval){
			$InsertData=array(
				'client_id'      => $clientid,
				'name'           => $this->input->post('name'),
				'type'           => $typeval,
				'company_name'   => $this->input->post('company'),
				'address'        => $this->input->post('address'),
				'address2'       => $this->input->post('address2'),
				'city'           => $this->input->post('city'),
				'zip_code'       => $this->input->post('zip_code'),
				'state'          => $this->input->post('state'),
				'country'        => $this->input->post('country'),
				'mobile_no'      => $this->input->post('mobile_no'),
				'emailid'      => $this->input->post('emailid'),
				'add_information'=> $this->input->post('add_information'),
				'created'        => date('Y-m-d H:i:s')
			);
			
			
			$tmp_id=$this->FunctionModel->Insert($InsertData,'vidiem_clients_address');
			 $shipping_assressid=$tmp_id;
			
		}
		
	   $addressid=$tmp_id;
	   $addresshtml='';
	   if(!empty($client_id)){
		   $type = $this->input->post('type');
            $shipping_address=$this->FunctionModel->Select_Fields('id,type,title,name,address,city,zip_code,state,country,mobile_no','vidiem_clients_address',array('client_id'=>$client_id,'type'=>$type)); 
			
			if($type=='1'){
				$triggerfun = 'triggershippingaddress_edit';
			}else{
				 $triggerfun  = 'triggerbillingaddress_edit';
			}
			
			$addresshtml .='<div id="address_list_'.$type.'">';
				if(!empty($shipping_address)){
					$cnt=1;
					foreach ($shipping_address as $displayaddress) { 
					
						$addresshtml .='<div class="row">
						  <div class="col-4">
							
							  <p><input class="dot" type="radio" id="slctadd_'.$cnt.'" name="shippingaddressid" value="'.$displayaddress['id'].'"> '.$displayaddress['name'].'</p>
							  <p>'.$displayaddress['mobile_no'].'<p> 
						
						  </div>
						  <div class="col-6">
							<p>'.$displayaddress['address'].'<p> 
						  </div>
						  <div class="col-2"> <a href="javascript:void(0);" class="cust_link edit btn btn-primary btn-sm" title="Edit" data-toggle="tooltip" onClick="javascript:'.$triggerfun.'('.$displayaddress['id'].');"><span  data-target=".addnew-address" aria-expanded="false" aria-controls="addnew-address"><i class="lni lni-pencil-alt"></i><span> </a>  </div>
						</div>';
					$cnt++; } }
			  $addresshtml .='</div>';
            
        }
	   

	   echo json_encode(array("addresshtml"=>$addresshtml,"type"=>$type,));
	   exit;
    }
	
	
    public function shippingaddress_edit(){
		$id = $_REQUEST['id'];
		//echo $id; exit;
        $data['menu_id']=0;
        $client_id=$this->session->userdata('client_id');
        if(empty($id)){ redirect('user/address');}

        $Edit_Info=$this->FunctionModel->Select_Row('vidiem_clients_address',array('id'=>$id));
		
		$cmycls='';
		if($Edit_Info['company_name']!=''){ 
			$cmycls='class="active"';
		}
		
		$add2cls='';
		if($Edit_Info['address2']!=''){ 
			$add2cls='class="active"';
		}
		
		$addtioninfocls='';
		if($Edit_Info['add_information']!=''){ 
			$addtioninfocls='class="active"';
		}
		
		//print_r($Edit_Info); exit;
		
	// Single Edit Form

	$addressformhtml='<h4 class="text-dark mb-3 shippingaddressdivupdate" id="shippingaddress-update">Shipping Address Update</h4>
					<div class="bg-white shadow1 mb-5 p-4 shippingaddressdivupdate">';
					$states=$this->ProjectModel->states();
					$addressformhtml .='<form method="POST" action="" id="shippingaddressFormupdate">
					    <input type="hidden" value="1" name="type">
						<input type="hidden" name="id" value="'.$Edit_Info['id'].'" >
						
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="name_ship" name="name" class="form-control jsrequired" value="'.$Edit_Info['name'].'">
								  <label for="name_ship" class="active">Name</label>
								 
								</div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="company_ship" name="company" class="form-control" value="'.$Edit_Info['company_name'].'">
								  <label for="company_ship" '.$cmycls.' >company</label>
								 
								</div>
							</div>
							<div class="col-sm-12 col-md-12">
								<div class="md-form">
								  <input type="text" id="address_ship" class="form-control jsrequired" name="address" value="'.$Edit_Info['address'].'">
								  <label for="address_ship" class="active">Address Line 1</label>
								 
								</div>
							</div>
							<div class="col-sm-12 col-md-12">
								<div class="md-form">
								  <input type="text" id="address2_ship" class="form-control" name="address2" value="'.$Edit_Info['address2'].'">
								  <label for="address2_ship" '.$add2cls.'>Address Line 2</label>
								</div>
							</div>
							
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="zip_code_ship" class="form-control jsrequired" name="zip_code" value="'.$Edit_Info['zip_code'].'">
								  <label for="zip_code_ship" class="active">Zip/Postal Code</label>
								  
								</div>
							</div>
							
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="city_ship" class="form-control jsrequired" name="city" value="'.$Edit_Info['city'].'">
								  <label for="city_ship" class="active">City</label>
								 
								</div>
							</div>
							
							<div class="col-sm-12 col-md-6 pt-4 mb-2">
								  <select id="country_ship" name="country" class="js-states form-control">
									<option>India</option>
								  </select>
							</div>
							<div class="col-sm-12 col-md-6 pt-4 mb-2">
								  <select id="state_ship" name="state" class="js-states form-control jsrequired">
								  
									<option>Select State</option>';
								if(!empty($states)){
								
									foreach ($states as $info) {
									  $selected='';
									  if($info== $Edit_Info['state']){
										$selected="selected='selected'";
										}									  
									  
										$addressformhtml .='<option value="'.$info.'" '.$selected.'>'.$info.'</option>';

									} } 
									
								 $addressformhtml .=' </select>
							</div>
							
							<div class="col-sm-12 col-md-12">
								<div class="md-form">
								  <input type="text" id="add_information_ship" class="form-control " name="add_information" value="'.$Edit_Info['add_information'].'">
								  <label for="add_information_ship" '.$addtioninfocls.'>Additional Information</label>
								</div>
							</div>
							
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="mobile_no_ship"  minlength="10"     maxlength="10"  class="form-control jsrequired" name="mobile_no" value="'.$Edit_Info['mobile_no'].'">
								  <label for="mobile_no_ship" class="active">Mobile Number</label>
								 
								</div>
							</div>
							
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="emailid" class="form-control jsrequired" name="emailid" value="'.$Edit_Info['emailid'].'">
								  <label for="emailid" class="active">Email Id</label>
								 
								</div>
							</div>
							
							<div class="col-sm-12 col-md-12 col-lg-12 text-right">
								<button type="button" class="red-btn small" onClick="javascript:saveaddress(\'shippingaddressFormupdate\',\''.base_url('home/shippingaddress_update').'\',\'Shipping Address Updated\');"><i class="lni lni-save"></i> &nbsp; Update</button>
							</div>

						</div>
						</form>
					</div>';
		
        echo json_encode(array("addressformhtml"=>$addressformhtml));
		exit;
    }

    function shippingaddress_update(){

		$id = $this->input->post('id');
		//echo $id; exit;
        $data['menu_id']=0;
        $client_id=$this->session->userdata('client_id');
        if(empty($id)){ redirect('user/address');}
        $count=$this->FunctionModel->Row_Count('vidiem_clients_address',array('id'=>$id,'client_id'=>$client_id));
        if($count==0){ redirect('user/address');}
        
        //if($this->form_validation->run()===true){
            $UpdateData=array(
                'client_id'      => $this->session->userdata('client_id'),
                'name'           => $this->input->post('name'),
                'type'           => $this->input->post('type'),
                'company_name'   => $this->input->post('company'),
                'address'        => $this->input->post('address'),
                'address2'       => $this->input->post('address2'),
                'city'           => $this->input->post('city'),
                'zip_code'       => $this->input->post('zip_code'),
                'state'          => $this->input->post('state'),
                'country'        => $this->input->post('country'),
                'mobile_no'      => $this->input->post('mobile_no'),
				'emailid'      => $this->input->post('emailid'),
                'add_information'=> $this->input->post('add_information'),
                'modified'        => date('Y-m-d H:i:s')
            );
            $this->FunctionModel->Update($UpdateData,'vidiem_clients_address',array('id'=>$id));
           
        //}
        $Edit_Info=$this->FunctionModel->Select_Row('vidiem_clients_address',array('id'=>$id));
		
		//print_r($Edit_Info); exit;

	   // Dispaly Address	
	   $addresshtml='';
	   if(!empty($client_id)){
		   
            $shipping_address=$this->FunctionModel->Select_Fields('id,type,title,name,address,city,zip_code,state,country,mobile_no','vidiem_clients_address',array('client_id'=>$client_id,'type'=>1)); 
			
			
			$addresshtml .='<div id="address_list_1">';
				if(!empty($shipping_address)){
					$cnt=1;
					foreach ($shipping_address as $displayaddress) { 
					
				$addresshtml .='<div class="row">
				  <div class="col-4">
					
					  <p><input class="dot" type="radio" id="slctadd_'.$cnt.'" name="shippingaddressid" value="'.$displayaddress['id'].'"> '.$displayaddress['name'].'</p>
					  <p>'.$displayaddress['mobile_no'].'<p> 
				
				  </div>
				  <div class="col-6">
					<p>'.$displayaddress['address'].'<p> 
				  </div>
				  <div class="col-2"> <a href="javascript:void(0);" class="cust_link edit btn btn-primary btn-sm" title="Edit" data-toggle="tooltip" onClick="javascript:triggershippingaddress_edit('.$displayaddress['id'].');"><span  data-target=".addnew-address" aria-expanded="false" aria-controls="addnew-address"><i class="lni lni-pencil-alt"></i><span> </a>  </div>
				</div>';					

					$cnt++; } }
			  $addresshtml .='</div>';
            
        }
		
		
        echo json_encode(array("addresshtml"=>$addresshtml,"type"=>"1"));
		exit;


	}	
	
	
	// Billing Address Update Section
	
	
	public function billingaddress_edit(){
		$id = $_REQUEST['id'];
		//echo $id; exit;
        $data['menu_id']=0;
        $client_id=$this->session->userdata('client_id');
        if(empty($id)){ redirect('user/address');}

        $Edit_Info=$this->FunctionModel->Select_Row('vidiem_clients_address',array('id'=>$id));
		
		//print_r($Edit_Info); exit;
		
		$cmycls='';
		if($Edit_Info['company_name']!=''){ 
			$cmycls='class="active"';
		}
		
		$add2cls='';
		if($Edit_Info['address2']!=''){ 
			$add2cls='class="active"';
		}
		
		$addtioninfocls='';
		if($Edit_Info['add_information']!=''){ 
			$addtioninfocls='class="active"';
		}
		
	// Single Edit Form

	$addressformhtml='<h4 class="text-dark mb-3 billingaddressdivupdate displaybillingaddressdiv" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">Billing Address Update</h4>
					<div class="bg-white mb-5 p-4 billingaddressdivupdate displaybillingaddressdiv" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000">';
					$states=$this->ProjectModel->states();
					$addressformhtml .='<form method="POST" action="" id="billingaddressFormupdate">
					    <input type="hidden" value="2" name="type">
						<input type="hidden" name="id" value="'.$Edit_Info['id'].'" >
						
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="name_ship" name="name" class="form-control jsrequired" value="'.$Edit_Info['name'].'">
								  <label for="name_ship" class="active" >Name</label>
								 
								</div>
							</div>
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="company_ship" name="company" class="form-control" value="'.$Edit_Info['company_name'].'">
								  <label for="company_ship" '.$cmycls.'>company</label>
								 
								</div>
							</div>
							<div class="col-sm-12 col-md-12">
								<div class="md-form">
								  <input type="text" id="address_ship" class="form-control jsrequired" name="address" value="'.$Edit_Info['address'].'">
								  <label for="address_ship" class="active" >Address Line 1</label>
								 
								</div>
							</div>
							<div class="col-sm-12 col-md-12">
								<div class="md-form">
								  <input type="text" id="address2_ship" class="form-control" name="address2" value="'.$Edit_Info['address2'].'">
								  <label for="address2_ship" '.$address2.'>Address Line 2</label>
								</div>
							</div>
							
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="zip_code_ship" class="form-control jsrequired" name="zip_code" value="'.$Edit_Info['zip_code'].'">
								  <label for="zip_code_ship" class="active" >Zip/Postal Code</label>
								  
								</div>
							</div>
							
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="city_ship" class="form-control jsrequired" name="city" value="'.$Edit_Info['city'].'">
								  <label for="city_ship" class="active">City</label>
								 
								</div>
							</div>
							
							<div class="col-sm-12 col-md-6 pt-4 mb-2">
								  <select id="country_ship" name="country" class="js-states form-control">
									<option>India</option>
								  </select>
							</div>
							<div class="col-sm-12 col-md-6 pt-4 mb-2">
								  <select id="state_ship" name="state" class="js-states form-control jsrequired">
								  
									<option>Select State</option>';
								if(!empty($states)){
								
									foreach ($states as $info) {
									  $selected='';
									  if($info== $Edit_Info['state']){
										$selected="selected='selected'";
										}									  
									  
										$addressformhtml .='<option value="'.$info.'" '.$selected.'>'.$info.'</option>';

									} } 
									
								 $addressformhtml .=' </select>
							</div>
							
							<div class="col-sm-12 col-md-12">
								<div class="md-form">
								  <input type="text" id="add_information_ship" class="form-control " name="add_information" value="'.$Edit_Info['add_information'].'">
								  <label for="add_information_ship" '.$addtioninfocls.'>Additional Information</label>
								</div>
							</div>
							
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="mobile_no_ship"  minlength="10"     maxlength="10"  class="form-control jsrequired" name="mobile_no" value="'.$Edit_Info['mobile_no'].'">
								  <label for="mobile_no_ship" class="active" >Mobile Number</label>
								 
								</div>
							</div>
							
							<div class="col-sm-12 col-md-6">
								<div class="md-form">
								  <input type="text" id="emailid" class="form-control jsrequired" name="emailid" value="'.$Edit_Info['emailid'].'">
								  <label for="emailid" class="active" >Email Id</label>
								 
								</div>
							</div>
							
							<div class="col-sm-12 col-md-12 col-lg-12 text-right">
								<button type="button" class="red-btn small" onClick="javascript:saveaddress(\'billingaddressFormupdate\',\''.base_url('home/billingaddress_update').'\',\'Billing Address Updated\');"><i class="lni lni-save"></i> &nbsp; Update</button>
							</div>

						</div>
						</form>
					</div>';
		
        echo json_encode(array("addressformhtml"=>$addressformhtml));
		exit;
    }
	
    function billingaddress_update(){

		$id = $this->input->post('id');
		//echo $id; exit;
        $data['menu_id']=0;
        $client_id=$this->session->userdata('client_id');
        if(empty($id)){ redirect('user/address');}
        $count=$this->FunctionModel->Row_Count('vidiem_clients_address',array('id'=>$id,'client_id'=>$client_id));
        if($count==0){ redirect('user/address');}
        
        //if($this->form_validation->run()===true){
            $UpdateData=array(
                'client_id'      => $this->session->userdata('client_id'),
                'name'           => $this->input->post('name'),
                'type'           => $this->input->post('type'),
                'company_name'   => $this->input->post('company'),
                'address'        => $this->input->post('address'),
                'address2'       => $this->input->post('address2'),
                'city'           => $this->input->post('city'),
                'zip_code'       => $this->input->post('zip_code'),
                'state'          => $this->input->post('state'),
                'country'        => $this->input->post('country'),
                'mobile_no'      => $this->input->post('mobile_no'),
                'add_information'=> $this->input->post('add_information'),
                'modified'        => date('Y-m-d H:i:s')
            );
            $this->FunctionModel->Update($UpdateData,'vidiem_clients_address',array('id'=>$id));
           
        //}
        $Edit_Info=$this->FunctionModel->Select_Row('vidiem_clients_address',array('id'=>$id));
		
		//print_r($Edit_Info); exit;

	   // Dispaly Address	
	   $addresshtml='';
	   if(!empty($client_id)){
            $billing_address=$this->FunctionModel->Select_Fields('id,type,title,name,address,city,zip_code,state,country,mobile_no','vidiem_clients_address',array('client_id'=>$client_id,'type'=>2)); 
			
			
			$addresshtml .='<div id="address_list_2">';
				if(!empty($billing_address)){
					$cnt=1;
					foreach ($billing_address as $displayaddress) { 
				$addresshtml .='<div class="row">
				  <div class="col-4">
					
					  <p><input class="dot" type="radio" id="slctadd_'.$cnt.'" name="shippingaddressid" value="'.$displayaddress['id'].'"> '.$displayaddress['name'].'</p>
					  <p>'.$displayaddress['mobile_no'].'<p> 
				
				  </div>
				  <div class="col-6">
					<p>'.$displayaddress['address'].'<p> 
				  </div>
				  <div class="col-2"> <a href="javascript:void(0);" class="cust_link edit btn btn-primary btn-sm" title="Edit" data-toggle="tooltip" onClick="javascript:triggerbillingaddress_edit('.$displayaddress['id'].');"><span  data-target=".addnew-address" aria-expanded="false" aria-controls="addnew-address"><i class="lni lni-pencil-alt"></i><span> </a>  </div>
				</div>';
					$cnt++; } }
			  $addresshtml .='</div>';
            
        }
		
		
        echo json_encode(array("addresshtml"=>$addresshtml,"type"=>"2"));
		exit;


	}

	  public function invoice($order_id){
         $order_data=$this->FunctionModel->Select_Row('vidiem_order',array('id'=>$order_id));
        $order_product=$this->FunctionModel->Select('vidiem_order_products',array('order_id'=>$order_id));
        $client=$this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
         $data['content']='
   <style>h1 {
    margin-top: -5px; margin-bottom:5px;
}</style>
   <div style="border:1px solid black; padding:5px; 10px;">
   <div class="container inCon">
        <div style="float:left; width:50%;"><h1 style="color:#00BFFF;"><img src="'.base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto"/></h1></div>
        <div style="width:30%;float:right;"><h1 style="color:#00BFFF;">Performa Invoice</h1></div>
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
        <div class="detail" style="float:left; width:35%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:14px;">Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road,
Oggiam Thoraipakkam,<br>Chennai - 600097, Tamilnadu, INDIA.</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Landline</span> : &nbsp; 044-6635 6635 / 77110 06635
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Website</span> : &nbsp; http://vidiem.in/
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">GST NO</span> : &nbsp;  33AAACM6280D1ZT
                </li>
            </ul>
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">BILL TO </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_name'].'
                </li>';
                if(!empty($order_data['billing_company_name'])){
                  $data['content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_company_name'].'</li>';
                }
                  $data['content'].='</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; '.@$order_data['billing_address'].' - '.@$order_data['billing_address2'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; '.@$order_data['billing_city'].'-'.$order_data['billing_zip'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; '.@$order_data['billing_state'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; '.@$order_data['billing_country'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; '.@$order_data['billing_mobile_no'].'
                </li>
            </ul>
        </div>
        <div class="logo" style="float:left; width:35%; "></div>
         <div class="contact" style="float:right; width:30%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">DATE</span> :&nbsp;
                &nbsp;'.date("d-M-Y", strtotime(@$order_data['created'])).'</li>
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">Invoice</span> :&nbsp;
                &nbsp;'.@$order_data['inv_code'].'</li>
            </ul>

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">SHIPPING ADDRESS </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_name'].'
                </li>';
                if(!empty($order_data['delivery_company_name'])){
                  $data['content'].='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_company_name'].'</li>';
                }
                  $data['content'].='</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; '.@$order_data['delivery_address'].' - '.@$order_data['delivery_address2'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; '.@$order_data['delivery_city'].'-'.$order_data['delivery_zip'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; '.@$order_data['delivery_state'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; '.@$order_data['delivery_country'].'
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; '.@$order_data['delivery_mobile_no'].'
                </li>
            </ul>';
         
          $data['content'].='</div>
        </div>        
        <div class="form" style="width:100%;">
            <table style="width:100%; padding:20px 0 40px 0;">
                <tr style="background:#3B4E87;; font-family:roboto; font-weight:normal">
                    <th style="color:#fff; padding:15px 0; font-size:14px;">SL</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Product</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Price</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Qty</th>
                    <th style="color:#fff;padding:15px 0;font-size:14px;">Amount</th>
                </tr>';
                
                if(!empty($order_product)){ $x=1;
                    foreach ($order_product as $info) {
                        $data['content'].='<tr style=""><td style="text-align:center;padding:15px 0;">'.$x.'</td>
                            <td style="padding:15px 20px;font-size:14px;">'.$info['name'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['price'],2,'.','').'</td>
                            <td style="padding:15px 0;text-align:right;">'.$info['qty'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['amount'],2,'.','').'</td>
                            </tr>';
                            $x++;
                    }
                }
                
                 $data['content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">SubTotal + GST 18% Included('.number_format($order_data['tax'],2,'.','').')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['sub_total'],2,'.','').'</b></th>
                </tr>';
                if($order_data['coupon_id']!=0){
                    $data['content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Coupon Discount ('.$order_data['coupon'].')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['discount'],2,'.','').'</b></th>
                </tr>';
                }
                  $data['content'].='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#3B4E87;;text-align:right;">&nbsp; '.number_format($order_data['amount'],2,'.','').'</th>
                </tr>';
               
                   $data['content'].='<tr><td></td><td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.</td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">If you have any questions about this invoice, please write us to below email id</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">care@vidiem.in</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
            </table>
        </div>
    </div>
    </div>';
    // echo $data['content']; exit;
   // $this->load->view('Backend/pdf-page',$data);
      $html=$this->load->view('Backend/pdf-page',$data,true);
        //this the the PDF filename that user will get to download
        $pdfFilePath ="invoice-".$inv_info['inv_code'].".pdf";
        //load mPDF library
         $this->load->library('m_pdf');
         $this->m_pdf->pdf->AddPage('P', // L - landscape, P - portrait
            '', '', '', '',
            7, // margin_left
            3, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5); // margin footer
       //generate the PDF from the given html
         $this->m_pdf->pdf->WriteHTML($html);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
    }	

	
}