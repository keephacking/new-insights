<?php

require_once 'include/lib.php';
$filter=new filter_class();

$messObj=new item_class();
$messObj->set("messages");
if(isset($_POST['message'])){
	$message=$_POST['message'];
	$mess=$filter->sanitizeImageContent($_POST['message']);
	$mess=$messObj::$link->real_escape_string($mess);
	$uid=$_POST['uid'];
	$fid=$_POST['fid'];
	$time=time();
	
	$mess_data=array("message"=>$mess,"time"=>$time,"uid"=>$uid,"fid"=>$fid);
	$messObj->insert($mess_data);
	$id=$messObj::$link->insert_id;
	$time=date("g:ia",time());
	
		echo 
		"<div class=mess-item-right>$message
		 <br><span class=mess-time>$time</span>
		 <span class=unseen>◉ </span>
		<a class=mess-delete rel=$id>✖</a></div>";
}
else echo "<h1>Error</h1>";
?>