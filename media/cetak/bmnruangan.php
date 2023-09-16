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
		h1 { font-family: Bookman Old Style; 
			 font-size: 11px; 
			 font-style: italic; 
			 font-variant: normal; 
			 font-weight: 400; 
			 line-height: 15.6px; 
			 } 
			 h2 { font-family: Bookman Old Style; 
			 font-size: 11px; 
			 font-style: italic; 
			 font-variant: normal; 
			 font-weight: 400; 
			 line-height: 15.6px; 
			 }	 
		h3 { font-family: Arial;
			 font-size: 14px; 
			 font-style: normal; 
			 font-variant: normal; 
			 text-align: center;
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
		p { font-family: Arial; 
			font-size: 11px; 
			font-style: normal; 
			font-variant: normal; 
			font-weight: 400; 
		   } 
		blockquote { font-family: Bookman Old Style; 
					 font-size: 21px; 
					 font-style: normal; 
					 font-variant: normal; 
					 font-weight: 400; 
					 line-height: 30px; 
					 } 
		pre { font-family: Bookman Old Style; 
			  font-size: 13px; 
			  font-style: normal; 
			  font-variant: normal; 
			  font-weight: 400; 
			  line-height: 18.5667px; }
			  .table1 {
					font-family: arial;
					font-size: 14px;
					color: #444;
					border-collapse: collapse;
					width: 50%;
					border: 1px solid #000;
				}

			
				.table1 th{
					background: #ccc;
					color: #000;
					font-weight: normal;
					border: 1px solid #000;
				}			
				.table1 td {
					padding: 8px 20px;
					border: 0px solid #000;
				}			
				.table1 tr:hover {
					background-color: #f5f5f5;
				}
				
				.table1 tr:nth-child(even) {
					background-color: #f2f2f2;
				}
	</style>
</head>
<body>
<?php
# Baca variabel URL
$ruang = $_GET['ruang'];

$satker = mysqli_query($koneksi, 
"SELECT * FROM m_satker")
or die ("Query salah : ".mysql_error());
$head = mysqli_fetch_array($satker);

$cek2 = mysqli_query($koneksi,
"SELECT a.ruang_gabung,a.unut_id,
		a.ruang_uraian, a.ruang_pj,
		b.pns_nip, b.pns_nama,
		c.ruang
FROM m_ruang a
LEFT JOIN m_pegawai b ON b.pns_nip=a.ruang_pj
LEFT JOIN m_daftarbmn c ON c.ruang=a.ruang_gabung
WHERE c.ruang='$_GET[ruang]'
GROUP BY c.ruang ASC");
$judul = mysqli_fetch_array($cek2);


?>
<br>
<h4>
<?php echo"$head[nmpb]";?><br>
<?php echo"$head[nmpb]";?><br>
<?php echo"$head[nmukpb]";?>
</h4>
<h5>
<div class='form-group '>
<label class='col-sm-5 control-label no-padding-right'></label>
Ruang : <b><?php echo"$judul[ruang_gabung]";?></b> <br>
</div>
Uraian Ruang : <b><?php echo"$judul[ruang_uraian]";?></b> <br>
Unit KPB : <b><?php echo"$head[nmukpb]";?></b> <br>
Kode KPB : <b><b><?php echo"$head[pebin]";?>.<?php echo"$head[pbi]";?>.<?php echo"$head[wilayah]";?>.<?php echo"$head[ukpb]";?>.<?php echo"$head[upkpb]";?>.<?php echo"$head[jk]";?></b> 
</h5>
<h3>
Daftar Barang Inventaris / Ruangan<br>
</h3>
<table class="table1" width="100%" border="0" cellspacing="1" cellpadding="2" >
  <thead>
  <tr>
    <th width="10" rowspan="2" align="center" bgcolor="#CCCCCC">No</th>
    <th width="30" rowspan="2" align="center" bgcolor="#CCCCCC">NUP</th>
    <th width="230" rowspan="2" align="center" bgcolor="#CCCCCC">Nama Aset </th>
    <th height="26" colspan="3" align="center" bgcolor="#CCCCCC">Tanda Pengenal Aset </th>
    <th width="100" rowspan="2" align="center" bgcolor="#CCCCCC">Penguasaan</th>
    <th width="50" rowspan="2" align="center" bgcolor="#CCCCCC">Kondisi</th>
    <th width="110" rowspan="2" align="center" bgcolor="#CCCCCC">Ket.</th>
  </tr>
   <tr>
    <th width="250" align="center" bgcolor="#CCCCCC">Merk / Type</th>
    <th width="88" align="center" bgcolor="#CCCCCC">Kodefikasi</th>
    <th width="88" align="center" bgcolor="#CCCCCC">Thn Perolehan </th>
  </tr>
  </thead>
  <?php
		# Menampilkan List Item barang yang dibeli untuk Nomor Transaksi Terpilih
    $tampil =
    "SELECT a.satker, a.unut, a.ruang, a.kdbrg,
			a.nup,a.status_pakai,
			b.kd_brg, b.ur_sskel,
			c.STATUS_KODE, c.STATUS_PEMAKAIAN,
			d.kd_brg, d.no_aset, 
			d.merk_type, d.tgl_perlh,
			d.tercatat, d.kondisi,
			e.idcatat, e.uraian_desc,
			f.idkondisi, f.uraian
	FROM m_daftarbmn a
	LEFT JOIN m_bmnbarang b ON b.kd_brg = a.kdbrg
	LEFT JOIN statuspemakaibmn c ON c.STATUS_KODE = a.status_pakai
	LEFT JOIN m_masteru d ON d.kd_brg = a.kdbrg AND d.no_aset = a.nup
	INNER JOIN m_tercatat e ON e.idcatat=d.tercatat
	INNER JOIN m_kondisi f ON f.idkondisi=d.kondisi
	WHERE a.ruang = '$_GET[ruang]'
	ORDER BY d.tgl_Perlh ASC";
		$pdf = mysqli_query($koneksi, $tampil)  or die ("Query list barang salah : ".mysql_error());
		$nomor  = 0;
		while ($dbr = mysqli_fetch_array($pdf)) {
    $nomor++;
    $tgl_perlh = $dbr['tgl_perlh'];
    $pecah = explode("-", $tgl_perlh);
    $hasil = $pecah[0];
	?>	 <tbody>
	<tr>
	  <td align="center"><?php echo $nomor ?></td>
	  <td align="center"><?php echo $dbr['nup']; ?></td>
	  <td> <?php echo $dbr['ur_sskel']; ?></td>
	  <td><?php echo $dbr['merk_type'];?></td>
	  <td align="center"><?php echo $dbr['kdbrg'];?></td>
	  <td align="center"><?php echo $hasil; ?></td>
	  <td align="center"><?php echo $dbr['uraian_desc'];?></td>
	  <td align="center"><?php echo $dbr['uraian'];?></td>
	  <td align="center"><?php echo $dbr['STATUS_PEMAKAIAN'];?></td>
	</tr>
	 </tbody>
   <?php } ?>
  </table>
  <p align='justify'>
  Tidak dibenarkan memindahkan barang-barang yang ada pada daftar ini tanpa sepengetahuan Kepala Bagian Tata Usaha, 
  Kepala Sub. Bagian Umum dan Penanggung Jawab Ruangan ini
  </p>
  <?php
	$ttd = mysqli_query($koneksi,
	" SELECT 	a.pns_nip, a.pns_nama, a.pns_namdepan,
				a.pns_jabatan, a.pns_unitkerja,a.pns_namblkg,
				b.idjab, b.jab_nama,
				d.ruang_uraian, d.ruang_pj, 
				d.ruang_gabung, d.unut_id,
				e.id_unut, e.ur_unut
	FROM m_pegawai a
	LEFT JOIN m_jabatan b ON b.idjab=a.pns_jabatan
	LEFT JOIN m_ruang d ON d.ruang_pj=a.pns_nip 
	LEFT JOIN m_unut e ON e.id_unut=d.unut_id
	WHERE d.ruang_gabung='$_GET[ruang]'
	GROUP BY d.ruang_gabung ASC");
	$cetak		= mysqli_fetch_array($ttd);
	?>
	<?php
	$ttd2 = mysqli_query($koneksi,
	"SELECT a.kdukpb, a.nipkpb, 
			a.namakpb, a.jabatankpb,
			b.kdukpb, b.nmukpb 
	FROM m_ttd a
	LEFT JOIN m_satker b ON b.kdukpb = a.kdukpb
	GROUP BY a.nipkpb ASC");
	$cetak2		= mysqli_fetch_array($ttd2);
	?>
  <?php
		include "../../config/phpqrcode/qrlib.php";	// Ini adalah letak pemyimpanan plugin qrcode

		$tempdir = "../../_qrcodeimg/";		// Nama folder untuk pemyimpanan file qrcode
		
		if (!file_exists($tempdir))		//jika folder belum ada, maka buat
		mkdir($tempdir);
		
		// berikut adalah parameter qr code
		$teks_qrcode	="$_GET[ruang]_$cetak[pns_nip]_$cetak[pns_nama]";
		$namafile		="qrcode-1.png";
		$teks_qrcode2	="$_GET[ruang]_$cetak2[nipkpb]_$cetak2[namakpb]";
		$namafile2		="qrcode-2.png";
		$quality		="L"; // ini ada 4 pilihan yaitu L (Low), M(Medium), Q(Good), H(High)
		$ukuran			=2; // 1 adalah yang terkecil, 10 paling besar
		$padding		=2;
		
		QRCode::png($teks_qrcode, $tempdir.$namafile, $quality, $ukuran, $padding);
		QRCode::png($teks_qrcode2, $tempdir.$namafile2, $quality, $ukuran, $padding);

	?>
	<br>
	<table width="100%" height="187" class='table2'>
	<tr>
		<td width="50%" align="center">
		<h5>
		A.n Penanggung Jawab UAKPB,<br />
		<?php echo "$cetak2[nmukpb]";?><br />
		<?php echo "$cetak2[jabatankpb]";?> 
		
		</h5>
		</td>
		<td width="50%" align="center">
		<h5>
		Pekanbaru, <?php echo TanggalIndonesia(date('Y-m-d')); ?><br />
		Penanggung Jawab Ruangan<br>
		<?php echo "$cetak[jab_nama]";?>
		</h5>
		</td>
	</tr>
	<tr>
		<td align='center' height="62"><img src="../../_qrcodeimg/<?php echo $namafile2; ?>"></td>		
		<td align='center'><img src="../../_qrcodeimg/<?php echo $namafile; ?>"></td>
	</tr>
	<tr>
		<td align="center">
		<h5>
		( <?php echo $cetak2['namakpb']; ?>) <br />
		NIP. <?php echo $cetak2['nipkpb']; ?> 
		</h5>
		</td>
		<td align="center"> 
		<h5>
		(<?php echo $cetak['pns_namdepan']; ?> <?php echo $cetak['pns_nama']; ?> <?php echo $cetak['pns_namblkg']; ?> ) <br />
		NIP. <?php echo $cetak['pns_nip']; ?>
		</h5>
		</td>
	</tr>
 	</table>
	<p align='left'>
	Note : <br>
          Pada Lajur Kondisi dicatat untuk barang-barang yang kondisinya,
          Barang Baik [ BB ],
          Rusak Ringan [ RR ],
          Rusak Berat [ RB ].

          <br>Pada Lajur Ket. dicatat untuk barang-barang dengan procedure :,
          Di Pinjam,
          Inventarisasi,
          Mutasi BMN,
          Service,
          Supaya Diberi Catatan di lajur Keterangan.
	</p>




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
