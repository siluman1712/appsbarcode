<?php
include "../../config/koneksi.php";
$id=$_POST['id'];
$query=mysqli_query($koneksi, "SELECT * FROM dblantai WHERE gedung ='".$id."'");
$row = mysqli_num_rows($query);
if($row > 0)
{
	while ($r=mysqli_fetch_array($query)) {
?>
		<option value='<?php echo "$r[ltgedung]"; ?>'>[ <?php echo "$r[gedung]"; ?> ][ <?php echo "$r[ltgedung]"; ?> ] <?php echo "$r[uraianlantai]"; ?></option>
<?php
	}
}
?>

