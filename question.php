<?php require_once 'include/head.php';?>

<script src="include/code-prettify-master/src/run_prettify.js"></script>
<link rel="stylesheet" href="include/code-prettify-master/src/prettify.css">


<script>
/************************tag edit dropdown*******************/
$(function(){
	$(".tag-edit-dropdown-btn").on("click",function(){
            $(".tag-edit-dropdown-menu").slideToggle();
		})
})
/************************tag edit dropdown*******************/
/*****************Updating views*************************/
$(function(){
     setTimeout(updateView, 7000);
})

function updateView(){
   //alert("Boom!");
     if($("#qid").length>0){
	      var qid=$("#qid").val();
		  $.ajax({
	                url:"pQuestion.php",
	                method:"get",
	                data:{views:1,qid:qid}
			   });
     }
}
/********************Delete question***********************/
$(function(){
	if($("#deleted").length!=0){
       $("#deleted").after("<br><h2 style='color:red;'>Deleted</h2><br>");
       $("#deleted").after("<br><div id='ques-mask' style='position:absolute;background-color:rgba(255,26,26,.5);z-index:1000;width:100%;'></div>");
       $("#ques-mask").css({"height":$(".question-answer").height(),"width":$(".question-answer").width()});
	}
});


/******************Adding New tags*************************/
$(function(){
 $(".question-answer").on("click",".edit-tag",function(){
        $(".new-tag-input").toggle("show");
	 });
 $(".question-answer").on("click",".del-tag",function(){
        $(".delete-ques-tag-btn").toggle("show");
	 });

});
/************Reporting Answr or question*******************/
$(function(){
  	$(".question-answer").on("click",".report-btn",function(){
            if($(this).parent().find('input[name="aid"]').length >0)
            {
				$("#report").find('input[name="aid"]').val($(this).parent().find('input[name="aid"]').val());
				$("#report").find('input[name="qid"]').val('0');
            }
            else{
            	$("#report").find('input[name="qid"]').val("<?php echo $_GET['id'];?>");
				$("#report").find('input[name="aid"]').val('0');
            }
  	  	});


  	$('.post-report').on("click",function(){

  	  var aid= $('#report').find('input[name="aid"]').val();
  	  var qid= $('#report').find('input[name="qid"]').val();
  	  var message= $('#report textarea').val();
  	  //alert(message);
		 	 $.ajax({
			 	 url: "pQuestion.php",
			 	 data:{
                        message:message,
                        uid:<?php if($user->loggedin)echo $user->id;else echo 0;?>,
                        aid:aid,
                        qid:qid
				 	 },
			    success: function(result){
				    $("#report-result").html(result);
		             //alert(result);
		               },
		               method:'POST'
				  	});

  	});

});


/************************End*******************************/


/*****************follow button***********************/
$(function(){
	$('.question-answer').on("click",".follow-btn",function(){
		    action=$.trim($(this).html());
            $.get("pQuestion.php",{"action":action,"uid":<?php if($user->loggedin)echo $_SESSION['id'];else echo 0;?>,"qid":<?php echo $_GET['id'];?>},
            function(response){
                 response=$.trim(response);
				 $(".follow-btn").html(response);
             });
		});
});
/***************managing the Comments*************************/

$(function()
		{
		  $('.question-answer').on("click",".post-cmt-btn",function()
		    {
		        var parent =$(this).parent();
		        var comment_area = parent.find('textarea[name="comment"]');
		        var comment = comment_area.val();

		        if(jQuery.trim( comment ).length!=0)
			        {
		        	var username=$('#username').val();
		        	var uid=$('#uid').val();
		        	   var comment_box= parent.parent();

				       var qid=<?php echo $_GET['id'];?> ;
				       var aqid=qid;
				        if(parent.find('input[name="aid"]').length>0)
					        {

				               aid=parent.find('input[name="aid"]').val();
				               $.post("pComment.php",{"aqid":aqid,"uid":uid,"aid":aid,"comment":comment,"username":username},function(response)
						          {
							          response=$.trim(response);
							          if(response!="error"){
								       comment_box.before("<div class='well comment-box'>"+
								    		   '<input type="hidden" name="cmt-body" value="'+comment_area.val()+'">'+
									               '<div class="cmt-body">'+comment_area.val()+
									               '<a href="profile.php?uid='+uid+'"><span class="cmt-author">--'+username+'</span></a></div>'+
									              '<div class="cmt-options">'+
									                   '<div class="dropdown">'+
										                   '<button class="clean-btn dropdown-toggle" type="button" data-toggle="dropdown">'+
										                   '<span class="glyphicon glyphicon-option-vertical"></span></button>'+
										                   '<input type="hidden" name="cid" value="'+response+'">'+
										                       '<ul class="dropdown-menu">'+
															      '<li><button  class="cmt-btn clean-btn">Edit</button></li>'+
															      '<li><button  class="cmt-btn clean-btn">Delete</button></li>'+
															   '</ul>'+
										               '</div>'+
									              '</div>'+
										        "</div>");

					                   comment_area.val(" ");
						               comment_box.slideToggle();
							          }
							          else alert("error");
					              });
				            }
				        else
				           {
					          var ques_sub = comment_box.parent().find(".ques-sub");
				        	  $.post("pComment.php",{"qid":qid,"uid":uid,"comment":comment,"username":username},function(response)
						          {
						          response=$.trim(response);
				        		    ques_sub.append("<div class='well comment-box'>"+
				        		    		'<input type="hidden" name="cmt-body" value="'+comment_area.val()+'">'+
								               '<div class="cmt-body">'+comment_area.val()+
								               '<a href="profile.php?uid='+uid+'"><span class="cmt-author">--'+username+'</span></a></div>'+
								              '<div class="cmt-options">'+
								                   '<div class="dropdown">'+
									                   '<button class="clean-btn dropdown-toggle" type="button" data-toggle="dropdown">'+
									                   '<span class="glyphicon glyphicon-option-vertical"></span></button>'+
									                   '<input type="hidden" name="cid" value="'+response+'">'+
									                       '<ul class="dropdown-menu">'+
														      '<li><button  class="cmt-btn clean-btn">Edit</button></li>'+
														      '<li><button  class="cmt-btn clean-btn">Delete</button></li>'+
														   '</ul>'+
									               '</div>'+
								              '</div>'+
									        "</div>");
						        	  comment_area.val(" ");
						        	  comment_box.slideToggle();
				            	  });
				            }
		         }

	    });
	});


$(function(){
	$('.fav-button').on("click",".fav-btn",function(){
		//alert("hii");
		var id=$(this).attr('id');
        $('.fav-button').load("addFav.php",{"action":id,"qid":<?php echo $_GET['id'];?>});
		});
    $('#open-ansbox').one("click",function(){
        $("#ansbox").load("ansbox.php",{"qid":<?php echo $_GET['id'];?>});
        $("body").animate({ scrollTop: $('body').prop("scrollHeight")}, 1000);
        });

});
/*****************Vote Question and Answer*********************/
$(function(){
	$('.question-answer').on("click",".vote",function(){
		   var  vote=$(this).attr('id');
		   var  parent=$(this).parent();
		    if(vote.replace("upvote-","")=="ques" || vote.replace("downvote-","")=="ques")
		    {
			  vote=vote.replace("-ques","");
			  $.post("addVote.php",{"vote":vote,"qid":<?php echo $_GET['id'];?>},function(response){
				  response=$.trim(response);
				    if(response!=0){
						parent.html($.trim(response));
				    }
				  });
		    }
		    else
		    {

				  vote=vote.replace("-ans","");
				  var ansId= parent.parent().find('input[name="aid"]').val();

				  $.post("addVote.php",{"vote":vote,"aid":ansId},function(response){
					  response=$.trim(response);
					    if(response!=0){
							parent.html($.trim(response));
					    }
				  });
			}

		});
});


/****************delete Answer************************/
 $(function(){
   $(".question-answer").on("click",".ans-del-btn",function(){
	  var parent=$(this).parent();
	  var aid=$(this).parent().parent().find('input[name="aid"]').val();
	  var qid= $('#qid').val();

          $.ajax({
                  url:"deleteAns.php",
                  data:{ans_del:"delete",
						aid:aid,
						qid:qid
                      },
                  method:'POST',
                  success:function(response){
						if($.trim(response)=="success")
							{
								parent.parents(".answer-area").hide("slow");
							}
						else {
							alert("failed");

						}
                      }
               });

	   });

});
</script>
<?php require_once 'header.php';
$filter=new filter_class();

$tags=new item_class("question_tags");
$tag_details=new item_class("tags");

if($user->loggedin)
{
	$user->id=$_SESSION['id'];
	$fav=new item_class();
	$fav->set("favourite_question");


	$voteQues=new item_class();
	$voteQues->sql_query("select * from vote_details where uid=$user->id and qid= $_GET[id]");
	if($voteQues->num_rows==1){
		$vote_datas=$voteQues->load_datas();
		$voteId=$vote_datas['id'];
		$voteQues->set("vote_details",$voteId);
		$voteQues->load_vars();
	}
	else {
		$voteQues->up=0;
		$voteQues->down=0;
	}

}
if(isset($_GET['id']) && $_GET['id']!='')
{
	$question=new item_class();
	$id=$_GET['id'];
	$question->set('questions',$id);
	$question->load_vars();
	if($question->num_rows==0)
		die("<h1>No Question Selected</h1>");
	$answer=new item_class();
	$answer->set("answers");
	$answer->sql_query("select * from answers where qid='$id'");
  //$answer->sql_query("select * from users RIGHT JOIN answers ON answers.uid=users.id WHERE answers.qid=$id");
  $ans_auth=new user_class();
  $ques_auth=new user_class();

}
else{
	die("<h1>No question selected</h1>");
}
?>
<input type="hidden" id="qid" value="<?=$id?>">
<!-- Modal -->
<div id="report" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Report</h4>
      </div>
      <div class="modal-body">
		 <form role="form">
			  <div class="form-group">
			    <input type="hidden" name="aid" value=0>
			    <input type="hidden" name="qid" value=0>
			    <textarea  class="form-control" id="report-mess">Your Message</textarea>
			    <button type="button" class="post-btn post-report">post</button>
			  </div>
			</form>
      </div>
      <div class="modal-footer">
        <div id="report-result"></div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div class="container question-answer"style="postion:relative;">
<?php if($question->deleted==1){
	echo '<input type="hidden" id="deleted" value=1>';
}?>
  <div class="header">

  <?php
     if($user->loggedin){
          $fav->sql_query("select * from favourite_question where uid='$user->id' and qid='$id'");
             if($fav->num_rows)
		  	        {
		  	        	$fav->isfav=true;
		  	        }
		  	        else {
		  	        	$fav->isfav=false;
		  	        }
  ?>

   	 <div class="fav-button">
   	 <?php
   	 if($fav->isfav){
   	 	echo "<button type=button class='fav-btn clean-btn' id=fav-del><span class='selected glyphicon glyphicon-star fa-2x'></span></button>";
   	 }
   	 else {
   	 	echo "<button type=button class='fav-btn clean-btn' id=fav-add><span class='glyphicon glyphicon-star-empty fa-2x'></span></button>";
   	 }

   	 ?>
     </div>
   <?php }?>

     <div class="ques-title"><?php echo $question->title;?></div>
  </div>
      <div class="wrap-main-question-answer">
		 <div class="text-left main-question-answer">
		   <div class="ques-area">
		     <div class="ques-container">
		       <div class="vote-container">
		          <?php if($user->loggedin){?>
		                    <?php if($voteQues->up==1){?>
					       <button id="upvote-ques" class="vote selected clean-btn glyphicon glyphicon-triangle-top fa-2x"></button>
					         <?php }else{?>
					       <button id="upvote-ques" class="vote clean-btn glyphicon glyphicon-triangle-top fa-2x"></button>
					         <?php }?>
					         <span><?php echo $question->vote;?></span>
		                    <?php if($voteQues->down==1){?>
					       <button id="downvote-ques"class="vote selected clean-btn glyphicon glyphicon-triangle-bottom fa-2x"></button>
					         <?php }else{?>
					       <button id="downvote-ques" class="clean-btn vote glyphicon glyphicon-triangle-bottom fa-2x"></button>
					         <?php }?>
			       <?php }?>
			    </div>



              <div class="ques-body-container">
				      <div class="related-tags">
					         <?php $tags->sql_query("select * from question_tags where qid=$id");
					               while($tag_id=$tags->load_datas()){
					              	  $tag_details->set("tags",$tag_id['tid']);
					              $tag_details->load_vars();
					              if($tag_details->num_rows>0){
					               ?>

			                     <div class="related-tag">
			                     <input type="hidden" id="tid" value='<?=$tag_details->id?>'>
			                     <div class="wrap-tag"><?=$tag_details->tag;?><span class="delete-ques-tag-btn">✖</span></div>
			                        <div class="related-tag-details"></div>
			                     </div>

			                     <?php }}?>

		                     <input type="text" id="new-tag" name="new-tag" class="new-tag-input">

												 <?php if($user->loggedin){
																	if($user->admin==1 or $user->moderator==1 or $user->id == $question->owner_id){ ?>
												<div class="ques-tag-edit-container">
														<button class="clean-btn tag-edit-dropdown-btn" type="button">
														<span class="caret"></span></button>
														<ul class="tag-edit-dropdown-menu">
																<li><button class="clean-btn  edit-tag">Add</button></li>
																<li><button class="clean-btn  del-tag">Delete</button></li>
														</ul>
												</div>
  											<?php } }?>

	                  </div>
			    <div class="tag-sug-container"></div>
	      <div class="ques-body">
	         <?php echo $question->body;?>
	      </div>
        </div>

		     </div><?php $ques_auth->sql_query("select * from users where id=$question->owner_id");
                  $auth_data=$ques_auth->load_datas();?>
        <div class="post-auth-container">
         <div class="post-auth-wrap">
	          <span class="time" data-livestamp="<?=$question->creation_date?>"></span>
	          <div class="post-auth">

		            <div class="auth-photo">

		              <img src="<?=$auth_data['profile_image']?>">
		            </div>
		            <div class="auth-details">
		              <a href="profile.php?uid=<?=$auth_data['id']?>"><?=$auth_data['username']; ?></a>
		            </div>
	          </div>
           </div>
        </div>

		      <?php $i=0;?>
                <div class="ques-sub">
		         <?php if($user->loggedin){?>
		           <div class="content-options" id="options">
			             <div class="content-option"><button class="tool" id="open-ansbox">Your Answer</button></div>

			             <?php $follow_ques=new item_class();
			                   $follow_ques->sql_query("select * from friends_questions where uid=$user->id and qid=$question->id and follow=1");
			                   if($follow_ques->num_rows>0){?>
			             <div class="content-option"><button class="tool follow-btn">unfollow</button></div>
			                   <?php }else{?>
			             <div class="content-option"><button class="tool follow-btn">follow</button></div>
			                   <?php }?>

			             <div class="content-option"><button class="tool">share</button></div>
		<!-- fb share*************************/ -->
			             <div class="fb-share-button" data-href="http://localhost:3333/proj/question.php" data-layout="button"></div>
			             <div id="fb-root"></div>

			             <div class="content-option">
					         <button class="tool open-comment" type="button" id="<?php echo "comment".$i."btn";?>">add comment</button>
					     </div>
			             <div class="content-option"><button class="tool open-action" id="<?php echo "action".$i."menu-btn";?>"><span class="glyphicon glyphicon-option-horizontal"></span></button>
			               <ul class="action-menu" id="<?php echo "action".$i."menu";?>">

											 <?php if($user->loggedin){
												    if($user->admin==1 or $user->moderator==1 or $user->id==$question->owner_id){?>
				                 <li class="action"><a  href="editQuestion.php?qid=<?=$id?>">edit</a></li>
												   <?php if($user->admin==1 or $user->id==$question->owner_id){ ?>
				                      <li class="action"><a href="pQuestion.php?action=del&qid=<?php echo $id;?>">delete</a></li>

											 <?php }} }?>
			                 <li class="action">
			                      <button class="report-btn clean-btn" type="button" data-toggle="modal" data-target="#report">Report Answer</button></li>

			               </ul>

			             </div>
		           </div>
		       <?php }?>
<?php 	/********************* displaying comments on question**********************/?>
		           <?php $comment=new item_class();
		                 $comment->set("comments");
		                 $comment->sql_query("select * from comments where qid=$id");
		                 while($ques_comment=$comment->load_datas()){

				           ?>

				           <div class="well comment-box">
					              <div class="cmt-body">
					                <input type="hidden" name="cmt-body" value="<?php echo $ques_comment['body'];?>">
					                <?php echo $ques_comment['body'];?>
					                <span class="cmt-author">--<a href="profile.php?uid=<?php echo $ques_comment['uid']?>">
					                <?php echo $ques_comment['username'];?></a></span>
					              </div>
					              <?php if($ques_comment['uid']==$user->id){?>
					              <div class="cmt-options">
					                   <div class="dropdown">
						                   <button class="clean-btn dropdown-toggle" type="button" data-toggle="dropdown">
						                   <span class="glyphicon glyphicon-option-vertical"></span></button>
						                     <input type="hidden" name="cid" value="<?php echo $ques_comment['id'];?>">
						                       <ul class="dropdown-menu">
											      <li> <button  class="cmt-btn clean-btn">Edit</button></li>
											      <li> <button  class="cmt-btn clean-btn">Delete</button></li>
											   </ul>
						               </div>
					              </div>
					              <?php }?>
				           </div>

		           <?php }  ?>
		           </div>
		         <?php if($user->loggedin){?>
				    <div class="form-group comment-textarea" id="<?php echo "comment".$i;$i++;?>">
					    <form>
						  <textarea class="form-control" rows="3" name="comment"></textarea>
						  <button type="button" class="post-btn post-cmt-btn" name="ques-post">post</button>
						</form>
					</div>
			 <?php }?>
		       </div>


<?php /******************Answer starts here***************************/?>


		      <div class="ans-container">
			      <?php if($answer->num_rows>0){

			      while($data=$answer->load_datas())

			      {
              $ans_auth->sql_query("select * from users where id=$data[uid]");
              $auth_data=$ans_auth->load_datas();
			      ?>
			    <div class=answer-area>

			      <div class="ans-body">
				         <div class="vote-container">

				     <?php if($user->loggedin){

				       	$voteAns=new item_class();
						$voteAns->sql_query("select * from vote_details where uid=$user->id and aid=$data[id]");
						if($voteAns->num_rows==1){
							$vote_datas=$voteAns->load_datas();
							$voteId=$vote_datas['id'];
							$voteAns->set("vote_details",$voteId);
							$voteAns->load_vars();
						}
						else {
							$voteAns->up=0;
							$voteAns->down=0;
						}

		                    if($voteAns->up==1){?>
					       <button id="upvote-ans" class="vote selected clean-btn glyphicon glyphicon-triangle-top fa-2x"></button>
					         <?php }else{?>
					       <button id="upvote-ans" class="vote clean-btn glyphicon glyphicon-triangle-top fa-2x"></button>
					         <?php }?>
					         <span><?php echo $data['vote'];?></span>
		                    <?php if($voteAns->down==1){?>
					       <button id="downvote-ans" class="vote selected clean-btn glyphicon glyphicon-triangle-bottom fa-2x"></button>
					         <?php }else{?>
					       <button id="downvote-ans" class="vote clean-btn glyphicon glyphicon-triangle-bottom fa-2x"></button>
					         <?php }?>
			       <?php }?>

					    </div>
				        <div class="answer">

				            <?php
				            echo "$data[body]";?>
				            <input type="hidden"  name="aid" value="<?php echo $data['id'];?>">
				        </div>
			      </div>
            <div class="post-auth-container">
               <div class="post-auth-wrap">
	               <span class="time"data-livestamp="<?=$data['date_created']?>"></span>
	              <div class="post-auth">
	                <div class="auth-photo">
	                  <img src="<?=$auth_data['profile_image']?>">
	                </div>
	                <div class="auth-details">
	                  <a href="profile.php?uid=<?=$auth_data['id']; ?>"><?=$auth_data['username'] ;?></a>
	                </div>
	              </div>
	            </div>
            </div>
			    <?php if($user->loggedin){?>
		           <div class="content-options" >
			             <div class="content-option"><button class="tool">share</button></div>
			             <div class="content-option">
					         <button class="tool open-comment " type="button" id="<?="comment".$i."btn";?>">add comment</button>
					     </div>
			             <div class="content-option"><button class="tool open-action" id="<?="action".$i."menu-btn";?>"><span class="glyphicon glyphicon-option-horizontal"></span></button>
			               <ul class="action-menu" id="<?php echo "action".$i."menu";?>">
											 <?php if($user->admin==1 or $user->moderator==1 or $data['uid']==$user->id){ ?>
			                 <li class="action"><a href="editQA.php?qid=<?=$id;?>&aid=<?=$data['id'];?>">edit</a></li>
											 <?php  if($user->admin==1 or $data['uid']==$user->id){?>
			                 <li class="action"><button type="button" class="ans-del-btn clean-btn">delete</button></li>
											<?php } }?>
			                 <li class="action">
			                 <input type="hidden" name="aid" value="<?=$data['id'];?>">
			                 <button class="report-btn clean-btn" type="button" data-toggle="modal" data-target="#report">Report Answer</button></li>
			                 
			               </ul>

			             </div>
		           </div>
		       <?php }?>
 <?php     	/********************* displaying comments on Answers**********************/?>
		           <?php

		                 $comment->sql_query("select * from comments where aid='$data[id]'");

		                 while($ans_comment=$comment->load_datas()){

		           ?>

			           <div class="well comment-box">
			            <input type="hidden" name="cmt-body" value="<?php echo $ans_comment['body'];?>">
			              <div class="cmt-body">
			                  <?php echo $ans_comment['body'];?>
			                  <span class="cmt-author">--<a href="profile.php?uid=<?php echo $ans_comment['uid'];?>">
			                  <?php echo $ans_comment['username'];?></a></span>
			              </div>
			               <?php if($ans_comment['uid'] == $user->id){?>
			              <div class="cmt-options">
			                   <div class="dropdown">
				                   <button class="clean-btn dropdown-toggle" type="button" data-toggle="dropdown">
				                   <span class="glyphicon glyphicon-option-vertical"></span></button>
				                     <input type="hidden" name="cid" value="<?=$ans_comment['id'];?>">
				                       <ul class="dropdown-menu">
									      <li><button  class="cmt-btn clean-btn">Edit</button></li>
									      <li><button  class="cmt-btn clean-btn">Delete</button></li>
									    </ul>
				               </div>
				          </div>
				           <?php }?>
			           </div>

		           <?php }?>

			       <?php  if($user->loggedin){?>
				       <div class="form-group comment-textarea" id="<?php echo "comment".$i;$i++;?>">
				         <form>
						   <textarea class="form-control" rows="3" name="comment"></textarea>

						   <input type="hidden" name="aid" value="<?php echo $data['id'];?>">

						   <button type="button" class="post-btn post-cmt-btn" name="ans-post">post</button>
						 </form>
					   </div>
			      <?php }?>
			      </div>
			 <?php }?>

			  <?php    }?>
			      </div>
           </div>

		    <div class="question-right-side">
		      <div class="question-details-container">
		         <div class="question-details">
		            <span>viewed  :</span><span><?=$question->_views?></span>
		         </div>
		      </div>
              <div class="related-ques-container">
		        <p>Related questions</p>
		        <hr>
		        <div class="wrap-related-posts">
		          <div class="related-posts">

		          </div>
		        </div>
			  </div>

		   </div>
	</div>
</div>
<div id="ansbox">


</div>
<script>
 $(function(){
   $(".tag-sug-container").hide();
   $("#new-tag").on("keyup",function(e){

           var tag=$(this).val();
            if($.trim(tag)!=""){
             $.ajax({
                  url:"tagSuggest.php",
				  method:"post",
				  data:{tag:tag},
				  success:function(response){
					  $(".tag-sug-container").show();
							  if($.trim(response)!=""){
		                       $(".tag-sug-container").html(response);
							  }else $(".tag-sug-container").hide();

					  }
                });
            }
            else $(".tag-sug-container").hide();


	   });


 $(".tag-sug-container").on({

    mouseleave:function(){$(this).find(".mask-suggested-tag").hide();},
    mouseover:function(){$(this).find(".mask-suggested-tag").show();},
    click:function(e)
     {
        		var qid=$("#qid").val();
    	        var tag=$.trim($(this).find(".suggested-item-name").html());
    	        var tid=$(this).find("input[name='tid']").val();
    	        $("#new-tag").val(tag);
    	        //alert(tag);
    	        $.ajax({
					url:"manageQuestionTags.php",
					method:"post",
					dataType:"json",
					data:{tid:tid,qid:qid,action:'add'},
					tagName:tag,
					success:function(response){
						   $(".tag-sug-container").hide();
						   $("#new-tag").val("");
						   if($.trim(response.out)=="success"){
						       $("#new-tag").before(
						    	         '<div class="related-tag">'+
						                     '<input type="hidden" id="tid" value='+response.tid+'>'+
						                     '<div class="wrap-tag">'+this.tagName+'<span class="delete-ques-tag-btn">✖</span></div>'+
						                        '<div class="related-tag-details"></div>'+
						                     '</div>');
						   }
						   else alert("Server Error");
						       $(".edit-tag").trigger("click");

						}
        	        });
        },
	 },".suggested-item");

 $(".related-tags").on({
     click:function(){
         var tag=$(this).parents(".related-tag");
         var tid=tag.find("input").val();
         var qid=$("#qid").val();

         $.ajax({
				url:"manageQuestionTags.php",
				method:"post",
				dataType:"json",
				data:{tid:tid,qid:qid,action:"del"},
				success:function(response){
				 if(response.out=="success")
					tag.hide();
				 else alert("Server Error");
				}

 	        });

        }
	 },".delete-ques-tag-btn");

 });
 /***********************facebook share button*******************

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=958210194216458";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

***********load related posts**********/
$(function(){
var qid= $('#qid').val();
$.ajax({
url:"loadRelatedPosts.php",
data:{qid:qid},
method:"post",
success:function(response){
	$(".related-posts").html(response);
}
})

})

 </script>


<?php require_once 'footer.php';?>
