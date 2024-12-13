<?php
session_start();

// Pastikan hanya santri yang dapat mengakses halaman ini
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] != 'santri') {
    header('location:../auth/login.php');
    exit();
}

require_once "../config.php"; // Pastikan path ke config.php sudah benar
$title = 'Laporan Mengaji - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebarsantri.php"; // Pastikan path ke file sidebar santri sudah benar

$nama = $_SESSION['nama']; // Ambil username dari session
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil keyword pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data berdasarkan pencarian dan nama
$sql = "SELECT * FROM tbl_laporan_mengaji 
        WHERE nama = ? AND 
        (pelajaran LIKE ? OR guru LIKE ? OR laporan LIKE ?) 
        ORDER BY tanggal DESC 
        LIMIT ? OFFSET ?";
$stmt = $koneksi->prepare($sql);
$searchKeyword = "%" . $search . "%";
$stmt->bind_param('ssssii', $nama, $searchKeyword, $searchKeyword, $searchKeyword, $limit, $offset);
$stmt->execute();
$queryLaporan = $stmt->get_result();

// Hitung total data untuk pagination
$total_sql = "SELECT COUNT(*) as total FROM tbl_laporan_mengaji 
              WHERE nama = ? AND 
              (pelajaran LIKE ? OR guru LIKE ? OR laporan LIKE ?)";
$total_stmt = $koneksi->prepare($total_sql);
$total_stmt->bind_param('ssss', $nama, $searchKeyword, $searchKeyword, $searchKeyword);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Laporan Mengaji</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../santri_dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Laporan Mengaji</li>
            </ol>
            <div class="card">
                <div class="card-header fs-3 text-center">Laporan Mengaji</div>
                <div class="card-body">
                    <form method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari pelajaran, guru, atau laporan..." value="<?= htmlspecialchars($search) ?>">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Tanggal</center></th>
                                <th><center>Nama</center></th>
                                <th><center>Pelajaran</center></th>
                                <th><center>Guru</center></th>
                                <th><center>Laporan</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = $offset + 1;
                            while ($data = $queryLaporan->fetch_assoc()) { ?>
                                <tr>
                                    <th scope="row"><?= $no++ ?></th>
                                    <td><?= htmlspecialchars($data['tanggal']) ?></td>
                                    <td><?= htmlspecialchars($data['nama']) ?></td>
                                    <td><?= htmlspecialchars($data['pelajaran']) ?></td>
                                    <td><?= htmlspecialchars($data['guru']) ?></td>
                                    <td><?= htmlspecialchars($data['laporan']) ?></td>
                                </tr>
                            <?php } ?>
                            <?php if ($queryLaporan->num_rows == 0) { ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data ditemukan</td>
                                </tr>
                            <?php } ?>
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
         </main>

<?php
require_once "../template/footer.php";
?>

</div>