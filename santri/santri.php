<?php

session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("Location:../auth/login.php");
    exit;
}

require_once "../config.php";
$title = "Santri - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

// Ambil parameter pencarian dari query string
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Query SQL untuk mengambil data santri berdasarkan role dan pencarian
$querySantri = "SELECT * FROM tbl_newuser 
                WHERE role = 'santri' 
                AND (nama LIKE '%$searchTerm%' 
                OR telpon LIKE '%$searchTerm%' 
                OR alamat LIKE '%$searchTerm%' 
                OR username LIKE '%$searchTerm%')";

$result = mysqli_query($koneksi, $querySantri);

if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($koneksi));
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Santri</li>
            </ol>
            <div class="card">
                <div class="card-header">
                    <span class="h5 my-2"><i class="fa-solid fa-list"></i> Data Santri</span> 
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Telpon</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <th scope="row"><?= $no++ ?></th>
                                    <td><?= htmlspecialchars($data['nama']) ?></td>
                                    <td><?= htmlspecialchars($data['telpon']) ?></td>
                                    <td><?= htmlspecialchars($data['alamat']) ?></td>
                                    <td align="center">
                                    <a href="update-santri.php?id=<?= urlencode($data['id']) ?>" class="btn btn-sm btn-warning" title="Update Santri"><i class="fa-solid fa-pen"></i></a>
                                        <a href="hapus-santri.php?id=<?= urlencode($data['id']) ?>" class="btn btn-sm btn-danger" title="Hapus Santri" onclick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa-solid fa-trash"></i></a>
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
</div>
