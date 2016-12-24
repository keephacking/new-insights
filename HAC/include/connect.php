<?php 
$host='localhost';
$u='root';
$p='';
$db='proj';
global $link;
$link=new mysqli($host,$u,$p,$db);
if($link->connect_error) 
	die($link->connect_error);
?>

