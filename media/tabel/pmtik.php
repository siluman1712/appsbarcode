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
        $aksi = "media/aksi/dbtik.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tgl = mysqli_query(
                        $koneksi,
                        "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl
                         ORDER BY idtgl ASC"
                    );
                    $rs     = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                    <section class="content-header">
                      <h1>BMN Peralatan dan Mesin 
                      <small>Khusus TIK, Non TIK, Angkutan dan Lain Lain</small>
                      </h1>
                    </section>

                    <section class="content">
                    <a class='btn bg-red btn-md flat' href=<?php echo "?module=pmtik&act=tambah"; ?>>
                    <i class="fa fa-plus"></i> Tambah BMN Peralatan dan Mesin</a>
                        <div class="row">
                        <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table_3" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> id </th>
                                                    <th bgcolor='#dcdcdc'> Satuan Kerja</th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang</th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset / NUP</th>
                                                    <th bgcolor='#dcdcdc'> Merek</th>
                                                    <th bgcolor='#dcdcdc'> Kondisi Barang</th>
                                                    <th bgcolor='#dcdcdc'> Status PSP</th>
                                                    <th bgcolor='#dcdcdc'> Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tik = mysqli_query($koneksi, 
                                                          "SELECT a.kodesatker, a.kodebarang, a.tglbuku,
                                                                  a.nup, a.merek, a.tglperoleh, a.status_psp,
                                                                  b.kd_brg, b.ur_sskel, a.kondisibarang,
                                                                  c.kdukpb, c.nmukpb,
                                                                  e.uraianstatus_psp, e.status_psp,
                                                                  f.status_kondisi, f.uraian_kondisi
                                                           FROM dbtik a
                                                           LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                           LEFT JOIN s_satker c ON c.kdukpb = a.kodesatker
                                                           LEFT JOIN status_psp e ON e.status_psp = a.status_psp
                                                           LEFT JOIN kondisi_bmn f ON f.status_kondisi = a.kondisibarang
                                                           ORDER BY a.kodebarang ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($tik)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[kodesatker]"; ?></td>
                                                        <td><?php echo "$r[kodebarang]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[nup]"; ?></td>
                                                        <td><?php echo "$r[merek]"; ?></td>
                                                        <td>
                                                        <span class="badge bg-green">
                                                        <?php echo "$r[uraian_kondisi]"; ?>
                                                        </span>
                                                        </td>
                                                        <td align="center">
                                                        <span class="badge bg-aqua">
                                                        <?php echo "$r[uraianstatus_psp]"; ?></span>
                                                        </td>
                                                        <td>
                                                        <a class='btn bg-blue btn-xs'
                                                        href=<?php echo "?module=pmtik&act=detail&kodebmn=$r[kodebarang]&noaset=$r[nup]"; ?>>
                                                        <i class="fa fa-search"></i> &nbsp;&nbsp; details   
                                                        </a>
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
                    $kpb = mysqli_query(
                        $koneksi,
                        "SELECT kdukpb, nmukpb, ukpb FROM s_satker
                         ORDER BY kdukpb ASC"
                    );
                    $sk     = mysqli_fetch_array($kpb);

                    $tgl = mysqli_query(
                        $koneksi,
                        "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl
                         ORDER BY idtgl ASC"
                    );
                    $rs     = mysqli_fetch_array($tgl);
                ?>

                    <section class="content">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary"> 
                                    <div class="box-header with-border">
                                        <h6 class="box-title">Peralatan dan Mesin</h6>
                                    </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">  
                                            <div>
                                                <form class="form-horizontal" method="post" action='<?php echo "$aksi?module=pmtik&act=addbmn";?>' enctype='multipart/form-data'>
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
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name='nmukpb' id="kdukpb" value='<?php echo "$sk[nmukpb]"; ?>' readonly>
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
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['kd_brg'] == $_POST['kodebarang']) {
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
                                                            <input type="text" class="form-control" name='merek' value='<?php echo "$_POST[merek]"; ?>'>
                                                        </div>
                                                    </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Tanggal Perolehan</label>
                                                <div class="col-sm-2">
                                                    <div class="input-group date">
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                    </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="tglperoleh" data-toggle="tooltip" data-placement="top" title="Tanggal Awal">
                                                    </div><!-- input-group -->
                                                </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Tanggal Buku</label>
                                                <div class="col-sm-2">
                                                    <div class="input-group date">
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                    </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="tglbuku" data-toggle="tooltip" data-placement="top" title="Tanggal Awal">
                                                    </div><!-- input-group -->
                                                </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Harga Perolehan</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" maxlength="20" class="form-control" name='h_peroleh' value='<?php echo "$_POST[h_peroleh]"; ?>'>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Status PSP</label>
                                                    <div class="col-sm-2">
                                                        <select class="form-control s2" name='status_psp'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM status_psp 
                                                                        ORDER BY status_psp ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['status_psp'] == $_POST['status_psp']) {
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
                                                    <input type="text" maxlength="100" class="form-control" name='nopsp' value='<?php echo "$_POST[nopsp]"; ?>'>
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

                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Status Kondisi BMN</label>
                                                    <div class="col-sm-2">
                                                        <select class="form-control s2" name='kondisi'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM kondisi_bmn 
                                                                        ORDER BY status_kondisi ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['status_kondisi'] == $_POST['kondisi']) {
                                                            $cek = " selected";
                                                            } else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[status_kondisi]' $cek>$dataRow[status_kondisi] - $dataRow[uraian_kondisi]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Keterangan</label>
                                                    <div class="col-sm-6">
                                                    <input type="text" maxlength="100" class="form-control" name='keterangan' value='<?php echo "$_POST[keterangan]"; ?>'>
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
                        </div>
                        </div>
                    </section>
                <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "detail":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                        $qry = "SELECT  a.kodebarang, a.nup, a.kodesatker,
                                        a.merek, a.tglperoleh, a.tglbuku,
                                        a.t_anggaran, a.hargaperolehan,
                                        a.nomor_psp, a.tgl_psp, a.kondisibarang,
                                        a.keterangan,
                                        b.kd_brg, b.ur_sskel, b.satuan,
                                        c.kdukpb, c.nmukpb
                                FROM dbtik a
                                LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                LEFT JOIN s_satker c ON c.kdukpb = a.kodesatker
                                WHERE a.kodebarang = '$_GET[kodebmn]' AND a.nup = '$_GET[noaset]'
                                ORDER BY a.kodebarang AND  a.nup ASC";
                        $detail = mysqli_query($koneksi, $qry );
                        $rs = mysqli_fetch_array($detail); 
                    ?>
    
                        <section class="content">
    
                            <a class='btn btn-danger btn-sm' href=<?php echo "?module=pmtik"; ?>><i class='fa fa-arrow-left'></i>&nbsp;&nbsp;&nbsp;KEMBALI</a>

                        <div class="box box-default">
                            <div class="box-header with-border">
                              <h6 class="box-title">BMN Peralatan dan Mesin</h6>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                <label >Uraian BMN / Nama</label>
                                                <input type="text" class="form-control" name='ur_bmn' value='<?php echo "$rs[ur_sskel]"; ?>' readonly>
                                                </div>

                                                <div class="col-sm-3">
                                                <input type="hidden" maxlength="10" class="form-control" name='kodebmn' value='<?php echo "$rs[kodebarang]"; ?>' readonly>
                                                </div>

                                                <div class="col-sm-3">
                                                <input type="hidden" class="form-control" name='nup' value='<?php echo "$rs[nup]"; ?>' readonly>
                                                </div>

                                                <div class="col-sm-3">
                                                <input type="hidden" class="form-control" name='satuan' value='<?php echo "$rs[satuan]"; ?>' readonly>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                <label >Merek / Type</label>
                                                <input type="text" class="form-control" name='merek' value='<?php echo "$rs[merek]"; ?>' readonly>
                                                </div>

                                                <div class="col-sm-3">
                                                <label >Tanggal Perolehan</label>
                                                <input type="text" class="form-control" name='tglperoleh' value='<?php echo "$rs[tglperoleh]"; ?>' readonly>
                                                </div>

                                                <div class="col-sm-3">
                                                <label >Tanggal Buku</label>
                                                <input type="text" class="form-control" name='tglperoleh' value='<?php echo "$rs[tglbuku]"; ?>' readonly>
                                                </div>

                                                <div class="col-sm-3">
                                                <label >Tahun Anggaran</label>
                                                <input type="text" class="form-control" name='t_anggaran' value='<?php echo "$rs[t_anggaran]"; ?>' readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                <label >Harga Perolehan</label>
                                                <input type="text" class="form-control" name='h_peroleh' value='<?php echo "$rs[hargaperolehan]"; ?>' readonly>
                                                </div>

                                                <div class="col-sm-3">
                                                <label >Nomor Penetapan Status Pengguna</label>
                                                <input type="text" class="form-control" name='nomor_psp' value='<?php echo "$rs[nomor_psp]"; ?>' readonly>
                                                </div>

                                                <div class="col-sm-3">
                                                <label >Tanggal Penetapan Status Pengguna</label>
                                                <input type="text" class="form-control" name='tgl_psp' value='<?php echo "$rs[tgl_psp]"; ?>' readonly>
                                                </div>

                                                <div class="col-sm-3">
                                                <label >Kode Satuan Kerja</label>
                                                <input type="text" class="form-control" name='kodesatker' value='<?php echo "$rs[kodesatker]"; ?>' readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                <label >Keterangan Barang</label>
                                                <input type="text" class="form-control" name='ur_bmn' value='<?php echo "$rs[keterangan]"; ?>' readonly>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-info">
                                    <div class="box-header with-border">
                                      <h6 class="box-title">Detail Peralatan dan Mesin</h6>
                                    </div>
                                        <div class="box-body">   
                                            <table id="table_4" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#dcdcdc'> SATUAN KERJA</th>
                                                        <th bgcolor='#dcdcdc'> KODE BARANG</th>
                                                        <th bgcolor='#dcdcdc'> NO ASET</th>
                                                        <th bgcolor='#dcdcdc'> NAMA BARANG</th>
                                                        <th bgcolor='#dcdcdc'> DETAIL KONDISI</th>
                                                        <th bgcolor='#dcdcdc'> DETAIL HAPUS</th>
                                                        <th bgcolor='#dcdcdc'> DETAIL PELIHARA</th>
                                                        <th bgcolor='#dcdcdc'> DETAIL PIC</th>
                                                        <th bgcolor='#dcdcdc'> DETAIL DBR / LOC</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                        <tr>
                                                            <td><?php echo "$rs[nmukpb]"; ?></td>
                                                            <td><?php echo "$rs[kodebarang]"; ?></td>
                                                            <td><?php echo "$rs[nup]"; ?></td>
                                                            <td><?php echo "$rs[ur_sskel]"; ?></td>
                                                            <td>
                                                            <a class='btn bg-blue btn-xs btn-block'
                                                            href=<?php echo "?module=pmtik&act=detailkondisi&kodebmn=$rs[kodebarang]&noaset=$rs[nup]"; ?>>
                                                            <i class="fa fa-search"></i> &nbsp;&nbsp; Tampilkan   
                                                            </a>
                                                            </td>
                                                            <td>
                                                            <a class='btn bg-red btn-xs btn-block'
                                                            href=<?php echo "?module=pmtik&act=detailhapus&kodebmn=$rs[kodebarang]&noaset=$rs[nup]"; ?>>
                                                            <i class="fa fa-search"></i> &nbsp;&nbsp; Tampilkan   
                                                            </a>
                                                            </td>
                                                            <td>
                                                            <a class='btn bg-gray btn-xs btn-block'
                                                            href=<?php echo "?module=pmtik&act=detailpelihara&kodebmn=$rs[kodebarang]&noaset=$rs[nup]"; ?>>
                                                            <i class="fa fa-search"></i> &nbsp;&nbsp; Tampilkan   
                                                            </a>
                                                            </td>
                                                            <td>
                                                            <a class='btn bg-green btn-xs btn-block'
                                                            href=<?php echo "?module=pmtik&act=detailpic&kodebmn=$rs[kodebarang]&noaset=$rs[nup]"; ?>>
                                                            <i class="fa fa-search"></i> &nbsp;&nbsp; Tampilkan   
                                                            </a>
                                                            </td>
                                                            <td>
                                                            <a class='btn bg-maroon btn-xs btn-block'
                                                            href=<?php echo "?module=pmtik&act=detaildbr&kodebmn=$rs[kodebarang]&noaset=$rs[nup]"; ?>>
                                                            <i class="fa fa-search"></i> &nbsp;&nbsp; Tampilkan   
                                                            </a>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
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

                    case "detailkondisi":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') { 
                    ?>
    
                        <section class="content">
    
                            <a class='btn btn-danger btn-sm' href=<?php echo "?module=pmtik"; ?>><i class='fa fa-arrow-left'></i>&nbsp;&nbsp;&nbsp;KEMBALI</a>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-info">
                                    <div class="box-header with-border">
                                      <h6 class="box-title">Detail Peralatan dan Mesin</h6>
                                    </div>
                                        <div class="box-body">   
                                            <table id="table_4" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#dcdcdc'> KODE BARANG</th>
                                                        <th bgcolor='#dcdcdc'> NO ASET</th>
                                                        <th bgcolor='#dcdcdc'> NAMA BARANG</th>
                                                        <th bgcolor='#dcdcdc'> MEREK</th>
                                                        <th bgcolor='#dcdcdc'> TANGGAL PERUBAHAN</th>
                                                        <th bgcolor='#dcdcdc'> ID KONDISI</th>
                                                        <th bgcolor='#dcdcdc'> KONDISI</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $tik = mysqli_query($koneksi, 
                                                          "SELECT a.kodesatker, a.kodebarang, a.tglbuku,
                                                                  a.nup, a.merek, a.tglperoleh, a.status_psp,
                                                                  a.kondisibarang,
                                                                  b.kd_brg, b.ur_sskel, b.satuan,
                                                                  c.tgltransaksi, c.kodebarang, c.noaset,
                                                                  c.merek, c.idkondisi, c.keterangan,
                                                                  d.status_kondisi, d.uraian_kondisi
                                                           FROM dbtik a
                                                           LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                           LEFT JOIN dbubahkondisi c ON c.kodebarang = a.kodebarang AND c.noaset = a.nup 
                                                           LEFT JOIN kondisi_bmn d ON d.status_kondisi = c.idkondisi
                                                           WHERE a.kodebarang = '$_GET[kodebmn]' AND a.nup = '$_GET[noaset]'
                                                           ORDER BY a.kodebarang ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($tik)) {
                                                    $no++;
                                                ?>

                                                        <tr>
                                                            <td><?php echo "$r[kodebarang]"; ?></td>
                                                            <td><?php echo "$r[nup]"; ?></td>
                                                            <td><?php echo "$r[ur_sskel]"; ?></td>
                                                            <td><?php echo "$r[merek]"; ?></td>
                                                            <td><?php echo "$r[tgltransaksi]"; ?></td>
                                                            <td><?php echo "$r[idkondisi]"; ?></td>
                                                            <td><?php echo "$r[uraian_kondisi]"; ?></td>
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
                
                ?>
<?php
        }
    }
}
?>