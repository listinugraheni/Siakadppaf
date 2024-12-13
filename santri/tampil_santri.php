<?php 
// Mulai session
session_start();

// Periksa apakah user sudah login dan memiliki peran yang benar
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] !== 'pengajar') {
    header('Location: ../auth/login.php');
    exit();
}

require_once "../config.php";
$title = "Data Santri - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebarguru.php";

// Query untuk mengambil data santri
$sqlSantri = "SELECT * FROM tbl_newuser WHERE role = 'santri' ORDER BY nama ASC";
$querySantri = $koneksi->query($sqlSantri);

// Mengecek apakah query berhasil
if (!$querySantri) {
    die("Query gagal dijalankan: " . $koneksi->error);
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../pengajar_dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Data Santri</li>
            </ol>
            <div class="card text-center">
                <div class="card-header fs-3">Daftar Santri</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($dataSantri = $querySantri->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($dataSantri['nama']) ?></td>
                                    <td><?= htmlspecialchars($dataSantri['username']) ?></td>
                                    <td><?= htmlspecialchars($dataSantri['telpon']) ?></td>
                                    <td><?= htmlspecialchars($dataSantri['alamat']) ?></td>
                                </tr>
                            <?php } ?>
                            <?php if ($querySantri->num_rows == 0) { ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data santri tersedia</td>
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
