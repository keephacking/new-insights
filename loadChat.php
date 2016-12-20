<?php 
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
	

}
else {
	$user->loggedin=false;
	$user->status=0;
}


$fid=$_POST['fid'];

/***********check if blocked********************/

$followed=new item_class();
$followed->sql_query("select * from friends_questions where (uid=$fid and fid=$user->id and block=1)");
if($followed->num_rows==1){
	die("blocked");
}
/********************end***********************/

$loadNew=$_POST['loadNew'];

    if($loadNew==0){
    	global $loaded;
    	$messObj_old=new item_class();
   
    	$cp=$_POST['currentPage'];
    	$size=10;
    	
        $messObj_old->sql_query("call loadMessages($cp,$size,$user->id,$fid)");
        $i=0;
          if($messObj_old->num_rows!=0)
          {
			while($message=$messObj_old->load_datas()){
				$timestamp = $message['time'];
				$time=date("g:ia",$timestamp);
					
				$mess=stripslashes($message['message']);
				
						    if($message['fseen']==1){

								   
								   if($message['uid']==$user->id){
								       echo "<div class=mess-item-right>$mess
								       <br><span class=mess-time><em>$time</em></span>
								       <span class=seen>◉ </span>
								       <a class=mess-delete rel=$message[id]>✖</a></div>";      
								   }
								   else {
									   	echo "<div class=mess-item-left>$mess
									   	<br><span class=mess-time><em>$time</em></span>
									   	<a class=mess-delete rel=$message[id]>✖</a></div>";
									   	
								   }
								   
					          }elseif ($message['fseen']==0 and $message['uid']== $user->id){
					          	echo "<div class=mess-item-right>$mess
					          	<br><span class=mess-time><em>$time</em></span>
					          	<span class=unseen>◉ </span>
					          	<a class=mess-delete rel=$message[id]>✖</a></div>";
					          }
			       }

		   }		   
    }
   elseif($loadNew==1)
   {
   	    $messObj_new=new item_class();
   	    $messObj_seen=new item_class();
    	$messObj_new->sql_query("select * from messages where (uid=$user->id and fid=$fid and udelete!=1) or 
    			                 (fid=$user->id and uid=$fid and fdelete!=1) order by time desc");
    	
    	while($message=$messObj_new->load_datas()){
    		
    		$timestamp = $message['time'];
    		$time=date("g:ia",$timestamp);
    		$mess=stripslashes($message['message']);
    		
    		if($message['fid']==$user->id){
		    	if($message['fseen']==0){
		            $messObj_seen->set("messages",$message['id']);
		    		$seen_data=array('fseen'=>1);
		    		$messObj_seen->update($seen_data);

		    			echo "<div class=mess-item-left>$mess
		    			<br><span class=mess-time><em>$time</em></span>
		    			<a class=mess-delete rel=$message[id]>✖</a></div>";
		    			
		    	}
	    			 
    		}
    	}
    }
		   
?>