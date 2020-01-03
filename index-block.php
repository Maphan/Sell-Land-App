<?php require_once('Connections/Myconnection.php'); ?>

<!----------------------- Myuser ---------------------------->
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

$colname_Myuser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Myuser = $_SESSION['MM_Username'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_Myuser = sprintf("SELECT * FROM `user` WHERE Email = %s", GetSQLValueString($colname_Myuser, "text"));
$Myuser = mysql_query($query_Myuser, $Myconnection) or die(mysql_error());
$row_Myuser = mysql_fetch_assoc($Myuser);
$totalRows_Myuser = mysql_num_rows($Myuser);
?>
<!-------------------------end Myuser---------------->


<!DOCTYPE html>
<?php 
	$page_name="index";
	include("domain.php");
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>TINNY</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="css/style_intro.css" rel="stylesheet">
    <link href="css/style_navbar.css" rel="stylesheet">
    <link href="font/stylesheet.css" rel="stylesheet">
    <link href="css/style_footer.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="jquery/jquery.min.js"></script>
      
	  <style type="text/css">
		  html,body{
			  width: 100%;
			  height: 100%;
			  padding: 0;
			  margin: 0;
			  overflow: hidden;
			  overflow-x: hidden;
			  overflow-y: hidden;
			  
		  }
		  @media (max-width: 767px){
			  html,body{
			  width: 100%;
			  height: 100%;
			  padding: 0;
			  margin: 0;
			  overflow: visible;
			  overflow-x: visible;
			  overflow-y: visible;  
			  }
		  }
	  </style>
  </head>
<body>

<?php 
include("Navbar/level_navbar.php");
NavBar_L1();
include("Navbar/navbar.php"); 
?>
<div class="phoneONhid" style="width: 100%;height: 100px; background-color: #C1C1C1;">
	
</div>
<div class="gb_intro">
	<div class="inner">
		<div class="content">
			<div class="col-lg-12 box_img_intro">
				<div class="col-lg-6 ">
					<a class="cursor" href="Post/">
						<img class="img-responsive img_sell" src="images/intro/sell.png"></img >
					</a>
				</div>
				<div class="col-lg-6 box_img_intro">
					<a class="cursor" href="buy.php">
						<img class="img-responsive img_buy" src="images/intro/buy.png"></img>
					</a>
				</div>
			</div>
			
		</div>
	</div>	
		<div class="inner_buttom">
			<div class="content phoneONhid">
           		<!--<a class="button btn btn-lg btn_signin" href="SignIn.php">SIGN IN</a>-->
            	<form action="buy.php" method="get" enctype="multipart/form-data">
					<div class="input-group">
                    	<input type="text" class="form-control" style="font-size: 20px; background-color: rgba(255,255,255,0.6);" id="title" name="title" placeholder="คำค้นหา...">
                    	<span class="input-group-btn">
                        	<button class="btn btn-warning" type="submit" style="opacity:1;"><span class="glyphicon glyphicon-search "></span></button>
                    	</span>
                	</div>
				</form>
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
</body>
</html>
<?php
mysql_free_result($Myuser);
?>
