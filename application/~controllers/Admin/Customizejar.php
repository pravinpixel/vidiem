<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class customizejar extends CI_Controller {
	   function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->model(array('Accessmodel'));
		
	
		
        if(!$this->session->userdata('user_logged_in')){
          $this->session->set_flashdata('class', "alert-danger");
          $this->session->set_flashdata('icon', "fa-warning");
          $this->session->set_flashdata('msg', "Access Denied.");
          redirect('Admin', 'refresh');
		    }
    }


    public function index(){
		if(hasPermission('customizable_index') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
        $this->load->view('Backend/customizejar/index');
    }

    public function create()
    {
        if(hasPermission('customizable_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		 $data['action'] =  "Create";
		 $data['categories'] = $this->FunctionModel->Select_Fields('name,id','vidiem_category',array('status'=>1,"parent_id"=>"0"));
		 $data['typeofhandle'] = $this->FunctionModel->Select_Fields('typeofhandlename as name,typeofhandle_id as id','vidiem_typeofhandle',array('isactive'=>1));
		 $data['typeoflid'] = $this->FunctionModel->Select_Fields('typeoflidname as name,typeoflid_id as id','vidiem_typeoflid',array('isactive'=>1));
		 $data['typeofjar'] = $this->FunctionModel->Select_Fields('typeofjarname as name,typeofjar_id as id','vidiem_typeofjar',array('isactive'=>1));
		 $data['capacity'] = $this->FunctionModel->Select_Fields('capacityname as name,capacity_id as id','vidiem_capacity',array('isactive'=>1));
		 $data['motor'] = $this->FunctionModel->Select_Fields('motorname as name,motor_id as id','vidiem_motors',array('isactive'=>1));
		 
		
				
        $this->load->view('Backend/customizejar/form',$data);
    }

    public function save()
    {
        if(hasPermission('customizable_add') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
        if($this->input->method() == 'post') {
            $this->form_validation->set_rules('name', 'Jar name', 'trim|required|edit_unique_customize[vidiem_jar.name.category_id.jar_id.'.$id.']');
			$this->form_validation->set_rules('price','Price','required');	
			$this->form_validation->set_rules('code','Code','required');	
			$this->form_validation->set_rules('typeofhandle_id','Type of handle','required');	
			$this->form_validation->set_rules('typeoflid_id','Type of lid','required');	
			$this->form_validation->set_rules('typeofjar_id','Type of jar','required');
			$this->form_validation->set_rules('basepath','Image','callback_image_upload');
            if ($this->form_validation->run() == FALSE) { 
			//echo "jjj"; die();
				  $data['action']="Create";
				  $data['dataitems']['name'] =  ltrim($this->input->post('name'));	
				  $data['typeofhandle'] = $this->FunctionModel->Select_Fields('typeofhandlename as name,typeofhandle_id as id','vidiem_typeofhandle',array('isactive'=>1));
		$data['typeoflid'] = $this->FunctionModel->Select_Fields('typeoflidname as name,typeoflid_id as id','vidiem_typeoflid',array('isactive'=>1));
		$data['typeofjar'] = $this->FunctionModel->Select_Fields('typeofjarname as name,typeofjar_id as id','vidiem_typeofjar',array('isactive'=>1));
		$data['categories'] = $this->FunctionModel->Select_Fields('name,id','vidiem_category',array('status'=>1,"parent_id"=>"0"));
		 $data['capacity'] = $this->FunctionModel->Select_Fields('capacityname as name,capacity_id as id','vidiem_capacity',array('isactive'=>1));
		 $data['motor'] = $this->FunctionModel->Select_Fields('motorname as name,motor_id as id','vidiem_motors',array('isactive'=>1));
		 
		 
		 
                return $this->load->view('Backend/customizejar/form',$data); 
            }
			
			//print_r($this->input->post());
			//die();
			
			 $createdatavalue = [
                "name"    => ltrim($this->input->post('name')),
                "code"    => ltrim($this->input->post('code')),
				"category_id"    => ltrim($this->input->post('category_id')),
				"typeofjar_id"    => ltrim($this->input->post('typeofjar_id')),
				"typeofhandle_id"    => ltrim($this->input->post('typeofhandle_id')),
				"typeoflid_id"    => ltrim($this->input->post('typeoflid_id')),
				"capacity_id"    => ltrim($this->input->post('capacity_id')),
				"description"    => ltrim($this->input->post('description')),
				"basepath"    => $this->upload_data['file']['file_name'],
				"price"    => ltrim($this->input->post('price')),
				"ismultichef"    => ltrim($this->input->post('ismultichef')),
				"sortby"=>ltrim($this->input->post('sortby')),
				"userid" 	=> $this->session->userdata("user_id"),
				"createddate"        => Date('Y-m-d H:i:s'),	
                "modifieddate"        =>Date('Y-m-d H:i:s'),	
            ];
            $result = $this->FunctionModel->Insert($createdatavalue,'vidiem_jar',array('jar_id' => $id));
			
			
           
            if( $result ) {
			if(count($this->input->post('motors'))>0){	
				$motor_jar=array();
			
				foreach($this->input->post('motors') as $m)
				{
					$motor_jar=array("motor_id"=> $m,	
										"jar_id"=>$result,
										"userid" 	=> $this->session->userdata("user_id"),
										"createddate"        => Date('Y-m-d H:i:s'),	
										"modifieddate"        =>Date('Y-m-d H:i:s'));
										
			//	print_r($motor_jar); die();						
										
				$result1 = $this->FunctionModel->Insert($motor_jar,'vidiem_motors_jars');						
				}
				 
			}	
				
				
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Added Successfully.");
            } else {
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
            }
            return redirect('Admin/customizejar/index');
            }
        
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/customizejar/index');
    }

    public function edit($id) 
    {
        if(hasPermission('customizable_update') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
		 $data['action'] =  "Edit";
        $data['dataitems'] = $this->CustomizeModel->GetJarById($id,"vidiem_jar","jar_id");
		
		//print_r($data['dataitems']); die();
		
		$data['typeofhandle'] = $this->FunctionModel->Select_Fields('typeofhandlename as name,typeofhandle_id as id','vidiem_typeofhandle',array('isactive'=>1));
		$data['typeoflid'] = $this->FunctionModel->Select_Fields('typeoflidname as name,typeoflid_id as id','vidiem_typeoflid',array('isactive'=>1));
		$data['typeofjar'] = $this->FunctionModel->Select_Fields('typeofjarname as name,typeofjar_id as id','vidiem_typeofjar',array('isactive'=>1));
		 $data['motor'] = $this->FunctionModel->Select_Fields('motorname as name,motor_id as id','vidiem_motors',array('isactive'=>1));
		 $data['capacity'] = $this->FunctionModel->Select_Fields('capacityname as name,capacity_id as id','vidiem_capacity',array('isactive'=>1));
		
        if(empty($data['dataitems'])) {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Data not found.");
            return redirect('Admin/customizejar/index');
        }
		 $data['categories'] = $this->FunctionModel->Select_Fields('name,id','vidiem_category',array('status'=>1,"parent_id"=>"0"));
		
        return $this->load->view('Backend/customizejar/form',$data);
    }

    public function update($id)
    {
		
	    if(hasPermission('customizable_update') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
        if($this->input->method() == 'post') {
		
		//echo "ggg"; die();
            $this->form_validation->set_rules('name', 'Jar name', 'trim|required|edit_unique_customize[vidiem_jar.name.category_id.jar_id.'.$id.']');
		  	$this->form_validation->set_rules('price','Price','required');	
		  	$this->form_validation->set_rules('code','Code','required');	
			$this->form_validation->set_rules('typeofhandle_id','Type of handle','required');	
			$this->form_validation->set_rules('typeoflid_id','Type of Lid','required');	
			$this->form_validation->set_rules('typeofjar_id','Type of jar','required');		
			$this->form_validation->set_rules('basepath','Image','callback_edit_image_upload['.$id.']');
            if ($this->form_validation->run() == FALSE) { 
			//echo "hhh"; die();
        $data['dataitems'] = $this->CustomizeModel->GetJarById($id,"vidiem_jar","jar_id");
		$data['typeofhandle'] = $this->FunctionModel->Select_Fields('typeofhandlename as name,typeofhandle_id as id','vidiem_typeofhandle',array('isactive'=>1));
		$data['typeoflid'] = $this->FunctionModel->Select_Fields('typeoflidname as name,typeoflid_id as id','vidiem_typeoflid',array('isactive'=>1));
		$data['typeofjar'] = $this->FunctionModel->Select_Fields('typeofjarname as name,typeofjar_id as id','vidiem_typeofjar',array('isactive'=>1));
		$data['categories'] = $this->FunctionModel->Select_Fields('name,id','vidiem_category',array('status'=>1,"parent_id"=>"0"));
		$data['motor'] = $this->FunctionModel->Select_Fields('motorname as name,motor_id as id','vidiem_motors',array('isactive'=>1));
		$data['capacity'] = $this->FunctionModel->Select_Fields('capacityname as name,capacity_id as id','vidiem_capacity',array('isactive'=>1));
		
		 
				$data['action']="Edit";
                return $this->load->view('Backend/customizejar/form',$data); 
            }
            $updatedatavalue = [
                "name"    => ltrim($this->input->post('name')),
                "code"    => ltrim($this->input->post('code')),
				"category_id"    => ltrim($this->input->post('category_id')),
				"typeofjar_id"    => ltrim($this->input->post('typeofjar_id')),
				"typeofhandle_id"    => ltrim($this->input->post('typeofhandle_id')),
				"typeoflid_id"    => ltrim($this->input->post('typeoflid_id')),
				"capacity_id"    => ltrim($this->input->post('capacity_id')),
				"description"    => ltrim($this->input->post('description')),
				"basepath"    => $this->upload_data['file']['file_name'],
				"price"    => ltrim($this->input->post('price')),
				"ismultichef"    => ltrim($this->input->post('ismultichef')),
				"sortby"=>ltrim($this->input->post('sortby')),
				"userid" 	=> $this->session->userdata("user_id"),			
                "modifieddate"        =>Date('Y-m-d H:i:s'),	
            ];
			
			
            $result = $this->FunctionModel->Update($updatedatavalue,'vidiem_jar',array('jar_id' => $id));
            if( $result ) {
							
				if(count($this->input->post('motors'))>0){	
				$motor_jar=array();
				
				 $existmotor = $this->FunctionModel->Select_Fields('group_concat(motor_id) as id','vidiem_motors_jars',array('isactive'=>1,'jar_id' => $id));
				
				 $exist_motor_data= explode(",",$existmotor[0]['id']);
				 
			 	$Deletemotor =array_diff($exist_motor_data,$this->input->post('motors'));
				$Insertmotor =array_diff($this->input->post('motors'),$exist_motor_data);
				
								 
				foreach($Deletemotor as $m)
				{
				
					$motor_jar=array("isactive"     => "2",
									"userid" 	=> $this->session->userdata("user_id"),	
									"modifieddate"        => Date('Y-m-d H:i:s'));
										
							
				  $result = $this->FunctionModel->Update($motor_jar,'vidiem_motors_jars',array('jar_id' => $id,"motor_id"=>$m));						
				
				}			 
		
				foreach($Insertmotor as $m)
				{
					$motor_jar=array("motor_id"=> $m,	
										"jar_id"=>$result,
										"userid" 	=> $this->session->userdata("user_id"),
										"createddate"        => Date('Y-m-d H:i:s'),	
										"modifieddate"        =>Date('Y-m-d H:i:s'));
										
							
										
				$result1 = $this->FunctionModel->Insert($motor_jar,'vidiem_motors_jars');	
				
				}
				
			}					
				
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Update Successfully.");
            }

            return redirect('Admin/customizejar/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/customizejar/index');
    }

    public function status($id) 
    {
        if($this->input->method() == 'post') {
            $dataarr = $this->CustomizeModel->GetJarById($id,"vidiem_jar","jar_id");
            $update_status = [
                "isactive"     => !(int)$dataarr->isactive,
				"userid" 	=> $this->session->userdata("user_id"),	
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
       
            $result = $this->FunctionModel->Update($update_status,'vidiem_jar',array('jar_id' => $id));
			
			// print_r($this->db->last_query());  
		  // die();
			
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Status Update Successfully.");
            }
            return redirect('Admin/customizejar/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/customizejar/index');
    }
    public function delete($id = NULL) {
        if(hasPermission('customizable_delete') != true){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access denied.");
			redirect('Admin/dashboard', 'refresh');
		}
        if(empty($id) || $this->input->method() != 'post'){
            $this->session->set_flashdata('class', "alert-warning");	 
            $this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
            return redirect('Admin/customizejar/index');
        }
        $dataarr = $this->CustomizeModel->GetJarById($id,"vidiem_jar","jar_id");
        
		//print_r($dataarr);
		//die();
		
        if(!isset($dataarr->jar_id)){
			
			
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Can not delete this category it is linked with registration product.");
            return $this->load->view('Backend/customizejar/index');
        }
		
		 
            $update_status = [
                "isactive"     => "2",
				"userid" 	=> $this->session->userdata("user_id"),	
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
       
            $result = $this->FunctionModel->Update($update_status,'vidiem_jar',array('jar_id' => $id));
          
		
      //  $result = $this->FunctionModel->Delete('vidiem_registration_categories',array('id'=>$id));
        if ($result) {
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Successfully Deleted.");
            return $this->load->view('Backend/customizejar/index');
        }else {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            return $this->load->view('Backend/customizejar/index');
        }
        return $this->load->view('Backend/customizejar/index');
    }

    public function display_datatble_list(){
		
		$searchbycloums=["p.name"];
		
        $length=$this->input->post('length');
        $draw=$this->input->post('draw');
        $start = $this->input->post('start');
        $rowperpage = $this->input->post('length'); 
        $columnIndex = $this->input->post('order')[0]['column'];
        $columnName = $this->input->post('columns')[$columnIndex]['data']; 
        $columnSortOrder = $this->input->post('order')[0]['dir']; 
        $searchValue = $this->input->post('search')['value']; 
        if($columnIndex==0){
            $order=array(
                'field'=>'sortby',
                'type'=> 'desc'
            );
        }else{
            $order=array(
                'field'=>$columnName,
                'type'=> $columnSortOrder
            );
        }
        $where=[];
		$where=array("p.isactive != "=>"2");
        $custom='';
        $searchQuery = [];
        if($searchValue != ''){
            $columns = $searchbycloums;
        foreach($columns as $column){
                $searchQuery[$column ] = $searchValue;
            }
            $searchQuery['p.name'] = $searchValue;
        }
		
		//print_r($searchQuery);
		//die();
		
        $DataResult=$this->CustomizeModel->customizejarList('list',$where,$custom,$searchQuery,$order);
        $count=$this->CustomizeModel->customizejarList('count',$where,$custom,$searchQuery);
        $data = array();
        if($order['type']=='desc' && $order['field']=='id'){
            $no=$start+1;
        }else if($order['type']=='asc' && $order['field']=='id' ){
            $no=$count;
        }else{
            $no=$start+1;  
        }
        
		//echo "bbb"; die();
       
       if($DataResult){
        foreach($DataResult as $row){
            $options='';
            $status =  $row['isactive'] == 0 ? "inactive" : "active" ;
            $status_color =  $row['isactive'] == 0 ? "label-danger" : "label-success" ;
        $data[]=array(
           'no'                  => '',
           'id'                  => $no,
		   'basepath'           => "<img src='".base_url()."uploads/customizeimg/jar/".$row['basepath']."?t=".time()."' width='50' height='50' />",
		   'code'           => $row['code'],		   
           'name'           => $row['name'],		   
		   'price'           => $row['price'],		     
		   'sortby'           => $row['sortby'],		     
           'status'              => '<div calss="row" ><a href="#" data-message="Are you want to update status" data-href="' . base_url('Admin/customizejar/status/'.$row['jar_id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-"><span class="label '.$status_color.' status-span">'.$status.'</span></a>',
           'action'              => '<div calss="row"> <a href="'.base_url('Admin/customizejar/edit/'.$row['jar_id']).'" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                                   <a href="#" data-message="Are you sure want to delete ? " data-href="' . base_url('Admin/customizejar/delete/'.$row['jar_id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></div>'
        );
        if($order['type']=='desc' && $order['field']=='id' ){
            $no++;
        }else if($order['type']=='asc' && $order['field']=='id' ){
            $no--;
        }else{
            $no++;  
        }
         }
        }
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $count,
            "iTotalDisplayRecords" => $count,
            "aaData" => $data
         );
         echo json_encode($response); exit;
    }
	
	
	function image_upload(){
		//print_r($_FILES); die();
		 if($_FILES['basepath']['size'] != 0){
			$upload_dir = './uploads/customizeimg/jar/';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}

			if(file_exists($upload_dir.'/'.$_FILES['basepath']['name'])){
				list($file_name)=explode('.',$_FILES['basepath']['name']);
				$file_name=$file_name.'_'.time();
			}else{
			//	list($file_name)=explode('.',$_FILES['basepath']['name']);
			$file_name="customizejar".time();
			}
			//print_r($_FILES['basepath']['']);
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg|gif';
			$config['file_name']     = $file_name;
			$config['overwrite']     = false;
			$config['max_size']	     = '5120';
			//echo "jjj"; die();
			//print_r($config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('basepath')){
				
				$this->form_validation->set_message('image_upload', $this->upload->display_errors('<p class=error>','</p>'));
				return false;
			}
			else{
				$this->upload_data['file'] =  $this->upload->data();
				return true;
			}
		}
		else{
			$this->form_validation->set_message('image_upload', "No file selected");
			return false;
		}
   }
   
   function edit_image_upload($value, $id) {
	    
		
	   if($_FILES['basepath']['size'] != 0){
	      //print_r($_FILES['image']['name']);exit;
			$upload_dir = './uploads/customizeimg/jar/';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}
	
			if(file_exists($upload_dir.'/'.$_FILES['basepath']['name'])){
				list($file_name)=explode('.',$_FILES['basepath']['name']);
				$file_name=$file_name.'_'.time();
			}else{
				list($file_name)=explode('.',$_FILES['basepath']['name']);
			}
			
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg|gif';
			$config['file_name']     = $file_name;
			$config['overwrite']     = TRUE;
			$config['max_size']	     = '2048000';
			 $config['max_width']  = '5024';
            $config['max_height']  = '5024';

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('basepath')){
			$this->form_validation->set_message('edit_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
			
			$this->upload_data['file'] =  $this->upload->data();
			return true;
		}
	}
	else{
		
		$file_name=$this->FunctionModel->Select_Field('basepath','vidiem_jar',array('jar_id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }
}