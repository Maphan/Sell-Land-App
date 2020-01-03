<?php require_once('../Connections/Myconnection.php'); ?>
<?php if(isset($_POST['email'])){
	date_default_timezone_set('Asia/Bangkok');
	$id_user=date('dmYHis').rand(0,999999);
	$email=$_POST['email'];

	
	//---- check email system ----//
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_user_system = "SELECT * FROM `user` WHERE Email = '$email'";
	$user_system = mysql_query($query_user_system, $Myconnection) or die(mysql_error());
	$row_user_system = mysql_fetch_assoc($user_system);
	
	if($row_user_system['ID_user']==NULL){//ไม่พบอีเมลนี้ในระบบ
		echo "0";
	}else{// มีอีเมลนี้แล้วในระบบ
		echo "1";
	}
}?>