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
        $this->load->model( 'DealersModel');
        $this->session->keep_flashdata('title');
        $this->session->keep_flashdata('msg');
        $this->session->keep_flashdata('type');
		$this->output->delete_cache();
		
		
		
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

    public function product($s=NULL, $slug=NULL){
        $data['menu_id']=3;
        if(empty($slug)){redirect();}
        $data['productseo']=$this->FunctionModel->Select('vidiem_products',array('slug'=>$slug));
        $product_id=$this->FunctionModel->Select_Field('id','vidiem_products',array('slug'=>$slug));
        if(empty($product_id)){redirect();}
		
		if($product_id==114) { 
			redirect('vidiem-adc');
		} else if($product_id==122)
		{
			redirect('vidiem-iris'); 
		}else if($product_id==137) 
		{
				redirect('vidiem-tusker'); 
		}
		
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
		if(isset($_REQUEST['subcatid'])!=''){
			$data['subcatid']=$_REQUEST['subcatid'];
			//$data['product_list']=$this->FunctionModel->Select_Fields('id,slug,name,image,price,old_price,outofstock,list_description','vidiem_products',array('sub_cat_id'=>$_REQUEST['subcatid'],'status'=>1),'price','desc');
			$this->db->select('p.id,p.slug,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description');
          $this->db->join('vidiem_category c','c.id=p.sub_cat_id and c.status=1 AND c.id='.$sub_cat_id.'','inner');
          $this->db->order_by("c.order_no", "asc");
		  $this->db->order_by("p.price", "desc");
		  //$this->db->limit(10,0);
          $query=$this->db->get_where('vidiem_products p',array('p.sub_cat_id'=>$data['subcatid'],'p.status'=>1, 'p.exclusive'=> 0)); 
		  $data['product_list']=$query->result_array();
			
		}else{
			//$data['product_list']=$this->FunctionModel->Select_Fields('id,slug,name,image,price,old_price,outofstock,list_description','vidiem_products',array('cat_id'=>$cat_id,'status'=>1),'order_no','ASC');
		$this->db->select('p.id,p.slug,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description');
          $this->db->join('vidiem_category c','c.id=p.sub_cat_id and c.status=1 AND c.parent_id='.$cat_id.'','inner');
          $this->db->order_by("c.order_no", "asc");
		  $this->db->order_by("p.price", "desc");
		  //$this->db->limit(10,0);
          $query=$this->db->get_where('vidiem_products p',array('p.cat_id'=>$cat_id,'p.status'=>1, 'p.exclusive'=> 0)); 
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
    // public function exclusiveProduct() {
    //     $data['menu_id']=3;
    //     $this->db->select('p.id,p.slug,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description');
    //     $this->db->join('vidiem_category c','c.id=p.sub_cat_id and c.status=1','inner');
    //     $this->db->order_by("c.order_no", "asc");
    //     $this->db->order_by("p.price", "desc");
    //     $query=$this->db->get_where('vidiem_products p',array('p.status'=>1, 'p.exclusive'=> 1)); 
    //     $data['product_list']=$query->result_array();
    //     $data['otherproduct_list']=$this->FunctionModel->Select_Fields('id,productlink,name,image,content','vidiem_otherproduct',array('status'=>1),'order_no','ASC');
    //     $has_child=$this->FunctionModel->Row_Count('vidiem_category',array('status'=>1));
    //     $data['has_child']=($has_child!=0?1:0);
    //     $data['filters']=$this->FunctionModel->Select_Fields('id,filter_id','vidiem_category_filters');
    //     $data['category_img']=$this->FunctionModel->Select_Fields('id,name,image,banner_url','vidiem_category_images',array('status'=>1,'parent_id'=>$data['cat']['id']),'order_no','ASC');
    //     $this->load->view('exclusive-product-listing',@$data);
    // }
    public function exclusiveProductAllData() {
        $data['menu_id']=3;
        $this->db->select('p.id,p.slug,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description');
        $this->db->join('vidiem_category c','c.id=p.sub_cat_id and c.status=1','inner');
        $this->db->order_by("c.order_no", "asc");
        $this->db->order_by("p.price", "desc");
        $query=$this->db->get_where('vidiem_products p',array('p.status'=>1, 'p.exclusive'=> 1)); 
        $data['product_list']=$query->result_array();
        $data['otherproduct_list']=$this->FunctionModel->Select_Fields('id,productlink,name,image,content','vidiem_otherproduct',array('status'=>1),'order_no','ASC');
        $has_child=$this->FunctionModel->Row_Count('vidiem_category',array('status'=>1));
        $data['has_child']=($has_child!=0?1:0);
        $data['filters']=$this->FunctionModel->Select_Fields('id,filter_id','vidiem_category_filters');
        $data['category_img']=$this->FunctionModel->Select_Fields('id,name,image,banner_url','vidiem_category_images',array('status'=>1,'parent_id'=>$data['cat']['id']),'order_no','ASC');
        $this->load->view('exclusive-product-listing',@$data);
    }
    
    public function exclusiveProduct($slug=NULL) {
        $data['menu_id']=3;
        if(empty($slug)){redirect();}
        $data['categoryseo']=$this->FunctionModel->Select('vidiem_category',array('slug'=>$slug));
        $cat_id=$this->FunctionModel->Select_Field('id','vidiem_category',array('slug'=>$slug));
        if(empty($cat_id)){redirect();}
        $data['cat_id']=$cat_id;
        $data['cat']=$this->FunctionModel->Select_Row('vidiem_category',array('id'=>$cat_id));
        $data['filter_sub_cat']=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('parent_id'=>$cat_id,'status'=>1),'order_no','ASC');
        $data['sub_cat']=$this->FunctionModel->Select_Fields('id,name,image,slug','vidiem_category',array('parent_id'=>$cat_id,'status'=>1),'order_no','ASC');
        
        $this->db->select('p.id,p.slug,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description');
        $this->db->join('vidiem_category c','c.id=p.sub_cat_id and c.status=1 AND c.parent_id='.$cat_id.'','inner');
        $this->db->order_by("c.order_no", "asc");
        $this->db->order_by("p.price", "desc");
        //$this->db->limit(10,0);
        $query=$this->db->get_where('vidiem_products p',array('p.cat_id'=>$cat_id,'p.status'=>1, 'p.exclusive'=> 1)); 
        $data['product_list']=$query->result_array();
		
		$data['otherproduct_list']=$this->FunctionModel->Select_Fields('id,productlink,name,image,content','vidiem_otherproduct',array('status'=>1),'order_no','ASC');
        $has_child=$this->FunctionModel->Row_Count('vidiem_category',array('parent_id'=>$cat_id,'status'=>1));
        $data['has_child']=($has_child!=0?1:0);
        $data['cat_slug']=$slug;
        $data['filters']=$this->FunctionModel->Select_Fields('id,filter_id','vidiem_category_filters',array('parent_id'=>$cat_id));
        $data['category_img']=$this->FunctionModel->Select_Fields('id,name,image,banner_url','vidiem_category_images',array('status'=>1,'parent_id'=>$data['cat']['id']),'order_no','ASC');
        $this->load->view('exclusive-product-listing',@$data);
        // $this->load->view('product-listing',@$data);
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
         
        $data['menu_id']        = 0;
		$client_id              = $this->session->userdata('client_id');
		$data['client_id']      = $client_id;
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

     public function checkout() {

        $contents                       = $this->cart->contents();
		$this->session->set_userdata('previous_url', 'checkout');
		$gst_no                         = $this->input->post('gst_no');
        if(empty($contents)){
            $this->session->set_flashdata('title', "Error..");  
            $this->session->set_flashdata('msg', "Cart Empty");  
            $this->session->set_flashdata('type', "warning");
            redirect('','refresh');
        }
        $client_id                      = $this->session->userdata('client_id');
		
		$data['client_id']              = $client_id;
        if(empty($this->input->post('from_cart'))){
            $coupon                     = $this->session->userdata('coupon');
        }else{
            $coupon                     = $this->input->post('coupon');
        }
        if(!empty($coupon) && !empty($client_id)) {
            $data['discount']           = $this->ProjectModel->coupon_discount($coupon);
            $data['discount']['code']   = $coupon;
        } 
        $data['menu_id']                = 0;
        if(!empty( $client_id ) ) {
            $data['shipping_address']   = $this->FunctionModel->Select_Fields('id,type,title,name,address,city,zip_code,state,country,mobile_no','vidiem_clients_address',array('client_id'=>$client_id,'type'=>1)); 
            $data['billing_address']    = $this->FunctionModel->Select_Fields('id,type,title,name,address,city,zip_code,state,country,mobile_no','vidiem_clients_address',array('client_id'=>$client_id,'type'=>2)); 
        }
        $data['ship_id']=$this->input->get('shipping_id');
        $data['bill_id']=$this->input->get('billing_id');
        $data['same']=$this->input->get('same');
        if(!empty($data['same'])){$data['same']=0;}
         $data['loginURL'] = $this->google->loginURL();
        $data['FbloginUrl'] = $this->facebook->loginUrl();
        $this->session->set_userdata('gst_no', $gst_no);
        $this->load->view('account-shipping',@$data);
     }
	 

     public function payment(){
		
		
		
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
		
		extract($_REQUEST);
		
		
        
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
                'tax'                   => $total-(($total/(TAXNEW+100))*100), // TAX variable define from confiq
                'discount'              => $discount['amount'],
                'amount'                => round($amount),
                'status'                => 1,
                'created'               => date('Y-m-d H:i:s'),
                'gst_no'                => $this->session->userdata('gst_no')
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
			
			$contact_add= $billing_info['address'].','.$billing_info['address2'].','.$billing_info['city'].','. $billing_info['state'].','. $billing_info['country'].'-'.$billing_info['zip_code'];
                
			
			$orderData = [
			'receipt'         => $order_id,
			'amount'          =>  round($amount) * 100, // 2000 rupees in paise
			'currency'        => "INR",
			'payment_capture' => 1 // auto capture
		];
			
         $razorOrder =$this->razorpay->CreateOrder($orderData);
		 
		 $razorpayOrderId = $razorOrder['id'];
		 
		 $this->session->set_userdata('razorpay_order_id', $razorpayOrderId);
		 $this->session->unset_userdata('gst_no');
		 	$ci = &get_instance();
		$configs = $ci->config;
	
		 $keyId=$configs->config['keyid'];
		 
		 
		$data = [
			"key"               => $keyId,
			"amount"            => round($amount)* 100,
			"name"              => "Vidiem Stores",
			"description"       => "Gas Stoves, Table Top Wet Grinder,Juicer Mixer Grinders",
			"image"             =>  "https://www.vidiem.in/assets/front-end/images/logo.png",
			"prefill"           => [
			"name"              => $firstname,
			"email"             => $email,
			"contact"           => $mobile,
			],
			"notes"             => [
			"address"           => $contact_add,
			"merchant_order_id" =>$order_id,
			],
			"theme"             => [
			"color"             => "#F37254"
			],
			"order_id"          => $razorpayOrderId,
		];

	
	
		echo $json = json_encode($data);
		
		 ?>

		 
		<?php	

		
		 //$this->load->view('payment-razorpay');
		
	// print_r($data);
	// die();
           /* $PaymentData=array(
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
            $data['pay']=$this->payumoney->paymentGeneration($PaymentData); */
           // $this->load->view('payment-payumoney',@$data);
        }
        else{
            redirect('checkout');
        }
        
        }
        else{
			
			print_r($_POST);
		echo "errror final";
		die();
			
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
         
            /**
             * update order history table
             */
            $tracking               = $this->FunctionModel->Select_Field('id','vidiem_order_tracking',array('order_id'=>$order_id, 'order_type' => 'order') );

            if( empty( $tracking ) ) {

                $ins_trac['order_id']       = $order_id;
                $ins_trac['order_type']     = 'order';
                $ins_trac['order_status']   = 1;
                $ins_trac['status_name']    = 'New Order';
                $ins_trac['created_at']     = date('Y-m-d H:i:s');
                $ins_trac['notes']          = 'Order has been created';
                $this->FunctionModel->Insert($ins_trac,' vidiem_order_tracking');

            }

            $this->ProjectModel->NewOrderNotification($order_id);
            $this->cart->destroy();
            $this->session->set_flashdata('title', "Thank You");     
            $this->session->set_flashdata('msg', "Payment is successful and You will receive email from our side further instructions.");     
            $this->session->set_flashdata('type', "success");
            $this->ProjectModel->OrderInvoicing($order_id); 
             redirect('order-success/'.$order_id,'refresh');
        }
   }    
   
   
     public function razorpay_success(){
		 
		 $success = true;

		$error = "Payment Failed";
		
		
		
if (empty($_POST['razorpay_payment_id']) === false)
{
	 $razorpay_order_id=$this->session->userdata('razorpay_order_id');
	$finalorder =$this->razorpay->FetchOrder($razorpay_order_id);
		//print_r($finalorder);
   
    try
    {      
        $attributes = array(
            'razorpay_order_id' => $razorpay_order_id,
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

   
        $this->razorpay->verifyPaymentSignature($attributes);
	}
		catch(SignatureVerificationError $e)
		{
			  $success = false;
			  redirect('home/payumoney_failure','refresh');
		}
	}
	else{
		 
		 if(isset($_POST['error']))
		 {
			$orderdata= json_decode($_POST['error']['metadata'],true);
			$_POST['razorpay_payment_id']=$orderdata['payment_id'];
			//($razorpay_order_id);

		   $finalorder=$this->razorpay->FetchOrder( $orderdata['order_id']);
			
		 }
		
	}
		
	   $finalorder=(array)$finalorder;
	   
	
	   
	   $tempdatarr=array();
	   foreach($finalorder as $key=>$orderdata)
	   {
		   $tempdatarr=$orderdata;
	   }
	   
	 
   
			$dataarr=array();
			foreach($tempdatarr as $key=>$val) 
			{
				switch($key)
				{
					case "receipt":
									$dataarr['order_id'] = $val;
									break;
					case "status":
									if($val=="paid")
									{
										$status="paid";
									}
									else{
										$status=="Failure";
									}
									break;
					case "id":
								$dataarr['tracking_id']= $val;
								break;
				case "payment_mode":
							$dataarr['payment_mode'] ='';
				
					
					
				} 
			} 
			$dataarr['bank_ref_no']=$_POST['razorpay_payment_id'];
			$dataarr['data']=$_POST['razorpay_signature'];
			
			
		
			
		   $this->session->set_userdata('razorpay_order_id', "");	
		
        if( strtolower($status) == 'paid'){
            // Invoice Code Update
            $order_id=$dataarr['order_id'];
            
            $code=$this->FunctionModel->Select_Field('inv_code','vidiem_order',array('id'=>$order_id),'inv_code','DESC',1);
            
            
            if(empty($code)){
                $inv_code       = $this->ProjectModel->InvoiceCode();
                $UpdateData     = array(
                                    'inv_code'      => $inv_code,
                                    'mihpayid'      => $dataarr['data'],
                                    'payment_source'=> "Razorpay",
                                    'pg_type'       => $dataarr['tracking_id'],
                                    'bank_ref_num'  => $dataarr['bank_ref_no'],
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
			$mobile=$this->FunctionModel->Select_Field('billing_mobile_no','vidiem_order',array('id'=>$order_id),'billing_mobile_no','DESC',1);
			
			if($mobile!=''){
			  SMS($mobile,"Thank you for shopping with Vidiem. Your order number ".$inv_code." is under process. We'll share the tracking details once the shipment is ready. -VIDIEM",'1107164362643761375'); 
			 }
			
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
        // print_r($this->input->post('enquire'));exit;
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
        //   print_r($this->input);exit;
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
       
        	// $subject='New Enquiry In Website';
        	$subject='New Enquiry In Website '.$this->input->post('enquire');
        	$msg='<style>table{background-color:#e6e6e6;}tr > td{padding:10px; font-size: 18px;} .tc{text-align:center;}</style>
        	  <table>
        		<tr>
        			<td colspan="2" class="tc" style="text-align:center;"><u>New Enquiry In Website -'. $this->input->post('enquire').'</u></td></br>
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
            // print_r( $msg);exit;
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

    public function sign_in() {
   
		if(!empty($this->session->userdata('client_id'))){
			redirect('user/dashboard');
		}		
		// ss( $this->session->userdata('previous_url') );
		
        $data['menu_id']=0;
        $this->form_validation->set_rules('user_name','Email.','required');
        $this->form_validation->set_rules('password','Password','required|callback_password_check');
         if($this->form_validation->run()==TRUE){
            // ss( $this->session->userdata('previous_url') );
            $user_name=$this->input->post('user_name');
            $password=md5($this->input->post('password'));
            $status=$this->ProjectModel->ClientLogin($user_name,$password);
            if($status==1){
                $this->session->set_flashdata('title', "Success");   
                $this->session->set_flashdata('msg', "Login Successfully.");     
                $this->session->set_flashdata('type', "success"); 
				
				$previous_url = $this->session->userdata('previous_url');
				
				$client_id=$this->session->userdata('client_id');

				 $updateDataexist=array(
						'IsActive'     => '2'
						);
			    $resultexist = $this->FunctionModel->Update($updateDataexist,'vidiem_carts',array('customer_id' => $client_id,
				 'IsActive'=>'1'
				 ));
				
                
				$updateData         = array(						
                                        'customer_id'     => $client_id,
                                        'sessionId'     => '0'
						            );
                $sessionid          = $this->session->session_id;		
                $result = $this->FunctionModel->Update($updateData,'vidiem_carts',array('sessionId' => $sessionid,
				    'IsActive'=>'1'
                ));
				
				$this->session->unset_userdata("previous_url");
               
				if($previous_url=='checkout' || $previous_url=='cart' || $previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
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

        $data['menu_id']    = 0;
        $client_id          = $this->session->userdata('client_id');
        if( !empty( $client_id ) ) {
            redirect();
        }
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[vidiem_clients.email]');
        $this->form_validation->set_rules('mobile_no','Mobile No.','required|is_unique[vidiem_clients.mobile_no]|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('password','Password','required|min_length[6]');
        $this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[password]');
        $this->form_validation->set_message('is_unique','%s Already Exist');

        if( $this->form_validation->run() == true ) {
            $otp_code       = rand(100000,999999);
            $InsertData     = array(
                                'name'       => $this->input->post('name'),
                                'email'      => $this->input->post('email'),
                                'mobile_no'  => str_replace(' ','',$this->input->post('mobile_no')),
                                'gender'        => $this->input->post('gender'),
                                'dob'           => $this->input->post('dob'),
                                'newsletter'    => $this->input->post('newsletter'),
                                'special_offer' => $this->input->post('special_offer'),
                                'sms_verified'  => 1,
                                'sms_code'   => $otp_code,
                                'password'   => md5($this->input->post('password')),
                                'status'     => 1,
                                'created'    =>date('Y-m-d H:i:s')
                            );
            $client_id      = $this->FunctionModel->Insert($InsertData,'vidiem_clients');
            // $sms_content="Your Otp is ".$otp_code.". Welcome to Vidiem Site.";
            // $this->ProjectModel->SMS($mobile_no,$sms_content);
            // Welcome Mail Start //
            $email          = $this->input->post('email');
            $name           = $this->input->post('name');
            $this->ProjectModel->WelcomeMail($email,$name);
            // Welcome Mail End //
            $this->session->set_flashdata('title', "Success");   
            $this->session->set_flashdata('msg', "Your account created Successfully.");    
            $this->session->set_flashdata('type', "success");

            // $previous_url = $this->session->userdata('previous_url');
            // if($previous_url=='checkout' || $previous_url=='cart' || $previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
            //     redirect($previous_url, 'refresh');
            // }
         
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
            //redirect('user/dashboard');
			
			$client_id=$this->session->userdata('client_id');	
			
			 $updateDataexist=array(
						'IsActive'     => '2'
						);
			$resultexist = $this->FunctionModel->Update($updateDataexist,'vidiem_carts',array('customer_id' => $client_id,
				 'IsActive'=>'1'
				 ));
			
				 $updateData=array(						
						'customer_id'     => $client_id,
						'sessionId'     => '0'
						);
					$sessionid = $this->session->session_id;		
				 $result = $this->FunctionModel->Update($updateData,'vidiem_carts',array('sessionId' => $sessionid,
				 'IsActive'=>'1'
				 ));
			
			$previous_url = $this->session->userdata('previous_url');
			$this->session->unset_userdata("previous_url");
				if($previous_url=='checkout' || $previous_url=='cart' || $previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
					redirect($previous_url, 'refresh');
				}else{
					redirect('user/dashboard', 'refresh');
				}
			
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
        //$data['category']=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('status'=>1,'parent_id'=>0));
        $data['category']=$this->FunctionModel->Select_Fields('id, category_name as name','vidiem_registration_categories',array('is_active'=>1));
        $data['productregistrationseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Product Registration'));
        
        $this->form_validation->set_rules('category','Category','required');
        $this->form_validation->set_rules('product','Product','required');
        $this->form_validation->set_rules('serialnumer','Serial number','required|is_unique[vidiem_product_registration.serialnumer]|regex_match[/^[Cc][HhZz][A-Za-z0-9]{13}$/]');
        $this->form_validation->set_rules('jdate','Date of purchase','required|validate_purchasedate[jdate]');
		$this->form_validation->set_rules('dealername','Dealer name','required|regex_match[/^[A-Za-z &]*$/]');
        $this->form_validation->set_rules('purchasefrom','Purchase Form','required');
        $this->form_validation->set_rules('gender','Gender','required');
        $this->form_validation->set_rules('name','Name','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('mobile','Mobile number','required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->set_rules('age','Age','required|regex_match[/^[0-9]{2}$/]');
        $this->form_validation->set_rules('address','Address','required');
        $this->form_validation->set_rules('city','City','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('state','State','required');
        //$this->form_validation->set_rules('pincode','Pincode','required|regex_match[/^[A-Za-z0-9]{6}$/]');
        
        $country = $this->input->post('state');
        $countryList = array("United Kingdom", "United State of America (USA)", "Canada", "Singapore", "Mauritius","Europe");

        if(!in_array($country, $countryList)){
            $this->form_validation->set_rules('pincode','Pincode','required|regex_match[/^[A-Za-z0-9]{6}$/]');
        }
        
        
        //$this->form_validation->set_rules('captcha','Captcha','required');
       // $this->form_validation->set_rules('g-recaptcha-response', 'recaptcha validation', 'required|callback_google_validate_captcha');
        if ($this->form_validation->run() === TRUE) {
                $email=$this->input->post('email');
                $this->db->like('year(created)',date('Y'));
               
           $code=$this->ProjectModel->RegistrationCode();
            $cat_id=$this->input->post('category');
            $pro_id=$this->input->post('product');
           // $cat_name=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$cat_id));
           // $pro_name=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$pro_id));
             $cat_name=$this->FunctionModel->Select_Field('category_name','vidiem_registration_categories',array('id'=>$cat_id));
             $pro_name=$this->FunctionModel->Select_Field('product_name','vidiem_registration_products',array('id'=>$pro_id));
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
                    <td>Product Name</td>
                    <td style="padding:10px 0;">'.$this->input->post('mobile').'</td>
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
                    <td style="padding:10px 0;">'. $pro_name.'</td>
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
		 if($this->input->post('mobile')!=''){
		  SMS($this->input->post('mobile'),'Your product is registered now! Reference Number '.$code.'. You get 3 months extended warranty from the date of purchase. VIDIEM for the joy of cooking','1107164362643761375'); 
		 }
		 
                redirect('product-registration', 'refresh');
                }
        }
        $data['city']=$this->ProjectModel->getCities();
        $cat_id=$this->input->post('category');
        if(!empty($cat_id)){
        //$data['products']=$this->FunctionModel->Select_Fields('id,name','vidiem_products',array('cat_id'=>$cat_id));
        $data['products']=$this->FunctionModel->Select_Fields('id, product_name as name','vidiem_registration_products',array('is_active'=>1,'category_id' => $cat_id));
        }
        $this->load->view('product-registration',@$data);
    }
    
     public function complaint_registration(){
        $data['menu_id']=4;
        //$data['category']=$this->FunctionModel->Select_Fields('id,name','vidiem_category',array('status'=>1,'parent_id'=>0));
        $data['category']=$this->FunctionModel->Select_Fields('id,category_name as name','vidiem_registration_categories',array('is_active'=>1));
        $data['productregistrationseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Product Complaint'));
        $this->form_validation->set_rules('category','Category','required');
        $this->form_validation->set_rules('product','Product','required');
        //$this->form_validation->set_rules('serialnumer','Serial number','required|is_unique[vidiem_complaint_registration.serialnumer]|regex_match[/^[Cc][Hh][A-Za-z0-9]{13}$/]');
		  $this->form_validation->set_rules('serialnumer','Serial number','required');
        $this->form_validation->set_rules('jdate','Date of purchase','required|validate_purchasedate[jdate]');
        $this->form_validation->set_rules('dealername','Dealer name','required|regex_match[/^[A-Za-z &]*$/]');
         $this->form_validation->set_rules('remarks','Complaint remarks','required|regex_match[/^[A-Za-z0-9 &,]*$/]');
        $this->form_validation->set_rules('name','Name','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('mobile','Mobile number','required|regex_match[/^[0-9]{10}$/]');
      //  $this->form_validation->set_rules('mobile2','Alternative Mobile Numer','required');
        $this->form_validation->set_rules('address','Address','required');
        $this->form_validation->set_rules('city','City','required|regex_match[/^[A-Za-z ]*$/]');
        $this->form_validation->set_rules('state','State','required|regex_match[/^[A-Za-z ]*$/]');
        //$this->form_validation->set_rules('pincode','Pincode','required|regex_match[/^[A-Za-z0-9]{6}$/]');
        
        $country = $this->input->post('state');
       $countryList = array("United Kingdom", "United State of America (USA)", "Canada", "Singapore", "Mauritius","Europe");

        if(!in_array($country, $countryList)){
            $this->form_validation->set_rules('pincode','Pincode','required|regex_match[/^[A-Za-z0-9]{6}$/]');
        }
        
        
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
            // $cat_name=$this->FunctionModel->Select_Field('name','vidiem_category',array('id'=>$cat_id));
            // $pro_name=$this->FunctionModel->Select_Field('name','vidiem_products',array('id'=>$pro_id));
            $cat_name = $this->FunctionModel->Select_Field('category_name','vidiem_registration_categories',array('id'=>$cat_id));
            $pro_name = $this->FunctionModel->Select_Field('product_name','vidiem_registration_products',array('id'=>$pro_id));
            $this->db->like('year(created)',date('Y'));
            $code=$this->ProjectModel->complaintCode();
             $InsertData=array(
                    'code'              =>  $code,
                    'category'          =>  $this->input->post('category'),
                    'product'           =>  $this->input->post('product'),
                    'category_name'     =>  $cat_name,
                    'product_name'      =>  $pro_name,
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
        //$data['products']=$this->FunctionModel->Select_Fields('id,name','vidiem_products',array('cat_id'=>$cat_id));
        $data['products']=$this->FunctionModel->Select_Fields('id, product_name as name','vidiem_registration_products',array('is_active'=>1, 'category_id'=>$cat_id));
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
       // $return['products']=$this->FunctionModel->Select_Fields('id,name','vidiem_products',array('cat_id'=>$cat_id));
        $return['products']=$this->FunctionModel->Select_Fields('id,product_name as name','vidiem_registration_products',array('category_id'=>$cat_id,'is_active' => 1));
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

    public function service_centers_old(){
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
			
			
			$client_id=$this->session->userdata('client_id');	
			 $updateDataexist=array(
						'IsActive'     => '2'
						);
			$resultexist = $this->FunctionModel->Update($updateDataexist,'vidiem_carts',array('customer_id' => $client_id,
				 'IsActive'=>'1'
				 ));
			
				 $updateData=array(						
						'customer_id'     => $client_id,
						'sessionId'     => '0'
						);
					$sessionid = $this->session->session_id;		
				 $result = $this->FunctionModel->Update($updateData,'vidiem_carts',array('sessionId' => $sessionid,
				 'IsActive'=>'1'
				 ));
			
			$previous_url = $this->session->userdata('previous_url');
			$this->session->unset_userdata("previous_url");
			
            if(empty($contents)){
				
				if( $previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
					$redirect=$previous_url;
				}else{
					$redirect='user/dashboard';
				}
				
              //  $redirect='user/dashboard';
            }else{
				if($previous_url=='checkout' || $previous_url=='cart' || $previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
					$redirect=$previous_url;
				}else{
					$redirect='checkout';
				}	
			  
                
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
           if($previous_url=='checkout' || $previous_url=='cart' || $previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
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
			
			
			
			$client_id=$this->session->userdata('client_id');			
			
			 $updateDataexist=array(
						'IsActive'     => '2'
						);
			$resultexist = $this->FunctionModel->Update($updateDataexist,'vidiem_carts',array('customer_id' => $client_id,
				 'IsActive'=>'1'
				 ));
				 $updateData=array(						
						'customer_id'     => $client_id,
						'sessionId'     => '0'
						);
					$sessionid = $this->session->session_id;		
				 $result = $this->FunctionModel->Update($updateData,'vidiem_carts',array('sessionId' => $sessionid,
				 'IsActive'=>'1'
				 ));

            $contents=$this->cart->contents();
            
           
            if(empty($contents)){
				if($previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
                   sleep(7);
					redirect($previous_url, 'refresh');
				}else{
					
                redirect('customize-checkout','refresh');
                // redirect('user/dashboard','refresh');
				}
            }else if($previous_url=='checkout' || $previous_url=='cart' || $previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
				
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
            }else if($previous_url=='checkout' || $previous_url=='cart' || $previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
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
            }else if($previous_url=='checkout' || $previous_url=='cart' || $previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
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
                if(empty($contents) && ($previous_url!='customize-cart' &&  $previous_url=='customize-checkout')){
                    redirect('user/dashboard','refresh');
                }else if($previous_url=='checkout' || $previous_url=='cart' || $previous_url=='customize-cart' ||  $previous_url=='customize-checkout' ){
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
        //  ss( $code );
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
                     $return['msg']='Invalid Coupon Code';
                }else{
                    $total= $this->cart->total();
                    // echo $total;
                    $user_order_count=$this->FunctionModel->Row_Count('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success'));
                    $user_used=$this->FunctionModel->Row_Count('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success','coupon_id'=>$info['id']));
                    $total_used=$this->FunctionModel->Row_Count('vidiem_order',array('payment_status'=>'success','coupon_id'=>$info['id']));
                    if($total<$info['min_order']){
                        echo 'tstet';
                    }
                  
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
                        </li> ';
					if($discount!=0){	
                       $return['msg'].=' <li class="clearfix">
                        <p class="priceti">Discount '.number_format($info['discount_value']).'% </p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($discount).'</p>
                        </li>';
					}else{
                        if( strtolower($code) == 'vitago' ) {

                            $return['msg'] .= ' 
                                                <li class="clearfix">
                                                    <p class="priceti"> Get VITA-GO Personal Blender </p>
                                                    <p class="priceAm"> Free </p>
                                                </li>';
                        } else {

                            $return['msg'] .= ' <li class="clearfix">
                                            <p class="priceti">3 Months Extended Warranty</p>
                                            <p class="priceAm">Free</p>
                                            </li>';
                        }

						
						
					}
                       $return['msg'].=' <li class="clearfix toamount">
                        <p class="priceti">AMOUNT PAYABLE</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()-$discount).'/-</p>
                        </li>';
                    }else if( $info['type'] ){

                        $discount       = ($info['discount_value']);
                        $return['msg']  = ' <li class="clearfix">
                                                <p class="priceti">Price ('.number_format($this->cart->total_items()).' Item)</p>
                                                <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($this->cart->total()).'/-</p>
                                                </li>
                                                <li class="clearfix">
                                                <p class="priceti">Delivery Charges</p>
                                                <p class="priceAm gre">Free</p>
                                            </li>';
                        if( $discount != 0 ) {	
                            $return['msg']  .= '<li class="clearfix">
                                                <p class="priceti">Discount</p>
                                                <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($discount).'</p>
                                                </li>';
                        } else {

                            if( strtolower($code) == 'vitago' ) {
                            
                                $return['msg'] .= ' 
                                                    <li class="clearfix">
                                                        <p class="priceti"> Get VITA-GO Personal Blender </p>
                                                        <p class="priceAm"> Free </p>
                                                    </li>';
                            } else {
    
                                $return['msg'] .= ' <li class="clearfix">
                                                <p class="priceti">3 Months Extended Warranty</p>
                                                <p class="priceAm">Free</p>
                                                </li>';
                            }

                        }
                            
                       $return['msg']    .= '  <li class="clearfix toamount">
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
	
	
	   // Coupon Code Functionalit
    public function custom_coupon_check() {

        $client_id              = $this->session->userdata('client_id');
        $code                   = $this->input->post('code');

        if(empty($code)){
            $return['status']   = 2;
            $return['msg']      = 'Enter Coupon Code';
        }else{
            if(empty($client_id)){
                $return['status']=2;
                $return['msg']   = 'Login to use coupon code';
            }else{
                $info=$this->ProjectModel->valid_coupon($code);
                
                if(empty($info)){
                     $return['status']=2;
                     $return['msg']='Invalid Coupon Code';
                }else{
                    $total= $this->cart->total();
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
                        </li>';
						if($discount!=0){
                        $return['msg'].=' <li class="clearfix">
                        <p class="priceti">Discount '.number_format($info['discount_value']).'% </p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($discount).'</p>
                        </li> ';
						}else{
                            if( strtolower($code) == 'vitago' ) {
                            
                                $return['msg'] .= ' 
                                                    <li class="clearfix">
                                                        <p class="priceti"> Get VITA-GO Personal Blender </p>
                                                        <p class="priceAm"> Free </p>
                                                    </li>';
                            } else {
    
                                $return['msg'] .= ' <li class="clearfix">
                                                <p class="priceti">3 Months Extended Warranty</p>
                                                <p class="priceAm">Free</p>
                                                </li>';
                            }
							
						}
                       $return['msg'].='  <li class="clearfix toamount">
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
                        </li>';
							if($discount!=0){
                        $return['msg'].=' <li class="clearfix">
                        <p class="priceti">Discount</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($discount).'</p>
                        </li>';
						}else{
                            if( strtolower($code) == 'vitago' ) {
                            
                                $return['msg'] .= ' 
                                                    <li class="clearfix">
                                                        <p class="priceti"> Get VITA-GO Personal Blender </p>
                                                        <p class="priceAm"> Free </p>
                                                    </li>';
                            } else {
    
                                $return['msg'] .= ' <li class="clearfix">
                                                <p class="priceti">3 Months Extended Warranty</p>
                                                <p class="priceAm">Free</p>
                                                </li>';
                            }	
							
						}
                        
                       $return['msg'].='  <li class="clearfix toamount">
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

    public function custom_order_coupon_check() {

        $total                  = 0;
        $cart_id                = $this->CheckCartId();	
        $client_id              = $this->session->userdata('client_id');
        $code                   = $this->input->post('code');

        if( empty( $code ) ) {
            $return['status']   = 2;
            $return['msg']      = 'Enter Coupon Code';
        } else {
            if( empty( $client_id ) ) {
                $return['status']=2;
                $return['msg']='Login to use coupon code';
            }else{
                $info                   = $this->ProjectModel->valid_coupon($code);
                
                if(empty($info)){
                    $return['status']   = 2;
                    $return['msg']      = 'Invalid Coupon Code';
                }else{
                    $total              = $this->calculatecartprice($cart_id);
                    $user_order_count   = $this->FunctionModel->Row_Count('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success'));
                    $user_used          = $this->FunctionModel->Row_Count('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success','coupon_id'=>$info['id']));
                    $total_used         = $this->FunctionModel->Row_Count('vidiem_order',array('payment_status'=>'success','coupon_id'=>$info['id']));
                    
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
                    $return['status']       = 1;
                    $data['cartitems']      = $this->getCartitems($cart_id);
                    $data['totprice']       = $this->calculatecartprice($cart_id);
                    
                    $cart_qty               = 0;
                    if(count($data['cartitems']['jarinfo'])>0)
                    {
                        foreach($data['cartitems']['jarinfo'] as $jar) {
                            $cart_qty      += $jar['qty'];
                        }
                    }
                    
                    $packageprice   = $this->CustomizeModel->calculatepackageprice($cart_id,$data['cartitems']['bodyinfo'][0]['base_id'],$cart_qty);
                    $grandtotal     = $total;
                    $total          = $total + $packageprice['price'];
                    if($info['type']==1){
                        $discount = $grandtotal*($info['discount_value']/100);
                        $discount = ($discount>$info['max_discount'])?$info['max_discount']:$discount;
                        $return['msg']='<li class="clearfix">
                        <p class="priceti">Price ('.number_format(1).' Item)</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($grandtotal).'</p>
                        </li>
                        <li class="clearfix">
                            <p class="priceti">Package Charges</p>
                            <p class="priceAm gre"><i class="fa fa-inr"></i>'. number_format($packageprice['price']).'</p>
                        </li>
                        <li class="clearfix">
                            <p class="priceti">Delivery Charges</p>
                            <p class="priceAm gre">Free</p>
                        </li>';
						if($discount!=0){
                        $return['msg'].=' <li class="clearfix">
                        <p class="priceti">Discount '.number_format($info['discount_value']).'% </p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($discount).'</p>
                        </li> ';
						}else{
                            if( strtolower($code) == 'vitago' ) {
                            
                                $return['msg'] .= ' 
                                                    <li class="clearfix">
                                                        <p class="priceti"> Get VITA-GO Personal Blender </p>
                                                        <p class="priceAm"> Free </p>
                                                    </li>';
                            } else {
    
                                $return['msg'] .= ' <li class="clearfix">
                                                <p class="priceti">3 Months Extended Warranty</p>
                                                <p class="priceAm">Free</p>
                                                </li>';
                            }

                            $_SESSION['customer_order_coupon_amount'] = $discount;
                            $_SESSION['custom_coupon_id']   = $info['id'];
                            $_SESSION['custom_coupon_code'] = $info['code'];
                            $_SESSION['coupon_type']        = $info['type'];
							
						}
                       $return['msg'].='  <li class="clearfix toamount">
                        <p class="priceti">AMOUNT PAYABLE</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($total-$discount).'/-</p>
                        </li>';
                    }else if($info['type']){
                        $discount           = ($info['discount_value']);
                        $return['msg']      = '<li class="clearfix">
                        <p class="priceti">Price ('.number_format(1).' Item)</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($grandtotal).'/-</p>
                        </li>
                        <li class="clearfix">
                            <p class="priceti">Package Charges</p>
                            <p class="priceAm gre"><i class="fa fa-inr"></i>'. number_format($packageprice['price']).'</p>
                        </li>
                        <li class="clearfix">
                        <p class="priceti">Delivery Charges</p>
                        <p class="priceAm gre">Free</p>
                        </li>';
						if( $discount!=0 ) {

                            $return['msg']  .= ' <li class="clearfix">
                                            <p class="priceti">Discount</p>
                                            <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($discount).'</p>
                                            </li>';

						} else {

                            if( strtolower($code) == 'vitago' ) {
                            
                                $return['msg'] .= ' 
                                                    <li class="clearfix">
                                                        <p class="priceti"> Get VITA-GO Personal Blender </p>
                                                        <p class="priceAm"> Free </p>
                                                    </li>';
                            } else {
    
                                $return['msg'] .= ' <li class="clearfix">
                                                <p class="priceti">3 Months Extended Warranty</p>
                                                <p class="priceAm">Free</p>
                                                </li>';
                            }

                            $_SESSION['customer_order_coupon_amount'] = $discount;
                            $_SESSION['custom_coupon_id']   = $info['id'];
                            $_SESSION['custom_coupon_code'] = $info['code'];
                            $_SESSION['coupon_type']        = $info['type'];
							
						}
                        
                       $return['msg'].='  <li class="clearfix toamount">
                        <p class="priceti">AMOUNT PAYABLE</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($total-$discount).'/-</p>
                        </li>';
                    }

                    if( $discount > 0 ) {
                        $_SESSION['customer_order_coupon_amount'] = $discount;
                        $_SESSION['custom_coupon_id']   = $info['id'];
                        $_SESSION['custom_coupon_code'] = $info['code'];
                        $_SESSION['coupon_type']        = $info['type'];
                    }
                }
            }
        }
        echo json_encode($return);
        exit;
    }

    public function custom_order_remove_coupon(){
        $nounce             = $this->input->post('nounce');
        if(empty($nounce)){ exit;}

        $cart_id            = $this->CheckCartId();	
        $total              = $this->calculatecartprice($cart_id);

        $data['cartitems']      = $this->getCartitems($cart_id);
        $data['totprice']       = $this->calculatecartprice($cart_id);
        
        $cart_qty               = 0;
        if(count($data['cartitems']['jarinfo'])>0)
        {
            foreach($data['cartitems']['jarinfo'] as $jar) {
                $cart_qty      += $jar['qty'];
            }
        }
        
        $packageprice   = $this->CustomizeModel->calculatepackageprice($cart_id,$data['cartitems']['bodyinfo'][0]['base_id'],$cart_qty);
        $grandtotal          = $total + $packageprice['price'];
        unset($_SESSION['customer_order_coupon_amount'] );
        unset( $_SESSION['custom_coupon_id'] );
        unset($_SESSION['custom_coupon_code']);

        echo '<li class="clearfix">
                        <p class="priceti">Price ('.number_format(1).' Item)</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($total).'/-</p>
                    </li>
                    <li class="clearfix">
                        <p class="priceti">Package Charges</p>
                        <p class="priceAm gre"><i class="fa fa-inr"></i>'. number_format($packageprice['price']).'</p>
                    </li>
                    <li class="clearfix">
                        <p class="priceti">Delivery Charges</p>
                        <p class="priceAm gre">Free</p>
                    </li>
                    <li class="clearfix toamount">
                        <p class="priceti">AMOUNT PAYABLE</p>
                        <p class="priceAm"><i class="fa fa-inr"></i> '.number_format($grandtotal).'/-</p>
                    </li>';
          exit;          
    }

    public function custom_remove_coupon(){
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

					$return['data'].='<div class="col-sm-12 col-md-6 col-lg-4 mb-5">
						
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

					$return['data'].='<div class="col-sm-12 col-md-6 col-lg-4 mb-5">
						
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
     public function vidiem_tusker(){
        $data['menu_id']=54;
         $data['vidiemtuskerseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Vidiem TUSKER'));
          $this->load->view('vidiem-tusker',$data);
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
       // $this->form_validation->set_rules('email','email','required|callback_mail_check');
	    $this->form_validation->set_rules('email','email','required');
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
				  <div class="col-12 col-sm-5">
					
					  <p><input class="dot" type="radio" id="slctadd_'.$cnt.'" name="shippingaddressid" value="'.$displayaddress['id'].'"> '.$displayaddress['name'].'</p>
					  <p>'.$displayaddress['mobile_no'].'<p> 
				
				  </div>
				  <div class="col-12 col-sm-5">
					<p>'.$displayaddress['address'].'<p> 
				  </div>
				  <div class="col-12 col-sm-2"> <a href="javascript:void(0);" class="cust_link edit btn btn-primary btn-sm" title="Edit" data-toggle="tooltip" onClick="javascript:triggershippingaddress_edit('.$displayaddress['id'].');"><span  data-target=".addnew-address" aria-expanded="false" aria-controls="addnew-address"><i class="lni lni-pencil-alt"></i><span> </a>  </div>
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
				  <div class="col-12 col-sm-5">
					
					  <p><input class="dot" type="radio" id="slctadd_'.$cnt.'" name="shippingaddressid" value="'.$displayaddress['id'].'"> '.$displayaddress['name'].'</p>
					  <p>'.$displayaddress['mobile_no'].'<p> 
				
				  </div>
				  <div class="col-12 col-sm-5">
					<p>'.$displayaddress['address'].'<p> 
				  </div>
				  <div class="col-12 col-sm-2"> <a href="javascript:void(0);" class="cust_link edit btn btn-primary btn-sm" title="Edit" data-toggle="tooltip" onClick="javascript:triggerbillingaddress_edit('.$displayaddress['id'].');"><span  data-target=".addnew-address" aria-expanded="false" aria-controls="addnew-address"><i class="lni lni-pencil-alt"></i><span> </a>  </div>
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
        <div style="width:30%;float:right;"><h1 style="color:#00BFFF;">Proforma Invoice</h1></div>
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
				if($order_data['discount']!=0){	
                    $data['content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">Coupon Discount ('.$order_data['coupon'].')</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['discount'],2,'.','').'</b></th>
                </tr>';
				}else{
					 $data['content'].='<tr>
                    <td></td>
                    <th style="text-align:right;" colspan="3">3 Months Extended Warranty</th>
                    <th style="padding:10px 0;text-align:right;">Free</th>
                </tr>';
					
				}
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

    public function vidiem_for_you() {

        $dealer_session             = $this->session->userdata('dealer_session');
        
        if( isset( $dealer_session ) && $dealer_session['user']['user_type'] != 'sale_person') {
            redirect('dealer-admin');
        }
        $data['menu_id']            = 12;
        $data['vidiemforyouseo']    = $this->FunctionModel->Select('vidiem_seo',array('title'=>'Vidiem for You'));
        $order                      = array(
                                        'field'=>'p.sortby',
                                        'type'=> 'desc'
                                    );
        
		$where                      = array("p.isactive = "=>"1");
        $custom                     = '';
        $searchQuery                = [];
       		
        $data['customizebase']      = $this->CustomizeModel->customizebaseList('list',$where,$custom,$searchQuery,$order);
        $data['customizepackage']   = $this->CustomizeModel->customizepackageList('list',$where,$custom,$searchQuery,$order);
        $data['typeofjar']          = $this->CustomizeModel->typeofjarList('list',$where,$custom,$searchQuery,'');
        $data['typeofhandle']       = $this->CustomizeModel->typeofhandleList('list',$where,$custom,$searchQuery,'');
        $data['capacity']           = $this->CustomizeModel->capacityList('list',$where,$custom,$searchQuery,'');
        $data['typeoflid']          = $this->CustomizeModel->typeoflidList('list',$where,$custom,$searchQuery,'');
    
        $cart_id                    = $this->getCartId();
        
        if($cart_id)
        {
            $cartarr                = $this->CustomizeModel->getDataActiveById($cart_id,"vidiem_cart_details","cart_id");

            if($cartarr->cart_detail_id)
            {
                $updateData         = array(
                                        'base_id'  => '0',
                                        'base_color_id'=>'0',
                                        'motor_id'=>'0',
                                        'package_id'=>'0',						
                                        'cart_id'    =>$cart_id,
                                        'Isactive'     => "1",
                                        'ModifiedDate' => date('Y-m-d H:i:s'),
                                        'dealer_user_id' => $dealer_session['user']['id'] ?? null,
                                        'dealer_id' => $dealer_session['dealer']['id'] ?? null
                                    );

                $result             = $this->FunctionModel->Update($updateData,'vidiem_cart_details',array('cart_detail_id' => $cartarr->cart_detail_id));
            
                $updatejar          = array(
                                        'Isactive'          => "2",
                                        'ModifiedDate'      => date('Y-m-d H:i:s'),
                                        'dealer_user_id'    => $dealer_session['user']['id'] ?? null,
                                        'dealer_id'         => $dealer_session['dealer']['id'] ?? null 
                                    );
                $result             = $this->FunctionModel->Update($updatejar,'vidiem_cart_jar',array('cart_id' => $cartarr->cart_id));	
            }
            
        }
        $this->load->view('vidiem-for-you',$data);
     }
	 
	public function vidiem_by_you_recustomize() {

        $data['menu_id']            = 12;
        $data['vidiemforyouseo']    = $this->FunctionModel->Select('vidiem_seo',array('title'=>'Vidiem for You'));
        
    
        $order                      = array(
                                        'field'=>'p.sortby',
                                        'type'=> 'desc'
                                    );
       
        $where=[];
		$where=array("p.isactive = "=>"1");
        $custom='';
        $searchQuery = [];
       		
        $data['customizebase']=$this->CustomizeModel->customizebaseList('list',$where,$custom,$searchQuery,$order);
        $data['customizepackage']=$this->CustomizeModel->customizepackageList('list',$where,$custom,$searchQuery,$order);
        $data['typeofjar']=$this->CustomizeModel->typeofjarList('list',$where,$custom,$searchQuery,'');
        $data['typeofhandle']=$this->CustomizeModel->typeofhandleList('list',$where,$custom,$searchQuery,'');
        $data['capacity']=$this->CustomizeModel->capacityList('list',$where,$custom,$searchQuery,'');
        $data['typeoflid']=$this->CustomizeModel->typeoflidList('list',$where,$custom,$searchQuery,'');
		
        $cart_id=$this->getCartId();
        
        if($cart_id)
        {
            $cartarr                    = $this->CustomizeModel->getDataActiveById($cart_id,"vidiem_cart_details","cart_id");
            $data['cartitems']          = $this->getCartitems($cart_id); 
				 
            $where                      = array("p.isactive = "=>"1", "p.base_id"=>	$data['cartitems']['bodyinfo'][0]['base_id']);	
            
            $data['basecolorlist']      = $this->CustomizeModel->combinebasecolorList('list',$where,'','',$order);
            $data['basemotorlist']      = $this->CustomizeModel->combinebasemotorList('list',$where,'','',$order);
            
            $where                      = array( "p.isactive = "=>"1", "p.base_id"=> $data['cartitems']['bodyinfo'][0]['bm_color_id']);	
            $data['jarlist']            = $this->CustomizeModel->combinebasejarList('list',$where,'','',$order);
				
            $order                      = array(
                                            'field'=>'name',
                                            'type'=> 'desc'
                                        );
				
            $data['alljarlist'] = $this->CustomizeModel->combinebasejarexclude('list',$where,'','',$order);
            $data['totprice']=$this->calculatecartprice($cart_id);	

            $data['selecteditem']=$this->getselecteditems($cart_id);	
            
        }
        $this->load->view('vidiem-for-you',$data);

    }
	
    public function getbasecolor(){

	    $id=$this->input->post('bid');
        if(!empty($id) && $id!=""){
            
            $order              = array( 'field'=>'sortby','type'=> 'desc' );
            $where              = array( "p.isactive"=>"1","p.base_id"=> $id );
            $basecolorlist      = $this->CustomizeModel->combinebasecolorList('list',$where,'','',$order);
            $basemotorlist      = $this->CustomizeModel->combinebasemotorList('list',$where,'','',$order);
		
            $showmessage        = $this->CustomizeModel->getDataActiveById($id,"vidiem_basemodel_text","base_id");
            
            $basecolor          = "<div class='body-color'>";
            if( count($basecolorlist)>0 ){
                foreach($basecolorlist as $base_col) {
                    $clsactive = "";
                    if($base_col['isdefault']==1)
                    {
                        // $clsactive=" active ";
                    }
							   
					$basecolor.=' <div>
							 <a class="select-color '.$clsactive.'" href="javascript:void(0);" onclick="fnbasecolorclick(this,\''.$base_col['bm_color_id'].'\',\''.base_url('uploads/customizeimg/basecolor/'.$base_col['basepath']).'\',\''.@number_format($base_col['price']).'\');" >	
                              <img src="'.base_url('uploads/customizeimg/basecolor/'.$base_col['basepath']).'" alt="" class="img-fluid"/>
                              <span>'.$base_col['title'].'</span>';
                    if(	$base_col['price']!=0)
                    {
                        $basecolor.='<span>'.$base_col['price'].'</span>'; 
                    }		
							  
                    $basecolor.='  <i class="fa fa-check-circle" aria-hidden="true"></i>
                        </a>
                    </div>';
							   
				}
				$basecolor.='</div>  <div class="next-btn">
                           <button type="button" class="black-btn" id="body-color-prev">Previous</button>
                           <button disabled type="button" class="red-btn" id="body-color-next">Accept</button>
                        </div>
				
				';	   
			
		        $basemotor='	 <div class="col-12 col-sm-4 col-md-4 col-lg-3 mob-motor-hide">
                                <p class="text-center">
                                    <img id="motorimg" src="'.base_url('uploads/customizeimg/basemotor/default_motor.png').' " alt="" class="img-fluid"/>
                                </p>
                            </div>';		
			
                $basemotor.='<div class="col-12 col-sm-8 col-md-8 col-lg-9"><div class="motor-select-scroll">';
                if(count($basemotorlist)>0){
                    $flag=0;
                    foreach($basemotorlist as $motor) {
                        $clsactive="";
                        if($flag==0)
                        {
                            $motorimg=base_url('uploads/customizeimg/basemotor/'.$motor['basepath']);
                            $flag=1;
                        }
							   
						$basemotor.=' <div>
							 <div class="custom-control custom-radio motor-select '.$clsactive.'" href="javascript:void(0);" >	
							 
							  <input onchange="fnbasemotorclick(this,\''.$motor['motor_id'].'\',\''.base_url('uploads/customizeimg/basemotor/'.$motor['basepath']).'\',\''.@number_format($motor['price']).'\');"  class="custom-control-input" type="radio" name="motorSelect" id="motorSelect'.$motor['motor_id'].'" />
                                            <label class="custom-control-label" for="motorSelect'.$motor['motor_id'].'"> '.$motor['motorname'].' <small>'.$motor['description'].'</small> </label>                             
                             ';
						if(	$motor['motorprice']!=0)
						{
							$basemotor.='<span>Rs. '.number_format($motor['motorprice']).'</span>'; 
						}		
							  
                        $basemotor.=' 
                            </div>
                            <div class="d-none motor_view_info" id="motor_view_info_'.$motor['motor_id'].'">
                            <a href="#" class="link" onclick="callMotorModal('.$motor['motor_id'].','.$motor['motor_base_id'].')">view info</a>
                            </div>
                        </div>';
                            
                    }
				    $basemotor.='</div> </div> 
                        <div class="col-12"> <div class="next-btn">
                            <button type="button" class="black-btn" id="motor-prev">Previous</button>
                           <button disabled type="button" class="red-btn"   href="#" id="motor-next">Accept</button>
                        </div></div>';		
			
			        $cart_id = $this->getCartId();
			
                    if($cart_id)
                    {
                        $cartarr = $this->CustomizeModel->getDataActiveById($cart_id,"vidiem_cart_details","cart_id");	
                        
                        if($cartarr->cart_detail_id)
                        {
                            $updateData=array(
                                'base_id'  => $id,
                                'base_color_id'=>'0',
                                'motor_id'=>'0',
                                'package_id'=>'0',	
                                'canvas_text'=>'',							
                                'cart_id'    =>$cart_id,
                                'Isactive'     => "1",
                                'dealer_user_id' => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                                'dealer_id' => $this->session->userdata('dealer_session')['dealer']['id'] ?? null,
                                'ModifiedDate' => date('Y-m-d H:i:s')
                                );
                            $result = $this->FunctionModel->Update($updateData,'vidiem_cart_details',array('cart_detail_id' => $cartarr->cart_detail_id));
                        
                            $updatejar  = array(
                                            'Isactive'     => "2",
                                            'ModifiedDate' => date('Y-m-d H:i:s'),
                                            'dealer_user_id' => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                                            'dealer_id' => $this->session->userdata('dealer_session')['dealer']['id'] ?? null, 
                                        );
                            $result     = $this->FunctionModel->Update($updatejar,'vidiem_cart_jar',array('cart_id' => $cartarr->cart_id));	
                        }
                        else{
                            
                            $insertData = array(
                                            'base_id'  => $id,
                                            'cart_id'    =>$cart_id,
                                            'Isactive'     => "1",
                                            'dealer_user_id' => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                                            'dealer_id' => $this->session->userdata('dealer_session')['dealer']['id'] ?? null,
                                            'ModifiedDate' => date('Y-m-d H:i:s')
                                        );
                            $result     = $this->FunctionModel->Insert( $insertData, 'vidiem_cart_details' );
                            
                        }
                    }
				
			
		        } else {
                    $data_arr=array("status"=>0,
                                "data_html"=>"",
                                "error_msg"=>"No motor Option");	
                    echo json_encode($data_arr);
                    exit();				
		        }
						
                $price=$this->calculatecartprice($cart_id);	
                $selecteditem=$this->getselecteditems($cart_id);	
				
			    $data_arr       = array(
                                    "status"=>200,
                                    "color_html"=>$basecolor,
                                    "motor_html"=>$basemotor,
                                    //"jar_html"=>$basejar,
                                    //"other_jar_html"=>$otherjar,
                                    //"otherjar_button"=>$otherjar_button,
                                    "showmsgleft"=>empty($showmessage->desktopleft)?0:$showmessage->desktopleft,
                                    "showmsgtop"=>empty($showmessage->desktoptop)?0:$showmessage->desktoptop,
                                    "showmsgvertical"=>empty($showmessage->desktop_vertical)?0:$showmessage->desktop_vertical,
                                    "totprice"=>number_format($price),
                                    "selecteditem"=>$selecteditem['strselecteditem'],
                                    "selecteditembase"=>$selecteditem['strselecteditem_base'],
                                    "jarcount"=>"0",
                                    "error_msg"=>""
                                );		   
				
		    } else {
                $data_arr       = array(
                                        "status"=>0,
                                        "data_html"=>"",
                                        "error_msg"=>"No Color Option"
                                    );
                echo json_encode($data_arr);
                exit();				
            }	
		
	    } else {
			$data_arr           = array(
                                        "status"=>0,
                                        "data_html"=>"",
                                        "error_msg"=>"Choose the base model"
                                    );
			echo json_encode($data_arr);
			exit();
		}	
	 	echo json_encode($data_arr);
		exit();
    
	}
	
		
    public function savebasecolor() {
	
	    $id = $this->input->post('bcid');
		
	    if(!empty($id) && $id!="") {

		    $cart_id                = $this->getCartId();
			if($cart_id)
			{
			    $cartarr            = $this->CustomizeModel->getDataActiveById($cart_id,"vidiem_cart_details","cart_id");	
                
				if($cartarr->cart_detail_id)
				{
					$updateData     = array(
                                        'base_color_id'  => $id,
                                        'cart_id'    =>$cart_id,
                                        'Isactive'     => "1",
                                        'ModifiedDate' => date('Y-m-d H:i:s'),
                                        'dealer_user_id' => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                                        'dealer_id' => $this->session->userdata('dealer_session')['dealer']['id'] ?? null,
                                    );
                    $result         = $this->FunctionModel->Update($updateData,'vidiem_cart_details',array('cart_detail_id' => $cartarr->cart_detail_id));
				    $updateData     = array(						
                                        'Isactive'     => "2",
                                        'ModifiedDate' => date('Y-m-d H:i:s'),
                                        'dealer_user_id' => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                                        'dealer_id' => $this->session->userdata('dealer_session')['dealer']['id'] ?? null,
                                    );
				    $newresult      = $this->FunctionModel->Update($updateData,'vidiem_cart_jar',array('cart_id' => $cart_id));
						
				} else {
					
					$insertData     = array(
                                        'base_color_id'  => $id,
                                        'cart_id'    =>$cart_id,
                                        'Isactive'     => "1",
                                        'ModifiedDate' => date('Y-m-d H:i:s'),
                                        'dealer_user_id' => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                                        'dealer_id' => $this->session->userdata('dealer_session')['dealer']['id'] ?? null,
                                    );
					$result         = $this->FunctionModel->Insert($insertData,'vidiem_cart_details');
					
				}
			}
			
				
           $order                   = array(
                                        'field'=>'sortby',
                                        'type'=> 'desc'
                                    );
		    $where                  = array("p.isactive"=>"1","p.base_id"=>	$id);
		
		    $jarlist                = $this->CustomizeModel->combinebasejarList('list',$where,'','',$order);
		
		    $order                  = array(
                                        'field'=>'name',
                                        'type'=> 'desc'
                                    );
		
		    $alljarlist             = $this->CustomizeModel->combinebasejarexclude('list',$where,'','',$order);
			
		    $basejar                = '  <div class="jar-scroll">';
            
		    if(count($jarlist)>0) {
                $flag=0;
                foreach($jarlist as $jar) {
                    $basejar.='';
                }
			    $basejar.='    <div> 
                              <div class="select-jar-last"><p class="jar-options">Choose from our Jar, Handle and Lid options <br/><a class="red-btn" href="#" data-toggle="modal" data-target="#JarsModal"><i class="lni lni-arrow-right arrow-animate"></i> &nbsp; Click Here!</a></p>
                               <p class="jar-options-selected"><strong>You have selected <span id="jarcnt">0</span> Jars</strong><br/><a class="red-btn" href="#" data-toggle="modal" data-target="#JarsModal"><i class="lni lni-arrow-right arrow-animate"></i> &nbsp; Click here to change</a><p>
                              </div>
                           </div> </div> ';
		    } else {
			    $data_arr = array(
                                "status"=>0,
                                "data_html"=>"",
                                "error_msg"=>"No Jar Option"
                            );	
			    echo json_encode($data_arr);
			    exit();				
		    }				   

			$otherjar='  <div class="model-jars">';
		    if(count($alljarlist)>0){
				
                foreach($alljarlist as $jar) {
                    
                    $description = (!empty($jar['description']) && $jar['description'] != '') ?  '' : "";
                    
                    $otherjar.='
							  
                              <div class="select-jar selectedjar-'.$jar['jar_id'].'">
                                 <a href="javascript:void(0)" onclick="return getJarView( '.$jar['jar_id'].' )">
                                    '.$description.'
                                     <img src="'.base_url("uploads/customizeimg/jar/".$jar['basepath']).'" alt="" class="img-fluid"/>
                                 </a>
                              
                           
                                 <span class="jar-name">'.$jar['name'].'</span>
                                 <span>Rs. '.number_format($jar['price']).'</span>                                            
                                    <div class="plus-minus">
                                        <button type="button" class="red-btn init-button" data-jar-id="'.$jar['jar_id'].'">
                                            Add
                                        </button>    
                                       <div class="input-group" id="jar-id-'.$jar['jar_id'].'" style="display:none">
                                          <span class="input-group-prepend">
                                          <button type="button" class="btn btn-number" disabled="disabled" data-type="minus" data-field="quant['.$jar['jar_id'].']">
                                          <span class="fa fa-minus"></span>
                                          </button>
                                          </span>
                                          <input type="text" id="qtyinp_'.$jar['jar_id'].'" name="quant['.$jar['jar_id'].']" class="form-control input-number" value="0" min="0" max="10">
                                          <span class="input-group-append">
                                          <button type="button" class="btn btn-number jar-plus" id="jar-id-inc-'.$jar['jar_id'].'" data-type="plus" data-field="quant['.$jar['jar_id'].']">
                                          <span class="fa fa-plus"></span>
                                          </button>
                                          </span>
                                       </div>
                                    </div>
                                 <i class="fa fa-check-circle" aria-hidden="true"></i>
                              </div>
                             ';
							   
					}
		        } else {
                    $otherjar .= ' <div class="select-jar ">
                                    No jar founds
                                </div>';
                }			
					   
                $otherjar .= '     </div> ';	
                
                $otherjar_button = '   <div class="row">
                 
                            <div class="col-sm-6">
                                <a class="black-btn" href="javascript:void(0);"  onclick="funremoveotherjars(\''.$id.'\');">Cancel</a>
                            </div>
                            <div class="col-sm-6">
                                <a class="red-btn" href="javascript:void(0);" onclick="funmodalclose(\''.$id.'\');">Accept</a>
                            </div>
                        </div> ';
			
                $price = $this->calculatecartprice($cart_id);	
                $selecteditem = $this->getselecteditems($cart_id);	
			
			    $data_arr = array(
                                "status"=>200,
                                "data_html"=>"",
                                "totprice"=>number_format($price),
                                "selecteditem"=>$selecteditem['strselecteditem'],
                                "selecteditembase"=>$selecteditem['strselecteditem_base'],
                                "jar_html" => $basejar,
                                "other_jar_html" => $otherjar,
                                "otherjar_button" => $otherjar_button,
                                "error_msg"=>""
                            );	
		
	    } else {
			$data_arr       = array(
                                "status"=>0,
                                "data_html"=>"",
                                "error_msg"=>"Choose the base color model"
                            );		  
		}	
	 	echo json_encode($data_arr);
		exit();
    }
	
		
    public function savebasemotor(){
		
	    $id     = $this->input->post('bcid');
		
        if(!empty($id) && $id!=""){
            
            
            $cart_id=$this->getCartId();
                
            if($cart_id)
            {
                $cartarr = $this->CustomizeModel->getDataActiveById($cart_id,"vidiem_cart_details","cart_id");	
                
                if($cartarr->cart_detail_id)
                {
                    $updateData=array(
                        'motor_id'  => $id,
                        'cart_id'    =>$cart_id,
                        'Isactive'     => "1",
                        'ModifiedDate' => date('Y-m-d H:i:s')
                        );
                $result = $this->FunctionModel->Update($updateData,'vidiem_cart_details',array('cart_detail_id' => $cartarr->cart_detail_id));
                        
                }
                else{
                    
                    $insertData=array(
                        'motor_id'          => $id,
                        'cart_id'           => $cart_id,
                        'Isactive'          => "1",
                        'ModifiedDate'      => date('Y-m-d H:i:s'),
                        'dealer_user_id'    => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                        'dealer_id'         => $this->session->userdata('dealer_session')['dealer']['id'] ?? null,
                        );
                    $result=$this->FunctionModel->Insert($insertData,'vidiem_cart_details');
                    
                }
            }
            $price          = $this->calculatecartprice($cart_id);	
            $selecteditem   = $this->getselecteditems($cart_id);	
        
            $data_arr       = array("status"=>200,
                                    "data_html"=>"",
                                    "totprice"=>number_format($price),
                                    "selecteditem"=>$selecteditem['strselecteditem'],
                                    "selecteditembase"=>$selecteditem['strselecteditem_base'],
                                    "error_msg"=>"");
            
        } else {
            $data_arr       = array(
                                "status"        => 0,
                                "data_html"     => "",
                                "error_msg"     => "Choose the base color model"
                            );		  
        }	
	 	echo json_encode($data_arr);
		exit();

    }
	
    public function savepackage(){
		
	    $id             = $this->input->post('bcid');
		
        if(!empty($id) && $id!="") {
            
            $cart_id    = $this->getCartId();
                
            if($cart_id)
            {
                $cartarr = $this->CustomizeModel->getDataActiveById($cart_id,"vidiem_cart_details","cart_id");	
                    
                if($cartarr->cart_detail_id)
                {
                    $updateData = array(
                        'package_id'  => $id,
                        'cart_id'    =>$cart_id,
                        'Isactive'     => "1",
                        'ModifiedDate' => date('Y-m-d H:i:s')
                        );
                    $result = $this->FunctionModel->Update($updateData,'vidiem_cart_details',array('cart_detail_id' => $cartarr->cart_detail_id));
                        
                } else {
                    
                    $insertData = array(
                                'package_id'        => $id,
                                'cart_id'           => $cart_id,
                                'Isactive'          => "1",
                                'ModifiedDate'      => date('Y-m-d H:i:s'),
                                'dealer_user_id'    => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                                'dealer_id'         => $this->session->userdata('dealer_session')['dealer']['id'] ?? null
                            );
                    $result = $this->FunctionModel->Insert( $insertData,'vidiem_cart_details');
                    
                }
            }
            $price          = $this->calculatecartprice($cart_id);	
            $selecteditem   = $this->getselecteditems($cart_id);	
            
            $data_arr       = array(
                                "status"=>200,
                                "data_html"=>"",
                                "totprice"=>number_format($price),
                                "selecteditem"=>$selecteditem['strselecteditem'],
                                "selecteditembase"=>$selecteditem['strselecteditem_base'],
                                "error_msg"=>""
                            );
            
        } else {
			$data_arr=array("status"=>0,
						"data_html"=>"",
						"error_msg"=>"Choose the base color model");		  
		}	
	 	echo json_encode($data_arr);
		exit();
    }
	
    public function saveimportedtext() {
		
	    $txt        = $this->input->post('txt');
		$cart_id    = $this->getCartId();
			
        if($cart_id)
        {
            $cartarr = $this->CustomizeModel->getDataActiveById($cart_id,"vidiem_cart_details","cart_id");	
            
            if($cartarr->cart_detail_id)
            {
                $updateData     = array(
                                    'canvas_text'   => $txt,
                                    'cart_id'       => $cart_id,
                                    'Isactive'      => "1",
                                    'ModifiedDate'  => date('Y-m-d H:i:s')
                                );
                $result             = $this->FunctionModel->Update($updateData,'vidiem_cart_details',array('cart_detail_id' => $cartarr->cart_detail_id));
                    
            } else {
                
                $insertData=array(
                    'canvas_text'       => $txt,
                    'cart_id'           => $cart_id,
                    'Isactive'          => "1",
                    'ModifiedDate'      => date('Y-m-d H:i:s'),
                    'dealer_user_id'    => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                    'dealer_id'         => $this->session->userdata('dealer_session')['dealer']['id'] ?? null
                );
                $result=$this->FunctionModel->Insert($insertData,'vidiem_cart_details');
                
            }
        }

		$price              = $this->calculatecartprice($cart_id);	
		$selecteditem       = $this->getselecteditems($cart_id);	
		
        $data_arr           = array(
                                "status"        => 200,
                                "data_html"     => "",
                                "totprice"      => number_format($price),
                                "selecteditem"  => $selecteditem['strselecteditem'],
                                "selecteditembase"=>$selecteditem['strselecteditem_base'],
                                "error_msg"=>""
                            );
		
	 	echo json_encode($data_arr);
		exit();
    }
	
    public function savemessagetext(){
		
        $txt            = $this->input->post('txt');
        $occasion_text  = $this->input->post('occasion_text');
		
		$cart_id        = $this->getCartId();
			
        if($cart_id)
        {
            $cartarr    = $this->CustomizeModel->getDataActiveById($cart_id,"vidiem_cart_details","cart_id");	
            
            if($cartarr->cart_detail_id)
            {
                $updateData = array(
                                'message_text'  => $txt,
                                'occasion_text' => $occasion_text,
                                'cart_id'       => $cart_id,
                                'Isactive'      => "1",
                                'ModifiedDate'  => date('Y-m-d H:i:s')
                            );
                $result     = $this->FunctionModel->Update($updateData,'vidiem_cart_details',array('cart_detail_id' => $cartarr->cart_detail_id));
                    
            } else {
                
                $insertData = array(
                                'message_text'      => $txt,
                                'occasion_text'     => $occasion_text,
                                'cart_id'           => $cart_id,
                                'Isactive'          => "1",
                                'ModifiedDate'      => date('Y-m-d H:i:s'),
                                'dealer_user_id'    => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                                'dealer_id'         => $this->session->userdata('dealer_session')['dealer']['id'] ?? null
                            );
                $result     = $this->FunctionModel->Insert($insertData,'vidiem_cart_details');
                
            }
        }
		$price          = $this->calculatecartprice($cart_id);	
		
		$selecteditem   = $this->getselecteditems($cart_id);	
		
        $data_arr       = array(
                            "status"            => 200,
                            "data_html"         => "",
                            "totprice"          => number_format($price),
                            "selecteditem"      => $selecteditem['strselecteditem'],
                            "selecteditembase"  => $selecteditem['strselecteditem_base'],
                            "error_msg"         => ""
                        );
		
	 	echo json_encode($data_arr);
		exit();

    }
	
    public function savejar() {
		 
        $id         = $this->input->post('jid');
        $dealer_session = $this->session->userdata('dealer_session');
        
        if(!empty($id) && $id!="")
        {
		    $cart_id=$this->getCartId();
			if($cart_id)
			{
				$where          = array( "cart_id"=>$cart_id, "jar_id"=>$id, "isactive"=>"1" );	
			    $cartjararr     = $this->CustomizeModel->getDataArrMultCond("vidiem_cart_jar",$where);	
               
				if( $cartjararr->cart_jar_id )
				{
				    if( $this->input->post('qty')>0 ){	
                        $updateData = array(
                                        'jar_id'  => $id,
                                        'cart_id'    =>$cart_id,
                                        "qty"=>$this->input->post('qty'),
                                        'Isactive'     => "1",
                                        'ModifiedDate' => date('Y-m-d H:i:s')
                                        );
                        $result     = $this->FunctionModel->Update($updateData,'vidiem_cart_jar',array('cart_jar_id' => $cartjararr->cart_jar_id));
                    } else {
                        $updateData = array(						
                                        'Isactive'     => "2",
                                        'ModifiedDate' => date('Y-m-d H:i:s')
                                    );
                        $result     = $this->FunctionModel->Update($updateData,'vidiem_cart_jar',array('cart_jar_id' => $cartjararr->cart_jar_id));
                    }
						
				} else {
                    if( $this->input->post('qty') > 0 ) {		
                        $insertData = array(
                                        'jar_id'            => $id,
                                        'cart_id'           => $cart_id,
                                        "qty"               => $this->input->post('qty'),
                                        'Isactive'          => "1",
                                        'createddate'       => date('Y-m-d H:i:s'),
                                        'modifieddate'      => date('Y-m-d H:i:s'),
                                        'dealer_user_id'    => $dealer_session['user']['id'] ?? null,
                                        'dealer_id'         => $dealer_session['dealer']['id'] ?? null
                                     );
                        $result     = $this->FunctionModel->Insert($insertData,'vidiem_cart_jar');
                    }
				}
			}
			$price              = $this->calculatecartprice($cart_id);	
			$selecteditem       = $this->getselecteditems($cart_id);
            $jarcount           = $this->CustomizeModel->getCartJarCount($cart_id);	
            
            $baseinfo           = $this->db->where('cart_id', $cart_id)->get('vidiem_cart_details')->row();
            
            $base_id            = $baseinfo->base_id;
            //$has75LJar          = $this->CustomizeModel->checkCartHas75L($cart_id);
             $has75LJar          = $this->CustomizeModel->checkCartHas75Lfixed($cart_id);
            
            
            $order              = array( 'field'=>'priority','type'=> 'asc' );
            $where              = array( "p.isactive"=>"1","p.base_id"=> $base_id );
            $basemotorlist      = $this->CustomizeModel->combinebasemotorList('list',$where,'','',$order);

            $basemotor          = '<div class="col-12 col-sm-4 col-md-4 col-lg-3 mob-motor-hide">
                                    <p class="text-center">
                                        <img id="motorimg" src="'.base_url('uploads/customizeimg/basemotor/default_motor.png').' " alt="" class="img-fluid"/>
                                    </p>
                                </div>';
                                
                        
			
            $basemotor.='<div class="col-12 col-sm-8 col-md-8 col-lg-9"><div class="motor-select-scroll">';
            if(count($basemotorlist)>0){
                $flag=0;
                $count = 0;
                $hintFlowText = '';
                foreach($basemotorlist as $motor) {
                    $clsactive="";
                   
                    if($flag==0)
                    {
                        $motorimg=base_url('uploads/customizeimg/basemotor/'.$motor['basepath']);
                        $flag=1;
                    }
                    
                   $disabled = '';
                    $hint_text="";
                  
                    if( $has75LJar > 0 && $motor['motorcode']=="Motor650"  || $has75LJar > 0 && $motor['motorcode']=="M5" ){
                        
                        $disabled   = 'disabled';
                        $hintFlowText = $hint_text  = '   <div class="col-12">
                                        <div class="alert alert-danger">650 &amp; 600 Watts motors are not compatible with 1.75 Litre Jars.</div>
                                    </div>';
                    }
                    
                    $basemotor.=' <div>
                            <div class="custom-control custom-radio '.$has75LJar.$count.' motor-select '.$clsactive.'" href="javascript:void(0);" >	
                            
                            <input '.$disabled.' onchange="fnbasemotorclick(this,\''.$motor['motor_id'].'\',\''.base_url('uploads/customizeimg/basemotor/'.$motor['basepath']).'\',\''.@number_format($motor['price']).'\');"  class="custom-control-input" type="radio" name="motorSelect" id="motorSelect'.$motor['motor_id'].'" />
                                        <label class="custom-control-label" for="motorSelect'.$motor['motor_id'].'"> '.$motor['motorname'].' <small>'.$motor['description'].'</small> </label>                             
                            ';
                    if(	$motor['motorprice']!=0)
                    {
                        $basemotor.='<span>Rs. '.number_format($motor['motorprice']).'</span>'; 
                    }		
                            
                    $basemotor.=' 
                        </div>
                        <div class="d-none motor_view_info" id="motor_view_info_'.$motor['motor_id'].'">
                        <a href="#" class="link" onclick="callMotorModal('.$motor['motor_id'].','.$motor['motor_base_id'].')">view info</a>
                        </div>
                    </div>';
                    $count++; 
                }
                $basemotor.='</div> </div> 
                    <div class="col-12"> <div class="next-btn">
                        <button type="button" class="black-btn" id="motor-prev">Previous</button>
                        <button disabled type="button" class="red-btn"   href="#" id="motor-next">Accept</button>
                    </div></div>'.$hintFlowText;	
            }            
            
            $data_arr       = array(
                            "status"=>200,
                            "data_html"=>"",
                            "motor_html" => $basemotor,
                            "totprice"=>number_format($price),
                            "jarcount"=>$jarcount,
                            "selecteditem"=>$selecteditem['strselecteditem'],
                            "selecteditembase"=>$selecteditem['strselecteditem_base'],
                            "error_msg"=>""
                        );
		
	    } else {
			$data_arr       = array(
                                "status"=>0,
                                "data_html"=>"",
                                "error_msg"=>"Choose the base color model"
                            );		  
		}	
	 	echo json_encode($data_arr);
		exit();
    }
	
	
public function deletecartjar(){
    
    $id=$this->input->post('cjid');

    if(!empty($id) && $id!="")
    {
        
        $cart_id=$this->getCartId();
            
            if($cart_id)
            {
                $updateData=array(						
                        'Isactive'     => "2",
                        'ModifiedDate' => date('Y-m-d H:i:s')
                        );
                $result = $this->FunctionModel->Update($updateData,'vidiem_cart_jar',array('cart_jar_id' => $id));
        
            }
    }
    
     $baseinfo           = $this->db->where('cart_id', $cart_id)->get('vidiem_cart_details')->row();
            
            $base_id            = $baseinfo->base_id;
	
        $price=$this->calculatecartprice($cart_id);	
        $selecteditem=$this->getselecteditems($cart_id);	
            
        
        $jarcount = $this->CustomizeModel->getCartJarCount($cart_id);
        $has75LJar          = $this->CustomizeModel->checkCartHas75L($cart_id);
        $order              = array( 'field'=>'sortby','type'=> 'desc' );
        $where              = array( "p.isactive"=>"1","p.base_id"=> $base_id );
        $basemotorlist      = $this->CustomizeModel->combinebasemotorList('list',$where,'','',$order);
        
       

        $basemotor          = '	 <div class="col-12 col-sm-4 col-md-4 col-lg-3 mob-motor-hide">
                            <p class="text-center">
                                <img id="motorimg" src="'.base_url('uploads/customizeimg/basemotor/default_motor.png').' " alt="" class="img-fluid"/>
                            </p>
                        </div>';		
        
        $basemotor.='<div class="col-12 col-sm-8 col-md-8 col-lg-9"><div class="motor-select-scroll">';
        if(count($basemotorlist)>0){
            $flag=0;
            $count = 0;
            foreach($basemotorlist as $motor) {
                $clsactive="";
                if($flag==0)
                {
                    $motorimg=base_url('uploads/customizeimg/basemotor/'.$motor['basepath']);
                    $flag=1;
                }
                $disabled = '';
                    $hint_text="";
                     if( $has75LJar > 0 && ($motor['motorcode']=="Motor650" || $motor['motorcode']=="M5") ){
                         $disabled = 'disabled';
                      $hint_text='   <div class="col-12">
                                        <div class="alert alert-danger">650 &amp; 600 Watts motors are not compatible with 1.75 Litre Jars.</div>
                                    </div>';
                     }
                        
                $basemotor.=' <div>
                        <div class="custom-control custom-radio durai'.$has75LJar.$count.' motor-select '.$clsactive.'" href="javascript:void(0);" >	
                        
                        <input '.$disabled.' onchange="fnbasemotorclick(this,\''.$motor['motor_id'].'\',\''.base_url('uploads/customizeimg/basemotor/'.$motor['basepath']).'\',\''.@number_format($motor['price']).'\');"  class="custom-control-input" type="radio" name="motorSelect" id="motorSelect'.$motor['motor_id'].'" />
                                    <label class="custom-control-label" for="motorSelect'.$motor['motor_id'].'"> '.$motor['motorname'].' <small>'.$motor['description'].'</small> </label>                             
                        ';
                if(	$motor['motorprice']!=0)
                {
                    $basemotor.='<span>Rs. '.number_format($motor['motorprice']).'</span>'; 
                }		
                        
                $basemotor.=' 
                    </div>
                    <div class="d-none motor_view_info" id="motor_view_info_'.$motor['motor_id'].'">
                    <a href="#" class="link" onclick="callMotorModal('.$motor['motor_id'].','.$motor['motor_base_id'].')">view info</a>
                    </div>
                </div>';
                $count++; 
            }
            $basemotor.='</div> </div> 
                <div class="col-12"> <div class="next-btn">
                    <button type="button" class="black-btn" id="motor-prev">Previous</button>
                    <button disabled type="button" class="red-btn"   href="#" id="motor-next">Accept</button>
                </div></div>'.$hint_text;	
        }
			
		$data_arr   = array("status"=>200,
						"data_html"=>"",
						"totprice"=>number_format($price),
						"jarcount"=>$jarcount,
						"motor_html"=>$basemotor,
						"selecteditem"=>$selecteditem['strselecteditem'],
						"selecteditembase"=>$selecteditem['strselecteditem_base'],
						"error_msg"=>"");
	
	 	echo json_encode($data_arr);
		exit();
    }
	
	
 public function removeotherjars(){
	
		  $id=$this->input->post('bid');
			$cart_id=$this->getCartId();
			
			if($cart_id)
			{
				  $order=array(
                'field'=>'sortby',
                'type'=> 'desc'
					);
				$where=array("p.isactive"=>"1",
					  "p.base_id"=>	$id);
		 $order=array(
                'field'=>'name',
                'type'=> 'desc'
            );	  
					  
				$alljarlist = $this->CustomizeModel->combinebasejarexcludeids('list',$where,'','','');
				//print_r($this->db->last_query());
				//print_r($alljarlist);
				//die();
				
				$this->db->where_in('jar_id',explode(",",$alljarlist->jar_id));
				
				 $updateData=array(						
						'Isactive'     => "2",
						'ModifiedDate' => date('Y-m-d H:i:s')
						);
				 $result = $this->FunctionModel->Update($updateData,'vidiem_cart_jar',array('cart_id' => $cart_id,"isactive"=>1));
				 
				
			}
	
			$price=$this->calculatecartprice($cart_id);	
			$selecteditem=$this->getselecteditems($cart_id);	
				
			
			$jarcount = $this->CustomizeModel->getCartJarCount($cart_id);
			
			
			
			$data_arr=array("status"=>200,
						"data_html"=>"",
						"totprice"=>number_format($price),
						"jarcount"=>$jarcount,
						"selecteditem"=>$selecteditem['strselecteditem'],
						"selecteditembase"=>$selecteditem['strselecteditem_base'],
						"error_msg"=>"");
	
	 	echo json_encode($data_arr);
		exit();
    }
	
	
	public function jarfillterlist(){
		$bid    = $this->input->post('hidbid');
	    $order  = array( 'field'=>'sortby', 'type'=> 'desc' );
		$where  = array( "p.isactive"=>"1", "p.base_id"=> $bid );
	    if(count($this->input->post('typeofjar'))>0){			  
	        $this->db->where_in("tj.typeofjar_id",$this->input->post('typeofjar'));
	    }
	   if(count($this->input->post('typeofhandle'))>0){			  
	        $this->db->where_in("th.typeofhandle_id",$this->input->post('typeofhandle'));
	    }
	  
        if(count($this->input->post('typeoflid'))>0){			  
            $this->db->where_in("tl.typeoflid_id",$this->input->post('typeoflid'));
        }
            
        if(count($this->input->post('capacity'))>0){			  
            $this->db->where_in("cc.capacity_id",$this->input->post('capacity'));
        }
	  
	    $order = array(
                'field'=>'name',
                'type'=> 'desc'
            );
	  
        $alljarlist = $this->CustomizeModel->combinebasejarexclude('list',$where,'','',$order);
        
        $cart_id = $this->getCartId();
		$cartJars = $this->CustomizeModel->getJarCountByCardId($cart_id);
        $JarCount = [];
        foreach($cartJars as $cartJar) {
            $JarCount[$cartJar->jar_id] = $cartJar->qty;
        }	
		$otherjar = '  <div class="model-jars">';
		
        if(count($alljarlist)>0) {		
            foreach($alljarlist as $jar) {
                if(!empty($JarCount[$jar['jar_id']])) {
                    $qty = $JarCount[$jar['jar_id']];
                }else {
                    $qty = 0;
                }
				  $description = (!empty($jar['description']) && $jar['description'] != '') ?  '' : "";
				 $otherjar.='<div class="select-jar selectedjar-'.$jar['jar_id'].'">
                                 <a href="javascript:void(0)" onclick="return getJarView( '.$jar['jar_id'].' )">
                                    '.$description.'
                                     <img src="'.base_url("uploads/customizeimg/jar/".$jar['basepath']).'" alt="" class="img-fluid"/>
                                 </a>
                              
                           
                                 <span class="jar-name">'.$jar['name'].'</span>
                                 <span>Rs. '.number_format($jar['price']).'</span>                                            
                                    <div class="plus-minus">
                                        <button type="button" class="red-btn init-button" data-jar-id="'.$jar['jar_id'].'">
                                            Add
                                        </button>    
                                       <div class="input-group" id="jar-id-'.$jar['jar_id'].'" style="display:none">
                                          <span class="input-group-prepend">
                                          <button type="button" class="btn btn-number" disabled="disabled" data-type="minus" data-field="quant['.$jar['jar_id'].']">
                                          <span class="fa fa-minus"></span>
                                          </button>
                                          </span>
                                          <input type="text" id="qtyinp_'.$jar['jar_id'].'" name="quant['.$jar['jar_id'].']" class="form-control input-number" value="0" min="0" max="10">
                                          <span class="input-group-append">
                                          <button type="button" class="btn btn-number jar-plus" id="jar-id-inc-'.$jar['jar_id'].'" data-type="plus" data-field="quant['.$jar['jar_id'].']">
                                          <span class="fa fa-plus"></span>
                                          </button>
                                          </span>
                                       </div>
                                    </div>
                                 <i class="fa fa-check-circle" aria-hidden="true"></i>
                              </div>';
                /*$otherjar.='<div class="select-jar selectedjar-'.$jar['jar_id'].'">
                                    <a href="javascript:void(0)" onclick="return getJarView( '.$jar['jar_id'].' )">
                                  <img src="'.base_url("uploads/customizeimg/jar/".$jar['basepath']).'" alt="" class="img-fluid"/>
                                </a>
                                 <span class="jar-name">'.$jar['name'].'</span>
                                 <span>Rs. '.number_format($jar['price']).'</span>                                            
                                 <div class="plus-minus">
                                    <div class="input-group">
                                       <span class="input-group-prepend">
                                       <button type="button" class="btn btn-number" disabled="disabled" data-type="minus" data-field="quant['.$jar['jar_id'].']">
                                       <span class="fa fa-minus"></span>
                                       </button>
                                       </span>
                                       <input type="text" id="qtyinp_'.$jar['jar_id'].'" name="quant['.$jar['jar_id'].']" class="form-control input-number" value="'.$qty.'" min="0" max="10">
                                       <span class="input-group-append">
                                       <button type="button" class="btn btn-number jar-plus" data-type="plus" data-field="quant['.$jar['jar_id'].']">
                                       <span class="fa fa-plus"></span>
                                       </button>
                                       </span>
                                    </div>
                                 </div>
                                 <i class="fa fa-check-circle" aria-hidden="true"></i>
                              </div>
                             ';  */
            }
        }else{
            $otherjar.=' <div class="select-jar ">
                            No jar found
                        </div>';
        }					
        $otherjar       .='     </div><script> $(".init-button").click(function(e) {
                    e.preventDefault();
                    let jarId = $(this).data("jar-id");
                    $(`#jar-id-${jarId}`).show();
                    $(this).hide();
                    $(`#jar-id-inc-${jarId}`).trigger("click");
                });</script> ';	
            
        $data_arr       = array(
                            "status"=>200,
                            "other_jar_html"=>$otherjar,						
                            "error_msg"=>""
                        );	
        echo json_encode($data_arr);
        exit();

    }
	
	public function getCartId()
	{
		
		$client_id = $this->session->userdata('client_id');
        $dealer_session = $this->session->userdata('dealer_session');
				
        if($client_id!="")
        {
            $cartexist = $this->CustomizeModel->getDataActiveById($client_id,"vidiem_carts","customer_id");
            if( !$cartexist) 
            {

                $InsertData     = array(
                                    'customer_id'  => $client_id,
                                    'sessionId'    => "0",
                                    'IsActive'     => "1",
                                    'CreatedDate'  =>date('Y-m-d H:i:s'),
                                    'ModifiedDate' => date('Y-m-d H:i:s')
                                );

                $cart_id        = $this->FunctionModel->Insert($InsertData,'vidiem_carts');
                
                $updateData     = array(						
                                    'cartcode'     => "VC".str_pad($cart_id,5,'0',STR_PAD_LEFT)
                                );
                $result = $this->FunctionModel->Update($updateData,'vidiem_carts',array('cart_id' => $cart_id));
                
            }
            else{
                $cart_id        = $cartexist->cart_id;
            }
            
        } else if( isset( $dealer_session ) && !empty( $dealer_session ) ) {

                $cartexist          = $this->CustomizeModel->getDataActiveById($dealer_session['user']['id'],"vidiem_carts","dealer_user_id");
                if( !$cartexist ) {
                    $InsertData     = array(
                                        'customer_id'       => $client_id,
                                        'sessionId'         => session_id(),
                                        'IsActive'          => "1",
                                        'CreatedDate'       => date('Y-m-d H:i:s'),
                                        'ModifiedDate'      => date('Y-m-d H:i:s'),
                                        'dealer_user_id'    => $dealer_session['user']['id'],
                                        'dealer_id'         => $dealer_session['dealer']['id'],
                                    );

                    $cart_id        = $this->FunctionModel->Insert($InsertData,'vidiem_carts');
                    
                    $updateData     = array(						
                                        'cartcode'     => "VC".str_pad($cart_id,5,'0',STR_PAD_LEFT)
                                    );
                    $result         = $this->FunctionModel->Update($updateData,'vidiem_carts',array('cart_id' => $cart_id));
                } else {
                    $cart_id        = $cartexist->cart_id;
                }

            } else {
				$cartexist = $this->CustomizeModel->getDataActiveById(session_id(),"vidiem_carts","sessionId");
				if( !$cartexist) 
				{
				 $InsertData=array(
                'customer_id'  => "0",
                'sessionId'    => session_id(),
                'IsActive'     => "1",
                'CreatedDate'  =>date('Y-m-d H:i:s'),
                'ModifiedDate' => date('Y-m-d H:i:s')
				);
				$cart_id=$this->FunctionModel->Insert($InsertData,'vidiem_carts');
				
				 $updateData=array(						
						'cartcode'     => "VC".str_pad($cart_id,5,'0',STR_PAD_LEFT)
						);
				 $result = $this->FunctionModel->Update($updateData,'vidiem_carts',array('cart_id' => $cart_id));
				
				}
				else{
					$cart_id=$cartexist->cart_id;
				}
			}
			return $cart_id;
		
	}
    public function calculatecartprice($cartid)
	{
		 $cartarr = $this->CustomizeModel->getDataActiveById($cartid,"vidiem_carts","cart_id");
		
	
				if($cartarr->cart_id)
				{
					 $this->db->select(" (if(b.base_id is not null and b.price is not null, b.price,'0')
											+
											 if( bc.bm_color_id is not null and bc.price is not null, bc.price,'0')
											+
											if( m.motor_id is not null and m.price is not null, m.price,'0')
											+
											 if( p.package_id is not null and  p.price is not null, p.price,'0')
											+
											 if( d.canvas_text is not null and d.canvas_text<>'' and bt.price is not null, bt.price,'0')	 
											 ) as price");
											 
					$this->db->join('vidiem_cart_details  d',' d.cart_id=c.cart_id and d.Isactive=1 ');	
					$this->db->join('vidiem_basemodel b',' b.base_id=d.base_id ', 'left');	
					$this->db->join('vidiem_basemodel_color bc',' bc.bm_color_id=d.base_color_id ', 'left');	
					$this->db->join('vidiem_motors m',' m.motor_id=d.motor_id ', 'left');	
					$this->db->join('vidiem_packages p',' p.package_id=d.package_id ', 'left');	
					$this->db->join('vidiem_basemodel_text bt',' bt.base_id=d.base_id ', 'left');	
					$this->db->where(" c.IsActive=1 ");
					$this->db->where(" c.cart_id= ".$cartarr->cart_id);
					
					$dataarr= $this->db->get_where(' vidiem_carts c ')->result_array();
					

					

					 $this->db->select(" sum(cj.qty*j.price) as price");
					 $this->db->join('vidiem_cart_jar  cj',' cj.cart_id=c.cart_id and cj.Isactive=1 ');			
				  	$this->db->join('vidiem_jar j',' j.jar_id=cj.jar_id and j.isactive=1 ');
					
					$this->db->where(" c.IsActive=1 ");
					$this->db->where(" c.cart_id= ".$cartarr->cart_id);
					
					$jarpricearr= $this->db->get_where(' vidiem_carts c ')->result_array();
					
					return ($dataarr[0]['price']+$jarpricearr[0]['price']);
				}
				return '0';

	}
	
	public function chkcondition()
	{
			$headid=$this->input->post('headid');
			
			$chkheadarr= array("2"=>array("basemodel"),
							   "3"=>array("basemodel","basecolor"),
							   "4"=>array("basemodel","basecolor","basejar"),
							   "5"=>array("basemodel","basecolor","basejar","basemotor"),
							   "6"=>array("basemodel","basecolor","basejar","basemotor"));
		  
			if(array_key_exists($headid,$chkheadarr))
			{
				
				$cart_id=$this->getCartId();
				foreach($chkheadarr[$headid] as $key=>$code)
				{
					$where=array("cart_id"=>$cart_id,
								"isactive"=>"1");
									  
					$cartarr = $this->CustomizeModel->getDataArrMultCond("vidiem_cart_details",$where);
					
					 
					
					switch($code)
					{
						case "basemodel":
						
										
											if(!$cartarr->base_id)
											{
												$data_arr=array("status"=>0,	
																"ind"=>$key+1,
																"error_msg"=>"Please choose base model");
												echo json_encode($data_arr);
												exit();					
												
											}
						
											break;
						case "basecolor":
											if(!$cartarr->base_color_id)
											{
												$data_arr=array("status"=>0,	
																"ind"=>$key+1,
																"error_msg"=>"Please choose base model color");
												echo json_encode($data_arr);
												exit();
											}
						
											break;	

					   case "basejar":
											$jarcount = $this->CustomizeModel->getCartJarCount($cart_id);
											
											if(!$jarcount)
											{
												$data_arr=array("status"=>0,	
																"ind"=>$key+1,
																"error_msg"=>"Please choose jar ");
												echo json_encode($data_arr);
												exit();				
												
											}
						
											break;

						case "basemotor":
											if(!$cartarr->motor_id)
											{
												$data_arr=array("status"=>0,	
																"ind"=>$key+1,
																"error_msg"=>"Please choose motor");
												echo json_encode($data_arr);
												exit();				
												
											}
						
											break;								
						
					}
				}

			}
			
				$data_arr=array("status"=>200,						
								"error_msg"=>"");				   
				echo json_encode($data_arr);
				exit();			 
						
		
	}
	
	
    public function getselecteditems($cartid)
	{
		 $cartarr = $this->CustomizeModel->getDataActiveById($cartid,"vidiem_carts","cart_id");		
		$strselecteditem="";	
		$strselecteditem_base="";
				if($cartarr->cart_id)
				{
					 $this->db->select(" b.base_id,b.basetitle, b.price as baseprice,bc.bm_color_id,bc.title, bc.price as colorprice,m.motor_id,m.motorname, m.price as motorprice,p.package_id,p.packagename, p.price as package_price,d.canvas_text, bt.price as canvas_price	");
											 											 
					$this->db->join('vidiem_cart_details  d',' d.cart_id=c.cart_id and d.Isactive=1 ');	
					$this->db->join('vidiem_basemodel b',' b.base_id=d.base_id ', 'left');	
					$this->db->join('vidiem_basemodel_color bc',' bc.bm_color_id=d.base_color_id ', 'left');	
					$this->db->join('vidiem_motors m',' m.motor_id=d.motor_id ', 'left');	
					$this->db->join('vidiem_packages p',' p.package_id=d.package_id ', 'left');	
					$this->db->join('vidiem_basemodel_text bt',' bt.base_id=d.base_id ', 'left');	
					$this->db->where(" c.IsActive=1 ");
					$this->db->where(" c.cart_id= ".$cartarr->cart_id);
					
					$dataarr= $this->db->get_where(' vidiem_carts c ')->result_array();
					

					 $this->db->select("cj.cart_jar_id, j.jar_id,j.name,j.basepath,cj.qty,j.price ");
					 $this->db->join('vidiem_cart_jar  cj',' cj.cart_id=c.cart_id and cj.Isactive=1 ');			
				  	$this->db->join('vidiem_jar j',' j.jar_id=cj.jar_id and j.isactive=1 ');
					
					$this->db->where(" c.IsActive=1 ");
					$this->db->where(" c.cart_id= ".$cartarr->cart_id);
					
					$jarpricearr= $this->db->get_where(' vidiem_carts c ')->result_array();
					
					
					if(!empty($dataarr[0]['base_id']))
					{
					//$strselecteditem_base.='<div class="selected-body">Body: <strong>'.$dataarr[0]['basetitle'].'</strong>					<span class="selected-body-price">Rs.'.number_format($dataarr[0]['baseprice']).'</span></div>';
					
					$strselecteditem_base.='<div class="selected-body">Body: <strong>'.$dataarr[0]['basetitle'].'</strong></div>';
					
					}
					
					if(!empty($dataarr[0]['bm_color_id']))
					{
					$strselecteditem_base.='   <div class="selected-color">Color: <strong>'.$dataarr[0]['title'].'</strong><span class="selected-color-price">Rs.'.number_format($dataarr[0]['colorprice']).'</span></div>';
					}
					
					if(count($jarpricearr)>0)
					{
						foreach($jarpricearr as $jar)
						{
							
							$strselecteditem.=' <div class="selected-jars">
						<span class="text-center">'.$jar['name'].'</span>
						<img src="'.base_url("uploads/customizeimg/jar/".$jar['basepath']).'" alt="" class="img-fluid"/>
						<div class="row no-gutters">
							<div class="col">
								<div class="jar-qty">Qty: '.$jar['qty'].'</div>
							</div>
							<div class="col">
								<div class="jar-pri">Rs.'.number_format( $jar['price']*$jar['qty']).'</div>
							</div>
						</div>
						<button type="button" onclick="fnjardelete('.$jar['cart_jar_id'].','.$jar['jar_id'].')" class="remove-jar"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
					</div> ';
							
						}
						
					}
					
					if(!empty($dataarr[0]['motor_id']))
					{
					$strselecteditem_base.='   <div class="selected-color">Motor: <strong>'.$dataarr[0]['motorname'].'</strong><span class="selected-color-price">Rs.'.number_format($dataarr[0]['motorprice']).'</span></div>';
					}
					
					if(!empty($dataarr[0]['canvas_text']) && $dataarr[0]['canvas_text']!='')
					{
					$strselecteditem_base.='   <div class="selected-color">Imported Text: <strong>'.$dataarr[0]['canvas_text'].'</strong><span class="selected-color-price">Rs.'.number_format($dataarr[0]['canvas_price']).'</span></div>';
					}
					
					if(!empty($dataarr[0]['package_id']) && $dataarr[0]['package_id']!='')
					{
					$strselecteditem_base.='   <div class="selected-color">Package: <strong>'.$dataarr[0]['packagename'].'</strong><span class="selected-color-price">Rs.'.number_format($dataarr[0]['package_price']).'</span></div>';
					}
					
				}
				return array("strselecteditem_base"=>$strselecteditem_base,"strselecteditem"=>$strselecteditem);

	}
	
	
	public function customize_cart() {

        $dealer_session             = $this->session->userdata('dealer_session');
        
        if( isset( $dealer_session ) && $dealer_session['user']['user_type'] != 'sale_person') {
            redirect('dealer-admin');
        }
        
        $data['menu_id']        = 0;
        $client_id              = $this->session->userdata('client_id');
        $data['client_id']      = $client_id;
        $cart_id                = $this->CheckCartId();
        
        if( !$cart_id )
        {
            redirect('vidiem-by-you');
        }
    
        $data['cartitems']      = $this->getCartitems($cart_id);
        $data['totprice']       = $this->calculatecartprice($cart_id);
        
        $cart_qty               = 0;
        if(count($data['cartitems']['jarinfo'])>0)
        {
            foreach($data['cartitems']['jarinfo'] as $jar) {
                $cart_qty      += $jar['qty'];
            }
        }
        // print_r( $data );die;
        $data['packageprice']   = $this->CustomizeModel->calculatepackageprice($cart_id,$data['cartitems']['bodyinfo'][0]['base_id'],$cart_qty);
        
        $this->session->set_userdata('previous_url', 'customize-cart');
        $this->session->unset_userdata('coupon');
        $this->load->view('customize-cart',@$data);

    }
	 
	
    public function getCartitems($cartid)
	{
		 $cartarr = $this->CustomizeModel->getDataActiveById($cartid,"vidiem_carts","cart_id");		
		$cartitems=array();	
				if($cartarr->cart_id)
				{
					 $this->db->select(" c.cartcode,b.base_id,b.basetitle,b.basepath as bodyimg, b.price as baseprice,bc.bm_color_id,bc.title,bc.basepath as bodycolorimg , bc.price as colorprice,m.motor_id,m.motorname,m.basepath as motorimg , m.price as motorprice,p.package_id,p.packagename,p.basepath as packageimg  , p.price as package_price,d.canvas_text, bt.price as canvas_price,c.cart_id,c.cartcode,cat.name as catname,bt.bm_text_id,bt.desktopleft,bt.desktoptop,d.message_text,d.occasion_text ");
											 											 
					$this->db->join('vidiem_cart_details  d',' d.cart_id=c.cart_id and d.Isactive=1 ');	
					$this->db->join('vidiem_basemodel b',' b.base_id=d.base_id ', 'left');	
					$this->db->join('vidiem_basemodel_color bc',' bc.bm_color_id=d.base_color_id ', 'left');	
					$this->db->join('vidiem_motors m',' m.motor_id=d.motor_id ', 'left');	
					$this->db->join('vidiem_packages p',' p.package_id=d.package_id ', 'left');	
					$this->db->join('vidiem_basemodel_text bt',' bt.base_id=d.base_id ', 'left');
					$this->db->join('vidiem_category cat',' cat.id=c.category_id and cat.status=1 ');
					$this->db->where(" c.IsActive=1 ");
					$this->db->where(" c.cart_id= ".$cartarr->cart_id);
					
					$dataarr= $this->db->get_where(' vidiem_carts c ')->result_array();
					

					 $this->db->select("cj.cart_jar_id, j.jar_id,j.name,j.basepath,cj.qty,j.price, vtj.typeofjarname as type_name,vc.capacityname as capacity_name, vth.typeofhandlename as handle_name, vtl.typeoflidname as lid_name ");
					 $this->db->join('vidiem_cart_jar  cj',' cj.cart_id=c.cart_id and cj.Isactive=1 ');			
				  	$this->db->join('vidiem_jar j',' j.jar_id=cj.jar_id and j.isactive=1 ');
                    $this->db->join('vidiem_typeofjar vtj',' vtj.typeofjar_id=j.typeofjar_id and vtj.isactive = 1');
                    $this->db->join('vidiem_capacity vc',' vc.capacity_id=j.capacity_id and vc.isactive = 1');
                    $this->db->join('vidiem_typeofhandle vth',' vth.typeofhandle_id=j.typeofhandle_id and vc.isactive = 1');
                    $this->db->join('vidiem_typeoflid vtl',' vtl.typeoflid_id=j.typeoflid_id and vc.isactive = 1');
                    
					$this->db->where(" c.IsActive=1 "); 
					$this->db->where(" c.cart_id= ".$cartarr->cart_id);
					
					$jarpricearr= $this->db->get_where(' vidiem_carts c ')->result_array();
					
					
					
				}
				$cartitems=array("bodyinfo"=>$dataarr,
								 "jarinfo"=>$jarpricearr);	
				return $cartitems;

	} 
	 
	 
	public function CheckCartId()
	{
		
		$client_id              = $this->session->userdata('client_id');
        $dealer_session         = $this->session->userdata('dealer_session');
		
        if( $client_id != "" )
        {
            $cartexist          = $this->CustomizeModel->getDataActiveById($client_id,"vidiem_carts","customer_id");
            if($cartexist) 
            {
            
                $cart_id        = $cartexist->cart_id;
            }
            
        } else if( isset( $dealer_session ) && !empty( $dealer_session ) ) {

            $cartexist          = $this->CustomizeModel->getDataActiveById($dealer_session['user']['id'],"vidiem_carts","dealer_user_id");
            $cart_id            = $cartexist->cart_id;

        } else {

            $cartexist          = $this->CustomizeModel->getDataActiveById(session_id(),"vidiem_carts","sessionId");
            if($cartexist) 
            {				
                $cart_id        = $cartexist->cart_id;
            }

        }
        return $cart_id;
		
	}

	 
    public function customize_checkout() {

        $dealer_session             = $this->session->userdata('dealer_session');
        
        if( isset( $dealer_session ) && $dealer_session['user']['user_type'] != 'sale_person') {
            redirect('dealer-admin');
        }
        
		$cart_id                    = $this->CheckCartId();	
        // ss( $cart_id );
        if(isset( $cart_id ) && !empty( $cart_id ) ) {
		    
		} else
		{
            redirect('vidiem-for-you');
		}
		
		$cartitems                  = $this->getCartitems($cart_id); 
		 
        if(!empty($cartitems['bodyinfo'][0]['base_id']) && !empty($cartitems['bodyinfo'][0]['bm_color_id']) && !empty($cartitems['bodyinfo'][0]['motor_id']) && count($cartitems['jarinfo'])>0 ){	

            $data['totprice']       = $this->calculatecartprice($cart_id);	
            $data['cartitems']      = $cartitems;
		    $this->session->set_userdata('previous_url', 'customize-checkout'); 
            $cart_qty               = 0;
            if(count($cartitems['jarinfo'])>0)
            {
                foreach($cartitems['jarinfo'] as $jar){
                    $cart_qty       += $jar['qty'];
                }
            }
            
			$data['packageprice']   = $this->CustomizeModel->calculatepackageprice($cart_id,$cartitems['bodyinfo'][0]['base_id'],$cart_qty);
		
            $client_id              = $this->session->userdata('client_id');		
            $data['client_id']      = $client_id;
            if(empty($this->input->post('from_cart'))){
                $coupon             = $this->session->userdata('coupon');
            }else{
                $coupon             = $this->input->post('coupon');
            }
            if(!empty($coupon) && !empty($client_id)){
                $data['discount']   = $this->ProjectModel->coupon_discount($coupon);
                $data['discount']['code'] = $coupon;
            }
            $data['menu_id']=0;
            if(!empty($client_id)) {
                $data['shipping_address']   = $this->FunctionModel->Select_Fields('id,type,title,name,address,city,zip_code,state,country,mobile_no','vidiem_clients_address',array('client_id'=>$client_id,'type'=>1)); 
                $data['billing_address']    = $this->FunctionModel->Select_Fields('id,type,title,name,address,city,zip_code,state,country,mobile_no','vidiem_clients_address',array('client_id'=>$client_id,'type'=>2)); 
            }
            $data['ship_id']        = $this->input->get('shipping_id');
            $data['bill_id']        = $this->input->get('billing_id');
            $data['same']           = $this->input->get('same');

            if(!empty($data['same'])){$data['same']=0;}
            $data['loginURL']       = $this->google->loginURL();
            $data['FbloginUrl']     = $this->facebook->loginUrl();
            $this->load->view('customize-account-shipping',@$data);

        } else {
			redirect('vidiem-by-you');
		}

    }

    public function custompayment() {
		
        $client_id      = $this->session->userdata('client_id');
        
		$cart_id        = $this->CheckCartId();	

		if(!$cart_id)
		{
            redirect('vidiem-by-you');
		}
		
		$cartitems      = $this->getCartitems($cart_id); 
		 
        if(empty($cartitems['bodyinfo'][0]['base_id']) || empty($cartitems['bodyinfo'][0]['bm_color_id']) || empty($cartitems['bodyinfo'][0]['motor_id']) || count($cartitems['jarinfo'])==0 ){
		
            $this->session->set_flashdata('title', "Error..");  
            $this->session->set_flashdata('msg', "Cart Empty");  
            $this->session->set_flashdata('type', "warning");
            redirect('','refresh');
        }
       
		extract($_REQUEST);
		
        if(($shippingaddressid!='' && $shippingmethodid!='' && $confirmcart!='') || $client_id==''){
			
            $code                       = $this->CustomizeModel->CustomOrderCode();
			
			if( $client_id != '' ) { //Login User

				$delivery_address       = $shippingaddressid;
				
				if($billingaddressid=='') {
					$billing_address    = $delivery_address;
				}else{
					$billing_address    = $billingaddressid;
				}
				$devliver_info          = $this->FunctionModel->Select_Row('vidiem_clients_address',array('id'=>$delivery_address));
				$billing_info           = $this->FunctionModel->Select_Row('vidiem_clients_address',array('id'=>$billing_address));
				$clientid               = $client_id;
				
			} else { 
                // Guest User
				
				$sessionid              = $this->session->session_id;
				$devliver_info          = $this->FunctionModel->Select_Row('vidiem_clients_address',array('client_id'=>$sessionid,'type'=>1),'id','desc');
				
                if(empty($devliver_info)){
                    $this->session->set_flashdata('title', "Error..");  
                    $this->session->set_flashdata('msg', "Please add your shipping address");  
                    $this->session->set_flashdata('type', "warning");
                    redirect('checkout','refresh');
                }
				
				if($same_billing=='1') {
					$billing_info   = $devliver_info;
				} else {
					$billing_info   = $this->FunctionModel->Select_Row('vidiem_clients_address',array('client_id'=>$sessionid,'type'=>2),'id','desc');
					
					if( empty($billing_info) ) {
						$this->session->set_flashdata('title', "Error..");  
						$this->session->set_flashdata('msg', "Please add your billing address");  
						$this->session->set_flashdata('type', "warning");
						redirect('checkout','refresh');
					}
				}
				$clientid   = 0;
				
			}
			
			$cart_qty       = 0;
        if(count($cartitems['jarinfo'])>0)
        {
            foreach($cartitems['jarinfo'] as $jar){
                $cart_qty   += $jar['qty'];
            }
        }
			
        $packageprice       = $this->CustomizeModel->calculatepackageprice($cart_id,$cartitems['bodyinfo'][0]['base_id'],$cart_qty);
			
        $total              = $this->calculatecartprice($cart_id);
        $coupon             = $couponcode;
        $discount           = $this->ProjectModel->coupon_discount($coupon);

        if( isset( $_SESSION['customer_order_coupon_amount'] ) && !empty( $_SESSION['customer_order_coupon_amount'] ) ) { 
            $discount       =  array(
                                'amount' => $_SESSION['customer_order_coupon_amount'],
                                'id' => $_SESSION['custom_coupon_id'],
                                'type' => $_SESSION['coupon_type'],
                                'value' => '',
                                'code' => $_SESSION['custom_coupon_code']
                            );
            unset( $_SESSION['customer_order_coupon_amount'] );
            unset( $_SESSION['custom_coupon_code'] );
            unset( $_SESSION['custom_coupon_id'] );
            unset( $_SESSION['coupon_type'] );
        }
        // ss( $discount );
        $amount             = $total - $discount['amount'];
        $amount             = $amount + $packageprice['price'];
				
        $InsertData         = array(

                                'code'                  => $code,
                                'cart_code'				=> $cartitems["bodyinfo"][0]["cartcode"],
                                'order_no'              => generateDealerOrderId(),
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
                                'delivery_emailid'      => $devliver_info['emailid'],
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
                                'billing_emailid'       => $billing_info['emailid'],
                                'billing_add_info'      => $billing_info['add_information'],
                                'coupon'                => $coupon,
                                'coupon_id'             => $discount['id'],
                                'coupon_type'           => $discount['type'],
                                'coupon_value'          => $discount['value'],
                                'sub_total'             => $total,
                                'tax'                   => $total-(($total/(TAXNEW+100))*100), // TAX variable define from confiq
                                'discount'              => $discount['amount'],
                                'packageprice'			=> $packageprice['price'],
                                'amount'                => round($amount),
                                'status'                => 1,
                                'created'               => date('Y-m-d H:i:s'),
                                'dealer_user_id'        => $this->session->userdata('dealer_session')['user']['id'] ?? null,
                                'dealer_id'             => $this->session->userdata('dealer_session')['dealer']['id'] ?? null,
                                'dealer_location_id'    => $this->session->userdata('dealer_session')['user']['location_id'] ?? null

                            );
        
        $order_id           = $this->FunctionModel->Insert($InsertData,'vidiem_customorder');

        if($order_id!='') {
            
            $InsertData = array(                   
                                "order_id"=>$order_id,
                                "base_id"=>$cartitems["bodyinfo"][0]["base_id"],
                                "basetitle"=>$cartitems["bodyinfo"][0]["basetitle"],
                                "basepath"=>$cartitems["bodyinfo"][0]["bodyimg"],
                                "baseprice"=>$cartitems["bodyinfo"][0]["baseprice"],
                                "bc_id"=>$cartitems["bodyinfo"][0]["bm_color_id"],
                                "bc_title"=>$cartitems["bodyinfo"][0]["title"],
                                "basecolorpath"=>$cartitems["bodyinfo"][0]["bodycolorimg"],
                                "basecolorprice"=>$cartitems["bodyinfo"][0]["colorprice"],
                                "motor_id"=>$cartitems["bodyinfo"][0]["motor_id"],
                                "motorname"=>$cartitems["bodyinfo"][0]["motorname"],
                                "motorbasepath"=>$cartitems["bodyinfo"][0]["motorimg"],
                                "motorprice"=>$cartitems["bodyinfo"][0]["motorprice"],
                                "bm_text_id"=>$cartitems["bodyinfo"][0]["bm_text_id"],
                                "desktopleft"=>$cartitems["bodyinfo"][0]["desktopleft"],
                                "desktoptop"=>$cartitems["bodyinfo"][0]["desktoptop"],
                                "textprice"=>$cartitems["bodyinfo"][0]["canvas_price"],
                                "canvas_text"=>$cartitems["bodyinfo"][0]["canvas_text"],
                                "message_text"=>$cartitems["bodyinfo"][0]["message_text"],
                                "occasion_text"=>$cartitems["bodyinfo"][0]["occasion_text"],
                                "package_id"=>$cartitems["bodyinfo"][0]["package_id"],
                                "packagename"=>$cartitems["bodyinfo"][0]["packagename"],
                                "packagebasepath"=>$cartitems["bodyinfo"][0]["packageimg"],
                                "packageprice"=>$cartitems["bodyinfo"][0]["package_price"],
                                "IsActive"=>"1",
                                "CreatedDate"=>date("Y-m-d H:i:s")
                               	
                            );
            $this->FunctionModel->Insert($InsertData,'vidiem_custom_order_products');
           
            foreach ($cartitems["jarinfo"] as $jar) {
                $InsertData=array(
                    'order_id'  => $order_id,
                    'cart_jar_id'=> $jar['cart_jar_id'],
                    'jar_id'      => $jar['jar_id'],
                    'jarname'      => $jar['name'],
                    'jarimgpath'     => $jar['basepath'],
                    'qty'     => $jar['qty'],
                    'price'       => $jar['price'],
                    "IsActive"=>"1",
					"CreatedDate"=>date("Y-m-d H:i:s")
                );
                $this->FunctionModel->Insert($InsertData,' vidiem_custom_order_jars');
            }

            /**** check if payment mode is online or counter */
            $payment_select_method = $this->input->post('payment_select_method', true );
            if( isset( $payment_select_method ) && $payment_select_method == 'counter' ) {

                //do offline
                $code               = $this->FunctionModel->Select_Field('inv_code','vidiem_customorder',array('id'=>$order_id),'inv_code','DESC',1);
            
                if( empty( $code ) ) {
                    
                    $UpdateData     = array(
                                        'payment_source'=> "counter",
                                        // 'pg_type'       => 'ord_'.date('ymdhis'),
                                        'payment_status'=> 'pending',
                                        'modified'      => date('Y-m-d H:i:s')
                                    );
                    $this->FunctionModel->Update($UpdateData,'vidiem_customorder',array('id'=>$order_id));
                }    
                    
                $cart_id            = $this->CheckCartId();	
                    
               // $this->CustomizeModel->Custom_NewOrderNotification($order_id);
               $order_pass_type='Showing interest';
                $this->CustomizeModel-> CustomerInvoiceDealer($order_id,$order_pass_type);
               // $this->CustomizeModel->Custom_NewOrderNotification($order_id);
                    
                $this->CustomizeModel->Cartdestroy($cart_id);
                // $this->CustomizeModel->CustomOrderInvoicing($order_id); 

                $responses = array( 
                                'order_id' => $order_id,
                                'pay_type' => 'counter'
                            );
                echo $json = json_encode($responses);

            } else {

                $client_id          = $this->session->userdata('client_id');
                    
                if($client_id!='' && isset($client_id)) { //Login User
                    $clt=$this->FunctionModel->Select_Fields_Row('email,mobile_no','vidiem_clients',array('id'=>$client_id));
                    $firstname = $this->session->userdata('client_name');
                    $email = $clt['email'];
                    $mobile = $clt['mobile_no'];
                }else{ //Guest User
                    
                    $firstname = $billing_info['name'];
                    $email = $billing_info['emailid'];
                    $mobile = $billing_info['mobile_no'];
                    
                }
                
                $contact_add= $billing_info['address'].','.$billing_info['address2'].','.$billing_info['city'].','. $billing_info['state'].','. $billing_info['country'].'-'.$billing_info['zip_code'];
                
                $orderData = [
                    'receipt'         => $order_id,
                    'amount'          =>  round($amount) * 100, // 2000 rupees in paise
                    //  'amount'          =>  1 * 100,
                    'currency'        => "INR",
                    'payment_capture' => 1 // auto capture
                ];
                
                $razorOrder =$this->razorpay->CreateOrder($orderData);
                
                $razorpayOrderId = $razorOrder['id'];
                
                $this->session->set_userdata('razorpay_order_id', $razorpayOrderId);
            
                $ci = &get_instance();
                $configs = $ci->config;
        
                $keyId=$configs->config['keyid'];
            
                $data = [
                    "key"               => $keyId,
                    "amount"            => round($amount)* 100,
                    "name"              => "Vidiem Stores",
                    "description"       => "Gas Stoves, Table Top Wet Grinder,Juicer Mixer Grinders",
                    "image"             =>  "https://www.vidiem.in/assets/front-end/images/logo.png",
                    "prefill"           => [
                    "name"              => $firstname,
                    "email"             => $email,
                    "contact"           => $mobile,
                    ],
                    "notes"             => [
                    "address"           => $contact_add,
                    "merchant_order_id" =>$cartitems["bodyinfo"][0]["cartcode"],
                    ],
                    "theme"             => [
                    "color"             => "#F37254"
                    ],
                    "order_id"          => $razorpayOrderId,
                ];
                    
                echo $json = json_encode($data);
            }
		
		?>

		 
		<?php	
        } else{
                redirect('checkout');
            }
        
        } else {
			
			print_r($_POST);
		    echo "errror final";
		    die();
			
            redirect('checkout');
        }
    }	
	   
    public function customize_razorpay_success(){
		 
        $success    = true;
		$error      = "Payment Failed";
		if (empty($_POST['razorpay_payment_id']) === false)
		{
            $razorpay_order_id  = $this->session->userdata('razorpay_order_id');
			$finalorder         = $this->razorpay->FetchOrder($razorpay_order_id);
	
			try
			{      
				$attributes     = array(
                                        'razorpay_order_id' => $razorpay_order_id,
                                        'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                                        'razorpay_signature' => $_POST['razorpay_signature']
                                    );
		   
				$this->razorpay->verifyPaymentSignature($attributes);
			}
				catch(SignatureVerificationError $e)
				{
                    $success = false;
                    redirect('home/payumoney_failure','refresh');
				}
        } else {
				 
            if(isset($_POST['error']))
            {
                $orderdata      = json_decode($_POST['error']['metadata'],true);
                $_POST['razorpay_payment_id'] = $orderdata['payment_id'];
                $finalorder     = $this->razorpay->FetchOrder( $orderdata['order_id']);
            
            }
            
        }
				
        $finalorder             = (array)$finalorder;
        
        $tempdatarr             = array();
        foreach($finalorder as $key=>$orderdata)
        {
            $tempdatarr         = $orderdata;
        }
			   
        $dataarr                = array();
        foreach($tempdatarr as $key=>$val) 
        {
            switch($key)
            {
                case "receipt":
                    $dataarr['order_id'] = $val;
                    break;
                    
                case "status":

                    if($val=="paid")
                    {
                        $status = "paid";
                    }
                    else{
                        $status = "Failure";
                    }
                    break;

                case "id":
                    $dataarr['tracking_id']= $val;
                    break;

                case "payment_mode":
                        $dataarr['payment_mode'] ='';
                
            } 
        } 
        $dataarr['bank_ref_no']     = $_POST['razorpay_payment_id'];
        $dataarr['data']            = $_POST['razorpay_signature'];
					
        if( strtolower($status) == 'paid' ) {
				 // Invoice Code Update
            $order_id           = $dataarr['order_id'];                
            $code               = $this->FunctionModel->Select_Field('inv_code','vidiem_customorder',array('id'=>$order_id),'inv_code','DESC',1);
        
            if( empty( $code ) ) {
                $inv_code       = $this->CustomizeModel->CustomInvoiceCode();
                $UpdateData     = array(
                                    'inv_code'      => $inv_code,
                                    'mihpayid'      => $dataarr['data'],
                                    'payment_source'=> "Razorpay",
                                    'pg_type'       => $dataarr['tracking_id'],
                                    'bank_ref_num'  => $dataarr['bank_ref_no'],
                                    'payment_status'=> 'success',
                                    'modified'      => date('Y-m-d H:i:s')
                                );
                $this->FunctionModel->Update($UpdateData,'vidiem_customorder',array('id'=>$order_id));
            }    

            /**
             * update order history table
             */
            $tracking               = $this->FunctionModel->Select_Field('id','vidiem_order_tracking',array('order_id'=>$order_id, 'order_type' => 'custom_order') );

            if( empty( $tracking ) ) {

                $ins_trac['order_id']       = $order_id;
                $ins_trac['order_type']     = 'custom_order';
                $ins_trac['order_status']   = 1;
                $ins_trac['status_name']    = 'New Order';
                $ins_trac['created_at']     = date('Y-m-d H:i:s');
                $ins_trac['notes']          = 'Order has been created';
                $this->FunctionModel->Insert($ins_trac,' vidiem_order_tracking');

            }
            
            $cart_id            = $this->CheckCartId();	
                
           // $this->CustomizeModel->Custom_NewOrderNotification($order_id);
                
            $this->CustomizeModel->Cartdestroy($cart_id);
            $this->session->set_flashdata('title', "Thank You");     
            $this->session->set_flashdata('msg', "Payment is successfull!");     
            $this->session->set_flashdata('type', "success");
            
            $this->CustomizeModel->CustomOrderInvoicing($order_id); 
        
            redirect('custom-order-success/'.$order_id,'refresh');
        }

    }
		   
    public function custom_order_success_page( $id = null ) {

        $data['menu_id']            = 0;
        if(empty($id)) {
            redirect('');
        }
		 
		$data['orderdetails']       = $this->FunctionModel->Select_Row('vidiem_customorder',array('id'=>$id));
        
        $is_counter_payment         = false;
        $is_dealer_payment          = false;
        if( isset( $data['orderdetails']['payment_source'] ) && $data['orderdetails']['payment_source'] == 'counter' ) {

            $dealer_info            = $this->FunctionModel->Select_Row('vidiem_dealers',array('id'=> $data['orderdetails']['dealer_id']));
            
            $is_counter_payment     = true;
            $is_dealer_payment      = true;
            $message                = 'Your order <strong style="font-weight: 700; color: #000;">#'.$data['orderdetails']['order_no'].'</strong> placed with <strong style="font-weight: 700; color: #000;">'.$dealer_info['display_name'].'</strong> is under process, please pay the payment at bill counter to confirm the order.';
            $title                  = 'Your order is Pending!';
        } else if( isset( $data['orderdetails']['dealer_id'] ) && !empty($data['orderdetails']['dealer_id']) ) { 

            $dealer_info            = $this->FunctionModel->Select_Row('vidiem_dealers',array('id'=>$data['orderdetails']['dealer_id']));
            $is_dealer_payment      = true;
            $message                = 'Your order <strong>#'.$data['orderdetails']['order_no'].'</strong> placed with '.$dealer_info['display_name'].' is confirmed, we will update back with the shipment details by mail.';
            $title                  = 'Your order is Confirmed!';
        } else {
            $message                = 'Your order placed with Vidiem is confirmed, we will update back with the shipment details by mail.';
            $title                  = 'Your order is Confirmed!';
        }

		$data['order_message']      = $message;
        $data['order_title']        = $title;
		$data['basiciteminfo']      = $this->CustomizeModel->getOrderBasicDetails($id);
		$data['jarinfo']            = $this->CustomizeModel->getOrderJarsDetails($id);
        $data['is_counter_payment'] = $is_counter_payment;
        $data['is_dealer_payment']  = $is_dealer_payment;
	
        $this->load->view('custom-order-confirmation',$data);

    } 
	
    public function custominvoice($order_id){
        
        // $order_data=$this->FunctionModel->Select_Row('vidiem_customorder',array('id'=>$order_id));
        
        $order_data_array= $this->FunctionModel->Select_order('vidiem_customorder',array('code'=>$order_id));
         
        $order_data = $order_data_array[0];
         
		$basiciteminfo=	$this->CustomizeModel->getOrderBasicDetails($order_id);
		$jarinfo=$this->CustomizeModel->getOrderJarsDetails($order_id);
		
		
        $client=$this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
        if($client['email']=='')
        {
            $client['email']=$order_data['billing_emailid'];
            
        }
        $template='
    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">';

    $template.="<title>Invocie</title>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900italic,900,300italic,300,100italic,100' rel='stylesheet' type='text/css'>
<link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
<style>
     .inTi li{font-family: arial;list-style: none;padding-top:10px;}
     .fullIn{width:80%;margin: 0 auto;padding:20px 5%;background-color:#f8f8f8; over-flow:hidden; overflow-x:scroll}
     .inCon{ width: 800px;font-family: Roboto, sans-serif; border: solid 2px #00bfff; margin: 0 auto;font-family:arial; box-sizing:border-box; padding: 1% 30px; margin-top:40px; }
</style>
</head>";
    $template.='<body style="margin:0; padding:0;">
    <div class="fullIn">
    <ul class="inTi">
        <li></li>
    </ul>';

    $template.='<div class="container inCon">
        <div style="float:left;"><h1 style="color:#00BFFF;"><img src="'.base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto"/></h1></div>
        <div style="width:30%;float:right;"><h1 style="color:#00BFFF;">PROFORMA INVOICE</h1></div>
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
        <div class="detail" style="float:left; width:35%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:14px; text-transform:uppercase;">No. 3/140, Old Mahabalipuram Road,
Oggiam Thoraipakkam,<br>Chennai - 600097, Tamilnadu, INDIA.</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Landline</span> : &nbsp; 044-6635 6635 / 77110 06635
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Website</span> : &nbsp; http://vidiem.in/
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">GST NO</span> : &nbsp; 33AAACM6280D1ZT
                </li>
            </ul>
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">BILL TO </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_name'].'
                </li>';
                if(!empty($order_data['billing_company_name'])){
                 $template.='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_company_name'].'</li>';
                }
                 $template.='</li>
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
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">PROFORMA INVOICE</span> :&nbsp;
                &nbsp;'.@$order_data['inv_code'].'</li>
            </ul>

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">SHIPPING ADDRESS </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_name'].'
                </li>';
                if(!empty($order_data['delivery_company_name'])){
                 $template.='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_company_name'].'</li>';
                }
                 $template.='</li>
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
         
         $template.='</div>
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
                       $template.='<tr style=""><td style="text-align:center;padding:15px 0;">'.$x.'</td>
                            <td style="padding:15px 20px;font-size:14px;">'.$info['name'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['price'],2,'.','').'</td>
                            <td style="padding:15px 0;text-align:right;">'.$info['qty'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['amount'],2,'.','').'</td>
                            </tr>';
                            $x++;
                    }
                }
                
                 $template.='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">SubTotal</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['sub_total'],2,'.','').'</b></th>
                </tr>';
                $template.='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">GST18%</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['tax'],2,'.','').'</b></th>
                </tr>';
                 $template.='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#3B4E87;;text-align:right;">&nbsp; '.number_format($order_data['amount'],2,'.','').'</th>
                </tr>';
               
                  $template.='<tr><td></td><td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.</td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">If you have any questions about this invoice, please write us to below email id</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">care@vidiem.in</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
            </table>
        </div>
    </div>
    <p style="font-size:14px; margin-left:40px; line-height:25px;">
                Warm Regards<br>
                Vidiem<br>
                044-6635 6635 / 77110 06635<br>
            </p>';

$invoice='
   <style>h1 {
    margin-top: -5px;
}</style>
   <div style="border:1px solid black;">
   <div class="container inCon">
        <div style="float:left;"><h1 style="color:#00BFFF;"><img src="'.base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto"/></h1></div>
        <div style="width:30%;float:right;"><h1 style="color:#000000;">PROFORMA INVOICE</h1></div>
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
        <div class="detail" style="float:left; width:35%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:14px; text-transform:uppercase;">No. 3/140, Old Mahabalipuram Road,
Oggiam Thoraipakkam,<br>Chennai - 600097, Tamilnadu, INDIA.</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Landline</span> : &nbsp; 044-6635 6635 / 77110 06635
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Website</span> : &nbsp; http://vidiem.in/
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">GST NO</span> : &nbsp; 33AAACM6280D1ZT
                </li>
            </ul>
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;;">BILL TO </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_name'].'
                </li>';
                if(!empty($order_data['billing_company_name'])){
                 $invoice.='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_company_name'].'</li>';
                }
                 $invoice.='</li>
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
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">PROFORMA INVOICE</span> :&nbsp;
                &nbsp;'.@$order_data['inv_code'].'</li>
            </ul>

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;;">SHIPPING ADDRESS </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_name'].'
                </li>';
                if(!empty($order_data['delivery_company_name'])){
                 $invoice.='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_company_name'].'</li>';
                }
                 $invoice.='</li>
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
         
         $invoice.='</div>
        </div>        
        <div class="form" style="width:100%;"> ';
		
		 $invoice.=' <table style="width:100%; padding:20px 0 40px 0;">
                <tr>
					<td style="width:15%">
						<img src="'.base_url('uploads/customizeimg/'.$basiciteminfo['basecolorpath']).'" style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
					</td>
					<td style="width:85%">
						<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<tbody>
									<tr>
										<td style="border-bottom:1px solid #CCC;"><strong>Customization Code</strong></td>
										<td style="border-bottom:1px solid #CCC;"><strong>'.$basiciteminfo['cart_code'].'</strong></td>
									</tr>
									<tr>
										<td>Body Design</td>
										<td>'.$basiciteminfo['basetitle'].'</td>
									</tr>
									<tr>
										<td>Color</td>
										<td>'.$basiciteminfo['bc_title'].'</td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td>'.count($jarinfo).'</td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td>'.$basiciteminfo['motorname'].'</td>
									</tr> ';
							if($basiciteminfo['canvas_text']!='') {		
								 $invoice.='	<tr>
										<td>Imprinted Text</td>
										<td>'.$basiciteminfo['canvas_text'].'</td>
									</tr> ';
							}	
						if($basiciteminfo['package_id']!='' && !empty($basiciteminfo['package_id'])) {				
							 $invoice.='		<tr>
										<td>Package Preference</td>
										<td>'.$basiciteminfo['packagename'].'</td>
									</tr> ';
						}			
						 $invoice.='			</tbody>
							</table> ';
							
						if(count($jarinfo)>0) {	
						 $invoice.='	<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<thead>
									<tr>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">No. Jars</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Unit Price</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Total Price</th>
									</tr>
								</thead>
								<tbody> ';
								foreach($jarinfo as $jar) {																	 $invoice.='<tr>
										<td>
												<img src="'.base_url("uploads/customizeimg/jar/".$jar['jarimgpath']).'?t='.time().'" style="margin: 0; border: 0; padding: 0; display: block;" width="60" height="60" />								
										</td>
										<td>'.$jar['jarname'].'</td>
										<td style="text-align:center;color:#F7000A;">
											'.$jar['qty'].' Jars
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs.'.number_format($jar['price']) .'
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs. '.number_format($jar['qty']*$jar['price']).'
										</td>
									</tr> ';
								}
						}	
									
							 $invoice.='	</tbody>
							</table>
							
					</td>
				</tr>
            </table> ';
		
        
                
            
                
                 $invoice.='<table style="width:100%; padding:20px 0 40px 0;">
				 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">SubTotal</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['sub_total'],2,'.','').'</b></th>
                </tr>';
                  $invoice.='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">GST18%</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['tax'],2,'.','').'</b></th>
                </tr>';
                 $invoice.='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#F7000A;;text-align:right;">Rs. '.number_format($order_data['amount'],2,'.','').'</th>
                </tr>';
               
                  $invoice.='
            </table>
        </div>
    </div>
    </div>';
	

	
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
    // echo $data['content']; exit;
   // $this->load->view('Backend/pdf-page',$data);
     // $html=$this->load->view('Backend/pdf-page',$data,true);
        //this the the PDF filename that user will get to download
        $pdfFilePath ="invoice-".$order_data['cart_code'].".pdf";
        //load mPDF library
     // print_r($invoice); die();
         $this->m_pdf->pdf->WriteHTML($invoice);
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
    }	
	
	
	function googlexmlgenrate(){
		  $this->db->select('p.id,p.slug,p.modal_no,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description,p.sub_cat_id,p.cat_id');
          $this->db->join('vidiem_category c','c.id=p.sub_cat_id and c.status=1  ','inner');
          $this->db->order_by("c.order_no", "asc");
		  $this->db->order_by("p.price", "desc"); 
          $query=$this->db->get_where('vidiem_products p',array('p.status'=>1)); 
		  $data['product_list']=$query->result_array();
		  
		$string = '<?xml version="1.0"?>
		<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
		<channel>
		<title>Gas Stove Online – Buy Mixer Grinder, Table Top Wet Grinder Online</title>
		<link>https://www.vidiem.in</link>
		<description>Buy Latest Collection Of Gas Stoves, Table Top Wet Grinder, Juicer Mixer Grinders Online At Best Price In India. Avail Cod.  Best Designs. 0% Emi.Free Shipping</description>';
		
		  
		   foreach($data['product_list'] as $listdata){
			 $data1['sub_cat_slug']=$this->FunctionModel->Select('vidiem_category',array('id'=>$listdata['sub_cat_id']));
			  $data1['cat_slug']=$this->FunctionModel->Select('vidiem_category',array('id'=>$listdata['cat_id']));
			
			    $query=$this->db->query("SELECT 'image'as type,id,name,image as url,classname as classname, '' as backimage,order_no FROM vidiem_product_images where status=1 and parent_id='".$listdata['id']."'  order by order_no asc ");
		 $data1['product_img']=$query->result_array();
			 //  print_r($data['product_img']);
			 //  die();
			 $product_multiple_image= '';
			   foreach($data1['product_img'] as $productimage){
				  $product_multiple_image .= '<g:additional_image_link>'.base_url('uploads/images/'.$productimage['url']).'</g:additional_image_link>';				   
			   }
			
    if($listdata['id']==114) { 
	$urlslug=  base_url('vidiem-adc');
	} else if($listdata['id']==122) { 
	
	$urlslug= base_url('vidiem-iris'); 
	} else if($listdata['id']==137) 
	{
	$urlslug= 	base_url('vidiem-tusker');
	} 
	else { 
	$urlslug= base_url('product/'.$listdata['slug']); 
	} 		  
			  // print_r($listdata); die();
			   
			$string .= '<item>		 
			<g:id>'.$listdata['modal_no'].'</g:id>
			<g:title>'.str_replace("&nbsp;","", htmlentities($listdata['name'])).'</g:title>
			<g:description>![CDATA['.str_replace("&nbsp;","", htmlentities(strip_tags($listdata['list_description']))).']]</g:description>
			<g:link>'.$urlslug.'</g:link>
			<g:image_link>'.base_url('uploads/images/'.$listdata['image']).'</g:image_link>
			<g:condition>New</g:condition>
			<g:availability>in stock</g:availability>
			<g:price>'.$listdata['price'].'</g:price>			  
			<g:brand>Vidiem</g:brand>			 			
			<g:google_product_category>'.$data1['cat_slug'][0]['name'].' > '.$data1['sub_cat_slug'][0]['name'].'</g:google_product_category>
			<g:product_type>'.$data1['cat_slug'][0]['name'].'</g:product_type>
			'.$product_multiple_image.'
		</item>';
		
		   }
		  	$string .= ' </channel>
						</rss>'; 
		  
		   header('Content-disposition: attachment; filename="googlefeedxml.xml"');
		   header('Content-type: "text/xml"; charset="utf8"');
		  
			echo $string;
	}

	 public function loadservicecity(){
		 
      $city = $this->FunctionModel->Select_Fields('cityname as name, city_id as id','vidiem_servicecity',array('isactive'=>1,"state_id"=>$_POST['sid']));
		 $optionhtml='  <select class="form-control" name="city_id" id="city_id" onchange="findcenter();">  <option  value="" >All City</option>';
		 if(!empty($city)){ 
                          foreach($city as $info){ 
                         $optionhtml.='<option  value="'.$info['id'].'" >'.$info['name'].'</option>';
                  } 
		  }  
		 echo $optionhtml.="</select>";  
		
    }
	
	 public function ajaxfindcenter(){
		
		$order=array(
                'field'=>'sortby',
                'type'=> 'desc'
            );
		 $where=[];
		 
		$where=array("p.isactive = "=>"1","p.state_id="=>$_POST['sid']);
		
		if(isset($_POST['cid']) && $_POST['cid']!=''){
		$where["p.city_id="]=$_POST['cid'];
		}
		$center=$this->SerivceModel->ManageServiceCenterList('list',$where,$custom,$searchQuery,$order);
		$strhtml="";
		if(count($center)>0 ) { 
		foreach($center as $c) { 
		$strhtml.='	<div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
				<div class="services-centers-locations">
					<h4>'.$c['title'].'</h4>
					<p class="icon address"><i class="fa fa-home" aria-hidden="true"></i> '.$c['address'].'</p>
					<p class="icon"><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:'.$c['email'].'" target="_blank">'.$c['email'].'</a></p>
					<p class="icon"><i class="fa fa-phone" aria-hidden="true"></i> '.$c['phone'].'</p>
					<p class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i> <a href="'.$c['googleurl'].'" target="_blank">View Map</a></p>
				</div>
			</div>';
		} 		
		} else { 
			$strhtml.='<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">No Service Center in Your Area</div>';
		
		} 	
      
		echo $strhtml;
    }
	 public function service_centers(){
        $data['menu_id']=4;
		
		
		 $order=array(
                'field'=>'sortby',
                'type'=> 'desc'
            );
		 $where=[];
		$where=array("p.isactive = "=>"1","p.state_id  "=>"1");
		$data['center']=$this->SerivceModel->ManageServiceCenterList('list',$where,$custom,$searchQuery,$order);
		$data['state'] = $this->FunctionModel->Select_Fields('statename as name, state_id as id','vidiem_servicestate',array('isactive'=>1));
		$data['city'] = $this->FunctionModel->Select_Fields('cityname as name, city_id as id','vidiem_servicecity',array('isactive'=>1,"state_id"=>1));
		
        $data['servicecenterseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Service Center'));
        $this->load->view('service-center-new',@$data);
    }
	public function ajaxfinddealer(){
		
		$order=array(
                'field'=>'sortby',
                'type'=> 'desc'
            );
		 $where=[];
		 
		$where=array("p.isactive = "=>"1","p.state_id="=>$_POST['sid']);
		
		if(isset($_POST['cid']) && $_POST['cid']!=''){
		$where["p.city_id="]=$_POST['cid'];
		}
		$center=$this->SerivceModel->ManageDealerLocatorList('list',$where,$custom,$searchQuery,$order);
		$strhtml="";
		if(count($center)>0 ) { 
		foreach($center as $c) { 
		$strhtml.='	<div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
				<div class="dealer-locator-locations">
					<h4>'.$c['title'].'</h4>
					<p class="icon address"><i class="fa fa-home" aria-hidden="true"></i> '.$c['address'].'</p>
					<p class="icon"><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:'.$c['email'].'" target="_blank">'.$c['email'].'</a></p>
					<p class="icon"><i class="fa fa-phone" aria-hidden="true"></i> '.$c['phone'].'</p>
					<p class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i> <a href="'.$c['googleurl'].'" target="_blank">View Map</a></p>
				</div>
			</div>';
		} 		
		} else { 
			$strhtml.='<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">No Dealers in Your Area</div>';
		
		} 	
      
		echo $strhtml;
    }
	/*public function dealer_locator(){
		 
        $data['menu_id']=4;
		
		
		 $order=array(
                'field'=>'sortby',
                'type'=> 'desc'
            );
		 $where=[];
		$where=array("p.isactive = "=>"1","p.state_id  "=>"1");
		$data['center']=$this->SerivceModel->ManageDealerLocatorList('list',$where,$custom,$searchQuery,$order);
		$data['state'] = $this->FunctionModel->Select_Fields('statename as name, state_id as id','vidiem_servicestate',array('isactive'=>1));
		$data['city'] = $this->FunctionModel->Select_Fields('cityname as name, city_id as id','vidiem_servicecity',array('isactive'=>1,"state_id"=>1));
		//echo $this->last_query();
        $data['dealerlocatorseo']=$this->FunctionModel->Select('vidiem_seo',array('title'=>'Dealer Locator'));
        $this->load->view('dealer-locator-new',@$data);
    }*/
	
    public function vidiemStartCustomize()
    
    {
        $title  = 'Vidiem by You - Worlds First Customizable Mixer Grinder';
        $desc  = 'Vidiem By You, brings you the opportunity to build your very own Mixer Grinder to perfectly suit your needs.Make your favourite dishes in a mixer grinder designed by you!';
        $data   =  array( 'title' => $title ,'desc' => $desc );
        $this->load->view('vidiem_customize_start', $data );
    }

    public function getMotorById()
    {
        $id = $this->input->post('id');
        $baseId = $this->input->post('baseId');
        $data['motor'] = $this->CustomizeModel->getMotorDetailById($id, $baseId);
        return $this->load->view('motor_view_info',$data);
    }

    public function adminOrderPayment($id)
    {
        
        $order_data         = $this->FunctionModel->Select_Row('vidiem_customorder',array('id'=>$id));

        $orders             = $this->DealersModel->getDealerOrdersAll( $id, 'admin' );
        
        if( isset( $orders) && !empty($orders) ) {
            $productItems   = $this->DealersModel->getDealerOrderItemsDetails($id);
        }

		$basicItemInfo      = $this->CustomizeModel->getOrderBasicDetails($id);
		$jarInfo            = $this->CustomizeModel->getOrderJarsDetails($id);
		
        $client             = $this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
        
        $params             = array(
                                'order_data' => $orders,
                                'order_items' => $productItems,
                                'jarInfo' => $jarInfo,
                                'basicItemInfo' => $basicItemInfo,
                                'order_id' => $id,
                                'from' => 'admin'
                            );
                            
        $this->load->view( 'Backend/dealers/admin/counter_payment', $params );
    }

    public function doCounterAdminPayment()
    {
       
        $this->form_validation->set_rules('vidiem_invoice', 'Vidiem Invoice', 'callback_file_selected_dynamic[vidiem_invoice]');

        if ($this->form_validation->run() == FALSE)
        {
            $error_message  = validation_errors();
            $status         = 0;
        } else {
            /***
             *  check data already exist in vidiem_dealer_locations
             */
            $id                                     = $this->input->post('id', true);
            $order_id                               = $this->input->post('order_id');

            $InsertData                             = array(
                                                        'modified'          => date('Y-m-d H:i:s')
                                                    );
         
            if( isset( $this->upload_data['vidiem_invoice']['file_name'] ) && !empty( $this->upload_data['vidiem_invoice']['file_name'] ) ) {
                $InsertData['vidiem_invoice']       = $this->upload_data['vidiem_invoice']['file_name'];
            }
            
            $result                                 = $this->FunctionModel->Update($InsertData,'vidiem_customorder', ['id' => $id]);
            
            $error_message                          = 'Updated successfully';

            if( $result >= 1 ) {
               // $this->CustomizeModel->UploadAdminInvoiceNotification($id);  
                $order_pass_type='Admin Invoice';
                 $this->CustomizeModel->CustomerInvoiceDealer($id,$order_pass_type);
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-check");
                $this->session->set_flashdata('msg', "Dealers Order Payment updated Successfully.");
                
                $status = 1;

            } else {

                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
                $status = 0;
            }

        }

        echo json_encode(['status' => $status, 'error_message' => $error_message ]);        
        
    }

    public function file_selected_dynamic( $image, $param ) {
        
        $file_name              = $param;

        $allowed_mime_type_arr  = array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime                   = get_mime_by_extension($_FILES[$file_name]['name']);

        
        if( isset($_FILES[$file_name]['name']) && $_FILES[$file_name]['name']!="" ) {

            if( in_array( $mime, $allowed_mime_type_arr ) ) {

                if( $_FILES[$file_name]['size'] != 0 ) {
                    $upload_dir = './uploads/dealer/orders';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir);
                    }
                    if(file_exists($upload_dir.'/'.$_FILES[$param]['name'])){
                            list($file_name)=explode('.',$_FILES[$param]['name']);
                            $file_name = $file_name.'_'.substr(md5(rand()),0,5);
                    } else {
                        list($file_name)=explode('.',$_FILES[$param]['name']);
                    }
                    $config['upload_path']   = $upload_dir;
                    $config['allowed_types'] = '*';
                    $config['file_name']     = $param;
                    $config['overwrite']     = false;
                    $config['max_size']	     = '5120';
            
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload($param)) {
                        
                        $this->form_validation->set_message('file_selected_dynamic', $this->upload->display_errors('<p class=error>','</p>'));
                        return false;
                    }
                    else{
                        $this->upload_data[$param] =  $this->upload->data();
                        return true;
                    }
                }

                return true;
            } else {
                $this->form_validation->set_message('file_selected_test', 'Please select only gif/jpg/png file.');
                return false;
            }

        }
        return true;

    }
	
	public function book_home_service() 
	{
	  $this->load->view('book-home-service');
	}

	public function mobilecheck(){
        $phone = $_POST["mobile_no"];
            if(preg_match('/^[0-9]{10}+$/', $phone)) {
                $addresshtml = "Valid Phone Number";
                $status = "success";
            } else {
                $addresshtml = "Invalid Phone Number";
                $status = "failed";
            }

            echo json_encode(array("addresshtml"=>$addresshtml,"status"=> $status,));
            exit;
    }

    public function emailcheck(){
        $email = $_POST["email_id"];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $addresshtml = "Invalid email format";
            $status = "failed";
          }else{
            $addresshtml = "Valid Email Address";
            $status = "success";
          }
 	   echo json_encode(array("addresshtml"=>$addresshtml,"status"=> $status,));
	   exit;
    } 
}