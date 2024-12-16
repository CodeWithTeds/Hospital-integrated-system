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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Bills Management</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Bills</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBillModal">
                                <i data-feather="plus" class="feather-icon"></i> Create New Bill
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <!-- Filter Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="index.php" method="GET" class="form-inline">
                                    <input type="hidden" name="action" value="bills">
                                    <select name="status" class="form-control mr-2">
                                        <option value="">All Status</option>
                                        <option value="unpaid">Unpaid</option>
                                        <option value="paid">Paid</option>
                                        <option value="overdue">Overdue</option>
                                    </select>
                                    <button type="submit" class="btn btn-info">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Bill ID</th>
                                                <th>Patient Name</th>
                                                <th>Appointment Date</th>
                                                <th>Total Amount</th>
                                                <th>Status</th>
                                                <th>Date Issued</th>
                                                <th>Due Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($bills as $bill): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($bill['bill_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($bill['first_name'] . ' ' . $bill['last_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($bill['appointment_date']); ?></td>
                                                    <td>$<?php echo htmlspecialchars(number_format($bill['total_amount'], 2)); ?></td>
                                                    <td>
                                                        <span class="badge badge-<?php
                                                                                    echo $bill['status'] === 'paid' ? 'success' : ($bill['status'] === 'unpaid' ? 'warning' : 'danger');
                                                                                    ?>">
                                                            <?php echo ucfirst(htmlspecialchars($bill['status'])); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($bill['date_issued']); ?></td>
                                                    <td><?php echo htmlspecialchars($bill['payment_due_date']); ?></td>
                                                    <td>
                                                        <!-- Status Update Icon -->
                                                        <a href="#" 
                                                           data-toggle="modal" 
                                                           data-target="#updateStatusModal" 
                                                           data-bill-id="<?php echo $bill['bill_id']; ?>"
                                                           class="text-info mr-2">
                                                            <i data-feather="refresh-cw" class="feather-icon"></i>
                                                        </a>

                                                        <!-- Edit Icon -->
                                                        <a href="index.php?action=edit_bill&id=<?php echo $bill['bill_id']; ?>" 
                                                           class="text-primary mr-2">
                                                            <i data-feather="edit" class="feather-icon"></i>
                                                        </a>

                                                        <!-- Delete Icon -->
                                                        <a href="index.php?action=delete_bill&id=<?php echo $bill['bill_id']; ?>" 
                                                           class="text-danger"
                                                           onclick="return confirm('Are you sure you want to delete this bill?');">
                                                            <i data-feather="trash-2" class="feather-icon"></i>
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

    <!-- Create Bill Modal -->
    <div class="modal fade" id="createBillModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Bill</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="index.php?action=store_bill" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Patient</label>
                            <select name="patient_id" class="form-control" required>
                                <?php foreach ($patients as $patient): ?>
                                    <option value="<?php echo $patient['patient_id']; ?>">
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
                                    <option value="<?php echo $appointment['appointment_id']; ?>">
                                        <?php echo htmlspecialchars($appointment['appointment_date'] . ' - ' . $appointment['appointment_time']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Total Amount</label>
                            <input type="number" step="0.01" name="total_amount" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Payment Due Date</label>
                            <input type="date" name="payment_due_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Bill</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Bill Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="index.php?action=update_bill_status" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="bill_id" id="statusBillId">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="unpaid">Unpaid</option>
                                <option value="paid">Paid</option>
                                <option value="overdue">Overdue</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../footer.php'; ?>

    <script>
        $('#updateStatusModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var billId = button.data('bill-id');
            var modal = $(this);
            modal.find('#statusBillId').val(billId);
        });
    </script>
</body>

</html>