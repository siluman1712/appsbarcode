<?php
include "config/koneksi.php";
$query = "SELECT a.NIP, a.LOGIN_TERAKHIR, 
                 b.PNS_NIPBARU, b.PNS_PNSNAM 
          FROM a_useraktif a
          LEFT JOIN m_pupns b ON b.PNS_NIPBARU = a.NIP
          WHERE a.NIP = '$_SESSION[NIP]'
          ORDER BY a.NIP ASC";
$info = $koneksi->query($query);
$rs    = mysqli_fetch_array($info);
?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
    
    <li class="header"><font color='#fff'>MENU UTAMA</font></li>
        <li><a href="?module=pmtik">
        <i class="fa fa-database"></i>
        Database Aset / BMN &nbsp;&nbsp;&nbsp;
        </a></li>

        <li><a href="?module=pendetailanbmn">
        <i class="fa fa-database"></i>
        Pendetailan BMN &nbsp;&nbsp;&nbsp;
        </a></li>

        <li><a href="?module=scanbmn" title="Scan BMN">
        <i class="fa fa-sun-o"></i>
        Scan Barang / Daftar &nbsp;&nbsp;&nbsp; 
        </a>
        </li>

        <li><a href="?module=distribusi">
        <i class="fa fa-plane"></i>
        Distribusi BMN / Loc. BMN &nbsp;&nbsp;&nbsp; 
        </a>
        </li>

        <li><a href="?module=perubahankondisi" title="perubahan kondisi">
        <i class="fa fa-retweet"></i>
        Perubahan Kondisi BMN&nbsp;&nbsp;&nbsp;
        </a>
        </li>

        <li><a href="?module=uploadbast">
        <i class="fa fa-upload"></i>
        Upload BAST &nbsp;&nbsp;&nbsp; 
        </a>
        </li>

        <li><a href="?module=pic">
        <i class="fa fa-user"></i>
        [PIC] BMN &nbsp;&nbsp;&nbsp; 
        </a>
        </li>

    <li class="header"><font color='#fff'>MENU TRANSAKSI</font></li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-tasks"></i> <span>BARANG MILIK NEGARA</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li>
          <a href="?module=penghapusan" title="penghapusan BMN">
          <button class='btn bg-red btn-xs flat' >&nbsp;Proses Penghapusan BMN &nbsp;&nbsp;&nbsp;</button>
          </a>
          </li>

          <li><a href="?module=pemeliharaan" title="Pemeliharaan BMN">
          <button class='btn bg-green btn-xs flat' >&nbsp;Pemeliharaan BMN &nbsp;&nbsp;&nbsp; </button>
          </a>
          </li>

          <li><a href="?module=peminjaman" title="Peminjaman BMN">
          <button class='btn bg-green btn-xs flat' >&nbsp;Pinjam Pakai BMN&nbsp;&nbsp;&nbsp;</button>
          </a>
          </li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-print"></i> <span>CETAK</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                <li><a href="?module=labelqrcode">
                <button class='btn bg-green btn-xs flat' >Label Registrasi [qrcode]</button>
                </a></li>

                <li><a href="?module=labelrusakberat">
                <button class='btn bg-green btn-xs flat' >Label Rusak Berat</button>
                </a></li>   

                <li><a href="?module=bast">
                <button class='btn bg-red btn-xs flat' >BASTB</button>
                </a></li>

                <li><a href="?module=hapusexcel">
                <button class='btn bg-gray btn-xs flat' >Exp. Lamp Hapus (.xls)</button>
                </a></li>

                <li><a href="?module=distexcel">
                <button class='btn bg-gray btn-xs flat' >Exp. Lamp Distribusi (.xls)</button>
                </a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-home"></i> <span>RUMAH NEGARA</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                <li>
                <a href="?module=dbrumahnegara">
                <button class='btn bg-olive btn-xs flat' >
                <i class='fa fa-database text-white'></i>&nbsp;&nbsp;Database Rumah Negara&nbsp;&nbsp;&nbsp;</button>
                </a>
                </li>

                <li>
                <a href="?module=siprumahnegara">
                <button class='btn bg-olive btn-xs flat' >
                <i class='fa fa-plus text-white'></i>&nbsp;&nbsp;Daftarkan Rumah Negara&nbsp;&nbsp;&nbsp;</button>
                </a>
                </li>

                <li>
                <a href="?module=sipupdatestatus">
                <button class='btn bg-blue btn-xs flat' >
                <i class='fa fa-retweet text-white'></i>&nbsp;&nbsp;Update Status SIP&nbsp;&nbsp;&nbsp;</button>
                </a>
                </li>
                
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-car"></i> <span>KENDARAAN DINAS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li>
            <a href="?module=#">
            <button class='btn bg-red btn-ms flat' >
            <i class='fa fa-bomb text-white'></i>&nbsp;&nbsp;UNDER CONTRUCTION&nbsp;&nbsp;&nbsp;</button>
            </a>
            </li>
                
          </ul>
        </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>