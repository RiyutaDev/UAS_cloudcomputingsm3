<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Hanya Manager (3) dan Admin (1)
        if (!in_array($this->session->userdata('role_id'), [1,3])) {
            show_error("Anda tidak memiliki akses ke laporan!", 403);
        }

        $this->load->model(['M_report', 'M_order', 'M_customer', 'M_sales']);
        $this->load->helper('url');
    }

    public function index() {

        // --- Ambil filter jika ada ---
        $filter = [
            'from'      => $this->input->get('from'),
            'to'        => $this->input->get('to'),
            'sales_id'  => $this->input->get('sales_id'),
            'status'    => $this->input->get('status'),
        ];

        // Ambil data laporan
        $data['orders'] = $this->M_report->get_filtered_report($filter);

        // Ambil semua sales untuk dropdown filter
        $data['sales'] = $this->M_sales->get_all();

        // ===== GRAFIK =====
        $statusData = $this->M_report->get_chart_data($filter);

        $data['status_labels'] = array_column($statusData, 'status');
        $data['status_totals'] = array_column($statusData, 'total_order');

        // Title
        $data['title'] = 'Laporan Penjualan';

        // Load view
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('report/index', $data);
        $this->load->view('template/footer');
    }
}
