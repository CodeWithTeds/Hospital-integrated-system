<?php
namespace Hospital\Management\Controllers;

use Hospital\Management\Models\Prescription;
use Hospital\Management\Models\Doctor;
use Hospital\Management\Models\Patient;

class PrescriptionController {
    private $prescriptionModel;
    private $doctorModel;
    private $patientModel;

    public function __construct() {
        $this->prescriptionModel = new Prescription();
        $this->doctorModel = new Doctor();
        $this->patientModel = new Patient();
    }

    public function index() {
        $prescriptions = $this->prescriptionModel->getAllPrescriptions();
        require_once __DIR__ . '/../../views/prescriptions/index.php';
    }

    public function create() {
        $doctors = $this->doctorModel->getAllDoctors();
        $patients = $this->patientModel->getAllPatients();
        require_once __DIR__ . '/../../views/prescriptions/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'patient_id' => $_POST['patient_id'],
                'doctor_id' => $_POST['doctor_id'],
                'prescription_date' => $_POST['prescription_date'],
                'medications' => $_POST['medications'],
                'dosage' => $_POST['dosage'],
                'frequency' => $_POST['frequency'],
                'duration' => $_POST['duration'],
                'notes' => $_POST['notes'] ?? ''
            ];

            if ($this->prescriptionModel->createPrescription($data)) {
                header('Location: index.php?action=prescriptions&success=created');
            } else {
                header('Location: index.php?action=create_prescription&error=create_failed');
            }
            exit();
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=prescriptions&error=invalid_id');
            exit();
        }

        $prescription = $this->prescriptionModel->getPrescription($id);
        $doctors = $this->doctorModel->getAllDoctors();
        $patients = $this->patientModel->getAllPatients();

        if (!$prescription) {
            header('Location: index.php?action=prescriptions&error=not_found');
            exit();
        }

        require_once __DIR__ . '/../../views/prescriptions/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['prescription_id'] ?? null;
            if (!$id) {
                header('Location: index.php?action=prescriptions&error=invalid_id');
                exit();
            }

            $data = [
                'patient_id' => $_POST['patient_id'],
                'doctor_id' => $_POST['doctor_id'],
                'prescription_date' => $_POST['prescription_date'],
                'medications' => $_POST['medications'],
                'dosage' => $_POST['dosage'],
                'frequency' => $_POST['frequency'],
                'duration' => $_POST['duration'],
                'notes' => $_POST['notes'] ?? '',
                'status' => $_POST['status']
            ];

            if ($this->prescriptionModel->updatePrescription($id, $data)) {
                header('Location: index.php?action=prescriptions&success=updated');
            } else {
                header('Location: index.php?action=edit_prescription&id=' . $id . '&error=update_failed');
            }
            exit();
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=prescriptions&error=invalid_id');
            exit();
        }

        if ($this->prescriptionModel->deletePrescription($id)) {
            header('Location: index.php?action=prescriptions&success=deleted');
        } else {
            header('Location: index.php?action=prescriptions&error=delete_failed');
        }
        exit();
    }
} 