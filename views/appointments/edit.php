<?php include __DIR__ . '/../head.php'; ?>
<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <?php include __DIR__ . '/../header.php'; ?>
        <?php include __DIR__ . '/../sidebar.php'; ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Edit Appointment</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item"><a href="index.php?action=appointments" class="text-muted">Appointments</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Edit</li>
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
                                <form action="index.php?action=update_appointment" method="POST" id="appointmentForm">
                                    <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['appointment_id']); ?>">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="patient_id">Patient</label>
                                                <select class="form-control" id="patient_id" name="patient_id" required>
                                                    <?php foreach ($patients as $patient): ?>
                                                        <option value="<?php echo $patient['patient_id']; ?>" 
                                                            <?php echo ($patient['patient_id'] == $appointment['patient_id']) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="doctor_id">Doctor</label>
                                                <select class="form-control" id="doctor_id" name="doctor_id" required>
                                                    <?php foreach ($doctors as $doctor): ?>
                                                        <option value="<?php echo $doctor['doctor_id']; ?>" 
                                                            <?php echo ($doctor['doctor_id'] == $appointment['doctor_id']) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($doctor['name'] . ' - ' . $doctor['specialization']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="appointment_date">Date</label>
                                                <input type="date" class="form-control" id="appointment_date" 
                                                       name="appointment_date" required 
                                                       value="<?php echo htmlspecialchars($appointment['appointment_date']); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="appointment_time">Time</label>
                                                <input type="time" class="form-control" id="appointment_time" 
                                                       name="appointment_time" required 
                                                       value="<?php echo htmlspecialchars($appointment['appointment_time']); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="reason_for_visit">Reason for Visit</label>
                                        <textarea class="form-control" id="reason_for_visit" name="reason_for_visit" 
                                                  rows="3" required><?php echo htmlspecialchars($appointment['reason_for_visit']); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="scheduled" <?php echo ($appointment['status'] == 'scheduled') ? 'selected' : ''; ?>>Scheduled</option>
                                            <option value="completed" <?php echo ($appointment['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                            <option value="cancelled" <?php echo ($appointment['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                            <option value="no_show" <?php echo ($appointment['status'] == 'no_show') ? 'selected' : ''; ?>>No Show</option>
                                        </select>
                                    </div>

                                    <div class="form-actions">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-info">Update Appointment</button>
                                            <a href="index.php?action=appointments" class="btn btn-dark">Cancel</a>
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

    <script>
    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        const doctor = document.getElementById('doctor_id').value;
        const date = document.getElementById('appointment_date').value;
        const time = document.getElementById('appointment_time').value;
        
        if (!doctor || !date || !time) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields'
            });
            return;
        }

        // Submit the form if validation passes
        this.submit();
    });
    </script>

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html>