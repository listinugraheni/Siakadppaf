<?php  
session_start();

// Cek apakah user belum login. Jika belum, redirect ke halaman login
if (!isset($_SESSION['ssLogin'])) {
	header("Location: ../auth/login.php");
	exit;
}

require_once "../config.php";

// Proses simpan data guru baru
if (isset($_POST['simpan'])) {
	$nama     = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['nama']));
	$mengajar = mysqli_real_escape_string($koneksi, $_POST['mengajar']);
	$telpon   = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['telpon']));
	$alamat   = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['alamat'])); 
 
	// Query untuk menyimpan data guru baru
	$query = "INSERT INTO tbl_guru (nama, mengajar, telpon, alamat) VALUES ('$nama', '$mengajar', '$telpon', '$alamat')";
	if (mysqli_query($koneksi, $query)) {
		echo "<script>
				alert('Data Guru berhasil disimpan');
				document.location.href = 'add-guru.php';
			</script>";
		exit;
	} else {
		echo "Gagal menyimpan data: " . mysqli_error($koneksi);
	}
}

// Proses update data guru
else if (isset($_POST['update'])) {
	$id      = mysqli_real_escape_string($koneksi, $_POST['id']);
	$nama    = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['nama']));
	$mengajar = mysqli_real_escape_string($koneksi, $_POST['mengajar']);
	$telpon  = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['telpon']));
	$alamat  = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['alamat']));

	// Query untuk mengupdate data guru
	$query = "UPDATE tbl_guru SET nama = '$nama', mengajar = '$mengajar', telpon = '$telpon', alamat = '$alamat' WHERE id = '$id'";
	if (mysqli_query($koneksi, $query)) {
		echo "<script>
				alert('Data Guru berhasil diupdate');
				document.location.href = 'guru.php';
			</script>";
		exit();
	} else {
		echo "Gagal mengupdate data: " . mysqli_error($koneksi);
	}
}
?>
