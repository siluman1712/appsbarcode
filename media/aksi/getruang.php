<?php
include "../../config/koneksi.php";
$gedung=$_POST['id'];
$query=mysqli_query($koneksi, "SELECT * FROM dbruangan WHERE ruanggedung ='$gedung'");
$row = mysqli_num_rows($query);
if($row > 0)
{
	while ($r=mysqli_fetch_array($query)) {
?>
		<option value='<?php echo "$r[koderuangan]"; ?>'>[ <?php echo "$r[ruanggedung]"; ?> ][ <?php echo "$r[lantai]"; ?> ][<strong><?php echo "$r[koderuangan]"; ?></strong>] <?php echo "$r[namaruangan]"; ?></option>
<?php
	}
}

?>

