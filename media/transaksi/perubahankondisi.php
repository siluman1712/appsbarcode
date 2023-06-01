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
                        Perubahan Kondisi Barang Milik Negara (BMN)
                        <small>Kondisi BMN</small>
                      </h1>
                    </section>
                    <section class="content">
                    <a class='btn bg-navy btn-md flat' href=<?php echo "?module=pic&act=addpic"; ?>>
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
                                                    <th bgcolor='#dcdcdc'> Tanggal Perubahan </th>
                                                    <th bgcolor='#dcdcdc'> Perubahan [Kondisi BMN] </th>
                                                    <th bgcolor='#dcdcdc'> Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $dist = mysqli_query($koneksi, 
                                                          "SELECT a.tgltransaksi, a.idkondisi,  
                                                                  a.noaset, a.kodebarang, a.keterangan,
                                                                  b.kd_brg, b.ur_sskel, b.satuan,
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

                case "addpic":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {

                ?>

                    <section class="content">

                        <a class='btn btn-success btn-sm pull-right' href=<?php echo "?module=pic"; ?>>KEMBALI</a>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form class='form-horizontal' method='POST' action='<?php echo "$aksi?module=distribusi&act=picsave"; ?>' enctype='multipart/form-data'>
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
                                                        <input type="text" maxlength="3" class="form-control" name='kuantitas' id="kuantitas" value='<?php echo "$_POST[kuantitas]"; ?>' onkeyup=sum3();>
                                                        <small>Kuantitas</small>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">No Aset</label>
                                                        <div class="col-sm-1">
                                                        <input type="text" class="form-control" maxlength="3" name='nupAWL' id="nupAWL" value='<?php echo "$_POST[nupAWL]"; ?>' onkeyup=sum3();>
                                                        <small>Awal</small>
                                                        </div>

                                                        <div class="col-sm-1">
                                                        <input type="text" class="form-control" maxlength="3" name='nupAKH' id="nupAKH" value='<?php echo "$_POST[nupAKH]"; ?>' readonly>
                                                        <small>Akhir</small>
                                                        </div>
                                                    </div>

                                                  <div class="form-group">
                                                    <label for="tgldist" class="col-sm-2 control-label">PIC BMN</label>

                                                    <div class="col-sm-2">
                                                      <input class='form-control' maxlength="18" type="text" name="NIP1" id="NIP1" placeholder="Masukkan NIP" value='<?php echo "$_POST[NIP1]" ?>' >
                                                    </div>
                                                    <div class="col-sm-3">
                                                      <input class='form-control' maxlength="50" type="text" name="NAMA1" id="NAMA1" placeholder="Nama Pegawai" value='<?php echo "$_POST[NAMA1]" ?>' readonly>
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