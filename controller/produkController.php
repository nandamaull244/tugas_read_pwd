<?php 

require_once '../model/database.php';

class ProdukController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function index() {
        return $this->db->table('hp')->get();
    }

    public function addProduk($data) {
        var_dump($data);
        return $this->db->table('hp')->insert($data);
    }
    public function updateProduk($id, $data) {
        return $this->db->table('hp')->where('id', $id)->update($data);
    }
    public function deleteProduk($id) {
        return $this->db->table('hp')->where('id', $id)->delete();
    }

    public function getById($id) {
        return $this->db->table('hp')->where('id', $id)->first();
    }

}