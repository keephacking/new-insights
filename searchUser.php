<?php require_once 'include/lib.php';
$user=new user_class();
if (isset($_SESSION['id']))
{
	$user->id=$_SESSION['id'];
	$user->loggedin=true;
	$user->set('users',$user->id);
	$user->load_vars();
}
else $user->loggedin=false;

if(isset($_POST['user']))
{
	$search_user=$_POST['user'];
	$user->sql_query("SELECT * FROM users where username LIKE '$search_user%' ");

}
else
$user->sql_query("select * from users");?>


<?php
if($user->num_rows){
while($row=$user->load_datas()){?>
     <div class="wrap-box"style="position:relative;top:0;left:0;right:0;">
       <div class="box-item" style="position:relative;top:0;right:0;">
				  <img src="<?=$row['profile_image'];?>" style="width:100%" alt="Image">
          <div class="box-item-details">
              <?="<a href=profile.php?uid=$row[id]>$row[username]</a>";?>
				       <div class="reput-details"><?=$row['reputation']?></div>
         </div>

       </div>
    </div>
<?php }}
else die("No Results");?>
