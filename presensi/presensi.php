<?php  
session_start();

// Periksa apakah user sudah login dan memiliki peran yang benar
if (!isset($_SESSION['ssLogin']) || !in_array($_SESSION['role'], ['admin', 'pengajar'])) {
    header('Location: ../auth/login.php');
    exit();
}

require_once "../config.php";
$title = 'Presensi Santri - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebarguru.php";

// Ambil data santri dari database
$querySantri = mysqli_query($koneksi, "SELECT id, nama FROM tbl_newuser WHERE role = 'santri'");
if (!$querySantri) {
    die("Query gagal dijalankan: " . mysqli_error($koneksi));
}

// Menangani form submit Presensi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $Presensi_data = $_POST['Presensi'];

    foreach ($Presensi_data as $santri_id => $status) {
        $santri_id = mysqli_real_escape_string($koneksi, $santri_id);
        $status = mysqli_real_escape_string($koneksi, $status);

        $query = "INSERT INTO tbl_presensi (santri_id, tanggal, status) VALUES ('$santri_id', '$tanggal', '$status') 
                  ON DUPLICATE KEY UPDATE status = '$status'";

        if (!mysqli_query($koneksi, $query)) {
            echo "Gagal menyimpan data Presensi: " . mysqli_error($koneksi);
        }
    }

    echo "<script>
            alert('Data Presensi berhasil disimpan');
            document.location.href = 'Presensi.php';
          </script>";
    exit();
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Presensi Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../guru_dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Presensi Santri</li>
                <li class="breadcrumb-item"><a href="rekap-Presensi-guru.php">Data Presensi</a></li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-check"></i> Presensi Santri
                    <a href="rekap-Presensi-guru.php" class="btn btn-sm btn-primary float-end ms-1"><i class="fa-solid fa-eye"></i> Data Presensi</a>
                </div>
                <div class="card-body">
                    <form action="Presensi.php" method="POST">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Santri</th>
                                    <th>Status Presensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1; 
                                while ($santri = mysqli_fetch_assoc($querySantri)) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($santri['nama']) ?></td>
                                        <td>
                                            <select name="Presensi[<?= $santri['id'] ?>]" class="form-select" required>
                                                <option value="Hadir">Hadir</option>
                                                <option value="Tidak Hadir">Tidak Hadir</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Simpan Presensi</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php
require_once "../template/footer.php";
?>
</div>