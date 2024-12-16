<?php

namespace Hospital\Management\Controllers;

use Hospital\Management\Models\Supplier;

class SupplierController {
    private $supplierModel;

    public function __construct() {
        $this->supplierModel = new Supplier();
    }

    public function index() {
        $suppliers = $this->supplierModel->getAllSuppliers();
        require_once __DIR__ . '/../../views/suppliers/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'contact_person' => $_POST['contact_person'],
                'contact_number' => $_POST['contact_number'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'website' => $_POST['website'] ?? null,
                'tax_id' => $_POST['tax_id'] ?? null,
                'payment_terms' => $_POST['payment_terms'] ?? null,
                'credit_limit' => $_POST['credit_limit'] ?? 0.00,
                'supplier_type' => $_POST['supplier_type'],
                'rating' => $_POST['rating'] ?? 1,
                'notes' => $_POST['notes'] ?? null
            ];

            if ($this->supplierModel->addSupplier($data)) {
                header('Location: index.php?action=suppliers&success=created');
            } else {
                header('Location: index.php?action=suppliers&error=create_failed');
            }
            exit();
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=suppliers&error=invalid_id');
            exit();
        }

        $supplier = $this->supplierModel->getSupplier($id);
        require_once __DIR__ . '/../../views/suppliers/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['supplier_id'] ?? null;
            if (!$id) {
                header('Location: index.php?action=suppliers&error=invalid_id');
                exit();
            }

            $data = [
                'name' => $_POST['name'],
                'contact_person' => $_POST['contact_person'],
                'contact_number' => $_POST['contact_number'],
                'email' => $_POST['email'],
                'address' => $_POST['address'],
                'website' => $_POST['website'] ?? null,
                'tax_id' => $_POST['tax_id'] ?? null,
                'payment_terms' => $_POST['payment_terms'] ?? null,
                'credit_limit' => $_POST['credit_limit'] ?? 0.00,
                'supplier_type' => $_POST['supplier_type'],
                'rating' => $_POST['rating'] ?? 1,
                'notes' => $_POST['notes'] ?? null,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->supplierModel->updateSupplier($id, $data)) {
                header('Location: index.php?action=suppliers&success=updated');
            } else {
                header('Location: index.php?action=edit_supplier&id=' . $id . '&error=update_failed');
            }
            exit();
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=suppliers&error=invalid_id');
            exit();
        }

        if ($this->supplierModel->deleteSupplier($id)) {
            header('Location: index.php?action=suppliers&success=deleted');
        } else {
            header('Location: index.php?action=suppliers&error=delete_failed');
        }
        exit();
    }

    public function toggleStatus() {
        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? null;
        
        if (!$id || !in_array($status, [0, 1])) {
            header('Location: index.php?action=suppliers&error=invalid_request');
            exit();
        }

        if ($this->supplierModel->toggleSupplierStatus($id, $status)) {
            header('Location: index.php?action=suppliers&success=status_updated');
        } else {
            header('Location: index.php?action=suppliers&error=status_update_failed');
        }
        exit();
    }

    public function filterByType() {
        $type = $_GET['type'] ?? null;
        if (!$type) {
            header('Location: index.php?action=suppliers&error=invalid_type');
            exit();
        }

        $suppliers = $this->supplierModel->getSuppliersByType($type);
        require_once __DIR__ . '/../../views/suppliers/index.php';
    }
}
