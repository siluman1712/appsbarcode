<?php
session_start();
if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
    echo "<link href='bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
      			<center>
      			Modul Tidak Bisa Di Akses,
      			Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
    $cek = user_akses($_GET['module'], $_SESSION['NIP']);
    if ($cek == 1 or $_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
        $aksi = "media/aksi/penghapusan.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin') {
                    $tgl = mysqli_query(
                        $koneksi,
                        "SELECT * FROM s_settgl
                         ORDER BY idtgl ASC"
                    );
                    $rs = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                    <section class="content-header">
                      <h1>
                        Export ke Excel <small>Sebagai Lampiran</small>
                      </h1>
                    </section>
                    <section class="content">

                    

                    <a class='btn bg-navy btn-md flat' href='<?php echo "media/cetak/exporxlsdist.php"; ?>' target='_blank'>
                    <i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;&nbsp; Export Excel</a>
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <table id="table_3" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Tanggal Distribusi </th>
                                                    <th bgcolor='#dcdcdc'> Gedung </th>
                                                    <th bgcolor='#dcdcdc'> Kode Ruangan </th>
                                                    <th bgcolor='#dcdcdc'> Nama Ruangan </th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang </th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang </th>
                                                    <th bgcolor='#dcdcdc'> No Aset </th>
                                                    <th bgcolor='#dcdcdc'> Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $dist = mysqli_query($koneksi, 
                                                          "SELECT a.tgldistribusi, a.ruanggedung, 
                                                                  a.koderuang, a.kodebarang, 
                                                                  a.noaset, a.keterangan,
                                                                  b.gedung, b.uraiangedung,
                                                                  c.kd_brg, c.ur_sskel, c.satuan,
                                                                  d.koderuangan, d.namaruangan
                                                           FROM dbdistribusi a
                                                           LEFT JOIN dbgedung b ON b.gedung = a.ruanggedung
                                                           LEFT JOIN b_nmbmn c ON c.kd_brg = a.kodebarang 
                                                           LEFT JOIN dbruangan d ON d.koderuangan = a.koderuang                                                   
                                                           ORDER BY a.ruanggedung ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($dist)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[tgldistribusi]"; ?></td>
                                                        <td>[<?php echo "$r[ruanggedung]"; ?>]&nbsp;
                                                            <?php echo "$r[uraiangedung]"; ?></td>

                                                        <td><?php echo "$r[koderuangan]"; ?></td>
                                                        <td><?php echo "$r[namaruangan]"; ?></td>

                                                        <td><?php echo "$r[kd_brg]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[noaset]"; ?></td>
                                                        <td><?php echo "$r[keterangan]"; ?></td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>
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
