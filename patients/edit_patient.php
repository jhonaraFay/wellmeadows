<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    die('Missing patient ID.');
}

$patient_id = $_GET['id'];

try {
    $stmt = $conn->prepare("SELECT * FROM patient WHERE patient_id = :id");
    $stmt->execute([':id' => $patient_id]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        die('Patient not found.');
    }

    $stmt2 = $conn->prepare("SELECT * FROM next_of_kin WHERE patient_id = :id");
    $stmt2->execute([':id' => $patient_id]);
    $kin = $stmt2->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching patient: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare("SELECT update_patient(:patient_id, :address, :telephone, :marital_status)");
        $stmt->execute([
            ':patient_id' => $patient_id,
            ':address' => $_POST['address'],
            ':telephone' => $_POST['telephone'],
            ':marital_status' => $_POST['marital_status']
        ]);

        $stmt2 = $conn->prepare("SELECT update_next_of_kin(:patient_id, :full_name, :relationship, :address, :telephone)");
        $stmt2->execute([
            ':patient_id' => $patient_id,
            ':full_name' => $_POST['kin_full_name'],
            ':relationship' => $_POST['kin_relationship'],
            ':address' => $_POST['kin_address'],
            ':telephone' => $_POST['kin_telephone']
        ]);

        header('Location: index.php');
        exit();

    } catch (PDOException $e) {
        die("Error updating patient: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Patient - Wellmeadows</title>
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
                <a href="../patients/index.php" class="fw-bold">Patient Management</a>
                <a href="../medication/index.php">Medication Management</a>
                <a href="../supplies/items.php">Supplies Management</a>
                <a href="../suppliers/index.php">Suppliers Management</a>
                <a href="../requisitions/index.php">Requisitions</a>
                <a href="../reports/index.php">Reports</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 content">
            <h2 class="mt-4 mb-4">Edit Patient</h2>

            <form method="POST">
                <h5>Patient Information</h5>
                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label>Telephone</label>
                        <input type="text" name="telephone" class="form-control" value="<?php echo htmlspecialchars($patient['telephone']); ?>">
                    </div>
                    <div class="col">
                        <label>Marital Status</label>
                        <input type="text" name="marital_status" class="form-control" value="<?php echo htmlspecialchars($patient['marital_status']); ?>">
                    </div>
                </div>

                <h5 class="mt-4">Next of Kin Information</h5>
                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" name="kin_full_name" class="form-control" value="<?php echo htmlspecialchars($kin['full_name'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label>Relationship</label>
                    <input type="text" name="kin_relationship" class="form-control" value="<?php echo htmlspecialchars($kin['relationship'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="kin_address" class="form-control" required><?php echo htmlspecialchars($kin['address'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Telephone</label>
                    <input type="text" name="kin_telephone" class="form-control" value="<?php echo htmlspecialchars($kin['telephone'] ?? ''); ?>" required>
                </div>

                <button type="submit" class="btn btn-custom-green">Update Patient</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
