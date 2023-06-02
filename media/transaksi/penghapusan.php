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
                                                    <th bgcolor="#dcdcdc"><input class='minimal' type="checkbox" onchange="checkAll(this)">&nbsp;&nbsp;&nbsp;PILIH</th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang</th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset</th>
                                                    <th bgcolor='#dcdcdc'> Merek</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Kondisi</th>
                                                    <th bgcolor='#dcdcdc'> Status PSP</th>
                                                    <th bgcolor='#dcdcdc'> Status BMN</th>
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
                                                        <td>
                                                        <div class='border-checkbox-group border-checkbox-group-primary'>
                                                        <input class='minimal' type='checkbox' name='kondisi<?php echo"$no";?>' value='<?php echo"$o[idkondisi]";?>' />
                                                        </div>
                                                        </td>
                                                        <td><?php echo "$r[kodebarang]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[nup]"; ?></td>
                                                        <td><?php echo "$r[merek]"; ?></td>
                                                        <td><?php echo "$r[tglperoleh]"; ?></td>
                                                        <td><span class="badge bg-green">[<?php echo "$r[status_kondisi]"; ?>] 
                                                            <?php echo "$r[uraian_kondisi]"; ?></span></td>
                                                        <td>

                                                        </td>
                                                        <td>

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

                                        <table id="table_4" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th bgcolor="#dcdcdc"><input class='minimal' type="checkbox" onchange="checkAll(this)">&nbsp;&nbsp;&nbsp;PILIH</th>
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
                                                        <td>
                                                        <div class='border-checkbox-group border-checkbox-group-primary'>
                                                        <input class='minimal' type='checkbox' name='kondisi<?php echo"$no";?>' value='<?php echo"$o[idkondisi]";?>' />
                                                        </div>
                                                        </td>
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
<script>
function tampilkan(){
  var pencarian=document.getElementById("info").pencarian.value;
  if (pencarian=="01")
    {document.getElementById("kategori").innerHTML="<option value='BLANK'>PILIH</option><option value='31'>[31] - Baik [BB]</option><option value='32'>[32] - Rusak Ringan [RR]</option><option value='33'>[33] - Rusak Berat [RB]</option>";}

  else if (pencarian=="02")
    {document.getElementById("kategori").innerHTML="<option value='BLANK'>PILIH</option><option value='11'>[11] - Baru Asal Pengadaan</option><option value='12'>[12] - Proses Penghapusan BMN</option><option value='13'>[13] - Proses Sensus BMN</option><option value='14'>[14] - BMN Baru Asal Transfer</option><option value='15'>[15] - Proses Pinjam Pakai BMN</option>";}
}
</script>
<script type="text/javascript">
  function checkAll(box) 
  {
   let checkboxes = document.getElementsByTagName('input');

   if (box.checked) { // jika checkbox teratar dipilih maka semua tag input juga dipilih
    for (let i = 0; i < checkboxes.length; i++) {
     if (checkboxes[i].type == 'checkbox') {
      checkboxes[i].checked = true;
     }
    }
   } else { // jika checkbox teratas tidak dipilih maka semua tag input juga tidak dipilih
    for (let i = 0; i < checkboxes.length; i++) {
     if (checkboxes[i].type == 'checkbox') {
      checkboxes[i].checked = false;
     }
    }
   }
  }
 </script>