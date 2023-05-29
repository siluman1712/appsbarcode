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
        $aksi = "docs/aksi/l_barcode.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tgl = mysqli_query($koneksi,"SELECT * FROM s_settgl ORDER BY idtgl ASC");
                    $rs        = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                    
                    <section class="content-header">
                      <h1>Cetak Label Registrasi [QRCODE]
                      </h1>
                    </section>

                    <section class="content">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="box box box-primary"> 
                                    <div class="box-header with-border">
                                        <h6 class="box-title">Setting Label QR Code / Input</h6>
                                    </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method='post' class='form-horizontal' action=''>
                                            <div class='form-group'>
                                                <div class='col-sm-4'>
                                                    <select class="select2 form-control" style="width: 100%" name='kodebarang'>
                                                        <option value='<?php echo "$_POST[nupAW]"; ?>'><?php echo "$_POST[nupAW]"; ?></option>
                                                        <?php
                                                        $dataSql = "SELECT  a.kd_brg, a.ur_sskel, a.satuan
                                                                    FROM b_nmbmn a 
                                                                    ORDER BY a.kd_brg ASC";
                                                        $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['kd_brg'] == $_POST['kd_brg']) {
                                                                $cek = " selected";
                                                            } else {
                                                                $cek = "";
                                                            }
                                                            echo "
                                                        <option value='$dataRow[kd_brg]' $cek>$dataRow[kd_brg]  -  $dataRow[ur_sskel]</option>";
                                                        }
                                                        $sqlData = "";
                                                        ?>
                                                    </select>
                                                    <small> Pilih Kode BMN 31001xxxxx </small>
                                                </div>
                                            </div>


                                                    <div class="form-group">
                                                        <div class="col-sm-1">
                                                        <input type="text" maxlength="3" class="form-control" name='qty' id="qty" value='<?php echo "$_POST[qty]"; ?>' onkeyup=sum2();>
                                                        <small>Kuantitas</small>
                                                        </div>
                                                        <div class="col-sm-1">
                                                        <input type="text" class="form-control" maxlength="3" name='nupAW' id="nupAW" value='<?php echo "$_POST[nupAW]"; ?>' onkeyup=sum2();>
                                                        <small>Awal</small>
                                                        </div>

                                                        <div class="col-sm-1">
                                                        <input type="text" class="form-control" maxlength="3" name='nupAK' id="nupAK" value='<?php echo "$_POST[nupAK]"; ?>' readonly>
                                                        <small>Akhir</small>
                                                        </div>

                                                
                                            <button type='submit' name='preview' class='btn btn-md btn-primary flat'>
                                                <i class='fa fa-search'></i>&nbsp;&nbsp; view</button>
                                            
                                            </div>
                                        </form>
<?php
                                        $a = mysqli_query(
                                            $koneksi,
                                            "   SELECT  a.kodebarang, a.nup, a.prosedur,
                                                        b.kd_brg, b.ur_sskel
                                                FROM   dbtik a
                                                LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                WHERE  a.kodebarang ='$_POST[kodebarang]'
                                                AND a.nup BETWEEN '$_POST[nupAW]' AND '$_POST[nupAK]'
                                                ORDER BY a.kodebarang AND a.nup ASC"
                                        );
                                        $data = mysqli_fetch_array($a);
                                        $cekdata = mysqli_num_rows($a);
                                        if (isset($_POST['kodebarang']) and isset($_POST['nupAW']) and isset($_POST['nupAK']) && $cekdata == 0) {
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
                                                            <font color='#fff'>Tgl Peroleh</font>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cek = mysqli_query(
                                                        $koneksi,
                                                        "SELECT  a.kodebarang, a.nup, 
                                                                 a.prosedur, a.merek,
                                                                 a.tglperoleh,
                                                                 b.kd_brg, b.ur_sskel
                                                         FROM   dbtik a
                                                         LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                         WHERE  a.kodebarang ='$_POST[kodebarang]'
                                                         AND a.nup BETWEEN '$_POST[nupAW]' AND '$_POST[nupAK]'
                                                         ORDER BY a.kodebarang AND a.nup ASC"
                                                    );

                                                    $numRows = mysqli_num_rows($cek);
                                                    $no = 0;
                                                    while ($r = mysqli_fetch_array($cek)) {
                                                        $no++;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo "$no"; ?></td>
                                                            <td><?php echo "$r[kd_brg]"; ?></td>
                                                            <td><?php echo "$r[ur_sskel]"; ?></b></td>
                                                            <td><?php echo "$r[nup]"; ?></td>
                                                            <td><?php echo "$r[merek]"; ?></td>
                                                            <td><?php echo "$r[tglperoleh]"; ?></td>
                                                        </tr>
                                                        </tfoot>
                                                    <?php }
                                                    if ($cekdata == 0) {
                                                    ?>

                                                    <?php } else { ?>
                                                        <form method=POST action='<?php echo "media/cetak/cetaklabel.php?kodebarang=$_POST[kodebarang]&nupAW=$_POST[nupAW]&nupAK=$_POST[nupAK]"; ?>' target='_blank'>
                                                            <p><button type=submit class='btn bg-navy btn-md'><i class='fa fa-print'></i>
                                                                    &nbsp;&nbsp;&nbsp;Tampilkan Label Barcode</button></p>
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