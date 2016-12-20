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
}
else $user->loggedin=false;
$answer=new item_class();
if(isset($_POST['ans_del'])){
	$aid=$_POST['aid'];
	$qid=$_POST['qid'];
	$answer->set("answers",$aid);
	$answer->delete();
	
    if($answer->affected_rows){ 
    	$question=new item_class();
    	$question->sql_query("CALL updateAnswerCount($qid,0)");
    	echo "success";
    }
    else {
    	echo "failed";
    }
}
?>