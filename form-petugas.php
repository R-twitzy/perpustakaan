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
    <title>Form Petugas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white">
                    Form Petugas
                </h4>
            </div>
            <div class="card-body">
                <?php
                if (isset($_GET["id_petugas"])) {
                    #form utk edit
                    # mengakses data petugas dari id yg dikirim
                    include "connection.php";
                    $id_petugas = $_GET["id_petugas"];
                    $sql = "select * from petugas 
                    where id_petugas='$id_petugas'";
                    # eksekusi perintah sql
                    $hasil = mysqli_query($connect, $sql);
                    # konversi hasil query ke bentuk array
                    $petugas = mysqli_fetch_array($hasil);
                    ?>
                    <form action="process-petugas.php" method="post"
                    enctype="multipart/form-data">
                        ID
                        <input type="number" name="id_petugas"
                        class="form-control mb-2" required
                        value="<?=$petugas["id_petugas"] ?>" readonly>

                        Nama
                        <input type="text" name="nama_petugas"
                        class="form-control mb-2" required
                        value="<?=$petugas["nama_petugas"] ?>">

                        Kontak
                        <input type="text" name="kontak"
                        class="form-control mb-2" required
                        value="<?=$petugas["kontak"] ?>">

                        Username
                        <input type="text" name="username"
                        class="form-control mb-2" required
                        value="<?=$petugas["username"] ?>">

                        Password
                        <input type="text" name="password"
                        class="form-control mb-2">

                        Foto <br>
                        <img src="foto/<?=$petugas["foto"] ?>" width="150">
                        <input type="file" name="foto"
                        class="form-control mb-2">

                        <button type="submit" class="btn btn-primary btn-block" name="edit_petugas"
                        onclick="return confirm('Apakah anda yakin?')">
                            Save
                        </button>
                    </form>
                <?php
                } else {
                    #form utk insert ?>
                    <form action="process-petugas.php" method="post"
                    enctype="multipart/form-data">

                        Nama
                        <input type="text" name="nama_petugas"
                        class="form-control mb-2" required>

                        Kontak
                        <input type="text" name="kontak"
                        class="form-control mb-2" required>

                        Username
                        <input type="text" name="username"
                        class="form-control mb-2" required>

                        Password
                        <input type="password" name="password"
                        class="form-control mb-2" required>

                        Foto
                        <input type="file" name="foto"
                        class="form-control mb-2" required>

                        <button type="submit" class="btn btn-primary btn-block" name="simpan_petugas">
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