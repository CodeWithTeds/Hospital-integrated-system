<?php

namespace Hospital\Management\Models;

use Hospital\Management\Database;

class Doctor {
    private $conn;
    private $table = 'doctors';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllDoctors() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->conn->query($sql);
        
        $doctors = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $doctors[] = $row;
            }
        }
        return $doctors;
    }

    public function getDoctor($id) {
        $sql = "SELECT * FROM {$this->table} WHERE doctor_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addDoctor($data) {
        $sql = "INSERT INTO {$this->table} (name, specialization, contact_number, email, schedule_start, schedule_end) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", 
            $data['name'],
            $data['specialization'],
            $data['contact_number'],
            $data['email'],
            $data['schedule_start'],
            $data['schedule_end']
        );

        return $stmt->execute();
    }

    public function updateDoctor($id, $data) {
        $sql = "UPDATE {$this->table} SET name = ?, specialization = ?, contact_number = ?, 
                email = ?, schedule_start = ?, schedule_end = ? WHERE doctor_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssi", 
            $data['name'],
            $data['specialization'],
            $data['contact_number'],
            $data['email'],
            $data['schedule_start'],
            $data['schedule_end'],
            $id
        );

        return $stmt->execute();
    }

    public function deleteDoctor($id) {
        $sql = "DELETE FROM {$this->table} WHERE doctor_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
} 