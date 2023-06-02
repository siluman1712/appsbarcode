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
        $aksi = "media/aksi/ubahkondisi.php";
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
                        Perubahan Kondisi Barang Milik Negara (BMN)
                        <small>Kondisi BMN</small>
                      </h1>
                    </section>
                    <section class="content">
                    <a class='btn bg-navy btn-md flat' href=<?php echo "?module=perubahankondisi&act=ubahkondisi"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp; Ubah Kondisi</a>
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table_1" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Kode Barang </th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang </th>
                                                    <th bgcolor='#dcdcdc'> No Aset </th>
                                                    <th bgcolor='#dcdcdc'> Merek </th>
                                                    <th bgcolor='#dcdcdc'> Tanggal Transaksi </th>
                                                    <th bgcolor='#dcdcdc'> Perubahan [Kondisi BMN] </th>
                                                    <th bgcolor='#dcdcdc'> Flag</th>
                                                    <th bgcolor='#dcdcdc'> Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $dist = mysqli_query($koneksi, 
                                                          "SELECT a.tgltransaksi, a.idkondisi, a.merek, 
                                                                  a.noaset, a.kodebarang, a.keterangan,
                                                                  b.kd_brg, b.ur_sskel, b.satuan, a.flag,
                                                                  c.status_kondisi, c.uraian_kondisi
                                                           FROM dbubahkondisi a
                                                           LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                           LEFT JOIN kondisi_bmn c ON c.status_kondisi = a.idkondisi                                      
                                                           ORDER BY a.kodebarang AND a.noaset ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($dist)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[kodebarang]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[noaset]"; ?></td>
                                                        <td><?php echo "$r[merek]"; ?></td>
                                                        <td><?php echo "$r[tgltransaksi]"; ?></td>
                                                        <td>
                                                            <?php if($r['idkondisi']=='31'){?>
                                                            <span class="badge bg-green">
                                                            [<?php echo "$r[idkondisi]"; ?>] <?php echo "$r[uraian_kondisi]"; ?>
                                                            </span>
                                                            <?php } elseif($r['idkondisi']=='32') { ?>
                                                            <span class="badge bg-maroon">
                                                            [<?php echo "$r[idkondisi]"; ?>] <?php echo "$r[uraian_kondisi]"; ?>
                                                            </span>
                                                            <?php }else{ ?>
                                                            <span class="badge bg-red">
                                                            [<?php echo "$r[idkondisi]"; ?>] <?php echo "$r[uraian_kondisi]"; ?>
                                                            </span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-maroon">
                                                            <?php echo "$r[flag]"; ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo "$r[keterangan]"; ?></td>
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

                case "ubahkondisi":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {

                ?>

                    <section class="content">

                        <a class='btn btn-danger btn-sm pull-right' href=<?php echo "?module=perubahankondisi"; ?>>KEMBALI</a>
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
                                                $a = mysqli_query($koneksi,
                                                " SELECT a.kodebarang, a.nup, a.merek, 
                                                         a.tglperoleh, a.kodesatker,
                                                         a.t_anggaran, a.hargaperolehan,
                                                         b.kd_brg, b.ur_sskel, b.satuan,
                                                         c.kodebarang, c.noaset, c.koderuang,
                                                         d.koderuangan, d.namaruangan
                                                  FROM   dbtik a
                                                  LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                  LEFT JOIN dbdistribusi c ON c.kodebarang = a.kodebarang AND c.noaset = a.nup
                                                  LEFT JOIN dbruangan d ON d.koderuangan = c.koderuang
                                                  WHERE  a.kodebarang='$_POST[kodebmn]' AND a.nup = '$_POST[noaset]'
                                                  ORDER BY a.kodebarang AND a.nup ASC");
                                                $r = mysqli_fetch_array($a);
                                                $cekdata = mysqli_num_rows($a);
                                                if(isset($_POST['kodebmn']) && $cekdata==0 ){
                                                  echo "
                                                  <h4>Ulang Lagi</h4> Cek Pengisian / Data Belum lengkap ";
                                                }else{
                                              ?>
                                            
                                            <form id='ubahkondisi' method='post' class='form-horizontal' action='<?php echo "$aksi?module=perubahankondisi&act=simpanperubahan"; ?>' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Kode Barang</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="col-sm-2 control-label">Nama Barang</label>
                                                    <div class="col-sm-4">
                                                    <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$r[ur_sskel]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                        <label class="col-sm-2 control-label">No Aset</label>
                                                        <div class="col-sm-1">
                                                        <input type="text" class="form-control" maxlength="3" name='noaset' id="noaset" value='<?php echo "$r[nup]"; ?>' readonly>
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                <label class="col-sm-2 control-label">Satuan</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='satuan' id="satuan" value='<?php echo "$r[satuan]"; ?>' readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="col-sm-2 control-label">Merek_type</label>
                                                    <div class="col-sm-4">
                                                    <input type="text" class="form-control" name='merek' id="merek" value='<?php echo "$r[merek]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 control-label">Perubahan Kondisi</label>
                                                    <div class="col-sm-2">
                                                        <select class="form-control" name='kondisi' id='kondisi'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <option value='31'>[31] - BAIK [BB]</option>
                                                            <option value='32'>[32] - RUSAK RINGAN [RR]</option>
                                                            <option value='33'>[33] - RUSAK BERAT [RB]</option>


                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="col-sm-2 control-label">Keterangan</label>
                                                    <div class="col-sm-4">
                                                    <input type="text" class="form-control" name='keterangan' id="keterangan" value='<?php echo "$_POSt[keterangan]"; ?>'>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                        <label class="col-sm-2 control-label">Tanggal Transaksi</label>
                                                        <div class="col-md-2">
                                                            <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="tgltrx" data-toggle="tooltip" data-placement="top" title="Tanggal Transaksi">
                                                            </div><!-- input-group -->
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