<?php
// Include database connection
include '../db_connection.php';

// Check if medication ID is set
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$medication_id = $_GET['id'];

// Fetch medication details
try {
    $stmt = $conn->prepare("
        SELECT m.*, 
               p.first_name || ' ' || p.last_name AS patient_name,
               ph.drug_name
        FROM medication m
        JOIN patient p ON m.patient_id = p.patient_id
        JOIN pharmaceutical ph ON m.drug_id = ph.drug_id
        WHERE m.medication_id = :medication_id
    ");
    $stmt->execute([':medication_id' => $medication_id]);
    $medication = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$medication) {
        echo "Medication record not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error fetching medication: " . $e->getMessage();
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $units_per_day = $_POST['units_per_day'];
    $method_of_administration = $_POST['method_of_administration'];
    $start_date = $_POST['start_date'];
    $finish_date = $_POST['finish_date'];

    try {
        $stmt = $conn->prepare("
            UPDATE medication
            SET units_per_day = :units_per_day,
                method_of_administration = :method_of_administration,
                start_date = :start_date,
                finish_date = :finish_date
            WHERE medication_id = :medication_id
        ");
        $stmt->execute([
            ':units_per_day' => $units_per_day,
            ':method_of_administration' => $method_of_administration,
            ':start_date' => $start_date,
            ':finish_date' => $finish_date,
            ':medication_id' => $medication_id
        ]);

        // Redirect back after update
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error updating medication: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Medication - Wellmeadows</title>
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
            <h2 class="mt-4">Edit Medication</h2>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Patient Name</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($medication['patient_name']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Drug Name</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($medication['drug_name']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="units_per_day" class="form-label">Units per Day</label>
                    <input type="number" name="units_per_day" id="units_per_day" class="form-control" value="<?= htmlspecialchars($medication['units_per_day']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="method_of_administration" class="form-label">Method of Administration</label>
                    <input type="text" name="method_of_administration" id="method_of_administration" class="form-control" value="<?= htmlspecialchars($medication['method_of_administration']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?= htmlspecialchars($medication['start_date']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="finish_date" class="form-label">Finish Date</label>
                    <input type="date" name="finish_date" id="finish_date" class="form-control" value="<?= htmlspecialchars($medication['finish_date']); ?>" required>
                </div>

                <button type="submit" class="btn btn-custom-green">Update Medication</button>
            </form>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
