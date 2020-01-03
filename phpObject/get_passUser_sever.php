<?php require_once('../Connections/Myconnection.php'); ?>
<?php if(isset($_POST['email']) && $_POST['accessCode']=="dfmfd894g9er4gb54dfv984e9r4g9e4h9fv5b4e984h9sdfSSDfg849er4g9Df98g9ef549g5df4_jaruwat"){	
	$email=$_POST['email'];
	//---- query user----//
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_user_system = "SELECT * FROM `user` WHERE Email = '$email'";
	$user_system = mysql_query($query_user_system, $Myconnection) or die(mysql_error());
	$row_user_system = mysql_fetch_assoc($user_system);
	
	if($row_user_system['ID_user']==NULL){//ไม่พบอีเมลนี้ในระบบ
		echo "fail";
	}else{// มีอีเมลนี้แล้วในระบบ
		echo $row_user_system['Password'];
	}

}?>