<?php
require_once 'include/head.php'?>
<link type="text/css" rel="stylesheet" href="include/font-awesome/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="include/bootstrap-3.3.6-dist/css/bootstrap.min.css" >
<script src="include/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<link type="text/css" href="include/style.css" rel="stylesheet">

<link href="chat/chat.css" rel="stylesheet" />
<script src="chat/chat.js"></script>
<head>
  <title><?php echo $user->username;?></title>
</head>
<body>
<?php
if($user->loggedin){

	if(isset($_GET['fid']))
	  {
	  	$fid=$_GET['fid'];
	  	$friend=new user_class();
	  	$friend->set("users",$fid);
	  	$friend->load_vars();

	  	$followed=new item_class();
	  	$followed->sql_query("select * from friends_questions where uid=$fid and fid=$user->id and block=1");

	  	if($followed->num_rows>0){
	  		echo "<input type=hidden id='blocked' value=1>";
	  	}
	  	else
	  		echo "<input type=hidden id='blocked' value=0>";
	?>



	<input type="hidden" id="fid" value="<?php echo $_GET['fid'];?>">
	<input type="hidden" id="uid" value="<?php echo $user->id;?>">

	<?php }else die();

}
else die();
?>
<audio id="pop-sound" preload="auto" style="display: none;">
  <source src="chat/pop2.mp3" type="audio/mpeg" >
  <source src="chat/pop.m4a" type="audio/mp4" >
</audio>


<div class="mess-container">

	<h1>Chat<span id="write-notification"><span><?php echo $friend->username;?></span>  typing ...</span></h1>

	 <div class="friend-image-area">
	   <img class="friend-image img-circle"src="<?php echo $friend->profile_image;?>">
	    <a href="profile.php?uid=<?php echo $friend->id?>"><?php echo $friend->username;?></a>

	 </div>
    <div class="mess-content">

          <div class="loading-icon" id="mess-loading" style="display:none;">
              <img src="chat/loading.gif">
           </div>


        <div id="image-load">
          <img class="image-load-icon"  src="chat/imageLoad.gif">
        </div>
       <div class="mess-item-container">


	    </div>
    </div>

    <form id="mess-form">
        <div class="mess-input-wrapper">
              <div class="mess-text-container">
                   <textarea class="mess-textarea" id="mess-body" name="mess-body"></textarea>
                   <div class="insert-image">
                      <span  title="Image" id="image-btn" class="glyphicon glyphicon-picture fa-lg"></span>
                      <input  style="display:none;"id="iImage"name="images"  type="file">
                  </div>
                   <span class="arrow-right"></span>
              </div>



              <div class="btn-area">
                <button id="post-mess" name="post-mess" value="send"class="mess-send-btn clean-btn" type="submit">send</button>
              </div>

              <div class="blocked-area">You are blocked by the User</div>
        </div>
    </form>

</div>


</body>
</html>
<?php require_once 'lastCode.php';?>
