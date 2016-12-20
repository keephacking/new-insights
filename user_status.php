<?php
ob_start();
session_start();
require_once 'include/lib.php';
$user=new user_class();
if (isset($_SESSION['id']))
{
	$user->id=$_SESSION['id'];
	$user->loggedin=true;
	$user->set('users',$user->id);
	$user->load_vars();
}

if(isset($_POST['getStatus']) && isset($_POST['friendId'])){
	$friend=new user_class();
	$friend->set("users",$_POST['friendId']);
	$friend->load_vars();
	$out=array();
	//$out=array("change"=>$_POST['friendId']);

	if($friend->status==1 && $_POST['getStatus']=="online"){
		$out=array("status"=>1,"change"=>0);
	}
	elseif($friend->status==0 && $_POST['getStatus']=="offline"){
		$out=array("status"=>0,"change"=>0);
	}
	else $out=array("status"=>$friend->status,"change"=>1);
	ob_end_clean();
	echo json_encode($out);
}
/********************change user online/offline status**********/
if(isset($_POST['status_val'])){
	$val=array("status"=>$_POST['status_val']);
	$user->update($val);
	$out=array("status"=>$_POST['status_val']);
	ob_end_clean();
	echo json_encode($out);
}
?>
