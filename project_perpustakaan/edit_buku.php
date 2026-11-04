<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id='$id'");
$d = mysqli_fetch_array($query);
if (!$d) { header("Location: dashboard.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku - Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Edit Data Buku</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul Buku</label>
                                <input type="text" name="judul" class="form-control" value="<?php echo htmlspecialchars($d['judul']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kategori Buku</label>
                                <select name="kategori" class="form-select">
                                    <option value="Komik/Manga" <?php if($d['kategori'] == 'Komik/Manga') echo 'selected'; ?>>Komik/Manga</option>
                                    <option value="Buku Belajar" <?php if($d['kategori'] == 'Buku Belajar') echo 'selected'; ?>>Buku Belajar</option>
                                    <option value="Novel Fiksi" <?php if($d['kategori'] == 'Novel Fiksi') echo 'selected'; ?>>Novel Fiksi</option>
                                    <option value="Biografi" <?php if($d['kategori'] == 'Biografi') echo 'selected'; ?>>Biografi</option>
                                    <option value="Majalah" <?php if($d['kategori'] == 'Majalah') echo 'selected'; ?>>Majalah</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Penulis</label>
                                    <input type="text" name="penulis" class="form-control" value="<?php echo htmlspecialchars($d['penulis']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Tahun Terbit</label>
                                    <input type="number" name="tahun" class="form-control" value="<?php echo $d['tahun']; ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jumlah Stok</label>
                                <input type="number" name="stok" class="form-control" value="<?php echo $d['stok']; ?>" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Sampul Saat Ini</label><br>
                                <img src="uploads/<?php echo $d['sampul']; ?>" class="rounded shadow-sm" width="70" alt="Sampul Lama">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Ganti Sampul (Opsional, Maks 2MB)</label>
                                <input type="file" name="sampul" class="form-control" accept="image/png, image/jpeg">
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="dashboard.php" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Batal</a>
                                <button type="submit" class="btn btn-warning px-4 fw-semibold"><i class="fa-solid fa-arrows-rotate me-1"></i>Update Buku</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>