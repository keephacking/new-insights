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
}
else $user->loggedin=false;

if($user->loggedin){
	$id=$_POST['qid'];
	?>
<script src="include/wysiwyg/wysiwyg.js"></script>
<link rel="stylesheet" href="include/wysiwyg/wysiwyg.css">
	
		       <div class="answer-box">
				 <form action="answerpost.php" method="post">
				   <h1>Your Answer</h1>
				   <div class="wysiwyg-container ">  
					 <textarea name="myTextArea" id="myTextArea"></textarea>
				   </div>
				   <div id="source"></div> 
				   
				   <input type="hidden" name="qid" value=<?php echo $id?>>
				   <input type="hidden" name="uid" value=<?php echo $user->id;?>>
				   <input type="submit" name="submit" value="post" id="post"class="post-btn">
				 </form> 
              </div>
 
<?php }else {?>
             <div class="login-ans">
             <p>Only registered users can post answers .</p>
             </div>
             <?php }?>
             
   	 <script>
	 $(function(){
		 alert("hii");
		 if($("richTextField")){
	 field = document.getElementById("richTextField");
	 field.contentDocument.designMode = "On";
		 }
	 });
	 </script>