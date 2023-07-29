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
                        Konfigurasi Waktu / Tanggal
                      </h1>
                    </section>
                    <section class="content">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form class='form-horizontal' method='POST' action='<?php echo "$aksi?module=settgl&act=updatetgl"; ?>' enctype='multipart/form-data'>
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <label>Tanggal Awal</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="hidden" class="form-control" name='idtgl' value='<?php echo "$rs[idtgl]"; ?>'>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="tglawal" value='<?php echo "$rs[s_tglawal]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal Awal">
                                                    </div><!-- input-group -->
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Tanggal Akhir</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name='tglakhir' value='<?php echo "$rs[s_tglakhir]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal Akhir">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <label>Tahun Anggaran</label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" placeholder="YYYY" name='thn_ang' value='<?php echo "$rs[s_thnang]"; ?>' data-toggle="tooltip" data-placement="top" title="Tahun Anggaran">
                                                    </div>
                                                </div>

                                            </div>
                                            <button type='submit' class='btn btn-primary btn-md flat'>
                                                <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;UPDATE</button>
                                        </form>

                                        <table id="table_4" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> No </th>
                                                    <th bgcolor='#dcdcdc'> TANGGAL AWAL</th>
                                                    <th bgcolor='#dcdcdc'> TANGGAL AKHIR</th>
                                                    <th bgcolor='#dcdcdc'> TAHUN ANGGARAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $unut = mysqli_query($koneksi, " SELECT * FROM s_settgl ORDER BY idtgl ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($unut)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[s_tglawal]"; ?></td>
                                                        <td><?php echo "$r[s_tglakhir]"; ?></td>
                                                        <td><?php echo "$r[s_thnang]"; ?></td>
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