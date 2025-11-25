<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_audit_log extends CI_Model {

    public function get_logs($start = null, $end = null, $user = null, $action = null, $q = null)
    {
        $this->db->select('audit_log.*, users.fullname, users.username');
        $this->db->from('audit_log');
        $this->db->join('users', 'users.id = audit_log.user_id', 'left');

        if ($start)  $this->db->where('DATE(audit_log.created_at) >=', $start);
        if ($end)    $this->db->where('DATE(audit_log.created_at) <=', $end);
        if ($user)   $this->db->where('audit_log.user_id', $user);
        if ($action) $this->db->where('audit_log.action', $action);

        if ($q) {
            $this->db->group_start()
                ->like('users.fullname', $q)
                ->or_like('users.username', $q)
                ->or_like('audit_log.detail', $q)
            ->group_end();
        }

        $this->db->order_by('audit_log.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_users()
    {
        return $this->db->select('id, fullname, username')
                        ->from('users')
                        ->order_by('fullname')
                        ->get()
                        ->result();
    }

    // ▬▬▬▬▬▬▬ CHART SUMMARY (FINAL) ▬▬▬▬▬▬▬
    public function get_summary_days($days = 14)
    {
        $sql = "
            SELECT 
                DATE(created_at) AS date,
                SUM(action='login')      AS login,
                SUM(action='logout')     AS logout,
                SUM(action='create')     AS create_count,
                SUM(action='update')     AS update_count,
                SUM(action='delete')     AS delete_count,
                SUM(action='error')      AS error_count
            FROM audit_log
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
            GROUP BY DATE(created_at)
            ORDER BY DATE(created_at) ASC
        ";

        return $this->db->query($sql, [$days])->result();
    }

    // Hapus semua log
    public function truncate()
    {
        return $this->db->truncate('audit_log');
    }
}
