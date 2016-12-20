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

		    if(isset($_POST['tag'])){
		      $tag=$_POST['tag'];
		      $t=$tag['0'];

		      $obj1=new item_class();
		      $obj2=new item_class();

		      $obj1->sql_query("select * from tags where tag='$t'");
		      $tagId=$obj1->load_datas();
		      if($obj1->num_rows==1){
		        $tid=$tagId['id'];
		      }


		      $obj2->sql_query("select uid,username,profile_image from
					 user_tag_score LEFT JOIN users on user_tag_score.uid=users.id where
		       user_tag_score.tid=$tid and users.status=1 order by score desc");
					if($obj2->num_rows>0){
						$rows=array();
						$i=0;
			      while($row=$obj2->load_datas()){
							$rows[$i]=array("uid"=>$row['uid'],"username"=>$row['username'],"photo"=>$row['profile_image']);
							$i++;
						}
					}else $rows=array("");
		      ob_end_clean();
		      echo json_encode($rows);

		    }

}

?>
