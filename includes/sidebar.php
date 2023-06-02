<?php
$info = mysqli_query(
  $koneksi,
  "SELECT a.NIP, b.PNS_NIPBARU, b.PNS_PNSNAM 
          FROM a_useraktif a
          LEFT JOIN m_pupns b ON b.pns_nip = a.NIP
          ORDER BY id ASC"
);
$rs    = mysqli_fetch_array($info);
?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li><a href="?module=pmtik">
        <i class="fa fa-database"></i>
        Database Aset / BMN &nbsp;&nbsp;&nbsp;
        </a></li>

        <li><a href="?module=scanbmn" title="Scan BMN">
        <i class="fa fa-sun-o"></i>
        Scan Barang / Daftar&nbsp;&nbsp;&nbsp; 
        </a>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-tasks"></i> <span>Transaksi BMN</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                <li><a href="?module=distribusi">
                <i class="fa fa-paper-plane text-aqua"></i>
                &nbsp;&nbsp;&nbsp;Distribusi / Loc &nbsp;&nbsp;&nbsp;
                </a></li>

                <li><a href="?module=uploadbast">
                <i class="fa fa-paper-plane text-aqua"></i>
                &nbsp;&nbsp;&nbsp;Upload BAST &nbsp;&nbsp;&nbsp;
                </a></li>

                <li><a href="?module=pic">
                <i class="fa fa-user text-aqua"></i>
                &nbsp;&nbsp;&nbsp;[PIC] BMN &nbsp;&nbsp;&nbsp;
                </a></li>

                <li><a href="?module=perubahankondisi" title="perubahan kondisi">
                <i class="fa fa-tasks text-aqua"></i>
                &nbsp;&nbsp;&nbsp;Perubahan Kondisi BMN&nbsp;&nbsp;&nbsp; 
                </a>
                </li>

                <li><a href="?module=pemeliharaan" title="Pemeliharaan BMN">
                <i class="fa fa-tasks text-aqua"></i>
                &nbsp;&nbsp;&nbsp;Pemeliharaan BMN&nbsp;&nbsp;&nbsp; 
                </a>
                </li>

                <li><a href="?module=peminjaman" title="Peminjaman BMN">
                <i class="fa fa-tasks text-aqua"></i>
                &nbsp;&nbsp;&nbsp;Pinjam Pakai BMN&nbsp;&nbsp;&nbsp; 
                </a>
                </li>

                <li><a href="?module=penghapusan" title="penghapusan BMN">
                <i class="fa fa-tasks text-aqua"></i>
                &nbsp;&nbsp;&nbsp;Penghapusan BMN&nbsp;&nbsp;&nbsp; 
                </a>
                </li>

          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-print"></i> <span>Cetak</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                <li><a href="?module=labelqrcode">
                <i class="fa fa-qrcode text-red">
                </i>&nbsp;&nbsp;&nbsp;Label Registrasi [qrcode]&nbsp;&nbsp;&nbsp;</a></li>

                <li><a href="?module=labelrusakberat">
                <i class="fa fa-qrcode text-red">
                </i>&nbsp;&nbsp;&nbsp;Label Rusak Berat&nbsp;&nbsp;&nbsp;</a></li>

                <li><a href="?module=bast">
                <i class="fa fa-sticky-note text-red"></i>
                &nbsp;&nbsp;&nbsp;BAST &nbsp;&nbsp;&nbsp;
                </a></li>

                <li><a href="?module=bast">
                <i class="fa fa-sticky-note text-red"></i>
                &nbsp;&nbsp;&nbsp;Lampiran (Hapus / PSP) &nbsp;&nbsp;&nbsp;
                </a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-home"></i> <span>Database Rumah Negara</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                <li><a href="?module=#">
                <i class="fa fa-plus text-red">
                </i>&nbsp;&nbsp;&nbsp;Daftar Rumah Negara&nbsp;&nbsp;&nbsp;</a></li>

                <li><a href="?module=#">
                <i class="fa fa-user text-red"></i>
                &nbsp;&nbsp;&nbsp;Penghuni Rumah Negara&nbsp;&nbsp;&nbsp;
                </a></li>
                
          </ul>
        </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>