<?php 
include "config/koneksi.php";

$query = "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl ORDER BY idtgl ASC";
$tgl = $koneksi->query($query);
$rs = mysqli_fetch_array($tgl);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>APPENDIXII | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte_2.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="dist/img/appendiks_logo.png" alt="AdminLTE Logo"  height="100" width="300" >
    </div>
    <div class="card-body">

                      <?php  
                      if(isset($_GET['pesan'])){
                        if($_GET['pesan'] == "gagal_login"){
                          echo "
                          <div class='alert alert-danger' align='center'><font color='#fff'><small>Login gagal! username dan password salah!.</small></font>
                          </div>";
                        }else if($_GET['pesan'] == "logout"){
                          echo "<div class='alert alert-success' align='center'><font color='#fff'><small>Logout Sukses! Anda berhasil Keluar.</small></font>
                          </div>";
                        }else if($_GET['pesan'] == "belum_login"){
                          echo "
                          <div class='alert alert-info' align='center'><font color='#fff'><small>Anda harus login untuk mengakses halaman ini.</small></font>
                          </div>";
                        }else if($_GET['pesan'] == "captcha"){
                          echo "
                          <div class='alert alert-danger' align='center'><font color='#fff'><small>Kode Pengaman Salah Coba Lagi.</small></font>
                          </div>";
                        }else if($_GET['pesan'] == "kosong"){
                          echo "
                          <div class='alert alert-info' align='center'><font color='#fff'><small>Username dan Password Masih kosong</small></font>
                          </div>";
                        }else if($_GET['pesan'] == "waktu_habis"){ 
                          echo "
                          <div class='alert alert-danger' align='center'><font color='#fff'><small>Waktu habis, Logout Otomatis</small></font>
                          </div>";
                        }
                      }
                      ?>

      <form action="ceklog.php" method="post">

        <div class="input-group mb-1">
          <input type="text" class="form-control" placeholder="User Name" name="uname">
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="fa fa-user"></i>
            </div>
          </div>
        </div>

        <div class="input-group mb-1">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="fa fa-lock"></i>
            </div>
          </div>
        </div>

        <div class="input-group mb-1">
          <input type="text" class="form-control" value='<?php echo "$rs[s_thnang]";?>' readonly>
          <div class="input-group-append">
            <div class="input-group-text">
              <strong>T A</strong>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" id="captcha" name="captcha" class="form-control" placeholder="jumlahkan">
          <div class="input-group-append">
              <img class="captchaImg" src="config/captcha.php" align="left">
          </div>
        </div>



        <div class="row">
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block"><i class="nav-icon fas fa-sign"></i>&nbsp;&nbsp;Masuk</button>
          </div>
          <div class="col-6">
            <button type="reset" class="btn btn-danger btn-block"><i class="nav-icon fas fa-retweet"></i>&nbsp;&nbsp;Reset</button>
          </div>
          <!-- /.col -->
        </div>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
