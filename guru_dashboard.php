<?php  
session_start();

// Pastikan hanya pengajar yang dapat mengakses halaman ini
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] !== 'pengajar') {
    header('Location: ../auth/login.php');
    exit();
}

require_once "config.php"; // Pastikan path ke config.php sudah benar
$title = 'Dashboard Pengajar - TPA PP.AL-FALAH';
require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/sidebarguru.php"; // Pastikan path ke file sidebar pengajar sudah benar

// Fetching data from the database untuk pengguna yang sedang login
$nama = $_SESSION['nama'] ?? ''; // Ambil nama pengguna dari session, pastikan ada fallback

if ($nama === '') {
    echo "<p>Nama pengguna tidak ditemukan di sesi.</p>";
    exit();
}

// Query untuk mengambil data profil pengguna
$queryProfil = $koneksi->prepare("SELECT nama, telpon, alamat FROM tbl_newuser WHERE nama = ?");
$queryProfil->bind_param("s", $nama);
$queryProfil->execute();
$resultProfil = $queryProfil->get_result();
$dataProfil = $resultProfil->fetch_assoc();
$queryProfil->close();

// Query untuk laporan mengaji
$queryLaporan = $koneksi->prepare("SELECT * FROM tbl_laporan_mengaji WHERE nama = ? ORDER BY id DESC");
$queryLaporan->bind_param("s", $nama);
$queryLaporan->execute();
$resultLaporan = $queryLaporan->get_result();

if (!$resultLaporan) {
    die("Query gagal dijalankan: " . $koneksi->error);
}
?>

<style>
    .profile-table {
        font-size: 1.25rem;
    }
    .profile-img {
        width: 300px;
        height: 300px;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .table-hover thead th {
        border-bottom: 0;
    }
    .table-hover tbody td {
        border: 0;
    }
</style>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard Pengajar</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Home</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Santri TPA</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="santri/tampil_santri.php">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Mata Pelajaran</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="pelajaran/tampil-pelajaran-guru.php">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Statistik atau Laporan Mengaji -->
        </div>
    </main>

<?php 
require_once "template/footer.php";
?>
</div>
