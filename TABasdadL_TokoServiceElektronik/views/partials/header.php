<?php
// views/auth/login.php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../public/index.php");
    exit;
}
$loginAs = $_GET['login_as'] ?? 'admin'; // Default ke admin
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
    <h2>Login</h2>
    <form action="../../controllers/AuthController.php" method="post">
        <input type="hidden" name="action" value="login">
        <label for="login_as">Login As:</label><br>
        <select name="login_as" id="login_as" required>
            <option value="admin" <?php if ($loginAs === 'admin')
                echo 'selected'; ?>>Admin</option>
            <option value="pelanggan" <?php if ($loginAs === 'pelanggan')
                echo 'selected'; ?>>Customer (Email)</option>
            <option value="teknisi" <?php if ($loginAs === 'teknisi')
                echo 'selected'; ?>>Technician (Email)</option>
        </select><br><br>

        <label for="username">Username/Email:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;">Invalid credentials or login type.</p>
    <?php endif; ?>
</body>

</html>