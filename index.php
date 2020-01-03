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
    <link href="images/favicon.png" rel="shortcut icon" type="image/x-icon" />
    <meta name="description" content="ขายที่ดูที่ ขายที่ดิน ประกาศขายที่ดินฟรี">
    <meta name="keywords" content="ขายที่ดูที่">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $Domain;?></title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
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
		  .box-fullscreen{
			  height: 100%;
			  background-color: #DDDDDD;
		  }
		  .barnner{
		  }
		  
		  .buy{
			  background-color: #2CA869 ;
		  }
		  .sell{
			  background-color: #CE38FF ;
		  }
		  .cover-navBar{
				  width: 100%;
				  height: 65px; 
				  background-color: #DDDDDD;
			  }
		  @media (min-width: 767px){ /* PC */
			  
			  .container{
				  padding-top:5px;
			  }
			  .btn-introMenu{
				  color: #FFF;
				  font-size: 30px;
				  width: 160px;
				  height: 160px;
				  border: 0px solid #FFF;
				  border-radius: 50%;
				  -moz-border-radius: 50%;
				  -webkit-border-radius: 50%;
				  transition: 0.3s;
		  	  }
			  .btn-introMenu:hover{
				  width: 160px;
				  height: 160px;
				  border: 10px solid #DD7E20;
		  	  }
		  }
		   @media (max-width: 767px){/* Phone */
			   html,body{
				   width: 100%;
				   height: 100%;
				   padding: 0;
				   margin: 0;
				   overflow: visible;
				   overflow-x: visible;
				   overflow-y: visible;	  
		  	   }
			   .btn-introMenu{
				  color: #FFF;
				  font-size: 24px;
				  width: 140px;
				  height: 140px;
				  border: 0px solid #FFF;
				  border-radius: 50%;
				  -moz-border-radius: 50%;
				  -webkit-border-radius: 50%;
				  transition: 0.3s;
		  	  }
			  .btn-introMenu:hover{
				  width: 140px;
				  height: 140px;
				  border: 7px solid #DD7E20;
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
<div class="cover-navBar"></div>
<div class="box-fullscreen">
	<div class="container text-center">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<img src="images/intro/banner1200.jpg" class="img-responsive barnner"/>
		</div>
		<div class="col-md-2"></div>
		<div style="margin-top: 10px; display: inline-block;">
			<div class="col-xs-6 text-right">
				<button class="btn-introMenu buy font text-size-34" onclick="goto('buy.php')">หาซื้อ / เช่า</button>
			</div>
			<div class="col-xs-6 text-left">
				<button class="btn-introMenu sell font text-size-34" onclick="goto('Post')">ลงประกาศ<br>ฟรี</button>
			</div>
		</div>
		<div class="col-md-12">
			<br>
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<form action="buy.php" method="get" enctype="multipart/form-data">
					<div class="input-group">
						<input type="text" class="form-control font" style="font-size: 20px; background-color: rgba(255,255,255,0.6);" id="title" name="title" placeholder="คำค้นหา...">
						<span class="input-group-btn">
							<button class="btn btn-warning" type="submit" style="opacity:1;"><span class="glyphicon glyphicon-search "></span></button>
						</span>
					</div>
				</form>
			</div>
			<div class="col-md-3"></div>
			
		</div>
		
	</div>
</div>

<nav class="navbar-fixed-bottom" style="background-color: #DDDDDD;">
	<?php include("footer.php") ?>
</nav> 
 
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/js/jquery.validate.js"></script>
<script type="text/javascript">
	function goto(url){
		window.location = url;
	}
</script>
</body>
</html>
<?php
mysql_free_result($Myuser);
?>
