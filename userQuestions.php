<?php require_once 'include/lib.php';
if(isset($_POST['id'])){
	$uid=$_POST['id'];
?>
<div class="activity-contents-container">
<?php 
$questions=new item_class();
$questions->sql_query("select * from questions where owner_id='$uid'");

while($ques=$questions->load_datas()){
	$qtime=strtotime($ques['creation_date']);
	$qtime=date("M j g:ia",$qtime);
	if(strlen($ques['title'])>60)
	{
		$quesbody=substr($ques['title'],0,60);
		$quesbody.="...";
	}
	else $quesbody=$ques['title'];?>

						    <div class="activity-contents">
						       <div class="count-box">
						         <span class="count-box-item"><?=$ques['answer_count']?></span>
						         <span class="count-box-details">answer</span>
						       </div>
						       <div class="activity-contents-data">
						          <a href="question.php?id=<?php echo $ques['id']?>"><?=$quesbody?></a>
						       </div>
						       <div class="dis-time"><?=$qtime?></div>
                              
						       
						    </div>
						    <?php }?>
						  </div>
<?php }?>