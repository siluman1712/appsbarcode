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

	if ($module == 'scanbmn' and $act == 'addscan') {
		$tgl = date('Y-m-d');
				$koneksi->query("INSERT INTO dbscanbmn
								SET	kodesatuankerja	= '$_POST[kodesatker]', 
									kodebarang	= '$_POST[kd_brg]',
									noaset			= '$_POST[nup]',
									qty = '1',
									merek		= '$_POST[merek]', 
									tglperoleh	= '$_POST[tglperoleh]',
									prosedur = '$_POST[prosedur]',
									t_anggaran	= '$_POST[t_anggaran]',
									periode = '$_POST[periode]',
									hargaperolehan = '$_POST[h_peroleh]',
									kondisi_bmn = '$_POST[kondisibmn]',
									koderuangan = '$_POST[koderuang]',
									flag = '1'");

			?>
				<script type="text/javascript">
					setTimeout(function() {
						swal({
							title: 'SUKSES',
							text: 'BMN berhasil di scan',
							type: 'success',
							showConfirmButton: false
						});
					}, 10);
					window.setTimeout(function() {
						window.location.replace('../../appsmedia.php?module=scanbmn');
					}, 1500);
				</script>
			<?php
			}
	
}
?>