<?php

namespace Hospital\Management\Models;

use Hospital\Management\Database;

class Inventory {
    private $conn;
    private $table = 'inventory';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllItems() {
        $sql = "SELECT i.*, s.name as supplier_name 
                FROM {$this->table} i 
                LEFT JOIN suppliers s ON i.supplier_id = s.supplier_id 
                ORDER BY i.item_name";
        $result = $this->conn->query($sql);

        $items = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        return $items;
    }

    public function getItem($id) {
        $sql = "SELECT i.*, s.name as supplier_name 
                FROM {$this->table} i 
                LEFT JOIN suppliers s ON i.supplier_id = s.supplier_id 
                WHERE i.inventory_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addItem($data) {
        $sql = "INSERT INTO {$this->table} (
            item_name, category, quantity_in_stock, reorder_level,
            unit_price, supplier_id, expiry_date, location, description, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        
        $expiry_date = empty($data['expiry_date']) ? null : $data['expiry_date'];
        
        $quantity = intval($data['quantity_in_stock']);
        $reorder = intval($data['reorder_level']);
        $price = floatval($data['unit_price']);
        $supplier = intval($data['supplier_id']);
        
        $stmt->bind_param("ssiidissss",
            $data['item_name'],
            $data['category'],
            $quantity,
            $reorder,
            $price,
            $supplier,
            $expiry_date,
            $data['location'],
            $data['description'],
            $data['status']
        );

        return $stmt->execute();
    }

    public function updateItem($id, $data) {
        $sql = "UPDATE {$this->table} SET 
            item_name = ?, category = ?, quantity_in_stock = ?,
            reorder_level = ?, unit_price = ?, supplier_id = ?,
            expiry_date = ?, location = ?, description = ?, status = ?
            WHERE inventory_id = ?";

        $expiry_date = empty($data['expiry_date']) ? null : $data['expiry_date'];

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssiidissssi",
            $data['item_name'],
            $data['category'],
            $data['quantity_in_stock'],
            $data['reorder_level'],
            $data['unit_price'],
            $data['supplier_id'],
            $expiry_date,
            $data['location'],
            $data['description'],
            $data['status'],
            $id
        );

        return $stmt->execute();
    }

    public function deleteItem($id) {
        $sql = "DELETE FROM {$this->table} WHERE inventory_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getItemsByCategory($category) {
        $sql = "SELECT i.*, s.name as supplier_name 
                FROM {$this->table} i 
                LEFT JOIN suppliers s ON i.supplier_id = s.supplier_id 
                WHERE i.category = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getLowStockItems() {
        $sql = "SELECT i.*, s.name as supplier_name 
                FROM {$this->table} i 
                LEFT JOIN suppliers s ON i.supplier_id = s.supplier_id 
                WHERE i.quantity_in_stock <= i.reorder_level";
        $result = $this->conn->query($sql);
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function adjustStock($id, $quantity, $type) {
        $sql = "UPDATE {$this->table} SET 
                quantity_in_stock = CASE 
                    WHEN ? = 'add' THEN quantity_in_stock + ?
                    WHEN ? = 'subtract' THEN GREATEST(0, quantity_in_stock - ?)
                    ELSE quantity_in_stock
                END,
                status = CASE 
                    WHEN (CASE 
                        WHEN ? = 'add' THEN quantity_in_stock + ?
                        WHEN ? = 'subtract' THEN GREATEST(0, quantity_in_stock - ?)
                        ELSE quantity_in_stock
                    END) <= 0 THEN 'Out of Stock'
                    ELSE 'Active'
                END
                WHERE inventory_id = ?";

        $stmt = $this->conn->prepare($sql);
        
        // Convert quantity to integer
        $qty = intval($quantity);
        
        // Bind the parameters in the correct order
        $stmt->bind_param("sisisissi", 
            $type,      // First CASE condition
            $qty,       // First quantity
            $type,      // Second CASE condition
            $qty,       // Second quantity
            $type,      // Third CASE condition
            $qty,       // Third quantity
            $type,      // Fourth CASE condition
            $qty,       // Fourth quantity
            $id         // WHERE clause
        );

        return $stmt->execute();
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}