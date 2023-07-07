
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
                    $query  = "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl ORDER BY idtgl ASC";
                    $tgl    = $koneksi->query($query);
                    $rs     = mysqli_fetch_array($tgl);
                    
                    $qry    ="SELECT kdukpb, nmukpb, ukpb FROM s_satker ORDER BY kdukpb ASC";
                    $kpb    = $koneksi->query($qry);
                    $sk     = mysqli_fetch_array($kpb);

?>

                    <section class="content-header">
                      <h1>
                        Konfigurasi Ruangan (Gedung)
                        <small>Gedung Utama dan Gedung Utama Arsip</small>
                      </h1>
                    </section>
                    <section class="content">
                        <a class='btn bg-red btn-ms flat' href=<?php echo "?module=konfigruangan&act=tambah"; ?>>
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp; Tambah Database Ruangan</a>

                        <a class='btn bg-blue btn-ms flat' href=<?php echo "?module=konfigruangan&act=kategoriruangan"; ?>>
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp; Tambah Kategori Ruangan</a>

                        <a class='btn bg-green btn-ms flat' href=<?php echo "?module=konfigruangan&act=list"; ?>>
                        <i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp; List Gedung Ruangan</a>
                        <br><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h6 class="box-title">Setting Tanda Tangan dan Satuan Kerja</h6>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                            <table id="table_3" class="table table-striped table-bordered">
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
                                                    <th bgcolor='#dcdcdc' width="20px">Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT a.ruanggedung, a.lantai, a.uniteselon,
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
                                                           ORDER BY a.ruanggedung ASC";
                                                $dbruang = $koneksi->query($query);
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
                                                        <td align="center">
                                                        <a class='btn bg-red btn-sm flat' href=<?php echo "?module=konfigruangan&act=ubahdata&koderuangan=$r[koderuangan]"; ?>>
                                                        <i class="fa fa-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                            </table>
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

                case "tambah":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $query  = "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl ORDER BY idtgl ASC";
                    $tgl    = $koneksi->query($query);
                    $rs     = mysqli_fetch_array($tgl);
                    
                    $qry    ="SELECT kdukpb, nmukpb, ukpb FROM s_satker ORDER BY kdukpb ASC";
                    $kpb    = $koneksi->query($qry);
                    $sk     = mysqli_fetch_array($kpb);

                    $kueri  = "SELECT MAX(urutruangan) as kodeTerbesar FROM dbruangan";
                    $kdurut = $koneksi->query($kueri);
                    $data   = mysqli_fetch_array($kdurut);
                    $urutruangan = $data['kodeTerbesar'];
                    $urutan = (int) substr($urutruangan, -3, 3);
                    $urutan++ ;
                    $urutruanganbaru = sprintf("%03s", $urutan);
                ?>

                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h6 class="box-title">Tambah Ruangan Baru Ruangan</h6>
                                    </div>
                                    <div class="box-body">
                                    <h1><strong><?php echo "$urutruanganbaru"; ?></strong></h1><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form class="form-horizontal" method="post" action='<?php echo "$aksi?module=konfigruangan&act=addruang";?>' enctype='multipart/form-data'>
                                                <div class="box-body">

                                                    <div class="form-group row">
                                                        <div class="col-md-1">
                                                        <label>T.A</label>
                                                            <input type="text" class="form-control" name='t_anggaran' id="t_anggaran" value='<?php echo "$rs[s_thnang]"; ?>' readonly>
                                                        </div>

                                                        <div class="col-sm-2">
                                                        <label>Kode Satuan Kerja</label>
                                                            <input type="text" class="form-control" name='kdukpb' id="kdukpb" value='<?php echo "$sk[kdukpb]"; ?>' readonly>
                                                        </div>

                                                        <div class="col-sm-4">
                                                        <label>Nama Satuan Kerja</label>
                                                            <input type="text" class="form-control" name='nmukpb' id="kdukpb" value='<?php echo "$sk[nmukpb]"; ?>' readonly>
                                                        </div>

                                                        <div class="col-sm-1">
                                                        <label>Nomor Urut</label>
                                                            <input type="text" class="form-control" name='nourut' id="nourut" value='<?php echo "$urutruanganbaru"; ?>' readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-2">
                                                        <label>Gedung</label>
                                                        <select class="form-control" name='gedung' id="gedung">
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM dbgedung 
                                                                        ORDER BY gedung ASC";
                                                            $dataQry = $koneksi->query($dataSql) or die("Gagal Query" . $koneksi->error);
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

                                                        <div class="col-sm-3">
                                                        <label>Lantai</label>
                                                        <select class="form-control" name='lantai' id="lantai">
                                                            <option selected="selected">PILIH LANTAI</option>
                                                        </select>
                                                        <small>*Pilih Gedung terlebih dahulu</small>
                                                        </div>
  
                                                        <div class="col-sm-3">
                                                        <label>Unit Eselon (Ruangan)</label>
                                                        <select class="form-control" name='uniteselon'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM dbuniteselon 
                                                                        ORDER BY idues ASC";
                                                            $dataQry = $koneksi->query($dataSql) or die("Gagal Query" . $koneksi->error);
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

                                                    <div class="form-group row">
                                                        <div class="col-sm-3">
                                                        <label>Kategori Ruangan</label>
                                                        <select class="s2 form-control" style="width: 100%; height:36px;" name='kategoriruang'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM dbkategoriruang 
                                                                        ORDER BY idkat ASC";
                                                            $dataQry = $koneksi->query($dataSql) or die("Gagal Query" . $koneksi->error);
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

                                                        <div class="col-sm-5">
                                                        <label>Nama Ruangan</label>
                                                            <input type="text" maxlength="85" class="form-control" name='namaruang' id="namaruang" value='<?php echo "$_POST[namaruang]"; ?>'>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                        <label>Luas Ruangan</label>
                                                            <input type="text" maxlength="5" class="form-control" name='luasruang' value='<?php echo "$_POST[luasruang]"; ?>'>
                                                            <small>exp:52,5</small>
                                                        </div>

                                                        <div class="col-sm-7">
                                                        <label>Keterangan Ruangan</label>
                                                            <input type="text" maxlength="150" class="form-control" name='keterangan' value='<?php echo "$_POST[keterangan]"; ?>'>
                                                            <small>Max 150 char</small>
                                                        </div>
                                                    </div>

                                                  <div class="form-group row">
                                                    <div class="col-sm-2">
                                                    <label>PIC</label>
                                                      <input class='form-control' maxlength="18" type="text" name="NIP1" id="NIP1" placeholder="Masukkan NIP" value='<?php echo "$_POST[NIP1]" ?>' >
                                                    </div>

                                                    <div class="col-sm-3">
                                                    <label>Nama PIC</label>
                                                      <input class='form-control' maxlength="50" type="text" name="NAMA1" id="NAMA1" placeholder="Nama Pegawai" value='<?php echo "$_POST[NAMA1]" ?>' readonly>
                                                    </div>
                                                  </div>
                                                <!-- /.box-body -->
                                                
                                                <div class="form-group ">
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <button type="reset" class="btn bg-blue btn-md btn-flat">
                                                <i class="fa fa-times"> </i>&nbsp;&nbsp;&nbsp;&nbsp; Reset</button>
     
                                                <button type="submit" class="btn btn-danger btn-md btn-flat">
                                                <i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp; Simpan </button>
                                                
                                                <a class='btn bg-green btn-md btn-flat' href=<?php echo "?module=konfigruangan"; ?>>
                                                <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Kembali</a>
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

                case "kategoriruangan":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {

                ?>

                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h6 class="box-title">Daftar Kategori Baru Ruangan</h6>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                            <form class="form-horizontal" method="post" action='<?php echo "$aksi?module=konfigruangan&act=kategoriruangan";?>' enctype='multipart/form-data'>
                                                <div class="box-body">

                                                    <div class="form-group row">
                                                        <div class="col-sm-1">
                                                        <label>Kode / Kategori</label>
                                                            <input type="text" class="form-control" name='kode' id="kode"  maxlength="3" value='<?php echo "$_POST[kode]"; ?>'>
                                                        </div>

                                                        <div class="col-sm-5">
                                                        <label>Nama Kategori</label>
                                                            <input type="text" class="form-control" name='kategori' id="kdukpb" value='<?php echo "$_POST[kategori]"; ?>'>
                                                        </div>
                                                    </div>

                                                <div class="form-group row">
                                                    &nbsp;&nbsp;
                                                    <label></label>
                                                    <button type="reset" class="btn bg-blue btn-md btn-flat">
                                                    <i class="fa fa-times"> </i>&nbsp;&nbsp;&nbsp;&nbsp; Reset</button>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <button type="submit" class="btn btn-danger btn-md btn-flat"><i class="fa fa-check"></i> &nbsp;&nbsp;&nbsp;Simpan </button>
                                                    </div>
                                                </div>
                                            </form>

                                            <table id="table_3" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#dcdcdc'> Kode Kategori </th>
                                                        <th bgcolor='#dcdcdc'> Nama Kategori</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT * FROM dbkategoriruang ORDER BY idkat ASC";
                                                    $dbkat = $koneksi->query($query);
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
                                        </div>        
                                    </div>
                                </div>
                             <a class='btn btn-danger btn-ms flat' href=<?php echo "?module=konfigruangan"; ?>><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;kembali</a>
                            </div>
                        </div>
                    </section>
                <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "list":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {

                ?>

                    <section class="content">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h6 class="box-title">Daftar Gedung</h6>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="table_4" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#dcdcdc'> Gedung </th>
                                                        <th bgcolor='#dcdcdc'> Uraian Gedung</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $gedung = "SELECT * FROM dbgedung ORDER BY idg ASC";
                                                    $gd = $koneksi->query($gedung);
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
                                        </div>        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h6 class="box-title">Daftar Lantai Gedung</h6>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="table_4" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#dcdcdc'> Gedung </th>
                                                        <th bgcolor='#dcdcdc'> Lt. Gedung</th>
                                                        <th bgcolor='#dcdcdc'> Uraian Lantai (Gedung)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $lantai = "SELECT * FROM dblantai ORDER BY idlt ASC";
                                                    $lt = $koneksi->query($lantai);
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
                                        </div>        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h6 class="box-title">Unit Eselon</h6>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="table_4" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#dcdcdc'> Unit Eselon </th>
                                                        <th bgcolor='#dcdcdc'> Uraian</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $kueri = "SELECT * FROM dbuniteselon ORDER BY idues ASC";
                                                    $ues = $koneksi->query($kueri);
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
                                        </div>        
                                    </div>
                                </div>
                            </div>

                        </div>
                        <a class='btn btn-success btn-ms' href=<?php echo "?module=konfigruangan"; ?>>KEMBALI</a>
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
