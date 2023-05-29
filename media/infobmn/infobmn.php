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
        $aksi = "media/aksi/appsPengaturan.php";
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
                        Pengecekan Belum atau Sudah <small>Untuk PSP dan Kondisi BMN</small>
                      </h1>
                    </section>
                    <section class="content">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id='info' class='form-horizontal' method='POST' action='' enctype='multipart/form-data'>
                                            <div class="form-group">
                                                    <label class="col-sm-2 control-label">Pencarian / Kategori </label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" name='pencarian' id='pencarian' onchange="tampilkan()">
                                                            <option value='BLANK'>PILIH</option>
                                                            <option value='01'>[01] - Penetapan Status Pengguna / PSP</option>
                                                            <option value='03'>[03] - Blank</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <select class="form-control" name='kategori' id='kategori'>
                                                            
                                                        </select>
                                                    </div>
                                                    <button type='submit' class='btn btn-primary btn-md'>
                                                    <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Cari</button>
                                            </div>
                                        </form>

                                        <?php
                                        $a = mysqli_query(
                                            $koneksi,
                                            "   SELECT  a.status_psp, a.status_kondisi, b.status_psp, b.uraianstatus_psp FROM dbtik a
                                                LEFT JOIN status_psp b ON b.status_psp = a.status_psp 
                                                WHERE  a.status_psp LIKE '%$_POST[kategori]%' 
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                    $cek = mysqli_query(
                                                        $koneksi,
                                                        "SELECT  a.kodebarang, a.nup, a.merek, a.status_psp,
                                                                 a.tglperoleh, a.status_kondisi,
                                                                 b.kd_brg, b.ur_sskel,
                                                                 c.status_psp, c.uraianstatus_psp,
                                                                 d.status_kondisi, d.uraian_kondisi

                                                         FROM dbtik a
                                                         LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                         LEFT JOIN status_psp c ON c.status_psp = a.status_psp 
                                                         LEFT JOIN kondisi_bmn d ON d.status_kondisi = a.status_kondisi 
                                                         WHERE a.status_psp LIKE '%$_POST[kategori]%' 
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
                                                        <td>[<?php echo "$r[status_kondisi]"; ?>] <?php echo "$r[uraian_kondisi]"; ?></td>
                                                        <td>[<?php echo "$r[status_psp]"; ?>] <?php echo "$r[uraianstatus_psp]"; ?></td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>
                                    <?php } ?>
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
<script>
function tampilkan(){
  var pencarian=document.getElementById("info").pencarian.value;
  if (pencarian=="01")
    {document.getElementById("kategori").innerHTML="<option value='BLANK'>PILIH</option><option value='01'>[01] - Belum Dilakukan PSP</option><option value='02'>[02] - Sudah Dilakukan PSP</option><option value='03'>[03] - Tidak Diketahui</option>";}

  else if (pencarian=="03")
    {document.getElementById("kategori").innerHTML="<option value='BLANK'>TIDAK ADA</option>";}
}
</script>