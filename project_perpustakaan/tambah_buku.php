<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku - Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-plus-circle me-2"></i>Tambah Data Buku Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul Buku</label>
                                <input type="text" name="judul" class="form-control" placeholder="Contoh: One Piece Vol. 100" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kategori Buku</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="Komik/Manga">Komik/Manga</option>
                                    <option value="Buku Belajar">Buku Belajar</option>
                                    <option value="Novel Fiksi">Novel Fiksi</option>
                                    <option value="Biografi">Biografi</option>
                                    <option value="Majalah">Majalah</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Penulis</label>
                                    <input type="text" name="penulis" class="form-control" placeholder="Nama penulis" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Tahun Terbit</label>
                                    <input type="number" name="tahun" class="form-control" placeholder="2024" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jumlah Stok</label>
                                <input type="number" name="stok" class="form-control" placeholder="0" min="0" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">File Sampul (.jpg / .png, Maks 2MB)</label>
                                <input type="file" name="sampul" class="form-control" accept="image/png, image/jpeg" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="dashboard.php" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i>Batal</a>
                                <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-1"></i>Simpan Buku</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>