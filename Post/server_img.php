<?php require_once('../Connections/Myconnection.php');?>
<?php  
require_once('ImageManipulator.php');

$folder_post="images/".$_POST['id_post'];
mkdir("$folder_post", 0700);// สร้า่ง folder เก็บรูป
$size=$_POST['0']['size'];
$amoutIMG=(int)$size;
for($i=0;i<=$amoutIMG;$i++){
	
	if ($_FILES["$i"]['error'] > 0) {
		echo "Error: " . $_FILES['0']['error'] . "<br />";
	}else if($_FILES["$i"]['tmp_name']!=NULL){
		// array of valid extensions
		$validExtensions = array('.jpg', '.jpeg','.JPG', '.gif', '.png', '.PNG');
		// get extension of the uploaded file
		$fileExtension = strrchr($_FILES["$i"]['name'], ".");
		// check if file Extension is on the list of allowed ones
		if (in_array($fileExtension, $validExtensions)) {
			$newNamePrefix = $_POST['id_post'].$i;
			$manipulator = new ImageManipulator($_FILES["$i"]['tmp_name']);
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
			// Cop
			$newImage = $manipulator->crop($x1, $y1, $x2, $y2);
			// saving file to uploads folder
			$folder_post=$_POST['id_post'];
			$manipulator->save('images/'.$folder_post."/".$newNamePrefix.".jpg");
			echo 'Done ...';
			$Filename=$newNamePrefix.".jpg";
			// Insert to SQL
			$id_post=$_POST['id_post'];
			$insertSQL1 = sprintf("INSERT INTO imgs_post (ID_post, File_name, Size) VALUES ('$id_post', '$Filename', '')");
			mysql_select_db($database_Myconnection, $Myconnection);
			if($Result1 = mysql_query($insertSQL1, $Myconnection) or die(mysql_error())){
				  echo "img_post is Seccess <br>";
			}else{ echo "img_post is Fail";}
			} else {
				echo 'You must upload an image...';
				$Filename="";
			}
	}
}//--- END loop for --//


 
?>