<?php require_once('../Connections/Myconnection.php'); ?>
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

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['pass'];
  $MM_fldUserAuthorization = "permission";
  $MM_redirectLoginSuccess = "dashboard.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_Myconnection, $Myconnection);
  	
  $LoginRS__query=sprintf("SELECT Email, Password, permission FROM `user` WHERE Email=%s AND Password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $Myconnection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'permission');
    
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
	$page_name="admin";
	include("../domain.php");
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ADMIN TINNE</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    <link href="css/style_intro.css" rel="stylesheet">-->
    <link href="../css/style_navbar-page.css" rel="stylesheet">
    <link href="../font/stylesheet.css" rel="stylesheet">
    <link href="../css/style_footer.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <!--<link href="../css/style_boxOder.css" rel="stylesheet">
    <link href="../css/style_list_province.css" rel="stylesheet">
     -->
    
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="js/btn_admin.js"></script>
      
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
			  .phone_onHID{
				  display:none;
			  }
			  #wrapper {
				/*You can add padding and margins here.*/
				text-align:center;
				vertical-align:middle;
				opacity:1;
				color:#FFF;
				height:500px;
				width:300px;
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
		  @media (min-width: 768px) {
			  .phone_onHID{
				  display: block;
			  }
			  #lable{
				  margin-top:5px;
				  text-align: left;
			  }
			  .phone-onHid{
				  display:none;
			  }
			  #wrapper {
				/*You can add padding and margins here.*/
				text-align:center;
				vertical-align:middle;
				opacity:1;
				color:#FFF;
				height:500px;
				width:800px;
			}
		  }
#full-size {
    height:100%;
    width:100%;
    top:0;
    left:0;
    overflow:hidden;
	background-color:#000;
	opacity:.8;
}

.centered {
	position: absolute;
	top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}		  
</style>

  </head>
<body>

<?php 
//include("../Navbar/level_navbar.php");
//NavBar_L2();
//include("../Navbar/navbar.php"); 
?>
<div id="full-size" class="col-sm-12">
    <div id="wrapper"  class="centered class="col-sm-12"">
				<div class="panel" style="border:0px dashed #FFF; height:500px;">
					<div class="panel-heading text-center alert-danger">
						
						<h3 class="font"><span class="glyphicon glyphicon-cog"></span><b> ยินดีต้อนรับสู่ระบบ Administrator</b></h3>
 					</div>
					<div class="panel-body">
                    	<div class="col-sm-12 phone_onHID">
                        	<img id="img_default" src="images/setting.png" alt="" width="150" height="150" style="display: none;"  />
     						<img id="img_loading" src="images/setting_motion.gif" alt="" width="150" height="150" style="position:relative;"/>
                        </div>
                    	<form ACTION="<?php echo $loginFormAction; ?>" name="admin_login" id="admin_login" method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"></div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username"/>
                                </div>
							</div>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"></div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Password"/>
                                </div>
							</div>
                            
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"></div>
                                <div class="col-md-6 text-center">
                                	<button type="submit" class="btn btn-danger btn-lg" name="login" id="login" value="Sign up">
                                    	<span class="glyphicon glyphicon-flash"></span> <b>LOG IN</b>
                                    </button>
                                </div>
                        	</div>  
                    	</form>
					</div>
				</div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../jquery/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/jquery.validate.js"></script>
</body>
</html>