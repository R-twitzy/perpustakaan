<?php
session_start();
# jika saat load halaman ini, pastikan telah login sbg petugas
if (!isset($_SESSION["petugas"])) {
    header("location:login.php");
}
include "navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Anggota</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white">Form Anggota</h4>
            </div>

            <div class="card-body">
                <?php
                if (isset($_GET["id_anggota"])) {
                    // memeriksa ketika load file ini
                    // apakah membawa data GET dg nama "id_anggota"
                    // jika true, maka form anggota digunakan utk edit

                    # mengakses data anggota dari id_anggota yg dikirim
                    include "connection.php";
                    $id_anggota = $_GET["id_anggota"];
                    $sql = "select * from anggota where id_anggota='$id_anggota'";
                    # eksekusi perintah sql
                    $hasil = mysqli_query($connect, $sql);
                    # konversi hasil query ke bentuk array
                    $anggota = mysqli_fetch_array($hasil);
                    ?>

                <form action="process-anggota.php" method="post">
                    ID Anggota
                    <input type="text" name="id_anggota"
                    class="form-control mb-2" required
                    value="<?=$anggota["id_anggota"] ?>" readonly>

                    Nama Anggota
                    <input type="text" name="nama_anggota"
                    class="form-control mb-2" required
                    value="<?=$anggota["nama_anggota"] ?>">

                    Tanggal Lahir
                    <input type="date" name="tgl_lahir"
                    class="form-control mb-2" required
                    value="<?=$anggota["tgl_lahir"] ?>">

                    Alamat Anggota
                    <input type="text" name="alamat"
                    class="form-control mb-2" required
                    value="<?=$anggota["alamat"] ?>">

                    Nomor Telepon
                    <input type="text" name="telepon"
                    class="form-control mb-2" required
                    value="<?=$anggota["telepon"] ?>">

                    <button type="submit" class="btn btn-primary btn-block"
                    name="edit_anggota" onclick="return confirm('Apakah anda yakin?')">
                        Save
                    </button>
                </form>

                    <?php
                }else {
                    // jika false, maka form anggota digunakan utk insert
                    ?>

                <form action="process-anggota.php" method="post">
                    ID Anggota
                    <input type="text" name="id_anggota"
                    class="form-control mb-2" required>

                    Nama Anggota
                    <input type="text" name="nama_anggota"
                    class="form-control mb-2" required>

                    Tanggal Lahir
                    <input type="date" name="tgl_lahir"
                    class="form-control mb-2" required>

                    Alamat Anggota
                    <input type="text" name="alamat"
                    class="form-control mb-2" required>

                    Nomor Telepon
                    <input type="text" name="telepon"
                    class="form-control mb-2" required>

                    <button type="submit" class="btn btn-primary btn-block"
                    name="simpan_anggota" onclick="return confirm('Apakah anda yakin?')">
                        Save
                    </button>
                </form>

                    <?php
                }
                ?>
                
            </div>
        </div>
    </div>
</body>
</html>