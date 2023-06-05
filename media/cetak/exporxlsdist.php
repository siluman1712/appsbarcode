<?php
include('../../config/koneksi.php');
$tgl = mysqli_query($koneksi,"SELECT * FROM s_settgl ORDER BY idtgl ASC");
$rs        = mysqli_fetch_array($tgl);
$update = date('Y-m-d');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lampiran Penghapusan BMN</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
 
	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Lampiran Penghapusan BMN.xls");
	?>
 
	<center>
		<h1>Lampiran Distribusi BMN <br/> Peralatan dan Mesin Tahun Anggaran <?php echo "$rs[s_thnang]";?></h1>
	</center>
 
	<table id="table_3" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th bgcolor='#dcdcdc'> Tanggal Distribusi </th>
                                                    <th bgcolor='#dcdcdc'> Gedung </th>
                                                    <th bgcolor='#dcdcdc'> Kode Ruangan </th>
                                                    <th bgcolor='#dcdcdc'> Nama Ruangan </th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang </th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang </th>
                                                    <th bgcolor='#dcdcdc'> No Aset </th>
                                                    <th bgcolor='#dcdcdc'> Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $dist = mysqli_query($koneksi, 
                                                          "SELECT a.tgldistribusi, a.ruanggedung, 
                                                                  a.koderuang, a.kodebarang, 
                                                                  a.noaset, a.keterangan,
                                                                  b.gedung, b.uraiangedung,
                                                                  c.kd_brg, c.ur_sskel, c.satuan,
                                                                  d.koderuangan, d.namaruangan
                                                           FROM dbdistribusi a
                                                           LEFT JOIN dbgedung b ON b.gedung = a.ruanggedung
                                                           LEFT JOIN b_nmbmn c ON c.kd_brg = a.kodebarang 
                                                           LEFT JOIN dbruangan d ON d.koderuangan = a.koderuang                                                   
                                                           ORDER BY a.ruanggedung ASC");
                                                $no = 0;
                                                while ($r = mysqli_fetch_array($dist)) {
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo "$r[tgldistribusi]"; ?></td>
                                                        <td>[<?php echo "$r[ruanggedung]"; ?>]&nbsp;
                                                            <?php echo "$r[uraiangedung]"; ?></td>

                                                        <td><?php echo "$r[koderuangan]"; ?></td>
                                                        <td><?php echo "$r[namaruangan]"; ?></td>

                                                        <td><?php echo "$r[kd_brg]"; ?></td>
                                                        <td><?php echo "$r[ur_sskel]"; ?></td>
                                                        <td><?php echo "$r[noaset]"; ?></td>
                                                        <td><?php echo "$r[keterangan]"; ?></td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>
</body>
</html>