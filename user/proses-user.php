<?php
// Mulai sesi
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['sslogin'])) {
    header("Location:../auth/login.php");
    exit;
}

// Sertakan file konfigurasi untuk koneksi database
require_once "../config.php";

// Cek apakah form telah disubmit
if (isset($_POST['simpan'])) {
    // Ambil dan bersihkan input dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jenisuser = mysqli_real_escape_string($koneksi, $_POST['jenisuser']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $password = '1234'; // Password default
    $pass = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $query = "SELECT * FROM tbl_user WHERE username = ?";
    if ($stmt = mysqli_prepare($koneksi, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Jika username sudah ada
            header("Location: user.php?msg=cancel");
        } else {
            // Insert data jika username belum ada
            $query = "INSERT INTO tbl_user (username, nama, jenisuser, alamat, password) VALUES (?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($koneksi, $query)) {
                mysqli_stmt_bind_param($stmt, 'sssss', $username, $nama, $jenisuser, $alamat, $pass);
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: user.php?msg=added");
                } else {
                    echo "Gagal menyimpan data. " . mysqli_stmt_error($stmt);
                }
            }
        }

        mysqli_stmt_close($stmt);
    }

    // Tutup koneksi
    mysqli_close($koneksi);
}
?>
