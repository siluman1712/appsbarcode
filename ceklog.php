<?php
	session_start();
	require_once ("config/session_out.php");
	include "config/koneksi.php";
	require_once ("helper/fungsi-validasi.php");
	date_default_timezone_set("Asia/Jakarta");

	$peraturan = [
		'UNAME' => ['required'],
		'PASSWORD' => ['required'],
		'captcha' => ['required']
	];

	$U_NAME  = $koneksi->real_escape_string($_POST['uname']);
	$PASSWORD  = $koneksi->real_escape_string(md5($_POST['password']));


	if(!empty($U_NAME) && !empty($PASSWORD) && !empty($_POST['captcha']))
	{
	   if($_POST['captcha'] == $_SESSION['captcha'])
	   {
		$sql="SELECT * FROM a_useraktif WHERE UNAME ='$U_NAME' AND PASSWORD ='$PASSWORD' AND AKTIF = '2'";
		$result=$koneksi->query($sql);
		$count=mysqli_num_rows($result);
		if($count==1)
		{
			while($r=mysqli_fetch_array($result)){
			$_SESSION['ID']=$r['ID'];
			$_SESSION['NIP']	= $r['NIP'];
			$_SESSION['UNAME']	= $r['UNAME'];
			$_SESSION['EMAIL']     = $r['EMAIL'];
			$_SESSION['PASSWORD'] = $r['PASSWORD'];
			$_SESSION['LEVEL']	= $r['LEVEL'];
			$_SESSION['STATUS']	= $r['STATUS'];
			$_SESSION['FOTO']      = $r['FOTO'];
			$_SESSION['LOGIN_TERAKHIR']      = $r['LOGIN_TERAKHIR'];
			$_SESSION['SESS_ID']	= $r['SESSION_ID'];

			$_SESSION['LOGIN'] = 1;
			$_SESSION['STATUS'] = 'ONLINE';
			$old_sid = session_id();
			session_regenerate_id();
			$new_sid = session_id();
			$koneksi->query("UPDATE a_useraktif SET SESSION_ID='$new_sid' where UNAME='$U_NAME'");
			header('location:appsmedia.php?module=home');

			$date = date('Y-m-d H:i:s');
			$koneksi->query("UPDATE a_useraktif SET ISLOGIN = '1', LOGIN_TERAKHIR='$date' WHERE ID='$r[ID]'")
			or die (mysqli_error($koneksi));
			$koneksi->query("UPDATE a_useraktif SET STATUS = 'ONLINE' WHERE ID ='$r[ID]'");
			$koneksi->query("UPDATE a_useraktif SET LOGIN_TERAKHIR  = '$date' WHERE ID = '$_SESSION[ID]'");
			$koneksi->query("UPDATE a_useraktif SET LOGIN_TERAKHIR  = '$date' WHERE UNAME = '$_SESSION[UNAME]'");
			}
			login_validate();						//setel waktu. jika halaman lebih dari 5 menit tidak digunakan, maka akan logout otomatis
			header('location:appsmedia.php?module=home');
		//	header("Location:index.php");
		}else{header("Location:login.php?pesan=gagal_login");  }//jika data tidak ditemukan
	   }else{header("Location:login.php?pesan=captcha"); }		// jika captcha salah
	}else{header("Location:login.php?pesan=kosong");	}		// jika field tidak diisi
?>
