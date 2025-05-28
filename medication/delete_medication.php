<?php
// Include database connection
include '../db_connection.php';

// Check if medication_id is provided
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$medication_id = $_GET['id'];

// Delete medication
try {
    $stmt = $conn->prepare("DELETE FROM medication WHERE medication_id = :medication_id");
    $stmt->execute([':medication_id' => $medication_id]);

    // Redirect back after deletion
    header("Location: index.php");
    exit;
} catch (PDOException $e) {
    echo "Error deleting medication: " . $e->getMessage();
}
?>
