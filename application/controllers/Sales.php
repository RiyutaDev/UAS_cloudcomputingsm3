<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('M_sales');

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // Tampilkan semua data sales
    public function index() {
        $data['title'] = 'Data Sales';
        $data['sales'] = $this->M_sales->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('sales/index', $data);
        $this->load->view('template/footer');
    }

    // Form tambah sales
    public function create() {
        // Generate kode otomatis (SALE001, SALE002, dst)
        $query = $this->db->query("SELECT MAX(RIGHT(sales_code, 3)) AS max_code FROM sales");
        $result = $query->row();

        if ($result && $result->max_code) {
            $num = (int) $result->max_code + 1;
            $sales_code = 'SALE' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $sales_code = 'SALE001';
        }

        $data['title'] = 'Tambah Sales';
        $data['sales_code'] = $sales_code;

        if ($this->input->post()) {
            $data_insert = [
                'sales_code' => $sales_code,
                'name'       => $this->input->post('name', true),
                'phone'      => $this->input->post('phone', true),
                'email'      => $this->input->post('email', true),
                'note'       => $this->input->post('note', true),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->M_sales->insert($data_insert);

            $this->db->insert('audit_log', [
                'user_id' => $this->session->userdata('user_id'),
                'action'  => 'create',
                'detail'  => 'Menambahkan sales: ' . $data['name'],
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $this->session->set_flashdata('success', 'Data sales berhasil ditambahkan!');
            redirect('sales');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('sales/add', $data);
        $this->load->view('template/footer');
    }

    // Edit sales
    public function edit($id) {
        $data['title'] = 'Edit Sales';
        $data['sales'] = $this->M_sales->get_by_id($id);

        if ($this->input->post()) {
            $data_update = [
                'name'  => $this->input->post('name', true),
                'phone' => $this->input->post('phone', true),
                'email' => $this->input->post('email', true),
                'note'  => $this->input->post('note', true)
            ];

            $this->M_sales->update($id, $data_update);

            $this->db->insert('audit_log', [
                'user_id' => $this->session->userdata('user_id'),
                'action'  => 'update',
                'detail'  => 'Update data sales ID ' . $id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $this->session->set_flashdata('success', 'Data sales berhasil diperbarui!');
            redirect('sales');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('sales/edit', $data);
        $this->load->view('template/footer');
    }

    // Hapus sales
    public function delete($id) {
        $this->M_sales->delete($id);

        $this->db->insert('audit_log', [
            'user_id' => $this->session->userdata('user_id'),
            'action'  => 'delete',
            'detail'  => 'Menghapus sales ID ' . $id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->session->set_flashdata('success', 'Data sales berhasil dihapus!');
        redirect('sales');
    }
}
