<?php
require_once 'include/lib.php';
$user=new user_class();
$user->set('users');
$filter=new filter_class();
if(isset($_POST['check_email'])){
	$check_email    = $filter->sanitizeString($_POST['check_email']);
	if(!$user->check_user($check_email)){
		echo "This email is not registered";
		echo "<input id=email_error type=hidden value=1>";
	}
}
if(isset($_POST['email'])&&isset($_POST['password']))
{
	$email    = $filter->sanitizeString($_POST['email']);
	$password = $filter->sanitizeString($_POST['password']);

    if($user->user_login($email, $password)=='true')
    {
    	header('location:index.php');
    }
    else{
    	echo "<br><h1>".$user->user_login($email, $password)."</h1>";
    }    
}


?>
