<?php
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config.php";

$title = 'Laporan Pembayaran - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

// Set locale ke Bahasa Indonesia
setlocale(LC_TIME, 'id_ID.UTF-8');

// Query untuk mengambil data dari tabel tbl_pembayaran
$query = "SELECT id, nama, tanggal_pembayaran, jumlah, status FROM tbl_pembayaran ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Error dalam query: " . mysqli_error($koneksi));
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Laporan Pembayaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Laporan Pembayaran</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-money-check-dollar"></i> Laporan Pembayaran
                    <a href="add-pembayaran.php" class="btn btn-primary float-end ms-1"><i class="fa-solid fa-plus"></i> Tambah Pembayaran</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) { 
                                // Ubah format tanggal
                                $tanggal_pembayaran = $row['tanggal_pembayaran'] 
                                    ? strftime('%d %B %Y', strtotime($row['tanggal_pembayaran'])) 
                                    : 'Belum Dibayar';
                            ?>
                                <tr>
                                    <td><center><?= $no++ ?></center></td>
                                    <td><center><?= htmlspecialchars($tanggal_pembayaran) ?></center></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><center><?= htmlspecialchars(number_format($row['jumlah'], 0, ',', '.')) ?></center></td>
                                    <td><center><?= htmlspecialchars($row['status']) ?></center></td> 
                                    <td>
                                        <center>
                                            <a href="update-pembayaran.php?id=<?= $row['id'] ?>" 
                                               class="btn btn-sm btn-warning" 
                                               title="Update Pembayaran">
                                               <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="hapus-pembayaran.php?id=<?= $row['id'] ?>" 
                                               class="btn btn-sm btn-danger" 
                                               title="Hapus Pembayaran" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                               <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </center>
                                        </div>
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
