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
		<h1>Lampiran Penghapusan BMN <br/> Peralatan dan Mesin Tahun Anggaran <?php echo "$rs[s_thnang]";?></h1>
	</center>
 
	<table id="table_4" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th bgcolor="#dcdcdc"> No</th>
                                                    <th bgcolor='#dcdcdc'> Kode Barang</th>
                                                    <th bgcolor='#dcdcdc'> Uraian Barang</th>
                                                    <th bgcolor='#dcdcdc'> No Aset</th>
                                                    <th bgcolor='#dcdcdc'> Kuantitas</th>
                                                    <th bgcolor='#dcdcdc'> Satuan</th>
                                                    <th bgcolor='#dcdcdc'> Tgl Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Nilai Perolehan</th>
                                                    <th bgcolor='#dcdcdc'> Nilai Limit</th>
                                                    <th bgcolor='#dcdcdc'> Nilai Buku</th>
                                                    <th bgcolor='#dcdcdc'> Kondisi BMN</th>
                                                    <th bgcolor='#dcdcdc'> Merek</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                    $hapus = mysqli_query(
                                                        $koneksi,
                                                        "SELECT a.kodebarang, a.noaset, a.qty,
                                                                a.flag, a.kondisi, a.nilailimit, 
                                                                a.nilaibuku, a.tglperolehan, 
                                                                a.nilaiperolehan, a.satuan,
                                                                b.kd_brg, b.ur_sskel, 
                                                                c.kodebarang, c.nup, c.hargaperolehan,
                                                                c.merek, c.tglperoleh, 
                                                                d.status_kondisi, d.uraian_kondisi
                                                        FROM   dbpenghapusan a
                                                        LEFT JOIN b_nmbmn b ON b.kd_brg = a.kodebarang 
                                                        LEFT JOIN dbtik c ON c.kodebarang = a.kodebarang AND c.nup = a.noaset
                                                        LEFT JOIN kondisi_bmn d ON d.status_kondisi = a.kondisi
                                                        WHERE  a.kondisi ='33' AND a.flag IN('2','3')
                                                        ORDER BY a.kodebarang AND a.noaset ASC"
                                                    );

                                                    $numRows = mysqli_num_rows($hapus);
                                                    $no = 0;
                                                    while ($rs = mysqli_fetch_array($hapus)) {
                                                        $no++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo "$no"; ?></td>
                                                        <td><?php echo "$rs[kodebarang]"; ?></td>
                                                        <td><?php echo "$rs[ur_sskel]"; ?></td>
                                                        <td><?php echo "$rs[nup]"; ?></td>
                                                        <td><?php echo "$rs[qty]"; ?></td>
                                                        <td><?php echo "$rs[satuan]"; ?></td>
                                                        <td><?php echo "$rs[tglperolehan]"; ?></td>
                                                        <td><?php echo "$rs[nilaiperolehan]"; ?></td>
                                                        <td><?php echo "$rs[nilailimit]"; ?></td>
                                                        <td><?php echo "$rs[nilaibuku]"; ?></td>
                                                        <td><?php echo "$rs[uraian_kondisi]"; ?></td>
                                                        <td><?php echo "$rs[merek]"; ?></td>
                                                    </tr>
                                                    </tfoot>
                                                <?php } ?>
                                        </table>
</body>
</html>