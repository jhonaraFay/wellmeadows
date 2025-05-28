<?php
// Include database connection
include '../db_connection.php';

// Get drug ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: drugs.php");
    exit;
}

$drug_id = $_GET['id'];

// Fetch existing drug data
try {
    $stmt = $conn->prepare("SELECT * FROM pharmaceutical WHERE drug_id = :id");
    $stmt->execute([':id' => $drug_id]);
    $drug = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$drug) {
        echo "Drug not found!";
        exit;
    }
} catch (PDOException $e) {
    echo "Error fetching drug: " . $e->getMessage();
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drug_number = $_POST['drug_number'];
    $drug_name = $_POST['drug_name'];
    $description = $_POST['description'];
    $dosage = $_POST['dosage'];
    $method_of_administration = $_POST['method_of_administration'];
    $quantity_in_stock = $_POST['quantity_in_stock'];
    $reorder_level = $_POST['reorder_level'];
    $cost_per_unit = $_POST['cost_per_unit'];

    try {
        $stmt = $conn->prepare("UPDATE pharmaceutical SET 
            drug_number = :drug_number,
            drug_name = :drug_name,
            description = :description,
            dosage = :dosage,
            method_of_administration = :method_of_administration,
            quantity_in_stock = :quantity_in_stock,
            reorder_level = :reorder_level,
            cost_per_unit = :cost_per_unit
            WHERE drug_id = :id");

        $stmt->execute([
            ':drug_number' => $drug_number,
            ':drug_name' => $drug_name,
            ':description' => $description,
            ':dosage' => $dosage,
            ':method_of_administration' => $method_of_administration,
            ':quantity_in_stock' => $quantity_in_stock,
            ':reorder_level' => $reorder_level,
            ':cost_per_unit' => $cost_per_unit,
            ':id' => $drug_id
        ]);

        // Redirect back to drugs list
        header("Location: drugs.php");
        exit;
    } catch (PDOException $e) {
        echo "Error updating drug: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Drug - Wellmeadows</title>
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
                <a href="../patients/index.php">Patient Management</a>
                <a href="../medication/index.php">Medication Management</a>
                <a href="../supplies/items.php" class="fw-bold">Supplies Management</a>
                <a href="../suppliers/index.php">Suppliers Management</a>
                <a href="../requisitions/index.php">Requisitions</a>
                <a href="../reports/index.php">Reports</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 content">
            <h2 class="mt-4">Edit Pharmaceutical Drug</h2>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="drug_number" class="form-label">Drug Number</label>
                    <input type="text" class="form-control" id="drug_number" name="drug_number" value="<?= htmlspecialchars($drug['drug_number']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="drug_name" class="form-label">Drug Name</label>
                    <input type="text" class="form-control" id="drug_name" name="drug_name" value="<?= htmlspecialchars($drug['drug_name']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($drug['description']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="dosage" class="form-label">Dosage</label>
                    <input type="text" class="form-control" id="dosage" name="dosage" value="<?= htmlspecialchars($drug['dosage']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="method_of_administration" class="form-label">Method of Administration</label>
                    <input type="text" class="form-control" id="method_of_administration" name="method_of_administration" value="<?= htmlspecialchars($drug['method_of_administration']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="quantity_in_stock" class="form-label">Quantity In Stock</label>
                    <input type="number" class="form-control" id="quantity_in_stock" name="quantity_in_stock" value="<?= htmlspecialchars($drug['quantity_in_stock']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="reorder_level" class="form-label">Reorder Level</label>
                    <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="<?= htmlspecialchars($drug['reorder_level']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="cost_per_unit" class="form-label">Cost Per Unit</label>
                    <input type="number" step="0.01" class="form-control" id="cost_per_unit" name="cost_per_unit" value="<?= htmlspecialchars($drug['cost_per_unit']); ?>" required>
                </div>

                <button type="submit" class="btn btn-custom-green">Update Drug</button>
				                <a href="drugs.php" class="btn btn-secondary">Cancel</a>

            </form>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
