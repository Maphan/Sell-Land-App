<?php require_once('Connections/Myconnection.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_All_Order = 30;
$pageNum_All_Order = 0;
if (isset($_GET['pageNum_All_Order'])) {
  $pageNum_All_Order = $_GET['pageNum_All_Order'];
}
$startRow_All_Order = $pageNum_All_Order * $maxRows_All_Order;

mysql_select_db($database_Myconnection, $Myconnection);
$query_All_Order = "SELECT * FROM post ORDER BY ID DESC";
$query_limit_All_Order = sprintf("%s LIMIT %d, %d", $query_All_Order, $startRow_All_Order, $maxRows_All_Order);
$All_Order = mysql_query($query_limit_All_Order, $Myconnection) or die(mysql_error());
$row_All_Order = mysql_fetch_assoc($All_Order);

if (isset($_GET['totalRows_All_Order'])) {
  $totalRows_All_Order = $_GET['totalRows_All_Order'];
} else {
  $all_All_Order = mysql_query($query_All_Order);
  $totalRows_All_Order = mysql_num_rows($all_All_Order);
}
$totalPages_All_Order = ceil($totalRows_All_Order/$maxRows_All_Order)-1;$maxRows_All_Order = 24;
$pageNum_All_Order = 0;
if (isset($_GET['pageNum_All_Order'])) {
  $pageNum_All_Order = $_GET['pageNum_All_Order'];
}
$startRow_All_Order = $pageNum_All_Order * $maxRows_All_Order;

//--------- query All_Order -------//
$colname_title_All_Order = "-1";
if (isset($_GET['title'])) {
  $colname_title_All_Order = $_GET['title'];
}else{$colname_title_All_Order=NULL;}

$colname_GEO_All_Order = "-1";
if (isset($_GET['GEO'])) {
  $colname_GEO_All_Order = $_GET['GEO'];
}else{$colname_GEO_All_Order=NULL;}

$colname_PRAV_All_Order = "-1";
if (isset($_GET['province'])) {
  $colname_PRAV_All_Order = $_GET['province'];
}else{$colname_PRAV_All_Order=NULL;}

$colnameAMPH_All_Order = "-1";
if (isset($_GET['amphur'])) {
  $colnameAMPH_All_Order = $_GET['amphur'];
}else{$colnameAMPH_All_Order=NULL;}

$colname_DIST_All_Order = "-1";
if (isset($_GET['district'])) {
  $colname_DIST_All_Order = $_GET['district'];
}else{$colname_DIST_All_Order=NULL;}

if (isset($_GET['post_type1'])) {
  $colname_post_type1 = $_GET['post_type1'];
}else{$colname_post_type1=NULL;}

if (isset($_GET['post_type2'])) {
  $colname_post_type2 = $_GET['post_type2'];
}else{$colname_post_type2=NULL;}
	$colname_post_type=NULL;
	if($colname_post_type1==NULL && $colname_post_type2==NULL){
		$colname_post_type=NULL;
	}else if($colname_post_type1!=NULL && $colname_post_type2!=NULL){
		$colname_post_type=NULL;
	}else if($colname_post_type1!=NULL && $colname_post_type2==NULL){
		$colname_post_type=$colname_post_type1;
	}else if($colname_post_type1==NULL && $colname_post_type2!=NULL){
		$colname_post_type=$colname_post_type2;
	}

if (isset($_GET['property_type'])) {
  $colname_Property_type = $_GET['property_type'];
}else{$colname_Property_type=NULL;}

$minPrice_All_Order = (int)NULL;
if (isset($_GET['min_price']) && $_GET['min_price']!=NULL) {
  $minPrice_All_Order = (int)$_GET['min_price'];
}

if (isset($_GET['max_price']) && $_GET['max_price']!=NULL) {
  $maxPrice_All_Order = (int)$_GET['max_price'];
}else{
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_ordermaxprice="SELECT * FROM `post` WHERE 1 ORDER BY post.Price DESC";
	$ordermaxprice=mysql_query($query_ordermaxprice,$Myconnection) or die(mysql_error());
	$row_ordermaxprice=mysql_fetch_assoc($ordermaxprice);
	$maxPrice_All_Order = (int)$row_ordermaxprice['Price'];
}

//--order by--//
$sort_All_Order="ID";
if(isset($_GET['sort'])){
	$sort_All_Order=$_GET['sort'];
}
$by_All_Order="DESC";
if(isset($_GET['by'])){
	$by_All_Order=$_GET['by'];
}
////////////////////////////////////////////////
if($colname_GEO_All_Order==NULL){//ไม่เลือก ซักอัน
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_All_Order = sprintf("SELECT * FROM post WHERE Post_type LIKE %s AND Property_type LIKE %s AND Title LIKE %s AND Price>=$minPrice_All_Order AND Price<=$maxPrice_All_Order ORDER BY $sort_All_Order $by_All_Order", GetSQLValueString("%" .$colname_post_type . "%", "text"),GetSQLValueString("%" . $colname_Property_type . "%", "text"),GetSQLValueString("%" . $colname_title_All_Order . "%", "text"));
	$query_limit_All_Order = sprintf("%s LIMIT %d, %d", $query_All_Order, $startRow_All_Order, $maxRows_All_Order);
	$All_Order = mysql_query($query_limit_All_Order, $Myconnection) or die(mysql_error());
	$row_All_Order = mysql_fetch_assoc($All_Order);
}else if($colname_PRAV_All_Order==NULL){// เลือก ภาค
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_All_Order = sprintf("SELECT * FROM post WHERE Post_type LIKE %s AND Property_type LIKE %s AND Title LIKE %s AND Geography=%s AND Price>=$minPrice_All_Order AND Price<=$maxPrice_All_Order ORDER BY $sort_All_Order $by_All_Order",GetSQLValueString("%" . $colname_post_type . "%", "text"),GetSQLValueString("%" . $colname_Property_type . "%", "text"), GetSQLValueString("%" . $colname_title_All_Order . "%", "text"),GetSQLValueString($colname_GEO_All_Order, "int"));
	$query_limit_All_Order = sprintf("%s LIMIT %d, %d", $query_All_Order, $startRow_All_Order, $maxRows_All_Order);
	$All_Order = mysql_query($query_limit_All_Order, $Myconnection) or die(mysql_error());
	$row_All_Order = mysql_fetch_assoc($All_Order);
}else if($colnameAMPH_All_Order==NULL){//เลือกภาค จังหวัด
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_All_Order = sprintf("SELECT * FROM post WHERE Post_type LIKE %s AND Property_type LIKE %s AND Title LIKE %s AND Geography=%s AND Pravince=%s AND Price>=$minPrice_All_Order AND Price<=$maxPrice_All_Order ORDER BY $sort_All_Order $by_All_Order",GetSQLValueString("%" . $colname_post_type . "%", "text"),GetSQLValueString("%" . $colname_Property_type . "%", "text"), GetSQLValueString("%" . $colname_title_All_Order . "%", "text"),GetSQLValueString($colname_GEO_All_Order, "int"),GetSQLValueString($colname_PRAV_All_Order, "int"));
	$query_limit_All_Order = sprintf("%s LIMIT %d, %d", $query_All_Order, $startRow_All_Order, $maxRows_All_Order);
	$All_Order = mysql_query($query_limit_All_Order, $Myconnection) or die(mysql_error());
	$row_All_Order = mysql_fetch_assoc($All_Order);
}else if($colname_DIST_All_Order==NULL){//เลือภาค จังหวัด อำเภอ
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_All_Order = sprintf("SELECT * FROM post WHERE Post_type LIKE %s AND Property_type LIKE %s AND Title LIKE %s AND Geography=%s AND Pravince=%s AND Amphur=%s AND Price>=$minPrice_All_Order AND Price<=$maxPrice_All_Order ORDER BY $sort_All_Order $by_All_OrderC",GetSQLValueString("%" . $colname_post_type . "%", "text"),GetSQLValueString("%" . $colname_Property_type . "%", "text"), GetSQLValueString("%" . $colname_title_All_Order . "%", "text"),GetSQLValueString($colname_GEO_All_Order, "int"),GetSQLValueString($colname_PRAV_All_Order, "int"),GetSQLValueString($colnameAMPH_All_Order, "int"));
	$query_limit_All_Order = sprintf("%s LIMIT %d, %d", $query_All_Order, $startRow_All_Order, $maxRows_All_Order);
	$All_Order = mysql_query($query_limit_All_Order, $Myconnection) or die(mysql_error());
	$row_All_Order = mysql_fetch_assoc($All_Order);
}else{//เลือกทั่งหมด
	mysql_select_db($database_Myconnection, $Myconnection);
	$query_All_Order = sprintf("SELECT * FROM post WHERE Post_type LIKE %s AND Property_type LIKE %s AND Title LIKE %s AND Geography=%s AND Pravince=%s AND District=%s AND Amphur=%s AND Price>=$minPrice_All_Order AND Price<=$maxPrice_All_Order ORDER BY $sort_All_Order $by_All_Order",GetSQLValueString("%" . $colname_post_type . "%", "text"),GetSQLValueString("%" . $colname_Property_type . "%", "text"), GetSQLValueString("%" . $colname_title_All_Order . "%", "text"),GetSQLValueString($colname_GEO_All_Order, "int"),GetSQLValueString($colname_PRAV_All_Order, "int"),GetSQLValueString($colname_DIST_All_Order, "int"),GetSQLValueString($colnameAMPH_All_Order, "int"));
	$query_limit_All_Order = sprintf("%s LIMIT %d, %d", $query_All_Order, $startRow_All_Order, $maxRows_All_Order);
	$All_Order = mysql_query($query_limit_All_Order, $Myconnection) or die(mysql_error());
	$row_All_Order = mysql_fetch_assoc($All_Order);
}

//------- End query All_Order-----------//

if (isset($_GET['totalRows_All_Order'])) {
  $totalRows_All_Order = $_GET['totalRows_All_Order'];
} else {
  $all_All_Order = mysql_query($query_All_Order);
  $totalRows_All_Order = mysql_num_rows($all_All_Order);
}
$totalPages_All_Order = ceil($totalRows_All_Order/$maxRows_All_Order)-1;
$amount_row_ALL_Order=$totalRows_All_Order;


//--- Myuser ---//
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
<!DOCTYPE html>
<?php 
	$page_name="buy";
	include("domain.php");
	//-------------------///
	function activeOrderby($key){
		if($key==1){
			if(isset($_GET['sort'])){
				if($_GET['sort']=="ID" && $_GET['by']=="DESC"){
					return "active";
				}else{return NULL;}
			}else {return "active";}
		}else if($key==2){
			if(isset($_GET['sort'])){
				if($_GET['sort']=="ID" && $_GET['by']=="ASC"){
					return "active";
				}else{return NULL;}
			}else {return NULL;}
		}else if($key==3){
			if(isset($_GET['sort'])){
				if($_GET['sort']=="Price" && $_GET['by']=="DESC"){
					return "active";
				}else{return NULL;}
			}else {return NULL;}
		}else if($key==4){
			if(isset($_GET['sort'])){
				if($_GET['sort']=="Price" && $_GET['by']=="ASC"){
					return "active";
				}else{return NULL;}
			}else {return NULL;}
		}
	}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/favicon.png" rel="shortcut icon" type="image/x-icon" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $Domain; ?></title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    <link href="css/style_intro.css" rel="stylesheet">-->
    <link href="css/style_navbar-page.css" rel="stylesheet">
    <link href="font/stylesheet.css" rel="stylesheet">
    <link href="css/style_footer.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style_boxOder.css" rel="stylesheet">
    <link href="css/style_list_province.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="jquery/jquery.min.js"></script>
      <script src="js/boxOder.js"></script>
      
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
			  .phone_onHiden{
				display:none;
			  }
			  .box_Orderby{
			  	text-align:left;
		  	  }
		  	  .text_h{
		  		font-size: 24px;
		  	  }
		  }
		  @media (min-width: 767px){
		  .phone_onHiden{
				  display: block;
			}
		  
		  .box_Orderby{
			  text-align: center;
		  	  }
		  .text_h{
		  	font-size: 26px;
		  }
		  }
		  .help-block{
			  font-size: 15px;
			  color: red;
			  margin:0px;
			  padding:0px;
		  }
		  hr{
			  color:#F00;
			  border:1px dashed #FFFFFF;
		  }
		  
		  #panel{
			  padding: 3px 0px 0px 0px;
		  }

		  .btn_UI{
		  	opacity: 0.7;
		  	text-align: center;
		  	position: fixed;
		  	z-index: 999999;
		  	width: 78px;
		  	height: 85px;
		  	border: 2px solid #CCC;
		  	left: -20px;
		  	top: 80px;
		  	background-color: #0C7F5C;
		  	cursor: pointer;
		  	transition: 0.1s;
		  	transition
		  	padding: 8px;
		  	padding-top: 13px;
		  }
		  .btn_UI .btn{
		  	overflow: hidden;
		  	background-color: transparent;
		  	border: 0px;
		  	height: 28px;
		  	color: #000;
		  }
		  .btn_UI .btn:hover{
		  	color: #CCC;
		  }
		  .btn_UI .btn.active{
		  	color: #FFF;
		  }
		  .btn_UI:hover{
		  	opacity: 1;
		  	text-align: center;
		  	position: fixed;
		  	z-index: 999999;
		  	width: 81px;
		  	height: 81px;
		  	border: 0px solid #CCC;
		  	left: 5px;
		  	top: 80px;
		  	background-color: #0F976E;
		  	transition: 0.1s;
		  	padding: 12px;
		  }
		  .checkbox{
			  width:18px;
			  height:18px;
			  float:left;
		  }
		  
	</style>

  </head>
<body>

<?php 
include("Navbar/level_navbar.php");
NavBar_L1();
include("Navbar/navbar.php"); 
?>

<div class="btn-circle phone_onHiden btn_UI" style="">
	<div class="">
		<a onclick="UI_grid()" id="grid-btn" class="btn btn-sm active"><span class="glyphicon glyphicon-th"></span> Grid</a>
        <a onclick="UI_list()" id="list_btn" class="btn btn-sm"><span class="glyphicon glyphicon-th-list"></span> List</a>
    </div>

</div>

<div class="box-fullscreen bg-W1 ">
	<div class="container" style="padding-left:0px; padding-right:0px;">
		<div class="col-lg-12" style="margin-top: 75px;">
			<!--<div class="col-lg-8 font text-size-28 text-center">
			</div>-->
		</div>
		<div class="col-lg-9 font text-size-28 text-center" style="margin-top: 10px;">
			<!-- <div class="btn-group">
            <a onclick="UI_list()" id="list_btn" class="btn btn-default btn-sm">
            	<span class="glyphicon glyphicon-th-list"></span>List</a> 
            <a onclick="UI_grid()" id="grid-btn" class="btn btn-default btn-sm active">
               <span class="glyphicon glyphicon-th"></span>Grid</a>
        	</div> -->
		</div>
		<div class="col-lg-12" style="margin-top:0px;">
			<div class="col-lg-9 bg-W2 well" style="padding:0px;">
            	<div>
                    <div class="col-lg-12" style="padding:0px; padding-bottom:10px; background-color:#CCC; opacity:.999; border-radius:7px 7px 0px 0px;">
                    	<form name="form_search" action="buy.php" method="get" enctype="multipart/form-data">
                        <div class="col-xs-12 " style="margin:8px 0px;">
                        	<div class="input-group">
                                <input type="text" class="form-control" style="opacity:.89;" id="title" name="title" placeholder="คำค้นหา" value="<?php echo$colname_title_All_Order?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-warning" type="submit" style="opacity:1;"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
						</div>
                        <div style="width:100%;" class="text-center text-size-14">
                        	<a role="button" data-toggle="collapse" href="#collapse_moreOption" aria-expanded="false" aria-controls="collapse_moreOption">
                            	<span class="glyphicon glyphicon-plus"></span><b> more option</b>
                            </a> 
                        </div>
                        <div id="collapse_moreOption" class="panel-body collapse" style="padding:0px;">
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-2"></div>
                                <div class="col-md-4 col-md-offset-0" style="padding-left:20px;">
                                    	  <label>
	                                        <input class="checkbox" class="" name="post_type1" type="checkbox" id="post_type_0" value="ขาย" <?php if($colname_post_type==NULL && $colname_Property_type==NULL){echo "checked";}else if($colname_post_type1!=NULL){echo "checked";}else{}?>>
	                                        ขาย</label>
	                                      <label>
	                                        <input class="checkbox" name="post_type2" type="checkbox" id="post_type_1" value="ให้เช่า" <?php if($colname_post_type==NULL && $colname_Property_type==NULL){echo "checked";}else if($colname_post_type2!=NULL){echo "checked";}else{}?>>
	                                        ให้เช่า</label>
                                </div>
                                <div class="col-md-4 col-md-offset-0">
                                	<select name="property_type" class="form-control" aria-invalid="false">
                                    	<option value="" selected="">- หมดหมู่ -</option>
                                        <option value="ที่ดิน">ที่ดิน</option>
                                        <option value="บ้านเดี่ยว">บ้านเดี่ยว</option>
                                        <option value="คอนโด">คอนโด</option>
                                        <option value="อพาร์ทเมนท์">อพาร์ทเมนท์</option>
                                    </select>
                                </div>
							</div>                            
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-2"></div>
                                <div class="col-md-4 col-md-offset-0" id="geography">
                                    <select class="form-control" name="GEO" id="GEO">
                                        <option value="">- ทุกภาค -</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-md-offset-0" id="province">
                                    <select class="form-control" name="province" id="province" disabled>
                                        <option value="">- ทุกจังหวัด -</option>
                                    </select>
                                </div>
							</div>
                            <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-2"></div>
								<div class="col-md-4" id="amphur">
                                    <select class="form-control" name="amphur" id="amphur" disabled>
                                    	<option value="">- ทุกอำเภอ -</option>
 									</select>
                            	</div>
                            	<div class="col-md-4" id="district">
                                    <select class="form-control" name="district" id="district" disabled>
                                    	<option value="">- ทุกตำบล -</option>
 									</select>
                            	</div>
							</div>
                             <div id="panel" class="col-md-12">	
                                <div id="lable" class="col-md-2"></div>
                                <div class="col-md-4 col-md-offset-0">
                                	<input name="min_price" id="min_price" class="form-control" type="text" placeholder="ราคาต่ำสุด">
                                </div>
                                <div class="col-md-4 col-md-offset-0">
                                	<input name="max_price" id="max_price" class="form-control" type="text" placeholder="ราคามากสุด">
                                </div>
							</div>   
                            <div id="panel" class="col-md-12">
                            	<div id="lable" class="col-md-2"></div>
                                <div class="col-md-8">	
                                    <table width="100%"><tr><td width="100%" align="center">
                                        <button type="submit" class="btn btn-sm btn-danger" style="width:95%;" name="btn_search" id="search"><span class="glyphicon glyphicon-search"></span>ค้นหา</button>
                                    </td></tr></table>
                                </div>                              
							</div>
                        </div><!-- end panel-body -->
                        </form>
                    </div>
                </div>
                <div class="col-xs-12" style="margin-top:25px;">
                	<div class="col-md-9 text-size-23">
                		<span class="glyphicon glyphicon-bullhorn color-main2" style="margin-right: 8px;"></span><b><span class="font text_h">ประกาศขาย ให้เช่า(<?php echo $amount_row_ALL_Order; ?>)</span></b>
                    </div>
                    <div class="col-md-3 text-left box_Orderby">
                  	  <?php
						$temp_url="?title=".$colname_title_All_Order."&post_type1=".$colname_post_type1."&post_type2=".$colname_post_type2."&property_type=".$colname_Property_type."&GEO=".$colname_GEO_All_Order."&province=".$colname_PRAV_All_Order."&amphur=".$colnameAMPH_All_Order."&district=".$colname_DIST_All_Order."&min_price=".$minPrice_All_Order."&max_price=".$maxPrice_All_Order;
					  ?>
                   	  <button class="btn btn-default dropdown-toggle width" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true"> เรียงลำดับตาม <span class="caret"></span> </button>
                        <ul class="dropdown-menu reviewdrop" role="menu" aria-labelledby="dropdownMenu1">
                        	<li role="presentation" class="<?php echo activeOrderby(1);?>">
                           		<a role="menuitem" tabindex="-1" href="buy.php<?php echo $temp_url;?>&sort=ID&by=DESC">มาใหม่-เก่า</a></li>
                            <li role="presentation" class="<?php echo activeOrderby(2);?>">
                            	<a role="menuitem" tabindex="-1" href="buy.php<?php echo $temp_url;?>&sort=ID&by=ASC">มาเก่า-ใหม่</a></li>
                            <li role="presentation" class="<?php echo activeOrderby(3);?>">
                            	<a role="menuitem" tabindex="-1" href="buy.php<?php echo $temp_url;?>&sort=Price&by=DESC">ราคาสูง-ต่ำ</a></li>
                            <li role="presentation" class="<?php echo activeOrderby(4);?>">
                            	<a role="menuitem" tabindex="-1" href="buy.php<?php echo $temp_url;?>&sort=Price&by=ASC">ราคาต่ำ-สูง</a></li>
                          </ul>
                    </div>
                </div>
                <hr>
  				<div style=" padding-top:1px; margin:18px;">
					<div id="products" class="row list-group box_oder-grid">
					   	<?php if($row_All_Order['ID_post']!=NULL){?>
                       	<?php do { ?>
                   	    <?php 
							// All_Order
							$pravince=$row_All_Order['Pravince'];
							mysql_select_db($database_Myconnection, $Myconnection);
							$query_Province = "SELECT * FROM province WHERE PROVINCE_ID = '$pravince'";
							$Province = mysql_query($query_Province, $Myconnection) or die(mysql_error());
							$row_Province = mysql_fetch_assoc($Province);
							$totalRows_Province = mysql_num_rows($Province);
							// img_post
							$id_post=$row_All_Order['ID_post'];
							$query_Img_Post = "SELECT * FROM imgs_post WHERE ID_post = '$id_post'";
							$Img_Post = mysql_query($query_Img_Post, $Myconnection) or die(mysql_error());
							$row_Img_Post = mysql_fetch_assoc($Img_Post);
							$totalRows_Img_Post = mysql_num_rows($Img_Post);
							
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
							if($row_Img_Post['File_name']!=NULL){
								$name_img=$row_Img_Post['File_name'];
							}else{$name_img='../no_img.jpg';}
						
						?>
                       	  
                       	  <div id="" class="list-group-item col-xs-4 col-lg-4">
                       	    <div class="thumbnail">
                       	      
                       	      <!--               		<img class="group list-group-image" src="images/bg_intro.jpg" alt="" />-->
                       	      <div id="box_img" class="group list-group-image">
								  <div style="display: inline;">
                                  	<div style="position:absolute;">
                                   		<?php if($row_All_Order['Post_type']=="ขาย"){?>
                                    	<img src="images/sell.png" class="img-responsive" style="max-width: 50px;" />
                                    	<?php }else if($row_All_Order['Post_type']=="ให้เช่า"){?>
                                    	<img src="images/lease.png" class="img-responsive" style="max-width: 50px;" />
                                    	<?php }?>
                                    </div>
                      	        	<a href="view_order.php?id_order=<?php echo $row_All_Order['ID_post']; ?>"><img class="" src="Post/images/<?php echo $row_All_Order['ID_post']; ?>/<?php echo $name_img; ?>" alt="" /></a>
                      	      	  </div>
                       	      </div>
                       	      
                       	      <div class="caption box_caption">
                      	        <div id="box_title" style="height: 60px;">
									<a href="view_order.php?id_order=<?php echo $row_All_Order['ID_post']; ?>">
									  <p id="title" class="group inner list-group-item-heading"><b><?php echo $row_All_Order['Title']; ?></b></p>
									</a>
								</div>
                       	        <p class="group inner list-group-item-text">
                       	          <span id="icon" class="glyphicon glyphicon-usd"  style="margin-right: 8px;"></span>
                       	          <span id="price">ราคา <b class="orange"><?php if($row_All_Order['Price']!=0){echo number_format($row_All_Order['Price']); ?></b> บาท<?php }else{echo "ไม่ระบุ";}?></span><br>
                       	          <span id="icon" class="glyphicon glyphicon-th-large" style="margin-right: 8px;"></span>
                       	          <span id="sellMan" class="text-detail font">ขนาด 
                       	            <?php if($row_All_Order['area_size_rai']!=NULL){echo $row_All_Order['area_size_rai']. "&nbsp;ไร่";}else{} ?> 
                       	            <?php if($row_All_Order['area_size_ngan']!=NULL){echo $row_All_Order['area_size_ngan']. "&nbsp;งาน";}else{} ?>
                       	            <?php if($row_All_Order['area_size_var']!=NULL){echo $row_All_Order['area_size_var']. "&nbsp;ตร.วา";}else{} ?>
                   	              </span><br>
                       	          <span id="icon" class="glyphicon glyphicon-map-marker" style="margin-right: 8px;"></span>
                       	          <span id="location" class="text-detail font"><?php echo $row_All_Order['Post_type']; ?> <?php echo $row_All_Order['Property_type']; ?> ที่ <?php echo $row_Province['PROVINCE_NAME']; ?></span><br>
                                  <span id="icon" class="glyphicon glyphicon-eye-open" style="margin-right: 8px;"></span>
                                  <span id="visit" class="text-detail font">เข้าชม <strong><?php echo number_format($row_visit_post['visit']);?></strong> ครั้ง</span>
                                 </p>
                       	        <div class="row">
                       	          <div class="col-xs-12 col-md-12 text-center">
                       	            <a id="btn_view" class="btn btn-sm btn-danger" href="view_order.php?id_order=<?php echo $row_All_Order['ID_post']; ?>">รายระเอียด</a>
                       	            </div>
                       	          </div>
                       	        </div>
                       	      </div>
                   	      </div>
                       	  <?php } while ($row_All_Order = mysql_fetch_assoc($All_Order)); mysql_free_result($Province);mysql_free_result($Img_Post); ?>
						  <?php }else{?>
                          	<div class="text-center alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-warning-sign text-size-45"></span><h3>ไม่พบประกาศ</h3>
                            </div>
                            <div class="text-center">
                            </div>
                          <?php }?>
					</div>

                    <div class="col-md-12 text-center">
                    	<div class="col-md-12 text-center" style="padding-bottom:20px;">
                        	<span class="badge bg-main2"><?php echo $pageNum_All_Order+1;?></span> ใน 
                        	<span class=""><?php echo $totalPages_All_Order+1;?></span> หน้า
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

                    </div>
                    
				</div>
				<div class="">
                <!--
				<div style="border-bottom: 1px solid #A2A2A2;">
					<span class="glyphicon glyphicon-fire text-size-26 color-main1" style="margin-right: 10px;"></span>
					<span class="font text-size-24">ยอดฮิด</span>
				</div>
				
				<?php //include('order_hot.php'); ?>
                -->
			</div>
			</div>
			<div class="col-lg-3">
            	<?php if($row_Myuser['ID_user']==NULL){?>
				<div class="well text-center" style="border: 1px solid #BCBCBC;">
					<form ACTION="#" id="signinForm" name="signinForm" enctype="multipart/form-data" method="POST">
				  		<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tbody>
							<tr>
								<td valign="top" align="center" height="20%">
									<span class="glyphicon glyphicon-user" style="font-size: 50px; color:#CCC;"></span>
								</td>
							</tr>
                            <tr>
								<td valign="top" align="center" height="15%">
									<span>เข้าสู่ระบบ ด้วย Facebook</span>
                                    <div id="signin_FB" class="btn btn-facebook fb_api"><span class="fa fa-facebook-square fa-lg"></span> Login with facebook</div>
                                    <hr>
								</td>
							</tr>
							<tr>
							  <td valign="top" height="">
							  	<div class="form-group">
									<input type="text" class="form-control" id="email_Form" name="email_Form" placeholder="Email" />
								</div>
							  </td>
							</tr>
							<tr>
							  <td valign="top" height="">
							  	<div class="form-group">
									<input type="password" class="form-control" name="password_Form" id="password_Form" placeholder="Password" />
								</div>
							  </td>
							</tr>
							<tr>
							  <td valign="top">
							  	<button type="submit" class="btn btn-main">Sign in</button>
                                <p id="status_signinForm" class="text-R1 font text-size-18"></p>
<!--							  	<button type="reset" class="glyphicon glyphicon-repeat color-main1 text-size-26" style="background-color: transparent; border: 0px;"></button>-->
						  </td>
							</tr>
							<tr>
							  <td valign="top" align="center">
								  <a href="forget_pass/"><span class="glyphicon glyphicon-exclamation-sign text-size-16 text-danger"></span><span class="text-detail text-size-16 font">ลืมรหัสผ่าน</span></a><br>
								  <a href="#" data-toggle="modal" data-target="#myModal2"><span></span><span class="text-size-14">สร้างบัญชีใหม่</span></a>
							  </td>
							</tr>
							
						  </tbody>
						</table>
					</form>
				</div>
				<?php }else{?>
                <div class="well text-center" style="border: 1px solid #BCBCBC;">
				  		<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tbody>
							<tr>
								<td valign="top" align="center" height="25%">
									<span class="glyphicon glyphicon-user" style="font-size: 60px; color: #CCC;"></span><br>
								</td>
							</tr>
							<tr>
							  <td id="detail_user" valign="top" height="21%" align="left" class="font text-size-20" style="padding-left:5px;">
                              		<div class="text-center">
							  	 		<span class="text-size-22"><b> <?php echo $row_Myuser['Username']; ?></b></span><hr style="margin:3px 0px;"></div>
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
							<tr>
							  	<td valign="top" height="15%">&nbsp;
							  		
						  		</td>
							</tr>
							<tr>
							  <td valign="top" align="center">
                                 
								 <a href="<?php if($row_Myuser['permission']==1){echo "admin/profile.php?id_user=".$row_Myuser['ID_user'];}else{echo "Myuser/profile.php";}?>" class="btn btn-warning"><span class="glyphicon glyphicon-home"></span>โปรไฟล์</a>
							  </td>
							</tr>
							
						  </tbody>
						</table>
				</div>
                                
                <?php }?>
                
				<div class="well text-center box-list_province" style="padding-bottom:0px; margin-bottom:15px !important;">
                	<div class="row list_province" style="margin-bottom:0px;"><span class="glyphicon glyphicon-fire text-size-17"></span>ยอดฮิด</div>
                    <div class="row text-left">
							<?php include('order_hot.php'); ?>
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
                
			</div>
		</div>
		
<!------------------------------------------------------------------------->
	
		<div class="col-lg-12" style="">
			<div class="col-lg-9 bg-W2">
				
			</div>
			<div class="col-lg-3"></div>
		</div>
	</div>
</div>


<?php include("footer.php") ?>

 
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/js/jquery.validate.js"></script>

<!---------------- form login ------------------------>
<script type="text/javascript">
		$( document ).ready( function () {

			$( "#signinForm" ).validate( {
				rules: {
					email_Form: {
						required: true,
						email: true
					},
					password_Form: {
						required: true,
						minlength: 6
					},
					agree: "required"
				},
				messages: {
					email_Form: "*อีเมลไม่ถูกต้อง",
					password_Form: {
						required: "*กรอกรหัสของคุณ",
						minlength: "*ต้องมีความยาวไม่น้อยกว่า 6 "
					}
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block font" );

					// Add `has-feedback` class to the parent div.form-group
					// in order to add icons to inputs
					element.parents( ".col-sm-5" ).addClass( "has-feedback" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
				submitHandler: function () {
	//				alert( "submitted!" );
	//				HTMLFormElement("#signinForm").submit;
					var email_form=$('#email_Form').val();
					var pass_form=$('#password_Form').val();
					console.log(email_form);
					console.log(pass_form);
					$.ajax({
						url:'signin/login_sever.php',
						data:{email:email_form,password:pass_form},
						type: 'POST',
						success: function(data){
							console.log(data);
							if(data=='1'){
								location.reload();
								document.getElementById("status_signinForm").innerHTML = "loading...";
							}else if(data=='0'){
								document.getElementById("status_signinForm").innerHTML = "รหัสผ่านหรืืออีเมลไม่ถูกต้อง!";
							}
						}
					});
				}
			} );
		} );
</script>


<!---------------- Select location ------------------------>
<script type="text/javascript">
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
             req.open("GET", "phpObject/select_localtion_inViewOder.php?data="+src+"&val="+val); //สร้าง connection
             req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
             req.send(null); //ส่งค่า
        }

        window.onLoad=dochange('geography', -1);     
 </script>

</body>
</html>
<?php
mysql_free_result($All_Order);
mysql_free_result($Myuser);

mysql_free_result($GEO_North);

mysql_free_result($GEO_CENTRAL);

mysql_free_result($GEO_NE);

mysql_free_result($GEO_W);

mysql_free_result($GEO_E);

mysql_free_result($GEO_S);
?>
