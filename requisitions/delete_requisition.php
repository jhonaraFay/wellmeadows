<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    echo "Requisition ID is missing.";
    exit;
}

$requisition_id = $_GET['id'];

// Delete the requisition
$stmt = $conn->prepare("DELETE FROM requisition WHERE requisition_id = :id");
$result = $stmt->execute([':id' => $requisition_id]);

if ($result) {
    echo "<script>alert('Requisition deleted successfully!'); window.location.href='index.php';</script>";
} else {
    echo "Error deleting requisition.";
}
?>
