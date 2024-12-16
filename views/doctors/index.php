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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Doctors</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Doctors</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createDoctorModal">
                                <i data-feather="plus" class="feather-icon"></i> Add Doctor
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
                                                <th>Name</th>
                                                <th>Specialization</th>
                                                <th>Contact Number</th>
                                                <th>Email</th>
                                                <th>Schedule</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($doctors as $doctor): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($doctor['name']); ?></td>
                                                <td><?php echo htmlspecialchars($doctor['specialization']); ?></td>
                                                <td><?php echo htmlspecialchars($doctor['contact_number']); ?></td>
                                                <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                                                <td>
                                                    <?php 
                                                    echo htmlspecialchars(date('h:i A', strtotime($doctor['schedule_start']))) . ' - ' . 
                                                         htmlspecialchars(date('h:i A', strtotime($doctor['schedule_end']))); 
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="index.php?action=edit_doctor&id=<?php echo $doctor['doctor_id']; ?>" 
                                                       class="btn btn-info btn-sm">Edit</a>
                                                    <a href="index.php?action=delete_doctor&id=<?php echo $doctor['doctor_id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Are you sure you want to delete this doctor?')">
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

    <!-- Add Doctor Modal -->
    <div class="modal fade" id="createDoctorModal" tabindex="-1" role="dialog" aria-labelledby="createDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDoctorModalLabel">Add New Doctor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="index.php?action=store_doctor" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <input type="text" class="form-control" id="specialization" name="specialization" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <input type="tel" class="form-control" id="contact_number" name="contact_number" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="schedule_start">Schedule Start</label>
                            <input type="time" class="form-control" id="schedule_start" name="schedule_start" required>
                        </div>
                        <div class="form-group">
                            <label for="schedule_end">Schedule End</label>
                            <input type="time" class="form-control" id="schedule_end" name="schedule_end" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html> 