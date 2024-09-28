<?php
class Database {
    // Datos de conexión proporcionados
    private $host = "www.server.daossystem.pro";
    private $port = "3301";
    private $db_name = "desaweb_2024_sp";
    private $username = "usr_desaweb_2024_sp";
    private $password = "5sr_d2s1w2b_2024_sp";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}


