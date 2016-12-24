<?php

date_default_timezone_set('Asia/Calcutta');
require_once ('include/database.class.php');
require_once ('include/user.class.php'	);
require_once ('include/table.class.php'	);
require_once ('include/filter.class.php'	);
require_once ('include/item.class.php'	);
require_once ('include/timeAgo_class.php'	);
  
  ?>

  
  <?php
    function destroySession()
  {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
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

  
function timeAgo($datetime, $full = false)
  {
  	$now = new DateTime;
  	$ago = new DateTime($datetime);
  	$diff = $now->diff($ago);
  	$diff->w = floor($diff->d / 7);
  	$diff->d -= $diff->w * 7;
  
  	$string = [
  			'y' => 'year ago',
  			'm' => 'month ago',
  			'w' => 'week ago',
  			'd' => 'day ago',
  			'h' => 'hour ago',
  			'i' => 'minute ago',
  			's' => 'second ago',
  	];
  
  	foreach ($string as $k => &$v)
  	{
  		if ($diff->$k)
  		{
  			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? ' ' : '');
  		}
  		else
  		{
  			unset($string[$k]);
  		}
  	}
  
  	if ( ! $full)
  	{
  		$string = array_slice($string, 0, 1);
  	}
  
  	return $string ? implode(', ', $string) . '' : 'just now';
  
  }
  
 function m_timeAgo($ptime){
  	$diff = time() - $ptime;
  	$calc_times = array();
  	$timeleft   = array();
  
  	// Prepare array, depending on the output we want to get.
  	$calc_times[] = array('Year',   'Years',   31557600);
  	$calc_times[] = array('Month',  'Months',  2592000);
  	$calc_times[] = array('Day',    'Days',    86400);
  	$calc_times[] = array('Hour',   'Hours',   3600);
  	$calc_times[] = array('Minute', 'Minutes', 60);
  	$calc_times[] = array('Second', 'Seconds', 1);
  
  	foreach ($calc_times AS $timedata){
  		list($time_sing, $time_plur, $offset) = $timedata;
  
  		if ($diff >= $offset){
  			$left = floor($diff / $offset);
  			$diff -= ($left * $offset);
  			$timeleft[] = "{$left} " . ($left == 1 ? $time_sing : $time_plur);
  		}
  	}
  
  	return $timeleft ? (time() > $ptime ? null : '-') . implode(' ', $timeleft) : 0;
  }
?>


