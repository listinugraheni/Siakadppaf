<?php  
session_start();

// Cek apakah user belum login. Jika belum, redirect ke halaman login
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config.php";

// Proses update data laporan mengaji
if (isset($_POST['update'])) {
    $id       = mysqli_real_escape_string($koneksi, $_POST['id']);
    $tanggal  = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['tanggal']));
    $nama     = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['nama']));
    $pelajaran = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['pelajaran']));
    $guru     = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['guru']));
    $laporan  = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['laporan']));

    // Query untuk mengupdate data laporan
    $query = "UPDATE tbl_laporan_mengaji SET 
                tanggal = '$tanggal', 
                nama = '$nama', 
                pelajaran = '$pelajaran', 
                guru = '$guru', 
                laporan = '$laporan' 
              WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        // Redirect ke halaman laporan-guru.php dengan pesan sukses
        $_SESSION['success'] = "Laporan Mengaji berhasil diupdate.";
        header("Location: laporan-guru.php");
        exit();
    } else {
        // Jika terjadi kesalahan
        echo "Gagal mengupdate data: " . mysqli_error($koneksi);
    }
} else {
    // Jika form tidak diakses dengan metode POST
    header("Location: laporan-guru.php");
    exit();
}
?>
