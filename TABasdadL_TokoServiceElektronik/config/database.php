<?php
// config/database.php
$host = 'localhost';
$port = '5433';
$dbname = 'aplikasi_service_elektronik'; // Ganti dengan nama database Anda
$username = 'postgres';    // Ganti dengan username Anda
$password = 'sekiro25'; // Ganti dengan password Anda

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>