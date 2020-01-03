<?php
    header("content-type: text/html; charset=utf-8");
    header ("Expires: Wed, 21 Aug 2013 13:13:13 GMT");
    header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");

	require_once('../Connections/Myconnection.php');

    $data = $_GET['data'];
    $val = $_GET['val'];
	mysql_select_db($database_Myconnection, $Myconnection);
		if ($data=='geography') { 
              echo "<select name='GEO' class='form-control' onChange=\"dochange('province', this.value)\">";
              echo "<option value=''>- เลือกภาค -</option>\n";
              $result=mysql_query("select * from geography order by GEO_ID");
              while($row = mysql_fetch_array($result)){
                   echo "<option value='$row[GEO_ID]' >$row[GEO_NAME]</option>" ;
              }
		}else if ($data=='province') { 
              echo "<select name='province' id='province' class='form-control' onChange=\"dochange('amphur', this.value)\">";
              echo "<option value=''>- เลือกจังหวัด -</option>\n";
              $result=mysql_query("SELECT * FROM province WHERE GEO_ID= '$val' ORDER BY PROVINCE_ID");
              while($row = mysql_fetch_array($result)){
                   echo "<option value='$row[PROVINCE_ID]' >$row[PROVINCE_NAME]</option>" ;
              }
         } else if ($data=='amphur') {
              echo "<select name='amphur' id='amphur' class='form-control' onChange=\"dochange('district', this.value)\">";
              echo "<option value=''>- เลือกอำเภอ -</option>\n";                             
              $result=mysql_query("SELECT * FROM amphur WHERE PROVINCE_ID= '$val' ORDER BY AMPHUR_NAME");
              while($row = mysql_fetch_array($result)){
                   echo "<option value=\"$row[AMPHUR_ID]\" >$row[AMPHUR_NAME]</option> " ;
              }
         } else if ($data=='district') {
              echo "<select name='district' id='district' class='form-control'>\n";
              echo "<option value=''>- เลือกตำบล -</option>\n";
              $result=mysql_query("SELECT * FROM district WHERE AMPHUR_ID= '$val' ORDER BY DISTRICT_NAME");
              while($row = mysql_fetch_array($result)){
                   echo "<option value=\"$row[DISTRICT_ID]\" >$row[DISTRICT_NAME]</option> \n" ;
              }
         }
         echo "</select>\n";

        echo mysql_error();
?>