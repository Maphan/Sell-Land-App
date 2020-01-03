<?php require_once('../Connections/Myconnection.php'); ?>
<?php if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){
	date_default_timezone_set('Asia/Bangkok');
	$id_user=date('dmYHis').rand(0,999999);
	$username=$_POST['username'];
	$email=$_POST['email'];
	$pass=$_POST['password'];
	$tel1=NULL;
	if(isset($_POST['tel1'])){$tel1=$_POST['tel1'];}
	$tel2=NULL;
	$line=NULL;
	if(isset($_POST['line'])){$line=$_POST['line'];}
	$fb=NULL;
	if(isset($_POST['fb'])){$fb=$_POST['fb'];}
	$address=NULL;
	$permission=2;
	
	//---- check email system ----//
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_user_system = "SELECT * FROM `user` WHERE Email = '$email'";
	$user_system = mysql_query($query_user_system, $Myconnection) or die(mysql_error());
	$row_user_system = mysql_fetch_assoc($user_system);
	
	if($row_user_system['ID_user']==NULL){//ไม่พบอีเมลนี้ในระบบ(สมัครได้)
		$insertSQL = "INSERT INTO user (ID_user, Username, Email, Password, Phone1, Phone2, Line, FB, Address, permission) VALUES ('$id_user', '$username', '$email', '$pass', '$tel1', '$tel2', '$line', '$fb', '$address', $permission)";
		mysql_select_db($database_Myconnection, $Myconnection);
		$Result1 = mysql_query($insertSQL, $Myconnection) or die(mysql_error());
		funcSuccess();
	}else{// มีอีเมลนี้แล้วในระบบ (สมัครไม่ได้)
		echo "fail";
	}
}?>
<?php function funcSuccess(){?>
<h3 class="text-center text-success font"><strong>สมัครสมาชิกสำเร็จแล้ว</strong></h3>
<div style="width: 100%;" class="text-center">
	<span class="glyphicon text-success glyphicon-ok text-size-30"></span>
	<p><a href="#login" data-toggle="modal" data-target="#myModal" onClick="register_hid()">เข้าสู่ระบบ</a></p>
</div>
<?php }?>
<?php function funcfail(){?>
<h3 class="text-center text-danger font"><strong>สมัครสมาชิกล้มเหลว</strong></h3>
<div style="width: 100%;" class="text-center">
	<span class="gglyphicon glyphicon-remove text-danger  text-size-30"></span>
</div>
<?php }?>