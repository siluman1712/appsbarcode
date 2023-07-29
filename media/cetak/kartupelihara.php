<style>
table,th {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<?php
session_start();
ob_start();
include('../../config/phpqrcode/qrlib.php');	// Ini adalah letak pemyimpanan plugin qrcode
include('../../config/koneksi.php');
include('../../config/inc.library.php');
include('../../config/fungsi_indotgl.php');
include('../../includes/css.php');

if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
	echo "

<section class='content'>

      <div class='error-page'>
        <h2 class='headline text-red'>500</h2>

        <div class='error-content'>
          <h3><i class='fa fa-warning text-red'></i> Oops! Something went wrong.</h3>

          <p>
            We will work on fixing that right away.
            Meanwhile, you may <a href='localhost/appslubmn'>return to dashboard</a> Login Dulu YA.
          </p>
        </div>
      </div>
      <!-- /.error-page -->

    </section>";
} else {
	$html = '
<html>
<head>
</head>
<body>';
	echo "";
?>

	<html>

	<head>
		<style type="text/css">

			h3 {
				text-align: right;
			}


		</style>
	</head>

	<body>
		<?php
		# Baca variabel URL
		$kodebarang = $_GET['kodebarang'];
		$noaset = $_GET['noaset'];

		$koneksi->query("UPDATE dbpemeliharaan SET flag = '2', status_pelihara = '52' WHERE kodebarang = '$kodebarang' AND noaset = '$noaset'");
		$koneksi->query("UPDATE dbtik SET statusbmn = '19', kondisibarang = '31', keterangan = 'Update Berhasil'  WHERE kodebarang = '$kodebarang' AND nup = '$noaset'");

    $tgl = $koneksi->query("SELECT * FROM s_settgl ORDER BY idtgl ASC");
    $rs  = mysqli_fetch_array($tgl);

		$qry=	" SELECT a.kodebarang, a.noaset, a.merek, a.prosedur,
                                    a.tglperolehan, a.tgl_pemeliharaan, 
                                    a.nilaiperolehan, a.permasalahan,   
                                    a.qty, a.kondisi, a.flag, a.tgl_selesaipelihara,
                                    a.pelaksana_tinjut, a.hasil_tinjut, a.tindaklanjut,
                                    a.rencanapelihara, a.keterangan1,
                                    b.kd_brg, b.ur_sskel, b.satuan,
                                    c.status_kondisi, c.uraian_kondisi,
                                    d.status_trx, d.uraian_trx,
                                    e.kodebarang, e.noaset, e.koderuang,
                                    f.koderuangan, f.namaruangan,
                                    g.kodebarang, g.noaset, g.picnip, g.picnama,
                                    h.kodebarang, h.nup, h.kodesatker,
                                    i.idptinjut, i.uraian_ptinjut,
                                    j.idhasil, j.uraian_hasiltl
                            FROM dbpemeliharaan a
                            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                            LEFT JOIN kondisi_bmn c ON c.status_kondisi = a.kondisi
                            LEFT JOIN status_transaksi d ON d.status_trx = a.prosedur
                            LEFT JOIN dbdistribusi e ON e.kodebarang = a.kodebarang AND e.noaset = a.noaset
                            LEFT JOIN dbruangan f ON f.koderuangan = e.koderuang
                            LEFT JOIN dbpicbmn g ON g.kodebarang = a.kodebarang AND g.noaset = a.noaset
                            LEFT JOIN dbtik h ON h.kodebarang = a.kodebarang AND h.nup = a.noaset
                            LEFT JOIN pelaksana_tinjut i ON i.idptinjut = a.pelaksana_tinjut
														LEFT JOIN hasil_tinjut j ON j.idhasil = a.hasil_tinjut
             WHERE a.kodebarang = '$kodebarang' AND a.noaset = '$noaset' 
             ORDER BY a.kodebarang ASC";

		$label = $koneksi->query($qry);

		?>

		<?php 
		

		$tempdir = "../../_qrcodeimg/";		// Nama folder untuk pemyimpanan file qrcode

		if (!file_exists($tempdir))		//jika folder belum ada, maka buat
			mkdir($tempdir);

		?>
					<?php while ($barcode = mysqli_fetch_array($label)) {
				// berikut adalah parameter qr code
				$teks_qrcode	= "$barcode[kodesatker]*$barcode[kodebarang]*$barcode[noaset]";
				$namafile		= "$barcode[noaset].png";
				$quality		= "H"; // ini ada 4 pilihan yaitu L (Low), M(Medium), Q(Good), H(High)
				$ukuran			= 2; // 1 adalah yang terkecil, 10 paling besar
				$padding		= 2;

				QRCode::png($teks_qrcode, $tempdir . $namafile, $quality, $ukuran, $padding);
			?>

<table width="350">
<tr>
	<td>
		
	</td>
	<td colspan="4" align="center">
	<img src="../../dist/img/headLogo.png" width="65px" height="65px" align='left' />
	<font face="arial" size="2">
	<strong>
		KARTU PEMELIHARAN <br>PERALATAN DAN MESIN<br>
	KANTOR REGIONAL XII BKN<br>
	TAHUN <?php echo "$rs[s_thnang]"; ?>
	</strong>
	</font>
	<hr>
	</td>
</tr>
<br>
<tr>
	<td></td>
	<td>
	<font face="arial" size="2">
	Uraian Barang Milik Negara
	<hr>
	<img src="../../_qrcodeimg/<?php echo $namafile; ?>" align="right">
	<p>
	Kode : <strong><?php echo "$barcode[kodebarang]"; ?></strong><br>
	Noaset : <strong><?php echo "$barcode[noaset]"; ?></strong><br>
  Nama BMN : <strong><?php echo "$barcode[ur_sskel]"; ?></strong><br>
  Merek : <strong><?php echo "$barcode[merek]"; ?></strong><br>
  <hr>
  Database
  <hr>
  D B R : <br> <strong><?php echo "$barcode[namaruangan]"; ?></strong><br>
  Kondisi : <strong><?php echo "$barcode[uraian_kondisi]"; ?></strong><br>
  PIC : <strong>[<?php echo "$barcode[picnip]"; ?>]&nbsp;&nbsp;<?php echo "$barcode[picnama]"; ?></strong><br>
  Prosedur : <strong><?php echo "$barcode[uraian_trx]"; ?></strong><br>
  Usul : <strong><?php echo tgl_indo($barcode['tgl_pemeliharaan']); ?></strong><br>
  Pemroses : <br><strong><?php echo "$barcode[uraian_ptinjut]"; ?> <br> <?php echo "$barcode[keterangan1]"; ?></strong> <br>
  <hr>
  Tindak Lanjut Pemeliharaan
  <hr>
  Permasalahan : <br> <strong><?php echo "$barcode[permasalahan]"; ?></strong><br>
  Hasil Tinjut : <br> <strong><?php echo "$barcode[uraian_hasiltl]"; ?><br><?php echo "$barcode[tindaklanjut]"; ?></strong><br>
  Selesai : <strong><?php echo tgl_indo($barcode['tgl_selesaipelihara']); ?></strong>
  <hr>
  </p>
	</font>
	<font face="Roboto" size="2" align='right'>				
	<p align="right"><?php echo date("Y-d-m H:i:s");?></p>
	</font></td>
	<td></td>
</tr>

<tr>
	<td></td>
	<td></td>
	<td height="14"></td>
</tr>

<?php }} ?>
		</table>

	</body>

	</html>
<?php
//$out = ob_get_contents();
//ob_end_clean();
//include("../../MPDF/mpdf.php");
//$mpdf = new mPDF('c','A4-P','');
//$mpdf = new mPDF('utf-8',array(75,35));
//$mpdf->SetDisplayMode('fullpage');
//$stylesheet = file_get_contents('mpdf/mpdf.css');
//$mpdf->WriteHTML($stylesheet,1);
//$mpdf->WriteHTML($html);
//$mpdf->WriteHTML($out);
//$mpdf->Output();
?>