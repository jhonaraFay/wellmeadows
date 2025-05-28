<?php
include '../db_connection.php';

// Fetch all patients
$stmt = $conn->query("SELECT patient_number, first_name, last_name, address, telephone, date_of_birth, sex, marital_status FROM patient ORDER BY last_name, first_name");
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Patient Report - Wellmeadows Hospital</title>
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
        .navbar-brand {
            font-weight: bold;
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
            <h2 class="mt-4">Patient Report</h2>

            <table class="table table-bordered mt-4 table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Patient Number</th>
                        <th>Full Name</th>
                        <th>Address</th>
                        <th>Telephone</th>
                        <th>Date of Birth</th>
                        <th>Sex</th>
                        <th>Marital Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($patients): ?>
                        <?php foreach ($patients as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['patient_number']) ?></td>
                                <td><?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?></td>
                                <td><?= htmlspecialchars($p['address']) ?></td>
                                <td><?= htmlspecialchars($p['telephone']) ?></td>
                                <td><?= htmlspecialchars($p['date_of_birth']) ?></td>
                                <td><?= htmlspecialchars($p['sex']) ?></td>
                                <td><?= htmlspecialchars($p['marital_status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No patient records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="mt-4">
                <a href="index.php" class="btn btn-secondary">Back</a>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
