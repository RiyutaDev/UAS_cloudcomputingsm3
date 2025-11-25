<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

    private $table = 'users';

    // Ambil user berdasarkan username (case insensitive)
    public function get_by_username($username) {
        return $this->db
            ->where('LOWER(username)', strtolower($username))
            ->get($this->table)
            ->row();
    }

    // Ambil user berdasarkan ID
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    // Ambil semua user
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    // Insert user – password disimpan sebagai password_hash
    public function insert($data) {

        if (!empty($data['password'])) {

            // Validasi regex password
            if (!$this->valid_password_regex($data['password'])) {
                return false; // tidak memenuhi syarat
            }

            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }

        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); // return id baru
    }

    // Update user
    public function update($id, $data) {

        if (!empty($data['password'])) {

            // Validasi password baru
            if (!$this->valid_password_regex($data['password'])) {
                return false;
            }

            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        } else {
            unset($data['password']);
            unset($data['password_hash']);
        }

        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Hapus user
    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    // Hitung jumlah user
    public function count_all() {
        return $this->db->count_all($this->table);
    }

    // Validasi password dengan regex (huruf besar, kecil, angka, simbol)
    public function valid_password_regex($password) {
        $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*\W).{8,}$/";
        return preg_match($pattern, $password);
    }
}
