<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Myconnection = "localhost";
$database_Myconnection = "tinny";
$username_Myconnection = "";
$password_Myconnection = "";
$Myconnection = mysql_pconnect($hostname_Myconnection, $username_Myconnection, $password_Myconnection) or trigger_error(mysql_error(),E_USER_ERROR); 
 mysql_query("Set Names UTF8");
?>