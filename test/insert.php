<?php require_once('../Connections/Myconnection.php'); ?>
<?php

if (isset($_POST['Submit'])){
	$idPost=$_POST['id_post'];
	$visit=$_POST['visit'];
	$img_name1=$_POST['img_1'];
	$img_name2=$_POST['img_2'];
	
  	$insertSQL1 = sprintf("INSERT INTO visit_post (id_post, count) VALUES ('$idPost', $visit)");
	$insertSQL2 = sprintf("INSERT INTO img_post (id_post, img1, img2, img3, img4, img5, img6) VALUES ('$idPost', '$img_name1', '$img_name2','$img_name2','$img_name2','','')");

  mysql_select_db($database_Myconnection, $Myconnection);
  if($Result1 = mysql_query($insertSQL1, $Myconnection) or die(mysql_error())){
	  echo "visit_post is Seccess <br>";
  }else{ echo "visit_post is Fail";}
  if($Result2 = mysql_query($insertSQL2, $Myconnection) or die(mysql_error())){
	  echo "img_post is Seccess <br>";
  }else{ echo "img_post is Fail";}
}

?>