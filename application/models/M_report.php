<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_report extends CI_Model {

    // =============================
    // FILTER LAPORAN
    // =============================
    public function get_filtered_report($filter) {

        $this->db->select("
            orders.*, 
            customers.name AS customer_name,
            sales.name AS sales_name
        ");

        $this->db->from("orders");
        $this->db->join("customers", "customers.id = orders.customer_id", "left");
        $this->db->join("sales", "sales.id = orders.sales_id", "left");

        // Filter tanggal
        if (!empty($filter['from'])) {
            $this->db->where("DATE(order_date) >=", $filter['from']);
        }
        if (!empty($filter['to'])) {
            $this->db->where("DATE(order_date) <=", $filter['to']);
        }

        // Filter sales
        if (!empty($filter['sales_id'])) {
            $this->db->where("orders.sales_id", $filter['sales_id']);
        }

        // Filter status
        if (!empty($filter['status'])) {
            $this->db->where("orders.status", $filter['status']);
        }

        $this->db->order_by("orders.id", "DESC");

        return $this->db->get()->result();
    }

    // =============================
    // DATA UNTUK GRAFIK
    // =============================
    public function get_chart_data($filter)
    {
        $this->db->select("orders.status, COUNT(*) AS total_order");
        $this->db->from("orders");

        // Filter tanggal
        if (!empty($filter['from'])) {
            $this->db->where("DATE(order_date) >=", $filter['from']);
        }
        if (!empty($filter['to'])) {
            $this->db->where("DATE(order_date) <=", $filter['to']);
        }

        // Filter sales
        if (!empty($filter['sales_id'])) {
            $this->db->where("sales_id", $filter['sales_id']);
        }

        // Filter status
        if (!empty($filter['status'])) {
            $this->db->where("status", $filter['status']);
        }

        $this->db->group_by("orders.status");

        return $this->db->get()->result_array();
    }
}
