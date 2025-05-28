<?php
// Include database connection
include '../db_connection.php';

// Get drug ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: drugs.php");
    exit;
}

$drug_id = $_GET['id'];

try {
    // Delete the drug
    $stmt = $conn->prepare("DELETE FROM pharmaceutical WHERE drug_id = :id");
    $stmt->execute([':id' => $drug_id]);

    // Redirect back to drug list
    header("Location: drugs.php");
    exit;
} catch (PDOException $e) {
    echo "Error deleting drug: " . $e->getMessage();
}
?>
