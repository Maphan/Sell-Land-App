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

$colname_User = "-1";
if (isset($_POST['Email'])) {
  $colname_User = $_POST['Email'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_User = sprintf("SELECT * FROM `user` WHERE Email = %s", GetSQLValueString($colname_User, "text"));
$User = mysql_query($query_User, $Myconnection) or die(mysql_error());
$row_User = mysql_fetch_assoc($User);
$totalRows_User = mysql_num_rows($User);

?>

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
		  @media (max-width: 768px) {
			  #lable{
				  margin-top:5px;
				  text-align: left;
			  }
			  .phone-onHid{
				  display:none;
			  }
		  }
		  #imgloading{
			  position:absolute;
			  max-height:80px;
			  max-width:80px;
			  right:45%;
			  top:35%;
		  }
		  .show{
			  display:block;
		  }
		  .hid{
			  display:none;
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
	<div class="container center-block" style="padding-top: 130px; padding-bottom: 50px;">
		<div class="col-sm-8 col-sm-offset-2">
        <?php if($row_User['ID_user']!=NULL){?>
			<div class="panel" style="border:0px dashed #FFF;">
					<div class="panel-heading text-center alert-success">
						
						<h3 class="font"><span class="glyphicon glyphicon-question-sign"></span><b> นี้คือชื่อของคุณใช่หรือไม่</b></h3>
 					</div>
					<div class="panel-body">
                    		<img id="imgloading" src="../images/loading.gif" class="hid" />
                    		<div id="result">
                                <div id="panel" class="col-md-12 text-center text-size-18">
                                    <span class="glyphicon glyphicon-user color-main1"></span>&nbsp; 
                                        <?php echo $row_User['Username']; ?>
                                </div>
                                <?php if($row_User['Phone1']!=NULL){?>
                                <div id="panel" class="col-md-12 text-center text-size-18">
                                    <span class="glyphicon glyphicon-phone-alt color-main1"></span>&nbsp; 
                                        <?php echo $row_User['Phone1']; ?>
                                </div>
                                <?php }else{}?>
                            </div>
                            <div id="panel" class="col-md-12">
                            	<hr>	
                                <div class="col-md-12 text-center">
                                       <button id="btn_sendmail" class="btn btn-main btn-lg" onClick="sentmail()" ><span class="glyphicon glyphicon-ok-sign"></span> <b>ใช่ นี้คือฉัน</b></button>
                                </div>
                        	</div>  

					</div>
				</div>
                <input id="e" type="hidden" value="<?php echo $row_User['Email']; ?>">
                <input id="p" type="hidden" value="<?php echo $row_User['Password']; ?>">
            <?php }else{?>
            	<div class="text-center alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-warning-sign text-size-45"></span><h3>ไม่พบอีเมลนี้ในระบบ</h3>
                </div>
                <div class="text-center">
                	<a class="btn btn-danger btn-lg" href="index.php">ลองอีกครั้ง</a>
                </div>
            <?php }?>
                
		</div>
	</div>
</div>

<nav class="navbar-fixed-bottom ">
	<?php include("../footer.php") ?>
</nav> 

 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
//---ajax send mail---//
function sentmail(){
	$('#imgloading').addClass("show");
	var e='<?php echo $row_User['Email']; ?>';
	var p='<?php echo $row_User['Password']; ?>';
	var uname='<?php echo $row_User['Username']; ?>';
	$.post('sendmail.php',{email:e,pass:p,name:uname},
		function(data){
			$('#result').html(data);
			$('#imgloading').removeClass("show");
			$('#imgloading').addClass("hid");
			$('#btn_sendmail').html('ส่งอีกครั้ง');
		});
}
</script>
</body>
</html>

<?php mysql_free_result($User);//สิ้นสุดการ query User?>