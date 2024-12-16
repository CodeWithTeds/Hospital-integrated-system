<?php

namespace Hospital\Management\Controllers;

use Hospital\Management\Models\Doctor;

class DoctorController {
    private $doctorModel;

    public function __construct() {
        $this->doctorModel = new Doctor();
    }

    public function index() {
        $doctors = $this->doctorModel->getAllDoctors();
        require_once __DIR__ . '/../../views/doctors/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'specialization' => $_POST['specialization'],
                'contact_number' => $_POST['contact_number'],
                'email' => $_POST['email'],
                'schedule_start' => $_POST['schedule_start'],
                'schedule_end' => $_POST['schedule_end']
            ];

            if ($this->doctorModel->addDoctor($data)) {
                header('Location: index.php?action=doctors&success=created');
            } else {
                header('Location: index.php?action=doctors&error=create_failed');
            }
            exit();
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=doctors&error=invalid_id');
            exit();
        }

        $doctor = $this->doctorModel->getDoctor($id);
        require_once __DIR__ . '/../../views/doctors/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['doctor_id'] ?? null;
            if (!$id) {
                header('Location: index.php?action=doctors&error=invalid_id');
                exit();
            }

            $data = [
                'name' => $_POST['name'],
                'specialization' => $_POST['specialization'],
                'contact_number' => $_POST['contact_number'],
                'email' => $_POST['email'],
                'schedule_start' => $_POST['schedule_start'],
                'schedule_end' => $_POST['schedule_end']
            ];

            if ($this->doctorModel->updateDoctor($id, $data)) {
                header('Location: index.php?action=doctors&success=updated');
            } else {
                header('Location: index.php?action=edit_doctor&id=' . $id . '&error=update_failed');
            }
            exit();
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=doctors&error=invalid_id');
            exit();
        }

        if ($this->doctorModel->deleteDoctor($id)) {
            header('Location: index.php?action=doctors&success=deleted');
        } else {
            header('Location: index.php?action=doctors&error=delete_failed');
        }
        exit();
    }
} 