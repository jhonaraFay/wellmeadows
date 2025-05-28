<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$ward_id = $_GET['id'];

try {
    $stmt = $conn->prepare("SELECT * FROM ward WHERE ward_id = :ward_id");
    $stmt->execute([':ward_id' => $ward_id]);
    $ward = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ward) {
        echo "Ward not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error fetching ward: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ward_name = $_POST['ward_name'];
    $location = $_POST['location'];
    $total_beds = $_POST['total_beds'];
    $telephone_extension = $_POST['telephone_extension'];

    try {
        $stmt = $conn->prepare("UPDATE ward SET ward_name = :ward_name, location = :location, total_beds = :total_beds, telephone_extension = :telephone_extension WHERE ward_id = :ward_id");
        $stmt->execute([
            ':ward_name' => $ward_name,
            ':location' => $location,
            ':total_beds' => $total_beds,
            ':telephone_extension' => $telephone_extension,
            ':ward_id' => $ward_id
        ]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Error updating ward: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Ward</title>
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

        <main class="col-md-10 ms-sm-auto px-md-4 content">
            <h2 class="mt-4">Edit Ward</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="ward_name" class="form-label">Ward Name</label>
                    <input type="text" name="ward_name" id="ward_name" class="form-control" value="<?php echo htmlspecialchars($ward['ward_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" id="location" class="form-control" value="<?php echo htmlspecialchars($ward['location']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="total_beds" class="form-label">Total Beds</label>
                    <input type="number" name="total_beds" id="total_beds" class="form-control" value="<?php echo htmlspecialchars($ward['total_beds']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="telephone_extension" class="form-label">Telephone Extension</label>
                    <input type="text" name="telephone_extension" id="telephone_extension" class="form-control" value="<?php echo htmlspecialchars($ward['telephone_extension']); ?>" required>
                </div>
                <button type="submit" class="btn btn-custom-green">Update Ward</button>
            </form>
        </main>
    </div>
</div>
</body>
</html>
