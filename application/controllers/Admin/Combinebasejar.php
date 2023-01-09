<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class combinebasejar extends CI_Controller {
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


    public function index($id){
		
	   $data['basedataitems'] = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel","base_id");
	 
	     if(empty($data['basedataitems'])) {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Data not found.");
            return redirect('Admin/Customizebase/index');
        }
        $this->load->view('Backend/combinebasejar/index',$data);
    }

  

    public function edit($id) 
    {
	
		 $data['action'] =  "Edit";
        $data['basedataitems'] = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel_color","bm_color_id");
	
	
					  
		$data['dataitems'] = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel_jar","base_id");
	//print_r($data['dataitems']); die();	
		
        if(empty($data['basedataitems'])) {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Data not found.");
            return redirect('Backend/customizebase/index');
        }
		 $data['jar'] = $this->FunctionModel->Select_Fields('name as name ,jar_id as id',' vidiem_jar ',array('isactive'=>1));
		 
		 //print_r($this->db->last_query());
		 
		 
		//print_r( $data['motor']); die();
        return $this->load->view('Backend/combinebasejar/form',$data);
    }

    public function update($id,$bid)
    {
		//echo "jjJ";
		//print_r($this->input->post()); 
		$GLOBALS['combinebase_ind']=0;
        if($this->input->method() == 'post') {	
		
            $this->form_validation->set_rules('default_jar_id[]', 'Choose default Jars', 'trim|required');
		  //	$this->form_validation->set_rules('price[]','Price','required');
			//$this->form_validation->set_rules('basepath[]','Image','callback_edit_image_upload['.$id.']');
            if ($this->form_validation->run() == FALSE) { 
			
			$error_data=validation_errors_with_index(); 
			//print_r($error_data); 
			//die();
		
			$dataarr=[];
			foreach($this->input->post() as $field=>$post)
			{
				
			    $i=0;
				foreach($post as $val)
				{
				$dataarr[$i][$field]=	$val;
				$i++;
				}
			}
			
                $data['basedataitems'] = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel_color","bm_color_id");
				 $data['jar'] = $this->FunctionModel->Select_Fields('name as name ,jar_id as id',' vidiem_jar ',array('isactive'=>1));
				
				$data['dataitems'] = $dataarr;
				
				$data['action']="Edit";
				$data_action=json_encode($data);
				$error_arr=array("status"=>0,
								 "action_url"=>	base_url('Backend/combinebasejar/form'),
								 "data_action"=>$data,
								 "error_data"=>$error_data);
				
				
				echo json_encode($error_arr);
				exit();
            }
			
		//	echo "test agaain"; die();
		//print_r($this->input->post()); die();
			 $chkexist = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel_jar","base_id");		
			
			 $updatedatavalue = [
                "base_id"    => ltrim($id),
				"default_jar_ids"    => implode(",",$this->input->post('default_jar_id')),
				"exclude_jar_id"    => implode(",",$this->input->post('exculde_jar_id')),
				//"price"    => ltrim($this->input->post('price')[$ind]),			
				//"sortby"=>ltrim($this->input->post('sortby')[$ind]),
				"userid" 	=> $this->session->userdata("user_id"),	
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
				
				if(isset($chkexist->bm_jar_id) && $chkexist->bm_jar_id!="")	{
			
					$result = $this->FunctionModel->Update($updatedatavalue,'vidiem_basemodel_jar',array('bm_jar_id' =>  $chkexist->bm_jar_id));	
				}else{
					
				  $result = $this->FunctionModel->Insert($updatedatavalue,'vidiem_basemodel_jar',array('bm_jar_id' => $chkexist->bm_jar_id));		
				}
									
		//echo "hhH"; 
		//		print_r($updatedatavalue);    die();
			
          
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Update Successfully.");
            }
			
			$error_arr=array("status"=>1,
								 "action_url"=>	base_url('Admin/Combinebasejar/index/'.$bid),
								 "data_action"=>"",
								 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
			
           // return redirect('Admin/combinebasejar/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
		$error_arr=array("status"=>1,
						 "action_url"=>	base_url('Admin/Combinebasejar/index/'.$bid),
						 "data_action"=>"",
						 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
       // return redirect('Admin/combinebasejar/index');
    }

    public function delete($id = NULL) {

        if(empty($id) || $this->input->method() != 'post'){
            $this->session->set_flashdata('class', "alert-warning");	 
            $this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
           // return redirect('Admin/combinebasejar/index');
		   $error_arr=array("status"=>1,
								 "action_url"=>	base_url('Admin/combinebasejar/index'),
								 "data_action"=>"",
								 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
		   
        }
        $dataarr = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel_jar","bm_jar_id");
        
		
		
        if(!isset($dataarr->bm_jar_id)){
			
			
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Can not delete this category it is linked with registration product.");
            return $this->load->view('Backend/combinebasejar/index');
        }
		
		 
            $update_status = [
                "isactive"     => "2",
				"userid" 	=> $this->session->userdata("user_id"),	
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
       
            $result = $this->FunctionModel->Update($update_status,'vidiem_basemodel_jar',array('bm_jar_id' => $id));
          
		
      //  $result = $this->FunctionModel->Delete('vidiem_registration_categories',array('id'=>$id));
        if ($result) {
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Successfully Deleted.");
           // return $this->load->view('Backend/combinebasejar/index');
		   $error_arr=array("status"=>1,
								 "action_url"=>  base_url('Admin/combinebasejar/edit/'.$_POST['bid']),
								 "data_action"=>"",
								 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
		   
        }else {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            //return $this->load->view('Backend/combinebasejar/index');
			$error_arr=array("status"=>1,
								 "action_url"=>	base_url('Admin/combinebasejar/index'),
								 "data_action"=>"",
								 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
        }
		$error_arr=array("status"=>1,
								 "action_url"=>	base_url('Admin/combinebasejar/index'),
								 "data_action"=>"",
								 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
		
        //return $this->load->view('Backend/combinebasejar/index');
    }


public function display_datatble_list($id){
		
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
		$where=array("p.isactive = "=>"1","p.base_id = "=>$id);
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
		
        $DataResult=$this->CustomizeModel->combinebasecolorList('list',$where,$custom,$searchQuery,$order);
        $count=$this->CustomizeModel->combinebasecolorList('count',$where,$custom,$searchQuery);
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
           'id'                  => $no,
		   'basepath'           => "<img src='".base_url()."uploads/customizeimg/".$row['basepath']."' width='50' height='50' />",		   
           'basetitle'           => $row['title'],
		   'option'              => '<a href="' . base_url('Admin/combinebasejar/edit/'.$row['bm_color_id']) . '" class="btn btn-primary"><img src="'.base_url('assets/back-end/img/jar.png').'" /> Add Jars</a>'
           
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
		//print_r($data); die();
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $count,
            "iTotalDisplayRecords" => $count,
            "aaData" => $data
         );
         echo json_encode($response); exit;
    }
	

   
   function edit_image_upload($value, $id) {
	
	for($j=0;$j<count($_POST['jar_id']);$j++){	
	
	 
	   if($_FILES['basepath']['size'][$j] != 0){
	      //print_r($_FILES['image']['name']);exit;
			$upload_dir = './uploads/customizeimg/basemotor';
			if (!is_dir($upload_dir)) {
			     mkdir($upload_dir);
			}
	
			
	
			if(file_exists($upload_dir.'/'.$_FILES['basepath']['name'][$j])){
				list($file_name)=explode('.',$_FILES['basepath']['name'][$j]);
				$file_name=$file_name.'_'.time();
			}else{
				list($file_name)=explode('.',$_FILES['basepath']['name'][$j]);
			}
			
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'jpg|png|jpeg|gif';
			$config['file_name']     = $file_name;
			$config['overwrite']     = TRUE;
			$config['max_size']	     = '2048000';
			 $config['max_width']  = '5024';
            $config['max_height']  = '5024';
			
			$newfile=array("name"=>$_FILES['basepath']['name'][$j],
							"type"=>$_FILES['basepath']['type'][$j],
							"tmp_name"=>$_FILES['basepath']['tmp_name'][$j],
							"error"=>$_FILES['basepath']['error'][$j],
							"size"=>$_FILES['basepath']['size'][$j]);
		//print_r($newfile); die();	
		$this->upload->initialize($config);
		if (!$this->upload->do_upload_multiple($newfile)){
			$this->form_validation->set_message('edit_image_upload', $this->upload->display_errors('<p class=error>','</p>'));
			return false;
		}
		else{
		
			$this->upload_data['file'][$j] =  $this->upload->data();
			
		}
	}	
	else{
		
	
		$file_name=$this->FunctionModel->Select_Field('basepath','vidiem_basemodel_jar',array('bm_jar_id'=>$this->input->post('bm_jar_id')[$j]));
		
		if($file_name!="")
	    	$this->upload_data['file'][$j]['file_name']=$file_name;
		else
			return false;
	}
	}
	return true;
   }
	
	
	
}