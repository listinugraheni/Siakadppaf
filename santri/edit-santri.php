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

$userid = $_GET['userid'];

// Gunakan prepared statement untuk mencegah SQL Injection
$stmt = $koneksi->prepare("SELECT * FROM tbl_newuser WHERE userid = ?");
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();
?>


            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Update Santri</h1>
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                         <li class="breadcrumb-item"><a href="santri.php">Santri</a></li>
                        <li class="breadcrumb-item active"> Update Santri</li>
                        </ol>
                        <form action="proses-santri.php?userid=<?= htmlspecialchars($userid) ?>" method="POST" enctype="multipart/form-data">
    <div class="card">
        <div class="card-header">
            <span class="h5 my-2"><i class="fa-solid fa-square-pen-to-square"></i> Update User</span>
            <button type="submit" name="update" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk"></i> Update</button>
        </div>
        <div class="card-body">
            <div class="row"></div>
            <div class="col-8"></div>
            <div class="mb-3 row">
                <label for="nama" class="col-sm-1 col-form-label">Nama</label>
                <label for="nis" class="col-sm-1 col-form-label">:</label>
                <div class="col-sm-9" style="margin-left: -50px;">
                    <input type="text" name="nama" required class="form-control border-0 border-bottom ps-2" id="nama" value="<?= htmlspecialchars($data['nama']) ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="telpon" class="col-sm-1 col-form-label">Telpon</label>
                <label for="nis" class="col-sm-1 col-form-label">:</label>
                <div class="col-sm-9" style="margin-left: -50px;">
                    <input type="tel" name="telpon" required class="form-control border-0 border-bottom ps-2" id="telpon" value="<?= htmlspecialchars($data['telpon']) ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat" class="col-sm-1 col-form-label">Alamat</label>
                <label for="nis" class="col-sm-1 col-form-label">:</label>
                <div class="col-sm-9" style="margin-left: -50px">
                    <textarea name="alamat" id="alamat" class="form-control border-0 border-bottom" required><?= htmlspecialchars($data['alamat']) ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
</form>

    </div>
    </main>

<?php
// Sertakan file footer
require_once "../template/footer.php";
?>
