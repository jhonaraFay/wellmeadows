<?php
$host = "localhost";
$dbname = "postgres"; // from what you told me earlier
$username = "postgres";
$password = "postgresql";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error connecting to PostgreSQL database: " . $e->getMessage();
}
?>

