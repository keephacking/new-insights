		<?php require_once 'include/lib.php';
		if(isset($_POST['id'])){
			$uid=$_POST['id'];
		
		$answers=new item_class();
		$answered_ques=new item_class();
		?>
					      <div class="activity-contents-container">
						    <?php $answers->sql_query("select * from answers where uid='$uid'");
						          while($ans=$answers->load_datas()){
						          	$atime=strtotime($ans['date_created']);
						          	$atime=date("M j g:ia",$atime);
						          	?>
						    <div class="activity-contents">
						    
						       <div class="activity-contents-data">
						        <div class="activity-ans-ques">
                                   <span>
						          <?php $answered_ques->sql_query("select * from questions where id='$ans[qid]'");
						                while($ans_ques=$answered_ques->load_datas()){echo $ans_ques['title'];}?>
						            </span>
						        </div> 
						        <div class="activity-ans-body"> 
				   
						          <a href="question.php?id=<?=$ans['qid']?>"><?=$ans['body']?></a>
						        </div>
						       </div>
						       
						       <div class="dis-time"><?=$atime?></div>
						       
						    </div>
						    <?php }?>
						  </div>
      <?php }?>