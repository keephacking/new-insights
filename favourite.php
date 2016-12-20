<?php require 'include/head.php';?>

<?php require 'header.php';
$fav=new item_class();
$fav->set("favourite_question");
$ques=new item_class();
$ques->set("questions");
?>
<div class="fav-wrapper" >
      <div class="fav-container">
		    <?php $fav->sql_query("select * from favourite_question where uid='$user->id'");
		        if($fav->num_rows){  
		          while($favs_data=$fav->load_datas()){
		             $ques->sql_query("select * from questions where id='$favs_data[qid]'");
		             $ques_data=$ques->load_datas();
		             $time=strtotime($ques_data['creation_date']);
		             $time=date("M j g:ia",$time);
		          ?>
		    <div class="fav-item">
		       <div class="fav-item-chara">
		           <div class="fav-item-chara1">
		           <span class="fav-chara-body"><?=$ques_data['answer_count']?></span>
		           <span class="fav-chara-detail">answer</span>
		           </div>
		       </div>
		       <div class="fav-item-body">
		          <a href="question.php?id=<?php echo $ques_data['id']?>"><?php echo $ques_data['title']?></a>
		       </div>
		       <div class="fav-item-time">
		         <?=$time?>
		       </div>
		    </div>
		    <?php }}
		    else die("<h1>No Favourite list .</h1>");
		    ?>
	  </div>
</div>
<?php require 'footer.php';?>