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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Prescriptions</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Prescriptions</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <a href="index.php?action=create_prescription" class="btn btn-primary">
                                <i data-feather="plus" class="feather-icon"></i> Add Prescription
                            </a>
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
                                                <th>Date</th>
                                                <th>Patient</th>
                                                <th>Doctor</th>
                                                <th>Medications</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($prescriptions as $prescription): ?>
                                            <tr>
                                                <td><?php echo date('M d, Y', strtotime($prescription['prescription_date'])); ?></td>
                                                <td><?php echo htmlspecialchars($prescription['first_name'] . ' ' . $prescription['last_name']); ?></td>
                                                <td><?php echo htmlspecialchars($prescription['doctor_name']); ?></td>
                                                <td><?php echo htmlspecialchars($prescription['medications']); ?></td>
                                                <td>
                                                    <span class="badge badge-<?php echo $prescription['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                                        <?php echo ucfirst(htmlspecialchars($prescription['status'])); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="index.php?action=edit_prescription&id=<?php echo $prescription['prescription_id']; ?>" 
                                                       class="btn btn-info btn-sm">Edit</a>
                                                    <a href="index.php?action=delete_prescription&id=<?php echo $prescription['prescription_id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Are you sure you want to delete this prescription?')">
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

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html> 