<?php

namespace Hospital\Management\Models;

use Hospital\Management\Database;

class BillItems {
    private $conn;
    private $table = 'bill_items';

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }
    public function createBillItem($data) {
        $sql = "INSERT INTO {$this->table} (bill_id, description, amount) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isd", 
            $data['bill_id'],
            $data['description'],
            $data['amount']
        );
        return $stmt->execute();
    }

    public function getBillItems($billId) {
        $sql = "SELECT * FROM {$this->table} WHERE bill_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $billId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateBillItem($id, $data) {
        $sql = "UPDATE {$this->table} SET description = ?, amount = ? WHERE bill_item_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdi", 
            $data['description'],
            $data['amount'],
            $id
        );
        return $stmt->execute();
    }

    public function deleteBillItem($id) {
        $sql = "DELETE FROM {$this->table} WHERE bill_item_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
} 