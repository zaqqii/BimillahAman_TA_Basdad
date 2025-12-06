<?php
// controllers/CustomerController.php
require_once '../config/database.php';
require_once '../models/Pelanggan.php';

$pdo = require_once '../config/database.php';
$pelangganModel = new Pelanggan($pdo);

session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'teknisi')) {
    header("Location: ../views/auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int) $_POST['id'];
    if ($pelangganModel->delete($id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete customer.']);
    }
    exit;
}

// Tambahkan action lain jika diperlukan, misalnya untuk update AJAX
?>