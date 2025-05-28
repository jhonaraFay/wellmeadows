<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    die('Missing staff ID.');
}

$staff_id = $_GET['id'];

try {
    $sql = "SELECT delete_staff(:staff_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':staff_id' => $staff_id]);

    header('Location: index.php');
    exit();
} catch (PDOException $e) {
    die("Error deleting staff: " . $e->getMessage());
}
?>
