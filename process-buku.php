<?php
include("connection.php");

# untuk insert buku
if (isset($_POST["simpan_buku"])) {
    // tampung data input buku dari user
    $isbn = $_POST["isbn"];
    $judul_buku = $_POST["judul_buku"];
    $penulis = $_POST["penulis"];
    $penerbit = $_POST["penerbit"];
    $jumlah_halaman = $_POST["jumlah_halaman"];
    $genre = $_POST["genre"];

    # mmanage upload file
    $fileName = $_FILES["cover"]["name"]; // file name
    $extension = pathinfo($_FILES["cover"]["name"]);
    $ext = $extension["extension"]; //extensi file

    $cover = time()."-".$fileName;

    #proses upload
    $folderName = "cover/$cover";
    if (move_uploaded_file($_FILES["cover"]["tmp_name"],$folderName)) {
        // membuat perintah sql utk insert data ke tbl buku
        $sql = "insert into buku values ('$isbn', '$judul_buku', 
        '$penulis', '$penerbit', '$jumlah_halaman', '$genre', '$cover')";

        // eksekusi perintah sql
        mysqli_query($connect, $sql);

        // direct ke halaman list buku
        header("location: list-buku.php");
    } else{
        echo "Upload File Gagal";
    }
    
}

# untuk edit buku
elseif (isset($_POST["edit_buku"])) {
    // tampung data edit buku dari user
    $isbn = $_POST["isbn"];
    $judul_buku = $_POST["judul_buku"];
    $penulis = $_POST["penulis"];
    $penerbit = $_POST["penerbit"];
    $jumlah_halaman = $_POST["jumlah_halaman"];
    $genre = $_POST["genre"];

    # jika update data dan gambar
    if (!empty($_FILES["cover"]["name"])) {
        # ambil data nama file yg akan dihapus
        $sql ="select * from buku where isbn='$isbn'";
        # eksekusi perintah sql
        $hasil = mysqli_query($connect, $sql);
        # konversi hasil query ke bentuk array
        $buku = mysqli_fetch_array($hasil);  
        
        $oldFileName = $buku["cover"];

        # membuat path file yg lama
        $path = "cover/$oldFileName";

        # cek eksistensi file lama
        if (file_exists($path)){
            # hapus file lama
            unlink($path);
        }

        # membuat file name baru 
        $cover = time()."-".$_FILES["cover"]["name"];
        $folder = "cover/$cover";

        # proses upload file baru
        if (move_uploaded_file($_FILES["cover"]["tmp_name"], $folder)) {
            $sql = "update buku set judul_buku='$judul_buku', penulis='$penulis',
            penerbit='$penerbit', jumlah_halaman='$jumlah_halaman', 
            genre='$genre', cover='$cover' where isbn='$isbn'";

            if (mysqli_query($connect, $sql)) {
                header("location:list-buku.php");
            } else {
                echo "gagal boss";
            }
        }
    }
    # jika update data 
    else {
        $sql = "update buku set judul_buku='$judul_buku', penulis='$penulis',
            penerbit='$penerbit', jumlah_halaman='$jumlah_halaman', 
            genre='$genre' where isbn='$isbn'";

            if (mysqli_query($connect, $sql)) {
                header("location:list-buku.php");
            } else {
                echo "gagal boss";
            }
    }
}

elseif (isset($_GET["isbn"])) {
    $isbn = $_GET['isbn'];

     # ambil data nama file yg akan dihapus
     $sql ="select * from buku where isbn='$isbn'";
     # eksekusi perintah sql
     $hasil = mysqli_query($connect, $sql);
     # konversi hasil query ke bentuk array
     $buku = mysqli_fetch_array($hasil);  
     
     $oldFileName = $buku["cover"];

     # membuat path file yg lama
     $path = "cover/$oldFileName";

     # cek eksistensi file lama
     if (file_exists($path)){
         # hapus file lama
         unlink($path);
     }

     $sql ="delete from buku where isbn = '".$isbn."'" ;
     # eksekusi perintah sql
     $hasil = mysqli_query($connect, $sql);
     header("location:list-buku.php");
}

?>