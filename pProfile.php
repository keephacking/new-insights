<?php
session_start();
require_once 'include/lib.php';
$user=new user_class();
if (isset($_SESSION['id']))
{
	$user->id=$_SESSION['id'];
	$user->loggedin=true;
	$user->set('users',$user->id);
	$user->load_vars();

if(isset($_GET['uid'])&&isset($_GET['fid'])){
	$following=new item_class("friends_questions");
	$uid=$_GET['uid'];
	$fid=$_GET['fid'];
	if(isset($_GET['action']) && $_GET['action']=='follow'){
		$follow=array("uid"=>$uid,"fid"=>$fid,"follow"=>1);
		$following->insert($follow);
		if($following->affected_rows){
			echo "unfollow";
		}
		else echo "error";

	}
	elseif(isset($_GET['action']) && $_GET['action']=='unfollow'){
		$following->sql_query("DELETE FROM friends_questions WHERE uid=$uid and fid=$fid and follow=1");
		if($following->affected_rows)
			echo "follow";
			else echo "error";
	}
	if(isset($_GET['action']) && $_GET['action']=='block'){
		$follow=array("uid"=>$uid,"fid"=>$fid,"block"=>1);
		$following->insert($follow);
		if($following->affected_rows){
			echo "unblock";
		}
		else echo "error";

	}
	elseif(isset($_GET['action']) && $_GET['action']=='unblock'){
		$following->sql_query("DELETE FROM friends_questions WHERE uid=$uid and fid=$fid and block=1");
		if($following->affected_rows)
			echo "block";
			else echo "error";
	}
}

if(isset($_FILES['avatar-in']['name']))
{
	$success="&#10006;&nbsp;unsuccessfull";
	$saveto = "users/profile_images/$user->id.jpg";
	if(file_exists($saveto)){
		unlink($saveto);
	}
	move_uploaded_file($_FILES['avatar-in']['tmp_name'],$saveto);
	$typeok = TRUE;
	switch($_FILES['avatar-in']['type'])
	{
		case "image/gif": $src = imagecreatefromgif($saveto); break;
		case "image/jpeg": // Both regular and progressive jpegs
		case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
		case "image/png": $src = imagecreatefrompng($saveto); break;
		default: $typeok = FALSE; break;
	}
	if ($typeok)
	{
		$success="&#10004;&nbsp;successfulls";
		list($w, $h) = getimagesize($saveto);
		$max = 150;
		$tw = $w;
		$th = $h;
		if ($w > $h && $max < $w)
		{
			$th = $max / $w * $h;
			$tw = $max;
		}
		elseif ($h > $w && $max < $h)
		{
			$tw = $max / $h * $w;
			$th = $max;
		}
		elseif ($max < $w)
		{
			$tw = $th = $max;
		}
		$tmp = imagecreatetruecolor($tw, $th);
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
		imageconvolution($tmp, array(array(-1, -1, -1),
		array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
		imagejpeg($tmp, $saveto);
		imagedestroy($tmp);
		imagedestroy($src);
		echo $saveto;
		/*************adding to database*****************/
		  $src_data=array("profile_image"=>$saveto);
		  $user->update($src_data);
	}
}
/**************change status******************/
if(isset($_POST['newusername']))
{
	$data=array("username"=>$_POST['newusername']);
	$user->update($data);
	echo $_POST['newusername'];
}
if(isset($_POST['newabtme']))
{
	$data=array("aboutme"=>$_POST['newabtme']);
	$user->update($data);
	echo $_POST['newabtme'];
}

}
else $user->loggedin=false;



?>
