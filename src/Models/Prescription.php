<?php
namespace Hospital\Management\Models;
use Hospital\Management\Database;

class Prescription {
    private $conn;
    private $table = 'prescriptions';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllPrescriptions() {
        $sql = "SELECT p.*, pt.first_name, pt.last_name, d.name as doctor_name 
                FROM {$this->table} p
                JOIN patients pt ON p.patient_id = pt.patient_id
                JOIN doctors d ON p.doctor_id = d.doctor_id
                ORDER BY p.prescription_date DESC";
        
        $result = $this->conn->query($sql);
        $prescriptions = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $prescriptions[] = $row;
            }
        }
        return $prescriptions;
    }

    public function getPrescription($id) {
        $sql = "SELECT p.*, pt.first_name, pt.last_name, d.name as doctor_name 
                FROM {$this->table} p
                JOIN patients pt ON p.patient_id = pt.patient_id
                JOIN doctors d ON p.doctor_id = d.doctor_id
                WHERE p.prescription_id = ?";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createPrescription($data) {
        $sql = "INSERT INTO {$this->table} (
            patient_id, doctor_id, prescription_date, 
            medications, dosage, frequency, duration, 
            notes, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $status = 'active';
        
        $stmt->bind_param("iisssssss",
            $data['patient_id'],
            $data['doctor_id'],
            $data['prescription_date'],
            $data['medications'],
            $data['dosage'],
            $data['frequency'],
            $data['duration'],
            $data['notes'],
            $status
        );

        return $stmt->execute();
    }

    public function updatePrescription($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                patient_id = ?, doctor_id = ?, prescription_date = ?,
                medications = ?, dosage = ?, frequency = ?,
                duration = ?, notes = ?, status = ?
                WHERE prescription_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisssssssi",
            $data['patient_id'],
            $data['doctor_id'],
            $data['prescription_date'],
            $data['medications'],
            $data['dosage'],
            $data['frequency'],
            $data['duration'],
            $data['notes'],
            $data['status'],
            $id
        );

        return $stmt->execute();
    }

    public function deletePrescription($id) {
        $sql = "DELETE FROM {$this->table} WHERE prescription_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getPatientPrescriptions($patientId) {
        $sql = "SELECT p.*, d.name as doctor_name 
                FROM {$this->table} p
                JOIN doctors d ON p.doctor_id = d.doctor_id
                WHERE p.patient_id = ?
                ORDER BY p.prescription_date DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $prescriptions = [];
        
        while ($row = $result->fetch_assoc()) {
            $prescriptions[] = $row;
        }
        
        return $prescriptions;
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
} 