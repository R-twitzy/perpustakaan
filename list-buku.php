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
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="text-white">Daftar Buku</h4>
            </div>
            <div class="card-body">
                <!-- tombol tambah -->
                <a href="form-buku.php">
                    <button class="btn btn-outline-success btn-block">
                        Tambahkan Buku
                    </button>
                </a>
                <hr>
                <!-- search-->
                <form action="list-buku.php" method="get">
                    <input type="text" name="search"
                    class="form-control mb-3"
                    placeholder="Masukkan Keyword Pencarian">
                </form>
                <ul class="list-group">
                    <?php
                    include ("connection.php");
                    if (isset($_GET["search"])) {
                        # jika pd saat load halaman ini
                        # akan mengecek apakah ada data dgn method
                        # GET yg bernama search
                        $search = $_GET["search"];
                        $sql = "select * from buku
                        where isbn like '%$search%'
                        or judul_buku like '%$search%'
                        or penulis like '%$search%'
                        or penerbit like '%$search%'
                        or jumlah_halaman like '%$search%'
                        or genre like '%$search%'
                        or cover like '%$search%'";
                    } else {
                        $sql = "select * from buku";
                    }

                    //eksekusi perintah sql
                    $query = mysqli_query($connect, $sql);
                    while($buku = mysqli_fetch_array($query)){ ?>
                        <li class="list-group-item">
                            <div class="row">

                                <!-- bagian gambar buku-->
                                <div class="col-lg-4">
                                    <img src="cover/<?=$buku["cover"]?>"
                                    width="200">
                                </div>

                                <!-- bagian data buku-->
                                <div class="col-lg-6">
                                    <h5><?=$buku["judul_buku"]?></h5>
                                    <h6>ISBN : <?=$buku["isbn"]?></h6>
                                    <h6>Penulis : <?=$buku["penulis"]?></h6>
                                    <h6>Penerbit : <?=$buku["penerbit"]?></h6>
                                    <h6>Genre : <?=$buku["genre"]?></h6>
                                    <h6>Halaman : <?=$buku["jumlah_halaman"]?></h6>
                                </div>

                                <!-- tombol-->
                                <div class="col-lg-2">
                                <a href="form-buku.php?isbn=<?=$buku["isbn"]?>">
                                    <button class="btn btn-block btn-outline-primary mb-1">
                                        Edit
                                    </button>
                                </a>
                                <a href="process-buku.php?isbn=<?=$buku["isbn"]?>">
                                    <button class="btn btn-block btn-danger"
                                    onclick="return confirm('Apakah anda yakin?')">
                                        Remove
                                    </button>
                                </a>
                                </div>
                            </div>
                        </li>
                    <?php 
                    } 
                    ?>

                </ul>
            </div>
        </div>
    </div>
</body>
</html>