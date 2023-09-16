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
                    <a class='btn bg-blue btn-sm ' href=<?php echo "?module=distribusi&act=distribusidbr"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp; Database Distribusi DBR (Antar Unit)</a>

                    <a class='btn bg-blue btn-sm ' href=<?php echo "?module=distribusi&act=dbdistribusi"; ?>>
                    <i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Tabel Database DBR Existing</a>

                    <a class='btn bg-blue btn-sm ' href=<?php echo "?module=distribusi&act=distexcel"; ?>>
                    <i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;&nbsp; Expor Data Distribusi (.xls)</a>
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                            <div class="col-md-12">
                            <form class='form-horizontal' method='POST' action='<?php echo "$aksi?module=distribusi&act=distribusibmn"; ?>' enctype='multipart/form-data'>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Lokasi INSTANSI</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name='LOKINS' value='<?php echo "$_SESSION[LOKINS]"; ?>' readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Penguasaan </label>
                                <div class="col-sm-2">
                                <select class="form-control" name='penguasaan' id="penguasaan">
                                    <option value='BLANK'>PILIH</option>
                                    <option value='01'>[01] MILIK SENDIRI (SATUAN KERJA)</option>
                                    <option value='02'>[02] MILIK PRIBADI PEGAWAI</option>
                                    <option value='03'>[03] MILIK PIHAK KE -3 (TIGA)</option>
                                </select>
                                </div>
                            </div>

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
                    </div>

                <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "dbdistribusi":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    
                    ?>
    
                        <section class="content">

                            <a class='btn btn-danger btn-sm' align='left' href=<?php echo "?module=distribusi"; ?>>
                            <i class='fa fa-arrow-left'></i>&nbsp;&nbsp;&nbsp;kembali</a>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
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
                                                            <th bgcolor='#dcdcdc' width="230px"> Status </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $dist = $koneksi->query( 
                                                                "SELECT a.tgldistribusi, a.ruanggedung, 
                                                                        a.koderuang, a.kodebarang, 
                                                                        a.noaset, a.keterangan,
                                                                        a.status_distribusi, a.penguasaan,
                                                                        b.gedung, b.uraiangedung,
                                                                        c.kd_brg, c.ur_sskel, c.satuan,
                                                                        d.koderuangan, d.namaruangan,
                                                                        e.status_distribusi, e.ur_statusdistribusi,
                                                                        f.penguasaan, f.ur_penguasaan
                                                                FROM dbdistribusi a
                                                                LEFT JOIN dbgedung b ON b.gedung = a.ruanggedung
                                                                LEFT JOIN b_nmbmn c ON c.kd_brg = a.kodebarang 
                                                                LEFT JOIN dbruangan d ON d.koderuangan = a.koderuang
                                                                LEFT JOIN status_distribusi e ON e.status_distribusi = a.status_distribusi
                                                                LEFT JOIN status_penguasaanbmn f ON f.penguasaan = a.penguasaan
                                                                WHERE a.status_distribusi ='80'                 
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
                                                                <td>
                                                                <?php if($r[status_distribusi]=='80'){?>
                                                                <span class="badge bg-blue">    
                                                                <?php echo "$r[status_distribusi]"; ?>
                                                                </span>
                                                                <span class="badge bg-blue">    
                                                                <?php echo "$r[ur_statusdistribusi]"; ?>
                                                                </span>
                                                                <?php } else { ?>
                                                                <span class="badge bg-red">    
                                                                <?php echo "$r[status_distribusi]"; ?>
                                                                </span>
                                                                <span class="badge bg-red">    
                                                                <?php echo "$r[ur_statusdistribusi]"; ?>
                                                                </span>
                                                                <?php } ?>
                                                                <span class="badge bg-orange">    
                                                                <?php echo "$r[ur_penguasaan]"; ?>
                                                                </span>
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

                    case "distribusidbr":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    
                    ?>
    
                        <section class="content">

                            <a class='btn btn-danger btn-sm' align='left' href=<?php echo "?module=distribusi"; ?>>
                            <i class='fa fa-arrow-left'></i>&nbsp;&nbsp;&nbsp;kembali</a>

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

                                                            <div class="col-sm-1">
                                                            <input type="text" class="form-control" maxlength="3" name='noaset' value='<?php echo "$_POST[noaset]"; ?>'>
                                                            <small>NUP</small>
                                                            </div>
                                                        
                                                        <div class="form-group">
                                                            <button type="submit" class="btn bg-green btn-md flat"><i class="fa fa-check"></i> &nbsp;&nbsp;Scan</button>
                                                            </div>
                                                        </div>

                                                </form>

                                              <?php
                                                $a = $koneksi->query(
                                                " SELECT a.tgldistribusi, a.ruanggedung, 
                                                                        a.koderuang, a.kodebarang, 
                                                                        a.noaset, a.keterangan,
                                                                        a.status_distribusi,
                                                                        b.gedung, b.uraiangedung,
                                                                        c.kd_brg, c.ur_sskel, c.satuan,
                                                                        d.koderuangan, d.namaruangan,
                                                                        e.status_distribusi, e.ur_statusdistribusi
                                                                FROM dbdistribusi a
                                                                LEFT JOIN dbgedung b ON b.gedung = a.ruanggedung
                                                                LEFT JOIN b_nmbmn c ON c.kd_brg = a.kodebarang 
                                                                LEFT JOIN dbruangan d ON d.koderuangan = a.koderuang
                                                                LEFT JOIN status_distribusi e ON e.status_distribusi = a.status_distribusi
                                                                WHERE a.status_distribusi ='80'                 
                                                                ORDER BY a.ruanggedung ASC");
                                                $r = mysqli_fetch_array($a);
                                                $cekdata = mysqli_num_rows($a);
                                                if(isset($_POST['kodebmn']) && $cekdata==0 ){
                                                  echo "
                                                  <h4>Ulang Lagi</h4> Cek Pengisian / Data Belum lengkap ";
                                                }else{
                                              ?>

                                                <form class='form-horizontal' method='POST' action='<?php echo "$aksi?module=distribusi&act=addnewdbr"; ?>' enctype='multipart/form-data'>

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

                    case "distexcel":
                        if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
        
                        ?>
                            <section class="content">
                                <a class='btn btn-danger btn-sm flat' align='right' href=<?php echo "?module=distribusi"; ?>>
                                <i class='fa fa-arrow-left'></i>&nbsp;&nbsp;&nbsp;KEMBALI</a>

                                <a class='btn bg-navy btn-sm flat' href='<?php echo "media/cetak/exporxlsdist.php"; ?>' target='_blank'>
                                <i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;&nbsp; Export Excel</a>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-12">
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