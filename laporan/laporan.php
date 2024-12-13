<?php 
session_start();

// Periksa apakah user sudah login dan memiliki peran yang benar
if (!isset($_SESSION['ssLogin']) || !in_array($_SESSION['role'], ['admin', 'pengajar'])) {
    header('Location: ../auth/login.php');
    exit();
}

require_once "../config.php";
$title = 'Laporan Mengaji - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

// Initialize search keyword
$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
}

// Fetching data from the database with a search filter
$queryLaporan = mysqli_query($koneksi, "SELECT * FROM tbl_laporan_mengaji WHERE nama LIKE '%$search%' ORDER BY id DESC");

if (!$queryLaporan) {
    die("Query gagal dijalankan: " . mysqli_error($koneksi));
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Daftar Laporan Mengaji</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Laporan Mengaji</li>
            </ol>

            

            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-table"></i> Laporan Mengaji
                    <a href="add-laporan.php" class="btn btn-sm btn-primary float-end ms-1"><i class="fa-solid fa-plus"></i> Tambah Laporan Mengaji</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Pelajaran</th>
                                <th>Guru</th>
                                <th>Laporan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1; // Initialize the counter
                            while ($data = mysqli_fetch_array($queryLaporan)) { ?>
                                <tr>
                                    <td><?= $no++ ?></td> <!-- Display the counter -->
                                    <td><?= htmlspecialchars($data['tanggal']) ?></td>
                                    <td><?= htmlspecialchars($data['nama']) ?></td>
                                    <td><?= htmlspecialchars($data['pelajaran']) ?></td>
                                    <td><?= htmlspecialchars($data['guru']) ?></td>
                                    <td><?= htmlspecialchars($data['laporan']) ?></td>
                                    <td> 
                                        <div class="d-flex gap-2">
                                        <a href="update-laporan.php?id=<?= urlencode($data['id']) ?>" class="btn btn-sm btn-warning" title="Update Laporan Mengaji"><i class="fa-solid fa-pen"></i></a>
                                        <a href="hapus-laporan.php?id=<?= urlencode($data['id']) ?>" class="btn btn-sm btn-danger" title="Hapus Laporan Mengaji" onclick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (mysqli_num_rows($queryLaporan) == 0) { ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data tersedia</td>
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