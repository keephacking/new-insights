<?php
session_start();
require_once '/include/lib.php';
$user=new user_class();
$fav=new item_class();
$fav->set("favourite_question");
if (isset($_SESSION['id']))
{
	$user->id=$_SESSION['id'];
	$user->loggedin=true;
	$user->set('users',$user->id);
	$user->load_vars();
}
else $user->loggedin=false;

$action = $_POST['action'];
$id     = $_POST['qid'];  	      
		  	    	   
		  	        $fav->sql_query("select * from favourite_question where uid='$user->id' and qid='$id'");
		  	        if($fav->num_rows)
		  	        {
		  	        	$fav->isfav=true;
		  	        }
		  	        else {
		  	        	$fav->isfav=false;
		  	        }
		  	
				  	if($action =='fav-del' && $fav->isfav)
				  	{
				  			$fav->sql_query("delete from favourite_question where uid='$user->id' and qid='$id'");
				  			if($fav->affected_rows)
				  			{
				  				$fav->isfav=false;
				  			}
				  	}
		  	
					elseif($action =='fav-add' && !$fav->isfav){
						
						$fav_data=array("uid"=>$user->id,"qid"=>$id);
						$fav->insert($fav_data);
						if($fav->affected_rows) $fav->isfav=true;
						else $fav->isfav=false;
					}     
					
					if($fav->isfav){
				     echo "<button class='fav-btn clean-btn' type=button id=fav-del><span class='selected glyphicon glyphicon-star fa-2x'></span></button>";
			        }
			        else echo "<button class='fav-btn clean-btn' type=button id=fav-add><span class='glyphicon glyphicon-star-empty fa-2x'></span></button>";
			        
  ?>        
   