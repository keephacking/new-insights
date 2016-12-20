<?php 
session_start();
require 'include/lib.php';
$comment=new item_class();
$comment->set("comments");
$owner=new item_class();
$owner->set("notification");
?>

<?php 
/************insert comments**************/
if (isset($_POST['aid'])){
		$qid=$_POST['aqid'];
		$body=$_POST['comment'];
		$time=time();
		$aid=$_POST['aid'];
		$uid=$_POST['uid'];
		$username=$_POST['username'];
		$data=array("uid"=>$uid,"aid"=>$aid,"body"=>$body,"time"=>$time,"username"=>$username);
		$comment->insert($data);
		if($comment->affected_rows>0){
			$cid=$comment::$link->insert_id;
			echo $cid;
			
			$owner->sql_query("select uid,body from answers where id=$aid");
			$owner_data=$owner->load_datas();
			$fid=$owner_data['uid'];
			
			$a_body=substr($owner_data['body'],0,25);
			$a_body.="...";
			
			if($fid!=$uid){
				$insertNot=array("message"=>$a_body,"cid"=>$cid,"aid"=>$aid,"fid"=>$uid,"uid"=>$fid,"qid"=>$qid);
				$owner->insert($insertNot);
			}
		}
		else echo "error";
}
elseif(isset($_POST['qid']))
{
	$body=$_POST['comment'];
		$time=time();
		$qid=$_POST['qid'];
		$uid=$_POST['uid'];
		$username=$_POST['username'];
		$data=array("uid"=>$uid,"qid"=>$qid,"body"=>$body,"time"=>$time,"username"=>$username);
		$comment->insert($data);
		if($comment->affected_rows>0){
			
	        $cid=$comment::$link->insert_id;
			echo $cid;
				
			$owner->sql_query("select owner_id,title from questions where id=$qid");
			$owner_data=$owner->load_datas();
			$fid=$owner_data['owner_id'];
			$q_title=substr($owner_data['title'],0,25);
			$q_title.="...";
			
			if($fid!=$uid){
			$insertNot=array("message"=>$q_title,"cid"=>$cid,"qid"=>$qid,"fid"=>$uid,"uid"=>$fid);
			$owner->insert($insertNot);
			}
		}
		else echo 0;
}

//header("location:question.php?id=$_GET[id]");

/************delete comments**************/
if(isset($_POST['cid']) && $_POST['action']=="delete"){
	$comment->set("comments",$_POST['cid']);
	$comment->delete();
	  if($comment->affected_rows>0){
	  	echo 1;
	  }
	  else echo 0;
}
elseif(isset($_POST['cid']) && $_POST['action']=="edit"){
	$comment->set("comments",$_POST['cid']);
	$update=array("body"=>$_POST['cmt_body']);
	$comment->update($update);
	  if($comment->affected_rows>0){
	  	echo 1;
	  }
	  else echo 0;
}
?>