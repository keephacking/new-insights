<?php 
class database{
	
	private  $host='localhost';
	private  $u='root';
	private  $p='';
	private  $db='proj';

	public  static $link;

  public function __construct()
  {
  	$host     =  'localhost';
  	$u        =  'root';
  	$p        =  '';
  	$db       =  'proj';
  	$num_rows =  0;
  	self::$link=new mysqli($this->host,$this->u,$this->p,$this->db);
  	if(self::$link->connect_error)
  		die(self::$link->connect_error);
  }	
  
}
$db = new database();
?>
