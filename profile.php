<?php require_once 'include/head.php';
if (!$user->loggedin){
header('Location:login.php');
}?>

<?php require_once 'header.php';

$tags=new item_class();
$user_tags=new item_class();
$tags->set('tags');
$user_tags->set('user_tags');
if(isset($_GET['uid']) && $user->loggedin)
{
	$uid=$_GET['uid'];
	$friend=new user_class();
	$friend->set("users",$uid);
	echo $friend::$link->error;
	$friend->load_vars();
	  if($user->id==$friend->id){
	  	$friend->same=true;
	  }else $friend->same=false;
}
elseif($user->loggedin){

	$friend=new user_class();
	$friend->set("users",$user->id);
	$friend->load_vars();
	echo $friend::$link->error;
	$friend->same=true;
}
elseif(isset($_GET['uid'])){
	$uid   =$_GET['uid'];
	$friend=new user_class();
	$friend->set("users",$uid);
	$friend->load_vars();
    $friend->same=false;
}
else
{
	die("<h1>No User Selected</h1>");
}
?>

<script>
/***********************load user questions********/
$(function(){
	var id=$("#get-friend-id").val();
$("#ques").load("userQuestions.php",{id:id});
$("#ans").load("userAnswers.php",{id:id});
$("#cms").load("userComments.php",{id:id});

})

/**************************************************/


/*****************profile image********************/
  $(function(){
	  $( "#tabs" ).tabs();
	  //$('.main-nav').hide();
         $("#avatar-in").hide();
         $("#avatar").on({
             mouseenter:function(){
        	 $("#avatar-edit").fadeIn(100);
             }
         });
         $("#avatar-edit").on({
        	 mouseleave:function(){
            	   $(this).fadeOut(100);
            	 },
        	 click:function(){
				   $("#avatar-in").trigger("click");
            	 }
          });


          $("#avatar-form").on("change","#avatar-in",function(){
        	  var filesSelected = document.getElementById("avatar-in").files;
        		if (filesSelected.length > 0)
        		{
        		    var fileToLoad = filesSelected[0];

        		    if (fileToLoad.type.match("image.*"))
        		    {
        		        var fileReader = new FileReader();
        		        fileReader.onload = function(fileLoadedEvent)
        		        {
        					   $.ajax({
        						   url: 'pProfile.php',
        						   type: 'POST',
        						   cache: false,
        						   contentType: false,
        						   data: new FormData($('#avatar-form')[0]), // The form with the file inputs.
        						   processData: false,                         // Using FormData, no need to process data.
        						   success:function(response){
        		        		        var src = fileLoadedEvent.target.result;
        		        		        $("#avatar").attr("src",src);
        							   }
        						 });


        		        };
        		        fileReader.readAsDataURL(fileToLoad);
        		    }
        		    else{alert("This file is not a supported");}
        		}

		   });


  });


/********************follow button*****************/
 $(function(){
	$('.follow-btn').on("click",function(){
		    action=$.trim($(this).html());
            $.get("pProfile.php",{"action":action,"uid":<?php echo $_SESSION['id'];?>,"fid":
            <?php if(isset($_GET['uid']))
            		echo $_GET['uid'];
                  else echo 0;
            	?>},
            function(response){
                response=$.trim(response);
				 $(".follow-btn").html(response);
             });
		});
});
/*************************************/
/********************block button*****************/
 $(function(){
	$('.block-btn').on("click",function(){
		    action=$.trim($(this).html());
            $.get("pProfile.php",{"action":action,"uid":<?php echo $_SESSION['id'];?>,"fid":
            <?php if(isset($_GET['uid']))
            		echo $_GET['uid'];
                  else echo 0;
            	?>},
            function(response){
                response=$.trim(response);
				 $(".block-btn").html(response);
             });
		});
});
/*************************************/

</script>


<div class=container>

	<div class="jumbotron bio-jumbotron">

	   <div class="bio">
		  <div id="avatar-area">
			  <img id="avatar" src="<?php echo $friend->profile_image;?>" class="img-rounded" alt="your image" width="152" height="152">
			  <?php if($user->id==$friend->id){?><div id="avatar-edit"><span class="glyphicon glyphicon-pencil"></span>edit</div>
			  <?php }?>
		  </div>

		  <form enctype="multipart/form-data" id="avatar-form">
		    <input type="file" name="avatar-in" id="avatar-in">
		  </form>

			<?php if($friend->status==1){?>
			<input type="hidden" id="get-friend-id" name="user-id" value="<?php echo $friend->id;?>">

			<div id="online-profile" class="online-status"><span class="green-color">◉</span></div>
			<?php } else {?>
			<input type="hidden" id="get-friend-id" name="user-id" value="<?php echo $friend->id;?>">

			<div id="offline-profile" class="online-status"><span class="red-color">◉</span></div>
			<?php }?>
			
		  <div class="bio-data">
		     <?php echo "<div class=username-area>
		                   <h4><span id=dis-username>$friend->username</span>";
            	  if($friend->id==$user->id){
		                echo"<button class=clean-btn id=changeusername><span class='glyphicon glyphicon-pencil'></span></button>
                         </h4></div>";
            echo "<div class=change-username>
		           <input type=text id=newusername >
                  <button type=button id=post-username-btn class=clean-btn><span class='glyphicon glyphicon-thumbs-up'>
		          </span></button>";

            	  }
           echo "</div>";
		echo"<div class=abtme-area>
		  <span id=dis-abtme>";
	          if($friend->aboutme==null){
	            echo "Apparently, this user prefers to keep an air of mystery about them";
	          }
	          else
	          {
	            echo $friend->aboutme;
	          }
	          echo"</span>";
			if($user->id==$friend->id){
	     echo"<button class=clean-btn id=changeabtme><span class='glyphicon glyphicon-pencil'></span></button>
	  	</div>
		 <div class=change-abtme>
	  		<textarea id=newabtme></textarea>
            <button type=button id=post-abtme-btn class=clean-btn><span class='glyphicon glyphicon-thumbs-up'>
		</span></button>";
			}
	  echo"</div>
	          <p>Reputation<span class=badge>$friend->reputation</span></p>";?>
		  </div>
	   </div>
	           <?php if($user->id!=$friend->id){?>
	   	           <div class="content-options">
   	           		<?php $followed=new item_class();
                        $followed->sql_query("select * from friends_questions where uid=$user->id and fid=$friend->id");
                        $data=$followed->load_datas();
                        if($data['follow']==1){?>
				             <div class="content-option"><button class="tool follow-btn">unfollow</button></div>
				         <?php }else {?>
				             <div class="content-option"><button class="tool follow-btn">follow</button></div>
				             <?php }
                        if($data['block']==1){?>
				             <div class="content-option"><button class="tool block-btn">unblock</button></div>
				         <?php }else {?>
				             <div class="content-option"><button class="tool block-btn">block</button></div>
				             <?php }?>



				             <div class="content-option"><a class="tool" href="chat.php?fid=<?php echo $friend->id?>" target="_blank">chat</a></div>
		           </div>
		           <?php }?>
	</div>

 <?php $fw_fid=new user_class("friends_questions");
       $fw_fdetails=new user_class();
       $fw_fid->sql_query("select * from friends_questions where uid=$friend->id");

 ?>
   <div class="activities">
      <div class="row-nowrap">
		<div class="following-container">
		    <p>People you follow</p>
			  <div class="following-list">
				  <?php $fw_not_nil=0;while($f_list=$fw_fid->load_datas()){
				  	  if($f_list['fid']!=null){
				  	  	 $fw_not_nil=1;
				  	     $fw_fdetails->set("users",$f_list['fid']);
				         $fw_fdetails->id=$f_list['fid'];
				         $fw_fdetails->load_vars();
				  	?>

				    <div class="following-list-item">
				        <div class="list-item-image">
				         <img src="<?php echo $fw_fdetails->profile_image;?>" height=50px width=50px>
				        </div>
				        <div class="list-item-username"><a href="profile.php?uid=<?php echo $fw_fdetails->id;?>">
				           <?php  echo $fw_fdetails->username;?></a></div>
				    </div>
				  <?php }
				  	  }if($fw_not_nil==0)echo "<h4>Nothing yet</h4>";?>
			  </div>
		</div>
	    <div class="users-postTag-container">
	      <?php
	      $user->sql_query("CALL getPostTagOfUserId($friend->id)");
	            while($postTag=$user->load_datas()){
	      ?>
	         <div class="wrap-posted-tags-details">
	            <div class="posted-tag"><?=$postTag['tag']?></div>
	            <div class="mul-symbol">✖</div>
	            <div class="post-count"><?=$postTag['count']?></div>
	         </div>
	         <?php }?>
	    </div>
      </div>
		  <div class="text-center main-activities">
		    <h3>My Activities</h3>

			   <div id="tabs">
				  <ul>
				    <li><a href="#ques">Questions</a></li>
				    <li><a href="#ans">Answers</a></li>
				    <li><a href="#cms">Comments</a></li>
				    <li><a href="#fw-ques">Followed Questions</a></li>
				    <li><a href="#edits">Edits</a></li>
				  </ul>

					  <div id="ques" >

					  </div>

					  <div id="ans">

					  </div>

					  <div id="cms">

					  </div>

					  <div id="fw-ques">
					         <?php $fw_qid=new item_class();
					               $fw_qid->set("friends_questions");
					               $fw_qid->sql_query("select * from friends_questions where uid=$friend->id");

					               $fw_not_nil=0;
					               while($fw_qid_var=$fw_qid->load_datas()){
					               $fw_qid_details=new item_class();
					               if($fw_qid_var['qid']!=null){
						               $fw_qid_details->set("questions",$fw_qid_var['qid']);
						               $fw_qid_details->load_vars();
						               $fw_not_nil=1;
						               ?>

										    <div class="row">
										      <?php  echo "<a href=question.php?id=$fw_qid_details->id>$fw_qid_details->title</a>";?>

										    </div>
										  <?php }
					               }
					               if($fw_not_nil==0) echo "<h1>Nothing to display</h1>";?>
					</div>

				  <div id="edits">


				  </div>

		   </div>
		  </div>
	</div>
</div>
<script>
/**************edit username and about me***************/
 $(function(){

$("#changeusername").on("click",function(){
	  $(".username-area").hide();
	  $(".change-username").show();
	  $("#newusername").val($.trim($("#dis-username").html()));
	});
$("#changeabtme").on("click",function(){
	  $(".abtme-area").hide();
	  $(".change-abtme").show();
	  $("#newabtme").val($.trim($("#dis-abtme").html()));
	});

   $("#post-username-btn").on("click",function(){
     var newusername=$("#newusername").val();
     $("#newusername").val("");
     if($.trim(newusername)!=""){
         $.ajax({
              url:"pProfile.php",
              method:"post",
              data:{newusername:newusername},
              success:function(response){
	         	       $(".username-area").show();
	        	       $(".change-username").hide();
       	               response=$.trim(response);
       	               $("#dis-username").html(response);
                  }
             });

     }
     else{
    	 $(".username-area").show();
	       $(".change-username").hide();
         }
   });

   $("#post-abtme-btn").on("click",function(){
     var newabtme=$("#newabtme").val();
     $("#newabtme").val("");
     if($.trim(newabtme)!=""){
         $.ajax({
              url:"pProfile.php",
              method:"post",
              data:{newabtme:newabtme},
              success:function(response){
            	  $(".abtme-area").show();
            	  $(".change-abtme").hide();
       	               response=$.trim(response);
       	               $("#dis-abtme").html(response);
                  }
             });

     }
     else{
   	  $(".abtme-area").show();
	  $(".change-abtme").hide();
         }
   });

  });
</script>
<?php require_once 'footer.php';?>
