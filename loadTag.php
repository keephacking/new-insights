<?php 
ob_start();
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
	if(isset($_POST['tid'])){
		$tagObj=new item_class();
		$tagObj->set("tags",$_POST['tid']);
		$tagObj->load_vars();
ob_end_clean();
		?>
		<div class="tag-container">
		<div class="tag-head">
		  <div class="tag-name">
		   <a href="tagged_posts.php?tid=<?=$tagObj->id?>"><?=$tagObj->tag;?></a>		   
		  </div>
		  <div class="close-tag-details glyphicon glyphicon-remove"></div>	   
		</div>
		  <div class="tag-description">
		  <?=$tagObj->description;?>
		  </div>
		  <div class="tag-chara">
		      posts:<?=$tagObj->maxpost;?>&nbsp&nbspfollowers:<?=$tagObj->followers?>
		  </div>
		
		</div>
<?php 	
	}
		
?>