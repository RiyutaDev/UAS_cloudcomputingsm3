<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model(['M_order', 'M_customer', 'M_sales', 'M_product']);

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // role string (admin, manager, etc.) — keep for view checks
        $this->role = $this->session->userdata('role');
        $this->user_id = $this->session->userdata('user_id');
    }

    // tampilkan daftar order
    public function index() {
        $data['title'] = 'Data Sales Order';

        if ($this->role === 'admin') {
            $data['orders'] = $this->M_order->get_all();
        } else {
            $sales_id = $this->session->userdata('sales_id');
            $data['orders'] = $this->M_order->get_by_sales($sales_id);
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('orders/index', $data);
        $this->load->view('template/footer');
    }

    // buat order baru
    public function create() {
        // generate code order terakhir
        $last = $this->db->select('order_code')->order_by('id', 'DESC')->limit(1)->get('orders')->row();
        $num = $last ? (int) substr($last->order_code, 2) + 1 : 1;
        $order_code = 'SO' . str_pad($num, 3, '0', STR_PAD_LEFT);

        $data['title'] = 'Tambah Sales Order';
        $data['order_code'] = $order_code;
        $data['customers'] = $this->M_customer->get_all();
        $data['products'] = $this->M_product->get_all();

        if ($this->role === 'admin') {
            $data['sales'] = $this->M_sales->get_all();
        }

        // handle submit form
        if ($this->input->post()) {

            $sales_id = ($this->role === 'admin') ? $this->input->post('sales_id', true) : $this->session->userdata('sales_id');

            if (empty($sales_id)) {
                $this->session->set_flashdata('error', 'Gagal mendapatkan ID Sales. Silakan login ulang.');
                redirect('orders/create');
            }

            $products = $this->input->post('product_id');
            $quantities = $this->input->post('quantity');

            if (empty($products) || empty($quantities)) {
                $this->session->set_flashdata('error', 'Pilih minimal 1 produk untuk order.');
                redirect('orders/create');
            }

            // validasi stok produk
            foreach ($products as $i => $pid) {
                $qty = (int) ($quantities[$i] ?? 0);
                $product = $this->M_product->get_by_id($pid);

                if (!$product) {
                    $this->session->set_flashdata('error', 'Produk tidak ditemukan.');
                    redirect('orders/create');
                }

                if ($qty <= 0) {
                    $this->session->set_flashdata('error', 'Jumlah produk harus lebih dari 0.');
                    redirect('orders/create');
                }

                if ($product->stock < $qty) {
                    $this->session->set_flashdata('error',
                        'Stok produk <b>' . $product->name . '</b> tidak mencukupi. Stok: ' . $product->stock . ' | Diminta: ' . $qty
                    );
                    redirect('orders/create');
                }
            }

            // simpan order
            $order_data = [
                'order_code'  => $order_code,
                'customer_id' => $this->input->post('customer_id', true),
                'sales_id'    => $sales_id,
                'status'      => 'draft',
                'order_date'  => date('Y-m-d H:i:s'),
                'note'        => $this->input->post('note', true)
            ];

            $order_id = $this->M_order->insert_order($order_data);
            if (!$order_id) {
                $this->session->set_flashdata('error', 'Gagal menyimpan order.');
                redirect('orders/create');
            }

            // simpan item order dan kurangi stok
            $total = 0;
            foreach ($products as $i => $pid) {
                $qty = (int) ($quantities[$i] ?? 0);
                $product = $this->M_product->get_by_id($pid);

                if (!$product || $qty <= 0) continue;

                $subtotal = $product->price * $qty;
                $total += $subtotal;

                // insert order item
                $this->M_order->insert_item([
                    'order_id'   => $order_id,
                    'product_id' => $pid,
                    'quantity'   => $qty,
                    'unit_price' => $product->price,
                    'subtotal'   => $subtotal
                ]);

                // kurangi stok langsung per produk
                $this->db->where('id', $pid)->update('products', [
                    'stock' => $product->stock - $qty
                ]);
            }

            // update total
            $this->M_order->update_order($order_id, ['total_price' => $total]);

            // catat audit log (create)
            $this->db->insert('audit_log', [
                'user_id'    => $this->user_id,
                'action'     => 'create',
                'detail'     => 'Membuat sales order: ' . $order_code,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $this->session->set_flashdata('success', 'Sales order berhasil ditambahkan!');
            redirect('orders');
        }

        // tampilkan form
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('orders/add', $data);
        $this->load->view('template/footer');
    }

    // update status order
    public function update_status($id)
    {
        // hanya admin boleh ubah status
        if ($this->role !== 'admin') {
            show_error('Akses ditolak. Hanya admin yang dapat mengubah status order.', 403);
        }

        $order = $this->M_order->get_by_id($id);
        if (!$order) {
            show_404();
        }

        $new_status = $this->input->post('status', true);
        $now = date('Y-m-d H:i:s');

        // jika tidak ada perubahan, kembali
        if ($new_status === $order->status) {
            $this->session->set_flashdata('info', 'Tidak ada perubahan status.');
            redirect('orders');
        }

        // jika status berubah menjadi 'dibatalkan' -> restore stok
        if ($new_status === 'dibatalkan') {
            $items = $this->M_order->get_items($id);
            foreach ($items as $item) {
                $product = $this->M_product->get_by_id($item->product_id);
                if ($product) {
                    $this->db->where('id', $product->id)->update('products', [
                        'stock' => $product->stock + (int)$item->quantity
                    ]);
                }
            }

            // set canceled_at
            $update_data = [
                'status'      => $new_status,
                'canceled_at' => $now,
                'sent_at'     => null,
                'completed_at'=> null
            ];

            $this->M_order->update_order($id, $update_data);

            // audit log for cancel
            $this->db->insert('audit_log', [
                'user_id'    => $this->user_id,
                'action'     => 'update',
                'detail'     => 'Membatalkan order ' . $order->order_code . ' dan mengembalikan stok.',
                'created_at' => $now
            ]);

            $this->session->set_flashdata('success', 'Order dibatalkan dan stok dikembalikan.');
            redirect('orders');
        }

        // jika status berubah ke dikirim / selesai (tanggal sesuai)
        $update_data = [
            'status'        => $new_status,
            'sent_at'       => ($new_status === 'dikirim') ? $now : null,
            'completed_at'  => ($new_status === 'selesai') ? $now : null,
            'canceled_at'   => null
        ];

        $this->M_order->update_order($id, $update_data);

        // audit log for status change
        $this->db->insert('audit_log', [
            'user_id'    => $this->user_id,
            'action'     => 'update',
            'detail'     => 'Mengubah status order ' . $order->order_code . ' menjadi: ' . $new_status,
            'created_at' => $now
        ]);

        $this->session->set_flashdata('success', 'Status order berhasil diperbarui.');
        redirect('orders');
    }

    // hapus order
    public function delete($id) {
        if ($this->role !== 'admin') {
            show_error('Akses ditolak. Hanya admin yang dapat menghapus order.', 403);
        }

        // sebelum hapus, dapatkan order code (untuk log)
        $order = $this->M_order->get_by_id($id);
        if (!$order) {
            $this->session->set_flashdata('error', 'Order tidak ditemukan.');
            redirect('orders');
        }

        // hapus order dan itemnya
        $this->M_order->delete($id);

        // catat log delete
        $this->db->insert('audit_log', [
            'user_id'    => $this->user_id,
            'action'     => 'delete',
            'detail'     => 'Menghapus order: ' . $order->order_code,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Sales order berhasil dihapus!');
        redirect('orders');
    }
}
