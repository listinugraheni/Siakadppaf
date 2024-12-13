<?php 

session_start();

if (!isset($_SESSION['ssLogin'])) {
	header("location: ../auth/login.php");
	exit();
}

require_once "../config.php";
$title = " Guru - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = "";
}

$alert = '';
if ($msg == 'deleted') {
    $alert ='<div class="alert alert-danger alert-dismissible fade show" role="alert">
   Data Guru berhasil dihapus..
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

?>

<div id="layoutSidenav_content">
              <main>
                 <div class="container-fluid px-4">
                   <h1 class="mt-4">Guru</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                        <li class="breadcrumb-item active">Guru</li>
                    </ol>

                    <?php if ($msg != "") {
                        echo $alert;
                    } ?>

                    <div class="card">
                    	<div class="card-header">
                    		<i class="fa-solid fa-list"></i> Data Guru
                    		<a href="<?= $main_url ?>guru/add-guru.php" class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i>Tambah Guru</a>
                    	</div>
                    	<div class="card-body">
                    		<table class="table table-hover" id="datatablesSimple">
  <thead>
    <tr>
      <th scope="col"><center>No</center></th>
      <th scope="col"><center>Nama</center></th>
      <th scope="col"><center>Mengajar</center></th>
      <th scope="col"><center>Telpon</center></th>
      <th scope="col"><center>Alamat</center></th>
      <th scope="col"><center>Operasi</center></th>
    </tr>
  </thead>
  <tbody>
  	<?php 
  	$no = 1;
  	$queryGuru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
  	while ($data = mysqli_fetch_array($queryGuru)) {
  	
  	?>
    <tr>
      <th scope="row"><?= $no++ ?></th>
      <td><?= $data ['nama'] ?></td>
      <td><?= $data ['mengajar'] ?></td>
      <td><?= $data ['telpon'] ?></td>
      <td><?= $data ['alamat'] ?></td>
      <td align="center">
      	<a href="edit-guru.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen" title="Update Guru"></i></a>
      	<a href="hapus-guru.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-danger" title="Hapus Guru" onclick="return confirm ('Anda yakin akan menghapus data ini ?')"><i class="fa-solid fa-trash"></i></a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
                    	</div>
                    </div>
                </div>
            </main>

  
<?php

require_once "../template/footer.php";

?>
