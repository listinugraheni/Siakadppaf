<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config.php";

// Periksa apakah parameter ID ada di URL
if (!isset($_GET['id'])) {
    echo "<script>
            alert('ID tidak ditemukan!');
            document.location.href = 'pembayaran.php';
          </script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data pembayaran berdasarkan ID
$query = "SELECT * FROM tbl_pembayaran WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo "<script>
            alert('Data tidak ditemukan!');
            document.location.href = 'laporan-pembayaran.php';
          </script>";
    exit;
}

$data = mysqli_fetch_assoc($result);

// Proses update data jika form disubmit
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['nama']));
    $tanggal_pembayaran = mysqli_real_escape_string($koneksi, $_POST['tanggal_pembayaran']);
    $jumlah = mysqli_real_escape_string($koneksi, htmlspecialchars($_POST['jumlah']));
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    $updateQuery = "UPDATE tbl_pembayaran SET 
                        nama = ?, 
                        tanggal_pembayaran = ?, 
                        jumlah = ?, 
                        status = ? 
                    WHERE id = ?";
    $stmtUpdate = mysqli_prepare($koneksi, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, 'ssdsi', $nama, $tanggal_pembayaran, $jumlah, $status, $id);

    if (mysqli_stmt_execute($stmtUpdate)) {
        echo "<script>
                alert('Data pembayaran berhasil diperbarui');
                document.location.href = 'pembayaran.php';
              </script>";
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <?php require_once "../template/header.php"; ?>
    <title>Update Pembayaran</title>
</head>
<body>
    <?php require_once "../template/navbar.php"; ?>
    <?php require_once "../template/sidebar.php"; ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Update Pembayaran</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="pembayaran.php">Laporan Pembayaran</a></li>
                    <li class="breadcrumb-item active">Update Pembayaran</li>
                </ol>

                <div class="card">
                    <div class="card-header">
                        <i class="fa-solid fa-pen"></i> Update Pembayaran
                    </div>
                    <div class="card-body">
                        <form action="update-pembayaran.php?id=<?= $id ?>" method="POST">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                                <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?= htmlspecialchars($data['tanggal_pembayaran']) ?>">
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= htmlspecialchars($data['jumlah']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="Lunas" <?= $data['status'] === 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                                    <option value="Belum Lunas" <?= $data['status'] === 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                                </select>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary"><i class="fa-solid fa-save"></i> Update</button>
                            <a href="pembayaran.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <?php require_once "../template/footer.php"; ?>
    </div>
</body>
</html>
