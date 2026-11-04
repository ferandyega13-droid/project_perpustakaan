
# 📚 Mini Digital Library - Sistem Informasi Perpustakaan Digital

Repositori ini berisi *source code* untuk Tugas Terstruktur Pemrograman Web: **Pengembangan Sistem Informasi Perpustakaan Digital Mini**. Aplikasi ini dibangun menggunakan PHP Native, MySQL, dan UI Framework Bootstrap 5.

---

## 👨‍💻 Identitas Mahasiswa

* **Nama:** Ferandy Ega Putra Pratama
* **NPM / NIM:** 2513020083
* **Program Studi:** Sistem Informasi
* **Mata Kuliah:** Pemrograman Web

---

## 🎥 Video Demo Aplikasi

[![Video Demo YouTube](https://img.shields.io/badge/YouTube-Demo_Aplikasi-red?style=for-the-badge&logo=youtube)](https://youtube.com/...)  
*(Ganti link `https://youtube.com/...` di atas dengan link video YouTube demo aplikasi kamu)*

---

## ⚙️ Fitur Utama Aplikasi

Sistem ini dirancang untuk memenuhi seluruh kriteria dan logika bisnis yang dipersyaratkan:

1. **Autentikasi & Hak Akses (Multi-Role):**
   * **Admin:** Memiliki akses penuh untuk mengelola data (Create, Read, Update, Delete).
   * **Pengunjung:** Hanya memiliki akses *Read-Only* untuk melihat daftar dan stok buku.
   * **Session & Cookie:** Fitur *Remember Me* untuk menyimpan identitas *username* dan *role* pada *browser* secara aman.

2. **Pengelolaan Data Buku (CRUD):**
   * **Create:** Tambah data buku beserta *upload* gambar sampul.
   * **Read:** Tampil daftar koleksi buku dalam bentuk tabel interaktif beserta statistik ketersediaan.
   * **Update:** Mengedit informasi data buku dan memperbarui file sampul (otomatis menghapus file sampul lama).
   * **Delete:** Menghapus data dari MySQL sekaligus menghapus berkas gambar terkait di folder server.

3. **Manajemen Berkas (Upload File):**
   * Validasi tipe/ekstensi file (`.jpg`, `.jpeg`, `.png`).
   * Validasi ukuran berkas maksimal **2MB**.

4. **Logika Bisnis & Ketersediaan:**
   * Penggunaan percabangan (*if-else*) / *Ternary Operator* untuk label status otomatis:
     * Stok $> 0$ $\rightarrow$ **Tersedia**
     * Stok $= 0$ $\rightarrow$ **Dipinjam**

5. **Kategori Koleksi Buku:**
   * Komik / Manga
   * Buku Belajar
   * Novel Fiksi
   * Biografi
   * Majalah

---

## 🗄️ Struktur Tabel Database (`db_perpustakaan`)

File *dump* database tersedia dalam proyek dengan nama file `db_perpustakaan.sql`.

### 1. Tabel `users`
Digunakan untuk manajemen hak akses sistem.

| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | `INT(11)` | Primary Key, Auto Increment |
| `username` | `VARCHAR(50)` | Username pengguna |
| `password` | `VARCHAR(255)` | Password tersimpan (di-hash MD5) |
| `role` | `ENUM('admin','pengunjung')` | Level hak akses pengguna |

### 2. Tabel `buku`
Digunakan untuk menyimpan informasi master data buku.

| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | `INT(11)` | Primary Key, Auto Increment |
| `judul` | `VARCHAR(100)` | Judul buku |
| `kategori` | `VARCHAR(50)` | Kategori koleksi |
| `penulis` | `VARCHAR(100)` | Nama penulis |
| `tahun` | `INT(4)` | Tahun terbit |
| `stok` | `INT(11)` | Jumlah stok tersedia |
| `sampul` | `VARCHAR(255)` | Nama file gambar fisik di folder `/uploads` |

---

## 📂 Struktur Direktori Proyek

```text
project_perpustakaan/
├── config/
│   └── koneksi.php       # Konfigurasi koneksi database MySQL
├── uploads/              # Folder penampung file gambar sampul
├── index.php             # Halaman Login & Form Cookie "Remember Me"
├── proses_login.php      # Verifikasi autentikasi (Session & Cookie)
├── dashboard.php         # Halaman Utama (Read Data & Tampilan Statistik)
├── tambah_buku.php       # Form Input Tambah Data Buku
├── proses_tambah.php     # Query Insert & Operasi Upload File
├── edit_buku.php         # Form Edit Data Buku
├── proses_edit.php       # Query Update & Penggantian File Gambar
├── hapus_buku.php        # Query Delete & Unlink File Gambar Fisik
├── logout.php            # Hapus Session & Cookie
```

---

## 🚀 Panduan Instalasi Lokal

1. Salin seluruh folder `project_perpustakaan` ke dalam direktori server lokal kamu: `C:/xampp/htdocs/`.
2. Buka **XAMPP Control Panel**, lalu jalankan service **Apache** dan **MySQL**.
3. Buka browser dan kunjungi `http://localhost/phpmyadmin`.
4. Buat database baru dengan nama `db_perpustakaan`.
5. Impor file `db_perpustakaan.sql` ke dalam database tersebut.
6. Akses aplikasi melalui URL: `http://localhost/project_perpustakaan/`.

### 🔑 Akun Default Login:
* **Admin:** Username: `admin` | Password: `admin123`
* **Pengunjung:** Username: `andi` | Password: `user123`

---

## 📸 Screenshot Tampilan Aplikasi

*(Untuk menambahkan screenshot di GitHub: drag & drop gambar screenshot kamu langsung ke dalam editor file README.md ini saat mengedit di GitHub)*

### 1. Halaman Login
![Login Page](<img width="1917" height="965" alt="Screenshot 2026-11-04 202642" src="https://github.com/user-attachments/assets/bfb8581d-79b5-4138-9422-f7f97cd5a08d" />)

### 2. Dashboard - Akses Admin (Full CRUD)
![Dashboard Admin](<img width="1917" height="966" alt="Screenshot 2026-11-04 202729" src="https://github.com/user-attachments/assets/cd0a506b-9360-41a0-9064-0013b3db9329" />)

### 3. Dashboard - Akses Pengunjung (Read-Only)
![Dashboard Pengunjung](<img width="1917" height="967" alt="Screenshot 2026-11-04 202802" src="https://github.com/user-attachments/assets/f9b0cc16-d7fb-4d6c-bfa3-87ab115e980b" />)

### 4. Form Tambah & Upload Sampul Buku
![Form Tambah](<img width="1917" height="967" alt="Screenshot 2026-11-04 202828" src="https://github.com/user-attachments/assets/7f5d13a2-4272-4da7-889a-a78cf06669b9" />)

---
*Dibuat untuk memenuhi Tugas Terstruktur Mata Kuliah Pemrograman Web.*
