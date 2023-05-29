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
                    $tgl = mysqli_query($koneksi, "SELECT * FROM s_settgl ORDER BY idtgl ASC" );
                    $rs = mysqli_fetch_array($tgl);
                    $satker = mysqli_query($koneksi, "SELECT * FROM s_satker ORDER BY id ASC");
                    $s		= mysqli_fetch_array($satker);
                    $ttd = mysqli_query($koneksi, "SELECT * FROM s_ttd ORDER BY idttd ASC");
                    $t	= mysqli_fetch_array($ttd);
                    $update = date('Y-m-d');

?>

                    <section class="content">
                        <div class="box box-default">
                            <div class="box-header with-border">
                              <h6 class="box-title">Setting Tanda Tangan dan Satuan Kerja</h6>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                      <table id="table_4" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> No </th>
                                                    <th bgcolor='#dcdcdc'> Kode Satuan Kerja</th>
                                                    <th bgcolor='#dcdcdc'> Nama Satuan Kerja</th>
                                                    <th bgcolor='#dcdcdc'> NIP KPB</th>
                                                    <th bgcolor='#dcdcdc'> Nama KPB</th>
                                                    <th bgcolor='#dcdcdc'> NIP Berita Acara</th>
                                                    <th bgcolor='#dcdcdc'> Nama Berita Acara</th>
                                                    <th bgcolor='#dcdcdc'> NIP Persediaan</th>
                                                    <th bgcolor='#dcdcdc'> Nama Persediaan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ttd = mysqli_query($koneksi, " SELECT a.kodesatuankerja, a.nip_kpb, a.nama_kpb,
                                                                                       a.nip_bmn, a.nama_bmn, a.nip_sedia, a.nip_sedia, a.nama_sedia,
                                                                                       b.kdukpb, b.nmukpb 
                                                                                FROM s_ttd a
                                                                                LEFT JOIN s_satker b ON b.kdukpb = a.kodesatuankerja
                                                                                ORDER BY idttd ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($ttd)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[kodesatuankerja]"; ?></td>
                                                        <td><?php echo "$r[nmukpb]"; ?></td>
                                                        <td><?php echo "$r[nip_kpb]"; ?></td>
                                                        <td><?php echo "$r[nama_kpb]"; ?></td>
                                                        <td><?php echo "$r[nip_bmn]"; ?></td>
                                                        <td><?php echo "$r[nama_bmn]"; ?></td>
                                                        <td><?php echo "$r[nip_sedia]"; ?></td>
                                                        <td><?php echo "$r[nama_sedia]"; ?></td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                      </table>
                                      <br>
                                      <form class='form-horizontal' id=payment method='POST' action='<?php echo"$aksi?module=penandatanganan&act=uptttd";?>' enctype='multipart/form-data'>
                                      <input type='hidden' name='idttd' class='form-control' value='<?php echo"$t[idttd]";?>' readonly> 

                                      <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label">Kode Satuan Kerja</label>
                                        <div class="col-sm-2">
                                        <input type='text' name='ukpb' class='form-control' value='<?php echo"$s[kdukpb]";?>' readonly>
                                        </div>
                                        <div class="col-sm-4">
                                        <input type='text' name='nmupkb' class='form-control' value='<?php echo"$s[nmukpb]";?>' readonly> 
                                        </div>
                                      </div>
                                      
                                      <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label">Kuasa Pengguna Barang</label>

                                        <div class="col-sm-2">
                                          <input class='form-control' maxlength="18" type="text" name="NIP1" id="NIP1" placeholder="Masukkan NIP" value='<?php echo "$t[nip_kpb]" ?>' >
                                        </div>
                                        <div class="col-sm-4">
                                          <input class='form-control' maxlength="50" type="text" name="NAMA1" id="NAMA1" placeholder="Nama Pegawai" value='<?php echo "$t[nama_kpb]" ?>' readonly>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label">TTD BAST dan DBR</label>

                                        <div class="col-sm-2">
                                          <input class='form-control' maxlength="18" type="text" name="NIP2" id="NIP2" placeholder="Masukkan NIP" value='<?php echo "$t[nip_bmn]" ?>' >
                                        </div>
                                        <div class="col-sm-4">
                                          <input class='form-control' maxlength="50" type="text" name="NAMA2" id="NAMA2" placeholder="Nama Pegawai" value='<?php echo "$t[nama_bmn]" ?>'  readonly>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label">Tandatangan Persediaan</label>

                                        <div class="col-sm-2">
                                          <input class='form-control' maxlength="18" type="text" name="NIP3" id="NIP3" placeholder="Masukkan NIP" value='<?php echo "$t[nip_sedia]" ?>'>
                                        </div>
                                        <div class="col-sm-4">
                                          <input class='form-control' maxlength="50" type="text" name="NAMA3" id="NAMA3" placeholder="Nama Pegawai" value='<?php echo "$t[nama_sedia]" ?>' readonly>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label class="col-sm-2 control-label">Kota</label>
                                        <div class="col-sm-2">
                                        <input type='text' name='kota' class='form-control' value='<?php echo "$t[kota]" ?>'>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label class="col-sm-2 control-label">Persetujuan</label>
                                        <div class="col-sm-2">
                                        <div class="input-group">
                                          <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </span>
                                          <input type="text" class="form-control datepicker" name='tglSetuju' placeholder="yyyy-mm-dd" value='<?php echo "$t[tglsetuju]" ?>'>
                                        </div>
                                        </div>
                                      </div>  

                                      <div class="form-group">
                                        <label class="col-sm-2 control-label">Dibuat</label>
                                        <div class="col-sm-2">
                                        <div class="input-group">
                                          <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </span>
                                          <input type="text" class="form-control datepicker" name='tglDibuat' placeholder="yyyy-mm-dd" value='<?php echo "$t[tgldibuat]" ?>'>
                                        </div>
                                        </div>
                                      </div> 

                                      <div class="form-group">
                                           <label for="submit" class="col-sm-2 control-label"></label>
                                           <div class="col-sm-3">
                                            <button type='submit' class='btn btn-primary btn-sm' >
                                            <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Update Data Tanda Tangan dan Persetujuan</button>
                                           </div>
                                         </div>
                                    </form>                                
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
