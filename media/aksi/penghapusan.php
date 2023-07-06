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

	if ($module=='penghapusan' AND $act=='simpandata'){
		$idkondisi = $_POST['idkondisi'];
		$flag = $_POST['flag'];
		$koneksi->query("INSERT INTO dbpenghapusan (kodebarang, noaset, kondisi, merek, flag, qty) 
		SELECT kodebarang, noaset, idkondisi, merek, 2, 1 
		FROM dbubahkondisi WHERE idkondisi='$idkondisi'");

		mysqli_query($koneksi, "UPDATE dbubahkondisi SET flag = '2' WHERE idkondisi='$idkondisi'");

?>
<script type="text/javascript">
	setTimeout(function() {
		swal({
			title: 'SUKSES',
			text: 'SImpan data berhasil',
			type: 'success',
			showConfirmButton: false
		});
	}, 10);
	window.setTimeout(function() {
		window.location.replace('../../appsmedia.php?module=penghapusan');
	}, 1500);
</script>
<?php
}

elseif ($module=='penghapusan' AND $act=='simpanhapus'){
	$koneksi->query(" UPDATE dbpenghapusan 
						   	SET kodebarang = '$_POST[kd_brg]' ,
							    noaset = '$_POST[nup]' ,
								qty = '$_POST[qty]' ,
								satuan = '$_POST[satuan]' ,
								tglperolehan = '$_POST[tglperoleh]' ,
								nilaiperolehan = '$_POST[h_peroleh]' ,
								nilailimit = '$_POST[h_limit]' ,
								nilaibuku = '$_POST[n_buku]' ,
								kondisi = '$_POST[status_kondisi]' ,
								merek = '$_POST[merek]' ,
								flag = '3'
						   	WHERE kodebarang = '$_POST[kd_brg]' 
						   	AND noaset = '$_POST[nup]'");

	?>
	<script type="text/javascript">
		setTimeout(function() {
			swal({
				title: 'SUKSES',
				text: 'Update Penghapusan Berhasil',
				type: 'success',
				showConfirmButton: false
			});
		}, 10);
		window.setTimeout(function() {
			window.location.replace('../../appsmedia.php?module=penghapusan');
		}, 1500);
	</script>
	<?php
	}

}
?>