<?php  
session_start();

if (!isset($_SESSION['ssLogin'])) {
	header('location: ../auth/login.php');
	exit();
}
require_once "../config.php";

$title = "Mata Pelajaran - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

if(isset($_GET['msg'])) {
    $msg = $_GET ['msg'];
} else {
    $msg = '';
}

$alert = '';
if ($msg == 'cancel') {
    $alert ='<div class="alert alert-danger alert-dismissible fade show" role="alert">
   <i class ="fa-solid fa-circle-xmark"></i>Tambah pelajaran gagal.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if ($msg == 'added') {
    $alert ='<div class="alert alert-success alert-dismissible fade show" id="added" role="alert">
   Tambah pelajaran berhasil.  
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if ($msg == 'deleted') {
    $alert ='<div class="alert alert-success alert-dismissible fade show" id="deleted" role="alert">
  Hapus Pelajaran berhasil.
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Mata Pelajaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Mata Pelajaran</li>
            </ol>
            <?php 
            if ($msg !== "") {
                echo $alert;
            }
            ?>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-plus"></i> Tambah Pelajaran
                        </div>
                        <div class="card-body">
                            <form action="proses-pelajaran.php" method="POST">
                                <div class="mb-3">
                                    <label for="hari" class="form-label ps-1">Hari</label>
                                    <select name="pelajaran" id="pelajaran" class="form-select">
                                <option value="">-- Pilih Hari --</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                             </select>
                                </div>
                                <div class="mb-3">
                                    <label for="pelajaran" class="form-label ps-1">Pelajaran</label>
                                    <select name="pelajaran" id="pelajaran" class="form-select">
                                <option value="">-- Pilih Pelajaran --</option>
                                <option value="Hafalan Surat & Doa">Hafalan Surat & Doa</option>
                                <option value="Fasholatan">Fasholatan</option>
                                <option value="Juz Amma & Al Qur'an">Juz Amma & Al Qur'an</option>
                             </select>
                                </div>
                                <div class="mb-3">
                                    <label for="guru" class="form-label ps-1">Guru</label>
                                    <select name="guru" id="guru" class="form-select" required>
                                        <option value="" selected>--Pilih Guru--</option>
                                        <?php 
                                        $queryGuru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                                        while ($dataGuru = mysqli_fetch_array($queryGuru)) { ?>
                                            <option value="<?= $dataGuru['nama'] ?>"><?= $dataGuru['nama'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="simpan"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                                <button type="reset" class="btn btn-danger" name="reset"><i class="fa-solid fa-xmark"></i> Reset</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-list"></i> Data Pelajaran
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col"><center>Hari</center></th>
                                        <th scope="col"><center>Pelajaran</center></th>
                                        <th scope="col"><center>Guru</center></th>
                                        <th scope="col"><center>Option</center></th>									      
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $queryPelajaran = mysqli_query($koneksi, "SELECT * FROM tbl_mapel");
                                    while ($data = mysqli_fetch_array($queryPelajaran)) { ?>
                                    <tr>
                                        <th scope="row"><?= $no++ ?></th>
                                        <td><?= $data['hari'] ?></td>
                                        <td><?= $data['pelajaran'] ?></td>
                                        <td><?= $data['guru'] ?></td>
                                        <td align="center">
                                            <a href="edit-pelajaran.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-warning" title="Update pelajaran"><i class="fa-solid fa-pen"></i></a>
                                            <a href="hapus-pelajaran.php?id=<?= $data['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pelajaran ini?')" class="btn btn-sm btn-danger" title="Hapus pelajaran"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#added').fadeOut('slow');
        }, 3000);
    });
</script>

<?php
require_once '../template/footer.php';
?>
