<?php if(!isset($_POST['id_post'])){header("Location: ../buy.php");} ?>
<?php require_once('../Connections/Myconnection.php'); ?>
<?php

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

// delete table post,img_post,visit
$idPost_delete=$_POST['id_post'];
$goto_success="finish.php?suc=1";
$goto_fail="finish.php?suc=0&post_id=$idPost_delete";

$path_img_post="../Post/images/".$idPost_delete;
if ($_POST['pass_post']==$_POST['pass_con']) {
  $deleteSQL = "DELETE FROM post WHERE ID_post='$idPost_delete'";
  $deleteSQL2 = "DELETE FROM imgs_post WHERE ID_post='$idPost_delete'";
  $deleteSQL3 = "DELETE FROM visit_post WHERE id_post='$idPost_delete'";
  $deleteSQL4 = "DELETE FROM contact WHERE ID_post='$idPost_delete'";
  $deleteSQL5 = "DELETE FROM comment_post WHERE ID_post='$idPost_delete'";
  
  mysql_select_db($database_Myconnection, $Myconnection);
  $Result1 = mysql_query($deleteSQL, $Myconnection) or die(mysql_error());
  $Result2 = mysql_query($deleteSQL2, $Myconnection) or die(mysql_error());
  $Result3 = mysql_query($deleteSQL3, $Myconnection) or die(mysql_error());
  $Result4 = mysql_query($deleteSQL4, $Myconnection) or die(mysql_error());
  $Result5 = mysql_query($deleteSQL5, $Myconnection) or die(mysql_error());

  delete_dir($path_img_post);//delet folder img
  echo "success";

}else{ 
	echo "fail";
}

?>