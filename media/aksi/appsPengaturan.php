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

	if ($module == 'settgl' and $act == 'updatetgl') {
		$koneksi->query("UPDATE s_settgl SET	s_tglawal='$_POST[tglawal]',
								s_tglakhir = '$_POST[tglakhir]',
								s_thnang = '$_POST[thn_ang]'
						WHERE idtgl = '$_POST[idtgl]'");
	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'PEMBAHARUAN BERHASIL',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=settgl');
			}, 1500);
		</script>
	<?php
}

	elseif ($module == 'penandatanganan' and $act == 'uptttd') {
		$koneksi->query("UPDATE s_ttd SET
								kodesatuankerja='$_POST[ukpb]',
								nip_kpb = '$_POST[NIP1]',
								nip_bmn = '$_POST[NIP2]',
								nip_sedia = '$_POST[NIP3]',
								nama_kpb = '$_POST[NAMA1]',
								nama_bmn = '$_POST[NAMA2]',
								nama_sedia = '$_POST[NAMA3]',
								kota = '$_POST[kota]',
								tgldibuat = '$_POST[tglDibuat]',
								tglsetuju = '$_POST[tglSetuju]'
						WHERE idttd = '$_POST[idttd]'");
	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'PEMBAHARUAN BERHASIL',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=penandatanganan');
			}, 1500);
		</script>
	<?php

	} 		

	elseif ($module=='konfigruangan' AND $act=='kategoriruangan'){
			
				$koneksi->query("INSERT INTO dbkategoriruang
				SET	kodekategori	= '$_POST[kode]',
					namakategori	= '$_POST[kategori]'");

		?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'DATA TAMBAHAN BERHASIL DIUPDATE',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=konfigruangan');
			}, 1500);
		</script>
		<?php
		//header('location:../../media.php?module='.$module);
		}

	elseif ($module == 'konfigruangan' and $act == 'addruang') {
		$koneksi->query("INSERT INTO dbruangan
				SET	ruanggedung	= '$_POST[gedung]',
					lantai 		= '$_POST[lantai]',
					uniteselon 	= '$_POST[uniteselon]',
					urutruangan = '$_POST[nourut]',
					koderuangan = '$_POST[gedung]$_POST[lantai]$_POST[uniteselon]$_POST[nourut]',
					namaruangan = '$_POST[namaruang]',
					luasruangan = '$_POST[luasruang]',
					kategori = '$_POST[kategoriruang]',
					nippenanggungjawab 	= '$_POST[NIP1]',
					namapenanggungjawab = '$_POST[NAMA1]',
					kdukpb = '$_POST[LOKINS]',
					keterangan = '$_POST[keterangan]'");

	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'DATABASE RUANG KERJA TELAH DITAMBAHKAN',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=konfigruangan');
			}, 1500);
		</script>
	<?php

		//header('location:../../media.php?module='.$module);
	}

	elseif ($module == 'dbpegawai' and $act == 'baru') {
		$createdDate = date('Y-m-d');

		$koneksi->query("INSERT INTO dbpegawai
				SET	nip	= '$_POST[nip]',
					nama_depan 		= '$_POST[PNS_GLRDPN]',
					nama 	= '$_POST[nama]',
					nama_belakang = '$_POST[PNS_GLRBLK]',
					idgolru = '$_POST[golru]',
					kdukpb = '$_POST[LOKINS]',
					tmt_golru = '$_POST[PNS_TMTGOL]',
					jabatan = '$_POST[JABATAN]',
					tmt_jabatan = '$_POST[TMT_JABATAN]',
					keterangan = '$_POST[keterangan]'");

	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'dbpegawai Berhasil ditambkan',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=dbpegawai');
			}, 1500);
		</script>
	<?php

		//header('location:../../media.php?module='.$module);
	}

	elseif ($module == 'user' and $act == 'newuser') {

		$rand = rand();
		$ekstensi =  array('png','jpg','jpeg','gif');
		$filename = $_FILES['imgavatar']['name'];
		$ukuran = $_FILES['imgavatar']['size'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$pass	=	md5($_POST['PASSWORD']);
		if(!in_array($ext,$ekstensi) ) {
		header("location:../../appsmedia.php?module=user&alert=gagal_ekstensi");
		}else{
			if($ukuran < 1044070){		
				$FOTO = $rand.'_'.$filename;
				move_uploaded_file($_FILES['imgavatar']['tmp_name'], 'avatar/'.$rand.'_'.$filename);
				$koneksi->query("INSERT INTO a_useraktif 
								  		SET	ID				= '$_POST[ID]',
								  			LOKINS			= '$_POST[kdukpb]',
											NIP 			= '$_POST[NIP1]',
											UNAME 			= '$_POST[UNAME]',
											PASSWORD 		= '$pass',
											LEVEL 			= '$_POST[LEVEL]',
											EMAIL 			= '$_POST[EMAIL]',
											LOGIN_TERAKHIR 	= '',
											ISLOGIN 		= '0',
											SESSION_ID		= '$_SESSION[ID]',
											NOTELP			= '$_POST[TELPWA]',
											AKTIF 			= '$_POST[AKTIF]',
											FOTO 			= '$FOTO',
											STATUS 			= '$_POST[STATUS]'");
					header("location:../../appsmedia.php?module=user&alert=berhasil");
					?>
					<script type="text/javascript">
						setTimeout(function() {
							swal({
								title: 'SUKSES',
								text: 'DATA BERHASIL DITAMBAHKAN',
								type: 'success',
								showConfirmButton: false
							});
						}, 10);
						window.setTimeout(function() {
							window.location.replace('../../appsmedia.php?module=user');
						}, 1500);
					</script>
					<?php
			}else{
				header("location:../../appsmedia.php?module=user&alert=gagal_ukuran");
			}
		}}



		elseif ($module=='user' AND $act=='hapus'){
		$koneksi->query("DELETE FROM a_useraktif WHERE ID = '$_GET[id]'");
		?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'DELETE BERHASIL',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=user');
			}, 1500);
		</script>
		<?php
		}

		elseif ($module=='user' AND $act=='aktifkan'){
		$koneksi->query( "UPDATE a_useraktif
						  SET AKTIF ='$_POST[AKTIF]' 
						  WHERE ID = '$_POST[ID]'");
		?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'User Berhasil Diaktifkan',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=user');
			}, 1500);
		</script>
		<?php
		}

		elseif ($module=='user' AND $act=='nonaktifkan'){
		$koneksi->query( "UPDATE a_useraktif
						  SET AKTIF ='$_POST[AKTIF]' 
						  WHERE ID = '$_POST[ID]'");
		?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'User Berhasil Diaktifkan',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=user');
			}, 1500);
		</script>
		<?php
		}



	elseif ($module == 'satker' and $act == 'setSatker') {
		mysqli_query($koneksi, "UPDATE s_satker
				SET	pebin='$_POST[pebin]',
					pbi = '$_POST[pbi]',
					wilayah = '$_POST[uappbw]',
					ukpb = '$_POST[ukpb]',
					upkpb = '$_POST[upkpb]',
					kdukpb = '$_POST[pebin]$_POST[pbi]$_POST[uappbw]$_POST[ukpb]$_POST[upkpb]$_POST[jk]',
					nmukpb = '$_POST[nmupkb]',
					nmpb = '$_POST[nmpb]',
					jk = '$_POST[jk]',
					kpknl = '$_POST[kpknl]'

				WHERE id = '$_POST[idsatker]'");

	?>
		<script type="text/javascript">
			setTimeout(function() {
				swal({
					title: 'SUKSES',
					text: 'SATUAN KERJA TELAH DIUPDATE',
					type: 'success',
					showConfirmButton: false
				});
			}, 10);
			window.setTimeout(function() {
				window.location.replace('../../appsmedia.php?module=satker');
			}, 1500);
		</script>
	<?php

		//header('location:../../media.php?module='.$module);
	}
		



}
?>