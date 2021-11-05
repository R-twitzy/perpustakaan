<?php
include "connection.php";
$kode_pinjam = $_GET["kode_pinjam"];
date_default_timezone_set('Asia/Jakarta');
$tgl_pengembalian = date_create(date("Y-m-d H:i:s"));
$tgl_pengembalian_fix = date("Y-m-d H:i:s");
// selisih hari = selisih tgl_pengembalian dan tgl_pinjam
// jika selisih hari > 7, maka denda = (selisih hari - 7)*1000
// else denda = 0

$sql = "select * from pinjam
where kode_pinjam='$kode_pinjam'";
$hasil = mysqli_query($connect, $sql);
$pinjam = mysqli_fetch_array($hasil);
$tgl_pinjam = date_create($pinjam["tgl_pinjam"]);

// menghitung selisih dua tanggal
$selisih = date_diff($tgl_pengembalian, $tgl_pinjam);
// mengkonversi hasil selisih format jumlah hari
$selisih_hari = $selisih->format("%a");

// menghitung denda
if ($selisih_hari > 7) {
    $denda = ($selisih_hari - 7)* 1000;
} else {
    $denda = 0;
}

$sql = "insert into pengembalian values
('', '$kode_pinjam', '$tgl_pengembalian_fix', '$denda')";
if (mysqli_query($connect, $sql)){
    header("location: list-pinjam.php");
}else {
    echo mysqli_error($connect);
}
?>