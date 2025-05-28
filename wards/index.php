<?php
// Include database connection
include '../db_connection.php';

// Fetch all wards
try {
    $stmt = $conn->prepare("SELECT * FROM ward ORDER BY ward_id ASC");
    $stmt->execute();
    $wards = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching wards: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Wards Management</title>
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
        /* Custom green button like staff page */
        .btn-custom-green {
            background-color: #008001;
            color: white;
        }
        .btn-custom-green:hover {
            background-color: #006600;
            color: white;
        }
        /* Adjust margin like staff page */
        .my-3 {
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
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
                <a href="index.php" class="active">Ward Management</a>
                <a href="../patients/index.php">Patient Management</a>
                <a href="../medication/index.php">Medication Management</a>
                <a href="../supplies/items_drugs.php">Supplies Management</a>
                <a href="../suppliers/index.php">Suppliers Management</a>
                <a href="../requisitions/index.php">Requisitions</a>
                <a href="../reports/index.php">Reports</a>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-10 ms-sm-auto px-md-4 content">
            <h2 class="mt-4">Wards Management</h2>

            <div class="my-3">
                <a href="add_ward.php" class="btn btn-custom-green">Add New Ward</a>
            </div>

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Ward Name</th>
                        <th>Location</th>
                        <th>Total Beds</th>
                        <th>Telephone Extension</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($wards): ?>
                        <?php foreach ($wards as $ward): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ward['ward_name']); ?></td>
                                <td><?php echo htmlspecialchars($ward['location']); ?></td>
                                <td><?php echo htmlspecialchars($ward['total_beds']); ?></td>
                                <td><?php echo htmlspecialchars($ward['telephone_extension']); ?></td>
                                <td>
                                    <a href="edit_ward.php?id=<?php echo $ward['ward_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_ward.php?id=<?php echo $ward['ward_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this ward?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No wards found.</td>
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
