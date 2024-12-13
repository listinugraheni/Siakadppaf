<?php
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config.php";

// Pastikan parameter ID diterima melalui metode GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Query untuk menghapus data pembayaran berdasarkan ID
    $deleteQuery = "DELETE FROM tbl_pembayaran WHERE id = $id";
    if (mysqli_query($koneksi, $deleteQuery)) {
        // Jika berhasil, redirect dengan pesan sukses
        header("Location: pembayaran.php?msg=deleted");
        exit;
    } else {
        // Jika gagal, tampilkan pesan error
        $error = "Gagal menghapus data pembayaran: " . mysqli_error($koneksi);
    }
} else {
    // Jika parameter ID tidak valid, redirect ke halaman pembayaran
    header("Location: pembayaran.php?msg=invalid-id");
    exit;
}
?>
