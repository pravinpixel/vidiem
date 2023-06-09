<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Combinebasetext extends CI_Controller {
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
		 
        $this->load->view('Backend/customizebase/index');
    }

  

    public function edit($id) 
    {
	
		 $data['action'] =  "Edit";
        $data['basedataitems'] = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel","base_id");
	
	
					  
		$data['dataitems'] = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel_text","base_id");
	//print_r($data['dataitems']); die();	
		
        if(empty($data['basedataitems'])) {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Data not found.");
            return redirect('Backend/customizebase/index');
        }
		
		 
		 
		//print_r( $data['motor']); die();
        return $this->load->view('Backend/combinebasetext/form',$data);
    }

    public function update($id)
    {
		//echo "jjJ";
		//print_r($this->input->post()); 
		$GLOBALS['combinebase_ind']=0;
        if($this->input->method() == 'post') {	
		
            $this->form_validation->set_rules('desktopleft', 'Desktop Left', 'trim|required');
            $this->form_validation->set_rules('desktoptop', 'Desktop Top', 'trim|required');
           
		  	$this->form_validation->set_rules('price','Price','required');
			
            if ($this->form_validation->run() == FALSE) { 
			
			$error_data=validation_errors_with_index(); 
					
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
			
                $data['basedataitems'] = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel","base_id");
				
				
				$data['dataitems'] = $dataarr;
				
				$data['action']="Edit";
				$data_action=json_encode($data);
				$error_arr=array("status"=>0,
								 "action_url"=>	base_url('Backend/combinebasetext/form'),
								 "data_action"=>$data,
								 "error_data"=>$error_data);
				
				
				echo json_encode($error_arr);
				exit();
            }
			
		//	echo "test agaain"; die();
		//print_r($this->input->post()); die();
			 $chkexist = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel_text","base_id");		
			
			 $updatedatavalue = [
                "base_id"    => ltrim($id),
				"desktopleft"    => ltrim($this->input->post('desktopleft')),
				"desktoptop"    => ltrim($this->input->post('desktoptop')),
				"desktop_vertical" => ltrim($this->input->post('desktop_vertical')),
				
				"price"    => ltrim($this->input->post('price')),
				"userid" 	=> $this->session->userdata("user_id"),	
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
				
				if(isset($chkexist->bm_text_id) && $chkexist->bm_text_id!="")	{
			
					$result = $this->FunctionModel->Update($updatedatavalue,'vidiem_basemodel_text',array('bm_text_id' =>  $chkexist->bm_text_id));	
				}else{
					
				  $result = $this->FunctionModel->Insert($updatedatavalue,'vidiem_basemodel_text',array('bm_text_id' => $chkexist->bm_text_id));		
				}
									
		//echo "hhH"; 
		//		print_r($updatedatavalue);    die();
			
          
            if( $result ) {
                $this->session->set_flashdata('class', "alert-success");
                $this->session->set_flashdata('icon', "fa-success");
                $this->session->set_flashdata('msg', "Update Successfully.");
            }
			
			$error_arr=array("status"=>1,
								 "action_url"=>	base_url('Admin/Combinebasetext/index'),
								 "data_action"=>"",
								 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
			
           // return redirect('Admin/Combinebasetext/index');
        }
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Something went wrong.");
		$error_arr=array("status"=>1,
						 "action_url"=>	base_url('Admin/Combinebasetext/index'),
						 "data_action"=>"",
						 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
       // return redirect('Admin/Combinebasetext/index');
    }

    public function delete($id = NULL) {

        if(empty($id) || $this->input->method() != 'post'){
            $this->session->set_flashdata('class', "alert-warning");	 
            $this->session->set_flashdata('error', "<span class='entypo-attention'></span> Something Wrong.");	
           // return redirect('Admin/Combinebasetext/index');
		   $error_arr=array("status"=>1,
								 "action_url"=>	base_url('Admin/Combinebasetext/index'),
								 "data_action"=>"",
								 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
		   
        }
        $dataarr = $this->CustomizeModel->getDataArrById($id,"vidiem_basemodel_text","bm_text_id");
        
		
		
        if(!isset($dataarr->bm_text_id)){
			
			
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Error");
            return $this->load->view('Backend/combinebasetext/index');
        }
		
		 
            $update_status = [
                "isactive"     => "2",
				"userid" 	=> $this->session->userdata("user_id"),	
                "modifieddate"        => Date('Y-m-d H:i:s'),	
            ];
       
            $result = $this->FunctionModel->Update($update_status,'vidiem_basemodel_text',array('bm_text_id' => $id));
          
		
      //  $result = $this->FunctionModel->Delete('vidiem_registration_categories',array('id'=>$id));
        if ($result) {
            $this->session->set_flashdata('class', "alert-success");
            $this->session->set_flashdata('icon', "fa-check");
            $this->session->set_flashdata('msg', "Successfully Deleted.");
           // return $this->load->view('Backend/combinebasetext/index');
		   $error_arr=array("status"=>1,
								 "action_url"=>  base_url('Admin/Combinebasetext/edit/'.$_POST['bid']),
								 "data_action"=>"",
								 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
		   
        }else {
            $this->session->set_flashdata('class', "alert-danger");
            $this->session->set_flashdata('icon', "fa-warning");
            $this->session->set_flashdata('msg', "Something Went Wrong.");
            //return $this->load->view('Backend/combinebasetext/index');
			$error_arr=array("status"=>1,
								 "action_url"=>	base_url('Admin/Combinebasetext/index'),
								 "data_action"=>"",
								 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
        }
		$error_arr=array("status"=>1,
								 "action_url"=>	base_url('Admin/Combinebasetext/index'),
								 "data_action"=>"",
								 "error_data"=>"");
				
				
				echo json_encode($error_arr);
				exit();
		
        //return $this->load->view('Backend/combinebasetext/index');
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
		
	
		$file_name=$this->FunctionModel->Select_Field('basepath','vidiem_basemodel_text',array('bm_text_id'=>$this->input->post('bm_text_id')[$j]));
		
		if($file_name!="")
	    	$this->upload_data['file'][$j]['file_name']=$file_name;
		else
			return false;
	}
	}
	return true;
   }
	
	
	
}