<?php
include '../db_connection.php';

// Fetch all staff
try {
    $stmt = $conn->query("SELECT * FROM staff ORDER BY last_name, first_name");
    $staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching staff: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Staff Management - Wellmeadows Hospital</title>
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
                <a href="index.php" class="active">Staff Management</a>
                <a href="../wards/index.php">Ward Management</a>
                <a href="../patients/index.php">Patient Management</a>
                <a href="../medication/index.php">Medication Management</a>
                <a href="../supplies/items.php">Supplies Management</a>
                <a href="../suppliers/index.php">Suppliers Management</a>
                <a href="../requisitions/index.php">Requisitions</a>
                <a href="../reports/index.php">Reports</a>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-10 ms-sm-auto px-md-4 content">
    <h2 class="mt-4">Staff Management</h2>

    <div class="my-3"> <!-- Added 'my-3' for vertical margin -->
        <a href="add_staff.php" class="btn" style="background-color: #008001; color: white;">Add New Staff</a>
    </div>

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Staff Number</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Position</th>
                        <th>Telephone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($staffs): ?>
                        <?php foreach ($staffs as $staff): ?>
                            <tr>
                                <td><?= htmlspecialchars($staff['staff_number']) ?></td>
                                <td><?= htmlspecialchars($staff['first_name']) ?></td>
                                <td><?= htmlspecialchars($staff['last_name']) ?></td>
                                <td><?= htmlspecialchars($staff['position']) ?></td>
                                <td><?= htmlspecialchars($staff['telephone']) ?></td>
                                <td>
                                    <a href="edit_staff.php?id=<?= $staff['staff_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete_staff.php?id=<?= $staff['staff_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this staff?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No staff found.</td>
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
