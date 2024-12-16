<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
use Hospital\Management\Controllers\PrescriptionController;
use Hospital\Management\Controllers\PatientController;
use Hospital\Management\Controllers\AppointmentController;
use Hospital\Management\Controllers\DoctorController;
use Hospital\Management\Controllers\SupplierController;
use Hospital\Management\Controllers\InventoryController;
use Hospital\Management\Controllers\TransactionController;
use Hospital\Management\Controllers\BillController;
use Hospital\Management\Controllers\BillItemController;


$prescriptionController = new PrescriptionController();
$patientController = new PatientController();
$appointmentController = new AppointmentController();
$doctorController = new DoctorController();
$supplierController = new SupplierController();
$inventoryController = new InventoryController();
$transactionController = new TransactionController();
$billController = new BillController();
$billItemController = new BillItemController();
// Route handling
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patientController->store();
        }
        break;

    case 'edit':
        if (isset($_GET['id'])) {
            $patientController->edit();
        }
        break;
    case 'delete':
        if (isset($_GET['id'])) {
            $patientController->delete();
        }

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $patientController->update();
        }

    case 'appointments':
        $appointmentController->index();
        break;

    case 'create_appointment':
        $appointmentController->create();
        break;

    case 'store_appointment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentController->store();
        }
        break;

    case 'edit_appointment':
        if (isset($_GET['id'])) {
            $appointmentController->edit();
        }
        break;

    case 'update_appointment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentController->update();
        }
        break;

    case 'delete_appointment':
        if (isset($_GET['id'])) {
            $appointmentController->delete();
        }
        break;

    case 'view_schedule':
        if (isset($_GET['doctor_id'])) {
            $appointmentController->viewSchedule();
        }
        break;

    case 'doctors':
        $doctorController->index();
        break;


    case 'store_doctor':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $doctorController->store();
        }
        break;

    case 'edit_doctor':
        if (isset($_GET['id'])) {
            $doctorController->edit();
        }
        break;

    case 'update_doctor':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $doctorController->update();
        }
        break;

    case 'delete_doctor':
        if (isset($_GET['id'])) {
            $doctorController->delete();
        }
        break;

    case 'suppliers':
        $supplierController->index();
        break;

    case 'store_supplier':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplierController->store();
        }
        break;

    case 'edit_supplier':
        if (isset($_GET['id'])) {
            $supplierController->edit();
        }
        break;

    case 'update_supplier':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $supplierController->update();
        }
        break;

    case 'delete_supplier':
        if (isset($_GET['id'])) {
            $supplierController->delete();
        }
        break;

    case 'toggle_supplier_status':
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $supplierController->toggleStatus();
        }
        break;

    case 'filter_suppliers':
        if (isset($_GET['type'])) {
            $supplierController->filterByType();
        }
        break;

    case 'inventory':
        $inventoryController->index();
        break;

    case 'store_inventory':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inventoryController->store();
        }
        break;

    case 'edit_inventory':
        if (isset($_GET['id'])) {
            $inventoryController->edit();
        }
        break;

    case 'update_inventory':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inventoryController->update();
        }
        break;

    case 'delete_inventory':
        if (isset($_GET['id'])) {
            $inventoryController->delete();
        }
        break;

    case 'filter_inventory':
        if (isset($_GET['category'])) {
            $inventoryController->filterByCategory();
        }
        break;

    case 'check_low_stock':
        $inventoryController->checkLowStock();
        break;

    case 'adjust_stock':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inventoryController->adjustStock();
        }
        break;

    case 'transactions':
        $transactionController->index();
        break;

    case 'add_transaction':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $transactionController->addTransaction();
        }
        break;

    case 'edit_transaction':
        $transactionController->edit();
        break;

    case 'update_transaction':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $transactionController->update();
        }
        break;

    case 'filter_transactions':
        $transactionController->filterTransactions();
        break;

    case 'item_transactions':
        $transactionController->getTransactionsByItem();
        break;

    case 'bills':
        $billController->index();
        break;

    case 'create_bill':
        $billController->create();
        break;

    case 'store_bill':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $billController->store();
        }
        break;

    case 'edit_bill':
        if (isset($_GET['id'])) {
            $billController->edit();
        }
        break;

    case 'update_bill':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $billController->update();
        }
        break;

    case 'delete_bill':
        if (isset($_GET['id'])) {
            $billController->delete();
        }
        break;

    case 'update_bill_status':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $billController->updateStatus();
        }
        break;

    case 'unpaid_bills':
        $billController->viewUnpaid();
        break;

    case 'overdue_bills':
        $billController->viewOverdue();
        break;

    case 'view_bill':
        if (isset($_GET['id'])) {
            $billItemController->index($_GET['id']);
        }
        break;

    case 'add_bill_item':
        $billItemController->store();
        break;

    case 'update_bill_item':
        $billItemController->update();
        break;

    case 'delete_bill_item':
        $billItemController->delete();
        break;

        case 'prescriptions':
            $prescriptionController->index();
            break;
    
        case 'create_prescription':
            $prescriptionController->create();
            break;
    
        case 'store_prescription':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $prescriptionController->store();
            }
            break;
    
        case 'edit_prescription':
            if (isset($_GET['id'])) {
                $prescriptionController->edit();
            }
            break;
    
        case 'update_prescription':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $prescriptionController->update();
            }
            break;
    
        case 'delete_prescription':
            if (isset($_GET['id'])) {
                $prescriptionController->delete();
            }
            break;

    default:
        $patientController->index();
        break;
}
