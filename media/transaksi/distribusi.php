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
        $aksi = "media/aksi/distribusi.php";
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
                        Distribusi BMN <small>Distribusi ke Unit</small>
                      </h1>
                    </section>
                    <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                          <!-- Custom Tabs -->
                          <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab_1" data-toggle="tab">db Distribusi</a></li>
                              <li><a href="#tab_2" data-toggle="tab">Pendistribusi BMN</a></li>
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_1">
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


                              <div class="tab-pane" id="tab_2">
                                <?php
                                $tgl = mysqli_query(
                                    $koneksi,
                                    "SELECT * FROM s_settgl
                                     ORDER BY idtgl ASC"
                                );
                                $rs = mysqli_fetch_array($tgl);
                                ?>
                                    <form class='form-horizontal' method='POST' action='<?php echo "$aksi?module=distribusi&act=distribusibmn"; ?>' enctype='multipart/form-data'>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Gedung </label>
                                                        <div class="col-sm-2">
                                                        <select class="form-control" name='gedung' id="gedung">
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM dbgedung 
                                                                        ORDER BY gedung ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['gedung'] == $_POST['gedung']) {
                                                            $cek = " selected";
                                                            } else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[gedung]' $cek>$dataRow[gedung] - $dataRow[uraiangedung]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                        <small>*Lokasi Tujuan</small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Kode Ruangan</label>
                                                        <div class="col-sm-5">
                                                        <select class="form-control s2" name='koderuang' id="koderuang">
                                                            <option selected="selected">KODE RUANG</option>
                                                        </select>
                                                        <small>*Lokasi Tujuan Ruangan</small>
                                                        </div>
                                                    </div>

                                                    <div class='form-group'>
                                                        <label class="col-sm-2 control-label">Kode / Daftar BMN</label>
                                                        <div class='col-sm-4'>
                                                            <select class="s2 form-control" style="width: 100%" name='kodebarang'>
                                                                <option value='BLANK'>KODE / DAFTAR BMN</option>
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
                                                        <label class="col-sm-2 control-label">Jumlah</label>
                                                        <div class="col-sm-1">
                                                        <input type="text" maxlength="3" class="form-control" name='qty' id="qty" value='<?php echo "$_POST[qty]"; ?>' onkeyup=sum2();>
                                                        <small>Kuantitas</small>
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
                                                        <label class="col-sm-2 control-label">Tanggal Distribusi</label>
                                                        <div class="col-md-2">
                                                            <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="tgldist" data-toggle="tooltip" data-placement="top" title="Tanggal Awal">
                                                            </div><!-- input-group -->
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Tahun Anggaran Pelaksanaan</label>
                                                        <div class="col-sm-1">
                                                            <input type="text" maxlength="150" class="form-control" name='tanggaran' value='<?php echo "$rs[s_thnang]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Keterangan</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" maxlength="150" class="form-control" name='keterangan' value='<?php echo "$_POST[keterangan]"; ?>'>
                                                            <small>Max 150 char</small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Nomor Urut BAST</label>
                                                        <div class="col-sm-1">
                                                            <input type="text" maxlength="4" class="form-control" name='nobast' value='<?php echo "$_POST[nourut]"; ?>'>
                                                        </div>
                                                    </div>

                                                    <div class="box-footer">
                                                    <div class="form-group">
                                                        &nbsp;&nbsp;
                                                        <label class="col-sm-2 control-label"></label>
                                                        <button type="reset" class="btn bg-blue btn-md flat">
                                                        <i class="fa fa-times"> </i>&nbsp;&nbsp;&nbsp;&nbsp; Reset</button>
                                                            
                                                            <button type="submit" class="btn btn-danger btn-md flat"><i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;Simpan </button>
                                                        </div>
                                                    </div>
                                        </form>
                              </div>

                            </div>
                          </div>
                        </div>
                    </div>

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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js" ></script> 
<script>
$(document).ready(function() { 
    $("#gedung").change(function() { 
        var gedung = $(this).val(); 
        if (gedung != "") { 
            $.ajax({ type:"post", 
            url:"media/aksi/getruang.php", 
            data:"id="+ gedung, 
            success: function(data){ 
                $("#koderuang").html(data); 
            } 
        }); 
    }  
    });

});
</script>