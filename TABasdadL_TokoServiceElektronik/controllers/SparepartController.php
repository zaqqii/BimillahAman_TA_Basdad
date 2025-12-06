<?php
// controllers/SparepartController.php
require_once '../config/database.php';
require_once '../models/Sparepart.php';

$pdo = require_once '../config/database.php';
$sparepartModel = new Sparepart($pdo);

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int) $_POST['id'];
    if ($sparepartModel->delete($id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete spare part.']);
    }
    exit;
}
?>