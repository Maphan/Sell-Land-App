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
$colname_Myuser=-1;
if (isset($_SESSION['MM_Username'])) {
  $colname_Myuser = $_SESSION['MM_Username'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_Myuser = sprintf("SELECT * FROM user WHERE Email = %s", GetSQLValueString($colname_Myuser, "text"));
$Myuser = mysql_query($query_Myuser, $Myconnection) or die(mysql_error());
$row_Myuser = mysql_fetch_assoc($Myuser);
$totalRows_Myuser = mysql_num_rows($Myuser);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_post")) {
	$idpost=$_POST['id_post'];
	if($_POST['price']==NULL){$price=0;}else{$price=$_POST['price'];}
	$t=$_POST['detail'];
	$TEXT= str_replace("\n", "<br>\n", "$t");
	$pass=$_POST['pass'];
  	$insertSQL1 = sprintf("INSERT INTO post (ID_post, ID_user, Post_type, Property_type, Title, area_size_rai, area_size_ngan, area_size_var, Price, Geography, Pravince, District, Amphur, Latitude, Longitude, Other, `Date`, `Time`, pass) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, '$pass')",
                       GetSQLValueString($_POST['id_post'], "text"),
                       GetSQLValueString($_POST['id_user'], "text"),
                       GetSQLValueString($_POST['post_type'], "text"),
                       GetSQLValueString($_POST['property_type'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['area_size_rai'], "int"),
                       GetSQLValueString($_POST['area_size_ngan'], "int"),
                       GetSQLValueString($_POST['area_size_var'], "double"),
                       GetSQLValueString($price, "int"),
                       GetSQLValueString($_POST['GEO'], "text"),
                       GetSQLValueString($_POST['province'], "text"),
                       GetSQLValueString($_POST['district'], "text"),
                       GetSQLValueString($_POST['amphur'], "text"),
                       GetSQLValueString($_POST['lat'], "text"),
                       GetSQLValueString($_POST['lng'], "text"),
                       GetSQLValueString($TEXT, "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['time'], "date"));
	$insertSQL2 = sprintf("INSERT INTO visit_post (id_post, visit) VALUES ('$idpost', '0')");
	$insertSQL3 = sprintf("INSERT INTO contact (ID_post, Name, Email, Tel_1, Tel_2, Line_id, Facebook, Address) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($idpost, "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone_1'], "text"),
                       GetSQLValueString($_POST['phone_2'], "text"),
                       GetSQLValueString($_POST['line_ID'], "text"),
                       GetSQLValueString($_POST['facebook'], "text"),
                       GetSQLValueString($_POST['address'], "text"));
	
  	mysql_select_db($database_Myconnection, $Myconnection);
  	$Result1 = mysql_query($insertSQL1, $Myconnection) or die(mysql_error());
	$Result2 = mysql_query($insertSQL2, $Myconnection) or die(mysql_error());
	$Result3 = mysql_query($insertSQL3, $Myconnection) or die(mysql_error());

  	$insertGoTo = "success.php?id_order=".$_POST['id_post'];
  	if (isset($_SERVER['QUERY_STRING'])) {
  	  $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
  	  $insertGoTo .= $_SERVER['QUERY_STRING'];
  	}
	include("sendmail_post.php");
  	header(sprintf("Location: %s", $insertGoTo));
}

?>
<!DOCTYPE html>
<?php 
	$page_name="post";
	include("../domain.php");
?>

<!-----  set string ---------->
<?php
	date_default_timezone_set('Asia/Bangkok');
	$id_post=date('dmYHis').rand(0,999999); //20ตัว
	$img1_name=$id_post.'1';
	$img2_name=$id_post.'2';
	$img3_name=$id_post.'3';
	$img4_name=$id_post.'4';
	$img5_name=$id_post.'5';
	$img6_name=$id_post.'6';
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ลงประกาศ</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    <link href="css/style_intro.css" rel="stylesheet">-->
    <link href="../css/style_navbar-page.css" rel="stylesheet">
    <link href="../font/stylesheet.css" rel="stylesheet">
    <link href="../css/style_footer.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/style_mapAPI.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="../jquery/jquery.min.js"></script>
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
				  color:#666;
			  }
		  #track{
				  color:#F00;
				  display:none;
			  }
		  .inputfile {
				width: 0.1px;
				height: 0.1px;
				opacity: 1;
				overflow: hidden;
				position: absolute;
				z-index: -1;
			}
		.inputfile + label {
				cursor: pointer; 
				font-size: 1.25em;
				font-weight: 700;
				color: white;
				background-color: black;
				display: inline-block;
				padding:5px;
				background-color: #0F976E;
				width:100%;
			}
			
		.inputfile:focus + label,
		.inputfile + label:hover {
				background-color: #0C7F5C;
			}
		
		  @media (max-width: 768px) {
			  #lable{
				  margin-top:5px;
				  text-align: left;
			  }
			  .phone-onHid{
				  display:none;
			  }

			.container {
				padding:0px;
			}
			.container-fluid{
				padding:0px;
			}
		}
		  
	</style>

  </head>
<body>

<?php 
include("../Navbar/level_navbar.php");
NavBar_L2();
include("../Navbar/navbar.php"); 
?>

<div class="bg-W1 container-fluid">
	<div class="container" style="padding-top: 90px; padding-bottom: 50px;">
		<div class="col-sm-3">
        	<div class="well" style="border:1px dashed #ccc; background-color:transparent !important; padding:8px !important;">
            	<div class="text-center font text-size-20 color-main1" style="border-bottom:1px solid #F0F0F0; padding-bottom:5px"><span class="glyphicon glyphicon-link text-size-18"></span> <b>ข้อตกลงในการลงประกาศ</b></div>
                <p class="cut-text ">
                	<li class="text-left font text-size-18">ลงประกาศซื้อขายเช่าที่ดินเท่านั้น ห้ามลงประกาศขายสินค้าไดๆ ทั้งสิ้นการซื้อขายเป็นการตกลงระหว่างผู้ซื้อกับผู้ขายเท่านั้นทางเว็บไซต์ไม่มีความเกี่ยวข้องกับการซื้อขายไดๆทั้งสิ้น</li>
                    <!--<li class="text-left font text-size-18">ห้ามลงประกาศในสิ่งที่ผิดกฎหมาย และศีลธรรม หรือเกี่ยวข้องกับสิ่งที่นำไปซึ่งสิ่งผิดกฎหมาย และศีลธรรม</li>-->
                    <li class="text-left font text-size-18">กรุณากรอกข้อมูลที่สามารถติดต่อได้จริง ที่ใช้ในการติดต่อกลับได้จริง</li>
                </p>
            </div>
            <?php if($row_Check_signin['Email']==NULL){?>
            <div class="well" style="border:1px dashed #ccc; background-color:transparent !important; padding:8px !important;">
            	<div class="text-center font text-size-20 color-main1" style="border-bottom:1px solid #F0F0F0; padding-bottom:5px"><span class="glyphicon glyphicon-info-sign text-size-17"></span><b> ข้อแนะนำ</b></div>
                <div class=" alert alert-warning">
                	<P class="cut-text font text-size-18">หากคุณเข้าสู่ระบบ คุณจะสามารถจัดการประกาศของคุณสะดวกและง่ายยิ่งขึ้น</P>
                    <p class="text-center"><a href="#login" data-toggle="modal" data-target="#myModal"> เข้าสู่ระบบ</a> | <a href="#" data-toggle="modal" data-target="#myModal2">สมุครสมาชิก</a></p>
              </div>
            </div>
            <?php }else{}?>
        </div>
		<div class="col-md-9">
			<form id="form_post" name="form_post" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data">
                <div class="panel panel-default">
					<div class="panel-heading text-center bg-B1">
					  <h3 class="font"><span class="glyphicon glyphicon-globe color-main1"></span><b> ข้อมูล อสังหาริมทรัพย์</b></h3>
 					</div>
					<div class="panel-body">
						<div id="panel" class="col-md-12">	
                            <div class="col-md-6" style="padding-bottom:15px;">
                            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="center" valign="middle"><span id="track">#&nbsp;</span>ประเภทประกาศ</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="middle" >
                                    	  <label>
                                    	    <input name="post_type" type="radio" id="post_type_0" value="ขาย" checked="CHECKED">
                                    	    ขาย</label>
                                    	  <label>
                                    	    <input type="radio" name="post_type" value="ให้เช่า" id="post_type_1">
                                    	    ให้เช่า</label>
                                     </td>
                                  </tr>
                                </table>
                            </div>
                            <div class="col-md-6" >
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="center" valign="middle"><span id="track">#&nbsp;</span>หมวดหมู่</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="middle" >
                                          <select name="property_type" class="form-control" style="width:120px;">
                                            <option value="ที่ดิน"  selected>ที่ดิน</option>
                                            <option value="บ้านเดี่ยว">บ้านเดี่ยว</option>
                                            <option value="คอนโด">คอนโด</option>
                                            <option value="อพาร์ทเมนท์">อพาร์ทเมนท์</option>
                                          </select>
                                    </td>
                                  </tr>
                                </table>
                            </div>
						</div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>หัวข้อประกาศ</div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"/>
                            </div>
						</div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ขนาดพื้นที้</div>
                            <div class="col-md-3">
                                <input type="number" class="form-control" id="area_size_rai" name="area_size_rai" placeholder="0" style=" padding-right:30px;"/>
                                <span class="form-control-feedback" style="margin-right:15px;">ไร่</span>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" id="area_size_ngan" name="area_size_ngan" placeholder="0" style=" padding-right:30px;"/>
                                <span class="form-control-feedback" style="margin-right:15px;">งาน</span>
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control" id="area_size_var" name="area_size_var" placeholder="0" style=" padding-right:35px;"/>
                                <span class="form-control-feedback" style="margin-right:20px;">ตร.วา</span>
                            </div>
						</div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ราคา</div>
                            <div class="col-md-4">
                                <input type="number" class="form-control" id="price" name="price" placeholder="Price" style=" padding-right:35px;"/>
                                <span class="form-control-feedback" style="margin-right:20px;">บาท</span>
                            </div>
						</div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ตำแหน่ง</div>
                            <div class="col-md-4" id="geography">
                                    <select class="form-control" name="GEO" id="GEO">
                                        <option value="">- เลือกภาค -</option>
                                    </select>
                            </div>
                            <div class="col-md-4" id="province">
                                    <select class="form-control" name="province" id="province" disabled>
                                    	<option value="">- เลือกจังหวัด -</option>
 									</select>
                            </div>
                        </div>
                        <div id="panel" class="col-md-12" style="padding-top:0px;">	
                            <div class="col-md-3 phone-onHid"></div>
                            <div class="col-md-4" id="amphur">
                                    <select class="form-control" name="amphur" id="amphur" disabled>
                                    	<option value="">- เลือกอำเภอ -</option>
 									</select>
                            </div>
                            <div class="col-md-4" id="district">
                                    <select class="form-control" name="district" id="district" disabled>
                                    	<option value="">- เลือกตำบล -</option>
 									</select>
                            </div>
						</div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>รายระเอียดอื่นๆ</div>
                            <div class="col-md-8">
                               <textarea name="detail" rows="6" maxlength="99999" class="form-control" id="detail" placeholder="Other..." ></textarea>
                            </div>
                        </div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ภาพประกอบ</div>
                            <div class="col-md-2 col-xs-offset-0">
                            	<span id="track" class="font text-size-18">(ขนาดไฟล์ไม่เกิน 8MB / ภาพ)</span>
                               <input type="file" name="img1" id="img1" class="font inputfile" >
                               <label for="img1" class="font"><span id="l1" class="glyphicon fa fa-download" >&nbsp;</span>เลือกรูป</label>
                            </div>
                            <div class="col-md-2">
                               <input type="file" name="img2" id="img2" class="font inputfile" >
                               <label for="img2" class="font"><span id="l2" class="glyphicon fa fa-download" >&nbsp;</span>เลือกรูป</label>
                            </div>
                            <div class="col-md-2">
                               <input type="file" name="img3" id="img3"  class="font inputfile" >
                               <label for="img3" class="font"><span id="l3" class="glyphicon fa fa-download" >&nbsp;</span>เลือกรูป</label>
                            </div>
                        </div>
                        <div id="panel" class="col-md-12" style="margin-top:0px; padding-top:0px">	
                            <div id="lable" class="col-md-3"></div>
                            <div class="col-md-2">
                               <input type="file" name="img4" id="img4"  class="font inputfile" >
                               <label for="img4" class="font"><span id="l4" class="glyphicon fa fa-download" >&nbsp;</span>เลือกรูป</label>
                            </div>
                            <div class="col-md-2">
                               <input type="file" name="img5" id="img5"  class="font inputfile" >
                               <label for="img5" class="font"><span id="l5" class="glyphicon fa fa-download" >&nbsp;</span>เลือกรูป</label>
                            </div>
                            <div class="col-md-2">
                               <input type="file" name="img6" id="img6"  class="font inputfile" >
                               <label for="img6" class="font"><span id="l6" class="glyphicon fa fa-download" >&nbsp;</span>เลือกรูป</label>
                            </div>
                        </div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3" style=" margin-right:15px;"><span id="track">#&nbsp;</span>พิกัด GPS</div>
                            <div id="map-search" class="col-md-6 input-group">
                                <input id="search-txt" type="text" maxlength="100" class="form-control" placeholder="ค้นหาด้วย ชื่อจังหวัด อำเภอ หรือ ตำบล">
								<span class="input-group-btn">
                                	<button id="search-btn" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
								</span>
                            </div>
                        </div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"></div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="lat" name="lat" placeholder="ละติจูด" />
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="lng" name="lng" placeholder="ลองจิจูด" />
                            </div>
                        </div>
                        <div id="panel" class="col-md-12">	
                            <div id="map-canvas" class="col-md-12"></div>
                        </div>
                        
					</div>
				</div>
			
			<!---------------------------------------------------->
				
				<div class="panel panel-default">
					<div class="panel-heading text-center bg-B1">
						
						<h3 class="font"><span class="glyphicon glyphicon-phone-alt color-main1"></span><b> ข้อมูลผู้ประกาศและการติดต่อ</b></h3>
 					</div>
					<div class="panel-body">
                    		<?php if($row_Myuser['Username']!=NULL){?>
							<div class=" text-center" >
								<p style="margin: 10px; padding-top: 10px;" class="font text-size-20"><b>คุณ <?php echo $row_Myuser['Username']; ?></b></p>
                                <input name="username" id="username" type="hidden" value="<?php echo $row_Myuser['Username']; ?>">
							</div>
                            <?php }else{?>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track"></span>ชื่อผู้ประกาศ</div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="your name" value="<?php echo $row_Myuser['Email']; ?>"/>
                                </div>
							</div>
                            <?php }?>
							<div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track"></span>อีเมล</div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row_Myuser['Email']; ?>"/>
                                </div>
							</div>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>เบอร์โทรติดต่อ</div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="phone_1" name="phone_1" placeholder="Telephone 1" value="<?php echo $row_Myuser['Phone1']; ?>"/>
                                </div>
							</div>
                            <div id="panel" class="col-md-12" style=" padding-top:8px;">	
                                <div id="lable" class="col-md-3"></div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="phone_2" name="phone_2" placeholder="Telephone 2" value="<?php echo $row_Myuser['Phone2']; ?>"/>
                                </div>
							</div>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ไลน์ ไอดี</div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="line_ID" name="line_ID" placeholder="Line ID" value="<?php echo $row_Myuser['Line']; ?>"/>
                                </div>
							</div>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ลิงค์ Facebook</div>
                                <div class="col-md-6">
                                    <input type="url" class="form-control" id="facebook" name="facebook" placeholder="https://" value="<?php echo $row_Myuser['FB']; ?>"/>
                                </div>
							</div>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ที่อยู่</div>
                                <div class="col-md-8">
                                    <textarea name="address" rows="5" maxlength="500" class="form-control" id="address" placeholder="Address"><?php echo $row_Myuser['Address']; ?></textarea>
                                </div>
                        	</div>
                            <?php if($row_Myuser['Password']==NULL){?>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>รหัสผ่านประกาศ</div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Password"/>
                                </div>
							</div>
                            <?php }else{?>
                            <input name="pass" type="hidden" value="<?php echo $row_Myuser['Password']; ?>">
							<?php }?>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"></div>
                                <div class="col-md-6">
                                  <span id="track" class="font text-size-19">*ข้อมูลการติดต่อจะถูกบันทึกลงข้อมูลส่วนตัวของท่าน เพื่อความสะดวกในครั้งต่อไป</span>
                                </div>
							</div>
							
					</div>
				</div>
                <div class="text-center" style=" margin-bottom:20px;">
                	<div class="progress progress-striped active">
                        <div class="progress-bar" style="width:0%"></div>
                    </div>
					<button name="submit" id="submit" type="submit" class="btn btn-main btn-lg"><span class="glyphicon glyphicon-tags"></span> บันทึก</button>
                </div>
                
                <input name="id_post" id="id_post" type="hidden" value="<?php echo $id_post;?>">
                <input name="img1_name" id="img1_name" type="hidden" value="<?php echo $img1_name;?>">
                <input name="img2_name" id="img2_name" type="hidden" value="<?php echo $img2_name;?>">
                <input name="img3_name" id="img3_name" type="hidden" value="<?php echo $img3_name;?>">
                <input name="img4_name" id="img4_name" type="hidden" value="<?php echo $img4_name;?>">
                <input name="img5_name" id="img5_name" type="hidden" value="<?php echo $img5_name;?>">
                <input name="img6_name" id="img6_name" type="hidden" value="<?php echo $img6_name;?>">
                <input name="id_user" id="id_user" type="hidden" value="<?php echo $row_Myuser['ID_user']; ?>">
                <input name="date" id="date" type="hidden" value="<?php echo date('Ymd');?>">
                <input name="time" id="time" type="hidden" value="<?php echo date('His');?>">
                <input type="hidden" name="MM_insert" value="form_post">
                <input type="hidden" name="MM_update" value="form_post">
			</form>
		</div>
	</div>
</div>



<?php include("../footer.php") ?>
 
 
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/jquery.validate.js"></script>
<script src="//maps.googleapis.com/maps/api/js?v=3&amp;sensor=false&amp;key=AIzaSyAFnIuLpTse2iNXtBDWhfHT5f7ATTCMWOw&amp;callback=loadmap" defer></script>
<script src="../js/map_API.js"></script>

<!---------------- Select location ------------------------>

<script language=Javascript>
        function Inint_AJAX() {
           try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
           try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
           try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
           alert("XMLHttpRequest not supported");
           return null;
        };

        function dochange(src, val) {
             var req = Inint_AJAX();
             req.onreadystatechange = function () { 
                  if (req.readyState==4) {
                       if (req.status==200) {
                            document.getElementById(src).innerHTML=req.responseText; //รับค่ากลับมา
                       } 
                  }
             };
             req.open("GET", "select_localtion.php?data="+src+"&val="+val); //สร้าง connection
             req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
             req.send(null); //ส่งค่า
        }

        window.onLoad=dochange('geography', -1);     
    </script>


<!---------------- check form ------------------------>
<script type="text/javascript">
		$.validator.setDefaults( {
			submitHandler: function () {

				HTMLFormElement("#form_post").submit;
			}
		} );

		$( document ).ready( function () {

			$( "#form_post" ).validate( {
				rules: {
					title: {
						required: true,
						maxlength:150
					},
					price:{
						//required: true,
						maxlength:10
					},
					GEO:{
						required: true
					},
					province:{
						required: true
					},
					amphur:{
						required: true
					},
					username:{
						required: true
					},
					email:{
						required: true,
						email: true
					},
					phone_1:{
						required: true
					},
					pass: {
						required: true,
						minlength: 6
					}
				},
				messages: {
					title: {
						required: "*ยังไม่กรอกหัวข้อ",
						maxlength: "*ไม่เกิน 80 ตัวอักษร"
					},
					price:{
						//required: "*ยังไม่กรอกราคา",
						maxlength: "*ไม่เกิน 10 ตัวอักษร"
					},
					GEO:{
						required: "*ยังไม่เลือกถูมิภาค"
					},
					province:{
						required: "*ยังไม่เลือกจังหวัด"
					},
					amphur:{
						required: "*ยังไม่เลือกอำเภอ"
					},
					username:{
						required: "*ยังไม่กรอกชื่อผู้ประกาศ"
					},
					email:{
						required: "*ยังไม่กรอกอีเมล",
						email: "*อีเมลไม่ถูกต้อง"
					},
					phone_1:{
						required: "*ยังไม่กรอกหมายเลขโทรศัพ"
					},
					pass: {
						required: "*ยังไม่กรอกรหัสผ่านประกาศ",
						minlength: "*ไม่ต่ำกว่า 6 อักษร"
					}
					
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					// Add `has-feedback` class to the parent div.form-group
					// in order to add icons to inputs
					element.parents( ".col-sm-5" ).addClass( "has-feedback" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}

					// Add the span element, if doesn't exists, and apply the icon classes to it.
					
				},
				success: function ( label, element ) {
					
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
					$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
				},
				unhighlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
					$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
				}
			} );
		} );
	</script>
    
<!---------------- form submit to file upload ------------------------>
<script type="text/javascript">

		$(document).on('submit','form',function(e){
			$form = $(this);
			uploadImage($form);
		});
		function uploadImage($form){
			$form.find('.progress-bar').removeClass('progress-bar-success')
										.removeClass('progress-bar-danger');
			var formdata = new FormData($form[0]); //formelement
			var request = new XMLHttpRequest();
			//progress event...
			request.upload.addEventListener('progress',function(e){
				var percent = Math.round(e.loaded/e.total * 100);
				$form.find('.progress-bar').width(percent+'%').html(percent+'%');
			});
			//progress completed load event
			request.addEventListener('load',function(e){
				$form.find('.progress-bar').addClass('progress-bar-success').html('upload completed');
			});
			//upload
			request.open('post', 'server.php');
			request.send(formdata);
			//cancel
			$form.on('click','.cancel',function(){
				request.abort();
				$form.find('.progress-bar').addClass('progress-bar-danger').removeClass('progress-bar-success').html('upload aborted...');
			});
		}
		
</script>

<!--- btn slect file -->
<script type="text/javascript">


setInterval(function(){ 
	var img1 = $('#img1').val();
	if(img1==''){
		$('#l1').removeClass("glyphicon-picture");
		$('#l1').addClass("fa fa-download");
	}else{
		$('#l1').removeClass("fa fa-download");
		$("#l1").addClass("glyphicon-picture");
	}
	
}, 10);
setInterval(function(){ 
	var img2 = $('#img2').val();
	if(img2==''){
		$('#l2').removeClass("glyphicon-picture");
		$('#l2').addClass("fa fa-download");
	}else{
		$('#l2').removeClass("fa fa-download");
		$("#l2").addClass("glyphicon-picture");
	}
}, 10);
setInterval(function(){ 
	var img3 = $('#img3').val();
	if(img3==''){
		$("#l3").removeClass("glyphicon-picture");
		$('#l3').addClass("fa fa-download");
	}else{
		$('#l3').removeClass("fa fa-download");
		$("#l3").addClass("glyphicon-picture");
	}
}, 10);
setInterval(function(){ 
	var img4 = $('#img4').val();
	if(img4==''){
		$('#l4').removeClass("glyphicon-picture");
		$('#l4').addClass("fa fa-download");
	}else{
		$('#l4').removeClass("fa fa-download");
		$('#l4').addClass("glyphicon-picture");
	}
}, 10);
setInterval(function(){ 
	var img5 = $('#img5').val();
	if(img5==''){
		$('#l5').removeClass("glyphicon-picture");
		$('#l5').addClass("fa fa-download");
	}else{
		$('#l5').removeClass("fa fa-download");
		$('#l5').addClass("glyphicon-picture");
	}
}, 10);
setInterval(function(){ 
	var img6 = $('#img6').val();
	if(img6==''){
		$('#l6').removeClass('glyphicon-picture');
		$('#l6').addClass("fa fa-download");
	}else{
		$('#l6').removeClass("fa fa-download");
		$('#l6').addClass("glyphicon-picture");
	}
}, 10);
</script>

<!-- set default map api -->
<script type="text/javascript">
var L1=13.759397; //lat
var L2=100.506768; //lng
</script>

</body>
</html>
<?php
mysql_free_result($Myuser);
?>
