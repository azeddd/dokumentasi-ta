<?php include("config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dokumentasi Tugas Akhir</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <style type="text/css">
    body {
      padding-top: 70px;
      background: #eeeeee;
    }

    .container-body {
      background: #ffffff;
      box-shadow: 1px 1px 1px #999;
      padding: 20px;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap-filestyle.min.js"></script>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><strong>Dokumentasi</strong> Tugas Akhir</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Beranda</a></li>
          <li class="active"><a href="upload.php">Upload</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php
          if($_SESSION['user']){
            echo '<li><a href="profile.php">Profile</a></li>';
            echo '<li><a href="logout.php" onclick="return confirm(\'Yakin?\')">Logout</a></li>';
          }else{
            echo '<li><a href="login.php">Login</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container container-body">
    <center><h1>Upload Tugas Akhir</h1></center>
    <hr>

    <?php
    if(!$_SESSION['user']){
      echo '<div class="alert alert-danger">Anda harus login untuk membuka halaman ini.</div>';
    }else{
    ?>
      <!-- Default form contact -->
      <form>
          <!-- Default input name -->
          <label for="nama" class="grey-text">Nama Penyusun</label>
          <input name="nama" type="text" id="nama" class="form-control">

          <br>

          <!-- Default input email -->
          <label for="nama" class="grey-text">NIM</label>
          <input name="nim" type="text" id="nim" class="form-control">

          <br>
          <!-- Default textarea message -->
          <label for="judul" class="grey-text">Judul</label>
          <textarea name="judul" type="text" id="judul" class="form-control" rows="2"></textarea>

          <br>

          <!-- Default textarea message -->
          <label for="abstrak" class="grey-text">Abstrak</label>
          <textarea name="abstrak" type="text" id="abstrak" class="form-control" rows="3"></textarea>

          <br>

          <!-- Default input subject -->
          <label for="dosen" class="grey-text">Dosen Pembimbing</label>
          <input name="dosen" type="text" id="dosen" class="form-control">

          <br>

          <!-- Default textarea message -->
          <label for="tahun" class="grey-text">Tahun</label>
          <input name="tahun" type="text" id="tahun" class="form-control"></input>

          <br>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <div class="col-md-10">
              <input type="file" name="myFile" class="filestyle" data-icon="false">
            </div>
            <br>
            <div class="col-md-2">
              <input type="submit" name="upload" class="btn btn-primary" value="Upload"> <input type="submit" name="cancel" href="index.php" class="btn btn-primary" value="Batal">
            </div>
          </div>
        </form>

        <?php
        // definisi folder upload
        define("UPLOAD_DIR", "uploads/");

        if (!empty($_FILES["myFile"])) {
          $myFile = $_FILES["myFile"];
          $ext    = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
          $size   = $_FILES["myFile"]["size"];
          $tgl   = date("Y-m-d");

          if ($myFile["error"] !== UPLOAD_ERR_OK) {
            echo '<div class="alert alert-warning">Gagal upload file.</div>';
            exit;
          }

          // filename yang aman
          $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

          // mencegah overwrite filename
          $i = 0;
          $parts = pathinfo($name);
          while (file_exists(UPLOAD_DIR . $name)) {
            $i++;
            $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
          }

          // upload file
          $success = move_uploaded_file($myFile["tmp_name"],
            UPLOAD_DIR . $name);
          if (!$success) { 
            echo '<div class="alert alert-warning">Gagal upload file.</div>';
            exit;
          }else{

            $insert = $conn->query("INSERT INTO uploads(nama, nim, judul, dosen, tahun, tgl_upload, file_name, file_size, file_type) VALUES('$nama', '$nim', '$judul', '$dosen', '$tahun', '$tgl', '$name', '$size', '$ext')");
            
            if($insert){
              echo '<div class="alert alert-success">File berhasil di upload.</div>';
            }

            else{
              echo '<div class="alert alert-warning">Gagal upload file.</div>';
              exit;
            }
          }

          // set permisi file
          chmod(UPLOAD_DIR . $name, 0644);
        }
        ?>

      </div>
    </div>

    <?php
    }
    ?>

    <hr>
    <center>copyright &copy; 2018 <strong>Blank</strong></center>
  </div>

</body>
</html>