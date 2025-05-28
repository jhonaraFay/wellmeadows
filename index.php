<?php
// Database connection parameters
include 'db_connection.php';


try {
    // Prepare and execute queries to count rows in each table
    $staffCount = $conn->query("SELECT COUNT(*) FROM staff")->fetchColumn();
    $patientCount = $conn->query("SELECT COUNT(*) FROM patient")->fetchColumn();
    $wardCount = $conn->query("SELECT COUNT(*) FROM ward")->fetchColumn();

} catch (connException $e) {
    // Handle connection errors gracefully
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- your head content as before -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellmeadows Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* your styles here */
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
        .content {
            padding: 20px;
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="position-sticky">
                    <h4 class="text-center py-3">Wellmeadows</h4>
                    <a href="index.php">Home</a>
                    <a href="staff/index.php">Staff Management</a>
                    <a href="wards/index.php">Ward Management</a>
                    <a href="patients/index.php">Patient Management</a>
                    <a href="medication/index.php">Medication Management</a>
                    <a href="supplies/items.php">Supplies Management</a>
                    <a href="suppliers/index.php">Suppliers Management</a>
                    <a href="requisitions/index.php">Requisitions</a>
                    <a href="reports/index.php">Reports</a>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4 content">
                <h1 class="mt-4">Dashboard</h1>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Staff</h5>
                                <p class="card-text"><?= htmlspecialchars($staffCount) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Patients</h5>
                                <p class="card-text"><?= htmlspecialchars($patientCount) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Wards</h5>
                                <p class="card-text"><?= htmlspecialchars($wardCount) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <h2>Welcome to Wellmeadows Hospital Management System!</h2>
                    <p>This system allows you to manage Staff, Patients, Wards, Supplies, and more.</p>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
