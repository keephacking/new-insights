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

    $tagObj=new item_class("user_tags");
    $out=array();
    if(isset($_POST['del'])&&isset($_POST['tid']))
    {
    	$tagObj->sql_query("delete from user_tags where uid=$user->id and 
    			tid=$_POST[tid]");
    	if($tagObj->affected_rows>0)
    	{
	       $out=array("out"=>"deleted");
	       ob_end_clean();
	       echo json_encode($out);
    	}
    	else{
    		ob_end_clean();
    		$out=array("out"=>"error");
    		echo json_encode($out);
    	}
    }
    if(isset($_POST['add'])&&isset($_POST['tid'])&&isset($_POST['tag']))
    {
    	if($_POST['tid']==0){
            $tag=$_POST['tag'];
            $tagObj->sql_query("select id from tags where tag='".$tag."'");
            if($tagObj->num_rows==1){
            	$tag_id=$tagObj->load_datas();
            	
            	$tagObj->sql_query("select * from user_tags where uid=$user->id and tid=$tag_id[id]");
            	if($tagObj->num_rows==0)
            	{
		            	$data=array("uid"=>$user->id,"tid"=>$tag_id['id']);
		            	$tagObj->insert($data);
		            	if($tagObj->affected_rows>0)
		            	{
		            		$out=array("out"=>"added","tid"=>$tag_id['id']);
		            		ob_end_clean();
		            		echo json_encode($out);
		            	}
		            	else{
		            		$out=array("out"=>"error");
		            		ob_end_clean();
		            		echo json_encode($out);
		            	}
            	}
            	else
            	{
            		$out=array("out"=>"exists");
            		ob_end_clean();
            		echo json_encode($out);
            	}
            }
            else{
            	$out=array("out"=>"unavailable");
            	ob_end_clean();
            	echo json_encode($out);
            }
    	}
    	else{
	    	$tagObj->set("user_tags");
	    	$tagObj->sql_query("select * from user_tags where uid=$user->id and tid=$_POST[tid]");
	    	if($tagObj->num_rows==0){
	    	  $data=array("uid"=>$user->id,"tid"=>$_POST['tid']);
	    	  $tagObj->insert($data);
		    	if($tagObj->affected_rows>0)
		    	{
			       $out=array("out"=>"added","tid"=>$_POST['tid']);
			       ob_end_clean();
			       echo json_encode($out);
		    	}
		    	else{
		    		$out=array("out"=>"error");
		    		ob_end_clean();
		    		echo json_encode($out);
		    	}
	    	}
	    	else 
	    	{
	    		$out=array("out"=>"exists");
	    		ob_end_clean();
	    		echo json_encode($out);
	    	}
    	}
    }
    
}
?>