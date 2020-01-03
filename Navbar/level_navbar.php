<?php
	$level="";
	$connec="";
	$img_logo="images/logo.png";
	$to_index="";
	$to_post="";
	$to_buy="";
	$Land="";
	$house="";
	$sert="";
	$to_signin="";
	$to_signup="";
	$to_profile="";
	$to_editProfile="";
	$logout="";
	
	function NavBar_L1(){
		global $level,$connec,$img_logo,$to_index,$to_post,$to_buy,$Land,$house,$sert,$to_signin,$to_signup,$to_profile,$to_editProfile,$logout;
		$level="";
		$connec='Connections/Myconnection.php';
		$img_logo="images/logo.png";
		$to_index='index.php';
		$to_post='Post/';
		$to_buy="buy.php";
		$Land="buy.php?Property_type1=ที่ดิน";
		$house="buy.php?Property_type2=บ้าน";
		$sert="#";
		$to_signin="SignIn.php";
		$to_signup="SignUp.php";
		$to_profile="Myuser/profile.php";
		$to_editProfile="Myuser/edit_profile.php";
		$logout="SignOut/SignOut.php";
	}
	function NavBar_L2(){
		global $level,$connec,$img_logo,$to_index,$to_post,$to_buy,$Land,$house,$sert,$to_signin,$to_signup,$to_profile,$to_editProfile,$logout;
		$level="../";
		$connec='../Connections/Myconnection.php';
		$img_logo="../images/logo.png";
		$to_index='../index.php';
		$to_post='../Post/';
		$to_buy="../buy.php";
		$Land="../buy.php?Property_type1=ที่ดิน";
		$house="../buy.php?Property_type2=บ้าน";
		$sert="#";
		$to_signin="../SignIn.php";
		$to_signup="../SignUp.php";
		$to_profile="../Myuser/profile.php";
		$to_editProfile="../Myuser/edit_profile.php";
		$logout="../SignOut/SignOut.php";
	}
	
?>