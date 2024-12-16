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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Suppliers</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Suppliers</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createSupplierModal">
                                <i data-feather="plus" class="feather-icon"></i> Add Supplier
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
                                    <input type="hidden" name="action" value="filter_suppliers">
                                    <select name="type" class="form-control mr-2">
                                        <option value="">All Types</option>
                                        <option value="Medical Equipment">Medical Equipment</option>
                                        <option value="Pharmaceuticals">Pharmaceuticals</option>
                                        <option value="Laboratory">Laboratory</option>
                                        <option value="General Supplies">General Supplies</option>
                                        <option value="Other">Other</option>
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
                                                <th>Name</th>
                                                <th>Contact Person</th>
                                                <th>Contact Number</th>
                                                <th>Type</th>
                                                <th>Rating</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($suppliers as $supplier): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($supplier['name']); ?></td>
                                                <td><?php echo htmlspecialchars($supplier['contact_person']); ?></td>
                                                <td><?php echo htmlspecialchars($supplier['contact_number']); ?></td>
                                                <td><?php echo htmlspecialchars($supplier['supplier_type']); ?></td>
                                                <td>
                                                    <?php 
                                                    for($i = 1; $i <= 5; $i++) {
                                                        echo $i <= $supplier['rating'] ? '★' : '☆';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php echo $supplier['is_active'] ? 'success' : 'danger'; ?>">
                                                        <?php echo $supplier['is_active'] ? 'Active' : 'Inactive'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="index.php?action=edit_supplier&id=<?php echo $supplier['supplier_id']; ?>" 
                                                       class="btn btn-info btn-sm">Edit</a>
                                                    <a href="index.php?action=toggle_supplier_status&id=<?php echo $supplier['supplier_id']; ?>&status=<?php echo $supplier['is_active'] ? '0' : '1'; ?>" 
                                                       class="btn btn-warning btn-sm">
                                                        <?php echo $supplier['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                                    </a>
                                                    <a href="index.php?action=delete_supplier&id=<?php echo $supplier['supplier_id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Are you sure you want to delete this supplier?')">
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

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="createSupplierModal" tabindex="-1" role="dialog" aria-labelledby="createSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSupplierModalLabel">Add New Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="index.php?action=store_supplier" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Company Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_person">Contact Person</label>
                                    <input type="text" class="form-control" id="contact_person" name="contact_person" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="tel" class="form-control" id="contact_number" name="contact_number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="url" class="form-control" id="website" name="website">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tax_id">Tax ID</label>
                                    <input type="text" class="form-control" id="tax_id" name="tax_id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier_type">Supplier Type</label>
                                    <select class="form-control" id="supplier_type" name="supplier_type" required>
                                        <option value="Medical Equipment">Medical Equipment</option>
                                        <option value="Pharmaceuticals">Pharmaceuticals</option>
                                        <option value="Laboratory">Laboratory</option>
                                        <option value="General Supplies">General Supplies</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rating">Rating</label>
                                    <select class="form-control" id="rating" name="rating" required>
                                        <option value="1">1 - Poor</option>
                                        <option value="2">2 - Fair</option>
                                        <option value="3">3 - Good</option>
                                        <option value="4">4 - Very Good</option>
                                        <option value="5">5 - Excellent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_terms">Payment Terms</label>
                                    <input type="text" class="form-control" id="payment_terms" name="payment_terms">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="credit_limit">Credit Limit</label>
                                    <input type="number" step="0.01" class="form-control" id="credit_limit" name="credit_limit">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html>