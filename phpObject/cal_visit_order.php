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


$colname_order_count_visit = "-1";
if (isset($_GET['id_order'])) {
  $colname_order_count_visit = $_GET['id_order'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_order_count_visit = sprintf("SELECT visit_post.ID,visit_post.visit FROM visit_post WHERE visit_post.id_post=%s", GetSQLValueString($colname_order_count_visit, "text"));
$order_count_visit = mysql_query($query_order_count_visit, $Myconnection) or die(mysql_error());
$row_order_count_visit = mysql_fetch_assoc($order_count_visit);
$totalRows_order_count_visit = mysql_num_rows($order_count_visit);

// count_Oder
if($row_order_count_visit['visit']==NULL){
	$count_visit=1;
}else{$count_visit=$row_order_count_visit['visit']+1;}

// update visit_order

$Mysign=$row_Myuser['Email'];
if($row_View_Order['Email']!=$Mysign){
	$ID=$row_order_count_visit['ID'];
	$updateSQL =("UPDATE visit_post SET id_post='$colname_order_count_visit', visit=$count_visit WHERE ID=$ID");
	
	mysql_select_db($database_Myconnection, $Myconnection);
	$Result1 = mysql_query($updateSQL, $Myconnection) or die(mysql_error());
}else{}
// end update visit_order //


mysql_free_result($order_count_visit);

?>
