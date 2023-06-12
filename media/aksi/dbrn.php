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

	if ($module == 'dbrumahnegara' and $act == 'addrumahnegara') {
		$tgl = date('Y-m-d');
		$nupAW = $_POST['nupAW'];
		$nupAK = $_POST['nupAK'];
		for ($i = $nupAW; $i <= $nupAK; $i++) {
			$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT kodebarang, nup FROM dbtik WHERE kodebarang='$_POST[kodebarang]' AND nup ='$i'"));
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
						window.location.replace('../../appsmedia.php?module=dbrumahnegara');
					}, 1500);
				</script>
			<?php

			} else {
				mysqli_query($koneksi, "INSERT INTO dbrumahnegara
								SET	kodesatker	= '$_POST[kdukpb]',
									t_anggaran	= '$_POST[t_anggaran]', 
									kodebarang	= '$_POST[kodebarang]',
									nup			= '$i',
									merek		= '$_POST[merek]',
									tglperoleh	= '$_POST[tglperoleh]',
									tglbuku	= '$_POST[tglbuku]',
									hargaperolehan = '$_POST[h_peroleh]',
									status_psp = '$_POST[status_psp]',
									nomor_psp = '$_POST[nopsp]',
									tgl_psp = '$_POST[tglpsp]', 
									status_kondisi = '$_POST[kondisi]',
									status_penggunaan = '$_POST[statusguna]',
									luas_sbsk = '$_POST[luasbg]'");

			?>
				<script type="text/javascript">
					setTimeout(function() {
						swal({
							title: 'SUKSES',
							text: 'Rumah Negara Baru Berhasil di tambahkan',
							type: 'success',
							showConfirmButton: false
						});
					}, 10);
					window.setTimeout(function() {
						window.location.replace('../../appsmedia.php?module=dbrumahnegara');
					}, 1500);
				</script>
			<?php
			}
		}
	}	

}
?>