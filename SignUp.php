<!DOCTYPE html>
<?php 
	$page_name="signup";
	include("domain.php");
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sign Up</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    <link href="css/style_intro.css" rel="stylesheet">-->
    <link href="css/style_navbar-page.css" rel="stylesheet">
    <link href="font/stylesheet.css" rel="stylesheet">
    <link href="css/style_footer.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style_boxOder.css" rel="stylesheet">
    <link href="css/style_list_province.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="jquery/jquery.min.js"></script>
      <script src="js/boxOder.js"></script>
      
	  <style type="text/css">
		  html,body{
			  width: 100%;
			  height: 100%;
			  padding: 0;
			  margin: 0;	  
		  }
		  @media (max-width: 767px){
			  html,body{
			  width: 100%;
			  height: 100%;
			  padding: 0;
			  margin: 0;  
			  }
		  }
		  .help-block{
			  font-size: 13px;
			  color: red;
			  margin-bottom: 0px;
		  }
		  .form-group{
			  margin-bottom: 0px;
			  height: 60px;
		  }
		  #step:hover{
			  background-color:#0C7F5C;
			  color: #FFF;
		  }
	</style>

  </head>
<body>

<?php 
include("Navbar/level_navbar.php");
NavBar_L1();
include("Navbar/navbar.php"); 
?>

<div class="box-fullscreen bg-W1 full_screen">
	<div class="container center-block" style="padding-top: 90px; padding-bottom: 70px;">
		
		<div class="col-sm-8 col-sm-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading text-center bg-B1">
						<span class="btn btn-circle bg-main1"  style="cursor: auto;">
							<span class="glyphicon glyphicon-plus text-W1" style="font-size: 30px; margin: 0px;"></span>
						</span>
						<span class="glyphicon glyphicon-user text-W4" style="font-size: 70px; "></span>
 					</div>
					<div id="panelSignup_body" class="panel-body">
						<form id="signupForm" method="post" enctype="multipart/form-data" class="form-horizontal" action="">
							<p id="alert" class="text-R1 text-center font text-size-18"><?php if(isset($_POST['alert'])){echo $_POST['alert'];} ?></p>
							<div class="form-group">
								<label class="col-sm-4 control-label" for="username">ชื่อผู้ใช้</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="username" name="username" placeholder="username" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>" />
								</div>
							</div>							
							<div class="form-group">
								<label class="col-sm-4 control-label" for="Email">อีเมล</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="Email" name="Email" placeholder="Email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>"/>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 control-label" for="tel">เบอร์โทรศัพท์</label>
								<div class="col-sm-5">
									<input type="number" class="form-control" id="tel" name="tel" placeholder="Phone numbe" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label" for="password">รหัสผ่าน</label>
								<div class="col-sm-5">
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label" for="confirm_password">ยืนยันหรัสผ่าน</label>
								<div class="col-sm-5">
									<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" for="line_ID">Line ID</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="line_ID" name="line_ID" placeholder="Line ID"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" for="facebook">Facebook</label>
								<div class="col-sm-5">
									<input type="url" class="form-control" id="facebook" name="facebook" placeholder="https://" value="<?php if(isset($_POST['linkfb'])){echo $_POST['linkfb'];} ?>" />
								</div>
							</div>
							<div class="col-md-8 col-md-offset-2" style="padding-top: 20px; padding-bottom: 10px;">
								<div class="text-center">
									<span class="text-R1 text-size-20">*</span><span>เงื่อนไขการใช้บริการ</span>
								</div>
								<div class="col-sm-12">
									<div class="cut-text" style="border-radius: 6px; border: 1px solid #DCDCDC; padding: 8px;">
									
										<p><li>เราเว็บไซต์ที่ให้บริการลงประกาศซื้อขาย ลงประกาศได้ฟรี เช่น ที่ดิน บ้าน</li></p>

										<p><li>ข้อมูลที่ท่านใช้ในการสมัครสมาชิก เราจะไม่เปิดเผยต่อผู้อื่น แต่หากทางเว็บไซต์ถูกจารกรรมข้อมูลด้วยวิธีใดๆ ก็ตาม ทางเว็บไซต์ขอสงวนสิทธิ์ในการปฏิเสธความรับผิดชอบทุกกรณี ทางเว็บไซต์ไม่ต้องรับผิดชอบต่อความเสียหายใดๆ ที่เกิดขึ้น</li></p>
									</div>
								</div>
							</div>
							
<!--
							<div class="form-group">
								<label class="col-sm-4 control-label" for="username1">Username</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" id="username" name="username" placeholder="Username" />
								</div>
							</div>
-->

							<div class="form-group" >
								<div class="col-sm-5 col-sm-offset-4">
									<div class="checkbox" style="padding-bottom: 20px;">
										<label>
											<input type="checkbox" id="agree" name="agree" value="agree" />ยอมรับเงื่อนไขการใช้บริการ
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-12 text-center">
									<button type="submit" class="btn btn-main" name="signup" value="Sign up">Submit</button>
									<p id="status" class="text-R1 text-center font text-size-18" style="margin-top: 8px;"></p>
								</div>
							</div>
						</form>
                        <div id="success_signup" class="hidden">
                        	<h3 class="text-center text-success font"><strong>สมัครสมาชิกสำเร็จแล้ว</strong></h3>
                            <div style="width: 100%;" class="text-center">
                                <span class="glyphicon text-success glyphicon-ok text-size-30"></span>
                                <p><a href="SignIn.php">เข้าสู่ระบบ</a></p>
                            </div>
                        </div>
					</div>
				</div>
			</div>
	</div>
</div>


<nav class="navbar-fixed-bottom ">
	<?php include("footer.php") ?>
</nav> 
 
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/js/jquery.validate.js"></script>

<script type="text/javascript">

		$( document ).ready( function () {
			$( "#signupForm" ).validate( {
				rules: {
					username: {
						required: true,
						maxlength:100
					},
					Email: {
						required: true,
						email: true
					},
					tel:{
						required:true,
						minlength:8,
						maxlength:13
					},
					pass: {
						required: true,
						minlength: 6
					},
					confirm_password: {
						required: true,
						minlength: 6,
						equalTo: "#pass"
					},
					
					agree: "required"
				},
				messages: {
					username: {
						required: "*กรอกชื้อผู้ใช",
						maxlength: "*มีความยาวมากเกินไป"
					},
					Email: "*กรอกอีเมลที่ถูกต้องของคุณ",
					tel:{
						required: "*กรอกเบอร์โทรศัพท์",
						minlength: "*ไม่ถูกต้อง",
						maxlength: "*ไม่ถูกต้อง"
					},
					pass: {
						required: "*กรอกรหัสของคุณ",
						minlength: "*ต้องมีความยาวไม่น้อยกว่า 6 "
					},
					confirm_password: {
						required: "*กรอกชื่อของคุณ",
						minlength: "*ต้องมีความยาวไม่น้อยกว่า 6",
						equalTo: "*รหัสไม่ตรงกัน"
					},
					
					agree: "*ยอมรับเงื่อนไขการให้บริการ"
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					// Add `has-feedback` class to the parent div.form-group
					// in order to add icons to inputs
					element.parents( ".col-sm-5" ).addClass( "has-feedback" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}

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
	//				alert( "submitted!" );
	//				HTMLFormElement("#signinForm").submit;
					var username_form=$('#username').val();
					var email_form=$('#Email').val();
					var pass_form=$('#pass').val();
					var tel=$('#tel').val();
					var line_form=$('#line_ID').val();
					var fb_form=$('#facebook').val();
					$.ajax({
						url: 'register/register_sever.php',
						data:{username:username_form,email:email_form,password:pass_form,tel1:tel,line:line_form,fb:fb_form},
						type: 'POST',
						success: function(respon){
							console.log(respon);
							if(respon == 'fail'){
								document.getElementById("status").innerHTML = "# อีเมลนี้มีผู้ใช้แล้ว #";
								alert("# อีเมลนี้มีผู้ใช้แล้ว #")
							}else{
								$('#signupForm').addClass('hidden');
								$('#success_signup').removeClass('hidden');
								$('#success_signup').addClass('show');
							}
						}
					});
				}
			} );
		} );
	</script>
</body>
</html>