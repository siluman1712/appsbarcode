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
        $aksi = "media/aksi/dbsip.php";
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
                        Surat Izin Penghunian Rumah Negara (Update Status)
                        <small>Pendaftaran Pegawai untuk penempatan Rumah Negara</small>
                      </h1>
                    </section>
                    <section class="content">
                    <a class='btn bg-black btn-md' href=<?php echo "?module=sipupdatestatus&act=update"; ?>>
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;SIP Update Status Penghunian </a>
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
                                                    <th bgcolor='#dcdcdc'> Tanggal Selesai</th>
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
                                                                  a.penghuni_selesaiperpnjang,
                                                                  a.penghuni_alasanselesai,
                                                                  b.kd_brg, b.ur_sskel, 
                                                                  c.nip, c.nama, c.nama_depan, c.nama_belakang,
                                                                  c.idgolru, c.tmt_golru, c.jabatan,
                                                                  d.GOL_GOLNAM, d.GOL_PKTNAM,
                                                                  e.idstatus_hunian, e.ur_statushunian
                                                           FROM dbsip a
                                                           LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                                                           LEFT JOIN dbpegawai c ON c.nip = a.penghuni_nip
                                                           LEFT JOIN dbgolru d ON d.GOL_GOLNAM = c.idgolru
                                                           LEFT JOIN status_penghunian e ON e.idstatus_hunian = a.penghuni_status
                                                           ORDER BY a.kodebarang AND a.noaset ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($tik)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[kd_brg]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[noaset]"; ?></td>
                                                        <td><?php echo "$r[nama_depan]"; ?><?php echo "$r[nama]"; ?>.,<?php echo "$r[nama_belakang]"; ?></td>
                                                        <td><?php echo "$r[nip]"; ?></td>
                                                        <td><?php echo "$r[penghuni_tmthuni]"; ?></td>
                                                        <td><?php echo "$r[penghuni_sksip]"; ?></td>
                                                        <td><?php echo "$r[penghuni_tglsk]"; ?></td>
                                                        <td><?php echo "$r[penghuni_selesaiperpnjang]"; ?></td>
                                                        <td>
                                                        <?php if($r['idstatus_hunian']=='90'){?>
                                                        <span class="badge bg-green">
                                                        <?php echo "$r[ur_statushunian]"; ?>
                                                        </span>
                                                        <?php } elseif($r['idstatus_hunian']=='91') { ?>
                                                        <span class="badge bg-blue">
                                                        <?php echo "$r[ur_statushunian]"; ?>
                                                        </span>
                                                        <?php } elseif($r['idstatus_hunian']=='92') { ?>
                                                        <span class="badge bg-orange">
                                                        <?php echo "$r[ur_statushunian]"; ?>
                                                        </span>
                                                        <?php } elseif($r['idstatus_hunian']=='93') { ?>
                                                        <span class="badge bg-red">
                                                        <?php echo "$r[ur_statushunian]"; ?>
                                                        </span>
                                                        <?php } elseif($r['idstatus_hunian']=='94') { ?>
                                                        <span class="badge bg-navy">
                                                        <?php echo "$r[ur_statushunian]"; ?>
                                                        </span>
                                                        <?php } elseif($r['idstatus_hunian']=='95') { ?>
                                                        <span class="badge bg-red">
                                                        <?php echo "$r[ur_statushunian]"; ?>
                                                        </span>
                                                        <?php }else{ ?>
                                                        <span class="badge bg-purple">
                                                        <?php echo "$r[ur_statushunian]"; ?>
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

                case "update":
                if ($_SESSION['LEVEL'] == 'admin' or $_SESSION['LEVEL'] == 'user') {   

                ?>
                    <section class="content-header">
                      <h1>
                        Surat Izin Penghunian Rumah Negara (UPDATE STATUS)
                        <small>Pendaftaran Pegawai untuk penempatan Rumah Negara</small>
                      </h1>
                    </section>
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
                                            $a = mysqli_query(
                                                $koneksi,
                                                "   SELECT  a.kodebarang, a.nup, a.merek, 
                                                            a.tglperoleh, a.kodesatker,
                                                            a.t_anggaran, a.hargaperolehan,
                                                            b.kd_brg, b.ur_sskel, b.satuan,
                                                            c.kdukpb, c.nmukpb,
                                                            d.penghuni_nip, d.penghuni_nilaisewa, 
                                                            d.penghuni_nama, d.penghuni_tmthuni,
                                                            d.penghuni_sksip, d.penghuni_tglsk, 
                                                            d.penghuni_lamahuni, d.kodebarang,
                                                            d.penghuni_gapok, d.no_rumah, d.gol_rumah,
                                                            d.type_rumah, d.penghuni_tmtbayarsewa,
                                                            d.penghuni_status, d.noaset, d.idsip,
                                                            d.penghuni_selesaiperpnjang, d.id_sip,
                                                            d.penghuni_alasanselesai
                                                            FROM dbrumahnegara a
                                                            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                            LEFT JOIN s_satker c ON c.kdukpb = a.kodesatker 
                                                            LEFT JOIN dbsip d ON d.kodebarang = a.kodebarang AND d.noaset = a.nup
                                                            WHERE  a.kodebarang='$_POST[kodebmn]' AND a.nup = '$_POST[noaset]'
                                                            ORDER BY d.id_sip DESC"
                                            );
                                            $r = mysqli_fetch_array($a);
                                            $cekdata = mysqli_num_rows($a);
                                            if (isset($_POST['kodebmn']) && $cekdata == 0) {
                                                echo "
                                                                <div class='alert bg-blue' role='alert'>
                                                                <h4><i class='ik ik-alert-octagon'></i> Pemberitahuan!</h4>
                                                                Data Tidak Ditemukan!
                                                                </div>";
                                            } else {
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
               
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                            <form role='form' method='post' class='form-horizontal' action='<?php echo "$aksi?module=sipupdatestatus&act=updatesip"; ?>' enctype='multipart/form-data'>

                                                <div class="form-group">
                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='kodesatker' value='<?php echo "$r[kodesatker]"; ?>' readonly>
                                                    <small>Kode Satuan kerja</small>
                                                    </div>

                                                    <div class="col-sm-5">
                                                    <input type="text" class="form-control" name='namasatker' value='<?php echo "$r[nmukpb]"; ?>' readonly>
                                                    <small>Nama Satuan kerja</small>
                                                    </div>

                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='nourut' value='<?php echo "$r[idsip]"; ?>' readonly>
                                                    <small>No Urut</small>
                                                    </div>

                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='no_rumah' value='<?php echo "$r[no_rumah]"; ?>' readonly>
                                                    <small>No Rumah</small>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='kd_brg' id="kd_brg" value='<?php echo "$r[kd_brg]"; ?>' readonly>
                                                    <small>kode bmn</small>
                                                    </div>

                                                
                                                    <div class="col-sm-4">
                                                    <input type="text" class="form-control" name='nm_brg' id="nm_brg" value='<?php echo "$r[ur_sskel]"; ?>' readonly>
                                                    <small>Uraian bmn</small>
                                                    </div>

                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='satuan' id="satuan" value='<?php echo "$r[satuan]"; ?>' readonly>
                                                    <small>satuan bmn</small>
                                                    </div>

                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='nup' value='<?php echo "$r[nup]"; ?>' readonly>
                                                    <small>No Aset</small>
                                                    </div>

                                                    <div class="col-sm-4">
                                                    <input type="text" class="form-control" name='merek' value='<?php echo "$r[merek]"; ?>' readonly>
                                                    <small>Jenis BMN</small>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='t_anggaran' value='<?php echo "$r[t_anggaran]"; ?>' readonly>
                                                    <small>Tahun Anggaran</small>
                                                    </div>

                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='periode' value='<?php echo date(m, strtotime($r[tglperoleh])); ?>' readonly>
                                                    <small>Periode</small>
                                                    </div>

                                                    <div class="col-sm-1">
                                                    <input type="text" class="form-control" name='tglperoleh' value='<?php echo "$r[tglperoleh]"; ?>' readonly>
                                                    <small>Perolehan</small>
                                                    </div>

                                                    <div class="col-sm-2">
                                                    <input type="text" class="form-control" name='h_peroleh' value='<?php echo "$r[hargaperolehan]"; ?>' readonly>
                                                    <small>Harga Perolehan</small>
                                                    </div>

                                                    <div class="col-sm-2">
                                                    <input class='form-control' maxlength="18" type="text" name="NIP1" id="NIP1" placeholder="Masukkan NIP" value='<?php echo "$r[penghuni_nip]" ?>'>
                                                    <small>NIP Penghuni</small>
                                                    </div>

                                                    <div class="col-sm-2">
                                                    <input class='form-control' maxlength="50" type="text" name="NAMA1" id="NAMA1" placeholder="Nama Pegawai" value='<?php echo "$r[penghuni_nama]" ?>'>
                                                    <small>Nama Penghuni</small>
                                                    </div>

                                                    <div class="col-sm-2">
                                                    <input maxlength="7" type="text" class="form-control" name='nilaigapok' value='<?php echo "$r[penghuni_gapok]"; ?>'>
                                                    <small>Gaji Pokok Penghuni</small>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-4">
                                                    <label >Golongan Rumah Negara</label>
                                                        <select class="form-control" name='golrn' id='gol'>
                                                            <option value='BLANK'>PILIH</option>
                                                            <?php
                                                            $dataSql = "SELECT * FROM dbgolrn 
                                                                        ORDER BY idgolrn ASC";
                                                            $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                            while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                            if ($dataRow['idgolrn'] == $r['gol_rumah']) {
                                                            $cek = " selected";
                                                            } else { $cek = ""; }
                                                            echo "
                                                            <option value='$dataRow[idgolrn]' $cek>[$dataRow[idgolrn]] $dataRow[ur_golrn] - $dataRow[keterangan]</option>";
                                                            }
                                                            $sqlData = "";
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-4">
                                                    <label>Type Rumah Negara</label>
                                                        <select class="form-control" name='typern' id='typern'>
                                                        <option value='BLANK'>PILIH</option>
                                                        <?php
                                                        $dataSql = "SELECT * FROM dbtipern 
                                                                    ORDER BY idtipern ASC";
                                                        $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                        if ($dataRow['tipern'] == $r['type_rumah']) {
                                                        $cek = " selected";
                                                        } else { $cek = ""; }
                                                        echo "
                                                        <option value='$dataRow[tipern]' $cek>[$dataRow[tipern]] $dataRow[ur_tipern] - $dataRow[keterangan] [$dataRow[luas]]</option>";
                                                        }
                                                        $sqlData = "";
                                                        ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                    <label>TMT Sewa</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name='tmtsewa' value='<?php echo "$r[penghuni_tmtbayarsewa]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal Penghunian">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>

                                                    <div class="col-sm-1">
                                                    <label >Lama Huni</label>
                                                    <input maxlength="3" type="text" class="form-control" name='lamahuni' value='<?php echo "$r[penghuni_lamahuni]"; ?>'>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">


                                                    <div class="col-sm-2">
                                                    <label >Nilai Sewa</label>
                                                    <input maxlength="7" type="text" class="form-control" name='nilaisewa' value='<?php echo "$r[penghuni_nilaisewa]"; ?>'>
                                                    </div>

                                                <div class="col-md-2">
                                                    <label>TMT Huni</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name='tmthuni' value='<?php echo "$r[penghuni_tmthuni]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal Penghunian">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-5">
                                                    <label >SK SIP</label>
                                                    <input type="text" class="form-control" name='sksip' value='<?php echo "$r[penghuni_sksip]"; ?>'>
                                                    </div>

                                                <div class="col-md-2">
                                                    <label>TMT SK SIP</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name='tmtsksip' value='<?php echo "$r[penghuni_tglsk]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal SK SIP">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                                <div class="form-group">
                                                    <div class="col-sm-3">
                                                    <label >Status Huni</label>
                                                    <select class="form-control s2" name='statushuni' id="statushuni">
                                                        <option value='BLANK'>PILIH</option>
                                                        <?php
                                                        $dataSql = "SELECT * FROM status_penghunian 
                                                                    ORDER BY idstatus_hunian ASC";
                                                        $dataQry = mysqli_query($koneksi, $dataSql) or die("Gagal Query" . mysqli_error($koneksi));
                                                        while ($dataRow = mysqli_fetch_array($dataQry)) {
                                                        if ($dataRow['idstatus_hunian'] == $r['penghuni_status']) {
                                                        $cek = " selected";
                                                        } else { $cek = ""; }
                                                        echo "
                                                        <option value='$dataRow[idstatus_hunian]' $cek>$dataRow[idstatus_hunian] - $dataRow[ur_statushunian]</option>";
                                                        }
                                                        $sqlData = "";
                                                        ?>
                                                    </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-5">
                                                    <label >Alasan Selesai / Perpanjang SIP</label>
                                                    <input type="text" class="form-control" name='alasanselesai' value='<?php echo "$r[penghuni_alasanselesai]"; ?>'>
                                                    </div>

                                                <div class="col-md-2">
                                                    <label>TMT Selesai / Perpanjang</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name='tmtselesaipanjang' value='<?php echo "$r[penghuni_selesaiperpnjang]"; ?>' data-toggle="tooltip" data-placement="top" title="Tanggal SK SIP">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                                </div>

                                                <div class="box-footer">
                                                <fieldset>
                                                <button type=submit Data class='btn btn-primary btn-md flat'>
                                                <i class='fa fa-check'></i>&nbsp;&nbsp;&nbsp; Simpan </button>

                                                <button type=reset Data class='btn btn-danger btn-md flat'>
                                                <i class='fa fa-retweet'></i>&nbsp;&nbsp;&nbsp; Reset </button>
                                                </fieldset>
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