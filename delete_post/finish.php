<!DOCTYPE html>
<?php 
	$page_name="delete";
	include("../domain.php");
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ลบประกาศสำเร็จ</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<!--    <link href="css/style_intro.css" rel="stylesheet">-->
    <link href="../css/style_navbar-page.css" rel="stylesheet">
    <link href="../font/stylesheet.css" rel="stylesheet">
    <link href="../css/style_footer.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
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

<?php
$key=$_GET['suc'];
if($key==1){?>
<div class="box-fullscreen bg-W1 full_screen">
	<div class="container center-block" style="padding-top: 130px; padding-bottom: 70px;">
		<div class="col-sm-8 col-sm-offset-2">
        
			<div class="text-center alert alert-success" role="alert">
				<span class="glyphicon glyphicon-ok text-size-45"></span><h3>Delete Success</h3>
 			</div>
			<div class="text-center">
			</div>
            
		</div>
	</div>
</div>
<?php }else{?>
<div class="box-fullscreen bg-W1 full_screen">
	<div class="container center-block" style="padding-top: 130px; padding-bottom: 70px;">
		<div class="col-sm-8 col-sm-offset-2">
        
			<div class="text-center alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-warning-sign text-size-45"></span><h3>ล้มเหลว รหัสไม่ถูกต้อง</h3>
 			</div>
			<div class="text-center">
            
            	<a class="btn btn-danger btn-lg" href="../view_order.php?id_order=<?php echo $_GET['post_id'];?>">ลองอีกครั้ง</a>
			</div>
            
		</div>
	</div>
</div>
<?php }?>

<nav class="navbar-fixed-bottom ">
	<?php include("../footer.php") ?>
</nav> 

 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../jquery/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/jquery.validate.js"></script>
</body>
</html>