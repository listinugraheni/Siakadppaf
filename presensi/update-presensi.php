<?php
session_start();

// Periksa apakah user sudah login dan memiliki peran yang benar
if (!isset($_SESSION['ssLogin']) || !in_array($_SESSION['role'], ['admin', 'pengajar'])) {
    header('Location: ../auth/login.php');
    exit();
}

require_once "../config.php";
$title = 'Update Data Presensi - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebarguru.php";

// Periksa apakah parameter ID diberikan
if (!isset($_GET['id'])) {
    header("Location: rekap-presensi-guru.php");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil data presensi berdasarkan ID
$query = "SELECT p.*, s.nama 
          FROM tbl_presensi p 
          JOIN tbl_newuser s ON p.santri_id = s.id 
          WHERE p.id = '$id'";
$result = mysqli_query($koneksi, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>
            alert('Data tidak ditemukan.');
            window.location.href = 'rekap-presensi-guru.php';
          </script>";
    exit();
}

$data = mysqli_fetch_assoc($result);
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Update Data Presensi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../guru_dashboard.php">Home</a></li>
                <li class="breadcrumb-item"><a href="rekap-presensi-guru.php">Data Presensi</a></li>
                <li class="breadcrumb-item active">Update Data Presensi</li>
            </ol>
            <form action="proses-presensi.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fa-solid fa-pen"></i> Form Update Presensi
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Santri</label>
                            <input type="text" id="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Presensi</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= htmlspecialchars($data['tanggal']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Presensi</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="Hadir" <?= $data['status'] === 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                                <option value="Tidak Hadir" <?= $data['status'] === 'Tidak Hadir' ? 'selected' : '' ?>>Tidak Hadir</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <a href="rekap-presensi-guru.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

<?php
require_once "../template/footer.php";
?>
</div>