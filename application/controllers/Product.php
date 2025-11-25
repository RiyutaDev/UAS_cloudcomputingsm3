<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('M_product');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // List Produk
    public function index() {
        $data['title'] = 'Daftar Produk';
        $data['products'] = $this->M_product->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('product/index', $data);
        $this->load->view('template/footer');
    }

    // Form tambah produk
    public function create() {

        // Generate kode otomatis
        $latest = $this->db->select('product_code')
                           ->order_by('id', 'DESC')
                           ->limit(1)
                           ->get('products')
                           ->row();

        if ($latest) {
            $num = (int) substr($latest->product_code, 3) + 1;
            $product_code = 'PRD' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $product_code = 'PRD001';
        }

        $data['title'] = 'Tambah Produk';
        $data['product_code'] = $product_code;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('product/add', $data);
        $this->load->view('template/footer');
    }

    // Simpan produk baru
    public function save() {

        $data = [
            'product_code' => $this->input->post('product_code', true),
            'name'         => $this->input->post('name', true),
            'price'        => $this->input->post('price', true),
            'stock'        => $this->input->post('stock', true),
            'description'  => $this->input->post('description', true),
            'created_at'   => date('Y-m-d H:i:s')
        ];

        $this->M_product->insert($data);

        // Log aktivitas
        $this->db->insert('audit_log', [
            'user_id' => $this->session->userdata('user_id'),
            'action'  => 'create',
            'detail'  => 'Menambahkan produk baru: ' . $data['name'],
            'created_at' => date('Y-m-d H:i:s')
        ]);


        $this->session->set_flashdata('success', 'Produk berhasil ditambahkan!');
        redirect('product');
    }

    //form edit produk
    public function edit($id) {
        $data['title'] = 'Edit Produk';
        $data['product'] = $this->M_product->get_by_id($id);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('product/add', $data);
        $this->load->view('template/footer');
    }

    // Update produk
    public function update($id) {
        $data = [
            'name'        => $this->input->post('name', true),
            'price'       => $this->input->post('price', true),
            'stock'       => $this->input->post('stock', true),
            'description' => $this->input->post('description', true),
        ];

        $this->M_product->update($id, $data);

        // Log aktivitas
        $this->db->insert('audit_log', [
            'user_id' => $this->session->userdata('user_id'),
            'action'  => 'update',
            'detail'  => 'Mengubah produk ID ' . $id . ' menjadi: ' . $data['name'],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Produk berhasil diperbarui!');
        redirect('product');
    }

    // Hapus produk
    public function delete($id) {
        $this->M_product->delete($id);
        // Log aktivitas
        $this->db->insert('audit_log', [
            'user_id' => $this->session->userdata('user_id'),
            'action'  => 'delete',
            'detail'  => 'Menghapus produk ID: ' . $id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $this->session->set_flashdata('success', 'Produk berhasil dihapus!');
        redirect('product');
    }
}
