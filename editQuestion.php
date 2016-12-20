<?php require_once 'include/head.php';?>

<script src="include/wysiwyg/wysiwyg.js"></script>
<link rel="stylesheet" href="include/wysiwyg/wysiwyg.css">
<link rel="stylesheet" href="include/tag/bootstrap-tagsinput.css">
<?php require_once 'header.php';
if(isset($_GET['qid'])){
	$filter=new filter_class();
	$qid=$_GET['qid'];
	$question=new item_class();
	$question->sql_query("CALL getQuestionById($qid)");
	$data=$question->load_datas();
	if($question->num_rows==0) die("<h1>Nthng to edit</h1>");
	$body=$filter->escape($data['body']);
}
else die();
?>
<script>
/********************update code*********************/
$(function(){
	$("#post").on({
		click:function(){
	          var qid=$("#qid").val();
	          tags=$("#tag-input-field").val();
	          var title=$("#title").val();
	          var body=$("#myTextArea").val();
	          $.ajax({
                      url:"updateQuestion.php",
                      method:"post",
                      dataType:"json",
                      data:{qid:qid,body:body,title:title,tags:tags},
                      success:function(r){
                              if(r.out=="success"){
                            	  window.location.assign('question.php?id='+qid);
                              }
                          }                    
		          });
			}
	});
})
</script>
<div class="container edit-ques">
<input type="hidden" id="qid" value=<?=$qid?>>
  <h2>Edit Question</h2>
   <form name="q_form" id="q_form" role="form" method="post"> 
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" value='<?=$data['title']?>'>
      </div>
   
    <div class="wysiwyg-container ">  
	 <textarea name="myTextArea" id="myTextArea"></textarea>
   </div>
    <div id="source"></div>		
    <br><br>
 
  <div class="tags-index-container">
		                
	     <div class="related-tags edit-ques">
          <?php if($data['tid1']!=NULL){?>
	       <div class="related-tag">
	                <input type="hidden" id="tid" value='<?=$data['tid1']?>'>
	                <div class="wrap-tag"><?=$data['tag1'];?><span class="delete-ques-tag-btn edit-ques">✖</span></div>						                 						                   
	       </div>
	    <?php }?>
	    <?php if($data['tid2']!=NULL){?>
	       <div class="related-tag"> 
	            <div class="related-tag-details"></div>
                <input type="hidden" id="tid" value='<?=$data['tid2']?>'>					                    
                <div class="wrap-tag"><?=$data['tag2'];?><span class="delete-ques-tag-btn edit-ques">✖</span></div> 
	       </div>
	       <?php }?>
	       <?php if($data['tid3']!=NULL){?>
	       <div class="related-tag">
	       <div class="related-tag-details "></div>
                <input type="hidden" id="tid" value='<?=$data['tid3']?>'>
                <div class="wrap-tag"><?=$data['tag3'];?><span class="delete-ques-tag-btn edit-ques">✖</span></div>   
	       </div>
	       <?php }?>
	       <?php if($data['tid4']!=NULL){?>
	       <div class="related-tag">
	       <div class="related-tag-details"></div>
                <input type="hidden" id="tid" value='<?=$data['tid4']?>'>
                <div class="wrap-tag"><?=$data['tag4'];?><span class="delete-ques-tag-btn edit-ques">✖</span></div>  
	       </div>
	       <?php }?>
	       <?php if($data['tid5']!=NULL){?>
	       <div class="related-tag">
	        <div class="related-tag-details"></div>
                <input type="hidden" id="tid" value='<?=$data['tid5']?>'>
                <div class="wrap-tag"><?=$data['tag5'];?><span class="delete-ques-tag-btn edit-ques">✖</span></div>  
	       </div>
	       <?php }?>
       </div>								     
   </div>
    
    <div class="form-group tag-input" style="clear:both;">
      <label for="tags">Tags:</label>
      <select multiple data-role="tagsinput" class='form-control' id="tag-input-field" name='tags[]'></select>
      <div class="tag-sug-container"></div>
    </div>  
    <button type="button" id="post" class="post-btn" name="submit">Post</button>
  </form>


</div>
<script src="include/tag/bootstrap-tagsinput.js"></script>
<script>
 $(function(){
   $(".tag-input").on("keyup",function(e){
	     
           var tag=$(".tag-input input[type='text']").val();
            if($.trim(tag)!=""){
             $.ajax({
                  url:"tagSuggest.php",
				  method:"post",
				  data:{tag:tag},
				  success:function(response){
                       $(".tag-sug-container").html(response);
					  }
                });
            }
            else $(".tag-sug-container").html("");
            
	      
	   });
  
   
	 });

 $(".tag-sug-container").on({
    
    mouseleave:function(){$(this).find(".mask-suggested-tag").hide();},
    mouseover:function(){$(this).find(".mask-suggested-tag").show();},
    click:function()
     { 
        var tag=$.trim($(this).find(".suggested-item-name").html());
        $(".tag-input input[type='text']").val(tag);

		        var e = jQuery.Event("keypress");
		        e.which = 13; 
		        $(".tag-input input[type='text']").trigger(e);
        
        },
	 },".suggested-item");

	 $(function(){
		 //alert("hii");
		 if($("richTextField")){
	 field = document.getElementById("richTextField");
	 field.contentDocument.designMode = "On";
		 }
	 });

	 /****************adding body to the iframe***************/
$(function(){
$('#richTextField').contents().find('body').html("<?php echo $body;?>");	
});
	 /****************delete existing tags*******************/
	 $(".container .edit-ques").on({
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
</script>
<?php require_once 'footer.php';?>
