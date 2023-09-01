<style>
table, th, td {
  border: 0px solid black;
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
		$nupAW = $_GET['nupAW'];
		$nupAK = $_GET['nupAK'];

		$qry=	" SELECT  a.kodebarang, a.nup, 
            a.merek, a.t_anggaran,
            a.tglperoleh, a.kodesatker,
            b.kd_brg, b.ur_sskel,
            c.kdukpb, c.nmukpb, c.nmpb,
            d.kodebarang, d.noaset, d.koderuang,
            e.koderuangan, e.namaruangan
            FROM   dbtik a
            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
            LEFT JOIN s_satker c ON c.kdukpb = a.kodesatker
            LEFT JOIN dbdistribusi d ON d.kodebarang = a.kodebarang AND d.noaset = a.nup 
            LEFT JOIN dbruangan e ON e.koderuangan = d.koderuang
            WHERE  a.kodebarang ='$kodebarang'
            AND  a.nup BETWEEN '$nupAW ' AND '$nupAK'
            ORDER BY a.kodebarang AND a.nup ASC";

		$label = mysqli_query($koneksi,$qry);

		?>

		<?php 
		

		$tempdir = "../../_qrcodeimg/";		// Nama folder untuk pemyimpanan file qrcode

		if (!file_exists($tempdir))		//jika folder belum ada, maka buat
			mkdir($tempdir);

		?>
		<table>
			<?php while ($barcode = mysqli_fetch_array($label)) {
				// berikut adalah parameter qr code
				$teks_qrcode	= "$barcode[kodesatker]*$barcode[kodebarang]*$barcode[nup]";
				$namafile		= "$barcode[nup].png";
				$quality		= "H"; // ini ada 4 pilihan yaitu L (Low), M(Medium), Q(Good), H(High)
				$ukuran			= 3; // 1 adalah yang terkecil, 10 paling besar
				$padding		= 3;

				QRCode::png($teks_qrcode, $tempdir . $namafile, $quality, $ukuran, $padding);
			?>
<tr>
	
	<td align="center" colspan="4">
	<font face="arial" size="2">
	<?php echo "$barcode[nmpb]"; ?><br>
	<?php echo "$barcode[kodesatker]"; ?>.<?php echo "$barcode[t_anggaran]"; ?>
	</font>
	</td>
</tr>

<tr>
	<td></td>
	<td>	<font face="arial" size="4">
				<strong><?php echo "$barcode[kodebarang]"; ?>&nbsp;&nbsp;&nbsp;
				<?php echo "$barcode[nup]"; ?></strong>
				</font><br>
				<font face="Roboto" size="2">
				<strong><?php echo "$barcode[ur_sskel]"; ?></strong><br>
				<?php echo "$barcode[merek]"; ?><br>
				<?php echo "$barcode[tglperoleh]"; ?> | <?php echo "$barcode[koderuang]"; ?><br>
				</font>
			</td>
	<td><img src="../../_qrcodeimg/<?php echo $namafile; ?>"></td>
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