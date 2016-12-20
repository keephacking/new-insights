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
	
	    
		$new_not=new item_class();
		if(isset($_POST['check_new_not'])){
			$new_not->sql_query("select * from notification where uid=$user->id and seen=0");
			echo $new_not->num_rows;
		}
		if(isset($_POST['load'])){
			$updateObj=new item_class();
			$pageNumber=$_POST['pn'];
			$pageSize=$_POST['ps'];			
			$startRow = (($pageNumber - 1) * $pageSize);
			
			$new_not->sql_query(" SELECT *
					FROM users RIGHT JOIN notification ON users.id=fid WHERE uid=$user->id 
					ORDER BY date desc LIMIT $startRow,$pageSize");	
			if($new_not->num_rows>0){
		            while($not=$new_not->load_datas()){
		            	$updateObj->set("notification",$not['id']);
		            	$updateObj->update(array("seen"=>1));
		                $time=strtotime($not['date']);
		            	$time=date("M j g:ia",$time);
		            	
		            	echo "
		            	<li class=notif-item-box>
		            	<input type=hidden id=nid value=$not[id]>
		            	<span class=notif-item-mess><a href=question.php?id=$not[qid]>
		            	<span class=notif-item-mess-body>";
		            	if(($not['cid']>0) && ($not['aid']>0) && ($not['qid']>0)){
		            		
                          echo "
		            		  <span class=responseToWhich>comment to your answer</span>";		            		  
		            	}
		            	elseif(($not['cid']==0)&& ($not['aid']>0) && ($not['qid']>0)){
		            		echo "
		            		  <span class=responseToWhich>answer to your question</span>";
		            		  
		            	}
		            	elseif(($not['cid']>0)&& ($not['aid']==0) && ($not['qid']>0)){
		            		echo "
		            		  <span class=responseToWhich>comment to your question</span>";
		            		  
		            		
		            	}
		            	echo"<span>$not[message]</span>
		            		</span></a>
			            		<span>
				            		<span class=notif-item-time>".$time."</span>
				            		<span class=notif-right>
				            		  <button type=button class='clean-btn close-notif-btn' id=close-notif>
				            		      <span class='glyphicon glyphicon-remove-sign'></span>
				            		          </button>
				            		</span>
				            	</span>
		            		
		            		</span>
		            		<span class=notif-item-by>by $not[username]</span>
		            		</li></a>";		
		            }
			}
		}
		
		if(isset($_POST['id'])){
		
			$deleteNot =new item_class();
			$deleteNot->set("notification",$_POST['id']);
			$deleteNot->delete();
			if($deleteNot->affected_rows==1){
				echo "success";
			}
			else echo "error";
		}

}
else echo "error";
?>