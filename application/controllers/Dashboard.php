<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['name'] = $this->session->userdata('name');
        $data['email'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');

        $this->load->view('dashboard', $data);
    }
}
