<?php  
session_start();

// Periksa apakah user sudah login dan memiliki peran yang benar
if (!isset($_SESSION['ssLogin']) || !in_array($_SESSION['role'], ['admin', 'pengajar'])) {
    header('Location: ../auth/login.php');
    exit();
}

require_once "../config.php";
$title = 'Rekap Presensi - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

// Ambil kata kunci pencarian dari form search bar
$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
}

// Query untuk mendapatkan data presensi
$queryPresensi = "SELECT p.tanggal, s.nama, p.status 
                  FROM tbl_presensi p 
                  JOIN tbl_newuser s ON p.santri_id = s.id 
                  WHERE s.role = 'santri'";

if (!empty($search)) {
    $queryPresensi .= " AND (s.nama LIKE '%$search%' OR p.status LIKE '%$search%')";
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
            <h1 class="mt-4">Data Presensi Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Data Presensi</li>
            </ol>
            <div class="card">
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
                                <th>Status Kehadiran</th>
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
                                    
                                </tr>
                            <?php } ?>
                            <?php if (mysqli_num_rows($resultPresensi) == 0) { ?>
                                <tr>
                                    <td colspan="7" class="text-center">Data presensi tidak ditemukan</td>
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
