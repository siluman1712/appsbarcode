<?php $b = getdate() ?>
<?php
error_reporting(0);
error_reporting('E_NONE');
session_start();
include "config/koneksi.php";
date_default_timezone_set("Asia/Bangkok");
$dbtik = mysqli_query($koneksi," SELECT  a.kodebarang, a.kodesatker,
                                            a.nup, a.merek, a.tglperoleh
                                    FROM dbtik a
                                    ORDER BY a.kodebarang ASC");
$tik = mysqli_num_rows($dbtik);

$dtUser = mysqli_query($koneksi," SELECT  a.UNAME, a.NIP, a.PASSWORD, a.LEVEL
                                  FROM a_useraktif a
                                  ORDER BY a.UNAME ASC");
$user = mysqli_num_rows($dtUser);

$unit = mysqli_query($koneksi," SELECT idminta, registrasi, unut, COUNT(registrasi) AS regis 
                                FROM c_unitsediaminta ORDER BY registrasi ASC");
$reg = mysqli_fetch_array($unit);

$keluar = mysqli_query($koneksi," SELECT id, registrasi, COUNT(kd_brg) AS brg_kel 
                                  FROM c_sediakeluarunit 
                                  ORDER BY registrasi ASC");
$out = mysqli_fetch_array($keluar);

if ($_GET['module'] == 'home') {
  echo "
      <!-- Main content -->
      <section class='content'>
        <!-- Small boxes (Stat box) -->
        <div class='row'>
          <div class='col-lg-3 col-xs-6'>
            <!-- small box -->
            <div class='small-box bg-aqua'>
              <div class='inner'>
                <h3>$tik</h3>
  
                <p>BMN Peralatan dan Mesin</p>
              </div>
              <div class='icon'>
                <i class='ion-pie-graph'></i>
              </div>
            </div>
          </div>
          <!-- ./col -->

          <div class='col-lg-3 col-xs-6'>
            <!-- small box -->
            <div class='small-box bg-green'>
              <div class='inner'>
                <h3>$user</h3>
  
                <p>BMN Non T I K</p>
              </div>
              <div class='icon'>
                <i class='ion ion-stats-bars'></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class='col-lg-3 col-xs-6'>
            <!-- small box -->
            <div class='small-box bg-yellow'>
              <div class='inner'>
                <h3>$reg[regis]</h3>
  
                <p>Pengajuan (UNIT)</p>
              </div>
              <div class='icon'>
                <i class='ion ion-person-add'></i>
              </div>
              <a href='#' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class='col-lg-3 col-xs-6'>
            <!-- small box -->
            <div class='small-box bg-red'>
              <div class='inner'>
                <h3>$out[brg_kel]</h3>
  
                <p>Transaksi Barang Keluar</p>
              </div>
              <div class='icon'>
                <i class='ion ion-pie-graph'></i>
              </div>
              <a href='#' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class='row'>

          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class='col-lg-5 connectedSortable'>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          sdkaljfkldsjfkl<br>
          </section>
      </section>
      <!-- /.content -->
      
";
} 

elseif ($_GET['module'] == 'satker') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/tabel/satker.php';
  }
} 

elseif ($_GET['module'] == 'kodefbmn') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/tabel/kodefbmn.php';
  }
}

elseif ($_GET['module'] == 'settgl') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/setting/s_settgl.php';
  }
}

elseif ($_GET['module'] == 'konfigruangan') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/setting/konfigruangan.php';
  }
}

elseif ($_GET['module'] == 'dbpegawai') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/setting/dbpegawai.php';
  }
}

elseif ($_GET['module'] == 'penandatanganan') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/setting/s_ttd.php';
  }
}

elseif ($_GET['module'] == 'pmtik') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/tabel/pmtik.php';
  }
}

elseif ($_GET['module'] == 'dbrumahnegara') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/tabel/dbrn.php';
  }
}

elseif ($_GET['module'] == 'labelrusakberat') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/cetak/labelrusakberat.php';
  }
}

elseif ($_GET['module'] == 'labelqrcode') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/cetak/labelqrcode.php';
  }
}

elseif ($_GET['module'] == 'hapusexcel') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/cetak/hapusexcel.php';
  }
}

elseif ($_GET['module'] == 'distexcel') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/cetak/distexcel.php';
  }
}

elseif ($_GET['module'] == 'distribusi') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/transaksi/distribusi.php';
  }
}

elseif ($_GET['module'] == 'pic') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/transaksi/pic.php';
  }
}

elseif ($_GET['module'] == 'scanbmn') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/transaksi/scanbmn.php';
  }
}

elseif ($_GET['module'] == 'penghapusan') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/transaksi/penghapusan.php';
  }
}

elseif ($_GET['module'] == 'bast') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/transaksi/bast.php';
  }
}

elseif ($_GET['module'] == 'uploadbast') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/transaksi/uploadbast.php';
  }
}

elseif ($_GET['module'] == 'perubahankondisi') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/transaksi/perubahankondisi.php';
  }
}

elseif ($_GET['module'] == 'infobmn') {
  if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    include 'media/infobmn/infobmn.php';
  }
}

?>