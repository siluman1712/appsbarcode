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
        $aksi = "media/aksi/pemeliharaanbmn.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin') {
                $tgl = $koneksi->query("SELECT * FROM s_settgl ORDER BY idtgl ASC");
                $rs  = mysqli_fetch_array($tgl);

                $satker = $koneksi->query("SELECT * FROM s_satker ORDER BY id ASC");
                $s      = mysqli_fetch_array($satker);
                $update = date('Y-m-d');    

?>
                    <section class="content-header">
                      <h1>
                        Pemeliharaan BMN <small>Usulan Masuk dan Tindak Lanjut</small>
                      </h1>
                    </section>
                    <section class="content">
                    <a class='btn bg-blue btn-ms' href=<?php echo "?module=pemeliharaanbmn&act=rekamusul"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp; Rekam Usulan</a>
                    <a class='btn bg-blue btn-ms' href=<?php echo "?module=home"; ?>>
                    <i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp; Kembali Ke Beranda</a>
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table_4" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Kode <br>No Aset <br> Uraian </th>
                                                    <th bgcolor='#dcdcdc'> qty</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Usul</th>
                                                    <th bgcolor='#dcdcdc'> Merek / Keterangan</th>
                                                    <th bgcolor='#dcdcdc'> Permasalahan</th>
                                                    <th bgcolor='#dcdcdc'> Rencana Perbaikan</th>
                                                    <th bgcolor='#dcdcdc'> Tindak Lanjut</th>
                                                    <th bgcolor='#dcdcdc'> Ket TL</th>
                                                    <th bgcolor='#dcdcdc'> Hasil Tinjut</th>
                                                    <th bgcolor='#dcdcdc'> Ket HTL</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Selesai</th>
                                                    <th bgcolor='#dcdcdc' width="25px"> Proses</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tik = $koneksi->query( 
                                                          "SELECT a.kodebarang, a.noaset, a.merek, a.prosedur,
                                                                  a.tglperolehan, a.tgl_pemeliharaan, a.tindaklanjut, 
                                                                  a.nilaiperolehan, a.permasalahan, a.keterangan1, 
                                                                  a.qty, a.kondisi, a.flag, a.rencanapelihara,
                                                                  a.tgl_selesaipelihara, a.hasil_tinjut,
                                                                  a.keterangan2,
                                                                  b.kd_brg, b.ur_sskel,
                                                                  d.status_trx, d.uraian_trx,
                                                                  e.idhasil, e.uraian_hasiltl
                                                           FROM dbpemeliharaan a
                                                           LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                           LEFT JOIN status_transaksi d ON d.status_trx = a.prosedur
                                                           LEFT JOIN hasil_tinjut e ON e.idhasil = a.hasil_tinjut
                                                           WHERE (a.flag IN ('1','2'))  AND a.tgl_pemeliharaan BETWEEN '$rs[s_tglawal]' AND '$rs[s_tglakhir]'
                                                           ORDER BY a.kodebarang ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($tik)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td>
                                                        <?php echo "$r[kodebarang]"; ?>&nbsp;
                                                        <strong><?php echo "$r[noaset]"; ?></strong><br>
                                                        <?php echo "$r[ur_sskel]"; ?>    
                                                        </td>
                                                        <td><?php echo "$r[qty]"; ?></td>
                                                        <td><?php echo indotgl($r[tgl_pemeliharaan]); ?></td>
                                                        <td><?php echo "$r[merek]"; ?></td>
                                                        <td><?php echo "$r[permasalahan]"; ?></td>
                                                        <td><?php echo "$r[rencanapelihara]"; ?></td>
                                                        <td><?php echo "$r[tindaklanjut]"; ?></td>
                                                        <td><?php echo "$r[keterangan1]"; ?></td>
                                                        <td>[<?php echo "$r[hasil_tinjut]"; ?>]&nbsp;
                                                            <?php echo "$r[uraian_hasiltl]"; ?></td>
                                                        <td><?php echo "$r[keterangan2]"; ?></td>
                                                        <td><?php echo "$r[tgl_selesaipelihara]"; ?></td>
                                                        <?php if($r['flag']=='1'){?>
                                                        <td>
                                                        <a class='btn bg-navy btn-sm btn-block' href=<?php echo "?module=pemeliharaanbmn&act=detail&kodebarang=$r[kodebarang]&noaset=$r[noaset]"; ?>>
                                                        <i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp; Detail</a>

                                                        <a class='btn bg-navy btn-sm btn-block' href=<?php echo "?module=pemeliharaanbmn&act=tinjut&kodebarang=$r[kodebarang]&noaset=$r[noaset]"; ?>>
                                                        <i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp; TL</a>

                                                        <a class='btn bg-navy btn-sm btn-block' href=<?php echo "?module=pemeliharaanbmn&act=h_tinjut&kodebarang=$r[kodebarang]&noaset=$r[noaset]"; ?>>
                                                        <i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp; HTL</a>
<br>
                                                        <form method=POST action='<?php echo "media/cetak/kartupelihara.php?kodebarang=$r[kodebarang]&noaset=$r[noaset]"; ?>' target='_blank'>
                                                        <button type=submit class='btn bg-blue btn-sm btn-block'><i class='fa fa-print'></i>&nbsp;&nbsp;&nbsp;Kartu</button>
                                                        </form>
                                                        </td>
                                                        <?php } else { ?>
                                                        <td>
                                                        <form method=POST action='<?php echo "media/cetak/kartupelihara.php?kodebarang=$r[kodebarang]&noaset=$r[noaset]"; ?>' target='_blank'>
                                                        <button type=submit class='btn bg-blue btn-sm btn-block'><i class='fa fa-print'></i>&nbsp;&nbsp;&nbsp;Kartu</button>
                                                        </form>

                                                        <form method=POST action='<?php echo "media/cetak/jadwalpelihara.php?kodebarang=$r[kodebarang]&noaset=$r[noaset]"; ?>' target='_blank'>
                                                        <button type=submit class='btn bg-orange btn-sm btn-block'><i class='fa fa-print'></i>&nbsp;&nbsp;&nbsp;Jadwal</button>
                                                        </form>
                                                        <?php } ?>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <badge class='badge bg-red flat'>* TL = Tindak Lanjut</badge><br>
                        <badge class='badge bg-red flat'>* HTL = Hasil Tindak Lanjut</badge>
                    </section>

                <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "rekamusul":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $dtusul = "SELECT kodebarang, noaset, kondisi_bmn, prosedur, flag FROM dbscanbmn
                               WHERE kondisi_bmn = '32' AND prosedur = '25' AND flag = '1' ";
                    $cek = $koneksi->query($dtusul);
                    $result=mysqli_fetch_array($cek);
                    ?>
    
                        <section class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">


                                        <form name='myform' method='post' action='<?php echo"$aksi?module=pemeliharaanbmn&act=simpanusul";?>'>
                                        <table id="table_4" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th bgcolor="#dcdcdc"> No</th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang</th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset</th>
                                                    <th bgcolor='#dcdcdc'> Merek</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Usul</th>
                                                    <th bgcolor='#dcdcdc'> PIC</th>
                                                    <th bgcolor='#dcdcdc'> Unit</th>
                                                    <th bgcolor='#dcdcdc'> Kondisi</th>
                                                    <th bgcolor='#dcdcdc'> Flag</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                    $dtpelihara = " SELECT a.kodebarang, a.noaset, a.qty,
                                                                           a.merek, a.prosedur, a.kondisi_bmn,
                                                                           a.koderuangan,a.flag, a.tglusul,
                                                                           b.kd_brg, b.ur_sskel, b.satuan,
                                                                           c.kodebarang, c.noaset , c.picnip, c.picnama,
                                                                           d.status_trx, d.uraian_trx,
                                                                           e.status_kondisi, e.uraian_kondisi,
                                                                           f.koderuangan, f.namaruangan
                                                                    FROM dbscanbmn a
                                                                    LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                                    LEFT JOIN dbpicbmn c ON c.kodebarang = a.kodebarang AND c.noaset = a.noaset
                                                                    LEFT JOIN status_transaksi d ON d.status_trx = a.prosedur
                                                                    LEFT JOIN kondisi_bmn e ON e.status_kondisi = a.kondisi_bmn
                                                                    LEFT JOIN dbruangan f ON f.koderuangan = a.koderuangan
                                                                    WHERE a.prosedur = '25' AND a.kondisi_bmn = '32' AND flag = '1'
                                                                    ORDER BY a.kodebarang AND a.noaset ASC";
                                                    $cek = $koneksi->query($dtpelihara);
                                                    $numRows = mysqli_num_rows($cek);
                                                    $no = 0;
                                                    while ($r = mysqli_fetch_array($cek)) {
                                                    $no++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[kodebarang]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[noaset]"; ?></td>
                                                        <td><?php echo "$r[merek]"; ?></td>
                                                        <td><?php echo "$r[tglusul]"; ?></td>
                                                        <td><?php echo "$r[picnama]"; ?></td>
                                                        <td><?php echo "$r[namaruangan]"; ?></td>
                                                        <td><?php if($r['idkondisi']=='31'){?>
                                                            <span class="badge bg-green">[<?php echo "$r[status_kondisi]"; ?>] 
                                                            <?php echo "$r[uraian_kondisi]"; ?></span>
                                                            <?php } elseif($r['idkondisi']=='32') { ?>
                                                            <span class="badge bg-blue">[<?php echo "$r[status_kondisi]"; ?>] 
                                                            <?php echo "$r[uraian_kondisi]"; ?></span>
                                                            <?php }else{ ?>
                                                            <span class="badge bg-red">[<?php echo "$r[status_kondisi]"; ?>] 
                                                            <?php echo "$r[uraian_kondisi]"; ?></span>
                                                            <?php } ?>
                                                        </td>
                                                        <td><span class="badge bg-maroon">
                                                            <?php echo "$r[flag]"; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>
                                        <input type='hidden' name='idkondisi' value='<?php echo"$result[kondisi_bmn]";?>' readonly>
                                        <input type='hidden' name='flag' value='<?php echo"$result[flag]";?>' readonly>
                                        <input type='hidden' name='prosedur' value='<?php echo"$result[prosedur]";?>' readonly>
                                        <button type='submit' id='btnKirim' class='btn btn-sm bg-blue'>
                                        <i class='fa fa-check'></i> &nbsp;&nbsp; Simpan Usul</button>

                                        <a class='btn bg-blue btn-sm' href=<?php echo "?module=pemeliharaanbmn"; ?>><i class="fa fa-arrow-left"></i> &nbsp;&nbsp; Kembali</a>
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

                    case "detail":
                        if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                            $query="SELECT a.kodebarang, a.noaset, a.merek, a.prosedur,
                                    a.tglperolehan, a.tgl_pemeliharaan, 
                                    a.nilaiperolehan, a.permasalahan, a.rencanapelihara,  
                                    a.qty, a.kondisi, a.flag,
                                    b.kd_brg, b.ur_sskel, b.satuan,
                                    c.status_kondisi, c.uraian_kondisi,
                                    d.status_trx, d.uraian_trx,
                                    e.kodebarang, e.noaset, e.koderuang,
                                    f.koderuangan, f.namaruangan,
                                    g.kodebarang, g.noaset, g.picnip, g.picnama
                            FROM dbpemeliharaan a
                            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                            LEFT JOIN kondisi_bmn c ON c.status_kondisi = a.kondisi
                            LEFT JOIN status_transaksi d ON d.status_trx = a.prosedur
                            LEFT JOIN dbdistribusi e ON e.kodebarang = a.kodebarang AND e.noaset = a.noaset
                            LEFT JOIN dbruangan f ON f.koderuangan = e.koderuang
                            LEFT JOIN dbpicbmn g ON g.kodebarang = a.kodebarang AND g.noaset = a.noaset
                            WHERE a.flag = '1' AND a.kodebarang = '$_GET[kodebarang]' AND a.noaset = '$_GET[noaset]'
                            ORDER BY a.kodebarang ASC";
                            $tampil = $koneksi->query($query);
                            $r  = mysqli_fetch_array($tampil);
        
                        ?>
        
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                <form id='scan' method='post' class='form-horizontal' action='<?php echo "$aksi?module=pemeliharaanbmn&act=simpandetail"; ?>' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Kode BMN</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$r[ur_sskel]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">No Aset</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='nup' value='<?php echo "$r[noaset]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Satuan</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='satuan' id="satuan" value='<?php echo "$r[satuan]"; ?>' readonly>
                                                    </div>

                                                    <label class="col-sm-1 control-label">Kuantitas</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='qty' value='<?php echo "$r[qty]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-1">
                                                    <input type="hidden" class="form-control" name='tglperolehan' value='<?php echo "$r[tglperolehan]"; ?>' readonly>
                                                    </div>
                                                    <div class="col-sm-2">
                                                    <input type="hidden" class="form-control" name='h_peroleh' value='<?php echo $r[nilaiperolehan]; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Kondisi</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='idkondisi' value='<?php echo $r[status_kondisi]; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='ur_kondisi' value='<?php echo $r[uraian_kondisi]; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Tgl Usul</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='tglusul' value='<?php echo "$r[tgl_pemeliharaan]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Merek</label>
                                                    <div class="col-sm-4">
                                                    <input type="text" class="form-control" name='merek' value='<?php echo "$r[merek]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">P I C</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='picnip' value='<?php echo $r[picnip]; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='picnama' value='<?php echo $r[picnama]; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">LOC / DBR</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='koderuang' value='<?php echo $r[koderuang]; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-5">
                                                    <input type="text" class="form-control" name='namaruang' value='<?php echo $r[namaruangan]; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Permasalahan</label>
                                                    <div class="col-sm-8">
                                                    <textarea autofocus class="form-control" type="text" rows="5" name='permasalahanbmn'  placeholder="isi dengan Permasalahan BMN yang akan dipelihara" required>
                                                    <?php echo "$r[permasalahan]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Rencana Pemeliharaan</label>
                                                    <div class="col-sm-8">
                                                    <textarea autofocus class="form-control" type="text" rows="5" name='rencanapelihara'  placeholder="isi dengan Perencaan Pemeliharaan BMN yang akan dipelihara" required>
                                                    <?php echo "$r[rencanapelihara]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>

                                                <label for='Kode' class='col-sm-1 control-label'></label>
                                                <button type=submit Data class='btn bg-blue btn-sm'>
                                                <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp; Simpai Detail </button>

                                                <a class='btn bg-blue btn-sm' href=<?php echo "?module=pemeliharaanbmn"; ?>><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp; Kembali</a>

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

                        case "tinjut":
                        if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                            $query="SELECT a.kodebarang, a.noaset, a.merek, a.prosedur,
                                    a.tglperolehan, a.tgl_pemeliharaan, a.permasalahan,
                                    a.nilaiperolehan, a.rencanapelihara, a.keterangan1,
                                    a.qty, a.kondisi, a.flag, a.pelaksana_tinjut,
                                    b.kd_brg, b.ur_sskel, b.satuan,
                                    c.status_kondisi, c.uraian_kondisi,
                                    d.status_trx, d.uraian_trx,
                                    e.kodebarang, e.noaset, e.koderuang,
                                    f.koderuangan, f.namaruangan,
                                    g.kodebarang, g.noaset, g.picnip, g.picnama
                            FROM dbpemeliharaan a
                            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                            LEFT JOIN kondisi_bmn c ON c.status_kondisi = a.kondisi
                            LEFT JOIN status_transaksi d ON d.status_trx = a.prosedur
                            LEFT JOIN dbdistribusi e ON e.kodebarang = a.kodebarang AND e.noaset = a.noaset
                            LEFT JOIN dbruangan f ON f.koderuangan = e.koderuang
                            LEFT JOIN dbpicbmn g ON g.kodebarang = a.kodebarang AND g.noaset = a.noaset
                            WHERE a.flag = '1' AND a.kodebarang = '$_GET[kodebarang]' AND a.noaset = '$_GET[noaset]'
                            ORDER BY a.kodebarang ASC";
                            $tampil = $koneksi->query($query);
                            $r  = mysqli_fetch_array($tampil);
        
                        ?>
        
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                <form id='scan' method='post' class='form-horizontal' action='<?php echo "$aksi?module=pemeliharaanbmn&act=simpantinjut"; ?>' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Kode BMN</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$r[ur_sskel]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">No Aset</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='nup' value='<?php echo "$r[noaset]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Tgl Usul</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='tglusul' value='<?php echo "$r[tgl_pemeliharaan]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Merek</label>
                                                    <div class="col-sm-5">
                                                    <input type="text" class="form-control" name='merek' value='<?php echo "$r[merek]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">P I C</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='picnip' value='<?php echo $r[picnip]; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='picnama' value='<?php echo $r[picnama]; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">LOC / DBR</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='koderuang' value='<?php echo $r[koderuang]; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-5">
                                                    <input type="text" class="form-control" name='namaruang' value='<?php echo $r[namaruangan]; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Permasalahan</label>
                                                    <div class="col-sm-5">
                                                    <textarea class="form-control" type="text" rows="5" name='permasalahanbmn'  placeholder="isi dengan Permasalahan BMN yang akan dipelihara" readonly>
                                                    <?php echo "$r[permasalahan]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Rencana Pemeliharaan</label>
                                                    <div class="col-sm-5">
                                                    <textarea class="form-control" type="text" rows="5" name='rencanapelihara'  placeholder="isi dengan Perencaan Pemeliharaan BMN yang akan dipelihara" readonly>
                                                    <?php echo "$r[rencanapelihara]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>

                                                <div class='form-group'>
                                                    <label class="col-sm-1 control-label">Pengerjaan</label>
                                                    <div class='col-sm-2'>
                                                        <select class="s2 form-control" style="width: 100%" name='pelaksanatl'>
                                                            <option value='BLANK'>PELAKSANA TINJUT</option>
                                                            <?php
                                                            $dataSql = "SELECT  * FROM pelaksana_tinjut ORDER BY idptinjut ASC";
                                                            $dataQry = $koneksi->query($dataSql) or die("Gagal Query" . $koneksi->error);
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['idptinjut'] == $_POST['uraian_ptinjut']) { $cek = " selected";} 
                                                            else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[idptinjut]' $cek>$dataRow[idptinjut]  -  $dataRow[uraian_ptinjut]</option>";
                                                                }
                                                                $sqlData = "";
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Tindak Lanjut Pemeliharaan</label>
                                                    <div class="col-sm-5">
                                                    <textarea class="form-control" type="text" rows="5" name='tinjut'  placeholder="isi dengan Tindak Lanjut Pemeliharaan" >
                                                    <?php echo "$r[tindaklanjut]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Keterangan</label>
                                                    <div class="col-sm-5">
                                                    <textarea class="form-control" type="text" rows="5" name='keterangan1'  placeholder="isi dengan Tindak Lanjut Pemeliharaan" >
                                                    <?php echo "$r[keterangan1]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>

                                                <label for='Kode' class='col-sm-1 control-label'></label>
                                                <button type=submit Data class='btn bg-blue btn-sm'>
                                                <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp; Simpai Detail </button>

                                                <a class='btn bg-blue btn-sm' href=<?php echo "?module=pemeliharaanbmn"; ?>><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp; Kembali</a>

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

                        case "h_tinjut":
                        if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                            $query="SELECT a.kodebarang, a.noaset, a.merek, a.prosedur,
                                    a.tglperolehan, a.tgl_pemeliharaan, a.permasalahan,
                                    a.nilaiperolehan, a.rencanapelihara, a.keterangan1,
                                    a.qty, a.kondisi, a.flag, a.pelaksana_tinjut,
                                    a.tindaklanjut, a.hasil_tinjut, a.keterangan1,
                                    b.kd_brg, b.ur_sskel, b.satuan,
                                    c.status_kondisi, c.uraian_kondisi,
                                    d.status_trx, d.uraian_trx,
                                    e.kodebarang, e.noaset, e.koderuang,
                                    f.koderuangan, f.namaruangan,
                                    g.kodebarang, g.noaset, g.picnip, g.picnama
                            FROM dbpemeliharaan a
                            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                            LEFT JOIN kondisi_bmn c ON c.status_kondisi = a.kondisi
                            LEFT JOIN status_transaksi d ON d.status_trx = a.prosedur
                            LEFT JOIN dbdistribusi e ON e.kodebarang = a.kodebarang AND e.noaset = a.noaset
                            LEFT JOIN dbruangan f ON f.koderuangan = e.koderuang
                            LEFT JOIN dbpicbmn g ON g.kodebarang = a.kodebarang AND g.noaset = a.noaset
                            WHERE a.flag = '1' AND a.kodebarang = '$_GET[kodebarang]' AND a.noaset = '$_GET[noaset]'
                            ORDER BY a.kodebarang ASC";
                            $tampil = $koneksi->query($query);
                            $r  = mysqli_fetch_array($tampil);
        
                        ?>
        
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                <form id='scan' method='post' class='form-horizontal' action='<?php echo "$aksi?module=pemeliharaanbmn&act=simpanhtl"; ?>' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Kode BMN</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                                    </div>

                                                    <label class="col-sm-1 control-label">Uraian BMN</label>
                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$r[ur_sskel]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">No Aset</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='nup' value='<?php echo "$r[noaset]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label" >Merek</label>
                                                    <div class="col-sm-5">
                                                    <input type="text" class="form-control" name='merek' value='<?php echo "$r[merek]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">P I C NIP</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='picnip' value='<?php echo $r[picnip]; ?>' readonly>
                                                    </div>

                                                    <label class="col-sm-1 control-label">P I C NAMA</label>
                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='picnama' value='<?php echo $r[picnama]; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">KODE DBR</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='koderuang' value='<?php echo $r[koderuang]; ?>' readonly>
                                                    </div>

                                                    <label class="col-sm-1 control-label">URAIAN DBR</label>
                                                    <div class="col-sm-5">
                                                    <input type="text" class="form-control" name='namaruang' value='<?php echo $r[namaruangan]; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Tgl Usul</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='tglusul' value='<?php echo "$r[tgl_pemeliharaan]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class='form-group'>
                                                    <label class="col-sm-1 control-label">Pengerjaan</label>
                                                    <div class='col-sm-2'>
                                                        <select class="s2 form-control" style="width: 100%" name='pelaksanatl'>
                                                            <option value='BLANK'>PELAKSANA TINJUT</option>
                                                            <?php
                                                            $dataSql = "SELECT  * FROM pelaksana_tinjut ORDER BY idptinjut ASC";
                                                            $dataQry = $koneksi->query($dataSql) or die("Gagal Query" . $koneksi->error);
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['idptinjut'] == $r['pelaksana_tinjut']) { $cek = " selected";} 
                                                            else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[idptinjut]' $cek>$dataRow[idptinjut]  -  $dataRow[uraian_ptinjut]</option>";
                                                                }
                                                                $sqlData = "";
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Permasalahan</label>
                                                    <div class="col-sm-5">
                                                    <textarea class="form-control" type="text" rows="5" name='permasalahanbmn'  placeholder="isi dengan Permasalahan BMN yang akan dipelihara" readonly>
                                                    <?php echo "$r[permasalahan]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-1 control-label">Rencana Pemeliharaan</label>
                                                    <div class="col-sm-5">
                                                    <textarea class="form-control" type="text" rows="5" name='rencanapelihara'  placeholder="isi dengan Perencaan Pemeliharaan BMN yang akan dipelihara" readonly>
                                                    <?php echo "$r[rencanapelihara]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">
                                                    Tindak Lanjut Pelaksana Pemeliharaan</label>
                                                    <div class="col-sm-5">
                                                    <textarea class="form-control" type="text" rows="4" name='tinjut'  placeholder="isi dengan Tindak Lanjut Pemeliharaan" readonly>
                                                    <?php echo "$r[tindaklanjut]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">
                                                    Keterangan Tindak Lanjut Pelaksana</label>
                                                    <div class="col-sm-5">
                                                    <textarea class="form-control" type="text" rows="4" name='keterangan1'  placeholder="isi dengan Tindak Lanjut Pemeliharaan" readonly>
                                                    <?php echo "$r[keterangan1]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>

                                                <div class='form-group'>
                                                    <label class="col-sm-1 control-label">Hasil Tindak Lanjut</label>
                                                    <div class='col-sm-3'>
                                                        <select class="s2 form-control" style="width: 100%" name='hasil_tinjut'>
                                                            <option value='BLANK'>HASIL TINJUT</option>
                                                            <?php
                                                            $dataSql = "SELECT  * FROM hasil_tinjut ORDER BY idhasil ASC";
                                                            $dataQry = $koneksi->query($dataSql) or die("Gagal Query" . $koneksi->error);
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['idhasil'] == $_POST['hasil_tinjut']) { $cek = " selected";} 
                                                            else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[idhasil]' $cek>$dataRow[idhasil]  -  $dataRow[uraian_hasiltl]</option>";
                                                                }
                                                                $sqlData = "";
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">
                                                    Keterangan Hasil Tindak Lanjut</label>
                                                    <div class="col-sm-5">
                                                    <textarea class="form-control" type="text" rows="4" name='keterangan2'  placeholder="isi dengan Tindak Lanjut Pemeliharaan">
                                                    <?php echo "$r[keterangan2]"; ?>
                                                    </textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Tanggal Selesai</label>
                                                    <div class="col-md-2">
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name='tglselesai' value='<?php echo "$rs[s_tglakhir]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal Akhir">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                    </div>
                                                </div>


                                                <label class="col-sm-1 control-label"></label>
                                                <button type=submit Data class='btn bg-blue btn-sm'>
                                                <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp; Simpai Hasil Tindak Lanjut </button>

                                                <a class='btn bg-blue btn-sm' href=<?php echo "?module=pemeliharaanbmn"; ?>><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp; Kembali</a>

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