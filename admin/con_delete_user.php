<?php require_once('../Connections/Myconnection.php'); ?>
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
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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


$colname_user_delete = "-1";
if (isset($_GET['id_user'])) {
  $colname_user_delete = $_GET['id_user'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_user_delete = sprintf("SELECT * FROM `user` WHERE ID_user = %s", GetSQLValueString($colname_user_delete, "text"));
$user_delete = mysql_query($query_user_delete, $Myconnection) or die(mysql_error());
$row_user_delete = mysql_fetch_assoc($user_delete);
$totalRows_user_delete = mysql_num_rows($user_delete);
?>
<!DOCTYPE html>
<?php 
	$page_name="dashbord";
	include("../domain.php");
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $row_Myuser['Username']; ?></title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    <link href="css/style_intro.css" rel="stylesheet">-->
    <link href="../css/style_navbar-page.css" rel="stylesheet">
    <link href="../font/stylesheet.css" rel="stylesheet">
    <link href="../css/style_footer.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/style_boxOder.css" rel="stylesheet">
    <link href="../css/style_list_province.css" rel="stylesheet">

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
			  #Chang_ui{
				  display:none;
			  }
			  #detail_user{
				  font-size:22px;
			  }
		  }
		  .help-block{
			  font-size: 15px;
			  color: red;
		  }

	</style>

  </head>
<body class="bg-W2">

<?php 
include("../Navbar/level_navbar.php");
NavBar_L2();
include("../Navbar/navbar_admin.php");
?>

<div class="box-fullscreen">
	<div class="container" style="padding-left:0px; padding-right:0px;">
		<div class="col-lg-12" style="margin-top: 70px;">
			
		</div>
		
		<div class="col-lg-12" style="margin-top:0px; margin-bottom:60px;">
        
        	<?php include('menu_admin.php');?>
            
			<div class="col-lg-9 bg-W2 well" style="padding:0px;">
            	
  					<div>
                        <div class="panel bg-W1">
                            <div class="panel-heading text-center bg-danger">
                            
                            <h3 class="font text-size-24 text-danger"><b><span class="glyphicon glyphicon-trash text-danger"></span> ยืนยันการลบบัญชีนี้</b></h3>
                        </div>
                        <div class="panel-body">
                        	<div class="col-xs-6 col-xs-offset-3 text-center">
                                <form action="delete_user.php" name="delete_user" id="delete_user" method="POST" class="form-horizontal">
                                    <input class="form-control" type="password" name="pass_con" id="pass_con" placeholder="กรอกรหัส admin เพื่อยืนยัน">
                                    <br>
                                    <span class="text-R1 text-center font text-size-18"><b>#</b> การประกาศทั้งหมดของ <b><?php echo $row_user_delete['Username']; ?></b> จะถูกลบออกด้วย<br>และไม่สามรถกู้คืนได้ <b>#</b></span><br><br>
                                    <button class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-fire"></span> ยืนยัน</button>
                                    <input name="pass" id="pass" type="hidden" value="<?php echo $row_Myuser['Password']; ?>">
                                    <input name="id_user" id="id_user" type="hidden" value="<?php echo $_GET['id_user'];?>">
                                </form>
                            </div>
                        </div>
                    </div>                    
				</div>
                
			</div>
			
		</div>
		
<!------------------------------------------------------------------------->
	
		<div class="col-lg-12" style="">
			<div class="col-lg-12 bg-W2 well">
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
				HTMLFormElement('#delete_user').submit;
			}
		} );

		$( document ).ready( function () {
			$( "#delete_user" ).validate( {
				rules: {
					pass_con: {
						required: true,
						equalTo: "#pass"
					}					
				},
				messages: {
					pass_con: "ไม่ถูกต้อง"
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

		} );
</script>
</body>
</html>
<?php
mysql_free_result($Myuser);

mysql_free_result($user_delete);
?>

