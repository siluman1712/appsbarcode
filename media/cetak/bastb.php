
<?php
session_start();
error_reporting(0);
error_reporting('E_NONE');
ob_start();
include('../../config/koneksi.php');
include('../../config/inc.library.php');
include('../../config/fungsi_indotgl.php');
if (empty($_SESSION['UNAME']) AND empty($_SESSION['PASSWORD'])){
	echo "<link href='../../asset/bootstrap/css/bootstrap.css' rel='stylesheet' type='text/css'>

                        <div class='alert alert-info'>
                        <br>
						<h2><i class='icon fa fa-info'></i> Pemberitahuan!</h2>
                        <b> MAAF BERITA ACARA TIDAK BISA DITAMPILKAN !,</b> <bR>
                        Untuk menampilkan BERITA ACARA yang mau dicetak, Anda harus login terlebih dahulu <br>
                        <br>
											  </div>";
}
else{
$html = '
<html>
<head>
</head>
<body>';


# Baca variabel URL
# Perintah untuk mendapatkan data dari tabel penjualan
echo "";
?>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<style type="text/css">
		body {
			font-family: "Arial";
			font-size: 13px;
		}
		
 
.table1, th {
	  font-family: Arial;
    font-size: 11px;
    border: 1px solid #000;
    padding: 2px 3px;
}
	</style>
</head>
<body>
<?php
$koderuangan = $_GET['koderuangan'];
$tgldistribusi = $_GET['tgldistribusi'];
?>
<?php
	$nobast = mysqli_query($koneksi,
	" SELECT 	no_bast, koderuang, tgldistribusi 
		FROM dbdistribusi
		WHERE koderuang = '$koderuangan' AND tgldistribusi = '$tgldistribusi'
	GROUP BY no_bast ASC");
	$x = mysqli_fetch_array($nobast);
?>
<table width="100%" align="center" border='0'>
  <tr>
	<td colspan="3" align="center">
	<br><br>
	<img src="../../dist/img/headLogo.png" width="75px" height="75px" align='center' />
	<h3>BADAN KEPEGAWAIAN NEGARA<BR>KANTOR REGIONAL XII</h3>
	<h5>Jalan Hangtuah Ujung Nomor 148, Sialang Sakti, Tenayan Raya, Pekanbaru, Riau 28285<br>
		Telepon (0761) 7870006; Faksimile (0761) 46104<br>
		Laman: https://pekanbaru.bkn.go.id;|Pos-el: kanreg12.pekanbaru@bkn.go.id
	</h5>
	<hr>
	<p>Berita Acara Serah Terima Barang <br>
	No. <?php echo $x['no_bast']; ?>/BASTB-BMN/KR.XII/<?php echo date('m');?> - <?php echo date('Y');?></p>
	</td>
  </tr> 
</table>

<p class="" align="justify">
Pada hari ini
<strong><?php echo tglIndonesia(date('D'));?></strong>
tanggal <strong><?php echo terbilang (tglIndonesia(date('d')));?></strong>
bulan <strong><?php echo tglIndonesia(date('F'));?></strong>
Tahun <strong><?php echo terbilang (tglIndonesia(date('Y')));?></strong>
kami yang bertanda tangan dibawah ini :
<br>
<?php
	$PIHAK1 = mysqli_query($koneksi,
	" SELECT 	a.kota, a.idttd, a.tgldibuat,
						a.tglsetuju, a.nip_bmn, 
						b.nip, b.nama_depan, b.nama_belakang, 
						b.idgolru, b.jabatan, b.nama,
						c.GOL_KODGOL, c.GOL_GOLNAM, c.GOL_PKTNAM
	FROM s_ttd a
	LEFT JOIN dbpegawai b ON b.nip=a.nip_bmn
	LEFT JOIN dbgolru c ON c.GOL_KODGOL=b.idgolru
	GROUP BY a.idttd ASC");
	$a = mysqli_fetch_array($PIHAK1);

	$satker = mysqli_query($koneksi, "SELECT * FROM s_satker ORDER BY id ASC");
  $s		= mysqli_fetch_array($satker);

	$PIHAK2 = mysqli_query($koneksi,
	" SELECT 	a.koderuang, b.nippenanggungjawab,
						b.koderuangan, b.namaruangan,
						c.nip, c.nama_depan, c.nama_belakang, 
						c.idgolru, c.jabatan, c.nama,
						d.GOL_KODGOL, d.GOL_GOLNAM, d.GOL_PKTNAM
	FROM dbdistribusi a
	LEFT JOIN dbruangan b ON b.koderuangan=a.koderuang
	LEFT JOIN dbpegawai c ON c.nip=b.nippenanggungjawab
	LEFT JOIN dbgolru d ON d.GOL_KODGOL = c.idgolru
	WHERE a.koderuang = '$koderuangan'
	GROUP BY a.koderuang ASC");
	$b = mysqli_fetch_array($PIHAK2);
?>
<table border='0' >
  <tr>
      <td width="10px">&nbsp;1. </td>
      <td width="100px">&nbsp;Nama</td>
      <td width="15px">:</td>
      <td><?php echo $a['nama']; ?>. <?php echo $a['nama_belakang']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;N I P</td>
      <td width="15px">:</td>
      <td><?php echo $a['nip_bmn']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;Pangkat</td>
      <td width="15px">:</td>
      <td><?php echo $a['GOL_PKTNAM']; ?> , <?php echo $a['GOL_GOLNAM']; ?></td>
  </tr>
    <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;Jabatan</td>
      <td width="15px">:</td>
      <td><?php echo $a['jabatan']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;Unit Kerja</td>
      <td width="15px">:</td>
      <td><?php echo $s['nmukpb']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;</td>
      <td width="15px"></td>
      <td>Dalam berita acara ini disebut <b>PIHAK PERTAMA</td>
  </tr>
  <br><br>
  <tr>
      <td width="10px">&nbsp;2. </td>
      <td width="100px">&nbsp;Nama</td>
      <td width="15px">:</td>
      <td><?php echo $b['nama']; ?>. <?php echo $b['nama_belakang']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;N I P</td>
      <td width="15px">:</td>
      <td><?php echo $b['nip']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;Pangkat</td>
      <td width="15px">:</td>
      <td><?php echo $b['GOL_PKTNAM']; ?> , <?php echo $b['GOL_GOLNAM']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;Jabatan</td>
      <td width="15px">:</td>
      <td><?php echo $b['jabatan']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;Unit Kerja</td>
      <td width="15px">:</td>
      <td><?php echo $s['nmukpb']; ?></td>
  </tr>
  <tr>
      <td width="10px">&nbsp;</td>
      <td width="100px">&nbsp;</td>
      <td width="15px"></td>
      <td>Dalam berita acara ini disebut <b>PIHAK KEDUA</td>
  </tr>
</table>
<p class="" align="justify">
  <b>PIHAK PERTAMA</b> telah menyerahkan barang-barang kepada <b>PIHAK KEDUA</b> dan <b>PIHAK KEDUA</b> telah menerima barang-barang dari <b>PIHAK PERTAMA</b> dengan rincian sbb:
</p>
	<table width="700" class="table1" align="center" border='0'>
		<thead>
			<tr>
				<th width='150' >(KD - NAMA BARANG)</th>
				<th >NOASET</th>
				<th >SAT</th>
				<th >QTY</th>
				<th >TA</th>
				<th width='200px' >MEREK_TYPE</th>
				<th width='65px' >NILAI PEROLEHAN</th>
				<th width='65px' >KETERANGAN</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$query = "SELECT a.tgldistribusi, COUNT(a.kodebarang) AS QTY, 
										 MAX(a.noaset) AS MAXnoaset, 
										 MIN(a.noaset) AS MINnoaset,
										 a.koderuang, a.keterangan,
										 b.kodebarang, b.nup, b.merek,
										 b.t_anggaran, b.hargaperolehan,
										 c.satuan, c.kd_brg, c.ur_sskel,
										 d.koderuangan, d.namaruangan
							FROM dbdistribusi a
							LEFT JOIN dbtik b ON b.kodebarang = a.kodebarang AND b.nup=a.noaset 
							LEFT JOIN b_nmbmn c ON c.kd_brg = a.kodebarang
							LEFT JOIN dbruangan d ON d.koderuangan = a.koderuang
							WHERE a.koderuang='$koderuangan' AND a.tgldistribusi ='$tgldistribusi'
							ORDER BY a.koderuang ASC";
		$cek = mysqli_query($koneksi,$query);
		$no = 1;
    while ($r = mysqli_fetch_array($cek)){
		$no++;
		?>
			<tr>
				<td><?php echo $r['kd_brg']; ?> <?php echo $r['ur_sskel']; ?></td>
				<td align="center"><?php echo $r['MINnoaset']; ?> - <?php echo $r['MAXnoaset']; ?></td>
				<td align="center"><?php echo $r['satuan']; ?></td>
				<td align="center"><?php echo $r['QTY']; ?></td>
				<td align="center"><?php echo $r['t_anggaran']; ?></td>
				<td><?php echo $r['merek']; ?></td>
				<td align="center"><?php echo rupiah($r['hargaperolehan']); ?></td>
				<td><?php echo $r['koderuang']; ?></td>
			</tr>
			</tfoot>
			<?php }?>
	</table>
<p align="justify">
Barang-barang tersebut di atas telah diterima dalam keadaan <strong>baik</strong> dan cukup jumlahnya.<br>
Demikian Berita Acara Serah Terima Barang ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
</p>


<table width='100%' border='0' align="center">
      <tr>
        <td width='150' align="center"><BR>PIHAK KEDUA<br><?php echo $b['jabatan']; ?></td>
        <td width='50' align="center"></td>
        <td width='150' align="center">Pekanbaru, <?php echo TanggalIndonesia($a[tgldibuat]); ?> <br />
          PIHAK PERTAMA<br><?php echo $a['jabatan']; ?></td>
      </tr>
      <tr>
        <td height='60' align='center'></td>
        <td></td>
        <td align='center'></td>
      </tr>
      <tr>
        <td align="center"><?php echo $b['nama']; ?>. <?php echo $b['nama_belakang']; ?> 
				<br>NIP. <?php echo $b['nip']; ?>
				</td>
        <td align="center"></td>
        <td align="center"><?php echo $a['nama']; ?>. <?php echo $a['nama_belakang']; ?>
        <br>NIP. <?php echo $a['nip']; ?>
        </td>
      </tr>

      <tr>
        <td align="center">&nbsp;&nbsp;&nbsp;</td>
        <td align="center">&nbsp;&nbsp;&nbsp;</td>
        <td align="center">&nbsp;&nbsp;&nbsp;</td>
      </tr>

</table>
<small>#[<?php echo $b['koderuang']; ?>] <?php echo $b['namaruangan']; ?></small>
</body>
</html>
<?php }?>
<?php
$out = ob_get_contents();
ob_end_clean();
include("../../MPDF/mpdf.php");
$mpdf = new mPDF('c','A4-P','');
$mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents('mpdf/mpdf.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$mpdf->WriteHTML($out);
$mpdf->Output();
?>