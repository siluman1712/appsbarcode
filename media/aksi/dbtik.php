<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=1,initial-scale=1,user-scalable=1" />
	<link rel="stylesheet" type="text/css" href="../../bower_components/sweetalert/css/sweetalert.css" />
	<script src="../../bower_components/sweetalert/js/sweetalert.min.js"></script>
	<script src="../../bower_components/sweetalert/js/jquery.1.12.0-min.js"></script>
</head>

</html>
<?php
session_start();
include "../../config/koneksi.php";
if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])) {
	echo "<link href='../../bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
			<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {


	$module = $_GET['module'];
	$act = $_GET['act'];

	if ($module == 'pmtik' and $act == 'addbmn') {
		$tgl = date('Y-m-d');
		$nupAW = $_POST['nupAW'];
		$nupAK = $_POST['nupAK'];
		for ($i = $nupAW; $i <= $nupAK; $i++) {
			$cek = mysqli_num_rows($koneksi->query("SELECT kodebarang, nup FROM dbtik WHERE kodebarang='$_POST[kodebarang]' AND nup ='$i'"));
			if ($cek > 0) {
?>
				<script type="text/javascript">
					setTimeout(function() {
						swal({
							title: 'ERROR',
							text: 'DATA SUDAH ADA',
							type: 'error',
							showConfirmButton: false
						});
					}, 10);
					window.setTimeout(function() {
						window.location.replace('../../appsmedia.php?module=pmtik');
					}, 1500);
				</script>
			<?php

			} else {
				$koneksi->query("INSERT INTO dbtik
								SET	kodesatker	= '$_POST[kdukpb]', 
									kodebarang	= '$_POST[kodebarang]',
									nup			= '$i',
									merek		= '$_POST[merek]', 
									tglperoleh	= '$_POST[tglperoleh]',
									tglbuku	= '$_POST[tglbuku]',
									t_anggaran	= '$_POST[t_anggaran]',
									hargaperolehan = '$_POST[h_peroleh]',
									keterangan = '$_POST[keterangan]',
									status_psp = '$_POST[status_psp]',
									nomor_psp = '$_POST[nopsp]',
									tgl_psp = '$_POST[tglpsp]',
									statusbmn = '$_POST[statusbmn]',
									kondisibarang = '$_POST[kondisi]'");

			?>
				<script type="text/javascript">
					setTimeout(function() {
						swal({
							title: 'SUKSES',
							text: 'BMN Baru Berhasil di tambahkan',
							type: 'success',
							showConfirmButton: false
						});
					}, 10);
					window.setTimeout(function() {
						window.location.replace('../../appsmedia.php?module=pmtik');
					}, 1500);
				</script>
			<?php
			}
		}
	}
}
?>