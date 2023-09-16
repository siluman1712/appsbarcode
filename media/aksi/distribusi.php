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

	if ($module == 'distribusi' and $act == 'distribusibmn') {
		$nupAW = $_POST['nupAW'];
		$nupAK = $_POST['nupAK'];
		for ($i = $nupAW; $i <= $nupAK; $i++) {

				$koneksi->query("INSERT INTO dbdistribusi
								SET	tgldistribusi	= '$_POST[tgldist]', 
									ruanggedung		= '$_POST[gedung]',
									koderuang		= '$_POST[koderuang]',
									kodebarang		= '$_POST[kodebarang]',
									no_bast			= '$_POST[nobast]',
									t_anggaran		= '$_POST[tanggaran]',
									lokins			= '$_POST[LOKINS]',
									penguasaan		= '$_POST[penguasaan]',
									status_distribusi = '80',
									noaset			= '$i',
									keterangan 		= '$_POST[keterangan]'");

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
						window.location.replace('../../appsmedia.php?module=distribusi');
					}, 1500);
				</script>
			<?php
		}
	}

	elseif ($module == 'distribusi' and $act == 'picsave') {
		$nupAWL = $_POST['nupAWL'];
		$nupAKH = $_POST['nupAKH'];
		for ($i = $nupAWL; $i <= $nupAKH; $i++) {
			$cek = mysqli_num_rows($koneksi->query("SELECT kodebarang, noaset FROM dbpicbmn WHERE kodebarang='$_POST[kodebarang]' AND noaset ='$i'"));
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
						window.location.replace('../../appsmedia.php?module=distribusi');
					}, 1500);
				</script>
			<?php

			} else {
				$koneksi->query("INSERT INTO dbpicbmn
								SET	kodebarang	= '$_POST[kodebarang]',
									noaset		= '$i',
									picnip		= '$_POST[NIP1]',
									lokins		= '$_POST[LOKINS]',
									picnama		= '$_POST[NAMA1]'");

			?>
				<script type="text/javascript">
					setTimeout(function() {
						swal({
							title: 'SUKSES',
							text: 'PIC BMN Berhasil di tambahkan',
							type: 'success',
							showConfirmButton: false
						});
					}, 10);
					window.setTimeout(function() {
						window.location.replace('../../appsmedia.php?module=distribusi');
					}, 1500);
				</script>
			<?php
			}
		}
	}
}
?>