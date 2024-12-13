<?php

session_start();

if(!isset($_SESSION['ssLogin'])) {
	header("Location:../auth/login.php");
	exit();
}

require_once "../config.php";

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM tbl_laporan_mengaji WHERE id = '$id'");

echo "<script>
		alert('Laporan berhasil dihapus..');
		document.location.href='laporan.php';
		</script>";
return;

?>