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
        $aksi = "media/aksi/penghapusan.php";
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
                        Daftarkan Penghapusan <small>Tentukan Kondisi Rusak Berat</small>
                      </h1>
                    </section>
                    <section class="content">
                    <a class='btn bg-navy btn-md flat' href=<?php echo "?module=penghapusan&act=simpan"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp; Daftar Proses Penghapusan Rusak Berat</a>
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <table id="table_4" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th bgcolor="#dcdcdc"> No</th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang</th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset</th>
                                                    <th bgcolor='#dcdcdc'> Kuantitas</th>
                                                    <th bgcolor='#dcdcdc'> Satuan</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Nilai Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Nilai Limit</th>
                                                    <th bgcolor='#dcdcdc'> Nilai Buku</th>
                                                    <th bgcolor='#dcdcdc'> Kondisi BMN</th>
                                                    <th bgcolor='#dcdcdc'> Merek</th>
                                                    <th bgcolor='#dcdcdc'> flag</th>
                                                    <th bgcolor='#dcdcdc'> Update Data</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                    $hapus = mysqli_query(
                                                        $koneksi,
                                                        "SELECT a.kodebarang, a.noaset, a.qty,
                                                                a.flag, a.kondisi, a.nilailimit, 
                                                                a.nilaibuku, a.tglperolehan, 
                                                                a.nilaiperolehan, a.satuan,
                                                                b.kd_brg, b.ur_sskel, 
                                                                c.kodebarang, c.nup, c.hargaperolehan,
                                                                c.merek, c.tglperoleh, 
                                                                d.status_kondisi, d.uraian_kondisi
                                                        FROM   dbpenghapusan a
                                                        LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                        LEFT JOIN dbtik c ON c.kodebarang = a.kodebarang AND c.nup = a.noaset
                                                        LEFT JOIN kondisi_bmn d ON d.status_kondisi = a.kondisi
                                                        WHERE  a.kondisi ='33' AND a.flag IN('2','3')
                                                        ORDER BY a.kodebarang AND a.noaset ASC"
                                                    );

                                                    $numRows = mysqli_num_rows($hapus);
                                                    $no = 0;
                                                    while ($rs = mysqli_fetch_array($hapus)) {
                                                        $no++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$rs[kodebarang]"; ?></td>
                                                        <td><?php echo "$rs[ur_sskel]"; ?></td>
                                                        <td><?php echo "$rs[nup]"; ?></td>
                                                        <td><?php echo "$rs[qty]"; ?></td>
                                                        <td><?php echo "$rs[satuan]"; ?></td>
                                                        <td><?php echo "$rs[tglperolehan]"; ?></td>
                                                        <td><?php echo "$rs[nilaiperolehan]"; ?></td>
                                                        <td><?php echo "$rs[nilailimit]"; ?></td>
                                                        <td><?php echo "$rs[nilaibuku]"; ?></td>
                                                        <td><?php echo "$rs[uraian_kondisi]"; ?></td>
                                                        <td><?php echo "$rs[merek]"; ?></td>
                                                        <td><span class="badge bg-maroon"> <?php echo "$rs[flag]"; ?></span></td>
                                                        <td>
                                                        <a class="btn btn-primary btn-xs" title='Update Data Penghapusan' href=<?php echo "?module=penghapusan&act=update&kodebarang=$rs[kodebarang]&noaset=$rs[noaset]"; ?>>
                                                        <i class="fa fa-retweet"></i>&nbsp;&nbsp;&nbsp;Update Data  
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
                    </section>

                <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "simpan":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
    
                    ?>
    
                        <section class="content">
    
                            <a class='btn btn-success btn-ms' href=<?php echo "?module=penghapusan"; ?>>KEMBALI</a>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                <form id='info' class='form-horizontal' method='POST' action='' enctype='multipart/form-data'>
                                            <div class="form-group">
                                                    <label class="col-sm-2 control-label">Filter </label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" name='pencarian' id='pencarian' onchange="tampilkan()">
                                                            <option value='BLANK'>PILIH</option>
                                                            <option value='01'>[01] - Status BMN</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <select class="form-control" name='kategori' id='kategori'>
                                                            
                                                        </select>
                                                    </div>
                                                    <button type='submit' class='btn btn-primary btn-md'>
                                                    <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Tampilkan</button>
                                            </div>
                                        </form>

                                        <?php
                                        $a = mysqli_query(
                                            $koneksi,
                                            "   SELECT  a.kodebarang, a.noaset,
                                                        a.flag, a.idkondisi, a.keterangan,
                                                        b.kd_brg, b.ur_sskel,
                                                        c.kodebarang, c.nup, 
                                                        c.merek, c.tglperoleh,
                                                        d.status_kondisi, d.uraian_kondisi
                                            FROM   dbubahkondisi a
                                            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                            LEFT JOIN dbtik c ON c.kodebarang = a.kodebarang AND c.nup = a.noaset
                                            LEFT JOIN kondisi_bmn d ON d.status_kondisi = a.idkondisi 
                                            WHERE  a.idkondisi LIKE '%$_POST[kategori]%' AND a.flag = '1'
                                            ORDER BY a.kodebarang AND a.noaset ASC"
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
                                        <form name='myform' method='post' action='<?php echo"$aksi?module=penghapusan&act=simpandata";?>'>
                                        <input type='hidden' class='form-control' name='idkondisi' maxlength='4' value='<?php echo"$data[idkondisi]";?>' readonly>
                                        <input type='hidden' class='form-control' name='flag' maxlength='4' value='<?php echo"$data[flag]";?>' readonly>
                                        <table id="table_4" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th bgcolor="#dcdcdc"> No</th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang</th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset</th>
                                                    <th bgcolor='#dcdcdc'> Merek</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Kondisi</th>
                                                    <th bgcolor='#dcdcdc'> Keterangan</th>
                                                    <th bgcolor='#dcdcdc'> Flag</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                    $cek = mysqli_query(
                                                        $koneksi,
                                                        "SELECT  a.kodebarang, a.noaset,
                                                        a.flag, a.idkondisi, a.keterangan,
                                                        b.kd_brg, b.ur_sskel,
                                                        c.kodebarang, c.nup, 
                                                        c.merek, c.tglperoleh,
                                                        d.status_kondisi, d.uraian_kondisi
                                                        FROM   dbubahkondisi a
                                                        LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                        LEFT JOIN dbtik c ON c.kodebarang = a.kodebarang AND c.nup = a.noaset
                                                        LEFT JOIN kondisi_bmn d ON d.status_kondisi = a.idkondisi 
                                                        WHERE  a.idkondisi LIKE '%$_POST[kategori]%' AND a.flag = '1'
                                                        ORDER BY a.kodebarang AND a.noaset ASC"
                                                    );

                                                    $numRows = mysqli_num_rows($cek);
                                                    $no = 0;
                                                    while ($r = mysqli_fetch_array($cek)) {
                                                        $no++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[kodebarang]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[nup]"; ?></td>
                                                        <td><?php echo "$r[merek]"; ?></td>
                                                        <td><?php echo "$r[tglperoleh]"; ?></td>
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
                                                        <td><?php echo "$r[keterangan]"; ?></td>
                                                        <td><span class="badge bg-maroon">
                                                            <?php echo "$r[flag]"; ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>
                                        <input type='hidden' name='n' value='<?php echo"$no";?>'/>
                                        <button type='submit' id='btnKirim' class='btn btn-sm btn-danger flat'>
                                        <i class='fa fa-send'></i> &nbsp;&nbsp; Simpan Data</button>
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

                    case "update":
                        if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {

                            $tampil = mysqli_query($koneksi,
                            "SELECT a.kodebarang, a.noaset, a.qty,
                                    a.flag, a.kondisi, a.nilailimit, 
                                    a.nilaibuku, 
                                    a.nilaiperolehan, 
                                    b.kd_brg, b.ur_sskel, b.satuan,
                                    c.kodebarang, c.nup, c.hargaperolehan,
                                    c.merek, c.tglperoleh, 
                                    d.status_kondisi, d.uraian_kondisi
                            FROM   dbpenghapusan a
                            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                            LEFT JOIN dbtik c ON c.kodebarang = a.kodebarang AND c.nup = a.noaset
                            LEFT JOIN kondisi_bmn d ON d.status_kondisi = a.kondisi
                            WHERE  a.kodebarang ='$_GET[kodebarang]' AND a.noaset = '$_GET[noaset]'
                            ORDER BY a.kodebarang AND a.noaset ASC");
                        $r  = mysqli_fetch_array($tampil);
        
                        ?>
        
                            <section class="content">
        
                                <a class='btn btn-danger btn-sm flat' href=<?php echo "?module=penghapusan"; ?>>KEMBALI</a>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                <form id='scan' method='post' class='form-horizontal' action='<?php echo "$aksi?module=penghapusan&act=simpanhapus"; ?>' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Kode BMN</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Uraian BMN</label>
                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$r[ur_sskel]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Satuan</label>
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
                                                    <label class="col-sm-2 control-label">Kuantitas</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='qty' value='<?php echo "$r[qty]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Tanggal Perolehan</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='tglperoleh' value='<?php echo "$r[tglperoleh]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Nilai Perolehan</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='h_peroleh' value='<?php echo $r[hargaperolehan]; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Nilai Limit</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='h_limit' value='<?php echo $r[nilailimit]; ?>'>
                                                    <small>Sesuaikan dengan SAKTI</small>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Nilai Buku</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='n_buku' value='<?php echo $r[nilaibuku]; ?>'>
                                                    <small>Sesuaikan dengan SAKTI</small>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Kondisi</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='status_kondisi' value='<?php echo $r[status_kondisi]; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='uraian_kondisi' value='<?php echo $r[uraian_kondisi]; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Merek</label>
                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='merek' value='<?php echo "$r[merek]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <fieldset>
                                                <label for='Kode' class='col-sm-2 control-label'></label>
                                                <button type=submit Data class='btn btn-primary btn-md flat'>
                                                <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp; Update Data Hapus </button>
                                                </fieldset>

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
<script>
function tampilkan(){
  var pencarian=document.getElementById("info").pencarian.value;
  if (pencarian=="01")
    {document.getElementById("kategori").innerHTML="<option value='BLANK'>PILIH</option><option value='31'>[31] - Baik [BB]</option><option value='32'>[32] - Rusak Ringan [RR]</option><option value='33'>[33] - Rusak Berat [RB]</option>";}

  else if (pencarian=="02")
    {document.getElementById("kategori").innerHTML="<option value='BLANK'>PILIH</option><option value='11'>[11] - Baru Asal Pengadaan</option><option value='12'>[12] - Proses Penghapusan BMN</option><option value='13'>[13] - Proses Sensus BMN</option><option value='14'>[14] - BMN Baru Asal Transfer</option><option value='15'>[15] - Proses Pinjam Pakai BMN</option>";}
}
</script>