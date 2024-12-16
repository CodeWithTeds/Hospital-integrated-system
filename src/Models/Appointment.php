<?php
namespace Hospital\Management\Models;
use Hospital\Management\Database;
class Appointment {
    private $conn;
    private $table = 'appointments';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllAppointments() {
        $sql = "SELECT a.*, p.first_name, p.last_name, d.name as doctor_name 
                FROM {$this->table} a
                JOIN patients p ON a.patient_id = p.patient_id
                JOIN doctors d ON a.doctor_id = d.doctor_id
                ORDER BY a.appointment_date, a.appointment_time";
        
        $result = $this->conn->query($sql);
        $appointments = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $appointments[] = $row;
            }
        }
        return $appointments;
    }

    public function getAppointment($id) {
        $sql = "SELECT a.*, p.first_name, p.last_name, d.name as doctor_name 
                FROM {$this->table} a
                JOIN patients p ON a.patient_id = p.patient_id
                JOIN doctors d ON a.doctor_id = d.doctor_id
                WHERE a.appointment_id = ?";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createAppointment($data) {
        $sql = "INSERT INTO {$this->table} (
            patient_id, doctor_id, appointment_date, 
            appointment_time, reason_for_visit, status
        ) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $status = 'scheduled';
        
        $stmt->bind_param("iissss",
            $data['patient_id'],
            $data['doctor_id'],
            $data['appointment_date'],
            $data['appointment_time'],
            $data['reason_for_visit'],
            $status
        );

        return $stmt->execute();
    }

    public function updateAppointment($id, $data) {
        $sql = "UPDATE {$this->table} SET 
            patient_id = ?, 
            doctor_id = ?, 
            appointment_date = ?, 
            appointment_time = ?,
            reason_for_visit = ?, 
            status = ?
            WHERE appointment_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iissssi",
            $data['patient_id'],
            $data['doctor_id'],
            $data['appointment_date'],
            $data['appointment_time'],
            $data['reason_for_visit'],
            $data['status'],
            $id
        );

        return $stmt->execute();
    }

    public function deleteAppointment($id) {
        $sql = "DELETE FROM {$this->table} WHERE appointment_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getUpcomingAppointments($patientId) {
        $sql = "SELECT a.*, p.first_name, p.last_name, d.name as doctor_name 
                FROM {$this->table} a
                JOIN patients p ON a.patient_id = p.patient_id
                JOIN doctors d ON a.doctor_id = d.doctor_id
                WHERE a.patient_id = ? 
                AND a.appointment_date >= CURDATE()
                AND a.status = 'scheduled'
                ORDER BY a.appointment_date, a.appointment_time";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $appointments = [];
        
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        
        return $appointments;
    }

    public function checkAvailability($doctorId, $date, $time) {
        $sql = "SELECT COUNT(*) as count 
                FROM {$this->table} 
                WHERE doctor_id = ? 
                AND appointment_date = ? 
                AND appointment_time = ? 
                AND status = 'scheduled'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $doctorId, $date, $time);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['count'] == 0;
    }

    public function getDoctorAppointments($doctorId, $date) {
        $sql = "SELECT a.*, p.first_name, p.last_name
                FROM {$this->table} a
                JOIN patients p ON a.patient_id = p.patient_id
                WHERE a.doctor_id = ? 
                AND a.appointment_date = ?
                ORDER BY a.appointment_time";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $doctorId, $date);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $appointments = [];
        
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        
        return $appointments;
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>