<?php
// Include database connection
include '../db_connection.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$ward_id = $_GET['id'];

// Delete ward
try {
    $stmt = $conn->prepare("DELETE FROM ward WHERE ward_id = :ward_id");
    $stmt->execute([':ward_id' => $ward_id]);

    // Redirect back to the list after deletion
    header("Location: index.php");
    exit;
} catch (PDOException $e) {
    echo "Error deleting ward: " . $e->getMessage();
}
?>
