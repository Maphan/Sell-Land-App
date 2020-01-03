<?php require_once('../Connections/Myconnection.php'); ?>
<?php require('../phpObject/ArrayList.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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
//-----------------------------------------------------------------------------------------//


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
//-- recordset post_user ---//
$colname_post_user = "-1";
if (isset($_POST['id_user'])) {
  $colname_post_user = $_POST['id_user'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_post_user = sprintf("SELECT * FROM post WHERE ID_user = %s ORDER BY ID ASC", GetSQLValueString($colname_post_user, "text"));
$post_user = mysql_query($query_post_user, $Myconnection) or die(mysql_error());
$row_post_user = mysql_fetch_assoc($post_user);
$totalRows_post_user = mysql_num_rows($post_user);
//-- recordset admin ---//
$colname_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_admin = sprintf("SELECT permission FROM `user` WHERE Email = %s", GetSQLValueString($colname_admin, "text"));
$admin = mysql_query($query_admin, $Myconnection) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);
$totalRows_admin = mysql_num_rows($admin);

?>

<?php
$idPost=new arraylist();
do {
	$idPost->add($row_post_user['ID_post']);
}while ($row_post_user = mysql_fetch_assoc($post_user)); 

// function delete  folder imgfile of post
function delete_dir($src) { 
	$dir = opendir($src);
	while(false !== ( $file = readdir($dir)) ) { 
		if (( $file != '.' ) && ( $file != '..' )) { 
			if ( is_dir($src . '/' . $file) ) { 
				delete_dir($src . '/' . $file); 
			} 
			else { 
				unlink($src . '/' . $file); 
			} 
		} 
	} 
	closedir($dir); 
	rmdir($src);
}
	
//--- delet all post of user ---//
$amountPost=$idPost->size();
if($amountPost!=NULL){
	for($i=0;$i<$amountPost;$i++){
		
		// delete table post
		$idPost_delete=$idPost->get($i);
		$path_img_post="../Post/images/".$idPost_delete;
		if ($row_admin['permission']==1 && $idPost_delete!=NULL) {
		  $deleteSQL = "DELETE FROM post WHERE ID_post='$idPost_delete'";
		  $deleteSQL2 = "DELETE FROM img_post WHERE ID_post='$idPost_delete'";
		  $deleteSQL3 = "DELETE FROM visit_post WHERE id_post='$idPost_delete'";
		  $deleteSQL4 = "DELETE FROM contact WHERE ID_post='$idPost_delete'";

		  mysql_select_db($database_Myconnection, $Myconnection);
		  $Result1 = mysql_query($deleteSQL, $Myconnection) or die(mysql_error());
		  $Result2 = mysql_query($deleteSQL2, $Myconnection) or die(mysql_error());
		  $Result3 = mysql_query($deleteSQL3, $Myconnection) or die(mysql_error());
		  $Result4 = mysql_query($deleteSQL4, $Myconnection) or die(mysql_error());
		  
		  if($Result1 && $Result2 && $Result3){
			  delete_dir($path_img_post);// delete img
			  echo "delete post success";
		  }else{header("Location: finish.php?suc=0&post_id=$idPost_delete");}
		}else{header("Location: finish.php?suc=0&post_id=$idPost_delete");}
	}
}

//--- delete user ---//
$idUser_delete=$_POST['id_user'];
if ($row_admin['permission']==1 && $idUser_delete!=NULL) {
	  $deleteSQL = "DELETE FROM user WHERE ID_user='$idUser_delete'";
	
	  mysql_select_db($database_Myconnection, $Myconnection);
	  $Result1 = mysql_query($deleteSQL, $Myconnection) or die(mysql_error());
	  	  
	  if($Result1 && $Result2 && $Result3){
		  echo "delete user success";
		  header('Location: finish.php?suc=1');
	  }else{ header('Location: finish.php?suc=0&post_id=$idPost_delete');}
	  
	}else{header("Location: finish.php?suc=0&post_id=$idPost_delete");
}

?>

<?php
mysql_free_result($post_user);

mysql_free_result($admin);
?>
