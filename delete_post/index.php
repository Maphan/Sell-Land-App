<!DOCTYPE html>
<?php 
	$page_name="delete_post";
	include("../domain.php");
	$pass_post=$_POST['pass_post'];
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ลบประกาศ</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    <link href="css/style_intro.css" rel="stylesheet">-->
    <link href="../css/style_navbar-page.css" rel="stylesheet">
    <link href="../font/stylesheet.css" rel="stylesheet">
    <link href="../css/style_footer.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/style_boxOder.css" rel="stylesheet">
    <link href="../css/style_list_province.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="../js/boxOder.js"></script>
      
	  <style type="text/css">
		  html,body{
			  width: 100%;
			  height: 100%;
			  padding: 0;
			  margin: 0;	  
		  }
		  @media (max-width: 767px){
			  html,body{
			  width: 100%;
			  height: 100%;
			  padding: 0;
			  margin: 0;  
			  }
		  }
		  .help-block{
			  font-size: 13px;
			  color: red;
			  margin-bottom: 0px;
		  }
		  .form-group{
			  margin-bottom: 0px;
			  height: 60px;
		  }
		  #panel{
			  padding-top:15px;
		  }
		  #lable{
			  	  margin-top:5px;
				  text-align:right;
			  }
		  #track{
				  color:#F00;
			  }
		  @media (max-width: 768px) {
			  #lable{
				  margin-top:5px;
				  text-align: left;
			  }
			  .phone-onHid{
				  display:none;
			  }
		  }
		  
	</style>

  </head>
<body>

<?php 
include("../Navbar/level_navbar.php");
NavBar_L2();
include("../Navbar/navbar.php"); 
?>

<div class="box-fullscreen bg-W1 full_screen">
	<div class="container center-block" style="padding-top: 150px; padding-bottom: 70px;">
		<div class="col-sm-8 col-sm-offset-2">
        
			<div class="text-center alert  alert-danger" role="alert">
				<span class="glyphicon glyphicon-trash text-size-30"></span><span class="text-size-40 font">ยืนยันการลบ</span>
                <br><br>
 				<table width="100%">
                	<tr><td width="300px" valign="middle" align="center">
                        <form name="form_delete" id="form_delete" action="delete.php" enctype="multipart/form-data" method="post">
                            <input type="password" name="pass_con" class="form-control" placeholder="รหัสผ่านประกาศ" style="width:230px;">
                            <br>
                            <input name="submit" type="submit" class="btn btn-group-sm btn-danger font text-size-24" value="ยืนยัน">
                            <input name="id_post" type="hidden" value="<?php echo $_POST['post_id'];?>">
                            <input name="pass_post" type="hidden" value="<?php echo $_POST['pass_post'];?>">
                        </form>
                	</td></tr>
                </table>
                
			</div>
            
		</div>
	</div>
</div>



<nav class="navbar-fixed-bottom ">
	<?php include("../footer.php") ?>
</nav>
 
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../jquery/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/jquery.validate.js"></script>

<!---------------- check form ------------------------>

    
</body>
</html>

