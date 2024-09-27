<?php
class Database {
    // Nuevos datos de conexión
    private $host = "us-cluster-east-01.k8s.cleardb.net";
    private $db_name = "heroku_a0591520c83c92b";
    private $username = "b7cf295cbfdbf0";
    private $password = "3dcd9529";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>

