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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Overdue Bills</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Overdue Bills</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <!-- Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Bill #</th>
                                                <th>Patient</th>
                                                <th>Amount</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($bills)): ?>
                                                <?php foreach ($bills as $bill): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($bill['bill_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($bill['patient_name']); ?></td>
                                                    <td class="text-right">₱<?php echo number_format($bill['total_amount'], 2); ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($bill['payment_due_date'])); ?></td>
                                                    <td>
                                                        <span class="badge badge-danger">Overdue</span>
                                                    </td>
                                                    <td>
                                                        <a href="#" 
                                                           data-toggle="modal" 
                                                           data-target="#updateStatusModal" 
                                                           data-bill-id="<?php echo $bill['bill_id']; ?>"
                                                           class="text-info mr-2">
                                                            <i data-feather="refresh-cw" class="feather-icon"></i>
                                                        </a>
                                                        <a href="index.php?action=view_bill&id=<?php echo $bill['bill_id']; ?>" 
                                                           class="text-primary mr-2">
                                                            <i data-feather="eye" class="feather-icon"></i>
                                                        </a>
                                                        <a href="index.php?action=edit_bill&id=<?php echo $bill['bill_id']; ?>" 
                                                           class="text-success">
                                                            <i data-feather="edit-2" class="feather-icon"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No overdue bills found</td>
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

    <!-- Status Update Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
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
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                                <option value="overdue" selected>Overdue</option>
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
        $(document).ready(function() {
            $('#updateStatusModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var billId = button.data('bill-id');
                var modal = $(this);
                modal.find('#statusBillId').val(billId);
            });
        });
    </script>
</body>
</html> 