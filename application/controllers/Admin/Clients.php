<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends CI_Controller {
	function __construct() {
        parent::__construct();
		$this->load->helper(array('url', 'form'));
        $this->load->library('form_validation', 'session', 'upload');
        $this->load->library('pagination');
        $this->load->model(array('Accessmodel'));
        $this->load->library('slug');
        if(!$this->session->userdata('user_logged_in')){
			$this->session->set_flashdata('class', "alert-danger");
			$this->session->set_flashdata('icon', "fa-warning");
			$this->session->set_flashdata('msg', "Access Denied.");
			redirect('Admin', 'refresh');
		}
  }

	 public function index($start=0) {
      if(hasPermission('client_index') != true){
        $this->session->set_flashdata('class', "alert-danger");
        $this->session->set_flashdata('icon', "fa-warning");
        $this->session->set_flashdata('msg', "Access denied.");
        redirect('Admin/dashboard', 'refresh');
      }
      $config['base_url'] = base_url('Admin/clients/index');
      $data['tmp_url']=$config['base_url'];
      $data['tmp_title']='All Clients';
      $config['per_page'] = 25;
      $search=$this->input->get('search');
      $data['search']=$search;
      $config['total_rows'] = $this->ProjectModel->ClientDataCount(array('status !='=>0),$search);
      $data['DataResult']=$this->ProjectModel->ClientData(array('status !='=>0),$config['per_page'],$start,$search);
      $data['x']=$start;
      $this->pagination->initialize($config);
      $data['pagination']=$this->pagination->create_links();
      $this->load->view('Backend/clients-view',$data);
    }

    public function status($id = NULL,$status = NULL) {
    if(empty($id) || empty($status)){
      $this->session->set_flashdata('class', "alert-danger");
      $this->session->set_flashdata('icon', "fa-warning");
      $this->session->set_flashdata('msg', "Something Went Wrong.");
      redirect('Admin/clients', 'refresh');
    }
    $UpdateData=array(
      'status' =>$status,
      'modified'=>date('Y-m-d H:i:s')
      );
    $result = $this->FunctionModel->Update($UpdateData,'vidiem_clients',array('id'=>$id));
    if ($result == 1) :
          $this->session->set_flashdata('class', "alert-success");
      $this->session->set_flashdata('icon', "fa-check");
      $this->session->set_flashdata('msg', "Status Successfully Updated.");
      redirect($_SERVER['HTTP_REFERER'],'refresh');
        else :
          $this->session->set_flashdata('class', "alert-danger");
      $this->session->set_flashdata('icon', "fa-warning");
      $this->session->set_flashdata('msg', "Something Went Wrong.");
          redirect($_SERVER['HTTP_REFERER'], 'refresh');
        endif;
    }

    public function export($Serach_term=null){
      if($Serach_term==1){$Serach_term='';}
      $DataResult=$this->ProjectModel->ClientData(array('status !='=>0),'','',$Serach_term);
           $data['report'] ='<thead>
                <tr>
                  <th>S.No</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Created</th>
                </tr>
                </thead>
                <tbody>';
               if(!empty($DataResult)){  
                  $x=1;
                  foreach ($DataResult as $info) { 
                 $data['report'] .='<tr>
                    <td>'.$x.'</td>
                    <td>'.$info['name'].'</td>
                    <td>'.$info['mobile_no'].'</td>
                    <td>'.$info['email'].'</td>
                    <td>'.($info['status']==1?'Active':'Inactive').'</td>   
                    <td>'.$info['created'].'</td>
                </tr>';
                 $x++; }
                }else { 
                $data['report'] .='<tr>
                  <td colspan="10">No Data Available...</td>
                </tr>';
                 } 
                 $data['report'].='</tbody>';
        $this->load->view('Backend/excel_export',@$data);   
    }

   
	
}