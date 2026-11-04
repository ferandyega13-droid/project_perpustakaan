<?php
session_start();
include 'config/koneksi.php';

$user = mysqli_real_escape_string($koneksi, $_POST['username']);
$pass = md5($_POST['password']); 

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($query);
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role']; // Simpan role di session
    
    // Set Cookie
    if (isset($_POST['remember'])) {
        setcookie('perpus_user', $data['username'], time() + (86400 * 30), "/"); 
        setcookie('perpus_role', $data['role'], time() + (86400 * 30), "/"); 
    }
    header("Location: dashboard.php");
} else {
    echo "<script>alert('Username atau password salah!'); window.location='index.php';</script>";
}
?>