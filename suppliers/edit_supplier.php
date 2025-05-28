<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    echo "Supplier ID is missing!";
    exit;
}

$supplier_id = $_GET['id'];

// Fetch existing supplier data
$stmt = $conn->prepare("SELECT * FROM supplier WHERE supplier_id = :supplier_id");
$stmt->execute([':supplier_id' => $supplier_id]);
$supplier = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$supplier) {
    echo "Supplier not found!";
    exit;
}

// If form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_number = $_POST['supplier_number'];
    $supplier_name = $_POST['supplier_name'];
    $address = $_POST['address'];
    $telephone = $_POST['telephone'];
    $fax = $_POST['fax'];

    $update = "UPDATE supplier
               SET supplier_number = :supplier_number,
                   supplier_name = :supplier_name,
                   address = :address,
                   telephone = :telephone,
                   fax = :fax
               WHERE supplier_id = :supplier_id";

    $stmt = $conn->prepare($update);

    $result = $stmt->execute([
        ':supplier_number' => $supplier_number,
        ':supplier_name' => $supplier_name,
        ':address' => $address,
        ':telephone' => $telephone,
        ':fax' => $fax,
        ':supplier_id' => $supplier_id
    ]);

    if ($result) {
        echo "<script>alert('Supplier updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating supplier.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <a href="index.php" class="active">Suppliers Management</a>
                <a href="../requisitions/index.php">Requisitions</a>
                <a href="../reports/index.php">Reports</a>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-10 ms-sm-auto px-md-4 content">
            <h2 class="mt-4">Edit Supplier</h2>
            <form method="POST">
                <div class="mb-3">
                    <label>Supplier Number</label>
                    <input type="text" name="supplier_number" class="form-control" value="<?= htmlspecialchars($supplier['supplier_number']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Supplier Name</label>
                    <input type="text" name="supplier_name" class="form-control" value="<?= htmlspecialchars($supplier['supplier_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" required><?= htmlspecialchars($supplier['address']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label>Telephone</label>
                    <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($supplier['telephone']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Fax</label>
                    <input type="text" name="fax" class="form-control" value="<?= htmlspecialchars($supplier['fax']) ?>">
                </div>
                <button type="submit" class="btn btn-custom-green">Update Supplier</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
