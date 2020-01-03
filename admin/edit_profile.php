<?php require_once('../Connections/Myconnection.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$MM_restrictGoTo = "../index.php";
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
?>
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

//record myuser
$colname_Myuser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Myuser = $_SESSION['MM_Username'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_Myuser = sprintf("SELECT * FROM `user` WHERE Email = %s", GetSQLValueString($colname_Myuser, "text"));
$Myuser = mysql_query($query_Myuser, $Myconnection) or die(mysql_error());
$row_Myuser = mysql_fetch_assoc($Myuser);
$totalRows_Myuser = mysql_num_rows($Myuser);

//record edit_user
$colname_user_edit = "-1";
if (isset($_GET['id_user'])) {
  $colname_user_edit = $_GET['id_user'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_user_edit = sprintf("SELECT * FROM `user` WHERE ID_user = %s", GetSQLValueString($colname_user_edit, "text"));
$user_edit = mysql_query($query_user_edit, $Myconnection) or die(mysql_error());
$row_user_edit = mysql_fetch_assoc($user_edit);
$totalRows_user_edit = mysql_num_rows($user_edit);


//update edit data
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edit_data")) {
  $updateSQL = sprintf("UPDATE user SET ID_user=%s, Username=%s, Email=%s, Password=%s, Phone1=%s, Phone2=%s, Line=%s, FB=%s, Address=%s WHERE ID=%s",
                       GetSQLValueString($_POST['id_user'], "text"),
                       GetSQLValueString($_POST['Username'], "text"),
                       GetSQLValueString($row_user_edit['Email'], "text"),
                       GetSQLValueString($row_user_edit['Password'], "text"),
                       GetSQLValueString($_POST['phone_1'], "text"),
                       GetSQLValueString($_POST['phone_2'], "text"),
                       GetSQLValueString($_POST['line_ID'], "text"),
                       GetSQLValueString($_POST['facebook'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_Myconnection, $Myconnection);
  $Result1 = mysql_query($updateSQL, $Myconnection) or die(mysql_error());

  $updateGoTo = "finish.php?suc=1";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}



$currentPage = $_SERVER["PHP_SELF"];

?>
<!DOCTYPE html>
<?php 
	$page_name="edit_profile";
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
		  @media (max-width: 768px){
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
			  #lable{
				  margin-top:5px;
				  text-align: left;
			  }
			  .phone-onHid{
				  display:none;
			  }
			  #box_submit{
				  text-align:center;
			  }
		  }
		  .help-block{
			  font-size: 15px;
			  color: red;
		  }
		  .form-group{
			  margin-bottom: 0px;
			  height: 60px;
		  }
		  #panel{
			  padding-top:15px;
			  background-color: rgba(0, 0, 0, 0);
		  }
		  #lable{
			  	  margin-top:5px;
				  text-align:right;
			  }
		  #track{
				  color:#F00;
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
                            <div class="panel-heading text-center bg-main2">
                            
                            <h3 class="font text-W1 text-size-24"><span class="glyphicon glyphicon-pencil text-W1"></span> แก้ไขข้อมูล</h3>
                        </div>
                        <div class="panel-body">
                            <form action="<?php echo $editFormAction; ?>" name="edit_data" id="edit_data" method="POST" class="form-horizontal">
                            	<div id="panel" class="col-md-12">	
                                    <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ชื่อ</div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="Username" name="Username" placeholder="first name" value="<?php echo $row_user_edit['Username']; ?>"/>
                                    </div>
                                </div>
                                <div id="panel" class="col-md-12">	
                                    <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>เบอร์โทรติดต่อ</div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" id="phone_1" name="phone_1" placeholder="Telephone" value="<?php echo $row_user_edit['Phone1']; ?>"/>
                                    </div>
                                </div>
                                <div id="panel" class="col-md-12" style=" padding-top:8px;">	
                                    <div id="lable" class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" id="phone_2" name="phone_2" placeholder="Telephone" value="<?php echo $row_user_edit['Phone2']; ?>"/>
                                    </div>
                                </div>
                                <div id="panel" class="col-md-12">	
                                    <div id="lable" class="col-md-3">ไลน์ ไอดี</div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="line_ID" name="line_ID" placeholder="Line ID" value="<?php echo $row_user_edit['Line']; ?>"/>
                                    </div>
                                </div>
                                <div id="panel" class="col-md-12">	
                                    <div id="lable" class="col-md-3">ลิงค์ Facebook</div>
                                    <div class="col-md-6">
                                        <input type="url" class="form-control" id="facebook" name="facebook" placeholder="https://" value="<?php echo $row_user_edit['FB']; ?>"/>
                                    </div>
                                </div>
                                <div id="panel" class="col-md-12">	
                                    <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ที่อยู่</div>
                                    <div class="col-md-8">
                                        <textarea name="address" rows="5" maxlength="500" class="form-control" id="address" placeholder="Address" ><?php echo $row_user_edit['Address']; ?></textarea>
                                    </div>
                                </div>
                                
                                <div id="panel" class="col-md-12">
                                	<hr>	
                                    <div id="lable" class="col-md-3"></div>
                                    <div class="col-md-4">
                                        <input type="password" class="form-control" id="pass_con" name="pass_con" placeholder="กรอกรหัส admin เพื่อยืนยัน" />
                                    </div>
                                </div>
                                <div id="panel" class="col-md-12">	
                                    <div id="lable" class="col-md-3"></div>
                                    <div class="col-md-8" id="box_submit">
                                           <button type="submit" class="btn btn-main" name="save" value="save"><span class="glyphicon glyphicon-floppy-saved"></span>บันทัก</button>
                                    </div>
                                </div>  
                                <input id="id" name="id" type="hidden" value="<?php echo $row_user_edit['ID']; ?>">
                                <input id="id_user" name="id_user" type="hidden" value="<?php echo $row_user_edit['ID_user']; ?>">
                                <input id="email" name="email" type="hidden" value="<?php echo $row_user_edit['Email']; ?>">
                                <input id="pass" name="pass" type="hidden" value="<?php echo $row_Myuser['Password']; ?>">
                                <input type="hidden" name="MM_update" value="edit_data">
                            </form>
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
				HTMLFormElement("#signinForm").submit;
			}
		} );

		$( document ).ready( function () {
			$( "#edit_data" ).validate( {
				rules: {
					first_name: {
						required: true,
					},
					last_name: {
						required: true,
					},
					phone_1:{
						required: true,
						minlength: 8,
						maxlength: 13
					},
					phone_2:{
						maxlength: 13
					},
					pass_con:{
						required: true,
						equalTo: "#pass"
					}
					
				},
				messages: {
					first_name: "ไม่ถูกต้อง",
					last_name: "ไม่ถูกต้อง",
					phone_1: "ไม่ถูกต้อง",
					phone_2: "ไม่ถูกต้อง",
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

mysql_free_result($user_edit);
?>
