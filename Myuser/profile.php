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
$colname_Myuser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Myuser = $_SESSION['MM_Username'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_Myuser = sprintf("SELECT * FROM `user` WHERE Email = %s", GetSQLValueString($colname_Myuser, "text"));
$Myuser = mysql_query($query_Myuser, $Myconnection) or die(mysql_error());
$row_Myuser = mysql_fetch_assoc($Myuser);
$totalRows_Myuser = mysql_num_rows($Myuser);

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_All_Order = 18;
$pageNum_All_Order = 0;
if (isset($_GET['pageNum_All_Order'])) {
  $pageNum_All_Order = $_GET['pageNum_All_Order'];
}
$startRow_All_Order = $pageNum_All_Order * $maxRows_All_Order;

mysql_select_db($database_Myconnection, $Myconnection);
$uer=$row_Myuser['ID_user'];
$query_All_Order = "SELECT * FROM post WHERE ID_user = '$uer' ORDER BY ID DESC";
$query_limit_All_Order = sprintf("%s LIMIT %d, %d", $query_All_Order, $startRow_All_Order, $maxRows_All_Order);
$All_Order = mysql_query($query_limit_All_Order, $Myconnection) or die(mysql_error());
$row_All_Order = mysql_fetch_assoc($All_Order);

if (isset($_GET['totalRows_All_Order'])) {
  $totalRows_All_Order = $_GET['totalRows_All_Order'];
} else {
  $all_All_Order = mysql_query($query_All_Order);
  $totalRows_All_Order = mysql_num_rows($all_All_Order);
}
$totalPages_All_Order = ceil($totalRows_All_Order/$maxRows_All_Order)-1;
$amount_row_ALL_Order=$totalRows_All_Order;
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
include("../Navbar/navbar.php");
?>

<div class="box-fullscreen">
	<div class="container" style="padding-left:0px; padding-right:0px;">
		<div class="col-lg-12" style="margin-top: 85px;">
			
		</div>
		
		<div class="col-lg-12" style="margin-top:0px; margin-bottom:60px;">
        	<div class="col-lg-3">
				<div class="well text-center" style="border: 1px solid #BCBCBC;">
					<form id="signinForm" action="#" enctype="multipart/form-data" method="post">
				  		<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
			<div class="col-lg-9 bg-W1 well" style="padding-top:5px;">
            	<div class="col-lg-12 " style="margin-top: 10px;">
                	<div class="col-lg-9 font text-size-28 text-center">
                        <span class="glyphicon glyphicon-bullhorn color-main2" style="margin-right: 8px;"></span><b>ประกาศของฉัน (<?php echo $amount_row_ALL_Order; ?>)</b>
                    </div>
                    <div id="Chang_ui" class="btn-group col-md-3">
                    <a onclick="UI_list()" id="list_btn" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-th-list"></span>List</a> 
                    <a onclick="UI_grid()" id="grid-btn" class="btn btn-default btn-sm active">
                       <span class="glyphicon glyphicon-th"></span>Grid</a>
                    </div>
                </div>
                <hr>
  				<div style="padding-top:20px;">
					<div id="products" class="row list-group box_oder-grid">
					   <?php if($row_All_Order['ID_post']!=NULL){?>
                       	<?php do { ?>
                   	    <?php 
							// Province
							$pravince=$row_All_Order['Pravince'];
							mysql_select_db($database_Myconnection, $Myconnection);
							$query_Province = "SELECT * FROM province WHERE PROVINCE_ID = '$pravince'";
							$Province = mysql_query($query_Province, $Myconnection) or die(mysql_error());
							$row_Province = mysql_fetch_assoc($Province);
							$totalRows_Province = mysql_num_rows($Province);
							// img_post
							$id_post=$row_All_Order['ID_post'];
							mysql_select_db($database_Myconnection, $Myconnection);
							$query_Img_Post = "SELECT * FROM img_post WHERE ID_post = '$id_post'";
							$Img_Post = mysql_query($query_Img_Post, $Myconnection) or die(mysql_error());
							$row_Img_Post = mysql_fetch_assoc($Img_Post);
							$totalRows_Img_Post = mysql_num_rows($Img_Post);
							// visit_post
							mysql_select_db($database_Myconnection, $Myconnection);
							$query_visit_post = "SELECT * FROM visit_post WHERE id_post = '$id_post'";
							$visit_post = mysql_query($query_visit_post, $Myconnection) or die(mysql_error());
							$row_visit_post = mysql_fetch_assoc($visit_post);
							$totalRows_visit_post = mysql_num_rows($visit_post);
				
							//page nect-per
							$queryString_All_Order = "";
							if (!empty($_SERVER['QUERY_STRING'])) {
							  $params = explode("&", $_SERVER['QUERY_STRING']);
							  $newParams = array();
							  foreach ($params as $param) {
								if (stristr($param, "pageNum_All_Order") == false && 
									stristr($param, "totalRows_All_Order") == false) {
								  array_push($newParams, $param);
								}
							  }
							  if (count($newParams) != 0) {
								$queryString_All_Order = "&" . htmlentities(implode("&", $newParams));
							  }
							}
							$queryString_All_Order = sprintf("&totalRows_All_Order=%d%s", $totalRows_All_Order, $queryString_All_Order);
						?>
                        <?php // result img
							$name_img="";
							if($row_Img_Post['img1']!=NULL){
								$name_img=$row_Img_Post['img1'];
							}else if($row_Img_Post['img2']!=NULL){
								$name_img=$row_Img_Post['img2'];
							}else if($row_Img_Post['img3']!=NULL){
								$name_img=$row_Img_Post['img3'];
							}else if($row_Img_Post['img4']!=NULL){
								$name_img=$row_Img_Post['img4'];
							}else if($row_Img_Post['img5']!=NULL){
								$name_img=$row_Img_Post['img5'];
							}else if($row_Img_Post['img6']!=NULL){
								$name_img=$row_Img_Post['img6'];
							}else{$name_img='../no_img.jpg';}
						
						?>
                       	  
                       	  <div id="" class="list-group-item col-xs-4 col-lg-4">
                       	    <div class="thumbnail">
                       	      
                       	      <!--               		<img class="group list-group-image" src="images/bg_intro.jpg" alt="" />-->
                       	      <div id="box_img" class="group list-group-image">
								  <div style="display: inline;">
                      	        	<a href="../view_order.php?id_order=<?php echo $row_All_Order['ID_post']; ?>"><img class="" src="../Post/images/<?php echo $row_All_Order['ID_post']; ?>/<?php echo $name_img; ?>" alt="" /></a>
                      	      	  </div>
                       	      </div>
                       	      
                       	      <div class="caption box_caption">
                      	        <div id="box_title" style="height: 60px;">
									<a href="../view_order.php?id_order=<?php echo $row_All_Order['ID_post']; ?>">
									  <p id="title" class="group inner list-group-item-heading"><b><?php echo $row_All_Order['Title']; ?></p>
									</a>
								</div>
                       	        <p class="group inner list-group-item-text">
                       	          <span id="icon" class="glyphicon glyphicon-usd"  style="margin-right: 8px;"></span></b>
                       	          <span id="price">ราคา <?php if($row_All_Order['Price']!=0){echo number_format($row_All_Order['Price']);echo " บาท";}else{echo "ไม่ระบุ";}?></span><br>
                       	          <span id="icon" class="glyphicon glyphicon-th-large" style="margin-right: 8px;"></span>
                       	          <span id="sellMan" class="text-detail font">ขนาด 
                       	            <?php if($row_All_Order['area_size_rai']!=NULL){echo $row_All_Order['area_size_rai']. "&nbsp;ไร่";}else{} ?> 
                       	            <?php if($row_All_Order['area_size_ngan']!=NULL){echo $row_All_Order['area_size_ngan']. "&nbsp;งาน";}else{} ?>
                       	            <?php if($row_All_Order['area_size_var']!=NULL){echo $row_All_Order['area_size_var']. "&nbsp;ตร.วา";}else{} ?>
                   	              </span><br>
                       	          <span id="icon" class="glyphicon glyphicon-map-marker" style="margin-right: 8px;"></span>
                       	          <span id="location" class="text-detail font"><?php echo $row_All_Order['Post_type']; ?> <?php echo $row_All_Order['Property_type']; ?> ที่ <?php echo $row_Province['PROVINCE_NAME']; ?></span><br>
                       	          <span id="icon" class="glyphicon glyphicon-eye-open" style="margin-right: 8px;"></span>
                       	          <span id="location" class="text-detail font">เข้าชม <?php echo $row_visit_post['visit']; ?> ครั้ง</span>
                       	          </p>
                       	        <div class="row" style="padding-top:5px;">
                       	          <div class="col-xs-12 col-md-12 text-center">
                                  	<form action="../Post/edit_post.php" method="post" enctype="multipart/form-data" >
										<a id="btn_view" class="btn btn-danger btn-sm" href="../view_order.php?id_order=<?php echo $row_All_Order['ID_post']; ?>">รายระเอียด</a>
										<input name="id_post" type="hidden" value="<?php echo $row_All_Order['ID_post']; ?>">
										<input name="pass" type="hidden" value="<?php echo $row_All_Order['pass']; ?>">
										<button type="submit" class="btn btn-sm btn-danger" name="submit"><span class="glyphicon glyphicon-cog"></span>แก้ไข/ลบ</button>
                                	</form>
                       	            </b>
                       	            </div>
                       	          </div>
                       	        </div>
                       	      </div>
                   	      </div>
                       	  <?php } while ($row_All_Order = mysql_fetch_assoc($All_Order));
						  	mysql_free_result($Province);
							mysql_free_result($Img_Post);
						  ?>
                        	
					</div>
                    <div class="col-md-12 text-center">
                    	<div class="col-md-12 text-center" style="padding-bottom:20px;">
                        	<span class="badge bg-main2"><?php echo $pageNum_All_Order+1;?></span>
                        </div>
                    	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center" valign="middle">
                            	<table width="" border="0">
                                    <tr>
                                      <td align="center"><?php if ($pageNum_All_Order > 0) { // Show if not first page ?>
                                          <a class="btn btn-default" href="<?php printf("%s?pageNum_All_Order=%d%s", $currentPage, max(0, $pageNum_All_Order - 1), $queryString_All_Order); ?>">Previous <span class="glyphicon glyphicon-step-backward"></span>
                                           </a>
                                          <?php }else{ // Show if not first page ?>
                                          	<span class="btn btn-block">Previous <span class="glyphicon glyphicon-step-backward"></span></span>
                                          <?php }?>
                                       </td>
                                      <td align="center"><?php if ($pageNum_All_Order < $totalPages_All_Order) { // Show if not last page ?>
                                          <a class="btn btn-default" href="<?php printf("%s?pageNum_All_Order=%d%s", $currentPage, min($totalPages_All_Order, $pageNum_All_Order + 1), $queryString_All_Order); ?>"><span class="glyphicon glyphicon-step-forward"></span> Next</a>
                                           <?php }else{ // Show if not first page ?>
                                          	<span class="btn btn-block"><span class="glyphicon glyphicon-step-forward"></span> Next</span>
                                          <?php }?>
                                      </td>
                                    </tr>
                                  </table>
                            </td>
                          </tr>
                        </table>
						<?php }else{?>
                        	<div class="text-center alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-warning-sign text-size-45"></span><h3>คุณยังไม่มีประกาศ</h3>
                            </div>
                            <div class="text-center">
                            	<a class="btn btn-lg btn-info" href="../Post/">ลงประกาศ</a>
                            </div>
						<?php }?>
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
mysql_free_result($All_Order);



mysql_free_result($Myuser);
?>
