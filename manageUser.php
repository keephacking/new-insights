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

if($user->loggedin && $user->admin==1 && isset($_POST['display_moderators']))
{
  $user->sql_query("select * from users where moderator=1");
  if($user->num_rows>0){
    while($data=$user->load_datas()){
       echo "<div class=user-item><a href=profile.php?uid=$data[id]>$data[username]</a></div>";
     }
  }
  else echo "<h4>No one yet</h4>";

}
if($user->loggedin && $user->admin==1 && isset($_POST['updateMod'])){
  $user->sql_query("update users set moderator=1 where reputation>5000");
}
?>
