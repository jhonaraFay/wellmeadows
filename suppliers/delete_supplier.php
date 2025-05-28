<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    echo "Supplier ID is missing!";
    exit;
}

$supplier_id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM supplier WHERE supplier_id = :supplier_id");
$result = $stmt->execute([':supplier_id' => $supplier_id]);

if ($result) {
    echo "<script>alert('Supplier deleted successfully!'); window.location.href='index.php';</script>";
} else {
    echo "Error deleting supplier.";
}
?>

