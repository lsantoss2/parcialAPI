<?php
class Database {
    // Datos de conexión desde la URL obtenida
    private $host = "us-cluster-east-01.k8s.cleardb.net";
    private $db_name = "heroku_3a87f62d1791bda";
    private $username = "b3633befa1a619";
    private $password = "4e452c28";
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
