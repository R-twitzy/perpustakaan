<?php
session_start();
include "connection.php";
# session -> tmpt penyimpanan data di sisi server yg dpt
# diakses scr global pd halaman web yg membutuhkan

if (isset($_POST["login"])) {
    # menampung data username dan password
    $username = $_POST["username"];
    $password = sha1($_POST["password"]);

    #ambil data petugas sesuai username & passsword
    $sql = "select * from petugas where 
    username='$username' and password='$password'";
    $hasil = mysqli_query($connect, $sql);

    # cek hasil query
    # mysqli_num_rows -> cek jumlah baris hasil query
    if (mysqli_num_rows($hasil) > 0) {
        # login berhasil
        # data disimpan dalam session
        $petugas = mysqli_fetch_array($hasil);
        $_SESSION["petugas"] = $petugas;
        header("location:list-buku.php");
    } else {
        # login gagal
        header("location:login.php");
    }
}
?>