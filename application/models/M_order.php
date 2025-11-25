<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_order extends CI_Model {

    // Ambil semua order
    public function get_all() {
        return $this->db->select('orders.*, customers.name AS customer_name, sales.name AS sales_name')
                        ->from('orders')
                        ->join('customers', 'customers.id = orders.customer_id', 'left')
                        ->join('sales', 'sales.id = orders.sales_id', 'left')
                        ->order_by('orders.id', 'DESC')
                        ->get()
                        ->result();
    }

    // Ambil order berdasarkan sales
    public function get_by_sales($sales_id) {
        return $this->db->select('orders.*, customers.name AS customer_name, sales.name AS sales_name')
                        ->from('orders')
                        ->join('customers', 'customers.id = orders.customer_id', 'left')
                        ->join('sales', 'sales.id = orders.sales_id', 'left')
                        ->where('orders.sales_id', $sales_id)
                        ->order_by('orders.id', 'DESC')
                        ->get()
                        ->result();
    }

    // Ambil detail order by ID
    public function get_by_id($id) {
        return $this->db->where('id', $id)
                        ->get('orders')
                        ->row();
    }

    // Insert order
    public function insert_order($data) {
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }

    // Insert item order
    public function insert_item($data) {
        return $this->db->insert('order_items', $data);
    }

    // UPDATE order
    public function update_order($id, $data) {
        return $this->db->where('id', $id)->update('orders', $data);
    }

    // DELETE order + hapus item
    public function delete($id) {
        // Hapus detail item dulu
        $this->db->where('order_id', $id)->delete('order_items');

        // Hapus order
        return $this->db->where('id', $id)->delete('orders');
    }

    // Ambil semua item berdasarkan order_id
    public function get_items($order_id) {
        return $this->db->select('order_items.*, products.name, products.stock')
                        ->from('order_items')
                        ->join('products', 'products.id = order_items.product_id', 'left')
                        ->where('order_items.order_id', $order_id)
                        ->get()
                        ->result();
    }

    // === FILTER LAPORAN ===
    public function filter_report($start_date = null, $end_date = null, $sales_id = null, $status = null)
    {
        $this->db->select('orders.*, customers.name AS customer_name, sales.name AS sales_name')
                 ->from('orders')
                 ->join('customers', 'customers.id = orders.customer_id', 'left')
                 ->join('sales', 'sales.id = orders.sales_id', 'left');

        if (!empty($start_date))
            $this->db->where('orders.order_date >=', $start_date . " 00:00:00");

        if (!empty($end_date))
            $this->db->where('orders.order_date <=', $end_date . " 23:59:59");

        if (!empty($sales_id))
            $this->db->where('orders.sales_id', $sales_id);

        if (!empty($status))
            $this->db->where('orders.status', $status);

        return $this->db->order_by('orders.id', 'DESC')->get()->result();
    }
}
