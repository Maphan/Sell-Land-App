<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<style type="text/css">
.centered {
 position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
}
#full-size {
    height:100%;
    width:100%;
    position:absolute;
    top:0;
    left:0;
    overflow:hidden;
	background-color:#000;
	opacity:.8;
}
#wrapper {
    /*You can add padding and margins here.*/
	text-align:center;
	vertical-align:middle;
	opacity:1;
	color:#FFF;
	border:2px dashed #FFF;
	height:500px;
	width:1000px;
}
</style>
<body>
<form action="insert.php" method="post" enctype="multipart/form-data" name="form">
<input name="id_post" id="id_post" type="text">
<input name="visit" id="visit" type="text">
<input name="img_1" id="img_1" type="text">
<input name="img_2" id="img_2" type="text">
<button type="submit" name="Submit" class="btn btn-success">Save</button> 
</form>
<hr>
<div id="full-size">
    <div id="wrapper"  class="centered">
        <div>fregergee</div>
    </div>
</div>
<div id="status"></div>
<script type="text/javascript">

function Goto(){
	window.location.href ="SignIn.php";
}

function countDown(secs,elem) {
	var element = document.getElementById(elem);
	element.innerHTML = "Please wait for "+secs+" seconds";
	if(secs ==0) {
		clearTimeout(timer);
		Goto();
	}
	secs--;
	var timer = setTimeout('countDown('+secs+',"'+elem+'")',700);
}
//countDown(6,"status");
</script>
</body>
</html>