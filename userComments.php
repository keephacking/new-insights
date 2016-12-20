		  <?php require_once 'include/lib.php';
		        if(isset($_POST['id'])){
		        	$uid=$_POST['id'];
		        	$comment=new item_class();
		        	$cmt_ans_ques=new item_class();
		  ?>  
					    <div class="activity-contents-container">
						    <?php $comment->sql_query("select * from comments where uid='$uid'");
						          while($cms=$comment->load_datas()){
						          	$ctime=strtotime($cms['time']);
						          	$ctime=date("M j g:ia",$ctime);
						          	?>
						    <div class="activity-contents">
						    
						       <div class="activity-contents-data">
						          <?php if($cms['qid']==null){
						          	    $cmt_ans_ques->sql_query("select * from answers where id='$cms[aid]'");
						                $cmt_data=$cmt_ans_ques->load_datas();
						                $cms['qid']=$cmt_data['qid'];
						          }
						          	?>
						         <div class="activity-cmt"> 
						          <span><a href="question.php?id=<?=$cms['qid'];?>">
						          <?=$cms['body']?></a>
						          </span>
						          <div class="dis-time"><?=$ctime?></div>
						        </div>
						       </div>
						       
					
						    </div>
						    <?php }?>
						  </div>
		<?php }?>