<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qrdealer extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('DealersModel');
    }

    public function index()
    {

        if (empty($this->session->userdata('dealer_session'))) {
            redirect('vidiem-dealer/login');
        }
        if ($this->session->userdata('dealer_session')['user']['user_type'] != 'sale_person' && !empty($this->session->userdata('dealer_session')['user']['user_type'])) {
            redirect('dealer-admin');
        }

        $data       = array(
            'title' => 'Vidiem Dealer ',
            'menu_id' => 0
        );
        $this->load->view('dealer/dashboard/index', $data);
    }

    public function login()
    {

        if (!empty($this->session->userdata('dealer_session')) && $this->session->userdata('dealer_session')['user_type'] == 'sale_person') {
            redirect('vidiem-dealer');
        }
        
        $check          = $this->DealersModel->checkQrDealersLogin();
        
        if ($check) {
            redirect('vidiem-dealer');
        }
       
    }
}
