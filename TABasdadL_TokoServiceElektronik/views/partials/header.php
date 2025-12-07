<?php
// views/partials/header.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<nav>
    <!-- 🔥 Tambahin link ke Beranda -->
    <a href="../../index.php">🏠 Beranda</a>
    <a href="../public/index.php">📊 Dashboard</a> <!-- Sesuai file lo -->

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="../customers/list.php">👥 Pelanggan</a>
        <a href="../technicians/list.php">🔧 Teknisi</a>
        <a href="../spareparts/list.php">⚙️ Spare Part</a>
        <a href="../reports/index.php">📈 Laporan</a>
        <a href="../database_features/performance.php">💾 Fitur DB</a>
    <?php endif; ?>

    <!-- Tambah link lain sesuai role -->
    <a href="../services/list.php">📋 Service</a>

    <form style="display:inline;" action="../../controllers/AuthController.php" method="post">
        <input type="hidden" name="action" value="logout">
        <button type="submit">Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)</button>
    </form>
</nav>
<hr>