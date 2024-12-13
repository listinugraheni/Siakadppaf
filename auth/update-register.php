<?php
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

require_once "../config.php";
$title = "Update User - TPA PP.AL-FALAH";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Ambil data user berdasarkan ID
$queryUser = mysqli_query($koneksi, "SELECT * FROM tbl_newuser WHERE id = '$id'");
$data = mysqli_fetch_assoc($queryUser);

if (!$data) {
    $_SESSION['error_message'] = "Data user tidak ditemukan.";
    header("location: ../user/user.php");
    exit();
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Update User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="../user/user.php">Data User</a></li>
                <li class="breadcrumb-item active">Update User</li>
            </ol>
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa-solid fa-user-edit"></i> Form Update User</h5>
                </div>
                <div class="card-body">
                    <form action="register_process.php" method="POST">
                        <!-- Hidden Input for ID -->
                        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telpon" class="form-label">Telpon</label>
                            <input type="tel" name="telpon" id="telpon" class="form-control" pattern="[0-9]{5,}" title="Minimal 5 angka" value="<?= htmlspecialchars($data['telpon']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required><?= htmlspecialchars($data['alamat']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="santri" <?= $data['role'] === 'santri' ? 'selected' : '' ?>>Santri</option>
                                <option value="pengajar" <?= $data['role'] === 'pengajar' ? 'selected' : '' ?>>Pengajar</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                            <a href="../user/user.php" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php require_once "../template/footer.php"; ?>
</div>
