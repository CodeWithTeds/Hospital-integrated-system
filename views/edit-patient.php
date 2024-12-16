<?php include 'views/head.php'; ?>
<script src="src/Validators/PatientValidation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <?php include 'views/header.php'; ?>
        <?php include 'views/sidebar.php'; ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Edit Patient</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Edit Patient</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="index.php?action=update" method="POST">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($patient['patient_id']); ?>">
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                                    value="<?php echo htmlspecialchars($patient['first_name']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                                    value="<?php echo htmlspecialchars($patient['last_name']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="middle_name">Middle Name</label>
                                                <input type="text" class="form-control" id="middle_name" name="middle_name" 
                                                    value="<?php echo htmlspecialchars($patient['middle_name']); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_of_birth">Date of Birth</label>
                                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                                                    value="<?php echo htmlspecialchars($patient['date_of_birth']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select class="form-control" id="gender" name="gender" required>
                                                    <option value="Male" <?php echo $patient['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                                    <option value="Female" <?php echo $patient['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                                    <option value="Other" <?php echo $patient['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="contact_number">Contact Number</label>
                                                <input type="tel" class="form-control" id="contact_number" name="contact_number" 
                                                    value="<?php echo htmlspecialchars($patient['contact_number']); ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" 
                                                    value="<?php echo htmlspecialchars($patient['email']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" 
                                                    value="<?php echo htmlspecialchars($patient['address']); ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="medical_history">Medical History</label>
                                                <textarea class="form-control" id="medical_history" name="medical_history" 
                                                    rows="3"><?php echo htmlspecialchars($patient['medical_history']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="current_medications">Current Medications</label>
                                                <textarea class="form-control" id="current_medications" name="current_medications" 
                                                    rows="3"><?php echo htmlspecialchars($patient['current_medications']); ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="emergency_contact_name">Emergency Contact Name</label>
                                                <input type="text" class="form-control" id="emergency_contact_name" 
                                                    name="emergency_contact_name" 
                                                    value="<?php echo htmlspecialchars($patient['emergency_contact_name']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="emergency_contact_number">Emergency Contact Number</label>
                                                <input type="tel" class="form-control" id="emergency_contact_number" 
                                                    name="emergency_contact_number" 
                                                    value="<?php echo htmlspecialchars($patient['emergency_contact_number']); ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-info">Update Patient</button>
                                            <a href="index.php" class="btn btn-dark">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
.validation-feedback {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
.valid-feedback { color: #198754; }
.invalid-feedback { color: #dc3545; }
.is-valid { border-color: #198754 !important; }
.is-invalid { border-color: #dc3545 !important; }
</style>
<?php include 'views/footer.php'; ?> 