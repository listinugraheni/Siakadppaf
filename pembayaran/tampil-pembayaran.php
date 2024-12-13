<?php
session_start();

// Pastikan hanya santri yang dapat mengakses halaman ini
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] != 'santri') {
    header('location:../auth/login.php');
    exit();
}

require_once "../config.php"; // Pastikan path ke config.php sudah benar
$title = 'Laporan Pembayaran - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebarsantri.php"; // Sidebar untuk santri

$nama = $_SESSION['nama']; // Ambil nama dari session pengguna yang login

// Membatasi hasil per halaman
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil keyword dari search bar
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

// Query untuk mengambil data pembayaran berdasarkan user login dan keyword
$sql = "SELECT * FROM tbl_pembayaran 
        WHERE nama = ? AND (tanggal_pembayaran LIKE ? OR jumlah LIKE ? OR status LIKE ?) 
        ORDER BY tanggal_pembayaran DESC 
        LIMIT ? OFFSET ?";

$searchTerm = "%$search%";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param('ssssii', $nama, $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
$stmt->execute();
$queryPembayaran = $stmt->get_result();

// Menghitung total data untuk pagination
$total_sql = "SELECT COUNT(*) as total FROM tbl_pembayaran 
              WHERE nama = ? AND (tanggal_pembayaran LIKE ? OR jumlah LIKE ? OR status LIKE ?)";
$total_stmt = $koneksi->prepare($total_sql);
$total_stmt->bind_param('ssss', $nama, $searchTerm, $searchTerm, $searchTerm);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Laporan Pembayaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../santri_dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Laporan Pembayaran</li>
            </ol>
            <div class="card">
                <div class="card-header fs-3 text-center">Laporan Pembayaran</div>
                <div class="card-body">
                    <!-- Search bar -->
                    <form method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari pembayaran..." value="<?= htmlspecialchars($search) ?>">
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-search"></i> Cari</button>
                        </div>
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Tanggal Pembayaran</center></th>
                                <th><center>Nama</center></th>
                                <th><center>Jumlah</center></th>
                                <th><center>Status</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = $offset + 1;
                            while ($data = $queryPembayaran->fetch_assoc()) { 
                                $tanggalFormatted = strftime('%d %B %Y', strtotime($data['tanggal_pembayaran']));
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($tanggalFormatted) ?></td>
                                    <td><?= htmlspecialchars($data['nama']) ?></td>
                                    <td><?= htmlspecialchars(number_format($data['jumlah'], 0, ',', '.')) ?></td>
                                    <td><?= htmlspecialchars($data['status']) ?></td>
                                </tr>
                            <?php } ?>
                            <?php if ($queryPembayaran->num_rows == 0) : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data pembayaran</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= htmlspecialchars($search) ?>" aria-label="Previous">
                                    &laquo;
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= htmlspecialchars($search) ?>" aria-label="Next">
                                    &raquo;
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>

    <?php require_once "../template/footer.php"; ?>
</div>
