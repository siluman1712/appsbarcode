<?php 
include "config/koneksi.php";
$tgl = mysqli_query($koneksi, "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl ORDER BY idtgl ASC" );
$rs  = mysqli_fetch_array($tgl);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/fonts/icomoon/style.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/login/css/bootstrap.min.css" >
    <link rel="stylesheet" href="assets/login/css/style.css" >  
    <link href="assets/css/main.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
    <title>Apps-Layanan Umum</title>
  </head>
  <body>
  
    <div class="content"> 
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-5">
          <img src='assets/images/logo.png' class="rounded" width='500' height='100'/>
          <h6 class="text-right">MODUL - APPSBARCODE </h6>
          </div>
          <div class="col-md-2 text-center">
          </div>
                <div class="log">
                    <!-- NOTIFIKASI -->
                      <?php  
                      if(isset($_GET['pesan'])){
                        if($_GET['pesan'] == "gagal_login"){
                          echo "
                          <div class='alert alert-danger' align='center'><font color='#000'><small>Login gagal! username dan password salah!.</small></font>
                          </div>";
                        }else if($_GET['pesan'] == "logout"){
                          echo "<div class='alert alert-success' align='center'><font color='#000'><small>Logout Sukses! Anda berhasil Keluar.</small></font>
                          </div>";
                        }else if($_GET['pesan'] == "belum_login"){
                          echo "
                          <div class='alert alert-info' align='center'><font color='#000'><small>Anda harus login untuk mengakses halaman ini.</small></font>
                          </div>";
                        }else if($_GET['pesan'] == "captcha"){
                          echo "
                          <div class='alert alert-danger' align='center'><font color='#020'><small>Kode Pengaman Salah Coba Lagi.</small></font>
                          </div>";
                        }else if($_GET['pesan'] == "kosong"){
                          echo "
                          <div class='alert alert-info' align='center'><font color='#020'><small>Username dan Password Masih kosong</small></font>
                          </div>";
                        }else if($_GET['pesan'] == "waktu_habis"){
                          echo "
                          <div class='alert alert-danger' align='center'><font color='#000'><small>Waktu habis, Logout Otomatis</small></font>
                          </div>";
                        }
                      }
                      ?>
                    <!-- END NOTIF -->
                    <hr>
                    <form action="ceklog.php" method="post">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend"> 
                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                          </div>
                          <input type="text" name="uname" class="form-control" placeholder="Masukkan Username">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend"> 
                            <div class="input-group-text"><i class="fa fa-unlock-alt"></i></div>
                          </div>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend"> 
                            <div class="input-group-text">TA</div>
                          </div>
                        <input type="text" class="form-control" value='<?php echo "$rs[s_thnang]";?>' readonly>
                        </div>
                      </div>

                      
                      <div class="form-group">
                      <table width="100%">
                        <tr>
                          <td>
                          <img class="captchaImg" src="config/captcha.php" align="left">
                          </td>
                          <td>
                          <div class="col-md-8">
                          <input type="text" id="captcha" name="captcha" class="form-control" placeholder="jumlahkan">
                          </div>
                          </td>
                        </tr>
                      </table>
                      </div>

                      <button type="submit" class="btn btn-primary btn-ms"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;
                      Masuk</button> 
                      <button type="reset" class="btn btn-danger btn-ms"><i class="fa fa-retweet"></i>&nbsp;&nbsp;
                      Reset</button> 
                    </form>
                    <hr>
                  </div>
        </div>
      </div>
    </div>

  
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>