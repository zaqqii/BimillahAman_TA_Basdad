<?php
// config/database.php
$host = 'localhost';
$port = '5433';
$dbname = 'your_database_name'; // Ganti dengan nama database Anda
$username = 'your_db_user';    // Ganti dengan username Anda
$password = 'your_db_password'; // Ganti dengan password Anda

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>