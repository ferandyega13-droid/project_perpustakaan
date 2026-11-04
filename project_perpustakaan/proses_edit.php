<?php
session_start();
include 'config/koneksi.php';

// Proteksi hak akses admin[cite: 1]
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$id       = $_POST['id'];
$judul    = $_POST['judul'];
$kategori = $_POST['kategori'];
$penulis  = $_POST['penulis'];
$tahun    = $_POST['tahun'];
$stok     = $_POST['stok'];

$nama_file   = $_FILES['sampul']['name'];
$ukuran_file = $_FILES['sampul']['size'];
$tmp_file    = $_FILES['sampul']['tmp_name'];

// Opsi 1: Jika admin mengunggah file sampul baru[cite: 1, 2]
if ($nama_file != "") {
    $ext_diizinkan = array('jpg', 'png', 'jpeg');
    $ext           = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    // Validasi ekstensi dan ukuran file maksimal 2MB (2.097.152 bytes)[cite: 2]
    if (in_array($ext, $ext_diizinkan)) {
        if ($ukuran_file < 2097152) { 
            
            // Ambil nama file gambar lama dari database untuk dihapus dari server[cite: 1]
            $query_lama = mysqli_query($koneksi, "SELECT sampul FROM buku WHERE id='$id'");
            $data_lama  = mysqli_fetch_array($query_lama);
            $file_lama  = "uploads/" . $data_lama['sampul'];

            // Hapus file fisik lama jika ada[cite: 1]
            if (file_exists($file_lama)) {
                unlink($file_lama);
            }

            // Simpan file baru ke folder server[cite: 1]
            $nama_file_baru = time() . '_' . $nama_file;
            move_uploaded_file($tmp_file, 'uploads/' . $nama_file_baru);

            // Update database beserta nama file sampul baru[cite: 1]
            mysqli_query($koneksi, "UPDATE buku SET 
                judul='$judul', 
                kategori='$kategori', 
                penulis='$penulis', 
                tahun='$tahun', 
                stok='$stok', 
                sampul='$nama_file_baru' 
                WHERE id='$id'");

            header("Location: dashboard.php");
        } else {
            echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.'); window.location='edit_buku.php?id=$id';</script>";
        }
    } else {
        echo "<script>alert('Format file tidak didukung! Gunakan .jpg atau .png.'); window.location='edit_buku.php?id=$id';</script>";
    }
} else {
    // Opsi 2: Jika admin HANYA mengedit teks tanpa mengganti gambar sampul[cite: 1]
    mysqli_query($koneksi, "UPDATE buku SET 
        judul='$judul', 
        kategori='$kategori', 
        penulis='$penulis', 
        tahun='$tahun', 
        stok='$stok' 
        WHERE id='$id'");

    header("Location: dashboard.php");
}
?>