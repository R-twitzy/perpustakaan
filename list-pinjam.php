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
    <title>Data Peminjaman</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="text-white">
                    Daftar Peminjaman
                </h4>
            </div>
            <div class="card-body">
                <!-- tombol tambah -->
                <a href="form-pinjam.php">
                    <button class="btn btn-outline-success btn-block">
                        Pinjam Buku
                    </button>
                </a>
                <hr>
                <ul class="list-group">
                    <?php
                    include "connection.php";
                    $sql = "select pinjam.*,anggota.*,petugas.*,pengembalian.kode_pengembalian,
                    pengembalian.tgl_pengembalian,pengembalian.denda
                    from pinjam 
                    inner join anggota on pinjam.id_anggota=anggota.id_anggota 
                    inner join petugas on pinjam.id_petugas=petugas.id_petugas
                    left outer join pengembalian on pinjam.kode_pinjam=pengembalian.kode_pinjam
                    order by kode_pinjam";

                    $hasil = mysqli_query($connect, $sql);
                    while($pinjam = mysqli_fetch_array($hasil)){
                        ?>
                        <li class="list-group-item">
                            <!-- Status Pengembalian-->
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <h5>
                                        <?php 
                                        if ($pinjam["kode_pengembalian"]==null) { ?>
                                            <div class="badge badge-warning">
                                                Masih dipinjam
                                            </div> 
                                            <a href="process-kembali.php?kode_pinjam=<?=($pinjam["kode_pinjam"])?>"
                                            onclick="return confirm('Apakah anda yakin?')">
                                            <button class="badge btn btn-outline-info mx-1">Kembalikan</button>
                                            </a>
                                            <?php } 
                                        else { ?>
                                            <div class="badge badge-dark">
                                                Sudah dikembalikan
                                            </div> 
                                            <h6>
                                                Denda: Rp <?=(number_format($pinjam["denda"],2))?>
                                            </h6><?php } ?> 
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <small class="text-info">Kode Pinjam</small>
                                    <h5><?=($pinjam["kode_pinjam"])?></h5>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <small class="text-info">Peminjam</small>
                                    <h5><?=($pinjam["nama_anggota"])?></h5>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <small class="text-info">Petugas</small>
                                    <h5><?=($pinjam["nama_petugas"])?></h5>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <small class="text-info">Tgl. Pinjam</small>
                                    <h5><?=($pinjam["tgl_pinjam"])?></h5>
                                </div>
                            </div>
                            <small class="text-success">Buku yang dipinjam</small>
                            <ul>
                                <?php
                                $kode_pinjam= $pinjam["kode_pinjam"];
                                $sql = "select * from detail_pinjam
                                inner join buku on detail_pinjam.isbn = buku.isbn
                                where kode_pinjam = '$kode_pinjam'";

                                $hasil_buku = mysqli_query($connect, $sql);
                                while($buku = mysqli_fetch_array($hasil_buku)){
                                    ?>
                                    <li>
                                        <small>
                                            <b><?=($buku["judul_buku"])?></b>
                                            <i class="ml-1 text-primary">Ditulis oleh <?=($buku["penulis"])?></i>
                                        </small>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
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