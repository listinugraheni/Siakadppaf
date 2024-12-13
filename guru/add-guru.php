<?php  

session_start();

if (!isset($_SESSION['ssLogin'])) {
	header("location:../auth/login.php");
	exit();
}

require_once "../config.php";
$title = " Tambah Guru - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
} else {
	$msg = "";
}

$alert = '';
if ($msg == 'cancel') {
    $alert ='<div class="alert alert-warning alert-dismissible fade show" role="alert">
   <i class ="fa-solid fa-xmark"></i>Tambah Guru gagal..
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if ($msg == 'added') {
    $alert ='<div class="alert alert-success alert-dismissible fade show" role="alert">
   Tambah Guru berhasil..
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

?>

<div id="layoutSidenav_content">
              <main>
                 <div class="container-fluid px-4">
                   <h1 class="mt-4">Tambah Guru</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="guru.php">Guru</a></li>
                        <li class="breadcrumb-item active">Tambah Guru</li>
                    </ol>
                    <form action="proses-guru.php" method="POST">
                    	<?php 
                    		if ($msg != '') {
                    			echo $alert;
                    		}
                    	?>
                     <div class="card">
            	<div class="card-header">
            		<span class="h5 my-2"><i class="fa-solid fa-square-plus"></i>Tambah Guru</span>
            		<button type="submit" name="simpan" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
            		<button type="reset" name="reset" class="btn btn-danger float-end me-1"><i class="fa-solid fa-xmark"></i> Reset</button>	
            	</div>
            	<div class="card-body">
            		<div class="row">
            			<div class="col-8">
            			<div class="mb-3 row">
            				<label for="nama" class="col-sm-2 col-form-label">Nama</label>
            				<label for="nama" class="col-sm-1 col-form-label">:</label>
            				<div class="col-sm-9" style="margin-left: -40px">
            					<input type="text" name="nama" class="form-control ps-2 border-0 border-bottom" required>
            				</div>
            			</div>
            			<div class="mb-3 row">
            				<label for="mengajar" class="col-sm-2 col-form-label">Mengajar</label>
            				<label for="mengajar" class="col-sm-1 col-form-label">:</label>
            				<div class="col-sm-9" style="margin-left: -40px">
            					<select name="mengajar" id="mengajar" class="form-select border-0 border-bottom" required>
            						<option value="" selected>--Pelajaran--</option>
            						<option value="Hafalan Surat dan Doa">Hafalan Surat dan Doa</option>
            						<option value="Fasholatan">Fasholatan</option>
            						<option value="Juz Amma & Al Qur'an">Juz Amma & Al Qur'an</option>
            					</select>
            				</div>
            			</div>
            			<div class="mb-3 row">
            				<label for="telpon" class="col-sm-2 col-form-label">Telpon</label>
            				<label for="telpon" class="col-sm-1 col-form-label">:</label>
            				<div class="col-sm-9" style="margin-left: -40px">
            					<input type="tel" name="telpon" pattern="[0-9]{5,}" title="minimal 5 angka" class="form-control ps-2 border-0 border-bottom" required>
            				</div>
            			</div>
            			<div class="mb-3 row">
            				<label for="Alamat" class="col-sm-2 col-form-label">Alamat</label>
            				<label for="Alamat" class="col-sm-1 col-form-label">:</label>
            				<div class="col-sm-9" style="margin-left: -40px">
            					<textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control" required></textarea>
            				</div>
            			</div>
            		</div>
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