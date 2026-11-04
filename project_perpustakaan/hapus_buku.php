<?php
session_start();
include 'config/koneksi.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') header("Location: dashboard.php");

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT sampul FROM buku WHERE id='$id'");
$data = mysqli_fetch_array($query);
$file_path = "uploads/" . $data['sampul'];

// Menghapus file fisik[cite: 1]
if (file_exists($file_path)) unlink($file_path);

// Menghapus dari database[cite: 1]
mysqli_query($koneksi, "DELETE FROM buku WHERE id='$id'");
header("Location: dashboard.php");
?>