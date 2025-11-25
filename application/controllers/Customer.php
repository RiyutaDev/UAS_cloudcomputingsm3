<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('M_customer');

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // Tampilkan daftar customer
    public function index() {
        $data['title'] = 'Data Pelanggan';
        $data['customers'] = $this->M_customer->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('customer/index', $data);
        $this->load->view('template/footer');
    }

    // Form tambah customer
    public function create() {
        // Cari kode terbesar berdasarkan angka di customer_code
        $query = $this->db->query("SELECT MAX(RIGHT(customer_code, 3)) AS max_code FROM customers");
        $result = $query->row();

        if ($result && $result->max_code) {
            $num = (int) $result->max_code + 1;
            $customer_code = 'CUST' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $customer_code = 'CUST001';
        }

        $data['title'] = 'Tambah Pelanggan';
        $data['customer_code'] = $customer_code;

        if ($this->input->post()) {
            $data_insert = [
                'customer_code' => $customer_code,
                'name'          => $this->input->post('name', true),
                'address'       => $this->input->post('address', true),
                'phone'         => $this->input->post('phone', true),
                'email'         => $this->input->post('email', true),
                'created_at'    => date('Y-m-d H:i:s')
            ];

            $this->M_customer->insert($data_insert);
            $this->session->set_flashdata('success', 'Pelanggan berhasil ditambahkan!');
            redirect('customer');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('customer/add', $data);
        $this->load->view('template/footer');
    }

    // Form edit customer
    public function edit($id) {
        $data['title'] = 'Edit Pelanggan';
        $data['customer'] = $this->M_customer->get_by_id($id);

        if ($this->input->post()) {
            $data_update = [
                'name'    => $this->input->post('name', true),
                'address' => $this->input->post('address', true),
                'phone'   => $this->input->post('phone', true),
                'email'   => $this->input->post('email', true)
            ];

            $this->M_customer->update($id, $data_update);
            $this->session->set_flashdata('success', 'Data pelanggan berhasil diperbarui!');
            redirect('customer');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('customer/edit', $data);
        $this->load->view('template/footer');
    }

    // Hapus customer
    public function delete($id) {
        $this->M_customer->delete($id);
        $this->session->set_flashdata('success', 'Pelanggan berhasil dihapus!');
        redirect('customer');
    }
}
