<?php 
require 'include/head.php';?>

<?php require 'header.php';?>
<input type="checkbox" id="side-bar-toggler" name="" value="">
     <div class="page-wrap">
		
	   <div class="side-bar">	
			<div class="side-bar-menu">
			  <ul >
<li id="acc"><label for="side-bar-toggler">Account   </label>      <span class="glyphicon glyphicon-hand-right fa-ālg"></span></li>
<li id="pri"><label for="side-bar-toggler">Privacy   </label>      <span class="glyphicon glyphicon-hand-right fa-ālg"></span></li>
<li id="not"><label for="side-bar-toggler">Manage Notifications</label><span class="glyphicon glyphicon-hand-right fa-ālg"></span></li>
			  </ul>
		    </div>
			<label class="menu-toggle" for="side-bar-toggler">
			    <div class="menu-toggle-btn">
			      <span class="glyphicon glyphicon-cog"></span>
			    </div>
			</label>
		</div>
	<div class="account-details">
	  <div class="account">
		<h1>Account</h1>
		    <table class="table">
		      <tr>
		        <td>Primary Email</td><td><?=$user->email?></td>
		      </tr>
		      <tr>
		        <td>Password</td>
		        <td><button type="button" class="clean-btn"id="change-pass-btn">Change</button>
		            <span class="new-pass-area">
		               <input type="text" id="new-pass" placeholder="new password">
		               <button class="post-btn" id="post-new-pass">post</button>
		            </span>
		        </td>
		      </tr>
		    </table>
		</div>
	<div class="privacy">
		<h1>Privacy</h1>
		
		    <table class="table">
		      <tr>
		        <td><h4>Allow other users to follow you</h4></td>
		        <td><input type="checkbox"></td>
		      </tr>
		      <tr>
		        <td><h4>Don't consider me for expert finding</h4></td>
		        <td><input type="checkbox"></td>
		      </tr>
		    </table>
		    
		    <h3>Message Preferences</h3>
		    
		    <table class="table">
		    <tr>
		      <td><h4>Receive Message from anyone</h4></td>
		      <td><input type="radio"></td>
		    </tr>
		    <tr>
		      <td><h4>Receive Message from people I follow</h4></td>
		      <td><input type="radio"></td>
		    </tr>
		    <tr>
		      <td><h4>Do not receive message</h4></td>
		      <td><input type="radio"></td>
		    </tr>

		    </table>
		    
		    <h3>Comment Preferences</h3>
		    <hr>
		    <table class="table">
		      <tr>
		        <td><h4>Allow comments on your answers and posts</h4></td>
		        <td><input type="checkbox"></td>
		      </tr>
		    </table>
		    
		    <h3>Security</h3>
		    <hr>
		    <table class="table">
		      <tr>
		        <td><h4>Deactivate Account</h4></td>
			  </tr>
			  <tr>
			    <td><h4>Delete Account</h4></td>
			  </tr>
		    </table>
		</div>
		
		<div class="notification">
		<h1>Mail and OnSite Notifications</h1>
		<h3>Notification about posts </h3>
		    <table class="table">
		      <tr>
		        <td><h4>Notify me about new posts by persons I follow</h4></td>
		      </tr>
		      <tr>
		        <td>by mail</td><td><input type="checkbox"></td>
		      </tr>
		      <tr><td>by Onsite</td><td><input type="checkbox"></td>
		      </tr>
		      <tr>
		        <td><h4>Notify me about  Questions I follow</h4></td>
		      </tr>
		      <tr><td>All posts <input type="radio">
		      <br>Only Comments <input type="radio"><br>
		      Only Questions<input type="radio"></td></tr>
		      <tr>
		        <td>by mail</td><td><input type="checkbox"></td></tr>
	           <tr><td>by Onsite</td><td><input type="checkbox"></td>
		      </tr>
		      <tr><td><h4>Notify Me about My Posts</h4></td></tr>
		      <tr><td>by Mail</td><td><input type="checkbox"></td></tr>
		      <tr><td>by Onsite</td><td><input type="checkbox"></td></tr>    
		    </table>
		 <h3>Notification about Messages</h3>
		 <table class="table">
		    <tr><td><h4>Notify me when I receive a Message</h4></td></tr>
	        <tr><td>by Mail</td><td><input type="checkbox"></td></tr>
		   <tr><td>by Onsite</td><td><input type="checkbox"></td></tr> 		    
		 </table>
		</div>
     </div>

     </div>
     
  <script>
$(document).ready(function(){
$('.main-nav').hide();

	$("#change-pass-btn").on("click",function(){
	  $(this).hide();
	  $(".new-pass-area").show();
	});

     $("#post-new-pass").on("click",function(){
       var newPass=$("#new-pass").val();
       if($.trim(newPass)!=""){
           $.ajax({
                url:"pAccount.php",
                method:"post",
                data:{newpass:newPass},
                success:function(response){
	         	       $(".new-pass-area").hide();
	        	       $("#change-pass-btn").show();
                    }
               });

       }
       else{
    	   $(".new-pass-area").hide();
	       $("#change-pass-btn").show();
           }
     });


});

</script>   
<?php require 'footer.php';?>