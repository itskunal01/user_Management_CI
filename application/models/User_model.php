<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');

        return $query->row();
    }

    public function get_all_users(
        $search = '',
        $role = '',
        $status = '',
        $limit = null,
        $offset = 0
    ) {
        $this->db->select('id, name, email, role, status, created_at');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }

        if (!empty($role)) {
            $this->db->where('role', $role);
        }

        if (!empty($status)) {
            $this->db->where('status', $status);
        }

        $this->db->order_by('id', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get('users')->result();
    }

    public function count_filtered_users($search = '', $role = '', $status = '')
    {
        $this->db->from('users');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('email', $search);
            $this->db->group_end();
        }

        if (!empty($role)) {
            $this->db->where('role', $role);
        }

        if (!empty($status)) {
            $this->db->where('status', $status);
        }

        return $this->db->count_all_results();
    }

    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function deactivate_user($id)
    {
        $this->db->where('id', $id);

        return $this->db->update('users', [
            'status' => 'INACTIVE',
        ]);
    }
}
