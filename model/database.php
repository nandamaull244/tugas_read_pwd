<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'toko');

class Database {
    public $mysqli;
    protected $query;
    protected $tableName;

    function __construct() {
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
            exit();
        }
    }

    // SELECT * FROM table
    function table($table) {
        $this->tableName = $table;
        $this->query = "SELECT * FROM $table";
        return $this;
    }

    // WHERE clause
    public function where($column, $value = null) {
        if (is_array($column)) {
            $conditions = [];
            foreach ($column as $key => $val) {
                $conditions[] = "$key = '$val'";
            }
            $clause = implode(" AND ", $conditions);
        } else {
            $clause = "$column = '$value'";
        }

        $this->query .= " WHERE $clause";
        return $this;
    }

    // GET ALL
    public function get() {
        $result = $this->mysqli->query($this->query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // GET ONE
    public function first() {
        $result = $this->mysqli->query($this->query);
        return $result->fetch_assoc();
    }

    // INSERT
    function insert($arr = []) {
        $keys = implode(", ", array_keys($arr));
        $vals = "'" . implode("','", array_values($arr)) . "'";
        $query = "INSERT INTO $this->tableName ($keys) VALUES ($vals)";
        return $this->mysqli->query($query);
    }

    // UPDATE
    public function update($arr = []) {
        // buat SET
        $set = "";
        foreach ($arr as $key => $value) {
            $set .= "$key = '$value', ";
        }
        $set = rtrim($set, ", ");

        // ambil WHERE dari query sebelumnya
        $wherePart = explode("WHERE", $this->query);

        if (!isset($wherePart[1])) {
            die("ERROR: UPDATE membutuhkan WHERE!");
        }

        $where = trim($wherePart[1]);

        $query = "UPDATE $this->tableName SET $set WHERE $where";

        return $this->mysqli->query($query);
    }

    // DELETE
    function delete() {
        $wherePart = explode("WHERE", $this->query);

        if (!isset($wherePart[1])) {
            die("ERROR: DELETE membutuhkan WHERE!");
        }

        $where = trim($wherePart[1]);
        $query = "DELETE FROM $this->tableName WHERE $where";

        return $this->mysqli->query($query);
    }
}
