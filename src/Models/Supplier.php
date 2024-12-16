<?php

namespace Hospital\Management\Models;

use Hospital\Management\Database;

class Supplier
{
    private $conn;
    private $table = 'suppliers';

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllSuppliers()
    {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->conn->query($sql);

        $suppliers = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $suppliers[] = $row;
            }
        }

        return $suppliers;
    }

    public function getSupplier($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE supplier_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);   
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addSupplier($data) {
        $sql = "INSERT INTO {$this->table} (
            name, contact_person, contact_number, email, address,
            website, tax_id, payment_terms, credit_limit, supplier_type,
            rating, notes
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssdsis",
            $data['name'],
            $data['contact_person'],
            $data['contact_number'],
            $data['email'],
            $data['address'],
            $data['website'],
            $data['tax_id'],
            $data['payment_terms'],
            $data['credit_limit'],
            $data['supplier_type'],
            $data['rating'],
            $data['notes']
        );

        return $stmt->execute();
    }

    public function updateSupplier($id, $data) {
        $sql = "UPDATE {$this->table} SET 
            name = ?, contact_person = ?, contact_number = ?, 
            email = ?, address = ?, website = ?, tax_id = ?,
            payment_terms = ?, credit_limit = ?, supplier_type = ?,
            rating = ?, notes = ?, is_active = ?
            WHERE supplier_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssdsiiii",
            $data['name'],
            $data['contact_person'],
            $data['contact_number'],
            $data['email'],
            $data['address'],
            $data['website'],
            $data['tax_id'],
            $data['payment_terms'],
            $data['credit_limit'],
            $data['supplier_type'],
            $data['rating'],
            $data['notes'],
            $data['is_active'],
            $id
        );

        return $stmt->execute();
    }

    public function deleteSupplier($id) {
        $sql = "DELETE FROM {$this->table} WHERE supplier_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function toggleSupplierStatus($id, $status) {
        $sql = "UPDATE {$this->table} SET is_active = ? WHERE supplier_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $status, $id);
        return $stmt->execute();
    }

    public function getSuppliersByType($type) {
        $sql = "SELECT * FROM {$this->table} WHERE supplier_type = ? AND is_active = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $type);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $suppliers = [];
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }
        return $suppliers;
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
