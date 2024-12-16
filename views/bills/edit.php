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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Edit Bill</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item"><a href="index.php?action=bills" class="text-muted">Bills</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Edit Bill</li>
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
                                <form action="index.php?action=update_bill" method="POST">
                                    <input type="hidden" name="bill_id" value="<?php echo htmlspecialchars($bill['bill_id']); ?>">
                                    
                                    <div class="form-group">
                                        <label>Patient</label>
                                        <select name="patient_id" class="form-control" required>
                                            <?php foreach ($patients as $patient): ?>
                                                <option value="<?php echo $patient['patient_id']; ?>" 
                                                    <?php echo ($patient['patient_id'] == $bill['patient_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Appointment</label>
                                        <select name="appointment_id" class="form-control">
                                            <option value="">No Appointment</option>
                                            <?php foreach ($appointments as $appointment): ?>
                                                <option value="<?php echo $appointment['appointment_id']; ?>"
                                                    <?php echo ($appointment['appointment_id'] == $bill['appointment_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($appointment['appointment_date'] . ' - ' . $appointment['appointment_time']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Total Amount</label>
                                        <input type="number" step="0.01" name="total_amount" class="form-control" 
                                            value="<?php echo htmlspecialchars($bill['total_amount']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="unpaid" <?php echo ($bill['status'] == 'unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                                            <option value="paid" <?php echo ($bill['status'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
                                            <option value="overdue" <?php echo ($bill['status'] == 'overdue') ? 'selected' : ''; ?>>Overdue</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Payment Due Date</label>
                                        <input type="date" name="payment_due_date" class="form-control" 
                                            value="<?php echo htmlspecialchars($bill['payment_due_date']); ?>" required>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success">Update Bill</button>
                                        <a href="index.php?action=bills" class="btn btn-secondary">Cancel</a>
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