<?php
include '../db_connection.php';

if (!isset($_GET['id'])) {
    die('Missing patient ID.');
}

$patient_id = $_GET['id'];

try {
    $stmt = $conn->prepare("DELETE FROM patient WHERE patient_id = :id");
    $stmt->execute([':id' => $patient_id]);

    header('Location: index.php');
    exit();

} catch (PDOException $e) {
    die("Error deleting patient: " . $e->getMessage());
}
?>
