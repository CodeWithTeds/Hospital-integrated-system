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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Edit Transaction</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item"><a href="index.php?action=transactions" class="text-muted">Transactions</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <a href="index.php?action=transactions" class="btn btn-primary">
                                <i data-feather="arrow-left" class="feather-icon"></i> Back to Transactions
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
                                <form action="index.php?action=update_transaction" method="POST">
                                    <input type="hidden" name="transaction_id" value="<?php echo $transaction['transaction_id']; ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="inventory_id">Item</label>
                                                <select class="form-control" id="inventory_id" name="inventory_id" required>
                                                    <option value="">Select Item</option>
                                                    <?php foreach ($inventory_items as $item): ?>
                                                        <option value="<?php echo $item['inventory_id']; ?>" <?php echo $item['inventory_id'] == $transaction['inventory_id'] ? 'selected' : ''; ?>>
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
                                                    <option value="stock-in" <?php echo $transaction['transaction_type'] == 'stock-in' ? 'selected' : ''; ?>>Stock In</option>
                                                    <option value="stock-out" <?php echo $transaction['transaction_type'] == 'stock-out' ? 'selected' : ''; ?>>Stock Out</option>
                                                    <option value="adjustment" <?php echo $transaction['transaction_type'] == 'adjustment' ? 'selected' : ''; ?>>Adjustment</option>
                                                    <option value="return" <?php echo $transaction['transaction_type'] == 'return' ? 'selected' : ''; ?>>Return</option>
                                                    <option value="damaged" <?php echo $transaction['transaction_type'] == 'damaged' ? 'selected' : ''; ?>>Damaged</option>
                                                    <option value="expired" <?php echo $transaction['transaction_type'] == 'expired' ? 'selected' : ''; ?>>Expired</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" required min="1" value="<?php echo $transaction['quantity']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="unit_price">Unit Price</label>
                                                <input type="number" step="0.01" class="form-control" id="unit_price" name="unit_price" value="<?php echo $transaction['unit_price']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="reference_number">Reference Number</label>
                                                <input type="text" class="form-control" id="reference_number" name="reference_number" value="<?php echo $transaction['reference_number']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="supplier_id">Supplier</label>
                                                <select class="form-control" id="supplier_id" name="supplier_id">
                                                    <option value="">Select Supplier</option>
                                                    <?php foreach ($suppliers as $supplier): ?>
                                                        <option value="<?php echo $supplier['supplier_id']; ?>" <?php echo $supplier['supplier_id'] == $transaction['supplier_id'] ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($supplier['name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo htmlspecialchars($transaction['notes']); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Update Transaction</button>
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