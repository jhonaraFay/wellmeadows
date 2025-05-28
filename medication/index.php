<?php
// Include database connection
include '../db_connection.php';

// Fetch all medication records
try {
    $stmt = $conn->prepare("
        SELECT m.medication_id, 
               p.first_name || ' ' || p.last_name AS patient_name,
               ph.drug_name,
               m.method_of_administration,
               m.units_per_day,
               m.start_date,
               m.finish_date
        FROM medication m
        JOIN patient p ON m.patient_id = p.patient_id
        JOIN pharmaceutical ph ON m.drug_id = ph.drug_id
        ORDER BY m.start_date DESC
    ");
    $stmt->execute();
    $medications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching medications: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Medication Management - Wellmeadows</title>
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
        .sidebar a.fw-bold {
            font-weight: bold;
            color: #0056b3;
        }
        .content {
            padding: 20px;
        }
        /* Custom green button like Staff & Patient pages */
        .btn-custom-green {
            background-color: #008001;
            color: white;
        }
        .btn-custom-green:hover {
            background-color: #006600;
            color: white;
        }
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
                <a href="../wards/index.php">Ward Management</a>
                <a href="../patients/index.php">Patient Management</a>
                <a href="../medication/index.php" class="fw-bold">Medication Management</a>
                <a href="../supplies/items.php">Supplies Management</a>
                <a href="../suppliers/index.php">Suppliers Management</a>
                <a href="../requisitions/index.php">Requisitions</a>
                <a href="../reports/index.php">Reports</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 content">
            <h2 class="mt-4">Medication Management</h2>

            <div class="my-3">
                <a href="add_medication.php" class="btn btn-custom-green">Add Medication</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Patient Name</th>
                            <th>Drug Name</th>
                            <th>Method of Administration</th>
                            <th>Units Per Day</th>
                            <th>Start Date</th>
                            <th>Finish Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($medications): ?>
                            <?php foreach ($medications as $medication): ?>
                                <tr>
                                    <td><?= htmlspecialchars($medication['patient_name']) ?></td>
                                    <td><?= htmlspecialchars($medication['drug_name']) ?></td>
                                    <td><?= htmlspecialchars($medication['method_of_administration']) ?></td>
                                    <td><?= htmlspecialchars($medication['units_per_day']) ?></td>
                                    <td><?= htmlspecialchars($medication['start_date']) ?></td>
                                    <td><?= htmlspecialchars($medication['finish_date']) ?></td>
                                    <td>
                                        <a href="edit_medication.php?id=<?= $medication['medication_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete_medication.php?id=<?= $medication['medication_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this medication?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No medications found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
