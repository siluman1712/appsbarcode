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

	if ($module=='pemeliharaanbmn' AND $act=='simpanusul'){
	$idkondisi = $_POST['idkondisi'];
	$flag = $_POST['flag'];
	$prosedur = $_POST['prosedur'];
	$koneksi->query("INSERT INTO dbpemeliharaan (kodebarang, noaset, qty, tglperolehan, nilaiperolehan, kondisi, merek, flag, statusbmn, tgl_pemeliharaan, status_pelihara, prosedur) 
	SELECT kodebarang, noaset, qty, tglperoleh, hargaperolehan, kondisi_bmn, merek, flag, 18, tglusul, 51, prosedur
	FROM dbscanbmn WHERE prosedur='$prosedur' AND kondisi_bmn='$idkondisi' AND flag = '$flag'");

	$koneksi->query("UPDATE dbscanbmn SET flag = '2' WHERE prosedur='$prosedur' AND kondisi_bmn='$idkondisi' AND flag = '$flag'");

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
		window.location.replace('../../appsmedia.php?module=pemeliharaanbmn');
	}, 1500);
</script>
<?php
}

elseif ($module=='pemeliharaanbmn' AND $act=='simpandetail'){
	$koneksi->query(" UPDATE dbpemeliharaan 
						   	SET kodebarang = '$_POST[kd_brg]' ,
							    noaset = '$_POST[nup]' ,
							    pic = '$_POST[picnip]' ,
							    unit = '$_POST[koderuang]' ,
								permasalahan = '$_POST[permasalahanbmn]',
								rencanapelihara = '$_POST[rencanapelihara]'

						   	WHERE kodebarang = '$_POST[kd_brg]' AND noaset = '$_POST[nup]'");

	?>
	<script type="text/javascript">
		setTimeout(function() {
			swal({
				title: 'SUKSES',
				text: 'Simpan Berhasil',
				type: 'success',
				showConfirmButton: false
			});
		}, 10);
		window.setTimeout(function() {
			window.location.replace('../../appsmedia.php?module=pemeliharaanbmn');
		}, 1500);
	</script>
	<?php
	}

	elseif ($module=='pemeliharaanbmn' AND $act=='simpantinjut'){
	$koneksi->query(" UPDATE dbpemeliharaan 
						   	SET kodebarang = '$_POST[kd_brg]' ,
							    noaset = '$_POST[nup]', 
							    tindaklanjut = '$_POST[tinjut]',
							    pelaksana_tinjut = '$_POST[pelaksanatl]' ,
							    keterangan1 = '$_POST[keterangan1]'

						   	WHERE kodebarang = '$_POST[kd_brg]' AND noaset = '$_POST[nup]'");


	?>
	<script type="text/javascript">
		setTimeout(function() {
			swal({
				title: 'SUKSES',
				text: 'Simpan Berhasil',
				type: 'success',
				showConfirmButton: false
			});
		}, 10);
		window.setTimeout(function() {
			window.location.replace('../../appsmedia.php?module=pemeliharaanbmn');
		}, 1500);
	</script>
	<?php
	}

	elseif ($module=='pemeliharaanbmn' AND $act=='simpanhtl'){
	$koneksi->query(" UPDATE dbpemeliharaan 
						   	SET kodebarang = '$_POST[kd_brg]' ,
							    noaset = '$_POST[nup]', 
							    hasil_tinjut = '$_POST[hasil_tinjut]',
							    keterangan2 = '$_POST[keterangan2]' ,
							    tgl_selesaipelihara = '$_POST[tglselesai]'

						   	WHERE kodebarang = '$_POST[kd_brg]' AND noaset = '$_POST[nup]'");


	?>
	<script type="text/javascript">
		setTimeout(function() {
			swal({
				title: 'SUKSES',
				text: 'Simpan Berhasil',
				type: 'success',
				showConfirmButton: false
			});
		}, 10);
		window.setTimeout(function() {
			window.location.replace('../../appsmedia.php?module=pemeliharaanbmn');
		}, 1500);
	</script>
	<?php
	}

}
?>