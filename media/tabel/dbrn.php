<?php
session_start();
error_reporting(0);
error_reporting('E_NONE');
include('../../config/fungsi_indotgl.php');
if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
    echo "<link href='bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
      			<center>
      			Modul Tidak Bisa Di Akses,
      			Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
    $cek = user_akses($_GET['module'], $_SESSION['NIP']);
    if ($cek == 1 or $_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
        $aksi = "media/aksi/dbrn.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tgl = mysqli_query(
                        $koneksi,
                        "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl
                         ORDER BY idtgl ASC"
                    );
                    $rs     = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                    <section class="content-header">
                      <h1>Database Bangunan Gedung 
                      <small>Bangunan Gedung Rumah Negara</small>
                      </h1>
                    </section>

                    <section class="content">
                    <a class='btn bg-navy btn-md flat' href=<?php echo "?module=dbrumahnegara&act=tambah"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp; Tambah Rumah Negara</a>
                        <div class="row">
                        <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table_3" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> id </th>
                                                    <th bgcolor='#dcdcdc'> Nama Satker</th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang</th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset</th>
                                                    <th bgcolor='#dcdcdc'> Merek</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Luas (SBSK)</th>
                                                    <th bgcolor='#dcdcdc'> Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tik = mysqli_query($koneksi, 
                                                          "SELECT a.kodesatker, a.kodebarang, 
                                                                  a.tglbuku, a.status_kondisi,
                                                                  a.nup, a.merek, a.tglperoleh, 
                                                                  a.status_psp, a.tgl_psp, a.nomor_psp,
                                                                  a.luas_sbsk, a.status_penggunaan,
                                                                  a.merek,
                                                                  b.kd_brg, b.ur_sskel, 
                                                                  c.kdukpb, c.nmukpb,
                                                                  e.uraianstatus_psp, e.status_psp,
                                                                  f.status_kondisi, f.uraian_kondisi,
                                                                  g.id_status, g.ur_status
                                                           FROM dbrumahnegara a
                                                           LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                           LEFT JOIN s_satker c ON c.kdukpb = a.kodesatker
                                                           LEFT JOIN status_psp e ON e.status_psp = a.status_psp
                                                           LEFT JOIN kondisi_bmn f ON f.status_kondisi = a.status_kondisi
                                                           LEFT JOIN status_penggunaan g ON g.id_status = a.status_penggunaan
                                                           ORDER BY a.kodebarang ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($tik)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[nmukpb]"; ?></td>
                                                        <td><?php echo "$r[kodebarang]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[nup]"; ?></td>
                                                        <td><?php echo "$r[merek]"; ?></td>
                                                        <td><?php echo "$r[tglperoleh]"; ?></td>
                                                        <td><?php echo "$r[luas_sbsk]"; ?></td>
                                                        <td>
                                                        <a class='btn bg-blue btn-sm'
                                                        href=<?php echo "?module=dbrumahnegara&act=detail&kodebmn=$r[kodebarang]&noaset=$r[nup]"; ?>>
                                                        <i class="fa fa-search"></i> &nbsp;&nbsp; details   
                                                        </a>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>    
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </section>

               <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "detail":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                        $qry = "SELECT  a.kodebarang, a.nup, a.luas_sbsk,
                                        b.kd_brg, b.ur_sskel
                                FROM dbrumahnegara a
                                LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                ORDER BY a.kodebarang AND  a.nup ASC";
                        $detail = mysqli_query($koneksi, $qry );
                        $rs = mysqli_fetch_array($tgl); 
                    ?>
    
                        <section class="content">
    
                            <a class='btn btn-danger btn-sm' href=<?php echo "?module=siprumahnegara"; ?>><i class='fa fa-arrow-left'></i>&nbsp;&nbsp;&nbsp;KEMBALI</a>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                <form class='form-horizontal' method='POST' action='' enctype='multipart/form-data'>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Kode BMN</label>
                                                            <div class="col-sm-2">
                                                            <input type="text" maxlength="10" class="form-control" name='kodebmn' value='<?php echo "$_POST[kodebmn]"; ?>'>
                                                            <small>Kode BMN</small>
                                                            </div>
    
                                                            <div class="col-sm-1">
                                                            <input type="text" class="form-control" maxlength="3" name='noaset' value='<?php echo "$_POST[noaset]"; ?>'>
                                                            <small>NUP</small>
                                                            </div>
                                                        
                                                        <div class="form-group">
                                                            <button type="submit" class="btn bg-green btn-md flat"><i class="fa fa-check"></i> &nbsp;&nbsp;Cek Detail</button>
                                                            </div>
                                                        </div>
    
                                                </form>
                                                <?php
                                                $a = mysqli_query(
                                                    $koneksi,
                                                    "   SELECT  a.status_psp, a.status_kondisi, a.status_bmn, 
                                                                b.status_psp, b.uraianstatus_psp,
                                                                c.appsstatus, c.uraianstatus
                                                                FROM dbtik a
                                                        LEFT JOIN status_psp b ON b.status_psp = a.status_psp 
                                                        LEFT JOIN bmnstatus c ON c.appsstatus = a.status_bmn 
                                                        WHERE  a.status_psp LIKE '%$_POST[kategori]%' OR a.status_bmn LIKE '%$_POST[kategori]%' 
                                                        ORDER BY a.status_psp ASC"
                                                );
                                                $data = mysqli_fetch_array($a);
                                                $cekdata = mysqli_num_rows($a);
                                                if (isset($_POST['kategori']) && $cekdata == 0) {
                                                    echo "
                                                                    <div class='alert bg-blue' role='alert'>
                                                                    <h4><i class='ik ik-alert-octagon'></i> Pemberitahuan!</h4>
                                                                    Data Tidak Ditemukan!
                                                                    </div>";
                                                } else {
                                                ?>
                                                <table id="table_3" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#dcdcdc'> No </th>
                                                        <th bgcolor='#dcdcdc'> Kode Barang</th>
                                                        <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                        <th bgcolor='#dcdcdc'> No Aset</th>
                                                        <th bgcolor='#dcdcdc'> Merek</th>
                                                        <th bgcolor='#dcdcdc'> Tgl Perolehan</th>
                                                        <th bgcolor='#dcdcdc'> Kondisi</th>
                                                        <th bgcolor='#dcdcdc'> Status PSP</th>
                                                        <th bgcolor='#dcdcdc'> Status BMN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <?php
                                                        $cek = mysqli_query(
                                                            $koneksi,
                                                            "SELECT  a.kodebarang, a.nup, a.merek, a.status_psp,
                                                                     a.tglperoleh, a.status_kondisi, a.status_bmn,
                                                                     b.kd_brg, b.ur_sskel,
                                                                     c.status_psp, c.uraianstatus_psp,
                                                                     d.status_kondisi, d.uraian_kondisi,
                                                                     e.appsstatus, e.uraianstatus
    
                                                             FROM dbtik a
                                                             LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                             LEFT JOIN status_psp c ON c.status_psp = a.status_psp 
                                                             LEFT JOIN kondisi_bmn d ON d.status_kondisi = a.status_kondisi 
                                                             LEFT JOIN bmnstatus e ON e.appsstatus = a.status_bmn 
                                                             WHERE  a.status_psp LIKE '%$_POST[kategori]%' OR a.status_bmn LIKE '%$_POST[kategori]%' 
                                                             ORDER BY a.kodebarang AND a.nup ASC"
                                                        );
    
                                                        $numRows = mysqli_num_rows($cek);
                                                        $no = 0;
                                                        while ($r = mysqli_fetch_array($cek)) {
                                                            $no++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo "$no"; ?></td>
                                                            <td><?php echo "$r[kodebarang]"; ?></td>
                                                            <td><?php echo "$r[ur_sskel]"; ?></td>
                                                            <td><?php echo "$r[nup]"; ?></td>
                                                            <td><?php echo "$r[merek]"; ?></td>
                                                            <td><?php echo "$r[tglperoleh]"; ?></td>
                                                            <td>[<?php echo "$r[status_kondisi]"; ?>] 
                                                                <span class="badge bg-green"><?php echo "$r[uraian_kondisi]"; ?></span></td>
                                                            <td>[<?php echo "$r[status_psp]"; ?>] 
                                                                <span class="badge bg-green"><?php echo "$r[uraianstatus_psp]"; ?></span></td>
                                                            <td><span class="badge bg-green">[<?php echo "$r[status_bmn]"; ?>] <?php echo "$r[uraianstatus]"; ?></span></td>
                                                        </tr>
                                                        </tfoot>
                                                    <?php } ?>
                                                </table>
                                                <?php } ?>
                                                </div>
                                            </div>        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php
                    } else {
                        echo "Anda tidak berhak mengakses halaman ini.";
                    }
                    break;
                ?>
<?php
        }
    }
}
?>