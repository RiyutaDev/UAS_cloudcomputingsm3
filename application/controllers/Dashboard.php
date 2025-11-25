<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model(['M_product', 'M_user']);
        $this->load->database();

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // Tampilkan halaman dashboard
    public function index() {
        // Ambil nama user dari session
        $data['user'] = [
            'nama' => $this->session->userdata('fullname'),
            'role' => $this->session->userdata('role')
        ];

        // Ambil jumlah data produk
        if (method_exists($this->M_product, 'count_all')) {
            $data['jumlah_barang'] = $this->M_product->count_all();
        } else {
            $data['jumlah_barang'] = $this->db->count_all('products');
        }

        // Ambil jumlah data user
        if (method_exists($this->M_user, 'count_all')) {
            $data['jumlah_user'] = $this->M_user->count_all();
        } else {
            $data['jumlah_user'] = $this->db->count_all('users');
        }

        // Judul halaman
        $data['title'] = 'Dashboard';

        // Load view
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer', $data);
    }
}
