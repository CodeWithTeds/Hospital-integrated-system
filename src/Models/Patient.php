<?php

namespace Hospital\Management\Models;

use Hospital\Management\Database;

class Patient {
    private $conn;
    private $table = 'patients';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllPatients() {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->conn->query($sql);
        
        $patients = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $patients[] = $row;
            }
        }
        return $patients;
    }

    public function getPatient($id) {
        $sql = "SELECT * FROM {$this->table} WHERE patient_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addPatient($data) {
        try {
            // Validate gender value
            $validGenders = ['Male', 'Female', 'Other'];
            $gender = ucfirst(strtolower($data['gender'])); // Capitalize first letter
            
            if (!in_array($gender, $validGenders)) {
                error_log("Invalid gender value: " . $data['gender']);
                return false;
            }

            $sql = "INSERT INTO {$this->table} (
                first_name, last_name, middle_name, date_of_birth, 
                gender, contact_number, email, address, 
                medical_history, current_medications, 
                emergency_contact_name, emergency_contact_number
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssssssssss",
                $data['first_name'],
                $data['last_name'],
                $data['middle_name'],
                $data['date_of_birth'],
                $gender, // Use the validated gender value
                $data['contact_number'],
                $data['email'],
                $data['address'],
                $data['medical_history'],
                $data['current_medications'],
                $data['emergency_contact_name'],
                $data['emergency_contact_number']
            );

            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Error adding patient: " . $e->getMessage());
            return false;
        }
    }

    public function updatePatient($id, $data){
        $sql = "UPDATE {$this->table} SET
        first_name = ?, last_name = ?, middle_name = ?,
        date_of_birth = ?, gender = ?, contact_number = ?,
        email = ?, address = ?, medical_history = ?, current_medications = ?,
        emergency_contact_name = ?, emergency_contact_number = ? WHERE patient_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssssssi",

        $data['first_name'],
        $data['last_name'],
        $data['middle_name'],
        $data['date_of_birth'],
        $data['gender'],
        $data['contact_number'],
        $data['email'],
        $data['address'],
        $data['medical_history'],
        $data['current_medications'],
        $data['emergency_contact_name'],
        $data['emergency_contact_number'],
        $id
        );

        return $stmt->execute();
    }

    public function deletePatient($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE patient_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (\Exception $e) {
            error_log("Error deleting patient: " . $e->getMessage());
            return false;
        }
    }
    

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}