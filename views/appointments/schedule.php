<?php
use Hospital\Management\Helpers\AppointmentHelper;
?>
<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <?php include '../views/header.php'; ?>
        <?php include '../views/sidebar.php'; ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">
                            <?php echo htmlspecialchars($doctor['name'] ?? ''); ?>'s Schedule
                        </h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item"><a href="index.php?action=appointments" class="text-muted">Appointments</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Schedule</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <select class="form-control custom-select" id="doctor-select" onchange="changeDoctor(this.value)">
                                <?php foreach ($doctors as $doc): ?>
                                    <option value="<?php echo $doc['doctor_id']; ?>" 
                                            <?php echo ($doc['doctor_id'] == $doctorId) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($doc['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="date" class="form-control ml-2" id="schedule-date" 
                                   value="<?php echo htmlspecialchars($date); ?>" 
                                   onchange="changeDate(this.value)">
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
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Time</th>
                                                <th>Patient</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($appointments as $appointment): ?>
                                                <tr>
                                                    <td><?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?></td>
                                                    <td><?php echo htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($appointment['reason_for_visit']); ?></td>
                                                    <td>
                                                        <span class="badge badge-<?php echo AppointmentHelper::getStatusBadgeClass($appointment['status']); ?>">
                                                            <?php echo htmlspecialchars(ucfirst($appointment['status'])); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="index.php?action=edit_appointment&id=<?php echo $appointment['appointment_id']; ?>" 
                                                           class="btn btn-info btn-sm">Edit</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (empty($appointments)): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No appointments scheduled for this date</td>
                                                </tr>
                                            <?php endif; ?>
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

    <script>
    function changeDate(date) {
        window.location.href = `index.php?action=view_schedule&doctor_id=${document.getElementById('doctor-select').value}&date=${date}`;
    }

    function changeDoctor(doctorId) {
        window.location.href = `index.php?action=view_schedule&doctor_id=${doctorId}&date=${document.getElementById('schedule-date').value}`;
    }
    </script>

<?php include '../views/footer.php'; ?>