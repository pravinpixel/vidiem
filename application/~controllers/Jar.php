<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jar extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function getJarViewModal()
    {
        $id = $this->input->post('id', true );
        $jarInfo = $this->CustomizeModel->GetJarById($id);
        echo $this->load->view('jar/view', array( 'info' => $jarInfo), true);
    }
}