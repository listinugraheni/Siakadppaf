<?php
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header(header: "location:../auth/login.php");
    exit();
}
require_once"../config.php";
$title = " Tambah User - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";
?>
         <div class="card-body">
                                    <?php if (isset($_SESSION['error_message'])) { ?>
                                        <div class="alert alert-danger">
                                            <?= htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8') ?>
                                        </div>
                                    <?php } ?>
                                    <form action="register_process.php" method="POST">

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px 4">
            <h1 class="mt-4">Tambah User</h1>
            <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="../user/user.php">Data User</a></li>
            <li class="breadcrumb-item active">Tambah User</li>
        </ol>
        <div class="card">
            <div class="card-header">
            <span class="h5"><i class="fa-solid fa-square-plus"></i> Tambah User</span>
	
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3 row">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            
            				<label for="nama" class="col-sm-1 col-form-label">:</label>
            				<div class="col-sm-9" style="margin-left: -40px">
            					<input type="text" name="username" class="form-control ps-2 border-0 border-bottom" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <label for="password" class="col-sm-1 col-form-label">:</label>
                        <div class="col-sm-9" style="margin-left: -40px">
                            <input type="text" name="password" class="form-control ps-2 border-0 border-bottom" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <label for="nama" class="col-sm-1 col-form-label">:</label>
                        <div class="col-sm-9" style="margin-left: -40px">
                            <input type="text" name="nama" class="form-control ps-2 border-0 border-bottom" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Telpon" class="col-sm-2 col-form-label">Telpon</label>
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
                        <div class="mb-3 row">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <label for="role" class="col-sm-1 col-form-label">:</label>
                        <div class="col-sm-9" style="margin-left: -40px">
                        <select class="form-control" id="role" name="role" required>
                             <option value="admin">Admin</option>
                             <option value="santri">Santri</option>
                             <option value="pengajar">Pengajar</option>
                       </select>
                        </div>
                        <div class="button-wrapper">
                            <button type="submit" name="register" class="btn btn-primary col-12 rounded-pill my-2">Simpan</button>
                        </div>

                        <style>
                          .button-wrapper {
                          display: flex;
                          justify-content: center;
                         align-items: center;
                         }
                        </style>
                    </div>
                </div>
            </div>
        </div>
            </div>
            </form>
            </div>
            <div class="card-footer text-center py-3">
            <div class="text-muted small">Copyright &copy; TPA PP.AL-FALAH</div>
            </main>
            </div>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
