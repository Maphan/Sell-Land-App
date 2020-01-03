<?php
	$strTo = $_POST['email'];
	$strSubject = 'Forget Password @kaiteedootee.com';
	$strHeader = "From: kaiteedootee.com";
	$strMessage = "สวัสดีคุณ ".$_POST['name']."\r\n";
	$strMessage .= "คุณเป็นสมาชิกของเว็บไซต์ kaiteedootee.com \r\n";
	$strMessage .= "รหัสผ่านของคุณคือ : ".$_POST['pass']."\r\n";
	
	$flgSend = mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //
	if($flgSend){
?>
    <div class="text-center alert alert-success" role="alert">
        <span class="glyphicon glyphicon-ok text-size-30"></span>
    </div>
    <div class="text-center text-success">
        เราได้ส่งรหัสผ่านไปยังอีเมลของคุณแล้ว กรุณาตรวจสอบกล่องข้อความของคุณ
    </div>
<?php }else{?>
	<div class="text-center alert alert-danger" role="alert">
		<span class="glyphicon glyphicon-warning-sign text-size-30"></span><h3>ล้มเหลว</h3>
 	</div>
	<div class="text-center  text-danger">
		ไม่สามารถส่งรหัสผผ่านให้คุณได้
	</div>
<?php }?>