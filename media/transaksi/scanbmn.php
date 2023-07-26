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
                        Rekam Usulan BMN
                        <small>Pengusulan BMN [PSP], [Pemeliharaan], [SENSUS / Inventaris Ulang] dan [Peminjaman]</small>
                      </h1>
                    </section>
                    <section class="content">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <table id="table_4" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Kode Barang </th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset / NUP</th>
                                                    <th bgcolor='#dcdcdc'> qty</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Usul</th>
                                                    <th bgcolor='#dcdcdc'> Harga Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Merek / Keterangan</th>
                                                    <th bgcolor='#dcdcdc'> flag</th>
                                                    <th bgcolor='#dcdcdc'> Transaksi</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tik = $koneksi->query( 
                                                          "SELECT a.kodebarang, a.noaset, a.merek, a.prosedur,
                                                                  a.tglperoleh, a.t_anggaran, a.tglusul,
                                                                  a.hargaperolehan, a.kodesatuankerja,  
                                                                  a.qty, a.kondisi_bmn, a.flag,
                                                                  b.kd_brg, b.ur_sskel, a.periode,
                                                                  c.kdukpb, c.nmukpb,
                                                                  d.status_trx, d.uraian_trx
                                                           FROM dbscanbmn a
                                                           LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                           LEFT JOIN s_satker c ON c.kdukpb = a.kodesatuankerja
                                                           LEFT JOIN status_transaksi d ON d.status_trx = a.prosedur
                                                           WHERE a.flag = '1'
                                                           ORDER BY a.kodebarang ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($tik)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[kodebarang]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[noaset]"; ?></td>
                                                        <td><?php echo "$r[qty]"; ?></td>
                                                        <td><?php echo "$r[tglusul]"; ?></td>
                                                        <td><?php echo "$r[hargaperolehan]"; ?></td>
                                                        <td><?php echo "$r[merek]"; ?></td>
                                                        <td>
                                                        <span class="badge bg-red">
                                                        <?php echo "$r[flag]"; ?></span>
                                                        </td>
                                                        
                                                        <td>
                                                        <?php if($r['prosedur']=='22'){?>
                                                        <span class="badge bg-green">
                                                        <?php echo "$r[uraian_trx]"; ?>
                                                        </span>
                                                        <?php } elseif($r['prosedur']=='23') { ?>
                                                        <span class="badge bg-orange">
                                                        <?php echo "$r[uraian_trx]"; ?>
                                                        </span>
                                                        <?php } elseif($r['prosedur']=='24') { ?>
                                                        <span class="badge bg-blue">
                                                        <?php echo "$r[uraian_trx]"; ?>
                                                        </span>
                                                        <?php }else{ ?>
                                                        <span class="badge bg-maroon">
                                                        <?php echo "$r[uraian_trx]"; ?>
                                                        </span>
                                                        <?php } ?>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>  
                                    <a class='btn bg-blue btn-sm' href=<?php echo "?module=scanbmn&act=UsulBaru"; ?>>
                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Usul Baru Transaksi</a>
                                    <a class='btn bg-blue btn-sm' href=<?php echo "?module=home"; ?>>
                                    <i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp; Kembali ke Beranda</a>
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

                case "UsulBaru":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {

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
                                                        <div class="col-sm-2">
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
                                                " SELECT a.kodebarang, a.nup, a.merek, 
                                                         a.tglperoleh, a.kodesatker,
                                                         a.t_anggaran, a.hargaperolehan,
                                                         b.kd_brg, b.ur_sskel, b.satuan,
                                                         c.kodebarang, c.noaset, c.koderuang,
                                                         d.koderuangan, d.namaruangan,
                                                         e.kodebarang, e.noaset, e.picnip,
                                                         e.picnama,
                                                         f.kodebarang, f.noaset, f.idkondisi,
                                                         f.keterangan, f.idperubahan,
                                                         g.status_kondisi, g.uraian_kondisi
                                                  FROM   dbtik a
                                                  LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                  LEFT JOIN dbdistribusi c ON c.kodebarang = a.kodebarang AND c.noaset = a.nup
                                                  LEFT JOIN dbruangan d ON d.koderuangan = c.koderuang
                                                  LEFT JOIN dbpicbmn e ON e.kodebarang = a.kodebarang AND e.noaset = a.nup
                                                  LEFT JOIN dbubahkondisi f ON f.kodebarang = a.kodebarang AND f.noaset = a.nup
                                                  LEFT JOIN kondisi_bmn g ON g.status_kondisi = f.idkondisi
                                                  WHERE  a.kodebarang='$_POST[kodebmn]' AND a.nup = '$_POST[noaset]'
                                                  ORDER BY a.kodebarang AND a.nup AND f.idperubahan desc");
                                                $r = mysqli_fetch_array($a);
                                                $cekdata = mysqli_num_rows($a);
                                                if(isset($_POST['kodebmn']) && $cekdata==0 ){
                                                  echo "
                                                  <h4>Ulang Lagi</h4> Cek Pengisian / Data Belum lengkap ";
                                                }else{
                                              ?>

                                            <form id='scan' method='post' class='form-horizontal' action='<?php echo "$aksi?module=scanbmn&act=addscan"; ?>' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"></label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$r[ur_sskel]"; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='satuan' id="satuan" value='<?php echo "$r[satuan]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">No Aset</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='nup' value='<?php echo "$r[nup]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Tahun Anggaran</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='t_anggaran' value='<?php echo "$r[t_anggaran]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Periode Anggaran</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='periode' value='<?php echo date(m, strtotime($r[tglperoleh])); ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Kode Satuan Kerja</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='kodesatker' value='<?php echo "$r[kodesatker]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Tanggal Perolehan</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='tglperoleh' value='<?php echo "$r[tglperoleh]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Harga Perolehan</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='h_peroleh' value='<?php echo $r[hargaperolehan]; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Koderuang</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='koderuang' value='<?php echo "$r[koderuang]"; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-5">
                                                    <input type="text" class="form-control" name='namaruangan' value='<?php echo "$r[namaruangan]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">P I C</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='picnip' value='<?php echo "$r[picnip]"; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-4">
                                                    <input type="text" class="form-control" name='picnama' value='<?php echo "$r[picnama]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Merek</label>
                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='merek' value='<?php echo "$r[merek]"; ?>'>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Tanggal Usul</label>
                                                    <div class="col-sm-2">
                                                        <div class="input-group date">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="tglusul" value='<?php echo "$_POST[tglusul]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal Pengusulan">
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Kondisi Barang</label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" name='idkondisi'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <option value='31'>[31] - Kondisi BAIK [BB]</option>
                                                            <option value='32'>[32] - Kondisi RUSAK RINGAN [RR]</option>
                                                            <option value='33'>[33] - Kondisi RUSAK BERAT [RB]</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Prosedur Transaksi (Usulan)</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" name='prosedur'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <option value='22'>[22] - Proses Penetapan Status Pengguna</option>
                                                            <option value='23'>[23] - Proses Inventaris / Sensus</option>
                                                            <option value='24'>[24] - Proses Peminjaman</option>
                                                            <option value='25'>[25] - Proses Pemeliharaan</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <fieldset>
                                                <label for='Kode' class='col-sm-2 control-label'></label>
                                                &nbsp;
                                                <button type=submit Data class='btn btn-primary btn-ms'>
                                                <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp; Simpan Usulan </button>

                                                <button type=reset Data class='btn btn-primary btn-ms'>
                                                <i class='fa fa-retweet'></i>&nbsp;&nbsp;&nbsp; Batal Usulan [reset] </button>

                                                <a class='btn btn-primary btn-ms' href=<?php echo "?module=scanbmn"; ?>><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp; Kembali </a>
                                                </fieldset>

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