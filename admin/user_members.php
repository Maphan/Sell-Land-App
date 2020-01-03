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


?>
<?php
mysql_select_db($database_Myconnection, $Myconnection);
$query_user_member = "SELECT * FROM user WHERE user.permission=2 ORDER BY ID DESC";
$user_member = mysql_query($query_user_member, $Myconnection) or die(mysql_error());
$row_user_member = mysql_fetch_assoc($user_member);
$totalRows_user_member = mysql_num_rows($user_member);
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
            
			<div class="col-lg-9 bg-W1 well" style="padding-top:5px;">
            	<div class="col-lg-12 " style="margin-top: 10px;">
                	<div class="col-lg-12 font text-size-28 text-center">
                        <span class="glyphicon glyphicon-bullhorn color-main2" style="margin-right: 8px;"></span><b>บัญชีผู้ใช้งาน(<?php echo $totalRows_user_member;?>)</b>
                    </div>
                </div>
                <hr>
                
                <div class="">
                
                	<?php do { ?>
               	    <div class="well text-center col-md-4" style="border: 1px solid #BCBCBC;">
                	    <form id="signinForm" action="#" enctype="multipart/form-data" method="post">
                	      <table width="100%" height="320px;" border="0" cellspacing="0" cellpadding="0">
                	        <tbody>
                	          <tr>
                	            <td valign="top" align="center" height="25%">
                	              <span class="glyphicon glyphicon-user color-main2" style="font-size: 40px;"></span>
                	              </td>
               	              </tr>
                	          <tr>
                	            <td id="detail_user" valign="top" height="21%" align="left" class="font text-size-20" style="padding-left:5px;">
                	              <div class="text-center">
                	                <span class="text-size-20"><b> <?php echo $row_user_member['Username'];?>
                	              </div>
                	              <span class="glyphicon glyphicon-envelope text-size-12 color-main1"></span><span><b> <?php echo $row_user_member['Email']; ?></b></span><br>
                	              <span class="glyphicon glyphicon-phone-alt text-size-12 color-main1"></span><span><b><?php echo $row_user_member['Phone1']; ?></b></span><br>
                	              <span class="glyphicon glyphicon-phone-alt text-size-12 color-main1"></span><span><b><?php echo $row_user_member['Phone2']; ?></b></span><br>
                	              <b><span class="color-main1">Line ID</span> : <?php echo $row_user_member['Line']; ?></b></span><br>
                	              
                	              <span><a target="_blank" href="<?php echo $row_user_member['FB']; ?>"><b>Facebook</b></a></span><br>
               	                </td>
               	              </tr>
                	          <tr>
                	            <td valign="top" height="15%" align="left">&nbsp;
                	              <textarea name="" cols="" rows="3" readonly class="form-control"><?php echo $row_user_member['Address']; ?></textarea>
                                  <br>
                	              </td>
               	              </tr>
                	          <tr>
                	            <td valign="top" align="center">
                	              <a href="profile.php?id_user=<?php echo $row_user_member['ID_user']; ?>" type="submit" class="btn btn-danger" style="width:80%;"><span class="glyphicon glyphicon-bullhorn"></span>ประกาศ</a>
               	                </td>
                	          <tr>
                	            <td valign="top" align="center">
                	              <a href="edit_profile.php?id_user=<?php echo $row_user_member['ID_user']; ?>" type="submit" class="btn btn-danger" style="width:80%;"><span class="glyphicon glyphicon-wrench"></span>แก้ไขข้อมูล</a>
               	                </td>
               	              </tr>
                              <tr>
                	            <td valign="top" align="center">
                	              <a href="con_delete_user.php?id_user=<?php echo $row_user_member['ID_user']; ?>" type="submit" class="btn btn-danger" style="width:80%;"><span class="glyphicon glyphicon-trash"></span>ลบ</a>
               	                </td>
               	              </tr>
               	              </tr>					
               	            </tbody>
                	        </table>
                	      </form>
               	      </div>
                	  <?php } while ($row_user_member = mysql_fetch_assoc($user_member)); ?>
                    
                    
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
				alert( "submitted!" );
			}
		} );

		$( document ).ready( function () {
			$( "#signinForm" ).validate( {
				rules: {
					username: {
						required: true,
						email: true
					},
					password: {
						required: true,
						minlength: 5
					},
					
				},
				messages: {
					username: "อีเมลของคุณไม่ถูกต้อง",
					password: {
						required: "ยังไม่กรอกรหัสผ่าน",
						minlength: "ต้องมี 6 ตัวขึ้นไป"
					},
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

mysql_free_result($user_member);
?>

