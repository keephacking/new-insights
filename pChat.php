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

	$followed=new item_class();
	$followed->sql_query("select * from friends_questions where uid=$fid and fid=$user->id and block=1");
	if($followed->num_rows>0){
		die("blocked");
	}
}
else {
	$user->loggedin=false;
	$user->status=0;
}

$messObj=new item_class();

if(isset($_POST['mid']))
{
	$mid=$_POST['mid'];
	if(isset($_POST['action'])&& $_POST['action']=="delete"){
		$messObj->set("messages",$mid);
		$messObj->load_vars();
		if($user->id==$messObj->uid){
			if($messObj->fdelete==1){
				$messObj->delete();
			}
			else{
			 $update_delete=array("udelete"=>1);
			 $messObj->update($update_delete);
			}
		}
		elseif($user->id==$messObj->fid){
			if($messObj->udelete==1){
				$messObj->delete();
			}
			else{
			 $update_delete=array("fdelete"=>1);
			 $messObj->update($update_delete);
			}
		}
		if($messObj->affected_rows>0){
			echo 1;
		}
		else echo 0;
	}
	if(isset($_POST['status'])){
		$messStatusCheck=new item_class("messages",$mid);
		$messStatusCheck->load_vars();
		$f= $messStatusCheck->fseen;
		$out=array("seen"=>$f);
		ob_end_clean();
		echo json_encode($out);
	}
}
/***************************update message activity*****************/
if(isset($_POST['writing']) and $_POST['writing']==1){
	$fid=$_POST['fid'];
	$uid=$_POST['uid'];
	$writeCheck=new item_class("message_activity");
	$insert=array("uid"=>$uid,"fid"=>$fid);
	$writeCheck->insert($insert);
}
elseif (isset($_POST['writing']) and $_POST['writing']==0){
	$fid=$_POST['fid'];
	$uid=$_POST['uid'];
	$writeCheck=new item_class("message_activity");

	$writeCheck->sql_query("select * from message_activity where (fid=$fid and uid=$uid)");
	if($writeCheck->num_rows>0){
	    $writeCheck->sql_query("delete from message_activity where (fid=$fid and uid=$uid)");
	}
}

if(isset($_POST['checkWriting'])and $_POST['checkWriting']==1){
	$currentCheck=new item_class("message_activity");
	$fid=$_POST['fid'];
	$uid=$_POST['uid'];

	$currentCheck->sql_query("select * from message_activity where (fid=$uid and uid=$fid)");

	if($currentCheck->num_rows>0){
	    $out=array("out"=>1);
	}else $out=array("out"=>0);
	ob_end_clean();
	echo json_encode($out);
}
