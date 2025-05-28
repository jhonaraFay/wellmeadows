<?php
include '../db_connection.php';

// Fetch all requisitions with ward name and staff full name
$stmt = $conn->query("
    SELECT r.*, w.ward_name, s.first_name || ' ' || s.last_name AS staff_name
    FROM requisition r
    JOIN ward w ON r.ward_id = w.ward_id
    JOIN staff s ON r.staff_id = s.staff_id
    ORDER BY r.requisition_date DESC
");
$requisitions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Requisitions Management - Wellmeadows Hospital</title>
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
        /* Custom green button style */
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
                <a href="../supplies/items.php">Supplies Management</a>
                <a href="../suppliers/index.php">Suppliers Management</a>
                <a href="index.php" class="active">Requisitions</a>
                <a href="../reports/index.php">Reports</a>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-10 ms-sm-auto px-md-4 content">
            <h2 class="mt-4">Requisitions Management</h2>

            <div class="mb-3">
                <a href="add_requisition.php" class="btn btn-custom-green">Add New Requisition</a>
            </div>

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Requisition No</th>
                        <th>Ward</th>
                        <th>Staff</th>
                        <th>Requisition Date</th>
                        <th>Delivery Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($requisitions): ?>
                        <?php foreach ($requisitions as $req): ?>
                            <tr>
                                <td><?= htmlspecialchars($req['requisition_number']) ?></td>
                                <td><?= htmlspecialchars($req['ward_name']) ?></td>
                                <td><?= htmlspecialchars($req['staff_name']) ?></td>
                                <td><?= htmlspecialchars($req['requisition_date']) ?></td>
                                <td><?= htmlspecialchars($req['delivery_date']) ?></td>
                                <td>
                                    <a href="edit_requisition.php?id=<?= $req['requisition_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete_requisition.php?id=<?= $req['requisition_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this requisition?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No requisitions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
