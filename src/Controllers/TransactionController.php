<?php

namespace Hospital\Management\Controllers;

use Hospital\Management\Models\Transaction;
use Hospital\Management\Models\Inventory;
use Hospital\Management\Models\Supplier;
use Hospital\Management\Database;

class TransactionController {
    private $transactionModel;
    private $inventoryModel;
    private $supplierModel;
    private $db;

    public function __construct() {
        $this->transactionModel = new Transaction();
        $this->inventoryModel = new Inventory();
        $this->supplierModel = new Supplier();
        $database = new Database();
        $this->db = $database->connect();
    }

    public function index() {
        $transactions = $this->transactionModel->getAllTransactions();
        $inventory_items = $this->inventoryModel->getAllItems();
        $suppliers = $this->supplierModel->getAllSuppliers();
        require_once __DIR__ . '/../../views/Transaction/inventory_transactions.php';
    }

    public function addTransaction() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $performed_by = $_SESSION['user_name'] ?? 'System User';

            $data = [
                'inventory_id' => $_POST['inventory_id'],
                'transaction_type' => $_POST['transaction_type'],
                'quantity' => $_POST['quantity'],
                'unit_price' => $_POST['unit_price'],
                'reference_number' => $_POST['reference_number'],
                'supplier_id' => !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null,
                'performed_by' => $performed_by,
                'notes' => $_POST['notes']
            ];

            // Begin transaction
            $this->db->begin_transaction();

            try {
                // Add the transaction record
                if (!$this->transactionModel->addTransaction($data)) {
                    throw new \Exception("Failed to add transaction");
                }

                // Update inventory quantity
                $adjustment = ($data['transaction_type'] === 'stock-in' || 
                             $data['transaction_type'] === 'return') ? 'add' : 'subtract';
                
                if (!$this->inventoryModel->adjustStock(
                    $data['inventory_id'], 
                    $data['quantity'], 
                    $adjustment
                )) {
                    throw new \Exception("Failed to update inventory");
                }

                // Commit transaction
                $this->db->commit();
                header('Location: index.php?action=transactions&success=created');
            } catch (\Exception $e) {
                // Rollback on error
                $this->db->rollback();
                header('Location: index.php?action=transactions&error=create_failed');
            }
            exit();
        }
    }

    public function filterTransactions() {
        $start_date = $_GET['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? null;

        if ($start_date && $end_date) {
            $transactions = $this->transactionModel->getTransactionsByDateRange($start_date, $end_date);
        } else {
            $transactions = $this->transactionModel->getAllTransactions();
        }

        $inventory_items = $this->inventoryModel->getAllItems();
        $suppliers = $this->supplierModel->getAllSuppliers();
        require_once __DIR__ . '/../../views/Transaction/inventory_transactions.php';
    }

    public function getTransactionsByItem() {
        $inventory_id = $_GET['inventory_id'] ?? null;
        if (!$inventory_id) {
            header('Location: index.php?action=transactions&error=invalid_item');
            exit();
        }

        $transactions = $this->transactionModel->getTransactionsByInventoryId($inventory_id);
        $inventory_items = $this->inventoryModel->getAllItems();
        $suppliers = $this->supplierModel->getAllSuppliers();
        require_once __DIR__ . '/../../views/Transaction/inventory_transactions.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=transactions&error=invalid_id');
            exit();
        }

        $transaction = $this->transactionModel->getTransactionById($id);
        $inventory_items = $this->inventoryModel->getAllItems();
        $suppliers = $this->supplierModel->getAllSuppliers();
        require_once __DIR__ . '/../../views/Transaction/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['transaction_id'] ?? null;
            if (!$id) {
                header('Location: index.php?action=transactions&error=invalid_id');
                exit();
            }

            $performed_by = $_SESSION['user_name'] ?? 'System User';

            $data = [
                'inventory_id' => $_POST['inventory_id'],
                'transaction_type' => $_POST['transaction_type'],
                'quantity' => $_POST['quantity'],
                'unit_price' => $_POST['unit_price'],
                'reference_number' => $_POST['reference_number'],
                'supplier_id' => !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null,
                'performed_by' => $performed_by,
                'notes' => $_POST['notes']
            ];

            if ($this->transactionModel->updateTransaction($id, $data)) {
                header('Location: index.php?action=transactions&success=updated');
            } else {
                header('Location: index.php?action=transactions&error=update_failed');
            }
            exit();
        }
    }
} 