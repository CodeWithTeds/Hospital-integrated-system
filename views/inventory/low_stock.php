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
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Low Stock Items</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="index.php" class="text-muted">Home</a></li>
                                    <li class="breadcrumb-item"><a href="index.php?action=inventory" class="text-muted">Inventory</a></li>
                                    <li class="breadcrumb-item text-muted active" aria-current="page">Low Stock</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-5 align-self-center">
                        <div class="customize-input float-right">
                            <a href="index.php?action=inventory" class="btn btn-primary">
                                <i data-feather="arrow-left" class="feather-icon"></i> Back to Inventory
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
                                                <th>Item Name</th>
                                                <th>Category</th>
                                                <th>Current Stock</th>
                                                <th>Reorder Level</th>
                                                <th>Unit Price</th>
                                                <th>Supplier</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($lowStockItems)): ?>
                                                <?php foreach ($lowStockItems as $item): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($item['category']); ?></td>
                                                        <td>
                                                            <span class="text-danger font-weight-bold">
                                                                <?php echo htmlspecialchars($item['quantity_in_stock']); ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($item['reorder_level']); ?></td>
                                                        <td><?php echo htmlspecialchars(number_format($item['unit_price'], 2)); ?></td>
                                                        <td><?php echo htmlspecialchars($item['supplier_name']); ?></td>
                                                        <td>
                                                            <span class="badge badge-warning">Low Stock</span>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-sm" 
                                                                    data-toggle="modal" 
                                                                    data-target="#adjustStockModal" 
                                                                    data-id="<?php echo $item['inventory_id']; ?>">
                                                                Restock
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8" class="text-center">No low stock items found.</td>
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

    <!-- Adjust Stock Modal -->
    <div class="modal fade" id="adjustStockModal" tabindex="-1" role="dialog" aria-labelledby="adjustStockModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adjustStockModalLabel">Restock Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="index.php?action=adjust_stock" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="inventory_id" id="adjust_inventory_id">
                        <input type="hidden" name="adjustment_type" value="add">
                        <div class="form-group">
                            <label for="quantity">Quantity to Add</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Restock Item</button>
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