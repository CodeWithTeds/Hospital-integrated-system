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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Appointments</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Appointments</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAppointmentModal">
                                <i data-feather="plus" class="feather-icon"></i> Create Appointment
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Patient</th>
                                                <th>Doctor</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($appointments as $appointment): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']); ?></td>
                                                <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                                                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                                <td><?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?></td>
                                                <td>
                                                    <span class="badge badge-<?php echo $appointment['status'] === 'scheduled' ? 'primary' : 
                                                        ($appointment['status'] === 'completed' ? 'success' : 
                                                        ($appointment['status'] === 'cancelled' ? 'danger' : 'warning')); ?>">
                                                        <?php echo ucfirst(htmlspecialchars($appointment['status'])); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="index.php?action=edit_appointment&id=<?php echo $appointment['appointment_id']; ?>" 
                                                       class="btn btn-info btn-sm">Edit</a>
                                                    <a href="index.php?action=delete_appointment&id=<?php echo $appointment['appointment_id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Are you sure you want to delete this appointment?')">
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="createAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAppointmentModalLabel">Create New Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createAppointmentForm" action="index.php?action=store_appointment" method="POST">
                    <div class="modal-body">
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
                                    <label for="appointment_date">Date</label>
                                    <input type="date" class="form-control" id="appointment_date" 
                                           name="appointment_date" required min="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="appointment_time">Time</label>
                                    <input type="time" class="form-control" id="appointment_time" 
                                           name="appointment_time" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="reason_for_visit">Reason for Visit</label>
                                    <textarea class="form-control" id="reason_for_visit" 
                                              name="reason_for_visit" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add your existing JavaScript code here
    });
    </script>

<?php include __DIR__ . '/../footer.php'; ?> 