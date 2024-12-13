<?php    
session_start();

// Periksa apakah user sudah login dan memiliki peran 'santri'
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] !== 'santri') {
    header('Location: ../auth/login.php');
    exit();
}

require_once "../config.php";
$title = 'Data presensi - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebarsantri.php";

// Ambil ID pengguna dari sesi
$santriId = $_SESSION['user_id']; // Pastikan 'user_id' adalah key yang digunakan untuk menyimpan ID pengguna

// Ambil keyword pencarian
$searchKeyword = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Query untuk mendapatkan data presensi hanya untuk santri yang sedang login
$querypresensi = "SELECT p.tanggal, p.status 
                  FROM tbl_presensi p 
                  JOIN tbl_newuser s ON p.santri_id = s.id 
                  WHERE s.role = 'santri' AND s.id = '$santriId'";

if (!empty($searchKeyword)) {
    $querypresensi .= " AND (p.tanggal LIKE '%$searchKeyword%' OR p.status LIKE '%$searchKeyword%')";
}

$querypresensi .= " ORDER BY p.tanggal ASC";

$resultpresensi = mysqli_query($koneksi, $querypresensi);
if (!$resultpresensi) {
    die("Query gagal dijalankan: " . mysqli_error($koneksi));
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Presensi Saya</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../santri_dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Data Presensi</li>
            </ol>

            <!-- Search Bar -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-search"></i> Cari Data Presensi
                </div>
                <div class="card-body">
                    <form action="rekap-presensi.php" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan tanggal atau status..." value="<?= htmlspecialchars($searchKeyword) ?>">
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-search"></i> Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Rekapitulasi Presensi -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-table"></i> Data Presensi
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Status Presensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while ($data = mysqli_fetch_assoc($resultpresensi)) { 
                                // Format tanggal dari YYYY-MM-DD ke DD/MM/YYYY
                                $tanggalFormatted = date("d/m/Y", strtotime($data['tanggal']));
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($tanggalFormatted) ?></td>
                                    <td><?= htmlspecialchars($data['status']) ?></td>
                                </tr>
                            <?php } ?>
                            <?php if (mysqli_num_rows($resultpresensi) == 0) { ?>
                                <tr>
                                    <td colspan="3" class="text-center">Data presensi tidak ditemukan</td>
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
