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
    <title>Form Buku</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white">
                    Form Buku
                </h4>
            </div>
            <div class="card-body">
                <?php
                if (isset($_GET["isbn"])) {
                    #form utk edit
                    # mengakses data anggota dari isbn yg dikirim
                    include "connection.php";
                    $isbn = $_GET["isbn"];
                    $sql = "select * from buku 
                    where isbn='$isbn'";
                    # eksekusi perintah sql
                    $hasil = mysqli_query($connect, $sql);
                    # konversi hasil query ke bentuk array
                    $buku = mysqli_fetch_array($hasil);
                    ?>
                    <form action="process-buku.php" method="post"
                    enctype="multipart/form-data">
                        ISBN
                        <input type="number" name="isbn"
                        class="form-control mb-2" required
                        value="<?=$buku["isbn"] ?>" readonly>

                        Judul Buku
                        <input type="text" name="judul_buku"
                        class="form-control mb-2" required
                        value="<?=$buku["judul_buku"] ?>">

                        Penulis
                        <input type="text" name="penulis"
                        class="form-control mb-2" required
                        value="<?=$buku["penulis"] ?>">

                        Penerbit
                        <input type="text" name="penerbit"
                        class="form-control mb-2" required
                        value="<?=$buku["penerbit"] ?>">

                        Jumlah Halaman
                        <input type="number" name="jumlah_halaman"
                        class="form-control mb-2" required
                        value="<?=$buku["jumlah_halaman"] ?>">

                        Genre
                        <select name="genre" class="form-control mb-2" required">
                            <option value="<?=$buku["genre"] ?>">
                                <?=$buku["genre"] ?>
                            </option>
                            <option value="Novel">Novel</option>
                            <option value="Sains">Sains</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Religi">Religi</option>
                            <option value="Romansa">Romansa</option>
                            <option value="Dokumenter">Dokumenter</option>
                        </select>

                        Cover <br>
                        <img src="cover/<?=$buku["cover"] ?>" width="150">
                        <input type="file" name="cover"
                        class="form-control mb-2">

                        <button type="submit" class="btn btn-primary btn-block" name="edit_buku"
                        onclick="return confirm('Apakah anda yakin?')">
                            Save
                        </button>
                    </form>
                <?php
                } else {
                    #form utk insert ?>
                    <form action="process-buku.php" method="post"
                    enctype="multipart/form-data">
                        ISBN
                        <input type="number" name="isbn"
                        class="form-control mb-2" required>

                        Judul Buku
                        <input type="text" name="judul_buku"
                        class="form-control mb-2" required>

                        Penulis
                        <input type="text" name="penulis"
                        class="form-control mb-2" required>

                        Penerbit
                        <input type="text" name="penerbit"
                        class="form-control mb-2" required>

                        Jumlah Halaman
                        <input type="number" name="jumlah_halaman"
                        class="form-control mb-2" required>

                        Genre
                        <select name="genre" class="form-control mb-2" required>
                            <option value="Novel">Novel</option>
                            <option value="Sains">Sains</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Religi">Religi</option>
                            <option value="Romansa">Romansa</option>
                            <option value="Dokumenter">Dokumenter</option>
                        </select>

                        Cover
                        <input type="file" name="cover"
                        class="form-control mb-2" required>

                        <button type="submit" class="btn btn-primary btn-block" name="simpan_buku">
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