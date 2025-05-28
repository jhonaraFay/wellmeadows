<?php
// Include database connection
include '../db_connection.php';

// Initialize arrays
$items = [];
$drugs = [];

try {
    $stmt = $conn->prepare("SELECT * FROM supply_item ORDER BY item_name ASC");
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching supply items: " . $e->getMessage();
}

try {
    $stmt = $conn->prepare("SELECT * FROM pharmaceutical ORDER BY drug_name");
    $stmt->execute();
    $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching drugs: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Supplies & Pharmaceutical Drugs - Wellmeadows Hospital</title>
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
        .sidebar a.active {
            font-weight: bold;
            color: #0056b3;
        }
        .content {
            padding: 20px;
        }
        h2 {
            margin-top: 30px;
        }
        /* Custom green button like Medication Management */
        .btn-custom-green {
            background-color: #008001;
            color: white;
        }
        .btn-custom-green:hover {
            background-color: #006600;
            color: white;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="position-sticky pt-3">
                <h4 class="text-center py-3">Wellmeadows</h4>
                <a href="../index.php">Home</a>
                <a href="../staff/index.php">Staff Management</a>
                <a href="../wards/index.php">Ward Management</a>
                <a href="../patients/index.php">Patient Management</a>
                <a href="../medication/index.php">Medication Management</a>
                <a href="items.php" class="active">Supplies Management</a>
                <a href="../suppliers/index.php">Suppliers Management</a>
                <a href="../requisitions/index.php">Requisitions</a>
                <a href="../reports/index.php">Reports</a>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-10 ms-sm-auto px-md-4 content">
            <!-- Supply Items Section -->
            <h2>Supply Items (Surgical/Non-Surgical)</h2>
            <div class="mb-3">
                <a href="add_item.php" class="btn btn-custom-green">Add New Supply Item</a>
            </div>

            <?php if (!empty($items)): ?>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Item Number</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Type</th>
                            <th scope="col">Description</th>
                            <th scope="col">Quantity In Stock</th>
                            <th scope="col">Reorder Level</th>
                            <th scope="col">Cost Per Unit</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['item_number']) ?></td>
                            <td><?= htmlspecialchars($item['item_name']) ?></td>
                            <td><?= htmlspecialchars($item['item_type']) ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td><?= htmlspecialchars($item['quantity_in_stock']) ?></td>
                            <td><?= htmlspecialchars($item['reorder_level']) ?></td>
                            <td>$<?= htmlspecialchars(number_format($item['cost_per_unit'], 2)) ?></td>
                            <td>
                                <a href="edit_item.php?id=<?= $item['item_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_item.php?id=<?= $item['item_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No supply items found.</p>
            <?php endif; ?>

            <!-- Pharmaceutical Drugs Section -->
            <h2>Pharmaceutical Drugs</h2>
            <div class="mb-3">
                <a href="add_drug.php" class="btn btn-custom-green">Add New Drug</a>
            </div>

            <?php if (!empty($drugs)): ?>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Drug Number</th>
                            <th scope="col">Drug Name</th>
                            <th scope="col">Dosage</th>
                            <th scope="col">Method of Administration</th>
                            <th scope="col">Quantity In Stock</th>
                            <th scope="col">Reorder Level</th>
                            <th scope="col">Cost Per Unit</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($drugs as $drug): ?>
                        <tr>
                            <td><?= htmlspecialchars($drug['drug_number']) ?></td>
                            <td><?= htmlspecialchars($drug['drug_name']) ?></td>
                            <td><?= htmlspecialchars($drug['dosage']) ?></td>
                            <td><?= htmlspecialchars($drug['method_of_administration']) ?></td>
                            <td><?= htmlspecialchars($drug['quantity_in_stock']) ?></td>
                            <td><?= htmlspecialchars($drug['reorder_level']) ?></td>
                            <td>$<?= htmlspecialchars(number_format($drug['cost_per_unit'], 2)) ?></td>
                            <td>
                                <a href="edit_drug.php?id=<?= $drug['drug_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_drug.php?id=<?= $drug['drug_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this drug?');">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No pharmaceutical drugs found.</p>
            <?php endif; ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
