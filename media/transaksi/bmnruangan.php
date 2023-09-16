

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
    if ($cek == 1 or $_SESSION['LEVEL'] == 'admin') {
        $aksi = "docs/aksi/bmnruangan.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tgl = mysqli_query($koneksi,"SELECT * FROM s_settgl ORDER BY idtgl ASC");
                    $rs        = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                    
                    <section class="content-header">
                      <h1>bmn ruangan <small>[daftar inventaris]</small>
                      </h1>
                    </section>

                    <section class="content">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="box box box-primary"> 
                                    <div class="box-header with-border">
                                        <h6 class="box-title">setting</h6>
                                    </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method='post' class='form-horizontal' action=''>
                                            <div class='form-group'>
                                                <div class='col-sm-5'>
                                                    <select class="s2 form-control" style="width: 100%" name='koderuang'>
                                                        <option value='BLANK'>PILIH RUANGAN</option>
                                                        <?php
                                                        $dataSql = "SELECT  a.koderuangan, a.namaruangan, 
                                                                            a.luasruangan
                                                                    FROM dbruangan a 
                                                                    ORDER BY a.koderuangan ASC";
                                                        $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['koderuangan'] == $_POST['koderuang']) {
                                                                $cek = " selected";
                                                            } else {
                                                                $cek = "";
                                                            }
                                                            echo "
                                                        <option value='$dataRow[koderuangan]' $cek>$dataRow[koderuangan]  -  $dataRow[namaruangan]</option>";
                                                        }
                                                        $sqlData = "";
                                                        ?>
                                                    </select>
                                                </div>                                                   

                                                <button type='submit' name='preview' class='btn btn-md btn-primary flat'>
                                                <i class='fa fa-search'></i>&nbsp;&nbsp; view</button>
                                            </div>
                                        </form>
<?php
                                        $a = mysqli_query(
                                            $koneksi,
                                            "   SELECT  a.kodebarang, a.noaset, a.keterangan,
                                                        a.koderuang, a.tgldistribusi, 
                                                        a.penguasaan, a.lokins, 
                                                        b.kd_brg, b.ur_sskel,
                                                        c.koderuangan, c.namaruangan,
                                                        d.kodebarang, d.nup, d.merek, 
                                                        d.t_anggaran,
                                                        f.penguasaan, f.ur_penguasaan
                                                FROM   dbdistribusi a
                                                LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                LEFT JOIN dbruangan c ON c.koderuangan = a.koderuang
                                                LEFT JOIN dbtik d ON d.kodebarang = a.kodebarang AND d.nup = a.noaset
                                                LEFT JOIN status_penguasaanbmn f ON f.penguasaan = a.penguasaan
                                                WHERE  a.koderuang ='$_POST[koderuang]'
                                                ORDER BY a.koderuang ASC"
                                        );
                                        $data = mysqli_fetch_array($a);
                                        $cekdata = mysqli_num_rows($a);
                                        if (isset($_POST['koderuang']) && $cekdata == 0) {
                                            echo "
                                                            <div class='alert bg-blue' role='alert'>
                                                            <h4><i class='ik ik-alert-octagon'></i> Pemberitahuan!</h4>
                                                            Data Tidak Ditemukan!
                                                            </div>";
                                        } else {
                                        ?>
                                            <table id='simpletable' class='table table-bordered table-striped'>
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#4682B4' style='width: 7px'>
                                                            <font color='#fff'>#</font>
                                                        </th>

                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>kode barang</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Uraian BMN</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Nomor Aset</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Merek</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Tahun Perolehan</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Penguasaan</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Keterangan</font>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cek = mysqli_query(
                                                        $koneksi,
                                                        "SELECT a.kodebarang, a.noaset, a.keterangan,
                                                                a.koderuang, a.tgldistribusi, 
                                                                a.penguasaan, a.lokins, 
                                                                b.kd_brg, b.ur_sskel,
                                                                c.koderuangan, c.namaruangan,
                                                                d.kodebarang, d.nup, d.merek, 
                                                                d.t_anggaran,
                                                                f.penguasaan, f.ur_penguasaan
                                                        FROM   dbdistribusi a
                                                        LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                        LEFT JOIN dbruangan c ON c.koderuangan = a.koderuang
                                                        LEFT JOIN dbtik d ON d.kodebarang = a.kodebarang AND d.nup = a.noaset
                                                        LEFT JOIN status_penguasaanbmn f ON f.penguasaan = a.penguasaan
                                                        WHERE  a.koderuang ='$_POST[koderuang]'
                                                        ORDER BY a.koderuang ASC"
                                                    );

                                                    $numRows = mysqli_num_rows($cek);
                                                    $no = 0;
                                                    while ($r = mysqli_fetch_array($cek)) {
                                                        $no++;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo "$no"; ?></td>
                                                            <td><?php echo "$r[kodebarang]"; ?></td>
                                                            <td><?php echo "$r[ur_sskel]"; ?></b></td>
                                                            <td><?php echo "$r[noaset]"; ?></td>
                                                            <td><?php echo "$r[merek]"; ?></td>
                                                            <td><?php echo "$r[t_anggaran]"; ?></td>
                                                            <td><?php echo "$r[ur_penguasaan]"; ?></td>
                                                            <td>[<?php echo "$r[keterangan]"; ?>]
                                                            </td>

                                                        </tr>
                                                        </tfoot>
                                                    <?php }
                                                    if ($cekdata == 0) {
                                                    ?>

                                                    <?php } else { ?>
                                                        <form method=POST action='<?php echo "media/cetak/bmnruangan.php?ruang=$_POST[koderuang]"; ?>' target='_blank'>
                                                            <p><button type=submit class='btn bg-navy btn-md'><i class='fa fa-print'></i>
                                                                    &nbsp;&nbsp;&nbsp; Kartu Inventaris Barang Ruangan </button></p>
                                                        </form>
                                                    <?php } ?>
                                            </table>
                                            <font face=tahoma size=2>Jumlah Data: <b><?php echo "$numRows"; ?></b></font>
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