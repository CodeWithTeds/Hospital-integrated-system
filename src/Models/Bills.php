<?php

namespace Hospital\Management\Models;

use Hospital\Management\Database;

class Bills
{
    private $conn;
    private $table = 'bills';

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllBills()
    {
        $sql = "SELECT b.*, p.first_name, p.last_name, a.appointment_date 
                FROM {$this->table} b
                JOIN patients p ON b.patient_id = p.patient_id
                LEFT JOIN appointments a ON b.appointment_id = a.appointment_id
                ORDER BY b.date_issued DESC";

        $result = $this->conn->query($sql);
        $bills = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bills[] = $row;
            }
        }
        return $bills;
    }

    public function getBill($id)
    {
        $sql = "SELECT b.*, p.first_name, p.last_name, a.appointment_date 
                FROM {$this->table} b
                JOIN patients p ON b.patient_id = p.patient_id
                LEFT JOIN appointments a ON b.appointment_id = a.appointment_id
                WHERE b.bill_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createBill($data)
    {
        $sql = "INSERT INTO {$this->table} (
        appointment_id, patient_id, total_amount, status,
        date_issued, payment_due_date
        ) VALUES (?, ?, ?, ?, NOW(), ?)";
        $stmt = $this->conn->prepare($sql);
        $status = 'unpaid';
        $stmt->bind_param(
            "iidss",  // 5 parameters: integer, integer, double, string, string
            $data['appointment_id'],
            $data['patient_id'],
            $data['total_amount'],
            $status,
            $data['payment_due_date']
        );
        return $stmt->execute();
    }

    public function updateBill($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                appointment_id = ?,
                patient_id = ?,
                total_amount = ?,
                status = ?,
                payment_due_date = ?
                WHERE bill_id = ?";
                
        $stmt = $this->conn->prepare($sql);
        
        // Make sure status is one of the allowed values
        $status = in_array($data['status'], ['unpaid', 'paid', 'overdue']) ? $data['status'] : 'unpaid';
        
        $stmt->bind_param("iidssi",  // Note the types: integer, integer, double, string, string, integer
            $data['appointment_id'],
            $data['patient_id'],
            $data['total_amount'],
            $status,
            $data['payment_due_date'],
            $id
        );
        
        return $stmt->execute();
    }

    public function deleteBill($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE bill_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getPatientBills($patientId)
    {
        $sql = "SELECT b.*, p.first_name, p.last_name, a.appointment_date 
                FROM {$this->table} b
                JOIN patients p ON b.patient_id = p.patient_id
                LEFT JOIN appointments a ON b.appointment_id = a.appointment_id
                WHERE b.patient_id = ? 
                ORDER BY b.date_issued DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $patientId);
        $stmt->execute();

        $result = $stmt->get_result();
        $bills = [];

        while ($row = $result->fetch_assoc()) {
            $bills[] = $row;
        }

        return $bills;
    }
    public function getBillsByStatus($status) {
        $sql = "SELECT b.*, CONCAT(p.first_name, ' ', p.last_name) as patient_name 
                FROM {$this->table} b 
                LEFT JOIN patients p ON b.patient_id = p.patient_id 
                WHERE b.status = ?";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUnpaidBills()
    {
        $sql = "SELECT b.*, p.first_name, p.last_name, a.appointment_date 
                FROM {$this->table} b
                JOIN patients p ON b.patient_id = p.patient_id
                LEFT JOIN appointments a ON b.appointment_id = a.appointment_id
                WHERE b.status = 'pending'
                ORDER BY b.date_issued DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $bills = [];

        while ($row = $result->fetch_assoc()) {
            $bills[] = $row;
        }
        return $bills;
    }

    public function getOverdueBills()
    {
        $sql = "SELECT b.*, p.first_name, p.last_name, a.appointment_date 
                FROM {$this->table} b
                JOIN patients p ON b.patient_id = p.patient_id
                LEFT JOIN appointments a ON b.appointment_id = a.appointment_id
                WHERE b.status = 'unpaid' 
                AND b.payment_due_date < CURDATE()
                ORDER BY b.payment_due_date ASC";

        $result = $this->conn->query($sql);
        $bills = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bills[] = $row;
            }
        }
        return $bills;
    }

    public function getAllBillsByPatient($patientId)
    {
        $sql = "SELECT b.*, p.first_name, p.last_name, a.appointment_date 
                FROM {$this->table} b
                JOIN patients p ON b.patient_id = p.patient_id
                LEFT JOIN appointments a ON b.appointment_id = a.appointment_id
                WHERE b.appointment_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateBillStatus($billId, $status)
    {
        // Validate status
        if (!in_array($status, ['unpaid', 'paid', 'overdue'])) {
            return false;
        }
        
        $sql = "UPDATE {$this->table} SET status = ? WHERE bill_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $status, $billId);
        return $stmt->execute();
    }

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
