<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_log extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','file','download']);
        $this->load->model('M_audit_log');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Allowed: Admin (1) & Manajer (3)
        if (!in_array((int)$this->session->userdata('role_id'), [1,3])) {
            show_error("Akses ditolak", 403);
        }
    }

    public function index()
    {
        $data['title'] = "Riwayat Aktivitas (Audit Log)";

        // Filter GET
        $start  = $this->input->get('start_date', true);
        $end    = $this->input->get('end_date', true);
        $user   = $this->input->get('user_id', true);
        $action = $this->input->get('action', true);
        $q      = $this->input->get('q', true);

        $data['logs']  = $this->M_audit_log->get_logs($start, $end, $user, $action, $q);
        $data['users'] = $this->M_audit_log->get_users();

        // CHART DATA (last 14 days)
        $chartData = $this->M_audit_log->get_summary_days(14);

        $data['chart_labels'] = json_encode(array_column($chartData, 'date'));
        $data['chart_login']  = json_encode(array_column($chartData, 'login'));
        $data['chart_logout'] = json_encode(array_column($chartData, 'logout'));
        $data['chart_create'] = json_encode(array_column($chartData, 'create_count'));
        $data['chart_update'] = json_encode(array_column($chartData, 'update_count'));
        $data['chart_delete'] = json_encode(array_column($chartData, 'delete_count'));
        $data['chart_error']  = json_encode(array_column($chartData, 'error_count'));

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('audit_log/index', $data);
        $this->load->view('template/footer');
    }

    // Export Excel CSV
    public function export_csv()
    {
        $start  = $this->input->get('start_date', true);
        $end    = $this->input->get('end_date', true);
        $user   = $this->input->get('user_id', true);
        $action = $this->input->get('action', true);
        $q      = $this->input->get('q', true);

        $logs = $this->M_audit_log->get_logs($start, $end, $user, $action, $q);

        header("Content-type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=audit_log_" . date('Ymd_His') . ".csv");

        echo "\xEF\xBB\xBF"; // UTF-8 BOM

        $output = fopen("php://output", "w");
        fputcsv($output, ["No","Tanggal","User","Username","Aksi","Detail"]);

        $no = 1;
        foreach ($logs as $log) {
            fputcsv($output, [
                $no++,
                $log->created_at,
                $log->fullname,
                $log->username,
                $log->action,
                $log->detail
            ]);
        }
        fclose($output);
        exit;
    }

    // Delete all logs
    public function truncate()
    {
        if ($this->session->userdata('role_id') != 1) {
            show_error("Only admin allowed", 403);
        }

        if ($this->input->method() !== 'post') {
            show_error("Invalid request", 405);
        }

        $this->M_audit_log->truncate();
        $this->session->set_flashdata('success', 'Semua data log berhasil dihapus.');
        redirect('audit_log');
    }
}
