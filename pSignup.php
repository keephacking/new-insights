<?php
require_once 'include/lib.php';

$user = new user_class();
$filter=new filter_class();
if(isset($_POST['ajax'])){
	$out=array();
	$user->email=$filter->sanitizeString($_POST['email']);
	if($user->check_user($user->email))
	{
		$out=array("out"=>"error","mess"=>"Email already exits");
	}
	else $out=array("out"=>"success");
	
	echo json_encode($out);
}
else{
	if(isset($_POST['username'])&&isset($_POST['email'])&&isset($_POST['password'])){
		$a=md5(uniqid(rand(),true));
		$user->username=$filter->sanitizeString($_POST['username']);
		$user->email=$filter->sanitizeString($_POST['email']);
		$user->password=$filter->sanitizeString($_POST['password']);
		$user->active=$a;
		if($user->check_user($user->email))
		{
			echo "Email already exits";
		}
		else {
			$success=$user->registration();
			if($success){
				echo "<div style='height:100%;color:green;text-align:center;'><h1>";
				echo $user->activate_mail();
				echo "</h1></div>";
			}
			else{
				echo "<h1>ERROR</h1>";
			}
			
		}
	}
}
?>