<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Cek apakah user memiliki hak akses yang benar (admin atau pengajar)
if (!in_array($_SESSION['role'], ['admin', 'pengajar'])) {
    echo "Akses ditolak. Hanya admin atau pengajar yang dapat melakukan pembaruan.";
    exit;
}

require_once "../config.php";

// Periksa apakah data dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Ambil data dari form
    $id = isset($_POST['id']) ? intval($_POST['id']) : '';
    $tanggal = isset($_POST['tanggal']) ? mysqli_real_escape_string($koneksi, trim($_POST['tanggal'])) : '';
    $status = isset($_POST['status']) ? mysqli_real_escape_string($koneksi, htmlspecialchars(trim($_POST['status']))) : '';

    // Validasi input
    if (empty($id) || empty($tanggal) || empty($status)) {
        header("Location: rekap-presensi-guru.php?error=missing_data");
        exit();
    }

    // Query untuk mengupdate data presensi
    $query = "UPDATE tbl_presensi SET tanggal = '$tanggal', status = '$status' WHERE id = $id";
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, redirect ke halaman rekap-presensi dengan pesan sukses
        header("Location: rekap-presensi-guru.php?success=update");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal mengupdate data presensi: " . mysqli_error($koneksi);
    }
} else {
    // Jika metode bukan POST atau data tidak sesuai, redirect ke halaman utama
    header("Location: rekap-presensi-guru.php?error=invalid_request");
    exit();
}

// Tutup koneksi
$koneksi->close();
?>
