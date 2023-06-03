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
                        Daftarkan Penghapusan <small>Tentukan Kondisi Rusak Berat</small>
                      </h1>
                    </section>
                    <section class="content">

                    

                    <a class='btn bg-navy btn-md flat' href=<?php echo "media/cetak/exporxls.php?kodebarang=$_POST[kodebarang]&nupAW=$_POST[nupAW]&nupAK=$_POST[nupAK]"; ?>' target='_blank'>
                    <i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;&nbsp; Export Excel</a>
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <table id="table_4" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th bgcolor="#dcdcdc"> No</th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang</th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset</th>
                                                    <th bgcolor='#dcdcdc'> Kuantitas</th>
                                                    <th bgcolor='#dcdcdc'> Satuan</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Nilai Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Nilai Limit</th>
                                                    <th bgcolor='#dcdcdc'> Nilai Buku</th>
                                                    <th bgcolor='#dcdcdc'> Kondisi BMN</th>
                                                    <th bgcolor='#dcdcdc'> Merek</th>
                                                    <th bgcolor='#dcdcdc'> flag</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                    $hapus = mysqli_query(
                                                        $koneksi,
                                                        "SELECT a.kodebarang, a.noaset, a.qty,
                                                                a.flag, a.kondisi, a.nilailimit, 
                                                                a.nilaibuku, a.tglperolehan, 
                                                                a.nilaiperolehan, a.satuan,
                                                                b.kd_brg, b.ur_sskel, 
                                                                c.kodebarang, c.nup, c.hargaperolehan,
                                                                c.merek, c.tglperoleh, 
                                                                d.status_kondisi, d.uraian_kondisi
                                                        FROM   dbpenghapusan a
                                                        LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                        LEFT JOIN dbtik c ON c.kodebarang = a.kodebarang AND c.nup = a.noaset
                                                        LEFT JOIN kondisi_bmn d ON d.status_kondisi = a.kondisi
                                                        WHERE  a.kondisi ='33' AND a.flag IN('2','3')
                                                        ORDER BY a.kodebarang AND a.noaset ASC"
                                                    );

                                                    $numRows = mysqli_num_rows($hapus);
                                                    $no = 0;
                                                    while ($rs = mysqli_fetch_array($hapus)) {
                                                        $no++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$rs[kodebarang]"; ?></td>
                                                        <td><?php echo "$rs[ur_sskel]"; ?></td>
                                                        <td><?php echo "$rs[nup]"; ?></td>
                                                        <td><?php echo "$rs[qty]"; ?></td>
                                                        <td><?php echo "$rs[satuan]"; ?></td>
                                                        <td><?php echo "$rs[tglperolehan]"; ?></td>
                                                        <td><?php echo "$rs[nilaiperolehan]"; ?></td>
                                                        <td><?php echo "$rs[nilailimit]"; ?></td>
                                                        <td><?php echo "$rs[nilaibuku]"; ?></td>
                                                        <td><?php echo "$rs[uraian_kondisi]"; ?></td>
                                                        <td><?php echo "$rs[merek]"; ?></td>
                                                        <td><span class="badge bg-maroon"> <?php echo "$rs[flag]"; ?></span></td>
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
