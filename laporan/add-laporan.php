<?php  
session_start();

// Periksa apakah user sudah login dan memiliki peran yang benar
if (!isset($_SESSION['ssLogin']) || !in_array($_SESSION['role'], ['admin', 'pengajar'])) {
    header('Location: ../auth/login.php');
    exit();
}

require_once "../config.php";
$title = 'Tambah Laporan Mengaji - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $santri_id = mysqli_real_escape_string($koneksi, $_POST['santri_id']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $pelajaran = mysqli_real_escape_string($koneksi, $_POST['pelajaran']);
    $guru = mysqli_real_escape_string($koneksi, $_POST['guru']);
    $laporan = mysqli_real_escape_string($koneksi, $_POST['laporan']);

    // Query untuk menyimpan laporan baru
    $query = "INSERT INTO tbl_laporan_mengaji (tanggal, nama, pelajaran, guru, laporan, santri_id) VALUES ('$tanggal','$nama', '$pelajaran', '$guru', '$laporan', '$santri_id')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Laporan berhasil disimpan');
                document.location.href = 'laporan.php';
            </script>";
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}

// Ambil data santri dari database
$querySantri = mysqli_query($koneksi, "SELECT id, nama FROM tbl_newuser WHERE role = 'santri'");
if (!$querySantri) {
    die("Query gagal dijalankan: " . mysqli_error($koneksi));
}

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Laporan Mengaji</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="laporan.php">Laporan Mengaji</a></li>
                <li class="breadcrumb-item active">Tambah Laporan Mengaji</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-plus"></i> Tambah Laporan Mengaji
                </div>
                <div class="card-body">
                    <form action="add-laporan.php" method="POST">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <select class="form-select" id="nama" name="nama" required>
                                <option value="">Pilih Santri</option>
                                <?php while ($santri = mysqli_fetch_assoc($querySantri)) { ?>
                                    <option value="<?= htmlspecialchars($santri['nama']) ?>">
                                        <?= htmlspecialchars($santri['nama']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pelajaran" class="form-label">Pelajaran</label>
                            <select name="pelajaran" id="pelajaran" class="form-select border-0 border-bottom" required>
                                <option value="" selected>Pelajaran</option>
                                <option value="Hafalan Surat dan Doa">Hafalan Surat dan Doa</option>
                                <option value="Fasholatan">Fasholatan</option>
                                <option value="Juz Amma & Al Qur'an">Juz Amma & Al Qur'an</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="guru" class="form-label">Guru</label>
                            <select name="guru" id="guru" class="form-select" required>
                                <option value="">Pilih Guru</option>
                                <?php
                                $queryGuru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                                while ($dataGuru = mysqli_fetch_array($queryGuru)) { ?>
                                    <option value="<?= htmlspecialchars($dataGuru['nama']) ?>"><?= htmlspecialchars($dataGuru['nama']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="laporan" class="form-label">Laporan</label>
                            <textarea class="form-control" id="laporan" name="laporan" rows="4" required></textarea>
                        </div>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan Laporan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php
require_once "../template/footer.php";
?>
</div>