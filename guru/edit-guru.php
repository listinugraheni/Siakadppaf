
<?php
session_start();

// Cek apakah user sudah login. Jika sudah, redirect ke halaman login
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config.php";
$title = "Update Guru - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

$id = $_GET['id'];


$queryGuru = mysqli_query($koneksi, "SELECT * FROM tbl_guru WHERE id ='$id'");
$data = mysqli_fetch_array($queryGuru);


?>

<div id="layoutSidenav_content">
              <main>
                 <div class="container-fluid px-4">
                   <h1 class="mt-4">Update Guru</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="guru.php">Guru</a></li>
                        <li class="breadcrumb-item active">Update Guru</li>
                    </ol>
                    <form action="proses-guru.php" method="POST">
                     <div class="card">
                <div class="card-header">
                    <span class="h5 my-2"><i class="fa-solid fa-pen-to-square"></i> Update Guru</span>
                    <button type="submit" name="update" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk"></i> Update</button>
                     
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                        <div class="mb-3 row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <label for="nama" class="col-sm-1 col-form-label">:</label>
                            <div class="col-sm-9" style="margin-left: -40px">
                                <input type="text" name="nama" class="form-control ps-2 border-0 border-bottom" id="nama" value="<?= $data['nama']?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="mengajar" class="col-sm-2 col-form-label">Mengajar</label>
                            <label for="mengajar" class="col-sm-1 col-form-label">:</label>
                            <div class="col-sm-9" style="margin-left: -40px">
                                <select name="mengajar" id="mengajar" class="form-select border-0 border-bottom" required>
                                   <?php 
                                    $mengajar = ['Hafalan Surat & Doa', 'Fasholatan', "Juz Amma & Al Qur'an"];
                                    foreach ($mengajar as $mngjr) {
                                        if ($data['mengajar'] == $mngjr) { ?>
                                            <option value="<?= $mngjr ?>" selected><?= $mngjr ?></option>
                                            <?php  
                                        } else { ?>
                                            <option value="<?= $mngjr ?>"><?= $mngjr ?></option>
                                            ?>
                                        <?php
                                        }
                                            
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="telpon" class="col-sm-2 col-form-label">Telpon</label>
                            <label for="telpon" class="col-sm-1 col-form-label">:</label>
                            <div class="col-sm-9" style="margin-left: -40px">
                                <input type="tel" name="telpon" pattern="[0-9]{5,}" title="minimal 5 angka" class="form-control ps-2 border-0 border-bottom" value="<?= $data['telpon'] ?>" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <label for="Alamat" class="col-sm-1 col-form-label">:</label>
                            <div class="col-sm-9" style="margin-left: -40px">
                                <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control" required><?= $data['alamat'] ?></textarea>
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