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
}