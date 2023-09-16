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
        $aksi = "media/AKSI/appsPengaturan.php";
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
                        Database Pegawai <small><?php echo "$s[nmukpb]";?></small>
                      </h1>
                    </section>
                    <section class="content">
                        <div class="row">
                        <div class="col-md-12">
                            <a class='btn bg-blue btn-ms flat' href=<?php echo "?module=dbpegawai&act=baru"; ?>>
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp; Tambah Data</a>
                            <br><br>
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table_3" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> NO </th>
                                                    <th bgcolor='#dcdcdc'> NIP</th>
                                                    <th bgcolor='#dcdcdc'> NAMA </th>
                                                    <th bgcolor='#dcdcdc'> GOLRU</th>
                                                    <th bgcolor='#dcdcdc'> TMT GOLRU</th>
                                                    <th bgcolor='#dcdcdc' width="150px"> JABATAN</th>
                                                    <th bgcolor='#dcdcdc'> TMT JABATAN</th>
                                                    <th bgcolor='#dcdcdc'> AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "  SELECT  a.nip, a.nama, a.idgolru,
                                                                    a.tmt_golru, a.jabatan, a.tmt_jabatan,
                                                                    b.GOL_KODGOL, b.GOL_GOLNAM, b.GOL_PKTNAM
                                                            FROM dbpegawai a
                                                            LEFT JOIN dbgolru b ON b.GOL_KODGOL = a.idgolru
                                                            ORDER BY a.nip ASC";
                                                $peg = $koneksi->query($query);
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($peg)) {
                                                $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$r[nip]"; ?></td>
                                                        <td><?php echo "$r[nama]"; ?></td>
                                                        <td><?php echo "$r[GOL_GOLNAM]"; ?>/<?php echo "$r[GOL_PKTNAM]"; ?></td>
                                                        <td><?php echo "$r[tmt_golru]"; ?></td>
                                                        <td><?php echo "$r[jabatan]"; ?></td>
                                                        <td><?php echo "$r[tmt_jabatan]"; ?></td>
                                                        <td>


                                                      <a class='btn bg-black btn-sm' title='Update Data Per NIP'
                                                      href=<?php echo "?module=dbpegawai&act=update&nip=$r[nip]"; ?>>
                                                      <i class="fa fa-pencil"></i>    
                                                      </a>

                                                      <a class='btn bg-red btn-sm' title='Hapus NIP' href="<?php echo $aksi;?>?module=dbpegawai&act=hapus&nip=<?php echo $r[nip];?>" onClick="return confirm('Anda yakin ingin menghapus ?<?php echo $r[pns_nama];?>?');"><i class="fa fa-trash"></i>
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
                        </div>
                        </div>
                    </section>

               <?php
                } else {
                    echo "Anda tidak berhak mengakses halaman ini.";
                }
                break;

                case "baru":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {

                ?>

                    <section class="content">

                        <a class='btn btn-success btn-ms' href=<?php echo "?module=dbpegawai"; ?>>KEMBALI</a>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                            <form class='form-horizontal' method='POST' action='' enctype='multipart/form-data'>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">NIP Baru</label>
                                                        <div class="col-sm-2">
                                                        <input type="text" maxlength="18" class="form-control" name='nipbaru' value='<?php echo "$_POST[nipbaru]"; ?>'>
                                                        <small>NIP Pegawai</small>
                                                        </div>
                                                    
                                                    <div class="form-group">
                                                        <button type="submit" class="btn bg-green btn-md flat"><i class="fa fa-check"></i> &nbsp;&nbsp;Scan</button>
                                                        </div>
                                                    </div>

                                            </form>
                                              <?php
                                              $query =" SELECT  a.PNS_NIPBARU, a.PNS_PNSNAM, 
                                                                a.PNS_GLRDPN, a.PNS_GLRBLK, 
                                                                a.PNS_GOLRU, a.PNS_TMTGOL,
                                                                b.GOL_KODGOL, b.GOL_GOLNAM, b.GOL_PKTNAM
                                                        FROM m_pupns a
                                                        LEFT JOIN dbgolru b ON b.GOL_KODGOL = a.PNS_GOLRU
                                                        WHERE  a.PNS_NIPBARU='$_POST[nipbaru]' 
                                                        ORDER BY a.PNS_NIPBARU ASC";
                                                $a = $koneksi->query($query);
                                                $r = mysqli_fetch_array($a);
                                                $cekdata = mysqli_num_rows($a);
                                                if(isset($_POST['nipbaru']) && $cekdata==0 ){
                                                  echo "
                                                  <h4>Ulang Lagi</h4> Cek Pengisian / Data Belum lengkap ";
                                                }else{
                                              ?>

                                            <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=dbpegawai&act=baru"; ?>' enctype='multipart/form-data'>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"></label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='nip' value='<?php echo "$r[PNS_NIPBARU]"; ?>' readonly>
                                                    </div>

                                                    <div class="col-sm-3">
                                                    <input type="text" class="form-control" name='nama' value='<?php echo "$r[PNS_PNSNAM]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Lokasi INSTANSI</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='LOKINS' value='<?php echo "$_SESSION[LOKINS]"; ?>' readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Gelar Depan</label>
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='PNS_GLRDPN' value='<?php echo "$r[PNS_GLRDPN]"; ?>'>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Gelar Belakang</label>
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='PNS_GLRBLK' value='<?php echo "$r[PNS_GLRBLK]"; ?>'>
                                                    </div>
                                                </div>

                                                    <div class='form-group'>
                                                        <label class="col-sm-2 control-label">Golongan Ruang / Pangkat</label>
                                                        <div class='col-sm-4'>
                                                            <select class="s2 form-control" style="width: 100%" name='golru'>
                                                                <option value='BLANK'>ID GOLRU</option>
                                                                <?php
                                                                $dataSql = "SELECT * FROM dbgolru 
                                                                            ORDER BY GOL_KODGOL ASC";
                                                                $dataQry = $koneksi->query($dataSql) or die("Gagal Query" . $koneksi->error);
                                                                while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                                    if ($dataRow['GOL_KODGOL'] == $r['PNS_GOLRU']) {$cek = " selected";
                                                                         } else { $cek = "";}
                                                                    echo "
                                                                <option value='$dataRow[GOL_KODGOL]' $cek>$dataRow[GOL_GOLNAM]  -  $dataRow[GOL_PKTNAM]</option>";
                                                                }
                                                                $sqlData = "";
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                <div class="form-group">
                                                        <label class="col-sm-2 control-label">TMT Golongan Ruang</label>
                                                        <div class="col-md-2">
                                                            <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="PNS_TMTGOL" data-toggle="tooltip" data-placement="top" title="TMT GOLRU" value='<?php echo "$r[PNS_TMTGOL]"; ?>'>
                                                            </div><!-- input-group -->

                                                        <small>TMT Golongan Ruang</small>
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Jabatan</label>
                                                    <div class="col-sm-6">
                                                    <input type="text" class="form-control" name='JABATAN' value='<?php echo "$_POST[JABATAN]"; ?>'>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                        <label class="col-sm-2 control-label">TMT Jabatan</label>
                                                        <div class="col-md-2">
                                                            <div class="input-group date">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="TMT_JABATAN" data-toggle="tooltip" data-placement="top" title="TMT GOLRU" value='<?php echo "$_POST[PNS_TMTGOL]"; ?>'>
                                                            </div><!-- input-group -->

                                                        <small>TMT Golongan Ruang</small>
                                                        </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Keterangan</label>
                                                    <div class="col-sm-6">
                                                    <input type="text" class="form-control" name='keterangan' value='<?php echo "$_POST[keterangan]"; ?>'>
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

                case "pegDetail":
                  if ($_SESSION['LEVEL']=='admin' OR $_SESSION['LEVEL']=='user'){

                  ?>
                      <section class="content">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <form action="" method="post">
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Masukkan NIP" name='nip' 
                                            value='<?php echo "$_POST[nip]"; ?>' >
                                            <span class="input-group-btn">
                                            <button type="submit" name="preview" class="btn btn-primary btn-md flat">Cari</button>
                                            </span>
                                        </div>
                                        <small>Nomor Induk Pegawai</small>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <?php
                                if (isset($_POST['preview'])) {
                                    $nip = $_POST['nip'];
                                    if (empty($_POST['nip'])) {
                                        echo "<script language='javascript'>alert('Masih ada yang belum diisi');
                                        window.location = 'appmedia.php?module=M_PEGAWAI&act=pegDetail'</script>";
                                    } else {
                                ?>
                                <br>
                                <?php
                                $query = "SELECT    a.pns_instansi, a.pns_nip, a.pns_nama,
                                            a.pns_templahir, a.pns_tgllahir, a.pns_tmtgolru,
                                            a.pns_golru, a.pns_tmtjab, a.pns_jabatan, a.pns_kanreg,
                                            a.pns_unitkerja, a.pns_telp, a.pns_plt, a.pns_uraiantambahan,
                                            a.pns_jabplt,a.pns_unitplt, a.idpegawai, a.pns_namblkg,
                                            a.jns_peg, a.pns_unitkerja2, a.pns_namdepan, a.pns_tglplt,
                                            b.JBF_KODJAB, b.JBF_NAMJAB, b.JBF_USIPEN,
                                            c.GOL_KODGOL, c.GOL_GOLNAM, c.GOL_PKTNAM,
                                            d.r_idutama, d.r_ruangutama, d.r_namaruang,
                                            e.jns_peg, e.jns_nama,
                                            f.PNS_NOMHP, f.PNS_NIPBARU,
                                            g.idkanreg, g.kanregnama, g.kanreg_lokker,
                                            h.INS_KODINS, h.INS_NAMINS
                                FROM m_pegawai a
                                LEFT JOIN m_jabatan b ON b.JBF_KODJAB = a.pns_jabatan
                                LEFT JOIN m_golru c ON c.GOL_KODGOL = a.pns_golru
                                LEFT JOIN r_ruangutama d ON d.r_idutama = a.pns_unitkerja
                                LEFT JOIN m_jnspeg e ON e.jns_peg = a.jns_peg
                                LEFT JOIN m_pupns f ON f.PNS_NIPBARU =a.pns_nip
                                LEFT JOIN m_kanreg g ON g.idkanreg = a.pns_kanreg
                                LEFT JOIN m_instansi h ON h.INS_KODINS = a.pns_instansi
                                WHERE a.pns_nip = '$_POST[nip] '
                                ORDER BY a.pns_nip DESC";
                                $pegs = $koneksi->query($query);
                                $i = mysqli_fetch_array($pegs);
                                //Info Kepala
                                ?>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo "$i[pns_nip]"; ?>' readonly>
                                        <small><font color='red'>NIP</font></small>
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo "$i[pns_namdepan]"; ?><?php echo "$i[pns_nama] "; ?><?php echo "$i[pns_namblkg]"; ?>' readonly>
                                        <small><font color='red'>Nama Pegawai</font></small>
                                    </div>

                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo "$i[pns_instansi]"; ?>' readonly>
                                        <small><font color='red'>ID</font></small>
                                    </div>

                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo "$i[INS_NAMINS]"; ?>' readonly>
                                        <small><font color='red'>Intansi</font></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo "$i[idkanreg]"; ?>' readonly>
                                        <small><font color='red'>Asal</font></small>
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo "$i[kanregnama]"; ?>' readonly>
                                        <small><font color='red'>Nama Kanreg</font></small>
                                    </div>

                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo indotgl($i['pns_tgllahir']); ?>' readonly>
                                        <small><font color='red'>Tanggal Lahir</font></small>
                                    </div>

                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo "$i[pns_templahir]"; ?>' readonly>
                                        <small><font color='red'>Lokasi Lahir</font></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo "$i[GOL_GOLNAM]"; ?>' readonly>
                                        <small><font color='red'>Golru</font></small>
                                    </div>

                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo "$i[GOL_PKTNAM]"; ?>' readonly>
                                        <small><font color='red'>Pangkat</font></small>
                                    </div>

                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo indotgl($i['pns_tmtgolru']); ?>' readonly>
                                        <small><font color='red'>TMT GOLRU</font></small>
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo "$i[JBF_NAMJAB]"; ?>' readonly>
                                        <small><font color='red'>Jabatan</font></small>
                                    </div>

                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" 
                                        name='pns_unitkerja2' value='<?php echo indotgl($i['pns_tmtjab']); ?>' readonly>
                                        <small><font color='red'>TMT JABATAN</font></small>
                                    </div>
                                </div>

                                <small><font color='Blue'>Uraian Tambahan</font></small>
                                        <table id="table" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> ID</th>
                                                    <th bgcolor='#dcdcdc'> NIP</th>
                                                    <th bgcolor='#dcdcdc'> PLT</th>
                                                    <th bgcolor='#dcdcdc'> TGL PLT</th>
                                                    <th bgcolor='#dcdcdc'> JABATAN</th>
                                                    <th bgcolor='#dcdcdc'> UNIT PLT</th>
                                                    <th bgcolor='#dcdcdc'> KETERANGAN </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $dp = "SELECT  a.pns_instansi, a.pns_nip, a.pns_nama,
                                                            a.pns_templahir, a.pns_tgllahir, a.pns_tmtgolru,
                                                            a.pns_golru, a.pns_tmtjab, a.pns_jabatan, a.pns_kanreg,
                                                            a.pns_unitkerja, a.pns_telp, a.pns_plt, a.pns_uraiantambahan,
                                                            a.pns_jabplt,a.pns_unitplt, a.idpegmaster, a.pns_namblkg,
                                                            a.jns_peg, a.pns_unitkerja2, a.pns_namdepan, a.pns_tglplt,
                                                            b.JBF_KODJAB, b.JBF_NAMJAB, b.JBF_USIPEN,
                                                            c.GOL_KODGOL, c.GOL_GOLNAM, c.GOL_PKTNAM,
                                                            d.r_idutama, d.r_ruangutama, d.r_namaruang,
                                                            e.jns_peg, e.jns_nama,
                                                            f.PNS_NOMHP, f.PNS_NIPBARU,
                                                            g.idkanreg, g.kanregnama, g.kanreg_lokker,
                                                            h.INS_KODINS, h.INS_NAMINS
                                                    FROM m_masterpeg a
                                                    LEFT JOIN m_jabatan b ON b.JBF_KODJAB = a.pns_jabatan
                                                    LEFT JOIN m_golru c ON c.GOL_KODGOL = a.pns_golru
                                                    LEFT JOIN r_ruangutama d ON d.r_idutama = a.pns_unitkerja
                                                    LEFT JOIN m_jnspeg e ON e.jns_peg = a.jns_peg
                                                    LEFT JOIN m_pupns f ON f.PNS_NIPBARU =a.pns_nip
                                                    LEFT JOIN m_kanreg g ON g.idkanreg = a.pns_kanreg
                                                    LEFT JOIN m_instansi h ON h.INS_KODINS = a.pns_instansi
                                                    WHERE a.pns_nip = '$_POST[nip] '
                                                    ORDER BY a.pns_nip ASC";
                                                $result = $koneksi->query($dp);
                                                $no = 0;
                                                while ($rs = mysqli_fetch_array($result)) {
                                                $no++;
                                                ?>
                                                    <tr>
                                                    <?php if($rs[pns_plt]=='1' OR $rs[pns_plt]=='2' OR $rs[pns_plt]=='3'){?>    
                                                        <td><?php echo "$rs[idpegmaster]"; ?></td>
                                                        <td><?php echo "$rs[pns_nip]"; ?></td>
                                                        <td><?php echo "$rs[pns_plt]"; ?></td>
                                                        <td><?php echo indotgl($rs['pns_tglplt']); ?></td>
                                                        <td><?php echo "$rs[JBF_NAMJAB]"; ?></td>
                                                        <td><?php echo "$rs[pns_unitkerja2]"; ?></td>
                                                        <td><?php echo "$rs[pns_uraiantambahan]"; ?></td>
                                                    <?php }else{ ?>
                                                    <?php } ?>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table> <?php }} ?>

                            </div>
                        </div>
                        <a href='?module=M_PEGAWAI' class="btn btn-sm bg-red">
                        <i class="fa fa-arrow-left"></i>&nbsp;&nbsp; Kembali    
                        </a>
                    </section>
  <?php
  }else{echo "Anda tidak berhak mengakses halaman ini.";}
  break;

  case "urTambahan":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {
                    $tampil = mysqli_query($koneksi,
                        "SELECT a.pns_nip, a.pns_nama, a.pns_namblkg,
                                a.pns_namdepan,
                                a.pns_unitkerja, a.pns_telp, a.pns_plt, a.pns_uraiantambahan,
                                a.pns_jabplt,a.pns_unitplt, a.idpegawai, 
                                a.jns_peg, a.pns_unitkerja2,  a.pns_tglplt,
                                b.JBF_KODJAB, b.JBF_NAMJAB, b.JBF_USIPEN,
                                c.GOL_KODGOL, c.GOL_GOLNAM, c.GOL_PKTNAM,
                                d.r_idutama, d.r_ruangutama, d.r_namaruang,
                                e.jns_peg, e.jns_nama,
                                f.PNS_NOMHP, f.PNS_NIPBARU,
                                g.idkanreg, g.kanregnama, g.kanreg_lokker
                        FROM m_pegawai a
                        LEFT JOIN m_jabatan b ON b.JBF_KODJAB = a.pns_jabatan
                        LEFT JOIN m_golru c ON c.GOL_KODGOL = a.pns_golru
                        LEFT JOIN r_ruangutama d ON d.r_idutama = a.pns_unitkerja
                        LEFT JOIN m_jnspeg e ON e.jns_peg = a.jns_peg
                        LEFT JOIN m_pupns f ON f.PNS_NIPBARU =a.pns_nip
                        LEFT JOIN m_kanreg g ON g.idkanreg = a.pns_kanreg
                        WHERE a.pns_nip = '$_GET[nip]'
                        ORDER BY a.pns_nip ASC");
                    $r  = mysqli_fetch_array($tampil);
      
                ?>

                    <section class="content">
                        <div class="row">
                            <!-- KENDARAAN DINAS <br> --> 
                            <div class="col-md-6">
                                <div class="box"> 
                                    <div class="box-header with-border">
                                    <h6 class="box-title">Info Pegawai </h6>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form method='post' class='form-horizontal' action='<?php echo "$aksi?module=M_PEGAWAI&act=urTambahan"; ?>' enctype='multipart/form-data'>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name='nip' value='<?php echo "$r[pns_nip]"; ?>' readonly>
                                                            <small>Nomor Pegawai</small>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" name='titleDepan' value='<?php echo "$r[pns_namdepan]"; ?>' readonly>
                                                            <small><font color='red'>Dpn</font></small>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name='nampeg' value='<?php echo "$r[pns_nama]"; ?>' readonly>
                                                            <small><font color='red'>Nama Pegawai</font></small>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" name='titleBlkg' value='<?php echo "$r[pns_namblkg]"; ?>' readonly>
                                                            <small>Nama Pegawai <font color='red'>Blkg</font></small>
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" name='pns_tgllahir' value='<?php echo "$r[pns_tgllahir]"; ?>' readonly>
                                                        </div>

                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name='pns_templahir' value='<?php echo "$r[pns_templahir]"; ?>' readonly>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <textarea type="text" rows="4" class="form-control" name='pns_uraian'><?php echo "$r[pns_uraiantambahan]"; ?></textarea> 
                                                            <small><font color='red'>* Update Uraian Tambahan Pegawai</font></small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <select class="s2 form-control"  name='plt' id="plt" >
                                                                <option value='<?php echo"$r[pns_plt]";?>'><?php echo"$r[pns_plt]";?></option>
                                                                <option value='2'>TIDAK</option>
                                                                <option value='1'>PLT (Pejabat Sementara)</option>
                                                            </select>
                                                            <small> <font color='red'>*Pilih Apakah Menjabat / Diperbantukan Unit Lain</font>
                                                            </small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <select class="s2 form-control"  name='jabplt' id='jabplt' disabled="true">
                                                                <option value='BLANK'>PILIH</option>
                                                                <?php
                                                                $dataSql = "SELECT JBF_KODJAB, JBF_NAMJAB, JBF_USIPEN
                                                                            FROM m_jabatan
                                                                            WHERE (JBF_KODJAB IN ('00002','00003','00004','00005','00006',00014,00015, 00016, 00011,00012,00013))
                                                                            ORDER BY JBF_KODJAB ASC";
                                                                $dataQry = mysqli_query($koneksi, $dataSql) 
                                                                           or die(" Query" . mysqli_error($koneksi));
                                                                           while ($dataRow = mysqli_fetch_assoc($dataQry)) {
                                                                            if ($dataRow['JBF_KODJAB'] == $r['pns_jabplt']) {
                                                                                $cek = " selected";
                                                                            }else{$cek = "";}
                                                                            echo "
                                                                            <option value='$dataRow[JBF_KODJAB]' $cek>$dataRow[JBF_KODJAB] - $dataRow[JBF_NAMJAB]</option>";
                                                                        }
                                                                $sqlData = "";
                                                                ?>
                                                            </select>
                                                            <small><font color='red'> * Pilih Jabatan Update</font></small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <select class="s2 form-control"  name='unitplt' id="unitplt" disabled="true" >
                                                                <option value='BLANK'>PILIH</option>
                                                                <?php
                                                                $dataSql = "SELECT r_idutama, r_ruangutama, r_namaruang
                                                                            FROM r_ruangutama
                                                                            WHERE (r_idutama IN (2,3,4,5,6,8,9))
                                                                            ORDER BY r_idutama ASC";
                                                                $dataQry = mysqli_query($koneksi, $dataSql) 
                                                                           or die(" Query" . mysqli_error($koneksi));
                                                                           while ($dataRow = mysqli_fetch_assoc($dataQry)) {
                                                                            if ($dataRow['r_idutama'] == $r['pns_unitplt']) {
                                                                                $cek = " selected";
                                                                            }else{$cek = "";}
                                                                            echo "
                                                                            <option value='$dataRow[r_idutama]' $cek>$dataRow[r_idutama] - $dataRow[r_ruangutama]</option>";
                                                                        }
                                                                $sqlData = "";
                                                                ?>
                                                            </select>
                                                            <small><font color='red'>* Pilih Unit Update </font></small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control datepicker" id='pns_tglplt' name='pns_tglplt' value='<?php echo "$r[pns_tglplt]"; ?>' readonly>
                                                            <small>Tanggal Update</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary btn-sm waves-effect text-left"><i class="fa fa-check"></i>&nbsp;&nbsp;Update Uraian Tambahan Pegawai</button>

                                                    <a href="?module=M_PEGAWAI" class="btn btn-default btn-sm flat waves-effect text-left"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp; Kembali</a>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="box"> 
                                    <div class="box-header with-border">
                                    <h6 class="box-title">Update Pegawai - Uraian Tambahan</h6>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type='text/javascript'>
$(window).load(function(){
$("#plt").change(function() {
            console.log($("#plt option:selected").val());
            if ($("#plt option:selected").val() == '2') {
                $('#jabplt').prop('disabled', 'true');
                $('#unitplt').prop('disabled', 'true');
                $('#pns_tglplt').prop('readonly', 'true');
            } else {
                $('#jabplt').prop('disabled', false);
                $('#unitplt').prop('disabled', false);
                $('#pns_tglplt').prop('readonly', false);
            }
        });
});
</script>
