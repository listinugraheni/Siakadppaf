<?php  

session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] != 'pengajar') {
    header('Location: ../auth/login.php');
    exit();
}

// Konfigurasi koneksi database
require_once "../config.php";

// Cek apakah tombol 'simpan' sudah diklik
if (isset($_POST['simpan'])) {
    // Ambil dan bersihkan input dari formulir
    $curPass = trim(htmlspecialchars($_POST['curPass']));
    $newPass = trim(htmlspecialchars($_POST['newPass']));
    $confPass = trim(htmlspecialchars($_POST['confPass']));

    // Ambil username dari sesi pengguna
    $username = $_SESSION['ssUser'];

    // Ambil data pengguna berdasarkan username dari tabel tbl_newuser
    $queryUser = mysqli_query($koneksi, "SELECT * FROM tbl_newuser WHERE username = '$username'");
    $data = mysqli_fetch_array($queryUser);

    // Cek apakah password baru dan konfirmasi password baru cocok
    if ($newPass !== $confPass) {
        header("Location: ganti-password-guru.php?msg=err1");
        exit;
    }

    // Cek apakah password saat ini cocok dengan password yang ada di database
    if (!password_verify($curPass, $data['password'])) {
        header("Location: ganti-password-guru.php?msg=err2");
        exit;
    } else {
        // Hash password baru dan perbarui di database
        $pass = password_hash($newPass, PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE tbl_newuser SET password = '$pass' WHERE username = '$username'");
        header('Location: ganti-password-guru.php?msg=updated');
        exit;
    }
}
?>
