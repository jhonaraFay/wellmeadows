<?php
// Include database connection
include '../db_connection.php';

// Check if item ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: items.php");
    exit;
}

$item_id = $_GET['id'];

try {
    // Delete the supply item
    $stmt = $conn->prepare("DELETE FROM supply_item WHERE item_id = :id");
    $stmt->execute([':id' => $item_id]);

    // Redirect back to items list
    header("Location: items.php");
    exit;
} catch (PDOException $e) {
    echo "Error deleting item: " . $e->getMessage();
}
?>
