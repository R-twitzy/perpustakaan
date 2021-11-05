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
    <title>Daftar Anggota Perpustakaan</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="text-white">Data Anggota Perpustakaan</h4>
            </div>
            <div class="card-body">
                <!-- tombol daftar -->
                <a href="form-anggota.php">
                    <button class="btn btn-outline-success btn-block">
                        Daftar Menjadi Anggota
                    </button>
                </a>
                <hr>
                <!-- kotak pencarian data anggota -->
                <form action="list-anggota.php" method="get">
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
                        $sql = "select * from anggota
                        where id_anggota like '%$search%'
                        or nama_anggota like '%$search%'
                        or tgl_lahir like '%$search%'
                        or alamat like '%$search%'
                        or telepon like '%$search%'";
                    } else {
                        $sql = "select * from anggota";
                    }
                    //eksekusi perintah sql
                    $query = mysqli_query($connect, $sql);
                    while($anggota = mysqli_fetch_array($query)){ ?>
                        <li class="list-group-item">
                        <div class="row">
                            <!-- bagian data anggota-->
                            <div class="col-lg-10 col-md-10">
                                <h5>Nama Anggota : <?php echo $anggota["nama_anggota"];?></h5>
                                <h6>ID Anggota : <?php echo $anggota["id_anggota"];?></h6>
                                <h6>Tanggal Lahir : <?php echo $anggota["tgl_lahir"];?></h6>
                                <h6>Alamat : <?php echo $anggota["alamat"];?></h6>
                                <h6>Telepon : <?php echo $anggota["telepon"];?></h6>
                            </div>

                            <!-- bagian tombol pilihan-->
                            <div class="col-lg-2 col-md-2">
                                <a href="form-anggota.php?id_anggota=<?=$anggota["id_anggota"]?>">
                                    <button class="btn btn-block btn-outline-primary mb-1">
                                        Edit
                                    </button>
                                </a>
                                <a href="delete.php?id_anggota=<?=$anggota["id_anggota"]?>">
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