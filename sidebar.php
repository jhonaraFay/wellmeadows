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
    </style>
<!-- includes/sidebar.php -->
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
        <a href="../requisitions/index.php">Requisitions</a>
        <a href="../reports/index.php">Reports</a>
    </div>
</nav>
