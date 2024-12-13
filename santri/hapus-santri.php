<?php

session_start();

if(!isset($_SESSION['ssLogin'])) {
	header("Location:../auth/login.php");
	exit();
}

require_once "../config.php";

$id = $_GET['nis'];

mysqli_query($koneksi, "DELETE FROM tbl_newuser WHERE nis = '$id'");

echo "<script>
		alert('Data Santri berhasil dihapus..');
		document.location.href='santri.php';
		</script>";
return;

?>