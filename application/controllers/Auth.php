<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data['error'] = '';
        $this->load->view('login', $data);
    }

    public function login()
    {
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email'
        );

        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            $data['error'] = validation_errors();
            $this->load->view('login', $data);
            return;
        }

        $email = $this->input->post('email', true);
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_email($email);

        if (!$user || !password_verify($password, $user->password)) {
            $data['error'] = 'Invalid email or password.';
            $this->load->view('login', $data);
            return;
        }

        if ($user->status !== 'ACTIVE') {
            $data['error'] = 'Your account is inactive.';
            $this->load->view('login', $data);
            return;
        }

        $this->session->sess_regenerate(true);

        $session_data = [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'logged_in' => true,
        ];

        $this->session->set_userdata($session_data);

        redirect('dashboard');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
