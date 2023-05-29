
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

                    $kpb = mysqli_query(
                        $koneksi,
                        "SELECT kdukpb, nmukpb, ukpb FROM s_satker
                         ORDER BY kdukpb ASC"
                    );
                    $sk     = mysqli_fetch_array($kpb);

                    $kdurut = mysqli_query($koneksi, "SELECT MAX(urutruangan) as kodeTerbesar FROM dbruangan");
                    $data = mysqli_fetch_array($kdurut);
                    $urutruangan = $data['kodeTerbesar'];
                    $urutan = (int) substr($urutruangan, -3, 3);
                    $urutan++ ;
                    $urutruanganbaru = sprintf("%03s", $urutan);

?>
                    <section class="content-header">
                      <h1>
                        Konfigurasi Ruangan (Gedung)
                        <small>Gedung Utama dan Gedung Utama Arsip</small>
                      </h1>
                    </section>
                    <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                          <!-- Custom Tabs -->
                          <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab_1" data-toggle="tab">List Gedung</a></li>
                              <li><a href="#tab_2" data-toggle="tab">List Lantai</a></li>
                              <li><a href="#tab_3" data-toggle="tab">List Unit Eselon</a></li>
                              <li><a href="#tab_4" data-toggle="tab"><i class="fa fa-plus text-blue"></i>
                              &nbsp; Daftar Kategori Ruangan</a></li>
                              <li><a href="#tab_5" data-toggle="tab"><i class="fa fa-database text-green"></i>
                              &nbsp; Database Ruangan</a></li></a></li>
                              <li><a href="#tab_6" data-toggle="tab"><i class="fa fa-plus text-blue"></i>
                              &nbsp; Daftar Ruangan (baru)</a></li>
                              <li class="pull-right"><a class="text-muted"><i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp; Konfigurasi Gedung</a></li>
                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_1">
                                        <table id="table_4" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Gedung </th>
                                                    <th bgcolor='#dcdcdc'> Uraian Gedung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $gd = mysqli_query($koneksi, 
                                                          "SELECT * FROM dbgedung
                                                           ORDER BY idg ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($gd)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[gedung]"; ?></td>
                                                        <td><?php echo "$r[uraiangedung]"; ?></td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table> 
                              </div>


                              <div class="tab-pane" id="tab_2">
                                        <table id="table_4" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Gedung </th>
                                                    <th bgcolor='#dcdcdc'> Lt. Gedung</th>
                                                    <th bgcolor='#dcdcdc'> Uraian Lantai (Gedung)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $lt = mysqli_query($koneksi, 
                                                          "SELECT * FROM dblantai
                                                           ORDER BY idlt ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($lt)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[gedung]"; ?></td>
                                                        <td><?php echo "$r[ltgedung]"; ?></td>
                                                        <td><?php echo "$r[uraianlantai]"; ?></td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>
                              </div>


                              <div class="tab-pane" id="tab_3">
                                        <table id="table_4" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Unit Eselon </th>
                                                    <th bgcolor='#dcdcdc'> Uraian</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ues = mysqli_query($koneksi, 
                                                          "SELECT * FROM dbuniteselon
                                                           ORDER BY idues ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($ues)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[uniteselon]"; ?></td>
                                                        <td><?php echo "$r[uraian]"; ?></td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>
                              </div>

                              <div class="tab-pane" id="tab_4">
                                <form class="form-horizontal" method="post" action='<?php echo "$aksi?module=konfigruangan&act=kategoriruangan";?>' enctype='multipart/form-data'>
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Kode / Kategori</label>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" name='kode' id="kode"  maxlength="3" value='<?php echo "$_POST[kode]"; ?>'>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Nama Kategori</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name='kategori' id="kdukpb" value='<?php echo "$_POST[kategori]"; ?>'>
                                                        </div>
                                                    </div>


                                                <!-- /.box-body -->
                                                <div class="box-footer">
                                                <div class="form-group">
                                                    &nbsp;&nbsp;
                                                    <label class="col-sm-2 control-label"></label>
                                                    <button type="reset" class="btn bg-blue btn-md flat">
                                                    <i class="fa fa-times"> </i>&nbsp;&nbsp;&nbsp;&nbsp; Reset</button>
                                                        
                                                        <button type="submit" class="btn btn-danger btn-md flat"><i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;Simpan </button>
                                                    </div>
                                                </div>
                                                <!-- /.box-footer -->
                                                </div>
                                            </form>

                                        <table id="table_1" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Kode Kategori </th>
                                                    <th bgcolor='#dcdcdc'> Nama Kategori</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $dbkat = mysqli_query($koneksi, 
                                                          "SELECT * FROM dbkategoriruang                                                           
                                                           ORDER BY idkat ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($dbkat)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[kodekategori]"; ?></td>
                                                        <td><?php echo "$r[namakategori]"; ?></td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>


                                </div>

                                <div class="tab-pane" id="tab_5">
                                        <table id="table_3" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Gedung </th>
                                                    <th bgcolor='#dcdcdc'> Lantai</th>
                                                    <th bgcolor='#dcdcdc'> Unit Eselon </th>
                                                    <th bgcolor='#dcdcdc'> Urut Ruangan </th>
                                                    <th bgcolor='#dcdcdc'> Kode Ruangan </th>
                                                    <th bgcolor='#dcdcdc'> Nama Ruangan </th>
                                                    <th bgcolor='#dcdcdc'> Kategori Ruangan </th>
                                                    <th bgcolor='#dcdcdc'> Luas Ruangan (m2) </th>
                                                    <th bgcolor='#dcdcdc'> Penanggung Jawab (NIP) </th>
                                                    <th bgcolor='#dcdcdc'> Penanggung Jawab (NAMA)</th>
                                                    <th bgcolor='#dcdcdc' width="20px">Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $dbruang = mysqli_query($koneksi, 
                                                          "SELECT a.ruanggedung, a.lantai, a.uniteselon,
                                                                  a.urutruangan, a.koderuangan, a.namaruangan,
                                                                  a.luasruangan, a.nippenanggungjawab, 
                                                                  a.kategori, a.namapenanggungjawab,
                                                                  b.gedung, b.uraiangedung,
                                                                  c.gedung, c.ltgedung, c.uraianlantai,
                                                                  d.uniteselon, d.uraian,
                                                                  e.kodekategori, e.namakategori
                                                           FROM dbruangan a
                                                           LEFT JOIN dbgedung b ON b.gedung = a.ruanggedung
                                                           LEFT JOIN dblantai c ON c.gedung = a.ruanggedung 
                                                           AND c.ltgedung = a.lantai
                                                           LEFT JOIN dbuniteselon d ON d.uniteselon = a.uniteselon
                                                           LEFT JOIN dbkategoriruang e ON e.kodekategori = a.kategori                                                           
                                                           ORDER BY a.ruanggedung ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($dbruang)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td>[<?php echo "$r[ruanggedung]"; ?>]&nbsp;
                                                            <?php echo "$r[uraiangedung]"; ?></td>
                                                        <td>[<?php echo "$r[lantai]"; ?>]
                                                            &nbsp;<?php echo "$r[uraianlantai]"; ?></td>
                                                        <td>[<?php echo "$r[uniteselon]"; ?>]
                                                            &nbsp;<?php echo "$r[uraian]"; ?></td>
                                                        <td><?php echo "$r[urutruangan]"; ?></td>
                                                        <td><?php echo "$r[koderuangan]"; ?></td>
                                                        <td><?php echo "$r[namaruangan]"; ?></td>
                                                        <td>[<?php echo "$r[kategori]"; ?>]
                                                            &nbsp;<?php echo "$r[namakategori]"; ?>
                                                        </td>
                                                        <td><?php echo "$r[luasruangan]"; ?></td>
                                                        <td><?php echo "$r[nippenanggungjawab]"; ?></td>
                                                        <td><?php echo "$r[namapenanggungjawab]"; ?></td>
                                                        <td align="center">
                                                        <a class='btn bg-red btn-sm flat' href=<?php echo "?module=konfigruangan&act=ubahdata&koderuangan=$r[koderuangan]"; ?>>
                                                        <i class="fa fa-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>
                                </div>
                                <div class="tab-pane" id="tab_6">
                                <form class="form-horizontal" method="post" action='<?php echo "$aksi?module=konfigruangan&act=addruang";?>' enctype='multipart/form-data'>
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Tahun Anggaran</label>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" name='t_anggaran' id="t_anggaran" value='<?php echo "$rs[s_thnang]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Kode Satuan Kerja</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" name='kdukpb' id="kdukpb" value='<?php echo "$sk[kdukpb]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Nama Satuan Kerja</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" name='nmukpb' id="kdukpb" value='<?php echo "$sk[nmukpb]"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Gedung</label>
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
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Lantai</label>
                                                        <div class="col-sm-3">
                                                        <select class="form-control" name='lantai' id="lantai">
                                                            <option selected="selected">PILIH LANTAI</option>
                                                        </select>
                                                        <small>*Pilih Gedung terlebih dahulu</small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Unit Eselon (Ruangan)</label>
                                                        <div class="col-sm-2">
                                                        <select class="form-control" name='uniteselon'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM dbuniteselon 
                                                                        ORDER BY idues ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['uniteselon'] == $_POST['uniteselon']) {
                                                            $cek = " selected";
                                                            } else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[uniteselon]' $cek>$dataRow[uniteselon] - $dataRow[uraian]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Nomor Urut</label>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" name='nourut' id="nourut" value='<?php echo "$urutruanganbaru"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Nama Ruangan</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" maxlength="85" class="form-control" name='namaruang' id="namaruang" value='<?php echo "$_POST[namaruang]"; ?>'>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Kategori Ruangan</label>
                                                        <div class="col-sm-4">
                                                        <select class="s2 form-control" style="width: 100%; height:36px;" name='kategoriruang'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM dbkategoriruang 
                                                                        ORDER BY idkat ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['kodekategori'] == $_POST['kategoriruang']) {
                                                            $cek = " selected";
                                                            } else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[kodekategori]' $cek>$dataRow[kodekategori] - $dataRow[namakategori]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Luas Ruangan</label>
                                                        <div class="col-sm-1">
                                                            <input type="text" maxlength="5" class="form-control" name='luasruang' value='<?php echo "$_POST[luasruang]"; ?>'>
                                                            <small>exp:52,5</small>
                                                        </div>
                                                        M2
                                                    </div>

                                                  <div class="form-group">
                                                    <label for="tgldist" class="col-sm-2 control-label">Penanggung Jawab Ruangan</label>

                                                    <div class="col-sm-2">
                                                      <input class='form-control' maxlength="18" type="text" name="NIP1" id="NIP1" placeholder="Masukkan NIP" value='<?php echo "$_POST[NIP1]" ?>' >
                                                    </div>
                                                    <div class="col-sm-3">
                                                      <input class='form-control' maxlength="50" type="text" name="NAMA1" id="NAMA1" placeholder="Nama Pegawai" value='<?php echo "$_POST[NAMA1]" ?>' readonly>
                                                    </div>
                                                  </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Keterangan Ruangan</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" maxlength="150" class="form-control" name='keterangan' value='<?php echo "$_POST[keterangan]"; ?>'>
                                                            <small>Max 150 char</small>
                                                        </div>
                                                    </div>
                                                    

                                                <!-- /.box-body -->
                                                <div class="box-footer">
                                                <div class="form-group">
                                                    &nbsp;&nbsp;
                                                    <label class="col-sm-2 control-label"></label>
                                                    <button type="reset" class="btn bg-blue btn-md flat">
                                                    <i class="fa fa-times"> </i>&nbsp;&nbsp;&nbsp;&nbsp; Reset</button>
                                                        
                                                        <button type="submit" class="btn btn-danger btn-md flat"><i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;Simpan </button>
                                                    </div>
                                                </div>
                                                <!-- /.box-footer -->
                                                </div>
                                                </form>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js" ></script> 
<script>
$(document).ready(function() { 
    $("#gedung").change(function() { 
        var gedung = $(this).val(); 
        if (gedung != "") { 
            $.ajax({ type:"post", 
            url:"media/aksi/getlantai.php", 
            data:"id="+ gedung, 
            success: function(data){ 
                $("#lantai").html(data); 
            } 
        }); 
    } 
}); 
});
</script>
