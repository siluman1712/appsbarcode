<?php
session_start();
error_reporting(0);
error_reporting('E_NONE');
ob_start();
include('../../config/koneksi.php');
include('../../config/inc.library.php');
include('../../config/fungsi_indotgl.php');

if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])){
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
# Perintah untuk mendapatkan data dari tabel penjualan
echo "";
?>

<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
	<style type="text/css">
		h1 { font-family: Arial; 
			text-align: center;
			 font-size: 20px; 
			 font-variant: normal; 
			 font-weight: 400; 
			 line-height: 15.6px; 
			 } 
			 h2 { font-family: Arial; 
			 text-align: center;
			 font-size: 12px; 
			 font-variant: normal; 
			 font-weight: 400; 
			 line-height: 15.6px; 
			 }	 
		h3 { font-family: Arial;
			 font-size: 14px; 
			 font-style: normal; 
			 font-variant: normal; 
			 
			 font-weight: bold; 
			 line-height: 15.4px; 
			 } 
		h4 { font-family: Arial; 
			 font-size: 12px; 
			 text-align: left;
			 font-variant: normal; 
			 font-weight: 400; 
			 line-height: 15.6px; 
			 }
			 h5 { font-family: Arial; 
			 font-size: 11px; 
			 text-align: left;
			 font-variant: normal; 
			 font-weight: 400; 
			 line-height: 15.6px; 
			 }

			  .table1 {
					font-family: arial;
					font-size: 13px;
					color: #444;
					border-collapse: collapse;
					border: 0px solid #000;
				}

			
				.table1 th{
					background: #ccc;
					color: #000;
					font-weight: normal;
					border: 1px solid #000;
				}			
				.table1 td {
					font-family: arial;
					font-size: 12px;
					padding: 5px 3px;
					border: 1px solid #000;
				}		
				.table2 td {
					font-family: arial;
					font-size: 13px;
				}	

				.table3 {
					font-family: arial;
					font-size: 12px;
				}	

	</style>
</head>
<body>
<?php
# Baca variabel URL
$ruang = $_GET['ruang'];

$query = "SELECT  a.koderuang, a.lokins,
											b.koderuangan, b.namaruangan,
											c.kdukpb, c.nmukpb, c.nmpb,
											c.wilayah,
											d.kd_wilayah, d.ur_wilayah,
											e.kota, e.kodesatuankerja
              FROM dbdistribusi a
              LEFT JOIN dbruangan b ON b.koderuangan = a.koderuang
              LEFT JOIN s_satker c ON c.kdukpb = a.lokins
              LEFT JOIN s_wilayah d ON d.kd_wilayah = c.wilayah
              LEFT JOIN s_ttd e ON e.kodesatuankerja = a.lokins
              WHERE a.lokins = '$_SESSION[LOKINS]' AND a.koderuang = '$ruang'                 
              ORDER BY a.koderuang ASC";
$a = mysqli_query($koneksi, $query);
$judulatas = mysqli_fetch_array($a);

?>
<br>
<h1>KARTU INVENTARIS BARANG RUANGAN</h1>
<table class="table2">
	 <tr>
	 		<td>U A P B</td>
	 		<td>:</td>
	 		<td><?php echo"$judulatas[nmpb]";?></td>
	 </tr>
	 <tr>
	 		<td>U A P P B - E1</td>
	 		<td>:</td>
	 		<td><?php echo"$judulatas[nmpb]";?></td>
	 </tr>
	 <tr>
	 		<td>U A P P B - W</td>
	 		<td>:</td>
	 		<td><?php echo"$judulatas[kd_wilayah]";?>-<?php echo"$judulatas[ur_wilayah]";?> (<?php echo"$judulatas[nmukpb]";?>)</td>
	 </tr>
	 <tr>
	 		<td>NAMA UAKPB</td>
	 		<td>:</td>
	 		<td><?php echo"$judulatas[nmukpb]";?> <?php echo"$judulatas[kota]";?></td>
	 </tr>
	 <tr>
	 		<td>KODE UAKPB</td>
	 		<td>:</td>
	 		<td><?php echo"$judulatas[lokins]";?></td>
	 </tr>
	 <tr>
	 		<td>URAIAN RUANGAN</td>
	 		<td>:</td>
	 		<td><strong><?php echo"$judulatas[koderuangan]";?> | <?php echo"$judulatas[namaruangan]";?></strong></td>
	 </tr>
</table>
</h4>
<table class="table1" width="100%" >
  <thead>
  <tr>
    <th rowspan="2" align="center">KODE<br>BARANG</th>
    <th rowspan="2" >NAMA<br>BARANG</th>
    <th rowspan="2" align="center">NO<br>ASET</th>
    <th colspan="2" align="center" height="30">IDENTITAS BARANG </th>
    <th rowspan="2" align="center" width="215">PENGUASAAN</th>
    <th rowspan="2" align="center">KET.</th>
  </tr>
   <tr>
    <th align="center" height="30">MEREK</th>
    <th align="center" width="100">PEROLEHAN </th>
  </tr>
  </thead>
  <?php
		# Menampilkan List Item barang yang dibeli untuk Nomor Transaksi Terpilih
    $query = "	SELECT 	a.tgldistribusi, a.ruanggedung, 
                				a.koderuang, a.kodebarang, 
                				a.noaset, a.keterangan,
                				a.status_distribusi, a.penguasaan,
                				b.gedung, b.uraiangedung,
                				c.kd_brg, c.ur_sskel, c.satuan,
                				d.koderuangan, d.namaruangan,
                				e.kodebarang, e.nup, 
                				e.t_anggaran, e.merek, 
                				f.penguasaan, f.ur_penguasaan
        				FROM dbdistribusi a
       					LEFT JOIN dbgedung b ON b.gedung = a.ruanggedung
                LEFT JOIN b_nmbmn c ON c.kd_brg = a.kodebarang 
                LEFT JOIN dbruangan d ON d.koderuangan = a.koderuang
                LEFT JOIN dbtik e ON e.kodebarang = a.kodebarang AND e.nup = a.noaset
                LEFT JOIN status_penguasaanbmn f ON f.penguasaan = a.penguasaan
                WHERE a.status_distribusi ='80' 
                AND a.lokins = '$_SESSION[LOKINS]'
                AND a.koderuang = '$ruang'                 
                ORDER BY e.t_anggaran AND a.koderuang AND a.noaset ASC";
		$b = mysqli_query($koneksi, $query)  or die ("Query list barang salah : ".mysql_error());
		$nomor  = 0;
		while ($dbr = mysqli_fetch_array($b)) {
    $nomor++;
		?>	 
	<tbody>
	<tr>
	  <td align="center"><?php echo $dbr['kodebarang']; ?></td>
	  <td> <?php echo $dbr['ur_sskel']; ?></td>
	  <td align="center"><?php echo $dbr['noaset']; ?></td>
	  <td><?php echo $dbr['merek'];?></td>
	  <td align="center"><?php echo $dbr['t_anggaran'];?></td>
	  <td><?php echo $dbr['ur_penguasaan'];?></td>
	  <td><?php echo $dbr['keterangan'];?></td>
	</tr>
  <?php } ?>
  </tbody>
  <tr>
  	<td colspan="7">
  	Tidak dibenarkan memindahkan barang-barang yang ada pada daftar ini tanpa sepengetahuan Kepala Bagian Tata Usaha, 
 		Kepala Sub. Bagian Umum dan Penanggung Jawab Ruangan ini
  	</td>
  </tr>
  </table>

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
	WHERE a.koderuang = '$ruang'
	GROUP BY a.koderuang ASC");
	$b = mysqli_fetch_array($PIHAK2);
	?>
	<br>
	<table class="table3" width="100%">
		<tr>
			<td align="center" width="260">
			A.N UNIT KUASA PENGGUNA BARANG <br>
			<?php echo "$a[jabatan]";?><br />
			</td>

			<td width="10">
				
			</td>

			<td align="center" width="30">
			<?php echo "$a[kota]";?>, <?php echo TanggalIndonesia(date('Y-m-d')); ?><br />
			PENANGGUNG JAWAB RUANGAN,<br />
			<?php echo "$b[jabatan]";?><br />
			</td>

		</tr>
			<tr>
			<td align="center" width="260" height="50"></td>
			<td width="10"></td>
			<td align="center" width="30"></td>
		</tr>

		</tr>
			<tr>
			<td align="center" width="260">
			<?php echo "$a[nama_depan]";?>. <?php echo "$a[nama]";?>., <?php echo "$a[nama_belakang]";?><br />
			NIP. <?php echo "$a[nip]";?>
			</td>

			<td width="10">
				
			</td>

			<td align="center" width="30">
			<?php echo "$b[nama_depan]";?>. <?php echo "$b[nama]";?>., <?php echo "$b[nama_belakang]";?><br />
			NIP. <?php echo "$b[nip]";?>
			</td>
		</tr>
	</table>
</body>
</html>
<?php }?>
<?php
$out = ob_get_contents();
ob_end_clean();
include("../../MPDF/mpdf.php");
$mpdf = new mPDF('c','F4-L','');
$mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents('mpdf/mpdf.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$mpdf->WriteHTML($out);
$mpdf->Output();
?>
