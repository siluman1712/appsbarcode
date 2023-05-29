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

				mysqli_query($koneksi, "INSERT INTO dbdistribusi
								SET	tgldistribusi	= '$_POST[tgldist]', 
									ruanggedung		= '$_POST[gedung]',
									koderuang		= '$_POST[koderuang]',
									kodebarang		= '$_POST[kodebarang]',
									no_bast			= '$_POST[nobast]',
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
			$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT kodebarang, noaset FROM dbpicbmn WHERE kodebarang='$_POST[kodebarang]' AND noaset ='$i'"));
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
				mysqli_query($koneksi, "INSERT INTO dbpicbmn
								SET	kodebarang	= '$_POST[kodebarang]',
									noaset		= '$i',
									picnip		= '$_POST[NIP1]',
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


	elseif ($module=='sedia_pengajuan' AND $act=='kirimPermohonan'){ 
	$n=$_POST['n'];
	for ($i=0;$i<=$n-1;$i++)
	{if(isset($_POST['registrasi'.$i]))
		{$registrasi=$_POST['registrasi'.$i];
		mysqli_query($koneksi,
		"UPDATE c_sediakeluarunit
		SET		prosedur	= '3',
				flag_kirim	= 'Y'
		WHERE registrasi		= '$registrasi'");

		mysqli_query($koneksi,
		"UPDATE c_unitsediaminta
		SET		prosedur	= '3',
				qtypesanan  = '$n'
		WHERE 	registrasi	= '$registrasi'");

	//header('location:../../appsmedia.php?module='.$module);
	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'Berhasil di Kirim! Pengajuan Unit akan segera di Proses',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=sedia_pengajuan');
			}, 1500);
		</script>
	<?php
	}}}

	elseif ($module=='sedia_pengajuan' AND $act=='hapus'){
	mysqli_query($koneksi, "DELETE FROM c_sediakeluarunit 
							WHERE kd_brg = '$_GET[kd_brg]' 
							AND registrasi = '$_GET[registrasi]' ");

	header('location:../../appsmedia.php?module='.$module.'&act='.upload.'&registrasi='.$_GET[registrasi].'');
	}

	elseif ($module=='c_aksiProsedia' AND $act=='cekBarang'){
	mysqli_query($koneksi," UPDATE c_sediakeluarunit 
						   	SET prosedur = '61' 
						   	WHERE registrasi = '$_GET[registrasi]' 
						   	AND kd_brg = '$_GET[kd_brg]'");

	//mysqli_query($koneksi,"	UPDATE c_unitsediaminta 
	//						SET prosedur = IF(prosedur='6','61', prosedur) 
	//						WHERE registrasi = '$_GET[registrasi]'");

	header('location:../../appsmedia.php?module='.$module);
	}

	elseif ($module=='c_aksiProsedia' AND $act=='tlAdmin'){
	mysqli_query($koneksi," UPDATE c_sediakeluarunit 
						   	SET prosedur = '61' 
						   	WHERE registrasi = '$_GET[registrasi]' 
						   	AND kd_brg = '$_GET[kd_brg]'");

	mysqli_query($koneksi,"	UPDATE c_unitsediaminta 
							SET prosedur = IF(prosedur='71','61', prosedur) 
							WHERE registrasi = '$_GET[registrasi]'");

	header('location:../../appsmedia.php?module='.$module);
	}

	elseif ($module=='c_aksiProsedia' AND $act=='uncekBarang'){
	mysqli_query($koneksi,"	UPDATE c_sediakeluarunit 
						   	SET prosedur = '63', 
						   	   	alasantidaksesuai ='$_POST[alasantidaksesuai]', 
						   	   	qtytidaksesuai = '$_POST[qtytidaksesuai]' 
						   	
						   	WHERE registrasi = '$_POST[registrasi]' 
						   	AND kd_brg = '$_POST[kd_brg]'");

	mysqli_query($koneksi,"	UPDATE c_unitsediaminta 
							SET prosedur = IF(prosedur='6','71', IF(prosedur='61','71', IF(prosedur='63','71', IF(prosedur='71','71','prosedur')))) 
							WHERE registrasi = '$_POST[registrasi]'");

	header('location:../../appsmedia.php?module='.$module.'&act='.terimaBarang.'&registrasi='.$_POST[registrasi].'');
}

	elseif ($module=='c_aksiProsedia' AND $act=='terimaUnit'){
	mysqli_query($koneksi, "UPDATE c_sediakeluarunit 
							SET prosedur = IF(prosedur='61','7', IF(prosedur='63','63', IF(prosedur='7','7','41'))) 
							WHERE registrasi = '$_POST[registrasi]'");

	mysqli_query($koneksi,"	UPDATE c_unitsediaminta 
							SET prosedur = IF(prosedur='61','7', IF(prosedur='63','71', IF(prosedur='71','71','prosedur'))) 
							WHERE registrasi = '$_POST[registrasi]'");
	header('location:../../appsmedia.php?module='.$module);
}

	elseif ($module=='c_spamPsedia' AND $act=='upTabel'){
	mysqli_query($koneksi," UPDATE c_sediakeluarunit 
						   	SET prosedur = '8' 
						   	WHERE registrasi = '$_POST[registrasi]' 
						   	AND kd_brg = '$_POST[kd_brg]'");

	header('location:../../appsmedia.php?module='.$module);
	}

	elseif ($module=='c_aksiProsedia' AND $act=='simpanKlaim'){
	mysqli_query($koneksi,"UPDATE c_sediakeluarunit 
						   SET prosedur = '63', 
						   	   alasantidaksesuai ='$_POST[alasantidaksesuai]', 
						   	   qtytidaksesuai = '$_POST[qtytidaksesuai]' 
						   	   WHERE registrasi = '$_POST[registrasi]' AND kd_brg = '$_POST[kd_brg]'");

	mysqli_query($koneksi,"UPDATE c_unitsediaminta 
						   SET prosedur = IF(prosedur='6','71', IF(prosedur='61','71', IF(prosedur='63','71', IF(prosedur='71','71','prosedur')))) 
						   WHERE registrasi = '$_POST[registrasi]'");
	header('location:../../appsmedia.php?module='.$module);
	}

	

}
?>