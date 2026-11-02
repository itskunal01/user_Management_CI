<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('User_model');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $search = $this->input->get('search', true);
        $role = $this->input->get('role', true);
        $status = $this->input->get('status', true);

        if (!in_array($role, ['', 'ADMIN', 'OPERATOR'], true)) {
            $role = '';
        }

        if (!in_array($status, ['', 'ACTIVE', 'INACTIVE'], true)) {
            $status = '';
        }

        $limit = 5;
        $offset = (int) $this->input->get('page');

        if ($offset < 0) {
            $offset = 0;
        }

        $total_rows = $this->User_model->count_filtered_users(
            $search,
            $role,
            $status
        );

        $config['base_url'] = site_url('users/index');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;
        $config['num_links'] = 2;

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['users'] = $this->User_model->get_all_users(
            $search,
            $role,
            $status,
            $limit,
            $offset
        );

        $data['search'] = $search;
        $data['role'] = $role;
        $data['status'] = $status;
        $data['pagination_links'] = $this->pagination->create_links();

        $this->load->view('users', $data);
    }

    public function add()
    {
        if ($this->session->userdata('role') !== 'ADMIN') {
            show_error('You are not authorized to add users.', 403);
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules(
                'name',
                'Name',
                'required|trim|max_length[100]'
            );

            $this->form_validation->set_rules(
                'email',
                'Email',
                'required|trim|valid_email|is_unique[users.email]'
            );

            $this->form_validation->set_rules(
                'password',
                'Password',
                'required|min_length[8]'
            );

            $this->form_validation->set_rules(
                'confirm_password',
                'Confirm Password',
                'required|matches[password]'
            );

            $this->form_validation->set_rules(
                'role',
                'Role',
                'required|in_list[ADMIN,OPERATOR]'
            );

            $this->form_validation->set_rules(
                'status',
                'Status',
                'required|in_list[ACTIVE,INACTIVE]'
            );

            if ($this->form_validation->run() == true) {
                $hashed_password = password_hash(
                    $this->input->post('password'),
                    PASSWORD_DEFAULT
                );

                $user_data = [
                    'name' => $this->input->post('name', true),
                    'email' => $this->input->post('email', true),
                    'password' => $hashed_password,
                    'role' => $this->input->post('role', true),
                    'status' => $this->input->post('status', true),
                ];

                if ($this->User_model->insert_user($user_data)) {
                    $this->session->set_flashdata(
                        'success',
                        'User added successfully.'
                    );

                    redirect('users');
                } else {
                    $data['error'] = 'Unable to save user.';
                }
            } else {
                $data['error'] = '';
            }
        } else {
            $data['error'] = '';
        }

        $this->load->view('add_user', isset($data) ? $data : ['error' => '']);
    }

    public function edit($id = null)
    {
        if ($id === null || !is_numeric($id)) {
            show_404();
        }

        $user = $this->User_model->get_by_id($id);

        if (!$user) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules(
                'name',
                'Name',
                'required|trim|max_length[100]'
            );

            $this->form_validation->set_rules(
                'email',
                'Email',
                'required|trim|valid_email|callback_email_check'
            );

            if ($this->session->userdata('role') === 'ADMIN') {
                $this->form_validation->set_rules(
                    'role',
                    'Role',
                    'required|in_list[ADMIN,OPERATOR]'
                );

                $this->form_validation->set_rules(
                    'status',
                    'Status',
                    'required|in_list[ACTIVE,INACTIVE]'
                );
            }

            if ($this->form_validation->run() == true) {
                $update_data = [
                    'name' => $this->input->post('name', true),
                    'email' => $this->input->post('email', true),
                ];

                if ($this->session->userdata('role') === 'ADMIN') {
                    $update_data['role'] = $this->input->post('role', true);
                    $update_data['status'] = $this->input->post('status', true);
                }

                if ($this->User_model->update_user($id, $update_data)) {
                    $this->session->set_flashdata(
                        'success',
                        'User updated successfully.'
                    );

                    redirect('users');
                } else {
                    $data['error'] = 'Unable to update user.';
                }
            } else {
                $data['error'] = '';
            }
        } else {
            $data['error'] = '';
        }

        $data['user'] = $user;

        $this->load->view('edit_user', $data);
    }

    public function email_check($email)
    {
        $id = $this->uri->segment(3);

        $existing_user = $this->User_model->get_by_email($email);

        if ($existing_user && $existing_user->id != $id) {
            $this->form_validation->set_message(
                'email_check',
                'This email address is already registered.'
            );

            return false;
        }

        return true;
    }

    public function deactivate($id = null)
    {
        if ($this->session->userdata('role') !== 'ADMIN') {
            show_error('You are not authorized to deactivate users.', 403);
        }

        if ($id === null || !is_numeric($id)) {
            show_404();
        }

        $user = $this->User_model->get_by_id($id);

        if (!$user) {
            show_404();
        }

        if ($user->id == $this->session->userdata('user_id')) {
            show_error('You cannot deactivate your own account.', 400);
        }

        if ($this->User_model->deactivate_user($id)) {
            $this->session->set_flashdata(
                'success',
                'User deactivated successfully.'
            );
        } else {
            $this->session->set_flashdata(
                'error',
                'Unable to deactivate user.'
            );
        }

        redirect('users');
    }

    public function update_status()
    {
        if ($this->session->userdata('role') !== 'ADMIN') {
            $this->output
                ->set_status_header(403)
                ->set_content_type('application/json')
                ->set_output(
                    json_encode([
                        'success' => false,
                        'message' => 'Unauthorized access.',
                    ])
                );
            return;
        }

        $id = $this->input->post('id');
        $status = $this->input->post('status');

        if (
            !is_numeric($id) ||
            !in_array($status, ['ACTIVE', 'INACTIVE'], true)
        ) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(
                    json_encode([
                        'success' => false,
                        'message' => 'Invalid user ID or status.',
                    ])
                );
            return;
        }

        $user = $this->User_model->get_by_id($id);

        if (!$user) {
            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(
                    json_encode([
                        'success' => false,
                        'message' => 'User not found.',
                    ])
                );
            return;
        }

        if ($user->id == $this->session->userdata('user_id')) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(
                    json_encode([
                        'success' => false,
                        'message' => 'You cannot change your own status.',
                    ])
                );
            return;
        }

        $this->User_model->update_user($id, ['status' => $status]);

        $this->output->set_content_type('application/json')->set_output(
            json_encode([
                'success' => true,
                'message' => 'User status updated successfully.',
            ])
        );
    }
}
