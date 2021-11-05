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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Daftar Petugas Perpustakaan</title>
</head>
<body>
<div class="container">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="text-white">Data Petugas Perpustakaan</h4>
            </div>
            <div class="card-body">
                <!-- tombol daftar -->
                <a href="form-petugas.php">
                    <button class="btn btn-outline-success btn-block">
                        Tambahkan Petugas
                    </button>
                </a>
                <hr>
                <!-- kotak pencarian data petugas -->
                <form action="list-petugas.php" method="get">
                    <input type="text" name="search"
                    class="form-control mb-3"
                    placeholder="Masukan Keyword Pencarian"
                    required>
                </form>
                <ul class="list-group">
                    <?php
                    include("connection.php");
                    if (isset($_GET["search"])) {
                        # jika pd saat load halaman ini
                        # akan mengecek apakah ada data dgn method
                        # GET yg bernama search
                        $search = $_GET["search"];
                        $sql = "select * from petugas
                        where id_petugas like '%$search%'
                        or nama_petugas like '%$search%'
                        or kontak like '%$search%'
                        or username like '%$search%'";
                    } else {
                        $sql = "select * from petugas";
                    }
                    //eksekusi perintah sql
                    $hasil = mysqli_query($connect, $sql);
                    while($petugas = mysqli_fetch_array($hasil)){ ?>
                        <li class="list-group-item">
                        <div class="row">
                            <!-- bagian gambar petugas-->
                            <div class="col-lg-3">
                                <img src="foto/<?=$petugas["foto"]?>"
                                width="200">
                            </div>

                            <!-- bagian data petugas-->
                            <div class="col-lg-7 col-md-7">
                                <h5>Nama Petugas : <?php echo $petugas["nama_petugas"];?></h5>
                                <h6>ID Petugas : <?php echo $petugas["id_petugas"];?></h6>
                                <h6>Username : <?php echo $petugas["username"];?></h6>
                                <h6>Kontak : <?php echo $petugas["kontak"];?></h6>
                            </div>

                            <!-- bagian tombol pilihan-->
                            <div class="col-lg-2 col-md-2">
                                <a href="form-petugas.php?id_petugas=<?=$petugas["id_petugas"]?>">
                                    <button class="btn btn-block btn-outline-primary mb-1">
                                        Edit
                                    </button>
                                </a>
                                <a href="process-petugas.php?id_petugas=<?=$petugas["id_petugas"]?>">
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