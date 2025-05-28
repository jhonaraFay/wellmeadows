<?php
include '../db_connection.php';

// Fetch all supply items
$stmt_items = $conn->query("
    SELECT 
        item_number,
        item_name,
        item_type,
        quantity_in_stock,
        reorder_level,
        cost_per_unit
    FROM supply_item
    ORDER BY item_name
");
$items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

// Fetch all pharmaceutical drugs
$stmt_drugs = $conn->query("
    SELECT 
        drug_number,
        drug_name,
        quantity_in_stock,
        reorder_level,
        cost_per_unit
    FROM pharmaceutical
    ORDER BY drug_name
");
$drugs = $stmt_drugs->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Supplies Report - Wellmeadows Hospital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #e9ecef;
        }
        .sidebar a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .sidebar a:hover {
            background-color: #d4e3f1;
            color: #0056b3;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="position-sticky">
                <h4 class="text-center py-3">Wellmeadows</h4>
                <a href="../index.php">Home</a>
                <a href="../staff/index.php">Staff Management</a>
                <a href="../wards/index.php">Ward Management</a>
                <a href="../patients/index.php">Patient Management</a>
                <a href="../medication/index.php">Medication Management</a>
                <a href="../supplies/items.php">Supplies Management</a>
                <a href="../suppliers/index.php">Suppliers Management</a>
                <a href="../requisitions/index.php">Requisitions</a>
                <a href="../reports/index.php" class="fw-bold" style="color:#0056b3;">Reports</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 content">
            <h2 class="mt-4">Supplies Report - Items</h2>

            <table class="table table-bordered mt-4 table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Item Number</th>
                        <th>Item Name</th>
                        <th>Item Type</th>
                        <th>Quantity In Stock</th>
                        <th>Reorder Level</th>
                        <th>Cost Per Unit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($items): ?>
                        <?php foreach ($items as $i): ?>
                            <tr>
                                <td><?= htmlspecialchars($i['item_number']) ?></td>
                                <td><?= htmlspecialchars($i['item_name']) ?></td>
                                <td><?= htmlspecialchars($i['item_type']) ?></td>
                                <td><?= htmlspecialchars($i['quantity_in_stock']) ?></td>
                                <td><?= htmlspecialchars($i['reorder_level']) ?></td>
                                <td>$<?= number_format($i['cost_per_unit'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No supply items found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <h2 class="mt-5">Supplies Report - Drugs</h2>

            <table class="table table-bordered mt-4 table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Drug Number</th>
                        <th>Drug Name</th>
                        <th>Quantity In Stock</th>
                        <th>Reorder Level</th>
                        <th>Cost Per Unit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($drugs): ?>
                        <?php foreach ($drugs as $d): ?>
                            <tr>
                                <td><?= htmlspecialchars($d['drug_number']) ?></td>
                                <td><?= htmlspecialchars($d['drug_name']) ?></td>
                                <td><?= htmlspecialchars($d['quantity_in_stock']) ?></td>
                                <td><?= htmlspecialchars($d['reorder_level']) ?></td>
                                <td>$<?= number_format($d['cost_per_unit'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No drugs found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="mt-4">
                <a href="index.php" class="btn btn-secondary">Home</a>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
