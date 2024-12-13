<?php
session_start();
require_once "../config.php";

// Proses tambah user
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $telpon = mysqli_real_escape_string($koneksi, $_POST['telpon']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO tbl_newuser (username, password, nama, telpon, alamat, role) 
              VALUES ('$username', '$password_hash', '$nama', '$telpon', '$alamat', '$role')";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success_message'] = "User berhasil ditambahkan.";
        header("location: ../user/user.php");
    } else {
        $_SESSION['error_message'] = "Gagal menambahkan user: " . mysqli_error($koneksi);
        header("location: register.php");
    }
    exit();
}

// Proses update user
if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $telpon = mysqli_real_escape_string($koneksi, $_POST['telpon']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    $update_query = "UPDATE tbl_newuser 
                     SET username = '$username', 
                         nama = '$nama', 
                         telpon = '$telpon', 
                         alamat = '$alamat', 
                         role = '$role'";

    // Update password jika diisi
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $update_query .= ", password = '$password_hash'";
    }

    $update_query .= " WHERE id = '$id'";

    if (mysqli_query($koneksi, $update_query)) {
        $_SESSION['success_message'] = "User berhasil diperbarui.";
        header("location: ../user/user.php");
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui user: " . mysqli_error($koneksi);
        header("location: update-register.php?id=$id");
    }
    exit();
}
?>
