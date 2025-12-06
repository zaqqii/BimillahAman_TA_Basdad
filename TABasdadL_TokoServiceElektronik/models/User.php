<?php
// models/User.php
require_once '../config/database.php';

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Authenticate Admin
    public function authenticateAdmin($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT id_admin as id, username, password as password_hash, nama_admin as name, 'admin' as role FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            return true;
        }
        return false;
    }

    // Authenticate Pelanggan (disarankan login via email)
    public function authenticatePelanggan($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT id_pelanggan as id, email as username, password as password_hash, nama as name, 'pelanggan' as role FROM pelanggan WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            return true;
        }
        return false;
    }

    // Authenticate Teknisi (disarankan login via email)
    public function authenticateTeknisi($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT id_teknisi as id, email as username, password as password_hash, nama_teknisi as name, 'teknisi' as role FROM teknisi WHERE email = ? AND status_aktif = TRUE");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            return true;
        }
        return false;
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
}
?>