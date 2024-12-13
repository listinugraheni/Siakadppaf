<?php
session_start();
require_once "../config.php";

// Pastikan form login disubmit
if (!isset($_POST['ssLogin'])) {
    // Ambil dan sanitasi input
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query untuk memeriksa apakah username ada di database
    $query = "SELECT * FROM tbl_newuser WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);
    
    if (!$result) {
        die("Query gagal dijalankan: " . mysqli_error($koneksi));
    }

    // Ambil data pengguna
    $user = mysqli_fetch_assoc($result);
    
    if ($user && password_verify($password, $user['password'])) {
        // Jika username dan password benar, set session
        $_SESSION['ssLogin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nama'] = $user['nama']; // Menyimpan nama pengguna ke dalam sesi
        $_SESSION['ssUser'] = $user['username']; // Menyimpan username ke dalam sesi
    
        // Redirect berdasarkan role
        if ($user['role'] == 'admin') {
            header('Location: ../index.php');
        } elseif ($user['role'] == 'santri') {
            header('Location: ../santri_dashboard.php');
        } elseif ($user['role'] === 'pengajar') { // Tambahkan pengalihan untuk role pengajar
            header('Location: ../guru_dashboard.php'); 
        } else {
            // Jika role tidak dikenal, redirect ke halaman login dengan pesan error
            header('Location: ../auth/login.php?msg=invalid_role');
        }
        exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
    } else {
        // Jika login gagal, redirect ke halaman login dengan pesan error
        header('Location: ../auth/login.php?msg=invalid_credentials');
        exit();
    }
}
?>
