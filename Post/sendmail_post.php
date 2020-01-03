<?php
	include("../phpObject/DateThai.php");

	$strTo = $_POST['email'];
	$strSubject = 'Post info @Tinny.com';
	$strHeader = "From: Tinny.com";
	$strMessage = "สวัสดีคุณ ".$_POST['username']."\r\n";
	$strMessage .= "คุณเป็นสมาชิกของเว็บไซต์ Tinny.com \r\n";
	$strMessage .= "คุณได้ลงประกาศ ".$_POST['post_type'].$_POST['property_type'].": ".$_POST['title']." (".DateThai($_POST['date']).")"."\r\n\r\n";
	$strMessage .="ID ประกาศ : ".$_POST['id_post']."\r\n";
	$strMessage .="รหัสผ่าน ประกาศ : ".$pass."\r\n";
	$strMessage .="** รหัสผ่านประกาศจะใช้ในการ แก้ไข หรือ ลบ ประกาศ **\r\n";
	
	mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //
?>