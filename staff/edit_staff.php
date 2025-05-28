<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    die('Missing staff ID.');
}

$staff_id = $_GET['id'];

// Fetch staff details
try {
    $stmt = $conn->prepare("SELECT * FROM staff WHERE staff_id = :id");
    $stmt->execute([':id' => $staff_id]);
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$staff) {
        die('Staff not found.');
    }
} catch (PDOException $e) {
    die("Error fetching staff: " . $e->getMessage());
}

// Update staff details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "SELECT update_staff(:staff_id, :address, :telephone, :position, :current_salary, :salary_scale, :payment_type, :contract_type, :hours_per_week)";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':staff_id' => $staff_id,
            ':address' => $_POST['address'],
            ':telephone' => $_POST['telephone'],
            ':position' => $_POST['position'],
            ':current_salary' => $_POST['current_salary'],
            ':salary_scale' => $_POST['salary_scale'],
            ':payment_type' => $_POST['payment_type'],
            ':contract_type' => $_POST['contract_type'],
            ':hours_per_week' => $_POST['hours_per_week']
        ]);

        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        die("Error updating staff: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Staff</title>
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
        /* Match button green from wards page */
        .btn-success-custom {
            background-color: #008001;
            color: white;
            border: none;
        }
        .btn-success-custom:hover {
            background-color: #006400;
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
        <a href="../staff/index.php" class="active">Staff Management</a>
        <a href="../wards/index.php">Ward Management</a>
        <a href="../patients/index.php">Patient Management</a>
        <a href="../medication/index.php">Medication Management</a>
        <a href="../supplies/items_drugs.php">Supplies Management</a>
        <a href="../suppliers/index.php">Suppliers Management</a>
        <a href="../requisitions/index.php">Requisitions</a>
        <a href="../reports/index.php">Reports</a>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="col-md-10 ms-sm-auto px-md-4 content">
      <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <h2>Edit Staff</h2>
        <a href="../index.php" class="btn btn-primary">Home</a>
      </div>

      <form method="POST">
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required><?php echo htmlspecialchars($staff['address']); ?></textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Telephone</label>
                <input type="text" name="telephone" class="form-control" value="<?php echo htmlspecialchars($staff['telephone']); ?>" required />
            </div>
            <div class="col">
                <label>Position</label>
                <input type="text" name="position" class="form-control" value="<?php echo htmlspecialchars($staff['position']); ?>" required />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Current Salary</label>
                <input type="number" step="0.01" name="current_salary" class="form-control" value="<?php echo htmlspecialchars($staff['current_salary']); ?>" required />
            </div>
            <div class="col">
                <label>Salary Scale</label>
                <input type="text" name="salary_scale" class="form-control" value="<?php echo htmlspecialchars($staff['salary_scale']); ?>" required />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Payment Type</label>
                <select name="payment_type" class="form-control" required>
                    <option value="W" <?php if ($staff['payment_type']=='W') echo 'selected'; ?>>Weekly</option>
                    <option value="M" <?php if ($staff['payment_type']=='M') echo 'selected'; ?>>Monthly</option>
                </select>
            </div>
            <div class="col">
                <label>Contract Type</label>
                <select name="contract_type" class="form-control" required>
                    <option value="P" <?php if ($staff['contract_type']=='P') echo 'selected'; ?>>Permanent</option>
                    <option value="T" <?php if ($staff['contract_type']=='T') echo 'selected'; ?>>Temporary</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Hours Per Week</label>
            <input type="number" step="0.01" name="hours_per_week" class="form-control" value="<?php echo htmlspecialchars($staff['hours_per_week']); ?>" required />
        </div>

        <button type="submit" class="btn btn-success btn-success-custom">Update Staff</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
      </form>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
