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

	if ($module == 'siprumahnegara' and $act == 'tambahsip') {
		$tgl = date('Y-m-d');
				$koneksi->query("INSERT INTO dbsip
								SET	idsip = '$_POST[nourut]',
									kodebarang	= '$_POST[kd_brg]',
									noaset	= '$_POST[nup]',
									no_rumah = '$_POST[typern]-$_POST[nourut]',
									gol_rumah = '$_POST[golrn]',
									type_rumah = '$_POST[typern]',
									kodesatker = '$_POST[kodesatker]',
									tglperoleh	= '$_POST[tglperoleh]',
									h_perolehan = '$_POST[h_peroleh]',
									t_anggaran	= '$_POST[t_anggaran]',
									periode = '$_POST[periode]',
									penghuni_nip = '$_POST[NIP1]',
									penghuni_nama = '$_POST[NAMA1]',
									penghuni_gapok = '$_POST[nilaigapok]',
									penghuni_tmthuni = '$_POST[tmthuni]',
									penghuni_nilaisewa = '$_POST[nilaisewa]',
									penghuni_lamahuni = '$_POST[lamahuni]',
									penghuni_sksip = '$_POST[sksip]',
									penghuni_tglsk = '$_POST[tmtsksip]',
									penghuni_tmtbayarsewa = '$_POST[tmtsewa]',
									penghuni_status = '$_POST[statushuni]'");

			?>
				<script type="text/javascript">
					setTimeout(function() {
						swal({
							title: 'SUKSES',
							text: 'SIP Rumah Negara sukses disimpan',
							type: 'success',
							showConfirmButton: false
						});
					}, 10);
					window.setTimeout(function() {
						window.location.replace('../../appsmedia.php?module=siprumahnegara');
					}, 1500);
				</script>
			<?php
			}

			elseif ($module == 'sipupdatestatus' and $act == 'updatesip') {
				$tgl = date('Y-m-d');
						$koneksi->query("INSERT INTO dbsip
										SET	idsip = '$_POST[nourut]',
											kodebarang	= '$_POST[kd_brg]',
											noaset	= '$_POST[nup]',
											no_rumah = '$_POST[no_rumah]',
											gol_rumah = '$_POST[golrn]',
											type_rumah = '$_POST[typern]',
											kodesatker = '$_POST[kodesatker]',
											tglperoleh	= '$_POST[tglperoleh]',
											h_perolehan = '$_POST[h_peroleh]',
											t_anggaran	= '$_POST[t_anggaran]',
											periode = '$_POST[periode]',
											penghuni_nip = '$_POST[NIP1]',
											penghuni_nama = '$_POST[NAMA1]',
											penghuni_gapok = '$_POST[nilaigapok]',
											penghuni_tmthuni = '$_POST[tmthuni]',
											penghuni_nilaisewa = '$_POST[nilaisewa]',
											penghuni_lamahuni = '$_POST[lamahuni]',
											penghuni_sksip = '$_POST[sksip]',
											penghuni_tglsk = '$_POST[tmtsksip]',
											penghuni_tmtbayarsewa = '$_POST[tmtsewa]',
											penghuni_selesaiperpnjang = '$_POST[tmtselesaipanjang]',
											penghuni_alasanselesai = '$_POST[alasanselesai]',
											penghuni_status = '$_POST[statushuni]'");

					?>
						<script type="text/javascript">
							setTimeout(function() {
								swal({
									title: 'SUKSES',
									text: 'Update SIP Rumah Negara sukses',
									type: 'success',
									showConfirmButton: false
								});
							}, 10);
							window.setTimeout(function() {
								window.location.replace('../../appsmedia.php?module=sipupdatestatus');
							}, 1500);
						</script>
					<?php
					}
	
}
?>