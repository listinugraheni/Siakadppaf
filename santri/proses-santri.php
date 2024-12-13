<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Cek apakah user adalah admin
if ($_SESSION['role'] !== 'admin') {
    echo "Akses ditolak. Hanya admin yang dapat melakukan pembaruan.";
    exit;
}

require_once "../config.php";
$id = isset($_GET['id']) ? $_GET['id'] : '';
$nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$telpon = isset($_POST['telpon']) ? $_POST['telpon'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';


// Check if data is being posted correctly
if (isset($_POST['update'])) {
    $id      = mysqli_real_escape_string($koneksi, $_POST['id']);
	$nama    = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['nama']));
	$telpon  = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['telpon']));
	$alamat  = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['alamat']));

	// Query untuk mengupdate data guru
	$query = "UPDATE tbl_newuser SET nama = '$nama',  telpon = '$telpon', alamat = '$alamat' WHERE id = '$id'";
	if (mysqli_query($koneksi, $query)) {
		echo "<script>
				alert('Data berhasil diupdate');
				document.location.href = 'santri.php';
			</script>";
		exit();
	} else {
		echo "Gagal mengupdate data: " . mysqli_error($koneksi);
	}
}

$koneksi->close();
?>
