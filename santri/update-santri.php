<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Cek apakah user adalah admin
if ($_SESSION['role'] !== 'admin') {
    echo "Akses ditolak. Hanya admin yang dapat melakukan pembaruan.";
    exit;
}

require_once "../config.php";
$title = "Update Santri - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';

// Debugging output
if (!$id) {
    echo "Parameter nama tidak ditemukan.";
    exit;
}

$querySantri = mysqli_query($koneksi, "SELECT * FROM tbl_newuser WHERE id = '$id'");
$data = mysqli_fetch_array($querySantri);

if (!$data) {
    echo "Data pengguna tidak ditemukan.";
    exit;
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Update Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="santri.php">Santri</a></li>
                <li class="breadcrumb-item active">Update Santri</li>
            </ol>
            <form action="proses-santri.php?id=<?= htmlspecialchars($id) ?>" method="POST">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-square-pen-to-square"></i> Update User</span>
                        <button type="submit" name="update" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk"></i> Update</button>
                    </div>
                    <div class="card-body">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                        <div class="mb-3 row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" required class="form-control" id="nama" value="<?= htmlspecialchars($data['nama']) ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="telpon" class="col-sm-2 col-form-label">Telpon</label>
                            <div class="col-sm-10">
                                <input type="tel" name="telpon" required class="form-control" id="telpon" value="<?= htmlspecialchars($data['telpon']) ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea name="alamat" id="alamat" class="form-control" required><?= htmlspecialchars($data['alamat']) ?></textarea>
                            </div>
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