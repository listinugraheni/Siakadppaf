<?php
session_start();

// Tampilkan pesan error jika ada
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Hapus pesan error dari session setelah ditampilkan
} else {
    $error_message = ''; // Atur $error_message menjadi string kosong jika tidak ada pesan error
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - TPA PP.AL-FALAH</title>
    <link href="../asset/sb-admin/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="<?= $main_url ?>asset/image/logo.png">
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container mt-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h4 class="text-center font-weight-light my-4">Login - TPA PP.AL-FALAH</h4>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($error_message)) { ?>
                                        <div class="alert alert-danger">
                                            <?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') ?>
                                        </div>
                                    <?php } ?>
                                    <form action="proseslogin.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="username" name="username" type="text" pattern="[A-Za-z0-9]{3,}" title="Kombinasi angka dan huruf minimal 3 karakter" placeholder="Username" autocomplete="off" required />
                                            <label for="username">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password" placeholder="Password" minlength="4" name="password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <button type="submit" name="login" class="btn btn-primary col-12 rounded-pill my-2">Login</button>
                                    </form>
                                   
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="text-muted small">Copyright &copy; TPA PP.AL-FALAH</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= $main_url ?>asset/sb-admin/js/script.js "></script>
</body>
</html>
