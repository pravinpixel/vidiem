<?php
class ProjectModel extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('session','Dbvars'));
        $this->load->database();
    }
   public function Pages(){
        $data=array('1'=>'Offers','2'=>'Combo Offers');
        return $data;
    } 
    public function SMS($mobile_no,$sms_content){
        return true;
        echo 'Mobile No.'.$mobile_no.'<br>'.$sms_content; exit;
        return true;
    }
    public function Reviews(){
        $this->db->select('r.*,h.name as product_name');
        $this->db->join('vidiem_products h','h.id=r.parent_id');
        $this->db->order_by('r.id','DESC');
        $query=$this->db->get_where('vidiem_products_reviews r');
        return $query->result_array();
    }
 public function Pagesevents(){
        $data=array('1'=>'Awards and Recognation','2'=>'Events');
        return $data;
    }
    
     public function complaintCode(){
        $code=$this->FunctionModel->Select_Field('code','vidiem_complaint_registration',array(),'id','DESC',1);
        if(empty($code)){
            return 'WC-1001';
        }else{
            $code=substr($code,3); $code++;
            return 'WC-'.$code;
        }
    }
    
    public function RegistrationCode(){
        $code=$this->FunctionModel->Select_Field('code','vidiem_product_registration',array(),'id','DESC',1);
        if(empty($code)){
            return 'WC-1001';
        }else{
            $code=substr($code,4); $code++;
            $code='REG-'.str_pad($code,4,"0",STR_PAD_LEFT);
            return $code;
        }
    }
    
     public function getCities(){
        $data=array('Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura    Agartala','Uttar Pradesh','Uttarakhand','West Bengal');
        return $data;
    }
    
    public function Courier(){
        $data=$this->FunctionModel->Select('vidiem_delivery_partners',['status'=>1]);
        $courier=[];
        if(!empty($data)){
            foreach ($data as $info) {
                $courier[$info['id']]=$info['name'];
            }
        }
        return $courier;
    }

    public function valid_coupon($code){
        $this->db->where('DATE(c.start_date) <=',date('Y-m-d'));
        $this->db->where('DATE(c.end_date) >=',date('Y-m-d'));
        $query=$this->db->get_where('vidiem_coupon c',array('code'=>$code,'status'=>1));
        return $query->row_array();
    }

    public function FetchTopSeller(){
       $this->db->select('op.slug,op.name');
       $this->db->join('vidiem_order o','o.id=op.order_id');
       $this->db->group_by('product_id');
       $this->db->order_by("SUM(op.qty)",'desc');
       $query=$this->db->get_where('vidiem_order_products op',array('o.payment_status'=>'success'),'10');
       return $query->result_array();
    }
 public function ClientMailCheck($email){
        $this->db->select();
        // $this->db->or_group_start();
        // $this->db->or_where('mobile_no',$user_name);
        $this->db->where('email',$email);
        // $this->db->group_end();
        //$this->db->where('password',md5($password));
        $query=$this->db->get_where('vidiem_clients');
        return $query->num_rows(); 
    }
     public function ClientTrackOrder($code,$email){
       
 $order=$this->FunctionModel->Select_Row('vidiem_order',array('inv_code'=>$code));
         $client_id=$this->FunctionModel->Select_Field('id','vidiem_clients',array('email'=>$email));
        /* $order= $this->FunctionModel->Select_Row('vidiem_order',array('code'=>$code));
         $client_id=$this->FunctionModel->Select_Row('vidiem_clients',array('email'=>$email));*/
       $data['status']=2;
       if($client_id!=$order['client_id']){
        return $data;
       }else{
         if(!empty($order['courier'])){
            $data['courier_name']=$this->FunctionModel->Select_Field('name','vidiem_delivery_partners',['id'=>$order['courier']]);
          }else{
            $data['courier_name']='';
          }  

         $data['status']=1;
         $data['code']=$order['inv_code'];
         $data['courier']=$order['courier'];
         $data['notes']=$order['notes'];
         $data['order_status']=$order['status'];         
         $data['tracking_code']=$order['tracking_code'];
          return $data;
     }

    }
    public function SearchCatFinder($terms){
        $cat_id=$this->FunctionModel->Select_Field('id','vidiem_category',array('name'=>$terms,'parent_id'=>0));
        $terms=urldecode($terms);
        if(!empty($cat_id)){
            return array('cat_id'=>$cat_id,'parent_id'=>$cat_id,'type'=>1);
        }else{
            $tmp=$this->FunctionModel->Select_Fields_Row('id,parent_id','vidiem_category',array('name'=>$terms,'parent_id !='=>0));
            if(!empty($tmp)){
                return array('cat_id'=>$tmp['parent_id'],'parent_id'=>$tmp['id'],'type'=>2);
            }else{
                 return array('cat_id'=>0,'parent_id'=>0,'type'=>0);
            }
        }
    }

    public function Notification(){
        $client_id=$this->session->userdata('client_id');
        $notification=$this->FunctionModel->Select('vidiem_notification',array('status'=>1));
        if(empty($client_id)){
            return $notification;
        }else{
            $from=date('Y-m-d',strtotime('-7 Days'));
            $this->db->where_in('status',array(2,3));
            $this->db->where('DATE(delivered_at) >=',$from);
            $query=$this->db->get_where('vidiem_order',array('client_id'=>$client_id));
            //$query=$this->db->get_where('vidiem_order');
            $row=$query->result_array();
            if(!empty($row)){
                $tmp['url']='user/dashboard';
                foreach ($row as $info) {
                   $tmp['title']='Order Id - '.$info['inv_code'].' Delivered at '.date("d-M-Y", strtotime($info['delivered_at']));;
                   $notification[]=$tmp;
                }
            }
            return $notification;
        }
    }


    public function coupon_discount($code){
        $client_id=$this->session->userdata('client_id');
        $return=array(
            'status'=> 2,
            'id'    => 0,
            'type'  => 0,
            'value' => 0,
            'amount'=> 0,
         );
        if(empty($code)){
             $return['status']=2;
             return $return;
        }
        if(empty($client_id)){
             $return['status']=2;
             return $return;
        }
        $info=$this->valid_coupon($code);
        if(empty($info)){
             $return['status']=2;
             return $return;
        }
            $total=$this->cart->total();
            $user_order_count=$this->FunctionModel->Row_Count('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success'));
            $user_used=$this->FunctionModel->Row_Count('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success','coupon_id'=>$info['id']));
            $total_used=$this->FunctionModel->Row_Count('vidiem_order',array('payment_status'=>'success','coupon_id'=>$info['id']));
            if($total<$info['min_order']){
                 $return['status']=2;
                 return $return;
            }
            if($user_order_count !=0 && $info['only_first_order']==1){
                 $return['status']=2;
                 return $return;
            }
            if($user_used >= $info['max_per_user']){
                 $return['status']=2;
                 return $return;
            }
            if($user_used >= $info['max_usage']){
                 $return['status']=2;
                 return $return;
            }
            $return['status']=1;
            $return['id']=$info['id'];
            $this->session->set_userdata('coupon',$code);
            if($info['type']==1){
                $discount=$total*($info['discount_value']/100);
                $discount=($discount>$info['max_discount'])?$info['max_discount']:$discount;
                $return['type']=1;
                $return['value']=number_format($info['discount_value']);
                $return['amount']=$discount;
                return $return;
            }else if($info['type']){
                 $discount=($info['discount_value']);
                $return['type']=2;
                $return['value']=number_format($info['discount_value']);
                $return['amount']=$discount;
            }
            return $return;
              
    }

    public function AjaxSearchFilter($search_term,$price,$sort,$stock){
        $this->db->select('s.id,s.image,s.price,s.old_price,p.id,p.name,p.slug,p.image,p.price,p.old_price,p.modal_no,p.outofstock,c.name as category,sub.name as sub_category,p.list_description');
                $this->db->join('vidiem_category c','c.id=p.cat_id');
        $this->db->join('vidiem_category sub','sub.id=p.sub_cat_id');
        $this->db->join('vidiem_products s','p.product_id=s.id','left');
        if(!empty($search_term)){
            $this->db->or_group_start();
            $this->db->like('p.name',$search_term);
            $this->db->or_like('p.modal_no',$search_term);
            $this->db->or_like('c.name',$search_term);
            $this->db->or_like('sub.name',$search_term);
            $this->db->or_like('p.search_keywords',$search_term);
            $this->db->or_like('c.search_keywords',$search_term);
            $this->db->or_like('sub.search_keywords',$search_term);
            $this->db->group_end();
        }
        if(empty($stock)){
            $this->db->where('p.outofstock',0);
        }
        if(!empty($price)){
            list($from,$to)=explode(',',$price);
            $this->db->where('p.price >=',$from);
            $this->db->where('p.price <=',$to);
        }
        if($sort==1){
            $this->db->order_by('p.id','DESC');
        }else if($sort==2){
            $this->db->order_by('p.price','ASC');
        }else if($sort==3){
            $this->db->order_by('p.price','DESC');
        }else{
            $this->db->order_by('p.id','DESC');
        }
        $query=$this->db->get_where('vidiem_products p',array('p.status'=>1,'c.status'=>1,'sub.status'=>1,'p.product_id'=>0));
		//echo $this->db->last_query(); exit;
        return $query->result_array();
    }

    public function ProductFilter($cat_id,$price,$filters,$type=NULL,$sub_cat=NULL,$sort,$stock,$sub_filters=null){
		
		 
        list($from,$to)=explode(',',$price);
        $this->db->select('p.id,p.slug,p.name,p.image,p.price,p.old_price,p.outofstock,p.list_description');
     
        if(!empty($filters)){
            $x=1;
            foreach ($filters as $key=>$info) {
                $this->db->join('vidiem_product_filters pf_'.$x,'pf_'.$x.'.parent_id=p.id');
                $this->db->where('pf_'.$x.'.cat_filter_id',$key);
                if(!empty($info)){
                        $this->db->group_start();
                    foreach ($info as $tmp) {
                        $this->db->or_where('pf_'.$x.'.value_id',$tmp);
                    }
                        $this->db->group_end();
                }
            $x++;
            }
        }
        if(empty($stock)){
            $this->db->where('p.outofstock',0);
        }
        $this->db->where('p.price >=',$from);
        $this->db->where('p.price <=',$to);
        if($sort==1){
            $this->db->order_by('p.id','DESC');
        }else if($sort==2){
            $this->db->order_by('p.price','ASC');
        }else if($sort==3){
            $this->db->order_by('p.price','DESC');
        }else{
            $this->db->order_by('p.id','DESC');
        }
		
		if(count($sub_filters)>0)
		{
			//echo "dfgdf"; die();
			$this->db->where_in('p.sub_cat_id',$sub_filters);
			
		}
        if($type==2){
            $this->db->where('sub_cat_id',$sub_cat);
        }
		
        $query=$this->db->get_where('vidiem_products p',array('cat_id'=>$cat_id,'status'=>1));
		//echo $this->db->last_query(); exit;
        return $query->result_array(); 
    }

    public function Login_with_google($data=array()){
        $count=$this->FunctionModel->Row_Count('vidiem_clients',array('email'=>$data['email']));
        if($count==0){
             if($data['gender']=='male'){
            $gender='Mr.';
        }
        else if($data['gender']=='female'){
             $gender='Mrs.';
        }
        else{  $gender=''; }
           $InsertData=array(
                'name'       => $data['first_name'].' '.$data['last_name'],
                'email'      => $data['email'],
                'mobile_no'  => '',
                'gender'        => $gender,
                'dob'           => '',
                'newsletter'    => 0,
                'special_offer' => 0,
                'sms_verified'   => 1,
                'sms_code'   => rand(100000,999999),
                'password'   => md5(time()),
                'status'     => 1,
                'created'    =>date('Y-m-d H:i:s')
            );
            $client_id=$this->FunctionModel->Insert($InsertData,'vidiem_clients');
        }
        else{
            $client_id=$this->FunctionModel->Select_Field('id','vidiem_clients',array('email'=>$data['email']));
        }
        $this->ClientIdLogin($client_id);
        return true;
    }

    public function Login_with_facebook($data=array()){
        $count=$this->FunctionModel->Row_Count('vidiem_clients',array('email'=>$data['email']));
        if($count==0){
           $InsertData=array(
                'name'       => $data['name'],
                'email'      => $data['email'],
                'sms_verified'   => 1,
                'sms_code'   => rand(100000,999999),
                'password'   => md5(time()),
                'status'     => 1,
                'created'    =>date('Y-m-d H:i:s')
            );
            $client_id=$this->FunctionModel->Insert($InsertData,'vidiem_clients');
            $this->ProjectModel->WelcomeMail($data['email'],$data['name']);
        }
        else{
            $client_id=$this->FunctionModel->Select_Field('id','vidiem_clients',array('email'=>$data['email']));
        }
        $this->ClientIdLogin($client_id);
        return true;
    }

    public function Related_Products($product_id){
        $cat_id=$this->FunctionModel->Select_Field('cat_id','vidiem_products',array('id'=>$product_id));
        $sub_cat_id=$this->FunctionModel->Select_Field('sub_cat_id','vidiem_products',array('id'=>$product_id));
        $this->db->select('id,slug,name,image');
        $this->db->order_by('id','RANDOM');
        $query=$this->db->get_where('vidiem_products',array('cat_id'=>$cat_id,'sub_cat_id'=>$sub_cat_id,'product_id'=>0,'id !='=>$product_id,'status'=>1),'3');
        $list=$query->result_array();
        $count=$query->num_rows();
        if($count<3){
            $this->db->select('id,slug,name,image');
            $this->db->order_by('id','RANDOM');
            $query=$this->db->get_where('vidiem_products',array('cat_id'=>$cat_id,'sub_cat_id !='=>$sub_cat_id,'product_id'=>0,'id !='=>$product_id,'status'=>1),(3-$count));
            $list1=$query->result_array();
            $list=array_merge($list,$list1);
        }
        return $list;
    }

    public function OrderProductList($order_id){
        $this->db->select('o.*,p.modal_no');
        $this->db->join('vidiem_products p','p.id=o.product_id');
        $query=$this->db->get_where('vidiem_order_products o',array('order_id'=>$order_id));
        return $query->result_array();
    }

    public function states(){
        $states=array('Andaman and Nicobar Islands','Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chand���garh','Chhatt���sgarh','Dadra and Nagar Haveli','Daman and Diu','Delhi','Goa','Gujarat','Haryana','Himachal Pradesh','Jammu and Kashm���r','Jharkhand','Karnataka','Kerala','Lakshadweep','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Orissa','Pondicherry','Punjab','Rajasthan','Sikkim','Tamil Nadu','Tripura','Uttar Pradesh','Uttaranchal','West Bengal');
        return $states;
    }
    
    public function currentOrder($client_id){
        $this->db->where_in('status',['1','2','5']);
        $data=$this->db->get_where('vidiem_order',array('client_id'=>$client_id,'payment_status'=>'success'))->result_array();
        return $data;
    }

    public function OrderStatus(){
         $order_status=array(
            '1'=>'<span class="label label-info status-span">New Order</span>',
            '5'=>'<span class="label label-warning status-span">Processing</span>',
            '2'=>'<span class="label label-primary status-span">Shipped</span>',
            '3'=>'<span class="label label-success status-span">Delivered</span>',
            '4'=>'<span class="label label-danger status-span">Cancelled</span>'
        );
        return $order_status;
    }

    public function OrderCode(){
        $code=$this->FunctionModel->Select_Field('code','vidiem_order',array(),'id','DESC',1);
        if(empty($code)){ return '0001'; }
        else{
             ++$code;
            return str_pad($code,'4','0',STR_PAD_LEFT);
        }
    }

    public function InvoiceCode(){
        $code=$this->FunctionModel->Select_Field('inv_code','vidiem_order',array(),'inv_code','DESC',1);
        if(empty($code)){ return '0001'; }
        else{
             ++$code;
            return str_pad($code,'4','0',STR_PAD_LEFT);
        }
    }

    // Clinet Login

    public function ClientIdLogin($tmp_id)
    {
        $this->session->unset_userdata('otp_client_id');
        $this->session->unset_userdata('forgot_client_id');
        $row=$this->FunctionModel->Select_Fields_Row('id,name','vidiem_clients',array('id'=>$tmp_id));
        $array=array(
            'client_id'  => $row['id'],
            'client_name'=> $row['name']
        );
        $this->session->set_userdata($array);
        return true;
    }

    public function ClientLoginCheck($user_name,$password){
        $this->db->select();
        // $this->db->or_group_start();
        // $this->db->or_where('mobile_no',$user_name);
        $this->db->where('email',$user_name);
        // $this->db->group_end();
        $this->db->where('password',md5($password));
        $query=$this->db->get_where('vidiem_clients');
        return $query->num_rows(); 
    }

    public function ClientLogin($user_name,$password){
        $this->db->select('id,name,mobile_no,sms_verified,status');
        // $this->db->or_group_start();
        // $this->db->or_where('mobile_no',$user_name);
        $this->db->where('email',$user_name);
        // $this->db->group_end();
        $this->db->where('password',$password);
        $query=$this->db->get_where('vidiem_clients');
        $row=$query->row_array();
        if($row['status']==2){
            return 2;
        } 
        $this->ProjectModel->ClientIdLogin($row['id']);
        return 1;
        if($row['sms_verified']==0){
            $otp_code=rand(100000,999999);
            $UpdateData=array(
                'sms_code' => $otp_code,
                'modified' => date('Y-m-d H:i:s')
            );
            $client_id=$this->FunctionModel->Update($UpdateData,'vidiem_clients',array('id'=>$row['id']));
            $sms_content="Thanks for registration. Your Otp is ".$otp_code;
            $this->ProjectModel->SMS($row['mobile_no'],$sms_content);
            $this->session->set_userdata('otp_client_id',$row['id']);
            return 3;
        }
        $this->ProjectModel->ClientIdLogin($row['id']);
        return 1;
    }

    // Client Datas

    public function ClientDataCount($array=array(),$search_term=null){
        $this->db->select('id,name,email,mobile_no,sms_verified,status,created');
        if(!empty($search_term)){
            $this->db->or_group_start();
            $this->db->or_like('name',$search_term);
            $this->db->or_like('email',$search_term);
            $this->db->or_like('mobile_no',$search_term);
            $this->db->group_end();
        }
        $query=$this->db->get_where('vidiem_clients',$array);
        return $query->num_rows();
    }

    public function ClientData($array=array(),$per_page=100,$start=0,$search_term=null){
       $this->db->select('id,name,email,mobile_no,sms_verified,status,created');
        if(!empty($search_term)){
            $this->db->or_group_start();
            $this->db->or_like('name',$search_term);
            $this->db->or_like('email',$search_term);
            $this->db->or_like('mobile_no',$search_term);
            $this->db->group_end();
        }
        $query=$this->db->get_where('vidiem_clients',$array,$per_page,$start);
        return $query->result_array();
    }

    // Product Info

    public function ProductInfo($id){
        $this->db->select('p.*,c.name as category,s.name as sub_category');
        $this->db->join('vidiem_category c','c.id=p.cat_id');
        $this->db->join('vidiem_category s','s.id=p.sub_cat_id');
        $query=$this->db->get_where('vidiem_products p',array('p.id'=>$id));
        return $query->row_array();
    }

    public function ProductInfoForCart($product_id){
        $this->db->select('s.id,s.image,s.price,s.old_price,p.id,p.name,p.slug,p.image,p.price,p.old_price,p.modal_no');
        $this->db->join('vidiem_products s','p.product_id=s.id','left');
        $query=$this->db->get_where('vidiem_products p',array('p.status'=>1,'p.id'=>$product_id));
        return $query->row_array();
    }


    // Order Invoicing

    public function OrderInvoicing($order_id){
        $order_data=$this->FunctionModel->Select_Row('vidiem_order',array('id'=>$order_id));
        $order_product=$this->FunctionModel->Select('vidiem_order_products',array('order_id'=>$order_id));
        $client=$this->FunctionModel->Select_Row('vidiem_clients',array('id'=>$order_data['client_id']));
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
        <div style="width:30%;float:right;"><h1 style="color:#00BFFF;">PERFORMA INVOICE</h1></div>
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
        <div class="detail" style="float:left; width:35%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:14px; text-transform:uppercase;">No. 3/140, Old Mahabalipuram Road,
Oggiam Thoraipakkam,<br>Chennai - 600097, Tamilnadu, INDIA.</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Landline</span> : &nbsp; 1800 123 8436
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
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">PERFORMA INVOICE</span> :&nbsp;
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
                1800 123 8436<br>
            </p>';

$invoice='
   <style>h1 {
    margin-top: -5px;
}</style>
   <div style="border:1px solid black;">
   <div class="container inCon">
        <div style="float:left;"><h1 style="color:#00BFFF;"><img src="'.base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto"/></h1></div>
        <div style="width:30%;float:right;"><h1 style="color:#00BFFF;">PERFORMA INVOICE</h1></div>
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
        <div class="detail" style="float:left; width:35%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:14px; text-transform:uppercase;">No. 3/140, Old Mahabalipuram Road,
Oggiam Thoraipakkam,<br>Chennai - 600097, Tamilnadu, INDIA.</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Landline</span> : &nbsp; 1800 123 8436
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
                 $invoice.='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['billing_company_name'].'</li>';
                }
                 $invoice.='</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; '.@$order_data['billing_address'].' - '.@$order_data['billing_address'].'
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
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">PERFORMA INVOICE</span> :&nbsp;
                &nbsp;'.@$order_data['inv_code'].'</li>
            </ul>

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">SHIPPING ADDRESS </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_name'].'
                </li>';
                if(!empty($order_data['delivery_company_name'])){
                 $invoice.='<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; '.@$order_data['delivery_company_name'].'</li>';
                }
                 $invoice.='</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; '.@$order_data['delivery_address'].' - '.@$order_data['delivery_address'].'
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
                       $invoice.='<tr style=""><td style="text-align:center;padding:15px 0;">'.$x.'</td>
                            <td style="padding:15px 20px;font-size:14px;">'.$info['name'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['price'],2,'.','').'</td>
                            <td style="padding:15px 0;text-align:right;">'.$info['qty'].'</td>
                            <td style="padding:15px 0;text-align:right;">'.number_format($info['amount'],2,'.','').'</td>
                            </tr>';
                            $x++;
                    }
                }
                
                 $invoice.='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">SubTotal</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['sub_total'],2,'.','').'</b></th>
                </tr>';
                  $invoice.='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">GST18%</th>
                    <th style="padding:10px 0;text-align:right;"><b>'.number_format($order_data['tax'],2,'.','').'</b></th>
                </tr>';
                 $invoice.='<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#3B4E87;;text-align:right;">&nbsp; '.number_format($order_data['amount'],2,'.','').'</th>
                </tr>';
               
                  $invoice.='<tr><td></td><td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.</td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">If you have any questions about this invoice, please write us to below email id</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">care@vidiem.in</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
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
      $file_name='uploads/invoice/vidiem_billing_Invoice.pdf';
      $this->m_pdf->pdf->WriteHTML($invoice);
      $attachdata=$this->m_pdf->pdf->Output($file_name, 'S'); 
      $this->FunctionModel->sendmail('saravanan.p@mayaappliances.com',$template,'New Order Invoice','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail($client['email'],$template,'Product Order Invoice','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('itsupport@mayaappliances.com',$template,'New Order Invoice','care@vidiem.in',$attachdata);
        return true;    
    }


    // Order Management

    public function Select_Orders(){
        $this->db->select('o.*,c.name,c.email,c.mobile_no');
        $this->db->join('vidiem_clients c','c.id=o.client_id');
        $this->db->order_by('o.id','DESC');
        $query=$this->db->get_where('vidiem_order o',array('o.status !='=>4,'o.payment_status'=>'success'));
        return $query->result_array();
    }

    public function Select_unCompletedOrders(){
        $this->db->select('o.*,c.name,c.email,c.mobile_no');
        $this->db->join('vidiem_clients c','c.id=o.client_id');
        $query=$this->db->get_where('vidiem_order o',array('o.status !='=>4,'o.payment_status !='=>'success'));
        return $query->result_array();
    }

    public function Select_Cancelled_Order(){
        $this->db->select('o.*,c.name,c.email,c.mobile_no');
        $this->db->join('vidiem_clients c','c.id=o.client_id');
        $query=$this->db->get_where('vidiem_order o',array('o.status'=>4));
        return $query->result_array();
    }
    
    public function Select_Cancel_Requests(){
        $this->db->select('o.*,c.name,c.email,c.mobile_no');
        $this->db->join('vidiem_clients c','c.id=o.client_id');
        $query=$this->db->get_where('vidiem_order o',array('o.status'=>1,'o.cancel_request'=>1));
        return $query->result_array();
    }


    // Search
    public function ProductSearch($search_term){
        $this->db->select('s.id,s.image,s.price,s.old_price,p.id,p.name,p.slug,p.image,p.price,p.old_price,p.modal_no,p.list_description,p.outofstock,c.name as category,sub.name as sub_category,p.status');
                $this->db->join('vidiem_category c','c.id=p.cat_id');
        $this->db->join('vidiem_category sub','sub.id=p.sub_cat_id');
        $this->db->join('vidiem_products s','p.product_id=s.id','left');
        if(!empty($search_term)){
            $this->db->or_group_start();
            $this->db->like('p.name',$search_term);
            $this->db->or_like('p.modal_no',$search_term);
            $this->db->or_like('c.name',$search_term);
            $this->db->or_like('sub.name',$search_term);
            $this->db->or_like('p.search_keywords',$search_term);
            $this->db->or_like('c.search_keywords',$search_term);
            $this->db->or_like('sub.search_keywords',$search_term);
            $this->db->group_end();
        }
        $query=$this->db->get_where('vidiem_products p',array('p.product_id'=>0));
        return $query->result_array();
    }
//recipe
     public function RecipeDataCount($array=array(),$search_term=null){
        $this->db->select('id,name,image,order_no,status,created');
        if(!empty($search_term)){
            $this->db->or_group_start();
            $this->db->or_like('name',$search_term);
            $this->db->group_end();
        }
        $query=$this->db->get_where('vidiem_recipe',$array);
        return $query->num_rows();
    }

    public function RecipeData($array=array(),$per_page=100,$start=0,$search_term=null){
       $this->db->select('id,name,image,order_no,status,created');
        if(!empty($search_term)){
            $this->db->or_group_start();
            $this->db->or_like('name',$search_term);
            $this->db->group_end();
        }
        $query=$this->db->get_where('vidiem_recipe',$array,$per_page,$start);
        return $query->result_array();
    }

    public function ProuctListing(){
        $this->db->select('p.*,c.name as category,s.name as sub_category');
        $this->db->join('vidiem_category s','s.id=p.sub_cat_id');
        $this->db->join('vidiem_category c','c.id=p.cat_id');
        $query=$this->db->get_where('vidiem_products p');
        return $query->result_array();
    }



    // Notifications

    public function NewOrderNotification($order_id){
        $order_info=$this->FunctionModel->Select_Fields_Row('client_id,inv_code,amount','vidiem_order',array('id'=>$order_id));
        $clt_info=$this->FunctionModel->Select_Fields_Row('mobile_no,email','vidiem_clients',array('id'=>$order_info['client_id']));

        // SMS
        $sms_content='Your Order on vidiem Invoice Code '.$order_info['inv_code'].' successfully Completed. Thanks for choosing vidiem';
        $this->SMS($clt_info['mobile_no'],$sms_content);

        $sms_content='New Order On Vidiem Invoice Code '.$order_info['inv_code'].'. Invoice Amount'.$order_info['amount'];
        $this->SMS(AdminMobile,$sms_content);
        
        $subject='Vidiem Order Successful';
            $msg='<p>Sir,<br> &nbsp;&nbsp; your order on vidiem successfully completed. Invoice Code '.$order_info['inv_code'];
    $this->FunctionModel->sendmail1($clt_info['email'],$msg,$subject,InfoMail);

    $subject='New Order on Vidiem Site';
            $msg='<p>Sir,<br>  &nbsp;&nbsp; New Order on Vidiem Site. Invoice Code'.$order_info['inv_code'].'. Invoice Amount'.$order_info['amount'];
    $this->FunctionModel->sendmail1(AdminMail,$msg,$subject,InfoMail);

    }
    
    public function OfferProductList($id){
        $this->db->select('p.name,p.image,p.price,op.status,op.created,op.id');
        $this->db->join('vidiem_products p','p.id=op.product_id');
        $query=$this->db->get_where('vidiem_offer_products op',array('parent_id'=>$id));
        return $query->result_array();
    }

    public function OfferProductFrontEnd($id){
         $this->db->select('p.*');
        $this->db->join('vidiem_products p','p.id=op.product_id');
        $query=$this->db->get_where('vidiem_offer_products op',array('parent_id'=>$id,'op.status'=>1,'p.status'=>1));
        return $query->result_array();
    }

    // All Mail Functionality

    public function WelcomeMail($email,$name){
  
        $subject='Welcome Mail';
        $message='<table width="100%" height="100%" style="min-width:348px" border="0" cellspacing="0" cellpadding="0"><tbody><tr height="32px"></tr><tr align="center"><td><div><div></div></div><table border="0" cellspacing="0" cellpadding="0" style="padding-bottom:20px;max-width:600px;min-width:220px"><tbody><tr><td><table cellpadding="0" cellspacing="0"><tbody><tr><td></td><td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="direction:ltr;padding-bottom:7px"><tbody><tr><td align="left"><img width="92" height="32" src="'.base_url('assets/front-end/images/logo.png').'" style="width:92px;height:32px" class="CToWUd"></td><td align="right" style="font-family:Roboto-Light,Helvetica,Arial,sans-serif"></td><td align="right" width="35"></td></tr></tbody></table></td><td></td></tr><tr><td style="background:url(\'https://ci5.googleusercontent.com/proxy/Ky9uO0L4rCGl_EWbkifDjpWLd1NFKfi-7b0JFxdVNqqFxNiBhPWyAqs1qKnPjpW5SaR1r77z_cI3vg96-jP6lpbwEfA67jtQsf_zpAF_QNGPg11GKPcs=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-nw.png\') top left no-repeat" width="6" height="5"><div></div></td><td style="background:url(\'https://ci4.googleusercontent.com/proxy/gXzgRO1K9pWfZAogBcrVQnvwQSkX2I8jcnx4g-SvUNfv82pak_4MS_c1aUDeM40soy4koxNBI_ked6U7zrdBUTjETr518K7PLsfDQqhgTKSF2StiCg=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-n.png\') top center repeat-x" height="5"><div></div></td><td style="background:url(\'https://ci5.googleusercontent.com/proxy/FCthMIcyUgO8YTLL_W5YLLOf8y-W7iePJhbY6RQcus60exGI_nmzO0_hpSJ3NY-IfXIgy7OGWAcb9gi34GE4UjaXoVwU99DLo_R6kdVlVf90Yw0S5N6J=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-ne.png\') top right no-repeat" width="6" height="5"><div></div></td></tr><tr><td style="background:url(\'https://ci4.googleusercontent.com/proxy/nt_AIB8tvZvtjQ12K1IxqaM2XPLvZjk-KfB0zxDCUh74WW4hggtOwVMhqJjCPlfdv-7695plB1wt2DOjd6bfj9g6YSYsIWkLks-Sp2OOLZrCHVSNqA=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-w.png\') center left repeat-y" width="6"><div></div></td><td><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;padding-left:20px;padding-right:20px;border-bottom:thin solid #f0f0f0;color:rgba(0,0,0,0.87);font-size:24px;padding-bottom:38px;padding-top:40px;text-align:center;word-break:break-word"><div class="m_57950529551843041v2sp">Hi '.$name.',<br><a style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.87);font-size:12px;line-height:1.8">THANK YOU FOR CREATING A CUSTOMER ACCOUNT AT VIDIEMESTORE.</a></div></div><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:rgba(0,0,0,0.87);line-height:1.6;padding-left:20px;padding-right:20px;padding-bottom:32px;padding-top:24px"><div class="m_57950529551843041v2sp">


        <table class="m_-6053241845862020151m_1333870210502687750MsoNormalTable" border="0" cellpadding="0" width="100%" style="width:100.0%"><tbody><tr><td width="10" style="width:7.5pt;padding:5.25pt 0cm 5.25pt 0cm"><p class="MsoNormal">&nbsp;<u></u><u></u></p></td><td style="padding:5.25pt 0cm 5.25pt 0cm"><div style="border:none;border-bottom:solid #d6d4d4 1.0pt;padding:0cm 0cm 8.0pt 0cm"><p style="margin-right:0cm;margin-bottom:5.25pt;margin-left:0cm;border:none;padding:0cm"><span style="font-size:13.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#555454;text-transform:uppercase">Important Security Tips:<u></u><u></u></span></p></div><ol start="1" type="1"><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Always keep your account details safe.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Never disclose your login details to anyone.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Change your password regularly.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Should you suspect someone is using your account illegally, please notify us immediately.<u></u><u></u></span></li></ol></td><td width="10" style="width:7.5pt;padding:5.25pt 0cm 5.25pt 0cm"><p class="MsoNormal">&nbsp;<u></u><u></u></p></td></tr></tbody></table>

        <div style="padding-top:24px;text-align:center"><a href="" style="display:inline-block;text-decoration:none" target="_blank"><table border="0" cellspacing="0" cellpadding="0" style="background-color:#4184f3;border-radius:2px;min-width:90px"><tbody><tr style="height:6px"></tr><tr><td style="padding-left:8px;padding-right:8px;text-align:center"><a href="'.base_url('sign-in').'" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:#ffffff;font-weight:400;line-height:20px;text-decoration:none;font-size:13px;text-transform:uppercase" target="_blank">Go to Login</a></td></tr><tr style="height:6px"></tr></tbody></table></a></div></div></div></td><td style="background:url(\'https://ci6.googleusercontent.com/proxy/nl-bhiVKfxoOB7l8fKJYsYxLGDXboVNAkOuVf2Uvp0gH24jKX-8iA4BRlejLgTxLKrMUJ_-Bl4tXJPbWh4qe7du3j2u-XwOc4vXL4K7JsVPWNAup3A=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-e.png\') center left repeat-y" width="6"><div></div></td></tr><tr><td style="background:url(\'https://ci3.googleusercontent.com/proxy/jfAHFNbb5XE9oYVyuunjwVJtgqc_knoooAotgLuxEgfAyq_Wjxon4zP-UeAI9LypsjsmD4LIbAkRu_ypi36lEngdVUx92ToChAkh_jvPYFWG0yrUFZu5=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-sw.png\') top left no-repeat" width="6" height="5"><div></div></td><td style="background:url(\'https://ci5.googleusercontent.com/proxy/RniWkHAniZgi6tGOh-m_jRAhJfDZPUcI07_qMnA2H3lz_OgKL92-fTeRX-hGfY0Xe7vmSdFV8JegmJHRXnoFCJ8AHeqnb0WRxPQLPmjroNPBoVQoHg=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-s.png\') top center repeat-x" height="5"><div></div></td><td style="background:url(\'https://ci6.googleusercontent.com/proxy/4eP0Q0IrdbbpIB09xEGV4oCRL6wZSSIR3WUel-pqjhdIMo4ehQk3f-p8izrdtEcVBkwKnVQYEh39DC6hMooGoc7H-q6EL3UH39aLF_9OSzX48i-BopOl=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-se.png\') top left no-repeat" width="6" height="5"><div></div></td></tr><tr><td></td><td><div style="text-align:left"><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:12px;line-height:20px;padding-top:10px"><div><a href="'.base_url().'">vidiem.in</a></div><div style="direction:ltr">1800 12308436 (Toll Free)&nbsp; &nbsp; &nbsp;&nbsp;<a class="m_57950529551843041afal" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:12px;line-height:20px;padding-top:10px" href="mailto:care@vidiem.in">care@vidiem.in</a></div></div><div style="display:none!important;max-height:0px;max-width:0px">1537852187000000</div></div></td><td></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr height="32px"></tr></tbody></table>';
             $this->FunctionModel->sendmail($email,$message,$subject,InfoMail);
            return true;
    }
    
    
    public function GuestWelcomeMail($id){
        $email=$this->FunctionModel->Select_Field('email','vidiem_clients',array('id'=>$id));
        $name=$this->FunctionModel->Select_Field('name','vidiem_clients',array('id'=>$id));
        $password = $this->FunctionModel->NewPassword(6,8);
        $UpdateData=array(
            'password'=>md5($password),
            'modified'=>date('Y-m-d H:i:s')
        );
        $this->FunctionModel->Update($UpdateData,'vidiem_clients',array('id'=>$id));

        $subject='Welcome Mail';
        $message='<table width="100%" height="100%" style="min-width:348px" border="0" cellspacing="0" cellpadding="0"><tbody><tr height="32px"></tr><tr align="center"><td><div><div></div></div><table border="0" cellspacing="0" cellpadding="0" style="padding-bottom:20px;max-width:600px;min-width:220px"><tbody><tr><td><table cellpadding="0" cellspacing="0"><tbody><tr><td></td><td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="direction:ltr;padding-bottom:7px"><tbody><tr><td align="left"><img width="92" height="32" src="'.base_url('assets/front-end/images/logo.png').'" style="width:92px;height:32px" class="CToWUd"></td><td align="right" style="font-family:Roboto-Light,Helvetica,Arial,sans-serif"></td><td align="right" width="35"></td></tr></tbody></table></td><td></td></tr><tr><td style="background:url(\'https://ci5.googleusercontent.com/proxy/Ky9uO0L4rCGl_EWbkifDjpWLd1NFKfi-7b0JFxdVNqqFxNiBhPWyAqs1qKnPjpW5SaR1r77z_cI3vg96-jP6lpbwEfA67jtQsf_zpAF_QNGPg11GKPcs=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-nw.png\') top left no-repeat" width="6" height="5"><div></div></td><td style="background:url(\'https://ci4.googleusercontent.com/proxy/gXzgRO1K9pWfZAogBcrVQnvwQSkX2I8jcnx4g-SvUNfv82pak_4MS_c1aUDeM40soy4koxNBI_ked6U7zrdBUTjETr518K7PLsfDQqhgTKSF2StiCg=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-n.png\') top center repeat-x" height="5"><div></div></td><td style="background:url(\'https://ci5.googleusercontent.com/proxy/FCthMIcyUgO8YTLL_W5YLLOf8y-W7iePJhbY6RQcus60exGI_nmzO0_hpSJ3NY-IfXIgy7OGWAcb9gi34GE4UjaXoVwU99DLo_R6kdVlVf90Yw0S5N6J=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-ne.png\') top right no-repeat" width="6" height="5"><div></div></td></tr><tr><td style="background:url(\'https://ci4.googleusercontent.com/proxy/nt_AIB8tvZvtjQ12K1IxqaM2XPLvZjk-KfB0zxDCUh74WW4hggtOwVMhqJjCPlfdv-7695plB1wt2DOjd6bfj9g6YSYsIWkLks-Sp2OOLZrCHVSNqA=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-w.png\') center left repeat-y" width="6"><div></div></td><td><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;padding-left:20px;padding-right:20px;border-bottom:thin solid #f0f0f0;color:rgba(0,0,0,0.87);font-size:24px;padding-bottom:38px;padding-top:40px;text-align:center;word-break:break-word"><div class="m_57950529551843041v2sp">Hi '.$name.',<br><a style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.87);font-size:12px;line-height:1.8">THANK YOU FOR CREATING A CUSTOMER ACCOUNT AT VIDIEMESTORE.</a></div></div><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:rgba(0,0,0,0.87);line-height:1.6;padding-left:20px;padding-right:20px;padding-bottom:32px;padding-top:24px"><div class="m_57950529551843041v2sp">


        <table class="m_-6053241845862020151m_1333870210502687750MsoNormalTable" border="0" cellpadding="0" width="100%" style="width:100.0%"><tbody><tr><td width="10" style="width:7.5pt;padding:5.25pt 0cm 5.25pt 0cm"><p class="MsoNormal">&nbsp;<u></u><u></u></p></td><td style="padding:5.25pt 0cm 5.25pt 0cm"><div style="border:none;border-bottom:solid #d6d4d4 1.0pt;padding:0cm 0cm 8.0pt 0cm"><p style="margin-right:0cm;margin-bottom:5.25pt;margin-left:0cm;border:none;padding:0cm"><span style="font-size:13.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#555454;text-transform:uppercase">Important Security Tips:<u></u><u></u></span></p></div><ol start="1" type="1"><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Always keep your account details safe.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Never disclose your login details to anyone.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Change your password regularly.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Should you suspect someone is using your account illegally, please notify us immediately.<u></u><u></u></span></li></ol></td><td width="10" style="width:7.5pt;padding:5.25pt 0cm 5.25pt 0cm"><p class="MsoNormal">&nbsp;<u></u><u></u></p></td></tr></tbody></table>

        <div style="padding-top:24px;text-align:center"><a href="" style="display:inline-block;text-decoration:none" target="_blank"><table border="0" cellspacing="0" cellpadding="0" style="background-color:#4184f3;border-radius:2px;min-width:90px"><tbody><tr style="height:6px"></tr><tr><td style="padding-left:8px;padding-right:8px;text-align:center"><a href="'.base_url('sign-in').'" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:#ffffff;font-weight:400;line-height:20px;text-decoration:none;font-size:13px;text-transform:uppercase" target="_blank">Go to Login</a></td></tr><tr style="height:6px"></tr></tbody></table></a></div></div></div></td><td style="background:url(\'https://ci6.googleusercontent.com/proxy/nl-bhiVKfxoOB7l8fKJYsYxLGDXboVNAkOuVf2Uvp0gH24jKX-8iA4BRlejLgTxLKrMUJ_-Bl4tXJPbWh4qe7du3j2u-XwOc4vXL4K7JsVPWNAup3A=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-e.png\') center left repeat-y" width="6"><div></div></td></tr><tr><td style="background:url(\'https://ci3.googleusercontent.com/proxy/jfAHFNbb5XE9oYVyuunjwVJtgqc_knoooAotgLuxEgfAyq_Wjxon4zP-UeAI9LypsjsmD4LIbAkRu_ypi36lEngdVUx92ToChAkh_jvPYFWG0yrUFZu5=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-sw.png\') top left no-repeat" width="6" height="5"><div></div></td><td style="background:url(\'https://ci5.googleusercontent.com/proxy/RniWkHAniZgi6tGOh-m_jRAhJfDZPUcI07_qMnA2H3lz_OgKL92-fTeRX-hGfY0Xe7vmSdFV8JegmJHRXnoFCJ8AHeqnb0WRxPQLPmjroNPBoVQoHg=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-s.png\') top center repeat-x" height="5"><div></div></td><td style="background:url(\'https://ci6.googleusercontent.com/proxy/4eP0Q0IrdbbpIB09xEGV4oCRL6wZSSIR3WUel-pqjhdIMo4ehQk3f-p8izrdtEcVBkwKnVQYEh39DC6hMooGoc7H-q6EL3UH39aLF_9OSzX48i-BopOl=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-se.png\') top left no-repeat" width="6" height="5"><div></div></td></tr><tr><td></td><td><div style="text-align:left"><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:12px;line-height:20px;padding-top:10px"><div><a href="'.base_url().'">vidiem.in</a></div><div style="direction:ltr">1800 12308436 (Toll Free)&nbsp; &nbsp; &nbsp;&nbsp;<a class="m_57950529551843041afal" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:12px;line-height:20px;padding-top:10px" href="mailto:care@vidiem.in">care@vidiem.in</a></div></div><div style="display:none!important;max-height:0px;max-width:0px">1537852187000000</div></div></td><td></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr height="32px"></tr></tbody></table>';
             $this->FunctionModel->sendmail($email,$message,$subject,InfoMail);


             // Password Mail
           $subject='Password for Vidiem Website';
        $message='<table width="100%" height="100%" style="min-width:348px" border="0" cellspacing="0" cellpadding="0"><tbody><tr height="32px"></tr><tr align="center"><td><div><div></div></div><table border="0" cellspacing="0" cellpadding="0" style="padding-bottom:20px;max-width:600px;min-width:220px"><tbody><tr><td><table cellpadding="0" cellspacing="0"><tbody><tr><td></td><td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="direction:ltr;padding-bottom:7px"><tbody><tr><td align="left"><img width="92" height="32" src="'.base_url('assets/front-end/images/logo.png').'" style="width:92px;height:32px" class="CToWUd"></td><td align="right" style="font-family:Roboto-Light,Helvetica,Arial,sans-serif"></td><td align="right" width="35"></td></tr></tbody></table></td><td></td></tr><tr><td style="background:url(\'https://ci5.googleusercontent.com/proxy/Ky9uO0L4rCGl_EWbkifDjpWLd1NFKfi-7b0JFxdVNqqFxNiBhPWyAqs1qKnPjpW5SaR1r77z_cI3vg96-jP6lpbwEfA67jtQsf_zpAF_QNGPg11GKPcs=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-nw.png\') top left no-repeat" width="6" height="5"><div></div></td><td style="background:url(\'https://ci4.googleusercontent.com/proxy/gXzgRO1K9pWfZAogBcrVQnvwQSkX2I8jcnx4g-SvUNfv82pak_4MS_c1aUDeM40soy4koxNBI_ked6U7zrdBUTjETr518K7PLsfDQqhgTKSF2StiCg=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-n.png\') top center repeat-x" height="5"><div></div></td><td style="background:url(\'https://ci5.googleusercontent.com/proxy/FCthMIcyUgO8YTLL_W5YLLOf8y-W7iePJhbY6RQcus60exGI_nmzO0_hpSJ3NY-IfXIgy7OGWAcb9gi34GE4UjaXoVwU99DLo_R6kdVlVf90Yw0S5N6J=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-ne.png\') top right no-repeat" width="6" height="5"><div></div></td></tr><tr><td style="background:url(\'https://ci4.googleusercontent.com/proxy/nt_AIB8tvZvtjQ12K1IxqaM2XPLvZjk-KfB0zxDCUh74WW4hggtOwVMhqJjCPlfdv-7695plB1wt2DOjd6bfj9g6YSYsIWkLks-Sp2OOLZrCHVSNqA=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-w.png\') center left repeat-y" width="6"><div></div></td><td><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;padding-left:20px;padding-right:20px;border-bottom:thin solid #f0f0f0;color:rgba(0,0,0,0.87);font-size:24px;padding-bottom:38px;padding-top:40px;text-align:center;word-break:break-word"><div class="m_57950529551843041v2sp">Your Password for Vidiem Website<br><a style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.87);font-size:16px;line-height:1.8">'.$password.'</a></div></div><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:rgba(0,0,0,0.87);line-height:1.6;padding-left:20px;padding-right:20px;padding-bottom:32px;padding-top:24px"><div class="m_57950529551843041v2sp">



<table class="m_-6053241845862020151m_1333870210502687750MsoNormalTable" border="0" cellpadding="0" width="100%" style="width:100.0%"><tbody><tr><td width="10" style="width:7.5pt;padding:5.25pt 0cm 5.25pt 0cm"><p class="MsoNormal">&nbsp;<u></u><u></u></p></td><td style="padding:5.25pt 0cm 5.25pt 0cm"><div style="border:none;border-bottom:solid #d6d4d4 1.0pt;padding:0cm 0cm 8.0pt 0cm"><p style="margin-right:0cm;margin-bottom:5.25pt;margin-left:0cm;border:none;padding:0cm"><span style="font-size:13.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#555454;text-transform:uppercase">Important Security Tips:<u></u><u></u></span></p></div><ol start="1" type="1"><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Always keep your account details safe.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Never disclose your login details to anyone.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Change your password regularly.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Should you suspect someone is using your account illegally, please notify us immediately.<u></u><u></u></span></li></ol></td><td width="10" style="width:7.5pt;padding:5.25pt 0cm 5.25pt 0cm"><p class="MsoNormal">&nbsp;<u></u><u></u></p></td></tr></tbody></table>



        <div style="padding-top:24px;text-align:center"><a href="'.base_url('sign-in').'" style="display:inline-block;text-decoration:none" target="_blank"><table border="0" cellspacing="0" cellpadding="0" style="background-color:#4184f3;border-radius:2px;min-width:90px"><tbody><tr style="height:6px"></tr><tr><td style="padding-left:8px;padding-right:8px;text-align:center"><a href="'.base_url('sign-in').'" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:#ffffff;font-weight:400;line-height:20px;text-decoration:none;font-size:13px;text-transform:uppercase" target="_blank">Go to Login</a></td></tr><tr style="height:6px"></tr></tbody></table></a></div></div></div></td><td style="background:url(\'https://ci6.googleusercontent.com/proxy/nl-bhiVKfxoOB7l8fKJYsYxLGDXboVNAkOuVf2Uvp0gH24jKX-8iA4BRlejLgTxLKrMUJ_-Bl4tXJPbWh4qe7du3j2u-XwOc4vXL4K7JsVPWNAup3A=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-e.png\') center left repeat-y" width="6"><div></div></td></tr><tr><td style="background:url(\'https://ci3.googleusercontent.com/proxy/jfAHFNbb5XE9oYVyuunjwVJtgqc_knoooAotgLuxEgfAyq_Wjxon4zP-UeAI9LypsjsmD4LIbAkRu_ypi36lEngdVUx92ToChAkh_jvPYFWG0yrUFZu5=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-sw.png\') top left no-repeat" width="6" height="5"><div></div></td><td style="background:url(\'https://ci5.googleusercontent.com/proxy/RniWkHAniZgi6tGOh-m_jRAhJfDZPUcI07_qMnA2H3lz_OgKL92-fTeRX-hGfY0Xe7vmSdFV8JegmJHRXnoFCJ8AHeqnb0WRxPQLPmjroNPBoVQoHg=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-s.png\') top center repeat-x" height="5"><div></div></td><td style="background:url(\'https://ci6.googleusercontent.com/proxy/4eP0Q0IrdbbpIB09xEGV4oCRL6wZSSIR3WUel-pqjhdIMo4ehQk3f-p8izrdtEcVBkwKnVQYEh39DC6hMooGoc7H-q6EL3UH39aLF_9OSzX48i-BopOl=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-se.png\') top left no-repeat" width="6" height="5"><div></div></td></tr><tr><td></td><td><div style="text-align:left"><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:12px;line-height:20px;padding-top:10px"><div><a href="'.base_url().'">vidiem.in</a></div><div style="direction:ltr">1800 12308436 (Toll Free)&nbsp; &nbsp; &nbsp;&nbsp;<a class="m_57950529551843041afal" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:12px;line-height:20px;padding-top:10px" href="mailto:care@vidiem.in">care@vidiem.in</a></div></div><div style="display:none!important;max-height:0px;max-width:0px">1537852187000000</div></div></td><td></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr height="32px"></tr></tbody></table>';
        
            $this->FunctionModel->sendmail($email,$message,$subject,InfoMail);
            return true;
    }


    public function SentNewPassword($id){

        $email=$this->FunctionModel->Select_Field('email','vidiem_clients',array('id'=>$id));
        $password = $this->FunctionModel->NewPassword(6,8);
        $UpdateData=array(
            'password'=>md5($password),
            'modified'=>date('Y-m-d H:i:s')
        );
        $this->FunctionModel->Update($UpdateData,'vidiem_clients',array('id'=>$id));

        $subject='Password Reset - Vidiem';
        $message='<table width="100%" height="100%" style="min-width:348px" border="0" cellspacing="0" cellpadding="0"><tbody><tr height="32px"></tr><tr align="center"><td><div><div></div></div><table border="0" cellspacing="0" cellpadding="0" style="padding-bottom:20px;max-width:600px;min-width:220px"><tbody><tr><td><table cellpadding="0" cellspacing="0"><tbody><tr><td></td><td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="direction:ltr;padding-bottom:7px"><tbody><tr><td align="left"><img width="92" height="32" src="'.base_url('assets/front-end/images/logo.png').'" style="width:92px;height:32px" class="CToWUd"></td><td align="right" style="font-family:Roboto-Light,Helvetica,Arial,sans-serif"></td><td align="right" width="35"></td></tr></tbody></table></td><td></td></tr><tr><td style="background:url(\'https://ci5.googleusercontent.com/proxy/Ky9uO0L4rCGl_EWbkifDjpWLd1NFKfi-7b0JFxdVNqqFxNiBhPWyAqs1qKnPjpW5SaR1r77z_cI3vg96-jP6lpbwEfA67jtQsf_zpAF_QNGPg11GKPcs=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-nw.png\') top left no-repeat" width="6" height="5"><div></div></td><td style="background:url(\'https://ci4.googleusercontent.com/proxy/gXzgRO1K9pWfZAogBcrVQnvwQSkX2I8jcnx4g-SvUNfv82pak_4MS_c1aUDeM40soy4koxNBI_ked6U7zrdBUTjETr518K7PLsfDQqhgTKSF2StiCg=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-n.png\') top center repeat-x" height="5"><div></div></td><td style="background:url(\'https://ci5.googleusercontent.com/proxy/FCthMIcyUgO8YTLL_W5YLLOf8y-W7iePJhbY6RQcus60exGI_nmzO0_hpSJ3NY-IfXIgy7OGWAcb9gi34GE4UjaXoVwU99DLo_R6kdVlVf90Yw0S5N6J=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-ne.png\') top right no-repeat" width="6" height="5"><div></div></td></tr><tr><td style="background:url(\'https://ci4.googleusercontent.com/proxy/nt_AIB8tvZvtjQ12K1IxqaM2XPLvZjk-KfB0zxDCUh74WW4hggtOwVMhqJjCPlfdv-7695plB1wt2DOjd6bfj9g6YSYsIWkLks-Sp2OOLZrCHVSNqA=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-w.png\') center left repeat-y" width="6"><div></div></td><td><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;padding-left:20px;padding-right:20px;border-bottom:thin solid #f0f0f0;color:rgba(0,0,0,0.87);font-size:24px;padding-bottom:38px;padding-top:40px;text-align:center;word-break:break-word"><div class="m_57950529551843041v2sp">Your New Password<br><a style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.87);font-size:16px;line-height:1.8">'.$password.'</a></div></div><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:rgba(0,0,0,0.87);line-height:1.6;padding-left:20px;padding-right:20px;padding-bottom:32px;padding-top:24px"><div class="m_57950529551843041v2sp">



<table class="m_-6053241845862020151m_1333870210502687750MsoNormalTable" border="0" cellpadding="0" width="100%" style="width:100.0%"><tbody><tr><td width="10" style="width:7.5pt;padding:5.25pt 0cm 5.25pt 0cm"><p class="MsoNormal">&nbsp;<u></u><u></u></p></td><td style="padding:5.25pt 0cm 5.25pt 0cm"><div style="border:none;border-bottom:solid #d6d4d4 1.0pt;padding:0cm 0cm 8.0pt 0cm"><p style="margin-right:0cm;margin-bottom:5.25pt;margin-left:0cm;border:none;padding:0cm"><span style="font-size:13.5pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:#555454;text-transform:uppercase">Important Security Tips:<u></u><u></u></span></p></div><ol start="1" type="1"><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Always keep your account details safe.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Never disclose your login details to anyone.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Change your password regularly.<u></u><u></u></span></li><li class="MsoNormal" style="color:#555454"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Should you suspect someone is using your account illegally, please notify us immediately.<u></u><u></u></span></li></ol></td><td width="10" style="width:7.5pt;padding:5.25pt 0cm 5.25pt 0cm"><p class="MsoNormal">&nbsp;<u></u><u></u></p></td></tr></tbody></table>



        <div style="padding-top:24px;text-align:center"><a href="'.base_url('sign-in').'" style="display:inline-block;text-decoration:none" target="_blank"><table border="0" cellspacing="0" cellpadding="0" style="background-color:#4184f3;border-radius:2px;min-width:90px"><tbody><tr style="height:6px"></tr><tr><td style="padding-left:8px;padding-right:8px;text-align:center"><a href="'.base_url('sign-in').'" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:#ffffff;font-weight:400;line-height:20px;text-decoration:none;font-size:13px;text-transform:uppercase" target="_blank">Go to Login</a></td></tr><tr style="height:6px"></tr></tbody></table></a></div></div></div></td><td style="background:url(\'https://ci6.googleusercontent.com/proxy/nl-bhiVKfxoOB7l8fKJYsYxLGDXboVNAkOuVf2Uvp0gH24jKX-8iA4BRlejLgTxLKrMUJ_-Bl4tXJPbWh4qe7du3j2u-XwOc4vXL4K7JsVPWNAup3A=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-e.png\') center left repeat-y" width="6"><div></div></td></tr><tr><td style="background:url(\'https://ci3.googleusercontent.com/proxy/jfAHFNbb5XE9oYVyuunjwVJtgqc_knoooAotgLuxEgfAyq_Wjxon4zP-UeAI9LypsjsmD4LIbAkRu_ypi36lEngdVUx92ToChAkh_jvPYFWG0yrUFZu5=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-sw.png\') top left no-repeat" width="6" height="5"><div></div></td><td style="background:url(\'https://ci5.googleusercontent.com/proxy/RniWkHAniZgi6tGOh-m_jRAhJfDZPUcI07_qMnA2H3lz_OgKL92-fTeRX-hGfY0Xe7vmSdFV8JegmJHRXnoFCJ8AHeqnb0WRxPQLPmjroNPBoVQoHg=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-pixel-s.png\') top center repeat-x" height="5"><div></div></td><td style="background:url(\'https://ci6.googleusercontent.com/proxy/4eP0Q0IrdbbpIB09xEGV4oCRL6wZSSIR3WUel-pqjhdIMo4ehQk3f-p8izrdtEcVBkwKnVQYEh39DC6hMooGoc7H-q6EL3UH39aLF_9OSzX48i-BopOl=s0-d-e1-ft#https://www.gstatic.com/accountalerts/email/hodor/4-corner-se.png\') top left no-repeat" width="6" height="5"><div></div></td></tr><tr><td></td><td><div style="text-align:left"><div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:12px;line-height:20px;padding-top:10px"><div><a href="'.base_url().'">vidiem.in</a></div><div style="direction:ltr">1800 12308436 (Toll Free)&nbsp; &nbsp; &nbsp;&nbsp;<a class="m_57950529551843041afal" style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;color:rgba(0,0,0,0.54);font-size:12px;line-height:20px;padding-top:10px" href="mailto:care@vidiem.in">care@vidiem.in</a></div></div><div style="display:none!important;max-height:0px;max-width:0px">1537852187000000</div></div></td><td></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr height="32px"></tr></tbody></table>';
        
            $this->FunctionModel->sendmail($email,$message,$subject,InfoMail);
            return true;
    }
    
    public function ProductRevisionUpdate($id,$type){
        $pro_info=$this->FunctionModel->Select_Row('vidiem_products',['id'=>$id]);
        $InsertData=[
            'rev_parent_id'=>$id,
            'rev_type'=>$type,
            'rev_time'=>date('Y-m-d H:i:s'),
            'user_name'=>$this->session->userdata('user_name'),
            'cat_name'=>$this->FunctionModel->Select_Field('name','vidiem_category',['id'=>$pro_info['cat_id']]),
            'sub_cat_name'=>$this->FunctionModel->Select_Field('name','vidiem_category',['id'=>$pro_info['sub_cat_id']]),
            'name'=>$pro_info['name'],
            'modal_no'=>$pro_info['modal_no'],
            'short_description'=>$pro_info['short_description'],
            'list_description'=>$pro_info['list_description'],
            'description'=>$pro_info['description'],
            'search_keywords'=>$pro_info['search_keywords'],
            'key_feature_image'=>$pro_info['key_feature_image'],
            'key_feature'=>$pro_info['key_feature'],
            'warranty'=>$pro_info['warranty'],
            'manual'=>$pro_info['manual'],
            'price'=>$pro_info['price'],
            'old_price'=>$pro_info['old_price'],
            'featured'=>$pro_info['featured'],
            'new_launches'=>$pro_info['new_launches'],
            'outofstock'=>$pro_info['outofstock'],
            'order_no'=>$pro_info['order_no'],
            'meta_title'=>$pro_info['meta_title'],
            'meta_description'=>$pro_info['meta_description'],
            'meta_keywords'=>$pro_info['meta_keywords'],
            'status'=>$pro_info['status'],
            'rating'=>$pro_info['rating'],
            'modified'=>$pro_info['modified'],
            'created'=>$pro_info['created'],
        ];
        $this->FunctionModel->Insert($InsertData,'vidiem_products_revision');
        return true;
    }
    public function deletedProductList(){
        $data=$this->db->get_where('vidiem_products_revision',['rev_type'=>'deleted'])->result_array();
        return $data;
    }

    public function CategoryRevisionUpdate($id,$type){
        $cat_info=$this->FunctionModel->Select_Row('vidiem_category',['id'=>$id]);
        $InsertData=[
            'rev_parent_id'=>$id,
            'rev_type'=>$type,
            'rev_time'=>date('Y-m-d H:i:s'),
            'user_name'=>$this->session->userdata('user_name'),
            'name'=>$cat_info['name'],
            'banner_image'=>$cat_info['banner_image'],
            'banner_url'=>$cat_info['banner_url'],
            'image'=>$cat_info['image'],
            'description'=>$cat_info['description'],
            'search_keywords'=>$cat_info['search_keywords'],
            'featured'=>$cat_info['featured'],
            'order_no'=>$cat_info['order_no'],
            'meta_title'=>$cat_info['meta_title'],
            'meta_description'=>$cat_info['meta_description'],
            'meta_keywords'=>$cat_info['meta_keywords'],
            'content'=>$cat_info['content'],
            'status'=>$cat_info['status'],
            'modified'=>$cat_info['modified'],
            'created'=>$cat_info['created'],
        ];
        $this->FunctionModel->Insert($InsertData,'vidiem_category_revision');
        return true;
    }

    public function deletedCategoryList(){
        $data=$this->db->get_where('vidiem_category_revision',['rev_type'=>'deleted'])->result_array();
        return $data;
    }
    
    public function productRegistrationList($list='list',$where=array(),$custom=null,$search=false,$order=false){
        $this->db->select('r.*');
        $this->db->where($where);   
        if($search){    
            $this->db->group_start();   
            foreach($search as $filed=>$value){ 
                $this->db->or_like($filed,$value);      
            }   
            $this->db->group_end();     
        }   
        if($order){ 
            $this->db->order_by($order['field'],$order['type']);    
        }else{  
            $this->db->order_by('r.created','desc');  
        }   
        if($list=='list'){  
            return $this->db->get_where('vidiem_product_registration r',array(),$this->input->post('length'),(int)$this->input->post('start'))->result_array();   
        }else{  
            $count=$this->db->count_all_results('vidiem_product_registration r'); 
            return (int)$count; 
        }   
    }


    public function complaintRegistrationList($list='list',$where=array(),$custom=null,$search=false,$order=false){
        $this->db->select('r.*,c.name as category_name,p.name as product_name');
        $this->db->join('vidiem_category c','c.id=r.category');
        $this->db->join('vidiem_products p','p.id=r.product');
        $this->db->where($where);   
        if($search){    
            $this->db->group_start();   
            foreach($search as $filed=>$value){ 
                $this->db->or_like($filed,$value);      
            }   
            $this->db->group_end();     
        }   
        if($order){ 
            $this->db->order_by($order['field'],$order['type']);    
        }else{  
            $this->db->order_by('r.created','desc');  
        }   
        if($list=='list'){  
            return $this->db->get_where('vidiem_complaint_registration r',array(),$this->input->post('length'),(int)$this->input->post('start'))->result_array();   
        }else{  
            $count=$this->db->count_all_results('vidiem_complaint_registration r'); 
            return (int)$count; 
        }   
    }

    public function complaintRegistrationExport(){
        $this->db->select('r.code as `Ref Code`,c.name as `Category Name`,p.name as `Product Name`,r.serialnumer as `Serial Number`,r.purchase_date as `Purchase Date`,r.dealername as `Dealer Name`,r.remarks as `Remarks`,r.gender as `Gender`,r.name as `Name`,r.email as `Email`,r.mobile as `Mobile No`,r.alternative_mobile as `Alt Mobile No`,r.occupation as `Occupation`,r.address as `Address`,r.city as `City`,r.state as `State`,r.pincode as `Pincode`,r.created as `Created`');
        $this->db->join('vidiem_category c','c.id=r.category');
        $this->db->join('vidiem_products p','p.id=r.product');
        $this->db->order_by('r.created','desc');  
        return $this->db->get_where('vidiem_complaint_registration r')->result_array();
    }

    public function productRegistrationExport(){
        $this->db->select('code as `Ref Code`,Product as `Product`,jdate as `Purchase Date`,serialnumer as `Serial Number`,dealername as `Dealer Name`,gender as `Gender`,name as `Name`,age as `Age`,email as `Email`,mobile as `Mobile No`,occupation as `Occupation`,address as `Address`,city as `City`,state as `State`,pincode as `Pincode`,created as `Created`');
        // $this->db->select('code as `Ref Code`,Product as `Product`,jdate as `Purchase Date`,serialnumer as `Serial Number`,dealername as `Dealer Name`,gender as `Gender`,name as `Name`,age as `Age`,email as `Email`,mobile as `Mobile No`,occupation as `Occupation`,city as `City`,state as `State`,pincode as `Pincode`,created as `Created`');
        $this->db->order_by('created','desc');  
        return $this->db->get_where('vidiem_product_registration')->result_array();
    }
}

