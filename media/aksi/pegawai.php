<?php
include "../../config/koneksi.php";
$NIP = $_GET['term'];
$sql = "SELECT PNS_NIPBARU, PNS_PNSNAM FROM m_pupns WHERE PNS_NIPBARU = '$NIP'";
$hs = mysqli_query($koneksi, $sql);
$json = array();
while($rs = mysqli_fetch_array($hs)){
	$json[] = array(
		'label' => $rs['NIP'],
		'value' => $rs['NIP'],
		'NAMA' => $rs['PNS_PNSNAM']
	);
}
header("Content-Type: application/json");
echo json_encode($json);


?>

