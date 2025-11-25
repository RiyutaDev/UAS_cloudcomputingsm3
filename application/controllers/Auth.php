<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Memuat library dan helper yang dibutuhkan
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
        // Memuat Model User
        $this->load->model('M_user');
    }

    // Tampilkan halaman login
    public function index() {
        // Jika sudah login, alihkan ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data['title'] = 'Login - Sales Order';
        $this->load->view('template/header', $data);
        $this->load->view('auth/login', $data);
        $this->load->view('template/footer');
    }

    // Proses login
    public function process() {

        // --- 1. VALIDASI FORM ---
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
    
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth');
        }
    
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);
    
        // --- 2. AMBIL DATA USER BERDASARKAN USERNAME ---
        $user = $this->M_user->get_by_username($username);
    
        if (!$user) {
            $this->session->set_flashdata('error', 'Username tidak ditemukan.');
            redirect('auth');
        }
    
        // --- 3. VERIFIKASI PASSWORD HASH ---
        if (!password_verify($password, $user->password_hash)) {
            $this->session->set_flashdata('error', 'Password salah.');
            redirect('auth');
        }
    
        // --- 4. DATA PENDUKUNG ---
        // Ambil role
        $role = $this->db->select('name')
                         ->where('id', $user->role_id)
                         ->get('roles')
                         ->row('name');
    
        $now = date('Y-m-d H:i:s');
    
        // Update last login
        $this->db->where('id', $user->id)
                 ->update('users', ['updated_at' => $now]);

        // --- 5. LOGIKA PENENTUAN SALES_ID ---
        $current_sales_id = NULL;

        // Jika Role adalah Sales (ID 2), gunakan user_id sebagai sales_id untuk order
        if ($user->role_id == 2) {
            $current_sales_id = $user->id; 
        }
        
        // --- 6. SET SESSION 
        $this->session->set_userdata([
            'logged_in'  => true,
            'user_id'    => $user->id,
            'username'   => $user->username,
            'fullname'   => $user->fullname,
            'role_id'    => $user->role_id,
            'role'       => strtolower($role),
            'sales_id'   => $current_sales_id, // Gunakan ID Sales yang ditentukan
            'last_login' => $now
        ]);
    
        // --- 7. LOG AUDIT  ---
        $this->db->insert('audit_log', [
            'user_id'   => $user->id,
            'action'    => 'login',
            'detail'    => 'User ' . $user->fullname . ' berhasil login.',
            'created_at'=> $now
        ]);
    
        // --- 8. REDIRECT BERDASARKAN ROLE ---
        switch ($user->role_id) {
            case 1: redirect('dashboard'); break; // Admin
            case 2: redirect('orders'); break;    // Sales
            case 3: redirect('report'); break;    // Role lain
            default: redirect('dashboard');
        }
    }
    
    // Proses logout
    public function logout() {

        $user_id = $this->session->userdata('user_id');

        if ($user_id) {
            // Log audit sebelum sesi dihancurkan
            $this->db->insert('audit_log', [
                'user_id'   => $user_id,
                'action'    => 'logout',
                'detail'    => 'User logout.',
                'created_at'=> date('Y-m-d H:i:s')
            ]);
        }

        // Hancurkan sesi
        $this->session->sess_destroy();
        redirect('auth');
    }
}