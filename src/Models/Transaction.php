<?php

namespace Hospital\Management\Models;

use Hospital\Management\Database;

class Transaction {
    private $conn;
    private $table = 'inventory_transactions';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllTransactions() {
        $sql = "SELECT t.*, i.item_name, s.name as supplier_name 
                FROM {$this->table} t
                LEFT JOIN inventory i ON t.inventory_id = i.inventory_id
                LEFT JOIN suppliers s ON t.supplier_id = s.supplier_id
                ORDER BY t.created_at DESC";
        
        $result = $this->conn->query($sql);
        $transactions = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $transactions[] = $row;
            }
        }
        return $transactions;
    }

    public function addTransaction($data) {
        $sql = "INSERT INTO {$this->table} (
            inventory_id, transaction_type, quantity, unit_price,
            reference_number, supplier_id, performed_by, notes
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isidsiss",
            $data['inventory_id'],
            $data['transaction_type'],
            $data['quantity'],
            $data['unit_price'],
            $data['reference_number'],
            $data['supplier_id'],
            $data['performed_by'],
            $data['notes']
        );

        return $stmt->execute();
    }

    public function getTransactionById($id) {
        $sql = "SELECT t.*, i.item_name, s.name as supplier_name 
                FROM {$this->table} t
                LEFT JOIN inventory i ON t.inventory_id = i.inventory_id
                LEFT JOIN suppliers s ON t.supplier_id = s.supplier_id
                WHERE t.transaction_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getTransactionsByInventoryId($inventoryId) {
        $sql = "SELECT t.*, i.item_name, s.name as supplier_name 
                FROM {$this->table} t
                LEFT JOIN inventory i ON t.inventory_id = i.inventory_id
                LEFT JOIN suppliers s ON t.supplier_id = s.supplier_id
                WHERE t.inventory_id = ?
                ORDER BY t.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $inventoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        return $transactions;
    }

    public function getTransactionsByDateRange($startDate, $endDate) {
        $sql = "SELECT t.*, i.item_name, s.name as supplier_name 
                FROM {$this->table} t
                LEFT JOIN inventory i ON t.inventory_id = i.inventory_id
                LEFT JOIN suppliers s ON t.supplier_id = s.supplier_id
                WHERE DATE(t.created_at) BETWEEN ? AND ?
                ORDER BY t.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        return $transactions;
    }

    public function updateTransaction($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                inventory_id = ?, transaction_type = ?, quantity = ?,
                unit_price = ?, reference_number = ?, supplier_id = ?,
                performed_by = ?, notes = ?
                WHERE transaction_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isidsissi",
            $data['inventory_id'],
            $data['transaction_type'],
            $data['quantity'],
            $data['unit_price'],
            $data['reference_number'],
            $data['supplier_id'],
            $data['performed_by'],
            $data['notes'],
            $id
        );

        return $stmt->execute();
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
