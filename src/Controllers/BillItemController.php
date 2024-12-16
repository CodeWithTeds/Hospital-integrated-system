<?php

namespace Hospital\Management\Controllers;

use Hospital\Management\Models\BillItems;

class BillItemController {
    private $billItemModel;

    public function __construct() {
        $this->billItemModel = new BillItems();
    }

    public function index($billId) {
        $billItems = $this->billItemModel->getBillItems($billId);
        require_once __DIR__ . '/../../views/bill_items/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'bill_id' => $_POST['bill_id'],
                'description' => $_POST['description'],
                'amount' => $_POST['amount']
            ];

            if ($this->billItemModel->createBillItem($data)) {
                header('Location: index.php?action=view_bill&id=' . $data['bill_id'] . '&success=item_added');
            } else {
                header('Location: index.php?action=view_bill&id=' . $data['bill_id'] . '&error=add_failed');
            }
            exit();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['bill_item_id'];
            $data = [
                'description' => $_POST['description'],
                'amount' => $_POST['amount']
            ];

            if ($this->billItemModel->updateBillItem($id, $data)) {
                header('Location: index.php?action=view_bill&id=' . $_POST['bill_id'] . '&success=item_updated');
            } else {
                header('Location: index.php?action=view_bill&id=' . $_POST['bill_id'] . '&error=update_failed');
            }
            exit();
        }
    }

    public function delete() {
        if (isset($_GET['id']) && isset($_GET['bill_id'])) {
            if ($this->billItemModel->deleteBillItem($_GET['id'])) {
                header('Location: index.php?action=view_bill&id=' . $_GET['bill_id'] . '&success=item_deleted');
            } else {
                header('Location: index.php?action=view_bill&id=' . $_GET['bill_id'] . '&error=delete_failed');
            }
            exit();
        }
    }
} 