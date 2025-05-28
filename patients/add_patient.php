<?php
include '../db_connection.php';

// Fetch doctors for selection
try {
    $doctors_stmt = $conn->query("SELECT doctor_id, full_name FROM local_doctor ORDER BY full_name");
    $doctors = $doctors_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching doctors: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "SELECT add_patient(:patient_number, :first_name, :last_name, :address, :telephone, :date_of_birth, :sex, :marital_status, :date_registered, :kin_full_name, :kin_relationship, :kin_address, :kin_telephone, :doctor_id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':patient_number' => $_POST['patient_number'],
            ':first_name' => $_POST['first_name'],
            ':last_name' => $_POST['last_name'],
            ':address' => $_POST['address'],
            ':telephone' => $_POST['telephone'],
            ':date_of_birth' => $_POST['date_of_birth'],
            ':sex' => $_POST['sex'],
            ':marital_status' => $_POST['marital_status'],
            ':date_registered' => $_POST['date_registered'],
            ':kin_full_name' => $_POST['kin_full_name'],
            ':kin_relationship' => $_POST['kin_relationship'],
            ':kin_address' => $_POST['kin_address'],
            ':kin_telephone' => $_POST['kin_telephone'],
            ':doctor_id' => $_POST['doctor_id'] ?: null
        ]);

        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        die("Error adding patient: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add New Patient - Wellmeadows</title>
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
            <h2 class="mt-4">Add New Patient</h2>

            <form method="POST">
                <h4>Patient Information</h4>
                <div class="row mb-3">
                    <div class="col">
                        <label>Patient Number</label>
                        <input type="text" name="patient_number" class="form-control" required />
                    </div>
                    <div class="col">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" required />
                    </div>
                    <div class="col">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" required />
                    </div>
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" required></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label>Telephone</label>
                        <input type="text" name="telephone" class="form-control" />
                    </div>
                    <div class="col">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" required />
                    </div>
                    <div class="col">
                        <label>Sex</label>
                        <select name="sex" class="form-control" required>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label>Marital Status</label>
                        <input type="text" name="marital_status" class="form-control" />
                    </div>
                    <div class="col">
                        <label>Date Registered</label>
                        <input type="date" name="date_registered" class="form-control" required />
                    </div>
                </div>

                <h4 class="mt-4">Next of Kin Information</h4>
                <div class="row mb-3">
                    <div class="col">
                        <label>Full Name</label>
                        <input type="text" name="kin_full_name" class="form-control" required />
                    </div>
                    <div class="col">
                        <label>Relationship</label>
                        <input type="text" name="kin_relationship" class="form-control" required />
                    </div>
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="kin_address" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Telephone</label>
                    <input type="text" name="kin_telephone" class="form-control" required />
                </div>

                <h4 class="mt-4">Local Doctor (Optional)</h4>
                <div class="mb-3">
                    <label>Choose Doctor</label>
                    <select name="doctor_id" class="form-control">
                        <option value="">-- None --</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor['doctor_id'] ?>"><?= htmlspecialchars($doctor['full_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-custom-green">Add Patient</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
