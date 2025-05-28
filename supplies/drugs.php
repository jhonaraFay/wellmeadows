<?php
// Include database connection
include '../db_connection.php';

// Fetch all pharmaceutical drugs
try {
    $stmt = $conn->query("SELECT * FROM pharmaceutical ORDER BY drug_name");
    $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching drugs: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pharmaceutical Drugs - Supplies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Pharmaceutical Drugs</h2>
        <div>
            <a href="../index.php" class="btn btn-primary">Home</a>
            <a href="add_drug.php" class="btn btn-success">Add New Drug</a>
        </div>
    </div>

    <?php if (count($drugs) > 0): ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Drug Number</th>
                <th>Drug Name</th>
                <th>Dosage</th>
                <th>Method of Administration</th>
                <th>Quantity In Stock</th>
                <th>Reorder Level</th>
                <th>Cost Per Unit</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($drugs as $drug): ?>
            <tr>
                <td><?php echo htmlspecialchars($drug['drug_number']); ?></td>
                <td><?php echo htmlspecialchars($drug['drug_name']); ?></td>
                <td><?php echo htmlspecialchars($drug['dosage']); ?></td>
                <td><?php echo htmlspecialchars($drug['method_of_administration']); ?></td>
                <td><?php echo htmlspecialchars($drug['quantity_in_stock']); ?></td>
                <td><?php echo htmlspecialchars($drug['reorder_level']); ?></td>
                <td>$<?php echo htmlspecialchars(number_format($drug['cost_per_unit'], 2)); ?></td>
                <td>
                    <a href="edit_drug.php?id=<?php echo $drug['drug_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_drug.php?id=<?php echo $drug['drug_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this drug?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No pharmaceutical drugs found.</p>
    <?php endif; ?>
</div>

</body>
</html>
