<?php
session_start();
require_once '/include/lib.php';
$user=new user_class();
if (isset($_SESSION['id']))
{
	$user->id=$_SESSION['id'];
	$user->loggedin=true;
	$user->set('users',$user->id);
	$user->load_vars();
}
else $user->loggedin=false;
$auth=new item_class("vote_details");
$upvoted=0;
$downvoted=0;
$friend=new user_class();
if(isset($_POST['qid'])){
	$vote_action=$_POST['vote'];
	$qid = $_POST['qid'];
	$voteQues=new item_class();
	$voteQues->set("questions",$qid);
	$voteQues->load_vars();
	$uid=$voteQues->owner_id;
	$friend->set("users",$uid);
	$friend->load_vars();
$f=new user_class();
	$auth->sql_query("select * from vote_details where uid=$user->id and qid=$qid");
	$auth_data=$auth->load_datas();
	$auth->set("vote_details",$auth_data['id']);
	  if($auth->num_rows==1){

			if($vote_action=="upvote"){
				$auth->sql_query("select * from vote_details where uid=$user->id and qid=$qid and down=1");
				if($auth->num_rows==1){
					$vote=$voteQues->vote +1;

					$update=array("vote"=>$vote);
					$voteQues->update($update);
					/*******************update user reputation***********/
					$friend->quesDownVote(1);

					/**************update tag score on users**********/
										$friend->sql_query("select * from question_tags where qid=$qid");


										while($tag_data=$f->load_datas()){
											$f->quesScoreOnVote($tag_data['tid'],1);
										}
					/****************************************************/
					$auth->delete();

					echo "
		  		<button id=upvote-ques class='vote clean-btn glyphicon glyphicon-triangle-top fa-2x'></button>
		        <span>$vote</span>
		        <button id=downvote-ques class='clean-btn vote glyphicon glyphicon-triangle-bottom fa-2x'></button>";
				}


			}
			else {
				$auth->sql_query("select * from vote_details where uid=$user->id and qid=$qid and down=0");
				if($auth->num_rows==1){

					$vote=$voteQues->vote-1;

					$update=array("vote"=>$vote);
					$voteQues->update($update);
					/*******************update user reputation***********/
					$friend->quesUpVote(1);


										/**************update tag score on users**********/
															$f->sql_query("select * from question_tags where qid=$qid");

															while($tag_data=$f->load_datas()){
																$friend->quesScoreOnVote($tag_data['tid'],0);
															}
										/****************************************************/
					/****************************************************/
					$auth->delete();

				echo "
		  		<button id=upvote-ques class='vote clean-btn glyphicon glyphicon-triangle-top fa-2x'></button>
		        <span>$vote</span>
		        <button id=downvote-ques class='clean-btn vote glyphicon glyphicon-triangle-bottom fa-2x'></button>";
				}

			}
	  }
	  else{
		  	if($vote_action=="upvote"){
		  		$vote=$voteQues->vote+1;
		  		$update=array("vote"=>$vote);
		  		$voteQues->update($update);
		  		$auth_data=array("uid"=>$user->id,"qid"=>$qid,"up"=>1,"down"=>0);
		  		$auth->insert($auth_data);

		  		/*******************update user reputation***********/
		  		$friend->quesUpVote();


										/**************update tag score on users**********/
															$f->sql_query("select * from question_tags where qid=$qid");

															while($tag_data=$f->load_datas()){
																$friend->quesScoreOnVote($tag_data['tid'],1);
															}
										/****************************************************/
		  		/****************************************************/
		  		//echo $vote;
		  		$upvoted=1;
		  	}
		  	else{
		  		$vote=$voteQues->vote-1;
		  		$update=array("vote"=>$vote);
		  		$voteQues->update($update);
		  		$auth_data=array("uid"=>$user->id,"qid"=>$qid,"down"=>1,"up"=>0);
		  		$auth->insert($auth_data);

		  		/*******************update user reputation**********/
		  		$friend->quesDownVote();

									 /**************update tag score on users**********/
														 $f->sql_query("select * from question_tags where qid=$qid");

														 while($tag_data=$f->load_datas()){
															 $friend->quesScoreOnVote($tag_data['tid'],0);
														 }
									 /****************************************************/
		  		/****************************************************/
		  		//echo $vote;
		  		$downvoted=1;
		  	}
		  	if($upvoted==1){
		  		echo "
		  		<button id=upvote-ques class='vote selected clean-btn glyphicon glyphicon-triangle-top fa-2x'></button>
		        <span>$vote</span>
		        <button id=downvote-ques class='clean-btn vote glyphicon glyphicon-triangle-bottom fa-2x'></button>";
		  	}
		  	elseif($downvoted==1){
		  		echo"
		  		<button id=upvote-ques class='vote clean-btn glyphicon glyphicon-triangle-top fa-2x'></button>
		        <span>$vote</span>
		        <button id=downvote-ques class='selected clean-btn vote glyphicon glyphicon-triangle-bottom fa-2x'></button>";
		  	}
	  }

}

elseif(isset($_POST['aid'])){
	$vote_action=$_POST['vote'];
	$aid = $_POST['aid'];
	$voteAns=new item_class();
	$voteAns->set("answers",$aid);
	$voteAns->load_vars();
  $f=new user_class();

	$auth->sql_query("select * from vote_details where uid=$user->id and aid=$aid");
	$auth_data=$auth->load_datas();
	$auth->set("vote_details",$auth_data['id']);
	$uid=$voteAns->uid;
	$friend->set("users",$uid);
	$friend->load_vars();
	   if($auth->num_rows==1){
			if($vote_action=="upvote"){
				$auth->sql_query("select * from vote_details where uid=$user->id and aid=$aid and down=1");
				if($auth->num_rows==1){
					$vote=$voteAns->vote+1;
					$update=array("vote"=>$vote);
					$voteAns->update($update);
					/*******************update user reputation**********/
					$friend->ansDownVote(1);

										/**************update tag score on users**********/
															$f->sql_query("select * from question_tags where qid=$voteAns->qid");

															while($tag_data=$f->load_datas()){
																$friend->ansScoreOnVote($tag_data['tid'],1);
															}
										/****************************************************/
					/****************************************************/
					$auth->delete();

					echo "
					<button id=upvote-ans class='vote clean-btn glyphicon glyphicon-triangle-top fa-2x'></button>
					<span>$vote</span>
					<button id=downvote-ans class='vote clean-btn glyphicon glyphicon-triangle-bottom fa-2x'></button>";

				}

			}
			else {
				$auth->sql_query("select * from vote_details where uid=$user->id and aid=$aid and up=1");
				if($auth->num_rows==1){

					$vote=$voteAns->vote -1;

					$update=array("vote"=>$vote);
					$voteAns->update($update);
					/*******************update user reputation**********/
					$friend->ansUpVote(1);

										/**************update tag score on users**********/
															$f->sql_query("select * from question_tags where qid=$voteAns->qid");

															while($tag_data=$f->load_datas()){
																$friend->ansScoreOnVote($tag_data['tid'],0);
															}
										/****************************************************/
					/****************************************************/
					$auth->delete();

					echo "
				<button id=upvote-ans class='vote clean-btn glyphicon glyphicon-triangle-top fa-2x'></button>
				<span>$vote</span>
				 <button id=downvote-ans class='vote clean-btn glyphicon glyphicon-triangle-bottom fa-2x'></button>";

				}

		  }
	   }
	   else{
			   	if($vote_action=="upvote"){
			   		$vote=$voteAns->vote+1;
			   		$update=array("vote"=>$vote);
			   		$voteAns->update($update);
			   		$auth_data=array("uid"=>$user->id,"aid"=>$aid,"up"=>1,"down"=>0);
			   		$auth->insert($auth_data);
			   		//echo $vote;
			   		/*******************update user reputation**********/
			   		$friend->ansUpVote();

											/**************update tag score on users**********/
																$f->sql_query("select * from question_tags where qid=$voteAns->qid");

																while($tag_data=$f->load_datas()){
																	$friend->ansScoreOnVote($tag_data['tid'],1);
																}
											/****************************************************/
			   		/****************************************************/
			   		$upvoted=1;
			   	}
			   	else{
			   		$vote=$voteAns->vote-1;
			   		$update=array("vote"=>$vote);
			   		$voteAns->update($update);
			   		$auth_data=array("uid"=>$user->id,"aid"=>$aid,"down"=>1,"up"=>0);
			   		$auth->insert($auth_data);
			   		//echo $vote;
			   		/*******************update user reputation**********/
			   		$friend->ansDownVote();

											/**************update tag score on users**********/
																$f->sql_query("select * from question_tags where qid=$voteAns->qid");

																while($tag_data=$f->load_datas()){
																	$friend->ansScoreOnVote($tag_data['tid'],0);
																}
											/****************************************************/
			   		/****************************************************/
			   		$downvoted=1;
			   	}

			if($upvoted==1){
				echo "
				<button id=upvote-ans class='selected vote clean-btn glyphicon glyphicon-triangle-top fa-2x'></button>
				<span>$vote</span>
				 <button id=downvote-ans class='vote clean-btn glyphicon glyphicon-triangle-bottom fa-2x'></button>";

			}
			elseif($downvoted==1){
				echo "
				<button id=upvote-ans class='vote clean-btn glyphicon glyphicon-triangle-top fa-2x'></button>
				<span>$vote</span>
		       <button id=downvote-ans class='vote selected clean-btn glyphicon glyphicon-triangle-bottom fa-2x'></button>";

			}
	   }
}



  ?>
