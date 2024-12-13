<?php

session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Konfigurasi koneksi database
require_once "../config.php";

// Cek apakah ID atau username diterima dari parameter GET dan valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Hapus data dari tabel dengan ID yang diberikan
    $query = "DELETE FROM tbl_newuser WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Redirect ke halaman user dengan pesan jika berhasil dihapus
            header("Location: user.php?msg=deleted");
        } else {
            // Redirect ke halaman user dengan pesan error jika gagal
            header("Location: user.php?msg=error");
        }

        mysqli_stmt_close($stmt);
    } else {
        // Redirect ke halaman user dengan pesan error jika query gagal disiapkan
        header("Location: user.php?msg=error");
    }
} elseif (isset($_GET['username']) && !empty($_GET['username'])) {
    $username = mysqli_real_escape_string($koneksi, $_GET['username']);

    // Hapus data dari tabel dengan username yang diberikan
    $query = "DELETE FROM tbl_newuser WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Redirect ke halaman user dengan pesan jika berhasil dihapus
            header("Location: user.php?msg=deleted");
        } else {
            // Redirect ke halaman user dengan pesan error jika gagal
            header("Location: user.php?msg=error");
        }

        mysqli_stmt_close($stmt);
    } else {
        // Redirect ke halaman user dengan pesan error jika query gagal disiapkan
        header("Location: user.php?msg=error");
    }
} else {
    // Redirect ke halaman user dengan pesan error jika parameter tidak valid
    header("Location: user.php?msg=invalid_id");
}

mysqli_close($koneksi);
?>