<?php
session_start();

// Cek apakah user belum login. Jika belum, redirect ke halaman login
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config.php";

// Cek apakah parameter id tersedia di URL
if (isset($_GET['id'])) {
    // Sanitasi input ID agar terhindar dari SQL Injection
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query untuk menghapus data pelajaran berdasarkan id
    $query = "DELETE FROM tbl_mapel WHERE id = '$id'";

    // Eksekusi query dan pengecekan apakah berhasil
    if (mysqli_query($koneksi, $query)) {
        header('Location: pelajaran.php?msg=deleted');
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    // Jika ID tidak ditemukan, redirect kembali ke halaman pelajaran
    header('Location: pelajaran.php?msg=id_not_found');
    exit;
}
?>
