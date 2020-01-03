<!DOCTYPE html>
<?php 
	$page_name="delete";
	include("../domain.php");
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Forget password</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    <link href="css/style_intro.css" rel="stylesheet">-->
    <link href="../css/style_navbar-page.css" rel="stylesheet">
    <link href="../font/stylesheet.css" rel="stylesheet">
    <link href="../css/style_footer.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="../js/boxOder.js"></script>
      
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
			  font-size: 18px;
			  color: red;
			  margin-bottom: 0px;
		  }
		  .form-group{
			  margin-bottom: 0px;
			  height: 60px;
		  }
		  #panel{
			  padding-top:15px;
		  }
		  #lable{
			  	  margin-top:5px;
				  text-align:right;
			  }
		  #track{
				  color:#F00;
			  }
		  @media (max-width: 768px) {
			  #lable{
				  margin-top:5px;
				  text-align: left;
			  }
			  .phone-onHid{
				  display:none;
			  }
		  }
		  
	</style>

  </head>
<body class="bg-W2">

<?php 
include("../Navbar/level_navbar.php");
NavBar_L2();
include("../Navbar/navbar.php"); 
?>

<div class="box-fullscreen full_screen">
	<div class="container center-block" style="padding-top: 130px; padding-bottom: 30px;">
		<div class="col-sm-8 col-sm-offset-2">
        
			<div class="panel" style="border:0px dashed #FFF;">
					<div class="panel-heading text-center alert-warning">
						
						<h3 class="font"><span class="glyphicon glyphicon-exclamation-sign"></span><b> ลืมรหัสผ่าน</b></h3>
 					</div>
					<div class="panel-body">
                    	<form action="check_system.php" name="forget_pass" id="forget_pass" method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"></div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="Email" name="Email" placeholder="your email"/>
                                </div>
							</div>
                            
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"></div>
                                <div class="col-md-6 text-center">
                                       <button type="submit" class="btn btn-warning btn-lg" name="signup" value="Sign up"><span class="glyphicon glyphicon-ok-sign"></span> <b>OK</b></button>
                                </div>
                        	</div>  
                    	</form>
					</div>
				</div>

            
		</div>
	</div>
</div>

<nav class="navbar-fixed-bottom ">
	<?php include("../footer.php") ?>
</nav> 

 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../jquery/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/jquery.validate.js"></script>
<script type="text/javascript">
	$.validator.setDefaults( {
			submitHandler: function () {
				//alert( "submitted!" );
				HTMLFormElement("#forget_pass").submit;
			}
		} );

		$( document ).ready( function () {
			$( "#forget_pass" ).validate( {
				rules: {
					Email: {
						required: true,
						email: true
					}
					
				},
				messages: {
					Email: "อีเมลของคุณไม่ถูกต้อง"
				},
				errorElement: "span",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block font" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
				}
			} );
		});
</script>

</body>
</html>