<?php require_once($connec); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Check_signin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Check_signin = $_SESSION['MM_Username'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_Check_signin = sprintf("SELECT * FROM `user` WHERE Email = %s", GetSQLValueString($colname_Check_signin, "text"));
$Check_signin = mysql_query($query_Check_signin, $Myconnection) or die(mysql_error());
$row_Check_signin = mysql_fetch_assoc($Check_signin);
$totalRows_Check_signin = mysql_num_rows($Check_signin);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>
<script src="https://use.fontawesome.com/62098b2cb7.js"></script>
<script src="<?php echo $level;?>bootstrap/js/jquery.validate.js"></script>
<script src="<?php echo $level;?>js/function_openWindowWithPost.js"></script>
<?php include($level."js/fb_login_API.php"); ?>

<style type="text/css">
	.form-control-feedback{
		right:8px;
		color:#B30000;
	}
	.glyphicon-remove{
		color:#B30000;
	}
	.glyphicon-ok{
		color:#090;
	}
	.btn-facebook{
			  padding:5px;
			  border-radius:4px;
			  background-color:#3b5998;
			  color:#FFF;
	}
	.btn-facebook:hover{
			  background-color:#2F059A;
			  color:#FFF;
	}
	.link{
		color: #FFF;
	}
	.link:hover{
		color: #B8B8B8;
	}
</style>

<nav class="navbar navbar-default navbar-fixed-top ">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
        <div class="margindash pull-right hidden-lg hidden-md hidden-sm">
			<li class="dropdown">
			  <!-- user -->
			  <?php if($row_Check_signin['Email']==NULL){?>
				<a href="#login" data-toggle="modal" data-target="#myModal" style="margin: 10px;"><span class="glyphicon glyphicon-user text-W1 text-size-18 link" style="margin-top: 15px;"></span></a>
			  <?php }else{ ?>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><span class="font text-size-18 text-W1" style="display: inline-block; margin-right: 8px; padding-top: 12px;"><?php echo $row_Check_signin['Username']; ?>
				  <span class="caret"></span></span></a>
			  <ul class="dropdown-menu" style="left:-50px;">
				<li><a href="<?php echo $to_profile;?>"><span class="glyphicon glyphicon-home"></span> <b>โปร์ไฟล์</b></a></li>
				<li><a href="<?php echo $to_editProfile;?>"><span class="glyphicon glyphicon-cog"></span> <b>แก้ไขข้อมูลส่วนตัว</b></a></li>
				<li role="separator" class="divider"></li>
				<li><a href="<?php echo $logout;?>" class="font"><span class="glyphicon glyphicon-off text-R1"></span> <b>Sign Out</b></a></li>
			  </ul>
			  <?php }?>
			</li>
        </div>
		  <a class="navbar-brand" href="<?php echo $to_index;?>">
   			<img src="<?php echo $img_logo;?>" width="220px" class="img-responsive navbar_loago phoneONhid"/>
   			<img src="<?php echo $level;?>images/logo2.png" width="130px" class="img-responsive navbar_loago pc-hid"/>
   		</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right navbar_menu">
      	<?php if($page_name=="view_order"||$page_name=="delete_post" ||$page_name=="Edit_post"||$page_name=="post"){?>
      	<li onclick="goBack()" ><a href="#"><span class="glyphicon glyphicon-arrow-left text-size-18"></span> กลับ</a></li>
        <?php }else{}?>
        <li class="<?php if($page_name=="buy"){echo "active";} ?>" ><a href="<?php echo $to_buy;?>">หน้าหลัก</a></li>
        
        <li class="<?php if($page_name=="post"){echo "active";} ?>"><a href="<?php echo $to_post;?>">ลงประกาศฟรี</a></li>
        <!-- <li><a href="<?php echo $sert;?>">ค้นหา</a></li> -->
        <li class="dropdown">
          <?php if($row_Check_signin['Email']==NULL){?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">สมาฃิก 
          	<span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href="#login" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span> <b>เข้าสู่ระบบ</b></a></li>
            <li><a href="#" data-toggle="modal" data-target="#myModal2"><span class="glyphicon glyphicon-user"></span> <b>สมัครมาชิก</b></a></li>
          </ul>
          <?php }else{ ?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $row_Check_signin['Username']; ?> 
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $to_profile;?>"><span class="glyphicon glyphicon-home"></span> <b>โปร์ไฟล์</b></a></li>
            <li><a href="<?php echo $to_editProfile;?>"><span class="glyphicon glyphicon-cog"></span> <b>แก้ไขข้อมูลส่วนตัว</b></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?php echo $logout;?>" class="font"><span class="glyphicon glyphicon-off text-R1"></span> <b>Sign Out</b></a></li>
          </ul>
          <?php }?>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<?php if($row_Check_signin['ID_user']==NULL){?>
<!-- sign in modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-main1" style="border-radius:4px 4px 0px 0px; color:#FFF;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="glyphicon glyphicon-remove"></span></button>
        <h4 class="modal-title text-center" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> สมาชิกเข้าสู่ระบบ</h4>
      </div>
      <div class="modal-body">
          <h4 class="text-center">เข้าสู่ระบบ ด้วย Facebook</h4>
          <div class="social-sharing is-large marginb15" align="center"><a class="share-facebook" href="#"><span class="iconso icon-facebook" aria-hidden="true"></span> <div id="signin_FB" class="btn btn-facebook fb_api"><span class="fa fa-facebook-square fa-lg"></span> Login with facebook</div></a> </div>
          <hr>
       	  <p id="status_signinFormNavbar"class="text-center text-R1 font text-size-18" style="width: 100%;"></p>
        <form name="form_SignIn_Navbar" id="form_SignIn_Navbar" action="" method="POST" role="form" class="form-horizontal" data-toggle="validator">
          <div class="form-group">
            <label class="col-sm-3 control-label" for="email_SignIn_Navbar">อีเมล</label>
            <div class="col-sm-7">
              <input type="email" placeholder="Email" name="email_SignIn_Navbar" id="email_SignIn_Navbar" class="form-control" data-error="อีเมลไม่ถูกต้อง" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9]{1,12}$" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="password">รหัสผ่าน</label>
            <div class="col-sm-7">
              <input type="password" placeholder="Password" id="password_SignIn_Navbar" name="password_SignIn_Navbar" class="form-control" pattern="\S{6,30}" required="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-8">
              <button class="btn btn-main" name="btn_login" ><span class=" glyphicon glyphicon-log-in"></span> เข้าสู่ระบบ</button>
              <a href="#" data-toggle="modal" data-target="#myModal2" title="สร้างบัญชี" onclick="">&nbsp;สร้างบัญชีใหม่</a> </div>
          </div>
          <div class="modal-footer"> <a href="<?php echo $level;?>forget_pass/" title="ลืมรหัสผ่าน"><span class="glyphicon glyphicon-exclamation-sign text-size-16 text-danger"></span> ลืมรหัสผ่าน</a> </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- sign up -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-main1" style="border-radius:4px 4px 0px 0px; color:#FFF;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="glyphicon glyphicon-remove"></span></button>
        <h4 class="modal-title text-center" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> สมัครสมาชิก</h4>
      </div>
      <div id="signup_body" class="modal-body">
          <h4 class="text-center">สมัครสมาชิกง่ายๆด้วย Facebook</h4>
          <div class="social-sharing is-large marginb15" align="center"><a class="share-facebook" href="#"><span class="iconso icon-facebook" aria-hidden="true"></span> <div id="signin_FB" class="btn btn-facebook fb_api"><span class="fa fa-facebook-square fa-lg"></span> Sign up with facebook</div></a> </div>
          <hr>
          <p id="status_signupFormNavbar"class="text-center text-R1 font text-size-18" style="width: 100%;"></p>
        <form name="form_SignUp_Navbar" id="form_SignUp_Navbar" method="post" role="form" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-3 control-label" for="username">ชื่อผู้ใช้</label>
            <div class="col-sm-7">
              <input type="text" placeholder="username" name="username_SignUp_Navbar" id="username_SignUp_Navbar" class="form-control" required>
            </div>
          </div>
           <div class="form-group">
            <label class="col-sm-3 control-label" for="username">อีเมล</label>
            <div class="col-sm-7">
              <input type="text" placeholder="Email" name="email_SignUp_Navbar" id="email_SignUp_Navbar" class="form-control" data-error="อีเมลไม่ถูกต้อง" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="tel_SignUp_Navbar">เบอร์โทรศัพท์</label>
            <div class="col-sm-7">
              <input type="number" placeholder="Phone number" name="tel_SignUp_Navbarr" id="tel_SignUp_Navbar" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="password">รหัสผ่าน</label>
            <div class="col-sm-7">
              <input type="password" placeholder="Password" id="pass_SignUp_Navbar" name="pass_SignUp_Navbar" class="form-control" pattern="\S{4,20}" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="password">ยืนยันรหัสผ่าน</label>
            <div class="col-sm-7">
              <input type="password" placeholder="Password" id="password_con_SignUp_Navbar" name="password_con_SignUp_Navbar" class="form-control" pattern="#password" required="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-8">
              <button class="btn btn-main" name="btn_signup" type="submit"><span class="glyphicon glyphicon-user"></span> สมัครสมาชิก</button>
              <a href="#login" data-toggle="modal" data-target="#myModal" onClick="register_hid()">&nbsp;เข้าสู่ระบบ</a> </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php }else{}?>

<?php
mysql_free_result($Check_signin);
?>


<script>
// go back
function goBack() {
    window.history.back();
}
// login hid
function login_hid(){
	$('#myModal').modal('hide')
}
function register_hid(){
	$('#myModal2').modal('hide')
}
$('#myModal').validator()
</script>
<script type="text/javascript">
//------ Sign in-------//
$( document ).ready( function () {

			$("#form_SignIn_Navbar" ).validate( {
				rules: {
					email_SignIn_Navbar: {
						required: true,
						email: true
					},
					password_SignIn_Navbar: {
						required: true,
						minlength: 6
					}
				},
				messages: {
					email_SignIn_Navbar: "*กรอกอีเมลที่ถูกต้องของคุณ",
					password_SignIn_Navbar: {
						required: "*กรอกรหัสของคุณ",
						minlength: "*ต้องมีความยาวไม่น้อยกว่า 6 "
					}
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					
					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !element.next( "span" )[ 0 ] ) {
//						$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !$( element ).next( "span" )[ 0 ] ) {
//						$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
					$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
				},
				unhighlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
					$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
				},
				submitHandler: function () {
					var email_SignIn_Navbar=$('#email_SignIn_Navbar').val();
					var pass_SignIn_Navbar=$('#password_SignIn_Navbar').val();
					var urlSigninSever='<?php echo $level."signin/login_sever.php";?>';
					console.log(email_SignIn_Navbar);
					console.log(pass_SignIn_Navbar);
					console.log(urlSigninSever);
					$.ajax({
						url: urlSigninSever,
						data:{email:email_SignIn_Navbar,password:pass_SignIn_Navbar},
						type: 'POST',
						success: function(data){
							console.log(data);
							if(data=='1'){
								document.getElementById("status_signinFormNavbar").innerHTML = "loading...";
								location.reload();
							}else if(data=='0'){
								document.getElementById("status_signinFormNavbar").innerHTML = "รหัสผ่านหรืืออีเมลไม่ถูกต้อง!";
							}
						}
					});
				}
			} );
} );

//------ Sign up-------//

$( document ).ready( function () {
			$( "#form_SignUp_Navbar" ).validate( {
				rules: {
					username_SignUp_Navbar: {
						required: true,
						maxlength:150
					},
					email_SignUp_Navbar: {
						required: true,
						email: true
					},
					pass_SignUp_Navbar: {
						required: true,
						minlength: 6
					},
					password_con_SignUp_Navbar: {
						required: true,
						minlength: 6,
						equalTo: "#pass_SignUp_Navbar"
					},
					tel_SignUp_Navbar: {
						required: true,
						minlength: 8,
						maxlength: 15
					},
					
					agree: "required"
				},
				messages: {
					username_SignUp_Navbar: {
						required: "*กรอกชื้อผู้ใช",
						maxlength: "*มีความยาวมากเกินไป"
					},
					Email_SignUp_Navbar: "*กรอกอีเมลที่ถูกต้องของคุณ",
					pass_SignUp_Navbar: {
						required: "*กรอกรหัสของคุณ",
						minlength: "*ต้องมีความยาวไม่น้อยกว่า 6 "
					},
					confirm_password_SignUp_Navbar: {
						required: "*กรอกชื่อของคุณ",
						minlength: "*ต้องมีความยาวไม่น้อยกว่า 6",
						equalTo: "*รหัสไม่ตรงกัน"
					},
					tel_SignUp_Navbar: "*ไม่ถูกต้อง",
					agree: "*ยอมรับเงื่อนไขการให้บริการ"
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					
					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
					$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
				},
				unhighlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
					$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
				},
				submitHandler: function () {
					var username_Sigup_Navbar=$('#username_SignUp_Navbar').val();
					var email_Sigup_Navbar=$('#email_SignUp_Navbar').val();
					var pass_Sigup_Navbar=$('#pass_SignUp_Navbar').val();
					var tel_SignUp_Navbar=$('#tel_SignUp_Navbar').val();
					var urlSignupSever='<?php echo $level."register/register_sever.php";?>';
					var page_Level='<?php echo $level;?>';
					console.log(username_Sigup_Navbar);
					console.log(email_Sigup_Navbar);
					console.log(pass_Sigup_Navbar);
					console.log(urlSignupSever);
					$.ajax({
						url: urlSignupSever,
						data:{username:username_Sigup_Navbar,email:email_Sigup_Navbar,password:pass_Sigup_Navbar,tel1:tel_SignUp_Navbar},
						type: 'POST',
						success: function(respon){
							console.log(respon);
							if(respon == 'fail'){
								document.getElementById("status_signupFormNavbar").innerHTML = "อีเมลนี้มีผู้ใช้แล้ว";
								alert("# อีเมลนี้มีผู้ใช้แล้ว #")
							}else{
								document.getElementById("signup_body").innerHTML = respon;
							}
						}
					});
				}
			} );
} );
</script>