<?php
namespace Hospital\Management;

use mysqli;

class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $conn;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->username = getenv('DB_USERNAME') ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: '';
        $this->database = getenv('DB_NAME') ?: 'Hospital_management';
    }

    public function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        if (!$this->conn->select_db($this->database)) {
            die("Database selection failed: " . $this->conn->error);
        }

        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}