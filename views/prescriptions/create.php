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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Create Prescription</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item"><a href="index.php?action=prescriptions" class="text-muted">Prescriptions</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Create</li>
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
                                <form action="index.php?action=store_prescription" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="patient_id">Patient</label>
                                                <select class="form-control" id="patient_id" name="patient_id" required>
                                                    <option value="">Select Patient</option>
                                                    <?php foreach ($patients as $patient): ?>
                                                        <option value="<?php echo $patient['patient_id']; ?>">
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
                                                    <option value="">Select Doctor</option>
                                                    <?php foreach ($doctors as $doctor): ?>
                                                        <option value="<?php echo $doctor['doctor_id']; ?>">
                                                            <?php echo htmlspecialchars($doctor['name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="prescription_date">Prescription Date</label>
                                                <input type="date" class="form-control" id="prescription_date" 
                                                       name="prescription_date" required value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="medications">Medications</label>
                                        <textarea class="form-control" id="medications" name="medications" 
                                                  rows="3" required placeholder="Enter medications..."></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dosage">Dosage</label>
                                                <input type="text" class="form-control" id="dosage" 
                                                       name="dosage" required placeholder="e.g., 500mg">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="frequency">Frequency</label>
                                                <input type="text" class="form-control" id="frequency" 
                                                       name="frequency" required placeholder="e.g., Twice daily">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="duration">Duration</label>
                                                <input type="text" class="form-control" id="duration" 
                                                       name="duration" required placeholder="e.g., 7 days">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="notes" name="notes" 
                                                  rows="3" placeholder="Additional notes..."></textarea>
                                    </div>

                                    <div class="form-actions">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-info">Create Prescription</button>
                                            <a href="index.php?action=prescriptions" class="btn btn-dark">Cancel</a>
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

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html> 