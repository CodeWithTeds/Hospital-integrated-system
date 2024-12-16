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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Inventory Management</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Inventory</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createItemModal">
                                <i data-feather="plus" class="feather-icon"></i> Add Item
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
                                    <input type="hidden" name="action" value="filter_inventory">
                                    <select name="category" class="form-control mr-2">
                                        <option value="">All Categories</option>
                                        <option value="Medication">Medication</option>
                                        <option value="Equipment">Equipment</option>
                                        <option value="Supplies">Supplies</option>
                                        <option value="Laboratory">Laboratory</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <button type="submit" class="btn btn-info">Filter</button>
                                    <a href="index.php?action=check_low_stock" class="btn btn-warning ml-2">
                                        <i data-feather="alert-triangle" class="feather-icon"></i> Check Low Stock
                                    </a>
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
                                                <th>Item Name</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Reorder Level</th>
                                                <th>Unit Price</th>
                                                <th>Supplier</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($inventory as $item): ?>
                                            <tr class="<?php echo $item['quantity_in_stock'] <= $item['reorder_level'] ? 'table-warning' : ''; ?>">
                                                <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                                <td><?php echo htmlspecialchars($item['category']); ?></td>
                                                <td><?php echo htmlspecialchars($item['quantity_in_stock']); ?></td>
                                                <td><?php echo htmlspecialchars($item['reorder_level']); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($item['unit_price'], 2)); ?></td>
                                                <td><?php echo htmlspecialchars($item['supplier_name']); ?></td>
                                                <td>
                                                    <span class="badge badge-<?php 
                                                        echo $item['status'] === 'Active' ? 'success' : 
                                                            ($item['status'] === 'Out of Stock' ? 'danger' : 'warning'); ?>">
                                                        <?php echo htmlspecialchars($item['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm" 
                                                            data-toggle="modal" 
                                                            data-target="#adjustStockModal" 
                                                            data-id="<?php echo $item['inventory_id']; ?>">
                                                        Adjust Stock
                                                    </button>
                                                    <a href="index.php?action=edit_inventory&id=<?php echo $item['inventory_id']; ?>" 
                                                       class="btn btn-info btn-sm">Edit</a>
                                                    <a href="index.php?action=delete_inventory&id=<?php echo $item['inventory_id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Are you sure you want to delete this item?')">
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

    <!-- Add Item Modal -->
    <div class="modal fade" id="createItemModal" tabindex="-1" role="dialog" aria-labelledby="createItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createItemModalLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="index.php?action=store_inventory" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item_name">Item Name</label>
                                    <input type="text" class="form-control" id="item_name" name="item_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="Medication">Medication</option>
                                        <option value="Equipment">Equipment</option>
                                        <option value="Supplies">Supplies</option>
                                        <option value="Laboratory">Laboratory</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity_in_stock">Quantity in Stock</label>
                                    <input type="number" class="form-control" id="quantity_in_stock" name="quantity_in_stock" required min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reorder_level">Reorder Level</label>
                                    <input type="number" class="form-control" id="reorder_level" name="reorder_level" required min="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit_price">Unit Price</label>
                                    <input type="number" step="0.01" class="form-control" id="unit_price" name="unit_price" required min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier_id">Supplier</label>
                                    <select class="form-control" id="supplier_id" name="supplier_id" required>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Storage Location</label>
                                    <input type="text" class="form-control" id="location" name="location">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Adjust Stock Modal -->
    <div class="modal fade" id="adjustStockModal" tabindex="-1" role="dialog" aria-labelledby="adjustStockModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adjustStockModalLabel">Adjust Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="index.php?action=adjust_stock" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="inventory_id" id="adjust_inventory_id">
                        <div class="form-group">
                            <label for="adjustment_type">Adjustment Type</label>
                            <select class="form-control" id="adjustment_type" name="adjustment_type" required>
                                <option value="add">Add Stock</option>
                                <option value="subtract">Remove Stock</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Adjust Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/../footer.php'; ?>

<script>
    $('#adjustStockModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var inventoryId = button.data('id');
        var modal = $(this);
        modal.find('#adjust_inventory_id').val(inventoryId);
    });
</script>
</body>
</html>
