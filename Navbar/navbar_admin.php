<?php require_once($connec); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

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

$colname_Check_signin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Check_signin = $_SESSION['MM_Username'];
}
mysql_select_db($database_Myconnection, $Myconnection);
$query_Check_signin = sprintf("SELECT * FROM `user` WHERE Email = %s", GetSQLValueString($colname_Check_signin, "text"));
$Check_signin = mysql_query($query_Check_signin, $Myconnection) or die(mysql_error());
$row_Check_signin = mysql_fetch_assoc($Check_signin);
$totalRows_Check_signin = mysql_num_rows($Check_signin);
?>
<nav class="navbar navbar-default navbar-fixed-top ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		  <a class="navbar-brand" href="<?php echo $to_index;?>">
        <img src="<?php echo $img_logo;?>" width="220px" class="img-responsive navbar_loago phoneONhid"/>
        <img src="<?php echo $level;?>images/logo2.png" width="130px" class="img-responsive navbar_loago pc-hid"/>
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right navbar_menu">
        <li class="<?php if($page_name=="index"){echo "active";} ?>" ><a href="dashboard.php">หน้าหลัก</a></li>
        <li class="<?php if($page_name=="buy"){echo "active";} ?>"><a href="<?php echo $to_buy;?>" target="_blank">โหมดผู้ใช้</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $row_Check_signin['Username']; ?> 
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
           
            <li><a href="<?php echo $logout;?>" class="font"><span class="glyphicon glyphicon-off text-R1"></span> <b>Sign Out</b></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav> 
<?php
mysql_free_result($Check_signin);
?>
<script>
function goBack() {
    window.history.back();
}
</script>