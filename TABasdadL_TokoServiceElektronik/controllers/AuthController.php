<?php
// controllers/AuthController.php
require_once '../models/User.php';

$pdo = require_once '../config/database.php';
$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $loginAs = $_POST['login_as']; // 'admin', 'pelanggan', 'teknisi'

    $success = false;
    if ($loginAs === 'admin') {
        $success = $userModel->authenticateAdmin($username, $password);
    } elseif ($loginAs === 'pelanggan') {
        $success = $userModel->authenticatePelanggan($username, $password); // Gunakan email
    } elseif ($loginAs === 'teknisi') {
        $success = $userModel->authenticateTeknisi($username, $password); // Gunakan email
    }

    if ($success) {
        header("Location: ../public/index.php");
        exit;
    } else {
        header("Location: ../views/auth/login.php?error=1&login_as=" . urlencode($loginAs));
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../views/auth/login.php");
    exit;
}
?>