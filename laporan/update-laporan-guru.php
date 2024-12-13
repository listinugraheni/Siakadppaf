<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config.php";
$title = "Update Laporan Mengaji - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebarguru.php";

// Ambil ID laporan dari parameter URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: laporan-guru.php');
    exit();
}

$id = intval($_GET['id']);

// Ambil data laporan berdasarkan ID
$queryLaporan = mysqli_query($koneksi, "SELECT * FROM tbl_laporan_mengaji WHERE id = $id");
$data = mysqli_fetch_array($queryLaporan);

if (!$data) {
    die("Data laporan tidak ditemukan.");
}

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Laporan Mengaji</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../guru_dashboard.php">Home</a></li>
                <li class="breadcrumb-item"><a href="laporan-guru.php">Laporan Mengaji</a></li>
                <li class="breadcrumb-item active">Update Laporan</li>
            </ol>

            <form action="proses-laporan.php" method="POST">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-pen-to-square"></i> Update Laporan</span>
                        <button type="submit" name="update" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk"></i> Update</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                <div class="mb-3 row">
                                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                                    <label for="tanggal" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -40px">
                                        <input type="date" name="tanggal" id="tanggal" class="form-control ps-2 border-0 border-bottom" value="<?= htmlspecialchars($data['tanggal']) ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <label for="nama" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -40px">
                                        <input type="text" name="nama" id="nama" class="form-control ps-2 border-0 border-bottom" value="<?= htmlspecialchars($data['nama']) ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="pelajaran" class="col-sm-2 col-form-label">Pelajaran</label>
                                    <label for="pelajaran" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -40px">
                                        <input type="text" name="pelajaran" id="pelajaran" class="form-control ps-2 border-0 border-bottom" value="<?= htmlspecialchars($data['pelajaran']) ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
    <label for="guru" class="col-sm-2 col-form-label">Guru</label>
    <label for="guru" class="col-sm-1 col-form-label">:</label>
    <div class="col-sm-9" style="margin-left: -40px">
    <select name="guru" id="guru" class="form-select" required>
                                <option value="">Pilih Guru</option>
                                <?php
                                $queryGuru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                                while ($dataGuru = mysqli_fetch_array($queryGuru)) { ?>
                                    <option value="<?= htmlspecialchars($dataGuru['nama']) ?>"><?= htmlspecialchars($dataGuru['nama']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
    </div>




                               <div class="mb-3 row">
                                    <label for="laporan" class="col-sm-2 col-form-label">Laporan</label>
                                    <label for="laporan" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -40px">
                                        <textarea name="laporan" id="laporan" rows="5" class="form-control" required><?= htmlspecialchars($data['laporan']) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4"></div>
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