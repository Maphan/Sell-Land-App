<?php
include('config.php');
$Myconnection = mysql_pconnect($hostname_Myconnection, $username_Myconnection, $password_Myconnection) or trigger_error(mysql_error(),E_USER_ERROR); 
 mysql_query("Set Names UTF8");
?>