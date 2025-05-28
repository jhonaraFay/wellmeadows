<?php
// Include database connection
include '../db_connection.php';

// Fetch patients
try {
    $stmt = $conn->query("SELECT patient_id, first_name || ' ' || last_name AS full_name FROM patient ORDER BY last_name");
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching patients: " . $e->getMessage();
    exit;
}

// Fetch drugs
try {
    $stmt = $conn->query("SELECT drug_id, drug_name FROM pharmaceutical ORDER BY drug_name");
    $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching drugs: " . $e->getMessage();
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'];
    $drug_id = $_POST['drug_id'];
    $units_per_day = $_POST['units_per_day'];
    $method_of_administration = $_POST['method_of_administration'];
    $start_date = $_POST['start_date'];
    $finish_date = $_POST['finish_date'];

    try {
        $stmt = $conn->prepare("
            INSERT INTO medication (patient_id, drug_id, units_per_day, method_of_administration, start_date, finish_date)
            VALUES (:patient_id, :drug_id, :units_per_day, :method_of_administration, :start_date, :finish_date)
        ");
        $stmt->execute([
            ':patient_id' => $patient_id,
            ':drug_id' => $drug_id,
            ':units_per_day' => $units_per_day,
            ':method_of_administration' => $method_of_administration,
            ':start_date' => $start_date,
            ':finish_date' => $finish_date
        ]);

        // Redirect after adding
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error adding medication: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Medication - Wellmeadows</title>
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
            <h2 class="mt-4 mb-4">Add New Medication</h2>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="patient_id" class="form-label">Patient</label>
                    <select name="patient_id" id="patient_id" class="form-select" required>
                        <option value="">Select Patient</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?= htmlspecialchars($patient['patient_id']) ?>">
                                <?= htmlspecialchars($patient['full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="drug_id" class="form-label">Drug</label>
                    <select name="drug_id" id="drug_id" class="form-select" required>
                        <option value="">Select Drug</option>
                        <?php foreach ($drugs as $drug): ?>
                            <option value="<?= htmlspecialchars($drug['drug_id']) ?>">
                                <?= htmlspecialchars($drug['drug_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="units_per_day" class="form-label">Units per Day</label>
                    <input type="number" name="units_per_day" id="units_per_day" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="method_of_administration" class="form-label">Method of Administration</label>
                    <input type="text" name="method_of_administration" id="method_of_administration" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="finish_date" class="form-label">Finish Date</label>
                    <input type="date" name="finish_date" id="finish_date" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-custom-green">Add Medication</button>
            </form>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
