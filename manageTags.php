<?php 
ob_start();
session_start();
require_once 'include/lib.php';
$user=new user_class();
$filter=new filter_class();
if (isset($_SESSION['id']))
{
	$user->id=$_SESSION['id'];
	$user->loggedin=true;
	$user->set('users',$user->id);
	$user->load_vars();
	
	
	if(isset($_POST['update'])){
		$tagObj=new item_class();
		$tagObj->set("tags",$_POST['tid']);
	
		$tag=$tagObj::$link->real_escape_string($_POST['tag']);
		$tagDes=$tagObj::$link->real_escape_string($_POST['des']);

			$tag_data=array("tag"=>$tag,"description"=>$tagDes);
			$tagObj->update($tag_data);
			$out=array();
			if(!$tagObj::$link->error){
				$out=array("out"=>"success");
			}
			else 
				$out=array("out"=>"error");
	        ob_end_clean();
	        echo json_encode($out);
		}
}
?>