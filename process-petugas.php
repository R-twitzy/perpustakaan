<?php
include("connection.php");

# untuk insert petugas
if (isset($_POST["simpan_petugas"])) {
    // tampung data input petugas dari user
    $id_petugas = $_POST["petugas"];
    $nama_petugas = $_POST["nama_petugas"];
    $kontak = $_POST["kontak"];
    $username = $_POST["username"];
    $password = sha1($_POST["password"]);

    # mmanage upload file
    $fileName = $_FILES["foto"]["name"]; // file name
    $extension = pathinfo($_FILES["foto"]["name"]);
    $ext = $extension["extension"]; //extensi file

    $foto = time()."-".$fileName;

    #proses upload
    $folderName = "foto/$foto";
    if (move_uploaded_file($_FILES["foto"]["tmp_name"],$folderName)) {
        // membuat perintah sql utk insert data ke tbl petugas
        $sql = "insert into petugas values ('$id_petugas', '$nama_petugas', 
        '$kontak', '$username', '$password', '$foto')";

        // eksekusi perintah sql
        mysqli_query($connect, $sql);

        // direct ke halaman list petugas
        header("location: list-petugas.php");
    } else{
        echo "Upload File Gagal";
    }
    
}

# untuk edit petugas
else if (isset($_POST["edit_petugas"])) {
    // tampung data edit petugas dari user
    $id_petugas = $_POST["id_petugas"];
    $nama_petugas = $_POST["nama_petugas"];
    $kontak = $_POST["kontak"];
    $username = $_POST["username"];

    # jika update data dan gambar
    if (!empty($_FILES["foto"]["name"])) {
        # ambil data nama file yg akan dihapus
        $sql ="select * from petugas where id_petugas='$id_petugas'";
        # eksekusi perintah sql
        $hasil = mysqli_query($connect, $sql);
        # konversi hasil query ke bentuk array
        $petugas = mysqli_fetch_array($hasil);  
        
        $oldFileName = $petugas["foto"];

        # membuat path file yg lama
        $path = "foto/$oldFileName";

        # cek eksistensi file lama
        if (file_exists($path)){
            # hapus file lama
            unlink($path);
        }

        # membuat file name baru 
        $foto = time()."-".$_FILES["foto"]["name"];
        $folder = "foto/$foto";

        # proses upload file baru
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $folder)) {
            if (empty($_POST["password"])) {
                $sql = "update petugas set id_petugas='$id_petugas', nama_petugas='$nama_petugas',
                kontak='$kontak', username='$username', foto='$foto' where id_petugas='$id_petugas'";
            } else {
                $password = sha1($_POST["password"]);
                $sql = "update petugas set id_petugas='$id_petugas', nama_petugas='$nama_petugas',
                kontak='$kontak', username='$username', 
                password='$password', foto='$foto' where id_petugas='$id_petugas'";
            }

            if (mysqli_query($connect, $sql)) {
                5header("location:list-petugas.php");
            } else {
                echo "gagal boss";
            }
        }
    }
    # jika update data 
    else {
        if (empty($_POST["password"])) {
            $sql = "update petugas set id_petugas='$id_petugas', nama_petugas='$nama_petugas',
            kontak='$kontak', username='$username'where id_petugas='$id_petugas'";
        } else {
            $password = sha1($_POST["password"]);
            $sql = "update petugas set id_petugas='$id_petugas', nama_petugas='$nama_petugas',
            kontak='$kontak', username='$username', 
            password='$password' where id_petugas='$id_petugas'";
        }

            if (mysqli_query($connect, $sql)) {
                header("location:list-petugas.php");
            } else {
                echo "gagal boss";
            }
    }
}

elseif (isset($_GET["id_petugas"])) {
    $id_petugas = $_GET['id_petugas'];

     # ambil data nama file yg akan dihapus
     $sql ="select * from petugas where id_petugas='$id_petugas'";
     # eksekusi perintah sql
     $hasil = mysqli_query($connect, $sql);
     # konversi hasil query ke bentuk array
     $petugas = mysqli_fetch_array($hasil);  
     
     $oldFileName = $petugas["foto"];

     # membuat path file yg lama
     $path = "foto/$oldFileName";

     # cek eksistensi file lama
     if (file_exists($path)){
         # hapus file lama
         unlink($path);
     }

     $sql ="delete from petugas where id_petugas = '".$id_petugas."'" ;
     # eksekusi perintah sql
     $hasil = mysqli_query($connect, $sql);
     header("location:list-petugas.php");
}

?>