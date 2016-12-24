<?php 
/*
class user_class{
	public  $username;
	public  $_password;
	public  $email;
	public  $joined_date;
	public  $aboutme;
	
	public  reg_user()
	{
		queryMysql("INSERT INTO users(username,email ,password)
				VALUES('$username','$email','$password')") or trigger_error("can't register");
		if($link->affected_rows==1)
		{
			echo "Successfully inserted";
		}
	}
	
	
	

}
?>



<?php
include 'connect.php';


  function sanitizeString($var)
  {
    global $link;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $link->real_escape_string($var);
  }
  
  
    function destroySession()
  {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
  }

    function queryMysql($query)
  {
  	global $link;
    $result = $link->query($query);
     return $result;
  }

    function createTable($name, $query)
  {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
  }

    function showProfile($username)
  {
    if (file_exists("profile_images/$username.jpg"))
      echo "<img src='profile_images/$username.jpg' ><br>";
  else
  	  echo "<img src='profile_images/default.jpg'><br>";

    $result = queryMysql("SELECT * FROM users WHERE username='$username'");

    if ($result->num_rows)
    {
      $row = $result->fetch_array(MYSQLI_ASSOC);
	  echo stripslashes($row['username']);
    }
  }

?>


$(iframeBody).on( 'keydown',function() {
	      var iFrameID = document.getElementById('richTextField');
	      if(iFrameID) {
    	      
	            // here you can make the height, I delete it first, then I make it again
	            iFrameID.style.height = "";
	            iFrameID.style.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
	            
	      }
	});
	<script>
$(document).ready(function(){
$("#bn").click(function(){
$("#box").slideToggle();
});
});
</script>
