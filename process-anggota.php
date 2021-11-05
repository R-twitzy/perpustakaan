<?php
include("connection.php");

# untuk insert anggota
if (isset($_POST["simpan_anggota"])) {
    // tampubg data input anggota dari user
    $id_anggota = $_POST["id_anggota"];
    $nama_anggota = $_POST["nama_anggota"];
    $tgl_lahir = $_POST["tgl_lahir"];
    $alamat = $_POST["alamat"];
    $telepon = $_POST["telepon"];

    // membuat perintah sql utk insert data ke tbl anggota
    $sql = "insert into anggota values ('$id_anggota', 
    '$nama_anggota', '$tgl_lahir', '$alamat', '$telepon')";

    // eksekusi perintah sql
    mysqli_query($connect, $sql);

    // direct ke halaman list anggota
    header("location: list-anggota.php");
}

# untuk edit anggota
if (isset($_POST["edit_anggota"])) {
    // tampung data yg akan diupdate
    $id_anggota = $_POST["id_anggota"];
    $nama_anggota = $_POST["nama_anggota"];
    $tgl_lahir = $_POST["tgl_lahir"];
    $alamat = $_POST["alamat"];
    $telepon = $_POST["telepon"];

    // membuat perintah sql untuk update data
    $sql = "update anggota set nama_anggota='$nama_anggota',
    tgl_lahir='$tgl_lahir',
    alamat='$alamat',
    telepon='$telepon' where id_anggota='$id_anggota'";

    // eksekusi perintah sql
    mysqli_query($connect, $sql);

    // direct ke halaman list anggota
    header("location: list-anggota.php");
}

?>