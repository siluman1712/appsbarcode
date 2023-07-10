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
    if ($cek == 1 or $_SESSION['LEVEL'] == 'admin') {
        $aksi = "docs/aksi/l_barcode.php";
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $query  = "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl ORDER BY idtgl ASC";
                    $tgl    = $koneksi->query($query);
                    $rs     = mysqli_fetch_array($tgl);
                    $update = date('Y-m-d');

?>
                    
                    <section class="content-header">
                      <h1>Detail BMN</h1>
                    </section>

                    <section class="content">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="box box box-primary"> 
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method='post' class='form-horizontal' action=''>
                                            <div class='form-group'>
                                                <div class='col-sm-4'>
                                                    <select class="select2 form-control" style="width: 100%" name='kodebarang'>
                                                        <option value='<?php echo "$_POST[nupAW]"; ?>'><?php echo "$_POST[nupAW]"; ?></option>
                                                        <?php
                                                        $dataSql = "SELECT  a.kd_brg, a.ur_sskel, a.satuan
                                                                    FROM b_nmbmn a 
                                                                    ORDER BY a.kd_brg ASC";
                                                        $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['kd_brg'] == $_POST['kodebarang']) {
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

                                                        <div class="col-sm-1">
                                                        <input type="text" maxlength="3" class="form-control" name='qty' id="qty" value='<?php echo "$_POST[qty]"; ?>' onkeyup=sum2();>
                                                        <small>Kuantitas</small>
                                                        </div>
                                                        <div class="col-sm-1">
                                                        <input type="text" class="form-control" maxlength="3" name='nupAW' id="nupAW" value='<?php echo "$_POST[nupAW]"; ?>' onkeyup=sum2();>
                                                        <small>Awal</small>
                                                        </div>

                                                        <div class="col-sm-1">
                                                        <input type="text" class="form-control" maxlength="3" name='nupAK' id="nupAK" value='<?php echo "$_POST[nupAK]"; ?>' readonly>
                                                        <small>Akhir</small>
                                                        </div>

                                                
                                            <button type='submit' name='preview' class='btn btn-md btn-primary flat'>
                                                <i class='fa fa-television'></i>&nbsp;&nbsp; Tampilkan</button>
                                            
                                            </div>
                                        </form>
<?php
                                        $a = $koneksi->query(
                                            "   SELECT  a.kodebarang, a.nup,
                                                        b.kd_brg, b.ur_sskel
                                                FROM   dbtik a
                                                LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                WHERE  a.kodebarang ='$_POST[kodebarang]'
                                                AND a.nup BETWEEN '$_POST[nupAW]' AND '$_POST[nupAK]'
                                                ORDER BY a.kodebarang AND a.nup ASC"
                                        );
                                        $data = mysqli_fetch_array($a);
                                        $cekdata = mysqli_num_rows($a);
                                        if (isset($_POST['kodebarang']) and isset($_POST['nupAW']) and isset($_POST['nupAK']) && $cekdata == 0) {
                                            echo "
                                                            <div class='alert bg-blue' role='alert'>
                                                            <h1 align='center'>
                                                            <i class='fa fa-times'></i>
                                                            </i>
                                                            <h2 align='center'>
                                                            <strong>DATA TIDAK ADA / TIDAK DITEMUKAN, COBA LAGI !</strong>  </h2>
                                                            </div>";
                                        } else {
                                        ?>
                                            <table id='simpletable' class='table table-bordered table-striped'>
                                                <thead>
                                                    <tr>
                                                        <th bgcolor='#4682B4' style='width: 7px'>
                                                            <font color='#fff'>#</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>kode barang</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Uraian BMN</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Nomor Aset</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Merek</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Tgl Peroleh</font>
                                                        </th>
                                                        <th bgcolor='#4682B4'>
                                                            <font color='#fff'>Detail</font>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $cek = mysqli_query(
                                                        $koneksi,
                                                        "SELECT  a.kodebarang, a.nup, 
                                                                 a.merek, a.tglperoleh,
                                                                 b.kd_brg, b.ur_sskel
                                                         FROM   dbtik a
                                                         LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                         WHERE  a.kodebarang ='$_POST[kodebarang]'
                                                         AND a.nup BETWEEN '$_POST[nupAW]' AND '$_POST[nupAK]'
                                                         ORDER BY a.kodebarang AND a.nup ASC"
                                                    );

                                                    $numRows = mysqli_num_rows($cek);
                                                    $no = 0;
                                                    while ($r = mysqli_fetch_array($cek)) {
                                                        $no++;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo "$no"; ?></td>
                                                            <td><?php echo "$r[kd_brg]"; ?></td>
                                                            <td><?php echo "$r[ur_sskel]"; ?></b></td>
                                                            <td><?php echo "$r[nup]"; ?></td>
                                                            <td><?php echo "$r[merek]"; ?></td>
                                                            <td><?php echo "$r[tglperoleh]"; ?></td>
                                                            <td>
                                                            <a class='btn bg-blue btn-sm'
                                                            href=<?php echo "?module=pendetailanbmn&act=detail&kodebmn=$r[kodebarang]&noaset=$r[nup]"; ?>>
                                                            <i class="fa fa-search"></i> &nbsp;&nbsp; details   
                                                            </a>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    <?php }
                                                    ?>
                                            </table>
                                            <font face=tahoma size=2>Jumlah Data: <b><?php echo "$numRows"; ?></b></font>
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

                case "detail":
                    if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                        $qry = "SELECT  a.kodebarang, a.nup, a.kodesatker,
                                        a.merek, a.tglperoleh, a.tglbuku,
                                        a.t_anggaran, a.hargaperolehan,
                                        a.nomor_psp, a.tgl_psp, a.kondisibarang,
                                        a.statusbmn,
                                        b.kd_brg, b.ur_sskel, b.satuan,
                                        c.kdukpb, c.nmukpb,
                                        d.status_kondisi, d.uraian_kondisi,
                                        e.appsstatus, e.uraianstatus
                                FROM dbtik a
                                LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                LEFT JOIN s_satker c ON c.kdukpb = a.kodesatker
                                LEFT JOIN kondisi_bmn d ON d.status_kondisi = a.kondisibarang
                                LEFT JOIN bmnstatus e ON e.appsstatus = a.statusbmn
                                WHERE a.kodebarang = '$_GET[kodebmn]' AND a.nup = '$_GET[noaset]'
                                ORDER BY a.kodebarang AND  a.nup ASC";
                        $detail = $koneksi->query($qry );
                        $rs = mysqli_fetch_array($detail); 
                    ?>
    
                        <section class="content">
    
                            <a class='btn btn-danger btn-sm' href=<?php echo "?module=pendetailanbmn"; ?>><i class='fa fa-arrow-left'></i>&nbsp;&nbsp;&nbsp;KEMBALI</a>

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
                                                <input type="text" class="form-control" name='ur_bmn' value='<?php echo "$rs[uraianstatus]"; ?>' readonly>
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


                ?>
<?php
        }
    }
}
?>