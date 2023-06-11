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
                        Surat Izin Penghunian Rumah Negara
                        <small>Pendaftaran Pegawai untuk penempatan Rumah Negara</small>
                      </h1>
                    </section>
                    <section class="content">
                    <a class='btn bg-red btn-md flat' href=<?php echo "?module=siprumahnegara&act=sip"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Pendaftaran SIP </a>
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <table id="table_1" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Kode Barang </th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset / NUP</th>
                                                    <th bgcolor='#dcdcdc'> Nama</th>
                                                    <th bgcolor='#dcdcdc'> NIP</th>
                                                    <th bgcolor='#dcdcdc'> TMT Penghunian</th>
                                                    <th bgcolor='#dcdcdc'> SK SIP</th>
                                                    <th bgcolor='#dcdcdc'> SK Tanggal</th>
                                                    <th bgcolor='#dcdcdc'> Lama Penghunian</th>
                                                    <th bgcolor='#dcdcdc'> Nilai Sewa</th>
                                                    <th bgcolor='#dcdcdc'> Status Penghunian</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tik = mysqli_query($koneksi, 
                                                          "SELECT a.penghuni_nip, a.penghuni_nilaisewa, 
                                                                  a.penghuni_nama, a.penghuni_tmthuni,
                                                                  a.penghuni_sksip, a.penghuni_tglsk, 
                                                                  a.penghuni_lamahuni, a.kodebarang,  
                                                                  a.penghuni_status, a.noaset,
                                                                  b.kd_brg, b.ur_sskel, 
                                                                  c.nip, c.nama, c.nama_depan, c.nama_belakang,
                                                                  c.idgolru, c.tmt_golru, c.jabatan,
                                                                  d.GOL_GOLNAM, d.GOL_PKTNAM
                                                           FROM dbsip a
                                                           LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                           LEFT JOIN dbpegawai c ON c.nip = a.penghuni_nip
                                                           LEFT JOIN dbgolru d ON d.GOL_GOLNAM = c.idgolru
                                                           ORDER BY a.kodebarang AND a.noaset ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($tik)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[kodebarang]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[noaset]"; ?></td>
                                                        <td><?php echo "$r[qty]"; ?></td>
                                                        <td><?php echo "$r[tglperoleh]"; ?></td>
                                                        <td><?php echo "$r[hargaperolehan]"; ?><br>
                                                        <td><?php echo "$r[uraian_kondisi]"; ?><br>
                                                        <td><?php echo "$r[merek]"; ?></td>
                                                        <td>
                                                        <span class="badge bg-red">
                                                        <?php echo "$r[flag]"; ?></span>
                                                        </td>
                                                        
                                                        <td>
                                                        <?php if($r['prosedur']=='21'){?>
                                                        <span class="badge bg-green">
                                                        <?php echo "$r[uraian_trx]"; ?>
                                                        </span>
                                                        <?php } elseif($r['prosedur']=='22') { ?>
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

                case "sip":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {

                ?>

                    <section class="content">

                        <a class='btn btn-danger btn-sm' href=<?php echo "?module=siprumahnegara"; ?>><i class='fa fa-arrow-left'></i>&nbsp;&nbsp;&nbsp;KEMBALI</a>
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
                                            $a = mysqli_query(
                                                $koneksi,
                                                "   SELECT  a.status_psp, a.status_kondisi, a.status_bmn, 
                                                            b.status_psp, b.uraianstatus_psp,
                                                            c.appsstatus, c.uraianstatus
                                                            FROM dbtik a
                                                    LEFT JOIN status_psp b ON b.status_psp = a.status_psp 
                                                    LEFT JOIN bmnstatus c ON c.appsstatus = a.status_bmn 
                                                    WHERE  a.status_psp LIKE '%$_POST[kategori]%' OR a.status_bmn LIKE '%$_POST[kategori]%' 
                                                    ORDER BY a.status_psp ASC"
                                            );
                                            $data = mysqli_fetch_array($a);
                                            $cekdata = mysqli_num_rows($a);
                                            if (isset($_POST['kategori']) && $cekdata == 0) {
                                                echo "
                                                                <div class='alert bg-blue' role='alert'>
                                                                <h4><i class='ik ik-alert-octagon'></i> Pemberitahuan!</h4>
                                                                Data Tidak Ditemukan!
                                                                </div>";
                                            } else {
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
                                                    <label class="col-sm-2 control-label">Merek</label>
                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='merek' value='<?php echo "$r[merek]"; ?>'>
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

                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Prosedur Transaksi</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" name='prosedur' id='prosedur' onchange="tampilkan()">
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
                                                <button type=submit Data class='btn btn-primary btn-md flat'>
                                                <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp; Simpan </button>
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