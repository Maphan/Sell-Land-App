<?php require_once('../Connections/Myconnection.php'); ?>
<?php  
require_once('ImageManipulator.php');

$folder_post="images/".$_POST['id_post'];
mkdir("$folder_post", 0700);

if ($_FILES['img1']['error'] > 0) {
    echo "Error: " . $_FILES['img1']['error'] . "<br />";
	$i1="";
} else {
    // array of valid extensions
    $validExtensions = array('.jpg', '.jpeg','.JPG', '.gif', '.png');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['img1']['name'], ".");
    // check if file Extension is on the list of allowed ones
    if (in_array($fileExtension, $validExtensions)) {
        $newNamePrefix = $_POST['img1_name'];
        $manipulator = new ImageManipulator($_FILES['img1']['tmp_name']);
        $width  = $manipulator->getWidth();
        $height = $manipulator->getHeight();
        $centreX = round($width / 2);
        $centreY = round($height / 2);
        // our dimensions will be W 380:H 280
		if($width<$height){
			$x1 = $centreX - $centreX; 
			$y1 = $centreY - ($centreX*28/38); 
	 
			$x2 = $centreX + $centreX; 
			$y2 = $centreY + ($centreX*28/38);
		}else if($width>$height){
			$y1 = $centreY - $centreY; 
			$x1 = $centreX - ($centreY*38/28); 
	 
			
			$y2 = $centreY + $centreY;  
			$x2 = $centreX + ($centreY*38/28);
		}
 		//Cop
        $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
        // saving file to uploads folder
		$folder_post=$_POST['id_post'];
        $manipulator->save('images/'.$folder_post.'/'.$newNamePrefix.".jpg");
        echo 'Done ...';
		$i1=$newNamePrefix.".jpg";
    } else {
        echo 'You must upload an image...';
		$i1="";
    }
}

//-------------img2-----------------
if ($_FILES['img2']['error'] > 0) {
    echo "Error: " . $_FILES['img2']['error'] . "<br />";
	$i2="";
} else {
    // array of valid extensions
    $validExtensions = array('.jpg', '.jpeg','.JPG', '.gif', '.png');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['img2']['name'], ".");
    // check if file Extension is on the list of allowed ones
    if (in_array($fileExtension, $validExtensions)) {
        $newNamePrefix = $_POST['img2_name'];
        $manipulator = new ImageManipulator($_FILES['img2']['tmp_name']);
        $width  = $manipulator->getWidth();
        $height = $manipulator->getHeight();
        $centreX = round($width / 2);
        $centreY = round($height / 2);
        // our dimensions will be W 380:H 280
		if($width<$height){
			$x1 = $centreX - $centreX; 
			$y1 = $centreY - ($centreX*28/38); 
	 
			$x2 = $centreX + $centreX; 
			$y2 = $centreY + ($centreX*28/38);
		}else if($width>$height){
			$y1 = $centreY - $centreY; 
			$x1 = $centreX - ($centreY*38/28); 
	 
			
			$y2 = $centreY + $centreY;  
			$x2 = $centreX + ($centreY*38/28);
		}
 		//Cop
        $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
        // saving file to uploads folder
		$folder_post=$_POST['id_post'];
        $manipulator->save('images/'.$folder_post.'/'.$newNamePrefix.".jpg");
        echo 'Done ...';
		$i2=$newNamePrefix.".jpg";
    } else {
        echo 'You must upload an image...';
		$i2="";
    }
}

//-------------img3-----------------
if ($_FILES['img3']['error'] > 0) {
    echo "Error: " . $_FILES['img3']['error'] . "<br />";
	$i3="";
} else {
    // array of valid extensions
    $validExtensions = array('.jpg', '.jpeg','.JPG', '.gif', '.png');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['img3']['name'], ".");
    // check if file Extension is on the list of allowed ones
    if (in_array($fileExtension, $validExtensions)) {
        $newNamePrefix = $_POST['img3_name'];
        $manipulator = new ImageManipulator($_FILES['img3']['tmp_name']);
        $width  = $manipulator->getWidth();
        $height = $manipulator->getHeight();
        $centreX = round($width / 2);
        $centreY = round($height / 2);
        // our dimensions will be W 380:H 280
		if($width<$height){
			$x1 = $centreX - $centreX; 
			$y1 = $centreY - ($centreX*28/38); 
	 
			$x2 = $centreX + $centreX; 
			$y2 = $centreY + ($centreX*28/38);
		}else if($width>$height){
			$y1 = $centreY - $centreY; 
			$x1 = $centreX - ($centreY*38/28); 
	 
			
			$y2 = $centreY + $centreY;  
			$x2 = $centreX + ($centreY*38/28);
		}
 		//Cop
        $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
        // saving file to uploads folder
		$folder_post=$_POST['id_post'];
        $manipulator->save('images/'.$folder_post.'/'.$newNamePrefix.".jpg");
        echo 'Done ...';
		$i3=$newNamePrefix.".jpg";
    } else {
        echo 'You must upload an image...';
		$i3="";
    }
}

//-------------img4-----------------
if ($_FILES['img4']['error'] > 0) {
    echo "Error: " . $_FILES['img4']['error'] . "<br />";
	$i4="";
} else {
    // array of valid extensions
    $validExtensions = array('.jpg', '.jpeg','.JPG', '.gif', '.png');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['img4']['name'], ".");
    // check if file Extension is on the list of allowed ones
    if (in_array($fileExtension, $validExtensions)) {
        $newNamePrefix = $_POST['img4_name'];
        $manipulator = new ImageManipulator($_FILES['img4']['tmp_name']);
        $width  = $manipulator->getWidth();
        $height = $manipulator->getHeight();
        $centreX = round($width / 2);
        $centreY = round($height / 2);
        // our dimensions will be W 380:H 280
		if($width<$height){
			$x1 = $centreX - $centreX; 
			$y1 = $centreY - ($centreX*28/38); 
	 
			$x2 = $centreX + $centreX; 
			$y2 = $centreY + ($centreX*28/38);
		}else if($width>$height){
			$y1 = $centreY - $centreY; 
			$x1 = $centreX - ($centreY*38/28); 
	 
			
			$y2 = $centreY + $centreY;  
			$x2 = $centreX + ($centreY*38/28);
		}
 		//Cop
        $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
        // saving file to uploads folder
		$folder_post=$_POST['id_post'];
        $manipulator->save('images/'.$folder_post.'/'.$newNamePrefix.".jpg");
        echo 'Done ...';
		$i4=$newNamePrefix.".jpg";
    } else {
        echo 'You must upload an image...';
		$i4="";
    }
}

//-------------img5-----------------
if ($_FILES['img5']['error'] > 0) {
    echo "Error: " . $_FILES['img5']['error'] . "<br />";
	$i5="";
} else {
    // array of valid extensions
    $validExtensions = array('.jpg', '.jpeg','.JPG', '.gif', '.png');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['img5']['name'], ".");
    // check if file Extension is on the list of allowed ones
    if (in_array($fileExtension, $validExtensions)) {
        $newNamePrefix = $_POST['img5_name'];
        $manipulator = new ImageManipulator($_FILES['img5']['tmp_name']);
        $width  = $manipulator->getWidth();
        $height = $manipulator->getHeight();
        $centreX = round($width / 2);
        $centreY = round($height / 2);
       // our dimensions will be W 380:H 280
		if($width<$height){
			$x1 = $centreX - $centreX; 
			$y1 = $centreY - ($centreX*28/38); 
	 
			$x2 = $centreX + $centreX; 
			$y2 = $centreY + ($centreX*28/38);
		}else if($width>$height){
			$y1 = $centreY - $centreY; 
			$x1 = $centreX - ($centreY*38/28); 
	 
			
			$y2 = $centreY + $centreY;  
			$x2 = $centreX + ($centreY*38/28);
		}
 		//Cop
        $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
        // saving file to uploads folder
		$folder_post=$_POST['id_post'];
        $manipulator->save('images/'.$folder_post.'/'.$newNamePrefix.".jpg");
        echo 'Done ...';
		$i5=$newNamePrefix.".jpg";
    } else {
        echo 'You must upload an image...';
		$i5="";
    }
}

//-------------img6-----------------
if ($_FILES['img6']['error'] > 0) {
    echo "Error: " . $_FILES['img6']['error'] . "<br />";
	$i6="";
} else {
    // array of valid extensions
    $validExtensions = array('.jpg', '.jpeg','.JPG', '.gif', '.png');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['img6']['name'], ".");
    // check if file Extension is on the list of allowed ones
    if (in_array($fileExtension, $validExtensions)) {
        $newNamePrefix = $_POST['img6_name'];
        $manipulator = new ImageManipulator($_FILES['img6']['tmp_name']);
        $width  = $manipulator->getWidth();
        $height = $manipulator->getHeight();
        $centreX = round($width / 2);
        $centreY = round($height / 2);
       // our dimensions will be W 380:H 280
		if($width<$height){
			$x1 = $centreX - $centreX; 
			$y1 = $centreY - ($centreX*28/38); 
	 
			$x2 = $centreX + $centreX; 
			$y2 = $centreY + ($centreX*28/38);
		}else if($width>$height){
			$y1 = $centreY - $centreY; 
			$x1 = $centreX - ($centreY*38/28); 
	 
			
			$y2 = $centreY + $centreY;  
			$x2 = $centreX + ($centreY*38/28);
		}
 		//Cop
        $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
        // saving file to uploads folder
		$folder_post=$_POST['id_post'];
        $manipulator->save('images/'.$folder_post.'/'.$newNamePrefix.".jpg");
        echo 'Done ...';
		$i6=$newNamePrefix.".jpg";
    } else {
        echo 'You must upload an image...';
		$i6="";
    }
}


//--------------------- Insert to SQL --------------------//
	$id_post=$_POST['id_post'];
	$insertSQL1 = sprintf("INSERT INTO img_post (id_post, img1, img2, img3, img4, img5, img6) VALUES ('$id_post', '$i1', '$i2', '$i3', '$i4', '$i5', '$i6')");

  mysql_select_db($database_Myconnection, $Myconnection);
  if($Result1 = mysql_query($insertSQL1, $Myconnection) or die(mysql_error())){
	  echo "img_post is Seccess <br>";
  }else{ echo "img_post is Fail";}
 
?>