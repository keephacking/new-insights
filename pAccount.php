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
      
		if(isset($_POST['newpass']))
		{
			$data=array("password"=>$_POST['newpass']);
			$user->update($data);
		}
		
}
?>