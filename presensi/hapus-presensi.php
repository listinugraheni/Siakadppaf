<?php

session_start();

if(!isset($_SESSION['ssLogin'])) {
	header("Location:../auth/login.php");
	exit();
}

require_once "../config.php";

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM tbl_presensi WHERE id = '$id'");

echo "<script>
		alert('Data berhasil dihapus..');
		document.location.href='rekap-presensi-guru.php';
		</script>";
return;

?>