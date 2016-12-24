<?php
session_start();

require ("/include/lib.php");


$user=new user_class();
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

if(isset($_GET['logout']) && $user->loggedin)
{
	if($_GET['logout']==true){
		$user->goOffline();
		session_destroy();
		header("Location:login.php");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<link type="text/css" rel="stylesheet" href="include/js/jquery-ui.theme.min.css" >
<link type="text/css" rel="stylesheet" href="include/js/jquery-ui.min.css" >

<script src="include/js/jquery.js"></script>
<script src="include/js/jquery.mobile.custom.min.js"></script>
<script src="include/js/jquery-ui.min.js"></script>
