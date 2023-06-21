<?php 
$parameter = "abc"; //nilai parameter yang dikirim GET
$salt = "cV0puOlx"; //untuk tambahan enkripsi acak di md5
$hashed = md5($salt.$parameter); //enkripsi nilai yang dikirim
header("Location: http://localhost/appsbarcode/appsmedia.php?module=$parameter&hash=$hashed");
?>