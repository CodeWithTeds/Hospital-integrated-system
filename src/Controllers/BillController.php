<?php

namespace Hospital\Management\Controllers;

use Hospital\Management\Models\Bills;
use Hospital\Management\Models\Patient;
use Hospital\Management\Models\Appointment;

class BillController {
    private $billModel;
    private $patientModel;
    private $appointmentModel;

    public function __construct() {
        $this->billModel = new Bills();
        $this->patientModel = new Patient();
        $this->appointmentModel = new Appointment();
    }

    public function index() {
        $bills = $this->billModel->getAllBills();
        $patients = $this->patientModel->getAllPatients();
        $appointments = $this->appointmentModel->getAllAppointments();
        require_once __DIR__ . '/../../views/bills/index.php';
    }

    public function create() {
        $patients = $this->patientModel->getAllPatients();
        $appointments = $this->appointmentModel->getAllAppointments();
        require_once __DIR__ . '/../../views/bills/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'appointment_id' => $_POST['appointment_id'],
                'patient_id' => $_POST['patient_id'],
                'total_amount' => $_POST['total_amount'],
                'payment_due_date' => $_POST['payment_due_date']
            ];

            if ($this->billModel->createBill($data)) {
                header('Location: index.php?action=bills&success=created');
            } else {
                header('Location: index.php?action=create_bill&error=create_failed');
            }
            exit();
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=bills&error=invalid_id');
            exit();
        }

        $bill = $this->billModel->getBill($id);
        $patients = $this->patientModel->getAllPatients();
        $appointments = $this->appointmentModel->getAllAppointments();
        require_once __DIR__ . '/../../views/bills/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['bill_id'] ?? null;
            if ($id) {
                $data = [
                    'appointment_id' => $_POST['appointment_id'],
                    'patient_id' => $_POST['patient_id'],
                    'total_amount' => $_POST['total_amount'],
                    'status' => $_POST['status'],
                    'payment_due_date' => $_POST['payment_due_date']
                ];

                if ($this->billModel->updateBill($id, $data)) {
                    header('Location: index.php?action=bills&success=updated');
                } else {
                    header('Location: index.php?action=edit_bill&id=' . $id . '&error=update_failed');
                }
                exit();
            }
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=bills&error=invalid_id');
            exit();
        }

        if ($this->billModel->deleteBill($id)) {
            header('Location: index.php?action=bills&success=deleted');
        } else {
            header('Location: index.php?action=bills&error=delete_failed');
        }
        exit();
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $billId = $_POST['bill_id'] ?? null;
            $status = $_POST['status'] ?? null;
    
            if (!$billId || !$status) {
                header('Location: index.php?action=bills&error=invalid_input');
                exit();
            }
    
            if ($this->billModel->updateBillStatus($billId, $status)) {
                header('Location: index.php?action=bills&success=status_updated');
            } else {
                header('Location: index.php?action=bills&error=update_failed');
            }
            exit();
        }
    }

    public function viewUnpaid() {
        $bills = $this->billModel->getBillsByStatus('unpaid');
        if (!$bills) {
            $bills = []; // Initialize as empty array if no results
        }
        require_once __DIR__ . '/../../views/bills/unpaid.php';
    }

    public function viewOverdue() {
        $bills = $this->billModel->getBillsByStatus('overdue');
        if (!$bills) {
            $bills = []; // Initialize as empty array if no results
        }
        require_once __DIR__ . '/../../views/bills/overdue.php';
    }
}