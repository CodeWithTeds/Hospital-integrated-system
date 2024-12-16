<?php
namespace Hospital\Management\Controllers;

use Hospital\Management\Models\Patient;

class PatientController {
    private $patientModel;

    public function __construct() {
        $this->patientModel = new Patient();
    }

    public function index() {
        $patients = $this->patientModel->getAllPatients();
        require_once __DIR__ . '/../../views/patients.php';
    }

    public function store() {
        if ($this->patientModel->addPatient($_POST)) {
            header('Location: index.php?success=created');
        } else {
            header('Location: index.php?error=create_failed');
        }
        exit();
    }

    public function edit() {
        $id = $_GET['id'];
        $patient = $this->patientModel->getPatient($id);
        if (!$patient) {
            header('Location: index.php?error=patient_not_found');
            exit();
        }
        require_once __DIR__ . '/../../views/edit-patient.php';
    }
    public function update(){
        $id = $_POST['id'];
        if($this->patientModel->updatePatient($id, $_POST)){
            header('Location: index.php?success=updated');
        }else{
            header('Location: index.php?error=update_failed');
        }
    }
    public function delete(){
        $id = $_GET['id'];
        if($this->patientModel->deletePatient($id)){
            header('Location: index.php?success=deleted');
        }else{
            header('Location: index.php?error=delete_failed');
        }
        exit();
    }

   
}