<?php  
session_start();

// Cek apakah user belum login. Jika belum, redirect ke halaman login
if (!isset($_SESSION['ssLogin'])) {
	header("Location: ../auth/login.php");
	exit;
}

require_once "../config.php";

// Proses simpan data pelajaran baru
if (isset($_POST['simpan'])) {
	$hari      = htmlspecialchars($_POST['hari']);
	$pelajaran = htmlspecialchars($_POST['pelajaran']);
	$guru      = htmlspecialchars($_POST['guru']);  // Pastikan nilai ini aman

	// Query untuk menyimpan data pelajaran baru
	mysqli_query($koneksi, "INSERT INTO tbl_mapel VALUES (null, '$hari', '$pelajaran', '$guru')");

		header('location:pelajaran.php?msg=added');
		return;
} 
else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $hari = htmlspecialchars($_POST['hari']);
    $pelajaran = htmlspecialchars($_POST['pelajaran']);
    $guru = htmlspecialchars($_POST['guru']);

    $query = "UPDATE `tbl_mapel` SET hari ='$hari', pelajaran='$pelajaran',guru='$guru' WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data pelajaran berhasil diupdate');
                document.location.href = 'pelajaran.php';
              </script>";
              exit();
    } else {
		echo "Gagal mengupdate data. " . mysqli_error($koneksi);
	}
}
?>