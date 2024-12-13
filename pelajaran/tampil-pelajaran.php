<?php
// Mulai session
session_start();

// Periksa apakah user sudah login dan memiliki peran yang benar
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] != 'santri') {
    header('Location: ../auth/login.php');
    exit();
}

require_once "../config.php";
$title = " Jadwal Pelajaran - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebarsantri.php";

// Membuat koneksi ke database
$conn = new mysqli("localhost", "root", "", "siakadppaf");

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel tbl_mapel, diurutkan mulai dari hari Senin
$sql = "SELECT * FROM tbl_mapel 
        ORDER BY 
        CASE 
            WHEN hari = 'Senin' THEN 1
            WHEN hari = 'Selasa' THEN 2
            WHEN hari = 'Rabu' THEN 3
            WHEN hari = 'Kamis' THEN 4
            WHEN hari = 'Jumat' THEN 5
            WHEN hari = 'Sabtu' THEN 6
            WHEN hari = 'Minggu' THEN 7
        END, id DESC";

$queryPelajaran = $conn->query($sql);

// Mengecek apakah query berhasil
if (!$queryPelajaran) {
    die("Query gagal dijalankan: " . $conn->error);
}
?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Jadwal Pelajaran</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../santri_dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Jadwal Pelajaran</li>
                </ol>
                <div class="card text-center">
                    <div class="card-header fs-3">Jadwal Pelajaran</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Pelajaran</th>
                                    <th>Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($data = $queryPelajaran->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($data['hari']) ?></td>
                                        <td><?= htmlspecialchars($data['pelajaran']) ?></td>
                                        <td><?= htmlspecialchars($data['guru']) ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if ($queryPelajaran->num_rows == 0) { ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data tersedia</td>
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
