<?php

session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("Location:../auth/login.php");
    exit;
}

require_once "../config.php";
$title = "Data User - TPA PP.AL-FALAH";
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
   Data User berhasil dihapus..
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
// Ambil parameter pencarian dari query string
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Ubah kueri SQL untuk memasukkan filter pencarian
$queryUser = "SELECT * FROM tbl_newuser 
              WHERE (username LIKE '%$searchTerm%' 
              OR nama LIKE '%$searchTerm%' 
              OR telpon LIKE '%$searchTerm%' 
              OR alamat LIKE '%$searchTerm%' 
              OR role LIKE '%$searchTerm%')";

$result = mysqli_query($koneksi, $queryUser);

if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($koneksi));
}

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Data User</li>
            </ol>
            <?php if ($msg != '') {
                echo $alert;
            } ?>

            <div class="card">
                <div class="card-header">
                    <span class="h5 my-2"><i class="fa-solid fa-users"></i> Data User</span>
                    <a href="<?= $main_url ?>auth/register.php" class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i>Tambah User</a>
                </div>
                <div class="card-body">     
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col"><center>Username</center></th>
                                <th scope="col"><center>Nama</center></th>
                                <th scope="col"><center>Telpon</center></th>
                                <th scope="col"><center>Alamat</center></th>
                                <th scope="col"><center>Jenis User</center></th>
                                <th scope="col"><center>Operasi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <th scope="row"><?= $no++ ?></th>
                                    <td><?= htmlspecialchars($data['username']) ?></td>
                                    <td><?= htmlspecialchars($data['nama']) ?></td>
                                    <td><?= htmlspecialchars($data['telpon']) ?></td>
                                    <td><?= htmlspecialchars($data['alamat']) ?></td>
                                    <td><?= htmlspecialchars($data['role']) ?></td>
                                    <td align="center">
                                    <a href="../auth/update-register.php?id=<?= urlencode($data['id']) ?>" class="btn btn-sm btn-warning" title="Update User"><i class="fa-solid fa-pen"></i></a>
                                    <a href="hapus-user.php?id=<?= urlencode($data['id']) ?>" class="btn btn-sm btn-danger" title="Delete User" onclick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php require_once "../template/footer.php"; ?>
</div>
