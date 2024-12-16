<?php include 'views/head.php'; ?>

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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Archived Patients</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Archived Patients</li>
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
                                <h4 class="card-title">Archived Patient List</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Date of Birth</th>
                                                <th>Gender</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Archived Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($archivedPatients) && !empty($archivedPatients)): ?>
                                                <?php foreach ($archivedPatients as $patient): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($patient['date_of_birth']); ?></td>
                                                        <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                                                        <td><?php echo htmlspecialchars($patient['contact_number']); ?></td>
                                                        <td><?php echo htmlspecialchars($patient['email']); ?></td>
                                                        <td><?php echo htmlspecialchars($patient['archived_at']); ?></td>
                                                        <td>
                                                            <form action="index.php?action=restore_patient" method="POST" style="display: inline;">
                                                                <input type="hidden" name="patient_id" value="<?php echo $patient['id']; ?>">
                                                                <button type="submit" class="btn btn-success btn-sm" 
                                                                        onclick="return confirm('Are you sure you want to restore this patient?')">
                                                                    Restore
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No archived patients found</td>
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

<?php include 'views/footer.php'; ?> 