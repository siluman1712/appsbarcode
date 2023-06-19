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
        $aksi = "media/aksi/dbrn.php";
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
                      <h1>Database Bangunan Gedung 
                      <small>Bangunan Gedung Rumah Negara</small>
                      </h1>
                    </section>

                    <section class="content">
                    <a class='btn bg-navy btn-md flat' href=<?php echo "?module=dbrumahnegara&act=tambah"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp; Tambah Rumah Negara</a>
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
                                                    <th bgcolor='#dcdcdc'> Nama Satker</th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang</th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset</th>
                                                    <th bgcolor='#dcdcdc'> Merek</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Luas (SBSK)</th>
                                                    <th bgcolor='#dcdcdc'> Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tik = mysqli_query($koneksi, 
                                                          "SELECT a.kodesatker, a.kodebarang, 
                                                                  a.tglbuku, a.status_kondisi,
                                                                  a.nup, a.merek, a.tglperoleh, 
                                                                  a.status_psp, a.tgl_psp, a.nomor_psp,
                                                                  a.luas_sbsk, a.status_penggunaan,
                                                                  a.merek,
                                                                  b.kd_brg, b.ur_sskel, 
                                                                  c.kdukpb, c.nmukpb,
                                                                  e.uraianstatus_psp, e.status_psp,
                                                                  f.status_kondisi, f.uraian_kondisi,
                                                                  g.id_status, g.ur_status
                                                           FROM dbrumahnegara a
                                                           LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                           LEFT JOIN s_satker c ON c.kdukpb = a.kodesatker
                                                           LEFT JOIN status_psp e ON e.status_psp = a.status_psp
                                                           LEFT JOIN kondisi_bmn f ON f.status_kondisi = a.status_kondisi
                                                           LEFT JOIN status_penggunaan g ON g.id_status = a.status_penggunaan
                                                           ORDER BY a.kodebarang ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($tik)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[nmukpb]"; ?></td>
                                                        <td><?php echo "$r[kodebarang]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[nup]"; ?></td>
                                                        <td><?php echo "$r[merek]"; ?></td>
                                                        <td><?php echo "$r[tglperoleh]"; ?></td>
                                                        <td><?php echo "$r[luas_sbsk]"; ?></td>
                                                        <td>
                                                        <a class='btn bg-blue btn-sm'
                                                        href=<?php echo "?module=dbrumahnegara&act=detail&kodebmn=$r[kodebarang]&noaset=$r[nup]"; ?>>
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

                case "detail":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                        $qry = "SELECT  a.kodebarang, a.nup, 
                                        a.luas_sbsk, a.merek,
                                        b.kd_brg, b.ur_sskel,
                                        c.kodebarang, c.noaset,
                                        c.no_rumah, c.gol_rumah,
                                        c.type_rumah
                                FROM dbrumahnegara a
                                LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                LEFT JOIN dbsip c ON c.kodebarang = a.kodebarang AND c.noaset = a.nup
                                WHERE a.kodebarang = '$_GET[kodebmn]' AND a.nup = '$_GET[noaset]'
                                ORDER BY a.kodebarang AND  a.nup ASC";
                        $detail = mysqli_query($koneksi, $qry );
                        $rs = mysqli_fetch_array($detail); 
                    ?>
    
                        <section class="content">
    
                            <a class='btn btn-danger btn-sm' href=<?php echo "?module=dbrumahnegara"; ?>><i class='fa fa-arrow-left'></i>&nbsp;&nbsp;&nbsp;KEMBALI</a>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4><p>&nbsp;&nbsp;&nbsp;&nbsp;Surat Izin Penghunian Menerangkan Bahwa : </p></h4>
                                                    <form class="form-horizontal">
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Uraian BMN</label>
                                                            <div class="col-sm-1">
                                                            <input type="text" maxlength="10" class="form-control" name='kodebmn' value='<?php echo "$rs[kodebarang]"; ?>' readonly>
                                                            </div>
    
                                                            <div class="col-sm-5">
                                                            <input type="text" class="form-control" name='ur_bmn' value='<?php echo "$rs[ur_sskel]"; ?>' readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">No Aset</label>
                                                            <div class="col-sm-1">
                                                            <input type="text" class="form-control" name='nup' value='<?php echo "$rs[nup]"; ?>' readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Jenis Rumah Negara</label>
                                                            <div class="col-sm-5">
                                                            <input type="text" class="form-control" name='merek' value='<?php echo "$rs[merek]"; ?>' readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Golongan Rumah Negara</label>
                                                            <div class="col-sm-1">
                                                            <input type="text" class="form-control" name='golrn' value='<?php echo "$rs[gol_rumah]"; ?>' readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Type Rumah Negara</label>
                                                            <div class="col-sm-1">
                                                            <input type="text" class="form-control" name='tipern' value='<?php echo "$rs[type_rumah]"; ?>' readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">No Rumah Negara</label>
                                                            <div class="col-sm-1">
                                                            <input type="text" class="form-control" name='norn' value='<?php echo "$rs[no_rumah]"; ?>' readonly>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>    
                                            <table id="table_1" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#dcdcdc'> NIP Penghuni</th>
                                                        <th bgcolor='#dcdcdc'> Nama Penghuni</th>
                                                        <th bgcolor='#dcdcdc'> TMT Penghunian</th>
                                                        <th bgcolor='#dcdcdc'> Lama Huni</th>
                                                        <th bgcolor='#dcdcdc'> Nilai Sewa</th>
                                                        <th bgcolor='#dcdcdc'> TMT Bayar</th>
                                                        <th bgcolor='#dcdcdc'> SKSIP</th>
                                                        <th bgcolor='#dcdcdc'> TGL SK</th>
                                                        <th bgcolor='#dcdcdc'> Status Huni</th>
                                                        <th bgcolor='#dcdcdc'> Update Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <?php
                                                        $cek = mysqli_query(
                                                            $koneksi,
                                                            "SELECT a.kodesatker, a.kodebarang, 
                                                                    a.tglbuku, a.status_kondisi,
                                                                    a.nup, a.merek, a.tglperoleh, 
                                                                    a.status_psp, a.tgl_psp, a.nomor_psp,
                                                                    a.luas_sbsk, a.status_penggunaan,
                                                                    a.merek,
                                                                    b.kd_brg, b.ur_sskel, 
                                                                    c.kdukpb, c.nmukpb,
                                                                    d.penghuni_nip, d.penghuni_nilaisewa, 
                                                                    d.penghuni_nama, d.penghuni_tmthuni,
                                                                    d.penghuni_sksip, d.penghuni_tglsk, 
                                                                    d.penghuni_lamahuni, d.kodebarang,  
                                                                    d.penghuni_status, d.noaset, 
                                                                    d.penghuni_selesaiperpnjang,
                                                                    d.penghuni_alasanselesai,
                                                                    d.penghuni_tmtbayarsewa, d.penghuni_tglsk,
                                                                    d.penghuni_sksip, d.penghuni_status,
                                                                    e.id_status, e.ur_status,
                                                                    f.idstatus_hunian, f.ur_statushunian

                                                            FROM dbrumahnegara a
                                                            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                            LEFT JOIN s_satker c ON c.kdukpb = a.kodesatker
                                                            LEFT JOIN dbsip d ON d.kodebarang = a.kodebarang AND d.noaset = a.nup
                                                            LEFT JOIN status_penggunaan e ON e.id_status = a.status_penggunaan
                                                            LEFT JOIN status_penghunian f ON f.idstatus_hunian = d.penghuni_status
                                                            WHERE a.kodebarang = '$_GET[kodebmn]' AND a.nup = '$_GET[noaset]'
                                                            ORDER BY a.kodebarang ASC"
                                                        );
    
                                                        $numRows = mysqli_num_rows($cek);
                                                        $no = 0;
                                                        while ($r = mysqli_fetch_array($cek)) {
                                                            $no++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo "$r[penghuni_nip]"; ?></td>
                                                            <td><?php echo "$r[penghuni_nama]"; ?></td>
                                                            <td><?php echo "$r[penghuni_tmthuni]"; ?></td>
                                                            <td><?php echo "$r[penghuni_lamahuni]"; ?></td>
                                                            <td><?php echo "$r[penghuni_nilaisewa]"; ?></td>
                                                            <td><?php echo "$r[penghuni_tmtbayarsewa]"; ?></td>
                                                            <td><?php echo "$r[penghuni_sksip]"; ?></td>
                                                            <td><?php echo "$r[penghuni_tglsk]"; ?></td>
                                                            <td>
                                                            <?php if($r['idstatus_hunian']=='90'){?>
                                                            <span class="badge bg-green">
                                                            <?php echo "$r[ur_statushunian]"; ?>
                                                            </span>
                                                            <?php } elseif($r['idstatus_hunian']=='91') { ?>
                                                            <span class="badge bg-blue">
                                                            <?php echo "$r[ur_statushunian]"; ?>
                                                            </span>
                                                            <?php } elseif($r['idstatus_hunian']=='92') { ?>
                                                            <span class="badge bg-orange">
                                                            <?php echo "$r[ur_statushunian]"; ?>
                                                            </span>
                                                            <?php } elseif($r['idstatus_hunian']=='93') { ?>
                                                            <span class="badge bg-red">
                                                            <?php echo "$r[ur_statushunian]"; ?>
                                                            </span>
                                                            <?php } elseif($r['idstatus_hunian']=='94') { ?>
                                                            <span class="badge bg-navy">
                                                            <?php echo "$r[ur_statushunian]"; ?>
                                                            </span>
                                                            <?php } elseif($r['idstatus_hunian']=='95') { ?>
                                                            <span class="badge bg-red">
                                                            <?php echo "$r[ur_statushunian]"; ?>
                                                            </span>
                                                            <?php }else{ ?>
                                                            <span class="badge bg-purple">
                                                            <?php echo "$r[ur_statushunian]"; ?>
                                                            </span>
                                                            <?php } ?>
                                                            </td>
                                                            <td><?php echo "$r[penghuni_selesaiperpnjang]"; ?></td>
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
        
                                <a class='btn btn-danger btn-sm' href=<?php echo "?module=dbrumahnegara"; ?>><i class='fa fa-arrow-left'></i>&nbsp;&nbsp;&nbsp;KEMBALI</a>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <form class="form-horizontal" method="post" action='<?php echo "$aksi?module=dbrumahnegara&act=addrumahnegara";?>' enctype='multipart/form-data'>
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
                                                                <label class="col-sm-2 control-label">Jenis / Type Rumah Negara</label>
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

                                                        <div class="form-group row">
                                                            <label class="col-sm-2 control-label">Status Penggunaan</label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control s2" name='statusguna'>
                                                                    <option value='BLANK'>PILIH</option>
                                                                    <?php
                                                                    $dataSql = "SELECT * FROM status_penggunaan 
                                                                                ORDER BY id_status ASC";
                                                                    $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                                    while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                                    if ($dataRow['id_status'] == $_POST['statusguna']) {
                                                                    $cek = " selected";
                                                                    } else { $cek = ""; }
                                                                    echo "
                                                                    <option value='$dataRow[id_status]' $cek>$dataRow[id_status] - $dataRow[ur_status]</option>";
                                                                    }
                                                                    $sqlData = "";
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">Luas Bangunan (SBSK)</label>
                                                            <div class="col-sm-1">
                                                            <input type="text" maxlength="3" class="form-control" name='luasbg' value='<?php echo "$_POST[luasbg]"; ?>'>
                                                            </div>
                                                            <strong>m2</strong>
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