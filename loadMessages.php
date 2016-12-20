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
	
	    $updateObj=new item_class();
		$new_mess=new item_class();
		if(isset($_POST['check_new_mess'])){
			$new_mess->sql_query("select * from messages where fid=$user->id and fseen=0 and notified=0");
			echo $new_mess->num_rows;
		}
		if(isset($_POST['pn'])){
			$pageNumber=$_POST['pn'];
			$pageSize=$_POST['ps'];			
			$startRow = (($pageNumber - 1) * $pageSize);
			
			$new_mess->sql_query(" SELECT *
					FROM users RIGHT JOIN messages ON users.id=uid WHERE ((fid=$user->id and fdelete!= 1) and (notified!=2 and fseen=0))
					ORDER BY time desc LIMIT $startRow,$pageSize");	
			
            while($mess=$new_mess->load_datas()){
            	$updateObj->set("messages",$mess['id']);
            	$updateObj->update(array("notified"=>1));
            
            	$time=date("M j g:ia",$mess['time']);
            	echo "
            	<li class=notif-item-box>
            	<input type=hidden id=lm_mid value=$mess[id]>
		         <span class=notif-item-mess><a href=chat.php?fid=$mess[uid] target=_blank>
		            	   <span class=notif-item-mess-body>$mess[message]</span></a>
		            	   <span>
		            		<span class=notif-item-time>".$time."</span>
		            		<span class=notif-right>
		            		  <button type=button class='clean-btn close-notif-btn' id=close-notif>
		            		      <span class='glyphicon glyphicon-remove-sign'></span>
		            		          </button>
		            		</span>
				           </span>
		            	</span>
		            	<span class=notif-item-by>by $mess[username]</span>
            	</li>";
            }
		}
		if(isset($_POST['mid'])){
			$updateObj=new item_class();
			$updateObj->set("messages",$_POST['mid']);
			$updateObj->update(array("notified"=>2));
		}

}
else echo "error";
?>