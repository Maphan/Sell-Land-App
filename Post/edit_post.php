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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form_edit")) {
  $id_post=$_POST['id_post'];
  $name=$_POST['username'];
  $email=$_POST['email'];
  $tel1=$_POST['phone_1'];
  $tel2=$_POST['phone_2'];
  $line=$_POST['line_ID'];
  $fb=$_POST['facebook'];
  $address=$_POST['address'];
  $id_contact=$_POST['id_contact'];
  $updateSQL = sprintf("UPDATE post SET ID_post=%s, ID_user=%s, Post_type=%s, Property_type=%s, Title=%s, area_size_rai=%s, area_size_ngan=%s, area_size_var=%s, Price=%s, Geography=%s, Pravince=%s, District=%s, Amphur=%s, Latitude=%s, Longitude=%s, Other=%s, `Date`=%s, `Time`=%s, pass=%s WHERE ID=%s",
                       GetSQLValueString($_POST['id_post'], "text"),
                       GetSQLValueString($_POST['id_user'], "text"),
                       GetSQLValueString($_POST['post_type'], "text"),
                       GetSQLValueString($_POST['property_type'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['area_size_rai'], "int"),
                       GetSQLValueString($_POST['area_size_ngan'], "int"),
                       GetSQLValueString($_POST['area_size_var'], "double"),
                       GetSQLValueString($_POST['price'], "int"),
                       GetSQLValueString($_POST['GEO'], "text"),
                       GetSQLValueString($_POST['province'], "text"),
                       GetSQLValueString($_POST['district'], "text"),
                       GetSQLValueString($_POST['amphur'], "text"),
                       GetSQLValueString($_POST['lat'], "text"),
                       GetSQLValueString($_POST['lng'], "text"),
                       GetSQLValueString($_POST['detail'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['time'], "date"),
                       GetSQLValueString($_POST['pass'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  $updateSQL_Contact = "UPDATE contact SET ID_post='$id_post',Name='$name',Email='$email',Tel_1='$tel1',Tel_2='$tel2',Line_id='$line',Facebook='$fb',Address='$address' WHERE id='$id_contact'";
  
  mysql_select_db($database_Myconnection, $Myconnection);
  $Result1 = mysql_query($updateSQL, $Myconnection) or die(mysql_error());
  $Result2 = mysql_query($updateSQL_Contact, $Myconnection) or die(mysql_error());

  $updateGoTo = "success.php?id_order=".$_POST['id_post'];
  header("Location: $updateGoTo");
}

//-----------//
if(isset($_POST['pass']) && isset($_POST['id_post'])){
	
	$colname_Post = $_POST['id_post'];
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_Post = sprintf("SELECT * FROM post,contact WHERE post.ID_post = %s AND contact.ID_post=post.ID_post", GetSQLValueString($colname_Post, "text"));
	$Post = mysql_query($query_Post, $Myconnection) or die(mysql_error());
	$row_Post = mysql_fetch_assoc($Post);
	$totalRows_Post = mysql_num_rows($Post);
	
	if($_POST['pass']!=$row_Post['pass']){
		header('Location: ../index.php');exit;
	}
}else{ header('Location: ../index.php');exit;}

?>


	
		

<!DOCTYPE html>
<?php 
	$page_name="Edit_post";
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
    <title>แก้ไขประกาศ</title>

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
            <div class="well text-center" style="border:1px dashed #ccc; background-color:transparent !important; padding:8px !important;">
                <a href="#" data-toggle="modal" data-target="#Modal_deletePost" class="btn btn-danger" style="width:150px;">
                    <span class="glyphicon glyphicon-trash"></span> ลบประกาศ
                </a>
            </div>
        </div>
		<div class="col-md-9" style="padding-left: 0px; padding-right: 0px;">
		  <form action="<?php echo $editFormAction; ?>" id="form_edit" name="form_edit" method="POST" enctype="multipart/form-data">
            	
                <div class="panel panel-default">
					<div class="panel-heading text-center bg-B1">
					  <h3 class="font"><span class="glyphicon glyphicon-globe color-main1"></span><b> แก้ไขข้อมูลอสังหาริมทรัพย์</b></h3>
 					</div>
					<div class="panel-body" style="padding-left: 0px; padding-right: 0px;">
						<div id="panel" class="col-md-12">	
                            <div class="col-md-6" style="padding-bottom:15px;">
                            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td align="center" valign="middle"><span id="track">#&nbsp;</span>ประเภทประกาศ</td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="middle" >
                                    	  <label>
                                    	    <input name="post_type" type="radio" id="post_type_0" value="ขาย" <?php if($row_Post['Post_type']=="ขาย"){echo "checked";}?>>
                                    	    ขาย</label>
                                    	  <label>
                                    	    <input type="radio" name="post_type" value="ให้เช่า" id="post_type_1" <?php if($row_Post['Post_type']=="ให้เช่า"){echo "checked";}?>>
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
                                          <select id="property_type" name="property_type" class="form-control" style="width:120px;">
                                            <option value="ที่ดิน"  <?php if($row_Post['Property_type']=="ที่ดิน"){echo "selected";}?>>ที่ดิน</option>
                                            <option value="บ้านเดี่ยว" <?php if($row_Post['Property_type']=="บ้านเดี่ยว"){echo "selected";}?>>บ้านเดี่ยว</option>
                                            <option value="คอนโด" <?php if($row_Post['Property_type']=="คอนโด"){echo "selected";}?>>คอนโด</option>
                                            <option value="อพาร์ทเมนท์" <?php if($row_Post['Property_type']=="อพาร์ทเมนท์"){echo "selected";}?>>อพาร์ทเมนท์</option>
                                          </select>
                                    </td>
                                  </tr>
                                </table>
                            </div>
						</div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>หัวข้อประกาศ</div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $row_Post['Title']; ?>"/>
                            </div>
						</div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ขนาดพื้นที้</div>
                            <div class="col-md-3">
                                <input type="number" class="form-control" id="area_size_rai" name="area_size_rai" placeholder="0" style=" padding-right:30px;" value="<?php echo $row_Post['area_size_rai']; ?>"/>
                                <span class="form-control-feedback" style="margin-right:15px;">ไร่</span>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" id="area_size_ngan" name="area_size_ngan" placeholder="0" style=" padding-right:30px;" value="<?php echo $row_Post['area_size_ngan']; ?>"/>
                                <span class="form-control-feedback" style="margin-right:15px;">งาน</span>
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control" id="area_size_var" name="area_size_var" placeholder="0" style=" padding-right:35px;" value="<?php echo $row_Post['area_size_var']; ?>"/>
                                <span class="form-control-feedback" style="margin-right:20px;">ตร.วา</span>
                            </div>
						</div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ราคา</div>
                            <div class="col-md-4">
                                <input type="number" class="form-control" id="price" name="price" placeholder="Price" style=" padding-right:35px;" value="<?php echo $row_Post['Price']; ?>"/>
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
                               <textarea name="detail" rows="6" maxlength="99999" class="form-control" id="detail" placeholder="Other..." ><?php echo $row_Post['Other']; ?></textarea>
                            </div>
                        </div>
                        <!--
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ภาพประกอบ</div>
                            <div class="col-md-2 col-xs-offset-0">
                            	<span id="track" class="font text-size-18">(ขนาดไฟล์ไม่เกิน 8MB / ภาพ)</span>
                               <input type="file" name="img1" id="img1" class="font inputfile" >
                               <label for="img1" class="font"><span id="l1" class="glyphicon glyphicon-picture" ></span>เลือกรูป</label>
                            </div>
                            <div class="col-md-2">
                               <input type="file" name="img2" id="img2" class="font inputfile" >
                               <label for="img2" class="font"><span id="l2" class="glyphicon glyphicon-picture" ></span>เลือกรูป</label>
                            </div>
                            <div class="col-md-2">
                               <input type="file" name="img3" id="img3"  class="font inputfile" >
                               <label for="img3" class="font"><span id="l3" class="glyphicon glyphicon-picture" ></span>เลือกรูป</label>
                            </div>
                        </div>
                        <div id="panel" class="col-md-12" style="margin-top:0px; padding-top:0px">	
                            <div id="lable" class="col-md-3"></div>
                            <div class="col-md-2">
                               <input type="file" name="img4" id="img4"  class="font inputfile" >
                               <label for="img4" class="font"><span id="l4" class="glyphicon glyphicon-picture" ></span>เลือกรูป</label>
                            </div>
                            <div class="col-md-2">
                               <input type="file" name="img5" id="img5"  class="font inputfile" >
                               <label for="img5" class="font"><span id="l5" class="glyphicon glyphicon-picture" ></span>เลือกรูป</label>
                            </div>
                            <div class="col-md-2">
                               <input type="file" name="img6" id="img6"  class="font inputfile" >
                               <label for="img6" class="font"><span id="l6" class="glyphicon glyphicon-picture" ></span>เลือกรูป</label>
                            </div>
                        </div>
                        -->
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3" style=" margin-right:15px;"><span id="track">#&nbsp;</span>พิกัด GPS</div>
                            <div id="map-search" class="col-md-6 input-group">
                              <input id="search-txt" type="text" maxlength="100" class="form-control" placeholder="ค้นหาด้วย ชื่อจังหวัด อำเภอ หรือ ตำบล"/>
								<span class="input-group-btn">
                                	<button id="search-btn" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
								</span>
                            </div>
                        </div>
                        <div id="panel" class="col-md-12">	
                            <div id="lable" class="col-md-3"></div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="lat" name="lat" placeholder="ละติจูด" value="<?php echo $row_Post['Latitude']; ?>" />
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="lng" name="lng" placeholder="ลองจิจูด" value="<?php echo $row_Post['Longitude']; ?>"/>
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
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track"></span>ชื่อผู้ประกาศ</div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="your name" value="<?php echo $row_Post['Name']; ?>"/>
                                </div>
							</div>
							<div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track"></span>อีเมล</div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row_Post['Email']; ?>"/>
                                </div>
							</div>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>เบอร์โทรติดต่อ</div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="phone_1" name="phone_1" placeholder="Telephone 1" value="<?php echo $row_Post['Tel_1']; ?>"/>
                                </div>
							</div>
                            <div id="panel" class="col-md-12" style=" padding-top:8px;">	
                                <div id="lable" class="col-md-3"></div>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" id="phone_2" name="phone_2" placeholder="Telephone 2" value="<?php echo $row_Post['Tel_2']; ?>"/>
                                </div>
							</div>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ไลน์ ไอดี</div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="line_ID" name="line_ID" placeholder="Line ID" value="<?php echo $row_Post['Line_id']; ?>"/>
                                </div>
							</div>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>ลิงค์ Facebook</div>
                                <div class="col-md-6">
                                    <input type="url" class="form-control" id="facebook" name="facebook" placeholder="https://" value="<?php echo $row_Post['Facebook']; ?>"/>
                                </div>
							</div>
                            
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-3"><span id="track">#&nbsp;</span>รหัสผ่านประกาศ</div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="pass" name="pass" placeholder="Password" value="<?php echo $row_Post['pass']; ?>"/>
                                </div>
							</div>
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
					<button name="submit" id="submit" type="submit" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-floppy-disk"></span> บันทึก</button>
                </div>
                <input name="id" id="id" type="hidden" value="<?php echo $row_Post['ID']; ?>"><!-- ID of table post -->
                <input name="id_contact" id="id_contact" type="hidden" value="<?php echo $row_Post['id']; ?>"><!-- ID of table contact -->
                <input name="id_post" id="id_post" type="hidden" value="<?php echo $row_Post['ID_post']; ?>">
                <input name="id_user" id="id_user" type="hidden" value="<?php echo $row_Post['ID_user']; ?>">
                <input name="address" id="address" type="hidden" value="<?php echo $row_Post['Address']; ?>">
                <input name="date" id="date" type="hidden" value="<?php echo date('Ymd');?>">
                <input name="time" id="time" type="hidden" value="<?php echo date('His');?>">
                <input type="hidden" name="MM_update" value="form_edit">
		  </form>
		</div>
	</div>
</div>

<!-- Popup delete Podt -->
<div class="modal fade" id="Modal_deletePost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-danger" style="border-radius:4px 4px 0px 0px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="glyphicon glyphicon-remove"></span></button>
        <h4 class="modal-title text-center" id="myModalLabel"><span class="glyphicon glyphicon-trash"></span> ยืนยันการลบประกาศ</h4>
      </div>
      <div class="modal-body text-center">
          <div id="body_con_delete" class="input-group" style="width:100%;">
          	  <span class="text-danger font text-size-18">* คุณจะไม่สามาถกู้ข้อมูลการประกาศของคุณคืนได้</span>
              <form action="../delete_post/delete.php" method="post" enctype="multipart/form-data">
                	<input name="id_post" type="hidden" value="<?php echo $row_Post['ID_post']; ?>">
                    <input name="pass_post" type="hidden" value="<?php echo $row_Post['pass']; ?>">
                    <input name="pass_con" type="hidden" value="<?php echo $row_Post['pass']; ?>">
                    <a id="btn_con_delete" href="#" onClick="deletepost()" class="btn btn-danger">ยืนยัน</a>
              </form>
          </div>
          <span id="status" class="font text-R1 text-size-16">&nbsp;</span>
        
      </div>
    </div>
  </div>
</div>		
<!-- END Popup delete Podt -->

<?php include("../footer.php") ?>
 
 
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/jquery.validate.js"></script>
<script src="//maps.googleapis.com/maps/api/js?v=3&amp;sensor=false&amp;key=AIzaSyAFnIuLpTse2iNXtBDWhfHT5f7ATTCMWOw&amp;callback=loadmap" defer></script>
<script src="../js/map_API.js"></script>

<!-- check form -->
<script type="text/javascript">
function deletepost(){
	var idpost='<?php echo $row_Post['ID_post']; ?>';
	var passpost='<?php echo $row_Post['pass']; ?>';
	var passcon='<?php echo $row_Post['pass']; ?>';
	var bodysuccess='<span class="glyphicon glyphicon-ok text-size-32" ></span>';
	var bodyfail='<span class="glyphicon glyphicon-remove text-size-32" ></span><br>ล้มเหลว';
	document.getElementById("btn_con_delete").innerHTML = "Loading...";
	$.ajax({
		url:'../delete_post/delete.php',
		type:'POST',
		data:{id_post:idpost,pass_post:passpost,pass_con:passcon},
		success: function(data){
			if(data=="success"){body_con_delete
				document.getElementById("body_con_delete").innerHTML = bodysuccess;
				setTimeout(function(){ 
					window.location.href = "../buy.php"; 
				}, 400);
				
			}else{document.getElementById("body_con_delete").innerHTML = bodyfail;}
		}
	});
}
</script>

<!---------------- Select location ------------------------>
<script language="javascript">
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
				
 				HTMLFormElement("#form_edit").submit;
			}
		});

		$( document ).ready( function () {

			$("#form_edit" ).validate( {
				rules: {
					title: {
						required: true,
						maxlength:150
					},
					price:{
						required: true,
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
						required: "*ยังไม่กรอกราคา",
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

<!--- btn slect file --->
<script type="text/javascript">


setInterval(function(){ 
	var img1 = $('#img1').val();
	if(img1==''){
		$('#l1').removeClass("glyphicon-ok");
	}else{
		$('#l1').removeClass("glyphicon-picture");
		$("#l1").addClass("glyphicon-ok");
	}
	
}, 10);
setInterval(function(){ 
	var img2 = $('#img2').val();
	if(img2==''){
		$('#l2').removeClass("glyphicon-ok");
	}else{
		$('#l2').removeClass("glyphicon-picture");
		$("#l2").addClass("glyphicon-ok");
	}
}, 10);
setInterval(function(){ 
	var img3 = $('#img3').val();
	if(img3==''){
		$("#l3").removeClass("glyphicon-ok");
	}else{
		$('#l3').removeClass("glyphicon-picture");
		$("#l3").addClass("glyphicon-ok");
	}
}, 10);
setInterval(function(){ 
	var img4 = $('#img4').val();
	if(img4==''){
		$('#l4').removeClass("glyphicon-ok")
	}else{
		$('#l4').removeClass("glyphicon-picture");
		$('#l4').addClass("glyphicon-ok");
	}
}, 10);
setInterval(function(){ 
	var img5 = $('#img5').val();
	if(img5==''){
		$('#l5').removeClass("glyphicon-ok");
	}else{
		$('#l5').removeClass("glyphicon-picture");
		$('#l5').addClass("glyphicon-ok");
	}
}, 10);
setInterval(function(){ 
	var img6 = $('#img6').val();
	if(img6==''){
		$('#l6').removeClass('glyphicon-ok');
	}else{
		$('#l6').removeClass("glyphicon-picture");
		$('#l6').addClass("glyphicon-ok");
	}
}, 10);
</script>

<!------ set default map api ------>
<script type="text/javascript">
var L1='<?php echo $row_Post['Latitude']; ?>'; //lat
var L2='<?php echo $row_Post['Longitude']; ?>'; //lng
</script>

</body>
</html>
<?php
mysql_free_result($Post);
?>
