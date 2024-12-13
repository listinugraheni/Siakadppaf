<?php  
session_start();

// Periksa apakah user sudah login dan memiliki peran yang benar
if (!isset($_SESSION['ssLogin']) || !in_array($_SESSION['role'], ['admin', 'pengajar'])) {
    header('Location: ../auth/login.php');
    exit();
}

require_once "../config.php";
$title = 'Data Presensi - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebarguru.php";

// Ambil filter tanggal dari form pencarian
$tanggal_awal = '';
$tanggal_akhir = '';
if (isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir'])) {
    $tanggal_awal = mysqli_real_escape_string($koneksi, $_GET['tanggal_awal']);
    $tanggal_akhir = mysqli_real_escape_string($koneksi, $_GET['tanggal_akhir']);
}

// Query untuk mendapatkan data Presensi
$queryPresensi = "SELECT p.id, p.tanggal, s.nama, p.status 
                  FROM tbl_presensi p 
                  JOIN tbl_newuser s ON p.santri_id = s.id 
                  WHERE s.role = 'santri'";

if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
    $queryPresensi .= " AND p.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
}

$queryPresensi .= " ORDER BY p.tanggal ASC, s.nama ASC";

$resultPresensi = mysqli_query($koneksi, $queryPresensi);
if (!$resultPresensi) {
    die("Query gagal dijalankan: " . mysqli_error($koneksi));
}

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Presensi Santri TPA</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../guru_dashboard.php">Home</a></li>
                <li class="breadcrumb-item"><a href="Presensi.php">Presensi TPA</a></li>
                <li class="breadcrumb-item active">Data Presensi</li>
            </ol>

            <!-- Tabel Rekapitulasi Presensi -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-table"></i> Data Presensi
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Santri</th>
                                <th>Status Presensi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while ($data = mysqli_fetch_assoc($resultPresensi)) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($data['tanggal']) ?></td>
                                    <td><?= htmlspecialchars($data['nama']) ?></td>
                                    <td><?= htmlspecialchars($data['status']) ?></td>
                                    <td> 
                                        <center>
                                            <a href="update-presensi.php?id=<?= urlencode($data['id']) ?>" class="btn btn-sm btn-warning" title="Update Data Presensi">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="hapus-presensi.php?id=<?= urlencode($data['id']) ?>" class="btn btn-sm btn-danger" title="Hapus Data Presensi" onclick="return confirm('Anda yakin akan menghapus data ini?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </center>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (mysqli_num_rows($resultPresensi) == 0) { ?>
                                <tr>
                                    <td colspan="7" class="text-center">Data Presensi tidak ditemukan</td>
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
