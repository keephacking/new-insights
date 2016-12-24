<?php
/*
if(isset($_POST['iUpload'])){
	$outputDir = "img/";
	$imgName = str_replace('','-',strtolower($_FILES['image']['name']));
	$imgExt = substr($imgName,strripos($imgName,'.'));
	$imgExt = substr_replace('.','',$imgExt);
	$exts = array("jpeg","jpg","png");
	if((($_FILES['image']['type'] == 'image/png') || ($_FILES['image']['type'] == "image/jpg") || ($_FILES['image']['type'] == 'image/jpeg'))
			&& in_array($imgExt, $exts)){
		if(file_exists("img/" . $_FILES['image']['name'])){
			echo $_FILES['image']['name']."<b>Already Exits.</b> ";
		}
		else {
			move_uploaded_file($_FILES['image']['tmp_name'], $outputDir.$imgName);
			echo "<img src='".$outputDir . $imgName ."'height='100' width='100'>";
			echo "error";
		}
				
	}
}
else echo "error";
*/
?>