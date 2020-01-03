<?php 
require_once('../Connections/Myconnection.php');
include("../phpObject/DateThai.php");
?>
<?php
if(isset($_POST['ID_post']) && $_POST['ID_post']!=NULL){
	$idpost=$_POST['ID_post'];
	$iduser=$_POST['ID_user'];
	$username=$_POST['Username'];
	$text=$_POST['text'];
	$date=$_POST['date'];
	$time=$_POST['time'];
	$insertSQL = sprintf("INSERT INTO comment_post (ID_post,ID_user,username,text,date,time) VALUES ('$idpost', '$iduser','$username','$text',$date,$time)");
	mysql_select_db($database_Myconnection, $Myconnection);
  	$Result1 = mysql_query($insertSQL, $Myconnection) or die(mysql_error());
	insertSuccess($username,$text,$date,$time);
}else{echo "ล้มเหลว";}
?>
<?php function insertSuccess($name,$text,$date,$time){?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td width="35" align="right" valign="top">
					<img src="images/user-icon.png" width="30px"/>
				</td>
				<td width="10"></td>
				<td align="left" valign="top">
					<span class="font text-size-18 text-primary"><strong><?php echo $name;?></strong></span>
					<p class="cut-text font text-size-17 comment"><?php echo $text;?> </p>
					<span style="color:darkgray; font-size: 10px;font-weight: 300;">วันที่ <?php echo DateThai($date); ?></span>
				</td>
			</tr>
		</tbody>
	</table>	

<?php } ?>
