<?php require_once('Connections/Myconnection.php'); ?>
<?php
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "buy.php";
  $MM_redirectLoginFailed = "SignIn.php?fail";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_Myconnection, $Myconnection);
  
  $LoginRS__query=sprintf("SELECT Email, Password FROM `user` WHERE Email=%s AND Password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $Myconnection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<?php 
	$page_name="signin";
	include("domain.php");
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sign In</title>

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
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
      
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
	<div class="container center-block" style="padding-top: 95px;">
    	<div class=" col-md-3"></div>
        <div class=" col-md-6">
        	<div class="modal-content">
              <div class="modal-header bg-main1" style="border-radius:4px 4px 0px 0px; color:#FFF;">
                <h4 class="modal-title text-center" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> สมาชิกเข้าสู่ระบบ</h4>
              </div>
              <div class="modal-body">
                   <h4 class="text-center">สมัครสมาชิกง่ายๆด้วย Facebook</h4>
                  <div class="social-sharing is-large marginb15" align="center"><a class="share-facebook" href="#"><span class="iconso icon-facebook" aria-hidden="true"></span> <div id="signin_FB" class="btn btn-facebook fb_api"><span class="fa fa-facebook-square fa-lg"></span> Sign up with facebook</div></a> </div>
                  <hr>
                <form name="form_SignIn" id="form_SignIn" action="<?php echo $loginFormAction; ?>" method="POST" role="form" class="form-horizontal" data-toggle="validator">
                  <div class="form-group text-center">
                  	<p class="text-R1 font text-size-18"><?php if(isset($_GET['fail'])){ echo "* รหัสผ่านหรืออีเมลไม่ถูกต้อง *";}?></p>
                    <label class="col-sm-3 control-label" for="username">อีเมล</label>
                    <div class="col-sm-7">
                      <input type="email" placeholder="Email" name="email" id="email" class="form-control" data-error="อีเมลไม่ถูกต้อง" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>">
                    </div>
                  </div>
                  <div class="form-group text-center">
                    <label class="col-sm-3 control-label" for="password">รหัสผ่าน</label>
                    <div class="col-sm-7">
                      <input type="password" placeholder="Password" id="password" name="password" class="form-control" pattern="\S{6,30}" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8">
                      <button class="btn btn-main" name="submit" type="submit"><span class=" glyphicon glyphicon-log-in"></span> เข้าสู่ระบบ</button>
                      <a href="#" data-toggle="modal" data-target="#myModal2" title="สร้างบัญชี" onclick="login_hid()">&nbsp;สร้างบัญชีใหม่</a> </div>
                  </div>
                  <div class="modal-footer"> <a href="<?php echo $level;?>forget_pass/" title="ลืมรหัสผ่าน"><span class="glyphicon glyphicon-exclamation-sign text-size-16 text-danger"></span> ลืมรหัสผ่าน</a> </div>
                </form>
              </div>
            </div>
        </div>
        <div class=" col-md-3" style="margin-bottom:70px;"></div>
	</div>
</div>
<nav class="navbar-fixed-bottom ">
	<?php include("footer.php"); ?>
</nav> 
 
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

</body>
</html>