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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Inventory Transactions</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Transactions</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTransactionModal">
                                <i data-feather="plus" class="feather-icon"></i> Add Transaction
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <!-- Filters -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="index.php" method="GET" class="form-inline">
                                    <input type="hidden" name="action" value="filter_transactions">
                                    <div class="form-group mx-sm-3">
                                        <label for="start_date" class="mr-2">From:</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date">
                                    </div>
                                    <div class="form-group mx-sm-3">
                                        <label for="end_date" class="mr-2">To:</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date">
                                    </div>
                                    <button type="submit" class="btn btn-info">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Item</th>
                                                <th>Type</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                                <th>Reference</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($transactions as $transaction): ?>
                                            <tr>
                                                <td><?php echo date('M d, Y', strtotime($transaction['created_at'])); ?></td>
                                                <td><?php echo htmlspecialchars($transaction['item_name']); ?></td>
                                                <td>
                                                    <span class="badge badge-<?php 
                                                        echo $transaction['transaction_type'] === 'stock-in' ? 'success' : 
                                                            ($transaction['transaction_type'] === 'stock-out' ? 'warning' : 
                                                            ($transaction['transaction_type'] === 'damaged' ? 'danger' : 
                                                            ($transaction['transaction_type'] === 'return' ? 'info' : 'secondary'))); ?>">
                                                        <?php echo ucfirst(htmlspecialchars($transaction['transaction_type'])); ?>
                                                    </span>
                                                </td>
                                                <td class="text-right"><?php echo number_format($transaction['quantity']); ?></td>
                                                <td class="text-right">₱<?php echo number_format($transaction['unit_price'], 2); ?></td>
                                                <td class="text-right">₱<?php echo number_format($transaction['total_amount'], 2); ?></td>
                                                <td><?php echo htmlspecialchars($transaction['reference_number']); ?></td>
                                                <td>
                                                    <a href="#" 
                                                       data-toggle="tooltip" 
                                                       data-placement="top" 
                                                       title="View Details"
                                                       class="text-info mr-2"
                                                       onclick="viewDetails(<?php echo htmlspecialchars(json_encode($transaction)); ?>)">
                                                        <i data-feather="eye" class="feather-icon"></i>
                                                    </a>
                                                    <a href="index.php?action=edit_transaction&id=<?php echo $transaction['transaction_id']; ?>" 
                                                       class="text-primary"
                                                       data-toggle="tooltip" 
                                                       data-placement="top" 
                                                       title="Edit Transaction">
                                                        <i data-feather="edit-2" class="feather-icon"></i>
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

    <!-- Add Transaction Modal -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="index.php?action=add_transaction" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inventory_id">Item</label>
                                    <select class="form-control" id="inventory_id" name="inventory_id" required>
                                        <option value="">Select Item</option>
                                        <?php foreach ($inventory_items as $item): ?>
                                            <option value="<?php echo $item['inventory_id']; ?>">
                                                <?php echo htmlspecialchars($item['item_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_type">Transaction Type</label>
                                    <select class="form-control" id="transaction_type" name="transaction_type" required>
                                        <option value="stock-in">Stock In</option>
                                        <option value="stock-out">Stock Out</option>
                                        <option value="adjustment">Adjustment</option>
                                        <option value="return">Return</option>
                                        <option value="damaged">Damaged</option>
                                        <option value="expired">Expired</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit_price">Unit Price</label>
                                    <input type="number" step="0.01" class="form-control" id="unit_price" name="unit_price">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reference_number">Reference Number</label>
                                    <input type="text" class="form-control" id="reference_number" name="reference_number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier</label>
                                    <select class="form-control" id="supplier_id" name="supplier_id">
                                        <option value="">Select Supplier</option>
                                        <?php foreach ($suppliers as $supplier): ?>
                                            <option value="<?php echo $supplier['supplier_id']; ?>">
                                                <?php echo htmlspecialchars($supplier['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Transaction</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transaction Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Supplier:</strong> <span id="modalSupplier"></span></p>
                            <p><strong>Performed By:</strong> <span id="modalPerformedBy"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date:</strong> <span id="modalDate"></span></p>
                            <p><strong>Reference:</strong> <span id="modalReference"></span></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Notes:</strong></p>
                            <p id="modalNotes" class="text-muted"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/../footer.php'; ?>

<script>
    $(document).ready(function() {
        // Initialize date inputs with current date range
        var today = new Date();
        var thirtyDaysAgo = new Date(today);
        thirtyDaysAgo.setDate(today.getDate() - 30);
        
        $('#start_date').val(thirtyDaysAgo.toISOString().split('T')[0]);
        $('#end_date').val(today.toISOString().split('T')[0]);
    });

    function viewDetails(transaction) {
        $('#modalSupplier').text(transaction.supplier_name);
        $('#modalPerformedBy').text(transaction.performed_by);
        $('#modalDate').text(new Date(transaction.created_at).toLocaleString());
        $('#modalReference').text(transaction.reference_number);
        $('#modalNotes').text(transaction.notes);
        $('#viewDetailsModal').modal('show');
    }
</script>
</body>
</html>