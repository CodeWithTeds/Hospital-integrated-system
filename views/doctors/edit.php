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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Edit Doctor</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item"><a href="index.php?action=doctors" class="text-muted">Doctors</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Edit Doctor</li>
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
                                <form action="index.php?action=update_doctor" method="POST">
                                    <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($doctor['doctor_id']); ?>">
                                    
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="specialization">Specialization</label>
                                        <input type="text" class="form-control" id="specialization" name="specialization" 
                                               value="<?php echo htmlspecialchars($doctor['specialization']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="contact_number">Contact Number</label>
                                        <input type="tel" class="form-control" id="contact_number" name="contact_number" 
                                               value="<?php echo htmlspecialchars($doctor['contact_number']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="schedule_start">Schedule Start</label>
                                        <input type="time" class="form-control" id="schedule_start" name="schedule_start" 
                                               value="<?php echo htmlspecialchars($doctor['schedule_start']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="schedule_end">Schedule End</label>
                                        <input type="time" class="form-control" id="schedule_end" name="schedule_end" 
                                               value="<?php echo htmlspecialchars($doctor['schedule_end']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <a href="index.php?action=doctors" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update Doctor</button>
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