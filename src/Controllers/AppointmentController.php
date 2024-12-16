<?php   
namespace Hospital\Management\Controllers;

use Hospital\Management\Models\Appointment;
use Hospital\Management\Models\Doctor;
use Hospital\Management\Models\Patient;

class AppointmentController {
    private $appointmentModel;
    private $doctorModel;
    private $patientModel;

    public function __construct() {
        $this->appointmentModel = new Appointment();
        $this->doctorModel = new Doctor();
        $this->patientModel = new Patient();
    }

    public function index() {
        $appointments = $this->appointmentModel->getAllAppointments();
        $doctors = $this->doctorModel->getAllDoctors();
        $patients = $this->patientModel->getAllPatients();
        require_once __DIR__ . '/../../views/appointments/index.php';
    }

    public function create() {
        try {
            $doctors = $this->doctorModel->getAllDoctors();
            $patients = $this->patientModel->getAllPatients();
            
            // Debug information
            if (empty($doctors)) {
                error_log("No doctors found in the database");
            }
            if (empty($patients)) {
                error_log("No patients found in the database");
            }
            
            require_once __DIR__ . '/../../views/appointments/create.php';
        } catch (\Exception $e) {
            error_log("Error in create appointment: " . $e->getMessage());
            header('Location: index.php?action=appointments&error=create_failed');
            exit();
        }
    }

    public function store() {
        // Validate the appointment data
        if (!isset($_POST['doctor_id']) || !isset($_POST['patient_id']) || 
            !isset($_POST['appointment_date']) || !isset($_POST['appointment_time'])) {
            header('Location: index.php?action=create_appointment&error=missing_fields');
            exit();
        }

        // Check if the time slot is available
        if (!$this->appointmentModel->checkAvailability(
            $_POST['doctor_id'],
            $_POST['appointment_date'],
            $_POST['appointment_time']
        )) {
            header('Location: index.php?action=create_appointment&error=time_unavailable');
            exit();
        }

        // Create the appointment
        $appointmentData = [
            'patient_id' => $_POST['patient_id'],
            'doctor_id' => $_POST['doctor_id'],
            'appointment_date' => $_POST['appointment_date'],
            'appointment_time' => $_POST['appointment_time'],
            'reason_for_visit' => $_POST['reason_for_visit'] ?? '',
            'status' => 'scheduled'
        ];

        if ($this->appointmentModel->createAppointment($appointmentData)) {
            header('Location: index.php?action=appointments&success=created');
        } else {
            header('Location: index.php?action=create_appointment&error=create_failed');
        }
        exit();
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=appointments&error=invalid_id');
            exit();
        }

        $appointment = $this->appointmentModel->getAppointment($id);
        $doctors = $this->doctorModel->getAllDoctors();
        $patients = $this->patientModel->getAllPatients();

        if (!$appointment) {
            header('Location: index.php?action=appointments&error=not_found');
            exit();
        }

        require_once __DIR__ . '/../../views/appointments/edit.php';
    }

    public function update() {
        $id = $_POST['appointment_id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=appointments&error=invalid_id');
            exit();
        }

        $appointmentData = [
            'patient_id' => $_POST['patient_id'],
            'doctor_id' => $_POST['doctor_id'],
            'appointment_date' => $_POST['appointment_date'],
            'appointment_time' => $_POST['appointment_time'],
            'reason_for_visit' => $_POST['reason_for_visit'] ?? '',
            'status' => $_POST['status']
        ];

        if ($this->appointmentModel->updateAppointment($id, $appointmentData)) {
            header('Location: index.php?action=appointments&success=updated');
        } else {
            header('Location: index.php?action=edit&id=' . $id . '&error=update_failed');
        }
        exit();
    }

    public function delete() {
        $id = $_GET['id'];
        
        if ($this->appointmentModel->deleteAppointment($id)) {
            header('Location: index.php?action=appointments&success=deleted');
        } else {
            header('Location: index.php?action=appointments&error=delete_failed');
        }
        exit();
    }

    public function viewSchedule() {
        $doctorId = $_GET['doctor_id'];
        $date = $_GET['date'] ?? date('Y-m-d');
        
        $doctor = $this->doctorModel->getDoctor($doctorId);
        $doctors = $this->doctorModel->getAllDoctors();
        $appointments = $this->appointmentModel->getDoctorAppointments($doctorId, $date);
        
        require_once __DIR__ . '/../../views/appointments/schedule.php';
    }
} 