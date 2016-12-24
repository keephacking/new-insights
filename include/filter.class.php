<?php 
require_once 'database.class.php';
class filter_class extends database
{
	public function sanitizeString($var)
	{
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return parent::$link->real_escape_string($var);
	}
	public function escape($var){
		return parent::$link->real_escape_string($var);
	}
	public function sanitizeImageContent($var){
		$var = strip_tags($var,"<img><br>");
		return $var;
	}
	public function sanitizeCodeContent($var){
		$var = htmlspecialchars($var);
		return $var;
	}
	
}
?>