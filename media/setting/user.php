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
        $aksi = "media/aksi/appsPengaturan.php"; 
        switch ($_GET['act']) {
            default:
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                $tgl = $koneksi->query("SELECT * FROM m_settglsys ORDER BY idtgl ASC");
                $rs  = mysqli_fetch_array($tgl);

                $satker = $koneksi->query("SELECT * FROM s_satker ORDER BY id ASC");
                $s      = mysqli_fetch_array($satker);
                $update = date('Y-m-d');

?>
                    <section class="content-header">
                      <h1>
                        User Aktif
                      </h1>
                    </section>
                    <?php 
                    $id_reg = $_POST['ID'];
                    $kueri  = "SELECT MAX(ID) AS akhir FROM a_useraktif WHERE ID LIKE '%$id_reg%'";
                    $data   = mysqli_fetch_array($koneksi->query($kueri));
                    $last   = $data['akhir'];
                    $next   = $last+1;
                    ?>
                    <section class="content">
                        <div class="row">
                        <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    <form class='form-horizontal' id=payment method='POST' action='<?php echo"$aksi?module=user&act=newuser";?>' enctype="multipart/form-data">
                                        <input type='hidden' name='idsatker' class='form-control' value='<?php echo"$s[id]";?>' readonly> 
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                            <h1><span class="label label-primary"><?php echo"$next"; ?></span></h1>
                                            <small>ID Lanjut User</small>    
                                            </div>
                                        </div>

                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-1 control-label">ID User</label>
                                         <div class="col-sm-1">
                                         <input type="text" class="form-control" name='ID' value='<?php echo "$next"; ?>' readonly>
                                         </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-1 control-label">Kode SatKer</label>
                                         <div class="col-sm-2">
                                         <input type='text' name='kdukpb' class='form-control' value='<?php echo"$s[kdukpb]";?>' readonly> 
                                         </div>
                                         <div class="col-sm-3">
                                         <input type='text' name='nmukpb' class='form-control' value='<?php echo"$s[nmukpb]";?>' readonly> 
                                         </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-1 control-label">NIP</label>
                                        <div class="col-sm-2">
                                            <input class='form-control' maxlength="18" type="text" name="NIP1" id="NIP1" placeholder="Masukkan NIP" value='<?php echo "$_POST[NIP1]" ?>' >
                                        </div>
                                        <div class="col-sm-3">
                                            <input class='form-control' maxlength="50" type="text" name="NAMA1" id="NAMA1" placeholder="Nama Pegawai" value='<?php echo "$_POST[NAMA1]" ?>' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">User Name</label>
                                        <div class="col-sm-2">
                                            <input class='form-control' type="text" maxlength="15" name="UNAME" placeholder="User Name" value='<?php echo "$_POST[UNAME]" ?>' >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Password</label>
                                        <div class="col-sm-2">
                                            <input class='form-control' type="password" maxlength="8" name="PASSWORD" placeholder="PASSWORD" value='<?php echo "$_POST[PASSWORD]" ?>' >
                                        <small>Pass max : 8 Karakter</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tgldist" class="col-sm-1 control-label">Level</label>
                                        <div class="col-sm-1">
                                          <select class="form-control" style="width: 100%" name='LEVEL'>
                                            <option value='admin'>Admin </option>
                                            <option value='user'>User </option>
                                          </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Email</label>
                                        <div class="col-sm-3">
                                            <input class='form-control' type="email" name="EMAIL" placeholder="Masukkan Email" value='<?php echo "$_POST[email]" ?>' >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">No Telp / WA</label>
                                        <div class="col-sm-2">
                                            <input class='form-control' type="text" maxlength="13" name="TELPWA" placeholder="nomor telp / wa" value='<?php echo "$_POST[telpwa]" ?>' >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Foto</label>
                                        <div class="col-sm-3">
                                            <input class='form-control' type="file" name="imgavatar" placeholder="Tentukan Avatar mu" value='<?php echo "$_POST[imgavatar]" ?>' >
                                            <?php 
                                                    if(isset($_GET['alert'])){
                                                        if($_GET['alert']=='gagal_ekstensi'){
                                                            ?>
                                                            <div class="alert alert-danger">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                                <h5><i class="icon fa fa-check"></i> Ekstensi Tidak Diperbolehkan</h5>
                                                            </div>                             
                                                            <?php
                                                        }elseif($_GET['alert']=="gagal_ukuran"){
                                                            ?>
                                                            <div class="alert alert-warning">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                                <h5><i class="icon fa fa-check"></i>Ukuran File terlalu Besar</h5>
                                                                
                                                            </div>                              
                                                            <?php
                                                        }elseif($_GET['alert']=="berhasil"){
                                                            ?>
                                                            <div class="alert alert-success">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                                <h5><i class="icon fa fa-check"></i>Berhasil Disimpan</h5>
                                                            </div>                              
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Status</label>
                                        <div class="col-sm-1">
                                            <input class='form-control' type="text" name="STATUS" value='Offline' readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Aktivasi</label>
                                        <div class="col-sm-1">
                                            <input class='form-control' type="text" name="AKTIF" value='1' readonly>
                                        </div>
                                    </div>
                                      <div class="form-group">
                                           
                                           <div class="col-sm-3">
                                            <button type='submit' class='btn btn-success btn-sm' >
                                            <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Simpan New User</button>
                                            <button type='reset' class='btn btn-danger btn-sm' >
                                            <i class='fa fa-retweet'></i>&nbsp;&nbsp;&nbsp;Reset Form User</button>
                                           </div>
                                         </div>
                                    </form>

                                    <table id="table_2" class="table ">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#00dcdc'> NIP </th>
                                                    <th bgcolor='#00dcdc'> LOKINS</th>
                                                    <th bgcolor='#00dcdc'> UNAME</th>
                                                    <th bgcolor='#00dcdc'> PASSWORD</th>
                                                    <th bgcolor='#00dcdc'> LEVEL</th>
                                                    <th bgcolor='#00dcdc'> AKTIF</th>
                                                    <th bgcolor='#00dcdc'> AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $kueri = "SELECT a.NIP, a.LOKINS, a.UNAME, a.ID,
                                                                 a.PASSWORD, a.LEVEL, a.EMAIL, 
                                                                 a.LOGIN_TERAKHIR, a.STATUS, 
                                                                 a.FOTO, a.NOTELP, a.AKTIF,
                                                                 b.nip, b.nama,
                                                                 c.kdukpb, c.nmukpb
                                                        FROM a_useraktif a
                                                        LEFT JOIN dbpegawai b ON b.nip = a.NIP
                                                        LEFT JOIN s_satker c ON c.kdukpb = a.LOKINS
                                                        WHERE a.AKTIF = '1'
                                                        ORDER BY a.LOKINS AND a.UNAME ASC";
                                                $dbuser = $koneksi->query($kueri);
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($dbuser)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[NIP]"; ?></td>
                                                        <td><?php echo "$r[LOKINS]"; ?></td>
                                                        <td><?php echo "$r[UNAME]"; ?></td>
                                                        <td><?php echo "$r[PASSWORD]"; ?></td>
                                                        <td><?php echo "$r[LEVEL]"; ?></td>
                                                        <td><?php echo "$r[AKTIF]"; ?></td>
                                                        <td width="200">
                                                          <a class='btn btn-primary btn-sm' title='AKTIFASI'
                                                          href=<?php echo "?module=user&act=aktifasi&id=$r[ID]"; ?>>
                                                          <i class="fa fa-check-square-o"></i>&nbsp;&nbsp;AKTIFASI 
                                                          </a>

                                                          <a class='btn btn-danger btn-sm' title='Hapus Data' href="<?php echo $aksi;?>?module=user&act=hapus&id=<?php echo $r[ID];?>" onClick="return confirm('Anda yakin ingin menghapus ID&nbsp;&nbsp;<?php echo $r[ID];?> UNAME:&nbsp;&nbsp;<?php echo $r[UNAME];?>?');"><i class="fa fa-trash"></i>&nbsp;&nbsp;HAPUS DATA
                                                          </a>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table> 

                                        <table id="table_4" class="table ">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> NIP </th>
                                                    <th bgcolor='#dcdcdc'> LOKINS</th>
                                                    <th bgcolor='#dcdcdc'> UNAME</th>
                                                    <th bgcolor='#dcdcdc'> PASSWORD</th>
                                                    <th bgcolor='#dcdcdc'> LEVEL</th>
                                                    <th bgcolor='#dcdcdc'> EMAIL</th>
                                                    <th bgcolor='#dcdcdc'> LOG TERAKHIR</th>
                                                    <th bgcolor='#dcdcdc'> FOTO</th>
                                                    <th bgcolor='#dcdcdc'> TELP</th>
                                                    <th bgcolor='#dcdcdc'> STATUS</th>
                                                    <th bgcolor='#dcdcdc'> AKTIF</th>
                                                    <th bgcolor='#dcdcdc'> AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $kueri = "SELECT a.NIP, a.LOKINS, a.UNAME, a.ID,
                                                                 a.PASSWORD, a.LEVEL, a.EMAIL, 
                                                                 a.LOGIN_TERAKHIR, a.STATUS, 
                                                                 a.FOTO, a.NOTELP, a.AKTIF,
                                                                 b.nip, b.nama,
                                                                 c.kdukpb, c.nmukpb
                                                        FROM a_useraktif a
                                                        LEFT JOIN dbpegawai b ON b.nip = a.NIP
                                                        LEFT JOIN s_satker c ON c.kdukpb = a.LOKINS
                                                        WHERE a.AKTIF = '2'
                                                        ORDER BY a.LOKINS AND a.UNAME ASC";
                                                $dbuser = $koneksi->query($kueri);
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($dbuser)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[NIP]"; ?></td>
                                                        <td><?php echo "$r[LOKINS]"; ?></td>
                                                        <td><?php echo "$r[UNAME]"; ?></td>
                                                        <td><?php echo "$r[PASSWORD]"; ?></td>
                                                        <td><?php echo "$r[LEVEL]"; ?></td>
                                                        <td><?php echo "$r[EMAIL]"; ?></td>
                                                        <td><?php echo "$r[LOGIN_TERAKHIR]"; ?></td>
                                                        <td><?php echo "$r[FOTO]"; ?></td>
                                                        <td><?php echo "$r[NOTELP]"; ?></td>
                                                        <td>
                                                        <?php if($r['STATUS']=='Online'){?>
                                                        <span class="badge badge-lg bg-green"><?php echo "$r[STATUS]"; ?></span>
                                                        <?php }else{?>
                                                        <span class="badge badge-lg bg-red"><?php echo "$r[STATUS]"; ?></span>
                                                        <?php }?>
                                                        </td>
                                                        <td>
                                                        <?php if($r['AKTIF']=='2'){?>
                                                        <span class="badge badge-lg bg-blue"><?php echo "$r[AKTIF]"; ?></span>
                                                        <?php }else{?>
                                                        <span class="badge badge-lg bg-maroon"><?php echo "$r[AKTIF]"; ?></span>
                                                        <?php }?>
                                                        </td>
                                                        <td width="100">
                                                          <a class='btn btn-danger btn-sm' title='AKTIFASI'
                                                          href=<?php echo "?module=user&act=nonaktifasi&id=$r[ID]"; ?>>
                                                          <i class="fa fa-check-square-o"></i>&nbsp;&nbsp;BATAL AKTIFASI 
                                                          </a>
                                                        </td>

                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>  
                                        # 1 : TIDAK AKTIF (USER)<br>
                                        # 2 : AKTIF (USER)
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

                case "aktifasi":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                $kueri = "SELECT    a.NIP, a.LOKINS, a.UNAME, a.ID,
                                    a.PASSWORD, a.LEVEL, a.EMAIL, 
                                    a.LOGIN_TERAKHIR, a.STATUS, 
                                    a.FOTO, a.NOTELP, a.AKTIF,
                                    b.nip, b.nama,
                                    c.kdukpb, c.nmukpb
                          FROM a_useraktif a
                          LEFT JOIN dbpegawai b ON b.nip = a.NIP
                          LEFT JOIN s_satker c ON c.kdukpb = a.LOKINS
                          WHERE a.AKTIF = '1'
                          AND a.ID = '$_GET[id]'
                          ORDER BY a.LOKINS AND a.UNAME ASC";
                $tampil = $koneksi->query($kueri);
                $rs = mysqli_fetch_array($tampil);
                ?>

                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                            <form class='form-horizontal' id=payment method='POST' action='<?php echo"$aksi?module=user&act=aktifkan";?>' enctype="multipart/form-data">


                                            <div class="form-group">
                                                <label for="tgldist" class="col-sm-1 control-label">ID User</label>
                                                 <div class="col-sm-1">
                                                 <input type="text" class="form-control" name='ID' value='<?php echo"$rs[ID]";?>' readonly>
                                                 </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label">User Name</label>
                                                <div class="col-sm-2">
                                                    <input class='form-control' type="text" maxlength="15" name="UNAME" placeholder="User Name" value='<?php echo "$rs[UNAME]" ?>' readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label">Password</label>
                                                <div class="col-sm-2">
                                                    <input class='form-control' type="password" maxlength="8" name="PASSWORD" placeholder="PASSWORD" value='<?php echo "$rs[PASSWORD]" ?>' readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label">Aktivasi</label>
                                                <div class="col-sm-2">
                                                  <select class="form-control" style="width: 100%" name='AKTIF'>
                                                    <option value='1'>[1] BELUM AKTIFASI </option>
                                                    <option value='2'>[2] AKTIFKAN</option>
                                                  </select>
                                                </div>
                                            </div>
                                      <div class="form-group">
                                           <label class="col-sm-1 control-label"></label>
                                            <div class="col-sm-3">
                                            <button type='submit' class='btn btn-primary btn-sm' >
                                            <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Aktifkan User</button>
                                            <a class='btn btn-success btn-sm' href=<?php echo "?module=user"; ?>>
                                            <i class="fa fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Kembali</a>
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

                case "nonaktifasi":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                $kueri = "SELECT    a.NIP, a.LOKINS, a.UNAME, a.ID,
                                    a.PASSWORD, a.LEVEL, a.EMAIL, 
                                    a.LOGIN_TERAKHIR, a.STATUS, 
                                    a.FOTO, a.NOTELP, a.AKTIF,
                                    b.nip, b.nama,
                                    c.kdukpb, c.nmukpb
                          FROM a_useraktif a
                          LEFT JOIN dbpegawai b ON b.nip = a.NIP
                          LEFT JOIN s_satker c ON c.kdukpb = a.LOKINS
                          WHERE a.AKTIF = '2'
                          AND a.ID = '$_GET[id]'
                          ORDER BY a.LOKINS AND a.UNAME ASC";
                $tampil = $koneksi->query($kueri);
                $rs = mysqli_fetch_array($tampil);
                ?>

                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                            <form class='form-horizontal' id=payment method='POST' action='<?php echo"$aksi?module=user&act=nonaktifkan";?>' enctype="multipart/form-data">


                                            <div class="form-group">
                                                <label for="tgldist" class="col-sm-1 control-label">ID User</label>
                                                 <div class="col-sm-1">
                                                 <input type="text" class="form-control" name='ID' value='<?php echo"$rs[ID]";?>' readonly>
                                                 </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label">User Name</label>
                                                <div class="col-sm-2">
                                                    <input class='form-control' type="text" maxlength="15" name="UNAME" placeholder="User Name" value='<?php echo "$rs[UNAME]" ?>' readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label">Password</label>
                                                <div class="col-sm-2">
                                                    <input class='form-control' type="password" maxlength="8" name="PASSWORD" placeholder="PASSWORD" value='<?php echo "$rs[PASSWORD]" ?>' readonly>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-1 control-label">Aktivasi</label>
                                                <div class="col-sm-2">
                                                  <select class="form-control" style="width: 100%" name='AKTIF'>
                                                    <option value='<?php echo "$rs[AKTIF]" ?>'><?php echo "$rs[AKTIF]" ?> </option>
                                                    <option value='1'>[1] NON AKTIFKAN </option>
                                                    <option value='2'>[2] AKTIFKAN</option>
                                                  </select>
                                                </div>
                                            </div>
                                      <div class="form-group">
                                           <label class="col-sm-1 control-label"></label>
                                            <div class="col-sm-3">
                                            <button type='submit' class='btn btn-primary btn-sm' >
                                            <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp;Aktifkan User</button>
                                            <a class='btn btn-success btn-sm' href=<?php echo "?module=user"; ?>>
                                            <i class="fa fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Kembali</a>
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