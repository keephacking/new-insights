<?php
require_once 'include/lib.php';
if(isset($_GET['qid'])){
	$qid= $_GET['qid'];
	$question=new item_class("questions",$qid);
}
	if(isset($_GET['views'])){
        $question->sql_query("CALL updateQuestionViews($qid)");
	}
	
	if(isset($_GET['action'])){
		$following=new item_class("friends_questions");
		$report=new item_class("reported_contents");
		if($_GET['action']=='del')
		{
		$delete=array("deleted"=>1);
		$question->update($delete);
		if($question->affected_rows)
		header("location:question.php?id=$qid");
		else echo "Can't Delete";
		}
		
		elseif($_GET['action']=='follow'){
		  $uid=$_GET['uid'];
		  $follow=array("uid"=>$uid,"qid"=>$qid,"follow"=>1);
		  $following->insert($follow);
		  if($following->affected_rows){
		  	echo "unfollow";
		  }
		  else echo "error";
		   
		}
		elseif($_GET['action']=='unfollow'){	
			$uid=$_GET['uid'];
			$following->sql_query("DELETE FROM friends_questions WHERE uid=$uid and qid=$qid and follow=1");
			if($following->affected_rows)
			echo "follow";
			else echo "error";
		}
	}
if(isset($_POST['message'])){
	$report_insert=array("uid"=>$_POST['uid'],"qid"=>$_POST['qid'],"aid"=>$_POST['aid'],"message"=>$_POST['message']);
	$report->insert($report_insert);
	echo "Success";
}

?>
