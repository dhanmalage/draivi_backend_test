<?php
class Database {
    private $host = "localhost";
    private $db_name = "draivi_backend_test";
    private $username = "root";
    private $password = "";
    public $conn;

    /**
     * Database connection using PDO Class
     */
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
