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
        $aksi = "media/aksi/appsPengaturan.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tgl = mysqli_query(
                        $koneksi,
                        "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl
                         ORDER BY idtgl ASC"
                    );
                    $rs     = mysqli_fetch_array($tgl);
                    $satker = mysqli_query($koneksi, "SELECT * FROM s_satker ORDER BY id ASC");
                    $s      = mysqli_fetch_array($satker);
                    $update = date('Y-m-d');

?>
                    <section class="content-header">
                      <h1>
                        Tabel Satuan Kerja
                      </h1>
                    </section>

                    <section class="content">
                        <div class="row">
                        <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table_4" class="table ">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> id </th>
                                                    <th bgcolor='#dcdcdc'> Pebin</th>
                                                    <th bgcolor='#dcdcdc'> Pbi</th>
                                                    <th bgcolor='#dcdcdc'> Wilayah</th>
                                                    <th bgcolor='#dcdcdc'> Unit KPB</th>
                                                    <th bgcolor='#dcdcdc'> Unit Pembantu KPB</th>
                                                    <th bgcolor='#dcdcdc'> Kode Kuasa Pengguna Barang</th>
                                                    <th bgcolor='#dcdcdc'> Nama Kuasa Pengguna Barang</th>
                                                    <th bgcolor='#dcdcdc'> Nama Pengguna Barang</th>
                                                    <th bgcolor='#dcdcdc'> JKD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sensus = mysqli_query($koneksi, 
                                                          "SELECT a.pebin, a.pbi,
                                                                  a.wilayah, a.ukpb, 
                                                                  a.upkpb, a.kdukpb,
                                                                  a.nmukpb, a.nmpb, a.jk
                                                           FROM s_satker a 
                                                           ORDER BY a.kdukpb ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($sensus)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[pebin]"; ?></td>
                                                        <td><?php echo "$r[pbi]"; ?></td>
                                                        <td><?php echo "$r[wilayah]"; ?></td>
                                                        <td><?php echo "$r[ukpb]"; ?></td>
                                                        <td><?php echo "$r[upkpb]"; ?></td>
                                                        <td><?php echo "$r[kdukpb]"; ?></td>
                                                        <td><?php echo "$r[nmukpb]"; ?></td>
                                                        <td><?php echo "$r[nmpb]"; ?></td>
                                                        <td><?php echo "$r[jk]"; ?></td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>  
                                        <form class='form-horizontal' id=payment method='POST' action='<?php echo"$aksi?module=satker&act=setSatker";?>' enctype='multipart/form-data'>
                                      <input type='hidden' name='idsatker' class='form-control' value='<?php echo"$s[id]";?>' readonly> 
                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label">Kode Instansi</label>

                                        <div class="col-sm-3">
                                        <select class="s2 form-control" style="width: 100%; height:36px;" id='pebin' name='pebin'>
                                            <option value='BLANK'>PILIH</option>
                                            <?php
                                            $dataSql = "SELECT * FROM s_pebin ORDER BY kd_pebin ASC";
                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                            if ($dataRow['kd_pebin'] == $s['pebin']) {
                                            $cek = " selected";
                                            } else { $cek = ""; }
                                            echo "
                                            <option value='$dataRow[kd_pebin]' $cek>$dataRow[kd_pebin] - $dataRow[ur_pebin]</option>";
                                            }
                                            $sqlData = "";
                                            ?>
                                         </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label">Kode Instansi [Satuan Eselon I]</label>

                                        <div class="col-sm-4">
                                        <select class="s2 form-control" style="width: 100%; height:36px;" id='pbi' name='pbi'>
                                            <option value='BLANK'>PILIH</option>
                                            <?php
                                            $dataSql = "SELECT * FROM s_pbi ORDER BY kd_pbi ASC";
                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                            if ($dataRow['kd_pbi'] == $s['pbi']) {
                                            $cek = " selected";
                                            } else { $cek = ""; }
                                            echo "
                                            <option value='$dataRow[kd_pbi]' $cek>$dataRow[kd_pebin]$dataRow[kd_pbi]-$dataRow[ur_pbi]</option>";
                                            }
                                            $sqlData = "";
                                            ?>
                                         </select>
                                         <small>Pilih PBI</small>
                                         </div>
                                     </div>

                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label">Kode Satuan Wilayah Kerja</label>
                                         <div class="col-sm-2">
                                         <select class="s2 form-control" style="width: 100%; height:36px;" id='uappbw' name='uappbw'>
                                            <option value='BLANK'>PILIH</option>
                                            <?php
                                            $dataSql = "SELECT * FROM s_wilayah ORDER BY kd_wilayah ASC";
                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                            if ($dataRow['kd_wilayah'] == $s['wilayah']) {
                                            $cek = " selected";
                                            } else { $cek = ""; }
                                            echo "
                                            <option value='$dataRow[kd_wilayah]' $cek>$dataRow[kd_wilayah]-$dataRow[ur_wilayah]</option>";
                                            }
                                            $sqlData = "";
                                            ?>
                                         </select>
                                         <small>Pilih Kode Wilayah</small>
                                         </div>
                                     </div>

                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label">Kode Satuan Kerja</label>
                                         <div class="col-sm-1">
                                         <input type='text' name='ukpb' class='form-control' value='<?php echo"$s[ukpb]";?>'> 
                                         </div>
                                         <div class="col-sm-1">
                                         <input type='text' name='upkpb' class='form-control' value='<?php echo"$s[upkpb]";?>'> 
                                         </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-2">
                                          <select class="s2 form-control" style="width: 100%" id='jk' name='jk'>
                                            <option value='BLANK'><?php echo"$s[jk]";?></option>
                                            <option value='KD'>[KD] - KANTOR DAERAH</option>
                                            <option value='KP'>[KP] - KANTOR PUSAT</option>
                                            <option value='DK'>[DK] - DEKONSENTRASI</option>
                                            <option value='TP'>[TP] - TUGAS PEMBANTUAN</option>
                                            <option value='UB'>[UB] - URUSAN BERSAMA</option>
                                          </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-3">
                                        <input type='text' name='nmupkb' class='form-control' value='<?php echo"$s[nmukpb]";?>'>
                                        </div> 
                                    </div>

                                    <div class="form-group">                                    
                                        <label for="tgldist" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-3">
                                        <input type='text' name='nmpb' class='form-control' value='<?php echo"$s[nmpb]";?>'> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-2 control-label"></label>
                                         <div class="col-sm-3">
                                         <select class="s2 form-control" style="width: 100%; height:36px;" id='kpknl' name='kpknl'>
                                            <option value='BLANK'>PILIH</option>
                                            <?php
                                            $dataSql = "SELECT * FROM s_kpknl ORDER BY kdkpknl ASC";
                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                            if ($dataRow['kdkpknl'] == $s['kpknl']) {
                                            $cek = " selected";
                                            } else { $cek = ""; }
                                            echo "
                                            <option value='$dataRow[kdkpknl]' $cek>$dataRow[urkpknl]-$dataRow[alamat]</option>";
                                            }
                                            $sqlData = "";
                                            ?>
                                         </select>
                                         <small>Pilih KPKNL</small>
                                         </div>
                                    </div>

                                      <div class="form-group">
                                           <label for="submit" class="col-sm-2 control-label"></label>
                                           <div class="col-sm-3">
                                            <button type='submit' class='btn btn-success btn-sm' >
                                            <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Update Data Satuan Kerja</button>
                                           </div>
                                         </div>
                                    </form>  
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