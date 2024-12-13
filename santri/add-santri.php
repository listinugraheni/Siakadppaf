<?php
session_start();

// Cek apakah user sudah login. Jika sudah, redirect ke halaman login
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config.php";
$title = "Tambah Santri - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

$queryNis = mysqli_query($koneksi, "SELECT max(nis) as maxnis FROM tbl_santri");
$data = mysqli_fetch_array($queryNis);
$maxnis = $data["maxnis"];

$noUrut = (int) substr($maxnis, 4, 3);
$noUrut++;
$maxnis = "PPAF".sprintf("%03s", $noUrut);

?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Tambah Santri</h1>
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                         <li class="breadcrumb-item"><a href="santri.php">Santri</a></li>
                        <li class="breadcrumb-item active"> Tambah Santri</li>
                        </ol>
                        <form action="proses-santri.php" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                        <span class=" h5 my-2"><i class="fa-solid fa-square-plus"></i> Tambah Santri</span>
                        <button type="submit" name="simpan" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                        <button type="reset" name="reset" class="btn btn-danger float-end me-1"><i class="fa-solid fa-xmark"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row"></div>
                        <div class="col-8"></div>
                        <div class="mb-3 row">
                        <label for="nis" class="col-sm-1 col-form-label">NIS</label>
                        <label for="nis" class="col-sm-1 col-form-label">:</label>
                        <div class="col-sm-9" style="margin-left: -50px;">
                        <input type="text" name="nis"  class="form-control-plaintext border-bottom ps-2" id="nis" value="<?= $maxnis ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                        <label for="nama" class="col-sm-1 col-form-label">Nama</label>
                        <label for="nis" class="col-sm-1 col-form-label">:</label>
                        <div class="col-sm-9" style="margin-left: -50px;">
                        <input type="text" name="nama" required class="form-control border-0 border-bottom ps-2" id="nis" value="">
                    </div>
                </div>
                 
                <div class="mb-3 row">
                        <label for="alamat" class="col-sm-1 col-form-label">alamat</label>
                        <label for="nis" class="col-sm-1 col-form-label">:</label>
                        <div class="col-sm-9" style="margin-left: -50px;">
                        <textarea name="alamat" id="alamat" cols="30" rows="3" placeholder="Alamat santri" class="form-control" required></textarea>
                    </div>
                </div>
            </div>
                <div class="col-4"></div>  
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    </main>

<?php
// Sertakan file footer
require_once "../template/footer.php";
?>
