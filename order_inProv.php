<?php require_once('Connections/Myconnection.php'); ?>
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

//require_once('Connections/Myconnection.php');

$maxRows_Hot_order = 7;
$pageNum_Hot_order = 0;
if (isset($_GET['pageNum_Hot_order'])) {
  $pageNum_Hot_order = $_GET['pageNum_Hot_order'];
}
$startRow_Hot_order = $pageNum_Hot_order * $maxRows_Hot_order;

// Query Oder hot
$prov=$row_View_Order['Pravince'];
$idpost=$_GET['id_order'];
mysql_select_db($database_Myconnection, $Myconnection);
$query_Hot_order = "SELECT * FROM post,visit_post,province WHERE post.ID_post!=$idpost AND post.Pravince=$prov AND post.Pravince=province.PROVINCE_ID AND visit_post.id_post=post.ID_post ORDER BY post.ID DESC";
$query_limit_Hot_order = sprintf("%s LIMIT %d, %d", $query_Hot_order, $startRow_Hot_order, $maxRows_Hot_order);
$Hot_order = mysql_query($query_limit_Hot_order, $Myconnection) or die(mysql_error());
$row_Hot_order = mysql_fetch_assoc($Hot_order);

if (isset($_GET['totalRows_Hot_order'])) {
  $totalRows_Hot_order = $_GET['totalRows_Hot_order'];
} else {
  $all_Hot_order = mysql_query($query_Hot_order);
  $totalRows_Hot_order = mysql_num_rows($all_Hot_order);
}
$totalPages_Hot_order = ceil($totalRows_Hot_order/$maxRows_Hot_order)-1;
?>
<?php 
if($row_Hot_order['ID']!=NULL){
	do {;
?>
  <div class="col-md-12" style=" padding: 10px 10px; border-bottom: 1px solid #D5D5D5;">
    <a href="view_order.php?id_order=<?php echo $row_Hot_order['ID_post']; ?>">
      <div class="cut-text" style="margin-bottom: 5px;">
        <span style="float:left;" class="glyphicon glyphicon-star text-size-18 color-orange"></span>
        <span class="text-size-15 cut-text color-main1"><strong><?php echo $row_Hot_order['Title']; ?></strong></span>
      </div>
    </a>
     <div class="col-md-7" style="padding-right:0px;">
      <span class="glyphicon glyphicon-usd text-W3 text-size-12"></span>
      <span class="text-W3 text-size-15 font"> <span class="text-danger text-size-18"><?php echo $row_Hot_order['Price']; ?></span> บาท</span>
    </div>
    <div class="col-md-5 text-right" style="padding-left:0px; padding-right:0px;">
      <span class="glyphicon glyphicon-eye-open text-W3 text-size-12"></span>
      <span class="text-W3 text-size-15 font"> <span class="text-danger text-size-15"><strong><?php echo $row_Hot_order['visit']; ?></strong></span> ครั้ง</span>
    </div>
    <!-- 
    <div class="col-md-12">
      <span class="glyphicon glyphicon-map-marker text-W3 text-size-12"></span>
      <span class="text-W3 text-size-15 font"><?php //echo $row_Hot_order['Post_type']; ?> <?php //echo $row_Hot_order['Property_type']; ?> ที่ <?php //echo $row_Hot_order['PROVINCE_NAME']; ?></span>
    </div>
    
    <div class="col-md-12">
      <span class="glyphicon glyphicon-time text-W3 text-size-12"></span>
      <span class="text-W3 text-size-15 font">วันที่ <?php //echo $row_Hot_order['Date']; ?></span>
     </div>-->
    </div>
<?php 
  	} while ($row_Hot_order = mysql_fetch_assoc($Hot_order)); 
}else{?>
	<div class="text-center alert alert-danger" role="alert">
    	<span class="glyphicon glyphicon-info-sign text-size-30"></span><h5>ไม่มีประกาศไกล้เคียง</h5>
    </div>
<?php }?>
<?php
mysql_free_result($Hot_order);
?>
