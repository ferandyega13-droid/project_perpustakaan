<?php
session_start();
include 'config/koneksi.php';
if (!isset($_SESSION['username'])) header("Location: index.php");
$isAdmin = ($_SESSION['role'] == 'admin');

// Hitung data statistik
$q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM buku");
$r_total = mysqli_fetch_assoc($q_total)['total'];

$q_ready = mysqli_query($koneksi, "SELECT COUNT(*) as ready FROM buku WHERE stok > 0");
$r_ready = mysqli_fetch_assoc($q_ready)['ready'];

$q_borrowed = mysqli_query($koneksi, "SELECT COUNT(*) as borrowed FROM buku WHERE stok = 0");
$r_borrowed = mysqli_fetch_assoc($q_borrowed)['borrowed'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mini Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .img-thumb { width: 55px; height: 75px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.15); }
        .card-stat { border: none; border-radius: 10px; }
    </style>
</head>
<body>
    <!-- Navbar Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="fa-solid fa-book-open-reader me-2"></i>Digital Library</a>
            <div class="d-flex align-items-center text-white">
                <span class="me-3">
                    <i class="fa-solid fa-circle-user me-1"></i>
                    <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> 
                    <span class="badge bg-light text-dark ms-1"><?php echo ucfirst($_SESSION['role']); ?></span>
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Kartu Ringkasan Statistik -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card card-stat bg-white p-3 shadow-sm border-start border-primary border-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total Koleksi Buku</div>
                            <div class="fs-3 fw-bold"><?php echo $r_total; ?></div>
                        </div>
                        <i class="fa-solid fa-book fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat bg-white p-3 shadow-sm border-start border-success border-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Buku Tersedia</div>
                            <div class="fs-3 fw-bold text-success"><?php echo $r_ready; ?></div>
                        </div>
                        <i class="fa-solid fa-circle-check fa-2x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat bg-white p-3 shadow-sm border-start border-danger border-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Buku Dipinjam (Stok 0)</div>
                            <div class="fs-3 fw-bold text-danger"><?php echo $r_borrowed; ?></div>
                        </div>
                        <i class="fa-solid fa-bookmark fa-2x text-danger opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Buku -->
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-list me-2 text-primary"></i>Daftar Koleksi Buku</h5>
                <?php if ($isAdmin): ?>
                    <a href="tambah_buku.php" class="btn btn-success btn-sm fw-semibold">
                        <i class="fa-solid fa-plus me-1"></i>Tambah Buku Baru
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center ps-4" style="width: 80px;">Sampul</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Stok & Status</th>
                                <?php if ($isAdmin) echo "<th class='text-center'>Aksi</th>"; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");
                            if (mysqli_num_rows($data) > 0) {
                                while ($d = mysqli_fetch_array($data)) {
                                    // Logika Status Ketersediaan Buku (Tersedia / Dipinjam)[cite: 2]
                                    $statusBadge = ($d['stok'] > 0) 
                                        ? "<span class='badge bg-success-subtle text-success border border-success-subtle'>Tersedia ({$d['stok']})</span>" 
                                        : "<span class='badge bg-danger-subtle text-danger border border-danger-subtle'>Dipinjam (0)</span>";
                            ?>
                            <tr>
                                <td class="text-center ps-4">
                                    <img src="uploads/<?php echo $d['sampul']; ?>" class="img-thumb" alt="Sampul">
                                </td>
                                <td><span class="fw-semibold text-dark"><?php echo htmlspecialchars($d['judul']); ?></span></td>
                                <td><span class="badge bg-secondary opacity-75"><?php echo htmlspecialchars($d['kategori']); ?></span></td>
                                <td><?php echo htmlspecialchars($d['penulis']); ?> <small class="text-muted">(<?php echo $d['tahun']; ?>)</small></td>
                                <td><?php echo $statusBadge; ?></td>
                                <?php if ($isAdmin): ?>
                                <td class="text-center">
                                    <a href="edit_buku.php?id=<?php echo $d['id']; ?>" class="btn btn-warning btn-sm me-1" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="hapus_buku.php?id=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data buku ini?')" title="Hapus">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </a>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php 
                                } 
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada koleksi buku.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>