<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    echo "Requisition ID missing.";
    exit;
}

$requisition_id = $_GET['id'];

// Fetch current requisition details
$stmt = $conn->prepare("SELECT * FROM requisition WHERE requisition_id = :id");
$stmt->execute([':id' => $requisition_id]);
$requisition = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$requisition) {
    echo "Requisition not found.";
    exit;
}

// Fetch wards and staff for dropdowns
$wards = $conn->query("SELECT * FROM ward ORDER BY ward_name")->fetchAll(PDO::FETCH_ASSOC);
$staff = $conn->query("SELECT * FROM staff ORDER BY last_name, first_name")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ward_id = $_POST['ward_id'];
    $staff_id = $_POST['staff_id'];
    $requisition_date = $_POST['requisition_date'];
    $delivery_date = $_POST['delivery_date'];

    $sql = "UPDATE requisition SET ward_id = :ward_id, staff_id = :staff_id, requisition_date = :requisition_date, delivery_date = :delivery_date WHERE requisition_id = :id";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([
        ':ward_id' => $ward_id,
        ':staff_id' => $staff_id,
        ':requisition_date' => $requisition_date,
        ':delivery_date' => $delivery_date,
        ':id' => $requisition_id
    ]);

    if ($result) {
        echo "<script>alert('Requisition updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating requisition.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Requisition - Wellmeadows Hospital</title>
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
                <a href="../requisitions/index.php" class="active">Requisitions</a>
                <a href="../reports/index.php">Reports</a>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-10 ms-sm-auto px-md-4 content">
            <h2 class="mt-4">Edit Requisition</h2>
            <form method="POST">
                <div class="mb-3">
                    <label>Requisition Number</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($requisition['requisition_number']) ?>" disabled>
                </div>

                <div class="mb-3">
                    <label>Select Ward</label>
                    <select name="ward_id" class="form-control" required>
                        <?php foreach ($wards as $ward): ?>
                            <option value="<?= $ward['ward_id'] ?>" <?= ($ward['ward_id'] == $requisition['ward_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ward['ward_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Select Staff</label>
                    <select name="staff_id" class="form-control" required>
                        <?php foreach ($staff as $s): ?>
                            <option value="<?= $s['staff_id'] ?>" <?= ($s['staff_id'] == $requisition['staff_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Requisition Date</label>
                    <input type="date" name="requisition_date" class="form-control" value="<?= $requisition['requisition_date'] ?>" required>
                </div>

                <div class="mb-3">
                    <label>Delivery Date</label>
                    <input type="date" name="delivery_date" class="form-control" value="<?= $requisition['delivery_date'] ?>">
                </div>

                <button type="submit" class="btn btn-custom-green">Update Requisition</button>
                <a href="index.php" class="btn btn-secondary">Home</a>
            </form>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
