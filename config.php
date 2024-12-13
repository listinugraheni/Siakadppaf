<?php

//koneksi
$koneksi = mysqli_connect("localhost","root","","siakadppaf");


if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
//cek koneksi
//if (mysqli_connect_errno()) {
//	echo "Gagal koneksi database"
// } else {
//	echo "Berhasil koneksi database";
// }

//url induk
$main_url = "http://localhost/siakad/";
