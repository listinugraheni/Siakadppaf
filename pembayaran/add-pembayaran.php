<?php
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config.php";
$title = 'Pembayaran - TPA PP.AL-FALAH';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tanggal_pembayaran = mysqli_real_escape_string($koneksi, $_POST['tanggal_pembayaran']);
    $jumlah = mysqli_real_escape_string($koneksi, $_POST['jumlah']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    $insertQuery = "INSERT INTO tbl_pembayaran (nama, tanggal_pembayaran, jumlah, status) 
                    VALUES ('$nama', '$tanggal_pembayaran', '$jumlah', '$status')";

    if (mysqli_query($koneksi, $insertQuery)) {
        echo "<script>
				alert('Laporan berhasil disimpan');
				document.location.href = 'pembayaran.php';
			</script>";
        exit;
    } else {
        $error = "Gagal menambahkan data pembayaran: " . mysqli_error($koneksi);
    }
}

// Ambil nama santri berdasarkan role 'santri'
$querySantri = "SELECT nama FROM tbl_newuser WHERE role = 'santri'";
$resultSantri = mysqli_query($koneksi, $querySantri);
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Pembayaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="pembayaran.php">Laporan Pembayaran</a></li>
                <li class="breadcrumb-item active">Tambah Pembayaran</li>
            </ol>

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php } ?>

        

        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-plus"></i> Tambah Pembayaran
            </div>
            <div class="card-body">
            <form action="add-pembayaran.php" method="POST">
                <div class="mb-3">
            <label for="nama" class="form-label">Nama Santri</label>
            <select name="nama" id="nama" class="form-control" required>
                <option value="">Pilih Santri</option>
                <?php while ($row = mysqli_fetch_assoc($resultSantri)) { ?>
                    <option value="<?= htmlspecialchars($row['nama']) ?>"><?= htmlspecialchars($row['nama']) ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
            <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" value="50.000" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="Lunas">Lunas</option>
                <option value="Belum Lunas">Belum Lunas</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="pembayaran.php" class="btn btn-secondary">Kembali</a>
    </form>
    </div>
    </div>
    </div>
    </main>

<?php
require_once "../template/footer.php";
?>


