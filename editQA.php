<?php require_once 'include/head.php';?>
<script src="include/code-prettify-master/src/run_prettify.js"></script>
<link rel="stylesheet" href="include/code-prettify-master/src/prettify.css">
<script src="include/wysiwyg/wysiwyg.js"></script>
<link rel="stylesheet" href="include/wysiwyg/wysiwyg.css">
 
<?php require_once 'header.php'; 
$filter=new filter_class();
$question=new item_class();
if(isset($_GET['qid']) && isset($_GET['aid'])){
$answer=new item_class();	

	$qid=$_GET['qid'];
	$aid=$_GET['aid'];

	$question->set("questions",$qid);
	$question->load_vars();
	$answer->set("answers",$aid);
	$answer->load_vars();
	$answer->body=$filter->escape($answer->body);
?>


	<div class="container question-answer">
	  <div class="header">
	     <div class="ques-title"><h1><?php echo $question->title;?></h1></div>
	  </div>
	   
			 <div class="col-sm-6 text-left main-question-answer"> 
			   <div class="ques-area">
			     <div class="ques-container">
				      <div class="ques-body">
				         <?php echo $question->body;?>
				      </div>
			     </div>         
			   </div>  			      
                  
            </div>
		       <div class="answer-box">
				 <form action="pEditQA.php" method="post">
				   <h1>Your Answer</h1>
				   <div class="wysiwyg-container ">  
					 <textarea name="myTextArea" id="myTextArea"></textarea>
				   </div>
				   <div id="source"></div>
				   <input type="hidden" name="qid" value="<?php echo $qid;?>">
				   <input type="hidden" name="aid" value="<?php echo $aid;?>">
<script>
$(function(){
$('#richTextField').contents().find('body').html("<?php echo $answer->body;?>");	
});
</script>
				   <button type="submit" name="submit" id="post"class="post-btn">post</button>
                  </form>
                </div>
              
        
		   
	</div>
<?php 
}
elseif(isset($_GET['qid']))
{
	
}

?>
      
      
<?php require_once 'footer.php';?>

          
