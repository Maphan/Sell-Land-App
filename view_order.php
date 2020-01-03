<?php require_once('Connections/Myconnection.php'); ?>
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

$colname_View_Order = "-1";
if (isset($_GET['id_order'])) {
  $colname_View_Order = $_GET['id_order'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_View_Order =("SELECT * FROM post,visit_post,contact WHERE post.ID_post='$colname_View_Order' AND visit_post.id_post='$colname_View_Order' AND contact.ID_post='$colname_View_Order'");
$View_Order = mysql_query($query_View_Order, $Myconnection) or die(mysql_error());
$row_View_Order = mysql_fetch_assoc($View_Order);
$totalRows_View_Order = mysql_num_rows($View_Order);

mysql_select_db($database_Myconnection, $Myconnection);
$query_ImgOrder = "SELECT * FROM imgs_post WHERE ID_post = '$colname_View_Order' ORDER BY id ASC";
$ImgOrder = mysql_query($query_ImgOrder, $Myconnection) or die(mysql_error());
$row_ImgOrder = mysql_fetch_assoc($ImgOrder);
$totalRows_ImgOrder = mysql_num_rows($ImgOrder);

$colname1_GEO = "-1";
if (isset($row_View_Order['Geography'])) {
  $colname1_GEO = $row_View_Order['Geography'];
}
$colname2_GEO = "-1";
if (isset($row_View_Order['Pravince'])) {
  $colname2_GEO = $row_View_Order['Pravince'];
}
$colname3_GEO = "-1";
if (isset($row_View_Order['Amphur'])) {
  $colname3_GEO = $row_View_Order['Amphur'];
}
$colname4_GEO = "-1";
if (isset($row_View_Order['District'])) {
  $colname4_GEO = $row_View_Order['District'];
}else{$colname4_GEO=NULL;}

if($colname4_GEO==NULL){
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_GEO = sprintf("SELECT * FROM geography,province,district,amphur WHERE geography.GEO_ID=%s AND province.PROVINCE_ID=%s AND amphur.AMPHUR_ID=%s", GetSQLValueString($colname1_GEO, "int"),GetSQLValueString($colname2_GEO, "int"),GetSQLValueString($colname3_GEO, "int"));
	$GEO = mysql_query($query_GEO, $Myconnection) or die(mysql_error());
	$row_GEO = mysql_fetch_assoc($GEO);
	$totalRows_GEO = mysql_num_rows($GEO);
}else{
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_GEO = sprintf("SELECT * FROM geography,province,district,amphur WHERE geography.GEO_ID=%s AND province.PROVINCE_ID=%s AND amphur.AMPHUR_ID=%s AND district.DISTRICT_ID=%s ", GetSQLValueString($colname1_GEO, "int"),GetSQLValueString($colname2_GEO, "int"),GetSQLValueString($colname3_GEO, "int"),GetSQLValueString($colname4_GEO, "int"));
	$GEO = mysql_query($query_GEO, $Myconnection) or die(mysql_error());
	$row_GEO = mysql_fetch_assoc($GEO);
	$totalRows_GEO = mysql_num_rows($GEO);
}

//--- Comment Post ----//
mysql_select_db($database_Myconnection, $Myconnection);
$query_Comment_post = "SELECT * FROM `comment_post` WHERE ID_post = '$colname_View_Order' ORDER BY ID DESC";
$Comment_post = mysql_query($query_Comment_post, $Myconnection) or die(mysql_error());
$row_Comment_post = mysql_fetch_assoc($Comment_post);
$totalRows_Comment_post = mysql_num_rows($Comment_post);

//--- Myuser ----//
$colname_Myuser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Myuser = $_SESSION['MM_Username'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_Myuser = sprintf("SELECT * FROM `user` WHERE Email = %s", GetSQLValueString($colname_Myuser, "text"));
$Myuser = mysql_query($query_Myuser, $Myconnection) or die(mysql_error());
$row_Myuser = mysql_fetch_assoc($Myuser);
$totalRows_Myuser = mysql_num_rows($Myuser);

//--- GEO_North ----//
mysql_select_db($database_Myconnection, $Myconnection);
$query_GEO_North = "SELECT *  FROM province  WHERE province.GEO_ID=1";
$GEO_North = mysql_query($query_GEO_North, $Myconnection) or die(mysql_error());
$row_GEO_North = mysql_fetch_assoc($GEO_North);
$totalRows_GEO_North = mysql_num_rows($GEO_North);
//--- GEO_CENTRAL ---//
mysql_select_db($database_Myconnection, $Myconnection);
$query_GEO_CENTRAL = "SELECT *  FROM province  WHERE province.GEO_ID=2";
$GEO_CENTRAL = mysql_query($query_GEO_CENTRAL, $Myconnection) or die(mysql_error());
$row_GEO_CENTRAL = mysql_fetch_assoc($GEO_CENTRAL);
$totalRows_GEO_CENTRAL = mysql_num_rows($GEO_CENTRAL);
//--- GEO_NE ---//
mysql_select_db($database_Myconnection, $Myconnection);
$query_GEO_NE = "SELECT *  FROM province  WHERE province.GEO_ID=3";
$GEO_NE = mysql_query($query_GEO_NE, $Myconnection) or die(mysql_error());
$row_GEO_NE = mysql_fetch_assoc($GEO_NE);
$totalRows_GEO_NE = mysql_num_rows($GEO_NE);
//--- GEO_W ---//
mysql_select_db($database_Myconnection, $Myconnection);
$query_GEO_W = "SELECT *  FROM province  WHERE province.GEO_ID=4";
$GEO_W = mysql_query($query_GEO_W, $Myconnection) or die(mysql_error());
$row_GEO_W = mysql_fetch_assoc($GEO_W);
$totalRows_GEO_W = mysql_num_rows($GEO_W);
//--- GEO E ---//
mysql_select_db($database_Myconnection, $Myconnection);
$query_GEO_E = "SELECT *  FROM province  WHERE province.GEO_ID=5";
$GEO_E = mysql_query($query_GEO_E, $Myconnection) or die(mysql_error());
$row_GEO_E = mysql_fetch_assoc($GEO_E);
$totalRows_GEO_E = mysql_num_rows($GEO_E);
//--- GEO S ---//
mysql_select_db($database_Myconnection, $Myconnection);
$query_GEO_S = "SELECT *  FROM province  WHERE province.GEO_ID=6";
$GEO_S = mysql_query($query_GEO_S, $Myconnection) or die(mysql_error());
$row_GEO_S = mysql_fetch_assoc($GEO_S);
$totalRows_GEO_S = mysql_num_rows($GEO_S);
?>

<?php 
// check go back page
if($row_View_Order['ID_post']==NULL){?>
<script>
window.history.back();
</script>
<?php }?>

<!DOCTYPE html>
<?php 
	$page_name="view_order";
	include("domain.php");
	include("phpObject/ArrayList.php");
	include("phpObject/DateThai.php");
	require_once('phpObject/cal_visit_order.php');
	
	date_default_timezone_set('Asia/Bangkok');
	$date=date('dmY');
	$time=date('His');
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/favicon.png" rel="shortcut icon" type="image/x-icon" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $row_View_Order['Title']; ?></title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    <link href="css/style_intro.css" rel="stylesheet">-->
    <link href="css/style_navbar-page.css" rel="stylesheet">
    <link href="font/stylesheet.css" rel="stylesheet">
    <link href="css/style_footer.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style_list_province.css" rel="stylesheet">
    <link href="css/style_viewOrder.css" rel="stylesheet">    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="jquery/jquery.min.js"></script>
      <script src="js/map_viewOrder.js"></script>
      <script src="js/share_API.js"></script>
      
	  <style type="text/css">
		  html,body{
			  width: 100%;
			  height: 100%;
			  padding: 0;
			  margin: 0;	  
		  }
		  hr {
				display: block;
				height: 2px;
				border: 0;
				border-top: 1px solid #DFDFDF;
				margin: 1em 0;
				padding: 0;
			 }
		  #text_comment{
			  margin-bottom: 5px;
			  resize: none;
			  box-shadow:inset 0px 0px 0px 0px;
			  border-radius: 0px 6px 6px 6px;
			  -moz-border-radius: 0px 6px 6px 6px;
			  -webkit-border-radius: 0px 6px 6px 6px;
			  font-weight: 300;
			  line-height: 20px;
		  }
		  #uername_comment{
			  padding: 3px;
			  font-size: 18px;
			  height: 25px;
			  border-top: 0px solid #FFF;
			  border-right: 0px solid #FFF;
			  border-left: 0px solid #FFF;
			  box-shadow: inset 0px 0px 0px 0px;
			  border-radius: 0px;
			  font-weight: 200;
			  text-align: center;
		  }
		  #item_comment{
			  margin-bottom: 15px;
			  -webkit-transition: background-color 2s; /* For Safari 3.1 to 6.0 */
    		  transition: background-color 2s;
		  }
		  .comment{
			  width: 100%;
			  max-width: 100%;
			  font-weight: 200;
			  line-height: 18px;
			  margin-bottom: 0px;
			  color: #222222;
		  }
		  @media (max-width: 767px){
			  .call_post{
				border-bottom:1px dashed #CCCCCC;
				border-right:0px dashed #CCCCCC;
		 	  }
			  .broder-rigth{
				 border-right:1px dashed #CCCCCC;
			 }
			  
		  }
		  @media (min-width: 767px){
			  .help-block{
				  font-size: 18px;
				  color: red;
			  }
			 .call_post{
				 border-right:1px dashed #CCCCCC;
			 }
			 .broder-rigth{
				 border-right:1px dashed #CCCCCC;
			 }
		 }
	</style>

  </head>
<body class="bg-W2">

<?php 
include("Navbar/level_navbar.php");
NavBar_L1();
include("Navbar/navbar.php"); 
?>

<?php
$img=new arraylist();
do {
	if($row_ImgOrder['File_name']!=NULL){
		$img->add($row_ImgOrder['File_name']);
	}
} while ($row_ImgOrder = mysql_fetch_assoc($ImgOrder));
?>

<div class="box-fullscreen bg-W2">
	<div class="container" style="padding-left:0px; padding-right:0px;">
		<div class="col-lg-12" style="margin-top: 85px;">
		</div>
		<div class="col-lg-12" style="margin-top:0px; padding-left:0px; padding-right:0px; ">
			<div class="col-lg-9">
            	<div id="intor" class="col-md-12 cut-text">
                	<span id="icon_title" class="glyphicon glyphicon-bullhorn color-main2 "></span>
                    <b id="text_title" class="font "><?php echo $row_View_Order['Title'];?></b><br>
                    <span id="icon_date" class="glyphicon glyphicon-time text-W4" style=""></span>
                    <span id="text_date" class="font"><span id="t1">ประกาศเมื่อ</span> <?php echo DateThai($row_View_Order['Date']);?> , <?php echo TimeThai($row_View_Order['Time']);?>  น.</span>
                </div>
                <div class="col-lg-12 bg-W1 well" style="margin-top:0px; padding:0px 0px; border: 0px solid #CCC;">
                	<!-- bOX SLIDE -->
                    <div id="img_slide" style="margin-bottom:10px;">
                    	 <?php if($img->get(0)!=NULL){ ?>
                    	 <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                              <?php for($i=1;$i<$img->size();$i++){?>
                              <li data-target="#myCarousel" data-slide-to="<?php echo $i;?>"></li>
                              <?php }?>
                            </ol>
                        	
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                              <div class="item active">
                                <img src="Post/images/<?php echo $row_View_Order['ID_post']; ?>/<?php echo $img->get(0);?>"  style="min-width: 100%;">
                              </div>
                              <?php for($i=1;$i<$img->size();$i++){?>
                              <div class="item">
                                <img src="Post/images/<?php echo $row_View_Order['ID_post']; ?>/<?php echo $img->get($i);?>"  style="min-width: 100%;">
                              </div>
                              <?php }?>
                            </div>
                        
                            <!-- Controls -->
                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                              <span class="glyphicon glyphicon-chevron-left " aria-hidden="true"></span>
                              <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                              <span class="sr-only">Next</span>
                            </a>
                         </div>
                         <?php }else {}?>
                    </div><!-- END bOX SLIDE -->
                    
                    <div id="box_detail">
                    	<div id="box_area" class="col-md-12 font">
                        	<strong><span id="icon" class="glyphicon glyphicon-th-large"></span> 
                            <?php if($row_View_Order['area_size_rai']==NULL && $row_View_Order['area_size_ngan']==NULL && $row_View_Order['area_size_var']==NULL){?>
                            <span>ไม่ระบุขนาดพื้นที่</span><?php }else{?>
                        	<?php if($row_View_Order['area_size_rai']!=NULL){echo $row_View_Order['area_size_rai']. "&nbsp;ไร่";}else{} ?> 
                       	    <?php if($row_View_Order['area_size_ngan']!=NULL){echo $row_View_Order['area_size_ngan']. "&nbsp;งาน";}else{} ?>
                       	    <?php if($row_View_Order['area_size_var']!=NULL){echo $row_View_Order['area_size_var']. "&nbsp;ตร.วา";}else{} ?>
                            <?php }?>
                            </strong>
                        </div>
                        <div id="Property" class="col-xs-6 broder-rigth font" style="">
                            <b><?php echo $row_View_Order['Post_type']; ?> <?php echo $row_View_Order['Property_type']; ?></b>
                        </div>
                        <div id="Price" class="col-xs-6 font" style="">
							<span id="icon"><b>฿</span> <?php if($row_View_Order['Price']!=0){echo number_format($row_View_Order['Price']); ?></b> บาท<?php }else{echo "ไม่ระบุราคา";}?>
                        </div>
                        <div class="clear" style=" font-size:1px; line-height:1px;">&nbsp;</div>
                        <article style="color:#666;">
                            <hr>
                            <?php if($row_View_Order['Other']!=NULL){?>
                            <div class=" col-md-12 text-size-18 font" style="margin-bottom:5px; line-height:1.1;">
                                <p class="cut-text" >
                                <?php echo $row_View_Order['Other']; ?>
                                </p>
                            </div>
                       		<?php }?>
                        </article>
                        <div id="box_locaton" class="col-md-12">
                        	<span id="icon" class="glyphicon glyphicon-map-marker color-main2"></span> <span>
                            <?php $url="http://www.google.com/maps/place/".$row_View_Order['Latitude'].",".$row_View_Order['Longitude']."/9z/data=!3m1!1e3";?>
                            <a id="text" class="font" href="<?php if($row_View_Order['Latitude']==NULL || $row_View_Order['Longitude']==NULL){echo "#";?>"<?php }else{echo $url;?>" target="_blank"<?php }?>>จ.<?php echo $row_GEO['PROVINCE_NAME']; ?> อ.<?php echo $row_GEO['AMPHUR_NAME']; ?> <?php if($row_View_Order['District']!=NULL){echo "ต.".$row_GEO['DISTRICT_NAME'];}else{}?></a></span>
                            <hr style=" margin-top:10px; margin-bottom:0px;">
                        </div>
                        <?php if($row_View_Order['Latitude']==NULL || $row_View_Order['Longitude']==NULL){}else{?>
                        <div id="box_map" class="col-md-12">
                            <div id="map"></div>
                        </div>                        
                        <?php }?>
                        <div id="Visit" class="col-xs-6 broder-rigth font" style="">
                            <span id="icon" class="glyphicon glyphicon-eye-open color-main2"></span> <b><?php echo $row_View_Order['visit']; ?></b> <span id="icon2">ครั้ง</span>
                        </div>
                        <div id="Share" class="col-xs-6 font" style="">
                            <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http://<?php echo $domain."/view_order.php?id_order=".$_GET['id_order'];?>&amp;src=sdkpreparse" onclick="window.open(this.href, 'facebook-share','width=500,height=500');return false;"><span id="icon_FB" class="fa fa-facebook-official fa-2x"></span></a>
                            <a class="twitter" href="http://twitter.com/share?text=<?php echo $row_View_Order['Title'];?>&<?php echo $domain."/view_order.php?id_order=".$_GET['id_order'];?>&via=<?php echo $domain;?>" data-hashtags="ขาย/เช่าที่ดินบ้านคอนโด" onclick="window.open(this.href, 'twitter-share', 'width=500,height=500');return false;"><span id="icon_TW" class="fa fa-twitter-square fa-2x"></span></a>
                            <a class="google-plus" href="https://plus.google.com/share?url=http://<?php echo $domain."/view_order.php?id_order=".$_GET['id_order'];?>" onclick="window.open(this.href, 'google-plus-share', 'width=500,height=500');return false;"><span id="icon_G"  class="fa fa-google-plus-square fa-2x"></span></a>
                        </div>
                        <div class="clear" style=" font-size:1px; line-height:1px;">&nbsp;</div>
            		</div>
            </div>
            <div class="col-lg-12 bg-W1 well" style="margin-top:0px; padding:10px 25px; border-top: 0px solid #CCC;">
				<div style="height: 3px; background-color: #CCC; width: 100%; margin-top: 15px; margin-bottom: 15px;"></div>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tbody>
					<tr>
					  <td width="100px" align="center" valign="top">
						  <img src="images/user-icon.png" width="40px" style="margin-bottom: 8px; "/>
						  <input id="uername_comment" type="text" class="form-control font" placeholder="ชื่อ" maxlength="80" width="90px;" max="150" value="<?php echo $row_Myuser['Username']; ?>" />
					  </td>
					  <td width="3px"></td>
					  <td align="right">
					  	<textarea name="text_comment" id="text_comment" class="form-control font text-size-18" rows="3" placeholder="Add a comment" maxlength="2500"></textarea>
						  <button type="submit" name="btn_comment" id="btn_comment" class="btn btn-info btn-sm" style="width: 70px;" onClick="addcomment()"><span class="glyphicon glyphicon-send"></span> <span id="status_addcomment">Send</span></button>
					  </td>
					</tr>
				  </tbody>
				</table>
				<div style="margin: 0px 15px;">
					<div class="bar_Dash1"></div>
					<div id="box_item_comment">
						<?php if($row_Comment_post['ID']!=NULL){?>
						<?php do { ?>
					    <div id="item_comment">
						    <table width="100%" border="0" cellspacing="0" cellpadding="0">
						      <tbody>
						        <tr>
						          <td width="35" align="right" valign="top">
						            <img src="images/user-icon.png" width="30px"/>
					              </td>
						          <td width="10"></td>
						          <td align="left" valign="top">
						            <span class="font text-size-18 text-primary"><strong><?php echo $row_Comment_post['username'];?></strong></span>
						            <p class="cut-text font text-size-17 comment"><?php echo $row_Comment_post['text'];?></p>
						            <span style="color:darkgray; font-size: 10px; font-weight: 300;">วันที่ <?php echo DateThai($row_Comment_post['date']);?></span>
					              </td>
					            </tr>
					          </tbody>
					      </table>
				      </div>
						  <?php } while ($row_Comment_post = mysql_fetch_assoc($Comment_post)); }?>
					</div>
				</div>
			</div>
		</div>
            
        <div class="col-lg-3">
            	<div class="well text-center" style="border: 1px solid #BCBCBC; padding-top:0px; margin-bottom: 15px;">
                		<div class="bg-main1 text-W1" style="border-radius:0px 0px 5px 5px; padding:5px; font-size:15px; margin-bottom:5px;">ติดต่อผู้ประกาศ</div>
				  		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="color:#666;">
						  <tbody>
  							<tr>
  								<td valign="top" align="center" height="25%">
  									<span class="glyphicon glyphicon-user" style="font-size: 60px; color: #C2C2C2;"></span>
  								</td>
  							</tr>
						  </tbody>
				  </table>
                        <div class="text-center" style="color:#666;">
							             <span class="text-size-22 font"><b>คุณ <?php echo $row_View_Order['Name'];?></b></span><hr>
                        </div>
                        <div class="text-left font text-size-18" style="padding-left:10px; color:#666;" >
                            <span class="glyphicon glyphicon-phone-alt text-size-18 color-main2"></span><span> <b><?php echo $row_View_Order['Tel_1']; ?></b></span><br>
                            <?php if($row_View_Order['Tel_2']!=NULL){?>
                            <span class="glyphicon glyphicon-phone-alt text-size-18 color-main2"></span><span> <b><?php echo $row_View_Order['Tel_2']; ?></b></span><br><?php }else{}?>
                            <span class="glyphicon glyphicon-envelope text-size-18 color-main2"></span><span> <b> <?php echo $row_View_Order['Email']; ?></b></span><br>
                            <?php if($row_View_Order['Line_id']!=NULL){?>
                            <b><span class="color-main1">Line ID</span> : <?php echo $row_View_Order['Line_id']; ?></b></span><br><?php }else{}?>
                                     <?php if($row_View_Order['Facebook']!=NULL){?>
                            <span><a target="_blank" href="<?php echo $row_View_Order['Facebook']; ?>"><b>Facebook</b></a></span><br><?php }else{}?>	
						</div>
				</div>
        <a href="#" data-toggle="modal" data-target="#Modal_EditPost">
          <div class="btn btn-main text-left font text-size-22" style="width:100%; border: 1px solid #BCBCBC; padding: 5px; margin-bottom: 15px; color: #FFF;">
            <span class="glyphicon glyphicon-cog text-size-18 text-W1"></span>&nbsp;&nbsp;<span class="text-W1">แก้ไขประกาศ</span>
          </div>
        </a>
        <div class="well text-center box-list_province" style="padding-bottom:0px; margin-bottom:15px !important;">
          <div class="row list_province" style="margin-bottom:0px;"><span class="glyphicon glyphicon-fire text-size-17"></span> ที่ไกล้เคียง</div>
            <div class="row text-left">
              <?php include('order_inProv.php'); ?>
            </div>
          </div>
				<div class="well text-center box-list_province" style="padding-bottom:0px;">
                	<a role="button" data-toggle="collapse" href="#collapse_N" aria-expanded="false" aria-controls="collapse_N">
						<div class="row list_province" style="margin-bottom:0px;">ภาคเหนือ</div>
                    </a>
					<div id="collapse_N" class="row collapse">
						<?php do { ?>
					    <div class="col-sm-4 col-md-6 item_province"><a href="buy.php?GEO=<?php echo $row_GEO_North['GEO_ID']; ?>&province=<?php echo $row_GEO_North['PROVINCE_ID']; ?>"><?php echo $row_GEO_North['PROVINCE_NAME']; ?></a></div>
						  <?php } while ($row_GEO_North = mysql_fetch_assoc($GEO_North)); ?>
					</div>
				</div>
				
				<div class="well text-center box-list_province" style="padding-bottom:0px;">
                	<a role="button" data-toggle="collapse" href="#collapse_CEN" aria-expanded="false" aria-controls="collapse_CEN">
						<div class="row list_province" style="margin-bottom:0px;">ภาคกลาง</div>
                    </a>
					<div id="collapse_CEN" class="row collapse">
						<?php do { ?>
					    <div class="col-sm-4 col-md-6 item_province"><a href="buy.php?GEO=<?php echo $row_GEO_CENTRAL['GEO_ID']; ?>&province=<?php echo $row_GEO_CENTRAL['PROVINCE_ID']; ?>"><?php echo $row_GEO_CENTRAL['PROVINCE_NAME']; ?></a></div>
						  <?php } while ($row_GEO_CENTRAL = mysql_fetch_assoc($GEO_CENTRAL)); ?>
					</div>
				</div>
				
				<div class="well text-center box-list_province" style="padding-bottom:0px;">
                	<a role="button" data-toggle="collapse" href="#collapse_NE" aria-expanded="false" aria-controls="collapse_NE">
						<div class="row list_province" style="margin-bottom:0px;">ภาคตะวันออกเฉียงเหนือ</div>
                    </a>
					<div id="collapse_NE" class="row collapse">
						<?php do { ?>
					    <div class="col-sm-4 col-md-6 item_province"><a href="buy.php?GEO=<?php echo $row_GEO_NE['GEO_ID']; ?>&province=<?php echo $row_GEO_NE['PROVINCE_ID']; ?>"><?php echo $row_GEO_NE['PROVINCE_NAME']; ?></a></div>
						  <?php } while ($row_GEO_NE = mysql_fetch_assoc($GEO_NE)); ?>
					</div>
				</div>
				
				<div class="well text-center box-list_province" style="padding-bottom:0px;">
                	<a role="button" data-toggle="collapse" href="#collapse_W" aria-expanded="false" aria-controls="collapse_W">
						<div class="row list_province" style="margin-bottom:0px;">ภาคตะวันตก</div>
                    </a>
					<div id="collapse_W" class="row collapse">
						<?php do { ?>
					    <div class="col-sm-4 col-md-6 item_province"><a href="buy.php?GEO=<?php echo $row_GEO_W['GEO_ID']; ?>&province=<?php echo $row_GEO_W['PROVINCE_ID']; ?>"><?php echo $row_GEO_W['PROVINCE_NAME']; ?></a></div>
						  <?php } while ($row_GEO_W = mysql_fetch_assoc($GEO_W)); ?>		
					</div>
				</div>
				
				<div class="well text-center box-list_province" style="padding-bottom:0px;">
                	<a role="button" data-toggle="collapse" href="#collapse_E" aria-expanded="false" aria-controls="collapse_E">
						<div class="row list_province" style="margin-bottom:0px;">ภาคตะวันออก</div>
                    </a>
					<div id="collapse_E" class="row collapse">
						<?php do { ?>
					    <div class="col-sm-4 col-md-6 item_province"><a href="buy.php?GEO=<?php echo $row_GEO_E['GEO_ID']; ?>&province=<?php echo $row_GEO_E['PROVINCE_ID']; ?>"><?php echo $row_GEO_E['PROVINCE_NAME']; ?></a></div>
						  <?php } while ($row_GEO_E = mysql_fetch_assoc($GEO_E)); ?>
					</div>
				</div>
				
				<div class="well text-center box-list_province" style="padding-bottom:0px;">
                	<a role="button" data-toggle="collapse" href="#collapse_S" aria-expanded="false" aria-controls="collapse_S">
						<div class="row list_province" style="margin-bottom:0px;">ภาคใต้</div>
                    </a>
					<div id="collapse_S" class="row collapse">
						<?php do { ?>
					    <div class="col-sm-4 col-md-6 item_province"><a href="buy.php?GEO=<?php echo $row_GEO_S['GEO_ID']; ?>&province=<?php echo $row_GEO_S['PROVINCE_ID']; ?>"><?php echo $row_GEO_S['PROVINCE_NAME']; ?></a></div>
						  <?php } while ($row_GEO_S = mysql_fetch_assoc($GEO_S)); ?>
					</div>
				</div>
                
		  </div><!-- end col-md-3 -->
       		
        </div>
  </div>
</div>

<!-- Popup Edit Podt -->
<div class="modal fade" id="Modal_EditPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-main1" style="border-radius:4px 4px 0px 0px; color:#FFF;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="glyphicon glyphicon-remove"></span></button>
        <h4 class="modal-title text-center" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> ระบบแก้ไขประกาศ</h4>
      </div>
      <div class="modal-body text-center">
          <?php if($row_Myuser['permission']==1){echo "#ระบบกรอกรหัสผ่านให้แล้ว";}?>
          <div class="input-group" style="width:100%;">
              <input type="password" placeholder="รหัสประกาศ" id="pass_check" name="pass_check" class="form-control" width="100%" value="<?php if($row_Myuser['permission']==1){echo $row_View_Order['pass'];}?>">
              <span class="input-group-btn">
                  <button class="btn btn-warning" name="submit" type="submit" onclick="checkpass_post()"><span class="glyphicon glyphicon-cog"></span> <b>ตกลง</b></button>
              </span>
          </div>
          <span id="status" class="font text-R1 text-size-16">&nbsp;</span>
        
      </div>
    </div>
  </div>
</div>		
<!-- END Popup Edit Podt -->

<?php include("footer.php");?> 
 
<!-- Map AIP -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFnIuLpTse2iNXtBDWhfHT5f7ATTCMWOw&callback=initMap" async defer></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/js/jquery.validate.js"></script>

<!------ Stop ImgSlide ------>
<script type="text/javascript">
//$(document).ready(function(){
	//$("#myCarousel").carousel({
	//	interval : false
	//});
//});
</script>

<!------ set map location api ------>
<script type="text/javascript">
var L1=<?php echo $row_View_Order['Latitude'];?>;
var L2=<?php echo $row_View_Order['Longitude'];?>;
</script>

<!------ check pass edit post ------>
<script type="text/javascript">
  function checkpass_post(){
    var idPost='<?php echo $row_View_Order['ID_post'];?>';
    var pass_post='<?php echo $row_View_Order['pass'];?>';
    var pass_check=$('#pass_check').val();

    var keys= new Array("id_post","pass");
    var values= new Array(idPost, pass_post);
        
    if(pass_post==pass_check){
      $('#status').removeClass("text-R1");
      $('#status').addClass("text-success");
      document.getElementById("status").innerHTML = "ถูกต้อง!";
      openWindowWithPost('Post/edit_post.php',"_top",keys,values);
    }else{
      document.getElementById("status").innerHTML = "หรัสผ่านไม่ถูกต้อง!";
    }
  }
</script>

<!------ add comment ------>
<script type="text/javascript">
function addcomment(){
	var Date='<?php echo date('Ymd');?>';
	var Time='<?php echo $time;?>';
	var idPost='<?php echo $colname_View_Order;?>';
	var idUser='<?php echo $row_Myuser['ID_user'];?>';
	var name= $('#uername_comment').val();
	var Text= $('#text_comment').val();
	
	if(Text=="" || name==""){
		if(name==""){alert('ยังไม่กรอกชื่อของคุณ');}
		if(Text==""){alert('ยังไม่กรอกความคิดเห็น');}
	}else{	
	document.getElementById("status_addcomment").innerHTML="loading...";
		$.ajax({
			url:'add_comment/sever_add_comment.php',
			type:'POST',
			data:{ID_post:idPost,ID_user:idUser,Username:name,text:Text,date:Date,time:Time},
			success:function(respone){
				console.log(respone);
				var createElem = document.createElement("div");
				createElem.setAttribute("id", "item_comment");
				var node = document.createTextNode("");
				createElem.appendChild(node);
				var element = document.getElementById("box_item_comment");
				var child = document.getElementById("item_comment");
				element.insertBefore(createElem,child);
				document.getElementById("item_comment").innerHTML=respone;
				document.getElementById("text_comment").value="";
				document.getElementById("status_addcomment").innerHTML="Send";
			}
		});
	}
}
</script>
</body>
</html>

<?php
mysql_free_result($View_Order);

mysql_free_result($GEO);
mysql_free_result($Comment_post);
mysql_free_result($Myuser);

mysql_free_result($GEO_North);

mysql_free_result($GEO_CENTRAL);

mysql_free_result($GEO_NE);

mysql_free_result($GEO_W);

mysql_free_result($GEO_E);

mysql_free_result($GEO_S);

mysql_free_result($ImgOrder);
?>
