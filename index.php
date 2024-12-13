<?php

session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location: auth/login.php");
    exit;
}

require_once "config.php";

$title = "Dashboard TPA PP.AL-FALAH";
require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/sidebar.php";

$countQuery = "SELECT COUNT(*) AS total_santri FROM tbl_santri";
$countResult = mysqli_query($koneksi, $countQuery);

if (!$countResult) {
    die("Query gagal dijalankan: " . mysqli_error($koneksi));
}

// Ambil hasil query
$countData = mysqli_fetch_assoc($countResult);
$totalSantri = $countData['total_santri'];

?>

<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Home</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Santri TPA</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="santri/santri.php">View Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Guru TPA</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="guru/guru.php">View Detail</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Mata Pelajaran</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="pelajaran/pelajaran.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                            </div>
                        </div>
                    </div>
                </main>

                <?php 
                
                    require_once "template/footer.php";

                ?>
