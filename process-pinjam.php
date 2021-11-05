<?php
include "connection.php";
// tampung inputan
$tgl_pinjam = $_POST["tgl_pinjam"];
$id_anggota = $_POST["id_anggota"];
$id_petugas = $_POST["id_petugas"];
$buku = $_POST["isbn"];

// perintah sql utk insert ke tabel pinjam
$sql="insert into pinjam values
('','$tgl_pinjam', '$id_anggota', '$id_petugas')";
if (mysqli_query($connect, $sql)) {
    # jika insert berhasil
    # insert ke tabel detail_pinjam
    $sql="select * from pinjam order by kode_pinjam desc";
    $pinjam = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($pinjam);
    $kode_pinjam= $array["kode_pinjam"];
    for ($i=0; $i < count($buku); $i++) { 
        $isbn = $buku[$i];
        $sql = "insert into detail_pinjam values ('$kode_pinjam', '$isbn')";
        if (mysqli_query($connect, $sql)){
            header("location: list-pinjam.php");
        }else {
            echo mysqli_error($connect);
        }
    }
} else {
    # jika gagal
    echo mysqli_error($connect);
}

?>