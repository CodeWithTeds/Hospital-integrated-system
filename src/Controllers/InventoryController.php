<?php

namespace Hospital\Management\Controllers;

use Hospital\Management\Models\Inventory;
use Hospital\Management\Models\Supplier;

class InventoryController {
    private $inventoryModel;
    private $supplierModel;

    public function __construct() {
        $this->inventoryModel = new Inventory();
        $this->supplierModel = new Supplier();
    }

    public function index() {
        $inventory = $this->inventoryModel->getAllItems();
        $suppliers = $this->supplierModel->getAllSuppliers();
        require_once __DIR__ . '/../../views/inventory/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'item_name' => $_POST['item_name'],
                'category' => $_POST['category'],
                'quantity_in_stock' => $_POST['quantity_in_stock'],
                'reorder_level' => $_POST['reorder_level'],
                'unit_price' => $_POST['unit_price'],
                'supplier_id' => $_POST['supplier_id'],
                'expiry_date' => $_POST['expiry_date'] ?? null,
                'location' => $_POST['location'] ?? null,
                'description' => $_POST['description'] ?? null,
                'status' => $_POST['status'] ?? 'Active'
            ];

            if ($this->inventoryModel->addItem($data)) {
                header('Location: index.php?action=inventory&success=created');
            } else {
                header('Location: index.php?action=inventory&error=create_failed');
            }
            exit();
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=inventory&error=invalid_id');
            exit();
        }

        $item = $this->inventoryModel->getItem($id);
        $suppliers = $this->supplierModel->getAllSuppliers();
        require_once __DIR__ . '/../../views/inventory/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['inventory_id'] ?? null;
            if (!$id) {
                header('Location: index.php?action=inventory&error=invalid_id');
                exit();
            }

            $data = [
                'item_name' => $_POST['item_name'],
                'category' => $_POST['category'],
                'quantity_in_stock' => $_POST['quantity_in_stock'],
                'reorder_level' => $_POST['reorder_level'],
                'unit_price' => $_POST['unit_price'],
                'supplier_id' => $_POST['supplier_id'],
                'expiry_date' => $_POST['expiry_date'] ?? null,
                'location' => $_POST['location'] ?? null,
                'description' => $_POST['description'] ?? null,
                'status' => $_POST['status']
            ];

            if ($this->inventoryModel->updateItem($id, $data)) {
                header('Location: index.php?action=inventory&success=updated');
            } else {
                header('Location: index.php?action=edit_inventory&id=' . $id . '&error=update_failed');
            }
            exit();
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=inventory&error=invalid_id');
            exit();
        }

        if ($this->inventoryModel->deleteItem($id)) {
            header('Location: index.php?action=inventory&success=deleted');
        } else {
            header('Location: index.php?action=inventory&error=delete_failed');
        }
        exit();
    }

    public function filterByCategory() {
        $category = $_GET['category'] ?? null;
        if (!$category) {
            header('Location: index.php?action=inventory&error=invalid_category');
            exit();
        }

        $inventory = $this->inventoryModel->getItemsByCategory($category);
        $suppliers = $this->supplierModel->getAllSuppliers();
        require_once __DIR__ . '/../../views/inventory/index.php';
    }

    public function checkLowStock() {
        $lowStockItems = $this->inventoryModel->getLowStockItems();
        require_once __DIR__ . '/../../views/inventory/low_stock.php';
    }

    public function adjustStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['inventory_id'];
            $quantity = $_POST['quantity'];
            $type = $_POST['adjustment_type']; // 'add' or 'subtract'

            if ($this->inventoryModel->adjustStock($id, $quantity, $type)) {
                header('Location: index.php?action=inventory&success=stock_adjusted');
            } else {
                header('Location: index.php?action=inventory&error=adjustment_failed');
            }
            exit();
        }
    }
}
