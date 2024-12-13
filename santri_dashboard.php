<?php 
session_start();

// Pastikan hanya santri yang dapat mengakses halaman ini
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] != 'santri') {
    header('location:../auth/login.php');
    exit();
}

require_once "config.php"; // Pastikan path ke config.php sudah benar
$title = 'Dashboard Santri - TPA PP.AL-FALAH';
require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/sidebarsantri.php"; // Pastikan path ke file sidebar santri sudah benar

// Fetching data from the database for the logged-in santri
$nama = $_SESSION['nama']; // Ambil nama pengguna dari session

// Query untuk mengambil data profil pengguna
$queryProfil = $koneksi->prepare("SELECT nama, telpon, alamat FROM tbl_newuser WHERE nama = ?");
$queryProfil->bind_param("s", $nama);
$queryProfil->execute();
$resultProfil = $queryProfil->get_result();
$dataProfil = $resultProfil->fetch_assoc();
$queryProfil->close();

// Query untuk laporan mengaji
$queryLaporan = mysqli_query($koneksi, "SELECT * FROM tbl_laporan_mengaji WHERE nama = '$nama' ORDER BY id DESC");

if (!$queryLaporan) {
    die("Query gagal dijalankan: " . mysqli_error($koneksi));
}
?>

<style>
    .profile-table {
        font-size: 1.25rem; /* Membesarkan ukuran font */
    }
    .profile-img {
        width: 300px; /* Mengatur lebar gambar */
        height: 300px; /* Mengatur tinggi gambar */
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa; /* Warna latar belakang saat hover */
    }
    .table-hover thead th {
        border-bottom: 0; /* Menghapus border bawah pada header tabel */
    }
    .table-hover tbody td {
        border: 0; /* Menghapus border pada sel tabel */
    }
</style>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Home</li>
            </ol>
            
            <!-- Profil Santri -->
                        <div class="card text-center">
                         <div class="card-header fs-3 thicker">
                             Profil Santri
                         </div>
                        <div class="card-body">
                            <div class="align-items-center">
                                <!-- Foto Profil -->
                                <div class="me-3">
                                    <img src="asset/image/user.jpg" alt="user" class="img-fluid rounded-circle" style="width: 200px; height: 200px;">
                                </div>
                                <!-- Detail Profil -->
                                <div>
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                
                                                <td class="fs-3"><?= htmlspecialchars($dataProfil['nama']) ?></td>
                                            </tr>
                                            <tr>
                                                
                                                <td class="fs-4"><?= htmlspecialchars($dataProfil['telpon']) ?></td>
                                            </tr>
                                            <tr>
                                                
                                                <td class="fs-4"><?= htmlspecialchars($dataProfil['alamat']) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Statistik atau Laporan Mengaji -->
        </div>
    </main>
</div>

<?php 
require_once "template/footer.php";
?>
