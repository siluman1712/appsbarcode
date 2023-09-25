<?php
session_start();
error_reporting(0);
error_reporting('E_NONE');
ob_start();
include('../../config/koneksi.php');
include('../../config/inc.library.php');
include('../../config/fungsi_indotgl.php');

if (empty($_SESSION['UNAME']) and empty($_SESSION['PASSWORD'])){
	echo "<link href='../../asset/bootstrap/css/bootstrap.css' rel='stylesheet' type='text/css'>

                        <div class='alert alert-info'>
                        <br>
												<h2><i class='icon fa fa-info'></i> Pemberitahuan!</h2>
                        <b> MAAF DATA PDF TIDAK DAPAT DIAKSES !,</b> <bR>
                        SILAHKAN LOGIN TERLEBIH DAHULU<br>
                        <br>
											  </div>";
}
else{
$html = '
<html>
<head>
</head>
<body>';
# Perintah untuk mendapatkan data dari tabel penjualan
echo "";
?>

<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
	<style type="text/css">
		h1 { font-family: Arial; 
			text-align: center;
			 font-size: 20px; 
			 font-variant: normal; 
			 font-weight: 400; 
			 line-height: 15.6px; 
			 } 
			 h2 { font-family: Arial; 
			 text-align: center;
			 font-size: 12px; 
			 font-variant: normal; 
			 font-weight: 400; 
			 line-height: 15.6px; 
			 }	 
		h3 { font-family: Arial;
			 font-size: 14px; 
			 font-style: normal; 
			 font-variant: normal; 
			 
			 font-weight: bold; 
			 line-height: 15.4px; 
			 } 
		h4 { font-family: Arial; 
			 font-size: 12px; 
			 text-align: left;
			 font-variant: normal; 
			 font-weight: 400; 
			 line-height: 15.6px; 
			 }
			 h5 { font-family: Arial; 
			 font-size: 11px; 
			 text-align: left;
			 font-variant: normal; 
			 font-weight: 400; 
			 line-height: 15.6px; 
			 }

			  .table1 {
					font-family: arial;
					font-size: 13px;
					color: #444;
					border-collapse: collapse;
					border: 0px solid #000;
				}

			
				.table1 th{
					background: #ccc;
					color: #000;
					font-weight: normal;
					border: 1px solid #000;
				}			
				.table1 td {
					font-family: arial;
					font-size: 12px;
					padding: 5px 3px;
					border: 1px solid #000;
				}		
				.table2 td {
					font-family: arial;
					font-size: 10px;
				}	

				.table3 {
					font-family: arial;
					font-size: 12px;
				}	

	</style>
</head>
<body>
<?php
# Baca variabel URL
	$kodebarang = $_GET['kodebarang'];
	$noaset = $_GET['noaset'];  

$query = "SELECT  a.kodebarang, a.noaset, a.lokins, 
									a.unit, a.pic,
									b.kd_brg, b.ur_sskel, b.satuan,
									c.kdukpb, c.nmukpb, c.nmpb,
									d.koderuangan, d.namaruangan,
               		e.kodebarang, e.nup, 
               		e.t_anggaran, e.merek,
               		f.nip, f.nama 
              FROM dbpemeliharaan a
              LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
              LEFT JOIN s_satker c ON c.kdukpb = a.lokins
              LEFT JOIN dbruangan d ON d.koderuangan = a.unit
              LEFT JOIN dbtik e ON e.kodebarang = a.kodebarang AND e.nup = a.noaset
              LEFT JOIN dbpegawai f ON f.nip = a.pic 
              WHERE a.lokins = '$_SESSION[LOKINS]'
              AND a.kodebarang = '$kodebarang'     
              AND a.noaset = '$noaset'            
              ORDER BY a.kodebarang AND a.noaset ASC";
$a = $koneksi->query($query);
$judulatas = mysqli_fetch_array($a);

?>
<br>
<table class="table2">
	 <tr>
	 		<td><?php echo"$judulatas[nmpb]";?></td>
	 		<td></td>
	 		<td></td>
	 </tr>
	 <tr>
	 		<td><?php echo"$judulatas[nmukpb]";?></td>
	 		<td></td>
	 		<td></td>
	 </tr>
</table>
<h1>KARTU JADWAL PEMELIHARAAN </h1>
<table class="table3">
	 <tr>
	 		<td>URAIAN BMN</td>
	 		<td>:</td>
	 		<td><strong><?php echo"$judulatas[kodebarang]";?> <?php echo"$judulatas[noaset]";?> - 
	 								<?php echo"$judulatas[ur_sskel]";?></strong></td>
	 </tr>
	 	 <tr>
	 		<td>MEREK</td>
	 		<td>:</td>
	 		<td><?php echo"$judulatas[merek]";?></td>
	 </tr>
	 </tr>
	 	 <tr>
	 		<td>PEROLEHAN</td>
	 		<td>:</td>
	 		<td><?php echo"$judulatas[t_anggaran]";?></td>
	 </tr>
	 <tr>
	 		<td>UNIT</td>
	 		<td>:</td>
	 		<td><?php echo"$judulatas[koderuangan]";?> - <?php echo"$judulatas[namaruangan]";?></td>
	 </tr>
	 <tr>
	 		<td>P I C</td>
	 		<td>:</td>
	 		<td><?php echo"$judulatas[pic]";?> - <?php echo"$judulatas[nama]";?></td>
	 </tr>
	 <tr>
	 		<td>KETERANGAN</td>
	 		<td>:</td>
	 		<td>PEMELIHARAAN BMN</td>
	 </tr>
	 <tr>
	 		<td>PARAF</td>
	 		<td>:</td>
	 		<td>TEKNISI PEMELIHARAAN</td>
	 </tr>
</table>



<table class="table1">
  <thead>
  <tr>
    <th align="center">TGL<br>PELIHARA</th>
    <th align="center" width="200">PERMASALAHAN</th>
    <th align="center" width="220">TINJUT</th>
    <th align="center" width="50">PARAF </th>
  </tr>
  </thead>
  <?php
		# Menampilkan List Item barang yang dibeli untuk Nomor Transaksi Terpilih
    $query = "	SELECT a.kodebarang, a.noaset, a.merek, a.prosedur, a.lokins,
                                    a.tglperolehan, a.tgl_pemeliharaan, 
                                    a.nilaiperolehan, a.permasalahan,   
                                    a.qty, a.kondisi, a.flag, a.tgl_selesaipelihara,
                                    a.pelaksana_tinjut, a.hasil_tinjut, a.tindaklanjut,
                                    a.rencanapelihara, a.keterangan1,
                                    b.kd_brg, b.ur_sskel, b.satuan,
                                    c.status_kondisi, c.uraian_kondisi,
                                    d.status_trx, d.uraian_trx,
                                    e.kodebarang, e.noaset, e.koderuang,
                                    f.koderuangan, f.namaruangan,
                                    g.kodebarang, g.noaset, g.picnip, g.picnama,
                                    h.kodebarang, h.nup, h.kodesatker,
                                    i.idptinjut, i.uraian_ptinjut,
                                    j.idhasil, j.uraian_hasiltl
                            FROM dbpemeliharaan a
                            LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang
                            LEFT JOIN kondisi_bmn c ON c.status_kondisi = a.kondisi
                            LEFT JOIN status_transaksi d ON d.status_trx = a.prosedur
                            LEFT JOIN dbdistribusi e ON e.kodebarang = a.kodebarang AND e.noaset = a.noaset
                            LEFT JOIN dbruangan f ON f.koderuangan = e.koderuang
                            LEFT JOIN dbpicbmn g ON g.kodebarang = a.kodebarang AND g.noaset = a.noaset
                            LEFT JOIN dbtik h ON h.kodebarang = a.kodebarang AND h.nup = a.noaset
                            LEFT JOIN pelaksana_tinjut i ON i.idptinjut = a.pelaksana_tinjut
														LEFT JOIN hasil_tinjut j ON j.idhasil = a.hasil_tinjut
             WHERE a.lokins = '$_SESSION[LOKINS]'
             AND a.kodebarang = '$kodebarang' 
             AND a.noaset = '$noaset' 
             ORDER BY a.kodebarang ASC";
		$b = mysqli_query($koneksi, $query)  or die ("Query list barang salah : ".mysql_error());
		$nomor  = 0;
		while ($dbr = mysqli_fetch_array($b)) {
    $nomor++;
		?>	 
	<tbody>
	<tr>
	  <td align="center"><?php echo indotgl($dbr[tgl_pemeliharaan]); ?></td>
	  <td><?php echo $dbr['permasalahan']; ?></td>
	  <td></td>
	  <td></td>
	</tr>
	</tbody>
  <?php } ?>
  </table>
</body>
</html>
<?php }?>
<?php
$out = ob_get_contents();
ob_end_clean();
include("../../MPDF/mpdf.php");
$mpdf = new mPDF('c','F4-p','');
$mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents('mpdf/mpdf.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$mpdf->WriteHTML($out);
$mpdf->Output();
?>
