<?php require_once('../Connections/Myconnection.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
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

//update edit data

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if($_SESSION['MM_UserGroup']==1){
	$permission=1;
}else{$permission=2;}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "chang_pass")) {
	if($_POST['pass']==$row_Myuser['Password']){
	  $updateSQL = sprintf("UPDATE user SET ID_user=%s, Username=%s, Email=%s, Password=%s, Phone1=%s, Phone2=%s, Line=%s, FB=%s, Address=%s, permission=$permission WHERE ID=%s",
						   GetSQLValueString($row_Myuser['ID_user'], "text"),
						   GetSQLValueString($row_Myuser['Username'], "text"),
						   GetSQLValueString($row_Myuser['Email'], "text"),
						   GetSQLValueString($_POST['password_new'], "text"),
						   GetSQLValueString($row_Myuser['Phone1'], "text"),
						   GetSQLValueString($row_Myuser['Phone2'], "text"),
						   GetSQLValueString($row_Myuser['Line'], "text"),
						   GetSQLValueString($row_Myuser['FB'], "text"),
						   GetSQLValueString($row_Myuser['Address'], "text"),
						   GetSQLValueString($row_Myuser['ID'], "int"));
	
	  mysql_select_db($database_Myconnection, $Myconnection);
	  $Result1 = mysql_query($updateSQL, $Myconnection) or die(mysql_error());
	
	  $updateGoTo = "finish.php?suc=1";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $updateGoTo));
	  
	}else{header('Location: finish.php?suc=0');}
}


$currentPage = $_SERVER["PHP_SELF"];

?>
<!DOCTYPE html>
<?php 
	$page_name="profile";
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
include("../Navbar/navbar.php");
?>

<div class="box-fullscreen">
	<div class="container" style="padding-left:0px; padding-right:0px;">
		<div class="col-lg-12" style="margin-top: 85px;">
			
		</div>
		
		<div class="col-lg-12" style="margin-top:0px; margin-bottom:60px;">
        	<div class="col-lg-3">
				<div class="well text-center" style="border: 1px solid #BCBCBC;">
					<form id="signinForm" enctype="multipart/form-data" method="post">
				  		<table width="100%" height="320px;" border="0" cellspacing="0" cellpadding="0">
						  <tbody>
							<tr>
								<td valign="top" align="center" height="25%">
									<span class="glyphicon glyphicon-user color-main2" style="font-size: 60px;"></span><br><br>
								</td>
							</tr>
							<tr>
							  <td id="detail_user" valign="top" height="21%" align="left" class="font text-size-20" style="padding-left:5px;">
                              		<div class="text-center">
							  	 		<span class="text-size-22"><b><?php echo $row_Myuser['Username']; ?></b></span><hr></div>
                                    <span class="glyphicon glyphicon-envelope text-size-12 color-main1"></span><span><b> <?php echo $row_Myuser['Email']; ?></b></span><br>
                                    <span class="glyphicon glyphicon-phone-alt text-size-12 color-main1"></span><span><b><?php echo $row_Myuser['Phone1']; ?></b></span><br>
                                    <?php if($row_Myuser['Phone2']!=NULL){?>
                                    <span class="glyphicon glyphicon-phone-alt text-size-12 color-main1"></span><span><b><?php echo $row_Myuser['Phone2']; ?></b></span><br><?php }else{}?>
                                    <?php if($row_Myuser['Line']!=NULL){?>
                                    <b><span class="color-main1">Line ID</span> : <?php echo $row_Myuser['Line']; ?></b></span><br><?php }else{}?>
                                     <?php if($row_Myuser['FB']!=NULL){?>
                                    <span><a target="_blank" href="<?php echo $row_Myuser['FB']; ?>"><b>Facebook</b></a></span><br><?php }else{}?>
							  </td>
							</tr>
                            <?php if($row_Myuser['Address']!=NULL){ ?>
							<tr>
                	            <td valign="top" height="15%" align="left">&nbsp;
                	              <textarea name="" cols="" rows="3" readonly class="form-control"><?php echo $row_Myuser['Address']; ?></textarea>
                                  <br>
                	              </td>
               	            </tr>
                            <?php }else{}?>
							<tr>
							  <td valign="top" align="center">
								 <a href="chang_pass.php" type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-lock"></span>เปลี่ยนรหัสผ่าน</a>
							  </td>
							</tr>
							
						  </tbody>
						</table>
					</form>
				</div>
				
                <a href="profile.php" class="btn btn-warning" style="width:100%; margin-bottom:5px;">
                	<span class="glyphicon glyphicon-bullhorn"></span>ประกาศของฉัน
                </a>
                <a href="edit_profile.php" class="btn btn-warning" style="width:100%; margin-bottom:20px;">
                	<span class="glyphicon glyphicon-pencil"></span>แก้ไขข้อมูล
                </a>
                
			</div>
			<div class="col-lg-9 bg-W2 well" style="padding:0px;">
            	
  					<div>
                        <div class="panel bg-W1" style="margin-bottom: 0px;">
                            <div class="panel-heading text-center bg-main2">
                            
                            <h3 class="font text-W1 text-size-24"><span class="glyphicon glyphicon-lock text-W1"></span> เปลี่ยนรหัสผ่าน</h3>
                        </div>
                        <div class="panel-body">
                            <form action="<?php echo $editFormAction; ?>" name="chang_pass" id="chang_pass" method="POST" class="form-horizontal">
                            	
                                <div id="panel" class="col-md-12">	
                                    <div id="lable" class="col-md-4">รหัสผ่าน</div>
                                    <div class="col-md-4">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน" />
                                    </div>
                                </div>
                                <div id="panel" class="col-md-12">	
                                    <div id="lable" class="col-md-4">รหัสผ่านใหม่</div>
                                    <div class="col-md-4">
                                        <input type="password" class="form-control" id="password_new" name="password_new" placeholder="รหัสผ่านใหม่" />
                                    </div>
                                </div>
                                <div id="panel" class="col-md-12">	
                                    <div id="lable" class="col-md-4">ยืนยันรหัสผ่านใหม่</div>
                                    <div class="col-md-4">
                                        <input type="password" class="form-control" id="password_new_con" name="password_new_con" placeholder="ยืนยันรหัสผ่านใหม่" />
                                    </div>
                                </div>
                                <div id="panel" class="col-md-12">	
                                    <div id="lable" class="col-md-4"></div>
                                    <div class="col-md-8" id="box_submit">
                                           <button type="submit" class="btn btn-main" name="save" value="save"><span class="glyphicon glyphicon-floppy-saved"></span>บันทัก</button>
                                    </div>
                                </div>
                                <input id="id" name="id" type="hidden" value="<?php echo $row_Myuser['ID']; ?>">
                                <input id="pass" name="pass" type="hidden" value="<?php echo $row_Myuser['Password']; ?>">
                                <input type="hidden" name="MM_update" value="chang_pass">
                                
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
			$( "#chang_pass" ).validate( {
				rules: {
					password:{
						required: true,
						equalTo: "#pass"
					},
					password_new:{
						required: true,
						minlength: 6,
						maxlength: 16
					},
					password_new_con:{
						required: true,
						equalTo: "#password_new"
					}
				},
				messages: {
					password: "ไม่ถูกต้อง",
					password_new: "ไม่ถูกต้อง",
					password_new_con: "ไม่ถูกต้อง",
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
?>
