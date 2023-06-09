<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class customizebase extends CI_Controller {
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
        $this->load->view('Backend/customizebase/index');
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
		   $data['defaultexist'] = $this->FunctionModel->Select_Fields('base_id','vidiem_basemodel',array('isactive !='=>2,'isdefault ='=>1));
        $this->load->view('Backend/customizebase/form',$data);
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
            $this->form_validation->set_rules('basetitle', 'Base name', 'trim|required|edit_unique_customize[vidiem_basemodel.basetitle.category_id.base_id.'.$id.']');
			$this->form_validation->set_rules('price','Price','required');	
			$this->form_validation->set_rules('code','code','required');	
			  $data['defaultexist'] = $this->FunctionModel->Select_Fields('base_id','vidiem_basemodel',array('isactive !='=>2,'isdefault ='=>1));
			$this->form_validation->set_rules('basepath','Image','callback_image_upload');
            if ($this->form_validation->run() == FALSE) { 
				  $data['action']="Create";
				  $data['dataitems']['basetitle'] =  ltrim($this->input->post('basetitle'));	
                return $this->load->view('Backend/customizebase/form',$data); 
            }
			
			//print_r($this->upload_data['file']);
			//die();
			
			 $createdatavalue = [
                "basetitle"    => ltrim($this->input->post('basetitle')),
				"description"    => ltrim($this->input->post('description')),
				"basepath"    => $this->upload_data['file']['file_name'],
				"code"    => ltrim($this->input->post('code')),
				"price"    => ltrim($this->input->post('price')),
				"sortby"=>ltrim($this->input->post('sortby')),
				"isdefault"=>ltrim($this->input->post('isdefault')),
				"userid" 	=> $this->session->userdata("user_id"),
				"createddate"        => Date('Y-m-d H:i:s'),	
                "modifieddate"        =>Date('Y-m-d H:i:s'),	
            ];
            $result = $this->FunctionModel->Insert($createdatavalue,'vidiem_basemodel',array('base_id' => $id));
			
           
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Added Successfully.");
            } else {
                $this->session->set_flashdata('class', "alert-danger");
                $this->session->set_flashdata('icon', "fa-warning");
                $this->session->set_flashdata('msg', "Something Went Wrong.");
            }
            return redirect('Admin/customizebase/index');
            }
        
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/customizebase/index');
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
        $data['dataitems'] = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel","base_id");
        if(empty($data['dataitems'])) {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Data not found.");
            return redirect('Admin/customizebase/index');
        }
		  $data['defaultexist'] = $this->FunctionModel->Select_Fields('base_id','vidiem_basemodel',array('isactive !='=>2,'isdefault ='=>1));
		 $data['categories'] = $this->FunctionModel->Select_Fields('name,id','vidiem_category',array('status'=>1,"parent_id"=>"0"));
		
        return $this->load->view('Backend/customizebase/form',$data);
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
		
		
            $this->form_validation->set_rules('basetitle', 'Motor name', 'trim|required|edit_unique_customize[vidiem_basemodel.basetitle.category_id.base_id.'.$id.']');
		  	$this->form_validation->set_rules('price','Price','required');		
		  	$this->form_validation->set_rules('code','Code','required');		
			$this->form_validation->set_rules('basepath','Image','callback_edit_image_upload['.$id.']');
            if ($this->form_validation->run() == FALSE) { 
                $data['dataitems'] = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel","base_id");
				$data['action']="Edit";
				  $data['defaultexist'] = $this->FunctionModel->Select_Fields('base_id','vidiem_basemodel',array('isactive !='=>2,'isdefault ='=>1));
                return $this->load->view('Backend/customizebase/form',$data); 
            }
            $updatedatavalue = [
                "basetitle"    => ltrim($this->input->post('basetitle')),
				"description"    => ltrim($this->input->post('description')),
				"basepath"    => $this->upload_data['file']['file_name'],
				"price"    => ltrim($this->input->post('price')),
				"code"    => ltrim($this->input->post('code')),
				"isdefault"=>ltrim($this->input->post('isdefault')),
				"sortby"=>ltrim($this->input->post('sortby')),
				"userid" 	=> $this->session->userdata("user_id"),	
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
			
			
            $result = $this->FunctionModel->Update($updatedatavalue,'vidiem_basemodel',array('base_id' => $id));
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Update Successfully.");
            }
            return redirect('Admin/customizebase/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/customizebase/index');
    }

    public function status($id) 
    {
        if($this->input->method() == 'post') {
            $dataarr = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel","base_id");
            $update_status = [
                "isactive"     => !(int)$dataarr->isactive,
				"userid" 	=> $this->session->userdata("user_id"),	
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
       
            $result = $this->FunctionModel->Update($update_status,'vidiem_basemodel',array('base_id' => $id));
			
			// print_r($this->db->last_query());  
		  // die();
			
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Status Update Successfully.");
            }
            return redirect('Admin/customizebase/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
        return redirect('Admin/customizebase/index');
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
            return redirect('Admin/customizebase/index');
        }
        $dataarr = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel","base_id");
        
		//print_r($dataarr);
		//die();
		
        if(!isset($dataarr->base_id)){
			
			
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Can not delete this category it is linked with registration product.");
            return $this->load->view('Backend/customizebase/index');
        }
		
		 
            $update_status = [
                "isactive"     => "2",
				"userid" 	=> $this->session->userdata("user_id"),	
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
       
            $result = $this->FunctionModel->Update($update_status,'vidiem_basemodel',array('base_id' => $id));
          
		
      //  $result = $this->FunctionModel->Delete('vidiem_registration_categories',array('id'=>$id));
        if ($result) {
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Successfully Deleted.");
            return $this->load->view('Backend/customizebase/index');
        }else {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            return $this->load->view('Backend/customizebase/index');
        }
        return $this->load->view('Backend/customizebase/index');
    }

    public function display_datatble_list(){
		
		$searchbycloums=["basetitle"];
		
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
                'field'=>'createddate',
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
            $searchQuery['basetitle'] = $searchValue;
        }
		
		//print_r($searchQuery);
		//die();
		
        $DataResult=$this->CustomizeModel->customizebaseList('list',$where,$custom,$searchQuery,$order);
        $count=$this->CustomizeModel->customizebaseList('count',$where,$custom,$searchQuery);
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
		   'basepath'           => "<img src='".base_url()."uploads/customizeimg/".$row['basepath']."' width='50' height='50' />",			   
           'basetitle'           => $row['basetitle'],		   
		   'price'           => $row['price'],	
		   'option'              => '<a href="' . base_url('Admin/combinebasecolor/edit/'.$row['base_id']) . '" class="btn btn-primary"><img src="'.base_url('assets/back-end/img/color.png').'" /></a><a href="' . base_url('Admin/combinebasemotor/edit/'.$row['base_id']) . '" class="btn btn-primary"><img src="'.base_url('assets/back-end/img/motor.png').'" /></a><a href="' . base_url('Admin/combinebasejar/index/'.$row['base_id']) . '" class="btn btn-primary"><img src="'.base_url('assets/back-end/img/jar.png').'" /></a><a href="' . base_url('Admin/combinebasetext/edit/'.$row['base_id']) . '" class="btn btn-primary"><img src="'.base_url('assets/back-end/img/text.png').'" /></a>',
           'status'              => '<div calss="row" ><a href="#" data-message="Are you want to update status" data-href="' . base_url('Admin/customizebase/status/'.$row['base_id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-"><span class="label '.$status_color.' status-span">'.$status.'</span></a>',
           'action'              => '<div calss="row"> <a href="'.base_url('Admin/customizebase/edit/'.$row['base_id']).'" class="btn btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                                   <a href="#" data-message="Are you sure want to delete ? " data-href="' . base_url('Admin/customizebase/delete/'.$row['base_id']) . '" id="tooltip" data-method="POST" data-title="POST"  data-toggle="modal" data-target="#-status-" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></div>'
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
		
		 if($_FILES['basepath']['size'] != 0){
			$upload_dir = './uploads/customizeimg';
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
			$config['overwrite']     = false;
			$config['max_size']	     = '5120';
			//echo "jjj"; die();
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
			$upload_dir = './uploads/customizeimg';
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
		
		$file_name=$this->FunctionModel->Select_Field('basepath','vidiem_basemodel',array('base_id'=>$id));
		$this->upload_data['file']['file_name']=$file_name;
		return true;
	}
   }
	
	
	
}