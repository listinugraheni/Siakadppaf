<?php  
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['ssLogin'])) {
    header('location: ../auth/login.php');
    exit();
}

require_once "../config.php";

// Mendapatkan ID pelajaran dari parameter URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data pelajaran berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_mapel WHERE id='$id'");

    // Cek apakah data pelajaran ditemukan
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
    } else {
        echo "<script>
                alert('Data pelajaran tidak ditemukan.');
                document.location.href = 'pelajaran.php';
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('ID pelajaran tidak ditemukan.');
            document.location.href = 'pelajaran.php';
          </script>";
    exit();
}

$title = "Update Pelajaran - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Update Pelajaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="pelajaran.php">Mata Pelajaran</a></li>
                <li class="breadcrumb-item active">Update Pelajaran</li>
            </ol>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-pen"></i> Update Pelajaran
                        </div>
                        <div class="card-body">
                            <form action="proses-pelajaran.php" method="POST">
                                <!-- Hidden field for ID -->
                                <input type="hidden" name="id" value="<?= $data['id'] ?>">

                                <!-- Input field for Hari -->
                                <div class="mb-3">
                                    <label for="hari" class="form-label">Hari</label>
                                    <input type="text" class="form-control" id="hari" name="hari" value="<?= $data['hari'] ?>" required>
                                </div>

                                <!-- Input field for Pelajaran -->
                                <div class="mb-3">
                                    <label for="pelajaran" class="form-label">Pelajaran</label>
                                    <input type="text" class="form-control" id="pelajaran" name="pelajaran" value="<?= $data['pelajaran'] ?>" required>
                                </div>

                                <!-- Dropdown for Guru -->
                                <div class="mb-3">
                                    <label for="guru" class="form-label">Guru</label>
                                    <select name="guru" id="guru" class="form-select" required>
                                        <option value="<?= $data['guru'] ?>" selected><?= $data['guru'] ?></option>
                                        <?php
                                        $queryGuru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                                        while ($dataGuru = mysqli_fetch_array($queryGuru)) { ?>
                                            <option value="<?= $dataGuru['nama'] ?>"><?= $dataGuru['nama'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary" name="update"><i class="fa-solid fa-floppy-disk"></i> Update</button>
                                <a href="pelajaran.php" class="btn btn-danger"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
require_once '../template/footer.php';
?>
