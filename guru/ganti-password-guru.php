<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['ssLogin']) || $_SESSION['role'] != 'pengajar') {
    header('Location: ../auth/login.php');
    exit();
}

require_once "../config.php";
$title = "Ganti Password - SIA TPA PP.AL-FALAH";
require_once '../template/header.php';
require_once "../template/navbar.php";
require_once "../template/sidebarguru.php";

// Bagian alert message
if (isset ($_GET['msg'])) {
    $msg = $_GET['msg'];
} else {
    $msg = '';
}

$alert = '';
if ($msg == 'updated') {
    $alert ='<div class="alert alert-success alert-dismissible fade show" role="alert"> 
    Ganti Password Berhasil..
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if ($msg == 'err1') {
    $alert ='<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Ganti password gagal, konfirmasi password tidak sama..
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if ($msg == 'err2') {
    $alert ='<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Ganti password gagal, Password lama tidak cocok..
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>

<div id="layoutSidenav_content">
              <main>
                 <div class="container-fluid px-4">
                   <h1 class="mt-4">Password</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../guru_dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Ganti Password</li>
                    </ol>
                    <form action="proses-password-guru.php" method="POST">
                    <?php
                        if ($msg !== '') {
                            echo $alert;
                        }  
                    ?>
                    <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-pen-to-square"></i> Ganti Password</span>
                        <button type="submit" name="simpan" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                        <button type="reset" name="reset" class="btn btn-danger float-end me-1"><i class="fa-solid fa-xmark"></i> Reset</button>
                    </div>
                        <div class="card-body">
                        <div class="mb-3 row">
                        <div class="col-7">
                            <label for="curPass" class="form-label">Password Lama</label>
                            <input type="password" class="form-control" id="curPass" name="curPass" placeholder="Masukkan password anda saat ini" required>
                        </div>
                        </div>
                        <div class="mb-3 row">
                        <div class="col-7">
                            <label for="newPass" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="newPass" name="newPass" minlength="4" maxlength="20" placeholder="Masukkan password baru anda" required>
                        </div>
                        </div>
                        <div class="mb-3 row">
                        <div class="col-7">
                            <label for="confPass" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="confPass" name="confPass"  placeholder="Ulangi password baru anda" required>
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