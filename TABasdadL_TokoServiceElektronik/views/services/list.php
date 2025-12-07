<?php
// views/services/list.php
require_once '../../config/database.php';
require_once '../../models/Service.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$serviceModel = new Service($pdo);
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = $_GET['search'] ?? '';
$filterStatus = $_GET['status'] ?? '';
$filterTeknisi = $_GET['teknisi'] ?? '';

$services = $serviceModel->getServices($limit, $offset, $search, $filterStatus, $filterTeknisi);
$totalServices = $serviceModel->countServices($search, $filterStatus, $filterTeknisi);
$totalPages = ceil($totalServices / $limit);

// Ambil status untuk filter dropdown
$stmt = $pdo->prepare("SELECT id_status, nama_status FROM status_perbaikan ORDER BY nama_status");
$stmt->execute();
$statusOptions = $stmt->fetchAll();

// Ambil teknisi untuk filter dropdown (hanya aktif)
$stmt = $pdo->prepare("SELECT id_teknisi, nama_teknisi FROM teknisi WHERE status_aktif = TRUE ORDER BY nama_teknisi");
$stmt->execute();
$teknisiOptions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Services List</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <script src="../../public/js/main.js"></script>
</head>
<body>
    <?php include '../../views/partials/header.php'; ?>
    <h1>Service List</h1>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="create.php">Add New Service</a>
    <?php endif; ?>
    <form method="GET" action="">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by complaint, customer, or technician...">
        <select name="status">
            <option value="">All Status</option>
            <?php foreach ($statusOptions as $status): ?>
                <option value="<?php echo $status['id_status']; ?>" <?php if($filterStatus == $status['id_status']) echo 'selected'; ?>><?php echo htmlspecialchars($status['nama_status']); ?></option>
            <?php endforeach; ?>
        </select>
        <select name="teknisi">
            <option value="">All Technicians</option>
            <?php foreach ($teknisiOptions as $teknisi): ?>
                <option value="<?php echo $teknisi['id_teknisi']; ?>" <?php if($filterTeknisi == $teknisi['id_teknisi']) echo 'selected'; ?>><?php echo htmlspecialchars($teknisi['nama_teknisi']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Device</th>
                <th>Complaint</th>
                <th>Est. Cost</th>
                <th>Status</th>
                <th>Technician</th>
                <th>Received</th>
                <th>Completed</th>
                <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'teknisi'): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $s): ?>
            <tr>
                <td><?php echo htmlspecialchars($s['id_service']); ?></td>
                <td><?php echo htmlspecialchars($s['nama_pelanggan']); ?></td>
                <td><?php echo htmlspecialchars($s['jenis_perangkat']) . ' ' . htmlspecialchars($s['merek']) . ' ' . htmlspecialchars($s['model']); ?></td>
                <td><?php echo htmlspecialchars($s['keluhan']); ?></td>
                <td>$<?php echo number_format($s['biaya_service'], 2); ?></td>
                <td><?php echo htmlspecialchars($s['nama_status']); ?></td>
                <td><?php echo htmlspecialchars($s['nama_teknisi'] ?? 'Unassigned'); ?></td>
                <td><?php echo $s['tanggal_masuk']; ?></td>
                <td><?php echo $s['tanggal_selesai']; ?></td>
                <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'teknisi'): ?>
                    <td>
                        <a href="track.php?id=<?php echo $s['id_service']; ?>">View/Update</a>
                    </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($filterStatus); ?>&teknisi=<?php echo urlencode($filterTeknisi); ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
    <?php if (isset($_GET['msg'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php endif; ?>
    <?php include '../../views/partials/footer.php'; ?>
</body>
</html>