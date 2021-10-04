<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "akademik";

$koneksi = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){ //cek koneksi
   die("Tidak bisa terkoneksi ke database");
}
$nis       = "";
$nama      = "";
$alamat    = "";
$sekolah   = "";
$jurusan   = "";
$sukses    = "";
$error     = "";

if(isset($_GET['op'])){
   $op = $_GET['op'];
}else{
   $op = "";
}
if($op == 'delete'){
   $id    = $_GET['id'];
   $sql1  = "delete from mahasiswa where id = '$id'";
   $q1    = mysqli_query($koneksi,$sql1);
   if($q1){
      $sukses = "Berhasil menghapus data";
   }else{
      $error  = "Gagal menghapus data";
   }
}

if($op == 'edit'){
   $id        = $_GET['id'];
   $sql1      = "SELECT * FROM mahasiswa WHERE id = '$id'";
   $q1        = mysqli_query($koneksi,$sql1);
   $r1        = mysqli_fetch_array($q1);
   $nis       = $r1['nis'];
   $nama      = $r1['nama'];
   $alamat    = $r1['alamat'];
   $sekolah   = $r1['sekolah'];
   $jurusan   = $r1['jurusan'];

   if($nis == ''){
      $error = "Data tidak ditemukan";
   }
}
if(isset($_POST['simpan'])){ //utuk create
   $nis      = $_POST['nis'];
   $nama     = $_POST['nama'];
   $alamat   = $_POST['alamat'];
   $sekolah  = $_POST['sekolah'];
   $jurusan  = $_POST['jurusan'];

   if($nis && $nama && $alamat && $sekolah && $jurusan){ 
         if($op == 'edit'){ // untuk update
         $sql1   = "update mahasiswa set nis = '$nis', nama = '$nama', alamat = '$alamat', sekolah = '$sekolah', jurusan = '$jurusan' where id = '$id'";
         $q1     = mysqli_query($koneksi,$sql1);
         if($q1){
            $sukses  = "Data berhasil diupdate";
         }else{
            $error   = "Data gagal diupdate";
         }
    }else{ //untuk insert
      $sql1 = "insert into mahasiswa(nis,nama,alamat,sekolah,jurusan) values ('$nis','$nama','$alamat','$sekolah','$jurusan')";
      $q1   = mysqli_query($koneksi,$sql1);
      if($q1){
         $sukses   = "berhasil memasukkan data baru";
      }else{
         $error    = "Gagal memasukkan data";
      }
      }
      

   }else{
      $error = "Silahkan masukkan semua data";
   }

}
?>
<!DOCTYPE html>
<html lang="en">
   
<title>Data Siswa</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>    
<body>
<div class="container">
<!-- <img src="img/2.jpg" class="rounded float-end" alt="..."> -->
<h1 class="text-center">Data Siswa</h1>
<h2 class="text-center">SMKN 26 JAKARTA</h2>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
      .mx-auto { width:1000px }
      .card { margin-top: 10px;}
      </style>
  </head>

<body>
    <div class="mx-auto">
        <!--untuk memasukkan data-->
        <div class="card">
           <div class="card-header text-white bg-success">
              Form Input Data Siswa
          </div>
          <div class="card-body">
             <?php
             if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                       <?php echo $error ?>
                    </div>
                <?php
                   header("refresh:5;url=index.php"); // 5 detik
                }
               ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                       <?php echo $sukses ?>
                    </div>
                <?php
                   header("refresh:5;url=index.php"); // 5 detik
                }
               ?>

           <form action ="" method="POST">
           <div class="mb-3 row">
              <label for="nis" class="col-sm-2 col-form-label">NIS</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nis" name="nis" value="<?php echo $nis ?>" placeholder="Masukkan NIS anda disini!" >
              </div>
           </div>
           <div class="mb-3 row">
              <label for="nama" class="col-sm-2 col-form-label">Nama</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>" placeholder="Masukkan Nama anda disini!" >
              </div>
           </div>
           <div class="mb-3 row">
              <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>"placeholder="Masukkan Alamat anda disini!" >
              </div>
               </div>
              <div class="mb-3 row">
              <label for="sekolah" class="col-sm-2 col-form-label">Sekolah</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="sekolah" name="sekolah"  value="<?php echo $sekolah ?>" placeholder="Masukkan Sekolah anda disini!">
              </div>
           </div>
           <div class="mb-3 row">
              <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
              <div class="col-sm-10">
                 <select class="form-control" name="jurusan" id="jurusan">
                    <option value="">- Pilih Jurusan -</option>
                     <option value="konstruksi gedung sanitasi perawatan" <?php if($jurusan == "konstruksi gedung sanitasi perawatan") echo "selected"?>>Konstruksi Gedung Sanitasi Perawatan</option>
                     <option value="teknik fabrikasi logam manufaktur"<?php if($jurusan == "teknik fabrikasi logam manufaktur") echo "selected"?> >Teknik Fabrikasi Logam dan Manufaktur</option>
                     <option value="teknik tenaga listrik"<?php if($jurusan == "teknik tenaga listrik") echo "selected"?> >Teknik Tenaga Listrik</option>
                     <option value="sistem informatika jaringan aplikasi"<?php if($jurusan == "sistem informatika jaringan aplikasi") echo "selected"?> >Sistem Informatika Jaringan Aplikasi</option>
                     <option value="teknik elektronika daya komunikasi"<?php if($jurusan == "teknik elektronika daya komunikasi") echo "selected"?> >Teknik Elektronika Daya Komunikasi</option>
                     <option value="teknik manajemen perawatan otomotif"<?php if($jurusan == "teknik manajemen perawatan otomotif") echo "selected"?> >Teknik Manajemen Perawatan Otomotif</option>



                </select>
             </div>
           </div>
           <div class="col-12">
              <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary"/>
           </div>
       </form>
    </div>
</div>

<!--untu mengeluarkan data-->
       <div class="card">
           <div class="card-header text-white bg-success">
              Data Siswa
          </div>
         <div class="card-body">
           <table class="table">
              <thead>
                 <tr>
                    <th scope="col">#</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Sekolah</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Aksi</th>
                 </tr>
                  <tbody>
                     <?php
                  
                     $sql2  = "SELECT * FROM mahasiswa order by id desc";
                     $q2    = mysqli_query($koneksi,$sql2);
                     $urut  = 1;
                     while($r2 = mysqli_fetch_array($q2)){
                        $id       = $r2['id'];
                        $nis      = $r2['nis'];
                        $nama     = $r2['nama'];
                        $alamat   = $r2['alamat'];
                        $sekolah  = $r2['sekolah'];
                        $jurusan  = $r2['jurusan'];

                        ?>
                         <tr>
                            <th scope="row"><?php echo $urut++ ?></th>
                            <td scope="row"><?php echo $nis ?></td>
                            <td scope="row"><?php echo $nama ?></td>
                            <td scope="row"><?php echo $alamat ?></td>
                            <td scope="row"><?php echo $sekolah ?></td>
                            <td scope="row"><?php echo $jurusan ?></td>
                            <td scope="row">
                               <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                               <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin ingin mau delete data?')"> <button type="button" class="btn btn-danger">Delete</button></a>
                                    
                            </td>
                         </tr>
                        <?php



                     }
                     ?>
                  </tbody>
              </thead>
       </div>
     </div> 
</div>
</body>

</html>