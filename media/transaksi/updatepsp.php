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
        $aksi = "media/aksi/scanbmn.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin') {
                    $query  = "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl ORDER BY idtgl ASC";
                    $tgl    = $koneksi->query($query);
                    $rs     = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                    <section class="content-header">
                      <h1>
                        Update PSP - SK PSP
                        <small>BMN Aktif yang di sahkan Kantor Pusat sebagai BMN </small>
                      </h1>
                    </section>
                    <section class="content">
                    <a class='btn bg-blue btn-sm' href=<?php echo "?module=updatepsp&act=addpsp"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Update PSP</a>
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <table id="table_3" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Kode Barang </th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset / NUP</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Harga Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Merek / Keterangan</th>
                                                    <th bgcolor='#dcdcdc'> TA</th>
                                                    <th bgcolor='#dcdcdc'> Status PSP</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tik = $koneksi->query( 
                                                          "SELECT a.kodebarang, a.nup, a.merek, 
                                                                  a.tglperoleh, a.t_anggaran, 
                                                                  a.hargaperolehan, a.kodesatker,  
                                                                  a.kondisibarang, a.status_psp,
                                                                  b.kd_brg, b.ur_sskel, 
                                                                  c.kdukpb, c.nmukpb,
                                                                  d.status_psp, d.uraianstatus_psp
                                                           FROM dbtik a
                                                           LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                           LEFT JOIN s_satker c ON c.kdukpb = a.kodesatker
                                                           LEFT JOIN status_psp d ON d.status_psp = a.status_psp
                                                           WHERE (a.status_psp IN ('01','03'))
                                                           ORDER BY a.kodebarang ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($tik)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[kodebarang]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[nup]"; ?></td>
                                                        <td><?php echo "$r[tglperoleh]"; ?></td>
                                                        <td><?php echo "$r[hargaperolehan]"; ?></td>
                                                        <td><?php echo "$r[merek]"; ?></td>       
                                                        <td><?php echo "$r[t_anggaran]"; ?></td> 
                                                        <td>
                                                        <?php if($r['status_psp']=='01'){?>
                                                        <span class="badge bg-red">
                                                        <?php echo "$r[status_psp]"; ?></span>
                                                        <span class="badge bg-red">
                                                        <?php echo "$r[uraianstatus_psp]"; ?></span>
                                                        <?php }else{ ?>
                                                        <span class="badge bg-maroon">
                                                        <?php echo "$r[status_psp]"; ?></span>
                                                        <span class="badge bg-maroon">
                                                        <?php echo "$r[uraianstatus_psp]"; ?></span>
                                                        <?php }?>
                                                        </td>
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

                case "addpsp":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                
                $update    = $koneksi->query($query);
                $rs     = mysqli_fetch_array($update);
                ?>

                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">

                                            <form class='form-horizontal' method='POST' action='' enctype='multipart/form-data'>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Kode BMN</label>
                                                        <div class="col-sm-1">
                                                        <input type="text" maxlength="10" class="form-control" name='kodebmn' value='<?php echo "$_POST[kodebmn]"; ?>'>
                                                        <small>Kode BMN</small>
                                                        </div>

                                                        <button type="submit" class="btn bg-green btn-md flat"><i class="fa fa-check"></i> &nbsp;&nbsp;Scan</button>
                                                        </div>
                                                    </div>

                                            </form>

                                              <?php
                                                $query = "  SELECT  a.kodebarang, a.nup, a.merek, 
                                                                    a.tglperoleh, a.t_anggaran, 
                                                                    a.hargaperolehan, a.kodesatker,  
                                                                    a.kondisibarang, a.status_psp,
                                                                    b.kd_brg, b.ur_sskel, 
                                                                    c.kdukpb, c.nmukpb,
                                                                    d.status_psp, d.uraianstatus_psp
                                                            FROM dbtik a
                                                            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                            LEFT JOIN s_satker c ON c.kdukpb = a.kodesatker
                                                            LEFT JOIN status_psp d ON d.status_psp = a.status_psp
                                                            WHERE (a.status_psp IN ('01','03')) 
                                                            AND a.kodebarang='$_POST[kodebmn]' 
                                                            ORDER BY a.kodebarang ASC";
                                                $a = $koneksi->query($query);
                                                $rs = mysqli_fetch_array($a);
                                                $cekdata = mysqli_num_rows($a);
                                                if(isset($_POST['kodebmn']) && $cekdata==0 ){
                                                  echo "
                                                  <h4>Ulang Lagi</h4> Cek Pengisian / Data Belum lengkap ";
                                                }else{
                                              ?>


                                            <form class="form-horizontal" method="post" action='<?php echo "$aksi?module=pmtik&act=addbmn";?>' enctype='multipart/form-data'>
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Tahun Anggaran</label>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" name='t_anggaran' id="t_anggaran" value='<?php echo "$rs[t_anggaran]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Kode Satuan Kerja</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" name='kdukpb' id="kdukpb" value='<?php echo "$rs[kdukpb]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Nama Satuan Kerja</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name='nmukpb' id="kdukpb" value='<?php echo "$rs[nmukpb]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                    <label for="Unit Utama" class="col-sm-2 control-label">Kode Barang</label>

                                                    <div class="col-sm-6">
                                                        <select class="form-control s2" name='kodebarang'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT kd_brg, ur_sskel
                                                                        FROM b_nmbmn 
                                                                        ORDER BY kd_brg ASC";
                                                            $dataQry = $koneksi->query($dataSql) or die("Gagal Query" . $koneksi->error);
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['kd_brg'] == $rs['kodebarang']) {
                                                            $cek = " selected";
                                                            } else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[kd_brg]' $cek>$dataRow[kd_brg] - $dataRow[ur_sskel]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                    </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Jumlah BMN</label>
                                                        <div class="col-sm-1">
                                                        <input type="text" maxlength="3" class="form-control" name='qty' id="qty" value='<?php echo "$_POST[qty]"; ?>' onkeyup=sum2();>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">No Aset</label>
                                                        <div class="col-sm-1">
                                                        <input type="text" class="form-control" maxlength="3" name='nupAW' id="nupAW" value='<?php echo "$_POST[nupAW]"; ?>' onkeyup=sum2();>
                                                        <small>Awal</small>
                                                        </div>

                                                        <div class="col-sm-1">
                                                        <input type="text" class="form-control" maxlength="3" name='nupAK' id="nupAK" value='<?php echo "$_POST[nupAK]"; ?>' readonly>
                                                        <small>Akhir</small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Merek BMN</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name='merek' value='<?php echo "$rs[merek]"; ?>'>
                                                        </div>
                                                    </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Status PSP</label>
                                                    <div class="col-sm-2">
                                                        <select class="form-control s2" name='status_psp'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM status_psp ORDER BY status_psp ASC";
                                                            $dataQry = $koneksi->query($dataSql) or die("Gagal Query" . $koneksi->error);
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['status_psp'] == $rs['status_psp']) {
                                                            $cek = " selected";
                                                            } else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[status_psp]' $cek>$dataRow[status_psp] - $dataRow[uraianstatus_psp]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">No PSP</label>
                                                    <div class="col-sm-4">
                                                    <input type="text" maxlength="100" class="form-control" name='nopsp' value='<?php echo "$rs[nomor_psp]"; ?>'>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Tanggal PSP</label>
                                                <div class="col-sm-2">
                                                    <div class="input-group date">
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                    </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="tglpsp" data-toggle="tooltip" data-placement="top" title="Tanggal Awal">
                                                    </div><!-- input-group -->
                                                </div>
                                                </div>

                                                <!-- /.box-body -->
                                                <div class="box-footer">
                                                    <div class="form-group">
                                                    &nbsp;&nbsp;
                                                    <label class="col-sm-2 control-label"></label>

                                                    <a class='btn bg-blue btn-md flat' href=<?php echo "?module=updatepsp"; ?>>
                                                    <i class="fa fa-arrow-left"></i> Kembali</a>

                                                    <button type="reset" class="btn bg-blue btn-md">
                                                    <i class="fa fa-times"> </i>&nbsp;&nbsp;&nbsp;&nbsp; Reset</button>
                                                        
                                                        <button type="submit" class="btn bg-blue btn-md"><i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;Simpan </button>
                                                    </div>
                                                </div>
                                                <!-- /.box-footer -->
                                                </div>
                                                </form>
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